<?php
use Dompdf\Dompdf;
use Dompdf\Options;
class Issuegoodreceiveinfo extends CI_Model{

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
    public function Getporder() {
		$this->db->select('`idtbl_grn_req`');
		$this->db->from('tbl_grn_req');
		$this->db->where('status', 1);
		$this->db->where('confirmstatus', 1);
		$this->db->where('issuestatus', 0);

		return $respond=$this->db->get();
	}
	public function Getmeasuretype() {
		$this->db->select('`idtbl_mesurements`, `measure_type`');
		$this->db->from('tbl_measurements');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}

	public function Issuegoodreceiveinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $tableData=$this->input->post('tableData');
		$issuedate=$this->input->post('issuedate');
		$total=$this->input->post('total');
		$employee=$this->input->post('employee');
		$ordertype=$this->input->post('ordertype');
		$location=$this->input->post('location');
		$itemrequest=$this->input->post('itemrequest');
        $updatedatetime=date('Y-m-d H:i:s');

		$data=array(
		'ordertype'=> $ordertype,
		'issuedate'=> $issuedate,
		'total'=> $total,
		'approvestatus'=> '0',
		'status'=> '1',
		'insertdatetime'=> $updatedatetime,
		'tbl_user_idtbl_user'=> $userID,
		'location_id'=> $location,
		'employee_id'=> $employee,
		'tbl_grn_req_idtbl_grn_req'=> $itemrequest);

        $this->db->insert('tbl_print_issue', $data);

        $issueID=$this->db->insert_id();


		foreach($tableData as $rowtabledata) {
			$batchno=$rowtabledata['col_2'];
			$uomId=$rowtabledata['col_4'];
			$comment=$rowtabledata['col_5'];
			$unitprice=$rowtabledata['col_6'];
			$qty=$rowtabledata['col_7'];
			$productid=$rowtabledata['col_9'];
			$total=$rowtabledata['col_10'];
			$stockid=$rowtabledata['col_11'];

			$dataone=array(
				'issue_date'=> $issuedate,
				'qty'=> $qty,
				'unitprice'=> $unitprice,
				'total'=> $total,
				'comment'=> $comment,
				'batchno'=> $batchno,
				'measure_type_id'=> $uomId,
				'status'=> '1',
				'insertdatetime'=> $updatedatetime,
				'tbl_print_issue_idtbl_print_issue'=> $issueID,
				'tbl_print_material_info_idtbl_print_material_info'=> $productid,
				'stock_id'=> $stockid);

			$this->db->insert('tbl_print_issuedetail', $dataone);
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

    public function Getcompanyaccordinggrnreq() {
		$recordID=$this->input->post('recordID');

		$this->db->select('`company_id`');
		$this->db->from('tbl_grn_req');
		$this->db->where('status', 1);
		$this->db->where('idtbl_grn_req', $recordID);

		$respond=$this->db->get();

		echo $respond->row(0)->company_id;
	}
    ////////Get Location///////////////
    public function Getlocationaccoitemreq() {
		$recordID=$this->input->post('recordID');

		$this->db->select('`company_id`');
		$this->db->from('tbl_grn_req');
		$this->db->where('status', 1);
		$this->db->where('idtbl_grn_req', $recordID);

		$respond=$this->db->get();

		echo $respond->row(0)->company_id;
	}

    ////////Get Department///////////////
    public function Getdepartmentaccoitemreq() {
		$recordID=$this->input->post('recordID');

		$this->db->select('`employee_id`');
		$this->db->from('tbl_grn_req');
		$this->db->where('status', 1);
		$this->db->where('idtbl_grn_req', $recordID);

		$respond=$this->db->get();

		echo $respond->row(0)->employee_id;
	}

    /**
     * Return JSON header+detail for an item request (GRN). Used by issue form.
     */
    public function GetRequestDetails() {
        $recordID = $this->input->post('recordID');

        // header: order type name, requestor
        $this->db->select('g.tbl_material_group_idtbl_material_group AS ordertypeid, m.group AS ordertype, g.employee_id, e.emp_name_with_initial, e.emp_id');
        $this->db->from('tbl_grn_req g');
        $this->db->join('tbl_material_group m', 'm.idtbl_material_group = g.tbl_material_group_idtbl_material_group', 'left');
        $this->db->join('employees e', 'e.id = g.employee_id', 'left');
        $this->db->where('g.status', 1);
        $this->db->where('g.idtbl_grn_req', $recordID);
        $header = $this->db->get()->row();

        // details: item + measurement + qty + comment
        $this->db->select('d.qty, d.comment, mi.materialname, mi.materialinfocode, ms.measure_type');
        $this->db->from('tbl_grn_req_detail d');
        $this->db->join('tbl_print_material_info mi', 'mi.idtbl_print_material_info = d.tbl_material_id', 'left');
        $this->db->join('tbl_measurements ms', 'ms.idtbl_mesurements = d.tbl_measurements_id', 'left');
        $this->db->where('d.tbl_grn_req_idtbl_grn_req', $recordID);
        $this->db->where('d.status', 1);
        $details = $this->db->get()->result();

        $result = new stdClass();
        $result->header = $header;
        $result->details = $details;

        echo json_encode($result);
    }

     ////////Get OrderType///////////////
     public function Getordertypeaccoitemreq() {
		$recordID=$this->input->post('recordID');

		$this->db->select('`tbl_material_group_idtbl_material_group`');
		$this->db->from('tbl_grn_req');
		$this->db->where('status', 1);
		$this->db->where('idtbl_grn_req', $recordID);

		$respond=$this->db->get();

		echo $respond->row(0)->tbl_material_group_idtbl_material_group;
	}

    //Get Material////
    public function Getmaterialitem() {
		$recordID=$this->input->post('recordID');

		$sql="SELECT `tbl_print_material_info`.`idtbl_print_material_info`, `tbl_print_material_info`.`materialinfocode`, `tbl_print_material_info`.`materialname` FROM `tbl_grn_req_detail` LEFT JOIN `tbl_print_material_info` ON `tbl_print_material_info`.`idtbl_print_material_info`=`tbl_grn_req_detail`.`tbl_material_id` WHERE `tbl_grn_req_detail`.`tbl_grn_req_idtbl_grn_req`=?";
		$respond=$this->db->query($sql, array($recordID));

		echo json_encode($respond->result());
	}

	public function Getproductinfoaccoproduct() {
		$recordID = $this->input->post('recordID');

		$this->db->select('idtbl_print_stock, batchno, qty, unitprice, measure_type_id, grndate');
		$this->db->from('tbl_print_stock');
		$this->db->where('status', 1);
		$this->db->where('tbl_print_material_info_idtbl_print_material_info', $recordID);

		$respond = $this->db->get();

		if ($respond->num_rows() > 0) {
			echo json_encode($respond->result());
		} else {
			echo json_encode([]);
		}
	}
	
	public function Getproductinfoaccomachine() {
		$recordID=$this->input->post('recordID');

		$this->db->select('*');
		$this->db->from('tbl_print_stock');
		$this->db->where('status', 1);
		$this->db->where('tbl_machine_id', $recordID);

		$respond=$this->db->get();

		if($respond->num_rows()>0) {
			echo json_encode($respond->result());
		}

	}

    public function GetitemreQTY() {
		$recordID=$this->input->post('recordID');

		$this->db->select('`qty`');
		$this->db->from('tbl_print_stock');
		$this->db->where('status', 1);
		$this->db->where('idtbl_print_stock', $recordID);

		$respond=$this->db->get();

		if($respond->num_rows()>0) {
			$obj=new stdClass();
			 $obj->qty=$respond->row(0)->qty;
		}

		echo json_encode($obj);
	}

	public function Getqtyfromreq() {
		$recordID=$this->input->post('recordID');
		$itemreq_id=$this->input->post('itemreq_id');

		$this->db->select('`qty`');
		$this->db->from('tbl_grn_req_detail');
		$this->db->where('status', 1);
		$this->db->where('tbl_grn_req_idtbl_grn_req', $itemreq_id);
		$this->db->where('tbl_material_id', $recordID);

		$respond=$this->db->get();

		if($respond->num_rows()>0) {
			$obj=new stdClass();
			 $obj->qtylabel=$respond->row(0)->qty;
		}

		echo json_encode($obj);
	}

	public function Getunitpricefrombatch() {

		$recordID = $this->input->post('recordID');
		$batchno  = $this->input->post('batchno');

		$obj = new stdClass();
		$obj->unitprice = 0;

		$this->db->select('unitprice');
		$this->db->from('tbl_print_stock');
		$this->db->where('status', 1);
		$this->db->where_in('batchno', $batchno);
		$this->db->where('tbl_print_material_info_idtbl_print_material_info', $recordID);

		$respond = $this->db->get();

		if ($respond->num_rows() > 0) {
			$obj->unitprice = $respond->row()->unitprice;
		}

		echo json_encode($obj);
	}

	public function Getqtyfromreqmachine() {
		$recordID=$this->input->post('recordID');
		$itemreq_id=$this->input->post('itemreq_id');

		$this->db->select('`qty`');
		$this->db->from('tbl_grn_req_detail');
		$this->db->where('status', 1);
		$this->db->where('tbl_grn_req_idtbl_grn_req', $itemreq_id);
		$this->db->where('tbl_machine_id', $recordID);

		$respond=$this->db->get();

		if($respond->num_rows()>0) {
			$obj=new stdClass();
			 $obj->qtylabel=$respond->row(0)->qty;
		}

		echo json_encode($obj);
	}

	public function Issueview() {
		$recordID = $this->input->post('recordID');

		$this->db->select('
			tbl_print_issuedetail.*,
			tbl_print_material_info.materialname,
			tbl_print_material_info.materialinfocode,
			tbl_measurements.measure_type,
			tbl_account.accountno AS accountno_head,
			tbl_account.accountname AS account_name_head,
			tbl_account_detail.accountno AS accountno_detail,
			tbl_account_detail.accountname AS account_name_detail
		');
		$this->db->from('tbl_print_issuedetail');
		$this->db->join('tbl_print_material_info', 'tbl_print_issuedetail.tbl_print_material_info_idtbl_print_material_info = tbl_print_material_info.idtbl_print_material_info', 'left');
		$this->db->join('tbl_measurements', 'tbl_measurements.idtbl_mesurements = tbl_print_issuedetail.measure_type_id', 'left');
		$this->db->join('tbl_account', 'tbl_account.idtbl_account = tbl_print_issuedetail.tbl_account_idtbl_account', 'left');
		$this->db->join('tbl_account_detail', 'tbl_account_detail.idtbl_account_detail = tbl_print_issuedetail.tbl_account_detail_idtbl_account_detail', 'left');
		$this->db->where('tbl_print_issuedetail.tbl_print_issue_idtbl_print_issue', $recordID);
		$this->db->where('tbl_print_issuedetail.status', 1);

		$responddetail = $this->db->get();

		$html = '';

		foreach ($responddetail->result() as $roworderinfo) {

			$accountName = '';
			$accountID   = '';
			$accountType = '';

			if (!empty($roworderinfo->tbl_account_idtbl_account)) {
				$accountName = $roworderinfo->accountno_head . ' - ' . $roworderinfo->account_name_head;
				$accountID   = $roworderinfo->tbl_account_idtbl_account;
				$accountType = 1;
			} elseif (!empty($roworderinfo->tbl_account_detail_idtbl_account_detail)) {
				$accountName = $roworderinfo->accountno_detail . ' - ' . $roworderinfo->account_name_detail;
				$accountID   = $roworderinfo->tbl_account_detail_idtbl_account_detail;
				$accountType = 2;
			}

			$html .= '<tr>
							<td>' . $roworderinfo->materialname . '-' . $roworderinfo->materialinfocode . '</td>
							<td class="text-left">' . $roworderinfo->measure_type . '</td>
							<td class="text-center">' . $roworderinfo->qty . '</td>
							<td class="text-center d-none">' . $roworderinfo->tbl_print_material_info_idtbl_print_material_info . '</td>
							<td class="text-center d-none">' . $roworderinfo->stock_id . '</td>
							<td class="accountlist">' . $accountName . '</td>
							<td class="text-center d-none"><input type="text" class="row_account_id" name="row_account_id[]" value="' . $accountID . '"></td>
							<td class="text-center d-none"><input type="text" class="row_account_type" name="row_account_type[]" value="' . $accountType . '"></td>
						</tr>';
		}

		echo $html;
	}

	public function Approveissue()
	{
		$userID = $_SESSION['userid'];
		$company = $_SESSION['company_id'];
		$branch = $_SESSION['branch_id'];

		$tableData = $this->input->post('tableData');
		$viewissueid = $this->input->post('viewissueid');
		$updatedatetime = date('Y-m-d H:i:s');

		$obj = new stdClass();
		$actionObj = new stdClass();

		try {
			$this->db->trans_begin();

			foreach ($tableData as $rowtabledata) {

				$stockid = $rowtabledata['stockid'];
				$account_id = $rowtabledata['account_id'];
				$account_type = $rowtabledata['account_type'];

				$accountData = array();

				if ($account_type == 1) {
					$accountData['tbl_account_idtbl_account'] = $account_id;
					$accountData['tbl_account_detail_idtbl_account_detail'] = null;
				} elseif ($account_type == 2) {
					$accountData['tbl_account_detail_idtbl_account_detail'] = $account_id;
					$accountData['tbl_account_idtbl_account'] = null;
				}

				$data = array_merge(array(
					'updateuser' => $userID,
					'updatedatetime' => $updatedatetime
				), $accountData);

				$this->db->where('stock_id', $stockid);
				$this->db->where('tbl_print_issue_idtbl_print_issue', $viewissueid);
				$this->db->update('tbl_print_issuedetail', $data);
			}

			$this->db->trans_commit();

			$actionObj->icon = 'fas fa-check-circle';
			$actionObj->title = '';
			$actionObj->message = 'Accounts Updated Successfully';
			$actionObj->type = 'success';

			$obj->status = 1;
			$obj->action = json_encode($actionObj);

		} catch (Exception $e) {

			$this->db->trans_rollback();

			error_log("Issue Approve Error: " . $e->getMessage());

			$actionObj->icon = 'fas fa-exclamation-triangle';
			$actionObj->title = '';
			$actionObj->message = 'Operation Failed';
			$actionObj->type = 'danger';

			$obj->status = 0;
			$obj->action = json_encode($actionObj);
		}

		echo json_encode($obj);
	}

	public function Issuegoodreceivecheckstatus() {
		$this->db->trans_begin();

		$recordID = $this->input->post('requestid');
		$confirmnot = $this->input->post('confirmnot');
		$userID = $_SESSION['userid'];
		$updatedatetime = date('Y-m-d H:i:s');

		$data = array('issued_by' => $userID);
		$this->db->where('idtbl_print_issue', $recordID);
		$this->db->update('tbl_print_issue', $data);

		if ($confirmnot == 1) {
			$this->db->select('*');
			$this->db->from('tbl_print_issuedetail');
			$this->db->where('tbl_print_issue_idtbl_print_issue', $recordID);
			$details = $this->db->get();

			foreach ($details->result() as $row) {
				$stockid = $row->stock_id;
				$issueqty = $row->qty;

				$stock = $this->db->get_where('tbl_print_stock', ['idtbl_print_stock' => $stockid])->row();
				if ($stock) {
					$newQty = max($stock->qty - $issueqty, 0);
					$this->db->where('idtbl_print_stock', $stockid);
					$this->db->update('tbl_print_stock', [
						'qty' => $newQty,
						'updateuser' => $userID,
						'updatedatetime' => $updatedatetime
					]);
				}
			}
		}

		$this->db->trans_complete();

		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
			$actionObj = new stdClass();
			$actionObj->icon = 'fas fa-check';
			$actionObj->title = '';
			$actionObj->message = ($confirmnot == 1) ? 'Issued Successfully' : 'Rejected Successfully';
			$actionObj->url = '';
			$actionObj->target = '_blank';
			$actionObj->type = 'success';

			echo json_encode([
				'status' => 1,
				'action' => json_encode($actionObj)
			]);
		} else {
			$this->db->trans_rollback();
			echo json_encode([
				'status' => 2,
				'message' => 'Record Error'
			]);
		}
	}
	public function IssueNoteView() {
		$recordID = $this->input->post('recordID');

		// ================= HEADER =================
		$this->db->select('
			i.idtbl_print_issue,
			i.issuedate,
			i.total,
			l.location,
			e.emp_fullname
		');
		$this->db->from('tbl_print_issue i');
		$this->db->join('tbl_location l', 'l.idtbl_location = i.location_id', 'left');
		$this->db->join('employees e', 'e.id = i.employee_id', 'left');
		$this->db->where('i.idtbl_print_issue', $recordID);
		$this->db->where('i.status', 1);
		$header = $this->db->get();

		// ================= DETAILS =================
		$this->db->select('
			d.qty,
			d.stock_id,
			d.unitprice,
			d.total,
			d.comment,
			d.batchno,
			m.materialname,
			m.materialinfocode,
			u.measure_type
		');
		$this->db->from('tbl_print_issuedetail d');
		$this->db->join('tbl_print_material_info m',
			'm.idtbl_print_material_info = d.tbl_print_material_info_idtbl_print_material_info',
			'left'
		);
		$this->db->join('tbl_measurements u',
			'u.idtbl_mesurements = d.measure_type_id',
			'left'
		);
		$this->db->where('d.tbl_print_issue_idtbl_print_issue', $recordID);
		$this->db->where('d.status', 1);
		$details = $this->db->get();

		// ================= HTML =================
		$html = '
		<div class="row mb-2">
			<div class="col-6 small">
				<strong>Issue Date:</strong> ' . $header->row()->issuedate . '<br>
				<strong>Location:</strong> ' . $header->row()->location . '
			</div>
			<div class="col-6 small text-right">
				<strong>Employee:</strong> ' . $header->row()->emp_fullname . '<br>
				<strong>Issue No:</strong> ' . $header->row()->idtbl_print_issue . '
			</div>
		</div>

		<hr class="border-dark">

		<table class="table table-bordered table-sm" id="issueTable">
			<thead class="thead-light">
				<tr>
					<th>Material</th>
					<th>Batch No</th>
					<th class="text-center">Qty</th>
					<th class="d-none">Stock ID</th>
					<th class="text-center">UOM</th>
					<th class="text-right">Unit Price</th>
					<th class="text-right">Total</th>
					<th>Remark</th>
				</tr>
			</thead>
			<tbody>';

		foreach ($details->result() as $row) {
			$material = $row->materialname;
			if (!empty($row->materialinfocode)) {
				$material .= ' / ' . $row->materialinfocode;
			}

			// Add classes for JS to pick stock ID and qty
			$html .= '
			<tr>
				<td>' . $material . '</td>
				<td>' . $row->batchno . '</td>
				<td class="text-center issueqty">' . $row->qty . '</td>
				<td class="d-none stockid">' . $row->stock_id . '</td>
				<td class="text-center">' . $row->measure_type . '</td>
				<td class="text-right">' . number_format($row->unitprice, 2) . '</td>
				<td class="text-right">' . number_format($row->total, 2) . '</td>
				<td>' . $row->comment . '</td>
			</tr>';
		}

		$html .= '
			</tbody>
		</table>

		<table width="100%" class="mt-3">
			<tr>
				<td width="80%" class="text-right font-weight-bold">Total</td>
				<td width="20%" class="text-right font-weight-bold">
					Rs. ' . number_format($header->row()->total, 2) . '
				</td>
			</tr>
		</table>';

		$response = [
			'html' => $html
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}

	public function Approvestatus() {
		$userID = $_SESSION['userid'];
		$company = $_SESSION['company_id'];
        $branch = $_SESSION['branch_id'];
		$updatedatetime = date('Y-m-d H:i:s');
		$approveID = $this->input->post('grnid');
		$grnreqid = $this->input->post('req_id');
		$confirmnot = $this->input->post('confirmnot');

		$obj = new stdClass();
        $actionObj = new stdClass();

		try {
			$this->db->trans_begin();

			if ($confirmnot == 1) { 
				$data = array(
					'approvestatus' => $confirmnot,
					'updateuser' => $userID,
					'updatedatetime' => $updatedatetime
				);
				$this->db->where('idtbl_print_issue', $approveID);
				$this->db->update('tbl_print_issue', $data);

				$datareq = array(
					'issuestatus' => '1',
					'updateuser' => $userID,
					'updatedatetime' => $updatedatetime
				);
				$this->db->where('idtbl_grn_req', $grnreqid);
				$this->db->update('tbl_grn_req', $datareq);

				$APIstatus = $this->load->model('Apiinfo');
				$APIstatus = $this->Apiinfo->InternalIssueApi($approveID);
				
				if (empty($APIstatus)) {
					throw new Exception("Internal Issue API configuration error: Missing chart of accounts for one or more items.");
				}

				$this->db->select('issuedate, total');
				$this->db->from('tbl_print_issue');
				$this->db->where('status', 1);
				$this->db->where('idtbl_print_issue', $approveID);
				$respond = $this->db->get();

				if (!empty($APIstatus)) {
                    $fullnarration = 'Costing for Internal Issue ID: ' . $approveID;
                    $apiurljobfinish = $_SESSION['accountapiurl'].'Api/JurnalEntryProcess';

                    $postDataList = http_build_query([
                        'userid' => $userID,
                        'company' => $company,
                        'branch' => $branch,
                        'invoicedate' => $respond->row(0)->issuedate,
                        'fullnarration' => $fullnarration,
						'fulltotal' => $respond->row(0)->total,
                        'jurnalentrydata' => json_encode($APIstatus)
                    ]);

                    $ch = curl_init();
                    curl_setopt_array($ch, [
                        CURLOPT_URL => $apiurljobfinish,
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => $postDataList,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTPHEADER => [
                            'Content-Type: application/x-www-form-urlencoded',
                        ]
                    ]);
                    
                    $server_output = curl_exec($ch);
                    $curlError = curl_error($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);
					
                    // Check both HTTP status and API response
                    $apiResponsejobfinish = json_decode($server_output, true);

                    if ($httpCode != 200 || !isset($apiResponsejobfinish['status']) || $apiResponsejobfinish['status'] !== 'success') {
                        $errorMsg = $apiResponsejobfinish['message'] ?? 'API request failed in jobfinish';
                        throw new Exception($errorMsg);
                    }
                }

			} else {
				$data = array(
					'approvestatus' => $confirmnot,
					'updateuser' => $userID,
					'updatedatetime' => $updatedatetime
				);
			
				$this->db->where('idtbl_print_issue', $approveID);
				$this->db->update('tbl_print_issue', $data);
			}
			
			$this->db->trans_commit();
			
			$actionObj->icon = 'fas fa-check';
			$actionObj->title = '';
			$actionObj->message = ($confirmnot == 1) ? 'Record Approved Successfully' : 'Record Rejected Successfully';
			$actionObj->url = '';
			$actionObj->target = '_blank';
			$actionObj->type = 'success';

			$obj->status = 1;
            $obj->action = json_encode($actionObj);

		} catch (Exception $e) {
            $this->db->trans_rollback();

            error_log("Transaction faild Error: " . $e->getMessage());
            
            $actionObj->icon = 'fas fa-exclamation-triangle';
            $actionObj->title = '';
            $actionObj->message = 'Operation Failed: ' . $e->getMessage();
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'danger';
    
            $obj->status = 0;
            $obj->action = json_encode($actionObj);
		}

		echo json_encode($obj);
	}

	public function Issuepdf($x){

		$recordID = $x;

		$this->db->select('tbl_print_issuedetail.*, tbl_print_issue.ordertype, tbl_order_type.type, tbl_location.location, employees.emp_id, employees.emp_name_with_initial, tbl_print_issue.idtbl_print_issue, tbl_print_material_info.materialname, tbl_measurements.measure_type');
		$this->db->from('tbl_print_issuedetail');
		$this->db->join('tbl_print_issue', 'tbl_print_issuedetail.tbl_print_issue_idtbl_print_issue = tbl_print_issue.idtbl_print_issue', 'left');
		$this->db->join('tbl_order_type', 'tbl_print_issue.ordertype = tbl_order_type.idtbl_order_type', 'left');
		$this->db->join('tbl_print_material_info', 'tbl_print_issuedetail.tbl_print_material_info_idtbl_print_material_info = tbl_print_material_info.idtbl_print_material_info', 'left');
		$this->db->join('tbl_measurements', 'tbl_measurements.idtbl_mesurements = tbl_print_issuedetail.measure_type_id', 'left');
		$this->db->join('tbl_location', 'tbl_print_issue.location_id = tbl_location.idtbl_location', 'left');
		$this->db->join('employees', 'tbl_print_issue.employee_id = employees.id', 'left');

		$this->db->where('tbl_print_issuedetail.tbl_print_issue_idtbl_print_issue', $recordID);
		$this->db->where('tbl_print_issuedetail.status', 1);

		$responddetail = $this->db->get();

		$ordertype = '';
		$location = '';
		$name = '';
		$empid = '';
		$idtbl_print_issue = '';

		if ($responddetail->num_rows() > 0) {
			$row = $responddetail->row();
			$ordertype = $row->type;
			$location = $row->location;
			$name = $row->emp_name_with_initial;
			$empid = $row->emp_id;
			$idtbl_print_issue = $row->idtbl_print_issue;
		}

		$sub_total_amount = 0;
		$generateddatetime = date('Y-m-d h:i A');

		$this->load->library('pdf');

		$fontDir = 'fonts/';
		$options = new Options();
		$options->set('fontDir', $fontDir);
		$options->set('isPhpEnabled', true);
		$dompdf = new Dompdf($options);

		$html = '
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Issue Item Request</title>
			<style>
				* {
					box-sizing: border-box;
				}
				body {
					margin: 0;
					padding: 18px 24px;
					font-family: Arial, sans-serif;
					color: #222;
					width: 100%;
				}
				.company-name {
					margin: 0 0 4px 0;
					font-size: 19px;
					letter-spacing: 0.5px;
				}
				.company-detail {
					margin: 0;
					font-size: 11px;
					line-height: 1.5;
					color: #444;
				}
				.doc-title {
					font-size: 16px;
					font-weight: bold;
					margin: 0;
					padding-bottom: 2px;
					border-bottom: 2px solid #333;
					display: inline-block;
				}
				.ref-box {
					font-size: 12px;
					text-align: right;
				}
				.ref-box b {
					font-size: 13px;
				}
				.info-table td {
					font-size: 12px;
					padding: 2px 0;
					vertical-align: top;
				}
				.info-label {
					font-weight: bold;
					width: 90px;
					display: inline-block;
				}
				.section-divider {
					border: none;
					border-top: 1px solid #ccc;
					margin: 10px 0;
				}
				.tablec {
					width: 100%;
					border-collapse: collapse;
					margin-top: 6px;
					font-size: 12px;
				}
				.tablec thead th {
					background-color: #333;
					color: #fff;
					padding: 7px 6px;
					font-size: 11.5px;
					text-transform: uppercase;
					letter-spacing: 0.3px;
					border: 1px solid #333;
				}
				.tablec tbody td {
					padding: 6px;
					border: 1px solid #ccc;
				}
				.tablec tbody tr:nth-child(even) {
					background-color: #f7f7f7;
				}
				.subtotal-row td {
					border-top: 2px solid #333;
					padding: 8px 6px;
					font-size: 12.5px;
					background-color: #eee;
				}
				.signature-table {
					width: 100%;
					margin-top: 55px;
					font-size: 11.5px;
				}
				.signature-table td {
					padding-top: 6px;
					text-align: center;
					border-top: 1px solid #333;
					width: 40%;
				}
				.signature-table .spacer {
					width: 20%;
					border-top: none;
				}
				.footer-note {
					margin-top: 25px;
					font-size: 9.5px;
					color: #888;
					text-align: center;
					border-top: 1px solid #ddd;
					padding-top: 6px;
				}
			</style>
		</head>
		<body>

			<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="65%" valign="top">
						<p class="company-name"><b><i>MULTI OFFSET PRINTERS (PVT) LTD</i></b></p>
						<p class="company-detail"><i>345, Negombo Road, Mukalangamuwa, Seeduwa</i></p>
						<p class="company-detail"><i>Phone: +94-11-2253505, 2253876, 2256615</i></p>
						<p class="company-detail"><i>E-Mail: multioffsetprinters@gmail.com</i></p>
						<p class="company-detail"><i>Fax: +94-11-2254057</i></p>
					</td>
					<td width="35%" valign="top" class="ref-box">
						<p>MO/GRNR-<b>' . $idtbl_print_issue . '</b></p>
						<p>Date: ' . date('Y-m-d') . '</p>
					</td>
				</tr>
			</table>

			<hr class="section-divider">

			<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<p class="doc-title">Issue Item Request</p>
					</td>
				</tr>
			</table>

			<table class="info-table" width="100%" cellpadding="0" cellspacing="0" style="margin-top:8px;">
				<tr>
					<td width="50%"><span class="info-label">Location:</span> ' . $location . '</td>
					<td width="50%"><span class="info-label">Order Type:</span> ' . $ordertype . '</td>
				</tr>
				<tr>
					<td><span class="info-label">Employee:</span> ' . $name . ' - ' . $empid . '</td>
					<td></td>
				</tr>
			</table>

			<table class="tablec">
				<thead>
					<tr>
						<th style="text-align:center;" width="30%">Item Name</th>
						<th style="text-align:center;" width="15%">UOM</th>
						<th style="text-align:center;" width="15%">Qty</th>
						<th style="text-align:right;" width="20%">Unit Price</th>
						<th style="text-align:right;" width="20%">Total</th>
					</tr>
				</thead>
				<tbody>';

		foreach ($responddetail->result() as $roworderinfo) {
			$total = ($roworderinfo->qty * $roworderinfo->unitprice);
			$html .= '<tr>';
			if ($roworderinfo->tbl_print_material_info_idtbl_print_material_info == 0) {
				$html .= '<td style="text-align:center;">' . $roworderinfo->machine . '</td>';
			} else {
				$html .= '<td style="text-align:center;">' . $roworderinfo->materialname . '</td>';
			}
			$html .= '<td style="text-align:center;">' . $roworderinfo->measure_type . '</td>';
			$html .= '<td style="text-align:center;">' . $roworderinfo->qty . '</td>
						<td style="text-align:right;">' . number_format($roworderinfo->unitprice, 2) . '</td>
						<td style="text-align:right;">' . number_format($total, 2) . '</td></tr>';
			$sub_total_amount += $total;
		}

		$html .= '<tr class="subtotal-row">
						<td colspan="4" style="text-align:right;"><b>Sub Total</b></td>
						<td style="text-align:right;"><b>' . number_format($sub_total_amount, 2) . '</b></td>
					</tr>
				</tbody>
			</table>

			<table class="signature-table" cellpadding="0" cellspacing="0">
				<tr>
					<td>Issued By</td>
					<td class="spacer"></td>
					<td>Received By</td>
				</tr>
			</table>

			<div class="footer-note">
				Generated on ' . $generateddatetime . ' &nbsp;|&nbsp; This is a system generated document.
			</div>

		</body>
		</html>
		';

		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();

		// Embed native PDF-level JavaScript so the print dialog opens automatically
		// as soon as the document is opened in a JS-capable PDF viewer (Adobe Reader,
		// most desktop browser PDF viewers). Viewers without a JS engine simply ignore it.
		$canvas = $dompdf->getCanvas();
		if (method_exists($canvas, 'get_cpdf')) {
			$canvas->get_cpdf()->addJavascript('this.print();');
		}

		$dompdf->stream("Issue Item Request - " . $idtbl_print_issue, ["Attachment" => 0]);
	}


}