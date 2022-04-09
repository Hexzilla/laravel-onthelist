<?php

namespace App\Http\Controllers\Dj;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DjProfile;
use App\Models\DjMedia;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->firstOrFail();
        return view('dj.profile.index', ['user' => $user]);
    }

    public function create()
    {
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->firstOrFail();
        return view('dj.profile.create', ['user' => $user]);
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'genres' => 'required',
            'age' => 'required',
        ]);

        $user = User::where('id', $user_id)->firstOrFail();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $this->createProfile($user, $request);
        $this->createMedia($user, $request);

        return redirect()->route('dj.profile.index');
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
            $path = upload_file($request->file('gallery_image'), 'dj');
            DjMedia::create([
                'user_id' => $user->id,
                'type' => 'image',
                'path' => $path
            ]);
        }

        if($request->hasFile('gallery_video'))
        {
            $path = upload_file($request->file('gallery_video'), 'dj');
            DjMedia::create([
                'user_id' => $user->id,
                'type' => 'video',
                'path' => $path
            ]);
        }
    }

    public function deleteMedia($id)
    {
        $media = DjMedia::where('id', $id)->firstOrFail();
        $media->delete();
        return redirect()->route('dj.profile.index');
    }

    
}
