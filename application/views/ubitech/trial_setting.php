<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>ubiAttendance</title>
</head>
<body>  
  	
	<div class="wrapper">
		<?php
			$data['pageid']=121.2;
			$this->load->view('ubitech/sidebar',$data);
		?>
		<?php
$data=isset($data)?$data:'';

// print_r($data);


?>
	    <div class="main-panel">
			<?php
				$this->load->view('ubitech/navbar');
			?>
			<div class="content">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-md-12">
						
	                        <div class="card">
	                            <div class="card-header" data-background-color="purple">
	                                <h4 class="title">Trial Settings</h4>
	                               
	                            </div>
	                            <div class="card-content">
									<div id="typography">
											
										<div class="row">
											<div class="col-md-1 col-lg-1"></div>
											<div class="col-xs-12 col-md-2 col-lg-2 col-sm-6 form-group">
												  <label>Trial Days</label>
											  
												<input class="form-control"  type="number" id="days" value="<?php if(isset($result) && $result['res']==1 ){ echo $result['detail'][0]['trial_days']; } ?>" />
											
											</div>	
											
											<div class="col-xs-12 col-md-2 col-lg-2 col-sm-6 form-group">
												  <label>User limit</label>
											  
												<input class="form-control"  type="number" id="user" value="<?php if(isset($result) && $result['res']==1 ){ echo $result['detail'][0]['user_limit']; } ?>" />
												
											  <!--
												<button style="background-color:#942bad;" class="btn btn-sm btn-primary" id="user_limit" type="button">submit</button>
												-->
											</div>
											<div class="col-xs-12 col-md-7 col-lg-7" >
											 <h4>Addons</h4>
											   <div class="form-group" style="margin-top:-0px;" >
					<div class="row" >
						<div class="col-sm-4">
							<input type="checkbox"  name="attendanceaddon" id = "attendanceaddon" value="<?php echo $result['detail'][0]['bulk_attendance'] ?>" <?php if($result['detail'][0]['bulk_attendance']==1) echo 'checked';  ?> />&nbsp;&nbsp;&nbsp;
							<label>Admin Attendance</label>
						</div>
						<div class="col-sm-4">
							<input type="checkbox"  name="locationtracking" id = "locationtracking" value="<?php echo $result['detail'][0]['location_tracing'] ?>" <?php if($result['detail'][0]['location_tracing']==1) echo 'checked';  ?> />&nbsp;&nbsp;&nbsp;
							<label>Location Tracking</label>
						</div>
						<div class="col-sm-4">
							<input type="checkbox"  name="visitpunch" id = "visitpunch" value="<?php echo $result['detail'][0]['visit_punch'] ?>" <?php if($result['detail'][0]['visit_punch']==1) echo 'checked';  ?> />&nbsp;&nbsp;&nbsp;
							<label>Visit Punch</label>&nbsp;&nbsp;&nbsp;
						</div>
					</div>
					<div class="row">
					<div class="col-sm-4">
						<input type="checkbox"  name="geofence" id = "geofence" value="<?php echo $result['detail'][0]['geo_fence'] ?>" <?php if($result['detail'][0]['geo_fence']==1) echo 'checked';  ?> />&nbsp;&nbsp;&nbsp;
						<label>Geofence</label>
						</div>
						<div class="col-sm-4">
						<input type="checkbox"  name="payroll" id = "payroll" value="<?php echo $result['detail'][0]['payroll'] ?>" <?php if($result['detail'][0]['payroll']==1) echo 'checked';  ?> />&nbsp;&nbsp;&nbsp;
						<label>Hourly Pay</label>
						</div>
						<div class="col-sm-4">
						<input type="checkbox"  name="timeoff" id = "timeoff" value="<?php echo $result['detail'][0]['time_off'] ?>" <?php if($result['detail'][0]['time_off']==1) echo 'checked';  ?> />&nbsp;&nbsp;&nbsp;
						<label>Timeoff</label>
						</div>
					</div>
					<div class="row">
					<div class="col-sm-4">
						<input type="checkbox"  name="flexishift" id = "flexishift" value="<?php echo $result['detail'][0]['Addon_flexi_shif'] ?>" <?php if($result['detail'][0]['Addon_flexi_shif']==1) echo 'checked';  ?> />&nbsp;&nbsp;&nbsp;
						<label>Flexi Shift</label>
						</div>
						
					</div>
					</div>
								 </div>
								
								<div class="col-sm-12 text-center" >
								  <hr/>
								   <button style="background-color:#942bad;" class="btn  btn-primary" id="trial_setting" type="button">submit</button>
								</div>
											
											
										</div>
									    
									   
									</div>
	                            </div>
								<hr/>
								 
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>

			<footer class="footer">
				<div class="container-fluid">
					<p class="copyright pull-right">
						&copy; <script>document.write(new Date().getFullYear())</script> <a href="#">DESIGNED BY </a>Ubitech Solutions Pvt. Ltd.
					</p>
				</div>
			</footer>
		</div>
	</div>



</body>

	
	<script type="text/javascript">
	$('#trial_setting').click(function(){
		var days = $('#days').val();
		var user = $('#user').val();
		
		var attendanceaddon = 0;
		var locationtracking =0;
		var visitpunch = 0;
		var geofence = 0;
		var payroll = 0;
		var timeoff = 0;
		var flexishift = 0;
		
		
		
		if($('#attendanceaddon').is(":checked"))
		var attendanceaddon = 1;
	    
		if($('#locationtracking').is(":checked"))
		var locationtracking = 1;
	
	    if($('#visitpunch').is(":checked"))
		var visitpunch = 1;
	     
		 if($('#geofence').is(":checked"))
		var geofence = 1;
	
	    if($('#payroll').is(":checked"))
		var payroll = 1;
	    
		if($('#timeoff').is(":checked"))
		var timeoff = 1;
		
		if($('#flexishift').is(":checked"))
		var flexishift = 1;
	
		$.ajax({url: "<?php echo URL;?>/ubitech/trial_days",
        data: {'days':days,'user':user,'attendanceaddon':attendanceaddon,'locationtracking':locationtracking,'visitpunch':visitpunch,'geofence':geofence,'payroll':payroll,'timeoff':timeoff,'flexishift':flexishift},
		success: function(result){
			
	   if(result == 1){
			  doNotify('top','center',2,'Trial updated successfully.');
			   setTimeout(location.reload.bind(location), 2000);
		  }else{
			  doNotify('top','center',4,'some error occurs.');
			   setTimeout(location.reload.bind(location), 2000);
			  
		  }
		  
    }});
	})
	
	/*$('#user_limit').click(function(){
		var user = $('#user').val();
		$.ajax({url: "<?php echo URL;?>/ubitech/trial_users",
        data: {'user':user},
		success: function(result){
	   if(result == 'true'){
			  doNotify('top','center',2,'user limit updated successfully.');
			   setTimeout(location.reload.bind(location), 2000);
		  }else{
			  doNotify('top','center',4,'some error occurs.');
			   setTimeout(location.reload.bind(location), 2000);
			  alert('false');
		  }
		  
    }});
	})*/
	
	/*
	$('#info').click(function(){
	$.ajax({url: "<?php echo URL ?>/ubitech/info",
    //data: {'pname':pname,'puname':puname,' ':pemail},
	success: function(result){
         if(result == 1){
		  alert();
		  }else{
			  
			  alert('false');
		  }  
    }});
})*/
/* $(function(){
   $('#info').on('click',function(){  
      $('#orinfo').show();
   });
}); */
	</script>
	
</html>
