<?php

namespace App\Services;

class WhatsAppService
{
    public static function send($phone, $message)
    {
        $token = 'teh95EWTb8znDq7RoCNR';

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.fonnte.com/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                "target"  => $phone,
                "message" => $message,
            ],
            CURLOPT_HTTPHEADER => [
                "Authorization: $token"
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);
        // dd($response);
        return $response;
    }
}
