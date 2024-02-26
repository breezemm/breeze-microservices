import {createFileRoute, Outlet, redirect} from '@tanstack/react-router'
import {store} from "~/store";

export const Route = createFileRoute('/_authenticated')({
  component: Auth,
  beforeLoad: () => {
    const auth = store.state.user
    console.log('Auth Layout', auth)

    if (!auth) {
      throw redirect({
        to: '/auth/login',
      })
    }
  }
})

function Auth() {

  return (
    <div>
      Auth Layout
      <Outlet/>
    </div>
  )
}
