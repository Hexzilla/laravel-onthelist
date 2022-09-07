<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function inbox()
    {
        $messages = Auth::guard('admin')->user()->notifications;
        return view('admin.inbox', [
            'messages' => $messages
        ]);
    }
}
