import { zodResolver } from '@hookform/resolvers/zod'
import { withErrorBoundary } from 'react-error-boundary'
import { useForm } from 'react-hook-form'
import { useNavigate } from 'react-router-dom'
import { authContractsDto, authTypesDto } from '~6shared/api/auth'
import { compose } from '~6shared/lib/react'
import { hasMessages } from '~6shared/lib/react-hook-form'
import { pathKeys } from '~6shared/lib/react-router'
import { ErrorHandler, logError } from '~6shared/ui/error-handler'
import { ErrorList } from '~6shared/ui/error-list'
import { useLoginMutation } from './login.mutation'

const enhance = compose((component) =>
  withErrorBoundary(component, {
    FallbackComponent: ErrorHandler,
    onError: logError,
  }),
)

export const LoginForm = enhance(() => {
  const navigate = useNavigate()

  const {
    register,
    handleSubmit,
    setError,
    formState: { errors, isDirty, isValid },
  } = useForm<authTypesDto.LoginUserDto>({
    mode: 'onTouched',
    resolver: zodResolver(authContractsDto.LoginUserDtoSchema),
    defaultValues: { email: '', password: '' },
  })

  const { mutate, isPending } = useLoginMutation({
    onSuccess: async (response) => {
      const { username } = response.data.user
      navigate(pathKeys.profile.byUsername({ username }))
    },

    onError(error) {
      setError('root', { message: error.message })
    },
  })

  const canSubmit = [isDirty, isValid, !isPending].every(Boolean)

  const onSubmit = (loginUserDto: authTypesDto.LoginUserDto) =>
    mutate(loginUserDto)

  return (
    <>
      {hasMessages(errors) && <ErrorList errors={errors} />}

      <form onSubmit={handleSubmit(onSubmit)}>
        <fieldset
          className="form-group"
          disabled={isPending}
        >
          <input
            className="form-control form-control-lg"
            type="text"
            placeholder="Email"
            {...register('email')}
          />
        </fieldset>

        <fieldset
          className="form-group"
          disabled={isPending}
        >
          <input
            className="form-control form-control-lg"
            type="password"
            placeholder="Password"
            {...register('password')}
          />
        </fieldset>

        <button
          className="btn btn-lg btn-primary pull-xs-right"
          type="submit"
          disabled={!canSubmit}
        >
          Sign in
        </button>
      </form>
    </>
  )
})
