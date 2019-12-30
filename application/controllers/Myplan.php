<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Myplan extends CI_Controller {
	 public function __construct()
    {
	    parent::__construct();
		
        $this->load->model('MyPlan_model');
		handleLogin();
    } 
	public function index()	
	{
       // $data['myplan']= $this->MyPlan_model->MyPlan();	
		//if(isset($_SESSION['txnd']))
		unset($_SESSION['txnd']);
		$data['myplan']= $this->MyPlan_model->MyPlan();
		//echo json_encode($this->MyPlan_model->MyPlan());
		 if($_SESSION['p_status']==0) // if user is in trial case 
			 $this->load->view('home/MyPlan12',$data);	   
		 else  
			 $this->load->view('home/renewal',$data);// if plan renewal case
	}
	public function balancedues()
	{
		$data['myplan']= $this->MyPlan_model->MyPlan();
		 $this->load->view('home/balancedues',$data);	
	}
	public function addons()	
	{
       // $data['myplan']= $this->MyPlan_model->MyPlan();	
		//if(isset($_SESSION['txnd']))
		unset($_SESSION['txnd']);
		$data['myplan']= $this->MyPlan_model->MyPlan();
		$this->load->view('home/myaddons',$data);	 
	}
	public function success()
	{
		$result=array();
		//$result = $this->MyPlan_model->PaymentSuccess();
		$result = $this->MyPlan_model->PaymentSuccesspaypal();
		//print_r($result);
		//exit();
		$this->load->view('home/success',$result);
	}
	public function failed()
	{
		$result=array();
		$result = $this->MyPlan_model->PaymentFailed();
		$this->load->view('home/failed');
	}
	 function generateInvoice($arr){
		 $data=array();
		 $data['data']=$_SESSION['invoice'];
	//	 print_r($data);
		 $this->load->view('pdf/generateinvoice',$data,$arr);
   }
   function UpgradePlan_Successpaypal(){
	   $result = $this->MyPlan_model->UpgradePlan_Successpaypal();
	//	print_r($result);
		//exit();
		
		$this->load->view('home/success',$result);
   }
   
   public function success_payUMoney ()
	{
		//$result=array();
		$result = $this->MyPlan_model->UpgradePlan_Successpaypal();
		$this->load->view('home/success',$result);
	}
	public function failed_payUMoney()
	{	
		$this->load->view('home/failed');
	}
	public function failed_upgrade()
	{	
		$result=array();
		$result = $this->MyPlan_model->UpgradePlan_Failed();
		$this->load->view('home/failed');
	}
	public function saveTempPay()
	{
		try{
			$data = $this->MyPlan_model->saveTempPay();
		}catch(Exception $e){
			echo $e->getMessage();
			
		}
	}
}
