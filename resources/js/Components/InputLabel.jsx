export default function InputLabel({
    value,
    className = "",
    required = false,
    children,
    ...props
}) {
    return (
        <label
            {...props}
            className={
                `block font-medium text-sm text-gray-700 flex gap-1` + className
            }
        >
            {value ? value : children}
            {required ? (
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="10"
                    height="10"
                    viewBox="0 0 10 10"
                >
                    <path
                        id="np_required_1371262_000000"
                        d="M24.341,22.305c0,.267.153.331.342.142l2.1-2.1a.455.455,0,0,1,.643.643l-2.1,2.1c-.189.189-.126.342.142.342h2.968a.455.455,0,0,1,0,.909H25.468c-.267,0-.331.153-.142.342l2.1,2.1a.455.455,0,0,1-.643.643l-2.1-2.1c-.189-.189-.342-.126-.342.142v2.968a.455.455,0,0,1-.909,0V25.468c0-.267-.153-.331-.342-.142l-2.1,2.1a.455.455,0,0,1-.643-.643l2.1-2.1c.189-.189.126-.342-.142-.342H19.337a.455.455,0,0,1,0-.909h2.968c.267,0,.331-.153.142-.342l-2.1-2.1a.455.455,0,0,1,.643-.643l2.1,2.1c.189.189.342.126.342-.142V19.337a.455.455,0,0,1,.909,0Z"
                        transform="translate(-18.886 -18.886)"
                        fill="#dd4f4f"
                        fillRule="evenodd"
                    />
                </svg>
            ) : null}
        </label>
    );
}
