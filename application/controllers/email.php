<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @File : email Controller
 * @Class : Emails
 * @Description: This class file holds the operations of user settings, configurations etc.
 * Created By: Himanshu Arora
 */
class Email extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('email_model');
    }

    /**
     * @Access		:	public
     * @Function	:	index
     * @Description	:	Index page display
     * @Param		:	none
     */
    public function index($error = '') {
        $data['title'] = 'Home';
        $this->load->view('header');
        $get_email_list =   $this->email_model->get_emails();
        $data['email_list'] =   $get_email_list;
        $this->load->view('navigation_header');
        $this->load->view("email_list.php",$data);
        $this->load->view('navigation_footer');
        $this->load->view('footer');
    }
    
    public function modify_email(){
        if(!empty($_POST)){
            $response   =   $this->email_model->modify_email($_POST);
            if($_POST['id'] =='0'){
                echo json_encode(array('error' => 0, 'id'=>$response));die;
            }else{
                echo json_encode(array('error' => 0));die;
            }
        }
    }
    
    public function delete_email(){
        if(!empty($_POST)){
            $response   =   $this->email_model->delete_email($_POST);
            echo json_encode(array('error' => 0));die;
        }
    }

}

?>