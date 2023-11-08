import InputControl from "@/Components/InputControl";
import InputLabel from "@/Components/InputLabel";
import PageContainer from "@/Components/PageContainer";
import PrimaryButton from "@/Components/PrimaryButton";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import { useForm } from "react-hook-form";
import { toast } from "react-toastify";

export default function NewUser(props) {
    const { user } = props;
    const isModeEdit = user ? true : false;
    console.log(user);
    const { register, handleSubmit, control } = useForm({
        defaultValues: user
            ? user
            : {
                  fullName: "Nguyễn Thái Hưng",
                  phone: "0707295002",
                  address: "Hải Phòng",
                  username: "hungnt",
                  password: "123456",
                  role: "2",
                  pos: "1",
                  dob: "1994-03-09",
              },
    });
    const onSubmit = (data) => {
        if (!isModeEdit) {
            router.post(route("taikhoan.store"), data, {
                onError: (errors) => {
                    toast.error("Tài khoản đã tồn tại !");
                },
                onSuccess: (data) => {
                    toast.success("Thêm tà khoản thành công !");
                },
            });
        } else {
            router.put(route("taikhoan.update", user.id), data, {
                onError: (errors) => {
                    toast.error("Tài khoản đã tồn tại !");
                },
                onSuccess: (data) => {
                    toast.success("Thêm tà khoản thành công !");
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
                        {isModeEdit ? "Sửa tài khoản" : "Thêm mới tài khoản"}
                    </h2>
                    <Link
                        className="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
                        href={route("taikhoan.index")}
                    >
                        Danh sách tài khoản
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
                            name="fullName"
                            className="mt-1 block w-full"
                            label="Họ và tên"
                            rules={{ required: "Họ và tên không để trống" }}
                        />
                        <InputControl
                            control={control}
                            name="phone"
                            label="Số điện thoại"
                            className="mt-1 block w-full"
                            rules={{ required: "Số điện thoại không để trống" }}
                        />
                    </div>
                    <div className="grid grid-cols-2 gap-10 mt-7">
                        <InputControl
                            control={control}
                            name="address"
                            className="mt-1 block w-full"
                            label="Địa chỉ"
                            rules={{ required: "Địa chỉ không để trống" }}
                        />
                        <InputControl
                            control={control}
                            name="dob"
                            className="mt-1 block w-full"
                            label="Ngày sinh"
                            type="date"
                            rules={{ required: "Ngày sinh không để trống" }}
                        />
                    </div>
                    <div className="grid grid-cols-2 gap-10 mt-7">
                        <InputControl
                            control={control}
                            name="username"
                            className="mt-1 block w-full"
                            label="Tên tài khoản"
                            rules={{ required: "Tên tài khoản không để trống" }}
                        />
                        {isModeEdit ? null : (
                            <InputControl
                                control={control}
                                name="password"
                                className="mt-1 block w-full"
                                label="Mật khẩu"
                                type="password"
                                rules={{ required: "Mật khẩu không để trống" }}
                            />
                        )}
                    </div>
                    <div className="grid grid-cols-2 gap-10 mt-7">
                        <div>
                            <InputLabel htmlFor="role" value="Quyền" />
                            <select
                                {...register("role")}
                                id="role"
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            >
                                <option value="2">Bác sĩ</option>
                                <option value="3">Y tá</option>
                                <option value="4">Lễ tân</option>
                            </select>
                        </div>
                        <div>
                            <InputLabel htmlFor="pos" value="Chức vụ" />
                            <select
                                {...register("pos")}
                                id="pos"
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            >
                                <option value="1">Bác sĩ</option>
                                <option value="2">Y tá</option>
                                <option value="3">Lễ tân</option>
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
