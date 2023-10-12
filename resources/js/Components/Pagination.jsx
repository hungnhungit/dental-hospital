import { usePagination } from "@/Hooks/usePagination";
import classnames from "classnames";

const Pagination = (props) => {
    const {
        onPageChange,
        totalCount,
        siblingCount = 1,
        currentPage,
        pageSize = 10,
        className,
    } = props;

    const paginationRange = usePagination({
        currentPage,
        totalCount,
        siblingCount,
        pageSize,
    });

    if (currentPage === 0 || !paginationRange) {
        return null;
    }

    const onNext = () => {
        if (currentPage === lastPage) {
            return;
        }
        onPageChange(currentPage + 1);
    };

    const onPrevious = () => {
        if (currentPage === 1) {
            return;
        }
        onPageChange(currentPage - 1);
    };

    let lastPage = paginationRange[paginationRange.length - 1];
    return (
        <div className="mt-10 flex justify-between items-center">
            <div>Tổng {totalCount} bản ghi</div>
            <ul className="flex items-center -space-x-px h-8 text-sm">
                <li
                    className={classnames("pagination-item", {
                        disabled: currentPage === 1,
                    })}
                    onClick={onPrevious}
                >
                    <a className="cursor-pointer flex items-center justify-center px-3 h-8 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <span className="sr-only">Previous</span>
                        <svg
                            className="w-2.5 h-2.5"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 6 10"
                        >
                            <path
                                stroke="currentColor"
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth="2"
                                d="M5 1 1 5l4 4"
                            />
                        </svg>
                    </a>
                </li>
                {paginationRange.map((pageNumber, key) => {
                    return (
                        <li
                            key={key}
                            className={classnames(
                                "flex items-center justify-center px-3 h-8 leading-tight border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white cursor-pointer",
                                [
                                    pageNumber === currentPage
                                        ? "text-blue-600 bg-blue-50"
                                        : "text-gray-500 bg-white",
                                ]
                            )}
                            onClick={() => onPageChange(Number(pageNumber))}
                        >
                            {pageNumber}
                        </li>
                    );
                })}
                <li
                    className={classnames({
                        disabled: currentPage === lastPage,
                    })}
                    onClick={onNext}
                >
                    <a className="cursor-pointer flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <span className="sr-only">Next</span>
                        <svg
                            className="w-2.5 h-2.5"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 6 10"
                        >
                            <path
                                stroke="currentColor"
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth="2"
                                d="m1 9 4-4-4-4"
                            />
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
    );
};

export default Pagination;
