import { queryOptions } from '@tanstack/react-query'
import { ProfileService } from '~6shared/api/profile'
import { queryClient } from '~6shared/lib/react-query'
import { transformProfileDtoToProfile } from './profile.lib'
import { Profile } from './profile.types'

export class ProfileQueries {
  static readonly keys = {
    root: ['profile'] as const,
  }

  static profileQuery(username: string) {
    return queryOptions({
      queryKey: [...this.keys.root, username],
      queryFn: async ({ signal }) => {
        const response = await ProfileService.profileQuery(username, { signal })
        return transformProfileDtoToProfile(response.data)
      },
      // @ts-expect-error FIXME: https://github.com/TanStack/query/issues/7341
      initialData: () =>
        queryClient.getQueryData<Profile>([...this.keys.root, username]),
      initialDataUpdatedAt: () =>
        queryClient.getQueryState([...this.keys.root, username])?.dataUpdatedAt,
    })
  }
}
