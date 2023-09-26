import { request } from "@/Utils/request";

const paginate = async () => {
    return await request.get("users");
};

const destroy = async (id) => {
    return await request.delete("users", {
        data: {
            id,
        },
    });
};

export { destroy, paginate };
