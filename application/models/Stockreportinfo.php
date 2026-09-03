<?php
class Stockreportinfo extends CI_Model{
    public function Getlocation(){
        $this->db->select('`idtbl_location`, `location`');
        $this->db->from('tbl_location');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getsupplier(){
        $this->db->select('`idtbl_supplier`, `suppliername`');
        $this->db->from('tbl_supplier');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getordertype(){
        $this->db->select('`idtbl_material_group`, `group`');
        $this->db->from('tbl_material_group');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getproductaccosupplier(){
        $recordID=$this->input->post('recordID');
        $sql="SELECT `idtbl_print_material_info`, `materialinfocode`, `materialname` FROM `tbl_print_material_info` WHERE `tbl_supplier_idtbl_supplier`=?";
        $respond=$this->db->query($sql, array($recordID));

        echo json_encode($respond->result());
    }
}