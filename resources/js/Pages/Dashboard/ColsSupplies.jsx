import { createColumnHelper } from "@/Components/Table";
import { useMemo } from "react";

const columnHelper = createColumnHelper();

const useColsSupplies = () => {
    const cols = useMemo(() => {
        return [
            columnHelper.accessor("TenVT", {
                header: "Tên Vật tư",
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

export default useColsSupplies;
