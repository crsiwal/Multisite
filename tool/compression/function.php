<?php

function runMinified($file_list, $serviceUrl, $basePath, $outputPath, $fileType, $nameKey, $onlyMerge = FALSE) {
    $rawData = joinRawData($file_list, $basePath);
    $minifiedContent = ($onlyMerge) ? $rawData : getMinifiedContent($rawData, $serviceUrl);
    if ($minifiedContent) {
        saveMinifiedOutput($outputPath, $fileType, $minifiedContent, $nameKey);
    }
}

function joinRawData($file_list, $basePath) {
    $rawdata = "";
    foreach ($file_list as $file) {
        $rawdata .= file_get_contents($basePath . $file);
    }
    return $rawdata;
}

function getMinifiedContent($rawdata, $serviceUrl) {
    if ($rawdata != "") {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $serviceUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ["Content-Type: application/x-www-form-urlencoded"],
            CURLOPT_POSTFIELDS => http_build_query(["input" => $rawdata]),
            CURLOPT_SSL_VERIFYHOST => FALSE,
            CURLOPT_SSL_VERIFYPEER => FALSE
        ]);
        $minified = curl_exec($ch);
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            die($error_msg);
        }
        curl_close($ch);
        return $minified;
    }
    return FALSE;
}

function saveMinifiedOutput($outputPath, $fileType, $minifiedContent, $nameKey) {
    $randomfilename = getFileName();
    $outputFilePath = $outputPath . $randomfilename . ".min." . $fileType;
    file_put_contents($outputFilePath, $minifiedContent);
    switch ($fileType) {
        case 'js':
            echo '$config["minify_js_files"]["' . $nameKey . '"] = "cache/' . $randomfilename . '.min";';
            break;
        case 'css':
            echo '$config["minify_css_files"]["' . $nameKey . '"] = "cache/' . $randomfilename . '.min";';
            break;
    }
    echo "\n";
}

function getFileName($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>