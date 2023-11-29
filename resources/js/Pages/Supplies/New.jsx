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
    const { supplie } = props;
    const isModeEdit = supplie ? true : false;

    const { register, handleSubmit, control } = useForm({
        defaultValues: isModeEdit ? supplie : {},
    });

    const onSubmit = (data) => {
        if (!isModeEdit) {
            router.post("/vat-tu", data);
            toast.success("Thêm vật tư thành công !");
        } else {
            router.put(`/vat-tu/${supplie.Id}`, data);
            toast.success("Sửa vật tư thành công !");
        }
    };

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <div className="flex justify-between">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight uppercase">
                        {isModeEdit ? "sửa vật tư" : "thêm mới vật tư"}
                    </h2>
                    <Link
                        className="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
                        href={route("vat-tu.index")}
                    >
                        Danh sách vật tư
                    </Link>
                </div>
            }
        >
            <Head title="Thêm mới vật tư" />

            <PageContainer>
                <form className="mt-4" onSubmit={handleSubmit(onSubmit)}>
                    <div className="grid grid-cols-2 gap-10">
                        <InputControl
                            control={control}
                            name="TenVT"
                            className="mt-1 block w-full"
                            label="Tên vật tư"
                            maxLength={255}
                            rules={{ required: "Tên vật tư không để trống" }}
                        />
                        <div>
                            <InputLabel
                                htmlFor="LoaiVatTuID"
                                value="Loại vật tư"
                            />
                            <select
                                {...register("LoaiVatTuID")}
                                id="LoaiVatTuID"
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
                            name="SoLuong"
                            className="mt-1 block w-full"
                            label="Số lượng"
                            type="number"
                            maxLength={10}
                            disabled={isModeEdit}
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
                            type="number"
                            control={control}
                            name="DonGia"
                            className="mt-1 block w-full"
                            label="Đơn giá"
                            maxLength={10}
                            rules={{ required: "Đơn giá không để trống" }}
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
