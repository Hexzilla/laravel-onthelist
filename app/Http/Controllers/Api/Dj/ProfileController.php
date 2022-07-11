<?php

namespace App\Http\Controllers\Api\Dj;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DjProfile;
use App\Models\DjMedia;
use App\Models\DjMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        if (is_null($user)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get user'));
        }
        return json_encode(array('success' => true, 'user' => $user));
    }

    public function edit()
    {
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        if (is_null($user)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get user'));
        }
        return json_encode(array('success' => true, 'user' => $user));
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'genres' => 'required',
            'age' => 'required',
        ]);

        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => $validator->errors()));
        }

        $user = User::where('id', $user_id)->first();
        if (is_null($user)) {
            return json_encode(array('success' => false, 'error' => 'The user does not exist.'));
        }
        if ($user->email !== $request->email) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users',
            ]);
            if ($validator->fails()) {
                return json_encode(array('success' => false, 'error' => $validator->errors()));
            } 
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $this->createProfile($user, $request);
        $this->createMedia($user, $request);

        return json_encode(array('success' => true));
    }

    public function createProfile($user, $request)
    {
        $profile = DjProfile::where('user_id', $user->id)->get();
        $size = count($profile);
        if($size > 0){
            $profile[0]->age = $request->age;
            $profile[0]->genres = $request->genres;
            $profile[0]->save();
        } else {
            DjProfile::create([
                'user_id' => $user->id,
                'age' => $request->age,
                'genres' => $request->genres
            ]);
        }
    }

    public function createMedia($user, $request)
    {
        if($request->hasFile('gallery_image'))
        {
            $file = $request->file('gallery_image');
            $path = $file->store('public/uploads/dj');
            DjMedia::create([
                'user_id' => $user->id,
                'type' => 'image',
                'path' => $path
            ]);
        }

        if($request->hasFile('gallery_video'))
        {
            $file = $request->file('gallery_video');
            $path = $file->store('public/uploads/dj');
            DjMedia::create([
                'user_id' => $user->id,
                'type' => 'video',
                'path' => $path
            ]);
        }
    }

    public function deleteMedia($id)
    {
        $media = DjMedia::where('id', $id)->first();
        if(is_null($media)) {
            return json_encode(array('success' => false, 'error' => 'Failed to remove media'));
        }
        $media->delete();
        return json_encode(array('success' => true));
    }

    public function showMessage($id)
    {
        $messages = DjMessage::where('dj_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

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
