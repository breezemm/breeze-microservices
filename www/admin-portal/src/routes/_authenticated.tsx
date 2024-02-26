import { Button } from '@breeze/ui';
import { createFileRoute, Link, Outlet, redirect } from '@tanstack/react-router'
import { authStore } from "~/store";


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
    <div>
      <header className="flex flex-row justify-between w-full px-10 py-6 border-b">
        <h1>Breeze Logo</h1>
        <div>
          Profile Image
        </div>
      </header>

      <div className="flex">
        <nav className="flex flex-col p-10 gap-y-6">


          <Button variant="ghost" asChild>
            <Link to={"/"}>Home</Link>
          </Button>


          <Button variant="ghost" asChild>
            <Link to={"/wallet"}>Wallet</Link>
          </Button>


          <Button variant="ghost" asChild>
            <Link to={"/verify"}>Verify</Link>
          </Button>

        </nav>
        <section>
          <Outlet />
        </section>
      </div>
    </div>
  )
}
