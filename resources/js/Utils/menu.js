const common = [
    { name: "dashboard", label: "Trang chủ", permission: "access" },
    {
        name: "benhnhan.index",
        label: "Bệnh nhân",
        permission: "benhnhan.index",
    },
    { name: "thuoc.index", label: "Thuốc", permission: "thuoc.index" },
    { name: "vat-tu.index", label: "Vật tư", permission: "vat-tu.index" },
];

const MENUS = {
    admin: [
        { name: "dashboard", label: "Trang chủ" },
        { name: "taikhoan.index", label: "Tài khoản" },
        { name: "tin-tuc.index", label: "Tin tức" },
        { name: "loai-tin-tuc.index", label: "Loại tin tức" },
        { name: "quyen.index", label: "Quyền" },
    ],
    doctor: [
        {
            name: "benhnhan.index",
            label: "Bệnh nhân",
            permission: "benhnhan.index",
        },
        {
            name: "sokhambenh.index",
            label: "Sổ khám bệnh",
            permission: "sokhambenh.index",
        },
        { name: "profile.edit", label: "Cài đặt" },
    ],
    nurse: [
        ...common,
        {
            name: "sokhambenh.index",
            label: "Sổ khám bệnh",
            permission: "sokhambenh.index",
        },
        { name: "profile.edit", label: "Cài đặt", permission: "access" },
    ],
    receptionist: [
        ...common,
        { name: "hoadon.index", label: "Hoá đơn", permission: "hoadon.index" },
        { name: "dichvu.index", label: "Dịch vụ", permission: "dichvu.index" },
        {
            name: "donvitinh.index",
            label: "Đơn vị tính",
            permission: "donvitinh.index",
        },
        {
            name: "loai-dich-vu.index",
            label: "Loại dịch vụ",
            permission: "loai-dich-vu.index",
        },
        {
            name: "loai-vat-tu.index",
            label: "Loại vật tư",
            permission: "loai-vat-tu.index",
        },
        {
            name: "loai-thuoc.index",
            label: "Loại thuốc",
            permission: "loai-thuoc.index",
        },
        {
            name: "sokhambenh.index",
            label: "Sổ khám bệnh",
            permission: "sokhambenh.index",
        },
        { name: "profile.edit", label: "Cài đặt", permission: "access" },
    ],
};

export { MENUS };
