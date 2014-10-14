<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @File : user.php Controller
 * @Class : User
 * @Description: This class file holds the operations of user login, display settings, configurations etc.
 * Created By: Himanshu Arora
 */
class Crawl extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('crawl_model');
        $this->load->model('dashboard_model');
        $this->load->model('keywords_model');
        $this->load->model('email_model');
    }

    public function checkcron() {
        echo "Hello, World 123" . PHP_EOL;

        $url_params = $this->config->item('url_params');
        $config = '1';
        $response = $this->dashboard_model->get_config_params($config);
        $post_data = "";

        //echo "<pre>";print_r($response);
        //$old_id = -1; $date = array();

        foreach ($response as $key => $each) {
            $bracket = '';

            if ($each['field_id'] == '1' || $each['field_id'] == '4') {
                $bracket = '[]';
            }

            if ($each['field_id'] == '6') {
                $post_data .= '&' . $each['field_value_name'] . $bracket . '=' . urlencode(sprintf("%02d", $each['value']));
            } else {
                $post_data .= '&' . $url_params[$each['field_id']] . $bracket . '=' . urlencode($each['value']);
            }

            /*
              if ($each['field_id'] == '6') {
              $date[] = $each;
              continue;
              }

              if ($each['field_id'] == '1' || $each['field_id'] == '4') {
              $bracket = '[]';
              }

              if ($old_id != $each['field_id']) {
              $old_id = $each['field_id'];

              if ($old_id != '1') {
              $post_data .= '&' . $config_file[$old_id] . '=';
              } else {
              $post_data .= $config_file[$old_id] . '=';
              }
              $post_data .= $each['value'];
              } else {
              $post_data .= ',' . $each['value'];
              }
             * 
             */
        }
        /*
          if (!empty($date)) {
          $id = 9;
          foreach ($date as $item) {
          $post_data .= '&' . $config_file[$id++] . '=';
          $post_data .= $item['value'];
          }
          }
         * 
         */

        $selected_site_keywords = $this->keywords_model->get_keywords($config);

        if (isset($selected_site_keywords) && !empty($selected_site_keywords)) {
            $key_arr = array();
            foreach ($selected_site_keywords as $keys) {
                array_push($key_arr, $keys['keyword']);
            }
            $post_data .= '&t=' . urlencode(implode(',', $key_arr));
        }

        //$params = ltrim($post_data, '&');
        $params = $post_data;

        $global_url = $this->config->item('global_url');

        $request_url = $global_url . '?limit=100' . $params;
        
        echo $request_url;
        
        //return urlencode($post_data);
    }

    public function send_request($request_url) {
        if ($request_url) {
            $agent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36';
            $options = array(
                CURLOPT_RETURNTRANSFER => true, // return web page
                CURLOPT_HEADER => TRUE, // don't return headers
                CURLOPT_FOLLOWLOCATION => true, // follow redirects
                CURLOPT_ENCODING => "", // handle all encodings
                CURLOPT_USERAGENT => $agent, // who am i
                CURLOPT_AUTOREFERER => true, // set referer on redirect
                CURLOPT_CONNECTTIMEOUT => 120, // timeout on connect
                CURLOPT_TIMEOUT => 120, // timeout on response
                CURLOPT_MAXREDIRS => 10, // stop after 10 redirects
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => Array("Content-Type: text/xml"),
                CURLOPT_FORBID_REUSE => true,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_FRESH_CONNECT => true
            );

            $ch = curl_init($request_url);
            curl_setopt_array($ch, $options);
            $content = curl_exec($ch);
            $err = curl_errno($ch);
            $errmsg = curl_error($ch);
            $header = curl_getinfo($ch);

            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $header['errno'] = $err;
            $header['errmsg'] = $errmsg;
            $header['content'] = $content;

            /* 200 Response! */
            if ($status == 200) {
                $this->load->helper('phpQuery');

                $doc = phpQuery::newDocument($content);

                // Create array to hold stats
                $stats = array();

                $doc['.tableC .table1 div.cent']->find('table tr:last')->remove();

                // Add stats from page to array
                // Notice the CSS style selector
                foreach ($doc['.tableC .table1 div.cent'] as $td) {
                    $href = pq($td)->find('a');
                    if (isset($href) && $href != '') {
                        foreach ($href as $a) {
                            $newhref = 'http://www.globaltenders.com/' . pq($a)->attr('href');
                            pq($a)->attr('href', $newhref);
                        }
                    }
                    $stats[] = pq($td)->html();
                }

                if (isset($stats[0])) {
                    return $stats[0];
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @Access		:	public
     * @Function	:	logout
     * @Description	:	Logout user
     * @Param		:	none
     */
    public function process_url_request($config = '1') {
        switch ($config) {
            case '1': $service_url = $this->config->item('global_url');
                break;
            case '2': $service_url = '';
                break;
            default: $service_url = '';
                break;
        }
        return $service_url;
    }

    /**
     * @Access		:	public
     * @Function	:	logout
     * @Description	:	Logout user
     * @Param		:	none
     */
    public function initialize_post_data($config = '1') {
        $get_activated_config_params = $this->Process_request_model->get_config_params($config);
        return $get_activated_config_params;
    }

    /**
     * @Access		:	public
     * @Function	:	logout
     * @Description	:	Logout user
     * @Param		:	none
     */
    public function request($config) {
        $url = $this->process_url_request($config);
        if (!empty($url)) {
            $post_array = $this->initialize_post_data($config);
        }
        $this->send_request();
    }

    /**
     * @Access		:	public
     * @Function	:	sendMail
     * @Description	:	Sends email to users
     * @Param		:	$to , $sub, $message
     */
    public function sendMail($to, $sub, $message) {
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => FROM_EMAIL_ADDRESS,
            'smtp_pass' => FROM_EMAIL_PASSWORD,
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from(FROM_EMAIL_ADDRESS);
        $this->email->to($to);
        $this->email->subject($sub);
        $this->email->message($message);
        if ($this->email->send()) {
            // Do nothing. Email is sent.
        } else {
            show_error($this->email->print_debugger());
        }
    }

}
