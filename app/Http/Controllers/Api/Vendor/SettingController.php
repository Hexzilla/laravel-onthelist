<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Vendor;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        return json_encode(array('success' => true, 'user' => $user));
    }

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
            return redirect()->back()->withInput($request->only('old_password'));
        }   

        $user->password = bcrypt($request->get('password'));
        $user->save();
        return json_encode(array('success' => true));
    }

    public function contact(Request $request)
    {
        $user_id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
        ]);
        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => $validator->errors()));
        }
        
        $user = User::where('id', $user_id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $this->createProfile($user, $request);
        
        return json_encode(array('success' => true));
    }

    public function createProfile($user, $request)
    {
        $profiles = Vendor::where('user_id', $user->id)->get();
        if(count($profiles) > 0){
            $profile = $profiles[0];
            $profile->phone = $request->phone;
            $profile->address = $request->address;
            if($request->hasFile('profile_image')){
                $path = upload_file($request->file('profile_image'), 'user');
                $profile->image_path = $path;
            }
            $profile->gender = $request->gender;
            $profile->date_birth = $request->date_birth;
            $profile->save();
        } else {
            if($request->hasFile('profile_image')){
                $path = upload_file($request->file('profile_image'), 'user');
            } else {
                $path = "";
            }
            Vendor::create([
                'user_id' => $user->id,
                'phone' => $request->phone,
                'address' => $request->phone,
                'image_path' => $path,
                'gender' => $request->gender,
                'date_birth' => $request->date_birth,
            ]);
        }
    }

    public function closeAccount()
    {
        $user_id = Auth::user()->id;
        $current = Carbon::now();
        $user = User::where('id', $user_id)->first();
        $user->deleted_at = $current;
        $user->save();
        
        Auth::logout();
        return json_encode(array('success' => true));
    }
}
