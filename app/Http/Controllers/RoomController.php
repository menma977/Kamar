<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        $location = Location::all();

        $data = [
          'rooms' => $rooms,
          'location' => $location
        ];

        return view('room.index',$data);
    }


    public function store(Request $request, $id = null)
    {
      $isUpdate = false;
      if ($id) {
        $room = Room::find($id);
        if ($request->name) {
          $this->validate($request, [
            'name' => 'required|string',
          ]);
          $room->name = $request->name;
        }
        if ($request->price) {
          $this->validate($request, [
            'price' => 'required|numeric',
          ]);
          $room->price = $request->price;
        }
        if ($request->image) {
          $this->validate($request, [
            'image' => 'required|image',
          ]);
          $room->image = $request->image;
        }
        if ($request->is_bond) {
          $this->validate($request, [
            'is_bond' => 'nullable|boolean'
          ]);
          $room->is_bond = $request->is_bond;
        }
        if ($request->is_man) {
          $this->validate($request, [
            'is_man' => 'required|boolean'
          ]);
          $room->is_man = $request->is_man;
        }
        if ($request->renter) {
          $this->validate($request, [
            'renter' => 'nullable|string'
          ]);
          $room->renter = $request->renter;
        }
        if ($request->join) {
          $this->validate($request, [
            'join' => 'nullable|date'
          ]);
          $room->join = $request->join;
        }
        if ($request->item) {
          $this->validate($request, [
            'item' => 'nullable|item'
          ]);
          $room->item = $request->item;
        }
        if ($request->location) {
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
          'image' => 'nullable|image',
          'is_bond' => 'nullable|boolean',
          'is_man' => 'required|boolean',
          'renter' => 'nullable|string',
          'join' => 'nullable|string',
          'item' => 'nullable|numeric',
          'location' => 'required|numeric|exists:locations,id'
        ]);
        $room->name = $request->name;
        $room->price = $request->price;
        $room->image = $request->image;
        $room->is_bond = $request->is_bond;
        $room->is_man = $request->is_man;
        $room->renter = $request->renter;
        $room->join = $request->join;
        $room->item = $request->item;
        $room->location = $request->location;
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
