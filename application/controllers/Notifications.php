<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends MY_Controller
{
    public function index()
    {
        $this->require_login();
        $items = $this->db->where('user_id', $this->current_user['id'])
            ->order_by('created_at', 'DESC')->order_by('id', 'DESC')->get('notifications')->result_array();
        // Only mark the displayed records: notifications arriving later stay unread.
        $unread_ids = array();
        foreach ($items as $item) {
            if (!$item['is_read']) {
                $unread_ids[] = (int) $item['id'];
            }
        }
        if ($unread_ids) {
            $this->db->where('user_id', $this->current_user['id'])
                ->where_in('id', $unread_ids)
                ->update('notifications', array('is_read' => 1));
        }
        $this->render('notifications/index', array('title' => 'Notifikasi', 'items' => $items));
    }

    public function read($id)
    {
        $this->require_login();
        $token = $this->session->userdata('notification_token');
        if ($this->input->method() !== 'post' || !$token || !hash_equals($token, (string) $this->input->post('token'))) {
            show_error('Permintaan tidak valid.', 403);
        }
        $this->db->where(array('id' => (int) $id, 'user_id' => $this->current_user['id']))
            ->update('notifications', array('is_read' => 1));
        redirect('notifications');
    }
}
