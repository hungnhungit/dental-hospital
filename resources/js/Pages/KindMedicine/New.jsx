import InputControl from "@/Components/InputControl";
import InputLabel from "@/Components/InputLabel";
import PageContainer from "@/Components/PageContainer";
import PrimaryButton from "@/Components/PrimaryButton";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import _get from "lodash/get";
import { useForm } from "react-hook-form";
import { toast } from "react-toastify";

export default function NewKindMedicine(props) {
    const { kindMedicine } = props;
    const isModeEdit = kindMedicine ? true : false;
    console.log(isModeEdit);

    const { register, handleSubmit, control } = useForm({
        defaultValues: isModeEdit
            ? {
                  name: kindMedicine.name,
                  desc: kindMedicine.desc,
                  unit: kindMedicine.unit,
              }
            : {},
    });

    const onSubmit = (data) => {
        if (!isModeEdit) {
            router.post("/loai-thuoc", data);
            toast.success("Thêm loại thuốc thành công !");
        } else {
            router.put(`/loai-thuoc/${kindMedicine.id}`, data);
            toast.success("Sửa loại thuốc thành công !");
        }
    };

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <div className="flex justify-between">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight uppercase">
                        {isModeEdit ? "sửa loại thuốc" : "thêm mới loại thuốc"}
                    </h2>
                    <Link
                        className="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
                        href={route("kindMedicine.list")}
                    >
                        Danh sách loại thuốc
                    </Link>
                </div>
            }
        >
            <Head title="Thêm mới tài khoản" />

            <PageContainer>
                <form className="mt-4" onSubmit={handleSubmit(onSubmit)}>
                    <div className="grid grid-cols-2 gap-10">
                        <InputControl
                            control={control}
                            name="name"
                            className="mt-1 block w-full"
                            label="Tên"
                            maxLength={10}
                            rules={{ required: "Tên không để trống" }}
                        />
                        <div>
                            <InputLabel htmlFor="pos" value="Đơn vị tính" />
                            <select
                                {...register("unit")}
                                id="pick"
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            >
                                {_get(props, "units", []).map((u, index) => {
                                    return (
                                        <option key={index} value={u.idDVT}>
                                            {u.TenDVT}
                                        </option>
                                    );
                                })}
                            </select>
                        </div>
                    </div>
                    <div className="mt-5">
                        <InputControl
                            control={control}
                            name="desc"
                            label="Miêu tả"
                            className="mt-1 block w-full"
                            rules={{ required: "Miêu tả không để trống" }}
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
