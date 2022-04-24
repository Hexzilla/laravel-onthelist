<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Dj;
use App\Models\UserFavorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DjController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $djs = Dj::where('status', 'Approved')->paginate(10);
        foreach($djs as $dj) {
            $favorite = UserFavorite::where('type', 'dj')->where('order_id', $dj->id)->first();
            if (is_null($favorite)) {
                $dj->favourite = false;
            } else {
                $dj->favourite = true;
            }
        }
        return view('customer.dj.list', [
            'breadcrumb' => 'All',
            'djs' => $djs
        ]);
    }

    public function favourited()
    {
        $user_id = Auth::user()->id;
        $dj_ids = UserFavorite::where('type', 'dj')->select('order_id')->get();
        $djs = Dj::whereIn('id', $dj_ids)->paginate(10);
        foreach($djs as $dj) {
            $dj->favourite = true;
        }
        return view('customer.dj.list', [
            'breadcrumb' => 'Favourite',
            'djs' => $djs
        ]);
    }

    public function favourite($id)
    {
        $user_id = Auth::user()->id;
        $dj = Dj::where('id', $id)->first();
        if (is_null($dj)) {
            return redirect()->back();
        }
        UserFavorite::create([
            'user_id' => $user_id,
            'order_id' => $id,
            'type' => 'dj'
        ]);
        return redirect()->back();
    }

    public function unfavourite($id)
    {
        $user_id = Auth::user()->id;
        $favorite = UserFavorite::where('user_id', $user_id)
                    ->where('order_id', $id)
                    ->where('type', 'dj')
                    ->first();
        if (is_null($favorite)) {
            return redirect()->back();
        }
        $favorite->delete();
        return redirect()->back()->with('Success');
    }
}
