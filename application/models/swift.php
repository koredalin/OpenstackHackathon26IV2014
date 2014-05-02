<?php

class Swift extends MY_MainModel {
    
    public function __construct() {
        parent::__construct();
        $this->userdata = $this->nativesession->get('userdata');
        if (empty($this->userdata)) {
            redirect('/auth');
        }
    }

    public function getContainers() {
        $ch = curl_init($this->userdata['os_swift_link']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            // 'Content-Type: application/json',
            'X-Auth-Token: ' . $this->userdata['os_token'])
        );

        $result = curl_exec($ch);
        $result=str_replace("\n","|||", $result);
        if (!$result) {
            return array();
        } else {
            $containers = explode('|||', $result);
        }
        
        return $containers;
    }
    
    public function createContainer($container='') {
        if (!$container) {
            redirect('/swift/getContainersList');
        }
        
        //$data_string = json_encode($data);
        
        $ch = curl_init($this->userdata['os_swift_link'].'/'.$container);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_PORT, 5000);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            // 'Content-Type: application/json',
            'X-Auth-Token: '. $this->userdata['os_token'],
            'Content-Length: 0')
        );

        $result = curl_exec($ch);
        return $result;
    }

}
