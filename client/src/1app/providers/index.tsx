import { withErrorBoundary } from 'react-error-boundary'
import { compose } from '~6shared/lib/react'
import { ErrorHandler, logError } from '~6shared/ui/error-handler'
import { Spinner, spinnerModel } from '~6shared/ui/spinner'
import { QueryClientProvider } from './QueryClientProvider'
import { BrowserRouter } from './RouterProvider'

const enhance = compose((component) =>
  withErrorBoundary(component, {
    FallbackComponent: ErrorHandler,
    onError: logError,
  }),
)

export const Provider = enhance(() => (
  <>
    <GlobalSpinner />
    <QueryClientProvider>
      <BrowserRouter />
    </QueryClientProvider>
  </>
))

function GlobalSpinner() {
  const display = spinnerModel.globalSpinner.use.display()

  return (
    <Spinner
      display={display}
      position="bottom-right"
    />
  )
}
