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
            },
        },
    },
};

function randomIntFromInterval(min, max) {
    // min and max included
    return Math.floor(Math.random() * (max - min + 1) + min);
}

const labels = Array(12)
    .fill("")
    .map((_, index) => {
        return `Tháng ${index + 1}`;
    });

export const data = {
    labels,
    datasets: [
        {
            label: "VND",
            data: labels.map(() => randomIntFromInterval(1000000, 100000000)),
            backgroundColor: "rgba(17, 105, 46, 0.5)",
        },
    ],
};

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
                    <Bar options={options} data={data} />
                </div>
            </PageContainer>
        </AuthenticatedLayout>
    );
}
