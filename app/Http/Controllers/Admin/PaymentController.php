<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function vendor()
    {
        $accounts = DB::table('vendor_accounts')
            ->join('users', 'users.id', '=', 'vendor_accounts.vendor_id')
            ->select('vendor_accounts.*', 'users.name')
            ->get();

        return view('admin.payment.account', ['accounts' => $accounts]);
    }
}
