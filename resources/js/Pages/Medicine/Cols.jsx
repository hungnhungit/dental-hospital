import { createColumnHelper } from "@/Components/Table";
import { useMemo } from "react";
import { BsPencil, BsTrash } from "react-icons/bs";

const columnHelper = createColumnHelper();

const useCols = ({ handleDelete, handleEdit }) => {
    const cols = useMemo(() => {
        return [
            columnHelper.accessor("Ten", {
                header: "Tên thuốc",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("LoaiThuoc", {
                header: "Tên loại thuốc",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("CongDung", {
                header: "Công dụng",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("CachDung", {
                header: "Cách dùng",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("DonVi", {
                header: "Đơn vị",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("HSD", {
                header: "HSD",
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
