import { createFileRoute } from '@tanstack/react-router'

export const Route = createFileRoute('/_authenticated/dashboard/wallet/')({
  component: () => <div>Wallet Page</div>
})
