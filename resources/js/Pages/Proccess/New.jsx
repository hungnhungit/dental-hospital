import InputControl from "@/Components/InputControl";
import InputLabel from "@/Components/InputLabel";
import PageContainer from "@/Components/PageContainer";
import PrimaryButton from "@/Components/PrimaryButton";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import _get from "lodash/get";
import { useForm } from "react-hook-form";
import { toast } from "react-toastify";
import { format } from "date-fns";

export default function NewProccess(props) {
    const { process, SoKhamBenhId } = props;
    const isModeEdit = process ? true : false;
    const { register, handleSubmit, control } = useForm({
        defaultValues: isModeEdit
            ? process
            : {
                  NgayDieuTri: format(new Date(), "yyyy-MM-dd"),
                  Sothuoc: 1,
                  SoVatTu: 1,
                  TenTienTrinh: "TTDT-" + Math.floor(Math.random() * 100000),
              },
    });

    const onSubmit = (data) => {
        if (!isModeEdit) {
            router.post(route("tientrinhdieutri.store", SoKhamBenhId), data, {
                onSuccess: () => {
                    toast.success("Sửa tiến trình điều trị thành công !");
                },
                onError: ({ message }) => {
                    if (message === "QUANTITY_LIMIT_SUPPLIES") {
                        toast.error("Vật tư không đủ !");
                    }
                    if (message === "QUANTITY_LIMIT_MEDICINE") {
                        toast.error("Thuốc không đủ !");
                    }
                },
            });
        } else {
            router.put(
                route("tientrinhdieutri.update", [SoKhamBenhId, process["Id"]]),
                data,
                {
                    onSuccess: () => {
                        toast.success("Sửa tiến trình điều trị thành công !");
                    },
                }
            );
        }
    };

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <div className="flex justify-between">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight uppercase">
                        {isModeEdit
                            ? "sửa tiến trình điều trị"
                            : "thêm mới tiến trình điều trị"}
                    </h2>
                    <Link
                        className="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
                        href={route("sokhambenh.show", SoKhamBenhId)}
                    >
                        Sổ khám bệnh
                    </Link>
                </div>
            }
        >
            <Head title="Thêm mới tiến trình điều trị" />

            <PageContainer>
                <form className="mt-4" onSubmit={handleSubmit(onSubmit)}>
                    <div className="grid grid-cols-2 gap-10">
                        <div>
                            <InputLabel htmlFor="MaDichVu" value="Dịch vụ" />
                            <select
                                {...register("MaDichVu")}
                                id="MaDichVu"
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            >
                                {_get(props, "DichVu", []).map(
                                    (item, index) => {
                                        return (
                                            <option key={index} value={item.id}>
                                                {item.name}
                                            </option>
                                        );
                                    }
                                )}
                            </select>
                        </div>
                        <div className="grid grid-cols-2 gap-10">
                            <div>
                                <InputLabel htmlFor="Thuoc" value="Thuốc" />
                                <select
                                    {...register("MaThuoc")}
                                    id="Thuoc"
                                    className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                >
                                    {_get(props, "Thuoc", []).map(
                                        (item, index) => {
                                            return (
                                                <option
                                                    key={index}
                                                    value={item.id}
                                                >
                                                    {item.name} -{" "}
                                                    {item.q === 0
                                                        ? "Hết thuốc"
                                                        : item.q}
                                                </option>
                                            );
                                        }
                                    )}
                                </select>
                            </div>
                            <InputControl
                                type="number"
                                control={control}
                                name="Sothuoc"
                                className="mt-1 block w-full"
                                label="Số lượng thuốc"
                                rules={{
                                    required: "Số lượng thuốc không để trống",
                                }}
                            />
                        </div>
                    </div>
                    <div className="grid grid-cols-2 gap-10 mt-5">
                        <div className="grid grid-cols-2 gap-10">
                            <div>
                                <InputLabel htmlFor="MaVatTu" value="Vật tư" />
                                <select
                                    {...register("MaVatTu")}
                                    id="MaVatTu"
                                    className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                >
                                    {_get(props, "VatTu", []).map(
                                        (item, index) => {
                                            return (
                                                <option
                                                    key={index}
                                                    value={item.id}
                                                >
                                                    {item.name} -{" "}
                                                    {item.q === 0
                                                        ? "Hết vật tư"
                                                        : item.q}
                                                </option>
                                            );
                                        }
                                    )}
                                </select>
                            </div>
                            <InputControl
                                type="number"
                                control={control}
                                name="SoVatTu"
                                className="mt-1 block w-full"
                                label="Số lượng vật tư"
                                rules={{
                                    required: "Số lượng vật tư không để trống",
                                }}
                            />
                        </div>
                        <InputControl
                            control={control}
                            type="date"
                            name="NgayDieuTri"
                            className="mt-1 block w-full"
                            label="Ngày điều trị"
                            rules={{
                                required: "Ngày điều trị không để trống",
                            }}
                        />
                    </div>
                    <div className="mt-5">
                        <InputControl
                            control={control}
                            name="ChiTietDieuTri"
                            className="mt-1 block w-full"
                            label="Chi tiết điều trị"
                            rules={{
                                required: "Chi tiết điều trị không để trống",
                            }}
                        />
                    </div>
                    <PrimaryButton type="submit" className="mt-4">
                        {isModeEdit ? "Sửa" : "Thêm mới"}
                    </PrimaryButton>
                </form>
            </PageContainer>
        </AuthenticatedLayout>
    );
}
