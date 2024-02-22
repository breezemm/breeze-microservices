import {signInWithEmailAndPassword, SignInCredentialDTO} from "~/features/auth/api/login";
import {initAuth} from "@breeze/react-auth";


const getAuthUser = async () => {
  return Promise.resolve({
    name: "Aung Myat Moe",
    email: "aungmyatmoe834@gmail.com"
  });
}

const signInUser = async (data: SignInCredentialDTO) => {
  return await signInWithEmailAndPassword(data);
}

const signOutUser = async () => {
  return Promise.resolve();
}

export const {useAuthUser} = initAuth({
  signInUserFn: signInUser,
  signOutUserFn: signOutUser,
  getAuthUserFn: getAuthUser,
  signUpUserFn: async () => Promise.resolve(),
})
