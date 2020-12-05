<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
  public function index()
  {
    $users = User::all();
    $location = Location::all();

    $data = [
      'users' => $users,
      'location' => $location
    ];

    return view('user.index', $data);
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
      $user = User::find($id);
      if ($request->name) {
        $this->validate($request, [
          'name' => 'required|string',
        ]);
        $user->name = $request->name;
      }
      if ($request->username) {
        $this->validate($request, [
          'username' => 'required|string',
        ]);
        $user->username = $request->username;
      }
      if ($request->password) {
        $this->validate($request, [
          'password' => 'required|string|min:6|same:confirmation_password',
        ]);
        $user->password = Hash::make($request->password);
      }
      if ($request->location) {
        $this->validate($request, [
          'location' => 'required|numeric|exists:locations,id'
        ]);
        $user->location = $request->location;
      }
      $user->save();
    } else {
      $isUpdate = true;
      $user = new User();
      $this->validate($request, [
        'username' => 'required|string|unique:users',
        'name' => 'required|string',
        'password' => 'required|string|min:6|same:confirmation_password',
        'location' => 'required|numeric|exists:locations,id'
      ]);
      $user->name = $request->name;
      $user->username = $request->username;
      $user->password = Hash::make($request->password);
      $user->location = $request->location;
      $user->save();
    }

    if ($isUpdate) {
      return redirect()->back()->withInput(["message" => "User has been update"]);
    }

    return redirect()->back()->withInput(["message" => "User has been add"]);
  }
}
