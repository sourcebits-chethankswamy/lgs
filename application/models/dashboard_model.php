<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @File : dashboard_model Model
 * @Class : Dashboard
 * @Description: This class file holds all the user related operations.
 * @Created By: Himanshu Arora
 */
class Dashboard_model extends MY_Model {

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

    public function reset_selected_status($config_id) {
        $fields_list_sql = $this->db->query('select id from fields_list where configuration_id = "' . $config_id . '"')->result_array();
        foreach ($fields_list_sql as $filedvalue) {
            $this->db->query('update field_list_values set selected_status="0" where field_id="' . $filedvalue['id'] . '"');
        }
        return true;
    }

    public function update_selected_fields($config_id = '1', $field_id, $field_value_id, $value = '') {

        if (empty($value)) {
            $condition = "selected_status ='1', updated_date=NOW()";
        } else {
            $condition = "value = " . $value . ",selected_status ='1',updated_date=NOW()";
        }
        $update_selected_fields_query = "UPDATE field_list_values
                                            SET $condition
                                            WHERE id = '" . $field_value_id . "'
                                            AND field_id='" . $field_id . "'
                                            ";

        //echo $update_selected_fields_query.'<br />';

        $result_set = $this->db->query($update_selected_fields_query);

        return true;
    }

    /**
     * @Function	:	login
     * @Description	:	Logins a user and creates a session for it
     * @Param		:	$email and $password 
     */
    public function get_config_params($config = '1') {
        $fetch_config_params_query = "SELECT  fl.id as field_id, flv.id as field_value_id, fl.*, flv.* 
                                      FROM fields_list fl, field_list_values flv
                                      WHERE fl.id=flv.field_id
                                      AND fl.configuration_id = " . $this->db->escape($config) . "
                                      AND flv.selected_status = '1'
                                      ORDER BY fl.id, flv.id";

        $q = $this->db->query($fetch_config_params_query)->result_array();
        return $q;
    }

    public function get_config_values($feild_id, $field_value_id) {
        $sql = "SELECT fl.field_name, fl.field_type, flv.field_value_name, flv.value FROM fields_list fl 
                join field_list_values flv on flv.field_id = fl.id
                WHERE fl.id = '" . $feild_id . "' and flv.id='" . $field_value_id . "'";

        $result = $this->db->query($sql)->result_array();

        return $result;
    }

    public function get_cronjob_settings($config) {
        $sql = 'Select * from cronjob_settings where configuration_id = "' . $config . '"';
        $result = $this->db->query($sql)->result_array();

        return $result;
    }

    public function set_cronjob_settings($settings, $config) {
        if (($settings['min'] != '') || ($settings['hour'] != '') || ($settings['day'] != '') || ($settings['month'] != '') || ($settings['week'] != '')) {
            $sql = 'insert into cronjob_settings (`configuration_id`, `minute`, `hour`, `day-of-month`, `month`, `day-of-week`, `created_date`) values 
                    ("' . $config . '", "' . $settings['min'] . '", "' . $settings['hour'] . '", "' . $settings['day'] . '", "' . $settings['month'] . '", "' . $settings['week'] . '", NOW())';

            $result_set = $this->db->query($sql);
        }
        return true;
    }

    public function update_cronjob_settings($settings, $config) {
        $sql = 'update cronjob_settings set 
                `minute` = "' . $settings['min'] . '",
                `hour` = "' . $settings['hour'] . '",
                `day-of-month` = "' . $settings['day'] . '",
                `month` = "' . $settings['month'] . '",
                `day-of-week` = "' . $settings['week'] . '",
                `modified_date` = NOW()
                where 
                `configuration_id` = "' . $config . '"';

        $result_set = $this->db->query($sql);
        return true;
    }

    public function get_cron_details($config_id) {
        $sql = 'select * from cronjob_settings where configuration_id = "' . $config_id . '"';
        $result = $this->db->query($sql)->result_array();

        return $result;
    }

}

?>
