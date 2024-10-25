import { z } from 'zod'
import { ProfileSchema } from './profile.contracts'

export type Profile = z.infer<typeof ProfileSchema>
