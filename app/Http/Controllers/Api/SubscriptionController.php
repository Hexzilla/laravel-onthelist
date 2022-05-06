<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
Use App\Models\User;
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

            $stripeCharge = $user->charge(
                $plan->price * 100,
                $request->paymentMethodId
            );

            return json_encode(array('success' => true));
        }
        catch (Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }
}
