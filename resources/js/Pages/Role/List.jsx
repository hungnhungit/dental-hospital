import PageContainer from "@/Components/PageContainer";
import Table from "@/Components/Table";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import _get from "lodash/get";
import useCols from "./Cols";

export default function ListRole(props) {
    const cols = useCols();
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <div className="flex justify-between">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight uppercase">
                        Phân quyền
                    </h2>
                </div>
            }
        >
            <Head title="Phân quyền" />

            <PageContainer>
                <Table data={_get(props, "roles", [])} columns={cols} />
            </PageContainer>
        </AuthenticatedLayout>
    );
}
