const common = [
    { name: "dashboard", label: "Tổng quan" },
    { name: "patients.list", label: "QL bệnh nhân" },
    { name: "examination_schedule.list", label: "QL lịch khám" },
];

const MENUS = {
    admin: [
        { name: "dashboard", label: "Tổng quan" },
        { name: "users.list", label: "Tài khoản" },
        { name: "news.list", label: "Tin tức" },
        { name: "kind_new.list", label: "Loại tin tức" },
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
        { name: "bills.list", label: "QL hoá đơn" },
        { name: "services.list", label: "QL dịch vụ" },
        { name: "kind_services.list", label: "QL loại dịch vụ" },
        { name: "units.list", label: "Đơn vị tính" },
        { name: "kind_services.list", label: "Loại dịch vụ" },
        { name: "supplies.list", label: "Loại vật tư" },
        { name: "kindMedicine.list", label: "Loại thuốc" },
    ],
};

export { MENUS };
