<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
Use App\Models\User;
use Stripe;
use Exception;

class SubscriptionController extends Controller
{
    public function purchase(Request $request)
    {
        $user = $request->user();
        $paymentMethod = $request->paymentMethod;

        try {
            if (!$user->hasDefaultPaymentMethod()) {
                $user->updateDefaultPaymentMethod($paymentMethod);
            }

            $stripeCharge = $user->charge(
                100, $request->paymentMethodId
            );

            return json_encode(array('success' => true, 'charge' => $stripeCharge));
        }
        catch (Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
        
        /*$validator = Validator::make($request->all(), [
            'paymentMethod' => 'required',
            'plan' => 'required'
        ]);
        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => $validator->errors()));
        }

        $token =  $request->stripeToken;
        $paymentMethod = $request->paymentMethod;
        $plan = $request->plan;

        try {

            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            
            if (is_null($user->stripe_id)) {
                $stripeCustomer = $user->createAsStripeCustomer();
            }

            \Stripe\Customer::createSource(
                $user->stripe_id,
                ['source' => $token]
            );

            $user->newSubscription('default', $plan)
                ->create($paymentMethod, ['email' => $user->email]);

            return json_encode(array('success' => true));
        } catch (Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }*/
    }
}
