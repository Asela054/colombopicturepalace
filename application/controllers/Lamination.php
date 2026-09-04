<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Lamination extends CI_Controller {
    public function index(){
		$this->load->model('Laminationinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('lamination',$result);
	}
   
	public function Laminationinsertupdate(){
		$this->load->model('Laminationinfo');
        $result=$this->Laminationinfo->Laminationinsertupdate();
	}
	public function Laminationedit(){
		$this->load->model('Laminationinfo');
        $result=$this->Laminationinfo->Laminationedit();
	}
	public function Laminationstatus($x, $y){
		$this->load->model('Laminationinfo');
        $result=$this->Laminationinfo->Laminationstatus($x, $y);
	}
	
}
