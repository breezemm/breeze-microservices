import "~/styles/globals.css"
import {StrictMode} from 'react'
import ReactDOM from 'react-dom/client'
import {QueryClientProvider} from '@tanstack/react-query'
import App, {createRouterWithAuth, queryClient} from "~/App.tsx";


declare module '@tanstack/react-router' {
  interface Register {
    router: ReturnType<typeof createRouterWithAuth>
  }
}

const rootElement = document.getElementById('app')!

if (!rootElement.innerHTML) {
  const root = ReactDOM.createRoot(rootElement)

  root.render(
    <StrictMode>
      <QueryClientProvider client={queryClient}>
        <App/>
      </QueryClientProvider>
    </StrictMode>,
  )
}
