import { createColumnHelper } from "@/Components/Table";
import { useMemo } from "react";
import { BsPencil, BsTrash } from "react-icons/bs";

const columnHelper = createColumnHelper();

const useCols = ({ handleDelete, handleEdit }) => {
    const cols = useMemo(() => {
        return [
            columnHelper.accessor("full_name", {
                header: "Họ và tên",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("account", {
                header: "Tài khoản",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("dob", {
                header: "Ngày sinh",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("address", {
                header: "Địa chỉ",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("phone", {
                header: "Số điện thoại",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("position", {
                header: "Chức vụ",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("actions", {
                header: "Thao tác",
                cell: (info) => (
                    <>
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
                        <BsPencil
                            className="cursor-pointer"
                            onClick={() => {
                                handleEdit(info.row.original.id);
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
