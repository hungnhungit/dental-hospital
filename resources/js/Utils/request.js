import _get from "lodash/get";

function createRequest() {
    const ins = axios.create({
        baseURL: "/api",
    });

    ins.interceptors.response.use((val) => {
        return _get(val.data, "data", val.data);
    });

    return ins;
}

export const request = createRequest();
