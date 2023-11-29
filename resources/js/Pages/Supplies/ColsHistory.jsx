import { createColumnHelper } from "@/Components/Table";
import { formatNumber } from "@/Utils/helpers";
import { useMemo } from "react";

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
            columnHelper.accessor("ChiPhiNhap", {
                header: "Chi phí nhập",
                cell: (info) => formatNumber(info.getValue()),
            }),
            columnHelper.accessor("ChiPhiXuat", {
                header: "Chi phí xuất",
                cell: (info) => formatNumber(info.getValue()),
            }),
        ];
    }, []);

    return cols;
};

export default useColsHistory;
