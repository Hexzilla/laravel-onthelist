<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index($role)
    {
        $users = User::where('role', $role)->get();
        return view("admin.user.$role-list", ['users' => $users]);
    }
}
