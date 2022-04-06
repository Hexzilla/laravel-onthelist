<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index($role)
    {
        echo("role:" . $role);
        exit(0);
    }
}
