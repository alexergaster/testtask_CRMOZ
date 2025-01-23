import axios from "axios";

const API_URL = "http://127.0.0.1:8000/api/";

const api = axios.create({
  baseURL: API_URL,
});

export const createAccount = async (data) => {
  try {
    const result = await api.post("/account/create", data);

    return result.data;
  } catch (errors) {
    return errors.response.data;
  }
};

export const createDeal = async (data) => {
  try {
    const result = await api.post("/deal/create", data);

    return result.data;
  } catch (errors) {
    return errors.response.data;
  }
};
