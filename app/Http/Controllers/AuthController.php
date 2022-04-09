<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Session;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $credentials = $request->only('email', 'password');
        if(Auth::attempt($credentials, $request->get('remember'))) {
            $user = User::where('email', $request->email)->first();
            if($user->role === 'vendor'){
                return redirect()->intended('/vendors');
            }elseif($user->role === 'dj'){
                return redirect()->intended('/dj');
            }else{
                return redirect('/login');
            }
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    public function logout() {
        Session::flash();
        Auth::logout();
        return Redirect('home');
    }
}