import PageContainer from "@/Components/PageContainer";
import SecondaryButton from "@/Components/SecondaryButton";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { formatNumber } from "@/Utils/helpers";
import { request } from "@/Utils/request";
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
import { map } from "lodash";
import { useMemo, useState } from "react";
import { Bar } from "react-chartjs-2";
import ReactDatePicker from "react-datepicker";
import { toast } from "react-toastify";
import { format } from "date-fns";

ChartJS.register(
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend
);

function randomBgColor() {
    const x = Math.floor(Math.random() * 256);
    const y = Math.floor(Math.random() * 256);
    const z = Math.floor(Math.random() * 256);
    return "rgb(" + x + "," + y + "," + z + ")";
}

export const options1 = {
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

export const options2 = {
    responsive: true,
    plugins: {
        legend: {
            position: "top",
        },
        title: {
            display: true,
            text: "Dịch vụ sử dụng",
        },
    },
};

const labels = Array(12)
    .fill("")
    .map((_, index) => {
        return `Tháng ${index + 1}`;
    });

export default function ListRevenue(props) {
    const { months, today, servicesLabel } = props;
    const [startDate, setStartDate] = useState(null);
    const [endDate, setEndDate] = useState(null);
    const onChange = (dates) => {
        const [start, end] = dates;
        setStartDate(start);
        setEndDate(end);
    };
    const data1 = {
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

    const data2 = useMemo(() => {
        return {
            labels,
            datasets: map(servicesLabel, (item) => {
                return {
                    label: item.name,
                    data: item.data,
                    backgroundColor: randomBgColor(),
                };
            }),
        };
    }, [servicesLabel]);

    const handlePrint = async (kind) => {
        const res = await request.post(
            route(`${kind}.pdf`),
            {},
            { responseType: "blob" }
        );
        let blob = new Blob([res], {
            type: "application/pdf",
        });
        let link = document.createElement("a");
        link.href = window.URL.createObjectURL(blob);
        link.download = "doanhthu.pdf";
        link.click();
    };

    const handlePrintRangeDate = async () => {
        if (!startDate && !endDate) {
            toast.warn("Chưa chọn khoảng thời gian !");
            return;
        }
        const res = await request.post(
            route(`doanhthukhoangngay.pdf`),
            {
                start: format(startDate, "yyyy-MM-dd"),
                end: format(endDate, "yyyy-MM-dd"),
            },
            { responseType: "blob" }
        );
        let blob = new Blob([res], {
            type: "application/pdf",
        });
        let link = document.createElement("a");
        link.href = window.URL.createObjectURL(blob);
        link.download = "doanhthukhoangngay.pdf";
        link.click();
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
                    <div className="flex gap-5">
                        <ReactDatePicker
                            locale="vi"
                            placeholderText="Ngày bắt đầu - Ngày kết thúc"
                            selected={startDate}
                            onChange={onChange}
                            startDate={startDate}
                            endDate={endDate}
                            selectsRange
                            className="w-[220px] bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2.5"
                        />
                        <SecondaryButton onClick={() => handlePrintRangeDate()}>
                            In doanh theo khoảng ngày
                        </SecondaryButton>
                        <SecondaryButton
                            onClick={() => handlePrint("doanhthutoday")}
                        >
                            In doanh thu ngày
                        </SecondaryButton>
                        <SecondaryButton
                            onClick={() => handlePrint("doanhthumonth")}
                        >
                            In doanh thu tháng
                        </SecondaryButton>
                        <SecondaryButton
                            onClick={() => handlePrint("doanhthuyear")}
                        >
                            In doanh thu năm
                        </SecondaryButton>
                    </div>
                </div>
            }
        >
            <Head title="Doanh thu" />

            <PageContainer>
                <div className="flex flex-col gap-10">
                    <Bar options={options1} data={data1} />

                    <Bar options={options2} data={data2} />
                </div>
            </PageContainer>
        </AuthenticatedLayout>
    );
}
