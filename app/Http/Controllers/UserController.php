<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken as HelperJWTToken;
use App\Mail\OTPEmail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    function UserLogin(Request $request){

            $counts =  User::where('email','=',$request->input('email'))
            ->where('password','=',$request->input('password'))
            ->count();

            if($counts==1){
                $token = HelperJWTToken::CreateToken($request->input('email'));
                return response()->json([
                    'status'=>'success',
                    'message' => 'User Login Succcessfuly',
                    'token'=> $token
                    ]);
            }else{
                return response()->json([
                    'status'=>'failed',
                    'message' => 'User Login Failed'
                    ]);
            }
    }

    function UserRegistration(Request $request){
        try{

            User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'password' => $request->input('password'),
               ]);
    
               return response()->json([
                'status'=>'success',
                'message' => 'User Registration Succcessfuly'
                ]);

        }catch(Exception $e){
            return response()->json([
                'status'=>'failed',
                'message' => 'User Registration Failed'
                ]);
        }
          
    }


    function sendOtpToUserEmail(Request $request){
         $userEmail = $request->input('email');
         $otp = rand(1000,9999);
         $res = User::where($request->input())->count();
         if($res==1){
            Mail::to($userEmail)->send(new OTPEmail($otp));
            User::where($request->input())->update(['otp'=>$otp]);

            return response()->json([
                'status'=>'success',
                'message' => 'OTP Send To Your Email'
                ]);

         }else{
            return response()->json([
                'status'=>'failed',
                'message' => 'Unothorize'
                ]);
           
         }
    }

    function OtpVerify(Request $request){
      
        $email = $request->input('email');
        $otp = $request->input('otp');

        $count = User::where('email','=',$email)
                ->where('otp','=', $otp)
                ->count();

        if($count==1){
            User::where('email','=',$email)->update(['otp'=>'0']);
            $token = HelperJWTToken::CreateTokenForSetPassword($request->input('email'));
            return response()->json([
                'status'=>'success',
                'message' => 'OTP Verification Successfull',
                'token'=> $token
            ]);
           
        }else{
            return response()->json([
                'status'=>'failed',
                'message' => 'Unothorize'
                ]);
        }
    }

    function SetPassword(Request $request){

        try{
            $email = $request->header('email');
            $password = $request->input('password');
            User::where('email','=',$email)->update(['password'=>$password]);

            return response()->json([
                'status'=>'success',
                'message' => 'Password Reset Succcessfuly'
                ]);
        }catch(Exception $e){

            return response()->json([
                'status'=>'failed',
                'message' => 'User Registration Failed'
                ]);
                
        }

      
        return response()->json(['msg'=>'success','data' => 'Updated']);
    }


    function ProfileUpdate(){
        
    }

    
}
