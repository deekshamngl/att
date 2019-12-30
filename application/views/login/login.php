<!DOCTYPE html>
<html>
<head>
<!-- Bootstrap core CSS     -->
    <link href="<?=URL?>../assets/css/bootstrap.min.css" rel="stylesheet" />
<style>
form {
       border: 3px solid #f1f1f1;
    }

@media only screen and (min-width: 501px) {
		form{
			margin-top:4%;
			width:400px!important;
		}
		.container{
			width:400px!important;
		}
		.alert{
	width:400px;
	}
}
input[type=text], input[type=password] 
{
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

button {
    background-color: #008067;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}
button:disabled {
  color: #C0C0C0;
  background-color: grey;
}

button:hover {
    opacity: 0.8;
}

.cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
}

.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
}

img.avatar {
    width: 40%;
    border-radius: 50%;
}

.container {
    padding: 16px;
}

span.psw {
    float: right;
    padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px){
    span.psw {
       display: block;
       float: none;
    }
    .cancelbtn {
       width: 100%;
    }
}
.alert{
	display:none;	
}
.alert1{
	display:none;	
}

.border-button {
  //border: solid 3px #d1a0ff;
  border: solid 3px red;
  transition: border-width 0.4s linear ;
}

.border-button:hover { border-width: 8px; }
#remmbermediv
{
	float:left;
}
</style>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<center>
		<!---------------------alert start--------------->
			 <div  class="alert alert-danger alert-dismissable fade in" id="fMessage">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Login Failed !  </strong> Invalid username or password.
			 </div>
			 <div  class="alert alert-danger alert-dismissable fade in" id="alert1">
				<a href="#" class="close" id="close1" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Login Failed !</strong> your subscription expired
				
			 </div>
			 
			 <div  class="alert alert-danger alert-dismissable fade in" id="fMessage1">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong> Failed !  </strong> Email id not registered .
			 </div>
			  <div  class="alert alert-danger alert-dismissable fade in" id="fMessage2">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong> Success ! </strong> Password Reset link sent successfully on your email.
			 </div>
			 <div  class="alert alert-danger alert-dismissable fade in" id="fMessage3">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong></strong> Please enter Email id.
			 </div>
		<!---------------------alert end--------------->
<form id="form">
  <div class="imgcontainer">
    <img src="<?=URL?>../assets/img/newlogo.png" alt="Ubitech" height="85px" width="110px"/>
  </div>
  <div class="container">
    <label><b>Username</b></label>
    <input type="text" placeholder="Enter Username" id="uname" value="<?php if(isset($_COOKIE['username'])) echo $_COOKIE['username'] ?>" required>
	<p></p>
	<div></div>
    <label><b>Password</b></label>
    <input type="password" placeholder="Enter Password" id="psw" value="<?php if(isset($_COOKIE['password'])) echo $_COOKIE['password'] ?>" required>
	<!--<div id="remmbermediv" >
	<input type="checkbox" id= "remmberme"  name="remmberme" />
	<label>Remember me</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	</div>-->
    <button id="login">Login</button>
	&nbsp;<a href="" id="to-recover" class="pointer pull-left " >Forgot password ? </a>
	<a href="https://www.ubihrm.com/attendance-app/sign-up" class="pointer pull-right" >Sign up </a>
    <!--<input type="checkbox" checked="checked"> Remember me-->
  </div>
  <div class="container" style="background-color:#f1f1f1">
    <span> 
		<!--<p class="copyright pull-right" style="" >
              &copy; <script>document.write(new Date().getFullYear())</script>. Developed by<a href="http://www.ubitechsolutions.com/" target="_blank" > Ubitech Solutions </a>
            </p>-->
		<a href="http://www.ubitechsolutions.com/" target="_blank" >
			<p class="copyright pull-right" style="padding-right:25px;" >
			Copyright &copy;<script>document.write(new Date().getFullYear())</script>
			Ubitech Solutions. All rights reserved.
			</p>
		</a>
			
	</span>
  </div>
</form>
<form id="form1" style="display:none;" >
  <div class="imgcontainer">
    <img src="<?=URL?>../assets/img/logo.png" alt="Ubitech" height="85px" width="150px"/>
  </div>
  <div class="container">
    <label><b>Enter your registered email id.  </b></label>
    <input type="text" placeholder="Registered email id" id="email"  pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,3}$" required >
    
    <button id="submit" >Submit</button>
	  <button id="submit1" style="background-color:orange;" >Back to login</button>
	  <!--onclick="history.go(-1)"-->
    <!--<input type="checkbox" checked="checked"> Remember me-->
  </div>
  <div class="container" style="background-color:#f1f1f1">
    <span> 
		<p>
			&copy; <?php echo date('Y');?>, Ubitech Solutions Pvt Ltd, All Rights Reserved
		</p>
	</span>
  </div>
</form>

</br>
<div class="container border-button alert1 " id="cont" style="background-image:url(<?=URL?>../assets/img/bg10.jpg); font-size:20px; height:260px;
 font-family: Helvetica;">

<a href="#" class="close" id="close2" data-dismiss="buyclose" aria-label="close">&times;</a>
<div class="imgcontainer">
    <!--<img src="<?=URL?>../assets/img/logo.png" alt="Ubitech" height="60px" width="100px"/>-->
  </div>
<b Style="color:purple;">Continue your Attendance application </b></br>
</br>
    <p id="buy1"> If you want to increase your trial period..<a> Click here</a></p>
	<p id="buy2"> If you want to purchase this product..<a> Click here</a></p>
</div>



</center>
</body>
	<script src="<?=URL?>../assets/js/jquery-3.1.0.min.js" type="text/javascript"></script>
	<script src="<?=URL?>../assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script>
	
	$(function(){
	  
		$('#login').click(function(){
			
			     var remmberme = 0	;
				if($("#remmberme"). prop("checked") == true)
				{
					remmberme = 1;
				}
				//alert("as");
			    var username=$('#uname').val();
			    var password=$('#psw').val();
				var expsts = '<?php isset($_SESSION['expirydate'])?$_SESSION['expirydate']:0;?>';
				var data = {username: username,password:password,remmberme:remmberme};
				$.ajax({
					url: '<?=URL?>login/login',
					type: 'post',
					data: data,
					dataType: 'json',
					success: function (data) {
						//alert(data);
						
						//alert(data);
						//return false;
						if(data == 0){
							$('#fMessage').fadeIn(2000);
						}else if(data == 1){
							location.replace("<?=URL?>Myplan");
							//$('#alert1').fadeIn(2000);
							//$('#cont').fadeIn(2000);
						}else
						{
							location.replace("<?=URL?>admin/attendances");
							//location.replace("<?=URL?>Dashboard");
						}
					},
					error: function(data){
					
					}
					
				});
			
			return false;
		});
		
		$('#submit').click(function(){
			  //alert("as");
			    var email=$('#email').val();
			   
				
				var data = {email: email};
				$.ajax({
					url: '<?=URL?>login/forgotpswd',
					type: 'post',
					data: data,
					
					dataType: 'json',
				
					success: function (data) {
						//alert(data);
						 if(data == 0){
							 //alert("0");
							$('#fMessage1').fadeIn(1000);
						}
							if(data == 2){
								//alert("2");
							$('#fMessage2').fadeIn(1000);
							 $("#submit").attr("disabled", true);
							
						}
						if(data == 1)
							{
							$('#fMessage3').fadeIn(1000);	
							}
						else{
							//alert("3");
						$('#fMessage1').fadeIn(1000);
						}
							//location.replace("<?=URL?>dashboard"); 
					},
					error: function(data){
					//alert("3");
					}
					
				});
			
			return false;
		});
		
		
		
		
		
		$('.close').click(function(){
			$('.alert').fadeOut(1000);
			
		});
		$('#close1').click(function(){
			$('#alert1').fadeOut(1000);
			//$('#cont').fadeOut(1000);
		
		});
		$('#close2').click(function(){
			//$('.buyclose').fadeOut(1000);
		$('#cont').fadeOut(1000);
			
		});	
		$('#to-recover').click(function(){
			//$('.form1').fadeOut(1000); 
			 $(form1).show();
			  $(form).hide();
			  return false;
		});	
		
		$('#submit1').click(function(){
			  $(form).show();
			  $(form1).hide();
			  return false;
		});
	});
	</script>
</html>