<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentCard;
use App\Models\StripeAccount;
use Illuminate\Support\Facades\Validator;

class CardController extends Controller
{
    public function showCard()
    {
        $user_id = Auth::user()->id;
        $cards = PaymentCard::where('user_id', $user_id)->get();

        return json_encode(array('success' => true, 'cards' => $cards));
    }

    public function showAccount($id)
    {
        $stripeAccount = StripeAccount::where('user_id', $id)->first();
        if (is_null($stripeAccount)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get account'));
        }

        return json_encode(array('success' => true, 'stripeAccount' => $stripeAccount));
    }

    public function AddCard(Request $request)
    {
        $user_id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'card_number' => 'required',
            'holder' => 'required',
            'expire' => 'required',
            'cvc' => 'required'
        ]);

        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => $validator->errors()));
        }

        PaymentCard::create([
            'user_id' => $user_id,
            'card_number' => $request->card_number,
            'holder' => $request->holder,
            'expire' => $request->expire,
            'cvc' => $request->cvc,
        ]);

        return json_encode(array('success' => true));
    }
}