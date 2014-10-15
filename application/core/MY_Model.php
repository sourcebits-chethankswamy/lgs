<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MY_Model extends CI_Model {

    public function __construct() {
        parent::__construct();

        /*
          if ($this->session->userdata('logged_in') != 1) {
          redirect('/');
          }
         */
    }

    public function set_site($id) {
        $this->db->query('update sites_list set selected_status = "0"');
        $this->db->query('update sites_list set selected_status = "1", updated_date=now() where id = ' . $id . '');
        return true;
    }

    public function get_site() {
        $sql = $this->db->query('select * from sites_list where selected_status = "1"');
        return $sql->result_array();
    }

}
