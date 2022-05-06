<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
Use App\Models\User;
use Stripe;
use Exception;

class SubscriptionController extends Controller
{
    public function index()
    {
        return view('subscription.create');
    }

    public function purchase(Request $request)
    {
        $user = $request->user();

        try {
            /*if (!$user->hasDefaultPaymentMethod()) {
                $user->updateDefaultPaymentMethod($paymentMethod);
            }*/

            $stripeCharge = $user->charge(
                100, $request->paymentMethodId
            );
            var_dump($stripeCharge);
            exit(0);

            //return back()->with('success', 'Subscription is completed.');
        }
        catch (Exception $e) {
            var_dump($e->getMessage());
            exit(0);
            //return back()->with('errors', $e->getMessage());
        }

        /*$user = auth()->user();
        
        $validator = Validator::make($request->all(), [
            'paymentMethodId' => 'required',
            'plan' => 'required'
        ]);
        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => $validator->errors()));
        }

        $token =  $request->stripeToken;
        $paymentMethodId = $request->paymentMethodId;
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
                ->create($paymentMethodId, ['email' => $user->email]);

            return back()->with('success', 'Subscription is completed.');

        } catch (Exception $e) {
            return back()->with('success',$e->getMessage());
        }*/
    }
}
