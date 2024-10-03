import axios from 'axios'
import ReactDOM from 'react-dom/client'
import { realworld, handleGenericError } from '~6shared/api'
import { sessionLib, useSessionStore } from '~6shared/session'
import { Provider } from './providers'
import './main.css'
// import { useLoginMutation } from '~4features/session/login/login.mutation'
// import { BsWindowSidebar } from 'react-icons/bs'

window.addEventListener('error', (event) => {
  if (axios.isAxiosError(event.error)) {
    event.preventDefault()
  }
})

realworld.interceptors.request.use(
  (config) => {
    const { session } = useSessionStore.getState()
    if (session) {
      // eslint-disable-next-line no-param-reassign
      config.headers.Authorization = `Bearer ${session.token}`
    }
    return config
  },
  (error) => Promise.reject(error),
)

realworld.interceptors.response.use(
  (response) => response,
  (error) => {
    if (!axios.isAxiosError(error)) {
      return Promise.reject(error)
    }

    return Promise.reject(handleGenericError(error))
  },
)

ReactDOM.createRoot(document.getElementById('root') as HTMLElement).render(
  <Provider />,
)

const url_params = JSON.parse(decodeURIComponent(window.location.search.substring(1)).replace(/=([^&]+)\&/g, "=\"$1\",\n\r").replace(/(^|\r)([^=]+)=/g, "\"$2\":").replace(/^/, '{').replace(/$/, '}')) //eslint-disable-line

const { setSession } = useSessionStore.getState();

const session = sessionLib.transformUserDtoToSession(url_params);

setSession(session);
