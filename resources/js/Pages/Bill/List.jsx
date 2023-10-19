import PageContainer from "@/Components/PageContainer";
import Pagination from "@/Components/Pagination";
import Table from "@/Components/Table";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link } from "@inertiajs/react";
import _get from "lodash/get";
import qs from "query-string";
import { useState } from "react";
import useCols from "./Cols";

export default function ListBill(props) {
    const { page } = qs.parse(location.search);
    const [currentPage, setCurrentPage] = useState(Number(page || 1));
    const cols = useCols();
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
                        href={route("users.new")}
                    >
                        Thêm mới
                    </Link>
                </div>
            }
        >
            <Head title="QL tài khoản" />

            <PageContainer>
                <Table data={_get(props, "bills", [])} columns={cols} />
                <Pagination
                    totalCount={_get(props, "totalPage")}
                    currentPage={currentPage}
                    onPageChange={(page) => {
                        setCurrentPage(page);
                        router.get(
                            route(route().current()),
                            { page, query },
                            {
                                preserveState: true,
                                replace: true,
                            }
                        );
                    }}
                />
            </PageContainer>
        </AuthenticatedLayout>
    );
}