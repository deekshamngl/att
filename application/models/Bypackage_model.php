<?php
class Bypackage_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
		include(APPPATH."PhpMailer/class.phpmailer.php");
		
    }
function MyPlan(){
		$data = array();
		
		$org_id=10;
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
		$query = $this->db->query("SELECT Name,Email,PhoneNumber,City,(SELECT  name FROM admin_login where OrganizationId =$org_id) as cname FROM Organization where id =$org_id ");
			$row = $query->row();
			$num = $query->num_rows();
			if($num > 0){
			 $data['oname']=$row->Name;	
			 $data['cname']=$row->cname;	
			 $data['oemail']=$row->Email;	
			 $data['ophone']=$row->PhoneNumber;	
			 $data['state']=$row->City;	
			}
			
			
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
	}
	?>