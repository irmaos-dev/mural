import { Button } from "../button";
import { Plan } from "./cards.model";

interface PricingCardProps {
    plan: Plan;
}

export const PricingCard: React.FC<PricingCardProps> = ({ plan }: PricingCardProps) => (
    <div className="pricing-card">
        <h2>{plan.name}</h2>
        <p>{plan.description}</p>
        <p>{plan.amount}</p>
        <Button>Assinar</Button>
        {/* <button type="button">Assinar</button> */}
    </div>
);