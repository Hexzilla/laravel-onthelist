<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Plan;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::get();

        if(count($plans) == 0) {
            return json_encode(array('success' => false, 'error' => 'Failed to get plan'));
        }

        return json_encode(array('success' => true, 'plans' => $plans));
    }

    public function add_plan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => $validator->errors()));
        }
        
        Plan::create([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return json_encode(array('success' => true));
    }

    public function remove_plan($id)
    {
        $plan = Plan::where('id', $id)->first();
        if (is_null($plan)) {
            return json_encode(array('success' => false, 'error' => 'The plan does not exist.'));
        }
        $plan->delete();
        return json_encode(array('success' => true));
    }
}
