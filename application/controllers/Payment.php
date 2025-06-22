<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/midtrans/midtrans-php/Midtrans.php';

class Payment extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->model('Payment_model', '', true);
        // $this->load->library('session');
    }

    public function index()
    {
        if ($this->session->userdata('role') == 'admin') {
            redirect('admin');
        } else if ($this->session->userdata('role') == 'user') {
            redirect('user');
        } else {
            redirect('auth2');
        }
    }
    public function manual_pay()
    {
        $id = $this->session->userdata('id');
        $siswa = $this->db->get_where('data_siswa', ['id_login' => $id])->row_array();

        $data['title'] = 'Pembayaran Manual';
        $data['user'] = $this->db->get_where('login', ['username' => $this->session->userdata('username')])->row_array();
        $data['siswa'] = $siswa;
        $data['ortu'] = $this->db->get_where('data_ortu', ['id_siswa' => $siswa['id_siswa']])->row_array();
        $data['tagihan'] = $this->db->get_where('pembayaran', ['id_siswa' => $siswa['id_siswa']])->row_array();

        if ($this->session->userdata('role') == 'user') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);

            if ($siswa['nik'] == 0 || $data['ortu']['nik_ayah'] == 0) {
                $data['judul'] = 'Lengkapi Data Dulu';
                $this->load->view('user/no_data', $data);
            } else {
                $this->load->view('user/byr_manual', $data);
            }

            $this->load->view('templates/footer');
        } else {
            redirect('auth2');
        }
    }

    public function upload_bukti()
    {
        $id_pembayaran = $this->input->post('id_pembayaran');
        $config['upload_path'] = './assets/img/bukti/';
        $config['allowed_types'] = 'jpg|png|jpeg|pdf';
        $config['max_size'] = 20480;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('bukti')) {
            $upload_data = $this->upload->data();
            $original_name = pathinfo($upload_data['file_name'], PATHINFO_FILENAME);
            $extension = $upload_data['file_ext'];
            $timestamp = time();

            $new_filename = $original_name . '_' . $timestamp . $extension;
            $old_path = $upload_data['full_path'];
            $new_path = $upload_data['file_path'] . $new_filename;

            // Rename file
            rename($old_path, $new_path);

            // Simpan nama baru ke DB
            $this->db->set('bukti', $new_filename);
            $this->db->set('status', 'menunggu');
            $this->db->set('metode', 'manual');
            $this->db->set('tgl_bayar', date('Y-m-d H:i:s'));
            $this->db->where('id_pembayaran', $id_pembayaran);
            $this->db->update('pembayaran');

            $this->session->set_flashdata('message', '<div class="alert alert-success">Bukti berhasil diupload.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">' . $this->upload->display_errors() . '</div>');
        }


        redirect('user/pembayaran');
    }

    public function acc($id_pembayaran)
    {
        $this->db->set('status', 'sudah');
        $this->db->where('id_pembayaran', $id_pembayaran);
        $this->db->update('pembayaran');

        $this->session->set_flashdata('message', '<div class="alert alert-success">Pembayaran telah disetujui.</div>');
        redirect('admin/pembayaran');
    }

    public function tolak($id_pembayaran)
    {
        $this->db->set('status', 'belum');
        $this->db->set('tgl_bayar', null);
        $this->db->set('bukti', null);
        $this->db->set('metode', null);
        $this->db->where('id_pembayaran', $id_pembayaran);
        $this->db->update('pembayaran');

        $this->session->set_flashdata('message', '<div class="alert alert-danger">Pembayaran telah ditolak.</div>');
        redirect('admin/pembayaran');
    }

    public function midtrans_callback()
    {
        \Midtrans\Config::$serverKey = 'SB-Mid-server-ck2TJTOVPAWZX80ZQ66iYLjk';
        \Midtrans\Config::$isProduction = false;

        $notif = new \Midtrans\Notification();

        $transaction = $notif->transaction_status;
        $order_id = $notif->order_id;
        $type = $notif->payment_type;
        $fraud = $notif->fraud_status;

        if ($transaction == 'settlement' || $transaction == 'capture') {
            $this->db->where('order_id_midtrans', $order_id);
            $this->db->update('pembayaran', ['status' => 'sudah', 'metode' => 'auto', 'tgl_bayar' => date('Y-m-d H:i:s')]);
        }
    }
}
