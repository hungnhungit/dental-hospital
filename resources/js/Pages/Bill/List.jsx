import InputControl from "@/Components/InputControl";
import InputSearch from "@/Components/InputSearch";
import PageContainer from "@/Components/PageContainer";
import Pagination from "@/Components/Pagination";
import SecondaryButton from "@/Components/SecondaryButton";
import Table from "@/Components/Table";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { request } from "@/Utils/request";
import { getRouter } from "@/Utils/router";
import { Head, Link, router } from "@inertiajs/react";
import _get from "lodash/get";
import qs from "query-string";
import { useState } from "react";
import ReactDatePicker from "react-datepicker";
import { toast } from "react-toastify";
import useCols from "./Cols";
import { format } from "date-fns";

export default function ListBill(props) {
    const { page, sortCols, sortType, f, start, end } = qs.parse(
        location.search
    );
    const [sorting, setSorting] = useState([
        {
            id: sortCols,
            desc: sortType === "desc",
        },
    ]);
    const [filter, setFilter] = useState(f);
    const [startDate, setStartDate] = useState(
        isNaN(Date.parse(start)) ? null : new Date(start)
    );
    const [endDate, setEndDate] = useState(
        isNaN(Date.parse(end)) ? null : new Date(end)
    );
    const [currentPage, setCurrentPage] = useState(Number(page || 1));

    const onChange = (dates) => {
        const [start, end] = dates;
        setStartDate(start);
        setEndDate(end);

        getRouter({
            start: format(start, "yyyy-MM-dd"),
            end: format(end, "yyyy-MM-dd"),
        });
    };
    const cols = useCols({
        handlePay: (id) => {
            router.post(
                route("hoadon.pay", id),
                {},
                {
                    onSuccess: () => {
                        toast.success("Thanh toán thành công !");
                    },
                }
            );
        },
        handleDelete: (id) => {
            router.delete(route("hoadon.destroy", id));
            toast.success("Xoá hoá đơn thành công !");
        },
        handlePrint: async (id) => {
            const res = await request.post(
                route("hoadon.pdf", id),
                {},
                { responseType: "blob" }
            );
            let blob = new Blob([res], {
                type: "application/pdf",
            });
            let link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = "hoadon.pdf";
            link.click();
        },
    });
    const handlePrint = async () => {
        const res = await request.post(
            route("hoadon.pdfList"),
            route().params,
            {
                responseType: "blob",
            }
        );
        let blob = new Blob([res], {
            type: "application/pdf",
        });
        let link = document.createElement("a");
        link.href = window.URL.createObjectURL(blob);
        link.download = "danhsachhoadon.pdf";
        link.click();
    };
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <div className="flex justify-between">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight uppercase">
                        Quản lý hoá đơn
                    </h2>
                    <div className="flex gap-5">
                        <Link
                            className="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
                            href={route("hoadon.create")}
                        >
                            Thêm mới
                        </Link>
                        <SecondaryButton onClick={handlePrint}>
                            In danh sách
                        </SecondaryButton>
                    </div>
                </div>
            }
        >
            <Head title="QL hoá đơn" />

            <PageContainer>
                <div className="flex gap-5">
                    <InputSearch
                        placeholder="tên"
                        onSearch={(query) => {
                            getRouter({ q: query, page: 1 });
                            setCurrentPage(1);
                        }}
                    />
                    <select
                        value={filter}
                        onChange={(e) => {
                            setFilter(e.target.value);
                            getRouter({ f: e.target.value });
                        }}
                        className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block"
                    >
                        <option key="tatca" value="">
                            Tất cả
                        </option>
                        <option key="thanhtoan" value="DaThanhToan">
                            Đã thanh toán
                        </option>
                        <option key="chuathanhtoan" value="ChuaThanhToan">
                            Chưa thanh toán
                        </option>
                    </select>

                    <ReactDatePicker
                        locale="vi"
                        placeholderText="Ngày bắt đầu - Ngày kết thúc"
                        selected={startDate}
                        onChange={onChange}
                        startDate={startDate}
                        endDate={endDate}
                        selectsRange
                        className="w-[250px] bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5"
                    />
                </div>
                <Table
                    setSorting={(e) => {
                        const sorts = e(sorting);
                        setSorting(sorts);
                        getRouter({
                            sortCols: sorts[0]?.id,
                            sortType: sorts[0]
                                ? sorts[0]?.desc
                                    ? "desc"
                                    : "asc"
                                : undefined,
                        });
                    }}
                    sorting={sorting}
                    data={_get(props, "bills", [])}
                    columns={cols}
                />
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
