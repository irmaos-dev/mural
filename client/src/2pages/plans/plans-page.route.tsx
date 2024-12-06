import { lazy } from "react";
import { RouteObject } from "react-router-dom";

const PlansPage = lazy(() =>
  import('./plans-page.ui').then((module) => ({
    default: module.PlansPage,
  })),
)

export const plansPageRoute: RouteObject = {
  path: 'plans',
  children: [
    {
      index: true,
      element: <PlansPage />,
    },
  ],
}