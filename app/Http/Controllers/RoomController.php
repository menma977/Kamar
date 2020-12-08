<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Room;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class RoomController extends Controller
{
  /**
   * @return Application|Factory|View
   */
  public function index()
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


  public function delete($id)
  {
    Room::destroy($id);

    return redirect()->back()->withInput(["message" => "Room has been deleted"]);
  }
}
