<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth2 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model', '', true);
        $this->load->library('session');
    }

    public function index()
    {
        if ($this->session->userdata('role') == 'kepsek') {
            redirect('kepsek');
        }else if($this->session->userdata('role') == 'admin') {
            redirect('admin');
        } else if ($this->session->userdata('role') == 'user') {
            redirect('user');
        } else {
            $data['title'] = 'Login Page';
            $this->load->view('auth/login', $data);
        }
    }

    public function login()
    {
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('nama');

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->Login_model->login($username, $password, PASSWORD_DEFAULT);

        if ($user) {
            $this->session->set_userdata('id', $user->id);
            $this->session->set_userdata('username', $user->username);
            $this->session->set_userdata('email', $user->email);
            $this->session->set_userdata('role', $user->role);
            $this->session->set_userdata('nama', $user->nama);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Login success!</div>');
            if ($user->role == 'kepsek') {
                redirect('kepsek');
            } else if($user->role == 'admin') {
                redirect('admin');
            } else if ($user->role == 'user') {
                $data_siswa = $this->db->get_where('data_siswa', ['id_login' => $user->id])->row();
                if ($data_siswa) {
                    if (empty($this->db->get_where('data_ortu', ['id_siswa' => $data_siswa->id_siswa])->row())) {
                        $this->db->insert('data_ortu', ['id_siswa' => $data_siswa->id_siswa]);
                    }
                }

                redirect('user');
            } else {
                redirect('auth2');
            }
        } else {
            $this->session->set_flashdata('error', 'Username atau password salah');
            $data['title'] = 'Login Page';
            $this->load->view('auth/login', $data);
        }
    }

    public function registration()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim', [
            'required' => 'Name is required.',
        ]);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[login.email]', [
            'is_unique' => 'This email has already registered!',
        ]);
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[login.username]', [
            'is_unique' => 'This username has already registered!',
        ]);
        $this->form_validation->set_rules(
            'password1',
            'Password',
            'required|trim|min_length[6]|matches[password2]|regex_match[/[!@#$%^&*(),.?":{}|<>]/]',
            [
                'matches'      => 'Password dont match!',
                'min_length'   => 'Password Minimum 6 characters!',
                'regex_match'  => 'Password must contain at least one symbol (e.g. !@#$%).',
            ]
        );
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Registration Page';
            $this->load->view('auth/registration', $data);
        } else {
            $data = [
                'nama'     => htmlspecialchars($this->input->post('nama', true)),
                'email'    => htmlspecialchars($this->input->post('email', true)),
                'image'    => 'default.jpg',
                'username' => htmlspecialchars($this->input->post('username', true)),
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role'     => 'user',
            ];
            $this->db->insert('login', $data);
            $id_login = $this->db->insert_id();
            $this->db->insert('data_siswa', ['id_login' => $id_login]);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Congratulation! your account has been created. Please Login!</div>');
            redirect('auth2/login');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('nama');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logged out!</div>');
        redirect('auth2');
    }
}