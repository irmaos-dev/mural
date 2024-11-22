import { realworld } from '../index'

export class CheckoutService {
  static checkoutQuery(config: { signal?: AbortSignal }) {
    return realworld
      .get('/checkout', config)
  }
}
