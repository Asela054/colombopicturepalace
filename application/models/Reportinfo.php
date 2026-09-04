<?php

class Reportinfo extends CI_Model {

    public function Categoryget() {

        $this->db->select('group, idtbl_material_group');
        $this->db->from('tbl_material_group');
        $this->db->where('status', 1);

		$respond=$this->db->get();
        return $respond;

    }

    public function stockReport() {

        $category  = $this->input->post('category'); // material group id
        $companyID = $_SESSION['company_id'];

        $this->db->select('
            tbl_print_stock.idtbl_print_stock,
            tbl_print_stock.batchno,
            tbl_location.location,
            tbl_warehouse.wh_name,
            tbl_print_stock.qty,
            tbl_print_stock.unitprice,
            tbl_print_stock.total,
            tbl_print_material_info.materialname,
            tbl_measurements.measure_type,
            tbl_material_group.group
        ');

        $this->db->from('tbl_print_stock');

        $this->db->join('tbl_location',
            'tbl_location.idtbl_location = tbl_print_stock.location', 'left');

        $this->db->join('tbl_warehouse',
            'tbl_warehouse.idtbl_warehouse = tbl_print_stock.warehouse_id', 'left');

        $this->db->join('tbl_print_material_info',
            'tbl_print_material_info.idtbl_print_material_info =
            tbl_print_stock.tbl_print_material_info_idtbl_print_material_info', 'left');

        $this->db->join('tbl_measurements',
            'tbl_measurements.idtbl_mesurements = tbl_print_stock.measure_type_id', 'left');

        $this->db->join('tbl_material_group',
            'tbl_material_group.idtbl_material_group =
            tbl_print_material_info.tbl_material_group_idtbl_material_group', 'left');

        // Common conditions
        $this->db->where('tbl_print_stock.tbl_company_idtbl_company', $companyID);
        $this->db->where('tbl_print_stock.tbl_print_material_info_idtbl_print_material_info IS NOT NULL', null, false);
        $this->db->where_in('tbl_print_stock.status', [1, 2]);
        $this->db->where('tbl_print_stock.qty >', 0);   // NEW - exclude zero/empty stock rows

        // Category (Material Group) filter
        if ($category != '0' && $category != '') {
            $this->db->where(
                'tbl_print_material_info.tbl_material_group_idtbl_material_group',
                $category
            );
        }

        $query  = $this->db->get();
        $result = $query->result();

        echo json_encode($result);
    }

    
}