<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $location = new Location();
    $location->address = "awww";
    $location->save();

    $location = new Location();
    $location->address = "qeeee";
    $location->save();

    $location = new Location();
    $location->address = "wrrrr";
    $location->save();

    $user = new User();
    $user->role = 1;
    $user->name = "ADMIN";
    $user->username = "admin";
    $user->password = Hash::make("admin");
    $user->location = $location->id;
    $user->save();

    $user = new User();
    $user->name = "USER";
    $user->username = "user";
    $user->password = Hash::make("user");
    $user->location = $location->id;
    $user->save();
  }
}
