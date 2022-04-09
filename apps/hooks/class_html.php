<?php
if (! class_exists('html')) {

    class html
    {

        function __construct()
        {}

        public function getArray($xml)
        {
            $xml = simplexml_load_string($xml);
            $json = json_encode($xml);
            return json_decode($json, TRUE);
        }

        public function clear($html, $skip = '')
        {
            return strip_tags($html, $skip);
        }

        public function cleanArray($array)
        {
            foreach ($array as $key => $val) {
                $array[$key] = trim($this->clear($val));
            }
            return $array;
        }

        public function getContent($url)
        {
            $user_agent = 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
            $options = array(
                CURLOPT_CUSTOMREQUEST => "GET", // set request type post or get
                CURLOPT_POST => false, // set to GET
                CURLOPT_USERAGENT => $user_agent, // set user agent
                CURLOPT_COOKIEFILE => "cookie.txt", // set cookie file
                CURLOPT_COOKIEJAR => "cookie.txt", // set cookie jar
                CURLOPT_RETURNTRANSFER => true, // return web page
                CURLOPT_HEADER => false, // don't return headers
                CURLOPT_FAILONERROR => true, // don't return headers
                CURLOPT_FOLLOWLOCATION => true, // follow redirects
                CURLOPT_ENCODING => "", // handle all encodings
                CURLOPT_AUTOREFERER => true, // set referer on redirect
                CURLOPT_CONNECTTIMEOUT => 120, // timeout on connect
                CURLOPT_TIMEOUT => 120, // timeout on response
                CURLOPT_MAXREDIRS => 10, // stop after 10 redirects
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0
            );
            $cURL = curl_init($url);
            curl_setopt_array($cURL, $options);
            $content = curl_exec($cURL);
            $err = curl_errno($cURL);
            $errmsg = curl_error($cURL);
            $header = curl_getinfo($cURL);
            curl_close($cURL);
            $header['errno'] = $err;
            $header['errmsg'] = $errmsg;
            $header['content'] = $content;
            return $header;
        }

        public function returnSubHtml($html, $id, $singleNode = true, $bytagname = false, $byid = false, $onlyhtml = false)
        {
            $identifier = ($byid == true) ? "(@id, '" . $id . "')" : "(@class, '" . $id . "')";
            $doc = new DOMDocument();
            libxml_use_internal_errors(true);
            $doc->loadHTML($html);
            $finder = new DomXPath($doc);
            $node = $finder->query("//*[contains" . $identifier . "]");
            if ($singleNode == true) {
                if ($bytagname == true) {
                    $node = $doc->getElementsByTagName($id);
                    $html = $doc->saveHTML($node->item(0));
                    if ($onlyhtml == true) {
                        return $html;
                    } else {
                        $html = preg_replace('/(\>)\s*(\<)/m', '$1$2', $html);
                        $html = preg_replace("/<p[^>]*?>/", '<p class="abc">', $html);
                        $html = preg_replace("/<div[^>]*?>/", '<div class="xyz">', $html);
                        return $html;
                    }
                } else {
                    $html = $doc->saveHTML($node->item(0));
                    if ($onlyhtml == true) {
                        return $html;
                    } else {
                        $html = preg_replace('/(\>)\s*(\<)/m', '$1$2', $html);
                        $html = preg_replace('/\s+/', ' ', $html);
                        $html = preg_replace("/<p[^>]*?>/", '<p class="para">', $html);
                        $html = preg_replace("/<div[^>]*?>/", '<div class="cdiv">', $html);
                        return $html;
                    }
                }
            } else {
                if ($bytagname == true) {
                    $array = array();
                    $list = $doc->getElementsByTagName($id);
                    foreach ($list as $row)
                        $array[] = $doc->saveHTML($row);
                    return $array;
                } else {
                    $array = array();
                    foreach ($node as $row)
                        $array[] = $doc->saveHTML($row);
                    return $array;
                }
            }
        }
    }
}