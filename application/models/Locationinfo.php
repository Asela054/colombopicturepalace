<?php
class Locationinfo extends CI_Model {
    public function Locationinsertupdate(){
        $this->db->trans_begin();

        $userID = $_SESSION['userid'];
        
        // Get form data with new field names
        $name = $this->input->post('name');
        $address = $this->input->post('address');
        $sublocation = $this->input->post('sublocation');
        $locationname = $this->input->post('locationname');
        $warehouse_type = $this->input->post('warehousetype'); // Note: Space in field name
        $capacity = $this->input->post('capacity');
        
        $recordOption = $this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){
            $recordID = $this->input->post('recordID');
        }

        $updatedatetime = date('Y-m-d H:i:s');

        if($recordOption == 1){ // Insert
            $data = array(
                'name' => $name,
                'address' => $address,
                'sublocation' => $sublocation,
                'location' => $locationname,
                'warehouse_type' => $warehouse_type,
                'capacity' => $capacity,
                'status' => '1',
                'insertdatetime' => $updatedatetime,
                'tbl_user_idtbl_user' => $userID
            );

            $this->db->insert('tbl_location', $data);

            $this->db->trans_complete();

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
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Location');                
            } else {
                $this->db->trans_rollback();

                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-warning';
                $actionObj->title = '';
                $actionObj->message = 'Record Error';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'danger';

                $actionJSON = json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Location');
            }
        }
        else { // Update
            $data = array(
                'name' => $name,
                'address' => $address,
                'sublocation' => $sublocation,
                'location' => $locationname,
                'warehouse_type' => $warehouse_type,
                'capacity' => $capacity,
                'updateuser' => $userID,
                'updatedatetime' => $updatedatetime
            );

            $this->db->where('idtbl_location', $recordID);
            $this->db->update('tbl_location', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-save';
                $actionObj->title = '';
                $actionObj->message = 'Record Updated Successfully';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'primary';

                $actionJSON = json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Location');                
            } else {
                $this->db->trans_rollback();

                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-warning';
                $actionObj->title = '';
                $actionObj->message = 'Record Error';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'danger';

                $actionJSON = json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Location');
            }
        }
    }
    
    public function Locationstatus($x, $y){
        $this->db->trans_begin();

        $userID = $_SESSION['userid'];
        $recordID = $x;
        $type = $y;
        $updatedatetime = date('Y-m-d H:i:s');

        if($type == 1){ // Activate
            $data = array(
                'status' => '1',
                'updateuser' => $userID,
                'updatedatetime' => $updatedatetime
            );

            $this->db->where('idtbl_location', $recordID);
            $this->db->update('tbl_location', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-check';
                $actionObj->title = '';
                $actionObj->message = 'Record Activated Successfully';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'success';

                $actionJSON = json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Location');                
            } else {
                $this->db->trans_rollback();

                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-warning';
                $actionObj->title = '';
                $actionObj->message = 'Record Error';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'danger';

                $actionJSON = json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Location');
            }
        }
        else if($type == 2){ // Deactivate
            $data = array(
                'status' => '2',
                'updateuser' => $userID,
                'updatedatetime' => $updatedatetime
            );

            $this->db->where('idtbl_location', $recordID);
            $this->db->update('tbl_location', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-times';
                $actionObj->title = '';
                $actionObj->message = 'Record Deactivated Successfully';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'warning';

                $actionJSON = json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Location');                
            } else {
                $this->db->trans_rollback();

                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-warning';
                $actionObj->title = '';
                $actionObj->message = 'Record Error';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'danger';

                $actionJSON = json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Location');
            }
        }
        else if($type == 3){ // Delete/Remove
            $data = array(
                'status' => '3',
                'updateuser' => $userID,
                'updatedatetime' => $updatedatetime
            );

            $this->db->where('idtbl_location', $recordID);
            $this->db->update('tbl_location', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-trash-alt';
                $actionObj->title = '';
                $actionObj->message = 'Record Removed Successfully';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'danger';

                $actionJSON = json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Location');                
            } else {
                $this->db->trans_rollback();

                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-warning';
                $actionObj->title = '';
                $actionObj->message = 'Record Error';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'danger';

                $actionJSON = json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Location');
            }
        }
    }
    
    public function Locationedit(){
        $recordID = $this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_location');
        $this->db->where('idtbl_location', $recordID);
        $this->db->where('status', 1);

        $respond = $this->db->get();

        if($respond->num_rows() > 0) {
            $obj = new stdClass();
            $obj->id = $respond->row(0)->idtbl_location;
            $obj->name = $respond->row(0)->name;
            $obj->address = $respond->row(0)->address;
            $obj->sublocation = $respond->row(0)->sublocation;
            $obj->locationname = $respond->row(0)->location;
            $obj->warehouse_type = $respond->row(0)->warehouse_type;
            $obj->capacity = $respond->row(0)->capacity;
            
           

            echo json_encode($obj);
        } else {
            echo json_encode(new stdClass());
        }
    }
    
    public function Getlocations() {
        $this->db->select('idtbl_location as locationid, location as locationname');
        $this->db->from('tbl_location');
        $this->db->where('status', 1); 
        
        $query = $this->db->get();
        
        return $query->result_array();
    }
}
?>