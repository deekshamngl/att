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
	if($this->db->affected_rows() > 0){


						
						
					$date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $id =$_SESSION['id'];
           
           $module = "Settings";
           $actionperformed = " <b>Daily Attendance Summary</b>  has been <b>updated  </b>.";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));

					

	}
 }

 public function getpreviousTimeOffApprovalSts($user_id,$org_id,$employeetimeoffid){
// $orgid = $_SESSION['orgid'];
$sql1 = "select * from TimeoffApproval WHERE TimeofId =? AND ApproverId=? and OrganizationId=?";
			$query1 = $this->db->query($sql1,array( $employeetimeoffid,$user_id,$org_id));
			// $query1->execute(array( $employeetimeoffid,$user_id,$org_id));
			// $con=$query1->rowCount();
			$count1= $this->db->affected_rows();
			$ApproverSts='';
			if($r=$query1->row()){
				$ApproverSts=$r->ApproverSts;
			}
			return $ApproverSts;
			// var_dump($this->db->last_query());
			// var_dump($query1);



 }

 public function timeoffstatus(){


 	$orgid =$_SESSION['orgid'];
			$zone=getTimeZone($orgid);
  			date_default_timezone_set($zone);
  			$todaydate = date('Y-m-d');
  			
  		  	 $uid =  isset($_REQUEST['uid'])?$_REQUEST['uid']:0;
  		  	 $toid =  isset($_REQUEST['ApproverComment'])?$_REQUEST['ApproverComment']:0;
  		  	 $query = $this->db->query("Select * from Timeoff where Id = $uid AND 	ApproverComment	 = $toid ");
			 if($this->db->affected_rows()>0)
			 {
			 	$sql = "update TimeoffApproval set 	ApproverSts= 1,ApprovalDate = '$todaydate'   where Id = $uid";
  			   $query = $this->db->query($sql);
			 
			 echo $this->db->affected_rows();
			 } 	
			else
			{
				echo 2;
			}

 }
public function updatetimeoff($user_id,$org_id,$employeetimeoffid,$appSts)
	{

		$query = $this->db->query("select * from Timeoff ");
		$orgid=$_SESSION['orgid'];
		//$adminid =$_SESSION['id'];
		
		$timeoffid = $employeetimeoffid;

		//$timefrom = isset($_REQUEST['timefrom'])?$_REQUEST['timefrom']:"";
		//$timeto = isset($_REQUEST['timeto'])?$_REQUEST['timeto']:"";
		$sts = $appSts;
		$comment1 = isset($_REQUEST['comment'])?$_REQUEST['comment']:"";
		/*$timeoffdate = isset($_REQUEST['timeoffdate'])?$_REQUEST['timeoffdate']:"";
		if($timeoffdate != "")
		{
		  $timeoffdate = date('Y-m-d',strtotime($timeoffdate));	
		}*/
		// var_dump($comment1);
			if($sts==1 )
			{
			// $comment ='Rejected to Ubiattendance Admin';	
        $comment = $comment1;
			}
			else if($sts == 2)
			 {
				// $comment =  "Approved to  Ubiattendance Admin";
        $comment = $comment1;
        
			 }
			
			 
			 // else if($sts == 5)
			 // {
				// // $comment =  "Withdrawn to Ubiattendance Admin";
			 // }
			
		$zname=getTimeZone($orgid);
		date_default_timezone_set ($zname);
		$todaydate = date('Y-m-d');
		
		$query = $this->db->query("UPDATE Timeoff SET ApprovalSts='$sts', ModifiedDate='$todaydate' , ApproverComment='$comment1'   WHERE Id = '$timeoffid'");
		$count = $this->db->affected_rows();
		if($count > 0 && $sts !=3 )
		{
		  $query1 = $this->db->query("UPDATE TimeoffApproval SET  ApproverSts='$sts' ,ApprovalDate = '$todaydate', ApproverComment= '$comment1' WHERE TimeofId =  '$timeoffid' AND OrganizationId = '$orgid' ");
		}
		echo $count;	
	}

 public function getTimeOffApprovalSts($employeetimeoffid){
 	// $orgid = $_SESSION['orgid'];
			$sql1 = "select * from  Timeoff WHERE 	Id =? ";
			$query1 = $this->db->query($sql1,array( $employeetimeoffid));
			// $query1->execute(array( $employeetimeoffid));
			// $con=$query1->rowCount();
			$count1= $this->db->affected_rows();
			$ApproverSts='';
			if($r=$query1->row()){
			// if($r=$query1->row()){
				$ApproverSts=$r->ApprovalSts;
			}
			return $ApproverSts;
			 // var_dump($query1);

		}


public function visitstatus()
 {
 	$orgid = $_SESSION['orgid'];
 	$id = $_SESSION['id'];
	$sts = isset($_REQUEST['sts'])?$_REQUEST['sts']:'';
	$this->db->query("update admin_login set visitImageStatus='$sts' where OrganizationId=$orgid")
	;

	if($this->db->affected_rows() > 0){


						
						
					$date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $id =$_SESSION['id'];
           
           $module = "Settings";
           $actionperformed = " <b>Visit Image Setting</b>  has been <b>updated  </b>.";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));

					

	}

	
 }

 public function fencestatus(){

 	$orgid = $_SESSION['orgid'];
 	$id = $_SESSION['id'];
	$sts = isset($_REQUEST['sts'])?$_REQUEST['sts']:'';
	$this->db->query("update admin_login set fencearea='$sts' where OrganizationId=$orgid")
	;

	if($this->db->affected_rows() > 0){


						
						
					$date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $id =$_SESSION['id'];
           
           $module = "Settings";
           $actionperformed = " <b>Fence Area Setting</b>  has been <b>updated  </b>.";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));

					

	}
 }

 public function attstatus()
 {
 	$orgid = $_SESSION['orgid'];
	$sts = isset($_REQUEST['sts'])?$_REQUEST['sts']:'';
	$this->db->query("update admin_login set AttnImageStatus='$sts' where OrganizationId=$orgid");

	if($this->db->affected_rows() > 0){


						
						
					$date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $id =$_SESSION['id'];
           
           $module = "Settings";
           $actionperformed = " <b>Attendance Image Setting</b>  has been <b>updated  </b>.";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));

					

	}
 }
 public function getactiveStatus(){
 	$orgid = $_SESSION['orgid'];
 	$sql = $this->db->query("select * FROM Alert_Settings WHERE OrganizationId='$orgid'");
 	 return $sql->result();
 }
 
public function getactiveVisitStatus()
{
 	$orgid = $_SESSION['orgid'];
 	$sql = $this->db->query("select * FROM admin_login WHERE OrganizationId='$orgid'");
 	 return $sql->result();
 }
 public function getactiveAttStatus()
{
 	$orgid = $_SESSION['orgid'];
 	$sql = $this->db->query("select * FROM admin_login WHERE OrganizationId='$orgid'");
 	 return $sql->result();
 }
 	public function getoutsidefenceStatus(){
 	$orgid = $_SESSION['orgid'];
 	$sql = $this->db->query("select * FROM admin_login WHERE OrganizationId='$orgid'");
 	 return $sql->result();

 	}

 	public function image_status(){
 	$orgid = $_SESSION['orgid'];
 	$sql = $this->db->query("select * FROM licence_ubiattendance WHERE OrganizationId='$orgid' AND image_status ='1'");
 	// var_dump($this->db->last_query());
 	 return $sql->result();

 	}
public function forgotpswd()
       {
			//$org_id = $_SESSION['orgid'];
			$email=isset($_REQUEST['email'])?$_REQUEST['email']:'';
			//$zone=getTimeZone($org_id);
            //   date_default_timezone_set($zone);
			if($email!='')
			{
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
					// More  headers
					$headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
					//$headers .= 'Cc: vijay@ubitechsolutions.com' . "\r\n";
					$subject ="ubiAttendance- password reset link.";
					sendEmail_new($email,$subject,$message);
					sendEmail_new('vijay@ubitechsolutions.com',$subject,$message);	
					echo 2;
				 }
			 }
			 else
				 echo 0;
			}
					else
				 echo 1;			
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
	
	foreach($sql->result() as $rows)
	{
		$data['id'] = $rows->Id;
		$id = $rows->Id;
		$data['name'] = $rows->Name;
		$sql1 = $this->db->query("SELECT count(Id)as totalEmp FROM AttendanceMaster WHERE AttendanceDate='$todate'  and EmployeeId IN (SELECT Id FROM EmployeeMaster WHERE OrganizationId=$orgid AND Department=$id AND DOL = '0000-00-00' AND Is_Delete = 0 )");
		
		if($row =  $sql1->result())
		{
		   $data['totalemp'] = $row[0]->totalEmp;
		}
		
		
		
		// $sql3 = $this->db->query("SELECT count(Id)as absEmp FROM AttendanceMaster WHERE AttendanceDate='$todate'  AND AttendanceStatus =2 and  EmployeeId IN (SELECT Id FROM EmployeeMaster WHERE OrganizationId=$orgid AND Department=$id AND DOL = '0000-00-00' AND Is_Delete = 0 ) ");
		
		// if($row =  $sql3->result())
		// {
		// $data['absemp'] = $row[0]->absEmp;
		// }
		
		
			// $sql4 = $this->db->query("SELECT count(A.Id) as lateEmp FROM AttendanceMaster A,ShiftMaster S WHERE A.AttendanceDate='$todate'  and A.`TimeIn`>S.`TimeIn` and A.EmployeeId IN (SELECT Id FROM EmployeeMaster WHERE OrganizationId=$orgid AND Department=$id AND DOL = '0000-00-00' AND Is_Delete = 0 ) AND S.Id=A.ShiftId ");
		
			// if($row =  $sql4->result())
			// {
			// $data['lateemp'] = $row[0]->lateEmp;
			// }
			
			
		// $sql5 = $this->db->query("SELECT count(A.Id) as earlyEmp  FROM AttendanceMaster A,ShiftMaster S WHERE A.AttendanceDate='$todate'  and S.`TimeOut`> A.`TimeOut` and A.EmployeeId IN (SELECT Id FROM EmployeeMaster WHERE OrganizationId=$orgid AND Department=$id AND DOL = '0000-00-00' AND Is_Delete = 0 ) AND S.Id=A.ShiftId and A.`TimeOut`!='00:00:00' ");
		
			// if($row =  $sql5->result())
			// {
			// $data['earlyemp'] = $row[0]->earlyEmp;
			// }	

		$sql2 = $this->db->query("SELECT count(Id) as allEmp FROM EmployeeMaster WHERE OrganizationId=$orgid AND Department=$id   AND DOL = '0000-00-00' AND Is_Delete = '0' ");
		if($row1 = $sql2->result())
		{
			$data['allemp'] = $row1[0]->allEmp;
		}
		$res[] = $data;
	}
	 return $res;
}
		public function statuschanged()
		{
			$orgid = $_SESSION['orgid'];
			$sql=$this->db->query("update Organization set DataDeleteSts=1 where Id='$orgid'");
			if($sql>0)
			{
				$_SESSION['datadelsts']=1;
				echo "1";
			}
		}



		public function login()
		{			
			$username=isset($_REQUEST['username'])?$_REQUEST['username']:'';
			$remmberme=isset($_REQUEST['remmberme'])?$_REQUEST['remmberme']:'';
			$password=encrypt(isset($_REQUEST['password'])?$_REQUEST['password']:'');
		 
			//echo "SELECT A.id,A.name ,A.OrganizationId,end_date,L.status FROM admin_login A,licence_ubiattendance L WHERE A.username= '$username' and A.password='$password' and A.archive='1' and A.OrganizationId=L.OrganizationId";
			
			$query = $this->db->query("SELECT A.id,A.name ,A.OrganizationId,end_date,L.status,O.delete_sts FROM admin_login A,licence_ubiattendance L, Organization O WHERE A.username= ? and A.password=? and A.archive='1' and A.OrganizationId=L.OrganizationId and A.OrganizationId=O.Id and O.delete_sts='0' ", array($username,$password));

			// var_dump($this->db->last_query());
			// die;
			
			if($row=$query->result())
			{
				$_SESSION['p_status'] = $row[0]->status;// lic master 0 trial/ 1 paid
				$_SESSION['orgName']=getOrgName($row[0]->OrganizationId);	
				$_SESSION['Email']=getAdminEmail($row[0]->OrganizationId);
				//echo $_SESSION['Email'];
				$_SESSION['attendanceAdmin']=true;
				$_SESSION['orgid']=$row[0]->OrganizationId;
				$_SESSION['id']=$row[0]->id;
				$_SESSION['name']=ucfirst($row[0]->name);
				$_SESSION['specialCase']=$row[0]->OrganizationId==502?'RAKP':'common';
				$today = date('Y-m-d');
				$last_date = $row[0]->end_date;// lic master
				$datadelsts=getDataDeleteSts($row[0]->OrganizationId);
				$_SESSION['datadelsts']=$datadelsts;
				
				if($today > $last_date)
				{
					$_SESSION['expirydate'] = 1;//admin out of expiry date
					return 1;
				}
				else 
				{
					$_SESSION['expirydate'] = 0; //admin with in expiry date-- valid case
					return 2;
				}
			}
			else 
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
		
		public function getDashboadAttendance($data)
		{
            $fromDate = date('Y-m-d', strtotime('-7 days', strtotime($data)));
             $data1=array();  
            
             $id = $_SESSION['orgid'];
              $query = $this->db->query("select count(AttendanceDate) as total,AttendanceDate from AttendanceMaster where OrganizationId =$id and (AttendanceDate BETWEEN '$fromDate' AND '$data') group by AttendanceDate");
				//echo  $query->result();
               $data1['result'] =  json_encode($query->result());
			$query = $this->db->query("SELECT count(Id) as maxemp FROM `UserMaster` WHERE `OrganizationId`=$id");
			$data1['maxemp'] =  json_encode($query->result());
			$this->db->close();
              echo json_encode( $data1);
			  
		}
		public function getMonthlyAttChart()
		{ 
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
				$res['PhoneNumber'] =$row['PhoneNumber'];
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
			$sname= $_SESSION['name'];
			$query = $this->db->query("SELECT * FROM admin_login where OrganizationId =$id and name ='$sname'" );
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
		
		
		public function updateCProfile()
		{
			$id = $_SESSION['orgid'];
			// $sname= $_SESSION['name'];
			$cpname = isset($_REQUEST['cpname'])?$_REQUEST['cpname']:'';
			$cpwebsite = isset($_REQUEST['cpwebsite'])?$_REQUEST['cpwebsite']:'';
			$pname = isset($_REQUEST['pname'])?$_REQUEST['pname']:''; // contact person
			$puname = isset($_REQUEST['puname'])?$_REQUEST['puname']:'';
			$cppnumber = isset($_REQUEST['cppnumber'])?$_REQUEST['cppnumber']:'';
			$cpemail = isset($_REQUEST['cpemail'])?$_REQUEST['cpemail']:'';
			$cpaddress = isset($_REQUEST['cpaddress'])?$_REQUEST['cpaddress']:'';
			$query = $this->db->query("update Organization set Name='$cpname', Website='$cpwebsite', Address='$cpaddress',Email='$cpemail' where Id = $id ");
			if($query>0){
				// $_SESSION['name']=$pname;
				$date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $sesid =$_SESSION['id'];
           $sesname =$_SESSION['name'];
            
            
            
           $module = "Settings";
           $actionperformed = " <b>Company</b> details has been <b>Updated</b>";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$sesid));

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
			 $id = $_SESSION['id'];
			 $cpassword = encrypt(isset($_REQUEST['cpassword'])?$_REQUEST['cpassword'] : '');
			 $npassword = encrypt(isset($_REQUEST['npassword'])?$_REQUEST['npassword'] : '');
			 $newpass = isset($_REQUEST['npassword'])?$_REQUEST['npassword'] : '';
			 $rtpassword =encrypt(isset($_REQUEST['rtpassword'])?$_REQUEST['rtpassword']: '');
			$query = $this->db->query("select * from admin_login where password='$cpassword' and id = $id");
			$result = $query->num_rows();
			if($result>0){
				$query1 = $this->db->query("update admin_login set password='$rtpassword' where id = $id");
				if($query1>0){
				$message = '<p>Dear '.$_SESSION['name'].'</p>
                     <p>Your Password for ubiAttendance Web Admin Panel has been changed successfully. ubiAttendance Team</p>
					 <p><b>Your New Pawword : '.$newpass.'</b></p>';
                 // $_SESSION['Email'] 
                 sendEmail_new($_SESSION['Email'],'New Password',$message,'');				 
				sendEmail_new('sohan@ubitechsolutions.com','New Password',$message,'');	
				// sohan
					$date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $sesid =$_SESSION['id'];
           // $sesname =$_SESSION['name'];
            
            
            
           $module = "Settings";
           $actionperformed = " <b>Web Admin Panel password </b> has been <b>Changed</b>";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$sesid));


					
				
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
									if($row222 = $query222->row())
									{
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
		public function getLateEmployee__new($deprtid)
		{
			//echo $ids;
			$org_id = $_SESSION['orgid'];
			$zone=getTimeZone($org_id);
			$res = array(); 
            date_default_timezone_set($zone);
			$date = date("Y-m-d");
			//$date = '2019-05-30';
			//$deprtid=isset($_REQUEST['id'])?$_REQUEST['id']:0;
			//echo $deprtid;
			$q1='';
			if($deprtid !=0) 
				{
			    $q1.=" AND A.Dept_id = '$deprtid'";
				}
			$sql="SELECT A.device,A.AttendanceDate ,E.Id, A.EmployeeId as empid,A.timeindate, E.EmployeeCode,TIMEDIFF(CONCAT(A.timeindate,' ',A.TimeIn),CONCAT(A.AttendanceDate,' ',S.TimeIn)) as time,A.ShiftId as ShiftId ,S.TimeInGrace, A.Dept_id as deptid, A.Desg_id as desid, A.TimeIn as atimein ,S.TimeIn as stimein,S.TimeOut as stimeout,S.Name as sname  FROM  AttendanceMaster  A,EmployeeMaster E ,ShiftMaster S  WHERE A.ShiftId=S.Id AND A.OrganizationId = S.OrganizationId AND A.TimeIn > (select(case when(S.TimeInGrace !='00:00:00') then S.TimeInGrace else S.TimeIn end) from ShiftMaster S where S.Id=ShiftId) AND A.AttendanceDate = '$date' AND A.OrganizationId = '$org_id' AND  A.TimeIn != '00:00:00'  and A.EmployeeId=E.Id $q1 order by A.TimeIn";
			$query = $this->db->query($sql);
			
			foreach($query->result() as $row)
			{
				$data = array();
				$name = ucwords(getEmpName($row->empid));
					if($name != "")
					{
					$data['Name'] = $name;
					$data['code'] = $row->EmployeeCode;
					// $data['late_by'] = substr(($row->time),0,5);
					$a = new DateTime(substr (getShiftTimes($row->ShiftId),0,5));
					$c = new DateTime($row->TimeInGrace);
					$b = new DateTime($row->atimein);

					$interval = "";
				    if($row->TimeInGrace = "00:00:00"){
					$interval =$b->diff($c);
					}
					else{

						$interval =$c->diff($a);
					   }

					$data['late_by'] = $interval->format("%H:%I");

					$data['deprt'] = getDepartmentByEmpID($row->empid);
					$data['Designation'] = getDesignationByEmpID($row->empid);
					$data['shift'] = $row->sname." ( ".substr(($row->stimein),0,5)." - ".substr(($row->stimeout),0,5)." )";
					$data['TimeIn'] = substr(($row->atimein),0,5);

					$data['device'] = $row->device;
					$res[] = $data;
					}

	// var_dump($row->time);
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
		public function getEarlyEmploy__new($deprtid)
		{
			$res = array();
			$org_id = $_SESSION['orgid'];
			$zone=getTimeZone($org_id);
            date_default_timezone_set($zone);
			$date = date("Y-m-d");
			//$date ='2019-09-05';
			//$deprtid=isset($_REQUEST['id'])?$_REQUEST['id']:0;
			$q1='';
			if($deprtid !=0) 
				{
					$q1.=" AND A.Dept_id = '$deprtid'";
				}
				
			$query = $this->db->query("SELECT A.AttendanceStatus,S.TimeOutGrace,A.device,E.Id,A.AttendanceDate,A.EmployeeId as empid ,A.ShiftId as sid,E.EmployeeCode ,if(A.timeoutdate!='0000-00-00',TIMEDIFF(CONCAT(A.AttendanceDate,' ',S.TimeOut),CONCAT(A.timeoutdate,' ',A.TimeOut)),TIMEDIFF(CONCAT(A.AttendanceDate,' ',S.TimeOut),CONCAT(A.AttendanceDate,' ',A.TimeOut))) as time, A.Dept_id as deptid, A.Desg_id as desid, A.TimeOut as atimeout ,S.TimeIn as stimein,S.TimeOut as stimeout,S.Name as sname,A.timeoutdate  FROM  AttendanceMaster  A ,ShiftMaster S,EmployeeMaster E  WHERE A.ShiftId=S.Id AND A.OrganizationId = S.OrganizationId  AND A.TimeOut < S.TimeOut AND A.TimeOut < (select(case when(S.TimeOutGrace !='00:00:00') then S.TimeOutGrace else S.TimeOut end) from ShiftMaster S where S.Id =ShiftId) AND A.AttendanceDate = '$date' AND A.OrganizationId = '$org_id' AND  A.TimeOut != '00:00:00' and A.EmployeeId=E.Id  $q1 order by A.TimeOut");
			foreach($query->result() as $row)
			{
				$data = array();
				if($row->AttendanceStatus==4)
				{
				$name = ucwords(getEmpName($row->empid));
				$earlyhalfday=$this->earlyleavehalfday($row->empid,$date);
					if($name != "" && $earlyhalfday!="")
					{
					$data['Name'] = $name;
					$data['code'] = $row->EmployeeCode;
					$data['early_by'] = $earlyhalfday;
					$data['deprt'] = getDepartmentByEmpID($row->empid);
					$data['Designation'] = getDesignationByEmpID($row->empid);
					$data['shift'] = $row->sname." ( ".substr(($row->stimein),0,5)." - ".substr(($row->stimeout),0,5)." )";
					$data['TimeOut'] = substr(($row->atimeout),0,5);
					$data['device'] = $row->device;
					$res[] = $data;
					}
				}
				else
				{
					if(strpos($row->time,'-')!==0)
						{
					$name = ucwords(getEmpName($row->empid));
						if($name != "")
							{
							$data['Name'] = $name;
							$data['code'] = $row->EmployeeCode;
							$data['early_by'] = substr(($row->time),0,5);

							// ----------------------------------------

							$a = new DateTime(substr (getShiftTimes($row->sid),0,5));
									$c = new DateTime($row->TimeOutGrace);
									$b = new DateTime($row->atimeout);
									// var_dump($a);

									// var_dump($b);
									// var_dump($c);
									// die;

									$interval = "";
									
									if($row->TimeOutGrace == "00:00:00"){
									$interval =$b->diff($a);
								}else{
									$interval =$b->diff($c);
								}
									
                                 $data['early_by'] = $interval->format("%H:%I");
							// ------------------------------------
							$data['deprt'] = getDepartmentByEmpID($row->empid);
							$data['Designation'] = getDesignationByEmpID($row->empid);
							$data['shift'] = $row->sname." ( ".substr(($row->stimein),0,5)." - ".substr(($row->stimeout),0,5)." )";
							$data['TimeOut'] = substr(($row->atimeout),0,5);
							$data['device'] = $row->device;
							$res[] = $data;
							}
						}
				}
			}
			return $res;
			
		}
		
		function earlyleavehalfday($empid,$date)
		{
			$org_id = $_SESSION['orgid'];
			$query = $this->db->query("SELECT  TIMEDIFF(S.TimeInBreak,A.TimeOut) AS early FROM AttendanceMaster A,ShiftMaster S WHERE A.EmployeeId = ($empid) AND A.OrganizationId= $org_id AND A.AttendanceDate = '$date'  and S.TimeInBreak >A.TimeOut AND S.TimeInBreak !='00:00:00' AND A.TimeOut != '00:00:00'  AND S.Id = A.ShiftId ");
		    if($row = $query->result_array())
			 {
				if($row[0]["early"] != null)
				{
					$length = strlen($row[0]["early"])-3;
					return (substr($row[0]["early"],0,$length));
				}
				else 
					return "00:00";
			 }
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
		///////////
		public function thirtydays()
		{
			 $res=array();
			 $data = array();
			 $org_id = $_SESSION['orgid'];
			 $enddate=date("Y-m-d");
			 $startdate=date('Y-m-d', strtotime('-29 day', strtotime($enddate)));
			
			 $query = $this->db->query("Select A.Id FROM AttendanceMaster A,EmployeeMaster E, ShiftMaster C where A.AttendanceDate between '$startdate' and '$enddate'   and A.AttendanceStatus in (1,8,4) And C.Id = A.ShiftId AND E.Id=A.EmployeeId And A.TimeIn != '0000:00:00' and A.OrganizationId = ".$org_id );
			 
			  $count=$query->num_rows();
			   $data['label'] = 'Present:'.$count;
			  $data ['presentee'] = $count;
			  
			
			 
			$begin = new DateTime($startdate);
			$interval = new DateInterval('P1D'); // 1 Day
			$realEnd = new DateTime($enddate);
			$realEnd->add($interval);
			$dateRange = new DatePeriod($begin,$interval,$realEnd);	
			$range = "";
		     	$zname=getTimeZone($org_id);
				date_default_timezone_set ($zname);
				$todate = date('Y-m-d');
				$time = date("H:i:s");
				$i = 0;
				$count1=0;
		 foreach ($dateRange as $date) 
		  {
		        $range = $date->format('Y-m-d');
				$query = "";
				$count=0;
			if(strtotime($range)==strtotime($todate))
			{
			$query = $this->db->query("Select  E.Id as EmployeeId,'".$todate."' as AttendanceDate FROM EmployeeMaster E,ShiftMaster S Where  E.Id NOT IN (select A.EmployeeId From AttendanceMaster A where A.AttendanceDate= '".$todate."'  AND  A.OrganizationId= ".$org_id." AND AttendanceStatus  IN (1,8,4) )  AND E.OrganizationId = ".$org_id ." AND E.Shift = S.Id AND S.TimeIn < '$time'  AND E.archive = 1   group By EmployeeId");
			$count=$query->num_rows();
			}
			else
			{
			$query = $this->db->query("Select A.Id FROM AttendanceMaster A,EmployeeMaster E where A.AttendanceDate = '".$range."'    and A.AttendanceStatus in (2,6,7) AND E.Id=A.EmployeeId AND E.archive = 1 and A.OrganizationId = ".$org_id );
			$count=$query->num_rows();
			}
			
			$count1=$count+$count1;
		  }	
		  
			$data ['absentee'] = $count1;
			$data['label1'] = 'Absent:'.$count1;
			 
			$query = $this->db->query("SELECT A.Id FROM  AttendanceMaster  A ,ShiftMaster S,EmployeeMaster E  WHERE A.ShiftId = S.Id AND A.OrganizationId = S.OrganizationId AND concat(A.timeindate,' ',A.TimeIn) > concat(A.AttendanceDate,' ',S.TimeIn) AND A.AttendanceDate between '$startdate' and '$enddate' AND A.OrganizationId = '$org_id' AND  A.TimeIn != '00:00:00' AND  E.Id = A.EmployeeId AND E.OrganizationId = A.OrganizationId AND E.Is_Delete = 0  order by A.TimeIn");
			 
			  $count=$query->num_rows();
			   $data['label2'] = 'Latecomers:'.$count;
			  $data ['latecomer'] = $count;



			 $query = $this->db->query("SELECT A.Id FROM  AttendanceMaster  A ,ShiftMaster S,EmployeeMaster E  WHERE A.ShiftId=S.Id AND A.OrganizationId = S.OrganizationId AND concat(A.timeoutdate,' ',A.TimeOut) < concat(A.AttendanceDate,' ',S.TimeOut) AND A.AttendanceDate between '$startdate' and '$enddate' AND A.OrganizationId = '$org_id'  AND  A.TimeOut != '00:00:00' AND  A.OrganizationId = E.OrganizationId AND A.EmployeeId = E.Id AND E.Is_Delete =0" );
			// ECHO $this->db->last_query();
			 
			  $count=$query->num_rows();
			   $data['label3'] = 'Earlyleaver:'.$count;
			  $data ['earlyleaver'] = $count;
			  $res[] = $data;
			 return json_encode($res);
		}
		////
		public function EarlyleaveEmployee(){
			$res=array();
			$data = array();
			$org_id = $_SESSION['orgid'];
			$sql = "select DISTINCT AttendanceDate from AttendanceMaster where  OrganizationId = $org_id 
		  ORDER BY AttendanceDate Desc LIMIT  7";
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
			//echo "select DISTINCT A.AttendanceDate from AttendanceMaster A , EmployeeMaster E where  A.OrganizationId = $org_id AND A.EmployeeId = E.Id AND E.Is_Delete = 0 ORDER BY AttendanceDate Desc LIMIT 8";
			foreach($sql->result() as $row)
			{
			 $date = $row->AttendanceDate; 
			// $date ='2019-09-05';
			 $query = $this->db->query("SELECT A.Id FROM  AttendanceMaster  A ,ShiftMaster S  WHERE A.ShiftId=S.Id AND A.OrganizationId = S.OrganizationId AND concat(A.timeoutdate,' ',A.TimeOut)< concat(A.AttendanceDate,' ',S.TimeOut)AND A.AttendanceDate = '$date'  AND A.OrganizationId = '$org_id' AND  A.TimeOut != '00:00:00'");
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
			from AttendanceMaster A ,EmployeeMaster E where  A.OrganizationId = '$org_id' AND  E.Id = A.EmployeeId AND A.OrganizationId = E.OrganizationId and archive=1 AND E.Is_Delete = 0  ORDER BY A.AttendanceDate Desc LIMIT 8");
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
			  $res= $this->db->affected_rows() ;
				 if($res)
				 { 
				 $data['status']= true; 
				 $data['sms']= "Geo Fence Created Successfully";

				  $date = date("y-m-d H:i:s");
				   $orgid =$_SESSION['orgid'];
				   $id =$_SESSION['id'];
				   $module = "Settings";
				   $actionperformed = " <b>".$name." Geo Location</b> is added from <b> Geo Fence.</b>";
				   $activityby = 1;
				   
				    $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module,ActivityBy, ActionPerformed,adminid, OrganizationId) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module, $activityby,$actionperformed,$id,$orgid)); 

				    // var_dump($this->db->last_query());
				 }
				 else
				 {
				   $data['status']= false; 
				   $data['sms']= "There is some problem while creating geo fence"; 
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
					 data-radius="'.number_format((float)$row->Radius, 2, '.', '').'" 
					 data-sts="'.$row->Status.'"
					data-target="#addDeptE">edit</i>
					</a>
				   <i class="delete fa fa-trash" style="font-size:24px; color:purple;" data-toggle="modal" data-target="#delDept" data-did="'.$row->Id.'" data-dname="'.$row->Name.'" title="Delete" ></i>
					<i class="upGeolocation fa fa-check-square-o" style="font-size:24px; color:purple" data-toggle="modal" data-target="#updateGeolocation" onclick="angular.element(this).scope().GetEmpList1(\''.$row->Id.'\')" 
					data-sid="'.$row->Id.'" data-sname="'.$row->Name.'" 
					title="Assign employee(s)" ></i>				   
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
		
		$query = $this->db->query($sql,array($orgid,$geoid));
		
			foreach($query->result() as $row)
			{
				$res = array();
				$res['id'] = $row->Id;
				$res['name'] = $row->EmployeeCode." - ".ucwords(strtolower($row->FirstName." ".$row->LastName));
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
		$query121 = $this->db->query("SELECT `Id`, `Name`, `Lat_Long`, `Location`, `Radius`, `archive`, `OrganizationId`, `Status`, `LastModifiedById`, `LastModifiedDate` FROM `Geo_Settings` WHERE Id=$did ");
		$query = $this->db->query("select id as totemp from EmployeeMaster where EmployeeMaster.area_assigned=? and OrganizationId=? and Is_Delete != 2",array($did,$orgid));
		$data['emp']=$query->num_rows();

		// $query = $this->db->query("select id as totarc from ArchiveAttendanceMaster where ArchiveAttendanceMaster.areaId=? and OrganizationId=?",array($sid,$orgid));
		// 	$data['ararc']=$query->num_rows();
		if($data['emp']==0)
		{
		$query = $this->db->query("DELETE FROM `Geo_Settings` where id=? and OrganizationId=?",array($did,$orgid));
		$data['afft']=$this->db->affected_rows();
		if($data['afft'] > 0){
			if ($r=$query121->result()){
							$name  = $r[0]->Name;

			 $date = date("y-m-d H:i:s");
				   $orgid =$_SESSION['orgid'];
				   $id =$_SESSION['id'];
				   $module = "Settings";
				   $actionperformed = " <b>".$name." Geo Location</b> has been <b>Deleted</b> from <b> Geo Fence</b> ";
				   $activityby = 1;
				   
				    $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module,ActivityBy, ActionPerformed,adminid, OrganizationId) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$activityby,$actionperformed,$id,$orgid));
				}
		}
		}
		$this->db->close();
		echo json_encode($data);
  }
  public function editLocation()
  {
	    $orgid = $_SESSION['orgid'];
		$did = isset($_REQUEST['did'])?$_REQUEST['did']:'';  
		$name = isset($_REQUEST['dna'])?$_REQUEST['dna']:'';  
		$radius = isset($_REQUEST['dra'])?$_REQUEST['dra']:'';  
		$status = isset($_REQUEST['sts'])?$_REQUEST['sts']:'';
		
       $query = $this->db->query("UPDATE Geo_Settings set Name = '$name',	Radius= '$radius',Status = '$status' where Id = '$did' AND OrganizationId = '$orgid' ");
       echo  $this->db->affected_rows();
       if($this->db->affected_rows()>0){
       	 $date = date("y-m-d H:i:s");
				   $orgid =$_SESSION['orgid'];
				   $id =$_SESSION['id'];
				   $module = "Settings";
				   $actionperformed = "<b>Details</b> has been <b>Updated </b> for <b>".$name." Geo Location</b> ";
				   $activityby = 1;
				   
				    $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module,ActivityBy, ActionPerformed,adminid, OrganizationId) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$activityby,$actionperformed,$id,$orgid));
       }
			   
  }
  ////////////////
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
					//$date1 = '2019-09-05';
				 }
				 else
				 {
					$date=date('d-M-Y',strtotime('-1 day'));
					$date1 = date("Y-m-d",strtotime('-1 day'));
					//$date1 = '2019-07-24';
					//$date1 = '2019-09-05';
				 }
					$list=array();
					$list['orgid']=$orgid;
					$list['admin']=getAdminName($orgid);
					$list['email']=getAdminEmail($orgid);
				
			/////////////Present Employee////////////////
			$sql="SELECT CONCAT(E.FirstName,' ',E.LastName) as name ,A.Id ,A.timeoutdate as timeoutdate, A.EmployeeId,C.TimeIn as ctin ,C.TimeOut as ctout,A.AttendanceDate as date , A.AttendanceStatus, A.TimeIn, A.TimeOut FROM AttendanceMaster A , ShiftMaster C,EmployeeMaster E  WHERE  A.TimeIn != '00:00:00'  and A.TimeOut!= '00:00:00' And C.Id = A.ShiftId  And A.AttendanceDate=? and  A.AttendanceStatus in (1,4,8) and A.OrganizationId=? AND E.Id=A.EmployeeId AND E.Is_Delete = '0' order by name";
			
			$query = $this->db->query($sql,array($date1,$orgid));
			
			$list['present']=$query->result();	
			
				
			
				
		////////////late comers
			$query = $this->db->query("SELECT CONCAT(E.FirstName,' ',E.LastName) as name , A.TimeIn,A.timeindate, A.TimeOut, TIMEDIFF(CONCAT(A.timeindate,' ',A.TimeIn) ,CONCAT( A.AttendanceDate,' ',(select time(TimeIn) from ShiftMaster where ShiftMaster.Id=shiftId))) as latecome ,'Present' as status,A.EntryImage,A.ExitImage FROM AttendanceMaster A,EmployeeMaster E WHERE (time(A.TimeIn) > (select time(TimeIn) from ShiftMaster where ShiftMaster.Id=shiftId))  and A.AttendanceDate = ? and  A.OrganizationId = ? and A.AttendanceStatus in (1,4,8) AND E.Id = A.EmployeeId AND E.Is_Delete = 0 order by name",array($date1,$orgid));
			$list['late']=$query->result();	
			
		
		
		////////////early leaver
			//$query = $this->db->query("SELECT CONCAT(E.FirstName,' ',E.LastName) as name , A.TimeIn, A.TimeOut,A.ShiftId,A.AttendanceStatus, TIMEDIFF( (select time(TimeOut) from ShiftMaster where ShiftMaster.Id=shiftId), A.TimeOut ) as earlyleave ,'Present' as status,A.EntryImage,A.ExitImage FROM AttendanceMaster A, EmployeeMaster E WHERE (time(A.TimeOut) < (select time(TimeOut) from ShiftMaster where ShiftMaster.Id=shiftId) and A.TimeOut!='00:00:00' ) and A.AttendanceDate=? AND A.OrganizationId=? and A.AttendanceStatus in(1,4,8) AND E.Id = A.EmployeeId AND E.Is_Delete = 0  order by `name`",array($date1,$orgid));
			
			$query=$this->db->query("SELECT CONCAT(E.FirstName,' ',E.LastName) as name , A.TimeIn, A.TimeOut,A.ShiftId,A.AttendanceStatus, if(A.timeoutdate!='0000-00-00',TIMEDIFF(CONCAT(A.AttendanceDate,' ',(select time(TimeOut) from ShiftMaster where ShiftMaster.Id=shiftId)),CONCAT(A.timeoutdate,' ',A.TimeOut)),TIMEDIFF(CONCAT(A.AttendanceDate,' ',(select time(TimeOut) from ShiftMaster where ShiftMaster.Id=shiftId)),CONCAT(A.AttendanceDate,' ',A.TimeOut))) as earlyleave ,'Present' as status,A.EntryImage,A.ExitImage,A.timeoutdate FROM AttendanceMaster A, EmployeeMaster E WHERE (time(A.TimeOut) < (select time(TimeOut) from ShiftMaster where ShiftMaster.Id=shiftId) and A.TimeOut!='00:00:00' ) and A.AttendanceDate=? AND
			A.OrganizationId=?  and A.AttendanceStatus in(1,4,8) AND E.Id = A.EmployeeId AND E.Is_Delete = 0  order by `name`",array($date1,$orgid));
			//$list['early']=$query->result();
			
			
			$res=array();
					foreach($query->result() as $row)
					{
						$res1=array();
						if(strpos($row->earlyleave,'-')!==0)
						{
							$res1['Name']=$row->name;
							$res1['earlyleave']=substr($row->earlyleave,0,5);
							$res1['timeout']=substr($row->TimeOut,0,5);
							$res1['sts']=substr($row->AttendanceStatus,0,5);
							$res1['shiftid']=substr($row->ShiftId,0,5);
							$res[] = $res1;
						}
					}
					$list['early']=$res;
					
			////////////Time off list
			$query = $this->db->query("SELECT CONCAT(E.FirstName,' ',E.LastName) as name , T.TimeFrom, T.TimeTo ,T.Reason, TIMEDIFF(T.TimeTo, T.TimeFrom) as Total FROM Timeoff T,EmployeeMaster E WHERE T.TimeofDate=? and  T.OrganizationId=? and T.ApprovalSts=2 AND E.Id = T.EmployeeId AND E.Is_Delete = 0 order by `name`",array($date1,$orgid));
			$list['timeoff']=$query->result();
			
			
		
			////////////forgot to mark timeout(timeout pending)
			$query = $this->db->query("SELECT CONCAT(E.FirstName,' ',E.LastName) as name , A.TimeIn,A.EntryImage FROM AttendanceMaster A , EmployeeMaster E WHERE ((A.TimeIn!='00:00:00' and A.TimeOut = '00:00:00') or (A.TimeIn = A.TimeOut)) and A.AttendanceDate=? and  A.OrganizationId=?  and A.AttendanceStatus=1 AND E.Id = A.EmployeeId AND E.Is_Delete = 0 order by name",array($date1,$orgid));
			$list['pending']=$query->result();	
			
		$query = $this->db->query("SELECT CONCAT(E.FirstName,' ',E.LastName) as name , '-' as TimeIn,'-' as TimeOut ,'Absent' as status FROM AttendanceMaster A, EmployeeMaster E WHERE A.AttendanceDate=?  and  A.OrganizationId=? and A.AttendanceStatus in (2,6,7) AND E.Id = A.EmployeeId AND E.Is_Delete = 0 order by `name`",array($date1,$orgid));
			$list['abs']=$query->result();
					
					
					
		 $query = $this->db->query("SELECT if(E.LastName!='NULL',CONCAT(E.FirstName,' ',E.LastName),E.FirstName)  as name , '-' as TimeIn,'-' as TimeOut ,'Absent' as status FROM  EmployeeMaster E,ShiftMaster S WHERE E.Id NOT IN (select A.EmployeeId From AttendanceMaster A where A.AttendanceDate= ?  AND  A.OrganizationId= ? AND AttendanceStatus  IN (1,8,4) )   and E.OrganizationId=?  AND E.Shift = S.Id AND S.TimeIn < '$time'  AND  E.Is_Delete = 0 AND E.archive = 1 order by `name`",array($date1,$orgid,$orgid));
		 $list['abstoday']=$query->result();	
					
		//Select '-' as device, E.Id as EmployeeId,E.EmployeeCode,E.Shift as ShiftId ,'".$todate."' as AttendanceDate FROM EmployeeMaster E,ShiftMaster S Where  E.Id NOT IN (select A.EmployeeId From AttendanceMaster A where A.AttendanceDate= '".$todate."'  AND  A.OrganizationId= ".$org_id." AND AttendanceStatus  IN (1,8,4) ) $s1 AND E.OrganizationId = ".$org_id ." AND E.Shift = S.Id AND S.TimeIn < '$time'  AND E.archive = 1   group By EmployeeId
		
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
							}
							else
							{
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
		
		
		$index=0;
		foreach($result as $r){
			
			if($type==1){
				$message ='<center>
				
				<img src=" https://ubiattendance.ubihrm.com/assets/img/newlogo.png" width="200px;"/>
				</center>';
				
			$message.='<center>
							<h3 style="color:green;padding:0px; margin:0px;">Daily Attendance Summary</h3>';
							$message.= '<h4 style="color:black;padding:0px; margin:0px;">'.$_SESSION['orgName'].'</h4>';

			$message.='['.$date.']<br/>';
			// $index=1;
			// if(count($r['pending'])>0)
			// {
			// $message.= '<div><br><h3 style="margin-bottom:5px;" >Time Out Not Marked</h3>
						// <table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804"><th>S.no</th><th>Employee</th><th>Time In</th><th>Time Out</th></tr>';
		
			// foreach($r['pending'] as $emp)
					// {
						// $message.= '<tr><td align="left"  style="padding-left:4%">'.($index++).'</td>
						// <td align="left"  style="padding-left:2%">'.$emp->name.'</td><td align="center">'. date("H:i",strtotime($emp->TimeIn)).'</td><td align="center">--</td></tr>';
					// }
				// $message.='</table></div>';
			// }
			$index=1;
			
			if(count($r['abstoday'])>0){
				
			$message.= '<div><br><h3 style="margin-bottom:5px;" >Absentees</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>S.No</th><th>Employee</th><th>Time In</th><th>Time Out</th></tr>';

				foreach($r['abstoday'] as $emp){
					$message.= '<tr><td align="left"  style="padding-left:4%">'.($index++).'</td><td align="left" style="padding-left:2%">'.$emp->name.'</td><td align="center">--</td><td align="center">--</td></tr>';
				}
			$message.= '</table></div>';
			}
			$index=1;
			if(count($r['late'])>0)
			{
			$message.='<div><br><h3 style="margin-bottom:5px;" >Late Comers</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804"><th>S.No</th><th>Employee</th><th>Time In</th><th>Late By</th></tr>';
						
				foreach($r['late'] as $emp)
				{
					$message.= '<tr><td align="left"  style="padding-left:4%">'.($index++).'</td><td align="left"  style="padding-left:2%">'.$emp->name.'</td><td align="center">'.date("H:i",strtotime($emp->TimeIn)).'</td><td align="center">'.date("H:i",strtotime($emp->latecome)).'</td></tr>';
				}
			$message.= '</table></div>';
			}
			$index=1;
			if(count($r['early'])>0){
			$message.= '<div><br><h3 style="margin-bottom:5px;" >Early Leavers</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804"><th>S.No</th><th>Employee</th><th>Time Out</th><th>Early By</th></tr>';	
			
				foreach($r['early'] as $emp)
				{
					if($emp['sts']==4)
					{
					$BreaksHalfday=getShiftBreaksHalfday($emp['shiftid']);
					$earlyhalfday=earlyhalfday($BreaksHalfday,$emp['timeout']);
						if($BreaksHalfday>$emp['timeout'])
						{
							$message.= '<tr><td align="left"  style="padding-left:4%">'.($index++).'</td><td align="left"  style="padding-left:2%">'.$emp['Name'].'</td><td align="center">'.$emp['timeout'].'</td><td align="center">'.date("H:i",strtotime($earlyhalfday)).'</td></tr>';
						}
						
					}
					else
					{
						$message.= '<tr><td align="left"  style="padding-left:4%">'.($index++).'</td><td align="left"  style="padding-left:2%">'.$emp['Name'].'</td><td align="center">'.$emp['timeout'].'</td><td align="center">'.$emp['earlyleave'].'</td></tr>';
						
					}
					
				}
			$message.= '</table></div>';
			}
			$index=1;
			if(count($r['timeoff'])>0)
			{
			$message.= '<div><br><h3 style="margin-bottom:5px;" >Time Off List (Approved)</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804"><th>S.No</th><th>Employee</th><th>Timings</th><th>Total Time </th width="40%"><th>Reason</th></tr>';
				
				foreach($r['timeoff'] as $emp)
				{
					$message.= '<tr><td align="left"  style="padding-left:4%">'.($index++).'</td><td align="left"  style="padding-left:2%">'.$emp->name.'</td><td align="center">'.date("H:i",strtotime($emp->TimeFrom)).' - '.date("H:i",strtotime($emp->TimeTo)).'</td><td align="center">'.date("H:i",strtotime($emp->Total)).'</td><td  width="40%" style="padding-left:3%">'.$emp->Reason.'</td></tr>';
				}
			$message.= '</table></div>';
			}
			$index=1;
			if(count($r['geoloc'])>0)
			{
			$message.= '<div><br><h3 style="margin-bottom:5px;" >Attendance Marked outside the Fenced Area</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>S.No</th><th>Employee</th><th>Time In</th><th>Time Out</th></tr>';	
					
				foreach($r['geoloc'] as $emp)
				{
					$message.= '<tr><td align="left" style="padding-left:2%">'.($index++).'</td><td align="left" style="padding-left:2%">'.$emp['Name'].'</td><td align="center">'.$emp['ti'].$emp['positionlin'].'</td><td align="center">'.$emp['to'].$emp['positionout'].'</td></tr>';
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
					</div>';
			
			$message.='</center>';
			print_r($message);
			}
			//////// yesterday's 
			else{
				$message ='<center>
				
				<img src=" https://ubiattendance.ubihrm.com/assets/img/newlogo.png" width="200px;"/></center>';
			$message.='<center><h3 style="color:green;padding:0px; margin:0px;">
			Yesterday'."'".'s Attendance Summary</h3>';
			$message.= '<h4 style="color:black;padding:0px; margin:0px;">'.$_SESSION['orgName'].'</h4>';
			$message.='['.$date.']<br/>';
			$index=1;	
			if(count($r['present'])>0)
			{
			$message.= '<div><br><h3 style="margin-bottom:5px;" >Present</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>S.no</th><th>Employee</th><th>Time In</th><th>Time Out</th></tr>';	
				foreach($r['present'] as $emp)
				{
					$message.= '<tr><td align="left" style="padding-left:3%">'.($index++).'</td><td align="left" style="padding-left:2%">'.$emp->name.'</td><td align="center">'.date("H:i",strtotime($emp->TimeIn)).'</td><td align="center">'.date("H:i",strtotime($emp->TimeOut)).'</td></tr>';
				}
			$message.= '</table></div>';
			}
			
			$index=1;
			if(count($r['pending'])>0)
			{
			$message.= '<div><h3 style="margin-bottom:5px;" >Time Out Not Marked</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>S.No</th><th>Employee</th><th>Time In</th><th>Time Out</th></tr>';
				foreach($r['pending'] as $emp){
					$message.= '<tr><td align="left" style="padding-left:3%">'.($index++).'</td><td align="left" style="padding-left:2%">'. $emp->name . '</td><td align="center">'. date("H:i",strtotime($emp->TimeIn)) .'</td><td align="center">--</td></tr>';
				}
				$message.='</table></div>';
			}
			$index=1;
			if(count($r['abs'])>0){
			$message.= '<div><br><h3 style="margin-bottom:5px;" >Absentees</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>S.No</th><th>Employee</th><th>Time In</th><th>Time Out</th></tr>';	
				foreach($r['abs'] as $emp){
					$message.= '<tr><td align="left" style="padding-left:3%">'.($index++).'</td><td align="left" style="padding-left:2%">'.$emp->name.'</td><td align="center">--</td><td align="center">--</td></tr>';
				}
			$message.= '</table></div>';
			}
			$index=1;
			if(count($r['late'])>0)
			{
			$message.= '<div><br><h3 style="margin-bottom:5px;" >Late Comers</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>S.No</th><th>Employee</th><th>Time In</th><th>Late By</th></tr>';	
				foreach($r['late'] as $emp){
					$message.= '<tr><td align="left" style="padding-left:3%">'.($index++).'</td><td align="left" style="padding-left:2%">'.$emp->name.'</td><td align="center">'.date("H:i",strtotime($emp->TimeIn)).'</td><td align="center">'.date("H:i",strtotime($emp->latecome)).'</td></tr>';
				}
			   $message.= '</table></div>';
			}
			$index=1;
			if(count($r['early'])>0)
			{
			$message.= '<div><br><h3 style="margin-bottom:5px;" >Early Leavers</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>S.No</th><th>Employee</th><th>Time Out</th><th>Early By</th></tr>';	
			
				foreach($r['early'] as $emp)
				{
					if($emp['sts']==4)
					{
					$BreaksHalfday=getShiftBreaksHalfday($emp['shiftid']);
					$earlyhalfday=earlyhalfday($BreaksHalfday,$emp['timeout']);
					if($BreaksHalfday>$emp['timeout'])
					{
						$message.= '<tr><td align="left"  style="padding-left:4%">'.($index++).'</td><td align="left"  style="padding-left:2%">'.$emp['Name'].'</td><td align="center">'.$emp['timeout'].'</td><td align="center">'.$emp['earlyleave'].'</td></tr>';
					}
					}
					else
					{
						$message.= '<tr><td align="left"  style="padding-left:4%">'.($index++).'</td><td align="left"  style="padding-left:2%">'.$emp['Name'].'</td><td align="center">'.$emp['timeout'].'</td><td align="center">'.$emp['earlyleave'].'</td></tr>';
					}
					
				}
			$message.= '</table></div>';
			}
			$index=1;
			if(count($r['timeoff'])>0)
			{
			$message.= '<div><br><h3 style="margin-bottom:5px;" >Time Off List (Approved)</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>S.No</th><th>Employee</th><th>Timings</th><th>Total Time </th width="40%"><th>Reason</th></tr>';
				
				foreach($r['timeoff'] as $emp){
					$message.= '<tr><td align="left" style="padding-left:3%">'.($index++).'</td><td align="left" style="padding-left:2%">'.$emp->name.'</td><td align="center">'.date("H:i",strtotime($emp->TimeFrom)).' - '.date("H:i",strtotime($emp->TimeTo)).'</td><td align="center">'.date("H:i",strtotime($emp->Total)).'</td><td  width="40%">'.$emp->Reason.'</td></tr>';
				}
			$message.= '</table></div>';
			}
			$index=1;
			if(count($r['geoloc'])>0){
			$message.= '<div><br><h3 style="margin-bottom:5px;" >Attendance Marked outside the Fenced Area</h3>
						<table style="border-collapse: collapse;" border width="50%"><tr style="color:#fa6804" ><th>S.No</th><th>Employee</th><th>Time In</th><th>Time Out</th></tr>';	
				
				foreach($r['geoloc'] as $emp){
					$message.= '<tr><td align="left" style="padding-left:2%">'.($index++).'</td><td align="left" style="padding-left:2%">'.$emp['Name'].'</td><td align="center">'.$emp['ti'].$emp['positionlin'].'</td><td align="center">'.$emp['to'].$emp['positionout'].'</td></tr>';
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
					
					</div>';
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
	 
	 public function test()
	 {
      $query = $this->db->query("select TIMEDIFF('2019-02-15 12:00:00' , '2019-02-14 10:00:00') as time");
	  if($row = $query->row())
		  return $row->time;
	 }
	 
		public function ApproveTimeoff($request)
    {
    	
		$result = array();
		$count=0; $errorMsg=""; $successMsg=""; $status=false;
		$data = array();
		$mid   = $request[0];	//USER ID CONTAINS IN ARRAY FIRST VALUE;
		$orgid = $request[1];	//ORG ID CONTAINS IN ARRAY SECOND VALUE;
		$timeoffid = $request[2];
		$apr = $request[3];
		$cmt = $request[4];
		$mdate = date("Y-m-d H:i:s");
		$res=0;
		// echo $mid ;
		// echo $orgid ;
		// echo $timeoffid ;
		// echo $apr ;
		// echo $cmt ;

		$sql = "UPDATE TimeoffApproval SET ApproverSts =$apr, ApprovalDate ='$mdate', ApproverComment='$cmt' WHERE TimeofId =$timeoffid AND ApproverId=$mid  and OrganizationId=$orgid and  ApproverSts = 3 and ApprovalDate='0000-00-00 00:00:00'";
		// echo $sql;
		// Trace($sql);
		// Trace($orgid);
		// Trace($result);
		// Trace($uidi);
		try{
			$query = $this->db->query($sql,array());
			// $query->execute(array());
			$count =  $this->db->affected_rows();
			// echo $count;		
			if ($count >= 1) {
				$empid=getName('Timeoff','EmployeeId','Id',$timeoffid);
                $empname=getName('EmployeeMaster','FirstName','Id',$empid);
				$msg="Time off has been approved of $empname";
				$sql = "INSERT INTO ActivityHistoryMaster ( LastModifiedById, Module, ActionPerformed,  OrganizationId) VALUES (?, ?, ?, ?)";
				$query = $this->db->query($sql,array($mid, "Timeoff Approval", $msg, $orgid));
				// $query->execute(array($mid, "Leave Approval", $msg, $orgid));
			   $status =true;
			   $successMsg="Time off has been approved";
			   $empname="";
				$userid="";
				$empmail="";
				$timeoffreason="";
				$timeoffdate="";
				$fromtime="";
				$totime="";
				
				$sql3="select * from Timeoff where Id=$timeoffid";
				//Utils::Trace($sql3." ".$leaveid);
				$query3=$this->db->query($sql3);
				 // return $query3->result();
				// echo $query3;
				// $query3->execute();
				// var_dump($this->db->last_query());
				// echo "423sdasd";
				if($row3=$query3->row()){
					// echo "sdasd";
					$userid=$row3->EmployeeId;
					$timeoffreason=$row3->Reason;
					$timeoffdate=$row3->TimeofDate;
					$fromtime=$row3->TimeFrom;
					$totime=$row3->TimeTo;
					$appliedon=$row3->CreatedDate;
					// echo $userid;
					// echo $timeoffreason;
					// echo $timeoffdate;
					// echo $fromtime;
					// echo $totime;
					// echo $appliedon;
					//Utils::Trace("name and email".$emp_mail." ".$emp_name);
				}
				// echo "4234";
					$empname=ucwords(getEmpName($userid));
					$empemail=decode5t(getName('EmployeeMaster','CompanyEmail','Id',$userid));
					///////// fetching timeoff approval history ///////////
					$approverhistory="";
					$sql = "SELECT * FROM TimeoffApproval WHERE OrganizationId = ? AND TimeofId = ? AND ApproverSts<>3 ";
					$query = $this->db->query($sql,array($orgid, $timeoffid));
					// $query->execute(array($orgid, $timeoffid));
					// echo $query;
					$count =  $this->db->affected_rows();
					// echo $count;
					
			   if($apr==2){
				$sql1 = "select * from TimeoffApproval WHERE TimeofId = ? and ApproverSts=3 and OrganizationId=?";
				$query1 = $this->db->query($sql1,array( $timeoffid, $orgid));

				$count2 = $this->db->affected_rows();

				// $query1->execute(array( $timeoffid, $orgid));
				if($r=$query1->result())
				{				

$res= 1;
					// $nxtapproverid=$r->ApproverId;
					// $approvelink=URL."login/viewapprovetimeoffapproval/$nxtapproverid/$orgid/$timeoffid/2";
					// $rejectlink=URL."login/viewapprovetimeoffapproval/$nxtapproverid/$orgid/$timeoffid/1";
					// $seniorname=Utils::getName($nxtapproverid,'EmployeeMaster','FirstName',$this->db);
					$adminname=getAdminName($orgid);
					// $senioremail=Utils::decode5t(Utils::getName($nxtapproverid,'EmployeeMaster','CompanyEmail',$this->db));
					$adminemail=decode5t(getName(getAdminEmail($orgid))); //need to check this line
					$title="Timeoff approval";
					$msg="<table>	
										<tr><td>Dear $adminname,</td></tr><br>
										<tr><td>$empname has requested for time off</td></tr>
										<tr><td>Applied on: $appliedon</td></tr>
										<tr><td><b>Details are given below:</b></td></tr>
										
										<tr><td>Reason for timeoff: $timeoffreason</td></tr>
										<tr><td>Timeoff Date: $timeoffdate</td></tr>
										<tr><td>Duration: from $fromtime to $totime</td></tr>
										
										</table><br>
										$approverhistory<br>
										<table>
										<tr><td><br/><br/>
												<a href='$approvelink'   style='text-decoration:none;padding: 10px 15px; background: #ffffff; color: green;
												-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; border: solid 1px green; text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.4); -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2); -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2); box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2);'>Approve</a>
												&nbsp;&nbsp;
												&nbsp;&nbsp;
												<a href='$rejectlink'  style='text-decoration:none;padding: 10px 15px; background: #ffffff; color: brown;
												-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; border: solid 1px brown; text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.4); -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2); -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2); box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2);'>Reject</a>
												<br/><br/>
												</td>															
												</tr>	
						</table>";
					Trace($adminemail." ".$msg);
					sendEmail_new($adminemail,$empname,$title,$msg);
				}
				if($count2==0){
					
					$sql2 = "UPDATE Timeoff SET ApprovalSts =?, ModifiedDate=?,ApproverId=?,ApproverComment=? WHERE Id =? ";
					$query2 = $this->db->query($sql2,array(2,$mdate,$mid, $cmt,$timeoffid));
					// $query2->execute(array(2,$mdate,$mid, $request[4],$timeoffid));
					if ($count >= 1) {
						$res= 1;
						$successMsg = "Timeoff has been approved";
						// var_dump($this->db->last_query());
						
						/*generate mail and alert for time off approved*/
						// Alerts::generateActionAlerts(53,$timeoffid,$orgid,$this->db);
						
						   $empname="";
							$userid="";
							$empmail="";
							$timeoffreason="";
							$timeoffdate="";
							$fromtime="";
							$totime="";
							
							$sql3="select * from Timeoff where Id=$timeoffid";
							//Utils::Trace($sql3." ".$leaveid);
							$query3=$this->db->query($sql3);
							// $query3->execute();
							if($row3=$query3->row()){
								$userid=$row3->EmployeeId;
								$timeoffreason=$row3->Reason;
								$timeoffdate=$row3->TimeofDate;
								$fromtime=$row3->TimeFrom;
								$totime=$row3->TimeTo;
								//Utils::Trace("name and email".$emp_mail." ".$emp_name);
							}
							
						$empname=getName('EmployeeMaster','FirstName','Id',$userid);
						$approverhistory="";
					$sql = "SELECT * FROM TimeoffApproval WHERE OrganizationId = ? AND TimeofId = ? AND ApproverSts<>3 ";
					$query = $this->db->query($sql,array($orgid, $timeoffid));
					// $query->execute(array($orgid, $timeoffid));
					$count = $this->db->affected_rows();
					// var_dump($this->db->last_query());
					
					
					if($count>=1){
						$approverhistory.="</table>";
					}
						$title="Application for TimeOff is accepted";
						
						
						
						$msg="Dear $empname <br> Your application for Time off is accepted.";
						$msg.="<table>
										<tr><td>Reason for timeoff: $timeoffreason</td></tr>
										<tr><td>Timeoff Date: $timeoffdate</td></tr>
										<tr><td>Duration: from $fromtime to $totime</td></tr>
										</table><br>
										$approverhistory<br>
										<table>";
						$sts=sendEmail_new($empemail,$empname,$title,$msg);
						if($sts){
							Trace("Mail sent successfully for time off . Tittle =$title, Message=$msg");
						}else{
							Trace("Mail sent failed for time off .Tittle =$title, Message=$msg");
						}
					}
			   }
				
			   }else{
				   $status=true;
				   $res= 1;
					// $successMsg = "Time off application is rejected successfully";
					$sql1 = "UPDATE Timeoff SET ApprovalSts =?, ApproverId=?,ApproverComment=?, ModifiedDate=? WHERE Id =? ";
					$query = $this->db->query($sql1,array(1,$mid,$cmt,$mdate,$timeoffid));
					// $query->execute(array(1,$mid,$request[4],$mdate,$timeoffid));
					// var_dump($this->db->last_query());
					/*generate mail and alert for time off request rejected*/
						// Alerts::generateActionAlerts(60,$timeoffid,$orgid,$this->db);
					  $empname="";
							$userid="";
							$empmail="";
							$timeoffreason="";
							$timeoffdate="";
							$fromtime="";
							$totime="";
							
							$sql3="select * from Timeoff where Id=$timeoffid";
							//Utils::Trace($sql3." ".$leaveid);
							$query3=$this->db->query($sql3);
							// $query3->execute();
							if($row3=$query3->row()){
								$userid=$row3->EmployeeId;
								$timeoffreason=$row3->Reason;
								$timeoffdate=$row3->TimeofDate;
								$fromtime=$row3->TimeFrom;
								$totime=$row3->TimeTo;
								//Utils::Trace("name and email".$emp_mail." ".$emp_name);
							}
							
					$empname=getName('EmployeeMaster','FirstName','Id',$userid);
					$approverhistory="";
					$sql = "SELECT * FROM TimeoffApproval WHERE OrganizationId = ? AND TimeofId = ? AND ApproverSts<>3 ";
					$query = $this->db->query($sql,array($orgid, $timeoffid));
					// $query->execute(array($orgid, $timeoffid));
					$count =  $this->db->affected_rows();
					// echo $count;
					
					
					$title="Application for Timeoff is Rejected";
						
						$msg="Dear $empname,<br><br>
								Your Application for TimeOff is Rejected.";
						$msg.="<table>
										
										<tr><td>Reason for timeoff: $timeoffreason</td></tr>
										<tr><td>Timeoff Date: $timeoffdate</td></tr>
										<tr><td>Duration: from $fromtime to $totime</td></tr>
										</table><br>
										$approverhistory<br>
										<table>";
				
					
							Trace($empemail." ".$msg);
								sendEmail_new($empemail,$empname,$title,$msg);
			   }
			  
			  
			} else{
						$sql1 = "select * from TimeoffApproval WHERE TimeofId=?";
						$query1 = $this->db->query($sql1,array( $timeoffid));
						// $query1->execute(array( $timeoffid));
						$sts=0;
						if($r=$query1->row()){
							$sts=$r->ApproverSts;
						}
						if($sts==1){
							$sts="rejected";
						}elseif($sts==2){
							$sts="approved";
						}else{
							$sts="answered";
						}
							$status=false;
							$errorMsg="Request already been ".$sts;
				}
		}catch(Exception $e) {
				$errorMsg = 'Message: ' .$e->getMessage();
				Trace($errorMsg);
			}
		
		// $result["data"] =$data;
		// $result['status']=$status;
		// $result['successMsg']=$successMsg;
		//$result['errorMsg']=$errorMsg;
		
        // default return
        return $res;
    }	



} ?>
