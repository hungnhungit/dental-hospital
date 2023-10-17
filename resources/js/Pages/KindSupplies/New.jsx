import InputControl from "@/Components/InputControl";
import PageContainer from "@/Components/PageContainer";
import PrimaryButton from "@/Components/PrimaryButton";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import { useForm } from "react-hook-form";
import { toast } from "react-toastify";

export default function NewKindSupplies(props) {
    const {} = props;
    const isModeEdit = kindSupplies ? true : false;

    const { handleSubmit, control } = useForm({
        defaultValues: isModeEdit ? kindSupplies : {},
    });

    const onSubmit = (data) => {
        if (!isModeEdit) {
            router.post("/loai-vat-tu", data);
            toast.success("Thêm loại vật tư thành công !");
        } else {
            router.put(`/loai-vat-tu/${kindSupplies.id}`, data);
            toast.success("Sửa loại vật tư thành công !");
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
                            ? "sửa loại vật tư"
                            : "thêm mới loại vật tư"}
                    </h2>
                    <Link
                        className="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
                        href={route("loai-dich-vu.index")}
                    >
                        Danh sách loại vật tư
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
