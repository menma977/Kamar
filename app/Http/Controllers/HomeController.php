<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function index(Request $request)
  {
    if ($request->now && $request->target) {
      $now = Carbon::parse($request->now)->format("Y-m-d H:i:s");
      $target = Carbon::parse($request->target)->format("Y-m-d H:i:s");
    } else {
      $now = Carbon::now()->subDays(30)->format("Y-m-d H:i:s");
      $target = Carbon::now()->addDay()->format("Y-m-d H:i:s");
    }

    $room = Room::whereBetween("created_at", [$now, $target])->get();

    $data = [
      "room" => $room
    ];

    return view("dashboard", $data);
  }
}
