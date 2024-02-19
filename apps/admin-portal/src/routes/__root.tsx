import * as React from 'react'
import {Link, Outlet, createRootRoute} from '@tanstack/react-router'
import {Suspense} from "react";

const TanStackRouterDevtools =
  process.env.NODE_ENV === 'production'
    ? () => null // Render nothing in production
    : React.lazy(() =>
      // Lazy load in development
      import('@tanstack/router-devtools').then((res) => ({
        default: res.TanStackRouterDevtools,
      })),
    )


export const Route = createRootRoute({
  component: RootComponent,
  notFoundComponent: () => {
    return <p>Not Found (on root route)</p>
  },
})

function RootComponent() {
  return (
    <>
      <div className="p-2 flex gap-4 text-lg">
        <Link
          to="/"
          activeProps={{
            className: 'font-bold',
          }}
          activeOptions={{exact: true}}
        >
          Home
        </Link>{' '}
        <Link
          to={'/posts'}
          activeProps={{
            className: 'font-bold',
          }}
        >
          Posts
        </Link>
        <Link
          to="/layout-a"
          activeProps={{
            className: 'font-bold',
          }}
        >
          Layout
        </Link>
        <Link
          to="/this-route-does-not-exist"
          activeProps={{
            className: 'font-bold',
          }}
        >
          This Route Does Not Exist
        </Link>
      </div>
      <hr/>
      <Outlet/>
      {/* Start rendering router matches */}
      <Suspense>
        <TanStackRouterDevtools position={"bottom-right"}/>
      </Suspense>
    </>
  )
}
