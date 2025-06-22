<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function login($username, $password)
    {
        $sql   = "SELECT * FROM login WHERE username = ?";
        $query = $this->db->query($sql, [$username]);
        $user  = $query->row();

        if ($user && password_verify($password, $user->password)) {
            return $user;
        }

        return false;
    }
}
