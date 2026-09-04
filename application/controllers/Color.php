<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Colombo');

class Color extends CI_Controller {

	public function index(){
		$this->load->model('Colorinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('color', $result);
	}

	public function Colorinsertupdate(){
		$this->load->model('Colorinfo');
        $result=$this->Colorinfo->Colorinsertupdate();
	}

	public function Coloredit(){
		$this->load->model('Colorinfo');
        $result=$this->Colorinfo->Coloredit();
	}
    
	public function Colorstatus($x, $y){
		$this->load->model('Colorinfo');
        $result=$this->Colorinfo->Colorstatus($x, $y);
	}

}
