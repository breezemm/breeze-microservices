import {createFileRoute, useNavigate} from '@tanstack/react-router'
import {useAuthUser} from "~/lib/auth.tsx";

export const Route = createFileRoute('/')({
  component: RootRouteComponent,
})


function RootRouteComponent() {
  const isAuth = useAuthUser()
  const navigate = useNavigate()


  if (isAuth.isError) {
    navigate({
      to: '/auth/login'
    })
  }
}
