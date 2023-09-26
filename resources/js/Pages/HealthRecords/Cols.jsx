import { createColumnHelper } from "@/Components/Table";
import _get from "lodash/get";
import { useMemo } from "react";
import { BsPencil, BsTrash } from "react-icons/bs";

const columnHelper = createColumnHelper();

const useCols = () => {
    const cols = useMemo(() => {
        return [
            columnHelper.accessor("patient", {
                header: "Bệnh nhân",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("doctor", {
                header: "Bác sĩ",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("created_by", {
                header: "Người tạo",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("sick", {
                header: "Tình trạng bệnh",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("actions", {
                header: "Thao tác",
                cell: (info) => (
                    <>
                        <BsTrash className="cursor-pointer" />
                        <BsPencil className="cursor-pointer" />
                    </>
                ),
            }),
        ];
    }, []);

    return cols;
};

export default useCols;
