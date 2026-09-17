<?php defined('BASEPATH') OR exit('No direct script access allowed');

function rupiah($value) { return 'Rp '.number_format((float) $value, 2, ',', '.'); }
function flash($type, $message) { get_instance()->session->set_flashdata($type, $message); }
function role() { return get_instance()->session->userdata('role_name'); }
function is_role($roles) { return in_array(role(), (array) $roles, TRUE); }
