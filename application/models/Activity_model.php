<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_model extends CI_Model
{
    private function base_query()
    {
        $this->db->select('aktivitas.*, pegawai.nama, pegawai.jabatan, approver.nama AS nama_approver')->from('aktivitas')->join('pegawai', 'pegawai.id = aktivitas.id_pegawai')->join('users approver', 'approver.id = aktivitas.id_approver', 'left');
    }
    public function employee_activities($employee_id, $filters = array())
    {
        $this->base_query(); $this->db->where('id_pegawai', $employee_id);
        if (!empty($filters['search'])) $this->db->group_start()->like('jenis', $filters['search'])->or_like('kegiatan', $filters['search'])->group_end();
        if (!empty($filters['start'])) $this->db->where('tanggal >=', $filters['start']);
        if (!empty($filters['end'])) $this->db->where('tanggal <=', $filters['end']);
        return $this->db->order_by('tanggal', 'DESC')->get()->result_array();
    }
    public function all($filters = array())
    {
        $this->base_query();
        if (!empty($filters['search'])) $this->db->group_start()->like('pegawai.nama', $filters['search'])->or_like('aktivitas.jenis', $filters['search'])->group_end();
        if (!empty($filters['status'])) $this->db->where('status_approval', $filters['status']);
        if (!empty($filters['date'])) $this->db->where('tanggal', $filters['date']);
        return $this->db->order_by("FIELD(status_approval, 'Not Approved', 'Rejected', 'Approved')")->order_by('tanggal', 'DESC')->get()->result_array();
    }
    public function find($id) { $this->base_query(); return $this->db->where('aktivitas.id', $id)->get()->row_array(); }
    public function create($data) { return $this->db->insert('aktivitas', $data); }
    public function update_pending($id, $employee_id, $data) { return $this->db->where(array('id' => $id, 'id_pegawai' => $employee_id, 'status_approval' => 'Not Approved'))->update('aktivitas', $data); }
    public function delete_pending($id, $employee_id) { return $this->db->where(array('id' => $id, 'id_pegawai' => $employee_id, 'status_approval' => 'Not Approved'))->delete('aktivitas'); }
    public function decide($id, $data) { return $this->db->where(array('id' => $id, 'status_approval' => 'Not Approved'))->update('aktivitas', $data); }
    public function count_status($employee_id) { return $this->db->select('status_approval, COUNT(*) as total')->where('id_pegawai', $employee_id)->group_by('status_approval')->get('aktivitas')->result_array(); }
}
