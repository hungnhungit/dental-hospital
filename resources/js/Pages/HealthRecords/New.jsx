import InputControl from "@/Components/InputControl";
import InputLabel from "@/Components/InputLabel";
import PageContainer from "@/Components/PageContainer";
import PrimaryButton from "@/Components/PrimaryButton";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import _get from "lodash/get";
import { useForm } from "react-hook-form";
import { toast } from "react-toastify";

export default function NewHealthRecords(props) {
    const { records } = props;
    const isModeEdit = records ? true : false;

    const { register, handleSubmit, control } = useForm({
        defaultValues: isModeEdit ? records : {},
    });

    const onSubmit = (data) => {
        if (!isModeEdit) {
            router.post("/sokhambenh", data);
            toast.success("Thêm sổ khám bệnh thành công !");
        } else {
            router.put(`/sokhambenh/${records.Id}`, data);
            toast.success("Sửa sổ khám bệnh thành công !");
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
                            ? "sửa sổ khám bệnh"
                            : "thêm mới sổ khám bệnh"}
                    </h2>
                    <Link
                        className="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
                        href={route("loai-dich-vu.index")}
                    >
                        Danh sách sổ khám bệnh
                    </Link>
                </div>
            }
        >
            <Head title="Thêm mới loại vật tư" />

            <PageContainer>
                <form className="mt-4" onSubmit={handleSubmit(onSubmit)}>
                    <div className="grid grid-cols-2 gap-10">
                        <div>
                            <InputLabel
                                htmlFor="MaBenhNhan"
                                value="Bệnh nhân"
                            />
                            <select
                                {...register("MaBenhNhan")}
                                id="MaBenhNhan"
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            >
                                {_get(props, "BenhNhan", []).map(
                                    (kind, index) => {
                                        return (
                                            <option key={index} value={kind.id}>
                                                {kind.name}
                                            </option>
                                        );
                                    }
                                )}
                            </select>
                        </div>
                        <div>
                            <InputLabel htmlFor="MaBacSi" value="Bác sĩ" />
                            <select
                                {...register("MaBacSi")}
                                id="MaBacSi"
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            >
                                {_get(props, "BacSi", []).map((kind, index) => {
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
                            name="ChanDoanBenh"
                            className="mt-1 block w-full"
                            label="Chuẩn đoán bệnh"
                            maxLength={10}
                            rules={{
                                required: "Chuẩn đoán bệnh không để trống",
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
