<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{


    public function index()
    {
        $jenis = $this->db->get_where('jenis_produk')->result_array();
        $data = [
            'content'  => 'Dashboard',
            'jenis'    => $jenis
        ];

        $this->load->view('Templates/Templates', $data);
    }

    public function kategori($slugKategori)
    {
        try {
            $kategori = $this->db->get_where('jenis_produk', ['slug' => strtolower($slugKategori)]);
            if ($kategori->num_rows() <= 0)
                throw new Exception("Produk tidak tersedia");


            $source = $kategori->row();
            $produk = $this->db->get_where('produk', ['id_jenis' => $source->id]);
            if ($produk->num_rows() <= 0)
                throw new Exception('Produk belum tersedia');

            $resultProduk = $produk->result_array();
            $x = 0;
            foreach ($resultProduk as $list) :
                $detailGambar = $this->db->select('detail_gambar.gambar')
                    ->from('detail_gambar')
                    ->where(['id_produk' => $list['id']])
                    ->get();
                if ($detailGambar->num_rows()  > 0) {
                    $resultGambar = $detailGambar->result_array();
                    $resultProduk[$x]['detail_gambar'] = array_column($resultGambar, 'gambar');
                }

                $x++;
            endforeach;
            $data = [
                'collections'  => $resultProduk,
                'count'        =>  $produk->num_rows(),
                'title'        => $source->nama_jenis,
                'status_code'  => 200
            ];
        } catch (Exception $error) {
            $data = [
                'status_code' => 400,
                'message'     => $error->getMessage()
            ];
        } finally {
            $data['content'] = 'Produk';
            // $this->library->printr($data);
            $this->load->view('Templates/Templates', $data);
        }
    }

    public function tentang()
    {
        $this->load->view('Templates/Templates', ['content' => 'TentangKami']);
    }
}
