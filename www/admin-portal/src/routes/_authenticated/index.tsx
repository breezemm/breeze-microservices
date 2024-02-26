import { createFileRoute } from '@tanstack/react-router'
import { Button } from "@breeze/ui";
import { useAuthUser, useSignOutUser } from "~/lib/auth.ts";

export const Route = createFileRoute('/_authenticated/')({
  component: Home,
})

function Home() {
  const auth = useAuthUser()

  const signOutUser = useSignOutUser({})

  const onLogout = () => {
    signOutUser.mutate({})
  }

  return (
    <div>
      <h1 className="font-semibold mb-3">Home Page</h1>
      {auth.isLoading && <p>Loading...</p>}
      <p>Name:{auth.isSuccess && auth.data?.name}</p>
      <Button onClick={onLogout}>Logout</Button>
    </div>
  )
}
