<?php

class UOMconversionsinfo extends CI_Model {
    public function Getmeasuretype() {
		$this->db->select('`idtbl_mesurements`, `measure_type`');
		$this->db->from('tbl_measurements');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}

    public function UOMconversionsinsertupdate() {
		$this->db->trans_begin();

		$userID=$_SESSION['userid'];
		$main_uom=$this->input->post('mainuom');
        $convert_uom=$this->input->post('convertuom');
		$qty=$this->input->post('qty');
		$insertdatetime=date('Y-m-d H:i:s');

		$recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

		
		if($recordOption==1) {

			$data = array(
                'main_uom'=> $main_uom,  
                'convert_uom'=> $convert_uom,  
                'qty'=> $qty,  
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );
			$this->db->insert('tbl_uom_conversions', $data);

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
                redirect('UOMconversions');

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
                redirect('UOMconversions');
            }

		} 
		else{
            $data = array(
                'main_uom'=> $main_uom,  
                'convert_uom'=> $convert_uom,  
                'qty'=> $qty,                  'status'=> '1', 
                'updateuser'=> $userID, 
                'updatedatetime' => $insertdatetime,
            );
			$this->db->where('idtbl_uom_conversions', $recordID);
			$this->db->update('tbl_uom_conversions', $data);

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
                redirect('UOMconversions');                
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
                redirect('UOMconversions');
            }
		}
	}

    public function UOMconversionsedit() {
		$recordID=$this->input->post('recordID');

		$this->db->select('*');
        $this->db->from('tbl_uom_conversions');
        $this->db->where('idtbl_uom_conversions', $recordID);
        $this->db->where('status', 1);

		$respond=$this->db->get();

        $obj=new stdClass();
		$obj->id=$respond->row(0)->idtbl_uom_conversions;
        $obj->main_uom=$respond->row(0)->main_uom;
        $obj->convert_uom=$respond->row(0)->convert_uom;
        $obj->qty=$respond->row(0)->qty;

		echo json_encode($obj);
	}

    public function UOMconversionsstatus($x, $y) {
		$this->db->trans_begin();

		$userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

		if ($type==1) {
            $data = array(
                'status' => '1',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );
			$this->db->where('idtbl_uom_conversions', $recordID);
            $this->db->update('tbl_uom_conversions', $data);

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
                redirect('UOMconversions');                
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
                redirect('UOMconversions');
            }
		}
		else if ($type==2) {
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_uom_conversions', $recordID);
            $this->db->update('tbl_uom_conversions', $data);

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
                redirect('UOMconversions');                
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
                redirect('UOMconversions');
            }
		}
		else if ($type==3) {
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_uom_conversions', $recordID);
            $this->db->update('tbl_uom_conversions', $data);

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
                redirect('UOMconversions');                
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
                redirect('UOMconversions');
            }
        }
	}

}