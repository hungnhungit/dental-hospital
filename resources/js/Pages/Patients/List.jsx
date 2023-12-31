import InputSearch from "@/Components/InputSearch";
import PageContainer from "@/Components/PageContainer";
import Pagination from "@/Components/Pagination";
import SecondaryButton from "@/Components/SecondaryButton";
import Table from "@/Components/Table";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { request } from "@/Utils/request";
import { getRouter } from "@/Utils/router";
import { Head, Link, router } from "@inertiajs/react";
import _get from "lodash/get";
import qs from "query-string";
import { useState } from "react";
import { toast } from "react-toastify";
import useCols from "./Cols";

export default function ListPatients(props) {
    const { page, sortCols, sortType } = qs.parse(location.search);
    const [sorting, setSorting] = useState([
        {
            id: sortCols,
            desc: sortType === "desc",
        },
    ]);
    const [currentPage, setCurrentPage] = useState(Number(page || 1));
    const cols = useCols({
        handleDelete: (id) => {
            router.delete(route("benhnhan.destroy", id), {
                onSuccess: () => {
                    toast.success("Xoá bệnh nhân thành công !");
                },
            });
        },
        handleEdit: (id) => {
            router.visit(route("benhnhan.edit", id));
        },
    });

    const handlePrint = async () => {
        const res = await request.post(
            route("benhnhan.pdf"),
            {
                ...route().params,
            },
            { responseType: "blob" }
        );
        let blob = new Blob([res], {
            type: "application/pdf",
        });
        let link = document.createElement("a");
        link.href = window.URL.createObjectURL(blob);
        link.download = "benhnhan.pdf";
        link.click();
    };
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <div className="flex justify-between">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight uppercase">
                        bệnh nhân
                    </h2>
                    <div className="flex gap-5">
                        <Link
                            className="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
                            href={route("benhnhan.create")}
                        >
                            Thêm mới
                        </Link>
                        <SecondaryButton onClick={handlePrint}>
                            In danh sách
                        </SecondaryButton>
                    </div>
                </div>
            }
        >
            <Head title="Quản lý bệnh nhân" />

            <PageContainer>
                <InputSearch
                    placeholder="tên, cccd"
                    onSearch={(query) => {
                        getRouter({ q: query, page: 1 });
                        setCurrentPage(1);
                    }}
                />
                <Table
                    sorting={sorting}
                    setSorting={(e) => {
                        const sorts = e(sorting);
                        setSorting(sorts);
                        getRouter({
                            sortCols: sorts[0]?.id,
                            sortType: sorts[0]
                                ? sorts[0]?.desc
                                    ? "desc"
                                    : "asc"
                                : undefined,
                        });
                    }}
                    data={_get(props, "patients", [])}
                    columns={cols}
                />
                <Pagination
                    totalCount={_get(props, "totalPage")}
                    currentPage={currentPage}
                    onPageChange={(page) => {
                        getRouter({ page });
                        setCurrentPage(page);
                    }}
                />
            </PageContainer>
        </AuthenticatedLayout>
    );
}
