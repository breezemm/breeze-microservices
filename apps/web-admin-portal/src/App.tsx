import {QueryClient} from "@tanstack/react-query";
import {createRouter, ErrorComponent, RouterProvider} from "@tanstack/react-router";
import {useAuthUser} from "~/lib/auth.tsx";
import {routeTree} from "~/routeTree.gen.ts";

// eslint-disable-next-line react-refresh/only-export-components
export const queryClient = new QueryClient()

// eslint-disable-next-line react-refresh/only-export-components
export const createRouterWithAuth = (auth: { name: string }) => createRouter({
  routeTree,
  context: {
    queryClient,
    auth,
  },
  defaultErrorComponent: ({error}) => <ErrorComponent error={error}/>,
  defaultPreload: 'intent',
  defaultPreloadStaleTime: 0,
})

function App() {
  const auth = useAuthUser()

  const router = createRouterWithAuth(auth.data)

  return <RouterProvider router={router}/>
}

export default App;
