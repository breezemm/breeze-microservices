import {createFileRoute} from '@tanstack/react-router'

export const Route = createFileRoute('/auth/login')({
  component: Login,
})


function Login() {

  return (
    <div className="mx-8 my-8">
      Login Page
    </div>
  )
}
