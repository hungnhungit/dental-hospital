import { createColumnHelper } from "@/Components/Table";
import { useMemo } from "react";
import { BsPencil, BsTrash } from "react-icons/bs";

const columnHelper = createColumnHelper();

const useColsProcess = ({ handleDelete, handleEdit }) => {
    const cols = useMemo(() => {
        return [
            columnHelper.accessor("DichVu", {
                header: "Dịch vụ",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("Thuoc", {
                header: "Thuốc",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("VatTu", {
                header: "Vật tư",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("ChiTietDieuTri", {
                header: "Chi tiết điều trị",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("NgayDieuTri", {
                header: "Ngày điều trị",
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

export default useColsProcess;
