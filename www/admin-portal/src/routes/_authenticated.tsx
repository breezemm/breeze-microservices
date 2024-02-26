import {createFileRoute, Outlet} from '@tanstack/react-router'

export const Route = createFileRoute('/_authenticated')({
  component: Auth,
})

function Auth() {

  return (
    <div>
      Auth Layout
      <Outlet/>
    </div>
  )
}
