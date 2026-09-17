<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activities extends MY_Controller
{
    public function __construct() { parent::__construct(); $this->require_login(array('pegawai')); $this->load->model(array('User_model', 'Activity_model')); }
    public function index()
    {
        $employee = $this->User_model->employee_by_user($this->current_user['id']);
        $data = array('title' => 'Aktivitas Saya', 'employee' => $employee, 'activities' => $this->Activity_model->employee_activities($employee['id'], array('search' => $this->input->get('q'))), 'notification_count' => $this->db->where(array('user_id' => $this->current_user['id'], 'is_read' => 0))->count_all_results('notifications'));
        $this->render('activities/index', $data);
    }
    public function save()
    {
        $employee = $this->User_model->employee_by_user($this->current_user['id']);
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required'); $this->form_validation->set_rules('jenis', 'Jenis', 'required'); $this->form_validation->set_rules('sub_status', 'Sub kategori', 'required'); $this->form_validation->set_rules('kegiatan', 'Kegiatan', 'required|min_length[5]');
        if (!$this->form_validation->run()) { $this->session->set_flashdata('toast_error', validation_errors('', '')); redirect('aktivitas'); }
        $document = $this->upload_document();
        if ($document === false) redirect('aktivitas');
        $payload = array('tanggal' => $this->input->post('tanggal'), 'jenis' => $this->input->post('jenis'), 'sub_status' => $this->input->post('sub_status'), 'kegiatan' => $this->input->post('kegiatan'), 'id_pegawai' => $employee['id']);
        if ($document) $payload['dokumen'] = $document;
        $id = (int) $this->input->post('id');
        $ok = $id ? $this->Activity_model->update_pending($id, $employee['id'], $payload) : $this->Activity_model->create($payload);
        $this->session->set_flashdata($ok ? 'toast_success' : 'toast_error', $ok ? ($id ? 'Pengajuan berhasil diperbarui.' : 'Pengajuan berhasil dikirim untuk approval.') : 'Pengajuan tidak dapat diubah karena sudah diproses.'); redirect('aktivitas');
    }
    public function delete($id)
    {
        $employee = $this->User_model->employee_by_user($this->current_user['id']); $ok = $this->Activity_model->delete_pending($id, $employee['id']);
        $this->session->set_flashdata($ok ? 'toast_success' : 'toast_error', $ok ? 'Pengajuan berhasil dihapus.' : 'Data terkunci dan tidak dapat dihapus.'); redirect('aktivitas');
    }
    private function upload_document()
    {
        if (empty($_FILES['dokumen']['name'])) return null;
        $upload_path = FCPATH . 'assets/uploads/';
        if (!is_dir($upload_path) && !mkdir($upload_path, 0733, true)) {
            $this->session->set_flashdata('toast_error', 'Folder dokumen belum siap. Hubungi administrator.');
            return false;
        }
        $config = array('upload_path' => $upload_path, 'allowed_types' => 'pdf|jpg|jpeg|png', 'max_size' => 4096, 'encrypt_name' => true);
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('dokumen')) { $this->session->set_flashdata('toast_error', strip_tags($this->upload->display_errors())); return false; }
        return $this->upload->data('file_name');
    }
}
