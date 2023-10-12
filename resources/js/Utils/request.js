import _get from "lodash/get";

class RequestError extends Error {}

function createRequest() {
    const ins = axios.create({
        baseURL: "/api",
    });

    ins.interceptors.response.use(
        (val) => {
            return _get(val.data, "data", val.data);
        },
        (err) => {
            const responseData = _get(err, "response.data") ?? {};
            let errorMsg = responseData.message;
            throw new RequestError(errorMsg ?? err.message);
        }
    );

    return ins;
}

export const request = createRequest();
