<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Rimming extends CI_Controller {
    public function index(){
		$this->load->model('Rimminginfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('rimming',$result);
	}
   
	public function Rimminginsertupdate(){
		$this->load->model('Rimminginfo');
        $result=$this->Rimminginfo->Rimminginsertupdate();
	}
	public function Rimmingedit(){
		$this->load->model('Rimminginfo');
        $result=$this->Rimminginfo->Rimmingedit();
	}
	public function Rimmingstatus($x, $y){
		$this->load->model('Rimminginfo');
        $result=$this->Rimminginfo->Rimmingstatus($x, $y);
	}
	
}
