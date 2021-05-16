<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth');
    }

    public function index()
    {
        // session_destroy();
        // $this->library->printr($_SESSION);
        $this->load->view('Templates/Templates', ['page' => 'Dashboard']);
    }
}
