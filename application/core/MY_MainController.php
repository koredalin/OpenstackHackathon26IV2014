<?php

class MY_MainController extends CI_Controller {

    protected $data = array();
    protected $navigation = '';
    protected $model = null;

    public function __construct() {
        parent::__construct();
        $this->data['baseDirectory'] = base_url();
    }

    protected function load_view($header, $body, $footer, $data) {
        $this->load->view('templates/' . $header, $data);
        $this->load->view($body, $data);
        $this->load->view('templates/' . $footer, $data);
    }

    protected function load_view_navigation($header, $navigation, $body, $footer, $data) {
        $this->load->view('templates/' . $header, $data);
        $this->load->view('templates/' . $navigation, $data);
        $this->load->view($body, $data);
        $this->load->view('templates/' . $footer, $data);
    }

    protected function headerJson() {
        header('Content-type: application/json');
    }

    protected function echoResult($result) {
        $this->headerJson();
        echo json_encode($result);
    }

    public function generateBreadcrumbs(Array $breadcrumbs) {
        $brcr_html = '';
        
        foreach ($breadcrumbs as $key => $row) {
            $key>0 ? $brcr_html .= ' :: ' : false;
            $brcr_html .= $this->generateBreadcrumbsLink($breadcrumbs[$key]);
        }
        
        $this->data['breadcrumbs'] = $brcr_html;
    }

    private function generateBreadcrumbsLink(Array $brcr_level) {
        $level_link = '';
        if (isset($brcr_level['link'])) {
            $level_link .= '<a href="' . $this->data['baseDirectory'] . $brcr_level['link'] . '">' . $brcr_level['text'] . '</a>';
        }
        else {
            $level_link .= $brcr_level['text'];
        }

        return $level_link;
    }

}
