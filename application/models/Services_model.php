<?php
class Services_model extends CI_Model {
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
			$org_perm="1,2,3";
			$date = date('Y-m-d');
			$device=isset($_REQUEST['device'])?$_REQUEST['device']:'';
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
			$query = $this->db->query("SELECT * FROM `UserMaster` , EmployeeMaster WHERE (Username=? or username_mobile=?)and Password=? and EmployeeMaster.id=UserMaster.`EmployeeId` and UserMaster.archive=1 and EmployeeMaster.OrganizationId not in(502,1074)",array($userName,$userName,$password)); // custom app- (502 for RAKP) 1074-Erawan
			if($query->num_rows()){
				foreach($query->result() as $row)
				{
					$data['response']=1;
					$data['fname']=ucfirst($row->FirstName);
					$data['lname']=ucfirst($row->LastName);
					$data['empid']=$row->EmployeeId;
					$data['status']=$row->VisibleSts;
					$data['orgid']=$row->OrganizationId;
					$data['sstatus']=$row->appSuperviserSts;
					$data['org_perm']=$org_perm;
					$result1 = $this->db->query("SELECT Name, Email FROM `Organization` WHERE id=?",array($data['orgid']));
					if($row1= $result1->row())
						if(strlen($row1->Name)>16)	
							$data['org_name']=substr($row1->Name,0,16).'...';
						else 
							$data['org_name']=$row1->Name;
						
							$data['orgmail']=$row1->Email;
						
					/*to fetch org trial status*/
					$result2 = $this->db->query("SELECT status, end_date FROM `licence_ubiattendance` WHERE OrganizationId =? order by id desc limit 1",array($data['orgid']));
					if($row2= $result2->row()){	
							$data['trialstatus']= $row2->status;
							if(date('Y-m-d',strtotime($row2->end_date)) < $date){
								$data['trialstatus']= 2;
							}
							$data['buysts']= $row2->status;
					}
						
					$data['desination']=getDesignation($row->Designation);
					
					if($row->ImageName!=""){
						$dir="public/uploads/".$row->OrganizationId."/".$row->ImageName;
						$data['profile'] = "https://ubitech.ubihrm.com/".$dir;
					}else{
						$data['profile'] = "http://ubiattendance.ubihrm.com/assets/img/avatar.png";
					}
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
			}else{
				$data['response']=0;
			}
				echo json_encode($data);
		}
		
		public function register_org(){	
	
			$org_name =  isset($_REQUEST['org_name'])?$_REQUEST['org_name']:"";
			$contact_person_name =  isset($_REQUEST['name'])?$_REQUEST['name']:"";
			$email =  isset($_REQUEST['email'])?strtolower(trim($_REQUEST['email'])):"";
			$password =  isset($_REQUEST['password'])?$_REQUEST['password']:"123456";
			$countrycode =  isset($_REQUEST['countrycode'])?$_REQUEST['countrycode']:"";
			$phone =  isset($_REQUEST['phone'])?$_REQUEST['phone']:"";
			$county =  isset($_REQUEST['country'])?$_REQUEST['country']:"0";
			$address =  isset($_REQUEST['address'])?$_REQUEST['address']:"";
		//	$password = ''.rand(100000,999999);
			//$password = $phone;
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
				
					$addonbulkatt = 0;
					$addonlocationtrack = 0;
					$addonvisit = 0;
					$addongeofence = 0;
					$addonpayroll = 0;
					$addontimeoff = 0;
					$query22 = $this->db->query('SELECT * FROM ubitech_login limit 1');
					foreach ($query22->result_array() as $row22)
					{
						$days  = $row22['trial_days'];
						$emplimit  = $row22['user_limit'];
						$addonbulkatt = $row22['bulk_attendance'];
						$addonlocationtrack = $row22['location_tracing'];
						$addonvisit = $row22['visit_punch'];
						$addongeofence = $row22['geo_fence'];
						$addonpayroll = $row22['payroll'];
						$addontimeoff = $row22['time_off'];
					}
				
					if($countrycode=='')
						$countrycode=getCountryCodeById1($county);
				
				  $query = $this->db->query("insert into Organization(Name,Email,countrycode,PhoneNumber,Country,Address,TimeZone,CreatedDate,LastModifiedDate,NoOfEmp) values('$org_name','$email','$countrycode','".$phone."',$county,'$address',$TimeZone,'$date','$date',$emplimit)");
				  
				 if($query>0){
					 
				/* 	$postdata = http_build_query(
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
					); */
				 /* 
						END Curl for SIA  RAAM  (CRM)
						
						
				 */
				 
				 $org_id = $this->db->insert_id(); 
				 $zone=getTimeZone($org_id);
				 date_default_timezone_set($zone);
				 $date=date('Y-m-d');
				 $query = $this->db->query("update Organization set CreatedDate=?,LastModifiedDate=? where Id=?",array($date,$date,$org_id));
				
				
				$epassword=encrypt($password);
				$query1 = $this->db->query("insert into admin_login(username,password,email,OrganizationId,name) values('$username','$epassword','$email',$org_id,'$contact_person_name')");
				// this code for insert days trial days start //
				
				
			    $start_date = date('Y-m-d');
				
				// create default disable email alert
				$query33 = $this->db->query("INSERT INTO Alert_Settings(OrganizationId, Created_Date) VALUES ($org_id,'$start_date')");
				///////////////////////////////////////
				
			    $end_date = date('Y-m-d', strtotime("+".$days." days"));
			    $query33 = $this->db->query("insert into licence_ubiattendance(OrganizationId,start_date,end_date,extended,user_limit,Addon_BulkAttn,Addon_LocationTracking,Addon_VisitPunch,Addon_GeoFence,Addon_Payroll,Addon_TimeOff) values($org_id,'$start_date','$end_date',1,$emplimit,$addonbulkatt,$addonlocationtrack,$addonvisit,$addongeofence,$addonpayroll,$addontimeoff)");
				// this code for insert days trial days end //
				
				//// This Code For Insert ShiftMaster,DepartmentMaster,DesignationMaster Table Start ////
				  $data1 = array(
				  array('Name' => 'Dummy Department','OrganizationId' => $org_id ),
				  array('Name' => 'Human Resource','OrganizationId' => $org_id ),
				  array('Name' => 'Finance','OrganizationId' => $org_id ),
				  array('Name' => 'Marketing','OrganizationId' => $org_id )
				  );
				  $this->db->insert_batch('DepartmentMaster', $data1);
				  $data1 = array(array('Name' => 'Dummy shift','TimeIn'=>'09:00:00','TimeOut'=>'18:00:00','OrganizationId' => $org_id));
				  $this->db->insert_batch('ShiftMaster', $data1);
				   $data1 = array(
				   array('Name' => 'Dummy Designation','OrganizationId' => $org_id),
				   array('Name' => 'Manager','OrganizationId' => $org_id),
				   array('Name' => 'HR','OrganizationId' => $org_id),
				   array('Name' => 'Clerk','OrganizationId' => $org_id),
				   array('Name' => 'Trial Designation','OrganizationId' => $org_id));	
				  $this->db->insert_batch('DesignationMaster', $data1);
				////  This Code For Insert ShiftMaster,DepartmentMaster,DesignationMaster Table End ////
				///////////////////////////-----creating default user-start
						$shift='0';
						$desg='0';
						$dept='0';
				$qry = $this->db->query("select Id as shift from ShiftMaster where  OrganizationId=".$org_id." order by id limit 1"); 
				if ($r=$qry->result())
						$shift=$r[0]->shift;;
				$qry = $this->db->query("select Id as dept from DepartmentMaster where  OrganizationId=".$org_id." order by id limit 1"); 
				if ($r=$qry->result())
						$dept=$r[0]->dept;;
				$qry = $this->db->query("select Id as desg from DesignationMaster where  OrganizationId=".$org_id." order by id limit 1"); 
				if ($r=$qry->result())
						$desg=$r[0]->desg;;
					
							$qry = $this->db->query("insert into EmployeeMaster(FirstName,LastName,doj,countrycode,PersonalNo,Shift,OrganizationId,Department,Designation,CompanyEmail) values('$contact_person_name',' ','$date','$countrycode','".encode5t($phone)."',$shift,$org_id,$dept,$desg,'".encode5t($email)."')"); 
							 if ($qry > 0) {
									$emp_id = $this->db->insert_id();
									$qry1   = $this->db->query("INSERT INTO `UserMaster`(`EmployeeId`,appSuperviserSts, `Password`, `Username`,`OrganizationId`,CreatedDate,LastModifiedDate,username_mobile,archive,HRSts) VALUES ($emp_id,1,'" . encode5t($password) . "','" . encode5t($email) . "',$org_id,'$start_date','$start_date','" . encode5t($phone) . "',1,1)");
									if ($qry1 > 0)
										$data['id'] = $emp_id;
									$today = date('Y-m-d');
									 for ($i = 1; $i < 8; $i++)// create default weekly off
										$query = $this->db->query("INSERT INTO `ShiftMasterChild`(`ShiftId`,`Day`,`WeekOff`, `OrganizationId`, `ModifiedBy`, `ModifiedDate`) VALUES (?,?,'0,0,0,0,0',?,?,?)",array($shift,$i,$org_id,$emp_id,$today));
									  
									$data['org_id'] = $org_id;
                }
				///////////////////////////-----creating default user-end 
				$countryName='';
				$query = $this->db->query("SELECT Name FROM `CountryMaster` WHERE Id=$county");
					if($row=$query->result())
					$countryName= $row[0]->Name;
				if($query1>0){
					//////////////////-------------activate mail body-strt
					$message='<html>
					<head>
					<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
					<meta name=Generator content="Microsoft Word 12 (filtered)">
					<style>
					</style>

					</head>

					<body lang=EN-US link=blue vlink=purple>

					<div class=Section1>

					<div align=center>

					<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width="550"
					 style="550px;border-collapse:collapse" align="center">
					 <tr style="height:328.85pt">
					  <td width=917 valign=top style="width:687.75px;padding:0in 0in 0in 0in;
					  height:328.85px">
					  <div align=center>
					  <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width="100%" style="width:100.0%;border-collapse:collapse">
					   <tr>
						<td valign=top style="background:#52BAD5;padding:0in 16.1pt 0in 16.1pt">
						<div align=center>
						<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
						 width="100%" style="width:100.0%;border-collapse:collapse">
						 <tr>
						  <td valign=top style="padding:21.5pt 0in 21.5pt 0in">
						  <p class=MsoNormal align=center style="margin-bottom:0in;margin-bottom:
						  .0001pt;text-align:center;line-height:normal"><span style="font-size:
						  12.0pt;font-family:Arial,sans-serif"><img width=200 
						  id="Picture 1" src="http://ubitechsolutions.com/ubitechsolutions/Mailers/ubiAttendance/ubiAttendance/logo.png" alt="ubitech solutions"></span></p>
						  </td>
						 </tr>
						</table>
						</div>
						</td>
					   </tr>
					   <tr>
						<td valign=top style="background:#52BAD5;padding:0in 16.1pt 0in 16.1pt">
						<div align=center>
						<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
						 width="100%" style="width:100.0%;border-collapse:collapse">
						 <tr>
						  <td valign=top style="padding:0in 0in 0in 0in">
						  <div align=center>
						  <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
						   width="100%" style="width:100.0%;border-collapse:collapse">
						   <tr>
							<td valign=top style="padding:0in 0in 0in 0in">
							<div align=center>
							<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
							 width="100%" style="width:100.0%;background:white">
							 <tr>
							  <td width="550" valign=top style="width:550px;padding:21.5pt 0in 0in 0in">
							  <p class=MsoNormal align=center style="margin-bottom:0in;margin-bottom:
							  .0001pt;text-align:center;line-height:normal"><span style="font-size:
							  12.0pt;font-family:Arial,sans-serif">&nbsp;</span></p>
							  </td>
							 </tr>
							</table>
							</div>
							</td>
						   </tr>
						  </table>
						  </div>
						  </td>
						 </tr>
						</table>
						</div>
						</td>
					   </tr>
					   <tr>
						<td valign=top style="padding:0in 0in 0in 0in">
						<div align=center>
						<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
						 width="550" style="width:550px;border-collapse:collapse">
						 <tr>
						  <td valign=top style="padding:0in 0in 0in 0in">
						  <div align=center>
						  <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
						   width="550" style="width:550px;border-collapse:collapse">
						   <tr>
							<td width=30 valign=top style="width:22.5pt;padding:0in 0in 0in 0in">
							<p class=MsoNormal align=right style="margin-bottom:0in;margin-bottom:
							.0001pt;text-align:right;line-height:normal"><span style="font-size:
							12.0pt;font-family:Arial,sans-serif"><img width=30 height=59
							id="Picture 2" src="http://ubitechsolutions.com/ubitechsolutions/Mailers/ubiAttendance/ubiAttendance/image002.jpg" alt=" "></span></p>
							</td>
							<td width="550" valign=top style="width:550px;padding:0in 37.6pt 0in 21.5pt">
							<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
							 align=center width="550" style="550px;border-collapse:collapse">
							 <tr>
							  <td valign=top style="padding:0in 0in 21.5pt 0in">
							  <p class=MsoNormal align=center style="margin-bottom:0in;margin-bottom:
							  .0001pt;text-align:left;line-height:22.55pt"><b><p style="font-size:20.0pt;font-family:Helvetica,sans-serif;
							  color:#606060;text-align:center;">Welcome - now let’s get started!<br/>
							  </p>  	
								<p style="font-size:14.0pt;font-family:Helvetica,sans-serif;
							  color:#606060;text-align:center;">
								<a href="https://ubiattendance.ubihrm.com/index.php/services/activateAccount?iuser='.encrypt($emp_id).'">Verify now to start your trial</a>
								</p>
							
								<div align=center>
							  <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
							   width="550" style="width:550px;border-collapse:collapse">
							   <tr>
								<td align="center" style="padding:0in 0in 0in 0in">
								<a href="https://ubiattendance.ubihrm.com/index.php/services/activateAccount?iuser='.encrypt($emp_id).'" target="_blank" style="font-size:20px;font-family:Helvetica,sans-serif;color:white;text-decoration:none">
								<p class=MsoNormal align=center style="margin-bottom:0in;								margin-bottom:.0001pt;text-align:center;line-height:normal; background:#52bad5;width: 250px;padding: 15px;">Verify your Account</span></b></span></p></a>
								</td>
							   </tr>
							  </table>
							  </div>
								<span
							  style="font-size:14.0pt;font-family:Helvetica,sans-serif;
							  color:#606060">
							  
							 <br/> Hello '.strtok($contact_person_name, " ").',
							  
								</span></b>
								<p style="text-align: left;" class="paragraph-text">
								Thanks for trying ubiAttendance. You’re going to love it.<br/><br/>
								First thing’s first:  <a href="https://ubiattendance.ubihrm.com/index.php/services/activateAccount?iuser='.encrypt($emp_id).'">Verify your Account</a> to start exploring our world class App.<br/>Enjoy your 15-day trial to your heart’s content!<br/><br/><br/>Need more help?  <a href="mailto:ubiattendance@ubitechsolutions.com">Contact us</a> or <a target="_blank" href="https://www.youtube.com/channel/UCLplA-GWJOKZTwGlAaVKezg">View our Channel</a> and learn about key features and best practices.
								</p>
								
							  </p>
							  </td>

							 </tr>
							 <tr>
							 
							 </tr>
							 <tr>
							  <td valign=top style="padding:0in 0in 2.7pt 0in">
									Cheers,<br/>Team ubiAttendance<br/><a href="http://www.ubiattendance.com/" target="_blank">www.ubiattendance.com</a><br/> Tel/ Whatsapp: +91 70678 22132<br/>Email: ubiattendance@ubitechsolutions.com<br/>Skype: ubitech.solutions
							  </td>
							 </tr>
							 
							</table>

							</td>
						   </tr>
						  </table>
						  </div>
						  </td>
						 </tr>
						</table>
						</div>
						</td>
					   </tr>
					  </table>
					  </div>
					  </td>
					 </tr>
					</table>

					</div>


					</div>


					</body>

					</html>';
				//	$message='Hello, You have registered successfully';
					$headers = 'From: <noreply@ubiattendance.com>' . "\r\n";
					$subject="You have successfully registered on ubiAttendance";
					sendEmail_new($email,$subject,$message,$headers);
					sendEmail_new('sohan@ubitechsolutions.com',$subject,$message,$headers);
					sendEmail_new('ubiattendance@ubitechsolutions.com',$subject,$message,$headers);
					//sendEmail_new('deeksha@ubitechsolutions.com',$subject,$message,$headers);
				
					//////////////////-------------activate mail body-close
  /////////////code by abhinav--CRM integration
					 $crn=encode_vt5($org_id);
					 $country_name=getName("CountryMaster", "Name", "id", $county);
				  
				 
				//$url = "http://ubitechsolutions.in/ubitech/UBICRM_SANDBOX/UbiAttendance_Integration.php";			
				/* $url = "https://ubirecruit.com/UBICRMNEW/GetLeadJson/";		
				$ch = curl_init($url);
				$arr=array(
							'inq_salutation' => "",						
							'fname' => $contact_person_name,
							'lname' => "",
							'email_id' => $email,
							'telephone_no' => "(".$countrycode.")".$phone,
							'inq_source' => "Mobile App registration",
							'inq_address' => $address,
							'inq_city' => $address,
							'inq_state' => "",
							'inq_country' => $country_name,
							'inq_zipcode' => "",
							'inq_stage' => "Trial",
							'inq_type'=>"",				
							'inq_company' => $org_name,
							'inq_mobile' => "(+".$countrycode.")".$phone,
							'inq_industry' => "",
							'inq_website' => "",
							'inq_desc' => "CRN no. - ".$crn,
							'product' => "ubiAttendance",
							'orgid' => "==AUVZ0RW5GaKJFbaNVTWJVU"
						);
						
					 
					 $payload = json_encode($arr);
						
						 //$arrval = str_replace("\\","",$arrval);
						 Trace($payload);
						//attach encoded JSON string to the POST fields
						curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

						//set the content type to application/json
						curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

						//return response instead of outputting
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

						//execute the POST request
						$result = curl_exec($ch);
						
						//close cURL resource
						curl_close($ch); */
						/////////////code by abhinav--CRM integration--close
				
				
					  echo json_encode($data);
					// echo $admin_id =  $this->db->insert_id();
				}
			 }else{
				  $data['sts']=0;
				  echo json_encode($data);
			 }
			  
			}	
		}
		public function activateAccount(){
			$empid =isset($_REQUEST['iuser'])?decrypt($_REQUEST['iuser']):0;
			$org_id=0;
			$email='(registered email id)';
			$contact='(registered contact no.)';
			$password='';
			$name='';
			$query = $this->db->query("select Username,username_mobile,Password,OrganizationId,(SELECT FirstName from  EmployeeMaster where  EmployeeMaster.Id=?)as FirstName from UserMaster where EmployeeId = ? order by Id limit 1",array($empid,$empid));
			if($row=$query->result()){
					$org_id		=	$row[0]->OrganizationId;
					$email		=	decode5t($row[0]->Username);
					$contact	=	decode5t($row[0]->username_mobile);
					$password	=	decode5t($row[0]->Password);
					$name		=	$row[0]->FirstName;	
			}
			
  			$updSts=0;
  			$sql = "update UserMaster set archive=1,VisibleSts = 1 where EmployeeId = $empid";
  			$query1 = $this->db->query($sql);
			$updSts=$this->db->affected_rows();
			$query = $this->db->query("UPDATE `Organization` SET `mail_varified`=1 WHERE Id=(select OrganizationId from UserMaster where EmployeeId = ?)",array($empid));
			$updSts += $this->db->affected_rows();
			$this->db->close();
			if($updSts){
				$message= "Hello ".$name.","."<br/><br/>
				Greetings from ubiAttendance Team…! <br/><br/>

				Congratulations! <b>'".getOrgName($org_id)."'</b> is successfully registered. You have been assigned <b>Admin Rights</b>.

				Company's Reference No. (CRN) is ".encode_vt5($org_id)."<br/><br/>

				<b>Login details for Mobile App</b><br/>
				Username:	".$email." or ".$contact."<br/>
				Password:	".$password."<br/><br/>


				Cheers,<br/>
				Team ubiAttendance<br/><a target='_blank' href='www.ubiattendance.com'>www.ubiattendance.com</a><br/> Tel/ Whatsapp:  +91-7067835131, 7067822132, 6264345452<br/>Email: ubiattendance@ubitechsolutions.com";
					$headers = 'From: <noreply@ubiattendance.com>' . "\r\n";
					$subject= "Congratulations ".$name."! Your ubiAttendance login details";
					sendEmail_new($email,$subject,$message,$headers);
					sendEmail_new('vijay@ubitechsolutions.com',$subject,$message,$headers);
					sendEmail_new('ubiattendance@ubitechsolutions.com',$subject,$message,$headers);
			}
  			return $updSts; 
		}
		public function activateOrg(){
			$org_id =isset($_REQUEST['iuser'])?decrypt($_REQUEST['iuser']):0;	
			Trace('OrgId: '.$org_id);
  			$query1 = $this->db->query("update UserMaster set archive=1,VisibleSts = 1 where OrganizationId = ?",array($org_id));
			$updSts=$this->db->affected_rows();
			$query = $this->db->query("UPDATE `Organization` SET `mail_varified`=1 WHERE Id=?",array($org_id));
			$updSts+=$this->db->affected_rows();
			$this->db->close();
  			return $updSts; 
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
		$password1 = encode5t(isset($_REQUEST['password'])?$_REQUEST['password']:'');
		$username = isset($_REQUEST['username'])?encode5t(strtolower($_REQUEST['username'])):'';
		$shift = isset($_REQUEST['shift'])?$_REQUEST['shift']:''; 
		$designation = isset($_REQUEST['designation'])?$_REQUEST['designation']:'';
		$department = isset($_REQUEST['department'])?$_REQUEST['department']:'';
		$contact = isset($_REQUEST['contact'])?encode5t($_REQUEST['contact']):'';
		$org_id = isset($_REQUEST['org_id'])?$_REQUEST['org_id']:'';
		$countrycode =isset($_REQUEST['countrycode'])?$_REQUEST['countrycode']:"";
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
			if($con>0){
				$data['sts']=3; // if Contact already exist
			}else if($ml>0){
					$data['sts']=2; // if email id already exist
			}else{
				/*----------------default shift/dept/designation-------------------*/
				if($shift=='' || $shift=='0')
				{
					$qry=$this->db->query("SELECT Id FROM `ShiftMaster` WHERE OrganizationId=$org_id  order by Id ASC limit 1");
					if ($r=$qry->result())
							$shift  = $r[0]->Id;
				}
				if($department=='' || $department=='0')
				{
					$qry=$this->db->query("SELECT Id FROM `DepartmentMaster` WHERE OrganizationId=$org_id order by Id ASC limit 1 ");
					if ($r=$qry->result())
							$department  = $r[0]->Id;
				}
				if($designation=='' || $designation=='0')
				{
					$qry=$this->db->query("SELECT Id FROM `DesignationMaster` WHERE OrganizationId=$org_id  order by Id ASC limit 1");
					if ($r=$qry->result())
							$designation  = $r[0]->Id;
				}
				/*----------------default shift/dept/designation-close-------------------*/
			  $query = $this->db->query("insert into EmployeeMaster(FirstName,LastName,PersonalNo,Shift,OrganizationId,Department,Designation,
			  CompanyEmail,countrycode,CurrentCountry,CreatedDate,doj) values('$f_name','$l_name','$contact',$shift,$org_id,$department,$designation,'$username','$countrycode',$country,'$date','$date')");

			 
  					 	
  						

			 if($query>0){
				 $emp_id = $this->db->insert_id();
				 $query1 = $this->db->query("INSERT INTO `UserMaster`(`EmployeeId`, `Password`, `Username`,`OrganizationId`,CreatedDate,LastModifiedDate,username_mobile) VALUES ($emp_id,'$password1','$username',$org_id,'$date','$date','$contact')");
				 if($query1>0){
					 $data['sts']=1;
					 $data['id']=$emp_id;
					if($admin==1){ //emp added by admin
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
						Password: ".$_REQUEST['password']."<br/>	
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
					$adminMail=getAdminEmail($org_id);
					sendEmail_new($adminMail,$subject,$message,$headers);
				//	sendEmail_new('vijay@ubitechsolutions.com',$subject,$message,$headers);
					sendEmail_new('ubiattendance@ubitechsolutions.com',$subject,$message,$headers);
		 ///////////////////mail drafted to admin/
					 
					  
				}
				 $date = date("y-m-d H:i:s");
				   $orgid =$_SESSION['orgid'];
				   $id =$_SESSION['id'];
				   $module = "Employees";
				   $actionperformed = " <b>".$f_name." ".$l_name."</b> has been added from <b>Self registration. </b>.";
				   $activityby = 1;
				   if($query1>0){
				   $query222 = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy) VALUES (?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby));
					/*
					 
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
					//	sendEmail_new($email,$subject,$message,$headers);
						
						sendEmail_new($empmailid,$subject,$message,$headers);
						sendEmail_new('vijay@ubitechsolutions.com',$subject,$message,$headers);
						 
						sendEmail_new('ubiattendance@ubitechsolutions.com',$subject,$message,$headers);
					 ///////////////////mail drafted to employee/
					} // emp added by admn/
			*/		 
					}
					else{ // if emp get registered by himself
					 
					 ///////// mail drafted to admin
					/* $message="<html>
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
						Password: ".$_REQUEST['password']."<br/>						
						</b>
						</p>
						<p>
							<a href='http://ubiattendance.ubihrm.com/index,php/services/useridcard/".$org_id."/".$emp_id."' target='_blank' >
							Generate ".$f_name." ".$l_name."’s
							 QR code </a>						
						</p>
						<h5>Regards,</h5>
						<h5>Team ubiAttendance </h5>
					</body>
					</html>
					";*/
					$message="<html>
  						<head>
							<title>ubiAttendance</title>
  						</head>
						<body>
						<h3>Dear Admin,</h3>
						<p>Employee are registered in ubiAttendance App for “ Ubitech Solutions”. Kindly punch your attendance through the following steps.</p>
						<ol>
						<li> 
							Download the Android App by clicking <a  href='https://play.google.com/store/apps/details?id=org.ubitech.attendance'>https://play.google.com/store/apps/details?id=org.ubitech.attendance</a> 
							iPhone users can download through 
							<a href='https://itunes.apple.com/us/app/ubiattendance-ubitech/id1375252261?mt=8 '>https://itunes.apple.com/us/app/ubiattendance-ubitech/id1375252261?mt=8</a>
						</li>
						<li>Install the App.  It will be added to the home screen</li>
						<li>Open the App & sign in. User name will be the registered Email/Phone no.</li>
						<li>Initial Sign in Password is ".$_REQUEST['password']."</li>
						<li>You can now start punching the attendance.</li>
						<li><a download href='http://192.168.0.200/ubiattendance/assets/PDF/Get%20started%20with%20ubiAttendance%20-%20Employees.pdf'>Download</a> the detailed Employee guide</li>
						</ol>
						</body>
						</html>";
						//echo $message;
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// More headers
					$headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
					//$headers .= 'Cc: vijay@ubitechsolutions.com' . "\r\n";
					$subject=$f_name." ".$l_name." is registered on ubiAttendance.";
				//	sendEmail_new($email,$subject,$message,$headers);
					$adminMail=getAdminEmail($org_id);
					sendEmail_new($adminMail,$subject,$message,$headers);
					//sendEmail_new('vijay@ubitechsolutions.com',$subject,$message,$headers);
					sendEmail_new('ubiattendance@ubitechsolutions.com',$subject,$message,$headers);
					 ///////// mail drafted to admin/
					 
					 ///////// mail drafted to employee
					$empmailid=$_REQUEST['username'];
					 if($empmailid!=''){ // trigger mail to employee
						/*	 $message="<html>
							<head>
							<title>ubiAttendance</title>
							</head>
							<body>Dear ".$f_name." ".$l_name.",<br/>
							<p>
							Congratulations!! You have been registered as an Employee of  ".getOrgName($org_id).".<br/><br/>
							Kindly <a> Download ubiAttendance App from <a href='https://play.google.com/store/apps/details?id=org.ubitech.attendance'>Google Play Store</a>. 
							<b>
							<br/>
							Login details:<br/>
							
							Username(Phone#): ".$empmailid." or  ".$_REQUEST['contact']."<br/>
							Password: ".$_REQUEST['password']."<br/><br/>
														
							</b> 	
							<br/>
							<br/>
							
							<h5>Cheers,</h5>
							<h5>Team ubiAttendance </h5>
						</body>
						</html>
						";
					*/
							/*$message="<html>
  							<head>
  							<title>ubiAttendance</title>
  							</head>
  							<body>Dear ".$f_name." ".$l_name.",<br/>
  							<p>
  							Congratulations!! You have been added to the Employees’ List of <b> ".getOrgName($org_id)."</b>.
  							<br/><br/>
  							</b>Your Login Details are:<b/><br/><br/>
  							Username(Phone#): ".$_REQUEST['contact']."<br/>
  							Password: ".$_REQUEST['password']."<br/>
  							</b>
  							</p>
  							<p>
  								Get QR code by clicking <b> <a href='https://ubiattendance.ubihrm.com/index.php/services/useridcard/".$org_id."/".$emp_id."' target='_blank' >Generate QR Code</a></b>						
  							</p>
  							<p>
  								<a href='https://play.google.com/store/apps/details?id=org.ubitech.attendance'>Download</a> App on Google Play Store. You can refer to our <a href='http://www.ubitechsolutions.com/images/ubiAttendance%20User%20Guide%20(For%20Employees).pdf'>Get Started Guide</a> for quick onboarding. 
  							</p>
  							<h5>Regards,</br>
  							Team ubiAttendance</h5>
  						</body>
  						</html>
  						";*/

//////////////new mail body by vanshika/////////
					$message="<html>
					<head>
					<title>ubiAttendance</title>
					</head>
					<body>
					Congratulations <b>".$f_name."</b>!!<br/>
					You are registered on ubiAttendance App for ".getOrgName($org_id)." .<br/>
					<ol>
					<li>Download & install the App through any of the links below:</li>
						<ol>
						<li>Android -<a href='https://play.google.com/store/apps/details?id=org.ubitech.attendance'>https://play.google.com/store/apps/details?id=org.ubitech.attendance</a></li>
						<li>iPhone -<a href='https://itunes.apple.com/us/app/ubiattendance-ubitech/id1375252261?mt=8 '>https://itunes.apple.com/us/app/ubiattendance-ubitech/id1375252261?mt=8</a></li>
						</ol>
						<li>Open the App & sign in.</li>
						Login details for Mobile App<br/>
						Username: ".$_REQUEST['username']."<br/>
						Password: ".$_REQUEST['password']."<br/>
						OR<br/>
						Username: ".$_REQUEST['contact']."<br/>
						Password: ".$_REQUEST['password']."<br/>
						<li>Click on “Time In” button to punch attendance.</li>
					</ol>
					<p>For further assistance, kindly contact your system administrator.</p>
					<h5>Cheers,</h5>
					<h5>ubiAttendance Team</h5>
					</body>
					</html>";	
////////////////////////////////////////




						
						// Always set content-type when sending HTML email
						$headers = "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
						// More headers
						$headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
					//$headers .= 'Cc: vijay@ubitechsolutions.com' . "\r\n";
						$subject="You have registered on ubiAttendance.";
					//	sendEmail_new($email,$subject,$message,$headers);
						sendEmail_new($empmailid,$subject,$message,$headers);//sendEmail_new('vijay@ubitechsolutions.com',$subject,$message,$headers);
						sendEmail_new('ubiattendance@ubitechsolutions.com',$subject,$message,$headers);
						///////// mail drafted to employee/
					 }
					 }
			 }else{ 
				 $data['sts']=0;
			 }
			 //////////---------check users limit
		$query = $this->db->query("select count(id) as totalUsers,(select NoOfEmp from Organization where Organization.Id =$org_id) as ulimit,(select status from licence_ubiattendance where licence_ubiattendance.OrganizationId =$org_id) as orgstatus from UserMaster where OrganizationId = $org_id");
			if ($r=$query->result())
			{
				if($r[0]->totalUsers>$r[0]->ulimit)
				{
					$range='1-20';
					if($r[0]->totalUsers<21)
						$range='1-20';
					else if($r[0]->totalUsers>=21 && $r[0]->totalUsers<41)
						$range='21-40';
					else if($r[0]->totalUsers>=41 && $r[0]->totalUsers<61)
						$range='41-60';
					else if($r[0]->totalUsers>=61 && $r[0]->totalUsers<81)
						$range='61-80';
					else if($r[0]->totalUsers>=81 && $r[0]->totalUsers<101)
						$range='81-100';
					else if($r[0]->totalUsers>=101 && $r[0]->totalUsers<121)
						$range='101-120';
					else
						$range='120+';
					
					
					$sdate='-';	
					$edate='-';	
					$country=93;	
					$rate_per_day=0;
					$days=0;
					$currency='';
					$due=0;
					$orgstatus=$r[0]->orgstatus;
					
					$query1 = $this->db->query("select start_date,end_date,status, due_amount,DATEDIFF(end_date,CURDATE())as days,(SELECT `Country` FROM `Organization` WHERE `Id`=$org_id)as country from licence_ubiattendance where OrganizationId  =$org_id");
					if ($r1=$query1->result()){
						$sdate	=	$r1[0]->start_date;	
						$edate	=	$r1[0]->end_date;
						$days	=	$r1[0]->days;
						$due	=	$r1[0]->due_amount;
						$currency=	$r1[0]->country==93?'INR':'USD';
						
						$data['trialstatus']= $r1[0]->status;
							if(date('Y-m-d',strtotime($edate)) < $date){
								$data['trialstatus']= 2;
							}
							$data['buysts']= $r1[0]->status;
							
						$query2 = $this->db->query("SELECT  monthly  FROM `Attendance_plan_master` WHERE `range`='$range' and `currency`='$currency' ");
						if ($r2=$query2->result())
							$rate_per_day	=	($r2[0]->monthly)/30 ;
					}
					
					$payable_amt=0;
					$tax=0;
					$total=0;
					if($currency=='INR')
						$tax		=	($rate_per_day)*($days)*(0.18);
						$payable_amt=	$rate_per_day*$days;
						$payamtwidtax = round(($payable_amt+$tax),2);
						$total		=	round(($due+$tax+$payable_amt),2);
				/////////////update due amount-start
					$query1 = $this->db->query("UPDATE `licence_ubiattendance` SET `due_amount`=$total WHERE `OrganizationId` =$org_id");
				/////////////update due amount-close
					if($orgstatus==1){
						$subject=getOrgName($org_id)." -Billing details for changed users";
						//$subject="ubiAttendance - Exceeded User Limit";
						$message="<div style='color:black'>
					Greetings from ubiAttendance App<br/><br/>
					The no. of users in your ubiAttendance Plan have exceeded. We have updated your plan.  Below are the payment details for the additional Users. <br/>
					<h4 style='color:blue'>Plan Details:</h4>
					Company name: ".getOrgName($org_id)."<br/>
					Plan Start Date:".date('d-M-Y',strtotime($sdate))."<br/>
					Plan End Date:".date('d-M-Y',strtotime($edate))."<br/>
					User limit: ".$r[0]->ulimit."<br/>
					Registered Users: ".($r[0]->totalUsers)."<br/>
					<br/>
					<h4 style='color:blue'>Billing Details:</h4>
					Previous Dues: ".$due.' '.$currency." <br/>
					Amount Payable for additional Users: ".$payamtwidtax.' '.$currency."<br/>
					Amount Payable: ".$payamtwidtax." + ".$due." = ".$total." ".$currency." <br/>
					<br/>
					<a href='".URL."'>Update your plan now</a> so that there is no disruption in our services<br/><br/>";
					$message.="Cheers,<br/>
					Team ubiAttendance<br/><a target='_blank' href='http://www.ubiattendance.com'>www.ubiattendance.com</a><br/> Tel/ Whatsapp: +91 70678 22132<br/>Email: ubiattendance@ubitechsolutions.com<br/>Skype: ubitech.solutions</div>";
						$headers = "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
						$headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
						$adminMail=getAdminEmail($org_id);
						//echo $message;
						sendEmail_new($adminMail,$subject,$message,$headers);
						//sendEmail_new('vijay@ubitechsolutions.com',$subject,$message,$headers);
						sendEmail_new('ubiattendance@ubitechsolutions.com',$subject,$message,$headers);
						//sendEmail_new('deeksha@ubitechsolutions.com',$subject,$message,$headers);
					}
				}
			}
		//////////---------check user's limit--close
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
	public function saveImage()
	{
		$userid=isset($_REQUEST['uid'])?$_REQUEST['uid']:0;
		$addr=isset($_REQUEST['location'])?$_REQUEST['location']:'';
		$aid=isset($_REQUEST['aid'])?$_REQUEST['aid']:0;
		$act=isset($_REQUEST['act'])?$_REQUEST['act']:'TimeIn';
		$shiftId=isset($_REQUEST['shiftid'])?$_REQUEST['shiftid']:0;
		$orgid=isset($_REQUEST['refid'])?$_REQUEST['refid']:0;
		$latit=isset($_REQUEST['latit'])?$_REQUEST['latit']:'0.0';
		$longi=isset($_REQUEST['longi'])?$_REQUEST['longi']:'0.0';
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
				$sql="UPDATE `AttendanceMaster` SET `ExitImage`='".IMGURL.$new_name."',CheckOutLoc='$addr',latit_out='$latit',longi_out='$longi', TimeOut='$time', LastModifiedDate='$stamp',overtime =(SELECT subtime(subtime('$time',timein),
				(select subtime(timeout,timein) from ShiftMaster where id=$shiftId)) as overTime )
				WHERE id=$aid and `EmployeeId`=$userid  and date(AttendanceDate) = '$date' ";  //and SUBTIME(  `TimeOut` ,  `TimeIn` ) >'00:05:00'";
			else
				$sql="UPDATE `AttendanceMaster` SET `ExitImage`='".IMGURL.$new_name."',CheckOutLoc='$addr',latit_out='$latit',longi_out='$longi', TimeOut='$time', LastModifiedDate='$stamp' ,overtime =(SELECT subtime(subtime('$time',timein),
				(select subtime(timeout,timein) from ShiftMaster where id=$shiftId)) as overTime )
				WHERE id=$aid and `EmployeeId`=$userid  ORDER BY `AttendanceDate` DESC LIMIT 1";
				//and date(AttendanceDate) = DATE_SUB('$date', INTERVAL 1 DAY)
				//----------push check code
				try{
					$push="push/"; 
					if (!file_exists($push))
						mkdir($push, 0777, true);
					$filename =  $push .$orgid . ".log";
					$fp = fopen($filename, "a+");
					fclose($fp);
				}catch(Exception $e){
					echo $e->getMessage();
				}
				//----------push check code
		}		//LastModifiedDate
		else if($aid==0)
{
			///-------- code for prevent duplicacy in a same day   code-001
			$sql="select * from  AttendanceMaster where EmployeeId=$userid and AttendanceDate= '$today'";
			
			try{ $result1 = $this->db->query($sql);
				if ($this->db->affected_rows()<1) {              ///////code-001 (ends)
					$area=getAreaId($userid);
					$sql = "INSERT INTO `AttendanceMaster`(`EmployeeId`, `AttendanceDate`, `AttendanceStatus`, `TimeIn`,`ShiftId`,areaId, `OrganizationId`,
	  `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `OwnerId`, `Overtime`, `EntryImage`, `checkInLoc`,`device`,latit_in,longi_in)
	  VALUES ($userid,'$date',1,'$time',$shiftId,$area,$orgid,'$date',$userid,'$stamp',$userid,$userid,'00:00:00','".IMGURL.$new_name."','$addr','mobile','$latit','$longi')";	
				}else
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
				//----------push check code
				try{
					$push="push/"; 
					if (!file_exists($push))
						mkdir($push, 0777, true);
					$filename =  $push .$orgid . ".log";
					$fp = fopen($filename, "a+");
					fclose($fp);
				}catch(Exception $e){
					echo $e->getMessage();
				}
				//----------push check code
				
				
				$resCode=0;
				$status =1; // update successfully
				$successMsg = "Image uploaded successfully.";
//////////////////----------------mail send if attndnce is marked very first time in org ever
				$sql="SELECT  `Email`  FROM `Organization` WHERE `Id`=".$orgid;
				$to='';
				$query1 = $this->db->query($sql);
				if($row=$query1->result()){
					$to=$row[0]->Email;
				}/*
				$sql='select * from  AttendanceMaster where OrganizationId='.$orgid.' limit 5';
				$query1 = $this->db->query($sql);
				if($this->db->affected_rows()==1){
			//		sendEmail_new('vijay@ubitechsolutions.com',"UbiAttendance - Attendance marked first time",'Thanks for choosing ubiattendance mailed to:'.$to." simple mail");
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
					sendEmail_new($adminMail,$subject,$message,$headers);
					 
				}*/
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
								}else {
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
		$query = $this->db->query("SELECT `AttendanceDate` , `TimeIn`, `TimeOut`,TIMEDIFF(TIMEDIFF(TimeOut,TimeIn),(SELECT SEC_TO_TIME(sum(time_to_sec( TIMEDIFF(TimeTo,TimeFrom))) )as time from  Timeoff where Timeoff.EmployeeId = ? and TimeofDate=AttendanceDate))as activeHours,TIMEDIFF(TimeOut,TimeIn) as thours,(SELECT SEC_TO_TIME(sum(time_to_sec( TIMEDIFF(TimeTo,TimeFrom))) )as time from  Timeoff where Timeoff.EmployeeId = ? and TimeofDate=AttendanceDate and Timeoff.ApprovalSts=2) as bhour,EntryImage,checkInLoc,ExitImage,CheckOutLoc  FROM `AttendanceMaster` WHERE AttendanceMaster.EmployeeId=? and AttendanceMaster.AttendanceStatus=1 and date(attendanceDate) between date('".$dateEnd."') AND date('".$dateStart."') order by DATE(AttendanceDate) desc  ",array($userid,$userid,$userid));//and TimeOut!= '00:00:00' //limit 7  
		$data=$query->result();
		//$query = $this->db->query("SELECT SEC_TO_TIME(sum(time_to_sec( TIMEDIFF(BreakOff,BreakOn))) )as time from  BreakMaster where EmployeeId = ? and date=?",array($userid,$row1->AttendanceDate));
	//	$data['timespent']=$query->result();
		echo json_encode($data); 
	}
	
	public function getSlider(){
		$orgid=isset($_REQUEST['orgid'])?$_REQUEST['orgid']:0;
		if($orgid==0){
			
			$query = $this->db->query("SELECT  `link`, `file`  FROM `slider_settings` WHERE  `archive`=1");
			echo json_encode($query->result()); 
			return;
		}
		else{
			$query = $this->db->query("SELECT status FROM `licence_ubiattendance` WHERE OrganizationId=?",array($orgid));
			if($row= $query->row()){
				$cond=' WHERE 0=1';;
				if($row->status==1) // paid users
					$cond=' WHERE archive in (1,2)';
				else if($row->status==0) // trial users
					$cond=' WHERE archive in (1,3)';
				$query = $this->db->query("SELECT  `link`, `file`  FROM `slider_settings`".$cond);
				echo json_encode($query->result()); 
				return;
			}
		}
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
			$query = $this->db->query("SELECT count(`Id`) as total FROM `EmployeeMaster`  WHERE `OrganizationId`=".$orgid." and archive=1 ");
			//and CAST('$time' as time) > (select TimeIn from ShiftMaster where ShiftMaster.Id=shift)
			$data['total']=$query->result();
			$query = $this->db->query("SELECT count(`EmployeeId`) as exited FROM AttendanceMaster  WHERE `AttendanceDate`  ='".$date."' and `TimeOut` !='00:00:00' and `OrganizationId`=".$orgid);
			$data['exited']=$query->result();
			$query = $this->db->query("SELECT count(`EmployeeId`) as timedin FROM AttendanceMaster  WHERE `AttendanceDate`  ='".$date."'  and `OrganizationId`=".$orgid);//and `TimeOut` ='00:00:00'
			$data['timedin']=$query->result(); 
			$query = $this->db->query("SELECT count(TimeFrom) as onbreak FROM `Timeoff` where TimeofDate=? and (TimeTo ='00:00:00' or TimeTo IS NULL)  and OrganizationId=?",array($date,$orgid));
			$data['onbreak']=$query->result();
			$query=$this->db->query("select count(Id) as latecomers from AttendanceMaster where `AttendanceDate`  ='".$date."' and `OrganizationId`=".$orgid." and time(TimeIn) > (select time(TimeIn) from ShiftMaster where ShiftMaster.Id=shiftId)");
			$data['latecomers']=$query->result();
			$query=$this->db->query("select count(Id) as earlyleavers from AttendanceMaster where `AttendanceDate`  ='".$date."' and `OrganizationId`=".$orgid." and TimeOut !='00:00:00' and time(TimeOut) < (select time(TimeOut) from ShiftMaster where ShiftMaster.Id=shiftId)");
			$data['earlyleavers']=$query->result();
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`, `TimeOut` ,'Present' as status,EntryImage,ExitImage,SUBSTR(checkInLoc, 1, 12) as checkInLoc, SUBSTR(CheckOutLoc, 1, 12) as CheckOutLoc,latit_in,longi_in,longi_out,latit_out FROM `AttendanceMaster` WHERE `AttendanceDate`=? and  OrganizationId=? and AttendanceStatus=1 order by `name`",array($date,$orgid));
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
		}else if($att=='today_late'){
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`, `TimeOut` ,'Present' as status,EntryImage,ExitImage,SUBSTR(checkInLoc, 1, 12) as checkInLoc, SUBSTR(CheckOutLoc, 1, 12) as CheckOutLoc,latit_in,longi_in,longi_out,latit_out FROM `AttendanceMaster` WHERE (time(TimeIn) > (select time(TimeIn) from ShiftMaster where ShiftMaster.Id=shiftId)) and `AttendanceDate`=? and  OrganizationId=? and AttendanceStatus=1 order by `name`",array($date,$orgid));
			$data['elist']=$query->result();	
		}else if($att=='today_early'){
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`, `TimeOut` ,'Present' as status,EntryImage,ExitImage, SUBSTR(checkInLoc, 1, 12) as checkInLoc, SUBSTR(CheckOutLoc, 1, 12) as CheckOutLoc,latit_in,longi_in,longi_out,latit_out FROM `AttendanceMaster` WHERE (time(TimeOut) < (select time(TimeOut) from ShiftMaster where ShiftMaster.Id=shiftId) and TimeOut!='00:00:00' ) and `AttendanceDate`=? and  OrganizationId=? and AttendanceStatus=1 order by `name`",array($date,$orgid));
			$data['elist']=$query->result();	
		}else if($att=='today_abs'){
			
			 
   $q2="select (select count(EmployeeMaster.Id)-count(AttendanceMaster.Id) from EmployeeMaster where OrganizationId =".$orgid.") as total, AttendanceDate from AttendanceMaster where AttendanceDate ='$date' and OrganizationId =".$orgid." group by AttendanceDate";
	 $query = $this->db->query($q2);
		$d=array();
		$res=array();
			foreach($query->result() as $row){
				 '<br/>total: '.$row->total.'  date: '.$row->AttendanceDate .'<br/>';
					$query1 = $this->db->query("SELECT Id as EmployeeId ,FirstName,Shift,Department,Designation, Id ,'".$row->AttendanceDate ."' as absentdate
							FROM `EmployeeMaster` 
							WHERE EmployeeMaster.OrganizationId =".$orgid."
							 AND archive=1 and IF(EmployeeMaster.CreatedDate!='0000-00-00 00:00:00', CreatedDate < '".$row->AttendanceDate ."', 1) and  Id 
							NOT IN (
							SELECT `EmployeeId` 
							FROM `AttendanceMaster` 
							WHERE `AttendanceDate` 
							IN (
							 '".$row->AttendanceDate ."'
							)
							AND AttendanceMaster.OrganizationId =".$orgid."
							AND `AttendanceStatus` not in(3,5,6)
							)
							ORDER BY EmployeeMaster.Id ");
							$count=$query1->num_rows();
				 foreach ($query1->result() as $row)
				{
					$data=array();
				    //$data['name']=ucwords(getEmpName($row->Id));
					$data['name']=getEmpName($row->EmployeeId);
				    $data['status']='Absent';
				    $data['TimeIn']='-';
				    $data['TimeOut']='-';
					$res[]=$data;
				}
			}
			 $this->db->close();
			$data['elist']=$res;
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
		}else if($att=='yes_late'){
			$date=date('Y-m-d',strtotime("-1 days"));
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`, `TimeOut` ,'Present' as status,EntryImage,ExitImage FROM `AttendanceMaster` WHERE (time(TimeIn) > (select time(TimeIn) from ShiftMaster where ShiftMaster.Id=shiftId)) and `AttendanceDate`=? and  OrganizationId=? and AttendanceStatus=1 order by `name`",array($date,$orgid));
			$data['elist']=$query->result();	
		}else if($att=='yes_early'){
			$date=date('Y-m-d',strtotime("-1 days"));
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`, `TimeOut` ,'Present' as status,EntryImage,ExitImage FROM `AttendanceMaster` WHERE (time(TimeOut) < (select time(TimeOut) from ShiftMaster where ShiftMaster.Id=shiftId) and TimeOut!='00:00:00' ) and `AttendanceDate`=? and  OrganizationId=? and AttendanceStatus=1 order by `name`",array($date,$orgid));
			$data['elist']=$query->result();	
		}else if($att=='yes_abs'){
			$date=date('Y-m-d',strtotime("-1 days"));
			$q2="select (select count(EmployeeMaster.Id)-count(AttendanceMaster.Id) from EmployeeMaster where OrganizationId =".$orgid.") as total, AttendanceDate from AttendanceMaster where AttendanceDate ='$date' and OrganizationId =".$orgid." group by AttendanceDate";
			$query = $this->db->query($q2);
			$d=array();
			$res=array();
			foreach($query->result() as $row){
				 '<br/>total: '.$row->total.'  date: '.$row->AttendanceDate .'<br/>';
					$query1 = $this->db->query("SELECT Id as EmployeeId ,FirstName,Shift,Department,Designation, Id ,'".$row->AttendanceDate ."' as absentdate
							FROM `EmployeeMaster` 
							WHERE EmployeeMaster.OrganizationId =".$orgid."
							 AND archive=1 and IF(EmployeeMaster.CreatedDate!='0000-00-00 00:00:00', CreatedDate < '".$row->AttendanceDate ."', 1) and  Id 
							NOT IN (
							SELECT `EmployeeId` 
							FROM `AttendanceMaster` 
							WHERE `AttendanceDate` 
							IN (
							 '".$row->AttendanceDate ."'
							)
							AND AttendanceMaster.OrganizationId =".$orgid."
							AND `AttendanceStatus` not in(3,5,6)
							)
							ORDER BY EmployeeMaster.Id ");
							$count=$query1->num_rows();
				 foreach ($query1->result() as $row)
				{
					$data=array();
				    //$data['name']=ucwords(getEmpName($row->Id));
					$data['name']=getEmpName($row->EmployeeId);
				    $data['status']='Absent';
				    $data['TimeIn']='-';
				    $data['TimeOut']='-';
					$res[]=$data;
				}
			}
			 $this->db->close();
			$data['elist']=$res;
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
		}else if($att=='cd_late'){
			$date=isset($_REQUEST['cdate'])?date('Y-m-d',strtotime($_REQUEST['cdate'])):0;
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`, `TimeOut` ,'Present' as status,EntryImage,ExitImage FROM `AttendanceMaster` WHERE (time(TimeIn) > (select time(TimeIn) from ShiftMaster where ShiftMaster.Id=shiftId)) and `AttendanceDate`=? and  OrganizationId=? and AttendanceStatus=1 order by `name`",array($date,$orgid));
			$data['elist']=$query->result();	
		}else if($att=='cd_early'){
			$date=isset($_REQUEST['cdate'])?date('Y-m-d',strtotime($_REQUEST['cdate'])):0;
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`, `TimeOut` ,'Present' as status,EntryImage,ExitImage FROM `AttendanceMaster` WHERE (time(TimeOut) < (select time(TimeOut) from ShiftMaster where ShiftMaster.Id=shiftId) and TimeOut!='00:00:00' ) and `AttendanceDate`=? and  OrganizationId=? and AttendanceStatus=1 order by `name`",array($date,$orgid));
			$data['elist']=$query->result();	
		}else if($att=='cd_abs'){
			$date=isset($_REQUEST['cdate'])?date('Y-m-d',strtotime($_REQUEST['cdate'])):0;
			$q2="select (select count(EmployeeMaster.Id)-count(AttendanceMaster.Id) from EmployeeMaster where OrganizationId =".$orgid.") as total, AttendanceDate from AttendanceMaster where AttendanceDate ='$date' and OrganizationId =".$orgid." group by AttendanceDate";
			$query = $this->db->query($q2);
			$d=array();
			$res=array();
			foreach($query->result() as $row){
				 '<br/>total: '.$row->total.'  date: '.$row->AttendanceDate .'<br/>';
					$query1 = $this->db->query("SELECT Id as EmployeeId ,FirstName,Shift,Department,Designation, Id ,'".$row->AttendanceDate ."' as absentdate
							FROM `EmployeeMaster` 
							WHERE EmployeeMaster.OrganizationId =".$orgid."
							 AND archive=1 and IF(EmployeeMaster.CreatedDate!='0000-00-00 00:00:00', CreatedDate < '".$row->AttendanceDate ."', 1) and  Id 
							NOT IN (
							SELECT `EmployeeId` 
							FROM `AttendanceMaster` 
							WHERE `AttendanceDate` 
							IN (
							 '".$row->AttendanceDate ."'
							)
							AND AttendanceMaster.OrganizationId =".$orgid."
							AND `AttendanceStatus` not in(3,5,6)
							)
							ORDER BY EmployeeMaster.Id ");
							$count=$query1->num_rows();
				 foreach ($query1->result() as $row)
				{
					$data=array();
				    //$data['name']=ucwords(getEmpName($row->Id));
					$data['name']=getEmpName($row->EmployeeId);
				    $data['status']='Absent';
				    $data['TimeIn']='-';
				    $data['TimeOut']='-';
					$res[]=$data;
				}
			}
			 $this->db->close();
			$data['elist']=$res;
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
			$query = $this->db->query("SELECT count(`EmployeeId`) as total,AttendanceDate FROM AttendanceMaster WHERE `AttendanceDate`  ='".$dt."' and AttendanceStatus<>1 and `OrganizationId`=".$orgid);
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
		}else if($att=='l7_late'){
			$end_week = date("Y-m-d",strtotime("-1 days"));
			$start_week = date("Y-m-d", strtotime('-6 day', strtotime($end_week)));	
			$start_week = \DateTime::createFromFormat('Y-m-d', $start_week);
			$end_week = \DateTime::createFromFormat('Y-m-d', $end_week);
			$datePeriod= new \DatePeriod( $start_week, new \DateInterval('P1D'),$end_week->modify('+1day') );
			$res=array();
			foreach($datePeriod as $date){
				$data1=array();
			$dt= $date->format('Y-m-d');
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`, `TimeOut` ,AttendanceDate ,'Present' as status,EntryImage,ExitImage FROM `AttendanceMaster` WHERE (time(TimeIn) > (select time(TimeIn) from ShiftMaster where ShiftMaster.Id=shiftId)) and `AttendanceDate`  ='".$dt."' and `OrganizationId`=".$orgid." and AttendanceStatus=1 order by DATE(AttendanceDate) desc,name");
			$res[]=$query->result();
			}
			$data['elist']=$res;
			
		}else if($att=='l7_early'){
			$end_week = date("Y-m-d",strtotime("-1 days"));
			$start_week = date("Y-m-d", strtotime('-6 day', strtotime($end_week)));	
			$start_week = \DateTime::createFromFormat('Y-m-d', $start_week);
			$end_week = \DateTime::createFromFormat('Y-m-d', $end_week);
			$datePeriod= new \DatePeriod( $start_week, new \DateInterval('P1D'),$end_week->modify('+1day') );
			$res=array();
			foreach($datePeriod as $date){
				$data1=array();
			$dt= $date->format('Y-m-d');
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`, `TimeOut` ,AttendanceDate ,'Present' as status,EntryImage,ExitImage FROM `AttendanceMaster` WHERE (time(TimeOut) < (select time(TimeOut) from ShiftMaster where ShiftMaster.Id=shiftId) and TimeOut!='00:00:00' ) and `AttendanceDate`  ='".$dt."' and `OrganizationId`=".$orgid." and AttendanceStatus=1 order by DATE(AttendanceDate) desc,name");
			$res[]=$query->result();
			}
			$data['elist']=$res;
		}else if($att=='l7_abs'){
			$end_week = date("Y-m-d",strtotime("-1 days"));
			$start_week = date("Y-m-d", strtotime('-6 day', strtotime($end_week)));	
			$start_week = \DateTime::createFromFormat('Y-m-d', $start_week);
			$end_week = \DateTime::createFromFormat('Y-m-d', $end_week);
			$datePeriod= new \DatePeriod( $start_week, new \DateInterval('P1D'),$end_week->modify('+1day') );
			
			$res=array();
			foreach($datePeriod as $date){
				$data1=array();
			$dt= $date->format('Y-m-d');
			$q2="select (select count(EmployeeMaster.Id)-count(AttendanceMaster.Id) from EmployeeMaster where OrganizationId =".$orgid.") as total, AttendanceDate from AttendanceMaster where AttendanceDate ='$dt' and OrganizationId =".$orgid." group by AttendanceDate";
			$query = $this->db->query($q2);
			$d=array();
			//$res=array();
			foreach($query->result() as $row){
				$date=$row->AttendanceDate;
				// '<br/>total: '.$row->total.'  date: '.$row->AttendanceDate .'<br/>';
					$query1 = $this->db->query("SELECT Id as EmployeeId ,FirstName,Shift,Department,Designation, Id ,'".$row->AttendanceDate ."' as absentdate
							FROM `EmployeeMaster` 
							WHERE EmployeeMaster.OrganizationId =".$orgid."
							 AND archive=1 and IF(EmployeeMaster.CreatedDate!='0000-00-00 00:00:00', CreatedDate < '".$row->AttendanceDate ."', 1) and  Id 
							NOT IN (
							SELECT `EmployeeId` 
							FROM `AttendanceMaster` 
							WHERE `AttendanceDate` 
							IN (
							 '".$row->AttendanceDate ."'
							)
							AND AttendanceMaster.OrganizationId =".$orgid."
							AND `AttendanceStatus` not in(3,5,6)
							)
							ORDER BY EmployeeMaster.Id ");
							$count=$query1->num_rows();
				 foreach ($query1->result() as $row)
				{
					$data=array();
				    //$data['name']=ucwords(getEmpName($row->Id));
					$data['name']=getEmpName($row->EmployeeId);
				    $data['AttendanceDate']=$date;
				    $data['status']='Absent';
				    $data['TimeIn']='-';
				    $data['TimeOut']='-';
					$res[]=$data;
				}
			}
			//$res1[]=$query->result();
			}
			 $this->db->close();
			$data['elist']=$res;
		}else if($att=='thismonth'){ //current month attendance
			$month=date('m');
			$year=date('Y');
			$query = $this->db->query("SELECT count(`Id`) as total FROM `EmployeeMaster`  WHERE `OrganizationId`=".$orgid);
			$data['total']=$query->result();
			$query = $this->db->query("SELECT count(`EmployeeId`) as marked FROM AttendanceMaster  WHERE EXTRACT(MONTH from AttendanceDate)  ='".$month."' and EXTRACT(YEAR from AttendanceDate)  ='".$year."' and  `OrganizationId`=".$orgid);
			$data['marked']=$query->result();
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`, `TimeOut`,'Present' as status ,AttendanceDate FROM `AttendanceMaster` WHERE EXTRACT(MONTH from AttendanceDate) =?  and  EXTRACT(YEAR from AttendanceDate)  =? and OrganizationId=? and AttendanceStatus=1 order by DATE(AttendanceDate),name",array($month,$year,$orgid));
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
		}else if($att=='tm_late'){
			$start_week =date('Y-m-01');
			$end_week = date('Y-m-d');
			$start_week = \DateTime::createFromFormat('Y-m-d', $start_week);
			$end_week = \DateTime::createFromFormat('Y-m-d', $end_week);
			$datePeriod= new \DatePeriod( $start_week, new \DateInterval('P1D'),$end_week->modify('+1day') );
			$res=array();
			foreach($datePeriod as $date){
				$data1=array();
			$dt= $date->format('Y-m-d');
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`, `TimeOut` ,AttendanceDate ,'Present' as status,EntryImage,ExitImage FROM `AttendanceMaster` WHERE (time(TimeIn) > (select time(TimeIn) from ShiftMaster where ShiftMaster.Id=shiftId)) and `AttendanceDate`  ='".$dt."' and `OrganizationId`=".$orgid." and AttendanceStatus=1 order by DATE(AttendanceDate) desc,name");
			$res[]=$query->result();
			}
			$data['elist']=$res;
			
		}else if($att=='tm_early'){
			$start_week =date('Y-m-01');
			$end_week = date('Y-m-d');
			$start_week = \DateTime::createFromFormat('Y-m-d', $start_week);
			$end_week = \DateTime::createFromFormat('Y-m-d', $end_week);
			$datePeriod= new \DatePeriod( $start_week, new \DateInterval('P1D'),$end_week->modify('+1day') );
			$res=array();
			foreach($datePeriod as $date){
				$data1=array();
			$dt= $date->format('Y-m-d');
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`, `TimeOut` ,AttendanceDate ,'Present' as status,EntryImage,ExitImage FROM `AttendanceMaster` WHERE (time(TimeOut) < (select time(TimeOut) from ShiftMaster where ShiftMaster.Id=shiftId) and TimeOut!='00:00:00' ) and `AttendanceDate`  ='".$dt."' and `OrganizationId`=".$orgid." and AttendanceStatus=1 order by DATE(AttendanceDate) desc,name");
			$res[]=$query->result();
			}
			$data['elist']=$res;
		}else if($att=='tm_abs'){
			$start_week =date('Y-m-01');
			$end_week = date('Y-m-d');
			$start_week = \DateTime::createFromFormat('Y-m-d', $start_week);
			$end_week = \DateTime::createFromFormat('Y-m-d', $end_week);
			$datePeriod= new \DatePeriod( $start_week, new \DateInterval('P1D'),$end_week->modify('+1day') );
			$res=array();
			foreach($datePeriod as $date){
				$data1=array();
			$dt= $date->format('Y-m-d');
			$q2="select (select count(EmployeeMaster.Id)-count(AttendanceMaster.Id) from EmployeeMaster where OrganizationId =".$orgid.") as total, AttendanceDate from AttendanceMaster where AttendanceDate ='$dt' and OrganizationId =".$orgid." group by AttendanceDate";
			$query = $this->db->query($q2);
			$d=array();
			//$res=array();
			foreach($query->result() as $row){
				$date=$row->AttendanceDate;
				// '<br/>total: '.$row->total.'  date: '.$row->AttendanceDate .'<br/>';
					$query1 = $this->db->query("SELECT Id as EmployeeId ,FirstName,Shift,Department,Designation, Id ,'".$row->AttendanceDate ."' as absentdate
							FROM `EmployeeMaster` 
							WHERE EmployeeMaster.OrganizationId =".$orgid."
							 AND archive=1 and IF(EmployeeMaster.CreatedDate!='0000-00-00 00:00:00', CreatedDate < '".$row->AttendanceDate ."', 1) and  Id 
							NOT IN (
							SELECT `EmployeeId` 
							FROM `AttendanceMaster` 
							WHERE `AttendanceDate` 
							IN (
							 '".$row->AttendanceDate ."'
							)
							AND AttendanceMaster.OrganizationId =".$orgid."
							AND `AttendanceStatus` not in(3,5,6)
							)
							ORDER BY EmployeeMaster.Id ");
							$count=$query1->num_rows();
				 foreach ($query1->result() as $row)
				{
					$data=array();
				    //$data['name']=ucwords(getEmpName($row->Id));
					$data['name']=getEmpName($row->EmployeeId);
				    $data['AttendanceDate']=$date;
				    $data['status']='Absent';
				    $data['TimeIn']='-';
				    $data['TimeOut']='-';
					$res[]=$data;
				}
			}
			//$res1[]=$query->result();
			}
			 $this->db->close();
			$data['elist']=$res;
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
	public function getPunchInfo(){
		$uid=isset($_REQUEST['uid'])?$_REQUEST['uid']:0;
		$orgid=isset($_REQUEST['refno'])?$_REQUEST['refno']:0;
		$zone=getTimeZone($orgid);
		date_default_timezone_set($zone);	
		$today=date('Y-m-d');
		$query = $this->db->query("SELECT Id FROM `checkin_master` WHERE `EmployeeId`=? and `OrganizationId`=? and `time_out`='00:00:00' and date=? order by id desc limit 1 ",array($uid,$orgid,$today));
		$data=array();
		$data['id']=0;
		if($row= $query->result())
			$data['id']=$row[0]->Id;
		echo json_encode($data);
	}
	public function getPunchedLocations(){  	 
		$userid=isset($_REQUEST['uid'])?$_REQUEST['uid']:0;
		$date=isset($_REQUEST['cdate'])?$_REQUEST['cdate']:0;
		
		$query = $this->db->query("SELECT  `location`,location_out ,`time`,`time_out`, `client_name`, `description` FROM `checkin_master` WHERE EmployeeId=? and date=? order by id desc",array($userid,$date));
		echo json_encode($query->result()); 
	}
	
	public function getTodaysPunchLocs(){  	 
		$orgid=isset($_REQUEST['refno'])?$_REQUEST['refno']:0;
		$zone=getTimeZone($orgid);
		date_default_timezone_set($zone);
		$date=date('Y-m-d');
		$query = $this->db->query("SELECT `EmployeeId`,(select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name ,SUBSTR(location, 1, 20) as location,`time`,SUBSTR(client_name, 1, 20) as client_name, `description`, `latit`, `longi` FROM `checkin_master` WHERE OrganizationId=? and date=? order by name asc, id desc",array($orgid,$date));
		echo json_encode($query->result()); 
	}
	
	public function timeBreak(){
		$uid=isset($_REQUEST['uid'])?$_REQUEST['uid']:0;
		$orgid=isset($_REQUEST['refno'])?$_REQUEST['refno']:0;
		$id=isset($_REQUEST['id'])?$_REQUEST['id']:0;
		$zone=getTimeZone($orgid);
		date_default_timezone_set($zone);	
		$today=date('Y-m-d');
		$time=date("H:i:s");;
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
				$query = $this->db->query("INSERT INTO `Timeoff`(`EmployeeId`, `TimeofDate`, `TimeFrom`, `OrganizationId`,ApprovalSts,CreatedDate) VALUES (?,?,?,?,?,?)",array($uid,$today,$time,$orgid,2,$today));
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
//sendEmail_new("bitsvijay@gmail.com","pwd testing","testing mail");
		$una=isset($_REQUEST['una'])?$_REQUEST['una']:'';
		//$orgid=isset($_REQUEST['refno'])?$_REQUEST['refno']:0;
		//$orgid=sqrt($`-99);
		$una=encode5t($una);
		$query = $this->db->query("SELECT Id,OrganizationId,`FirstName`,(SELECT  `resetPassCounter` FROM `UserMaster` WHERE `Username`=? or username_mobile=?)as ctr, (SELECT  `Username` FROM `UserMaster` WHERE `Username`=? or username_mobile=?)as email FROM `EmployeeMaster` WHERE `Id`=(SELECT  `EmployeeId` FROM `UserMaster` WHERE `Username`=? or username_mobile=?)",array($una,$una,$una,$una,$una,$una));
		if($query->num_rows()>0){
			if($row=$query->result()){	
//	 $url='https://ubiattendance.ubihrm.com/index.php/services/HastaLaVistaUbi?hasta='.encrypt($row[0]->Id).'&vista='.encrypt($orgid);
			$orgid = $row[0]->OrganizationId;
			$email=($row[0]->email=='')?'':decode5t($row[0]->email);
			 $url='https://ubiattendance.ubihrm.com/index.php/services/HastaLaVistaUbi?hasta='.encrypt($row[0]->Id).'&vista='.encrypt($orgid).'&ctrpvt='.encrypt($row[0]->ctr);
			$msg=" Dear ".$row[0]->FirstName." <br/>
				You have requested for reset your ubiAttendance login password, please click on the following link to reset your password ".$url." <br/><br/>
				Thanks<br/>
				UBITECH TEAM
				" ;
				//sendEmail_new($email,"UbiAttendance reset Password",$msg);
				$headers = 'From: <noreply@ubiattendance.com>' . "\r\n";
				sendEmail_new($email,"UbiAttendance reset Password",$msg,$headers);
				
				echo 1; // valid id and ref
			}else
				echo 0;  
		}else
				echo 2;
	}

public function setPassword(){
		$uid=isset($_REQUEST['hasta'])?decrypt($_REQUEST['hasta']):0;
		$orgid=isset($_REQUEST['vista'])?decrypt($_REQUEST['vista']):0;
		$np=isset($_REQUEST['np'])?encode5t($_REQUEST['np']):'';
		//$np=isset($_REQUEST['np'])?($_REQUEST['np']):'';
		$res=0;
	//	echo "UPDATE UserMaster SET Password='".$np."' WHERE EmployeeId=".$uid." and OrganizationId=".$orgid;
	//	return false;
		 $query = $this->db->query("UPDATE `UserMaster` SET`Password`=?,resetPassCounter=resetPassCounter+1 WHERE EmployeeId=? and OrganizationId=?",array($np,$uid,$orgid));
		$res=$this->db->affected_rows();
		echo $res;
	}
	public function checkLinkValidity($uid,$orgid,$counter){
	//	echo "SELECT id  FROM `UserMaster` WHERE  EmployeeId='$uid' and OrganizationId=$orgid and resetPassCounter=$counter";
//		die();
			$query = $this->db->query("SELECT id  FROM `UserMaster` WHERE  EmployeeId=? and OrganizationId=? and resetPassCounter=?",array($uid,$orgid,$counter));
			
		return $query->num_rows();
		
	}
	public function getSuperviserSts(){
		$uid=isset($_REQUEST['uid'])?$_REQUEST['uid']:0;
		$orgid=isset($_REQUEST['refid'])?$_REQUEST['refid']:0;
		$query = $this->db->query("SELECT `appSuperviserSts`  FROM `UserMaster` WHERE  EmployeeId=? and OrganizationId=?",array($uid,$orgid));
		echo json_encode($query->result());
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
		/*	if($res>0)
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
					sendEmail_new($adminMail,$subject,$message,$headers);
					 
				}
			}*/
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
		/*	if($res>0)
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
					sendEmail_new($adminMail,$subject,$message,$headers);
					 
				}
			}*/
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
		/*	if($res>0)
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
					sendEmail_new($adminMail,$subject,$message,$headers);
					 
				}
			}*/
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
			$query = $this->db->query("SELECT android_version as version FROM  `PlayStore` WHERE orgid=0 LIMIT 1");
		else
			$query = $this->db->query("SELECT ios_version as version FROM  `PlayStore` WHERE orgid=0 LIMIT 1");
		echo json_encode($query->result());
	}
	
	public function addCheckin()
	{
		$orgid=isset($_REQUEST['orgid'])?$_REQUEST['orgid']:0;
		$cname=isset($_REQUEST['cname'])?$_REQUEST['cname']:'';
		$comment=isset($_REQUEST['comment'])?$_REQUEST['comment']:'';
		$loc=isset($_REQUEST['loc'])?$_REQUEST['loc']:'';
		$latit=isset($_REQUEST['latit'])?$_REQUEST['latit']:'0.0';
		$longi=isset($_REQUEST['longi'])?$_REQUEST['longi']:'0.0';
		$skip=isset($_REQUEST['skip'])?$_REQUEST['skip']:0;
		$uid=isset($_REQUEST['uid'])?$_REQUEST['uid']:0;
		$punch_id=isset($_REQUEST['punch_id'])?$_REQUEST['punch_id']:0;
		$zone=getTimeZone($orgid);
		date_default_timezone_set($zone);
		$date=date('Y-m-d');
		$time=date('H:i:00');
		if($punch_id==0)
			echo $query = $this->db->query("INSERT INTO `checkin_master`(`EmployeeId`, `location`, `latit`, `longi`, `time`, `date`, `client_name`, `description`, `OrganizationId`) VALUES (?,?,?,?,?,?,?,?,?)",array($uid,$loc,$latit,$longi,$time,$date,$cname,$comment,$orgid));
		else if($punch_id!=0 && $skip==1) // skip case
			echo $query = $this->db->query("UPDATE `checkin_master`set `location_out`=location, `latit_out`=latit, `longi_out`=longi, `time_out`=time where id=?",array($punch_id));
		else
			echo $query = $this->db->query("UPDATE `checkin_master`set `location_out`=?, `latit_out`=?, `longi_out`=?, `time_out`=? where id=?",array($loc,$latit,$longi,$time,$punch_id));
	}
	
	
	public function mailtest(){
		echo getAreaId(4147);
		return false;
		echo decrypt('q+fX19fNg7zez84=');
		echo "</br/>".decrypt('q+fX19fNg7zez86U');
		return false;
			$tmrw=date('Y-m-d',strtotime(' +1 day'));
			$startdate = date('Y-m-d', strtotime(' -2 day'));
			$enddate = date('Y-m-d', strtotime(' +2 day'));
			$data = array();
			$query = $this->db->query("SELECT
			LIC.end_date as expiry ,
			AD.name as contectperson ,
			ORG.Id as orgid,
			ORG.Name as orgname ,
			ORG.PhoneNumber as orgno,
			ORG.Email as orgemail,
			ORG.Country as orgcountry,
			(select count(id) from EmployeeMaster as EMP where EMP.OrganizationId=ORG.Id) as orgemp ,
			AD.username as uname,
			AD.password as pass
			FROM  admin_login AD , Organization ORG , licence_ubiattendance LIC WHERE LIC.OrganizationId=ORG.Id AND AD.OrganizationId=ORG.Id AND  LIC.end_date BETWEEN '$startdate' AND '$enddate'  ORDER BY LIC.end_date ");
			foreach ($query->result() as $row)
			{
				$data1=array();
					$data1['expiry']= $row->expiry;
					$data1['contectperson']= $row->contectperson;
					$data1['orgid']= $row->orgid;
					$data1['orgname']= $row->orgname;
					$data1['orgno']= $row->orgno;
					$data1['orgemail']= $row->orgemail;
					$data1['orgcountry']= $row->orgcountry;
					$data1['orgemp']= $row->orgemp;
					$data1['uname']= $row->uname;
					$data1['pass']= decrypt($row->pass);
					$data[]=$data1;
			}
			//print_r($data); return;
		$list='';
		for($i=0;$i< count($data);$i++){
			$list.= '<tr><td>'.($i+1).'.</td><td>'.date('d-m-Y',strtotime($data[$i]['expiry'])).'</td><td>'.(($data[$i]['orgid'])*($data[$i]['orgid']) + 99 ).'</td><td>'.$data[$i]['orgname'].'</td><td>'.$data[$i]['contectperson'].'</td><td>'.$data[$i]['orgno'].'</td><td>'.$data[$i]['orgemail'].'</td><td>'.$data[$i]['orgemp'].'</td><td>'.getCountryById1($data[$i]['orgcountry']).'</td><tr/>';
				
		if($data[$i]['expiry']==$tmrw){
			$to=$data[$i]['orgemail'];
			$subject = $data[$i]['contectperson'].", your Premium Plan expires tomorrow!";
			$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

				<title>ubiAttendance</title>
				<style type="text/css">
				body {
				  margin-left: 0px;
				  margin-top: 0px;
				  margin-right: 0px;
				  margin-bottom: 0px;
				-webkit-text-size-adjust:none; -ms-text-size-adjust:none;
				background: white;
				} 

				table{border-collapse: collapse;}  
				.icon-row{
				  border-bottom: 2px solid #00aad4;

				}

				.icons{
				  padding: 50px;
				}
				.icons img{
				  width:100px;
				  height: auto;
				}

				</style></head>

				<body>
				<table  width="650" align="center" style="background-color: white;">
				  <tr>
					<td><img src="https://ubiattendance.ubihrm.com/mailers/banner.png"></td>
				</tr>
				<tr>
				  <td align="left">
					<p style="font-family: Arial;font-size: 18px;padding: 10px;">
					  Hello '.$data[$i]['contectperson'].',<br><br>

				We hope you are enjoying the free trial of ubiAttendance!<br><br> 

				The Trial period will be over in just less than 24 hours. By now, you are more than likely feeling one of these two ways:<br><br> 

				 

				HAPPY! -    Subscribe to the ubiAttendance Software - <a target="_blank" href="https://ubiattendance.ubihrm.com/">Login to My Plan</a><br><br>

				NEED MORE TIME?  -   <a  style="color: black;" href="mailto:support@ubitechsolutions.com?subject=Extend%20My%20Free%20Trial">Extend your trial further by writing back to us</a><br><br>

				 

				Looking forward to make <b>ubiAttendance</b> work for you!<br><br>

				Regards,<br>

				Team ubiAttendance 
					  
					</p>
					
				  </td>
				</tr>
				<tr>
				  <td align="center">
					<p style="text-align: center;font-size: 16px;font-family: Arial">You can <a style="color: black;" href="mailto:unsubscribe@ubitechsolutions.com?subject=Unsubscribe&body=Hello%0A%0APlease%20unsubscribe%20me%20from%20the%20mailing%20list%0A%0AThanks">unsubscribe</a> from this email or change your email 
				<br>notifications</p>
				  </td>
				</tr>
				  </table>
				  <table  width="650" align="center"> 
					<tr>
					  <td>
						<p style="text-align: center; font-size: 12px; font-family:Arial">
						  This email was sent by <a style="" href="mailto:ubiattendance@ubitechsolutions.com">ubiattendance@ubitechsolutions.com</a> to '.$data[$i]['orgemail'].'
				Not interested? <a style="color: black;" href="mailto:unsubscribe@ubitechsolutions.com?subject=Unsubscribe&body=Hello%0A%0APlease%20unsubscribe%20me%20from%20the%20mailing%20list%0A%0AThanks">Unsubscribe</a><br>
				<p style="color: grey;text-align: center;font-size: 12px;">Ubitech Solutions Private Limited | S-553, Greater Kailash Part II, New Delhi, 110048</p>

						</p>
					  </td>
					</tr>
				  </table>

				</body>
				</html>';

			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			// More headers
			$headers .= 'From: <support@ubitechsolutions.com>' . "\r\n";
			//$headers .= 'Cc: vijay@ubitechsolutions.com' . "\r\n";
	//		sendEmail_new($to,$subject,$message,$headers);
			sendEmail_new('parth@ubitechsolutions.com',"Mail Via SMTP",$message,$headers);
			echo 'Mail done';
		//	sendEmail_new('parth@ubitechsolutions.com',$subject,$message,$headers);
			break;
		} //if ends here
	} // loop ends here
	
	
	return false;/*
		$to = "parth@ubitechsolutions.com";
		$subject = "Expiry mailer";
		$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>ubiAttendance</title>
<style type="text/css">
body {
  margin-left: 0px;
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 0px;
-webkit-text-size-adjust:none; -ms-text-size-adjust:none;
background: white;
} 

table{border-collapse: collapse;}  
.icon-row{
  border-bottom: 2px solid #00aad4;

}

.icons{
  padding: 50px;
}
.icons img{
  width:100px;
  height: auto;
}

</style></head>

<body>
<table  width="650" align="center" style="border: 3px solid #e3e6e7;">
  <tr>
    <td><img src="https://ubiattendance.ubihrm.com/mailers/banner.png"></td>
</tr>
<tr>
  <td align="left">
    <p style="font-family: Arial;font-size: 20px;padding: 10px;">
      Hello [Customer Name]*,<br><br>

We hope you are enjoying the free trial of ubiAttendance!<br><br> 

The Trial period will be over in just less than 24 hours. By now, you are more than likely feeling one of these two ways:<br><br> 

 

HAPPY!     Subscribe to the ubiAttendance Software - <a target="_blank" href="https://ubiattendance.ubihrm.com/">Login to My Plan</a><br><br>

ID - [registered email id]*<br><br>

Password - [password]*<br><br>

 

NEED MORE TIME?     <a  style="color: black;" href="mailto:support@ubitechsolutions.com?subject=Extend%20My%20Free%20Trial">Extend your trial further by writing back to me</a><br><br>

 

Looking forward to make <b>ubiAttendance</b> work for you!<br><br>

Regards,<br><br>

Team ubiAttendance 
      
    </p>
    
  </td>
</tr>
  </table>

</body>
</html>';

		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		// More headers
		$headers .= 'From: <support@ubitechsolutions.com.com>' . "\r\n";
		//$headers .= 'Cc: vijaympct13@gmail.com' . "\r\n";
		sendEmail_new($to,$subject,$message,$headers);*/
	}


}
?>