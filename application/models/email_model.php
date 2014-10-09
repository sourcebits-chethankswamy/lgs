<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @File : email_model Model
 * @Class : Email
 * @Description: This class file holds all the user related operations.
 * @Created By: Himanshu Arora
 */
class Email_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function get_emails($config = '1'){
        $email_list     =   "SELECT * FROM emails_list WHERE configuration_id = ".$this->db->escape($config)."";
        $result_set     =   $this->db->query($email_list)->result_array();
        return $result_set;
    }
    
    public function modify_email($data, $config='1'){
        if($data['id'] == '0'){
            $insert_email   =   "INSERT INTO emails_list VALUES(".$this->db->escape($config).",".$this->db->escape($data['email']).",'1','0',NOW(), NOW())";
            $this->db->query($insert_email);
            return array('error'=> $this->db->insert_id(), 'type');
        } else {
            $update_email   =   "UPDATE emails_list 
                                 SET email=".$this->db->escape($data['email'])."
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
    
    public function delete_email($data){
        $delete_email_query =   "DELETE FROM emails_list WHERE id  = ".$this->db->escape($data['id'])."";
        $this->db->query($update_email);
        $count  =   $this->db->affected_rows();
    }

}

?>