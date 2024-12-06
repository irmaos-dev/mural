import { planTypesDto } from '~6shared/api/plan'

export function transformPlanDtoToPlan(
  planDto: planTypesDto.PlanDto,
): Plan {
  const { plan } = planDto

  return {
    ...plan,
  }
}

export function transformPlansDtoToPlans(
  plansDto: planTypesDto.PlansDto,
): Plans {
  const { plans } = plansDto

  return new Map(
    plans.map((plan) => [
      transformPlanDtoToPlan ({ plan }),
    ]),
  )
}
