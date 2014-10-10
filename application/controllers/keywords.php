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
        $get_keyword_list =   $this->keywords_model->get_keywords();
        $data['keyword_list'] =   $get_keyword_list;
        $this->load->view('navigation_header');
        $this->load->view("keywords_list.php",$data);
        $this->load->view('navigation_footer');
        $this->load->view('footer');
    }
    
    public function modify_keyword(){
        if(!empty($_POST)){
        	if($this->keywords_model->keyword_check($_POST)){
        		echo json_encode(array('error' => -1));die;
        	}
            $response   =   $this->keywords_model->modify_keyword($_POST);
            if($_POST['id'] =='0'){
                echo json_encode(array('error' => 0, 'id'=>$response));die;
            }else{
                echo json_encode(array('error' => 0));die;
            }
        }
    }
    
    public function delete_keyword(){
        if(!empty($_POST)){
            $response   =   $this->keywords_model->delete_keyword($_POST);
            echo json_encode(array('error' => 0));die;
        }
    }

}

?>