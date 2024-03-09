import axios from "axios";

export const getToken = async () => {
    await axios.get("/sanctum/csrf-cookie");
};