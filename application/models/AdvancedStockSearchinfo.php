<?php

class AdvancedStockSearchinfo extends CI_Model {
    public function Suppliearget() {

        $this->db->select('suppliername, idtbl_supplier');
        $this->db->from('tbl_supplier');
        $this->db->where('status', 1);

		$respond=$this->db->get();
        return $respond;

    }
    
}