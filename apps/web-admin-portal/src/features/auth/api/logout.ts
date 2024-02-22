import {axios} from "~/lib/axios.ts";


export const loginWithEmailAndPassword = async () => {
  try {
    const response = await axios.post('/logout');

    return response.data.data;

  } catch (e) {
    throw new Error("Login Failed");
  }
}
