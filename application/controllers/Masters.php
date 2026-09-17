<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Masters extends MY_Controller {
 private $map=array(
  'users'=>array('title'=>'User','table'=>'users','pk'=>'user_id','roles'=>array('Admin'),'fields'=>array('role_id'=>'Role','name'=>'Nama','username'=>'Username','password'=>'Password','status'=>'Status')),
  'agreements'=>array('title'=>'Master Agreement','table'=>'master_agreements','pk'=>'agreement_id','roles'=>array('Admin'),'fields'=>array('agreement_number'=>'Nomor Kontrak','agreement_name'=>'Nama Kontrak','year'=>'Tahun','start_date'=>'Tanggal Mulai','end_date'=>'Tanggal Berakhir','status'=>'Status')),
  'items'=>array('title'=>'Master Item','table'=>'master_items','pk'=>'master_item_id','roles'=>array('Admin'),'fields'=>array('part_number'=>'Part Number','description'=>'Description','uom'=>'UOM')),
  'boqs'=>array('title'=>'BOQ','table'=>'boqs','pk'=>'boq_id','roles'=>array('Admin'),'fields'=>array('agreement_id'=>'Master Agreement','master_item_id'=>'Master Item','unit_price'=>'Unit Price')),
  'cost-centres'=>array('title'=>'Cost Centre','table'=>'cost_centres','pk'=>'cost_centre_id','roles'=>array('Admin'),'fields'=>array('cost_centre_code'=>'Kode','cost_centre_name'=>'Nama Cost Centre'))
 );
 public function __construct(){parent::__construct();$this->load->model('Finance_model','finance');}
 private function cfg($key){if(!isset($this->map[$key]))show_404(); return $this->map[$key];}
 public function index($key){$c=$this->cfg($key);$this->require_login($c['roles']);$this->render('masters/index',array('title'=>$c['title'],'key'=>$key,'cfg'=>$c,'rows'=>$this->finance->master_rows($key)));}
 public function create($key){$c=$this->cfg($key);$this->require_login($c['roles']);if($this->input->method()==='post'){$data=$this->data($key);if($key==='users')$data['password']=password_hash($data['password'],PASSWORD_DEFAULT);$this->db->insert($c['table'],$data);flash('success',$c['title'].' berhasil ditambahkan.');redirect('masters/'.$key);} $this->form($key,$c);}
 public function edit($key,$id){$c=$this->cfg($key);$this->require_login($c['roles']);$row=$this->db->where($c['pk'],$id)->get($c['table'])->row();if(!$row)show_404();if($this->input->method()==='post'){$data=$this->data($key);if($key==='users'){if(empty($data['password']))unset($data['password']);else $data['password']=password_hash($data['password'],PASSWORD_DEFAULT);}$this->db->where($c['pk'],$id)->update($c['table'],$data);flash('success',$c['title'].' berhasil diperbarui.');redirect('masters/'.$key);} $this->form($key,$c,$row);}
 private function data($key){$d=array();foreach($this->map[$key]['fields'] as $field=>$label)$d[$field]=$this->input->post($field,TRUE);return $d;}
 private function form($key,$cfg,$row=NULL){$options=array();if($key==='users')$options['role_id']=$this->finance->options('roles','role_id','role_name');if($key==='boqs'){$options['agreement_id']=$this->finance->options('master_agreements','agreement_id','agreement_number',array('status'=>'Active'));$options['master_item_id']=$this->finance->options('master_items','master_item_id','part_number');}$this->render('masters/form',array('title'=>$cfg['title'],'key'=>$key,'cfg'=>$cfg,'row'=>$row,'options'=>$options));}
}
