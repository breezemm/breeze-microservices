import {createFileRoute} from '@tanstack/react-router'

export const Route = createFileRoute('/_auth/auth/login')({
  component: Login,
  beforeLoad: ({context}) => {
    console.log('Login Page', context.auth?.name)
  }
})


function Login() {
  return (
    <div>
      Login page
    </div>
  )
}
