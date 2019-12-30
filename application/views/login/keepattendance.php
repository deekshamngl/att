<!DOCTYPE html>
<html>
<head>
<!-- Bootstrap core CSS     -->
    <link href="<?=URL?>../assets/css/bootstrap.min.css" rel="stylesheet" />
<style>
form {
     //  border: 3px solid #f1f1f1;
     //  border: 3px solid #f1f1f1;
    }

@media only screen and (min-width: 501px) {
		form{
			margin-top:10%;
		//	width:400px!important;
		}
		.container{
			width:700px!important;
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
   // padding: 16px;
   background-color:white;
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
#ok{

	width:50%;
}

</style>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="background-color:#8080800d">
<center>
<form id="form">


  <div class="container">
  <div class="imgcontainer">
    <img src="<?=URL?>../assets/img/logo.png" alt="Ubitech" height="85px" width="150px"/>
  </div>
	<p>Starting July 05, We would be only be keeping attendance data of last 90 days for faster & better performance. The earlier Attendance Records would be deleted. If required, you can download the data at your end from the Admin web panel before July 5th 2019.</p>
	<div></div>
	<div class="row">
	
	<!--<input type="checkbox" id="check" >&nbsp;&nbsp;I Agree&nbsp;&nbsp;-->
	<button id="ok" >I Understand and Accept</button>
	
    
	</div>
  </div>
 
</form>

</center>
</body>
	<script src="<?=URL?>../assets/js/jquery-3.1.0.min.js" type="text/javascript"></script>
	<script src="<?=URL?>../assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script>

	$('#check').on('click',function()
				{
					if(this.checked)
					{
						 $("#ok").css("visibility", "visible");
					}
					else
					{
						$("#ok").css("visibility", "hidden");
					}
					
				});
	</script>
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
				alert(expsts);
				var data = {username: username,password:password,remmberme:remmberme};
				$.ajax({
					url: '<?=URL?>login/login',
					type: 'post',
					data: data,
					dataType: 'json',
					success: function (data) {
						//alert(data);
						
						
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
					error: function(data)
					{
					
					}
					
				});
			
			return false;
		});
		
		
		
		$('#ok').click(function(){
			var expsts = '<?php isset($_SESSION['expirydate'])?$_SESSION['expirydate']:0;?>';
			
			
			$.ajax({
					url: '<?=URL?>login/statuschanged',
					type: 'post',
					dataType: 'json',
					success: function (data) {
					
						if(data == 1)
						{
								location.replace("<?=URL?>admin/attendances");
							
						}
						
						else
						{
							alert('error');
							//location.replace("<?=URL?>Dashboard");
						}
					},
					error: function(data)
					{
					
					}
					
				});	
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
							$('#fMessage1').fadeIn(2000);
						}
							if(data == 2){
								//alert("2");
							$('#fMessage2').fadeIn(2000);
							//$('#cont').fadeIn(2000);
							
							
						}else{
							//alert("3");
						$('#fMessage1').fadeIn(2000);
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