<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @File : dashboard.php Controller
 * @Class : Dashboard
 * @Description: This class file holds the operations of user settings, configurations etc.
 * Created By: Himanshu Arora
 */
class Site extends MY_Controller {

    public function __construct() {
        parent::__construct();
        //$this->load->library('session');

        $this->load->model('site_model');
        $this->load->model('dashboard_model');
        $this->load->model('keywords_model');
        $this->load->model('email_model');
    }

    public function index() {
        $data['title'] = 'LGS - Sites list';

        $data['sites_list'] = $this->site_model->get_sites_list();

        $this->load->view('header');
        $this->load->view('navigation_header');
        $this->load->view("site/list", $data);
        $this->load->view('navigation_footer');
        $this->load->view('footer');
    }

    public function add() {
        $data['title'] = 'LGS - Add New Site';

        $this->load->view('header');
        $this->load->view('navigation_header');
        $this->load->view("site/add", $data);
        $this->load->view('navigation_footer');
        $this->load->view('footer');
    }

    public function create_site() {
        if (isset($_POST)) {
            $site_name = $_POST['site_name'];

            $site_id = $this->site_model->create_site($site_name);
            if ($site_id) {
                foreach ($_POST['field_name'] as $key => $value) {
                    $field_value = $_POST['field_type'];
                    $this->site_model->insert_site($site_id, $value, $field_value[$key]);
                }
                $this->add_field_values($site_id);
            } else {
                $message = 'Error while creating site, please try again';
                $this->session->set_flashdata("message", $message);

                redirect('site/add');
            }
        } else {
            $message = 'Invalid data';
            $this->session->set_flashdata("message", $message);

            redirect('site/add');
        }
    }

    public function add_field_values($site_id) {
        if ($site_id) {
            $data['title'] = 'LGS - Add field values';

            $data['fields_list'] = $this->site_model->get_fields($site_id);
            $data['site_id'] = $site_id;

            $this->load->view('header');
            $this->load->view('navigation_header');
            $this->load->view("site/field_values_add", $data);
            $this->load->view('navigation_footer');
            $this->load->view('footer');
        } else {
            $message = 'Invalid data';
            $this->session->set_flashdata("message", $message);

            redirect('site/add');
        }
    }

    public function insert_field_value() {
        //print_r($_POST);
        if (isset($_POST)) {
            $site_id = $_POST['site_id'];

            if ($site_id) {
                foreach ($_POST['field_value']['name'] as $key => $value) {
                    $value_chunks = explode("::", $value);
                    foreach ($value_chunks as $vkey => $vval) {
                        $field_value = $_POST['field_value']['value'][$key];
                        $field_value_chunks = explode("::", $field_value);

                        $this->site_model->insert_field_value($key, $vval, $field_value_chunks[$vkey]);
                    }
                }
                $message = 'Field values saved!!';
                $this->session->set_flashdata("message", $message);

                redirect('site');
            } else {
                $message = 'Error while inserting field value, please try again';
                $this->session->set_flashdata("message", $message);

                redirect('site/add');
            }
        } else {
            $message = 'Invalid data';
            $this->session->set_flashdata("message", $message);

            redirect('site/add');
        }
    }

    public function edit_field_values($site_id) {
        if ($site_id) {
            $data['title'] = 'LGS - Update field values';
            $data['site_id'] = $site_id;
            $data['fields_list'] = $this->site_model->get_field_values($site_id);

            $this->load->view('header');
            $this->load->view('navigation_header');
            $this->load->view("site/field_values_edit", $data);
            $this->load->view('navigation_footer');
            $this->load->view('footer');
        } else {
            $message = 'Invalid data';
            $this->session->set_flashdata("message", $message);

            redirect('site');
        }
    }

    public function update_field_value() {
        //print_r($_POST);exit;
        if (isset($_POST)) {
            $site_id = $_POST['site_id'];

            if ($site_id) {
                foreach ($_POST['field_value']['name'] as $key => $value) {
                    $value_chunks = explode("::", $value);
                    foreach ($value_chunks as $vkey => $vval) {
                        $field_value = $_POST['field_value']['value'][$key];
                        $field_value_chunks = explode("::", $field_value);

                        $field_value_id = $_POST['field_value']['field_value_id'][$key];
                        $field_value_id_chunks = explode("::", $field_value_id);

                        $this->site_model->update_field_value($key, $vval, $field_value_chunks[$vkey], $field_value_id_chunks[$vkey]);
                    }
                }
                $message = 'Field values saved!!';
                $this->session->set_flashdata("message", $message);

                redirect('site');
            } else {
                $message = 'Error while updating field value, please try again';
                $this->session->set_flashdata("message", $message);

                redirect('site/edit/' . $site_id);
            }
        } else {
            $message = 'Invalid data';
            $this->session->set_flashdata("message", $message);

            redirect('site');
        }
    }

    public function edit($site_id) {
        if ($site_id) {
            $data['title'] = 'LGS - Edit Site';
            $data['fields_list'] = $this->site_model->get_fields($site_id);
            $data['site_detals'] = $this->site_model->get_site_details($site_id);
            $data['site_id'] = $site_id;

            $this->load->view('header');
            $this->load->view('navigation_header');
            $this->load->view("site/edit", $data);
            $this->load->view('navigation_footer');
            $this->load->view('footer');
        } else {
            $message = 'Invalid data';
            $this->session->set_flashdata("message", $message);

            redirect('site/add');
        }
    }

    public function update_site() {
        //print_r($_POST);
        if (isset($_POST)) {
            $site_name = $_POST['site_name'];
            $site_id = $_POST['site_id'];

            $this->site_model->update_site($site_name, $site_id);

            foreach ($_POST['field_name'] as $key => $value) {
                $field_value = $_POST['field_type'];
                $this->site_model->update_site_fields($key, $site_id, $value, $field_value[$key]);
            }

            $message = 'Field values saved!!';
            $this->session->set_flashdata("message", $message);

            redirect('site');
        } else {
            $message = 'Invalid data';
            $this->session->set_flashdata("message", $message);

            redirect('site');
        }
    }

    public function delete($site_id) {
        if ($site_id != '') {
            $delete = $this->site_model->delete_site($site_id);
            if ($delete) {
                $message = 'Site successfully deleted!!!';
            } else {
                $message = 'Site could be deleted, please try again';
            }
            $this->session->set_flashdata("message", $message);

            redirect('site');
        } else {
            $message = 'Invalid Data';
            $this->session->set_flashdata("message", $message);

            redirect('site');
        }
    }

    public function changestatus($site_id, $status) {
        if ($site_id != '' && $status != '') {
            $change = $this->site_model->change_status($status, $site_id);

            $active_status = ($status) ? "Active" : "In-Active";
            if ($change) {
                $message = 'Site successfully made ' . $active_status . '!!!';
            } else {
                $message = 'Could not make site ' . $active_status . ', please try again';
            }
            $this->session->set_flashdata("message", $message);

            redirect('/site');
        } else {
            $message = 'Invalid Configuration';
            $this->session->set_flashdata("message", $message);

            redirect('/site');
        }
    }

}
