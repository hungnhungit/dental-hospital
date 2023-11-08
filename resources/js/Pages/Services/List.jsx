import InputSearch from "@/Components/InputSearch";
import PageContainer from "@/Components/PageContainer";
import Pagination from "@/Components/Pagination";
import Table from "@/Components/Table";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { getRouter } from "@/Utils/router";
import { Head, Link, router } from "@inertiajs/react";
import _get from "lodash/get";
import qs from "query-string";
import { useState } from "react";
import { toast } from "react-toastify";
import useCols from "./Cols";

export default function ListServices(props) {
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
            router.delete(route("dichvu.destroy", id));
            toast.success("Xoá dịch vụ thành công !");
        },
        handleEdit: (id) => {
            router.visit(route("dichvu.edit", id));
        },
    });
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <div className="flex justify-between">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight uppercase">
                        Quản lý dịch vụ
                    </h2>
                    <Link
                        className="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
                        href={route("dichvu.create")}
                    >
                        Thêm mới
                    </Link>
                </div>
            }
        >
            <Head title="QL dịch vụ" />

            <PageContainer>
                <InputSearch
                    placeholder="tên"
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
                    data={_get(props, "services", [])}
                    columns={cols}
                />
                <Pagination
                    totalCount={_get(props, "totalPage")}
                    currentPage={currentPage}
                    pageSize={10}
                    onPageChange={(page) => {
                        getRouter({ page });
                        setCurrentPage(page);
                    }}
                />
            </PageContainer>
        </AuthenticatedLayout>
    );
}
