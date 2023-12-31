import { createColumnHelper } from "@/Components/Table";
import { formatNumber } from "@/Utils/helpers";
import { useMemo } from "react";
import { BsPencil, BsTrash } from "react-icons/bs";

const columnHelper = createColumnHelper();

const useCols = ({ handleDelete, handleEdit }) => {
    const cols = useMemo(() => {
        return [
            columnHelper.accessor("HoVaTen", {
                header: "Họ và tên",
                cell: (info) => info.getValue(),
                enableSorting: true,
            }),
            columnHelper.accessor("Ma", {
                header: "Mã bệnh nhân",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("TongTienChi", {
                header: "Tổng tiền chi",
                cell: (info) => formatNumber(info.getValue()),
                enableSorting: true,
            }),
            columnHelper.accessor("dob", {
                header: "Ngày sinh",
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
            columnHelper.accessor("w", {
                header: "Cân nặng",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("h", {
                header: "Chiều cao",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("blood", {
                header: "Nhóm máu",
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
