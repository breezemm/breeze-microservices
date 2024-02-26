import { createFileRoute } from '@tanstack/react-router'

export const Route = createFileRoute('/_authenticated/verify/')({
  component: () => <div>Hello /_authenticated/verify/!</div>
})