<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // Memuat library database
		$this->load->model('Produk_model'); // Load model
		$this->load->library('form_validation');
    }

	public function index() {
        $data['produk'] = $this->Produk_model->get_all_produk(); // Ambil data dari model
        $this->load->view('produk/produk_list', $data); // Tampilkan view dengan data
    }

	public function tambah() {
		// Aturan validasi
		$this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required', [
			'required' => 'Nama produk wajib diisi.'
		]);
		$this->form_validation->set_rules('harga', 'Harga', 'required|numeric', [
			'required' => 'Harga produk wajib diisi.',
			'numeric' => 'Harga produk harus berupa angka.'
		]);

		if ($this->form_validation->run() == FALSE) {
			// Jika validasi gagal, tampilkan kembali form dengan pesan error
			$data['kategori'] = $this->db->get('kategori')->result_array();
			$data['status'] = $this->db->get('status')->result_array();
			$this->load->view('produk/produk_tambah', $data);
		} else {
			// Jika validasi sukses, simpan data ke database
			$data = [
				'nama_produk' => $this->input->post('nama_produk'),
				'harga' => $this->input->post('harga'),
				'kategori_id' => $this->input->post('kategori_id'),
				'status_id' => $this->input->post('status_id'),
			];
			$this->db->insert('produk', $data);
			redirect('produk');
		}
	}

	public function edit($id) {
		// Aturan validasi
		$this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required', [
			'required' => 'Nama produk wajib diisi.'
		]);
		$this->form_validation->set_rules('harga', 'Harga', 'required|numeric', [
			'required' => 'Harga produk wajib diisi.',
			'numeric' => 'Harga produk harus berupa angka.'
		]);

		if ($this->form_validation->run() == FALSE) {
			// Jika validasi gagal, tampilkan kembali form dengan pesan error
			$data['produk'] = $this->db->get_where('produk', ['id_produk' => $id])->row_array();
			$data['kategori'] = $this->db->get('kategori')->result_array();
			$data['status'] = $this->db->get('status')->result_array();
			$this->load->view('produk/produk_edit', $data);
		} else {
			// Jika validasi sukses, update data ke database
			$data = [
				'nama_produk' => $this->input->post('nama_produk'),
				'harga' => $this->input->post('harga'),
				'kategori_id' => $this->input->post('kategori_id'),
				'status_id' => $this->input->post('status_id'),
			];
			$this->db->where('id_produk', $id);
			$this->db->update('produk', $data);
			redirect('produk');
		}
	}

	public function hapus($id) {
		$this->db->where('id_produk', $id);
		$this->db->delete('produk');
		redirect('produk');
	}

    public function fetch_api_data() {
        $url = "https://recruitment.fastprint.co.id/tes/api_tes_programmer";

        // Data yang akan dikirim melalui POST
		date_default_timezone_set('Asia/Makassar');
		$username = "tesprogrammer". date('d') . date('m') . date('y') . "C" . date('H');
        $password_md5 = md5("bisacoding-" . date('d') . "-" . date('m') . "-" . date('y'));
        

        // Debugging username dan password
		echo "<script>
        console.log('Username: " . addslashes($username) . "');
        console.log('Password Setelah Enkripsi (MD5): " . addslashes($password_md5) . "');
    	</script>";

        // Inisialisasi cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'username' => $username,
            'password' => $password_md5
        ]);

        // Eksekusi cURL
        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Tampilkan hasil respons
        if ($http_status == 200) {
            $data = json_decode($response, true);

            if (isset($data['data']) && is_array($data['data'])) {
                echo "<h3>Data Produk:</h3>";
                echo "<pre>";
                print_r($data['data']);
                echo "</pre>";

                // Simpan data ke database
                foreach ($data['data'] as $item) {
                    // Cek dan simpan kategori
                    $kategori_id = $this->db->get_where('kategori', ['nama_kategori' => $item['kategori']])->row('id_kategori');
                    if (!$kategori_id) {
                        $this->db->insert('kategori', ['nama_kategori' => $item['kategori']]);
                        $kategori_id = $this->db->insert_id();
                    }

                    // Cek dan simpan status
                    $status_id = $this->db->get_where('status', ['nama_status' => $item['status']])->row('id_status');
                    if (!$status_id) {
                        $this->db->insert('status', ['nama_status' => $item['status']]);
                        $status_id = $this->db->insert_id();
                    }

                    // Simpan produk
                    $this->db->insert('produk', [
                        'nama_produk' => $item['nama_produk'],
                        'harga' => $item['harga'],
                        'kategori_id' => $kategori_id,
                        'status_id' => $status_id,
                    ]);
                }
                echo "<p>Data berhasil disimpan ke database.</p>";
            } else {
                echo "<p>Data API tidak valid atau kosong.</p>";
            }
        } else {
            echo "<p>Gagal mengambil data dari API. Status: $http_status</p>";
            echo "<h3>Respons API:</h3>";
            echo "<pre>$response</pre>";
        }
    }
}
