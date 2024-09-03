import {
  DefaultError,
  UseMutationOptions,
  useMutation,
} from '@tanstack/react-query'
import { AuthService } from '~6shared/api/auth'
import { queryClient } from '~6shared/lib/react-query'
import { useSessionStore } from '~6shared/session'

export function useLogoutMutation(
  options?: Pick<
    UseMutationOptions<
      Awaited<ReturnType<typeof AuthService.logoutUserMutation>>,
      DefaultError,
      void,
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
    mutationKey: ['session', 'logout-user', ...mutationKey],

    mutationFn: async () => AuthService.logoutUserMutation(),

    onMutate,

    onSuccess: async (response, variables, context) => {
      const { resetSession } = useSessionStore.getState()
      resetSession()

      queryClient.removeQueries()

      await onSuccess?.(response, variables, context)
    },

    onError,

    onSettled,
  })
}
