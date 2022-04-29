<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        return json_encode(array('success' => true, 'notifications' => $user->notifications));
    }

    public function unread(Request $request)
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        return json_encode(array('success' => true, 'notifications' => $user->unreadNotifications));
    }

    public function markAsRead($id)
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        foreach ($user->unreadNotifications as $notification) {
            if ($notification->id == $id) {
                $notification->markAsRead();
                break;
            }
        }
        return json_encode(array('success' => true));
    }
}
