import { createFileRoute } from '@tanstack/react-router'

export const Route = createFileRoute('/_authenticated/dashboard/wallet/cashinout')({
  component: () => <div>Hello /_authenticated/dashboard/wallet/cashinout!</div>
})