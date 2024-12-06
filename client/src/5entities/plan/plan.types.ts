import { InfiniteData } from '@tanstack/react-query'
import { z } from 'zod'
import {
  ArticleSchema,
  ArticlesSchema,
  FilterQuerySchema,
} from './article.contracts'

export type Plan = z.infer<typeof PlanSchema>
export type Plans = z.infer<typeof PlansSchema>