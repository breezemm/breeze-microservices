import { createFileRoute } from '@tanstack/react-router'

export const Route = createFileRoute('/_authenticated/(dashboard)/events')({
  component: () => <div>Hello /_authenticated/events!</div>
})