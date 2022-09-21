<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Vendor;
use App\Models\UserProfile;
use Carbon\Carbon;

class SettingController extends Controller
{
    public function index()
    {
        $user = Auth::guard('admin')->user();

        return view('admin.setting.index', ['user' => $user]);
    }

    public function profile()
    {
        $user = Auth::guard('admin')->user();
        return view('admin.setting.profile', ['user' => $user]);
    }

    public function changePassword(Request $request)
    {
        $user = Auth::guard('admin')->user();

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
        return redirect()->route('/admin')->with("success","Password successfully changed!");
    }
}
