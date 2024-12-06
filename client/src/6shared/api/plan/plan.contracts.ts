import { z } from 'zod'

const PlanDto = z.object({
  name: z.string(),
  description: z.string(),
  amount: z.string(),
})

export const PlansDtoSchema = z.object({
  plans: z.array(PlanDto),
})

export const PlanDtoSchema = z.object({
  plan: PlanDto,
})
