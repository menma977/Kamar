<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use App\Models\Location;
use App\Models\Room;
use App\Models\History;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function index()
  {
    $location = Location::all();
    $locationCount = $location->count();
    $rooms = Room::all();
    $roomsBooked = $rooms->where('is_bond',true)->count();
    $roomsAvailable = $rooms->where('is_bond',false)->count();
    //Bar Chart
    $locationId = Location::get(['id'])->pluck('id');
    $bookedRooms = Room::whereIn('location',$locationId)
      ->get()
      ->groupBy('location')
      ->map(function ($item){
        $item->r = $item->where('is_bond',true)->count();

        return $item;
      })
      ->pluck('r');

    $allRooms = Room::whereIn('location',$locationId)
      ->get()
      ->groupBy('location')
      ->map(function ($item){
        $item->r = $item->count();

        return $item;
      })
      ->pluck('r');
    //bar chart end

    //booked room history bar chart
      $history = History::orderBy('join','asc')
      ->whereIn('location',$locationId)
      ->get()
      ->groupBy(function ($item){
        return Carbon::parse($item->join)->format("M");

      })
      ->map(function ($item){
        $h = [];
        foreach (Location::all()->pluck('address') as $key => $value) {
          $h[$value]=0;
        }

        foreach ($item as $key => $subItem) {
          $findLocation = Location::find($subItem->location);
          $h[$findLocation->address]+=1;
        }
        return $h;
      });
    //booked room history bar chart end

    $data = [
      "location" => $location,
      "bookedRooms" => $bookedRooms,
      "allRooms" => $allRooms,
      "rooms" => $rooms->count(),
      "roomsBooked" => $roomsBooked,
      "roomsAvailable" => $roomsAvailable,
      "locationCount" => $locationCount,
      "history" => $history,
    ];

    return view("dashboard", $data);
  }
}
