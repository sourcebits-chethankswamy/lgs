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
        $this->load->model('keywords_model');
        $this->load->model('email_model');
    }

    function setcron() {
        $output = shell_exec('/usr/bin/crontab -l');

        file_put_contents('/tmp/crontab.txt', $output . '*/5 * * * * http://localhost/lgs/crawl/checkcron >> /Users/chethan/lgs.log' . PHP_EOL);
        echo exec('crontab /tmp/crontab.txt', $output);

        exit;
    }

    /**
     * @Access		:	public
     * @Function	:	index
     * @Description	:	Index page display
     * @Param		:	none
     */
    public function index($error = '') {
        $selected_site = $this->get_site();
        $selected_site_page = $selected_site[0]['configuration_page'];
        $data['title'] = 'Home';
        $site_lists = $this->dashboard_model->get_site_lists();
        $fetch_field_details = $this->dashboard_model->fetch_data();

        $keywords_list = $this->keywords_model->get_keywords();
        $emails_list = $this->email_model->get_emails();
        $selected_site_keywords = $this->keywords_model->get_keywords($selected_site[0]['id']);
        $selected_site_emails = $this->email_model->get_emails($selected_site[0]['id']);

        if (!empty($fetch_field_details)) {
            $fetch_field_details = $this->format_result_set($fetch_field_details);
        }
        $data['site_lists'] = $site_lists;
        $data['selected_site_id'] = $selected_site[0]['id'];
        $data['keywords_list'] = $keywords_list;
        $data['emails_list'] = $emails_list;
        $data['field_details'] = $fetch_field_details;
        $data['selected_site_keywords'] = $selected_site_keywords;
        $data['selected_site_emails'] = $selected_site_emails;

        $data['site_page'] = $this->load->view('sites/' . $selected_site_page, $data, TRUE);

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

    public function save_configuration() {
        if (!empty($_POST)) {
            $config_id = isset($_POST['site_id']) ? $_POST['site_id'] : 0;
            $value = '';

            if (isset($_POST['save'])) {
                //print_r($_POST);
                $this->dashboard_model->reset_selected_status($config_id);

                $email_list = isset($_POST['emails']) ? $_POST['emails'] : '';
                $email_activation_list = $this->email_model->email_list($email_list);
                if (!empty($email_activation_list)) {
                    $update_email_list = $this->email_model->update_email_configuration($email_activation_list, $config_id);
                }

                $keyword_list = isset($_POST['keywords']) ? $_POST['keywords'] : '';
                $keyword_activation_list = $this->keywords_model->keyword_list($keyword_list);
                if (!empty($keyword_activation_list)) {
                    $update_keyword_list = $this->keywords_model->update_keyword_configuration($keyword_activation_list, $config_id);
                }

                if (isset($_POST['set']) && !empty($_POST['set'])) {
                    foreach ($_POST['set'] as $key => $val) {
                        $value = '';
                        if (!strpos($key, '_')) {
                            $field_id = $key;
                            if (!is_array($val)) {
                                if (!strpos($val, '_')) {
                                    $field_value_id = $val;
                                    $this->dashboard_model->update_selected_fields($config_id, $field_id, $field_value_id);
                                } else {
                                    $field_value_id = substr($val, 0, strpos($val, '_'));
                                    $value = substr($val, strpos($val, '_') + 1);

                                    $this->dashboard_model->update_selected_fields($config_id, $field_id, $field_value_id, $value);
                                }
                            } else {
                                foreach ($val as $multivalue) {
                                    $this->dashboard_model->update_selected_fields($config_id, $field_id, $multivalue);
                                }
                            }
                        } else {
                            $field_id = substr($key, 0, strpos($key, '_'));
                            if (!is_array($val)) {
                                if (!strpos($val, '_')) {
                                    $field_value_id = $val;
                                    $this->dashboard_model->update_selected_fields($config_id, $field_id, $field_value_id);
                                } else {
                                    $field_value_id = substr($val, 0, strpos($val, '_'));
                                    $value = substr($val, strpos($val, '_') + 1);
                                    //                               echo $field_value_id.'$$$'.$value;die;
                                    $this->dashboard_model->update_selected_fields($config_id, $field_id, $field_value_id, $value);
                                }
                            }
                        }
                    }
                }
            }

            if (isset($_POST['search'])) {
                $request_url = $this->generate_url($_POST);
                $result = $this->send_request($request_url);
                print_r($result);
            }
            die(json_encode(array('error' => 0, 'message' => 'success')));
        }
    }

    public function generate_url($post_vars) {
        $url_params = $this->config->item('url_params');
        $post_data = "";
        
        foreach ($post_vars['set'] as $key => $val) {
            $bracket = '';
            if (strpos($key, '_')) {
                $field_id = substr($key, 0, strpos($key, '_'));
                $field_value_id = substr($val, 0, strpos($val, '_'));
                $value = substr($val, strpos($val, '_') + 1);

                $config_val = $this->dashboard_model->get_config_values($field_id, $field_value_id);
                //echo $config_val[0]['field_name'].'--'.$config_val[0]['field_type'].'--'.$config_val[0]['field_value_name'].'--'. $value .'<br />';
                $post_data .= '&amp;' . $config_val[0]['field_value_name'] . '=' . $value;
            } else {
                if($key == 1 || $key == 4) {
                    $bracket = '[]';
                }
                
                if (is_array($val)) {
                    foreach ($val as $multivalue) {
                        $config_val = $this->dashboard_model->get_config_values($key, $multivalue);
                        $post_data .= '&amp;' . $url_params[$key] . $bracket . '=' . $config_val[0]['value'];
                    }
                } else {
                    $config_val = $this->dashboard_model->get_config_values($key, $val);
                    $post_data .= '&amp;' . $url_params[$key] . $bracket .'=' . $config_val[0]['value'];
                }
                //echo $config_val[0]['field_name'].'--'.$config_val[0]['field_type'].'--'.$config_val[0]['field_value_name'].'--'. $config_val[0]['value'] .'<br />';
                //echo '<hr>';
            }
        }
        
        if(isset($post_vars['keywords'])) {
            $post_data .= '&amp;t=' . $post_vars['keywords'];
        }

        $params = ltrim($post_data, '&amp;');
        
        $global_url = $this->config->item('global_url');
        
        return $global_url.'?'.$params;

        /*
          $response = $this->dashboard_model->get_config_params($config);
          $post_data = "";
          //        echo "<pre>";print_r($response);die;
          $old_id = -1;
          $date = array();
          foreach ($response as $each) {
          if ($each['field_id'] == '6') {
          $date[] = $each;
          continue;
          }
          if ($old_id != $each['field_id']) {
          $old_id = $each['field_id'];

          if ($old_id != '1')
          $post_data .= '&' . $config_file[$old_id] . '=';
          else
          $post_data .= $config_file[$old_id] . '=';
          $post_data .= $each['value'];
          } else {
          $post_data .= ',' . $each['value'];
          }
          }
          if (!empty($date)) {
          $id = 9;
          foreach ($date as $item) {
          $post_data .= '&' . $config_file[$id++] . '=';
          $post_data .= $item['value'];
          }
          }
          return urlencode($post_data);
         * 
         */
    }

}

?>
