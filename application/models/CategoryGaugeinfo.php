<?php

class CategoryGaugeinfo extends CI_Model {

    public function CategoryGaugeinsertupdate() {
        
		$this->db->trans_begin();

		$userID=$_SESSION['userid'];
		$categoryGauge_type=$this->input->post('categoryGauge_type');
		$datetime=date('Y-m-d H:i:s');

		$recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

		if($recordOption==1) {

			$data = array(
                'categorygauge_type'=> $categoryGauge_type,  
                'status'=> '1', 
                'insertdatetime'=> $datetime, 
                'tbl_user_idtbl_user'=> $userID,
            );
			$this->db->insert('tbl_categorygauge', $data);

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
                redirect('CategoryGauge');

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
                redirect('CategoryGauge');
            }
		} 
		else{
            $data = array(
                'categorygauge_type'=> $categoryGauge_type,  
                'status'=> '1', 
                'updateuser'=> $userID, 
                'updatedatetime' => $datetime,
            );
			$this->db->where('idtbl_categorygauge', $recordID);
			$this->db->update('tbl_categorygauge', $data);

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
                redirect('CategoryGauge'); 

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
                redirect('CategoryGauge');
            }
		}
	}

    public function CategoryGaugeedit() {
		$recordID=$this->input->post('recordID');

		$this->db->select('*');
        $this->db->from('tbl_categorygauge');
        $this->db->where('idtbl_categorygauge', $recordID);
        $this->db->where('status', 1);

		$respond=$this->db->get();

        $obj=new stdClass();
		$obj->id=$respond->row(0)->idtbl_categorygauge;
        $obj->categorygauge_type=$respond->row(0)->categorygauge_type;

		echo json_encode($obj);
	}

    public function CategoryGaugestatus($x, $y) {
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
			$this->db->where('idtbl_categorygauge', $recordID);
            $this->db->update('tbl_categorygauge', $data);

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
                redirect('CategoryGauge'); 

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
                redirect('CategoryGauge');
            }
		}
		else if ($type==2) {
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_categorygauge', $recordID);
            $this->db->update('tbl_categorygauge', $data);

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
                redirect('CategoryGauge');    

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
                redirect('CategoryGauge');
            }
		}
		else if ($type==3) {
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_categorygauge', $recordID);
            $this->db->update('tbl_categorygauge', $data);

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
                redirect('CategoryGauge');         
                       
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
                redirect('CategoryGauge');
            }
        }
	}

}