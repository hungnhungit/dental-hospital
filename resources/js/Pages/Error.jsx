import { Head } from "@inertiajs/react";

const mapCode = {
    503: "503: Service Unavailable",
    500: "500: Server Error",
    404: "404: Page Not Found",
    403: "403: Forbidden",
};

const mapDescription = {
    503: "Sorry, we are doing some maintenance. Please check back soon.",
    500: "Whoops, something went wrong on our servers.",
    404: "Sorry, the page you are looking for could not be found.",
    403: "Sorry, you are forbidden from accessing this page.",
};

export default function Error(props) {
    const { status } = props;
    return (
        <div>
            <Head title="Error" />
            <div className="flex flex-col items-center justify-center w-screen h-screen gap-12 py-8 ">
                <div className="flex flex-col items-center gap-4">
                    <h1 className="text-3xl font-medium text-center">
                        {mapCode[status]}
                    </h1>
                    <p className="text-xl text-center ">
                        You tried to access a page you did not have prior
                        {mapDescription[status]}
                    </p>
                </div>
            </div>
        </div>
    );
}
