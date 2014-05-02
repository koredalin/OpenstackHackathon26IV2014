<?php

class TestController extends CI_Controller {
    public $data=array();
    public function __construct() {
        parent::__construct();
    }
   
    public function index() {
        $this->load->helper('url');
        echo ' shalala';
        $this->data['baseDirectory'] = base_url();
        // $this->load->view('templates/' . 'header', $this->data);
        $this->load->view('testview', $this->data);
        // $this->load->view('templates/' . 'footer', $this->data);
    }
}