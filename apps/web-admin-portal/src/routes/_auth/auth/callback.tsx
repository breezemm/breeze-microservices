import { createFileRoute } from '@tanstack/react-router'

export const Route = createFileRoute('/_auth/auth/callback')({
  component: () => <div>Hello /_auth/auth/callback!</div>
})