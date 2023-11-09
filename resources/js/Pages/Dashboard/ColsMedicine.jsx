import { createColumnHelper } from "@/Components/Table";
import { useMemo } from "react";

const columnHelper = createColumnHelper();

const useColsMedicine = () => {
    const cols = useMemo(() => {
        return [
            columnHelper.accessor("TenThuoc", {
                header: "Tên thuốc",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("SoLuong", {
                header: "Số lượng",
                cell: (info) => info.getValue() || "Hết",
            }),
        ];
    }, []);

    return cols;
};

export default useColsMedicine;
