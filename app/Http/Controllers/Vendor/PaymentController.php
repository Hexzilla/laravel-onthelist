<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VendorAccount;

class PaymentController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $account = VendorAccount::where('vendor_id', $user_id)->first();
        if (!is_null($account)) {
            $account->firstname = explode(" ", $account->name);
            $account->lastname = explode(" ", $account->name);
        }
        
        return view('vendor.payment.index', [
            'action' => route('vendors.payment.store'),
            'account' => $account,
        ]);
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'bank_name' => 'required',
            'sort_code' => 'required',
            'account_number' => 'required'
        ]);
        $account = VendorAccount::where('vendor_id', $user_id)->first();
        if(is_null($account)) {
            $account = new VendorAccount;
            $account->vendor_id = $user_id;
        }
        $account->name = $request->firstname . ' ' . $request->lastname;
        if (!is_null($request->address)) {
            $account->address = $request->address;
        }
        if (!is_null($request->city)) {
            $account->city = $request->city;
        }
        if (!is_null($request->postcode)) {
            $accoun->postcode = $request->postcode;
        }
        if (!is_null($request->phone)) {
            $account->phone = $request->phone;
        }
        $account->bank_name = $request->bank_name;
        $account->sort_code = $request->sort_code;
        $account->account_number = $request->account_number;
        $account->save();

        return redirect()->route('vendors.dashboard');

    }
}
