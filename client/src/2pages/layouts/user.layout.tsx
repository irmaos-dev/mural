import { withErrorBoundary } from 'react-error-boundary'
import { IoLogOutOutline } from 'react-icons/io5'
import { Outlet } from 'react-router-dom'
import { compose, withSuspense } from '~6shared/lib/react'
import { useSessionStore, PermissionService } from '~6shared/session'
import {
  DropdownMenu,
  createDropdownMenuStore,
} from '~6shared/ui/dropdown-menu'
import { ErrorHandler, logError } from '~6shared/ui/error-handler'
import { Skeleton } from '~6shared/ui/skeleton'
import { Stack } from '~6shared/ui/stack'
import { LogoutButton } from '~4features/session'
import {
  Footer,
  BrandLink,
  NewArticleLink,
  SettingsProfileLink,
  ProfileLink,
} from './layout.ui'

export function UserLayout() {
  return (
    <>
      <nav className="navbar navbar-light">
        <div className="container">
          <BrandLink />
          <UserNavigation />
        </div>
      </nav>
      <Outlet />
      <Footer />
    </>
  )
}

function UserLogoutButton() {
  return (
    <LogoutButton
      className="btn btn-outline-danger"
      style={{ border: '0px' }}
    >
      <IoLogOutOutline />
      &nbsp;Logout
    </LogoutButton>
  )
}

function UserDropdownMenu() {
  const userDropdownMenuStore = createDropdownMenuStore({
    initialState: { isOpen: false },
    devtoolsOptions: { name: 'Example Dropdown' },
  })
  return (
    <DropdownMenu.Root store={userDropdownMenuStore}>
      <DropdownMenu.Trigger split>
        <ProfileLink />
      </DropdownMenu.Trigger>
      <DropdownMenu.Content>
        <DropdownMenu.Item>
          <SettingsProfileLink />
        </DropdownMenu.Item>
        <DropdownMenu.Item>
          <UserLogoutButton/>
        </DropdownMenu.Item>
      </DropdownMenu.Content>
    </DropdownMenu.Root>
  )
}

const enhance = compose(
  (component) =>
    withErrorBoundary(component, {
      FallbackComponent: ErrorHandler,
      onError: logError,
    }),
  (component) =>
    withSuspense(component, { FallbackComponent: UserNavigationSkeleton }),
)

const UserNavigation = enhance(() => {
  const session = useSessionStore.use.session()

  const canCreateArticle = PermissionService.useCanPerformAction(
    'create',
    'article',
  )

  const canUpdateProfile = PermissionService.useCanPerformAction(
    'update',
    'profile',
    { profileOwnerId: session?.username || '' },
  )

  return (
    <ul className="nav navbar-nav pull-xs-right">
      {canCreateArticle && (
        <li className="nav-item">
          <NewArticleLink />
        </li>
      )}
      {canUpdateProfile && (
        <li className="nav-item">
          <UserDropdownMenu />
        </li>
      )}
    </ul>
  )
})

function UserNavigationSkeleton() {
  return (
    <Stack
      spacing={16}
      alignItems="center"
      justifyContent="flex-end"
      style={{ height: '38px' }}
    >
      <Skeleton width={40} />
      <Skeleton width={90} />
      <Skeleton width={70} />
      <Stack
        alignItems="center"
        spacing={4}
      >
        <Skeleton
          variant="circular"
          width={26}
          height={26}
        />
        <Skeleton />
      </Stack>
    </Stack>
  )
}
