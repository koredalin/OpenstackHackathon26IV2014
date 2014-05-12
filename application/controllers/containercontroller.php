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
        $object_links = $this->formatLinks($container, $objects, 4);
        $this->data['object_links']=$object_links;
    }
    
    public function uploadFile($container='') {
        $this->data['upload_result']=$this->model->uploadFile($container);
        $this->select($container);
    }
    
    public function formatLinks($container, $links, $cols_num) {
        --$cols_num;
        $object_links='';
        $col_count=-1;
        foreach ($links as $object) {
            $col_count===$cols_num ? $col_count=0 : $col_count++;
            if ($col_count===0) {
                $object_links.= '<p>';
            }
            if ($object) {
                $object_links.= '<span class="contname_width"><a href="'.$this->data['baseDirectory']. 
                        'object/select/'.$container. '/' . $object.'">'.$object.'</a></span>';
            }
            if ($col_count===$cols_num) {
                $object_links.= '</p>';
            }
            else {
                $object_links.=' || ';
            }
        } 
        if ($col_count<$cols_num) {
            $object_links= substr_replace($object_links, '</p>', -8, 8);
        }
        
        return $object_links;

    }
}
        
        
//        foreach ($objects as $key => $object) {
//            if ($object) {
//            $object_links.= '<p><a href="'.$this->data['baseDirectory'].'object/select/'.$container . '/' . $object.'">'.$object.'</a></p>';
//            }
//        }