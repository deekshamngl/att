<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends CI_Controller {
	 public function __construct()
    {
	    parent::__construct();
        $this->load->model('admin_model');
		handleLogin();
    } 
	function helpNav()
	{
		//$this->view->render('home/help');
		$this->load->view('home/help');	
	}
	public function buy12()
	{                                                                                    
		$this->load->view('buy/buynow12');	
	}
	public function attendance_register()
	{                                                                                    
		$this->load->view('home/attendance_register');	
	}
	public function remain(){
		//$this->load->view('home/weeklyoff');
       $this->admin_model->remainday();			
	}
	
	public function absent()
	{
		$this->load->view('home/report');	
	}
	public function notsync()
	{
		$deprt['id']=isset($_REQUEST['id'])?$_REQUEST['id']:0;
		$this->load->view('home/notsync',$deprt);	
	}

	public function absent_archived()
	{
		$this->load->view('home/archived_absent');	
	}
	
	public function latecoming()
	{
		$this->load->view('home/latereport');	
	}
	
	public function Earlyleave()
	{
		$this->load->view('home/earlyreport');	
	}
	public function employeeSummaryReport()
	{
		$this->load->view('home/employeesummaryreport');	
	}
	
	public function getEmployeeSummaryReport()
	{
		$this->admin_model->getEmployeeSummaryReport();		
	}
	public function EmployeesWiseReport()
	{
		$this->load->view('home/EmployeesWiseReport');
	}
	
	public function DepartmentReport()
	{
		$this->load->view('home/departmentReport');
	}
	public function getDeparmentReport()
	{
		$this->admin_model->getDepartmentReport();
	}
	public function overtime()
	{
		$this->load->view('home/overtimereport');	
	}
	
	public function data3month()
	{
		$this->load->view('home/data3month');	
	}

	public function archiveattendance3months()
	{
		$this->load->view('home/archiveattendance3months');	
	}
	
	public function locationReport()
	{
		$this->load->view('home/locationreport');	
	}
	public function locationReportemp()
	{
		$this->load->view('home/locationreportemp');	
	}
	public function locationReportnamewise()
	{
		$this->load->view('home/locationreportnamewise');	
	}
	public function getdaypunchLocation()
	{
		$this->admin_model->daypunchLocation();
	}
	 public function punchedLocations()
      {
		$this->admin_model->punchedLocations();	
	  } 
	  
	   public function punchedFlexi()
      {
		$this->admin_model->punchedFlexi();	
	  } 

	   public function getregister()
      {
		$this->admin_model->getregister();	
		// var_dump($this->db->last_query());

	  } 
	public function Timeoff()
	{
		$this->load->view('home/timeoffreport');	
	}
	public function empreport()
	{
		//$data['getMonthlyEmployee'] = $this->admin_model->getMonthlyEmployee();
		$this->load->view('home/employereport');	
	}
	public function undertime()
	{
		$this->load->view('home/undertimereport ');	
	}
	
	public function index()
	{
		$this->load->view('home/dhasboard');	
	}
	public function shifts()
	{
		$this->load->view('home/shifts');	
	}
	public function getAllShift(){
		$this->admin_model->getAllShift();	
	}
	
	public function editShift(){
		$this->admin_model->editShift();	
	}
	public function deleteShift(){
		$this->admin_model->deleteShift();	
	}
	public function departments()
	{
		$this->load->view('home/departments');	
	}
	public function getAllDept(){
		$this->admin_model->getAllDept();	
	}
	public function holidays(){
		$this->load->view('home/holidays');	
		//$this->admin_model->holidays();	
	}
	public function weekfetch($sid){
		//$this->load->view('home/weeklyoff');
       $this->admin_model->fetchWeeklyOff($sid);			
	}
	public function weeklyOff(){
		
		$this->load->view('home/weeklyoff');	
	}
	public function holiday(){
		$this->load->view('home/holidays');	
	}
	public function registerDept(){
		$this->admin_model->registerDept();	
	}
	public function editDept(){
		$this->admin_model->editDept();	
	}
	public function deleteDept(){
		$this->admin_model->deleteDept();	
	}
	public function designations()
	{
		$this->load->view('home/designations');	
	}
	
	public function qrcodeoption(){
		$this->load->view('home/qrcodeoption');
	}
	public function qrcodeselector(){
		$this->admin_model->qrcodeselector();
	}

	public function getAllDesg(){
		$this->admin_model->getAllDesg();	
	}
	public function getAllrates(){
		$this->admin_model->getAllrates();	
	}

	
	public function registerDesg(){
		$this->admin_model->registerDesg();	
	}
	public function addRate(){
		$this->admin_model->addRate();	
	}
	
	public function editDesg(){
		$this->admin_model->editDesg();	
	}
	public function editRate()
	{
		$this->admin_model->editRate();	
	}
	public function deleteDesg()
	{

		$this->admin_model->deleteDesg();	
	}
	public function deleteRate()
	{
		$this->admin_model->deleteRate();	
	}
	public function attendances()
	{
		$deprt['id']=isset($_REQUEST['id'])?$_REQUEST['id']:0;
		$this->load->view('home/attendance',$deprt);	
	}
	public function attendances1()
	{
		$deprt['id']=isset($_REQUEST['id'])?$_REQUEST['id']:0;
		$this->load->view('home/attendance1',$deprt);	
	}
	public function both()
	{
		$deprt['id']=isset($_REQUEST['id'])?$_REQUEST['id']:0;
		$this->load->view('home/both',$deprt);	
	}
	public function flexi()
	{
		$this->load->view('home/flexireport');	
	}

	public function viewflezi()
	{

		 $eid=$this->uri->segment(3);
		 $date=$this->uri->segment(4);
//echo $eid;
//echo $date;
		 $arr=array();
		 $arr['detail']=$this->admin_model->viewflezi($eid,$date);
		// print_r( $arr['detail']);	
		 $arr['name']=getEmpName($eid);
		  $arr['date']=$date;
		 $this->load->view('home/viewflexireport',$arr);
	}
	
	public function department()
	{
		$deprt['id']=isset($_REQUEST['id'])?$_REQUEST['id']:0;
		$this->load->view('home/reportdepartment',$deprt);	
	}
	
	public function getAbsent()
	{
	   $this->admin_model->getAbsent();	
	} 
	public function getAbsent__new()
	{
	  $this->admin_model->getAbsent__new();	
	}
	public function getAbsent__archive()
	{
	  $this->admin_model->getAbsent__archive();	
	}
	 public function getempreport()
	{
		$this->admin_model->getempreport();	
	} 
	public function getLate()
	{
		$this->admin_model->getLate();	
	} 
	public function getLate__new()
	{
		$this->admin_model->getLate__new();
		
	}
	public function Timeoffreport()
	{
		$this->admin_model->Timeoffreport();	
	}
	public function getearlyleave()
	{
		$this->admin_model->getearlyleave();	
	}
	public function getearlyleave__new()
	{
	  $this->admin_model->getearlyleave__new();
	}
	public function overTimeR()
	{
		$this->admin_model->overtime();	
	} 
	public function overTimeR__new()
	{
		$this->admin_model->overTimeR__new();	
	}
	public function underTimeR()
	{
		//$admin_model = $this->loadModel('Admin');
		//$Shift = isset($_POST["Shift"])?$_POST["Shift"]:0;
		//$this->view->Shift=$Shift;
        //$this->view->Shift = $admin_model->getAllShift();
		$data=$this->admin_model->undertime();	
		//print_r($data);
	}
	
	public function overTimeRbyshift()
	{
		$this->admin_model->overTimeRbyshift();	
	}
	public function LateReport()
	{
		$this->admin_model->LateReport();	
	}
	public function getattRoaster()
	{
		// echo 'hiii';
	$data = $this->admin_model->getattRoaster();
	// var_dump($this->db->last_query());
	echo json_encode($data);
	}
	public function getattRoastermonthly()
	{
	$data = $this->admin_model->getattRoastermonthly();
	echo json_encode($data);
	}
	public function getattRoastermonthly_count()
	{
	  $this->admin_model->getattRoastermonthly_count();

	}
	
	public function attendanceRoaster()
	{
		$this->load->view('home/attRoaster');
	}
	
	public function monthlysummary()
	{
		$this->load->view('home/monthlysummary');
	}
	public function getAttendances()
	{
		try
		{
		$this->admin_model->getAttendances();	
		}
		catch(Exception $e)
		{
			
		}
	}
	// by sohan
	public function getAttendances__new()
	{
	  $this->admin_model->getAttendances__new();	
	}

	public function getAttendances__both()
	{
	  $this->admin_model->getAttendances__both();	
	}

	public function getnotsyncdata()
	{
	  $this->admin_model->getnotsyncdata();	
	}
	// public function getdeleted_records()
	// {
	  // $this->admin_model->getdeleted_records();	
	// }
	public function getAttendances__3month()
	{
	  $this->admin_model->getAttendances__3month();	
	}

	

	public function getAttendances__archived()
	{
	  $this->admin_model->getAttendances__archived();	
	}
	
	
	public function editAttUBI(){
		$this->admin_model->editAttUBI();	
	}
	public function Attask(){

		$shifttype=isset($_REQUEST['shifttype'])?$_REQUEST['shifttype']:0;
		$aname=isset($_REQUEST['aname'])?$_REQUEST['aname']:'';
		// var_dump($aname);
		$timein=isset($_REQUEST['tin'])?$_REQUEST['tin']:'';
	    $timeout =  isset($_REQUEST['tout'])?$_REQUEST['tout']:'';
	    $timeindate  =  isset($_REQUEST['datein'])?$_REQUEST['datein']:0;
		$timeoutdate  =  isset($_REQUEST['dateout'])?$_REQUEST['dateout']:0;
		$today = date("Y-m-d");
		$yes = date('Y-m-d',strtotime("-1 days"));date('Y-m-d');
		$yes1 = date('Y-m-d',strtotime("-2 days"));date('Y-m-d');
		$ti = $timeindate." ".$timein;
		$to = $timeoutdate." ".$timeout;
		$timestamp=date("h:i A");
		// var_dump($ti);
		// var_dump($to);
		// var_dump($timestamp);
		// var_dump($shifttype);

		$format_timestamp=date("H:i:s", strtotime($timestamp));
		$format_timestamp2=date("Y/m/d H:i:s", strtotime($timestamp));

		// var_dump($today);
		// var_dump($format_timestamp);
		// var_dump($format_timestamp2);
		if($shifttype==1 && $timeindate == $today){
		$timestamp=date("h:i A");
		// var_dump($timestamp);
		
		$format_timestamp=date("H:i:s", strtotime($timestamp));
		// var_dump($format_timestamp);

		// $format_timestamp2=date("Y/m/d H:i:s", strtotime($timestamp));
		// var_dump($format_timestamp2);
		$timein  =  date("H:i:s",strtotime(isset($_REQUEST['tin'])?$_REQUEST['tin']:''));
		$timeout  =  date("H:i:s",strtotime(isset($_REQUEST['tout'])?$_REQUEST['tout']:''));
		// var_dump($timein);
			if($timeout == '00:00:00'){
		if($timein > $format_timestamp )
					{
						echo 110;
					}
					else{
		$this->admin_model->Attask();
		}		
				}

		elseif($timeout != '00:00:00' ){

			if($timein > $timeout){

						echo 22;
					}
					elseif($timeout > $format_timestamp ){ 
						echo 111;

					}
					elseif($timein > $format_timestamp ){ 
						echo 114;

					}
					elseif($timeindate > $today ){ 
						echo 112;

					}
					elseif($timeoutdate > $today ){ 
						echo 113;

					}
					else{
						$this->admin_model->Attask();
						// var_dump($this->db->last_query());
						// die();
					}
		}
		
				
	}

	else if($shifttype==1  && $timeout='00:00:00' && ($yes==$timeindate || $yes1==$timeindate || $today==$timeindate))
			{
		$timein  =  date("H:i:s",strtotime(isset($_REQUEST['tin'])?$_REQUEST['tin']:''));
			$timeout = date("H:i:s",strtotime(isset($_REQUEST['tout'])?$_REQUEST['tout']:''));
			if($timein > $timeout )
					{
						echo 22;
					}

					elseif($timein = '00:00:00' )
					{
						$timein ='00:00:01';
						// var_dump($timein);
						$this->admin_model->Attask();
					}
					
					else{
		$this->admin_model->Attask();
		}	


					}

					elseif($shifttype==2 && $timeindate == $today){

		$timein  =  date("H:i:s",strtotime(isset($_REQUEST['tin'])?$_REQUEST['tin']:''));
		// var_dump($timein);
		// var_dump($format_timestamp2);
		$timeout  =  date("H:i:s",strtotime(isset($_REQUEST['tout'])?$_REQUEST['tout']:''));
		$timeindate  =  isset($_REQUEST['dateIn'])?$_REQUEST['dateIn']:0;
		$timeoutdate  =  isset($_REQUEST['dateOut'])?$_REQUEST['dateOut']:0;

		$ti = $timeindate." ".$timein;
		$to = $timeoutdate." ".$timeout;


			if($timeout == '00:00:00'){
		if($timein > $format_timestamp )
					{
						echo 110;
					}

					


					else{
		$this->admin_model->Attask();
		}		
	}

	elseif($timeout != '00:00:00' ){

			if($ti > $to){

						echo 22;
					}
					elseif($timeout > $format_timestamp ){ 
						echo 111;

					}
					elseif($timein > $format_timestamp ){ 
						echo 114;

					}
					elseif($timeindate > $today ){ 
						echo 112;

					}
					elseif($timeoutdate > $today ){ 
						echo 113;

					}

					else{
		$this->admin_model->Attask();
		}		




	}
}

		// $this->admin_model->Attask();
	}
	public function editAtt(){
		$shifttype=isset($_REQUEST['shifttype'])?$_REQUEST['shifttype']:0;
		$timeout=isset($_REQUEST['timeout'])?$_REQUEST['timeout']:0;
		$timein=isset($_REQUEST['timein'])?$_REQUEST['timein']:0;
		$timeindate  =  isset($_REQUEST['dateIn'])?$_REQUEST['dateIn']:0;
		$timeoutdate  =  isset($_REQUEST['dateOut'])?$_REQUEST['dateOut']:0;
		$today = date("Y-m-d");
		$yes = date('Y-m-d',strtotime("-1 days"));date('Y-m-d');
		$yes1 = date('Y-m-d',strtotime("-2 days"));date('Y-m-d');
		$ti = $timeindate." ".$timein;
		$to = $timeoutdate." ".$timeout;
		$timestamp=date("h:i A");
		$format_timestamp=date("H:i:s", strtotime($timestamp));
		$format_timestamp2=date("Y/m/d H:i:s", strtotime($timestamp));
		// var_dump($yes);
		// var_dump($yes1);
		
			 if($shifttype==1 && $timeindate == $today){
		$timestamp=date("h:i A");
		$format_timestamp=date("H:i:s", strtotime($timestamp));
		// var_dump($format_timestamp);

		// $format_timestamp2=date("Y/m/d H:i:s", strtotime($timestamp));
		// var_dump($format_timestamp2);
		$timein  =  date("H:i:s",strtotime(isset($_REQUEST['ti'])?$_REQUEST['ti']:''));
		$timeout  =  date("H:i:s",strtotime(isset($_REQUEST['to'])?$_REQUEST['to']:''));
			if($timeout == '00:00:00'){
		if($timein > $format_timestamp )
					{
						echo 110;
					}
					else{
		$this->admin_model->editAtt();
		}		
				}

		elseif($timeout != '00:00:00' ){

			if($timein > $timeout){

						echo 22;
					}
					elseif($timeout > $format_timestamp ){ 
						echo 111;

					}
					elseif($timein > $format_timestamp ){ 
						echo 114;

					}
					elseif($timeindate > $today ){ 
						echo 112;

					}
					elseif($timeoutdate > $today ){ 
						echo 113;

					}
					else{
						$this->admin_model->editAtt();
					}
		}
		
					
	}
			else if($shifttype==1  && $timeout='00:00:00' && ($yes==$timeindate || $yes1==$timeindate || $today==$timeindate))
			{
		$timein  =  date("H:i:s",strtotime(isset($_REQUEST['ti'])?$_REQUEST['ti']:''));
			$timeout = date("H:i:s",strtotime(isset($_REQUEST['to'])?$_REQUEST['to']:''));
			if($timein > $timeout )
					{
						echo 22;
					}

					elseif($timein = '00:00:00' )
					{
						$timein ='00:00:01';
						// var_dump($timein);
						$this->admin_model->editAtt();
					}
					
					else{
		$this->admin_model->editAtt();
		}	


					}

// ===================shift type 2================

					elseif($shifttype==2 && $timeindate == $today){

		$timein  =  date("H:i:s",strtotime(isset($_REQUEST['ti'])?$_REQUEST['ti']:''));
		// var_dump($timein);
		// var_dump($format_timestamp2);
		$timeout  =  date("H:i:s",strtotime(isset($_REQUEST['to'])?$_REQUEST['to']:''));
		$timeindate  =  isset($_REQUEST['dateIn'])?$_REQUEST['dateIn']:0;
		$timeoutdate  =  isset($_REQUEST['dateOut'])?$_REQUEST['dateOut']:0;

		$ti = $timeindate." ".$timein;
		$to = $timeoutdate." ".$timeout;


			if($timeout == '00:00:00'){
		if($timein > $format_timestamp )
					{
						echo 110;
					}

					


					else{
		$this->admin_model->editAtt();
		}		
	}

	elseif($timeout != '00:00:00' ){

			if($ti > $to){

						echo 22;
					}
					elseif($timeout > $format_timestamp ){ 
						echo 111;

					}
					elseif($timein > $format_timestamp ){ 
						echo 114;

					}
					elseif($timeindate > $today ){ 
						echo 112;

					}
					elseif($timeoutdate > $today ){ 
						echo 113;

					}

					else{
		$this->admin_model->editAtt();
		}		




	}

}

else if($shifttype==2  && $timeout='00:00:00' && ($yes==$timeindate || $yes1==$timeindate || $today==$timeindate))
			{
		$timein  =  date("H:i:s",strtotime(isset($_REQUEST['ti'])?$_REQUEST['ti']:''));
		// var_dump($timein);
		// var_dump($format_timestamp2);
		$timeout  =  date("H:i:s",strtotime(isset($_REQUEST['to'])?$_REQUEST['to']:''));
		$timeindate  =  isset($_REQUEST['dateIn'])?$_REQUEST['dateIn']:0;
		$timeoutdate  =  isset($_REQUEST['dateOut'])?$_REQUEST['dateOut']:0;
		$ti = $timeindate." ".$timein;
		$to = $timeoutdate." ".$timeout;

			if($ti > $to )
					{
						echo 22;
					}



}
					
	else{
		$this->admin_model->editAtt();
		}	

	}
	public function editimg(){
		$this->admin_model->editimg();	
	}
	public function deleteAtt(){
	 $result = $this->admin_model->deleteAtt();	
	// echo $result;
	}
	public function getTimeOffEmpList(){
		header('Access-Control-Allow-Origin: *'); 
		$this->admin_model->getTimeOffEmpList();			
	}
	public function getTimeOffEmpCount(){ 
		header('Access-Control-Allow-Origin: *'); 
		$this->admin_model->getTimeOffEmpCount();			
	}
	public function getPresentEmpList(){
		header('Access-Control-Allow-Origin: *'); 
		$this->admin_model->getPresentEmpList();			
	}
	public function getPresentEmpCount(){
		header('Access-Control-Allow-Origin: *'); 
		$this->admin_model->getPresentEmpCount();			
	}
	public function editWeeklyOff(){
		header('Access-Control-Allow-Origin: *'); 
		$this->admin_model->editWeeklyOff();			
	}
	public function addWeeklyOff(){
		header('Access-Control-Allow-Origin: *'); 
		$this->admin_model->addWeeklyOff();			
	}
	public function getAllHolidays(){
		$this->admin_model->getAllHolidays();	
	}
	public function getAllActivity(){
		$this->admin_model->getAllActivity();	
	}
	
	public function getAllAttendanceLog()
	{
		$this->admin_model->getAllAttendanceLog();	
	}
	public function addHoliday()
	{
		$this->admin_model->addHoliday();	
	}
	public function editHoliday(){
		$this->admin_model->editHoliday();	
	}
	public function deleteHoliday()
	{
		$this->admin_model->deleteHoliday();	
	}
	public function getMonthlyEmployee()
	{
		$this->admin_model->getMonthlyEmployee();	
	}
	public function getAbsentEmployee(){
	  //$data['absent'] = $this->login_model->getAbsentEmployee();
	   $this->admin_model->getAbsentEmployee();
	 //$this->load->view('home/presentEmployee');
	}
	public function sendInvitation()
	{
	   // $this->admin_model->sendInvitation();
	    $this->admin_model->sendInvitation_new();
	}
	public function trackLocations($eid,$date,$timein,$timeout,$logdhours)
	{
		// var_dump($timein);
		
		$detail=$this->admin_model->trackLocations($eid,$date);	
		// print_r($detail);
		$arr=array('name'=>getEmpName($eid),'date'=>$date,'ti'=>$timein,'to'=>$timeout,'wh'=>$logdhours,'detail'=>$detail);
		

		// $arr['wh']=$logdhours;
		$this->load->view('home/tracklocations',$arr);	
	}
	public function hourlyPay()
	{
		$this->load->view("home/hourlypay1");
	}
	public function viewpay($vid,$startdate,$enddate)
	{
		$adata = $this->admin_model->viewData($vid,$startdate,$enddate);
		//*echo json_encode($adata['total_workedhour']);
		$data = array('vid'=>$vid,'startdate'=>$startdate,'enddate'=>$enddate,'adata'=>$adata);
	    $this->load->view("home/viewpay",$data);
	}
	
	
	public function getMonthlyPay()
	{
		 $this->admin_model->getMonthlyPay();
		//echo json_encode($data);
	}
	public function getHourlyPay()
	{
		 $this->admin_model->getHourlyPay();
		//echo json_encode($data);
	}	
	public function generatepdf()
	{
		               $this->load->library('pdf'); 
					   $pdf=new Pdf();
					   $pdf->loadHtml('
						<table border=1 align=center width=400>
						<tr><td>Name : </td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td><td>sohan</td></tr>
						<tr><td>Email : </td><td>'.'sohan'.'</td></tr>
						<tr><td>Age : </td><td>'.'sohan'.'</td></tr>
						<tr><td>Country : </td><td>'.'sohan'.'</td></tr>
						</table>
						');
						$pdf->setPaper('A4', 'landscape');
						$pdf->render();
						$pdf->stream("attandancereport.pdf");
						exit(0);
	 }
    public function Userpermission()
	{
		$this->load->view('home/userpermission');
	}
	public function updateuserpermission()
	{
	   echo $this->admin_model->updateuserpermission();
	   //echo $_REQUEST['checked'];
	 
	}
	public function addShift()
	{
		$this->load->view("home/addshift");
	}
	public function viewshift($sid)
	{
		$sdata = $this->admin_model->getshiftdata($sid);
		$data = array('sid'=>$sid,'sdata'=>$sdata );
		$this->load->view("home/viewshift",$data);
	}
	public function updateshiftchild()
	{
		$this->admin_model->updateshiftchild();
	}
	public function markattendance()
	{
		$this->load->view('home/markattendance');
	}
	public function getaattendance()
	{
		$data =  $this->admin_model->getaattendance();
		echo json_encode($data);
	}
	public function createattendance()
	{
		$this->admin_model->createattendance();
	}
	public function importdesination()
	{
		$this->load->view('home/importdesignation');
	}
	public function importdepartment()
	{
		$this->load->view('home/importdepartment');
	}
	public function importUploadsDeg()
	{
		$orgid =$_SESSION['orgid'];
        $inputFileName=isset($_FILES["proposalfile"]["tmp_name"])?$_FILES["proposalfile"]["tmp_name"]:"";
		//$ext = end((explode(".", $inputFileName))); 
		$storage_name="newdesignation.csv";
		
		if (file_exists("uploads/employee/$orgid/$storage_name"))
			{ 
			unlink("uploads/employee/$orgid/$storage_name"); 
			}
		if (!file_exists("uploads/employee/$orgid/")) {
				mkdir("uploads/employee/$orgid/", 0755, true);
			}
		 $location="uploads/employee/$orgid/";
		 $config['upload_path'] = $location;
         $config['allowed_types'] = 'csv';    
		 $config['file_name'] = $storage_name; 
         $this->load->library('upload', $config);
         
        if (! $this->upload->do_upload('proposalfile'))
        {
          echo ($this->upload->display_errors());
            //$this->load->view('home/import', $error);
        }
        else
        {
            echo json_encode($this->upload->data());
           // $this->load->view('home/import', $data);
        } 
        
    }
	public function importUploadsDep()
	 {
		$orgid =$_SESSION['orgid'];
        $inputFileName=isset($_FILES["proposalfile"]["tmp_name"])?$_FILES["proposalfile"]["tmp_name"]:"";
		//$ext = end((explode(".", $inputFileName))); 
		$storage_name="newdepartment.csv";
		
		if (file_exists("uploads/employee/$orgid/$storage_name"))
			{ 
			unlink("uploads/employee/$orgid/$storage_name"); 
			}
		if (!file_exists("uploads/employee/$orgid/")) {
				mkdir("uploads/employee/$orgid/", 0755, true);
			}
		 $location="uploads/employee/$orgid/";
		 $config['upload_path'] = $location;
         $config['allowed_types'] = 'csv';    
		 $config['file_name'] = $storage_name; 
         $this->load->library('upload', $config);
         
        if (! $this->upload->do_upload('proposalfile'))
        {
          echo ($this->upload->display_errors());
            //$this->load->view('home/import', $error);
        }
        else
        {
            echo json_encode($this->upload->data());
           // $this->load->view('home/import', $data);
        }  
    }
	public function emportDeg()
	{
		$result=$this->admin_model->emportDeg();
		
		echo json_encode($result);
	}
	public function emportDep()
	{
		$result=$this->admin_model->emportDep();
		echo json_encode($result);
	}
	public function showTMPDes($id)
	{
		$data = array('id'=>$id);
		$this->load->view('home/showTMPDes',$data);
	}
	public function getEmpotTmpDes()
	{
		$data=$this->admin_model->getEmpotTmpDes();
	}
   	function getemployeebyshift()
	{
		$employeearray = $this->admin_model->getemployeebyshift();
		echo json_encode($employeearray);
	}
	
	
	function SaveEmpShiftList()
	{		
		$employeearray = $this->admin_model->SaveEmpShiftList();
		echo json_encode($employeearray);
	}
	function tabuler()
	{
		$this->load->view('home/tabuler');
	}
	public function activitylog()
	{
		$this->load->view('home/actvitylog');
	}
	public function attendancelog()
	{
		$this->load->view('home/attendancelog');
	}
	public function getattRoastermonthly__new()
	{
		echo json_encode($this->admin_model->getattRoastermonthly__new());
		
	}
	public function getattRoastermonthly__new1()
	{
		echo json_encode($this->admin_model->getattRoastermonthly__new1());
		
	}
	public function allempcsv()
	{
		header('Content-Type: text/csv');
       header('Content-Disposition: attachment; filename="sample.csv"');
		
		 $user_CSV =  $this->admin_model->getattRoastermonthly__newcsv();
		/* print_r( $user_CSV1)."<br>";
		 
        $user_CSV[0] =  array('first_name', 'last_name', 'age');
		 $user_CSV[1] = array('Quentin', 'Del Viento', 34);
		$user_CSV[2] = array('Antoine', 'Del Torro', 55);
		$user_CSV[3] = array('Arthur', 'Vincente', 15);
        print_r($user_CSV);*/
	   
        $fp = fopen('php://output', 'wb');
          foreach ($user_CSV as $line){
          fputcsv($fp, $line, ',');
        }
      fclose($fp);
	}
	public function test()
	{
		$areada = getAreaInfo(97);
		
			echo $areada;
			$areada = json_decode(getAreaInfo(970),true);
			echo $areada['lat'];
		   echo  $data['assign_long'] = $areada['long'];
		   echo  $data['assign_radius'] = $areada['radius'];
			
	}
	/*public function registerShift(){
		$this->admin_model->registerShift();	
	}*/
	public function registerShift()
	{
		    
			$shifttype=isset($_REQUEST['shifttype'])?$_REQUEST['shifttype']:0;
			
			if($shifttype==1)
			{
			$timein  =  date("H:i:s",strtotime(isset($_REQUEST['ti'])?$_REQUEST['ti']:''));
			$timeout = date("H:i:s",strtotime(isset($_REQUEST['to'])?$_REQUEST['to']:''));
			$timein_break =date("H:i:s",strtotime(isset($_REQUEST['tib'])?$_REQUEST['tib']:''));
			$timeout_break=date("H:i:s",strtotime(isset($_REQUEST['tob'])?$_REQUEST['tob']:''));
			$timegrace=date("H:i:s",strtotime(isset($_REQUEST['tig'])?$_REQUEST['tig']:''));
			$timegraceout=date("H:i:s",strtotime(isset($_REQUEST['gto'])?$_REQUEST['gto']:''));
			// var_dump($timeout);
			// var_dump($timegrace);
			
			$query = $this->db->query("Select Time_TO_SEC(TIMEDIFF('$timeout' , '$timein') ) as shifthour ");
				if($row = $query->row())
				{
				$shifthour = $row->shifthour;
				
					if((int)$shifthour > 72000)
							echo 66;
					else	if($timein > $timeout )
					{
						echo 22;
					}
					else if($timein_break > $timeout_break)
					{
						echo 33;
					}
					else if($timein > $timegrace)
					{
						echo 50;
					}
					else if($timegrace > $timeout)
					{
						echo 52;
					}
					else if($timein > $timegraceout)
					{
						echo 51;
					}
					else if($timeout < $timegraceout)
					{
						echo 60;
					}
					else if($timein_break <= $timein)
					{
						echo 44;
					}
					else if($timeout_break >= $timeout)
					{
						echo  55;
					}
					else
					{
						$this->admin_model->registerShift();	
					}
				}
				else
				{
					echo 0;
				}
				
		 }
		else
		{
			
$timein =date("Y-m-d H:i:s",strtotime(isset($_REQUEST['ti'])?'2019-06-25'.' '.$_REQUEST['ti']:''));
// $timein  =  date("H:i:s",strtotime(isset($_REQUEST['ti'])?$_REQUEST['ti']:''));
			$timeout = date("Y-m-d H:i:s",strtotime(isset($_REQUEST['to'])?'2019-06-26'.' '.$_REQUEST['to']:''));
		    $timein_break =date("Y-m-d H:i:s",strtotime(isset($_REQUEST['tib'])?'2019-06-25'.' '.$_REQUEST['tib']:''));
	    	$timeout_break=date("Y-m-d H:i:s",strtotime(isset($_REQUEST['tob'])?'2019-06-25'.' '.$_REQUEST['tob']:''));
	    	$timegrace=date("Y-m-d H:i:s",strtotime(isset($_REQUEST['tig'])?'2019-06-25'.' '.$_REQUEST['tig']:''));
	    	$timegraceout=date("Y-m-d H:i:s",strtotime(isset($_REQUEST['gto'])?'2019-06-26'.' '.$_REQUEST['gto']:''));
	     /*var_dump($timegrace);
	     var_dump($timein);
	     die;*/
			
		   if($timein_break > $timeout_break)
		    {
			    $timein_break = date("Y-m-d H:i:s",strtotime(isset($_REQUEST['tib'])?'2019-06-25'.' '.$_REQUEST['tib']:''));
	        	$timeout_break = date("Y-m-d H:i:s",strtotime(isset($_REQUEST['tob'])?'2019-06-26'.' '.$_REQUEST['tob']:''));
		    }
			else if($timein > $timein_break || $timein > $timeout_break)
			{
				$timein_break = date("Y-m-d H:i:s",strtotime(isset($_REQUEST['tib'])?'2019-06-26'.' '.$_REQUEST['tib']:''));
	        	$timeout_break = date("Y-m-d H:i:s",strtotime(isset($_REQUEST['tob'])?'2019-06-26'.' '.$_REQUEST['tob']:''));
			}
			
			$query = $this->db->query("Select Time_TO_SEC(TIMEDIFF('$timeout' , '$timein') ) as shifthour ");
			
				if($row = $query->row())
				{	
				$shifthour = $row->shifthour;
				
				if((int)$shifthour > 72000)
				{
					echo 66;
				}
				
		      else if($timein > $timeout )
				{
					echo 22;
				}
				else if($timein_break > $timeout_break)
				{
					echo 33;
				}
				else if($timein > $timegrace)
					{
						echo 50;
					}
				else if($timeout > $timegraceout)
				{
						echo 60;
				}
				else if($timein_break <= $timein)
				{
					echo 44;
				}
				else if($timeout_break >= $timeout)
				{
					echo 55;
				} 
				else if(ti > gto){
					echo 51;
				}
				
				else
				{
					$this->admin_model->registerShift();	
				}
			}
			else
			{
				echo 0;
			}
			
		}
		
	}
	
}
