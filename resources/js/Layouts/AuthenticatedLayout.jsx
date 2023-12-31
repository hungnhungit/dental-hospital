import Dropdown from "@/Components/Dropdown";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink";
import { getPostion } from "@/Utils/helpers";
import { MENUS } from "@/Utils/menu";
import { Link } from "@inertiajs/react";
import { map } from "lodash";
import { useState } from "react";
import { BsHospital } from "react-icons/bs";

export default function Authenticated({ auth, header, children }) {
    const { full_name, role, permssions } = auth.user;
    const permssionsMap = map(permssions, "permission");
    const [showingNavigationDropdown, setShowingNavigationDropdown] =
        useState(false);

    return (
        <div className="min-h-screen bg-gray-100 flex">
            <div className="min-w-[300px] bg-black px-7 py-5">
                <div className="flex gap-2 items-center justify-center">
                    <Link href="/" className="text-white">
                        <BsHospital className="w-8 h-8" />
                    </Link>
                    <div className="text-lg text-white top-2 relative">
                        Hospital
                    </div>
                </div>
                <ul className="flex flex-col mt-5">
                    {MENUS[role].map((menu) => {
                        if (
                            permssionsMap.includes(menu.permission) ||
                            menu.permission === "access" ||
                            role === "admin" ||
                            role === "supperadmin"
                        ) {
                            return (
                                <li
                                    key={menu.name}
                                    className={`py-4 hover:border-none hover:text-sky-500 transition-colors ${
                                        route().current() === menu.name
                                            ? "text-sky-500"
                                            : "text-white"
                                    }`}
                                >
                                    <Link href={route(menu.name)}>
                                        {menu.label}
                                    </Link>
                                </li>
                            );
                        }
                        return null;
                    })}
                </ul>
            </div>
            <div className="bg-gray-100 flex flex-col flex-1">
                <nav className="bg-white border-b border-gray-100">
                    <div className="max-w-9xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="flex justify-between items-center h-16">
                            <div>
                                <strong>Quyền: {getPostion(role)}</strong>
                            </div>

                            <div className="hidden sm:flex sm:items-center sm:ml-6">
                                <div className="ml-3 relative">
                                    <Dropdown>
                                        <Dropdown.Trigger>
                                            <span className="inline-flex rounded-md">
                                                <button
                                                    type="button"
                                                    className="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                                >
                                                    {full_name}
                                                    <svg
                                                        className="ml-2 -mr-0.5 h-4 w-4"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                    >
                                                        <path
                                                            fillRule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clipRule="evenodd"
                                                        />
                                                    </svg>
                                                </button>
                                            </span>
                                        </Dropdown.Trigger>

                                        <Dropdown.Content>
                                            {role === "admin" ? null : (
                                                <Dropdown.Link
                                                    href={route("profile.edit")}
                                                >
                                                    Cài đặt
                                                </Dropdown.Link>
                                            )}

                                            <Dropdown.Link
                                                href={route("logout")}
                                                method="post"
                                                as="button"
                                            >
                                                Đăng xuất
                                            </Dropdown.Link>
                                        </Dropdown.Content>
                                    </Dropdown>
                                </div>
                            </div>

                            <div className="-mr-2 flex items-center sm:hidden">
                                <button
                                    onClick={() =>
                                        setShowingNavigationDropdown(
                                            (previousState) => !previousState
                                        )
                                    }
                                    className="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                                >
                                    <svg
                                        className="h-6 w-6"
                                        stroke="currentColor"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            className={
                                                !showingNavigationDropdown
                                                    ? "inline-flex"
                                                    : "hidden"
                                            }
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth="2"
                                            d="M4 6h16M4 12h16M4 18h16"
                                        />
                                        <path
                                            className={
                                                showingNavigationDropdown
                                                    ? "inline-flex"
                                                    : "hidden"
                                            }
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth="2"
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div
                        className={
                            (showingNavigationDropdown ? "block" : "hidden") +
                            " sm:hidden"
                        }
                    >
                        <div className="pt-2 pb-3 space-y-1">
                            <ResponsiveNavLink
                                href={route("dashboard")}
                                active={route().current("dashboard")}
                            >
                                Tổng quan
                            </ResponsiveNavLink>
                        </div>

                        <div className="pt-4 pb-1 border-t border-gray-200">
                            <div className="px-4">
                                <div className="font-medium text-base text-gray-800">
                                    {full_name} ({getPostion(role)})
                                </div>
                                <div className="font-medium text-sm text-gray-500"></div>
                            </div>

                            <div className="mt-3 space-y-1">
                                {role === "admin" ? null : (
                                    <ResponsiveNavLink
                                        href={route("profile.edit")}
                                    >
                                        Cài đặt
                                    </ResponsiveNavLink>
                                )}
                                <ResponsiveNavLink
                                    method="post"
                                    href={route("logout")}
                                    as="button"
                                >
                                    Đăng xuất
                                </ResponsiveNavLink>
                            </div>
                        </div>
                    </div>
                </nav>

                {header && (
                    <header className="bg-white shadow">
                        <div className="py-6 px-4 sm:px-6 lg:px-8">
                            {header}
                        </div>
                    </header>
                )}

                <main>{children}</main>
            </div>
        </div>
    );
}
