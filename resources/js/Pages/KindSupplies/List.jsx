import PageContainer from "@/Components/PageContainer";
import Table from "@/Components/Table";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link } from "@inertiajs/react";
import _get from "lodash/get";
import useCols from "./Cols";

export default function ListKindSupplies(props) {
    const cols = useCols();
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <div className="flex justify-between">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight uppercase">
                        Loại vật tư
                    </h2>
                    <Link className="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase">
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
