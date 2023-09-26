import { createColumnHelper } from "@/Components/Table";
import { useMemo } from "react";
import { BsPencil, BsTrash } from "react-icons/bs";

const columnHelper = createColumnHelper();

const useCols = () => {
    const cols = useMemo(() => {
        return [
            columnHelper.accessor("name", {
                header: "Tên",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("slug", {
                header: "đường dẫn tĩnh",
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
