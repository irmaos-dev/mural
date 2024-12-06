import { queryOptions } from '@tanstack/react-query'
import { PlansService } from '~6shared/api/plan'
import { transformPlanDtoToPlan } from './plan.lib'

export class PlansQueries {
  static readonly keys = {
    root: ['plans'] as const,
  }

  static planQuery() {
    return queryOptions({
      queryKey: [...this.keys.root],
      queryFn: async ({ signal }) => {
        const response = await PlansService.plansQuery({ signal })
        return transformPlanDtoToPlan(response.data)
      },
    })
  }

}
