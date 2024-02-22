import {createFileRoute, Outlet} from '@tanstack/react-router'
import AuthLayout from "~/features/auth/components/AuthLayout.tsx";

export const Route = createFileRoute('/_auth')({
  component: Auth,
})

function Auth() {

  return (
    <AuthLayout>
      Hello /_auth! Layout
      <Outlet/>
    </AuthLayout>
  )
}
