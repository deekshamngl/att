<?php   
defined('BASEPATH') OR exit('No direct script access allowed');
class Buypackage extends CI_Controller {
	 public function __construct()
    {
	    parent::__construct();
        $this->load->model('buypackage_model');
    }
	 
	public function index()
	{
		$result['data']=$this->buypackage_model->getPackagesDetail();	
		$this->load->view('buy/packages',$result);
	}
	public function buynow($_pno)
	{	$result['id']=$_pno;
	$result['data']=$this->buypackage_model->getPackagesDetail();	
		$this->load->view('buy/buynow',$result);
	}
	public function organization(){
        $country_data['h'] = $this->ubitech_model->getCountries();
		$this->load->view('ubitech/organization',$country_data);
	}
	public function vieworg()
	{   $data['id']=0;
		$this->load->model("Bypackage_model");
		$data['myplan']=$this->Bypackage_model->MyPlan();
		$this->load->view('buy/buynow1',$data);
	}
	public function getOrganizationData($id="",$packageId=1){
         $org= $this->buypackage_model->getOrganizationData($id,$packageId);   		
	}
	public function registerOrganization(){
		$result = $this->ubitech_model->register_org();
		$this->load->view('ubitech/organization');
	}
	public function editOrganizationData($id){
		$result['data'] = $this->ubitech_model->editOrganizationData($id);
		$result['h'] = $this->ubitech_model->getCountries();
		$result['t'] = $this->ubitech_model->getTrialData($id);
		$this->load->view('ubitech/editorganization',$result);
	}
	public function getPackageData(){
        $this->ubitech_model->getPackageData();
	}
	public function package(){
		 $this->load->view('buy/package');	
	}
	public function editPackageData($id){
        $this->BuyPackage_model->editPackageData();
		redirect(URL."BuyPackage/editPackageData/".$id);
        exit();
	}
	public function getPackageData1($id){
		$this->load->model('buypackage_model');
		$data = $this->buypackage_model->getPackageData1($id);
		echo json_encode($data);	
		
	}
	function PayuMoney($amount){
		$data['amount'] = $amount;
		$this->load->view('buy/payUmoney',$data);
	}
	
	function PayuMoneySuccess(){
	   echo 'Success';	
	}
	
	function PayuMoneyFailed(){
		echo 'Failed';
	}
	
	
}
