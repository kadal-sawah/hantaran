<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Credential extends CI_Model
{
    private $salt = true;

    public function __construct()
    {
        $this->TextSalt = '';
        if ($this->salt == true)
            $this->TextSalt = sha1('adm-hantaran') . '_';
    }

    public function cekCredential()
    {
        if (empty($this->userdata('id')) && empty($this->userdata('nama_user')))
            return false;

        $idAdmin = $this->userdata('id');

        $cek = $this->db->get_where('admin', ['id' => $idAdmin])->num_rows();

        if ($cek <= 0)

            return false;

        // kalo lulus validasi
        return true;
    }

    public function set_userdata($Name, $Value = null)
    {
        $this->session->set_userdata($this->TextSalt . $Name, $Value);
    }

    public function userdata($Name)
    {
        return $this->session->userdata($this->TextSalt . $Name);
    }

    public function unset_userdata($name)
    {
        unset($_SESSION[$this->TextSalt . $name]);
    }
    public function has_userdata($Name)
    {
        if ($this->userdata($Name) == null)
            return false;

        return true;
    }
}
