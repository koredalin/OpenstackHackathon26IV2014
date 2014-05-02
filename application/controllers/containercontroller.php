<?php

class ContainerController extends MY_MainController {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Container');
        $this->model=$this->Container;
    }
    
    public function index() {
        $this->data['title'] = 'Container managing';
        $this->getObjectsList($this->data['container_name']);
        $this->load_view_navigation('header', 'title', 'containerview', 'footer', $this->data);
    }
    
    public function select($container='') {
        if (!$container) {
            redirect('/swift/getContainersList');
        }
        $this->data['container_name']=$container;
        $this->index();
    }
    
    public function delete($container='') {
        $this->model->deleteEmptyContainer($container);
        redirect('/swift/getContainersList');
    }
    
    public function getObjectsList($container='') {
        $objects=$this->model->getobjects($container);
        $object_links='';
        foreach ($objects as $key => $object) {
            if ($object) {
            $object_links.= '<p><a href="'.$this->data['baseDirectory'].'object/select/'.$container . '/' . $object.'">'.$object.'</a></p>';
            }
        }
        $this->data['object_links']=$object_links;
    }
    
    public function uploadFile($container='') {
        $this->data['upload_result']=$this->model->uploadFile($container);
        $this->select($container);
    }
}