import { createColumnHelper } from "@/Components/Table";
import _get from "lodash/get";
import { useMemo } from "react";
import { BsPencil, BsTrash } from "react-icons/bs";

const columnHelper = createColumnHelper();

const stylesPayment = {
    cancel: "uppercase bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300",
    doing: "uppercase bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300",
    done: "uppercase bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300",
};

const useCols = () => {
    const cols = useMemo(() => {
        return [
            columnHelper.accessor("title", {
                header: "Tiêu đề",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("desc", {
                header: "miêu tả",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("kindNew", {
                header: "Loại tin tức",
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
