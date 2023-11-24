import PageContainer from "@/Components/PageContainer";
import Pagination from "@/Components/Pagination";
import Table from "@/Components/Table";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { getRouter } from "@/Utils/router";
import { Head } from "@inertiajs/react";
import _get from "lodash/get";
import qs from "query-string";
import { useState } from "react";
import useCols from "./Cols";
import ReactDatePicker from "react-datepicker";
import { format } from "date-fns";

export default function ListProccess(props) {
    const { page, start, end } = qs.parse(location.search);
    const [currentPage, setCurrentPage] = useState(Number(page || 1));
    const [startDate, setStartDate] = useState(
        isNaN(Date.parse(start)) ? null : new Date(start)
    );
    const [endDate, setEndDate] = useState(
        isNaN(Date.parse(end)) ? null : new Date(end)
    );
    const cols = useCols();

    const onChange = (dates) => {
        const [start, end] = dates;
        setStartDate(start);
        setEndDate(end);
        if (start && end) {
            getRouter({
                start: format(start, "yyyy-MM-dd"),
                end: format(end, "yyyy-MM-dd"),
            });
        }

        if (!start && !end) {
            getRouter({
                start: undefined,
                end: undefined,
            });
        }
    };

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <div className="flex justify-between">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight uppercase">
                        Lịch sử khám bệnh
                    </h2>
                </div>
            }
        >
            <Head title="Quản lý lịch sử khám bệnh" />

            <PageContainer>
                <ReactDatePicker
                    locale="vi"
                    placeholderText="Ngày điều trị bắt đầu - Ngày điều trị kết thúc"
                    selected={startDate}
                    onChange={onChange}
                    startDate={startDate}
                    endDate={endDate}
                    selectsRange
                    className="w-[350px] bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5"
                />
                <Table data={_get(props, "proccess", [])} columns={cols} />
                <Pagination
                    totalCount={_get(props, "totalPage")}
                    currentPage={currentPage}
                    onPageChange={(page) => {
                        getRouter({ page });
                        setCurrentPage(page);
                    }}
                />
            </PageContainer>
        </AuthenticatedLayout>
    );
}
