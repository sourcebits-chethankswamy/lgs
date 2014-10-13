<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @File : user_model Model
 * @Class : User
 * @Description: This class file holds all the user related operations.
 * @Created By: Himanshu Arora
 */
class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * @Function	:	login
     * @Description	:	Logins a user and creates a session for it
     * @Param		:	$email and $password 
     */
    function login($email, $password) {
        $this->db->where("email", $email);
        $this->db->where("password", $password);
        $query = $this->db->get("user");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                //add all data to session
                $newdata = array(
                    'user_id' => $rows->id,
                    'user_email' => $rows->email,
                    'logged_in' => TRUE,
                );
            }
            $this->session->set_userdata($newdata);
            return true;
        }
        return false;
    }

    /**
     * @Function	:	login
     * @Description	:	Logins a user and creates a session for it
     * @Param		:	$email and $password 
     */
    public function get_config_params($config = '1') {
        $fetch_config_params_query = "SELECT  fl.id as field_id, fvl.id as field_value_id, fl.*, fvl.* FROM field_list fl, field_value_list fvl
                                      WHERE fl.id=fvl.configuration_id
                                      AND fvl.selected_status = '1'
                                      ORDER BY fl.id, fvl.id";
        
        $q = $this->db->query($fetch_config_params_query);
    }

}

?>
