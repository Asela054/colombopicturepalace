<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stocklistreport extends CI_Controller {


public function index(){

$this->load->model('Stocklistreportinfo');
$this->load->model('Commeninfo');


$data['menuaccess']=$this->Commeninfo->Getmenuprivilege();

$data['materialgroup']=$this->Stocklistreportinfo->MaterialGroupget();


$this->load->view('stocklistreport',$data);

}


}