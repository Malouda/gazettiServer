<?php
/**
 * Created by PhpStorm.
 * User: Malouda
 * Date: 9/20/2017
 * Time: 11:50 PM
 */

namespace App\Helpers\Interfaces;

use App\Helpers\Sms\KannelSmsSender;

interface SmsInterface{

    public function sendSms($number,$email,$msg);
}