<html>
 <head>
 <!--<meta http-equiv="refresh" content="60;url=http://192.168.0.200/ubiattendance/index.php" />-->
  <style>
.wrapper
	{
		 overflow-x:hidden;
	}
    #buyplane{
		//margin-left:60px;
		height:40px;
		text-align: center;
		font-size:14px;
		margin-top:8px;
		padding-top:9px;
        width:150px;
       font-style:initial;	
	   
	}
   .btn-success{
   // padding: 10px 20px !important; 
    background-color: #ff9800 !important;
    color: #fff !important;
    font-size: 13px !important;
    border-radius: 2px !important;
    border-top-left-radius: 5px !important;
    border-top-right-radius: 5px !important;
    border-bottom-right-radius: 5px !important;
    border-bottom-left-radius: 5px !important;
    text-decoration: none !important;
    text-decoration-line: none !important;
    text-decoration-style: initial !important;
    text-decoration-color: initial !important;
	text:bold;
	}
	#getAtt
	{
		width:80px !important;
		height:40px !important;
		padding: 10px 20px !important;
	}
	#printsection
	{
		margin-top:45px;
	}
	.btn-primary
	{
		padding:10px 20px !important;
	}
	
  </style>
 </head>
</html>
<?php
		$this->load->view('menubar/loadcss');			
		$this->load->view('menubar/loadjs');
		?>
		
<?php 
function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}


$ip = getRealIpAddr(); // This will contain the ip of the request
?>
		<nav class="navbar navbar-transparent navbar-absolute">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<?php 
							$ref=0;
							if(isset($_SESSION['orgid'])){
								$ref=$_SESSION['orgid'] * $_SESSION['orgid'];
								$ref+=99;
							}
						?>
						<center>
						<div class="hidden-lg hidden-md  hidden-xl  col-sm-8 col-xl-8" style="color:black">
							<div style="margin:0px!important;font-size:1.5em">
								<strong> </strong>
							</div>
						</div>
						
						<div class="row">
						<div class="col-sm-5">
						<div class="col-sm-10 col-xs-10 col-md-5 col-lg-5" style="padding-right:25px;box-shadow:2px 2px 2px #4c2652; background-color:#008067;color:wheat;min-width:295px">
									<?php echo isset($_SESSION['orgName'])?'<div style=""><strong>'.$_SESSION['orgName'].'</strong></div>':'';
									
									 ?>
									
									 <?php echo '<div>Customer Reference No(CRN): <b>'. $ref.'</b></div>'; ?>
						</div>
						</div>
						<div class="col-sm-6">
						<div class="hidden-xs hidden-sm col-sm-12 col-xs-12  " style="color:black; margin-left:108px; margin-top:15px;">
						<span style="margin:0px!important;font-size:2em">
								<strong></strong>
						</span>
						</div>
						</div>
						</div>
						<!--<div class="hidden-sm hidden-xs col-md-7 " style="color:black; margin-left:300px; margin-top:0px;">
							<span style="margin:0px!important;font-size:1.8em ">
								<strong>Administrator Panel</strong>
							</span>
						</div>-->
					</center>
				
						<!-----notification code--->
							<span id="countTB" hidden></span>
							<span id="presentCount" hidden></span>
							<a href="#"  id="notificationButton" class="button" hidden >att</a>
							<a href="#"  id="timeBreakNotification" class="button" hidden >brk</a>
						<!-----notification code close--->
						
<!-----notification script code start--->
<script> /*
	var counter=0;// to prevent notification for attendance on first loading of window
	var counter1=0;// to prevent notification for time break on first loading of window					
		getTimeoffEmpCount();setInterval(getTimeoffEmpCount,5000);				
		getPresentEmpCount();setInterval(getPresentEmpCount,5000);				
	 
				if (Notification.permission !== "granted")
				{
				Notification.requestPermission();
				}
				$("#notificationButton").click(function(){
					notifyBrowser("ubiAttendance Notification","Attendance Marked","http://ubiattendance.ubihrm.com/index.php/dashboard");
					//e.preventDefault();
				});
				$("#timeBreakNotification").click(function(){
					notifyBrowser1("ubiAttendance Notification","TimeBreak Marked","http://ubiattendance.ubihrm.com/index.php/dashboard");
					//e.preventDefault();
				});
				function notifyBrowser(title,desc,url) 
				{
				if (!Notification) {
				console.log('Desktop notifications not available in your browser..'); 
				return;
				}
				if (Notification.permission !== "granted")
				{
				Notification.requestPermission();
				}
				else {
				//alert(counter);
				if(counter!=0){
				var notification = new Notification(title, {
				icon:'http://ubiattendance.ubihrm.com/assets/img/important-Img-used-in-ubiattendance-push-notification.png',
				body: desc,
				});

				// Remove the notification from Notification Center when clicked.
				notification.onclick = function () {
				window.open(url);      
				};

				// Callback function when the notification is closed.
				notification.onclose = function () {
				console.log('Notification closed');
				};
				}
				counter++;
				}
				}
				function notifyBrowser1(title,desc,url) 
				{
				if (!Notification) {
				console.log('Desktop notifications not available in your browser..'); 
				return;
				}
				if (Notification.permission !== "granted")
				{
				Notification.requestPermission();
				}
				else {
				//alert(counter);
				if(counter1!=0){
				var notification = new Notification(title, {
				icon:'http://ubiattendance.ubihrm.com/assets/img/important-Img-used-in-ubiattendance-push-notification.png',
				body: desc,
				});

				// Remove the notification from Notification Center when clicked.
				notification.onclick = function () {
				window.open(url);      
				};

				// Callback function when the notification is closed.
				notification.onclose = function () {
				console.log('Notification closed');
				};
				}
				counter1++;
				}
				}
   */
	</script>
	<!----nottification code script -close--->
					</div>
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav navbar-right">	
						<li>
						<a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-user" ></i>
						<b>&nbsp;<?php echo $_SESSION['name'];?></b>
						</a>
						<ul class="dropdown-menu">
						<li><a href="<?php echo URL;?>dashboard/profile">My Profile</a></li>
						<li><a href="<?php echo URL;?>dashboard/changePassword">Change Password</a></li>
						<li><a href="<?=URL?>Logout">Logout</a></li>
						</ul>
						</li>
						</ul>
					
					<?php if(isset($pageid)){ ?>
				 <!-- <a href="<?=URL?>Myplan"  data-background-color="orange" class="btn btn-sm btn-primary navbar-right	" id="buyplane" type="button" >Upgrade Plan</a>	-->
					<?php } ?>
				<!--
				
						<form class="navbar-form navbar-right" role="search">
							<div class="form-group  is-empty">
								<input type="text" class="form-control" placeholder="Search">
								<span class="material-input"></span>
							</div>
							<button ty Administrator Panelpe="submit" class="btn btn-white btn-round btn-just-icon">
								<i class="material-icons">search</i><div class="ripple-container"></div>
							</button>
						</form>
						
						-->
						
						<div class="container text-right">
						<a href="<?php echo URL; ?>Myplan" Id="myplan" class="btn btn-success">Upgrade</a>
					    </div>
					</div>
				</div>
			</nav>
		
	   <script type="text/javascript">  
			/*tawk.to script*/
			var ipAddr=<?php echo json_encode($ip); ?>;
//alert(ipAddr);

				$.getJSON("https://api.ipinfodb.com/v3/ip-country/?key=f89dea8568c20b6c5340c439372ed203b522e8c7418299e13819d4ac75c74999&ip="+ipAddr+"&callback=?&format=json",
				 
				   function(data) {
					 
					var a=data["countryName"];

					/* if(a=="India"){

				  

				  $("#variable-price-span").html(

				'<span class="pricing__currency">&#8377;</span>60<span class="pricing__period">/ user / month</span>'
				);

				}

				if(a=="United Arab Emirates"){
				  $(".uae-top").show();
				}
				else{
				  $(".india-top").show();
				} */

				var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
				$(window).on('load', function () {
				var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
				s1.async=true;
				if(a=="India"){
				s1.src='https://embed.tawk.to/5b2b630eeba8cd3125e30c46/default';

				}
				else{
				s1.src='https://embed.tawk.to/5c63f7966cb1ff3c14cc4eb0/default';
					
				}

				s1.charset='UTF-8';
				s1.setAttribute('crossorigin','*');
				s0.parentNode.insertBefore(s1,s0);
				});


		 });
			
			/* 
			
			var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
			$(window).on('load', function () {
			var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
			s1.async=true;
			s1.src='https://embed.tawk.to/5b2b630eeba8cd3125e30c46/default';
			s1.charset='UTF-8';
			s1.setAttribute('crossorigin','*');
			s0.parentNode.insertBefore(s1,s0);
			}); */
		</script>	