import { createColumnHelper } from "@/Components/Table";
import { formatNumber, getPaymentText, getStatusText } from "@/Utils/helpers";
import _get from "lodash/get";
import { useMemo } from "react";
import { BsCreditCard2Back, BsTrash } from "react-icons/bs";

const columnHelper = createColumnHelper();

const stylesPayment = {
    HuyBo: "uppercase bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300",
    DangXuLy:
        "uppercase bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300",
    ThanhCong:
        "uppercase bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300",
};

const useCols = () => {
    const cols = useMemo(() => {
        return [
            columnHelper.accessor("code", {
                header: "Mã hoá đơn",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("total", {
                header: "Tổng tiền",
                cell: (info) => formatNumber(info.getValue()),
            }),
            columnHelper.accessor("payment", {
                header: "Hình thức thanh toán",
                cell: (info) => getPaymentText(info.getValue()),
            }),
            columnHelper.accessor("status", {
                header: "trạng thái",
                cell: (info) => (
                    <span className={stylesPayment[info.getValue()]}>
                        {getStatusText(info.getValue())}
                    </span>
                ),
            }),
            columnHelper.accessor("created_by", {
                header: "người tạo",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("patient", {
                header: "bệnh nhân",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("actions", {
                header: "Thao tác",
                cell: (info) => (
                    <>
                        <BsTrash className="cursor-pointer" />
                        <BsCreditCard2Back className="cursor-pointer" />
                    </>
                ),
            }),
        ];
    }, []);

    return cols;
};

export default useCols;
