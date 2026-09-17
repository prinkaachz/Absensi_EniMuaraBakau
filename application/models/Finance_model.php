<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Finance_model extends CI_Model {
    public function login($username, $password) {
        $user = $this->db->select('users.*, roles.role_name')->from('users')->join('roles','roles.role_id=users.role_id')->where(array('username'=>$username,'status'=>'Active'))->get()->row();
        return ($user && password_verify($password, $user->password)) ? $user : FALSE;
    }
    public function dashboard() {
        $sum = function($table, $field) { return (float) ($this->db->select_sum($field)->get($table)->row()->$field ?: 0); };
        return array('so_count'=>$this->db->count_all('service_orders'), 'po_count'=>$this->db->count_all('purchase_orders'), 'invoice_count'=>$this->db->count_all('invoices'), 'budget'=>$sum('service_orders','total_budget'), 'po_value'=>$this->db->select_sum('subtotal')->get('purchase_order_items')->row()->subtotal ?: 0, 'invoice_value'=>$sum('invoices','total_invoice'), 'paid'=>$this->db->where('status','Paid')->select_sum('total_invoice')->get('invoices')->row()->total_invoice ?: 0);
    }
    public function master_rows($key) {
        $tables = array('users'=>array('users','users.user_id','roles','roles.role_id=users.role_id'), 'agreements'=>array('master_agreements','agreement_id'), 'items'=>array('master_items','master_item_id'), 'boqs'=>array('boqs','boq_id'), 'cost-centres'=>array('cost_centres','cost_centre_id'));
        if (!isset($tables[$key])) return array(); $t=$tables[$key]; $q=$this->db->from($t[0]); if(isset($t[2])) $q->select('users.*,roles.role_name')->join($t[2],$t[3]); return $q->order_by($t[1],'DESC')->get()->result();
    }
    public function options($table, $id, $label, $where = array()) { return $this->db->where($where)->order_by($label)->get($table)->result(); }
    public function so_list() { return $this->db->select('s.*,a.agreement_number,c.cost_centre_code,u.name')->from('service_orders s')->join('master_agreements a','a.agreement_id=s.agreement_id')->join('cost_centres c','c.cost_centre_id=s.cost_centre_id')->join('users u','u.user_id=s.created_by')->order_by('s.so_id','DESC')->get()->result(); }
    public function po_list() { return $this->db->select('p.*,u.name,COALESCE(SUM(i.subtotal),0) total')->from('purchase_orders p')->join('users u','u.user_id=p.created_by')->join('purchase_order_items i','i.po_id=p.po_id','left')->group_by('p.po_id')->order_by('p.po_id','DESC')->get()->result(); }
    public function invoice_list() { return $this->db->select('i.*,p.po_number,u.name')->from('invoices i')->join('purchase_orders p','p.po_id=i.po_id')->join('users u','u.user_id=i.created_by')->order_by('i.invoice_id','DESC')->get()->result(); }
    public function available_so_details($so_id = NULL) { $q=$this->db->select('d.*,s.so_number,b.unit_price,m.part_number,m.description,m.uom,(d.qty_plan-COALESCE(SUM(p.qty),0)) remaining')->from('service_order_details d')->join('service_orders s','s.so_id=d.so_id')->join('boqs b','b.boq_id=d.boq_id')->join('master_items m','m.master_item_id=b.master_item_id')->join('purchase_order_items p','p.so_detail_id=d.so_detail_id','left')->where('s.status','Approved')->group_by('d.so_detail_id')->having('remaining >',0); if($so_id)$q->where('s.so_id',$so_id); return $q->get()->result(); }
    public function po_items($po_id) { return $this->db->select('i.*,d.unit_price,m.part_number,m.description,m.uom')->from('purchase_order_items i')->join('service_order_details d','d.so_detail_id=i.so_detail_id')->join('boqs b','b.boq_id=d.boq_id')->join('master_items m','m.master_item_id=b.master_item_id')->where('i.po_id',$po_id)->get()->result(); }
}
