import { createColumnHelper } from "@/Components/Table";
import { getRecordsText } from "@/Utils/helpers";
import { useMemo } from "react";
import { BsEye, BsPencil, BsPrinter, BsTrash } from "react-icons/bs";

const columnHelper = createColumnHelper();

const useCols = ({
    handleDelete,
    handleEdit,
    handleShow,
    handlePrint,
    user,
}) => {
    const cols = useMemo(() => {
        return [
            columnHelper.accessor("HoVaTen", {
                header: "Bệnh nhân",
                cell: (info) => info.getValue(),
                enableSorting: true,
            }),
            columnHelper.accessor("CMND", {
                header: "CCCD",
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
            columnHelper.accessor("TrangThai", {
                header: "Trạng thái",
                cell: (info) => getRecordsText(info.getValue()),
            }),
            columnHelper.accessor("actions", {
                header: "Thao tác",
                cell: (info) => (
                    <>
                        <BsEye
                            className="cursor-pointer"
                            onClick={() => {
                                handleShow(info.row.original.id);
                            }}
                        />

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
                        {["ChoPheDuyet", "DangDieuTri"].includes(
                            info.row.original["TrangThai"]
                        ) ? (
                            <BsPencil
                                className="cursor-pointer"
                                onClick={() => {
                                    handleEdit(info.row.original.id);
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
    }, [user]);

    return cols;
};

export default useCols;
