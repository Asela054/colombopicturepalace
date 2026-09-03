<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Warehouse extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Warehouseinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('warehouse', $result);
	}
    public function Warehouseinsertupdate(){
		$this->load->model('Warehouseinfo');
        $result=$this->Warehouseinfo->Warehouseinsertupdate();
	}
    public function Warehousestatus($x, $y){
		$this->load->model('Warehouseinfo');
        $result=$this->Warehouseinfo->Warehousestatus($x, $y);
	}
    public function Warehouseedit(){
		$this->load->model('Warehouseinfo');
        $result=$this->Warehouseinfo->Warehouseedit();
	}
}