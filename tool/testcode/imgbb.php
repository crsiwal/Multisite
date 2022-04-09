<?php
$curl = curl_init();
$hash = base64_encode(file_get_contents('C:\Users\user\Downloads\namefile.png'));
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.imgbb.com/1/upload",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => array(
        'key' => '70261a4e4fc1eb18aca9426fa9534a9e',
        'image' => $hash,
        'name' => "namefile.png",
    ),
));

$response = curl_exec($curl);
curl_close($curl);
echo "<pre>";
var_dump(json_decode($response));
