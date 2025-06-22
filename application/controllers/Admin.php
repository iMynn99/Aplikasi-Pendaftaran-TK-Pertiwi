<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->helper('url'); 
        $this->load->library('session'); 
        $this->load->database(); 
    }
    private function _getSidebarData()
    {
        $data['user']  = $this->db->get_where('login', ['username' => $this->session->userdata('username')])->row_array();
        $data['role'] = $this->session->userdata('role');

        // Mengambil semua data kelas dari tabel 'kelas'
        $data['all_kelas'] = $this->db->get('kelas')->result_array();

        // QUERY MENU (tetap seperti yang sudah ada)
        $role      = $this->session->userdata('role');
        $queryMenu = "SELECT * FROM `menu` WHERE `menu`.`role` = '$role'";
        $data['menu'] = $this->db->query($queryMenu)->result_array();

        return $data;
    }
    
    public function index()
    {
        $data = $this->_getSidebarData(); // Memastikan data bilah sisi dimuat
        $data['title'] = 'Dashboard';

        // Data pengguna untuk bilah atas (topbar)/profil
        $data['user']  = $this->db->get_where('login', ['username' => $this->session->userdata('username')])->row_array();

        // Menghitung total siswa
        $data['total_siswa'] = $this->db->get('data_siswa')->num_rows();

        // Menghitung total orang tua
        $data['total_ortu'] = $this->db->get('data_ortu')->num_rows();

        // Menghitung total nominal dari pembayaran
        $this->db->select_sum('nominal');
        $total = $this->db->get('pembayaran')->row();
        $data['total_nominal'] = $total->nominal;

        // Mendapatkan jumlah total kelas
        $data['total_jumlah_kelas'] = $this->db->get('kelas')->num_rows();

        // Mendapatkan jumlah siswa untuk setiap kelas secara dinamis
        $this->db->select('kelas.nama_kelas, COUNT(data_siswa.id_siswa) as jumlah_siswa');
        $this->db->from('kelas');
        $this->db->join('data_siswa', 'kelas.id_kelas = data_siswa.id_kelas', 'left');
        $this->db->group_by('kelas.id_kelas');
        $this->db->order_by('kelas.nama_kelas', 'ASC'); // Urutkan berdasarkan nama kelas
        $data['jumlah_siswa_per_kelas'] = $this->db->get()->result_array();

        if ($this->session->userdata('role') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/index', $data); // Tampilan dasbor
            $this->load->view('templates/footer');
        } else {
            redirect('auth2');
        }
    }

    public function kelas($slug_kelas)
    {
        $data = $this->_getSidebarData();

        // Mengubah slug URL menjadi nama kelas yang sesuai di database
        // Misalnya, jika URLnya 'kelas-b1', kita ingin menjadi 'B1'
        // Jika nama kelas di database memiliki spasi, sesuaikan logika ini
        $nama_kelas_db = str_replace('-', ' ', strtoupper($slug_kelas)); // Misal: kelas-a-1 menjadi A 1

        // Ambil ID kelas berdasarkan nama_kelas
        $kelas_info = $this->db->get_where('kelas', ['nama_kelas' => $nama_kelas_db])->row_array();

        if ($kelas_info) {
            $data['title'] = 'Data Siswa Kelas ' . $kelas_info['nama_kelas'];
            $id_kelas = $kelas_info['id_kelas'];

            // Query untuk mendapatkan siswa berdasarkan id_kelas
            $this->db->select('data_siswa.*, kelas.nama_kelas');
            $this->db->from('data_siswa');
            $this->db->join('kelas', 'kelas.id_kelas = data_siswa.id_kelas', 'left');
            $this->db->where('data_siswa.id_kelas', $id_kelas);
            $data['siswa_kelas'] = $this->db->get()->result_array();
        } else {
            // Jika kelas tidak ditemukan
            $data['title'] = 'Kelas Tidak Ditemukan';
            $data['siswa_kelas'] = [];
            // $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Kelas yang Anda cari tidak ditemukan.</div>');
        }

        if ($this->session->userdata('role') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/data_siswa_kelas', $data); // Ini adalah view baru
            $this->load->view('templates/footer');
        } else {
            redirect('auth2');
        }
    }

    public function siswa()
    {
        $data = $this->_getSidebarData();
        $data['title'] = 'Data Siswa';
        $data['user']  = $this->db->get_where('login', ['username' => $this->session->userdata('username')])->row_array();
        $this->db->select('data_siswa.*, login.created_at, login.email, login.username, kelas.nama_kelas');
        $this->db->from('data_siswa');
        $this->db->join('login', 'login.id = data_siswa.id_login');
        $this->db->join('kelas', 'kelas.id_kelas = data_siswa.id_kelas', 'left');
        $data['siswa'] = $this->db->get()->result_array();

        if ($this->session->userdata('role') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/siswa', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('auth2');
        }
    }

    public function tambahsiswa()
    {
        $data = $this->_getSidebarData();
        $data['title'] = 'Tambah Data Siswa';
        $data['user']  = $this->db->get_where('login', ['username' => $this->session->userdata('username')])->row_array();
        $kelas = $this->db->get('kelas')->result_array();
        foreach ($kelas as $key => $k) {
            $this->db->where('id_kelas', $k['id_kelas']);
            $kelas[$key]['jumlah_siswa'] = $this->db->count_all_results('data_siswa');
        }
    
        $data['kelas'] = $kelas;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/tambahsiswa', $data);
        $this->load->view('templates/footer');
    }



    public function viewEditSiswa($id)
    {
        $data = $this->_getSidebarData();
        $data['title'] = 'Edit Siswa';
        $data['user']  = $this->db->get_where('login', ['username' => $this->session->userdata('username')])->row_array();
        $this->db->select('data_siswa.*, login.created_at, login.email, login.username');
        $this->db->from('data_siswa');
        $this->db->join('login', 'login.id = data_siswa.id_login');
        $this->db->where('data_siswa.id_siswa', $id);
        $data['siswa'] = $this->db->get()->row_array();

        if ($this->session->userdata('role') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/editSiswa', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('auth2');
        }
    }

    public function simpansiswa()
{
    // Validasi input
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[login.email]');
    $this->form_validation->set_rules('nis', 'NIS', 'required|is_unique[data_siswa.nis]');
    $this->form_validation->set_rules('nama', 'Nama Siswa', 'required');
    // Tambahkan validasi untuk field lainnya sesuai kebutuhan

    if ($this->form_validation->run() == FALSE) {
        // Jika validasi gagal
        $errors = validation_errors();
        $this->session->set_flashdata('message', '<div class="alert alert-danger">' . $errors . '</div>');
        redirect('admin/siswa/tambah');
    }

    // Proses upload gambar profil
    $config['upload_path'] = './assets/img/profile/';
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['max_size'] = 2048; // 2MB
    $config['file_name'] = 'profile_' . time();
    
    $this->load->library('upload', $config);
    $data['jenis_kelamin'] = $this->input->post('kelamin');
    
    if ($data['jenis_kelamin'] == 'L') {
        $image = 'laki-laki.jpg';
    } elseif ($data['jenis_kelamin'] == 'P') {
        $image = 'perempuan.svg';
    } else {
        $image = 'default.jpg'; 
    }

    if (!empty($_FILES['foto']['name'])) {
        if ($this->upload->do_upload('foto')) {
            $uploadData = $this->upload->data();
            $image = $uploadData['file_name'];
            
            // Resize gambar jika diperlukan
            $config['image_library'] = 'gd2';
            $config['source_image'] = './assets/img/profile/' . $image;
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 300;
            $config['height'] = 300;
            
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
        } else {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Error upload foto: ' . $error . '</div>');
            redirect('admin/siswa/tambah');
        }
    }

    // Mulai transaksi database
    $this->db->trans_start();

    try {
        // Data untuk tabel login
        $dataLogin = [
            'email' => $this->input->post('email'),
            'nama' => $this->input->post('nama'),
            'username' => strtolower(str_replace(' ', '', $this->input->post('nama'))), // Format username
            'password' => password_hash('123456', PASSWORD_DEFAULT), // Password default
            'role' => 'user',
            'image' => $image,
            'created_at' => date('Y-m-d H:i:s'),
            'is_active' => 0,
        ];

        $this->db->insert('login', $dataLogin);
        $id_login = $this->db->insert_id();

        // Data untuk tabel siswa
        $dataSiswa = [
            'nis' => $this->input->post('nis'),
            'nama_siswa' => $this->input->post('nama'),
            'nik' => $this->input->post('nik'),
            'jenis_kelamin' => $this->input->post('kelamin'),
            'alamat' => $this->input->post('alamat'),
            'tempat_lahir' => $this->input->post('tempat_lahir'),
            'tgl_lahir' => $this->input->post('tgl_lahir'),
            'agama' => $this->input->post('agama'),
            'kewarganegaraan' => $this->input->post('kewarganegaraan'),
            'usia' => $this->input->post('usia'),
            'anak_ke' => $this->input->post('anak_ke'),
            'id_kelas' => $this->input->post('id_kelas'),
            'id_login' => $id_login,
            'status_pendaftaran' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->insert('data_siswa', $dataSiswa);

        // Selesaikan transaksi
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            throw new Exception('Gagal menyimpan data');
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success">Data siswa berhasil ditambahkan</div>');
        redirect('admin/siswa');

    } catch (Exception $e) {
        $this->db->trans_rollback();
        $this->session->set_flashdata('message', '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>');
        redirect('admin/tambahsiswa');
    }
    }



    public function editSiswa($id)
    {
        $data = $this->_getSidebarData();
        // Ambil data siswa
        $siswa = $this->db->get_where('data_siswa', ['id_siswa' => $id])->row_array();
        $user  = $this->db->get_where('login', ['id' => $siswa['id_login']])->row_array(); // Ambil data user (login)

        // Data untuk tabel data_siswa
        $dataS = [
            'nama_siswa' => $this->input->post('nama'),
            'nik' => $this->input->post('nik'),
            'jenis_kelamin' => $this->input->post('kelamin'),
            'alamat' => $this->input->post('alamat'),
            'tempat_lahir' => $this->input->post('tempat_lahir'),
            'agama' => $this->input->post('agama'),
            'kewarganegaraan' => $this->input->post('kewarganegaraan'),
            'usia' => $this->input->post('usia'),
            'anak_ke' => $this->input->post('anak_ke'),
        ];

        $dataL = [
            'email' => $this->input->post('email'),
        ];

        // Konfigurasi untuk upload gambar
        $config['upload_path']   = './assets/img/profile/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 20480; // Maksimum ukuran file (dalam KB)
        $config['file_name']     = 'user_' . $id; // Nama file foto dengan ID dan timestamp

        $this->load->library('upload', $config);

        $image = $user['image'];

        if (!empty($_FILES['image']['name'])) {
            if ($this->upload->do_upload('image')) {
                if ($user['image'] != 'default.jpg' && file_exists('./assets/img/profile/' . $user['image'])) {
                    // Hapus gambar lama
                    $old_image_path = './assets/img/profile/' . $user['image'];
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path); // Hapus gambar lama
                    }
                }
                $image = $this->upload->data('file_name');
            } else {
                // Jika upload gagal, set pesan error dan redirect
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Upload gambar gagal: ' . $this->upload->display_errors('', '') . '</div>');
                redirect('admin/siswa/edit/' . $id); // Redirect ke halaman edit
            }
        }


        // Update data siswa di tabel data_siswa
        $this->db->where('id_siswa', $id)->update('data_siswa', $dataS);

        // Update data login (termasuk email dan gambar) di tabel login
        $dataL['image'] = $image; // Masukkan image yang baru (jika ada)
        $this->db->where('id', $siswa['id_login'])->update('login', $dataL);

        // Set pesan sukses dan redirect ke halaman daftar siswa
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Siswa Berhasil Diubah!</div>');
        redirect('admin/siswa');
    }

    public function hapussiswa($id_siswa)
{
    $this->db->trans_start();

    try {
        // 1. Ambil id_login yang terkait dengan id_siswa
        $this->db->select('data_siswa.id_login, login.image');
        $this->db->from('data_siswa');
        $this->db->join('login', 'data_siswa.id_login = login.id', 'left');
        $this->db->where('data_siswa.id_siswa', $id_siswa);
        $siswa_data = $this->db->get()->row_array();

        if (empty($siswa_data)) {
            throw new Exception("Data siswa tidak ditemukan.");
        }

        $id_login_terkait = $siswa_data['id_login'];
        $profile_image = $siswa_data['image'];

        
        // Tambahkan ini untuk cek nilai sebelum hapus siswa
        // echo "Akan menghapus siswa ID: " . $id_siswa . " dan login ID: " . $id_login_terkait . "<br>";
        // die(); // Hentikan eksekusi di sini untuk melihat output

        // 2. Hapus data siswa dari tabel 'data_siswa'
        $this->db->where('id_siswa', $id_siswa);
        $this->db->delete('data_siswa');

        // Periksa apakah penghapusan siswa berhasil
        // if ($this->db->affected_rows() == 0) {
        //     throw new Exception("Penghapusan data siswa gagal (tidak ada baris terpengaruh).");
        // }

        // Tambahkan ini untuk cek setelah hapus siswa
        // echo "Data siswa berhasil dihapus.<br>";
        // die();

        // 3. Hapus data login yang terkait dari tabel 'login'
        if (!empty($id_login_terkait)) {
            $this->db->where('id', $id_login_terkait);
            $this->db->delete('login');

            // Periksa apakah penghapusan login berhasil
            // if ($this->db->affected_rows() == 0) {
            //     throw new Exception("Penghapusan data login gagal (tidak ada baris terpengaruh).");
            // }

            // Opsional: Hapus file gambar profil jika bukan default
            $default_images = ['laki-laki.jpg', 'perempuan.svg', 'default.jpg'];
            if (!in_array($profile_image, $default_images) && file_exists('./assets/img/profile/' . $profile_image)) {
                // Tambahkan ini untuk cek sebelum unlink
                // echo "Akan menghapus file: " . './assets/img/profile/' . $profile_image . "<br>";
                // die();
                unlink('./assets/img/profile/' . $profile_image);
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            throw new Exception("Gagal menghapus data siswa dan data login.");
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data siswa dan login berhasil dihapus.</div>');

    } catch (Exception $e) {
        $this->db->trans_rollback();
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Error: ' . $e->getMessage() . '</div>');
    }
    redirect('admin/siswa');
}


    public function ortu()
    {
        $data = $this->_getSidebarData();
        $data['title'] = 'Data Orang Tua';
        $data['user']  = $this->db->get_where('login', ['username' => $this->session->userdata('username')])->row_array();
        $this->db->select('data_siswa.*, data_ortu.*');
        $this->db->from('data_siswa');
        $this->db->join('data_ortu', 'data_ortu.id_siswa = data_siswa.id_siswa');
        $data['ortu'] = $this->db->get()->result_array();

        if ($this->session->userdata('role') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/ortu', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('auth2');
        }
    }

    public function tambahortu()
    {
        $data = $this->_getSidebarData();
        $data['title'] = 'Tambah Data Orang Tua';
        $data['user']  = $this->db->get_where('login', ['username' => $this->session->userdata('username')])->row_array();
        $data['siswa'] = $this->db->get('data_siswa')->result_array();
        $data['ortu'] = null;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/tambahortu', $data);
        $this->load->view('templates/footer');
    }

    public function viewEditOrtu($id)
    {
        $data = $this->_getSidebarData();
        $data['title'] = 'Edit Data Orang Tua';
        $data['user']  = $this->db->get_where('login', ['username' => $this->session->userdata('username')])->row_array();

        $this->db->select('data_ortu.*, data_siswa.*');
        $this->db->from('data_ortu');
        $this->db->join('data_siswa', 'data_siswa.id_siswa = data_ortu.id_siswa');
        $this->db->where('data_ortu.id_ortu', $id);
        $data['ortu'] = $this->db->get()->row_array();

        if ($this->session->userdata('role') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/editOrtu', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('auth2');
        }
    }

    public function simpandataortu()
    {
        // Tangkap data dari form
        $id_siswa = $this->input->post('id_siswa');
        $nama_ayah = $this->input->post('nama_ayah');
        $nik_ayah = $this->input->post('nik_ayah');
        $lahir_ayah = $this->input->post('lahir_ayah');
        $pend_ayah = $this->input->post('pend_ayah');
        $kerja_ayah = $this->input->post('kerja_ayah');
        $nama_ibu = $this->input->post('nama_ibu');
        $nik_ibu = $this->input->post('nik_ibu');
        $lahir_ibu = $this->input->post('lahir_ibu');
        $pend_ibu = $this->input->post('pend_ibu');
        $kerja_ibu = $this->input->post('kerja_ibu');
        $no_telepon = $this->input->post('no_telepon');

        $data = array(
            'id_siswa' => $id_siswa, // Simpan ID Siswa
            'nama_ayah' => $nama_ayah,
            'nik_ayah' => $nik_ayah,
            'lahir_ayah' => $lahir_ayah,
            'pend_ayah' => $pend_ayah,
            'kerja_ayah' => $kerja_ayah,
            'nama_ibu' => $nama_ibu,
            'nik_ibu' => $nik_ibu,
            'lahir_ibu' => $lahir_ibu,
            'pend_ibu' => $pend_ibu,
            'kerja_ibu' => $kerja_ibu,
            'no_telepon' => $no_telepon
        );

        // Langsung insert karena ini fungsi untuk "tambah"
        $this->db->insert('data_ortu', $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data orang tua berhasil disimpan!</div>');
        redirect('admin/ortu');
    }
    public function editOrtu($id)
    {
        $data = $this->_getSidebarData();
        $data = [
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
        $this->db->where('id_ortu', $id)->update('data_ortu', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Orang Tua Berhasil Diubah!</div>');
        redirect('admin/ortu');
    }

    public function hapusortu($id_ortu)
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('auth2'); 
        }

        $this->db->where('id_ortu', $id_ortu);
        $this->db->delete('data_ortu');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data orang tua berhasil dihapus!</div>');

        redirect('admin/ortu');
    }


    public function pembayaran()
    {
        $data = $this->_getSidebarData();
        $data['title'] = 'Data Pembayaran';
        $data['user']  = $this->db->get_where('login', ['username' => $this->session->userdata('username')])->row_array();
        $this->db->select('data_siswa.id_login, data_siswa.nama_siswa, pembayaran.*, login.email');
        $this->db->from('data_siswa');
        $this->db->join('pembayaran', 'pembayaran.id_siswa = data_siswa.id_siswa');
        $this->db->join('login', 'login.id = data_siswa.id_login');
        $data['bayar'] = $this->db->get()->result_array();

        if ($this->session->userdata('role') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/pembayaran', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('auth2');
        }
    }

    public function laporan()
    {
        $data = $this->_getSidebarData();
        $data['title'] = 'Laporan';
        $data['user']  = $this->db->get_where('login', ['username' => $this->session->userdata('username')])->row_array();

        if ($this->session->userdata('role') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/laporan', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('auth2');
        }
    }

    public function cetak()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        $data['title'] = 'Laporan';
        $data['user']  = $this->db->get_where('login', ['username' => $this->session->userdata('username')])->row_array();
        $this->db->select('data_siswa.*, pembayaran.*, login.email, login.username');
        $this->db->from('data_siswa');
        $this->db->join('pembayaran', 'pembayaran.id_siswa = data_siswa.id_siswa');
        $this->db->join('login', 'login.id = data_siswa.id_login');
        $this->db->where('pembayaran.tgl_bayar >=', $tgl_awal);
        $this->db->where('pembayaran.tgl_bayar <=', $tgl_akhir);
        $data['bayar'] = $this->db->get()->result_array();

        if ($this->session->userdata('role') == 'admin') {
            if (empty($data['bayar'])) {
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $data['tgl_awal'] = $tgl_awal;
                $data['tgl_akhir'] = $tgl_akhir;
                $this->load->view('admin/no_data', $data);
                $this->load->view('templates/footer');
            } else {
                $data['tgl_awal'] = $tgl_awal;
                $data['tgl_akhir'] = $tgl_akhir;
                $this->load->view('admin/cetak', $data);
            }
        } else {
            redirect('auth2');
        }
    }

    public function cetakSemuaSiswa()
    {
        $data['title'] = 'Laporan';
        $data['user']  = $this->db->get_where('login', ['username' => $this->session->userdata('username')])->row_array();
        $this->db->select('data_siswa.*, login.email, login.username');
        $this->db->from('data_siswa');
        // $this->db->join('pembayaran', 'pembayaran.id_siswa = data_siswa.id_siswa');
        $this->db->join('login', 'login.id = data_siswa.id_login');
        // $this->db->join('data_ortu', 'data_ortu.id_siswa = data_siswa.id_siswa');
        $data['siswa'] = $this->db->get()->result_array();

        if ($this->session->userdata('role') == 'admin') {
            $this->load->view('admin/cetakAllSiswa', $data);
        } else {
            redirect('auth2');
        }
    }

    public function printsiswa()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $this->db->from('data_siswa');
        $this->db->join('login', 'login.id = data_siswa.id_login');
        $siswa = $this->db->get()->result_array();

        // Header Kolom
        $sheet->setCellValue('A1', 'Daftar Peserta Didik');
        $sheet->setCellValue('A2', 'TK PERTIWI BOJONGWETAN');
        $sheet->setCellValue('A3', 'Kecamatan Bojong, Kabupaten Pekalongan, Provinsi Jawa Tengah');
        $sheet->setCellValue('A4', 'Tanggal unduh ' . date('d-m-Y H:i:s'));
        $sheet->setCellValue('F4', 'Di unduh oleh ' . htmlspecialchars($this->session->userdata('nama')));

        $sheet->setCellValue('A5', 'No');
        $sheet->setCellValue('B5', 'Nama');
        $sheet->setCellValue('C5', 'NIK');
        $sheet->setCellValue('D5', 'Tempat Lahir');
        $sheet->setCellValue('E5', 'Tanggal Lahir');
        $sheet->setCellValue('F5', 'Jenis Kelamin');
        $sheet->setCellValue('G5', 'Alamat');

        $row = 6;
        $no = 1;
        foreach ($siswa as $data) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $data['nama_siswa']);
            $sheet->setCellValue('C' . $row, $data['nik']);
            $sheet->setCellValue('D' . $row, $data['tempat_lahir']);
            $sheet->setCellValue('E' . $row, date('d-m-Y', strtotime($data['tgl_lahir'])));
            $sheet->setCellValue('F' . $row, $data['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan');
            $sheet->setCellValue('G' . $row, $data['alamat']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'data_siswa_' . date('Ymd_His');

        // Output file ke browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function printortu()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $this->db->from('data_siswa');
        $this->db->join('login', 'login.id = data_siswa.id_login');
        $this->db->join('data_ortu', 'data_ortu.id_siswa = data_siswa.id_siswa');
        $this->db->select('data_siswa.*, data_ortu.*, login.email, login.username');
        $siswa = $this->db->get()->result_array();

        // Header Kolom
        $sheet->setCellValue('A1', 'Daftar Orang Tua Peserta Didik');
        $sheet->setCellValue('A2', 'TK PERTIWI BOJONGWETAN');
        $sheet->setCellValue('A3', 'Kecamatan Bojong, Kabupaten Pekalongan, Provinsi Jawa Tengah');
        $sheet->setCellValue('A4', 'Tanggal unduh ' . date('d-m-Y H:i:s'));
        $sheet->setCellValue('F4', 'Di unduh oleh ' . htmlspecialchars($this->session->userdata('nama')));

        $sheet->setCellValue('A5', 'No');
        $sheet->setCellValue('B5', 'Nama Siswa');
        $sheet->setCellValue('C5', 'Nama Ayah');
        $sheet->setCellValue('D5', 'NIK Ayah');
        $sheet->setCellValue('E5', 'Kelahiran Ayah');
        $sheet->setCellValue('F5', 'Pendidikan Ayah');
        $sheet->setCellValue('G5', 'Pekerjaan Ayah');
        $sheet->setCellValue('H5', 'Nama Ibu');
        $sheet->setCellValue('I5', 'NIK Ibu');
        $sheet->setCellValue('J5', 'Kelahiran Ibu');
        $sheet->setCellValue('K5', 'Pendidikan Ibu');
        $sheet->setCellValue('L5', 'Pekerjaan Ibu');
        $sheet->setCellValue('M5', 'Nomor Telepon');



        $row = 6;
        $no = 1;
        foreach ($siswa as $data) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $data['nama_siswa']);
            $sheet->setCellValue('C' . $row, $data['nama_ayah']);
            $sheet->setCellValue('D' . $row, $data['nik_ayah']);
            $sheet->setCellValue('E' . $row, date('d-m-Y', strtotime($data['lahir_ayah'])));
            $sheet->setCellValue('F' . $row, $data['pend_ayah']);
            $sheet->setCellValue('G' . $row, $data['kerja_ayah']);
            $sheet->setCellValue('H' . $row, $data['nama_ibu']);
            $sheet->setCellValue('I' . $row, $data['nik_ibu']);
            $sheet->setCellValue('J' . $row, date('d-m-Y', strtotime($data['lahir_ibu'])));
            $sheet->setCellValue('K' . $row, $data['pend_ibu']);
            $sheet->setCellValue('L' . $row, $data['kerja_ibu']);
            $sheet->setCellValue('M' . $row, $data['no_telepon']);

            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'data_ortu_' . date('Ymd_His');

        if (ob_get_length()) ob_end_clean();

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function printAllSiswa()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $this->db->from('data_siswa');
        $this->db->join('login', 'login.id = data_siswa.id_login');
        $this->db->join('data_ortu', 'data_ortu.id_siswa = data_siswa.id_siswa');
        $this->db->select('data_siswa.*, data_ortu.*, login.email, login.username');
        $siswa = $this->db->get()->result_array();

        // Header Kolom
        $sheet->setCellValue('A1', 'Daftar Semua Data Peserta Didik');
        $sheet->setCellValue('A2', 'TK PERTIWI BOJONGWETAN');
        $sheet->setCellValue('A3', 'Kecamatan Bojong, Kabupaten Pekalongan, Provinsi Jawa Tengah');
        $sheet->setCellValue('A4', 'Tanggal unduh ' . date('d-m-Y H:i:s'));
        $sheet->setCellValue('F4', 'Di unduh oleh ' . htmlspecialchars($this->session->userdata('nama')));

        $sheet->setCellValue('A5', 'No');
        $sheet->setCellValue('B5', 'Nama Siswa');
        $sheet->setCellValue('C5', 'NIK');
        $sheet->setCellValue('D5', 'Tempat Lahir');
        $sheet->setCellValue('E5', 'Tanggal Lahir');
        $sheet->setCellValue('F5', 'Usia');
        $sheet->setCellValue('G5', 'Anak Ke');
        $sheet->setCellValue('H5', 'Jenis Kelamin');
        $sheet->setCellValue('I5', 'Alamat');
        $sheet->setCellValue('J5', 'Agama');
        $sheet->setCellValue('K5', 'Kewarganegaraan');
        $sheet->setCellValue('L5', 'Nama Ayah');
        $sheet->setCellValue('M5', 'NIK Ayah');
        $sheet->setCellValue('N5', 'Tanggal Lahir Ayah');
        $sheet->setCellValue('O5', 'Pendidikan Ayah');
        $sheet->setCellValue('P5', 'Pekerjaan Ayah');
        $sheet->setCellValue('Q5', 'Nama Ibu');
        $sheet->setCellValue('R5', 'NIK Ibu');
        $sheet->setCellValue('S5', 'Tanggal Lahir Ibu');
        $sheet->setCellValue('T5', 'Pendidikan Ibu');
        $sheet->setCellValue('U5', 'Pekerjaan Ibu');
        $sheet->setCellValue('V5', 'Nomor Telepon');

        $row = 6;
        $no = 1;
        foreach ($siswa as $data) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $data['nama_siswa']);
            $sheet->setCellValue('C' . $row, $data['nik']);
            $sheet->setCellValue('D' . $row, $data['tempat_lahir']);
            $sheet->setCellValue('E' . $row, date('d-m-Y', strtotime($data['tgl_lahir'])));
            $sheet->setCellValue('F' . $row, $data['usia']);
            $sheet->setCellValue('G' . $row, $data['anak_ke']);
            $sheet->setCellValue('H' . $row, $data['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan');
            $sheet->setCellValue('I' . $row, $data['alamat']);
            $sheet->setCellValue('J' . $row, $data['agama']);
            $sheet->setCellValue('K' . $row, $data['kewarganegaraan']);
            $sheet->setCellValue('L' . $row, $data['nama_ayah']);
            $sheet->setCellValue('M' . $row, $data['nik_ayah']);
            $sheet->setCellValue('N' . $row, date('d-m-Y', strtotime($data['lahir_ayah'])));
            $sheet->setCellValue('O' . $row, $data['pend_ayah']);
            $sheet->setCellValue('P' . $row, $data['kerja_ayah']);
            $sheet->setCellValue('Q' . $row, $data['nama_ibu']);
            $sheet->setCellValue('R' . $row, $data['nik_ibu']);
            $sheet->setCellValue('S' . $row, date('d-m-Y', strtotime($data['lahir_ibu'])));
            $sheet->setCellValue('T' . $row, $data['pend_ibu']);
            $sheet->setCellValue('U' . $row, $data['kerja_ibu']);
            $sheet->setCellValue('V' . $row, $data['no_telepon']);

            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'biodata_siswa_' . date('Ymd_His');

        // Output file ke browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}