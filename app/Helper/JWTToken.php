<?php

namespace App\Helper;

use App\Models\User;
use Carbon\Exceptions\Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

    class JWTToken{

        public static function CreateToken($userEmail):string{

            $key = env('JWT_KEY');

            $payload = [
                'iss' => 'laravel JWT',
                'iat' => time(),
                'exp' => time() + 60*60,
                'userEmail' => $userEmail
            ];

            return JWT::encode($payload, $key,'HS256');
        }


        public static function CreateTokenForSetPassword($userEmail):string{

            $key = env('JWT_KEY');

            $payload = [
                'iss' => 'laravel JWT',
                'iat' => time(),
                'exp' => time() + 60*20,
                'userEmail' => $userEmail
            ];

            return JWT::encode($payload, $key,'HS256');
            
        }

        public static function VrerifyToken($token):string{

            try{
                $key = env('JWT_KEY');
                $decoded = JWT::decode($token, new Key($key, 'HS256'));
                return $decoded->userEmail;
            }catch(Exception $e){
                return 'Unothorize';
            }

           
        }


      


    }