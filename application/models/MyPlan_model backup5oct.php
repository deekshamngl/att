<?php
class MyPlan_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
		include(APPPATH."PhpMailer/class.phpmailer.php");
		
    }

    function MyPlan()
	 {
		$data = array();
		$org_id=$_SESSION['orgid'];
		$CurrentDate = date('Y-m-d');
		$query = $this->db->query("SELECT `id`,`start_date`, `end_date`,`user_limit`, `adons`, `reg_users`,Addon_BulkAttn,Addon_LocationTracking,Addon_VisitPunch,Addon_GeoFence,Addon_Payroll,Addon_TimeOff,due_amount,(SELECT COUNT(Id) FROM EmployeeMaster WHERE OrganizationId =$org_id AND is_Delete != 2 ) AS totalUser,(SELECT COUNT(Id) FROM EmployeeMaster WHERE OrganizationId =$org_id and archive = 1) AS activeUser FROM `licence_ubiattendance` where `OrganizationId`=$org_id");
		
		if($row=$query->result_array())
		{
			 $data['due_amount'] =  $row[0]['due_amount'];
			 $data["Addon_TimeOffP"] = $row[0]['Addon_TimeOff'];
			 $data["Addon_PayrollP"] =  $row[0]['Addon_Payroll'];
			 $data["Addon_GeoFenceP"] =  $row[0]['Addon_GeoFence'];
			 $data["Addon_VisitPunchP"] =  $row[0]['Addon_VisitPunch'];
			 $data["Addon_LocationTrackingP"] =  $row[0]['Addon_LocationTracking'];
			 $data["Addon_BulkAttnP"] =  $row[0]['Addon_BulkAttn'];
			 $data['start_date'] =  date("j-F-Y", strtotime($row[0]['start_date'])); 
			 $data['end_date']   =date("j-F-Y", strtotime($row[0]['end_date']));
		     $data['end_date1'] = date("Y/m/d H:i:s", strtotime($row[0]['end_date']));
			 
			 //$last_date = $row11->end_date;
			 $start_date = date('Y-m-d');
			 
			 $date2=date_create($data['end_date']);
             $date1=date_create($CurrentDate);
             $diff=date_diff($date1,$date2);
             
             if($date2 > $date1)
				  $data['days'] = $diff->format("%a");
			else
				  $data['days'] = 0;
			 
			 if($start_date > $data['end_date1'])
			 {
				 $data['end_date2'] =$data['end_date1'];
				 $data['exdays']=date('Y-m-d', strtotime($data['end_date']. '+'.$data['days'].'days'));
			 }
			 else
			 {
			 $data['end_date2'] =$start_date;
			 }
			 $data['my_country'] =getCountryIdByOrg($org_id);
		     $data['user_limit'] =  $row[0]['user_limit']; 	   
		     $data['totalUser']  =  $row[0]['totalUser']; 	   
		     $data['activeUser'] =  $row[0]['activeUser'];	
			 $data['inactiveUser'] =  $row[0]['totalUser']-$row[0]['activeUser'];
			 
			/* $date2=date_create($data['end_date']);
             $date1=date_create($CurrentDate);
             $diff=date_diff($date1,$date2);
             $data['days'] = $diff->format("%a");
             $data['days'] = $data['days']>0?$data['days']:0;*/
			
          		 
		}
		
		
		$today=date('Y-m-d');
		$data['discount']['usd']='';
		
		$query = $this->db->query("SELECT  status,`plan`, `discount`,end_date,start_date FROM `attendance_discount_master` WHERE  currency ='USD' ");
		foreach($query->result() as $row)
		{	//status=1 and (CURDATE() BETWEEN `start_date` AND `end_date`) and
			 $data1=array();		     
		     $data1['plan'] =$row->plan;		     
		      if($row->status==1 && (($today >= $row->start_date) && ($today <= $row->end_date)))
				$data1['dis'] =$row->discount;     
			  else
				$data1['dis'] =0;		     
			    $data['discount']['usd'][]= $data1;
		}
		$data['discount']['inr']='';
		$query = $this->db->query("SELECT  status,`plan`, `discount`,start_date,end_date FROM `attendance_discount_master` WHERE  currency ='INR' ");
		foreach($query->result() as $row)
		{	
			 $data1=array();	
		//status=1 and (CURDATE() BETWEEN `start_date` AND `end_date`) and
		    $data1['plan'] =$row->plan;		     
			 if($row->status==1 && (($today >= $row->start_date) && ($today <= $row->end_date)))
				$data1['dis'] =$row->discount;	
			else
				$data1['dis'] =0;		          
			  $data['discount']['inr'][]= $data1;
		}
		
		$data['planinfo']['usd']='';
		$query = $this->db->query("SELECT  `range`, `monthly`, `yearly`, `bulk_attendance`,`location_tracing`,`visit_punch`,`geo_fence`,`payroll`,`time_off` FROM `Attendance_plan_master` WHERE currency='USD'");
		
		foreach($query->result() as $row)
		{	
			 $data1=array();	     
		     $data1['range'] =$row->range;		     
		     $data1['monthly'] =$row->monthly;		     
		     $data1['yearly'] =$row->yearly;		     
		     $data1['bulk_attendance'] =$row->bulk_attendance;		     
		     $data1['location_tracing'] =$row->location_tracing;	 	     
		     $data1['visit_punch'] =$row->visit_punch;		     
		     $data1['geo_fence'] =$row->geo_fence;		     
		     $data1['payroll'] =$row->payroll;		     
		     $data1['time_off'] =$row->time_off;		     
			 $data['planinfo']['usd'][]= $data1;
		}
		$data['planinfo']['inr']='';
		$query = $this->db->query("SELECT  `range`, `monthly`, `yearly`, `bulk_attendance`,`location_tracing`,`visit_punch`,`geo_fence`,`payroll`,`time_off` FROM `Attendance_plan_master` WHERE currency='INR'");
		foreach($query->result() as $row)
		{	
			 $data1=array();	     
		     $data1['range'] =$row->range;		     
		     $data1['monthly'] =$row->monthly;		     
		     $data1['yearly'] =$row->yearly;  
			 $data1['bulk_attendance'] =$row->bulk_attendance;		     
		     $data1['location_tracing'] =$row->location_tracing;		     
		     $data1['visit_punch'] =$row->visit_punch;		     
		     $data1['geo_fence'] =$row->geo_fence;		     
		     $data1['payroll'] =$row->payroll;		     
		     $data1['time_off'] =$row->time_off;			     
			 $data['planinfo']['inr'][]= $data1;
		}
		
		
		
		$query = $this->db->query("SELECT Name,Email,PhoneNumber,City,(SELECT  name FROM admin_login where OrganizationId =$org_id limit 1) as cname FROM Organization where id =$org_id ");
			$row = $query->row();
			$num = $query->num_rows();
			if($num > 0)
			{
			 $data['oname']=$row->Name;	
			 $data['cname']=$row->cname;	
			 $data['oemail']=$row->Email;	
			 $data['ophone']=$row->PhoneNumber;	
			 $data['state']=$row->City;	
			}
			$query = $this->db->query("SELECT * FROM state_gst ORDER BY name");
			$states=array();
			$codes=array();
			foreach ($query->result() as $row)
				{
					$states['name'][]=$row->name;
					$codes['code'][]=$row->code;
				}
				$data['states']=$states;
				$data['codes']=$codes;
				
			$query11 = $this->db->query("SELECT * FROM CountryMaster ORDER BY Name");
			$country=array();
			$countrycodes=array();
			foreach ($query11->result() as $row)
				{
					$country['Name'][]=$row->Name;
					$countrycodes['countrycodes'][]=$row->countrycode;
				}
				$data['country']=$country;
				$data['countrycodes']=$countrycodes;
	
		return $data;
	}
    
	
	
	function Balancedues()
	{
		echo 'ok';
	}
	
	
	
	
	
	
    function PaymentSuccess(){
			$status=isset($_REQUEST["status"])?$_REQUEST["status"]:0;
			$firstname=isset($_REQUEST["firstname"])?$_REQUEST["firstname"]:'0';
			$amount=isset($_REQUEST["amount"])?$_REQUEST["amount"]:'0';
			$txnid=isset($_REQUEST["txnid"])?$_REQUEST["txnid"]:'0';
			$posted_hash=isset($_REQUEST["hash"])?$_REQUEST["hash"]:'0';
			$key=isset($_REQUEST["key"])?$_REQUEST["key"]:'0';
			$productinfo=isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"]:'0';
			$email=isset($_REQUEST["email"])?$_REQUEST["email"]:'0';
			$salt="e5iIg1jwi8";  // test
		//	$salt="AlGt0f59fS";  // live
			$org_id		= 	$_SESSION['orgid'];
			$cur		= 	$_SESSION['paid_in'];
			$plan_users	= 	$_SESSION['plan_users'];
			$package	= 	$_SESSION['package'];
			$plan		=	$_SESSION['plan'];
			$addon_users=	$_SESSION['addon_users'];
			$addon_amt	=	$_SESSION['addon_amt'];
			$discount_amt=	$_SESSION['discount_amt'];
			$tax		=	$_SESSION['tax'];
			$gstin		=	$_SESSION['gstin'];			
			$country	=	$_SESSION['country'];
			$state		=	$_SESSION['state'];
			$street		=	str_replace("'","",$_SESSION['street']);
			$city		=	$_SESSION['city'];
			$zip		=	$_SESSION['zip'];
			$individual	=	str_replace("'","",$_SESSION['individual']);
			$contact	=	$_SESSION['contact'];
			$data		=	array();
			$data['email']=$email; 
			$data['status']=0; // false
			$data['amount']=$amount;
			$data['firstname']=str_replace("'","",$firstname);
			$data['txnid']=$txnid;
			$data['country']=$country;
			$data['state']=$state;
			$data['street']=str_replace("'","",$street);
			$data['city']=str_replace("'","",$city);
			$data['zip']=str_replace("'","",$zip);
			$data['contact']=str_replace("'","",$contact);
			$data['tax']=$tax;
			$data['discount_amt']=$discount_amt;
			$data['cur']=$cur;
			$data['plan_users']=$plan_users;
			$data['package']=$package;
			$data['plan']=$plan;
			$data['addon_users']=$addon_users;
			$data['addon_amt']=$addon_amt;
			$data['gstin']=str_replace("'","",$gstin);
			$data['email']=$email;
////////////////////////////////////
		If (isset($_REQUEST["additionalCharges"])) {
		   $additionalCharges=$_REQUEST["additionalCharges"];
			$retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
			}
		else {	  
			$retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
			 }
			 $hash = hash("sha512", $retHashSeq);
		   if ($hash != $posted_hash)
			   $data['status']=-1;
		   else{
////////////////////////////////////	
 $tusers=$plan_users + $addon_users;
//echo "update licence_ubiattendance set user_limit = $tusers ,`end_date` = DATE_ADD(`end_date`, INTERVAL $plan MONTH),extended =extended +1,transaction_id='".$txnid."' ,status=1,  where OrganizationId = $org_id";
//return;
				$query1 = $this->db->query("select id from licence_ubiattendance where transaction_id = '$txnid' ");
				if($query1->num_rows() > 0)
						return $data; // txn id already exist
				$query = $this->db->query("update licence_ubiattendance set user_limit = $tusers , `end_date` = DATE_ADD(`end_date`, INTERVAL $plan MONTH),extended =extended +1,transaction_id='".$txnid."' ,status=1  where OrganizationId = $org_id");
				if($query){
					$date=date('Y-m-d');
					$query1 = $this->db->query("INSERT INTO `payments_invoice`(`txnid`,OrganizationId, `name`, `email`, `payment_amount`, `payment_status`, `createDate`, `tax`, `discount`, `currency`, `country`, `state`, `city`, `street`, `contact`, `zip`, `indivisual_name`,gstin) VALUES ('$txnid',$org_id,'$firstname','$email',$amount,'$status','$date',$tax,$discount_amt,'$cur','$country','$state','$city','$street','$contact','$city','$individual','$gstin')");
				//	if($query1->num_rows() > 0){
				///		  $data['status']=1;
				//	}
					
					$query1 = $this->db->query("select Email from Organization where Id = $org_id");
					if($query1->num_rows() > 0)
					{
						$row = $query1->row();
						$to = $row->Email;
						$subject = "Payment for ubiAttendance is successful";
						$txt = "Thanks for buying ubiAttendance Premium Plan";
						$headers = "From: sales@ubitechsolutions.com" . "\r\n" .
						 "CC: vijay@ubitechsolutions.com";
						mail($to,$subject,$txt,$headers);
					}
					 $data['status']=1; // true
				}
				else
				{
					$data['status']=2; // payment done but didnt update in our system
				}
		   }
		   
		   return $data;
	} 	
	
	
	function PaymentSuccesspaypal(){
		   
	//echo  $endate=isset($_REQUEST["endate"])?$_REQUEST["endate"]:'0';
//	return false;
	 $ind_name='';
	 $amount='0';
	 $discount='0';
	 $duration='0';
	 $plan='';
	 $country='';
	 $street='';
	 $city='';
	 $zip= '';
	 $nofuser=''; 
	 $contact='';
	 $currency= '0';
	 $tax= '0';
	 $gstin='0';
	 $state= '';
	 $msg='';
	 
	 
	 $bulk_att='';
	 $loc_trace='';
	 $visit_punch='';
	 $geo_fence='';
	 $payroll='';
	 $timeoff='';
	 $bulk_attsts='';
	 $loc_tracests='';
	 $visit_punchsts='';
	 $geo_fencests='';
	 $payrollsts='';
	 $timeoffsts='';
	 
	if(isset($_REQUEST['productinfo'])){ // payUMoney
	 $_REQUEST['productinfo']=json_decode($_REQUEST['productinfo']);
	 //print_r(base64_decode($_REQUEST['productinfo'][0]->duration));
	 $ind_name=isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->ind_name:'0';
	 $amount=isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->total):'0';
	 $discount=isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->discount):'0';
	 $duration=isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->duration):'0';
	 $plan=isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->plan:'0';
	 $country=isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->country):'0';
	 $street=isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->street):'0';
	 $city=isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->city):'0';
	 $zip= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->zip:'0';
	 $nofuser=isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->noofusers:'0'; 
	 $contact= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->contact:'0';
	 $currency= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->currency:'0';
	 $tax= isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->taxforinr):'0';
	 $gstin= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->gstin:'0';
	 $state= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->state:'';
	 
	 $bulk_att= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->bulk_attendance:'0';
	 $visit_punch= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->visit_punch:'0';
	 $loc_trace= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->loc_sharing:'0';
	 $geo_fence= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->geo_fence:'0';
	 $payroll= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->payroll:'0';
	 $timeoff= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->timeoff:'0';
	 $bulk_attsts= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->stsbulk_attendance:'0';
	 $visit_punchsts= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->stsvisit_punch:'0';
	 $loc_tracests= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->stsloc_trace:'0';
	 $geo_fencests= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->stsgeo_fence:'0';
	 $payrollsts= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->stspayroll:'0';
	 $timeoffsts= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->ststimeoff:'0';
	 $msg='Payment recieved via auto mode-payUMoney (admin)';
	}
	else{							// payPal
	 $ind_name=isset($_REQUEST["ind_name"])?$_REQUEST["ind_name"]:'0';
	 $amount=isset($_REQUEST["total"])?base64_decode($_REQUEST["total"]):'0';
	 $discount=isset($_REQUEST["discount"])?base64_decode($_REQUEST["discount"]):'0';
	 $duration=isset($_REQUEST["duration"])?base64_decode($_REQUEST["duration"]):'0';
	 $plan=isset($_REQUEST["plan"])?$_REQUEST["plan"]:'0';
	
	 $country=isset($_REQUEST["country"])?base64_decode($_REQUEST["country"]):'0';
	 $street=isset($_REQUEST["street"])?base64_decode($_REQUEST["street"]):'0';
	 $city=isset($_REQUEST["city"])?base64_decode($_REQUEST["city"]):'0';
	 $zip= isset($_REQUEST["zip"])?$_REQUEST["zip"]:'0';
	 $nofuser=isset($_REQUEST["noofusers"])?$_REQUEST["noofusers"]:'0'; 
	 $contact= isset($_REQUEST["contact"])?$_REQUEST["contact"]:'0';
	 $currency= isset($_REQUEST["currency"])?$_REQUEST["currency"]:'0';
	 $tax= isset($_REQUEST["taxforinr"])?base64_decode($_REQUEST["taxforinr"]):'0';
	 $gstin= isset($_REQUEST["gstin"])?$_REQUEST["gstin"]:'0';
	 $state= isset($_REQUEST["state"])?$_REQUEST["state"]:'';
	 $msg='Payment recieved via auto mode-payPal (My Plan)';
	 $bulk_att= isset($_REQUEST["bulk_attendance"])?$_REQUEST["bulk_attendance"]:'0';
	 $visit_punch= isset($_REQUEST["visit_punch"])?$_REQUEST["visit_punch"]:'0';
	 $loc_trace= isset($_REQUEST["loc_trace"])?$_REQUEST["loc_trace"]:'0';
	 $geo_fence= isset($_REQUEST["geo_fence"])?$_REQUEST["geo_fence"]:'0';
	 $payroll= isset($_REQUEST["payroll"])?$_REQUEST["payroll"]:'0';
	 $timeoff= isset($_REQUEST["timeoff"])?$_REQUEST["timeoff"]:'0';
	 $bulk_attsts= isset($_REQUEST["bulk_attsts"])?$_REQUEST["bulk_attsts"]:'0';
	 $visit_punchsts= isset($_REQUEST["visit_punchsts"])?$_REQUEST["visit_punchsts"]:'0';
	 $loc_tracests= isset($_REQUEST["loc_tracests"])?$_REQUEST["loc_tracests"]:'0';
	 $geo_fencests= isset($_REQUEST["geo_fencests"])?$_REQUEST["geo_fencests"]:'0';
	 $payrollsts= isset($_REQUEST["payrollsts"])?$_REQUEST["payrollsts"]:'0';
	 $timeoffsts= isset($_REQUEST["timeoffsts"])?$_REQUEST["timeoffsts"]:'0';
	 
	}
	 
	 $org_id	= 	$_SESSION['orgid'];
	 $Company=getOrgName($org_id);
	 $zone=getTimeZone($org_id);
	 date_default_timezone_set($zone);
	 $today=date('Y-m-d');	
	 $amount=$amount-$tax;
	 $data		=	array();
	 $email=getAdminEmail($org_id);
	 $txnid=$org_id.''.'';
	 $id=0;
	 $plan_enddate='';
	 if(!isset($_SESSION['txnd'])){
		 $query = $this->db->query("SELECT max(id)as id FROM `payments_invoice`");
		 if($row=$query->result())
			$id=$row[0]->id;
		 $txnid=$org_id.''.$id;	
		 $_SESSION['txnd']=$txnid;
	 }else
		 $txnid=$_SESSION['txnd'];
	 
		// echo $duration;
	 if($plan=='YEARLY')
		  $duration=$duration * 12; // if plan is yearly, it should be convert in months
	 
	 $query = $this->db->query("SELECT `end_date`  FROM `licence_ubiattendance` WHERE `OrganizationId`='$org_id' limit 1");
	 if($row=$query->result())
		 $plan_enddate= $row[0]->end_date;
	if($plan_enddate < $today)
			 $plan_enddate=$today;
	$st_date = $plan_enddate;	 
	  $plan_enddate = date('Y-m-d', strtotime("+".$duration." months", strtotime($plan_enddate)));
	  
	$narration='Plan Period: '.date('d/m/Y',strtotime($st_date)).' - '.date('d/m/Y',strtotime($plan_enddate)).'<br/>No. of Users: '.$nofuser;
	////////////////////////////////////
			$data['email']=$email; 
			$data['txnid']=$txnid; 
			$data['status']='SUCCESS'; // true
			$data['amount']=$amount; 
			$data['firstname']=$ind_name;
			$data['country']=$country;
			$data['state']=$state;
			$data['street']=str_replace("'","",$street);
			$data['city']=str_replace("'","",$city);
			$data['zip']=str_replace("'","",$zip);
			$data['contact']=str_replace("'","",$contact);
			$data['tax']=$tax;
			$data['discount_amt']=$discount;
		    $data['cur']=$currency;
	////////////////////////////////////
	
	
	 $query = $this->db->query("SELECT id FROM `payments_invoice` WHERE `txnid`='$txnid'");
	 if($query->num_rows()>0)
	 {		
			return $data;
			return false; ///// transaction information already inserted
	 }
	
	/////////////********************************
//	echo "INSERT INTO `payments_invoice`( `txnid`, `OrganizationId`, `name`, `email`, `payment_amount`, `payment_status`, `createDate`, `tax`, `discount`, `currency`, `country`, `state`, `city`, `street`, `contact`, `zip`, `indivisual_name`, `gstin`, `remark`, `action`) VALUES ('$txnid','$org_id','$Company','$email','$amount','SUCCESS','$today','$tax','$discount','$currency','$country','$state','$city','$street','$contact','$zip','$ind_name','$gstin','$msg','BUY')";
	//echo "<br/>";
//	echo "update licence_ubiattendance set user_limit = '$nofuser' , `end_date` = '$plan_enddate',extended =extended +1,transaction_id='".$txnid."' ,status=1  where OrganizationId = $org_id";
	
//	return false;
	/////////////********************************

	 $query = $this->db->query("INSERT INTO `payments_invoice`( `txnid`, `OrganizationId`, `name`, `email`, `payment_amount`, `payment_status`, `createDate`, `tax`, `discount`, `currency`, `country`, `state`, `city`, `street`, `contact`, `zip`, `indivisual_name`, `gstin`, `remark`,  `narration`, `action`, `Addon_BulkAttn`, `Addon_LocationTracking`, `Addon_VisitPunch`, `Addon_GeoFence`, `Addon_Payroll`, `Addon_TimeOff`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($txnid,$org_id,$Company,$email,$amount,'SUCCESS',$today,$tax,$discount,$currency,$country,$state,$city,$street,$contact,$zip,$ind_name,$gstin,$msg,$narration,'BUY',$bulk_att,$loc_trace,$visit_punch,$geo_fence,$payroll,$timeoff));
	//	if($this->db->affected_rows()>0){
			// updating licence_ubiattendance
			$ragisteruser = countRegisteredEmployee($org_id);
		
			$due_amount = 0;
			
			if($ragisteruser > $nofuser)
			{
				$due_amount =  ((int)$amount/(int)$nofuser)*($ragisteruser - $nofuser);
			}
			$query = $this->db->query("update licence_ubiattendance set user_limit = $nofuser , `end_date` = '$plan_enddate',extended =extended +1,transaction_id='".$txnid."' ,status=1, due_amount =  '$due_amount', Addon_BulkAttn='".$bulk_attsts."', Addon_LocationTracking='".$loc_tracests."', Addon_VisitPunch='".$visit_punchsts."', Addon_GeoFence='".$geo_fencests."', Addon_Payroll='".$payrollsts."', Addon_TimeOff='".$timeoffsts."' where OrganizationId = $org_id");
			
				//due_amount
			$query3 = $this->db->query("update Organization set NoOfEmp = $nofuser  where Id = $org_id");
			/* $query4 = $this->db->query("update admin_login set web_admin_login_sts = 1  where OrganizationId = $org_id"); */
	//	}
			// txn id already exist
						$_SESSION['p_status']=1;
						$subject = $Company." - ubiAttendance Payment.";
						$txt = "<html><body>Dear super admin<br/>,
							". $Company." has paid amount ".$currency." ".$amount." to upgrade ubiAttendance premium plan. <br/><br/>
							<b>Payment summary:</b> <br/><br/>
							Email ID: 	".$email." <br/>
							Transaction Id: ".$txnid." <br/>
							Amount paid: ".$currency." ".($amount+$tax)." (tax included) <br/>
							Taxes paid:    ".$currency." ".$tax." <br/>
							Discount:    ".$currency." ".$discount." <br/>
							No. of users extended: ".$nofuser." <br/>
							Plan periods extends: ".$duration." month(s) <br/><br/>
							Thanks for buying ubiAttendance services.<br/><br/>
							To generate the Invoice <a href='".URL."cron/generateInvoice?id=".base64_encode($txnid)."' target='_blank'> Click here</a>.<br/><br/>
							Regards<br/>
							Team ubiAttendance</body></html>";
						$txtuser = "<html><body>Dear ". $Company."<br/><br/>
							You have paid amount ".$currency." ".$amount." to upgrade ubiAttendance Premium Plan. <br/><br/>
							<b>Payment summary:</b> <br/><br/>
							Email ID: 	".$email." <br/>
							Transaction Id: ".$txnid." <br/>
							Amount paid: ".$currency." ".($amount+$tax)." (tax included) <br/>
							Tax paid:    ".$currency." ".$tax." <br/>
							Discount:    ".$currency." ".$discount." <br/>
							No. of users extended: ".$nofuser." <br/>
							Plan periods extends: ".$duration." month(s) <br/><br/>
							Thanks for buy ubiAttendance services.<br/><br/>
							TO generate the Invoice <a href='".URL."cron/generateInvoice?id=".base64_encode($txnid)."' target='_blank'> Click here</a>.<br/><br/>
							Regards<br/>
							Team ubiAttendance</body></html>";
							
						$headers = "From: sales@ubitechsolutions.com" . "\r\n" .
						 "CC: pragati@ubitechsolutions.com";
						sendEmail_new("sohan@ubitechsolutions.com",$subject,$txt,$headers);
						sendEmail_new("ubiattendance@ubitechsolutions.com",$subject,$txt,$headers);
						sendEmail_new("accounts@ubitechsolutions.com",$subject,$txt,$headers);
						sendEmail_new($email,$subject,$txtuser,$headers);
			
					//	$txt = "Thanks for buy the ubiAttendance subscription.<br/><br/>To generate the Invoice <a href='".URL."cron/generateInvoice?id=".base64_encode($txnid)."' target='_blank'> Click here</a>.<br/><br/>";
						//$headers = "From: sales@ubitechsolutions.com" . "\r\n" ."CC: pragati@ubitechsolutions.com";
					//	sendEmail_new("vijay@ubitechsolutions.com",$subject,$txt);
					//	sendEmail_new($email,$subject,$txt);
		   return $data; 
	}
	
	function UpgradePlan_Successpaypal(){
	 $ind_name='';
	 $amount='0';
	 $discount='0';
	 $duration='0';
	 $plan='';
	 $country='';
	 $street='';
	 $city='';
	 $zip= '';
	 $nofuser=''; 
	 $contact='';
	 $currency= '0';
	 $tax= '0';
	 $gstin='0';
	 $state= '';
	 $msg='';
	 $paymentmthd = '';
	 $action='';
      
	 $bulk_att='';
	 $loc_trace='';
	 $visit_punch='';
	 $geo_fence='';
	 $payroll='';
	 $timeoff='';
	 $bulk_attsts='';
	 $loc_tracests='';
	 $geo_fencests='';
	 $visit_punchsts='';
	 $payrollsts='';
	 $timeoffsts='';
	 $due_amount = '0.0';

	if(isset($_REQUEST['productinfo'])){ // payUMoney
	 $_REQUEST['productinfo']=json_decode($_REQUEST['productinfo']);
	 $action=isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->action:'0';
	 $ind_name=isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->ind_name:'0';
	 $amount=isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->total):'0';
	 $discount=isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->discount):'0';
	 $duration=isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->duration):'0';
	 $plan=isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->plan:'0';
	
	 $country=isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->country):'0';
	 $street=isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->street):'0';
	 $city=isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->city):'0';
	 $zip= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->zip:'0';
	 $nofuser=isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->noofusers:'0'; 
	 $contact= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->contact:'0';
	 $currency= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->currency:'0';
	 $tax= isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->taxforinr):'0';
	 $gstin= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->gstin:'0';
	 $state= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->state:'';
	  $bulk_att= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->bulk_attpriceP:'0';
	 $visit_punch= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->visit_punchpriceP:'0';
	 $loc_trace= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->location_tracepriceP:'0';
	 $geo_fence= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->geo_fencepriceP:'0';
	 $payroll= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->payroll_priceP:'0';
	 $timeoff= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->timeoff_priceP:'0';
	 $bulk_attsts= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->stsbulk_attendance:'0';
	 $visit_punchsts= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->stsvisit_punch:'0';
	 $loc_tracests= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->stsloc_trace:'0';
	 $geo_fencests= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->stsgeo_fence:'0';
	 $payrollsts= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->stspayroll:'0';
	 $timeoffsts= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->ststimeoff:'0';
	 $due_amount= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->dueamount:'0';
	 
	 
	 $msg='Payment recieved via auto mode-payUMoney (admin)';
	 $paymentmthd = 'Payumoney';
	 
	 
	}else{
	 $action=isset($_REQUEST["action"])?$_REQUEST["action"]:''; // UO/DO/UD users lim only/duration only/user lim and duration both
	 $ind_name=isset($_REQUEST["ind_name"])?$_REQUEST["ind_name"]:'0';
	 $amount=isset($_REQUEST["total"])?base64_decode($_REQUEST["total"]):'0';
	 $discount=isset($_REQUEST["discount"])?base64_decode($_REQUEST["discount"]):'0';
	 $duration=isset($_REQUEST["duration"])?base64_decode($_REQUEST["duration"]):'0';
	 $plan=isset($_REQUEST["plan"])?$_REQUEST["plan"]:'0';
	 $country=isset($_REQUEST["country"])?base64_decode($_REQUEST["country"]):'0';
	 $street=isset($_REQUEST["street"])?base64_decode($_REQUEST["street"]):'0';
	 $city=isset($_REQUEST["city"])?base64_decode($_REQUEST["city"]):'0';
	 $zip= isset($_REQUEST["zip"])?$_REQUEST["zip"]:'0';
	 $nofuser=isset($_REQUEST["noofusers"])?$_REQUEST["noofusers"]:'0'; 
	 $contact= isset($_REQUEST["contact"])?$_REQUEST["contact"]:'0';
	 $currency= isset($_REQUEST["currency"])?$_REQUEST["currency"]:'0';
	 $tax= isset($_REQUEST["taxforinr"])?base64_decode($_REQUEST["taxforinr"]):'0';
	 $gstin= isset($_REQUEST["gstin"])?$_REQUEST["gstin"]:'0';
	 $state= isset($_REQUEST["state"])?$_REQUEST["state"]:'';
	 
	 $bulk_att= isset($_REQUEST["bulk_attendance"])?$_REQUEST["bulk_attendance"]:'0';
	 $visit_punch= isset($_REQUEST["visit_punch"])?$_REQUEST["visit_punch"]:'0';
	 $loc_trace= isset($_REQUEST["loc_trace"])?$_REQUEST["loc_trace"]:'0';
	 $geo_fence= isset($_REQUEST["geo_fence"])?$_REQUEST["geo_fence"]:'0';
	 $payroll= isset($_REQUEST["payroll"])?$_REQUEST["payroll"]:'0';
	 $timeoff= isset($_REQUEST["timeoff"])?$_REQUEST["timeoff"]:'0';
	 $bulk_attsts= isset($_REQUEST["bulk_attsts"])?$_REQUEST["bulk_attsts"]:'0';
	 $visit_punchsts= isset($_REQUEST["visit_punchsts"])?$_REQUEST["visit_punchsts"]:'0';
	 $loc_tracests= isset($_REQUEST["loc_tracests"])?$_REQUEST["loc_tracests"]:'0';
	 $geo_fencests= isset($_REQUEST["geo_fencests"])?$_REQUEST["geo_fencests"]:'0';
	 $payrollsts= isset($_REQUEST["payrollsts"])?$_REQUEST["payrollsts"]:'0';
	 $timeoffsts= isset($_REQUEST["timeoffsts"])?$_REQUEST["timeoffsts"]:'0';
	 
	 $msg='Payment recieved via auto mode-payPal (My Plan)';
	 $paymentmthd = 'Paypal';
	 
	 
	 
	}
	
	
	 $org_id	= 	$_SESSION['orgid'];
	 $Company=getOrgName($org_id);
	 $zone=getTimeZone($org_id);
	 date_default_timezone_set($zone);
	 $today=date('Y-m-d');	
	 $amount=$amount-$tax;
	 $data		=	array();
	 $email=getAdminEmail($org_id);
	 $txnid=$org_id.''.'';
	 $id=0;
	 $plan_enddate='';
	$ulimit = getName('Organization', 'NoOfEmp', 'Id', $org_id);
	$ulimit = $nofuser+$ulimit;
	/* 		$subject = $Company." -ubiAttendance Payment.";
			$txt = "<html><body>Dear super admin<br/>,
				". $Company." has paid amount ".$currency." ".$amount." for upgradation of its ubiAttendance subscription. <br/><br/>
				<strong> Payment summary: </strong> <br/><br/>
				email ID: 	".$email." <br/>
				Amount paid: ".$currency." ".$amount." (tax included) <br/>
				Tax paid:    ".$currency." ".$tax." <br/>
				Discount:    ".$currency." ".$discount." <br/>
				No. of users extended: ".$nofuser." <br/>
				Subscription periods extends: ".$duration." month(s)<br/><br/>

				Thanks for buy ubiAttendance services.<br/><br/>

				Regards<br/>
				Team ubiAttendance</body></html>";
			$headers = "From: sales@ubitechsolutions.com" . "\r\n" .
			 "CC: pragati@ubitechsolutions.com";
			sendEmail_new("vijay@ubitechsolutions.com",$subject,$txt,$headers);
	*/
	 if(!isset($_SESSION['txnd'])){
		 $query = $this->db->query("SELECT max(id)as id FROM `payments_invoice`");
		 if($row=$query->result())
			$id=$row[0]->id;
		 $txnid=$org_id.''.$id;	
		 $_SESSION['txnd']=$txnid;
	 }else
		 $txnid=$_SESSION['txnd'];
	 
		 
	 if($plan=='YEARLY')
		 $duration=$duration * 12; // if plan is yearly, it should be convert in months
	 
	 $query = $this->db->query("SELECT `end_date`  FROM `licence_ubiattendance` WHERE `OrganizationId`='$org_id' limit 1");
	 if($row=$query->result())
		$plan_enddate= $row[0]->end_date;
	if($plan_enddate < $today)
			 $plan_enddate=$today;
	$st_date = $plan_enddate;
		 
	 $plan_enddate = date('Y-m-d', strtotime("+".$duration." months", strtotime($plan_enddate)));
	////////////////////////////////////
			$data['email']=$email; 
			$data['txnid']=$txnid; 
			$data['status']='SUCCESS'; // true
			$data['amount']=$amount; 
			$data['firstname']=$ind_name;
			$data['country']=$country;
			$data['state']=$state;
			$data['street']=str_replace("'","",$street);
			$data['city']=str_replace("'","",$city);
			$data['zip']=str_replace("'","",$zip);
			$data['contact']=str_replace("'","",$contact);
			$data['tax']=$tax;
			$data['discount_amt']=$discount;
		    $data['cur']=$currency;
	////////////////////////////////////
	
	 $query = $this->db->query("SELECT id FROM `payments_invoice` WHERE `txnid`='$txnid'");
	 if($query->num_rows()>0)
	 {	
			return $data;
			return false; ///// transaction information already inserted
	 }
	 
		if($action=='DO'){
		 $query = $this->db->query("INSERT INTO `payments_invoice`( `txnid`, `OrganizationId`, `name`, `email`, `payment_amount`, `payment_status`, `createDate`, `tax`, `discount`, `currency`, `country`, `state`, `city`, `street`, `contact`, `zip`, `indivisual_name`, `gstin`,`payment_method`, `remark`, `narration`, `action`,`Addon_BulkAttn`, `Addon_LocationTracking`, `Addon_VisitPunch`, `Addon_GeoFence`, `Addon_Payroll`, `Addon_TimeOff`,due_payment) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($txnid,$org_id,$Company,$email,$amount,'SUCCESS',$today,$tax,$discount,$currency,$country,$state,$city,$street,$contact,$zip,$ind_name,$gstin,$paymentmthd,'Update Plan duration for '.$duration.' months. '.$msg, 'Plan Period: '.date('d/m/Y',strtotime($st_date)).' - '.date('d/m/Y',strtotime($plan_enddate)).' <br/>','UPGRADE',$bulk_att,$loc_trace,$visit_punch,$geo_fence,$payroll,$timeoff,$due_amount));
				// updating licence_ubiattendance
		$query = $this->db->query("update licence_ubiattendance set `end_date` = '$plan_enddate',extended =extended +1,transaction_id='".$txnid."' ,status=1 ,Addon_BulkAttn='".$bulk_attsts."', Addon_LocationTracking='".$loc_tracests."', Addon_VisitPunch='".$visit_punchsts."', Addon_GeoFence='".$geo_fencests."', Addon_Payroll='".$payrollsts."', Addon_TimeOff='".$timeoffsts."',due_amount = (due_amount-".$due_amount.")  where OrganizationId = $org_id");
				
		}else if($action=='UO'){ 
			$query = $this->db->query("INSERT INTO `payments_invoice`( `txnid`, `OrganizationId`, `name`, `email`, `payment_amount`, `payment_status`, `createDate`, `tax`, `discount`, `currency`, `country`, `state`, `city`, `street`, `contact`, `zip`, `indivisual_name`, `gstin`,`payment_method`, `remark`, `narration`, `action`,`Addon_BulkAttn`, `Addon_LocationTracking`, `Addon_VisitPunch`, `Addon_GeoFence`, `Addon_Payroll`, `Addon_TimeOff`,due_payment) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($txnid,$org_id,$Company,$email,$amount,'SUCCESS',$today,$tax,$discount,$currency,$country,$state,$city,$street,$contact,$zip,$ind_name,$gstin,$paymentmthd,'Update user limit for '.$ulimit.' users. '.$msg,'Plan Period: '.date('d/m/Y',strtotime($today)).' - '.date('d/m/Y',strtotime($plan_enddate)).' <br/>No. of Users: '.$nofuser,'UPGRADE',$bulk_att,$loc_trace,$visit_punch,$geo_fence,$payroll,$timeoff,$due_amount));
				// updating licence_ubiattendance
		$query = $this->db->query("update licence_ubiattendance set user_limit = user_limit + $nofuser ,extended =extended +1,transaction_id='".$txnid."' ,status=1 ,Addon_BulkAttn='".$bulk_attsts."', Addon_LocationTracking='".$loc_tracests."', Addon_VisitPunch='".$visit_punchsts."', Addon_GeoFence='".$geo_fencests."', Addon_Payroll='".$payrollsts."', Addon_TimeOff='".$timeoffsts."' ,due_amount = (due_amount-".$due_amount.") where OrganizationId = $org_id");
		$query3 = $this->db->query("update Organization set NoOfEmp = NoOfEmp + $nofuser  where Id = $org_id");
		}
		else if($action=='UD'){ 
			$query = $this->db->query("INSERT INTO `payments_invoice`( `txnid`, `OrganizationId`, `name`, `email`, `payment_amount`, `payment_status`, `createDate`, `tax`, `discount`, `currency`, `country`, `state`, `city`, `street`, `contact`, `zip`, `indivisual_name`, `gstin`,`payment_method`, `remark`, `narration`, `action`,`Addon_BulkAttn`, `Addon_LocationTracking`, `Addon_VisitPunch`, `Addon_GeoFence`, `Addon_Payroll`, `Addon_TimeOff`,due_payment) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($txnid,$org_id,$Company,$email,$amount,'SUCCESS',$today,$tax,$discount,$currency,$country,$state,$city,$street,$contact,$zip,$ind_name,$gstin,$paymentmthd,'Update user limit for '.$nofuser.' users. and extend plan period for '.$duration.' months. '.$msg,'Plan Period: '.date('d/m/Y',strtotime($st_date)).' - '.date('d/m/Y',strtotime($plan_enddate)).' <br/>No. of Users: '.$ulimit,'UPGRADE',$bulk_att,$loc_trace,$visit_punch,$geo_fence,$payroll,$timeoff,$due_amount));
		// updating licence_ubiattendance
		$query = $this->db->query("update licence_ubiattendance set `end_date` = '$plan_enddate', user_limit = user_limit + $nofuser ,extended =extended +1,transaction_id='".$txnid."' ,status=1 ,Addon_BulkAttn='".$bulk_attsts."', Addon_LocationTracking='".$loc_tracests."', Addon_VisitPunch='".$visit_punchsts."', Addon_GeoFence='".$geo_fencests."', Addon_Payroll='".$payrollsts."', Addon_TimeOff='".$timeoffsts."' ,due_amount = (due_amount-".$due_amount.")  where OrganizationId = $org_id");
		$query3 = $this->db->query("update Organization set NoOfEmp = NoOfEmp + $nofuser  where Id = $org_id");
		}			
		/* $query4 = $this->db->query("update admin_login set web_admin_login_sts = 1  where OrganizationId = $org_id"); */
		
			$subject = $Company." -ubiAttendance Payment.";
			$txt = "<html><body>Dear super admin<br/>,
				". $Company." has paid amount ".$currency." ".$amount." for upgradation of its ubiAttendance premium plan. <br/><br/>
				<b>Payment summary:</b> <br/><br/>
				Email ID: 	".$email." <br/>
				Transaction Id: ".$txnid." <br/>
				Amount paid: ".$currency." ".($amount+$tax)." (tax included) <br/>
				Tax paid:    ".$currency." ".$tax." <br/>
				Discount:    ".$currency." ".$discount." <br/>
				No. of users extended: ".$nofuser." <br/>
				Plan periods extends: ".$duration." month(s) <br/><br/>
				Thanks for buy ubiAttendance services.<br/><br/>
				TO generate the Invoice <a href='".URL."cron/generateInvoice?id=".base64_encode($txnid)."' target='_blank'> Click here</a>.<br/><br/>
				Regards<br/>
				Team ubiAttendance</body></html>";
			$txtuser = "<html><body>Dear ".$Company."<br/><br/>
				You have paid amount ".$currency." ".$amount." for upgradation of ubiAttendance Premium Plan. <br/><br/>
				<b>Payment summary:</b> <br/><br/>
				Email ID: 	".$email." <br/>
				Transaction Id: ".$txnid." <br/>
				Amount paid: ".$currency." ".($amount+$tax)." (tax included) <br/>
				Tax paid:    ".$currency." ".$tax." <br/>
				Discount:    ".$currency." ".$discount." <br/>
				No. of users extended: ".$nofuser." <br/>
				Plan periods extends: ".$duration." month(s) <br/><br/>
				Thanks for buy ubiAttendance services.<br/><br/>
				To generate the Invoice <a href='".URL."cron/generateInvoice?id=".base64_encode($txnid)."' target='_blank'> Click here</a>.<br/><br/>
				Regards<br/>
				Team ubiAttendance</body></html>";
			$headers = "From: sales@ubitechsolutions.com" . "\r\n" .
			 "CC: pragati@ubitechsolutions.com";
			sendEmail_new("sohan@ubitechsolutions.com",$subject,$txt,$headers);
			sendEmail_new("ubiattendance@ubitechsolutions.com",$subject,$txt,$headers);
			sendEmail_new("accounts@ubitechsolutions.com",$subject,$txt,$headers);
			sendEmail_new($email,$subject,$txtuser,'');
		    return $data; 
	}
	
function saveTempPay(){
	try{
	$ind_name=isset($_REQUEST["ind_name"])?$_REQUEST["ind_name"]:'0';
	 $amount=isset($_REQUEST["total"])?($_REQUEST["total"]):'0';
	 $discount=isset($_REQUEST["discount"])?($_REQUEST["discount"]):'0';
	 $duration=isset($_REQUEST["duration"])?($_REQUEST["duration"]):'0';
	 $plan=isset($_REQUEST["plan"])?$_REQUEST["plan"]:'0';
	 $country=isset($_REQUEST["country"])?($_REQUEST["country"]):'0';
	 $street=isset($_REQUEST["street"])?($_REQUEST["street"]):'0';
	 $city=isset($_REQUEST["city"])?($_REQUEST["city"]):'0';
	 $zip= isset($_REQUEST["zip"])?$_REQUEST["zip"]:'0';
	 $nofuser=isset($_REQUEST["noofusers"])?$_REQUEST["noofusers"]:'0'; 
	 $contact= isset($_REQUEST["contact"])?$_REQUEST["contact"]:'0';
	 $currency= isset($_REQUEST["currency"])?$_REQUEST["currency"]:'0';
	 $tax= isset($_REQUEST["taxforinr"])?($_REQUEST["taxforinr"]):'0';
	 $gstin= isset($_REQUEST["gstin"])?$_REQUEST["gstin"]:'0';
	 $state= isset($_REQUEST["state"])?$_REQUEST["state"]:'';
	 $action= isset($_REQUEST["action"])?$_REQUEST["action"]:'';
	 $msg='Payment recieved via auto mode (My Plan)';
	
	 $org_id	= 	$_SESSION['orgid'];
	 $Company=getOrgName($org_id);
	 $zone=getTimeZone($org_id);
	 date_default_timezone_set($zone);
	 $today=date('Y-m-d');	
	 $amount=$amount-$tax;
	 $data		=	array();
	 $email=getAdminEmail($org_id);
	 $txnid=$org_id.''.'';
	 $id=0;
	 $plan_enddate='';
	 
	    $query = $this->db->query("SELECT max(id)as id FROM `payments_invoice`");
		 if($row=$query->result())
			$id=$row[0]->id;
		 $txnid=$org_id.''.$id;	
		 
	 if($plan=='YEARLY')
		 $duration=$duration * 12; // if plan is yearly, it should be convert in months
	 
	 $query = $this->db->query("SELECT `end_date`  FROM `licence_ubiattendance` WHERE `OrganizationId`='$org_id' limit 1");
	 if($row=$query->result())
		$plan_enddate= $row[0]->end_date;
	if($plan_enddate < $today)
			 $plan_enddate=$today;
		 
	 $plan_enddate = date('Y-m-d', strtotime("+".$duration." months", strtotime($plan_enddate)));
	/* 
	 $query = $this->db->query("SELECT id FROM `payments_invoice` WHERE `txnid`='$txnid'");
	 if($query->num_rows()>0)
	 {	
			return $data;
			return false; ///// transaction information already inserted
	 }
	  */
	  
		 $query = $this->db->query("INSERT INTO `temp_payment`(`txnid`, `OrganizationId`, `name`, `email`, `payment_amount`, `payment_status`, `createDate`, `tax`, `discount`, `currency`, `country`, `state`, `city`, `street`, `contact`, `zip`, `indivisual_name`, `gstin`,`noofusers`, `duration`, `remark`,`narration`, `action`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($txnid,$org_id,$Company,$email,$amount,'SUBMIT',$today,$tax,$discount,$currency,$country,$state,$city,$street,$contact,$zip,$ind_name,$gstin,$nofuser,$duration,$msg, 'Plan Period: Your plan duration extend for '.$duration.' months<br/>Administrator Login (1 Admin)<br/>User Logins ('.$nofuser.' Users)',$action));
		 $this->db->close();
		 $data['status']=true;
		echo json_encode($data);
	}catch(Exception $e){
		echo $e->getMessage();
	}
	}
	
	function PaymentFailed(){
		
	/*if(isset($_REQUEST['productinfo'])){ // payUMoney
	 $_REQUEST['productinfo']=json_decode($_REQUEST['productinfo']);
	 //print_r(base64_decode($_REQUEST['productinfo'][0]->duration));
	 $ind_name=isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->ind_name:'0';
	 $amount=isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->total):'0';
	 $discount=isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->discount):'0';
	 $duration=isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->duration):'0';
	 $plan=isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->plan:'0';
	 $country=isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->country):'0';
	 $street=isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->street):'0';
	 $city=isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->city):'0';
	 $zip= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->zip:'0';
	 $nofuser=isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->noofusers:'0'; 
	 $contact= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->contact:'0';
	 $currency= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->currency:'0';
	 $tax= isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->taxforinr):'0';
	 $gstin= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->gstin:'0';
	 $state= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->state:'';
	 $msg='Payment recieved via auto mode-payUMoney (admin)';
	}else{							// payPal
	 $ind_name=isset($_REQUEST["ind_name"])?$_REQUEST["ind_name"]:'0';
	 $amount=isset($_REQUEST["total"])?base64_decode($_REQUEST["total"]):'0';
	 $discount=isset($_REQUEST["discount"])?base64_decode($_REQUEST["discount"]):'0';
	 $duration=isset($_REQUEST["duration"])?base64_decode($_REQUEST["duration"]):'0';
	 $plan=isset($_REQUEST["plan"])?$_REQUEST["plan"]:'0';
	
	 $country=isset($_REQUEST["country"])?base64_decode($_REQUEST["country"]):'0';
	 $street=isset($_REQUEST["street"])?base64_decode($_REQUEST["street"]):'0';
	 $city=isset($_REQUEST["city"])?base64_decode($_REQUEST["city"]):'0';
	 $zip= isset($_REQUEST["zip"])?$_REQUEST["zip"]:'0';
	 $nofuser=isset($_REQUEST["noofusers"])?$_REQUEST["noofusers"]:'0'; 
	 $contact= isset($_REQUEST["contact"])?$_REQUEST["contact"]:'0';
	 $currency= isset($_REQUEST["currency"])?$_REQUEST["currency"]:'0';
	 $tax= isset($_REQUEST["taxforinr"])?base64_decode($_REQUEST["taxforinr"]):'0';
	 $gstin= isset($_REQUEST["gstin"])?$_REQUEST["gstin"]:'0';
	 $state= isset($_REQUEST["state"])?$_REQUEST["state"]:'';
	 $msg='Payment recieved via auto mode-payPal (My Plan)';
	}
	// $ind_name='no name';
	
	 $org_id	= 	$_SESSION['orgid'];
	 $Company=getOrgName($org_id);
	 $zone=getTimeZone($org_id);
	 date_default_timezone_set($zone);
	 $today=date('Y-m-d');	
	 $amount=$amount-$tax;
	 $data		=	array();
	 $email=getAdminEmail($org_id);
	 $txnid=$org_id.''.'';
	 $id=0;
	 $plan_enddate='';
	 if(!isset($_SESSION['txnd'])){
		 $query = $this->db->query("SELECT max(id)as id FROM `payments_invoice`");
		 if($row=$query->result())
			$id=$row[0]->id;
		 $txnid=$org_id.''.$id;	
		 $_SESSION['txnd']=$txnid;
	 }else
		 $txnid=$_SESSION['txnd'];
	 
		// echo $duration;
	 if($plan=='YEARLY')
		  $duration=$duration * 12; // if plan is yearly, it should be convert in months
	 
	 $query = $this->db->query("SELECT `end_date`  FROM `licence_ubiattendance` WHERE `OrganizationId`='$org_id' limit 1");
	 if($row=$query->result())
		 $plan_enddate= $row[0]->end_date;
	if($plan_enddate < $today)
			 $plan_enddate=$today;
		 
	  $plan_enddate = date('Y-m-d', strtotime("+".$duration." months", strtotime($plan_enddate)));
	  
	$narration='Plan Period: Your Plan will end on '.date('d/m/Y',strtotime($plan_enddate)).'<br/>Administrator Login (1 Admin)<br/>User Logins ('.$nofuser.' Users)';
	
	 $query = $this->db->query("SELECT id FROM `payments_invoice` WHERE `txnid`='$txnid'");
	 if($query->num_rows()>0)
	 {		
			return $data;
			return false; ///// transaction information already inserted
	 }
	
	$query = $this->db->query("INSERT INTO `payments_invoice`( `txnid`, `OrganizationId`, `name`, `email`, `payment_amount`, `payment_status`, `createDate`, `tax`, `discount`, `currency`, `country`, `state`, `city`, `street`, `contact`, `zip`, `indivisual_name`, `gstin`, `remark`,  `narration`, `action`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($txnid,$org_id,$Company,$email,$amount,'FAILED',$today,$tax,$discount,$currency,$country,$state,$city,$street,$contact,$zip,$ind_name,$gstin,$msg,$narration,'BUY'));
	return $data; */
//	echo  '<h2>Plan Failed</h2>';
	}
	
	
	function UpgradePlan_Failed(){
	/*if(isset($_REQUEST['productinfo'])){ // payUMoney
	 $_REQUEST['productinfo']=json_decode($_REQUEST['productinfo']);
	 $action=isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->action:'0';
	 $ind_name=isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->ind_name:'0';
	 $amount=isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->total):'0';
	 $discount=isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->discount):'0';
	 $duration=isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->duration):'0';
	 $plan=isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->plan:'0';
	
	 $country=isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->country):'0';
	 $street=isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->street):'0';
	 $city=isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->city):'0';
	 $zip= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->zip:'0';
	 $nofuser=isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->noofusers:'0'; 
	 $contact= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->contact:'0';
	 $currency= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->currency:'0';
	 $tax= isset($_REQUEST["productinfo"])?base64_decode($_REQUEST["productinfo"][0]->taxforinr):'0';
	 $gstin= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->gstin:'0';
	 $state= isset($_REQUEST["productinfo"])?$_REQUEST["productinfo"][0]->state:'';
	 $msg='Payment recieved via auto mode-payUMoney (admin)';
	}else{
	 $action=isset($_REQUEST["action"])?$_REQUEST["action"]:''; // UO/DO/UD users lim only/duration only/user lim and duration both
	 $ind_name=isset($_REQUEST["ind_name"])?$_REQUEST["ind_name"]:'0';
	 $amount=isset($_REQUEST["total"])?base64_decode($_REQUEST["total"]):'0';
	 $discount=isset($_REQUEST["discount"])?base64_decode($_REQUEST["discount"]):'0';
	 $duration=isset($_REQUEST["duration"])?base64_decode($_REQUEST["duration"]):'0';
	 $plan=isset($_REQUEST["plan"])?$_REQUEST["plan"]:'0';
	 $country=isset($_REQUEST["country"])?base64_decode($_REQUEST["country"]):'0';
	 $street=isset($_REQUEST["street"])?base64_decode($_REQUEST["street"]):'0';
	 $city=isset($_REQUEST["city"])?base64_decode($_REQUEST["city"]):'0';
	 $zip= isset($_REQUEST["zip"])?$_REQUEST["zip"]:'0';
	 $nofuser=isset($_REQUEST["noofusers"])?$_REQUEST["noofusers"]:'0'; 
	 $contact= isset($_REQUEST["contact"])?$_REQUEST["contact"]:'0';
	 $currency= isset($_REQUEST["currency"])?$_REQUEST["currency"]:'0';
	 $tax= isset($_REQUEST["taxforinr"])?base64_decode($_REQUEST["taxforinr"]):'0';
	 $gstin= isset($_REQUEST["gstin"])?$_REQUEST["gstin"]:'0';
	 $state= isset($_REQUEST["state"])?$_REQUEST["state"]:'';
	 $msg='Payment recieved via auto mode-payPal (My Plan)';
	}
	
	
	
	 $org_id	= 	$_SESSION['orgid'];
	 $Company=getOrgName($org_id);
	 $zone=getTimeZone($org_id);
	 date_default_timezone_set($zone);
	 $today=date('Y-m-d');	
	 $amount=$amount-$tax;
	 $data		=	array();
	 $email=getAdminEmail($org_id);
	 $txnid=$org_id.''.'';
	 $id=0;
	 $plan_enddate='';
	 if(!isset($_SESSION['txnd']))
	 {
		 $query = $this->db->query("SELECT max(id)as id FROM `payments_invoice`");
		 if($row=$query->result())
			$id=$row[0]->id;
		 $txnid=$org_id.''.$id;	
		 $_SESSION['txnd']=$txnid;
	 }else
		 $txnid=$_SESSION['txnd'];
	 
		 
	 if($plan=='YEARLY')
		 $duration=$duration * 12; // if plan is yearly, it should be convert in months
	 
	 $query = $this->db->query("SELECT `end_date`  FROM `licence_ubiattendance` WHERE `OrganizationId`='$org_id' limit 1");
	 if($row=$query->result())
		$plan_enddate= $row[0]->end_date;
	if($plan_enddate < $today)
			 $plan_enddate=$today;
		 
	 $plan_enddate = date('Y-m-d', strtotime("+".$duration." months", strtotime($plan_enddate)));
	
	 $query = $this->db->query("SELECT id FROM `payments_invoice` WHERE `txnid`='$txnid'");
	 if($query->num_rows()>0)
	 {	
			return $data;
			return false; ///// transaction information already inserted
	 }
	 
		if($action=='DO'){
		 $query = $this->db->query("INSERT INTO `payments_invoice`( `txnid`, `OrganizationId`, `name`, `email`, `payment_amount`, `payment_status`, `createDate`, `tax`, `discount`, `currency`, `country`, `state`, `city`, `street`, `contact`, `zip`, `indivisual_name`, `gstin`, `remark`, `narration`, `action`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($txnid,$org_id,$Company,$email,$amount,'FAILED',$today,$tax,$discount,$currency,$country,$state,$city,$street,$contact,$zip,$ind_name,$gstin,'Update Plan duration for '.$duration.' months. '.$msg, 'Plan Period: Your Plan duration extend for '.$duration.' months<br/>Administrator Login (1 Admin)','UPGRADE'));
		
		}else if($action=='UO'){ 
			$query = $this->db->query("INSERT INTO `payments_invoice`( `txnid`, `OrganizationId`, `name`, `email`, `payment_amount`, `payment_status`, `createDate`, `tax`, `discount`, `currency`, `country`, `state`, `city`, `street`, `contact`, `zip`, `indivisual_name`, `gstin`, `remark`, `narration`, `action`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($txnid,$org_id,$Company,$email,$amount,'FAILED',$today,$tax,$discount,$currency,$country,$state,$city,$street,$contact,$zip,$ind_name,$gstin,'Update user limit for '.$nofuser.' users. '.$msg,'Administrator Login ( Admin)<br/>User Logins ('.$nofuser.' Users)','UPGRADE'));
			
		}
		else if($action=='UD'){ 
			$query = $this->db->query("INSERT INTO `payments_invoice`( `txnid`, `OrganizationId`, `name`, `email`, `payment_amount`, `payment_status`, `createDate`, `tax`, `discount`, `currency`, `country`, `state`, `city`, `street`, `contact`, `zip`, `indivisual_name`, `gstin`, `remark`, `narration`, `action`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($txnid,$org_id,$Company,$email,$amount,'FAILED',$today,$tax,$discount,$currency,$country,$state,$city,$street,$contact,$zip,$ind_name,$gstin,'Update user limit for '.$nofuser.' users. and extend plan period for '.$duration.' months. '.$msg,'Plan Period: Your Plan duration extend for '.$duration.' months<br/>Administrator Login (1 Admin)<br/>User Logins ('.$nofuser.' Users)','UPGRADE'));
		}		
		    return $data; 
	}*/
	//echo  '<h2>Plan Failed</h2>';
	
}
}
?>