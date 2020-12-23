<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;
use App\Models\Room;

class RoomSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $location = Location::first();

    $room = new Room();
    $room->location = $location->id;
    $room->name = "ASDF";
    $room->price = "200000";
    $room->is_man = true;
    $room->save();

    $room = new Room();
    $room->location = $location->id;
    $room->name = "ASDFG";
    $room->price = "500000";
    $room->is_man = false;
    $room->save();
  }
}
