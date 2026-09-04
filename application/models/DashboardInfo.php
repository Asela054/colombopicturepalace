<?php
class DashboardInfo extends CI_Model{
    public function DashMaterialInfo(){
        $company = $_SESSION['company_id'];

        $sql = "SELECT COUNT(`idtbl_print_stock`) AS stockcount 
                FROM `tbl_print_stock` 
                LEFT JOIN `tbl_print_material_info` 
                ON `tbl_print_material_info`.`idtbl_print_material_info` = `tbl_print_stock`.`tbl_print_material_info_idtbl_print_material_info`
                WHERE `tbl_print_stock`.`status` = 1 
                AND `tbl_print_stock`.`tbl_print_material_info_idtbl_print_material_info`
                AND `tbl_print_stock`.`tbl_company_idtbl_company` = ?";
        $materialinfo = $this->db->query($sql, array($company));
        return $materialinfo;
    }

    public function DashZeroStockInfo(){
        $company = $_SESSION['company_id'];

        $sql = "SELECT COUNT(`idtbl_print_stock`) AS stockcount 
            FROM `tbl_print_stock` 
            LEFT JOIN `tbl_print_material_info`
            ON `tbl_print_material_info`.`idtbl_print_material_info`= `tbl_print_stock`.`tbl_print_material_info_idtbl_print_material_info`
            WHERE `tbl_print_stock`.`status` = 1
            AND `tbl_print_stock`.`qty` = 0 
            AND `tbl_print_stock`.`tbl_print_material_info_idtbl_print_material_info` 
            AND `tbl_print_stock`.`tbl_company_idtbl_company` = ?";
        $zerostockinfo=$this->db->query($sql, array($company));
        return $zerostockinfo;
    }

    public function DashLowStockInfo(){
        $company = $_SESSION['company_id'];

        $sql="SELECT COUNT(`idtbl_print_stock`) AS stockcount 
        	  FROM `tbl_print_stock` LEFT JOIN `tbl_print_material_info` 
        	  ON `tbl_print_material_info`.`idtbl_print_material_info`= `tbl_print_stock`.`tbl_print_material_info_idtbl_print_material_info`
        	  WHERE `tbl_print_stock`.`status` = 1 
        	  AND `tbl_print_stock`.`tbl_print_material_info_idtbl_print_material_info` <> 0 
        	  AND `tbl_print_stock`.`qty` < `tbl_print_material_info`.`reorderlevel`
        	  AND `tbl_print_stock`.`tbl_company_idtbl_company` = ?";
        $lowstockinfo = $this->db->query($sql, array($company));
        return $lowstockinfo;
    }

    public function DashLastFiveInfo(){
        $company = $_SESSION['company_id'];

        $sql="SELECT m.materialname, g.date, g.qty, g.unitprice, g.total 
        	  FROM tbl_print_grndetail g LEFT JOIN tbl_print_grn gd ON gd.idtbl_print_grn=g.tbl_print_grn_idtbl_print_grn INNER JOIN tbl_print_material_info m 
        	  ON g.tbl_print_material_info_idtbl_print_material_info = m.idtbl_print_material_info 
        	  WHERE g.status = 1 AND gd.approvestatus=1 AND gd.tbl_company_idtbl_company=$company AND g.tbl_print_material_info_idtbl_print_material_info <> 0 ORDER BY g.date DESC LIMIT 5";
        $resultdate = $this->db->query($sql);
        return $resultdate;
    }

    public function DashTopFiveInfo(){
        $company = $_SESSION['company_id'];

        $sql="SELECT m.materialname, g.date, g.qty, g.unitprice, g.total FROM tbl_print_grndetail g LEFT JOIN tbl_print_grn gd ON gd.idtbl_print_grn=g.tbl_print_grn_idtbl_print_grn INNER JOIN tbl_print_material_info m ON g.tbl_print_material_info_idtbl_print_material_info = m.idtbl_print_material_info WHERE g.status = 1 AND gd.approvestatus=1 AND gd.tbl_company_idtbl_company=$company AND g.tbl_print_material_info_idtbl_print_material_info <> 0 ORDER BY g.qty DESC LIMIT 5 ";
        $resultqty = $this->db->query($sql);
        return $resultqty;
    }

    public function DashNonMoveInfo(){
        $company = $_SESSION['company_id'];

        $sql="SELECT m.materialname, g.grndate, g.qty, g.unitprice, g.total FROM tbl_print_stock g INNER JOIN tbl_print_material_info m ON g.tbl_print_material_info_idtbl_print_material_info = m.idtbl_print_material_info WHERE g.status = 1 AND g.tbl_company_idtbl_company=$company AND g.tbl_print_material_info_idtbl_print_material_info <> 0 AND (g.updatedatetime IS NULL OR g.updatedatetime > g.grndate) <> 0 ORDER BY g.qty DESC LIMIT 5";
        $resultnonmove = $this->db->query($sql);
        return $resultnonmove;
    }
}