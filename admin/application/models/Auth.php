<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->Auth();
    }

    public function Auth()
    {
        try {
            $this->load->model('Credential', 'credential');
            $credential = $this->credential->cekCredential();
            if (!$credential)
                throw new Exception("Anda tidak diizinkan mengakses halaman ini");

            return true;
        } catch (Exception $Error) {
            $this->session->set_flashdata('pesan', "<script>pesan('" . ($Error->getMessage()) . "')</script>");
            // echo $Error->getMessage();
            header('location:' . base_url('../'));
        } catch (Throwable $Error) {
            $this->session->set_flashdata('pesan', "<script>pesan('" . ($Error->getMessage()) . "')</script>");
            header('location:' . base_url('../'));
        }
    }
}
