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
    }

    public function checkcron() {
        echo "Hello, World 123" . PHP_EOL;
    }

    public function index() {
        echo "Hello, World" . PHP_EOL;
    }

    /**
     * @Access		:	public
     * @Function	:	logout
     * @Description	:	Logout user
     * @Param		:	none
     */
    public function send_request($request_url) {
        if ($request_url) {
            /* cURL Resource */
            $ch = curl_init();

            /* Set URL */
            curl_setopt($ch, CURLOPT_URL, $request_url);

            /* Tell cURL to return the output */
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            /* Tell cURL NOT to return the headers */
            curl_setopt($ch, CURLOPT_HEADER, false);

            /* Execute cURL, Return Data */
            $data = curl_exec($ch);

            /* Check HTTP Code */
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            /* Close cURL Resource */
            curl_close($ch);

            /* 200 Response! */
            if ($status == 200) {
                $this->load->helper('phpQuery');

                $doc = phpQuery::newDocument($data);

                // Create array to hold stats
                $stats = array();

                // Add stats from page to array
                // Notice the CSS style selector
                foreach ($doc['.tableC .table1 div.cent'] as $td) {
                    $stats[] = pq($td)->html();
                }

                if (isset($status[0])) {
                    return $status[0];
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
