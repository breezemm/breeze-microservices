import {axios} from "~/lib/axios.ts";

export interface SignInCredentialDTO {
  email: string;
  password: string;
}

export const signInWithEmailAndPassword = async (credentials: SignInCredentialDTO) => {
  const response = await axios.post('/auth/login', credentials);

  return response.data.data;
}
