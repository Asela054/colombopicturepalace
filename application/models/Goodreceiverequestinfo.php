<?php
class Goodreceiverequestinfo extends CI_Model{
    public function Getlocation() {
		$this->db->select('`idtbl_location`, `location`');
		$this->db->from('tbl_location');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}

    public function Getemployee(){
        $comapnyID=$_SESSION['company_id'];

        $this->db->select('`id`, `emp_id`, `emp_name_with_initial`');
        $this->db->from('employees');
        $this->db->where('emp_location', $comapnyID);
        $this->db->where('is_resigned', 0);
        $this->db->where('deleted', 0);

        return $respond=$this->db->get();
    }
    public function Getservicetype(){
        $this->db->select('`idtbl_service_type`, `service_name`');
        $this->db->from('tbl_service_type');
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

    public function Getmeasuretype() {
		$this->db->select('`idtbl_mesurements`, `measure_type`');
		$this->db->from('tbl_measurements');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}
	public function getProductsByType() {
		$companyID=$_SESSION['company_id'];
		$branchID=$_SESSION['branch_id'];
		$searchTerm=$this->input->post('searchTerm');
		$ordertype = $this->input->post('ordertype');
		
			if(!isset($searchTerm)){
				$this->db->select('idtbl_print_material_info as id, materialname as name');
				$this->db->where('status', 1);
				$this->db->where('tbl_material_group_idtbl_material_group', $ordertype);
				$this->db->where('tbl_company_idtbl_company', $companyID);
				$this->db->limit(5);
				$query = $this->db->get('tbl_print_material_info');                     
			}
			else{            
				if(!empty($searchTerm)){
					$this->db->select('idtbl_print_material_info as id, materialname as name');
					$this->db->where('status', 1);
					$this->db->where('tbl_material_group_idtbl_material_group', $ordertype);
					$this->db->where('tbl_company_idtbl_company', $companyID);
					$this->db->like('materialname', $searchTerm, 'after');
					$query = $this->db->get('tbl_print_material_info');  
				}
				else{
					$this->db->select('idtbl_print_material_info as id, materialname as name');
					$this->db->where('status', 1);
					$this->db->where('tbl_material_group_idtbl_material_group', $ordertype);
					$this->db->where('tbl_company_idtbl_company', $companyID);
					$this->db->limit(5);
					$query = $this->db->get('tbl_print_material_info');             
				}
			}            
        
		$data=array();
        
        foreach ($query->result() as $row) {
            $data[]=array("id"=>$row->id, "text"=>$row->name);
        }
        
        echo json_encode($data);
    }

    public function Getproductforvehicle(){
        $recordID=$this->input->post('recordID');
        $sql="SELECT `idtbl_service_item_list`, `service_type` FROM `tbl_service_item_list` ";
        $respond=$this->db->query($sql, array($recordID));

        echo json_encode($respond->result());
    }
    public function Getproductformachine(){
        $recordID=$this->input->post('recordID');
        $sql="SELECT `idtbl_machine`, `machine` FROM `tbl_machine`";
        $respond=$this->db->query($sql, array($recordID));

        echo json_encode($respond->result());
    }


    public function Goodreceiverequestinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $tableData=$this->input->post('tableData');
        $company=$this->input->post('company');
        $employee=$this->input->post('employee');
        $reason=$this->input->post('reason');
        $ordertype=$this->input->post('ordertype');

        $updatedatetime=date('Y-m-d H:i:s');

        $data = array(
            'employee_id '=> $employee, 
            'confirmstatus'=> '0',  
            'company_id '=> $company, 
            'status'=> '1', 
            'insertdatetime'=> $updatedatetime, 
            'tbl_user_idtbl_user'=> $userID,
            'tbl_material_group_idtbl_material_group'=> $ordertype
            
        );

        $this->db->insert('tbl_grn_req', $data);

        $porderID=$this->db->insert_id();

        foreach ($tableData as $rowtabledata) {
            $materialname = $rowtabledata['col_1'];
            $uom = $rowtabledata['col_3'];
            $materialID = $rowtabledata['col_4'];
            $qty = $rowtabledata['col_5'];
            $reason = $rowtabledata['col_6'];
        
            $dataone = array(
                'qty' => $qty,
                'comment' => $reason,
                'status' => '1',
                'insertdatetime' => $updatedatetime,
                'tbl_grn_req_idtbl_grn_req' => $porderID,
                'tbl_material_id' => $materialID,
                'tbl_measurements_id' => $uom
            );
        
            $this->db->insert('tbl_grn_req_detail', $dataone);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            
            $actionObj=new stdClass();
            $actionObj->icon='fas fa-save';
            $actionObj->title='';
            $actionObj->message='Record Added Successfully';
            $actionObj->url='';
            $actionObj->target='_blank';
            $actionObj->type='success';

            $actionJSON=json_encode($actionObj);

            $obj=new stdClass();
            $obj->status=1;          
            $obj->action=$actionJSON;  
            
            echo json_encode($obj);
        } else {
            $this->db->trans_rollback();

            $actionObj=new stdClass();
            $actionObj->icon='fas fa-exclamation-triangle';
            $actionObj->title='';
            $actionObj->message='Record Error';
            $actionObj->url='';
            $actionObj->target='_blank';
            $actionObj->type='danger';

            $actionJSON=json_encode($actionObj);

            $obj=new stdClass();
            $obj->status=0;          
            $obj->action=$actionJSON;  
            
            echo json_encode($obj);
        }
    }
    public function Grnorderview(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `u`.*, `ua`.`location` AS `locemail`,  `ub`.`emp_id` AS `empid`,  `ub`.`emp_name_with_initial` AS `employeename`, `uc`.`type` AS `ordertype` FROM `tbl_grn_req` AS `u` LEFT JOIN `tbl_location` AS `ua` ON (`ua`.`idtbl_location` = `u`.`company_id`)  LEFT JOIN `employees` AS `ub` ON (`ub`.`id` = `u`.`employee_id`)  LEFT JOIN `tbl_order_type` AS `uc` ON (`uc`.`idtbl_order_type` = `u`.`tbl_material_group_idtbl_material_group`)WHERE `u`.`status`=? AND `u`.`idtbl_grn_req`=?";
        $respond=$this->db->query($sql, array(1, $recordID));

        $this->db->select('tbl_grn_req_detail.*,tbl_grn_req.tbl_material_group_idtbl_material_group, tbl_print_material_info.materialinfocode, tbl_print_material_info.materialname, tbl_measurements.measure_type');
        $this->db->from('tbl_grn_req_detail');
        $this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_grn_req_detail.tbl_material_id', 'left');
        $this->db->join('tbl_grn_req', 'tbl_grn_req.idtbl_grn_req = tbl_grn_req_detail.tbl_grn_req_idtbl_grn_req', 'left');
        $this->db->join('tbl_measurements', 'tbl_measurements.idtbl_mesurements = tbl_grn_req_detail.tbl_measurements_id', 'left');
        $this->db->where('tbl_grn_req_detail.tbl_grn_req_idtbl_grn_req', $recordID);
        $this->db->where('tbl_grn_req_detail.status', 1);

        $responddetail=$this->db->get();

        $html='';
        $html.='
        <div class="row">
        
        <div class="col-12 text-right"></div>
            <div class="col-12 text-left">
                <h6>Company : '.$respond->row(0)->locemail.'</h6>
                <h6>Employee : '.$respond->row(0)->employeename. '-'.$respond->row(0)->empid.'</h6>
                <h6>Order Type : '.$respond->row(0)->ordertype.'</h6>
            </div>
            
        </div>
        <div class="row">
            <div class="col-12">
                <hr>
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>UOM</th>
                            <th class="text-center">Qty</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach($responddetail->result() as $roworderinfo){
                            $html.='<tr>
                            <td>'.$roworderinfo->materialname.' / '.$roworderinfo->materialinfocode.'</td>
                            <td>'.$roworderinfo->measure_type.'</td>
                            <td class="text-center">'.$roworderinfo->qty.'</td>
                        </tr>';
                    }
                    $html.='</tbody>
                </table>
            </div>
        </div>
        ';

        echo $html;
    }
    public function Goodreceiverequeststatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==1){
            $data = array(
                'confirmstatus' => '1',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_grn_req', $recordID);
            $this->db->update('tbl_grn_req', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-check';
                $actionObj->title='';
                $actionObj->message='GRN Request Confirm Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='success';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Goodreceiverequest');                
            } else {
                $this->db->trans_rollback();

                $actionObj=new stdClass();
                $actionObj->icon='fas fa-warning';
                $actionObj->title='';
                $actionObj->message='Record Error';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Goodreceiverequest');
            }
        }
    }
}
