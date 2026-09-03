<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class StockReport extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Stockreportinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['locationlist']=$this->Stockreportinfo->Getlocation();
		$result['supplierlist']=$this->Stockreportinfo->Getsupplier();
		$result['ordertypelist']=$this->Stockreportinfo->Getordertype();
		$this->load->view('stockreport', $result);
	}
}