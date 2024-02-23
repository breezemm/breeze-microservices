import {QueryClient, QueryClientProvider} from "@tanstack/react-query";
import {createRouter, ErrorComponent, RouterProvider} from "@tanstack/react-router";
import {routeTree} from "~/routeTree.gen.ts";
import {useAuthUser} from "~/lib/auth.ts";
import {Spinner} from "~/components/Spinner.tsx";


const queryClient = new QueryClient({
  defaultOptions: {
    queries: {
      staleTime: 0,
      refetchOnWindowFocus: false,
    },
  },
});

const router = createRouter({
  routeTree,
  context: {
    queryClient,
    auth: undefined,
  },
  defaultErrorComponent: ({error}) => <ErrorComponent error={error}/>,
  defaultPreload: 'intent',
  defaultPreloadStaleTime: 0,
});


declare module '@tanstack/react-router' {
  interface Register {
    router: typeof router
  }
}

const WithAuthProvider = () => {
  const auth = useAuthUser()

  if (auth.isLoading) return <Spinner/>;

  return (
    <RouterProvider
      router={router}
      context={{
        auth: auth.isSuccess ? auth.data : undefined,
      }}
    />
  );
}

const App = () => {
  return (
    <QueryClientProvider client={queryClient}>
      <WithAuthProvider/>
    </QueryClientProvider>
  )

};

export default App;
