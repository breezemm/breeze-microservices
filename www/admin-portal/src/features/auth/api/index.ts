import {axios} from "~/lib/axios.ts";

export interface SignInCredentialDTO {
  email: string;
  password: string;
}

export const signInWithEmailAndPassword = async (credentials: SignInCredentialDTO) => {
  const response = await axios.post('/auth/login', credentials);

  return response.data.data;
}


export const getAuthUser = async () => {
  const response
    = await axios.get('/me');
  return response.data.data;
}
