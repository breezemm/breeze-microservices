import {signInWithEmailAndPassword, SignInCredentialDTO, getAuthUser} from "~/features/auth/api";
import {initAuth} from "@breeze/react-auth";


const handleSignIn = async (data: { access_token: string; }) => {
  const {access_token}: {
    access_token: string;
  } = data;
  localStorage.setItem('access_token', JSON.stringify(access_token));

  return access_token;
}

const signInUser = async (data: SignInCredentialDTO) => {
  const token = await signInWithEmailAndPassword(data);
  await handleSignIn(token);

  return token;
}

const signOutUser = async () => {
  return Promise.resolve();
}

export const {useAuthUser, useSignInUser} = initAuth({
  signInUserFn: signInUser,
  signOutUserFn: signOutUser,
  getAuthUserFn: getAuthUser,
  signUpUserFn: async () => Promise.resolve(),
})
