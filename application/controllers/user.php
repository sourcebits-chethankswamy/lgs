<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @File : user.php Controller
 * @Class : User
 * @Description: This class file holds the operations of user login, display settings, configurations etc.
 * Created By: Himanshu Arora
 */
class User extends CI_Controller{
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
		$this->load->view('header_view');
        $this->load->view("login.php", $data);
		$this->load->view('footer_view');
    }
	
	/**
	 * @Access		:	public
	 * @Function	:	welcome
	 * @Description	:	Welcome page display
	 * @Param		:	none
	 */
	public function welcome() {
		$data['title']= 'Home';
		$this->load->view('header_view');
		$this->load->view('navigation_header');
		$this->load->view("welcome_view.php",$data);
		$this->load->view('footer_view');
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
		if($result) $this->welcome();
		else        $this->index("Invalid Credentials");
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
}
?>