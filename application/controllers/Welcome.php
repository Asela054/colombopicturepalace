<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$this->load->view('login');
	}
	public function LoginUser(){
		$this->load->model('Userinfo');
        $result=$this->Userinfo->LoginUser();
		//  print_r($result['user_data']);
		$AccountAPIURL='http://localhost/accountscode/';

        if($result['user_data']!=false){
            $user_data=array(
                'userid'=>$result['user_data']->idtbl_user,
                'name'=>$result['user_data']->name,
                'type'=>$result['user_data']->idtbl_user_type,
                'typename'=>$result['user_data']->type,
				'company_id'=>$result['company_id'],
				'companyname'=>$result['company_name'],
				'branch_id'=>$result['branch_id'],
				'branchname'=>$result['branch_name'],
				'branchname'=>$result['branch_name'],
				'accountapiurl'=>$AccountAPIURL,
                'loggedin'=>true
            );

			$this->session->set_userdata($user_data);
			
			redirect('Welcome/Dashboard');            
        }
        else{
            $this->session->set_flashdata('msg', 'Invalid Username or password');
            redirect();
        }
	}
	public function Logout(){
        $this->session->unset_userdata('userid');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('type');
        $this->session->unset_userdata('typename');
		$this->session->unset_userdata('company_id');
		$this->session->unset_userdata('companyname');
		$this->session->unset_userdata('branch_id');
		$this->session->unset_userdata('branchname');
		$this->session->unset_userdata('accountapiurl');
        $this->session->unset_userdata('loggedin');
        $this->cart->destroy();

		
        redirect(base_url());
    }
	public function Dashboard(){
		$this->load->model('Commeninfo');
		$this->load->model('DashboardInfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['materialinfo']=$this->DashboardInfo->DashMaterialInfo();
		$result['zerostockinfo']=$this->DashboardInfo->DashZeroStockInfo();
		$result['lowstockinfo']=$this->DashboardInfo->DashLowStockInfo();
		$result['resultdate']=$this->DashboardInfo->DashLastFiveInfo();
		$result['resultqty']=$this->DashboardInfo->DashTopFiveInfo();
		$result['resultnonmove']=$this->DashboardInfo->DashNonMoveInfo();
		$this->load->view('dashboard', $result);
	}
	public function Getbranchaccocompany(){
		$recordID=$this->input->post('company_id');
        $result=CompanyBranchList($recordID);
	}
}
