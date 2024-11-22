import { Outlet } from 'react-router-dom'
import {
  Footer,
  BrandLink,
  SignInLink,
} from './layout.ui'


export function GuestLayout() {
  return (
    <>
      <nav className="navbar navbar-light">
        <div className="container">
          <BrandLink />

          <ul className="nav navbar-nav pull-xs-right">
            <li className="nav-item">
              <SignInLink />
            </li>

          </ul>
        </div>
      </nav>
      <Outlet />
      <Footer />
    </>
  )
}
