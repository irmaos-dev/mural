import { useEffect, useState } from "react";
import { PlansService } from "~6shared/api/plan";
import { PricingCard, cardsModel } from "~6shared/ui/cards";

const PlansCards: React.FC = () => {

    const [plans, setPlans] = useState<cardsModel.Plan[]>([]);

    useEffect(() => {
        const controller = new AbortController();
        const { signal } = controller;

        const fetchPlans = async () => {
            try {
                const response = await PlansService.plansQuery({ signal });
                setPlans(response.data.data);
            } catch {
                console.error("Erro ao buscar os planos");
            }
        };

        fetchPlans();

        return () => {
            controller.abort();
        };
    }, []);
    console.log(plans);
    return (
        <div className="plans-page">

            {plans.length && plans.map((plan) => (
                <PricingCard
                    key={plan.id}
                    plan={plan} />
            ))}
        </div>
    );
};

export function PlansPage() {
    return (
        <div className="plans-page">
            <h1>Planos</h1>
            <PlansCards />
        </div>
    );
}