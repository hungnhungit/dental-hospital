import PageContainer from "@/Components/PageContainer";
import Table from "@/Components/Table";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import _get from "lodash/get";
import useCols from "./Cols";

export default function ListKindSupplies(props) {
    console.log(props);
    const cols = useCols({
        handleDelete: (id) => {
            router.delete(route("loai-vat-tu.destroy", id));
            toast.success("Xoá loại vật tư thành công !");
        },
        handleEdit: (id) => {
            console.log(id);
            router.visit(route("loai-vat-tu.edit", id));
        },
    });
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <div className="flex justify-between">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight uppercase">
                        Loại vật tư
                    </h2>
                    <Link
                        className="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
                        href={route("loai-vat-tu.create")}
                    >
                        Thêm mới
                    </Link>
                </div>
            }
        >
            <Head title="Loại vật tư" />

            <PageContainer>
                <Table data={_get(props, "supplies", [])} columns={cols} />
            </PageContainer>
        </AuthenticatedLayout>
    );
}
