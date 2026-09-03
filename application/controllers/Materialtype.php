<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Materialtype extends CI_Controller {
    public function index(){
		$this->load->model('Materialtypeinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['materialgroup']=$this->Materialtypeinfo->Materialgroup();
		$this->load->view('materialtype',$result);
	}
   
	public function Materialtypeinsertupdate(){
		$this->load->model('Materialtypeinfo');
        $result=$this->Materialtypeinfo->Materialtypeinsertupdate();
	}
	public function Materialtypeedit(){
		$this->load->model('Materialtypeinfo');
        $result=$this->Materialtypeinfo->Materialtypeedit();
	}
	public function Materialtypestatus($x, $y){
		$this->load->model('Materialtypeinfo');
        $result=$this->Materialtypeinfo->Materialtypestatus($x, $y);
	}
	
}
