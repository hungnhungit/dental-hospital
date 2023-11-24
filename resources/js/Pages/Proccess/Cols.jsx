import { createColumnHelper } from "@/Components/Table";
import { useMemo } from "react";
import { BsPencil, BsTrash } from "react-icons/bs";

const columnHelper = createColumnHelper();

const useCols = () => {
    const cols = useMemo(() => {
        return [
            columnHelper.accessor("TenTienTrinh", {
                header: "Mã",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("TenBacSi", {
                header: "Tên bác sỹ",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("TenBenhNhan", {
                header: "Tên bệnh nhân",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("NgayDieuTri", {
                header: "Ngày điều trị",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("ChiTietDieuTri", {
                header: "Chi tiết điều trị",
                cell: (info) => info.getValue(),
            }),
        ];
    }, []);

    return cols;
};

export default useCols;
