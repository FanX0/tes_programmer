<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_model extends CI_Model {
    public function get_all_produk() {
        $this->db->select('produk.id_produk, produk.nama_produk, produk.harga, kategori.nama_kategori, status.nama_status');
        $this->db->from('produk');
        $this->db->join('kategori', 'produk.kategori_id = kategori.id_kategori');
        $this->db->join('status', 'produk.status_id = status.id_status');
		$this->db->where('status.nama_status', 'bisa dijual');
        return $this->db->get()->result_array();
    }
}
