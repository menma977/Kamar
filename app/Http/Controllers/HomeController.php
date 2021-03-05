<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use App\Models\Location;
use App\Models\Room;
use App\Models\History;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
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
    $history = History::whereYear('join',Carbon::now())
    ->get()
    ->groupBy('location')
    ->map(function($item,$index){
      $m = [1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0,11=>0,12=>0];
      $item->loc = Location::find($index)->address;
      $item->i = $item->groupBy(function($item){
        return (int)Carbon::parse($item->join)->format('m');
      });
      foreach ($item->i as $key => $value) {
        $m[$key] = $value->count();
      }
      $item->i = $m;
      return $item;
    })->pluck('i','loc');


    //Rent due is near and renter has not paid
    $rentDue = Room::where('is_bond',true)
    ->where('payment',false)
    ->whereBetween('end',[Carbon::now(),Carbon::now()->addDays(5)->toDateString()])
    ->get();

    $data = [
      "location" => $location,
      "bookedRooms" => $bookedRooms,
      "allRooms" => $allRooms,
      "rooms" => $rooms->count(),
      "roomsBooked" => $roomsBooked,
      "roomsAvailable" => $roomsAvailable,
      "locationCount" => $locationCount,
      "history" => $history,
      "rentDue" => $rentDue
    ];

    return view("dashboard", $data);
  }
}
