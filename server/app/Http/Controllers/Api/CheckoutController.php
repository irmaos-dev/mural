<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CheckoutController extends Controller
{
    public function checkout (Request $request){

        if ($request->user()){
            return $request->user()
            ->newSubscription('default', 'price_basic_monthly')
            ->trialDays(5)
            ->allowPromotionCodes()
            ->checkout([    
                'success_url' => route('checkout.sucess'),
                'cancel_url' => route('checkout.cancel'),
            ]);
        } else {
            return redirect()->to(config('frontend.url'));
        }
    }

    public function sucess (){
        return redirect()->to(config('frontend.url'));
    }

    public function cancel (){
        return redirect()->to(config('frontend.url'));
    }

};
