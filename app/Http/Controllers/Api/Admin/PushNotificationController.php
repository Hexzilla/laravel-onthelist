<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Venue;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Notifications\PushNotify;
use Notification;

class PushNotificationController extends Controller
{
    public function getLink()
    {
        $events = Event::get();
        $venues = Venue::get();
        return json_encode(array('success' => true, 'events' => $events, 'venues' => $venues));
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
            ->whereIn('user_profiles.address', $request->location)
            ->whereIn('user_profiles.gender', $gender)
            ->select('users.*', 'user_profiles.date_birth as date_birth')
            ->get();

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

        return redirect()->route('admin.dashboard');
    }
}
