
<?php
class Superadmin_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
		include(APPPATH."PhpMailer/class.phpmailer.php");
    }
	public function getCountries()
	{
		$query = $this->db->query("SELECT `Id`, `Name` FROM `CountryMaster`");
		return $query;
	}
	public function getOrganizationData($val){
		
			$countype = isset($_REQUEST['conttype'])?$_REQUEST['conttype']:"0";
			//$date = isset($_REQUEST['date'])?$_REQUEST['date']:"";
			//echo $conttype;
			 $q = "";
			 $todaydate = date("Y-m-d");
			 /* trial user */
			 $pageid = "";
			 if($val=='trial')
			 {
			    $q= "AND licence_ubiattendance.status = '0' AND licence_ubiattendance.extended = '1' AND '$todaydate' <= licence_ubiattendance.end_date AND Organization.customize_org=0 and delete_sts=0";
				$pageid=3.1;
				
			 }
			 	 /* paid user */
			 else if($val=='paid')
			 {
				 $q= "AND licence_ubiattendance.status= '1' AND '$todaydate' <= licence_ubiattendance.end_date AND Organization.customize_org=0 and delete_sts=0";
				 $pageid=3;
			 }
			 	 /* Expired user tril */
			 else if($val=='expiretril')
			 {
				$q= "AND licence_ubiattendance.status= '0' AND '$todaydate' > licence_ubiattendance.end_date AND Organization.customize_org=0 and delete_sts=0";
				 $pageid=3.2;
			 }
			 	 /* Extended trial user */
			 else if($val=='extendtrial')
			 {
				$q= "AND licence_ubiattendance.status= '0' AND licence_ubiattendance.extended > 1 AND  licence_ubiattendance.end_date >='$todaydate' AND Organization.customize_org=0 and delete_sts=0";
				$pageid=3.3;
			 }
			  /* not renew user */
			 else if($val=='notrenew')
			 {
				$q = "AND delete_sts=2";
				$pageid=3.4;
			 }
			 /* Expired Subscription */
			 else if($val=='subscriptionexpired')
			 {
				$q = "AND licence_ubiattendance.status= '1'  AND '$todaydate' > licence_ubiattendance.end_date AND Organization.customize_org=0 and delete_sts=0";
				$pageid=3.6;
			 }
			 else if($val=='customized')
			 {
				$q = "AND Organization.customize_org=1 and delete_sts=0";
                $pageid=3.7;				
			 }
			 else if($val=='archive')
			 {
				$q = "AND delete_sts=1";  
				$pageid=3.8;
			 }
			 else if($val == 'pendingall')
			 {
				
				$q = "AND Organization.customize_org=0 and delete_sts=0 and mail_varified=0"; 
				   // if($date != "")
				 // {
					// $arr=explode('-',trim($date));
					 // $enddate = date('Y-m-d',strtotime($arr[1]));
					 // $strtdate= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3)));  
                    // $q .= " AND  Organization.CreatedDate BETWEEN     '$strtdate' AND '$enddate'";
				 // }
				 // else
				 // {
					 
					 // $date = date('Y-m-d');
					 // $enddate = date('Y-m-d');
					 // $strtdate= date('Y-m-d',strtotime('-7 days',strtotime($date)));
					 // $q .= " AND  Organization.CreatedDate BETWEEN ' $strtdate' AND '$enddate'";
				 // }
                $pageid=3.12;				 
			 }
			 
			  if($countype == 2){
				  
			 	$q.= " AND Organization.Country = 93";
			 }else if($countype == 1){
				 
			 	$q.= " AND Organization.Country != 93";
			 }
			 
			 
			
			$query = $this->db->query("SELECT Organization.Id, Organization.mail_unsubscribe,Organization.Name ,Organization.Country ,Organization.Email ,Organization.PhoneNumber,Organization.NoOfEmp ,Organization.Address, admin_login.name, admin_login.password as pwd,mail_varified, date(CreatedDate) as cdate 
            ,licence_ubiattendance.status as sstts ,(SELECT count(Id)  FROM `UserMaster` WHERE UserMaster.	OrganizationId=Organization.Id)as noemp,(SELECT `end_date`  FROM `licence_ubiattendance` WHERE licence_ubiattendance.OrganizationId=Organization.Id)as edate,(SELECT `due_amount`  FROM `licence_ubiattendance` WHERE licence_ubiattendance.OrganizationId=Organization.Id)as dueamount,(SELECT `start_date`  FROM `licence_ubiattendance` WHERE licence_ubiattendance.OrganizationId=Organization.Id)as sdate FROM Organization
            INNER JOIN admin_login ON Organization.	Id = admin_login.OrganizationId 
            INNER JOIN licence_ubiattendance ON Organization.Id = licence_ubiattendance.OrganizationId $q group by Organization.Id "); 
			
			$d=array();
			$res=array();
			$today=date('Y-m-d');
			 $flag=1;
			 $count = $this->db->affected_rows();
			
			 if($count)
			 foreach ($query->result() as $row)
			{
					$varify='';
					$data=array();
					$data['orgName']=$row->Name;
					$data['address']=$row->Address;
					$data['noemp']=$row->noemp;
					$data['userlimit']=$row->NoOfEmp;
					$data['dueamount']=$row->dueamount;
					$data['ref_no']=(($row->Id)*($row->Id))+99;
					$data['rdate']=date('Y-m-d',strtotime($row->cdate));
					$data['sdate']=date('Y-m-d',strtotime($row->sdate));
					$data['edate']=$data['edate']='<div title="Active Subscription " class="text-center" data-background-color="green">'.date('Y-m-d',strtotime($row->edate)).'</div>';
					if($today > $row->edate)
						$data['edate']='<div title="Subscription expired" class="text-center" data-background-color="red">'.date('Y-m-d',strtotime($row->edate)).'</div>';
					$country =  $row->Country;
					// this code for get a country start////
					$this->db->where('Id', $country);
					$q = $this->db->get('CountryMaster');
					$data1 = $q->result_array();
					$data['country'] = getCountryById1($row->Country);
					// this code for get a country end ////
					$data['email']=$row->Email;
					
					$data['c_nmae'] = $row->name;
					//$data['pass'] = decrypt($data2[0]['password']);
					$data['pass'] = decrypt($row->pwd);
					$data['PhoneNumber']='('.getCountryCodeById1($row->Country).')'.$row->PhoneNumber;
					$data['emailstatus']='<div class="text-center"  data-background-color="red">Pending</div>';
					// this code for cunsulting person name end //
					$data['action']='<i class="material-icons edit" data-toggle="modal" title="View" 
					data-id="'.$row->Id.'" 
					data-orgname="'.$row->Name.'" 
					data-country="'.$row->Country.'"
					data-email="'.$row->Email.'"
					data-phonenumber="'.$row->PhoneNumber.'"
					data-address="'.$row->Address.'"
					data-name="'.$row->name.'"
					><a href="'.URL.'ubitech/editOrganizationData/'.$row->Id .'/'.$pageid.'" >visibility</a></i> ';
				
					$data['action'].='<a href="'.URL.'services/activateOrg?iuser='.encrypt($row->Id).'" target="_blank"><i style="color:red" title="Verify account" class="material-icons edit" >done</i></a>';
					
					
					if($val=='archive')
						//$data['action'].='';
						$data['action'].='<a><i data-id="'.$row->Id.'" 
					data-orgname="'.$row->Name.'"  style="color:red;cursor:pointer" title="Permanently Delete Organization" class="material-icons delete_p" >delete</i></a>';
					else
						$data['action'].='<a><i data-id="'.$row->Id.'" 
					data-orgname="'.$row->Name.'"  style="color:orange;cursor:pointer" title="Archive Organization" class="material-icons delete" >delete</i></a>';
					
					if($row->sstts==1){
						$data['sstts']='<div title="Paid subscription " class="text-center"  data-background-color="green">Paid</div>';
						$data['action'].='<a href="'.URL.'ubitech/getPaymentHistory?orgid='.$row->Id.'"><i 
						data-orgname="'.$row->Name.'"  style="color:green;cursor:pointer" title="Payment History" class="material-icons" >credit_card</i></a>';
					}
					else if($row->sstts==2)
						$data['sstts']='<div title="
					Subscription Expired" class="text-center" data-background-color="red">Expired</div>';
					else
						$data['sstts']='<div title="Subscription is under trial period" class="text-center" data-background-color="orange">Trial</div>';
					if($val=='subscriptionexpired')
					{
					  $data['action'].='<a>&nbsp;&nbsp;<i data-id="'.$row->Id.'" 
					data-orgname="'.$row->Name.'"  style="color:orange;cursor:pointer;font-size:20px" title="Not Renewed" class="fa fa-ban notrenew" ></i></a>';	
					}
					if($row->mail_unsubscribe==0)
						$data['action'].='<a href="'.URL.'cron/unsubscribeOrgMails/'.$row->Id.'" target="_blank"><i style="color:red" title="Unsubscribe" class="material-icons unsubscribe">unsubscribe</i></a>';	//to unsubscribe mails
					
					$res[]=$data;
					$flag=0;
			}  	
			
			$d['data']=$res;  				//$query->result();
			echo json_encode($d); return false;
			
		}
}
?>