import {createFileRoute, redirect, useNavigate} from '@tanstack/react-router'
import {useSignInUser} from "~/lib/auth.ts";
import {Button} from "@breeze/ui";
import {store} from "~/store";
import {flushSync} from "react-dom";

export const Route = createFileRoute('/auth/login')({
  component: Login,
  beforeLoad: ({context: {auth}}) => {
    if (auth) {
      throw redirect({
        to: '/'
      })
    }
  }
})


function Login() {
  const navigate = useNavigate()

  const signInUser = useSignInUser({
    onSuccess: (user) => {
      flushSync(() => {
        store.setState(state => {
          return {
            ...state,
            user,
          }
        })
        navigate({
          to: '/'
        })
      })
    }
  })

  const onLogin = async () => {
    await signInUser.mutateAsync({
      email: 'admin@breeze.com',
      password: 'password',
    })
  }


  return (
    <div className="mx-8 my-8">
      Login Page
      <Button
        onClick={onLogin}>Sign In</Button>
    </div>
  )
}
