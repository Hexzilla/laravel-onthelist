<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function index()
    {
        return view('vendor.setting.index');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ]);

        if (!(Hash::check($request->old_password, Auth::user()->password))) {
            return redirect()->back()->withInput($request->only('old_password'));
        }   

        $user->password = bcrypt($request->get('password'));
        $user->save();
        return redirect()->route('vendors.dashboard')->with("success","Password successfully changed!");
    }
}
