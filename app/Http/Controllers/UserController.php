<?php

namespace App\Http\Controllers;

use App\Group;
use App\Helpers\Sms\SmsComponent;
use App\Invite;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function getUser(Request $request){



       $user=DB::table('users')
            ->join('user_groups','users.user_group_id','=','user_groups.id')
            ->where('users.id','=',$request->user()->id)
            ->select('user_groups.*','users.*')
            ->get();

        return $user;
    }

    public function registerUser(Request $request){



        $result=Invite::where('token','=',$request->invite_token)
            ->where('invited_phone','=',$request->phone)
            ->first();


        if(!empty($result)){


            //check if token expired
            if ($result->token_expired===1){

                return response()->json(['error' => 'Sorry Token Expired'], 404);

            }else{

                //check if phone is already registered
                $phone=User::where('phone','=',$request->phone)->first();
                //check if email is already registered
                $email=User::where('email','=',$request->email)->first();

                if (!empty($phone)){

                    return response()->json(['error' => 'This Phone Number is already Registered'], 404);

                }elseif(!empty($email)){
                    return response()->json(['error' => 'This Email is already Registered'], 404);
                }else{

                    User::create([
                        'fname'=>$request->fname,
                        'lname'=>$request->lname,
                        'username'=>$request->uname,
                        'password'=>Hash::make($request->password),
                        'user_group_id'=>$result->group_id,
                        'publication_id'=>$result->publication_id,
                        'publisher_id'=>$result->publisher_id? $result->publisher_id:null,
                        'location_id'=>$request->location_id,
                        'phone'=>$request->phone,
                        'email'=>$request->email,
                        'age'=>$request->age,
                        'gender_id'=>$request->gender_id,
                    ]);

                    $result->token_expired=1;
                    $result->save();

                }
            }

        }else{

            //Log::info('here');
            return response()->json(['error' => 'Mismatch in Phone number or Invitation code'], 404);
        }
    }

    public function RegisterReader(Request $request){


        $group=Group::where('user_group_name','=','Reader')->first();

        User::create([
            'fname'=>$request->fname,
            'lname'=>$request->lname,
            'username'=>$request->uname,
            'password'=>Hash::make($request->password),
            'user_group_id'=>$group->id,
            'publisher_id'=>null,
            'location_id'=>$request->location_id,
            'phone'=>$request->phone,
            'email'=>$request->email,
            'age'=>$request->age,
            'gender_id'=>$request->gender_id,
        ]);

    }

    public function changePassword(Request $request){

        $newPassword=Hash::make($request->newPassword);
        $oldPassword=$request->oldPassword;

        $user=$request->user();

        if(Hash::check($oldPassword,$user->password)){
            $user->password=$newPassword;
            $user->save();
        }else{

            return response()->json(['error' => 'Wrong old password'], 404);
        }
    }

    public function forgotPassword(Request $request,SmsComponent $smsComponent){

        $invitersPhone=$request->invitorNobileNumber;
        $mobileNumber=$request->oldMobileNumber;

        $letter = chr(rand(65,90));
        $number=rand(100, 999);
        $token=$number.$letter;

        $result=DB::table('invite')
            ->join('users','invite.inviter_id','=','users.id')
            ->where('phone','=',$invitersPhone)
            ->where('invited_phone','=',$mobileNumber)
            ->get();

        if($result->isEmpty()){

            return response()->json(['error' => 'This Details Do not Exist'], 404);
        }else{

            User::where('phone','=',$mobileNumber)
                ->update(['forgot_passwordCode'=>$token,'forgotPasswordCodeUsed'=>0]);

            $smsComponent->sendSms($mobileNumber,$token);

            return 'true';
        }
    }

    public function checkForgotPasswordCode(Request $request){

        $user=User::where('forgot_passwordCode','=',$request->code)
            ->where('forgotPasswordCodeUsed','=',0)
            ->first();

        if($user){

            User::where('forgot_passwordCode','=',$request->code)
                ->where('forgotPasswordCodeUsed','=',0)
                ->update(['forgotPasswordCodeUsed'=>1]);

            return $user->id;
        }else{

            return response()->json(['error' => 'Wrong Code'], 404);
        }
    }

    public function forgotPasswordChange(Request $request){

        $newPassword=Hash::make($request->newPassword);


        User::where('id','=',$request->userId)
            ->update(['password'=>$newPassword]);

    }

    public function editProfile(Request $request){

        $userId=$request->user()->id;

        User::where('id','=',$userId)
            ->update(['fname'=>$request->fname,'lname'=>$request->lname,
                'email'=>$request->email,'age'=>$request->age,'profile_picture_url'=>$request->img_url]);
    }

    public function deleteUserByPublicationId($id){
    
        User::where('publication_id','=',$id)
        ->delete();
    }
}
