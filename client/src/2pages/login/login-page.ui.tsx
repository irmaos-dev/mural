// import { Link } from 'react-router-dom'
// import { pathKeys } from '~6shared/lib/react-router'
// import { LoginForm } from '~4features/session'
import { BtnGoogle } from '~4features/session'

export function LoginPage() {
  return (
    <div className="auth-page">
      <div className="container page">
        <div className="row">
          <div className="col-md-6 offset-md-3 col-xs-12 text-xs-center">
            <h1 className="text-xs-center">Sign up with Google</h1>
            <BtnGoogle />
          </div>
        </div>
      </div>
    </div>
  )
}
