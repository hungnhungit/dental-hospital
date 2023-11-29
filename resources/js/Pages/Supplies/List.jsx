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
import { toast } from "react-toastify";
import useCols from "./Cols";
import PrimaryButton from "@/Components/PrimaryButton";
import Dialog from "rc-dialog";
import { useForm } from "react-hook-form";
import InputLabel from "@/Components/InputLabel";
import InputControl from "@/Components/InputControl";
import { format } from "date-fns";
import useColsHistory from "./ColsHistory";

export default function ListSupplies(props) {
    const { page, sortCols, sortType, f } = qs.parse(location.search);
    const [sorting, setSorting] = useState([
        {
            id: sortCols,
            desc: sortType === "desc",
        },
    ]);
    const [filter, setFilter] = useState(f);
    const [openModal, setOpenModal] = useState(false);
    const [currentPage, setCurrentPage] = useState(Number(page || 1));
    const { register, control, handleSubmit, reset } = useForm();
    const colsHistory = useColsHistory();
    const cols = useCols({
        handleDelete: (id) => {
            router.delete(route("vat-tu.destroy", id));
            toast.success("Xoá vật tư thành công !");
        },
        handleEdit: (id) => {
            router.visit(route("vat-tu.edit", id));
        },
    });
    const handlePrint = async () => {
        const res = await request.post(route("vat-tu.pdf"), route().params, {
            responseType: "blob",
        });
        let blob = new Blob([res], {
            type: "application/pdf",
        });
        let link = document.createElement("a");
        link.href = window.URL.createObjectURL(blob);
        link.download = "thongkevattu.pdf";
        link.click();
    };
    const onSubmit = (data) => {
        router.post(route("vat-tu.import"), data, {
            onSuccess: () => {
                setOpenModal(false);
                toast.success("Nhập thêm thành công !");
            },
        });
    };

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <div className="flex justify-between">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight uppercase">
                        vật tư
                    </h2>

                    <div className="flex gap-5">
                        <Link
                            className="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
                            href={route("vat-tu.create")}
                        >
                            Thêm mới
                        </Link>
                        <PrimaryButton
                            onClick={() => {
                                setOpenModal(true);
                                reset({
                                    NgayNhap: format(new Date(), "yyyy-MM-dd"),
                                });
                            }}
                        >
                            Nhập vật tư
                        </PrimaryButton>
                        <SecondaryButton onClick={handlePrint}>
                            in báo cáo thống kê vật tư
                        </SecondaryButton>
                    </div>
                </div>
            }
        >
            <Head title="Quản lý vật tư" />

            <PageContainer>
                <div className="flex gap-10">
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
                        <option key="con" value="con">
                            Còn vật tư
                        </option>
                        <option key="het" value="het">
                            Hết vật tư
                        </option>
                    </select>
                </div>
                <Table
                    sorting={sorting}
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
                    data={_get(props, "supplies", [])}
                    columns={cols}
                />
                <Pagination
                    totalCount={_get(props, "totalPage")}
                    currentPage={currentPage}
                    pageSize={10}
                    onPageChange={(page) => {
                        getRouter({ page });
                        setCurrentPage(page);
                    }}
                />
                <div className="mt-4">
                    <h3 className="font-semibold text-lg">Lịch sử biến động</h3>
                    <Table
                        data={_get(props, "history", [])}
                        columns={colsHistory}
                    />
                </div>
            </PageContainer>
            <Dialog
                title="Nhập thêm vật tư"
                onClose={() => setOpenModal(false)}
                visible={openModal}
            >
                <form className="mt-4" onSubmit={handleSubmit(onSubmit)}>
                    <div className="flex flex-col gap-5">
                        <div>
                            <InputLabel htmlFor="VatTuID" value="Vật tư" />
                            <select
                                {...register("MaVatTu")}
                                id="MaVatTu"
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            >
                                {_get(props, "supplieOptions", []).map(
                                    (s, index) => {
                                        return (
                                            <option key={index} value={s.id}>
                                                {s.name}
                                            </option>
                                        );
                                    }
                                )}
                            </select>
                        </div>
                        <InputControl
                            control={control}
                            name="SoLuong"
                            className="mt-1 block w-full"
                            label="Số lượng"
                            type="number"
                            maxLength={10}
                            rules={{ required: "Số lượng không để trống" }}
                        />
                        <InputControl
                            control={control}
                            name="NgayNhap"
                            className="mt-1 block w-full"
                            label="Ngày nhập"
                            type="date"
                            rules={{ required: "Ngày nhập không để trống" }}
                        />
                    </div>
                    <div className="mt-5">
                        <PrimaryButton>Lưu</PrimaryButton>
                    </div>
                </form>
            </Dialog>
        </AuthenticatedLayout>
    );
}
