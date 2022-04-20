<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'vendor')
            ->whereNull('deleted_at')
            ->get();
        return view("admin.vendor.list", ['users' => $users, 'role' => 'vendor']);    
    }

    public function edit($id)
    {
        $users = User::where('id', $id)->get();
        $user = $users[0];
        return view("admin.vendor.create", ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $users = User::where('id', $id)->get();
        $user = $users[0];
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();
        $users = User::where('role', $user->role)->get();
        return view("admin.user.list", ['users' => $users, 'role' => $user->role ]);
    }

    public function show($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $current = Carbon::now();

        $events = DB::table('event_djs')
            ->join('events', 'events.id', '=', 'event_djs.event_id')
            ->where('event_djs.user_id', $id)
            ->where('events.start', '>', $current)
            ->select('events.*')
            ->get();
        
        return view("admin.user.show", ['events' => $events, 'user' => $user]);
    }

    public function pause($id)
    {
        User::where('id', $id)->update(['paused_at' => now()]);
        return redirect()->route('admin.vendors.index')->with('Success');
    }

    public function resume($id)
    {
        User::where('id', $id)->update(['paused_at' => NULL]);
        return redirect()->route('admin.vendors.index')->with('Success');
    }


    public function destroy($id)
    {
        User::where('id', $id)->update(['deleted_at' => now()]);
        return redirect()->route('admin.vendors.index')->with('Success');
    }
}
