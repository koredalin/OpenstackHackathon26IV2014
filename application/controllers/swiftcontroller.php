<?php

class SwiftController extends MY_MainController {

    protected $model = null;

    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['userdata']) || empty($_SESSION['userdata'])) {
            redirect('/auth');
        }
        $this->data['breadcrumbs'] = array();
        $this->load->model("Swift");
        $this->model = $this->Swift;
    }

    public function index() {
        $this->data['title'] = 'Containers home';
        $userdata = $this->nativesession->get('userdata');
        // echo $userdata['os_token'].'<br />';
        // var_dump($this->nativesession->get('userdata'));
        $this->load_view_navigation('header', 'title', 'swiftview', 'footer', $this->data);
    }

    public function getContainersList() {
        $containers = $this->model->getContainers();
        $container_links = $this->formatLinks($containers, 3);
        $this->data['container_links'] = $container_links;
        $this->index();
    }

    public function createContainer() {
        $new_container_name = $this->validateNewContainerName();
        if ($new_container_name) {
            $result = $this->model->createContainer($new_container_name);
        }

        $this->getContainersList();
    }

    public function validateNewContainerName() {
        $this->load->library('form_validation');
        $validation = $this->form_validation;
        $validation->set_rules('new_container_name', 'New_container_name', 'trim|required|min_length[3]|max_length[15]|alpha_dash');
        if ($validation->run() == FALSE) {
            $this->data['validation_error'] = 'The new container\'s name should be between 3 and 15 alpha-numeric symbols!';
            return '';
        } else {
            return trim($this->input->post('new_container_name'));
        }
    }

    public function formatLinks($links, $cols_num) {
        --$cols_num;
        $container_links = '';
        $col_count = -1;
        foreach ($links as $key => $container) {
            $col_count === $cols_num ? $col_count = 0 : $col_count++;
            if ($col_count === 0) {
                $container_links.= '<p>';
            }
            if ($container) {
                $container_links.= '<span class="contname_width"><a href="' . $this->data['baseDirectory'] .
                        'container/select/' . $container . '">' . $container . '</a></span>';
            }
            if ($col_count === $cols_num) {
                $container_links.= '</p>';
            } else {
                $container_links.=' || ';
            }
        }
        if ($col_count < $cols_num) {
            $container_links = substr_replace($container_links, '</p>', -8, 8);
        }

        return $container_links;
    }

}
