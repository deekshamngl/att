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
input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
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
@media screen and (max-width: 300px) {
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
  border: solid 3px #d1a0ff;
  transition: border-width 0.4s linear ;
}

.border-button:hover { border-width: 8px; }
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
		<!---------------------alert end--------------->
<form>
  <div class="imgcontainer">
    <img src="<?=URL?>../assets/img/logo.png" alt="Ubitech" height="85px" width="150px"/>
  </div>
  <div class="container">
    <label><b>Username</b></label>
    <input type="text" placeholder="Enter Username" id="uname" required>
    <label><b>Password</b></label>
    <input type="password" placeholder="Enter Password" id="psw" required>
    <button id="login">Login</button>
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
<div class="container border-button alert1 " id="cont" style="background-image:url(<?=URL?>../assets/img/bg6.jpg); font-size:20px; height:260px;
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
			    var username=$('#uname').val();
			    var password=$('#psw').val();
				var data = {username: username,password:password};
				$.ajax({
					url: '<?=URL?>login/login',
					type: 'post',
					data: data,
					dataType: 'json',
					success: function (data) {
					//	alert(data);
						if(data == 0){
							$('#fMessage').fadeIn(2000);
						}else if(data == 2){
							$('#alert1').fadeIn(2000);
							$('#cont').fadeIn(2000);
							
							
						}else
							location.replace("<?=URL?>dashboard");
					},
					error: function(data){
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
	});
	</script>
</html>