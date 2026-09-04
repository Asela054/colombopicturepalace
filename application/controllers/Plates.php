<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Plates extends CI_Controller {
    public function index(){
		$this->load->model('Platesinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('plates',$result);
	}
   
	public function Platesinsertupdate(){
		$this->load->model('Platesinfo');
        $result=$this->Platesinfo->Platesinsertupdate();
	}
	public function Platesedit(){
		$this->load->model('Platesinfo');
        $result=$this->Platesinfo->Platesedit();
	}
	public function Platesstatus($x, $y){
		$this->load->model('Platesinfo');
        $result=$this->Platesinfo->Platesstatus($x, $y);
	}
	
}
