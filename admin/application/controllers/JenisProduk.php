<?php
defined('BASEPATH') or exit('No direct script access allowed');

class JenisProduk extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('grocery_CRUD');
        $this->load->model('Auth');
    }

    public function index()
    {

        $crud = $this->grocery_crud;
        $crud->set_theme('datatables');
        $crud->set_table('jenis_produk');
        $crud->display_as('cover', 'FOTO');
        $crud->display_as('nama_jenis', 'JENIS');

        // $crud->display_as('id_jurusan', 'JURUSAN');
        $crud->columns('cover', 'nama_jenis');

        $crud->required_fields('cover', 'nama_jenis');
        $crud->set_field_upload('cover', 'assets/uploads/files/jenis');

        $crud->callback_column('cover', array($this, '_column_cover'));
        $crud->unset_read();
        $crud->unset_clone();

        $output = $crud->render();
        $data['crud'] = $output;
        $data['page'] = 'JenisProduk/Data';
        // $this->library->printr($data);
        $this->load->view('Templates/Templates', $data);
    }

    public function _column_cover($value)
    {

        $dir = 'assets/uploads/files/jenis/';
        return "<img src='" . base_url($dir . $value) . "' width='125' height='110'/>";
    }
}
