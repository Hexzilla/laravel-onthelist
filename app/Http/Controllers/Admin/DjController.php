<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dj;
use App\Models\User;
use App\Models\Venue;
use App\Models\DjMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class DjController extends Controller
{
    public function index()
    {
        $djs = Dj::paginate(10);
        return view('admin.dj.list', ['djs' => $djs]);
    }

    public function create()
    {
        return view('admin.dj.create', [
            'title' => 'Create',
            'action' => route('admin.djs.store'),
            'dj' => NULL,
        ]);
    }

    public function edit($id)
    {
        $dj = Dj::where('id', $id)->first();

        if (is_null($dj)) {
            return redirect()->route('admin.djs.index');
        }

        $dj->genres = explode(',', $dj->genre);

        return view('admin.dj.create', [
            'title' => 'Edit',
            'action' => route('admin.djs.update', $id),
            'dj' => $dj,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
            'genres' => 'required',
            'header_image' => 'required|mimes:jpeg,png,jpg,gif',
        ]);

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

        return redirect()->route('admin.djs.index');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'genres' => 'required',
        ]);

        $dj = Dj::find($id);

        $header_image_path = null;
        if (!is_null($request->file('header_image'))) {
            $header_image_path = upload_file($request->file('header_image'), 'venue');
        } else {
            $header_image_path = $request->header_image_path;
        }
        if (is_null($header_image_path)) {
            return redirect()->back()->with(['errors' => 'Invalid header image']);
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

        return redirect()->route('admin.djs.index');
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
        return redirect()->route('admin.djs.index')->with('Success');
    }

    public function approve($id)
    {
        $user = User::where('id', $id)->first();
        if(is_null($user)) {
            return redirect()->back();
        }
        $user->status = 'Approved';
        $user->save();
        return redirect()->back();
    }

    public function reject($id)
    {
        $user = User::where('id', $id)->first();
        if(is_null($user)) {
            return redirect()->back();
        }
        $user->status = 'Rejected';
        $user->save();
        return redirect()->back();
    }
}