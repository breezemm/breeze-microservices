import {createFileRoute, redirect, useNavigate} from '@tanstack/react-router'
import {useSignInUser} from "~/lib/auth.ts";
import {FormEvent} from "react";
import {Button} from "@breeze/ui";

export const Route = createFileRoute('/auth/login')({
  component: Login,
  beforeLoad: ({context: {auth}}) => {
    console.log('auth', auth)
    if (auth) {
      throw redirect({
        to: '/'
      })
    }
  }
})


function Login() {
  const navigate = useNavigate();


  const login = useSignInUser({
    onSuccess: () => {
      navigate({
        to: '/'
      })
    }
  });

  const onLoginUser = (e: FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    login.mutate({
      email: "admin@breeze.com",
      password: "password",
    })
  }

  return (
    <div className="mx-8 my-8">
      <form onSubmit={onLoginUser}>
        <Button className="" type="submit">Login User</Button>
      </form>
    </div>
  )
}
