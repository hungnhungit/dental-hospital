import InputControl from "@/Components/InputControl";
import PageContainer from "@/Components/PageContainer";
import PrimaryButton from "@/Components/PrimaryButton";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import { useForm } from "react-hook-form";
import { toast } from "react-toastify";

export default function NewUnit(props) {
    const { unit } = props;
    const isModeEdit = unit ? true : false;

    const { handleSubmit, control } = useForm({
        defaultValues: isModeEdit ? unit : {},
    });

    const onSubmit = (data) => {
        if (!isModeEdit) {
            router.post("/donvitinh", data);
            toast.success("Thêm đơn vị tính thành công !");
        } else {
            router.put(`/donvitinh/${unit.id}`, data);
            toast.success("Sửa đơn vị tính thành công !");
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
                            ? "sửa đơn vị tính"
                            : "thêm mới đơn vị tính"}
                    </h2>
                    <Link
                        className="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
                        href={route("donvitinh.index")}
                    >
                        Danh sách đơn vị tính
                    </Link>
                </div>
            }
        >
            <Head
                title={isModeEdit ? "sửa đơn vị tính" : "thêm mới đơn vị tính"}
            />

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
                        <InputControl
                            control={control}
                            name="float"
                            label="Hệ số"
                            type="number"
                            className="mt-1 block w-full"
                            rules={{ required: "Hệ số không để trống" }}
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
