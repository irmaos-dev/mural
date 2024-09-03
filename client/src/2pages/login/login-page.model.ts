import { LoaderFunctionArgs, redirect } from 'react-router-dom'
import { pathKeys } from '~6shared/lib/react-router'
import { useSessionStore } from '~6shared/session'

export class LoginLoader {
  static async loginPage(args: LoaderFunctionArgs) {
    if (useSessionStore.getState().session) {
      return redirect(pathKeys.home())
    }
    return args
  }
}
