<?php
/**
 * Created by PhpStorm.
 * User: Malouda
 * Date: 9/20/2017
 * Time: 11:56 PM
 */

namespace App\Helpers\Sms;


use App\Helpers\Interfaces\SmsInterface;

class SmsComponent
{
    protected $smsLink;

    public function __construct(SmsInterface $smsLink)
    {
        $this->smsLink=$smsLink;
    }

    public function sendSms($number,$email,$msg){

        $this->smsLink->sendSms($number,$email,$msg);
    }

}