<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Dj;
use App\Models\Venue;
use App\Models\DjMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DjController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $djs = Dj::where('user_id', $user_id)->get();
        return view('vendor.dj.list', ['djs' => $djs]);
    }

    public function create()
    {
        return view('vendor.dj.create', [
            'title' => 'Create',
            'action' => route('vendors.dj.store'),
            'dj' => NULL,
        ]);
    }

    public function edit($id)
    {
        $dj = Dj::where('id', $id)->firstOrFail();

        if (is_null($dj)) {
            return redirect()->route('vendors.dj.index');
        }

        $dj->genres = explode(',', $dj->genre);

        return view('vendor.dj.create', [
            'title' => 'Edit',
            'action' => route('vendors.dj.update', $id),
            'dj' => $dj,
        ]);
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $request->validate([
            'name' => 'required',
            'genres' => 'required',
            'header_image' => 'required|mimes:jpeg,png,jpg,gif',
        ]);

        $header_image_path = null;
        if (!is_null($request->file('header_image'))) {
            $header_image_path = upload_file($request->file('header_image'), 'venue');
        }

        $dj = Dj::create([
            'user_id' => $user_id,
            'name' => $request->name,
            'description' => $request->description,
            'header_image_path' => $header_image_path,
            'mixcloud_link' => $request->mixcloud_link,
            'genre' => implode(',', $request->genres),
        ]);

        $this->createMedia($dj, $request);

        return redirect()->route('vendors.dj.index');
    }

    public function update(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        $request->validate([
            'name' => 'required',
            'genre' => 'required',
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

        $dj->user_id = $user_id;
        $dj->name = $request->name;
        $dj->description = $request->description;
        $dj->header_image_path = $header_image_path;
        $dj->mixcloud_link = $request->mixcloud_link;
        $dj->genre = $request->genre;
        $dj->save();        

        $this->updateMedia($dj, $request);

        return redirect()->route('vendors.dj.index');
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
        return redirect()->route('vendors.dj.index')->with('Success');
    }
}
