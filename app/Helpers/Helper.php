<?php

namespace App\Helpers;

if (!function_exists('send_sms')) {
    function send_sms($mobile, $message)
    {
        $user = 'webcomnaghilo';
        $pass = 'webcomco1403';
        $fromNum = '+983000505';
        $input_data = array(
            'verification-code' =>$message,
        );
        $rcpt_nm = array($mobile);
        $pattern_code = 'zj9xvrhyabn5vnx';
        $url = 'https://ippanel.com/patterns/pattern?username=' . $user . '&password=' . urlencode($pass) . '&from=' . $fromNum . '&to=' . json_encode($rcpt_nm) . '&input_data=' . urlencode(json_encode($input_data)) . '&pattern_code=' . $pattern_code;
        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($handler);
    }
}