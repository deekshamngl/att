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
			$data['pageid']=121.4;
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
	                                <h4 class="title">Play Store</h4>
	                                <p class="category">Mobile App Path Setting (Google play store & App store)</p> <button class="btn btn-sm btn-primary" id="path"  data-background-color="purple" type="button" style="float: right;margin-top:-20px;" >	
														Edit
													<div class="ripple-container"></div></button>
											<button style="display:none;float: right;margin-top:-20px;" data-background-color="purple" class="btn btn-sm btn-primary"  id="Edit_path" type="button">Done</button>							
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
											<!--<input type="hidden" id="id" value="<?php $p['id'];?>" >-->
                       <div class="row">
								<div class="col-md-5">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>Google Play Store Path </b></label>
								  <input class="form-control input-sm" id="googlepath" value="<?php if($p['googlepath'] != ""){ echo $p['googlepath']; }?>" type="text" readonly >
								</div>
								</div>
								<div class="col-md-3">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>Android App Version</b></label>
								  <input class="form-control input-sm" id="androidversion" value="<?php if($p['androidversion'] != ""){ echo $p['androidversion']; }?>" type="text" readonly >
								</div>
								</div>
								
								<div class="col-md-2">
								<div class="form-group">
								 <label for="inputsm" style="color:black;font-size:11px;"><b>Update Status</b></label>
								  <input class="form-control" id="Popupstatus_android" value="1" <?php if($p['alert_popup_android']=="1"){echo "checked";} ?> type="checkbox" style="height: 15px; width: 15px;" disabled>
								</div>
								</div>
								
								<div class="col-md-2">
								<div class="form-group">
								 <label for="inputsm" style="color:black;font-size:11px;"><b>Mandatory Update</b></label>
								  <input class="form-control" id="checkbox1" value="1" <?php if($p['is_mandatory_android']=="1"){echo "checked";} ?> type="checkbox" style="height: 15px; width: 15px;" disabled>
								</div>
								</div>
								
								
								<div class="col-md-5">
								<div class="form-group">
								 <label for="inputsm" style="color:black;"> <b>App Store Path(Current)</b></label>
								  <input class="form-control input-sm" id="applepath" value="<?php if($p['applepath'] != ""){ echo $p['applepath']; }?>" type="text" readonly >
								</div>
								</div>
								
								<div class="col-md-3">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>IOS App Version(Current)</b></label>
								  <input class="form-control input-sm" id="iosversion" value="<?php if($p['iosversion'] != ""){ echo $p['iosversion']; }?>" type="text" readonly >
								</div>
								</div>
								
								<div class="col-md-2">
								<div class="form-group">
								 <label for="inputsm" style="color:black;font-size:11px"><b>Update Status</b></label>
								  <input class="form-control" id="Popupstatus_ios" value="1" <?php if($p['alert_popup_ios']=="1"){echo "checked";} ?> type="checkbox" style="height: 15px; width: 15px;" disabled>
								</div>
								</div>
								
								<div class="col-md-2">
								<div class="form-group">
								 <label for="inputsm" style="color:black;font-size:11px"><b>Mandatory Update</b></label>
								  <input class="form-control" id="checkbox2" value="1" <?php if($p['is_mandatory_ios']=="1"){echo "checked";} ?> type="checkbox" style="height: 15px; width: 15px;" disabled>
								</div>
								</div>
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
	
	
	$('#path').click(function(){
	document.getElementById('googlepath').removeAttribute('readonly');
	document.getElementById('applepath').removeAttribute('readonly');
	document.getElementById('androidversion').removeAttribute('readonly');
	document.getElementById('iosversion').removeAttribute('readonly');
	document.getElementById('checkbox1').removeAttribute('disabled');
	document.getElementById('checkbox2').removeAttribute('disabled');
	document.getElementById('Popupstatus_android').removeAttribute('disabled');
	document.getElementById('Popupstatus_ios').removeAttribute('disabled');
	
	$('#Edit_path').show();
	$('#path').hide();
	
})

$('#Edit_path').click(function(){
	
	var googlepath = $('#googlepath').val();
	var applepath = $('#applepath').val();
	var androidversion = $('#androidversion').val();
	var iosversion = $('#iosversion').val();
	var checkbox1 = $('#checkbox1:checked').val();
	var checkbox2 = $("#checkbox2:checked").val();
	var alert_popup_ios = $("#Popupstatus_ios:checked").val();
	var alert_popup_android = $("#Popupstatus_android:checked").val();

   $.ajax({url: "<?php echo URL ?>/ubitech/updatePath",
    data: {'googlepath':googlepath,'applepath':applepath,'iosversion':iosversion,'androidversion':androidversion,'checkbox1':checkbox1,'checkbox2':checkbox2,'alert_popup_ios':alert_popup_ios,'alert_popup_android':alert_popup_android},
	
	success:function(result)
	{
		
        if(result == 1)
		{
		  doNotify('top','center',2,'Path updated successfully.');
			   setTimeout(location.reload.bind(location), 1000);
		  }
		  else
		  {
			  doNotify('top','center',4,'some error occurs.');
			  
		  }
    }});
}) 
	</script>
	
</html>
