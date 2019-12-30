
<?php
  class Userprofiles_model extends CI_Model {
    function __construct()
      {
          parent::__construct();
      } 
  
   /*  

public function get_last_ten_entries()
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
                  $this->db->update('entries',$this,array('id' => $_POST['id']));
          }  
  
        public function getgeolocations(){
          $orgid=$_SESSION['orgid'];
          $sql = "SELECT `Id`, `Name` FROM `Geo_Settings` WHERE OrganizationId=$orgid";
          $query=$this->db->query($sql);
          foreach($query->result() as $row){
            $data = array();
            $res= array();
          $data['id'] = $row->Id;
          $data['name'] = $row->Name;
          $res[] = $data;
        }
      return $res;
    
        }*/
      
	  

	  
      public function getEmployeesData()
      {
         $orgid=$_SESSION['orgid'];

         $sname=$_SESSION['name'];
         $id =$_SESSION['id'];
          
          $res = array();
          $d = array();

    $query1 = $this->db->query("SELECT `user_limit` as userlimit, (SELECT COUNT(*)
    FROM EmployeeMaster where`OrganizationId` = 10 and Is_Delete != 2) as registeredusers from licence_ubiattendance where `OrganizationId`=$orgid");
          // var_dump($this->db->last_query());

         
         foreach ($query1->result() as $row){

          $data = array();

            $data['userlimit']=$row->userlimit;
            $data['reguser']=$row->registeredusers;


          $res[]=$data;
          
        }   
        $d['data'] = $res;
        // echo json_encode($d);
       
        
      


        


      
         $query = $this->db->query("SELECT EmployeeMaster.id as id,EmployeeMaster.EmployeeCode as ecode,EmployeeMaster.area_assigned as area ,`FirstName`,lastname,concat(FirstName,'',lastname)as name,archive,department,designation,shift,PersonalNo,DOB, Nationality,hourly_rate, `MaritalStatus`,`Religion`,`BloodGroup`,`DOJ`, `DOC`,`Gender`,`HomeAddress`, EmployeeMaster.CurrentCountry,EmployeeMaster.CurrentCity,`CurrentCountry`, `HomeCity`, `HomeZipCode`,(select appSuperviserSts from UserMaster where EmployeeId= EmployeeMaster.id LIMIT 1)as appSuperviserSts,(select username_mobile from UserMaster where EmployeeId= EmployeeMaster.id LIMIT 1)as una,(select Name from CityMaster where Id = EmployeeMaster.CurrentCity LIMIT 1 )as city123,(select Website from Organization where   Id = EmployeeMaster.OrganizationId)as web,(select qrselector from `admin_login` where  id = '$id' and OrganizationId  = '$orgid' )as qroption,(select Password from UserMaster where EmployeeId= EmployeeMaster.id LIMIT 1)as upa,ImageName FROM `EmployeeMaster` where OrganizationId=? AND archive=1 AND Is_Delete = '0' order by  FirstName ",array($orgid));
         // var_dump($this->db->last_query());

         
         
         $d=array();
         $res=array();
         $userstts='';
         $resetpassword='';
         foreach ($query->result() as $row)
        {
          if($row->archive==1)
            $userstts='<i class=" status fa fa-thumbs-down" style="font-size:16px; color:red" data-id="'.$row->id.'" data-sts="'.$row->archive.'" data-ena="'.$row->FirstName.'" title="Click here to make user status Inactive" ></i>';
          else
            $userstts='<i class=" status fa fa-thumbs-up" style="font-size:16px; color:green" data-toggle="modal" data-id="'.$row->id.'" data-ena="'.$row->FirstName.'"  title="Click to make user Active" ></i>';
              $pass = decode5t($row->upa);
            $resetpassword='<i class=" resetpwd fa fa-key" style="font-size:16px; color:purple" data-toggle="modal" data-target="#resetpwd" typographi="'.$pass.'" data-id="'.$row->id.'" data-name="'.$row->FirstName.' '.$row->lastname.'" title="Request for reset password Only App " ></i>';
          
             $data=array();
            $eno='';
            //  if($_SESSION['specialCase']=='RAKP')
                //$eno='<br/><b>'.$row->ecode.' </b>';
            $data['change']='<input type="checkbox" name="chk"  id="'.$row->id.'" class="checkbox"  value="'.$row->id.'" >';  
          if($row->ImageName!="" || $row->ImageName!=0)
          {
                   $data['photo']=/*'<img src="'.IMGURL3."uploads/$orgid/".$row->ImageName.'" style="width:50px!important;height:50px!important;border-radius:50%" />';*/
          '<i class="pop" data-toggle="modal" data-target="#imagemodal"><img src="'.IMGURL3."uploads/$orgid/".$row->ImageName.'"   style="width:50px!important;height:50px!important;border-radius:50%"  /></i>';         
          }
          else
          {
           if($row->Gender==1)
           {
          $data['photo']=/*'<img src="'.IMGURL3."avatars/male.png".'" style="width:60px!important;border-radius:50%" />';*/
          '<i class="pop" data-toggle="modal" data-target="#imagemodal"><img src="'.IMGURL3."avatars/male.png".'"    style="width:50px!important;height:50px!important;border-radius:50%"  /></i>';
           }
           else if($row->Gender==2)
           {
          $data['photo']='<i class="pop" data-toggle="modal" data-target="#imagemodal"><img src="'.IMGURL3."avatars/female.png".'"    style="width:50px!important;height:50px!important;border-radius:50%"  /></i>';
           }
           else
           {
          $data['photo']='<i class="pop" data-toggle="modal" data-target="#imagemodal"><img src="'.IMGURL3."avatars/male.png".'"    style="width:50px!important;height:50px!important;border-radius:50%"  /></i>';
           }
          }
            $data['name']=$row->FirstName.' '.$row->lastname;
            $data['code']=$row->ecode;
            $data['username']=decode5t(getUserName($row->id));
            // $data['date'] = date('d-M-Y',strtotime($row->TimeofDate));
            //$data['password']=decode5t($row->upa);
          
            $data['pemissions']="";
          if($row->appSuperviserSts==1)
          {
            $data['pemissions'] = '<div style="background-color:green;text-align:center;color:white;" title="for App only" >Admin</div>';
          }
          else if($row->appSuperviserSts==2)
          {
            $data['pemissions'] = '<div style="background-color:#9c27b0;text-align:center;color:white;" title="for App only" >Supervisor</div>';
          }
          else
          {
            $data['pemissions'] = '<div style="background-color:#ff9800;text-align:center;color:white;" title="user" >User</div>';
          }
            $data['designation']=getDesignation($row->designation);
          
            if($row->area != 0)
            $data['area'] = getName('Geo_Settings','Name', 'Id', $row->area);
          else
            $data['area'] = '--';
            $data['shift']='<span title="Shift Timing: '.getShiftTimes($row->shift).', Break Hours: '.getShiftBreaks($row->shift).'">'.getShift($row->shift).'</span>';
            $data['department']=getDepartment($row->department);
            $data['contact']=decode5t($row->PersonalNo);

          
            $data['status']=$row->archive==1?'<div style="background-color:green;text-align:center;color:white;">Active</div>':'<div style="background-color:red;text-align:center;color:white;">Inactive</div>';
          
          if($data['contact'] != "")
          $qr = '<i class=" qr fa fa-qrcode" style="font-size:16px; color:purple" data-toggle="modal" data-target="#genQR" data-id="'.$row->id.'" data-name="'.$row->FirstName.' '.$row->lastname.'" 
          data-ecode="'.$row->ecode.'" data-shift="'. substr(getShift($row->shift),0,15) .'"
          data-desg="'.getDesignation($row->designation).'" data-city123="'.$row->city123.'" data-web123="'.$row->web.'"data-dept="'.getDepartment($row->department).'" data-shifttime="'.getShiftTimes($row->shift).'" data-una="'.decode5t($row->una).'" data-firstname="'.$row->FirstName.'" data-lastname="'.$row->lastname.'" data-email="'.decode5t(getUserName($row->id)).'" data-cont="'.decode5t($row->PersonalNo).'" data-image="'.$row->ImageName.'" data-addr="'.decode5t($row->HomeAddress).'" data-qrc="'.$row->qroption.'" data-upa="ykks=='.$row->upa.'" title="Generate QR Code" ></i>';

          // elseif($data['contact'] != "")
          // $qr = '<i class=" qr fa fa-qrcode" style="font-size:16px; color:purple" data-toggle="modal" data-target="#genQR1" data-id="'.$row->id.'" data-name="'.$row->FirstName.' '.$row->lastname.'" 
          // data-ecode="'.$row->ecode.'"
          // data-desg="'.getDesignation($row->designation).'" data-city123="'.$row->city123.'" data-web123="'.$row->web.'"data-dept="'.getDepartment($row->department).'" data-shifttime="'.getShiftTimes($row->shift).'" data-una="'.decode5t($row->una).'" data-firstname="'.$row->FirstName.'" data-lastname="'.$row->lastname.'" data-email="'.decode5t(getUserName($row->id)).'" data-cont="'.decode5t($row->PersonalNo).'" data-image="'.$row->ImageName.'" data-addr="'.decode5t($row->HomeAddress).'" data-qrc="'.$row->qroption.'" data-upa="ykks=='.$row->upa.'" title="Generate QR Code" ></i>';
          else
          {
            $qr = '<i class="qr1 fa fa-qrcode" style="font-size:16px; color:purple"    data-name="'.$row->FirstName.' '.$row->lastname.'" title="Generate QR Code" ></i>';  
          }
          
          // if($data['code'] != "")
          // $qr = '<i class=" qr fa fa-qrcode" style="font-size:16px; color:purple" data-toggle="modal" data-target="#genQR" data-id="'.$row->id.'" data-name="'.$row->FirstName.' '.$row->lastname.'" data-desg="'.getDesignation($row->designation).'"  data-dept="'.getDepartment($row->department).'" data-shifttime="'.getShiftTimes($row->shift).'" data-una="'.decode5t($row->una).'" data-upa="ykks=='.$row->upa.'" title="Generate QR Code" ></i>';
          // else
          // {
            // $qr = '<i class="qr2 fa fa-qrcode" style="font-size:16px; color:purple"    data-name="'.$row->FirstName.' '.$row->lastname.'" title="Generate QR Code" ></i>'; 
          // }
          
          
            $data['action']='<a href="#"><i class="material-icons edit" style="font-size:16px" data-toggle="modal" title="Edit" data-target="#addEmpE"  
             data-id="'.$row->id.'"
             data-name="'.$row->name.'"
             data-firstname="'.$row->FirstName.'" 
             data-lastname="'.$row->lastname.'" 
             data-area="'.$row->area.'"
             data-dob="'.$row->DOB.'"
             data-doj="'.$row->DOJ.'"
             data-gen="'.$row->Gender.'"
             data-doc="'.$row->DOC.'"
             data-nat="'.$row->Nationality.'"
             data-cont="'.decode5t($row->PersonalNo).'"
             data-addr="'.decode5t($row->HomeAddress).'"
             data-password="'.$pass.'"
             data-email="'.decode5t(getUserName($row->id)).'"
             data-country="'.$row->CurrentCountry.'"
             data-city="'.$row->HomeCity.'"
             data-status="'.$row->archive.'"
             data-shift="'.$row->shift.'"
             data-desg="'.$row->designation.'"
             data-dept="'.$row->department.'"
             data-bg="'.$row->BloodGroup.'"
             data-rel="'.$row->Religion.'"
             data-ms="'.$row->MaritalStatus.'"
           data-hourlypay="'.$row->hourly_rate.'"
             data-sstatus="'.$row->appSuperviserSts.'"
           data-image="'.$row->ImageName.'"
             data-ecode="'.$row->ecode.'"
             data-city123="'.$row->city123.'"
             data-web123="'.$row->web.'"
             data-qrc="'.$row->qroption.'"
             >edit</i></a>
            <i class=" delete fa fa-trash" style="font-size:16px; color:purple" data-toggle="modal" data-target="#delEmp" data-id="'.$row->id.'" data-name="'.$row->FirstName.'" title="Archive Employee"></i> '.$qr.' '.
          $userstts.' '.$resetpassword;
            $res[]=$data;
        }   
        $d['data']=$res;  
            $this->db->close();     //$query->result();
        echo json_encode($d);

      }
      
      public function getCity()
    {
        $country =  isset($_REQUEST['country'])?$_REQUEST['country']:0;
        $sql = "SELECT * FROM CityMaster where CountryId = $country";
        $query = $this->db->query($sql);
        echo json_encode($query->result());
      }
      
      
      public function insertUsermaster()
    { 
        $orgid =$_SESSION['orgid'];
        $fname =  isset($_REQUEST['fname'])?ucfirst($_REQUEST['fname']):0;
        
        $lname =  isset($_REQUEST['lname'])?ucfirst($_REQUEST['lname']):0;
        $area =  isset($_REQUEST['area'])?$_REQUEST['area']:0;
        $ecode =  isset($_REQUEST['ecode'])?$_REQUEST['ecode']:'';
        $dob =  isset($_REQUEST['dob'])?$_REQUEST['dob']:0;
      $zone=getTimeZone($orgid);
        date_default_timezone_set($zone);
        $doj =  date("Y-m-d");//isset($_REQUEST['doj'])?$_REQUEST['doj']:0;
        $doc =  $doj;//isset($_REQUEST['doc'])?$_REQUEST['doc']:0;
        $gen =  isset($_REQUEST['gen'])?$_REQUEST['gen']:0;
        $nat =  isset($_REQUEST['nat'])?$_REQUEST['nat']:0;
        $ms  =  isset($_REQUEST['ms'])?$_REQUEST['ms']:0;
        $rel =  isset($_REQUEST['rel'])?$_REQUEST['rel']:0;
        $bg  =  isset($_REQUEST['bg'])?$_REQUEST['bg']:0;
        $dept =  isset($_REQUEST['dept'])?$_REQUEST['dept']:0;
        $desg =  isset($_REQUEST['desg'])?$_REQUEST['desg']:0;
        $shift =  isset($_REQUEST['shift'])?$_REQUEST['shift']:0;
        $sts   =  isset($_REQUEST['sts'])?$_REQUEST['sts']:0;
        $sts1  =  isset($_REQUEST['sts1'])?$_REQUEST['sts1']:0;
        $country  =  isset($_REQUEST['country'])?$_REQUEST['country']:0;
        $city =  isset($_REQUEST['city'])?$_REQUEST['city']:0;
        $password = encode5t(isset($_REQUEST['password'])?$_REQUEST['password']:0);
        $email =  encode5t(isset($_REQUEST['email'])?strtolower($_REQUEST['email']):0);
        $addr =  encode5t(isset($_REQUEST['addr'])?$_REQUEST['addr']:0);
         $cont = isset($_REQUEST['PersonalNo'])? encode5t($_REQUEST['PersonalNo']):0;
   //  echo encode5t($_REQUEST['PersonalNo']);
       $profile=isset($_FILES["prof"])?$_FILES["prof"]:"";
       
         $check=true;
       $locProfile=IMGURL2."uploads/$orgid/";
         $zone=getTimeZone($orgid);
        date_default_timezone_set($zone);
        $date=date('Y-m-d H:i:s');
      
      if (!file_exists($locProfile))
      {
        mkdir($locProfile ,0777,true);
      }
      
      //////////---------check users limit
    /*  $query = $this->db->query("select count(id) as totalUsers,(select NoOfEmp from Organization where Organization.Id =$orgid) as ulimit from UserMaster where OrganizationId = $orgid");
        if ($r=$query->result())
        {
          if($r[0]->totalUsers>=$r[0]->ulimit)
          {
            $subject=getAdminName($orgid).", your user limit has exceeded.";
            $message="<div style='color:black'>
            Dear Subscriber<br/><br/>

            The no. of users in your Subscription of ubiAttendance  have exceeded. <br/>

            No worries! You can add more users. We will update your plan in the next month’s subscription.<br/><br/>

            <b>Your Current Plan:</b><br/>
            Company name: ".getOrgName($orgid)."<br/>
            Current users: ".($r[0]->totalUsers + 1)."<br/>
            User limit: ".$r[0]->ulimit."<br/><br/><br/>



            Cheers,<br/>
            Team ubiAttendance</div>";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
            $adminMail=getAdminEmail($orgid);
            sendEmail_new($adminMail,$subject,$message,$headers);
            sendEmail_new('vijay@ubitechsolutions.com',$subject,$message,$headers);
            sendEmail_new('ubiattendance@ubitechsolutions.com',$subject,$message,$headers);
          }
        }*/
      //////////---------check user slimit--close
          if($email!=''){
             $sql = "Select Id from UserMaster where Username = '$email'";
             $query = $this->db->query($sql);
           $query->num_rows();
          if($query->num_rows() > 0 )
        {
            $check=false;
            echo 1;
            return;
          }
          }
          if($cont!='')
        {
              $sql = "Select Id from EmployeeMaster where (PersonalNo = '$cont' AND Is_Delete != 2)  ";
            $query = $this->db->query($sql);
            $query->num_rows();
            if($query->num_rows() > 0 )
          {
              $check=false;
              echo 2;
              return;
          }
            
          }
        if($ecode!='' && $ecode!='0')
        {
             $sql = "Select * from EmployeeMaster where EmployeeCode = ? and OrganizationId=? and Is_Delete != 2";
           $query = $this->db->query($sql,array($ecode,$orgid ));
           $query->num_rows();
          if($query->num_rows() > 0 )
            {
            $check=false;
            echo 3;
            return;
            }
          
        }
          
         
          if($check)
        { 
      if($profile)
      {
          $sql = "INSERT INTO EmployeeMaster (FirstName,LastName,EmployeeCode,DOB,DOJ,DOC,Gender,Nationality,MaritalStatus,Religion,BloodGroup,Department,Designation,Shift,archive,CurrentCountry,HomeCity,HomeAddress,PersonalNo,OrganizationId,CreatedDate,area_assigned,CompanyEmail) VALUES 
        (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
          $this->db->query($sql,array($fname,$lname,
        $ecode,$dob,$doj,$dob,$gen,$nat,$ms,$rel,$bg,$dept,$desg,$shift,$sts,$country,$city,$addr,$cont,$orgid,$date,$area,$email)); 
          $emp_id = $this->db->insert_id();
        $uid=$emp_id.".jpg";
        //print_r($_FILES["prof"]["tmp_name"]);
        //echo $locProfile.$uid;
        
        if(move_uploaded_file($_FILES["prof"]["tmp_name"],$locProfile.$uid))
        {
        $sql = "update EmployeeMaster set ImageName=? where OrganizationId = ? and id =? ";
        $query = $this->db->query($sql,array($uid,$orgid,$emp_id));
        }
      }
    else
    {
      $sql = "INSERT INTO EmployeeMaster (FirstName,LastName,EmployeeCode,DOB,DOJ,DOC,Gender,Nationality,MaritalStatus,Religion,BloodGroup,Department,Designation,Shift,archive,CurrentCountry,HomeCity,HomeAddress,PersonalNo,OrganizationId,CreatedDate,area_assigned,CompanyEmail) VALUES 
        (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
      $this->db->query($sql,array($fname,$lname,
        $ecode,$dob,$doj,$dob,$gen,$nat,$ms,$rel,$bg,$dept,$desg,$shift,$sts,$country,$city,$addr,$cont,$orgid,$date,$area,$email)); 
        $emp_id = $this->db->insert_id();
    }
        
        $result =  $this->db->affected_rows();
          if($result >0){
            $sql = "INSERT INTO UserMaster (EmployeeId,Password,Username,username_mobile,appSuperviserSts,Archive,OrganizationId) VALUES ($emp_id,'$password','$email','$cont','$sts1','$sts',$orgid)";
            $this->db->query($sql);
            $result =  $this->db->affected_rows();
            if($result >0){
              ///////////////////mail drafted
            
              ///////////////////////mail drafted
             //////////////////mail to emp
              $empmailid=$_REQUEST['email'];
             if($empmailid!=''){ // trigger mail to employee
                /*$message="<html>
              <head>
              <title></title>
              </head>
            <body>
            <p>You are registered in ubiAttendance App for “ Ubitech Solutions”. Kindly punch your attendance through the following steps.</p>
            <ol>
            <li> 
              Download the Android App by clicking <a  
              href='https://play.google.com/store/apps/details?id=org.ubitech.attendance.'>https://play.google.com/store/apps/details?id=org.ubitech.attendance.</a> 
              iPhone users can download through 
              <a href='https://itunes.apple.com/us/app/ubiattendance-ubitech/id1375252261?mt=8 '>https://itunes.apple.com/us/app/ubiattendance-ubitech/id1375252261?mt=8</a>
            </li>
            <li>Install the App.  It will be added to the home screen</li>
            <li>Open the App & sign in. User name will be the registered Email/Phone no.</li>
            <li>Initial Sign in Password is 12345678.</li>
            <li>You can now start punching the attendance.</li>
            <li>Download the detailed Employee guide</li>
            </ol>
            </body>
            </html>
              ";*/
              $message="<html>
          <head>
          <title>ubiAttendance</title>
          </head>
          <body>
          Congratulations <b>".$fname."</b>!!<br/>
          You are registered on ubiAttendance App for ".getOrgName($orgid)." .<br/>
          <ol>
          <li>Download & install the App through any of the links below:</li>
            <ol>
            <li>Android -<a href='https://play.google.com/store/apps/details?id=org.ubitech.attendance'>https://play.google.com/store/apps/details?id=org.ubitech.attendance</a></li>
            <li>iPhone -<a href='https://itunes.apple.com/us/app/ubiattendance-ubitech/id1375252261?mt=8 '>https://itunes.apple.com/us/app/ubiattendance-ubitech/id1375252261?mt=8</a></li>
            </ol>
            <li>Open the App & sign in.</li>
            Login details for Mobile App<br/>
            Username: ".$_REQUEST['email']."<br/>
            Password: ".decode5t($password)."<br/>
            OR<br/>
            Username: ".$_REQUEST['PersonalNo']."<br/>
            Password: ".decode5t($password)."<br/>
            <li>Click on “Time In” button to punch attendance.</li>
          </ol>
          <p>For further assistance, kindly contact your system administrator.</p>
          <h5>Cheers,</h5>
          <h5>ubiAttendance Team</h5>
          </body>
          </html>"; 
          //echo $message;
              // Always set content-type when sending HTML email
              $headers = "MIME-Version: 1.0" . "\r\n";
              $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
              // More headers
              $headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
              //$headers .= 'Cc: vijay@ubitechsolutions.com' . "\r\n";
              $subject="You have registered on ubiAttendance.";
            //  sendEmail_new($email,$subject,$message,$headers);
              
              sendEmail_new($empmailid,$subject,$message,$headers);
              //sendEmail_new('vijay@ubitechsolutions.com',$subject,$message,$headers);
              //sendEmail_new('sohan@ubitechsolutions.com',$subject,$message,$headers);
              sendEmail_new('ubiattendance@ubitechsolutions.com',$subject,$message,$headers);
             }
           
             //////////////////mail to emp-close
           else
           {
             $message="<html>
              <head>
              <title></title>
              </head>
            <body>
            <h3>Dear Admin,</h3>
            <p>Please send the below message through text or Email to the Employee to get him started. The message below is already sent to the Employees with valid Email ID</p>
            <p>You are registered in ubiAttendance App for “ Ubitech Solutions”. Kindly punch your attendance through the following steps.</p>
            <ol>
            <li> 
              Download the Android App by clicking <a  
              href='https://play.google.com/store/apps/details?id=org.ubitech.attendance.'>https://play.google.com/store/apps/details?id=org.ubitech.attendance.</a> 
              iPhone users can download through 
              <a href='https://itunes.apple.com/us/app/ubiattendance-ubitech/id1375252261?mt=8 '>https://itunes.apple.com/us/app/ubiattendance-ubitech/id1375252261?mt=8</a>
            </li>
            <li>Install the App.  It will be added to the home screen</li>
            <li>Open the App & sign in. User name will be the registered Email/Phone no.</li>
            <li>Initial Sign in Password is ".decode5t($password)."</li>
            <li>You can now start punching the attendance.</li>
            <li>Download the detailed Employee guide</li>
            </ol>
            <p>For further assistance, kindly contact your system administrator.</p>
            <h5>Cheers,</h5>
            <h5>ubiAttendance Team</h5>
            </body>
            </html>";
        
          /*
            You can edit Employee’s Profile through the Web Application.<br/>
              Admin Login for Web Application<br/>
              Login URL: https://ubiattendance.ubihrm.com<br/>
              Company's Reference No. (CRN): <b>".encode_vt5($orgid)."</b><br/>
              User Id: <b>".getAdminUsername($orgid)."</b><br/>
              Password: Sent in the registration<br/>*/
            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            // More headers
            $headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
            //$headers .= 'Cc: vijay@ubitechsolutions.com' . "\r\n";
            $subject="UbiAttendance New Employee Registration.";
          //  sendEmail_new($email,$subject,$message,$headers);
            $adminMail=getAdminEmail($orgid);
            sendEmail_new($adminMail,$subject,$message,$headers);
            //sendEmail_new('vijay@ubitechsolutions.com',$subject,$message,$headers);
            //sendEmail_new('sohan@ubitechsolutions.com',$subject,$message,$headers);
            sendEmail_new('ubiattendance@ubitechsolutions.com',$subject,$message,$headers);
          //echo $message;
           }
           //////////---------check users limit
    $query = $this->db->query("select count(id) as totalUsers,(select NoOfEmp from Organization where Organization.Id =$orgid) as ulimit,(select status from licence_ubiattendance where licence_ubiattendance.OrganizationId =$orgid) as orgstatus from UserMaster where OrganizationId = $orgid");
    
      if ($r=$query->result())
      {
        if($r[0]->totalUsers > $r[0]->ulimit)
        {
          $range='1-20';
          if($r[0]->totalUsers<21)
            $range='1-20';
          else if($r[0]->totalUsers>=21 && $r[0]->totalUsers<41)
            $range='21-40';
          else if($r[0]->totalUsers>=41 && $r[0]->totalUsers<61)
            $range='41-60';
          else if($r[0]->totalUsers>=61 && $r[0]->totalUsers<81)
            $range='61-80';
          else if($r[0]->totalUsers>=81 && $r[0]->totalUsers<101)
            $range='81-100';
          else if($r[0]->totalUsers>=101 && $r[0]->totalUsers<121)
            $range='101-120';
          else
            $range='120+';
          
          $sdate='-'; 
          $edate='-'; 
          $country=93;  
          $rate_per_day=0;
          $days=0;
          $currency='';
          $due=0;
          
          $bulk_att_price1=0;
          $location_tracing_price1=0;
          $visit_punch_price1=0;
          $geo_fence_price1=0;
          $payroll_price1=0;
          $time_off_price1=0;
          
          $bulk_att_price_per_day=0;
          $location_tracing_price_per_day=0;
          $visit_punch_price_per_day=0;
          $geo_fence_price_per_day=0;
          $payroll_price_per_day=0;
          $time_off_price_per_day=0;
          
          $orgstatus=$r[0]->orgstatus;
          
          $query1 = $this->db->query("select start_date,end_date,due_amount,DATEDIFF(end_date,CURDATE())as days,(SELECT `Country` FROM `Organization` WHERE `Id`=$orgid)as country,Addon_BulkAttn,Addon_LocationTracking,Addon_VisitPunch,Addon_GeoFence,Addon_Payroll,Addon_TimeOff from licence_ubiattendance where OrganizationId  =$orgid");
          if ($r1=$query1->result())
          {
            $sdate  = $r1[0]->start_date; 
            $edate  = $r1[0]->end_date;
            $days = $r1[0]->days;
            $due  = $r1[0]->due_amount;
            $currency=  $r1[0]->country==93?'INR':'USD';
            
            $bulk_att_addon=  $r1[0]->Addon_BulkAttn;
            $location_addon=  $r1[0]->Addon_LocationTracking;
            $visitpunch_addon=  $r1[0]->Addon_VisitPunch;
            $geofence_addon=  $r1[0]->Addon_GeoFence;
            $payroll_addon= $r1[0]->Addon_Payroll;
            $timeoff_addon= $r1[0]->Addon_TimeOff;
            
            
              $query2 = $this->db->query("SELECT  monthly FROM `Attendance_plan_master` WHERE `range`='$range' and `currency`='$currency' ");
              if ($r2=$query2->result())
              $rate_per_day = ($r2[0]->monthly)/30 ;
            
            
                $query2 = $this->db->query("SELECT  bulk_attendance,location_tracing,visit_punch,geo_fence,payroll,
                time_off  FROM `Attendance_plan_master` WHERE `range`='$range' and `currency`='$currency' ");
                if ($r2=$query2->result())
                {
                $bulk_att_price_per_day=($r2[0]->bulk_attendance)/30;
                $location_tracing_price_per_day=($r2[0]->location_tracing)/30;
                $visit_punch_price_per_day=($r2[0]->visit_punch)/30;
                $geo_fence_price_per_day=($r2[0]->geo_fence)/30;
                $payroll_price_per_day=($r2[0]->payroll)/30;
                $time_off_price_per_day=($r2[0]->time_off)/30;
                }
              
              if($bulk_att_addon!=0)
              {
              $bulk_att_price1=$bulk_att_price_per_day;
              }
              if($location_addon!=0)
              {
              $location_tracing_price1=$location_tracing_price_per_day;
              }
              if($visitpunch_addon!=0)
              {
              $visit_punch_price1=$visit_punch_price_per_day;
              }
              if($geofence_addon!=0)
              {
              $geo_fence_price1=$geo_fence_price_per_day;
              }
              if($payroll_addon!=0)
              {
              $payroll_price1=$payroll_price_per_day;
              }
              if($timeoff_addon!=0)
              {
              $time_off_price1=$time_off_price_per_day;
              }
            
          }
            
            
          
          
          $payable_amt=0;
          $tax=0;
          $total=0;
          if($currency=='INR')
          $tax=($bulk_att_price1+$location_tracing_price1+$visit_punch_price1+$geo_fence_price1+$payroll_price1+$time_off_price1+$rate_per_day)*($days)*(0.18);
        
          $payable_amt= ($bulk_att_price1+$location_tracing_price1+$visit_punch_price1+$geo_fence_price1+$payroll_price1+$time_off_price1+$rate_per_day)*$days;
          //$payable_amt_addon=($bulk_att_price1+$location_tracing_price1+$visit_punch_price1+$geo_fence_price1+$payroll_price1+$time_off_price1)*$days;
          
          $payamtwidtax = round(($payable_amt+$tax),2);
          
          $total    = round(($due+$tax+$payable_amt),2);
          
          
          
        /////////////update due amount-start
        
          $query1 = $this->db->query("UPDATE `licence_ubiattendance` SET `due_amount`=$total WHERE `OrganizationId` =$orgid");
          
        /////////////update due amount-close
        if($orgstatus==1){
          $subject=getOrgName($orgid)." -Billing details for additional users ";
          //$subject="ubiAttendance - Exceeded User Limit";
          $message="<div style='color:black'>
          Greetings from ubiAttendance App<br/><br/>
          The no. of users in your ubiAttendance Plan have exceeded. We have updated your plan.  Below are the payment details for the additional Users. <br/>
          <h4 style='color:blue'>Plan Details:</h4>
          Company name: ".getOrgName($orgid)."<br/>
          Plan Start Date:".date('d-M-Y',strtotime($sdate))."<br/>
          Plan End Date:".date('d-M-Y',strtotime($edate))."<br/>
          User limit: ".$r[0]->ulimit."<br/>
          Registered Users: ".($r[0]->totalUsers)."<br/>
          <br/>
          <h4 style='color:blue'>Billing Details:</h4>
          Previous Dues: ".$due.' '.$currency." <br/>
          Amount Payable for additional Users: ".$payamtwidtax.' '.$currency."<br/>
          Amount Payable: ".$payamtwidtax." + ".$due." = ".$total." ".$currency." <br/>
          <br/>
          <a href='".URL."'>Update your plan now</a> so that there is no disruption in our services<br/><br/>";
          $message.="Cheers,<br/>
          Team ubiAttendance<br/><a target='_blank' href='http://www.ubiattendance.com'>www.ubiattendance.com</a><br/> Tel/ Whatsapp: +91 70678 22132<br/>Email: ubiattendance@ubitechsolutions.com<br/>Skype: ubitech.solutions</div>";
          $headers = "MIME-Version: 1.0" . "\r\n";
          $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
          $headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
          Trace("<br/><br/>Insert Message:   ".$message);
          $adminMail=getAdminEmail($orgid);
          sendEmail_new($adminMail,$subject,$message,$headers);
          sendEmail_new('ubiattendance@ubitechsolutions.com',$subject,$message,$headers);
          sendEmail_new('sohan@ubitechsolutions.com',$subject,$message,$headers);
            //sendEmail_new('deeksha@ubitechsolutions.com',$subject,$message,$headers);
          //sendEmail_new('vijay@ubitechsolutions.com',$subject,$message,$headers);
        }
        
        }
      }
    //////////---------check user slimit--close
    
            /// Activity log data insert by sohan
          
             $date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $id =$_SESSION['id'];
           $module = "Employees";
           $actionperformed = " <b>".$fname." ".$lname."</b> has been added from <b>Add Employee </b>.";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id)); 
              $this->db->close();
              echo 4;
            }
            
          }
        
        }
      }
      ///////////////////////emport bulk EMP data file///////////////////// 
      public function emportEmp($request)
    {
      //$result1 = array();
        $errormsg = ""; $count = ""; $success = "";
        $user_id = $_SESSION['id'];
        $orgid = $_SESSION['orgid'];
        //return print_r($request);
        $fname =  $request[0];  
        $lname =  $request[1];
        $email =  $request[2];
        $cont = $request[3];
        $shift =  $request[4];
        $dept = $request[5];
        $desg =  $request[6];
        $password = $request[3];
         $ecode = $request[7];
         $country = $request[8];
         $check=true;
         $zone=getTimeZone($orgid);
        date_default_timezone_set($zone);
        $date=date('Y-m-d');
        $file_name = "newjoining.csv";
        $location = IMGURL."employee/$orgid/";
        $fp = $location.$file_name;
        $remark = "data insufficient";
        $sts = 0;
        $i = 0;
      $j = 0;
      $rer = "";
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
            if($data[5] == "" || $data[6] == "" || $data[$fname] == "" || $data[$lname] == "" || $data[3] == "" || $data[4] == "")  
            {   
          //$sql1 = $this->db->query("INSERT INTO Temp_user_csv(FirstName,LastName,EmployeeCode,Department,Designation,Shift,PersonalNo,OrganizationId,CreatedDate,email,Archive,createdBy,remark) VALUES ('".$data[$fname]."','".$data[$lname]."','".$data[$ecode]."','".$data[5]."','".$data[6]."','".$data[4]."','".$data[3]."','$orgid','$date','".$data[$email]."',$sts,$user_id,'$remark')");
          
          $sql1 = "INSERT INTO Temp_user_csv(FirstName,LastName,EmployeeCode,Department,Designation,Shift,PersonalNo,OrganizationId,CreatedDate,email,Archive,createdBy,remark,country) VALUES 
              (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
          $this->db->query($sql1,array($data[$fname],$data[$lname],
            $data[$ecode],$data[5],$data[6],$data[4],$data[3],$orgid,$date,$data[$email],$sts,$user_id,$remark,$data[8]));
          
          
          $result = $this->db->affected_rows();
        
          if($result >0)
          {
            $check=false;
          }
            } 
        
         if($data[2] != '')
          {   
              $query = $this->db->query("select Id FROM UserMaster WHERE Username =? ",array(encode5t($data[$email])));
          
          if($query->num_rows() > 0){
             $check=false;
            $remark1 = "Email Id already exist.";
          //$sql2 = $this->db->query("INSERT INTO Temp_user_csv(FirstName,LastName,EmployeeCode,Department,Designation,Shift,PersonalNo,OrganizationId,CreatedDate,email,Archive,createdBy,remark) VALUES ('".$data[$fname]."','".$data[$lname]."','".$data[$ecode]."','".$data[$dept]."','".$data[$desg]."','".$data[$shift]."','".$data[$cont]."','$orgid','$date','".$data[$email]."','$sts','$user_id','$remark1')"); 
        
        $sql2 = "INSERT INTO Temp_user_csv(FirstName,LastName,EmployeeCode,Department,Designation,Shift,PersonalNo,OrganizationId,CreatedDate,email,Archive,createdBy,remark,country) VALUES 
              (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
          $this->db->query($sql2,array($data[$fname],$data[$lname],
            $data[$ecode],$data[$dept],$data[$desg],$data[$shift],$data[$cont],$orgid,$date,$data[$email],$sts,$user_id,$remark1,$data[8]));
        
            }
        }
        
         if($data[3] != '')
          {
           $query1 =$this->db->query("select Id FROM EmployeeMaster WHERE PersonalNo =? ",array(encode5t($data[$cont])));
          
          $query1->num_rows();
          if($query1->num_rows() > 0 )
          {
            $j++;
            $check = false;
            $remark2 = "Contact number already exist.";
            //$sql1 = $this->db->query("INSERT INTO Temp_user_csv(FirstName,LastName,EmployeeCode,Department,Designation,Shift,PersonalNo,OrganizationId,CreatedDate,email,Archive,createdBy,remark) VALUES ('".$data[$fname]."','".$data[$lname]."','".$data[$ecode]."','".$data[$dept]."','".$data[$desg]."','".$data[$shift]."','".$data[$cont]."','$orgid','$date','".$data[$email]."','$sts','$user_id','$remark2')");
            
            $sql1 = "INSERT INTO Temp_user_csv(FirstName,LastName,EmployeeCode,Department,Designation,Shift,PersonalNo,OrganizationId,CreatedDate,email,Archive,createdBy,remark,country) VALUES 
              (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
          $this->db->query($sql1,array($data[$fname],$data[$lname],
            $data[$ecode],$data[$dept],$data[$desg],$data[$shift],$data[$cont],$orgid,$date,$data[$email],$sts,$user_id,$remark2,$data[$country]));
            
          } 
          }
          
          if($data[7] != '')
            {
            $query2 = $this->db->query("select Id FROM EmployeeMaster WHERE EmployeeCode=? AND OrganizationId = ?",array($data[$ecode],$orgid));
          $query2->num_rows();
         if($query2->num_rows() > 0)
          {
            $check=false;
            $remark3 = "Employee code already exist.";
            
            //$sql3 = $this->db->query("INSERT INTO Temp_user_csv(FirstName,LastName,EmployeeCode,Department,Designation,Shift,PersonalNo,OrganizationId,CreatedDate,email,Archive,createdBy,remark) VALUES ('".$data[$fname]."','".$data[$lname]."','".$data[$ecode]."','".$data[$dept]."','".$data[$desg]."','".$data[$shift]."','".$data[$cont]."','$orgid','$date','".$data[$email]."','$sts','$user_id','$remark3')");
            
            $sql3 = "INSERT INTO Temp_user_csv(FirstName,LastName,EmployeeCode,Department,Designation,Shift,PersonalNo,OrganizationId,CreatedDate,email,Archive,createdBy,remark,country) VALUES 
              (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $this->db->query($sql3,array($data[$fname],$data[$lname],
            $data[$ecode],$data[$dept],$data[$desg],$data[$shift],$data[$cont],$orgid,$date,$data[$email],$sts,$user_id,$remark3,$data[$country]));
            
            
            
          }     
       }
           // edit by sohan
           if($check)
           {
           $dept1= getDepartmentId_create($data[5],$orgid);
           $desg1 = getDesignationId_create($data[6],$orgid);
           $shift1 = getshiftId($data[4],$orgid);
         $remarks = "";
         if($dept1 == 0)// if department not found
         {
          $remarks = "department not found."; 
         }
          else 
          if($desg1==0) // if destination not found
         {
          $remarks = "Designation not found."; 
         }
        else if($shift1==0) // if shift not found
         {
          $remarks = "Shift not found."; 
         }
         
       if($remarks != "")
         {
          $sql = $this->db->query("INSERT INTO Temp_user_csv(FirstName,LastName,EmployeeCode,Department,Designation,Shift,PersonalNo,OrganizationId,CreatedDate,email,Archive,createdBy,remark,country) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($data[$fname],$data[$lname],$data[$ecode],$data[$dept],$data[$desg],$data[$shift],$data[$cont],$orgid,$date,$data[$email],$sts,$user_id,$remarks,$data[$country]));
         }
         else
         {   
        //  $sql2 = $this->db->query("INSERT INTO EmployeeMaster(FirstName,LastName,EmployeeCode,Department,Designation,Shift,PersonalNo,OrganizationId,CreatedDate,DOC,DOJ) VALUES ('".$data[$fname]."','".$data[$lname]."','".$data[$ecode]."','$dept1','$desg1','$shift1','".encode5t($data[$cont])."','$orgid','$date','$date','$date')");
        
        $sql2 = "INSERT INTO EmployeeMaster(FirstName,LastName,EmployeeCode,Department,Designation,Shift,PersonalNo,OrganizationId,CreatedDate,DOC,DOJ,CompanyEmail,CurrentCountry) VALUES 
              (?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $this->db->query($sql2,array($data[$fname],$data[$lname],
            $data[$ecode],$dept1,$desg1,$shift1,encode5t($data[$cont]),$orgid,$date,$date,$date,$data[$email],$data[$country]));
        
          $result = $this->db->affected_rows($sql2);
          $emp_id = $this->db->insert_id();
          $count = $count+1;
        
          if($result > 0)
          { 
            $password = 123456;
            $pass = encode5t($password);
            $sql3 = $this->db->query("INSERT INTO UserMaster (CreatedDate,EmployeeId,Username,username_mobile,Password,OrganizationId) VALUES ('$date','$emp_id','".encode5t($data[$email])."','".encode5t($data[$cont])."','$pass','$orgid')");
            $result =  $this->db->affected_rows($sql3);
            }
        ////////////////////////////
            
          
        }
        }
        }
         $i++;
       
        }
        }
        $message="<html>
              <head>
              <title>ubiAttendance</title>
              </head>
            <body>
            <p>Please send the below message through text or Email to the Employees to get them started.</p>
            <p>You are registered in ubiAttendance App for “ Ubitech Solutions”. Kindly punch your attendance through the following steps.</p>
            <ol>
            <li>
              Download the Android App by clicking 
              <a  href='https://play.google.com/store/apps/details?id=org.ubitech.attendance'>https://play.google.com/store/apps/details?id=org.ubitech.attendance</a> 
              iPhone users can download through 
              <a href='https://itunes.apple.com/us/app/ubiattendance-ubitech/id1375252261?mt=8 '>https://itunes.apple.com/us/app/ubiattendance-ubitech/id1375252261?mt=8</a>
            </li>
            <li>Install the App. It will be added to the home screen</li>
            <li>Open the App & sign in. User name will be the registered Email/Phone no.</li>
            <li>Initial Sign in Password is ".$password."</li>
            <li>You can now start punching the attendance.</li>
            <li>Download the detailed Employee guide</li>
            </ol>
            </body>
            </html>";
            
      /*$message="<html>
          <head>
          <title>ubiAttendance</title>
          <body>
          Congratulations <b>".$data[$fname]."</b>!!<br/>
          You are registered on ubiAttendance App for ".getOrgName($orgid)." .<br/>
          <ol>
          <li>Download & install the App through any of the links below:</li>
            <ol>
            <li>Android -<a  
              href='https://play.google.com/store/apps/details?id=org.ubitech.attendance'>https://play.google.com/store/apps/details?id=org.ubitech.attendance</a></li>
            <li>iPhone -<a href='https://itunes.apple.com/us/app/ubiattendance-ubitech/id1375252261?mt=8 '>https://itunes.apple.com/us/app/ubiattendance-ubitech/id1375252261?mt=8</a></li>
            </ol>
            <li>Open the App & sign in.</li>
            Login details for Mobile App<br/>
            Username: ".$_REQUEST['PersonalNo']."<br/>
            Password: ".$password."<br/>
            <li>Click on “Time In” button to punch attendance.</li>
          </ol>
          <p>For further assistance, kindly contact your system administrator.</p>
          <h5>Cheers,</h5>
          <h5>ubiAttendance Team</h5>
          </body>
            
          </head>
          </html>";*/
          
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
            $subject="Import employee";
            $adminMail=getAdminEmail($orgid);
            sendEmail_new($adminMail,$subject,$message,$headers);
          
        $result1 = array("repeatemp"=>$totalcount, "importemp"=>$count, "sts"=>"true","rer"=>$j);  
        $check=true;
        return $result1;
      }
      public function deleteTmp()
    {
        $orgid = $_SESSION['orgid'];
      $query=$this->db->query("DELETE FROM Temp_user_csv WHERE OrganizationId ='$orgid'");
      if($query >0)
      {
        return TRUE;
      }
    } 
      
      public function getEmpotTmp(){
      $orgid = $_SESSION['orgid'];
      $date = date('y-m-d');
      $res = array();
      $d = array();
    $query  =$this->db->query("select FirstName,CreatedDate,LastName,Designation,Department,Shift,PersonalNo,email,EmployeeCode,remark FROM Temp_user_csv WHERE CreatedDate='$date' AND OrganizationId='$orgid' ");
    
    foreach($query->result() as $row)
    { $data = array();
      $data['fname'] = $row->FirstName;
      $data['lname'] = $row->LastName;
      $data['desg'] = $row->Designation;
      $data['deprt'] = $row->Department;
      $data['shift'] = $row->Shift;
      $data['cont'] = $row->PersonalNo;
      $data['email'] = $row->email;
      $data['ecode'] = $row->EmployeeCode;      
      $data['Date'] = $row->CreatedDate;
      $data['remark'] = $row->remark;
      $res[] = $data;
    }
      $d['data'] = $res;
      echo json_encode($d);
    }   
        
    
    public function getHourlyRate()
    {
        $orgid =$_SESSION['orgid'];
        $id =  isset($_REQUEST['id'])?$_REQUEST['id']:0;
        $sql = "SELECT Id FROM `HourlyRateMaster` where Name='$id' ";
        $query = $this->db->query($sql);
      
        foreach ($query->result() as $row)
        {
        echo $row->Id;
        } 
    }
    
    
    
      public function editUsermaster()
    {  
    
        $orgid =$_SESSION['orgid'];
        $fname =  isset($_REQUEST['fname'])?$_REQUEST['fname']:0;
        $lname =  isset($_REQUEST['lname'])?$_REQUEST['lname']:0;
        $ecode =  isset($_REQUEST['ecode'])?$_REQUEST['ecode']:'';
        $dob =  isset($_REQUEST['dob'])?$_REQUEST['dob']:0;
        $area = isset($_REQUEST['areaE'])?$_REQUEST['areaE']:0;
        $doj =  isset($_REQUEST['doj'])?$_REQUEST['doj']:0;
        $doc =  isset($_REQUEST['doc'])?$_REQUEST['doc']:0;
        $gen =  isset($_REQUEST['gen'])?$_REQUEST['gen']:0;
        $nat =  isset($_REQUEST['nat'])?$_REQUEST['nat']:0;
        $ms =  isset($_REQUEST['ms'])?$_REQUEST['ms']:0;
        $rel =  isset($_REQUEST['rel'])?$_REQUEST['rel']:0;
        $bg =  isset($_REQUEST['bg'])?$_REQUEST['bg']:0;
        $dept =  isset($_REQUEST['dept'])?$_REQUEST['dept']:0;
        $desg =  isset($_REQUEST['desg'])?$_REQUEST['desg']:0;
        $shift =  isset($_REQUEST['shift'])?$_REQUEST['shift']:0;
        $sts =  isset($_REQUEST['sts'])?$_REQUEST['sts']:0;
        $sstatus =  isset($_REQUEST['sstatus'])?$_REQUEST['sstatus']:0;
        $country =  isset($_REQUEST['country'])?$_REQUEST['country']:0;
        $city =  isset($_REQUEST['city'])?$_REQUEST['city']:0;
        $hourlyrate =  isset($_REQUEST['hourlyrateE'])?$_REQUEST['hourlyrateE']:0;
        $email =  encode5t(isset($_REQUEST['email'])?$_REQUEST['email']:"");
        $password = encode5t(isset($_REQUEST['password'])?$_REQUEST['password']:0);
        $addr =  encode5t(isset($_REQUEST['addr'])?$_REQUEST['addr']:0);
        $PersonalNo =encode5t(isset($_REQUEST['PersonalNo'])?$_REQUEST['PersonalNo']:0);
        $desc =  isset($_REQUEST['desc'])?$_REQUEST['desc']:0;
        $empid =  isset($_REQUEST['empid'])?$_REQUEST['empid']:0;
      $locProfile=IMGURL2."uploads/$orgid/";
      $profileE=isset($_FILES["profE"])?$_FILES["profE"]:"";
      
      $new_name   = $empid.".jpg";
      
      if (!file_exists($locProfile))
      {
      mkdir($locProfile ,  0777,true);
      }
      // if(file_exists($locProfile.$new_name))
      // {
      // unlink($locProfile.$new_name);
      // }
      
         if($PersonalNo!=''){
              $sql = "Select Id from UserMaster where username_mobile = '$PersonalNo' and OrganizationId = $orgid and EmployeeId != $empid";
             $query = $this->db->query($sql);
             $query->num_rows();
            if($query->num_rows() > 0 )
          {
              echo 4;
              return;
              }
            
          }
        if($email!=''){
              $sql = "Select Id from UserMaster where Username = ? and OrganizationId = ? and EmployeeId != ?";
             $query = $this->db->query($sql,array($email,$orgid,$empid));
             $query->num_rows();
            if($query->num_rows() > 0 )
          {
              echo 2;
              return;
              }
            
          }
        if($ecode!='' && $ecode!='0')
        {
             $sql = "Select Id from EmployeeMaster where EmployeeCode =?  and OrganizationId=? and id != ? ";
           $query = $this->db->query($sql,array($ecode,$orgid,$empid));
           $query->num_rows();
          if($query->num_rows() > 0 )
          {
            $check=false;
            echo 3;
            return;
          }
          
        }
         
      if(isset($_FILES["profE"]))
      {
          if (move_uploaded_file($_FILES["profE"]["tmp_name"], $locProfile.$new_name))
        {
        $updSts=0;
        $sql = "update EmployeeMaster set FirstName =? ,LastName= ?,EmployeeCode=?,Gender =? ,Nationality = ?, MaritalStatus =? ,Religion = ? ,BloodGroup =?,Department =? ,Designation = ?,Shift = ? ,archive = ?,CurrentCountry = ? ,HomeCity = ? , HomeAddress = ?, PersonalNo =?,area_assigned =?,hourly_rate=?,CurrentEmailId= ?,ImageName=?,CompanyEmail=? where OrganizationId = ? and id =?";

        $query = $this->db->query($sql,array($fname,$lname,$ecode,$gen,$nat,$ms,$rel,$bg,$dept,$desg,$shift,$sts,$country,$city,$addr,$PersonalNo,$area ,$hourlyrate,$email,$new_name,$email,$orgid,$empid));
        $updSts+=$this->db->affected_rows();
        $sql = "update UserMaster set VisibleSts=?,appSuperviserSts=? ,username_mobile =?,Username=?,Password=? where OrganizationId = ? and EmployeeId = ?";
        $query1 = $this->db->query($sql,array($sts,$sstatus,$PersonalNo,$email,$password,$orgid,$empid));
        $updSts+=$this->db->affected_rows();
          if($updSts > 0)
        {
          /// Activity log data insert by sohan
             $date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $id =$_SESSION['id'];
           $module = "Employees";
           $actionperformed = "Update Employees Details<b>".$fname.' '.$lname."</b>";
           $activityby = 1;
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));
           $this->db->close();
        }
            echo $query; 
        }
      }
      else
      {
      $updSts=0;
        $sql = "update EmployeeMaster set FirstName =? ,LastName= ?,EmployeeCode=?,Gender =? ,Nationality = ?, MaritalStatus =? ,Religion = ? ,BloodGroup =?  ,Department =? ,Designation = ?,Shift = ? ,archive = ?,CurrentCountry = ? ,HomeCity = ? , HomeAddress = ?, PersonalNo =?,area_assigned =?,hourly_rate=?,CurrentEmailId= ?,CompanyEmail=? where OrganizationId = ? and id =?";
      
        $query = $this->db->query($sql,array($fname,$lname,$ecode,$gen,$nat,$ms,$rel,$bg,$dept,$desg,$shift,$sts,$country,$city,$addr,$PersonalNo,$area ,$hourlyrate,$email,$email,$orgid,$empid));
      
        $updSts+=$this->db->affected_rows();
        $sql = "update UserMaster set VisibleSts=?,appSuperviserSts=? ,username_mobile =?,Username=?,Password=? where OrganizationId = ? and EmployeeId = ?";
        $query1 = $this->db->query($sql,array($sts,$sstatus,$PersonalNo,$email,$password,$orgid,$empid));
        $updSts+=$this->db->affected_rows();
          if($updSts > 0)
        {
          /// Activity log data insert by sohan
             $date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $id =$_SESSION['id'];
           $module = "Employees";
           $actionperformed = "<b>".$fname.' '.$lname."</b> details has been updated from <b>Edit employee </b>";
           $activityby = 1;
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));
           $this->db->close();
        }
            echo $query; 
      }
        
      }
    public function deleteimg()
    {
      $orgid =$_SESSION['orgid'];
      $empid =  isset($_REQUEST['empid'])?$_REQUEST['empid']:0;
      $profileE=isset($_REQUEST["imageE"])?$_REQUEST["imageE"]:"";
      
        $locProfile=IMGURL2."uploads/$orgid/";
        $new_name   = $profileE;
      if($new_name)
      {
      
       if(file_exists($locProfile.$new_name))
       {
       unlink($locProfile.$new_name);
       }
      }
      $query = $this->db->query("update EmployeeMaster set ImageName='',Gender=1 where Id=$empid");
      echo $query;
    }
    
    public function editshifts()
    {    
        $orgid =$_SESSION['orgid'];
        $shift =  isset($_REQUEST['shift'])?$_REQUEST['shift']:0;


        
        $favorite =  isset($_REQUEST['favorite'])?$_REQUEST['favorite']:0;
        
      $favorite1=implode(",",$favorite);
      $name = getEmpName($favorite1);
        
      // print_r ($name);
        $sql = "update EmployeeMaster set Shift = $shift  where OrganizationId =$orgid and id IN ($favorite1)";
      
        $query = $this->db->query($sql);
            echo $query;
            if($query==true)
            {

              // return true;
              $date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $id =$_SESSION['id'];
           $sname=$_SESSION['name'];
            $favorite =  isset($_REQUEST['favorite'])?$_REQUEST['favorite']:0;
        
      $favorite1=implode(",",$favorite);
      
      $i= 0;
      for($i=0; $i<count($favorite); $i++)
            {
              $empid121 = $favorite[$i];
              // print_r($empid);

              // $querye= array($empid,$orgid);
           $module = "Employees";
           $actionperformed = " <b>Shift</b> has been <b>Updated </b>for <b>".getEmpName($empid121)."</b> from <b>Active Employees </b>.";
           $activityby =1;
           // $adminid = ;

           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id)); 
           // var_dump($this->db->last_query());
              // $this->db->close();
              // echo 4;
            }
          }

            else
            {
              return false;
            }
             
    }
      
    
    
    
    public function editgeolocation(){
        $orgid =$_SESSION['orgid'];
        $geolocation =  isset($_REQUEST['geolocation'])?$_REQUEST['geolocation']:0;
        $favorite =  isset($_REQUEST['favorite'])?$_REQUEST['favorite']:0;
      $favorite1=implode(",",$favorite);
        $sql = "update EmployeeMaster set area_assigned=$geolocation  where OrganizationId =$orgid and id IN ($favorite1)";
        $query = $this->db->query($sql);
            echo $query;
            if($query==true)
            {
              $date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $id =$_SESSION['id'];
            $favorite =  isset($_REQUEST['favorite'])?$_REQUEST['favorite']:0;
        
      $favorite1=implode(",",$favorite);
      // $name = getEmpName($favorite1);
      $i= 0;
      for($i=0; $i<count($favorite); $i++)
            {
              $empid121 = $favorite[$i];
           $module = "Employees";
           $actionperformed = " <b>Geo location</b> has been updated for <b>".getEmpName($empid121)."</b> from <b>Active Employees </b>.";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));
            }
          }
            else
            {
              return false;
            }
                }
    
    public function editdesignation(){
        $orgid =$_SESSION['orgid'];
        $desgS =  isset($_REQUEST['desgS'])?$_REQUEST['desgS']:0;
        $favorite =  isset($_REQUEST['favorite'])?$_REQUEST['favorite']:0;
      $favorite1=implode(",",$favorite);
        $sql = "update EmployeeMaster set Designation=$desgS  where OrganizationId =$orgid and id IN ($favorite1)";
        $query = $this->db->query($sql);
            echo $query;
            if($query==true)
            {
               $date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $id =$_SESSION['id'];

      //       $i= 1;
      // for($i=1; $i<=count($favorite); $i++)
      //       {
            $favorite =  isset($_REQUEST['favorite'])?$_REQUEST['favorite']:0;
        
      $favorite1=implode(",",$favorite);
      // $name = getEmpName($favorite1);
      $i= 0;
      for($i=0; $i<count($favorite); $i++)
            {
              $empid121 = $favorite[$i];
           $module = "Employees";
           $actionperformed = " <b>Designation</b> has been <b>Updated</b> for <b>".getEmpName($empid121)."</b> from <b>Active Employees </b>.";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));
            }
          }
            else
            {
              return false;
            }
                }
                
                
      public function editdepartment(){
        $orgid =$_SESSION['orgid'];
        $deptS =  isset($_REQUEST['deptS'])?$_REQUEST['deptS']:0;
        $favorite =  isset($_REQUEST['favorite'])?$_REQUEST['favorite']:0;
      $favorite1=implode(",",$favorite);
        $sql = "update EmployeeMaster set Department=$deptS  where OrganizationId =$orgid and id IN ($favorite1)";
        $query = $this->db->query($sql);
            echo $query;
            if($query==true)
            {
              $date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $id =$_SESSION['id'];
            $favorite =  isset($_REQUEST['favorite'])?$_REQUEST['favorite']:0;
        
      $favorite1=implode(",",$favorite);
      // $name = getEmpName($favorite1);
      $i= 0;
      for($i=0; $i<count($favorite); $i++)
            {
              $empid121 = $favorite[$i];
           $module = "Employees";
           $actionperformed = " <b>Department</b> has been <b>Updated </b>for <b>".getEmpName($empid121)."</b> from <b>Active Employees </b>.";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));
            }
          }
            else
            {
              return false;
            }
                         }          
    // public function QRcode()
    // {
      // $orgid =$_SESSION['orgid'];
        // $data=array();
        // $sql = "select Id from  EmployeeMaster  where `OrganizationId`=$orgid AND archive=1 AND Is_Delete = '0'";
      // //echo $sql;
      // $query = $this->db->query($sql);
      // if($query==true)
            // {
              // return true;
            // }
            // else
            // {
              // return false;
            // }
    // }
          
    
    
    
     // public function QRcode()
       // { 
      // $result = array();
      // $orgid = isset($_SESSION['orgid'])?$_SESSION['orgid']:0;
      // $list['orgid']=$orgid;
      // $sql="select Id,department,designation,shift,(select username_mobile from UserMaster where EmployeeId= EmployeeMaster.id LIMIT 1)as una,(select Password from UserMaster where EmployeeId= EmployeeMaster.id LIMIT 1)as upa from  EmployeeMaster  where `OrganizationId`=$orgid AND archive=1 AND Is_Delete = '0'";
      // $query = $this->db->query($sql,array($orgid));
      // $list['qr']=$query->result();  
      
      // $result[]=$list;
       // $this->db->close();
        // $message='';
    // foreach($result as $r){
        // $message ='';
      // if(count($r['qr'])>0)
      // {
      // $message.= '<div id="qrcode" class="container" style="width:20%;height:100%">';  
          
        // foreach($r['qr'] as $emp)
        // {
          // $message.='<div style="border:1px solid black;padding:10px;text-align:center;">';
          // $message.= '<div style="font-size:18px;">'.getEmpName($emp->Id).'</div>';
          // $message.= '<div style="color:grey">'.getDesignation($emp->designation).'</div>';
          // $message.= '<div>'.getShiftTimes($emp->shift).'</div>';
          // $message.= '<img width="150px"  src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=
      // "'.decode5t($emp->una).''.$emp->una.'"&choe=UTF-8"/><br/>';
          // $message.= '</div>';
        // }
        // $message.='<center><button class="btn btn-warning btn-block nonPrintable"    >Print</button></center></div>';
      // }
      
      // print_r($message);
      
      
      
    // }
     
   // }
  
     public function QRcode($Id)
      {
      $res = array();
      $result = array();
      $orgid = $_SESSION['orgid'];
      $id1 = $_SESSION['id'];
       $sname=$_SESSION['name'];
      $query= $this->db->query("select Id,department,designation,shift,(select username_mobile from UserMaster where EmployeeId = EmployeeMaster.id LIMIT 1)as una,(select Username from UserMaster where EmployeeId = EmployeeMaster.id LIMIT 1)as email,(select Password from UserMaster where EmployeeId= EmployeeMaster.id LIMIT 1)as upa,(select qrselector from `admin_login` where id = '$id1' )as qrselect,(select Website from Organization where   Id = EmployeeMaster.OrganizationId)as web,PersonalNo,EmployeeCode,(select Name from CityMaster where Id = EmployeeMaster.CurrentCity LIMIT 1 )as city123,FirstName,LastName,ImageName,CurrentAddress from  EmployeeMaster  where `OrganizationId`=$orgid AND archive=1 AND Is_Delete = '0' and Id IN ($Id)");


      
      foreach($query->result() as $row)
      {
        if(decode5t($row->PersonalNo)!=""){
          $data = array();
          $data['name'] =getEmpName($row->Id);
          $data['firstname'] =$row->FirstName;
          // data-shift="'. substr(getShift($row->shift),0,15)."&hellip;" .'"

          $data['lastname'] =$row->LastName;
          $data['code'] =$row->EmployeeCode;
          $data['mobile'] =decode5t($row->upa);
          $data['email'] =decode5t($row->email);
          // $data['address'] =decode5t($row->CurrentAddress);
          
          $data['profile'] ='';
         if($row->ImageName=='' && $orgid == 36706){
            $img= '<img src="'.IMGURL3."avatars/male.png".'" style="width:60px!important;" />';
           $data['profile'] ='';
         }
         else{

           $data['profile']= $row->ImageName;
         }


          $data['city'] =$row->city123;
          $data['web'] =$row->web;
          $data['designation']=//strlen(getDesignation($row->designation)) > 5 ? substr(getDesignation($row->designation),0,10)."&hellip;" : getDesignation($row->designation);
          getDesignation($row->designation);
          $data['department']= //strlen(getDepartment($row->department)) > 5 ? substr(getDepartment($row->department),0,10)."&hellip;" : getDepartment($row->department);
          getDepartment($row->department);
          $shiftname= getShiftByEmpID($row->Id);
          $data['shiftname'] = strlen($shiftname) > 5 ? substr($shiftname,0,15) : $shiftname;
          $data['shift']= getShiftTimes($row->shift);
            $str = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=".decode5t($row->una)."ykks==".$row->upa."&choe=UTF-8";
          $data['qrcode']="";
          if($orgid == 36706){
           $data['qrcode']=" <img  width='100px' src= '$str' />";
          }
          else{
             $data['qrcode']="<img  width='100px' src= '$str' />";
          }
          $data['qrselect']= $row->qrselect;
          
          $res[] = $data;
          
        }
      }       
        $result['data'] = $res;
        // print_r($result['data']);
         return  $result; 
    }
    
    
      public function deleteUser()
    {
      /* echo 1;
      return false; */
      $orgid =$_SESSION['orgid'];
      $zone=getTimeZone($orgid);
        date_default_timezone_set($zone);
        $todaydate = date('Y-m-d');
           $sid =  isset($_REQUEST['sid'])?$_REQUEST['sid']:0;
        // $sql = "delete FROM  `AttendanceMaster` where `Id` IN( SELECT `Id` FROM `AttendanceMaster` 
           //WHERE `Id` = '$sid') ";
       $query = $this->db->query("Select Id from UserMaster where EmployeeId = $sid AND appSuperviserSts = 0 ");

       if($this->db->affected_rows()>0)
       {
         $sql = "update  AttendanceMaster set Is_Delete = 1,Deleted_Date = '$todaydate' where EmployeeId= $sid";
         $query = $this->db->query($sql);
         // var_dump($this->db->last_query());
         if($query > 0){
          $sql = "update EmployeeMaster set Is_Delete = 1,Deleted_Date = '$todaydate'  where Id = $sid";
        $query = $this->db->query($sql);
        if($query > 0){
          $sql = "update UserMaster set Is_Delete = 1,Deleted_Date = '$todaydate'  where EmployeeId = $sid";
          $query = $this->db->query($sql);
          if($this->db->affected_rows()>0){
           
           $sql = "update `Timeoff` set Is_Delete = 1,Deleted_Date = '$todaydate'  WHERE EmployeeId=$sid and `OrganizationId`='$orgid'";
           $query = $this->db->query($sql);
           
        if($query > 0)
        {
          $sql = " update `checkin_master` set Is_Delete = 1,Deleted_Date = '$todaydate'  WHERE EmployeeId =$sid and OrganizationId ='$orgid'";
        
          $queryn = $this->db->query($sql);
        
          if($queryn > 0)
        {
        /*start updating previous dues*/
        
        $query = $this->db->query("select count(id) as totalUsers,(select NoOfEmp from Organization where Organization.Id =$orgid) as ulimit,(select status from licence_ubiattendance where licence_ubiattendance.OrganizationId =$orgid) as orgstatus from UserMaster where OrganizationId = $orgid");
        if ($r=$query->result())
         {
          if($r[0]->totalUsers >= $r[0]->ulimit)
          {
            $range='1-20';
            if($r[0]->totalUsers<21)
              $range='1-20';
            else if($r[0]->totalUsers>=21 && $r[0]->totalUsers<41)
              $range='21-40';
            else if($r[0]->totalUsers>=41 && $r[0]->totalUsers<61)
              $range='41-60';
            else if($r[0]->totalUsers>=61 && $r[0]->totalUsers<81)
              $range='61-80';
            else if($r[0]->totalUsers>=81 && $r[0]->totalUsers<101)
              $range='81-100';
            else if($r[0]->totalUsers>=101 && $r[0]->totalUsers<121)
              $range='101-120';
            else
              $range='120+';
            
            $sdate='-'; 
            $edate='-'; 
            $country=93;  
            $rate_per_day=0;
            $days=0;
            $currency='';
            $due=0;
            $orgstatus=$r[0]->orgstatus;
            
            $query1 = $this->db->query("select start_date,end_date,due_amount,DATEDIFF(end_date,CURDATE())as days,(SELECT `Country` FROM `Organization` WHERE `Id`=$orgid)as country from licence_ubiattendance where OrganizationId = $orgid");
            if ($r1=$query1->result()){
              $sdate  = $r1[0]->start_date; 
              $edate  = $r1[0]->end_date;
              $days = $r1[0]->days;
              $due  = $r1[0]->due_amount;
              $currency=  $r1[0]->country==93?'INR':'USD';
              $query2 = $this->db->query("SELECT  monthly  FROM `Attendance_plan_master` WHERE `range`='$range' and `currency`='$currency'");
              if ($r2=$query2->result())
                $rate_per_day = ($r2[0]->monthly)/30 ;
            }
            $payable_amt=0;
            $tax=0;
            $total=0;
            if($currency=='INR')
            $tax  = ($rate_per_day)*($days)*(0.18);
            $payable_amt =  $rate_per_day*$days;
            $payamtwidtax = round(($payable_amt+$tax),2);
            $total    = round(($due-($tax+$payable_amt)),2);
            
          /////////////update due amount-start
          if($total<0){
            Trace("Total is less than zero".$total);
            $total=0;
            $query1 = $this->db->query("UPDATE `licence_ubiattendance` SET `due_amount`=$total WHERE `OrganizationId` = $orgid");
          }else{
            $query1 = $this->db->query("UPDATE `licence_ubiattendance` SET `due_amount`=$total WHERE `OrganizationId` = $orgid");
          /////////////update due amount-close
          if($orgstatus==1)
          {
            $subject=getOrgName($orgid)." -Billing details for changed users";
            //$subject="ubiAttendance - Exceeded User Limit";
            $message="<div style='color:black'>
            Greetings from ubiAttendance App<br/><br/>
            The no. of users in your ubiAttendance Plan have reduced. We have updated your plan.<br/>
            <h4 style='color:blue'>Plan Details:</h4>
            Company name: ".getOrgName($orgid)."<br/>
            Plan Start Date:".date('d-M-Y',strtotime($sdate))."<br/>
            Plan End Date:".date('d-M-Y',strtotime($edate))."<br/>
            User limit: ".$r[0]->ulimit."<br/>
            Registered Users: ".($r[0]->totalUsers)."<br/>
            <br/>
            <h4 style='color:blue'>Billing Details:</h4>
            Previous Dues: ".$due.' '.$currency." <br/>
            Reduction for deleted Users: -".$payamtwidtax.' '.$currency."<br/>
            Amount Payable: ".$due." - ".$payamtwidtax." = ".$total." ".$currency." <br/>
            <br/>
            ";
            $message.="Cheers,<br/>
            Team ubiAttendance<br/><a target='_blank' href='http://www.ubiattendance.com'>www.ubiattendance.com</a><br/> Tel/ Whatsapp: +91 70678 22132<br/>Email: ubiattendance@ubitechsolutions.com<br/>Skype: ubitech.solutions</div>";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
            $adminMail=getAdminEmail($orgid);
            Trace("<br/><br/>Delete Message:   ".$message);
            sendEmail_new($adminMail,$subject,$message,$headers);
            sendEmail_new('ubiattendance@ubitechsolutions.com',$subject,$message,$headers);
            //sendEmail_new('deeksha@ubitechsolutions.com',$subject,$message,$headers); 
            //sendEmail_new('vijay@ubitechsolutions.com',$subject,$message,$headers); 
            }
          }
          }
        }
        
        /*end updating previous dues*/
              
              
        $this->db->close();
          echo $queryn;
          }
          }
          }       
          }
         }
     }
    else
    {
      echo 2;
    }
      }
    // archive user By sohan
  public function deleteUser__New()
     {
      $orgid =$_SESSION['orgid'];
      $zone=getTimeZone($orgid);
        date_default_timezone_set($zone);
        $todaydate = date('Y-m-d');
        
           $sid =  isset($_REQUEST['sid'])?$_REQUEST['sid']:0;
       $query = $this->db->query("Select Id, archive as arc from UserMaster where EmployeeId = $sid AND appSuperviserSts = 0 ");

       if($this->db->affected_rows()>0)
       {
        $query1 = $this->db->query("Select Id, archive from UserMaster where EmployeeId = $sid AND appSuperviserSts = 0 ");
        if ($r1=$query1->result()){
          $arc= $r1[0]->archive;
        }
           $sql = "update EmployeeMaster set Is_Delete = 1,Deleted_Date = '$todaydate'  where Id = $sid";
           $query = $this->db->query($sql);
           // var_dump($query);
         $sts = "";
         if($arc == 1){
          $sts = "Active employee";
         }
         if($arc == 0){
          $sts = "Inactive employee";
         }
             /// Activity log by sohan
             $date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $id =$_SESSION['id'];
           $module = "Employees";
           

          
           $actionperformed = "<b>".getDeleteEmpName($sid)."</b> has been <b>Deleted </b> from <b>".$sts." </b> and moved to <b>Archive employees </b>";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));
         
         
               echo $this->db->affected_rows();
       }  
      else
      {
        echo 2;
      }
      }
      // permanent delete user By sohan
  public function deleteUserpermanent__New()
     {
      /* echo 1;
      return false; */
      $orgid =$_SESSION['orgid'];
      $zone=getTimeZone($orgid);
        date_default_timezone_set($zone);
        $todaydate = date('Y-m-d');
        
           $sid =  isset($_REQUEST['sid'])?$_REQUEST['sid']:0;
       
      // echo $sid;
       
        // $sql = "delete FROM  `AttendanceMaster` where `Id` IN( SELECT `Id` FROM `AttendanceMaster` 
           //WHERE `Id` = '$sid') ";
       $query = $this->db->query("Select Id from UserMaster where EmployeeId = $sid AND appSuperviserSts = 0 ");
       if($this->db->affected_rows()>0)
       {
         
          /// Activity log by sohan
             $date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $id =$_SESSION['id'];
           $module = "Employees";
          
           $actionperformed = "<b>".getDeleteEmpName($sid)."</b> has been <b>Permanently deleted</b> from <b>Archived employees </b>";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));
           
          /// clase activity log
         
         
         
         
         
         $sql = "Delete from AttendanceMaster  where EmployeeId= $sid";
         $query = $this->db->query($sql);
         if($query > 0){
          $sql = "update  EmployeeMaster set  Is_Delete = 2 where Id = $sid";
        $query = $this->db->query($sql);
        if($query > 0){
          $sql = "Delete from  UserMaster  where EmployeeId = $sid";
          $query = $this->db->query($sql);
          if($this->db->affected_rows()>0){
           $sql = "Delete from  `Timeoff` WHERE EmployeeId=$sid and `OrganizationId`='$orgid'";
           $query = $this->db->query($sql);
           
        if($query > 0)
        {
          $sql = " Delete from  `checkin_master`  WHERE EmployeeId = $sid and OrganizationId ='$orgid'";
        
          $queryn = $this->db->query($sql);
        
          if($queryn > 0)
        {
        /*start updating previous dues*/
        $query = $this->db->query("select count(id) as totalUsers,(select NoOfEmp from Organization where Organization.Id =$orgid) as ulimit,(select status from licence_ubiattendance where licence_ubiattendance.OrganizationId =$orgid) as orgstatus from UserMaster where OrganizationId = $orgid");
        if ($r=$query->result())
         {
          if($r[0]->totalUsers >= $r[0]->ulimit)
          {
            $range='1-20';
            if($r[0]->totalUsers<21)
              $range='1-20';
            else if($r[0]->totalUsers>=21 && $r[0]->totalUsers<41)
              $range='21-40';
            else if($r[0]->totalUsers>=41 && $r[0]->totalUsers<61)
              $range='41-60';
            else if($r[0]->totalUsers>=61 && $r[0]->totalUsers<81)
              $range='61-80';
            else if($r[0]->totalUsers>=81 && $r[0]->totalUsers<101)
              $range='81-100';
            else if($r[0]->totalUsers>=101 && $r[0]->totalUsers<121)
              $range='101-120';
            else
              $range='120+';
            
            $sdate='-'; 
            $edate='-'; 
            $country=93;  
            $rate_per_day=0;
            $days=0;
            $currency='';
            $due=0;
            
            $bulk_att_price1=0;
            $location_tracing_price1=0;
            $visit_punch_price1=0;
            $geo_fence_price1=0;
            $payroll_price1=0;
            $time_off_price1=0;
            
          $bulk_att_price_per_day=0;
          $location_tracing_price_per_day=0;
          $visit_punch_price_per_day=0;
          $geo_fence_price_per_day=0;
          $payroll_price_per_day=0;
          $time_off_price_per_day=0;
          
            $orgstatus=$r[0]->orgstatus;
            
            $query1 = $this->db->query("select start_date,end_date,due_amount,DATEDIFF(end_date,CURDATE())as days,(SELECT `Country` FROM `Organization` WHERE `Id`=$orgid)as country,Addon_BulkAttn,Addon_LocationTracking,Addon_VisitPunch,Addon_GeoFence,Addon_Payroll,Addon_TimeOff from licence_ubiattendance where OrganizationId = $orgid");
            if ($r1=$query1->result()){
              $sdate  = $r1[0]->start_date; 
              $edate  = $r1[0]->end_date;
              $days = $r1[0]->days;
              $due  = $r1[0]->due_amount;
              $currency=  $r1[0]->country==93?'INR':'USD';
              
              $bulk_att_addon=$r1[0]->Addon_BulkAttn;
              $location_addon=$r1[0]->Addon_LocationTracking;
              $visitpunch_addon=$r1[0]->Addon_VisitPunch;
              $geofence_addon=$r1[0]->Addon_GeoFence;
              $payroll_addon=$r1[0]->Addon_Payroll;
              $timeoff_addon=$r1[0]->Addon_TimeOff; 
            
              $query2 = $this->db->query("SELECT  monthly  FROM `Attendance_plan_master` WHERE `range`='$range' and `currency`='$currency'");
              if ($r2=$query2->result())
                $rate_per_day = ($r2[0]->monthly)/30 ;
              
              $query2 = $this->db->query("SELECT  bulk_attendance,location_tracing,visit_punch,geo_fence,payroll,
              time_off  FROM `Attendance_plan_master` WHERE `range`='$range' and `currency`='$currency' ");
                if($r2=$query2->result())
                {
                $bulk_att_price_per_day=($r2[0]->bulk_attendance)/30;
                $location_tracing_price_per_day=($r2[0]->location_tracing)/30;
                $visit_punch_price_per_day=($r2[0]->visit_punch)/30;
                $geo_fence_price_per_day=($r2[0]->geo_fence)/30;
                $payroll_price_per_day=($r2[0]->payroll)/30;
                $time_off_price_per_day=($r2[0]->time_off)/30;
                }
              
              
              if($bulk_att_addon!=0)
              {
              $bulk_att_price1=$bulk_att_price_per_day;
              }
              if($location_addon!=0)
              {
              $location_tracing_price1=$location_tracing_price_per_day;
              }
              if($visitpunch_addon!=0)
              {
              $visit_punch_price1=$visit_punch_price_per_day;
              }
              if($geofence_addon!=0)
              {
              $geo_fence_price1=$geo_fence_price_per_day;
              }
              if($payroll_addon!=0)
              {
              $payroll_price1=$payroll_price_per_day;
              }
              if($timeoff_addon!=0)
              {
              $time_off_price1=$time_off_price_per_day;
              }
            }
            
            
            
            $payable_amt=0;
            $tax=0;
            $total=0;
            if($currency=='INR')
            $tax  = ($bulk_att_price1+$location_tracing_price1+$visit_punch_price1+$geo_fence_price1+$payroll_price1+$time_off_price1+$rate_per_day)*($days)*(0.18);
          
            $payable_amt= ($bulk_att_price1+$location_tracing_price1+$visit_punch_price1+$geo_fence_price1+$payroll_price1+$time_off_price1+$rate_per_day)*$days;
            $payamtwidtax = round(($payable_amt+$tax),2);
            $total    = round(($due-($tax+$payable_amt)),2);
            
          /////////////update due amount-start
          if($total<0){
            Trace("Total is less than zero".$total);
            $total=0;
            $query1 = $this->db->query("UPDATE `licence_ubiattendance` SET `due_amount`=$total WHERE `OrganizationId` = $orgid");
          }else{
            $query1 = $this->db->query("UPDATE `licence_ubiattendance` SET `due_amount`=$total WHERE `OrganizationId` = $orgid");
          /////////////update due amount-close
          if($orgstatus==1)
          {
            $subject=getOrgName($orgid)." -Billing details for changed users";
            //$subject="ubiAttendance - Exceeded User Limit";
            $message="<div style='color:black'>
            Greetings from ubiAttendance App<br/><br/>
            The no. of users in your ubiAttendance Plan have reduced. We have updated your plan.<br/>
            <h4 style='color:blue'>Plan Details:</h4>
            Company name: ".getOrgName($orgid)."<br/>
            Plan Start Date:".date('d-M-Y',strtotime($sdate))."<br/>
            Plan End Date:".date('d-M-Y',strtotime($edate))."<br/>
            User limit: ".$r[0]->ulimit."<br/>
            Registered Users: ".($r[0]->totalUsers)."<br/>
            <br/>
            <h4 style='color:blue'>Billing Details:</h4>
            Previous Dues: ".$due.' '.$currency." <br/>
            Reduction for deleted Users: -".$payamtwidtax.' '.$currency."<br/>
            Amount Payable: ".$due." - ".$payamtwidtax." = ".$total." ".$currency." <br/>
            <br/>
            ";
            $message.="Cheers,<br/>
            Team ubiAttendance<br/><a target='_blank' href='http://www.ubiattendance.com'>www.ubiattendance.com</a><br/> Tel/ Whatsapp: +91 70678 22132<br/>Email: ubiattendance@ubitechsolutions.com<br/>Skype: ubitech.solutions</div>";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
            $adminMail=getAdminEmail($orgid);
            Trace("<br/><br/>Delete Message:   ".$message);
            sendEmail_new($adminMail,$subject,$message,$headers);
            sendEmail_new('ubiattendance@ubitechsolutions.com',$subject,$message,$headers);
            //sendEmail_new('deeksha@ubitechsolutions.com',$subject,$message,$headers); 
            //sendEmail_new('sohan@ubitechsolutions.com',$subject,$message,$headers); 
            }
          }
          }
        }
        
        /*end updating previous dues*/
        
              
        $this->db->close();
          echo $queryn;
          }
          }
          }       
           }
          }
      }
    else
    {
      echo 2;
    }
      }
  public function deleteallemp_permanent()
     {
      /* echo 1;
      return false; */
      $orgid =$_SESSION['orgid'];
      $zone=getTimeZone($orgid);
        date_default_timezone_set($zone);
        $todaydate = date('Y-m-d');
        $id =$_SESSION['id'];
        $date = date("y-m-d H:i:s");
        
           $favorite =  isset($_REQUEST['favorite'])?$_REQUEST['favorite']:0;
      $favorite1=implode(",",$favorite);
        // $sql = "delete FROM  `AttendanceMaster` where `Id` IN( SELECT `Id` FROM `AttendanceMaster` 
           //WHERE `Id` = '$sid') ";
       $query = $this->db->query("Select Id from UserMaster where EmployeeId IN ($favorite1) AND appSuperviserSts = 0 ");
       if($this->db->affected_rows()>0)
       {
         /// Activity log by sohan
         /*    $date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $id =$_SESSION['id'];
           $module = "Delete Employee";
          
           $actionperformed = "Delete <b>".getDeleteEmpName($sid)."</b>";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId) VALUES (?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid));*/
           
          /// close activity log
         
         
         $sql = "Delete from AttendanceMaster  where EmployeeId IN ($favorite1)";
         $query = $this->db->query($sql);
         if($query > 0){
          $sql = "update EmployeeMaster set Is_Delete = 2 where Id IN ($favorite1)";
        $query = $this->db->query($sql);
        // ===============================================
            if($query>0)
            {
              
           
           
         
      // $name = getEmpName($favorite1);
      $i= 0;
      for($i=0; $i<count($favorite); $i++)
            {
              $empid121 = $favorite[$i];
              // echo $empid121;

           $module = "Employees";
           $actionperformed = " <b>".getdeletepermanentEmpName($empid121)."</b> has been <b>Permanently Deleted</b>  from <b>Archive Employees </b>.";

           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));
            }
          }
            

        // ===============================================
        if($query > 0)  {
          $sql = "Delete from  UserMaster  where EmployeeId IN ($favorite1)";
          $query = $this->db->query($sql);
          if($this->db->affected_rows()>0)
        {
         $sql = "Delete from  `Timeoff` WHERE EmployeeId IN ($favorite1) and `OrganizationId`='$orgid'";
         $query = $this->db->query($sql);
        
        if($query>0)
        {
          $sql = "Delete from  `ShiftRotationMaster` WHERE EmployeeId IN ($favorite1) and `OrganizationId`='$orgid'";
              $query = $this->db->query($sql);
          
                if($query > 0)
                {
                $sql = " Delete from `checkin_master`  WHERE EmployeeId IN ($favorite1) and OrganizationId ='$orgid'";
                
                $queryn = $this->db->query($sql);
                
                if($queryn > 0)
                {
                /*start updating previous dues*/
                
    $query = $this->db->query("select count(id) as totalUsers,(select NoOfEmp from Organization where Organization.Id =$orgid) as ulimit,(select status from licence_ubiattendance where licence_ubiattendance.OrganizationId =$orgid) as orgstatus from UserMaster where OrganizationId = $orgid");
    if($r=$query->result())
    {
    if($r[0]->totalUsers >= $r[0]->ulimit)
    {
    $range='1-20';
    if($r[0]->totalUsers<21)
    $range='1-20';
    else if($r[0]->totalUsers>=21 &&  $r[0]->totalUsers<41)
    $range='21-40';
    else if($r[0]->totalUsers>=41 &&  $r[0]->totalUsers<61)
    $range='41-60';
    else if($r[0]->totalUsers>=61 &&  $r[0]->totalUsers<81)
    $range='61-80';
    else if($r[0]->totalUsers>=81 &&  $r[0]->totalUsers<101)
    $range='81-100';
    else if($r[0]->totalUsers>=101 && $r[0]->totalUsers<121)
    $range='101-120';
    else
    $range='120+';
    $sdate='-'; 
    $edate='-'; 
    $country=93;  
    $rate_per_day=0;
    $days=0;
    $currency='';
    $due=0;
    $orgstatus=$r[0]->orgstatus;
    $query1 = $this->db->query("select start_date,end_date,due_amount,DATEDIFF(end_date,CURDATE())as days,(SELECT `Country` FROM `Organization` WHERE `Id`=$orgid)as country from licence_ubiattendance where OrganizationId = $orgid");
    if ($r1=$query1->result())      
    {
      $sdate  = $r1[0]->start_date; 
      $edate  = $r1[0]->end_date;
      $days = $r1[0]->days;
      $due  = $r1[0]->due_amount;
      $currency=  $r1[0]->country==93?'INR':'USD';
      $query2 = $this->db->query("SELECT  monthly  FROM `Attendance_plan_master` WHERE `range`='$range' and `currency`='$currency'");
      if ($r2=$query2->result())
        $rate_per_day = ($r2[0]->monthly)/30 ;
    }
      $payable_amt=0;
      $tax=0;
      $total=0;
      if($currency=='INR')
      $tax  = ($rate_per_day)*($days)*(0.18);
      $payable_amt =  $rate_per_day*$days;
      $payamtwidtax = round(($payable_amt+$tax),2);
      $total    = round(($due-($tax+$payable_amt)),2);
                                
      /////////////update due amount-start
      if($total<0){
        Trace("Total is less than zero".$total);
        $total=0;
        $query1 = $this->db->query("UPDATE `licence_ubiattendance` SET `due_amount`=$total WHERE `OrganizationId` = $orgid");
      }else{
        $query1 = $this->db->query("UPDATE `licence_ubiattendance` SET `due_amount`=$total WHERE `OrganizationId` = $orgid");
      /////////////update due amount-close
      if($orgstatus==1)
      {
        $subject=getOrgName($orgid)." -Billing details for changed users";
        //$subject="ubiAttendance - Exceeded User Limit";
        $message="<div style='color:black'>
        Greetings from ubiShift App<br/><br/>
        The no. of users in your ubiShift Plan have reduced. We have updated your plan.<br/>
        <h4 style='color:blue'>Plan Details:</h4>
        Company name: ".getOrgName($orgid)."<br/>
        Plan Start Date:".date('d-M-Y',strtotime($sdate))."<br/>
        Plan End Date:".date('d-M-Y',strtotime($edate))."<br/>
        User limit: ".$r[0]->ulimit."<br/>
        Registered Users: ".($r[0]->totalUsers)."<br/>
        <br/>
        <h4 style='color:blue'>Billing Details:</h4>
        Previous Dues: ".$due.' '.$currency." <br/>
        Reduction for deleted Users: -".$payamtwidtax.' '.$currency."<br/>
        Amount Payable: ".$due." - ".$payamtwidtax." = ".$total." ".$currency." <br/>
        <br/>
        ";
        $message.="Cheers,<br/>
        Team ubiShift<br/>Tel/ Whatsapp: +91 70678 22132<br/>Email: ubishift@ubitechsolutions.com<br/>Skype: ubitech.solutions</div>";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <noreply@ubiattendance.com>' . "\r\n";
        $adminMail=getAdminEmail($orgid);
        Trace("<br/><br/>Delete Message:   ".$message);
        sendEmail_new($adminMail,$subject,$message,$headers);
        sendEmail_new('ubishift@ubitechsolutions.com',$subject,$message,$headers);
        //sendEmail_new('deeksha@ubitechsolutions.com',$subject,$message,$headers); 
        //sendEmail_new('sohan@ubitechsolutions.com',$subject,$message,$headers); 
        }
        }
      }
    }
                  
      /*end updating previous dues*/
      $this->db->close();
        echo $queryn;
        }
       }
}
      
}
    }
    }
}
  else
  {
    echo 2;
  }
}

  
    public function UnarchiveUser()
    {
         $orgid =$_SESSION['orgid'];
           $sid =  isset($_REQUEST['sid'])?$_REQUEST['sid']:0;
         $sql = "update EmployeeMaster set Is_Delete = '0' where Id = $sid";
         $query = $this->db->query($sql);
       
       /// Activity log by sohan
             $date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $id =$_SESSION['id'];
           $module = "Archived Employee";
          
           $actionperformed = "<b>".getEmpName($sid)."</b> has been <b>Unarchived</b> from <b>Archive employess</b>";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));
       
       
       echo $this->db->affected_rows();
    }

    public function unarchiveallemp()
    {
         $orgid =$_SESSION['orgid'];
         $date = date("y-m-d H:i:s");
         $id =$_SESSION['id'];
       
        $favorite =  isset($_REQUEST['favorite'])?$_REQUEST['favorite']:0;
      $favorite1=implode(",",$favorite);
         $sql = "update EmployeeMaster set Is_Delete = '0',Deleted_Date = '0000:00:00'  where Id In  ($favorite1)";
         $query = $this->db->query($sql);
       
       /// Activity log by sohan
             /*$date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $id =$_SESSION['id'];
           $module = "UnArchived Employee";
           $actionperformed = "Unarchive <b>".getEmpName($sid)."</b>";
           $activityby = 1;
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId) VALUES (?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid));*/
           
        echo $query;
            if($query==true)
            {
              
              
           
           
         
      // $name = getEmpName($favorite1);
      $i= 0;
      for($i=0; $i<count($favorite); $i++)
            {
              $empid121 = $favorite[$i];
              // echo $empid121;
              
           $module = "Employees";
           $actionperformed = " <b>".getEmpName($empid121)."</b> has been <b>Unarchived</b> Successfully.";

           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));
            }
          
            }
            
    }
    
    
    
    
      public function updateUserStatus(){
           $empid =  isset($_REQUEST['id'])?$_REQUEST['id']:0;
           $sts = ( isset($_REQUEST['sts'])?$_REQUEST['sts']:0)==1?0:1;
        $updSts=0;
        $sql = "update EmployeeMaster set archive = $sts where id = $empid";
        $query = $this->db->query($sql);
      
        $updSts+=$this->db->affected_rows();
        $sql = "update UserMaster set VisibleSts=$sts, archive = $sts where EmployeeId = $empid";
        $query1 = $this->db->query($sql);
        $updSts+=$this->db->affected_rows();
          if($updSts > 0)
        {
            
          /// Activity log by sohan
             $date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $id =$_SESSION['id'];
           if($sts==1)
           {
            $module = "Employees";
            $actionperformed = "<b>".getEmpName($empid)."</b> status has been changed to <b>Active</b> from <b> Inactive employees</b>";
           }
           else
           {
          $module = "Employees";
            $actionperformed = "<b>".getEmpName($empid)."</b> status has been changed to <b>Inactive</b> from <b> Active employees</b>";  
           }
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));
           $this->db->close();
        }
            echo $query; 
      }
      
      
      public function getInactiveEmpData()
      {
         $orgid=$_SESSION['orgid'];
         $query = $this->db->query("SELECT EmployeeMaster.id as id, `FirstName`,lastname,archive,department,designation,shift,PersonalNo,DOB, Nationality, `MaritalStatus`,`Religion`,`BloodGroup`,`DOJ`, `DOC`,`Gender`,`HomeAddress`, `HomeCountry`, `HomeCity`, `HomeZipCode`,(select appSuperviserSts from UserMaster where EmployeeId= EmployeeMaster.id )as appSuperviserSts,(select Username from UserMaster where EmployeeId= EmployeeMaster.id )as una,(select Password from UserMaster where EmployeeId= EmployeeMaster.id )as upa FROM `EmployeeMaster` where OrganizationId=? AND archive = 0 AND Is_Delete = '0' ",array($orgid));
         $d=array();
         $res=array();
         $userstts='';
         foreach ($query->result() as $row)
        {
          if($row->archive==1)
            $userstts='<i class=" status fa fa-thumbs-down" style="font-size:16px; color:red" data-target="#delEmp" data-id="'.$row->id.'" title="Click to make user Inactive" data-ena="'.$row->FirstName.'" ></i>';
          else
            $userstts='<i class=" status fa fa-thumbs-up" style="font-size:16px; color:green" data-target="#delEmp" data-id="'.$row->id.'"  title="Click here to make user status Active" data-ena="'.$row->FirstName.'" ></i>';
        
          $data=array();
            $data['name']=$row->FirstName.' '.$row->lastname;
            $data['username']=decode5t(getUserName($row->id));
            $data['designation']=getDesignation($row->designation);
            $data['shift']='<span title="Shift Timing: '.getShiftTimes($row->shift).', Break Hours: '.getShiftBreaks($row->shift).'">'.getShift($row->shift).'</span>';
            $data['department']=getDepartment($row->department);
            $data['contact']=decode5t($row->PersonalNo);
            $data['status']=$row->archive==1?'<div style="background-color:green;text-align:center;color:white;">Active</div>':'<div style="background-color:red;text-align:center;color:white;">Inactive</div>';
            $data['action']='
          <!--  <a href="#"><i class="material-icons edit" style="font-size:26 px" data-toggle="modal" title="Edit" data-target="#addEmpE"  
             data-id="'.$row->id.'"
             data-firstname="'.$row->FirstName.'" 
             data-lastname="'.$row->lastname.'" 
             data-dob="'.$row->DOB.'"
             data-doj="'.$row->DOJ.'"
             data-gen="'.$row->Gender.'"
             data-doc="'.$row->DOC.'"
             data-nat="'.$row->Nationality.'"
             data-cont="'.decode5t($row->PersonalNo).'"
             data-addr="'.decode5t($row->HomeAddress).'"
             data-password="'.''.'"
             data-email="'.decode5t(getUserName($row->id)).'"
             data-country="'.$row->HomeCountry.'"
             data-city="'.$row->HomeCity.'"
             data-status="'.$row->archive.'"
             data-shift="'.$row->shift.'"
             data-desg="'.$row->designation.'"
             data-dept="'.$row->department.'"
             data-bg="'.$row->BloodGroup.'"
             data-rel="'.$row->Religion.'"
             data-ms="'.$row->MaritalStatus.'"
             data-sstatus="'.$row->appSuperviserSts.'"
             >edit</i></a> -->
            <i class=" delete fa fa-trash"   style="font-size:16px; color:purple" data-toggle="modal" data-target="#delEmp" data-id="'.$row->id.'" data-name="'.$row->FirstName.'" title="Archive" ></i> 
              <!--<i class=" qr fa fa-qrcode" style="font-size:16px; color:purple" data-toggle="modal" data-target="#genQR" data-id="'.$row->id.'" data-name="'.$row->FirstName.' '.$row->lastname.'" data-desg="'.getDesignation($row->designation).'" data-dept="'.getDepartment($row->department).'" data-una="'.decode5t($row->una).'" data-upa="ykks=='.$row->upa.'" title="Generate QR Code" ></i> -->
            '. $userstts;
            $res[]=$data;
        }   
        $d['data']=$res;
           $this->db->close();      //$query->result();
        echo json_encode($d);
      }
      function resetPassword()
    {
        $pass =  encode5t(isset($_REQUEST['pass'])?$_REQUEST['pass']:'');
      //echo $pass;
         $empid =  isset($_REQUEST['id'])?$_REQUEST['id']:0;
      
        $sts=0;
          $sql="Update UserMaster set Password='$pass' where EmployeeId=$empid";
        $query = $this->db->query($sql);
        $sts=$this->db->affected_rows();
      
      /// Activity log by sohan
             $date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $id =$_SESSION['id'];
          
          $module = "Employees";
            $actionperformed = " <b> Password </b>  has been updated for <b>".getEmpName($empid)."</b> from <b> Active employees </b>";
           $activityby = 1;
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));
      
        $this->db->close();
        echo json_encode($sts);
          
      }
    
    public function getTimeoffs()
  {
    $orgid=$_SESSION['orgid'];
    $emp = isset($_REQUEST['empl'])?$_REQUEST['empl']:0;
    $desg = isset($_REQUEST['desg'])?$_REQUEST['desg']:0;
    $deprt = isset($_REQUEST['deprt'])?$_REQUEST['deprt']:0;
    $shift = isset($_REQUEST['shift'])?$_REQUEST['shift']:0;
    $date =  isset($_REQUEST['date'])?$_REQUEST['date']:"";
    $q = "";
      if($date != "")
       {
         $arr=explode('-',trim($date));
         $enddate = date('Y-m-d',strtotime($arr[1]));
         $strtdate= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3)));  
         $q = " AND  TimeofDate BETWEEN '$strtdate' AND '$enddate'";
       }
       else
       {
         $date = date('Y-m-d');
         $enddate = date('Y-m-d');//,strtotime('-1 days',strtotime($date)));
         $strtdate= date('Y-m-d',strtotime('-7 days',strtotime($date)));
         $q = " AND  TimeofDate BETWEEN ' $strtdate' AND '$enddate'";
       }
     if($emp != 0)
         {
       $q .= " AND Timeoff.EmployeeId = '$emp' ";
     }
      if($desg != 0)
     {
      $q .= "AND Timeoff.EmployeeId in (select id from EmployeeMaster where Designation = '$desg' AND EmployeeMaster.OrganizationId='$orgid' ) "; 
     }
      if($deprt != 0)
     {
      $q .= "AND Timeoff.EmployeeId in (select id from EmployeeMaster where Department = '$deprt' AND EmployeeMaster.OrganizationId='$orgid' )"; 
     }
     if($shift != 0)
     {
       $q .= ""; 
     }  
     
     
    $query = $this->db->query("SELECT * , TIMEDIFF(`TimeTo`,`TimeFrom`)as duration FROM Timeoff WHERE   Timeoff.OrganizationId = '$orgid' $q order by Timeoff.TimeofDate DESC");
    $res = array();
    $d = array();
    foreach($query->result() as $row)
    {
      $data = array();
      $name= getEmpName($row->EmployeeId);
      if($name != "")
      { 
      $data['name'] = $name;
      $emp = $row->EmployeeId;
      $id = $row->Id;
      /*$qur = $this->db->query("Select CONCAT(FirstName,' ',LastName) as name From EmployeeMaster where Id = '$emp'");
      foreach($qur->result() as $row1)
      {
        $data['name'] = $row1->name;
      }*/
      $data['date'] = date('d-M-Y',strtotime($row->TimeofDate));
       $data['duration'] = substr($row->duration,0,5);
      $data['createddate'] = date('d-M-Y',strtotime($row->CreatedDate));
      $data['timefrom'] = substr($row->TimeFrom,0,5);
      $data['timeto'] = substr($row->TimeTo,0,5);
      $data['reason'] = $row->Reason;
      $status = $row->ApprovalSts;
      $data['status'] = "-";
       if($status == 1)
       {
        $data['status'] =  "<span style='color:#ff6666;' > Rejected </span>";
       }
       else if($status == 2)
       {
        $data['status'] =  "<span style='color:green' >Approved</span>";
       }
       else if($status == 3)
       {
             $data['status'] =  '<u><a href="#" ><span class="edit" data-toggle="modal" title="Edit" 
           data-timeoffid="'.$row->Id.'" 
           data-timefrom="'.$row->TimeFrom.'" 
           data-timeto="'.$row->TimeTo.'"
           data-empname="'.$data['name'].'"
           data-sts="'.$status.'"
           data-comment="'.$row->ApproverComment.'"
           data-timeoffdate="'.$data['date'].'"
          data-target="#editTimeoff">Pending</span></a></u>';
       }
       else if($status == 4)
       {
        $data['status'] =  "Cancel";
       }
       else if($status == 5)
       {
        $data['status'] =  "<span style='color:blue' >Withdrawn</span>";
       }
       else if($status == 7)
       {
        $data['status'] =  "Escalated";
       }
    /* if($data['status'] == "Pending")
      $data['action'] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><i class="material-icons edit" data-toggle="modal" title="Edit" 
           data-timeoffid="'.$row->Id.'" 
           data-timefrom="'.$row->TimeFrom.'" 
           data-timeto="'.$row->TimeTo.'"
           data-empname="'.$data['name'].'"
           data-sts="'.$status.'"
           data-comment="'.$row->ApproverComment.'"
           data-timeoffdate="'.$data['date'].'"
          data-target="#editTimeoff">edit</i></a>';
      else
        $data['action'] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><i class="material-icons notedit"  title="Not Change"> edit</i></a>';*/  
      $res[] = $data;
      }
    }
        $d['data']=$res;
        echo json_encode($d);
       $this->db->close();
  } 
  public function getLeaves()
  {
    $orgid=$_SESSION['orgid'];
    $emp = isset($_REQUEST['empl'])?$_REQUEST['empl']:0;
    $desg = isset($_REQUEST['desg'])?$_REQUEST['desg']:0;
    $deprt = isset($_REQUEST['deprt'])?$_REQUEST['deprt']:0;
    $shift = isset($_REQUEST['shift'])?$_REQUEST['shift']:0;
    $date =  isset($_REQUEST['date'])?$_REQUEST['date']:"";
    $q = "";
      if($date != "")
       {
         $arr=explode('-',trim($date));
         $enddate = date('Y-m-d',strtotime($arr[1]));
         $strtdate= date('Y-m-d',strtotime(substr($arr[0],2,strlen($arr[0])-3)));  
         $q = " AND  LeaveFrom BETWEEN '$strtdate' AND '$enddate'";
       }
       else
       {
         $date = date('Y-m-d');
         $enddate = date('Y-m-d');
         $strtdate= date('Y-m-d',strtotime('-7 days',strtotime($date)));
         $q = " AND  LeaveFrom BETWEEN ' $strtdate' AND '$enddate'";
       }
         if($emp != 0)
         {
       $q .= " AND EmployeeId = '$emp' ";
     }
     if($desg != 0)
     {
      $q .= "AND EmployeeId in (select id from EmployeeMaster where Designation = '$desg' AND EmployeeMaster.OrganizationId='$orgid' ) "; 
     }
     if($deprt != 0)
     {
      $q .= "AND EmployeeId in (select id from EmployeeMaster where Department = '$deprt' AND EmployeeMaster.OrganizationId='$orgid' )"; 
     }
     if($shift != 0)
     {
       $q .= ""; 
     }


       
    $query = $this->db->query("SELECT * FROM EmployeeLeave WHERE  EmployeeLeave.OrganizationId = '$orgid' $q");
    $res = array();
    $d = array();
    foreach($query->result() as $row)
    {
      $data = array();
      $emp = $row->EmployeeId;
      $qur = $this->db->query("Select CONCAT(FirstName,' ',LastName) as name From EmployeeMaster where Id = '$emp'");
      foreach($qur->result() as $row1)
       {
         $data['name'] = $row1->name;
       }
      $data['leavefrom'] = date('d-M-Y',strtotime($row->LeaveFrom));
      $data['leaveto'] = date('d-M-Y',strtotime($row->LeaveTo));
      $data['applydate'] = date('d-M-Y',strtotime($row->ApplyDate));
      $data['reason'] = $row->LeaveReason;
      if($data['reason'] == "")
      {
       $data['reason'] = "-"; 
      }
      $status = $row->LeaveStatus;
      $data['status'] = "-";
       if($status == 1)
       {
        $data['status'] =  "Rejected";
       }
       else if($status == 2)
       {
        $data['status'] =  "Approved";
       }
       else if($status == 3)
       {
        $data['status'] =  "Pending";
       }
       else if($status == 4)
       {
        $data['status'] =  "Cancel";
       }
       else if($status == 5)
       {
        $data['status'] =  "Withdrawn";
       }
       else if($status == 7)
       {
        $data['status'] =  "Escalated";
       }
       
      $data['action'] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><i class="material-icons edit" data-toggle="modal" title="Edit" 
           data-leaveid="'.$row->Id.'" 
           data-leavefrom="'.date('d-M-Y',strtotime($row->LeaveFrom)) .'" 
           data-leaveto="'.date('d-M-Y',strtotime($row->LeaveTo)).'"
           data-empname="'.$data['name'].'"
           data-leavestatus="'.$status.'"
           data-comment="'.$row->ApproverComment.'"
          data-target="#updateleaveE">edit</i></a>';
              $res[] = $data;
    }
        $d['data']=$res;
        echo json_encode($d);
       $this->db->close();
  }
    public function updatetimeoff()
  {
    $orgid=$_SESSION['orgid'];
    
    //$adminid =$_SESSION['id'];
    // $name= getEmpName($row->EmployeeId);
    $timeoffid = isset($_REQUEST['timeoffid'])?$_REQUEST['timeoffid']:"";
    $id121 = isset($_REQUEST['id121'])?$_REQUEST['id121']:"";
    //$timefrom = isset($_REQUEST['timefrom'])?$_REQUEST['timefrom']:"";
    //$timeto = isset($_REQUEST['timeto'])?$_REQUEST['timeto']:"";
    $sts = isset($_REQUEST['sts'])?$_REQUEST['sts']:"";
    $comment1 = isset($_REQUEST['comment'])?$_REQUEST['comment']:"";
    /*$timeoffdate = isset($_REQUEST['timeoffdate'])?$_REQUEST['timeoffdate']:"";
    if($timeoffdate != "")
    {
      $timeoffdate = date('Y-m-d',strtotime($timeoffdate)); 
    }*/
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
    
    $query = $this->db->query("UPDATE Timeoff SET ApprovalSts='$sts', ModifiedDate='$todaydate' , ApproverComment='$comment'   WHERE Id = '$timeoffid'");
    $count = $this->db->affected_rows();
    if($count > 0 && $sts !=3){
       $date = date("y-m-d H:i:s");
           $orgid =$_SESSION['orgid'];
           $id =$_SESSION['id'];
            $sts = isset($_REQUEST['sts'])?$_REQUEST['sts']:"";
            $name = isset($_REQUEST['name121'])?$_REQUEST['name121']:"";
            $status="";
            if($sts == 1){
              $status = "Rejected";
            }
             if($sts == 2){
              $status = "Approved";
            }

           $module = "Approve Timeoff";
           $actionperformed = " <b>Timeoff</b> has been <b>".$status." </b>for <b>".$name." </b>.";
           $activityby = 1;
           
           $query = $this->db->query("INSERT INTO ActivityHistoryMaster( LastModifiedDate,LastModifiedById,Module, ActionPerformed, OrganizationId,ActivityBy,adminid) VALUES (?,?,?,?,?,?,?)",array($date,$id,$module,$actionperformed,$orgid,$activityby,$id));
    }
    if($count > 0 && $sts !=3 )
    {
      $query1 = $this->db->query("UPDATE TimeoffApproval SET  ApproverSts='$sts' ,ApprovalDate = '$todaydate', ApproverComment= '$comment1' WHERE TimeofId =  '$timeoffid' AND OrganizationId = '$orgid' ");
    }
    echo $count;  
  }
  
    public function updateleave()
  {
    $orgid=$_SESSION['orgid'];
    $adminid =$_SESSION['id'];
    
    $sts = isset($_REQUEST['leavestatus'])?$_REQUEST['leavestatus']:"";
    $comment = isset($_REQUEST['leavecomment'])?$_REQUEST['leavecomment']:"";
    $leaveid = isset($_REQUEST['leaveid'])?$_REQUEST['leaveid']:"";
    
    $zname=getTimeZone($orgid);
    date_default_timezone_set ($zname);
    $todaydate = date('Y-m-d');
    
    $query = $this->db->query("UPDATE EmployeeLeave SET LeaveStatus='$sts' , LastModifiedById='$adminid',ApprovedBy ='$adminid' , LastModifiedDate='$todaydate' , ApproverComment='$comment'   WHERE Id = '$leaveid'");
    echo $this->db->affected_rows();
  } 
    public function getArchiveEmp()
  {
    $org_id=$_SESSION['orgid'];
    $res = array();
    $query = $this->db->query("Select Id ,Shift,Department,Designation  FROM EmployeeMaster Where OrganizationId = ".$org_id ." AND Is_Delete = 1 Order By FirstName ");
    foreach($query->result() as $row)
       {
          $data=array();
        $data['change']='<input type="checkbox" name="chk"  id="'.$row->Id.'" class="checkbox"  value="'.$row->Id.'" >';
        $data['FirstName']= getDeleteEmpName($row->Id);
        $data['desg']=ucwords(getDesignationByEmpID($row->Id));
        $data['deprt']=ucwords(getDepartmentByEmpID($row->Id));
        $data['action'] = '<i class="unarchive fa fa-archive" style="font-size:16px; color:purple" data-toggle="modal" data-target="#unarchive"   data-id="'.$row->Id.'" data-name="'.$data['FirstName'].'" title="Unarchive Employee" ></i> &nbsp;&nbsp;&nbsp;&nbsp;';
        
        $data['action'] .= '<i class="delete fa fa-trash" style="font-size:16px; color:purple" data-toggle="modal" data-target="#delE"  data-id="'.$row->Id.'" data-name="'.$data['FirstName'].'" title="Permanent Delete" ></i> ';
        
        $res[]=$data;     
        }
    $d['data']=$res;          //$query->result();
    $this->db->close();
    echo json_encode($d);
    return false;
  }
  public function Testreport()
  {
    $orgid=$_SESSION['orgid'];
    $res = array();
     $query = $this->db->query("SELECT  id , EmployeeCode ,FirstName,LastName,department,designation,shift FROM `EmployeeMaster` where OrganizationId=? AND archive=1 AND Is_Delete = '0' order by  FirstName ",array($orgid));
     foreach($query->result() as $row)
     {
       $data = array();
       $data['name'] =  $row->FirstName."  ".$row->LastName;
       $data['code'] =  $row->EmployeeCode;
       $data['department'] = getDepartment($row->department);
       $data['designation'] = getDesignation($row->designation);
       $data['action']='<a href="'.URL.'userprofiles/alldatareport/'.$row->id.'" target="_blank"><i class="fa fa-eye" style="font-size:24px; color:purple;" title="View"></i></a>';
       $res[]=$data;
     }
    $result['data'] = $res;
    echo json_encode($result);
  }
  
    
  public function departmentreport()
  {
    $orgid=$_SESSION['orgid'];
    $zname=getTimeZone($orgid);
    date_default_timezone_set ($zname);
    $todate = date('Y-m-d');//'2018-07-09';
    //$todate ='2019-02-28';
    $time = date("H:i:s");
    
    $res = array();
     $query = $this->db->query("SELECT Id,Name FROM DepartmentMaster WHERE OrganizationId=? AND archive = 1 ",array($orgid));
   foreach($query->result() as $row)
   {
    $data = array();
    $data['id'] = $row->Id;
    $id = $row->Id;
    $data['departname'] = '<a href="#" title="view">'.$row->Name.'</a>';
    $sql1 = $this->db->query("SELECT count(Id)as preEmp FROM AttendanceMaster WHERE AttendanceDate='$todate' and AttendanceStatus=1 and EmployeeId IN (SELECT Id FROM EmployeeMaster WHERE OrganizationId=$orgid AND Department=$id AND DOL = '0000-00-00' AND Is_Delete = 0 and archive=1)");
    
    if($row =  $sql1->result())
    {
       $data['present'] ='<div style="padding-left:10px;cursor:pointer">'.$row[0]->preEmp.'</div>';
    }
    
    // $sql3 = $this->db->query("SELECT count(Id) as absEmp FROM AttendanceMaster WHERE AttendanceDate='$todate'  AND AttendanceStatus =2 and  EmployeeId IN (SELECT Id FROM EmployeeMaster WHERE OrganizationId=$orgid AND Department=$id AND DOL = '0000-00-00' AND Is_Delete = 0 ) ");
    
    // if($row =  $sql3->result())
    // {
    // $data['absent'] = $row[0]->absEmp;
    // }
    
    //$sql3 = $this->db->query("SELECT count(A.Id) as absEmp FROM AttendanceMaster A,ShiftMaster S WHERE A.AttendanceDate='$todate'  and AttendanceStatus  IN (1,8,4) AND S.TimeIn < '$time' and A.EmployeeId IN (SELECT Id FROM EmployeeMaster WHERE OrganizationId=$orgid AND Department=$id AND DOL = '0000-00-00' AND Is_Delete = 0 ) AND S.Id=A.ShiftId ");
    
    
    $sql3 = $this->db->query("SELECT count(Id) as absEmp
            FROM  `EmployeeMaster` 
            WHERE  `OrganizationId` =$orgid
            AND ARCHIVE =1 and Department=$id  AND Is_Delete = 0 AND DOL = '0000-00-00'
            AND Id NOT 
            IN (
            SELECT EmployeeId
            FROM AttendanceMaster
            WHERE AttendanceDate = '$todate'
            AND  `OrganizationId`= $orgid AND AttendanceStatus  IN (1,8,4)
                )
            AND 
            (
            SELECT  `TimeIn` 
            FROM  `ShiftMaster` 
            WHERE  `Id` = Shift
            AND TimeIn <  '$time'
            ) ");
  
      if($row =  $sql3->result())
      {
      $data['absent']='<div style="padding-left:10px;cursor:pointer">'.$row[0]->absEmp.'</div>';
      }
    
      $sql4 = $this->db->query("SELECT count(A.Id) as lateEmp FROM AttendanceMaster A,ShiftMaster S WHERE A.AttendanceDate='$todate'  and A.`TimeIn`>S.`TimeIn` and A.EmployeeId IN (SELECT Id FROM EmployeeMaster WHERE OrganizationId=$orgid AND Department=$id AND DOL = '0000-00-00' AND Is_Delete = 0 ) AND S.Id=A.ShiftId ");
    
      if($row =  $sql4->result())
      {
      $data['latecomers'] ='<div style="padding-left:10px;cursor:pointer">'.$row[0]->lateEmp.'</div>';
      }
      
      
    $sql5 = $this->db->query("SELECT count(A.Id) as earlyEmp  FROM AttendanceMaster A,ShiftMaster S WHERE A.AttendanceDate='$todate'  and S.`TimeOut`> A.`TimeOut` and A.EmployeeId IN (SELECT Id FROM EmployeeMaster WHERE OrganizationId=$orgid AND Department=$id AND DOL = '0000-00-00' AND Is_Delete = 0 ) AND S.Id=A.ShiftId and A.`TimeOut`!='00:00:00' ");
    
      if($row =  $sql5->result())
      {
      $data['earlyleavers'] = '<div style="padding-left:10px;cursor:pointer">'.$row[0]->earlyEmp.'</div>';
      } 
      
    $sql2 = $this->db->query("SELECT count(Id) as allEmp FROM EmployeeMaster WHERE OrganizationId=$orgid AND Department=$id   AND DOL = '0000-00-00' AND Is_Delete = '0' and archive=1");
    if($row1 = $sql2->result())
    {
      $data['total'] = '<div style="padding-left:10px;cursor:pointer">'.$row1[0]->allEmp.'</div>';
    } 
       //$data['action']='<a href="'.URL.'admin/attendances/'.$id.'" target="_blank"><i class="fa fa-eye" style="font-size:24px; color:purple;" title="View"></i></a>';
       $res[]=$data;
     }
    $result['data'] = $res;
    echo json_encode($result);
  }
  
  }
  ?>