<?php
defined('BASEPATH') or exit('No direct script access allowed');


require_once APPPATH . 'libraries/midtrans/midtrans-php/Midtrans.php';

class User extends CI_Controller
{
    public function index()
    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('login', ['id' => $this->session->userdata('id')])->row_array();

        if ($this->session->userdata('role') == 'user') {
            redirect('user/data');
        } else {
            redirect('auth2');
        }
    }

    public function datadiri()
    {
        $data['title'] = 'Data Diri';
        $data['user'] = $this->db->get_where('login', ['username' => $this->session->userdata('username')])->row_array();

        if ($this->session->userdata('role') !== 'user') {
            redirect('auth2');
            return;
        }

        $this->db->select('data_siswa.*, kelas.nama_kelas'); // Pilih semua kolom dari data_siswa dan kolom nama_kelas dari tabel kelas
        $this->db->from('data_siswa');
        $this->db->join('kelas', 'kelas.id_kelas = data_siswa.id_kelas', 'left'); // Lakukan LEFT JOIN
        $this->db->where('data_siswa.id_login', $this->session->userdata('id'));
        $data['siswa'] = $this->db->get()->row_array();

        $incomplete_data = false;

        if (empty($data['siswa'])) {
            $incomplete_data = true;
        } else {
            if (empty($data['siswa']['nik']) || $data['siswa']['nik'] == 0) {
                $incomplete_data = true;
            }

            $data['ortu'] = $this->db->get_where('data_ortu', ['id_siswa' => $data['siswa']['id_siswa']])->row_array();

            if (empty($data['ortu'])) {
                $incomplete_data = true;
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);

        if ($incomplete_data) {
            $data['judul'] = 'Data Diri';
            $this->load->view('user/no_data', $data);
        } else {
            $this->load->view('user/data', $data);
        }

        $this->load->view('templates/footer');
    }

    public function dataortu()
    {
        $data['title'] = 'Data Orang Tua';
        $data['user'] = $this->db->get_where('login', ['username' => $this->session->userdata('username')])->row_array();

        if ($this->session->userdata('role') !== 'user') {
            redirect('auth2');
            return;
        }

        $data['siswa'] = $this->db->get_where('data_siswa', ['id_login' => $this->session->userdata('id')])->row_array();

        $incomplete_data = false;

        if (empty($data['siswa'])) {
            $incomplete_data = true;
        } else {
            if (empty($data['siswa']['nik']) || $data['siswa']['nik'] == 0) {
                $incomplete_data = true;
            }

            $data['ortu'] = $this->db->get_where('data_ortu', ['id_siswa' => $data['siswa']['id_siswa']])->row_array();

            if (empty($data['ortu'])) {
                $incomplete_data = true;
            } else {
                if (empty($data['ortu']['nik_ayah']) || $data['ortu']['nik_ayah'] == 0) {
                    $incomplete_data = true;
                }
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);

        if ($incomplete_data) {
            $data['judul'] = 'Data Orang Tua';
            $this->load->view('user/no_data', $data);
        } else {
            $this->load->view('user/ortu', $data);
        }

        $this->load->view('templates/footer');
    }

    public function formdatadiri()
    {
        $data['title'] = 'Data Diri';
        $data['user'] = $this->db->get_where('login', ['username' => $this->session->userdata('username')])->row_array();

        if ($this->session->userdata('role') !== 'user') {
            redirect('auth2');
            return;
        }

        // Ambil data siswa. Inisialisasi sebagai array kosong jika tidak ditemukan.
        $data['siswa'] = $this->db->get_where('data_siswa', ['id_login' => $this->session->userdata('id')])->row_array();
        if (empty($data['siswa'])) {
            $data['siswa'] = [];
        }

        // Inisialisasi data ortu sebagai array kosong.
        $data['ortu'] = [];

        // Jika data siswa ada (tidak kosong), baru coba ambil data ortu
        // Ini mencegah error jika $data['siswa']['id_siswa'] belum ada
        if (!empty($data['siswa']) && isset($data['siswa']['id_siswa'])) {
            $data['ortu'] = $this->db->get_where('data_ortu', ['id_siswa' => $data['siswa']['id_siswa']])->row_array();
            // Pastikan $data['ortu'] tidak null jika tidak ditemukan
            if (empty($data['ortu'])) {
                $data['ortu'] = [];
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/formdatasiswa', $data);
        $this->load->view('templates/footer');
    }

    public function simpanDatadiri()
    {
        $id = $this->session->userdata('id');
        $siswa = $this->db->get_where('data_siswa', ['id_login' => $id])->row_array();
        $user  = $this->db->get_where('login', ['id' => $id])->row_array();

        $config['upload_path']   = './assets/img/profile/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 20480;
        $config['file_name']     = 'user_' . $id;

        $this->load->library('upload', $config);

        $image = $user['image'];

        $tanggal = date('dmy');
        $nis = $tanggal . $id;

        if (!empty($_FILES['image']['name'])) {
            if ($this->upload->do_upload('image')) {
                if ($user['image'] != 'default.jpg' && file_exists('./assets/img/profile/' . $user['image'])) {
                    unlink('./assets/img/profile/' . $user['image']);
                }
                $image = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Upload gambar gagal: ' . $this->upload->display_errors('', '') . '</div>');
                redirect('user/data');
            }
        }
        $kelas_awal = 'B1';  // Kelas pertama, bisa diubah sesuai kebutuhan
        $kelas = $kelas_awal;

        $this->db->where('kelas', $kelas);
        $this->db->from('data_siswa');
        $jumlah_murid = $this->db->count_all_results();

        if ($jumlah_murid >= 18) {
            $kelas = $this->get_next_class($kelas);
        }

        function get_next_class($current_class)
        {
            $current_class_letter = substr($current_class, 0, 1);
            $current_class_number = substr($current_class, 1);

            if ($current_class_letter == 'b') {
                $next_class_letter = 'a';
                $next_class_number = $current_class_number;
            } else {
                $next_class_letter = $current_class_letter;
                $next_class_number = $current_class_number + 1;
            }

            // Menghasilkan kelas berikutnya
            return $next_class_letter . $next_class_number;
        }

        $dataS = [
            'nama_siswa'      => $this->input->post('nama'),
            'nik'             => $this->input->post('nik'),
            'nis'             => $nis,
            'jenis_kelamin'   => $this->input->post('kelamin'),
            'alamat'          => $this->input->post('alamat'),
            'tempat_lahir'    => $this->input->post('tempat_lahir'),
            'tgl_lahir'       => $this->input->post('tgl_lahir'),
            'agama'           => $this->input->post('agama'),
            'kewarganegaraan' => $this->input->post('kewarganegaraan'),
            'usia'            => $this->input->post('usia'),
            'anak_ke'         => $this->input->post('anak_ke'),
            'kelas'           => $kelas
        ];

        $dataL = [
            'email' => $this->input->post('email'),
            'image' => $image
        ];

        $this->db->where('id_login', $id)->update('data_siswa', $dataS);
        $this->db->where('id', $id)->update('login', $dataL);

        // Tambahkan pembayaran jika belum ada
        $pembayaran = $this->db->get_where('pembayaran', ['id_siswa' => $siswa['id_siswa']])->row_array();
        if (empty($pembayaran)) {
            $this->db->insert('pembayaran', [
                'id_siswa'   => $siswa['id_siswa'],
                'nominal'    => 25000,
                'status'     => 'belum',
                'date_added' => gmdate('Y-m-d H:i:s', time() + 7 * 3600)
            ]);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Siswa Berhasil Diubah!</div>');
        redirect('user/data');
    }

    public function formdataortu()
    {
        $data['title'] = 'Data Orang Tua';
        $data['user'] = $this->db->get_where('login', ['username' => $this->session->userdata('username')])->row_array();

        if ($this->session->userdata('role') !== 'user') {
            redirect('auth2');
            return;
        }

        // Ambil data siswa
        $data['siswa'] = $this->db->get_where('data_siswa', ['id_login' => $this->session->userdata('id')])->row_array();

        // Inisialisasi data ortu agar tidak null jika belum ada
        $data['ortu'] = []; // Default ke array kosong

        // Jika data siswa ada, baru coba ambil data ortu
        if (!empty($data['siswa'])) {
            $data['ortu'] = $this->db->get_where('data_ortu', ['id_siswa' => $data['siswa']['id_siswa']])->row_array();
            // Pastikan $data['ortu'] tidak null jika tidak ditemukan
            if (empty($data['ortu'])) {
                $data['ortu'] = []; // Tetapkan ke array kosong jika tidak ada data
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/formdataortu', $data); // Form selalu ditampilkan
        $this->load->view('templates/footer');
    }

    public function simpanDataortu()
    {
        $id = $this->session->userdata('id');
        $dataO = [
            'nama_ayah' => $this->input->post('nama_ayah'),
            'nik_ayah' => $this->input->post('nik_ayah'),
            'lahir_ayah' => $this->input->post('lahir_ayah'),
            'pend_ayah' => $this->input->post('pend_ayah'),
            'kerja_ayah' => $this->input->post('kerja_ayah'),
            'nama_ibu' => $this->input->post('nama_ibu'),
            'nik_ibu' => $this->input->post('nik_ibu'),
            'lahir_ibu' => $this->input->post('lahir_ibu'),
            'pend_ibu' => $this->input->post('pend_ibu'),
            'kerja_ibu' => $this->input->post('kerja_ibu'),
            'no_telepon' => $this->input->post('no_telepon'),
        ];
        $this->db->where('id_siswa', $this->db->get_where('data_siswa', ['id_login' => $id])->row_array()['id_siswa'])->update('data_ortu', $dataO);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Orang Tua Berhasil Diubah!</div>');
        redirect('user/ortu');
    }

    public function pembayaran()
    {
        $skey = 'SB-Mid-server-ck2TJTOVPAWZX80ZQ66iYLjk';
        $id = $this->session->userdata('id');
        $data['title'] = 'Pembayaran';
        $data['user'] = $this->db->get_where('login', ['username' => $this->session->userdata('username')])->row_array();

        if ($this->session->userdata('role') !== 'user') {
            redirect('auth2');
            return;
        }

        $data['siswa'] = $this->db->get_where('data_siswa', ['id_login' => $id])->row_array();

        $incomplete_data = false;

        if (empty($data['siswa'])) {
            $incomplete_data = true;
        } else {
            if (empty($data['siswa']['nik']) || $data['siswa']['nik'] == 0) {
                $incomplete_data = true;
            }

            $data['ortu'] = $this->db->get_where('data_ortu', ['id_siswa' => $data['siswa']['id_siswa']])->row_array();

            if (empty($data['ortu'])) {
                $incomplete_data = true;
            } else {
                if (empty($data['ortu']['nik_ayah']) || $data['ortu']['nik_ayah'] == 0) {
                    $incomplete_data = true;
                }
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);

        if ($incomplete_data) {
            $data['judul'] = 'Data Pembayaran';
            $this->load->view('user/no_data', $data);
        } else {
            // Mengambil data tagihan
            $data['tagihan'] = $this->db->get_where('pembayaran', ['id_siswa' => $data['siswa']['id_siswa']])->row_array();

            // Inisialisasi snapToken dan error_midtrans di sini
            $data['snapToken'] = null;
            $data['error_midtrans'] = null;

            // Jika tagihan ditemukan, proses Midtrans
            if (!empty($data['tagihan'])) {
                $tagihan = $data['tagihan'];
                $id_pembayaran = $tagihan['id_pembayaran'];

                if (empty($tagihan['order_id_midtrans']) || $tagihan['status'] != 'sudah') {
                    $order_id = 'ORDER-' . $id_pembayaran . '-' . time();
                    $this->db->set('order_id_midtrans', $order_id);
                    $this->db->where('id_pembayaran', $id_pembayaran);
                    $this->db->update('pembayaran');
                } else {
                    $order_id = $tagihan['order_id_midtrans'];
                }

                \Midtrans\Config::$serverKey = $skey;
                \Midtrans\Config::$isProduction = false;
                \Midtrans\Config::$isSanitized = true;
                \Midtrans\Config::$is3ds = true;

                $params = array(
                    'transaction_details' => array(
                        'order_id' => $order_id,
                        'gross_amount' => $tagihan['nominal'],
                    ),
                    'customer_details' => array(
                        'first_name' => $data['siswa']['nama_lengkap'] ?? '',
                        'email' => $data['user']['email'] ?? '',
                    ),
                );

                try {
                    $snapToken = \Midtrans\Snap::getSnapToken($params);
                    $data['snapToken'] = $snapToken;
                } catch (Exception $e) {
                    $data['snapToken'] = null;
                    $data['error_midtrans'] = $e->getMessage();
                }
            }

            // Memuat view pembayaran, baik ada tagihan atau tidak
            echo "<script src='https://app.sandbox.midtrans.com/snap/snap.js' data-client-key='$skey'></script>";
            $this->load->view('user/pembayaran', $data);
        }

        $this->load->view('templates/footer');
    }

    public function cetakData()
    {
        $data['title'] = 'Cetak Data';
        $data['user'] = $this->db->get_where('login', ['username' => $this->session->userdata('username')])->row_array();
        $id_login = $this->session->userdata('id');

        $this->db->select('data_siswa.*, kelas.nama_kelas');
        $this->db->from('data_siswa');
        $this->db->join('kelas', 'kelas.id_kelas = data_siswa.id_kelas', 'left'); 
        $this->db->where('data_siswa.id_login', $id_login);
        $data['siswa'] = $this->db->get()->row_array();
        $data['ortu'] = $this->db->get_where('data_ortu', ['id_siswa' => $data['siswa']['id_siswa']])->row_array();

        $this->load->view('user/cetak', $data);
    }

    public function cetakBukti()
    {
        $data['title'] = 'Cetak Bukti Pembayaran';
        $data['user'] = $this->db->get_where('login', ['username' => $this->session->userdata('username')])->row_array();
        $id_login = $this->session->userdata('id');

        $this->db->select('data_siswa.*, kelas.nama_kelas');
        $this->db->from('data_siswa');
        $this->db->join('kelas', 'kelas.id_kelas = data_siswa.id_kelas', 'left'); 
        $this->db->where('data_siswa.id_login', $id_login);
        $data['siswa'] = $this->db->get()->row_array();
        $data['ortu'] = $this->db->get_where('data_ortu', ['id_siswa' => $data['siswa']['id_siswa']])->row_array();
        $data['tagihan'] = $this->db->get_where('pembayaran', ['id_siswa' => $data['siswa']['id_siswa']])->row_array();

        $this->load->view('user/bukti', $data);
    }

    public function cetakKartu()
    {
        $id_login = $this->session->userdata('id');

        $this->db->select('data_siswa.*, kelas.nama_kelas');
        $this->db->from('data_siswa');
        $this->db->join('kelas', 'kelas.id_kelas = data_siswa.id_kelas', 'left'); 
        $this->db->where('data_siswa.id_login', $id_login);
        $data['siswa'] = $this->db->get()->row_array();
        $data = [
            'title' => 'Cetak Kartu Pelajar',
            'user' => $this->db->get_where('login', ['username' => $this->session->userdata('username')])->row_array(),
            'siswa' => $data['siswa'],
            
        ];

        $this->load->view('user/kartupelajar', $data);
    }
}