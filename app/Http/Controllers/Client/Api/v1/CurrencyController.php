<?php

namespace App\Http\Controllers\Client\Api\v1;

use App\Traits\ApiControllerTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class CurrencyController extends Controller
{

    use ApiControllerTrait;

    public function getCurrency()
    {

        if(auth()->guard('api')->check()) {
            $currency = auth()->guard('api')->user()->currency;
        } else {
            $currency = session()->has('currency') ? session()->get('currency') : 'rur';;
        }
        return $this->successResponse(
            ['currency' => $currency]
        );
    }

    public function setCurrency(Request $request)
    {
        session()->put('currency', $request->currency);
        if(auth()->guard('api')->check()) {
            $user = auth()->guard('api')->user();
            $user->currency = $request->currency;
            $user->save();
        }

        return $this->successResponse(
            ['currency' => $request->currency]
        );
    }

}
