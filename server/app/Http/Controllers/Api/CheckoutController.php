<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CheckoutController extends Controller
{
    public function chechout (Request $request){

        return $request->user()
            ->newSubscription('default', 'price_basic_monthly')
            ->trialDays(5)
            ->allowPromotionCodes()
            ->checkout([
                'success_url' => route('checkout.sucess'),
                'cancel_url' => route('checkout.cancel'),
            ]);
    }

    public function sucess (){
        return redirect()->to(config('frontend.url'));
    }

    public function cancel (){
        return redirect()->to(config('frontend.url'));
    }

};
