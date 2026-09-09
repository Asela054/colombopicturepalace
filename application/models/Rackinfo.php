<?php
class Rackinfo extends CI_Model{
    public function Rackinsertupdate(){
        $this->db->trans_begin();

        $userID = $_SESSION['userid'];

        $site_location = $this->input->post('site_location');
        $zonename = $this->input->post('zonename');
        $racknumber = $this->input->post('racknumber');
        $maxweight = $this->input->post('maxweight');
        $maxunit = $this->input->post('maxunit');

        $recordOption = $this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))) {
            $recordID = $this->input->post('recordID');
        }

        $updatedatetime = date('Y-m-d H:i:s');

        if($recordOption == 1){
            $data = array(
                'zone_name' => $zonename,
                'rack_number' => $racknumber, 
                'max_weight' => $maxweight,
                'max_unit' => $maxunit,
                'tbl_location_idtbl_location' => $site_location,
                'status' => '1', 
                'insertdatetime' => $updatedatetime, 
                'tbl_user_idtbl_user' => $userID
            );

            $this->db->insert('tbl_rack', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-save';
                $actionObj->title = '';
                $actionObj->message = 'Zone Added Successfully';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'success';

                $actionJSON = json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Rack');                
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
                redirect('Rack');
            }
        } else {
            $data = array(
                'zone_name' => $zonename,
                'rack_number' => $racknumber, 
                'max_weight' => $maxweight,
                'max_unit' => $maxunit,
                'tbl_location_idtbl_location' => $site_location,
                'updateuser' => $userID,
                'updatedatetime' => $updatedatetime
            );

            $this->db->where('idtbl_rack', $recordID);
            $this->db->update('tbl_rack', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-save';
                $actionObj->title = '';
                $actionObj->message = 'Zone Updated Successfully';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'primary';

                $actionJSON = json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Rack');                
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
                redirect('Rack');
            }
        }
    }

    public function Rackstatus($x, $y){
        $this->db->trans_begin();

        $userID = $_SESSION['userid'];
        $recordID = $x;
        $type = $y;
        $updatedatetime = date('Y-m-d H:i:s');

        if($type == 1){
            $data = array(
                'status' => '1',
                'updateuser' => $userID, 
                'updatedatetime' => $updatedatetime
            );

            $this->db->where('idtbl_rack', $recordID);
            $this->db->update('tbl_rack', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-check';
                $actionObj->title = '';
                $actionObj->message = 'Zone Activated Successfully';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'success';

                $actionJSON = json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Rack');                
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
                redirect('Rack');
            }
        } else if($type == 2){
            $data = array(
                'status' => '2',
                'updateuser' => $userID, 
                'updatedatetime' => $updatedatetime
            );

            $this->db->where('idtbl_rack', $recordID);
            $this->db->update('tbl_rack', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-times';
                $actionObj->title = '';
                $actionObj->message = 'Zone Deactivated Successfully';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'warning';

                $actionJSON = json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Rack');                
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
                redirect('Rack');
            }
        } else if($type == 3){
            $data = array(
                'status' => '3',
                'updateuser' => $userID, 
                'updatedatetime' => $updatedatetime
            );

            $this->db->where('idtbl_rack', $recordID);
            $this->db->update('tbl_rack', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-trash-alt';
                $actionObj->title = '';
                $actionObj->message = 'Zone Removed Successfully';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'danger';

                $actionJSON = json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Rack');                
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
                redirect('Rack');
            }
        }
    }

    public function Rackedit(){
        $recordID = $this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_rack');
        $this->db->where('idtbl_rack', $recordID);
        $this->db->where('status !=', 3); 

        $respond = $this->db->get();

        $obj = new stdClass();
        $obj->id = $respond->row(0)->idtbl_rack;
        $obj->site_location = $respond->row(0)->tbl_location_idtbl_location;
        $obj->zone_name = $respond->row(0)->zone_name;
        $obj->rack_number = $respond->row(0)->rack_number;
        $obj->max_weight = $respond->row(0)->max_weight;
        $obj->max_unit = $respond->row(0)->max_unit;

        echo json_encode($obj);
    }

    public function Getracks() {
        $this->db->select('idtbl_rack, rack_number, tbl_location_idtbl_location');
        $this->db->from('tbl_rack');
        $this->db->where('status', 1);
        $this->db->order_by('rack_number', 'ASC');
        
        return $this->db->get();
    }
    
    public function GetSiteLocations()
    {
        $this->db->select('idtbl_location, location as location_name');
        $this->db->from('tbl_location');
        $this->db->where('status', 1);
        $this->db->order_by('location', 'asc');

        return $this->db->get()->result_array();
    }
}