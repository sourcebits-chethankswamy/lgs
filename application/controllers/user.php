<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @File : user.php Controller
 * @Class : User
 * @Description: This class file holds the operations of user login, display settings, configurations etc.
 * Created By: Himanshu Arora
 */
class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('user_model');
    }

    /**
     * @Access		:	public
     * @Function	:	index
     * @Description	:	Index page display
     * @Param		:	none
     */
    public function index($error = '') {
        if ($this->session->userdata('logged_in') == 1) {
            redirect('dashboard');
        } else {
            $data['title'] = 'Home';
            $data['error'] = $error;
            $this->load->view('header');
            $this->load->view("login", $data);
            $this->load->view('footer');
        }
    }

    /**
     * @Access		:	public
     * @Function	:	login
     * @Description	:	Login user
     * @Param		:	none
     */
    public function login() {
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));
        $result = $this->user_model->login($email, $password);
        if ($result) {
            redirect('/dashboard');
        } else {
            $this->index("Invalid Credentials");
        }
    }

    /**
     * @Access		:	public
     * @Function	:	logout
     * @Description	:	Logout user
     * @Param		:	none
     */
    public function logout() {
        $newdata = array(
            'user_id' => '',
            'user_name' => '',
            'user_email' => '',
            'logged_in' => FALSE,
        );
        $this->session->unset_userdata($newdata);
        $this->session->sess_destroy();
        redirect('/');
    }

    public function generate_configuration_url() {
        $response = $this->user_model->get_config_params();
        $old_id = -1;
        $new_id;
        foreach ($response as $each) {
            if ($old_id != $each['field_id']) {
                $old_id = $each['field_id'];
            } else {
                
            }
        }
        switch ($each['$field_id']) {
            
        }
        if (!empty($response)) {
            
        } else {
            return array('error' => 0, 'message' => 'url not found');
        }
    }

}

?>
