import {createFileRoute} from '@tanstack/react-router'
import {useStore} from '@tanstack/react-store'
import {store} from "~/store";
import {Button} from "@breeze/ui";

export const Route = createFileRoute('/_authenticated/')({
  component: Home,
})

function Home() {
  const name = useStore(store, state => state.name)

  const updateName = (name: string) => {
    store.setState((state) => {
      return {
        ...state,
        name: `${name} - Updated`
      }
    })
  }

  console.log(name)
  return (
    <div>
      <h1 className="font-semibold mb-3">Home Page</h1>
      <hr/>
      <p>Name:{name}</p>
      <Button onClick={() => updateName('John')}>Update Name</Button>
    </div>
  )
}
