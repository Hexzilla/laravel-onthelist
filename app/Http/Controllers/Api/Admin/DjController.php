<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dj;
use App\Models\User;
use App\Models\Venue;
use App\Models\DjMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DjController extends Controller
{
    public function index()
    {
        $djs = Dj::paginate(10);
        return json_encode(array('success' => true, 'djs' => $djs));
    }

    public function edit($id)
    {
        $dj = Dj::where('id', $id)->firstOrFail();

        if (is_null($dj)) {
            return json_encode(array('success' => false, 'error' => 'The dj does not exist'));
        }

        $dj->genres = explode(',', $dj->genre);

        return json_encode(array('success' => true, 'dj' => $dj));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
            'genres' => 'required',
            'header_image' => 'required|mimes:jpeg,png,jpg,gif',
        ]);

        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => $validator->errors()));
        }

        $header_image_path = null;
        if (!is_null($request->file('header_image'))) {
            $header_image_path = upload_file($request->file('header_image'), 'venue');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'dj',
        ]);

        $dj = Dj::create([
            'vendor_id' => 0,
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'genres' => 'required',
        ]);

        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => $validator->errors()));
        }

        $dj = Dj::where('id', $id)->first();
        if (is_null($dj)) {
            return json_encode(array('success' => false, 'error' => 'The dj does not exist'));
        }

        $header_image_path = null;
        if (!is_null($request->file('header_image'))) {
            $header_image_path = upload_file($request->file('header_image'), 'venue');
        } else {
            $header_image_path = $request->header_image_path;
        }
        if (is_null($header_image_path)) {
            return json_encode(array('success' => false, 'errors' => 'Invalid header image'));
        }

        $dj->description = $request->description;
        $dj->header_image_path = $header_image_path;
        $dj->mixcloud_link = $request->mixcloud_link;
        $dj->genre = implode(',', $request->genres);
        $dj->save();

        $user = User::where('id', $dj->user_id)->firstOrFail();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $this->updateMedia($dj, $request);

        return json_encode(array('success' => true));
    }

    public function createMedia($dj, $request)
    {
        if ($request->hasFile('gallery_image'))
        {
            $path = upload_file($request->file('gallery_image'), 'dj');
            DjMedia::create([
                'dj_id' => $dj->id,
                'type' => 'image',
                'path' => $path
            ]);
        }

        // create media record if the video exists
        if ($request->hasFile('gallery_video'))
        {
            $path = upload_file($request->file('gallery_video'), 'dj');
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
            $path = upload_file($request->file('gallery_image'), 'dj');
            DjMedia::create([
                'dj_id' => $dj->id,
                'type' => 'image',
                'path' => $path
            ]);
        }

        // create media record if the video exists
        if ($request->hasFile('gallery_video'))
        {
            $path = upload_file($request->file('gallery_video'), 'dj');
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
        Dj::where('id', $id)->delete();
        return json_encode(array('success' => true));
    }

    public function approve($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $user->status = 'Approved';
        $user->save();
        return json_encode(array('success' => true));
    }

    public function reject($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $user->status = 'Rejected';
        $user->save();
        return json_encode(array('success' => true));
    }
}