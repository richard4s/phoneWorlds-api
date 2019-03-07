<?php
/**
 * Created by PhpStorm.
 * User: Imaxinacion
 * Date: 3/6/2019
 * Time: 11:55 PM
 */

namespace App\Http\Controllers;

use \Illuminate\Http\Request;
use App\User;
use \Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
//use App\User;

class RegisterController extends Controller {

    public function __construct() {
//        $this->middleware('authenticate');
    }

    public function store(Request $request) {
        if($request->all()) {

            try {
                $user = User::create([
                    'firstName' => $request['firstName'],
                    'lastName' => $request['lastName'],
                    'email' => $request['email'],
                    'password' => Hash::make($request['password']),
                    'number' => $request['number'],
                    'birthDate' => $request['birthDate'],
                    'role' => $request['role']
                ]);

                return response()->json('User Created Successfully!', 200, [], JSON_PRETTY_PRINT);
            } catch(QueryException $ex){
                return response()->json($ex->getMessage());
            }

        }

        return response()->json('No request data sent', 200, [], JSON_PRETTY_PRINT);
    }
}