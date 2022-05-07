<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
Use App\Models\User;
use App\Models\Plan;
use App\Models\TransactionsHistory;
use Exception;

class SubscriptionController extends Controller
{
    public function purchase(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'paymentMethodId' => 'required',
            'plan_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => $validator->errors()));
        }

        try {
            $user = $request->user();
            $plan = Plan::where('id', $request->plan_id)->first();
            if (is_null($plan)) {
                return json_encode(array('success' => false, 'error' => 'The plan does not exist.'));
            }

            $stripeCharge = $user->charge(
                $plan->price * 100,
                $request->paymentMethodId
            );

            TransactionsHistory::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'price' => $plan->price,
            ]);

            return json_encode(array('success' => true));
        }
        catch (Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }
}
