<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Materialgroup extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Materialgroupinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('materialgroup', $result);
	}
    public function Materialgroupinsertupdate(){
		$this->load->model('Materialgroupinfo');
        $result=$this->Materialgroupinfo->Materialgroupinsertupdate();
	}
    public function Materialgroupstatus($x, $y){
		$this->load->model('Materialgroupinfo');
        $result=$this->Materialgroupinfo->Materialgroupstatus($x, $y);
	}
    public function Materialgroupedit(){
		$this->load->model('Materialgroupinfo');
        $result=$this->Materialgroupinfo->Materialgroupedit();
	}
}