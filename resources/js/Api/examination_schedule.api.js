import { request } from "@/Utils/request";

const paginate = async () => {
    return await request.get("examination-schedule");
};

export { paginate };
