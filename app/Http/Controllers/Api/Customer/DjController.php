<?php

namespace App\Http\Controllers\Api\Customer;

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
        return json_encode(array('success' => true, 'djs' => $djs));
    }

    public function favourited()
    {
        $user_id = Auth::user()->id;
        $dj_ids = UserFavorite::where('type', 'dj')->select('order_id')->get();
        $djs = Dj::whereIn('id', $dj_ids)->paginate(10);
        foreach($djs as $dj) {
            $dj->favourite = true;
        }
        return json_encode(array('success' => true, 'djs' => $djs));
    }

    public function favourite($id)
    {
        $user_id = Auth::user()->id;
        $dj = Dj::where('id', $id)->first();
        if (is_null($dj)) {
            return json_encode(array('success' => false, 'error' => 'The dj does not exist'));
        }
        UserFavorite::create([
            'user_id' => $user_id,
            'order_id' => $id,
            'type' => 'dj'
        ]);
        return json_encode(array('success' => true));
    }

    public function unfavourite($id)
    {
        $user_id = Auth::user()->id;
        $dj = Dj::where('id', $id)->first();
        if (is_null($dj)) {
            return json_encode(array('success' => false, 'error' => 'The dj does not exist'));
        }
        $favorite = UserFavorite::where('user_id', $user_id)
                    ->where('order_id', $id)
                    ->where('type', 'dj')
                    ->first();
        if (is_null($favorite)) {
            return  json_encode(array('success' => false, 'error' => 'Failed to get favourite dj'));
        }
        $favorite->delete();
        return json_encode(array('success' => true));
    }
}
