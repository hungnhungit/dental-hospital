import PageContainer from "@/Components/PageContainer";
import Table from "@/Components/Table";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import _get from "lodash/get";
import { toast } from "react-toastify";
import useCols from "./Cols";

export default function ListUnit(props) {
    const cols = useCols({
        handleDelete: (id) => {
            router.delete(route("donvitinh.destroy", id));
            toast.success("Xoá đơn vị tính thành công !");
        },
        handleEdit: (id) => {
            router.visit(route("donvitinh.edit", id));
        },
    });
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <div className="flex justify-between">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight uppercase">
                        đơn vị tính
                    </h2>
                    <Link
                        className="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
                        href={route("donvitinh.create")}
                    >
                        Thêm mới
                    </Link>
                </div>
            }
        >
            <Head title="QL đơn vị tính" />

            <PageContainer>
                <Table data={_get(props, "units", [])} columns={cols} />
            </PageContainer>
        </AuthenticatedLayout>
    );
}
