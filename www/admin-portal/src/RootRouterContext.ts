import {QueryClient} from "@tanstack/react-query";

export interface RootRouterContext {
  queryClient: QueryClient;
  auth: string | undefined;
}
