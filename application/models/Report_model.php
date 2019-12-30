

<?php
class Report_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
		include(APPPATH."PhpMailer/class.phpmailer.php");
		
    }
     
     public function getEmployeesWiseReport()
	 {
					 $orgid=$_SESSION['orgid'];
					 $date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
					$shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:'';
					$deprtid=isset($_REQUEST['deprt'])?$_REQUEST['deprt']:'';
					$emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:'';
					$desgid=isset($_REQUEST['desg'])?$_REQUEST['desg']:'';
				  $q = "";
				  $startdate='';
					if($date != '')
						{
							$arr=explode('-', trim($date));
							$enddate= date('Y-m-d',strtotime($arr[1]));
							$startdate= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3))); 
							//echo strlen(trim($arr[0]));
						   $q ="AND `AttendanceDate` BETWEEN  '$startdate' AND '$enddate' ";
						}
						else
						{
							 $enddate=date("Y-m-d");
							 $d = date('d')-7;
							 $startdate=date('Y-m-d',(strtotime ( "-7 day",strtotime(date('Y-m-d'))) ));
							 $q=" AND  `AttendanceDate` BETWEEN  '$startdate' AND '$enddate' ";
						}
		        $q1 = '';
				if($deprtid!=0)
				{
					 $q1.=" AND  `Department` = '$deprtid' ";
			    } 
		    	if($shiftid!=0)
				{
			     $q1.= " AND `Shift`='$shiftid' ";
			    }
                if($desgid!=0)
				{
			      $q1.=" AND  `Designation` = '$desgid'  ";
			    } 

				if($emplid!=0)
				{
					$q1.=" AND `id`='$emplid' ";
				
				}
				
				$query = $this->db->query("SELECT Id,CONCAT(Firstname,' ',Lastname) as name,Department,Designation,Shift from EmployeeMaster where   OrganizationId=? $q1 AND DOL = '0000:00:00' order by Firstname  ",array($orgid));
						
				$d=array();
				$res=array();
				
				 foreach ($query->result() as $row)
				{
					   $Empid = $row->Id;
					  $query1 = $this->db->query("SELECT  A.ShiftId, A.AttendanceDate as atdate,C.shifttype as ctype,A.TimeIn as timein,A.TimeOut as timeout,C.TimeIn as ctimein,C.TimeOut as ctimeout,C.Name as cname, CASE WHEN(A.TimeIn > C.TimeIn) THEN (TIMEDIFF(A.TimeIn,C.TimeIn)) ELSE ('-') END as late, CASE WHEN(A.TimeOut < C.TimeOut) THEN (TIMEDIFF(C.TimeOut,A.TimeOut)) ELSE ('-') END as early FROM AttendanceMaster A,ShiftMaster C WHERE  C.Id = A.ShiftId $q  AND A.EmployeeId = $Empid AND A.OrganizationId = $orgid AND A.TimeIn != '0000:00:00' AND A.TimeOut != '0000:00:00'");
                      				  
					   foreach($query1->result() as $row1)
					   {
						  $sp = strtotime($row1->atdate);
						$data=array();
						$data['Name'] = $row->name." | ".getDepartment($row->Department)." | ".getDesignation($row->Designation)." | ".$row1->ctimein." To ".$row1->ctimeout;	
						$data['Date']= date_format(date_create($row1->atdate),"d-m-Y");
						$data['cname']= $row1->cname;
						$data['Shift_start']= substr($row1->ctimein,0,5);
						$data['Time_in']= substr($row1->timein,0,5);
						$data['Late_by']= substr($row1->late,0,5);
						$data['Shift_end']= substr($row1->ctimeout,0,5);
						$data['Time_out']= substr($row1->timeout,0,5);
						if(strtotime($row1->timeout)<strtotime($row1->ctimeout))
						{
						  $data['Early_by'] = substr($row1->early,0,5);	
						}
						else
						{
						if(strtotime($row1->timeout) > strtotime($row1->ctimeout) && strtotime($row1->ctimein) > strtotime($row1->ctimeout) && strtotime($row1->timein) <= strtotime($row1->timeout) )
							{
								 $time = "24:00:00";
								 $secs = strtotime($row1->timeout)-strtotime($row1->ctimeout);
								 $data['Early_by'] = date("H:i",strtotime($time)-$secs);
								 
							}
							else
							{
								$data['Early_by'] = "-";
							}
							
						}
						if(strtotime($row1->timein) <= strtotime($row1->timeout) && strtotime($row1->ctimein) <= strtotime($row1->ctimeout) )
						$data['Over_under']= $this->getoveundertime($Empid,$row1->atdate);
					    else
						{
						     	$time = "24:00:00";
								$secs = strtotime($row1->ctimein)-strtotime($row1->ctimeout);
								$data['shifthpurs'] = date("H:i",strtotime($time)-$secs);
								$a = new DateTime($data['shifthpurs']);
								$secs = strtotime($row1->timein)-strtotime($row1->timeout);
								$data['var'] = date("H:i",strtotime($time)-$secs);
								$b = new DateTime($data['var']);
								if($b >= $a)
								{
								 $interval = $a->diff($b);
								 $data['Over_under']= $interval->format("%H:%I");	
								}
								else
								{
								  $interval = $b->diff($a);
								  $a = new DateTime($interval->format("%H:%I"));
								  $b = new DateTime(getShiftBreak($row1->ShiftId));
								  $interval1 = $b->diff($a);
								  $data['Over_under']= "-".$interval1->format("%H:%I");			
								}
								
                         }
						$data['Time_of']= $this->TimeOf($Empid,$row1->atdate);
						if(strtotime($row1->timein) <= strtotime($row1->timeout))
						$data['Totalworkin_hour']= $this->getworkinghour($Empid,$row1->atdate);
					    else
						{
								$time = "24:00:00";
								$secs = strtotime($row1->timein)-strtotime($row1->timeout);
								$data['var'] = date("H:i",strtotime($time)-$secs);
								$a = new DateTime($data['var']);
								$b = new DateTime(getShiftBreak($row1->ShiftId));
								
								$interval = $b->diff($a);
								$data['Totalworkin_hour']= $interval->format("%H:%I");	
						}
						$res[]=$data;
					   }			   
				} 
				$d['data']= $res;
				$this->db->close();	
				echo json_encode($d);
				return false;
		}
		function getworkinghour($empid,$date)
		{
			
			$org_id = $_SESSION['orgid'];
			$currentdate = date("y-m-d");
			$query = $this->db->query("SELECT  SEC_TO_TIME(sum(time_to_sec(TIMEDIFF(A.TimeOut,A.TimeIn))- CASE WHEN(A.TimeOut>S.TimeOutBreak && A.TimeIn < S.TimeOutBreak ) THEN time_to_sec(TIMEDIFF(S.TimeOutBreak,S.TimeInBreak)) ELSE 0 END)) as time FROM AttendanceMaster A,ShiftMaster S WHERE A.EmployeeId = ($empid) AND A.OrganizationId= $org_id AND A.AttendanceDate = '$date'  AND A.TimeOut > A.TimeIn AND A.TimeIn != 'null' AND A.TimeOut != 'null' AND S.Id = A.ShiftId ");
		    if( $row = $query->result_array())
			 {
				if($row[0]["time"] != null)
				{
					$length = strlen($row[0]["time"])-3;
					return ( substr($row[0]["time"],0,$length) );
				}
				else 
					return "00:00";
			 }
		  //return 0;
		}
		function getoveundertime($empid,$date)
		{
			
			$org_id = $_SESSION['orgid'];
			//$currentdate = date("y-m-d");
			$query = $this->db->query("SELECT SEC_TO_TIME(sum(time_to_sec( TIMEDIFF(A.TimeOut,A.TimeIn))-CASE WHEN(A.TimeOut>S.TimeOutBreak) THEN time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)) ELSE time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)-time_to_sec(TIMEDIFF(S.TimeOutBreak,S.TimeInBreak))) END)) as time FROM AttendanceMaster A,ShiftMaster S WHERE A.EmployeeId = ($empid) AND A.OrganizationId= $org_id AND A.AttendanceDate = '$date'   AND A.TimeOut > A.TimeIn AND A.TimeIn != 'null' AND A.TimeOut != 'null' AND S.Id = A.ShiftId ");
		    if( $row = $query->result_array())
			 {
				if($row[0]["time"] != null)
				{
					$length = strlen($row[0]["time"])-3;
					return ( substr($row[0]["time"],0,$length) );
				}
				else 
					return "00:00";
			   
			 }
		}
		
		function TimeOf($empid,$date)
		{
			/*if($date != '')
			{
				$arr=explode('-', trim($date));
				$end= date('Y-m-d',strtotime($arr[1]));
				$strt= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3))); 
			    //echo strlen(trim($arr[0]));
			   $q =" AND `TimeofDate` BETWEEN  '$strt' AND '$end' ";
			}
			else
			{
				 $enddate=date("Y-m-d");
		         $startdate=date('Y-m-d',(strtotime ( '-30 day',strtotime(date('Y-m-d'))) ));
			     $q=" AND  `TimeofDate` BETWEEN  '$startdate' AND '$enddate' ";
			}*/
			$org_id = $_SESSION['orgid'];
			//$currentdate = date("y-m-d");
			$query = $this->db->query("SELECT ( TIMEDIFF(T.TimeTo,T.TimeFrom) )as time FROM Timeoff T WHERE T.EmployeeId = ($empid) AND T.OrganizationId= $org_id AND TimeofDate= '$date'  AND T.TimeFrom < T.TimeTo AND T.TimeFrom != '00:00:00' AND T.TimeTo != '00:00:00'");
		     if( $row = $query->result_array())
			 {
				  if($row[0]["time"] == null)
				  {
					return "-";  
				  } 
			     else
				 {
					 return ( substr($row[0]["time"],0,5) ); 
				 } 
			 }
			 else
			 {
				return "-"; 
			 }
		}
		
		
	 }	 
?>