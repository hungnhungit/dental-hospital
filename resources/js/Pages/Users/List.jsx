import PageContainer from "@/Components/PageContainer";
import Pagination from "@/Components/Pagination";
import Table from "@/Components/Table";
import TextInput from "@/Components/TextInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import _get from "lodash/get";
import qs from "query-string";
import { useState } from "react";
import { toast } from "react-toastify";
import useCols from "./Cols";

export default function ListUser(props) {
    const { account, page } = qs.parse(location.search);
    const [currentPage, setCurrentPage] = useState(Number(page || 1));
    const [query, setQuery] = useState(account || "");
    const cols = useCols({
        handleDelete: (id) => {
            router.delete(route("taikhoan.destroy", id));
            toast.success("Xoá tài khoản thành công !");
        },
        handleEdit: (id) => {
            router.visit(route("taikhoan.edit", id));
        },
    });
    const search = (event) => {
        if (event.key == "Enter") {
            router.get(
                route(route().current()),
                { page: 1, account: query },
                {
                    preserveState: true,
                    replace: true,
                }
            );
        }
    };

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <div className="flex justify-between">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight uppercase">
                        tài khoản
                    </h2>
                    <Link
                        className="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
                        href={route("taikhoan.create")}
                    >
                        Thêm mới
                    </Link>
                </div>
            }
        >
            <Head title="QL tài khoản" />

            <PageContainer>
                <TextInput
                    className="mb-4 w-[400px]"
                    placeholder="Tìm kiếm theo tài khoản"
                    value={query}
                    onChange={(e) => setQuery(e.target.value)}
                    onKeyPress={search}
                />
                <Table data={_get(props, "users", [])} columns={cols} />
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
