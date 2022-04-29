<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Following;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FollowingController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;

        $followings = DB::table('followings')
            ->select( 'users.id as userId', 'users.name as name', 'users.role as role', 'user_profiles.image_path as profile_image')
            ->join('users', 'users.id', '=', 'followings.following_user_id')
            ->leftJoin('user_profiles', 'user_profiles.user_id', '=', 'users.id')
            ->where('followings.user_id', $user_id)
            ->get();

        return json_encode(array('success' => true, 'followings' => $followings));
    }

    public function add_following($following_user_id)
    {
        $user_id = Auth::user()->id;

        $followings = array([
            'user_id' => $user_id,
            'following_user_id' => $following_user_id,
        ]);
        Following::upsert($followings, ['user_id', 'following_user_id'], ['user_id', 'following_user_id']);

        return json_encode(array('success' => true));
    }

    public function remove_following($following_user_id)
    {
        $user_id = Auth::user()->id;

        Following::where('user_id', $user_id)
            ->where('following_user_id', $following_user_id)
            ->delete();
        
        return json_encode(array('success' => true));
    }
}
