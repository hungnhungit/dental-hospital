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
        ...common,
        { name: "sick.list", label: "QL tình trạng bệnh" },
        { name: "health_records.list", label: "QL sổ khám bệnh" },
    ],
    nurse: [
        ...common,
        { name: "sick.list", label: "QL tình trạng bệnh" },
        { name: "health_records.list", label: "QL sổ khám bệnh" },
    ],
    receptionist: [
        ...common,
        { name: "hoadon.index", label: "Hoá đơn" },
        { name: "dichvu.index", label: "Dịch vụ" },
        { name: "loai-dich-vu.index", label: "Loại dịch vụ" },
        { name: "donvitinh.index", label: "Đơn vị tính" },
        { name: "loai-vat-tu.index", label: "Loại vật tư" },
        { name: "loai-thuoc.index", label: "Loại thuốc" },
    ],
};

export { MENUS };
