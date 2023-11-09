import PageContainer from "@/Components/PageContainer";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { formatNumber } from "@/Utils/helpers";
import { Head } from "@inertiajs/react";

export default function ListRevenue(props) {
    const { today, month, year } = props;
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <div className="flex justify-between">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight uppercase">
                        doanh thu
                    </h2>
                </div>
            }
        >
            <Head title="Doanh thu" />

            <PageContainer>
                <div className="flex flex-col gap-10">
                    <p className="font-semibold">
                        Hôm nay: {formatNumber(today)}
                    </p>
                    <p className="font-semibold">
                        Tháng này: {formatNumber(month)}
                    </p>
                    <p className="font-semibold">
                        Quý này: {formatNumber(year)}
                    </p>
                </div>
            </PageContainer>
        </AuthenticatedLayout>
    );
}
