import PageContainer from "@/Components/PageContainer";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { formatNumber } from "@/Utils/helpers";
import { Head } from "@inertiajs/react";
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend,
} from "chart.js";
import { Bar } from "react-chartjs-2";

ChartJS.register(
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend
);

export const options = {
    responsive: true,
    plugins: {
        legend: {
            position: "top",
        },
        title: {
            display: true,
            text: "Doanh thu năm",
        },
        tooltip: {
            callbacks: {
                label: (context) => {
                    const {
                        dataIndex,
                        dataset: { data },
                    } = context;

                    return formatNumber(data[dataIndex]);
                },
                title: (context) => {
                    const {
                        dataset: { label },
                    } = context[0];
                    return label;
                },
            },
        },
    },
};

const labels = Array(12)
    .fill("")
    .map((_, index) => {
        return `Tháng ${index + 1}`;
    });

export default function ListRevenue(props) {
    const { months, today } = props;
    const data = {
        labels,
        datasets: [
            {
                label: "Tháng",
                data: months,
                backgroundColor: "rgba(17, 105, 46, 0.5)",
            },
            {
                label: "Ngày",
                data: today,
                backgroundColor: "rgba(199, 36, 109, 0.5)",
            },
        ],
    };

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
                    <Bar options={options} data={data} />
                </div>
            </PageContainer>
        </AuthenticatedLayout>
    );
}
