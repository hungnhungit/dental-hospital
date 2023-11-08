import { router } from "@inertiajs/react";

const getRouter = (qs) => {
    router.get(
        route(route().current()),
        { ...route().params, ...qs },
        {
            replace: true,
            preserveState: true,
            preserveScroll: true,
        }
    );
};

export { getRouter };
