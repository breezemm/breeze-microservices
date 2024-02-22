import {createFileRoute} from '@tanstack/react-router'
import Login from "~/features/auth/components/Login.tsx";

export const Route = createFileRoute('/_auth/auth/login')({
  component: LoginLayout,
  beforeLoad: ({context}) => {
    console.log('Login Page', context.auth?.name)
  }
})


function LoginLayout() {
  return (
    <div>
      <Login/>
    </div>
  )
}
