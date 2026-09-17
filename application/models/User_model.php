<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function authenticate($username, $password)
    {
        $user = $this->db->where('username', $username)->where('is_active', 1)->get('users')->row_array();
        if ($user && password_verify($password, $user['password'])) { unset($user['password']); return $user; }
        return false;
    }

    public function employees($search = '')
    {
        $this->db->select('pegawai.*, users.username')->from('pegawai')->join('users', 'users.id = pegawai.user_id');
        if ($search !== '') $this->db->group_start()->like('pegawai.nama', $search)->or_like('pegawai.nik', $search)->or_like('pegawai.jabatan', $search)->group_end();
        return $this->db->order_by('pegawai.nama')->get()->result_array();
    }
    public function employee($id) { return $this->db->get_where('pegawai', array('id' => $id))->row_array(); }
    public function employee_by_user($user_id) { return $this->db->get_where('pegawai', array('user_id' => $user_id))->row_array(); }
}
