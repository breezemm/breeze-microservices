import {API_URL} from "~/config";
import Axios from 'axios';

export const axios = Axios.create({
  baseURL: API_URL,
});

axios.interceptors.request.use((config) => {
  const token = '123'
  if (token) {
    config.headers.authorization = `${token}`;
  }
  config.headers.Accept = 'application/json';

  return config;
});
