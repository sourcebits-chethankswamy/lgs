<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @File : email_model Model
 * @Class : Email
 * @Description: This class file holds all the user related operations.
 * @Created By: Himanshu Arora
 */
class Email_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_emails($id = '') {
        if ($id != '') {
            $email_list = "SELECT el.email, el.id as email_id, sel.id as sel_email_id  FROM selected_emails_list sel
                            join emails_list el on el.id = sel.email_id
                            WHERE 
                            el.status = '1' and sel.configuration_id = '1'";
        } else {
            $email_list = "SELECT * FROM emails_list WHERE status = '1'";
        }
        $result_set = $this->db->query($email_list)->result_array();
        return $result_set;
    }

    public function modify_email($data, $config = '1') {
        if ($data['id'] == '0') {
            $insert_email = "INSERT INTO emails_list VALUES(NULL," . $this->db->escape($data['email']) . ",'1',NOW(), NOW())";
            $this->db->query($insert_email);
            return array('error' => $this->db->insert_id(), 'type');
        } else {
            $update_email = "UPDATE emails_list 
                                 SET email=" . $this->db->escape($data['email']) . ",updated_date = now()
                                 WHERE id = " . $this->db->escape($data['id']) . "";
            $this->db->query($update_email);
            $count = $this->db->affected_rows();
            if ($count == 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function delete_email($data) {
        $delete_email_query = "update emails_list set status = '0',updated_date = now() WHERE id  = " . $this->db->escape($data['id']) . "";
        $this->db->query($delete_email_query);
        $count = $this->db->affected_rows();
        if ($count == 1)
            return true;
        else
            return false;
    }

    public function email_check($data, $config = '1') {
        $email = "SELECT * FROM emails_list WHERE configuration_id = " . $this->db->escape($config) . " AND  email=" . $this->db->escape($data['email']) . "";
        $result = $this->db->query($email)->result_array();
        if (isset($result[0]) && !empty($result[0])) {
            return true;
        } else {
            return false;
        }
    }

}

?>