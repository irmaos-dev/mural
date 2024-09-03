import { createElement, lazy } from 'react'
import {
  NavLink,
  Outlet,
  RouterProvider,
  createBrowserRouter,
  redirect,
  useRouteError,
} from 'react-router-dom'
import { compose, withSuspense } from '~6shared/lib/react'
import { pathKeys } from '~6shared/lib/react-router'
import { Skeleton } from '~6shared/ui/skeleton'
import { Spinner } from '~6shared/ui/spinner'
import { Stack } from '~6shared/ui/stack'
import { articlePageRoute } from '~2pages/article'
import { editorPageRoute } from '~2pages/editor'
import { homePageRoute } from '~2pages/home'
import { loginPageRoute } from '~2pages/login'
import { page404Route } from '~2pages/page-404'
import { profilePageRoute } from '~2pages/profile'
import { registerPageRoute } from '~2pages/register'
import { settingsPageRoute } from '~2pages/settings'

export function BrowserRouter() {
  return <RouterProvider router={browserRouter} />
}

const enhance = compose((component) =>
  withSuspense(component, { FallbackComponent: LayoutSkeleton }),
)

const GenericLayout = lazy(() =>
  import('~2pages/layouts').then((module) => ({
    default: module.GenericLayout,
  })),
)

const GuestLayout = lazy(() =>
  import('~2pages/layouts').then((module) => ({
    default: module.GuestLayout,
  })),
)

const UserLayout = lazy(() =>
  import('~2pages/layouts').then((module) => ({
    default: module.UserLayout,
  })),
)

const browserRouter = createBrowserRouter([
  {
    errorElement: <BubbleError />,
    children: [
      {
        element: createElement(enhance(GenericLayout)),
        children: [homePageRoute, articlePageRoute, profilePageRoute],
      },
      {
        element: createElement(enhance(UserLayout)),
        children: [editorPageRoute, settingsPageRoute],
      },
      {
        element: createElement(enhance(GuestLayout)),
        children: [loginPageRoute, registerPageRoute],
      },
      {
        element: createElement(Outlet),
        children: [page404Route],
      },
      {
        loader: async () => redirect(pathKeys.page404()),
        path: '*',
      },
    ],
  },
])

// https://github.com/remix-run/react-router/discussions/10166
function BubbleError() {
  const error = useRouteError()

  if (error) throw error
  return null
}

function LayoutSkeleton() {
  return (
    <>
      <nav className="navbar navbar-light">
        <div className="container">
          <Stack justifyContent="space-between">
            <NavLink
              className="navbar-brand"
              to={pathKeys.home()}
            >
              conduit
            </NavLink>

            <Stack
              spacing={16}
              alignItems="center"
              justifyContent="flex-end"
              style={{ height: '38px' }}
            >
              <Skeleton width={40} />
              <Skeleton width={45} />
              <Skeleton width={50} />
            </Stack>
          </Stack>
        </div>
      </nav>

      <Spinner
        display
        position="center"
      />
    </>
  )
}
