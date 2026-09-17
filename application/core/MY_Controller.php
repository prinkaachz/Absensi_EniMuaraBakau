<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    protected $current_user;

    public function __construct()
    {
        parent::__construct();
        $this->current_user = $this->session->userdata('user');
    }

    protected function require_login($roles = array())
    {
        if (!$this->current_user) redirect('login');
        if ($roles && !in_array($this->current_user['role'], $roles, true)) show_error('Anda tidak memiliki akses ke halaman ini.', 403, 'Akses Ditolak');
    }

    protected function render($view, $data = array())
    {
        $data['user'] = $this->current_user;
        $data['notification_count'] = $this->db->where(array('user_id' => $this->current_user['id'], 'is_read' => 0))->count_all_results('notifications');
        $this->load->view('layouts/header', $data);
        $this->load->view($view, $data);
        $this->load->view('layouts/footer');
    }
}
