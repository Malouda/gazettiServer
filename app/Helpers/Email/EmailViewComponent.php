<?php
/**
 * Created by PhpStorm.
 * User: Malouda
 * Date: 10/16/2017
 * Time: 9:01 AM
 */
namespace App\Helpers\Email;

use \App\Helpers\Interfaces\EmailViewInterface;
class EmailViewComponent
{

    protected $emailView;

    public function __construct(EmailViewInterface $emailView)
    {
        $this->emailView=$emailView;
    }

    public function sendEmail($subject,$view,$user,$sendEmail){

        $this->emailView->sendEmail($subject,$view,$user,$sendEmail);
    }

}