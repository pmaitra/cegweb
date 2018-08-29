<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('callApi')) {

    function callApi($method, $url, $data = false) {
        try {
            //create a new cURL resource
            $ch = curl_init($url);

            //setup request to send json via POST

            $payload = json_encode($data);
            curl_setopt($ch, CURLOPT_POST, 1);
            //attach encoded JSON string to the POST fields
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

            //set the content type to application/json
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

            //return response instead of outputting
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            //execute the POST request
            $result = curl_exec($ch);
            if ($result === false) {
                //pr(curl_error($ch));
            } else {
                return $result;
            }
//close cURL resource
            curl_close($ch);
        }

//catch exception
        catch (Exception $e) {
            return FALSE;
            //echo 'Message: ' .$e->getMessage();
        }
//        $curl = curl_init();
//
//        switch ($method)
//        {
//            case "POST":
//                curl_setopt($curl, CURLOPT_POST, 1);
//
//                if(!empty($data))
//                {
//                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
//                }
//                break;
//            case "PUT":
//                curl_setopt($curl, CURLOPT_PUT, 1);
//                break;
//            default:
//                if ($data)
//                    $url = sprintf("%s?%s", $url, http_build_query($data));
//        }

        return $result;
    }

}
?>