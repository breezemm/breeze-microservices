import {createRootRoute, Link, Outlet} from '@tanstack/react-router'
import React, {Suspense} from "react";


const TanStackRouterDevtools =
  process.env.NODE_ENV === 'production'
    ? () => null // Render nothing in production
    : React.lazy(() =>
      // Lazy load in development
      import('@tanstack/router-devtools').then((res) => ({
        default: res.TanStackRouterDevtools,
        // For Embedded Mode
        // default: res.TanStackRouterDevtoolsPanel
      })),
    )

const ReactQueryDevtools = process.env.NODE_ENV === 'production'
  ? () => null // Render nothing in production
  : React.lazy(() =>
    // Lazy load in development
    import('@tanstack/react-query-devtools').then((res) => ({
      default: res.ReactQueryDevtools,
    })),
  )

export const Route = createRootRoute({
  component: () => (
    <>
      <div className="p-2 flex gap-2">
        <Link to="/" className="[&.active]:font-bold">
          Home
        </Link>{' '}
        <Link to={"/posts"} className="[&.active]:font-bold">
          Posts
        </Link>{' '}
        <Link to={"/about"} className="[&.active]:font-bold">
          About
        </Link>
      </div>
      <hr/>
      <Outlet/>
      <Suspense fallback={null}>
        <TanStackRouterDevtools/>
        <ReactQueryDevtools initialIsOpen={false}/>
      </Suspense>
    </>
  ),
})
