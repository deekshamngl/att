<?php
class MyPlan_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
		include(APPPATH."PhpMailer/class.phpmailer.php");
		
    }

    function MyPlan(){
		$data = array();
		$org_id=$_SESSION['orgid'];
		$CurrentDate = date('Y-m-d');
		$query = $this->db->query("SELECT `id`,`start_date`, `end_date`,`user_limit`, `adons`, `reg_users`,(SELECT COUNT( Id ) FROM EmployeeMaster WHERE OrganizationId =$org_id) AS totalUser, (SELECT COUNT( Id ) FROM EmployeeMaster WHERE OrganizationId =$org_id and archive = 1) AS activeUser FROM `licence_ubiattendance` where `OrganizationId`=$org_id");
		if ($row=$query->result_array())
		{
			 $data['start_date'] =  date("d-m-Y", strtotime($row[0]['start_date'])); 	   
		     $data['end_date']   =  date("d-m-Y", strtotime($row[0]['end_date'])); 	   
		     $data['user_limit'] =  $row[0]['user_limit']; 	   
		     $data['totalUser']  =  $row[0]['totalUser']; 	   
		     $data['activeUser'] =  $row[0]['activeUser'];	
			 $data['inactiveUser'] =  $row[0]['totalUser']- $row[0]['activeUser'];
			 $date2=date_create($data['end_date']);
             $date1=date_create($CurrentDate);
             $diff=date_diff($date1,$date2);
             $data['days'] = $diff->format("%a");			 
		}
		$query = $this->db->query("SELECT Id,`packagename`,`baseinr`, `basedollar`, `priceperuserpermonthinr`, `priceperuserpermonthdollar`, `disinrupeeforinr`, `disindollarfordollar`, `disinperforinr`, `disinperfordollar`, `disinmonthforyearlyinr`, `disinmonthforyearlydollar`, `applogin`, `adminlogin`, `modified_date`,addonuseerpminr,addonuseerpmusd,igst FROM `package_master_ubiattendance_new` WHERE 1");
		if ($row=$query->result_array())
		{			 
		     $data['pid'] =$row[0]['Id'];
		     $data['packagename'] =  $row[0]['packagename'];
		     $data['baseinr'] =  $row[0]['baseinr'];
		     $data['basedollar'] =  $row[0]['basedollar'];
		     $data['priceperuserpermonthinr'] =  $row[0]['priceperuserpermonthinr'];
		     $data['priceperuserpermonthdollar'] =  $row[0]['priceperuserpermonthdollar'];
		     $data['disinrupeeforinr'] =  $row[0]['disinrupeeforinr'];
		     $data['disindollarfordollar'] =  $row[0]['disindollarfordollar'];
		     $data['disinperforinr'] =  $row[0]['disinperforinr'];
		     $data['disinperfordollar'] =  $row[0]['disinperfordollar'];
		     $data['disinmonthforyearlyinr'] =  $row[0]['disinmonthforyearlyinr'];
		     $data['disinmonthforyearlydollar'] =  $row[0]['disinmonthforyearlydollar'];
		     $data['applogin'] =  $row[0]['applogin'];
		     $data['adminlogin'] =  $row[0]['adminlogin'];		 
		     $data['addonuseerpminr'] =  $row[0]['addonuseerpminr'];		 
		     $data['addonuseerpmusd'] =  $row[0]['addonuseerpmusd'];		 
		     $data['igst'] =  $row[0]['igst'];		 
		}
		$query = $this->db->query("SELECT Name,Email,PhoneNumber,City,(SELECT  name FROM admin_login where OrganizationId =$org_id limit 1) as cname FROM Organization where id =$org_id ");
			$row = $query->row();
			$num = $query->num_rows();
			if($num > 0){
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
					
				}$data['states']=$states;
				$data['codes']=$codes;
			
	/*	$query = $this->db->query("SELECT start_date, end_date,status,user_limit, (SELECT COUNT( Id ) FROM EmployeeMaster WHERE OrganizationId =$org_id) AS totalUser, (SELECT COUNT( Id ) FROM EmployeeMaster WHERE OrganizationId =$org_id and archive = 1) AS activeUser,
	
	(select per_user_usd from package_master_ubiattendance) as PerUserPlan ,(select per_user_inr from package_master_ubiattendance) as per_user_inr ,(select package_price_inr_yr from package_master_ubiattendance) as package_price_inr_yr,(select package_price_usd_yr from package_master_ubiattendance) as package_price_usd_yr ,(select package_price_usd_yr from package_master_ubiattendance) as package_price_usd_yr FROM licence_ubiattendance WHERE OrganizationId =$org_id LIMIT 0 , 30");
	
		foreach ($query->result_array() as $row)
		{	 
		     
		     $data['start_date'] =  date("d-m-Y", strtotime($row['start_date'])); 	   
		     $data['end_date']   =  date("d-m-Y", strtotime($row['end_date'])); 	   
		     $data['user_limit'] =  $row['user_limit']; 	   
		     $data['totalUser']  =  $row['totalUser']; 	   
		     $data['activeUser'] =  $row['activeUser'];
             $data['inactiveUser'] =  $row['totalUser']- $row['activeUser'];
			 $date2=date_create($data['end_date']);
             $date1=date_create($CurrentDate);
             $diff=date_diff($date1,$date2);
             $data['days'] = $diff->format("%a");
		}		*/
		return $data;
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
					if($query1->num_rows() > 0){
						$row = $query1->row();
						$to = $row->Email;
						$subject = "ubiAttendance Payment Success";
						$txt = "Thanks for buy the ubiAttendance subscription";
						$headers = "From: sales@ubitechsolutions.com" . "\r\n" .
						 "CC: vijay@ubitechsolutions.com";
						mail($to,$subject,$txt,$headers);
					}
					 $data['status']=1; // true
				}else{
					$data['status']=2; // payment done but didnt update in our system
				}
		   }
		   
		   return $data;
	} 	
}
?>