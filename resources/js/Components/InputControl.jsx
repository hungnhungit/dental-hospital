import cx from "classnames";
import { get } from "lodash";
import { useController } from "react-hook-form";
import InputError from "./InputError";
import InputLabel from "./InputLabel";

export default function InputControl(props) {
    const {
        className,
        label,
        type = "text",
        control,
        name,
        maxLength,
        rules,
        disabled,
        required,
    } = props;
    const {
        field,
        fieldState: { error },
    } = useController({
        name,
        control,
        rules,
    });
    const cls = cx([
        "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5",
        error && "border-red-600",
        className,
    ]);

    const handleOnChange = (e) => {
        if (type === "number") {
            field.onChange(String(e.target.value).replace(/\D/g, ""));
        } else {
            field.onChange(e.target.value);
        }
    };

    return (
        <div className="flex flex-col items-start">
            <InputLabel
                id={name}
                value={label}
                required={required || rules?.required}
            />
            <input
                {...field}
                value={field.value || ""}
                type={type === "number" ? "text" : type}
                className={cls}
                disabled={disabled}
                maxLength={maxLength}
                onChange={handleOnChange}
            />
            {error ? <InputError message={get(error, "message")} /> : null}
        </div>
    );
}
