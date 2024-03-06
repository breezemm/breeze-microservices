import { createFileRoute } from '@tanstack/react-router'

export const Route = createFileRoute('/_authenticated/(dashboard)/users')({
  component: () => <div>Hello /_authenticated/(dashboard)/users!</div>
})