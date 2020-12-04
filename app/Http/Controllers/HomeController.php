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
      $now = Carbon::parse($request->now);
      $target = Carbon::parse($request->target);
    } else {
      $now = Carbon::now()->subDays(30);
      $target = Carbon::now()->addDay();
    }

    $room = Room::whereBetween('created_at', [$now, $target])->get();


    $data = [
      'room' => $room
    ];

    return view("dashboard", $data);
  }
}
