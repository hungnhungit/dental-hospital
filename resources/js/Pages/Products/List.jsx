import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import PageContainer from '@/Components/PageContainer';
import { Head } from '@inertiajs/react';

export default function ListUser(props) {
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">QL tài khoản</h2>}
        >
            <Head title="QL tài khoản" />

            <PageContainer>
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sit mollitia, reprehenderit necessitatibus quidem tempore ea voluptatum, provident, excepturi sint laudantium error? Dolor fugit odit consequatur mollitia commodi ipsum tempora at distinctio assumenda voluptatem perspiciatis, sed velit vitae quae quasi officiis! Placeat possimus impedit cumque eveniet ex nobis repudiandae natus dolores?
            </PageContainer>
        </AuthenticatedLayout>
    );
}
