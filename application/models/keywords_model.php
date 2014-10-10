<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @File : keywords_model Model
 * @Class : Keywords
 * @Description: This class file holds all the user related operations.
 * @Created By: Himanshu Arora
 */
class Keywords_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function get_keywords($config = '1'){
        $keyword_list     =   "SELECT * FROM keywords_list WHERE configuration_id = ".$this->db->escape($config)."";
        $result_set     =   $this->db->query($keyword_list)->result_array();
        return $result_set;
    }
    
	 public function keyword_check($data, $config='1'){
    	$keywords     	=   "SELECT * FROM keywords_list WHERE configuration_id = ".$this->db->escape($config)." AND  keyword=".$this->db->escape($data['keyword'])."";
        $result    	=   $this->db->query($keywords)->result_array();
        if(isset($result[0]) && !empty($result[0])){
        	return true;
        } else {
        	return false;
        }
    }
    
    public function modify_keyword($data, $config='1'){
        if($data['id'] == '0'){
            $insert_email   =   "INSERT INTO keywords_list VALUES(NULL,".$this->db->escape($config).",".$this->db->escape($data['keyword']).",'1','0',NOW(), NOW())";
            $this->db->query($insert_email);
            return $this->db->insert_id();
        } else {
            $update_email   =   "UPDATE keywords_list 
                                 SET keyword=".$this->db->escape($data['keyword'])."
                                 WHERE id = ".$this->db->escape($data['id'])."
                                 AND configuration_id = ".$this->db->escape($config)."
                                ";
            $this->db->query($update_email);
            $count  =   $this->db->affected_rows();
            if($count == 1)
                return true;
            else
                return false;
            
        }
    }
    
    public function delete_keyword($data){
        $delete_email_query =   "DELETE FROM keywords_list WHERE id  = ".$this->db->escape($data['id'])."";
        $this->db->query($delete_email_query);
        $count  =   $this->db->affected_rows();
        if($count == 1)
            return true;
        else
            return false;
    }

}

?>