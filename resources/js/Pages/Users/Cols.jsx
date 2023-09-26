import { createColumnHelper } from "@/Components/Table";
import { useMemo } from "react";
import { BsTrash } from "react-icons/bs";

const columnHelper = createColumnHelper();

const useCols = () => {
    const cols = useMemo(() => {
        return [
            columnHelper.accessor("full_name", {
                header: "Tên",
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
            columnHelper.accessor("phone", {
                header: "Số điện thoại",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("address", {
                header: "Địa chỉ",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("position", {
                header: "Chức vụ",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("id", {
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
                                    handleDelete(info.getValue());
                                }
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
