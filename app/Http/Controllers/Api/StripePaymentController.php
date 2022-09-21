<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StripePaymentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $cards = $user->localPaymentMethod;

        return json_encode(array('success' => true, 'cards' => $cards));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $user->createOrGetStripeCustomer();

        $paymentMethod = $request->payment_method;
        $user->addPaymentMethod($paymentMethod);
        $this->saveRecord([
            'pm_id' => $paymentMethod
        ]);

        if (!$user->hasDefaultPaymentMethod())
        {
            $user->updateDefaultPaymentMethod($paymentMethod);
            $this->setDefault($paymentMethod);
        }

        return json_encode(array('success' => true, 'message' => 'Card is successfully saved!'));
    }

    protected function saveRecord($col)
    {
        $user = Auth::user();
        $paymentMethod = $user->findPaymentMethod($col['pm_id']);
        
        $user->localPaymentMethod()->updateOrCreate($col, [
            'card_number' => $paymentMethod->card->last4,
            'brand' => $paymentMethod->card->brand,
            'exp_month' => $paymentMethod->card->exp_month,
            'exp_year' => $paymentMethod->card->exp_year,
            'type' => $paymentMethod->type
        ]);
    }

    protected function setDefault($paymentMethod)
    {
        $user = Auth::user();
        $user->localPaymentMethod()->where('default_method', 1)->update([
            'default_method' => 0
        ]);
        $user->localPaymentMethod()->where('pm_id', $paymentMethod)->update([
            'default_method' => 1
        ]);
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();
        $paymentMethod = $user->findPaymentMethod($request->paymentMethodId);
        $paymentMethod->delete();

        $user->localPaymentMethod()->where('pm_id', $request->paymentMethodId)->delete();

        return json_encode(array('success' => true, 'message' => 'Card is successfully removed!'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $paymentMethod = $user->findPaymentMethod($request->paymentMethodId);
        $user->updateDefaultPaymentMethod($paymentMethod);
        $this->setDefault($request->paymentMethodId);

        return json_encode(array('success' => true, 'message' => 'Card is successfully updated!'));
    }
}
