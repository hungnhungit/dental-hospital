import InputLabel from "@/Components/InputLabel";
import PageContainer from "@/Components/PageContainer";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import { Head } from "@inertiajs/react";

export default function RegisterExaminationSchedule(props) {
    return (
        <>
            <Head title="Đăng ký khám bệnh" />
            <PageContainer>
                <h1 className="font-bold">Đăng ký khám bệnh</h1>
                <form className="mt-4">
                    <div className="grid grid-cols-2 gap-10">
                        <div>
                            <InputLabel
                                htmlFor="password"
                                value="Tên bệnh nhân"
                            />

                            <TextInput
                                id="password"
                                type="text"
                                name="password"
                                className="mt-1 block w-full"
                            />
                        </div>
                        <div>
                            <InputLabel htmlFor="phone" value="Số điện thoại" />

                            <TextInput
                                id="phone"
                                type="text"
                                name="phone"
                                maxLength={11}
                                className="mt-1 block w-full"
                            />
                        </div>
                    </div>
                    <div className="grid grid-cols-2 gap-10 mt-7">
                        <div>
                            <InputLabel htmlFor="address" value="Địa chỉ" />

                            <TextInput
                                id="address"
                                type="text"
                                name="address"
                                className="mt-1 block w-full"
                            />
                        </div>
                        <div>
                            <InputLabel htmlFor="cccd" value="CCCD" />

                            <TextInput
                                id="cccd"
                                type="text"
                                name="cccd"
                                maxLength={11}
                                className="mt-1 block w-full"
                            />
                        </div>
                    </div>
                    <div className="grid grid-cols-2 gap-10 mt-7">
                        <div>
                            <InputLabel htmlFor="pick" value="Bác sĩ khám" />

                            <select
                                id="pick"
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >
                                <option>Doctor 1</option>
                                <option>Doctor 2</option>
                                <option>Doctor 3</option>
                                <option>Doctor 4</option>
                            </select>
                        </div>
                        <div>
                            <InputLabel
                                htmlFor="registerDate"
                                value="Ngày khám"
                            />

                            <TextInput
                                id="registerDate"
                                type="date"
                                name="registerDate"
                                className="mt-1 block w-full"
                            />
                        </div>
                    </div>
                    <PrimaryButton className="mt-4">Đăng ký</PrimaryButton>
                </form>
            </PageContainer>
        </>
    );
}
