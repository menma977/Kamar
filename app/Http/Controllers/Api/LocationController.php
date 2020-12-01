<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Location;
use Auth;
use Illuminate\Validation\ValidationException;

class LocationController extends Controller
{
  /**
   * @param Request $request
   * @param bool $isUpdate
   * @param string $id
   * @return JsonResponse
   * @throws ValidationException
   */
  public function store(Request $request, $id = "")
  {
    if (Auth::user()->role == 2) {
      return response()->json([
        'response' => 'Successfully add data'
      ], 500);
    }

    $this->validate($request, [
      'address' => 'required|string'
    ]);

    if ($id) {
      $location = Location::find($id);
    } else {
      $location = new Location();
    }

    $location->address = $request->address;
    $location->save();

    return response()->json([
      'response' => 'Successfully add data'
    ], 200);
  }

  /**
   * @return JsonResponse
   */
  public function show()
  {
    if (Auth::user()->role = !1) {
      $location = Location::where('id', Auth::user()->location)->get();
    } else {
      $location = Location::all();
    }

    return response()->json([
      'data' => $location,
    ], 200);
  }


}
