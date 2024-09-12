import { withErrorBoundary } from "react-error-boundary"
// import { useNavigate } from "react-router-dom"
import { compose } from "~6shared/lib/react"
import { ErrorHandler, logError } from "~6shared/ui/error-handler"

const enhance = compose((component) =>
    withErrorBoundary(component, {
      FallbackComponent: ErrorHandler,
      onError: logError,
    }),
  )
  console.log (enhance);

// const onSubmit = async() => {
//     await fetch(
//         'http://localhost:8081/api/auth/redirect').then(
//             response=>response.json())};

export const BtnGoogle = ()=> {
    // const navigate = useNavigate();

    const onSubmit = async() => {
        window.location.href= 'http://localhost:8081/api/auth/redirect'}

    return (
        <button className="btn btn-lg btn-primary flex justify-center"
          type="button"
          onClick={async()=> onSubmit()}>
            Google
          </button>
    )

}