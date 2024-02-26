import {createFileRoute, Link, Outlet, redirect} from '@tanstack/react-router'
import {authStore} from "~/store";


export const Route = createFileRoute('/_authenticated')({
  component: Auth,
  beforeLoad: () => {
    const auth = authStore.state.user
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
    <main>
      <div className="">
        <Link to={"/"}>Home</Link>
        <Link to={"/wallet"}>Wallet</Link>
        <Link to={"/verify"}>Verify</Link>
      </div>
      <div>
        <Outlet/>
      </div>
    </main>
  )
}
