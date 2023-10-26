const common = [
    { name: "dashboard", label: "Tổng quan" },
    { name: "benhnhan.index", label: "Bệnh nhân" },
    { name: "thuoc.index", label: "Thuốc" },
    { name: "vat-tu.index", label: "Vật tư" },
];

const MENUS = {
    admin: [
        { name: "dashboard", label: "Tổng quan" },
        { name: "users.list", label: "Tài khoản" },
        { name: "tin-tuc.index", label: "Tin tức" },
        { name: "loai-tin-tuc.index", label: "Loại tin tức" },
    ],
    doctor: [
        { name: "benhnhan.index", label: "Bệnh nhân" },
        { name: "sokhambenh.index", label: "Sổ khám bệnh" },
        { name: "profile.edit", label: "Cài đặt" },
    ],
    nurse: [
        ...common,
        { name: "sokhambenh.index", label: "Sổ khám bệnh" },
        { name: "profile.edit", label: "Cài đặt" },
    ],
    receptionist: [
        ...common,
        { name: "hoadon.index", label: "Hoá đơn" },
        { name: "dichvu.index", label: "Dịch vụ" },
        { name: "loai-dich-vu.index", label: "Loại dịch vụ" },
        { name: "donvitinh.index", label: "Đơn vị tính" },
        { name: "loai-vat-tu.index", label: "Loại vật tư" },
        { name: "loai-thuoc.index", label: "Loại thuốc" },
        { name: "sokhambenh.index", label: "Sổ khám bệnh" },
        { name: "profile.edit", label: "Cài đặt" },
    ],
};

export { MENUS };
