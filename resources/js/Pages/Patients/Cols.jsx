import { createColumnHelper } from "@/Components/Table";
import { useMemo } from "react";
import { BsPencil, BsTrash } from "react-icons/bs";

const columnHelper = createColumnHelper();

const useCols = () => {
    const cols = useMemo(() => {
        return [
            columnHelper.accessor("full_name", {
                header: "Họ và tên",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("dob", {
                header: "Ngày sinh",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("phone", {
                header: "Số điện thoại",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("cccd", {
                header: "CCCD",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("address", {
                header: "Địa chỉ",
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
