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
			$data['pageid']=7;
			$this->load->view('ubitech/sidebar',$data);
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
	                                <h4 class="title">Trial</h4>
	                                <p class="category">Trial Settings</p>
	                            </div>
	                            <div class="card-content">
									<div id="typography">
										<!--<div class="title">
											<div class="row">
												<div class="col-md-8">
													<h3>Organization</h3>
												</div>
												<div class="col-md-4 text-right">
													<button data-background-color="purple" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addSld" type="button">	
														<i class="fa fa-edit">&nbsp;Edit</i>
													</button>
												</div>
											</div>
										</div><br><br>-->	
  
									    <div class="row">
											<div class="col-sm-12" align="center" >
											  <b>Trial Days
											  
											  </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="number" id="days" value="<?php if($h != ""){ echo $h; } ?>" />
											
											 <button style="background-color:#942bad;" class="btn btn-sm btn-primary" id="trial_setting" type="button">submit</button>
											</div>											
										</div>
									  
									    
									  
											 <button style="background-color:#942bad;" class="btn btn-sm btn-primary" id="info" type="button">Info</button>
									 
									  
									  
									 

										
									</div>
									
									
									 
									  <div class="panel panel-default">
										<div class="panel-heading card-header" style="background-color:teal; color:white;" >Organizations</div>
										<div class="panel-body" align="center" style="overflow-x:auto;" > 
						<div class="row">
								<div class="col-md-3">
									<div class="form-group"><label for="inputsm">Name</label>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="inputsm">Trial Day</label>
										
									</div>
										</div>
										<div class="col-md-3">
									<div class="form-group">
										<label for="inputsm">Remaining Day</label>
									</div>
										</div>
									</div>
									
									<div class="row" id="oinfo">
								<div class="col-md-3">
									<div class="form-group" id="name"><?php if($i['name'] != ""){ echo $i['name']; }?></label>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="inputsm">Trial Day</label>
										
									</div>
										</div>
										<div class="col-md-3">
									<div class="form-group">
										<label for="inputsm">Remaining Day</label>
									</div>
										</div>
									</div>
								</div>
											<!--<input type="radio" name="r1" id="r1" value="0"/><b>&nbsp;&nbsp;&nbsp;Trial</b>
											
									
											
											<div id="trial_date" style="display:none;"  >
											<b>Till Date </b><input type="date" name="till_date" id="till_date" value="" checked="checked" />
											<input type="hidden" value="" id="extended_data"/>
											</br>
											<button style="background-color:teal;" class="btn btn-sm btn-primary" id="trail" type="button">	
											Submit
											</button>
											</div>-->
											
										
										 
									
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
		$.ajax({url: "<?php echo URL;?>/ubitech/trial_days",
        data: {'days':days},
		success: function(result){
	   if(result == 'true'){
			  doNotify('top','center',2,'days updated successfully.');
			   setTimeout(location.reload.bind(location), 2000);
		  }else{
			  doNotify('top','center',4,'some error occurs.');
			   setTimeout(location.reload.bind(location), 2000);
			  alert('false');
		  }
		  
    }});
	})
	
	
	$('#info').click(function(){
	
	
	$.ajax({url: "<?php echo URL ?>/ubitech/info",
    //data: {'pname':pname,'puname':puname,'pemail':pemail},
	success: function(result){
        /* if(result == 1){
		  doNotify('top','center',2,'Profile updated successfully.');
			   setTimeout(location.reload.bind(location), 1000);
		  }else{
			  doNotify('top','center',4,'some error occurs.');
			  setTimeout(location.reload.bind(location), 2000);
			  alert('false');
		  } */
    }});
})
	</script>
	
</html>
