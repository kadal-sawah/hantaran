<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{
    use dataTable;
    use cart;

    function __construct()
    {
        parent::__construct();
        $this->load->library('grocery_CRUD');
        $this->load->model('Auth');
    }


    public function index()
    {
        $crud = $this->grocery_crud;
        $crud->set_table('transaksi');
        $crud->set_theme('datatables');


        $crud->columns('no_invoice', 'nama_pelanggan', 'telepon_wa', 'status_pengiriman', 'total_harga', 'created_at');
        $crud->display_as('no_invoice', 'NO.INV');
        $crud->display_as('nama_pelanggan', 'NAMA PELANGGAN');
        $crud->display_as('telepon_wa', 'TELEPON');
        $crud->display_as('status_pengiriman', 'PENGIRIMAN');
        $crud->display_as('total_harga', 'TOTAL');
        $crud->display_as('created_at', 'TGL TRANSAKSI');

        $crud->callback_column('AKSI', array($this, '_column_aksi'));
        $crud->callback_column('total_harga', array($this, '_column_total'));
        $crud->callback_column('created_at', array($this, '_column_tgl_transaksi'));
        $crud->callback_column('telepon_wa', array($this, '_column_telepon_wa'));
        $crud->callback_column('no_invoice', array($this, '_column_no_invoice'));

        $crud->order_by('created_at', 'desc');

        $crud->add_action('Detail Transaksi', '', 'transaksi/detail', 'ui-icon-arrow-4-diag no-border');

        $crud->unset_clone();
        $crud->unset_read();
        $crud->unset_edit();
        $crud->unset_add();
        $crud->unset_delete();

        $output = $crud->render();
        $data['crud'] = $output;
        $data['page'] = 'Transaksi/Data';
        // $this->library->printr($data);
        $this->load->view('Templates/Templates', $data);
    }

    public function detailTransaksi($idTransaksi)
    {
        try {
            $readTransaksi = $this->db->get_where('transaksi', ['id' => $idTransaksi]);
            $readDetail = $this->db->select('detail_transaksi.*, 
                                             produk.nama_produk,
                                             produk.kode_produk,
                                             jenis_produk.nama_jenis')
                ->from('detail_transaksi')
                ->join('produk', 'produk.id = detail_transaksi.id_produk', 'LEFT')
                ->join('jenis_produk', 'produk.id_jenis = jenis_produk.id', 'LEFT')
                ->where(['detail_transaksi.id_transaksi' => $idTransaksi])
                ->get();

            if ($readTransaksi->num_rows() <= 0)
                throw new Exception("transaksi tidak ditemukan");

            if ($readDetail->num_rows() <= 0)
                throw new Exception("detail transaksi tidak ditemukan");


            $sourceDetail = $readDetail->result_array();
            $x = 0;
            foreach ($sourceDetail as $list) :
                $detailGambar = $this->db->get_where('detail_gambar', ['id_produk' => $list['id_produk']]);
                $dataGambar = '';

                if ($detailGambar->num_rows() > 0)
                    $dataGambar = $detailGambar->row()->gambar;


                $sourceDetail[$x++]['foto'] = $dataGambar;
            endforeach;
            $data = [
                'transaksi'             => $readTransaksi->row(),
                'detailTransaksi'       => $sourceDetail,
                'count_detailTransaksi' => $readDetail->num_rows(),
                'count_transaksii'      => $readTransaksi->num_rows(),

                'status_code'           => 200

            ];
        } catch (Exception $error) {
            $data = [
                'status_code' => 400,
                'message'     => $error->getMessage()
            ];
        } catch (Throwable $error) {
            $data = [
                'status_code' => 400,
                'message'     => $error->getMessage()
            ];
        } finally {
            $data['page'] = 'Transaksi/Detail';

            // $this->library->printr($data);
            $this->load->view('Templates/Templates', $data);
        }
    }

    public function _column_no_invoice($value)
    {
        return "<div class='text-center text-md-1 fweight-600'>{$value}</div>";
    }

    public function _column_telepon_wa($value)
    {
        return $value == null ? "<span class='text-muted'>tidak diisi</span>" : $value;
    }

    public function _column_tgl_transaksi($value)
    {
        return $this->library->TanggalToText($value);
    }

    public function _column_total($value, $row)
    {
        $biayaLain = $row->biaya_lain;
        $total = $value;
        if ($biayaLain != null)
            $total += $biayaLain;

        return "Rp." . number_format($total, 0, '.', '.');
    }

    public function Buat()
    {
        $data = [
            'status_code' => 200,

            'css'         => [
                'https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css',
                base_url('assets/css/GridView.css')
            ],
            'js'          => [
                'https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js',
                'https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js',
                base_url('assets/js/Transaksi.js')
            ],
            'page'        => 'Transaksi/Buat',
            'fiturPage'   => "<div id='showSidebar' class='text-md-1 hover-pointer'><i class='lni lni-shopping-basket icon-primary'></i> Keranjang</div>"
        ];
        $this->load->view('Templates/Templates', $data);
    }

    public function Sukses()
    {
        $this->load->view('Templates/Templates', ['page' => 'Transaksi/SuksesCheckout']);
    }

    public function getDataTable()
    {
        try {

            $input = $this->input->get();

            $q = null;

            // kalo ada search
            if (@isset($input['search']['value']))
                $q = $input['search']['value'];
            // tampil semua produk
            $produk = $this->db->select('produk.*, jenis_produk.nama_jenis')
                ->from('produk')
                ->where([
                    'is_aktif' => '1',
                ])
                ->join('jenis_produk', 'jenis_produk.id = produk.id_jenis', 'LEFT');


            // kaloa $q tidak kosong
            if ($q != null)
                $produk = $this->db->like('nama_produk', $q);

            // get table
            $produk = $this->db->get();

            $count = $produk->num_rows();

            // cek ketersediaan produk
            if ($count <= 0)
                throw new Exception("produk belum tersedia");

            $resultProduk = $produk->result_array();
            $resultProduk = $this->detailGambar($resultProduk);
            $response = [
                'draw'              => @$_GET['draw'] ?? 1,
                'recordsTotal'      => $this->countAll(),
                'recordsFiltered'   => $count,
                'data'              => $resultProduk
            ];
        } catch (Exception $error) {
            $response = [
                'draw'              => @$_GET['draw'] ?? 1,
                'recordsTotal'      => 0,
                'recordsFiltered'   => 0,
                'data'              => [],
                'message'           => $error->getMessage()
            ];
        } catch (Throwable $error) {
            $response = [
                'draw'              => @$_GET['draw'] ?? 1,
                'recordsTotal'      => 0,
                'recordsFiltered'   => 0,
                'data'              => [],
                'message'           => $error->getMessage()
            ];
        } finally {
            echo json_encode($response);
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

    public function AddCart()
    {
        try {
            $input = $this->input->post();

            $cekProduk = $this->db->select('produk.*, jenis_produk.nama_jenis')
                ->from('produk')
                ->join('jenis_produk', 'jenis_produk.id = produk.id_jenis', 'LEFT')
                ->where(['produk.id' => $input['id']])
                ->get();

            // cek produk
            if ($cekProduk->num_rows() <= 0)
                throw new Exception("produk tidak ditemukan");

            $source = $cekProduk->row();

            $items = @$_SESSION['items'];

            $qtySession = $items[$source->id]['qty'] ?? 0;


            // kalo itemnya belum ada, maka masukin ke keranjang
            if (!isset($items[$source->id])) {

                // detail_gambar
                $detailGambar = $this->db->get_where('detail_gambar', ['id_produk' => $source->id]);

                $dataGambar = null;

                // cek data gambar
                if ($detailGambar->num_rows() > 0)
                    $dataGambar = $detailGambar->row()->gambar;


                $items[$source->id] = [
                    'id'            => $source->id,
                    'nama_produk'   => $source->nama_produk,
                    'harga'         => $source->harga,
                    'qty'           => 1,
                    'nama_jenis'    => $source->nama_jenis,
                    'foto'          => $dataGambar
                ];
            }
            // kalo udah pernah di masukin, maka tambah qtynya aja
            else {
                // cek qty nya
                if (@$qtySession >= $source->stok)
                    throw new Exception("pembelian {$source->nama_produk} telah mencapai maksimal");

                @$items[$source->id]['qty'] += 1;
            }

            $_SESSION['items'] = $items;
            // $this->library->printr($_SESSION['items']);
            $response = [
                'status_code' => 200,
                'cart'        => $_SESSION['items']
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

    public function HapusCart()
    {
        try {
            $input = $this->input->post();

            $cekProduk = $this->db->get_where('produk', ['produk.id' => $input['id']]);
            // cek produk
            if ($cekProduk->num_rows() <= 0)
                throw new Exception("produk tidak ditemukan");

            $source = $cekProduk->row();
            // kalo ditemukan, maka hapus cart
            unset($_SESSION['items'][$source->id]);
            $response = [
                'status_code' => 200,
                'cart'        => $_SESSION['items']
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

    public function ViewCart()
    {
        $this->load->view('Transaksi/ViewCart');
    }


    public function nextDataDiri()
    {
        try {
            $items = $_SESSION['items'] ?? [];

            // cek keranjang belanja
            if (count($items) <= 0)
                throw new Exception('keranjang belanja kosong');
            // set response
            $response = [
                'status_code' => 200,
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
    public function Checkout()
    {
        try {
            $items = $_SESSION['items'] ?? [];

            $input = $this->input->post();
            // $this->library->printr($input);
            // cek keranjang belanja
            if (count($items) <= 0)
                throw new Exception('keranjang belanja kosong');

            $noInvoice = date('ym') . rand(1000, 10000);

            // data transaksi
            $allowTransaksi = [
                'no_invoice'        => $noInvoice,
                'total_harga'       => $this->totalHarga(),
                'status_transaksi'  => 'ACC',
                'id_user'           => null,
                'nama_pelanggan'    => $input['nama_pelanggan'],
                'alamat_lengkap'    => $input['alamat_lengkap'],
                'telepon_wa'        => $input['telpon_wa'] ?? '',
                'status_pengiriman' => $input['status_pengiriman'],
                'biaya_lain'        => $input['biaya_lain'] ?? ''
            ];


            // kalo upload bukti transaksi
            if (isset($_FILES['bukti_tf'])) {

                $filename = sha1(time()) . '_' . $_FILES['bukti_tf']['name'];

                // config upload
                $config['upload_path']          = './assets/uploads/files/bukti_tf';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 3000;
                $config['file_name']            = $filename;

                $this->load->library('upload', $config);

                // upload file
                if (!$this->upload->do_upload('bukti_tf'))
                    throw new Exception($this->upload->display_errors());

                // kalo lulus validasi, maka masukan ke $allowTransaksi
                $allowTransaksi['bukti_tf'] = $filename;
            }

            // data detail transaksi
            $allowDetailTransaksi = [];
            // insert transaksi
            $this->db->insert('transaksi', $allowTransaksi);

            $idTransaksi = $this->db->insert_id();

            // set data allowdetailTransaksi
            $allowDetailTransaksi = [];

            // insert detail transaksi
            foreach ($items as $key => $item) :
                $allowDetailTransaksi[] = [
                    'id_transaksi'      => $idTransaksi,
                    'id_produk'         => $item['id'],
                    'qty'               => $item['qty'],
                    'harga'             => $item['harga']
                ];
            endforeach;

            // insert detail_transaksi 
            $this->db->insert_batch('detail_transaksi', $allowDetailTransaksi);

            // unset session
            unset($_SESSION['items']);

            // set response
            $response = [
                'status_code' => 200,
                'action'      => base_url('transaksi/sukses')
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
trait cart
{
    private function totalHarga()
    {
        $items = $_SESSION['items'];
        $totalHarga = 0;
        foreach ($items as $key => $list) :
            $totalHarga += $list['harga'] * $list['qty'];
        endforeach;

        return $totalHarga;
    }
}

trait dataTable
{

    private $table = 'produk';
    function countAll()
    {
        return $this->db->get($this->table)->num_rows();
    }
}
