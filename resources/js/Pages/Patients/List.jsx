import { paginate } from "@/Api/patients.api";
import PageContainer from "@/Components/PageContainer";
import Table from "@/Components/Table";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link } from "@inertiajs/react";
import _get from "lodash/get";
import { useAsync } from "react-use";
import useCols from "./Cols";

export default function ListPatients(props) {
    const cols = useCols();
    const { value: res, loading } = useAsync(async () => {
        return await paginate();
    }, []);
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <div className="flex justify-between">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight uppercase">
                        Quản lý bệnh nhân
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
            <Head title="Quản lý bệnh nhân" />

            <PageContainer>
                <Table data={_get(res, "patients", [])} columns={cols} />
            </PageContainer>
        </AuthenticatedLayout>
    );
}
