import qs from "query-string";
import { useState } from "react";
import TextInput from "./TextInput";

const InputSearch = ({ onSearch, placeholder }) => {
    const { q } = qs.parse(location.search);
    const [query, setQuery] = useState(q || "");
    const search = (event) => {
        if (event.key == "Enter") {
            onSearch(query);
        }
    };
    return (
        <TextInput
            className="w-[400px]"
            placeholder={`Tìm kiếm theo ${placeholder}`}
            value={query}
            onChange={(e) => setQuery(e.target.value)}
            onKeyPress={search}
        />
    );
};

export default InputSearch;
