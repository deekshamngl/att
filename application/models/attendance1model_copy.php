

<?php
  class Attendance_model extends CI_Model {
  	function __construct()
      {
          parent::__construct();
      }
	public function getOutLocationEmp()
	  {
		 $orgid=$_SESSION['orgid'];
		 $deptId = isset($_REQUEST['dept'])?$_REQUEST['dept']:0;
		 $date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
		 $shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:0;
		 $emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:0;
		 $desgid=isset($_REQUEST['desg'])?$_REQUEST['desg']:0;
		 $zname=getTimeZone($orgid);
		date_default_timezone_set ($zname);

			 $today=date('Y-m-d');
			   $q1 = '';
		    	if($shiftid!= 0)
				{
			     $q1.= " AND A.ShiftId='$shiftid' ";
			    }
                if($desgid != 0)
				{
			      $q1.=" AND  A.Desg_id = '$desgid'  ";
			    } 
				if($deptId != 0){
					$q1.=" AND A.Dept_id='$deptId' ";
				}
				if($emplid !=0 ) 
				{
					$q1.=" AND A.EmployeeId = '$emplid'";
				}
			    if($date == '')
				{
					$datestatus = isset($_REQUEST['datestatus'])?$_REQUEST['datestatus']:0;
					$range = "";
					if($datestatus == 7)
					{   
				        $enddate=date("Y-m-d");
				        $startdate=date('Y-m-d', strtotime('-7 day', strtotime($enddate)));
						$begin = new DateTime($startdate);
						$interval = new DateInterval('P1D'); // 1 Day
						$realEnd = new DateTime($enddate);
						 $realEnd->add($interval);
						$dateRange = new DatePeriod($begin,$interval,$realEnd);
						foreach ($dateRange as $date) 
						 {
							$dt= $date->format('Y-m-d');
							if($range == "")
							   $range = "'".$date->format('Y-m-d')."'";
							else
							   $range .= ",'".$date->format('Y-m-d')."'";
						 }
				   }
				   else
				   {
					   $enddate=date("Y-m-d");
					   $range = "'".date('Y-m-d')."'"; 
				   }
				$query = $this->db->query("SELECT A.Id, A.EmployeeId,C.TimeIn as ctin ,C.TimeOut as ctout, A.AttendanceDate as date , A.AttendanceStatus, A.TimeIn, A.TimeOut, A.ShiftId, A.Overtime,A.EntryImage, A.ExitImage,A.latit_in,A.longi_in,A.longi_out,A.latit_out,A.checkInLoc, A.CheckOutLoc,A.areaId FROM AttendanceMaster A, ShiftMaster C  WHERE A.OrganizationId=?  And A.AttendanceStatus IN (1,4,8) And C.Id = A.ShiftId and C.OrganizationId = ? $q1 And A.AttendanceDate IN ( ".$range." )",array($orgid,$orgid));
				}
			else
			{
				$arr=explode('-',trim($date));
				$end= date('Y-m-d',strtotime($arr[1]));
				$strt= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3))); 
				$begin = new DateTime($strt);
				$interval = new DateInterval('P1D'); // 1 Day
	            $realEnd = new DateTime($end);           
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
			 if($rangedate==""){
			   $rangedate = 1;
			   } 
				$query = $this->db->query("SELECT A.Id, A.EmployeeId,C.TimeIn as ctin ,C.TimeOut as ctout, A.AttendanceDate as date , A.AttendanceStatus, A.TimeIn, A.TimeOut, A.ShiftId, A.Overtime,A.EntryImage, A.ExitImage,A.latit_in,A.longi_in,A.longi_out,A.latit_out,A.checkInLoc, A.CheckOutLoc,A.areaId FROM AttendanceMaster A, ShiftMaster C  WHERE A.OrganizationId=?  And A.AttendanceStatus IN (1,4,8) And C.Id = A.ShiftId and C.OrganizationId = ? $q1 And A.AttendanceDate IN ( ".$rangedate." )",array($orgid,$orgid));
				
			}
			$d=array();                      
			$res=array();
			 foreach ($query->result() as $row)
			  {	
					$data=array();
					$name = ucwords(getEmpName($row->EmployeeId));
					
					 if($row->areaId != 0)
					{
						$lat_lang = getName('Geo_Settings','Lat_Long','Id',$row->areaId);
						$radius = getName('Geo_Settings','Radius','Id',$row->areaId);
						$arr1 = explode(",",$lat_lang);
						//echo '----------'.count($arr1);
					if(count($arr1)>1){
						$a=floatval($arr1[0]);
						$b=floatval($arr1[1]);
						$d1 = $this->distance($a,$b, $row->latit_in, $row->longi_in, "K");
						$d2 = $this->distance($a,$b, $row->latit_out, $row->longi_out, "K");
					}
					} 
					//$timeinnotzero	=	$row->latit_in !='0.0';
					//$timeoutnotzero	=	$row->longi_out != '0.0';
					//$area=($row->areaId != 0 && ($d1>$radius));
					//$area1=($row->areaId != 0 && ($d2>$radius));
					//if($name != "" && $area)
					//{
					$timeinnotzero	=	$row->latit_in !='0.0';
					$timeoutnotzero	=	$row->longi_out != '0.0';
					$area=($row->areaId != 0 && ($d1>$radius) && $timeinnotzero );
					$area1=($row->areaId != 0 && ($d2>$radius) && $timeoutnotzero );
					//if($name != "" && ($d1 > $radius || $d2 > $radius) && $timeoutnotzero)
					if($name != "" && ($area || $area1))
					{
					$data['name'] = $name;	
					$data['date']=date("d-M-Y",strtotime($row->date));
					$data['ti']=substr($row->TimeIn,0,5);
					$data['to']=substr($row->TimeOut,0,5);
					$data['shift']='<span title="Shift Timing: '.getShiftTimes($row->ShiftId).', Break Hours: '.getShiftBreaks($row->ShiftId).'">'.getShift($row->ShiftId).'</span>';
					//$data['shift']=getShiftTimes($row->ShiftId);
					$data['ot']=$row->Overtime;
					$data['entryimg']='<img src="'.$row->EntryImage.'"  style="width:60px!important; "/>';
					$data['exitimg']='<img src="'.$row->ExitImage.'"  style="width:60px!important; "/>';
					$data['positionlin']="";
					$data['positionout']="";
					if($row->areaId != 0)
					{
						$lat_lang = getName('Geo_Settings','Lat_Long','Id',$row->areaId);
						$radius = getName('Geo_Settings','Radius','Id',$row->areaId);
						$arr1 = explode(",",$lat_lang);
						//echo '----------'.count($arr1);
					if(count($arr1)>1){
						$a=floatval($arr1[0]);
						$b=floatval($arr1[1]);
						$d1 = $this->distance($a,$b, $row->latit_in, $row->longi_in, "K");
						$d2 = $this->distance($a,$b, $row->latit_out, $row->longi_out, "K");
						if($d1 <= $radius)
						{
							$data['positionlin'] = '<div title="Attendance marked from the assigned area" class="text-center"  data-background-color="green">Within the Location</div>';
						}
						else
						{
							$data['positionlin'] ='<div title="Attendance marked from the out side of assigned area" class="text-center" data-background-color="red">Outside the Location</div>';
						}
						
						if($d2 <= $radius)
						{
							$data['positionout'] = '<div title="Attendance marked from the assigned area" class="text-center"  data-background-color="green">Within the Location</div>';
						}
						else
						{
							$data['positionout'] ='<div title="Attendance marked from the out side of assigned area" class="text-center" data-background-color="red">Outside the Location</div>';
						}
					}
					
				}
					if($row->latit_in=='0.0')
						$data['chiloc']=$row->checkInLoc!=''?'<span title="'.$row->checkInLoc.'">'.$row->checkInLoc.'</span>':'-';
					else
						$data['chiloc']='<a style="font-size:11px;" href="http://maps.google.com/?q='.$row->latit_in.','.$row->longi_in.'" target="_blank" title="'.$row->checkInLoc.'">'.$row->checkInLoc .$data['positionlin'].'</a>';
					if($row->longi_out=='0.0')
						$data['choloc']=$row->CheckOutLoc!=''?'<span title="'.$row->CheckOutLoc.'">'.$row->CheckOutLoc.'</span>':'-';
					else
						$data['choloc']='<a style="font-size:11px;" href="http://maps.google.com/?q='.$row->latit_out.','.$row->longi_out.'" target="_blank" title="'.$row->CheckOutLoc.'">'.$row->CheckOutLoc .$data['positionout'].'</a>';

					$data['wh']='-';

					$attn=$row->AttendanceStatus==1?'<span style="background-color:green;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Present">P</span>':'<span style=" background-color:red;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Absent">A</span>';
					$goings='';$overtime='';$coming='';
					if($row->AttendanceStatus==1){
					$tm = comings($row->ShiftId,$row->TimeIn);
					$coming=strpos($tm,'-')!==0?'<span style="background-color:red;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Late Coming By '.substr($tm,0,5).' Hr">LC</span>':'<span style=" background-color:green;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Early Coming By '.substr(str_replace("-","",$tm),0,5).' Hr">EC</span>';
					
					if($row->TimeOut!='00:00:00')
					{
						$tm = goings($row->ShiftId,$row->TimeOut);
						$goings=strpos($tm,'-')!==0?'<span style=" background-color:green;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Late Leaving By '.substr($tm,0,5).' Hr">LL</span>':'<span style="background-color:red;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Early Leaving By '.substr(str_replace("-","",$tm),0,5).' Hr">EL</span>';
						
						//calculate work hours
					if(strtotime($row->ctin) < strtotime($row->ctout))
						{
						  if(strtotime($row->TimeIn) < strtotime($row->TimeOut))
						  {
							$a = new DateTime($row->TimeIn);
							$b = new DateTime($row->TimeOut);
							$interval1 = $a->diff($b);
							$a = new DateTime($interval1->format("%H:%I"));
							$data['wh']= $interval1->format("%H:%I");
						  }
						  else
						  {
							   $time = "24:00:00";
								$secs = strtotime($row->TimeIn)-strtotime($row->TimeOut);
								$data['wh'] = date("H:i",strtotime($time)-$secs); 
						  }
						}
						else
						{
							$a = new DateTime($row->TimeIn);
							$b = new DateTime($row->TimeOut);
							if( strtotime($row->TimeIn) <= strtotime($row->TimeOut))
							{
								$interval1 = $a->diff($b);
								$a = new DateTime($interval1->format("%H:%I"));
								$data['wh']=$interval1->format("%H:%I");	
							}
							else
							{
								$time = "24:00:00";
								$secs = strtotime($row->TimeIn)-strtotime($row->TimeOut);
								$data['wh'] = date("H:i",strtotime($time)-$secs);
							}
						}
				  }
				    
						if($row->Overtime!='00:00:00')
						{
							$overtime=strpos($row->Overtime,'-')!==0?'<span style="background-color:green;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Over Time By '.substr($row->Overtime,0,5).' Hr">OT</span>':'<span style=" background-color:red;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Under Time By '.substr(str_replace("-","",$row->Overtime),0,5).' Hr">UT</span>';
						}
					}
					$data['status']=$attn.' '.$coming.' '.$goings.' '.$overtime;
		            $data['timeoff'] = $this->calculatetimeoff($row->EmployeeId, $row->date);
					
							if($data['timeoff'] != "00:00" AND $data['wh'] != "-" )
								{
									 $a = new DateTime($data['timeoff']);
									 $b = new DateTime($data['wh']);
									 $interval = $a->diff($b);
									 $a = new DateTime($interval->format("%H:%I"));
									 $data['wh'] = $interval->format("%H:%I");
								}
					
					$data['action']='
					  &nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->date.'" target="_self"><i class="track_loc fa fa-map-marker"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>';
					$res[]=$data;
			    }
		    }  	
		    	 	
			$d['data']=$res;  
            $this->db->close();			//$query->result();
			echo json_encode($d); return false;
		}
		
  
   public function calculatetimeoff($empid,$date)
	 {
					$org_id = $_SESSION['orgid'];
					$query = $this->db->query("SELECT ( TIMEDIFF(T.TimeTo,T.TimeFrom) )as time FROM Timeoff T,AttendanceMaster A WHERE T.EmployeeId = ($empid) AND T.OrganizationId= '$org_id' AND TimeofDate= '$date'  AND T.TimeFrom < T.TimeTo AND T.TimeFrom != '00:00:00' AND T.TimeTo != '00:00:00' AND A.AttendanceDate='$date' AND A.EmployeeId='$empid' AND A.OrganizationId='$org_id' AND A.TimeIn <= T.TimeFrom AND A.TimeOut >= T.TimeTo AND  A.TimeIn != '00:00:00' AND A.TimeOut != '00:00:00' ");
							 if( $row = $query->result_array())
							 {
									  if($row[0]["time"] == null)
									  {
										return "00:00";  
									  } 
									 else
									 {
										 return (substr($row[0]["time"],0,5) ); 
									 } 
							 }
							 else
							 {
								return "00:00"; 
							 }
				}
		  
		 // public function caltimeoff($empid,$rangedate,$workdays)
			  // {
				
					// $org_id = $_SESSION['orgid'];
					// $query = $this->db->query("SELECT SEC_TO_TIME(sum(TIME_TO_SEC(TIMEDIFF(T.TimeTo,T.TimeFrom)))DIV $workdays) AS time FROM Timeoff T,AttendanceMaster A WHERE T.EmployeeId = $empid AND T.OrganizationId= '$org_id' AND TimeofDate IN(".$rangedate.")   AND T.TimeFrom != '00:00:00' AND T.TimeTo != '00:00:00' AND A.AttendanceDate IN(".$rangedate.") AND A.EmployeeId='$empid' AND A.OrganizationId='$org_id'   AND  A.TimeIn != '00:00:00' AND A.TimeOut != '00:00:00' AND TimeofDate IN(A.AttendanceDate)");
				 // if($row = $query->result_array())
				 // {
					// if($row[0]["time"] == null)
					  // {
						// return "00:00";  
					  // } 
					// else
					 // {
						// return (substr($row[0]["time"],0,5)); 
						// //return  (substr($row[0]["cumtimeoff"],0,5)); 
					 // } 
				 // }
					 // else
					 // {
						// return "00:00"; 
					 // }
				// }
		  // public function calcitimeoff($empid,$rangedate,$workdays)
			  // {
				
					// $org_id = $_SESSION['orgid'];
					// $query = $this->db->query("SELECT TIME_TO_SEC(SEC_TO_TIME(sum(TIME_TO_SEC(TIMEDIFF(T.TimeTo,T.TimeFrom)))
					// DIV $workdays)) AS cumtimeoff FROM Timeoff T,AttendanceMaster A WHERE T.EmployeeId = $empid AND T.OrganizationId= '$org_id' AND TimeofDate IN(".$rangedate.")   AND T.TimeFrom != '00:00:00' AND T.TimeTo != '00:00:00' AND A.AttendanceDate IN(".$rangedate.") AND A.EmployeeId='$empid' AND A.OrganizationId='$org_id'   AND  A.TimeIn != '00:00:00' AND A.TimeOut != '00:00:00' AND TimeofDate IN(A.AttendanceDate)");
				 // if($row = $query->result_array())
				 // {
					// return  ($row[0]["cumtimeoff"]); 
				 // }
					 // else
					 // {
						// return "00:00"; 
					 // }
				// }  
		  
		  
		  
	///////////////////AVERAGES WEEKLY REPORT BY VANSHIKA ///////////  
    public function getWeeklyAverageSummary($type)
        { 
				$result = array();
				$res = array();
				$count=0;
				$total=0;$total1=0;$total2=0;$total3=0;$total4=0;
				$totalcumlate=0;$totalcumearly=0;$totalavgsum=0;$totalcumunder=0;$totalcumtime=0;
				$orgid = isset($_SESSION['orgid'])?$_SESSION['orgid']:0;
				$zname=getTimeZone($orgid);
				date_default_timezone_set ($zname);
				$date = date("d-M-Y");
				 $time = date("H:i");
				 $stime = date("H:i");
				 $etime = date("H:i", strtotime('+59 minutes',strtotime($stime)));
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
					$workdays = $this->getWorkingDays($shiftid,$enddate);
					
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
					'<center><div style="width:65%;margin-bottom:5%;"><h3 style="color:green;padding:0px; margin:0px;">Weekly Attendance Summary</h3>
					['.$startdate.' to '.$enddate.']
					<div style="margin-top:5%;">
					<table style="border-collapse: collapse;" border width="100%">
					<tr style="color:#fa6804">
					<th>S.no</th>
					<th style="width:18%">Employees</th>
					<th style="width:16.5%;">Avg<br/> Shift Hours </th>
					<th style="width:16.5%;">Total<br/> Shift Hours </th>
					<th style="width:16.5%;">Avg<br/> Late Coming</th>
					<th style="width:16.5%;">Total<br/> Late Coming</th>
					<th style="width:16.5%;">Avg<br/> Early Leaving</th>
					<th style="width:16.5%;">Total<br/> Early Leaving</th>
					<th style="width:16.5%;">Avg<br/> Time Off</th>
					<th style="width:16.5%;">Total <br/> Time Off</th>
					<th style="width:16.5%;">Avg<br/> Undertime </th>
					<th style="width:16.5%;">Total<br/> Undertime </th>
					</tr>';	
					foreach($r['report'] as $emp)
					{
						$message.= '<tr>
		<td align="left"  style="padding-left:1%">'.($index++).'</td>				
		<td align="left" style="width:18%;padding-left:1%">'.$emp['name'].'</td>
		<td align="center" style="width:16.5%;padding:1% 1%">'.$emp['avglog'].'</td>
		<td align="center" style="width:16.5%;padding:1% 1%">'.$emp['totaldiff'].'</td>
		<td align="right" style="width:16.5%;padding-right:3%">'.$emp['latecoming'].'</td>
		<td align="right" style="width:16.5%;padding-right:3%">'.$emp['totlatecoming'].'</td>
		<td align="right" style="width:16.5%;padding-right:3%">'.$emp['earlyleaving'].'</td>
		<td align="right" style="width:16.5%;padding-right:3%">'.$emp['totearlyleaving'].'</td>
		<td align="right" style="width:16.5%;padding-right:3%">'.$emp['timeoff'].'</td>
		<td align="right" style="width:16.5%;padding-right:3%">'.$emp['tottimeoff'].'</td>
		<td align="right" style="width:16.5%;padding-right:3%">'.$emp['undertime'].'</td>
		<td align="right" style="width:16.5%;padding-right:3%">'.$emp['undertime'].'</td>
								
								</tr>';
									
					}
				$message.= '<tfoot>
				<tr style="font-weight:bold">
				<td align="right" style="padding-right:1%"></td>
				<td style="text-align:left;padding-left:1%">Team’s Total</td>
				<td align="right" style="padding-right:3%">'.$cumtotal4.'</td>
				<td align="right" style="padding-right:3%">'.$cumtotalavg.'</td>
				<td align="right" style="padding-right:3%">'.$cumtotal.'</td>
				<td align="right" style="padding-right:3%">'.$cumtotallate.'</td>
				<td align="right" style="padding-right:3%">'.$cumtotal1.'</td>
				<td align="right" style="padding-right:3%">'.$cumtotalearly.'</td>
				<td align="right" style="padding-right:3%">'.$cumtotal2.'</td>
				<td align="right" style="padding-right:3%">'.$cumtotalunder.'</td>
				<td align="right" style="padding-right:3%">'.$cumtotal3.'</td>
				<td align="right" style="padding-right:3%">'.$cumtotaltime.'</td>
				</tr>
				
				<tr style="color:#f19240;font-weight:bold">
				<td align="right" style="padding-right:1%"></td>
				<td style="text-align:left;padding-left:1%">Team’s Average</td>
				<td align="right" style="padding-right:3%">'.$timeFormat4.'</td>
				<td align="right" style="padding-right:3%">'.$totaltimeFormat4.'</td>
				<td align="right" style="padding-right:3%">'.$timeFormat.'</td>
				<td align="right" style="padding-right:3%">'.$totaltimeFormat.'</td>
				<td align="right" style="padding-right:3%">'.$timeFormat1.'</td>
				<td align="right" style="padding-right:3%">'.$totaltimeFormat1.'</td>
				<td align="right" style="padding-right:3%">'.$timeFormat2.'</td>
				<td align="right" style="padding-right:3%">'.$totaltimeFormat2.'</td>
				<td align="right" style="padding-right:3%">'.$totaltimeFormat3.'</td>
				<td align="right" style="padding-right:3%">'.$timeFormat3.'</td>
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
			<div style="display:none">
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
			</div></div>';
				}
				
				$message.='</center>';
				print_r($message);
				}
								
			}
			
		
	public function getMonthlyAverageSummary($type)
        { 
				$result = array();
				$res = array();
				$count=0;
				$total=0;$total1=0;$total2=0;$total3=0;$total4=0;
				$orgid = isset($_SESSION['orgid'])?$_SESSION['orgid']:0;
				$zname=getTimeZone($orgid);
				date_default_timezone_set ($zname);
					//$date = date("d-M-Y");
				$time = date("H:i");
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
					-CASE WHEN(A.TimeOut>S.TimeOutBreak)
					THEN time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)) 
					ELSE time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)-time_to_sec(TIMEDIFF(S.TimeOutBreak,S.TimeInBreak))) END) ) as undertime,
					TIME_TO_SEC(SEC_TO_TIME(sum(time_to_sec(TIMEDIFF(A.TimeOut,A.TimeIn))
					-CASE WHEN(A.TimeOut>S.TimeOutBreak) THEN time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)) 
					ELSE time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)-time_to_sec(
					TIMEDIFF(S.TimeOutBreak,S.TimeInBreak))) END) )) as cumundertime FROM AttendanceMaster A, ShiftMaster S WHERE (A.TimeIn != '00:00:00') and (S.TimeIn != '00:00:00')  AND A.OrganizationId = $orgid  AND 
					(A.TimeOut != '00:00:00') and A.EmployeeId = $empid  AND S.Id =$shiftid AND A.AttendanceDate IN(".$rangedate.") and A.TimeIn>S.TimeIn and S.TimeOut>A.TimeOut  ");
					if($row2 = $q3->row())
					{
						$data['latecoming']=substr($row2->latecoming,0,-3);
						//print_r($data['latecoming']);
						$total=$total+$row2->cumlatecoming;
						$data['earlyleaving']=substr($row2->earlyleaving,0,-3);
						//print_r($data['earlyleaving']);
						$total1=$total1+$row2->cumearlyleave;
						$data['avglog']=substr($row2->difference,0,-3);
						$total4=$total4+$row2->avgsum;
						$data['undertime']=substr($row2->undertime,0,-3);
						$total2=$total2+$row2->cumundertime;
						if($row2->undertime==''||$row2->difference==''||$row2->latecoming==''||$row2->earlyleaving=='')
						{
							$data['undertime']	 =  "-";
							$data['avglog']		 =  "-";
							$data['latecoming']  =  "-";
							$data['earlyleaving']=  "-";
						}
					
					}
			
		//////////////////Average  Time Off ////////////////////
		$q5=$this->db->query("SELECT SEC_TO_TIME(sum(TIME_TO_SEC(TIMEDIFF(T.TimeTo,T.TimeFrom)))) AS timeoff,TIME_TO_SEC(SEC_TO_TIME(sum(TIME_TO_SEC(TIMEDIFF(T.TimeTo,T.TimeFrom)))
		)) AS cumtimeoff,T.`TimeofDate` FROM Timeoff T WHERE  T.OrganizationId =$orgid  and T.`TimeofDate` IN (".$rangedate.") AND T.TimeFrom != '00:00:00' AND T.TimeTo != '00:00:00'  AND T.EmployeeId=$empid");
		
				if($row5 = $q5->row())
				{
					$data['timeoff']=substr($row5->timeoff,0,-3);
					$total3=$total3+$row5->cumtimeoff;
					if($row5->timeoff=='')
					{
					$data['timeoff']="-";
					}
				}
					
		$q6=$this->db->query("SELECT 				A.AttendanceDate,sec_to_time(sum(time_to_sec(timediff(SEC_TO_TIME(CASE WHEN(A.TimeOut>S.TimeOutBreak)
					THEN time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)) 
					ELSE time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)-time_to_sec(TIMEDIFF(S.TimeOutBreak,S.TimeInBreak))) END),sec_to_time(time_to_sec(TIMEDIFF(A.TimeOut,A.TimeIn)))))) )as undertime ,time_to_sec(sec_to_time(sum(time_to_sec(timediff(SEC_TO_TIME(CASE WHEN(A.TimeOut>S.TimeOutBreak)
					THEN time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)) 
					ELSE time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)-time_to_sec(TIMEDIFF(S.TimeOutBreak,S.TimeInBreak))) END),sec_to_time(time_to_sec(TIMEDIFF(A.TimeOut,A.TimeIn)))))) ))as cumundertime
					
					FROM AttendanceMaster A, ShiftMaster S WHERE (A.TimeIn != '00:00:00') and (S.TimeIn != '00:00:00')  AND A.OrganizationId =$orgid AND (A.TimeOut != '00:00:00') and A.EmployeeId = $empid   AND S.Id =$shiftid AND A.AttendanceDate IN (".$rangedate.") and SEC_TO_TIME(CASE WHEN(A.TimeOut>S.TimeOutBreak)
					THEN time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)) 
					ELSE time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)-time_to_sec(TIMEDIFF(S.TimeOutBreak,S.TimeInBreak))) END)>sec_to_time(time_to_sec(TIMEDIFF(A.TimeOut,A.TimeIn))) ");
						if($row6 = $q6->row())	{				
						$data['undertime']=substr($row2->undertime,0,-3);
						$total2=$total2+$row2->cumundertime;
						if($row5->undertime=='')
							{
							$data['undertime']="-";
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
		$timeFormat4 	= 	sprintf('%02d:%02d',$hours, $mins);
		
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
					<h3 style="color:green;padding:0px; margin:0px;">Monthly Attendance Summary
					</h3>
					['.$date.']
					<div style="margin-top:5%;">
					<table style="border-collapse: collapse;" border width="100%"><tr style="color:#fa6804"><th>Sr.No</th><th style="width:25%">Employees</th><th style="width:15%;">Total Hours Logged</th><th style="width:15%;">Total Late Coming</th><th style="width:15%;">Total Early Leaving</th><th style="width:15%;">Total Time <br/>Off</th>
					<th style="width:15%;">Total Undertime</th>
					</tr>';	
					foreach($r['report'] as $emp)
					{
						$message.= '<tr>
							<td align="center"  style="padding-left:1%">'.($index++).'</td>
							<td align="left" style="width:25%;padding-left:1%">'.$emp['name'].'</td>
							<td align="right" style="width:15%;padding-right:3%">'.$emp['avglog'].'</td>
							<td align="right" style="width:15%;padding-right:3%">'.$emp['latecoming'].'</td>
							<td align="right" style="width:15%;padding-right:3%">'.$emp['earlyleaving'].'</td>
							<td align="right" style="width:15%;padding-right:3%">'.$emp['timeoff'].'</td>
							<td align="right" style="width:15%;padding-right:3%">'.$emp['undertime'].'</td>
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
				 Team’s Total / No. of Employees</span>
				</p>
			</div>
			
			<div style="display:none" >
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
			</div></div>';
				}
				
				$message.='</center>';
				print_r($message);
				}
								
			}
			
			
		
		
		// get working days  according to shift
		public function getWorkingDays($shiftid,$date)
	   {
			$org_id = isset($_SESSION['orgid'])?$_SESSION['orgid']:0;
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
			
			////get last month///////////
			function  getStartAndEndDate1()
			{
			$firstday=date('Y-m-d', strtotime('first day of last month'));
			$lastday=date('Y-m-d', strtotime('last day of last month'));
			$result['start_date'] = $firstday;
			$result['end_date'] = $lastday;
			return $result;
			}
			
		function attendanceOutsideThefencedArea()
		 {
			$result = array();
			$orgid = isset($_SESSION['orgid'])?$_SESSION['orgid']:0;
			$zname=getTimeZone($orgid);
			date_default_timezone_set ($zname);
			$time = date("H:i:00");
			
			$date=date('d-M-Y',strtotime('-1 day'));
			$date1 = date("Y-m-d",strtotime('-1 day'));
			$list=array();
			$list['orgid']=$orgid;
			$list['admin']=getAdminName($orgid);
			$list['email']=getAdminEmail($orgid);
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
						if(count($arr1)>1)
						{
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
				
				$result[]=$list;
				
			 $this->db->close();	
	$message='';
	
		foreach($result as $r)
		{
			
			$message ='<center><img src="http://ubitechsolutions.com/ubitechsolutions/Mailers/ubiAttendance/ubiAttendance/logo.png" width="250px;"/></center>';
			$message.= '<center><div style="width:750px;" >
			<h3 style="color:green;text-align:center;font-weight:bold;padding:0px; margin:0px;">Attendance Marked outside the Fenced Area*</h3>';
			$message.='['.$date.']<br/>';
			$index=1;
			if(count($r['geoloc'])>0)
			{
				$message.='<div style="margin-top:5%;"><table style="border-collapse: collapse;" border width="100%"><tr style="color:#fa6804;"><th>S.no</th><th>Employee</th><th>Time In</th><th>Time Out</th></tr>';	
			
				foreach($r['geoloc'] as $emp)
				{
				$message.= '<tr><td align="center"  >'.($index++).'</td><td align="center">'.$emp['Name'].'</td><td align="center">'.$emp['ti'].$emp['positionlin'].'</td><td align="center">'.$emp['to'].$emp['positionout'].'</td></tr>';
				}
				$message.= '</div></table>';
			}
			$message.='<p style="text-align:left">
			Report sent on 
			<b>'.$date.'</b> at <b>'.$time.'</b><br/>
			View more details on – <span><a href="https://ubiattendance.ubihrm.com">https://ubiattendance.ubihrm.com/</a><span></p>
			<p style="text-align:left;font-weight:bold">Cheers,<br/>
			Team ubiAttendance<br/>
			<a href="www.ubiattendance.com">www.ubiattendance.com</a><br/>
			Tel/ Whatsapp: +91 70678 22132<br/>
			Email: <a href="ubiattendance@ubitechsolutions.com">ubiattendance@ubitechsolutions.com<a><br/>
			Skype: ubitech.solutions
			</p>
			
			<p style="text-align:left;font-size:13px">You have received this email because your are a registered member on ubiAttendance App. If you do not want to receive this mailer, <a href="unsubscribe">unsubscribe<a>. To make sure this email is not sent to your "junk" folder, Add “<a href="ubiattendance@ubitechsolutions.com">ubiattendance@ubitechsolutions.com</a>” to your Address Book</p><br/>
			<p style="text-align:left;font-size:10px">*Disclaimer: These GPS data files are made available with the understanding that data is provided with no warranties, expressed or implied, concerning data accuracy, completeness, reliability, or suitability. Ubitech Solutions’ service shall not be liable regardless of the cause or duration, for any errors, inaccuracies, omissions, or other defects in, or untimeliness or inauthenticity of, the Information, or for any delay or interruption in the transmission thereof to the user, or for any Claims or Losses arising therefrom or occasioned thereby. The end user assumes the entire risk as to the quality of the data. Although every effort has been made to ensure the correctness and accuracy of the GPS Dataset, the Supplier makes no representations, either express or implied, as to the accuracy, completeness or suitability for any particular purpose of the information and accepts no liability for any use of the GPS Dataset or any responsibility for any reliance placed on that information. The user acknowledges that the Dataset cannot be guaranteed error free and that use of the Dataset is at the user’s sole risk and that the information contained in the Dataset may be subject to change without notice.</p>

			</div>';
			
			$message.='</center>';
			print_r($message);	
		
	  }
		 }
public function distance($lat1, $lon1, $lat2, $lon2, $unit) 
    {
	  $theta = $lon1 - $lon2;
	  $dist = sin(deg2rad((float)$lat1)) * sin(deg2rad((float) $lat2)) +  cos(deg2rad((float) $lat1)) * cos(deg2rad((float) $lat2)) * cos(deg2rad((float) $theta));
	  $dist = acos($dist);
	  $dist = rad2deg($dist);
	  $miles = $dist * 60 * 1.1515;
	  $unit = strtoupper($unit);
	  if ($unit == "K") 
	  {
		return ($miles * 1.609344);
	  } 
	  else if ($unit == "N") 
	  {
		return ($miles * 0.8684);
	  } else {
			return $miles;
		  }
    }	
			
	
  }
  ?>