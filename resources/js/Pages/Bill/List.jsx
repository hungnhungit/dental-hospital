import InputSearch from "@/Components/InputSearch";
import PageContainer from "@/Components/PageContainer";
import Pagination from "@/Components/Pagination";
import Table from "@/Components/Table";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { request } from "@/Utils/request";
import { getRouter } from "@/Utils/router";
import { Head, Link } from "@inertiajs/react";
import _get from "lodash/get";
import qs from "query-string";
import { useState } from "react";
import useCols from "./Cols";

export default function ListBill(props) {
    const { page, sortCols, sortType } = qs.parse(location.search);
    const [sorting, setSorting] = useState([
        {
            id: sortCols,
            desc: sortType === "desc",
        },
    ]);
    const [currentPage, setCurrentPage] = useState(Number(page || 1));
    const [filter, setFilter] = useState("today");
    const cols = useCols({
        handlePrint: async (id) => {
            const res = await request.post(
                route("hoadon.pdf", id),
                {},
                { responseType: "blob" }
            );
            let blob = new Blob([res], {
                type: "application/pdf",
            });
            let link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = "hoadon.pdf";
            link.click();
        },
    });
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <div className="flex justify-between">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight uppercase">
                        Quản lý hoá đơn
                    </h2>
                    <Link
                        className="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
                        href={route("hoadon.create")}
                    >
                        Thêm mới
                    </Link>
                </div>
            }
        >
            <Head title="QL tài khoản" />

            <PageContainer>
                <div className="flex gap-3">
                    <InputSearch
                        placeholder="tên"
                        onSearch={(query) => {
                            getRouter({ q: query, page: 1 });
                            setCurrentPage(1);
                        }}
                    />
                    <div className="w-[150px]">
                        <select
                            value={filter}
                            onChange={(e) => {
                                getRouter({ filter: e.target.value, page: 1 });
                                setFilter(e.target.value);
                                setCurrentPage(1);
                            }}
                            className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        >
                            <option key="today" value="today">
                                Hôm nay
                            </option>
                            <option key="month" value="month">
                                Tháng này
                            </option>
                            <option key="precious" value="precious">
                                Quý này
                            </option>
                        </select>
                    </div>
                </div>
                <Table
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
                    sorting={sorting}
                    data={_get(props, "bills", [])}
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
