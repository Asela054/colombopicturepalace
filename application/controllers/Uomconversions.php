<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Uomconversions extends CI_Controller {

	public function index(){
		$this->load->model('Uomconversionsinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['measurelist']=$this->Uomconversionsinfo->Getmeasuretype();
		$this->load->view('uomconversions', $result);
	}
    public function UOMconversionsinsertupdate(){
		$this->load->model('Uomconversionsinfo');
        $result=$this->Uomconversionsinfo->UOMconversionsinsertupdate();
	}
    public function UOMconversionsedit(){
		$this->load->model('Uomconversionsinfo');
        $result=$this->Uomconversionsinfo->UOMconversionsedit();
	}
    public function UOMconversionsstatus($x, $y){
		$this->load->model('Uomconversionsinfo');
        $result=$this->Uomconversionsinfo->UOMconversionsstatus($x, $y);
	}

}