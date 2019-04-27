<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Firebase\JWT\JWT;
use App\Services\IJwt;

class JwtAuth
{

  private $jwtService;

  public function __construct(IJwt $jwtService)
  {
    $this->jwtService = $jwtService;
  }

  /**
   * Run the request filter.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    if (!$request->hasHeader('Authorization')) {
      return response()->json(['error' => 'Authorization Header not found'], 401);
    }

    $token = $request->bearerToken();

    if ($request->header('Authorization') == null || $token == null) {
      return response()->json(['error' => 'No token provided'], 401);
    }

    $user = $this->jwtService->toUser($token);
    
    if (!$user instanceof User) {
      return response()->json($user, 401);
    }

    $request->auth = $user;
    return $next($request);
  }

}