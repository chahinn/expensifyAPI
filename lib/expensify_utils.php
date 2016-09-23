<?php
namespace Expensify;

class Utils {

    public static function http_get($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $raw_response = curl_exec($ch);
        curl_close($ch);
//
//        if ($raw_response->responseCode > 299 || $raw_response->responseCode < 200) {
//            throw new Exception(
//                "Http Response Error: " . $raw_response->responseCode,
//                $raw_response->responseCode);
//        }

        return $raw_response;
    }

}