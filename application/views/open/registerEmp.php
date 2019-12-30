<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>ubiAttendance</title>
			
			<link rel="stylesheet" href="https://ubiattendance.ubihrm.com/assets/css/bootstrap.min.css" />
			<script type="text/javascript" src="https://ubiattendance.ubihrm.com/assets/js/jquery-3.1.0.min.js"></script>
			<script type="text/javascript" src="https://ubiattendance.ubihrm.com/assets/js/bootstrap.min.js"></script>
			
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
			</head>
			<body>
			<br/><br/>
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12"></div>
					<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12" style="border:2px solid lightgrey;padding:3%;background-color:#f7f7f7">
						<center>
							<img width="30%" src="http://ubitechsolutions.com/ubitechsolutions/Mailers/ubiAttendance/Clock_time_in_with_4_easy_steps/logo.png" /><hr/><br/>
						
							<div>
								<form>
									<div class="form-group">
										<input readonly='readonly' type="text" class="form-control" id="email" name="email" placeholder="email" value="<?php echo decode5t(isset($_REQUEST['tocken1'])?$_REQUEST['tocken1']:'');?>">
									</div>
									
									<div class="form-group">
									<input id="refid" readonly='readonly' type="hidden" value="<?php echo decode5t(isset($_REQUEST['tocken'])?$_REQUEST['tocken']:'0');?>"/>
										<div class="row">
											<div class="col-xs-6"><input type="text" class="form-control text" id="first_name" name="first_name" placeholder="First Name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)"></div>
											<div class="col-xs-6"><input type="text" class="form-control text" id="last_name" name="last_name" placeholder="Last Name"  onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" ></div>
										</div>        	
									</div>
									<div class="form-group">
										<input type="text" pattern="[0-9]{1}[0-9]{9}" class="form-control" id="mobile" name="mobile" placeholder="Mobile No." onKeyUp="$(this).val($(this).val().replace(/[^\d]/ig, ''))">
									</div>
									
									<div class="input-group">
										
										<!--<input id="password" type="password" class="form-control" name="password" placeholder="password (At least 6 character long)">-->
										<input id="password" type="password" class="form-control" name="password" value="123456" readonly title="Password is initially set. It can be changed later on by the Admin or the Employee">
										
										<span class="input-group-addon" id="eyeBtn"><i id="eye" class="fa fa-eye"></i></span>
									</div>
									<div class="form-group" style="margin-top:5%">
										<button type="button" id='save' class="btn btn-warning btn-block btn-lg "/> Register me <i class="fa fa-circle-o-notch fa-spin" id="wait" style="display:none"></i></button>
									</div>
								</form>
							</div>
						</center>
					</div>
					<div col-md-3 col-lg-3 col-sm-12 col-xs-12></div>
				</div>
			</div>
			</body>
			<script>
			$(function()
			{
				$('#save').click(function(){
					var first_name=$('#first_name');
					var last_name=$('#last_name');
					var mobile=$('#mobile');
					var password=$('#password');
					var refid=$('#refid');
					var email=$('#email');
					if(!validateEmail(email.val()))
						{
						 email.focus();
						alert("Invalid email");
						return false;
					}else if( first_name.val()=='')
						{
						 first_name.focus();
						alert("Please enter the first name");
						return false;
					}else if( last_name.val()=='')
						{
						 last_name.focus();
						alert("Please enter the last name");
						return false;
					}else if( mobile.val().length < 6 || mobile.val().length > 15)
						{
						mobile.focus();
						alert("Please enter the valid mobile No.");
						return false;
					}
					// else if(password.val().length < 6)
						// {
						// mobile.focus();
						// alert("Password must contain at least 6 character");
						// return false;
					// }
					else {  $("#wait").show();
					/**/
					
					$.ajax({url: "<?php echo URL;?>services/registerEmp",
					   data: {"f_name":first_name.val(),"l_name":last_name.val(),"username":email.val(),"password":password.val(),"countrycode":'0',"country":'0',"contact":mobile.val(),"shift":'0',"designation":'0',"department":'0',"org_id":refid.val()},
					  success: function(result){
					  $("#wait").hide();
					  result=JSON.parse(result);
						if(result['sts'] == 2){ // if already exist email
						   alert("email already exists");
						  $('#email').css("border-color", "red");
						}else if(result['sts'] == 3){ // if already exist phone
						   alert("Phone already exists");
						  $('#mobile').css("border-color", "red");
						}else{
						   if(result['sts'] == 0){
							 alert("Emplyoee couldn't register. Try later");
						   }else{
							  alert("Thank you! You have registered successfully.");
							 window.location.href="<?php echo URL;?>services/thanks";
						   }
						}
						//location.reload();
					  },
					  error: function(result)
					  {
					  $("#wait").hide();
						 alert("Poor Network connection! Try later");
					  }
					});
				  
					}
					
				});
				$('#eyeBtn').click(function(){
					view();
				});
			});
			function view() {
				var x = document.getElementById("password");
				if (x.type === "password") {
					x.type = "text";
					$('#eye').removeClass('fa-eye');
					$('#eye').addClass('fa-eye-slash');
				} else {
					x.type = "password";
					$('#eye').removeClass('fa-eye-slash');
					$('#eye').addClass('fa-eye');
				}
			}
			function validateEmail(email) {
			var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(String(email).toLowerCase());
			}
        </script>
			</html>