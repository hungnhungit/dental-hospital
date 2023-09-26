import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import PageContainer from "@/Components/PageContainer";
import { Head } from "@inertiajs/react";

export default function NewUser(props) {
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight uppercase">
                    Thêm mới tài khoản
                </h2>
            }
        >
            <Head title="Thêm mới tài khoản" />

            <PageContainer></PageContainer>
        </AuthenticatedLayout>
    );
}
