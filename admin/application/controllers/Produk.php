<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends CI_Controller
{

    use Field;
    use Column;

    function __construct()
    {
        parent::__construct();

        $this->load->library('grocery_CRUD');
        $this->load->model('Auth');
    }
    public function index()
    {
        $crud = $this->grocery_crud;
        $crud->set_table('produk');
        $crud->set_theme('datatables');


        $crud->columns('FOTO PRODUK', 'kode_produk', 'nama_produk', 'id_jenis', 'harga', 'stok');
        $crud->display_as('nama_produk', 'NAMA PRODUK');
        $crud->display_as('id_jenis', 'JENIS PRODUK');
        $crud->display_as('harga', 'HARGA');
        $crud->display_as('stok', 'STOK');
        $crud->display_as('is_aktif', 'PUBLISH');
        $crud->display_as('slug', 'AKSES URL');
        $crud->display_as('kode_produk', 'KODE PRODUK');

        $crud->set_relation('id_jenis', 'jenis_produk', 'nama_jenis');

        $crud->callback_column('FOTO PRODUK', array($this, '_column_cover'));
        $crud->callback_column('harga', array($this, '_column_harga'));

        $crud->add_fields('kode_produk', 'nama_produk', 'slug', 'id_jenis', 'harga', 'stok', 'deskripsi', 'FOTO PRODUK');
        $crud->edit_fields('nama_produk', 'id_jenis', 'harga', 'stok', 'deskripsi', 'FOTO PRODUK', 'is_aktif');

        $crud->callback_add_field('deskripsi', array($this, '_field_deskripsi'));
        $crud->callback_add_field('FOTO PRODUK', array($this, '_field_upload_produk'));

        $crud->callback_edit_field('deskripsi', array($this, '_field_edit_deskripsi'));
        $crud->callback_edit_field('FOTO PRODUK', array($this, '_field_edit_upload_produk'));
        $crud->callback_edit_field('is_aktif', array($this, '_field_edit_is_aktif'));


        $crud->callback_insert(array($this, '_store_produk'));
        $crud->callback_update(array($this, '_edit_produk'));

        $crud->callback_delete(array($this, '_delete_produk'));

        $crud->set_field_upload('logo', 'assets/uploads/files/produk');
        $crud->order_by('nama_produk', 'asc');
        $crud->unset_clone();
        $crud->unset_read();
        $output = $crud->render();
        $data['crud'] = $output;
        $data['page'] = 'Produk/Data';
        // $this->library->printr($data);
        $this->load->view('Templates/Templates', $data);
    }



    public function _edit_produk($data, $idProduk)
    {
        try {
            unset($data['foto']);
            $this->db->where('id', $idProduk);
            $this->db->update('produk', $data);

            // upload foto
            $this->uploadFoto($idProduk, $_FILES);
        } catch (Exception $error) {
            echo $error->getMessage();
            exit(1);
        }
    }
    public function _store_produk($data)
    {
        try {
            // insert prodyj
            $data['is_aktif'] = '1';
            $this->db->insert('produk', $data);

            $idProduk = $this->db->insert_id();

            // upload foto
            $this->uploadFoto($idProduk, $_FILES);
        } catch (Exception $error) {
            echo $error->getMessage();
            exit(1);
        }
    }

    private function uploadFoto($idProduk, $file)
    {
        // inserty detail gambar
        $foto = $file['foto'];

        $length = count($foto['name']);

        $error = 0;

        for ($x = 0; $x < $length; $x++) {

            // kalo ada yang error
            if ($foto['error'][$x] != 0) {
                $error = 1;
                continue;
            }

            // file name
            $fileName = sha1(time() + ($x + 1) . 'file-hantaran') . '.' . $this->library->MimeToExt($foto['type'][$x]);

            // cek ekstensi
            $this->AllowExtension($foto['type'][$x]);

            // set data untuk detail_gambar
            $dataGambar = [
                'id_produk' => $idProduk,
                'gambar'    => $fileName
            ];


            // insert dambar
            $this->db->insert('detail_gambar', $dataGambar);

            // pindahkan file
            move_uploaded_file($foto['tmp_name'][$x], "./assets/uploads/files/produk/{$fileName}");
        }
    }

    public function _delete_produk($idProduk)
    {

        // delete detail gambarnya juga
        $DetailGambar = $this->db->get_where('detail_gambar', ['id_produk' => $idProduk]);
        if ($DetailGambar->num_rows() > 0) {
            $source = $DetailGambar->result_array();
            $dir = './assets/uploads/files/produk/';
            foreach ($source as $list) :

                // kalo ada filenya, maka hapus
                if (file_exists($dir . $list['gambar']))
                    unlink($dir . $list['gambar']);
            endforeach;

            // hapus data
            $this->db->where('id_produk', $idProduk);
            $this->db->delete('detail_gambar');
        }

        // delete produk
        $this->db->where('id', $idProduk);
        $this->db->delete('produk');
    }

    public function deleteGambar($id)
    {
        try {
            $detailGambar = $this->db->get_where('detail_gambar', ['id' => $id]);

            // cek row nya
            if ($detailGambar->num_rows() <= 0)
                throw new Exception("row tidak ditemukan");


            $source = $detailGambar->row();
            $dir = './assets/uploads/files/produk/';

            // cek filenya ada ga
            if (!file_exists($dir . $source->gambar))
                throw new Exception("File tidak ditemukan");

            // delete gambar
            unlink($dir . $source->gambar);

            // delete row
            $this->db->where('id', $id);
            $this->db->delete('detail_gambar');

            // kembali
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        } catch (Exception $error) {
            echo "<h5>" . $error->getMessage() . "</h5>";
            echo "<a href='javascript:history.go(-1)'>< kembali</a>";
        } catch (Throwable $error) {
            echo "<h5>" . $error->getMessage() . "</h5>";
            echo "<a href='javascript:history.go(-1)'>< kembali</a>";
        }
    }


    private function AllowExtension($mimeType)
    {
        $allow = ['image/jpeg', 'image/pjpeg', 'image/gif', 'image/png', 'image/x-png', 'image/jpg'];
        $cekExt = in_array($mimeType, $allow);
        if (!$cekExt)
            throw new Exception("Ekstensi file tidak didukung");


        return true;
    }
}


// untuk field
trait Field
{

    public function _field_edit_is_aktif($value, $row)
    {
        return "
        <select name='is_aktif' class='form-control'>
            <option value='1'>PUBLISH</option>
            <option value='2'>UNPUBLISH</option>
        </select>
        ";
    }
    public function _field_upload_produk()
    {
        return "<div class='file-loading'> <input id='input-b6' name='foto[]' type='file' multiple></div>";
    }
    public function _edit_field_alamat($val)
    {
        return "<textarea name='alamat' class='form-control'>{$val}</textarea>";
    }
    public function _field_deskripsi()
    {
        return "<textarea class='form-control' name='deskripsi'></textarea>";
    }

    public function _field_edit_deskripsi($value)
    {
        return "<textarea class='form-control' name='deskripsi'>{$value}</textarea>";
    }

    public function _field_edit_upload_produk($value, $idProduk)
    {
        $DetailGambar = $this->db->get_where('detail_gambar', ['id_produk' => $idProduk]);
        $img = '';
        if ($DetailGambar->num_rows() > 0) {
            $source = $DetailGambar->result_array();

            foreach ($source as $list) :
                $img .= "
                <div class='d-flex flex-column mb-3 mr-2 '>
                    <img src='" . base_url('assets/uploads/files/produk/' . $list['gambar']) . "' width='100' height='75'>
                    <a href='" . base_url('produk/delete/gambar/' . $list['id']) . "' onclick=\"return confirm('Apakah anda yakin, ingin menghapus foto ini?')\">x hapus</a>
                </div>
                ";
            endforeach;
        }

        return "
        <div class='d-flex'>
            {$img}
        </div>
        <div class='file-loading'> <input id='input-b6' name='foto[]' type='file' multiple></div>
        ";
    }
}


// untuk column
trait Column
{
    public function _column_cover($value, $row)
    {
        $DetailGambar = $this->db->get_where('detail_gambar', ['id_produk' => $row->id]);

        // kalo ada gambarnya
        if ($DetailGambar->num_rows() > 0) {
            $source = $DetailGambar->result_array();
            // $this->library->printr($source, false);
            $img = '';
            foreach ($source as $list) :
                $img .= "<img class='mr-2' src='" . (base_url('assets/uploads/files/produk/' . $list['gambar'])) . "' width=50/>";
            endforeach;
            return $img;
        }

        return "<span class='text-muted'>Belum upload</span>";
    }

    public function _column_harga($value)
    {
        return "Rp." . number_format($value, 2);
    }
}
