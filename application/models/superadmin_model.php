<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @File : dashboard_model Model
 * @Class : Dashboard
 * @Description: This class file holds all the user related operations.
 * @Created By: Himanshu Arora
 */
class Superadmin_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_users() {
        $sql = 'select * from user where email != "lgssuperadmin@sourcebits.com"';

        $result_set = $this->db->query($sql)->result_array();
        return $result_set;
    }

    public function delete_user($id) {
        $sql = 'delete from user where id = "' . $id . '" and email != "lgssuperadmin@sourcebits.com"';

        $result_set = $this->db->query($sql);
        return $result_set;
    }

}

?>