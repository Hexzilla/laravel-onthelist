<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Http\Middleware\VerifyRedirectUrl;
use Stripe\PaymentIntent as StripePaymentIntent;

class StripeAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware(VerifyRedirectUrl::class);
    }

    public function show($id)
    {
        $user = Auth::user();

        $stripeAccount = $this->vendor->stripeAccount;

        return json_encode(array(
            'stripeKey' => $stripeAccount->key,
            'payment' => new Payment(
                StripePaymentIntent::retrieve($id, $user->stripeOptions())
            )
        ));
    }
}
