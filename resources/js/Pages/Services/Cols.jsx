import { createColumnHelper } from "@/Components/Table";
import { formatNumber } from "@/Utils/helpers";
import { useMemo } from "react";
import { BsPencil, BsTrash } from "react-icons/bs";

const columnHelper = createColumnHelper();

const useCols = () => {
    const cols = useMemo(() => {
        return [
            columnHelper.accessor("name", {
                header: "Tên",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("desc", {
                header: "Miêu tả",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("price", {
                header: "đơn giá",
                cell: (info) => formatNumber(info.getValue()),
            }),
            columnHelper.accessor("kindService", {
                header: "Loại dịch vụ",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("actions", {
                header: "Thao tác",
                cell: (info) => (
                    <>
                        <BsTrash className="cursor-pointer" />
                        <BsPencil className="cursor-pointer" />
                    </>
                ),
            }),
        ];
    }, []);

    return cols;
};

export default useCols;
