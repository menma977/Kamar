<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use Auth;

class LocationController extends Controller
{
/**
 * @param Request $request
 * @return JsonResponse
 * @throws ValidationException
 */

    public function store(Request $request, $isUpdate = false, $id = ""){
        $this->validate($request,[
            'address' => 'required|string'
        ]);

        if($isUpdate&&$id){
            $location= Location::find($id);
        }else {
            $location = new Location();
        }

        $location->address = $request->address;
        $location->save();

        return response()->json([
            'response' => 'Successfully add data'
        ],200);
    }

    public function show()
    {
        if(Auth::user()->role =! 1){
            $location = Location::where('id',Auth::user()->location)->get();
        }else{
            $location = Location::all();
        }
       
        return response()->json([
            'data' => $location,
        ], 200);
    }
}
