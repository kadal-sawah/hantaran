<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelLogin extends CI_Model
{

    public function CekLogin($data)
    {
        try {

            $CekLogin = $this->db->select('admin.*')
                ->from('admin')
                ->where(['username' => $data['username']])
                ->get();
            if ($CekLogin->num_rows() <= 0)
                throw new Exception('Username atau password salah');
            $source = $CekLogin->row();
            if (password_verify($data['password'], $source->password) == false)
                throw new Exception('Password salah');

            if ($source->is_aktif == '0')
                throw new Exception("Akun anda di nonaktifkan, silahkan hubungi admin");
            // ambil id_admin
            return  [
                'id'        => $source->id,
                'username'  => $source->username,
                'nama_user' => $source->nama_user,
                'level'     => $source->level
            ];

            // $this->library->printr($message/);
        } catch (Exception $Error) {
            throw new Exception($Error->getMessage());
        } catch (Throwable $Error) {
            throw new Exception($Error->getMessage());
        }
    }
}
