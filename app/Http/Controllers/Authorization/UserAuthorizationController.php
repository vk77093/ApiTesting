<?php

namespace App\Http\Controllers\Authorization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authorization\LoginRequest;
use App\Http\Requests\Authorization\RegisterRequest;
use App\Mail\Authorization\PasswordResetMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserAuthorizationController extends Controller
{
    //user Login Method
    public function LoginHandle(LoginRequest $request){
        try{
            if(Auth::attempt($request->only('email','password'))){
                $user=Auth::user();
                $token=$user->createToken('app')->accessToken;
                return response()->json([
                    'message'=>'Login Successfull',
                    'token'=>$token,
                    'user'=>$user
                ],200);
            }else{
                return response([
                    'message'=>'InValid Email id and Password',
                ],401);
            }

        }catch(Exception $ex){
            return response([
                'message'=>$ex->getMessage()
            ],400);
        }
    }

    //User Registration
    public function UserRegisteration(RegisterRequest $request){

try{


    $user=User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>Hash::make($request->password),
    ]);
    $token=$user->createToken('app')->accessToken;
    return response([
        'message'=>'User Registration Successfully',
        'token'=>$token,
        'user'=>$user,
    ],200);
}catch(Exception $ex){
    return response([
        'message'=>$ex->getMessage()
    ],400);
}
    }
    //Forgot Password Options
    public function ForgotPassword(Request $request){
        $request->validate([
            'email'=>'required|email',
        ]);
            $emailGot=$request->email;

            //$oldEmail=User::where('email',$emailGot)->doesntExist();
            if(User::where('email',$emailGot)->doesntExist()){
            return response()->json([
                'message'=>'Email Id Does not Exists',
            ],401);

        }
        $token=rand(10,10000);
            try{
                $previousData =DB::table('password_reset_tokens')->where('email',$emailGot)->first();

                if($previousData !==null){
                   return response()->json(['message'=>'We had Already Send you the password Reset link']);
               }
                DB::table('password_reset_tokens')->insert([
                    'email'=>$emailGot,
                    'token'=>$token,
                ]);

//sending Mail
Mail::to($emailGot)->send(new PasswordResetMail($token));
return response()->json([
    'message'=>'The password Reset Link is Send To You',

],200);
            }catch(Exception $ex){
                return response([
                    'message'=>$ex->getMessage()
                ],400);
            }

    }

    //Reseeting Password
    public function ResetPassword(Request $request){
$request->validate([
    'token' => 'required',
    'email' => 'required|email',
    'password' => 'required|min:4|confirmed'
]);
try{
   $email= $request->email;
   $token=$request->token;
   $password=Hash::make($request->password);
   $emailCheck=DB::table('password_reset_tokens')->where('email',$email)->first();
   $pinCheck=DB::table('password_reset_tokens')->where('token',$token)->first();
   if(!$emailCheck){
    return response([
        'message'=>'Email Id Not Found'
    ],401);

   }if(!$pinCheck){
    return response([
        'message'=>'Token Does not match',
    ],401);
   }
   //Update The Users
   DB::table('users')->where('email',$email)->update([
    'password'=>$password,
   ]);
   //Delete the Data From Token
   DB::table('password_reset_tokens')->where('email',$email)->delete();

   return response()->json([
    'message'=>'User Password Got Updated'
   ],200);


}catch(Exception $ex){
    return response([
        'message'=>$ex->getMessage()
    ],400);
}

    }

    //Authenticate Users
    public function AuthenticateUser(){
        $currentUser=Auth::user();
        return response()->json([
            'userData'=>$currentUser
        ],200);
    }
}
