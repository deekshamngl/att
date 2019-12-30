<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Att_services extends CI_Controller{
	function __construct()
    {
        parent::__construct();
		$this->load->model('Att_services_model');
    }
	
	public function getCountries(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getCountries();
	}
	public function getAttendancees(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getAttendancees();
	}
	public function getAreaStatus(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getAreaStatus();
	}
	
	public function getOrganization($id){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getOrganization($id);
	}
	
	public function checkLogin(){
		header('Access-Control-Allow-Origin: *');
		//echo $userName=isset($_REQUEST['userName'])?$_REQUEST['userName']:'';
		//echo $password=encode5t(isset($_REQUEST['password'])?$_REQUEST['password']:'');
		 $result = $this->Att_services_model->checkLogin();
	}
	
	public function register_org(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->register_org();
	}
	
	public function getAllDesg($orgid){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getAllDesg($orgid);
	}
	
	public function getAllDept($orgid){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getAllDept($orgid);
	}
	public function DesignationMaster(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->DesignationMaster();
	}
	
	public function DepartmentMaster(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->DepartmentMaster();
	}
	
	public function shiftMaster(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->shiftMaster();
	}
	public function registerEmp(){
		
		header('Access-Control-Allow-Origin: *');
		try{
		$this->Att_services_model->registerEmp();
		}catch(Exception $e){
			Trace($e->getMessage());
			echo $e->getMessage();
		}
	}
		public function sendsms(){
		
		header('Access-Control-Allow-Origin: *');
		try{
		$this->Att_services_model->sendsms();
		}catch(Exception $e){
			Trace($e->getMessage());
			echo $e->getMessage();
		}
	}
	public function updateEmp(){
		
		header('Access-Control-Allow-Origin: *');
		try{
		$this->Att_services_model->updateEmp();
		}catch(Exception $e){
			Trace($e->getMessage());
			echo $e->getMessage();
		}
	}
	
	public function checkOrganization(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->checkOrganization();
	}
	
	public function getImage(){
		header('Access-Control-Allow-Origin: *');
		
		echo isset($_REQUEST["uid"])? $_REQUEST["uid"]: 0;  
	}
	public function saveImage(){
		header('Access-Control-Allow-Origin: *');
		$orgid   = isset($_REQUEST['refid']) ? $_REQUEST['refid'] : 0;
		$this->Att_services_model->saveImage();  
	//	if($orgid==10)
			//$this->Att_services_model->test();  
	//	else
	//		$this->Att_services_model->saveImage();  
	}
	public function saveVisit(){
		header('Access-Control-Allow-Origin: *');
		$orgid   = isset($_REQUEST['refid']) ? $_REQUEST['refid'] : 0;
		$this->Att_services_model->saveVisit();  
	}
	public function saveVisitOut(){
		header('Access-Control-Allow-Origin: *');
		$orgid   = isset($_REQUEST['refid']) ? $_REQUEST['refid'] : 0;
		$this->Att_services_model->saveVisitOut();  
	}
	public function saveImageFromChrome(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->saveImageFromChrome();  
	}
	public	function getUserPermission(){
		try{	
			$perarray = $this->Att_services_model->getUserPermission();
			echo json_encode($perarray);
		}catch(Exception $e){
			echo $e->getMessage();
		}		
	}
	public function getInfo(){
	
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getInfo();  
	}
	public function getPunchInfo(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getPunchInfo();  
	}
	public function getPunchedLocations(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getPunchedLocations();  
	}
	public function getHistory(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getHistory();  
	}
	public function getSlider(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getSlider();  
	}
	public function getAttendanceMobile(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getAttendanceMobile();  
	}
	public function getIndivisualReportData(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getIndivisualReportData();  
	}
	public function getLateComings(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getLateComings();  
	}
	public function getEarlyLeavings(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getEarlyLeavings();  
	}
	public function getBreakInfo(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getBreakInfo();  
	}
	public function timeBreak(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->timeBreak();  
	}
	public function changePassword(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->changePassword();  
	}
	public function getProfile(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getProfile();  
	}
	public function updateProfile(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->updateProfile();  
	}
	 public function updateProfilePhoto(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->updateProfilePhoto();  
	}
	public function resend_verification_mail(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->resend_verification_mail();  
	}
	public function resetPasswordLink(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->resetPasswordLink();  
	}
	public function HastaLaVistaUbi(){
		header('Access-Control-Allow-Origin: *');
		$data=array();
		$uid=isset($_REQUEST['hasta'])?decrypt($_REQUEST['hasta']):'';
		$orgid=isset($_REQUEST['vista'])?decrypt($_REQUEST['vista']):0;
		$counter=isset($_REQUEST['ctrpvt'])?decrypt($_REQUEST['ctrpvt']):'';
		$res=$this->Att_services_model->checkLinkValidity($uid,$orgid,$counter);
	if($res){
		$data['uid']=$uid;
		$data['orgid']=$orgid;
		$this->load->view('home/resetPasswordLinkPage');	
	}else
		echo '<center><h2 style="margin-top:20%;color:red">Your reset password Link has been expired.</h2></center>';
//		$this->login_model->resetPasswordLinkPage($data);
		//$this->Att_services_model->HastaLaVistaUbi();  
	}
	public function setPassword(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->setPassword();  
	}
	public function getUsersMobile(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getUsersMobile();  
	}
	public function getSuperviserSts(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getSuperviserSts(); 
	}
	public function addShift(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->addShift();  
	}
	public function addDesg(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->addDesg();  
	}
	public function updateDept(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->updateDept();
	}
	public function updateDesg(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->updateDesg();
	}
	public function updateShift(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->updateShift();
	}
	public function addDept(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->addDept();
	}
	public function addCheckin(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->addCheckin();
	}
	public function getTimeoffList(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getTimeoffList();  
	}
	public function getLeaveList(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getLeaveList();  
	}
	public function getAppVersion(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getAppVersion();  
	}
	public function UpdateStatus(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->UpdateStatus();  
	}
	public function checkMandUpdate(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->checkMandUpdate();  
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
		if($this->Att_services_model->activateAccount())
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
		if($this->Att_services_model->activateOrg())
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
		 $response = $this->Att_services_model->getModules();
		 echo json_encode($response);
	}
	public function punchLocation(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->punchLocation();  
	}
	public function skipPunch(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->skipPunch();  
	}
	public function fetchTimeOffList(){
		header('Access-Control-Allow-Origin: *');
		try{
		$this->Att_services_model->fetchTimeOffList();  
		}catch(Exception $e){echo 'Exceptipn occured';}
	}
/* 	public function reqForTimeOff(){
		header('Access-Control-Allow-Origin: *');
		try{
		$this->Att_services_model->reqForTimeOff();  
		}catch(Exception $e){echo 'Exceptipn occured';}
	} */
	public function reqForTimeOff(){
		header('Access-Control-Allow-Origin: *');
		try{		
		$deptarray = $this->Att_services_model->Createtimeoff();  
		echo json_encode($deptarray);
		}catch(Exception $e){echo 'Exceptipn occured';}
	}
	
	function changetimeoffsts(){	
		header('Access-Control-Allow-Origin: *');
		try{		
		$deptarray = $this->Att_services_model->UpdateTimeoffSts();
		echo json_encode($deptarray);			
		}catch(Exception $e){echo $e->getMessage();}
    }
	
	public function saveAllDesgPermission(){
		header('Access-Control-Allow-Origin: *');
		try{
		$perarray = $this->Att_services_model->updatePermission();
		echo json_encode($perarray);
		}catch(Exception $e){echo 'Exceptipn occured';}
	}
	/////////////////////////////--importing from HRM-close
	public	function getAllDesgPermission(){
		try{	
			$perarray = $this->Att_services_model->getAllDesgPermission();
			echo json_encode($perarray);
		}catch(Exception $e){
			echo $e->getMessage();
		}		
	}
	
	public function getEmpHistoryOf30(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getEmpHistoryOf30();  
	}
	public function getEmpHistoryOf30Count(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getEmpHistoryOf30Count();  
	}
	public function getEmployeesList(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getEmployeesList();  
	}
	public function getAttendances_new(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getAttendances_new();  
	}
	public function getCDateAttendances_new(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getCDateAttendances_new();  
	}
	public function getCDateAttnDeptWise_new(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getCDateAttnDeptWise_new();  
	}
	public function getEmpdataDepartmentWise(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getEmpdataDepartmentWise();  
	}
	public function getEmpdataDepartmentWiseCount(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getEmpdataDepartmentWiseCount();  
	}
	public function getCDateAttnDesgWise_new(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getCDateAttnDesgWise_new();  
	}
	public function getCDateAttnDesgWiseForCsv_new(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getCDateAttnDesgWiseForCsv_new();  
	}
	public function getCDateAttnDesgWiseCount_new(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getCDateAttnDesgWiseCount_new();  
	}
	
	public function getChartDataToday(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getChartDataToday();  
	}
	public function getAttendances_yes(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getAttendances_yes();  
	}
	public function getChartDataYes(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getChartDataYes();  
	}
	public function getChartDataCDate(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getChartDataCDate();  
	}
	public function getChartDataLast_7(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getChartDataLast_7();  
	}
	public function getChartDataLast_30(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getChartDataLast_30();  
	}
	public function getAttnDataLast(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getAttnDataLast();  
	}
	
	///////////-------------test
	public function test(){
		
		if(strtotime('06:00')<strtotime('18:00'))
			echo 'condition 1 true';
		else
			echo 'condition 2 true';
		return;
	//	$this->Att_services_model->test(); 
	//	return false;
		$pwd=isset($_REQUEST['pwd'])?$_REQUEST['pwd']:'';
		echo encode5t('12345');
		echo '<br>';
		echo decode5t($pwd);
			return false;
			header('Access-Control-Allow-Origin: *');
			$this->Att_services_model->test();
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
	//		$res=$this->Att_services_model->mailtest();  
	//		$res=mail("vijay@ubitechsolutions.com","Testing Mail","Testing Mail body");
	//		echo "response: ".$res;
			//$this->Att_services_model->test();  
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
		$perarray = $this->Att_services_model->CreateBulkAtt();
		echo json_encode($perarray);
		}catch(Exception $e){echo 'Exceptipn occured';}
	}
	
	public function getDeptEmp(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getDeptEmp();  
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
		
		
		$this->Att_services_model->backgroundLocationService();
		
		}catch(Exception $e){
		//echo 'Exceptipn occured';
		Trace($e->getMessage());
		}
    
    }
    
    	 public	function getEmplolyeeTrackTime()
    {
    
    header('Access-Control-Allow-Origin: *');
		try{

		$this->Att_services_model->getEmplolyeeTrackTime();
		
		}catch(Exception $e){
		//echo 'Exceptipn occured';
		Trace($e->getMessage());
		}
    
    }
    
	public function getClientsDDList(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getClientsDDList();
	}
	
	public function saveFlexi(){
		header('Access-Control-Allow-Origin: *');
		$orgid   = isset($_REQUEST['refid']) ? $_REQUEST['refid'] : 0;
		$this->Att_services_model->saveFlexi();  
	}
	public function saveFlexiOut(){
		header('Access-Control-Allow-Origin: *');
		$orgid   = isset($_REQUEST['refid']) ? $_REQUEST['refid'] : 0;
		$this->Att_services_model->saveFlexiOut();  
	}
	public function getFlexiInfo(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getFlexiInfo();  
	}public function getAttendanceesFlexi(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getAttendanceesFlexi();  
	}
	public function getFlexiInfoReport(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getFlexiInfoReport();  
	}
	public function getOutsidegeoReport(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->getOutsidegeoReport();  
	}

/*******************************SHashank for offline mode */
public function saveOfflineData(){
	
	header('Access-Control-Allow-Origin: *');
	$this->Att_services_model->saveOfflineData();  
}
public function saveOfflineVisits(){
	
	header('Access-Control-Allow-Origin: *');
	$this->Att_services_model->saveOfflineVisits();  
}

public function getNotifications(){
	header('Access-Control-Allow-Origin: *');
	$this->Att_services_model->getNotifications();
}

public function addHoliday(){
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->addHoliday();  
	}

public function getAllHoliday(){
		header('Access-Control-Allow-Origin: *');
		$orgid   = isset($_REQUEST['orgid']) ? $_REQUEST['orgid'] : 0;
		$this->Att_services_model->getAllHoliday($orgid);  
	}
	public function saveOfflineQRData(){
		header('Access-Control-Allow-Origin: *');
		
		$this->Att_services_model->saveOfflineQRData();  
	}

	public function checkNextWorkingDayCode(){
		header('Access-Control-Allow-Origin: *');
		
		$this->Att_services_model->checkNextWorkingDayCode();  
	}
	
	public function syncAshTechData(){
		header('Access-Control-Allow-Origin: *');
		
		$this->Att_services_model->syncAshTechData();  
	}
		public function updateTimeOut()
	{
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->updateTimeOut();  
	}
	public function calculateReferralDiscount()
	{
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->calculateReferralDiscount();  
	}
	public function updateReferralDiscountStatus()
	{
		header('Access-Control-Allow-Origin: *');
		$this->Att_services_model->updateReferralDiscountStatus();  
	}
	public function isInternetConnected()
	{
		header('Access-Control-Allow-Origin: *');
		echo "1";
	}
}	
?>
