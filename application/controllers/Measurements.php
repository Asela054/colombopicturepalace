<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Measurements extends CI_Controller {
	public function index(){
		$this->load->model('Measurementsinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('measurements', $result);
	}
	public function Measurementsinsertupdate(){
		$this->load->model('Measurementsinfo');
        $result=$this->Measurementsinfo->Measurementsinsertupdate();
	}
	public function Measurementsedit(){
		$this->load->model('Measurementsinfo');
        $result=$this->Measurementsinfo->Measurementsedit();
	}
	public function Measurementstatus($x, $y){
		$this->load->model('Measurementsinfo');
        $result=$this->Measurementsinfo->Measurementstatus($x, $y);
	}
}
