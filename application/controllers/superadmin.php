<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @File : user.php Controller
 * @Class : User
 * @Description: This class file holds the operations of user login, display settings, configurations etc.
 * Created By: Himanshu Arora
 */
class Superadmin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->model('superadmin_model');
    }

    public function index() {
        $data['users_list'] = $this->superadmin_model->get_all_users();
        $data['superadmin'] = '1';

        $this->load->view('header');
        $this->load->view('navigation_header', $data);
        $this->load->view("superadmin/users", $data);
        $this->load->view('navigation_footer');
        $this->load->view('footer');
    }

    public function delete($id) {
        if ($id) {
            $delete = $this->superadmin_model->delete_user($id);
            if ($delete) {
                $message = 'User successfully deleted';
                $this->session->set_flashdata("message", $message);

                redirect('/superadmin');
            } else {
                $message = 'Error while deleting user, please try again';
                $this->session->set_flashdata("message", $message);

                redirect('/superadmin');
            }
        } else {
            $message = 'Invalid data';
            $this->session->set_flashdata("message", $message);

            redirect('/superadmin');
        }
    }

}
