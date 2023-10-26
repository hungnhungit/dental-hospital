import { createColumnHelper } from "@/Components/Table";
import { formatNumber, getStatusText } from "@/Utils/helpers";
import { useMemo } from "react";
import { BsCreditCard2Back, BsPrinter, BsTrash } from "react-icons/bs";

const columnHelper = createColumnHelper();

const stylesPayment = {
    Huy: "uppercase bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300",
    ChuaThanhToan:
        "uppercase bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300",
    DaThanhToan:
        "uppercase bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300",
};

const useCols = ({ handlePrint }) => {
    const cols = useMemo(() => {
        return [
            columnHelper.accessor("TenHoaDon", {
                header: "Tên hoá đơn",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("TongSoTien", {
                header: "Tổng tiền",
                cell: (info) => formatNumber(info.getValue()),
            }),
            columnHelper.accessor("TrangThai", {
                header: "trạng thái",
                cell: (info) => (
                    <span className={stylesPayment[info.getValue()]}>
                        {getStatusText(info.getValue())}
                    </span>
                ),
            }),
            columnHelper.accessor("NguoiTao", {
                header: "người tạo",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("BenhNhan", {
                header: "bệnh nhân",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("actions", {
                header: "Thao tác",
                cell: (info) => (
                    <>
                        <BsTrash className="cursor-pointer" />
                        <BsCreditCard2Back className="cursor-pointer" />
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
