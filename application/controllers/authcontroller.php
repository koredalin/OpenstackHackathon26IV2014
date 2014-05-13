<?php

class AuthController extends MY_MainController {

    public function __construct() {
        parent::__construct();
          $this->load->model('Auth');
          $this->model=$this->Auth;
    }

    public function index() {
        if (isset($_POST['os_username']) && isset($_POST['os_password'])) {
            $this->success();
        } else {
            $this->login();
        }
    }

    public function login() {
        $this->data['title'] = 'Openstack authentication';
        $this->load_view_navigation('header', 'title', 'authview', 'footer', $this->data);
    }

    private function success() {
        $username = trim($this->input->post('os_username'));
        $password = trim($this->input->post('os_password'));

        $login_data = array('auth' =>
            array('passwordCredentials' =>
                array(
                    'username' => $username,
                    'password' => $password),
                'tenantName' => 'hackathon'));
        $responce = $this->model->jsonCommunication($login_data);
        $responce = json_decode($responce, true);
        echo '<br /> <br />';
        $os_swift_link=$responce['access']['serviceCatalog'][5]['endpoints'][0]['publicURL'];
        $os_token = trim($responce['access']['token']['id']);
        $os_tenant_id = trim($responce['access']['token']['tenant']['id']);
        $userdata = array(
            'os_username' => $username,
            'os_token' => $os_token,
            'os_tenant_id' => $os_tenant_id,
            'os_swift_link' => $os_swift_link
         );
//        var_dump($userdata);
//        exit;
        // var_dump($userdata);
        if (!isset($_SESSION['userdata'])) {
            session_start();
        }
        $this->nativesession->set('userdata', $userdata);
        // var_dump($this->nativesession->get('userdata'));
        $this->model->clearTempFiles();
        redirect('/swift/getContainersList');
    }

    public function logout() {
        $this->nativesession->set('userdata', array());
        redirect('/auth');
    }

}
