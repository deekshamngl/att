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
	 
        $data['myplan']= $this->MyPlan_model->MyPlan();
       	  // var_dump($data);
       $this->load->view('home/MyPlan12',$data);	   
	}
	public function success ()
	{
		//$result=array();
		$result = $this->MyPlan_model->PaymentSuccess();
		$this->load->view('home/success',$result);
	}
	public function failed()
	{
		$this->load->view('home/failed');
	}
	 function generateInvoice($arr){
		 $data=array();
		 $data['data']=$_SESSION['invoice'];
	//	 print_r($data);
		$this->load->view('pdf/generateinvoice',$data,$arr);
   }
}
