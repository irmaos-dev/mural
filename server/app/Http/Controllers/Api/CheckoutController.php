<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Laravel\Cashier\Cashier;
use Route;

class CheckoutController extends Controller
{
    public function checkout (Request $request){

        $session = Cashier::stripe()->checkout->sessions->retrieve($request->query('session_id'));

        $user = $session->client_reference_id;

        if ($user){
            return User::find($user)
            ->newSubscription('default', 'price_1QMWjC2QKc4mmxl21hEaXVrY')
            // ->create($request->paymentMethodId)
            // ->trialDays(5)
            // ->allowPromotionCodes()
            ->checkout([    
                'success_url' => route('api.checkout.success'),
                'cancel_url' => route('api.checkout.cancel'),
            ]);
        } else {
            return redirect()->to(config('frontend.url').'/article/porro-fugit-ut-commodi-qui/');
        }
    }

    public function success (){
        return redirect()->to(config('frontend.url').'/article/labore-aliquam-repellendus-reiciendis-qui-exercitationem/');
    }

    public function cancel (){
        return redirect()->to(config('frontend.url').'/article/corporis-necessitatibus-commodi-eius-pariatur-veritatis/');
    }

    public function plans (){
        return Cashier::stripe()->plans->all();
    }

};
