<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @File : dashboard_model Model
 * @Class : Dashboard
 * @Description: This class file holds all the user related operations.
 * @Created By: Himanshu Arora
 */
class Dashboard_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_site_lists() {
        $site_list_query = "SELECT * FROM sites_list WHERE status='1'";
        $result_set = $this->db->query($site_list_query)->result_array();
        return $result_set;
    }

    public function fetch_data($config = '1') {
        $fetch_data = "SELECT fl.id as field_id,fl.*, flv.id as field_value_id, flv.* FROM
                        fields_list fl, field_list_values flv
                        WHERE fl.configuration_id = " . $this->db->escape($config) . "
                        AND fl.id = flv.field_id
                        ORDER BY fl.id,flv.id";
        $result_set = $this->db->query($fetch_data)->result_array();
        return $result_set;
// echo '<pre>';print_r($result_set);die;
    }

}

?>