<?php
class Employeeinfo extends CI_Model{

    // NOTE: table is `employees`, primary key is `id` (per the schema you posted).
    // Only the TEXT fields from the "Add Employee Record" modal are handled here —
    // Employee Status, Job Title, Work Shift, Company, Department, Work Location,
    // Employee Position (all dropdowns) and Photograph (file upload) are intentionally
    // left out throughout, including in the profile view below. Add them back in
    // once those dropdown/upload flows are wired up.

    public function Employeeinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $emp_etfno            = $this->input->post('emp_etfno');
        $emp_id               = $this->input->post('emp_id');
        $emp_first_name       = $this->input->post('emp_first_name');
        $emp_med_name         = $this->input->post('emp_med_name');
        $emp_last_name        = $this->input->post('emp_last_name');
        $emp_fullname         = $this->input->post('emp_fullname');
        $emp_name_with_initial= $this->input->post('emp_name_with_initial');
        $calling_name         = $this->input->post('calling_name');
        $emp_national_id      = $this->input->post('emp_national_id');
        $emp_birthday         = $this->input->post('emp_birthday');
        $tp1                  = $this->input->post('tp1');
        $emp_mobile           = $this->input->post('emp_mobile');
        $emp_work_phone_no    = $this->input->post('emp_work_phone_no');

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'emp_etfno'             => $emp_etfno,
                'emp_id'                => $emp_id,
                'emp_first_name'        => $emp_first_name,
                'emp_med_name'          => $emp_med_name,
                'emp_last_name'         => $emp_last_name,
                'emp_fullname'          => $emp_fullname,
                'emp_name_with_initial' => $emp_name_with_initial,
                'calling_name'          => $calling_name,
                'emp_national_id'       => $emp_national_id,
                'emp_birthday'          => $emp_birthday,
                'tp1'                   => $tp1,
                'emp_mobile'            => $emp_mobile,
                'emp_work_phone_no'     => $emp_work_phone_no,
                'status'                => '1',
                'created_at'            => $insertdatetime,
                'created_by'            => $userID,
            );

            $this->db->insert('employees', $data);

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
                redirect('Employee');
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
                redirect('Employee');
            }
        }
        else{
            $data = array(
                'emp_etfno'             => $emp_etfno,
                'emp_id'                => $emp_id,
                'emp_first_name'        => $emp_first_name,
                'emp_med_name'          => $emp_med_name,
                'emp_last_name'         => $emp_last_name,
                'emp_fullname'          => $emp_fullname,
                'emp_name_with_initial' => $emp_name_with_initial,
                'calling_name'          => $calling_name,
                'emp_national_id'       => $emp_national_id,
                'emp_birthday'          => $emp_birthday,
                'tp1'                   => $tp1,
                'emp_mobile'            => $emp_mobile,
                'emp_work_phone_no'     => $emp_work_phone_no,
                'updated_at'            => $insertdatetime,
                'modified_user_id'      => $userID,
            );

            $this->db->where('id', $recordID);
            $this->db->update('employees', $data);

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
                redirect('Employee');
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
                redirect('Employee');
            }
        }
    }

    public function Employeestatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==1){
            $data = array(
                'status'           => '1',
                'modified_user_id' => $userID,
                'updated_at'       => $updatedatetime
            );

            $this->db->where('id', $recordID);
            $this->db->update('employees', $data);

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
                redirect('Employee');
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
                redirect('Employee');
            }
        }
        else if($type==2){
            $data = array(
                'status'           => '2',
                'modified_user_id' => $userID,
                'updated_at'       => $updatedatetime
            );

            $this->db->where('id', $recordID);
            $this->db->update('employees', $data);

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
                redirect('Employee');
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
                redirect('Employee');
            }
        }
        else if($type==3){
            $data = array(
                'status'           => '3',
                'modified_user_id' => $userID,
                'updated_at'       => $updatedatetime
            );

            $this->db->where('id', $recordID);
            $this->db->update('employees', $data);

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
                redirect('Employee');
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
                redirect('Employee');
            }
        }
    }

    public function Employeeedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('employees');
        $this->db->where('id', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();
        $row = $respond->row(0);

        $obj=new stdClass();
        $obj->id                    = $row->id;
        $obj->emp_etfno             = $row->emp_etfno;
        $obj->emp_id                = $row->emp_id;
        $obj->emp_first_name        = $row->emp_first_name;
        $obj->emp_med_name          = $row->emp_med_name;
        $obj->emp_last_name         = $row->emp_last_name;
        $obj->emp_fullname          = $row->emp_fullname;
        $obj->emp_name_with_initial = $row->emp_name_with_initial;
        $obj->calling_name          = $row->calling_name;
        $obj->emp_national_id       = $row->emp_national_id;
        $obj->emp_birthday          = $row->emp_birthday;
        $obj->tp1                   = $row->tp1;
        $obj->emp_mobile            = $row->emp_mobile;
        $obj->emp_work_phone_no     = $row->emp_work_phone_no;
        echo json_encode($obj);
    }

    // Read-only profile for the "View Profile" modal — mirrors exactly the
    // fields collected on the Add/Edit form, nothing else from the table.
    public function Employeeview(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('employees');
        $this->db->where('id', $recordID);

        $respond=$this->db->get();
        $row = $respond->row(0);

        $obj=new stdClass();
        $obj->id                    = $row->id;
        $obj->emp_etfno             = $row->emp_etfno;
        $obj->emp_id                = $row->emp_id;
        $obj->emp_first_name        = $row->emp_first_name;
        $obj->emp_med_name          = $row->emp_med_name;
        $obj->emp_last_name         = $row->emp_last_name;
        $obj->emp_fullname          = $row->emp_fullname;
        $obj->emp_name_with_initial = $row->emp_name_with_initial;
        $obj->calling_name          = $row->calling_name;
        $obj->emp_national_id       = $row->emp_national_id;
        $obj->emp_birthday          = $row->emp_birthday;
        $obj->tp1                   = $row->tp1;
        $obj->emp_mobile            = $row->emp_mobile;
        $obj->emp_work_phone_no     = $row->emp_work_phone_no;

        echo json_encode($obj);
    }
}