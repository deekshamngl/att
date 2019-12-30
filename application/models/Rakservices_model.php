<?php
class Rakservices_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
		include(APPPATH."PhpMailer/class.phpmailer.php");
    }
		public function getCountries(){
			$query = $this->db->query("SELECT `Id`, `Name`,countryCode FROM `CountryMaster` order by Name");
			echo json_encode($query->result());
		}
		public function getOrganization($id){
			$query = $this->db->query("SELECT o.id as orgid, o.Name as name , z.name as zone FROM Organization as  o, ZoneMaster as z WHERE o.country=z.CountryId and o.id=?",array($id));
			$data=array();
			if($query->num_rows()){
				foreach($query->result() as $row)
				{
					$data['response']=1;
					$data['orgid']=$row->orgid;
					$data['name']=$row->name;
					$data['zone']=$row->zone;
				}
			}
			else{
				$data['response']=0;
			}
				echo json_encode($data);
		}
		public function checkLogin(){
			
			$data=array();
			$active=1;
			$userName='';
			$password='';
			$device=isset($_REQUEST['device'])?$_REQUEST['device']:'';
			$orgid=502;
			$qr=isset($_REQUEST['qr'])?$_REQUEST['qr']:'';
			if($qr=='true')
			{
				 $userName=encode5t(isset($_REQUEST['userName'])?strtolower($_REQUEST['userName']):'');
				 $password=isset($_REQUEST['password'])?$_REQUEST['password']:'';
				
			}else{
				$userName=encode5t(isset($_REQUEST['userName'])?strtolower($_REQUEST['userName']):'');
				$password=encode5t(isset($_REQUEST['password'])?$_REQUEST['password']:'');
			}
			//echo "SELECT * FROM `UserMaster` , EmployeeMaster WHERE Username='".$userName."' and Password='".$password."' and EmployeeMaster .id=UserMaster.`EmployeeId`";
			$query = $this->db->query("SELECT * FROM `UserMaster` , EmployeeMaster WHERE (Username=? or username_mobile=?)and Password=? and UserMaster.OrganizationId=? and EmployeeMaster .id=UserMaster.`EmployeeId`",array($userName,$userName,$password,$orgid));
			if($query->num_rows()){
				foreach($query->result() as $row)
				{
					$data['response']=1;
					$data['fname']=ucfirst($row->FirstName);
					$data['lname']=ucfirst($row->LastName);
					$data['skey']=ucfirst($row->Password);
					$data['empid']=$row->EmployeeId;
					$data['status']=$row->VisibleSts;
					$data['orgid']=$row->OrganizationId;
					$data['sstatus']=$row->appSuperviserSts;
					$result1 = $this->db->query("SELECT name FROM `Organization` WHERE id=?",array($data['orgid']));
					if($row1= $result1->row())
						if(strlen($row1->name)>16)	
							$data['org_name']=substr($row1->name,0,16).'...';
						else 
							$data['org_name']=$row1->name;
				}
				$result1 = $this->db->query("SELECT * FROM `PlayStore` Where 1");
					if($row1= $result1->row()){
						if($device=='Android')
							$data['store']=$row1->googlepath;
						else if($device=='iOS')
							$data['store']=$row1->applepath;
						else
							$data['store']='https://ubiattendance.ubihrm.com';
					}
			}
			else{
				$data['response']=0;
			}
				echo json_encode($data);
		}
		
		public function register_org(){	
			$org_name =  isset($_REQUEST['org_name'])?$_REQUEST['org_name']:"";
			$contact_person_name =  isset($_REQUEST['name'])?$_REQUEST['name']:"";
			$email =  isset($_REQUEST['email'])?strtolower(trim($_REQUEST['email'])):"";
			$countrycode =  isset($_REQUEST['countrycode'])?$_REQUEST['countrycode']:"";
			$phone =  isset($_REQUEST['phone'])?$_REQUEST['phone']:"";
			$county =  isset($_REQUEST['country'])?$_REQUEST['country']:"0";
			$address =  isset($_REQUEST['Address'])?$_REQUEST['Address']:"";
		//	$password = ''.rand(100000,999999);
			$password = $phone;
			$date=date('Y-m-d H:i:s');
		//	$password = encrypt(make_rand_pass());
			$emp_id=0;
			$org_id=0;
			$data=array();
			$data['f_name']=$contact_person_name ;
			$org=explode(" ",$org_name);
		//	$username=strtolower("admin@".$org[0].".com");
			$username=strtolower($email);
			$counter=0;
			$sql = "SELECT * FROM Organization where Email = '$email'";
			$this->db->query($sql);
			
			if($this->db->affected_rows()>0)
			{
				$counter++;
				$data['sts']= "false1"; // email id duplicacy
				echo json_encode($data);
				return;
			}
			$sql = "SELECT * FROM UserMaster where Username = '".encode5t($email)."'";
			$this->db->query($sql);
			if($this->db->affected_rows()>0)
			{
				$counter++;
				$data['sts']= "false3"; // user register with this email duplicacy
				echo json_encode($data);
				return;
			}
			
			$sql = "SELECT * FROM Organization where PhoneNumber = '$phone'";
			$this->db->query($sql);
			if($this->db->affected_rows()>0)
			{
				$counter++;
				$data['sts']= "false2"; // phone no. duplicacy
				echo json_encode($data);
				return;
			}
			
			
			$sql = "SELECT * FROM UserMaster where username_mobile = '".encode5t($phone)."'";
			$this->db->query($sql);
			if($this->db->affected_rows()>0)
			{
				$counter++;
				$data['sts']= "false4"; // user register with this phone duplicacy
				echo json_encode($data);
				return;
			}
			//$sql = "SELECT * FROM UserMaster where Username = '".encode5t($email)."' or username_mobile = '".encode5t($phone)."'";
			
			
		/*	$sql = "SELECT * FROM UserMaster where Username = '".encode5t($email)."' username_mobile = '".encode5t($phone)."'"; //or 
			$this->db->query($sql);
			if($this->db->affected_rows()>0){
				$data['sts']= "false3"; // 
				echo json_encode($data);
			}*/
			if($counter>0){
				$data['sts']= "false"; // 
				echo json_encode($data);
			}else{
					$data['sts']= "true";
					$TimeZone=0;
					$query = $this->db->query("SELECT * FROM `ZoneMaster` WHERE `CountryId`=$county");
					if($row=$query->result())
					$TimeZone= $row[0]->Id;
				  $query = $this->db->query("insert into Organization(Name,Email,countrycode,PhoneNumber,Country,Address,TimeZone,CreatedDate,LastModifiedDate) values('$org_name','$email','$countrycode','".$phone."',$county,'$address',$TimeZone,'$date','$date')");
				 if($query>0){
				  /* 
						Curl for SIA RAM  (CRM)
				 */
				 
				$url = "http://ubitechsolutions.in/ubitech/UBICRM_SANDBOX/UbiAttendance_Integration.php";			
				$postdata = http_build_query(
				array(
							'inq_title' => "",
							'inq_amount' => "",
							'lname' => "",
							'inq_source' => "",
							'inq_city' => "",
							'inq_state' => "",
							'inq_zipcode' => "",
							'inq_stage' => "New",
							'inq_type' => "",
							'inq_company' => "",
							'inq_industry' => "",
							'inq_website' => "",
							'inq_desc' => "",
							'org_id' => "ubitechsolutions.com",
							'product' => "Attendance Management Software",							
							'fname' => $org_name,
							'email_id' => $email,
							'telephone_no' => $phone,
							'inq_address' => $address,
							'inq_mobile' => $phone,
							'inq_country' => $county							
						)
					);
					$opts = array('http' =>
					array(
					'method'  => 'POST',
					'header'  => 'Content-type: application/x-www-form-urlencoded',
					'content' => $postdata
					)
			);
			
				$context  = stream_context_create($opts);
				//print_r($context);
				$result1 = file_get_contents($url, false, $context);
				//$result=json_decode($result1);
				If($result1){
					Trace("Successfully Integrated");
					//echo "Successfully Integrated";
				}else{
					Trace("Problem while Integrated");
					//echo "Problem while Integrated";
					}
				
				 /* 
						END Curl for SIA  RAAM  (CRM)
				 */
				 
				$epassword=encrypt($password);
				$org_id = $this->db->insert_id(); 
				$query1 = $this->db->query("insert into admin_login(username,password,email,OrganizationId,name) values('$username','$epassword','$email',$org_id,'$contact_person_name')");
				// this code for insert days trial days start //
				$query22 = $this->db->query('SELECT * FROM ubitech_login');
				foreach ($query22->result_array() as $row22)
				{
						$days  = $row22['trial_days'];
				}
			    $start_date = date('Y-m-d');
			    $end_date = date('Y-m-d', strtotime("+".$days." days"));
			    $query33 = $this->db->query("insert into licence_ubiattendance(OrganizationId,start_date,end_date,extended,user_limit) values($org_id,'$start_date','$end_date',1,100)");
				// this code for insert days trial days end //
				
				//// This Code For Insert ShiftMaster,DepartmentMaster,DesignationMaster Table Start ////
				  $data1 = array(array('Name' => 'Human Resource','OrganizationId' => $org_id ),array('Name' => 'Finance','OrganizationId' => $org_id ),array('Name' => 'Marketing','OrganizationId' => $org_id ));
				  $this->db->insert_batch('DepartmentMaster', $data1);
				  $data1 = array(array('Name' => 'Trial shift','TimeIn'=>'09:00:00','TimeOut'=>'18:00:00','OrganizationId' => $org_id));
				  $this->db->insert_batch('ShiftMaster', $data1);
				   $data1 = array(array('Name' => 'Manager','OrganizationId' => $org_id),array('Name' => 'HR','OrganizationId' => $org_id),array('Name' => 'Clerk','OrganizationId' => $org_id),array('Name' => 'Trial Designation','OrganizationId' => $org_id));	
				  $this->db->insert_batch('DesignationMaster', $data1);
				////  This Code For Insert ShiftMaster,DepartmentMaster,DesignationMaster Table End ////
				///////////////////////////-----creating default user-start
						$qry = $this->db->query("select ShiftMaster.Id as shift,DesignationMaster.Id as desg,DepartmentMaster.Id as dept from DepartmentMaster,ShiftMaster,DesignationMaster where DepartmentMaster.OrganizationId=".$org_id." and ShiftMaster.OrganizationId=".$org_id." and DesignationMaster.OrganizationId=".$org_id." limit 1"); 
						$shift='';
						$desg='';
						$dept='';
						if ($r=$qry->result())
						{
							$shift  = $r[0]->shift;
							$desg  = $r[0]->desg;
							$dept  = $r[0]->dept;
							$qry = $this->db->query("insert into EmployeeMaster(FirstName,LastName,countrycode,PersonalNo,Shift,OrganizationId,Department,Designation,CompanyEmail) values('$contact_person_name',' ','$countrycode','".encode5t($phone)."',$shift,$org_id,$dept,$desg,'$email')"); 
							 if($qry>0){ 
								 $emp_id = $this->db->insert_id();
								 $qry1 = $this->db->query("INSERT INTO `UserMaster`(`EmployeeId`,appSuperviserSts, `Password`, `Username`,`OrganizationId`,CreatedDate,LastModifiedDate,username_mobile) VALUES ($emp_id,1,'".encode5t('123456')."','".encode5t($email)."',$org_id,'$start_date','$start_date','".encode5t($phone)."')");
								 if($qry1>0)
									 $data['id']=$emp_id;
								 $today=date('Y-m-d');
								 for($i=1;$i<8;$i++) // create default weekly off
									$query = $this->db->query("INSERT INTO `WeekOffMaster`(`Day`,`WeekOff`, `OrganizationId`, `ModifiedBy`, `ModifiedDate`) VALUES (?,'0,0,0,0,0',?,?,?)",array($i,$org_id,$emp_id,$today));
								 $data['org_id']=$org_id;
							}
						}
				///////////////////////////-----creating default user-end 
				$countryName='';
				$query = $this->db->query("SELECT Name FROM `CountryMaster` WHERE Id=$county");
					if($row=$query->result())
					$countryName= $row[0]->Name;
				
				if($query1>0){
			/*		$message="<html>
<head>
<title>ubiAttendance</title>
</head>
<body>Hello ".$contact_person_name."<br/><br/>
Congratulations! <b>'".$org_name."'</b>, ".$countryName." is successfully registered. We have assigned you Admin rights and added you as an employee. To configure our Attendance App login with the following credentials:<br/><br/>
<b>Admin Login for Web Admin Panel </b><br/>
Login URL: https://ubiattendance.ubihrm.com<br/>
Company's Reference No. (CRN): ".encode_vt5($org_id)."<br/>
User Id: ".$username."<br/>
Password: ".$password."<br/>
<br/><br/><br/>
<p>
<b>Admin/User Login for Mobile App</b><br/>
Username:	".$email." <b>or</b> ".$phone."<br/>
Password:	123456
</p>
<br/>
<span><b>NOTE</b> : <i>To maintain the security of user & user data we have provided Admin with different login credentials for App & Web Platform</i>.</span>
<br/>
<br/>

<p>
<b>Setup</b><br/>
	1. Add actual shifts, departments and designations through the Web Admin Panel (https://ubiattendance.ubihrm.com/) or through the mobile app.<br/>
	2. Add employees.<br/>
	<br/>
<p>
Start tracking Employee Time Records with 100% accuracy. Please contact support@ubitechsolutions.com for any queries/ suggestions. Thanks !
					</body>
					</html>
					";
*/

$message="<html>
<head>
<title>ubiAttendance</title>
</head>
<body>Hello ".$contact_person_name."<br/><br/>
Greetings from ubiAttendance Team…! <br/><br/>
Congratulations! <b>'".$org_name."'</b>, ".$countryName." is successfully registered.<br/><br/>

<p>
<b>Login details for Mobile App</b><br/>
Username:	".$email." <b>or</b> ".$phone."<br/>
Password:	123456<br/><br/>
You have been assigned the <b>Admin rights</b><br/>
<b>Company's Reference No. (CRN): </b>".encode_vt5($org_id)."<br/>
</p>
Please begin by marking your<b> Trial Attendance</b>. Refer - <a href='http://www.ubitechsolutions.com/images/ubiAttendance App User Guide.pdf' target='_blank'>ubiAttendance Get Started Guide</a>!
<br/>
To access all the features of ubiAttendance,<a href='#'> upgrade to our premium plan</a><br/>
<a href='https://www.youtube.com/channel/UCLplA-GWJOKZTwGlAaVKezg' target='_blank'>Click here</a> <b>for our online resources.</b> Contact support@ubitechsolutions.com for any queries.<br/><br/>
Cheers,<br/>
Team ubiAttendance
					</body>
					</html>
					";
					// Always set content-type when sending HTML email
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// More headers
					$headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
					//$headers .= 'Cc: vijay@ubitechsolutions.com' . "\r\n";
					$subject="UbiAttendance Admin Login";
					mail($email,$subject,$message,$headers);
					mail('anita@ubitechsolutions.com',$subject,$message,$headers);
					mail('vijay@ubitechsolutions.com',$subject,$message,$headers);
					mail('nagendra@ubitechsolutions.com',$subject,$message,$headers);
					mail('reach@ubitechsolutions.com',$subject,$message,$headers);
					mail('parth@ubitechsolutions.com',$subject,$message,$headers);
					mail('ubiattendance@ubitechsolutions.com',$subject,$message,$headers);
////////////-----------trigger second mail-strt
					
$message="<html>
<head>
<title>ubiAttendance</title>
</head>
<body>Hello ".$contact_person_name."<br/><br/>
Greetings from ubiAttendance Team! <br/><br/>
Start exploring ubiAttendance. Mark your <b>Trial Attendance</b>. Please follow these steps:<br/><br/>

<p>
<ol>
<li>
	<b>Login to your ubiAttendance </b>account with following credentials:<br/>
	<ol>
			<li>Username:	".$email." <b>or</b> ".$phone."<br/></li>
			<li>Password:	123456<br/><br/></li>
			<li>Company's Reference No. (CRN):".encode_vt5($org_id)."<br/></li>
	</ol>
</li>
<li>	Click on <b>Mark Attendance button</b><br/></li>
<li>	Click on <b>Time In / Time Out button</b><br/></li>
<li>	<b>Click on Camera</b> button<br/></li>
<li>	<b>Capture your image</b><br/><br/></li>
</ol>
</p>
Now you can check your Attendance by following these steps:<br/>
<ol>
	<li>	Click on <b>My Attendance</b> button on dashboard<br/>	</li>
	<li>	<b>Your Attendance log</b> will show  - Captured photo, location and <b>TimeIn</b><br/>	</li>
	<li>	You may similarly mark <b>Trial Time out</b> also<br/>	</li>
	<li>	<b>Your Attendance log</b> will show  - Captured photo, location and <b>Time Out</b><br/>	</li>
</ol>
The next mail will help <b>configure ubiAttendance App</b> for your company. <br/>
<a href='https://www.youtube.com/channel/UCLplA-GWJOKZTwGlAaVKezg'>Click here </a> <b>for our online resources</b>. Contact support@ubitechsolutions.com for any queries.<br/><br/>
Cheers,<br/>
Team ubiAttendance
					</body>
					</html>
					";
					// Always set content-type when sending HTML email
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// More headers
					$headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
					//$headers .= 'Cc: vijay@ubitechsolutions.com' . "\r\n";
					$subject="ubiAttendance – Mark your Trial Attendance";
					mail($email,$subject,$message,$headers);
					mail('anita@ubitechsolutions.com',$subject,$message,$headers);
					mail('vijay@ubitechsolutions.com',$subject,$message,$headers);
					mail('nagendra@ubitechsolutions.com',$subject,$message,$headers);
					mail('reach@ubitechsolutions.com',$subject,$message,$headers);
					mail('parth@ubitechsolutions.com',$subject,$message,$headers);
					mail('ubiattendance@ubitechsolutions.com',$subject,$message,$headers);
////////////-----------trigger second mail-ends	  
					  echo json_encode($data);
					// echo $admin_id =  $this->db->insert_id();
				}
			 }else{
				  $data['sts']=0;
				  echo json_encode($data);
			 }
			  
			}	
		}
		public function getAllDesg($orgid){
			$query = $this->db->query("SELECT `Id`, `Name` FROM `DesignationMaster`  WHERE OrganizationId=? and archive = 1 order by name",array($orgid));
			echo json_encode($query->result()); 
        }
		public function getAllDept($orgid){
			$query = $this->db->query("SELECT `Id`, `Name`,`archive` FROM `DepartmentMaster`  WHERE OrganizationId=? and archive = 1 order by name",array($orgid));
			echo json_encode($query->result()); 
        }
		public function DesignationMaster($orgid){
			$query = $this->db->query("SELECT `Id`, `Name`,archive FROM `DesignationMaster`  WHERE OrganizationId=?  order by name",array($orgid));
			echo json_encode($query->result()); 
        }
		
		public function DepartmentMaster($orgid){

			$query = $this->db->query("SELECT `Id`, `Name`, archive FROM `DepartmentMaster`  WHERE OrganizationId=? order by name",array($orgid));
			echo json_encode($query->result()); 
        }
		public function shiftMaster($orgid){
			$query = $this->db->query("SELECT * FROM `ShiftMaster`  WHERE OrganizationId=?  order by Time(Timein)",array($orgid));
			echo json_encode($query->result()); 
		}
		public function registerEmp(){
		$f_name = isset($_REQUEST['f_name'])?ucfirst($_REQUEST['f_name']):'';
		$l_name = isset($_REQUEST['l_name'])?ucfirst($_REQUEST['l_name']):'';
		$empno = isset($_REQUEST['empno'])?ucfirst($_REQUEST['empno']):'0';
		$password1 = encode5t(isset($_REQUEST['password'])?$_REQUEST['password']:'');
		$username = isset($_REQUEST['username'])?encode5t(strtolower($_REQUEST['username'])):'';
		$shift = isset($_REQUEST['shift'])?$_REQUEST['shift']:''; 
		$designation = isset($_REQUEST['designation'])?$_REQUEST['designation']:'';
		$department = isset($_REQUEST['department'])?$_REQUEST['department']:'';
		$contact = isset($_REQUEST['contact'])?encode5t($_REQUEST['contact']):'';
		$org_id = isset($_REQUEST['org_id'])?$_REQUEST['org_id']:'';
		$countrycode =  isset($_REQUEST['countrycode'])?$_REQUEST['countrycode']:"";
		$country =  isset($_REQUEST['country'])?$_REQUEST['country']:0;
		$admin =  isset($_REQUEST['admin'])?$_REQUEST['admin']:0; // 1 if emp added by admin
		$data=array();
		$zone=getTimeZone($org_id);
		date_default_timezone_set($zone);
		$date=date('Y-m-d H:i:s');
		$data['id']	=0;
		$data['sts']=0;
		$ml=0;
		$con=0;
		$en=0;
		 if($username!=''){
			$sql = "SELECT * FROM UserMaster where username = '".$username."'";
			$this->db->query($sql);
			$ml=$this->db->affected_rows();
		 }
		 if($contact!=''){
			$sql = "SELECT * FROM UserMaster where username_mobile = '".$contact."' ";
			$this->db->query($sql);
			$con=$this->db->affected_rows();
		 }
		 if($empno!='0' && $empno!=''){
			$sql = "SELECT * FROM EmployeeMaster where EmployeeCode = '".$empno."' and OrganizationId='".$org_id."'";
			$this->db->query($sql);
			$en=$this->db->affected_rows();
		 }
			if($con>0){
				$data['sts']=3; // if Contact already exist
			}else if($ml>0){
					$data['sts']=2; // if email id already exist
			}else if($en>0){
					$data['sts']=4; // if emp code already exist
			}else{
			  $query = $this->db->query("insert into EmployeeMaster(FirstName,LastName,PersonalNo,Shift,OrganizationId,Department,Designation,CompanyEmail,countrycode,CurrentCountry,EmployeeCode,CreatedDate) values('$f_name','$l_name','$contact',$shift,$org_id,$department,$designation,'$username','$countrycode',$country,'$empno','$date')"); 
			 if($query>0){
				 $emp_id = $this->db->insert_id();
				 $query1 = $this->db->query("INSERT INTO `UserMaster`(`EmployeeId`, `Password`, `Username`,`OrganizationId`,CreatedDate,LastModifiedDate,username_mobile) VALUES ($emp_id,'$password1','$username',$org_id,'$date','$date','$contact')");
				 if($query1>0){
					 $data['sts']=1;
					 $data['id']=$emp_id;
					if($admin==1){//emp added by admin
					 ///////////////////mail drafted to admin
					 	$message="<html>
						<head>
						<title>ubiAttendance</title>
						</head>
						<body>Dear Admin,<br/>
						<p>
						Congratulations!! <b>".$f_name." ".$l_name."</b> has been added to the Employees’ List of<b> ".getOrgName($org_id)."</b>.
						<br/> The details registered are:<br/><br/>
						<b>
						
						Employee: ".$f_name." ".$l_name." <br/>
						
						Username(Phone#): ".$_REQUEST['contact']."<br/>	
						Password: ".$_REQUEST['password']."<br/><br/>						
						</b>
						</p>
						<p>
							<a href='https://ubiattendance.ubihrm.com/index.php/services/useridcard/".$org_id."/".$emp_id."' target='_blank' >
							Generate".$f_name." ".$l_name."’s
							 QR code </a>						
						</p>
						
						
						<h5>Regards,</h5>
						<h5>Team ubiAttendance </h5>
					</body>
					</html>
					";
						
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// More headers
					$headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
					//$headers .= 'Cc: vijay@ubitechsolutions.com' . "\r\n";
					$subject=$f_name." ".$l_name." is registered on ubiAttendance.";
				//	mail($email,$subject,$message,$headers);
					$adminMail=getAdminEmail($org_id);
					mail($adminMail,$subject,$message,$headers);
					mail('vijay@ubitechsolutions.com',$subject,$message,$headers);
					mail('nagendra@ubitechsolutions.com',$subject,$message,$headers);
					mail('ubiattendance@ubitechsolutions.com',$subject,$message,$headers);
		 ///////////////////mail drafted to admin/
					 
					 
					 
					 
		///////////////////mail drafted to employee
					 $empmailid=$_REQUEST['username'];
					 if($empmailid!=''){ // trigger mail to employee
							 $message="<html>
							<head>
							<title>ubiAttendance</title>
							</head>
							<body>Dear ".$f_name." ".$l_name.",<br/>
							<p>
							Greetings from ubiAttendance Team!<br/><br/>
							Congratulations!! You have been registered as an Employee of ".getOrgName($org_id)."<br/>
							Kindly<a href='https://play.google.com/store/apps/details?id=org.ubitech.attendance'> Download ubiAttendance App</a> from Google Play Store. <br/><br/>
							
							Your Login Details:<br/>
							Company Name: <b>".getOrgName($org_id)."</b><br/>
							
							Username(Phone#): <b>".$empmailid." or  ".$_REQUEST['contact']."</b><br/>
							Password: ".$_REQUEST['password']."<br/><br/>							
							<br/>
							<br/>
							Any Questions? Please refer to our
							<a href='http://www.ubitechsolutions.com/images/ubiAttendance User Guide (For Employees).pdf'> Employee Guide</a> for our online resources. Contact support@ubitechsolutions.com for any queries.
							</p>
							
							
							<br/>
							
							<h5>Cheers,</h5>
							<h5>Team ubiAttendance </h5>
						</body>
						</html>
						";
							
						// Always set content-type when sending HTML email
						$headers = "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
						// More headers
						$headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
						//$headers .= 'Cc: vijay@ubitechsolutions.com' . "\r\n";
						$subject="Download the ubiAttendance App. .";
					//	mail($email,$subject,$message,$headers);
						
						mail($empmailid,$subject,$message,$headers);
						mail('vijay@ubitechsolutions.com',$subject,$message,$headers);
						mail('nagendra@ubitechsolutions.com',$subject,$message,$headers);
						mail('ubiattendance@ubitechsolutions.com',$subject,$message,$headers);
					 ///////////////////mail drafted to employee/
					} // emp added by admn/
					 
					}
					else{ // if emp get registered by himself
					 
					 ///////// mail drafted to admin
					 $message="<html>
						<head>
						<title>ubiAttendance</title>
						</head>
						<body>Dear Admin,<br/>
						<p>
						Congratulations!! <b>".$f_name." ".$l_name."</b> has been added to the Employees’ List of<b> ".getOrgName($org_id)."</b>.
						<br/><br/>
						<b>
						Employee: ".$f_name." ".$l_name." <br/>
						Username(Phone#): ".$_REQUEST['contact']."<br/>	
						Password: ".$_REQUEST['password']."<br/><br/>						
						</b>
						</p>
						<p>
							<a href='https://ubiattendance.ubihrm.com/index.php/services/useridcard/".$org_id."/".$emp_id."' target='_blank' >
							Generate".$f_name." ".$l_name."’s
							 QR code </a>						
						</p>
						<h5>Regards,</h5>
						<h5>Team ubiAttendance </h5>
					</body>
					</html>
					";
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// More headers
					$headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
					//$headers .= 'Cc: vijay@ubitechsolutions.com' . "\r\n";
					$subject=$f_name." ".$l_name." is registered on ubiAttendance.";
				//	mail($email,$subject,$message,$headers);
					$adminMail=getAdminEmail($org_id);
					mail($adminMail,$subject,$message,$headers);
					mail('vijay@ubitechsolutions.com',$subject,$message,$headers);
					mail('nagendra@ubitechsolutions.com',$subject,$message,$headers);
					mail('ubiattendance@ubitechsolutions.com',$subject,$message,$headers);
					 ///////// mail drafted to admin/
					 
					 ///////// mail drafted to employee
					$empmailid=$_REQUEST['username'];
					 if($empmailid!=''){ // trigger mail to employee
							 $message="<html>
							<head>
							<title>ubiAttendance</title>
							</head>
							<body>Dear ".$f_name." ".$l_name.",<br/>
							<p>
							Greetings from ubiAttendance Team!<br/><br/>
							Congratulations!! You have been registered as an Employee of  ".getOrgName($org_id).".<br/><br/>
							Kindly <a> Download ubiAttendance App from Google Play Store. 
							<b>
							Login details for Mobile App<br/>
							Company Name: ".getOrgName($org_id)."<br/>
							
							Username(Phone#): ".$empmailid." or  ".$_REQUEST['contact']."<br/>
							Password: ".$_REQUEST['password']."<br/><br/>
							Company's Reference No. (CRN):".(($org_id * $org_id) +99 )." 
							
							</b>
							<br/>
							<br/>
							Please begin by marking your <b>Trial Attendance</b><br/><br/>
							<a href='https://www.youtube.com/channel/UCLplA-GWJOKZTwGlAaVKezg'>Click here</a> for our online resources. Contact support@ubitechsolutions.com for any queries.
							</p>
							<br/>
							<h5>Cheers,</h5>
							<h5>Team ubiAttendance </h5>
						</body>
						</html>
						";
							
						// Always set content-type when sending HTML email
						$headers = "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
						// More headers
						$headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
						//$headers .= 'Cc: vijay@ubitechsolutions.com' . "\r\n";
						$subject="You have registered on ubiAttendance.";
					//	mail($email,$subject,$message,$headers);
						
						mail($empmailid,$subject,$message,$headers);
						mail('vijay@ubitechsolutions.com',$subject,$message,$headers);
						mail('nagendra@ubitechsolutions.com',$subject,$message,$headers);
						mail('ubiattendance@ubitechsolutions.com',$subject,$message,$headers);
						///////// mail drafted to employee/
					 }
					
						
					 }
			 }else{ 
				 $data['sts']=0;
				 $data['sts']=0;
			 }
			}
			} 
		echo json_encode($data);
		}
		
	public function checkOrganization(){	
		 $orgid=(int)isset($_REQUEST['refid'])?$_REQUEST['refid']:0;
		 $orgid=decode_vt5($orgid);
		 if(is_nan($orgid)) // org id is not a no. after decoding
		 {
				echo "false";
				return false;
		 }
		$this->db->where('Id',$orgid);
		$query=$this->db->get('Organization');
		$num_rows=$query->num_rows();
		if($num_rows > 0){
			$result = $query->result();
				echo json_encode($result);
		}else{
		    echo "false"; 	
		} 
	}
	public function saveImage(){
		$userid=isset($_REQUEST['uid'])?$_REQUEST['uid']:0;
		$addr=isset($_REQUEST['location'])?$_REQUEST['location']:'';
		$aid=isset($_REQUEST['aid'])?$_REQUEST['aid']:0;
		$act=isset($_REQUEST['act'])?$_REQUEST['act']:'TimeIn';
		$shiftId=isset($_REQUEST['shiftid'])?$_REQUEST['shiftid']:0;
		$orgid=isset($_REQUEST['refid'])?$_REQUEST['refid']:0;
		$result = array();
		////////---------------checking and marking "timeOff" stop (if exist)
		$zone=getTimeZone($orgid);
		date_default_timezone_set($zone);	
		$stamp=date("Y-m-d H:i:s");
		$date=date("Y-m-d");
		$time=date("H:i");
		$today=date('Y-m-d');
		$query1 = $this->db->query("SELECT `Id`,TimeFrom as BreakOn,TimeTo as BreakOff FROM `Timeoff` WHERE EmployeeId=? and OrganizationId=? and TimeofDate=? order by Id desc limit 1",array($userid,$orgid,$today));
		$tid=0;
		foreach ($query1->result() as $row){
				$tid=$row->Id; 
				if(($row->BreakOn != '00:00:00' || $row->BreakOn != '') and ($row->BreakOff == '00:00:00' ||  $row->BreakOff == '')){
					$query = $this->db->query("UPDATE `Timeoff` SET `TimeTo`=? WHERE id=? ",array($time,$tid));
					
				}
				//echo  $row->BreakOn.' '.$row->BreakOff ;
			}
		////////---------------checking and marking "timeOff" stop (if exist)--/end
		$count=0; $errorMsg=""; $successMsg=""; $status=0;$resCode=0;$serversts=1;
		$new_name=$userid.'_'.date('dmY_His').".jpg";
		if(move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/".$new_name))
		//if(true)
		{
		$sql='';
		
		//////----------------getting shift info
			$stype=0;
			$sql1="SELECT TIMEDIFF(`TimeIn`,`TimeOut`) AS stype FROM ShiftMaster where id=".$shiftId;
				try{
					$result1 =$this->db->query($sql1);
					if($row1= $result1->row()){
							$stype=$row1->stype;
					}
				}catch(Exception $e){
					Trace('Error_3: '.$e->getMessage());
				}
		//////----------------/gettign shift info
		
		if($aid!=0)	//////////////updating path of employee profile picture in database/////////////
		{
			if($stype<0) //// if shift is end whthin same date
				$sql="UPDATE `AttendanceMaster` SET `ExitImage`='".IMGURL.$new_name."',CheckOutLoc='$addr', TimeOut='$time', LastModifiedDate='$stamp',overtime =(SELECT subtime(subtime('$time',timein),
				(select subtime(timeout,timein) from ShiftMaster where id=$shiftId)) as overTime )
				WHERE id=$aid and `EmployeeId`=$userid  and date(AttendanceDate) = '$date' ";  //and SUBTIME(  `TimeOut` ,  `TimeIn` ) >'00:05:00'";
			else
				$sql="UPDATE `AttendanceMaster` SET `ExitImage`='".IMGURL.$new_name."',CheckOutLoc='$addr', TimeOut='$time', LastModifiedDate='$stamp' ,overtime =(SELECT subtime(subtime('$time',timein),
				(select subtime(timeout,timein) from ShiftMaster where id=$shiftId)) as overTime )
				WHERE id=$aid and `EmployeeId`=$userid  ORDER BY `AttendanceDate` DESC LIMIT 1";
				//and date(AttendanceDate) = DATE_SUB('$date', INTERVAL 1 DAY)
				
		}		//LastModifiedDate
		else if($aid==0)
{
			///-------- code for prevent duplicacy in a same day   code-001
			$sql="select * from  AttendanceMaster where EmployeeId=$userid and AttendanceDate= '$today'";
			
			try{ $result1 = $this->db->query($sql);
				if ($this->db->affected_rows()<1)               ///////code-001 (ends)
					$sql = "INSERT INTO `AttendanceMaster`(`EmployeeId`, `AttendanceDate`, `AttendanceStatus`, `TimeIn`,`ShiftId`, `OrganizationId`,
	  `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `OwnerId`, `Overtime`, `EntryImage`, `checkInLoc`,`device`)
	  VALUES ($userid,'$date',1,'$time',$shiftId,$orgid,'$date',$userid,'$stamp',$userid,$userid,'00:00:00','".IMGURL.$new_name."','$addr','mobile')";	
				else
						$sql='';
				}catch(Exception $e) {
					Trace('Error_2: '.$e->getMessage());
					$errorMsg = 'Message: ' .$e->getMessage();
					$status=0;
				}
				
			
		}
		/*	$sql = "INSERT INTO `AttendanceMaster`(`EmployeeId`, `AttendanceDate`, `AttendanceStatus`, `TimeIn`,`ShiftId`, `OrganizationId`,
  `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `OwnerId`, `Overtime`, `EntryImage`, `checkInLoc`)
  VALUES ($userid,'$date',1,'$time',$shiftId,1,'$date',$userid,'$date',$userid,$userid,'00:00:00','$new_name','$addr')";	
			*/	
		try{
			$query = $this->db->query($sql);
			if($this->db->affected_rows()>0 && $act=='TimeIn')
			{
				$resCode=0;
				$status =1; // update successfully
				$successMsg = "Image uploaded successfully.";
//////////////////----------------mail send if attndnce is marked very first time in org ever
				$sql="SELECT  `Email`  FROM `Organization` WHERE `Id`=".$orgid;
				$to='';
				$query1 = $this->db->query($sql);
				if($row=$query1->result()){
					$to=$row[0]->Email;
				}
				$sql='select * from  AttendanceMaster where OrganizationId='.$orgid.' limit 5';
				$query1 = $this->db->query($sql);
				if($this->db->affected_rows()==1){
			//		mail('vijay@ubitechsolutions.com',"UbiAttendance - Attendance marked first time",'Thanks for choosing ubiattendance mailed to:'.$to." simple mail");
					$to = "vijay@ubitechsolutions.com"; // comment it when need to send meail to real admin
					$subject = "UbiAttendance - Configure your Attendance System now";
					$message = "
					<html>
					<head>
					<title>ubiAttendance</title>
					</head>
					<body>
					<h3>Hello ".getAdminName($orgid)."</h3>
					<br/><br/>
					Greetings from ubiAttendance Team…!<br/><br/>
					You must have checked your attendance log by now. You are now ready to configure your Attendance system by following these steps:<br/><br/>
					<ol>
						<li>
							Click on Settings button on dashboard
						</li>
						<li>
							<b>To add a new Shift:</b>
							<ol>
								<li>
									a)	Click on Shifts button & then on '+' button.
								</li>
								<li>
									Fill Shift Name, Shift Start Time, Shift End Time & Click on Add button
								</li>
								<li>
									Shift will be added successfully.
								</li>
							</ol>
						</li>
						<li>
							<b>Add Departments:</b><br/>
								To add Department(s), subscribe now
						</li>
						<li>
							<b>Add Designations:</b>
							To add a Designation(s), subscribe now
								
						</li>
						
					</ol>
					<br/><br/>
					<a href='https://www.youtube.com/channel/UCLplA-GWJOKZTwGlAaVKezg'>Click here </a>for our online resources. Contact support@ubitechsolutions.com for any queries.
					<br/><br/>
					Cheers,</br/>
					Team ubiAttendance
					</body>
					</html>
					";
					// Always set content-type when sending HTML email
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// More headers
					$headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
					$headers .= 'Cc: vijay@ubitechsolutions.com' . "\r\n";
					$adminMail=getAdminEmail($orgid);
					mail($adminMail,$subject,$message,$headers);
					mail('nagendra@ubitechsolutions.com',$subject,$message,$headers);
				}
//////////////////----------------/mail send if attndnce is marked very first time in org ever
			}
			else
			{
				$status =2; // no changes found
				$errorMsg .= "Failed to upload Image/No Check In found today.";
			}
		}catch(Exception $e) {
			Trace('Error_1: '.$e->getMessage());
			$errorMsg = 'Message: ' .$e->getMessage();
			$status=0;
		}
	}else
			{	Trace('image not uploaded--');
				$status=3;   // error in uploading image
				$errorMsg = 'Message: error in uploading image';
			}
			$result['status']=$status;
			$result['successMsg']=$successMsg;
			$result['errorMsg']=$errorMsg;
			//$result['location']=$addr;
		
		echo json_encode($result);
		}		
		
/////------------------------------------------------------------------------	
	public function getInfo(){
		$uid=isset($_REQUEST['uid'])?$_REQUEST['uid']:0;
		$orgid=isset($_REQUEST['refno'])?$_REQUEST['refno']:0;
		$data=array();
			//////////////-------getting time zone
			   $sql="SELECT name
				FROM ZoneMaster
				WHERE id = ( 
				SELECT  `TimeZone` 
				FROM  `Organization` 
				WHERE id =$orgid
				LIMIT 1)";
				$zone='Asia/Kolkata';
				$result1 =$this->db->query($sql);
				if($row= $result1->row())
					$zone=$row->name;				
				date_default_timezone_set($zone); 
			//////////////-------/getting time zone
			$date=date('Y-m-d');
			$stype=0;
			 $sql = "SELECT Id,EmployeeCode,FirstName,LastName,shift FROM `EmployeeMaster` WHERE id=$uid";
			$result =$this->db->query($sql);
			foreach($result->result() as $row) {
					$data['shiftId']=$row->shift;
					$data['aid']=0;     //o means no attendance punched till now
					
					//////----------------gettig shift info
					
					$sql1="SELECT TIMEDIFF(  `TimeIn` ,  `TimeOut` ) AS stype
		FROM ShiftMaster where id=".$data['shiftId'];
						try{
							$result1 =$this->db->query($sql1);
							foreach( $result1->result() as $row1){
									$stype=$row1->stype;
							}
						}catch(Exception $e){}
					//////----------------/gettig shift info
					if($stype<0){ //// if shift is end whthin same date
					$sql1="SELECT id as aid,TimeOut FROM `AttendanceMaster` WHERE employeeid=$uid and `AttendanceDate`='$date'";
						try{
							$result1 =$this->db->query($sql1);
							if($row1= $result1->row()){
								$data['act']='TimeOut';
								$data['aid']=$row1->aid;
								if($row1->TimeOut!='00:00:00')
									$data['act']='Imposed';
							}
							else   
								$data['act']='TimeIn';	
						}catch(Exception $e){}
					}else{ 			/////// if shift is start and end in two diff dates
						$sql1="SELECT id as aid,TimeOut FROM `AttendanceMaster` WHERE employeeid=$uid and TimeIn !='00:00:00' and TimeOut='00:00:00' and `AttendanceDate`=DATE_SUB('$date', INTERVAL 1 DAY)";
						try{
								$result1 =$this->db->query($sql1);
								if($row1= $result1->row()){
									$data['act']='TimeOut';
									$data['aid']=$row1->aid;
									if($row1->TimeOut!='00:00:00')
										$data['act']='Imposed';
								}
								else {
								 $sql1="SELECT id as aid,TimeOut FROM `AttendanceMaster` WHERE employeeid=$uid and `AttendanceDate`='$date'";
									try{
										$result1 =$this->db->query($sql1);
										if($row1= $result1->row()){
											$data['act']='TimeOut';
											$data['aid']=$row1->aid;
											if($row1->TimeOut!='00:00:00')
												$data['act']='Imposed';
										}
										else   
											$data['act']='TimeIn';	
									}catch(Exception $e){}
									
								}									
						}catch(Exception $e){}
					}
				}
			
			
			$data['stype']=$stype;
			$data['data']=$date;
			echo json_encode($data); 
				
			}
	public function getHistory(){  	 
		$userid=isset($_REQUEST['uid'])?$_REQUEST['uid']:0;
		$refno=isset($_REQUEST['refno'])?$_REQUEST['refno']:0;
		$zone=getTimeZone($refno);
		date_default_timezone_set($zone);
		$dateStart=date('Y-m-d');
		$dateEnd=date('Y-m-d', strtotime('-7 days'));
		//echo "SELECT `AttendanceDate` , `TimeIn`, `TimeOut`,TIMEDIFF(TIMEDIFF(TimeOut,TimeIn),(SELECT SEC_TO_TIME(sum(time_to_sec( TIMEDIFF(BreakOff,BreakOn))) )as time from  BreakMaster where BreakMaster.EmployeeId = ".$userid." and date=AttendanceDate))as activeHours,TIMEDIFF(TimeOut,TimeIn) as thours,(SELECT SEC_TO_TIME(sum(time_to_sec( TIMEDIFF(BreakOff,BreakOn))) )as time from  BreakMaster where BreakMaster.EmployeeId = ".$userid." and date=AttendanceDate) as bhour,EntryImage,checkInLoc,ExitImage,CheckOutLoc  FROM `AttendanceMaster` WHERE AttendanceMaster.EmployeeId=".$userid." and AttendanceMaster.AttendanceStatus=1 and date(attendanceDate) between date('".$dateEnd."') AND date('".$dateStart."') order by DATE(AttendanceDate) desc  "; //`TimeofDate`, `TimeFrom`, `TimeTo` Timeoff
		$query = $this->db->query("SELECT `AttendanceDate` , `TimeIn`, `TimeOut`,TIMEDIFF(TIMEDIFF(TimeOut,TimeIn),(SELECT SEC_TO_TIME(sum(time_to_sec( TIMEDIFF(TimeTo,TimeFrom))) )as time from  Timeoff where Timeoff.EmployeeId = ? and TimeofDate=AttendanceDate))as activeHours,TIMEDIFF(TimeOut,TimeIn) as thours,(SELECT SEC_TO_TIME(sum(time_to_sec( TIMEDIFF(TimeTo,TimeFrom))) )as time from  Timeoff where Timeoff.EmployeeId = ? and TimeofDate=AttendanceDate) as bhour,EntryImage,checkInLoc,ExitImage,CheckOutLoc  FROM `AttendanceMaster` WHERE AttendanceMaster.EmployeeId=? and AttendanceMaster.AttendanceStatus=1 and date(attendanceDate) between date('".$dateEnd."') AND date('".$dateStart."') order by DATE(AttendanceDate) desc  ",array($userid,$userid,$userid));//and TimeOut!= '00:00:00' //limit 7
		$data=$query->result();
		//$query = $this->db->query("SELECT SEC_TO_TIME(sum(time_to_sec( TIMEDIFF(BreakOff,BreakOn))) )as time from  BreakMaster where EmployeeId = ? and date=?",array($userid,$row1->AttendanceDate));
	//	$data['timespent']=$query->result();
		echo json_encode($data); 
	}
	public function getSlider(){
		$query = $this->db->query("SELECT  `link`, `file`  FROM `slider_settings` WHERE  `archive`=1");
			echo json_encode($query->result()); 
	}
	public function getUsersMobile(){
		$orgid=isset($_REQUEST['refno'])?$_REQUEST['refno']:0;
		$query = $this->db->query("SELECT Concat( `FirstName`,' ',`LastName`) as name , `Department` ,`Designation`,(select VisibleSts from UserMaster where EmployeeId = EmployeeMaster.Id) as `archive` FROM `EmployeeMaster` WHERE  `OrganizationId`=".$orgid." order by FirstName");
		$data1=array();
		foreach( $query->result() as $row){
				$data=array();
				$data['name']=$row->name;
				$data['archive']=$row->archive;
				$data['Department']=getDepartment($row->Department);
				$data['Shift']=getDesignation($row->Designation);
				$data1['data'][]=$data;
		}
		
		echo json_encode($data1);
	}
	public function getAttendanceMobile(){
		// getting counting of attending/onbreak/exits and not attending emps
		$orgid=isset($_REQUEST['refno'])?$_REQUEST['refno']:0;
		$att=isset($_REQUEST['att'])?$_REQUEST['att']:0;
		$zone=getTimeZone($orgid);
		date_default_timezone_set($zone);
		$date=date('Y-m-d');
		 $time=date('H:i:s');
		$data=array();
		if($att=='today'){ //today attendance
			$query = $this->db->query("SELECT count(`Id`) as total FROM `EmployeeMaster`  WHERE `OrganizationId`=".$orgid." and archive=1 and CAST('$time' as time) > (select TimeIn from ShiftMaster where ShiftMaster.Id=shift)");
			$data['total']=$query->result();
			$query = $this->db->query("SELECT count(`EmployeeId`) as exited FROM AttendanceMaster  WHERE `AttendanceDate`  ='".$date."' and `TimeOut` !='00:00:00' and `OrganizationId`=".$orgid);
			$data['exited']=$query->result();
			$query = $this->db->query("SELECT count(`EmployeeId`) as timedin FROM AttendanceMaster  WHERE `AttendanceDate`  ='".$date."'  and `OrganizationId`=".$orgid);//and `TimeOut` ='00:00:00'
			$data['timedin']=$query->result(); 
			$query = $this->db->query("SELECT count(TimeFrom) as onbreak FROM `Timeoff` where TimeofDate=? and TimeTo ='00:00:00' and OrganizationId=?",array($date,$orgid));
			$data['onbreak']=$query->result();
			$query=$this->db->query("select count(Id) as latecomers from AttendanceMaster where `AttendanceDate`  ='".$date."' and `OrganizationId`=".$orgid." and time(TimeIn) > (select time(TimeIn) from ShiftMaster where ShiftMaster.Id=shiftId)");
			$data['latecomers']=$query->result();
			$query=$this->db->query("select count(Id) as earlyleavers from AttendanceMaster where `AttendanceDate`  ='".$date."' and `OrganizationId`=".$orgid." and TimeOut !='00:00:00' and time(TimeOut) < (select time(TimeOut) from ShiftMaster where ShiftMaster.Id=shiftId)");
			$data['earlyleavers']=$query->result();
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`, `TimeOut` ,'Present' as status,EntryImage,ExitImage FROM `AttendanceMaster` WHERE `AttendanceDate`=? and  OrganizationId=? and AttendanceStatus=1 order by `name`",array($date,$orgid));
			$data['elist']=$query->result();
			//---managing off (weekly and holiday)
			$dt=$date;
					
					//	day of month : 1 sun 2 mon --
					$dayOfWeek = 1 + date('w',strtotime($dt));
					$weekOfMonth = weekOfMonth($dt);
					$week='';
					$query = $this->db->query("SELECT `WeekOff` FROM  `WeekOffMaster` WHERE  `OrganizationId` =? AND  `Day` =  ?",array($orgid,$dayOfWeek));	
					if($row=$query->result()){
							$week =	explode(",",$row[0]->WeekOff);
					}
					if($week[$weekOfMonth-1]==1)
					{
						$data['absentees']='';
					}
					else{
						$query = $this->db->query("SELECT `DateFrom`, `DateTo` FROM `HolidayMaster` WHERE OrganizationId=? and (? between `DateFrom` and `DateTo`) ",array($orgid,$dt));
						if($query->num_rows()>0){
						//-----managing off (weekly and holiday) - close			
						$query = $this->db->query("SELECT CONCAT(FirstName,' ',LastName) as name,'-' as TimeIn,'-' as TimeOut ,'Absent' as status from EmployeeMaster where `OrganizationId` =$orgid and EmployeeMaster.archive=1 and EmployeeMaster.Id not in(select AttendanceMaster.`EmployeeId` from AttendanceMaster where `AttendanceDate`='$date' and `OrganizationId` =$orgid) and CAST('$time' as time) > (select TimeIn from ShiftMaster where ShiftMaster.Id=shift) order by `name`",array($orgid,$date,$orgid));
						$data['absentees']=$query->result();
						}else{
							$data['absentees']='';
						}
					}
		}else if($att=='yesterday'){ //yesterday attendance
			$date=date('Y-m-d',strtotime("-1 days"));
			$query = $this->db->query("SELECT count(`Id`) as total FROM `EmployeeMaster`  WHERE archive=1 and `OrganizationId`=".$orgid);
			$data['total']=$query->result();
			$query = $this->db->query("SELECT count(`Id`) as timedin FROM `AttendanceMaster`  WHERE AttendanceDate='".$date."' and AttendanceStatus=1 and `OrganizationId`=".$orgid);
			$data['timedin']=$query->result();
			$query=$this->db->query("select count(Id) as latecomers from AttendanceMaster where `AttendanceDate`  ='".$date."' and `OrganizationId`=".$orgid." and time(TimeIn) > (select time(TimeIn) from ShiftMaster where ShiftMaster.Id=shiftId)");
			$data['latecomers']=$query->result();
			$query=$this->db->query("select count(Id) as earlyleavers from AttendanceMaster where `AttendanceDate`  ='".$date."' and `OrganizationId`=".$orgid." and TimeOut !='00:00:00' and time(TimeOut) < (select time(TimeOut) from ShiftMaster where ShiftMaster.Id=shiftId)");
			$data['earlyleavers']=$query->result();
			//$query = $this->db->query("SELECT count(`EmployeeId`) as exited FROM AttendanceMaster  WHERE `AttendanceDate`  ='".$date."' and `TimeOut` !='00:00:00' and `OrganizationId`=".$orgid);
			//$data['exited']=$query->result();
		//	$query = $this->db->query("SELECT count(`EmployeeId`) as timedin FROM AttendanceMaster  WHERE `AttendanceDate`  ='".$date."' and `TimeOut` ='00:00:00' and `OrganizationId`=".$orgid);
		//	$data['timedin']=$query->result();
		//	$query = $this->db->query("SELECT count(BreakOn) as onbreak FROM `BreakMaster` where Date=? and BreakOff ='00:00:00' and OrganizationId=?",array($date,$orgid));
		//	$data['onbreak']=$query->result();
		
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`, `TimeOut` ,'Present' as status,EntryImage,ExitImage FROM `AttendanceMaster` WHERE AttendanceStatus=1 and `AttendanceDate`=? and  OrganizationId=? order by `name`",array($date,$orgid));
			$data['elist']=$query->result();
			//---managing off (weekly and holiday)
			$dt=$date;
					
					//	day of month : 1 sun 2 mon --
					$dayOfWeek = 1 + date('w',strtotime($dt));
					$weekOfMonth = weekOfMonth($dt);
					$week='';
					$query = $this->db->query("SELECT `WeekOff` FROM  `WeekOffMaster` WHERE  `OrganizationId` =? AND  `Day` =  ?",array($orgid,$dayOfWeek));	
					if($row=$query->result()){
							$week =	explode(",",$row[0]->WeekOff);
					}
					if($week[$weekOfMonth-1]==1)
					{
						$data['absentees']='';
					}
					else{
							$query = $this->db->query("SELECT `DateFrom`, `DateTo` FROM `HolidayMaster` WHERE OrganizationId=? and (? between `DateFrom` and `DateTo`) ",array($orgid,$dt));
							if($query->num_rows()>0){
						
					//-----managing off (weekly and holiday) - close			
					$query = $this->db->query("SELECT CONCAT(FirstName,' ',LastName) as name,'-' as TimeIn,'-' as TimeOut ,'Absent' as status from EmployeeMaster where `OrganizationId` =$orgid and EmployeeMaster.archive=1 and EmployeeMaster.Id in(select AttendanceMaster.`EmployeeId` from AttendanceMaster where `AttendanceDate`='$date' and AttendanceStatus<>1 and `OrganizationId` =$orgid) and CAST('$time' as time) > (select TimeIn from ShiftMaster where ShiftMaster.Id=shift) order by `name`",array($orgid,$date,$orgid));
					$data['absentees']=$query->result();
						}else{
							$data['absentees']='';
						}
					}
		}else if($att=='cdate'){ //custom date  attendance
			$cdate=isset($_REQUEST['cdate'])?date('Y-m-d',strtotime($_REQUEST['cdate'])):0;
			$cond='';
			if($cdate==$date)
				$cond="	and CAST('$time' as time) > (select TimeIn from ShiftMaster where ShiftMaster.Id=shift)";
			$query = $this->db->query("SELECT count(`Id`) as total FROM `EmployeeMaster`  WHERE `OrganizationId`=".$orgid." and archive=1 ".$cond);
			$data['total']=$query->result();
			$query = $this->db->query("SELECT count(`EmployeeId`) as marked FROM AttendanceMaster  WHERE AttendanceDate  ='".$cdate."'  and attendancestatus=1 and `OrganizationId`=".$orgid);
			$data['marked']=$query->result();
			$query=$this->db->query("select count(Id) as latecomers from AttendanceMaster where `AttendanceDate`  ='".$cdate."' and `OrganizationId`=".$orgid." and time(TimeIn) > (select time(TimeIn) from ShiftMaster where ShiftMaster.Id=shiftId)");
			$data['latecomers']=$query->result();
			$query=$this->db->query("select count(Id) as earlyleavers from AttendanceMaster where `AttendanceDate`  ='".$cdate."' and `OrganizationId`=".$orgid." and TimeOut !='00:00:00' and time(TimeOut) < (select time(TimeOut) from ShiftMaster where ShiftMaster.Id=shiftId)");
			$data['earlyleavers']=$query->result();
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`, `TimeOut`,'Present' as status ,AttendanceDate FROM `AttendanceMaster` WHERE AttendanceDate =? and AttendanceStatus=1 and  OrganizationId=? order by `AttendanceDate` desc,name",array($cdate,$orgid));
			$data['elist']=$query->result();
			//---managing off (weekly and holiday)// 
			$dt=$cdate;
					
					//	day of month : 1 sun 2 mon --
					 $dayOfWeek = 1 + date('w',strtotime($dt));
					$weekOfMonth =weekOfMonth($dt);
					$week='';
					$query = $this->db->query("SELECT `WeekOff` FROM  `WeekOffMaster` WHERE  `OrganizationId` =? AND  `Day` =  ?",array($orgid,$dayOfWeek));	
					if($row=$query->result()){
							$week =	explode(",",$row[0]->WeekOff);
					}
					if($week[$weekOfMonth-1]==1)
					{
						$data['absentees']='';
					}else{
						$query = $this->db->query("SELECT `DateFrom`, `DateTo` FROM `HolidayMaster` WHERE OrganizationId=? and (? between `DateFrom` and `DateTo`) ",array($orgid,$dt));
					if($query->num_rows()==0){
				//-----managing off (weekly and holiday) - close
						$query = $this->db->query("SELECT CONCAT(FirstName,' ',LastName) as name,'-' as TimeIn,'-' as TimeOut ,'Absent' as status,'".$cdate."' as AttendanceDate from EmployeeMaster where `OrganizationId` =? and EmployeeMaster.archive=1 and EmployeeMaster.Id in(select AttendanceMaster.`EmployeeId` from AttendanceMaster where `AttendanceDate`=? and AttendanceStatus<>1 and `OrganizationId` =?) ".$cond." order by `name`",array($orgid,$cdate,$orgid));
						//$query = $this->db->query("select * from AttendanceMaster where AttendanceStatus<>1 and AttendanceDate='2018-01-01'",array());
					$data['absentees']=$query->result();
					}else{
						$data['absentees']='';
					}
				}
		}else if($att=='absentees'){ //custom date  absentees
			$cdate=isset($_REQUEST['cdate'])?date('Y-m-d',strtotime($_REQUEST['cdate'])):0;
			////////////////
			$query = $this->db->query("SELECT CONCAT(FirstName,' ',LastName) as name,'-' as TimeIn,'-' as TimeOut ,'Absent' as status,'".$cdate."' as AttendanceDate  from EmployeeMaster where `OrganizationId` =".$orgid." and EmployeeMaster.Id not in(select AttendanceMaster.`EmployeeId` from AttendanceMaster WHERE `AttendanceDate`  ='".$cdate."' and `OrganizationId`=".$orgid." and CAST('$time' as time) > (select TimeIn from ShiftMaster where ShiftMaster.Id=shift) order by DATE(AttendanceDate),name)");
			$data['absentees'][]=$query->result();
			////////////////
			$query = $this->db->query("SELECT count(`Id`) as total FROM `EmployeeMaster`  WHERE `OrganizationId`=".$orgid);
			$data['total']=$query->result();
			$query = $this->db->query("SELECT count(`EmployeeId`) as marked FROM AttendanceMaster  WHERE AttendanceDate  ='".$cdate."' and `OrganizationId`=".$orgid);
			$data['marked']=$query->result();
			$query = $this->db->query("SELECT CONCAT(FirstName,' ',LastName) as name,'-' as TimeIn,'-' as TimeOut ,'Absent' as status,'".$cdate."' as AttendanceDate  from EmployeeMaster where `OrganizationId` =".$orgid." and EmployeeMaster.Id not in(select AttendanceMaster.`EmployeeId` from AttendanceMaster WHERE `AttendanceDate`  ='".$cdate."' and `OrganizationId`=".$orgid."  and AttendanceStatus=1 order by DATE(AttendanceDate),name)");
			$data['elist']=$query->result();
		}else if($att=='l7'){ //last 7 days attendance
			$end_week = date("Y-m-d",strtotime("-1 days"));
			$start_week = date("Y-m-d", strtotime('-6 day', strtotime($end_week)));	
			$start_week = \DateTime::createFromFormat('Y-m-d', $start_week);
			$end_week = \DateTime::createFromFormat('Y-m-d', $end_week);
			$datePeriod= new \DatePeriod( $start_week, new \DateInterval('P1D'),$end_week->modify('+1day') );
			foreach($datePeriod as $date){
			$dt= $date->format('Y-m-d');
			 $query = $this->db->query("SELECT count(`EmployeeId`) as total,AttendanceDate FROM AttendanceMaster  WHERE `AttendanceDate`  ='".$dt."' and AttendanceStatus<>1 and `OrganizationId`=".$orgid);
			$data['rec'][]=$query->result();
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`, `TimeOut` ,AttendanceDate ,'Present' as status FROM `AttendanceMaster` WHERE `AttendanceDate`  ='".$dt."' and `OrganizationId`=".$orgid." and AttendanceStatus=1 order by DATE(AttendanceDate) desc,name");
			$data['elist'][]=$query->result();
			///////////////abs
			
				//---managing off (weekly and holiday)
					$query = $this->db->query("SELECT `DateFrom`, `DateTo` FROM `HolidayMaster` WHERE OrganizationId=? and (? between `DateFrom` and `DateTo`) ",array($orgid,$dt));
					if($query->num_rows()>0)
						continue;
					//	day of month : 1 sun 2 mon --
					 $dayOfWeek = 1 + date('w',strtotime($dt));
					$weekOfMonth =weekOfMonth($dt);
					$week='';
					$query = $this->db->query("SELECT `WeekOff` FROM  `WeekOffMaster` WHERE  `OrganizationId` =? AND  `Day` =  ?",array($orgid,$dayOfWeek));	
					if($row=$query->result()){
							$week =	explode(",",$row[0]->WeekOff);
					}
					if($week[$weekOfMonth-1]==1)
						continue;
				//-----managing off (weekly and holiday) - close
			$query = $this->db->query("SELECT CONCAT(FirstName,' ',LastName) as name,'-' as TimeIn,'-' as TimeOut ,'Absent' as status,'".$dt."' as AttendanceDate  from EmployeeMaster where `OrganizationId` =".$orgid." and EmployeeMaster.archive=1 and EmployeeMaster.Id in(select AttendanceMaster.`EmployeeId` from AttendanceMaster WHERE `AttendanceDate`  ='".$dt."' and AttendanceStatus<>1 and `OrganizationId`=".$orgid.") and CAST('$time' as time) > (select TimeIn from ShiftMaster where ShiftMaster.Id=shift) order by DATE(AttendanceDate),name");
			$data['absentees'][]=$query->result();
			
			//////////abs
			
			
			}
		}else if($att=='thismonth'){ //current month attendance
			$month=date('m');
			$query = $this->db->query("SELECT count(`Id`) as total FROM `EmployeeMaster`  WHERE `OrganizationId`=".$orgid);
			$data['total']=$query->result();
			$query = $this->db->query("SELECT count(`EmployeeId`) as marked FROM AttendanceMaster  WHERE EXTRACT(MONTH from AttendanceDate)  ='".$month."' and `OrganizationId`=".$orgid);
			$data['marked']=$query->result();
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`, `TimeOut`,'Present' as status ,AttendanceDate FROM `AttendanceMaster` WHERE EXTRACT(MONTH from AttendanceDate) =?  and  OrganizationId=? and AttendanceStatus=1 order by DATE(AttendanceDate),name",array($month,$orgid));
			$data['elist']=$query->result();
			$query=$this->db->query("select count(Id) as latecomers from AttendanceMaster where EXTRACT(MONTH from AttendanceDate) ='".$month."' and `OrganizationId`=".$orgid." and time(TimeIn) > (select time(TimeIn) from ShiftMaster where ShiftMaster.Id=shiftId)");
			$data['latecomers']=$query->result();
			$query=$this->db->query("select count(Id) as earlyleavers from AttendanceMaster where EXTRACT(MONTH from AttendanceDate) ='".$month."' and `OrganizationId`=".$orgid." and TimeOut !='00:00:00' and time(TimeOut) < (select time(TimeOut) from ShiftMaster where ShiftMaster.Id=shiftId)");
			$data['earlyleavers']=$query->result();
			$start_week =date('Y-m-01');
			$end_week = date('Y-m-d');
			$start_week = \DateTime::createFromFormat('Y-m-d', $start_week);
			$end_week = \DateTime::createFromFormat('Y-m-d', $end_week);
			$datePeriod= new \DatePeriod( $start_week, new \DateInterval('P1D'),$end_week->modify('+1day') );
			foreach($datePeriod as $date){
			$dt= $date->format('Y-m-d');
			//---managing off (weekly and holiday)
					$query = $this->db->query("SELECT `DateFrom`, `DateTo` FROM `HolidayMaster` WHERE OrganizationId=? and (? between `DateFrom` and `DateTo`) ",array($orgid,$dt));
					if($query->num_rows()>0)
						continue;
					//	day of month : 1 sun 2 mon --
					$dayOfWeek = 1 + date('w',strtotime($dt));
					$weekOfMonth =weekOfMonth($dt);
					$week='';
					$query = $this->db->query("SELECT `WeekOff` FROM  `WeekOffMaster` WHERE  `OrganizationId` =? AND  `Day` =  ?",array($orgid,$dayOfWeek));	
					if($row=$query->result()){
							$week =	explode(",",$row[0]->WeekOff);
					}
					if($week[$weekOfMonth-1]==1)
						continue;
				//-----managing off (weekly and holiday) - close
			$query = $this->db->query("SELECT CONCAT(FirstName,' ',LastName) as name,'-' as TimeIn,'-' as TimeOut ,'Absent' as status,'".$dt."' as AttendanceDate  from EmployeeMaster where `OrganizationId` =".$orgid." and EmployeeMaster.archive=1 and EmployeeMaster.Id in(select AttendanceMaster.`EmployeeId` from AttendanceMaster WHERE `AttendanceDate`  ='".$dt."'  and AttendanceStatus<>1 and `OrganizationId`=".$orgid.") and CAST('$time' as time) > (select TimeIn from ShiftMaster where ShiftMaster.Id=shift) order by DATE(AttendanceDate),name asc");
			$data['absentees'][]=$query->result();
			}
		}else if($att=='lastweek'){ //lasweek attendance
			$previous_week = strtotime("-1 week +1 day");
			$start_week =strtotime("last monday midnight",$previous_week);
			$end_week = strtotime("next sunday",$start_week);
			$start_week = date("Y-m-d",$start_week);
			$end_week = date("Y-m-d",$end_week);
			$start_week = \DateTime::createFromFormat('Y-m-d', $start_week);
			$end_week = \DateTime::createFromFormat('Y-m-d', $end_week);
			$datePeriod= new \DatePeriod( $start_week, new \DateInterval('P1D'),$end_week->modify('+1day') );
			foreach($datePeriod as $date){
			$dt= $date->format('Y-m-d');
			 $query = $this->db->query("SELECT count(`EmployeeId`) as total,AttendanceDate FROM AttendanceMaster  WHERE `AttendanceDate`  ='".$dt."' and `OrganizationId`=".$orgid);
			$data['rec'][]=$query->result();
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`, `TimeOut` ,AttendanceDate,'Present' as status FROM `AttendanceMaster` WHERE `AttendanceDate`  ='".$dt."' and `OrganizationId`=".$orgid." and AttendanceStatus=1 order by DATE(AttendanceDate),name ");
			$data['elist'][]=$query->result();
			//---managing off (weekly and holiday)
					$query = $this->db->query("SELECT `DateFrom`, `DateTo` FROM `HolidayMaster` WHERE OrganizationId=? and (? between `DateFrom` and `DateTo`) ",array($orgid,$dt));
					if($query->num_rows()>0)
						continue;
					//	day of month : 1 sun 2 mon --
					 $dayOfWeek = 1 + date('w',strtotime($dt));
					$weekOfMonth =weekOfMonth($dt);
					$week='';
					$query = $this->db->query("SELECT `WeekOff` FROM  `WeekOffMaster` WHERE  `OrganizationId` =? AND  `Day` =  ?",array($orgid,$dayOfWeek));	
					if($row=$query->result()){
							$week =	explode(",",$row[0]->WeekOff);
					}
					if($week[$weekOfMonth-1]==1)
						continue;
				//-----managing off (weekly and holiday) - close
			$query = $this->db->query("SELECT CONCAT(FirstName,' ',LastName) as name,'-' as TimeIn,'-' as TimeOut ,'Absent' as status,'".$dt."' as AttendanceDate  from EmployeeMaster where `OrganizationId` =".$orgid." and EmployeeMaster.Id not in(select AttendanceMaster.`EmployeeId` from AttendanceMaster WHERE `AttendanceDate`  ='".$dt."' and `OrganizationId`=".$orgid.") order by DATE(AttendanceDate),name");
			$data['absentees'][]=$query->result();
			}
			//$data['elist']=$query->result();
		}
		echo json_encode($data, JSON_NUMERIC_CHECK);
			
	}
	public function getIndivisualReportData(){
		return true;
	}
	public function getLateComings()
	{
		$org_id=isset($_REQUEST['refno'])?$_REQUEST['refno']:0;
		$date=isset($_REQUEST['cdate'])?$_REQUEST['cdate']:0;
		$res  = array();
			$date = date('Y-m-d', strtotime($date));
			$query = $this->db->query("select Shift,Id  from EmployeeMaster where OrganizationId = $org_id and Id IN (select EmployeeId from AttendanceMaster where OrganizationId = $org_id and AttendanceDate='$date' and TimeIn != '00:00:00') order by FirstName");
			foreach ($query->result() as $row)
			{
				   $ShiftId = $row->Shift;
				   $EId = $row->Id;
				   $query = $this->db->query("select TimeIn,TimeOut from ShiftMaster where Id = $ShiftId");
				   if($data123 = $query->row()){
					   $shiftin =  $data123->TimeIn;
					   $shift=substr($data123->TimeIn,0,5).' - '. substr($data123->TimeOut,0,5);
                       $ct =  date('H:i:s');
				       $query111 = $this->db->query("select * from EmployeeMaster where OrganizationId = $org_id  and Id =$EId");
				       if($row111 = $query111->row()){
                       $query333 = $this->db->query("select * from AttendanceMaster where OrganizationId = $org_id  and EmployeeId =$EId and TimeIn > '$shiftin' and AttendanceDate='$date'");
					   if($row333 = $query333->row()){
						    $a = new DateTime($row333->TimeIn);
							$b = new DateTime($data123->TimeIn);
							$interval = $a->diff($b);
					    $data['lateby'] = $interval->format("%H:%I");
					    $data['timein'] = substr($row333->TimeIn,0,5);
				        $data['name'] = $row111->FirstName.' '.$row111->LastName;
				        $data['shift'] = $shift;
				        $data['date'] = $date;
						$res[] = $data;
					   }
				   }   
				  }	               		  
			}
			
		echo json_encode($res, JSON_NUMERIC_CHECK); 
	}
	public function getEarlyLeavings()
	{
		$org_id=isset($_REQUEST['refno'])?$_REQUEST['refno']:0;
		$date=isset($_REQUEST['cdate'])?$_REQUEST['cdate']:0;
		$zone=getTimeZone($org_id);
		date_default_timezone_set($zone);	
		$res  = array();
			$date = date('Y-m-d', strtotime($date));
			$cdate = date('Y-m-d');
			$time = date('H:i:s');
			$cond='';
			$query = $this->db->query("select Shift,Id  from EmployeeMaster where OrganizationId = $org_id and Id IN (select EmployeeId from AttendanceMaster where OrganizationId = $org_id and AttendanceDate='$date' and TimeIn != '00:00:00') order by FirstName");
			foreach ($query->result() as $row)
			{
				   $ShiftId = $row->Shift;
				   $EId = $row->Id;
				   $query = $this->db->query("select TimeIn,TimeOut from ShiftMaster where Id = $ShiftId");
				   if($data123 = $query->row()){
					   $shiftout =  $data123->TimeOut;
					   $shift=substr($data123->TimeIn,0,5).' - '. substr($data123->TimeOut,0,5);
                       $ct =  date('H:i:s');
				       $query111 = $this->db->query("select * from EmployeeMaster where OrganizationId = $org_id  and Id =$EId");
				       if($row111 = $query111->row()){
						   if($cdate==$date)
								$cond="	and TimeOut !='00:00:00'";
                       $query333 = $this->db->query("select * from AttendanceMaster where OrganizationId = $org_id  and EmployeeId =$EId and TimeOut < '$shiftout' and AttendanceDate='$date'".$cond);
					   if($row333 = $query333->row()){
						    $a = new DateTime($row333->TimeOut);
							$b = new DateTime($data123->TimeOut);
							$interval = $a->diff($b);
					    $data['earlyby'] = $interval->format("%H:%I");
					    $data['timeout'] = substr($row333->TimeOut,0,5);;
				        $data['name'] = $row111->FirstName.' '.$row111->LastName;
				        $data['shift'] = $shift;
				        $data['date'] = $date;
						$res[] = $data;
					   }
				   }   
				  }	               		  
			}
			
		echo json_encode($res, JSON_NUMERIC_CHECK); 
	}
	
	
	public function getBreakInfo(){
		$uid=isset($_REQUEST['uid'])?$_REQUEST['uid']:0;
		$orgid=isset($_REQUEST['refno'])?$_REQUEST['refno']:0;
		$zone=getTimeZone($orgid);
		date_default_timezone_set($zone);	
		$today=date('Y-m-d');
		//SELECT `Id`, `EmployeeId`, `TimeofDate`, `TimeFrom`, `TimeTo`, `Reason`, `ApproverId`, `ApprovalSts`, `ApproverComment`, `CreatedDate`, `ModifiedDate`, `OrganizationId` FROM `Timeoff` WHERE 1
		$query = $this->db->query("SELECT `Id`,TimeofDate as Date, TimeFrom as `BreakOn`, TimeTo as `BreakOff`, `OrganizationId` FROM `Timeoff` WHERE EmployeeId=? and OrganizationId=? and TimeofDate=? order by Id desc limit 1",array($uid,$orgid,$today));
		$data=array();
		$data['id']='';
		$data['stb']='';
		$data['sts']=0;
			foreach ($query->result() as $row){
				$data['id']=$row->Id;
				if(($row->BreakOn != '00:00:00' or $row->BreakOn != '')and ($row->BreakOff == '00:00:00' or $row->BreakOff == '')){
					$data['sts']=1;		// Timed in but not timed out
					$data['stb']=$row->BreakOn;
				}
			}
			echo json_encode($data);
	}
	public function timeBreak(){
		$uid=isset($_REQUEST['uid'])?$_REQUEST['uid']:0;
		$orgid=isset($_REQUEST['refno'])?$_REQUEST['refno']:0;
		$id=isset($_REQUEST['id'])?$_REQUEST['id']:0;
		$zone=getTimeZone($orgid);
		date_default_timezone_set($zone);	
		$today=date('Y-m-d');
		$time=date("H:i:s");;
		//$query = $this->db->query("SELECT `Id`,BreakOn,BreakOff FROM `BreakMaster` WHERE EmployeeId=? and OrganizationId=? and Date=? order by Id desc limit 1",array($uid,$orgid,$today));
		//SELECT `Id`, `EmployeeId`, `TimeofDate`, `TimeFrom`, `TimeTo`, `Reason`, `ApproverId`, `ApprovalSts`, `ApproverComment`, `CreatedDate`, `ModifiedDate`, `OrganizationId` FROM `Timeoff` WHERE 1
	//	echo "SELECT `Id`,TimeFrom as BreakOn,TimeTo as BreakOff FROM `Timeoff` WHERE EmployeeId=$uid and OrganizationId=$orgid and TimeofDate=$today order by Id desc limit 1";
		
		$query = $this->db->query("SELECT `Id`,TimeFrom as BreakOn,TimeTo as BreakOff FROM `Timeoff` WHERE EmployeeId=? and OrganizationId=? and TimeofDate=? order by Id desc limit 1",array($uid,$orgid,$today));
		$data=array();
		$sts=0;
		$res=0;
			if ($query->num_rows()>0){
				$row = $query->result();
				$data['id']=$row[0]->Id;
				//echo $row[0]->BreakOn."--".$row[0]->BreakOff.'--';
				if(($row[0]->BreakOn != '00:00:00' or $row[0]->BreakOn != '') and ($row[0]->BreakOff == '00:00:00' or $row[0]->BreakOff == '')){
					$sts=1;		// Timed in but not timed out
				}
			}
			
			if($sts==0){ // time to marke start time off
			
			//	$query = $this->db->query("INSERT INTO `BreakMaster`(`EmployeeId`, `Date`, `BreakOn`, `OrganizationId`) VALUES (?,?,?,?)",array($uid,$today,$time,$orgid));
				$query = $this->db->query("INSERT INTO `Timeoff`(`EmployeeId`, `TimeofDate`, `TimeFrom`, `OrganizationId`,ApprovalSts) VALUES (?,?,?,?,?)",array($uid,$today,$time,$orgid,2));
				if($this->db->affected_rows()>0)
					$res=1;
			}else{   // time to mark stop time off
			//	$query = $this->db->query("UPDATE `BreakMaster` SET `BreakOff`=? WHERE id=? ",array($time,$id));
				$query = $this->db->query("UPDATE `Timeoff` SET `TimeTo`=? WHERE id=? ",array($time,$id));
				if($this->db->affected_rows()>0)
					$res=2;
			}
			echo json_encode($res);
	}	
public function changePassword(){
		$uid=isset($_REQUEST['uid'])?$_REQUEST['uid']:0;
		$orgid=isset($_REQUEST['refno'])?$_REQUEST['refno']:0;
		$pwd=encode5t(isset($_REQUEST['pwd'])?$_REQUEST['pwd']:'');
		$npwd=encode5t(isset($_REQUEST['npwd'])?$_REQUEST['npwd']:'');
		$data=array();
		$data['res']=0;
		$zone=getTimeZone($orgid);
		date_default_timezone_set($zone);	
		$today=date('Y-m-d');
		$query = $this->db->query("select * from UserMaster where EmployeeId=? and Password=? and OrganizationId=?",array($uid,$pwd,$orgid));
		if($this->db->affected_rows()<1)
		{
			$data['res']=2;    // password not matched
			echo json_encode($data);
			return false;
		}else{    // old password matched
			if($pwd==$npwd){
				$data['res']=3;    // new password and old password are same
			echo json_encode($data);
			return false;
			}
		}
		
		$query = $this->db->query("UPDATE `UserMaster` SET `Password`=?  WHERE EmployeeId=? and OrganizationId=?",array($npwd,$uid,$orgid));
		if($this->db->affected_rows()>0)
		{
			$data['res']=1;    // password updated
			echo json_encode($data);
			return false;
		}
		echo json_encode($data);		
	}	
	public function getProfile(){
		$uid=isset($_REQUEST['uid'])?$_REQUEST['uid']:0;
		$query = $this->db->query("SELECT `Id`,`FirstName`,`LastName`,`MaritalStatus`,`HomeAddress`,`PersonalNo`,Department,Designation  ,Shift,CurrentCountry FROM `EmployeeMaster` WHERE `Id`=?",array($uid));
		$data=array();
		$data['info']=$query->result();
		$query = $this->db->query("SELECT `DisplayName`, `ActualValue` FROM `OtherMaster` WHERE `OtherType`='MaritalStatus'");
		$data['marital']=$query->result();
		$msts=$data['info'][0]->MaritalStatus;
		$data['dept']=getDepartment($data['info'][0]->Department);
		$data['desg']=getDesignation($data['info'][0]->Designation);
		$data['shift']=getShift($data['info'][0]->Shift);
		$data['PersonalNo']=decode5t($data['info'][0]->PersonalNo);
		$data['HomeAddress']=decode5t($data['info'][0]->HomeAddress);
		$data['CurrentCountry']=$data['info'][0]->CurrentCountry;
		$query = $this->db->query("SELECT `Id`, `Name`,countryCode FROM `CountryMaster` order by Name");	
		$data['country']=$query->result();
		echo json_encode($data);
	}
	public function updateProfile(){
		$uid=isset($_REQUEST['uid'])?$_REQUEST['uid']:0;
		$orgid=isset($_REQUEST['refno'])?$_REQUEST['refno']:0;
		$no=isset($_REQUEST['no'])?encode5t($_REQUEST['no']):0;
		$mar=isset($_REQUEST['mar'])?$_REQUEST['mar']:0; // marrital status -- eliminated
		$con=isset($_REQUEST['con'])?$_REQUEST['con']:0;
		$ccon=isset($_REQUEST['ccon'])?$_REQUEST['ccon']:'0';
		$add=isset($_REQUEST['add'])?encode5t($_REQUEST['add']):0;
		$res=0;
		
		$query = $this->db->query("update EmployeeMaster set `MaritalStatus` =?
		,`HomeAddress` =? ,`PersonalNo`= ?, CurrentCountry=?,countrycode=? WHERE `Id`=? and OrganizationId=? ",array($mar,$add,$no,$con,$ccon,$uid,$orgid));
		$res=$this->db->affected_rows();
		if($res)
			$query = $this->db->query("update UserMaster set username_mobile=? WHERE `EmployeeId`=? and OrganizationId=? ",array($no,$uid,$orgid));
			
		$data=array();
		$data['res']=$res;
		echo json_encode($data);
	}
	
public function resetPasswordLink(){   // generate and set reset password link
//mail("bitsvijay@gmail.com","pwd testing","testing mail");
		$una=isset($_REQUEST['una'])?$_REQUEST['una']:'';
		$orgid=isset($_REQUEST['refno'])?$_REQUEST['refno']:0;
		$orgid=$orgid=='131028'?'502':0;
		$email=$una;
		$una=encode5t($una);
		$query = $this->db->query("SELECT Id,`FirstName`,(SELECT  `resetPassCounter` FROM `UserMaster` WHERE `Username`=? and OrganizationId=?)as ctr FROM `EmployeeMaster` WHERE `Id`=(SELECT  `EmployeeId` FROM `UserMaster` WHERE `Username`=? and OrganizationId=?)",array($una,$orgid,$una,$orgid));
		if($query->num_rows()>0){
			if($row=$query->result()){	
//	 $url='https://ubiattendance.ubihrm.com/index.php/services/HastaLaVistaUbi?hasta='.encrypt($row[0]->Id).'&vista='.encrypt($orgid);
			 $url='https://ubiattendance.ubihrm.com/index.php/rakservices/HastaLaVistaUbi?hasta='.encrypt($row[0]->Id).'&vista='.encrypt($orgid);
			$msg=" Dear ".$row[0]->FirstName." 
				You have requested for reset your ubiAttendance login password, please click on the following link to reset your password ".$url." 
				Thanks 
				UBITECH TEAM
				" ;
				mail($email,"UbiAttendance reset Password",$msg);
				mail('vijay@ubitechsolutions.com',"UbiAttendance reset Password",$msg);
				mail('parth@ubitechsolutions.com',"UbiAttendance reset Password",$msg);
				echo 1; // valid id and ref
			}else
				echo 0;  
		}else
				echo 2;
}
public function getSuperviserSts(){
		$uid=isset($_REQUEST['uid'])?$_REQUEST['uid']:0;
		$orgid=isset($_REQUEST['refid'])?$_REQUEST['refid']:0;
		$query = $this->db->query("SELECT `appSuperviserSts`  FROM `UserMaster` WHERE  EmployeeId=? and OrganizationId=?",array($uid,$orgid));
		echo json_encode($query->result());
	}
	
	public function checkLinkValidity($uid,$orgid,$counter){
			$orgid=502;
			$query = $this->db->query("SELECT id  FROM `UserMaster` WHERE  EmployeeId=? and OrganizationId=? and resetPassCounter=?",array($uid,$orgid,$counter));
			
		return $query->num_rows();
		
	}
public function setPassword(){
		$uid=isset($_REQUEST['hasta'])?decrypt($_REQUEST['hasta']):0;
		$orgid=isset($_REQUEST['vista'])?decrypt($_REQUEST['vista']):0;
		$np=isset($_REQUEST['np'])?encode5t($_REQUEST['np']):'';
		$res=0;
	//	echo "UPDATE UserMaster SET Password='".$np."' WHERE EmployeeId=".$uid." and OrganizationId=".$orgid;
	//	return false;
		$query = $this->db->query("UPDATE `UserMaster` SET`Password`=?,resetPassCounter=resetPassCounter+1 WHERE EmployeeId=? and OrganizationId=?",array($np,$uid,$orgid));
		$res=$this->db->affected_rows();
		echo $res;
	}
public function test(){
	echo "Encoding 21: ".encode_vt5(21);
	echo "Decoding 540: ".decode_vt5(540);
	return false;
			$tz=0;
			$query = $this->db->query("SELECT * FROM `ZoneMaster` WHERE `CountryId`=93");
			if($row=$query->result())
					echo $row[0]->Id;
			else
					echo "Nothing";
	}
	//////-----------------------------------shift
	public function addShift(){
			$sna=isset($_REQUEST['name'])?$_REQUEST['name']:'';
			$ti=date("H:i:s", strtotime(isset($_REQUEST['ti'])?$_REQUEST['ti']:'00:00:00'));
			$to=date("H:i:s", strtotime(isset($_REQUEST['to'])?$_REQUEST['to']:'00:00:00'));
			$tib=date("H:i:s", strtotime(isset($_REQUEST['tib'])?$_REQUEST['tib']:'00:00:00'));
			$tob=date("H:i:s", strtotime(isset($_REQUEST['tob'])?$_REQUEST['tob']:'00:00:00'));
			$tig=date("H:i:s", strtotime(isset($_REQUEST['tig'])?$_REQUEST['tig']:'00:00:00'));
			$tog=date("H:i:s", strtotime(isset($_REQUEST['tog'])?$_REQUEST['tog']:'00:00:00'));
			$bog=date("H:i:s", strtotime(isset($_REQUEST['bog'])?$_REQUEST['bog']:'00:00:00'));
			$big=date("H:i:s", strtotime(isset($_REQUEST['big'])?$_REQUEST['big']:'00:00:00'));
			$shifttype=isset($_REQUEST['shifttype'])?$_REQUEST['shifttype']:0;
			$orgid=isset($_REQUEST['org_id'])?$_REQUEST['org_id']:'0';
			$sts=isset($_REQUEST['sts'])?$_REQUEST['sts']:0;
			$date=date('Y-m-d');
			$res=0;
			$query = $this->db->query("select Id from `ShiftMaster` where Name=? and OrganizationId=?  ",array($sna,$orgid));
			if($query->num_rows()>0)
				$res=0; // Shift Name already exist already exist
			else{				
			$query = $this->db->query("INSERT INTO `ShiftMaster`(`Name`, `TimeIn`, `TimeOut`, `TimeInGrace`, `TimeOutGrace`, `TimeInBreak`, `TimeOutBreak`, `OrganizationId`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `OwnerId`, `BreakInGrace`, `BreakOutGrace`, `archive`,shifttype) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($sna,$ti,$to,$tig,$tog,$tib,$tob,$orgid,$date,0,$date,0,0,$big,$bog,$sts,$shifttype));
			$res = $this->db->affected_rows();
			//////////////mail drafted on system configured-start
			if($res>0)
			{
				$sh=0;
				$dp=0;
				$ds=0;
				$sql='SELECT count(id) as total FROM `ShiftMaster` WHERE `OrganizationId`='.$orgid;
					$query1 = $this->db->query($sql);
					$row=$query1->result();
					$sh=$row[0]->total;
				$sql='SELECT count(id) as total FROM `DepartmentMaster` WHERE `OrganizationId`='.$orgid;
					$query1 = $this->db->query($sql);
					$row=$query1->result();
					$dp=$row[0]->total;
				$sql='SELECT count(id) as total FROM `DesignationMaster` WHERE `OrganizationId`='.$orgid;
					$query1 = $this->db->query($sql);
					$row=$query1->result();
					$ds=$row[0]->total;
				if($sh==2 && $dp>1 && $ds>1){
					$subject = "UbiAttendance - Configure your Attendance System now";
					$message = "
					<html>
					<head>
					<title>ubiAttendance</title>
					</head>
					<body>
					<h3>Hello ".getAdminName($orgid)."</h3>
					<br/><br/>
					Wonderful! Your Attendance system is configured now with <b>Company's Reference No. (CRN)</b>: ".(($orgid*$orgid)+99).".  
Kindly ask <b>Employees</b> to <a href='https://play.google.com/store/apps/details?id=org.ubitech.attendance'>download the App</a>
<br/><br/>
Please start <a>adding Employees</a> to the Attendance System. Employees can be added in two different ways:<br/><br/>

<b>Option 1: Employeesadded by the Admin(You)</b><br/>
					<ol>
						<li>
							<b>Login to ubiAttendance App</b>
						</li>
						<li>
							Click on the <b>Settings button</b> on dashboard
						</li>
						<li>
							Click on the <b>Employees Tab</b> & then on +' button
						</li>
						<li>
							<b>Enter Employee’s details</b> & click on <b>Register</b> Button
						</li>
						<li>
							The <b>Employee will be added</b> successfully
						</li>
					</ol>
					<br/>
					
					<b>
						Option 2: Employees can register themselves</b> using CRN. They should
					</br/>
						<ol>
							<li>
								Click on '<b>Not Registered? Sign Up</b>' and select Register employee.
							</li>
							<li>
								Enter <b>CRN (Company’s Reference Number)</b> of your Organisation 
							</li>
							<li>
								Fill <b>Employees details</b> and click on Register button
							</li>
							<li>
								The <b>Employee will be added</b> successfully
							</li>
						</ol><br/>
						Now the <b>Employees can start punching their attendance</b><br/>
						To access all the features of ubiAttendance,<a href='#'> upgrade to our premium plan</a><br/>
						<a href='https://www.youtube.com/channel/UCLplA-GWJOKZTwGlAaVKezg'>Click here</a> for our online resources. Contact support@ubitechsolutions.com for any queries.<br/>
					Cheers,</br/>
					Team ubiAttendance
					</body>
					</html>
					";
					// Always set content-type when sending HTML email
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// More headers
					$headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
					$headers .= 'Cc: vijay@ubitechsolutions.com' . "\r\n";
					$adminMail=getAdminEmail($orgid);
					mail($adminMail,$subject,$message,$headers);
					mail('nagendra@ubitechsolutions.com',$subject,$message,$headers);
				}
			}
			///////////////mail drafted on system conigured-close
			}
			$this->db->close();
			echo $res;
			
		}
	//////-----------------------------------/shift
	//////-----------------------------------/department
	public function addDept()
	{
			
			$id=0;
			$orgid=isset($_REQUEST['orgid'])?$_REQUEST['orgid']:0;
			$dna=isset($_REQUEST['name'])?$_REQUEST['name']:'';
			$sts=isset($_REQUEST['sts'])?$_REQUEST['sts']:0;
			$date=date('Y-m-d');
			$query = $this->db->query("INSERT INTO `DepartmentMaster`(`Name`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `OwnerId`, `OrganizationId`,`archive`) VALUES (?,?,?,?,?,?,?,?)",array($dna,$date,$id,$date,$id,$id,$orgid,$sts));
			
			$res = $this->db->affected_rows();
			//////////////mail drafted on system configured-start
			if($res>0)
			{
				$sh=0;
				$dp=0;
				$ds=0;
				$sql='SELECT count(id) as total FROM `ShiftMaster` WHERE `OrganizationId`='.$orgid;
					$query1 = $this->db->query($sql);
					$row=$query1->result();
					$sh=$row[0]->total;
				$sql='SELECT count(id) as total FROM `DepartmentMaster` WHERE `OrganizationId`='.$orgid;
					$query1 = $this->db->query($sql);
					$row=$query1->result();
					$dp=$row[0]->total;
				$sql='SELECT count(id) as total FROM `DesignationMaster` WHERE `OrganizationId`='.$orgid;
					$query1 = $this->db->query($sql);
					$row=$query1->result();
					$ds=$row[0]->total;
				if($sh>1 && $dp==2 && $ds>1){
					$subject = "UbiAttendance - Configure your Attendance System now";
					$message = "
					<html>
					<head>
					<title>ubiAttendance</title>
					</head>
					<body>
					<h3>Hello ".getAdminName($orgid)."</h3>
					<br/><br/>
					Wonderful! Your Attendance system is configured now with <b>Company's Reference No. (CRN)</b>: ".(($orgid*$orgid)+99).".  
Kindly ask <b>Employees</b> to <a href='https://play.google.com/store/apps/details?id=org.ubitech.attendance'>download the App</a>
<br/><br/>
Please start <a>adding Employees</a> to the Attendance System. Employees can be added in two different ways:<br/><br/>

<b>Option 1: Employeesadded by the Admin(You)</b><br/>
					<ol>
						<li>
							<b>Login to ubiAttendance App</b>
						</li>
						<li>
							Click on the <b>Settings button</b> on dashboard
						</li>
						<li>
							Click on the <b>Employees Tab</b> & then on +' button
						</li>
						<li>
							<b>Enter Employee’s details</b> & click on <b>Register</b> Button
						</li>
						<li>
							The <b>Employee will be added</b> successfully
						</li>
					</ol>
					<br/>
					
					<b>
						Option 2: Employees can register themselves</b> using CRN. They should
					</br/>
						<ol>
							<li>
								Click on '<b>Not Registered? Sign Up</b>' and select Register employee.
							</li>
							<li>
								Enter <b>CRN (Company’s Reference Number)</b> of your Organisation 
							</li>
							<li>
								Fill <b>Employees details</b> and click on Register button
							</li>
							<li>
								The <b>Employee will be added</b> successfully
							</li>
						</ol><br/>
						Now the <b>Employees can start punching their attendance</b><br/>
						To access all the features of ubiAttendance,<a href='#'> upgrade to our premium plan</a><br/>
						<a href='https://www.youtube.com/channel/UCLplA-GWJOKZTwGlAaVKezg'>Click here</a> for our online resources. Contact support@ubitechsolutions.com for any queries.<br/>
					Cheers,</br/>
					Team ubiAttendance
					</body>
					</html>
					";
					// Always set content-type when sending HTML email
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// More headers
					$headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
					$headers .= 'Cc: vijay@ubitechsolutions.com' . "\r\n";
					$adminMail=getAdminEmail($orgid);
					mail($adminMail,$subject,$message,$headers);
					mail('nagendra@ubitechsolutions.com',$subject,$message,$headers);
				}
			}
			///////////////mail drafted on system conigured-close
			echo $res;
		}
	//////-----------------------------------/department
	//////-----------------------------------/desgi
	public function addDesg(){
			$orgid=isset($_REQUEST['orgid'])?$_REQUEST['orgid']:0;
			$id=0;
			$dna=isset($_REQUEST['name'])?$_REQUEST['name']:'';
			$sts=isset($_REQUEST['sts'])?$_REQUEST['sts']:0;
			$desc=isset($_REQUEST['desc'])?$_REQUEST['desc']:'';
			$date=date('Y-m-d');
			$query = $this->db->query("INSERT INTO `DesignationMaster`(`Name`, `OrganizationId`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `OwnerId`,`Description`, `archive`) VALUES (?,?,?,?,?,?,?,?,?)",array($dna,$orgid,$date,$id,$date,$id,$id,$desc,$sts));
			$res = $this->db->affected_rows();
			//////////////mail drafted on system configured-start
			if($res>0)
			{
				$sh=0;
				$dp=0;
				$ds=0;
				$sql='SELECT count(id) as total FROM `ShiftMaster` WHERE `OrganizationId`='.$orgid;
					$query1 = $this->db->query($sql);
					$row=$query1->result();
					$sh=$row[0]->total;
				$sql='SELECT count(id) as total FROM `DepartmentMaster` WHERE `OrganizationId`='.$orgid;
					$query1 = $this->db->query($sql);
					$row=$query1->result();
					$dp=$row[0]->total;
				$sql='SELECT count(id) as total FROM `DesignationMaster` WHERE `OrganizationId`='.$orgid;
					$query1 = $this->db->query($sql);
					$row=$query1->result();
					$ds=$row[0]->total;
				if($sh>1 && $dp>1 && $ds==2){
					$subject = "UbiAttendance - Configure your Attendance System now";
					$message = "
					<html>
					<head>
					<title>ubiAttendance</title>
					</head>
					<body>
					<h3>Hello ".getAdminName($orgid)."</h3>
					<br/><br/>
					Wonderful! Your Attendance system is configured now with <b>Company's Reference No. (CRN)</b>: ".(($orgid*$orgid)+99).".  
Kindly ask <b>Employees</b> to <a href='https://play.google.com/store/apps/details?id=org.ubitech.attendance'>download the App</a>
<br/><br/>
Please start <a>adding Employees</a> to the Attendance System. Employees can be added in two different ways:<br/><br/>

<b>Option 1: Employeesadded by the Admin(You)</b><br/>
					<ol>
						<li>
							<b>Login to ubiAttendance App</b>
						</li>
						<li>
							Click on the <b>Settings button</b> on dashboard
						</li>
						<li>
							Click on the <b>Employees Tab</b> & then on +' button
						</li>
						<li>
							<b>Enter Employee’s details</b> & click on <b>Register</b> Button
						</li>
						<li>
							The <b>Employee will be added</b> successfully
						</li>
					</ol>
					<br/>
					
					<b>
						Option 2: Employees can register themselves</b> using CRN. They should
					</br/>
						<ol>
							<li>
								Click on '<b>Not Registered? Sign Up</b>' and select Register employee.
							</li>
							<li>
								Enter <b>CRN (Company’s Reference Number)</b> of your Organisation 
							</li>
							<li>
								Fill <b>Employees details</b> and click on Register button
							</li>
							<li>
								The <b>Employee will be added</b> successfully
							</li>
						</ol><br/>
						Now the <b>Employees can start punching their attendance</b><br/>
						To access all the features of ubiAttendance,<a href='#'> upgrade to our premium plan</a><br/>
						<a href='https://www.youtube.com/channel/UCLplA-GWJOKZTwGlAaVKezg'>Click here</a> for our online resources. Contact support@ubitechsolutions.com for any queries.<br/>
					Cheers,</br/>
					Team ubiAttendance
					</body>
					</html>
					";
					// Always set content-type when sending HTML email
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// More headers
					$headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
					$headers .= 'Cc: vijay@ubitechsolutions.com' . "\r\n";
					$adminMail=getAdminEmail($orgid);
					mail($adminMail,$subject,$message,$headers);
					mail('nagendra@ubitechsolutions.com',$subject,$message,$headers);
				}
			}
			///////////////mail drafted on system conigured-close
			echo $res;
		}
	public function getTimeoffList(){
			$data=array();
			$org_id=isset($_REQUEST['refno'])?$_REQUEST['refno']:'0';
			$start_week=isset($_REQUEST['fd'])?$_REQUEST['fd']:'0';
			$end_week=isset($_REQUEST['to'])?$_REQUEST['to']:'0';
			 $start_week = date("Y-m-d",strtotime($start_week));
			 $end_week = date("Y-m-d",strtotime($end_week));
			 $query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName) from EmployeeMaster where id= `EmployeeId`) as name, TIME_FORMAT(TimeFrom, '%H:%i') as TimeFrom ,TIME_FORMAT(TimeTo, '%H:%i') as TimeTo,TIME_FORMAT(TIMEDIFF( TimeTo, TimeFrom), '%H:%i') as diff,DATE_FORMAT(TimeofDate,'%d/%m/%Y') as tod FROM `Timeoff` where OrganizationId = ".$org_id." and TimeofDate  BETWEEN '".$start_week."' AND '".$end_week."' order by DATE(TimeofDate), name");
	
			$data['elist'][]=$query->result();
			echo json_encode($data, JSON_NUMERIC_CHECK);
		
//echo "SELECT (select CONCAT(FirstName,' ',LastName) from EmployeeMaster where id= `EmployeeId`) as name, TimeFrom,TimeTo,TIMEDIFF( TimeTo, TimeFrom) as diff FROM `Timeoff`,TimeofDate where OrganizationId = 10 and TimeofDate  BETWEEN '".$start_week."' AND '".$end_week."'";
		
		}
	//////-----------------------------------/desig
	
	public function getAppVersion(){
		$platform=isset($_REQUEST['platform'])?$_REQUEST['platform']:'Android';
		if($platform=='Android')
			$query = $this->db->query("SELECT android_version as version FROM  `PlayStore` LIMIT 1");
		else
			$query = $this->db->query("SELECT ios_version as version FROM  `PlayStore` LIMIT 1");
		echo json_encode($query->result());
	}
	public function checkPwdUpdate(){
		$id=isset($_REQUEST['id'])?$_REQUEST['id']:'0';
		$query = $this->db->query("SELECT password as skey FROM UserMaster where EmployeeId =$id");
		
		echo json_encode($query->result());
	}
	
	
	
public function mailtest(){
//	if( mail("vijay@ubitechsolutions.com","Testing Mail","Testing Mail body"))
//		echo "done";
  $org_id=10;
  $data=array();
   $begin = new DateTime('2017-11-04');
    $end = new DateTime('2017-12-03');

    $interval = new DateInterval('P1D'); // 1 Day
    $dateRange = new DatePeriod($begin, $interval, $end);
    $range = "";
    foreach ($dateRange as $date) {
        $range .= "'".$date->format('Y-m-d')."',";
    }
	$rangedate =$range;
  // print_r ($range);
  // echo json_encode($range);
  
  //$date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
	$query = $this->db->query("select (select count(EmployeeMaster.Id)-count(AttendanceMaster.Id) from EmployeeMaster where OrganizationId =".$org_id.") as total, AttendanceDate from AttendanceMaster where AttendanceDate 
		IN (
		".$rangedate." +''
		) and OrganizationId =$org_id group by AttendanceDate");
			foreach($query->result() as $row){
				echo '<br/>total: '.$row->total.'  date: '.$row->AttendanceDate .'<br/>';
					$query1 = $this->db->query('SELECT  `FirstName` ,Shift, Id
							FROM  `EmployeeMaster` 
							WHERE EmployeeMaster.OrganizationId ='.$org_id.'
							AND Id
							NOT IN (
							SELECT  `EmployeeId` 
							FROM  `AttendanceMaster` 
							WHERE  `AttendanceDate` 
							IN (
							 "'.$row->AttendanceDate .'"
							)
							AND AttendanceMaster.OrganizationId ='.$org_id.'
							)
							ORDER BY EmployeeMaster.Id');
							echo json_encode($query1->result());
			}
}

}
?>