import {
  DefaultError,
  UseMutationOptions,
  useMutation,
} from '@tanstack/react-query'
import { AuthService, authTypesDto } from '~6shared/api/auth'
import { sessionLib, useSessionStore } from '~6shared/session'

export function useLoginMutation(
  options?: Pick<
    UseMutationOptions<
      Awaited<ReturnType<typeof AuthService.loginUserMutation>>,
      DefaultError,
      authTypesDto.LoginUserDto,
      unknown
    >,
    'mutationKey' | 'onMutate' | 'onSuccess' | 'onError' | 'onSettled'
  >,
) {
  const {
    mutationKey = [],
    onMutate,
    onSuccess,
    onError,
    onSettled,
  } = options || {}

  return useMutation({
    mutationKey: ['session', 'login-user', ...mutationKey],

    mutationFn: async (loginUserDto: authTypesDto.LoginUserDto) =>
      AuthService.loginUserMutation({ loginUserDto }),

    onMutate,

    onSuccess: async (response, variables, context) => {
      const { user } = response.data
      const { setSession } = useSessionStore.getState()

      console.log("Response", response.data);

      const session = sessionLib.transformUserDtoToSession({ user })
      setSession(session)

      await onSuccess?.(response, variables, context)
    },

    onError,

    onSettled,
  })
}
