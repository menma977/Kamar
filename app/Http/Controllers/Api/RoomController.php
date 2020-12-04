<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class RoomController extends Controller
{
  /**
   * @param Request $request
   * @param string $name
   * @return JsonResponse
   */
  public function index(Request $request, $name = "")
  {
    $request->validate([
      "booked" => "nullable|string",
      "gender" => "nullable|string",
      "location" => "nullable|string",
      "renter" => "nullable|string",
      "price_lt" => "nullable|numeric",
      "price_gt" => "nullable|numeric"
    ]);
    $rooms = Room::where('name', 'like', '%' . $name . '%');
    if ($request->booked) {
      $rooms = $request->booked == "true" ? $rooms->whereNotNull('join') : $rooms->whereNull('join');
    }
    if ($request->gender) {
      $rooms = $request->gender == 'M' ? $rooms->where("is_man", true) : $rooms->where("is_man", false);
    }
    if ($request->location) {
      $rooms = $rooms->where("location", $request->location);
    }
    if ($request->renter) {
      $rooms = $rooms->where("renter", "LIKE", '%' . $request->renter . '%');
    }
    if ($request->price_lt) {
      $rooms = $rooms->where("price", "<=", $request->price_lt);
    }
    if ($request->price_gt) {
      $rooms = $rooms->where("price", ">=", $request->price_gt);
    }
    return response()->json([
      "data" => $rooms->get()
    ], 200);
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function rent(Request $request)
  {
    $request->validate([
      "room" => "required|exists:rooms,id",
      "renter" => "required|string",
    ]);
    $room = Room::find($request->room);
    $room->renter = $request->renter;
    $room->is_bond = true;
    $room->join = Carbon::now();
    $room->save();
    return response()->json([
      "response" => $room->name . " has successfully rented to " . $room->renter,
      "data" => $room
    ]);
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function delete(Request $request)
  {
    $request->validate([
      "room" => "required|exists:rooms,id"
    ]);
    $room = Room::find($request->room);
    $renter = $room->renter;
    $room->renter = NULL;
    $room->is_bond = false;
    $room->join = NULL;
    $room->save();
    return response()->json([
      "response" => $room->name . " no longer rented to " . $renter,
      "data" => $room
    ]);
  }

  /**
   * @param Request $request
   * @param string $action
   * @param string $id
   * @return JsonResponse
   * @throws ValidationException
   */
  public function store(Request $request, $action = "create", $id = "")
  {
    $this->validate($request, [
      'name' => 'required|string',
      'price' => 'required|numeric',
      'is_man' => 'required|string',
      'location' => 'required|numeric|exists:locations,id',
      'image' => 'nullable|image|size:' . (8 * 1024)
    ]);

    if ($action == 'update' && $id) {
      $room = Room::find($id);
    } else {
      $room = new Room();
    }

    $room->location = $request->location;
    $room->name = $request->name;
    $room->price = $request->price;
    $room->is_man = $request->is_man;
    if ($request->hasFile('image')) {
      Storage::delete($room->image);
      $path = Storage::putFileAs("public/room/", $request->file("image"), $room->id);
      $room->image = $path;
    }
    $room->save();

    return response()->json([
      'response' => 'Successfully add data',
    ], 200);
  }
}
