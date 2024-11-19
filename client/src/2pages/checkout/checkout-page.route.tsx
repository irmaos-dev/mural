import { lazy } from "react";
import { RouteObject } from "react-router-dom";

const CheckoutPage = lazy(() =>
  import('./checkout-page.ui').then((module) => ({
    default: module.checkoutPage,
  })),
)

export const checkoutPageRoute: RouteObject = {
  path: 'checkout',
  children: [
    {
      index: true,
      element: <CheckoutPage />,
    },
  ],
}