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

    public function check_user($user_id, $password) {
        $q = $this->db->query("select * from user where id='" . $user_id . "' AND password = MD5('" . $password . "')");
        if ($q->num_rows > 0) {
            return $q->result_array();
        } else {
            return false;
        }
    }

    public function change_password($user_id, $password) {
        $sql = 'UPDATE user set password = MD5("' . $password . '"), updated_date = NOW() WHERE id = "' . $user_id . '"';

        $result_set = $this->db->query($sql);
        return true;
    }

    public function get_site_lists() {
        $site_list_query = "SELECT * FROM sites_list WHERE status='1'";
        $result_set = $this->db->query($site_list_query)->result_array();
        return $result_set;
    }

    public function fetch_data($config) {
        $fetch_data = "SELECT fl.id as field_id,fl.*, flv.id as field_value_id, flv.* FROM
                        fields_list fl, field_list_values flv
                        WHERE fl.configuration_id = " . $this->db->escape($config) . "
                        AND fl.id = flv.field_id
                        ORDER BY fl.id,flv.id";

        $result_set = $this->db->query($fetch_data)->result_array();
        return $result_set;
    }

    public function get_configuration_details($config_id) {
        $sql = 'SELECT * from site_configurations WHERE id="' . $config_id . '"';

        $result_set = $this->db->query($sql)->result_array();
        return $result_set;
    }

    public function update_config_name($config_name, $config_id) {
        $sql = 'Update site_configurations SET configuration_name = "' . $config_name . '", modified_date = NOW() WHERE id = ' . $config_id;

        $result_set = $this->db->query($sql);
        return true;
    }

    public function get_site_configuration_lists($site_id, $status = 0) {
        $active_cond = ($status != 0) ? " AND status = '1'" : "";

        $sql = 'SELECT * from site_configurations
                WHERE 
                site_id = "' . $site_id . '"' . $active_cond;

        $result_set = $this->db->query($sql)->result_array();
        return $result_set;
    }

    public function get_all_configuration($config_id) {
        $sql = 'SELECT sfl.configuration_id, fl.id as field_id, fl.field_name, fl.field_type, flv.field_value_name, flv.id as field_value_id, flv.value as field_value, sfl.value as field_value_slv, sfl.selected_status
                FROM field_list_values flv
                LEFT JOIN selected_fields_list sfl on sfl.field_list_values_id = flv.id and sfl.configuration_id = ' . $config_id . '
                JOIN fields_list fl on fl.id = flv.field_id';
        //echo $sql;
        $result_set = $this->db->query($sql)->result_array();
        return $result_set;
    }

    public function delete_configuration_details($config_id, $site_id) {
        $sql = "DELETE FROM site_configurations WHERE id = " . $this->db->escape($config_id) . " AND site_id = " . $site_id;
        $this->db->query($sql);

        $sql1 = "DELETE FROM selected_keywords_list WHERE configuration_id = " . $this->db->escape($config_id);
        $this->db->query($sql1);

        $sql2 = "DELETE FROM selected_fields_list WHERE configuration_id = " . $this->db->escape($config_id);
        $this->db->query($sql2);

        return true;
    }

    public function change_configuration_status($status, $config_id, $site_id) {
        $sql = "update site_configurations set status = '" . $status . "' where id = " . $this->db->escape($config_id) . " AND site_id = " . $site_id;
        $this->db->query($sql);

        return true;
    }

    public function get_configuration($config_id) {
        $sql = 'SELECT sfl.configuration_id, fl.id as field_id, fl.field_name, fl.field_type, flv.field_value_name, flv.id as field_value_id, flv.value as field_value, sfl.value as field_value_slv, sfl.selected_status
                FROM field_list_values flv
                LEFT JOIN selected_fields_list sfl on sfl.field_list_values_id = flv.id
                JOIN fields_list fl on fl.id = flv.field_id
                WHERE sfl.configuration_id = ' . $config_id;
        //echo $sql.'<br />';exit;
        $result_set = $this->db->query($sql)->result_array();
        return $result_set;
    }

    public function get_site_configurations($config_id, $status = 0) {
        $selected_cond = ($status == 0) ? 'and sfl.selected_status = "1"' : "";

        $sql = 'SELECT sc.id as site_id, sc.configuration_name, fl.id as field_id, fl.field_name, fl.field_type, flv.field_value_name, flv.id as field_value_id, flv.value as field_value, sfl.selected_status
                FROM site_configurations sc 
                JOIN fields_list fl on fl.configuration_id = sc.site_id
                JOIN field_list_values flv on flv.field_id = fl.id
                LEFT JOIN selected_fields_list sfl on sfl.field_list_values_id = flv.id
                WHERE 
                sc.site_id = "' . $config_id . '" ' . $selected_cond;
        //echo $sql;
        $result_set = $this->db->query($sql)->result_array();
        return $result_set;
    }

    public function reset_selected_status($config_id) {
        /*
          $fields_list_sql = $this->db->query('select id from fields_list where configuration_id = "' . $config_id . '"')->result_array();
          foreach ($fields_list_sql as $filedvalue) {
          $this->db->query('update field_list_values set selected_status="0" where field_id="' . $filedvalue['id'] . '"');
          }
         */
        if ($config_id != 0) {
            $delete_existing_configs = "DELETE FROM selected_fields_list WHERE configuration_id = " . $this->db->escape($config_id) . "";
            $this->db->query($delete_existing_configs);

            //$delete_existing_email_configs = "DELETE FROM selected_emails_list WHERE active = '1'";
            //$this->db->query($delete_existing_email_configs);

            $delete_existing_keyword_configs = "DELETE FROM selected_keywords_list WHERE configuration_id = " . $this->db->escape($config_id) . "";
            $this->db->query($delete_existing_keyword_configs);
        }
        return true;
    }

    public function create_site_configuration($site_id, $config_name) {
        $sql = 'INSERT into site_configurations (site_id, configuration_name, status, created_date) values
                ("' . $site_id . '", "' . $config_name . '", "1", NOW())';
        $result_set = $this->db->query($sql);
        return $this->db->insert_id();
    }

    public function update_selected_fields($config_id, $field_value_id, $value = '') {
        if (empty($value)) {
            $value = "NULL";
        }

        $sql = 'INSERT into selected_fields_list (field_list_values_id, configuration_id, value, selected_status, created_date) values 
                ("' . $field_value_id . '", "' . $config_id . '", "' . $value . '", "1", NOW())';

        //echo $sql . '<br />';

        $result_set = $this->db->query($sql);
        return true;
        /*

          $update_selected_fields_query = "UPDATE field_list_values
          SET $condition
          WHERE id = '" . $field_value_id . "'
          AND field_id='" . $field_id . "'
          ";

          //echo $update_selected_fields_query.'<br />';

          $result_set = $this->db->query($update_selected_fields_query);

          return true;
         */
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
        $sql = 'Select * from cronjob_settings where site_id = "' . $config . '"';
        $result = $this->db->query($sql)->result_array();

        return $result;
    }

    public function set_cronjob_settings($settings, $config) {
        if (($settings['min'] != '') || ($settings['hour'] != '') || ($settings['day'] != '') || ($settings['month'] != '') || ($settings['week'] != '')) {
            $sql = 'insert into cronjob_settings (`site_id`, `minute`, `hour`, `day-of-month`, `month`, `day-of-week`, `created_date`) values 
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
                `site_id` = "' . $config . '"';

        $result_set = $this->db->query($sql);
        return true;
    }

    public function get_cron_details($config_id) {
        $sql = 'select * from cronjob_settings where site_id = "' . $config_id . '"';
        $result = $this->db->query($sql)->result_array();

        return $result;
    }

}

?>
