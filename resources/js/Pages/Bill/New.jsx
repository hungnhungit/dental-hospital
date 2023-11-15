import InputControl from "@/Components/InputControl";
import InputLabel from "@/Components/InputLabel";
import PageContainer from "@/Components/PageContainer";
import PrimaryButton from "@/Components/PrimaryButton";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import _get from "lodash/get";
import { useFieldArray, useForm } from "react-hook-form";
import { toast } from "react-toastify";
import { FaTrash } from "react-icons/fa";
import InputError from "@/Components/InputError";
import { formatNumber } from "@/Utils/helpers";
import { useMemo } from "react";
import { filter, isEmpty, keyBy, reduce, size } from "lodash";

export default function NewBill(props) {
    const { bill, DichVu } = props;
    const isModeEdit = bill ? true : false;

    const { register, handleSubmit, control, watch } = useForm({
        defaultValues: isModeEdit
            ? bill
            : {
                  TenHoaDon: "BILL-" + Math.floor(Math.random() * 100000),
              },
    });
    const { fields, append, remove } = useFieldArray({
        control, // control props comes from useForm (optional: if you are using FormContext)
        name: "services", // unique name for your Field Array
    });
    const wServices = watch("services");

    const servicesKeyBy = useMemo(() => {
        return keyBy(DichVu, "id");
    }, [DichVu]);

    const total = reduce(
        filter(wServices, (s) => !isEmpty(s?.DichVuId) && !isEmpty(s?.SoLuong)),
        (sum, item) => {
            return sum + servicesKeyBy[item.DichVuId].p * item.SoLuong;
        },
        0
    );

    const onSubmit = (data) => {
        if (!isModeEdit) {
            if (!size(wServices)) {
                toast.warn("Chưa có dịch vụ !");
                return;
            }
            router.post("/hoadon", {
                ...data,
                TongSoTien: total,
            });
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
                        <div>
                            <InputLabel
                                htmlFor="MaBenhNhan"
                                value="Tiến trình điều trị"
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
                        <InputControl
                            type="number"
                            control={control}
                            name="GiamGia"
                            className="mt-1 block w-full"
                            label="Giảm giá"
                            rules={{
                                max: {
                                    value: 100,
                                    message: "Nhập mã giảm giá khoảng 0 - 100",
                                },
                            }}
                        />
                    </div>
                    <div>
                        {fields.map((field, index) => (
                            <div
                                key={field.id}
                                className="grid grid-cols-4 gap-10 mt-5 items-center"
                            >
                                <div>
                                    <InputLabel value="Dịch vụ" required />
                                    <select
                                        {...register(
                                            `services.${index}.DichVuId`,
                                            { required: true }
                                        )}
                                        className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    >
                                        <option key="empty" value="">
                                            Chọn dịch vụ
                                        </option>
                                        {_get(props, "DichVu", []).map(
                                            (item, index) => {
                                                return (
                                                    <option
                                                        key={index}
                                                        value={item.id}
                                                    >
                                                        {item.name} -{" "}
                                                        {formatNumber(item.p)}
                                                    </option>
                                                );
                                            }
                                        )}
                                    </select>
                                </div>
                                <div className="flex flex-col items-start">
                                    <InputLabel value="Số lượng" required />
                                    <input
                                        {...register(
                                            `services.${index}.SoLuong`,
                                            { required: true }
                                        )}
                                        type="number"
                                        className="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5"
                                    />
                                </div>
                                <FaTrash
                                    className="cursor-pointer h-[20px] w-[20px] relative top-3"
                                    onClick={() => remove(index)}
                                />
                            </div>
                        ))}
                    </div>
                    <div className="mt-5">Tổng tiền: {formatNumber(total)}</div>
                    <div className="mt-5">
                        <PrimaryButton
                            onClick={() => {
                                append([
                                    {
                                        DichVuId: "",
                                        SoLuong: "",
                                    },
                                ]);
                            }}
                            type="button"
                        >
                            thêm dịch vụ
                        </PrimaryButton>
                    </div>
                    <div className="flex gap-2 items-center mt-4">
                        <PrimaryButton type="submit">
                            {isModeEdit ? "Sửa" : "Thêm mới"}
                        </PrimaryButton>
                    </div>
                </form>
            </PageContainer>
        </AuthenticatedLayout>
    );
}
