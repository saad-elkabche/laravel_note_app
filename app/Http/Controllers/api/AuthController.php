<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){

    }
    public function register(Request $request){
        $validator=Validator::make($request->all(),[
            "email"=> ['required','email','unique:users,email'],
            "password"=>["required"],
            "name"=>["required"],
        ]);
        if($validator->fails()){
            return response()->json(
                [
                    "status"=> "error",
                    'errors'=>$validator->errors()
                ]
            );
        }
       $user=new User();
       
       $user->email=$request->email;
       $user->name=$request->name;
       $user->password=Hash::make($request->password);
       $user->save();
       
        $token=$user->createToken('api-token')->plainTextToken;
        return response()->json(
            [
                'status'=> 'success',
                'token'=> $token,
            ]
            );
    }
}
