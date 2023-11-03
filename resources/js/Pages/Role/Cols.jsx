import { createColumnHelper } from "@/Components/Table";
import { router } from "@inertiajs/react";
import { useMemo } from "react";
import { AiOutlineSetting } from "react-icons/ai";

const columnHelper = createColumnHelper();

const useCols = () => {
    const cols = useMemo(() => {
        return [
            columnHelper.accessor("Quyen", {
                header: "Tên quyền",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("actions", {
                header: "Thao tác",
                cell: (info) => (
                    <>
                        {info.row.original["Quyen"] !== "admin" ? (
                            <AiOutlineSetting
                                className="cursor-pointer"
                                onClick={() =>
                                    router.visit(
                                        route(
                                            "quyen.show",
                                            info.row.original.id
                                        )
                                    )
                                }
                            />
                        ) : null}
                    </>
                ),
            }),
        ];
    }, []);

    return cols;
};

export default useCols;
