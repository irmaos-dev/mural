import { realworld } from '../index'

export class PlansService {
  static plansQuery(config: { signal?: AbortSignal }) {
    return realworld
      .get('/checkout/plans', config)
  }
}
