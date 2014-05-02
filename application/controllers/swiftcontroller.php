<?php

class SwiftController extends MY_MainController {
    protected $model=null;

    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['userdata']) || empty($_SESSION['userdata'])) {
            redirect('/auth');
        }
        $this->data['breadcrumbs'] = array();
        $this->load->model("Swift");
        $this->model=$this->Swift;
    }

    public function index() {
        $this->data['title'] = 'Containers home';
        $userdata=$this->nativesession->get('userdata');
        // echo $userdata['os_token'].'<br />';
        // var_dump($this->nativesession->get('userdata'));
        $this->load_view_navigation('header', 'title', 'swiftview', 'footer', $this->data);
    }

    public function getContainersList() {
        $containers=$this->model->getContainers();
        $container_links='';
        foreach ($containers as $key => $container) {
            if ($container) {
            $container_links.= '<p><a href="'.$this->data['baseDirectory'].'container/select/'.$container.'">'.$container.'</a></p>';
            }
        }
        $this->data['container_links']=$container_links;
        $this->index();
    }

    public function createContainer() {
        if (!isset($_POST['new_container_name']) || !$this->input->post('new_container_name')) {
            redirect('/swift/getContainersList');
        }
        
        $result=$this->model->createContainer($this->input->post('new_container_name'));
        $this->getContainersList();
    }

}