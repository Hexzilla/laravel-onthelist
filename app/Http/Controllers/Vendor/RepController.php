<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RepController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;

        $reps = DB::table('vendor_affiliates')
            ->join('events', 'events.id', '=', 'vendor_affiliates.event_id')
            ->where('events.user_id', '=', $user_id)
            ->select('vendor_affiliates.*', 'events.name as EventName')
            ->paginate(10);

        return view('vendor.reps.index', ['reps' => $reps]);
    }
}
