import {createRouter, ErrorComponent, RouterProvider} from "@tanstack/react-router";
import {useState} from "react";
import {routeTree} from "~/routeTree.gen.ts";
import {QueryClient, QueryClientProvider} from "@tanstack/react-query";

const queryClient = new QueryClient({
  defaultOptions: {
    queries: {
      refetchOnWindowFocus: false,
    }
  }
})


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


const App = () => {
  const [auth] = useState('Auth')
  return (
    <QueryClientProvider client={queryClient}>
      <RouterProvider
        router={router}
        context={{
          auth,
        }}
      />
    </QueryClientProvider>
  );
};

export default App;
