import {createFileRoute, Outlet, redirect} from '@tanstack/react-router'

export const Route = createFileRoute('/_auth')({
  component: Auth,
  beforeLoad: ({context: {auth}}) => {
    console.log('Auth Layout', auth)
    if (!auth) {
      throw redirect({
        to: '/auth/login'
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
