<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'vendor')
            ->whereNull('deleted_at')
            //->simplePaginate(10);
            ->paginate(10);

        return json_encode(array('success' => true, 'users' => $users));   
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        return json_encode(array('success' => true, 'user' => $user));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "name" => 'required',
            "email" => 'required|email',
        ]);

        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => $validator->errors()));
        }
        $user = User::where('id', $id)->firstOrFail();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $this->createVendor($user, $request);

        return json_encode(array('success' => true));
    }

    public function createVendor($user, $request)
    {
        $vendors = Vendor::where('user_id', $user->id)->get();
        if ($request->hasFile('profile_image')) {
            $path = upload_file($request->file('profile_image'), 'user');
        } else {
            $path = "";
        }
        if (count($vendors) == 0) {
            Vendor::create([
                'user_id' => $user->id,
                'phone' => $request->phone,
                'address' => $request->address,
                'image_path' => $path,
                'gender' => $request->gender,
                'date_birth' => $request->date_birth,
            ]);
        } else {
            $vendor = $vendors[0];
            $vendor->phone = $request->phone;
            $vendor->address = $request->address;
            $vendor->gender = $request->gender;
            $vendor->date_birth = $request->date_birth;
            if ($request->hasFile('profile_image')) {
                $vendor->image_path = $path;
            }
            $vendor->save;
        }
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
        
        return json_encode(array('success' => true, 'events' => $events, 'user' => $user));
    }

    public function pause($id)
    {
        User::where('id', $id)->update(['paused_at' => now()]);
        return json_encode(array('success' => true));
    }

    public function resume($id)
    {
        User::where('id', $id)->update(['paused_at' => NULL]);
        return json_encode(array('success' => true));
    }


    public function destroy($id)
    {
        User::where('id', $id)->update(['deleted_at' => now()]);
        return json_encode(array('success' => true));
    }
}
