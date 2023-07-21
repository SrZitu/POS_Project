<?php

namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class JWTToken
{

    public static function CreateJWTToken($userEmail, $userId): string
    {
        $key = env('JWT_KEY');

        $payload = [
            'iss' => 'laravel_JWT',
            'iat' => time(),
            'exp' => time() + 60 * 60,
            'userEmail' => $userEmail,
            'userId' => $userId
        ];

        return JWT::encode($payload, $key, 'HS256');
    }
    public static function CreateJWTForResetPassword($userEmail): string
    {
        $key = env('JWT_KEY');

        $payload = [
            'iss' => 'laravel_JWT',
            'iat' => time(),
            'exp' => time() + 60 * 60,
            'userEmail' => $userEmail,
            'userId' => '0'
        ];

        return JWT::encode($payload, $key, 'HS256');
    }

    public static function VarifyToken($token): string|object
    {
        try {

            if ($token === null) {
                return "Unauthorized";
            } else {
                $key = env('JWT_KEY');

                $decoded = JWT::decode($token, new Key($key, 'HS256'));

                return $decoded;
            }
        } catch (Exception $e) {
            return "Unauthorized";
        }
    }
}
