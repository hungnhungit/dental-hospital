import { createColumnHelper } from "@/Components/Table";
import { useMemo } from "react";
import { BsPencil, BsTrash } from "react-icons/bs";

const columnHelper = createColumnHelper();

const useColsHistory = () => {
    const cols = useMemo(() => {
        return [
            columnHelper.accessor("NgayBienDong", {
                header: "Ngày biến động",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("SoLuongNhap", {
                header: "Số lượng nhập",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("SoLuongXuat", {
                header: "Số lượng xuất",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("SoLuongHienTai", {
                header: "Số lượng hiện tại",
                cell: (info) => info.getValue(),
            }),
        ];
    }, []);

    return cols;
};

export default useColsHistory;
