<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

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
          'wallet' => $user->wallet,
          'account_cookie' => $user->account_cookie,
          'phone' => $user->phone,
          'username' => $user->username_doge,
          'password' => $user->password_doge
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
}
