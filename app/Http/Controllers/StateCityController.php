<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class StateCityController extends Controller
{
    public function getState(Request $request)
    {
    	//print_r("expression");die;
    	$states = DB::table("states")->where('country_id', $request->country_id)->pluck("name", "id");
    	return response()->json($states);
    }

    public function getCity(Request $request)
    {
    	$cities = DB::table("cities")->where('state_id', $request->state_id)
    				->pluck("name", "id");
    	return response()->json($cities);
    }
}
