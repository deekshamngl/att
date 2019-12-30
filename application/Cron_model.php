<?php
class Cron_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
		include(APPPATH."PhpMailer/class.phpmailer.php");
    }
	
	public function getOrgListAboutToExpire__new()
	{
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
			FROM  admin_login AD , Organization ORG , licence_ubiattendance LIC WHERE LIC.OrganizationId=ORG.Id AND AD.OrganizationId=ORG.Id AND  LIC.end_date BETWEEN '$startdate' AND '$enddate' AND ORG.mail_unsubscribe = 0 and LIC.status = '0' ORDER BY LIC.end_date ");
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
			echo json_encode($data);
	}
	
	public function getOrgListAboutToExpire()
	      { //vijay
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
			FROM  admin_login AD , Organization ORG , licence_ubiattendance LIC WHERE LIC.OrganizationId=ORG.Id AND AD.OrganizationId=ORG.Id AND  LIC.end_date BETWEEN '$startdate' AND '$enddate' AND ORG.mail_unsubscribe = 0 and LIC.status = '0' ORDER BY LIC.end_date ");
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
			$subject = $data[$i]['contectperson'].", your Trial Period expires tomorrow!";
			$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
				<title>ubiAttendance</title>
				<style type="text/css">
				body{
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
					  Hello '.$data[$i]['contectperson'].',<br/><br/>

				We hope you are enjoying the free trial of ubiAttendance!<br/><br/> 

				The Trial period will be over in just less than 24 hours. By now, you are more than likely feeling one of these two ways:<br/><br/> 

				 

				HAPPY! -    Subscribe to the ubiAttendance Software - <a target="_blank" href="https://ubiattendance.ubihrm.com/">Login to My Plan</a><br/><br/>
				NEED MORE TIME?  -   <a  style="color: black;" href="mailto:support@ubitechsolutions.com?subject=Extend%20My%20Free%20Trial">Extend your trial further by writing back to us</a><br/><br/>

				Looking forward to make <b>ubiAttendance</b> work for you!<br/><br/>

				Cheers,<br/>

				Team ubiAttendance 
				<br/><a href="www.ubiattendance.com" target="_blank">www.ubiattendance.com</a><br/> Tel/ Whatsapp: +91 70678 22132<br/>Email: ubiattendance@ubitechsolutions.com<br/>Skype: ubitech.solutions<br/>	  
					</p>
					
				  </td>
				</tr>
				
				  </table>
				  <table  width="650" align="center"> 
					<tr>
					  <td>
						<p style="text-align: center; font-size: 12px; font-family:Arial">
						  This email was sent by <a style="" href="mailto:ubiattendance@ubitechsolutions.com">ubiattendance</a> to '.$data[$i]['orgemail'].'
				Not interested? <a href="'.URL.'cron/unsubscribeOrgMails/'.$data[$i]['orgid'].'" target="_top"> Unsubscribe </a><br/>
				<p style="color: grey;text-align: center;font-size: 12px;">Ubitech Solutions Private Limited | S-553, Greater Kailash Part II, New Delhi, 110048</p>

						</p>
					  </td>
					</tr>
				  </table>

				</body>
				</html>';
			/* 	<tr>
				  <td align="center">
					<p style="text-align: center;font-size: 16px;font-family: Arial">You can <a style="color: black;" href="mailto:unsubscribe@ubitechsolutions.com?subject=Unsubscribe&body=Hello%0A%0APlease%20unsubscribe%20me%20from%20the%20mailing%20list%0A%0AThanks">unsubscribe</a> from this email or change your email 
				<br>notifications</p>
				  </td>
				</tr> */
			//<a style="color: black;" href="mailto:unsubscribe@ubitechsolutions.com?subject=Unsubscribe&body=Hello%0A%0APlease%20unsubscribe%20me%20from%20the%20mailing%20list%0A%0AThanks">Unsubscribe</a>;
			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			// More headers
			$headers .= 'From: <support@ubitechsolutions.com>' . "\r\n";
			//$headers .= 'Cc: vijay@ubitechsolutions.com' . "\r\n";
			sendEmail_new($to,$subject,$message,$headers);
			//sendEmail_new('deeksha@ubitechsolutions.com',$subject,$message,$headers);
		//	sendEmail_new('vijay@ubitechsolutions.com',$subject,$message,$headers);
		//	sendEmail_new('parth@ubitechsolutions.com',$subject,$message,$headers);
		} //if ends here
	}/// loop ends here
					$subject = "UbiAttendance - Trial Expiration list";
					$message = "
					<html>
					<head>
					<title>ubiAttendance</title>
					</head>
					<body>
					<h3>Hi Super Admin</h3>
					<h4>
					The list of organization about to expire (or already expired) is below:</h4>
					<table border>
						<tr>
							<th>S.No.</th>
							<th>Expire On</th>
							<th>CRN</th>
							<th>Org Name</th>
							<th>Contact Person</th>
							<th>Contact</th>
							<th>Mail</th>
							<th>No. Of Employees</th>
							<th>Country</th>
						</tr>".$list."
					</table>
					<p>
						Thanks & regards<br/>
						<strong>ubiAttendance Team </strong>
					</p>
					</body>
					</html>
					";
				//	echo $message;
					// Always set content-type when sending HTML email
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					$headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
				//	$headers .= 'Cc: vijay@ubitechsolutions.com' . "\r\n";
					sendEmail_new('vijay@ubitechsolutions.com',$subject,$message,$headers);
					sendEmail_new('parth@ubitechsolutions.com',$subject,$message,$headers);	
					sendEmail_new('deeksha@ubitechsolutions.com',$subject,$message,$headers);
	}
	
	public function getdetailAlertOrg__new()
    {
		$result = array();
		$sql = $this->db->query("SELECT Id FROM `Organization` WHERE Id not in (1074) AND mail_unsubscribe = 0 and Id in (select OrganizationId from licence_ubiattendance where status=1 and end_date >= CURDATE()) ");// 1074 is erawan,
		foreach($sql->result() as $row)
		{
			 $orgid = $row->Id;
			 $zone=getTimeZone($orgid);
			 date_default_timezone_set($zone);
			 $time = date("H:i:00");
			 $stime = date("H:00:00");
			 $etime = date("H:i:00", strtotime('+59 minutes',strtotime($stime)));
			 /* echo $stime.'<br/>';
			 echo $etime.'<br/>'; */
			 $date=date('Y-m-d',strtotime('-1 day'));
			 $sql1 = $this->db->query("SELECT OrganizationId,Time FROM `Alert_Settings` WHERE Status=1 and OrganizationId= $orgid and Time between '$stime' and '$etime' ");
			// $sql1 = $this->db->query("SELECT OrganizationId,Time FROM `Alert_Settings` WHERE Status=1 and OrganizationId= $orgid ");
			foreach($sql1->result() as $row1)
			{
				$list=array();
				$list['orgid']=$row1->OrganizationId;
				$list['admin']=getAdminName($row1->OrganizationId);
				$list['email']=getAdminEmail($row1->OrganizationId);
				
			////////////late comers
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`, `TimeOut` ,'Present' as status,EntryImage,ExitImage FROM `AttendanceMaster` WHERE (time(TimeIn) > (select time(TimeIn) from ShiftMaster where ShiftMaster.Id=shiftId)) and `AttendanceDate`=? and  OrganizationId=? and AttendanceStatus=1 order by `name`",array($date,$orgid));
			$list['late']=$query->result();	
		
			////////////early leaver
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`, `TimeOut` ,'Present' as status,EntryImage,ExitImage FROM `AttendanceMaster` WHERE (time(TimeOut) < (select time(TimeOut) from ShiftMaster where ShiftMaster.Id=shiftId) and TimeOut!='00:00:00' ) and `AttendanceDate`=? and  OrganizationId=? and AttendanceStatus=1 order by `name`",array($date,$orgid));
			$list['early']=$query->result();	
			
			////////////Time off list
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , TimeFrom, TimeTo,Reason, TIMEDIFF(TimeTo, TimeFrom) as Total FROM `Timeoff` WHERE `TimeofDate`=? and  OrganizationId=? and ApprovalSts=2 order by `name`",array($date,$orgid));
			$list['timeoff']=$query->result();
			
			////////////forgot to mark timeout(timeout pending)
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`,EntryImage FROM `AttendanceMaster` WHERE ((TimeIn != '00:00:00' and TimeOut = '00:00:00' ) or (TimeOut = TimeIn and ExitImage = '')) and `AttendanceDate`=? and  OrganizationId=? and AttendanceStatus=1 order by `name`",array($date,$orgid));
			$list['pending']=$query->result();	
			
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , '-' as `TimeIn`,'-' as `TimeOut` ,'Absent' as status FROM `AttendanceMaster` WHERE `AttendanceDate`=? and  OrganizationId=? and AttendanceStatus in (2) order by `name`",array($date,$orgid));
					$list['abs']=$query->result();
					
					//////////////Presentees
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`, `TimeOut` ,'Present' as status,EntryImage,ExitImage FROM AttendanceMaster WHERE AttendanceDate='$date' and  OrganizationId=$orgid and TimeIn !='00:00:00' order by name");
			$list['present']=$query->result();
					
					
					/*Start Geolocations*/
					
					$q2="SELECT A.Id, A.EmployeeId, E.FirstName, E.LastName, A.AttendanceDate as date, A.AttendanceStatus, A.TimeIn, A.TimeOut, A.ShiftId, A.Overtime,A.EntryImage, A.ExitImage,A.latit_in,A.longi_in,A.longi_out,A.latit_out, A.checkInLoc, A.CheckOutLoc,A.areaId, G.Lat_Long, G.Radius FROM AttendanceMaster A, Geo_Settings G, EmployeeMaster E WHERE A.OrganizationId=".$orgid." and G.OrganizationId = ".$orgid." and E.OrganizationId = ".$orgid." and A.AttendanceDate='".$date."' and A.TimeIn!='00:00' and A.areaId!=0 and G.Id=A.areaId and E.Id= A.EmployeeId order by A.AttendanceDate Desc";
					
					$query = $this->db->query($q2);
					$res=array();
					foreach($query->result() as $row){
						$res1=array();
						$res1['Name']=$row->FirstName." ".$row->LastName;	
						$res1['ti']=substr($row->TimeIn,0,5);
						$res1['to']=substr($row->TimeOut,0,5);
						$res1['positionlin']="";
						$res1['positionout']="";
						$res1['latit_in']=$row->latit_in;
						$res1['latit_out']=$row->latit_out;
						$lat_lang = $row->Lat_Long;
						$radius = $row->Radius;
						$arr1 = explode(",",$lat_lang);
						if(count($arr1)>1){
							$a=floatval($arr1[0]);
							$b=floatval($arr1[1]);
							$d1 = $this->distance($a,$b, $row->latit_in, $row->longi_in, "K");
							$d2 = $this->distance($a,$b, $row->latit_out, $row->longi_out, "K");
						if($row->latit_in!='0.0' && $row->latit_in!='0'){
							if($d1 <= $radius){
								$res1['positionlin'] = '';
							}else{
								$res1['positionlin'] =' - Outside the Location';
							}
						}
						if($row->latit_out!='0.0' && $row->latit_out!='0'){
							if($d2 <= $radius){
								$res1['positionout'] = '';
							}else{
								$res1['positionout'] =' - Outside the Location';
							}
						}
						}
						if($res1['positionout']!='' || $res1['positionlin']!=''){
							if($res1['positionout']=='' && $res1['to']!='00:00')
								$res1['positionout']=' - Within the location';
							if($res1['positionlin']=='')
								$res1['positionlin']=' - Within the location';
							$res[] = $res1;
						}
					}
					$list['geoloc']=$res;
					/*End Geolocations*/
					$result[]=$list;
				}
				
			
			
			}// main foreach close
			 $this->db->close();
			 echo json_encode($result);
	}
	public function getdetailAlertOrg__test()
    {
		
		$result = array();
		$sql = $this->db->query("SELECT Id FROM `Organization` WHERE Id not in (1074) AND mail_unsubscribe = 0 and Id in (select OrganizationId from licence_ubiattendance where status=1 and end_date >= CURDATE()) and id = 363 ");// 1074 is erawan,
		foreach($sql->result() as $row)
		{
			 $orgid = $row->Id;
			 $zone=getTimeZone($orgid);
			 date_default_timezone_set($zone);
			 $time = date("H:i:00");
			 $stime = date("H:00:00");
			 $etime = date("H:i:00", strtotime('+59 minutes',strtotime($stime)));
			 /* echo $stime.'<br/>';
			 echo $etime.'<br/>'; */
			 $date=date('Y-m-d',strtotime('-1 day'));
			 $sql1 = $this->db->query("SELECT OrganizationId,Time FROM `Alert_Settings` WHERE Status=1 and OrganizationId= $orgid  ");
			// $sql1 = $this->db->query("SELECT OrganizationId,Time FROM `Alert_Settings` WHERE Status=1 and OrganizationId= $orgid ");
			foreach($sql1->result() as $row1)
			{
				$list=array();
				$list['orgid']=$row1->OrganizationId;
				$list['admin']=getAdminName($row1->OrganizationId);
				$list['email']=getAdminEmail($row1->OrganizationId);
				
			////////////late comers
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`, `TimeOut` ,'Present' as status,EntryImage,ExitImage FROM `AttendanceMaster` WHERE (time(TimeIn) > (select time(TimeIn) from ShiftMaster where ShiftMaster.Id=shiftId)) and `AttendanceDate`=? and  OrganizationId=? and AttendanceStatus=1 order by `name`",array($date,$orgid));
			$list['late']=$query->result();	
		
			////////////early leaver
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`, `TimeOut` ,'Present' as status,EntryImage,ExitImage FROM `AttendanceMaster` WHERE (time(TimeOut) < (select time(TimeOut) from ShiftMaster where ShiftMaster.Id=shiftId) and TimeOut!='00:00:00' ) and `AttendanceDate`=? and  OrganizationId=? and AttendanceStatus=1 order by `name`",array($date,$orgid));
			$list['early']=$query->result();	
			
			////////////Time off list
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , TimeFrom, TimeTo,Reason, TIMEDIFF(TimeTo, TimeFrom) as Total FROM `Timeoff` WHERE `TimeofDate`=? and  OrganizationId=? and ApprovalSts=2 order by `name`",array($date,$orgid));
			$list['timeoff']=$query->result();
			
			////////////forgot to mark timeout(timeout pending)
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`,EntryImage FROM `AttendanceMaster` WHERE ((TimeIn != '00:00:00' and TimeOut = '00:00:00' ) or (TimeOut = TimeIn and ExitImage = '')) and `AttendanceDate`=? and  OrganizationId=? and AttendanceStatus=1 order by `name`",array($date,$orgid));
			$list['pending']=$query->result();	
			
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , '-' as `TimeIn`,'-' as `TimeOut` ,'Absent' as status FROM `AttendanceMaster` WHERE `AttendanceDate`=? and  OrganizationId=? and AttendanceStatus in (2) order by `name`",array($date,$orgid));
					$list['abs']=$query->result();
					
					//////////////Presentees
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`, `TimeOut` ,'Present' as status,EntryImage,ExitImage FROM AttendanceMaster WHERE AttendanceDate='$date' and  OrganizationId=$orgid and TimeIn !='00:00:00' order by name");
			$list['present']=$query->result();
					
					
					/*Start Geolocations*/
					
					$q2="SELECT A.Id, A.EmployeeId, E.FirstName, E.LastName, A.AttendanceDate as date, A.AttendanceStatus, A.TimeIn, A.TimeOut, A.ShiftId, A.Overtime,A.EntryImage, A.ExitImage,A.latit_in,A.longi_in,A.longi_out,A.latit_out, A.checkInLoc, A.CheckOutLoc,A.areaId, G.Lat_Long, G.Radius FROM AttendanceMaster A, Geo_Settings G, EmployeeMaster E WHERE A.OrganizationId=".$orgid." and G.OrganizationId = ".$orgid." and E.OrganizationId = ".$orgid." and A.AttendanceDate='".$date."' and A.TimeIn!='00:00' and A.areaId!=0 and G.Id=A.areaId and E.Id= A.EmployeeId order by A.AttendanceDate Desc";
					
					$query = $this->db->query($q2);
					$res=array();
					foreach($query->result() as $row){
						$res1=array();
						$res1['Name']=$row->FirstName." ".$row->LastName;	
						$res1['ti']=substr($row->TimeIn,0,5);
						$res1['to']=substr($row->TimeOut,0,5);
						$res1['positionlin']="";
						$res1['positionout']="";
						$res1['latit_in']=$row->latit_in;
						$res1['latit_out']=$row->latit_out;
						$lat_lang = $row->Lat_Long;
						$radius = $row->Radius;
						$arr1 = explode(",",$lat_lang);
						if(count($arr1)>1){
							$a=floatval($arr1[0]);
							$b=floatval($arr1[1]);
							$d1 = $this->distance($a,$b, $row->latit_in, $row->longi_in, "K");
							$d2 = $this->distance($a,$b, $row->latit_out, $row->longi_out, "K");
						if($row->latit_in!='0.0' && $row->latit_in!='0'){
							if($d1 <= $radius){
								$res1['positionlin'] = '';
							}else{
								$res1['positionlin'] =' - Outside the Location';
							}
						}
						if($row->latit_out!='0.0' && $row->latit_out!='0'){
							if($d2 <= $radius){
								$res1['positionout'] = '';
							}else{
								$res1['positionout'] =' - Outside the Location';
							}
						}
						}
						if($res1['positionout']!='' || $res1['positionlin']!=''){
							if($res1['positionout']=='' && $res1['to']!='00:00')
								$res1['positionout']=' - Within the location';
							if($res1['positionlin']=='')
								$res1['positionlin']=' - Within the location';
							$res[] = $res1;
						}
					}
					$list['geoloc']=$res;
					/*End Geolocations*/
					$result[]=$list;
				}
				
			
			
			}// main foreach close
			 $this->db->close();
			 echo json_encode($result);
	}
	
	public function getdetailAlertOrg(){	
		$result = array();
		$sql = $this->db->query("SELECT Id FROM `Organization` WHERE Id not in (1074) AND mail_unsubscribe = 0 and Id in (select OrganizationId from licence_ubiattendance where status=1 and end_date >= CURDATE()) ");// 1074 is erawan,
		foreach($sql->result() as $row)
		{
			 $orgid = $row->Id;
			 $zone=getTimeZone($orgid);
			 date_default_timezone_set($zone);
			 $time = date("H:i:00");
			 $stime = date("H:00:00");
			 $etime = date("H:i:00", strtotime('+59 minutes',strtotime($stime)));
			 /* echo $stime.'<br/>';
			 echo $etime.'<br/>'; */
			 $date=date('Y-m-d',strtotime('-1 day'));
			 $sql1 = $this->db->query("SELECT OrganizationId,Time FROM `Alert_Settings` WHERE Status=1 and OrganizationId= $orgid and Time between '$stime' and '$etime' ");
			foreach($sql1->result() as $row1)
			{
				$list=array();
				$list['orgid']=$row1->OrganizationId;
				$list['admin']=getAdminName($row1->OrganizationId);
				$list['email']=getAdminEmail($row1->OrganizationId);
				
			////////////late comers
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , A.`TimeIn`, A.`TimeOut` ,'Present' as status,EntryImage,ExitImage,Timediff(A.TimeIn,S.TimeIn) as lateby FROM `AttendanceMaster` A ,ShiftMaster S WHERE A.TimeIn > S.TimeIn and S.Id=A.shiftId and A.`AttendanceDate`=? and  A.OrganizationId=? and A.AttendanceStatus=1 order by `name`",array($date,$orgid));
			$list['late']=$query->result();	
		
			////////////early leaver
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , A.`TimeIn`, A.`TimeOut` ,'Present' as status,EntryImage,ExitImage ,Timediff(S.TimeOut,A.TimeOut) as earlyleaver FROM `AttendanceMaster` A ,ShiftMaster S WHERE A.TimeOut < S.TimeOut and S.Id=A.shiftId and A.TimeOut!='00:00:00' and A.`AttendanceDate`=? and  A.OrganizationId=? and A.AttendanceStatus=1 order by `name`",array($date,$orgid));
			$list['early']=$query->result();	
			
			////////////Time off list
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , TimeFrom, TimeTo,Reason, TIMEDIFF(TimeTo, TimeFrom) as Total FROM `Timeoff` WHERE `TimeofDate`=? and  OrganizationId=? and ApprovalSts=2 order by `name`",array($date,$orgid));
			$list['timeoff']=$query->result();
			
			////////////forgot to mark timeout(timeout pending)
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`,EntryImage FROM `AttendanceMaster` WHERE ((TimeIn != '00:00:00' and TimeOut = '00:00:00' ) or (TimeOut = TimeIn and ExitImage = '')) and `AttendanceDate`=? and  OrganizationId=? and AttendanceStatus=1 order by `name`",array($date,$orgid));
			$list['pending']=$query->result();	
			
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , '-' as `TimeIn`,'-' as `TimeOut` ,'Absent' as status FROM `AttendanceMaster` WHERE `AttendanceDate`=? and  OrganizationId=? and AttendanceStatus in (2) order by `name`",array($date,$orgid));
					$list['abs']=$query->result();
					
					//////////////Presentees
			$query = $this->db->query("SELECT (select CONCAT(FirstName,' ',LastName)  from EmployeeMaster where id= `EmployeeId`) as name , `TimeIn`, `TimeOut` ,'Present' as status,timediff(TimeOut,TimeIn) as loggedhours,EntryImage,ExitImage FROM AttendanceMaster WHERE AttendanceDate='$date' and  OrganizationId=$orgid and TimeIn !='00:00:00' order by name");
			$list['present']=$query->result();
					
					
					/*Start Geolocations*/
					
					$q2="SELECT A.Id, A.EmployeeId, E.FirstName, E.LastName, A.AttendanceDate as date, A.AttendanceStatus, A.TimeIn, A.TimeOut, A.ShiftId, A.Overtime,A.EntryImage, A.ExitImage,A.latit_in,A.longi_in,A.longi_out,A.latit_out, A.checkInLoc, A.CheckOutLoc,A.areaId, G.Lat_Long, G.Radius FROM AttendanceMaster A, Geo_Settings G, EmployeeMaster E WHERE A.OrganizationId=".$orgid." and G.OrganizationId = ".$orgid." and E.OrganizationId = ".$orgid." and A.AttendanceDate='".$date."' and A.TimeIn!='00:00' and A.areaId!=0 and G.Id=A.areaId and E.Id= A.EmployeeId order by A.AttendanceDate Desc";
					
					$query = $this->db->query($q2);
					$res=array();
					foreach($query->result() as $row){
						$res1=array();
						$res1['Name']=$row->FirstName." ".$row->LastName;	
						$res1['ti']=substr($row->TimeIn,0,5);
						$res1['to']=substr($row->TimeOut,0,5);
						$res1['positionlin']="";
						$res1['positionout']="";
						$res1['latit_in']=$row->latit_in;
						$res1['latit_out']=$row->latit_out;
						$lat_lang = $row->Lat_Long;
						$radius = $row->Radius;
						$arr1 = explode(",",$lat_lang);
						if(count($arr1)>1){
							$a=floatval($arr1[0]);
							$b=floatval($arr1[1]);
							$d1 = $this->distance($a,$b, $row->latit_in, $row->longi_in, "K");
							$d2 = $this->distance($a,$b, $row->latit_out, $row->longi_out, "K");
						if($row->latit_in!='0.0' && $row->latit_in!='0'){
							if($d1 <= $radius){
								$res1['positionlin'] = '';
							}else{
								$res1['positionlin'] =' - Outside the Location';
							}
						}
						if($row->latit_out!='0.0' && $row->latit_out!='0'){
							if($d2 <= $radius){
								$res1['positionout'] = '';
							}else{
								$res1['positionout'] =' - Outside the Location';
							}
						}
						}
						if($res1['positionout']!='' || $res1['positionlin']!=''){
							if($res1['positionout']=='' && $res1['to']!='00:00')
								$res1['positionout']=' - Within the location';
							if($res1['positionlin']=='')
								$res1['positionlin']=' - Within the location';
							$res[] = $res1;
						}
					}
					$list['geoloc']=$res;
					/*End Geolocations*/
					$result[]=$list;
				}
				
			
			
			}// main foreach close
			 $this->db->close();	
	    $message='';		
		//print_r($result);
		foreach($result as $r){
			//print_r($r);
			if(count($r['pending'])>0 || $r['present'] >0 || count($r['abs'])>0 || count($r['late'])>0 || count($r['early'])>0 || count($r['timeoff'])>0 || count($r['geoloc'])>0){
			//print_r($r);
			$message ='<center><img src="http://ubitechsolutions.com/ubitechsolutions/Mailers/ubiAttendance/ubiAttendance/logo.png" width="250px;"/></center>';
			$message.='<center><h3 style="color:green;padding:0px; margin:0px;">
			Yesterday'."'".'s Attendance Summary</h3>';
			$message.='['.$date.']<br/>';
			$index=1;	
			if(count($r['present'])>0)
			{
			$message.= '<div><br><h3 style="margin-bottom:5px;" >Present</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>S.no</th><th>Employee</th><th>Time In</th><th>Time Out</th><th>Logged Hours</th></tr>';	
				foreach($r['present'] as $emp){
					$message.= '<tr><td align="left" style="padding-left:3%">'.($index++).'</td><td align="left" style="padding-left:2%">'.$emp->name.'</td><td align="center">'.date("H:i",strtotime($emp->TimeIn)).'</td>
					<td align="center">'.date("H:i",strtotime($emp->TimeOut)).'</td>
					<td align="center">'.$emp->loggedhours.'</td>
					</tr>';
				}
			$message.= '</table></div>';
			}
			
			
			$index=1;
			if(count($r['pending'])>0){
			$message.= '<div><h3 style="margin-bottom:5px;" >Time Out Not Marked</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>S.no</th><th>Employee</th><th>Time In</th><th>Time Out</th><th>Logged Hours</th></tr>';
				foreach($r['pending'] as $emp){
					$message.= '<tr><td align="left" style="padding-left:3%">'.($index++).'</td><td align="left" style="padding-left:2%">'. $emp->name . '</td><td align="center">'. date("H:i",strtotime($emp->TimeIn)) .'</td><td align="center">--</td>
					<td align="center">"00:00"</td></tr>';
				}
				$message.='</table></div>';
			}
			$index=1;
			if(count($r['abs'])>0){
			$message.= '<div><br><h3 style="margin-bottom:5px;" >Absentees</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>S.no</th><th>Employee</th><th>Time In</th><th>Time Out</th></tr>';	
				foreach($r['abs'] as $emp){
					$message.= '<tr><td align="left" style="padding-left:3%">'.($index++).'</td><td align="left" style="padding-left:2%">'.$emp->name.'</td><td align="center">--</td><td align="center">--</td></tr>';
				}
			$message.= '</table></div>';
			}
			$index=1;
			if(count($r['late'])>0){
			$message.= '<div><br><h3 style="margin-bottom:5px;" >Late Comers</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>S.no</th><th>Employee</th><th>Time In</th><th>Time Out</th><th>Late By</th></tr>';	
				foreach($r['late'] as $emp){
					$message.= '<tr><td align="left" style="padding-left:3%">'.($index++).'</td><td align="left" style="padding-left:2%">'.$emp->name.'</td><td align="center">'.date("H:i",strtotime($emp->TimeIn)).'</td><td align="center">'.date("H:i",strtotime($emp->TimeOut)).'</td>
					<td>'.$emp->lateby.'</td>

					</tr>';
				}
			$message.= '</table></div>';
			}
			$index=1;
			if(count($r['early'])>0){
			$message.= '<div><br><h3 style="margin-bottom:5px;" >Early Leavers</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>S.no</th><th>Employee</th><th>Time In</th><th>Time Out</th><th>Early By</th></tr>';	
			
				foreach($r['early'] as $emp){
					$message.= '<tr><td align="left" style="padding-left:3%">'.($index++).'</td><td align="left" style="padding-left:2%">'.$emp->name.'</td><td align="center">'.date("H:i",strtotime($emp->TimeIn)).'</td><td align="center">'.date("H:i",strtotime($emp->TimeOut)).'</td>
					<td>'.$emp->earlyleaver.'</td>
					</tr>';
				}
			$message.= '</table></div>';
			}
			$index=1;
			if(count($r['timeoff'])>0)
			{
			$message.= '<div><br><h3 style="margin-bottom:5px;" >Time Off List (Approved)</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>S.no</th><th>Employee</th><th>Timings</th><th>Total Time </th width="40%"><th>Reason</th></tr>';
				
				foreach($r['timeoff'] as $emp){
					$message.= '<tr><td align="left" style="padding-left:3%">'.($index++).'</td><td align="left" style="padding-left:2%">'.$emp->name.'</td><td align="center">'.date("H:i",strtotime($emp->TimeFrom)).' - '.date("H:i",strtotime($emp->TimeTo)).'</td><td align="center">'.date("H:i",strtotime($emp->Total)).'</td><td  width="40%">'.$emp->Reason.'</td></tr>';
				}
			$message.= '</table></div>';
			}
			$index=1;
			if(count($r['geoloc'])>0){
			$message.= '<div><br><h3 style="margin-bottom:5px;" >Attendance Marked outside the Fenced Area</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>S.no</th><th>Employee</th><th>Time In</th><th>Time Out</th></tr>';	
				
				foreach($r['geoloc'] as $emp){
					$message.= '<tr><td align="left" style="padding-left:2%">'.($index++).'</td><td align="left" style="padding-left:2%">'.$emp['Name'].'</td><td align="center">'.$emp['ti'].$emp['positionlin'].'</td><td align="center">'.$emp['to'].$emp['positionout'].'</td></tr>';
				}
			$message.= '</table></div>';
			}
			$message.= '<div style="width:50%" ><p style="text-align:left">
			
			View more details on – <span><a href="https://ubiattendance.ubihrm.com">https://ubiattendance.ubihrm.com/</a><span></p>
			<p style="text-align:left;font-weight:bold">Cheers,Team ubiAttendance<br/>
			<a href="www.ubiattendance.com">www.ubiattendance.com</a><br/>
			Tel / Whatsapp: +91 70678 22132<br/>
			Email: <a href="ubiattendance@ubitechsolutions.com">ubiattendance@ubitechsolutions.com<a><br/>
			Skype: ubitech.solutions
			</p>
			<p style="text-align:left;font-size:13px">You have received this email because your are a registered member on ubiAttendance App. If you do not want to receive this mailer, <a href="#">unsubscribe<a>. To make sure this email is not sent to your "junk" folder, Add “<a href="ubiattendance@ubitechsolutions.com">ubiattendance@ubitechsolutions.com</a>” to your Address Book</p></div>';
		    $message.='</center>';
			//print_r($message);
				sendEmail_new($r['email'],'ubiAttendance- Attendance Summary',$message,'');
				sendEmail_new('vijay@ubitechsolutions.com','ubiAttendance- Attendance Summary',$message,'');
				sendEmail_new('parth@ubitechsolutions.com','ubiAttendance- Attendance Summary',$message,'');
				sendEmail_new('sohan@ubitechsolutions.com','ubiAttendance- Attendance Summary',$message,'');
				
		 }
		}
		//mail('vijay@ubitechsolutions.com','Organizations alert mails cron per hour','Organizations alert mails cron per hour success');
		//mail('deeksha@ubitechsolutions.com','Organizations alert mails cron per hour','Organizations alert mails cron per hour success');
	}
	
	public function weekllyAttAlert()//sohan
	{
		$sql = $this->db->query("SELECT Id FROM `Organization` WHERE Id not in (1074) AND mail_unsubscribe = 0 and Id in (select OrganizationId from licence_ubiattendance where status=1 and end_date >= CURDATE()) ");// 1074 is erawan,
		foreach($sql->result() as $row)
		{

			 $orgid = $row->Id;
			 $zone=getTimeZone($orgid);
			 date_default_timezone_set($zone);
			 $time = date("H:i:00");
			 $stime = date("H:00:00");
			 $etime = date("H:i:00", strtotime('+59 minutes',strtotime($stime)));
			
			 $date = date("d-M-Y");
			 $sql1 = $this->db->query("SELECT OrganizationId,Time FROM `Alert_Settings` WHERE Status=1 and OrganizationId= $orgid  ");//and Time between '$stime' and '$etime'
			foreach($sql1->result() as $row1)
			{
				$list=array();
				$list['orgid']=$row1->OrganizationId;
				$list['admin']=getAdminName($row1->OrganizationId);
				$list['email']=getAdminEmail($row1->OrganizationId);
				////////calculation
				
			
			$result = array();
			$res = array();
			$count=0;
			$total=0;$total1=0;$total2=0;$total3=0;$total4=0;
			$totalcumlate=0;$totalcumearly=0;$totalavgsum=0;$totalcumunder=0;$totalcumtime=0;
				
				$enddate="";
				$startdate="";
				$da = $this->getStartAndEndDate();
				$enddate=$da['end_date'];
				$startdate= $da['start_date'];
				$begin = new DateTime($startdate);
				$interval = new DateInterval('P1D'); // 1 Day
				$realEnd = new DateTime($enddate);           
				$realEnd->add($interval);
				$dateRange = new DatePeriod($begin,$interval,$realEnd);
				$range = "";
				foreach ($dateRange as $date) 
				{
					$dt= $date->format('Y-m-d');
					if($range == "")
					$range = "'".$date->format('Y-m-d')."'";
					else
					$range .= ",'".$date->format('Y-m-d')."'";
				}
				$rangedate = $range;
			
				if($rangedate=="")
				  {
					$rangedate = 1;
				 } 
					$list=array();
					$list['orgid']=$orgid;
					$list['admin']=getAdminName($orgid);
					$list['email']=getAdminEmail($orgid);
					$q1=$this->db->query("Select CONCAT(E.FirstName,' ',E.LastName) as name,Id,Shift from EmployeeMaster E where E.OrganizationId = $orgid and E.archive = 1 and E.Is_Delete = 0 order by E.FirstName");
					foreach($q1->result() as $row1)
					{			
					$data=array();
					$empid=$row1->Id;
					$data['name']=$row1->name;
					$shiftid = $row1->Shift;
					$workdays = $this->getWorkingDays($shiftid,$enddate,$orgid);
					
					$q3=$this->db->query("SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( TIMEDIFF( A.TimeIn, S.TimeIn ) ) )DIV $workdays ) AS latecoming,SEC_TO_TIME( SUM( TIME_TO_SEC( TIMEDIFF( A.TimeIn, S.TimeIn ) ) )) AS totlatecoming,
					SUM( TIME_TO_SEC( TIMEDIFF( A.TimeIn, S.TimeIn ) ) )DIV $workdays  AS cumlatecoming ,SUM( TIME_TO_SEC( TIMEDIFF( A.TimeIn, S.TimeIn ) ) ) AS totcumlatecoming, A.TimeIn,
					SEC_TO_TIME(SUM(TIME_TO_SEC( TIMEDIFF( S.TimeOut, A.TimeOut))) DIV $workdays ) AS earlyleaving,SEC_TO_TIME(SUM(TIME_TO_SEC( TIMEDIFF( S.TimeOut, A.TimeOut)))) AS totearlyleaving,
					 SUM( TIME_TO_SEC( TIMEDIFF( S.TimeOut, A.TimeOut))) DIV $workdays  AS cumearlyleave,SUM( TIME_TO_SEC( TIMEDIFF( S.TimeOut, A.TimeOut))) DIV $workdays  AS totcumearlyleave,A.TimeOut,
					sec_to_time(sum(Time_to_Sec(TIMEDIFF(A.TimeOut,A.TimeIn))) DIV $workdays) as difference,sec_to_time(sum(Time_to_Sec(TIMEDIFF(A.TimeOut,A.TimeIn)))) as totaldiff,
					sum(Time_to_Sec(TIMEDIFF(A.TimeOut,A.TimeIn))) DIV $workdays 
					as avgsum,sum(Time_to_Sec(TIMEDIFF(A.TimeOut,A.TimeIn)))  
					as totavgsum,
					SEC_TO_TIME(sum(time_to_sec(TIMEDIFF(A.TimeIn,A.TimeOut))
					-CASE WHEN(A.TimeOut>S.TimeOutBreak) THEN time_to_sec(TIMEDIFF(S.TimeIn,S.TimeOut)) 
					ELSE time_to_sec(TIMEDIFF(S.TimeIn,S.TimeOut)-time_to_sec(TIMEDIFF(S.TimeInBreak,S.TimeOutBreak))) END) div $workdays) as undertime,SEC_TO_TIME(sum(time_to_sec(TIMEDIFF(A.TimeIn,A.TimeOut))
					-CASE WHEN(A.TimeOut>S.TimeOutBreak) THEN time_to_sec(TIMEDIFF(S.TimeIn,S.TimeOut)) 
					ELSE time_to_sec(TIMEDIFF(S.TimeIn,S.TimeOut)-time_to_sec(TIMEDIFF
					(S.TimeInBreak,S.TimeOutBreak))) END)) as totalundertime,
					TIME_TO_SEC(SEC_TO_TIME(sum(time_to_sec( TIMEDIFF(A.TimeIn,A.TimeOut))
					-CASE WHEN(A.TimeOut>S.TimeOutBreak) THEN time_to_sec(TIMEDIFF(S.TimeIn,S.TimeOut)) 
					ELSE time_to_sec(TIMEDIFF(S.TimeIn,S.TimeOut)-time_to_sec(
					TIMEDIFF(S.TimeInBreak,S.TimeOutBreak))) END) div $workdays)) as cumundertime,TIME_TO_SEC(SEC_TO_TIME(sum(time_to_sec( TIMEDIFF(A.TimeIn,A.TimeOut))
					-CASE WHEN(A.TimeOut>S.TimeOutBreak) THEN time_to_sec(TIMEDIFF(S.TimeIn,S.TimeOut)) 
					ELSE time_to_sec(TIMEDIFF(S.TimeIn,S.TimeOut)-time_to_sec(
					TIMEDIFF(S.TimeInBreak,S.TimeOutBreak))) END)  )) as totcumundertime FROM AttendanceMaster A, ShiftMaster S WHERE (A.TimeIn != '00:00:00')  AND A.OrganizationId = $orgid  AND 
					(A.TimeOut != '00:00:00') and A.EmployeeId = $empid  AND S.Id =$shiftid AND A.AttendanceDate IN(".$rangedate.")");
					
					if($row2 = $q3->row())
					{
						$data['latecoming']=substr($row2->latecoming,0,-3);
						$total=$total+$row2->cumlatecoming;
						
						$data['totlatecoming']=substr($row2->totlatecoming,0,-3);
						$totalcumlate=$totalcumlate+$row2->totcumlatecoming;
						
						$data['earlyleaving']=substr($row2->earlyleaving,0,-3);
						$total1=$total1+$row2->cumearlyleave;
						
						$data['totearlyleaving']=substr($row2->totearlyleaving,0,-3);
						$totalcumearly=$totalcumearly+$row2->totcumearlyleave;
						
						$data['avglog']=substr($row2->difference,0,-3);
						$total4=$total4+$row2->avgsum;
						
						$data['totaldiff']=substr($row2->totaldiff,0,-3);
						$totalavgsum=$totalavgsum+$row2->totavgsum;
						
						$data['undertime']=substr($row2->undertime,0,-3);
						$total2=$total2+$row2->cumundertime;
						
						$data['totalundertime']=substr($row2->totalundertime,0,-3);
						$totalcumunder=$totalcumunder+$row2->totcumundertime;
						
						if($row2->undertime==''||$row2->difference==''||$row2->latecoming==''||$row2->earlyleaving==''||$row2->totaldiff==''||$row2->totalundertime==''||$row2->totlatecoming==''||$row2->totearlyleaving=='')
						{
							$data['undertime']='00:00';
							$data['avglog']='00:00';
							$data['latecoming']='00:00';
							$data['earlyleaving']='00:00';
							$data['totaldiff']='00:00';
							$data['totalundertime']='00:00';
							$data['totlatecoming']='00:00';
							$data['totearlyleaving']='00:00';
							
						}
					
					}
			
				//////////////////Average  Time Off //////////////////////////
				$q5=$this->db->query("SELECT SEC_TO_TIME(sum(TIME_TO_SEC(TIMEDIFF(T.TimeTo,T.TimeFrom)))DIV $workdays) AS timeoff,
				SEC_TO_TIME(sum(TIME_TO_SEC(TIMEDIFF(T.TimeTo,T.TimeFrom)))) AS tottimeoff,
				TIME_TO_SEC(SEC_TO_TIME(sum(TIME_TO_SEC(TIMEDIFF(T.TimeTo,T.TimeFrom)))DIV $workdays)) AS cumtimeoff,
				TIME_TO_SEC(SEC_TO_TIME(sum(TIME_TO_SEC(TIMEDIFF(T.TimeTo,T.TimeFrom)))
				)) AS totcumtimeoff,T.TimeofDate FROM Timeoff T WHERE  T.OrganizationId =$orgid  and T.TimeofDate IN (".$rangedate.") AND T.TimeFrom != '00:00:00' AND T.TimeTo != '00:00:00'  AND T.EmployeeId=$empid");
						if($row5 = $q5->row())
						{
							$data['timeoff']=substr($row5->timeoff,0,5);
							$total3=$total3+$row5->cumtimeoff;
							$data['tottimeoff']=substr($row5->tottimeoff,0,5);
							$totalcumtime=$totalcumtime+$row5->totcumtimeoff;
							if($row5->timeoff==''||$row5->tottimeoff=='')
							{
							$data['timeoff']='00:00';
							$data['tottimeoff']='00:00';
							}
						}
							
						
						$count++;
						$res[] = $data;
						}
					if($count==0)
						$count++;
					
			$hours 		= 	floor($total / 3600);
			$mins 		= 	floor($total / 60 % 60);
			$cumtotal	= 	sprintf('%02d:%02d',$hours,$mins);
			$total		=	$total/$count;
			$hours 		= 	floor($total / 3600);
			$mins 		= 	floor($total / 60 % 60);
			$timeFormat = 	sprintf('%02d:%02d', $hours, $mins);
			
			$hours 		= 	floor($totalcumlate / 3600);
			$mins 		= 	floor($totalcumlate / 60 % 60);
			$cumtotallate	= 	sprintf('%02d:%02d',$hours,$mins);
			$total		=	$totalcumlate/$count;
			$hours 		= 	floor($totalcumlate / 3600);
			$mins 		= 	floor($totalcumlate / 60 % 60);
			$totaltimeFormat = 	sprintf('%02d:%02d', $hours, $mins);
			
			
			$hours 		= 	floor($total1 / 3600);
			$mins 		= 	floor($total1 / 60 % 60);
			$cumtotal1	=	sprintf('%02d:%02d', $hours, $mins);
			$total1		=	$total1/$count;
			$hours		= 	floor($total1 / 3600);
			$mins 		= 	floor($total1 / 60 % 60);
		$timeFormat1    = 	sprintf('%02d:%02d', $hours, $mins);
		
		$hours 		= 	floor($totalcumearly / 3600);
			$mins 		= 	floor($totalcumearly / 60 % 60);
			$cumtotalearly	=	sprintf('%02d:%02d', $hours, $mins);
			$totalcumearly		=	$totalcumearly/$count;
			$hours		= 	floor($totalcumearly / 3600);
			$mins 		= 	floor($totalcumearly / 60 % 60);
		$totaltimeFormat1    = 	sprintf('%02d:%02d', $hours, $mins);
			
			
			$hours 		= 	floor($total2 / 3600);
			$mins 		= 	floor($total2 / 60 % 60);
			$cumtotal2 	= 	sprintf('%02d:%02d',$hours,$mins);
			$total2		=	$total2/$count;
			$hours 		= 	floor($total2 / 3600);
			$mins 		= 	floor($total2 / 60 % 60);
		$timeFormat2 	= 	sprintf('%02d:%02d', $hours, $mins);
		
		$hours 		= 	floor($totalcumunder / 3600);
			$mins 		= 	floor($totalcumunder / 60 % 60);
			$cumtotalunder 	= 	sprintf('%02d:%02d',$hours,$mins);
			$totalcumunder		=	$totalcumunder/$count;
			$hours 		= 	floor($totalcumunder / 3600);
			$mins 		= 	floor($totalcumunder / 60 % 60);
		$totaltimeFormat2 	= 	sprintf('%02d:%02d', $hours, $mins);
			
			
			$hours 		= 	floor($total3 / 3600);
			$mins 		= 	floor($total3 / 60 % 60);
			$cumtotal3 	= 	sprintf('%02d:%02d', $hours, $mins);
			$total3		=	$total3/$count;
			$hours 		= 	floor($total3 / 3600);
			$mins 		= 	floor($total3 / 60 % 60);
		$timeFormat3 	= 	sprintf('%02d:%02d', $hours, $mins);
		
			$hours 		= 	floor($totalcumtime / 3600);
			$mins 		= 	floor($totalcumtime / 60 % 60);
			$cumtotaltime 	= 	sprintf('%02d:%02d', $hours, $mins);
			$totalcumtime		=	$totalcumtime/$count;
			$hours 		= 	floor($totalcumtime / 3600);
			$mins 		= 	floor($totalcumtime / 60 % 60);
		$totaltimeFormat3 	= 	sprintf('%02d:%02d', $hours, $mins);
		
			
		
		
			$hours 		= 	floor($total4 / 3600);
			$mins 		= 	floor($total4 / 60 % 60);
			$cumtotal4 	= 	sprintf('%02d:%02d', $hours, $mins);
			$total4		=	$total4/$count;
			$hours 		= 	floor($total4 / 3600);
			$mins 		= 	floor($total4 / 60 % 60);
		$timeFormat4 	= 	sprintf('%02d:%02d', $hours, $mins);
		
		
		    $hours 		= 	floor($totalavgsum / 3600);
			$mins 		= 	floor($totalavgsum / 60 % 60);
			$cumtotalavg 	= 	sprintf('%02d:%02d', $hours, $mins);
			$totalavgsum		=	$totalavgsum/$count;
			$hours 		= 	floor($totalavgsum / 3600);
			$mins 		= 	floor($totalavgsum / 60 % 60);
		$totaltimeFormat4 	= 	sprintf('%02d:%02d', $hours, $mins);
		
			$list['report']=$res;
			$result[]=$list;
			$message='';
			
			foreach($result as $r)
			{
				$index=1;
				$message ='<center>';
				
				if(count($r['report'])>0)
				{
					$date1=date('d-M-Y');
					$message ='<center><img src="http://ubitechsolutions.com/ubitechsolutions/Mailers/ubiAttendance/ubiAttendance/logo.png" width="250px;"/></center>';
					$message.= 
					'<center><div style="width:65%;margin-bottom:5%;"><h3 style="color:green;padding:0px; margin:0px;">Attendance Weekly Averages Summary</h3>
					['.$startdate.' to '.$enddate.']
					<div style="margin-top:5%;">
					<table style="border-collapse: collapse;" border width="100%">
					<tr style="color:#fa6804">
					<th>S.no</th>
					<th style="width:18%">Employees</th>
					<th style="width:16.5%;">Avg / Total<br/> Shift Hours </th>
					<th style="width:16.5%;">Avg / Total<br/> Late Coming</th>
					<th style="width:16.5%;">Avg / Total<br/> Early Leaving</th>
					<th style="width:16.5%;">Avg / Total <br/> Time Off</th>
					<th style="width:16.5%;">Avg /  Total<br/> Undertime </th>
					</tr>';	
					foreach($r['report'] as $emp)
					{
						$message.= '<tr>
		<td align="left"  style="padding-left:1%">'.($index++).'</td>				
		<td align="left" style="width:18%;padding-left:1%">'.$emp['name'].'</td>
		<td align="center" style="width:16.5%;padding:1% 1%">'.$emp['avglog']." / ".$emp['totaldiff'].'</td>
		<td align="right" style="width:16.5%;padding-right:3%">'.$emp['latecoming']." / ".$emp['totlatecoming'].'</td>
		<td align="right" style="width:16.5%;padding-right:3%">'.$emp['earlyleaving']." / ".$emp['totearlyleaving'].'</td>
		<td align="right" style="width:16.5%;padding-right:3%">'.$emp['timeoff']." / ".$emp['tottimeoff'].'</td>
		<td align="right" style="width:16.5%;padding-right:3%">'.$emp['undertime']." / ".$emp['totalundertime'].'</td>
								
								</tr>';
									
					}
				$message.= '<tfoot>
				<tr style="font-weight:bold">
				<td align="right" style="padding-right:1%"></td>
				<td style="text-align:left;padding-left:1%">Team’s Total</td>
				<td align="right" style="padding-right:3%">'.$cumtotal4." / ".$cumtotalavg.'</td>
				<td align="right" style="padding-right:3%">'.$cumtotal." / ".$cumtotallate.'</td>
				<td align="right" style="padding-right:3%">'.$cumtotal1." / ".$cumtotalearly.'</td>
				<td align="right" style="padding-right:3%">'.$cumtotal2." / ".$cumtotalunder.'</td>
				<td align="right" style="padding-right:3%">'.$cumtotal3." / ".$cumtotaltime.'</td>
				</tr>
				
				<tr style="color:#f19240;font-weight:bold">
				<td align="right" style="padding-right:1%"></td>
				<td style="text-align:left;padding-left:1%">Team’s Average</td>
				<td align="right" style="padding-right:3%">'.$timeFormat4." / ".$totaltimeFormat4.'</td>
				<td align="right" style="padding-right:3%">'.$timeFormat." / ".$totaltimeFormat.'</td>
				<td align="right" style="padding-right:3%">'.$timeFormat1." / ".$totaltimeFormat1.'</td>
				<td align="right" style="padding-right:3%">'.$timeFormat2." / ".$totaltimeFormat2.'</td>
				<td align="right" style="padding-right:3%">'.$timeFormat3." / ".$totaltimeFormat3.'</td>
				</tr></tfoot>
						
				</div>
			</table>
					
			<br/><br/>
					
			<div>
				<p style="text-align:left;font-weight:bold">
				Note: Team’s Average = <span style="text-align:center;font-weight:bold">
				Team’s Total/No. of Employees</span>
				</p>
			</div>
			
			<p style="text-align:left">
			Report sent on 
			<b>'.$date1.'</b> at <b>'.$time.'</b><br/>
			View more details on – <span><a href="https://ubiattendance.ubihrm.com">https://ubiattendance.ubihrm.com/</a><span></p>
			<p style="text-align:left;font-weight:bold">Cheers,<br/>
			Team ubiAttendance<br/>
			<a href="www.ubiattendance.com">www.ubiattendance.com</a><br/>
			Tel/ Whatsapp: +91 70678 22132<br/>
			Email: <a href="ubiattendance@ubitechsolutions.com">ubiattendance@ubitechsolutions.com<a><br/>
			Skype: ubitech.solutions
			</p>
			
			
			<p style="text-align:left;font-size:13px">You have received this email because your are a registered member on ubiAttendance App. If you do not want to receive this mailer, <a href="#">unsubscribe<a>. To make sure this email is not sent to your "junk" folder, Add “<a href="ubiattendance@ubitechsolutions.com">ubiattendance@ubitechsolutions.com</a>” to your Address Book</p>
			</div>';
				}
				
				$message .= '</center>';
				//echo ($message);
				sendEmail_new($r['email'],'ubiAttendance- Attendance Summary',$message,'');
				sendEmail_new('vijay@ubitechsolutions.com','ubiAttendance- Attendance Summary',$message,'');
				sendEmail_new('parth@ubitechsolutions.com','ubiAttendance- Attendance Summary',$message,'');
				
				sendEmail_new('sohan@ubitechsolutions.com','ubiAttendance- Attendance Summary',$message,'');
			}
				
			}
		}
	}
	
	public function monthllyAttAlert()// sohan
	{
		
		$sql = $this->db->query("SELECT Id FROM `Organization` WHERE Id not in (1074) AND mail_unsubscribe = 0 and Id in (select OrganizationId from licence_ubiattendance where status=1 and end_date >= CURDATE()) ");// 1074 is erawan,
		foreach($sql->result() as $row)
		{

			 $orgid = $row->Id;
			 $zone=getTimeZone($orgid);
			 date_default_timezone_set($zone);
			 $time = date("H:i:00");
			 $stime = date("H:00:00");
			 $etime = date("H:i:00", strtotime('+59 minutes',strtotime($stime)));
			
			 $date = date("d-M-Y");
			 $sql1 = $this->db->query("SELECT OrganizationId,Time FROM `Alert_Settings` WHERE Status=1 and OrganizationId= $orgid  ");//and Time between '$stime' and '$etime'
			foreach($sql1->result() as $row1)
			{
				$list=array();
				$list['orgid']=$row1->OrganizationId;
				$list['admin']=getAdminName($row1->OrganizationId);
				$list['email']=getAdminEmail($row1->OrganizationId);
				////////calculation
			   $result = array();
				$res = array();
				$count=0;
				$total=0;$total1=0;$total2=0;$total3=0;$total4=0;
				
				$enddate="";
				$startdate="";
				$da = $this->getStartAndEndDate1();
				$enddate=$da['end_date'];
				$startdate= $da['start_date'];
				$begin = new DateTime($startdate);
				$interval = new DateInterval('P1D'); // 1 Day
				$realEnd = new DateTime($enddate);           
				$realEnd->add($interval);
				$dateRange = new DatePeriod($begin,$interval,$realEnd);
				$range = "";
				foreach ($dateRange as $date) 
				{
					$dt= $date->format('Y-m-d');
					if($range=="")
					$range = "'".$date->format('Y-m-d')."'";
					else
					$range .= ",'".$date->format('Y-m-d')."'";
				}
				$rangedate = $range;
				//echo $rangedate;
				if($rangedate=="")
				{
					$rangedate = 1;
				} 
					$list=array();
					$list['orgid']=$orgid;
					$list['admin']=getAdminName($orgid);
					$list['email']=getAdminEmail($orgid);
					$q1=$this->db->query("Select CONCAT(E.FirstName,' ',E.LastName) as name,Id,Shift from EmployeeMaster E where E.OrganizationId = $orgid and E.archive = 1 and E.Is_Delete = 0 order by E.FirstName"  );
					foreach($q1->result() as $row1)
					{			
					$data=array();
					$empid=$row1->Id;
					$data['name']=$row1->name;
					$shiftid = $row1->Shift;
					$q3=$this->db->query("SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( TIMEDIFF( A.TimeIn, S.TimeIn )))) AS latecoming,
					TIME_TO_SEC(SEC_TO_TIME( SUM( TIME_TO_SEC( TIMEDIFF( A.TimeIn, S.TimeIn ) ) ) )) AS cumlatecoming,A.TimeIn,
					SEC_TO_TIME(SUM(TIME_TO_SEC( TIMEDIFF( S.TimeOut, A.TimeOut))) ) AS earlyleaving,
					TIME_TO_SEC(SEC_TO_TIME( SUM( TIME_TO_SEC( TIMEDIFF( S.TimeOut, A.TimeOut)))  )) AS cumearlyleave,A.TimeOut,
					sec_to_time(sum(Time_to_Sec(TIMEDIFF(A.TimeOut,A.TimeIn))) ) as difference,
					time_to_sec(sec_to_time (sum(Time_to_Sec(TIMEDIFF(A.TimeOut,A.TimeIn)))))
					as avgsum,
					SEC_TO_TIME(sum(time_to_sec( TIMEDIFF(A.TimeOut,A.TimeIn))
					-CASE WHEN(A.TimeOut>S.TimeOutBreak) THEN time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)) 
					ELSE time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)-time_to_sec(TIMEDIFF(S.TimeOutBreak,S.TimeInBreak))) END) ) as undertime,
					TIME_TO_SEC(SEC_TO_TIME(sum(time_to_sec( TIMEDIFF(A.TimeOut,A.TimeIn))
					-CASE WHEN(A.TimeOut>S.TimeOutBreak) THEN time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)) 
					ELSE time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)-time_to_sec(
					TIMEDIFF(S.TimeOutBreak,S.TimeInBreak))) END) )) as cumundertime FROM AttendanceMaster A, ShiftMaster S WHERE (A.TimeIn != '00:00:00') and (S.TimeIn != '00:00:00')  AND A.OrganizationId = $orgid  AND 
					(A.TimeOut != '00:00:00') and A.EmployeeId = $empid  AND S.Id =$shiftid AND A.AttendanceDate IN(".$rangedate.")  ");
					if($row2 = $q3->row())
					{
						$data['latecoming']=substr($row2->latecoming,0,-3);
						$total=$total+$row2->cumlatecoming;
						$data['earlyleaving']=substr($row2->earlyleaving,0,-3);
						$total1=$total1+$row2->cumearlyleave;
						$data['avglog']=substr($row2->difference,0,-3);
						$total4=$total4+$row2->avgsum;
						$data['undertime']=substr($row2->undertime,0,-3);
						$total2=$total2+$row2->cumundertime;
						if($row2->undertime==''||$row2->difference==''||$row2->latecoming==''||$row2->earlyleaving=='')
						{
							$data['undertime']='00:00';
							$data['avglog']='00:00';
							$data['latecoming']='00:00';
							$data['earlyleaving']='00:00';
						}
					
					}
			
		//////////////////Average  Time Off //////////////////////////
		$q5=$this->db->query("SELECT SEC_TO_TIME(sum(TIME_TO_SEC(TIMEDIFF(T.TimeTo,T.TimeFrom)))) AS timeoff,TIME_TO_SEC(SEC_TO_TIME(sum(TIME_TO_SEC(TIMEDIFF(T.TimeTo,T.TimeFrom)))
		)) AS cumtimeoff,T.`TimeofDate` FROM Timeoff T WHERE  T.OrganizationId =$orgid  and T.`TimeofDate` IN (".$rangedate.") AND T.TimeFrom != '00:00:00' AND T.TimeTo != '00:00:00'  AND T.EmployeeId=$empid");
		
				if($row5 = $q5->row())
				{
					$data['timeoff']=substr($row5->timeoff,0,-3);
					$total3=$total3+$row5->cumtimeoff;
					if($row5->timeoff=='')
					{
					$data['timeoff']='00:00';
					}
				}
					
				
				$count++;
				$res[] = $data;
		}
					
					
			$hours 		= 	floor($total / 3600);
			$mins 		= 	floor($total / 60 % 60);
			$cumtotal	= 	sprintf('%02d:%02d',$hours,$mins);
			$total		=	$total/$count;
			$hours 		= 	floor($total / 3600);
			$mins 		= 	floor($total / 60 % 60);
			$timeFormat = 	sprintf('%02d:%02d', $hours, $mins);
			
			
			$hours 		= 	floor($total1 / 3600);
			$mins 		= 	floor($total1 / 60 % 60);
			$cumtotal1	=	sprintf('%02d:%02d', $hours, $mins);
			$total1		=	$total1/$count;
			$hours		= 	floor($total1 / 3600);
			$mins 		= 	floor($total1 / 60 % 60);
		$timeFormat1    = 	sprintf('%02d:%02d', $hours, $mins);
			
			
			$hours 		= 	floor($total2 / 3600);
			$mins 		= 	floor($total2 / 60 % 60);
			$cumtotal2 	= 	sprintf('%02d:%02d',$hours,$mins);
			$total2		=	$total2/$count;
			$hours 		= 	floor($total2 / 3600);
			$mins 		= 	floor($total2 / 60 % 60);
		$timeFormat2 	= 	sprintf('%02d:%02d', $hours, $mins);
			
			
			$hours 		= 	floor($total3 / 3600);
			$mins 		= 	floor($total3 / 60 % 60);
			$cumtotal3 	= 	sprintf('%02d:%02d', $hours, $mins);
			$total3		=	$total3/$count;
			$hours 		= 	floor($total3 / 3600);
			$mins 		= 	floor($total3 / 60 % 60);
		$timeFormat3 	= 	sprintf('%02d:%02d', $hours, $mins);
			
		
			$hours 		= 	floor($total4 / 3600);
			$mins 		= 	floor($total4 / 60 % 60);
			$cumtotal4 	= 	sprintf('%02d:%02d', $hours, $mins);
			$total4		=	$total4/$count;
			$hours 		= 	floor($total4 / 3600);
			$mins 		= 	floor($total4 / 60 % 60);
		$timeFormat4 	= 	sprintf('%02d:%02d', $hours, $mins);
		
			$list['report']=$res;
			$result[]=$list;
			$message='';
			
			foreach($result as $r)
			{
				$message ='<center>';
				$index=1;
				if(count($r['report'])>0)
				{
					$date=date('M-Y',strtotime('last day of last month'));
					$date1=date('d-M-Y');
					$message ='<center><img src="http://ubitechsolutions.com/ubitechsolutions/Mailers/ubiAttendance/ubiAttendance/logo.png" width="250px;"/></center>';
					$message.= 
					'<center><div style="width:55%;margin-bottom:5%;">
					<h3 style="color:green;padding:0px; margin:0px;">
					Attendance Monthly Averages Summary
					</h3>
					['.$date.']
					<div style="margin-top:5%;">
					<table style="border-collapse: collapse;" border width="100%"><tr style="color:#fa6804"><th>S.no</th><th style="width:25%">Employees</th><th style="width:15%;">Team’s Hours Logged</th><th style="width:15%;">Team’s Late Coming</th><th style="width:15%;">Team’s Early Leaving</th><th style="width:15%;">Team’s Time Off</th><th style="width:15%;">Team’s  Time</th></tr>';	
					foreach($r['report'] as $emp)
					{
						$message.= '<tr>
							<td align="left"  style="padding-left:1%">'.($index++).'</td>
							<td align="left" style="width:25%;padding-left:1%">'.$emp['name'].'</td>
							<td align="right" style="width:15%;padding-right:4%">'.$emp['avglog'].'</td>
							<td align="right" style="width:15%;padding-right:4%">'.$emp['latecoming'].'</td>
							<td align="right" style="width:15%;padding-right:4%">'.$emp['earlyleaving'].'</td>
							<td align="right" style="width:15%;padding-right:4%">'.$emp['timeoff'].'</td>
							<td align="right" style="width:15%;padding-right:4%">'.$emp['undertime'].'</td>
								</tr>';
					}
				$message.= '<tfoot>
				<tr style="font-weight:bold">
				<td align="right" style="padding-right:1%"></td>
				<td style="text-align:left;padding-left:1%">Team’s Total</td>
				<td align="right" style="padding-right:4%">'.$cumtotal4.'</td>
				<td align="right" style="padding-right:4%">'.$cumtotal.'</td>
				<td align="right" style="padding-right:4%">'.$cumtotal1.'</td>
				<td align="right" style="padding-right:4%">'.$cumtotal2.'</td>
				<td align="right" style="padding-right:4%">'.$cumtotal3.'</td>
				</tr>
				
				<tr style="color:#f19240;font-weight:bold">
				<td align="right" style="padding-right:1%"></td>
				<td style="text-align:left;padding-left:1%">Team’s Average</td>
				<td align="right" style="padding-right:4%">'.$timeFormat4.'</td>
				<td align="right" style="padding-right:4%">'.$timeFormat.'</td>
				<td align="right" style="padding-right:4%">'.$timeFormat1.'</td>
				<td align="right" style="padding-right:4%">'.$timeFormat2.'</td>
				<td align="right" style="padding-right:4%">'.$timeFormat3.'</td>
				</tr></tfoot>
						
				</div>
			</table>
					
			<br/><br/>
					
			<div>
				<p style="font-weight:bold;text-align:left">
				Note: Team’s Average = <span style="text-align:center;font-weight:bold">
				 Team’s Total/No. of Employees</span>
				</p>
			</div>
			
			
			<p style="text-align:left">
			Report sent on 
			<b>'.$date1.'</b> at <b>'.$time.'</b><br/>
			View more details on  <span><a href="https://ubiattendance.ubihrm.com">https://ubiattendance.ubihrm.com/</a><span></p>
			<p style="text-align:left;font-weight:bold">Cheers,<br/>
			Team ubiAttendance<br/>
			<a href="www.ubiattendance.com">www.ubiattendance.com</a><br/>
			Tel/ Whatsapp: +91 70678 22132<br/>
			Email: <a href="ubiattendance@ubitechsolutions.com">ubiattendance@ubitechsolutions.com<a><br/>
			Skype: ubitech.solutions
			</p>
			
			<p style="text-align:left;font-size:13px">You have received this email because your are a registered member on ubiAttendance App. If you do not want to receive this mailer, <a href="#">unsubscribe<a>. To make sure this email is not sent to your "junk" folder, Add “<a href="ubiattendance@ubitechsolutions.com">ubiattendance@ubitechsolutions.com</a>” to your Address Book</p>
			</div>';
				}
				
				$message.='</center>';
				sendEmail_new($r['email'],'ubiAttendance- Attendance Summary',$message,'');
				//sendEmail_new('vijay@ubitechsolutions.com','ubiAttendance- Attendance Summary',$message,'');
				sendEmail_new('parth@ubitechsolutions.com','ubiAttendance- Attendance Summary',$message,'');
				
				sendEmail_new('sohan@ubitechsolutions.com','ubiAttendance- Attendance Summary',$message,'');
				}	
				
				
			}
		}
	}
	
	
	
	///////////////////////////////////////////////////////////////////////////////
	public function sendRoutineMail(){ //vijay
			
			$startdate = date('Y-m-d', strtotime(' -2 day'));
			$enddate = date('Y-m-d', strtotime(' +2 day'));
			$data = array();
			
	//////mail triggered for the second day of first EMPLOYEE  registration
			$query = $this->db->query("SELECT C.OrganizationId as orgid, C.CreatedDate
				FROM EmployeeMaster C
				LEFT JOIN (
				SELECT A.id, IFNULL( B.id, 0 ) groupid2
				FROM EmployeeMaster A
				LEFT JOIN (
				SELECT B.id
				FROM EmployeeMaster B
				GROUP BY B.OrganizationId
				ORDER BY B.id
				)B ON A.id = B.id
				)D ON C.id = D.id
				WHERE D.groupid2 =0
				and DATE(C.CreatedDate)= Date((NOW() - INTERVAL 1 DAY))
				GROUP BY C.OrganizationId
				ORDER BY C.id"); // query for geting the second employee record from every organzation-- mail triggered for the second day of first EMPLOYEE registration
		/*	foreach ($query->result() as $row)
			{
				$to=getAdminEmail($row->orgid);
				$subject = "ubiAttendance - Track your Employees with customized Attendance Report";
					$message = "
					<html>
					<head>
					<title>ubiAttendance</title>
					</head>
					<body>
					Hello ".getAdminName($row->orgid)."<br/><br/>
					Greetings from ubiAttendance Team…!<br/>
					Congratulations! You have added Employees successfully to ubiAttendance.<br/>
					Now <b>start tracking time & attendance</b> of your Employees by following these steps:<br/>
					<ol>
						<li>
							Click on <b>Employee Reports</b> in left menu
						</li>
						<li>
							You will get multiple Employee Reports such as
							<ul>
								<li>Today’s Attendance Report</li>
								<li>Yesterday’s Attendance Report   </li>
								<li> Last 7 days Attendance Report </li>
								<li>Current Months Attendance Report</li>
								<li>Specific Days Attendance Report</li>
								<li>Late Comers Report</li>
								<li>Early Leavers Report</li>
								<li>Employees Time off Report</li>
							</ul>
						</li>
						<li>
							Click on the desired Report for summarized <b>Attendance data</b>.
						</li>
						
					</ol>
					<br/>
					<br/>
					To access all the features of ubiAttendance, upgradeto our premium plan<br/>
					<a href='https://www.youtube.com/channel/UCLplA-GWJOKZTwGlAaVKezg'>Click here</a> for our online resources. Contact support@ubitechsolutions.com for any queries.<br/><br/>
					Cheers, <br/><br/>
					Team ubiAttendance
					</body>
					</html>
					";
				//	echo $to.'--'. $message.'<br/><br/><br/>-----------<br/><br/>';
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					$headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
					mail($to,$subject,$message,$headers);
					mail('vijay@ubitechsolutions.com',$subject,$message,$headers);
					mail('parth@ubitechsolutions.com',$subject,$message,$headers);
					mail('nagendra@ubitechsolutions.com',$subject,$message,$headers);	
			}*/


				$query = $this->db->query("SELECT C.OrganizationId as orgid, C.CreatedDate
				FROM EmployeeMaster C
				LEFT JOIN (
				SELECT A.id, IFNULL( B.id, 0 ) groupid2
				FROM EmployeeMaster A
				LEFT JOIN (
				SELECT B.id
				FROM EmployeeMaster B
				GROUP BY B.OrganizationId
				ORDER BY B.id
				)B ON A.id = B.id
				)D ON C.id = D.id
				WHERE D.groupid2 =0
				and DATE(C.CreatedDate)= Date((NOW() - INTERVAL 2 DAY))
				GROUP BY C.OrganizationId
				ORDER BY C.id"); // query for geting the second employee record from every organzation-- mail triggered for the second day of first EMPLOYEE  registration /
				
				//////		mail triggered for the third day of first EMPLOYEE  registration
		/*	foreach ($query->result() as $row)
			{
				$to=getAdminEmail($row->orgid);
				$subject = "ubiAttendance–Upgrade to our Paid version";
					$message = "
					<html>
					<head>
					<title>ubiAttendance</title>
					</head>
					<body>
					Hello ".getAdminName($row->orgid)."<br/><br/>
					Greetings from ubiAttendance Team…!<br/>
					Congratulations! You have explored ubiAttendance System. Now track your Employees Attendance records efficiently & accurately with the prebuilt reports on the App. <br/>
					Now <a href='#'>subscribe to our Paid version</a> to access complete set of features& reports:<br/>
					<ol>
						<li>
							Dynamic Dashboard with <b>Graphical representation of  Attendance data</b>
						</li>
						<li>
							Attendance Records with <b>Images, Location and Time Stamp</b>
						</li>
						<li>
							<b>Edit & Delete Employee Information</b>
						</li>
						<li>
							Make <a>user status</a> Inactive
						</li>
						<li>
							<b>Give Admin Rights to user </b>for the Mobile App
						</li>
						<li>
							Generate <b>Employee QR Code Id </b>with a single click	
						</li>
						<li>
							Add & Edit <b>Departments and Designations </b>
						</li>
						<li>
							Add <b>Week Offs&Holidays</b>
						</li>
						<li>
							<b>Generate Reports</b> of - <b>Absentees, Late Comers, Early Leavers, Overtime, Under time, Time-Off </b>in Excel, PDF and CSV formats
						</li>
					</ol>
					<br/>
					<br/>
					To access all the features of ubiAttendance,<a href='#'>upgradeto our premium plan</a><br/>
					To refer to our online resources - <a href='https://www.youtube.com/channel/UCLplA-GWJOKZTwGlAaVKezg'>Click here</a>
					<br/>
					Please contact support@ubitechsolutions.com for any queries.
					
					<br/><br/>
					Cheers, <br/><br/>
					Team ubiAttendance
					</body>
					</html>
					";
				//	echo $to.'--'. $message.'<br/><br/><br/>-----------<br/><br/>';
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					$headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
					mail($to,$subject,$message,$headers);
					mail('vijay@ubitechsolutions.com',$subject,$message,$headers);
					mail('parth@ubitechsolutions.com',$subject,$message,$headers);
					mail('nagendra@ubitechsolutions.com',$subject,$message,$headers);	
			}*/
			//////		mail triggered for the third day of first EMPLOYEE  registration
	}
	public function setAdminPassword(){
		$uid=isset($_REQUEST['hasta'])?decode5t($_REQUEST['hasta']):'';
		$ctr=isset($_REQUEST['ctr'])?$_REQUEST['ctr']:0;
		$np=isset($_REQUEST['np'])?$_REQUEST['np']:'';
		$orgid=isset($_REQUEST['orgid'])?$_REQUEST['orgid']:'';
		$res=0;
	//	echo "UPDATE UserMaster SET Password='".$np."' WHERE EmployeeId=".$uid." and OrganizationId=".$orgid;
	//	return false;
		 $query = $this->db->query("UPDATE `admin_login` SET`Password`=?,resetPassCounter=resetPassCounter+1 WHERE email=? and OrganizationId=?",array(encrypt($np),$uid,$orgid));
		$res=$this->db->affected_rows();
		echo $res;
	}
	public function varify_mail_account($orgid){
		 $query = $this->db->query("UPDATE `Organization` SET `mail_varified`=1 WHERE Id=?",array($orgid));
		$res=$this->db->affected_rows();
		//$query = $this->db->query("UPDATE `UserMaster` set `archive`=1  WHERE `OrganizationId`=?",array($orgid));
		return $res;
	}
	public function clean_expired_org_data(){
		$orgList='';
		$orgids='';
		$i = 0;
		$date = date('Y-m-d h:i:s');
		$enddate = date('Y-m-d', strtotime(date('Y-m-d')." -45 day"));
		
		$query = $this->db->query("SELECT `OrganizationId` FROM `licence_ubiattendance` WHERE `end_date` <'$enddate' AND status=0 and OrganizationId not In (Select OrganizationId from licence_ubihrm)  and OrganizationId in (Select Id from Organization where ubihrm_sts=0  and cleaned_up!=1 and delete_sts!=1)");
		foreach ($query->result() as $row)
		{
			$orgid = $row->OrganizationId;
			$qry=$this->db->query("Select Name,Email FROM `Organization` WHERE Id='$orgid'");
			if($r = $qry->result())
				$orgList.= '<br/>'.$i.' <b>OrgName:</b> '.$r[0]->Name.'&nbsp;&nbsp;&nbsp;&nbsp;<b>OrgEmail:</b> '.$r[0]->Email.'&nbsp;&nbsp;&nbsp;&nbsp;OrgId:  '.$orgid;
				if($orgids=='')
					$orgids.=$row->OrganizationId;
				else
					$orgids.=','.$row->OrganizationId;
			  $i++;
		 }	
		   if($orgids != "")
		   { 
		 //	$this->db->query("Update `EmployeeMaster` set Is_Delete=2, LastModifiedDate = '$date' WHERE OrganizationId In ($orgids)");
			
			$this->db->query("DELETE FROM `AttendanceMaster` WHERE `OrganizationId` In ($orgids)");
			
			// $this->db->query("DELETE FROM `DepartmentMaster` WHERE `OrganizationId` In ($orgids)");
			
			// $this->db->query("DELETE FROM `DesignationMaster` WHERE `OrganizationId` In ($orgids)");
			
			// $this->db->query("DELETE FROM `ShiftMaster` WHERE `OrganizationId` In ($orgids)");
			
			// $this->db->query("DELETE FROM `UserMaster` WHERE `OrganizationId` In ($orgids)");
			
			// $this->db->query("DELETE FROM `Timeoff` WHERE `OrganizationId` In ($orgids)");
			
			// $this->db->query("DELETE FROM `checkin_master` WHERE `OrganizationId` In ($orgids)");
			
			// $this->db->query("Update Organization set cleaned_up=1, delete_sts=1, LastModifiedDate = '$date' WHERE `Id` In ($orgids)");
	    }
		 print_r($orgids);
		 print_r($orgList);
			 $subject='EXP_Organization data clean up list';
		
			 $headers = "MIME-Version: 1.0" . "\r\n";
			 $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			 $headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
			 sendEmail_new('sohan@ubitechsolutions.com',$subject,$orgList,$headers);
			 sendEmail_new('deeksha@ubitechsolutions.com',$subject,$orgList,$headers);
	}
	
	/*public function check_expired_org_data(){
		$orgList='';
		$i=0;
		$enddate = date('Y-m-d', strtotime(date('Y-m-d')." -90 day"));
		$query = $this->db->query("SELECT `OrganizationId` FROM `licence_ubiattendance` WHERE `end_date` <'$enddate' AND status=0 and OrganizationId not In (Select OrganizationId from licence_ubihrm)  and OrganizationId in (Select Id from Organization where ubihrm_sts=0 and cleaned_up!=1 and delete_sts!=1)");
		foreach ($query->result() as $row){
		$i++;
			$orgid = $row->OrganizationId;
			$date = date('Y-m-d h:i:s');
			$qry=$this->db->query("Select Email, Name FROM `Organization` WHERE Id='$orgid'");
			if($r = $qry->result())
				$orgList.= '<br/><br/>'.$i.' <b>OrgName:</b> '.$r[0]->Name.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      <b>OrgEmail:</b> '.$r[0]->Email.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OrgId:  '.$orgid;
		/*		
			$this->db->query("Update `EmployeeMaster` set Is_Delete=1 and LastModifiedDate = '$date' WHERE OrganizationId='$orgid'");
			
			$this->db->query("DELETE FROM `AttendanceMaster` WHERE `OrganizationId`='$orgid'");
			
			$this->db->query("DELETE FROM `DepartmentMaster` WHERE `OrganizationId`='$orgid'");
			
			$this->db->query("DELETE FROM `DesignationMaster` WHERE `OrganizationId`='$orgid'");
			
			$this->db->query("DELETE FROM `ShiftMaster` WHERE `OrganizationId`='$orgid'");
			
			$this->db->query("DELETE FROM `UserMaster` WHERE `OrganizationId`='$orgid'");
			
			$this->db->query("DELETE FROM `Timeoff` WHERE `OrganizationId`='$orgid'");
			
			$this->db->query("DELETE FROM `checkin_master` WHERE `OrganizationId`='$orgid'");
			
			$this->db->query("Update Organization set cleaned_up=1 and delete_sts=1 and LastModifiedDate = '$date' WHERE `Id`='$orgid'");
		 */
		/* }
		 print_r($orgList);
			/* $subject='EXP_Organization data clean up list';
			 $headers = "MIME-Version: 1.0" . "\r\n";
			 $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			 $headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
			 sendEmail_new('vijay@ubitechsolutions.com',$subject,$orgList,$headers);
			 sendEmail_new('deeksha@ubitechsolutions.com',$subject,$orgList,$headers);*/
	/*}*/
	public function org_user_snap(){
		// getting the list of users snap for subscribed organizations -- created by vijay
		$today=date('Y-m-d');
		$message="Dear Super admin,
		<br/>
		There is the list of registered users snap for this month as on(".date('d-m-Y').") :<br></br/>";
		$message.='<table border><th>S.No.</th><th>Company</th><th>User Limit</th><th>Registered users</th>';
		
		$query = $this->db->query("SELECT 
		licence_ubiattendance.OrganizationId,
		user_limit,
		(select count(UserMaster.Id) from  UserMaster where UserMaster.OrganizationId=licence_ubiattendance.OrganizationId) as reg_users
		from licence_ubiattendance where end_date >= '$today' AND status=1");
		$i=0;
		foreach ($query->result() as $row){
			$message.='<tr><td>'.++$i.'</td><td>'.getOrgName($row->OrganizationId).'</td><td>'.getOrgLimit($row->OrganizationId).'</td><td>'.$row->reg_users.'</td></tr>';
		}
		$message.='</table><br/><br/><b> Thanks<br/>Team ubiAttendance</b>';
		echo $message;
	//	sendEmail_new('ubiattendance@ubitechsolutions.com',"Organization User's snap",$message,'');
	//	sendEmail_new('vijay@ubitechsolutions.com',"Organization User's snap",$message,'');
		/*$headers = "MIME-Version: 1.0" . "\r\n";
			 $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			 $headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
		mail('vijay@ubitechsolutions.com',"Mail Via simple mail",$message,$headers);*/
	}
	
	/*Send mails to the trial organizations to give them the overview of attendance and encourage them to buy attendance. 
	****by deeksha****/	 
	public function sendTrialOrgMail(){ 
			$count = 0;
			$data = array();
			$query = $this->db->query("SELECT ORG.Id, DATEDIFF(CURDATE(), LIC.start_date) as days, LIC.start_date, AD.email, AD.name as contactname, ORG.Name as orgname FROM Organization ORG , licence_ubiattendance LIC, admin_login AD WHERE LIC.OrganizationId=ORG.Id AND AD.OrganizationId = ORG.Id AND AD.email=ORG.Email AND LIC.status = 0 AND ORG.mail_varified = 1 AND ORG.mail_unsubscribe = 0 AND (LIC.start_date between DATE_SUB(CURDATE(), INTERVAL 14 DAY) and CURDATE()) AND ORG.delete_sts = 0 AND DATEDIFF(CURDATE(), LIC.start_date) not in (3,5,7,9,11) order by days");
			$username="";
			$subject = '';
			$message = '';
			$year = Date("Y");
			$this->db->close();
			foreach ($query->result() as $row)
			{
				$orgid = $row->Id;
				$contactname = $row->contactname;
				$contactmail = $row->email;
				$orgname = $row->orgname;
				$days = $row->days;
				//$username = 'noreply'.$days.'@ubiattendance.com';
				$subject = '';
				$message = '';
				if($days==0){
					//$username = 'noreply2@ubiattendance.com';
					$subject = 'How ubiAttendance works?';
					$message = '<center><b style="color:#ea9800;">How ubiAttendance works?</b></center><br/>Thank you for your downloading our ubiAttendance App. Now Employees can Clock In & Clock Out through an extremely user-friendly time tracking app for marking attendance, from anywhere at anytime!<br/><ul><li>The device identifies the Employee through Email/Phone or QR code.</li><li>Users can now mark their time from the field in seconds.</li><li>The location along with the time & picture will be captured.</li><li>The Time tracking software also generates all kinds of reports for the management – Attendance records, latecomers, early leavers, over time, under time, etc.</li></ul><br/><a href="https://buy.ubiattendance.com">Buy Now!</a><br/><br/>Cheers,<br/>Team ubiAttendance<br/><a target="_blank" href="www.ubiattendance.com">www.ubiattendance.com</a><br/> 
					Tel/ Whatsapp(India): +91 70678 22132, +91 70678 35131<br/>
					Tel/ Whatsapp(Outside India): +971 50 552 4131<br/>
					Email: ubiattendance@ubitechsolutions.com<br/>
					Skype: ubitech.solutions';
				}else if($days==1){
					//$username = 'noreply2@ubiattendance.com';
					$subject = 'Wondering - How to add Employees?';
					$message = 'Greetings from ubiAttendance Team!<br/><br/>I hope your experience with the best Attendance App["'.$year.'"] was pleasant. Wondering -  How to add Employees? Check the links below.<br/><br/>Add Employees through App<br/><a target="_blank" href="https://www.youtube.com/watch?v=8ThgW8aM1C4&feature=youtu.be ">https://www.youtube.com/watch?v=8ThgW8aM1C4&feature=youtu.be</a><br/><br/>To add Bulk Employees & detailed overview of the Web Panel<br/><a target="_blank" href=" https://www.youtube.com/watch?v=8TUwLu4xXMY&feature=youtu.be"> https://www.youtube.com/watch?v=8TUwLu4xXMY&feature=youtu.be</a><br/><br/>Start tracking Employee Time Records with 100% accuracy.<br/><br/>Cheers,<br/>Team ubiAttendance<br/><a target="_blank" href="www.ubiattendance.com">www.ubiattendance.com</a><br/>Tel/ Whatsapp(India): +91 70678 22132, +91 70678 35131<br/>
					Tel/ Whatsapp(Outside India): +971 50 552 4131<br/>Email: ubiattendance@ubitechsolutions.com<br/>Skype: ubitech.solutions';
				}else if($days==2){
					$subject = 'Thanks for your interest in ubiAttendance App';
					$message = 'Greetings from ubiAttendance!<br/><br/>We thank you for showing your interest the best Time & Attendance tracking App[].<br/><br/>When is a good time to talk to you? Can we have your employee count with contact no. or skype id to understand your requirements & offer the best solution? You can call us on +91 77730 00234. You can also call us on Skype. Our Skype id is ubitech.solutions<br/><br/><a href="https://buy.ubiattendance.com">Buy Now!</a><br/><br/>Cheers,<br/>Team ubiAttendance<br/><a href="www.ubiattendance.com" target="_blank">www.ubiattendance.com</a><br/>Tel/ Whatsapp(India): +91 70678 22132, +91 70678 35131<br/>
					Tel/ Whatsapp(Outside India): +971 50 552 4131<br/>Email: ubiattendance@ubitechsolutions.com<br/>Skype: ubitech.solutions';
				}else if($days==4){
					$subject = 'No other Time tracking device offers…';
					$message = 'Greetings from ubiAttendance!<br/><br/>When you purchase ubiAttendance subscription you can be assured of<ol><li><b>Reliable & Experienced Services</b> from 18+ years, 500+ clients, 20+ Countries</li><li>Attendance tracking on <b>Computers, Android & IOS platform</b></li><li>Use along with <b>Biometric Attendance machines</b> for Complete Attendance management & Combined reporting</li><li><b>Huge Savings every month:</b> Costs only Rs. 60/employee. Save at least Rs.1000/employee/month. Pay only for what you use</li><li><b>4 way secure:</b> Login/QR Code + Time + Photo + Location. 100% stop to buddy punching</li><li><b>Highly Affordable:</b> Available on a low monthly subscription of just RS. 60/month.</li><li><b>Track from anywhere:</b> Attendance can be checked anytime, anywhere.</li><li><b>Location Reporting:</b> Track Employee locations without draining their Phone batteries</li><li><b>Powerful Reports & Graphs:</b> Track late comers, early leavers, absentees, employee’s overtime & under time</li><li><b>Scalable</b> to include leave management, payroll, timesheets & full HR management software</li></ol><br/>Don&#39;t take our word for it! Check details on <a href="https://www.ubiattendance.com/" target="_blank">https://www.ubiattendance.com/</a>   When is a good time to discuss our bulk discount offer? Hurry before you miss your chance on amazing offers.<br/><br/><u>Switch to the premium plan Now!</u><br/><br/>Cheers,<br/>Team ubiAttendance<br/><a href="www.ubiattendance.com" target="_blank">www.ubiattendance.com</a><br/> Tel/ Whatsapp(India): +91 70678 22132, +91 70678 35131<br/>
					Tel/ Whatsapp(Outside India): +971 50 552 4131<br/>Email: ubiattendance@ubitechsolutions.com<br/>Skype: ubitech.solutions';
				}else if($days==6){
					$subject = 'Listen to what our customers say';
					$message = '“UbiAttendance eases the worry of implementing our complex attendance policy.It’s sturdy, unbiased and practical.The developer has taken care of all aspects. I strongly recommend it.”<br/><br/>“My employees are afraid of coming late now and it captures the location with time and photograph, which nobody offers.”<br/><br/>“Wonderful app! I really like the reports given to the admin. Very easy to use even for people who are not tech savy. <br/><br/>“This app has automated my attendance recording process. The staff appreciates the transparency of attendance records. I can just download attendance data & BI reports on the  go! Such a help for payroll generation. The support is amazing & extremely polite. “<br/><br/>“Easy, fast n seamless......a must have app for quick management of attendance.”<br/><br/>“This app is a perfect solution for switching from manual attendance. Saves time and manpower. I found it very user friendly. Recommended for every business.”<br/><br/>“Since we have started using this app we don’t have to worry about the attendance and overtime. Thanks to ubiAttendance for helping us.”<br/><br/><u>Upgrade Now!</u><br/><br/>Cheers,<br/>Team ubiAttendance<br/><a href="www.ubiattendance.com" target="_blank">www.ubiattendance.com</a><br/>Tel/ Whatsapp(India): +91 70678 22132, +91 70678 35131<br/>
					Tel/ Whatsapp(Outside India): +971 50 552 4131<br/>Email: ubiattendance@ubitechsolutions.com<br/>Skype: ubitech.solutions';
				}else if($days==8){
					$subject = 'ubiAttendance Trial Expiry ';
					$message = 'Hello '.$contactname.',<br/><br/>We hope you are enjoying our free trial of ubiAttendance!<br/><br/>Your trial period will be over in a week. By now, you’re more than likely feeling one of these two ways:<br/><br/>HAPPY! Subscribe to the ubiAttendance Software – Just login with your email id & password (your registered phone)<br/><br/>NEED MORE TIME?  Extend your trial further by writing back to me<br/><br/>Looking forward to make ubiAttendance work for you! <a href="https://buy.ubiattendance.com">Buy Now!</a><br/><br/>Cheers,<br/>Team ubiAttendance<br/><a href="www.ubiattendance.com" target="_blank">www.ubiattendance.com</a><br/>Tel/ Whatsapp(India): +91 70678 22132, +91 70678 35131<br/>
					Tel/ Whatsapp(Outside India): +971 50 552 4131<br/>Email: ubiattendance@ubitechsolutions.com<br/>Skype: ubitech.solutions';
				}/* else if($days==10){	//commented on 11 dec 2018
					$subject = 'ubiAttendance special - 20% off on the Best Attendance App – 2018';
					$message = 'Greetings from ubiAttendance team!<br/><br/>Thanks for downloading our Attendance App.<br/><br/>We are offering <b>20% off</b> on the <b>Best 2-in-1 Time Tracker – 2018.</b> <br/><br/>Our <b>app offers fool proof attendance.</b> Check on employee hours with 100% accuracy. Convert your phone to a Biometric Time Machine. No more proxy!<br/><br/>Don’t take our word for it! Check details on <a href="https://www.ubihrm.com/attendance-app/">https://www.ubihrm.com/attendance-app/</a>! So hurry before you miss your chance on this amazing offer. When is a good time to discuss our bulk discount offer?<br/><br/><a href="https://buy.ubiattendance.com">Buy Now!</a><br/><br/>Cheers,<br/>Team ubiAttendance<br/><a href="www.ubiattendance.com" target="_blank">www.ubiattendance.com</a><br/>Tel/ Whatsapp: +91 70678 22132<br/>Email: ubiattendance@ubitechsolutions.com<br/>Skype: ubitech.solutions';
				} */else if($days==12){
					$subject = 'Top 7 benefits of our Attendance tracking App';
					$message = '<b style="color:#ea9800;">1: 4 way Check:</b> Id Check + Time + Photo + Location. Keep a check on employee hours with 100% accuracy. No more proxy!<br/><br/><b style="color:#ea9800;">2: Login with QR Code/Email/Phone no.:</b> Device indentifies employees by Email/QR code scans. Helps illiterate employees punch Time in & Time out!<br/><br/><b style="color:#ea9800;">3: Attendance anywhere:</b> Attendance can be marked anytime, anywhere – every time.Track employees from Home, Parties, Jungle, Mountains.... even when you are travelling. <br/><br/><b style="color:#ea9800;">4: Biometric based App:</b> Unlike biometric machines - installation, bug fixing & updates are free. No office space required.<br/><br/><b style="color:#ea9800;">5: Highly Affordable:</b> Budget friendly App. No cost required. Our App is subscription based. Nominally priced /Employee/Month. Pay for what you use.<br/><br/><b style="color:#ea9800;">6: For Every Industry:</b> Our Time Attendance App caters to all Industry sectors – Construction, Education, IT, Healthcare.....Start-ups, SMEs Large organizations<br/><br/><b style="color:#ea9800;">7: Insightful Reports & Graphs:</b> Track late comers, early leavers, absentees, employee’s overtime & under time with powerful reports.<br/><br/><a href="https://buy.ubiattendance.com">Buy Now!</a><br/><br/>Cheers,<br/>Team ubiAttendance<br/><a href="www.ubiattendance.com" target="_blank">www.ubiattendance.com</a><br/> Tel/ Whatsapp(India): +91 70678 22132, +91 70678 35131<br/>
					Tel/ Whatsapp(Outside India): +971 50 552 4131<br/>Email: ubiattendance@ubitechsolutions.com<br/>Skype: ubitech.solutions<br/>';
				}else if($days==13){
					//$username = 'noreply12@ubiattendance.com';
					$subject = '4 way Attendance check - Identity + Time + Photo + Location';
					$message = '<span style="color:#ea9800;">Keep a check on employee hours with 100% accuracy. No more proxy!</span><ul><li>The device identifies the Employee through Email/Phone Login or QR code.</li><li>The location, time as per the world clock & selfie will also be captured.</li><li>The Time tracking software also generates all kinds of reports for the management – they can now keep a close track on defaulters.</li></ul><br/>There is no way the managers can be fooled.  To see if our Time & Attendance application is appropriate for your business, <a href="https://buy.ubiattendance.com">Buy Now!</a><br/><br/>Cheers,<br/>Team ubiAttendance<br/><a href="www.ubiattendance.com" target="_blank">www.ubiattendance.com</a><br/>Tel/ Whatsapp(India): +91 70678 22132, +91 70678 35131<br/>
					Tel/ Whatsapp(Outside India): +971 50 552 4131<br/>Email: ubiattendance@ubitechsolutions.com<br/>Skype: ubitech.solutions';
				}else if($days==14){
					$subject = 'On Free Trial Expiry';
					$message = 'Your Free Trial for ubiAttendance has expired.<br/><br/>ubiAttendance team feels honoured that you chose ubiAttendance along with hundreds of happy App users.<br/><br/>Switch to Premium plan to<br/><ol><li>Add unlimited users</li><li>Generate Payroll</li><li>Enable attendance in Kiosk mode</li><li>Add, edit, generate QR code for bulk users </li><li>Avail powerful reports & Dashboard</li><li>Check locations punched</li><li>Geo Fencing</li><li>Export data to CSV, PDF, Excel...</li><li>Monitor attendance by departments/ Sites</li></ol><br/><a href="https://buy.ubiattendance.com">Buy Now!</a><br/><br/>Cheers,<br/>Team ubiAttendance<br/><a href="www.ubiattendance.com" target="_blank">www.ubiattendance.com</a><br/> Tel/ Whatsapp(India): +91 70678 22132, +91 70678 35131<br/>
					Tel/ Whatsapp(Outside India): +971 50 552 4131<br/>Email: ubiattendance@ubitechsolutions.com<br/>Skype: ubitech.solutions';
				}
				if($subject!='' && $message!='')
				{
				$message.='<br/><br/><br/>You are subscribed to daily Ubiattendance Alerts. Click to <a href="'.URL.'cron/unsubscribeOrgMails/'.$orgid.'" target="_top"> unsubscribe </a>';
				//sendEmail_new($contactmail,$subject,$message); 
				sendEmail_new("vanshika@ubitechsolutions.com",$subject,$message); 
				/* echo '<br/>Trial Mails<br/>';*/
				echo $message; 
				
				$count++;
				}
			}
			Trace('Today Auto Trial Mail Count'.$count);
	}
	
	 public function generateHtml(){ 
		$id = isset($_REQUEST['id'])?$_REQUEST['id']:0;
		if($id=='')
		{
			return '';
		}
		$tid = base64_decode($id);
		$html ="";
			$query = $this->db->query("SELECT p.id, p.name,p.email, p.payment_amount, p.createDate, p.tax, p.discount, p.currency, p.country, p.city, p.state, p.gstin,p.narration,p.Addon_BulkAttn,p.Addon_LocationTracking,p.Addon_VisitPunch,p.Addon_GeoFence,p.Addon_Payroll,p.Addon_TimeOff,p.due_payment,o.Address,o.Name as orgname, l.start_date, l.end_date, l.user_limit, ad.name as cname FROM `payments_invoice` p, Organization o, licence_ubiattendance l, admin_login ad where p.OrganizationId = o.Id and l.OrganizationId = o.Id and ad.OrganizationId=o.Id  and p.txnid = '$tid' order by l.Id desc limit 1");
			foreach ($query->result() as $row)
			{
				$startdate=date('y',strtotime($row->createDate));
				$enddate=$startdate+1;
				
				$startdate1=date('y',strtotime($row->createDate))-1;
				$enddate1=$startdate1+1;
				
				if(date('m',strtotime($row->createDate))<04)
				{
				$invoiceno='INVOICE NO. UBI/'.$startdate1.'-'.$enddate1.'/ATT'.$row->id;
				}
				else 
				{
				$invoiceno='INVOICE NO. UBI/'.$startdate.'-'.$enddate.'/ATT'.$row->id;	
				}
					
				$addonshtml='';
				$addonspricehtml='';
				
				if($row->due_payment != 0)
				{
					$addonshtml.='Previous Dues<br/>';
					$addonspricehtml.=number_format($row->due_payment,2).'<br/>';
				}
				if($row->Addon_BulkAttn!=0)
				{
					$addonshtml.='Bulk Attendance Addon <br/>';
					$addonspricehtml.=number_format($row->Addon_BulkAttn,2).'<br/>';
				}
				if($row->Addon_LocationTracking!=0)
				{
					$addonshtml.='Location Tracking Addon<br/>';
					$addonspricehtml.=number_format($row->Addon_LocationTracking,2).'<br/>';
				}
				if($row->Addon_VisitPunch!=0)
				{ 
					$addonshtml.='Visit Punch Addon<br/>';
					$addonspricehtml.=number_format($row->Addon_VisitPunch,2).'<br/>';
				}
				if($row->Addon_GeoFence!=0)
				{
					$addonshtml.='GeoFence Addon<br/>';
					$addonspricehtml.=number_format($row->Addon_GeoFence,2).'<br/>';
				}
				if($row->Addon_Payroll!=0)
				{
					$addonshtml.='Payroll Addon<br/>';
					$addonspricehtml.=number_format($row->Addon_Payroll,2).'<br/>';
				}
				if($row->Addon_TimeOff!=0)
				{
					$addonshtml.='TimeOff Addon<br/>';
					$addonspricehtml.=number_format($row->Addon_TimeOff,2).'<br/>';
				}
				
				
				$total=$row->payment_amount;
				$paywiddisc=(($row->payment_amount) + ($row->discount))-($row->Addon_BulkAttn+$row->Addon_LocationTracking+$row->Addon_VisitPunch+$row->Addon_GeoFence+$row->Addon_Payroll+$row->Addon_TimeOff);
				
				//$currency = ($row->currency=='INR')?'Rs.':'$';
				$currency = $row->currency.' ';
				$addr = ($row->city!='')?$row->city:$row->Address;
				/* $narration=($row->narration!="")?$row->narration:'Subscription Period: Your Subscription will end on '.date('d M, Y',strtotime($row->end_date)).'<br/>Administrator Login (1 Admin)<br/>User Logins ('.$row->user_limit.' Users)'; */
				$narration=$row->narration;
				
				$html = '<html><body style="text-align: justify;"><center><table width="100%" style="padding-top:50px;"><tr><td width="80%"><h4>Ubitech Solutions Pvt. Ltd';
				if($row->currency=='INR'){
					$html .= '<br/>D-15, Kailash Nagar, Near Prime Hospital, <br/>New City Centre, Gwalior-474011<br/>	MP, India<br/>Phone: + 91 98262 74403';
				}
				$html .= '<br/>Email: accounts@ubitechsolutions.com<br/>	GSTIN:  23AAACU9333R1ZT<br/>CIN: U72900MP2006PTC018872</h4></td><td style="float:right;"><img src="'.$_SERVER['DOCUMENT_ROOT'].'/assets/img/u-logo.png" style="width: 250px; height: 110px;"/></td></tr></table><h1>Tax Invoice</h1><table width="100%" border="1" style="border-collapse: collapse;"><tr><td><h4>INVOICE TO</h4></td><td colspan="2" style="text-align:right; padding-right:5px;border-bottom:none;">	<b>'.$invoiceno.'</b></td></tr><tr>	<td><b>'.$row->orgname.'<br/>'.$row->cname.'<br/>'.$row->email.'<br/>'.$addr.'</b>';

				if($row->currency=='INR')
				{
					$html.= '<br/><b>Place of supply: '.getName('state_gst', 'name', 'code', $row->state).'<br/>State Code: '.$row->state.'<br/>GSTIN: '.$row->gstin.'</b>';
				}
				$html.= '</td><td colspan="2" style="text-align:right; padding-right:5px; border-top:none;"><b>	'.date('M d, Y',strtotime($row->createDate)).'</b></td></tr><tr><td style="text-align:center;"> <h4>Particulars</h4> </td><td style="text-align:center;"><h4>HSN No.</h4></td><td style="text-align:center;"><h4>Amount ('.$currency.')</h4></td> </tr><tr><td  style="vertical-align:top;border-bottom: none;"><b>Premium Plan of ubiAttendance App</b><br/>'.$narration.'<br/>'.$addonshtml.'<br/></td><td style="vertical-align:top;text-align:center;border-bottom: none;"><b>998314</b>		</td>		<td style="text-align:right; padding-right:5px;border-bottom: none;"><b>'.number_format($paywiddisc,2).'</b><br/><br/><br/><b>'.$addonspricehtml.
				'</b><br/><br/><br/><br/><br/></td></tr>';
				/*in case of no discount*/
				if($row->discount > 0)
					$html .= '<tr style="border-top: none;"><td style="border-top: none;"><b>Less Discount</b><br/></td><td style="border-top: none;"></td> <td style="text-align:right; padding-right:5px;border-top: none;"><span style="color:red;"> ('.number_format($row->discount,2).')</span><br/></td></tr>';
				$html .= '<tr>		<td style="text-align:right; padding-right:5px;">			<b>Sub Total</b>		</td>		<td>				</td>		<td style="text-align:right; padding-right:5px;">			<b>'.$currency.number_format($row->payment_amount,2).'</b>		</td>	</tr>';
				/*Tax For indian currency*/
				if($row->currency=='INR'){
					/*Tax for in state*/
				if($row->state!=23){
					$tax = number_format(round(($total*18)/100, 2),2);
					$html .= '<tr>		<td style="text-align:right; padding-right:5px;">			IGST @ 18%		</td>		<td>				</td>		<td style="text-align:right; padding-right:5px;">			'.$currency.$tax.'		</td>	</tr>';
				}
				else
				{ /*Tax for out of state*/
					$tax = number_format(round(($total*9)/100, 2),2);
					$html .= '<tr>		<td style="text-align:right; padding-right:5px;">			SGST @ 9%		</td>		<td></td>		<td style="text-align:right; padding-right:5px;">			'.$currency.$tax.'		</td>	</tr><tr>		<td style="text-align:right; padding-right:5px;">			CGST @ 9%		</td>		<td>	</td>		<td style="text-align:right; padding-right:5px;">			'.$currency.$tax.'		</td></tr>	';
				}
				$total = number_format($total + round((($total*18)/100),2),2);
				}
				
				$html .= '<tr>		<td style="text-align:right; padding-right:5px;">	<b>Total</b>		</td>		<td>		</td>	<td style="text-align:right; padding-right:5px;">	<b>'.$currency.$total.'</b></td>	</tr></table></center>';
				
				/* Terms and conditions in invoice */
				$html .= '<h4 style="page-break-before: always">Sales Terms & Conditions</h4>Thank you for purchasing our services. We value your trust and assure you of the best services at all times. As our customer, when you are buying our product or service, you agree to our terms and conditions as below:<br/><ul style="font-size:15px;"><li>Ubitech Solutions provides services remotely to individuals and businesses and neither encourages nor permits any in-person visits by its experts to the customer`s location for any of the services delivered.</li><br/><br/><li>Ubitech Solutions publishes the prices for all services delivered through its subscription platform. However, at any point of time, Ubitech Solutions reserves the right to change the price of these services.</li><br/><br/><li>Ubitech Solutions reserves the right to offer special discounts on its services to customers from time to time.</li><br/><br/><li>At all times, Ubitech Solutions expects to maintain a cordial business relationship with its customers. However, if the customer comes across as being extremely unreasonable or rude with Ubitech Solutions staff or its experts, Ubitech Solutions reserves the right to cancel the order and terminate the agreement with the customer. In the event of cancellation, the Ubitech Solutions will forfeit any payment made by the Client.</li><br/><br/><li>An order once placed will not be refunded.</li><br/><br/><li>Any plan purchased will have a maximum validity of 1 year from the date of purchase. This implies the entire service under the plan shall be delivered within one year. Ubitech Solutions reserves the right to cancel the order after one year.</li><br/><br/><li>In situations where the customer purchases a plan in advance, Ubitech Solutions team shall contact the customer for order fulfillment within a reasonable timeframe before the plan expires or the deadline approaches. Customer will cooperate with Ubitech Solutions to help us deliver the services in a timely manner.</li><br/><br/><li>In situations where the service needs to be delivered before a deadline, Ubitech Solutions will clarify the estimated time required to fulfill the service to the customer. Customer is expected to cooperate with Ubitech Solutions to enable us to deliver the services in a timely manner.</li><br/><br/><li>In case of any delay in order fulfillment, Ubitech Solutions shall not bear the cost of any interest or penalty.</li><br/><br/><li>Ubitech Solutions is governed by the laws of India.</li><br/><br/><li>Ubitech Solutions reserves the right to refuse any order that it cannot deem to fulfill.</li><br/><br/><li>Ubitech Solutions will be entitled to divulge the information to those who are directly concerned or as may be necessary in order to obtain certain information necessary for the performance of his obligations.</li><br/><br/><li>Quoted price are relevant for period specified in the invoice only.</li></ul></body></html>';
		}
		return $html;
	} 
	
	public function unsubscribeOrgMails($orgid){
		
		$query = $this->db->query("UPDATE `Organization` SET `mail_unsubscribe`=1 WHERE Id=?",array($orgid));
		$res=$this->db->affected_rows();
		return $res;
	}

	/*Send mails to the organizations whose premium plan is going to expire in few days. 
	****by deeksha on 30 nov 2018****/	 
	public function sendPremiumExpMail(){ 
		$count = 0;
		$data = array();
		$query = $this->db->query("SELECT ORG.Id, DATEDIFF(LIC.end_date, CURDATE()) as days, LIC.end_date, AD.email, AD.name as contactname, ORG.Name as orgname FROM Organization ORG , licence_ubiattendance LIC, admin_login AD WHERE LIC.OrganizationId=ORG.Id AND AD.OrganizationId=ORG.Id AND AD.email=ORG.Email AND LIC.status = 1 AND ORG.mail_varified = 1 AND ORG.mail_unsubscribe = 0 AND (LIC.end_date between DATE_SUB(CURDATE(), INTERVAL 2 DAY) AND DATE_ADD(CURDATE(), INTERVAL 15 DAY)) AND ORG.delete_sts = 0 and ORG.Id not in (1074) and DATEDIFF(LIC.end_date, CURDATE()) in (-1,0,7,10,15) order by days");
		$subject = '';
		$message = '';
		$this->db->close();
		foreach ($query->result() as $row)
		{
			$orgid = $row->Id;
			$contactname = 	$row->contactname;
			$contactmail = 	$row->email;
			$orgname 	= 	$row->orgname;
			$days = $row->days;
			$subject = '';
			$message = '';
			if($days=='-1'){
				$subject = 'After Premium plan Expiry';
				$message = 'Your Premium plan for ubiAttendance has expired.
							<br/><br/>
							ubiAttendance team feels honoured that you chose ubiAttendance along with hundreds of happy App users.<br/><br/>
							<a href="'.URL.'">Update your plan</a> to continue using our App.
							<br/>
							We have continued to make ubiAttendance better & efficient based on valuable Client inputs. 
							<br/><br/>
							Cheers,<br/>
							Team ubiAttendance<br/>
							<a href="http://www.ubiattendance.com">www.ubiattendance.com</a><br/>
							Tel/ Whatsapp(India): +91 70678 22132, +91 70678 35131<br/>
							Tel/ Whatsapp(Outside India): +971 50 552 4131<br/>
							Email:<a href="mailto:ubiattendance@ubitechsolutions.com">ubiattendance@ubitechsolutions.com</a><br/>
							Skype: ubitech.solutions<br/>
							<b style="color:orange;font-style:italic">Ubitech Solutions ranked among "30 Most Trusted Software Development Companies in India"</b><br/><br/>';
			}else if($days==0){
				$subject = 'Premium Plan Expiry Mail before 24 hours!';
				$message = 'Dear '.$contactname.',<br/>
							We hope enjoyed Premium plan of ubiAttendance!<br/><br/>
							Time flies. Your plan’s subscription is over in just [24 hours]. 
							With your patronage ubiAttendance now has 30,000+ active users. Kindly renew the premium plan for continued access to powerful features of ubiAttendance App.<br/><br/>
							Got any Question?Give us a call so that our executive can also brief you of our other HR management Apps. <br/><br/><br/>
							Cheers,<br/>
							Team ubiAttendance<br/>
							<a href="http://www.ubiattendance.com">www.ubiattendance.com</a><br/>
							Tel/ Whatsapp(India): +91 70678 22132, +91 70678 35131<br/>
							Tel/ Whatsapp(Outside India): +971 50 552 4131<br/>
							Email: <a href="mailto:ubiattendance@ubitechsolutions.com">ubiattendance@ubitechsolutions.com</a><br/>
							Skype: ubitech.solutions<br/>
							<b style="color:orange;font-style:italic">Ubitech Solutions ranked among "30 Most Trusted Software Development Companies in India"</b><br/><br/>
							----------Fool proof Attendance tracking in our palm  --------';
			}else if($days==7){
				$subject = 'Premium plan Expiry';
				$message = 'Hello '.$contactname.',<br/><br/>
							Greetings from Ubitech Solutions!<br/><br/><br/>
							Thank you for subscribing to ubiAttendance App. We are very grateful that our App has 50k+ downloads & runs in 31 countries.<br/><br/>
							Kindly note that only 7 days are left before your premium plan expires.   Kindly <a href="'.URL.'">renew your plan</a> at the earliest. <br/><br/><br/> 
							Looking forward to ease HR management for you! <br/><br/>
							Cheers,<br/>
							Team ubiAttendance<br/>
							<a href="http://www.ubiattendance.com">www.ubiattendance.com</a><br/>
							Tel/ Whatsapp(India): +91 70678 22132, +91 70678 35131<br/>
					Tel/ Whatsapp(Outside India): +971 50 552 4131<br/>
							Email: <a href="mailto:ubiattendance@ubitechsolutions.com">ubiattendance@ubitechsolutions.com</a><br/>
							Skype: ubitech.solutions<br/>
							<b style="color:orange;font-style:italic">Ubitech Solutions ranked among "30 Most Trusted Software Development Companies in India"</b>';
			}else if($days==10){
				$subject = 'Update your Plan Now!';
				$message = 'Greetings from ubiAttendance Team!<br/><br/>
							Ubitech team is proud that the features & services ubiAttendance App provides are unparalled
							We have made renewal &#38; update of ubiAttendance plan easy.<br/><br/>
							You can <a href="'.URL.'">now  pay through the web Admin Panel</a>. Please feel free to contact us for any problems. <br/><br/><br/>
							Cheers,<br/>
							Team ubiAttendance<br/>
							<a href="http://www.ubiattendance.com">www.ubiattendance.com</a><br/>
							Tel/ Whatsapp(India): +91 70678 22132, +91 70678 35131<br/>
					Tel/ Whatsapp(Outside India): +971 50 552 4131<br/>
							Email: <a href="mailto:ubiattendance@ubitechsolutions.com">ubiattendance@ubitechsolutions.com</a><br/>
							Skype: ubitech.solutions<br/>
							<b style="color:orange;font-style:italic">Ubitech Solutions ranked among "30 Most Trusted Software Development Companies in India"</b><br/><br/>';
			}else if($days==15){
				$subject = 'Premium plan for ubiAttendance expires in 15 days';
				$message = 'Greetings from Ubitech Solutions!<br/><br/>
							Thank you for evaluating ubiAttendance App.<br/><br/>
							Your plan’s subscription will be over in 15 days. <a href="'.URL.'">Renew your plan</a> to avoid service disruption.<br/><br/> 
							We hope you enjoy increased productivity through our world renowned App.<br/><br/>
							Cheers,<br/>
							Team ubiAttendance<br/>
							<a href="http://www.ubiattendance.com">www.ubiattendance.com</a><br/>
							Tel/ Whatsapp(India): +91 70678 22132, +91 70678 35131<br/>
					Tel/ Whatsapp(Outside India): +971 50 552 4131<br/>
							Email: <a href="mailto:ubiattendance@ubitechsolutions.com">ubiattendance@ubitechsolutions.com</a><br/>
							Skype: ubitech.solutions<br/>
							<b style="color:orange;font-style:italic">Ubitech Solutions ranked among "30 Most Trusted Software Development Companies in India"</b>';
			}
			if($subject!='' && $message!=''){
			$message.='<br/><br/><br/>You are subscribed to daily Ubiattendance Alerts. Click to <a href="'.URL.'cron/unsubscribeOrgMails/'.$orgid.'" target="_top"> unsubscribe </a><br/>';
			//sendEmail_new($contactmail,$subject,$message); 
			sendEmail_new('vanshika@ubitechsolutions.com',$subject,$message); 
			/* sendEmail_new('deeksha@ubitechsolutions.com',$subject,$message);  */
			$count++;
			/* echo '<br/>Expiration Mails<br/>';*/
			echo $message; 
			echo $subject; 
			}
		}
		Trace('Today expiration Mail Count'.$count);
	} 
	
	/*Send mails to the organizations whose premium plan had expired and they haven't renewed it yet. 
	****by deeksha on 30 nov 2018****/	 
	public function sendMailAfterExpiry(){ 
		$count = 0;
		$data = array();
		$query = $this->db->query("SELECT ORG.Id, DATEDIFF(CURDATE(), LIC.end_date) as days, LIC.end_date, AD.email, AD.name as contactname, ORG.Name as orgname FROM Organization ORG , licence_ubiattendance LIC, admin_login AD WHERE LIC.OrganizationId=ORG.Id AND AD.OrganizationId=ORG.Id AND AD.email=ORG.Email AND LIC.status = 1 AND ORG.mail_varified = 1 AND ORG.mail_unsubscribe = 0 AND ORG.delete_sts = 0 and ORG.Id not in (1074) and (DATEDIFF(CURDATE(), end_date)%30)=0 and end_date < CURDATE() order by days");
		$subject = '';
		$message = '';
		$this->db->close();
		foreach ($query->result() as $row)
		{
			$orgid = $row->Id;
			$contactname = $row->contactname;
			$contactmail = $row->email;
			$orgname = $row->orgname;
			$days = $row->days;
				$subject = 'After Premium plan Expiry';
				$message = 'Your Premium plan for ubiAttendance has expired.
							<br/><br/>
							ubIAttendance team feels honoured that you chose ubiAttendance along with thousands of happy App users.<br/><br/>
							We have continued to make ubiAttendance better & efficient based on valuable Client inputs. <br/><br/>
							<a href="'.URL.'">Update your plan</a> to continue using our app. <br/><br/><br/>
							Cheers,<br/>
							Team ubiAttendance<br/>
							<a href="http://www.ubiattendance.com">www.ubiattendance.com</a><br/>
							Tel/ Whatsapp(India): +91 70678 22132, +91 70678 35131<br/>
							Tel/ Whatsapp(Outside India): +971 50 552 4131<br/>
							Email: <a href="mailto:ubiattendance@ubitechsolutions.com">ubiattendance@ubitechsolutions.com</a><br/>
							Skype: ubitech.solutions<br/>
							<b style="color:orange;font-style:italic">Ubitech Solutions ranked among "30 Most Trusted Software Development Companies in India"</b><br/><br/>';
			
			$message.='<br/><br/><br/>You are subscribed to daily Ubiattendance Alerts. Click to <a href="'.URL.'cron/unsubscribeOrgMails/'.$orgid.'" target="_top"> unsubscribe </a><br/>';
			//sendEmail_new($contactmail,$subject,$message); 
			/* sendEmail_new('deeksha@ubitechsolutions.com',$subject,$message); */
			 sendEmail_new('vanshika@ubitechsolutions.com',$subject,$message); 
			$count++;
			/* echo '<br/>After Expiry Mails<br/>';*/
			echo $message; 
			
		}
		Trace('Today expiration Mail Count'.$count);
	} 
	
	/*Send mails to the organizations who have not verified there mail Ids 
	****by deeksha on 30 nov 2018****/
	public function sendVerificationMails(){ 
		$count = 0;
		$data = array();//substring_index(ad.name, " ", 1) as Name
		$query = $this->db->query("SELECT  org.Id as orgid, org.Email as email, ad.name as Name, DATEDIFF(CURDATE(), lic.start_date) as days,  DATEDIFF(lic.end_date, lic.start_date) as trialdays,lic.start_date, org.mail_varified FROM Organization org, licence_ubiattendance lic, admin_login ad WHERE org.Id=lic.OrganizationId and ad.OrganizationId=org.Id and org.mail_unsubscribe=0 and org.delete_sts=0 and org.mail_varified=0 and DATEDIFF(CURDATE(), lic.start_date) in (2,5,10)");
		$subject = '';
		$message = '';
		$this->db->close();
		foreach ($query->result() as $row)
		{
			$orgid = $row->orgid;
			$contactmail = $row->email;
			$contact_person_name = $row->Name;
			$days = $row->days;
			$trialdays = $row->trialdays;
			/* $subject = '';
			$message = ''; */
			
				$subject = 'UbiAttendance- Account verification';
				$message = '<html>
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
							  color:#606060;text-align:center;">Welcome - now let&#39;s get started!<br/>
							  </p>  	
								<p style="font-size:14.0pt;font-family:Helvetica,sans-serif;
							  color:#606060;text-align:center;">
								<a href="https://ubiattendance.ubihrm.com/index.php/services/activateOrgAccount?iuser='.encrypt($orgid).'">Verify now to start your trial</a>
								</p>
							
								<div align=center>
							  <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
							   width="550" style="width:550px;border-collapse:collapse">
							   <tr>
								<td align="center" style="padding:0in 0in 0in 0in">
								<a href="https://ubiattendance.ubihrm.com/index.php/services/activateOrgAccount?iuser='.encrypt($orgid).'" target="_blank" style="font-size:20px;font-family:Helvetica,sans-serif;color:white;text-decoration:none">
								<p class=MsoNormal align=center style="margin-bottom:0in;								margin-bottom:.0001pt;text-align:center;line-height:normal; background:#52bad5;width: 250px;padding: 15px;">Verify your Account</span></b></span></p></a>
								</td>
							   </tr>
							  </table>
							  </div>
								<span
							  style="font-size:14.0pt;font-family:Helvetica,sans-serif;
							  color:#606060">
							  
							 <br/> Hello '.$contact_person_name.',
							  
								</span></b>
								<p style="text-align: left;" class="paragraph-text">
								Thanks for trying ubiAttendance. You&#39;re going to love it.<br/><br/>
								First thing&#39;s first:  <a href="https://ubiattendance.ubihrm.com/index.php/services/activateOrgAccount?iuser='.encrypt($orgid).'">Verify your Account</a> to start exploring our world class App. Enjoy your '.$trialdays.'-day trial to your heart&#39;s content!<br/><br/><br/>Need more help?  <a href="mailto:ubiattendance@ubitechsolutions.com">Contact us</a> or <a target="_blank" href="https://www.youtube.com/channel/UCLplA-GWJOKZTwGlAaVKezg">View our Channel</a> and learn about key features and best practices.
								</p>
								
							  </p>
							  </td>

							 </tr>
							 <tr>
							 
							 </tr>
							 <tr>
							  <td valign=top style="padding:0in 0in 2.7pt 0in">
									Cheers,<br/>Team ubiAttendance<br/><a href="http://www.ubiattendance.com/" target="_blank">www.ubiattendance.com</a><br/> 
									Tel/ Whatsapp(India): +91 70678 22132, +91 70678 35131<br/>
									Tel/ Whatsapp(Outside India): +971 50 552 4131<br/>Email: ubiattendance@ubitechsolutions.com<br/>Skype: ubitech.solutions
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
						<br/><br/><br/>You are subscribed to daily Ubiattendance Alerts. Click to <a href="'.URL.'cron/unsubscribeOrgMails/'.$orgid.'" target="_top"> unsubscribe </a>
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
		//	sendEmail_new($contactmail,$subject,$message);
			sendEmail_new('vanshika@ubitechsolutions.com',$subject,$message);
			/* sendEmail_new('deeksha@ubitechsolutions.com',$subject,$message); */
			/* echo '<br/>Verification Mails<br/>';
			echo $message; */
		}
	} 
	/*Send mails who have add extra users than assigned and have to pay due amount 
	****by deeksha on 30 nov 2018****/
	public function exceedUserAlert(){ 
		$count = 0;
		$data = array();
		$query = $this->db->query("Select org.Id as orgid,org.Name as orgname, ad.name as contactname, ad.email as email, org.NoOfEmp as ulimit, (select count(Id) from UserMaster where OrganizationId=org.Id) as totalusers,lic.start_date, lic.end_date, org.Country as country, lic.due_amount as due from Organization org, licence_ubiattendance lic, admin_login ad where org.Id=lic.OrganizationId and org.Id = ad.OrganizationId and lic.status=1 and org.mail_unsubscribe=0 and (select count(Id) from UserMaster where OrganizationId=org.Id) > org.NoOfEmp");
		foreach ($query->result() as $row)
		{
			$org_id = $row->orgid;
			$contactmail = $row->email;
			$orgname = $row->orgname;
			$contact_person_name = $row->contactname;
			$sdate = $row->start_date;
			$edate = $row->end_date;
			$currency=	$row->country==93?'INR':'USD';
			$subject = "Dear ".$contact_person_name.", your User Limit has exceeded.";
			$due=$row->due;
			$aduser=($row->totalusers)-($row->ulimit);
			if(($currency=='INR' && $due > 500) || ($currency=='USD' && $due > 10)){ /*mail will be sent when due is greater tha either 500 INR or 10 USD*/
			$message = "<div style='color:black'>
					Greetings from ubiAttendance App<br/><br/>
					The no. of users in your ubiAttendance Plan have exceeded. Below are the payment details for additional Users. <br/>
					<h4 style='color:blue'>Plan Details:</h4>
					Company : ".$orgname."<br/>
					Plan Start Date:".date('d-M-Y',strtotime($sdate))."<br/>
					Plan End Date:".date('d-M-Y',strtotime($edate))."<br/>
					User limit: ".$row->ulimit."<br/>
				    Registered Users: ".$row->totalusers."<br/>
				    Additional Users: ".$aduser."<br/>
					<br/>
					<h4 style='color:blue'>Billing Details:</h4>
					Amount Payable: ".$row->due." ".$currency." <br/>
					<br/>
					<a href='".URL."'>Update your plan now</a> so that there is no disruption in our services<br/><br/>
					Cheers,<br/>
					Team ubiAttendance<br/><a target='_blank' href='http://www.ubiattendance.com'>www.ubiattendance.com</a><br/> 
					Tel/ Whatsapp(India): +91 70678 22132, +91 70678 35131<br/>
					Tel/ Whatsapp(Outside India): +971 50 552 4131<br/>Email: ubiattendance@ubitechsolutions.com<br/>Skype: ubitech.solutions</div>";
			//sendEmail_new($contactmail,$subject,$message); 
			sendEmail_new('vanshika@ubitechsolutions.com',$subject,$message); 
			/* sendEmail_new('deeksha@ubitechsolutions.com',$subject,$message); */
			/* echo '<br/>Exceed User limit Mails<br/>';*/
			echo $message; 
			//echo $subject; 
			}
		}
		$this->db->close();
	} 
	/*get employees whose timein timeout locations are outside of assigned area*/
	public function getOutsideLocations(){/*Not in use for now*/
		$result = array();
		$sql = $this->db->query("SELECT Id FROM `Organization` WHERE Id not in (1074) AND mail_unsubscribe = 0 and Id in (select OrganizationId from licence_ubiattendance where status=1)");// 1074 is erawan,
			foreach($sql->result() as $row){
				$orgid = $row->Id;
				$zone=getTimeZone($orgid);
				date_default_timezone_set($zone);
				$date=date('Y-m-d',strtotime('-1 day'));
				$list=array();
				$list['orgid']=$orgid;
				$list['admin']=getAdminName($orgid);
				$list['email']=getAdminEmail($orgid);
				$list['date']=$date;
				$q2="SELECT A.Id, A.EmployeeId, E.FirstName, E.LastName, A.AttendanceDate as date, A.AttendanceStatus, A.TimeIn, A.TimeOut, A.ShiftId, A.Overtime,A.EntryImage, A.ExitImage,A.latit_in,A.longi_in,A.longi_out,A.latit_out, A.checkInLoc, A.CheckOutLoc,A.areaId, G.Lat_Long, G.Radius FROM AttendanceMaster A, Geo_Settings G, EmployeeMaster E WHERE A.OrganizationId=".$orgid." and G.OrganizationId = ".$orgid." and E.OrganizationId = ".$orgid." and A.AttendanceDate='".$date."' and A.TimeIn!='00:00' and A.areaId!=0 and G.Id=A.areaId and E.Id= A.EmployeeId order by A.AttendanceDate Desc";
				$query = $this->db->query($q2);
					$res=array();
					foreach($query->result() as $row){
						$res1=array();
						$res1['Name']=$row->FirstName." ".$row->LastName;	
						$res1['ti']=substr($row->TimeIn,0,5);
						$res1['to']=substr($row->TimeOut,0,5);
						$res1['positionlin']="";
						$res1['positionout']="";
						$res1['latit_in']=$row->latit_in;
						$res1['latit_out']=$row->latit_out;
						$lat_lang = $row->Lat_Long;
						$radius = $row->Radius;
						$arr1 = explode(",",$lat_lang);
						if(count($arr1)>1){
							$a=floatval($arr1[0]);
							$b=floatval($arr1[1]);
							$d1 = $this->distance($a,$b, $row->latit_in, $row->longi_in, "K");
							$d2 = $this->distance($a,$b, $row->latit_out, $row->longi_out, "K");
							if($row->latit_in!='0.0' && $row->latit_in!='0'){
								if($d1 <= $radius){
									$res1['positionlin'] = '';
								}else{
									$res1['positionlin'] ='<span style=background-color="red"> - Outside the Location </span>';
								}
							}
							if($row->latit_out!='0.0' && $row->latit_out!='0'){
								if($d2 <= $radius){
									$res1['positionout'] = '';
								}else{
									$res1['positionout'] ='<span style=background-color="red"> - Outside the Location </span>';
								}
							}
						}
						
						if($res1['positionout']!='' || $res1['positionlin']!=''){
							if($res1['positionout']=='' && $res1['to']!='00:00')
								$res1['positionout']='<span style=background-color="green"> - Within the location </span>';
							if($res1['positionlin']=='')
								$res1['positionlin']='<span style=background-color="green"> - Within the location </span>';
							$res[] = $res1;
						}
					}
					$list['emplist']=$res;
					if($list['emplist']){
						$result[]=$list;
					}
			}
			$this->db->close();	
			$message='';		
		//print_r($result);
		foreach($result as $r){
			//print_r($r);
			$message ='<div align="center"><div style="width:80%;"><center><img src="http://ubitechsolutions.com/ubitechsolutions/Mailers/ubiAttendance/ubiAttendance/logo.png" width="250px;"/></center>';
			$message.='<center>Geo Fence Update:'.date('D d F, Y',strtotime($r['date'])).'<br/><br/><br/>';
			$message.= '<div><span style="color:#0193ab;"><u>Attendance Marked outside the Fenced Area*</u></span><br/><br/>
						<table style="border-collapse: collapse;" border width="100%"><tr><th>Employee</th><th>Time In</th><th>Time Out</th></tr>';
				foreach($r['emplist'] as $emp){
					$message.= '<tr><td align="center">'.$emp['Name'].'</td><td align="center">'.$emp['ti'].$emp['positionlin'].'</td><td align="center">'.$emp['to'].$emp['positionout'].'</td></tr>';
				}
			$message.='</table></div>';
			$message.='</center>';
			$message.='<br/><div align="justify">View Detailed Report at – <a href="'.URL.'">'.URL.'</a>';
			$message.='<br/><br/><br/>You are subscribed to daily Ubiattendance Alerts. Click to <a href="'.URL.'cron/unsubscribeOrgMails/'.$r['orgid'].'" target="_top"> unsubscribe </a>';
			$message.='<br/><br/><br/>Cheers,<br/>Team ubiAttendance<br/><a href="www.ubiattendance.com" target="_blank">www.ubiattendance.com</a><br/> Tel/ Whatsapp: +91 70678 22132<br/>Email: ubiattendance@ubitechsolutions.com<br/>Skype: ubitech.solutions';
			$message.='<br/><br/><br/><span style="font-size:11px;font-style: italic;">* Disclaimer: These GPS data files are made available with the understanding that data is provided with no warranties, expressed or implied, concerning data accuracy, completeness, reliability, or suitability. Ubitech Solutions’ service shall not be liable regardless of the cause or duration, for any errors, inaccuracies, omissions, or other defects in, or untimeliness or unauthenticity of, the Information, or for any delay or interruption in the transmission thereof to the user, or for any Claims or Losses arising therefrom or occasioned thereby. The end user assumes the entire risk as to the quality of the data.Although every effort has been made to ensure the correctness and accuracy of the GPS Dataset, the Supplier makes no representations, either express or implied, as to the accuracy, currency, completeness or suitability for any particular purpose of the information and accepts no liability for any use of the GPS Dataset or any responsibility for any reliance placed on that information. The user acknowledges that the Dataset cannot be guaranteed error free and that use of the Dataset is at the user’s sole risk and that the information contained in the Dataset may be subject to change without notice.</span><br/></div></div></div>';
			sendEmail_new('deeksha@ubitechsolutions.com','Geo Fence Update Alert',$message,'');
		} 
		//mail('deeksha@ubitechsolutions.com','Geo Fence Update Alert Cron','Geo Fence Update Alert Cron run');
	}
	
 public function distance($lat1, $lon1, $lat2, $lon2, $unit) {
	  $theta = $lon1 - $lon2;
	  $dist = sin(deg2rad((float)$lat1)) * sin(deg2rad((float) $lat2)) +  cos(deg2rad((float) $lat1)) * cos(deg2rad((float) $lat2)) * cos(deg2rad((float) $theta));
	  $dist = acos($dist);
	  $dist = rad2deg($dist);
	  $miles = $dist * 60 * 1.1515;
	  $unit = strtoupper($unit);

	  if ($unit == "K") {
		return ($miles * 1.609344);
	  } else if ($unit == "N") {
		  return ($miles * 0.8684);
		} else {
			return $miles;
		  }
}
public function sendMailAWS(){
	$json_arr[0] = json_decode(file_get_contents('php://input'), true);
	$arrval=json_encode($json_arr);
	Trace($arrval);
	$arr = array();
	$i=0;
	foreach ($json_arr[0] as $key => $values){
		$arr[$i] = $values;
		$i++;
	}
	$to		=	isset($arr[0])	?	$arr[0]	:"";
	$subject		=		isset($arr[1])	?	$arr[1]	:"";
	$msg		=		isset($arr[2])	?	$arr[2]	:"";
	//Trace('To:   '.$to);
	//Trace($subject);
	//Trace($msg);
	sendEmail_new($to,$subject,$msg);
	return true;
}
	
public function sendAutoMailAWS(){
		 $json_arr[0] = json_decode(file_get_contents('php://input'), true);
		 $arrval=json_encode($json_arr);
		 Trace($arrval);
		 $arr = array();
		 $i=0;
		foreach ($json_arr[0] as $key => $values){
			$arr[$i] = $values;
			$i++;
		}
		$to		=	isset($arr[0])	?	$arr[0]	:"";
		$subject		=		isset($arr[1])	?	$arr[1]	:"";
		$msg		=		isset($arr[2])	?	$arr[2]	:"";
		$userName		=		isset($arr[3])	?	$arr[3]	:"";
		//Trace('To:   '.$to);
		//Trace($subject);
		//Trace($msg);
	sendAutoMail($to,$subject,$msg,'',$userName);
	return true;
}
    /////// get last week//////////
			function getStartAndEndDate() 
			{
			//$year1=date('Y-m-d');
			$week= date('W', strtotime( 'last week' ));
			//$year= Date("Y",  strtotime('-7 day', strtotime($year1)));
			$year=date('Y');
			$dateTime = new DateTime();
			$dateTime->setISODate($year,$week);
			$result['start_date'] = $dateTime->format('d-M-Y');
			$dateTime->modify('+6 days');
			$result['end_date'] = $dateTime->format('d-M-Y');
			return $result;
			}
			public function getWorkingDays($shiftid,$date,$org_id)
	       {
			//$org_id = isset($_SESSION['orgid'])?$_SESSION['orgid']:0;
			$weekOfMonth = ceil(date( 'j', strtotime( $date ) ) / 7 );
			$count = 0;
			$query = $this->db->query("SELECT WeekOff FROM  ShiftMasterChild WHERE  OrganizationId = ? AND  ShiftId =  ?" , 
			array($org_id,$shiftid));
			foreach($query->result() as $row)
			{
				$week='';
				$week =explode(",",$row->WeekOff);
				if($week[$weekOfMonth-1]==0)
				$count++;	
			} 
				return $count;
				
		}
        ////get last month///////////
			function  getStartAndEndDate1()
			{
			$firstday=date('Y-m-d', strtotime('first day of last month'));
			$lastday=date('Y-m-d', strtotime('last day of last month'));
			$result['start_date'] = $firstday;
			$result['end_date'] = $lastday;
			return $result;
			}		
	/*	function  testorientation()
			{
			correctImageOrientation('uploads/4141_28062019_111200.jpg');
			echo '<img src="http://192.168.0.200/ubiattendance/uploads/4141_28062019_111200.jpg">';
			}	*/
			
			
			/*Cron Function to delete attendances before 3 months and save into archivedattendance table
				by Deeksha on 6 july 2019*/
	public function archiveattendances()
	{
		  //// OrganizationId (1074) not for erawan
		$query = $this->db->query("INSERT INTO `ArchiveAttendanceMaster`(`Id`, `EmployeeId`, `AttendanceDate`, `AttendanceStatus`, `TimeIn`, `TimeOut`, `ShiftId`, `Dept_id`, `Desg_id`, `areaId`, `OrganizationId`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `OwnerId`, `Overtime`, `device`, `TimeinIp`, `TimeoutIp`, `EntryImage`, `ExitImage`, `checkInLoc`, `CheckOutLoc`, `timebreak`, `timeindate`, `timeoutdate`, `latit_in`, `longi_in`, `latit_out`, `longi_out`, `HourlyRateId`, `remarks`, `remark`, `manual_status`, `manual_action`, `Is_Delete`, `Deleted_Date`, `RegularizeSts`, `ApproverId`, `RegularizationRemarks`, `RegularizeRequestDate`, `RegularizeTimeOut`, `RegularizeApproverRemarks`, `RegularizeApprovalDate`, `RegularizeTimeIn`) SELECT `Id`, `EmployeeId`, `AttendanceDate`, `AttendanceStatus`, `TimeIn`, `TimeOut`, `ShiftId`, `Dept_id`, `Desg_id`, `areaId`, `OrganizationId`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `OwnerId`, `Overtime`, `device`, `TimeinIp`, `TimeoutIp`, `EntryImage`, `ExitImage`, `checkInLoc`, `CheckOutLoc`, `timebreak`, `timeindate`, `timeoutdate`, `latit_in`, `longi_in`, `latit_out`, `longi_out`, `HourlyRateId`, `remarks`, `remark`, `manual_status`, `manual_action`, `Is_Delete`, `Deleted_Date`, `RegularizeSts`, `ApproverId`, `RegularizationRemarks`, `RegularizeRequestDate`, `RegularizeTimeOut`, `RegularizeApproverRemarks`, `RegularizeApprovalDate`, `RegularizeTimeIn` FROM `AttendanceMaster` WHERE  OrganizationId != 1074 AND `AttendanceDate` < (select (last_day(now()) + interval 1 day - interval 4 month) as  sdate)");
		$query1 = $this->db->query("Delete from AttendanceMaster where OrganizationId != 1074 AND  `AttendanceDate` < (select (last_day(now()) + interval 1 day - interval 4 month) as  sdate)");
			 $subject='Attendance Archived Cron';
			 $message='Attendance Archived Cron run Successfully';
			sendEmail_new('deeksha@ubitechsolutions.com',$subject,$message);
	}
	
	public function sendMailBeforeCleanedup(){ 
		$count = 0;
		$data = array();
		$date = date('Y-m-d h:i:s');
		$enddate = date('Y-m-d', strtotime(date('Y-m-d')." -44 day"));
		$query = $this->db->query("SELECT `OrganizationId` FROM `licence_ubiattendance` WHERE `end_date` <'$enddate' AND status=0 and OrganizationId not In (Select OrganizationId from licence_ubihrm)  and OrganizationId in (Select Id from Organization where ubihrm_sts=0  and cleaned_up!=1 and delete_sts!=1)");
		$subject = '';
		$message = '';
		$this->db->close();
		foreach ($query->result() as $row)
		{
			$orgid = $row->OrganizationId;
			//$contactmail = 	$row->email;
			//$orgname 	= 	$row->Name;
			//$days = $row->days;
			$subject = 'ok';
			$message = 'okk';
			
			if($subject!='' && $message!=''){
			$message.='<br/><br/><br/>You are subscribed to daily Ubiattendance Alerts. Click to <a href="'.URL.'cron/unsubscribeOrgMails/'.$orgid.'" target="_top"> unsubscribe </a><br/>';
			//sendEmail_new($contactmail,$subject,$message); 
			sendEmail_new('vanshika@ubitechsolutions.com',$subject,$message); 
			/* sendEmail_new('deeksha@ubitechsolutions.com',$subject,$message);  */
			$count++;
			/* echo '<br/>Expiration Mails<br/>';*/
			echo $message; 
			echo $subject; 
			}
		}
		Trace('Today expiration Mail Count'.$count);
	} 
	
}
?>
