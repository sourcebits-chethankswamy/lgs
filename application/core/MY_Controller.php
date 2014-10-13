<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('logged_in') != 1) {
            redirect('/');
        }
    }

    public function set_site($id) {
        if ($id) {
            $this->dashboard_model->set_site($id);
            $this->__load_site_config_file($id);
            return true;
        }
        return false;
    }

    public function get_site() {
        return $this->dashboard_model->get_site();
    }

    private function __load_site_config_file($id) {
        switch ($id) {
            case '1':
                $this->config->load('sites_config/global_tenders');
                break;
            case '2':
                $this->config->load('sites_config/abc_tenders');
                break;
            case '3':
                $this->config->load('sites_config/xyz_tenders');
                break;

            default:
                $this->config->load('sites_config/global_tenders');
                break;
        }
    }

    public function send_request($request_url) {
        echo $request_url.'<br />';
        if ($request_url) {
            /* cURL Resource */
            $ch = curl_init();

            /* Set URL */
            curl_setopt($ch, CURLOPT_URL, $request_url);

            /* Tell cURL to return the output */
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            /* Tell cURL NOT to return the headers */
            curl_setopt($ch, CURLOPT_HEADER, false);

            /* Execute cURL, Return Data */
            $data = curl_exec($ch);
            print_r($data);
            exit;
            /* Check HTTP Code */
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            /* Close cURL Resource */
            curl_close($ch);

            /* 200 Response! */
            if ($status == 200) {
                $this->load->helper('phpQuery');
                
                $doc = phpQuery::newDocument($data);

                // Create array to hold stats
                $stats = array();

                // Add stats from page to array
                // Notice the CSS style selector
                foreach ($doc['.tableC .table1 div.cent'] as $td) {
                    $stats[] = pq($td)->html();
                }

                if (isset($stats[0])) {
                    return $stats[0];
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
