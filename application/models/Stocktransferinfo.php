<?php
class Stocktransferinfo extends CI_Model{
    public function Getlocation(){
        $this->db->select('`idtbl_location`, `location`');
        $this->db->from('tbl_location');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getproductlist(){
        $locationId = $this->input->post('locationId');

        $sql="SELECT `tbl_print_material_info`.`materialinfocode`, `tbl_print_material_info`.`materialname`, `tbl_print_material_info`.`idtbl_print_material_info` FROM `tbl_print_stock` LEFT JOIN `tbl_print_material_info` ON `tbl_print_material_info`.`idtbl_print_material_info`=`tbl_print_stock`.`tbl_print_material_info_idtbl_print_material_info`  WHERE `tbl_print_stock`.`location`=? AND `tbl_print_stock`.`status`=?";
        $respond=$this->db->query($sql, array($locationId, 1));

        echo json_encode($respond->result());
    }

    public function Getbatchlist(){
        $productId = $this->input->post('productId');
        $fromlocation = $this->input->post('fromlocation');
    
        $sql="SELECT `tbl_print_stock`.`idtbl_print_stock`,`tbl_print_stock`.`batchno`, SUM(`qty`) AS totalqty FROM `tbl_print_stock`  WHERE `tbl_print_stock`.`tbl_print_material_info_idtbl_print_material_info`=? AND `tbl_print_stock`.`status`=? AND `tbl_print_stock`.`location`=? GROUP BY `tbl_print_stock`.`batchno`";
        $respond=$this->db->query($sql, array($productId, 1, $fromlocation));
    
        echo json_encode($respond->result());
    }

   
    public function Stocktransferprocess() {
        $this->db->trans_begin();
    
        $userID = $_SESSION['userid'];
        $comapnyID=$_SESSION['company_id'];
		$branchID=$_SESSION['branch_id'];

        $tableData = $this->input->post('tableData');
        $fromlocation = $this->input->post('fromlocation');
        $tolocation = $this->input->post('tolocation');
        $hiddenbatchid = $this->input->post('hiddenbatchid');
        $insertdatetime = date('Y-m-d H:i:s');
        $updatedatetime = date('Y-m-d H:i:s');
        $transdate = date('Y-m-d');
    
        foreach ($tableData as $rowtabledata) {
            $batchnos = explode(',', $rowtabledata['col_7']);
            $totalQty = $rowtabledata['col_8'];
    
            $this->db->select('batchno, qty');
            $this->db->from('tbl_print_stock');
            $this->db->where('tbl_print_material_info_idtbl_print_material_info', $rowtabledata['col_6']);
            $this->db->where('location', $rowtabledata['col_2']);
            $this->db->where_in('batchno', $batchnos);
            $this->db->where('status', 1);
    
            $respondstock = $this->db->get();
            $orderqty = $totalQty;
    
            $transID = null;
    
            foreach ($respondstock->result() as $rowstocklist) {
                if ($orderqty > 0) {
                    $batchno2 = $rowstocklist->batchno;
                    $availableqty = $rowstocklist->qty;
    
                    if ($availableqty >= $orderqty) {
                        $dedqty = $orderqty;
                        $availableqty -= $dedqty;
                        $orderqty = 0;
                    } else {
                        $dedqty = $availableqty;
                        $orderqty -= $dedqty;
                        $availableqty = 0;
                    }
    
                    $datastockupdate = array(
                        'qty' => $availableqty,
                        'updateuser' => $userID,
                        'updatedatetime' => $updatedatetime
                    );
    
                    $this->db->where('batchno', $batchno2);
                    $this->db->where('tbl_print_material_info_idtbl_print_material_info', $rowtabledata['col_6']);
                    $this->db->where('location', $rowtabledata['col_2']);
                    $this->db->update('tbl_print_stock', $datastockupdate);
    
                    $datastockupdatetolocation = array(
                        'batchno' => $batchno2,
                        'qty' => $dedqty,
                        'status' => '1',
                        'insertdatetime' => $insertdatetime,
                        'tbl_user_idtbl_user' => $userID,
                        'tbl_company_idtbl_company'=> $comapnyID, 
                        'tbl_company_branch_idtbl_company_branch'=> $branchID,
                        'tbl_print_material_info_idtbl_print_material_info' => $rowtabledata['col_6'],
                        'location' => $rowtabledata['col_4']
                    );
    
                    $this->db->insert('tbl_print_stock', $datastockupdatetolocation);
    
                    if ($transID === null) {
                        $data = array(
                            'date' => $transdate,
                            'approvestatus' => '0',
                            'approveuser' => '0',
                            'status' => '1',
                            'insertdatetime' => $insertdatetime,
                            'fromlocation' => $rowtabledata['col_2'],
                            'tolocation' => $rowtabledata['col_4'],
                            'tbl_user_idtbl_user' => $userID,
                            'tbl_company_idtbl_company'=> $comapnyID, 
                            'tbl_company_branch_idtbl_company_branch'=> $branchID,
                        );
    
                        $this->db->insert('tbl_transfer_material', $data);
                        $transID = $this->db->insert_id();
                    }
    
                    $dataone = array(
                        'batchno' => $batchno2,
                        'qty' => $dedqty,
                        'status' => '1',
                        'insertdatetime' => $insertdatetime,
                        'tbl_transfer_material_idtbl_transfer_material' => $transID,
                        'tbl_print_material_info_idtbl_print_material_info' => $rowtabledata['col_6']
                    );
                    $this->db->insert('tbl_transfer_material_detail', $dataone);
    
                    if ($orderqty == 0) {
                        break;
                    }
                } else {
                    break;
                }
            }
        }
    
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-save';
            $actionObj->title = '';
            $actionObj->message = 'Record Added Successfully';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'success';
    
            $actionJSON = json_encode($actionObj);
    
            $obj = new stdClass();
            $obj->status = 1;
            $obj->action = $actionJSON;
    
            echo json_encode($obj);
        } else {
            $this->db->trans_rollback();
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-exclamation-triangle';
            $actionObj->title = '';
            $actionObj->message = 'Record Error';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'danger';
    
            $actionJSON = json_encode($actionObj);
    
            $obj = new stdClass();
            $obj->status = 0;
            $obj->action = $actionJSON;
    
            echo json_encode($obj);
        }
    }    
}
