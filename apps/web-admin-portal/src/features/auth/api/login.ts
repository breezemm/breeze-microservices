import {axios} from "~/lib/axios.ts";

export interface SignInCredentialDTO {
  email: string;
  password: string;
}

export const loginWithEmailAndPassword = async (credentials: SignInCredentialDTO) => {
  try {
    const response = await axios.post('/login', credentials);

    return response.data.data;
  } catch (e) {
    throw new Error("Login Failed");
  }
}
