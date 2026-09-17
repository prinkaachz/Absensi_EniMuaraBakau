<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends MY_Controller
{
    public function __construct() { parent::__construct(); $this->require_login(array('monitoring')); $this->load->model(array('User_model', 'Activity_model')); }
    public function index() { $this->render('monitoring/index', array('title' => 'List Pegawai', 'employees' => $this->User_model->employees($this->input->get('q')))); }
    public function detail($id)
    {
        $employee = $this->User_model->employee($id); if (!$employee) show_404();
        $filters = array('start' => $this->input->get('mulai'), 'end' => $this->input->get('akhir'));
        $this->render('monitoring/detail', array('title' => 'Aktivitas ' . $employee['nama'], 'employee' => $employee, 'activities' => $this->Activity_model->employee_activities($id, $filters), 'filters' => $filters));
    }
    public function report($id)
    {
        $employee = $this->User_model->employee($id); if (!$employee) show_404();
        $filters = array('start' => $this->input->get('mulai') ?: date('Y-m-01'), 'end' => $this->input->get('akhir') ?: date('Y-m-t'));
        $activities = array_filter($this->Activity_model->employee_activities($id, $filters), function($item) { return $item['status_approval'] === 'Approved'; });
        $this->load->library('Pdf');
        $this->pdf->timesheet($employee, $activities, $filters, 'Timesheet-' . url_title($employee['nama'], '-', true) . '.pdf');
    }
}
