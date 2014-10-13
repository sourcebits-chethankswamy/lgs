<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$config['global_url'] = "http://www.globaltenders.com/search.php";
$config['records_per_page_tests'] = 30;
$config['email_host'] = 'ssl://smtp.googlemail.com';
$config['email_port'] = 465;
$config['email_username'] = '';
$config['email_password'] = '';

$config['url_params'] = array("1" => "notice_type_new", "2" => "mfa", "3" => "sector", "4" => "region_name", 
            "5" => "competition", "9" => "day", "10" => "mon", "11" => "year", "7" => "t", "8" => "deadline");