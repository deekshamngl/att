<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Rakservices extends CI_Controller{
	function __construct()
    {
		
        parent::__construct();
		$this->load->model('Rakservices_model');
    }
	
	public function getCountries(){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->getCountries();
	}
	
	public function getOrganization($id){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->getOrganization($id);
	}
	
	public function checkLogin(){
		header('Access-Control-Allow-Origin: *');
		
		//echo $userName=isset($_REQUEST['userName'])?$_REQUEST['userName']:'';
		//echo $password=encode5t(isset($_REQUEST['password'])?$_REQUEST['password']:'');
		 $result = $this->Rakservices_model->checkLogin();
		 
		
	}
	
	public function register_org(){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->register_org();
	}
	
	public function getAllDesg($orgid){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->getAllDesg($orgid);
	}
	
	public function getAllDept($orgid){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->getAllDept($orgid);
	}
	public function DesignationMaster($orgid){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->DesignationMaster($orgid);
	}
	
	public function DepartmentMaster($orgid){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->DepartmentMaster($orgid);
	}
	
	public function shiftMaster($orgid){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->shiftMaster($orgid);
	}
	public function registerEmp(){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->registerEmp();
	}
	
	public function checkOrganization(){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->checkOrganization();
	}
	
	public function getImage(){
		header('Access-Control-Allow-Origin: *');
		
		echo isset($_REQUEST["uid"])? $_REQUEST["uid"]: 0;  
	}
	public function saveImage(){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->saveImage();  
	}
	public function getInfo(){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->getInfo();  
	}
	public function getHistory(){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->getHistory();  
	}
	public function getSlider(){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->getSlider();  
	}
	public function getAttendanceMobile(){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->getAttendanceMobile();  
	}
	public function getIndivisualReportData(){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->getIndivisualReportData();  
	}
	public function getLateComings(){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->getLateComings();  
	}
	public function getEarlyLeavings(){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->getEarlyLeavings();  
	}
	public function getBreakInfo(){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->getBreakInfo();  
	}
	public function timeBreak(){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->timeBreak();  
	}
	public function changePassword(){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->changePassword();  
	}
	public function getProfile(){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->getProfile();  
	}
	public function updateProfile(){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->updateProfile();  
	}
	public function resetPasswordLink(){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->resetPasswordLink();  
	}
	public function HastaLaVistaUbi(){
		header('Access-Control-Allow-Origin: *');
		$data=array();
		$uid=isset($_REQUEST['hasta'])?decrypt($_REQUEST['hasta']):'';
		$orgid=isset($_REQUEST['vista'])?decrypt($_REQUEST['vista']):0;
		$counter=isset($_REQUEST['ctrpvt'])?decrypt($_REQUEST['ctrpvt']):'';
		$res=$this->Rakservices_model->checkLinkValidity($uid,$orgid,$counter);
		
		if($res){
			$data['uid']=$uid;
			$data['orgid']=$orgid;
			$this->load->view('home/resetPasswordLinkPage');	
		}else
			echo '<center><h2 style="margin-top:20%;color:red">Your reset password Link has been expired.</h2></center>';
	}
	public function setPassword(){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->setPassword();  
	}
	public function getUsersMobile(){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->getUsersMobile();  
	}
	public function getSuperviserSts(){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->getSuperviserSts(); 
	}
	public function addShift(){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->addShift();  
	}
	public function addDesg(){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->addDesg();  
	}
	public function addDept(){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->addDept();
	}
	public function getTimeoffList(){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->getTimeoffList();  
	}
	public function getAppVersion(){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->getAppVersion();  
	}
	public function checkPwdUpdate(){
		header('Access-Control-Allow-Origin: *');
		$this->Rakservices_model->checkPwdUpdate();  
	}
	function useridcard($org,$user)
	{
		header('Access-Control-Allow-Origin: *');
		$data=array();
		$data['org']=getOrgName($org);
		$data['emp']=getEmpName($user);
		$data['dept']=getDepartmentByEmpID($user);
		$data['desg']=getDesignationByEmpID($user);
		$data['una']=getQRLoginDetailByEmpID($user);
		$this->load->view('open/useridcard',$data);	
	}
	///////////-------------test
	public function test(){
		echo getEmpIDbyEmpNo(117);
	//	header('Access-Control-Allow-Origin: *');
	//	echo getTimeZone(96);
//		$res=0;
	//		$res=$this->Rakservices_model->mailtest();  
	//		$res=mail("vijay@ubitechsolutions.com","Testing Mail","Testing Mail body");
	//		echo "response: ".$res;
			//$this->Rakservices_model->test();  
	}
	///////////-------------test/
}	
?>