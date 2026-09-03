<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stockvaluationreport extends CI_Controller {


public function index(){

$this->load->model('Stockvaluationreportinfo');
$this->load->model('Commeninfo');


$data['menuaccess']=$this->Commeninfo->Getmenuprivilege();

$data['materialgroup']=$this->Stockvaluationreportinfo->MaterialGroupget();


$this->load->view('stockvaluationreport',$data);

}


}