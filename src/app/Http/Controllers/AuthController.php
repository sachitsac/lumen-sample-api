<?php

namespace App\Http\Controllers;

use App\User;
use Firebase\JWT\JWT;
use App\Services\IJwt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  protected $jwtService;

  public function __construct(IJwt $jwtService)
  {
    $this->jwtService = $jwtService;
  }

  public function __invoke(Request $request)
  {
    $this->validate($request, [
      'email'     => 'required|email',
      'password'  => 'required'
    ]);

    $user = User::where('email', $request->input('email'))->first();

    if (!$user) {
      return response()->json([
        'error' => 'Email does not exist.'
      ], 400);
    }

    if (Hash::check($request->input('password'), $user->password)) {
      return response()->json([
        'token' => $this->jwtService->fromUser($user)
      ], 200);
    }

    return response()->json([
      'error' => 'Email or password is wrong.'
    ], 400);
  }
}