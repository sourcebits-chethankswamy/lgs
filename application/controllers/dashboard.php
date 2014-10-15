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
        //$this->load->library('session');

        $this->load->model('dashboard_model');
        $this->load->model('keywords_model');
        $this->load->model('email_model');
    }

    public function changepassword() {
        $data['title'] = 'LGS - Change password';

        $this->load->view('header');
        $this->load->view('changepassword', $data);
        $this->load->view('footer');
    }

    public function dochangepassword() {
        $user_id = $this->session->userdata('user_id');
        $check_user = $this->dashboard_model->check_user($user_id, $_POST['old_password']);
        
        if ($check_user) {            
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            if (strcmp($new_password, $confirm_password) !== 0) {
                $message = "The new password and confirm password do not match, please try again";
                $this->session->set_flashdata("message", $message);

                redirect('/dashboard/changepassword');
            } else {
                $change = $this->dashboard_model->change_password($user_id, $confirm_password);

                if ($change) {
                    $message = "Password successfully changed, please login again with new password";
                    $this->session->set_flashdata("message", $message);

                    redirect('/dashboard');
                } else {
                    $message = "Error while updating password, please try again";
                    $this->session->set_flashdata("message", $message);

                    redirect('/dashboard/changepassword');
                }
            }
        } else {
            $message = "The password you provided is incorrect, please enter your current password";
            $this->session->set_flashdata("message", $message);

            redirect('/dashboard/changepassword');
        }
    }

    function removecron($config_id) {
        if ($config_id) {
            $cron_details = $this->dashboard_model->get_cron_details($config_id);

            if (!empty($cron_details)) {
                $min = ($cron_details[0]['minute'] == 'NULL') ? '*' : $cron_details[0]['minute'];
                $hour = ($cron_details[0]['hour'] == 'NULL') ? '*' : $cron_details[0]['hour'];
                $day = ($cron_details[0]['day-of-month'] == 'NULL') ? '*' : $cron_details[0]['day-of-month'];
                $month = ($cron_details[0]['month'] == 'NULL') ? '*' : $cron_details[0]['month'];
                $week = ($cron_details[0]['day-of-week'] == 'NULL') ? '*' : $cron_details[0]['day-of-week'];

                $output = shell_exec('/usr/bin/crontab -l');

                $remove_cron = str_replace("*/$min $hour $day $month $week /Applications/MAMP/bin/php/php5.5.10/bin/php /Applications/MAMP/htdocs/lgs/index.php crawl/testruncronjob > /Users/chethan/lgscronlogs.log", "", $output);

                file_put_contents('/tmp/crontab.txt', $remove_cron);
                echo exec('/usr/bin/crontab /tmp/crontab.txt', $output);

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function setcron($config_id) {
        if ($config_id) {
            $cron_details = $this->dashboard_model->get_cron_details($config_id);

            if (!empty($cron_details)) {
                $min = ($cron_details[0]['minute'] == 'NULL') ? '*' : $cron_details[0]['minute'];
                $hour = ($cron_details[0]['hour'] == 'NULL') ? '*' : $cron_details[0]['hour'];
                $day = ($cron_details[0]['day-of-month'] == 'NULL') ? '*' : $cron_details[0]['day-of-month'];
                $month = ($cron_details[0]['month'] == 'NULL') ? '*' : $cron_details[0]['month'];
                $week = ($cron_details[0]['day-of-week'] == 'NULL') ? '*' : $cron_details[0]['day-of-week'];

                //echo exec('crontab -r');
                $output = shell_exec('/usr/bin/crontab -l');

                //print_r($output);

                /*
                  $strchunk = explode('\n', $output);
                  echo '<br /><br />';
                  print_r($strchunk);
                  exit;
                 */

                //$remove_cron = str_replace("01 01 * * * /Applications/MAMP/bin/php/php5.5.10/bin/php /Applications/MAMP/htdocs/lgs/index.php crawl/checkcron > /Users/chethan/lgsnew.log\n", "", $output);
                //file_put_contents('/tmp/lgscrontab.txt', $remove_cron.PHP_EOL);
                //echo exec('/usr/bin/crontab /tmp/lgscrontab.txt', $output);
                //echo '<br /><br />';
                //exit;


                file_put_contents('/tmp/crontab.txt', $output . "*/$min $hour $day $month $week /Applications/MAMP/bin/php/php5.5.10/bin/php /Applications/MAMP/htdocs/lgs/index.php crawl/testruncronjob > /Users/chethan/lgscronlogs.log" . PHP_EOL);

                echo exec('/usr/bin/crontab /tmp/crontab.txt', $output);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function addconfiguration($config_id) {
        if ($config_id != '') {
            $selected_site = $this->get_site();
            $selected_site_page = $selected_site[0]['configuration_page'];
            $data['title'] = 'LGS - Add New Configuration';
            //$data['site_configurations'] = $this->dashboard_model->get_site_configurations($config_id, 1);

            $fetch_field_details = $this->dashboard_model->get_all_configuration($config_id);

            if (!empty($fetch_field_details)) {
                $fetch_field_details = $this->format_result_set($fetch_field_details);
            }

            $data['keywords_list'] = $this->keywords_model->get_keywords();
            $data['emails_list'] = $this->email_model->get_emails();
            $data['field_details'] = $fetch_field_details;
            $data['site_lists'] = $this->dashboard_model->get_site_lists();
            $data['selected_site_id'] = $selected_site[0]['id'];
            $data['selected_configuration_id'] = $config_id;

            $data['site_page'] = $this->load->view('sites/' . $selected_site_page . '/add', $data, TRUE);

            $this->load->view('header');
            $this->load->view('navigation_header');
            $this->load->view("dashboard", $data);
            $this->load->view('navigation_footer');
            $this->load->view('footer');
        } else {
            $message = 'Invalid Configuration';
            $this->session->set_flashdata("message", $message);

            redirect('/dashboard');
        }
    }

    public function editconfiguration($config_id) {
        if ($config_id != '') {
            $selected_site = $this->get_site();
            $selected_site_page = $selected_site[0]['configuration_page'];
            $data['title'] = 'LGS - Edit Configuration';
            //$data['site_configurations'] = $this->dashboard_model->get_site_configurations($config_id, 1);

            $fetch_field_details = $this->dashboard_model->get_all_configuration($config_id);
            //print_r($fetch_field_details);exit;
            if (!empty($fetch_field_details)) {
                $fetch_field_details = $this->format_result_set($fetch_field_details);
            }
            $configuration_details = $this->dashboard_model->get_configuration_details($config_id);

            $data ['configuration_name'] = $configuration_details[0]['configuration_name'];
            $data['keywords_list'] = $this->keywords_model->get_keywords();
            $data['emails_list'] = $this->email_model->get_emails();
            $data['field_details'] = $fetch_field_details;
            $data['site_lists'] = $this->dashboard_model->get_site_lists();
            $data['selected_site_id'] = $selected_site[0]['id'];
            $data['selected_configuration_id'] = $config_id;
            $data['selected_site_keywords'] = $this->keywords_model->get_keywords($config_id);

            $data['site_page'] = $this->load->view('sites/' . $selected_site_page . '/edit', $data, TRUE);

            $this->load->view('header');
            $this->load->view('navigation_header');
            $this->load->view("dashboard", $data);
            $this->load->view('navigation_footer');
            $this->load->view('footer');
        } else {
            $message = 'Invalid Configuration';
            $this->session->set_flashdata("message", $message);

            redirect('/dashboard');
        }
    }

    public function deleteconfiguration($config_id) {
        if ($config_id != '') {
            $selected_site = $this->get_site();

            $delete = $this->dashboard_model->delete_configuration_details($config_id, $selected_site[0]['id']);
            if ($delete) {
                $message = 'Configuration successfully deleted!!!';
            } else {
                $message = 'Configuration could be deleted, please try again';
            }
            $this->session->set_flashdata("message", $message);

            redirect('/dashboard');
        } else {
            $message = 'Invalid Configuration';
            $this->session->set_flashdata("message", $message);

            redirect('/dashboard');
        }
    }

    public function changeconfigurationstatus($config_id, $status) {
        if ($config_id != '' && $status != '') {
            $selected_site = $this->get_site();

            $change = $this->dashboard_model->change_configuration_status($status, $config_id, $selected_site[0]['id']);

            $active_status = ($status) ? "Active" : "In-Active";
            if ($change) {
                $message = 'Configuration successfully made ' . $active_status . '!!!';
            } else {
                $message = 'Configuration make it ' . $active_status . ', please try again';
            }
            $this->session->set_flashdata("message", $message);

            redirect('/dashboard');
        } else {
            $message = 'Invalid Configuration';
            $this->session->set_flashdata("message", $message);

            redirect('/dashboard');
        }
    }

    /**
     * @Access		:	public
     * @Function	:	index
     * @Description	:	Index page display
     * @Param		:	none
     */
    public function index() {
        $selected_site = $this->get_site();
        $selected_site_page = $selected_site[0]['configuration_page'];
        $data['title'] = 'LGS - Dashboard';

        $config_det = array();
        $site_configurations_list = $this->dashboard_model->get_site_configuration_lists($selected_site[0]['id']);
        foreach ($site_configurations_list as $site_list_key => $site_list) {
            $config_det[$site_list['configuration_name']]['configuration_id'] = $site_list['id'];
            $config_det[$site_list['configuration_name']]['configuration_status'] = $site_list['status'];
            $config_det[$site_list['configuration_name']]['configuration_values'] = $this->dashboard_model->get_configuration($site_list['id']);
        }

        $data['config_det'] = $config_det;
        //$data['site_configurations'] = $this->dashboard_model->get_site_configurations($site_configurations_list[0]['id']);

        $data['site_lists'] = $this->dashboard_model->get_site_lists();
        $data['selected_site_id'] = $selected_site[0]['id'];

        $data['site_page'] = $this->load->view('sites/' . $selected_site_page . '/list', $data, TRUE);

        $this->load->view('header');
        $this->load->view('navigation_header');
        $this->load->view("dashboard", $data);
        $this->load->view('navigation_footer');
        $this->load->view('footer');


        /*

          $fetch_field_details = $this->dashboard_model->fetch_data();

          $keywords_list = $this->keywords_model->get_keywords();
          $emails_list = $this->email_model->get_emails();
          $selected_site_keywords = $this->keywords_model->get_keywords($selected_site[0]['id']);
          $selected_site_emails = $this->email_model->get_emails($selected_site[0]['id']);
          $cronjob_settings = $this->dashboard_model->get_cronjob_settings($selected_site[0]['id']);

          if (!empty($fetch_field_details)) {
          $fetch_field_details = $this->format_result_set($fetch_field_details);
          }


          $data['keywords_list'] = $keywords_list;
          $data['emails_list'] = $emails_list;
          $data['field_details'] = $fetch_field_details;
          $data['selected_site_keywords'] = $selected_site_keywords;
          $data['selected_site_emails'] = $selected_site_emails;
          $data['cronjob_settings'] = $cronjob_settings;

         */
    }

    public function format_result_set($data) {
        //print_r($data);exit;
        $old_id = -1;
        $new_id = 0;
        $prerare_data = array();
        foreach ($data as $each_field) {
            unset($result_array);
            if ($old_id != $each_field['field_id']) {
                $new_id = $each_field['field_id'];
                $prepare_data[$new_id]['field_name'] = $each_field['field_name'];
                $prepare_data[$new_id]['field_type'] = $each_field['field_type'];
                $result_array['configuration_id'] = $each_field['configuration_id'];
                $result_array['field_value_id'] = $each_field['field_value_id'];
                $result_array['field_value_name'] = $each_field['field_value_name'];

                if ($each_field['field_id'] == '6') {
                    $result_array['value'] = $each_field['field_value_slv'];
                } else {
                    $result_array['value'] = $each_field['field_value'];
                }

                $result_array['selected_status'] = $each_field['selected_status'];
                $prepare_data[$new_id]['result_set'][] = $result_array;
                $old_id = $each_field['field_id'];
            } else {
                $result_array['configuration_id'] = $each_field['configuration_id'];
                $result_array['field_value_id'] = $each_field['field_value_id'];
                $result_array['field_value_name'] = $each_field['field_value_name'];

                if ($each_field['field_id'] == '6') {
                    $result_array['value'] = $each_field['field_value_slv'];
                } else {
                    $result_array['value'] = $each_field['field_value'];
                }

                $result_array['selected_status'] = $each_field['selected_status'];
                $prepare_data[$old_id]['result_set'][] = $result_array;
            }
        }
        return $prepare_data;
    }

    public function save() {
        //print_r($_POST);echo '<br />';exit;
        if (!empty($_POST)) {
            $site_id = isset($_POST['site_id']) ? $_POST['site_id'] : 0;
            $config_id = isset($_POST['configuration_id']) ? $_POST['configuration_id'] : 0;

            $value = '';

            if (isset($_POST['save'])) {
                if ($config_id == 0) {
                    $config_name = $_POST['config_name'];
                    $create_new_config = $this->dashboard_model->create_site_configuration($site_id, $config_name);
                    $config_id = $create_new_config;
                }

                /*
                  if (isset($_POST['cronjob']) && !empty($_POST['cronjob'])) {
                  $this->removecron($config_id);
                  $cronjob = $this->dashboard_model->get_cronjob_settings($config_id);
                  if (empty($cronjob)) {
                  $this->dashboard_model->set_cronjob_settings($_POST['cronjob'], $config_id);
                  } else {
                  $this->dashboard_model->update_cronjob_settings($_POST['cronjob'], $config_id);
                  }
                  $this->setcron($config_id);
                  }
                 */

                $this->dashboard_model->reset_selected_status($config_id);

                /*
                  $email_list = isset($_POST['emails']) ? $_POST['emails'] : '';
                  if ($email_list != '') {
                  $email_activation_list = $this->email_model->email_list($email_list);
                  if (!empty($email_activation_list)) {
                  $update_email_list = $this->email_model->update_email_configuration($email_activation_list, $config_id);
                  }
                  }
                 */

                $config_name = isset($_POST['config_name']) ? $_POST['config_name'] : '';
                if ($config_name != '') {
                    $this->dashboard_model->update_config_name($config_name, $config_id);
                }

                $keyword_list = isset($_POST['keywords']) ? $_POST['keywords'] : '';
                if ($keyword_list != '') {
                    $keyword_activation_list = $this->keywords_model->keyword_list($keyword_list);
                    if (!empty($keyword_activation_list)) {
                        $update_keyword_list = $this->keywords_model->update_keyword_configuration($keyword_activation_list, $config_id);
                    }
                }

                if (isset($_POST['set']) && !empty($_POST['set'])) {
                    foreach ($_POST['set'] as $key => $val) {
                        $value = '';
                        if (!strpos($key, '_')) {
                            $field_id = $key;
                            if (!is_array($val)) {
                                if (!strpos($val, '_')) {
                                    $field_value_id = $val;
                                    $this->dashboard_model->update_selected_fields($config_id, $field_value_id);
                                } else {
                                    $field_value_id = substr($val, 0, strpos($val, '_'));
                                    $value = substr($val, strpos($val, '_') + 1);

                                    $this->dashboard_model->update_selected_fields($config_id, $field_value_id, $value);
                                }
                            } else {
                                foreach ($val as $multivalue) {
                                    $this->dashboard_model->update_selected_fields($config_id, $multivalue);
                                }
                            }
                        } else {
                            $field_id = substr($key, 0, strpos($key, '_'));
                            if (!is_array($val)) {
                                if (!strpos($val, '_')) {
                                    $field_value_id = $val;
                                    $this->dashboard_model->update_selected_fields($config_id, $field_value_id);
                                } else {
                                    $field_value_id = substr($val, 0, strpos($val, '_'));
                                    $value = substr($val, strpos($val, '_') + 1);
                                    //echo $field_value_id.'$$$'.$value.'<br />';
                                    $this->dashboard_model->update_selected_fields($config_id, $field_value_id, $value);
                                }
                            }
                        }
                    }
                }

                $message = 'Settings successfully changed!!!';
                $this->session->set_flashdata("message", $message);

                redirect('/dashboard');

                /*
                  $selected_site = $this->get_site();
                  $selected_site_page = $selected_site[0]['configuration_page'];
                  $data['title'] = 'Home';
                  $data['save'] = '1';
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
                 * 
                 */
            }
        } else {
            redirect('/dashboard');
        }
    }

    public function configsettings() {
        $selected_site = $this->get_site();

        $data['title'] = 'LGS - Configuration Settings';
        $data['site_lists'] = $this->dashboard_model->get_site_lists();
        $data['selected_site_id'] = $selected_site[0]['id'];
        $data['emails_list'] = $this->email_model->get_emails();
        $data['selected_site_emails'] = $this->email_model->get_emails($selected_site[0]['id']);
        $data['cronjob_settings'] = $this->dashboard_model->get_cronjob_settings($selected_site[0]['id']);

        $data['site_page'] = $this->load->view('configsettings', $data, TRUE);

        $this->load->view('header');
        $this->load->view('navigation_header');
        $this->load->view("configsettings", $data);
        $this->load->view('navigation_footer');
        $this->load->view('footer');
    }

    public function saveconfigsettings() {
        if (!empty($_POST)) {
            $config_id = isset($_POST['site_id']) ? $_POST['site_id'] : 0;
            $value = '';

            if (isset($_POST['save'])) {
                if (isset($_POST['cronjob']) && !empty($_POST['cronjob'])) {
                    $this->removecron($config_id);
                    $cronjob = $this->dashboard_model->get_cronjob_settings($config_id);
                    if (empty($cronjob)) {
                        $this->dashboard_model->set_cronjob_settings($_POST['cronjob'], $config_id);
                    } else {
                        $this->dashboard_model->update_cronjob_settings($_POST['cronjob'], $config_id);
                    }
                    $this->setcron($config_id);
                }

                $email_list = isset($_POST['emails']) ? $_POST['emails'] : '';
                if ($email_list != '') {
                    $email_activation_list = $this->email_model->email_list($email_list);
                    if (!empty($email_activation_list)) {
                        $update_email_list = $this->email_model->update_email_configuration($email_activation_list);
                    }
                }
                $message = 'Settings successfully changed!!!';
                $this->session->set_flashdata("message", $message);

                redirect('dashboard/configsettings');
            }
        } else {
            redirect('dashboard/configsettings');
        }
    }

    public function search() {
        if (isset($_POST)) {
            $request_url = $this->generate_url($_POST);
            $result = $this->send_request($request_url);
            echo $result;
        } else {
            echo 'Invalid input';
        }

        exit;


        $selected_site = $this->get_site();
        $selected_site_page = $selected_site[0]['configuration_page'];
        $data['title'] = 'LGS - Search results';
        if (isset($result) && $result != '') {
            /*
              if (isset($_POST['emails'])) {
              if ($_POST['emails'] != '') {
              $to_email = $_POST['emails'];
              $subject = 'Search results for ' . strtoupper($selected_site[0]['configuration_name']);
              $this->sendMail($to_email, $subject, $result);
              }
              }
             */
            $data['search_view'] = $result;
        } else {
            $data['search_view'] = "Sorry, No Record matches your request.";
        }
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

    public function generate_url($post_vars) {
        $url_params = $this->config->item('url_params');
        $post_data = "";

        if (isset($post_vars['set'])) {
            foreach ($post_vars['set'] as $key => $val) {
                $bracket = '';
                if (strpos($key, '_')) {
                    $field_id = substr($key, 0, strpos($key, '_'));
                    $field_value_id = substr($val, 0, strpos($val, '_'));
                    $value = substr($val, strpos($val, '_') + 1);

                    $config_val = $this->dashboard_model->get_config_values($field_id, $field_value_id);
                    //echo $config_val[0]['field_name'].'--'.$config_val[0]['field_type'].'--'.$config_val[0]['field_value_name'].'--'. $value .'<br />';
                    $post_data .= '&' . $config_val[0]['field_value_name'] . '=' . urlencode($value);
                } else {
                    if ($key == 1 || $key == 4) {
                        $bracket = '[]';
                    }

                    if (is_array($val)) {
                        foreach ($val as $multivalue) {
                            $config_val = $this->dashboard_model->get_config_values($key, $multivalue);
                            $post_data .= '&' . $url_params[$key] . $bracket . '=' . urlencode($config_val[0]['value']);
                        }
                    } else {
                        $config_val = $this->dashboard_model->get_config_values($key, $val);
                        $post_data .= '&' . $url_params[$key] . $bracket . '=' . urlencode($config_val[0]['value']);
                    }
                    //echo $config_val[0]['field_name'].'--'.$config_val[0]['field_type'].'--'.$config_val[0]['field_value_name'].'--'. $config_val[0]['value'] .'<br />';
                    //echo '<hr>';
                }
            }
        }

        if (isset($post_vars['keywords'])) {
            $post_data .= '&t=' . urlencode($post_vars['keywords']);
        }

        //$params = ltrim($post_data, '&');
        $params = $post_data;

        $global_url = $this->config->item('global_url');

        return $global_url . '?limit=100' . $params;

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
