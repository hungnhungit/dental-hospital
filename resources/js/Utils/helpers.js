import { lowerCase } from "lodash";

const ROLE_MAP_TO_POSTION = {
    admin: "Quản trị",
    doctor: "Bác sĩ",
    nurse: "Y tá",
    receptionist: "Lễ tân",
};

const STATUS_MAP_TO_STATUS_TEXT = {
    ChuaThanhToan: "Chờ thanh toán",
    DaThanhToan: "Đã thanh toán",
    Huy: "Hủy thanh toán",
};

const PAYMENT_MAP_TO_PAYMENT_TEXT = {
    ck: "Chuyển khoản",
    tm: "Tiền mặt",
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

const formatNumber = (number, currency = "VND") => {
    const nf = new Intl.NumberFormat();
    return `${nf.format(number)} ${currency}`;
};

export { getPostion, getStatusText, getPaymentText, formatNumber };
