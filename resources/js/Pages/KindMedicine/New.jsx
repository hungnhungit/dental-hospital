import InputControl from "@/Components/InputControl";
import PageContainer from "@/Components/PageContainer";
import PrimaryButton from "@/Components/PrimaryButton";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import { useForm } from "react-hook-form";
import { toast } from "react-toastify";

export default function NewKindMedicine(props) {
    const { kindMedicine } = props;
    const isModeEdit = kindMedicine ? true : false;
    const { handleSubmit, control } = useForm({
        defaultValues: isModeEdit
            ? {
                  name: kindMedicine.name,
              }
            : {},
    });

    const onSubmit = (data) => {
        if (!isModeEdit) {
            router.post("/loai-thuoc", data, {
                onSuccess: () => {
                    toast.success("Thêm loại thuốc thành công !");
                },
                onError: () => {
                    toast.error("Loại thuốc đã tồn tại !");
                },
            });
        } else {
            router.put(`/loai-thuoc/${kindMedicine.id}`, data, {
                onSuccess: () => {
                    toast.success("Sửa loại thuốc thành công !");
                },
                onError: () => {
                    toast.error("Loại thuốc đã tồn tại !");
                },
            });
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
                        href={route("loai-thuoc.index")}
                    >
                        Danh sách loại thuốc
                    </Link>
                </div>
            }
        >
            <Head title="Thêm mới loại thuốc" />

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
                    </div>
                    <PrimaryButton type="submit" className="mt-4">
                        {isModeEdit ? "Sửa" : "Thêm mới"}
                    </PrimaryButton>
                </form>
            </PageContainer>
        </AuthenticatedLayout>
    );
}
