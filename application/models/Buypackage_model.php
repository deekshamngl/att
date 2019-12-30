<?php
class Buypackage_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
		include(APPPATH."PhpMailer/class.phpmailer.php");
    }
		/* public function getPackagesDetail(){
			$query = $this->db->query("SELECT * FROM `package_master_ubiattendance` WHERE archive=1");		
			return $query->result();
		} */
		
			public function getPackagesDetail(){
		
			$query = $this->db->query("SELECT * FROM `package_master_ubiattendance` WHERE archive=1");
			$d=array();
			$res=array();
			 foreach ($query->result() as $row)
			{
				$data=array();
					$data['id']=$row->id;
					$data['name']=$row->package_name;
					$data['discount']=$row->discount;
					$data['inr']=$row->package_price_inr_yr;
					$data['usd']=$row->package_price_usd_yr;
					$data['inrperuser']=$row->per_user_inr;
					$data['usdperuser']=$row->per_user_usd;
					$data['user']=$row->package_user_limit;
					$data['sts']=$row->archive==1?'<div style="background-color:green;text-align:center;color:white;">Active</div>':'<div style="background-color:red;text-align:center;color:white;">
					Inactive</div>';
					//$data['sts']=$row->archive;
					
					/*$data['image']='<img src="'.URL.'../ubitech/upload/'.$row->filename.'"  style="width:100%!important; "/>';
					$data['status']=$row->archive==1?'<div style="background-color:green;text-align:center;color:white;">Visible</div>':'<div style="background-color:red;text-align:center;color:white;">
					Invisible</div>';
					*/
					$res[]=$data;
			}  	
			$d['data']=$res;  				//$query->result();
			//echo json_encode($d); 
			return $d;
	
		}
		
		/*
		//////////////////////---------------------------------------slider
		public function uploadimg(){
		$fname = isset($_REQUEST['name'])?$_REQUEST['name']:'';
		$desc = isset($_REQUEST['desc'])?$_REQUEST['desc']:'';
		$link = isset($_REQUEST['link'])?$_REQUEST['link']:'';
		$status = isset($_REQUEST['status'])?$_REQUEST['status']:'';
		
			try{
					
			if(isset($_FILES['file'])){
			$name="";
				$errors= array();
				$file_name = $_FILES['file']['name'];
				$ext = end((explode(".", $file_name))); 
				 $query = $this->db->query("SELECT max(id)+1 as maxid FROM slider_settings");
				
		
				if ($row= $query->row()) {
			
				 $name=$row->maxid;
				
			
				}
	
	
		 $storage_name="$name.$ext";

		//Trace($storage_name);
		
				if (file_exists($storage_name))
				{
					unlink($storage_name); 
				}
				$file_size =$_FILES['file']['size'];
				$file_tmp =$_FILES['file']['tmp_name'];
				$file_type=$_FILES['file']['type'];   
				$location="ubitech/upload/";
				if($file_size > 2097152){
				$errors[]='File size must be less than 2 MB';
				}
				
				if(empty($errors)==true){
				
					if(move_uploaded_file($file_tmp, $location.$storage_name )){
						 $query = $this->db->query("INSERT INTO `slider_settings`(`name`, `description`, `link`, `file`, `archive`) VALUES (?,?,?,?,?)",array($fname,$desc,$link,$storage_name,$status)); 
			 if($query>0){
                  Trace("inserted successfully");
				  $this->session->set_flashdata('success', "Data inserted successfully");
					}else{
						$this->session->set_flashdata('error', "Data is not insert");
						Trace(" not inserted");
					}
					chmod($location.$storage_name, 0755);
					
					}
				}else{
					print_r($errors);
				}
				
			}else{
				Trace("not in isset");
			}
			}catch(Exception $e){
				Trace($e->getMessage());
			}
			
			
		}
		public function getSliderData(){
			
			$query = $this->db->query("SELECT `id`, `name`, `description`, `link` as links, `file` as filename, `archive` FROM `slider_settings` order by name");
			$d=array();
			$res=array();
			 foreach ($query->result() as $row)
			{
				$data=array();
					$data['name']=$row->name;
					$data['desc']=$row->description;
					$data['link']=$row->links;
					$data['image']='<img src="'.URL.'../ubitech/upload/'.$row->filename.'"  style="width:100%!important; "/>';
					$data['status']=$row->archive==1?'<div style="background-color:green;text-align:center;color:white;">Visible</div>':'<div style="background-color:red;text-align:center;color:white;">
					Invisible</div>';
					$data['action']='<i class="material-icons edit" data-toggle="modal" title="Edit" data-sid="'.$row->id.'"
					 data-id="'.$row->id.'" 
					 data-name="'.$row->name.'" 
					 data-desc="'.$row->description.'"
					 data-link="'.$row->links.'"
					 data-file="'.$row->filename.'"
					 data-sts="'.$row->archive.'"
					data-target="#addSldE">edit</i>
					<i class="material-icons delete" data-toggle="modal" data-target="#delSld" data-aid="'.$row->id.'" data-image="'.$row->filename.'" title="Delete" >close</i> 
					';
					$res[]=$data;
			}  	
			$d['data']=$res;  				//$query->result();
			echo json_encode($d); return false;
		}
		///////////////////////////-----------------------slider
		
		public function deleteSliderData(){
			$id =  isset($_REQUEST['id'])? $_REQUEST['id'] : '' ;
			$imagepath =  isset($_REQUEST['imagePath'])?$_REQUEST['imagePath']: '';
			$query = $this->db->query("delete from slider_settings where id = $id");
			unlink("ubitech/upload/".$imagepath);
			if($query>0){
			 echo "true";
			}
		}
		
		public function editSliderData(){
			
		$id = isset($_REQUEST['edit_id'])?$_REQUEST['edit_id']:'';
		$fname = isset($_REQUEST['nameE'])?$_REQUEST['nameE']:'';
		$desc = isset($_REQUEST['descE'])?$_REQUEST['descE']:'';
		$link = isset($_REQUEST['linkE'])?$_REQUEST['linkE']:'';
		$status = isset($_REQUEST['statusE'])?$_REQUEST['statusE']:'';
		
			try{
					
			if(isset($_FILES['fileE'])){
			    $name="";
				$errors= array();
				$file_name = $_FILES['fileE']['name'];
				$ext = end((explode(".", $file_name))); 
				$name=$id;
		        $storage_name="$name.$ext";
				$file_size =$_FILES['fileE']['size'];
				$file_tmp =$_FILES['fileE']['tmp_name'];
				$file_type=$_FILES['fileE']['type'];   
				$location="ubitech/upload/";
				if($file_size > 2097152){
				$errors[]='File size must be less than 2 MB';
				}
				$query = $this->db->query("SELECT file FROM slider_settings where id = $id");
					if ($row= $query->row()) {						 
					  $file=$row->file;
					  if($file!=""){
						  if($file_name!=""){
							unlink("ubitech/upload/".$file);
						  }
					  }
					}
				
				if(empty($errors)==true){
					if(move_uploaded_file($file_tmp, $location.$storage_name )){
						 $query = $this->db->query("update slider_settings set file = '$storage_name' where id = $id"); 
					}
				}else{
					print_r($errors);
				}
				
			}else{
				Trace("not in isset");
			}
			
			$query = $this->db->query("update slider_settings set name='$fname',description='$desc',link='$link',archive=$status where id = $id");
            if($query>0){
				$this->session->set_flashdata('success', "Data Updated successfully");
			 
			  }else{
				  $this->session->set_flashdata('error', "Data is not update");
				
			   }	
			}catch(Exception $e){
				Trace($e->getMessage());
			}
		}
		
		public function getCountries(){
			$query = $this->db->query("SELECT `Id`, `Name` FROM `CountryMaster`");
			return $query;
		}*/
		
		public function register_org(){
			
			$org_name =  isset($_REQUEST['org_name'])?$_REQUEST['org_name']:"";
			$contact_person_name =  isset($_REQUEST['name'])?$_REQUEST['name']:"";
			$email =  isset($_REQUEST['email'])?$_REQUEST['email']:"";
			$phone =  isset($_REQUEST['phone'])?$_REQUEST['phone']:"";
			$county =  isset($_REQUEST['country'])?$_REQUEST['country']:"0";
			$address =  isset($_REQUEST['Address'])?$_REQUEST['Address']:"";
			$password = encrypt(make_rand_pass());
			
			$sql = "SELECT * FROM Organization where Email = '$email'";
			$this->db->query($sql);
			if($this->db->affected_rows()>0){
				$this->session->set_flashdata('error', "Email id is already exists");
			}else{
					$TimeZone=0;
					$query = $this->db->query("SELECT * FROM `ZoneMaster` WHERE `CountryId`=$county");
					if($row=$query->result())
					$TimeZone= $row[0]->Id;
			        $query = $this->db->query("insert into Organization(Name,Email,PhoneNumber,Country,Address,TimeZone) values('$org_name','$email',$phone,$county,'$address',$TimeZone)");
			  
			 if($query>0){
				 $epassword=encrypt($password);
				$org_id = $this->db->insert_id(); 
				$query1 = $this->db->query("insert into admin_login(username,password,email,OrganizationId,name) values('$email','$epassword','$email',$org_id,'$contact_person_name')");
				
				//// This Code For Insert ShiftMaster,DepartmentMaster,DesignationMaster Table Start ////
				
					$data = array(
					'Name' => 'Other',
					'OrganizationId' => $org_id
					  );
				  $this->db->insert('DepartmentMaster', $data);			
				  $this->db->insert('ShiftMaster', $data);			
				  $this->db->insert('DesignationMaster', $data);
				  
				////  This Code For Insert ShiftMaster,DepartmentMaster,DesignationMaster Table End ////
				if($query1>0){
					
					$msg='userid: '.$email." Password: ".$password." AdminURL: http://ubiattendance.ubihrm.com/ orgnisation reference id: ".$org_id. " Thanks for registered with us." ;
					
					mail($email,"UbiAttendance Admin Login",$msg);
					//echo $org_id;
					// echo $admin_id =  $this->db->insert_id();
				}
				
				
			 }
			  $this->session->set_flashdata('success', "Organization registered successfully");
			}  
			
		}
		public function getOrganizationData($id,$packageId){
			$new_id = $id-99;
			$new_id = sqrt($new_id);
			$sql="SELECT * FROM Organization WHERE  (Id*Id)+99 = $id";
			$query = $this->db->query($sql);
			if($query->num_rows()>0){
			 $d=array();
			 $res=array();
			 $data=array();
			 foreach ($query->result() as $row)
			{
				$data['orgName']=$row->Name;
				$data['ref_no']=(($row->Id)*($row->Id))+99;
				
				$country =  $row->Country;
				// this code for get a country start////
				$this->db->where('Id', $country);
				$q = $this->db->get('CountryMaster');
				$data1 = $q->result_array();
				$data['country'] = $data1[0]['Name']; 
				// this code for get a country end ////
				$data['email']=$row->Email;
				// this code for cunsulting person name start //
				$id = $row->Id;
				$this->db->where('OrganizationId', $id);
				$q2 = $this->db->get('admin_login');
				$data2 = $q2->result_array();
				$data['c_nmae'] = $data2[0]['name']; 
				$data['PhoneNumber']=$row->PhoneNumber;
				// this code for cunsulting person name end //
				// this code for count user start //
				$query = $this->db->query("SELECT * FROM UserMaster where OrganizationId=$new_id");
                $data['TotalUsers'] = $query->num_rows();
				// this code for count user end //
				$query33 = $this->db->query("SELECT * FROM package_master_ubiattendance where id =$packageId");
                $row33 = $query33->row();
                $data['userUsd'] =  $row33->per_user_usd;
                $data['userRs'] =  $row33->per_user_inr;
                $data['BasicInUsd'] =  $row33->package_price_usd_yr;
                $data['BasicInRs'] =  $row33->package_price_inr_yr;
				// this code for user limit (start) - palash //
				$query44 = $this->db->query("SELECT * FROM licence_ubiattendance where OrganizationId =$new_id");
				$row44 = $query44->row();
                $data['UserLimit'] =  $row44->user_limit;
				$dt = new DateTime($row44->start_date);
				$data['RegistrationDate']=$dt->format('Y-m-d');
				$dt1 = new DateTime($row44->end_date);
				$data['Subscriptionupto']=$dt1->format('Y-m-d');
			    // this code for user limit (end) - palash //
			}
			echo json_encode($data);
			}			
			else{
			echo 0;	
			}
			return false;
		}
		
		
		public function editOrganizationData($id){
			    $res=array();		
			    $result=array();		
				$query = $this->db->query("select * from Organization where Id = $id");
				foreach ($query->result_array() as $row)
				{
					
					$res['id'] = $row['Id'];
					$res['Name'] = $row['Name'];
					$res['PhoneNumber'] = $row['PhoneNumber'];
					$res['Email'] = $row['Email'];
					$res['Address'] = $row['Address'];
					$res['country_id'] = $row['Country'];
					$country =  $row['Country'];
					$this->db->where('Id', $country);
					$q = $this->db->get('CountryMaster');
					$data = $q->result_array();
					$res['Country'] = $data[0]['Name'];	
				}
				return $res;		  		
		}
		/*
		public function getUserData($id){
			$query = $this->db->query("SELECT * from admin_login where OrganizationId = $id");
			$d=array();
			$res=array();
			 foreach ($query->result() as $row)
			{
				$data=array();
				$data['orgName']=$row->username;
				$data['country']=$row->email;
				$data['email']=$row->name;
				if($row->status == 0){
					$sts = "<b class='alert alert-danger' >Inactive</b>";
				}else{
					$sts = "<b class='alert alert-info' >Active</b>";
				}
				$data['status']=$sts;
				$data['action']='<i class="material-icons edit" data-toggle="modal" title="Edit" data-id="'.$row->id.'"
					 data-username="'.$row->username.'" 
					 data-password="'.$row->password.'" 
					 data-email="'.$row->email.'"
					 data-name="'.$row->name.'"
					 data-status="'.$row->status.'"
					data-target="#addSldE">edit</i> 
					';
				$res[]=$data;
			}  	
			$d['data']=$res;  				
			echo json_encode($d); return false;
		}
		
		public function editUserData(){
			
			$edit_id =  isset($_REQUEST['edit_id'])?$_REQUEST['edit_id']:"";
			$name =  isset($_REQUEST['nameE'])?$_REQUEST['nameE']:"";
			$username =  isset($_REQUEST['usernameE'])?$_REQUEST['usernameE']:"";
			$email =  isset($_REQUEST['emailE'])?$_REQUEST['emailE']:"";
			$status =  isset($_REQUEST['statusE'])?$_REQUEST['statusE']:"0";
			$query = $this->db->query("update admin_login set username='$username', email='$email', name='$name',status=$status where id = $edit_id");
			if($query>0){
				$this->session->set_flashdata('success', "User Updated successfully");
			  }else{
				  $this->session->set_flashdata('error', "some error occurs");
			   }
		}
		
		public function updateOrganizationData($id){

			 $org_name =  isset($_REQUEST['org_name'])?$_REQUEST['org_name']:"";
			 $email =  isset($_REQUEST['email'])?$_REQUEST['email']:"";
			 $phone =  isset($_REQUEST['phone'])?$_REQUEST['phone']:"";
			 $county =  isset($_REQUEST['country'])?$_REQUEST['country']:"0";
			 $address =  isset($_REQUEST['Address'])?$_REQUEST['Address']:"";
             $query = $this->db->query("update Organization set Name='$org_name',PhoneNumber=$phone,Email='$email',Country=$county,Address='$address' where Id = $id");
	          if($query>0){
				 $this->session->set_flashdata('success', "Organization updated successfully"); 
			  }else{
				$this->session->set_flashdata('error', "some error occurs");  
			  }			 
		}
		
		public function getTrialData($id){
          
		        $res1=array();			
				$query1 = $this->db->query("SELECT * FROM trail_info WHERE org_id = $id");
				foreach ($query1->result_array() as $row1)
				{
					
					$res1['id'] = $row1['id'];
					$res1['org_id'] = $row1['org_id'];
					$res1['start_date'] = $row1['start_date'];
					$res1['end_date'] = $row1['end_date'];
					$res1['extended'] = $row1['extended'];
					$res1['status'] = $row1['status'];
					$res1['archive'] = $row1['archive'];
				}
				return $res1;
				
			
				
		}
		
		
		public function trial(){
			$till_date =  $_REQUEST['till_date'];
			$end_date =  $_REQUEST['end_date'];
			$extended_data =  $_REQUEST['extended_data'];
			if($till_date != $end_date){
			 $extended_data =  $extended_data+1;	
			}
			$start_date =  $_REQUEST['start_date'];
			$org_id =  $_REQUEST['org_id'];
			
			$sql = "update trail_info set start_date='$start_date', end_date='$till_date' ,extended=$extended_data , status = 0 where org_id=$org_id";
			$query = $this->db->query($sql);
			
			if($query > 0){
				echo 'true';
			}else{
				echo 'false';
			}
		}
		public function buy(){
			$end_date =  $_REQUEST['end_date'];
			$start_date =  $_REQUEST['start_date'];
			$org_id =  $_REQUEST['org_id'];
			
			$sql = "update trail_info set start_date='$start_date', end_date='$end_date'  , status = 1 where org_id=$org_id";
			$query = $this->db->query($sql);
			
			if($query > 0){
				echo 'true';
			}else{
				echo 'false';
			}
		}
		
		public function trial_days(){
			
			$days = $_REQUEST['days'];
			$sql = "update ubitech_login set trial_days=$days";
			$query = $this->db->query($sql);
			
			if($query > 0){
				echo 'true';
			}else{
				echo 'false';
			}
			
		}
		
		public function get_trial_days(){
			$query = $this->db->query('SELECT * FROM ubitech_login');

				foreach ($query->result_array() as $row)
				{
						return $row['trial_days'];
				}
	
		}
		*/
		
		
		//////Package 
			public function registerPackageData(){

			 $package_name =  isset($_REQUEST['package_name'])?$_REQUEST['package_name']:"";
			 $package_modules =  isset($_REQUEST['package_modules'])?$_REQUEST['package_modules']:"";
			 $package_price_inr_yr =  isset($_REQUEST['package_price_inr_yr'])?$_REQUEST['package_price_inr_yr']:"";
			 $package_price_usd_yr =  isset($_REQUEST['package_price_usd_yr'])?$_REQUEST['package_price_usd_yr']:"0";
			 $package_user_limit =  isset($_REQUEST['package_user_limit'])?$_REQUEST['package_user_limit']:"";
             $query = $this->db->query("insert into package_master_ubiattendance(package_name,package_modules,package_price_inr_yr,package_price_usd_yr,package_user_limit) values('$package_name','$package_modules','$package_price_inr_yr',$package_price_usd_yr,'$package_user_limit')");
	          if($query>0){
				 $this->session->set_flashdata('success', "Package Inserted successfully"); 
			  }else{
				$this->session->set_flashdata('error', "some error occurs");  
			  }			 
		}
		
		public function getPackageData(){
			$query = $this->db->query("SELECT * from package_master_ubiattendance");
			/* $query = $this->db->query("SELECT package_master_ubiattendance.package_id ,package_master_ubiattendance.package_name,
			package_master_ubiattendance.package_modules,
			package_master_ubiattendance.package_price_inr_yr,
			package_master_ubiattendance.package_price_usd_yr,
			package_master_ubiattendance.package_price_inr_hy,
			package_master_ubiattendance.package_price_inr_qt,
			package_master_ubiattendance.package_price_usd_qt,
			package_master_ubiattendance.package_price_inr_mt ,
			package_master_ubiattendance.package_price_usd_mt,
			package_master_ubiattendance.package_user_limit,
			package_master_ubiattendance.package_date_modified,
			package_master_ubiattendance.archive
			 FROM package_master_ubiattendance"); */
			//alert($query);
			$d=array();
			$res=array();
			 foreach ($query->result() as $row)
			{
				$data=array();
				    $data['package_id']=$row->package_id;
					$data['package_name']=$row->package_name;
					$data['package_modules']=$row->package_modules;
					$data['package_price_inr_yr']=$row->package_price_inr_yr;
					$data['package_price_usd_yr']=$row->package_price_usd_yr;
					$data['package_user_limit']=$row->package_user_limit;
				    $data['action']='<i class="material-icons edit" data-toggle="modal" title="View" 
					data-package_id="'.$row->package_id.'" 
					data-package_name="'.$row->package_name.'" 
					data-package_modules="'.$row->package_modules.'"
					data-package_price_inr_yr="'.$row->package_price_inr_yr.'"
					data-package_price_usd_yr="'.$row->package_price_usd_yr.'"
					data-package_user_limit="'.$row->package_user_limit.'"
				    ><a href="'.URL.'BuyPackage/editPackageData/'.$row->Id.'" >visibility</a></i>';
					$res[]=$data;  
			}  	
			 alert($res);
			$d['data']=$res;  				//$query->result();
			echo json_encode($d); return false;
		}
		
		public function getPackageData1($id){
			$query = $this->db->query("SELECT * from package_master_ubiattendance where package_id =$id");
			$num = $query->num_rows();
			if($num > 0){
				$row = $query->row_array();		
			}else{
				$row['message'] =false;
			}
			
			return $row;
			
		}
			

		
		
			
}
?>