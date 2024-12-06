import { z } from 'zod'
import { PlanDtoSchema, PlansDtoSchema } from './plan.contracts'

export type PlanDto = z.infer<typeof PlanDtoSchema>
export type PlansDto = z.infer<typeof PlansDtoSchema>