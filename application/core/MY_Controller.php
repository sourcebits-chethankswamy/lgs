<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if ($this->session->userdata('logged_in') != 1) {
            redirect('/');
        }
    }

    public function set_site($id) {
        if ($id) {
            $this->dashboard_model->set_site($id);
            return true;
        }
        return false;
    }

    public function get_site() {
        return $this->dashboard_model->get_site();
    }

}
