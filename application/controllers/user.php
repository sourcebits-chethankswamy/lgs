<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @File : user.php Controller
 * @Class : User
 * @Description: This class file holds the operations of user login, display settings, configurations etc.
 * Created By: Himanshu Arora
 */
class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

/**
	 * @Access		:	public
	 * @Function	:	index
	 * @Description	:	Index page display
	 * @Param		:	none
	 */
	public function index($error = '') {
		$data['title']= 'Home';
		$data['error']= $error;
		$this->load->view('header');
        $this->load->view("login.php", $data);
		$this->load->view('footer');
    }
	
	/**
	 * @Access		:	public
	 * @Function	:	welcome
	 * @Description	:	Welcome page display
	 * @Param		:	none
	 */
	public function welcome() {
		$data['title']= 'Home';
		$this->load->view('header');
		$this->load->view('navigation_header');
		$this->load->view("dashboard.php",$data);
		$this->load->view('navigation_footer');
		$this->load->view('footer');
	}
	
	/**
	 * @Access		:	public
	 * @Function	:	login
	 * @Description	:	Login user
	 * @Param		:	none
	 */
	public function login() {
		$email=$this->input->post('email');
		$password=md5($this->input->post('password'));
		$result=$this->user_model->login($email,$password);
		if($result) {
			redirect('/dashboard');
		}
		else {
			$this->index("Invalid Credentials");
		}
	}
	
	/**
	 * @Access		:	public
	 * @Function	:	logout
	 * @Description	:	Logout user
	 * @Param		:	none
	 */
	public function logout()
	{
		$newdata = array(
		'user_id'   =>'',
		'user_name'  =>'',
		'user_email'     => '',
		'logged_in' => FALSE,
		);
		$this->session->unset_userdata($newdata );
		$this->session->sess_destroy();
		$this->index();
	}
    

    /**
     * @Access		:	public
     * @Function	:	logout
     * @Description	:	Logout user
     * @Param		:	none
     */
    public function send_request($request_url, $post_data) {

        $request_url = 'http://www.globaltenders.com/search.php';

        $curl = curl_init($request_url);
        $post_data = array(
            "notice_type_new" => "1,2,3,7,10,11,16,9,4,8",
            "sector" => "0",
            "region_name" => "0",
            "competition" => "2",
            "day" => "0",
            "mon" => "0",
            "year" => "0",
            "t" => "",
            "deadline" => "select",
            "mfa" => "0"
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
        $curl_response = curl_exec($curl);
        curl_close($curl);
        echo $curl_response;

        //$respose_data = json_decode($curl_response,true);
        //echo "<pre>";print_r($respose_data);die;
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

}

?>