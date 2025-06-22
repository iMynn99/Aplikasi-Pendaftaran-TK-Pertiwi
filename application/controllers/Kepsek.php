<?php

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;


defined('BASEPATH') or exit('No direct script access allowed');

class Kepsek extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model', '', true);
        $this->load->library('session');
    }

    public function index()
    {
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

        if ($this->session->userdata('role') == 'kepsek') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/index', $data); // Tampilan dasbor
            $this->load->view('templates/footer');
        } else {
            redirect('auth2');
        }
    } 

    public function pendaftaran() {
        if ($this->session->userdata('role') != 'kepsek') {
            redirect('auth2');
        }
    
        $data['title'] = 'Konfirmasi Pendaftaran Siswa';
        $data['user']  = $this->db->get_where('login', ['username' => $this->session->userdata('username')])->row_array();
    
        // Ambil siswa dengan status 'pending'
        $this->db->select('data_siswa.*, login.email, login.username, kelas.nama_kelas');
        $this->db->from('data_siswa');
        $this->db->join('login', 'login.id = data_siswa.id_login');
        $this->db->join('kelas', 'kelas.id_kelas = data_siswa.id_kelas', 'left');
        $this->db->where('data_siswa.status_pendaftaran', 'pending');
        $data['siswa_pending'] = $this->db->get()->result_array();
    
        // Ambil daftar kelas untuk dropdown saat konfirmasi
        $data['kelas'] = $this->db->get('kelas')->result_array();
    
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('kepsek/pendaftaran', $data);
        $this->load->view('templates/footer');
    }

    public function konfirmasipendaftaran() {
        if ($this->session->userdata('role') != 'kepsek') {
            redirect('auth2/logout');
        }
    
        $id_siswa = $this->input->post('id_siswa');
        $action = $this->input->post('action'); // 'approve' atau 'reject'
        $id_kelas_baru = $this->input->post('id_kelas_baru'); // Jika disetujui, bisa pilih kelas baru
    
        // Ambil data siswa dan login terkait
        $siswa = $this->db->get_where('data_siswa', ['id_siswa' => $id_siswa])->row_array();
        if (!$siswa) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Siswa tidak ditemukan.</div>');
            redirect('kepsek/pendaftaran');
        }
    
        $this->db->trans_start(); // Mulai transaksi
    
        try {
            if ($action == 'approve') {
                $data_update_siswa = [
                    'status_pendaftaran' => 'approved',
                    'id_kelas' => $id_kelas_baru, // Update dengan kelas yang disetujui (bisa sama atau beda)
                ];
                $this->db->where('id_siswa', $id_siswa)->update('data_siswa', $data_update_siswa);
    
                // Aktifkan akun login siswa
                $this->db->where('id', $siswa['id_login'])->update('login', ['is_active' => 1]);
    
                $this->session->set_flashdata('message', '<div class="alert alert-success">Pendaftaran siswa berhasil disetujui.</div>');
    
            } elseif ($action == 'reject') {
                $data_update_siswa = [
                    'status_pendaftaran' => 'rejected',
                    // Anda bisa menambahkan kolom 'catatan_penolakan' jika ingin kepala sekolah memberikan alasan
                ];
                $this->db->where('id_siswa', $id_siswa)->update('data_siswa', $data_update_siswa);
    
                // Opsional: Hapus akun login jika pendaftaran ditolak (hati-hati dengan ini)
                // $this->db->where('id', $siswa['id_login'])->delete('login');
                // $this->db->where('id_siswa', $id_siswa)->delete('data_siswa');
    
                $this->session->set_flashdata('message', '<div class="alert alert-warning">Pendaftaran siswa berhasil ditolak.</div>');
    
            } else {
                throw new Exception('Aksi tidak valid.');
            }
    
            $this->db->trans_complete();
    
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Gagal memproses konfirmasi.');
            }
    
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>');
        }
    
        redirect('kepsek/pendaftaran');
    }

    public function laporan()
    {
        $data['title'] = 'Laporan Pembayaran';
        $data['user']  = $this->db->get_where('login', ['username' => $this->session->userdata('username')])->row_array();

        if ($this->session->userdata('role') == 'kepsek') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('kepsek/laporan', $data);
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

        if ($this->session->userdata('role') == 'kepsek') {
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

?>