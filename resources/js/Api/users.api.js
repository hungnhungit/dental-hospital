import { request } from "@/Utils/request";

const paginate = async () => {
    return await request.get("users");
};

const create = async (body) => {
    console.log(body);
    return await request.post("users", body);
};

const destroy = async (id) => {
    return await request.delete("users", {
        data: {
            id,
        },
    });
};

export { create, destroy, paginate };
