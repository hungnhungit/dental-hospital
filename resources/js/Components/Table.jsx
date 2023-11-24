import {
    createColumnHelper,
    flexRender,
    getCoreRowModel,
    getSortedRowModel,
    useReactTable,
} from "@tanstack/react-table";
import { memo, useMemo } from "react";
import { BiSortAlt2, BiSortDown, BiSortUp } from "react-icons/bi";

const Table = ({ data, columns, sorting, setSorting }) => {
    const memoizedData = useMemo(() => data, [data]);
    const memoizedColumns = useMemo(() => columns, [columns]);
    const table = useReactTable({
        data: memoizedData,
        columns: memoizedColumns,
        manualSorting: true,
        state: {
            sorting,
        },
        onSortingChange: setSorting,
        getCoreRowModel: getCoreRowModel(),
        getSortedRowModel: getSortedRowModel(),
        defaultColumn: {
            enableSorting: false,
        },
    });

    return (
        <div className="relative overflow-x-auto min-h-[600px] w-[1500px] mt-4">
            <table className="w-full text-sm text-left text-gray-500">
                <thead className="lg:text-base md:text-[10px] text-gray-700 uppercase bg-gray-50">
                    {table.getHeaderGroups().map((headerGroup) => (
                        <tr key={headerGroup.id}>
                            {headerGroup.headers.map((header) => {
                                return (
                                    <th
                                        key={header.id}
                                        className={`${
                                            header.id === "actions"
                                                ? "px-6 py-3 w-[150px]"
                                                : "px-6 py-3"
                                        } whitespace-nowrap`}
                                    >
                                        {header.isPlaceholder ? null : (
                                            <div
                                                {...{
                                                    className:
                                                        header.column.getCanSort()
                                                            ? "select-none cursor-pointer flex items-center gap-1"
                                                            : "",
                                                    onClick:
                                                        header.column.getToggleSortingHandler(),
                                                }}
                                            >
                                                {flexRender(
                                                    header.column.columnDef
                                                        .header,
                                                    header.getContext()
                                                )}
                                                {{
                                                    asc: (
                                                        <BiSortDown className="h-5 w-5" />
                                                    ),
                                                    desc: (
                                                        <BiSortUp className="h-5 w-5" />
                                                    ),
                                                }[
                                                    header.column.getIsSorted()
                                                ] ?? null}
                                                {header.column.getCanSort() &&
                                                !header.column.getIsSorted() ? (
                                                    <BiSortAlt2 className="h-5 w-5" />
                                                ) : null}
                                            </div>
                                        )}
                                    </th>
                                );
                            })}
                        </tr>
                    ))}
                </thead>
                <tbody>
                    {table.getRowModel().rows.map((row) => (
                        <tr key={row.id} className="border-b">
                            {row.getVisibleCells().map((cell) => (
                                <td
                                    key={cell.id}
                                    className={
                                        cell.column.id === "actions"
                                            ? "flex items-center px-6 py-4 space-x-3"
                                            : "px-6 py-4 font-medium text-gray-900 whitespace-nowrap md:text-[12px] lg:text-base"
                                    }
                                >
                                    {flexRender(
                                        cell.column.columnDef.cell,
                                        cell.getContext()
                                    )}
                                </td>
                            ))}
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
};

export default memo(Table);

export { createColumnHelper };
