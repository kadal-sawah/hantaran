<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Profil extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Auth');
    }


    public function ProfilSaya()
    {
        try {
            $user = $this->library->SessionData();

            $getProfil = $this->db->get_where('admin', ['id' => $user['id']]);
            if ($getProfil->num_rows() <= 0)
                throw new Exception("Akun tidak diketahui");


            $source = $getProfil->row();

            $response = [
                'status_code' => 200,
                'profil'      => $source,
                'js'          => [base_url('assets/js/profilsaya.js')]
            ];
        } catch (Exception $error) {
            $response = [
                'status_code' => 400,
                'message'     => $error->getMessage()
            ];
        } catch (Throwable $error) {
            $response = [
                'status_code' => 400,
                'message'     => $error->getMessage()
            ];
        } finally {
            $response['page'] = 'ProfilSaya';
            // $this->library->printr($user);
            $this->load->view('Templates/Templates', $response);
        }
    }

    public function StoreProfilSaya()
    {
        try {
            $user = $this->library->SessionData();

            $input = $this->input->post();

            $allowAdmin = [
                'username'  => $input['username'],
                'nama_user' => $input['nama_user'],
            ];

            if (!empty($input['password']))
                $allowAdmin['password'] = password_hash($input['password'], PASSWORD_BCRYPT);

            $this->db->where('id', $user['id']);
            $this->db->update('admin', $allowAdmin);


            $response = [
                'status_code'    => 200,
                'message'        => 'Profil telah diperbarui',
                'action'         => base_url('profil/saya')
            ];

            $this->session->set_flashdata('pesan', "<script>pesan('" . ($response['message']) . "')</script>");
        } catch (Exception $error) {
            $response = [
                'status_code'    => 400,
                'message'        => $error->getMessage()
            ];
        } catch (Throwable $error) {
            $response = [
                'status_code' => 400,
                'message'     => $error->getMessage()
            ];
        } finally {
            echo json_encode($response);
        }
    }
    public function index()
    {

        $profil = $this->db->get_where('profil')->row();

        $data['profil'] = $profil;
        $data['page'] = 'Profil';
        $data['js'] = [base_url('assets/js/profil.js')];
        $this->load->view('Templates/Templates', $data);
    }

    public function Store()
    {
        try {
            $input = $this->input->post();

            $data = [
                'email'     => $input['email'],
                'whatsapp'  => $input['whatsapp'],
                'alamat'    => $input['alamat'],
            ];

            // $this->library->printr($_POST);
            $this->db->update('profil', $data);

            $response = [
                'status_code' => 200,
                'message'     => 'profil telah diperbarui',
            ];
        } catch (Exception $error) {
            $response = [
                'status_code' => 400,
                'message'     => $error->getMessage()
            ];
        } catch (Throwable $error) {
            $response = [
                'status_code' => 400,
                'message'     => $error->getMessage()
            ];
        } finally {
            $response['action'] = base_url('profil');
            echo json_encode($response);
        }
    }

    public function updateLogo()
    {
        try {
            $config['upload_path']          = './assets/img/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 3000;
            $config['max_width']            = 1024;
            $config['max_height']           = 768;
            $config['file_name']            = sha1(time()) . '_' . $_FILES['logo']['name'];
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('logo'))
                throw new Exception($this->upload->display_errors());

            // hapus logo sebelumnya
            $profil = $this->db->get_where('profil');

            // cek profil
            if ($profil->num_rows() <= 0)
                throw new Exception('profil perusahaan tidak ditemukan');

            $source = $profil->row();

            $dir = './assets/img/';

            // cek filenya ada
            if (file_exists($dir . $source->logo))
                unlink($dir . $source->logo);

            // update logo
            $this->db->update('profil', ['logo' => $config['file_name']]);

            $response = [
                'status_code' => 200,
                'message'     => 'logo telah di perbarui',
                'action'      => base_url('profil')
            ];
        } catch (Exception $error) {

            $response = [
                'status_code' => 400,
                'message'     => $error->getMessage()
            ];
        } catch (Throwable $error) {
            $response = [
                'status_code' => 400,
                'message'     => $error->getMessage()
            ];
        } finally {
            echo json_encode($response);
        }
    }
}
