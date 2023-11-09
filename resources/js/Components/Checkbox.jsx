export default function Checkbox({ label = "", className = "", id, ...props }) {
    return (
        <div className="flex gap-2 items-center">
            <input
                {...props}
                type="checkbox"
                className={
                    "rounded border-gray-300 text-indigo-600 shadow-sm " +
                    className
                }
                id={id}
            />
            <label className="cursor-pointer" htmlFor={id}>
                {label}
            </label>
        </div>
    );
}
