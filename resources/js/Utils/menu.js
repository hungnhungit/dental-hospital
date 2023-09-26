const common = [
    { name: "dashboard", label: "Tổng quan" },
    { name: "patients.list", label: "QL bệnh nhân" },
    { name: "examination_schedule.list", label: "QL lịch khám" },
];

const MENUS = {
    admin: [
        { name: "dashboard", label: "Tổng quan" },
        { name: "users.list", label: "QL tài khoản" },
        { name: "news.list", label: "QL tin tức" },
        { name: "kind_new.list", label: "QL loại tin tức" },
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
    ],
};

export { MENUS };
