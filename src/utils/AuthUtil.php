<?php

use \Firebase\JWT\JWT;

class AuthUtil
{
    public static function createJWT(User $user, JWTProperties $JWTProperties): string
    {
        return JWT::encode(array(
            "iss" => $JWTProperties->iss,
            "aud" => $JWTProperties->aud,
            "iat" => $JWTProperties->iat,
            "nbf" => $JWTProperties->nbf,
            "data" => array(
                "id" => $user->id,
                "username" => $user->username,
            )),
            $JWTProperties->key, JWT_ALGORITHM);
    }
}