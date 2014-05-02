<?php

class ObjectController extends MY_MainController {

    public function __construct() {
        parent::__construct();
        $this->load->model("Object");
        $this->model = $this->Object;
    }

    public function index() {
        $this->data['title'] = 'Object management';
        $this->load_view_navigation('header', 'title', 'objectview', 'footer', $this->data);
    }

    public function delete($container = '', $object = '') {
        
        $meta_data = $this->model->downloadMetaData($container, $object);
        $attributes = $this->model->getFileAttributes($meta_data);
        $file_name = $attributes['file_name'];
        $file_name = $this->existFile($container, $object, $file_name);
        if ($file_name) {
            $base_folder = $_SERVER['DOCUMENT_ROOT'] . '/oshackathon/temp_files/';
            $file_path = $base_folder . $file_name;
            $this->model->deleteFileOnServer($file_path);
            //echo 'File deleted: '.$result;
        }
        $this->model->delete($container, $object);
        // echo 'Object deleted: '.$obj_del_res;
        redirect('/container/select/' . $container);
    }

    public function download($container = '', $object = '') {
        $this->model->download($container, $object);
        redirect('/container/select/' . $container);
    }

    public function select($container = '', $object = '') {
        $meta_data = $this->model->downloadMetaData($container, $object);
        $attributes = $this->model->getFileAttributes($meta_data);
        $this->data['file_name'] = $attributes['file_name'];
        $this->data['head_content'] = $attributes['head_content'];
        $this->data['container_name'] = $container;
        $this->data['object_name'] = $object;
        $this->data['file_on_server'] = $this->existFile($container, $object, $attributes['file_name']);
        $this->index();
    }

    public function downloadFile($container, $object, $file_name) {
        $file_downloaded = $this->model->downloadFile($container, $object, $file_name);
        $header_cleared=$this->model->clearHeaderOfFile($container, $object, $file_name);
        // echo '$file_downloaded: '. $file_downloaded . ' || $header_cleared: '. $header_cleared.'<br />';
        $this->select($container, $object);
    }

    public function existFile($container, $object, $file_name) {
        if (!$container || !$object || !$file_name) {
            return false;
        }
        $base_folder = $_SERVER['DOCUMENT_ROOT'] . '/oshackathon/temp_files/';
        $needle = $container . '---' . $object . '---' . $file_name;
        $files_list = scandir($base_folder);
        $result = array_search($needle, $files_list);
        if ($result) {
            $result = $needle;
        }
        return $result;
    }

}
