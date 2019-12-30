<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Company Profile</title>
	<style type="text/css">
.hover{background-color: #cc0000}
.authorBlock{border-top:1px solid #cc0000;}
.main-panel > .content 
{
	    padding: 1px 15px!important;
}
</style>
<style>
    
      .red{
      color:red;
      font-weight:'bold';
      font-size:16px;
      }
      .delete{
      cursor:pointer;
      }
    .bargraph{
         display:inline-block;
         margin-top:-8px;
         margin-left:-17px;
       }
      div.dt-buttons{
      position:relative;
      float:left;
      margin-left:15px;
      }
      .t2{display:none;}
     .modal-footer .btn+.btn 
    {
      margin-bottom: 10px!important;
    }
    a
    {
      cursor:pointer;
      
    }
    </style>
</head>
<body>
	<div class="wrapper">
		<?php
			$data['pageid']=12.1;
			$this->load->view('menubar/sidebar',$data);
		?>
	    <div class="main-panel">
			<?php
				$this->load->view('menubar/navbar');
			?>
			</br>
		<div class="content" id="content">	
			<div class="content ">
				<div class="container-fluid center">
					
					<div class="row">
						<div class="col-lg-6 col-md-12">
						</div>

						<div class="col-md-12">
							<div class="card valign">
	                            <div class="card-header" data-background-color="orange">
									<div class="nav-tabs-navigation"  >
									  <h4>   <p class="nav-tabs-title">Company profile
											</p></h4>
										<a rel="tooltip" style="position:relative;margin-top:-30px;height: 36px;width:60px; "  data-placement="bottom"data-background-color="orange" title="Help" class="btn btn-success btn-sm pull-right toggle-sidebar ">
                                        <i class="fa fa-question"></i></a>
									    <div >		
										<button class="btn btn-sm btn-primary" id="Edit_cprofile"  data-background-color="orange" type="button" style="float: right;margin-top:-30px;" >	
												Edit
										<div class="ripple-container"></div>
										</button>
										<button style="display:none;float: right;margin-top:-30px;" data-background-color="orange" class="btn btn-sm btn-primary"  id="company_profile" type="button" >Done</button>
										</div>
											
										
									</div>
	                         <!--       <p class="category">Employee(s) are on Break currently. </p>-->
	                            </div>
	                            <div class="card-content table-responsive">
								<div class="row">
								<div class="col-md-6">
								<div class="form-group">
								  <label for="inputsm">Company</label>
								  <input class="form-control " id="cpname" value="<?php if($r['Name'] != ""){ echo $r['Name']; }?>" type="text" readonly >
								</div>
								
								</div>
								
								<div class="col-md-6">
								<div class="form-group">
								  <label for="inputsm">Website</label>
								  <input class="form-control " id="cpwebsite" value="<?php if($r['Website'] != ""){ echo $r['Website']; }?>" type="text" readonly >
								</div>
								</div>
								</div>
								
								<div class="row">
								<div class="col-md-6">
								<div class="form-group">
								  <label for="inputsm">Contact Person</label>
								  <input class="form-control " id="pname" value="<?php if($p['name'] != ""){ echo $p['name']; }?>" type="text" disabled >
								</div>
								</div>
								<div class="col-md-6">
								<div class="form-group">
								  <label for="inputsm">Username</label>
								  <input class="form-control " id="puname" value="<?php if($p['username'] != ""){ echo $p['username']; }?>" type="text" disabled >
								</div>
									</div>
									</div>
									<div class="row">
									<div class="col-md-6">
								<div class="form-group">
								  <label for="inputsm">Phone</label>
								  <input class="form-control " id="cppnumber" value="<?php if($r['PhoneNumber'] != ""){ echo $r['PhoneNumber']; }?>" type="text" disabled >
								</div>
								</div>
								<div class="col-md-6">
								<div class="form-group">
								  <label for="inputsm">Email</label>
								  <input class="form-control " id="cpemail" value="<?php if($r['Email'] != ""){ echo $r['Email']; }?>" type="text" readonly >
								</div>
								</div>
								</div>
								<div class="form-group">
								  <label for="inputsm">Address</label>
								  <textarea class="form-control"id="cpaddress" readonly ><?php if($r['Address'] != ""){ echo $r['Address']; }?></textarea>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
								  <label for="inputsm">Country</label>
								  <input class="form-control " id="" value="<?php if($r['Country'] != ""){ echo $r['Country']; }?>" type="text" disabled >
								</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
								  <label for="inputsm">City</label>
								 <input class="form-control " id="" value="<?php if($r['City'] != ""){echo $r['City']; }?>" type="text" disabled >
								</div>
									</div>
								</div>
								
								
	                            </div>
	                        </div>
						</div>
					</div>
				</div>
			</div>
<!--------------change password----------------->
			<div class="content" >
	            <div class="container-fluid center">
	                <div class="row">
					
	                    <div class="col-md-12">
	                        <div class="card">
	                            <div class="card-header" data-background-color="orange">
								    <p class="category" style="color:#ffffff;font-size:17px;" > Change Password for the Web Admin Panel</p>
	                            </div>
	                            <div class="card-content">
									<div id="typography">
										<div class="row">
										<div class="col-md-2" ></div>
										<div class="col-md-8" >
										  <div class="tab-pane active" id="profile">
											<div class="form-group label-floating">
											  <label class="control-label" for="inputsm">Current Password</label>
											  <input class="form-control input-sm" id="cpassword"  type="password"  >
											</div>
											<div class="form-group label-floating">
											  <label class="control-label" for="inputsm">New Password</label>
											  <input class="form-control input-sm" id="npassword"  type="password"  >
											</div>
											<div class="form-group label-floating">
											  <label class="control-label" for="inputsm">Confirm password</label>
											  <input class="form-control input-sm" id="rtpassword"   type="password"  >
											</div>
                                            <center>
                                            <button  data-background-color="orange" class="btn btn-sm btn-primary"  id="ChangePassword" type="button">Submit</button></center>											
										</div>
										</div>
										<div class="col-md-2" ></div>
										</div>
									</div>
	                            </div>
	                        </div>
	                    </div>
	               </div>
	            </div>
	        </div>
	    </div>    
<!--------------------------------------------->
 <div class="col-md-3 t2" id="sidebar" style=" margin-top:75px;"></div>
			<footer class="footer">
				<div class="container-fluid">
					<nav class="pull-left">
						
					</nav>
					<a href="http://www.ubitechsolutions.com/" target="_blank" >
					<p class="copyright pull-right" style="padding-right:25px;" >
					Copyright &copy;<script>document.write(new Date().getFullYear())</script>
					Ubitech Solutions. All rights reserved.
					</p>
				</a>
				</div>
			</footer>
		</div>
	</div>
<a href="#"  id="notificationButton" class="button" hidden >Attendance</a>
<a href="#"  id="timeBreakNotification" class="button" hidden >Attendance</a>
</body>
<div id="mySidenav" class="pull-right sidenav" style="background-image:url(<?=URL?>../assets/img/bg7.jpg);background-repeat:no-repeat;">
            <div class="helpHeader"><span >Help</span><a style="color:black;" href="javascript:void(0)" class="closebtn text-right" onclick="closeNav()">x </a></div>
            <div id="sidenavData" class="sidenavData">
            </div>
          </div>

            <script src="<?=URL?>../assets/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/moment.js"></script>
   <script type="text/javascript" src="<?=URL?>../assets/js/daterangepicker.js"></script>
   <script src="<?=URL?>../assets/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <script src="<?=URL?>../assets/js/buttons.colVis.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/buttons.flash.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/jszip.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/buttons.html5.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/buttons.print.min.js"></script>

   <script>
            function openNav() 
            {
              document.getElementById("mySidenav").style.width = "360PX";
              $('#sidenavData').load('<?=URL?>help/helpNav',{'pageid' :'profile'});  
            }
            function closeNav() {
              document.getElementById("mySidenav").style.width = "0";
            }
  
  </script>

<script type="text/javascript">
var text = document.getElementById('puname');
text.addEventListener('input', function(e){
  var keyCode = e.keyCode ? e.keyCode : e.which;
  this.value = this.value.replace(/\s/g, '')
  if(keyCode === 32) return;
})


$('#Edit_cprofile').click(function(){
	document.getElementById('cpname').removeAttribute('readonly');
	document.getElementById('cpwebsite').removeAttribute('readonly');
	document.getElementById('cpemail').removeAttribute('readonly');
	document.getElementById('cpaddress').removeAttribute('readonly');
	document.getElementById('cpaddress').removeAttribute('readonly');
	$('#company_profile').show();
	$('#Edit_cprofile').hide();
	
})


$('#proile').click(function(){
	var pname = $('#pname').val();
	var puname = $('#puname').val();
	var pemail = $('#pemail').val();
	
	$.ajax({url: "<?php echo URL ?>/dashboard/updateProfile",
    data: {'pname':pname,'puname':puname,'pemail':pemail},
	success: function(result){
        if(result == 1){
		  doNotify('top','center',2,'Profile updated successfully.');
			   setTimeout(location.reload.bind(location), 1000);
		  }else{
			  doNotify('top','center',4,'some error occurs.');
			  setTimeout(location.reload.bind(location), 2000);
			  alert('false');
		  }
    }});
}) 

$('#company_profile').click(function(){
	var cpname = $('#cpname').val(); 	//cmpny
	var cpwebsite = $('#cpwebsite').val();
	var pname = $('#pname').val();  	// cntct person		
	var puname = $('#puname').val();	// user name
	var cppnumber = $('#cppnumber').val();//  contact
	var cpemail = $('#cpemail').val();	// email
	var cpaddress = $('#cpaddress').val(); 	// address
	
	$.ajax({url: "<?php echo URL ?>/dashboard/updateCProfile",
    data: {'cpname':cpname,'cpwebsite':cpwebsite,'cppnumber':cppnumber,'pname':pname,'puname':puname,'cpemail':cpemail,'cpaddress':cpaddress},
	success: function(result){
        if(result == 1){
		  doNotify('top','center',2,'Updated Successfully.');
			   setTimeout(location.reload.bind(location), 1000);
		  }else{
			  doNotify('top','center',4,'some error occurs.');
			   setTimeout(location.reload.bind(location), 2000);
			  alert('false');
		  }
    }});
})
</script>
<script type="text/javascript" >
	  $('#ChangePassword').click(function(){
		var cpassword = $('#cpassword').val();
		var npassword =  $('#npassword').val().trim();
		var rtpassword =  $('#rtpassword').val().trim();
		
		if(cpassword == ""){
			 $('#cpassword').focus();
			doNotify('top','center',3,'Please enter the current password');
			
			return false;
		}
		if(npassword.length < 6){
			$('#npassword').focus();
			$('#npassword').val(npassword);
			doNotify('top','center',3,'Password must contains at least 6 characters');
			return false;
		}
		if(rtpassword == ""){
			$('#rtpassword').focus();
			$('#rtpassword').val(rtpassword);
			doNotify('top','center',3,'Please Enter Confirm Password');
			return false;
		}
		
		if(npassword != rtpassword){
			$('#npassword').focus();
			$('#rtpassword').focus();
			doNotify('top','center',4,'New password and re-type password should be same.');
			return false;
		}
		
			$.ajax({url: "<?php echo URL;?>dashboard/updatePassword",
						data: {"cpassword":cpassword,"npassword":npassword,"rtpassword":rtpassword},
						success: function(result){
							
							if(result == 1){
								doNotify('top','center',2,'Password changed successfully.');
			                    setTimeout(location.reload.bind(location), 1000);
							}else{
								doNotify('top','center',4,'Please enter valid current password.');
			                   
							} 								
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			
		 
	  })
	</script>
	<script>
    $(document).ready(function(){
    $('.toggle-sidebar').click(function(){
    $("#sidebar").toggleClass("collapsed t2");
    $("#content").toggleClass("col-md-9");
    $("#sidebar").load('<?=URL?>admin/helpNav',{'pageid': 'profile'}); 
    });
    
    });
  </script>
</html>
