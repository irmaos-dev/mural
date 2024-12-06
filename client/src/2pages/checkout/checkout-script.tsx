import { Script } from "~6shared/ui/script";

const pricingTable = import.meta.env.VITE_PRICING_TABLE_ID;
const publishableKey = import.meta.env.VITE_PUBLISHABLE_KEY;

export const ScriptTable = (props: { userID: string }) => (
  <>
  <Script src='https://js.stripe.com/v3/pricing-table.js'/>
    {/* @ts-ignore */}
    <stripe-pricing-table
      pricing-table-id= {pricingTable}
      publishable-key={publishableKey} 
      client-reference-id={props.userID}
      />
  </>
)


