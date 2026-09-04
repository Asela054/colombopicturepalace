<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class CategoryGauge extends CI_Controller {

	public function index(){
		$this->load->model('CategoryGaugeinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('categorygauge', $result);
	}

	public function CategoryGaugeinsertupdate(){
		$this->load->model('CategoryGaugeinfo');
        $result=$this->CategoryGaugeinfo->CategoryGaugeinsertupdate();
	}

	public function CategoryGaugeedit(){
		$this->load->model('CategoryGaugeinfo');
        $result=$this->CategoryGaugeinfo->CategoryGaugeedit();
	}
    
	public function CategoryGaugestatus($x, $y){
		$this->load->model('CategoryGaugeinfo');
        $result=$this->CategoryGaugeinfo->CategoryGaugestatus($x, $y);
	}

}
