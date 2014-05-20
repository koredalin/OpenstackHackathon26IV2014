<?php

class ContainerController extends MY_MainController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Container');
        $this->model = $this->Container;
        $this->data['logout_link'] = ' / <a href="' . $this->data['baseDirectory'] . 'auth/logout">Logout</a>';
    }

    public function index() {
        $this->data['title'] = 'Container Managing';
        $this->getObjectsList($this->data['container_name']);
        $breadcrumbs = array(
            array(
                'link' => 'swift/getContainersList',
                'text' => 'Storages home'),
            array(
                'text' => 'Container: <strong>' . $this->data['container_name'] . '</strong>'),
        );
        $this->generateBreadcrumbs($breadcrumbs);
        $this->load_view_navigation('header', 'title', 'containerview', 'footer', $this->data);
    }

    public function select($container = '') {
        if (!$container) {
            redirect('/swift/getContainersList');
        }
        $this->data['container_name'] = $container;
        $this->index();
    }

    public function delete($container = '') {
        $this->model->deleteEmptyContainer($container);
        redirect('/swift/getContainersList');
    }

    public function getObjectsList($container = '') {
        $objects = $this->model->getobjects($container);
        $this->data['objects_list'] = $objects;
        $object_links = $this->formatLinks($container, $objects, 4);
        $this->data['object_links'] = $object_links;
    }

    public function uploadFile($container = '') {
        $object_name = $this->validateNewObjectName();
        if ($object_name) {
            $upload_result = $this->model->uploadFile($container, $object_name);
            if (isset($upload_result['error'])) {
                $this->data['validation_error'] = $upload_result['error'];
            } else {
                $this->data['upload_result'] = $upload_result;
            }
        } else {
            $this->model->unlinkTempFile();
        }

        $this->select($container);
    }

    public function validateNewObjectName() {
        $this->load->library('form_validation');
        $validation = $this->form_validation;
        $validation->set_rules('object_name', 'Object_name', 'trim|required|min_length[3]|max_length[16]|alpha_dash');
        if ($validation->run() == FALSE) {
            $this->data['validation_error'] = 'The new object\'s name should be between 3 and 16 alpha-numeric symbols!';
            return '';
        } else {
            return trim($this->input->post('object_name'));
        }
    }

    public function formatLinks($container, $links, $cols_num) {
        --$cols_num;
        $object_links = '';
        $col_count = -1;
        foreach ($links as $object) {
            $col_count === $cols_num ? $col_count = 0 : $col_count++;
            if ($col_count === 0) {
                $object_links.= '<p>';
            }
            if ($object) {
                $object_links.= '<span class="objname_width"><a href="' . $this->data['baseDirectory'] .
                        'object/select/' . $container . '/' . $object . '">' . $object . '</a></span>';
            }
            if ($col_count === $cols_num) {
                $object_links.= '</p>';
            } else {
                $object_links.=' || ';
            }
        }
        if ($col_count < $cols_num) {
            $object_links = substr_replace($object_links, '</p>', -8, 8);
        }

        return $object_links;
    }

}

//        foreach ($objects as $key => $object) {
//            if ($object) {
//            $object_links.= '<p><a href="'.$this->data['baseDirectory'].'object/select/'.$container . '/' . $object.'">'.$object.'</a></p>';
//            }
//        }