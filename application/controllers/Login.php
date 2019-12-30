<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
	 public function __construct()
    {
	    parent::__construct();
        $this->load->model('login_model');
        $this->load->library('form_validation');



    }
	 
	public function index()
	{
		$this->load->view('login/login');
	}
	public function keepattendance()
	{
	 $this->load->view('login/keepattendance');	
	}
	
	public function statuschanged()
	{
	 $this->login_model->statuschanged();
	}
	
	
	public function login(){
		
		    $res[]=array();
			$val=$this->login_model->login();
			echo $val;
	}
	
	public function forgotpswd(){
			$val=$this->login_model->forgotpswd();
			//$val=$this->login_model->mailtest();
	}

	public function approvetimeoffbymail($user_id=1,$org_id=10,$employeetimeoffid=1,$approverresult=0){
		
		$appSts=$this->login_model->getpreviousTimeOffApprovalSts($user_id,$org_id,$employeetimeoffid);
		// $update=$this->login_model->updatetimeoff($user_id,$org_id,$employeetimeoffid,$appSts);
		$gtos=$this->login_model->getTimeOffApprovalSts($employeetimeoffid);
		// $list=$this->login_model->gettimeoffreq();

		$arr = array('uid'=> $user_id, 'orgid' => $org_id, 'timeoffid' => $employeetimeoffid, 'approverresult' => $approverresult , 'ptoff' => $appSts,'gtos'=>$gtos);

		// $this->load->view('leave/timeoff/timeoffaction',$arr);
		    $this->load->view('leave/timeoff/timeoffaction',$arr);

		// var_dump($employeetimeoffid);
		// var_dump($update);
		// var_dump($arr);
	}

	// public function approvetimeoffapproval()
	// {

	// 	try{
	// 		$ubihrm_timezone = $this->getTimeZone($_POST["org_id"]);
	// 		if($ubihrm_timezone){
	// 			define('TIMEZONE1', $ubihrm_timezone);
	// 			date_default_timezone_set(TIMEZONE1);
	// 			// date_default_timezone_set ($zname);
	// 		}
	// 		$arr = array();
	// 		$arr[0] = $_POST["userid"];
	// 		$arr[1] = $_POST["org_id"];
	// 		$arr[2] = $_POST["employeetimeoffid"];
	// 		$arr[3] = $_POST["approverresult"];
	// 		$arr[4] =  $_POST["comment"];
	// 		$dept = $this->login_model->ApproveTimeoff($arr);
	// 		// $deptarray = $dept->ApproveTimeoff($arr);
	// 		echo json_encode($dept);
	// 	}catch(Exception $e){
	// 		Trace($e->getMessage());
	// 	}
	// }


	public function timeoffstatus(){

		$this->login_model->timeoffstatus();
	}

	// function approveleaveapproval()
	// {
	// 	try{
	// 		$ubihrm_timezone = $this->getOrgTimezone($_POST["org_id"]);
	// 		if($ubihrm_timezone){
	// 			define('TIMEZONE1', $ubihrm_timezone);
	// 			date_default_timezone_set(TIMEZONE1);
	// 		}
	// 		$arr = array();
	// 		$arr[0] = $_POST["userid"];
	// 		$arr[1] = $_POST["org_id"];
	// 		$arr[2] = $_POST["employeeleaveid"];
	// 		$arr[3] = $_POST["approverresult"];
	// 		$arr[4] =  $_POST["comment"];
	// 		$arr[5] = "";
			
	// 		// $dept = $this->loadModel('Leaveapproval');
	// 		$deptarray = $dept->Approve($arr);
	// 		//echo json_encode($deptarray);	
	// 		//echo $deptarray['successMsg'];
	// 		echo json_encode($deptarray);
	// 	}catch(Exception $e){
	// 		Trace($e->getMessage());
	// 	}
	// }
	 

	
public function viewapproveleaveapproval($user_id=1,$org_id=10,$employeeleaveid=1,$approverresult=0)
	{
		try{
			$ubihrm_timezone = $this->getOrgTimezone($org_id);
			if($ubihrm_timezone){
			define('TIMEZONE1', $ubihrm_timezone);
			date_default_timezone_set(TIMEZONE1);
			}
			$gtoff=$this->load->login_model->getpreviousApprovalSts($user_id,$org_id,$employeeleaveid);
			$tof=$this->load->login_model->getApprovalSts($employeeleaveid);

			$arr = array('userid'=>$user_id,'orgid'=>$org_id,'eid'=>$employeeleaveid,'asr'=>$approverresult,'gtoff'=>$gtoff,'tof'=>$tof);
			// $this->view->userid = $arr[0] = $user_id;
			// $this->view->org_id = $arr[1] = $org_id;
			// $this->view->employeeleaveid = $arr[2] = $employeeleaveid;
			// $this->view->approverresult = $arr[3] = $approverresult;
			// $arr[4] = "";
			// $arr[5] = "";
			// $dept = $this->loadModel('Leaveapproval');
			
			
			//$this->view->appSts = true;
			$this->load->view('leave/leaveapproval/approvebymail',$arr);
			//echo json_encode($deptarray);	
			//echo $deptarray['successMsg'];
			//echo "<h3>" .$deptarray['successMsg']. "</h3>";
		}catch(Exception $e){
			Trace($e->getMessage());
		}
	}
		public function approvetimeoffapprovalreject()
	{
		// try{
		// 	$ubihrm_timezone = getTimezone(isset($_POST["org_id"]));
		// 	if($ubihrm_timezone){
		// 		define('TIMEZONE1', $ubihrm_timezone);
		// 		date_default_timezone_set(TIMEZONE1);
		// 	}
			$arr = array();
			// print_r(isset($_REQUEST["uid"]));
			// print_r(isset($_REQUEST["orgid"]));
			// print_r(isset($_REQUEST["timeoffid"]));
			// print_r(isset($_REQUEST["approverresult"]));
			// print_r(isset($_REQUEST["remark"]));
			$arr[0] = isset($_REQUEST["uid"])?$_REQUEST["uid"]:0;
			$arr[1] = isset($_REQUEST["orgid"])?$_REQUEST["orgid"]:0;
			$arr[2] = isset($_REQUEST["timeoffid"])?$_REQUEST["timeoffid"]:0;
			$arr[3] = isset($_REQUEST["approverresult"])?$_REQUEST["approverresult"]:0;
			$arr[4] = isset($_REQUEST["remark"])?$_REQUEST["remark"]:0;

			// print_r($arr);
			// var_dump($arr[1]);
			// $dept = $this->loadModel('Leaveapproval');
			$deptarray = $this->login_model->ApproveTimeoff($arr);
			echo json_encode($deptarray);
		// }catch(Exception $e){
		// 	Trace($e->getMessage());
		// }
	}

		public function approvetimeoffapprovalapprove()
	{
		// try{
		// 	$ubihrm_timezone = getTimezone(isset($_POST["org_id"]));
		// 	if($ubihrm_timezone){
		// 		define('TIMEZONE1', $ubihrm_timezone);
		// 		date_default_timezone_set(TIMEZONE1);
		// 	}
			$arr = array();
			// print_r(isset($_REQUEST["uid1"]));
			// print_r(isset($_REQUEST["orgid1"]));
			// print_r(isset($_REQUEST["timeoffid1"]));
			// print_r(isset($_REQUEST["approverresult1"]));
			// print_r(isset($_REQUEST["remark1"]));
			$arr[0] = isset($_REQUEST["uid1"])?$_REQUEST["uid1"]:0;
			$arr[1] = isset($_REQUEST["orgid1"])?$_REQUEST["orgid1"]:0;
			$arr[2] = isset($_REQUEST["timeoffid1"])?$_REQUEST["timeoffid1"]:0;
			$arr[3] = isset($_REQUEST["approverresult1"])?$_REQUEST["approverresult1"]:0;
			$arr[4] = isset($_REQUEST["remark1"])?$_REQUEST["remark1"]:0;

			// print_r($arr);
			// var_dump($arr[1]);
			// $dept = $this->loadModel('Leaveapproval');
			$deptarray = $this->login_model->ApproveTimeoff($arr);
			echo json_encode($deptarray);
		// }catch(Exception $e){
		// 	Trace($e->getMessage());
		// }
	}

}
