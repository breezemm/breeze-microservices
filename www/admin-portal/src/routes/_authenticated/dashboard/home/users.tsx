import { createFileRoute } from '@tanstack/react-router'
import UserNavigate from './-component/-routes/UserNavigate'
import UserBaseTable from './-component/UserBaseTable'

export const Route = createFileRoute('/_authenticated/dashboard/home/users')({
  component: User
})

function User() {
  return (
    <div>
      <UserNavigate />
      <UserBaseTable />
    </div>
  )
}
