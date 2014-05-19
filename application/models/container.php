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
        // var_dump($result);
        if (!$result) {
            return array();
        } else {
            $containers = explode('|||', $result);
        }

        return $containers;
    }

    public function uploadFile($container = '', $object_name) {
        if (!$container || !isset($_FILES['file_upload_name']) || !isset($_FILES['file_upload_name']) ||
                !$_FILES['file_upload_name']['name'] || !$this->input->post('object_name')) {
            return array('error' => 'Error: You have to select a file for upload!');
            // redirect('/swift/getContainersList');
        }

        $filedata = $_FILES['file_upload_name']['tmp_name'];
        $filesize = filesize($filedata);
        // Filesize validation
        if ($filesize > 20971520) {
            unlink($filedata);
            return array('error' => 'Error: Too large file for upload! Maximum size is 20MB.');
        }
        // Sanitizing the file name
        $filename = trim($_FILES['file_upload_name']['name']);
        $filename = preg_replace('/[^a-zA-Z0-9а-яА-Я\.\-]/', '_', $filename);
        // Configuring upload properties
        $object_name = $object_name;
        $target_url = $this->userdata['os_swift_link'] . '/' . $container . '/' . $object_name;
        $file_upload_path = '/home/master/public_html/oshackathon/temp_files/' . $filename;
        // Moves the uploaded file to the framework temp files direcctory
        $upload_to_server = move_uploaded_file($filedata, $file_upload_path);
        $result['upload_to_server'] = $upload_to_server;

        $post = array(
            // 'Original-filename' => $filename,
            'file_contents' => '@' . $file_upload_path);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $target_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        // curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Object-Meta-orig-filename: ' . $filename . '-temp',
            // 'Content-Length: '.$filesize,
            // 'Content-Type: binary/octet-stream',
            'X-Auth-Token: ' . $this->userdata['os_token'])
        );

        $cloud_responce = curl_exec($ch);
        curl_close($ch);
//        var_dump($cloud_responce);
//        exit;

        $cloud_responce === '' ? $result['cloud_responce'] = TRUE : $result['cloud_responce'] = FALSE;
        return $result;
    }

    public function unlinkTempFile() {
        if (!isset($_FILES['file_upload_name']) || !isset($_FILES['file_upload_name']) ||
                !$_FILES['file_upload_name']['name']) {
            return false;
        }
        $filedata = $_FILES['file_upload_name']['tmp_name'];
        unlink($filedata);

        return true;
    }

}

/*

$upload_result = move_uploaded_file($tmp_name, $file_upload_path);
        echo $container . '<br>';
        var_dump($file_upload_name);
        var_dump($object_name);
        var_dump($upload_result);
        set_time_limit(600);
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
 * 
 * $headers = array('X-Detect-Content-Type: true',
                'X-Auth-Token: ' . $this->userdata['os_token'],
                'Content-Length: '.$filesize);

 */
