import InputControl from "@/Components/InputControl";
import InputLabel from "@/Components/InputLabel";
import PageContainer from "@/Components/PageContainer";
import PrimaryButton from "@/Components/PrimaryButton";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import _get from "lodash/get";
import { Controller, useForm } from "react-hook-form";
import ReactQuill from "react-quill";
import "react-quill/dist/quill.snow.css";
import { toast } from "react-toastify";

const modules = {
    toolbar: [
        [{ header: [1, 2, false] }],
        ["bold", "italic", "underline", "strike", "blockquote"],
        [
            { list: "ordered" },
            { list: "bullet" },
            { indent: "-1" },
            { indent: "+1" },
        ],
        ["link", "image"],
        ["clean"],
    ],
};

const formats = [
    "header",
    "bold",
    "italic",
    "underline",
    "strike",
    "blockquote",
    "list",
    "bullet",
    "indent",
    "link",
    "image",
];

export default function NewKindNew(props) {
    console.log(props);
    const { news } = props;
    const isModeEdit = news ? true : false;

    const { register, handleSubmit, control } = useForm({
        defaultValues: isModeEdit ? news : {},
    });

    const onSubmit = (data) => {
        console.log(data);
        if (!isModeEdit) {
            router.post("/tin-tuc", data);
            toast.success("Thêm tin tức thành công !");
        } else {
            router.put(`/tin-tuc/${news.id}`, data);
            toast.success("Sửa tin tức thành công !");
        }
    };

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <div className="flex justify-between">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight uppercase">
                        {isModeEdit ? "sửa tin tức" : "thêm mới tin tức"}
                    </h2>
                    <Link
                        className="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase"
                        href={route("tin-tuc.index")}
                    >
                        Danh sách tin tức
                    </Link>
                </div>
            }
        >
            <Head title="Thêm mới tin tức" />

            <PageContainer>
                <form className="mt-4" onSubmit={handleSubmit(onSubmit)}>
                    <div className="grid grid-cols-2 gap-10">
                        <InputControl
                            control={control}
                            name="name"
                            className="mt-1 block w-full"
                            label="Tên"
                            maxLength={10}
                            rules={{ required: "Tên không để trống" }}
                        />
                        <div>
                            <InputLabel htmlFor="kind" value="Loại tin tức" />
                            <select
                                {...register("kind")}
                                id="kind"
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            >
                                {_get(props, "kindNews", []).map(
                                    (kind, index) => {
                                        return (
                                            <option key={index} value={kind.id}>
                                                {kind.name}
                                            </option>
                                        );
                                    }
                                )}
                            </select>
                        </div>
                    </div>
                    <div className="mt-5 h-[380px]">
                        <Controller
                            control={control}
                            name="desc"
                            render={({ field: { onChange, value } }) => (
                                <>
                                    <label htmlFor="desc">Miêu tả</label>
                                    <ReactQuill
                                        id="desc"
                                        formats={formats}
                                        style={{
                                            height: 300,
                                        }}
                                        modules={modules}
                                        value={value}
                                        onChange={onChange}
                                    />
                                </>
                            )}
                        />
                    </div>
                    <div>
                        <PrimaryButton type="submit" className="mt-4">
                            {isModeEdit ? "Sửa" : "Thêm mới"}
                        </PrimaryButton>
                    </div>
                </form>
            </PageContainer>
        </AuthenticatedLayout>
    );
}
