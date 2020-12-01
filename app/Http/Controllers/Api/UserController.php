<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
  /**
   * @param Request $request
   * @return JsonResponse
   * @throws ValidationException
   */
  public function login(Request $request)
  {
    $this->validate($request, [
      'username' => 'required|string|exists:users,username',
      'password' => 'required|string',
    ]);
    try {
      if (Auth::attempt(['username' => request('username'), 'password' => request('password')])) {
        foreach (Auth::user()->tokens as $key => $value) {
          $value->revoke();
        }
        $user = Auth::user();
        $user->token = $user->createToken('Android')->accessToken;
        return response()->json([
          'token' => $user->token,
          'role' => $user->role,
          'name' => $user->name,
          'location' => $user->Location
        ], 200);
      }
    } catch (Exception $e) {
      Log::error($e->getMessage() . " - " . $e->getFile() . " - " . $e->getLine());
    }
    $data = [
      'message' => 'The given data was invalid.',
      'errors' => [
        'validation' => ['Invalid username or password.'],
      ],
    ];
    return response()->json($data, 500);
  }

  /**
   * @return JsonResponse
   */
  public function logout()
  {
    $token = Auth::user()->tokens;
    foreach ($token as $key => $value) {
      $value->delete();
    }
    return response()->json([
      'response' => 'Successfully logged out',
    ], 200);
  }

  /**
   * @return JsonResponse
   */
  public function show()
  {
    $user = Auth::user();

    return response()->json([
      'role' => $user->role,
      'name' => $user->name,
      'username' => $user->location()
    ], 200);
  }

  /**
   * @param Request $request
   * @return JsonResponse
   * @throws ValidationException
   */
  public function update(Request $request)
  {
    $user = User::find(Auth::id());
    if ($request->name) {
      $this->validate($request, [
        'name' => 'required|string',
      ]);
      $user->name = $request->name;
    }

    if ($request->name) {
      $this->validate($request, [
        'role' => 'required|numeric',
      ]);
      $user->role = $request->role;
    }

    if ($request->location) {
      $this->validate($request, [
        'location' => 'required|numeric|exists:locations,id',
      ]);
      $user->location = $request->location;
    }

    $user->save();

    return response()->json([
      'response' => 'Successfully update',
    ], 200);
  }
}
