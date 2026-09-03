<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Stocklistreportinfo extends CI_Model{


public function MaterialGroupget(){

$this->db->select('idtbl_material_group,group');
$this->db->where('status',1);
return $this->db->get('tbl_material_group');

}


}