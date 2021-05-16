<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // session_destroy();
        // $this->library->printr($_SESSION);
        $this->load->model('ModelLogin', 'login');
        // $this->load->model('Auth');
    }

    public function index()
    {
        // echo password_hash("123", PASSWORD_BCRYPT);
        $this->load->view('Login');
    }

    public function Store()
    {
        try {
            // set data 
            $data = [
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
            ];

            // kalau username kosong
            if (empty($data['username']))
                throw new Exception('Kolom username tidak boleh kosong');

            // kalau password kosong
            if (empty($data['password']))
                throw new Exception('Kolom password tidak boleh kosong');

            // Cek login 
            $CekLogin = $this->login->CekLogin($data);

            // kalau lulus validasi set token & insert ke tabel token login
            $this->credential->set_userdata('id', $CekLogin['id']);
            $this->credential->set_userdata('nama_user', $CekLogin['nama_user']);

            // set message flashdata
            $this->session->set_flashdata('pesan', "<script>pesan_sukses('Selamat datang " . $CekLogin['nama_user'] . "')</script>");
            redirect('dashboard');
        } catch (Exception $Error) {
            $this->session->set_flashdata('pesan', "<script>pesan_warning('" . ($Error->getmessage()) . "')</script>");
            redirect('login');
        } catch (Throwable $Error) {
            $this->session->set_flashdata('pesan', "<script>pesan_warning('Throwable " . ($Error->getmessage()) . "')</script>");
            redirect('login');
        }
    }

    public function Logout()
    {
        session_destroy();
        redirect('login');
    }
}
