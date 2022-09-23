<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Event;
use App\Models\Venue;
use App\Models\VenueCity;
use Illuminate\Support\Facades\DB;
use App\Notifications\PushNotify;
use Notification;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        return view('admin.notifications.list', [
            'notifications' => $user->notifications
        ]);
    }

    public function unread(Request $request)
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        return view('admin.notifications.list', [
            'notifications' => $user->unreadNotifications,
        ]);
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
        return redirect()->route('admin.notifications.index')->with('Success');
    }

    public function getLink()
    {
        $events = Event::get();
        $venues = Venue::get();
        $cities = VenueCity::get();
        return view('admin.notifications.push', [
            'events' => $events, 
            'venues' => $venues,
            'cities' => $cities
        ]);
    }


    public function pushNotification(Request $request)
    {
        $details = [
            'name' => $request->name,
            'message' => $request->message,
            'link' => $request->link
        ];

        if ($request->gender == 'Both') {
            $gender = ['Female', 'Male'];
        } else {
            $gender = [$request->gender];
        }

        $users = DB::table('users')
            ->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
            // ->whereIn('user_profiles.address', $request->location)
            ->whereIn('user_profiles.gender', $gender)
            ->select('users.*', 'user_profiles.date_birth as date_birth')
            ->get();
        if (is_null($request->age)) {
            foreach($users as $user) {
                Notification::send($user, new PushNotify($details));
            }
        } else {
            if (in_array('1', $request->age)) {
                foreach($users as $user) {
                    $age = Carbon::parse($user->date_birth)->diff(Carbon::now())->y;
                    if ($age >= 18 && $age <= 24) {
                        Notification::send($user, new PushNotify($details));
                    }
                }
            }
    
            if (in_array('2', $request->age)) {
                foreach($users as $user) {
                    $age = Carbon::parse($user->date_birth)->diff(Carbon::now())->y;
                    if ($age >= 25 && $age <= 30) {
                        Notification::send($user, new PushNotify($details));
                    }
                }
            } 
    
            if (in_array('3', $request->age)) {
                foreach($users as $user) {
                    $age = Carbon::parse($user->date_birth)->diff(Carbon::now())->y;
                    if ($age > 30) {
                        Notification::send($user, new PushNotify($details));
                    }
                }
            }
        }

        return redirect()->route('admin.dashboard');
    }
}
