import { Script } from "~6shared/ui/script";

const pricingTable = import.meta.env.VITE_PRICING_TABLE_ID;
const publishableKey = import.meta.env.VITE_PUBLISHABLE_KEY;
console.log("p1", pricingTable);
console.log("p2", publishableKey);

export const ScriptTable = () => (
  <>
  <Script src='https://js.stripe.com/v3/pricing-table.js'/>
    {/* <script
      src="https://js.stripe.com/v3/pricing-table.js" /> */}
    {/* @ts-ignore */}
    <stripe-pricing-table
      pricing-table-id= {pricingTable}
      publishable-key={publishableKey} />
  </>
)


