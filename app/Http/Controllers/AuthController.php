<?php
/**
 * Created by PhpStorm.
 * User: Imaxinacion
 * Date: 3/7/2019
 * Time: 10:05 AM
 */

namespace App\Http\Controllers;

use Validator;
use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use App\Exceptions;
//use Dotenv\Dotenv;
use Laravel\Lumen\Routing\Controller as BaseController;


class AuthController extends BaseController {

    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function jwt(User $user) {
        $payload = [
          'iss' => "lumen-jwt",
          'sub' => $user->id,
           'iat' => time(),
            'exp' => time() + 60*60
        ];

        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT',
        ];

        return JWT::encode($payload, env('JWT_SECRET'));
    }

    public function authenticate(User $user) {
        $this->validate($this->request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $this->request->input('email'))->first();
        if (!$user) {
            // You wil probably have some sort of helpers or whatever
            // to make sure that you have the same response format for
            // differents kind of responses. But let's return the
            // below respose for now.
            return response()->json([
                'error' => 'Email does not exist.'
            ], 400);
        }

        if (Hash::check($this->request->input('password'), $user->password)) {
            return response()->json([
                'token' => $this->jwt($user)
            ], 200);
        }

        return response()->json([
            'error' => 'Email or password is wrong.'
        ], 400);
    }

}