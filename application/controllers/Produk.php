<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends CI_Controller
{


    public function detailProduk($slugProduk)
    {
        try {
            $produk = $this->db->get_where('produk', ['slug' => $slugProduk]);

            if ($produk->num_rows() <= 0)
                throw new Exception("Produk tidak ditemukan");

            $resultProduk = $produk->result_array();


            $resultProduk = $this->detailGambar($resultProduk);
            $data = [
                'status_code' => 200,
                'collection' => $resultProduk[0],
            ];
        } catch (Exception $error) {
            $data = [
                'status_code' => 400,
                'message'     => $error->getMessage()
            ];
        } finally {
            $data['content'] = 'DetailProduk';
            // $this->library->printr($data);
            $this->load->view('Templates/Templates', $data);
        }
    }

    public function produkKami()
    {
        try {
            $produk = $this->db->select('
                produk.*,
                jenis_produk.nama_jenis')
                ->from('produk')
                ->join('jenis_produk', 'jenis_produk.id = produk.id_jenis', 'LEFT')
                ->where(['is_aktif' => '1'])
                ->get();
            $resultProduk = $produk->result_array();

            if ($produk->num_rows() <= 0)
                throw new Exception("produk tidak tersedia");

            $resultProduk = $this->detailGambar($resultProduk);

            $data = [
                'collections' => $resultProduk,
                'status_code' => 200
            ];
            // $this->library->printr($resultProduk);
        } catch (Exception $error) {
            $data = [
                'status_code' => 400,
                'message'     => $error->getMessage()
            ];
        } finally {
            $data['content'] = 'ProdukKami';
            // $this->library->printr($data);
            $this->load->view('Templates/Templates', $data);
        }
    }

    private function detailGambar($resultProduk)
    {
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

        return $resultProduk;
    }
}
