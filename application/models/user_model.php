<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @File : user_model.php Model
 * @Class : User_model
 * @Description: This class file holds all the user related operations.
 * @Created By: Himanshu Arora
 */
class User_model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
	 * @Function	:	login
	 * @Description	:	Logins a user and creates a session for it
	 * @Param		:	$email and $password 
	 */	
	function login($email,$password) {
		$this->db->where("email",$email);
        $this->db->where("password",$password);
        $query=$this->db->get("user");
		if($query->num_rows()>0)
        {
         	foreach($query->result() as $rows)
            {
            	//add all data to session
                $newdata = array(
                	   	'user_id' 		=> $rows->id,
                    	'user_email'    => $rows->email,
	                    'logged_in' 	=> TRUE,
                   );
			}
			$this->session->set_userdata($newdata);
			return true;            
		}
		return false;
    }
}
?>