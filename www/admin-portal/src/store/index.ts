import {Store} from "@tanstack/store";

export interface User {
  name: string;
  email: string;
}

interface State {
  user: User | undefined;
}

export const store = new Store<State>({
  user: undefined,
})
