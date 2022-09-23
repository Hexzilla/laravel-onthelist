<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorAccount;
use App\Models\User;

class PaymentController extends Controller
{
    public function vendor()
    {
        $accounts = VendorAccount::paginate(10);

        foreach ($accounts as $account) {
            if (!is_null($account->venue_id)) {
                $venue = Venue::where('id', $account->venue_id)->first();
                $account->venuename = $venue->name;
            } else {
                $vendor = User::where('id', $account->vendor_id)->first();
                $account->venuename = $vendor->name;
            }
        }

        return view('admin.payment.detail', ['accounts' => $accounts]);
    }
}
