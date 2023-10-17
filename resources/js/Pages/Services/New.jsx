import InputControl from "@/Components/InputControl";
import PageContainer from "@/Components/PageContainer";
import PrimaryButton from "@/Components/PrimaryButton";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import { useForm } from "react-hook-form";
import { toast } from "react-toastify";
import _get from "lodash/get";
import InputLabel from "@/Components/InputLabel";

export default function NewServices(props) {
    const { service } = props;
    const isModeEdit = service ? true : false;

    const { register, handleSubmit, control } = useForm({
        defaultValues: isModeEdit ? service : {},
    });

    const onSubmit = (data) => {
        if (!isModeEdit) {
            router.post("/dichvu", data);
            toast.success("Thêm dịch vụ thành công !");
        } else {
            router.put(`/dichvu/${service.id}`, data);
            toast.success("Sửa dịch vụ thành công !");
        }
    };

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <div className="flex justify-between">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight uppercase">
                        {isModeEdit ? "sửa dịch vụ" : "thêm mới dịch vụ"}
                    </h2>
                    <Link
                        className="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
                        href={route("loai-dich-vu.index")}
                    >
                        Danh sách dịch vụ
                    </Link>
                </div>
            }
        >
            <Head title="Thêm mới dịch vụ" />

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
                            name="desc"
                            className="mt-1 block w-full"
                            label="Miêu tả"
                            maxLength={10}
                            rules={{ required: "Miêu tả không để trống" }}
                        />
                    </div>
                    <div className="grid grid-cols-2 gap-10 mt-5">
                        <InputControl
                            control={control}
                            name="price"
                            className="mt-1 block w-full"
                            label="Đơn giá"
                            maxLength={10}
                            type="number"
                            rules={{ required: "Đơn giá không để trống" }}
                        />
                        <div>
                            <InputLabel htmlFor="kind" value="Loại tin tức" />
                            <select
                                {...register("kind")}
                                id="kind"
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            >
                                {_get(props, "kindService", []).map(
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
                    </div>
                    <PrimaryButton type="submit" className="mt-4">
                        {isModeEdit ? "Sửa" : "Thêm mới"}
                    </PrimaryButton>
                </form>
            </PageContainer>
        </AuthenticatedLayout>
    );
}
