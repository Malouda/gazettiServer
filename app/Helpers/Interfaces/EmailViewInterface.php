<?php
/**
 * Created by PhpStorm.
 * User: Malouda
 * Date: 10/16/2017
 * Time: 9:00 AM
 */

namespace App\Helpers\Interfaces;


interface EmailViewInterface
{

    public function sendEmail($subject,$view,$user,$sendEmail);
}