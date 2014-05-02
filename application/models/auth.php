<?php

class Auth extends MY_MainModel {
    public function __construct() {
        parent::__construct();
    }
    
    public function jsonCommunication($data) {
        $data_string = json_encode($data);
        $ch = curl_init('http://rgw-staging.altscale.com/v2.0/tokens');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_PORT, 5000);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );

        $result = curl_exec($ch);
        // var_dump($result);
        return $result;
    }
    
}