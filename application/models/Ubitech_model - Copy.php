
<?php
class Ubitech_model extends CI_Model {
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
		public function login(){
			
			 $username=isset($_REQUEST['username'])?$_REQUEST['username']:'';
			 $password=encrypt(isset($_REQUEST['password'])?$_REQUEST['password']:'');
			 $query = $this->db->query("SELECT * FROM ubitech_login WHERE username= ? and password=? and archive='1'", array($username,$password));
		 if ($query->num_rows()){
			foreach ($query->result() as $row)
			{
					$_SESSION['attendanceAdmin']=true;
					$_SESSION['id']=$row->id;
					$_SESSION['name']=$row->name;
			}
			 
			 return 1;
		 }else{
			 return 0;
		 }
		}
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
					//$data['image']='<img src="'.IMGURL4.'upload/'.$row->filename.'"  style="width:100%!important; "/>';
					$data['image']='<img src="'.URL.'../ubitech/upload/'.$row->filename.'"  style="width:100%!important; "/>';
					$data['status']=$row->archive==1?'<div class="text-center" data-background-color="green">Visible</div>':'<div style="background-color:red;text-align:center;color:white;">
					Invisible</div>';
					if($row->archive==1)
						$data['status']='<div class="text-center" data-background-color="green">Visible to all</div>';
					else if($row->archive==2)
						$data['status']='<div class="text-center" data-background-color="blue">Paid user</div>';
					else if($row->archive==3)
						$data['status']='<div class="text-center" data-background-color="orange">Trial user</div>';
					else 
						$data['status']='<div class="text-center" data-background-color="red">Invisible</div>';
					$data['action']='<i class="material-icons edit" data-toggle="modal" title="Edit" style="cursor:pointer" data-sid="'.$row->id.'"
					 data-id="'.$row->id.'" 
					 data-name="'.$row->name.'" 
					 data-desc="'.$row->description.'"
					 data-link="'.$row->links.'"
					 data-file="'.$row->filename.'"
					 data-sts="'.$row->archive.'"
					data-target="#addSldE">edit</i>
					<i class="material-icons delete1" data-toggle="modal" data-target="#delSld" data-aid="'.$row->id.'" data-image="'.$row->filename.'" title="Delete" style="cursor:pointer">close</i> 
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
		}
		/* add another admin function */
		public function add_admin()
		{
			$contact_person_name = isset($_REQUEST['admin_name'])?$_REQUEST['admin_name']:"";
			$email = isset($_REQUEST['admin_email'])?$_REQUEST['admin_email']:"";
			$password = isset($_REQUEST['admin_pass'])?$_REQUEST['admin_pass']:"";
			$org_id = isset($_REQUEST['orgid1'])?$_REQUEST['orgid1']:"";
			
			$counter=0;
			$sql = "SELECT * FROM Organization where Email = '$email'";
			$this->db->query($sql);
			$counter=$this->db->affected_rows();
			$sql = "SELECT * FROM UserMaster where Username = '".encode5t($email)."'";
			$this->db->query($sql);
			$counter+=$this->db->affected_rows();
			$sql = "SELECT * FROM admin_login where username = '$email' OR 	email = '$email'";
			$this->db->query($sql);
			$counter+=$this->db->affected_rows();
			
			if($counter>0)
			{
				$this->session->set_flashdata('error1', "Email id is already exists");
				return false;
			}
			else
			{
				$username = $email;
				$epassword=encrypt($password);
				$query1 = $this->db->query("insert into admin_login(username,password,email,OrganizationId,name) values('$username','$epassword','$email',$org_id,'$contact_person_name')");
				if($query1>0)
				{
					$this->session->set_flashdata('success1', "Admin add Successfully.");
				    return false;
				}
				else
				{
					$this->session->set_flashdata('error', "some error occurs"); 
				}
			}
			
		}
		public function register_org(){
			// new org reg fun created by vijay singh
			
			$org_name =  isset($_REQUEST['org_name'])?$_REQUEST['org_name']:"";
			$contact_person_name =  isset($_REQUEST['name'])?$_REQUEST['name']:"";
			$email =  isset($_REQUEST['email'])?strtolower(trim($_REQUEST['email'])):"";
			$phone =  isset($_REQUEST['phone'])?$_REQUEST['phone']:"";
			
			$county =  isset($_REQUEST['country'])?$_REQUEST['country']:"0";
			$address =  isset($_REQUEST['Address'])?$_REQUEST['Address']:"";
            $password =  isset($_REQUEST['password'])?$_REQUEST['password']:"123456";
			$countrycode =  isset($_REQUEST['countrycode'])?$_REQUEST['countrycode']:"";
			$date=date('Y-m-d H:i:s');
			$emp_id=0;
			$org_id=0;
			$data=array();
			$data['f_name']=$contact_person_name ;
			$org=explode(" ",$org_name);
			$username= $email;//strtolower("admin@".$org[0].".com");
			$counter=0;
			$counter1=0;
			$sql = "SELECT * FROM Organization where Email = '$email'";
			$this->db->query($sql);
			$counter=$this->db->affected_rows();
			$sql = "SELECT * FROM UserMaster where Username = '".encode5t($email)."'";
			$this->db->query($sql);
			$counter+=$this->db->affected_rows();
			$sql = "SELECT * FROM Organization where PhoneNumber = '$phone'";
			$this->db->query($sql);
			$counter1=$this->db->affected_rows();
			$sql = "SELECT * FROM UserMaster where username_mobile = '".encode5t($phone)."'";
			$this->db->query($sql);
			$counter1+=$this->db->affected_rows();
			if($counter>0){
				//$this->session->set_flashdata('error', "Email id is already exists");
				echo '<script>alert("Email id is already exists"); 
				window.open("'.URL .'ubitech/organization","_self");</script>';
				return false;
			}if($counter1>0){
				echo '<script>alert("Phone no. is already exists"); 
				window.open("'.URL .'ubitech/organization","_self");</script>';
				return false;
			}
			else{
						$data['sts']= "true";
						$TimeZone=0;
					$query = $this->db->query("SELECT * FROM `ZoneMaster` WHERE `CountryId`=$county");
					if($row=$query->result())
					$TimeZone= $row[0]->Id;
					$days=15;
					$emplimit=10;
					
					$addonbulkatt = 0;
					$addonlocationtrack = 0;
					$addonvisit = 0;
					$addongeofence = 0;
					$addonpayroll = 0;
					$addontimeoff = 0;
					$query22 = $this->db->query('SELECT * FROM ubitech_login limit 1');
					
					foreach ($query22->result_array() as $row22)
					{
						$days  = $row22['trial_days'];
						$emplimit  = $row22['user_limit'];
						$addonbulkatt = $row22['bulk_attendance'];
						$addonlocationtrack = $row22['location_tracing'];
						$addonvisit = $row22['visit_punch'];
						$addongeofence = $row22['geo_fence'];
						$addonpayroll = $row22['payroll'];
						$addontimeoff = $row22['time_off'];
					}
				  $query = $this->db->query("insert into Organization(Name,Email,countrycode,PhoneNumber,Country,Address,TimeZone,CreatedDate,LastModifiedDate,NoOfEmp) values ('$org_name','$email','$countrycode','".$phone."',$county,'$address',$TimeZone,'$date','$date',$emplimit)");
				  
				 if($query>0)
				 {
				 $org_id = $this->db->insert_id(); 
				 $zone=getTimeZone($org_id);
				 date_default_timezone_set($zone);
				 $date=date('Y-m-d');
				 
				 $query = $this->db->query("update Organization set CreatedDate=?,LastModifiedDate=? where Id=?",array($date,$date,$org_id));
				
				
				$epassword=encrypt($password);
				$query1 = $this->db->query("insert into admin_login(username,password,email,OrganizationId,name) values('$username','$epassword','$email',$org_id,'$contact_person_name')");
				
				// this code for insert days trial days start //
				
			    $start_date = date('Y-m-d');
				//echo $org_id;
				// create default disable email alert
				$query33 = $this->db->query("INSERT INTO Alert_Settings(OrganizationId, Created_Date) VALUES ($org_id,'$start_date')");
				///////////////////////////////////////
				
			    $end_date = date('Y-m-d', strtotime("+".$days." days"));
				
			    $query33 = $this->db->query("insert into licence_ubiattendance(OrganizationId,start_date,end_date,extended,user_limit,Addon_BulkAttn,Addon_LocationTracking,Addon_VisitPunch,Addon_GeoFence,Addon_Payroll,Addon_TimeOff) values($org_id,'$start_date','$end_date',1,$emplimit,$addonbulkatt,$addonlocationtrack,$addonvisit,$addongeofence,$addonpayroll,$addontimeoff)");
				// this code for insert days trial days end //
				
				//// This Code For Insert ShiftMaster,DepartmentMaster,DesignationMaster Table Start ////
				  $data1 = array(
				  array('Name' => 'Dummy Department','OrganizationId' => $org_id ),
				  array('Name' => 'Human Resource','OrganizationId' => $org_id ),
				  array('Name' => 'Finance','OrganizationId' => $org_id ),
				  array('Name' => 'Marketing','OrganizationId' => $org_id )
				  );
				  $this->db->insert_batch('DepartmentMaster', $data1);
				  
				  $data1 = array(array('Name' => 'Dummy shift','TimeIn'=>'09:00:00','TimeOut'=>'18:00:00','TimeInBreak'=>'13:00:00','TimeOutBreak'=>'13:30:00','OrganizationId' => $org_id));
				  $this->db->insert_batch('ShiftMaster', $data1);
				   $data1 = array(
				   array('Name' => 'Dummy Designation','OrganizationId' => $org_id),
				   array('Name' => 'Manager','OrganizationId' => $org_id),
				   array('Name' => 'HR','OrganizationId' => $org_id),
				   array('Name' => 'Clerk','OrganizationId' => $org_id),
				   array('Name' => 'Trial Designation','OrganizationId' => $org_id));	
				  $this->db->insert_batch('DesignationMaster', $data1);
				////  This Code For Insert ShiftMaster,DepartmentMaster,DesignationMaster Table End ////
				///////////////////////////-----creating default user-start
						$shift='';
						$desg='';
						$dept='';
				$qry = $this->db->query("select Id as shift from ShiftMaster where  OrganizationId=".$org_id." order by id limit 1"); 
				if ($r=$qry->result())
						$shift=$r[0]->shift;;
				$qry = $this->db->query("select Id as dept from DepartmentMaster where  OrganizationId=".$org_id." order by id limit 1"); 
				if ($r=$qry->result())
						$dept=$r[0]->dept;
				$qry = $this->db->query("select Id as desg from DesignationMaster where  OrganizationId=".$org_id." order by id limit 1"); 
				$zone=getTimeZone($org_id);
				 date_default_timezone_set($zone);
				 $date1=date('Y-m-d');
				if ($r=$qry->result())
						    $desg=$r[0]->desg;
							$qry = $this->db->query("insert into EmployeeMaster(DOJ,DOC,FirstName,LastName,countrycode,PersonalNo,Shift,OrganizationId,Department,Designation,CompanyEmail) values('$date1','$date1','$contact_person_name',' ','$countrycode','".encode5t($phone)."',$shift,$org_id,$dept,$desg,'".encode5t($email)."')"); 
							 if($qry>0){ 
								 $emp_id = $this->db->insert_id();
								 $qry1 = $this->db->query("INSERT INTO `UserMaster`(`EmployeeId`,appSuperviserSts, `Password`, `Username`,`OrganizationId`,CreatedDate,LastModifiedDate,username_mobile,archive) VALUES ($emp_id,1,'".encode5t($password)."','".encode5t($email)."',$org_id,'$start_date','$start_date','".encode5t($phone)."',0)");
								 if($qry1>0)
									 $data['id']=$emp_id;
								 $today=date('Y-m-d');
								 for($i=1;$i<8;$i++) // create default weekly off
									$query = $this->db->query("INSERT INTO `ShiftMasterChild`(`ShiftId`,`Day`,`WeekOff`, `OrganizationId`, `ModifiedBy`, `ModifiedDate`) VALUES (?,?,'0,0,0,0,0',?,?,?)",array($shift,$i,$org_id,$emp_id,$today));
								    $data['org_id']=$org_id;
						}
				///////////////////////////-----creating default user-end 
				
				
				if($query1>0){					  
					//  $this->session->set_flashdata('success', "Organization registered	successfully");/* window.open("'.URL .'ubitech/organization","_self"); */
					echo '<script>alert("Organization registered successfully");window.open("'.URL .'ubitech/organization","_self");</script>';
					  $message="<html>
				<head>
				<title>ubiAttendance</title>
				</head>
				<body>Dear ".$contact_person_name."<br/>
				Congratulations!
				Thank you for registering ".$org_name." with us. To complete your organization’s profile please login to http://ubiAttendance.ubihrm.com/ with the following credentials:<br/>
				<b>Admin Login</b><br/>
				Login URL: http://ubiAttendance.ubihrm.com<br/>
				Reference No.: ".encode_vt5($org_id)."<br/>
				User Id: ".$username."<br/>
				Password: ".$password."<br/>
				Your attendance system is already configured and is ready to use. 
				<br/>
				<p>
				<b>Login credentials for app</b><br/>
				Username:	".$email."<br/>
				Password:	123456
				</p>
				Let’s begin by configuring ubiAttendance for your company with trial data. To understand how ubiAttendance works, treat yourself as an employee. For your convenience we have added following data - <br/>
				1.	Trial Shift <br/>
				2.	Trial Department<br/>
				3.	Trial Designation<br/>
				The system has already added you as an employee.
				<p>
				<b>Further Steps</b><br/>
					1.Mark your Attendance.<br/>
					2.Check attendance by clicking the “Attendance log”.<br/>
					3.Configure attendance system by adding actual shifts,departments and designations through the Desktop’s Admin Panel (http://ubiAttendance.ubihrm.com/) or through the mobile app.<br/>
					4. Add employees.<br/>
					5.Start tracking attendance.<br/>
				<p>
				Please feel free to ask any further queries support@ubitechsolutions.com. Thanks !
									</body>
									</html>
					";
					// Always set content-type when sending HTML email
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// More headers
					$headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
					//$headers .= 'Cc: vijay@ubitechsolutions.com' . "\r\n";
					$subject="UbiAttendance Admin Login";
					mail($email,$subject,$message,$headers);
					mail('anita@ubitechsolutions.com',$subject,$message,$headers);
					mail('vijay@ubitechsolutions.com',$subject,$message,$headers);
					mail('nagendra@ubitechsolutions.com',$subject,$message,$headers);
					// echo $admin_id =  $this->db->insert_id();
				
					  return false;
				}
			 }else{
				  //$this->session->set_flashdata('error', "Company could't Register, Try later");
				  echo '<script>alert("Company could not Register, Try later");
				  window.open("'.URL .'ubitech/organization","_self");</script>';
				  return false;
			 }
			  
			}
			/* /// old registration fun made by palash 
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
			  */
		}
		public function getExtrauserOrg()
		{
			$query = $this->db->query("SELECT NoOfEmp,Name,Email,Id,Country,PhoneNumber,Address, (select count(Id) from UserMaster where UserMaster.OrganizationId = Organization.Id ) as users FROM Organization Having users > NoOfEmp ");
			$res = array();
			foreach ($query->result() as $row)
			{
				$data = array();
				$data['allowusers'] = $row->NoOfEmp;
				$data['orgname'] = $row->Name;
				$data['users'] = $row->users;
				$data['extuser'] = ($row->users)-($row->NoOfEmp);
				$data['email'] = $row->Email;
				$data['action']='<i class="material-icons edit" data-toggle="modal" title="View" 
					data-id="'.$row->Id.'" 
					data-orgname="'.$row->Name.'" 
					data-country="'.$row->Country.'"
					data-email="'.$row->Email.'"
					data-phonenumber="'.$row->PhoneNumber.'"
					data-address="'.$row->Address.'"><a href="'.URL.'ubitech/editOrganizationData/'.$row->Id.'/'.'3.9'.'" >visibility</a></i> ';
				$res[] = $data;
			}
			$d['data'] = $res;
			echo json_encode($d);
		}
		
		public function getOrganizationData($val)
		{
			$countype = isset($_REQUEST['conttype'])?$_REQUEST['conttype']:"0";
			$date = isset($_REQUEST['date'])?$_REQUEST['date']:"";
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
				$q= "AND licence_ubiattendance.status= '0' AND '$todaydate' > licence_ubiattendance.end_date AND Organization.customize_org = 0 and delete_sts=0";
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
			 else if($val == 'all')
			 {
				$q = "AND Organization.customize_org=0 and delete_sts=0"; 
				   if($date != "")
				 {
						$arr=explode('-',trim($date));
						$enddate = date('Y-m-d',strtotime($arr[1]));
						$strtdate= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3)));  
						$q .= " AND  Organization.CreatedDate BETWEEN  '$strtdate' AND '$enddate'";
				 }
				 else
				 {
					 $date = date('Y-m-d');
					 $enddate = date('Y-m-d');
					 $strtdate= date('Y-m-d',strtotime('-7 days',strtotime($date)));
					 $q .= " AND  Organization.CreatedDate BETWEEN ' $strtdate' AND '$enddate'";
				 }
                $pageid=3.5;				 
			 }
			 
			  if($countype == 2){
				  
			 	$q.= " AND Organization.Country = 93";
			 }else if($countype == 1){
				 
			 	$q.= " AND Organization.Country != 93";
			 }
			 
			 
			
			$query = $this->db->query("SELECT Organization.Id, Organization.mail_unsubscribe,Organization.Name ,Organization.Country ,Organization.Email ,Organization.PhoneNumber,Organization.NoOfEmp ,Organization.Address, admin_login.name, admin_login.password as pwd,mail_varified, date(CreatedDate) as cdate 
            ,licence_ubiattendance.status as sstts ,(SELECT count(Id)  FROM `UserMaster` WHERE UserMaster.OrganizationId=Organization.Id)as noemp,(SELECT `end_date`  FROM `licence_ubiattendance` WHERE licence_ubiattendance.OrganizationId=Organization.Id)as edate,(SELECT `due_amount`  FROM `licence_ubiattendance` WHERE licence_ubiattendance.OrganizationId=Organization.Id)as dueamount,(SELECT `start_date`  FROM `licence_ubiattendance` WHERE licence_ubiattendance.OrganizationId=Organization.Id)as sdate FROM Organization
            INNER JOIN admin_login ON Organization.	Id = admin_login.OrganizationId 
            INNER JOIN licence_ubiattendance ON Organization.Id = licence_ubiattendance.OrganizationId $q group by Organization.Id "); 
			/*echo $q;
			return false;*/
			/* 
			$query = $this->db->query("SELECT Organization.Id ,Organization.Name ,Organization.Country ,Organization.Email ,Organization.PhoneNumber ,Organization.Address, (select admin_login.name from admin_login where admin_login.OrganizationId=Organization.Id limit 1) as cname, (select admin_login.password from admin_login where admin_login.OrganizationId=Organization.Id limit 1) as pwd,mail_varified, date(CreatedDate) as cdate 
            ,(select licence_ubiattendance.status from licence_ubiattendance where licence_ubiattendance.OrganizationId=Organization.Id limit 1) as sstts,(SELECT count(Id)  FROM `UserMaster` WHERE UserMaster.OrganizationId=Organization.Id limit 1)as noemp,(SELECT `end_date`  FROM `licence_ubiattendance` WHERE licence_ubiattendance.OrganizationId=Organization.Id limit 1)as edate,(SELECT `start_date`  FROM `licence_ubiattendance` WHERE licence_ubiattendance.OrganizationId=Organization.Id limit 1)as sdate FROM Organization,licence_ubiattendance 
             $q 
			");*/
		//	echo json_encode($query->result());
			// return false;
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
					$data['change']='<input type="checkbox" name="chk"  id="'.$row->Id.'" class="checkbox"  value="'.$row->Id.'" style="padding-top:30px">';
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
					$data['emailstatus']=($row-> mail_varified==0)?'<div class="text-center"  data-background-color="red">Pending</div>':'<div class="text-center"  data-background-color="green">Verified</div>';
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
					if($row-> mail_varified==0)
						$data['action'].='<a href="'.URL.'services/activateOrg?iuser='.encrypt($row->Id).'" target="_blank"><i style="color:red" title="Verify account" class="material-icons edit" >done</i></a>';
					else
						$data['action'].='<i style="color:green" title="Account verified" class="material-icons edit" >done_all</i>';
					
					if($val=='archive')
						//$data['action'].='';
						$data['action'].='<a><i data-id="'.$row->Id.'" 
					data-orgname="'.$row->Name.'"  style="color:red;cursor:pointer" title="Permanently Delete Organization" class="material-icons delete_p" >delete</i></a><a><i data-id="'.$row->Id.'" 
					data-orgname="'.$row->Name.'"  style="color:blue;cursor:pointer" title="Unarchive Organization" class="material-icons delete_a" >unarchive</i></a>';
					
					else
						$data['action'].='<a><i data-id="'.$row->Id.'" 
					data-orgname="'.$row->Name.'"  style="color:orange;cursor:pointer" title="Archive Organization" class="material-icons delete" >archive</i></a>';
					
					
					
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
					else if($val=='notrenew')
					{
					$data['action'].='<a>&nbsp;&nbsp;<i data-id="'.$row->Id.'" 
					data-orgname="'.$row->Name.'"  style="color:orange;cursor:pointer;font-size:20px" title="Undo Not Renew" class="fa fa-undo renew" ></i></a>';
					}
					if($row->mail_unsubscribe==0)
						$data['action'].='<a href="'.URL.'cron/unsubscribeOrgMails/'.$row->Id.'" target="_blank"><i style="color:red" title="Unsubscribe" class="material-icons unsubscribe">unsubscribe</i></a>';	//to unsubscribe mails
					
					$res[]=$data;
					$flag=0;
			}  	
			
			$d['data']=$res;  				//$query->result();
			echo json_encode($d); return false;
			
		}
		/* get unsubscribe organization  */
		public function getunsubscribe()
		{
			$q = " AND  `Organization`.`mail_unsubscribe`='1' ";
			$todaydate = date("Y-m-d");
			$query = $this->db->query("SELECT Organization.Id ,Organization.Name ,Organization.Country ,Organization.Email ,Organization.PhoneNumber ,Organization.Address, admin_login.name, admin_login.password as pwd,mail_varified, date(CreatedDate) as cdate,licence_ubiattendance.status as sstts ,(SELECT count(Id)  FROM `UserMaster` WHERE UserMaster.	OrganizationId=Organization.Id)as noemp,(SELECT `end_date`  FROM `licence_ubiattendance` WHERE licence_ubiattendance.OrganizationId=Organization.Id)as edate,(SELECT `start_date`  FROM `licence_ubiattendance` WHERE licence_ubiattendance.OrganizationId=Organization.Id)as sdate FROM Organization
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
					$data['emailstatus']=($row-> mail_varified==0)?'<div class="text-center"  data-background-color="red">Pending</div>':'<div class="text-center"  data-background-color="green">Verified</div>';
					// this code for cunsulting person name end //
					$data['action']='<i class="material-icons edit" data-toggle="modal" title="View" 
					data-id="'.$row->Id.'" 
					data-orgname="'.$row->Name.'" 
					data-country="'.$row->Country.'"
					data-email="'.$row->Email.'"
					data-phonenumber="'.$row->PhoneNumber.'"
					data-address="'.$row->Address.'"
					data-name="'.$row->name.'"
					><a href="'.URL.'ubitech/editOrganizationData/'.$row->Id .'/'.'3.11'.'" >visibility</a></i> ';
					if($row-> mail_varified==0)
						$data['action'].='<a href="'.URL.'services/activateOrg?iuser='.encrypt($row->Id).'" target="_blank"><i style="color:red" title="Verify account" class="material-icons edit" >done</i></a>';
					else
						$data['action'].='<i style="color:green" title="Account verified" class="material-icons edit" >done_all</i>';
					
					/*if($val=='archive')
						//$data['action'].='';
						$data['action'].='<a><i data-id="'.$row->Id.'" 
					data-orgname="'.$row->Name.'"  style="color:red;cursor:pointer" title="Permanently Delete Organization" class="material-icons delete_p" >delete</i></a>';
					else
						$data['action'].='<a><i data-id="'.$row->Id.'" 
					data-orgname="'.$row->Name.'"  style="color:orange;cursor:pointer" title="Archive Organization" class="material-icons delete" >delete</i></a>';*/
					
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
					
					
					$res[]=$data;
					$flag=0;
			}  	
			
			$d['data']=$res;  				//$query->result();
			echo json_encode($d); return false;
		}
		public function archiveOrg()
		{
			$did=isset($_REQUEST['did'])?$_REQUEST['did']:'';
			$data=array();
			$query = $this->db->query("UPDATE `Organization` SET `delete_sts`=1 WHERE `Id`=?",array($did));
			$data['afft']=$this->db->affected_rows();
			 $this->db->close();
			echo json_encode($data);	
		}
		public function archiveAllOrg()
		{
			$favorite =  isset($_REQUEST['favorite'])?$_REQUEST['favorite']:0;
			$favorite1=implode(",",$favorite);
			$data=array();
			$query = $this->db->query("UPDATE Organization SET `delete_sts`=1 WHERE `Id`IN ($favorite1)");
			echo $query;
			if($query==true)
			{
				return true;
			}
			else
			{
				return false;
			}	
		}
		public function DeleteAllOrg()
		{
			$favorite =  isset($_REQUEST['favorite'])?$_REQUEST['favorite']:0;
			$favorite1=implode(",",$favorite);
			$data=array();
			$query = $this->db->query("DELETE FROM `AttendanceMaster` WHERE `OrganizationId` in($favorite1)");
			
			$query = $this->db->query("DELETE FROM `Organization` WHERE Id in ($favorite1)");
			
			$query = $this->db->query("DELETE FROM `admin_login` WHERE `OrganizationId` in ($favorite1)");
			$query = $this->db->query("DELETE FROM `BreakMaster` WHERE `OrganizationId` in ($favorite1)");
			$query = $this->db->query("DELETE FROM `DepartmentMaster` WHERE `OrganizationId` in ($favorite1)");
			$query = $this->db->query("DELETE FROM `DesignationMaster` WHERE `OrganizationId` in ($favorite1)");
			$query = $this->db->query("DELETE FROM `EmployeeMaster` WHERE `OrganizationId` in ($favorite1)");
			$query = $this->db->query("DELETE FROM `licence_ubiattendance` WHERE `OrganizationId` in ($favorite1)");
			$query = $this->db->query("DELETE FROM `ShiftMaster` WHERE `OrganizationId` in ($favorite1)");
			$query = $this->db->query("DELETE FROM `UserMaster` WHERE `OrganizationId` in ($favorite1)");
			
			$query = $this->db->query("DELETE FROM `WeekOffMaster` WHERE `OrganizationId` in ($favorite1)");
			$query = $this->db->query("DELETE FROM `Timeoff` WHERE `OrganizationId` in ($favorite1)");
			
			$query = $this->db->query("DELETE FROM `checkin_master` WHERE `OrganizationId` in ($favorite1)");
			$query = $this->db->query("DELETE FROM `Alert_Settings` WHERE `OrganizationId` in ($favorite1)");
			echo $query;
			if($query==true)
			{
				return true;
			}
			else
			{
				return false;
			}	
		}
		

		
		
		
		
		
		
		
		
		
		
		public function unarchiveOrg()
		{
			$did=isset($_REQUEST['did'])?$_REQUEST['did']:'';
			$data=array();
			$query = $this->db->query("UPDATE `Organization` SET `delete_sts`=0 WHERE `Id`=?",array($did));
			$data['afft']=$this->db->affected_rows();
			 $this->db->close();
			echo json_encode($data);	
		}
		
		
		
		public function notrenedOrg()
		{
			$did=isset($_REQUEST['did'])?$_REQUEST['did']:'';
			$data=array();
			$query = $this->db->query("UPDATE `Organization` SET `delete_sts`=2 WHERE `Id`=?",array($did));
			$data['afft']=$this->db->affected_rows();
			 $this->db->close();
			echo json_encode($data);	
		}
		public function renedOrg()
		{
			$did=isset($_REQUEST['did'])?$_REQUEST['did']:'';
			$data=array();
			$query = $this->db->query("UPDATE `Organization` SET `delete_sts`=0 WHERE `Id`=?",array($did));
			$data['afft']=$this->db->affected_rows();
			 $this->db->close();
			echo json_encode($data);	
		}
		public function archiveOrg_del()
		{
			$did=isset($_REQUEST['did'])?$_REQUEST['did']:'';
			$data=array();
			$data['afft']=0;
			$query = $this->db->query("DELETE FROM `AttendanceMaster` WHERE `OrganizationId` in (?)",array($did));
			$data['afft']+=$this->db->affected_rows();
			$query = $this->db->query("DELETE FROM `Organization` WHERE Id in (?)",array($did));
			$data['afft']+=$this->db->affected_rows();
			$query = $this->db->query("DELETE FROM `admin_login` WHERE `OrganizationId` in (?)",array($did));
			$data['afft']+=$this->db->affected_rows();
			$query = $this->db->query("DELETE FROM `BreakMaster` WHERE `OrganizationId` in (?)",array($did));
			$data['afft']+=$this->db->affected_rows();
			$query = $this->db->query("DELETE FROM `DepartmentMaster` WHERE `OrganizationId` in (?)",array($did));
			$data['afft']+=$this->db->affected_rows();
			$query = $this->db->query("DELETE FROM `DesignationMaster` WHERE `OrganizationId` in (?)",array($did));
			$data['afft']+=$this->db->affected_rows();
			$query = $this->db->query("DELETE FROM `EmployeeMaster` WHERE `OrganizationId` in (?)",array($did));
			$data['afft']+=$this->db->affected_rows();
			$query = $this->db->query("DELETE FROM `licence_ubiattendance` WHERE `OrganizationId` in (?)",array($did));
			$data['afft']+=$this->db->affected_rows();
			$query = $this->db->query("DELETE FROM `ShiftMaster` WHERE `OrganizationId` in (?)",array($did));
			$data['afft']+=$this->db->affected_rows();
			$query = $this->db->query("DELETE FROM `UserMaster` WHERE `OrganizationId` in (?)",array($did));
			$data['afft']+=$this->db->affected_rows();
			$query = $this->db->query("DELETE FROM `WeekOffMaster` WHERE `OrganizationId` in (?)",array($did));
			$data['afft']+=$this->db->affected_rows();
			$query = $this->db->query("DELETE FROM `Timeoff` WHERE `OrganizationId` in (?)",array($did));
			$data['afft']+=$this->db->affected_rows();
			$query = $this->db->query("DELETE FROM `checkin_master` WHERE `OrganizationId` in (?)",array($did));
			$data['afft']+=$this->db->affected_rows();
			$query = $this->db->query("DELETE FROM `Alert_Settings` WHERE `OrganizationId` in (?)",array($did));
			$data['afft']+=$this->db->affected_rows();
			 $this->db->close();
			echo json_encode($data);	
		}
		
		 public function expiredOrganization()
		 {
		 	$countype = isset($_REQUEST['conttype'])?$_REQUEST['conttype']:"0";
		 	 $q = "";
		 	 
		 	 if($countype == 2){
			 	$q.= " AND Organization.Country=93";
			 }else if($countype == 1){
			 	$q.= " AND Organization.Country != 93";
			 }
			 $todaydate = date("Y-m-d");
			$query = $this->db->query("SELECT Organization.Id ,Organization.Name ,Organization.Country ,Organization.Email ,Organization.PhoneNumber ,Organization.Address, admin_login.name, admin_login.password as pwd,mail_varified, date(CreatedDate) as cdate 
            ,licence_ubiattendance.status as sstts ,(SELECT count(Id)  FROM `UserMaster` WHERE UserMaster.	OrganizationId=Organization.Id)as noemp,licence_ubiattendance.end_date as edate,licence_ubiattendance.start_date as sdate FROM Organization
            INNER JOIN admin_login ON Organization.	Id = admin_login.OrganizationId 
            INNER JOIN licence_ubiattendance ON Organization.Id = licence_ubiattendance.OrganizationId AND licence_ubiattendance.status= '1' $q AND '$todaydate' > licence_ubiattendance.end_date 
			");
			$d=array();
			$res=array();
			$today=date('Y-m-d');
			 foreach ($query->result() as $row)
			{
					$varify='';
					$data=array();
					$orgid = $row->Id;
					$count = 0;
					$endid = date('Y-m-d',strtotime($row->edate));
				//	$query1 = $this->db->query("SELECT MAX(AttendanceMaster.AttendanceDate) as atdate,MAX(UserMaster.CreatedDate) as crdate FROM AttendanceMaster FULL OUTER JOIN UserMaster ON AttendanceMaster.OrganizationId = UserMaster.OrganizationId AND AttendanceMaster.OrganizationId = $orgid AND UserMaster.OrganizationId =$orgid AND AttendanceMaster.AttendanceDate > '$endid' AND UserMaster.CreatedDate > '$endid'");
					$where = array('OrganizationId'=>$orgid,'AttendanceDate >'=>$endid);
					 $this->db->select_max('AttendanceDate');
					$this->db->where($where);
					//$this->db->where('AttendanceDate >', $endid );
					$q = $this->db->get('AttendanceMaster');
					 $data0 = $q->result_array();
					 $date0 = $data0[0]['AttendanceDate'];
					//$count = $this->db->affected_rows();
					//if($count==0)
					//{
					 $this->db->select_max('CreatedDate');
					 $where1 = array('OrganizationId'=>$orgid,'CreatedDate >', $endid);
					 $this->db->where($where1);
					 $q1 = $this->db->get('UserMaster');
					 $data1 = $q1->result_array();
					 $date1 = $data1[0]['CreatedDate'];
					 //$count1 = $this->db->affected_rows();	
					//}
					if($date0 !="" || $date1 != "")
					{
						if(strtotime($date1)>strtotime($date0))
						$data['lastactivedate'] = date('Y-m-d',strtotime($date1));
					    else
						$data['lastactivedate'] = date('Y-m-d',strtotime($date0));
					    $date11=date_create($data['lastactivedate']);
						$d1 = date("Y-m-d");
						$date22=date_create($d1);
						$diff=date_diff($date11,$date22);
						$a =  $diff->format("%R%a");
					if($a <= 15)
					{
					$data['orgName']=$row->Name;
					$data['address']=$row->Address;
					$data['noemp']=$row->noemp;
					$data['ref_no']=(($row->Id)*($row->Id))+99;
					$data['rdate']=date('Y-m-d',strtotime($row->cdate));
					$data['sdate']=date('Y-m-d',strtotime($row->sdate));
					$data['edate']=$data['edate']='<div title="Active Subscription " class="text-center" data-background-color="green">'.date('Y-m-d',strtotime($row->edate)).'</div>';
				/*	if($today > $row->edate)
						$data['edate']='<div title="Subscription expired" class="text-center" data-background-color="red">'.date('Y-m-d',strtotime($row->edate)).'</div>';
					
					if($row->sstts==1)
						$data['sstts']='<div title="Paid subscription " class="text-center"  data-background-color="green">Paid</div>';
					else if($row->sstts==2)
						$data['sstts']='<div title="
					Subscription Expired" class="text-center" data-background-color="red">Expired</div>';
					else
						$data['sstts']='<div title="Subscription is under trial period" class="text-center" data-background-color="orange">Trial</div>';*/
					$country =  $row->Country;
					// this code for get a country start////
					$this->db->where('Id', $country);
					$q = $this->db->get('CountryMaster');
					$data1 = $q->result_array();
					$data['country'] = $data1[0]['Name'];
					// this code for get a country end ////
					$data['email']=$row->Email;
					// this code for cunsulting person name start //
					/*$id = $row->Id;
					$this->db->where('OrganizationId', $id);
					$q2 = $this->db->get('admin_login');
					$data2 = $q2->result_array();*/
					$data['c_nmae'] = $row->name;
					//$data['pass'] = decrypt($data2[0]['password']);
					$data['pass'] = decrypt($row->pwd);
					$data['PhoneNumber']=$row->PhoneNumber;
					$data['emailstatus']=($row-> mail_varified==0)?'<div class="text-center"  data-background-color="red">Pending</div>':'<div class="text-center"  data-background-color="green">Verified</div>';
					// this code for cunsulting person name end //
					$data['action']='<i class="material-icons edit" data-toggle="modal" title="View" 
					data-id="'.$row->Id.'" 
					data-orgname="'.$row->Name.'" 
					data-country="'.$row->Country.'"
					data-email="'.$row->Email.'"
					data-phonenumber="'.$row->PhoneNumber.'"
					data-address="'.$row->Address.'"
					data-name="'.$row->name.'"
					><a href="'.URL.'ubitech/editOrganizationData/'.$row->Id.'" >visibility</a></i> ';
					if($row-> mail_varified==0)
						$data['action'].='<a href="'.URL.'services/activateOrg?iuser='.encrypt($row->Id).'" target="_blank"><i style="color:red" title="Verify account" class="material-icons edit" >done</i></a>';
					else
						$data['action'].='<i style="color:green" title="Account verified" class="material-icons edit" >done_all</i>';
					$res[]=$data;
				}
			  }
			}  	
			$d['data']=$res;  				//$query->result();
			echo json_encode($d); return false;
		 }
		 
		 public function expiredOrganization_old()
		 {
			
			 $todaydate = date("Y-m-d");
			$query = $this->db->query("SELECT Organization.Id ,Organization.Name ,Organization.Country ,Organization.Email ,Organization.PhoneNumber ,Organization.Address, admin_login.name, admin_login.password as pwd,mail_varified, date(CreatedDate) as cdate 
            ,licence_ubiattendance.status as sstts ,(SELECT count(Id)  FROM `UserMaster` WHERE UserMaster.	OrganizationId=Organization.Id)as noemp,licence_ubiattendance.end_date as edate,licence_ubiattendance.start_date as sdate FROM Organization
            INNER JOIN admin_login ON Organization.	Id = admin_login.OrganizationId 
            INNER JOIN licence_ubiattendance ON Organization.Id = licence_ubiattendance.OrganizationId AND licence_ubiattendance.status= '0' AND '$todaydate' > licence_ubiattendance.end_date 
			");
			$d=array();
			$res=array();
			$today=date('Y-m-d');
			 foreach ($query->result() as $row)
			{
					$varify='';
					$data=array();
					$orgid = $row->Id;
					$count = 0;
					$endid = date('Y-m-d',strtotime($row->edate));
				//	$query1 = $this->db->query("SELECT MAX(AttendanceMaster.AttendanceDate) as atdate,MAX(UserMaster.CreatedDate) as crdate FROM AttendanceMaster FULL OUTER JOIN UserMaster ON AttendanceMaster.OrganizationId = UserMaster.OrganizationId AND AttendanceMaster.OrganizationId = $orgid AND UserMaster.OrganizationId =$orgid AND AttendanceMaster.AttendanceDate > '$endid' AND UserMaster.CreatedDate > '$endid'");
					$where = array('OrganizationId'=>$orgid,'AttendanceDate >'=>$endid);
					 $this->db->select_max('AttendanceDate');
					$this->db->where($where);
					//$this->db->where('AttendanceDate >', $endid );
					$q = $this->db->get('AttendanceMaster');
					 $data0 = $q->result_array();
					 $date0 = $data0[0]['AttendanceDate'];
					//$count = $this->db->affected_rows();
					//if($count==0)
					//{
					 $this->db->select_max('CreatedDate');
					 $where1 = array('OrganizationId'=>$orgid,'CreatedDate >', $endid);
					 $this->db->where($where1);
					 $q1 = $this->db->get('UserMaster');
					 $data1 = $q1->result_array();
					 $date1 = $data1[0]['CreatedDate'];
					 //$count1 = $this->db->affected_rows();	
					//}
					if($date0 !="" || $date1 != "")
					{
						if(strtotime($date1)>strtotime($date0))
						$data['lastactivedate'] = date('Y-m-d',strtotime($date1));
					    else
						$data['lastactivedate'] = date('Y-m-d',strtotime($date0));
					    $date11=date_create($data['lastactivedate']);
						$d1 = date("Y-m-d");
						$date22=date_create($d1);
						$diff=date_diff($date11,$date22);
						$a =  $diff->format("%R%a");
					if($a <= 15)
					{
					$data['orgName']=$row->Name;
					$data['address']=$row->Address;
					$data['noemp']=$row->noemp;
					$data['ref_no']=(($row->Id)*($row->Id))+99;
					$data['rdate']=date('Y-m-d',strtotime($row->cdate));
					$data['sdate']=date('Y-m-d',strtotime($row->sdate));
					$data['edate']=$data['edate']='<div title="Active Subscription " class="text-center" data-background-color="green">'.date('Y-m-d',strtotime($row->edate)).'</div>';
				/*	if($today > $row->edate)
						$data['edate']='<div title="Subscription expired" class="text-center" data-background-color="red">'.date('Y-m-d',strtotime($row->edate)).'</div>';
					
					if($row->sstts==1)
						$data['sstts']='<div title="Paid subscription " class="text-center"  data-background-color="green">Paid</div>';
					else if($row->sstts==2)
						$data['sstts']='<div title="
					Subscription Expired" class="text-center" data-background-color="red">Expired</div>';
					else
						$data['sstts']='<div title="Subscription is under trial period" class="text-center" data-background-color="orange">Trial</div>';*/
					$country =  $row->Country;
					// this code for get a country start////
					$this->db->where('Id', $country);
					$q = $this->db->get('CountryMaster');
					$data1 = $q->result_array();
					$data['country'] = $data1[0]['Name'];
					// this code for get a country end ////
					$data['email']=$row->Email;
					// this code for cunsulting person name start //
					/*$id = $row->Id;
					$this->db->where('OrganizationId', $id);
					$q2 = $this->db->get('admin_login');
					$data2 = $q2->result_array();*/
					$data['c_nmae'] = $row->name;
					//$data['pass'] = decrypt($data2[0]['password']);
					$data['pass'] = decrypt($row->pwd);
					$data['PhoneNumber']=$row->PhoneNumber;
					$data['emailstatus']=($row-> mail_varified==0)?'<div class="text-center"  data-background-color="red">Pending</div>':'<div class="text-center"  data-background-color="green">Verified</div>';
					// this code for cunsulting person name end //
					$data['action']='<i class="material-icons edit" data-toggle="modal" title="View" 
					data-id="'.$row->Id.'" 
					data-orgname="'.$row->Name.'" 
					data-country="'.$row->Country.'"
					data-email="'.$row->Email.'"
					data-phonenumber="'.$row->PhoneNumber.'"
					data-address="'.$row->Address.'"
					data-name="'.$row->name.'"
					><a href="'.URL.'ubitech/editOrganizationData/'.$row->Id.'" >visibility</a></i> ';
					if($row-> mail_varified==0)
						$data['action'].='<a href="'.URL.'services/activateOrg?iuser='.encrypt($row->Id).'" target="_blank"><i style="color:red" title="Verify account" class="material-icons edit" >done</i></a>';
					else
						$data['action'].='<i style="color:green" title="Account verified" class="material-icons edit" >done_all</i>';
					$res[]=$data;
				}
			  }
			}  	
			$d['data']=$res;  				//$query->result();
			echo json_encode($d); return false;
		 }
		 
		 
		 
		public function getOrganization(){
			
			///$query = $this->db->query("SELECT Organization.Id ,Organization.Name, Organization.Country ,Organization.Email ,Organization.PhoneNumber ,Organization.Address, admin_login.name
           // FROM Organization
           // INNER JOIN admin_login ON Organization.	Id = admin_login.OrganizationId;");
		   $query = $this->db->query("SELECT * FROM  `Organization` WHERE Id IN (SELECT OrganizationId FROM licence_ubiattendance)");
			$d=array();
			$res=array();
					//$week =	explode(",",$row[0]->WeekOff);
			 foreach ($query->result() as $row)
			{
				$data=array();
					
					$Id=$row->Id;
					$query1 = $this->db->query("SELECT * FROM  `licence_ubiattendance` WHERE OrganizationId	= $Id ");	
			      if( $row1=$query1->row()){
				   //$sdate =$row1->start_date;
				   //$edate =$row1->end_date;
				   $data['orgName']=$row->Name;
					$data['Id']=$row->Id;
				  $data['sdate'] =$row1->start_date;
				  $data['edate'] =$row1->end_date;
				   $data['now'] =date("Y-m-d");
				  
				  $date1 = new DateTime($data['now']);  //current date or any date
                  $date2 = new DateTime($data['edate']);   //gave end date
                  $diff = $date2->diff($date1)->format("%a");  //find difference
                  $data['remaindays'] = intval($diff);   //rounding days
                  //echo $days;
				  if( $data['now'] > $data['edate']){
					  $data['remaindays']="expired";
					  
				  }
					//$data['ref_no']=(($row->Id)*($row->Id))+99;
				  }//$country =  $row->Country;
					// this code for get a country start////
					//$this->db->where('Id', $country);
					//$q = $this->db->get('CountryMaster');
					////$data1 = $q->result_array();
					//$data['country'] = $data1[0]['Name'];
					// this code for get a country end ////
					//$data['email']=$row->Email;
					// this code for cunsulting person name start //
					//$id = $row->Id;
					//$this->db->where('OrganizationId', $id);
					//$q2 = $this->db->get('admin_login');
					//$data2 = $q2->result_array();
					//$data['c_nmae'] = $data2[0]['name'];
					//$data['PhoneNumber']=$row->PhoneNumber;
					// this code for cunsulting person name end //
					
					$res[]=$data;
			}  	
			$d['data']=$res;  				//$query->result();
			echo json_encode($d); return false;
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
					$res['orgtype'] = $row['customize_org'];
					$res['country_id'] = $row['Country'];
					$res['userLimit'] = $row['NoOfEmp'];
					
					$country =  $row['Country'];
					$this->db->where('Id', $country);
					$q = $this->db->get('CountryMaster');
					$res['activeUsers']=0;
					$query = $this->db->query("select count(id) as activeUsers from UserMaster where OrganizationId = $id");
					if($row =$query->result_array())
						$res['activeUsers']=$row[0]['activeUsers'];
					$data = $q->result_array();
					$res['Country'] = $data[0]['Name'];	
					$qry = $this->db->query("SELECT * from payments_invoice where OrganizationId='$id' order by Id DESC limit 1");
					    $res['city'] = "";
						$res['state'] = "";
						$res['gst'] = "";
						$res['tax'] = "";
						$res['currency'] = "";
						$res['discount'] = "";
						$res['paymentamount'] = "";
						$res['txnid'] = "";
					foreach($qry->result() as $rw)
					{
						$res['city'] = $rw->city;
						$res['state'] = $rw->state;
						$res['gst'] = $rw->gstin;
						$res['tax'] = $rw->tax;
						$res['currency'] = $rw->currency;
						$res['discount'] = $rw->discount;
						$res['paymentamount'] = $rw->payment_amount+$res['tax'];
						$res['txnid'] = $rw->txnid;
						
					}
				}
				$query = $this->db->query("select due_amount,Addon_BulkAttn,Addon_LocationTracking,Addon_VisitPunch,Addon_GeoFence,Addon_Payroll,Addon_TimeOff,Addon_flexi_shif from licence_ubiattendance where OrganizationId = $id");
				if($row = $query->result())
					$res['due']=$row[0]->due_amount;
				    $res['attendanceadon'] = $row[0]->Addon_BulkAttn;
				    $res['locationtracking'] = $row[0]->Addon_LocationTracking;
				    $res['visitpunch'] = $row[0]->Addon_VisitPunch;
				    $res['geofence'] = $row[0]->Addon_GeoFence;
				    $res['payroll'] = $row[0]->Addon_Payroll;
				    $res['timeoff'] = $row[0]->Addon_TimeOff;
				    $res['flexi'] = $row[0]->Addon_flexi_shif;
				
				$query = $this->db->query("select name from admin_login where OrganizationId = $id");
				if($row = $query->result())
					$res['contectperson']=$row[0]->name;
				return $res;		  		
		}
		public function getallState(){
			$query = $this->db->query("SELECT * FROM state_gst ORDER BY name");
			$states=array();
			$codes=array();
			foreach ($query->result() as $row)
				{
					$states['name'][]=$row->name;
					$codes['code'][]=$row->code;
					
				}$data['states']=$states;
				$data['codes']=$codes;
				
				return $data;
		}
		public function getUserData($id){

			$query = $this->db->query("SELECT * from admin_login where OrganizationId = $id");
			$d=array();
			$res=array();
			 foreach ($query->result() as $row)
			  {
				$data=array();
				$data['orgName']=$row->username;
				$data['email']=$row->email;
				$data['name']=$row->name;
				$data['password']=decrypt($row->password);
				if($row->status == 0){
					$sts = "<b class='alert alert-danger' >Inactive</b>";
				}else{
					$sts = "<b class='alert alert-info' >Active</b>";
				}
				$data['status']=$sts;
				$data['action']='<i class="material-icons edit" style="cursor: pointer;" data-toggle="modal" title="View/Edit" data-id="'.$row->id.'"
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
		
		
		
		
	public function getstorepath(){
			$result1=array();
			$res1=array();
		
			$query = $this->db->query("SELECT * FROM PlayStore WHERE orgid=0");
			foreach ($query->result_array() as $row)
			{
				
				$res1['googlepath'] =   $row['googlepath'];
				$res1['applepath'] = 	 $row['applepath'];
				$res1['androidversion'] = 	 $row['android_version'];
				$res1['iosversion'] = 	 $row['ios_version'];
				$res1['is_mandatory_android'] = $row['is_mandatory_android'];
				$res1['is_mandatory_ios'] = 	 $row['is_mandatory_ios'];
			}
			
			$result1 = $res1;
			return $result1;
		}
		public function updatePath()
		{
			$googlepath = isset($_REQUEST['googlepath'])?$_REQUEST['googlepath']:'';
			$applepath = isset($_REQUEST['applepath'])?$_REQUEST['applepath']:'';
			$iosversion = isset($_REQUEST['iosversion'])?$_REQUEST['iosversion']:'';
			$androidversion = isset($_REQUEST['androidversion'])?$_REQUEST['androidversion']:'';
			$checkbox1 = isset($_REQUEST['checkbox1'])?$_REQUEST['checkbox1']:'';
			$checkbox2 = isset($_REQUEST['checkbox2'])?$_REQUEST['checkbox2']:'';
			if($googlepath!='' || $applepath!='' || $iosversion!='' || $androidversion)
			{
				$query = $this->db->query("update PlayStore set googlepath='$googlepath', applepath='$applepath',android_version='$androidversion',ios_version='$iosversion',is_mandatory_android='$checkbox1',is_mandatory_ios='$checkbox2' WHERE orgid=0");
				if($query>0){
					echo 1;
				}else{
					echo 0;
				} 
			}else echo 0;
			
			
		}
		
		
			
	public function getstorepackage1(){
			$result1=array();
			$res1=array();
		
			$query = $this->db->query("SELECT * FROM package_master_ubiattendance_new ");
			foreach ($query->result_array() as $row)
			{
				$res1['packagename'] =   $row['packagename'];
				$res1['modules'] = 	 $row['modules'];
				//$res1['archive'] = 	 $row['archive'];
				$res1['baseinr'] = 	 $row['baseinr'];
				
				$res1['basedollar'] =   $row['basedollar'];
				$res1['priceperuserpermonthinr'] = 	 $row['priceperuserpermonthinr'];
				$res1['priceperuserpermonthdollar'] = 	 $row['priceperuserpermonthdollar'];
				$res1['disinrupeeforinr'] = 	 $row['disinrupeeforinr'];
				
				$res1['disindollarfordollar'] =   $row['disindollarfordollar'];
				$res1['disinperforinr'] = 	 $row['disinperforinr'];
				$res1['disinperfordollar'] = 	 $row['disinperfordollar'];
				$res1['disinmonthforyearlyinr'] = 	 $row['disinmonthforyearlyinr'];
				
				$res1['disinmonthforyearlydollar'] =   $row['disinmonthforyearlydollar'];
				$res1['applogin'] = 	 $row['applogin'];
				$res1['adminlogin'] = 	 $row['adminlogin'];
				$res1['modified_date'] = 	 $row['modified_date'];
				$res1['addonuseerpminr'] = 	 $row['addonuseerpminr'];
				$res1['addonuseerpmusd'] = 	 $row['addonuseerpmusd'];
				
				
			}
			
			$result1 = $res1;
			return $result1;
		}
		
		public function newpackages(){
			$result1=array();
			$result=array();
		
			$query = $this->db->query("SELECT * FROM Attendance_plan_master ");
			foreach ($query->result_array() as $row)
			{
				$res1=array();
				$res1['id'] =   $row['id'];
				$res1['monthly'] =   $row['monthly'];
				$res1['yearly'] = 	 $row['yearly'];
				
				$res1['bulkattendance'] = 	 $row['bulk_attendance'];
				$res1['location_tracing'] = 	 $row['location_tracing'];
				$res1['visit_punch'] = 	 $row['visit_punch'];
				$res1['geo_fence'] = 	 $row['geo_fence'];
				$res1['payroll'] = 	 $row['payroll'];
				$res1['time_off'] = 	 $row['time_off'];
				//$res1['archive'] = 	 $row['archive'];
				
				
				$result1[]=$res1;
				
				
			}
			
			$result = $result1;
			return $result;
		}
		public function getDiscount(){
			$result = array();
			$data1 = array();
			$data = array();
			$query = $this->db->query("SELECT * FROM attendance_discount_master");
			foreach($query->result() as $row)
			{
				$data['curr'] = $row->currency;
				$data['plan'] = $row->plan;
				$data['discount'] = $row->discount;
				$data['start'] =$row->start_date;
				$data['end'] = $row->end_date;
				$data['sts'] = $row->status;
				$result[]    = $data;
			}
			$data1 = $result;
			return $data1;
		}
		public function updateDiscountPackages()
		{
			$discount1 = isset($_REQUEST['discount1'])?$_REQUEST['discount1']:'0';
			
			$discount2 = isset($_REQUEST['discount2'])?$_REQUEST['discount2']:'0';
			
			$discount3 = isset($_REQUEST['discount3'])?$_REQUEST['discount3']:'0';
			
			$discount4 = isset($_REQUEST['discount4'])?$_REQUEST['discount4']:'0';
			
			$start1 = isset($_REQUEST['start1'])?date('Y-m-d',strtotime($_REQUEST['start1'])):'0';
			
			$start2 = isset($_REQUEST['start2'])?date('Y-m-d',strtotime($_REQUEST['start2'])):'0';
			
			$start3 = isset($_REQUEST['start3'])?date('Y-m-d',strtotime($_REQUEST['start3'])):'0';
			
			$start4 = isset($_REQUEST['start4'])?date('Y-m-d',strtotime($_REQUEST['start4'])):'0';
			
			$end1 = isset($_REQUEST['end1'])?date('Y-m-d',strtotime($_REQUEST['end1'])):'0';
			
			$end2 = isset($_REQUEST['end2'])?date('Y-m-d',strtotime($_REQUEST['end2'])):'0';
			
			$end3 = isset($_REQUEST['end3'])?date('Y-m-d',strtotime($_REQUEST['end3'])):'0';
			
			$end4 = isset($_REQUEST['end4'])?date('Y-m-d',strtotime($_REQUEST['end4'])):'0';
			
			$status1 = isset($_REQUEST['status1'])?$_REQUEST['status1']:'0';
			
			$status2 = isset($_REQUEST['status2'])?$_REQUEST['status2']:'0';
			
			$status3 = isset($_REQUEST['status3'])?$_REQUEST['status3']:'0';
			
			$status4 = isset($_REQUEST['status4'])?$_REQUEST['status4']:'0';
			 $today = date("Y-m-d");
			/* update query */
			$query1 = $this->db->query("update attendance_discount_master set discount='$discount1', start_date='$start1',end_date='$end1', modify_date='$today',status='$status1' where id=1");	
			
			$query2 = $this->db->query("update attendance_discount_master set discount='$discount2', start_date='$start2',end_date='$end2', modify_date='$today',status='$status2' where id=2");
			
			$query3 = $this->db->query("update attendance_discount_master set discount='$discount3', start_date='$start3',end_date='$end3', modify_date='$today',status='$status3' where id=3");
			
			$query4 = $this->db->query("update attendance_discount_master set discount='$discount4', start_date='$start4',end_date='$end4', modify_date='$today',status='$status4' where id=4");
			
			if($query1>0 && $query2>0 && $query3>0 && $query4>0  )
			  echo 1;
		    else
			  echo 0;
		}
		public function updateNewPackages(){
			//$id = $_SESSION['orgid'];
			$usdmonthly1 = isset($_REQUEST['usdmonthly1'])?$_REQUEST['usdmonthly1']:0;
			$usdyearly1 = isset($_REQUEST['usdyearly1'])?$_REQUEST['usdyearly1']:0;
			$rsmonthly1 = isset($_REQUEST['rsmonthly1'])?$_REQUEST['rsmonthly1']:0;
			$rsyearly1 = isset($_REQUEST['rsyearly1'])?$_REQUEST['rsyearly1']:0;
			
			$usdmonthly2 = isset($_REQUEST['usdmonthly2'])?$_REQUEST['usdmonthly2']:0;
			$usdyearly2 = isset($_REQUEST['usdyearly2'])?$_REQUEST['usdyearly2']:0;
			$rsmonthly2 = isset($_REQUEST['rsmonthly2'])?$_REQUEST['rsmonthly2']:0;
			$rsyearly2 = isset($_REQUEST['rsyearly2'])?$_REQUEST['rsyearly2']:0;
			
			$usdmonthly3 = isset($_REQUEST['usdmonthly3'])?$_REQUEST['usdmonthly3']:0;
			$usdyearly3 = isset($_REQUEST['usdyearly3'])?$_REQUEST['usdyearly3']:0;
			$rsmonthly3 = isset($_REQUEST['rsmonthly3'])?$_REQUEST['rsmonthly3']:0;
			$rsyearly3 = isset($_REQUEST['rsyearly3'])?$_REQUEST['rsyearly3']:0;
			
			$usdmonthly4 = isset($_REQUEST['usdmonthly4'])?$_REQUEST['usdmonthly4']:0;
			$usdyearly4 = isset($_REQUEST['usdyearly4'])?$_REQUEST['usdyearly4']:0;
			$rsmonthly4 = isset($_REQUEST['rsmonthly4'])?$_REQUEST['rsmonthly4']:0;
			$rsyearly4 = isset($_REQUEST['rsyearly4'])?$_REQUEST['rsyearly4']:0;
			
			$usdmonthly5 = isset($_REQUEST['usdmonthly5'])?$_REQUEST['usdmonthly5']:0;
			$usdyearly5 = isset($_REQUEST['usdyearly5'])?$_REQUEST['usdyearly5']:0;
			$rsmonthly5 = isset($_REQUEST['rsmonthly5'])?$_REQUEST['rsmonthly5']:0;
			$rsyearly5 = isset($_REQUEST['rsyearly5'])?$_REQUEST['rsyearly5']:0;
			
			$usdmonthly6 = isset($_REQUEST['usdmonthly6'])?$_REQUEST['usdmonthly6']:0;
			$usdyearly6 = isset($_REQUEST['usdyearly6'])?$_REQUEST['usdyearly6']:0;
			$rsmonthly6 = isset($_REQUEST['rsmonthly6'])?$_REQUEST['rsmonthly6']:0;
			$rsyearly6 = isset($_REQUEST['rsyearly6'])?$_REQUEST['rsyearly6']:0;
			
			$usdmonthly7 = isset($_REQUEST['usdmonthly7'])?$_REQUEST['usdmonthly7']:0;
			$usdyearly7 = isset($_REQUEST['usdyearly7'])?$_REQUEST['usdyearly7']:0;
			$rsmonthly7 = isset($_REQUEST['rsmonthly7'])?$_REQUEST['rsmonthly7']:0;
			$rsyearly7 = isset($_REQUEST['rsyearly7'])?$_REQUEST['rsyearly7']:0;		
			
		
			if($usdmonthly1!=0 || $usdyearly1!=0)
				
			{
				$query = $this->db->query("update Attendance_plan_master set yearly='$usdyearly1', monthly='$usdmonthly1' where id=1");				 
			}
			if($usdmonthly2!=0 || $usdyearly2!=0)
				
			{
				$query = $this->db->query("update Attendance_plan_master set yearly='$usdyearly2', monthly='$usdmonthly2' where id=2");				 
			}
			if($usdmonthly3!=0 || $usdyearly3!=0)
				
			{
				$query = $this->db->query("update Attendance_plan_master set yearly='$usdyearly3', monthly='$usdmonthly3' where id=3");				 
			}
			if($usdmonthly4!=0 || $usdyearly4!=0)
			{
				$query = $this->db->query("update Attendance_plan_master set yearly='$usdyearly4', monthly='$usdmonthly4' where id=4");				 
			}
			if($usdmonthly5!=0 || $usdyearly5!=0)
				
			{
				$query = $this->db->query("update Attendance_plan_master set yearly='$usdyearly5', monthly='$usdmonthly5' where id=5");				 
			}
			if($usdmonthly6!=0 || $usdyearly6!=0)
				
			{
				$query = $this->db->query("update Attendance_plan_master set yearly='$usdyearly6', monthly='$usdmonthly6' where id=6");				 
			}
			if($usdmonthly7!=0 || $usdyearly7!=0)
				
			{
				$query = $this->db->query("update Attendance_plan_master set yearly='$usdyearly7', monthly='$usdmonthly7' where id=7");				 
			}
			
			if($rsmonthly1!=0 || $rsyearly1!=0)
				
			{
				$query = $this->db->query("update Attendance_plan_master set yearly='$rsyearly1', monthly='$rsmonthly1' where id=8");				 
			}
			
			if($rsmonthly2!=0 || $rsyearly2!=0)
				
			{
				$query = $this->db->query("update Attendance_plan_master set yearly='$rsyearly2', monthly='$rsmonthly2' where id=9");				 
			}
			if($rsmonthly3!=0 || $rsyearly3!=0)
				
			{
				$query = $this->db->query("update Attendance_plan_master set yearly='$rsyearly3', monthly='$rsmonthly3' where id=10");				 
			}
			
			if($rsmonthly4!=0 || $rsyearly4!=0)
				
			{
				$query = $this->db->query("update Attendance_plan_master set yearly='$rsyearly4', monthly='$rsmonthly4' where id=11");				 
			}
			if($rsmonthly5!=0 || $rsyearly5!=0)
			{
				$query = $this->db->query("update Attendance_plan_master set yearly='$rsyearly5', monthly='$rsmonthly5' where id=12");				 
			}
			if($rsmonthly6!=0 || $rsyearly6!=0)
			{
				$query = $this->db->query("update Attendance_plan_master set yearly='$rsyearly6', monthly='$rsmonthly6' where id=13");				 
			}
			if($rsmonthly7!=0 || $rsyearly7!=0)
			{
				$query = $this->db->query("update Attendance_plan_master set yearly='$rsyearly7', monthly='$rsmonthly7' where id=14");				 
			}
			
			return true;
		}
		public function updateAddons()
		{
			//$id = $_SESSION['orgid'];		
			$usdyearly1 = isset($_REQUEST['usdyearly1'])?$_REQUEST['usdyearly1']:0;
			$rsyearly1 = isset($_REQUEST['rsyearly1'])?$_REQUEST['rsyearly1']:0;
			
			
			$usdyearly2 = isset($_REQUEST['usdyearly2'])?$_REQUEST['usdyearly2']:0;
			$rsyearly2 = isset($_REQUEST['rsyearly2'])?$_REQUEST['rsyearly2']:0;
			
			
			$usdyearly3 = isset($_REQUEST['usdyearly3'])?$_REQUEST['usdyearly3']:0;
			$rsyearly3 = isset($_REQUEST['rsyearly3'])?$_REQUEST['rsyearly3']:0;
			
			
			$usdyearly4 = isset($_REQUEST['usdyearly4'])?$_REQUEST['usdyearly4']:0;
			$rsyearly4 = isset($_REQUEST['rsyearly4'])?$_REQUEST['rsyearly4']:0;
			
			
			$usdyearly5 = isset($_REQUEST['usdyearly5'])?$_REQUEST['usdyearly5']:0;
			$rsyearly5 = isset($_REQUEST['rsyearly5'])?$_REQUEST['rsyearly5']:0;
			
			
			$usdyearly6 = isset($_REQUEST['usdyearly6'])?$_REQUEST['usdyearly6']:0;
			$rsyearly6 = isset($_REQUEST['rsyearly6'])?$_REQUEST['rsyearly6']:0;
			

			$usdyearly7 = isset($_REQUEST['usdyearly7'])?$_REQUEST['usdyearly7']:0;
			$rsyearly7 = isset($_REQUEST['rsyearly7'])?$_REQUEST['rsyearly7']:0;		
			
			
			$addon = isset($_REQUEST['addons'])?$_REQUEST['addons']:"";		
			//echo $addon;
		   if($addon != "")
		   {  
			if($usdyearly1!=0)	
			{
				$query = $this->db->query("update Attendance_plan_master set $addon='$usdyearly1' where id=1");				 
			}
			if($usdyearly2!=0)	
			{
				$query = $this->db->query("update Attendance_plan_master set $addon='$usdyearly2' where id=2");				 
			}
			if($usdyearly3!=0)
			{
				$query = $this->db->query("update Attendance_plan_master set $addon='$usdyearly3' where id=3");				 
			}
			if($usdyearly4!=0)	
			{
				$query = $this->db->query("update Attendance_plan_master set $addon='$usdyearly4' where id=4");				 
			}
			if($usdyearly5!=0)	
			{
				$query = $this->db->query("update Attendance_plan_master set $addon='$usdyearly5' where id=5");				 
			}
			if($usdyearly6 != 0)	
			{
				$query = $this->db->query("update Attendance_plan_master set $addon='$usdyearly6' where id=6");				 
			}
			if($usdyearly7!=0)
			{
				$query = $this->db->query("update Attendance_plan_master set $addon='$usdyearly7' where id=7");				 
			}
			
			if($rsyearly1!=0)	
			{
				$query = $this->db->query("update Attendance_plan_master set $addon='$rsyearly1' where id=8");				 
			}
			
			if($rsyearly2!=0)	
			{
				$query = $this->db->query("update Attendance_plan_master set $addon='$rsyearly2' where id=9");				 
			}
			if($rsyearly3!=0)			
			{
				$query = $this->db->query("update Attendance_plan_master set $addon='$rsyearly3' where id=10");				 
			}
			
			if( $rsyearly4!=0)				
			{
				$query = $this->db->query("update Attendance_plan_master set $addon='$rsyearly4' where id=11");				 
			}
			if($rsyearly5!=0)
			{
				$query = $this->db->query("update Attendance_plan_master set $addon='$rsyearly5' where id=12");				 
			}
			if($rsyearly6!=0)
			{
				$query = $this->db->query("update Attendance_plan_master set $addon='$rsyearly6' where id=13");				 
			}
			if($rsyearly7!=0)
			{
				$query = $this->db->query("update Attendance_plan_master set $addon='$rsyearly7' where id=14");				 
			}
			
			return true;
		   }
		   else
		   {
			   return false;
		   }
		}
		
		public function updatePackge1(){
			//$id = $_SESSION['orgid'];
			$packagename = isset($_REQUEST['packagename'])?$_REQUEST['packagename']:'';
			$modules = isset($_REQUEST['modules'])?$_REQUEST['modules']:'';
			$baseinr = isset($_REQUEST['baseinr'])?$_REQUEST['baseinr']:'';
			$basedollar = isset($_REQUEST['basedollar'])?$_REQUEST['basedollar']:'';
			
			$priceperuserpermonthinr = isset($_REQUEST['priceperuserpermonthinr'])?$_REQUEST['priceperuserpermonthinr']:'';
			$priceperuserpermonthdollar = isset($_REQUEST['priceperuserpermonthdollar'])?$_REQUEST['priceperuserpermonthdollar']:'';
			$disinrupeeforinr = isset($_REQUEST['disinrupeeforinr'])?$_REQUEST['disinrupeeforinr']:'';
			$disindollarfordollar = isset($_REQUEST['disindollarfordollar'])?$_REQUEST['disindollarfordollar']:'';
			
			$disinperforinr = isset($_REQUEST['disinperforinr'])?$_REQUEST['disinperforinr']:'';
			$disinperfordollar = isset($_REQUEST['disinperfordollar'])?$_REQUEST['disinperfordollar']:'';
			$disinmonthforyearlyinr = isset($_REQUEST['disinmonthforyearlyinr'])?$_REQUEST['disinmonthforyearlyinr']:'';
			$disinmonthforyearlydollar = isset($_REQUEST['disinmonthforyearlydollar'])?$_REQUEST['disinmonthforyearlydollar']:'';
			
			$applogin = isset($_REQUEST['applogin'])?$_REQUEST['applogin']:'';
			$adminlogin = isset($_REQUEST['adminlogin'])?$_REQUEST['adminlogin']:'';
			$modified_date = isset($_REQUEST['modified_date'])?$_REQUEST['modified_date']:'';
			$addonuseerpminr = isset($_REQUEST['addonuseerpminr'])?$_REQUEST['addonuseerpminr']:'';
			$addonuseerpmusd = isset($_REQUEST['addonuseerpmusd'])?$_REQUEST['addonuseerpmusd']:'';
		
			if($packagename!='' || $modules!='' || $baseinr!='' || $basedollar!='' || $priceperuserpermonthinr!='' || $priceperuserpermonthdollar!='' || $disinrupeeforinr!='' || $disindollarfordollar!=''|| $disinperforinr!='' || $disinperfordollar!='' || $disinmonthforyearlyinr!='' || $disinmonthforyearlydollar!='' || $applogin!='' || $adminlogin!='' || $modified_date!=''|| $addonuseerpminr!=''|| $addonuseerpmusd!='')
			{
				$query = $this->db->query("update package_master_ubiattendance_new set packagename='$packagename', modules='$modules',baseinr='$baseinr',basedollar='$basedollar',priceperuserpermonthinr='$priceperuserpermonthinr', priceperuserpermonthdollar='$priceperuserpermonthdollar',
				disinrupeeforinr='$disinrupeeforinr',disindollarfordollar='$disindollarfordollar',disinperforinr='$disinperforinr', disinperfordollar='$disinperfordollar',disinmonthforyearlyinr='$disinmonthforyearlyinr',disinmonthforyearlydollar='$disinmonthforyearlydollar',applogin='$applogin', adminlogin='$adminlogin', modified_date='$modified_date'
				, addonuseerpminr='$addonuseerpminr', addonuseerpmusd='$addonuseerpmusd'");
				if($query>0){
					echo 1;
				}else
				{
					echo 0;
				} 
			}else echo 0;
			
		}
		
		public function editUserData(){
			$edit_id =  isset($_REQUEST['edit_id'])?$_REQUEST['edit_id']:"";
			$name =  isset($_REQUEST['nameE'])?$_REQUEST['nameE']:"";
			$username =  isset($_REQUEST['usernameE'])?$_REQUEST['usernameE']:"";
			$email =  isset($_REQUEST['emailE'])?$_REQUEST['emailE']:"";
			$status =  isset($_REQUEST['statusE'])?$_REQUEST['statusE']:"0";
			$query = $this->db->query("update admin_login set username='$username', email='$email', name='$name',status=$status where id = $edit_id");
			if($query>0)
				{
				$this->session->set_flashdata('success', "User Updated successfully");
			  }else{
				  $this->session->set_flashdata('error', "some error occurs");
			   }
		}
		
		public function updateOrganizationData($id)
		   {
			 $org_name =  isset($_REQUEST['org_name'])?$_REQUEST['org_name']:"";
			 $email =  isset($_REQUEST['email'])?$_REQUEST['email']:"";
			 $phone =  isset($_REQUEST['phone'])?$_REQUEST['phone']:"";
			 $county =  isset($_REQUEST['country'])?$_REQUEST['country']:"0";
			 $address =  isset($_REQUEST['Address'])?$_REQUEST['Address']:"";
			 $orgtype =  isset($_REQUEST['orgtype'])?$_REQUEST['orgtype']:0;
			 $TimeZone=0;
			 
		if(isset($_REQUEST['attendanceaddon'])) 
		{
		 $attendanceaddon = 1;
		}
		if(isset($_REQUEST['locationtracking'])) 
		{
		 $locationtracking = 1;
		}   
		if(isset($_REQUEST['visitpunch']))
		{
		$visitpunch = 1;
		}  
		if(isset($_REQUEST['geofence'])) 
		{
		 $geofence = 1;
        }  
		if(isset($_REQUEST['payroll'])) 
		{
		 $payroll = 1;
		}
			  
		if(isset($_REQUEST['timeoff'])) 
		{
		 $timeoff = 1;
		}	
		if(isset($_REQUEST['flexi'])) 
		{
		 $flexi = 1;
		}
			 $username= $email;
			  $data = $this->editOrganizationData($id);
			  $flage = 1;
			 $email1 = $data['Email'];
			 $phone1 = $data['PhoneNumber'];
			  if($data['Email'] != $email )
			 {
			$counter=0;
			$sql = "SELECT * FROM Organization where Email = '$email'";
			$this->db->query($sql);
			$counter=$this->db->affected_rows();
			$sql = "SELECT * FROM UserMaster where Username = '".encode5t($email)."'";
			$this->db->query($sql);
			$counter+=$this->db->affected_rows();
			$sql = "SELECT * FROM admin_login where username = '$email' OR 	email = '$email'";
			$this->db->query($sql);
			$counter+=$this->db->affected_rows();
			
			
			
		
			if($counter>0)
			{
				$this->session->set_flashdata('error1', "Email id is already exists");
				return false;
				$flage=0;
			}
			else
			{
				$flage = 1;
			}
			
		  }
		  if($phone!=$phone1)
			{
			$counter1=0;
			$sql = "SELECT * FROM Organization where PhoneNumber = '$phone'";
			$this->db->query($sql);
			$counter1=$this->db->affected_rows();
			$sql = "SELECT * FROM UserMaster where username_mobile = '".encode5t($phone)."'";
			$this->db->query($sql);
			$counter1+=$this->db->affected_rows();
			if($counter1>0)
				{
				$this->session->set_flashdata('error2', "phone is already exists");
				return false;
				$flage=0;
				}
			  else
			  {
				$flage = 1; 
			  }
			}
			
			$query = $this->db->query("SELECT * FROM `ZoneMaster` WHERE `CountryId`=$county");
			if($row=$query->result())
			$TimeZone= $row[0]->Id;
		   if($flage==1)
			{	
			 $query0 = $this->db->query("Update admin_login SET username='$email',email='$email' WHERE username= '$email1' AND email='$email1' ");
			 
			$query1 = $this->db->query("Update UserMaster SET Username = '".encode5t($email)."' where Username = '".encode5t($email1)."'");	
			
			 $query11 = $this->db->query("Update UserMaster SET username_mobile = '".encode5t($phone)."' where username_mobile = '".encode5t($phone1)."'");
			 
             $query = $this->db->query("update Organization set Name='$org_name',PhoneNumber=$phone,Email='$email',Country=$county,Address='$address',customize_org='$orgtype',TimeZone='$TimeZone' where Id = $id");
			 
			 $query = $this->db->query("update licence_ubiattendance set Addon_BulkAttn = ' $attendanceaddon',Addon_LocationTracking='$locationtracking',Addon_VisitPunch= ' $visitpunch',Addon_GeoFence='$geofence',Addon_Payroll= '$payroll',Addon_TimeOff='$timeoff',Addon_flexi_shif='$flexi' where OrganizationId = '$id' ");
			 
	          if($query>0)
			  {
				$this->session->set_flashdata('success', "Organization updated successfully"); 
			  }
			  else
			  {
				$this->session->set_flashdata('error', "some error occurs");  
			  }		 
		   }
		
		}
		public function updateaddonspermission($id)
	  {
			 
		if(isset($_REQUEST['attendanceaddon'])) 
		{
		 $attendanceaddon = 1;
		}
		if(isset($_REQUEST['locationtracking'])) 
		{
		 $locationtracking = 1;
		}   
		if(isset($_REQUEST['visitpunch']))
		{
		$visitpunch = 1;
		}  
		if(isset($_REQUEST['geofence'])) 
		{
		 $geofence = 1;
        }  
		if(isset($_REQUEST['payroll'])) 
		{
		 $payroll = 1;
		}
			  
		if(isset($_REQUEST['timeoff'])) 
		{
		 $timeoff = 1;
		}	
		if(isset($_REQUEST['flexi'])) 
		{
		 $flexi = 1;
		}
			
			 $query = $this->db->query("update licence_ubiattendance set Addon_BulkAttn = ' $attendanceaddon',Addon_LocationTracking='$locationtracking',Addon_VisitPunch= ' $visitpunch',Addon_GeoFence='$geofence',Addon_Payroll= '$payroll',Addon_TimeOff='$timeoff',Addon_flexi_shif='$flexi' where OrganizationId = '$id' ");
			 
	          if($query>0)
			  {
				$this->session->set_flashdata('success', "Addons updated successfully"); 
			  }
			  else
			  {
				$this->session->set_flashdata('error', "some error occurs");  
			  }		 
		}
		public function get_trial_days()
		{
			$query = $this->db->query('SELECT * FROM ubitech_login');

				foreach ($query->result_array() as $row)
				{
						return $row['trial_days'];
				}
		}
		public function getTrialData($id){
		        $res1=array();			
				$query1 = $this->db->query("SELECT * FROM licence_ubiattendance WHERE OrganizationId = $id");
				foreach ($query1->result_array() as $row1)
				{
					$res1['id'] = $row1['id'];
					$res1['org_id'] = $row1['OrganizationId'];
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
			$limit =  $_REQUEST['limit'];
		
			
			if($till_date != $end_date){
			 $extended_data =  $extended_data+1;	
			}
			$start_date =  $_REQUEST['start_date'];
			$org_id =  $_REQUEST['org_id'];
			$sql = "update licence_ubiattendance set start_date='$start_date', end_date='$till_date' ,extended=$extended_data , status = 0, user_limit=$limit where OrganizationId=$org_id";
			$query = $this->db->query($sql);
			$c1 = $this->db->affected_rows();
			$c2 =0;
			if($this->db->affected_rows()>0)
			{
				$sql = "update Organization set NoOfEmp='$limit' where Id=$org_id";
				$query = $this->db->query($sql);
				$c2 = $this->db->affected_rows();
			}
			if($c1>0 || $c2>0){
				echo 1;
			}else{
				echo 0;
			}
			/*if($query > 0){
				echo 'true';
			}else{
				echo 'false';
			} */
		}
		public function buy(){
			$end_date =  $_REQUEST['end_date'];
			$start_date =  $_REQUEST['start_date'];
			$org_id =  $_REQUEST['org_id'];
			$email =  $_REQUEST['email'];
			$country =  $_REQUEST['country'];
			$company =  $_REQUEST['company'];
			$name =  $_REQUEST['name'];
			$txn =  $_REQUEST['txn'];
			$currency =  $_REQUEST['currency'];
			$due =  $_REQUEST['due'];
			$amount =  $_REQUEST['amount'];
			$tax =  $_REQUEST['tax'];
			$dis =  $_REQUEST['dis'];
			$state =  $_REQUEST['state'];
			$city =  $_REQUEST['city'];
			$gst =  $_REQUEST['gst'];
			$contact =  $_REQUEST['contact'];
			$remark =  $_REQUEST['remark'];
			$limit =  $_REQUEST['limit'];
			$createdate=date("Y-m-d");
			if($due != 0)
			   $due = $due-$amount;
		    else
				$dus=0;
			
			
			
			 $sql = "Select id from payments_invoice where txnid = '$txn'";
			 $query = $this->db->query($sql);
				if($query->num_rows() > 0)
				{
					echo 2;
					return;
				}
  			 
			 
			/*narration is for invoice subscription details*/
			$narration = 'Subscription Period: Your Subscription will end on '.date('d M, Y',strtotime($end_date)).'<br/>Administrator Login (1 Admin)<br/>User Logins ('.$limit.' Users)';
			$sql = "insert into payments_invoice (`txnid`, `OrganizationId`, `name`, `email`, `payment_amount`, `payment_status`, `createDate`, `tax`, `discount`, `currency`, `country`, `state`, `city`, `contact`,  `indivisual_name`, `gstin`, `narration`, `remark`) values('$txn',$org_id, '$name', '$email', '$amount', 'success', '$createdate', '$tax', '$dis', '$currency', '$country', '$state', '$city', '$contact', '$company', '$gst', '$narration', '$remark')";
			$query = $this->db->query($sql);
			
			$sql1 = "update  licence_ubiattendance set start_date='$start_date', end_date='$end_date', status = 1, due_amount='$due',user_limit=$limit  where OrganizationId=$org_id";
			$query1 = $this->db->query($sql1);
			
			$sql2 = "update Organization set NoOfEmp='$limit' where Id=$org_id";
			$query2 = $this->db->query($sql2);
			
			/*$sql4 = "update admin_login set web_admin_login_sts = 1  where OrganizationId = $org_id";
			$query4 = $this->db->query($sql4); */
			
		/*	if($query > 0){
				echo 'true';
			}else{
				echo 'false';
			} */ 
			if($query > 0){
				echo 1;
			}else{
				echo 0;
			}
		}
		public function updateLimit(){
			$limit =  $_REQUEST['limit'];
			$org_id =  $_REQUEST['org_id'];
			$sql = "update  licence_ubiattendance set  licence_ubiattendance='$limit' where OrganizationId=$org_id";
			$query = $this->db->query($sql);
			$sql = "update Organization set NoOfEmp='$limit' where Id=$org_id";
			$query = $this->db->query($sql);
			if($query > 0){
				echo 'true';
			}else
			{
				echo 'false';
			}
		}
		
		public function trial_days()
		{
			
			$days = $_REQUEST['days'];
			$user = $_REQUEST['user'];
			
		    $attendanceaddon = $_REQUEST['attendanceaddon'];
			$locationtracking = $_REQUEST['locationtracking'];
			$visitpunch = $_REQUEST['visitpunch'];
			$geofence = $_REQUEST['geofence'];
			$payroll = $_REQUEST['payroll'];
			$timeoff = $_REQUEST['timeoff'];
			
			$sql = "update ubitech_login set trial_days=$days,user_limit=$user,bulk_attendance=$attendanceaddon,location_tracing=$locationtracking,visit_punch=$visitpunch,geo_fence=$geofence,payroll=$payroll ,	time_off=$timeoff ";
			$query = $this->db->query($sql);
			
			if($query > 0){
				echo '1';
			}else{
				echo '0';
			}
			
		}
		
		public function trial_users(){
			
			$user = $_REQUEST['user'];
			$sql = "update ubitech_login set user_limit=$user";
			$query = $this->db->query($sql);
			
			if($query > 0){
				echo 'true';
			}else{
				echo 'false';
			}
			
		}
		
		public function trial_setting(){
		$query = $this->db->query('SELECT trial_days,user_limit,bulk_attendance,location_tracing,visit_punch,geo_fence,payroll,	time_off FROM ubitech_login');
				$data=array();
				$data['res']=false;
				if($row=$query->result_array() ){
						 $data['detail']=$row;
						 $data['res']=true;
				}
				return $data;		
		}
		
		//////Package 
		 	 public function registerPackageData(){
			 $name =  isset($_REQUEST['packagenameA'])?$_REQUEST['packagenameA']:"";
			 $discount =  isset($_REQUEST['discountA'])?$_REQUEST['discountA']:"";
			 $inr =  isset($_REQUEST['inrA'])?$_REQUEST['inrA']:"";
			 $usd =  isset($_REQUEST['usdA'])?$_REQUEST['usdA']:"0";
			 $inrperuserA =  isset($_REQUEST['inrperuserA'])?$_REQUEST['inrperuserA']:"0";
			 $usdperuserA =  isset($_REQUEST['usdperuserA'])?$_REQUEST['usdperuserA']:"0";
			 $user =  isset($_REQUEST['userA'])?$_REQUEST['userA']:"";
			 $status =  isset($_REQUEST['stsA'])?$_REQUEST['stsA']:"";
			 
			 $sql = "SELECT * FROM package_master_ubiattendance where package_name = '$name'";
			$this->db->query($sql);
			if($this->db->affected_rows()>0){
				$this->session->set_flashdata( "package is already exists");
			}
			 else{
             $query1 = $this->db->query("insert into package_master_ubiattendance(package_name,discount,package_price_inr_yr,package_price_usd_yr,per_user_inr,per_user_usd,package_user_limit,archive) values('$name',$discount,$inr,$usd,$inrperuserA, $usdperuserA,$user,$status)");
	          if($query1>0){
				 $this->session->set_flashdata('success', "Package Inserted successfully"); 
			  }else{
				$this->session->set_flashdata('error', "some error occurs");  
			  }			 
		} 
			 }
		
		public function getPackageData(){
			$query = $this->db->query("SELECT * FROM `package_master_ubiattendance` WHERE 1");
			$d=array();
			$res=array();
			 foreach ($query->result() as $row)
			{
				    $data=array();
					$data['id']=$row->id;
					$data['name']=$row->package_name;
					$data['inr']=$row->package_price_inr_yr;
					$data['usd']=$row->package_price_usd_yr;
					$data['inrperuser']=$row->per_user_inr;
					$data['usdperuser']=$row->per_user_usd;
					$data['discount']=$row->discount;
					$data['user']=$row->package_user_limit;
					$data['sts']=$row->archive==1?'<div style="background-color:green;text-align:center;color:white;">Active</div>':'<div style="background-color:red;text-align:center;color:white;">
					Inactive</div>';
					//$data['sts']=$row->archive;
					$data['action']='<i class="material-icons edit" data-toggle="modal" title="Edit"    
					 
					 data-id="'.$row->id.'" 
					 data-name="'.$row->package_name.'" 
					 data-inr="'.$row->package_price_inr_yr.'"
					 data-usd="'.$row->package_price_usd_yr.'"
					 data-user="'.$row->package_user_limit.'"
					 data-userinr="'.$row->per_user_inr.'"
					 data-userusd="'.$row->per_user_usd.'"
					 data-discount="'.$row->discount.'"
					 data-sts="'.$row->archive.'" 
					 data-target="#PackageE">edit</i>
					';
					/*$data['image']='<img src="'.URL.'../ubitech/upload/'.$row->filename.'"  style="width:100%!important; "/>';
					$data['status']=$row->archive==1?'<div style="background-color:green;text-align:center;color:white;">Visible</div>':'<div style="background-color:red;text-align:center;color:white;">
					Invisible</div>';
					*/
					$res[]=$data;
			}  	
			$d['data']=$res;  				//$query->result();
			echo json_encode($d); return false;
		}
		 
		public function updatePackageData()
		{
			
            $id =  isset($_REQUEST['edit_id'])?$_REQUEST['edit_id']:"";
			 $name =  isset($_REQUEST['packagename'])?$_REQUEST['packagename']:"";
			 $discount =  isset($_REQUEST['discount'])?$_REQUEST['discount']:"";
			 $inr =  isset($_REQUEST['inr'])?$_REQUEST['inr']:"";
			 $usd =  isset($_REQUEST['usd'])?$_REQUEST['usd']:"0";
			 $inrperuser =  isset($_REQUEST['inrperuser'])?$_REQUEST['inrperuser']:"0";
			 $usdperuser =  isset($_REQUEST['usdperuser'])?$_REQUEST['usdperuser']:"0";
			 $user =  isset($_REQUEST['user'])?$_REQUEST['user']:"";
			 $status =  isset($_REQUEST['sts'])?$_REQUEST['sts']:"";
			 
             $query = $this->db->query("update package_master_ubiattendance set 
			 package_name=?,
			 discount=?,
			 package_price_inr_yr=?,
			 package_price_usd_yr = ?,
			 per_user_inr = ?,
			 per_user_usd = ?,
			 package_user_limit=?,
			 archive=$status where id = ?",array($name,$discount,$inr,$usd,$inrperuser,$usdperuser,$user,$id));
	          if($query>0){
				 $this->session->set_flashdata('success', "Package updated successfully"); 
			  }else{
				$this->session->set_flashdata('error', "some error occurs");  
			  }			 
		}
		public function updatePassword()
		{
			 $id = $_SESSION['id'];
			 $cpassword = encrypt(isset($_REQUEST['cpassword'])?$_REQUEST['cpassword'] : '');
			 $npassword = encrypt(isset($_REQUEST['npassword'])?$_REQUEST['npassword'] : '');
			 $rtpassword =encrypt(isset($_REQUEST['rtpassword'])?$_REQUEST['rtpassword']: '');
			$query = $this->db->query("select * from ubitech_login where password='$cpassword' and id = $id");
			$result = $query->num_rows();
			if($result>0){
				$query1 = $this->db->query("update ubitech_login set password='$rtpassword' where id = $id");
				if($query1>0){
				echo 1;
				}
			}else{
				echo 0;
			}
		
		}
		public function getPaymentHistoryData($orgid)
		{
			$cond='';
			if($orgid!=0)
				$cond=' where OrganizationId='.$orgid ;
			$query = $this->db->query("SELECT `id`,OrganizationId, `txnid`, `name`, `email`, `payment_amount`, `createDate`, `tax`, `discount`, `currency`,action,remark,payment_status FROM `payments_invoice` ".$cond." order by Id desc");
			$d=array();
			$res=array();
			 foreach ($query->result() as $row)
			{
				$data=array();
				    $orgid1 = $row->OrganizationId;
					$data['company']=$row->name." (".(($row->OrganizationId*$row->OrganizationId)+99).")";
					$data['date']=date('d M y',strtotime($row->createDate));
					$data['transaction']=$row->txnid;
					if($row->action == 'BUY')
					{
					 $data['activity']= 'First Purchase';	
					}
					else
					{
					  $data['activity']= "Upgrade";	
					}
					$data['amount']=$row->currency.' '.$row->payment_amount;
					$data['tax']=$row->tax;
					$data['discount']=$row->discount;
					$data['remark']=$row->remark;
					$data['pay_status']=$row->payment_status;
					$qur = $this->db->query("SELECT `end_date`,`start_date`  FROM `licence_ubiattendance` WHERE OrganizationId=$orgid1");
					$data['edate']="";
					$data['sdate']="";
					foreach($qur->result() as $rw)
					{
					 $data['edate']= date('d M y',strtotime($rw->end_date));	
					 $data['sdate']= date('d M y',strtotime($rw->start_date));		
					  break;
					}
					$data['userlimit'] = getName('Organization', 'NoOfEmp', 'id', $orgid1);
					$data['action']='';
					if($row->payment_status!='FAILED'){
					$data['action']='<a href="'.URL.'cron/generateInvoice?id='.base64_encode($row->txnid).'" target="_blank"><i class= "fa fa-file" title="Generate Invoice" style="font-size:19px;" ></i> </a>
					';
					}
					$res[]=$data;
			}  	
			$d['data']=$res;
			echo json_encode($d); return false;
		}
		
		public function getSuccessfulPaymentData($val)
		  {
			$cond='';
			if($val=='paypal')
				$cond = "AND remark LIKE '%paypal%'";
			else if($val=='payumoney')
				$cond = "AND remark LIKE '%payumoney%'";
			else if($val=='manual')
			     $cond = "AND remark LIKE '%manual%' or remark LIKE '%bank%'";
			$query = $this->db->query("SELECT `id`,OrganizationId, `txnid`, `name`, `email`, `payment_amount`, `createDate`, `tax`, `discount`, `currency`,action,remark,payment_status FROM `payments_invoice` where payment_status = 'success' ".$cond." order by Id desc");
			$d=array();
			$res=array();
			 foreach ($query->result() as $row)
			{
				    $data=array();
				    $orgid1 = $row->OrganizationId;
					$data['company']=$row->name." (".(($row->OrganizationId*$row->OrganizationId)+99).")";
					$data['date']=date('d M y',strtotime($row->createDate));
					$data['transaction']=$row->txnid;
					if($row->action == 'BUY')
					{
					 $data['activity']= 'First Purchase';	
					}
					else
					{
					  $data['activity']= "Upgrade";	
					}
					$data['amount']=$row->currency.' '.$row->payment_amount;
					$data['tax']=$row->tax;
					$data['discount']=$row->discount;
					$data['remark']=$row->remark;
					$data['pay_status']=$row->payment_status;
					$qur = $this->db->query("SELECT `end_date`,`start_date`  FROM `licence_ubiattendance` WHERE OrganizationId=$orgid1");
					$data['edate']="";
					$data['sdate']="";
					foreach($qur->result() as $rw)
					{
					 $data['edate']= date('d M y',strtotime($rw->end_date));	
					 $data['sdate']= date('d M y',strtotime($rw->start_date));		
					 break;
					}
					$data['userlimit'] = getName('Organization', 'NoOfEmp', 'id', $orgid1);
					$data['action']='';
					if($row->payment_status!='FAILED')
					{
					$data['action']='<a href="'.URL.'cron/generateInvoice?id='.base64_encode($row->txnid).'" target="_blank"><i class= "fa fa-file" title="Generate Invoice1" style="font-size:19px;" ></i> </a>
					';
					}
					$res[]=$data;
			}  	
			$d['data']=$res;
			echo json_encode($d); return false;
		}
		
			
}
?>