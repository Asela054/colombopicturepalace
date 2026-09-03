<?php
class Materialdetailinfo extends CI_Model{
    public function Getmaterialcaregorybygroup(){
        $recordID=$this->input->post('recordID');

        $this->db->select('`idtbl_material_type`, `paper`');
        $this->db->from('tbl_material_type');
        $this->db->where('status', 1);
        $this->db->where('tbl_material_group_idtbl_material_group', $recordID);

        $respond=$this->db->get();
        echo json_encode($respond->result());
    }
    public function Getmaterialname(){
        $this->db->select('`idtbl_material_code`, `materialname`, `materialcode`');
        $this->db->from('tbl_material_code');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getmaterialgroup(){
        $this->db->select('`idtbl_material_group`, `group`');
        $this->db->from('tbl_material_group');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getmeasurement(){
        $this->db->select('`idtbl_mesurements`, `measure_type`');
        $this->db->from('tbl_measurements');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getmaterialcolor(){
        $this->db->select('`idtbl_color`, `color`');
        $this->db->from('tbl_color');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getmaterialcategorygauge(){
        $this->db->select('`idtbl_categorygauge`, `categorygauge_type`');
        $this->db->from('tbl_categorygauge');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getsupplier(){
        $comapnyID=$_SESSION['company_id'];

        $this->db->select('`idtbl_supplier`, `suppliername`');
        $this->db->from('tbl_supplier');
        $this->db->where('status', 1);
        $this->db->where('tbl_supplier.tbl_company_idtbl_company', $comapnyID);

        return $respond=$this->db->get();
    }

    public function Materialdetailinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        //Remove the Select
        $company_id=$this->input->post('f_company_id');
		$branch_id=$this->input->post('f_branch_id');
        $materialname=$this->input->post('materialname');
        $materialname = str_replace('Select', '', $materialname);

        $materialcode=$this->input->post('materialcode');
        $materialcategory=$this->input->post('materialcategory');
        $materialgroup=$this->input->post('materialgroup');
        $supplier=$this->input->post('supplier');
        $reorder=$this->input->post('reorder');
        $comment=$this->input->post('comment');  
        $unitprice=$this->input->post('unitprice');  
        
        if(!empty($this->input->post('material_color'))){
            $material_color = $this->input->post('material_color');
        } else {
            $material_color = 0;
        }

        if(!empty($this->input->post('material_categorygauge'))){
            $material_categorygauge = $this->input->post('material_categorygauge');
        } else {
            $material_categorygauge = 0;
        }

        if(!empty($this->input->post('chartofdetailaccount'))){
            $chartofdetailaccount = $this->input->post('chartofdetailaccount');
            $accounttype = $this->input->post('hiddenaccounttype');
        } else {
            $chartofdetailaccount = 0;
            $accounttype = 0;
        }

        if($accounttype == 1){
            $chartofaccount=$chartofdetailaccount;
            $chartofdetailaccount=0;
        } else {
            $chartofaccount=0;
            $chartofdetailaccount=$chartofdetailaccount;
        }

        $measurement=$this->input->post('measurement');

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $updatedatetime=date('Y-m-d H:i:s');  

        if($recordOption==1){
            $data = array(
                'materialname'=> $materialname, 
                'materialinfocode'=> $materialcode, 
                'unitprice'=> $unitprice, 
                'reorderlevel'=> $reorder, 
                'comment'=> $comment, 
                'tbl_company_idtbl_company'=> $company_id, 
				'tbl_company_branch_idtbl_company_branch'=> $branch_id, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID, 
                'tbl_material_type_idtbl_material_type'=> $materialcategory,
                'tbl_color_idtbl_color'=> $material_color,
                'tbl_categorygauge_idtbl_categorygauge'=> $material_categorygauge,
                'tbl_supplier_idtbl_supplier'=> $supplier,
                'tbl_material_group_idtbl_material_group'=> $materialgroup,
                'tbl_account_idtbl_account'=> $chartofaccount,
                'tbl_account_detail_idtbl_account_detail'=> $chartofdetailaccount,
                'tbl_measurements_idtbl_measurements'=> $measurement
            );

            $this->db->insert('tbl_print_material_info', $data);

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
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Materialdetail');                
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
                redirect('Materialdetail');
            }
        }
        else{
            $data = array(
                'materialname'=> $materialname, 
                'materialinfocode'=> $materialcode, 
                'reorderlevel'=> $reorder, 
                'comment'=> $comment, 
                'tbl_company_idtbl_company'=> $company_id, 
				'tbl_company_branch_idtbl_company_branch'=> $branch_id, 
                'unitprice'=> $unitprice, 
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime, 
                'tbl_material_type_idtbl_material_type'=> $materialcategory,
                'tbl_color_idtbl_color'=> $material_color,
                'tbl_categorygauge_idtbl_categorygauge'=> $material_categorygauge,
                'tbl_supplier_idtbl_supplier'=> $supplier,
                'tbl_material_group_idtbl_material_group'=> $materialgroup,
                'tbl_account_idtbl_account'=> $chartofaccount,
                'tbl_account_detail_idtbl_account_detail'=> $chartofdetailaccount,
                'tbl_measurements_idtbl_measurements'=> $measurement
            );

            $this->db->where('idtbl_print_material_info', $recordID);
            $this->db->update('tbl_print_material_info', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-save';
                $actionObj->title='';
                $actionObj->message='Record Update Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='primary';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Materialdetail');                
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
                redirect('Materialdetail');
            }
        }
    }
    public function UOMqtyinsert(){

        $this->db->trans_begin();

        $userID = $_SESSION['userid'];
        $hiddenmaterialID = $this->input->post('hiddenmaterialID');
        $checked_uoms = $this->input->post('uom_options');
        $all_uoms = explode(',', $this->input->post('all_uom_ids'));

        if(empty($checked_uoms)){
            $checked_uoms = [];
        }

        $updatedatetime = date('Y-m-d H:i:s');

        foreach ($all_uoms as $uom_id) {

            $uom_details = $this->db->select('qty, main_uom, convert_uom')
                ->where('idtbl_uom_conversions', $uom_id)
                ->get('tbl_uom_conversions')
                ->row_array();

            if(!$uom_details){
                continue;
            }

            // Check if record already exists
            $existing = $this->db->select('muq.idtbl_material_uom_qty')
                ->from('tbl_material_uom_qty muq')
                ->join(
                    'tbl_material_uom_qty_has_tbl_print_material_info rel',
                    'rel.tbl_material_uom_qty_idtbl_material_uom_qty = muq.idtbl_material_uom_qty'
                )
                ->where('muq.measurement', $uom_details['convert_uom'])
                ->where('muq.tbl_measurements_idtbl_mesurements', $uom_details['main_uom'])
                ->where('rel.tbl_print_material_info_idtbl_print_material_info', $hiddenmaterialID)
                ->get()
                ->row_array();

            // ✅ IF CHECKED
            if(in_array($uom_id, $checked_uoms)){

                if($existing){

                    // Reactivate if previously removed
                    $this->db->where('idtbl_material_uom_qty', $existing['idtbl_material_uom_qty']);
                    $this->db->update('tbl_material_uom_qty', ['status' => 1]);

                }else{

                    // Insert new
                    $material_qty_data = [
                        'qty' => $uom_details['qty'],
                        'measurement' => $uom_details['convert_uom'],
                        'status' => 1,
                        'insertdatetime' => $updatedatetime,
                        'tbl_user_idtbl_user' => $userID,
                        'tbl_measurements_idtbl_mesurements' => $uom_details['main_uom'],
                    ];

                    $this->db->insert('tbl_material_uom_qty', $material_qty_data);

                    $material_uom_qty_id = $this->db->insert_id();

                    $relation_data = [
                        'tbl_material_uom_qty_idtbl_material_uom_qty' => $material_uom_qty_id,
                        'tbl_print_material_info_idtbl_print_material_info' => $hiddenmaterialID,
                    ];

                    $this->db->insert('tbl_material_uom_qty_has_tbl_print_material_info', $relation_data);
                }

            }
            else{

                if($existing){

                    $this->db->where('idtbl_material_uom_qty', $existing['idtbl_material_uom_qty']);
                    $this->db->update('tbl_material_uom_qty', ['status' => 3]);

                }

            }

        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {

            $this->db->trans_commit();

            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-save';
            $actionObj->title = '';
            $actionObj->message = 'Records Updated Successfully';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'success';

            $this->session->set_flashdata('msg', json_encode($actionObj));
            redirect('Materialdetail');

        } else {

            $this->db->trans_rollback();

            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-warning';
            $actionObj->title = '';
            $actionObj->message = 'Error Updating Records';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'danger';

            $this->session->set_flashdata('msg', json_encode($actionObj));
            redirect('Materialdetail');
        }
    }
    
    public function Getadduomqty()
    {
        $materialID = $this->input->post('id');

        $this->db->distinct();
        $this->db->select('c.idtbl_uom_conversions, c.main_uom, c.convert_uom, c.qty, 
                        main.measure_type AS main_uom_name, 
                        convert.measure_type AS convert_uom_name');
        $this->db->from('tbl_uom_conversions c');
        $this->db->join('tbl_measurements as main', 'main.idtbl_mesurements = c.main_uom', 'left');
        $this->db->join('tbl_measurements as convert', 'convert.idtbl_mesurements = c.convert_uom', 'left');
        $this->db->where('c.status', 1);
        $uoms = $this->db->get()->result_array();

        $result = [];
        foreach ($uoms as $uom) {
            $this->db->select('rel.tbl_print_material_info_idtbl_print_material_info');
            $this->db->from('tbl_material_uom_qty muq');
            $this->db->join('tbl_material_uom_qty_has_tbl_print_material_info rel', 
                'rel.tbl_material_uom_qty_idtbl_material_uom_qty = muq.idtbl_material_uom_qty');
            $this->db->where('muq.measurement', $uom['convert_uom']);
            $this->db->where('muq.tbl_measurements_idtbl_mesurements', $uom['main_uom']);
            $this->db->where('rel.tbl_print_material_info_idtbl_print_material_info', $materialID);
            $this->db->where('muq.status', 1);
            
            $query = $this->db->get();
            $is_checked = $query->num_rows() > 0 ? 1 : 0;
            
            $result[] = [
                'idtbl_uom_conversions' => $uom['idtbl_uom_conversions'],
                'main_uom' => $uom['main_uom_name'],
                'convert_uom' => $uom['convert_uom_name'],
                'qty' => $uom['qty'],
                'is_checked' => $is_checked
            ];
        }

        if (!empty($result)) {
            echo json_encode([
                'status' => 'success',
                'uom_conversions' => $result
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No data found']);
        }
    }
        

    public function Materialdetailstatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==1){
            $data = array(
                'status' => '1',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_print_material_info', $recordID);
            $this->db->update('tbl_print_material_info', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-check';
                $actionObj->title='';
                $actionObj->message='Record Activate Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='success';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Materialdetail');                
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
                redirect('Materialdetail');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_print_material_info', $recordID);
            $this->db->update('tbl_print_material_info', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-times';
                $actionObj->title='';
                $actionObj->message='Record Deactivate Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='warning';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Materialdetail');                
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
                redirect('Materialdetail');
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_print_material_info', $recordID);
            $this->db->update('tbl_print_material_info', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-trash-alt';
                $actionObj->title='';
                $actionObj->message='Record Remove Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Materialdetail');                
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
                redirect('Materialdetail');
            }
        }
    }
    public function Materialdetailedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_print_material_info');
        $this->db->where('idtbl_print_material_info', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $this->db->select('tbl_account_detail.idtbl_account_detail, tbl_account_detail.accountno, tbl_account_detail.accountname, tbl_account.idtbl_account, tbl_account.accountno AS chartaccountno, tbl_account.accountname AS chartaccountname');
        $this->db->from('tbl_print_material_info');
        $this->db->join('tbl_account', 'tbl_account.idtbl_account = tbl_print_material_info.tbl_account_idtbl_account', 'left');
        $this->db->join('tbl_account_detail', 'tbl_account_detail.idtbl_account_detail = tbl_print_material_info.tbl_account_detail_idtbl_account_detail', 'left');
        $this->db->where('tbl_print_material_info.idtbl_print_material_info', $recordID);
        $this->db->where('tbl_print_material_info.status', 1);
        $responddetail=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_print_material_info;
        $obj->materialname=$respond->row(0)->materialname;
        $obj->reorderlevel=$respond->row(0)->reorderlevel;
        $obj->comment=$respond->row(0)->comment;
        $obj->unitprice=$respond->row(0)->unitprice;
        $obj->materialcode=$respond->row(0)->materialinfocode;
        $obj->materialcategory=$respond->row(0)->tbl_material_type_idtbl_material_type;
        $obj->materialcolor=$respond->row(0)->tbl_color_idtbl_color;
        $obj->materialcategorygauge=$respond->row(0)->tbl_categorygauge_idtbl_categorygauge;
        $obj->supplier=$respond->row(0)->tbl_supplier_idtbl_supplier;
        $obj->materialgroup=$respond->row(0)->tbl_material_group_idtbl_material_group;  

        if(!empty($responddetail->row(0)->idtbl_account_detail)){
            $obj->accountid=$responddetail->row(0)->idtbl_account_detail;
            $obj->account=$responddetail->row(0)->accountname.' - '.$responddetail->row(0)->accountno;
            $obj->accounttype=2;
        }
        else if(!empty($responddetail->row(0)->idtbl_account)){
            $obj->accountid=$responddetail->row(0)->idtbl_account;
            $obj->account=$responddetail->row(0)->chartaccountname.' - '.$responddetail->row(0)->chartaccountno;
            $obj->accounttype=1;
        }
        else{
            $obj->accountid=0;
            $obj->account='';
            $obj->accounttype=0;
        }
        $obj->idtbl_measurements=$respond->row(0)->tbl_measurements_idtbl_measurements; 

        echo json_encode($obj);
    }
    public function Materialdetailcheck(){
        // $recordID=$this->input->post('recordID');

        // $this->db->select('COUNT(*) as `count`');
        // $this->db->from('tbl_brand');
        // $this->db->where('tbl_material_category_idtbl_material_category', $recordID);
        // $this->db->where('status', 1);

        // $respondbrand=$this->db->get();

        // $this->db->select('COUNT(*) as `count`');
        // $this->db->from('tbl_form');
        // $this->db->where('tbl_material_category_idtbl_material_category', $recordID);
        // $this->db->where('status', 1);

        // $respondform=$this->db->get();

        // $this->db->select('COUNT(*) as `count`');
        // $this->db->from('tbl_grade');
        // $this->db->where('tbl_material_category_idtbl_material_category', $recordID);
        // $this->db->where('status', 1);

        // $respondgrade=$this->db->get();

        // $this->db->select('COUNT(*) as `count`');
        // $this->db->from('tbl_side');
        // $this->db->where('tbl_material_category_idtbl_material_category', $recordID);
        // $this->db->where('status', 1);

        // $respondside=$this->db->get();

        // $this->db->select('COUNT(*) as `count`');
        // $this->db->from('tbl_size');
        // $this->db->where('tbl_material_category_idtbl_material_category', $recordID);
        // $this->db->where('status', 1);

        // $respondsize=$this->db->get();

        // $this->db->select('COUNT(*) as `count`');
        // $this->db->from('tbl_unit_type');
        // $this->db->where('tbl_material_category_idtbl_material_category', $recordID);
        // $this->db->where('status', 1);

        // $respondunittype=$this->db->get();

        // $obj=new stdClass();
        // if($respondbrand->row(0)->count>0){$obj->brandstatus='1';}else{$obj->brandstatus='0';}
        // if($respondform->row(0)->count>0){$obj->formstatus='1';}else{$obj->formstatus='0';}
        // if($respondgrade->row(0)->count>0){$obj->gradestatus='1';}else{$obj->gradestatus='0';}
        // if($respondsize->row(0)->count>0){$obj->sizestatus='1';}else{$obj->sizestatus='0';}
        // if($respondside->row(0)->count>0){$obj->sidestatus='1';}else{$obj->sidestatus='0';}
        // if($respondunittype->row(0)->count>0){$obj->unittypestatus='1';}else{$obj->unittypestatus='0';}

        // echo json_encode($obj);   
    }
    public function Getbrandcode($brand){
        $this->db->select('brandcode');
        $this->db->from('tbl_brand');
        $this->db->where('idtbl_brand', $brand);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->brandcode;
    }
    public function Getformcode($form){
        $this->db->select('formcode');
        $this->db->from('tbl_form');
        $this->db->where('idtbl_form', $form);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->formcode;
    }
    public function Getgradecode($grade){
        $this->db->select('gradecode');
        $this->db->from('tbl_grade');
        $this->db->where('idtbl_grade', $grade);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->gradecode;
    }
    public function Getsidecode($side){
        $this->db->select('sidecode');
        $this->db->from('tbl_side');
        $this->db->where('idtbl_side', $side);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->sidecode;
    }
    public function Getsizecode($size){
        $this->db->select('sizecode');
        $this->db->from('tbl_size');
        $this->db->where('idtbl_size', $size);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->sizecode;
    }
    public function Getunittypecode($unittype){
        $this->db->select('unittypecode');
        $this->db->from('tbl_unit_type');
        $this->db->where('idtbl_unit_type', $unittype);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->unittypecode;
    }
    public function Getmaterialcode($materialname){
        $this->db->select('materialcode');
        $this->db->from('tbl_material_code');
        $this->db->where('idtbl_material_code', $materialname);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->materialcode;
    }
    public function Getmaterialcategorycode($materialcategory){
        $this->db->select('categorycode');
        $this->db->from('tbl_material_category');
        $this->db->where('idtbl_material_category', $materialcategory);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->categorycode;
    }
    public function Materialdetailupload(){
        $this->db->trans_begin();
        $i=0;

        $userID=$_SESSION['userid'];

		$filename=$_FILES['csvfile']['tmp_name'];
        $updatedatetime=date('Y-m-d h:i:s');

        $file = fopen($filename, 'r');
        while (($line = fgetcsv($file)) !== FALSE) {
            if($i>0 && $line[0]!=''){
                $materialcode='';
                $materialname=$line[0];
                $materialmaincode = $this->Materialdetailinfo->Getmaterialcodeacconame($materialname);
                $materialmainid = $this->Materialdetailinfo->Getmaterialidacconame($materialname);
                $materialcode.=$materialmaincode;

                $materialcategorycode=$line[3];
                $materialcategoryid = $this->Materialdetailinfo->Getmaterialcategoryid($materialcategorycode);
                $materialcode.='-'.$materialcategorycode;

                $brandcode=$line[4];
                if(!empty($brandcode)){
                    $brand = $this->Materialdetailinfo->Getbrandid($brandcode);
                    $materialcode.='-'.$brandcode;
                }else{$brand=0;}

                $formcode=$line[6];
                if(!empty($formcode)){
                    $form = $this->Materialdetailinfo->Getformid($formcode);
                    $materialcode.='-'.$formcode;
                }else{$form=0;}
                
                $gradecode=$line[7];
                if(!empty($gradecode)){
                    $grade = $this->Materialdetailinfo->Getgradeid($gradecode);
                    $materialcode.='-'.$gradecode;
                }else{$grade=0;}

                $sizecode=$line[8];
                if(!empty($sizecode)){
                    $size = $this->Materialdetailinfo->Getsizeid($sizecode);
                    $materialcode.='-'.$sizecode;
                }else{$size=0;}

                $sidecode=$line[9];
                if(!empty($sidecode)){
                    $side = $this->Materialdetailinfo->Getsideid($sidecode);
                    $materialcode.='-'.$sidecode;
                }else{$side=0;}

                $unittypecode=$line[10];
                if(!empty($unittypecode)){
                    $unittype = $this->Materialdetailinfo->Getunittypeid($unittypecode);
                    $materialcode.='-'.$unittypecode;
                }else{$unittype=0;}    

                $unitcode=$line[5];
                if(!empty($unitcode)){
                    $unit = $this->Materialdetailinfo->Getunitid($unitcode);
                }else{$unit=0;}
                
                $reorder=$line[1];
                $comment=$line[2];

                $data = array(
                    'materialinfocode'=> $materialcode, 
                    'reorderlevel'=> $reorder, 
                    'comment'=> $comment, 
                    'colour'=> '', 
                    'status'=> '1', 
                    'insertdatetime'=> $updatedatetime, 
                    'tbl_user_idtbl_user'=> $userID, 
                    'tbl_material_code_idtbl_material_code'=> $materialmainid, 
                    'tbl_material_category_idtbl_material_category'=> $materialcategoryid, 
                    'tbl_brand_idtbl_brand'=> $brand, 
                    'tbl_unit_idtbl_unit'=> $unit, 
                    'tbl_form_idtbl_form'=> $form, 
                    'tbl_grade_idtbl_grade'=> $grade, 
                    'tbl_size_idtbl_size'=> $size, 
                    'tbl_side_idtbl_side'=> $side, 
                    'tbl_unit_type_idtbl_unit_type'=> $unittype
                );
    
                $this->db->insert('tbl_print_material_info', $data);
            }
            $i++;
        }
        fclose($file);

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
            
            $this->session->set_flashdata('msg', $actionJSON);
            redirect('Materialdetail');                
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
            redirect('Materialdetail');
        }
    }
    public function Getmaterialcodeacconame($materialname){
        $this->db->select('materialcode');
        $this->db->from('tbl_material_code');
        $this->db->where('materialname', $materialname);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->materialcode;
    }
    public function Getmaterialidacconame($materialname){
        $this->db->select('idtbl_material_code');
        $this->db->from('tbl_material_code');
        $this->db->where('materialname', $materialname);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->idtbl_material_code;
    }
    public function Getmaterialcategoryid($materialcategorycode){
        $this->db->select('idtbl_material_category');
        $this->db->from('tbl_material_category');
        $this->db->where('categorycode', $materialcategorycode);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->idtbl_material_category;
    }
    public function Getbrandid($brand){
        $this->db->select('idtbl_brand');
        $this->db->from('tbl_brand');
        $this->db->where('brandcode', $brand);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->idtbl_brand;
    }
    public function Getformid($form){
        $this->db->select('idtbl_form');
        $this->db->from('tbl_form');
        $this->db->where('formcode', $form);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->idtbl_form;
    }
    public function Getgradeid($grade){
        $this->db->select('idtbl_grade');
        $this->db->from('tbl_grade');
        $this->db->where('gradecode', $grade);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->idtbl_grade;
    }
    public function Getsideid($side){
        $this->db->select('idtbl_side');
        $this->db->from('tbl_side');
        $this->db->where('sidecode', $side);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->idtbl_side;
    }
    public function Getsizeid($size){
        $this->db->select('idtbl_size');
        $this->db->from('tbl_size');
        $this->db->where('sizecode', $size);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->idtbl_size;
    }
    public function Getunittypeid($unittype){
        $this->db->select('idtbl_unit_type');
        $this->db->from('tbl_unit_type');
        $this->db->where('unittypecode', $unittype);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->idtbl_unit_type;
    }
    public function Getunitid($unitcode){
        $this->db->select('idtbl_unit');
        $this->db->from('tbl_unit');
        $this->db->where('unitcode', $unitcode);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->idtbl_unit;
    }
    public function Getlabelinforaccomaterial(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_material_code`.`materialname`, `tbl_print_material_info`.`materialinfocode` FROM `tbl_print_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_print_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_print_material_info`.`idtbl_print_material_info`=?";
        $respond=$this->db->query($sql, array($recordID));

        $sqlgrnlist="SELECT `tbl_print_grn`.`idtbl_print_grn`, `tbl_print_grn`.`batchno` FROM `tbl_print_stock` LEFT JOIN `tbl_print_grn` ON `tbl_print_grn`.`batchno`=`tbl_print_stock`.`batchno` WHERE `tbl_print_stock`.`tbl_print_material_info_idtbl_print_material_info`=? AND `tbl_print_stock`.`qty`>?";
        $respondgrnlist=$this->db->query($sqlgrnlist, array($recordID, 0));

        $obj=new stdClass();
        $obj->materialname=$respond->row(0)->materialname;
        $obj->materialinfocode=$respond->row(0)->materialinfocode;
        $obj->grnlist=$respondgrnlist->result();

        echo json_encode($obj);
    }
    public function Getgrninfoaccogrnid(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_print_grn`.`tbl_print_porder_idtbl_print_porder`, `tbl_print_grndetail`.`mfdate`, `tbl_print_grndetail`.`expdate`, `tbl_print_grn`.`batchno` FROM `tbl_print_grn` LEFT JOIN `tbl_print_grndetail` ON `tbl_print_grndetail`.`tbl_print_grn_idtbl_print_grn`=`tbl_print_grn`.`idtbl_print_grn` WHERE `tbl_print_grn`.`idtbl_print_grn`=?";
        $respond=$this->db->query($sql, array($recordID));

        echo json_encode($respond->row(0));
    }
    public function Getmaterialinfo(){
        $recordID=$this->input->post('recordID');
        $html='';

        $sql="SELECT 
        `u`.`idtbl_print_material_info`,
        `u`.`materialinfocode`,
        `u`.`status`,
        `ua`.`materialname`,
        `ua`.`materialcode`,
        `ub`.`categoryname`,
        `uc`.`brandcode`,
        `ud`.`unitcode`,
        `ue`.`formcode`,
        `uf`.`gradecode`,
        `ug`.`sizecode`,
        `uh`.`sidecode`,
        `ui`.`unittypecode`
        FROM 
        `tbl_print_material_info` `u`
        LEFT JOIN `tbl_material_category` `ub` ON `ub`.`idtbl_material_category` = `u`.`tbl_material_category_idtbl_material_category`
        WHERE `u`.`idtbl_print_material_info`=?";

        $respond=$this->db->query($sql, array($recordID));

        foreach($respond->result() as $rowlist){
            $html.='

            <ul>
            	<li>
            		<label for="">Material Name : <span>&nbsp;'.$rowlist->materialname.'</span></label>
            	</li>
            	<li>
            		<label for="">Material Code : <span>&nbsp;'.$rowlist->materialcode.'</span></label>
            	</li>
            	<li>
            		<label for="">Category : <span>&nbsp;'.$rowlist->categoryname.'</span></label>
            	</li>
            </ul>
            ';
        }

        echo $html;
    }
}