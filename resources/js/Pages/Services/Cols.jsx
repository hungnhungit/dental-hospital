import { createColumnHelper } from "@/Components/Table";
import { formatNumber } from "@/Utils/helpers";
import { useMemo } from "react";
import { BsPencil, BsTrash } from "react-icons/bs";

const columnHelper = createColumnHelper();

const useCols = ({ handleDelete, handleEdit }) => {
    const cols = useMemo(() => {
        return [
            columnHelper.accessor("TenDichVu", {
                header: "Tên",
                cell: (info) => info.getValue(),
                enableSorting: true,
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
                        <BsTrash
                            className="cursor-pointer"
                            onClick={() => {
                                console.log(info);
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
