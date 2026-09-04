<?php class ServicePurchaseOrderinfo extends CI_Model {

	public function Getsupplier() {

		$companyID=$_SESSION['company_id'];

		$this->db->select('`idtbl_supplier`, `suppliername`');
		$this->db->from('tbl_supplier');
		$this->db->where('status', 1);
		$this->db->where('tbl_company_idtbl_company', $companyID);

		return $respond=$this->db->get();
	}

	public function Getordertype() {
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
	
	public function Getpiecesforqty() {
		$uomID = $this->input->post('recordID');
		$productId = $this->input->post('productId');
		$qty = $this->input->post('qty');
	
		$this->db->select('qty, measure_type');
		$this->db->from('tbl_material_uom_qty');
		$this->db->join('tbl_measurements', 'tbl_measurements.idtbl_mesurements=tbl_material_uom_qty.measurement');
		$this->db->join('tbl_material_uom_qty_has_tbl_print_material_info', 'tbl_material_uom_qty_has_tbl_print_material_info.tbl_material_uom_qty_idtbl_material_uom_qty =tbl_material_uom_qty.idtbl_material_uom_qty');
		$this->db->where('tbl_print_material_info_idtbl_print_material_info', $productId);
		$this->db->where('tbl_measurements_idtbl_mesurements', $uomID);
		$this->db->where('tbl_material_uom_qty.status', 1);
	
		$query = $this->db->get();
		$result = $query->row();
	
		$response = new stdClass();
		if ($result) {
			$response->piecesper_qty = $result->qty*$qty;  
			$response->measure_type = $result->measure_type;  
		} else {
			$response->piecesper_qty = 0;
			$response->measure_type = 0;
		}
	
		echo json_encode($response);
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

	public function Purchaseorderedit()
	{
		$recordID = $this->input->post('recordID');
		$comapnyID=$_SESSION['company_id'];
	
		$this->db->select('tbl_print_porder.idtbl_print_porder, tbl_print_porder.tbl_print_porder_req_idtbl_print_porder_req, tbl_print_porder.orderdate, tbl_print_porder.orderdate, tbl_print_porder.tbl_supplier_idtbl_supplier, tbl_print_porder.tbl_material_group_idtbl_material_group, tbl_print_porder_detail.pieces, tbl_print_porder_detail.actual_qty, tbl_print_porder_detail.packetprice, tbl_print_porder_detail.comment, tbl_print_porder_detail.netprice, tbl_print_porder_detail.qty, tbl_measurements.idtbl_mesurements, tbl_measurements.measure_type, tbl_print_material_info.idtbl_print_material_info, tbl_print_material_info.materialname, tbl_print_porder_detail.unitprice AS detail_unitprice');
		$this->db->from('tbl_print_porder');
		$this->db->join('tbl_print_porder_detail', 'tbl_print_porder.idtbl_print_porder = tbl_print_porder_detail.tbl_print_porder_idtbl_print_porder', 'left');
		$this->db->join('tbl_supplier', 'tbl_supplier.idtbl_supplier = tbl_print_porder.tbl_supplier_idtbl_supplier', 'left');
		$this->db->join('tbl_material_group', 'tbl_material_group.idtbl_material_group = tbl_print_porder.tbl_material_group_idtbl_material_group', 'left');
		$this->db->join('tbl_measurements', 'tbl_measurements.idtbl_mesurements = tbl_print_porder_detail.tbl_measurements_idtbl_measurements', 'left');
		$this->db->join('tbl_print_material_info', 'tbl_print_material_info.idtbl_print_material_info = tbl_print_porder_detail.tbl_material_id', 'left');
		$this->db->where('idtbl_print_porder', $recordID);
		$this->db->where('tbl_print_porder.tbl_material_group_idtbl_material_group', 4);
		$this->db->where('tbl_print_porder.tbl_company_idtbl_company', $comapnyID);
		$this->db->where('tbl_print_porder.status', 1);
	
		$respond = $this->db->get();
	
		$obj = new stdClass();
		$obj->id = $respond->row(0)->idtbl_print_porder;
		$obj->requestid = $respond->row(0)->tbl_print_porder_req_idtbl_print_porder_req ;
		$obj->orderdate = $respond->row(0)->orderdate;
		$obj->supplier = $respond->row(0)->tbl_supplier_idtbl_supplier;
		$obj->type = $respond->row(0)->tbl_material_group_idtbl_material_group;
	
		$items = array();
		foreach ($respond->result() as $row) {
			$item = new stdClass();
			$item->pieces = $row->pieces;
			$item->actual_qty = $row->actual_qty;
			$item->unitprice = $row->detail_unitprice;
			$item->packetprice = $row->packetprice;
			$item->comment = $row->comment;
			$item->measureID = $row->idtbl_mesurements;
			$item->measure = $row->measure_type;
			$item->materialID = $row->idtbl_print_material_info;
			$item->material = $row->materialname;
			$item->netprice = $row->netprice;
			$item->qty = $row->qty;
			$item->materialgroup = $row->tbl_material_group_idtbl_material_group;
			$items[] = $item;
		}
		$obj->items = $items;
	
		echo json_encode($obj);
	}

	public function Purchaseorderupdate(){
        $this->db->trans_begin();
    
        $userID=$_SESSION['userid'];
    
        $tableData=$this->input->post('tableData');
    
        // Check if $tableData is an array and not empty
        if(is_array($tableData) && !empty($tableData)){
			$orderdate=$this->input->post('orderdate');
			$discounttotal=$this->input->post('discounttotal');
			$vatamounttotal=$this->input->post('vatamounttotal');
			$grosstotal=$this->input->post('grosstotal');
			$total=$this->input->post('total');
			$remark=$this->input->post('remark');
			$supplier=$this->input->post('supplier');
			$location=$this->input->post('location');
			$ordertype=$this->input->post('ordertype');
			$company_id=$this->input->post('company_id');
			$branch_id=$this->input->post('branch_id');
			$porderID=$this->input->post('porderID');
			$porderreqID=$this->input->post('porderreqID');
            $updatedatetime=date('Y-m-d H:i:s');
    
			$data=array(
			'orderdate'=> $orderdate,
			'duedate'=> 'null',
			'subtotal'=>'0',
			'vattotamount'=> '0',
			'discountamount'=> '0',
			'nettotal'=>$grosstotal,
			'confirmstatus'=> '1',
			'grnconfirm'=>'0',
			'remark'=> $remark,
			'status'=> '1',
			'updatedatetime'=> $updatedatetime,
			'updateuser'=> $userID,
			'tbl_supplier_idtbl_supplier'=> $supplier,
			'tbl_material_group_idtbl_material_group'=> $ordertype,
			'tbl_company_idtbl_company'=> $company_id, 
			'tbl_company_branch_idtbl_company_branch'=> $branch_id, 
			'tbl_print_porder_req_idtbl_print_porder_req '=> $porderreqID,

		);
    
            $this->db->where('idtbl_print_porder', $porderID);
            $this->db->update('tbl_print_porder', $data);
    
    
            $this->db->where('tbl_print_porder_idtbl_print_porder', $porderID);
            $this->db->delete('tbl_print_porder_detail');

				foreach ($tableData as $rowtabledata) {
					$materialname=$rowtabledata['col_1'];
					$comment=$rowtabledata['col_2'];
					$materialID=$rowtabledata['col_3'];
					$qty=$rowtabledata['col_4'];
					$uom=$rowtabledata['col_5'];
					$uomID=$rowtabledata['col_6'];
					$unit=$rowtabledata['col_7'];
					$nettotal=$rowtabledata['col_8'];
					$pieces=$rowtabledata['col_10'];
					
	
					$dataone=array(
						'qty'=> $qty,
						'pieces'=> $pieces,
						'tbl_measurements_idtbl_measurements'=> $uomID,
						'unitprice'=> $unit,
						'packetprice'=> '0',
						'discount'=>'0',
						'vat'=>'0',
						'vatamount'=>'0',
						'grossprice'=>'0',
						'netprice'=>  $nettotal,
						'comment'=> $comment,
						'status'=> '1',
						'updatedatetime'=> $updatedatetime,
						'tbl_print_porder_idtbl_print_porder'=> $porderID,
						'tbl_material_id'=> $materialID,
						'tbl_user_idtbl_user'=> $userID
						
					);
	
					$this->db->insert('tbl_print_porder_detail', $dataone);
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
    }

	public function Purchaseorderstatus() {
		$this->db->trans_begin();

		$userID=$_SESSION['userid'];
		$recordID=$this->input->post('porderid');
        $reqid=$this->input->post('reqestid');
		$confirmnot=$this->input->post('confirmnot');
		$updatedatetime=date('Y-m-d H:i:s');

		$companyID=$_SESSION['company_id'];
		$branchID=$_SESSION['branch_id'];

		// if($type==1) {
			$data=array(
				'servicepo_confirm'=> $confirmnot,
				'updateuser'=> $userID,
				'updatedatetime'=> $updatedatetime);

			$this->db->where('idtbl_print_porder', $recordID);
			$this->db->update('tbl_print_porder', $data);


			$this->db->select('tbl_print_porder.idtbl_print_porder,tbl_print_porder.orderdate, tbl_print_porder.nettotal,tbl_print_porder.tbl_material_group_idtbl_material_group,tbl_print_porder.tbl_supplier_idtbl_supplier');
			$this->db->from('tbl_print_porder');
			$this->db->where('tbl_print_porder.status', 1);
			$this->db->where('tbl_print_porder.idtbl_print_porder', $recordID);

			$respond=$this->db->get();

			if ($respond->num_rows() > 0) {
				foreach ($respond->result() as $row) {
					$grnid=$row->idtbl_print_porder;
					$totalamount=$row->nettotal;
					$supplier=$row->tbl_supplier_idtbl_supplier;
					$grndate=$row->orderdate;
					$orderType=$row->tbl_material_group_idtbl_material_group;


					if ($orderType == 4) {
						$accountsData = array(
							'grndate' => $grndate,
							'tbl_supplier_idtbl_supplier' => $supplier,
							'exptype' => '2',
							'grnno' => $grnid,
							'expcode' => 'SER',
							'amount' => $totalamount,
							'status' => '1',
							'insertdatetime' => $updatedatetime,
							'tbl_user_idtbl_user' => $userID,
							'tbl_company_idtbl_company'=> $companyID, 
							'tbl_company_branch_idtbl_company_branch'=> $branchID
						);
						$this->db->insert('tbl_expence_info', $accountsData);
					}
				}
			}



			$this->db->trans_complete();

			if ($this->db->trans_status()===TRUE) {
				$this->db->trans_commit();

				$actionObj=new stdClass();
				$actionObj->icon='fas fa-check';
				$actionObj->title='';
				if($confirmnot==1){$actionObj->message='Record Approved Successfully';}
				else{$actionObj->message='Record Rejected Successfully';}
				$actionObj->url='';
				$actionObj->target='_blank';
				$actionObj->type='success';

				$actionJSON=json_encode($actionObj);

				$obj=new stdClass();
				$obj->status=1;
				$obj->action=$actionJSON;

				echo json_encode($obj);
			}

			else {
				$this->db->trans_rollback();

				$actionObj=new stdClass();
				$actionObj->icon='fas fa-warning';
				$actionObj->title='';
				$actionObj->message='Record Error';
				$actionObj->url='';
				$actionObj->target='_blank';
				$actionObj->type='danger';

				$actionJSON=json_encode($actionObj);

				$obj=new stdClass();
				$obj->status=2;
				$obj->action=$actionJSON;

				echo json_encode($obj);
			}
	}

}