import PageContainer from "@/Components/PageContainer";
import Pagination from "@/Components/Pagination";
import PrimaryButton from "@/Components/PrimaryButton";
import Table from "@/Components/Table";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { getRecordsText } from "@/Utils/helpers";
import { Head, Link, router } from "@inertiajs/react";
import _get from "lodash/get";
import qs from "query-string";
import { useState } from "react";
import { toast } from "react-toastify";
import useColsProcess from "./ColsProcess";

export default function DetailHealthRecords(props) {
    const { records } = props;
    const { page } = qs.parse(location.search);
    console.log(records);
    const [currentPage, setCurrentPage] = useState(Number(page || 1));
    const handleChangeStatus = (status) => {
        router.post(route("sokhambenh.changeStatus", records.id), { status });
    };
    const cols = useColsProcess({
        handleDelete: (id) => {
            console.log(id);
            router.delete(route("tientrinhdieutri.destroy", id));
            toast.success("Xoá tiến trình điểu trị thành công !");
        },
        handleEdit: (id) => {
            router.visit(route("tientrinhdieutri.edit", [records.id, id]));
        },
    });

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <div className="flex justify-between">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight uppercase">
                        chi tiết sổ khám bệnh
                    </h2>
                    <Link
                        className="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
                        href={route("sokhambenh.index")}
                    >
                        Danh sách sổ khám bệnh
                    </Link>
                </div>
            }
        >
            <Head title="Chi tiết sổ khám bệnh" />

            <PageContainer>
                <div className="flex flex-col gap-4">
                    <div className="text-lg">
                        <span className="font-bold">Bệnh nhân: </span>
                        {records.BenhNhan}
                    </div>
                    <div>
                        <span className="font-bold">Bác sĩ: </span>

                        {records.BacSi}
                    </div>
                    <div>
                        <span className="font-bold">Chuẩn đoán bệnh: </span>
                        {records.ChanDoanBenh}
                    </div>
                    <div>
                        <span className="font-bold">Trạng thái: </span>
                        {getRecordsText(records.TrangThai)}
                    </div>
                    <div className="flex gap-3">
                        {records.TrangThai !== "DangDieutri" ? (
                            <PrimaryButton
                                onClick={() =>
                                    handleChangeStatus("DangDieutri")
                                }
                            >
                                Điều trị
                            </PrimaryButton>
                        ) : null}
                        {records.TrangThai === "Huy" ? null : (
                            <PrimaryButton
                                onClick={() => handleChangeStatus("Huy")}
                                className="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300"
                            >
                                Huỷ bỏ
                            </PrimaryButton>
                        )}
                    </div>
                </div>
                {records.TrangThai === "DangDieutri" ? (
                    <>
                        <div className="mt-10 mb-5 flex justify-between">
                            <h1 className="text-3xl font-bold">
                                Tiến trình điều trị
                            </h1>
                            <Link
                                className="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
                                href={route(
                                    "tientrinhdieutri.create",
                                    records["id"]
                                )}
                            >
                                Thêm mới
                            </Link>
                        </div>
                        <Table
                            data={_get(props, "process", [])}
                            columns={cols}
                        />
                        <Pagination
                            totalCount={_get(props, "totalPage")}
                            currentPage={currentPage}
                            onPageChange={(page) => {
                                setCurrentPage(page);
                                router.get(
                                    route(route().current()),
                                    { page, query },
                                    {
                                        preserveState: true,
                                        replace: true,
                                    }
                                );
                            }}
                        />
                    </>
                ) : null}
            </PageContainer>
        </AuthenticatedLayout>
    );
}
