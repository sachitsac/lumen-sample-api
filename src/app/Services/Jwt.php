<?php

namespace App\Services;

use App\User;
use App\Guest;
use Exception;
use App\Services\IJwt;
use Firebase\JWT\JWT as JwtToken;
use Firebase\JWT\ExpiredException;

class Jwt implements IJwt
{
  public function fromUser(User $user): string
  {
    $payload = [
      'iss' => "coding-challenge",
      'sub' => $user->id,
      'iat' => time(),
      'exp' => time() + 60 * 60
    ];

    return JwtToken::encode($payload, env('JWT_SECRET'));
  }

  public function toUser(string $token)
  {
    try {
      $credentials = JwtToken::decode($token, env('JWT_SECRET'), ['HS256']);
    } catch (ExpiredException $e) {
      return [ 'error' => 'Provided token is expired.'];
    } catch (Exception $e){
      return ['error' => 'An error while decoding token.'];
    }

    return User::find($credentials->sub);
  }
}