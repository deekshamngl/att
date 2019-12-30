<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>ubiAttendance</title>
	<style>
		.red{
			color:red;
			font-weight:'bold';
			font-size:16px;
		}
	</style>
</head>
<body>
	<div class="wrapper">
		<?php
			$data['pageid']=100;
			$this->load->view('ubitech/sidebar',$data);
		?>
	    <div class="main-panel">
			<?php
				$this->load->view('ubitech/navbar');
			?>
			</br>
			<div class="content">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-md-12">
	                        <div class="card">
	                            <div class="card-header" data-background-color="purple">
	                                <h4 class="title">Change Password</h4>
	                               
	                            </div>
	                            <div class="card-content">
									<div id="typography">
										
										<div class="row">
										<div class="col-md-3" ></div>
										<div class="col-md-4"   >

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
                                            <button  data-background-color="purple" class="btn btn-sm btn-primary"  id="ChangePassword" type="button">Submit</button></center>											
										</div>
										</div>
										<div class="col-md-2" ></div>
										
											<!--<table id="example" class="display table" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>Name</th>
													<th>UserName</th>
													<th>Designation</th>
													<th>Shift</th>
													<th>Department</th>
													<th>Contact</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</thead>
										</table>-->
										</div>
									</div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>

	       
			<footer class="footer">
				<div class="container-fluid">
					<nav class="pull-left">
						
					</nav>
					<p class="copyright pull-right">
						&copy; <script>document.write(new Date().getFullYear())</script> <a href="#">DESIGNED BY</a> Ubitech Solutions Pvt. Ltd.
					</p>
				</div>
			</footer>
		</div>
	</div>

</body>

	<script type="text/javascript" >
	  $('#ChangePassword').click(function(){
		var cpassword = $('#cpassword').val();
		var npassword =  $('#npassword').val();
		var rtpassword =  $('#rtpassword').val();
		
		if(cpassword == ""){
			 $('#cpassword').focus();
			doNotify('top','center',3,'Please enter Current password.');
			return false;
		}
		if(npassword == ""){
			$('#npassword').focus();
			doNotify('top','center',3,'Please enter New password');
			return false;
		}
		if(npassword.length<=5){
			$('#npassword').focus();
			doNotify('top','center',3,'Password should be minimum 6 digit');
			return false;
		}
		if(rtpassword == ""){
			$('#rtpassword').focus();
			doNotify('top','center',3,'Please enter Confirm password');
			return false;
		}
		
		if(npassword != rtpassword){
			$('#npassword').focus();
			$('#rtpassword').focus();
			doNotify('top','center',4,'New password and re-type password should be same.');
			return false;
		}
		
			$.ajax({url: "<?php echo URL;?>ubitech/updatePassword",
						data: {"cpassword":cpassword,"npassword":npassword,"rtpassword":rtpassword},
						success: function(result){
							
							if(result == 1){
								doNotify('top','center',2,'Password changed successfully.');
			                    setTimeout(location.reload.bind(location), 1000);
							}else{
								doNotify('top','center',4,'Please enter valid current password.');
			                    //setTimeout(location.reload.bind(location), 1000);
							} 								
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			
		 
	  })
	</script>

	

</html>
