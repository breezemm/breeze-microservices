import {createFileRoute, Outlet} from '@tanstack/react-router'

export const Route = createFileRoute('/_auth')({
  component: Auth,
  beforeLoad: ({context: {auth}}) => {
    console.log(auth)
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
