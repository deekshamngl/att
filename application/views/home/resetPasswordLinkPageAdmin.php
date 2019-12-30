<!doctype html>
<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

?>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>ubiAttendance</title>
	<style>
		.red{ 
			color:red; font-weight:'bold'; font-size:16px; 
		}
		.card img {
			width: 150px!important;
			height: auto;
		}
		#cancel{
			    background-color: transparent!important;
				color: #9c27b0!important;
				border: 1px solid #9c27b0!important;
		}
	</style>
</head>
<body>
		<?php $this->load->view('menubar/loadcss'); $this->load->view('menubar/loadjs'); ?>
		<div class="container">
		<?php if(!$isvalid_link)echo '<h3> Link has been expired.</h3>';//
		else {?>
		
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">
			   <div class="card">
					<div class="card-header" data-background-color="green">
						<h4 class="title">Reset Password</h4>
					</div> 
				<div style="padding:10%"><center>	
    <img src="<?=URL?>../assets/img/logo.png" alt="Ubitech" width="80px"/></center>
	<!-----------------Reset Passeord Form--------------------->
			   <form id="signupform" class="form-horizontal" role="form">
			   <input type="hidden" id="hasta" value="<?=$email?>"/>
			   <input type="hidden" id="ctr" value="<?=$ctr?>"/>
			   <input type="hidden" id="orgid" value="<?=$orgid?>"/>
					<div class="form-group">
						<label for="email" class="col-sm-3">New password <span class="red"> *</span></label>
						<div class="col-sm-9">
							<input type="password" class="form-control" name="password" id="password" placeholder="">
							<span class="red" id='p'></span>
						</div>
					</div>
					<div class="form-group">
						<label for="email" class=" col-sm-3">Confirm password <span class="red"> *</span></label>
						<div class="col-sm-9">
							<input  type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="	
Confirm New Password">
							<span class="red" id='cp'></span>
						</div>
					</div>
					<div class="form-group">
						<!-- Button -->                                 
						<div class="row" id="buttons">
							<div class="col-md-6">
								<button id="submit" type="button" class="btn btn-success btn-block">Reset Password <span style="display:none;" class="fa fa-circle-o-notch fa-spin" id="wait"></span></button>
							</div>
							<div class="col-md-6">
								<a  href="<?php echo URL;?>" id="cancel"  type="reset" class="btn btn-block">Cancel</a>
							</div>
						</div>
					</div>                             
				</form>
	<!-----------------/Reset Password Form--------------------->  
	<center>
	<h4 style="color:green;display:none" id="succsss">Password reset successfully !<br/><i class="fa fa-check-circle-o fa-3x"></i><br/><br/></h4>
	</center>
				</div>					
				</div>
			</div>
			<div class="col-md-4"></div>
		</div> 
		<?php } ?>
		</div>
		<footer class="footer">
			<div class="container-fluid">	
			</div>
		</footer>
</body>
	<script>
	$(function(){
		$('#submit').click(function(){
				$cpwd=$("#password_confirmation");
				$pwd=$("#password");
				$check=1;
				$cpwd.css("background-color", "transparent");
				$pwd.css("background-color", "transparent");
				$('#p').text('');
				$('#cp').text('');
				if($cpwd.val()==''){
					$cpwd.css("background-color", "rgba(255, 0, 0, 0.21)");
					$('#cp').text('Confirm Password Required');
					$check=0;
				}
				if($pwd.val()==''){
					$pwd.css("background-color", "rgba(255, 0, 0, 0.21)");
					$('#p').text('Password Required');
					$check=0;
				}
				if($cpwd.val()!=$pwd.val()){
					$cpwd.css("background-color", "rgba(255, 0, 0, 0.21)");
					$('#cp').text('Confirm Password not matched');
					$check=0;
				}
				if($check){
					$('#wait').show();
					var hasta=$('#hasta').val();
					var ctr=$('#ctr').val();
					var orgid=$('#orgid').val();
					var new_pwd=$pwd.val();
				//	alert(hasta+" "+vista+" "+new_pwd);
				//	return false;
					///////--------success section
					$.ajax({ 
				url:'https://ubiattendance.ubihrm.com/index.php/cron/setAdminPassword?hasta='+hasta+'&np='+new_pwd+'&ctr='+ctr+'&orgid='+orgid,
						type:'GET',
						headers:{
							"Content-Type":'application/x-www-form-urlencoded'
						},
						cache:false,
						success: function (data) {
							//alert(data);
						//data=JSON.parse(data);
							if(data==1) // updated successfully
								{
								$('#cp').css("color", "green");
								$cpwd.val('');
								$pwd.val('');
								$('#signupform').hide();
								$('#succsss').show();
								return false;
							}else{
								$('#cp').css("color", "red");
								$('#cp').text("Your current password can not be used as new password.");
								return false;
							}
							$('#wait').hide();
							
						},
						error:function(request, textStatus, errorThrown){
							toast("Poor Network connection! Try later");
							$('#wait').hide();
					}
				});
					///////--------/success section
				}else{
					return false;
				}
		});
		$('#cancel').click(function(){
				$cpwd=$("#password_confirmation");
				$pwd=$("#password");
					$cpwd.css("background-color", "transparent");
					$pwd.css("background-color", "transparent");
					$('#p').text('');
					$('#cp').text('');
					$check=1;
		});
		
	});
	</script>
</html>
