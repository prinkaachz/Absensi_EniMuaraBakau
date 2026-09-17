<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approval extends MY_Controller
{
    public function __construct() { parent::__construct(); $this->require_login(array('atasan')); $this->load->model('Activity_model'); }
    public function index()
    {
        $data = array('title' => 'Review Pengajuan', 'activities' => $this->Activity_model->all(array('search' => $this->input->get('q'), 'status' => $this->input->get('status'), 'date' => $this->input->get('tanggal')))); $this->render('approval/index', $data);
    }
    public function detail($id) { $data = array('title' => 'Detail Pengajuan', 'activity' => $this->Activity_model->find($id)); if (!$data['activity']) show_404(); $this->render('approval/detail', $data); }
    public function decide($id)
    {
        $decision = $this->input->post('decision'); $note = trim($this->input->post('catatan_reject'));
        if (!in_array($decision, array('Approved', 'Rejected'), true) || ($decision === 'Rejected' && $note === '')) { $this->session->set_flashdata('toast_error', 'Catatan reject wajib diisi.'); redirect('approval/detail/' . $id); }
        $activity = $this->Activity_model->find($id); if (!$activity) show_404();
        $ok = $this->Activity_model->decide($id, array('status_approval' => $decision, 'catatan_reject' => $decision === 'Rejected' ? $note : null, 'id_approver' => $this->current_user['id'], 'approved_at' => date('Y-m-d H:i:s')));
        if ($ok) {
            $user_id = $this->db->select('user_id')->get_where('pegawai', array('id' => $activity['id_pegawai']))->row()->user_id;
            $this->db->insert('notifications', array('user_id' => $user_id, 'title' => 'Status pengajuan diperbarui', 'message' => 'Pengajuan ' . $activity['jenis'] . ' tanggal ' . date('d/m/Y', strtotime($activity['tanggal'])) . ' telah ' . strtolower($decision) . '.', 'type' => strtolower($decision)));
        }
        $this->session->set_flashdata($ok ? 'toast_success' : 'toast_error', $ok ? 'Keputusan berhasil disimpan.' : 'Pengajuan sudah diproses sebelumnya.'); redirect('approval');
    }
}
