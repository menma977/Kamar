<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\History;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
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
      "location" => "nullable|string|exists:locations,id",
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

    $user = Auth::user();
    if($user->role == 1){
      return response()->json([
        "data" => $rooms->get()
      ], 200);
    }

    return response()->json([
      "data" => $rooms->where("location",$user->location)->get()
    ], 200);
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function addRenter(Request $request)
  {
    $request->validate([
      "room" => "required|exists:rooms,id",
      "renter" => "required|string",
      "payment" => "nullable|boolean",
      "item" => "nullable|numeric"
    ]);
    $room = Room::find($request->room);
    $room->renter = $request->renter;
    $room->item = $request->item;
    $room->payment = $request->payment;
    $room->is_bond = true;
    $room->join = Carbon::now();
    $room->end = Carbon::now()->addMonth(1)->toDateString();

    $history = new History();
    $history->roomId = $request->room;
    $history->location = $room->location;
    $history->join = $room->join;
    $history->end = $room->end;
    $history->save();
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
  public function editRenter(Request $request){
    $request->validate([
      "room" => "required|exists:rooms,id",
      "renter" => "required|string",
      "payment" => "nullable|boolean",
      "item" => "nullable|numeric"
    ]);

    $room = Room::find($request->room);
    $room->renter = $request->renter;
    $room->payment = $request->payment;
    $room->item = $request->item;
    $room->save();

    return response()->json([
      "response" => "Rent detail has been updated",
      "data" => $room
    ]);
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function extendRenter(Request $request){
    $request->validate([
      "room" => "required|exists:rooms,id",
      "renter" => "required|string",
      "payment" => "nullable|boolean",
      "item" => "nullable|numeric"
    ]);

    $room = Room::find($request->room);
    $room->renter = $request->renter;
    $room->is_bond = true;
    $room->payment = $request->payment;
    $room->item = $request->item;
    $room->end = Carbon::now()->addMonth(1)->toDateString();

    $history = new History();
    $history->roomId = $request->room;
    $history->location = $room->location;
    $history->join = $room->join;
    $history->end = $room->end;
    $history->save();
    $room->save();

    return response()->json([
      "response" => "Rent has been extended",
      "data" => $room
    ]);
  }


  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function deleteRenter(Request $request)
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

  public function delete(Request $request)
  {
    $request->validate([
      "room" => "required|exists:rooms,name"
    ]);

    Room::destroy($request->room);

    return response()->json([
      'response' => 'Successfully delete room',
    ], 200);
  }

}
