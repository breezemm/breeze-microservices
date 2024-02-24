import {API_URL} from "~/config";
import Axios from 'axios';

export const axios = Axios.create({
  baseURL: API_URL,
});

axios.defaults.withCredentials = true;

axios.interceptors.request.use((config) => {
  const token = JSON.parse(localStorage.getItem('access_token')! as string) ?? null;

  if (!token) {
    throw new Error('Token not found');
  }

  config.headers.Authorization = `Bearer ${token}`;

  return config;
});
