<?php

namespace Database\Seeders;

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
    $user = new User();
    $user->role = 1;
    $user->name = "ADMIN";
    $user->username = "admin";
    $user->password = Hash::make("admin");
    $user->save();

    $user = new User();
    $user->role = 1;
    $user->name = "USER";
    $user->username = "user";
    $user->password = Hash::make("user");
    $user->save();
  }
}
