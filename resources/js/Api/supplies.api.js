import { request } from "@/Utils/request";

const paginate = async () => {
    return await request.get("supplies");
};

export { paginate };
