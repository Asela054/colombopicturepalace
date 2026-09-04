<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class ServicePurchaseOrder extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('ServicePurchaseOrderinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['supplierlist']=$this->ServicePurchaseOrderinfo->Getsupplier();
		$result['ordertypelist']=$this->ServicePurchaseOrderinfo->Getordertype();
		$result['measurelist']=$this->ServicePurchaseOrderinfo->Getmeasuretype();
		$this->load->view('servicepurchaseorder', $result);
	}

    public function Purchaseorderedit(){
		$this->load->model('ServicePurchaseOrderinfo');
        $result=$this->ServicePurchaseOrderinfo->Purchaseorderedit();
	}
	public function GetProductList() {
        $this->load->model('ServicePurchaseOrderinfo');
        $products = $this->ServicePurchaseOrderinfo->getProductsByType();
    }
	public function Getpiecesforqty(){
		$this->load->model('ServicePurchaseOrderinfo');
        $result=$this->ServicePurchaseOrderinfo->Getpiecesforqty();
	}
	public function Purchaseorderupdate(){
		$this->load->model('ServicePurchaseOrderinfo');
        $result=$this->ServicePurchaseOrderinfo->Purchaseorderupdate();
	}
	public function Purchaseorderstatus(){
		$this->load->model('ServicePurchaseOrderinfo');
        $result=$this->ServicePurchaseOrderinfo->Purchaseorderstatus();
	}
}
