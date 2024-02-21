import {createFileRoute, redirect} from '@tanstack/react-router'

export const Route = createFileRoute('/')({
  component: () => <div>Hello /!</div>,
  beforeLoad: () => {
    const isAuth = false;
    console.log(isAuth)
    if (!isAuth) {
      throw redirect({
        to: '/auth/login',
      })
    }
  },
})
