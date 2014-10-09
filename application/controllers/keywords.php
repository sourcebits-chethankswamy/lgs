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
        $this->load->view('navigation_header');
        $this->load->view("keywords_list.php",$data);
        $this->load->view('navigation_footer');
        $this->load->view('footer');
    }

}

?>