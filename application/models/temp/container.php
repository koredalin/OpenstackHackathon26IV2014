<?php

class Container extends MY_MainModel {

    public function __construct() {
        parent::__construct();
        $this->userdata = $this->nativesession->get('userdata');
        if (empty($this->userdata)) {
            redirect('/auth');
        }
    }

    public function deleteEmptyContainer($container = '') {
        if (!$container) {
            redirect('/swift/getContainersList');
        }
        $container = trim($container);
        $ch = curl_init($this->userdata['os_swift_link'] . '/' . $container);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_PORT, 5000);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Auth-Token: ' . $this->userdata['os_token'])
        );

        $result = curl_exec($ch);
        return $result;
    }

    public function getObjects($container = '') {
        if (!$container) {
            redirect('/swift/getContainersList');
        }
        $container = trim($container);
        $ch = curl_init($this->userdata['os_swift_link'] . '/' . $container);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'X-Auth-Token: ' . $this->userdata['os_token'])
        );

        $result = curl_exec($ch);
        //var_dump($result);
        $result = str_replace("\n", "|||", $result);
        if (!$result) {
            return array();
        } else {
            $containers = explode('|||', $result);
        }

        return $containers;
    }

    public function uploadFile($container = '') {
        if (!$container || !isset($_FILES['file_upload_name']) || !isset($_FILES['file_upload_name']) ||
                !$_FILES['file_upload_name']['name'] || !$this->input->post('object_name')) {
            redirect('/swift/getContainersList');
        }


        var_dump($_FILES);
        $file_upload_name = $_FILES['file_upload_name']['name'];
        $file_upload_path = '/home/master/public_html/oshackathon/temp_files/upload_files/' . $file_upload_name;
        $object_name = $this->input->post('object_name');
        $tmp_name = $_FILES['file_upload_name']['tmp_name'];
        $upload_result = move_uploaded_file($tmp_name, $file_upload_path);
        echo $container . '<br>';
        var_dump($file_upload_name);
        var_dump($object_name);
        var_dump($upload_result);
        set_time_limit(600);
        $filesize = filesize($file_upload_path);
        echo '<br>filesize: ' . $filesize . '<br>';

        $data = array('file' => '@$file_upload_path');
        $container = trim($container);
        $ch = curl_init($this->userdata['os_swift_link'] . '/' . $container . '/' . $object_name);
        curl_setopt($ch, CURLOPT_UPLOAD, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Auth-Token: ' . $this->userdata['os_token'],
            'Content-Length: ' . $filesize,
            // 'Transfer-Encoding: chunked'
                )
        );

        $result = curl_exec($ch);
        echo '<br>$result: ';
        var_dump($result);
        exit;
    }

}

/*

$ch = curl_init();
 	$localfile = '/home/koredalin/Documents/Openstack/os_swift_commands_1.txt';
 	$fp = fopen($localfile, 'r');
 	curl_setopt($ch, CURLOPT_URL, $this->userdata['os_swift_link'].'/os_swift_commands_1.txt');
 	curl_setopt($ch, CURLOPT_UPLOAD, 1);
 	curl_setopt($ch, CURLOPT_INFILE, $fp);
 	curl_setopt($ch, CURLOPT_INFILESIZE, filesize($localfile));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Auth-Token: ' . $this->userdata['os_token'])
        );
 	$response=curl_exec ($ch);
 	$error_no = curl_errno($ch);
 	curl_close ($ch);
        if ($error_no == 0) {
        	$error = 'File uploaded succesfully.';
        } else {
        	$error = 'File upload error.';
        }


/**/