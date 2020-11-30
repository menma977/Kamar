<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RoomController extends Controller
{
  /**
   * @param Request $request
   * @param bool $isUpdate
   * @param string $id
   * @return JsonResponse
   * @throws ValidationException
   */
  public function store(Request $request, $isUpdate = false, $id = "")
  {
    $this->validate($request, [
      'name' => 'required|string',
      'price' => 'required|numeric',
      'is_man' => 'required|string',
      'location' => 'required|numeric|exists:locations,id'
    ]);

    if ($isUpdate && $id) {
      $room = Room::find($id);
    } else {
      $room = new Room();
    }

    $room->location = $request->location;
    $room->name = $request->name;
    $room->price = $request->price;
    $room->is_man = $request->is_man;
    $room->save();

    return response()->json([
      'response' => 'Successfully add data',
    ], 200);
  }
}
