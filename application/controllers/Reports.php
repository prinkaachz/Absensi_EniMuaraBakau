<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Reports extends MY_Controller {
 public function __construct(){parent::__construct();$this->load->model('Finance_model','finance');}
 public function index(){$this->require_login(array('PIC Project','Finance','Admin'));$this->render('reports/index',array('title'=>'Report','so'=>$this->finance->so_list(),'po'=>$this->finance->po_list(),'invoice'=>$this->finance->invoice_list()));}
 public function export($type){$this->require_login();$map=array('so'=>array('Service Order',$this->finance->so_list()),'po'=>array('Purchase Order',$this->finance->po_list()),'invoice'=>array('Invoice',$this->finance->invoice_list()));if(!isset($map[$type]))show_404();header('Content-Type: text/csv; charset=utf-8');header('Content-Disposition: attachment; filename="report-'.$type.'.csv"');$out=fopen('php://output','w');fputcsv($out,array_keys((array)$map[$type][1][0] ?? array()));foreach($map[$type][1] as $row)fputcsv($out,(array)$row);fclose($out);}
}
