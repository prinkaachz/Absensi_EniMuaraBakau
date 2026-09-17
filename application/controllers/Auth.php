<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function login()
    {
        if ($this->session->userdata('user')) redirect('dashboard');
        if ($this->input->method() === 'post') {
            $this->load->model('User_model');
            $user = $this->User_model->authenticate(trim($this->input->post('username')), $this->input->post('password'));
            if ($user) { $this->session->set_userdata('user', $user); redirect('dashboard'); }
            $data['error'] = 'Username atau kata sandi tidak tepat.';
        }
        $this->load->view('auth/login', isset($data) ? $data : array());
    }
    public function logout()
    {
        if (!$this->session->userdata('user')) redirect('login');
        if ($this->input->method() !== 'post') {
            $this->load->view('auth/confirm_logout');
            return;
        }
        if (!hash_equals((string) $this->session->userdata('logout_token'), (string) $this->input->post('logout_token')) || !$this->session->userdata('logout_token')) {
            show_error('Konfirmasi keluar tidak valid. Muat ulang halaman.', 403);
        }
        $this->session->sess_destroy();
        redirect('login');
    }
}
