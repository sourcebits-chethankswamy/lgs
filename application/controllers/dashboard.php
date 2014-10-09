<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @File : dashboard.php Controller
 * @Class : Dashboard
 * @Description: This class file holds the operations of user settings, configurations etc.
 * Created By: Himanshu Arora
 */
class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('dashboard_model');
    }

    /**
     * @Access		:	public
     * @Function	:	index
     * @Description	:	Index page display
     * @Param		:	none
     */
    public function index($error = '') {
        $data['title'] = 'Home';
        $site_lists = $this->dashboard_model->get_site_lists();
        $fetch_field_details = $this->dashboard_model->fetch_data();

        if (!empty($fetch_field_details)) {
            $fetch_field_details = $this->format_result_set($fetch_field_details);
        }
        $data['site_lists'] = $site_lists;
        $data['field_details'] = $fetch_field_details;
        $this->load->view('header');
        $this->load->view('navigation_header');
        $this->load->view("dashboard.php", $data);
        $this->load->view('navigation_footer');
        $this->load->view('footer');
    }

    public function format_result_set($data) {
        $old_id = -1;
        $new_id = 0;
        $prerare_data = array();
        foreach ($data as $each_field) {
            unset($result_array);
            if ($old_id != $each_field['field_id']) {
                $new_id = $each_field['field_id'];
                $prepare_data[$new_id]['field_name'] = $each_field['field_name'];
                $prepare_data[$new_id]['field_type'] = $each_field['field_type'];
                $result_array['field_value_id'] = $each_field['field_value_id'];
                $result_array['field_value_name'] = $each_field['field_value_name'];
                $result_array['value'] = $each_field['value'];
                $result_array['selected_status'] = $each_field['selected_status'];
                $prepare_data[$new_id]['result_set'][] = $result_array;
                $old_id = $each_field['field_id'];
            } else {
                $result_array['field_value_id'] = $each_field['field_value_id'];
                $result_array['field_value_name'] = $each_field['field_value_name'];
                $result_array['value'] = $each_field['value'];
                $result_array['selected_status'] = $each_field['selected_status'];
                $prepare_data[$old_id]['result_set'][] = $result_array;
            }
        }
        return $prepare_data;
    }

}

?>