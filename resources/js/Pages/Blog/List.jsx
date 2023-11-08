export default function ListBlog(props) {
    return (
        <div className="m-auto w-[1200px] mt-10">
            {props.news.map((item, index) => {
                return (
                    <div key={index} className="mb-10">
                        <div className="flex gap-4 items-center">
                            <h2 className="font-bold text-xl">
                                <a
                                    href=""
                                    className="bg-green-500 bg-green-800 text-white font-bold"
                                >
                                    {item.title}
                                </a>
                            </h2>
                            <span className="">By Admin</span>
                        </div>
                        <p>{item.desc}</p>
                    </div>
                );
            })}
        </div>
    );
}
