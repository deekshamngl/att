<?php
class Login_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
		include(APPPATH."PhpMailer/class.phpmailer.php");
    }

    /*  public function get_last_ten_entries()
        {
                $query = $this->db->get('entries', 10);
                return $query->result();
        }
        public function insert_entry()
        {
                $this->title    = $_POST['title']; // please read the below note
                $this->content  = $_POST['content'];
                $this->date     = time();
                $this->db->insert('entries', $this);
        }
        public function update_entry()
        {
                $this->title    = $_POST['title'];
                $this->content  = $_POST['content'];
                $this->date     = time();
                $this->db->update('entries', $this, array('id' => $_POST['id']));
        }	 
    */
	
 public function addAlert()
 {
 	$orgid = $_SESSION['orgid'];
	$todate = date('Y-m-d');
	$time = isset($_REQUEST['time'])?$_REQUEST['time']:'';
	$sts = isset($_REQUEST['sts'])?$_REQUEST['sts']:'';
	$this->db->query("INSERT INTO `Alert_Settings`(`OrganizationId`,`Status`,`Time`,`Created_Date`) VALUES ('$orgid','$sts','$time','$todate') ON DUPLICATE KEY UPDATE Status='$sts',Time='$time'");
}
 public function getactiveStatus(){
 	$orgid = $_SESSION['orgid'];
 	$sql = $this->db->query("select * FROM Alert_Settings WHERE OrganizationId='$orgid'");
 	 return $sql->result();
 }

public function forgotpswd()
       {
			//$org_id = $_SESSION['orgid'];
			$email=isset($_REQUEST['email'])?$_REQUEST['email']:'';
			//$zone=getTimeZone($org_id);
            //   date_default_timezone_set($zone);
            $query = $this->db->query("SELECT * FROM admin_login WHERE email= ? ", array($email));
			 if ($query->num_rows()>0){
				 if($row=$query->result()){	
				   $message="<html>
						<head>
						<title>ubiAttendance</title>
						</head>
						<body>
						<p>
						Your password reset link for ubiAttendance Web Admin Panel is <a href='".URL."cron/ijlprapfcb?ui=".encode5t($row[0]->email)."&ctr=".$row[0]->resetPassCounter."&orgid=".$row[0]->OrganizationId."'> here  </a>
					   </p>
					   <h5>Cheers</h5>
					   <h5> Team ubiAttendance </h5>
					   </body>
					   </html>
					   ";
				    $headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// More headers
					$headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
					//$headers .= 'Cc: vijay@ubitechsolutions.com' . "\r\n";
					$subject ="ubiAttendance- password reset link.";
					sendEmail_new($email,$subject,$message);
					sendEmail_new('vijay@ubitechsolutions.com',$subject,$message);	echo 2;
				 }
			 }
			 else
				 echo 0;	
		}

    public function getloggedEmp()
	{
	$orgid = $_SESSION['orgid'];
	$zname=getTimeZone($orgid);
	date_default_timezone_set ($zname);
	$todate = date('Y-m-d');//'2018-07-09';
	$data = array();
	$res = array();
	$sql = $this->db->query("SELECT Id,Name FROM DepartmentMaster WHERE OrganizationId='$orgid' AND archive = 1 ");    
	foreach($sql->result() as $rows){
		$data['id'] = $rows->Id;
		$id = $rows->Id;
		$data['name'] = $rows->Name;
		
		$sql1 = $this->db->query("SELECT count(Id)as totalEmp FROM AttendanceMaster WHERE AttendanceDate='$todate'  and EmployeeId IN (SELECT Id FROM EmployeeMaster WHERE OrganizationId=$orgid AND Department=$id AND DOL = '0000-00-00' AND Is_Delete = 0 )");
		
		if($row =  $sql1->result()){
			$data['totalemp'] = $row[0]->totalEmp;
		}
		$sql2 = $this->db->query("SELECT count(Id) as allEmp FROM EmployeeMaster WHERE OrganizationId=$orgid AND Department=$id   AND DOL = '0000-00-00' AND Is_Delete = '0' ");
		if($row1 = $sql2->result()){
			$data['allemp'] = $row1[0]->allEmp;
		}
		$res[] = $data;
	}
	 return $res;
}



		public function login()
		{			
			$username=isset($_REQUEST['username'])?$_REQUEST['username']:'';
			$remmberme=isset($_REQUEST['remmberme'])?$_REQUEST['remmberme']:'';
			$password=encrypt(isset($_REQUEST['password'])?$_REQUEST['password']:'');
			
			//echo "SELECT A.id,A.name ,A.OrganizationId,end_date,L.status FROM admin_login A,licence_ubiattendance L WHERE A.username= '$username' and A.password='$password' and A.archive='1' and A.OrganizationId=L.OrganizationId";
			
			$query = $this->db->query("SELECT A.id,A.name ,A.OrganizationId,end_date,L.status FROM admin_login A,licence_ubiattendance L WHERE A.username= ? and A.password=? and A.archive='1' and A.OrganizationId=L.OrganizationId", array($username,$password));
			
			if ($row=$query->result())
			{
				$_SESSION['p_status'] = $row[0]->status;// lic master 0 trial/ 1 paid
				$_SESSION['orgName']=getOrgName($row[0]->OrganizationId);	
				$_SESSION['Email']=getAdminEmail($row[0]->OrganizationId);
				$_SESSION['attendanceAdmin']=true;
				$_SESSION['orgid']=$row[0]->OrganizationId;
				$_SESSION['id']=$row[0]->id;
				$_SESSION['name']=ucfirst($row[0]->name);
				$_SESSION['specialCase']= $row[0]->OrganizationId==502?'RAKP':'common';
				
				$today = date('Y-m-d');
				$last_date = $row[0]->end_date; 		// lic master
				if($today > $last_date){
					$_SESSION['expirydate'] = 1;// admin out of expiry date
					return 1;
				}
				else{
					$_SESSION['expirydate'] = 0; // admin with in expiry date-- valid case
					return 2;
				}
			}else 
				return 0;
			/*
			$query22 = $this->db->query("SELECT * FROM admin_login WHERE username= ? and password=?", array($username,$password));
			 if ($query22->num_rows()){
				$row22 = $query22->row();
				$OrganizationId = $row22->OrganizationId;
				$query11 = $this->db->query("SELECT * FROM  licence_ubiattendance where OrganizationId =$OrganizationId");
			    $row11 = $query11->row();
                $last_date = $row11->end_date;
                $p_status = $row11->status;
			    $today = date('Y-m-d');
				
				
			 }else
				 return 0;	
			// to get an organization name (start) ///
			$query44 = $this->db->query("SELECT * FROM Organization where id =$OrganizationId ");
			$row44 = $query44->row();
			$num44 = $query44->num_rows();
			if($num44 > 0){
			$_SESSION['orgName']=$row44->Name;	
			$_SESSION['Email']=$row44->Email;	
			}
			// to get an organization name (end) ///
			 $query = $this->db->query("SELECT * FROM admin_login WHERE username= ? and password=? and archive='1'", array($username,$password));
		    
			if ($row=$query->result())
			{    
					$_SESSION['p_status']=$p_status;
					$_SESSION['attendanceAdmin']=true;
					$_SESSION['orgid']=$row[0]->OrganizationId;
					$_SESSION['id']=$row[0]->id;
					$_SESSION['name']=ucfirst($row[0]->name);
					$_SESSION['specialCase']= $row[0]->OrganizationId==502?'RAKP':'common';
					if($today > $last_date)
						$_SESSION['expirydate'] = 1;// admin out of expiry date
					else
						$_SESSION['expirydate'] = 0; // admin with in expiry date
				 return 1;
			 }
				 return 0;
				 */
		}
		
		public function getDashboadAttendance($data){
			
            $fromDate = date('Y-m-d', strtotime('-7 days', strtotime($data)));
             $data1=array();  
            
             $id = $_SESSION['orgid'];
              $query = $this->db->query("select count(AttendanceDate) as total,AttendanceDate from AttendanceMaster where OrganizationId =$id and (AttendanceDate BETWEEN '$fromDate' AND '$data') group by AttendanceDate");
             
            // echo  $query->result();
               $data1['result'] =  json_encode($query->result());
		$query = $this->db->query("SELECT count(Id) as maxemp FROM `UserMaster` WHERE `OrganizationId`=$id");
		 $data1['maxemp'] =  json_encode($query->result());
		  $this->db->close();
              echo json_encode( $data1);
			  
		}
		public function getMonthlyAttChart(){
			
             
              $id = $_SESSION['orgid'];
              $query = $this->db->query("SELECT count(id) as total ,MONTH(`AttendanceDate`) as month  FROM `AttendanceMaster` where YEAR(CURDATE())=YEAR(AttendanceDate) and MONTH(AttendanceDate)>7 and `OrganizationId`=$id group by MONTH(`AttendanceDate`)");
			   $this->db->close();
              echo json_encode($query->result_array());
			  
		}
		public function getCompanydetail(){
			$result=array();
			$res=array();
			$id = $_SESSION['orgid'];
			$query = $this->db->query("SELECT * FROM Organization where id =$id");
			foreach ($query->result_array() as $row)
			{
				$res['Name'] =   $row['Name'];
				$res['Website'] = 	 $row['Website'];
				$res['PhoneNumber'] = 	 $row['PhoneNumber'];
				$res['Email'] = 	 $row['Email'];
				$res['Address'] = 	 $row['Address'];
				$res['City'] = 	    getCityById1($row['City']);
				$res['Country'] = 	 getCountryById1($row['Country']);
			}
			
			$result = $res;
			return $result;
		}
		
		public function getCompanyprofile(){
			$result1=array();
			$res1=array();
			$id = $_SESSION['orgid'];
			$query = $this->db->query("SELECT * FROM admin_login where OrganizationId =$id");
			foreach ($query->result_array() as $row)
			{
				$res1['username'] =   $row['username'];
				$res1['email'] = 	 $row['email'];
				$res1['name'] = 	 $row['name'];
			}
			
			$result1 = $res1;
			return $result1;
		}
		public function updateProfile(){
			$id = $_SESSION['orgid'];
			$pname = $_REQUEST['pname'];
			$puname = $_REQUEST['puname'];
			$pemail = $_REQUEST['pemail'];
			$query = $this->db->query("update admin_login set username='$puname', email='$pemail', name='$pname' where OrganizationId =$id");
			if($query>0){
				$_SESSION['name']=$pname;
				echo 1;
			}else{
				echo 0;
			}
			
			
		}
		
		
		public function updateCProfile(){
			$id = $_SESSION['orgid'];
			
			$cpname = isset($_REQUEST['cpname'])?$_REQUEST['cpname']:'';
			$cpwebsite = isset($_REQUEST['cpwebsite'])?$_REQUEST['cpwebsite']:'';
			$pname = isset($_REQUEST['pname'])?$_REQUEST['pname']:''; // contact person
			$puname = isset($_REQUEST['puname'])?$_REQUEST['puname']:'';
			$cppnumber = isset($_REQUEST['cppnumber'])?$_REQUEST['cppnumber']:'';
			$cpemail = isset($_REQUEST['cpemail'])?$_REQUEST['cpemail']:'';
			$cpaddress = isset($_REQUEST['cpaddress'])?$_REQUEST['cpaddress']:'';
			
			$query = $this->db->query("update Organization set Name='$cpname', Website='$cpwebsite', Address='$cpaddress',Email='$cpemail' where Id = $id");
			if($query>0){
				$_SESSION['name']=$pname;
				echo 1;
			}else{
				echo 0;
			}
			
			
		} 
		
		/* 
		public function updateCProfile(){
			$id = $_SESSION['orgid'];
			
			$cpname = $_REQUEST['cpname'];
			$cpwebsite = $_REQUEST['cpwebsite'];
			//$pname = $_REQUEST['pname'];
			//$puname = $_REQUEST['puname'];
			$cppnumber = $_REQUEST['cppnumber'];
			$cpemail = $_REQUEST['cpemail'];
			$cpaddress = $_REQUEST['cpaddress'];
			
			$query = $this->db->query("update Organization set Name='$cpname', Website='$cpwebsite',PhoneNumber=$cppnumber, Email='$cpemail', Address='$cpaddress' where Id =$id");
			if($query>0){
				$_SESSION['orgName']=$cpname;
				echo 1;
			}else{
				echo 0;
			}
			
			
		}
		 */
		public function updatePassword(){
			 $id = $_SESSION['orgid'];
			 $cpassword = encrypt(isset($_REQUEST['cpassword'])?$_REQUEST['cpassword'] : '');
			 $npassword = encrypt(isset($_REQUEST['npassword'])?$_REQUEST['npassword'] : '');
			 $rtpassword =encrypt(isset($_REQUEST['rtpassword'])?$_REQUEST['rtpassword']: '');
			$query = $this->db->query("select * from admin_login where password='$cpassword' and OrganizationId = $id");
			$result = $query->num_rows();
			if($result>0){
				$query1 = $this->db->query("update admin_login set password='$rtpassword' where OrganizationId = $id");
				if($query1>0){
				echo 1;
				}
			}else{
				echo 0;
			}
			
		}
		
		public function q()
		{	
			$data = array();
			$res  = array();
			$org_id = $_SESSION['orgid'];
			$zone=getTimeZone($org_id);
            date_default_timezone_set($zone);
			$date = date("Y-m-d");
			$query = $this->db->query("select Shift,Id  from EmployeeMaster where OrganizationId = $org_id and archive = 1 and Id NOT IN (select EmployeeId from AttendanceMaster where OrganizationId = $org_id and AttendanceDate='$date' and TimeIn != '00:00:00')");
			foreach ($query->result() as $row)
			{
				   $ShiftId = $row->Shift;
				   $EId = $row->Id;
				   $query = $this->db->query("select TimeIn from ShiftMaster where Id = $ShiftId");
				   if($data123 = $query->row()){
					   $shiftin =  substr(($data123->TimeIn),0,5);
                       $ct =  date('H:i:s');				   
				       $query111 = $this->db->query("select * from EmployeeMaster where OrganizationId = $org_id  and '$ct' > '$shiftin' and Id =$EId");
				       if($row111 = $query111->row()){   
						   $query333 = $this->db->query("SELECT `DateFrom`, `DateTo` FROM `HolidayMaster` WHERE OrganizationId=$org_id and ('$date' between `DateFrom` and `DateTo`)");
						   if($query333->num_rows()>0)
						    continue;	
							$dayOfWeek = 1 + date('w',strtotime($date));
							$weekOfMonth =weekOfMonth($date);
							$week='';
							$query555 = $this->db->query("SELECT `WeekOff` FROM  `WeekOffMaster` WHERE  `OrganizationId` =? AND  `Day` =  ?",array($org_id,$dayOfWeek));	
							if($row555=$query555->result()){
									$week =	explode(",",$row555[0]->WeekOff);
							}
								if($week[$weekOfMonth-1]==1)
								  continue;
									$data['Weekofmonth']  = weekOfMonth($date);
									$data['dayOfWeek'] = $dayOfWeek;
									$data['Id'] = $row111->Id;
									$data['FirstName'] = $row111->FirstName;
									$data['LastName'] = $row111->LastName;
									$designation = $row111->Designation;
									$query222 = $this->db->query("select * from DesignationMaster where Id =$designation");
									if($row222 = $query222->row()){
									$data['Designation'] = $row222->Name;
									$data['shift'] = getShiftTimes($ShiftId);
									$data['deprt'] = getDepartmentByEmpID($EId);
									}
								 $res[] = $data;
							}
				}	         			  
			}
			return $res;
		}
		
		
		public function getLateEmployee(){ 
			$data = array();
			$res  = array();
			$org_id = $_SESSION['orgid'];
			$zone=getTimeZone($org_id);
            date_default_timezone_set($zone);
			$date = date("Y-m-d");
			$query = $this->db->query("select Shift,Id  from EmployeeMaster where OrganizationId = $org_id and Id IN (select EmployeeId from AttendanceMaster where OrganizationId = $org_id and AttendanceDate='$date' and TimeIn != '00:00:00' order by TimeIn )");
			foreach ($query->result() as $row)
			{
				   $ShiftId = $row->Shift;
				   $EId = $row->Id;
				   $query = $this->db->query("select * from ShiftMaster where Id = $ShiftId");
				   if($data123 = $query->row()){
					   $shiftin =  substr(($data123->TimeIn),0,5);
                       $ct =  date('H:i:s');
				       $query111 = $this->db->query("select * from EmployeeMaster where OrganizationId = $org_id  and Id =$EId");
				       if($row111 = $query111->row()){
                       $query333 = $this->db->query("select * from AttendanceMaster where OrganizationId = $org_id  and EmployeeId =$EId and TimeIn > '$shiftin' and AttendanceDate='$date'");
					   if($row333 = $query333->row()){
					    $data['TimeIn'] = substr(($row333->TimeIn),0,5);
				        $data['Id'] = $row111->Id;
				        $data['FirstName'] = $row111->FirstName;
				        $data['LastName'] = $row111->LastName;
						$data['Name'] = $data['FirstName']." ".$data['LastName'];
				        $designation = $row111->Designation;
					    $query222 = $this->db->query("select * from DesignationMaster where Id =$designation");
					    if($row222 = $query222->row())
						{
					    $data['Designation'] = $row222->Name;
					    $Tio=getShiftTimes($ShiftId);
				        $data['shift'] = getShift($ShiftId)."(".$Tio.")";
						$data['deprt'] = getDepartmentByEmpID($EId);
						$a = new DateTime(substr (getShiftTimes($data123->Id),0,5));
                        $b = new DateTime($row333->TimeIn);
                        $interval = $a->diff($b);
                        $data['late_by']=$interval->format("%H:%I");
						
						
						}
						$res[] = $data;
						
					   }
				   }   
				  }	               		  
			}
			return $res;
		}
		
		// Count Late Comming Employee BY sohan
		public function Count_LateEmployee()
		{
			$res = array();
			$org_id = $_SESSION['orgid'];
			$zone=getTimeZone($org_id);
            date_default_timezone_set($zone);
			$date = date("Y-m-d");
			$query = $this->db->query("SELECT A.Id FROM  AttendanceMaster  A ,ShiftMaster S,EmployeeMaster E  WHERE A.ShiftId = S.Id AND A.OrganizationId = S.OrganizationId AND A.TimeIn > S.TimeIn AND A.AttendanceDate = '$date' AND A.OrganizationId = '$org_id' AND  A.TimeIn != '00:00:00' AND  E.Id = A.EmployeeId AND E.OrganizationId = A.OrganizationId AND E.Is_Delete = 0  order by A.TimeIn");
			return $this->db->affected_rows();
		}
		// get late Comming emp By sohan
		public function getLateEmployee__new()
		{
			$org_id = $_SESSION['orgid'];
			$zone=getTimeZone($org_id);
			$res = array();
            date_default_timezone_set($zone);
			$date = date("Y-m-d");
			$query = $this->db->query("SELECT A.AttendanceDate , A.EmployeeId as empid , TIMEDIFF(A.TimeIn,S.TimeIn) as time, A.Dept_id as deptid, A.Desg_id as desid, A.TimeIn as atimein ,S.TimeIn as stimein,S.TimeOut as stimeout,S.Name as sname  FROM  AttendanceMaster  A ,ShiftMaster S  WHERE A.ShiftId=S.Id AND A.OrganizationId = S.OrganizationId AND A.TimeIn > S.TimeIn AND A.AttendanceDate = '$date' AND A.OrganizationId = '$org_id' AND  A.TimeIn != '00:00:00'  order by A.TimeIn");
			foreach($query->result() as $row)
			{
				$data = array();
				$name = ucwords(getEmpName($row->empid));
				if($name != "")
				{
				$data['Name'] = $name;
				$data['late_by'] = substr(($row->time),0,5);
				$data['deprt'] = getDepartmentByEmpID($row->empid);
				$data['Designation'] = getDesignationByEmpID($row->empid);
				$data['shift'] = $row->sname." ( ".substr(($row->stimein),0,5)." - ".substr(($row->stimeout),0,5)." )";
				$data['TimeIn'] = substr(($row->atimein),0,5);
				$res[] = $data;
				}
			}
			return $res;
		}
		
		
		public function getEarlyEmploy()
		{
			$data = array();
			$res  = array();
			$org_id = $_SESSION['orgid'];
			$zone=getTimeZone($org_id);
            date_default_timezone_set($zone);
			$date =  date("Y-m-d");
			
			$query = $this->db->query("select Shift,Id  from EmployeeMaster where OrganizationId = $org_id and Id IN (select EmployeeId from AttendanceMaster where OrganizationId = $org_id and AttendanceDate='$date' and TimeOut!= '00:00:00' )");
			foreach ($query->result() as $row)
			 {
				   $ShiftId = $row->Shift;
				   $EId = $row->Id;
				   $query = $this->db->query("select Id,TimeOut from ShiftMaster where Id = $ShiftId");
				   if($data123 = $query->row()){
					   $shifto =  substr(($data123->TimeOut),0,5);
                       $ct =  date('H:i:s');
				       $query111 = $this->db->query("select * from EmployeeMaster where OrganizationId = $org_id  and Id =$EId");
				       if($row111 = $query111->row()){
                       $query333 = $this->db->query("select * from AttendanceMaster where OrganizationId = $org_id  and EmployeeId =$EId and time(TimeOut) < (select time(TimeOut) from ShiftMaster where Id=$ShiftId) and AttendanceDate='$date'and TimeOut!= '00:00:00'");
					   if($row333 = $query333->row()){
					    $data['TimeOut'] = substr(($row333->TimeOut),0,5);
				        $data['Id'] = $row111->Id;
				        $data['FirstName'] = $row111->FirstName;
				        $data['LastName'] = $row111->LastName;
						$data['Name'] = $row111->FirstName." ".$row111->LastName;
				        $designation = $row111->Designation;
					    $query222 = $this->db->query("select * from DesignationMaster where Id =$designation");
					    if($row222 = $query222->row()){
					    $data['Designation'] = $row222->Name;
					    $Tio=getShiftTimes($ShiftId);
				        $data['shift'] = getShift($row->Shift)."(".$Tio.")";
						$data['deprt'] = getDepartmentByEmpID($EId);
						
						$a = new DateTime(substr (getShiftTimeso($data123->Id),0,5));
					//echo $a ;
                    $b = new DateTime($row333->TimeOut);
                    $interval = $a->diff($b);
					if($b<$a){
                    $data['early_by']=$interval->format("%H:%I");
					}
					if($b>$a){
                    $data['early_by']="-";
					}
						}
						$res[] = $data;
					   }
				   }   
				  }	               		  
			}
			return $res;
			//print_r($res);
		}
		// Count Early Leavers By sohan
		 public function Count_EarlyLeaverEmp()
		 {
			$org_id = $_SESSION['orgid'];
			$zone=getTimeZone($org_id);
            date_default_timezone_set($zone);
			$date = date("Y-m-d");
			$query = $this->db->query("SELECT A.AttendanceDate FROM  AttendanceMaster  A ,ShiftMaster S,EmployeeMaster E  WHERE A.ShiftId=S.Id AND A.OrganizationId = S.OrganizationId AND A.TimeOut < S.TimeOut AND A.AttendanceDate = '$date' AND A.OrganizationId = '$org_id'  AND  A.TimeOut != '00:00:00' AND  A.OrganizationId = E.OrganizationId AND A.EmployeeId = E.Id AND E.Is_Delete =0 ");
			return $this->db->affected_rows();
		 }
		// early leaver by sohan patel
		public function getEarlyEmploy__new()
		{
			$res = array();
			$org_id = $_SESSION['orgid'];
			$zone=getTimeZone($org_id);
            date_default_timezone_set($zone);
			$date = date("Y-m-d");
			$query = $this->db->query("SELECT A.AttendanceDate , A.EmployeeId as empid , TIMEDIFF(S.TimeOut,A.TimeOut) as time, A.Dept_id as deptid, A.Desg_id as desid, A.TimeOut as atimeout ,S.TimeIn as stimein,S.TimeOut as stimeout,S.Name as sname  FROM  AttendanceMaster  A ,ShiftMaster S  WHERE A.ShiftId=S.Id AND A.OrganizationId = S.OrganizationId AND A.TimeOut < S.TimeOut AND A.AttendanceDate = '$date' AND A.OrganizationId = '$org_id' AND  A.TimeOut != '00:00:00'  order by A.TimeOut");
			foreach($query->result() as $row)
			{
				$data = array();
				$name = ucwords(getEmpName($row->empid));
				 if($name != "")
				 {
				$data['Name'] = $name;
				$data['early_by'] = substr(($row->time),0,5);
				$data['deprt'] = getDepartmentByEmpID($row->empid);
				$data['Designation'] = getDesignationByEmpID($row->empid);
				$data['shift'] = $row->sname." ( ".substr(($row->stimein),0,5)." - ".substr(($row->stimeout),0,5)." )";
				$data['TimeOut'] = substr(($row->atimeout),0,5);
				$res[] = $data;
				 }
			}
			return $res;
			
		}
		
		
		function getEarlyEmployee1(){
			$data = array();
			$res = array();
		    $ci =& get_instance();
		    $ci->load->database();
			$i = 1;
			$org_id = $_SESSION['orgid'];
			$zone=getTimeZone($org_id);
            date_default_timezone_set($zone);
			$date = date("Y-m-d");
			$query = $ci->db->query("select Shift,Id,Designation,Department,FirstName,LastName from EmployeeMaster where OrganizationId = $org_id and Id IN (select EmployeeId from AttendanceMaster where OrganizationId = $org_id and AttendanceDate='$date' and TimeOut != '00:00:00')");
			//if($query->num_rows()){
				foreach ($query->result() as $row)
				{
					$ShiftId1 = getShiftTimes($row->Shift);
					$ShiftId =$row->Shift;
					$FirstName = $row->FirstName;
					$LastName = $row->LastName;
					$EId = $row->Id;
					$Department = $row->Department;
					$Designation1 = getDesignation($row->Designation);
					$Designation = $row->Designation;
					 $query222 = $ci->db->query("SELECT A.TimeOut,B.Name as department,C.Name as designation,D.TimeOut as timeout FROM AttendanceMaster D,ShiftMaster A ,DepartmentMaster B,DesignationMaster C WHERE A.Id = $ShiftId AND A.OrganizationId = $org_id AND B.Id = $Department AND C.Id = $Designation AND D.EmployeeId = $EId AND D.TimeOut < A.TimeOut AND D.OrganizationId = $org_id AND D.TimeOut != '00:00:00' AND D.AttendanceDate='$date'");
					
					if($result222 = $query222->row()){
						
				     //  $data['shift'] = $result222->Id;
				        $data['FirstName'] = $FirstName;
						 $data['desg'] = $Designation;
				       // $data['LastName'] = $LastName;
				        $data['shift'] = $ShiftId1;
						$data['TimeOut'] = substr(($result222->timeOut),0,5);
					  
							   $res[] = $data;
                   // }
				}					
				}
				return $res;
				/* if(count($res) == 0){
					echo '<tr style="width:100%"><td colspan="5">No Employees Found</td></tr>';
				} */
			//}else{
				// echo '<tr style="width:100%"><td colspan="5">No Employees Found</td></tr>';
			//}
	}
	
		
		
		
		// Count present Employee by sohan
		public function getPresentEmployee()
		{
			$org_id = $_SESSION['orgid'];
			$zone=getTimeZone($org_id);
            date_default_timezone_set($zone);
            $date = date("Y-m-d");
			$query = $this->db->query("select A.Id as presentEmp from AttendanceMaster A,EmployeeMaster E where A.OrganizationId = '$org_id' and A.AttendanceDate='$date' and A.TimeIn != '00:00:00' AND E.OrganizationId = A.OrganizationId AND A.EmployeeId = E.Id 	AND E.Is_Delete = 0  AND A.AttendanceStatus IN (1,8,4)");
			 return $this->db->affected_rows();
		}
		
		public function DailyPresentEmployee(){
		  $org_id = $_SESSION['orgid'];
		  $data = array();
		  $res = array();
		  $sql = "select DISTINCT AttendanceDate from AttendanceMaster where OrganizationId = $org_id
		  ORDER BY AttendanceDate Desc LIMIT 7";
		  $query = $this->db->query($sql);
		  $result = $query->result();
		  foreach ($query->result() as $row)
          {
			$dt = $row->AttendanceDate;
			$data['label'] = date('M d', strtotime($dt));
            $query = $this->db->query("select count(AttendanceDate) as total from AttendanceMaster where AttendanceDate = '$dt' and OrganizationId = $org_id");
		    $result = $query->row();
		    $data['y'] = $result->total;
            $res[] = $data;			
          }
		  return json_encode($res);		
	    }

        public function MonthlyPresentEmployee(){
		$org_id = $_SESSION['orgid'];
		$res = array();
        $data = array();		
		$date = date("Y");
        $sql = "SELECT DISTINCT MONTH( AttendanceDate ) AS months FROM AttendanceMaster where YEAR(AttendanceDate) = '$date' ORDER BY AttendanceDate Desc LIMIT 12";
		$query = $this->db->query($sql);
		foreach ($query->result() as $row)
          {
			$months = $row->months;
			$sql11 = "select count(AttendanceDate) as total FROM AttendanceMaster where YEAR(AttendanceDate) = '$date' and MONTH(AttendanceDate) = '$months'  and OrganizationId = $org_id";
			$query11 = $this->db->query($sql11);
			if($result = $query11->row()){
			$dateObj   = DateTime::createFromFormat('!m',$months);
            $data['months'] = $dateObj->format('F');
			$data['total'] = $result->total;
			}
			$res[] = $data;
		  }
		  return json_encode($res);
	    }
		
		public function DailyLateEmployee(){
			$res=array();
			$data = array();
			$org_id = $_SESSION['orgid'];
			$sql = "select DISTINCT AttendanceDate from AttendanceMaster where  OrganizationId = $org_id 
		  ORDER BY AttendanceDate Desc LIMIT 7";
		      $query = $this->db->query($sql);
		      $result = $query->result();
		      foreach ($query->result() as $row)
               {
			         $date = $row->AttendanceDate;   
					  $id = "";
					  $data = array();
					  
					  $zone=getTimeZone($org_id);
                      date_default_timezone_set($zone);
			          $query = $this->db->query("select Shift,Id  from EmployeeMaster where OrganizationId = $org_id and Id IN (select EmployeeId from AttendanceMaster where OrganizationId = $org_id and AttendanceDate='$date' and TimeIn != '00:00:00')");
			             foreach ($query->result() as $row)
			             {
				             $ShiftId = $row->Shift;
				             $EId = $row->Id;
				             $query = $this->db->query("select TimeIn from ShiftMaster where Id = $ShiftId");
				             if($data123 = $query->row()){
					             $shiftin =  substr(($data123->TimeIn),0,5);
				                 $query111 = $this->db->query("select * from EmployeeMaster where OrganizationId = $org_id  and Id =$EId");
								 if($row111 = $query111->row()){
                                  $query333 = $this->db->query("select * from AttendanceMaster where OrganizationId = $org_id  and EmployeeId =$EId and TimeIn > '$shiftin' and AttendanceDate='$date'");
									   if($row333 = $query333->row()){
										$id .= $row111->Id . ",";
										
									   }
				                    } 
				            }	               		  
			            }
						 $data['label'] = date('M d', strtotime($date));
						 $str = rtrim($id,',');
						 $data ['lateComers'] = count(explode(",",$str));
	                     $res[] = $data;	            
					}
					return json_encode($res);
	    }
		  // get Last 7 days late commerse b y sohan
		public function DailyLateEmployee_New()
		{
			$res=array();
			$data = array();
			$org_id = $_SESSION['orgid'];
			$sql = $this->db->query("select DISTINCT A.AttendanceDate from AttendanceMaster A , EmployeeMaster E where  A.OrganizationId = $org_id AND A.EmployeeId = E.Id AND E.Is_Delete = 0 ORDER BY A.AttendanceDate Desc LIMIT 8");
			foreach($sql->result() as $row)
			{
			  $date = $row->AttendanceDate;
			 $query = $this->db->query("SELECT A.Id FROM  AttendanceMaster  A ,ShiftMaster S  WHERE A.ShiftId = S.Id AND A.OrganizationId = S.OrganizationId AND A.TimeIn > S.TimeIn AND A.AttendanceDate = '$date' AND A.OrganizationId = '$org_id' AND  A.TimeIn != '00:00:00' order by A.TimeIn");
			  $data['label'] = date('M d', strtotime($date));
			 $data ['lateComers'] = $this->db->affected_rows();
			 $res[] = $data;
			}
			return json_encode($res);
		}
		// count abset  employee today by sohan 
		public function getAbsentEmployee()
		{	
			$data = array();
			$res  = array();
			$org_id = $_SESSION['orgid'];
			$zone=getTimeZone($org_id);
            date_default_timezone_set($zone);
			$date = date("Y-m-d");
			$time = date("H:i:s");
			//IF(E.CreatedDate!='0000-00-00 00:00:00', E.CreatedDate < '".$date ."', 1) and
			$query1 = $this->db->query("SELECT E.Id FROM  `EmployeeMaster` E, ShiftMaster S WHERE E.OrganizationId =".$org_id." AND E.archive=1 and E.Id NOT IN (SELECT A.EmployeeId FROM   `AttendanceMaster` A  WHERE  `AttendanceDate` IN ( '".$date."') AND A.OrganizationId =".$org_id." AND 	`AttendanceStatus`  in(1,8,4))  AND E.Shift = S.Id AND S.TimeIn < '$time' AND E.Is_Delete = 0 ORDER BY E.Id");
					//json_encode($query1->result());
			$count=$query1->num_rows();
			return $count;
		}
		
		
		////
		public function EarlyleaveEmployee(){
			$res=array();
			$data = array();
			$org_id = $_SESSION['orgid'];
			$sql = "select DISTINCT AttendanceDate from AttendanceMaster where  OrganizationId = $org_id 
		  ORDER BY AttendanceDate Desc LIMIT  7 ";
		      $query = $this->db->query($sql);
		      $result = $query->result();
		      foreach ($query->result() as $row)
               {
			          $date = $row->AttendanceDate;   
					  $id = "";
					  $data = array();
					  
					  $zone=getTimeZone($org_id);
                      date_default_timezone_set($zone);
			          $query = $this->db->query("select Shift,Id  from EmployeeMaster where OrganizationId = $org_id and Id IN (select EmployeeId from AttendanceMaster where OrganizationId = $org_id and AttendanceDate='$date' and TimeOut != '00:00:00')");
			             foreach ($query->result() as $row)
			             {
				              $ShiftId = $row->Shift;
				             $EId = $row->Id;
				             $query = $this->db->query("select TimeOut from ShiftMaster where Id = $ShiftId");
				             if($data123 = $query->row()){
					             $shiftOut =  substr(($data123->TimeOut),0,5);
				                 $query111 = $this->db->query("select * from EmployeeMaster where OrganizationId = $org_id  and Id =$EId and DOL = '0000:00:00'");
								 if($row111 = $query111->row()){
                                  $query333 = $this->db->query("select * from AttendanceMaster where OrganizationId = $org_id  and EmployeeId =$EId and TimeOut < '$shiftOut' and AttendanceDate='$date' and TimeIn != '0000:00:00'");
									   if($row333 = $query333->row()){
										$id .= $row111->Id . ","; 
									
									   }
				                    } 
				            }	               		  
			            }
						 $data['label'] = date('M d', strtotime($date));
						 $str = rtrim($id,',');
						 $data ['early'] = count(explode(",",$str));
	                     $res[] = $data;	            
					}
					return json_encode($res);
	    }
		
		/// last 7 days early leavers by sohan
		public function EarlyleaveEmployee_New()
		{
			$res=array();
			$data = array();
			$org_id = $_SESSION['orgid'];
			$sql = $this->db->query("select DISTINCT A.AttendanceDate from AttendanceMaster A , EmployeeMaster E where  A.OrganizationId = $org_id AND A.EmployeeId = E.Id AND E.Is_Delete = 0 ORDER BY AttendanceDate Desc LIMIT 8");
			foreach($sql->result() as $row)
			{
			  $date = $row->AttendanceDate;
			 $query = $this->db->query("SELECT A.Id FROM  AttendanceMaster  A ,ShiftMaster S  WHERE A.ShiftId=S.Id AND A.OrganizationId = S.OrganizationId AND A.TimeOut < S.TimeOut AND A.AttendanceDate = '$date'  AND A.OrganizationId = '$org_id' AND  A.TimeOut != '00:00:00' ");
			  $data['label'] = date('M d', strtotime($date));
			 $data ['early'] = $this->db->affected_rows();
			 $res[] = $data;
			}
			return json_encode($res);
		}
		
		
	 public function DailyAbsentEmployee()
	  {
			$data = array();
			$res  = array();
			$org_id = $_SESSION['orgid'];
			$zone=getTimeZone($org_id);
            date_default_timezone_set($zone);
			//$date = date("Y-m-d");
			$sql = "select DISTINCT(AttendanceDate),EmployeeId,ShiftId from AttendanceMaster where  OrganizationId = '$org_id' ORDER BY AttendanceDate Desc LIMIT 8";
		    $query = $this->db->query($sql);
		    $result = $query->result();
		      foreach($query->result() as $row)
               {
				$date = $row->AttendanceDate;
				$shiftid = $row->ShiftId;
				$data['label'] = date('M d', strtotime($date));

				////////////////////////////////////////////////
			  $query1 = $this->db->query("SELECT Id
							FROM  `EmployeeMaster` 
							WHERE EmployeeMaster.OrganizationId =".$org_id."
							 AND archive=1 and IF(EmployeeMaster.CreatedDate!='0000-00-00 00:00:00', CreatedDate < '".$date ."', 1) and  Id 
							NOT IN (
							SELECT `EmployeeId` 
							FROM   `AttendanceMaster` 
							WHERE  `AttendanceDate` 
							IN (
							 '".$date."'
							)
							AND AttendanceMaster.OrganizationId =".$org_id."
							AND `AttendanceStatus` not in(3,5,6)
							)
							ORDER BY EmployeeMaster.Id ");
						  
			    $data['y'] = $query1->num_rows();
                $res[] = $data;				
			   }
			return json_encode($res);
		}
		// get last 7 days Absent by sohan
	  public function DailyAbsentEmployee_new()
	  {
		   
			$res  = array();
			$org_id = $_SESSION['orgid'];
			$zone=getTimeZone($org_id);
            date_default_timezone_set($zone);
            $date = date("Y-m-d");			
			$query = $this->db->query("select DISTINCT(A.AttendanceDate)  
			from AttendanceMaster A ,EmployeeMaster E where  A.OrganizationId = '$org_id' AND  E.Id = A.EmployeeId AND A.OrganizationId = E.OrganizationId  AND E.Is_Delete = 0  ORDER BY A.AttendanceDate Desc LIMIT 8");
			foreach($query->result() as $row)
			{ 
			
			    $data = array();
				$date1 = $row->AttendanceDate;
				$data['label'] = date('M d', strtotime($date1));
				 
				$query1 = $this->db->query("SELECT Id as absentemp from AttendanceMaster where AttendanceDate = '$date1' AND OrganizationId = '$org_id' AND  AttendanceStatus in (2,6,7)");
				$data['y'] = $this->db->affected_rows();
				$res[] = $data;	
			}
			return json_encode($res);
			
	  }
		public function MonthlyLateEmployee(){
		$org_id = $_SESSION['orgid'];
		$res = array();
        $data = array();		
		$date = date("Y");
        $sql = "SELECT DISTINCT MONTH( AttendanceDate ) AS months FROM AttendanceMaster where  OrganizationId = $org_id and YEAR(AttendanceDate) = '$date' ORDER BY AttendanceDate Desc LIMIT 12";
		$query = $this->db->query($sql);
		foreach ($query->result() as $row)
          {
			$sum = 0;  
			$months = $row->months;
			$dateObj   = DateTime::createFromFormat('!m',$months);
            $data['months'] = $dateObj->format('F');
			$sql11 = "select DISTINCT AttendanceDate from AttendanceMaster where   MONTH(AttendanceDate) = '$months' and OrganizationId = $org_id";
			$query11 = $this->db->query($sql11);
		      foreach ($query11->result() as $row11)
               {
				$current_date = date("Y-m-d");
				$date = $row11->AttendanceDate;
				$query = $this->db->query("SELECT `DateFrom`, `DateTo` FROM `HolidayMaster` WHERE OrganizationId=? and (? between `DateFrom` and `DateTo`) ",array($org_id,$date));
					if($query->num_rows()>0)
						continue;
					
				    // $dayOfWeek = 1 + date('w',strtotime($date));
					// $weekOfMonth =weekOfMonth($date);
					// $week='';
					// $query = $this->db->query("SELECT `WeekOff` FROM  `WeekOffMaster` WHERE  `OrganizationId` =? AND  `Day` =  ?",array($org_id,$dayOfWeek));	
					
					  // if($row=$query->result()){
							// $week =	explode(",",$row[0]->WeekOff);	
					   // }
					   
					 // if($week[$weekOfMonth-1]==1)
						// continue;
					   

					
                $query1 = $this->db->query("select count(Id) as Id from EmployeeMaster where archive = 1 and OrganizationId = $org_id and Id NOT IN (select EmployeeId from AttendanceMaster where OrganizationId = $org_id and AttendanceDate='$date' and TimeIn != '00:00:00' )");
			    $row1 = $query1->row();
			    $sum+= $row1->Id;				
			   }
			   $data ['total'] = $sum;
			   $res[] = $data;
		  }
		  return json_encode($res);
	    }
		
		
	
public function mailtest(){
		
	
	$to = "vijay@ubitechsolutions.com";
	$subject = "HTML email-1";

	$message = "
	<html>
	<head>
	<title>HTML email</title>
	</head>
	<body>
	<p>This email contains HTML Tags!</p>
	<table>
	<tr>
	<th>Firstname</th>
	<th>Lastname</th>
	</tr>
	<tr>
	<td>John</td>
	<td>Doe</td>
	</tr>
	</table>
	</body>
	</html>
	";
sendEmail_new($to,$subject,$message);
return false;
	// Always set content-type when sending HTML email
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

	// More headers
	$headers .= 'From: <support@ubitechsolutions.com.com>' . "\r\n";
	$headers .= 'Cc: vijaympct13@gmail.com' . "\r\n";

	mail($to,$subject,$message,$headers);
}
  function saveGeolocation()
	{
	  $radius =  isset($_REQUEST['radius'])?$_REQUEST['radius']:0;
	  $location =  isset($_REQUEST['location'])?$_REQUEST['location']:'';
	  $latlong =  isset($_REQUEST['latlong'])?$_REQUEST['latlong']:'';
	  $name =  isset($_REQUEST['name'])?$_REQUEST['name']:'';
	  $id =  isset($_REQUEST['id'])?$_REQUEST['id']:0;
	  $orgid = $_SESSION['orgid'];
	   $data = array();
	    
	  if($id != 0)
	  {
		  $query = $this->db->query("UPDATE Geo_Settings SET Lat_Long=?,Location=?,Radius=?,Name=? WHERE Id = ? AND OrganizationId= ? " ,array($latlong,$location,$radius,$name,$id,$orgid));
		 $res= $this->db->affected_rows();
			 if($res)
			 {
			 $data['status']= true; 
			 $data['sms']= "Location update successfull"; 
			 }
			 else
			 {
			   $data['status']= false; 
			   $data['sms']= "There is some problem when update a location"; 
			 }
	     return $data;
	  }
	  else
	  {
		  $res=0;
			$query=$this->db->query("select Id from Geo_Settings where Name=? and OrganizationId=?",array($name,$orgid));
			if($query->num_rows()>0)
			{
			 $res=2;	
			if($res==2)
				 {
				 $data['status']= false; 
				 $data['sms']= "Geo Center Name Already exist"; 
				 }
				 else
				 {
				   $data['status']= 'ok'; 
				   $data['sms']= "There is some problem when insert a location"; 
				 }
				return $data;
			}
			else
			{
			  $query=$this->db->query("INSERT INTO  Geo_Settings (`OrganizationId`,`Lat_Long`,`Location`,`Radius`,`Name`) VALUES (?,?,?,?,?)",array($orgid,$latlong,$location,$radius,$name));
			  $res= $this->db->affected_rows();
				 if($res)
				 {
				 $data['status']= true; 
				 $data['sms']= "Location insert successfull"; 
				 }
				 else
				 {
				   $data['status']= false; 
				   $data['sms']= "There is some problem when insert a location"; 
				 }
				 return $data;
			  }
			 
		}
	}
  function getGeolocation()
  {
	  	      $orgid=$_SESSION['orgid'];
			 $query = $this->db->query("SELECT * FROM `Geo_Settings` WHERE OrganizationId=? ",array($orgid));
			$d=array();
			$res=array();
			 foreach ($query->result() as $row)
			{
				$data=array();
				  $id = encode5t($row->Id);
					$data['name']= $row->Name;
					$data['latlong']=$row->Lat_Long;
					$data['location']="<a href='http://maps.google.com/?q=$row->Lat_Long' target='_blank' title='Click to see location on map'>$row->Location;</a>";
					$data['radius']=number_format((float)$row->Radius, 2, '.', '');
					$data['status']=$row->Status==1?'<div style="background-color:green;text-align:center;color:white;">Active</div>':'<div style="background-color:red;text-align:center;color:white;">
					Inactive</div>';
					$data['action']='<a href="#"><i class="material-icons edit" data-toggle="modal" title="Edit" data-sid="'.$row->Id.'"
					 data-did="'.$row->Id.'" 
					 data-name="'.$row->Name.'" 
					 data-sts="'.$row->Status.'"
					data-target="#addDeptE">edit</i></a>
				   <i class="delete fa fa-trash" style="font-size:24px; color:purple;" data-toggle="modal" data-target="#delDept" data-did="'.$row->Id.'" data-dname="'.$row->Name.'" title="Delete" ></i>
					<i class="upGeolocation fa fa-check-square-o" style="font-size:24px; color:purple" data-toggle="modal" data-target="#updateGeolocation" onclick="angular.element(this).scope().GetEmpList1(\''.$row->Id.'\')" 
					data-sid="'.$row->Id.'" data-sname="'.$row->Name.'" title="checklist" ></i>				   
					';
					$res[]=$data;
			}  	
			$d['data']=$res;
			 $this->db->close();
			echo json_encode($d); 
			return false;
  }

 public function getemployeebygeolocation() {
		 
		$result = array();
		$data = array();
		 $orgid=$_SESSION['orgid'];
		  $geoid=isset($_REQUEST['geoid'])?$_REQUEST['geoid']:'';
		
		$sql = "SELECT Id,EmployeeCode,FirstName,LastName FROM EmployeeMaster WHERE OrganizationId =? and area_assigned!= ? and archive=1 order by FirstName";
		
		$query = $this->db->query($sql,array($orgid,$geoid ));
		
			foreach($query->result() as $row)
			{
				$res = array();
				$res['id'] = $row->Id;
				$res['name'] = $row->EmployeeCode." - ". ucwords(strtolower($row->FirstName." ".$row->LastName));
				$res['empfname'] = $row->FirstName;
				$res['emplname'] = $row->LastName;
				
				$res['sts']=0;
				
				
				$data[] = $res;
			}
		$result["data"] =$data;
		return $result;
    }
	
	
	
	public function SaveEmpGeoList() {
        $result = array();
        $data = array();
		$orgid=$_SESSION['orgid'];
		 $geoid=isset($_REQUEST['geoid'])?$_REQUEST['geoid']:'';
        
            $emplistarr = json_decode($_POST['emplist'], true);
           
            for($i=0; $i<count($emplistarr); $i++)
            {
                if($emplistarr[$i]['sts']==1 ){
					
					$empid = $emplistarr[$i]['id'];
					
					$sql = "update EmployeeMaster set area_assigned=? where OrganizationId =? and Id=?";
					
					$query = $this->db->query($sql,array($geoid ,$orgid,$empid));
                }
            }
          
        $result["data"] =$data;
        return $result;
    }    
  







  
  public function deleteLocation()
  {
		$orgid=$_SESSION['orgid'];
		$did=isset($_REQUEST['did'])?$_REQUEST['did']:'';
		$data=array();
		$data['afft']=0;
		$query = $this->db->query("select id as totemp from EmployeeMaster where EmployeeMaster.area_assigned=? and OrganizationId=?",array($did,$orgid));
		$data['emp']=$query->num_rows();
		if($data['emp']==0){
		$query = $this->db->query("DELETE FROM `Geo_Settings` where id=? and OrganizationId=?",array($did,$orgid));
		$data['afft']=$this->db->affected_rows();
		}
		$this->db->close();
		echo json_encode($data);
  }
  public function editLocation()
  {
	    $orgid = $_SESSION['orgid'];
		$did = isset($_REQUEST['did'])?$_REQUEST['did']:'';  
		$name = isset($_REQUEST['dna'])?$_REQUEST['dna']:'';  
		$status = isset($_REQUEST['sts'])?$_REQUEST['sts']:'';
		$query = $this->db->query("SELECT Id from Geo_Settings where Id != '$did' AND Name = '$name' ");
		if($this->db->affected_rows())
		{
			echo 2;
		}
		else{
       $query = $this->db->query("UPDATE Geo_Settings set Name = '$name',Status = '$status' where Id = '$did' AND OrganizationId = '$orgid' ");
       echo  $this->db->affected_rows();
		}	   
  }
  public function getLocationById($id)
  {
	  $orgid=$_SESSION['orgid'];
	   $query = $this->db->query("SELECT * FROM `Geo_Settings` WHERE OrganizationId=? AND Id = ? ",array($orgid,$id));
	   $data = array();
	    foreach ($query->result() as $row)
			{
				$data['id'] = $row->Id;
				$data['name'] = $row->Name;
				$data['location'] = $row->Location;
				$data['latlang'] = $row->Lat_Long;
				$data['radius'] = $row->Radius;
			}
		return $data;
  }
  //////////
    public function getSummaryData($type)
       { 
	    //1 for today,2 for yesterday
			$result = array();
			$orgid = isset($_SESSION['orgid'])?$_SESSION['orgid']:0;
			$zname=getTimeZone($orgid);
				date_default_timezone_set ($zname);
				 $time = date("H:i");
				 $stime = date("H:00");
				 $etime = date("H:i", strtotime('+59 minutes',strtotime($stime)));
			 /* echo $stime.'<br/>';
			 echo $etime.'<br/>'; */
				 if($type==1)
				 {
					$date = date("d-M-Y");
					$date1 = date("Y-m-d");
				 }
				 else
				 {
					$date=date('d-M-Y',strtotime('-1 day'));
					$date1 = date("Y-m-d",strtotime('-1 day'));
				 }
					$list=array();
					$list['orgid']=$orgid;
					$list['admin']=getAdminName($orgid);
					$list['email']=getAdminEmail($orgid);
				
				
		
				
			
				
		////////////late comers
			$query = $this->db->query("SELECT CONCAT(E.FirstName,' ',E.LastName) as name , A.TimeIn, A.TimeOut ,'Present' as status,A.EntryImage,A.ExitImage FROM AttendanceMaster A,EmployeeMaster E WHERE (time(A.TimeIn) > (select time(TimeIn) from ShiftMaster where ShiftMaster.Id=shiftId))  and A.AttendanceDate = ? and  A.OrganizationId = ? and A.AttendanceStatus = 1 AND E.Id = A.EmployeeId AND E.Is_Delete = 0 order by name",array($date1,$orgid));
			$list['late']=$query->result();	
		
		
		////////////early leaver
			$query = $this->db->query("SELECT CONCAT(E.FirstName,' ',E.LastName) as name , A.TimeIn, A.TimeOut ,'Present' as status,A.EntryImage,A.ExitImage FROM AttendanceMaster A, EmployeeMaster E WHERE (time(A.TimeOut) < (select time(TimeOut) from ShiftMaster where ShiftMaster.Id=shiftId) and A.TimeOut!='00:00:00' ) and A.AttendanceDate=? AND
			A.OrganizationId=? and A.AttendanceStatus=1 AND E.Id = A.EmployeeId AND E.Is_Delete = 0  order by `name`",array($date1,$orgid));
			$list['early']=$query->result();
			
			////////////Time off list
			$query = $this->db->query("SELECT CONCAT(E.FirstName,' ',E.LastName) as name , T.TimeFrom, T.TimeTo ,T.Reason, TIMEDIFF(T.TimeTo, T.TimeFrom) as Total FROM Timeoff T,EmployeeMaster E WHERE T.TimeofDate=? and  T.OrganizationId=? and T.ApprovalSts=2 AND E.Id = T.EmployeeId AND E.Is_Delete = 0 order by `name`",array($date1,$orgid));
			$list['timeoff']=$query->result();
			
			
			////////////forgot to mark timeout(timeout pending)
			$query = $this->db->query("SELECT CONCAT(E.FirstName,' ',E.LastName) as name , A.TimeIn,A.EntryImage FROM AttendanceMaster A , EmployeeMaster E WHERE (A.TimeIn!='00:00:00' and A.TimeOut='00:00:00') and A.AttendanceDate=? and  A.OrganizationId=?  and A.AttendanceStatus=1 AND E.Id = A.EmployeeId AND E.Is_Delete = 0 order by name",array($date1,$orgid));
			$list['pending']=$query->result();	
			
					$query = $this->db->query("SELECT CONCAT(E.FirstName,' ',E.LastName) as name , '-' as TimeIn,'-' as TimeOut ,'Absent' as status FROM AttendanceMaster A, EmployeeMaster E WHERE A.AttendanceDate=?  and  A.OrganizationId=? and A.AttendanceStatus in (2) AND E.Id = A.EmployeeId AND E.Is_Delete = 0 order by `name`",array($date,$orgid));
					$list['abs']=$query->result();
					
					/*Start Geolocations*/
					
				$q2="SELECT A.Id, A.EmployeeId, E.FirstName, E.LastName, A.AttendanceDate as date, A.AttendanceStatus, A.TimeIn, A.TimeOut, A.ShiftId, A.Overtime,A.EntryImage, A.ExitImage,A.latit_in,A.longi_in,A.longi_out,A.latit_out, A.checkInLoc, A.CheckOutLoc,A.areaId, G.Lat_Long, G.Radius FROM AttendanceMaster A, Geo_Settings G, EmployeeMaster E WHERE A.OrganizationId=".$orgid." and G.OrganizationId = ".$orgid." and E.OrganizationId = ".$orgid." and A.AttendanceDate='".$date1."'  and A.TimeIn!='00:00' and A.areaId!=0 and G.Id=A.areaId and E.Id= A.EmployeeId AND E.Is_Delete = 0 order by A.AttendanceDate Desc";
					$query = $this->db->query($q2);
					$res=array();
					foreach($query->result() as $row){
						$res1=array();
						$res1['Name']=$row->FirstName." ".$row->LastName;	
						//print_r($res1['Name']);
						$res1['ti']=substr($row->TimeIn,0,-3);
						$res1['to']=substr($row->TimeOut,0,-3);
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
				
			
			 $this->db->close();	
			 
	      $message='';		
		//print_r($result);
		
		
		
		foreach($result as $r){
			
			if($type==1){
				
				$message ='<center><img src="http://ubitechsolutions.com/ubitechsolutions/Mailers/ubiAttendance/ubiAttendance/logo.png" width="250px;"/></center>';
			$message.='<center><h3 style="color:green;padding:0px; margin:0px;">Daily Attendance Summary</h3>';
			$message.='['.$date.']<br/>';
			
			if(count($r['pending'])>0){
			$message.= '<div><br><h3 style="margin-bottom:5px;" >Time Out Not Marked</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>Employee</th><th>Time In</th><th>Time Out</th></tr>';
				foreach($r['pending'] as $emp){
					$message.= '<tr><td align="left"  style="padding-left:2%">'.$emp->name.'</td><td align="center">'. date("H:i",strtotime($emp->TimeIn)).'</td><td align="center">--</td></tr>';
				}
				$message.='</table></div>';
			}
			if(count($r['abs'])>0){
			$message.= '<div><br><h3 style="margin-bottom:5px;" >Absentees</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>Employee</th><th>Time In</th><th>Time Out</th></tr>';	
				foreach($r['abs'] as $emp){
					$message.= '<tr><td align="left"  style="padding-left:2%">'.$emp->name.'</td><td align="center">--</td><td align="center">--</td></tr>';
				}
			$message.= '</table></div>';
			}
			if(count($r['late'])>0){
			$message.= '<div><br><h3 style="margin-bottom:5px;" >Late Comers</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>Employee</th><th>Time In</th><th>Time Out</th></tr>';	
				foreach($r['late'] as $emp){
					$message.= '<tr><td align="left"  style="padding-left:2%">'.$emp->name.'</td><td align="center">'.date("H:i",strtotime($emp->TimeIn)).'</td><td align="center">'.date("H:i",strtotime($emp->TimeOut)).'</td></tr>';
				}
			$message.= '</table></div>';
			}
			if(count($r['early'])>0){
			$message.= '<div><br><h3 style="margin-bottom:5px;" >Early Leavers</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>Employee</th><th>Time In</th><th>Time Out</th></tr>';	
			
				foreach($r['early'] as $emp){
					$message.= '<tr><td align="left"  style="padding-left:2%">'.$emp->name.'</td><td align="center">'.date("H:i",strtotime($emp->TimeIn)).'</td><td align="center">'.date("H:i",strtotime($emp->TimeOut)).'</td></tr>';
				}
			$message.= '</table></div>';
			}
			if(count($r['timeoff'])>0){
			$message.= '<div><br><h3 style="margin-bottom:5px;" >Time Off List (Approved)</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>Employee</th><th>Timings</th><th>Total Time </th width="40%"><th>Reason</th></tr>';
				
				foreach($r['timeoff'] as $emp){
					$message.= '<tr><td align="left"  style="padding-left:2%">'.$emp->name.'</td><td align="center">'.date("H:i",strtotime($emp->TimeFrom)).' - '.date("H:i",strtotime($emp->TimeTo)).'</td><td align="center">'.date("H:i",strtotime($emp->Total)).'</td><td  width="40%">'.$emp->Reason.'</td></tr>';
				}
			$message.= '</table></div>';
			}
			if(count($r['geoloc'])>0)
			{
			$message.= '<div><br><h3 style="margin-bottom:5px;" >Attendance Marked outside the Fenced Area</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>Employee</th><th>Time In</th><th>Time Out</th></tr>';	
					
				foreach($r['geoloc'] as $emp)
				{
					$message.= '<tr><td align="left" style="padding-left:2%">'.$emp['Name'].'</td><td align="center">'.$emp['ti'].$emp['positionlin'].'</td><td align="center">'.$emp['to'].$emp['positionout'].'</td></tr>';
				}
						$message.= '</table></div>';
			}
					$message.= '<div style="width:50%" ><p style="text-align:left">
					Report sent on 
					<b>'.$date.'</b> at <b>'.$time.'</b><br/>
					View more details on – <span><a href="https://ubiattendance.ubihrm.com">https://ubiattendance.ubihrm.com/</a><span></p>
					<p style="text-align:left;font-weight:bold">Cheers,<br/>
					Team ubiAttendance<br/>
					<a href="www.ubiattendance.com">www.ubiattendance.com</a><br/>
					Tel / Whatsapp: +91 70678 22132<br/>
					Email: <a href="ubiattendance@ubitechsolutions.com">ubiattendance@ubitechsolutions.com<a><br/>
					Skype: ubitech.solutions
					</p>
					<p style="text-align:left;font-size:13px">You have received this email because your are a registered member on ubiAttendance App. If you do not want to receive this mailer, <a href="#">unsubscribe<a>. To make sure this email is not sent to your "junk" folder, Add “<a href="ubiattendance@ubitechsolutions.com">ubiattendance@ubitechsolutions.com</a>” to your Address Book</p></div>';
			
			$message.='</center>';
			print_r($message);
			}
			
			else{
				$message ='<center><img src="http://ubitechsolutions.com/ubitechsolutions/Mailers/ubiAttendance/ubiAttendance/logo.png" width="250px;"/></center>';
			$message.='<center><h3 style="color:green;padding:0px; margin:0px;">
			Yesterday'."'".'s Attendance Summary</h3>';
			$message.='['.$date.']<br/>';
			
			if(count($r['pending'])>0){
			$message.= '<div><h3 style="margin-bottom:5px;" >Time Out Not Marked</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>Employee</th><th>Time In</th><th>Time Out</th></tr>';
				foreach($r['pending'] as $emp){
					$message.= '<tr><td align="left" style="padding-left:2%">'. $emp->name . '</td><td align="center">'. date("H:i",strtotime($emp->TimeIn)) .'</td><td align="center">--</td></tr>';
				}
				$message.='</table></div>';
			}
			if(count($r['abs'])>0){
			$message.= '<div><br><h3 style="margin-bottom:5px;" >Absentees</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>Employee</th><th>Time In</th><th>Time Out</th></tr>';	
				foreach($r['abs'] as $emp){
					$message.= '<tr><td align="left" style="padding-left:2%">'.$emp->name.'</td><td align="center">--</td><td align="center">--</td></tr>';
				}
			$message.= '</table></div>';
			}
			if(count($r['late'])>0){
			$message.= '<div><br><h3 style="margin-bottom:5px;" >Late Comers</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>Employee</th><th>Time In</th><th>Time Out</th></tr>';	
				foreach($r['late'] as $emp){
					$message.= '<tr><td align="left" style="padding-left:2%">'.$emp->name.'</td><td align="center">'.date("H:i",strtotime($emp->TimeIn)).'</td><td align="center">'.date("H:i",strtotime($emp->TimeOut)).'</td></tr>';
				}
			$message.= '</table></div>';
			}
			if(count($r['early'])>0){
			$message.= '<div><br><h3 style="margin-bottom:5px;" >Early Leavers</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>Employee</th><th>Time In</th><th>Time Out</th></tr>';	
			
				foreach($r['early'] as $emp){
					$message.= '<tr><td align="left" style="padding-left:2%">'.$emp->name.'</td><td align="center">'.date("H:i",strtotime($emp->TimeIn)).'</td><td align="center">'.date("H:i",strtotime($emp->TimeOut)).'</td></tr>';
				}
			$message.= '</table></div>';
			}
			if(count($r['timeoff'])>0)
			{
			$message.= '<div><br><h3 style="margin-bottom:5px;" >Time Off List (Approved)</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>Employee</th><th>Timings</th><th>Total Time </th width="40%"><th>Reason</th></tr>';
				
				foreach($r['timeoff'] as $emp){
					$message.= '<tr><td align="left" style="padding-left:2%">'.$emp->name.'</td><td align="center">'.date("H:i",strtotime($emp->TimeFrom)).' - '.date("H:i",strtotime($emp->TimeTo)).'</td><td align="center">'.date("H:i",strtotime($emp->Total)).'</td><td  width="40%">'.$emp->Reason.'</td></tr>';
				}
			$message.= '</table></div>';
			}
			if(count($r['geoloc'])>0){
			$message.= '<div><br><h3 style="margin-bottom:5px;" >Attendance Marked outside the Fenced Area</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>Employee</th><th>Time In</th><th>Time Out</th></tr>';	
				
				foreach($r['geoloc'] as $emp){
					$message.= '<tr><td align="left" style="padding-left:2%">'.$emp['Name'].'</td><td align="center">'.$emp['ti'].$emp['positionlin'].'</td><td align="center">'.$emp['to'].$emp['positionout'].'</td></tr>';
				}
			$message.= '</table></div>';
			}
			$message.= '<div style="width:50%" ><p style="text-align:left">
			Report sent on 
			<b>'.$date.'</b> at <b>'.$time.'</b><br/>
			View more details on – <span><a href="https://ubiattendance.ubihrm.com">https://ubiattendance.ubihrm.com/</a><span></p>
			<p style="text-align:left;font-weight:bold">Cheers,<br/>
			Team ubiAttendance<br/>
			<a href="www.ubiattendance.com">www.ubiattendance.com</a><br/>
			Tel / Whatsapp: +91 70678 22132<br/>
			Email: <a href="ubiattendance@ubitechsolutions.com">ubiattendance@ubitechsolutions.com<a><br/>
			Skype: ubitech.solutions
			</p>
			<p style="text-align:left;font-size:13px">You have received this email because your are a registered member on ubiAttendance App. If you do not want to receive this mailer, <a href="#">unsubscribe<a>. To make sure this email is not sent to your "junk" folder, Add “<a href="ubiattendance@ubitechsolutions.com">ubiattendance@ubitechsolutions.com</a>” to your Address Book</p></div>';
		    $message.='</center>';
			print_r($message);
	  }
		}
	   
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
		
} ?>
