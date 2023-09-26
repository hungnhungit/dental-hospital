import { createColumnHelper } from "@/Components/Table";
import _get from "lodash/get";
import { useMemo } from "react";
import { BsEye } from "react-icons/bs";

const columnHelper = createColumnHelper();

const useCols = () => {
    const cols = useMemo(() => {
        return [
            columnHelper.accessor("doctor", {
                header: "Bác sĩ",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("created_by", {
                header: "Người tạo",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("registration_date", {
                header: "Thời gian khám",
                cell: (info) => info.getValue(),
            }),
            columnHelper.accessor("actions", {
                header: "Thao tác",
                cell: (info) => (
                    <>
                        <BsEye className="cursor-pointer" />
                    </>
                ),
            }),
        ];
    }, []);

    return cols;
};

export default useCols;
