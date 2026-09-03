<?php
class Materialtypeinfo extends CI_Model{
    public function Materialtypeinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $materialgroup=$this->input->post('materialgroup');
        $materialcat_name=$this->input->post('materialcat_name');
		$qtyinbox=$this->input->post('qtyinbox');
      
        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'paper'=> $materialcat_name, 
				'qty_in_box'=> $qtyinbox,
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
                'tbl_material_group_idtbl_material_group'=> $materialgroup
            );

            $this->db->insert('tbl_material_type', $data);

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
                redirect('Materialtype');                
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
                redirect('Materialtype');
            }
        }
        else{
            $data = array(
				'paper'=> $materialcat_name, 
				'qty_in_box'=> $qtyinbox,
                'updatedatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
                'tbl_material_group_idtbl_material_group'=> $materialgroup
            );

            $this->db->where('idtbl_material_type', $recordID);
            $this->db->update('tbl_material_type', $data);

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
                redirect('Materialtype');                
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
                redirect('Materialtype');
            }
        }
    }
    public function Materialtypestatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==1){
            $data = array(
                'status' => '1',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_material_type', $recordID);
            $this->db->update('tbl_material_type', $data);

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
                redirect('Materialtype');                
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
                redirect('Materialtype');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_material_type', $recordID);
            $this->db->update('tbl_material_type', $data);

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
                redirect('Materialtype');                
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
                redirect('Materialtype');
            }
        }
        else if($type==3){
			$data = array(
                'status' => '3',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_material_type', $recordID);
            $this->db->update('tbl_material_type', $data);

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
                redirect('Materialtype');                
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
                redirect('Materialtype');
            }
        }
    }
    public function Materialtypeedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_material_type');
        $this->db->where('idtbl_material_type', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_material_type;
        $obj->paper=$respond->row(0)->paper;
		$obj->qty_in_box=$respond->row(0)->qty_in_box;
		$obj->materialgroup=$respond->row(0)->tbl_material_group_idtbl_material_group;
        echo json_encode($obj);
    }
    public function Materialgroup(){
        $this->db->select('`idtbl_material_group`, `group`');
        $this->db->from('tbl_material_group');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
}
