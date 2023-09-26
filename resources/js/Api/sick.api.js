import { request } from "@/Utils/request";

const paginate = async () => {
    return await request.get("sick");
};

export { paginate };
