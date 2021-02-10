<?php
/**
 * Created by PhpStorm.
 * User: Malouda
 * Date: 10/16/2017
 * Time: 9:46 AM
 */

namespace App\Helpers\Email;


use App\Helpers\Interfaces\EmailViewInterface;
use App\Mail\Views;
use Illuminate\Support\Facades\Mail;

class EmailView implements EmailViewInterface
{

    public function sendEmail($subject,$view,$user,$sendEmail){

        $view=new Views($subject,$view,$user);

        Mail::to($sendEmail)->send($view);
    }
}