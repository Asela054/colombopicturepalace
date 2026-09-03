<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Stocktransfer extends CI_Controller {
    public function index(){
		$this->load->model('Stocktransferinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['locationlist']=$this->Stocktransferinfo->Getlocation();
	
		$this->load->view('stocktransfer',$result);
	}
   
	public function Getproductlist(){
		$this->load->model('Stocktransferinfo');
        $result=$this->Stocktransferinfo->Getproductlist();
	}

    public function Getbatchlist(){
		$this->load->model('Stocktransferinfo');
        $result=$this->Stocktransferinfo->Getbatchlist();
	}

    public function Stocktransferprocess(){
		$this->load->model('Stocktransferinfo');
        $result=$this->Stocktransferinfo->Stocktransferprocess();
	}
}