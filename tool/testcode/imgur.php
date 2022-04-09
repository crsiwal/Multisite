<?php

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.imgur.com/3/image",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => array(
        'image' => new CURLFile(
                'C:\Users\user\Downloads\zq2qr.jpg',
                'application/octet-string',
                'icon.png'
        )
    ),
    CURLOPT_HTTPHEADER => array(
        "Authorization: Client-ID 0640c19809d6508"
    ),
));

$response = curl_exec($curl);
curl_close($curl);
echo "<pre>";
var_dump(json_decode($response));
