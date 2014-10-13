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
        if ($request_url) {
            $agent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36';
            $options = array(
                CURLOPT_RETURNTRANSFER => true, // return web page
                CURLOPT_HEADER => TRUE, // don't return headers
                CURLOPT_FOLLOWLOCATION => true, // follow redirects
                CURLOPT_ENCODING => "", // handle all encodings
                CURLOPT_USERAGENT => $agent, // who am i
                CURLOPT_AUTOREFERER => true, // set referer on redirect
                CURLOPT_CONNECTTIMEOUT => 120, // timeout on connect
                CURLOPT_TIMEOUT => 120, // timeout on response
                CURLOPT_MAXREDIRS => 10, // stop after 10 redirects
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => Array("Content-Type: text/xml"),
                CURLOPT_FORBID_REUSE => true,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_FRESH_CONNECT => true
            );

            $ch = curl_init($request_url);
            curl_setopt_array($ch, $options);
            $content = curl_exec($ch);
            $err = curl_errno($ch);
            $errmsg = curl_error($ch);
            $header = curl_getinfo($ch);

            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $header['errno'] = $err;
            $header['errmsg'] = $errmsg;
            $header['content'] = $content;

            /* 200 Response! */
            if ($status == 200) {
                $this->load->helper('phpQuery');

                $doc = phpQuery::newDocument($content);

                // Create array to hold stats
                $stats = array();

                $doc['.tableC .table1 div.cent']->find('table tr:last')->remove();

                // Add stats from page to array
                // Notice the CSS style selector
                foreach ($doc['.tableC .table1 div.cent'] as $td) {
                    $href = pq($td)->find('a');
                    if (isset($href) && $href != '') {
                        foreach ($href as $a) {
                            $newhref = 'http://www.globaltenders.com/' . pq($a)->attr('href');
                            pq($a)->attr('href', $newhref);
                        }
                    }
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

    /**
     * @Access		:	public
     * @Function	:	sendMail
     * @Description	:	Sends email to users
     * @Param		:	$to , $sub, $message
     */
    public function sendMail($to, $sub, $message) {
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => FROM_EMAIL_ADDRESS,
            'smtp_pass' => FROM_EMAIL_PASSWORD,
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from(FROM_EMAIL_ADDRESS);
        $this->email->to($to);
        $this->email->subject($sub);
        $this->email->message($message);
        if ($this->email->send()) {
            // Do nothing. Email is sent.
        } else {
            show_error($this->email->print_debugger());
        }
    }

}
