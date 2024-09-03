import { LoaderFunctionArgs, redirect } from 'react-router-dom'
import { pathKeys } from '~6shared/lib/react-router'
import { useSessionStore } from '~6shared/session'

export class SettingsLoader {
  static async settingsPage(args: LoaderFunctionArgs) {
    if (useSessionStore.getState().session) {
      return args
    }
    return redirect(pathKeys.login())
  }
}
