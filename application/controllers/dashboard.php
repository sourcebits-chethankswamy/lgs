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
        $keywords_list = $this->dashboard_model->get_keyword_lists();
        $emails_list = $this->dashboard_model->get_email_lists();

        if (!empty($fetch_field_details)) {
            $fetch_field_details = $this->format_result_set($fetch_field_details);
        }
        $data['site_lists'] = $site_lists;
        $data['keywords_list'] = $keywords_list;
        $data['emails_list'] = $emails_list;
        $data['field_details'] = $fetch_field_details;
        
        $data['site_page'] = $this->load->view('sites/global_tenders', $data, TRUE);
        
        $this->load->view('header');
        $this->load->view('navigation_header');
        $this->load->view("dashboard", $data);
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
    
    public function save_configuration () {
        if(!empty($_POST)){
            $config_id  =   isset($_POST['site_id'])    ?  $_POST['site_id'] : 0;
            $value = '';
            if(isset($_POST['set']) && !empty($_POST['set'])){
                foreach($_POST['set'] as $key => $val){
                    $value='';
                    if(!strpos($key, '_')){
                        $field_id = $key;
                        if(!is_array($val)){
                           if(!strpos($val, '_')){
                               $field_value_id = $val;
                               $this->dashboard_model->update_selected_fields($config_id , $field_id, $field_value_id);
                           } else {
                               $field_value_id   =   substr ($val, 0, strpos($val, '_'));
                               $value =     substr ($val,  strpos($val, '_'));
                           }
                           $this->dashboard_model->update_selected_fields($config_id , $field_id, $field_value_id, $value);
                        } else {
                            foreach($val as $index => $value){
                                $field_value_id   =   $index;
                                $value = $value;
                            }
                            $this->dashboard_model->update_selected_fields($config_id , $field_id, $field_value_id, $value);
                        }
                    } else {
                        $field_id   =   substr ($key, 0, strpos($key, '_'));
                        if(!is_array($val)){
                           if(!strpos($val, '_')){
                               $field_value_id = $val;
                               $this->dashboard_model->update_selected_fields($config_id , $field_id, $field_value_id);
                           } else {
                               $field_value_id   =   substr ($val, 0, strpos($val, '_'));
                               $value =     substr ($val,  strpos($val, '_'));
                           }
                           $this->dashboard_model->update_selected_fields($config_id , $field_id, $field_value_id, $value);
                        } else {
                            foreach($val as $index => $value1){
                                $field_value_id   =   $index;
                                $value = $value1;
                            }
                            $this->dashboard_model->update_selected_fields($config_id , $field_id, $field_value_id, $value);
                        }
                    }
                }
                die(json_encode(array('error'=>0, 'message'=>'updated successfully')));
            }
            
       } else {
            die(json_encode(array('error'=> 1, 'message' => 'Invalid post data')));
        }
    }
    
}

?>