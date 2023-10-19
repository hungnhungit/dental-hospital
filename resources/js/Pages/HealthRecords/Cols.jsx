import { createColumnHelper } from "@/Components/Table";
import { useMemo } from "react";
import { BsEye, BsPencil, BsTrash } from "react-icons/bs";

const columnHelper = createColumnHelper();

const useCols = ({ handleDelete, handleEdit, handleShow }) => {
    const cols = useMemo(() => {
        return [
            columnHelper.accessor("BenhNhan", {
                header: "Bệnh nhân",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("BacSi", {
                header: "Bác sĩ",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("ChanDoanBenh", {
                header: "Chuẩn đoán bệnh",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("actions", {
                header: "Thao tác",
                cell: (info) => (
                    <>
                        <BsEye className="cursor-pointer" />
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
