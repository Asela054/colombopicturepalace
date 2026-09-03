<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Goodreceiverequest extends CI_Controller {
    public function index(){
		$this->load->model('Goodreceiverequestinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['employeelist']=$this->Goodreceiverequestinfo->Getemployee();
		$result['supplierlist']=$this->Goodreceiverequestinfo->Getsupplier();
		$result['ordertypelist']=$this->Goodreceiverequestinfo->Getordertype();
		$result['servicetypelist']=$this->Goodreceiverequestinfo->Getservicetype();
		$result['locationlist']=$this->Goodreceiverequestinfo->Getlocation();
		$result['measurelist']=$this->Goodreceiverequestinfo->Getmeasuretype();
		$this->load->view('goodreceiverequest',$result);
	}
   
	public function Goodreceiverequestinsertupdate(){
		$this->load->model('Goodreceiverequestinfo');
        $result=$this->Goodreceiverequestinfo->Goodreceiverequestinsertupdate();
	}
    public function Goodreceiverequeststatus($x, $y){
		$this->load->model('Goodreceiverequestinfo');
        $result=$this->Goodreceiverequestinfo->Goodreceiverequeststatus($x, $y);
	}
	public function GetProductList() {
        $this->load->model('Goodreceiverequestinfo');
        $products = $this->Goodreceiverequestinfo->getProductsByType();
    }
	public function Getproductforvehicle(){
		$this->load->model('Goodreceiverequestinfo');
        $result=$this->Goodreceiverequestinfo->Getproductforvehicle();
	}
	public function Getproductformachine(){
		$this->load->model('Goodreceiverequestinfo');
        $result=$this->Goodreceiverequestinfo->Getproductformachine();
	}
    public function Grnorderview(){
		$this->load->model('Goodreceiverequestinfo');
        $result=$this->Goodreceiverequestinfo->Grnorderview();
	}
	public function porderviewheader(){
		$this->load->model('Goodreceiverequestinfo');
        $result=$this->Goodreceiverequestinfo->porderviewheader();
	}
	public function Printinvoice($x){
		$this->load->model('Grnreqinfo');
        $result=$this->Grnreqinfo->Printinvoice($x);
	}
}
