<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Dj;
use App\Models\User;
use App\Models\Venue;
use App\Models\DjMedia;
use App\Models\DjMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DjController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $djs = Dj::where('vendor_id', $user_id);
        return json_encode(array('success' => true, 'djs' => $djs));
    }

    public function edit($id)
    {
        $dj = Dj::where('id', $id)->first();
        if (is_null($dj)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get dj'));
        }

        $dj->genres = explode(',', $dj->genre);

        return json_encode(array('success' => true, 'dj' => $dj));
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'genres' => 'required',
            'header_image' => 'required|mimes:jpeg,png,jpg,gif',
        ]);
        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => $validator->errors()));
        }

        $header_image_path = null;
        if (!is_null($request->file('header_image'))) {
            $file = $request->file('header_image');
            $header_image_path = $file->store('public/uploads/user');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'dj',
        ]);

        $dj = Dj::create([
            'vendor_id' => $user_id,
            'user_id' => $user->id,
            'description' => $request->description,
            'header_image_path' => $header_image_path,
            'mixcloud_link' => $request->mixcloud_link,
            'genre' => implode(',', $request->genres),
        ]);

        $this->createMedia($dj, $request);

        return json_encode(array('success' => true));
    }

    public function update(Request $request, $id)
    {
        $vendor_id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'genres' => 'required',
        ]);
        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => $validator->errors()));
        }

        $dj = Dj::find($id);
        if (is_null($dj)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get dj'));
        }

        $user = User::where('id', $dj->user_id)->first();
        if ($user->email !== $request->email) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users',
            ]);
            if ($validator->fails()) {
                return json_encode(array('success' => false, 'error' => $validator->errors()));
            } 
        }
        if(is_null($user)) {
            return json_encode(array('success' => false, 'error' => 'Failed to update user'));
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        $dj->vendor_id = $vendor_id;
        $dj->description = $request->description;
        if (!is_null($request->file('header_image'))) {
            $file = $request->file('header_image');
            $dj->header_image_path = $file->store('public/uploads/user');
        }
        $dj->mixcloud_link = $request->mixcloud_link;
        $dj->genre = implode(',', $request->genres);
        $dj->save();

        $this->updateMedia($dj, $request);

        return json_encode(array('success' => true));
    }

    public function createMedia($dj, $request)
    {
        if ($request->hasFile('gallery_image'))
        {
            $file = $request->file('gallery_image');
            $path = $file->store('public/uploads/dj');
            DjMedia::create([
                'dj_id' => $dj->id,
                'type' => 'image',
                'path' => $path
            ]);
        }

        // create media record if the video exists
        if ($request->hasFile('gallery_video'))
        {
            $file = $request->file('gallery_video');
            $path = $file->store('public/uploads/dj');
            DjMedia::create([
                'dj_id' => $dj->id,
                'type' => 'video',
                'path' => $path
            ]);
        }

        if (!is_null($request->video_link))
        {
            DjMedia::create([
                'dj_id' => $dj->id,
                'type' => 'link',
                'path' => $request->video_link
            ]);
        }
    }

    public function updateMedia($dj, $request)
    {
        if ($request->hasFile('gallery_image'))
        {
            $file = $request->file('gallery_image');
            $path = $file->store('public/uploads/dj');
            DjMedia::create([
                'dj_id' => $dj->id,
                'type' => 'image',
                'path' => $path
            ]);
        }

        // create media record if the video exists
        if ($request->hasFile('gallery_video'))
        {
            $file = $request->file('gallery_video');
            $path = $file->store('public/uploads/dj');
            DjMedia::create([
                'dj_id' => $dj->id,
                'type' => 'video',
                'path' => $path
            ]);
        }

        if (!is_null($request->video_link))
        {
            DjMedia::create([
                'dj_id' => $dj->id,
                'type' => 'link',
                'path' => $request->video_link
            ]);
        }
    }

    public function destroy($id)
    {
        $dj = Dj::where('id', $id)->first();
        if (is_null($dj)) {
            return json_encode(array('success' => false, 'error' => 'The dj does not exist'));
        }
        $dj->delete();
        return json_encode(array('success' => true));
    }
    
    public function showMessage($id)
    {
        $messages = DjMessage::where('dj_id', $id)->orderBy('created_at', 'desc')->get();

        return json_encode(array('success' => true, 'messages' => $messages));
    }

    public function markAsRead($id)
    {
        $message = DjMessage::where('id', $id)->first();

        if (is_null($message)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get message'));
        }

        $current = Carbon::now();
        $message->read_at = $current;
        $message->save();

        return json_encode(array('success' => true, 'message' => $message));
    }
}
