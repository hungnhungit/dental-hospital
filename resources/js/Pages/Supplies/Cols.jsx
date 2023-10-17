import { createColumnHelper } from "@/Components/Table";
import { useMemo } from "react";
import { BsPencil, BsTrash } from "react-icons/bs";

const columnHelper = createColumnHelper();

const useCols = ({ handleDelete, handleEdit }) => {
    const cols = useMemo(() => {
        return [
            columnHelper.accessor("TenVT", {
                header: "Tên vật tư",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("LoaiVatTu", {
                header: "Tên loại vật tư",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("DonVi", {
                header: "Đơn vị tính",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("SoLuong", {
                header: "Số lượng",
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
