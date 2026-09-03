<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Materialdetail extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Materialdetailinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['measurement']=$this->Materialdetailinfo->Getmeasurement();
        // $result['materialcategory']=$this->Materialdetailinfo->Getmaterialcategory();
		$result['materialcolor']=$this->Materialdetailinfo->Getmaterialcolor();
		$result['materialgroup']=$this->Materialdetailinfo->Getmaterialgroup();
		$result['materialcategorygauge']=$this->Materialdetailinfo->Getmaterialcategorygauge();
		$result['supplierlist']=$this->Materialdetailinfo->Getsupplier();
		$this->load->view('materialdetail', $result);
	}
    public function Materialdetailinsertupdate(){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->Materialdetailinsertupdate();
	}
    public function Materialdetailstatus($x, $y){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->Materialdetailstatus($x, $y);
	}
    public function Materialdetailedit(){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->Materialdetailedit();
	}
    public function Materialdetailupload(){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->Materialdetailupload();
	}
    public function Materialdetailcheck(){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->Materialdetailcheck();
	}
    public function Getlabelinforaccomaterial(){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->Getlabelinforaccomaterial();
	}
    public function Getgrninfoaccogrnid(){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->Getgrninfoaccogrnid();
	}
	public function Getmaterialinfo(){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->Getmaterialinfo();
	}
    public function Createlabel($mname, $mcode, $grnno, $pono, $mfdate, $expdate, $batchno){
		$this->load->library('Fpdf_gen');
		
		$pdf=new RPDF('L','mm',array(50,30));
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',12);
		$pdf->SetFontSize(12);
		$pdf->TextWithDirection(3,5,'MATERIAL LABEL','R');
		$pdf->SetFont('Arial','',5);
		$pdf->TextWithDirection(3,8,'Name       : '.str_replace('%20', ' ', $mname),'R');
		$pdf->TextWithDirection(3,11,'Code        : '.$mcode,'R');
		$pdf->TextWithDirection(3,14,'GRN No   : '.$grnno,'R');
		$pdf->TextWithDirection(3,17,'PO No      : '.$pono,'R');
        $pdf->TextWithDirection(3,20,'MF Date   : '.$mfdate,'R');
		$pdf->TextWithDirection(3,23,'EXP Date : '.$expdate,'R');
		$pdf->TextWithDirection(3,26,'Batch No  : '.$batchno,'R');
		$pdf->Output();
	}
	public function UOMqtyinsert(){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->UOMqtyinsert();
	}
	public function Getadduomqty(){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->Getadduomqty();
	}
	public function Getmaterialcaregorybygroup(){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->Getmaterialcaregorybygroup();
	}
	public function Getaccountlist(){
        $searchTerm=$this->input->post('searchTerm');
        $companyid=$this->input->post('companyid');
        $branchid=$this->input->post('branchid');

        $result=get_all_accounts($searchTerm, $companyid, $branchid);
	}
}