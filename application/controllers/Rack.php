<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Rack extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Rackinfo');
        $result['site_locations'] = $this->Rackinfo->GetSiteLocations();
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('rack', $result);
	}
    public function Rackinsertupdate(){
		$this->load->model('Rackinfo');
        $result=$this->Rackinfo->Rackinsertupdate();
	}
    public function Rackstatus($x, $y){
		$this->load->model('Rackinfo');
        $result=$this->Rackinfo->Rackstatus($x, $y);
	}
    public function Rackedit(){
		$this->load->model('Rackinfo');
        $result=$this->Rackinfo->Rackedit();
	}
}