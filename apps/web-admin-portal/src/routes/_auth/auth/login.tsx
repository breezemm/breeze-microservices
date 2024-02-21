import {createFileRoute} from '@tanstack/react-router'
import {initAuth} from "react-auth";
import {useQueryClient} from '@tanstack/react-query'

export const Route = createFileRoute('/_auth/auth/login')({
  component: Login,
})


function Login() {
  const queryClient = useQueryClient()

  const {useAuthUser} = initAuth({
    getAuthUserFn: async () => {
      return {
        id: 1,
        email: "amm@gmial.com"
      }
    },
    signInUserFn: async () => {
      return {
        id: 1,
        email: "amm@gmial.com"
      }
    },
    signUpUserFn: async () => {
      return {
        id: 1,
        email: "amm@gmial.com"
      }
    },
    signOutUserFn: async () => {
      return {
        id: 1,
        email: "amm@gmial.com"
      }
    },
  })

  const result = useAuthUser()
  console.log(result.data)

  console.log('qc', queryClient.getQueryData(['authenticated-user']))


  return (
    <div>
      Login page
    </div>
  )
}
