<?php

class Logout extends CI_Controller {

    function index()
    {
        $this->session->unset_userdata('loggedinusername');
        $this->session->sess_destroy();
        redirect(BASEURL.'login');
    }
}
