<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Captcha extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('CI_Securimage'));
    }

    function index() {
        $this->ci_securimage->show();
        // echo "captcha";
    }

    function check() {
        $inputCode = $this->input->get('captcha');
        if ($this->ci_securimage->check($inputCode) == true) {
            echo "true";
        } else {
            echo "false";
        }
    }

}

?>