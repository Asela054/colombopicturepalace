<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Foiling extends CI_Controller {
    public function index(){
		$this->load->model('Foilinginfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('foiling',$result);
	}
   
	public function Foilinginsertupdate(){
		$this->load->model('Foilinginfo');
        $result=$this->Foilinginfo->Foilinginsertupdate();
	}
	public function Foilingedit(){
		$this->load->model('Foilinginfo');
        $result=$this->Foilinginfo->Foilingedit();
	}
	public function Foilingstatus($x, $y){
		$this->load->model('Foilinginfo');
        $result=$this->Foilinginfo->Foilingstatus($x, $y);
	}
	
}
