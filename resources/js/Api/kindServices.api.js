import { request } from "@/Utils/request";

const paginate = async () => {
    return await request.get("kind-services");
};

export { paginate };
