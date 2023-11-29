import { lowerCase } from "lodash";

const ROLE_MAP_TO_POSTION = {
    admin: "Quản trị",
    doctor: "Bác sĩ",
    nurse: "Y tá",
    receptionist: "Lễ tân",
    supperadmin: "Lãnh đạo",
};

const STATUS_MAP_TO_STATUS_TEXT = {
    ChuaThanhToan: "Chờ thanh toán",
    DaThanhToan: "Đã thanh toán",
    Huy: "Hủy thanh toán",
};

const STATUS_RECORD_MAP_TO_STATUS_TEXT = {
    ChoPheDuyet: "Chờ phê duyệt",
    DangDieutri: "Đang điều trị",
    Huy: "Hủy bỏ",
    ThanhCong: "Thành công",
};

const PAYMENT_MAP_TO_PAYMENT_TEXT = {
    ck: "Chuyển khoản",
    tm: "Tiền mặt",
};

const isReceptionist = (role) => {
    return role === "receptionist";
};

const isDoctor = (role) => {
    return role === "doctor";
};

const getPostion = (role) => {
    return ROLE_MAP_TO_POSTION[role];
};

const getStatusText = (status) => {
    return STATUS_MAP_TO_STATUS_TEXT[status];
};

const getPaymentText = (payment) => {
    return PAYMENT_MAP_TO_PAYMENT_TEXT[lowerCase(payment)];
};

const getRecordsText = (records) => {
    return STATUS_RECORD_MAP_TO_STATUS_TEXT[records];
};

const formatNumber = (number, currency = "VND") => {
    const nf = new Intl.NumberFormat();
    return `${nf.format(number)} ${currency}`;
};

export {
    getPostion,
    getStatusText,
    getPaymentText,
    formatNumber,
    isReceptionist,
    getRecordsText,
    isDoctor,
};
