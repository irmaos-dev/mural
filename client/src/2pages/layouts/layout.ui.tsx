import { useSuspenseQuery } from '@tanstack/react-query'
import {
  IoCreateOutline,
  IoSettingsSharp,
  IoLogOutOutline,
} from 'react-icons/io5'
import { NavLink } from 'react-router-dom'
import { pathKeys } from '~6shared/lib/react-router'
import { SessionQueries } from '~6shared/session'
import { GoogleButton } from '~6shared/ui/button-google'
import { LogoutButtonCustomizable } from '~4features/session'

export function Footer() {
  return (
    <footer>
      <div className="container">
        <NavLink
          className="logo-font"
          to={pathKeys.home()}
        >
          conduit
        </NavLink>
        <span className="attribution">
          An interactive learning project from{' '}
          <a
            href="https://thinkster.io"
            target="_blank"
            rel="noreferrer"
          >
            Thinkster
          </a>
          . Code &amp; design licensed under MIT.
        </span>
      </div>
    </footer>
  )
}

export function BrandLink() {
  return (
    <NavLink
      className="navbar-brand"
      to={pathKeys.home()}
      style={{ padding: 0 }}
    >
      conduit
    </NavLink>
  )
}

export function SignInLink() {
  const onSubmit = async () => {
    window.location.href = `${import.meta.env.VITE_API_BASE_URL}/auth/redirect`
  }
  return <GoogleButton onClick={onSubmit} />
}

export function NewArticleLink() {
  return (
    <NavLink
      className="nav-link"
      to={pathKeys.editor.root()}
    >
      <IoCreateOutline size={16} />
      &nbsp;New Article
    </NavLink>
  )
}

export function SettingsProfileLink() {
  return (
    <NavLink
      className="nav-link"
      to={pathKeys.settings()}
    >
      <IoSettingsSharp size={16} />
      &nbsp;Settings
    </NavLink>
  )
}

export function ProfileLink() {
  const { data: user } = useSuspenseQuery(SessionQueries.currentSessionQuery())

  return (
    <NavLink
      className="nav-link"
      to={pathKeys.profile.byUsername({ username: user.username })}
    >
      <img
        className="user-pic"
        src={user.image}
        alt={user.username}
      />
      {user.username}
    </NavLink>
  )
}

export function LogoutDropdownButton() {
  return (
    <LogoutButtonCustomizable>
      <IoLogOutOutline />
      &nbsp;Logout
    </LogoutButtonCustomizable>
  )
}
