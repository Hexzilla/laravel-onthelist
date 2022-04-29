<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Carbon\Carbon;

class SettingController extends Controller
{
    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => $validator->errors()));
        }

        if (!(Hash::check($request->old_password, Auth::user()->password))) {
            return json_encode(array('success' => false, 'error' => 'Mismatch password'));
        }   

        $user->password = bcrypt($request->get('password'));
        $user->save();
        return json_encode(array('success' => true));
    }

    public function closeAccount(Request $request)
    {
        $user_id = Auth::user()->id;
        User::find($user_id)->delete();
        
        $request->user()->currentAccessToken()->delete();
        $request->user()->tokens()->delete();

        return json_encode(array('success' => true));
    }
}
