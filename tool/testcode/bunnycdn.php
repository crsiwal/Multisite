<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://storage.bunnycdn.com/testing-1/test/value.png");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Checksum: "
));
$response = curl_exec($ch);
curl_close($ch);

var_dump($response);
