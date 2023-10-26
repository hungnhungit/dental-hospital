import InputControl from "@/Components/InputControl";
import InputLabel from "@/Components/InputLabel";
import PageContainer from "@/Components/PageContainer";
import PrimaryButton from "@/Components/PrimaryButton";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import _get from "lodash/get";
import { useForm } from "react-hook-form";
import { toast } from "react-toastify";

export default function NewBill(props) {
    const { bill } = props;
    const isModeEdit = bill ? true : false;

    const { register, handleSubmit, control } = useForm({
        defaultValues: isModeEdit
            ? bill
            : {
                  TenHoaDon: "BILL-" + Math.floor(Math.random() * 100000),
              },
    });

    const onSubmit = (data) => {
        if (!isModeEdit) {
            router.post("/hoadon", data);
            toast.success("Thêm hoá đơn thành công !");
        } else {
            router.put(`/hoadon/${bill.Id}`, data);
            toast.success("Sửa hoá đơn thành công !");
        }
    };

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <div className="flex justify-between">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight uppercase">
                        {isModeEdit ? "sửa hoá đơn" : "thêm mới hoá đơn"}
                    </h2>
                    <Link
                        className="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
                        href={route("hoadon.index")}
                    >
                        Danh sách hoá đơn
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
                            name="TenHoaDon"
                            className="mt-1 block w-full"
                            label="Tên hoá đơn"
                            maxLength={10}
                            rules={{
                                required: "Tên hoá đơn không để trống",
                            }}
                            disabled
                        />
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
                                    (item, index) => {
                                        return (
                                            <option key={index} value={item.id}>
                                                {item.name}
                                            </option>
                                        );
                                    }
                                )}
                            </select>
                        </div>
                    </div>
                    <div className="grid grid-cols-2 gap-10 mt-5">
                        <div>
                            <InputLabel
                                htmlFor="MaTienTrinh"
                                value="Tiến trình điều trị"
                            />
                            <select
                                {...register("MaTienTrinh")}
                                id="MaTienTrinh"
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            >
                                {_get(props, "TienTrinhDieuTri", []).map(
                                    (item, index) => {
                                        return (
                                            <option key={index} value={item.id}>
                                                {item.id} - {item.NgayDieuTri}
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
