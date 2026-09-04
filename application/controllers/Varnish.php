<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Varnish extends CI_Controller {
    public function index(){
		$this->load->model('Varnishinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('varnish',$result);
	}
   
	public function Varnishinsertupdate(){
		$this->load->model('Varnishinfo');
        $result=$this->Varnishinfo->Varnishinsertupdate();
	}
	public function Varnishedit(){
		$this->load->model('Varnishinfo');
        $result=$this->Varnishinfo->Varnishedit();
	}
	public function Varnishstatus($x, $y){
		$this->load->model('Varnishinfo');
        $result=$this->Varnishinfo->Varnishstatus($x, $y);
	}
	
}
