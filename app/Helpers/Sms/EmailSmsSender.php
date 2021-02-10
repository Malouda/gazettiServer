<?php
/**
 * Created by PhpStorm.
 * User: Malouda
 * Date: 10/8/2017
 * Time: 8:43 PM
 */

namespace App\Helpers\Sms;


use App\Helpers\Interfaces\SmsInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\Invite;

class EmailSmsSender implements SmsInterface
{

    public function sendSms($number,$sendEmail,$msg){


        $email=new Invite($msg);

        if($sendEmail==null){

            Mail::to($number.'@gazetti.com')->send($email);

        }else{


            Mail::to($sendEmail)->send($email);

        }

    }

}