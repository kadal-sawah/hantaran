<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelLogin extends CI_Model
{

    public function CekLogin($data)
    {
        try {

            $CekLogin = $this->db->select('password,id')
                ->from('admin')
                ->where(['username' => $data['username']])
                ->get();
            if ($CekLogin->num_rows() <= 0)
                throw new Exception('Username atau password salah');
            $source = $CekLogin->row();
            if (password_verify($data['password'], $source->password) == false)
                throw new Exception('Password salah');

            // ambil id_admin
            return  [
                'id'        => $source->id,
                'nama_user' => $source->nama_user
            ];

            // $this->library->printr($message/);
        } catch (Exception $Error) {
            throw new Exception($Error->getMessage());
        } catch (Throwable $Error) {
            throw new Exception($Error->getMessage());
        }
    }
}
