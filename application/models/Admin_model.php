
<?php
class Admin_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
		include(APPPATH."PhpMailer/class.phpmailer.php");
    }
		
	///////////////////shifts////////////////////////////
		public function getAllShift()
		{
			 $orgid=$_SESSION['orgid'];
			 $query = $this->db->query("SELECT `Id`, `Name`, `TimeIn`, `TimeOut`, `TimeInGrace`, `TimeOutGrace`, `TimeInBreak`, `TimeOutBreak`, `BreakInGrace`, `BreakOutGrace`,`archive`,TIMEDIFF(`TimeOut`,`TimeIn`) AS shifthpurs, TIMEDIFF(TIMEDIFF(`TimeOut`,`TimeIn`),TIMEDIFF(`TimeOutBreak`,`TimeInBreak`)) AS workhours,TIMEDIFF(`TimeOutBreak`,`TimeInBreak`) as breakhours,shifttype FROM `ShiftMaster` WHERE OrganizationId=? order by TimeIn",array($orgid));
			$d=array();
			$res=array();
			 foreach ($query->result() as $row)
			{
					$data=array();
					$data['name']=$row->Name;
					$data['timein']=substr($row->TimeIn,0,5);
					$data['timeout']=substr($row->TimeOut,0,5);
					$data['timeingrace']=$row->TimeInGrace;
					$data['timeoutgrace']=$row->TimeOutGrace;
					$data['timeinbreak']=substr($row->TimeInBreak,0,5);
					$data['timeoutbreak']=substr($row->TimeOutBreak,0,5);
					
					if($row->shifttype==1)
					{
						if(strtotime($row->TimeIn) < strtotime($row->TimeOut))
						  {
							$a = new DateTime($row->TimeIn);
							$b = new DateTime($row->TimeOut);
							$interval1 = $a->diff($b);
							$data['shifthpurs']= $interval1->format("%H:%I");
							$a = new DateTime($interval1->format("%H:%I"));
						    $b = new DateTime(getShiftBreak($row->Id));
							$interval = $a->diff($b);
							$data['workhours']= $interval->format("%H:%I");
							//$data['shifthpurs']=substr(ltrim($row->shifthpurs,'-'),0,5);
						    //$data['workhours']=substr(trim($row->workhours,"-!"),0,5);
						  }
						  else
						  {
							    $time = "24:00:00";
								$secs = strtotime($row->TimeIn)-strtotime($row->TimeOut);
								$data['shifthpurs'] = date("H:i",strtotime($time)-$secs);
								$a = new DateTime($data['shifthpurs']);
								$b = new DateTime(getShiftBreak($row->Id));
								$interval = $b->diff($a);
								$data['workhours']= $interval->format("%H:%I");
						 }
						//$data['shifthpurs']=substr(ltrim($row->shifthpurs,'-'),0,5);
						//$data['workhours']=substr(trim($row->workhours,"-!"),0,5);
					}
					else
					{
						/*$timearr=array();
						$timearr=explode(':',substr(substr($row->shifthpurs,1),0,5));
						$data['shifthpurs']=(23-$timearr[0]) .':'. (60-$timearr[1]);
						$time = $data['shifthpurs'];
						$time2 = $row->breakhours;
						$secs = strtotime("00:00:00")-strtotime($time2);
						$result = date("H:i:s",strtotime($time)+$secs);
						$data['workhours']=substr(trim($result,'-'),0,5);*/
					        	$time = "24:00:00";
								$secs = strtotime($row->TimeIn)-strtotime($row->TimeOut);
								$data['shifthpurs'] = date("H:i",strtotime($time)-$secs);
								$a = new DateTime($data['shifthpurs']);
								$b = new DateTime(getShiftBreak($row->Id));
								$interval = $b->diff($a);
								$data['workhours']= $interval->format("%H:%I");
					}
					//substr(trim($row->Overtime,"-!"),0,5);
					$data['shifttype']=$row->shifttype==1?'<div style="background-color:green;text-align:center;color:white;">Single Date</div>':'<div style="background-color:orange;text-align:center;color:white;">
					Multi Date</div>';
					//substr(trim($row->Overtime,"-!"),0,5);
					$data['status']=$row->archive==1?'<div style="background-color:green;text-align:center;color:white;">Active</div>':'<div style="background-color:red;text-align:center;color:white;">
					Inactive</div>';
					/*
					$data['action']='<a href="#"><i class="material-icons editShift" style="font-size:26px" data-toggle="modal" title="Edit/View" data-sid="'.$row->Id.'"
					 data-sid="'.$row->Id.'" 
					 data-name="'.$row->Name.'" 
					 data-ti="'.date("g:i A", strtotime($row->TimeIn)).'" 
					 data-to="'.date("g:i A", strtotime($row->TimeOut)).'" 
					 data-tig="'.date("g:i A", strtotime($row->TimeInGrace)).'"
					 data-tog="'.date("g:i A", strtotime($row->TimeOutGrace)).'"
					 data-tib="'.date("g:i A", strtotime($row->TimeInBreak)).'"
					 data-tob="'.date("g:i A", strtotime($row->TimeOutBreak)).'"
					 data-big="'.date("g:i A", strtotime($row->BreakInGrace)).'"
					 data-bog="'.date("g:i A", strtotime($row->BreakOutGrace)).'"
					 data-sts="'.$row->archive.'"
					data-target="#addShiftE">edit</i></a>
					<i class="deleteShift fa fa-trash" style="font-size:24px; color:purple" data-toggle="modal" data-target="#delShift" data-sid="'.$row->Id.'" data-sname="'.$row->Name.'" title="Delete" ></i>
					'; */
					$data['action'] = '<a href = "'.URL .'Admin/viewshift/'.$row->Id .'" ><i class="material-icons" style="font-size:26px" title="Edit/View" >edit</i> </a> <i class="deleteShift fa fa-trash" style="font-size:24px; color:purple" data-toggle="modal" data-target="#delShift" data-sid="'.$row->Id.'" data-sname="'.$row->Name.'" title="Delete" ></i>
					<i class="upShift fa fa-check-square-o" style="font-size:24px; color:purple" data-toggle="modal" data-target="#updateShift" onclick="angular.element(this).scope().GetEmpList(\''.$row->Id.'\')" 
					data-sid="'.$row->Id.'" data-sname="'.$row->Name.'" title="Assign" ></i>
					';
					$res[]=$data;
			}  	
			$d['data']=$res; 
			 $this->db->close();
			echo json_encode($d);
			return false;
		}
		
		public function getshiftdata($sid)
		{
			$res = array();
			$orgid = $_SESSION['orgid'];
			$query= $this->db->query("Select * from ShiftMaster where Id = '$sid' AND OrganizationId = '$orgid' ");
			foreach($query->result() as $row)
			{
				$data = array();
				$data['sti'] = $row->TimeIn;
				$data['sto'] = $row->TimeOut;
				$data['bsti'] = $row->TimeInBreak;
				$data['bsto'] = $row->TimeOutBreak;
				$data['tig'] = $row->TimeInGrace;
				$data['tog'] = $row->TimeOutGrace;
				$data['status'] = $row->archive;
				$data['stype'] = $row->shifttype;
				$data['sname'] = $row->Name;
				$res[] = $data;
				break;
			}
			return $res;
		}
		
		public function registerShift()
		 {
			$orgid=$_SESSION['orgid'];
			$id=$_SESSION['id'];
			$sna=isset($_REQUEST['sna'])?$_REQUEST['sna']:'';
			$res=0;
			$query = $this->db->query("select Id from `ShiftMaster` where Name=? and OrganizationId=?  ",array($sna,$orgid));
			if($query->num_rows()>0)
				$res=2; // Shift Name already exist 
			else
			{
			$ti=date("H:i:s",strtotime(isset($_REQUEST['ti'])?$_REQUEST['ti']:''));
			$to=date("H:i:s",strtotime(isset($_REQUEST['to'])?$_REQUEST['to']:''));
			$tib=date("H:i:s",strtotime(isset($_REQUEST['tib'])?$_REQUEST['tib']:''));
			$tob=date("H:i:s",strtotime(isset($_REQUEST['tob'])?$_REQUEST['tob']:''));
			$tig=date("H:i:s",strtotime(isset($_REQUEST['tig'])?$_REQUEST['tig']:''));
			$gto=date("H:i:s",strtotime(isset($_REQUEST['gto'])?$_REQUEST['gto']:''));
			// $tog=date("H:i:s",strtotime(isset($_REQUEST['tog'])?$_REQUEST['tog']:''));
			$bog=date("H:i:s",strtotime(isset($_REQUEST['bog'])?$_REQUEST['bog']:''));
			$big=date("H:i:s",strtotime(isset($_REQUEST['big'])?$_REQUEST['big']:''));
			$sts=isset($_REQUEST['sts'])?$_REQUEST['sts']:0;
			$shifttype=isset($_REQUEST['shifttype'])?$_REQUEST['shifttype']:0;
			$date=date('Y-m-d');

			$query = $this->db->query("INSERT INTO `ShiftMaster`(`Name`, `TimeIn`, `TimeOut`, `TimeInGrace`,`TimeOutGrace`,`TimeInBreak`, `TimeOutBreak`, `OrganizationId`, `CreatedDate`,`CreatedById`, `LastModifiedDate`, `LastModifiedById`, `OwnerId`, `BreakInGrace`,`BreakOutGrace`, `archive`,shifttype) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($sna,$ti,$to,$tig,$gto,$tib,$tob,$orgid,$date,$id,$date,$id,$id,$big,$bog,$sts,$shifttype));
			//$res= $this->db->affected_rows($query);
			$lsid = $this->db->insert_id();
			// var_dump($this->db->last_query());
		  //insert weekoff in this shift
		    if($this->db->affected_rows($query)>0)
			{
          	$sun=isset($_REQUEST['sun'])?$_REQUEST['sun']:'0,0,0,0,0';
			$mon=isset($_REQUEST['mon'])?$_REQUEST['mon']:'0,0,0,0,0';
			$tue=isset($_REQUEST['tue'])?$_REQUEST['tue']:'0,0,0,0,0';
			$wed=isset($_REQUEST['wed'])?$_REQUEST['wed']:'0,0,0,0,0';
			$thus=isset($_REQUEST['thus'])?$_REQUEST['thus']:'0,0,0,0,0';
			$fri=isset($_REQUEST['fri'])?$_REQUEST['fri']:'0,0,0,0,0';
			$sat=isset($_REQUEST['sat'])?$_REQUEST['sat']:'0,0,0,0,0';
			$user=0;
			$orgId=isset($_SESSION['orgid'])?$_SESSION['orgid']:$_REQUEST['refId']; 
			// ref id if fun called by mobile when not set session
			$zname='Asia/Kolkata';
			/////////////get time zone
				$zname=getTimeZone($orgId);
				date_default_timezone_set ($zname);
			//////////////get time zone///////////
			$today=date('Y-m-d');
			
			$query = $this->db->query("INSERT INTO `ShiftMasterChild`(`ShiftId`,`Day`,`WeekOff`, `OrganizationId`, `ModifiedBy`, `ModifiedDate`, `Archive`) VALUES ($lsid,1,?,?,?,?,'1')",array($sun,$orgId,$user,$today));
			
			$query = $this->db->query("INSERT INTO `ShiftMasterChild`(`ShiftId`,`Day`,`WeekOff`, `OrganizationId`, `ModifiedBy`, `ModifiedDate`, `Archive`) VALUES ($lsid,2,?,?,?,?,'1')",array($mon,$orgId,$user,$today));
			
			$query = $this->db->query("INSERT INTO `ShiftMasterChild`(`ShiftId`,`Day`,`WeekOff`, `OrganizationId`, `ModifiedBy`, `ModifiedDate`, `Archive`) VALUES ($lsid,3,?,?,?,?,'1')",array($tue,$orgId,$user,$today));
			
			$query = $this->db->query("INSERT INTO `ShiftMasterChild`(`ShiftId`,`Day`,`WeekOff`, `OrganizationId`, `ModifiedBy`, `ModifiedDate`, `Archive`) VALUES ($lsid,4,?,?,?,?,'1')",array($wed,$orgId,$user,$today));
			$query = $this->db->query("INSERT INTO `ShiftMasterChild`(`ShiftId`,`Day`,`WeekOff`, `OrganizationId`, `ModifiedBy`, `ModifiedDate`, `Archive`) VALUES ($lsid,5,?,?,?,?,'1')",array($thus,$orgId,$user,$today));
			$query = $this->db->query("INSERT INTO `ShiftMasterChild`(`ShiftId`,`Day`,`WeekOff`, `OrganizationId`, `ModifiedBy`, `ModifiedDate`, `Archive`) VALUES ($lsid,6,?,?,?,?,'1')",array($fri,$orgId,$user,$today));
			$query = $this->db->query("INSERT INTO `ShiftMasterChild`(`ShiftId`,`Day`,`WeekOff`, `OrganizationId`, `ModifiedBy`, `ModifiedDate`, `Archive`) VALUES ($lsid,7,?,?,?,?,'1')",array($sat,$orgId,$user,$today));

				


			$res= $this->db->affected_rows($query);	

			if($res > 0){
				$query12112 = $this->db->query("SELECT `Id`, `Name`, `TimeIn`, `TimeOut`, `TimeInGrace`, `TimeOutGrace`, `TimeInBreak`, `TimeOutBreak`, `OrganizationId`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `OwnerId`, `BreakInGrace`, `BreakOutGrace`, `archive`, `shifttype` FROM `ShiftMaster` WHERE Name = '$sna' ");
			if ($r=$query12112->result()){
							$sname  = $r[0]->Name;
							
					$date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $id =$_SESSION['id'];
           
           $module = "Settings";
           $actionperformed = " <b>".$sname."</b> shift has been <b> Added.  </b>.";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));

					}
			}


		   }			
		}
			$this->db->close();
		    echo $res;
			
		}
		public function qrcodeselector(){
			$orgid=$_SESSION['orgid'];
			$id=$_SESSION['id'];
			$sna=isset($_REQUEST['sna'])?$_REQUEST['sna']:'';
			$res=0;
			$query = $this->db->query("select id from `admin_login` where Name=? and id =? and OrganizationId=?  ",array($sna,$id,$orgid));
			if($query->num_rows()>0)
				$res=2; // QR template already selected
			else
			{
			$qrselect=isset($_REQUEST['home'])?$_REQUEST['home']:'0';
			// echo $qrselect;

			$query = $this->db->query("update `admin_login` set qrselector = $qrselect  WHERE id=$id;");
			// var_dump($this->db->last_query());
			//$res= $this->db->affected_rows($query);
			$lsid = $this->db->insert_id();

			$res= $this->db->affected_rows($query);
		}
		$this->db->close();
		    echo $res;

		}
		public function editShift()
		{
			// $orgid=$_SESSION['orgid'];
			// $id=$_SESSION['id'];
			// $sna=isset($_REQUEST['sna'])?$_REQUEST['sna']:'';
			// $sid=isset($_REQUEST['sid'])?$_REQUEST['sid']:'';
			// $shifttype=isset($_REQUEST['shifttype'])?$_REQUEST['shifttype']:0;
			// $sts=isset($_REQUEST['sts'])?$_REQUEST['sts']:0;
			// $date=date('Y-m-d');
			// $res=0;
			
			// $query = $this->db->query("select Id from `ShiftMaster` where Name=? and OrganizationId=? and Id !=? ",array($sna,$orgid,$sid));
			// if($query->num_rows()>0)
			// 	$res= 2; // Shift Name already exist 
			
		 // $query = $this->db->query("select Id from `AttendanceMaster` where OrganizationId=? and ShiftId=? ",array($orgid,$sid));
	  // if($query->num_rows()>0)
	  //   //if(false)
		 // $res= 3; 
			// else
			// {
			// $ti=date("H:i:s",strtotime(isset($_REQUEST['ti'])?$_REQUEST['ti']:''));
			// $to=date("H:i:s",strtotime(isset($_REQUEST['to'])?$_REQUEST['to']:''));
			// $tib=date("H:i:s",strtotime(isset($_REQUEST['tib'])?$_REQUEST['tib']:''));
			// $tob=date("H:i:s",strtotime(isset($_REQUEST['tob'])?$_REQUEST['tob']:''));
			// $query = $this->db->query("UPDATE `ShiftMaster` SET `Name`=?,`LastModifiedDate`=?, `LastModifiedById`=?,  `archive`=?, `TimeIn`=?, `TimeOut`=?,   `TimeInBreak`=?, `TimeOutBreak`=?,shifttype=? where id=? and OrganizationId=?",array($sna,$date,$id,$sts,$ti,$to,$tib,$tob,$shifttype,$sid,$orgid));
			//   // $res=$this->db->affected_rows($query);
			//   // var_dump($res);
				
			// 	$sun=isset($_REQUEST['sun'])?$_REQUEST['sun']:'0,0,0,0,0';
			// 	$mon=isset($_REQUEST['mon'])?$_REQUEST['mon']:'0,0,0,0,0';
			// 	$tue=isset($_REQUEST['tue'])?$_REQUEST['tue']:'0,0,0,0,0';
			// 	$wed=isset($_REQUEST['wed'])?$_REQUEST['wed']:'0,0,0,0,0';
			// 	$thus=isset($_REQUEST['thus'])?$_REQUEST['thus']:'0,0,0,0,0';
			// 	$fri=isset($_REQUEST['fri'])?$_REQUEST['fri']:'0,0,0,0,0';
			// 	$sat=isset($_REQUEST['sat'])?$_REQUEST['sat']:'0,0,0,0,0';
				
			// 	$query = $this->db->query("update `ShiftMasterChild` set `WeekOff`=? where `ShiftId`=$sid and `Day`=1",array($sun));
				
			// 	$query = $this->db->query("update `ShiftMasterChild` set `WeekOff`=? where `ShiftId`=$sid and `Day`=2",array($mon));
				
			// 	$query = $this->db->query("update `ShiftMasterChild` set `WeekOff`=? where `ShiftId`=$sid and `Day`=3",array($tue));
				
			// 	$query = $this->db->query("update `ShiftMasterChild` set `WeekOff`=? where `ShiftId`=$sid and `Day`=4",array($wed));
				
			// 	$query = $this->db->query("update `ShiftMasterChild` set `WeekOff`=? where `ShiftId`=$sid and `Day`=5",array($thus));
				
			// 	$query = $this->db->query("update `ShiftMasterChild` set `WeekOff`=? where `ShiftId`=$sid and `Day`=6",array($fri));
				
			// 	$query = $this->db->query("update `ShiftMasterChild` set `WeekOff`=? where `ShiftId`=$sid and `Day`=7",array($sat));
			// 	$res= $this->db->affected_rows($query);

				
			
			// }
			//  $this->db->close();
			//  echo $res;




			$orgid=$_SESSION['orgid'];
			$id=$_SESSION['id'];
			$sna=isset($_REQUEST['sna'])?$_REQUEST['sna']:'';
			$sid=isset($_REQUEST['sid'])?$_REQUEST['sid']:'';
			$shifttype=isset($_REQUEST['shifttype'])?$_REQUEST['shifttype']:0;
			$sts=isset($_REQUEST['sts'])?$_REQUEST['sts']:0;
			$date=date('Y-m-d');
			$res=0;
			
			$query = $this->db->query("select Id from `ShiftMaster` where Name=? and OrganizationId=? and Id !=? ",array($sna,$orgid,$sid));
			
			if($query->num_rows()>0)
				{
					$res= 2;// Shift Name already exist 
				} 
			
		 	// $query = $this->db->query("select Id from `AttendanceMaster` where OrganizationId=? and ShiftId=? ",array($orgid,$sid));
		 	
	  		// if($query->num_rows()>0)
				// {
				// $res= 3; // Shift  already exist in AttendanceMaster
				// }
			else
			{
			$ti=date("H:i:s",strtotime(isset($_REQUEST['ti'])?$_REQUEST['ti']:''));
			$to=date("H:i:s",strtotime(isset($_REQUEST['to'])?$_REQUEST['to']:''));
			$tib=date("H:i:s",strtotime(isset($_REQUEST['tib'])?$_REQUEST['tib']:''));
			$tob=date("H:i:s",strtotime(isset($_REQUEST['tob'])?$_REQUEST['tob']:''));
			$query = $this->db->query("UPDATE `ShiftMaster` SET `Name`=?,`LastModifiedDate`=?, `LastModifiedById`=?,  `archive`=?, `TimeIn`=?, `TimeOut`=?,`TimeInBreak`=?, `TimeOutBreak`=?,shifttype=? where id=? and OrganizationId=?",array($sna,$date,$id,$sts,$ti,$to,$tib,$tob,$shifttype,$sid,$orgid));
			  $res1=$this->db->affected_rows($query);

			  if($res1>0)
			  {
			  	$query12112 = $this->db->query("SELECT `Id`, `Name`, `TimeIn`, `TimeOut`, `TimeInGrace`, `TimeOutGrace`, `TimeInBreak`, `TimeOutBreak`, `OrganizationId`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `OwnerId`, `BreakInGrace`, `BreakOutGrace`, `archive`, `shifttype` FROM `ShiftMaster` WHERE Name = '$sna' ");
			if ($r=$query12112->result()){
							$sname  = $r[0]->Name;
							
					$date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $id =$_SESSION['id'];
           
           $module = "Settings";
           $actionperformed = " <b>".$sname."</b> shift has been <b>Updated.  </b>.";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));

					}
			  	$res=1;
			  }
			  else
			  {
				$sun=isset($_REQUEST['sun'])?$_REQUEST['sun']:'0,0,0,0,0';
				$mon=isset($_REQUEST['mon'])?$_REQUEST['mon']:'0,0,0,0,0';
				$tue=isset($_REQUEST['tue'])?$_REQUEST['tue']:'0,0,0,0,0';
				$wed=isset($_REQUEST['wed'])?$_REQUEST['wed']:'0,0,0,0,0';
				$thus=isset($_REQUEST['thus'])?$_REQUEST['thus']:'0,0,0,0,0';
				$fri=isset($_REQUEST['fri'])?$_REQUEST['fri']:'0,0,0,0,0';
				$sat=isset($_REQUEST['sat'])?$_REQUEST['sat']:'0,0,0,0,0';
				//var_dump($sun);
				$query = $this->db->query("update `ShiftMasterChild` set `WeekOff`=? where `ShiftId`=$sid and `Day`=1",array($sun));
				$res2=$this->db->affected_rows($query);
				if($res2>0)
				{
				$res=1;
				}

				
				$query = $this->db->query("update `ShiftMasterChild` set `WeekOff`=? where `ShiftId`=$sid and `Day`=2",array($mon));
				$res3=$this->db->affected_rows($query);
				if($res3>0)
				{

					$res=1;
				}
				
				$query = $this->db->query("update `ShiftMasterChild` set `WeekOff`=? where `ShiftId`=$sid and `Day`=3",array($tue));
				$res4=$this->db->affected_rows($query);
				if($res4>0)
				{
					$res=1;
				}

				$query = $this->db->query("update `ShiftMasterChild` set `WeekOff`=? where `ShiftId`=$sid and `Day`=4",array($wed));
				$res5=$this->db->affected_rows($query);
				if($res5>0 )
				{
					$res=1;
				}

				$query = $this->db->query("update `ShiftMasterChild` set `WeekOff`=? where `ShiftId`=$sid and `Day`=5",array($thus));
				$res6=$this->db->affected_rows($query);
				if($res6>0 )
				{
					$res=1;
				}

				$query = $this->db->query("update `ShiftMasterChild` set `WeekOff`=? where `ShiftId`=$sid and `Day`=6",array($fri));
				$res7=$this->db->affected_rows($query);
				if($res7>0 )
				{
					$res=1;
				}
				
				$query = $this->db->query("update `ShiftMasterChild` set `WeekOff`=? where `ShiftId`=$sid and `Day`=7",array($sat));
				$res8=$this->db->affected_rows($query);
				if($res8>0 )
				{
					

					$res=1;
				}
				
			}
			
			}
			 $this->db->close();
			 echo $res;


		}
		
		
		///////////-------Shifts
				///////// departments
		public function getAllDept(){
			$orgid=$_SESSION['orgid'];
			 $query = $this->db->query("SELECT `Id`, `Name`,`CreatedDate`, `LastModifiedDate`, `archive` FROM `DepartmentMaster` WHERE OrganizationId=? order by name",array($orgid));
			$d=array();
			$res=array();
			 foreach ($query->result() as $row)
			{
				$data=array();
					$data['name']=$row->Name;
					$data['cdate']=$row->CreatedDate;
					$data['mdate']=$row->LastModifiedDate;
					$data['status']=$row->archive==1?'<div style="background-color:green;text-align:center;color:white;">Active</div>':'<div style="background-color:red;text-align:center;color:white;">
					Inactive</div>';
					$data['action']='<a href="#"><i class="material-icons edit" data-toggle="modal" title="Edit" data-sid="'.$row->Id.'"
					 data-did="'.$row->Id.'" 
					 data-name="'.$row->Name.'" 
					 data-sts="'.$row->archive.'"
					 data-assign="'.departmentAssignAll($row->Id).'"
					data-target="#addDeptE">edit</i></a>
				   <i class="delete fa fa-trash" style="font-size:24px; color:purple;" data-toggle="modal" data-target="#delDept" data-did="'.$row->Id.'" data-dname="'.$row->Name.'" title="Delete" ></i> ';
					$res[]=$data;
			}  	
			$d['data']=$res;
			 $this->db->close();
			echo json_encode($d); return false;
		}
		
		public function registerDept(){
			$orgid=$_SESSION['orgid'];
			$id=$_SESSION['id'];
			$dna=isset($_REQUEST['dna'])?$_REQUEST['dna']:'';
			$sts=isset($_REQUEST['sts'])?$_REQUEST['sts']:0;
			$date=date('Y-m-d');
			$res=0;
			$query = $this->db->query("select Id from `DepartmentMaster` where Name=? and OrganizationId=?  ",array($dna,$orgid));
			if($query->num_rows()>0)
				$res=2; // Dept Name already exist already exist
			else{
			$query = $this->db->query("INSERT INTO `DepartmentMaster`(`Name`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `OwnerId`, `OrganizationId`,`archive`) VALUES (?,?,?,?,?,?,?,?)",array($dna,$date,$id,$date,$id,$id,$orgid,$sts));
			$res= $this->db->affected_rows();
			// $this->db->close();

			if($res > 0){
				$query121 = $this->db->query("SELECT `Id`, `Name`, `ParentId`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `OwnerId`, `OrganizationId`, `Code`, `archive` FROM `DepartmentMaster` WHERE Name='$dna' and OrganizationId='$orgid' ");
						if ($r=$query121->result()){
							$hname  = $r[0]->Name;
					$date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           
           $module = "Settings";
           $actionperformed = " <b>".$hname."</b> department has been <b> added  </b>.";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));

					}
			 
			}
			}
			echo $res;
		}
		
		public function editDept(){
			$orgid=$_SESSION['orgid'];
			$id=$_SESSION['id'];
			$dna=isset($_REQUEST['dna'])?$_REQUEST['dna']:'';
			$did=isset($_REQUEST['did'])?$_REQUEST['did']:'';
			$sts=isset($_REQUEST['sts'])?$_REQUEST['sts']:0;
			$date=date('Y-m-d');
			$res=0;
			$query = $this->db->query("select Id from `DepartmentMaster` where Name=? and OrganizationId=? and Id != ? ",array($dna,$orgid,$did));
			if($query->num_rows()>0)
				$res=2; // Dept Name already exist already exist
			else{
			$query = $this->db->query("UPDATE `DepartmentMaster` SET `Name`=?,`LastModifiedDate`=?,`LastModifiedById`=?,`archive`=? where id=? ",array($dna,$date,$id,$sts,$did));
			$res= $this->db->affected_rows();	
			// $this->db->close();
			if($res > 0){
				$query121 = $this->db->query("SELECT `Id`, `Name`, `ParentId`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `OwnerId`, `OrganizationId`, `Code`, `archive` FROM `DepartmentMaster` WHERE Name='$dna' and OrganizationId='$orgid' ");
						if ($r=$query121->result()){
							$hname  = $r[0]->Name;
					$date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $id =$_SESSION['id'];
           
           $module = "Settings";
           $actionperformed = " <b>".$hname."</b> department has been <b>updated  </b>.";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));

					}
			}
			}
			echo $res;
		}
		public function deleteDept(){
			$orgid=$_SESSION['orgid'];
			$did=isset($_REQUEST['did'])?$_REQUEST['did']:'';
			$data=array();
			$data['afft']=0;
			$query121 = $this->db->query("SELECT `Id`, `Name`, `ParentId`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `OwnerId`, `OrganizationId`, `Code`, `archive` FROM `DepartmentMaster` WHERE Id='$did' and OrganizationId='$orgid' ");
			$query = $this->db->query("select id as totemp from EmployeeMaster where EmployeeMaster.department=? and OrganizationId=? and Is_Delete != 2 ",array($did,$orgid));
			$data['emp']=$query->num_rows();
			
			$query = $this->db->query("select id as totemp from AttendanceMaster where Dept_id=? and OrganizationId=?",array($did,$orgid));
			$data['A_emp']=$query->num_rows();

			$query = $this->db->query("select id as totarc from ArchiveAttendanceMaster where ArchiveAttendanceMaster.Dept_id=? and OrganizationId=?",array($did,$orgid));
			$data['aarc']=$query->num_rows();
			
			 if($data['emp']==0 && $data['A_emp']==0 && $data['aarc']==0){
				$query = $this->db->query("DELETE FROM `DepartmentMaster` where id=? and OrganizationId=?",array($did,$orgid));
				$data['afft']=$this->db->affected_rows();

				if($data['afft'] > 0){

						if ($r=$query121->result()){
							$hname  = $r[0]->Name;
					$date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $id =$_SESSION['id'];
           
           $module = "Settings";
           $actionperformed = " <b>".$hname."</b> department has been <b>Deleted  </b> </b>.";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));

					}
				}
			} 
			 $this->db->close();
			echo json_encode($data);	
		}
		//////////////////---/department
		/////////////////////designations
		public function getAllDesg(){
			$orgid=isset($_SESSION['orgid'])?$_SESSION['orgid']:0;
			 $query = $this->db->query("SELECT `Id`, `Name`,Description, `CreatedDate`,  `LastModifiedDate`,`archive` FROM `DesignationMaster`  WHERE OrganizationId=? order by name",array($orgid));
			$d=array();
			$res=array();
			 foreach ($query->result() as $row)
			{
				    $data=array();
					$data['name']=$row->Name;
					$data['desc']=$row->Description;
					$data['cdate']=date('Y-m-d',strtotime($row->CreatedDate));
					$data['mdate']=date('Y-m-d',strtotime($row->LastModifiedDate));
					$data['status']=$row->archive==1?'<div style="background-color:green;text-align:center;color:white;">Active</div>':'<div style="background-color:red;text-align:center;color:white;">
					Inactive</div>';
					$data['action']='<a href="#" ><i class="material-icons edit"style="font-size:26px;" data-toggle="modal" title="Edit" data-sid="'.$row->Id.'"
					 data-did="'.$row->Id.'" 
					 data-name="'.$row->Name.'" 
					 data-sts="'.$row->archive.'"
					 data-desc="'.$row->Description.'"
					 data-assign="'.designationAssign($row->Id).'"
					data-target="#addDesgE">edit</i></a>
					 <i class="delete fa fa-trash" style="font-size:24px; color:purple;" data-toggle="modal" data-target="#delDesg" data-did="'.$row->Id.'" data-dname="'.$row->Name.'" title="Delete" ></i>
					';
					$res[]=$data;
			}  	
			$d['data']=$res; 
           $this->db->close();			//$query->result();
			echo json_encode($d); return false;
		}
		public function getAllrates()
		{
			$orgid=isset($_SESSION['orgid'])?$_SESSION['orgid']:0;
			 $query = $this->db->query("SELECT `Id`,`Name`,Rate, `CreatedDate`,`LastModifiedDate`,`status` FROM `HourlyRateMaster`  WHERE OrganizationId = ? order by name",array($orgid));
			$d=array();
			$res=array();
			 foreach ($query->result() as $row)
			{
				$data=array();
					$data['name']=$row->Name;/*getName('DesignationMaster','Name','Id',$row->Name);*/
					$data['rate']=$row->Rate;
					$data['cdate']=date('Y-m-d',strtotime($row->CreatedDate));
					$data['mdate']=date('Y-m-d',strtotime($row->LastModifiedDate));
					$data['status']=$row->status==1?'<div style="background-color:green;text-align:center;color:white;">Active</div>':'<div style="background-color:red;text-align:center;color:white;">
					Inactive</div>';
					$data['action']='<a href="#" ><i class="material-icons edit "style="font-size:26px;" data-toggle="modal" title="Edit" data-sid="'.$row->Id.'"
					 data-did="'.$row->Id.'" 
					 data-name="'.$row->Name.'" 
					 data-sts="'.$row->status.'"
					 data-rate="'.$row->Rate.'"
					data-target="#addDesgE">edit</i></a>
					 <i class="delete fa fa-trash" style="font-size:24px; color:purple;" data-toggle="modal" data-target="#delDesg" data-did="'.$row->Id.'" data-na="'.$row->Name.'" title="Delete" ></i>
					';
					$res[]=$data;
			}  	
			$d['data']=$res; 
           $this->db->close();			//$query->result();
			echo json_encode($d); return false;
		}
		public function registerDesg(){
			$orgid=$_SESSION['orgid'];
			$id=$_SESSION['id'];
			$dna=isset($_REQUEST['dna'])?$_REQUEST['dna']:'';
			$sts=isset($_REQUEST['sts'])?$_REQUEST['sts']:0;
			$desc=isset($_REQUEST['desc'])?$_REQUEST['desc']:0;
			$date=date('Y-m-d');
			$res=0;
			$query = $this->db->query("select Id from `DesignationMaster` where Name=? and OrganizationId=? ",array($dna,$orgid));
			if($query->num_rows()>0)
				$res=2; // Dept Name already exist already exist
			else{
			$query = $this->db->query("INSERT INTO `DesignationMaster`(`Name`, `OrganizationId`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `OwnerId`,`Description`, `archive`) VALUES (?,?,?,?,?,?,?,?,?)",array($dna,$orgid,$date,$id,$date,$id,$id,$desc,$sts));
			$res= $this->db->affected_rows();
			 // $this->db->close();
			if($res>0){
				$query121 = $this->db->query("SELECT `Id`, `Name`, `OrganizationId`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `OwnerId`, `Code`, `RoleId`, `HRSts`, `Description`, `archive`, `daysofnotice` FROM `DesignationMaster` WHERE Name='$dna' and OrganizationId='$orgid' ");
						if ($r=$query121->result()){
							$hname  = $r[0]->Name;
					$date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           
           $module = "Settings";
           $actionperformed = " <b>".$hname."</b> designation has been <b> added  </b>.";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));

					}
			}
			}
			echo $res;
		}
		public function addRate(){
			$orgid=$_SESSION['orgid'];
			$id=$_SESSION['id'];
			$rna=isset($_REQUEST['rna'])?$_REQUEST['rna']:'';
			$sts=isset($_REQUEST['sts'])?$_REQUEST['sts']:0;
			$rate=isset($_REQUEST['rate'])?$_REQUEST['rate']:0;
			$date=date('Y-m-d');
			$res=0;
			$query = $this->db->query("select Id from `HourlyRateMaster` where Rate=? and OrganizationId=? ",array($rate,$orgid));
			if($query->num_rows()>0)
				$res=2; // Rate already exist already exist
			else{
			$query = $this->db->query("INSERT INTO `HourlyRateMaster`(`Name`, `OrganizationId`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`,`Rate`, `status`) VALUES (?,?,?,?,?,?,?,?)",array($rna,$orgid,$date,$id,$date,$id,$rate,$sts));
			$res= $this->db->affected_rows();

			if($res > 0 ){
			 // $this->db->close();
			
			$query121 = $this->db->query("SELECT `Id`, `Name`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `OrganizationId`, `Rate`, `status` FROM `HourlyRateMaster` WHERE Rate='$rate' and OrganizationId='$orgid' ");
						if ($r=$query121->result()){
							$hname  = $r[0]->Name;
					$date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           
           $module = "Settings";
           $actionperformed = " New Hourly Rate <b>".$hname."</b>  has been <b> Added  </b>.";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));

					}
			}
		}
			echo $res;
		}
		
		public function editDesg()
		{
			$orgid=$_SESSION['orgid'];
			$id=$_SESSION['id'];
			$dna=isset($_REQUEST['dna'])?$_REQUEST['dna']:'';
			$did=isset($_REQUEST['did'])?$_REQUEST['did']:'';
			$sts=isset($_REQUEST['sts'])?$_REQUEST['sts']:0;
			$desc=isset($_REQUEST['desc'])?$_REQUEST['desc']:0;
			$date=date('Y-m-d');
			$res=0;
			$query = $this->db->query("select Id from `DesignationMaster` where Name=? and OrganizationId=? and Id != ?",array($dna,$orgid,$did));
			if($query->num_rows()>0)
				$res=2; // Dept Name already exist already exist
			else{
			$query = $this->db->query("UPDATE `DesignationMaster` SET `Name`=?,Description=?,`LastModifiedDate`=?,`LastModifiedById`=?,`archive`=? where id=? ",array($dna,$desc,$date,$id,$sts,$did));
			$res=$this->db->affected_rows();	
			 // $this->db->close();
			if($res>0){

				$query121 = $this->db->query("SELECT `Id`, `Name`, `OrganizationId`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `OwnerId`, `Code`, `RoleId`, `HRSts`, `Description`, `archive`, `daysofnotice` FROM `DesignationMaster` WHERE Name='$dna' and OrganizationId='$orgid' ");
						if ($r=$query121->result()){
							$hname  = $r[0]->Name;
					$date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           
           $module = "Settings";
           $actionperformed = " <b>".$hname."</b> designation has been <b> Updated  </b>.";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));

					}
				}
			}
			echo $res;
		}
		public function editRate()
		{
			$orgid=$_SESSION['orgid'];
			$id=$_SESSION['id'];
			$rna=isset($_REQUEST['rna'])?$_REQUEST['rna']:'';
			$rid=isset($_REQUEST['rid'])?$_REQUEST['rid']:'';
			$sts=isset($_REQUEST['sts'])?$_REQUEST['sts']:0;
			$rate=isset($_REQUEST['rate'])?$_REQUEST['rate']:0;
			$date=date('Y-m-d');
			$res=0;
			$query = $this->db->query("select Id from `HourlyRateMaster` where Rate=? and OrganizationId=? and Id !=?",array($rate,$orgid,$rid));
			if($query->num_rows()>0)
				$res=2; // Dept Name already exist already exist
			else{
			$query = $this->db->query("UPDATE `HourlyRateMaster` SET `Name`=?,Rate=?,`LastModifiedDate`=?,`LastModifiedById`=?,`status`=? where id=? ",array($rna,$rate,$date,$id,$sts,$rid));
			$res=$this->db->affected_rows();	
			 // $this->db->close();
			if($res > 0){
				$query121 = $this->db->query("SELECT `Id`, `Name`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `OrganizationId`, `Rate`, `status` FROM `HourlyRateMaster` WHERE Rate='$rate' and OrganizationId='$orgid' ");
						if ($r=$query121->result()){
							$hname  = $r[0]->Name;
					$date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           
           $module = "Settings";
           $actionperformed = " <b>".$hname."</b>  has been <b> Updated  </b>.";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));

					}
			}
			}
			echo $res;
		}
		
		public function deleteDesg()
		{
			$orgid=$_SESSION['orgid'];
			$did=isset($_REQUEST['did'])?$_REQUEST['did']:'';
			$data=array();
			$data['afft']=0;
			$query121 = $this->db->query("SELECT `Id`, `Name`, `OrganizationId`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `OwnerId`, `Code`, `RoleId`, `HRSts`, `Description`, `archive`, `daysofnotice` FROM `DesignationMaster` WHERE Id='$did' and OrganizationId='$orgid' ");
			$query = $this->db->query("select id as totemp from EmployeeMaster where EmployeeMaster.Designation=? and OrganizationId=? and Is_Delete != 2",array($did,$orgid));
			$data['emp']=$query->num_rows();

			// $query = $this->db->query("select id as totarc from ArchiveAttendanceMaster where ArchiveAttendanceMaster.Desg_id=? and OrganizationId=?",array($sid,$orgid));
			// $data['atarc']=$query->num_rows();
			
			 if($data['emp']==0){
				$query = $this->db->query("DELETE FROM `DesignationMaster` where id=? and OrganizationId=?",array($did,$orgid));
				$data['afft']=$this->db->affected_rows();

				if($data['afft']>0){


						if ($r=$query121->result()){
							$hname  = $r[0]->Name;
					$date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $id =$_SESSION['id'];
           
           $module = "Settings";
           $actionperformed = " <b>".$hname."</b> designation has been <b> Deleted  </b>.";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));

					}
				}
			} 
			 $this->db->close();
			echo json_encode($data);	
		}
		public function deleteRate(){
			$orgid=$_SESSION['orgid'];
			$rid=isset($_REQUEST['rid'])?$_REQUEST['rid']:'';
			$data=array();
			$data['afft']=0;
			$query = $this->db->query("select id  from EmployeeMaster where EmployeeMaster.hourly_rate=? and OrganizationId=? and Is_Delete != 2",array($rid,$orgid));
			$data['emp']= $query->num_rows();
			 if($data['emp']==0){
			 $query1 = $this->db->query("select Id  from AttendanceMaster where AttendanceMaster.HourlyRateId=? and OrganizationId=?",array($rid,$orgid));
			 $data['emp']= $query1->num_rows();
				 
				 if($data['emp']==0)
				 {
				$query = $this->db->query("DELETE FROM `HourlyRateMaster` where id=? and OrganizationId=?",array($rid,$orgid));
				$data['afft']=$this->db->affected_rows();
				 }
			} 
			 $this->db->close();
			echo json_encode($data);	
		}
		/////////////////////-----------/designations
		
		////////////Attendances
		
		public function getAttendances(){
				 $orgid=isset($_REQUEST['orgid'])?$_REQUEST['orgid']:$_SESSION['orgid'];
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
			     $q1.= " AND `Shift`='$shiftid' ";
			    }
                if($desgid != 0)
				{
			      $q1.=" AND  `Designation` = '$desgid'  ";
			    } 
				if($deptId != 0){
					$q1.=" AND `Department`='$deptId' ";
				}
				 
			    if($date == '')
				$query = $this->db->query("SELECT A.Id,C.TimeIn as ctin,C.TimeOut as ctout, A.EmployeeId, A.AttendanceDate as date, A.AttendanceStatus, A.TimeIn, A.TimeOut, A.ShiftId, A.Overtime,A.EntryImage, A.ExitImage,A.latit_in,A.longi_in,A.longi_out,A.latit_out, A.checkInLoc, A.CheckOutLoc,A.areaId FROM AttendanceMaster A ,ShiftMaster C   WHERE A.OrganizationId=? and C.OrganizationId=? and C.Id = A.ShiftId and  A.AttendanceDate=?  order by A.AttendanceDate Desc",array($orgid,$orgid,$today));
			else{
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
				$query = $this->db->query("SELECT A.Id, A.EmployeeId,C.TimeIn as ctin ,C.TimeOut as ctout, A.AttendanceDate as date , A.AttendanceStatus, A.TimeIn, A.TimeOut, A.ShiftId, A.Overtime,A.EntryImage, A.ExitImage,A.latit_in,A.longi_in,A.longi_out,A.latit_out,A.checkInLoc, A.CheckOutLoc,A.areaId FROM AttendanceMaster A, ShiftMaster C  WHERE A.OrganizationId=? and A.AttendanceStatus!= 2 and C.Id = A.ShiftId and C.OrganizationId = ? and A.AttendanceDate IN ( ".$rangedate." )   order by A.AttendanceDate Desc",array($orgid,$orgid));
				
			}
			$d=array();                      
			$res=array();
			 foreach ($query->result() as $row)
			{
				$flag = false;
				if($emplid !=0 && $emplid == $row->EmployeeId)
				     {
						$qr = $this->db->query("SELECT id FROM EmployeeMaster WHERE OrganizationId='$orgid' $q1 AND Id= $row->EmployeeId AND $row->EmployeeId = $emplid");
						if($qr->num_rows()>0)
						$flag=true;
					 }
			    else if($emplid ==0 )
				     { 
						$qr = $this->db->query("SELECT id FROM EmployeeMaster WHERE OrganizationId='$orgid' $q1 AND Id= $row->EmployeeId ");
						if($qr->num_rows()>0)
						$flag=true;
					 }
				if($flag){
					$data=array();
					$data['name']=ucwords(getEmpName($row->EmployeeId));
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
			   	    //$data['wh']=getShiftBreak($row->ShiftId);
					//$data['lat'] = $row->latit;
					//$data['long'] = $row->longi;A.longi_out,A.latit_out
					$data['wh']='-';

					$attn=$row->AttendanceStatus==1?'<span style="background-color:green;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Present">P</span>':'<span style=" background-color:red;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Absent">A</span>';
					$goings='';$overtime='';$coming='';
					if($row->AttendanceStatus==1){
					$tm=comings($row->ShiftId,$row->TimeIn);
					$coming=strpos($tm,'-')!==0?'<span style="background-color:red;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Late Coming By '.substr($tm,0,5).' Hr">LC</span>':'<span style=" background-color:green;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Early Coming By '.substr(str_replace("-","",$tm),0,5).' Hr">EC</span>';
					
					if($row->TimeOut!='00:00:00')
					{
						$tm=goings($row->ShiftId,$row->TimeOut);
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
														$data['wh']	= $interval1->format("%H:%I");
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
										/*$b = new DateTime(getShiftBreak($row->ShiftId));
										$interval = $a->diff($b);*/
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
					
					
				/*	$data['status']=$row->AttendanceStatus==1?'<div style="width:15px;background-color:green;text-align:center;color:white;">P</div>':'<div style=" width:15px;background-color:red;text-align:center;color:white;">
					Absent</div>';
				    $shiftTI=explode('-',$data['shift']);
					//print_r($shiftTI);
				  // $data['status']=$row->TimeIn>"9:30" ?'<div style="width:15px;background-color:orange;text-align:center;color:white;">L</div>':'<div style=" width:15px;background-color:red;text-align:center;color:white;">
					//A</div>';
					
				 $data['status']=$row->Overtime>"0"?'<div style="width:15px;background-color:purple;text-align:center;color:white;">O</div>':'<div style=" width:15px;background-color:#F95D3C  ;text-align:center;color:white;">
				 U</div>';
					*/
					/*
					<a href="#"><i class="material-icons edit" style="font-size:26px;display:none" data-toggle="modal" title="Edit" data-sid="'.$row->Id.'"
					 data-id="'.$row->Id.'" 
					 data-name="'.ucwords(getEmpName($row->EmployeeId)).'" 
					 data-date="'.$row->date.'"
					 data-ti="'.substr($row->TimeIn,0,5).'"
					 data-to="'.substr($row->TimeOut,0,5).'"
					 data-sts="'.$row->AttendanceStatus.'"
					 data-shiftid="'.$row->ShiftId.'"
					data-target="#addAttE">edit</i></a>
					*/
					
					
					//<i class="delete fa fa-trash"style="font-size:24px; color:purple;" data-toggle="modal" data-target="#delAtt" data-aid="'.$row->Id.'" data-aname="'.getEmpName($row->EmployeeId).'" title="Delete"></i>
					$data['action']='
					 
					  &nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->date.'" target="_self"><i class="track_loc fa fa-map-marker"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>
					';
					$res[]=$data;
					}
		    	   }  	
		    	 	
			$d['data']=$res;  
            $this->db->close();			//$query->result();
			echo json_encode($d); return false;
		}
		//// unsynced data//////////

		  public function getnotsyncdata(){
		 	 $orgid=$_SESSION['orgid'];
				 $deptId = isset($_REQUEST['dept'])?$_REQUEST['dept']:0;
				 $date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
				 $shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:0;
			     $emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:0;
			     $desgid=isset($_REQUEST['desg'])?$_REQUEST['desg']:0;
				 $zname=getTimeZone($orgid);
				date_default_timezone_set ($zname);
			 $today=date('Y-m-d');
			 //$today='2019-02-28';
			   $q1 = '';
		    	if($shiftid!= 0)
				{
			     $q1.= " AND A.ShiftId='$shiftid' ";
			    }
                if($desgid != 0)
				{
			      $q1.=" AND  A.Desg_id = '$desgid'";
			    } 
				if($deptId != 0)
				{
					$q1.=" AND A.Dept_id='$deptId' ";
				}
				if($emplid !=0) 
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
					   // $enddate=date("Y-m-d");
						//$startdate=date("Y-m-d");
				   }
					
			   

				   $query = $this->db->query("select a.Id, a.EmployeeId,DATE(a.OfflineMarkedDate) as atd,a.OrganizationId, DATE(a.SyncDate) AS synd,a.Time,a.image,a.Action,a.Latitude,a.Longitude,a.ReasonForFailure,a.FakeLocationStatus,c.Addon_offline_mode,e.area_assigned  from  OfflineAttendanceNotSynced a, licence_ubiattendance c, EmployeeMaster e where a.OrganizationId=? and  a.EmployeeId = e.Id and c.Addon_offline_mode = 1 AND e.Is_Delete = '0' And DATE(a.SyncDate) IN ( ".$range." ) and e.OrganizationId = ? $q1 GROUP BY Id  ",array($orgid,$orgid)) ;


				  // var_dump($this->db->last_query());
				}

				else{
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
				//echo $range;
			 $rangedate = $range;
			 // var_dump($rangedate)
			 
			
			 if($rangedate=="")
				{
			   $rangedate = 1;
				} 
				$query = $this->db->query("select a.Id,a.EmployeeId,DATE(a.OfflineMarkedDate) as atd,a.image,a.OrganizationId, DATE(a.SyncDate) AS synd,a.Time,a.Action,a.Latitude,a.Longitude,a.ReasonForFailure,a.FakeLocationStatus,c.Addon_offline_mode,e.area_assigned  from  OfflineAttendanceNotSynced a, licence_ubiattendance c, EmployeeMaster e where a.OrganizationId=? and a.EmployeeId = e.Id and c.Addon_offline_mode = 1 And DATE(a.SyncDate) IN ( ".$range." ) and e.OrganizationId = ? $q1 GROUP BY Id  ",array($orgid,$orgid)) ;

					//var_dump($this->db->last_query());
		 }

		 
			
			$d=array();                      
			$res=array();

			
			 foreach ($query->result() as $row)
			  {	
					$data=array();
					$name = ucwords(getEmpName($row->EmployeeId));

					if($name != "")
					{
					//$ff=$this->fetchWeeklyOff($row->ShiftId);
					//print_r($ff);
					$data['name'] = $name;
					}
					$data['syncdate']=date("M d,Y",strtotime($row->synd));
					$data['Attendancedate']=date("M d,Y",strtotime($row->atd));
					$data['time']=substr($row->Time,0,5);
					$data['image']='<i class="pop" data-toggle="modal" data-target="#imagemodal" data-id="'.$row->EmployeeId.'" data-eximage="'.$row->image.'"><img src="'.$row->image.'" style="width:60px!important; "/></i>';
					$data['location']="";
					$data['chiloc'] ="";
					if($row->area_assigned!=0)
					{
						$lat_lang=getName('Geo_Settings','Lat_Long','Id',$row->area_assigned);
						$radius  = getName('Geo_Settings','Radius','Id',$row->area_assigned);
						$arr1 = explode(",",$lat_lang);
						//echo '----------'.count($arr1);
					if(count($arr1)>1)
					{
						$a=floatval($arr1[0]);
						$b=floatval($arr1[1]);
						$d1 = $this->distance($a,$b,$row->Latitude, $row->Longitude, "K");
						// $d2 = $this->distance($a,$b, $row->latit_out, $row->longi_out, "K");
						if($row->FakeLocationStatus==1)
						{
							$data['location'] ='<div title="Location recorded maliciously" class="text-center"  data-background-color="red">Fake Location</div>';
						}
						else	
						if($d1 <= $radius)
						{
							$data['location'] = '<div title="Attendance marked from assigned area" class="text-center"  data-background-color="green">Within the Location</div>';
						}
					else
						{
							$data['location'] = '<div title="Attendance marked from Outside the assigned area" class="text-center"  data-background-color="red"> Outside the Location</div>';
						}
					}
					}
						if($row->FakeLocationStatus==1)
						{
							$data['chiloc'] = '<a style="font-size:11px;" href="http://maps.google.com/?q='.$row->Latitude.','.$row->Longitude.'" target="_blank" title="'.$row->Latitude.' , '.$row->Longitude.'">'.$row->Latitude.' , '.$row->Longitude .$data['location'].'</a>';
						}

						else
						{
							$data['chiloc'] = '<a style="font-size:11px;" href="http://maps.google.com/?q='.$row->Latitude.','.$row->Longitude.'" target="_blank" title="'.$row->Latitude.' , '.$row->Longitude.'">'.$row->Latitude.' , '.$row->Longitude .$data['location'].'</a>';
						}							
						// if($d1 <= $radius)
						// {
							// $data['chiloc'] = '<a style="font-size:11px;" href="http://maps.google.com/?q='.$row->Latitude.','.$row->Longitude.'" target="_blank" title="'.$row->Latitude.' , '.$row->Longitude.'">'.$row->Latitude.' , '.$row->Longitude .$data['location'].'</a>';
						// }
					// else
						// {
							// $data['chiloc'] = '<a style="font-size:11px;" href="http://maps.google.com/?q='.$row->Latitude.','.$row->Longitude.'" target="_blank" title="'.$row->Latitude.' , '.$row->Longitude.'">'.$row->Latitude.' , '.$row->Longitude .$data['location'].'</a>';
						// }
						
					//}
					//}
					// $data['action']="";
					if($row->Action == 0)
					{
						$data['action'] = '<div title="Time In"class="text-center"  data-background-color="green"> Time In </div>';
					}
					else{
						$data['action'] = '<div title="Time In"class="text-center"  data-background-color="red"> Time Out </div>';
					}

					$data['failure_reason']= $row->ReasonForFailure;



					// var_dump($data);


					
$res[]=$data;


					}

					$d['data']=$res;  
			//print_r($d['data']);
            $this->db->close();			//$query->result();
			echo json_encode($d); 
			return false;

				}
			






		////end of unsynced data////

//////get attendances both by pulkit
				

public function getAttendances__both()
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
			 $time = date("H:i:s");
			 //$today='2019-02-28';
			   $q1 = '';
		    	if($shiftid!= 0)
				{
			     $q1.= " AND A.ShiftId='$shiftid' ";
			    }
                if($desgid != 0)
				{
			      $q1.=" AND  A.Desg_id = '$desgid'";
			    } 
				if($deptId != 0)
				{
					$q1.=" AND A.Dept_id='$deptId' ";
				}
				if($emplid !=0) 
				{
					$q1.=" AND A.EmployeeId = '$emplid'";
				}
			    if($date == '')
				{
					$datestatus = isset($_REQUEST['datestatus'])?$_REQUEST['datestatus']:0;
					$range = "";
					if($datestatus == 7)
					{   
				        $enddate=date('Y-m-d') ;
				        $startdate=date('Y-m-d', strtotime('-6 day', strtotime($enddate)));
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
					   // $enddate=date("Y-m-d");
						//$startdate=date("Y-m-d");
				   }
					
					
				$query = $this->db->query("SELECT A.FakeTimeOutTimeStatus, A.FakeTimeInTimeStatus, A.FakeLocationStatusTimeIn,A.FakeLocationStatusTimeOut,A.Id ,A.timeoutdate as timeoutdate, A.EmployeeId,C.TimeIn as ctin ,C.TimeOut as ctout, A.AttendanceDate  , A.AttendanceStatus, A.TimeIn, A.TimeOut, A.ShiftId,C.shifttype, A.Overtime,A.EntryImage,A.device,E.EmployeeCode, A.ExitImage,A.latit_in,A.longi_in,A.longi_out,A.latit_out,A.checkInLoc, A.CheckOutLoc,A.areaId,E.ImageName,E.Gender,A.timeindate,A.timeoutdate, case when (A.timeindate='0000-00-00' || A.timeoutdate='0000-00-00') then TIMEDIFF(A.TimeOut,A.TimeIn) else TIMEDIFF(CONCAT(A.timeoutdate,'   ',A.TimeOut) ,  CONCAT(A.timeindate,'  ',A.TimeIn))end as loggedhours FROM AttendanceMaster A, ShiftMaster C ,EmployeeMaster E WHERE A.OrganizationId=?   And C.Id = A.ShiftId and C.OrganizationId = ? $q1 And A.AttendanceDate IN ( ".$range." ) and A.EmployeeId=E.Id  ",array($orgid,$orgid));
				// var_dump($this->db->last_query());
				}
			else{
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
				//echo $range;
			 $rangedate = $range;
			 // var_dump($rangedate)
			 
			
			 if($rangedate=="")
				{
			       $rangedate = 1;
				} 

				//between '$strt' and '$end'
			 // echo  $rangedate;
			   //, TIMEDIFF(CONCAT(A.timeoutdate,'   ',A.TimeOut) , CONCAT(A.AttendanceDate,'  ',A.TimeIn)) as Officehours 
				$query = $this->db->query("SELECT A.FakeTimeOutTimeStatus,A.FakeTimeInTimeStatus, A.FakeLocationStatusTimeIn,A.FakeLocationStatusTimeOut,A.Id,A.EmployeeId,C.TimeIn as ctin ,C.TimeOut as ctout, A.AttendanceDate ,A.timeoutdate as timeoutdate , A.AttendanceStatus, A.TimeIn, A.TimeOut, A.ShiftId, A.Overtime,A.EntryImage,A.device,E.EmployeeCode,C.shifttype, A.ExitImage,A.latit_in,A.longi_in,A.longi_out,A.latit_out,A.checkInLoc, A.CheckOutLoc,A.areaId,E.ImageName,E.Gender,A.timeindate,A.timeoutdate, case when (A.timeindate='0000-00-00' || A.timeoutdate='0000-00-00') then TIMEDIFF(A.TimeOut,A.TimeIn) else TIMEDIFF(CONCAT(A.timeoutdate,'   ',A.TimeOut) ,  CONCAT(A.timeindate,'  ',A.TimeIn))end as loggedhours  FROM AttendanceMaster A, ShiftMaster C,EmployeeMaster E  WHERE A.OrganizationId=?   And C.Id = A.ShiftId and C.OrganizationId = ? $q1 And A.AttendanceDate IN ( ".$rangedate." )  and A.EmployeeId=E.Id  ",array($orgid ,   $orgid));
				// var_dump($this->db->last_query());
			}


			
			$d=array();                      
			$res=array();
			$currentdatestatus = 0;


			 foreach ($query->result() as $row)
			  {	
					$data=array();
					$name = ucwords(getEmpName($row->EmployeeId));
					if($row->AttendanceDate==$today)
						$currentdatestatus =1;
					if($name != "")
					{
					$data['name'] = $name;	
					if($row->ImageName)
					{
					$data['proimage'] ='<i class="pop1" data-toggle="modal" data-target="#imagemodal1" data-id="'.$row->EmployeeId.'" data-enimage="'.$row->ImageName.'"><img src="'.IMGURL3."uploads/$orgid/".$row->ImageName.'" style="width:60px!important;" /> </i>';
					}
					else
					{
						if($row->Gender==1)
						{
						$data['proimage'] ='<img src="'.IMGURL3."avatars/male.png".'" style="width:60px!important;" />';
						}
						else
						{
						$data['proimage'] ='<img src="'.IMGURL3."avatars/female.png".'" style="width:60px!important;" />';	
						}
					}
					$data['code']=$row->EmployeeCode;
					$data['date']=date("M d,Y",strtotime($row->AttendanceDate));
					
					$data['ti']=substr($row->TimeIn,0,5);
					if($row->FakeTimeInTimeStatus == 1)
					{
						$data['fti']='<div title="TimeIn recorded maliciously" class="text-center"  data-background-color="red" style="font-size:11px;">Fake</div>';
					}
					else
					{
						$data['fti']="";
					}

					$data['tif']="";
					if($row->FakeTimeInTimeStatus == 0){
						$data['tif'] =  substr($row->TimeIn,0,5);
					}
					else{
						$data['tif']=substr($row->TimeIn,0,5).' ' .$data['fti'];
					}

					$data['to']=substr($row->TimeOut,0,5);

					if($row->FakeTimeOutTimeStatus == 1){

						$data['fto']='<div title="TimeOut recorded maliciously" class="text-center"  data-background-color="red" style="font-size:11px;">Fake</div>';

					}
					else{
						$data['fto']="";
					}

					$data['tof']="";
					if($row->FakeTimeOutTimeStatus == 0){
						$data['tof'] =  substr($row->TimeOut,0,5);
					}
					else{
						$data['tof']=substr($row->TimeOut,0,5).' ' .$data['fto'];
					}
					$data['timeindate']=$row->timeindate;
					$data['timeoutdate']=$row->timeoutdate;
					$data['shift']='<span title="Shift Timing: '.getShiftTimes($row->ShiftId).', Break Hours:'.getShiftBreaks($row->ShiftId).'">'.getShift($row->ShiftId).'</span>';
					
					$data['ot']=$row->Overtime;
					$data['entryimg']=/*'<a href="#" class="pop"><img src="'.$row->EntryImage.'"  style="width:60px!important; "/></a>';*/
					
					'<i class="pop" data-toggle="modal" data-target="#imagemodal" data-id="'.$row->EmployeeId.'" data-enimage="'.$row->EntryImage.'"><img src="'.$row->EntryImage.'"  style="width:60px!important; "  /></i>';
					
					$data['exitimg']=/*'<img src="'.$row->ExitImage.'"  style="width:60px!important; "/>';*/
					'<i class="pop" data-toggle="modal" data-target="#imagemodal" data-id="'.$row->EmployeeId.'" data-eximage="'.$row->ExitImage.'"><img src="'.$row->ExitImage.'" style="width:60px!important; "/></i>';
					
					$data['positionlin']="";
					$data['positionout']="";
					
					if($row->areaId != 0)
					{
						$lat_lang=getName('Geo_Settings','Lat_Long','Id',$row->areaId);
						$radius  = getName('Geo_Settings','Radius','Id',$row->areaId);
						$arr1 = explode(",",$lat_lang);
						//echo '----------'.count($arr1);
					if(count($arr1)>1)
					{
						$a=floatval($arr1[0]);
						$b=floatval($arr1[1]);
						$d1 = $this->distance($a,$b, $row->latit_in, $row->longi_in, "K");
						$d2 = $this->distance($a,$b, $row->latit_out, $row->longi_out, "K");
						if($row->FakeLocationStatusTimeIn==1){
							$data['positionlin'] = '<div title="Location recorded maliciously"   style="width:100px;" data-background-color="red"><i>Fake Location</i></div>';
						}
					else	
						if($d1 <= $radius)
						{
							$data['positionlin'] = '<div title="Attendance marked from the assigned area"  style="width:100px;" data-background-color="green"><i>Within the Location</i></div>';
						}
						else
						{
							$data['positionlin'] ='<div title="Attendance marked from the out side of assigned area" style="width:100px;"  data-background-color="red"><i>Outside the Location</i></div>';
						}
						if($row->FakeLocationStatusTimeIn==1){
							$data['positionout'] = '<div title="Location recorded maliciously"   style="width:100px;" data-background-color="red"><i>Fake Location</i></div>';
						}
						else
						if($d2 <= $radius)
						{
							$data['positionout'] = '<div title="Attendance marked from the assigned area"  style="width:100px;" data-background-color="green"><i>Within the Location</i></div>';
						}
						else
						{
							$data['positionout'] ='<div title="Attendance marked from the out side of assigned area" style="width:100px;" data-background-color="red"><i>Outside the Location</i></div>';
						}
					}
					
				}
					if($row->latit_in =='0.0')
						$data['chiloc']=$row->checkInLoc != ''?'<span title="'.$row->checkInLoc.'">'.$row->checkInLoc.'</span>':'-';
					else
						if($row->checkInLoc != "" && $row->checkInLoc =="Location not fetched.")
					$data['chiloc']='<span class="loc" data-toggle="modal" data-target="#locationmodal" data-latit="'.$row->latit_in.','.$row->longi_in.'" data-latitin="'.$row->latit_in.'" data-longiin="'.$row->longi_in.'" data-checkinloc="'.encode5t($row->checkInLoc).'"><a style="font-size:11px;" title="'.$row->checkInLoc.'">'.$row->checkInLoc .$data['positionlin'].'</a></span>';
					
					
						else
						if($row->checkInLoc =="" || $row->checkInLoc =="Location not fetched.")
						{
						$data['chiloc']='<span class="loc" data-toggle="modal" data-target="#locationmodal" data-latit="'.$row->latit_in.','.$row->longi_in.'" data-latitin="'.$row->latit_in.'" data-longiin="'.$row->longi_in.'" ><a style="font-size:11px;"  title="'.$row->latit_in.' , '.$row->longi_in.'">'.$row->latit_in.' , '.$row->longi_in .$data['positionlin'].'</a></span>';
						}
						
					    else
						 $data['chiloc']='<span class="loc" data-toggle="modal" data-target="#locationmodal" data-latit="'.$row->latit_in.','.$row->longi_in.'" data-latitin="'.$row->latit_in.'" data-longiin="'.$row->longi_in.'" data-checkinloc="'.encode5t($row->checkInLoc).'"><a style="font-size:11px;"  title="'.$row->checkInLoc.'">'.$row->checkInLoc.$row->longi_in.$data['positionlin'].'</a></span>';
						 
					if($row->longi_out=='0.0')
						$data['choloc']=$row->CheckOutLoc!=''?'<span title="'.$row->CheckOutLoc.'">'.$row->CheckOutLoc.'</span>':'-';
					
					else
						if($row->CheckOutLoc == "" || $row->CheckOutLoc =="Location not fetched.")
						$data['choloc']='<span class="loc" data-toggle="modal" data-target="#locationmodal" data-latit="'.$row->latit_out.','.$row->longi_out.'" data-latitin="'.$row->latit_out.'" data-longiin="'.$row->longi_out.'" >
					<a style="font-size:11px;" title="'.$row->latit_out.' , '.$row->longi_out.'">'.$row->latit_out.' , '.$row->longi_out .$data['positionout'].'</a>';
					else
						$data['choloc']='<span class="loc" data-toggle="modal" data-target="#locationmodal" data-latit="'.$row->latit_out.','.$row->longi_out.'" data-latitin="'.$row->latit_out.'" data-longiin="'.$row->longi_out.'" data-checkinloc="'.encode5t($row->CheckOutLoc).'">
						<a style="font-size:11px;"  title="'.$row->CheckOutLoc.'">'.$row->CheckOutLoc .$data['positionout'].'</a></span>';
						
					$data['wh']='-';
					if($row->AttendanceStatus==4)
					{
					$attn='<span style="background-color:green;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Halfday">Hd</span>';	
					}
				

					else 
					{
					$attn=$row->AttendanceStatus !=2 ?'<span style="background-color:green;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Present">P</span>':'<span style=" background-color:red;text-align:center;color:white;padding-left:6px;
					padding-right:6px;" title="Absent">A</span>';
					}
					
					$goings='';$overtime='';$coming='';
					
					if($row->AttendanceStatus != 2)
					{	
					$tm = comings($row->ShiftId,$row->TimeIn,$row->timeindate,$row->AttendanceDate);
					//echo $tm;
					if(substr($tm,0,5) != '00:00')
					$coming=strpos($tm,'-')!==0?'<span style="background-color:red;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Late Coming By '.substr($tm,0,5).' Hr">LC</span>':'<span style=" background-color:green;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Early Coming By '.substr(str_replace("-","",$tm),0,5).' Hr">EC</span>';
					if($row->TimeOut!='00:00:00')
					{
						//$data['wh'] = substr($row->Officehours,0,5);
						$tm = goings($row->ShiftId,$row->TimeOut,$row->AttendanceStatus,$row->timeoutdate,$row->AttendanceDate);
						if(substr($tm,0,5) != '00:00')
						$goings=strpos($tm,'-') !== 0 ?'<span style=" background-color:green;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Late Leaving By '.substr($tm,0,5).' Hr">LL</span>':'<span style="background-color:red;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Early Leaving By '.substr(str_replace("-","",$tm),0,5).' Hr">EL</span>';
						
						//calculate work hours
					
					if(strtotime($row->ctin) < strtotime($row->ctout))
						{
						  if(strtotime($row->TimeIn) < strtotime($row->TimeOut))
						  {
							 
							// $a = new DateTime($row->TimeIn);
							// $b = new DateTime($row->TimeOut);
							//  //echo  $a;
							// // echo  $b;
							// $interval1 = $a->diff($b);
							// $a = new DateTime($interval1->format("%H:%I"));
							$data['wh']= substr($row->loggedhours,0,5);
							// print_r($data['wh']);
							// echo $name;
							// echo "<br/>";
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
							if(strtotime($row->TimeIn) <= strtotime($row->TimeOut))
							{
								// $interval1 = $a->diff($b);
								// $a = new DateTime($interval1->format("%H:%I"));
								// $data['wh']=$interval1->format("%H:%I");	
								$data['wh']= substr($row->loggedhours,0,5);
							}
							else
							{
								$time = "24:00:00";
								$secs = strtotime($row->TimeIn)-strtotime($row->TimeOut);
								$data['wh'] = date("H:i",strtotime($time)-$secs);
							}
						}
				     
				    }
						if($row->AttendanceStatus==4)
						{
							$overtime='';
						}
						elseif($row->AttendanceStatus==1 && $row->TimeOut== '00:00:00'){
							$overtime='';
						}
						else
						{
							if($row->Overtime != '00:00:00' )
							{
								$overtime=strpos($row->Overtime,'-')!==0?'<span style="background-color:green;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Over Time By '.substr($row->Overtime,0,5).' Hr">OT</span>':'<span style=" background-color:red;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Under Time By '.substr(str_replace("-","",$row->Overtime),0,5).' Hr">UT</span>';
							}
						}
						
						
					}
					$data['device']=$row->device;
					$data['status']=$attn.' '.$coming.' '.$goings.' '.$overtime;
		            $data['timeoff'] = $this->calculatetimeoff($row->EmployeeId, $row->AttendanceDate);
					
				if($data['timeoff'] != "00:00" AND $data['wh'] != "-" )
					{
						 $a = new DateTime($data['timeoff']);
						 $b = new DateTime($data['wh']);
						 $interval = $a->diff($b);
						 $a = new DateTime($interval->format("%H:%I"));
						 $data['wh'] = $interval->format("%H:%I");
					}


						$permis = getAddonPermission($_SESSION['orgid'],'Addon_Delete') ;
						$permis1 = getAddonPermission($_SESSION['orgid'],'Addon_Edit') ;
						if($row->AttendanceDate > date('Y-m-d', strtotime('-3 day', strtotime(date('Y-m-d'))))&& date('Y-m-d')!=$row->AttendanceDate && $permis == 0 && $permis1 == 1 && $row->AttendanceStatus != 2)
						{
						$shiftype=getShiftType($row->ShiftId);

         //                       $permis = getAddonPermission($_SESSION['orgid'],'Addon_Delete') ;
							  // if($permis == 1)
							  // 	$data['action'] = ""
							  
							  // else{
								
							   
						$data['action']='
						&nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>
						 
						 
						  <a href="#"><i class="fa fa-pencil edit" style="font-size:20px;color:purple;" data-toggle="modal" title="Edit" data-target="#addAttE"	
						 data-id="'.$row->Id.'"
						 data-aname="'.getEmpName($row->EmployeeId).'"
						 data-timein="'.date("H:i",strtotime($row->TimeIn)).'"
						 data-timeout="'.date("H:i",strtotime($row->TimeOut)).'";
						 data-tidate="'.$row->timeindate.'";
						 data-todate="'.$row->timeoutdate.'";
						  data-shifttype="'.$shiftype.'";
						 ></i></a>
						 ';
						// }
						}
					elseif($row->AttendanceDate > date('Y-m-d', strtotime('-3 day', strtotime(date('Y-m-d'))))&& date('Y-m-d')!=$row->AttendanceDate && $permis1 == 0 && $permis == 1 && $row->AttendanceStatus != 2)
						{
						$shiftype=getShiftType($row->ShiftId);							   
						$data['action']='
						 &nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>

						 ';
						// }
						}

					elseif($row->AttendanceDate > date('Y-m-d', strtotime('-3 day', strtotime(date('Y-m-d'))))&& date('Y-m-d')!=$row->AttendanceDate && $permis1 == 1 && $permis == 1 && $row->AttendanceStatus != 2)
						{
						$shiftype=getShiftType($row->ShiftId);
	   
						$data['action']='
	                           &nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>

						
						 <a href="#"><i class="fa fa-pencil edit" style="font-size:20px;color:purple;" data-toggle="modal" title="Edit" data-target="#addAttE"	
						 data-id="'.$row->Id.'"
						 data-aname="'.getEmpName($row->EmployeeId).'"
						 data-timein="'.date("H:i",strtotime($row->TimeIn)).'"
						 data-timeout="'.date("H:i",strtotime($row->TimeOut)).'";
						 data-tidate="'.$row->timeindate.'";
						 data-todate="'.$row->timeoutdate.'";
						  data-shifttype="'.$shiftype.'";
						 ></i></a>';
						// }
					}
					// condition for editing absent employee
					elseif($row->AttendanceStatus == 2 && $row->AttendanceDate > date('Y-m-d', strtotime('-3 day', strtotime(date('Y-m-d'))))&& date('Y-m-d')!=$row->AttendanceDate && $permis1 == 0 ){

						$data['action']= '';
							}

							elseif($row->AttendanceStatus == 2 && $row->AttendanceDate > date('Y-m-d', strtotime('-3 day', strtotime(date('Y-m-d'))))&& date('Y-m-d')!=$row->AttendanceDate && $permis1 == 1){
								$shiftype=getShiftType($row->ShiftId);

									$data['action']='<a href="#"><i class="fa fa-pencil edit" style="font-size:20px;color:purple;" data-toggle="modal" title="Edit" data-target="#addAttE"	
						 data-id="'.$row->Id.'"
						 data-aname="'.getEmpName($row->EmployeeId).'"
						 data-timein="'.date("H:i",strtotime($row->TimeIn)).'"
						 data-timeout="'.date("H:i",strtotime($row->TimeOut)).'";
						 data-tidate="'.$row->timeindate.'";
						 data-todate="'.$row->timeoutdate.'";
						  data-shifttype="'.$shiftype.'";
						 ></i></a>';

							}

					elseif($row->AttendanceDate > date('Y-m-d', strtotime('-3 day', strtotime(date('Y-m-d'))))&& date('Y-m-d')!=$row->AttendanceDate && $permis1 == 0 && $permis == 0 && $row->AttendanceStatus != 2)
						{
						$data['action']='
					 &nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>';

					}

					else if(date('Y-m-d')==$row->AttendanceDate && $permis == 0 && $permis1 == 1 && $row->AttendanceStatus != 2){
						$shiftype=getShiftType($row->ShiftId);
						if($row->TimeOut=='00:00:00' && $row->timeoutdate ='0000-00-00' ){
					$data['action']='&nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>
					<a href="#"><i class="fa fa-pencil edit" style="font-size:20px;color:purple;" data-toggle="modal" title="Edit" data-target="#addAttc"
						 
						 	
						 data-id="'.$row->Id.'"
						 data-aname="'.getEmpName($row->EmployeeId).'"
						 data-timein="'.date("H:i",strtotime($row->TimeIn)).'"
						 
						 data-tidate="'.$row->timeindate.'";
						
						  data-shifttype="'.$shiftype.'";
						 ></i></a>
					';
					}

					else{

						$data['action']='&nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>


							<a href="#"><i class="fa fa-pencil edit" style="font-size:20px;color:purple;" data-toggle="modal" title="Edit" data-target="#addAttE"
						 
						 	
						 data-id="'.$row->Id.'"
						 data-aname="'.getEmpName($row->EmployeeId).'"
						 data-timein="'.date("H:i",strtotime($row->TimeIn)).'"
						 data-timeout="'.date("H:i",strtotime($row->TimeOut)).'";
						 data-tidate="'.$row->timeindate.'";
						 data-todate="'.$row->timeoutdate.'";
						  data-shifttype="'.$shiftype.'";
						 ></i></a>


						';

					}

				}

				else if(date('Y-m-d')==$row->AttendanceDate && $permis == 1 && $permis1 == 0 ){

					$data['action']='&nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>

					<a href="#"><i class="delete fa fa-trash"style="font-size:24px; color:purple;" data-toggle="modal" data-target="#delAtt" data-aid="'.$row->Id.'" data-aname="'.getEmpName($row->EmployeeId).'" data-attdate="'.$row->AttendanceDate.'" title="Delete"></i></a>';




				}
				else if(date('Y-m-d')==$row->AttendanceDate && $permis == 1 && $permis1 == 1){
					$shiftype=getShiftType($row->ShiftId);
					if($row->TimeOut=='00:00:00' && $row->timeoutdate ='0000-00-00' ){
						$data['action']='&nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>
					<a href="#"><i class="delete fa fa-trash"style="font-size:24px; color:purple;" data-toggle="modal" data-target="#delAtt" data-aid="'.$row->Id.'" data-aname="'.getEmpName($row->EmployeeId).'" data-attdate="'.$row->AttendanceDate.'" title="Delete"></i></a>

					<a href="#"><i class="fa fa-pencil edit" style="font-size:20px;color:purple;" data-toggle="modal" title="Edit" data-target="#addAttc"
						 
						 	
						 data-id="'.$row->Id.'"
						 data-aname="'.getEmpName($row->EmployeeId).'"
						 data-timein="'.date("H:i",strtotime($row->TimeIn)).'"
						 
						 data-tidate="'.$row->timeindate.'";
						
						  data-shifttype="'.$shiftype.'";
						 ></i></a>';
					}
						else{
					
					$data['action']='&nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>
					<a href="#"><i class="delete fa fa-trash"style="font-size:24px; color:purple;" data-toggle="modal" data-target="#delAtt" data-aid="'.$row->Id.'" data-aname="'.getEmpName($row->EmployeeId).'" data-attdate="'.$row->AttendanceDate.'" title="Delete"></i></a>

					<a href="#"><i class="fa fa-pencil edit" style="font-size:20px;color:purple;" data-toggle="modal" title="Edit" data-target="#addAttE"
						 
						 	

						 data-id="'.$row->Id.'"
						 data-aname="'.getEmpName($row->EmployeeId).'"
						 data-timein="'.date("H:i",strtotime($row->TimeIn)).'"
						 data-timeout="'.date("H:i",strtotime($row->TimeOut)).'";
						 data-tidate="'.$row->timeindate.'";
						 data-todate="'.$row->timeoutdate.'";
						  data-shifttype="'.$shiftype.'";
						 ></i></a>';
			      	}

				}

					else
					{
						$data['action']='
					  &nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>';	
					}
					//}
					$res[]=$data;
			    }
		    }

		    if($currentdatestatus==1) 
		    {
		    	
		    	$query = $this->db->query("Select '-' as device, E.Id as EmployeeId,E.ImageName,E.Gender,E.EmployeeCode,E.Shift as ShiftId ,E.area_assigned as area,E.Designation as desg,E.Department as dept,'".$today."' as AttendanceDate,S.TimeIn as ctin,S.shifttype FROM EmployeeMaster E,ShiftMaster S Where  E.Id NOT IN (select A.EmployeeId From AttendanceMaster A where A.AttendanceDate= '".$today."'  AND  A.OrganizationId= ".$orgid." AND AttendanceStatus  IN (1,8,4) ) AND E.OrganizationId = ".$orgid ." AND E.Shift = S.Id AND S.TimeIn < '$time'  AND E.archive = 1 AND E.Is_Delete = 0 group By EmployeeId");
		    	foreach ($query->result() as $row ) {
		    		$data = array();
		    		$data['name']  = ucwords(getEmpName($row->EmployeeId));
		    		if($data['name']=="")
		    			continue;
					if($row->ImageName)
					{
					$data['proimage'] ='<i class="pop1" data-toggle="modal" data-target="#imagemodal1" data-id="'.$row->EmployeeId.'" data-enimage="'.$row->ImageName.'"><img src="'.IMGURL3."uploads/$orgid/".$row->ImageName.'" style="width:60px!important;" /> </i>';
					}
					else
					{
						if($row->Gender==1)
						{
						$data['proimage'] ='<img src="'.IMGURL3."avatars/male.png".'" style="width:60px!important;" />';
						}
						else
						{
						$data['proimage'] ='<img src="'.IMGURL3."avatars/female.png".'" style="width:60px!important;" />';	
						}
					}
					$data['code']= "dummy";
					$data['date']= date("M d,Y",strtotime($today));
					$data['ti']= "-";
					$data['fti']= "-";
					$data['to']= "-";
					$data['fto']= "-";
					$data['tof']= "-";
					$data['timeindate']= "-";
					$data['timeoutdate']= "-";
					$data['ot']= "-";
					$data['entryimg']= "-";
					$data['exitimg']= "-";
					$data['positionlin']= "-";
					$data['positionout']= "-";
					$data['chiloc']= "-";
					$data['choloc']= "-";
					$data['wh']= "-";
					$data['timeoff']= "-";
					
					$attn = '';
					if($row->ctin < $time && $row->AttendanceDate==$today){
						$attn = '<span style=" background-color:red;text-align:center;color:white;padding-left:6px;
					padding-right:6px;" title="Absent">A</span>';

					}
					$data['status']= $attn;
					$data['device']= "-";
					$data['action']= '<a href="#"><i class="fa fa-pencil edit" style="font-size:20px;color:purple;" data-toggle="modal" title="Edit" data-target="#addAttsk" data-id="'.$row->EmployeeId.'"
						data-sid="'.$row->ShiftId.'"
						data-areaid="'.$row->area.'"
						data-desgid="'.$row->desg.'"
						data-deptid="'.$row->dept.'"
						data-shifttype="'.$row->shifttype.'"
						data-aname="'.getEmpName($row->EmployeeId).'"

						></i></a>';
					
					
					$data['shift']= '<span title="Shift Timing: '.getShiftTimes($row->ShiftId).', Break Hours:'.getShiftBreaks($row->ShiftId).'">'.getShift($row->ShiftId).'</span>';
					$data['tif']= "-";
					$res[]=$data;
		    	}
		    	
		    }	
		    	 	
			$d['data']=$res;  
			//print_r($d['data']);
            $this->db->close();			//$query->result();
			echo json_encode($d); 
			return false;
		}

		public function Attask(){

			// var_dump($_REQUEST);
			// exit();
			$orgid=$_SESSION['orgid'];
			$tin=isset($_REQUEST['tin'])?$_REQUEST['tin']:'';
			$aname=isset($_REQUEST['aname'])?$_REQUEST['aname']:'';
			// var_dump($aname);
			$tout=isset($_REQUEST['tout'])?$_REQUEST['tout']:'';
			$emp_id=isset($_REQUEST['id'])?$_REQUEST['id']:'';
			$datein=isset($_REQUEST['datein'])?$_REQUEST['datein']:0;
			$dateatt=date("M d,Y",strtotime($datein));
			// var_dump($dateatt);
			$dateout=isset($_REQUEST['dateout'])?$_REQUEST['dateout']:0;
			$sid=isset($_REQUEST['sid'])?$_REQUEST['sid']:0;
			$desgid=isset($_REQUEST['desgid'])?$_REQUEST['desgid']:0;
			$areaid=isset($_REQUEST['areaid'])?$_REQUEST['areaid']:0;
			$deptid=isset($_REQUEST['deptid'])?$_REQUEST['deptid']:0;
			$ts=isset($_REQUEST['tin'])?date("H:i", strtotime($_REQUEST['tin'])):'';
			$ts1=isset($_REQUEST['tout'])?date("H:i", strtotime($_REQUEST['tout'])):'';
			$shifttype=isset($_REQUEST['shifttype'])?$_REQUEST['shifttype']:0;


			// var_dump($shifttype);
			// exit();
			$status=1;
			$today2 = Date('Y-m-d');


			
			$today1=Date('Y-m-d h:i:s');
			$dti = $datein." ".$ts;
			$dto = $dateout." ".$ts1;

			// var_dump($today1);
			// var_dump($dti);
			// var_dump($dto);

			$sql= $this->db->query("SELECT timediff(TIMEDIFF('$dto','$dti'),timediff(TimeOut,TimeIn))as diff FROM  ShiftMaster  WHERE   id=? ",array($sid));

			// var_dump($this->db->last_query());
			// 	die;
			// var_dump($_REQUEST);

				if($sk=$sql->row()){
				$diff = $sk->diff;				
				$query = $this->db->query("INSERT INTO AttendanceMaster(EmployeeId,AttendanceStatus,AttendanceDate,TimeIn,TimeOut,ShiftId,Dept_id,Desg_id,areaId,OrganizationId,CreatedDate,LastModifiedDate,Overtime,timeindate,timeoutdate)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($emp_id,$status,$today2,$ts,$ts1,$sid,$deptid,$desgid,$areaid,$orgid,$today1,$today1,$diff,$datein,$dateout));


				// $name = ucwords(getEmpName($row->EmployeeId));

				// var_dump($this->db->last_query());
				// die;
			$res = $this->db->affected_rows();
			if($res){

		   $date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $id =$_SESSION['id'];
           $module = "Attendance";
           $actionperformed = " Attendance has been <b>Updated</b> for <b>".$aname."</b> <b>Status Changed</b> From <b>Absent</b> To <b>Present</b> of<b> ".$dateatt."</b> Time In <b>".$ts."</b> Time Out <b>".$ts1."</b>";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id)); 
       }
       else{

       }
       
					// var_dump($res);
					// die;
					if($res > 0){

						echo 1;
					}
					else
					{
						echo  0;
					}


					$this->db->close();
			



			}

			

			

		}

		





		//// get present employee report by sohan
     public function getAttendances__new()
	 {
		         $orgid=$_SESSION['orgid'];
				 $deptId = isset($_REQUEST['dept'])?$_REQUEST['dept']:0;
				 $date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
				 $shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:0;
			     $emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:0;
			     $county=isset($_REQUEST['county'])?$_REQUEST['county']:0;
			     $desgid=isset($_REQUEST['desg'])?$_REQUEST['desg']:0;
				 $zname=getTimeZone($orgid);
				date_default_timezone_set ($zname);
			 $today=date('Y-m-d');
			 //$today='2019-02-28';
			   $q1 = '';
		    	if($shiftid!= 0)
				{
			     $q1.= " AND A.ShiftId='$shiftid' ";
			    }
                if($desgid != 0)
				{
			      $q1.=" AND  A.Desg_id = '$desgid'";
			    } 
				if($deptId != 0)
				{
					$q1.=" AND A.Dept_id='$deptId' ";
				}
				if($emplid !=0) 
				{
					$q1.=" AND A.EmployeeId = '$emplid'";
				}
				if($county !=0) 
				{
					$q1.=" AND E.CurrentCountry = '$county'";
				}
			    if($date == '')
				{
					$datestatus = isset($_REQUEST['datestatus'])?$_REQUEST['datestatus']:0;
					$range = "";
					if($datestatus == 7)
					{   
				        $enddate=date('Y-m-d') ;
				     $startdate=date('Y-m-d', strtotime('-6 day', strtotime($enddate)));
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
					   // $enddate=date("Y-m-d");
						//$startdate=date("Y-m-d");
				   }
					
					
				$query = $this->db->query("SELECT A.FakeTimeOutTimeStatus, A.FakeTimeInTimeStatus, A.FakeLocationStatusTimeIn,A.FakeLocationStatusTimeOut,A.Id ,A.timeoutdate as timeoutdate, A.EmployeeId,C.TimeIn as ctin ,C.TimeOut as ctout, A.AttendanceDate  , A.AttendanceStatus, A.TimeIn, A.TimeOut, A.ShiftId,C.shifttype, A.Overtime,A.EntryImage,A.device,E.CurrentCountry,E.EmployeeCode, A.ExitImage,A.latit_in,A.longi_in,A.longi_out,A.latit_out,A.checkInLoc, A.CheckOutLoc,A.areaId,E.ImageName,E.Gender,A.timeindate,A.timeoutdate, case when (A.timeindate='0000-00-00' || A.timeoutdate='0000-00-00') then TIMEDIFF(A.TimeOut,A.TimeIn) else TIMEDIFF(CONCAT(A.timeoutdate,'   ',A.TimeOut) ,  CONCAT(A.timeindate,'  ',A.TimeIn))end as loggedhours FROM AttendanceMaster A, ShiftMaster C ,EmployeeMaster E WHERE A.OrganizationId=?  And A.TimeIn != '0000:00:00' And C.Id = A.ShiftId and C.OrganizationId = ? $q1 And A.AttendanceDate IN ( ".$range." ) and A.EmployeeId=E.Id  ",array($orgid,$orgid));
				// var_dump($this->db->last_query());
				}
			else{
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
				//echo $range;
			 $rangedate = $range;
			 // var_dump($rangedate)
			 
			
			 if($rangedate=="")
				{
			   $rangedate = 1;
				} 

				//between '$strt' and '$end'
			 // echo  $rangedate;
			   //, TIMEDIFF(CONCAT(A.timeoutdate,'   ',A.TimeOut) , CONCAT(A.AttendanceDate,'  ',A.TimeIn)) as Officehours 
				$query = $this->db->query("SELECT A.FakeTimeOutTimeStatus,A.FakeTimeInTimeStatus, A.FakeLocationStatusTimeIn,A.FakeLocationStatusTimeOut,A.Id,A.EmployeeId,C.TimeIn as ctin ,C.TimeOut as ctout, A.AttendanceDate ,A.timeoutdate as timeoutdate , A.AttendanceStatus, A.TimeIn, A.TimeOut, A.ShiftId, A.Overtime,A.EntryImage,A.device,E.EmployeeCode,C.shifttype, A.ExitImage,A.latit_in,A.longi_in,A.longi_out,A.latit_out,A.checkInLoc, A.CheckOutLoc,A.areaId,E.CurrentCountry,E.ImageName,E.Gender,A.timeindate,A.timeoutdate, case when (A.timeindate='0000-00-00' || A.timeoutdate='0000-00-00') then TIMEDIFF(A.TimeOut,A.TimeIn) else TIMEDIFF(CONCAT(A.timeoutdate,'   ',A.TimeOut) ,  CONCAT(A.timeindate,'  ',A.TimeIn))end as loggedhours  FROM AttendanceMaster A, ShiftMaster C,EmployeeMaster E  WHERE A.OrganizationId=?  And A.TimeIn != '0000:00:00' And C.Id = A.ShiftId and C.OrganizationId = ? $q1 And A.AttendanceDate IN ( ".$rangedate." )  and A.EmployeeId=E.Id  ",array($orgid,$orgid));
			}


			
			$d=array();                      
			$res=array();
			 foreach ($query->result() as $row)
			  {	
					$data=array();
					$name = ucwords(getEmpName($row->EmployeeId));
					if($name != "")
					{
					$data['name'] = $name;	
					if($row->ImageName)
					{
					$data['proimage'] ='<i class="pop1" data-toggle="modal" data-target="#imagemodal1" data-id="'.$row->EmployeeId.'" data-enimage="'.$row->ImageName.'"><img src="'.IMGURL3."uploads/$orgid/".$row->ImageName.'" style="width:60px!important;" /> </i>';
					}
					else
					{
						if($row->Gender==1)
						{
						$data['proimage'] ='<img src="'.IMGURL3."avatars/male.png".'" style="width:60px!important;" />';
						}
						else
						{
						$data['proimage'] ='<img src="'.IMGURL3."avatars/female.png".'" style="width:60px!important;" />';	
						}
					}
					$data['code']=$row->EmployeeCode;
					$data['date']=date("M d,Y",strtotime($row->AttendanceDate));
					
					$data['ti']=substr($row->TimeIn,0,5);
					if($row->FakeTimeInTimeStatus == 1)
					{
						$data['fti']='<div title="TimeIn recorded maliciously" class="text-center"  data-background-color="red" style="font-size:11px;">Fake</div>';
					}
					else
					{
						$data['fti']="";
					}

					$data['tif']="";
					if($row->FakeTimeInTimeStatus == 0){
						$data['tif'] =  substr($row->TimeIn,0,5);
					}
					else{
						$data['tif']=substr($row->TimeIn,0,5).' ' .$data['fti'];
					}

					$data['to']=substr($row->TimeOut,0,5);

					if($row->FakeTimeOutTimeStatus == 1){

						$data['fto']='<div title="TimeOut recorded maliciously" class="text-center"  data-background-color="red" style="font-size:11px;">Fake</div>';

					}
					else{
						$data['fto']="";
					}

					$data['tof']="";
					if($row->FakeTimeOutTimeStatus == 0){
						$data['tof'] =  substr($row->TimeOut,0,5);
					}
					else{
						$data['tof']=substr($row->TimeOut,0,5).' ' .$data['fto'];
					}
					$data['timeindate']=$row->timeindate;
					$data['timeoutdate']=$row->timeoutdate;
					$data['shift']='<span title="Shift Timing: '.getShiftTimes($row->ShiftId).', Break Hours:'.getShiftBreaks($row->ShiftId).'">'.getShift($row->ShiftId).'</span>';
					
					$data['ot']=$row->Overtime;
					$data['entryimg']=/*'<a href="#" class="pop"><img src="'.$row->EntryImage.'"  style="width:60px!important; "/></a>';*/
					
					'<i class="pop" data-toggle="modal" data-target="#imagemodal" data-id="'.$row->EmployeeId.'" data-enimage="'.$row->EntryImage.'"><img src="'.$row->EntryImage.'"  style="width:60px!important; "  /></i>';
					
					$data['exitimg']=/*'<img src="'.$row->ExitImage.'"  style="width:60px!important; "/>';*/
					'<i class="pop" data-toggle="modal" data-target="#imagemodal" data-id="'.$row->EmployeeId.'" data-eximage="'.$row->ExitImage.'"><img src="'.$row->ExitImage.'" style="width:60px!important; "/></i>';
					
					$data['positionlin']="";
					$data['positionout']="";
					
					if($row->areaId != 0)
					{
						$lat_lang=getName('Geo_Settings','Lat_Long','Id',$row->areaId);
						$radius  = getName('Geo_Settings','Radius','Id',$row->areaId);
						$arr1 = explode(",",$lat_lang);
						//echo '----------'.count($arr1);
					if(count($arr1)>1)
					{
						$a=floatval($arr1[0]);
						$b=floatval($arr1[1]);
						$d1 = $this->distance($a,$b, $row->latit_in, $row->longi_in, "K");
						$d2 = $this->distance($a,$b, $row->latit_out, $row->longi_out, "K");
						if($row->FakeLocationStatusTimeIn==1){
							$data['positionlin'] = '<div title="Location recorded maliciously"   style="width:100px;" data-background-color="red"><i>Fake Location</i></div>';
						}
					else	
						if($d1 <= $radius)
						{
							$data['positionlin'] = '<div title="Attendance marked from the assigned area"  style="width:100px;" data-background-color="green"><i>Within the Location</i></div>';
						}
						else
						{
							$data['positionlin'] ='<div title="Attendance marked from the out side of assigned area" style="width:100px;"  data-background-color="red"><i>Outside the Location</i></div>';
						}
						if($row->FakeLocationStatusTimeIn==1){
							$data['positionout'] = '<div title="Location recorded maliciously"   style="width:100px;" data-background-color="red"><i>Fake Location</i></div>';
						}
						else
						if($d2 <= $radius)
						{
							$data['positionout'] = '<div title="Attendance marked from the assigned area"  style="width:100px;" data-background-color="green"><i>Within the Location</i></div>';
						}
						else
						{
							$data['positionout'] ='<div title="Attendance marked from the out side of assigned area" style="width:100px;" data-background-color="red"><i>Outside the Location</i></div>';
						}
					}
					
				}
					if($row->latit_in =='0.0')
						$data['chiloc']=$row->checkInLoc != ''?'<span title="'.$row->checkInLoc.'">'.$row->checkInLoc.'</span>':'-';
					else
						if($row->checkInLoc != "" && $row->checkInLoc =="Location not fetched.")
					$data['chiloc']='<span class="loc" data-toggle="modal" data-target="#locationmodal" data-latit="'.$row->latit_in.','.$row->longi_in.'" data-latitin="'.$row->latit_in.'" data-longiin="'.$row->longi_in.'" data-checkinloc="'.encode5t($row->checkInLoc).'"><a style="font-size:11px;" title="'.$row->checkInLoc.'">'.$row->checkInLoc .$data['positionlin'].'</a></span>';
					
					
						else
						if($row->checkInLoc =="" || $row->checkInLoc =="Location not fetched.")
						{
						$data['chiloc']='<span class="loc" data-toggle="modal" data-target="#locationmodal" data-latit="'.$row->latit_in.','.$row->longi_in.'" data-latitin="'.$row->latit_in.'" data-longiin="'.$row->longi_in.'" ><a style="font-size:11px;"  title="'.$row->latit_in.' , '.$row->longi_in.'">'.$row->latit_in.' , '.$row->longi_in .$data['positionlin'].'</a></span>';
						}
						
					    else
						 $data['chiloc']='<span class="loc" data-toggle="modal" data-target="#locationmodal" data-latit="'.$row->latit_in.','.$row->longi_in.'" data-latitin="'.$row->latit_in.'" data-longiin="'.$row->longi_in.'" data-checkinloc="'.encode5t($row->checkInLoc).'"><a style="font-size:11px;"  title="'.$row->checkInLoc.'">'.$row->checkInLoc.$row->longi_in.$data['positionlin'].'</a></span>';
						 
					if($row->longi_out=='0.0')
						$data['choloc']=$row->CheckOutLoc!=''?'<span title="'.$row->CheckOutLoc.'">'.$row->CheckOutLoc.'</span>':'-';
					
					else
						if($row->CheckOutLoc == "" || $row->CheckOutLoc =="Location not fetched.")
						$data['choloc']='<span class="loc" data-toggle="modal" data-target="#locationmodal" data-latit="'.$row->latit_out.','.$row->longi_out.'" data-latitin="'.$row->latit_out.'" data-longiin="'.$row->longi_out.'" >
					<a style="font-size:11px;" title="'.$row->latit_out.' , '.$row->longi_out.'">'.$row->latit_out.' , '.$row->longi_out .$data['positionout'].'</a>';
					else
						$data['choloc']='<span class="loc" data-toggle="modal" data-target="#locationmodal" data-latit="'.$row->latit_out.','.$row->longi_out.'" data-latitin="'.$row->latit_out.'" data-longiin="'.$row->longi_out.'" data-checkinloc="'.encode5t($row->CheckOutLoc).'">
						<a style="font-size:11px;"  title="'.$row->CheckOutLoc.'">'.$row->CheckOutLoc .$data['positionout'].'</a></span>';
						
					$data['wh']='-';
					if($row->AttendanceStatus==4)
					{
					$attn='<span style="background-color:green;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Halfday">Hd</span>';	
					}
					else
					{
					$attn=$row->AttendanceStatus !=2 ?'<span style="background-color:green;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Present">P</span>':'<span style=" background-color:red;text-align:center;color:white;padding-left:6px;
					padding-right:6px;" title="Absent">A</span>';
					}
					$goings='';$overtime='';$coming='';
					
					if($row->AttendanceStatus != 2)
					{	
					$tm = comings($row->ShiftId,$row->TimeIn,$row->timeindate,$row->AttendanceDate);
					//echo $tm;
					if(substr($tm,0,5) != '00:00')
					$coming=strpos($tm,'-')!==0?'<span style="background-color:red;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Late Coming By '.substr($tm,0,5).' Hr">LC</span>':'<span style=" background-color:green;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Early Coming By '.substr(str_replace("-","",$tm),0,5).' Hr">EC</span>';
					if($row->TimeOut!='00:00:00')
					{
						//$data['wh'] = substr($row->Officehours,0,5);
						$tm = goings($row->ShiftId,$row->TimeOut,$row->AttendanceStatus,$row->timeoutdate,$row->AttendanceDate);
						if(substr($tm,0,5) != '00:00')
						$goings=strpos($tm,'-') !== 0 ?'<span style=" background-color:green;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Late Leaving By '.substr($tm,0,5).' Hr">LL</span>':'<span style="background-color:red;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Early Leaving By '.substr(str_replace("-","",$tm),0,5).' Hr">EL</span>';
						
						//calculate work hours
					
					if(strtotime($row->ctin) < strtotime($row->ctout))
						{
						  if(strtotime($row->TimeIn) < strtotime($row->TimeOut))
						  {
							 
							// $a = new DateTime($row->TimeIn);
							// $b = new DateTime($row->TimeOut);
							//  //echo  $a;
							// // echo  $b;
							// $interval1 = $a->diff($b);
							// $a = new DateTime($interval1->format("%H:%I"));
							$data['wh']= substr($row->loggedhours,0,5);
							// print_r($data['wh']);
							// echo $name;
							// echo "<br/>";
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
							if(strtotime($row->TimeIn) <= strtotime($row->TimeOut))
							{
								// $interval1 = $a->diff($b);
								// $a = new DateTime($interval1->format("%H:%I"));
								// $data['wh']=$interval1->format("%H:%I");	
								$data['wh']= substr($row->loggedhours,0,5);
							}
							else
							{
								$time = "24:00:00";
								$secs = strtotime($row->TimeIn)-strtotime($row->TimeOut);
								$data['wh'] = date("H:i",strtotime($time)-$secs);
							}
						}
				     
				    }
						if($row->AttendanceStatus==4)
						{
							$overtime='';
						}
						elseif($row->AttendanceStatus==1 && $row->TimeOut== '00:00:00'){
							$overtime='';
						}
						else
						{
							if($row->Overtime != '00:00:00' )
							{
								$overtime=strpos($row->Overtime,'-')!==0?'<span style="background-color:green;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Over Time By '.substr($row->Overtime,0,5).' Hr">OT</span>':'<span style=" background-color:red;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Under Time By '.substr(str_replace("-","",$row->Overtime),0,5).' Hr">UT</span>';
							}
						}
						
						
					}
					$data['device']=$row->device;
					$data['status']=$attn.' '.$coming.' '.$goings.' '.$overtime;
		            $data['timeoff'] = $this->calculatetimeoff($row->EmployeeId, $row->AttendanceDate);
					
				if($data['timeoff'] != "00:00" AND $data['wh'] != "-" )
					{
						 $a = new DateTime($data['timeoff']);
						 $b = new DateTime($data['wh']);
						 $interval = $a->diff($b);
						 $a = new DateTime($interval->format("%H:%I"));
						 $data['wh'] = $interval->format("%H:%I");
					}
				//	$row->date > date('Y-m-d', strtotime('-3 day', strtotime(date('Y-m-d'))))&&
					
					// if($_SESSION['orgid']==10)
					// {
					// 	$permis = getAddonPermission($_SESSION['orgid'],'Addon_Delete') ;
					// 	$permis1 = getAddonPermission($_SESSION['orgid'],'Addon_Edit') ;
					// 	// org id condition for ubitech
					// 	if($row->AttendanceDate > date('Y-m-d', strtotime('-3 day', strtotime(date('Y-m-d'))))&& date('Y-m-d')!=$row->AttendanceDate)
					// 	{
					// 	$shiftype=getShiftType($row->ShiftId);
					// 	if($row->device=='Auto Time Out' && ($row->TimeIn==$row->TimeOut) && $permis1 == 1 && $permis==0)  
					// 	{
					// 	$data['action']='
					// 	 &nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>
					// 	  <a href="#"><i class="fa fa-pencil editATT" style="font-size:20px;color:purple;" data-toggle="modal" title="Edit" data-target="#addAttATO"	
					// 	 data-id="'.$row->Id.'"
					// 	 data-timeout="'.date("H:i",strtotime($row->TimeOut)).'";
					// 	 data-date="'.$row->timeoutdate.'";
					// 	  data-shifttype="'.$shiftype.'";
					// 	 ></i></a>';
					// 	}
					// 	else if( ($row->TimeIn!='00:00:00')&&($row->TimeOut=='00:00:00') && $permis1 == 1&& $permis==0)
					// 	{
					// 	$data['action']='
					// 	  &nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>
					// 	  <a href="#"><i class="fa fa-pencil editATT" style="font-size:20px;color:purple;" data-toggle="modal" title="Edit" data-target="#addAttATO"	
					// 	 data-id="'.$row->Id.'"
					// 	 data-timeout="'.date("H:i",strtotime($row->TimeOut)).'";
					// 	 data-date="'.$row->timeoutdate.'";
					// 	 data-shifttype="'.$shiftype.'";
					// 	 ></i></a>';
					// 	}
						
						
					// /////////	
					// else if($row->device=='Auto Time Out' && ($row->TimeIn==$row->TimeOut) && $permis1 == 1 && $permis==1)  
					// 	{
					// 	$data['action']='
					// 	 &nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>
					// 	  <a href="#"><i class="fa fa-pencil editATT" style="font-size:20px;color:purple;" data-toggle="modal" title="Edit" data-target="#addAttATO"	
					// 	 data-id="'.$row->Id.'"
					// 	 data-timeout="'.date("H:i",strtotime($row->TimeOut)).'";
					// 	 data-date="'.$row->timeoutdate.'";
					// 	  data-shifttype="'.$shiftype.'";
					// 	 ></i></a><a href="#"><i class="delete fa fa-trash"style="font-size:24px; color:purple;" data-toggle="modal" data-target="#delAtt" data-aid="'.$row->Id.'" data-aname="'.getEmpName($row->EmployeeId).'" data-attdate="'.$row->AttendanceDate.'" title="Delete"></i></a>';
					// 	}
					// 	else if( ($row->TimeIn!='00:00:00')&&($row->TimeOut=='00:00:00') && $permis1 == 1 && $permis==1)
					// 	{
					// 	$data['action']='
					// 	  &nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>
					// 	  <a href="#"><i class="fa fa-pencil editATT" style="font-size:20px;color:purple;" data-toggle="modal" title="Edit" data-target="#addAttATO"	
					// 	 data-id="'.$row->Id.'"
					// 	 data-timeout="'.date("H:i",strtotime($row->TimeOut)).'";
					// 	 data-date="'.$row->timeoutdate.'";
					// 	 data-shifttype="'.$shiftype.'";
					// 	 ></i></a><a href="#"><i class="delete fa fa-trash"style="font-size:24px; color:purple;" data-toggle="modal" data-target="#delAtt" data-aid="'.$row->Id.'" data-aname="'.getEmpName($row->EmployeeId).'" data-attdate="'.$row->AttendanceDate.'" title="Delete"></i></a>';
					// 	}	
						
						
					// /////	
						
					// else if( $permis1 == 0 && $permis==1)  
					// 	{
					// 	$data['action']='
					// 	 &nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>
					// 	  <a href="#"><i class="delete fa fa-trash"style="font-size:24px; color:purple;" data-toggle="modal" data-target="#delAtt" data-aid="'.$row->Id.'" data-aname="'.getEmpName($row->EmployeeId).'" data-attdate="'.$row->AttendanceDate.'" title="Delete"></i></a>';
					// 	}
							
					
						
						
						
						
						
						
						
						
					// 	//date("H:i A",strtotime($row->TimeIn))	
					// 	else
					// 	{
					// 		$data['action']='
					// 	  &nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>';	
					// 	}
					// }
					// else if($permis==1 && date('Y-m-d')==$row->AttendanceDate)
					// 	{
							
					// 		$data['action']='
					// 	  &nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track punched location(s)"></i><a href="#"><i class="delete fa fa-trash"style="font-size:24px; color:purple;" data-toggle="modal" data-target="#delAtt" data-aid="'.$row->Id.'" data-aname="'.getEmpName($row->EmployeeId).'" data-attdate="'.$row->AttendanceDate.'" title="Delete"></i></a>';
					// 	}	
						
					// else if($permis==0 && date('Y-m-d')==$row->AttendanceDate)
					// 	{
					// 		$data['action']='
					// 	  &nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>';
					// 	}	
					// else
					// {
					// 	$data['action']='
					//  &nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>';	
					// }
					// }





					//else{

						$permis = getAddonPermission($_SESSION['orgid'],'Addon_Delete') ;
						$permis1 = getAddonPermission($_SESSION['orgid'],'Addon_Edit') ;

						// for brigade eda delete inclusion for yesterday start

if($row->AttendanceDate > date('Y-m-d', strtotime('-2 day', strtotime(date('Y-m-d'))))&& date('Y-m-d')!=$row->AttendanceDate && $permis1 == 0 && $permis == 1 && ($orgid=10 || $orgid=26338))
{
$shiftype=getShiftType($row->ShiftId);


$data['action']='
&nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track Visits"></i>

<a href="#"><i class="delete fa fa-trash"style="font-size:24px; color:purple;" data-toggle="modal" data-target="#delAtt" data-aid="'.$row->Id.'" data-aname="'.getEmpName($row->EmployeeId).'" data-attdate="'.$row->AttendanceDate.'" title="Delete"></i></a>

';
}

elseif($row->AttendanceDate > date('Y-m-d', strtotime('-2 day', strtotime(date('Y-m-d'))))&& date('Y-m-d')!=$row->AttendanceDate && $permis1 == 1 && $permis == 1 &&($orgid=10 || $orgid=26338))
{
$shiftype=getShiftType($row->ShiftId);

         

 
$data['action']='
&nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track Visits"></i>


<a href="#"><i class="fa fa-pencil edit" style="font-size:20px;color:purple;" data-toggle="modal" title="Edit" data-target="#addAttE"


data-id="'.$row->Id.'"
data-aname="'.getEmpName($row->EmployeeId).'"
data-timein="'.date("H:i",strtotime($row->TimeIn)).'"
data-timeout="'.date("H:i",strtotime($row->TimeOut)).'";
data-tidate="'.$row->timeindate.'";
data-todate="'.$row->timeoutdate.'";
 data-shifttype="'.$shiftype.'";
></i></a>

<a href="#"><i class="delete fa fa-trash"style="font-size:24px; color:purple;" data-toggle="modal" data-target="#delAtt" data-aid="'.$row->Id.'" data-aname="'.getEmpName($row->EmployeeId).'" data-attdate="'.$row->AttendanceDate.'" title="Delete"></i></a>

';

}


// for brigade eda end
						elseif($row->AttendanceDate > date('Y-m-d', strtotime('-3 day', strtotime(date('Y-m-d'))))&& date('Y-m-d')!=$row->AttendanceDate && $permis == 0 && $permis1 == 1)
						{
						$shiftype=getShiftType($row->ShiftId);

         //                       $permis = getAddonPermission($_SESSION['orgid'],'Addon_Delete') ;
							  // if($permis == 1)
							  // 	$data['action'] = ""
							  
							  // else{
								
							   
						$data['action']='
						&nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track Visits"></i>
						 
						 
						  <a href="#"><i class="fa fa-pencil edit" style="font-size:20px;color:purple;" data-toggle="modal" title="Edit" data-target="#addAttE"	
						 data-id="'.$row->Id.'"
						 data-aname="'.getEmpName($row->EmployeeId).'"
						 data-timein="'.date("H:i",strtotime($row->TimeIn)).'"
						 data-timeout="'.date("H:i",strtotime($row->TimeOut)).'";
						 data-tidate="'.$row->timeindate.'";
						 data-todate="'.$row->timeoutdate.'";
						  data-shifttype="'.$shiftype.'";
						 ></i></a>
						 ';
						// }
						}
					elseif($row->AttendanceDate > date('Y-m-d', strtotime('-3 day', strtotime(date('Y-m-d'))))&& date('Y-m-d')!=$row->AttendanceDate && $permis1 == 0 && $permis == 1)
						{
						$shiftype=getShiftType($row->ShiftId);

         //                       $permis = getAddonPermission($_SESSION['orgid'],'Addon_Delete') ;
							  // if($permis == 1)
							  // 	$data['action'] = ""
							  
							  // else{

						
								
							   
						$data['action']='
						 &nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track Visits"></i>

						 ';
						// }
						}

					elseif($row->AttendanceDate > date('Y-m-d', strtotime('-3 day', strtotime(date('Y-m-d'))))&& date('Y-m-d')!=$row->AttendanceDate && $permis1 == 1 && $permis == 1)
						{
						$shiftype=getShiftType($row->ShiftId);

         //                       $permis = getAddonPermission($_SESSION['orgid'],'Addon_Delete') ;
							  // if($permis == 1)
							  // 	$data['action'] = ""
							  
							  // else{
								
							   
						$data['action']='
						 &nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track Visits"></i>

						 
						 <a href="#"><i class="fa fa-pencil edit" style="font-size:20px;color:purple;" data-toggle="modal" title="Edit" data-target="#addAttE"
						 
						 	
						 data-id="'.$row->Id.'"
						 data-aname="'.getEmpName($row->EmployeeId).'"
						 data-timein="'.date("H:i",strtotime($row->TimeIn)).'"
						 data-timeout="'.date("H:i",strtotime($row->TimeOut)).'";
						 data-tidate="'.$row->timeindate.'";
						 data-todate="'.$row->timeoutdate.'";
						  data-shifttype="'.$shiftype.'";
						 ></i></a>
						 ';
						// }
					}

					elseif($row->AttendanceDate > date('Y-m-d', strtotime('-3 day', strtotime(date('Y-m-d'))))&& date('Y-m-d')!=$row->AttendanceDate && $permis1 == 0 && $permis == 0)
						{
						$data['action']='
					 &nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track Visits"></i>';

					}

					else if(date('Y-m-d')==$row->AttendanceDate && $permis == 0 && $permis1 == 1){
						$shiftype=getShiftType($row->ShiftId);
						if($row->TimeOut=='00:00:00' && $row->timeoutdate ='0000-00-00' ){
					$data['action']='&nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>
					<a href="#"><i class="fa fa-pencil edit" style="font-size:20px;color:purple;" data-toggle="modal" title="Edit" data-target="#addAttc"
						 
						 	
						 data-id="'.$row->Id.'"
						 data-aname="'.getEmpName($row->EmployeeId).'"
						 data-timein="'.date("H:i",strtotime($row->TimeIn)).'"
						 
						 data-tidate="'.$row->timeindate.'";
						
						  data-shifttype="'.$shiftype.'";
						 ></i></a>
					';
					}

					else{

						$data['action']='&nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track Visits"></i>


							<a href="#"><i class="fa fa-pencil edit" style="font-size:20px;color:purple;" data-toggle="modal" title="Edit" data-target="#addAttE"
						 
						 	
						 data-id="'.$row->Id.'"
						 data-aname="'.getEmpName($row->EmployeeId).'"
						 data-timein="'.date("H:i",strtotime($row->TimeIn)).'"
						 data-timeout="'.date("H:i",strtotime($row->TimeOut)).'";
						 data-tidate="'.$row->timeindate.'";
						 data-todate="'.$row->timeoutdate.'";
						  data-shifttype="'.$shiftype.'";
						 ></i></a>


						';

					}

				}

				else if(date('Y-m-d')==$row->AttendanceDate && $permis == 1 && $permis1 == 0){

					$data['action']='&nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track Visits"></i>

					<a href="#"><i class="delete fa fa-trash"style="font-size:24px; color:purple;" data-toggle="modal" data-target="#delAtt" data-aid="'.$row->Id.'" data-aname="'.getEmpName($row->EmployeeId).'" data-attdate="'.$row->AttendanceDate.'" title="Delete"></i></a>';




				}
				else if(date('Y-m-d')==$row->AttendanceDate && $permis == 1 && $permis1 == 1){
					$shiftype=getShiftType($row->ShiftId);
					if($row->TimeOut=='00:00:00' && $row->timeoutdate ='0000-00-00' ){
						$data['action']='&nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>
					<a href="#"><i class="delete fa fa-trash"style="font-size:24px; color:purple;" data-toggle="modal" data-target="#delAtt" data-aid="'.$row->Id.'" data-aname="'.getEmpName($row->EmployeeId).'" data-attdate="'.$row->AttendanceDate.'" title="Delete"></i></a>

					<a href="#"><i class="fa fa-pencil edit" style="font-size:20px;color:purple;" data-toggle="modal" title="Edit" data-target="#addAttc"
						 
						 	
						 data-id="'.$row->Id.'"
						 data-aname="'.getEmpName($row->EmployeeId).'"
						 data-timein="'.date("H:i",strtotime($row->TimeIn)).'"
						 
						 data-tidate="'.$row->timeindate.'";
						
						  data-shifttype="'.$shiftype.'";
						 ></i></a>
					';
					}
						else{
					
					$data['action']='&nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track Visits"></i>
					<a href="#"><i class="delete fa fa-trash"style="font-size:24px; color:purple;" data-toggle="modal" data-target="#delAtt" data-aid="'.$row->Id.'" data-aname="'.getEmpName($row->EmployeeId).'" data-attdate="'.$row->AttendanceDate.'" title="Delete"></i></a>

					<a href="#"><i class="fa fa-pencil edit" style="font-size:20px;color:purple;" data-toggle="modal" title="Edit" data-target="#addAttE"
						 
						 	
						 data-id="'.$row->Id.'"
						 data-aname="'.getEmpName($row->EmployeeId).'"
						 data-timein="'.date("H:i",strtotime($row->TimeIn)).'"
						 data-timeout="'.date("H:i",strtotime($row->TimeOut)).'";
						 data-tidate="'.$row->timeindate.'";
						 data-todate="'.$row->timeoutdate.'";
						  data-shifttype="'.$shiftype.'";
						 ></i></a>
					';
				}
// yaha lagana hai edit
				}



					else
					{
						$data['action']='
					  &nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'/'.$data['ti'].'/'.$data['to'].'/'.$data['wh'].'" target="_self"><i class="track_loc fas fa-walking"style="font-size:24px; color:purple;" title="Track Visits"></i>';	
					}

					//}


				
					$res[]=$data;
			    }
		    }  	
		    	 	
			$d['data']=$res;  
			//print_r($d['data']);
            $this->db->close();			//$query->result();
			echo json_encode($d); 
			return false;
		}	

		public function getAttendances__archived(){

			$orgid=$_SESSION['orgid'];
				 $deptId = isset($_REQUEST['dept'])?$_REQUEST['dept']:0;
				 $date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
				 $shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:0;
			     $emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:0;
			     $desgid=isset($_REQUEST['desg'])?$_REQUEST['desg']:0;
				 $zname=getTimeZone($orgid);
				date_default_timezone_set ($zname);
			 $today=date('Y-m-d');
			 //$today='2019-02-28';
			   $q1 = '';
		    	if($shiftid!= 0)
				{
			     $q1.= " AND A.ShiftId='$shiftid' ";
			    }
                if($desgid != 0)
				{
			      $q1.=" AND  A.Desg_id = '$desgid'  ";
			    } 
				if($deptId != 0)
				{
					$q1.=" AND A.Dept_id='$deptId' ";
				}
				if($emplid !=0) 
				{
					$q1.=" AND A.EmployeeId = '$emplid'";
				}
			    if($date == '')
				{
						$range = "";
						// $lastdate= date('Y-m-d', strtotime('last day of previous month'));
				        // $enddate=date('Y-m-d', strtotime('-3 month', strtotime($lastdate)));
				        // $startdate=date('Y-m-d', strtotime('-5 day', strtotime($enddate)));
					$enddate=date('Y-m-d', strtotime('-4 month', strtotime('last day of this month')));
					$startdate=date('Y-m-d', strtotime('-6 day', strtotime($enddate)));
						
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
					
				$query = $this->db->query("SELECT A.Id ,A.timeoutdate as timeoutdate, A.EmployeeId,C.TimeIn as ctin ,C.TimeOut as ctout, A.AttendanceDate  , A.AttendanceStatus, A.TimeIn, A.TimeOut, A.ShiftId,C.shifttype, A.Overtime,A.EntryImage,A.device,E.EmployeeCode, A.ExitImage,A.latit_in,A.longi_in,A.longi_out,A.latit_out,A.checkInLoc, A.CheckOutLoc,A.areaId,E.ImageName,E.Gender,A.timeindate,A.timeoutdate FROM ArchiveAttendanceMaster A, ShiftMaster C ,EmployeeMaster E WHERE A.OrganizationId=?  And A.TimeIn != '0000:00:00' And C.Id = A.ShiftId and C.OrganizationId = ? $q1 And A.AttendanceDate IN ( ".$range." ) and A.EmployeeId=E.Id  ",array($orgid,$orgid));
				}
			else{
				
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
				//echo $range;
			 $rangedate = $range;
			 
			
			 if($rangedate=="")
				{
			   $rangedate = 1;
				} 

				//between '$strt' and '$end'
			 // echo  $rangedate;
			   //, TIMEDIFF(CONCAT(A.timeoutdate,'   ',A.TimeOut) , CONCAT(A.AttendanceDate,'  ',A.TimeIn)) as Officehours 
				$query = $this->db->query("SELECT A.Id,A.EmployeeId,C.TimeIn as ctin ,C.TimeOut as ctout, A.AttendanceDate ,A.timeoutdate as timeoutdate , A.AttendanceStatus, A.TimeIn, A.TimeOut, A.ShiftId, A.Overtime,A.EntryImage,A.device,E.EmployeeCode,C.shifttype, A.ExitImage,A.latit_in,A.longi_in,A.longi_out,A.latit_out,A.checkInLoc, A.CheckOutLoc,A.areaId,E.ImageName,E.Gender,A.timeindate,A.timeoutdate FROM ArchiveAttendanceMaster A, ShiftMaster C,EmployeeMaster E  WHERE A.OrganizationId=?  And A.TimeIn != '0000:00:00' And C.Id = A.ShiftId and C.OrganizationId = ? $q1 And A.AttendanceDate IN ( ".$rangedate." )  and A.EmployeeId=E.Id  ",array($orgid,$orgid));
			}
			
			$d=array();                      
			$res=array();
			 foreach ($query->result() as $row)
			  {	
					$data=array();
					$name = ucwords(getEmpName($row->EmployeeId));
					if($name != "")
					{
					//$ff=$this->fetchWeeklyOff($row->ShiftId);
					//print_r($ff);
					$data['name'] = $name;	
					if($row->ImageName)
					{
					$data['proimage'] ='<img src="'.IMGURL3."uploads/$orgid/".$row->ImageName.'" style="width:60px!important;" />';
					}
					else
					{
						if($row->Gender==1)
						{
						$data['proimage'] ='<img src="'.IMGURL3."avatars/male.png".'" style="width:60px!important;" />';
						}
						else
						{
						$data['proimage'] ='<img src="'.IMGURL3."avatars/female.png".'" style="width:60px!important;" />';	
						}
					}
					$data['code']=$row->EmployeeCode;
					$data['date']=date("M d,Y",strtotime($row->AttendanceDate));
					//print_r($data['date']);
					$data['ti']=substr($row->TimeIn,0,5);
					$data['to']=substr($row->TimeOut,0,5);
					$data['timeindate']=$row->timeindate;
					$data['timeoutdate']=$row->timeoutdate;
					$data['shift']='<span title="Shift Timing: '.getShiftTimes($row->ShiftId).', Break Hours:'.getShiftBreaks($row->ShiftId).'">'.getShift($row->ShiftId).'</span>';
					//$data['shift']=getShiftTimes($row->ShiftId);
					$data['ot']=$row->Overtime;
					$data['entryimg']=/*'<a href="#" class="pop"><img src="'.$row->EntryImage.'"  style="width:60px!important; "/></a>';*/
					
					'<i class="pop" data-toggle="modal" data-target="#imagemodal" data-id="'.$row->EmployeeId.'" data-enimage="'.$row->EntryImage.'"><img src="'.$row->EntryImage.'"  style="width:60px!important; "  /></i>';
					
					$data['exitimg']=/*'<img src="'.$row->ExitImage.'"  style="width:60px!important; "/>';*/
					'<i class="pop" data-toggle="modal" data-target="#imagemodal" data-id="'.$row->EmployeeId.'" data-eximage="'.$row->ExitImage.'"><img src="'.$row->ExitImage.'" style="width:60px!important; "/></i>';
					
					$data['positionlin']="";
					$data['positionout']="";
					
					if($row->areaId != 0)
					{
						$lat_lang=getName('Geo_Settings','Lat_Long','Id',$row->areaId);
						$radius  = getName('Geo_Settings','Radius','Id',$row->areaId);
						$arr1 = explode(",",$lat_lang);
						//echo '----------'.count($arr1);
					if(count($arr1)>1)
					{
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
					if($row->latit_in =='0.0')
						$data['chiloc']=$row->checkInLoc != ''?'<span title="'.$row->checkInLoc.'">'.$row->checkInLoc.'</span>':'-';
					else
						if($row->checkInLoc != "")
						$data['chiloc']='<a style="font-size:11px;" href="http://maps.google.com/?q='.$row->latit_in.','.$row->longi_in.'" target="_blank" title="'.$row->checkInLoc.'">'.$row->checkInLoc .$data['positionlin'].'</a>';
					    else
						 $data['chiloc']='<a style="font-size:11px;" href="http://maps.google.com/?q='.$row->latit_in.','.$row->longi_in.'" target="_blank" title="'.$row->checkInLoc.'">'.$row->latit_in .','.$row->longi_in.$data['positionlin'].'</a>';
					if($row->longi_out=='0.0')
						$data['choloc']=$row->CheckOutLoc!=''?'<span title="'.$row->CheckOutLoc.'">'.$row->CheckOutLoc.'</span>':'-';
					else
						$data['choloc']='<a style="font-size:11px;" href="http://maps.google.com/?q='.$row->latit_out.','.$row->longi_out.'" target="_blank" title="'.$row->CheckOutLoc.'">'.$row->CheckOutLoc .$data['positionout'].'</a>';

					$data['wh']='-';
					if($row->AttendanceStatus==4)
					{
					$attn='<span style="background-color:green;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Halfday">Hd</span>';	
					}
					else
					{
					$attn=$row->AttendanceStatus !=2 ?'<span style="background-color:green;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Present">P</span>':'<span style=" background-color:red;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Absent">A</span>';
					}
					$goings='';$overtime='';$coming='';
					
					if($row->AttendanceStatus != 2)
					{	
					$tm = comings($row->ShiftId,$row->TimeIn,$row->timeindate,$row->AttendanceDate);
					if(substr($tm,0,5) != '00:00')
					$coming=strpos($tm,'-')!==0?'<span style="background-color:red;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Late Coming By '.substr($tm,0,5).' Hr">LC</span>':'<span style=" background-color:green;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Early Coming By '.substr(str_replace("-","",$tm),0,5).' Hr">EC</span>';
					if($row->TimeOut!='00:00:00')
					{
						//$data['wh'] = substr($row->Officehours,0,5);
						$tm = goings($row->ShiftId,$row->TimeOut,$row->AttendanceStatus,$row->timeoutdate,$row->AttendanceDate);
						if(substr($tm,0,5) != '00:00')
						$goings=strpos($tm,'-') !== 0 ?'<span style=" background-color:green;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Late Leaving By '.substr($tm,0,5).' Hr">LL</span>':'<span style="background-color:red;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Early Leaving By '.substr(str_replace("-","",$tm),0,5).' Hr">EL</span>';
						
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
							if(strtotime($row->TimeIn) <= strtotime($row->TimeOut))
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
						if($row->AttendanceStatus==4)
						{
							$overtime='';
						}
						else
						{
							if($row->Overtime != '00:00:00')
							{
								$overtime=strpos($row->Overtime,'-')!==0?'<span style="background-color:green;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Over Time By '.substr($row->Overtime,0,5).' Hr">OT</span>':'<span style=" background-color:red;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Under Time By '.substr(str_replace("-","",$row->Overtime),0,5).' Hr">UT</span>';
							}
						}
						
						
					}
					$data['device']=$row->device;
					$data['status']=$attn.' '.$coming.' '.$goings.' '.$overtime;
		            $data['timeoff'] = $this->calculatetimeoff($row->EmployeeId, $row->AttendanceDate);
					
				if($data['timeoff'] != "00:00" AND $data['wh'] != "-" )
					{
						 $a = new DateTime($data['timeoff']);
						 $b = new DateTime($data['wh']);
						 $interval = $a->diff($b);
						 $a = new DateTime($interval->format("%H:%I"));
						 $data['wh'] = $interval->format("%H:%I");
					}
				//	$row->date > date('Y-m-d', strtotime('-3 day', strtotime(date('Y-m-d'))))&&
					if($row->AttendanceDate > date('Y-m-d', strtotime('-3 day', strtotime(date('Y-m-d'))))&& date('Y-m-d')!=$row->AttendanceDate)
					{
						
						$shiftype=getShiftType($row->ShiftId);
						if($row->device=='Auto Time Out' && ($row->TimeIn==$row->TimeOut))  
						{
						$data['action']='
						 &nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'" target="_self"><i class="track_loc fa fa-map-marker"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>
						  <a href="#"><i class="fa fa-pencil edit" style="font-size:20px;color:purple;" data-toggle="modal" title="Edit" data-target="#addAttE"	
						 data-id="'.$row->Id.'"
						 data-timein="'.date("H:i A",strtotime($row->TimeIn)).'"
						 data-timeout="'.date("H:i A",strtotime($row->TimeOut)).'";
						 data-date="'.$row->AttendanceDate.'";
						  data-shifttype="'.$shiftype.'";
						 ></i></a>';
						}
						else if(($row->TimeIn!='00:00:00')&&($row->TimeOut=='00:00:00'))
						{
						$data['action']='
						  &nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'" target="_self"><i class="track_loc fa fa-map-marker"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>
						  <a href="#"><i class="fa fa-pencil edit" style="font-size:20px;color:purple;" data-toggle="modal" title="Edit" data-target="#addAttE"	
						 data-id="'.$row->Id.'"
						 data-timein="'.date("H:i A",strtotime($row->TimeIn)).'"
						 data-timeout="'.date("H:i A",strtotime($row->TimeOut)).'";
						 data-date="'.$row->AttendanceDate.'";
						 data-shifttype="'.$shiftype.'";
						 ></i></a>';
						}
						//date("H:i A",strtotime($row->TimeIn))	
						else
						{
							$data['action']='
						  &nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'" target="_self"><i class="track_loc fa fa-map-marker"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>';	
						}
					}
					else
					{
						$data['action']='
					  &nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'" target="_self"><i class="track_loc fa fa-map-marker"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>';	
					}
					$res[]=$data;
			    }
		    }  	
		    	 	
			$d['data']=$res;  
			//print_r($d['data']);
            $this->db->close();			//$query->result();
			echo json_encode($d); 
			return false;

		}
		 
		public function getAttendances__3month()
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
			 //$today='2019-02-28';
			   $q1 = '';
		    	if($shiftid!= 0)
				{
			     $q1.= " AND A.ShiftId='$shiftid' ";
			    }
                if($desgid != 0)
				{
			      $q1.=" AND  A.Desg_id = '$desgid'  ";
			    } 
				if($deptId != 0)
				{
					$q1.=" AND A.Dept_id='$deptId' ";
				}
				if($emplid !=0) 
				{
					$q1.=" AND A.EmployeeId = '$emplid'";
				}
			    if($date == '')
				{
						$range = "";
						// $lastdate= date('Y-m-d', strtotime('last day of previous month'));
				        // $enddate=date('Y-m-d', strtotime('-3 month', strtotime($lastdate)));
				        // $startdate=date('Y-m-d', strtotime('-5 day', strtotime($enddate)));
					$enddate=date('Y-m-d', strtotime('-4 month', strtotime('last day of this month')));
					$startdate=date('Y-m-d', strtotime('-6 day', strtotime($enddate)));
						
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
					
				$query = $this->db->query("SELECT A.Id ,A.timeoutdate as timeoutdate, A.EmployeeId,C.TimeIn as ctin ,C.TimeOut as ctout, A.AttendanceDate  , A.AttendanceStatus, A.TimeIn, A.TimeOut, A.ShiftId,C.shifttype, A.Overtime,A.EntryImage,A.device,E.EmployeeCode, A.ExitImage,A.latit_in,A.longi_in,A.longi_out,A.latit_out,A.checkInLoc, A.CheckOutLoc,A.areaId,E.ImageName,E.Gender,A.timeindate,A.timeoutdate FROM ArchiveAttendanceMaster A, ShiftMaster C ,EmployeeMaster E WHERE A.OrganizationId=?  And A.TimeIn != '0000:00:00' And C.Id = A.ShiftId and C.OrganizationId = ? $q1 And A.AttendanceDate IN ( ".$range." ) and A.EmployeeId=E.Id  ",array($orgid,$orgid));
				}
			else{
				
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
				//echo $range;
			 $rangedate = $range;
			 
			
			 if($rangedate=="")
				{
			   $rangedate = 1;
				} 

				//between '$strt' and '$end'
			 // echo  $rangedate;
			   //, TIMEDIFF(CONCAT(A.timeoutdate,'   ',A.TimeOut) , CONCAT(A.AttendanceDate,'  ',A.TimeIn)) as Officehours 
				$query = $this->db->query("SELECT A.Id,A.EmployeeId,C.TimeIn as ctin ,C.TimeOut as ctout, A.AttendanceDate ,A.timeoutdate as timeoutdate , A.AttendanceStatus, A.TimeIn, A.TimeOut, A.ShiftId, A.Overtime,A.EntryImage,A.device,E.EmployeeCode,C.shifttype, A.ExitImage,A.latit_in,A.longi_in,A.longi_out,A.latit_out,A.checkInLoc, A.CheckOutLoc,A.areaId,E.ImageName,E.Gender,A.timeindate,A.timeoutdate FROM ArchiveAttendanceMaster A, ShiftMaster C,EmployeeMaster E  WHERE A.OrganizationId=?  And A.TimeIn != '0000:00:00' And C.Id = A.ShiftId and C.OrganizationId = ? $q1 And A.AttendanceDate IN ( ".$rangedate." )  and A.EmployeeId=E.Id  ",array($orgid,$orgid));
			}
			
			$d=array();                      
			$res=array();
			 foreach ($query->result() as $row)
			  {	
					$data=array();
					$name = ucwords(getEmpName($row->EmployeeId));
					if($name != "")
					{
					//$ff=$this->fetchWeeklyOff($row->ShiftId);
					//print_r($ff);
					$data['name'] = $name;	
					if($row->ImageName)
					{
					$data['proimage'] ='<img src="'.IMGURL3."uploads/$orgid/".$row->ImageName.'" style="width:60px!important;" />';
					}
					else
					{
						if($row->Gender==1)
						{
						$data['proimage'] ='<img src="'.IMGURL3."avatars/male.png".'" style="width:60px!important;" />';
						}
						else
						{
						$data['proimage'] ='<img src="'.IMGURL3."avatars/female.png".'" style="width:60px!important;" />';	
						}
					}
					$data['code']=$row->EmployeeCode;
					$data['date']=date("M d,Y",strtotime($row->AttendanceDate));
					//print_r($data['date']);
					$data['ti']=substr($row->TimeIn,0,5);
					$data['to']=substr($row->TimeOut,0,5);
					$data['timeindate']=$row->timeindate;
					$data['timeoutdate']=$row->timeoutdate;
					$data['shift']='<span title="Shift Timing: '.getShiftTimes($row->ShiftId).', Break Hours:'.getShiftBreaks($row->ShiftId).'">'.getShift($row->ShiftId).'</span>';
					//$data['shift']=getShiftTimes($row->ShiftId);
					$data['ot']=$row->Overtime;
					$data['entryimg']=/*'<a href="#" class="pop"><img src="'.$row->EntryImage.'"  style="width:60px!important; "/></a>';*/
					
					'<i class="pop" data-toggle="modal" data-target="#imagemodal" data-id="'.$row->EmployeeId.'" data-enimage="'.$row->EntryImage.'"><img src="'.$row->EntryImage.'"  style="width:60px!important; "  /></i>';
					
					$data['exitimg']=/*'<img src="'.$row->ExitImage.'"  style="width:60px!important; "/>';*/
					'<i class="pop" data-toggle="modal" data-target="#imagemodal" data-id="'.$row->EmployeeId.'" data-eximage="'.$row->ExitImage.'"><img src="'.$row->ExitImage.'" style="width:60px!important; "/></i>';
					
					$data['positionlin']="";
					$data['positionout']="";
					
					if($row->areaId != 0)
					{
						$lat_lang=getName('Geo_Settings','Lat_Long','Id',$row->areaId);
						$radius  = getName('Geo_Settings','Radius','Id',$row->areaId);
						$arr1 = explode(",",$lat_lang);
						//echo '----------'.count($arr1);
					if(count($arr1)>1)
					{
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
					if($row->latit_in =='0.0')
						$data['chiloc']=$row->checkInLoc != ''?'<span title="'.$row->checkInLoc.'">'.$row->checkInLoc.'</span>':'-';
					else
						if($row->checkInLoc != "")
						$data['chiloc']='<a style="font-size:11px;" href="http://maps.google.com/?q='.$row->latit_in.','.$row->longi_in.'" target="_blank" title="'.$row->checkInLoc.'">'.$row->checkInLoc .$data['positionlin'].'</a>';
					    else
						 $data['chiloc']='<a style="font-size:11px;" href="http://maps.google.com/?q='.$row->latit_in.','.$row->longi_in.'" target="_blank" title="'.$row->checkInLoc.'">'.$row->latit_in .','.$row->longi_in.$data['positionlin'].'</a>';
					if($row->longi_out=='0.0')
						$data['choloc']=$row->CheckOutLoc!=''?'<span title="'.$row->CheckOutLoc.'">'.$row->CheckOutLoc.'</span>':'-';
					else
						$data['choloc']='<a style="font-size:11px;" href="http://maps.google.com/?q='.$row->latit_out.','.$row->longi_out.'" target="_blank" title="'.$row->CheckOutLoc.'">'.$row->CheckOutLoc .$data['positionout'].'</a>';

					$data['wh']='-';
					if($row->AttendanceStatus==4)
					{
					$attn='<span style="background-color:green;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Halfday">Hd</span>';	
					}
					else
					{
					$attn=$row->AttendanceStatus !=2 ?'<span style="background-color:green;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Present">P</span>':'<span style=" background-color:red;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Absent">A</span>';
					}
					$goings='';$overtime='';$coming='';
					
					if($row->AttendanceStatus != 2)
					{	
					$tm = comings($row->ShiftId,$row->TimeIn);
					if(substr($tm,0,5) != '00:00')
					$coming=strpos($tm,'-')!==0?'<span style="background-color:red;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Late Coming By '.substr($tm,0,5).' Hr">LC</span>':'<span style=" background-color:green;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Early Coming By '.substr(str_replace("-","",$tm),0,5).' Hr">EC</span>';
					if($row->TimeOut!='00:00:00')
					{
						//$data['wh'] = substr($row->Officehours,0,5);
						$tm = goings($row->ShiftId,$row->TimeOut,$row->AttendanceStatus);
						if(substr($tm,0,5) != '00:00')
						$goings=strpos($tm,'-') !== 0 ?'<span style=" background-color:green;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Late Leaving By '.substr($tm,0,5).' Hr">LL</span>':'<span style="background-color:red;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Early Leaving By '.substr(str_replace("-","",$tm),0,5).' Hr">EL</span>';
						
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
							if(strtotime($row->TimeIn) <= strtotime($row->TimeOut))
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
						if($row->AttendanceStatus==4)
						{
							$overtime='';
						}
						else
						{
							if($row->Overtime != '00:00:00')
							{
								$overtime=strpos($row->Overtime,'-')!==0?'<span style="background-color:green;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Over Time By '.substr($row->Overtime,0,5).' Hr">OT</span>':'<span style=" background-color:red;text-align:center;color:white;padding-left:6px;padding-right:6px;" title="Under Time By '.substr(str_replace("-","",$row->Overtime),0,5).' Hr">UT</span>';
							}
						}
						
						
					}
					$data['device']=$row->device;
					$data['status']=$attn.' '.$coming.' '.$goings.' '.$overtime;
		            $data['timeoff'] = $this->calculatetimeoff($row->EmployeeId, $row->AttendanceDate);
					
				if($data['timeoff'] != "00:00" AND $data['wh'] != "-" )
					{
						 $a = new DateTime($data['timeoff']);
						 $b = new DateTime($data['wh']);
						 $interval = $a->diff($b);
						 $a = new DateTime($interval->format("%H:%I"));
						 $data['wh'] = $interval->format("%H:%I");
					}
				//	$row->date > date('Y-m-d', strtotime('-3 day', strtotime(date('Y-m-d'))))&&
					if($row->AttendanceDate > date('Y-m-d', strtotime('-3 day', strtotime(date('Y-m-d'))))&& date('Y-m-d')!=$row->AttendanceDate)
					{
						
						$shiftype=getShiftType($row->ShiftId);
						if($row->device=='Auto Time Out' && ($row->TimeIn==$row->TimeOut))  
						{
						$data['action']='
						 &nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'" target="_self"><i class="track_loc fa fa-map-marker"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>
						  <a href="#"><i class="fa fa-pencil edit" style="font-size:20px;color:purple;" data-toggle="modal" title="Edit" data-target="#addAttE"	
						 data-id="'.$row->Id.'"
						 data-timein="'.date("H:i A",strtotime($row->TimeIn)).'"
						 data-timeout="'.date("H:i A",strtotime($row->TimeOut)).'";
						 data-date="'.$row->AttendanceDate.'";
						  data-shifttype="'.$shiftype.'";
						 ></i></a>';
						}
						else if(($row->TimeIn!='00:00:00')&&($row->TimeOut=='00:00:00'))
						{
						$data['action']='
						  &nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'" target="_self"><i class="track_loc fa fa-map-marker"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>
						  <a href="#"><i class="fa fa-pencil edit" style="font-size:20px;color:purple;" data-toggle="modal" title="Edit" data-target="#addAttE"	
						 data-id="'.$row->Id.'"
						 data-timein="'.date("H:i A",strtotime($row->TimeIn)).'"
						 data-timeout="'.date("H:i A",strtotime($row->TimeOut)).'";
						 data-date="'.$row->AttendanceDate.'";
						 data-shifttype="'.$shiftype.'";
						 ></i></a>';
						}
						//date("H:i A",strtotime($row->TimeIn))	
						else
						{
							$data['action']='
						  &nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'" target="_self"><i class="track_loc fa fa-map-marker"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>';	
						}
					}
					else
					{
						$data['action']='
					  &nbsp;<a href="trackLocations/'.$row->EmployeeId.'/'.$row->AttendanceDate.'" target="_self"><i class="track_loc fa fa-map-marker"style="font-size:24px; color:purple;" title="Track punched location(s)"></i>';	
					}
					$res[]=$data;
			    }
		    }  	
		    	 	
			$d['data']=$res;  
			//print_r($d['data']);
            $this->db->close();			//$query->result();
			echo json_encode($d); 
			return false;
		}	 
		 public function getAbsent__archive(){

		 	$org_id=$_SESSION['orgid'];
			 $date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
			 $shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:0;
			 $deprtid=isset($_REQUEST['deprt'])?$_REQUEST['deprt']:0;
			// echo $deprtid;
			 $emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:0;
			 $desgid=isset($_REQUEST['desg'])?$_REQUEST['desg']:0;
			 $res = array();
			    $startdate="";
				$enddate="";
				$s='';
				$s1='';
			if($date=='') 
			{
				 $datestatus=isset($_REQUEST['datestatus'])?$_REQUEST['datestatus']:0;
				 if($datestatus == 7)
				 {
				$enddate=date('Y-m-d', strtotime('-4 month', strtotime('last day of this month')));
					$startdate=date('Y-m-d', strtotime('-6 day', strtotime($enddate)));
				 }
				 
				 else
				 {
				   $enddate=date("Y-m-d");
				   $startdate=date("Y-m-d");
				 }
			}
			if($shiftid!=0)
			{
				$s=" AND ShiftId='$shiftid' ";
				$s1 =" AND Shift='$shiftid' ";
				
			} 
			if($deprtid != 0)
			{
				$s .= " AND `Dept_id` = '$deprtid' ";
				$s1 .= " AND `Department`='$deprtid' ";
			}
			if($emplid!=0)
			{
				$s1 .=" AND E.Id='$emplid' ";
			    $s .= "AND EmployeeId = '$emplid'";
			}
			if($desgid!=0)
			{
				$s .=" AND `Desg_id`='$desgid' ";
				$s1 .=" AND `Designation`='$desgid' ";
			}
			if($date != '')
			{
				$arr= explode('-', trim($date));
				$enddate= date('Y-m-d',strtotime($arr[1]));
				$startdate= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3)));

			}
			$begin = new DateTime($startdate);
			$interval = new DateInterval('P1D'); // 1 Day
			$realEnd = new DateTime($enddate);
			$realEnd->add($interval);
			$dateRange = new DatePeriod($begin,$interval,$realEnd);	
			$range = "";
			//set time zone
		     	$zname=getTimeZone($org_id);
				date_default_timezone_set ($zname);
				$todate = date('Y-m-d');
				//date_default_timezone_set ($zname);
				$time = date("H:i:s");
				$i = 0;
		 foreach ($dateRange as $date) 
		  {
		        $range = $date->format('Y-m-d');
				$query = "";
				//print_r($range);
			 if(strtotime($range) == strtotime($todate))//fetch data today
				{ 
					$query = $this->db->query("Select '-' as device, E.Id as EmployeeId,E.EmployeeCode,E.Shift as ShiftId ,'".$todate."' as AttendanceDate FROM EmployeeMaster E,ShiftMaster S Where  E.Id NOT IN (select A.EmployeeId From ArchiveAttendanceMaster A where A.AttendanceDate= '".$todate."'  AND  A.OrganizationId= ".$org_id." AND AttendanceStatus  IN (1,8,4) ) $s1 AND E.OrganizationId = ".$org_id ." AND E.Shift = S.Id AND S.TimeIn < '$time'  AND E.archive = 1   group By EmployeeId");
				   
				}
				else
				{
					//echo $range;
					$query = $this->db->query("Select A.device,E.Id,E.EmployeeCode,A.EmployeeId,A.AttendanceDate,A.ShiftId FROM ArchiveAttendanceMaster A,EmployeeMaster E where A.AttendanceDate = '".$range."'  $s and A.AttendanceStatus in (2,6,7) AND E.Id=A.EmployeeId AND E.archive = 1 and A.OrganizationId = ".$org_id);
				}
				
				foreach($query->result() as $row)
				 {
						   $data=array();
							$name= ucwords(getEmpName($row->EmployeeId));
							if($name != "")
							{
							$data['FirstName'] = $name;
							$data['code'] = $row->EmployeeCode;
							$data['absentdate']=date('M d,Y',strtotime($row->AttendanceDate));
							
							$Tio=getShiftTimes($row->ShiftId);
							$data['shift']=getShift($row->ShiftId). " (".$Tio.")";
							if(strtotime($range) == strtotime($todate))
							{
								$data['device']=' - ';
							}
							else
							{
								$data['device']=$row->device;
							}
							$data['desg']=ucwords(getDesignationByEmpID($row->EmployeeId));
							$data['deprt']=ucwords(getDepartmentByEmpID($row->EmployeeId));
							
							$res[]=$data;
							}
							
				 }
		     
		  }
	
		$d['data']=$res;  //$query->result();
		//print_r($d['data']);
		$this->db->close();
		echo json_encode($d); return false;
		 }
		  
		/// New  Absent Reports By sohan
    public function getAbsent__new()
	  {
			 $org_id=$_SESSION['orgid'];
			 $date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
			 $shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:0;
			 $deprtid=isset($_REQUEST['deprt'])?$_REQUEST['deprt']:0;
			// echo $deprtid;
			 $emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:0;
			 $desgid=isset($_REQUEST['desg'])?$_REQUEST['desg']:0;
			 $res = array();
			    $startdate="";
				$enddate="";
				$s='';
				$s1='';
			if($date=='') 
			{
				 $datestatus=isset($_REQUEST['datestatus'])?$_REQUEST['datestatus']:0;
				 if($datestatus == 7)
				 {
				 // $enddate=date('Y-m-d');//,(strtotime ( "-1 day",strtotime(date('Y-m-d'))) ));
				 	$enddate=date('Y-m-d');
				//echo  $enddate;
				  $startdate=date('Y-m-d', strtotime('-6 day', strtotime($enddate)));
				// echo  $startdate;
				 }
				 
				 else
				 {
				   $enddate=date("Y-m-d");
				   $startdate=date("Y-m-d");
				 }
			}
			if($shiftid!=0)
			{
				$s=" AND ShiftId='$shiftid' ";
				$s1 =" AND Shift='$shiftid' ";
				
			} 
			if($deprtid != 0)
			{
				$s .= " AND `Dept_id` = '$deprtid' ";
				$s1 .= " AND `Department`='$deprtid' ";
			}
			if($emplid!=0)
			{
				$s1 .=" AND E.Id='$emplid' ";
			    $s .= "AND EmployeeId = '$emplid'";
			}
			if($desgid!=0)
			{
				$s .=" AND `Desg_id`='$desgid' ";
				$s1 .=" AND `Designation`='$desgid' ";
			}
			if($date != '')
			{
				$arr= explode('-', trim($date));
				$enddate= date('Y-m-d',strtotime($arr[1]));
				$startdate= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3)));
			}
			$begin = new DateTime($startdate);
			$interval = new DateInterval('P1D'); // 1 Day
			$realEnd = new DateTime($enddate);
			$realEnd->add($interval);
			$dateRange = new DatePeriod($begin,$interval,$realEnd);	
			$range = "";
			//set time zone
		     	$zname=getTimeZone($org_id);
				date_default_timezone_set ($zname);
				$todate = date('Y-m-d');
				//date_default_timezone_set ($zname);
				$time = date("H:i:s");
				$i = 0;
		 foreach ($dateRange as $date) 
		  {
		        $range = $date->format('Y-m-d');
				$query = "";
				//print_r($range);
			 if(strtotime($range) == strtotime($todate))//fetch data today
				{
					$query = $this->db->query("Select '-' as device, E.Id as EmployeeId,E.EmployeeCode,E.Shift as ShiftId ,'".$todate."' as AttendanceDate FROM EmployeeMaster E,ShiftMaster S Where  E.Id NOT IN (select A.EmployeeId From AttendanceMaster A where A.AttendanceDate= '".$todate."'  AND  A.OrganizationId= ".$org_id." AND AttendanceStatus  IN (1,8,4) ) $s1 AND E.OrganizationId = ".$org_id ." AND E.Shift = S.Id AND S.TimeIn < '$time'  AND E.archive = 1   group By EmployeeId");
				}
				else
				{
					
				//echo $range;
				$query = $this->db->query("Select A.device,E.Id,E.EmployeeCode,A.EmployeeId,A.AttendanceDate,A.ShiftId FROM AttendanceMaster A,EmployeeMaster E where A.AttendanceDate = '".$range."'  $s and A.AttendanceStatus in (2,6,7) AND E.Id=A.EmployeeId AND E.Is_Delete = 0 AND  A.OrganizationId = ".$org_id);
				//echo $this->db->last_query();
				}
				
				foreach($query->result() as $row)
				 {
						   $data=array();
							$name= ucwords(getEmpName($row->EmployeeId));
							if($name != "")
							{
							$data['FirstName'] = $name;
							$data['code'] = $row->EmployeeCode;
							$data['absentdate']=date('M d,Y',strtotime($row->AttendanceDate));
							
							$Tio=getShiftTimes($row->ShiftId);
							$data['shift']=getShift($row->ShiftId). " (".$Tio.")";
							if(strtotime($range) == strtotime($todate))
							{
								$data['device']=' - ';
							}
							else
							{
								$data['device']=$row->device;
							}
							$data['desg']=ucwords(getDesignationByEmpID($row->EmployeeId));
							$data['deprt']=ucwords(getDepartmentByEmpID($row->EmployeeId));
							$res[]=$data;
							}
							
				 }
		     
		  }
	
		$d['data']=$res;  //$query->result();
		//print_r($d['data']);
		$this->db->close();
		echo json_encode($d); return false;

	}
		
		
		
	//// AbsentRports	
	public function getAbsent(){
		    $org_id=$_SESSION['orgid'];
			//$org_id=10;
			 $date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
			 $shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:0;
			 $deprtid=isset($_REQUEST['deprt'])?$_REQUEST['deprt']:0;
			 $emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:0;
			 $desgid=isset($_REQUEST['desg'])?$_REQUEST['desg']:0;
			  $q="";
			  $s="";
			 // echo $deprtid;
			$startdate="";
			$enddate="";
			if($date=='')
			{
				 $enddate=date("Y-m-d");
				 $startdate=date("Y-m-d");
		        // $startdate=date('Y-m-d',(strtotime ( '-7 day',strtotime(date('Y-m-d'))) ));
			}
			if($shiftid!=0)
			{
				$s=" AND `Shift`='$shiftid' ";
			
			} 
			if($deprtid!=0)
			{
				$s.=" AND `Department`='$deprtid' ";
			
			}
			if($emplid!=0)
			{
				$s.=" AND `Id`='$emplid' ";
			
			}
			if($desgid!=0)
			{
				$s.=" AND `Designation`='$desgid' ";
			
			}
			if($date!='')
			{
				$arr= explode('-', trim($date));
				$enddate= date('Y-m-d',strtotime($arr[1]));
				$startdate= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3)));
			}	
		$begin = new DateTime($startdate);
		$begin = new DateTime($startdate);
		$interval = new DateInterval('P1D'); // 1 Day
		$realEnd = new DateTime($enddate);
		//$begin->add($interval);
		 $realEnd->add($interval);
		$dateRange = new DatePeriod($begin,$interval,$realEnd);
				
		$range = "";
	
    foreach ($dateRange as $date) 
	   {
			$dt= $date->format('Y-m-d');
		     //---managing off (weekly and holiday)
				$query = $this->db->query("SELECT `DateFrom`, `DateTo` FROM `HolidayMaster` WHERE OrganizationId=? and (? between `DateFrom` and `DateTo`) ",array($org_id,$dt));
			   if($query->num_rows()>0)
			   continue;
					// Day of month : 1 sun 2 mon --
				
			     $dayOfWeek = 1 + date('w',strtotime($dt));
			   
			     $weekOfMonth =weekOfMonth($dt);
					// $weekOfMonth =Weeks($dt);
				if($weekOfMonth<=-1){
				$weekOfMonth= -1*($weekOfMonth); 
				}
					 
					$week='';
					$query = $this->db->query("SELECT `WeekOff` FROM  `WeekOffMaster` WHERE  `OrganizationId` =? AND  `Day` =  ?",array($org_id,$dayOfWeek));	
					if($row=$query->result()){
					$week =	explode(",",$row[0]->WeekOff);
				//	print_r ($week);
					}
					// $range = $dt;
					if($weekOfMonth<=5){
					if($week[$weekOfMonth-1]==1)
						
						continue;
						
					}
					
				//-----managing off (weekly and holiday) - close
		
			if($range=="")
			$range = "'".$date->format('Y-m-d')."'";
	
		else
			$range.= ",'".$date->format('Y-m-d')."'";
		}
	
      $rangedate = $range;
	
	 if($rangedate==""){
	        $rangedate = 1;	
	     } 
		 
    //$date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
   $q2="select (select count(EmployeeMaster.Id)-count(AttendanceMaster.Id) from EmployeeMaster where OrganizationId =".$org_id."  ) as total, AttendanceDate,AttendanceStatus from AttendanceMaster where AttendanceDate 	IN ( ".$rangedate." ) AND OrganizationId =".$org_id."  group by AttendanceDate";
	 $query = $this->db->query($q2);
	// echo $q2;
		$d=array();
		$res=array();
			foreach($query->result() as $row){
				 '<br/>total: '.$row->total.'  date: '.$row->AttendanceDate .'<br/>';
					$query1 = $this->db->query("SELECT Id as EmployeeId ,FirstName,Shift,Department,Designation, Id ,'".$row->AttendanceDate ."' as absentdate
							,'".$row->AttendanceStatus ."' as status FROM  `EmployeeMaster` 
							WHERE EmployeeMaster.OrganizationId =".$org_id."
							$s AND archive=1 and IF( EmployeeMaster.CreatedDate!='0000-00-00 00:00:00', CreatedDate < '".$row->AttendanceDate ."', 1) and  Id 
							NOT IN (
							SELECT `EmployeeId` 
							FROM   `AttendanceMaster` 
							WHERE  `AttendanceDate` 
							IN (
							 '".$row->AttendanceDate ."'
							)
							AND AttendanceMaster.OrganizationId =".$org_id."
							AND `AttendanceStatus` not in(3,5,6)
							)
							ORDER BY EmployeeMaster.Id ");
						  //json_encode($query1->result());
							$count=$query1->num_rows();
				 foreach ($query1->result() as $row)
				  {
					$data=array();
				    //$data['name']=ucwords(getEmpName($row->Id));
					$data['FirstName']= getEmpName($row->EmployeeId);
				    $data['absentdate']=date('d-M-Y',strtotime($row->absentdate));
				    // $data['absentdate']= date('d/m/Y',strtotime($row->absentdate))." Absent Employee :".$count;
				    $Tio=getShiftTimes($row->Shift);
				    ///$To=getShiftTimes($row->ShiftId);
				    $data['shift']=getShift($row->Shift). " (".$Tio.")";
					$data['desg']=ucwords(getDesignationByEmpID($row->EmployeeId));
				    $data['deprt']=ucwords(getDepartmentByEmpID($row->EmployeeId));
					$data['conutrow']=$count;
					$data['status'] = $row->status;
					$data['date']= $date;
					$res[]=$data;
				}
			  }
				$d['data']=$res;  				//$query->result();
				 $this->db->close();
				echo json_encode($d); return false;
		}
	 ///Reports starts from here...Added by Surbhi :)
	 
	 /////Absentees
	/* 
	 public function getAbsent(){
		    $org_id=$_SESSION['orgid'];
			//$org_id=10;
			 $date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
			 $shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:0;
			 $deprtid=isset($_REQUEST['deprt'])?$_REQUEST['deprt']:0;
			 $emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:0;
			 $desgid=isset($_REQUEST['desg'])?$_REQUEST['desg']:0;
			  $q="";
			  $s="";
			 // echo $deprtid;
			$startdate="";
			$enddate="";
		
			
			if($shiftid!=0)
			{
				$s.=" AND  EmployeeId IN( SELECT `Id` FROM `EmployeeMaster` 
			  WHERE `Shift` = '$shiftid' ) ";
			
			} 
			if($deprtid!=0)
			{
				$s.=" AND  EmployeeId IN( SELECT `Id` FROM `EmployeeMaster` 
			  WHERE `Department` = '$deprtid' ) ";
			
			}
			if($emplid!=0)
			{
				$s.=" AND `EmployeeId`='$emplid' ";
			
			}
			if($desgid!=0)
			{
				$s.=" AND  EmployeeId IN( SELECT `Id` FROM `EmployeeMaster` 
			  WHERE `Designation` = '$desgid' ) ";
			
			}
			
			 if($date==''){
                 //$date=$today=date('Y-m-d');
				 $enddate=date("Y-m-d");
				 //$d = date('d')-7;
				 $startdate=date('Y-m-d',(strtotime ( "-7 day",strtotime(date('Y-m-d'))) ));
				 //$q=" AND  `AttendanceDate` BETWEEN  '$startdate' AND '$enddate' ";
				 echo "SELECT *  FROM  `AttendanceMaster` WHERE    OrganizationId =".$org_id."  AND `AttendanceStatus` in(3,5,6)  AND `AttendanceDate` BETWEEN  '$startdate' AND '$enddate'  $s  ORDER BY `AttendanceDate`";
				 return false;
				 
				 $query1 = $this->db->query("SELECT *  FROM  `AttendanceMaster` WHERE    OrganizationId =".$org_id."  AND `AttendanceStatus` in(3,5,6)  AND `AttendanceDate` BETWEEN  '$startdate' AND '$enddate'  $s  ORDER BY `AttendanceDate`" );
			}
			else{
				$arr=explode('-', trim($date));
				$end= date('Y-m-d',strtotime($arr[1]));
				$strt= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3))); 
				//echo strlen(trim($arr[0]));
				$begin = new DateTime($strt);
				$interval = new DateInterval('P1D'); // 1 Day
	            $realEnd = new DateTime($end);
	            //$begin->add($interval);
                $realEnd->add($interval);
                $dateRange = new DatePeriod($begin,$interval,$realEnd);
			
                $range = "";
			   foreach ($dateRange as $date) 
	             {
		
			    $dt= $date->format('Y-m-d');
		            //---managing off (weekly and holiday)
				$query = $this->db->query("SELECT `DateFrom`, `DateTo` FROM `HolidayMaster` WHERE OrganizationId=? and (? between `DateFrom` and `DateTo`) ",array($org_id,$dt));
			   if($query->num_rows()>0)
			   continue;
					//	day of month : 1 sun 2 mon --
			   $dayOfWeek = 1 + date('w',strtotime($dt));
			   $weekOfMonth =weekOfMonth($dt);
					 //$weekOfMonth =Weeks($dt);
					 
				if($weekOfMonth<=-1){
				$weekOfMonth= -1*($weekOfMonth); 
				}
					 
					$week='';
					$query = $this->db->query("SELECT `WeekOff` FROM  `WeekOffMaster` WHERE  `OrganizationId` =? AND  `Day` =  ?",array($org_id,$dayOfWeek));	
					if($row=$query->result()){
					$week =	explode(",",$row[0]->WeekOff);
					//print_r ($week);
					}
					// $range = $dt;
					if($weekOfMonth<=5){
					if($week[$weekOfMonth-1]==1)
						
						continue;
						
					}
					
				//-----managing off (weekly and holiday) - close
		
		if($range=="")
        $range = "'".$date->format('Y-m-d')."'";
	
	    else
		$range .= ",'".$date->format('Y-m-d')."'";
    }
	    $rangedate = $range;
	
	    // print_r ($range);
   
	    if($rangedate==""){
	
	     $rangedate = 1;
		
	   }// echo "SELECT *  FROM  `AttendanceMaster` WHERE    OrganizationId =".$org_id."  AND `AttendanceStatus` in(3,5,6) AND `AttendanceDate` IN ( ".$rangedate." )  $s  ORDER BY `AttendanceDate`";
	   ;
        $query1 = $this->db->query("SELECT *  FROM  `AttendanceMaster` WHERE    OrganizationId =".$org_id."  AND `AttendanceStatus` in(3,5,6) AND `AttendanceDate` IN ( ".$rangedate." )  $s  ORDER BY `AttendanceDate`");
				
			}    
		         $count=$query1->num_rows();
				 $d=array();
			     $res=array();
				 foreach ($query1->result() as $row)
				{
					$data=array();
				    //$data['name']=ucwords(getEmpName($row->Id));
					$data['FirstName']=getEmpName($row->EmployeeId);
				    $data['absentdate']=date('d/m/Y',strtotime($row->	AttendanceDate));
				    // $data['absentdate']= date('d/m/Y',strtotime($row->absentdate))." Absent Employee :".$count;
				    $Tio=getShiftTimes($row->ShiftId);
				    ///$To=getShiftTimes($row->ShiftId);
				    $data['shift']=getShift($row->ShiftId). " (".$Tio.")";
					$data['desg']=ucwords(getDesignationByEmpID($row->EmployeeId));
				    $data['deprt']=ucwords(getDepartmentByEmpID($row->EmployeeId));
					$data['conutrow']=$count;
					$data['date']=$date;
					$res[]=$data;
				}
			
				
				 $d['data']=$res;  	
             	 $this->db->close();			//$query->result();
				 echo json_encode($d); return false;
		}
*/
	public function getDepartmentReport(){
			$orgid=$_SESSION['orgid'];
				$date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
	            $shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:'';
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
							 //$d = date('d')-1;
							 $startdate=date('Y-m-d',(strtotime ( "-7 day",strtotime(date('Y-m-d'))) ));
							 $q=" AND  `AttendanceDate` BETWEEN  '$startdate' AND '$enddate' ";
						}
		//////////////////////////////////////////////////////////////////////////
		        $q1 = '';
				 
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
				 $sql = "select Id, CONCAT(FirstName,' ',LastName)AS name,Designation, Department, Shift FROM EmployeeMaster WHERE OrganizationId =? $q1 AND DOL='0000-00-00' ORDER BY Department";
		  
			$query = $this->db->query($sql,array($orgid));
			 $d=array();
			 $res=array();
			foreach ($query->result() as $row)
			 {	
			 	$emplid = $row->Id;
			 	$depart = $row->Department;
				
			 	/* $sql1=$this->db->query("SELECT A.AttendanceDate as date,A.ShiftId as shift,A.TimeIn as Atimein,A.TimeOut as Atimeout,C.TimeIn as Stimein,C.TimeOut as Stimeout,CASE WHEN (A.TimeIn > C.TimeIn) THEN (TIMEDIFF(A.TimeIn,C.TimeIn)) ELSE('-') END as late,CASE WHEN (A.TimeOut < C.TimeOut) THEN (SUBSTRING(TIMEDIFF(A.TimeOut,C.TimeOut),2,5)) ELSE('-') END as early,(SELECT Name FROM DepartmentMaster WHERE Id=$depart ORDER BY  Name)as department FROM AttendanceMaster A,ShiftMaster C WHERE A.EmployeeId = ($emplid) AND A.TimeIn !='0000:00:00' AND A.TimeOut !='0000:00:00' AND A.OrganizationId = $orgid $q AND C.OrganizationId= $orgid AND C.Id = A.ShiftId"); */
				
				
				
				$sql1 = $this->db->query("SELECT  A.ShiftId as shift, A.AttendanceDate as atdate,C.shifttype as ctype,A.TimeIn as timein,A.TimeOut as timeout,C.TimeIn as ctimein,C.TimeOut as ctimeout,C.Name as cname, CASE WHEN(A.TimeIn > C.TimeIn) THEN (TIMEDIFF(A.TimeIn,C.TimeIn)) ELSE ('-') END as late, CASE WHEN(A.TimeOut < C.TimeOut) THEN (TIMEDIFF(C.TimeOut,A.TimeOut)) ELSE ('-') END as early FROM AttendanceMaster A,ShiftMaster C WHERE  C.Id = A.ShiftId $q  AND A.EmployeeId = $emplid AND A.OrganizationId = $orgid AND A.TimeIn != '00:00:00' AND A.TimeOut != '00:00:00'");
				
			 	foreach($sql1->result() as $row1)
			 	{	
				$data=array();					
					$data['date']=date('d/m/Y',strtotime($row1->atdate));
					$data['Name']=ucwords($row->name);				    
				    $Tio=getShiftTimes($row1->shift);
					$data['shift']= getShift($row1->shift)."(".$Tio.")";
					$data['TimeIn']=(substr($row1->timein,0,5));
					$data['lateBy']= substr($row1->late,0,5);
					$data['TimeOut']= substr($row1->timeout,0,5);
					//$data['earlyby']= ($row1->early);
					/////////////////////
					if(strtotime($row1->timeout)<strtotime($row1->ctimeout))
						{
						  $data['earlyby'] = substr($row1->early,0,5);	
						}
						else
						{
						if(strtotime($row1->timeout) > strtotime($row1->ctimeout) && strtotime($row1->ctimein) > strtotime($row1->ctimeout) && strtotime($row1->timein) <= strtotime($row1->timeout) )
							{
								 $time = "24:00:00";
								 $secs = strtotime($row1->timeout)-strtotime($row1->ctimeout);
								 $data['earlyby'] = date("H:i",strtotime($time)-$secs); 
							}
							else
							{
								$data['earlyby'] = "-";
							}
							
						}
					
					/////////////////////
					
					//$data['overunder']= $this->gatoveundertime($emplid,$row1->atdate);
					/////////////////////////////////
					if(strtotime($row1->timein) <= strtotime($row1->timeout) && strtotime($row1->ctimein) <= strtotime($row1->ctimeout) )
						$data['overunder']= $this->gatoveundertime($emplid,$row1->atdate);
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
								 $data['overunder']= $interval->format("%H:%I");	
								}
								else
								{
								  $interval = $b->diff($a);
								  $a = new DateTime($interval->format("%H:%I"));
								  $b = new DateTime(getShiftBreak($row1->shift));
								  $interval1 = $b->diff($a);
								  $data['overunder']= "-".$interval1->format("%H:%I");			
								}
								
                         }
					///////////////////
					$data['timeoff']=$this->TimeOfff($emplid,$row1->atdate);
				  //$data['Totaltime']=$this->gatworkinghour($emplid,$row1->atdate);	
                     /////////////////////// working hours calculation
                        if(strtotime($row1->timein) <= strtotime($row1->timeout))
						$data['Totaltime']= $this->gatworkinghour($emplid ,$row1->atdate);
					    else
						{
								$time = "24:00:00";
								$secs = strtotime($row1->timein)-strtotime($row1->timeout);
								$data['var'] = date("H:i",strtotime($time)-$secs);
								$a = new DateTime($data['var']);
								$b = new DateTime(getShiftBreak($row1->shift));
								$interval = $b->diff($a);
								$data['Totaltime']= $interval->format("%H:%I");	
						}					 
                     ///////////////////////					
				    $data['depart']= getDepartment($row->Department);
					$res[]=$data;
				}					
			} 
             $d['data']=$res; 
             $this->db->close();			//$query->result();
			echo json_encode($d); 
			return false;
	}
	
	function TimeOfff($empid,$date)
		{
			$org_id = $_SESSION['orgid'];
			//$currentdate = date("y-m-d");
			$query = $this->db->query("SELECT ( TIMEDIFF(T.TimeTo,T.TimeFrom) )as time FROM Timeoff T WHERE T.EmployeeId = ($empid) AND T.OrganizationId= $org_id AND TimeofDate= '$date'  AND T.TimeFrom < T.TimeTo AND T.TimeFrom != '00:00:00' AND T.TimeTo != '00:00:00'  ");
		     if( $row = $query->result_array())
			 {
				  if($row[0]["time"] == null)
				  {
					return "-";  
				  } 
			     else
				 {
					 return (substr($row[0]["time"],0,5) ); 
				 } 
			 }
			 else
			 {
				return "-"; 
			 }
		}
  public function calculatetimeoff($empid,$date)
      {
	        $org_id = $_SESSION['orgid'];
			$query = $this->db->query("SELECT (TIMEDIFF(T.TimeTo,T.TimeFrom))as time FROM Timeoff T,AttendanceMaster A WHERE T.EmployeeId = ($empid) AND T.OrganizationId= '$org_id' AND TimeofDate= '$date'  AND T.TimeFrom < T.TimeTo AND T.TimeFrom != '00:00:00' AND T.TimeTo != '00:00:00' AND A.AttendanceDate='$date' AND A.EmployeeId='$empid' AND A.OrganizationId='$org_id' AND A.TimeIn <= T.TimeFrom AND A.TimeOut >= T.TimeTo AND  A.TimeIn != '00:00:00' AND A.TimeOut != '00:00:00' and T.ApprovalSts NOT IN (1,3,4,5,7)");
		     if($row = $query->result_array())
			 {
				  if($row[0]["time"] == null)
				  {
					return "00:00";  
				  } 
			     else
				 {
					return ( substr($row[0]["time"],0,5) ); 
				 } 
			 }
			 else
			 {
				return "00:00"; 
			 }
  }
  public function  timeoffmonthly($empid,$date)
      {
	        $org_id = $_SESSION['orgid'];
			$query = $this->db->query("SELECT T.TimeFrom as timefrom ,T.TimeTo as timeto  FROM Timeoff T,AttendanceMaster A WHERE T.EmployeeId = ($empid) AND T.OrganizationId= '$org_id' AND TimeofDate= '$date'   AND A.AttendanceDate='$date' AND A.EmployeeId='$empid' AND A.OrganizationId='$org_id'");
		     if($row = $query->result_array())
			 {
			return (substr($row[0]["timefrom"],0,5)."-".substr($row[0]["timeto"],0,5) ); 
			 }
			 else
			 {
				return "00:00"; 
			 }
  }
	public function getattRoaster(){
		        $orgid=$_SESSION['orgid'];
				 $res = array();
                 $result = array();
				$date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
	            $shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:'';
		        $deprtid=isset($_REQUEST['deprt'])?$_REQUEST['deprt']:'';
			    $emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:'';
			    // var_dump($emplid);
			    $desgid=isset($_REQUEST['desg'])?$_REQUEST['desg']:'';
			    $areaid=isset($_REQUEST['areaid'])?$_REQUEST['areaid']:'';
				  $q = "";
				  $startdate='';
				  $enddate='';
				  $d = 0;
				  
						$de = "";
						if($date != '')
						{   
					     $date1 = '01-'.$date;
						 $de = date('Y-m-t',strtotime($date1));
						}
						else
						{
							$de = date('Y-m-d');
						}
						
		//////////////////////////////////////////////////////////////////////////
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
				if($areaid!=0)
				{
					$q1.=" AND `area_assigned`='$areaid' ";
				}
          /////////////////////////////////////////////////////////////////////////	AND DOJ != '0000-00-00' AND  DOJ <= '$de'  AND (DOL='0000-00-00' OR DOL >='$de' )
        $sql = $this->db->query("SELECT Id,CONCAT(Firstname,' ',Lastname) as name,EmployeeCode,DOL,DOC,DOJ,Shift  from EmployeeMaster where OrganizationId=? $q1  and  archive = '1' AND Is_Delete = 0  order by Firstname",array($orgid));
		
         $dateval = array();
        foreach($sql->result() as $rows)
         {  
			//$DOJ = $rows->DOJ;
		   $present = 0;
		   $absent = 0;
		   $weekoff = 0;
		   $holyday = 0;
		   $halfday = 0;
		   $leave = 0;
           if($date != '')
						{   
					         //$date = date('m-Y',strtotime($date));
							$arr=explode('-',$date);
							$d=cal_days_in_month(CAL_GREGORIAN,$arr[0],$arr[1]);
							$a = $d."-".$date;
							$b = "01-".$date;
							$enddate= date('Y-m-d',strtotime($a));
							$startdate= date('Y-m-d',strtotime($b)); 
							//echo strlen(trim($arr[0]));
						   $q ="AND `AttendanceDate` BETWEEN  '$startdate' AND '$enddate' ";
						}
						else
						{
							$enddate=date('Y-m-t');	
							$startdate=date('Y-m-01');
							$q=" AND  `AttendanceDate` BETWEEN  '$startdate' AND '$enddate' ";
						}
						
		        $dateval = array();
		        $data =  array();
				
		  		$emplid = $rows->Id;
				$shiftid = $rows->Shift;
		 		$data['name']= ucwords($rows->name);
				if($rows->EmployeeCode != "")
				$data['empcode'] = $rows->EmployeeCode;
			    else
				$data['empcode'] = "-";
			
				$temp= array();
				//$temp1329= array();
		       
				$flage = false;
				
		while( $startdate <= $enddate)
			{
				
			 $dateval[] =date('dS M',strtotime($startdate));
             $flage = true;	
		   $query = $this->db->query("SELECT TimeIn,TimeOut,AttendanceStatus,AttendanceDate FROM AttendanceMaster WHERE OrganizationId=? AND AttendanceDate='$startdate' AND EmployeeId=?  limit 1",array($orgid,$emplid));
		   // var_dump($this->db->last_query());
		   // die;

		   $n = $this->db->affected_rows();
		   if($n>0)
		   foreach($query->result() as $row)
		   {
			//$data['name']=ucwords(getEmpName($row->EmployeeId));
			$sts = $row->AttendanceStatus;
			$symbol = "";
			$title = "";
			if($sts == 1)
			{
				if($row->TimeOut=='00:00:00')
				{
				$present++;
				$symbol='P*';
				}
				else
				{
				$present++;
				$symbol="P";
				
				}
				
			}
			else if($sts == 2){
				$symbol = 'A';
				$absent++;
		
		
			}
			else if($sts == 3 )
			{
				 if($row->TimeIn!='00:00:00')
				 {
					$present++;
					$symbol="P/WO";	
			
				 }
				 else
				 {
				   $symbol = 'WO';
				   $weekoff++;
				  
				 }
		   
			}else if($sts == 4)
			{	
				$halfday++;
				$symbol = 'HD';
				 
				
			}
			else if($sts == 5){
				$symbol = 'H';
		        $holyday++;
				
		       
			}else if($sts == 6 || $sts == 9){
				$symbol = 'L';
		        $leave++;
				
		       
			}else if($sts == 7){
				$symbol = "CO";
				
				
			}
			else if($sts == 8){
				$symbol = "WFH";
				
				
			}
			else
				 $symbol = "-";
			$temp[] = $symbol;
		}
		 
			 else
			 {
				  
					if(date('Y-m-d')>$startdate)
					{
						 $t = $this->getweeklyoff($startdate,$shiftid,$emplid);
						 $temp[] = $t;
						 
					  if($t=="WO")
					  {
						
						$weekoff++;
						
					  }
					  else if($t=="H")
					  {
						$holyday++;
					  }
					  
					  
					}
					
					 else
					 
					$temp[]= "-"; 
				
					 

					

			 }
			 $startdate = date('Y-m-d', strtotime($startdate . ' +1 days'));
		  }
		   if($flage)
		   {
			     $dateval[] = 'Total Present';
			     $dateval[] = 'Total Absent';
			     $dateval[] = 'Weekly Offs';
			     $dateval[] = 'Total Holiday';
			     $dateval[] = 'Total Half Day';
			     $dateval[] = 'Total Leave';
		       
				 $temp[] = $present;
				 $temp[] = $absent;
				 $temp[] = $weekoff;
				 $temp[] = $holyday;
				 $temp[] = $halfday;
				 $temp[] = $leave;
		   }
		  
		  $data['sts']=$temp;
		  
		  $res[] = $data;
		  // var_dump($data['sts']);
		}
		$result['data']= $res;
	
		$result['date']= $dateval;
	    return($result);
	}
	/*public function getattRoaster(){
		        $orgid=$_SESSION['orgid'];
				 $res = array();
                 $result = array();
				$date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
	            $shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:'';
		        $deprtid=isset($_REQUEST['deprt'])?$_REQUEST['deprt']:'';
			    $emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:'';
			    $desgid=isset($_REQUEST['desg'])?$_REQUEST['desg']:'';
				  $q = "";
				  $startdate='';
				  $enddate='';
				  $d = 0;
				  
						$de = "";
						if($date != '')
						{   
					     $date1 = '01-'.$date;
						 $de = date('Y-m-t',strtotime($date1));
						}
						else
						{
							$de = date('Y-m-d');
						}
						
		//////////////////////////////////////////////////////////////////////////
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
				
          /////////////////////////////////////////////////////////////////////////	AND DOJ != '0000-00-00' AND  DOJ <= '$de'  AND (DOL='0000-00-00' OR DOL >='$de' )
        $sql = $this->db->query("SELECT Id,CONCAT(Firstname,' ',Lastname) as name,EmployeeCode,DOL,DOC,DOJ,Shift  from EmployeeMaster where OrganizationId=? $q1  and  archive = '1' AND Is_Delete = 0  order by Firstname",array($orgid));
		
         $dateval = array();
        foreach($sql->result() as $rows)
         {  
			//$DOJ = $rows->DOJ;
		   $present = 0;
		   $absent = 0;
		   $weekoff = 0;
		   $holyday = 0;
		   $halfday = 0;
		   $leave = 0;
           if($date != '')
						{   
					         //$date = date('m-Y',strtotime($date));
							$arr=explode('-',$date);
							$d=cal_days_in_month(CAL_GREGORIAN,$arr[0],$arr[1]);
							$a = $d."-".$date;
							$b = "01-".$date;
							$enddate= date('Y-m-d',strtotime($a));
							$startdate= date('Y-m-d',strtotime($b)); 
							//echo strlen(trim($arr[0]));
						   $q ="AND `AttendanceDate` BETWEEN  '$startdate' AND '$enddate' ";
						}
						else
						{
							$enddate=date('Y-m-t');	
							$startdate=date('Y-m-01');
							$q=" AND  `AttendanceDate` BETWEEN  '$startdate' AND '$enddate' ";
						}
						
		        $dateval = array();
		        $data =  array();
				$temp1=array();
		  		$emplid = $rows->Id;
				$shiftid = $rows->Shift;
		 		$data['name']= ucwords($rows->name);
				if($rows->EmployeeCode != "")
				$data['empcode'] = $rows->EmployeeCode;
			    else
				$data['empcode'] = "-";
			
				$temp= array();
				//$temp1329= array();
		       
				$flage = false;
				
		while( $startdate <= $enddate)
			{
				 $temp1= array();
			 $dateval[] =date('dS M',strtotime($startdate));
             $flage = true;	
		   $query = $this->db->query("SELECT TimeIn,TimeOut,AttendanceStatus,AttendanceDate FROM AttendanceMaster WHERE OrganizationId=? AND AttendanceDate='$startdate' AND EmployeeId=?  limit 1",array($orgid,$emplid));
		   $n = $this->db->affected_rows();
		   if($n>0)
		   foreach($query->result() as $row)
		   {
			//$data['name']=ucwords(getEmpName($row->EmployeeId));
			$sts = $row->AttendanceStatus;
			$symbol = "";
			$title = "";
			if($sts == 1)
			{
				if($row->TimeOut=='00:00:00')
				{
				$present++;
				$symbol='P*';
				$title = "Present";
				}
				else
				{
				$present++;
				$symbol="P";
				$title = "Present";
				}
				
			}
			else if($sts == 2){
				$symbol = 'A';
				$absent++;
			$title = "Absent";
		
			}
			else if($sts == 3)
			{
				 if($row->TimeIn!='00:00:00')
				 {
					$present++;
					$symbol="P/WO";	
				$title = "Present/Weekoff";
				 }
				 else
				 {
				   $symbol = 'WO';
				   $weekoff++;
				   $title = "Weekoff";
				 }
		   
			}else if($sts == 4)
			{	
				$halfday++;
				$symbol = 'HD';
				 $title = "Half day";
				
			}
			else if($sts == 5){
				$symbol = 'H';
		        $holyday++;
				$title = "Holiday";
		       
			}else if($sts == 6){
				$symbol = 'L';
		        $leave++;
				$title = "Leaves";
		       
			}else if($sts == 7){
				$symbol = "CO";
				$title = "co";
				
			}
			else if($sts == 8){
				$symbol = "WFH";
				$title = "Work From Home";
				
			}
			else
			{
				 $symbol = "N/A";  
					 $title='Not Available';
			}
			 $temp1['symbol'] = $symbol;
			 $temp1['title'] = $title;
			 $temp[]=$temp1;
		}
		 
			 else
			 {
				  $symbol = "";
			      $title = "";
				   $temp1=array();
					if(date('Y-m-d')>$startdate)
					{
						 $t = $this->getweeklyoff($startdate,$shiftid,$emplid);
						 $temp1['symbol'] = $t;
						 
					  if($t=="WO")
					  {
						$symbol = "WO";
						$weekoff++;
						$title='Week Off';
					  }
					  else if($t=="H")
					  {
						$symbol = "H";  
						$holyday++;
						$title='Holiday';
					  }
					  else
					  {
					$symbol = "N/A";  
					 $title='Not Available';  
					  }
					  
					}
					
					 else
					 {
					 $symbol = "N/A";  
					 $title='Not Available';
					 }
					 $temp1['symbol'] = $symbol;
				$temp1['title'] = $title;
					$temp[] = $temp1; 
					 

					

			 }
			 $startdate = date('Y-m-d', strtotime($startdate . ' +1 days'));
		  }
		   if($flage)
		   {
			     $dateval[] = 'Total Present';
			     $dateval[] = 'Total Absent';
			     $dateval[] = 'Total Week Offs';
			     $dateval[] = 'Total Holidays';
			     $dateval[] = 'Total Half Days';
			     $dateval[] = 'Total Leaves';
		         $temp1['symbol'] = $present; 
				 $temp1['title'] ="";
				 $temp[] = $temp1;
				 
		        $temp1['symbol'] = $absent;
                $temp1['title'] ="";				
				$temp[] = $temp1;
				
		         $temp1['symbol'] = $weekoff;
				 $temp1['title'] ="";
				 $temp[] = $temp1;	
					
		         $temp1['symbol'] = $holyday;
				 $temp1['title'] ="";
				 $temp[] = $temp1;
				 
		        $temp1['symbol']= $halfday;
				$temp1['title'] ="";
				$temp[] = $temp1;
				
		         $temp1['symbol']= $leave;
				 $temp1['title'] ="";
				 $temp[] = $temp1;
				
				
					
		   }
		  
		  $data['sts']=$temp;
		  
		  $res[] = $data;
		}
		$result['data']= $res;
		//print_r($result['data']);
		$result['date']= $dateval;
	    return($result);
	}*/
 
  public function getattRoastermonthly_count()
  {
	  $orgid=$_SESSION['orgid'];
	$res 	= 	array();
    $result = 	array();
	$date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
	$emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:'';
	$deprtid=isset($_REQUEST['deprt'])?$_REQUEST['deprt']:'';
	$shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:'';
	//echo $deprtid;
		$q = "";
		$startdate='';
		$enddate='';
						$d = 0;
						$de = "";
						if($date != '')
						{
					        $date1 = '01-'.$date;
							$de = date('Y-m-t',strtotime($date1));
						}
						else
						{
							$de = date('Y-m-d');
						}
		//////////////////////////////////////////////////////////////////////////
				$q1 = '';
				if($emplid!=0)
				{
					$q1.=" AND `id`='$emplid'";
				}
				if($deprtid!=0)
				{
					 $q1.=" AND `Department` = '$deprtid' ";
				}
				if($shiftid!=0)
				{
			     $q1.= " AND `Shift`='$shiftid' ";
			    }
				$sql = $this->db->query("SELECT count(Id) as Totalemp from EmployeeMaster where OrganizationId=? $q1 and archive = '1'  AND Is_Delete = 0  order by Firstname ",array($orgid));
				if($row = $sql->row())
				{
					echo $row->Totalemp;
				}
				
  }
  
//SEC_TO_TIME(time_to_sec(TIMEDIFF(concat(A.timeoutdate,' ',A.TimeOut),concat(A.timeindate,' ',A.TimeIn)))-CASE WHEN(A.TimeOut>S.TimeOutBreak) THEN time_to_sec(TIMEDIFF(CONCAT(A.AttendanceDate,' ',S.TimeOut),CONCAT(A.AttendanceDate,' ',S.TimeIn)))ELSE time_to_sec(TIMEDIFF(CONCAT(A.AttendanceDate,' ',S.TimeOut),CONCAT(A.AttendanceDate,' ',S.TimeIn))-time_to_sec(TIMEDIFF(CONCAT(A.AttendanceDate,' ',S.TimeOutBreak),CONCAT(A.AttendanceDate,' ',S.TimeInBreak)))) END)

//sec_to_time(time_to_sec(timediff(SEC_TO_TIME(CASE WHEN(A.TimeOut>S.TimeOutBreak)THEN time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)) ELSE time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)-time_to_sec(TIMEDIFF(S.TimeOutBreak,S.TimeInBreak))) END),sec_to_time(time_to_sec(TIMEDIFF(A.TimeOut,A.TimeIn))))))as undertime

	public function getattRoastermonthly() //// for count of list of present absent holiday week off //
	{
	$orgid=$_SESSION['orgid'];
	$res 	= 	array();
    $result = 	array();
	$date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
	$emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:'';
	$deprtid=isset($_REQUEST['deprt'])?$_REQUEST['deprt']:'';
	$shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:'';
	$areaid=isset($_REQUEST['areaid'])?$_REQUEST['areaid']:'';
	$begin=isset($_REQUEST['begin'])?$_REQUEST['begin']:'0';
	$end=isset($_REQUEST['end'])?$_REQUEST['end']:'0';
		$q = "";
		$startdate='';
		$enddate='';
						$d = 0;
						$de = "";
						if($date != '')
						{
							$date1 = '01-'.$date;
							$de = date('Y-m-t',strtotime($date1));
						}
						else
						{
							$de = date('Y-m-d');
						}
		//////////////////////////////////////////////////////////////////////////
				$q1 = '';
				if($emplid!=0)
				{
					$q1.=" AND `id`='$emplid'";
				}
				if($deprtid!=0)
				{
					 $q1.=" AND `Department` = '$deprtid' ";
				}
				if($shiftid!=0)
				{
			     $q1.= " AND `Shift`='$shiftid' ";
			    }
				if($areaid!=0)
				{
			     $q1.= " AND `area_assigned`='$areaid' ";
			    }
          //////////////////////////////////////////////////////	
		  $totalemp = 0;
		
		 
        $sql = $this->db->query("SELECT Id,CONCAT(Firstname,' ',Lastname) as name,EmployeeCode,DOL,DOC,Shift from EmployeeMaster where OrganizationId=? $q1 and archive = '1'  AND Is_Delete = 0  order by Firstname limit $begin,$end ",array($orgid));

        // var_dump($this->db->last_query());
		
       // $sql = $this->db->query("SELECT Id,CONCAT(Firstname,' ',Lastname) as name,EmployeeCode,DOL,DOC,Shift from EmployeeMaster where OrganizationId=? $q1 and archive = '1'  AND Is_Delete = 0  order by Firstname  ",array($orgid));
        
        foreach($sql->result() as $rows)
        {  
				$present = 0;
				$absent  = 0;
				$weekoff = 0;
				$holyday = 0;
				$halfday = 0;
				$leave   = 0;
				
			if($date != '')	
			{
				$arr=explode('-',$date);
				$arr[0]=date('m',strtotime($arr[0]));
				$d=cal_days_in_month(CAL_GREGORIAN,$arr[0],$arr[1]);
				$a = $d."-".$date;
				$b = "01-".$date;
				$enddate= date('Y-m-d',strtotime($a));
				$startdate= date('Y-m-d',strtotime($b)); 
				//$q ="AND AttendanceDate BETWEEN  '$startdate' AND '$enddate' ";
			}
			else
			{
				
				
				$enddate=date('Y-m-t');	
				$startdate=date('Y-m-01');
			//$q=" AND  `AttendanceDate` BETWEEN  '$startdate' AND '$enddate' ";
			}		
		        $dateval = array();
		        $data =  array();
		  		$emplid = $rows->Id;
		 		$data['name']= ucwords($rows->name);
		 		$data['department']= ucwords(getDepartmentByEmpID($rows->Id));
				//print_r($data['department']);
				if($rows->EmployeeCode != "")
				$data['empcode'] = $rows->EmployeeCode;
			    else
				$data['empcode'] = "-";
			    $data['totaldurations']=$this->workinghourofmonthlysummary($emplid,$startdate,$enddate);
				$data['shifthours']=$this->ShiftHours($emplid,$startdate,$enddate);
				//print_r($data['totaldurations']);
				 $timein="";
				 $timeout="";
				 
				 $timeindate="";
				 $timeoutdate="";
				 $latecome="";
				 $earlyleave="";
				 $undertime="";
				 $officehour="";	
				
				 $overtime='';
				 $timefrom="";
				 
				$temp= array();
			
		        $temptimein  = array();
		        $temptimeout = array();
		        $temptimeoutdate = array();
		        $temptimeindate = array();
		        $latecommers = array();
		        $earlyleavers= array();
				$overtiming= array();
				$undertiming=array();
		        $officehours = array();
		        $timefromoff = array();
				
				
				while($startdate <= $enddate)
				{
					$dateval[] =date('dS M',strtotime($startdate));
					if( $startdate != date('Y-m-d') )
					$sql="SELECT A.ShiftId,A.TimeIn,A.TimeOut,A.timeindate,A.timeoutdate,AttendanceStatus,
					if(A.timeindate!='0000-00-00',TIMEDIFF(CONCAT(A.timeindate,' ',A.TimeIn),CONCAT(A.AttendanceDate,' ',S.TimeIn)),TIMEDIFF(CONCAT(A.AttendanceDate,' ',A.TimeIn),CONCAT(A.AttendanceDate,' ',S.TimeIn))) as latecome,
					
					if(A.timeoutdate!='0000-00-00',TIMEDIFF(CONCAT(A.AttendanceDate,' ',S.TimeOut),CONCAT(A.timeoutdate,' ',A.TimeOut)),TIMEDIFF(CONCAT(A.AttendanceDate,' ',S.TimeOut),CONCAT(A.AttendanceDate,' ',A.TimeOut))) as earlyleave,
				   if(A.timeoutdate!='0000-00-00',sec_to_time(time_to_sec(TIMEDIFF(CONCAT(A.timeoutdate,' ',A.TimeOut),CONCAT(A.timeindate,' ',A.TimeIn)))),sec_to_time(time_to_sec(TIMEDIFF(CONCAT(A.timeoutdate,' ',A.TimeOut),CONCAT(A.timeindate,' ',A.TimeIn))))) as 	officehour,
				   
				     SEC_TO_TIME(time_to_sec(TIMEDIFF(concat(A.timeoutdate,' ',A.TimeOut),concat(A.timeindate,' ',A.TimeIn)))
					-CASE WHEN(A.TimeOut>S.TimeOutBreak) THEN time_to_sec(TIMEDIFF(CONCAT(A.AttendanceDate,' ',S.TimeOut),CONCAT(A.AttendanceDate,' ',S.TimeIn)))
					ELSE time_to_sec(TIMEDIFF(CONCAT(A.AttendanceDate,' ',S.TimeOut),CONCAT(A.AttendanceDate,' ',S.TimeIn))) END) as overtime,
					
					S.TimeIn as shifttimein,S.TimeOut as shifttimeout,
					
					SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(concat(A.timeoutdate,' ',A.TimeOut),concat(A.timeindate,' ',A.TimeIn)) ) ) as over,
					
					SEC_TO_TIME( 
					CASE WHEN (A.TimeOut > S.TimeOutBreak)
					THEN TIME_TO_SEC( TIMEDIFF(CONCAT(A.AttendanceDate,' ',S.TimeOut),CONCAT(A.AttendanceDate,' ',S.TimeIn))) 
					ELSE TIME_TO_SEC(TIMEDIFF(CONCAT(A.AttendanceDate,' ',S.TimeOut),CONCAT(A.AttendanceDate,' ',S.TimeIn)) - TIME_TO_SEC( TIMEDIFF(concat(A.AttendanceDate,' ',S.TimeOutBreak),concat(A.AttendanceDate,' ',S.TimeInBreak)))) 
					END ) as under,
					
					if(A.timeoutdate!='0000-00-00',sec_to_time(time_to_sec(timediff(SEC_TO_TIME(CASE WHEN(A.TimeOut>S.TimeOutBreak)
					THEN time_to_sec(TIMEDIFF(CONCAT(A.AttendanceDate,' ',S.TimeOut),CONCAT(A.AttendanceDate,' ',S.TimeIn))) 
					ELSE time_to_sec(TIMEDIFF(CONCAT(A.AttendanceDate,' ',S.TimeOut),CONCAT(A.AttendanceDate,' ',S.TimeIn))) END),sec_to_time(time_to_sec(TIMEDIFF(CONCAT(A.timeoutdate,' ',A.TimeOut),CONCAT(A.timeindate,' ',A.TimeIn))))))),
					
					
					sec_to_time(time_to_sec(timediff(SEC_TO_TIME(CASE WHEN(A.TimeOut>S.TimeOutBreak)
					THEN time_to_sec(TIMEDIFF(CONCAT(A.AttendanceDate,' ',S.TimeOut),CONCAT(A.AttendanceDate,' ',S.TimeIn))) 
					ELSE time_to_sec(TIMEDIFF(CONCAT(A.AttendanceDate,' ',S.TimeOut),CONCAT(A.AttendanceDate,' ',S.TimeIn))) END),
					sec_to_time(time_to_sec(TIMEDIFF(CONCAT(A.AttendanceDate,' ',A.TimeOut),CONCAT(A.AttendanceDate,' ',A.TimeIn))))))))as undertime
					FROM AttendanceMaster A,ShiftMaster S 
					WHERE A.OrganizationId=? and  A.EmployeeId='$emplid' AND A.AttendanceDate =
					'$startdate' AND S.Id=A.ShiftId";
					
					else 
					$sql="SELECT A.ShiftId,A.TimeIn,A.TimeOut,A.timeindate,A.timeoutdate,AttendanceStatus,
					if(A.timeindate!='0000-00-00',TIMEDIFF(CONCAT(A.timeindate,' ',A.TimeIn),CONCAT(A.AttendanceDate,' ',S.TimeIn)),TIMEDIFF(CONCAT(A.AttendanceDate,' ',A.TimeIn),CONCAT(A.AttendanceDate,' ',S.TimeIn))) as latecome,'00:00:00' as earlyleave,'00:00:00' as 	officehour,
				    '00:00:00' as overtime,S.TimeIn as shifttimein,S.TimeOut as shifttimeout,'00:00:00' as over,'00:00:00' as under,'00:00:00' as undertime FROM AttendanceMaster A,ShiftMaster S 
					WHERE A.OrganizationId=? and  A.EmployeeId='$emplid' AND A.AttendanceDate = '$startdate' AND S.Id=A.ShiftId";
					
			$query = $this->db->query($sql,array($orgid));
			//echo $this->db->affected_rows();
			if($this->db->affected_rows()>0)
			foreach($query->result() as $row)
				{
					
					$sts = $row->AttendanceStatus;
					//echo $startdate;
					$shiftid =$row->ShiftId;
					$timein=substr($row->TimeIn,0,-3);
					$timeout=substr($row->TimeOut,0,-3);
					$timeindate1=$row->timeindate;
					// echo $timeindate ;
					
					$timeoutdate1=$row->timeoutdate;
					// echo $timeoutdate ;
					$timefrom=$this->timeoffmonthly($emplid,$startdate);
					$shifttimein=substr($row->shifttimein,0,-3);
					$shifttimeout=substr($row->shifttimeout,0,-3);
					$over=substr($row->over,0,-3);
					$under=substr($row->under,0,-3);
					if($timein>$shifttimein && $row->timeindate!='0000-00-00' && $row->TimeIn != '00:00:00')
					{
						$latecome = date('H:i',strtotime($row->latecome));
					   // $latecome=substr($row->latecome,0,-3);
					}
					else
					{
						$latecome="-";
					}
					//echo $latecome;
					if($shifttimeout>$timeout && $row->timeoutdate!='0000-00-00' &&     $row->TimeOut!='00:00:00')
					{
						if(strpos($row->earlyleave,'-')!==0)
						{
							$earlyleave = date('H:i',strtotime($row->earlyleave));
							//$earlyleave=substr($row->earlyleave,0,-3);
						}
						else
						{
							$earlyleave="-"; 
						}
					}
					else
					{
					 $earlyleave="-";
					}
					$officehour=substr($row->officehour,0,-3);
					if($row->officehour==false)
					{
						$officehour = '00:00';
					}
					if($row->timeoutdate=='0000-00-00' || $row->timeindate=='0000-00-00' || $row->TimeIn=='00:00:00' || $row->TimeOut== '00:00:00'){
						$officehour = '00:00';
					}
					// echo $under;
					// echo "<br/>";
					// echo $over;
					$overtime=substr($row->overtime,0,-3);
					
					if($row->overtime==false)
					{
					$overtime = '00:00';
					}
					if($row->timeoutdate=='0000-00-00' || $row->timeindate=='0000-00-00' || $row->TimeIn=='00:00:00' || $row->TimeOut== '00:00:00'){
						$overtime = '00:00';
					}
					if($under > $over)
					{
					$overtime='-';
					}
					
					$undertime=substr($row->undertime,0,-3);
					if($row->undertime==false)
					{
						$undertime = '00:00';
					}
					if($row->timeoutdate=='0000-00-00' || $row->timeindate=='0000-00-00' || $row->TimeIn=='00:00:00' || $row->TimeOut== '00:00:00'){
						$undertime = '00:00';
					}
					if($over> $under)
					{
					   $undertime='-';
					}
		
			$symbol = "";
			//$title = "";
			if($sts == 1)
			{
				$present++;
				$symbol="P";
			}
			else if($sts == 2)
			{	
				 $absent++;
				 $symbol ='A';
				 $timein='00:00';
				 $timeout='00:00';
				 $latecome='00:00';
				 $earlyleave='00:00';
				 $overtime='00:00';
				 $undertime='00:00';
				 $officehour='00:00';
			     $timefrom='00:00';
			     $timeindate1='-';
			     $timeoutdate1='-';
			}
			else if($sts == 3 )
			{	
			if($row->TimeIn!='00:00:00')
				 {
					$present++;
					$symbol="P/WO";	
			
				 }
				 else
				 {
				 $weekoff++;
				 $symbol ='WO';
				 $timein='00:00';
				 $timeout='00:00';
				 $timeoutdate1='-';
				 $timeindate1='-';
				 $latecome='00:00';
				 $earlyleave='00:00';
				 $overtime='00:00';
				 $undertime='00:00';
				 $officehour='00:00';
				 $timefrom='00:00';
				 }

			}

			elseif($sts == 5){

				if($row->TimeIn!='00:00:00')
				 {
					$present++;
					$symbol="P/H";	
			
				 }
				 else
				 {
				 $holyday++;
				 $symbol ='WO';
				 $timein='00:00';
				 $timeout='00:00';
				 $timeoutdate1='-';
				 $timeindate1='-';
				 $latecome='00:00';
				 $earlyleave='00:00';
				 $overtime='00:00';
				 $undertime='00:00';
				 $officehour='00:00';
				 $timefrom='00:00';
				 }





			}
			else if($sts == 4)
			{
				$halfday++;
				$symbol = 'HD';
				$earlyleavehalf=$this->earlyleavehalfday($emplid,$startdate);
				if($earlyleavehalf!=null)
					{
						$earlyleave=$earlyleavehalf;
					}
				else
					{
						$earlyleave='-';
					}
				 $overtime='00:00';
				 $undertime='00:00';
			}
			
			else if($sts == 5)
			{
				$symbol = 'H';
				$holyday++;
			}
			else if($sts == 6){
				$leave++;
					$symbol = 'L';
				 $timein='00:00';
				 $timeout='00:00';
				 $latecome='00:00';
				 $earlyleave='00:00';
				 $overtime='00:00';
				 $undertime='00:00';
				 $officehour='00:00';
				 $timefrom='00:00';
				 $timeoutdate1='-';
				 $timeindate1='-';
			}
			else if($sts == 7)
			{
			  $symbol = "CO";
			}
			else if($sts == 8)
			{
				$symbol = "WFH";
			}
			else
			
			 	 $symbol = "-";
			$temp[] = $symbol;
		 }
		 	
			
		 else
		 {
			 $timein='00:00';
			 $timeout='00:00';
			 $latecome='00:00';
			 $earlyleave='00:00';
			 $overtime='00:00';
			 $undertime='00:00';
			 $officehour='00:00';
			 $timefrom='00:00';
			 $timeoutdate1='-';
			 $timeindate1='-';
			 
				if(date('Y-m-d')>$startdate)
				{
					 $t = $this->getweeklyoff($startdate,$shiftid,$emplid);
					 $temp[]  = $t; 
					if($t=="WO")
					{
					   $weekoff++;
					}
					else if($t=="H")
					{
						$holyday++;
					}
					
				}
				 else
				 
					$temp[] = "-";
		 }
			
				
			 $startdate = date('Y-m-d', strtotime($startdate . ' +1 days'));
			   
			   
			$temptimein[] 	= $timein;
			$temptimeout[] 	= $timeout;
			$temptimeoutdate[] 	= $timeoutdate1;
			$temptimeindate[] 	= $timeindate1;
			$latecommers[] 	= $latecome;
			$earlyleavers[] = $earlyleave;
			$overtiming[]   = $overtime;
			$undertiming[]  = $undertime;
			$officehours[]  = $officehour;
			$timefromoff[]  = $timefrom;
			
		  }
			
			$data['sts']=$temp;
			$data['timein']=$temptimein;
			$data['timeout']=$temptimeout;
			$data['timeoutdate']=$temptimeoutdate;
			$data['timeindate']=$temptimeindate;
			$data['latecome']=$latecommers;
			$data['earlyleave']=$earlyleavers;
			$data['overtime']=$overtiming;
			$data['undertimee']=$undertiming;
			$data['officehours']=$officehours;
			$data['timeoff']=$timefromoff;
			
			$data['present']=$present;
			$data['absent']=$absent;
			$data['weekoff']=$weekoff;
			$data['holyday']=$holyday;
			$data['halfday']=$halfday;
			$data['leave']=$leave;
			$res[] = $data;
			
		}
		
		$result['data']= $res;
		$result['date']= $dateval;
	    return($result);
		}
		
		
		
		
		
		
	
	public function getattRoastermonthly__new()
	{	
	$orgid=$_SESSION['orgid'];
	$res 	= 	array();
    $result = 	array();
	$date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
	$emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:'';
	$emplid=implode(",",$emplid);
	$deprtid=isset($_REQUEST['deprt'])?$_REQUEST['deprt']:'';
	$shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:'';
	$begin=isset($_REQUEST['begin'])?$_REQUEST['begin']:'0';
	$end=isset($_REQUEST['end'])?$_REQUEST['end']:'0';
	
	
	
	//echo $deprtid;
		$q = "";
		$startdate='';
		$enddate='';
						$d = 0;
						$de = "";
						if($date != '')
						{
					        $date1 = '01-'.$date;
							$de = date('Y-m-t',strtotime($date1));
						}
						else
						{
							$de = date('Y-m-d');
						}
		//////////////////////////////////////////////////////////////////////////
				$q1 = '';
				
					if($emplid!=0)
					{
						$q1.=" AND `id` IN ($emplid) ";
					}
				
				if($deprtid!=0)
				{
					 $q1.=" AND `Department` = '$deprtid' ";
				}
				if($shiftid!=0)
				{
			     $q1.= " AND `Shift`='$shiftid' ";
			    }
				
				
          //////////////////////////////////////////////////////	
		  $totalemp = 0;
          $dateval = array();
		 
        $sql = $this->db->query("SELECT Id,CONCAT(Firstname,' ',Lastname) as name,EmployeeCode,DOL,DOC,Shift from EmployeeMaster where OrganizationId=? $q1 and archive = '1'  AND Is_Delete = 0  order by Firstname  ",array($orgid));
		
        
        foreach($sql->result() as $rows)
        {  
				$present = 0;
				$absent  = 0;
				$weekoff = 0;
				$holyday = 0;
				$leave   = 0;
			if($date != '')	
			{
				$arr=explode('-',$date);
				$arr[0]=date('m',strtotime($arr[0]));
				$d=cal_days_in_month(CAL_GREGORIAN,$arr[0],$arr[1]);
				$a = $d."-".$date;
				$b = "01-".$date;
				$enddate= date('Y-m-d',strtotime($a));
				$startdate= date('Y-m-d',strtotime($b)); 
				//$q ="AND AttendanceDate BETWEEN  '$startdate' AND '$enddate' ";
			}
			else
			{
				
				
				$enddate=date('Y-m-t');	
				$startdate=date('Y-m-01');
			//$q=" AND  `AttendanceDate` BETWEEN  '$startdate' AND '$enddate' ";
			}		
		        $dateval = array();
		        $data =  array();
		  		$emplid = $rows->Id;
		 		$data['name']= ucwords($rows->name);
		 		$data['department']= ucwords(getDepartmentByEmpID($rows->Id));
				if($rows->EmployeeCode != "")
				$data['empcode'] = $rows->EmployeeCode;
			    else
				$data['empcode'] = "-";
				//$data['totaldurations']=$this->workinghourofmonthlysummary($emplid,$startdate,$enddate);
				
				 $timein="00:00";
				 $timeout="00:00";
				 $latecome="00:00";
				 $earlyleave="00:00";
				 $undertime="-";
				 $officehour="-";	
				 //$totalduration='';
				// $shifthours='';
				 $overtime='-';
				 
				$temp= array();
		        $temptimein  = array();
		        $temptimeout = array();
		        $latecommers = array();
		        $earlyleavers= array();
				$overtiming= array();
				$undertiming=array();
		        $officehours = array();
				//$attshift=array();
				//$shif=0;
				
				while($startdate <= $enddate)
				{
				 $dateval[] =date('dS M',strtotime($startdate));
				$sql="SELECT ShiftId,TimeIn,AttendanceDate,TimeOut,AttendanceStatus,timeoutdate From AttendanceMaster  where  EmployeeId='$emplid' AND AttendanceDate ='$startdate' ";
					//echo $sql;
			   $query = $this->db->query($sql,array($orgid));
			   if($this->db->affected_rows()>0)
			   foreach($query->result() as $row)
				{
					
					 $sts = $row->AttendanceStatus;
					 $shiftid =$row->ShiftId;
					 $shifttime = getShiftTimeInSeconde($shiftid);
					 $shifttype = 1;
					 $shifttimein = "";
					 $shifttimeout = "";
					 if($shifttime != 0)
					 {
						 $sarr = explode("**",$shifttime);
						 $shifttime = $sarr[0];
						 $shifttype = $sarr[1];
						 $shifttimein = $sarr[2];
						 $shifttimeout = $sarr[3];
					 }
					 $timein=substr($row->TimeIn,0,-3);
					 $timeout=substr($row->TimeOut,0,-3);
					 $attendanceDate = $row->AttendanceDate;
					 $timeoutDate = $row->timeoutdate;
					  $officehour='00:00';
					  $officesecond = 0;
					  $ti = "00:00";
					  $to = "00:00";
					  // office hours calculation
					 if($timeout != "00:00" AND $timein != "00:00" )
					 {
						  $Fquery = "";
						  
						 if($timeoutDate != '0000-00-00')
						 {
							 $ti = $attendanceDate." ".$timein;
							 $to = $timeoutDate." ".$timeout;
					    	 $Fquery = $this->db->query(" Select  TimeDiff('$to','$ti') as  officehour, time_to_sec(TimeDiff('$to','$ti')) as   officesecond ");
						 }
						 else
						 {
							 $ti = $attendanceDate." ".$timein;
							 $to = $attendanceDate." ".$timeout;
					    	 $Fquery = $this->db->query(" Select  TimeDiff('$to','$ti') as  officehour ,  time_to_sec(TimeDiff('$to','$ti')) as   officesecond ");
						 }
						 
						 if($Frow = $Fquery->row())
						 {
							 $officehour = substr($Frow->officehour,0,-3);
							 $officesecond = $Frow->officesecond;
						 }
					 }
					 
					  // under and over time calculation
					 if($shifttime>$officesecond)
					 {
						 $over_under_time = $this->db->query("Select TIMEDIFF(sec_to_time('$shifttime') , sec_to_time('$officesecond')) as outime");
						 if($ourow = $over_under_time->row())
						 {
							 $undertime =  substr($ourow->outime,0,-3);
						 }
						 $overtime='-';
					 }
					 else
					 {
						$over_under_time = $this->db->query("Select TIMEDIFF(sec_to_time('$officesecond') , sec_to_time('$shifttime')) as outime");
						 if($ourow = $over_under_time->row())
						 {
							 $overtime =  substr($ourow->outime,0,-3);
						 }
						 $undertime='-';
					 }
					 
					 //calculate latecommers and EarlyLeavers
					 if($shifttype == 1) // for singlle date shift
					 {
						if(strtotime($shifttimein)<strtotime($timein)) 
						{
							$latequery = $this->db->query(" select timediff('$timein','$shifttimein') as lateby");
			                 if($laterow = $latequery->row())
				             $latecome= substr($laterow->lateby,0,-3);
						}
						else{
							 $latecome="-";
						}
						
						if(strtotime($shifttimeout)>strtotime($timeout)) 
						{
							$leftearlyquery = $this->db->query(" select timediff('$shifttimeout','$timeout') as leftearly");
			                 if($leftearlyrow = $leftearlyquery->row())
				             $earlyleave= substr($leftearlyrow->leftearly,0,-3);
						}
						else{
				             $earlyleave="-";
						}
					 }
					 
					 else  // for multiple date shift
					 {
						 if(strtotime($attendanceDate." ".$shifttimein)<strtotime($ti)) 
						{
							$latequery = $this->db->query(" select timediff('$timein','$shifttimein') as lateby");
			                 if($laterow = $latequery->row())
				             $latecome= substr($laterow->lateby,0,-3);
						}
						else{
							 $latecome="-";
						}
						
						$shifttimeoutdate = date("Y-m-d",strtotime(" +1 days" , $attendanceDate));
						if(strtotime($shifttimeoutdate." ".$shifttimeout)>strtotime($to)) 
						{
							$leftearlyquery = $this->db->query(" select timediff('$shifttimeout','$timeout') as leftearly");
			                 if($leftearlyrow = $leftearlyquery->row())
				             $earlyleave= substr($leftearlyrow->leftearly,0,-3);
						}
						else{
				             $earlyleave="-";
						}
					 }
					
			$symbol = "";
			if($sts == 1)
			{
				$present++;
				$symbol="P";
			}
			else if($sts == 2)
			{	
				 $absent++;
				 $symbol ='A';
				 $timein='00:00';
				 $timeout='00:00';
				 $latecome='00:00';
				 $earlyleave='00:00';
				 $overtime='00:00';
				 $undertime='00:00';
				 $officehour='00:00';
			}
			else if($sts == 3)
			{	
				 $weekoff++;
				 $symbol ='WO';
				 $timein='00:00';
				 $timeout='00:00';
				 $latecome='00:00';
				 $earlyleave='00:00';
				 $overtime='00:00';
				 $undertime='00:00';
				 $officehour='00:00';
			}
			else if($sts == 4)
			{
				$holyday++;
				$symbol = 'HD';
				$earlyleavehalf=$this->earlyleavehalfday($emplid,$startdate);
				if($earlyleavehalf!=null)
					{
						$earlyleave=$earlyleavehalf;
					}
				else
					{
						$earlyleave='-';
					}
				 $overtime='00:00';
				 $undertime='00:00';
			}
			
			else if($sts == 5)
			{
				$symbol = 'H';
			}
			else if($sts == 7)
			{
			  $symbol = "CO";
			}
			else if($sts == 8)
			{
				$symbol = "WFH";
			}
			else
			  $symbol = "-";
			 $temp[] = $symbol;
		 }
		 	
			
		 else
		 {
			 $timein='00:00';
			 $timeout='00:00';
			 $latecome='00:00';
			 $earlyleave='00:00';
			 $overtime='00:00';
			 $undertime='00:00';
			 $officehour='00:00';
				if(date('Y-m-d')>$startdate)
				{
					 $t = $this->getweeklyoff($startdate,$shiftid,$emplid);
					 $temp[] = $t; 
					if($t=="WO")
					$weekoff++;
					else if($t=="H")
					$holyday++;
				}
				 else
					$temp[] = "-";
		 }
			
				
			 $startdate = date('Y-m-d', strtotime($startdate . ' +1 days'));
			  
			$temptimein[] 	= $timein;
			$temptimeout[] 	= $timeout;
			$latecommers[] 	= $latecome;
			$earlyleavers[] = $earlyleave;
			 $overtiming[]  = $overtime;
			$undertiming[]  = $undertime;
			$officehours[]  = $officehour;
			//$attshift[]     = $shiftid;
		  }
		   
			//$hours 		= 	floor($shif / 3600);
			//$mins 		= 	floor($shif/ 60 % 60);
			//$cumtotal	= 	sprintf('%02d:%02d',$hours,$mins);
			//$data['shifthours']=$cumtotal;
			
			$data['sts']=$temp;
			$data['timein']=$temptimein;
			$data['timeout']=$temptimeout;
			$data['latecome']=$latecommers;
			$data['earlyleave']=$earlyleavers;
			$data['overtime']=$overtiming;
			$data['undertimee']=$undertiming;
			$data['officehours']=$officehours;
			//$data['attshift']=$attshift;
			
			$data['present']=$present;
			$data['absent']=$absent;
			$data['weekoff']=$weekoff;
			$data['holyday']=$holyday;
			$res[] = $data;
		}
		
		$result['data']= $res;
		$result['date']= $dateval;
	
	    return($result);
	}
	public function getattRoastermonthly__new1()
	{	
	$orgid=$_SESSION['orgid'];
	$res 	= 	array();
    $result = 	array();
	$date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
	$emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:'';
	//$emplid=implode(",",$emplid);
	$deprtid=isset($_REQUEST['deprt'])?$_REQUEST['deprt']:'';
	$shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:'';
	$begin=isset($_REQUEST['begin'])?$_REQUEST['begin']:'0';
	$end=isset($_REQUEST['end'])?$_REQUEST['end']:'0';
	
	
	
	//echo $deprtid;
		$q = "";
		$startdate='';
		$enddate='';
						$d = 0;
						$de = "";
						if($date != '')
						{
					        $date1 = '01-'.$date;
							$de = date('Y-m-t',strtotime($date1));
						}
						else
						{
							$de = date('Y-m-d');
						}
		//////////////////////////////////////////////////////////////////////////
				$q1 = '';
				
					if($emplid!=0)
					{
						$q1.=" AND `id` = '$emplid' ";
					}
				
				if($deprtid!=0)
				{
					 $q1.=" AND `Department` = '$deprtid' ";
				}
				if($shiftid!=0)
				{
			     $q1.= " AND `Shift`='$shiftid' ";
			    }
          //////////////////////////////////////////////////////	
		  $totalemp = 0;
          $dateval = array();
		 
        $sql = $this->db->query("SELECT Id,CONCAT(Firstname,' ',Lastname) as name,EmployeeCode,DOL,DOC,Shift from EmployeeMaster where OrganizationId=? $q1 and archive = '1'  AND Is_Delete = 0  order by Firstname  ",array($orgid));
		
        
        foreach($sql->result() as $rows)
        {  
				$present = 0;
				$absent  = 0;
				$weekoff = 0;
				$holyday = 0;
				$leave   = 0;
			if($date != '')	
			{
				$arr=explode('-',$date);
				$arr[0]=date('m',strtotime($arr[0]));
				$d=cal_days_in_month(CAL_GREGORIAN,$arr[0],$arr[1]);
				$a = $d."-".$date;
				$b = "01-".$date;
				$enddate= date('Y-m-d',strtotime($a));
				$startdate= date('Y-m-d',strtotime($b)); 
				//$q ="AND AttendanceDate BETWEEN  '$startdate' AND '$enddate' ";
			}
			else
			{
				
				
				$enddate=date('Y-m-t');	
				$startdate=date('Y-m-01');
			//$q=" AND  `AttendanceDate` BETWEEN  '$startdate' AND '$enddate' ";
			}		
		        $dateval = array();
		        $data =  array();
		  		$emplid = $rows->Id;
		 		$data['name']= ucwords($rows->name);
		 		$data['department']= ucwords(getDepartmentByEmpID($rows->Id));
				if($rows->EmployeeCode != "")
				$data['empcode'] = $rows->EmployeeCode;
			    else
				$data['empcode'] = "-";
				//$data['totaldurations']=$this->workinghourofmonthlysummary($emplid,$startdate,$enddate);
				
				 $timein="00:00";
				 $timeout="00:00";
				 $latecome="00:00";
				 $earlyleave="00:00";
				 $undertime="-";
				 $officehour="-";	
				 //$totalduration='';
				// $shifthours='';
				 $overtime='-';
				 
				$temp= array();
		        $temptimein  = array();
		        $temptimeout = array();
		        $latecommers = array();
		        $earlyleavers= array();
				$overtiming= array();
				$undertiming=array();
		        $officehours = array();
				//$attshift=array();
				//$shif=0;
				
				while($startdate <= $enddate)
				{
				 $dateval[] =date('dS M',strtotime($startdate));
				$sql="SELECT ShiftId,TimeIn,AttendanceDate,TimeOut,AttendanceStatus,timeoutdate From AttendanceMaster  where  EmployeeId='$emplid' AND AttendanceDate ='$startdate' ";
					//echo $sql;
			   $query = $this->db->query($sql,array($orgid));
			   if($this->db->affected_rows()>0)
			   foreach($query->result() as $row)
				{
					
					 $sts = $row->AttendanceStatus;
					 $shiftid =$row->ShiftId;
					 $shifttime = getShiftTimeInSeconde($shiftid);
					 $shifttype = 1;
					 $shifttimein = "";
					 $shifttimeout = "";
					 if($shifttime != 0)
					 {
						 $sarr = explode("**",$shifttime);
						 $shifttime = $sarr[0];
						 $shifttype = $sarr[1];
						 $shifttimein = $sarr[2];
						 $shifttimeout = $sarr[3];
					 }
					 $timein=substr($row->TimeIn,0,-3);
					 $timeout=substr($row->TimeOut,0,-3);
					 $attendanceDate = $row->AttendanceDate;
					 $timeoutDate = $row->timeoutdate;
					  $officehour='00:00';
					  $officesecond = 0;
					  $ti = "00:00";
					  $to = "00:00";
					  // office hours calculation
					 if($timeout != "00:00" AND $timein != "00:00" )
					 {
						  $Fquery = "";
						 if($timeoutDate != '0000-00-00')
						 {
							 $ti = $attendanceDate." ".$timein;
							 $to = $timeoutDate." ".$timeout;
					    	 $Fquery = $this->db->query(" Select  TimeDiff('$to','$ti') as  officehour, time_to_sec(TimeDiff('$to','$ti')) as   officesecond ");
						 }
						 else
						 {
							 $ti = $attendanceDate." ".$timein;
							 $to = $attendanceDate." ".$timeout;
					    	 $Fquery = $this->db->query(" Select  TimeDiff('$to','$ti') as  officehour ,  time_to_sec(TimeDiff('$to','$ti')) as   officesecond ");
						 }
						 
						 if($Frow = $Fquery->row())
						 {
							 $officehour = substr($Frow->officehour,0,-3);
							 $officesecond = $Frow->officesecond;
						 }
					 }
					 
					  // under and over time calculation
					 if($shifttime>$officesecond)
					 {
						 $over_under_time = $this->db->query("Select TIMEDIFF(sec_to_time('$shifttime') , sec_to_time('$officesecond')) as outime");
						 if($ourow = $over_under_time->row())
						 {
							 $undertime =  substr($ourow->outime,0,-3);
						 }
						 $overtime='-';
					 }
					 else
					 {
						$over_under_time = $this->db->query("Select TIMEDIFF(sec_to_time('$officesecond') , sec_to_time('$shifttime')) as outime");
						 if($ourow = $over_under_time->row())
						 {
							 $overtime =  substr($ourow->outime,0,-3);
						 }
						 $undertime='-';
					 }
					 
					 //calculate latecommers and EarlyLeavers
					 if($shifttype == 1) // for singlle date shift
					 {
						if(strtotime($shifttimein)<strtotime($timein)) 
						{
							$latequery = $this->db->query(" select timediff('$timein','$shifttimein') as lateby");
			                 if($laterow = $latequery->row())
				             $latecome= substr($laterow->lateby,0,-3);
						}
						else{
							 $latecome="-";
						}
						
						if(strtotime($shifttimeout)>strtotime($timeout)) 
						{
							$leftearlyquery = $this->db->query(" select timediff('$shifttimeout','$timeout') as leftearly");
			                 if($leftearlyrow = $leftearlyquery->row())
				             $earlyleave= substr($leftearlyrow->leftearly,0,-3);
						}
						else{
				             $earlyleave="-";
						}
					 }
					 
					 else  // for multiple date shift
					 {
						 if(strtotime($attendanceDate." ".$shifttimein)<strtotime($ti)) 
						{
							$latequery = $this->db->query(" select timediff('$timein','$shifttimein') as lateby");
			                 if($laterow = $latequery->row())
				             $latecome= substr($laterow->lateby,0,-3);
						}
						else{
							 $latecome="-";
						}
						
						$shifttimeoutdate = date("Y-m-d",strtotime(" +1 days" , $attendanceDate));
						if(strtotime($shifttimeoutdate." ".$shifttimeout)>strtotime($to)) 
						{
							$leftearlyquery = $this->db->query(" select timediff('$shifttimeout','$timeout') as leftearly");
			                 if($leftearlyrow = $leftearlyquery->row())
				             $earlyleave= substr($leftearlyrow->leftearly,0,-3);
						}
						else{
				             $earlyleave="-";
						}
					 }
					
			$symbol = "";
			if($sts == 1)
			{
				$present++;
				$symbol="P";
			}
			else if($sts == 2)
			{	
				 $absent++;
				 $symbol ='A';
				 $timein='00:00';
				 $timeout='00:00';
				 $latecome='00:00';
				 $earlyleave='00:00';
				 $overtime='00:00';
				 $undertime='00:00';
				 $officehour='00:00';
			}
			else if($sts == 3)
			{	
				 $weekoff++;
				 $symbol ='WO';
				 $timein='00:00';
				 $timeout='00:00';
				 $latecome='00:00';
				 $earlyleave='00:00';
				 $overtime='00:00';
				 $undertime='00:00';
				 $officehour='00:00';
			}
			else if($sts == 4)
			{
				$holyday++;
				$symbol = 'HD';
				$earlyleavehalf=$this->earlyleavehalfday($emplid,$startdate);
				if($earlyleavehalf!=null)
					{
						$earlyleave=$earlyleavehalf;
					}
				else
					{
						$earlyleave='-';
					}
				 $overtime='00:00';
				 $undertime='00:00';
			}
			
			else if($sts == 5)
			{
				$symbol = 'H';
			}
			else if($sts == 7)
			{
			  $symbol = "CO";
			}
			else if($sts == 8)
			{
				$symbol = "WFH";
			}
			else
			  $symbol = "-";
			 $temp[] = $symbol;
		 }
		 	
			
		 else
		 {
			 $timein='00:00';
			 $timeout='00:00';
			 $latecome='00:00';
			 $earlyleave='00:00';
			 $overtime='00:00';
			 $undertime='00:00';
			 $officehour='00:00';
				if(date('Y-m-d')>$startdate)
				{
					 $t = $this->getweeklyoff($startdate,$shiftid,$emplid);
					 $temp[] = $t; 
					if($t=="WO")
					$weekoff++;
					else if($t=="H")
					$holyday++;
				}
				 else
					$temp[] = "-";
		 }
			
				
			 $startdate = date('Y-m-d', strtotime($startdate . ' +1 days'));
			  
			$temptimein[] 	= $timein;
			$temptimeout[] 	= $timeout;
			$latecommers[] 	= $latecome;
			$earlyleavers[] = $earlyleave;
			 $overtiming[]  = $overtime;
			$undertiming[]  = $undertime;
			$officehours[]  = $officehour;
			//$attshift[]     = $shiftid;
		  }
		   
			//$hours 		= 	floor($shif / 3600);
			//$mins 		= 	floor($shif/ 60 % 60);
			//$cumtotal	= 	sprintf('%02d:%02d',$hours,$mins);
			//$data['shifthours']=$cumtotal;
			
			$data['sts']=$temp;
			$data['timein']=$temptimein;
			$data['timeout']=$temptimeout;
			$data['latecome']=$latecommers;
			$data['earlyleave']=$earlyleavers;
			$data['overtime']=$overtiming;
			$data['undertimee']=$undertiming;
			$data['officehours']=$officehours;
			//$data['attshift']=$attshift;
			
			$data['present']=$present;
			$data['absent']=$absent;
			$data['weekoff']=$weekoff;
			$data['holyday']=$holyday;
			$res[] = $data;
		}
		
		$result['data']= $res;
		$result['date']= $dateval;
	
	    return($result);
	}
	
	
	public function getattRoastermonthly__newcsv()
	{	
	$orgid=$_SESSION['orgid'];
	$res 	= 	array();
    $result = 	array();
	$alldata = array();
	$date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
	$emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:'';
	$deprtid=isset($_REQUEST['deprt'])?$_REQUEST['deprt']:'';
	$desigid=isset($_REQUEST['designation'])?$_REQUEST['designation']:'';
	$shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:'';
	$begin=isset($_REQUEST['begin'])?$_REQUEST['begin']:'0';
	$end=isset($_REQUEST['end'])?$_REQUEST['end']:'0';
	$userlimit = isset($_REQUEST['userlimit'])?$_REQUEST['userlimit']:"";
	$limit_offset = "";
	if($userlimit != "")
	{
		$limit_offset = "limit 20 offset $userlimit";
	}
	//echo $deprtid;
		$q = "";
		$startdate='';
		$enddate='';
						$d = 0;
						$de = "";
						if($date != '')
						{
					        $date1 = '01-'.$date;
							$de = date('Y-m-t',strtotime($date1));
						}
						else
						{
							$de = date('Y-m-d');
						}
		//////////////////////////////////////////////////////////////////////////
				$q1 = '';
				if($emplid!=0)
				{
					$q1.=" AND `id`='$emplid'";
				}
				if($deprtid!=0)
				{
					 $q1.=" AND `Department` = '$deprtid' ";
				}
				if($desigid!=0)
				{
					 $q1.=" AND `Designation` = '$desigid' ";
				}
				if($shiftid!=0)
				{
			     $q1.= " AND `Shift`='$shiftid' ";
			    }
          //////////////////////////////////////////////////////	
		  $totalemp = 0;
          $dateval = array();
		 
		 
 
        $sql = $this->db->query("SELECT Id,CONCAT(Firstname,' ',Lastname) as name,EmployeeCode,DOL,DOC,Shift from EmployeeMaster where OrganizationId=?  and archive = '1'  AND Is_Delete = 0 $q1 order by Firstname $limit_offset ",array($orgid));
		
        
        foreach($sql->result() as $rows)
        {  
				$present = 0;
				$absent  = 0;
				$weekoff = 0;
				$holyday = 0;
				$leave   = 0;
			if($date != '')	
			{
				$arr=explode('-',$date);
				$arr[0]=date('m',strtotime($arr[0]));
				$d=cal_days_in_month(CAL_GREGORIAN,$arr[0],$arr[1]);
				$a = $d."-".$date;
				$b = "01-".$date;
				$enddate= date('Y-m-d',strtotime($a));
				$startdate= date('Y-m-d',strtotime($b)); 
			}
			else
			{
				$enddate=date('Y-m-t');	
				$startdate=date('Y-m-01');
			}		
		        $dateval = array();
		        $data =  array();
		  		$emplid = $rows->Id;
		 		$data['name']= ucwords($rows->name);
		 		$data['department']= ucwords(getDepartmentByEmpID($rows->Id));
		 		
				if($rows->EmployeeCode != "")
				$data['empcode'] = $rows->EmployeeCode;
			    else
				$data['empcode'] = "-";
				 $timein="00:00";
				 $timeout="00:00";
				 $latecome="00:00";
				 $earlyleave="00:00";
				 $undertime="-";
				 $officehour="-";	
				 $overtime='-';
				 
				$temp= array();
		        $temptimein  = array();
		        $temptimeout = array();
		        $latecommers = array();
		        $earlyleavers= array();
				$overtiming= array();
				$undertiming=array();
		        $officehours = array();
				$emptyarray = array();
				$emptyarray[] = " ";
				 
				$dateval[] = "";
				$temp[] = "";
				$temptimein[] = " ";
				$temptimeout[] = "";
				$latecommers[] = "";
				$earlyleavers[] = "";
				$overtiming[] = "";
				$undertiming[] = "";
				$officehours[] = "";
			
				$temp[] = "Status";
		        $temptimein[]  = "Time In";
		        $temptimeout[] = "Time Out";
		        $latecommers[] = "Late by";
		        $earlyleavers[] = "Left Early by";
				$overtiming[] = "Overtime";
				$undertiming[] = "Undertime";
		        $officehours[]  = "Logged Hours";
				$dateval[] = "Days";
				while($startdate <= $enddate)
				{
				 $dateval[] =date('dS M',strtotime($startdate));
				$sql="SELECT ShiftId,TimeIn,AttendanceDate,TimeOut,AttendanceStatus,timeoutdate From AttendanceMaster  where  EmployeeId='$emplid' AND AttendanceDate ='$startdate' ";
				//	echo $enddate;
			   $query = $this->db->query($sql,array($orgid));
			   if($this->db->affected_rows()>0)
			   foreach($query->result() as $row)
				{
					
					 $sts = $row->AttendanceStatus;
					 $shiftid =$row->ShiftId;
					 $shifttime = getShiftTimeInSeconde($shiftid);
					 $shifttype = 1;
					 $shifttimein = "";
					 $shifttimeout = "";
					 if($shifttime != 0)
					 {
						 $sarr = explode("**",$shifttime);
						 $shifttime = $sarr[0];
						 $shifttype = $sarr[1];
						 $shifttimein = $sarr[2];
						 $shifttimeout = $sarr[3];
					 }
					 $timein=substr($row->TimeIn,0,-3);
					 $timeout=substr($row->TimeOut,0,-3);
					 $attendanceDate = $row->AttendanceDate;
					 $timeoutDate = $row->timeoutdate;
					  $officehour='00:00';
					  $officesecond = 0;
					  $ti = "00:00";
					  $to = "00:00";
					  // office hours calculation
					 if($timeout != "00:00" AND $timein != "00:00" )
					 {
						  $Fquery = "";
						 if($timeoutDate != '0000-00-00')
						 {
							 $ti = $attendanceDate." ".$timein;
							 $to = $timeoutDate." ".$timeout;
					    	 $Fquery = $this->db->query(" Select  TimeDiff('$to','$ti') as  officehour, time_to_sec(TimeDiff('$to','$ti')) as   officesecond ");
						 }
						 else
						 {
							 $ti = $attendanceDate." ".$timein;
							 $to = $attendanceDate." ".$timeout;
					    	 $Fquery = $this->db->query(" Select  TimeDiff('$to','$ti') as  officehour ,  time_to_sec(TimeDiff('$to','$ti')) as   officesecond ");
						 }
						 
						 if($Frow = $Fquery->row())
						 {
							 $officehour = substr($Frow->officehour,0,-3);
							 $officesecond = $Frow->officesecond;
						 }
					 }
					 
					  // under and over time calculation
					 if($shifttime>$officesecond)
					 {
						 $over_under_time = $this->db->query("Select TIMEDIFF(sec_to_time('$shifttime') , sec_to_time('$officesecond')) as outime");
						 if($ourow = $over_under_time->row())
						 {
							 $undertime =  substr($ourow->outime,0,-3);
						 }
						 $overtime='-';
					 }
					 else
					 {
						$over_under_time = $this->db->query("Select TIMEDIFF(sec_to_time('$officesecond') , sec_to_time('$shifttime')) as outime");
						 if($ourow = $over_under_time->row())
						 {
							 $overtime =  substr($ourow->outime,0,-3);
						 }
						 $undertime='-';
					 }
					 
					 //calculate latecommers and EarlyLeavers
					 if($shifttype == 1) // for singlle date shift
					 {
						if(strtotime($shifttimein)<strtotime($timein)) 
						{
							$latequery = $this->db->query(" select timediff('$timein','$shifttimein') as lateby");
			                 if($laterow = $latequery->row())
				             $latecome= substr($laterow->lateby,0,-3);
						}
						else{
							 $latecome="-";
						}
						
						if(strtotime($shifttimeout)>strtotime($timeout)) 
						{
							$leftearlyquery = $this->db->query(" select timediff('$shifttimeout','$timeout') as leftearly");
			                 if($leftearlyrow = $leftearlyquery->row())
				             $earlyleave= substr($leftearlyrow->leftearly,0,-3);
						}
						else{
				             $earlyleave="-";
						}
					 }
					 
					 else  // for multiple date shift
					 {
						 if(strtotime($attendanceDate." ".$shifttimein)<strtotime($ti)) 
						{
							$latequery = $this->db->query(" select timediff('$timein','$shifttimein') as lateby");
			                 if($laterow = $latequery->row())
				             $latecome= substr($laterow->lateby,0,-3);
						}
						else{
							 $latecome="-";
						}
						
						$shifttimeoutdate = date("Y-m-d",strtotime($attendanceDate));
						if(strtotime($shifttimeoutdate." ".$shifttimeout)>strtotime($to)) 
						{
							$leftearlyquery = $this->db->query(" select timediff('$shifttimeout','$timeout') as leftearly");
			                 if($leftearlyrow = $leftearlyquery->row())
				             $earlyleave= substr($leftearlyrow->leftearly,0,-3);
						}
						else{
				             $earlyleave="-";
						}
					 }
					
			$symbol = "";
			if($sts == 1)
			{
				$present++;
				$symbol="P";
			}
			else if($sts == 2)
			{	
				 $absent++;
				 $symbol ='A';
				 $timein='00:00';
				 $timeout='00:00';
				 $latecome='00:00';
				 $earlyleave='00:00';
				 $overtime='00:00';
				 $undertime='00:00';
				 $officehour='00:00';
			}
			else if($sts == 3)
			{	
				 $weekoff++;
				 $symbol ='WO';
				 $timein='00:00';
				 $timeout='00:00';
				 $latecome='00:00';
				 $earlyleave='00:00';
				 $overtime='00:00';
				 $undertime='00:00';
				 $officehour='00:00';
			}
			else if($sts == 4)
			{
				$holyday++;
				$symbol = 'HD';
				$earlyleavehalf=$this->earlyleavehalfday($emplid,$startdate);
				if($earlyleavehalf!=null)
					{
						$earlyleave=$earlyleavehalf;
					}
				else
					{
						$earlyleave='-';
					}
				 $overtime='00:00';
				 $undertime='00:00';
			}
			
			else if($sts == 5)
			{
				$symbol = 'H';
			}
			else if($sts == 7)
			{
			  $symbol = "CO";
			}
			else if($sts == 8)
			{
				$symbol = "WFH";
			}
			else
			  $symbol = "-";
			 $temp[] = $symbol;
		 }
		 	
			
		 else
		 {
			 $timein='00:00';
			 $timeout='00:00';
			 $latecome='00:00';
			 $earlyleave='00:00';
			 $overtime='00:00';
			 $undertime='00:00';
			 $officehour='00:00';
				if(date('Y-m-d')>$startdate)
				{
					 $t = $this->getweeklyoff($startdate,$shiftid,$emplid);
					 $temp[] = $t; 
					if($t=="WO")
					$weekoff++;
					else if($t=="H")
					$holyday++;
				}
				 else
					$temp[] = "-";
		 }
			
				
			 $startdate = date('Y-m-d', strtotime($startdate . ' +1 days'));
			  
			$temptimein[] 	= $timein;
			$temptimeout[] 	= $timeout;
			$latecommers[] 	= $latecome;
			$earlyleavers[] = $earlyleave;
			 $overtiming[]  = $overtime;
			$undertiming[]  = $undertime;
			$officehours[]  = $officehour;
			//$attshift[]   = $shiftid;
		  } // while loop of date
		   
			
			
		
			
			    $dateval[0] = "Name : ".$data['name'];
				$temp[0] = "Code : ".$data['empcode'];
				$temptimein[0] = "Department : ".$data['department'];
				$temptimeout[0] =  "Presents : ".$present;
				$latecommers[0] = "Absents : ".$absent;
				$earlyleavers[0] = "WeekOff : ".$weekoff;
				$overtiming[0] = "Holidays : ".$holyday;
				$undertiming[0] = " ";
				$officehours[0] = " ";
			
			 
			$alldata[] = $dateval;
			$alldata[] = $temp;
			$alldata[] = $temptimein;
			$alldata[] = $temptimeout;
			$alldata[] = $latecommers;
			$alldata[] = $earlyleavers;
			$alldata[] = $overtiming;
			$alldata[] = $undertiming;
			$alldata[] = $officehours;
			
			$alldata[] = $emptyarray; // this array assign for apacing
			$alldata[] = $emptyarray;
			
			
		} // first for each loop
	  return($alldata);
	}
	
	
	function getshiftdays($date,$shiftid,$emplid)
		         { 
			        $orgid=$_SESSION['orgid'];
	                $dt=$date;
					$dayOfWeek = 1 + date('w',strtotime($dt));
				
					$weekOfMonth = weekOfMonth($dt);
					$week='';
					
					$query = $this->db->query("Select ShiftId from AttendanceMaster where AttendanceDate < '$date' AND EmployeeId = '$emplid' ORDER BY AttendanceDate DESC LIMIT 1");
					if($row=$query->result())
					{
						$shiftid = $row[0]->ShiftId;
					}
					$query = $this->db->query("SELECT `WeekOff` FROM  `ShiftMasterChild` WHERE  `OrganizationId` =? AND  `Day` =  ? AND ShiftId=? ",array($orgid,$dayOfWeek,$shiftid));
                     $flage = false;					
					if($row=$query->result())
					{
							$week =	explode(",",$row[0]->WeekOff);
							$flage = true;
					}
					if($flage && $week[$weekOfMonth-1]==2)
					{
					    return '2';
					}
					else if($flage && $week[$weekOfMonth-1]==1)
						return '1';
					else 
						return '0';
		}

/*public function getattRoastermonthly()
	{
	$orgid=$_SESSION['orgid'];
	$result=array();
	$res=array();
	$date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
	$emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:'';
	$deprtid=isset($_REQUEST['deprt'])?$_REQUEST['deprt']:'';
		$q = "";
		$startdate='';
		$enddate='';
		$d = 0;
		$de = "";
		$q1 = '';
		if($emplid!=0)
		{
			$q1.=" AND id ='$emplid'";
		}
		if($deprtid!=0)
		{
			 $q1.=" AND `Department` = '$deprtid' ";
		}		
		
					
		
				$data=array();
				$dateval=array();
				$temp= array();
				$temptimein= array();
				$temptimeout= array();
				$latecommers= array();
				$earlyleavers= array();
				$officehours= array();
				$overtiming= array();
				$undertiming= array();
				if($date != '')
						{
							$date1 = '01-'.$date;
							$de = date('Y-m-t',strtotime($date1));
							$arr=explode('-',$date);
							$d=cal_days_in_month(CAL_GREGORIAN,$arr[0],$arr[1]);
							$a = $d."-".$date;
							$b = "01-".$date;
							$enddate  = date('Y-m-t',strtotime($a));
							$startdate= date('Y-m-01',strtotime($b)); 
						}
						else
						{
							$de = date('Y-m-d');
							$enddate=date('Y-m-t');	
							$startdate=date('Y-m-01');
							
						}
				
					
											
	$sql="SELECT Id,CONCAT(Firstname,' ',Lastname) as name,EmployeeCode,DOL,DOC,Shift  from EmployeeMaster where OrganizationId=? $q1   AND Is_Delete = 0  order by Firstname";
	
	$q2 = $this->db->query($sql,array($orgid));	
	
	foreach($q2->result() as $rows)
				{
					// if($date != '')
						// {
							// $date1 = '01-'.$date;
							// $de = date('Y-m-t',strtotime($date1));
							// $enddate  = date('Y-m-t',strtotime($de));
							// $startdate= date('Y-m-01',strtotime($de)); 
						// }
						// else
						// {
							// //$de = date('Y-m-d');
							// $enddate=date('Y-m-t');	
							// $startdate=date('Y-m-01');
						// }
				$present = 0;
				$absent  = 0;
				$weekoff = 0;
				$holyday = 0;
				
				$emplid=$rows->Id;
				
				$data['name']=ucwords(getEmpName($rows->Id));
				$data['department']= ucwords(getDepartmentByEmpID($rows->Id));
				if($rows->EmployeeCode != "")
				$data['empcode'] = $rows->EmployeeCode;
			
			    else
				$data['empcode'] = "-";
				$data['totaldurations']=$this->workinghourofmonthlysummary($emplid,$startdate,$enddate);
				$data['shifthours']=$this->ShiftHours($emplid,$startdate,$enddate);
				$shiftid = $rows->Shift;
				//echo $startdate;
				while($startdate <= $enddate)
				{
					
				//	echo $startdate;
				$dateval[] =date('dS M',strtotime($startdate));
				//print_r(date('dS M',strtotime($startdate)));
				$sql1="SELECT A.TimeIn,A.TimeOut,AttendanceStatus,TIMEDIFF(A.TimeIn,S.TimeIn) as latecome,TIMEDIFF(S.TimeOut,A.TimeOut) as earlyleave,sec_to_time(time_to_sec(TIMEDIFF(A.TimeOut,A.TimeIn))) as 		officehour,
				SEC_TO_TIME(time_to_sec(TIMEDIFF(A.TimeOut,A.TimeIn))
					-CASE WHEN(A.TimeOut>S.TimeOutBreak) THEN time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn))
					ELSE time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)-time_to_sec(TIMEDIFF(S.TimeOutBreak,S.TimeInBreak))) END) as overtime,S.TimeIn as shifttimein ,S.TimeOut as shifttimeout,SEC_TO_TIME( TIME_TO_SEC( TIMEDIFF( A.TimeOut, A.TimeIn ) ) ) as over,SEC_TO_TIME( 
					CASE WHEN (
					A.TimeOut > S.TimeOutBreak
					)
					THEN TIME_TO_SEC( TIMEDIFF( S.TimeOut, S.TimeIn ) ) 
					ELSE TIME_TO_SEC( TIMEDIFF( S.TimeOut, S.TimeIn ) - TIME_TO_SEC( TIMEDIFF(S.TimeOutBreak, S.TimeInBreak ) ) ) 
					END ) as under,
					sec_to_time(time_to_sec(timediff(SEC_TO_TIME(CASE WHEN(A.TimeOut>S.TimeOutBreak)
					THEN time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)) 
					ELSE time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)-time_to_sec(TIMEDIFF(S.TimeOutBreak,S.TimeInBreak))) END),sec_to_time(time_to_sec(TIMEDIFF(A.TimeOut,A.TimeIn))))))as undertime 
					FROM AttendanceMaster A,ShiftMaster S 
					WHERE A.OrganizationId=? and  A.EmployeeId='$emplid' AND A.AttendanceDate =
					'$startdate' AND S.Id=A.ShiftId";
				
				//echo $sql1;
				$q11 = $this->db->query($sql1,array($orgid));
				
					if($row11 = $q11->row())
					{
						$sts = $row11->AttendanceStatus;
						$timein=substr($row11->TimeIn,0,-3);
						$timeout=substr($row11->TimeOut,0,-3);
						$shifttimein=substr($row11->shifttimein,0,-3);
						$shifttimeout=substr($row11->shifttimeout,0,-3);
						$over=substr($row11->over,0,-3);
						$under=substr($row11->under,0,-3);
						if($timein>$shifttimein)
						{
						  $latecome=substr($row11->latecome,0,-3);
						}
						else
						{
						  $latecome="-";
						}
						
						if($shifttimeout>$timeout)
						{
						 $earlyleave=substr($row11->earlyleave,0,-3);
						}
						else
						{
						 $earlyleave="-";
						}
					    $officehour=substr($row11->officehour,0,-3);
						
					    $overtime=substr($row11->overtime,0,-3);
					    
						
						if($row11->overtime==false)
						{
							$overtime = '00:00';
						}
						if($under > $over)
						{
						   $overtime='-';
						}
						
						$undertime=substr($row11->undertime,0,-3);
						if($row11->undertime==false)
						{
							$undertime = '00:00';
						}
						if($over> $under)
						{
						   $undertime='-';
						}
						
						$symbol = "";
						
							if($sts == 1)
							{
								$present++;
								$symbol="P";
							}
							else if($sts == 2)
							{	
								 $absent++;
								 $symbol ='A';
								 $timein='00:00';
								 $timeout='00:00';
								 $latecome='00:00';
								 $earlyleave='00:00';
								 $overtime='00:00';
								 $undertime='00:00';
								 $officehour='00:00';
							}
							else if($sts == 3)
							{
								$weekoff++;
								$symbol = 'WO';
							}
							else if($sts == 4)
							{
								$holyday++;
								$symbol = 'HD';
							}
							else if($sts == 5)
							{
								$symbol = 'H';
							}
							else if($sts == 7)
							{
							$symbol = "CO";
							}
							else if($sts == 8)
							{
								$symbol = "WFH";
							}
							else
							  $symbol = "-";
							 $temp[] = $symbol;
					}
		 			
									 else
									 {
									 $timein='00:00';
									 $timeout='00:00';
									 $latecome='00:00';
									 $earlyleave='00:00';
									 $overtime='00:00';
									 $undertime='00:00';
									 $officehour='00:00';
									 
									if(date('Y-m-d')>$startdate)
									{
										
										$t = $this->getweeklyoff($startdate,$shiftid,$emplid);
										$temp[] = $t; 
										if($t=="WO")
										$weekoff++;
										else if($t=="H")
										$holyday++;
									}
									 else
										$temp[] = "-"; 
									 }
									 
						 //$startdate = date('Y-m-d', strtotime($startdate . ' +1 days'));
				 $startdate = date('Y-m-d', strtotime($startdate . ' +1 days'));
				 
						 $temptimein[]   = $timein;
						 $temptimeout[]  = $timeout;
						 $latecommers[]  = $latecome;
						 $earlyleavers[] = $earlyleave;
						 $officehours[]  = $officehour;
						 $overtiming[]  = $overtime;
						 $undertiming[]  = $undertime;
					
				}
					$data['sts']=$temp;
					$data['timein']=$temptimein;
					$data['timeout']=$temptimeout;
					$data['latecome']=$latecommers;
					$data['earlyleave']=$earlyleavers;
					$data['officehours']=$officehours;
					$data['overtime']=$overtiming;
					$data['undertimee']=$undertiming;
					$data['present']=$present;
					$data['absent']=$absent;
					$data['weekoff']=$weekoff;
					$data['holyday']=$holyday;
				
					$res[] = $data;
				}
		$result['data'] = $res;
		$result['date'] = $dateval;
		return $result;	
	}*/
	
	
	function gatworkinghour($empid,$range)
		{
			
			$org_id = $_SESSION['orgid'];
			$query = $this->db->query("
			SELECT  SEC_TO_TIME(sum(time_to_sec(TIMEDIFF(A.TimeOut,A.TimeIn))- CASE WHEN(A.TimeOut>S.TimeOutBreak && A.TimeIn < S.TimeOutBreak) THEN time_to_sec(TIMEDIFF(S.TimeOutBreak,S.TimeInBreak)) ELSE 0 END)) as time FROM AttendanceMaster A,ShiftMaster S WHERE A.EmployeeId = ($empid) AND A.OrganizationId= $org_id AND A.AttendanceDate IN (".$range.") AND A.TimeOut > A.TimeIn AND A.TimeIn != '00:00:00' AND A.TimeOut != '00:00:00' AND A.HourlyRateId != 0 AND  S.Id = A.ShiftId");
		    if($row = $query->result_array())
			 {
				if($row[0]["time"] != null)
				{
					$length = strlen($row[0]["time"])-3;
					return (substr($row[0]["time"],0,$length));
				}
				else 
					return "00:00";
			 }
		  
	}
	
	
	
	function workinghour($empid,$startdate,$enddate)
		{
			$org_id = $_SESSION['orgid'];
			$query = $this->db->query("SELECT  SEC_TO_TIME(sum(time_to_sec(TIMEDIFF(A.TimeOut,A.TimeIn))- CASE WHEN(A.TimeOut>S.TimeOutBreak && A.TimeIn < S.TimeOutBreak ) THEN time_to_sec(TIMEDIFF(S.TimeOutBreak,S.TimeInBreak)) ELSE 0 END)) as time FROM AttendanceMaster A,ShiftMaster S WHERE A.EmployeeId = ($empid) AND A.OrganizationId= $org_id AND A.AttendanceDate between '$startdate' and '$enddate' AND A.TimeOut > A.TimeIn AND A.TimeIn != '00:00:00' AND A.TimeOut != '00:00:00' AND A.HourlyRateId != 0 AND S.Id = A.ShiftId ");
		    if($row = $query->result_array())
			 {
				if($row[0]["time"] != null)
				{
					$length = strlen($row[0]["time"])-3;
					return ( substr($row[0]["time"],0,$length));
				}
				else 
					return "00:00";
			 }
		  
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
	
	// function latehalfday($empid,$date)
		// {
			// $org_id = $_SESSION['orgid'];
			// $query = $this->db->query("SELECT  TIMEDIFF(S.TimeInBreak,A.TimeOut) AS early FROM AttendanceMaster A,ShiftMaster S WHERE A.EmployeeId = ($empid) AND A.OrganizationId= $org_id AND A.AttendanceDate = '$date'  and S.TimeInBreak >A.TimeOut AND S.TimeInBreak !='00:00:00' AND A.TimeOut != '00:00:00'  AND S.Id = A.ShiftId ");
		    // if($row = $query->result_array())
			 // {
				// if($row[0]["late"] != null)
				// {
					// $length = strlen($row[0]["late"])-3;
					// return ( substr($row[0]["late"],0,$length));
				// }
				// else 
					// return "00:00";
			 // }
	// }
	function workinghourofmonthlysummary($empid,$startdate,$enddate)
		{
			// if(A.timeoutdate!='0000-00-00',sec_to_time(time_to_sec(TIMEDIFF(CONCAT(A.timeoutdate,' ',A.TimeOut),CONCAT(A.timeindate,' ',A.TimeIn)))),sec_to_time(time_to_sec(TIMEDIFF(CONCAT(A.timeoutdate,' ',A.TimeOut),CONCAT(A.timeindate,' ',A.TimeIn)))))
		
			$org_id = $_SESSION['orgid'];
			$query = $this->db->query("
SELECT SEC_TO_TIME(sum(time_to_sec(

case when (A.timeindate='0000-00-00' || A.timeoutdate='0000-00-00') 
then TIMEDIFF(A.TimeOut,A.TimeIn) 
else 
TIMEDIFF(CONCAT(A.timeoutdate,'   ',A.TimeOut),CONCAT(A.timeindate,'  ',A.TimeIn))

end))) as time FROM AttendanceMaster A,ShiftMaster S WHERE A.EmployeeId = ($empid) AND A.OrganizationId= $org_id AND A.AttendanceDate between '$startdate' and '$enddate' AND A.TimeOut > A.TimeIn AND A.TimeIn != '00:00:00' AND A.TimeOut != '00:00:00' AND S.Id = A.ShiftId");
			// var_dump($this->db->last_query());
		    if($row = $query->result_array())
			 {
				if($row[0]["time"] != null)
				{
					$length = strlen($row[0]["time"])-3;
					return (substr($row[0]["time"],0,$length));
				}
				else 
					return "00:00";
			 }
		  
	   }
	
	// function ShiftHours($empid,$startdate,$enddate)
		// {
			// $org_id = $_SESSION['orgid'];
			// $query = $this->db->query("SELECT A.AttendanceDate, SEC_TO_TIME(sum(time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn))-time_to_sec(TIMEDIFF(
			// S.TimeOutBreak,S.TimeInBreak)))) as shifttime,A.AttendanceDate FROM AttendanceMaster A,ShiftMaster S WHERE A.EmployeeId = $empid AND A.OrganizationId= $org_id  AND A.AttendanceDate between '$startdate' and 
			// '$enddate'  AND S.Id = A.ShiftId ");
		    // if($row = $query->result_array())
			 // {
				// if($row[0]["shifttime"] != null)
				// {
					// $length = strlen($row[0]["shifttime"])-3;
					// return (substr($row[0]["shifttime"],0,$length));
				// }
				// else 
					// return "00:00";
			 // }
		  
	   // }
	
	// function ShiftHours($empid,$sts,$date)
		// {
			// $org_id = $_SESSION['orgid'];
			// if($sts==4)
			// {
			// $query = $this->db->query("SELECT A.AttendanceDate,A.AttendanceStatus, sum(time_to_sec(TIMEDIFF(S.TimeInBreak,S.TimeIn))) as shifttime,A.AttendanceDate FROM AttendanceMaster A,ShiftMaster S WHERE A.EmployeeId = $empid AND A.OrganizationId= $org_id  and  A.AttendanceDate = '$date' AND S.Id = A.ShiftId");
			// }
			// else
			// {
			// $query = $this->db->query("SELECT A.AttendanceDate,A.AttendanceStatus, sum(time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn))) as shifttime,A.AttendanceDate FROM AttendanceMaster A,ShiftMaster S WHERE A.EmployeeId = $empid AND A.OrganizationId= $org_id  AND A.AttendanceDate = '$date'  AND S.Id = A.ShiftId");
			// }
		    // if($row = $query->result_array())
			 // {
				// if($row[0]["shifttime"] != null)
				// {
					// //$length = strlen($row[0]["shifttime"])-3;
					// //return (substr($row[0]["shifttime"],0,$length));
					// return $row[0]["shifttime"];
				// }
				// else 
					
					// return "00:00";
			 // }
		  
	   // }
	function ShiftHours($empid,$startdate,$enddate)
		{
			$org_id = $_SESSION['orgid'];
			
			
			$query = $this->db->query("SELECT A.AttendanceDate,A.AttendanceStatus, sec_to_time(sum(time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)))) as shifttime,A.AttendanceDate FROM AttendanceMaster A,ShiftMaster S WHERE A.EmployeeId = $empid AND A.OrganizationId= $org_id  AND A.AttendanceDate between '$startdate' and '$enddate'  AND S.Id = A.ShiftId");
			// var_dump($this->db->last_query());
		    if($row = $query->result_array())
			 {
				if($row[0]["shifttime"] != null)
				{
					$length = strlen($row[0]["shifttime"])-3;
					return (substr($row[0]["shifttime"],0,$length));
					//return $row[0]["shifttime"];
				}
				else 
					
					return "00:00";
			 }
		  
	   }
	
		function gatoveundertime($empid,$date)
		{
			$org_id = $_SESSION['orgid'];
			//$currentdate = date("y-m-d");
			$query = $this->db->query("SELECT SEC_TO_TIME(sum(time_to_sec( TIMEDIFF(A.TimeOut,A.TimeIn))-CASE WHEN(A.TimeOut>S.TimeOutBreak) THEN time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)) ELSE time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)-time_to_sec(TIMEDIFF(S.TimeOutBreak,S.TimeInBreak))) END)) as time FROM AttendanceMaster A,ShiftMaster S WHERE A.EmployeeId = ($empid) AND A.OrganizationId= $org_id AND A.AttendanceDate = '$date'   AND A.TimeOut > A.TimeIn AND A.TimeIn != 'null' AND A.TimeOut != 'null' AND S.Id = A.ShiftId ");
		    if($row = $query->result_array())
			 {
				if($row[0]["time"] != null)
				{
					$length = strlen($row[0]["time"])-3;
					return ( substr($row[0]["time"],0,$length) );
				}
				else 
					return "-";
			   
			 }
		}
	
	
	////Latecoming
	
	public function getLate(){
			$orgid=$_SESSION['orgid'];
	        $date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
	        $shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:'';
		    $deprtid=isset($_REQUEST['deprt'])?$_REQUEST['deprt']:'';
			$emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:'';
			$desgid=isset($_REQUEST['desg'])?$_REQUEST['desg']:'';
			$q="";
			if($date=='')
			{
				 $enddate=date("Y-m-d");
		         $startdate=date('Y-m-d',(strtotime ( '-7 day',strtotime(date('Y-m-d'))) ));
			     $q=" AND  `AttendanceDate` BETWEEN  '$startdate' AND '$enddate' ";
			}
			if($deprtid!=0)
				{
				$arr=explode('-', trim($date));
				$end= date('Y-m-d',strtotime($arr[1]));
				$strt= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3))); 
			    //echo strlen(trim($arr[0]));
			    $q.=" AND  EmployeeId IN(SELECT `Id` FROM `EmployeeMaster` 
			     WHERE `Department` = '$deprtid')";
			  } 
			if($shiftid!=0)
				{
				$q.=" AND `ShiftId`='$shiftid' AND `TimeIn` > (SELECT `TimeIn` FROM `ShiftMaster` WHERE  `Id`='$shiftid') ";
				}
            if($desgid!=0)
				{
				$arr=explode('-', trim($date));
				$end= date('Y-m-d',strtotime($arr[1]));
				$strt= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3))); 
			   //echo strlen(trim($arr[0]));
			
			 $q.=" AND  EmployeeId IN( SELECT `Id` FROM `EmployeeMaster` 
			  WHERE `Designation` = '$desgid' ) ";
				
			} 

          if($emplid!=0)
			{
				$q.=" AND `EmployeeId`='$emplid' ";
			}			
		  if($date!='')
				{
				$arr=explode('-', trim($date));
				$end= date('Y-m-d',strtotime($arr[1]));
				$strt= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3))); 
			    $q.=" AND `AttendanceDate` BETWEEN  '$strt' AND '$end' ";
			  }
			
		     $sql="SELECT EmployeeId,AttendanceDate,TimeIn,TimeOut,ShiftId,TIMEDIFF(`TimeOut`,`TimeIn`) AS stype  FROM `AttendanceMaster` WHERE OrganizationId =? AND time(TimeIn) > (select time(TimeIn) from ShiftMaster where ShiftMaster.Id=shiftId) $q   ORDER BY `AttendanceDate`";
			//$sql="SELECT *  FROM  `AttendanceMaster` WHERE OrganizationId =?  AND `TimeIn` >IN(SELECT TimeIn FROM `ShiftMaster` ) $q  ORDER BY `TimeIn` DESC";
			//$sql="SELECT EmployeeId,AttendanceDate,COUNT(AttendanceDate)as ad,TimeIn,TimeOut,ShiftId,TIMEDIFF(`TimeOut`,`TimeIn`) AS stype  FROM `AttendanceMaster` WHERE OrganizationId =?  $q  ORDER BY `TimeIn` DESC GROUP BY AttendanceDate";
			$query = $this->db->query($sql,array($orgid));
			//echo $sql;
			 $d=array();
			 $res=array();
			foreach ($query->result() as $row)
			 {
				$data=array();
					 $data['Name']=ucwords(getEmpName($row->EmployeeId));
				     //$data['date']=$row->AttendanceDate ;
					 //$test1='2010-04-19 18:31:27';
                    // echo date('d/m/Y',strtotime($test1));
				    $data['date']= date('d-M-Y',strtotime($row->AttendanceDate));
					$data['TimeIn']=substr(($row->TimeIn),0,5);
					$data['TimeOut']=$row->TimeOut;
					//$data['ad']=$row->ad;
					$data['Totaltime']=$row->stype;
					$a = new DateTime(substr (getShiftTimes($row->ShiftId),0,5));
                    $b = new DateTime($row->TimeIn);
                    $interval = $a->diff($b);
                    $data['LateHours']=$interval->format("%H:%I");
					$Tio=getShiftTimes($row->ShiftId);
				    $data['desg']=ucwords(getDesignationByEmpID($row->EmployeeId));
				    $data['shift']=getShift($row->ShiftId)." (".$Tio.")";
				    $data['depart']=ucwords(getDepartmentByEmpID($row->EmployeeId));
					$res[]=$data;
			} 
             $d['data']=$res; 
             $this->db->close();			//$query->result();
			echo json_encode($d); return false;
		}
	 // late commers report By sohan 
	// public function getLate__new()
	 // {
		    // $orgid=$_SESSION['orgid'];
	        // $date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
	        // $shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:'';
		    // $deprtid=isset($_REQUEST['deprt'])?$_REQUEST['deprt']:'';
			// $emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:'';
			// $desgid=isset($_REQUEST['desg'])?$_REQUEST['desg']:'';
			// $q="";
			
			// if($date=='')
			 // {
				 // $enddate=date("Y-m-d");
		         // $startdate=date('Y-m-d',(strtotime ( '-7 day',strtotime(date('Y-m-d'))) ));
			     // $q=" AND  `AttendanceDate` BETWEEN  '$startdate' AND '$enddate' ";
			 // }
			// if($deprtid!=0)
				// {
			     // $q.=" AND Dept_id = '$deprtid'  ";
			    // } 
			// if($shiftid!=0)
				// {
			    // $q.=" AND `ShiftId`='$shiftid' AND `TimeIn` > (SELECT `TimeIn` FROM `ShiftMaster` WHERE  `Id`='$shiftid') ";	
			   // }
            // if($desgid!=0)
				// {
				
			     // $q.=" AND Desg_id = '$desgid'  ";
		    	// } 

			  // if($emplid!=0)
				// {
					// $q.=" AND `EmployeeId`='$emplid' ";
				// }			
		  // if($date!='')
				// {
					
				// $arr=explode('-', trim($date));
				// $end= date('Y-m-d',strtotime($arr[1]));
				// $strt= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3))); 
			    // $q.=" AND `AttendanceDate` BETWEEN  '$strt' AND '$end' ";
			  // }
			
		     // $sql="SELECT EmployeeId,AttendanceDate,TimeIn,Dept_id,Desg_id,TimeOut,ShiftId,TIMEDIFF(`TimeOut`,`TimeIn`) AS stype  FROM `AttendanceMaster` WHERE OrganizationId =? AND time(TimeIn) > (select time(TimeIn) from ShiftMaster where ShiftMaster.Id=shiftId) $q   ORDER BY `AttendanceDate` desc ";
			 // $query = $this->db->query($sql,array($orgid));
			 
			 
			 
			 // $d=array();
			 // $res=array();
			// foreach ($query->result() as $row)
			 // {
				    // $data=array();
					// $name  = ucwords(getEmpName($row->EmployeeId));
					// if($name != "")
					// {
					// $data['Name']= $name;
				    // $data['date']= date('d-M-Y',strtotime($row->AttendanceDate));
					// $data['TimeIn']=substr(($row->TimeIn),0,5);
					// $data['TimeOut']=$row->	TimeOut;
					// //$data['ad']=$row->ad;
					// $data['Totaltime']=$row->stype;
					// $a = new DateTime(substr (getShiftTimes($row->ShiftId),0,5));
                    // $b = new DateTime($row->TimeIn);
                    // $interval = $a->diff($b);
                    // $data['LateHours']=$interval->format("%H:%I");
					// $Tio=getShiftTimes($row->ShiftId);
				    // $data['desg']=ucwords(getDesignation($row->Desg_id));
				    // $data['shift']=getShift($row->ShiftId)." (".$Tio.")";
				    // $data['depart']=ucwords(getDepartment($row->Dept_id));
					// $res[]=$data;
				 // }
			// } 
             // $d['data']=$res; 
             // $this->db->close();			//$query->result();
			// echo json_encode($d); return false;
	// }	
		
	public function getLate__new(){
			$orgid=$_SESSION['orgid'];
	        $date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
	        $shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:'';
		    $deprtid=isset($_REQUEST['deprt'])?$_REQUEST['deprt']:'';
			$emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:'';
			$desgid=isset($_REQUEST['desg'])?$_REQUEST['desg']:'';
			$q="";
			if($date=='')
			{
				
				$datestatus=isset($_REQUEST['datestatus'])?$_REQUEST['datestatus']:0;
				 if($datestatus == 7)
				 {
				  $enddate=date('Y-m-d');
				  $startdate=date('Y-m-d', strtotime('-6 day', strtotime($enddate)));
				 // echo  $enddate;
				 // echo  $startdate;
				  $q=" AND  `AttendanceDate` BETWEEN  '$startdate' AND '$enddate' ";
				 }
				 else
				 {
				   $enddate=date("Y-m-d");
				   $startdate=date("Y-m-d"); 
				   echo $enddate;
				   echo $startdate;
				   $q=" AND  `AttendanceDate` BETWEEN  '$startdate' AND '$enddate' ";
				 }
				
			}
			if($deprtid!=0)
				{
				$arr=explode('-', trim($date));
				$end= date('Y-m-d',strtotime($arr[1]));
				$strt= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3))); 
			    //echo strlen(trim($arr[0]));
			
			 $q.=" AND  EmployeeId IN( SELECT `Id` FROM `EmployeeMaster` 
			  WHERE `Department` = '$deprtid' ) ";
				
			} 
			if($shiftid!=0)
				{
				
			$q.=" AND `ShiftId`='$shiftid' AND `TimeIn` > (SELECT `TimeIn` FROM `ShiftMaster` WHERE  `Id`='$shiftid') ";
				
			}
            if($desgid!=0)
				{
				$arr=explode('-', trim($date));
				$end= date('Y-m-d',strtotime($arr[1]));
				$strt= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3))); 
			
			 $q.=" AND  EmployeeId IN( SELECT `Id` FROM `EmployeeMaster` 
			  WHERE `Designation` = '$desgid' ) ";
				
			} 

          if($emplid!=0)
			{
				$q.=" AND `EmployeeId`='$emplid' ";
			}			
		  if($date!='')
				{
				
					$arr=explode('-', trim($date));
					$end= date('Y-m-d',strtotime($arr[1]));
					
					 $strt= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3))); 
					
					$q.=" AND `AttendanceDate` BETWEEN  '$strt' AND '$end' ";
				}	
		     // $sql="SELECT E.Id,E.EmployeeCode,A.AttendanceStatus,A.EmployeeId,A.device,A.AttendanceDate,A.TimeIn,A.TimeOut,A.ShiftId,TIMEDIFF(`TimeOut`,`TimeIn`) AS stype  FROM AttendanceMaster A,EmployeeMaster E WHERE E.Id=A.EmployeeId and  A.OrganizationId =? AND E.Is_Delete = 0 AND time(TimeIn) > (select time(TimeIn) from ShiftMaster where ShiftMaster.Id=shiftId) $q  ORDER BY `AttendanceDate`";
				$q2=$this->db->query("Select  EmployeeId from AttendanceMaster where OrganizationId = '$orgid'  group by EmployeeId");
				
				
			foreach($q2->result() as $row1)

				{
				$empid=$row1->EmployeeId;
				
				// $sql="SELECT EmployeeId,AttendanceDate,TimeIn,Dept_id,Desg_id,TimeOut,ShiftId,
					// TIMEDIFF(`TimeOut`,`TimeIn`) AS stype  FROM `AttendanceMaster` WHERE  
					// EmployeeId=$empid AND  time(TimeIn) > (select time(TimeIn) from ShiftMaster where ShiftMaster.Id=shiftId) $q  GROUP BY `AttendanceDate` ";
					
				$sql="SELECT A.AttendanceDate,E.EmployeeCode ,S.TimeInGrace,A.EmployeeId as empid ,A.device, TIMEDIFF(A.TimeIn,S.TimeIn) as stype, A.Dept_id as Dept_id, A.Desg_id as Desg_id, A.TimeIn as atimein , S.TimeIn as stimein,S.TimeOut as stimeout,A.TimeOut as TimeOut,A.ShiftId as ShiftId  FROM  AttendanceMaster A , ShiftMaster S,EmployeeMaster E  WHERE A.ShiftId=S.Id AND A.OrganizationId = S.OrganizationId AND A.TimeIn > (select(case when(S.TimeInGrace !='00:00:00') then S.TimeInGrace else S.TimeIn end) from ShiftMaster S where S.Id=ShiftId)  $q AND A.EmployeeId=$empid and   A.TimeIn != '00:00:00'   group by A.AttendanceDate";


				// >(select(case when(S.TimeInGrace !='00:00:00') then S.TimeInGrace else S.TimeIn end) from ShiftMaster S where) 

			// var_dump($sql);

			// die;
				$query = $this->db->query($sql);
				
				
					foreach ($query->result() as $row)
					{
							$data=array();
							$name  = ucwords(getEmpName($row->empid));
								if($name != "")
								{
									$data['Name']= $name;
									$data['code']=$row->EmployeeCode;
									$data['date']= date('M d,Y',strtotime($row->AttendanceDate));
									$data['TimeIn']=substr(($row->atimein),0,5);
									$data['TimeOut']=$row->	TimeOut;
									$data['Totaltime']=$row->stype;
									$a = new DateTime(substr (getShiftTimes($row->ShiftId),0,5));
									$c = new DateTime($row->TimeInGrace);
				
									$b = new DateTime($row->atimein);

									$interval = "";
									if($row->TimeInGrace = "00:00:00"){
									$interval =$b->diff($c);
								}else{
									$interval =$c->diff($a);

									// var_dump($interval);
								}
								    $data['LateHours']=$interval->format("%H:%I");
									// var_dump($shakir);
									// die;
									$Tio=getShiftTimes($row->ShiftId);
									$data['desg']=ucwords(getDesignation($row->Desg_id));
									$data['shift']=getShift($row->ShiftId)." (".$Tio.")";
									$data['depart']=ucwords(getDepartment($row->Dept_id));
									$data['device']=$row->device;
									$res[]=$data;
								}
					}
				
				}
             $d['data']=$res; 

             $this->db->close();			//$query->result();
			echo json_encode($d); return false;
		}	
		
		
		
		
		public function getEmployeeSummaryReport(){
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
							 //$d = date('d')-1;
							 $startdate=date('Y-m-d',(strtotime ( "-7 day",strtotime(date('Y-m-d'))) ));
							 $q=" AND  `AttendanceDate` BETWEEN  '$startdate' AND '$enddate' ";
						}
		//////////////////////////////////////////////////////////////////////////
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
				
          /////////////////////////////////////////////////////////////////////////				
	$query = $this->db->query("SELECT Id,CONCAT(Firstname,' ',Lastname) as name,Department,Designation,Shift from EmployeeMaster where OrganizationId=? AND DOL = '0000:00:00' $q1 order by Firstname",array($orgid));
				
				$d=array();
				$res=array();
				
				foreach ($query->result() as $row)
			 {	
			 	$emplid = $row->Id;
			 	$depart = $row->Department;
				$sql1 = $this->db->query("SELECT  A.ShiftId as shift, A.AttendanceDate as atdate,C.shifttype as ctype,A.TimeIn as timein,A.TimeOut as timeout,C.TimeIn as ctimein,C.TimeOut as ctimeout,C.Name as cname, CASE WHEN(A.TimeIn > C.TimeIn) THEN (TIMEDIFF(A.TimeIn,C.TimeIn)) ELSE ('-') END as late, CASE WHEN(A.TimeOut < C.TimeOut) THEN (TIMEDIFF(C.TimeOut,A.TimeOut)) ELSE ('-') END as early FROM AttendanceMaster A,ShiftMaster C WHERE  C.Id = A.ShiftId $q  AND A.EmployeeId = $emplid AND A.OrganizationId = $orgid AND A.TimeIn != '0000:00:00' AND A.TimeOut != '0000:00:00'");
				
				
			 	foreach($sql1->result() as $row1)
			 	{	$data=array();					
					//$data['date']=date('d/m/Y',strtotime($row1->atdate));
					$data['Name']=ucwords($row->name);				    
				    $Tio=getShiftTimes($row1->shift);
				    $data['desg']= getDesignation($row->Designation);
				    $data['absent']=$this->absent($emplid,$q);
					$data['shift']= getShift($row1->shift)."(".$Tio.")";
					$data['TimeIn']=(substr($row1->timein,0,5));
					$data['lateby']= substr($row1->late,0,5);
					$data['TimeOut']= substr($row1->timeout,0,5);
					
					if(strtotime($row1->timeout)<strtotime($row1->ctimeout))
						{
						  $data['earlyby'] = substr($row1->early,0,5);	
						}
						else
						{
						if(strtotime($row1->timeout) > strtotime($row1->ctimeout) && strtotime($row1->ctimein) > strtotime($row1->ctimeout) && strtotime($row1->timein) <= strtotime($row1->timeout) )
							{
								 $time = "24:00:00";
								 $secs = strtotime($row1->timeout)-strtotime($row1->ctimeout);
								 $data['earlyby'] = date("H:i",strtotime($time)-$secs); 
							}
							else
							{
								$data['earlyby'] = "-";
							}
							
						}
					
					if(strtotime($row1->timein) <= strtotime($row1->timeout) && strtotime($row1->ctimein) <= strtotime($row1->ctimeout) )
						$data['outime']= $this->gatoveundertime($emplid,$row1->atdate);
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
								 $data['outime']= $interval->format("%H:%I");	
								}
								else
								{
								  $interval = $b->diff($a);
								  $a = new DateTime($interval->format("%H:%I"));
								  $b = new DateTime(getShiftBreak($row1->shift));
								  $interval1 = $b->diff($a);
								  $data['outime']= "-".$interval1->format("%H:%I");			
								}
								
                         }
					/////////////////////////////////
					$data['timeoff']=$this->TimeOfff($emplid,$row1->atdate);
					
					//$data['Totaltime']=$this->gatworkinghour($emplid,$row1->atdate);	
                     /////////////////////// working hours calculation
                        if(strtotime($row1->timein) <= strtotime($row1->timeout))
						$data['workhours']= $this->gatworkinghour($emplid ,$row1->atdate);
					    else
						{
								$time = "24:00:00";
								$secs = strtotime($row1->timein)-strtotime($row1->timeout);
								$data['var'] = date("H:i",strtotime($time)-$secs);
								$a = new DateTime($data['var']);
								$b = new DateTime(getShiftBreak($row1->shift));
								
								$interval = $b->diff($a);
								$data['workhours']= $interval->format("%H:%I");	
						}					 
                     ///////////////////////					
				    $data['dept']= getDepartment($row->Department);
					$res[]=$data;
					}
				}
				$d['data']=$res;
				$this->db->close();	
			echo json_encode($d); return false;
		}
		/*			  
					    $data=array();
						$data['Name']=ucwords($row->name);
						$data['desg']= getDesignation($row->Designation);
						$data['dept']= getDepartment($row->Department);
						$data['absent']=$this->absent($row->Id,$q);
						$data['lateby']= $this->LateBy($row->Id,$q);
						$data['earlyby']= $this->EarlyBy($row->Id,$q);
						$data['outime']= $this->getoveundertime($row->Id,$q);
						$data['timeoff']= $this->TimeOf($row->Id,$date);
						$data['workhours']= $this->getworkinghour($row->Id,$q);
						$res[]=$data;
				} 
		
		
		*/
		
		
		///////////some function by sohan////////////
		function absent($id,$q)
		{
			
			// return "$id";
			$orgid=$_SESSION['orgid'];
			$date = date("Y-m-d");
			$sql = $this->db->query("SELECT * FROM AttendanceMaster where EmployeeId=? AND OrganizationId=? $q AND AttendanceStatus in (2,6)",array($id,$orgid));
			$row = $this->db->affected_rows();
		    if($row != 0)
			{
				return $row;
			}
			else
			return "0";
		
		}
		function LateBy($empid,$q)
		{
			
			$org_id = $_SESSION['orgid'];
			$currentdate = date("y-m-d");
			$query = $this->db->query("SELECT SEC_TO_TIME(sum(time_to_sec(TIMEDIFF(A.TimeIn,C.TimeIn))) )as time FROM AttendanceMaster A, ShiftMaster C WHERE A.EmployeeId = ($empid) AND A.OrganizationId= $org_id $q AND C.OrganizationId= $org_id AND C.Id = A.ShiftId  AND A.TimeIn > C.TimeIn AND A.TimeIn != 'null'");
			
		     if( $row = $query->result_array())
			 {
				if($row[0]["time"] != null)
				{
					$length = strlen($row[0]["time"])-3;
					return ( substr($row[0]["time"],0,$length) );
				}
				else
					return "-";
			 }
			/*$query = $this->db->query("SELECT SEC_TO_TIME(sum(time_to_sec(TIMEDIFF(A.TimeIn,C.TimeIn))) )as time FROM AttendanceMaster A, ShiftMaster C WHERE A.EmployeeId = ($empid) AND A.OrganizationId= $org_id $q AND C.OrganizationId= $org_id AND C.Id = A.ShiftId  AND A.TimeIn > C.TimeIn AND A.TimeIn != 'null' AND C.TimeIn > C.TimeOut ");*/
		}
		function EarlyBy($empid,$q)
		{
			
			$org_id = $_SESSION['orgid'];
			$currentdate = date("y-m-d");
			$a='';
			$b='';
			$query = $this->db->query("SELECT SEC_TO_TIME(sum(time_to_sec(TIMEDIFF(C.TimeOut,A.TimeOut)))) as time FROM AttendanceMaster A, ShiftMaster C WHERE A.EmployeeId = ($empid) AND A.OrganizationId= $org_id $q AND C.OrganizationId= $org_id AND C.Id = A.ShiftId   AND A.TimeOut < C.TimeOut AND A.TimeOut != '00:00:00' AND C.TimeIn<C.TimeOut");
		     if( $row = $query->result_array())
			 {
				if($row[0]["time"] != null)
				{
					$length = strlen($row[0]["time"]);
					$b =  ( substr($row[0]["time"],0,$length) );
				}
				else
				    $b = "00:00:00";
			 }
			 
			 /*"SELECT SEC_TO_TIME(sum(time_to_sec(CASE WHEN(A.TimeOut>C.TimeOut && A.TimeIn<=A.TimeOut) THEN(TIMEDIFF('24:00:00',TIMEDIFF(A.TimeOut,C.TimeOut))) ELSE('00:00:00') END ))) as time FROM AttendanceMaster A, ShiftMaster C WHERE A.EmployeeId = ($empid) AND A.OrganizationId= $org_id $q AND C.OrganizationId= $org_id AND C.Id = A.ShiftId   AND  A.TimeOut != '00:00:00'AND A.TimeIn != '00:00:00' AND C.TimeIn > C.TimeOut"*/
			 
			 $query = $this->db->query("SELECT SEC_TO_TIME(sum(time_to_sec(CASE WHEN(A.TimeOut>C.TimeOut && A.TimeIn<=A.TimeOut) THEN(TIMEDIFF('24:00:00',TIMEDIFF(A.TimeOut,C.TimeOut))) ELSE('00:00:00') END ))) as time FROM AttendanceMaster A, ShiftMaster C WHERE A.EmployeeId = ($empid) AND A.OrganizationId= $org_id $q AND C.OrganizationId= $org_id AND C.Id = A.ShiftId   AND  A.TimeOut != '00:00:00'AND A.TimeIn != '00:00:00' AND C.TimeIn > C.TimeOut");
			 if( $row1 = $query->result_array())
			 {
				if($row1[0]["time"] != null)
				{
					$length = strlen($row1[0]["time"]);
					$a =  ( substr($row1[0]["time"],0,$length) );
				}
				else
				  $a = "00:00:00";
			 }
		     return substr(sum_the_time($a,$b),0,5);
	           //return $b;
		}
		function TimeOf($empid,$date)
		{   
		     $q = "" ;
			if($date != '')
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
				 $d = date('d')-1;
			    $startdate=date('Y-m-d',(strtotime ( "-$d day",strtotime(date('Y-m-d'))) ));
			     $q=" AND  `TimeofDate` BETWEEN  '$startdate' AND '$enddate' ";
			}
			$org_id = $_SESSION['orgid'];
			$currentdate = date("y-m-d");
			$query = $this->db->query("SELECT SEC_TO_TIME(sum(time_to_sec( TIMEDIFF(T.TimeTo,T.TimeFrom))) )as time FROM Timeoff T WHERE T.EmployeeId = ($empid) AND T.OrganizationId= $org_id $q  AND T.TimeFrom < T.TimeTo AND T.TimeFrom != '00:00:00' AND T.TimeTo != '00:00:00'");
		     if( $row = $query->result_array())
			 {
				  if($row[0]["time"] == null)
			     return "-";
			     else
			    return ( substr($row[0]["time"],0,5) );
			 }
		}
		function getworkinghour($empid,$date)
		{
		$org_id = $_SESSION['orgid'];
		
				  $q = "";
				  $startdate='';
					if($date != '')
						{
							$arr=explode('-', trim($date));
							$enddate= date('Y-m-d',strtotime($arr[1]));
							$startdate= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3))); 
						   $q ="AND A.AttendanceDate BETWEEN  '$startdate' AND '$enddate' ";
						}
						else
						{
							 $enddate=date("Y-m-d");
							 $startdate=date('Y-m-d',(strtotime ( "-7 day",strtotime(date('Y-m-d'))) ));
							 $q=" AND  A.AttendanceDate BETWEEN  '$startdate' AND '$enddate' ";
						}
		//////////////////////////////////////////////////////////////////////////
		       
			$a="";
			$b="";
			$query = $this->db->query("SELECT SEC_TO_TIME(sum(time_to_sec(CASE WHEN(A.TimeOut>=A.TimeIn) THEN TIMEDIFF(A.TimeOut,A.TimeIn) ELSE TIMEDIFF('24:00:00',TIMEDIFF(A.TimeIn,A.TimeOut)) end )- CASE WHEN(S.TimeOutBreak > S.TimeInBreak) THEN (CASE WHEN(A.TimeOut>S.TimeOutBreak && A.TimeIn < S.TimeOutBreak ) THEN time_to_sec(TIMEDIFF(S.TimeOutBreak,S.TimeInBreak)) ELSE (0) END) ELSE (time_to_sec(TIMEDIFF('24:00:00',TIMEDIFF(S.TimeInBreak,S.TimeOutBreak)))) END ))
			as time FROM AttendanceMaster A,ShiftMaster S WHERE A.EmployeeId = ($empid) AND A.OrganizationId= $org_id  $q AND A.TimeIn != '00:00:00' AND A.TimeOut != 'null' AND S.Id = A.ShiftId AND S.TimeIn > S.TimeOut");
			if( $row1 = $query->result_array())
			 {
				if($row1[0]["time"] != null)
				{
					$length = strlen($row1[0]["time"]);
					$a = ( substr($row1[0]["time"],0,$length) );
				}
				else
					$a= "00:00:00";
			 }

			$query = $this->db->query("SELECT SEC_TO_TIME(sum(time_to_sec(TIMEDIFF(A.TimeOut,A.TimeIn))- CASE WHEN(A.TimeOut>S.TimeOutBreak && A.TimeIn < S.TimeOutBreak ) THEN time_to_sec(TIMEDIFF(S.TimeOutBreak,S.TimeInBreak)) ELSE 0 END)) as time FROM AttendanceMaster A,ShiftMaster S WHERE A.EmployeeId = ($empid) AND A.OrganizationId= $org_id  $q  AND A.TimeOut > A.TimeIn AND A.TimeIn != 'null' AND A.TimeOut != 'null' AND S.Id = A.ShiftId AND S.TimeIn < S.TimeOut ");
		    if( $row = $query->result_array())
			 {
				if($row[0]["time"] != null)
				{
					$length = strlen($row[0]["time"]);
					$b= ( substr($row[0]["time"],0,$length) );
				}
				else
					$b = "00:00:00";
			 }
			 $length = strlen(sum_the_time($a,$b))-3;
			 return substr(sum_the_time($a,$b),0,$length);
		
		}
		function getoveundertime($empid,$q)
		{
			
			$org_id = $_SESSION['orgid'];
			//$currentdate = date("y-m-d");
			$query = $this->db->query("SELECT SEC_TO_TIME(sum(time_to_sec( TIMEDIFF(A.TimeOut,A.TimeIn))-CASE WHEN(A.TimeOut>S.TimeOutBreak) THEN time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)) ELSE time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)-time_to_sec(TIMEDIFF(S.TimeOutBreak,S.TimeInBreak))) END)) as time FROM AttendanceMaster A,ShiftMaster S WHERE A.EmployeeId = ($empid) AND A.OrganizationId= $org_id  $q  AND A.TimeOut > A.TimeIn AND A.TimeIn != 'null' AND A.TimeOut != 'null' AND S.Id = A.ShiftId ");
		    if( $row = $query->result_array())
			 {
				if($row[0]["time"] != null)
				{
					$length = strlen($row[0]["time"])-3;
					return ( substr($row[0]["time"],0,$length) );
				}
			   
			 }
		}
		//////////////end function that make by sohan
		
		
		public function getearlyleave(){
			$orgid=$_SESSION['orgid'];
	        $date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
	        $shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:'';
		    $deprtid=isset($_REQUEST['deprt'])?$_REQUEST['deprt']:'';
			$emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:'';
			$desgid=isset($_REQUEST['desg'])?$_REQUEST['desg']:'';
			$q="";
			if($date=='')
			{
				 $enddate=date("Y-m-d");
		         $startdate=date('Y-m-d',(strtotime ( '-7 day',strtotime(date('Y-m-d'))) ));
				 
			     $q=" AND  `AttendanceDate` BETWEEN  '$startdate' AND '$enddate' ";
			}
			if($deprtid!=0)
				{
				$arr=explode('-', trim($date));
				$end= date('Y-m-d',strtotime($arr[1]));
				$strt= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3))); 
			    //echo strlen(trim($arr[0]));
			
			 $q.=" AND  EmployeeId IN( SELECT `Id` FROM `EmployeeMaster` 
			  WHERE `Department` = '$deprtid' ) ";
				
			} 
			if($shiftid!=0)
				{
				
			$q.=" AND ShiftId ='$shiftid'";
				
			}
            if($desgid!=0)
				{
				$arr=explode('-', trim($date));
				$end= date('Y-m-d',strtotime($arr[1]));
				$strt= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3))); 
			//echo strlen(trim($arr[0]));
			
			 $q.=" AND  EmployeeId IN( SELECT `Id` FROM `EmployeeMaster` 
			  WHERE `Designation` = '$desgid' ) ";
				
			} 

          if($emplid!=0)
			{
				$q.=" AND `EmployeeId`='$emplid' ";
			}			
		  if($date!='')
			  {
				$arr=explode('-', trim($date));
				$end= date('Y-m-d',strtotime($arr[1]));
				$strt= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3))); 
			    $q.=" AND `AttendanceDate` BETWEEN  '$strt' AND '$end' ";
			  }
			
           $sql="SELECT A.EmployeeId as id , A.AttendanceDate as date,A.TimeOut as timeout,A.ShiftId as sid,TIMEDIFF(S.TimeOut,A.TimeOut) AS stype  FROM AttendanceMaster A,ShiftMaster S WHERE S.Id = A.shiftId AND A.OrganizationId =? AND S.TimeOut > A.TimeOut AND A.TimeOut != '0000:00:00' $q  ORDER BY A.AttendanceDate";
			$query = $this->db->query($sql,array($orgid));
			
			 $d=array();
			 $res=array();
			foreach ($query->result() as $row)
			 {
				  $data=array();
					$data['Name']=ucwords(getEmpName($row->id));
				    //$data['date']=$row->AttendanceDate ;
				    $data['date']= date('d-M-Y',strtotime($row->date));
					$data['TimeOut']= substr($row->timeout,0,5);
					//$data['Totaltime']=$row->stype;
					//$a = new DateTime(substr (getShiftTimes($row->sid),0,5));
                    //$b = new DateTime($row->TimeIn);
                    //$interval = $a->diff($b);
                    $data['LateHours']=substr($row->stype,0,5);//$interval->format("%H:%I");
					$Tio=getShiftTimes($row->sid);
				    $data['desg']=ucwords(getDesignationByEmpID($row->id));
				    $data['shift']=getShift($row->sid)." (".$Tio.")";
				    $data['depart']=ucwords(getDepartmentByEmpID($row->id));
					$res[]=$data;
					
			} 
             $d['data']=$res; 
             $this->db->close();			//$query->result();
			echo json_encode($d); return false;
		}
    	////EarlyleaveReport
		
		
	      // get early report by sohan
	  public function getearlyleave__new(){
			$orgid=$_SESSION['orgid'];
	        $date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
	        $shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:'';
		    $deprtid=isset($_REQUEST['deprt'])?$_REQUEST['deprt']:'';
			$emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:'';
			$desgid=isset($_REQUEST['desg'])?$_REQUEST['desg']:'';
			$q="";
			if($date=='')
			{
				$datestatus=isset($_REQUEST['datestatus'])?$_REQUEST['datestatus']:0;
				 if($datestatus == 7)
				 {
				  $enddate=date('Y-m-d');
				  $startdate=date('Y-m-d', strtotime('-6 day', strtotime($enddate)));
				  $q=" AND  `AttendanceDate` BETWEEN  '$startdate' AND '$enddate' ";
				 }
				 else
				 {
				   $enddate=date("Y-m-d");
				   $startdate=date("Y-m-d"); 
				   $q=" AND  `AttendanceDate` BETWEEN  '$startdate' AND '$enddate' ";
				 }
			}
			if($deprtid!=0)
				{
					$q.="AND Dept_id  = '$deprtid'  ";
				} 
			if($shiftid!=0)
			 {
			   $q.=" AND ShiftId ='$shiftid'";
			 }
            if($desgid!=0)
			 {
			    $q.=" AND Desg_id  = '$desgid' ) ";
			 } 
          if($emplid!=0)
			{
			$q.=" AND EmployeeId='$emplid' ";
			}			
				if($date!='')
				{
				$arr=explode('-', trim($date));
				$end= date('Y-m-d',strtotime($arr[1]));
				$strt= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3)));
			    $q.=" AND AttendanceDate BETWEEN  '$strt' AND '$end' ";
				}
			
          // $sql="SELECT E.Id,E.EmployeeCode,A.AttendanceStatus,A.EmployeeId as id,A.device,A.AttendanceDate as date,A.timeoutdate,A.Dept_id as departid,A.Desg_id as degid,A.TimeOut as timeout,A.ShiftId as sid,TIMEDIFF(S.TimeOut,A.TimeOut) AS stype  FROM AttendanceMaster A,ShiftMaster S,EmployeeMaster E WHERE S.Id = A.shiftId AND A.OrganizationId =? AND S.TimeOut > A.TimeOut AND A.TimeOut != '0000:00:00'  $q and E.Id=A.EmployeeId And E.Is_Delete = 0 ORDER BY A.AttendanceDate desc";
		  
		   $sql="SELECT S.TimeOut,A.TimeOut,E.Id,E.EmployeeCode,S.TimeOutGrace,A.AttendanceStatus,A.EmployeeId as id,A.device,A.AttendanceDate as date,A.timeoutdate,A.Dept_id as departid,A.Desg_id as degid,A.TimeOut as timeout,A.ShiftId as sid,if(A.timeoutdate!='0000-00-00',TIMEDIFF(CONCAT(A.AttendanceDate,' ',S.TimeOut),CONCAT(A.timeoutdate,' ',A.TimeOut)),TIMEDIFF(CONCAT(A.AttendanceDate,' ',S.TimeOut),CONCAT(A.AttendanceDate,' ',A.TimeOut))) AS stype  FROM AttendanceMaster A,ShiftMaster S,EmployeeMaster E WHERE S.Id = A.shiftId AND A.OrganizationId =$orgid   AND A.TimeOut != '0000:00:00' and  S.TimeOut > A.TimeOut AND A.TimeOut < (select(case when(S.TimeOutGrace !='00:00:00') then S.TimeOutGrace else S.TimeOut end) from ShiftMaster S where S.Id=ShiftId)  $q and E.Id=A.EmployeeId And E.Is_Delete = 0 ORDER BY A.AttendanceDate desc";

		   
			$query = $this->db->query($sql,array($orgid));
			 $d=array();
			 $res=array();
			foreach ($query->result() as $row)
			 {
					$data=array(); 
					
					if($row->AttendanceStatus==4)
					{

						//echo "hiiii";

						$leavehalfday=$this->earlyleavehalfday($row->id,$row->date);
						
						$name = ucwords(getEmpName($row->id));

						if($name != "" && $leavehalfday!="")
						{
						$data['Name']=$name;
						$data['code']=$row->EmployeeCode;
						$data['date']= date('M d,Y',strtotime($row->date));

						$data['TimeOut']= substr($row->timeout,0,5);
						$data['LateHours']=$leavehalfday;
						

						$Tio=getShiftTimes($row->sid);
						$data['desg']=ucwords(getDesignation($row->degid));
						$data['shift']=getShift($row->sid)." (".$Tio.")";
						$data['depart']=ucwords(getDepartment($row->departid));
						$data['device']=$row->device;
						$res[]=$data;
						}
					}
					else
					{
						if(strpos($row->stype,'-')!==0)
						{
							$name = ucwords(getEmpName($row->id));
							if($name != "")
							{
							$data['Name']=$name;
							$data['code']=$row->EmployeeCode;
							$data['date']= date('M d,Y',strtotime($row->date));
							$data['TimeOut']= substr($row->timeout,0,5);
							$data['LateHours']=substr($row->stype,0,5);
							$a = new DateTime(substr (getShiftTimes($row->sid),0,5));
									$c = new DateTime($row->TimeOutGrace);
									$b = new DateTime($row->timeout);
									//  var_dump($a);

									// var_dump($b);
									// var_dump($c);
									// die;

									$interval = "";
									if($row->TimeOutGrace == "00:00:00"){
									$interval =$b->diff($a);
								}else{
									$interval =$b->diff($c);
								}
									$data['LateHours']=$interval->format("%H:%I");
							$Tio=getShiftTimes($row->sid);
							$data['desg']=ucwords(getDesignation($row->degid));
							$data['shift']=getShift($row->sid)." (".$Tio.")";
							$data['depart']=ucwords(getDepartment($row->departid));
							$data['device']=$row->device;
							$res[]=$data;
							}
						}
					}
			}
				
             $d['data']=$res; 
             $this->db->close();			//$query->result();
			echo json_encode($d); return false;
		}
	
	
	//////////day wise punched locations report///////
	public function daypunchLocation(){
				$orgid = $_SESSION['orgid'];
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
							$zname=getTimeZone($orgid);
							date_default_timezone_set ($zname);
							$today=date("Y-m-d");
							 $q=" AND  `AttendanceDate` =  '$today' ";
						}
		//////////////////////////////////////////////////////////////////////////
		        $q1 = '';
				if($deprtid!=0)
				{
					 $q1.=" AND  `Department` = '$deprtid' ";
			    } 
		    	if($shiftid!=0)
				{
			     $q1.= " AND `ShiftId`='$shiftid' ";
			    }
                if($desgid!=0)
				{
			      $q1.=" AND  `Designation` = '$desgid'  ";
			    } 

				if($emplid!=0)
				{
					$q1.=" AND id='$emplid' ";
				}
			
	$query =$this->db->query("SELECT `EmployeeId`,`AttendanceDate`,`TimeIn`, `TimeOut` FROM `AttendanceMaster` WHERE OrganizationId=$orgid $q  ");
			 	$d= array();
				$res = array();
			 foreach($query->result() as $row){
			 	$emplid = $row->EmployeeId;
				$date = $row->AttendanceDate;
			$sql = $this->db->query("SELECT EmployeeId,location,latit,longi,time,latit_out, longi_out,time_out,date,client_name,description FROM checkin_master WHERE OrganizationId=$orgid AND EmployeeId=$emplid AND date='$date'");
				if($sql->num_rows() != 0){
					$data = array();
					foreach($sql->result() as $row1){
					$data['date'] = date('d-M-Y',strtotime($row1->date));
			 		$data['name'] = getEmpName($row1->EmployeeId);
			 		$data['timein'] = substr($row->TimeIn,0,5);
			 		$data['timeout'] = substr($row->TimeOut,0,5);
			 		//$data['loc'] =$row1->location;
					$data['loc'] = '<a href="http://maps.google.com/?q='.$row1->latit.','.$row1->longi.'" title="'.$row1->location.'" target="_blank">'.$row1->location.'</a>';
					$data['time'] = substr($row1->time,0,5);
					$data['client'] = $row1->client_name;
					$data['desc'] = $row1->description;
					$res[] = $data;
				}
				}
				
			 }
			 $d['data'] = $res;
			 $this->db->close();
			 echo json_encode($d);
	}
	
	/////////////////////punched locations report-start
	  public function punchedLocations(){
			$orgid=$_SESSION['orgid'];
				$date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
	            $shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:'';
		        $deprtid=isset($_REQUEST['deprt'])?$_REQUEST['deprt']:'';
			    $emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:'';
			    $desgid=isset($_REQUEST['desg'])?$_REQUEST['desg']:'';
				$zname=getTimeZone($orgid);
						// date_default_timezone_set ($zname);
				  $q = "";
				  $startdate='';
					if($date != '')
					{
						$arr=explode('-', trim($date));
						$enddate= date('Y-m-d',strtotime($arr[1]));
						$startdate= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3))); 
						$q ="AND date BETWEEN  '$startdate' AND '$enddate' ";
					}
					else
					{
						$zname=getTimeZone($orgid);
						date_default_timezone_set ($zname);
						$today=date("Y-m-d");
						$q=" AND  date =  '$today' ";
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
						$q1.=" AND EMP.Id='$emplid' ";
					}
			 $res=array();
			 
			 $query=$this->db->query("SELECT EMP.EmployeeCode,CONCAT(FirstName,' ',LastName) as name, CM.FakeVisitOutTimeStatus, CM.FakeVisitInTimeStatus ,CM.location,CM.checkin_img,CM.checkout_img, CM.`latit`,CM.`FakeLocationStatusVisitIn`,CM.`FakeLocationStatusVisitOut`, CM.`longi`,CM.`latit_out`, CM.`longi_out`,CASE WHEN(CM.time_out > CM.time) THEN (TIMEDIFF(CM.time_out,CM.time)) ELSE('-') END as total,CM.`time_out`, CM.`time`, CM.`date`, CM.`client_name`,CM.location_out, CM.`description` FROM `checkin_master` CM,EmployeeMaster EMP  WHERE CM.OrganizationId=$orgid and EMP.Id=CM.EmployeeId   AND EMP.Is_Delete = '0'   $q $q1 order by date(date) Desc, CM.time asc");
			 foreach ($query->result() as $row)
			 {
				$data=array();
				$data['name']=$row->name;
				$data['code']=$row->EmployeeCode;
				//$data['device']=$row->device;
				
				// $data['locationin']= '<a href="http://maps.google.com/?q='.$row->latit.','.$row->longi.'" target="_blank" title="Click to see location on map">'.$row->location.'</a>';	

				if($row->FakeLocationStatusVisitIn==1){
							$data['locationin']= '<a href="http://maps.google.com/?q='.$row->latit.','.$row->longi.'" target="_blank" title="Click to see location on map">'.$row->location.'</a>
							</br> </br>
							<div title="Lacation recorded maliciously" class="text-center"  data-background-color="red" style="margin-right:10px;">Fake Location</div>';
						}
						else{
							$data['locationin']= '<a href="http://maps.google.com/?q='.$row->latit.','.$row->longi.'" target="_blank" title="Click to see location on map">'.$row->location.'</a>';
						}



           				
				// $data['locationout']= '<a href="http://maps.google.com/?q='.$row->latit_out.','.$row->longi_out.'" target="_blank" title="Click to see location on map">'.$row->location_out.'</a>';


					if($row->FakeLocationStatusVisitOut==1){
							$data['locationout']= '<a href="http://maps.google.com/?q='.$row->latit_out.','.$row->longi_out.'" target="_blank" title="Click to see location on map">'.$row->location_out.'</a>
							</br> </br>
							<div title="Lacation recorded maliciously" class="text-center"  data-background-color="red" style="margin-right:10px;">Fake Location</div>';
						}
						else{
							$data['locationout']= '<a href="http://maps.google.com/?q='.$row->latit_out.','.$row->longi_out.'" target="_blank" title="Click to see location on map">'.$row->location_out.'</a>';
						}


				
				$data['hyperlink'] = 'http://maps.google.com/?q='.$row->latit.','.$row->longi;			
				if(strtotime($row->time) <= strtotime($row->time_out)){
					$data['total']= substr($row->total,0,5);
				}else
					{
					if(strtotime($row->time) > strtotime($row->time_out) && $row->time != '00:00:00' && $row->time_out != '00:00:00'){
					$time = "24:00:00";
					$actualtime = strtotime($row->time)-strtotime($row->time_out);
					$data['total'] = date("H:i",strtotime($time)-$actualtime);
					}
					else
					{
						$data['total'] = '-';
					}
				}
					
				
				
				$data['date']= date('M d,Y', strtotime($row->date));
				$data['totaltime']=substr($row->total,0,5);
				$data['timein']=substr($row->time,0,5);
				if($row->FakeVisitInTimeStatus == 1)
					{
						$data['fti']='<div title="TimeIn recorded maliciously" class="text-center"  data-background-color="red" style="font-size:11px;">Fake</div>';
					}
					else
					{
						$data['fti']="";
					}

					$data['tif']="";
					if($row->FakeVisitInTimeStatus == 0){
						$data['tif'] =  substr($row->time,0,5);
					}
					else{
						$data['tif']=substr($row->time,0,5).' ' .$data['fti'];
					}
				$data['timeout']= substr($row->time_out,0,5);
				if($row->time_out == "00:00:00")
					$data['timeout'] = "-";
				if($row->FakeVisitOutTimeStatus == 1){

						$data['fto']='<div title="TimeOut recorded maliciously" class="text-center"  data-background-color="red" style="font-size:11px;">Fake</div>';

					}
					else{
						$data['fto']="";
					}

					$data['tof']="";
					if($row->FakeVisitOutTimeStatus == 0){
						$data['tof'] =  substr($row->time_out,0,5);
					}
					else{
						$data['tof']=substr($row->time_out,0,5).' ' .$data['fto'];
					}
				$data['client']=$row->client_name;
				//$data['total']=substr($row->total,0,5);
				$data['comments']=$row->description;
				
				$data['entryimg']=/*'<img src="'.$row->checkin_img.'"  style="width:60px!important; "/>';*/
				
				'<i class="pop" data-toggle="modal" data-target="#imagemodal"><img src="'.$row->checkin_img.'"  style="width:60px!important; "/></i>';
				
					
				$data['exitimg']=/*'<img src="'.$row->checkout_img.'"  style="width:60px!important; "/>';*/
				'<i class="pop" data-toggle="modal" data-target="#imagemodal"><img src="'.$row->checkout_img.'"  style="width:60px!important; "/></i>';
				
				$res[]=$data;
			 } 
            $d['data']=$res;  
            $this->db->close();		
			echo json_encode($d); 
		}


	/////////////////////punched locations report-close
	//////////Punched Flexi ///////////
	 public function punchedFlexi(){
			$orgid=$_SESSION['orgid'];
				$date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
	            // $shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:'';
		        // $deprtid=isset($_REQUEST['deprt'])?$_REQUEST['deprt']:'';
			    $emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:'';
			    //$desgid=isset($_REQUEST['desg'])?$_REQUEST['desg']:'';
				$zname=getTimeZone($orgid);
						// date_default_timezone_set ($zname);
				  $q = "";
				  $startdate='';
					if($date != '')
					{
						$arr=explode('-', trim($date));
						$enddate= date('Y-m-d',strtotime($arr[1]));
						$startdate= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3))); 
						$q ="AND date BETWEEN  '$startdate' AND '$enddate' ";
					}
					else
					{
						$zname=getTimeZone($orgid);
						date_default_timezone_set ($zname);
						$today=date("Y-m-d");
						$q=" AND  date =  '$today' ";
					}
		         $q1 = '';
					// if($deprtid!=0)
					// {
						 // $q1.=" AND  `Department` = '$deprtid' ";
					// } 
					// if($shiftid!=0)
					// {
					 // $q1.= " AND `Shift`='$shiftid' ";
					// }
					// if($desgid!=0)
					// {
					  // $q1.=" AND  `Designation` = '$desgid'  ";
					// } 
					if($emplid!=0)
					{
						$q1.=" AND FX.EmployeeId='$emplid' ";
					}
					
			 $res=array();
			 $query=$this->db->query("SELECT min(FX.Id) as mnid, max(FX.Id) as mxid,FX.EmployeeId,FX.date FROM `FlexiShift_master` FX  INNER JOIN `EmployeeMaster` ON  FX.EmployeeId = EmployeeMaster.Id WHERE FX.OrganizationId=$orgid   $q  $q1  AND EmployeeMaster.Is_Delete = '0' GROUP BY FX.EmployeeId ,FX.date ");

			 // $query=$this->db->query("SELECT FX.Id,FX.EmployeeId, FX.location,FX.checkin_img,FX.checkout_img, FX.`latit`, FX.`longi`,FX.`latit_out`, FX.`longi_out`,FX.`time_out`, FX.`time`, FX.`date`, FX.location_out,if( FX.`time_out`!= '00:00',  TIMEDIFF(CONCAT(FX.timeout_date,'   ',FX.time_out) , CONCAT(FX.date,'  ',FX.time)),'00:00') as loggedhours FROM `FlexiShift_master` FX  WHERE FX.OrganizationId=$orgid   $q  $q1 order by date(date) Desc");
		// var_dump($this->db->last_query());
			 foreach ($query->result() as $row)
			 {
				$data=array();
				$data['name']=getEmpName($row->EmployeeId);
				$MINID=$row->mnid;
				$MAXID=$row->mxid;
				// $data['id']=$row->Id;
			
			$query1=$this->db->query("SELECT FlexiShift_master.`latit`, FlexiShift_master.`longi`, FlexiShift_master.`time`, FlexiShift_master.`date`, FlexiShift_master.`checkin_img`, FlexiShift_master.`location`, FlexiShift_master.`FakeLocationStatusTimeIn`,FlexiShift_master.`FakeLocationStatusTimeOut` FROM `FlexiShift_master` INNER JOIN `EmployeeMaster` ON FlexiShift_master.EmployeeId = EmployeeMaster.Id WHERE FlexiShift_master.id = $MINID  AND EmployeeMaster.Is_Delete = '0' ");
			// var_dump($this->db->last_query());
				
				$data['timein']="-";
				$timeindate="-";
			if($row1=$query1->row())
			{
				$data['timein']=substr($row1->time,0,5);
				$data['timeindate']= $row1->date;
				// $data['locationin']= '<a href="http://maps.google.com/?q='.$row1->latit.','.$row1->longi.'" target="_blank" title="Click to see location on map">'.$row1->location.'</a>';
				$data['entryimg']=/*'<img src="'.$row->checkin_img.'"  style="width:60px!important; "/>';*/
				
				'<i class="pop" data-toggle="modal" data-target="#imagemodal"><img src="'.$row1->checkin_img.'"  style="width:60px!important; "/></i>';	
			}
			if($row1->FakeLocationStatusTimeIn==1){
							$data['locationin'] = '<a href="http://maps.google.com/?q='.$row1->latit.','.$row1->longi.'" target="_blank" title="Click to see location on map">'.$row1->location.'</a>
							</br> </br>
							<div title="Lacation recorded maliciously" class="text-center"  data-background-color="red" style="margin-right:34px;">Fake Location</div>';
						}
						else{
							$data['locationin'] = '<a href="http://maps.google.com/?q='.$row1->latit.','.$row1->longi.'" target="_blank" title="Click to see location on map">'.$row1->location.'</a>';
						}


			$query2=$this->db->query("SELECT FlexiShift_master.`latit_out`,FlexiShift_master.`longi_out`,FlexiShift_master.`time_out`,FlexiShift_master.`timeout_date`, FlexiShift_master.`checkout_img`,FlexiShift_master.`location_out` FROM `FlexiShift_master`INNER JOIN `EmployeeMaster` ON FlexiShift_master.EmployeeId = EmployeeMaster.Id WHERE FlexiShift_master.id= $MAXID AND EmployeeMaster.Is_Delete = '0' ");
			
			$data['timeout']="-";
			$timeoutdate="-";
			if($row2=$query2->row())
			{
				$data['timeout']= substr($row2->time_out,0,5);
				$data['timeoutdate']= $row2->timeout_date;
			
				$data['locationout']= '<a href="http://maps.google.com/?q='.$row2->latit_out.','.$row2->longi_out.'" target="_blank" title="Click to see location on map">'.$row2->location_out.'</a>';
				$data['exitimg']=/*'<img src="'.$row->checkout_img.'"  style="width:60px!important; "/>';*/
				'<i class="pop" data-toggle="modal" data-target="#imagemodal"><img src="'.$row2->checkout_img.'"  style="width:60px!important; "/></i>';
				if($row1->FakeLocationStatusTimeOut==1){
							$data['locationout']= '<a href="http://maps.google.com/?q='.$row2->latit_out.','.$row2->longi_out.'" target="_blank" title="Click to see location on map">'.$row2->location_out.'</a>
							</br> </br>
							<div title="Lacation recorded maliciously" class="text-center"  data-background-color="red" style="margin-right:34px;">Fake Location</div>';
						}	
						else{

							$data['locationout']= '<a href="http://maps.google.com/?q='.$row2->latit_out.','.$row2->longi_out.'" target="_blank" title="Click to see location on map">'.$row2->location_out.'</a>';

						}
			}


				// if($data['timeout']=='00:00:00')
				// $data['timeout']="-";
    //        		$data['loggedhours']="-";		
				
				
				//$data['hyperlink'] = 'http://maps.google.com/?q='.$row->latit.','.$row->longi;			
				// if(strtotime($row->time) <= strtotime($row->time_out))
				// {
					// $data['total']= substr($row->total,0,5);
				// }else
					// {
					// if(strtotime($row->time) > strtotime($row->time_out) && $row->time != '00:00:00' && $row->time_out != '00:00:00'){
					// $time = "24:00:00";
					// $actualtime = strtotime($row->time)-strtotime($row->time_out);
					// $data['total'] = date("H:i",strtotime($time)-$actualtime);
					// }
					// else
					// {
						// $data['total'] = '-';
					// }
				// }
					

				
				
				$data['date']= date('M d,Y', strtotime($row->date));
				
				if($data['timeout']!='00:00')
				{
					
					$query3=$this->db->query("SELECT TIMEDIFF(CONCAT(?,' ',?) , CONCAT(?,' ',?)) as loggedhours FROM `FlexiShift_master` FX ",array($data['timeoutdate'],$data['timeout'],$data['timeindate'],$data['timein']));
					if($row3=$query3->row())
					{	
					$data['loggedhours']=substr($row3->loggedhours,0,5);
					}
					
				}
				else
				{
					$data['loggedhours']='00:00';
				}				
			 	
			 	$empid=$row->EmployeeId;
			 	$empdate = $row->date;
			 	$count=$this->countatt($empid,$empdate);

			 	
			 	if($count > 1){
			 		$data['action']='<a href="viewflezi/'.$row->EmployeeId.'/'.$row->date.'"><i class="fa fa-eye"></i></a>';
			 	}
			 	
			 	else{
			 		$data['action']='';
			 	}
			
				$res[]=$data;
			 } 


            $d['data']=$res;  
            $this->db->close();		
			echo json_encode($d); 
		}


		public function getregister(){
			$orgid=$_SESSION['orgid'];
			
			 $date = isset($_REQUEST['date'])?$_REQUEST['date']:"";
			 $shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:'';

			 $emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:'';

			 // var_dump($emplid);
			 // var_dump($date);
			 // var_dump($orgid);
			    //$desgid=isset($_REQUEST['desg'])?$_REQUEST['desg']:'';
				// $zname=getTimeZone($orgid);
						// date_default_timezone_set ($zname);
				  $q = "";
				  $startdate='';
				  $enddate='';
				  $res = "";
				  // var_dump($startdate);
					if($date != '')
					{
						$arr=explode('-', trim($date));
						$enddate= date('Y-m-d',strtotime($arr[1]));
						$startdate= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3))); 
						$q ="BETWEEN  '$startdate' AND '$enddate' ";
					}
					else
					{
							$zname=getTimeZone($orgid);
							date_default_timezone_set ($zname);
							$today=date("Y-m-d");
							$q=" AND  `AttendanceDate` =  '$today' ";
				
					}

					

					




			$query =$this->db->query("SELECT E.area_assigned as location, if(E.LastName!='NULL',concat(E.FirstName, ' ' ,E.LastName),E.FirstName) as name,E.Id, D.Name as desg, (select COUNT(AttendanceStatus) FROM AttendanceMaster where AttendanceStatus = 1 AND   EmployeeId=E.Id AND AttendanceDate $q) as present, (SELECT COUNT(AttendanceStatus) FROM AttendanceMaster where AttendanceStatus = 2 AND EmployeeId=E.Id and AttendanceDate $q) as absent , (SELECT COUNT(A.Id) FROM AttendanceMaster A, ShiftMaster S where  A.TimeIn >S.TimeIn and AttendanceStatus = 1 AND EmployeeId=E.Id AND S.Id=E.Shift  and A.AttendanceDate $q) as latecoming from EmployeeMaster E, DesignationMaster D,AttendanceMaster A where E.Designation = D.id  and A.EmployeeId =  E.Id and E.Is_Delete=0 and A.AttendanceDate $q  and A.OrganizationId = $orgid GROUP BY A.EmployeeId");



			// var_dump($this->db->last_query());


			// var_dump($query->result());
				// $res=array();
				// var_dump($res);
			foreach($query->result() as $row)
			{
				$data['name']=$row->name;
				// print_r($data['name']);

				$data['Presentcount']=$row->present;
				$data['Absentcont']=$row->absent;
				$data['latecoming']=$row->latecoming;
				$data['desg']=$row->desg;
				$data['weekoff']= $startdate.'/'.$enddate;

				if($row->location != 0)
            $data['location'] = getName('Geo_Settings','Name', 'Id', $row->location);
          else
            $data['location'] = '--';


				// $data['location']=$row->location;
				// var_dump($data['location']);
				$res[]=$data;
			}
			
			
			$d['data']=$res;  
			// var_dump($d['data']);				//$query->result();
			echo json_encode($d); return false; 
		}


		public function countatt($empid,$empdate)
		{
			$query3=$this->db->query("SELECT count(EmployeeId) as cntemp  FROM `FlexiShift_master` WHERE EmployeeId = '".$empid."' AND date = '".$empdate."' ");

			foreach($query3->result() as $row)
			{
				return $row->cntemp;
			}
					 	
		}

		//function view flexi

		public function viewflezi($eid,$date){
			// echo $eid;
			header('Access-Control-Allow-Origin: *'); 

			 $orgid=isset($_SESSION['orgid'])?$_SESSION['orgid']:'0';
			// $eid=isset($_SESSION['eid'])?$_SESSION['eid']:'0';
			// $date=isset($_SESSION['date'])?$_SESSION['date']:'0';
			 $sql="SELECT FX.Id,FX.EmployeeId, FX.location,FX.checkin_img,FX.checkout_img, FX.`latit`, FX.`longi`,FX.`latit_out`, FX.`longi_out`,FX.`time_out`, FX.`time`, FX.`date`, FX.location_out,TIMEDIFF(CONCAT(FX.timeout_date,'   ',FX.time_out) , CONCAT(FX.date,'  ',FX.time))as loggedhours FROM `FlexiShift_master` FX  WHERE FX.EmployeeId='".$eid."' AND FX.date='".$date."' and OrganizationId=$orgid";
		// echo $sql;
			$query = $this->db->query($sql);

			$res=array();
			 foreach ($query->result() as $row)
			 {
			 	
				$data=array();
				$data['id']=$row->EmployeeId;
				$data['timein']=substr($row->time,0,5);
				
				$data['locationin']= '<a href="http://maps.google.com/?q='.$row->latit.','.$row->longi.'" target="_blank" title="Click to see location on map">'.$row->location.'</a>';
				$data['entryimg']=
				
				'<i class="pop" data-toggle="modal" data-target="#imagemodal"><img src="'.$row->checkin_img.'"  style="width:60px!important; "/></i>';	
			

			
				$data['timeout']= substr($row->time_out,0,5);
					
			
				$data['locationout']= '<a href="http://maps.google.com/?q='.$row->latit_out.','.$row->longi_out.'" target="_blank" title="Click to see location on map">'.$row->location_out.'</a>';
				$data['exitimg']=/*'<img src="'.$row->checkout_img.'"  style="width:60px!important; "/>';*/
				'<i class="pop" data-toggle="modal" data-target="#imagemodal"><img src="'.$row->checkout_img.'"  style="width:60px!important; "/></i>';	
				
				$data['date']= date('M d,Y', strtotime($row->date));
				
				$data['loggedhours']=date("H:i",strtotime($row->loggedhours));
							 	
					
			
				$res[]=$data;
			 } 

			
          return $res;


		}

		//end view flexi


	////////////////////////
	       ///////overTime
	
	     public function overtime(){
			    $orgid = $_SESSION['orgid'];
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
							
							$enddate=date('Y-m-d');
							 //$d = date('d')-1;
							
							 $startdate=date('Y-m-d',(strtotime ( "-7 day",strtotime(date('Y-m-d'))) ));
							 
							 $q=" AND  `AttendanceDate` BETWEEN  '$startdate' AND '$enddate' ";
						}
			
					
		//////////////////////////////////////////////////////////////////////////
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
			
			$query=$this->db->query("SELECT Id,EmployeeCode,CONCAT(FirstName,' ',LastName)as name, Designation, Department,Shift FROM EmployeeMaster WHERE OrganizationId=$orgid AND DOL='0000:00:00'	$q1 AND Is_Delete = '0'  ORDER BY Firstname");
			
			$d=array();
			$res=array();
			
			 foreach ($query->result() as $row1)
			{	
				$emplid =$row1->Id;
				/*$query1=$this->db->query("SELECT A.AttendanceStatus,A.AttendanceDate as date,A.ShiftId as shift,A.TimeOut as timeout,A.TimeIn as timein,C.TimeIn as ctimein,C.TimeOut as ctimeout FROM AttendanceMaster A,ShiftMaster C WHERE A.ShiftId=C.Id AND A.EmployeeId=$emplid $q AND A.OrganizationId = $orgid AND A.TimeIn != '00:00:00'  ");
				
				foreach($query1->result() as $row1)
				{
				$data = array();
				$flag = false;
					if(strtotime($row1->timein) <= strtotime($row1->timeout) && strtotime($row1->ctimein) <= strtotime($row1->ctimeout) )
					{
						$data['Overtime']= $this->getOverTime($emplid,$row1->date);
						if($data['Overtime'] == "-")
						$flag = false;
					    else
						$flag = true;
					}
					else if($row1->AttendanceStatus==3)
					{
					$flag = false;
					}	
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
								 $data['Overtime']= $interval->format("%H:%I");	
								 $flag = true;
								}
							else
								{
								  $interval = $b->diff($a);
								  $a = new DateTime($interval->format("%H:%I"));
								  $b = new DateTime(getShiftBreak($row1->shift));
								  $interval1 = $b->diff($a);
								  $data['Overtime']= "-";
			                      $flag = false;
								}	
								
                         }	
					if($flag)
					{
					$data['FirstName']=ucwords($row->name);
					$data['code']=$row->EmployeeCode;
				    $data['date']= date('M d,Y',strtotime($row1->date));
				     //$data['Overtime']="dummy";//substr(($row->Overtime),0,5);
					 if($row1->AttendanceStatus==4)
					 {
						$data['Overtime']='00:00';
					 }
					  
			        $Tio=getShiftTimes($row->Shift);
				    $data['shift']=getShift($row->Shift)." (".$Tio.")";
				    $data['desg']=ucwords(getDesignationByEmpID($row->Id));
				   $data['depart']=ucwords(getDepartmentByEmpID($row->Id));
				   //$data['device']=$row1->device;
					$res[]=$data;
					}
				  
				}*/
				$sql="SELECT ShiftId,TimeIn,AttendanceDate,dept_id,desg_id,TimeOut,AttendanceStatus,timeoutdate From AttendanceMaster  where  EmployeeId='$emplid'AND TimeOut !='00:00:00'  $q ";
					//echo $sql;
			   $query = $this->db->query($sql,array($orgid));
			   if($this->db->affected_rows()>0)
			   foreach($query->result() as $row)
				{
					 $data = array();
					 $sts = $row->AttendanceStatus;
					 $shiftid =$row->ShiftId;
					 $shifttime = getShiftTimeInSeconde($shiftid);
					 $shifttype = 1;
					 $shifttimein = "";
					 $shifttimeout = "";
					 if($shifttime != 0)
					 {
						 $sarr = explode("**",$shifttime);
						 $shifttime = $sarr[0];
						 $shifttype = $sarr[1];
						 $shifttimein = $sarr[2];
						 $shifttimeout = $sarr[3];
					 }
					 $timein=substr($row->TimeIn,0,-3);
					 $timeout=substr($row->TimeOut,0,-3);
					 $attendanceDate = $row->AttendanceDate;
					 $timeoutDate = $row->timeoutdate;
					  $officehour='00:00';
					  $officesecond = 0;
					  $ti = "00:00";
					  $to = "00:00";
					  $data['FirstName']=ucwords($row1->name);
					 
			          $data['code']=$row1->EmployeeCode;
			
					   $data['date']= date('M d,Y',strtotime($attendanceDate));
						$Tio=getShiftTimes($shiftid);
						$data['shift']=getShift($shiftid)." (".$Tio.")";
						$data['desg']=ucwords(getDesignation($row->desg_id));
						$data['depart']=ucwords(getDepartment($row->dept_id));
					  // office hours calculation
					 if($timeout != "00:00" AND $timein != "00:00" )
					 {
						  $Fquery = "";
						 if($timeoutDate != '0000-00-00')
						 {
							 $ti = $attendanceDate." ".$timein;
							 $to = $timeoutDate." ".$timeout;
					    	 $Fquery = $this->db->query(" Select  TimeDiff('$to','$ti') as  officehour, time_to_sec(TimeDiff('$to','$ti')) as   officesecond ");
						 }
						 else
						 {
							
							 $ti = $attendanceDate." ".$timein;
							 $to = $attendanceDate." ".$timeout;
							 
					    	 $Fquery = $this->db->query(" Select  TimeDiff('$to','$ti') as  officehour ,  time_to_sec(TimeDiff('$to','$ti')) as   officesecond ");
						 }
						 
						 if($Frow = $Fquery->row())
						 {
							 $officehour = substr($Frow->officehour,0,-3);
							 $officesecond = $Frow->officesecond;
						 }
					 }
					
					  // under and over time calculation
					 if($officesecond>$shifttime)
					 {
						 $over_under_time = $this->db->query("Select TIMEDIFF(sec_to_time('$officesecond') , sec_to_time('$shifttime')) as outime");
						 if($ourow = $over_under_time->row())
						 {
							$data['Overtime'] = date('H:i',strtotime($ourow->outime));
							// echo $ourow->outime;
							// print_r($data['Overtime']);
							// echo "<br/>";
						 } 
						$res[]=$data;  
					 }
					 
					}  
			}  	
			$d['data']=$res;  
            $this->db->close();		
			echo json_encode($d); 
			return false;
		}
	
	 public function overtime__new(){
			    $orgid = $_SESSION['orgid'];
				$date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
	            $shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:'';
		        $deprtid=isset($_REQUEST['deprt'])?$_REQUEST['deprt']:'';
			    $emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:'';
			    $desgid=isset($_REQUEST['desg'])?$_REQUEST['desg']:'';
			    $q = "";
			    $startdate='';
				if($date != '')
					{
						 $todatdate = date("Y-m-d");
						$arr=explode('-', trim($date));
						$enddate= date('Y-m-d',strtotime($arr[1]));
						$startdate= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3))); 
					   $q ="AND `AttendanceDate` BETWEEN  '$startdate' AND '$enddate' AND  '$enddate' <= '$todatdate'";
					}
					else
					{
						 $enddate=date('Y-m-d',(strtotime ( "-1 day",strtotime(date('Y-m-d'))) ));
						 $startdate=date('Y-m-d',(strtotime ( "-7 day",strtotime(date('Y-m-d'))) ));
						 $q=" AND  `AttendanceDate` BETWEEN  '$startdate' AND '$enddate' ";
					}
		        $q1 = '';
				if($deprtid!=0)
				{
					 $q1.=" AND  Dept_id = '$deprtid' ";
			    } 
		    	if($shiftid!=0)
				{
			     $q1.= " AND ShiftId ='$shiftid' ";
			    }
                if($desgid!=0)
				{
			      $q1.=" AND  Desg_id = '$desgid'  ";
			    } 

				if($emplid!=0)
				{
					$q1.=" AND EmployeeId = '$emplid' ";
				}
			
			$query=$this->db->query("SELECT Id,CONCAT(FirstName,' ',LastName)as name, Designation, Department,Shift FROM EmployeeMaster WHERE OrganizationId=$orgid AND DOL='0000:00:00'$q1 AND Is_Delete = '0' ORDER BY Firstname ");
			
			$d=array();
			$res=array();
			
			 foreach ($query->result() as $row)
			{	
				$emplid =$row->Id;
				$query1=$this->db->query("SELECT A.AttendanceDate as date,A.ShiftId as shift,A.TimeOut as timeout,A.TimeIn as timein,C.TimeIn as ctimein,C.TimeOut as ctimeout FROM AttendanceMaster A,ShiftMaster C WHERE A.ShiftId=C.Id AND A.EmployeeId=$emplid $q AND A.OrganizationId = $orgid AND A.TimeIn != '0000-00-00' ");
				
				foreach($query1->result() as $row1)
				{
				$data = array();
				
					$flag = false;
					if(strtotime($row1->timein) <= strtotime($row1->timeout) && strtotime($row1->ctimein) <= strtotime($row1->ctimeout) )
					{
						$data['Overtime']= $this->getOverTime($emplid,$row1->date);
						if($data['Overtime'] == "-")
						$flag = false;
					    else
						$flag = true;
						
					}
						
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
								 $data['Overtime']= $interval->format("%H:%I");	
								 $flag = true;
								}
							else
								{
								  $interval = $b->diff($a);
								  $a = new DateTime($interval->format("%H:%I"));
								  $b = new DateTime(getShiftBreak($row1->shift));
								  $interval1 = $b->diff($a);
								  $data['Overtime']= "-";
			                      $flag = false;
								}	
								
                         }	
					if($flag)
					{
						$data['FirstName']=ucwords($row->name);
				       $data['date']= date('d-M-Y',strtotime($row1->date));
				     //$data['Overtime']="dummy";//substr(($row->Overtime),0,5);
			        $Tio=getShiftTimes($row->Shift);
				    $data['shift']=getShift($row->Shift)." (".$Tio.")";
				    $data['desg']=ucwords(getDesignationByEmpID($row->Id));
				   $data['depart']=ucwords(getDepartmentByEmpID($row->Id));
					$res[]=$data;
					}
				  
				}
			}  	
			$d['data']=$res;  
            $this->db->close();		
			echo json_encode($d); 
			return false;
		}
	
	////////create by yogendra/////
	function getOverTime($empid,$date)
	{
	     $org_id = $_SESSION['orgid'];
         $query = $this->db->query("SELECT SEC_TO_TIME( SUM( TIME_TO_SEC(LEFT(TIMEDIFF( A.TimeOut,A.TimeIn ),5)) - TIME_TO_SEC(TIMEDIFF( C.TimeOut, C.TimeIn)))) as overtime FROM AttendanceMaster A, ShiftMaster C WHERE A.EmployeeId =$empid AND A.AttendanceDate = '$date' AND A.OrganizationId =$org_id AND C.Id = A.ShiftId AND A.TimeOut>C.TimeOut AND A.TimeOut != '00:00:00' AND A.TimeIn != '00:00:00' AND overtime > '00:00:00' ");
                $result = $query->row();
				$overtime = $result->overtime;
				$overtime =  substr($overtime,0,5);
				
							if($overtime > '00:00:00')
								{
								return $overtime;
					   			} 
					   			else
								{
					   			return "-";
								}				
	}
	/////Undertime 
	    public function undertime(){
			     $orgid=$_SESSION['orgid'];
				$date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
	            $shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:'';
			    $emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:'';
			    $desgid=isset($_REQUEST['desg'])?$_REQUEST['desg']:'';
				 $deprtid=isset($_REQUEST['deprt'])?$_REQUEST['deprt']:'';
				  $q = "";
				  $startdate='';
					if($date != '')
						{
							$todaydate = date('Y-m-d');
							$arr=explode('-', trim($date));
							$enddate= date('Y-m-d',strtotime($arr[1]));
							$startdate= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3)));
						   $q ="AND `AttendanceDate` BETWEEN  '$startdate' AND '$enddate' ";
						}
						else
						{
							 $enddate=date('Y-m-d');
							 //$d = date('d')-1;
							 //echo $enddate; 
							 $startdate=date('Y-m-d',(strtotime ( "-7 day",strtotime(date('Y-m-d'))) ));
							 // echo $startdate; 
							 $q=" AND  `AttendanceDate` BETWEEN  '$startdate' AND '$enddate' ";
						}
		//////////////////////////////////////////////////////////////////////////
		        $q1 = '';
				 
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
			if($deprtid!=0)
				{
					 $q1.=" AND  `Department` = '$deprtid' ";
			    } 
			$query=$this->db->query("SELECT EmployeeCode,Id,CONCAT(FirstName,' ',LastName)as name, Designation, Department,Shift FROM EmployeeMaster WHERE OrganizationId=$orgid AND DOL='0000:00:00' $q1 AND Is_Delete = '0' ORDER BY Firstname ");
			
			$d=array();
			$res=array();
			
			 foreach ($query->result() as $row1)
			  {	
				$emplid =$row1->Id;
		
			$sql="SELECT ShiftId,TimeIn,AttendanceDate,dept_id,desg_id,TimeOut,AttendanceStatus,timeoutdate From AttendanceMaster  where  EmployeeId='$emplid'AND TimeOut !='00:00:00'  $q ";
					//echo $sql;
			   $query = $this->db->query($sql,array($orgid));
			   if($this->db->affected_rows()>0)
			   foreach($query->result() as $row)
				{
					 $data = array();
					 $sts = $row->AttendanceStatus;
					 $shiftid =$row->ShiftId;
					 $shifttime = getShiftTimeInSeconde($shiftid);
					 $shifttype = 1;
					 $shifttimein = "";
					 $shifttimeout = "";
					 if($shifttime != 0)
					 {
						 $sarr = explode("**",$shifttime);
						 $shifttime = $sarr[0];
						 $shifttype = $sarr[1];
						 $shifttimein = $sarr[2];
						 $shifttimeout = $sarr[3];
					 }
					 $timein=substr($row->TimeIn,0,-3);
					 $timeout=substr($row->TimeOut,0,-3);
					 $attendanceDate = $row->AttendanceDate;
					 $timeoutDate = $row->timeoutdate;
					  $officehour='00:00';
					  $officesecond = 0;
					  $ti = "00:00";
					  $to = "00:00";
					  $data['FirstName']=ucwords($row1->name);
			          $data['code']=$row1->EmployeeCode;
			
					   $data['date']= date('M d,Y',strtotime($attendanceDate));
						$Tio=getShiftTimes($shiftid);
						$data['shift']=getShift($shiftid)." (".$Tio.")";
						$data['desg']=ucwords(getDesignation($row->desg_id));
						$data['depart']=ucwords(getDepartment($row->dept_id));
					  // office hours calculation
					 if($timeout != "00:00" AND $timein != "00:00" )
					 {
						  $Fquery = "";
						 if($timeoutDate != '0000-00-00')
						 {
							 $ti = $attendanceDate." ".$timein;
							 $to = $timeoutDate." ".$timeout;
					    	 $Fquery = $this->db->query(" Select  TimeDiff('$to','$ti') as  officehour, time_to_sec(TimeDiff('$to','$ti')) as   officesecond ");
						 }
						 else
						 {
							 $ti = $attendanceDate." ".$timein;
							 $to = $attendanceDate." ".$timeout;
					    	 $Fquery = $this->db->query(" Select  TimeDiff('$to','$ti') as  officehour ,  time_to_sec(TimeDiff('$to','$ti')) as   officesecond ");
						 }
						 
						 if($Frow = $Fquery->row())
						 {
							 $officehour = substr($Frow->officehour,0,-3);
							 $officesecond = $Frow->officesecond;
						 }
					 }
					 
					  // under and over time calculation
					 if($shifttime>$officesecond)
					 {
						 $over_under_time = $this->db->query("Select TIMEDIFF(sec_to_time('$shifttime') , sec_to_time('$officesecond')) as outime");
						 if($ourow = $over_under_time->row())
						 {
							$data['Overtime']  =  date('H:i',strtotime($ourow->outime));
						 }
						$res[]=$data;  
					 }
					 
					}  
				}
			
			
			$d['data']=$res;  
            $this->db->close();		
			echo json_encode($d); 
			return false;
			}
	   // public function undertime(){
			// $orgid=$_SESSION['orgid'];
				// $date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
	            // $shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:'';
			    // $emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:'';
			    // $desgid=isset($_REQUEST['desg'])?$_REQUEST['desg']:'';
				  // $q = "";
				  // $startdate='';
					// if($date != '')
						// {
							
							// $todaydate = date('Y-m-d');
							
							// $arr=explode('-', trim($date));
							// $enddate= date('Y-m-d',strtotime($arr[1]));
							
							// $startdate= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3)));
					
						   // $q ="AND `AttendanceDate` BETWEEN  '$startdate' AND '$enddate' AND '$enddate'<= '$todaydate'";
						// }
						// else
						// {
							
							 // $enddate=date('Y-m-d',(strtotime ( "-1 day",strtotime(date('Y-m-d'))) ));
							 
							
							 // $startdate=date('Y-m-d',(strtotime ( "-7 day",strtotime(date('Y-m-d'))) ));
							 
							 // $q=" AND  `AttendanceDate` BETWEEN  '$startdate' AND '$enddate' ";
						// }
		////////////////////////////////////////////////////////////////////
		        // $q1 = '';
				 
		    	// if($shiftid!=0)
				// {
			     // $q1.= " AND `Shift`='$shiftid' ";
			    // }
                // if($desgid!=0)
				// {
			      // $q1.=" AND  `Designation` = '$desgid'  ";
			    // } 

				// if($emplid!=0)
				// {
					// $q1.=" AND `id`='$emplid' ";
				
				// }  
			
			// $query=$this->db->query("SELECT Id,CONCAT(FirstName,' ',LastName)as name, Designation, Department,Shift FROM EmployeeMaster WHERE OrganizationId=$orgid AND DOL='0000:00:00'$q1 AND Is_Delete = '0' ORDER BY Firstname");
			
			// $d=array();
			// $res=array();
			
			 // foreach ($query->result() as $row)
			// {	
				// $emplid =$row->Id;
				// $query1=$this->db->query("SELECT A.AttendanceDate as date,A.ShiftId as shift,A.TimeOut as timeout,A.TimeIn as timein,C.TimeIn as ctimein,C.TimeOut as ctimeout FROM AttendanceMaster A,ShiftMaster C WHERE A.ShiftId=C.Id AND A.EmployeeId=$emplid $q AND A.OrganizationId = $orgid AND A.TimeIn != '0000:00:00' ORDER BY AttendanceDate");
				
				// foreach($query1->result() as $row1)
				// {
				// $data = array();
				// $data['FirstName']=ucwords($row->name);
				// $data['date']= date('d-M-Y',strtotime($row1->date));
				// $data['Overtime']="dummy";//substr(($row->Overtime),0,5);
			    // $Tio=getShiftTimes($row->Shift);
				// $data['shift']=getShift($row->Shift)." (".$Tio.")";
				// $data['desg']=ucwords(getDesignationByEmpID($row->Id));
				// $data['depart']=ucwords(getDepartmentByEmpID($row->Id));
					// $flag = false;
						// if(strtotime($row1->timein) <= strtotime($row1->timeout) && strtotime($row1->ctimein) <= strtotime($row1->ctimeout) )
						// {	
							// $data['Overtime'] = $this->getundertime($emplid,$row1->date);
							// if($data['Overtime'] == "-")
								// $flag = false;
							// else
								// $flag = true;
							
						// }
					    // else
						// {
						     // $time = "24:00:00";
							// $secs = strtotime($row1->ctimein)-strtotime($row1->ctimeout);
							// $data['shifthpurs'] = date("H:i",strtotime($time)-$secs);
							// $a = new DateTime($data['shifthpurs']);
							// $secs = strtotime($row1->timein)-strtotime($row1->timeout);
							// $data['var'] = date("H:i",strtotime($time)-$secs);
							// $b = new DateTime($data['var']);
							// if($b >= $a)
								// {
								 // $interval = $a->diff($b);
								 // $data['Overtime']= $interval->format("%H:%I");	
								 // $flag = false;
								// }
							// else
								// {
								  // $interval = $b->diff($a);
								  // $a = new DateTime($interval->format("%H:%I"));
								  // $b = new DateTime(getShiftBreak($row1->shift));
								  // $interval1 = $b->diff($a);
								  // $data['Overtime']= "-".$interval1->format("%H:%I");	
								// $flag = true;								  
								// }	
								
                        // }	
				// if($flag)
				// {
				// $res[]=$data;
				// }
				// }
			// }  	
			// $d['data']=$res;  
            // $this->db->close();		
			// echo json_encode($d); 
			// return false;
			// }
			
	  
/* $sql="SELECT *  FROM  `AttendanceMaster` WHERE OrganizationId =?  
             AND `Overtime`<'00:00' $q ORDER BY `AttendanceDate` ";
			
			$query = $this->db->query($sql,array($orgid));
			$d=array();
			$res=array();
			$count=$query->num_rows();
			 foreach ($query->result() as $row)
			{
				$data=array();
					$data['FirstName']=ucwords(getEmpName($row->EmployeeId));
					$data['date']= date('d/m/Y',strtotime($row->AttendanceDate));
					$data['Overtime']= substr(trim($row->Overtime,"-!"),0,5);
					$Tio=getShiftTimes($row->ShiftId);
				    $data['shift']=getShift($row->ShiftId)." (".$Tio.")";
					$data['desg']=ucwords(getDesignationByEmpID($row->EmployeeId));
					$data['depart']=ucwords(getDepartmentByEmpID($row->EmployeeId));
					$res[]=$data;
			}  	
			 $d['data']=$res;  				//$query->result();
			 $this->db->close();
			 echo json_encode($d); return false;	*/
		
			public function getundertime($emplid,$date){
				$org_id = $_SESSION['orgid'];
			//$currentdate = date("y-m-d");
			$query = $this->db->query("SELECT 				sec_to_time(sum(time_to_sec(timediff(SEC_TO_TIME(CASE 						WHEN(A.TimeOut>S.TimeOutBreak)
					THEN time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)) --WHEN(A.TimeIn >S.TimeInBreak)
					--THEN time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn))
					ELSE time_to_sec(TIMEDIFF(S.TimeOut,S.TimeIn)-time_to_sec(TIMEDIFF(S.TimeOutBreak,S.TimeInBreak))) END),sec_to_time(time_to_sec(TIMEDIFF(A.TimeOut,A.TimeIn))))))) as time FROM AttendanceMaster A,ShiftMaster S WHERE A.EmployeeId = ($emplid) AND A.OrganizationId= $org_id AND A.AttendanceDate = '$date'   AND A.TimeOut > A.TimeIn AND A.TimeIn != 'null' AND A.TimeOut != 'null' AND S.Id = A.ShiftId ");
			
			
			
		    if( $row = $query->result_array())
			 {
				if($row[0]["time"] != null)
				{
					$length = strlen($row[0]["time"])-3;
					return ( substr($row[0]["time"],0,$length) );
				}
				else 
					return "-";
			   
			 }				
			 	 }
	       public function editAttUBI()
			{
			$orgid=$_SESSION['orgid'];
			$res=0;
			$aid=isset($_REQUEST['id'])?$_REQUEST['id']:'';
			$date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
			$shifttype=isset($_REQUEST['shifttype'])?$_REQUEST['shifttype']:'';
			//$tomorrow=date('Y-m-d', strtotime('+1 day', strtotime($date)));
			$to=date("H:i:s", strtotime(isset($_REQUEST['to'])?$_REQUEST['to']:''));
			$device='TimeOut marked by Admin';
			//$timeoutimage="https://ubitech.ubihrm.com/public/avatars/male.png";
			//$timeoutimage=IMGURL."uploads/male.png";
			$timeoutimage='https://ubiattendance.ubihrm.com/assets/img/managerdevice.png';
				if($date)
				{
				
					$query = $this->db->query("UPDATE `AttendanceMaster` SET `TimeOut`=?,device=?,ExitImage=?,timeoutdate=? where Id=? and OrganizationId=?",array($to,$device,$timeoutimage,$date,$aid,$orgid));	
					$res= $this->db->affected_rows();	
					$this->db->close();
					echo $res;
				
				}
				else
				{
				$query = $this->db->query("UPDATE `AttendanceMaster` SET `TimeOut`=?,device=?,ExitImage=?  where Id=? and OrganizationId=?",array($to,$device,$timeoutimage,$aid,$orgid));	
				$res= $this->db->affected_rows();	
				$this->db->close();
				echo $res;	
				}
			}
			
			public function editAtt()
			{

				
			//$id=$_SESSION['id'];
			//$sts=isset($_REQUEST['sts'])?$_REQUEST['sts']:0;
			//$sh=isset($_REQUEST['sh'])?$_REQUEST['sh']:'';	
			//$ti=date("H:i:s", strtotime(isset($_REQUEST['ti'])?$_REQUEST['ti']:''));
			//$date=date('Y-m-d');
			 //$query = $this->db->query("UPDATE `AttendanceMaster` SET `AttendanceStatus`=?,`TimeIn`=?,`TimeOut`=?,`ShiftId`=?,Overtime =(SELECT subtime(subtime('$to',TimeIn),(select subtime(timeout,timein) from ShiftMaster where id=$sh)) as overTime ) where id=? and OrganizationId=?",array($sts,$ti,$to,$sh,$aid,$orgid));
			 //$timeoutimage="https://ubitech.ubihrm.com/public/avatars/male.png";
			//$timeoutimage=IMGURL."uploads/male.png";
			
			$orgid=$_SESSION['orgid'];
			$res=0;
			$aid=isset($_REQUEST['id'])?$_REQUEST['id']:'';
			$aname=isset($_REQUEST['aname'])?$_REQUEST['aname']:'';
			// var_dump($aname);
			$dateIn=isset($_REQUEST['dateIn'])?$_REQUEST['dateIn']:'';
			$dateatt=date("M d,Y",strtotime($dateIn));
			$dateOut=isset($_REQUEST['dateOut'])?$_REQUEST['dateOut']:'';
			$shifttype=isset($_REQUEST['shifttype'])?$_REQUEST['shifttype']:'';
			$to=isset($_REQUEST['to'])?date("H:i", strtotime($_REQUEST['to'])):'';

			// var_dump($to);
			// die;
			
			$ti=isset($_REQUEST['ti'])?date("H:i", strtotime($_REQUEST['ti'])):'';
			$ts=isset($_REQUEST['ts'])?date("H:i", strtotime($_REQUEST['ts'])):'';
			$ts1=isset($_REQUEST['ts1'])?date("H:i", strtotime($_REQUEST['ts1'])):'';
			$mdate=date("Y-m-d H:i:s");
			$today=date("Y-m-d");
			$device='TimeOut marked by Admin';
			$timeoutimage='https://ubiattendance.ubihrm.com/assets/img/managerdevice.png';
			$dti = $dateIn." ".$ti;
			$dto = $dateOut." ".$to;

			// $Fquery = $this->db->query(" Select  timediff(TimeDiff('$dto','$dti'),(S.TimeOut,S.TimeIn)) as diff  from AttendanceMaster A , ShiftMaster S where A.Id=? and A.OrganizationId=? and S.Id=A.ShiftId ", array($aid,$orgid));
						 
						 
			// 			 if($Frow = $Fquery->row())
			// 			 {
			// 			 	$diff  = $Frow->diff;


			//$timeinimage='https://ubiattendance.ubihrm.com/assets/img/managerdevice.png';

			$att = $this->db->query("SELECT * FROM AttendanceMaster WHERE Id = '$aid' and OrganizationId = '$orgid' ");
			if($r1= $att->result()){
			

				$attendancedate = $r1[0]->AttendanceDate;
				$attendancestatus = $r1[0]->AttendanceStatus;
				$status1 = '';

				if($attendancestatus == 2){

					$status1 = 1;
				}
				else{

					$status1 = $attendancestatus;
				}

				// var_dump($attendancedate);
				// die;
			
			
				$sql= $this->db->query("SELECT timediff(TIMEDIFF('$dto','$dti'),timediff(S.TimeOut,S.TimeIn)) as diff, S.Id,A.ShiftId  from AttendanceMaster A , ShiftMaster S where A.Id=? and A.OrganizationId=? and S.Id=A.ShiftId ", array($aid,$orgid));

				// var_dump($this->db->last_query());

				if($r=$sql->result()){
							$diff  = $r[0]->diff;

				if($dateIn || $dateOut)
				{

					// if($to = '00:00' && $attendancedate = $today){

					// 	$query = $this->db->query("UPDATE `AttendanceMaster` SET TimeIn=?,timeindate=?,LastModifiedDate=? where Id=? and OrganizationId=?",array($ti,$dateIn,$mdate,$aid,$orgid));


				 //   $date = date("y-m-d H:i:s");
				 //   $orgid =$_SESSION['orgid'];
				 //   $id =$_SESSION['id'];
				 //   $module = "Attendance";
				   
				 //  $actionperformed = "Attendance Updated of <b>".$aname." </b> of <b> ".$dateatt." </b>  and Old TimeIn: ".$ts.",<b> New TimeIn: ".$ti.", </b> ";
				   
				 //   $activityby = 1;
				 //   // $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy) VALUES (?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby));
				 //   $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));					
					// $res= $this->db->affected_rows();

					// echo $res;
					
					// }
					// else{

					

					$query = $this->db->query("UPDATE `AttendanceMaster` SET TimeIn=?,`TimeOut`=?,device=?,ExitImage=?,timeindate=?,timeoutdate=?,LastModifiedDate=?, Overtime=?, AttendanceStatus=?  where Id=? and OrganizationId=?",array($ti,$to,$device,$timeoutimage,$dateIn,$dateOut,$mdate,$diff,$status1,$aid,$orgid));
				
					
				   $date = date("y-m-d H:i:s");
				   $orgid =$_SESSION['orgid'];
				   $id =$_SESSION['id'];
				   $module = "Attendance";
				   
				  $actionperformed = "Attendance Updated of <b>".$aname." </b> of <b> ".$dateatt." </b>  and Old TimeIn: ".$ts.",<b> New TimeIn: ".$ti.", </b> Old TimeOut: ".$ts1.", <b> New TimeOut: ".$to." </b>";
				   
				   $activityby = 1;
				   // $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy) VALUES (?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby));
				   $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));					
					$res= $this->db->affected_rows();
					$this->db->close();
					echo $res;
				// }
				}
				else
				{	

					if($to = '00:00' && $attendancedate = $today){

						$query = $this->db->query("UPDATE `AttendanceMaster` SET TimeIn=?,timeindate=?,LastModifiedDate=? where Id=? and OrganizationId=?",array($ti,$dateIn,$mdate,$aid,$orgid));

						 $date = date("y-m-d H:i:s");
				   $orgid =$_SESSION['orgid'];
				   $id =$_SESSION['id'];
				   $module = "Employees";
				    $actionperformed = "Update Attendance of <b>".$aname." of ".$dateatt." and Old TimeIn is ".$ts." New TimeIn is ".$ti."";
				   $activityby = 1;
				   $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy) VALUES (?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby));	
					$res= $this->db->affected_rows();	

					echo $res;
					
					}
					else{
					$query = $this->db->query("UPDATE `AttendanceMaster` SET TimeIn=?,`TimeOut`=?,device=?,ExitImage=?,LastModifiedDate=?, Overtime=?,AttendanceStatus=? where Id=? and OrganizationId=?",array($ti,$to,$device,$timeoutimage,$mdate,$diff,$status1,$aid,$orgid));


					
				   $date = date("y-m-d H:i:s");
				   $orgid =$_SESSION['orgid'];
				   $id =$_SESSION['id'];
				   $module = "Employees";
				    $actionperformed = "Update Attendance of <b>".$aname." of ".$dateatt." and Old TimeIn is ".$ts." New TimeIn is ".$ti." and Old TimeOut is ".$ts1." New TimeOut is ".$to;
				   $activityby = 1;
				   $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy) VALUES (?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby));	
					$res= $this->db->affected_rows();	
				}
					
					$this->db->close();
					echo $res;
	
				}
			}
		}
			
	}
			
			public function getAllAttendanceLog(){
			$orgid=$_SESSION['orgid'];
		
		 $query = $this->db->query("SELECT * FROM  AttendanceLog where OrganizationId = ? AND ActivityBy = 1 ORDER BY LastModifiedDate DESC ",array($orgid));
			$d=array();
			$res=array();
			 foreach ($query->result() as $row)
			  {
				$data=array();
				$data['ActionPerformed'] = $row->ActionPerformed;
				$data['Module'] = $row->Module;
				$data['LastModifiedDate'] = date("d-M-Y H:i", strtotime($row->LastModifiedDate ));
				$data['LastModifiedById'] = ucwords(getAdminName($orgid));
				$res[]=$data;
			}  	
			$d['data']=$res; 
			 $this->db->close();
			echo json_encode($d); return false;
		}
		
			
			public function deleteAtt()
			{
					$orgid=$_SESSION['orgid'];
					$aid=isset($_REQUEST['aid'])?$_REQUEST['aid']:0;
					$name=isset($_REQUEST['ana'])?$_REQUEST['ana']:0;
					$del_att=isset($_REQUEST['del_att'])?$_REQUEST['del_att']:0;
					$del_att= date("M d,Y",strtotime($del_att));
					$query = $this->db->query("DELETE FROM `AttendanceMaster` where id=? and OrganizationId=?",array($aid,$orgid));
			
			       $date = date("y-m-d H:i:s");
				   $orgid =$_SESSION['orgid'];
				   $id =$_SESSION['id'];
				   $module = "Attendance";
				   $actionperformed = "Attendance has been <b>Deleted</b> for <b>".$name." of ".$del_att."</b>";
				   $activityby = 1;
				   $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));
			
			echo   $this->db->affected_rows(); 
			}
			
		
		
		
		////////////-----/Attendances
		
		
		///////////// list for timeoff employees
		public function getTimeOffEmpList(){
			header('Access-Control-Allow-Origin: *'); 
		$orgid=$_SESSION['orgid'];
		$zid=0;
		$zname='';
		$res='';
		/////////////get time zone
			$zname=getTimeZone($orgid);
			date_default_timezone_set ($zname);
		/////////////--/get time zone
		 $today=date('Y-m-d');

		 $query = $this->db->query("SELECT TimeFrom as BreakOn,(select EmployeeMaster.Id from EmployeeMaster where EmployeeMaster .id=Timeoff.EmployeeId )as EmployeeId FROM `Timeoff` where TimeofDate=? and TimeTo ='00:00:00'  and OrganizationId=?",array($today,$orgid));
		 if($query->num_rows()){
			 $i=1;
			foreach ($query->result() as $row){
					$res.= '<tr style="width:100%">
							<td>'.$i++.'.</td>
							<td>'.getEmpName($row->EmployeeId).'</td>
							<td>'.getDepartmentByEmpID($row->EmployeeId).'</td>
							<td>'.getDesignationByEmpID($row->EmployeeId).'</td>
							<td>'.substr(($row->BreakOn)).'</td>
						  </tr>';
						  /*<tr>
	                                        	<td>1</td>
	                                        	<td>Dakota Rice </td>
	                                        	<td>$36,738</td>
	                                        	<td>Niger</td>
	                                        	<td>Niger</td>
	                                        </tr>*/
				}
		 }else
			 $res.= '<tr style="width:100%"><td colspan="5">No Employees Found</td></tr>';
			 $this->db->close();
			echo $res;
		}
		///////////// list for timeoff employees/
		///////////// count for timeoff employees
		public function getTimeOffEmpCount(){
			header('Access-Control-Allow-Origin: *'); 
			$orgid=$_SESSION['orgid'];
			$zname=getTimeZone($orgid);
			date_default_timezone_set ($zname);
			$today=date('Y-m-d');
			$query = $this->db->query("SELECT count(TimeFrom) as total FROM `Timeoff` where TimeofDate=? and TimeTo ='00:00:00'  and OrganizationId=?",array($today,$orgid));
			if($row = $query->result())
			echo $row[0]->total;
		}
		///////////// count for timeoff employees/
		
		///////////// list for present employees
		public function getPresentEmpList(){
			header('Access-Control-Allow-Origin: *'); 
			
		$orgid=$_SESSION['orgid'];
		$zid=0;
		$zname='';
		$res='';
		/////////////get time zone
			$zname=getTimeZone($orgid);
			date_default_timezone_set ($zname);
		/////////////--/get time zone
		 $today=date('Y-m-d');
		 $query = $this->db->query("SELECT EmployeeId,TimeIn FROM `AttendanceMaster` where AttendanceDate=? and TimeOut='00:00:00' and OrganizationId=? order by LastModifiedDate desc",array($today,$orgid));
		 if($query->num_rows())
		 {
			 $i=1;
			foreach ($query->result() as $row){
					$res.= '<tr style="width:100%">
							<td>'.$i++.'.</td>
							<td>'.getEmpName($row->EmployeeId).'</td>
							<td>'.getDepartmentByEmpID($row->EmployeeId).'</td>
							<td>'.getDesignationByEmpID($row->EmployeeId).'</td>
							<td>'.substr(($row->TimeIn),0,5).'</td>
						  </tr>';
				}
		 }else
			 $res.= '<tr style="width:100%"><td colspan="5">No Employees Found</td></tr>';
			 $this->db->close();
			echo $res;
		}
		
		///////////// list for present employees/
		///////////// count for present employees
		public function getPresentEmpCount(){
		header('Access-Control-Allow-Origin: *'); 
		$orgid=$_SESSION['orgid'];
		//----------push check code
			try{
				$push="push/"; 
				if (!file_exists($push .$orgid . ".log"))
					return false;
				else
					unlink($push .$orgid . ".log");
			}catch(Exception $e){
				echo $e->getMessage();	
			}
		//----------push check code
				
		$zname='Asia/Kolkata';
		/////////////get time zone
			$zname=getTimeZone($orgid);
			date_default_timezone_set($zname);
		/////////////--/get time zone
		$today=date('Y-m-d');
		$arr=array();
		$query = $this->db->query("SELECT count(id) as total FROM `AttendanceMaster` where AttendanceDate=? and TimeOut='00:00:00' and OrganizationId=? ",array($today,$orgid));
			if($row = $query->result())
				$arr['count']= $row[0]->total;
		
		$query = $this->db->query("SELECT EmployeeId FROM `AttendanceMaster` where AttendanceDate=? and OrganizationId=? order by LastModifiedDate desc limit 1",array($today,$orgid));
			if($row = $query->result())
				$arr['name']= getEmpName($row[0]->EmployeeId);
			$this->db->close();	
			echo json_encode($arr);
		}
		
		////////fetch weekoff
		
		public function fetchWeeklyOff($sid){
			
         $shiftid = $sid;			
		 $orgId=isset($_SESSION['orgid'])?$_SESSION['orgid']:0;
			$data=array();
			$res=array();
			$query = $this->db->query("select * from ShiftMasterChild WHERE `OrganizationId`=? AND ShiftId = ?",array($orgId,$shiftid));
			if($this->db->affected_rows()>0)
			foreach($query->result() as $row)
			{
				$data['week']=$row->WeekOff;
				$data['day']=$row->Day ;
				$res[]=$data;
			}
			
			// else
			// {
			// $query = $this->db->query("select * from WeekOffMaster WHERE `OrganizationId`=?",array($orgId));
			 // foreach ($query->result() as $row)
				// {
				// $data['week']=$row->WeekOff;
				// $data['day']=$row->Day ;
				// $res[]=$data;
			  // }
			// }
			$d['data']=$res;  
            $this->db->close();			//$query->result();
			echo json_encode($d);
			return false;
			/* $weekday=explode (",",$data['week']);
						for($i=0;$i<count($weekday);$i++)
						{
						if($weekday[$i]==0){
							//echo "Sun ";
						}   
							else if($weekday[$i]==1){
								//echo "Mon ";
							}
			} */
		}
		
		///////////// count for present employees/
		/////////////holidays management
		    public function editWeeklyOff(){ 
			$orgId=isset($_SESSION['orgid'])?$_SESSION['orgid']:0;
			//$sunday=explode($sunday);
			$query = $this->db->query("select * from WeekOffMaster WHERE `OrganizationId`=?",array($orgId));
		    
			if(!$query->num_rows()){
				$this->addWeeklyOff();   // created rows if no rows inserted yet
				return false;
			} 
			
			$sun=isset($_REQUEST['sun'])?$_REQUEST['sun']:'0,0,0,0,0';
			$mon=isset($_REQUEST['mon'])?$_REQUEST['mon']:'0,0,0,0,0';
			$tue=isset($_REQUEST['tue'])?$_REQUEST['tue']:'0,0,0,0,0';
			$wed=isset($_REQUEST['wed'])?$_REQUEST['wed']:'0,0,0,0,0';
			$thus=isset($_REQUEST['thus'])?$_REQUEST['thus']:'0,0,0,0,0';
			$fri=isset($_REQUEST['fri'])?$_REQUEST['fri']:'0,0,0,0,0';
			$sat=isset($_REQUEST['sat'])?$_REQUEST['sat']:'0,0,0,0,0';
			$user=0;
			$zname='Asia/Kolkata';
			/////////////get time zone
				$zname=getTimeZone($orgId);
				date_default_timezone_set ($zname);
			/////////////--/get time zone
			$today=date('Y-m-d');
			$query = $this->db->query("UPDATE WeekOffMaster set `WeekOff`=?,`ModifiedBy`=?, `ModifiedDate`=? WHERE `OrganizationId`=? and Day=1",array($sun,$user,$today,$orgId));
			$query = $this->db->query("UPDATE WeekOffMaster set `WeekOff`=?,`ModifiedBy`=?, `ModifiedDate`=? WHERE `OrganizationId`=? and Day=2",array($mon,$user,$today,$orgId));
			$query = $this->db->query("UPDATE WeekOffMaster set `WeekOff`=?,`ModifiedBy`=?, `ModifiedDate`=? WHERE `OrganizationId`=? and Day=3",array($tue,$user,$today,$orgId));
			$query = $this->db->query("UPDATE WeekOffMaster set `WeekOff`=?,`ModifiedBy`=?, `ModifiedDate`=? WHERE `OrganizationId`=? and Day=4",array($wed,$user,$today,$orgId));
			$query = $this->db->query("UPDATE WeekOffMaster set `WeekOff`=?,`ModifiedBy`=?, `ModifiedDate`=? WHERE `OrganizationId`=? and Day=5",array($thus,$user,$today,$orgId));
			$query = $this->db->query("UPDATE WeekOffMaster set `WeekOff`=?,`ModifiedBy`=?, `ModifiedDate`=? WHERE `OrganizationId`=? and Day=6",array($fri,$user,$today,$orgId));
			$query = $this->db->query("UPDATE WeekOffMaster set `WeekOff`=?,`ModifiedBy`=?, `ModifiedDate`=? WHERE `OrganizationId`=? and Day=7",array($sat,$user,$today,$orgId));
			if($this->db->affected_rows()>0)
				echo 1;
			else
				echo 0;		
			return;
		}
		public function addWeeklyOff(){ 
			$sun=isset($_REQUEST['sun'])?$_REQUEST['sun']:'0,0,0,0,0';
			$mon=isset($_REQUEST['mon'])?$_REQUEST['mon']:'0,0,0,0,0';
			$tue=isset($_REQUEST['tue'])?$_REQUEST['tue']:'0,0,0,0,0';
			$wed=isset($_REQUEST['wed'])?$_REQUEST['wed']:'0,0,0,0,0';
			$thus=isset($_REQUEST['thus'])?$_REQUEST['thus']:'0,0,0,0,0';
			$fri=isset($_REQUEST['fri'])?$_REQUEST['fri']:'0,0,0,0,0';
			$sat=isset($_REQUEST['sat'])?$_REQUEST['sat']:'0,0,0,0,0';
			$user=0;
			$orgId=isset($_SESSION['orgid'])?$_SESSION['orgid']:$_REQUEST['refId']; // ref id if fun called by mobile when not set session
			$zname='Asia/Kolkata';
			/////////////get time zone
				$zname=getTimeZone($orgId);
				date_default_timezone_set ($zname);
			/////////////--/get time zone
			$today=date('Y-m-d');
			$query = $this->db->query("INSERT INTO `WeekOffMaster`(`Day`,`WeekOff`, `OrganizationId`, `ModifiedBy`, `ModifiedDate`, `Archive`) VALUES (1,?,?,?,?,'1')",array($sun,$orgId,$user,$today));
			$query = $this->db->query("INSERT INTO `WeekOffMaster`(`Day`,`WeekOff`, `OrganizationId`, `ModifiedBy`, `ModifiedDate`, `Archive`) VALUES (2,?,?,?,?,'1')",array($mon,$orgId,$user,$today));
			$query = $this->db->query("INSERT INTO `WeekOffMaster`(`Day`,`WeekOff`, `OrganizationId`, `ModifiedBy`, `ModifiedDate`, `Archive`) VALUES (3,?,?,?,?,'1')",array($tue,$orgId,$user,$today));
			$query = $this->db->query("INSERT INTO `WeekOffMaster`(`Day`,`WeekOff`, `OrganizationId`, `ModifiedBy`, `ModifiedDate`, `Archive`) VALUES (4,?,?,?,?,'1')",array($wed,$orgId,$user,$today));
			$query = $this->db->query("INSERT INTO `WeekOffMaster`(`Day`,`WeekOff`, `OrganizationId`, `ModifiedBy`, `ModifiedDate`, `Archive`) VALUES (5,?,?,?,?,'1')",array($thus,$orgId,$user,$today));
			$query = $this->db->query("INSERT INTO `WeekOffMaster`(`Day`,`WeekOff`, `OrganizationId`, `ModifiedBy`, `ModifiedDate`, `Archive`) VALUES (6,?,?,?,?,'1')",array($fri,$orgId,$user,$today));
			$query = $this->db->query("INSERT INTO `WeekOffMaster`(`Day`,`WeekOff`, `OrganizationId`, `ModifiedBy`, `ModifiedDate`, `Archive`) VALUES (7,?,?,?,?,'1')",array($sat,$orgId,$user,$today));
			if($this->db->affected_rows()>0)
				echo 1;
			else
				echo 0;			
			return;
		}
		public function getAllHolidays(){
			$orgid=$_SESSION['orgid'];
			$q="";
			$date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
			//,DATEDIFF('DateTo','fromDate') AS DiffDate
	/*	if($date=='')
			{
				 $enddate=date("Y-m-d");
		         $startdate=date('Y-m-d',(strtotime('-30 day',strtotime(date('Y-m-d'))) ));
				 
			     $q=" AND `DateFrom` BETWEEN '$startdate' AND '$enddate' ";
			} 
			 if($date!='')
				{
				$arr=explode('-', trim($date));
				$end= date('Y-m-d',strtotime($arr[1]));
				$strt= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3))); 
			$q.=" AND `DateFrom` BETWEEN  '$strt' AND '$end' ";
			
			}
			*/
			
		 $query = $this->db->query("SELECT `Id`, `Name`, `Description`, DATE(DateFrom) AS fromDate, `DateTo`, DATEDIFF(DATE(DateTo),DATE(DateFrom)) + 1  AS DiffDate FROM `HolidayMaster` WHERE OrganizationId=?  order by fromDate DESC",array($orgid));
			$d=array();
			$res=array();
			 foreach ($query->result() as $row)
			  {
				    $data=array();
					$data['name']=$row->Name;
					$data['from']=date("d-M-Y", strtotime($row->fromDate));
					//$from=date($row->fromDate);
					$data['to']=date("d-M-Y", strtotime($row->DateTo));
					//$to=date($row->DateTo);
					$data['days']=$row->DiffDate;
					/* if($data['days']=='0'){
						$data['days']=='1';
					} */
					$data['description']=$row->Description;
					if($row->fromDate > date("Y-m-d"))
					{
					$data['action']='<a href="#"><i class="material-icons edit" style="font-size:26px" data-toggle="modal" title="Edit" data-sid="'.$row->Id.'"
					 data-sid="'.$row->Id.'" 
					 data-name="'.$row->Name.'" 
					 data-from="'.date("d-m-Y", strtotime($row->fromDate)).'" 
					 data-to="'.date("d-m-Y", strtotime($row->DateTo)).'" 
					 data-description="'.$row->Description.'"
					 data-target="#edit">edit</i></a>
					 <i class="delete fa fa-trash" style="font-size:24px; color:purple" data-toggle="modal" data-target="#delete" data-sid="'.$row->Id.'" data-sname="'.$row->Name.'" title="Delete" ></i>';
					}
					else
					{
					  $data['action']='<a href="#"><i class=" cant12 material-icons edit" style="font-size:26px" title="Cannot be edited" data-sid="'.$row->Id.'"
					 data-sid="'.$row->Id.'" 
					 data-name="'.$row->Name.'" 
					 data-from="'.date("d-m-Y", strtotime($row->fromDate)).'" 
					 data-to="'.date("d-m-Y", strtotime($row->DateTo)).'" 
					 data-description="'.$row->Description.'"
					 >edit</i></a>
					 <i class="cant23 delete fa fa-trash" style="font-size:24px; color:purple" data-sid="'.$row->Id.'" data-sname="'.$row->Name.'" title="Cannot be deleted" ></i>';	
					}
					 $res[]=$data;
			}  	
			$d['data']=$res; 
			 $this->db->close();
			echo json_encode($d); return false;
		}
		public function getAllActivity(){
			$orgid=$_SESSION['orgid'];
			$adminid=$_SESSION['id'];
			///==========
			$q='';
			
			$date=isset($_REQUEST['date'])?$_REQUEST['date']:'';

			// var_dump($date);
			// die;
			

			// if($date == ''){
			// 		$enddate=date("Y-m-d");
		 //         $startdate=date('Y-m-d',(strtotime ( '-7 day',strtotime(date('Y-m-d'))) ));
				 
			//      $q.=" AND  `LastModifiedDate` BETWEEN  '$startdate' AND '$enddate' ";
			// }
			// else{
			// 		// $enddate = date('Y-m-d');
			// 		// $startdate = date('Y-m-d');
			
			// 	$arr=explode('-', trim($date));
			// 	$end= date('Y-m-d',strtotime($arr[1]));
			// 	$strt= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3))); 
			// $q.=" AND `LastModifiedDate` BETWEEN  '$strt' AND '$end' ";
			// // echo $date;
			// // echo $end;
			// // echo $strt;

			// }
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
					   // $enddate=date("Y-m-d");
						//$startdate=date("Y-m-d");
				   }


		
			
			
		 $query = $this->db->query("SELECT  Id ,LastModifiedDate AS LastModifiedDate, Module, LastModifiedById,ActionPerformed, OrganizationId , ActivityBY, adminid FROM  ActivityHistoryMaster where OrganizationId = ? AND ActivityBy = 1 AND DATE(LastModifiedDate ) IN ( ".$range." )   ORDER BY DATE(LastModifiedDate ) DESC  ",array($orgid));
		}
		 // var_dump($this->db->last_query());
		else{
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
				//echo $range;
			 $rangedate = $range;
			 // var_dump($rangedate)
			 
			
			 if($rangedate == "")
				{
			   $rangedate = 1;
				} 

				 $query = $this->db->query("SELECT  Id ,LastModifiedDate AS LastModifiedDate, Module, LastModifiedById,ActionPerformed, OrganizationId , ActivityBY, adminid FROM  ActivityHistoryMaster where OrganizationId = ? AND ActivityBy = 1 AND DATE(LastModifiedDate ) IN ( ".$range." )  ORDER BY DATE(LastModifiedDate ) DESC  ",array($orgid));
		}

			$d=array();
			$res=array();
			 foreach ($query->result() as $row)
			  {
				$data=array();
				$data['ActionPerformed'] = $row->ActionPerformed;
				$data['Module'] = $row->Module;
				

				// print_r($data['LastModifiedDate']);
				// die;
				$data['LastModifiedById'] = "";
				if($row->adminid != 0){
				$data['LastModifiedById'] = ucwords(getAdminName($row->adminid));
			}
			else{
				$data['LastModifiedById'] = ucwords(getAdminName($row->ActivityBY));
			}
			$data['LastModifiedDate'] = substr(($row->LastModifiedDate),0,16);
				$res[]=$data;
			
			}  	
			$d['data']=$res; 
			 $this->db->close();
			echo json_encode($d); return false;
		}
		
		
		public function addHoliday()
		{
			$orgid=$_SESSION['orgid'];
			$id=$_SESSION['id'];
			$sna=isset($_REQUEST['name'])?$_REQUEST['name']:'';
			$fromdate=date("Y-m-d", strtotime(isset($_REQUEST['from'])?$_REQUEST['from']:''));
			$todate=date("Y-m-d", strtotime(isset($_REQUEST['to'])?$_REQUEST['to']:''));
			$data['afft']=0;
			$desc=isset($_REQUEST['desc'])?$_REQUEST['desc']:'';
			$date=date('Y-m-d');
			$query1 = $this->db->query("SELECT Name FROM HolidayMaster WHERE Name='$sna' and OrganizationId='$orgid' ");
			$data['name']=$query1->num_rows();
			
			$query2 = $this->db->query("SELECT DateFrom FROM HolidayMaster WHERE DateFrom='$fromdate'  and OrganizationId='$orgid' ");
			$data['datefrom']=$query2->num_rows();
			
             if($data['name']==0 and $data['datefrom']==0)
				{				 
				$query = $this->db->query("INSERT INTO `HolidayMaster`(`Name`, `Description`, `DateFrom`, `DateTo`, `DivisionId`, `OrganizationId`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `FiscalId`) VALUES (?,?,?,?,'0',?,?,?,?,?,1)",array($sna,$desc,$fromdate,$todate,$orgid,$date,$id,$date,$id));
				$data['afft']=$this->db->affected_rows();
				if($data['afft'] > 0){

					$query121 = $this->db->query("SELECT Name FROM HolidayMaster WHERE Name='$sna' and OrganizationId='$orgid' ");
						if ($r=$query121->result()){
							$hname  = $r[0]->Name;
					$date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           
           $module = "Settings";
           $actionperformed = " <b>".$hname."</b> holiday has been added  </b>.";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));

					}
				}
				}
			$this->db->close();
			echo json_encode($data);
			}
			
		public function deleteShift()
		{
			$orgid=$_SESSION['orgid'];
			$sid=isset($_REQUEST['sid'])?$_REQUEST['sid']:'';
			$data=array();
			$data['afft']=0;
			$query12112 = $this->db->query("SELECT `Id`, `Name`, `TimeIn`, `TimeOut`, `TimeInGrace`, `TimeOutGrace`, `TimeInBreak`, `TimeOutBreak`, `OrganizationId`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `OwnerId`, `BreakInGrace`, `BreakOutGrace`, `archive`, `shifttype` FROM `ShiftMaster` WHERE  Id = '$sid' ");
			$query = $this->db->query("select id as totattn from AttendanceMaster where AttendanceMaster.shiftid=? and OrganizationId=?",array($sid,$orgid));
			$data['attn']=$query->num_rows();
			
			$query = $this->db->query("select id as totemp from EmployeeMaster where EmployeeMaster.shift=? and OrganizationId=? and Is_Delete != 2",array($sid,$orgid));
			$data['emp']=$query->num_rows();

			$query = $this->db->query("select id as totarc from ArchiveAttendanceMaster where ArchiveAttendanceMaster.ShiftId=? and OrganizationId=?",array($sid,$orgid));
			$data['arc']=$query->num_rows();
			if($data['attn']==0 and $data['emp']==0 and $data['arc']==0)
			{
				$query = $this->db->query("DELETE FROM `ShiftMaster` where id=? and OrganizationId=?",array($sid,$orgid));
				$data['afft']=$this->db->affected_rows();
				if($data['afft']>0)
				{
				  $query = $this->db->query("DELETE FROM `ShiftMasterChild` where ShiftId=? and OrganizationId=?",array($sid,$orgid));

				 /* $count1 = $this->db->affected_rows();*/
				}
			}
			 // $this->db->close();
			echo json_encode($data);

			if($data['afft'] > 0){



			if ($r=$query12112->result()){
							$sname  = $r[0]->Name;
							
					$date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $id =$_SESSION['id'];
           
           $module = "Settings";
           $actionperformed = " <b>".$sname."</b> shift has been <b> Deleted.  </b>.";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));

					}
				}

				
			
		}
		public function editHoliday(){
			$orgid=$_SESSION['orgid'];
			$id=$_SESSION['id'];
			$sid=isset($_REQUEST['sid'])?$_REQUEST['sid']:'';
			$sna=isset($_REQUEST['name'])?$_REQUEST['name']:'';
			$fromdate=date("Y-m-d", strtotime(isset($_REQUEST['from'])?$_REQUEST['from']:''));
			$todate=date("Y-m-d", strtotime(isset($_REQUEST['to'])?$_REQUEST['to']:''));
			$desc=isset($_REQUEST['desc'])?$_REQUEST['desc']:'';
			$date=date('Y-m-d');
			$query = $this->db->query("update HolidayMaster set Name=?, `Description`=?, `DateFrom`=?, `DateTo`=?,`LastModifiedDate`=?, `LastModifiedById`=? where Id=?",array($sna,$desc,$fromdate,$todate,$date,$id,$sid));
			 // $this->db->close();
			echo $this->db->affected_rows();
			if($this->db->affected_rows() > 0){

				$query1211 = $this->db->query("SELECT `Id`, `Name`, `Description`, `DateFrom`, `DateTo`, `DivisionId`, `OrganizationId`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `FiscalId` FROM `HolidayMaster` WHERE Id=$sid");
				if ($r=$query1211->result()){
							$hname  = $r[0]->Name;
							
					$date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           
           $module = "Settings";
           $actionperformed = " <b>".$hname."</b> holiday has been Updated.  </b>.";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));

					}


			}
		}
		public function deleteHoliday(){
			$did=isset($_REQUEST['sid'])?$_REQUEST['sid']:'';
			$query12112 = $this->db->query("SELECT `Id`, `Name`, `Description`, `DateFrom`, `DateTo`, `DivisionId`, `OrganizationId`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `FiscalId` FROM `HolidayMaster` WHERE Id=$did");
			$query = $this->db->query("delete from HolidayMaster where Id=?",array($did));
			 // $this->db->close();
			echo $this->db->affected_rows();
			if($this->db->affected_rows() > 0){
				if ($r=$query12112->result()){
							$hname  = $r[0]->Name;
							
					$date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $id =$_SESSION['id'];
           
           $module = "Settings";
           $actionperformed = " <b>".$hname."</b> holiday has been Deleted.  </b>.";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));

					}
			}
		}
		/////////////holidays management//
		
		////*** show remain day on subscriptions expire.. Added By surbhi 
	
	public function remainday()
	{
		
		  $orgid=$_SESSION['orgid'];
		  $query = $this->db->query("SELECT * FROM  `licence_ubiattendance` WHERE OrganizationId	= ? ",array($orgid));
		  $d=array();
		  $res=array();
			//$week =	explode(",",$row[0]->WeekOff);
			foreach ($query->result() as $row)
			{
				$data=array();
				$d=array();
			    $sdate =$row->start_date;
				$edate =$row->end_date;
				$now =date("Y-m-d");
				$date1 = new DateTime($now);  //current date or any date
                $date2 = new DateTime($edate);   //gave end date
                $diff = $date2->diff($date1)->format("%a");  //find difference
                // $data['remaindays'] = intval($diff);   //rounding days
                //echo $days;
			    $remaindays =0;
				 if( intval($diff) <= 15){
			    $remaindays = intval($diff);
				} 
			}  	
			$d['data']=$remaindays;  				//$query->result();
			$this->db->close();
			echo json_encode($d);
			return false;
		}
		
		//Time Off Report start//
		public function Timeoffreport(){
			$orgid=$_SESSION['orgid'];
	        $date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
	        $shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:'';
		    $deprtid=isset($_REQUEST['deprt'])?$_REQUEST['deprt']:'';
			$emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:'';
			$desgid=isset($_REQUEST['desg'])?$_REQUEST['desg']:'';
			$q="";
			if($date=='')
			{
				 $enddate=date("Y-m-d");
		         $startdate=date('Y-m-d',(strtotime ( '-7 day',strtotime(date('Y-m-d'))) ));
				 
			     $q=" AND  `TimeofDate` BETWEEN  '$startdate' AND '$enddate' ";
			}
			else{
					$enddate = date('Y-m-d');
					$startdate = date('Y-m-d');
			}
			if($deprtid!=0)
				{
				
			 $q.=" AND  EmployeeId IN( SELECT `Id` FROM `EmployeeMaster` 
			  WHERE `Department` = '$deprtid' ) ";
				
			} 
			if($shiftid!=0)
				{
				
			 $q.=" AND  EmployeeId IN( SELECT `Id` FROM `EmployeeMaster` 
			  WHERE `Shift` = '$shiftid' ) ";
				
			} 
		
            if($desgid!=0)
				{
			 $q.=" AND  EmployeeId IN( SELECT `Id` FROM `EmployeeMaster` 
			  WHERE `Designation` = '$desgid' ) ";
				
					} 

          if($emplid!=0)
			{
				$q.=" AND `EmployeeId`='$emplid' ";
			
			}			
		  if($date!='')
				{
				$arr=explode('-', trim($date));
				$end= date('Y-m-d',strtotime($arr[1]));
				$strt= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3)));
				
				$q.=" AND `TimeofDate` BETWEEN  '$strt' AND '$end' ";
			
			}
			if($deprtid==0  && $shiftid==0  && $desgid==0  && $emplid==0){
			$sql="SELECT E.EmployeeCode,T.EmployeeId,T.ApprovalSts,T.TimeofDate,T.TimeFrom,T.TimeTo,T.Reason FROM `Timeoff` T,EmployeeMaster E  WHERE T.OrganizationId =? AND 	E.Id=T.EmployeeId   AND E.Is_Delete = '0'  ";	
			}
			
		    $sql="SELECT   E.EmployeeCode,T.EmployeeId,T.ApprovalSts,T.TimeofDate,T.TimeFrom,T.TimeTo,	T.Reason	,TIMEDIFF(T.`TimeTo`,T.`TimeFrom`) AS stype FROM `Timeoff` T,EmployeeMaster E WHERE T.OrganizationId =?  AND E.Id=T.EmployeeId $q  AND E.Is_Delete = '0'   ";
			
			 $query = $this->db->query($sql,array($orgid));
			 //echo $sql;
			 $d=array();
			 $res=array();
			foreach ($query->result() as $row)
			 {
				$data=array();
				    $name = ucwords(getEmpName($row->EmployeeId));
					if($name != "")
					{
					$data['Name']=  $name;
					$data['code']=   $row->EmployeeCode;
				//	$data['device']=   $row->device;
				    $data['date']= date('M d,Y',strtotime($row->TimeofDate));
					$data['TimeFrom']=substr(($row->TimeFrom),0,5);
					$data['TimeTo']=substr(($row->TimeTo),0,5);
					//if(strtotime($row->TimeTo) > strtotime($row->TimeFrom))
					$data['Totaltime']=substr(($row->stype),0,5);
					$data['Reason']=$row->Reason;
					if($data['Reason']=='')
					{
						$data['Reason']="Not given";
					}
					$sts = $row->ApprovalSts;
					$type = "LeaveStatus";
					$sql1 = $this->db->query("select DisplayName FROM OtherMaster WHERE OtherType=? AND ActualValue=?",array($type,$sts));
					foreach($sql1->result() as $row1){
						$data['approsts'] = $row1->DisplayName;
					}
					
					//$a = new DateTime(substr (getShiftTimes($row->ShiftId),0,5));
                    // $b = new DateTime($row->TimeIn);
                    // $interval = $a->diff($b);
                    //  $data['LateHours']=$interval->format("%H:%I");
					$Tio=getShiftTimeByEmpID($row->EmployeeId);
				    $data['desg']=ucwords(getDesignationByEmpID($row->EmployeeId));
				    $data['shift']=ucwords(getShiftByEmpID($row->EmployeeId))." (".$Tio.")";
				    $data['depart']=ucwords(getDepartmentByEmpID($row->EmployeeId));
					$res[]=$data;	
			   }
			} 
             $d['data']=$res; 
             $this->db->close();			//$query->result();
			echo json_encode($d); return false;
		}
		///Tim e off Report end 
		
		
		////Monthly Report Start
		
		function getMonthlyEmployee(){
	    $date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
	    $shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:0;
	    $deprtid=isset($_REQUEST['deprt'])?$_REQUEST['deprt']:'';
	    $emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:'';
	    $desgid=isset($_REQUEST['desg'])?$_REQUEST['desg']:'';
		$q="";
		$s="";
		if($date=='')
			{
				 $enddate=date("Y-m-d");
		         $startdate=date('Y-m-d',(strtotime ( '-30 day',strtotime(date('Y-m-d'))) ));
				 $s =" AND  `AttendanceDate` BETWEEN  '$startdate' AND '$enddate' ";
			}
			if($deprtid!=0)
				{
			 $q.=" AND `Department` = '$deprtid'  ";
				
			} 
			if($shiftid!=0)
				{
				
			$q.=" AND `Shift`='$shiftid' ";
				
			}
            if($desgid!=0)
				{
				
			 $q.=" AND `Designation` = '$desgid'  ";
				
			} 

          if($emplid!=0)
			{
				$q.=" AND `Id`='$emplid' ";
			
			}			
		  if($date!='')
				{
				$arr=explode('-', trim($date));
				$end= date('Y-m-d',strtotime($arr[1]));
				$strt= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3))); 
			$s.=" AND `AttendanceDate` BETWEEN  '$strt' AND '$end' ";
			
			}
		//$res = array();
		$ci =& get_instance();
		$ci->load->database();
		$i = 1;
		$org_id = $_SESSION['orgid'];
		$zone=getTimeZone($org_id);
        date_default_timezone_set($zone);
		$date = date("Y-m-d");
		//$d=array();
			
        $query1 = $this->db->query("select Id,FirstName,LastName,Shift,`Department`, `Designation` from EmployeeMaster where OrganizationId = ? $q order by FirstName ",array($org_id));
		if($query1->num_rows() != 0){
			//$query = $this->db->query($query1,array($org_id));
			$d=array();
			$res=array();
			foreach ($query1->result() as $row)
			{
				$data = array();
				$month = date("m", strtotime("-1 months")); 
				$year = date("Y", strtotime("-1 months")); 
				$Eid = $row->Id;
				$data['FirstName'] =ucwords(getEmpName($row->Id));
				$Tio=getShiftTimes($row->Shift);
				$data['shift1']=getShift($row->Shift). " (".$Tio.")";
			    $data['desg']=ucwords(getDesignationByEmpID($row->Id));
				$data['deprt']=ucwords(getDepartmentByEmpID($row->Id));
				$Shift = $row->Shift;
				// get Earlyleaving Start///
                $query2 = $ci->db->query("select SEC_TO_TIME( SUM( LEFT( TIMEDIFF( C.TimeOut, A.TimeOut ) , 2 ) *3600 + SUBSTRING( TIMEDIFF( C.TimeOut, A.TimeOut ) , 4, 2 ) *60 + SUBSTRING( TIMEDIFF( C.TimeOut, A.TimeOut ) , 7, 2 ) ) ) AS EarlyLeaving from AttendanceMaster A,ShiftMaster C where A.EmployeeId =$Eid and A.OrganizationId = $org_id  and MONTH(A.AttendanceDate) = '$month' and YEAR(A.AttendanceDate) = '$year' and C.OrganizationId = $org_id and C.Id =$Shift and A.TimeOut !='00:00:00' and A.TimeOut < C.TimeOut");
				$result2 = $query2->row();
				$EarlyLeaving = $result2->EarlyLeaving;
				//if($EarlyLeaving == "")
				//$EarlyLeaving = '00:00:00';
				//$EarlyLeaving =  date('H :i', strtotime($EarlyLeaving));
				
				$data['EarlyLeaving'] =substr(($EarlyLeaving),0,5);
				//$data['EarlyLeaving'] =$EarlyLeaving;
					if($EarlyLeaving==''){
					$data['EarlyLeaving'] ='-';
				}	
				// get Earlyleaving end///
                // get LateComing Start///				
				$query1 = $ci->db->query("select SEC_TO_TIME(SUM( LEFT( TIMEDIFF( A.TimeIn, C.TimeIn ) , 2 ) *3600 + SUBSTRING( TIMEDIFF( A.TimeIn, C.TimeIn ) , 4, 2 ) *60 + SUBSTRING( TIMEDIFF( A.TimeIn, C.TimeIn ) , 7, 2 ) ) ) AS LateComing from AttendanceMaster A,ShiftMaster C where A.EmployeeId =$Eid and A.OrganizationId = $org_id   and MONTH(A.AttendanceDate) = '$month' and YEAR(A.AttendanceDate) = '$year' and A.TimeIn >C.TimeIn and C.OrganizationId = $org_id and C.Id =$Shift");
				 $result3 = $query1->row();
				 $LateComing = $result3->LateComing;
				 // get LateComing End///	
				// if($LateComing == "")
				// $LateComing = '00:00:00';
				// $LateComing =  date('H :i', strtotime($LateComing));
				$data['LateComing'] =substr($LateComing,0,5);
				if($LateComing==''){
					$data['LateComing']='-';
				}
				// get overtime start//
               
				 $query4 = $ci->db->query("SELECT TIMEDIFF(SEC_TO_TIME( SUM( LEFT( TIMEDIFF( A.TimeOut, A.TimeIn ) , 2 ) *3600 + SUBSTRING( TIMEDIFF( A.TimeOut, A.TimeIn ) , 4, 2 ) *60 + SUBSTRING( TIMEDIFF( A.TimeOut, A.TimeIn ) , 7, 2 ) ) ),SEC_TO_TIME( SUM( LEFT( TIMEDIFF( C.TimeOut, C.TimeIn ) , 2 ) *3600 + SUBSTRING( TIMEDIFF( C.TimeOut, C.TimeIn ) , 4, 2 ) *60 + SUBSTRING( TIMEDIFF( C.TimeOut, C.TimeIn ) , 7, 2 ) ) )) as overtime FROM AttendanceMaster A, ShiftMaster C WHERE A.EmployeeId =$Eid AND A.OrganizationId =$org_id AND MONTH( A.AttendanceDate ) =  '$month' AND YEAR( A.AttendanceDate ) =  '$year' AND C.OrganizationId =$org_id AND C.Id =$Shift");
                $result4 = $query4->row();
				$overtime= $result4->overtime;
				//$data['overtime'] =$overtime;
				//$overtime =  date('H :i', strtotime($overtime));
				if($overtime < '00:00:00'){
					$undertime =$overtime;
					
					$data['undertime'] =substr(trim($undertime,"-!"),0,5);
					//$data['undertime']=$undertime;
					$data['overtime'] = "-";
				}else{
					$overtime = $overtime;
					$data['overtime'] =substr($overtime,0,5);
					$data['undertime']="-";
				}
				if($overtime =='' ){
					$data['overtime'] ="-";
					$data['undertime']="-";
				}
			$res[]=$data;
			}
			$d['data']=$res;  
            $this->db->close();			//$query->result();
			echo json_encode($d); return false;	
		}
   }
   public function trackLocations($eid,$date){
			header('Access-Control-Allow-Origin: *'); 
			$res=array();
			// $d=array();
			$orgid=isset($_SESSION['orgid'])?$_SESSION['orgid']:'0';
			//$eid=isset($_SESSION['eid'])?$_SESSION['eid']:'0';
			//$date=isset($_SESSION['date'])?$_SESSION['date']:'0';
			$query = $this->db->query("SELECT FakeVisitOutTimeStatus, FakeVisitInTimeStatus , FakeVisitOutTimeStatus,`EmployeeId`,`location`, `latit`, `longi`, `time`,`time_out`, `location_out`,`checkin_img`,`latit_out`,`longi_out`,`checkout_img`, `date`, `client_name`, `description`,CASE WHEN(time_out>=time && time_out !='00:00:00' && time!='00:00:00') THEN TimeDiff( concat(date, ' ' ,time_out) , concat(date, ' ', time)) WHEN(time_out !='00:00:00' && time!='00:00:00') THEN (timediff('24:00:00',TimeDiff( concat(date, ' ' ,time) , concat(date, ' ', time_out)) )) ELSE('00:00') END as workhour,(SELECT  sec_to_time( sum(time_to_sec(timediff(`time_out`,`time`)))) as abc FROM `checkin_master` WHERE EmployeeId=$eid and  date ='$date' and time_out != '00:00:00') as twh FROM checkin_master  where EmployeeId=? and date =?  and OrganizationId=? order by time asc ",array($eid,$date,$orgid));

			// return $query->result();

			  // $d=array();                    
			
			$i=1;
			 foreach ($query->result() as $row)
			 	{	
					$dat=array();

					$dat['sno'] = $i++;
					$dat['client'] = $row->client_name;
					$dat['inimg'] = '<i class="pop" data-toggle="modal" data-target="#imagemodal" data-id="'.$row->EmployeeId.'" data-enimage="'.$row->checkin_img.'"><img src="'.$row->checkin_img.'"  style="width:60px!important; "  /></i>';
					$dat['tin'] = substr($row->time,0,5);
					if($row->FakeVisitInTimeStatus == 1){

						$dat['fti']='<div title="TimeIn recorded maliciously" class="text-center"  data-background-color="red">Fake</div>';

					}
					else{
						$dat['fti']="";
					}

					$dat['tif']="";
					if($row->FakeVisitInTimeStatus == 0){
						$dat['tif'] =  substr($row->time,0,5);
					}
					else{
						$dat['tif']=substr($row->time,0,5).' ' .$dat['fti'];
					}

					$dat['inloc'] = '<a href="http://maps.google.com/?q='.$row->latit.','.$row->longi.'" target="_blank" title="Click here to point location on google map" >'.$row->location.'</a>';

					$dat['otimg'] = '<i class="pop" data-toggle="modal" data-target="#imagemodal" data-id="'.$row->EmployeeId.'" data-enimage="'.$row->checkout_img.'"><img src="'.$row->checkout_img.'"  style="width:60px!important; "  /></i>';

					$dat['to']=substr($row->time_out,0,5);

					if($row->FakeVisitOutTimeStatus == 1){

						$dat['fto']='<div title="TimeOut recorded maliciously" class="text-center"  data-background-color="red">Fake</div>';

					}
					else{
						$dat['fto']="";
					}

					$dat['tof']="";
					if($row->FakeVisitOutTimeStatus == 0){
						$dat['tof'] =  substr($row->time_out,0,5);
					}
					else{
						$dat['tof']=substr($row->time_out,0,5).' ' .$dat['fto'];
					}

					$dat['outloc'] = '<a href="http://maps.google.com/?q='.$row->latit.','.$row->longi.'" target="_blank" title="Click here to point location on google map" >'.$row->location_out.'</a>';

					$dat['workhr'] = substr($row->workhour,0,5);
					$dat['desc'] = $row->description ;
					$dat['latit'] = $row->latit ;
					$dat['longi'] = $row->longi ;
					$dat['latit_out'] = $row->latit_out ;
					$dat['longi_out'] = $row->longi_out ;
		
		$res[]=$dat;
			    }
		     	// $d['data']=$res;  
			// print_r($d['data']);
            // $this->db->close();			//$query->result();
			// echo json_encode($d); 
			// return false;
		    	 	
			return  $res;
		}	

 //   public function trackLocations($eid,$date)
 //   {
	   
	// 		header('Access-Control-Allow-Origin: *'); 
	// 		$orgid=isset($_SESSION['orgid'])?$_SESSION['orgid']:'0';
	// 		//$eid=isset($_SESSION['eid'])?$_SESSION['eid']:'0';
	// 		//$date=isset($_SESSION['date'])?$_SESSION['date']:'0';
			
	// 		$query = $this->db->query("SELECT ch.id,ch.location, ch.latit,ch.longi, ch.time,ch.time_out,ch.date,ch.`client_name`, ch.description,ch.latit_out, ch.longi_out,ch.location_out,ch.descriptionIn,chvl.ProductNo,chvl.TrailerNo, if(ch.time_out !='00:00:00',SEC_TO_TIME(TimeDiff( concat(ch.date, ' ' ,ch.time_out) , concat(ch.date, ' ', ch.time))) ,'00:00:00') as workhour, (SELECT  sec_to_time( sum(time_to_sec(timediff(`time_out`,`time`)))) as abc FROM `checkin_master` WHERE EmployeeId=$eid and  date ='$date' and time_out != '00:00:00') as twh,  chvl.Action,chvl.CheckinId
	// 		FROM checkin_master ch,checkin_data_vtl chvl  where ch.EmployeeId=? and ch.date =?   and ch.OrganizationId=? and chvl.CheckinId=ch.id"  ,array($eid,$date,$orgid));
			
	// 		// var_dump($this->db->last_query());
	// 		return $query->result();
	// } 


		
	public function sendInvitation(){
		header('Access-Control-Allow-Origin: *'); 
		$orgid=isset($_SESSION['orgid'])?$_SESSION['orgid']:'0';
		$crn = $orgid*$orgid+99;
		$orgName=isset($_SESSION['orgName'])?$_SESSION['orgName']:'';
		$admin=getAdminName($orgid);
		$emails=isset($_REQUEST['emails'])?explode(',', $_REQUEST['emails']):'';
		//print_r($emails);
		$headers = 'From: <noreply@ubiattendance.com>' . "\r\n";
		$subject="Employee Registeration Invitation from ".$orgName;
		$i=0;
		foreach ($emails as $email){
			$message='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html>
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
			

		<title>ubiAttendance</title>
		<style type="text/css">

		@media only screen and (max-width: 600px)
		{
		 
		}

		body {
		  margin-left: 0px;
		  margin-top: 0px;
		  margin-right: 0px;
		  margin-bottom: 0px;
		-webkit-text-size-adjust:none; -ms-text-size-adjust:none;
		background: white;
		} 

		table{border-collapse: collapse;
		font-size: 1em;

		}  
		.icon-row{
		  border-bottom: 2px solid #00aad4;

		}
		?

		.icons{
		  padding: 50px;
		}
		.icons img{
		  width:100px;
		  height: auto;
		}
		.number{
		  margin-right: 10px;
		}
        p{
			font-family: Times New Roman;
		}
		</style></head>

		<body>
		<table  width="70%" align="center" style="/*border: 1px solid #e3e6e7;*/">
		  <tr>
			<td colspan="3" valign="center" >
			  <table width="100%">
				<tr>
					<td width="100%" align="center" style="text-align: center;"><a href="http://www.ubihrm.com/attendance-app/" ><img style="width: 200px;" src="http://ubitechsolutions.com/ubitechsolutions/Mailers/ubiAttendance/self_registration/logo.png"></a>
					<a href="#/"><img src="http://ubitechsolutions.com/ubitechsolutions/Mailers/ubiAttendance/self_registration/header.png" style="width: 100%;"></a>

					
					</td>

			  </tr>

			  </table>
			</td>
		  </tr>
		  
		  <tr width="100%">
			<td align="center" >
			  <table width="60%">
				<tr style="border-bottom: 1px solid grey; ">
					<td colspan="2"align="center" valign="center">
					  <p class="main-p" style="text-align: center;font-size: 20px; color: black;font-weight: bold;">
						<span class="number">1.</span>Download the App<br><br>
						<a href="https://itunes.apple.com/us/app/ubiattendance-ubitech/id1375252261?platform=iphone&preserveScrollPosition=true#platform/iphone"><img src="https://www.ubihrm.com/wp-content/uploads/2018/09/app-icon.jpg" style="width: 140px;"></a><a href="#/"><h3><b>or</b></h3></a>
						<a href="https://play.google.com/store/apps/details?id=org.ubitech.attendance&hl=en_IN">
						<img style="width: 140px;" src="https://www.ubihrm.com/wp-content/uploads/2018/09/app-get-it-on.jpg">
						</a>
					  </p>
					</td>
					

				</tr>
				<tr style="border-bottom: 1px solid grey; ">
					<td align="center" valign="center">
					  <p class="main-p" style="text-align: left;font-size: 20px; color: black;font-weight: bold;">
						<span class="number">2.</span>Go to "Sign Up" button

					  </p>
					</td>
					<td valign="center" align="center">
					  <a href="#/"><img src="http://ubitechsolutions.com/ubitechsolutions/Mailers/ubiAttendance/self_registration/5.png" style="max-width: 200px;margin-top: 30px;"></a>
					</td>

				</tr>
				<tr style="border-bottom: 1px solid grey; ">
					<td valign="center" align="center">
					  <a href="#/"><img src="http://ubitechsolutions.com/ubitechsolutions/Mailers/ubiAttendance/self_registration/4.png" style="max-width: 200px;margin-top: 30px;"></a>
					</td>
					<td align="center" valign="center">
					  <p class="main-p" style="text-align: left;font-size: 20px; color: black;font-weight: bold;">
						<span class="number">3.</span>Choose "Register employee"
						& enter CRN <span style="color: blue;">'.$crn.'</span>

					  </p>
					</td>
					

				</tr>
				<tr style="border-bottom: 1px solid grey; ">
					<td align="center" valign="center">
					  <p class="main-p" style="text-align: left;font-size: 20px; color: black;font-weight: bold;">
						<span class="number">4.</span>Fill your details to register

					  </p>
					</td>
					<td valign="center" align="center">
					  <a href="#/"><img src="http://ubitechsolutions.com/ubitechsolutions/Mailers/ubiAttendance/self_registration/2.png" style="max-width: 200px;margin-top: 30px;"></a>
					</td>

				</tr>
				<tr style="border-bottom: 1px solid grey; ">
					<td valign="center" align="center">
					  <a href="#/"><img src="http://ubitechsolutions.com/ubitechsolutions/Mailers/ubiAttendance/self_registration/1.png" style="max-width: 200px;margin-top: 30px;"></a>
					</td>
					<td align="center" valign="center">
					  <p class="main-p" style="text-align: left;font-size: 20px;color: black;font-weight: bold;">
						<span class="number">5.</span>You can now punch your attendance
					  </p>
					</td>
				</tr>
				<tr style="">
					<td align="center" valign="center" colspan="2">
					  <p class="main-p" style="text-align: center;font-size: 20px; color: black;font-weight: bold;">
						<a href="https://www.ubihrm.com/wp-content/uploads/2019/Get_started_with_ubiAttendance.pdf" style="color: blue;text-decoration: underline;">Download detailed Employee Guide</a>
					  </p>
					</td>
				</tr>
				
			  </table>
			  
			</td>
		  </tr>
		  
		  
		   <tr width="100%" >
		  <td colspan="3" align="center" style="padding-top: 20px; " >
			
			 <p style="color: grey; font-size: 16px;">Ubitech Solutions Pvt Ltd</p>
			 <p style="color: grey; font-size: 16px;">Email: <a href="mailto:ubiattendance@ubitechsolutions.com" style="text-decoration:none; color: grey;">ubiattendance@ubitechsolutions.com</a> Website:<a style="text-decoration:none;color: grey;" target="_blank" href="https://www.ubihrm.com/attendance-app">www.ubihrm.com/attendance-app</a></p>
			 <p style="color: grey; font-size: 16px;">+91-77730 00234,+971 55-5524131</p>
			 <table  align="center">
		   
		  </table>
		  <p style="color: grey;line-height: 10px; font-size: 16px;"><a href="mailto:unsubscribe@ubitechsolutions.com?subject=Unsubscribe&body=Hello%0A%0APlease%20unsubscribe%20me%20from%20the%20mailing%20list%0A%0AThanks">Unsubscribe from emails</a></p>
			 
		  </td>    
		</tr>


		  </table>

		</body>
		</html>'; 
		
			sendEmail_new($email,$subject,$message,$headers);
			$i++;
			
		}
		echo $i;
	
		
	}
	
	
	public function sendInvitation_new(){
		header('Access-Control-Allow-Origin: *'); 
		$orgid=isset($_SESSION['orgid'])?$_SESSION['orgid']:'0';
		$orgName=isset($_SESSION['orgName'])?$_SESSION['orgName']:'';
		$admin=getAdminName($orgid);
		$emails=isset($_REQUEST['emails'])?explode(',', $_REQUEST['emails']):'';
		$headers = 'From: <noreply@ubiattendance.com>' . "\r\n";
		$subject="Employee Registeration Invitation from ".$orgName;
		$i=0;
		foreach ($emails as $email)
		{
			$message='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
			<title>ubiAttendance</title>
			<style type="text/css">
			body 
			{
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
			<table  width="650" align="center" >
			  <tr>
				<td  valign="center" align="center" >
				  <a href="http://www.ubihrm.com/attendance-app/" "><img style="width: 150px;padding-top: 50px;" src="http://ubitechsolutions.com/ubitechsolutions/Mailers/ubiAttendance/Clock_time_in_with_4_easy_steps/logo.png"></a>
				</td>
			  </tr>
			   <tr>
				<td  valign="center" align="center">
				  <h1 style="font-family: Arial">
					You are invited to join ubiAttendance
				  </h1>
				</td>
			  </tr>
			  <tr>
				<td  valign="center" align="center">
				  <p style="font-family: Arial;">
					'.$admin.' from '.$orgName.' has invited you to use ubiAttendance for easy marking of Time In & Time Out from your mobile device! 
				  </p>   
				</td>
			  </tr>
			   <tr>
				<td  valign="center" align="center" style="padding-top: 50px;padding-bottom: 50px;  ">
					<a href="'.URL.'services/regInvEmp?tocken='.encode5t($orgid).'&tocken1='.encode5t($email).'" style="padding:20px 50px;font-family: Arial;background-color: #22be2a;color: white;text-decoration: none;border-radius: 5px;">Accept</a>
				</td> 
				</tr>
			<tr>
				<td  valign="center" align="center" style="padding-top: 50px; display:none">
				   <p style="font-family: Arial;color: grey;"> You may copy/paste this link into your browser:'.URL.'services/regInvEmp?tocken='.encode5t($orgid).'&tocken1='.encode5t($email).'</p>
				</td> 
			</tr>
			  </table>
			</body>
			</html>';
			sendEmail_new($email,$subject,$message,$headers);
			$i++;
		}
		echo $i;
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

public function gettimeoff($id,$date){
	 $orgid = $_SESSION['orgid'];
	  $q = "";
				  $startdate='';
					if($date != '')
						{
							$arr=explode('-', trim($date));
							$enddate= date('Y-m-d',strtotime($arr[1]));
							$startdate= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3))); 
						   $q ="AND TimeofDate BETWEEN  '$startdate' AND '$enddate' ";
						}
						else
						{
							 $enddate=date("Y-m-d");
							 $startdate=date('Y-m-d',(strtotime ( "-7 day",strtotime(date('Y-m-d'))) ));
							 $q=" AND  TimeofDate BETWEEN  '$startdate' AND '$enddate' ";
						}
	 
	 
	 $sql=$this->db->query("SELECT 	SEC_TO_TIME(sum(TIME_TO_SEC(TIMEDIFF(TimeTo,TimeFrom)))) AS stype FROM `Timeoff` WHERE ApprovalSts='2' AND OrganizationId =$orgid AND EmployeeId=$id $q  ");
	 foreach($sql->result() as $row)
	 {
		 	if($row->stype == NULL){
				$timeoff = "00:00:00";
			}else{
				$timeoff = $row->stype;
			}
			return $timeoff;
	 }
}

 public function getMonthlyPay()
 {
	 $orgid=isset($_SESSION['orgid'])?$_SESSION['orgid']:'0';
	 $query = $this->db->query("SELECT Id,FirstName,Lastname,hourly_rate FROM EmployeeMaster WHERE OrganizationId=$orgid and hourly_rate!=0");
	 $result = array();
	 $q = "";
	 
	 foreach($query->result()  as $row)
	 {
		 $data = array();
		 $data["name"] =  $row->FirstName." ".$row->Lastname;
		 $data['rate'] = $row->hourly_rate;
		 $data['total_hour'] = $this->getworkinghour($row->Id,$q);
		 $timeoff  = $this->gettimeoff($row->Id,$q);
		 $data['total_amount'] = "dummy";
		 $result[] = $data;
	 }
	 $d['data'] = $result;
	 return $d; 
 }
 
  function getweeklyoff($date,$shiftid,$emplid)
		         { 
				 // echo $date;
			        $orgid=$_SESSION['orgid'];
	                $dt=$date;
					$dayOfWeek = 1 + date('w',strtotime($dt));
					$weekOfMonth = weekOfMonth($dt);
					$week='';
					$query = $this->db->query("Select ShiftId from AttendanceMaster where AttendanceDate < '$date' AND EmployeeId = '$emplid' ORDER BY AttendanceDate DESC LIMIT 1");
					
					if($row=$query->result())
					{
						$shiftid = $row[0]->ShiftId;
					}
					else
					{
						return "N/A";
					}
					
					$query = $this->db->query("SELECT `WeekOff` FROM  `ShiftMasterChild` WHERE  `OrganizationId` =? AND  `Day` =  ? AND ShiftId=? ",array($orgid,$dayOfWeek,$shiftid));
                     $flage = false;					
					if($row=$query->result())
					{
							$week =	explode(",",$row[0]->WeekOff);
							$flage = true;
					}
					if($flage && $week[$weekOfMonth-1]==1)
					{
						return "WO";
					}
					else
					{
						// echo $dt;
						// echo "<br/>";
						$query = $this->db->query("SELECT `DateFrom`, `DateTo` FROM `HolidayMaster` WHERE OrganizationId=? and (? between `DateFrom` and `DateTo`) ",array($orgid,$dt));
						if($query->num_rows()>0)
						{
							return "H";
						}
						else
						{
							return "N/A";
						}
					}
		}
 public function updatedatabase()
    { 
	return false;
    }

 // public function getHourlyPay()
 // {
	 
	// $orgid=isset($_SESSION['orgid'])?$_SESSION['orgid']:'0';
	// $q = "";
	// $cond="";
	// $date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
	// //echo $date;
	// $shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:'';
	// $deprtid=isset($_REQUEST['deprt'])?$_REQUEST['deprt']:'';
	// $emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:'';
	
	// $desgid=isset($_REQUEST['desg'])?$_REQUEST['desg']:'';
		// if($date != '')
		// {
		// echo $date;
		// $arr=explode('-', trim($date));
		// $enddate= date('Y-m-d',strtotime($arr[1]));
		// $startdate= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3))); 
		// $q ="AND TimeofDate BETWEEN  '$startdate' AND '$enddate' ";
		// $q1=" AND  AttendanceDate BETWEEN  '$startdate' AND '$enddate' ";
		// }
		// else
		// {
			
		 // $enddate=date("Y-m-d",(strtotime ( "-1 day",strtotime(date('Y-m-d'))) ));
		
		 // $startdate= date('Y-m-d',(strtotime ( "-7 day",strtotime(date('Y-m-d'))) ));
		
		 // $q=" AND  TimeofDate BETWEEN  '$startdate' AND '$enddate' ";
		 // $q1=" AND  AttendanceDate BETWEEN  '$startdate' AND '$enddate' ";
		// }
	// if($shiftid){
		// $cond.=" AND Shift = $shiftid";
	// }if($deprtid){
		// $cond.=" AND Department = $deprtid";
	// }if($emplid){
		// $cond.=" AND E.Id = $emplid";
	// }if($desgid){
		// $cond.=" AND Designation = $desgid";
	// }
	// $query = $this->db->query("SELECT E.Id,E.FirstName,E.Lastname,A.`EmployeeId` AS EmployeeId FROM EmployeeMaster E,AttendanceMaster A WHERE A.OrganizationId=$orgid AND A.HourlyRateId!=0   AND E.Is_Delete = 0 AND A.`EmployeeId`=E.Id $cond GROUP by E.FirstName");
	
	// $result1 = array();
	// $i = 0;
	// //$q = "";
	// foreach($query->result()  as $row)
	// {
		// $sum = 0;
		// $empid =  $row->EmployeeId;
		// $query1 = $this->db->query("SELECT A.ShiftId,SEC_TO_TIME(sum(TIME_TO_SEC(TimeDiff(A.TimeOut,A.TimeIn))-(CASE WHEN(A.TimeOut>S.TimeOutBreak && A.TimeIn < S.TimeOutBreak ) THEN time_to_sec(TIMEDIFF(S.TimeOutBreak,S.TimeInBreak)) ELSE (0) END))) as totalhour, HourlyRateId From AttendanceMaster A,ShiftMaster S
		// WHERE (A.AttendanceStatus = 1 or A.AttendanceStatus = 4) 
		// and A.EmployeeId = $empid	$q1 AND A.TimeIn != '00:00:00' AND A.TimeOut != 'null' AND S.Id = A.ShiftId 
		// group by HourlyRateId");
		// $flage = true;
		// $flage1 = false;
		// $result = array();
		// foreach($query1->result()  as $row1)
		// {
			// $flage1 = true;
			// $data = array();
			// $hrid = $row1->HourlyRateId;
		 // $query2 = $this->db->query("Select SEC_TO_TIME(sum(TIME_TO_SEC(TIMEDIFF(TimeTo,TimeFrom)))) as totaltimeoff FROM `Timeoff` WHERE EmployeeId = $empid  $q AND TimeofDate in (select AttendanceDate from AttendanceMaster where (AttendanceStatus = 1 or AttendanceStatus = 4) 
		// and EmployeeId = $empid	$q1 AND HourlyRateId= $hrid) ");	
		 
		 // $timeoff="00:00:00";
		 // $c= $this->db->affected_rows($query2);
		 // $flage2 = false;
		 // foreach($query2->result()  as $row2)
		// {
			// $timeoff = $row2->totaltimeoff;
			// if($timeoff)
			// $flage2 = true;
		// }
		 // if($flage)
		  // $data["name"] =  $row->FirstName." ".$row->Lastname;
	  
	     // else
		  // $data["name"] =  "";
	 
		 // $rate = $data["rate"] = getName('HourlyRateMaster','rate','Id',$row1->HourlyRateId);
		
		 // $thour = $row1->totalhour;
		// // $timeoff = $row1->totaltimeoff;
		 // if($flage2)
		 // {
			 // $thour = $this->timetosecond($thour) - $this->timetosecond($timeoff);
			 // $thour = $this->secondtotime($thour);
			 
		 // }
		 // $data['total_hour'] = $thour;
		
		 // $data['total_amount'] = '';
		// if($rate)
		 // $data['total_amount'] = $this->payamountcal($thour,$rate);
	     // $sum = $sum+$data['total_amount'];
		 // $result[] = $data;
		 
		 // $flage = false;
		// }
		// if($flage1)
		// {
			// $result1[$i]['info'] = $result;
			// $result1[$i]['total'] = $sum;
			// $i++;
			
		// }
		
	// }
	
	// $d['data'] = $result1;
	// print_r($d['data']);
	// return $d;
	
	 
 // }
 
 
 
 
  public function getHourlyPay()
	 {
	 $orgid=$_SESSION['orgid'];
	 $deptId = isset($_REQUEST['dept'])?$_REQUEST['dept']:0;
	 $date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
	 $shiftid=isset($_REQUEST['shift'])?$_REQUEST['shift']:0;
	 $emplid=isset($_REQUEST['empl'])?$_REQUEST['empl']:0;
	 $desgid=isset($_REQUEST['desg'])?$_REQUEST['desg']:0;
	 $zname=getTimeZone($orgid);
		date_default_timezone_set ($zname);
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
					$q1.=" AND A.EmployeeId ='$emplid'";
				}
			    if($date == '')
				{
					$datestatus = isset($_REQUEST['datestatus'])?$_REQUEST['datestatus']:0;
					
					$range = "";
					if($datestatus == 7)
					{   
				       $enddate=date('Y-m-d');
				        $startdate=date('Y-m-d', strtotime('-6 day', strtotime($enddate)));
						$dat=$startdate;
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
				 
				$query = $this->db->query("SELECT A.device,E.EmployeeCode,CONCAT(E.FirstName,' ',E.LastName) as name,A.HourlyRateId,A.Id,A.EmployeeId,A.AttendanceDate as date , A.AttendanceStatus FROM AttendanceMaster A,EmployeeMaster E  WHERE   A.AttendanceDate IN ( ".$range." ) AND A.AttendanceStatus in (1,4,8) and A.OrganizationId=$orgid AND E.Id=A.EmployeeId AND E.Is_Delete = '0' and A.HourlyRateId!=0 group by A.EmployeeId");
			}
			else{
				$arr=explode('-',trim($date));
				$enddate= date('Y-m-d',strtotime($arr[1]));
				$strt= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3))); 
				$begin = new DateTime($strt);
				$dat=$strt;
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
			 if($rangedate=="")
				{
			   $rangedate = 1;
			   } 
				$query = $this->db->query("SELECT A.device,E.EmployeeCode,CONCAT(E.FirstName,' ',E.LastName) as name,A.Id,A.HourlyRateId,A.EmployeeId,A.AttendanceDate as date , A.AttendanceStatus FROM AttendanceMaster A,EmployeeMaster E  WHERE   A.AttendanceDate IN ( ".$rangedate." ) AND A.AttendanceStatus in (1,4,8) and A.OrganizationId=$orgid AND E.Id=A.EmployeeId $q1 and A.HourlyRateId!=0 group by A.EmployeeId");
				
			}
				$d=array();                      
				$res=array();
			 foreach ($query->result() as $row)
			  {	
					$data=array();
					$name = $row->name;
					if($name != "")
					{
					$data['name'] = $name;
					$data['code'] = $row->EmployeeCode;
					$data['device'] = $row->device;
					$data['date']=date("M d,Y",strtotime($dat)).'  -  '.date("M d,Y",strtotime($enddate));
					$thour=$data['total_hour']=$this->gatworkinghour($row->EmployeeId,$range);
					$rate=$data['rate']=getName('HourlyRateMaster','rate','Id',$row->HourlyRateId);
					$data['total_amount']=$this->payamountcal($thour,$rate);
					
					$data["action"]='&nbsp;&nbsp;<a href="'.URL .'Admin/viewpay/'.$row->EmployeeId.'/'.$dat.'/'.$enddate.'" style="font-size:16px" target="_self"><i class="fa fa-eye" style="font-size:16px; color:purple;" title="view"></i>';
					$res[]=$data;
					}
		     }  	
		    	 	
			$d['data']=$res;
            $this->db->close();			//$query->result();
			echo json_encode($d); return false;
		}	
		 
 
 
 
 

  public function timetosecond($str_time)
  {
     $str_time = preg_replace("/^([d]{1,2}):([d]{2})$/", "00:$1:$2", $str_time);
    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
     $time_seconds = $hours * 3600 + $minutes * 60 + $seconds; 
	 return $time_seconds;
  }
  public function secondtotime($seconds)
  {
	  $hours = floor($seconds / 3600);
      $mins = floor($seconds / 60 % 60);
      $secs = floor($seconds % 60);
	  $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
	  return $timeFormat;
  }
  public function payamountcal($str_time,$rate)
  {
	$str_time = preg_replace("/^([d]{1,2}):([d]{2})$/", "00:$1:$2", $str_time);
	sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
	$time_seconds = $hours * $rate + $minutes *$rate/60 + $seconds*$rate/(60*60); 
	return number_format((float)$time_seconds, 2, '.', '');
  }
  
  public function viewData($vid,$startdate,$enddate)
		{
			
			$res = array();
			$result = array();
			$orgid = $_SESSION['orgid'];
			//echo $orgid;
			$query= $this->db->query("SELECT CONCAT(E.FirstName,' ',E.LastName) as name,A.HourlyRateId,A.Id,A.EmployeeId,A.AttendanceDate as date ,A.TimeIn,A.TimeOut ,A.AttendanceStatus FROM AttendanceMaster A,EmployeeMaster E,ShiftMaster S  WHERE   A.AttendanceDate between '$startdate' and '$enddate' AND A.TimeIn!='null' and A.OrganizationId=$orgid AND A.EmployeeId=$vid and A.EmployeeId=E.Id and  A.HourlyRateId != 0 and A.TimeOut!='null' AND S.Id = A.ShiftId");
			$netamount = 0.00;
			$thour1 = "00:00";
			foreach($query->result() as $row)
			{
					$data = array();
					$data['name'] =$row->name;
					$data['date']= date("M d,Y",strtotime($row->date));
					$data['timein']= date('H:i',strtotime($row->TimeIn));
					$data['timeout']= date('H:i',strtotime($row->TimeOut));
					$thour=$data['total_hour']=$this->workinghour($row->EmployeeId,$row->date,$row->date);
					
					//$this->workinghour($row->EmployeeId,$row->date,$row->date);
					$rate=$data['rate']=getName('HourlyRateMaster','rate','Id',$row->HourlyRateId);
					
					$data['total_amount']=$this->payamountcal($thour,$rate);
					
					$netamount = $netamount+$this->payamountcal($thour,$rate);
					$res[] = $data;
			}
			 
			       /* $thour1=$this->workinghour($vid,$startdate,$enddate);
					$netamount = $netamount+$this->payamountcal($thour1,$rate);*/
					
				$result['data'] = $res;
				$result['net_amount']=$netamount;
				$result['total_workedhour']=$this->workinghour($vid,$startdate,$enddate);
				 return  $result; 
		}
  // public function viewData($vid,$startdate,$enddate)
		// {
			// $res = array();
			// $orgid = $_SESSION['orgid'];
			// $query= $this->db->query("SELECT SEC_TO_TIME(time_to_sec(TIMEDIFF(A.TimeOut,A.TimeIn))- CASE WHEN(A.TimeOut>S.TimeOutBreak && A.TimeIn < S.TimeOutBreak ) THEN time_to_sec(TIMEDIFF(S.TimeOutBreak,S.TimeInBreak)) ELSE 0 END) as time,CONCAT(E.FirstName,' ',E.LastName) as name,A.HourlyRateId,A.Id,A.EmployeeId,A.AttendanceDate as date ,A.TimeIn,A.TimeOut ,A.AttendanceStatus FROM AttendanceMaster A,EmployeeMaster E ,ShiftMaster S WHERE   A.AttendanceDate between '$startdate' and '$enddate' AND A.AttendanceStatus in (1,4,8) and A.OrganizationId=$orgid AND A.EmployeeId=$vid and A.EmployeeId=E.Id and  A.HourlyRateId!=0 and A.TimeOut!='00:00:00' AND S.Id = A.ShiftId");
			// foreach($query->result() as $row)
			// {
					// $data = array();
					// $data['name'] =$row->name;
					// $data['date']=date("M d,Y",strtotime($row->date));
					// $data['timein']=substr(($row->TimeIn),0,5);
					// $data['timeout']=substr(($row->TimeOut),0,5);
					// $thour=$data['total_hour']=substr(($row->time),0,5);
					// $rate=$data['rate']=getName('HourlyRateMaster','rate','Id',$row->HourlyRateId);
					// $data['total_amount']=$this->payamountcal($thour,$rate);
					// $thour1=$this->workinghour($row->EmployeeId,$startdate,$enddate);
					// $data['net_amount']=$this->payamountcal($thour1,$rate);
					// $data['total_workedhour']=$thour1;
					// $res[] = $data;
			// }
				 // return  $res; 
		// }
  
  
  public function updateuserpermission()
  {
	  $data = json_decode($_REQUEST['checked']);
	  $status = json_decode($_REQUEST['status']);
	  $desinationid = $_REQUEST['desid'];
	  $adminid = $_SESSION['id'];
	  $orgid = $_SESSION['orgid'];
	  $zname=getTimeZone($orgid);
      date_default_timezone_set ($zname);
	  $today =date('Y-m-d');
		$count =0;
	 for($i=0;$i<count($data);$i++)
	 {	
      $moduleid = $data[$i];
      $viewstatus = $status[$i];
	  if($viewstatus=='0')
	  {
	  $query = $this->db->query("UPDATE UserPermission SET ViewPermission = '0',LastModifiedById='$adminid',LastModifiedDate='$today' where RoleId = '$desinationid' AND ModuleId = '$moduleid' AND OrganizationId='$orgid'");
	  $count =1;
	  }
	 else
	 {
	   $query = $this->db->query("UPDATE UserPermission SET ViewPermission = '1',LastModifiedById='$adminid',LastModifiedDate='$today' where RoleId = '$desinationid' AND ModuleId = '$moduleid' AND OrganizationId='$orgid'");
	   $count =1;
	 }
	}
	 return $count; 
  }
  public function updateshiftchild()
  {
	  $query = $this->db->query("SELECT Id,OrganizationId from ShiftMaster");
	  foreach($query->result() as $row)
	  {
		  $sid = $row->Id;
		  $orgid = $row->OrganizationId;
		  
		  $qer = $this->db->query("SELECT ShiftId FROM ShiftMasterChild where ShiftId = '$sid' ");
		  
		  if($this->db->affected_rows()<1)
	      {
			  $query1 = $this->db->query("SELECT * from WeekOffMaster where OrganizationId = '$orgid'");
			  foreach($query1->result() as $row1)
			  {
				$day = $row1->Day;
                $weekoff = $row1->WeekOff;				
                $orgid1 = $row1->OrganizationId;				
                $ModifiedBy = $row1->ModifiedBy;				
                $ModifiedDate = $row1->ModifiedDate;				
                $Archive = $row1->Archive;
               $query2 = $this->db->query("INSERT INTO ShiftMasterChild(ShiftId, Day,WeekOff,OrganizationId, ModifiedBy,ModifiedDate,Archive) VALUES ('$sid','$day','$weekoff','$orgid1','$ModifiedBy','$ModifiedDate','$Archive')");				
			  }
		  }
	  }
	  echo $this->db->affected_rows();
  }
  
  
  public function getaattendance()
  {
	   $result1 = array();
	  $orgid = $_SESSION['orgid'];
	  /////////////get time zone
				$zname=getTimeZone($orgid);
				date_default_timezone_set ($zname);
			/////////////--/get time zone
	    $date = date("Y-m-d");
		$designations = isset($_REQUEST['desg'])?$_REQUEST['desg']:0;	
		$emplist = isset($_REQUEST['empl'])?$_REQUEST['empl']:0;	
		$department = isset($_REQUEST['deprt'])?$_REQUEST['deprt']:0;	
		$shift = isset($_REQUEST['shift'])?$_REQUEST['shift']:0;
		$q = "";
        if($designations != 0)	
		{
			$q = "AND Designation = $designations";	
		}	
      	if($shift != 0)	
		{
			$q .= "AND Shift = $shift";
		}	
		if($emplist != 0)	
				{
			$q .= "AND Id = $emplist";		
				}	
		if($department != 0)	
				{
			$q .= "AND 	Department = $department";		
				}			
	  $query = $this->db->query("SELECT Id, EmployeeCode, FirstName, LastName,Designation, Department,area_assigned,hourly_rate,Shift FROM EmployeeMaster WHERE OrganizationId = '$orgid' $q and Is_Delete = 0 AND  (DOL='0000-00-00' OR DOL>='$date') and DOJ<='$date'  and Id not in (select EmployeeId from AttendanceMaster where AttendanceDate='$date' and OrganizationId = $orgid) Order by Shift, FirstName, LastName");
	  
	  foreach($query->result() as $rows)
	  {
		    $res = array();
			$res['id'] = $rows->Id;
			$res['empcode'] = $rows->EmployeeCode;
			$res['empname'] = ucwords(strtolower($rows->FirstName." ".$rows->LastName));
			$res['timein'] = "00:00";
			$res['department'] = $rows->Department;
			$res['designations'] = $rows->Designation;
			$res['area'] = $rows->area_assigned;
			$res['hourly_rate'] = $rows->hourly_rate;
			$res['timeout'] = "00:00";
			$res['shifttimein'] = "00:00";
			$res['shifttimeout'] = "00:00";
			$res['shifttimeinbreak'] = "00:00";
			$res['shifttimeoutbreak'] = "00:00";
			$res['totaltime'] = "00:00";
			$res['overtime'] = "00:00";
			$res['sts'] = '1';
			$res['shift'] = $rows->Shift;
			$qur = $this->db->query("SELECT TimeIn, TimeOut, TimeInBreak, TimeOutBreak, TIME_FORMAT(TIMEDIFF( TIME_FORMAT(TIMEDIFF(TimeOut, TimeIn),'%H:%i'),TIME_FORMAT(TIMEDIFF(TimeOutBreak, TimeInBreak),'%H:%i')),'%H:%i') as totaltime FROM ShiftMaster WHERE Id =  $rows->Shift");
			foreach($qur->result() as $row1)
			{
				$res['totaltime'] = $row1->totaltime;
				$res['timein'] = $row1->TimeIn;
				$res['shifttimein'] = $row1->TimeIn;
				$res['shifttimeinbreak'] = $row1->TimeInBreak;
				$res['shifttimeoutbreak'] = $row1->TimeOutBreak;
				$res['timeout'] = $row1->TimeOut;
				$res['shifttimeout'] = $row1->TimeOut;
			}
			$result1[] = $res;
	  }
	    return $result1;
  }
  
   public function createattendance()
   {
	   
	    $result = array();
	    $orgid = $_SESSION['orgid'];
	    $adminid = $_SESSION['id'];
		$device = 'by admin panel';
		$attdata = isset($_REQUEST['jsonarr'])?$_REQUEST['jsonarr']:"";
		$attdata = json_decode($attdata);
		$zname=getTimeZone($orgid);
		date_default_timezone_set ($zname);
	    $date = date("Y-m-d");
		$status = 0;
		//echo json_encode($attdata[0]->timein);
		//return false;
		$count = 0;
		for($i = 0; $i< count($attdata);$i++)
		{
			$query = $this->db->query("INSERT INTO AttendanceMaster1(EmployeeId, AttendanceDate, AttendanceStatus, TimeIn, TimeOut, ShiftId, Dept_id, Desg_id, OrganizationId, CreatedDate, CreatedById, device,`HourlyRateId`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)", array($attdata[$i]->id,$date,$attdata[$i]->sts,$attdata[$i]->timein,$attdata[$i]->timeout,$attdata[$i]->shift,$attdata[$i]->department,$attdata[$i]->designations,$orgid,$date,$adminid,$device,$attdata[$i]->hourly_rate));
			$count = $count+1;
			$status = 1;
		}
		$result['count'] = $count;
		$result['status'] = $status;
		
		echo json_encode($result);
   }
  
    public function deleteTmpDeg(){
  			$orgid = $_SESSION['orgid'];
			$query=$this->db->query("DELETE FROM Temp_desig_csv WHERE OrganizationId ='$orgid'");
			if($query >0){
				return TRUE;
			}
		} 
	// created by sohan
    public function emportDeg()
	{
		  //$result1 = array();
  			$errormsg = ""; $count = ""; $success = "";
  			$user_id = $_SESSION['id'];
  			$orgid = $_SESSION['orgid'];
  			$check=true;
  			$zone=getTimeZone($orgid);
  			date_default_timezone_set($zone);
  			$date=date('Y-m-d');
  			$file_name = "newdesignation.csv";
  			$location = IMGURL."employee/$orgid/";
  			$fp = $location.$file_name;
  			$remark = "data insufficient";
  			$sts = 0;
  			$i = 0;
  			$count = 0;
  			$totalcount = 0;
  			if(($file = fopen($fp,'r')) !== FALSE)//select file //
  			 { 
  			 while(($data = fgetcsv($file,1000,",")) !== FALSE)//get the data of file//
  				{
			  $check=true;
  			  if($i>0)
  				{ 
  				$totalcount = $totalcount+1;
  				if($data[0] == "" || $data[0] == " "|| $data[0] == "'"|| $data[0] == "''"|| $data[0] == '""'|| $data[0] == "'"|| $data[0] == '"')	
  					{   
				    $data[0] = " ".$data[0];
					$sql2 = $this->db->query("INSERT INTO Temp_user_csv(Designation,OrganizationId,CreatedDate,Archive,createdBy,remark) VALUES (?,?,?,?,?,?)",array($data[0],$orgid,$date,$sts,$user_id,$remark));
					
					$result = $this->db->affected_rows();
				
					if($result >0)
						{
						$check=false;
						}
					} 
  			
  			 if($data[0] != '')
  				{ 	
  	            $query = $this->db->query("select Id FROM DesignationMaster WHERE Name =? AND OrganizationId = ? ",array(trim($data[0]),$orgid));
  				if($query->num_rows() > 0){
  				 $check=false;
  				$remark1 = "Designation already exist.";
  				$sql2 = $this->db->query("INSERT INTO Temp_user_csv(Designation,OrganizationId,CreatedDate,Archive,createdBy,remark) VALUES (?,?,?,?,?,?)",array($data[0],$orgid,$date,$sts,$user_id,$remark1));	
  			    }
  			}
 
  				
  				 if($check)
  				 {
					 $query= $this->db->query("INSERT INTO DesignationMaster(`Name`, `OrganizationId`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`,`archive`) VALUES (?,?,?,?,?,?,?)",array($data[0],$orgid,$date,$user_id,$date,$user_id,1));
  				    $count++;
					
  			     }
			  }
			   $i++;
  		  }
  		  }

		$result1 = array("repeatemp"=>$totalcount, "importemp"=>$count, "sts"=>"true");
		$check=true;
		return $result1;
		//print_r($result1);
	}
	// created by sohan
	 public function emportDep()
	 {
		   //$result1 = array();
  			$errormsg = ""; $count = ""; $success = "";
  			$user_id = $_SESSION['id'];
  			$orgid = $_SESSION['orgid'];
  			$check=true;
  			 $zone=getTimeZone($orgid);
  			date_default_timezone_set($zone);
  			$date=date('Y-m-d');
  			$file_name = "newdepartment.csv";
  			$location = IMGURL."employee/$orgid/";
  			$fp = $location.$file_name;
  			$remark = "data insufficient";
  			$sts = 0;
  			$i = 0;
  			$count = 0;
  			$totalcount = 0;
  			if(($file = fopen($fp,'r')) !== FALSE)//select file //
  			 {
  			 while(($data = fgetcsv($file,1000,",")) !== FALSE)//get the data of file//
  				{ 
				  $check=true;
  			  if($i>0)
  				{ 
  				   $totalcount = $totalcount+1;
  					if($data[0] == "" || $data[0] == " "|| $data[0] == "'"|| $data[0] == "''"|| $data[0] == '""'|| $data[0] == "'"|| $data[0] == '"')	
  					{   
				        $data[0] = " ".$data[0];
						$sql1 = $this->db->query("INSERT INTO Temp_user_csv(Department,OrganizationId,CreatedDate,Archive,createdBy,remark) VALUES (?,?,?,?,?,?)",array($data[0],$orgid,$date,$sts,$user_id,$remark));
						
						$result = $this->db->affected_rows();
					
						if($result >0)
						{
							$check=false;
						}
  			       } 
  			
  			 if($data[0] != '')
  				{ 	
  	            $query = $this->db->query("select Id FROM DepartmentMaster WHERE Name =? AND OrganizationId = ? ",array($data[0],$orgid));
  				if($query->num_rows() > 0){
  					 $check=false;
  					$remark1 = "Department already exist.";
  				$sql2 = $this->db->query("INSERT INTO Temp_user_csv(Department,OrganizationId,CreatedDate,Archive,createdBy,remark) VALUES (?,?,?,?,?,?)",array($data[0],$orgid,$date,$sts,$user_id,$remark1));	
  			
  			     }
  			  }
 
  				
  				 if($check)
  				 {
  				   $query = $this->db->query("INSERT INTO DepartmentMaster(`Name`, `OrganizationId`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`,`archive`) VALUES (?,?,?,?,?,?,?)",array($data[0],$orgid,$date,$user_id,$date,$user_id,1));
				   $count++;
  			     }
			  }
			   $i++;
  		  }
  		  }

		$result1 = array("repeatemp"=>$totalcount, "importemp"=>$count, "sts"=>"true");
		$check=true;
		return $result1;
	}
   public function getEmpotTmpDes(){
			$orgid = $_SESSION['orgid'];
			$date = date('y-m-d');
			$res = array();
			$d = array();
		$query	=$this->db->query("select CreatedDate,Designation,Department,remark FROM Temp_user_csv WHERE CreatedDate='$date' AND OrganizationId='$orgid' ");
		foreach($query->result() as $row)
		{	$data = array();
			
			$data['desg'] = $row->Designation;
			$data['deprt'] = $row->Department;			
			$data['Date'] = $row->CreatedDate;
			$data['remark'] = $row->remark;
			$res[] = $data;
		}
			$d['data'] = $res;
			echo json_encode($d);
			
		} 
  public function getemployeebyshift() {
		$result = array();
		
		$data = array();
		 $orgid=$_SESSION['orgid'];
		  $shiftid=isset($_REQUEST['shiftid'])?$_REQUEST['shiftid']:'';
		
		$sql = "SELECT Id,EmployeeCode,FirstName,LastName FROM EmployeeMaster WHERE OrganizationId =? and Shift!=? and archive=1 and Is_Delete=0 order by FirstName";
		
		$query = $this->db->query($sql,array($orgid,$shiftid ));
		
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
	
	
	
	
	
	public function SaveEmpShiftList() {
        $result = array();
        $data = array();
        $date=date('Y-m-d');
		$orgid=$_SESSION['orgid'];
		$shiftid=isset($_REQUEST['shiftid'])?$_REQUEST['shiftid']:'';
		$query12112 = $this->db->query("SELECT `Id`, `Name`, `TimeIn`, `TimeOut`, `TimeInGrace`, `TimeOutGrace`, `TimeInBreak`, `TimeOutBreak`, `OrganizationId`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `OwnerId`, `BreakInGrace`, `BreakOutGrace`, `archive`, `shifttype` FROM `ShiftMaster` WHERE  Id = '$shiftid' ");
		var_dump($this->db->last_query());
        
            $emplistarr = json_decode($_POST['emplist'], true);
           
            for($i=0; $i<count($emplistarr); $i++)
            {
                if($emplistarr[$i]['sts']==1 )
				{
					//print_r($emplistarr);
					$empid = $emplistarr[$i]['id'];
					$sql = "update EmployeeMaster set Shift=? where OrganizationId =? and Id=?";
					
					$query = $this->db->query($sql,array($shiftid ,$orgid,$empid));
					//$count=$query->rowCount();
					if ($r=$query12112->result()){
							$sname  = $r[0]->Name;
					$id =$_SESSION['id'];
           
           $module = "Settings";
           $actionperformed = " <b>".$sname."</b> shift has been assigned to <b>".ucwords(getEmpName($empid))." </b>.";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));
					}
                }
            }
          
        $result["data"] =$data;
       
        
        return $result;
    }    
  
  
  
  
  
  public function editimg()
		{   
  			$orgid =$_SESSION['orgid'];
  			$empid =  isset($_REQUEST['id'])?$_REQUEST['id']:0;
			
			$locProfile=IMGURL2."uploads/$orgid/";
			$profileE=isset($_REQUEST["profimg"])?$_REQUEST["profimg"]:"";
			$name = substr($profileE, strrpos($profileE, '/') + 1);
			$copyfile='uploads/'.$name;
			$new_name   = $empid.".jpg";
			if (!file_exists($locProfile))
			{
			mkdir($locProfile ,0777,true);
			}
			
  			
			if(file_exists($copyfile))
			{
			if(copy($copyfile,$locProfile.$new_name))
				{
					$updSts=0;
					$sql = "update EmployeeMaster set ImageName=? where OrganizationId = ? and id =?";
					$query = $this->db->query($sql,array($new_name,$orgid,$empid));
					$updSts+=$this->db->affected_rows();
					echo $query;
				}
				// var_dump($this->db->last_query());
				// var_dump($updSts);
				// var_dump($copyfile);
			}
			else
			{
					$updSts=0;
					$sql = "update EmployeeMaster set ImageName=? where OrganizationId = ? and id =?";
					$query = $this->db->query($sql,array($new_name,$orgid,$empid));
					$updSts+=$this->db->affected_rows();
					echo $query; 	
					
			}
			// var_dump($this->db->last_query());
			// var_dump($updSts);
  			// 
  		}
   
   
  
  
  
  }?>
  
  
  
  
  
