<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @File : keywords_model Model
 * @Class : Keywords
 * @Description: This class file holds all the user related operations.
 * @Created By: Himanshu Arora
 */
class Site_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_sites_list() {
        $sql = 'SELECT * from sites_list';

        $result_set = $this->db->query($sql)->result_array();
        return $result_set;
    }

    public function create_site($site_name) {
        $sql = 'INSERT into sites_list (configuration_name, status, created_date) values ("' . $site_name . '", "1", NOW())';

        $result_set = $this->db->query($sql);
        return $this->db->insert_id();
    }

    public function update_site($site_name, $site_id) {
        $sql = 'Update sites_list set 
                configuration_name = "' . $site_name . '",
                updated_date = NOW()
                where id = "' . $site_id . '"';

        $result_set = $this->db->query($sql);
        return true;
    }

    public function insert_site($site_id, $field_name, $field_value) {
        $sql = 'INSERT into fields_list (site_id, field_name, field_type, field_status, created_date) 
                values ("' . $site_id . '", "' . $field_name . '", "' . $field_value . '", "1", NOW())';

        $result_set = $this->db->query($sql);
        return $this->db->insert_id();
    }

    public function update_site_fields($field_id, $site_id, $field_name, $field_value) {
        $sql = 'Update fields_list set
                field_name = "' . $field_name . '",
                field_type = "' . $field_value . '",
                updated_date = NOW()
                where id = "' . $field_id . '" AND site_id = "' . $site_id . '"';
        //echo $sql . '<br />';

        $result_set = $this->db->query($sql);
        return true;
    }

    public function insert_field_value($field_id, $field_value_name, $field_value) {
        $sql = 'INSERT into field_list_values (field_id, field_value_name, value, status, created_date) 
                values ("' . $field_id . '", "' . $field_value_name . '", "' . $field_value . '", "1", NOW())';

        $result_set = $this->db->query($sql);
        return $this->db->insert_id();
    }

    public function update_field_value($field_id, $field_value_name, $field_value, $field_value_id) {
        $sql = 'Update field_list_values SET
                field_value_name = "' . $field_value_name . '",
                value = "' . $field_value . '",
                modified_date = NOW()
                WHERE id = "' . $field_value_id . '" AND field_id = "' . $field_id . '"';
        //echo $sql . '<br />';

        $result_set = $this->db->query($sql);
        return true;
    }

    public function get_fields($site_id) {
        $sql = 'SELECT * from fields_list where site_id = "' . $site_id . '"';

        $result_set = $this->db->query($sql)->result_array();
        return $result_set;
    }

    public function get_field_values($site_id) {
        $sql = 'SELECT fl.id as field_id, fl.field_name, flv.id as field_list_value_id, flv.field_value_name, flv.value as field_value 
                FROM fields_list fl
                JOIN field_list_values flv on flv.field_id = fl.id
                WHERE fl.site_id = "' . $site_id . '" ORDER BY fl.id';


        $sql1 = "SELECT fl.id as field_id, fl.field_name,
                GROUP_CONCAT(flv.id SEPARATOR '::') as field_list_value_id,
                GROUP_CONCAT(flv.field_value_name SEPARATOR '::') as field_value_name,
                GROUP_CONCAT(flv.value SEPARATOR '::') as field_value
                FROM
                fields_list fl
                JOIN field_list_values flv on flv.field_id = fl.id
                WHERE fl.site_id = '" . $site_id . "' GROUP BY fl.id ORDER BY fl.id";

        $result_set = $this->db->query($sql1)->result_array();
        return $result_set;
    }

    public function get_site_details($site_id) {
        $sql = 'SELECT * from sites_list where id = "' . $site_id . '"';

        $result_set = $this->db->query($sql)->result_array();
        return $result_set;
    }

    public function delete_site($site_id) {
        $sql = 'select id from fields_list where site_id = "' . $site_id . '"';
        $result_set = $this->db->query($sql)->result_array();
        if (!empty($result_set)) {
            foreach ($result_set as $key => $value) {
                $sql1 = 'Select id from field_list_values where field_id = "' . $value['id'] . '"';
                $result_set1 = $this->db->query($sql1)->result_array();
                if (!empty($result_set1)) {
                    foreach ($result_set1 as $key1 => $value1) {
                        $sql2 = 'DELETE FROM `selected_fields_list` WHERE `field_list_values_id` = "' . $value1['id'] . '"';
                        $this->db->query($sql2);
                    }
                }

                $sql3 = 'DELETE FROM `field_list_values` WHERE `field_id` = "' . $value['id'] . '"';
                $this->db->query($sql3);
            }
            $sql4 = 'DELETE FROM `fields_list` WHERE `site_id` = "' . $site_id . '"';
            $this->db->query($sql4);
        }

        $sql5 = 'select id from site_configurations where site_id = "' . $site_id . '"';
        $result_set2 = $this->db->query($sql5)->result_array();
        if (!empty($result_set2)) {
            foreach ($result_set2 as $key2 => $value2) {
                $sql6 = 'DELETE FROM `selected_keywords_list` WHERE `configuration_id` = "' . $value2['id'] . '"';
                $this->db->query($sql6);
            }
            $sql7 = 'DELETE FROM `site_configurations` WHERE `site_id` = "' . $site_id . '"';
            $this->db->query($sql7);
        }
        $sql8 = 'DELETE FROM `sites_list` WHERE `id` = "' . $site_id . '"';
        $this->db->query($sql8);

        return true;
    }

    public function change_status($status, $site_id) {
        $sql = 'update sites_list set 
                status = "' . $status . '",
                updated_date = NOW()
                where id = "' . $site_id . '"';

        $result_set = $this->db->query($sql);
        return true;
    }

}
