import Checkbox from "@/Components/Checkbox";
import PageContainer from "@/Components/PageContainer";
import PrimaryButton from "@/Components/PrimaryButton";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { getPostion } from "@/Utils/helpers";
import { Head, Link, router } from "@inertiajs/react";
import { chunk, findIndex, partition, values } from "lodash";
import { useState } from "react";
import { toast } from "react-toastify";

const MAP_GROUP_TO_TEXT = {
    ["thuoc"]: "Thuốc",
    ["vat-tu"]: "Vật tư",
    ["dichvu"]: "Dịch vụ",
    ["benhnhan"]: "Bệnh nhân",
    ["donvitinh"]: "Đơn vị tính",
    ["sokhambenh"]: "Sổ khám bệnh",
    ["hoadon"]: "Hoá đơn",
    ["tientrinhdieutri"]: "Tiến trình điều trị",
};

const MAP_PERMISSION_TO_LABEL = {
    ["thuoc.index"]: "Danh sách thuốc",
    ["thuoc.store"]: "Thêm thuốc",
    ["thuoc.update"]: "Sửa thuốc",
    ["thuoc.destroy"]: "Xoá thuốc",

    ["vat-tu.index"]: "Danh sách vật tư",
    ["vat-tu.store"]: "Thêm vật tư",
    ["vat-tu.update"]: "Sửa vật tư",
    ["vat-tu.destroy"]: "Xoá vật tư",

    ["hoadon.index"]: "Danh sách hoá đơn",
    ["hoadon.store"]: "Thêm hoá đơn",
    ["hoadon.update"]: "Sửa hoá đơn",
    ["hoadon.destroy"]: "Xoá hoá đơn",
    ["hoadon.print"]: "Xoá hoá đơn",

    ["benhnhan.index"]: "Danh sách bệnh nhân",
    ["benhnhan.store"]: "Thêm bệnh nhân",
    ["benhnhan.update"]: "Sửa bệnh nhân",
    ["benhnhan.destroy"]: "Xoá bệnh nhân",

    ["dichvu.index"]: "Danh sách dịch vụ",
    ["dichvu.store"]: "Thêm dịch vụ",
    ["dichvu.update"]: "Sửa dịch vụ",
    ["dichvu.destroy"]: "Xoá dịch vụ",

    ["donvitinh.index"]: "Danh sách đơn vị tính",
    ["donvitinh.store"]: "Thêm đơn vị tính",
    ["donvitinh.update"]: "Sửa đơn vị tính",
    ["donvitinh.destroy"]: "Xoá đơn vị tính",

    ["sokhambenh.index"]: "Danh sách sổ khám bệnh",
    ["sokhambenh.store"]: "Thêm sổ khám bệnh",
    ["sokhambenh.update"]: "Sửa sổ khám bệnh",
    ["sokhambenh.destroy"]: "Xoá sổ khám bệnh",

    ["tientrinhdieutri.index"]: "Danh sách tiến trình điều trị",
    ["tientrinhdieutri.store"]: "Thêm tiến trình điều trị",
    ["tientrinhdieutri.update"]: "Sửa tiến trình điều trị",
    ["tientrinhdieutri.destroy"]: "Xoá tiến trình điều trị",
};

export default function RoleSettings(props) {
    const { role, permssions, kindP } = props;
    const [permissions, setPermissions] = useState(values(permssions));
    const [kindPermission, setKindPermission] = useState(kindP);
    const handleOnChangePermission = (permission, on) => {
        const index = findIndex(permissions, { permission });

        setPermissions((prev) => {
            prev[index].on = on;
            return [...prev];
        });
    };

    const onSave = () => {
        const [permissionsOn, permissionsOff] = partition(
            permssions,
            (p) => p.on
        );

        router.post(
            route("quyen.update", role["Id"]),
            {
                permissionsOn,
                permissionsOff,
                kindPermission,
            },
            {
                onSuccess: () => {
                    toast.success("Lưu quyền thành công !");
                },
            }
        );
    };

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <div className="flex justify-between">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight uppercase"></h2>
                    <Link
                        className="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
                        href={route("quyen.index")}
                    >
                        Danh sách quyền
                    </Link>
                </div>
            }
        >
            <Head title="Cài đặt" />

            <PageContainer>
                <h3 className="text-lg mb-10">
                    Quyền: <strong>{getPostion(role["Quyen"])}</strong>
                </h3>
                <div className="mb-5">
                    <Checkbox
                        key="loai"
                        id="loai"
                        label="Loại (Thuốc, Vật tư, Dịch vụ)"
                        checked={kindPermission}
                        value={kindPermission}
                        onChange={(e) => setKindPermission(e.target.checked)}
                    />
                </div>
                <div className="grid grid-cols-3 gap-10">
                    {chunk(permissions, 4).map((chunk, index) => {
                        const group = chunk[0].permission.split(".")[0];
                        return (
                            <div key={`chunk-${index}`}>
                                <h3 className="text-lg font-semibold mb-1">
                                    {MAP_GROUP_TO_TEXT[group]}
                                </h3>
                                {chunk.map(({ permission, on }) => {
                                    const label =
                                        MAP_PERMISSION_TO_LABEL[permission];
                                    return (
                                        <Checkbox
                                            key={permission}
                                            id={permission}
                                            label={label}
                                            value={on}
                                            checked={on}
                                            onChange={(e) =>
                                                handleOnChangePermission(
                                                    permission,
                                                    e.target.checked
                                                )
                                            }
                                        />
                                    );
                                })}
                            </div>
                        );
                    })}
                </div>

                <div className="mt-10">
                    <PrimaryButton onClick={onSave}>Lưu thay đổi</PrimaryButton>
                </div>
            </PageContainer>
        </AuthenticatedLayout>
    );
}
