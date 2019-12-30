<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Services extends CI_Controller{
	function __construct()
    {
		
        parent::__construct();
		$this->load->model('Services_model');
//		include(APPPATH."PhpMailer/class.phpmailer.php");
    }
	
	public function getCountries(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->getCountries();
	}
	
	public function getOrganization($id){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->getOrganization($id);
	}
	
	public function checkLogin(){
		header('Access-Control-Allow-Origin: *');
		
		//echo $userName=isset($_REQUEST['userName'])?$_REQUEST['userName']:'';
		//echo $password=encode5t(isset($_REQUEST['password'])?$_REQUEST['password']:'');
		 $result = $this->Services_model->checkLogin();
		 
		
	}
	
	public function register_org(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->register_org();
	}
	
	public function getAllDesg($orgid){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->getAllDesg($orgid);
	}
	
	public function getAllDept($orgid){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->getAllDept($orgid);
	}
	public function DesignationMaster($orgid){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->DesignationMaster($orgid);
	}
	
	public function DepartmentMaster($orgid){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->DepartmentMaster($orgid);
	}
	
	public function shiftMaster($orgid){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->shiftMaster($orgid);
	}
	public function registerEmp(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->registerEmp();
	}
	
	public function checkOrganization(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->checkOrganization();
	}
	
	public function getImage(){
		header('Access-Control-Allow-Origin: *');
		
		echo isset($_REQUEST["uid"])? $_REQUEST["uid"]: 0;  
	}
	public function saveImage(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->saveImage();  
	}
	public function getInfo(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->getInfo();  
	}
	public function getPunchInfo(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->getPunchInfo();  
	}
	public function getPunchedLocations(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->getPunchedLocations();  
	}
	public function getTodaysPunchLocs(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->getTodaysPunchLocs();  
	}
	public function getHistory(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->getHistory();  
	}
	public function getSlider(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->getSlider();  
	}
	public function getAttendanceMobile(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->getAttendanceMobile();  
	}
	public function getIndivisualReportData(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->getIndivisualReportData();  
	}
	public function getLateComings(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->getLateComings();  
	}
	public function getEarlyLeavings(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->getEarlyLeavings();  
	}
	public function getBreakInfo(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->getBreakInfo();  
	}
	public function timeBreak(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->timeBreak();  
	}
	public function changePassword(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->changePassword();  
	}
	public function getProfile(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->getProfile();  
	}
	public function updateProfile(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->updateProfile();  
	}
	public function resetPasswordLink(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->resetPasswordLink();  
	}
	public function HastaLaVistaUbi(){
		header('Access-Control-Allow-Origin: *');
		$data=array();
		$uid=isset($_REQUEST['hasta'])?decrypt($_REQUEST['hasta']):'';
		$orgid=isset($_REQUEST['vista'])?decrypt($_REQUEST['vista']):0;
		$counter=isset($_REQUEST['ctrpvt'])?decrypt($_REQUEST['ctrpvt']):'';
		$res=$this->Services_model->checkLinkValidity($uid,$orgid,$counter);
	if($res){
		$data['uid']=$uid;
		$data['orgid']=$orgid;
		$this->load->view('home/resetPasswordLinkPage');	
	}else
		echo '<center><h2 style="margin-top:20%;color:red">Your reset password Link has been expired.</h2></center>';
//		$this->login_model->resetPasswordLinkPage($data);
		//$this->Services_model->HastaLaVistaUbi();  
	}
	public function setPassword(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->setPassword();  
	}
	public function getUsersMobile(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->getUsersMobile();  
	}
	public function getSuperviserSts(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->getSuperviserSts(); 
	}
	public function addShift(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->addShift();  
	}
	public function addDesg(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->addDesg();  
	}
	public function addDept(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->addDept();
	}
	public function addCheckin(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->addCheckin();
	}
	public function getTimeoffList(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->getTimeoffList();  
	}
	public function getAppVersion(){
		header('Access-Control-Allow-Origin: *');
		$this->Services_model->getAppVersion();  
	}
	function useridcard($org,$user)
	{
		header('Access-Control-Allow-Origin: *');
		$data=array();
		$data['org']=getOrgName($org);
		$data['emp']=getEmpName($user);
		$data['dept']=getDepartmentByEmpID($user);
		$data['desg']=getDesignationByEmpID($user);
		$data['shift']=getShiftByEmpID($user);
		$data['una']=getQRLoginDetailByEmpID($user);
		$this->load->view('open/useridcard',$data);	
	}
	public function activateAccount(){
		header('Access-Control-Allow-Origin: *');
		if($this->Services_model->activateAccount())
		{
			echo '<html><head><meta name="viewport" content="width=device-width, initial-scale=1.0"><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"></head><body><center><h3 style="color:green">Your account has been activated successfully. Thank you!</h3></center></body></html>';
			/*<a class="btn btn-primary visible-md visible-lg" style="max-width:200px;" href="https://ubiattendance.ubihrm.com/" target="_self">Take Me to Login</a>*/
		}else{
			echo '<html><head><meta name="viewport" content="width=device-width, initial-scale=1.0"> </head><body><center><h3 style="color:orange">Your account is already activated. if you need any further assistance please mail us at <a href="mailto:support@ubitechsolutions.com">support@ubitechsolutions.com</a> Thank you!</h3></center></body></html>';
		}
	
	}
	public function activateOrgAccount(){
		header('Access-Control-Allow-Origin: *');
		if($this->Services_model->activateOrg())
		{
			echo '<html><head><meta name="viewport" content="width=device-width, initial-scale=1.0"><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"></head><body><center><h3 style="color:green">Your account has been activated successfully. Thank you!</h3></center></body></html>';
			/*<a class="btn btn-primary visible-md visible-lg" style="max-width:200px;" href="https://ubiattendance.ubihrm.com/" target="_self">Take Me to Login</a>*/
		}else{
			echo '<html><head><meta name="viewport" content="width=device-width, initial-scale=1.0"> </head><body><center><h3 style="color:orange">Your account is already activated. if you need any further assistance please mail us at <a href="mailto:support@ubitechsolutions.com">support@ubitechsolutions.com</a> Thank you!</h3></center></body></html>';
		}
	
	}
	public function activateOrg(){
		header('Access-Control-Allow-Origin: *');
		if($this->Services_model->activateOrg())
		{
			echo '<html><head><meta name="viewport" content="width=device-width, initial-scale=1.0"><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"></head><body><center><h3 style="color:green">This account has been activated successfully. Thank you!</h3>
			</center></body></html>';
		}else{
			echo '<html><head><meta name="viewport" content="width=device-width, initial-scale=1.0"> </head><body><center><h3 style="color:orange">This account is already activated. Thank you!</h3>
			</center></body></html>';
		}
	
	}
	public function regInvEmp(){
		$this->load->view('open/registerEmp');
	}
	public function thanks(){
		$this->load->view('open/thanks');
	}
	///////////-------------test
	public function test(){
			header('Access-Control-Allow-Origin: *');
			
			
			$org_name=isset($_REQUEST['org_name'])?$_REQUEST['org_name']:"No name";
		//	$myname=isset($_REQUEST['myname'])?$_REQUEST['myname']:"No name";
			$name=isset($_REQUEST['name'])?$_REQUEST['name']:"No name";
			$email=isset($_REQUEST['email'])?$_REQUEST['email']:"No name";
			$password=isset($_REQUEST['password'])?$_REQUEST['password']:"No name";
			$countrycode=isset($_REQUEST['countrycode'])?$_REQUEST['countrycode']:"No name";
			$phone=isset($_REQUEST['phone'])?$_REQUEST['phone']:"No name";
			$country=isset($_REQUEST['country'])?$_REQUEST['country']:"No name";
			$Address=isset($_REQUEST['address'])?$_REQUEST['address']:"No name";
		echo "org_name: ".$org_name." name: ".$name." email: ".$email." password: ".$password." countrycode: ".$countrycode." phone: ".$phone." country: ".$country." Address: ".$Address;
			
			
	//		echo getTimeZone(96);
	//		$res=0;
	//		$res=$this->Services_model->mailtest();  
	//		$res=mail("vijay@ubitechsolutions.com","Testing Mail","Testing Mail body");
	//		echo "response: ".$res;
			//$this->Services_model->test();  
	}
	///////////-------------test/
}	
?>