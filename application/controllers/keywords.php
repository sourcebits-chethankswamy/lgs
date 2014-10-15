<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @File : keywords Controller
 * @Class : Keywords
 * @Description: This class file holds the operations of user settings, configurations etc.
 * Created By: Himanshu Arora
 */
class Keywords extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('keywords_model');
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
        $get_keyword_list = $this->keywords_model->get_keywords();
        $data['keyword_list'] = $get_keyword_list;
        $this->load->view('navigation_header');
        $this->load->view("keywords_list.php", $data);
        $this->load->view('navigation_footer');
        $this->load->view('footer');
    }

    public function modify_keyword() {
        if (!empty($_POST)) {
            if ($this->keywords_model->keyword_check($_POST)) {
                $error = 1;
            	$message = 'Keyword already exists';
            }
            $response = $this->keywords_model->modify_keyword($_POST);
            if($response){
            	$error = 0;
            	$message = 'Keyword successfully saved!!!';
            } else {
            	$error = 1;
            	$message = 'Error while saving keyword, please try again';
            }     
        } else {
        	$error = 1;
        	$message = 'No keyword provided';        
        }
        die(json_encode(array('error'=> $error, 'message' => $message)));     
    }

    public function delete_keyword() {
        if (!empty($_POST)) {
            $response = $this->keywords_model->delete_keyword($_POST);
             if($response){
            	$error = 0;
            	$message = 'Keyword successfully deleted!!!';
            } else {
            	$error = 1;
            	$message = 'Error while deleting keyword, please try again';
            }     
        } else {
        	$error = 1;
        	$message = 'No keyword provided';        
        }
        die(json_encode(array('error'=> $error, 'message' => $message)));     
    }
}
?>