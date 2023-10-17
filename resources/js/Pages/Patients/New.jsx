import InputControl from "@/Components/InputControl";
import InputLabel from "@/Components/InputLabel";
import PageContainer from "@/Components/PageContainer";
import PrimaryButton from "@/Components/PrimaryButton";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import { useForm } from "react-hook-form";
import { toast } from "react-toastify";
import _get from "lodash/get";

export default function NewMedicine(props) {
    const { patient } = props;
    const isModeEdit = patient ? true : false;

    const { register, handleSubmit, control } = useForm({
        defaultValues: isModeEdit ? patient : {},
    });

    const onSubmit = (data) => {
        if (!isModeEdit) {
            router.post("/benhnhan", data);
            toast.success("Thêm bệnh nhân thành công !");
        } else {
            router.put(`/benhnhan/${patient.Id}`, data);
            toast.success("Sửa bệnh nhân thành công !");
        }
    };

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <div className="flex justify-between">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight uppercase">
                        {isModeEdit ? "sửa bệnh nhân" : "thêm mới bệnh nhân"}
                    </h2>
                    <Link
                        className="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
                        href={route("loai-dich-vu.index")}
                    >
                        Danh sách bệnh nhân
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
                            name="HoVaTen"
                            className="mt-1 block w-full"
                            label="Tên bệnh nhân"
                            rules={{ required: "Tên bệnh nhân không để trống" }}
                        />
                        <div>
                            <InputLabel htmlFor="GioiTinh" value="Giới tính" />
                            <select
                                {...register("GioiTinh")}
                                id="GioiTinh"
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            >
                                <option value="nam">Nam</option>
                                <option value="nu">Nữ</option>
                            </select>
                        </div>
                    </div>
                    <div className="grid grid-cols-2 gap-10 mt-5">
                        <InputControl
                            control={control}
                            name="DiaChi"
                            className="mt-1 block w-full"
                            label="Địa chỉ"
                            rules={{ required: "Địa chỉ không để trống" }}
                        />
                        <InputControl
                            control={control}
                            name="CMND"
                            className="mt-1 block w-full"
                            label="CCCD"
                            rules={{ required: "cccd không để trống" }}
                        />
                    </div>
                    <div className="grid grid-cols-2 gap-10 mt-5">
                        <InputControl
                            control={control}
                            name="NhomMau"
                            className="mt-1 block w-full"
                            label="Nhóm máu"
                            rules={{ required: "Nhóm máu không để trống" }}
                        />
                        <InputControl
                            control={control}
                            name="NgaySinh"
                            className="mt-1 block w-full"
                            label="Ngày sinh"
                            type="date"
                            rules={{ required: "Ngày sinh không để trống" }}
                        />
                    </div>
                    <div className="grid grid-cols-2 gap-10 mt-5">
                        <InputControl
                            control={control}
                            name="CanNang"
                            className="mt-1 block w-full"
                            label="Cân nặng"
                            maxLength={10}
                            rules={{ required: "Cân nặng không để trống" }}
                        />
                        <InputControl
                            control={control}
                            name="ChieuCao"
                            className="mt-1 block w-full"
                            label="Chiều cao"
                            maxLength={10}
                            rules={{ required: "Chiều cao không để trống" }}
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
