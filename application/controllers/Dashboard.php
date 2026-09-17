<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function index()
    {
        $this->require_login(); $this->load->model(array('User_model', 'Activity_model'));
        if ($this->current_user['role'] === 'pegawai') {
            $employee = $this->User_model->employee_by_user($this->current_user['id']);
            redirect('aktivitas');
        }
        if ($this->current_user['role'] === 'monitoring') redirect('monitoring');
        redirect('approval');
    }
}
