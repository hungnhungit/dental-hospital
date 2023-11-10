import InputControl from "@/Components/InputControl";
import InputLabel from "@/Components/InputLabel";
import PageContainer from "@/Components/PageContainer";
import PrimaryButton from "@/Components/PrimaryButton";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import _get from "lodash/get";
import { useForm } from "react-hook-form";
import { toast } from "react-toastify";

export default function NewMedicine(props) {
    const { medicine } = props;
    const isModeEdit = medicine ? true : false;

    const { register, handleSubmit, control } = useForm({
        defaultValues: isModeEdit ? medicine : {},
    });

    const onSubmit = (data) => {
        if (!isModeEdit) {
            router.post("/thuoc", data);
            toast.success("Thêm thuốc thành công !");
        } else {
            router.put(`/thuoc/${medicine.Id}`, data);
            toast.success("Sửa thuốc thành công !");
        }
    };

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <div className="flex justify-between">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight uppercase">
                        {isModeEdit ? "sửa thuốc" : "thêm mới thuốc"}
                    </h2>
                    <Link
                        className="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
                        href={route("thuoc.index")}
                    >
                        Danh sách thuốc
                    </Link>
                </div>
            }
        >
            <Head title="Thêm mới loại vật tư" />

            <PageContainer>
                <form className="mt-4" onSubmit={handleSubmit(onSubmit)}>
                    <div className="grid grid-cols-2 gap-10">
                        <InputControl
                            control={control}
                            name="TenThuoc"
                            className="mt-1 block w-full"
                            label="Tên thuốc"
                            maxLength={255}
                            rules={{ required: "Tên thuốc không để trống" }}
                        />
                        <div>
                            <InputLabel
                                htmlFor="LoaiThuocID"
                                value="Loại thuốc"
                            />
                            <select
                                {...register("LoaiThuocID")}
                                id="LoaiThuocID"
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            >
                                {_get(props, "kinds", []).map((kind, index) => {
                                    return (
                                        <option key={index} value={kind.id}>
                                            {kind.name}
                                        </option>
                                    );
                                })}
                            </select>
                        </div>
                    </div>
                    <div className="grid grid-cols-2 gap-10 mt-5">
                        <InputControl
                            control={control}
                            name="CongDung"
                            className="mt-1 block w-full"
                            label="Công dụng"
                            maxLength={255}
                            rules={{ required: "Công dụng không để trống" }}
                        />
                        <InputControl
                            control={control}
                            name="CachDung"
                            className="mt-1 block w-full"
                            label="Cách dùng"
                            maxLength={255}
                            rules={{ required: "Cách dùng không để trống" }}
                        />
                    </div>
                    <div className="grid grid-cols-2 gap-10 mt-5">
                        <InputControl
                            control={control}
                            name="SoLuong"
                            className="mt-1 block w-full"
                            label="Số lượng"
                            type="number"
                            maxLength={10}
                            rules={{ required: "Số lượng không để trống" }}
                        />
                        <div>
                            <InputLabel htmlFor="MaDonVi" value="Đơn vị tính" />
                            <select
                                {...register("MaDonVi")}
                                id="MaDonVi"
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            >
                                {_get(props, "units", []).map((kind, index) => {
                                    return (
                                        <option key={index} value={kind.id}>
                                            {kind.name}
                                        </option>
                                    );
                                })}
                            </select>
                        </div>
                    </div>
                    <div className="grid grid-cols-2 gap-10 mt-5">
                        <InputControl
                            type="date"
                            control={control}
                            name="HSD"
                            className="mt-1 block w-full"
                            label="HSD"
                            maxLength={10}
                            rules={{ required: "HSD không để trống" }}
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
