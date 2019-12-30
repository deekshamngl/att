<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Att_services_offline extends CI_Controller{
	function __construct()
    {
        parent::__construct();
		$this->load->model('Att_services_model_offline');
    }
	
	public function getCountries(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getCountries();
	}
	public function getAttendancees(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getAttendancees();
	}
	public function getAreaStatus(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getAreaStatus();
	}
	
	public function getOrganization($id){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getOrganization($id);
	}
	
	public function checkLogin(){
		header('Access-Control-Allow-Origin: *');
		//echo $userName=isset($_REQUEST['userName'])?$_REQUEST['userName']:'';
		//echo $password=encode5t(isset($_REQUEST['password'])?$_REQUEST['password']:'');
		 $result = $this->Att_services_model_offline->checkLogin();
	}
	
	public function register_org(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->register_org();
	}
	
	public function getAllDesg($orgid){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getAllDesg($orgid);
	}
	
	public function getAllDept($orgid){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getAllDept($orgid);
	}
	public function DesignationMaster(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->DesignationMaster();
	}
	
	public function DepartmentMaster(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->DepartmentMaster();
	}
	
	public function shiftMaster(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->shiftMaster();
	}
	public function registerEmp(){
		
		header('Access-Control-Allow-Origin: *');
		try{
		$this->Att_services_model_offline->registerEmp();
		}catch(Exception $e){
			Trace($e->getMessage());
			echo $e->getMessage();
		}
	}
	
	public function checkOrganization(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->checkOrganization();
	}
	
	public function getImage(){
		header('Access-Control-Allow-Origin: *');
		
		echo isset($_REQUEST["uid"])? $_REQUEST["uid"]: 0;  
	}
	public function saveImage(){
		header('Access-Control-Allow-Origin: *');
		$orgid   = isset($_REQUEST['refid']) ? $_REQUEST['refid'] : 0;
		$this->Att_services_model_offline->saveImage();  
	//	if($orgid==10)
			//$this->Att_services_model_offline->test();  
	//	else
	//		$this->Att_services_model_offline->saveImage();  
	}
	public function saveVisit(){
		header('Access-Control-Allow-Origin: *');
		$orgid   = isset($_REQUEST['refid']) ? $_REQUEST['refid'] : 0;
		$this->Att_services_model_offline->saveVisit();  
	}
	public function saveVisitOut(){
		header('Access-Control-Allow-Origin: *');
		$orgid   = isset($_REQUEST['refid']) ? $_REQUEST['refid'] : 0;
		$this->Att_services_model_offline->saveVisitOut();  
	}
	public function saveImageFromChrome(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->saveImageFromChrome();  
	}
	public	function getUserPermission(){
		try{	
			$perarray = $this->Att_services_model_offline->getUserPermission();
			echo json_encode($perarray);
		}catch(Exception $e){
			echo $e->getMessage();
		}		
	}
	public function getInfo(){
	
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getInfo();  
	}
	public function saveOfflineData(){
	
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->saveOfflineData();  
	}
	
	public function getPunchInfo(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getPunchInfo();  
	}
	public function getPunchedLocations(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getPunchedLocations();  
	}
	public function getHistory(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getHistory();  
	}
	public function getSlider(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getSlider();  
	}
	public function getAttendanceMobile(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getAttendanceMobile();  
	}
	public function getIndivisualReportData(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getIndivisualReportData();  
	}
	public function getLateComings(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getLateComings();  
	}
	public function getEarlyLeavings(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getEarlyLeavings();  
	}
	public function getBreakInfo(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getBreakInfo();  
	}
	public function timeBreak(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->timeBreak();  
	}
	public function changePassword(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->changePassword();  
	}
	public function getProfile(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getProfile();  
	}
	public function updateProfile(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->updateProfile();  
	}
	 public function updateProfilePhoto(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->updateProfilePhoto();  
	}
	public function resend_verification_mail(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->resend_verification_mail();  
	}
	public function resetPasswordLink(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->resetPasswordLink();  
	}
	public function HastaLaVistaUbi(){
		header('Access-Control-Allow-Origin: *');
		$data=array();
		$uid=isset($_REQUEST['hasta'])?decrypt($_REQUEST['hasta']):'';
		$orgid=isset($_REQUEST['vista'])?decrypt($_REQUEST['vista']):0;
		$counter=isset($_REQUEST['ctrpvt'])?decrypt($_REQUEST['ctrpvt']):'';
		$res=$this->Att_services_model_offline->checkLinkValidity($uid,$orgid,$counter);
	if($res){
		$data['uid']=$uid;
		$data['orgid']=$orgid;
		$this->load->view('home/resetPasswordLinkPage');	
	}else
		echo '<center><h2 style="margin-top:20%;color:red">Your reset password Link has been expired.</h2></center>';
//		$this->login_model->resetPasswordLinkPage($data);
		//$this->Att_services_model_offline->HastaLaVistaUbi();  
	}
	public function setPassword(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->setPassword();  
	}
	public function getUsersMobile(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getUsersMobile();  
	}
	public function getSuperviserSts(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getSuperviserSts(); 
	}
	public function addShift(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->addShift();  
	}
	public function addDesg(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->addDesg();  
	}
	public function updateDept(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->updateDept();
	}
	public function updateDesg(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->updateDesg();
	}
	public function updateShift(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->updateShift();
	}
	public function addDept(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->addDept();
	}
	public function addCheckin(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->addCheckin();
	}
	public function getTimeoffList(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getTimeoffList();  
	}
	public function getLeaveList(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getLeaveList();  
	}
	public function getAppVersion(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getAppVersion();  
	}
	public function checkMandUpdate(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->checkMandUpdate();  
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
		if($this->Att_services_model_offline->activateAccount())
		{
			echo '<html><head><meta name="viewport" content="width=device-width, initial-scale=1.0"><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"></head><body><center><h3 style="color:green">Your account has been activated successfully. Thank you!</h3>
			</center></body></html>';
			/*<a class="btn btn-primary visible-md visible-lg" style="max-width:200px;" href="https://ubiattendance.ubihrm.com/" target="_self">Take Me to Login</a>*/
		}else{
			echo '<html><head><meta name="viewport" content="width=device-width, initial-scale=1.0"> </head><body><center><h3 style="color:orange">Your account is already activated. if you need any further assistance please mail us at <a href="mailto:support@ubitechsolutions.com">support@ubitechsolutions.com</a>. Thank you!</h3>
			</center></body></html>';
		}
	
	}
	public function activateOrg(){
		header('Access-Control-Allow-Origin: *');
		if($this->Att_services_model_offline->activateOrg())
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
	
	/////////////////////////////--importing from HRM-start
	public function getModules()
	{
		 header('Access-Control-Allow-Origin: *');
		 $response = $this->Att_services_model_offline->getModules();
		 echo json_encode($response);
	}
	public function punchLocation(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->punchLocation();  
	}
	public function skipPunch(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->skipPunch();  
	}
	public function fetchTimeOffList(){
		header('Access-Control-Allow-Origin: *');
		try{
		$this->Att_services_model_offline->fetchTimeOffList();  
		}catch(Exception $e){echo 'Exceptipn occured';}
	}
/* 	public function reqForTimeOff(){
		header('Access-Control-Allow-Origin: *');
		try{
		$this->Att_services_model_offline->reqForTimeOff();  
		}catch(Exception $e){echo 'Exceptipn occured';}
	} */
	public function reqForTimeOff(){
		header('Access-Control-Allow-Origin: *');
		try{		
		$deptarray = $this->Att_services_model_offline->Createtimeoff();  
		echo json_encode($deptarray);
		}catch(Exception $e){echo 'Exceptipn occured';}
	}
	
	function changetimeoffsts(){	
		header('Access-Control-Allow-Origin: *');
		try{		
		$deptarray = $this->Att_services_model_offline->UpdateTimeoffSts();
		echo json_encode($deptarray);			
		}catch(Exception $e){echo $e->getMessage();}
    }
	
	public function saveAllDesgPermission(){
		header('Access-Control-Allow-Origin: *');
		try{
		$perarray = $this->Att_services_model_offline->updatePermission();
		echo json_encode($perarray);
		}catch(Exception $e){echo 'Exceptipn occured';}
	}
	/////////////////////////////--importing from HRM-close
	public	function getAllDesgPermission(){
		try{	
			$perarray = $this->Att_services_model_offline->getAllDesgPermission();
			echo json_encode($perarray);
		}catch(Exception $e){
			echo $e->getMessage();
		}		
	}
	
	public function getEmpHistoryOf30(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getEmpHistoryOf30();  
	}
	public function getEmployeesList(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getEmployeesList();  
	}
	public function getAttendances_new(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getAttendances_new();  
	}
	public function getCDateAttendances_new(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getCDateAttendances_new();  
	}
	public function getCDateAttnDeptWise_new(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getCDateAttnDeptWise_new();  
	}
	public function getEmpdataDepartmentWise(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getEmpdataDepartmentWise();  
	}
	public function getCDateAttnDesgWise_new(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getCDateAttnDesgWise_new();  
	}
	
	public function getChartDataToday(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getChartDataToday();  
	}
	public function getAttendances_yes(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getAttendances_yes();  
	}
	public function getChartDataYes(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getChartDataYes();  
	}
	public function getChartDataCDate(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getChartDataCDate();  
	}
	public function getChartDataLast_7(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getChartDataLast_7();  
	}
	public function getChartDataLast_30(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getChartDataLast_30();  
	}
	public function getAttnDataLast(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getAttnDataLast();  
	}
	
	///////////-------------test
	public function test(){
		
		if(strtotime('06:00')<strtotime('18:00'))
			echo 'condition 1 true';
		else
			echo 'condition 2 true';
		return;
	//	$this->Att_services_model_offline->test(); 
	//	return false;
		$pwd=isset($_REQUEST['pwd'])?$_REQUEST['pwd']:'';
		echo encode5t('12345');
		echo '<br>';
		echo decode5t($pwd);
			return false;
			header('Access-Control-Allow-Origin: *');
			$this->Att_services_model_offline->test();
			return false;
			$pwd=isset($_REQUEST['pwd'])?$_REQUEST['pwd']:'';
			echo decode5t($pwd);
			return false;
			
			$org_name=isset($_REQUEST['org_name'])?$_REQUEST['org_name']:"No name";
			//$myname=isset($_REQUEST['myname'])?$_REQUEST['myname']:"No name";
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
	//		$res=$this->Att_services_model_offline->mailtest();  
	//		$res=mail("vijay@ubitechsolutions.com","Testing Mail","Testing Mail body");
	//		echo "response: ".$res;
			//$this->Att_services_model_offline->test();  
	}
	
	public function testJSON(){
		$arr=array();
		$arr[]='ajay';
		$arr[]='amit';
		$arr[]='ajit';
		$arr[]='aakash';
		$arr[]='aashi';
		echo json_encode($arr); 
	}
	
	public function CreateBulkAtt(){
		header('Access-Control-Allow-Origin: *');
		try{
		$perarray = $this->Att_services_model_offline->CreateBulkAtt();
		echo json_encode($perarray);
		}catch(Exception $e){echo 'Exceptipn occured';}
	}
	
	public function getDeptEmp(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getDeptEmp();  
	}
	
	 public	function backgroundLocationService()
    {
    
    header('Access-Control-Allow-Origin: *');
		try{
		
		$latitude = isset($_REQUEST['latitude']) ? $_REQUEST['latitude'] : "";
   		$longitude = isset($_REQUEST['longitude']) ? $_REQUEST['longitude'] : "";
   		$address = isset($_REQUEST['address']) ? $_REQUEST['address'] : "";
   		$empid = isset($_REQUEST['empid']) ? $_REQUEST['empid'] : "";
   		$time =date("H:i:s");
		Trace("This is background ".$time." Latitude ".$latitude." Longitude ".$longitude." Address ".$address." Empid ".$empid);
		
		
		$this->Att_services_model_offline->backgroundLocationService();
		
		}catch(Exception $e){
		//echo 'Exceptipn occured';
		Trace($e->getMessage());
		}
    
    }
    
    	 public	function getEmplolyeeTrackTime()
    {
    
    header('Access-Control-Allow-Origin: *');
		try{

		$this->Att_services_model_offline->getEmplolyeeTrackTime();
		
		}catch(Exception $e){
		//echo 'Exceptipn occured';
		Trace($e->getMessage());
		}
    
    }
    
	public function getClientsDDList(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getClientsDDList();
	}
	
	public function saveFlexi(){
		header('Access-Control-Allow-Origin: *');
		$orgid   = isset($_REQUEST['refid']) ? $_REQUEST['refid'] : 0;
		$this->Att_services_model_offline->saveFlexi();  
	}
	public function saveFlexiOut(){
		header('Access-Control-Allow-Origin: *');
		$orgid   = isset($_REQUEST['refid']) ? $_REQUEST['refid'] : 0;
		$this->Att_services_model_offline->saveFlexiOut();  
	}
	public function getFlexiInfo(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getFlexiInfo();  
	}public function getAttendanceesFlexi(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getAttendanceesFlexi();  
	}
	public function getFlexiInfoReport(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model_offline->getFlexiInfoReport();  
	}
}	
?>
