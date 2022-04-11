<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;

class SettingController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        return view('vendor.setting.index', ['user' => $user]);
    }

    public function changePassword(Request $request)
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

    public function contact(Request $request)
    {
        $user_id = Auth::user()->id;
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
        ]);
        
        $user = User::where('id', $user_id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $this->createProfile($user, $request);
        
        return redirect()->route('vendors.dashboard')->with("success","Profile successfully changed!");
    }

    public function createProfile($user, $request)
    {
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();
        if(!is_null($profile)){
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
            UserProfile::create([
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
        return Redirect('home');
    }
}
