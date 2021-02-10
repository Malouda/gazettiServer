<?php
/**
 * Created by PhpStorm.
 * User: Malouda
 * Date: 9/20/2017
 * Time: 11:59 PM
 */

namespace App\Helpers\Sms;


use App\Helpers\Interfaces\SmsInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class KannelSmsSender implements SmsInterface
{
    public function sendSms($number,$msg){

        $server_address=env('KANNEL_SERVER_ADDRESS');
        $server_port=env('KANNEL_SERVER_PORT');
        $url=env('KANNEL_URL');
        $username=env('KANNEL_USERNAME');
        $password=env('KANNEL_PASSWORD');
        $from_number=env('KANNEL_FROM_NUMBER');

        $full_url=$server_address.':'
            .$server_port.'/'
            .$url.'username='
            .$username
            .'&password='
            .$password
            .'&from='
            .$from_number
            .'&to='
            .$number
            .'&text='
            .$msg;

       $client = new Client(['base_uri' => $full_url]);

        $response = $client->request('GET');



    }


}