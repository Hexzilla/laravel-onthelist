<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorAccount;

class PaymentController extends Controller
{
    public function vendor()
    {
        $accounts = VendorAccount::paginate(10);

        return view('admin.payment.detail', ['accounts' => $accounts]);
    }
}
