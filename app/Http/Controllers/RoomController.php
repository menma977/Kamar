<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Room;
use App\Models\History;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Carbon;

class RoomController extends Controller
{
  /**
   * @return Application|Factory|View
   */
  public function index(Request $request, $name = "")
  {
    $rooms = Room::all();
    $location = Location::all();

    $data = [
      'rooms' => $rooms,
      'location' => $location
    ];

    return view('room.index', $data);
  }

  /**
   * @param Request $request
   * @param null $id
   * @return RedirectResponse
   * @throws ValidationException
   */
  public function store(Request $request, $id = null)
  {
    $isUpdate = false;
    if ($id) {
      $room = Room::find($id);
      if ($request->has("name")) {
        $this->validate($request, [
          'name' => 'required|string',
        ]);
        $room->name = $request->name;
      }
      if ($request->has("price")) {
        $this->validate($request, [
          'price' => 'required|numeric',
        ]);
        $room->price = $request->price;
      }
      if ($request->has("image")) {
        $this->validate($request, [
          'image' => 'required|image',
        ]);
        $room->image = $request->image;
      }
      if ($request->has("is_bond")) {
        $this->validate($request, [
          'is_bond' => 'required|boolean'
        ]);
        $room->is_bond = $request->is_bond;
      }
      if ($request->has("is_man")) {
        $this->validate($request, [
          'is_man' => 'required|boolean'
        ]);
        $room->is_man = $request->is_man;
      }
      if ($request->has("renter")) {
        $this->validate($request, [
          'renter' => 'required|string'
        ]);
        $room->renter = $request->renter;
      }
      if ($request->has("join")) {
        $this->validate($request, [
          'join' => 'required|date'
        ]);
        $room->join = $request->join;
      }
      if ($request->has("item")) {
        $this->validate($request, [
          'item' => 'required|item'
        ]);
        $room->item = $request->item;
      }
      if ($request->has("location")) {
        $this->validate($request, [
          'location' => 'required|numeric|exists:locations,id'
        ]);
        $room->location = $request->location;
      }
      $room->save();
    } else {
      $isUpdate = true;
      $room = new Room();
      $this->validate($request, [
        'name' => 'required|string',
        'price' => 'required|numeric',
        'is_man' => 'required|boolean',
        'location' => 'required|numeric|exists:locations,id'
      ]);
      $room->name = $request->input("name");
      $room->price = $request->input("price");
      $room->is_man = $request->input("is_man");
      $room->location = $request->input("location");
      $room->save();
    }

    if ($isUpdate) {
      return redirect()->back()->withInput(["message" => "Room has been update"]);
    }

    return redirect()->back()->withInput(["message" => "Room has been add"]);
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
      "payment" => "nullable|boolean",
      "item" => "nullable|numeric"
    ]);

    switch($request->input("action")){
      case 'extend':
        $room = Room::find($request->room);
        $room->renter = $request->renter;
        $room->is_bond = true;
        $room->payment = $request->input("payment");
        $room->item = $request->item;
        $room->end = Carbon::now()->addMonth(1);

        $history = new History();
        $history->roomId = $request->room;
        $history->location = $room->location;
        $history->join = $room->join;
        $history->end = $room->end;
        $history->save();
        $room->save();

        return redirect()->back()->withInput(["message" => "Rent has been extended"]);
        break;

      case 'add':
        $room = Room::find($request->room);
        $room->renter = $request->renter;
        $room->is_bond = true;
        $room->payment = $request->input("payment");
        $room->item = $request->item;
        $room->join = Carbon::now();
        $room->end = Carbon::now()->addMonth(1);

        $history = new History();
        $history->roomId = $request->room;
        $history->location = $room->location;
        $history->join = $room->join;
        $history->end = $room->end;
        $history->save();
        $room->save();

        return redirect()->back()->withInput(["message" => "Renter has been added"]);
        break;

      case 'edit':
        $room = Room::find($request->room);
        $room->renter = $request->input("renter");
        $room->payment = $request->input("payment");
        $room->item = $request->input("item");
        $room->save();

        return redirect()->back()->withInput(["message" => "Rent detail has been updated"]);
        break;
    }
  }

  public function deleteRenter($id)
  {
    $room = Room::find($id);
    $renter = $room->renter;
    $room->renter = NULL;
    $room->is_bond = false;
    $room->join = NULL;
    $room->end = NULL;
    $room->item = 0;
    $room->save();

    return redirect()->back()->withInput(["message" => "Renter has been added"]);
  }

  public function payment($id){
    $room = Room::find($id);
    $room->payment = true;
    $room->save();

    return redirect()->back()->withInput(["message" => "Renter has paid the fee"]);
  }

  public function delete($id)
  {
    Room::destroy($id);

    return redirect()->back()->withInput(["message" => "Room has been deleted"]);
  }
}
