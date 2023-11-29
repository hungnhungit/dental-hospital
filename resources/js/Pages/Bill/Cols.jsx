import { createColumnHelper } from "@/Components/Table";
import { formatNumber, getStatusText } from "@/Utils/helpers";
import { useMemo } from "react";
import { BsCreditCard, BsPrinter, BsTrash } from "react-icons/bs";

const columnHelper = createColumnHelper();

const stylesPayment = {
    Huy: "uppercase bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300",
    ChuaThanhToan:
        "uppercase bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300",
    DaThanhToan:
        "uppercase bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300",
};

const useCols = ({ handlePrint, handleDelete, handlePay }) => {
    const cols = useMemo(() => {
        return [
            columnHelper.accessor("TenHoaDon", {
                header: "Tên hoá đơn",
                cell: (info) => info.getValue(),
                enableSorting: true,
            }),
            columnHelper.accessor("TongSoTien", {
                header: "Tổng tiền",
                cell: (info) =>
                    info.row.original["GiamGia"] > 0
                        ? formatNumber(
                              info.getValue() -
                                  (info.getValue() *
                                      info.row.original["GiamGia"]) /
                                      100
                          )
                        : formatNumber(info.getValue()),
            }),
            columnHelper.accessor("GiamGia", {
                header: "Giảm giá",
                cell: (info) =>
                    info.getValue() > 0
                        ? `${info.getValue()}%`
                        : "Không giảm giá",
            }),
            columnHelper.accessor("TrangThai", {
                header: "trạng thái",
                cell: (info) => (
                    <span className={stylesPayment[info.getValue()]}>
                        {getStatusText(info.getValue())}
                    </span>
                ),
            }),
            columnHelper.accessor("NgayLap", {
                header: "Ngày tạo",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("NguoiTao", {
                header: "người tạo",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("BenhNhan", {
                header: "bệnh nhân",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("CMND", {
                header: "CCCD",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("actions", {
                header: "Thao tác",
                cell: (info) => (
                    <>
                        {info.row.original["TrangThai"] !== "DaThanhToan" ? (
                            <BsCreditCard
                                className="cursor-pointer"
                                onClick={() => {
                                    if (
                                        confirm(
                                            "Bạn có muốn thanh toán hoá đơn này không ?"
                                        )
                                    ) {
                                        handlePay(info.row.original.id);
                                    }
                                }}
                            />
                        ) : null}
                        {info.row.original["TrangThai"] !== "DaThanhToan" ? (
                            <BsTrash
                                className="cursor-pointer"
                                onClick={() => {
                                    if (
                                        confirm(
                                            "Bạn có muốn xoá bản ghi này không ?"
                                        )
                                    ) {
                                        handleDelete(info.row.original.id);
                                    }
                                }}
                            />
                        ) : null}
                        <BsPrinter
                            className="cursor-pointer"
                            onClick={() => {
                                handlePrint(info.row.original.id);
                            }}
                        />
                    </>
                ),
            }),
        ];
    }, []);

    return cols;
};

export default useCols;
