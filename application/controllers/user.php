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
        $this->load->library('session');
        $this->load->model('user_model');
    }

    /**
     * @Access		:	public
     * @Function	:	index
     * @Description	:	Index page display
     * @Param		:	none
     */
    public function index($error = '') {
        if ($this->session->userdata('logged_in') == 1) {
            redirect('dashboard');
        } else {
            $data['title'] = 'Home';
            $data['error'] = $error;
            $this->load->view('header');
            $this->load->view("login", $data);
            $this->load->view('footer');
        }
    }

    /**
     * @Access		:	public
     * @Function	:	login
     * @Description	:	Login user
     * @Param		:	none
     */
    public function login() {
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));
        $result = $this->user_model->login($email, $password);
        if ($result) {
            redirect('/dashboard');
        } else {
            $this->index("Invalid Credentials");
        }
    }

    /**
     * @Access		:	public
     * @Function	:	logout
     * @Description	:	Logout user
     * @Param		:	none
     */
    public function logout() {
        $newdata = array(
            'user_id' => '',
            'user_name' => '',
            'user_email' => '',
            'logged_in' => FALSE,
        );
        $this->session->unset_userdata($newdata);
        $this->session->sess_destroy();
        redirect('/');
    }

    public function generate_configuration_url() {
        $response = $this->user_model->get_config_params();
        $old_id = -1;
        $new_id;
        foreach ($response as $each) {
            if ($old_id != $each['field_id']) {
                $old_id = $each['field_id'];
            } else {
                
            }
        }
        switch ($each['$field_id']) {
            
        }
        if (!empty($response)) {
            
        } else {
            return array('error' => 0, 'message' => 'url not found');
        }
    }

    public function forgotpassword() {
        $data['title'] = 'LGS - Forgot password';

        $this->load->view('header');
        $this->load->view('forgetpassword', $data);
        $this->load->view('footer');
    }
    
    public function user_registration(){
    	$data['title'] = 'User Registration';
        $this->load->view('header');
        $this->load->view('registeruser', $data);
        $this->load->view('footer');
        
    }
    
	public function register(){
    	$email 				= $_POST['email'];
    	$password 			= $_POST['new_password'];
    	$status				= $this->user_model->register_user($email, $password);
    	if(isset($status) && $status == true){
    		$subject 			= 'LGS - New user registration';
	        $email_body 		= "Hello Admin,
	        						<br/><br/>
	        						You are successfully signed up for LGS account. Here are your account details.
	        						<br/><br/>
	        						Email: ".$email.
	        						"<br/><br/>
	        						Regards,
	        						Team LGS";
													
	        $this->sendMail($email, $subject, $email_body);
	    	$message = "User Registered Successfully";
	        $this->session->set_flashdata("message", $message);
			redirect('/');		
    	} else {
    		$message = "Email already exist";
            $this->session->set_flashdata("message", $message);
            redirect('/user/user_registration');
    	}
    }

    public function doforget() {
        $this->load->helper('url');
        $email = $_POST['email'];

        $check_email = $this->user_model->check_user_email($email);
        if ($check_email) {
            $user = $check_email[0];
            $this->resetpassword($user);

            $message = "Password has been reset and has been sent to email id: " . $email;
            $this->session->set_flashdata("message", $message);

            redirect('/');
        } else {
            $message = "The email id you entered is not found on our database";
            $this->session->set_flashdata("message", $message);

            redirect('/user/forgotpassword');
        }
    }

    private function resetpassword($user) {
        date_default_timezone_set('GMT');
        $this->load->helper('string');
        $password = random_string('alnum', 16);

        $this->user_model->reset_password($user['id'], $password);

        $subject = 'LGS - Password reset';
        $email_body = 'You have requested the new password, Here is you new password:' . $password;
        $this->sendMail($user['email'], $subject, $email_body);
    }

    public function sendMail($to, $sub, $message) {
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => $this->config->item('FROM_EMAIL_ADDRESS'),
            'smtp_pass' => $this->config->item('FROM_EMAIL_PASSWORD'),
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->set_crlf("\r\n");
        $this->email->from($this->config->item('FROM_EMAIL_ADDRESS'));
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

?>
