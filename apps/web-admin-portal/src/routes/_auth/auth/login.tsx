import {createFileRoute} from '@tanstack/react-router'

export const Route = createFileRoute('/_auth/auth/login')({
  component: () => <div>Hello /login!</div>
})
