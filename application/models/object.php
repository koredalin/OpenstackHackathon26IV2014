<?php

class Object extends MY_MainModel {

    private $temp_folder = '';

    public function __construct() {
        parent::__construct();
        $this->temp_folder = $_SERVER['DOCUMENT_ROOT'] . '/oshackathon/temp_files/';
        $this->userdata = $this->nativesession->get('userdata');
        if (empty($this->userdata)) {
            redirect('/auth');
        }
    }

    public function delete($container = '', $object = '') {
        if (!$container || !$object) {
            redirect('/swift/getContainersList');
        }
        $container = trim($container);
        $ch = curl_init($this->userdata['os_swift_link'] . '/' . $container . '/' . $object);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Auth-Token: ' . $this->userdata['os_token'])
        );
        $result = curl_exec($ch);
        
        return $result;
    }

    public function download($container = '', $object = '') {
        if (!$container || !$object) {
            redirect('/swift/getContainersList');
        }
        $container = trim($container);
        $object = trim($object);
    }

    public function downloadMetaData($container = '', $object = '') {
        if (!$container || !$object) {
            redirect('/swift/getContainersList');
        }
        $container = trim($container);
        $ch = curl_init($this->userdata['os_swift_link'] . '/' . $container . '/' . $object);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Range: bytes=0-60',
            'X-Auth-Token: ' . $this->userdata['os_token'])
        );
        $result = curl_exec($ch);
        return $result;
    }

    public function getFileAttributes($text = '') {
        if (!$text) {
            return '';
        }
        $file_name = '';
        $text_temp = '';
        $text_temp = str_replace('filename:', '|||', $text);
        $text_temp = str_replace('Content-Length', '|||', $text_temp);
        $file_name = explode('|||', $text_temp);
        $file_name = trim($file_name[1]);
        $head_content = substr($text, -61);
        return array(
            'file_name' => $file_name,
            'head_content' => $head_content);
    }

    public function downloadFile($container, $object, $file_name) {
        if (!$container || !$object || !$file_name) {
            redirect('/swift/getContainersList');
        }
//        echo '$file_name: '.$file_name.'<br />';
//        $bg_name = urldecode($file_name);
//        echo '$bg_name: '.$bg_name.'<br />';
        
        $session = curl_init($this->userdata['os_swift_link'] . '/' . $container . '/' . $object);
        
        $fname = urldecode($this->temp_folder . $container . '---' . $object . '---' . $file_name);
        $logfh = fopen($fname, 'w+');
        if ($logfh == false) {
            // print "Opened the log file without errors";
            echo "Temp file is not opened!";
        }
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_FILE, $logfh);
        curl_setopt($session, CURLOPT_VERBOSE, true);
        curl_setopt($session, CURLOPT_HTTPHEADER, array(
            'X-Auth-Token: ' . $this->userdata['os_token'])
        );
        $result = curl_exec($session);
        // var_dump($result);
        curl_close($session);
        fclose($logfh);
        return $result;
    }

    public function deleteFileOnServer($file_path = '') {
        if (!$file_path) {
            return false;
        }
        $result = unlink($file_path);
        return $result;
    }

    public function clearHeaderOfFile($container='', $object='', $file_name = '') {
        if (!$container || !$object || !$file_name) {
            echo 'There is no file for head clearing';
            return false;
        }
        $file_name= urldecode($file_name);
        $file_path=$this->temp_folder . $container . '---' . $object . '---' . $file_name;
        // echo '$file_path: '. $file_path.'<br>';
        $dataFile = file_get_contents($file_path);
        $file_header = substr($dataFile, 0, 300);
        // echo '$file_header: '.$file_header.'<br>';
        // echo 'strpos_res: '.strpos($file_header, '------------------------------').'<br>';
        if (strpos($file_header, '------------------------------') === 0) {
            // echo 'Sanitizing file. <br>';
            $separator = "Content-Type:";
            $dataFile = stristr($dataFile, $separator);
//            $positionFile = strpos($dataFile, $separator);
//            echo '$positionFile: ' . $positionFile . '<br />';
//            $dataFile = substr($dataFile, $positionFile);
            $separator = 0x0D;
//            echo substr($dataFile, 0, 500) . "<br /><br />";
            $positionFile = strpos($dataFile, $separator) + 4;
            $dataFile = substr($dataFile, $positionFile);
//            echo substr($dataFile, 0, 500);

            $newFile = fopen($file_path, 'w');
            if (fwrite($newFile, $dataFile)===FALSE) {
                echo 'File writing fail.';
            }
            // echo 'new file: '.substr($dataFile, 0, 300).'<br>';
            fclose($newFile);
            return false;
        }
        // echo 'Do NOT Sanitizing file. <br>';
        return true;
    }

}
