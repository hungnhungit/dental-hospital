import InputControl from "@/Components/InputControl";
import InputLabel from "@/Components/InputLabel";
import PageContainer from "@/Components/PageContainer";
import PrimaryButton from "@/Components/PrimaryButton";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import _get from "lodash/get";
import { useForm } from "react-hook-form";
import { toast } from "react-toastify";
import { format } from "date-fns";
import { useEffect, useMemo, useRef, useState } from "react";
import { yupResolver } from "@hookform/resolvers/yup";
import * as yup from "yup";
import SecondaryButton from "@/Components/SecondaryButton";
import { request } from "@/Utils/request";
import { isEmpty, isNumber, omit } from "lodash";

const schema = yup
    .object({
        Sothuoc: yup
            .string()
            .nullable()
            .when("MaThuoc", (maThuoc, schema) => {
                if (!isEmpty(maThuoc[0])) {
                    return schema.required(
                        "Số lượng thuốc không được để trống"
                    );
                }
                return schema;
            }),
        SoVatTu: yup
            .string()
            .nullable()
            .when("MaVatTu", (maVatTu, schema) => {
                if (!isEmpty(maVatTu[0])) {
                    return schema.required("Số lượng vật tư không để trống");
                }
                return schema;
            }),
        NgayDieuTri: yup.string().required("Ngày điều trị không để trống"),
        ChiTietDieuTri: yup
            .string()
            .required("Chi tiết điều trị không để trống"),
        MaThuoc: yup.string().nullable(),
        MaVatTu: yup.string().nullable(),
    })
    .required();

export default function NewProccess(props) {
    const { process, SoKhamBenhId } = props;
    const isModeEdit = process ? true : false;
    const fileRef = useRef(null);
    const [img, setImg] = useState(process?.LinkHinhAnh || null);
    const { register, handleSubmit, watch, setValue, clearErrors, control } =
        useForm({
            resolver: yupResolver(schema),
            criteriaMode: "all",
            defaultValues: isModeEdit
                ? process
                : {
                      NgayDieuTri: format(new Date(), "yyyy-MM-dd"),
                      TenTienTrinh:
                          "TTDT-" + Math.floor(Math.random() * 100000),
                  },
        });
    const MaThuoc = watch("MaThuoc");
    const MaVatTu = watch("MaVatTu");
    const hasMedicine = useMemo(() => {
        if (MaThuoc === undefined || MaThuoc === "" || MaThuoc === null) {
            return false;
        }
        return true;
    }, [MaThuoc]);
    const hasSupplier = useMemo(() => {
        if (MaVatTu === undefined || MaVatTu === "" || MaVatTu === null) {
            return false;
        }
        return true;
    }, [MaVatTu]);
    useEffect(() => {
        const subscription = watch((value, { name, type }) => {
            if (name === "MaThuoc" && type === "change") {
                if (value[name] === "") {
                    clearErrors("Sothuoc");
                    setValue("Sothuoc", "");
                }
            }
            if (name === "MaVatTu" && type === "change") {
                if (value[name] === "") {
                    clearErrors("SoVatTu");
                    setValue("SoVatTu", "");
                }
            }
        });
        return () => subscription.unsubscribe();
    }, []);

    const onSubmit = (data) => {
        if (!isModeEdit) {
            router.post(route("tientrinhdieutri.store", SoKhamBenhId), data, {
                onSuccess: () => {
                    toast.success("Sửa tiến trình điều trị thành công !");
                },
                onError: ({ message }) => {
                    if (message === "QUANTITY_LIMIT_SUPPLIES") {
                        toast.error("Vật tư không đủ !");
                    }
                    if (message === "QUANTITY_LIMIT_MEDICINE") {
                        toast.error("Thuốc không đủ !");
                    }
                },
            });
        } else {
            router.put(
                route("tientrinhdieutri.update", [SoKhamBenhId, process["Id"]]),
                omit(data, ["LinkHinhAnh"]),
                {
                    onSuccess: () => {
                        toast.success("Sửa tiến trình điều trị thành công !");
                    },
                }
            );
        }
    };

    const upload = async (file) => {
        const form = new FormData();
        form.append("file", file);
        try {
            const res = await request.post(route("upload.handle"), form);
            console.log(res);
            setImg(res.link);
            setValue("HinhAnhXetNghiem", res.fileName);
        } catch (error) {}
    };

    const handleSelectFile = (e) => {
        if (e.target.files && e.target.files.length > 0) {
            const pickedFile = e.target.files[0];
            if (!pickedFile) {
                return;
            }

            const reader = new FileReader();
            reader.addEventListener("load", () => {
                if (reader.result) {
                    upload(pickedFile);
                }
            });
            reader.readAsDataURL(pickedFile);

            e.target.files = null;
            e.target.value = "";
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
                            ? "sửa tiến trình điều trị"
                            : "thêm mới tiến trình điều trị"}
                    </h2>
                    <Link
                        className="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
                        href={route("sokhambenh.show", SoKhamBenhId)}
                    >
                        Sổ khám bệnh
                    </Link>
                </div>
            }
        >
            <Head title="Thêm mới tiến trình điều trị" />

            <PageContainer>
                <form className="mt-4" onSubmit={handleSubmit(onSubmit)}>
                    <div className="grid grid-cols-2 gap-10">
                        <div className="grid grid-cols-2 gap-10">
                            <div>
                                <InputLabel htmlFor="Thuoc" value="Thuốc" />
                                <select
                                    {...register("MaThuoc")}
                                    id="Thuoc"
                                    className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                >
                                    <option key="khongdungthuoc" value="">
                                        Không dùng
                                    </option>
                                    {_get(props, "Thuoc", []).map(
                                        (item, index) => {
                                            return (
                                                <option
                                                    key={index}
                                                    value={item.id}
                                                >
                                                    {item.name} -{" "}
                                                    {item.q === 0
                                                        ? "Hết thuốc"
                                                        : item.q}
                                                </option>
                                            );
                                        }
                                    )}
                                </select>
                            </div>
                            <InputControl
                                type="number"
                                control={control}
                                name="Sothuoc"
                                disabled={!hasMedicine}
                                className="mt-1 block w-full"
                                label="Số lượng thuốc"
                                required={hasMedicine}
                            />
                        </div>
                        <div className="grid grid-cols-2 gap-10">
                            <div>
                                <InputLabel htmlFor="MaVatTu" value="Vật tư" />
                                <select
                                    {...register("MaVatTu")}
                                    id="MaVatTu"
                                    className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                >
                                    <option key="khongdungvattu" value="">
                                        Không dùng
                                    </option>
                                    {_get(props, "VatTu", []).map(
                                        (item, index) => {
                                            return (
                                                <option
                                                    key={index}
                                                    value={item.id}
                                                >
                                                    {item.name} -{" "}
                                                    {item.q === 0
                                                        ? "Hết vật tư"
                                                        : item.q}
                                                </option>
                                            );
                                        }
                                    )}
                                </select>
                            </div>
                            <InputControl
                                type="number"
                                control={control}
                                name="SoVatTu"
                                className="mt-1 block w-full"
                                label="Số lượng vật tư"
                                disabled={!hasSupplier}
                                required={hasSupplier}
                            />
                        </div>
                    </div>
                    <div className="grid grid-cols-2 gap-10 mt-5">
                        <InputControl
                            control={control}
                            type="date"
                            name="NgayDieuTri"
                            className="mt-1 block w-full"
                            label="Ngày điều trị"
                            required
                        />
                        <InputControl
                            control={control}
                            name="ChiTietDieuTri"
                            className="mt-1 block w-full"
                            label="Chi tiết điều trị"
                            required
                        />
                    </div>
                    <div className="mt-5">
                        <SecondaryButton
                            onClick={() => {
                                if (img) {
                                    setImg(null);
                                    setValue("HinhAnhXetNghiem", null);
                                } else {
                                    fileRef.current?.click();
                                }
                            }}
                        >
                            {img
                                ? "Xoá Hình ảnh xét nghiệm"
                                : "Chọn Hình ảnh xét nghiệm"}
                        </SecondaryButton>
                        <input
                            className="hidden"
                            ref={fileRef}
                            accept="image/*"
                            onChange={handleSelectFile}
                            type="file"
                        />
                        {img ? (
                            <img
                                src={img}
                                alt=""
                                className="h-[300px] w-[300px] mt-5 object-cover"
                            />
                        ) : null}
                    </div>
                    <PrimaryButton type="submit" className="mt-4">
                        {isModeEdit ? "Sửa" : "Thêm mới"}
                    </PrimaryButton>
                </form>
            </PageContainer>
        </AuthenticatedLayout>
    );
}
