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
			$data['pageid']=8;
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
	                                <h4 class="title">Plans</h4>
	                                <p class="category">Plan Setting</p>
									
									<div class="nav-tabs-wrapper">
										<h6 class="nav-tabs-title">
											
											<button class="btn btn-sm btn-primary" id="path"  data-background-color="purple" type="button" style="float: right;margin-top: -20px;" >	
														Edit
													<div class="ripple-container"></div></button>
											<button style="display:none;float: right;margin-top: -20px;" data-background-color="purple" class="btn btn-sm btn-primary"  id="Edit_path" type="button" >Done</button>
											</h6>
											
										</div>
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
								<div class="col-md-4">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>Package Name </b></label>
								  <input class="form-control input-sm" id="packagename" value="<?php if($p['packagename'] != ""){ echo $p['packagename']; }?>" type="text" readonly >
								</div>
								
								</div>
								<div class="col-md-4">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>Modules</b></label>
								  <input class="form-control input-sm" id="modules" value="<?php if($p['modules'] != ""){ echo $p['modules']; }?>" type="text" readonly >
								</div>
								
								</div>
								<div class="col-md-4">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>Basic general setup price(INR) </b></label>
								  <input class="form-control input-sm" id="baseinr" value="<?php if($p['baseinr'] != ""){ echo $p['baseinr']; }?>" type="text" readonly >
								</div>
								
								</div>
								
								</div>
								<div class="row">
								<div class="col-md-4">
								<div class="form-group">
								 <label for="inputsm" style="color:black;"> <b>Basic general setup price(USD) </b></label>
								  <input class="form-control input-sm" id="basedollar" value="<?php if($p['basedollar'] != ""){ echo $p['basedollar']; }?>" type="text" readonly >
								</div>
								</div>
								<div class="col-md-4">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>Price for one user per for one month(inr)</b></label>
								  <input class="form-control input-sm" id="priceperuserpermonthinr" value="<?php if($p['priceperuserpermonthinr'] != ""){ echo $p['priceperuserpermonthinr']; }?>" type="text" readonly >
								</div>
								
								</div>
								
								<div class="col-md-4">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>Price for one user per for one month(USD) </b></label>
								  <input class="form-control input-sm" id="priceperuserpermonthdollar" value="<?php if($p['priceperuserpermonthdollar'] != ""){ echo $p['priceperuserpermonthdollar']; }?>" type="text" readonly >
								</div>
								
								</div>
								</div>
								
								 <div class="row">
								<div class="col-md-4">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>Discount INR/Year. </b></label>
								  <input class="form-control input-sm" id="disinrupeeforinr" value="<?php if($p['disinrupeeforinr'] != ""){ echo $p['disinrupeeforinr']; }?>" type="text" readonly >
								</div>
								
								</div>
								<div class="col-md-4">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>Discount USD/Year. </b></label>
								  <input class="form-control input-sm" id="disindollarfordollar" value="<?php if($p['disindollarfordollar'] != ""){ echo $p['disindollarfordollar']; }?>" type="text" readonly >
								</div>
								
								</div>
								
								
								
								<div class="col-md-4">
								<div class="form-group">
								 <label for="inputsm" style="color:black;"> <b>Discount(INR) %/Year.</b></label>
								  <input class="form-control input-sm" id="disinperforinr" value="<?php if($p['disinperforinr'] != ""){ echo $p['disinperforinr']; }?>" type="text" readonly >
								</div>
								</div>
								
								</div>
								
								  <div class="row">
								<div class="col-md-4">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>Discount (USD)%/Year. </b></label>
								  <input class="form-control input-sm" id="disinperfordollar" value="<?php if($p['disinperfordollar'] != ""){ echo $p['disinperfordollar']; }?>" type="text" readonly >
								</div>
								
								</div>
								<div class="col-md-4">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>Discount of free no. of months in terms of yearly plan (INR)</b></label>
								  <input class="form-control input-sm" id="disinmonthforyearlyinr" value="<?php if($p['disinmonthforyearlyinr'] != ""){ echo $p['disinmonthforyearlyinr']; }?>" type="text" readonly >
								</div>
								
								</div>
								
								
								
								<div class="col-md-4">
								<div class="form-group">
								 <label for="inputsm" style="color:black;"> <b>Discount of free no. of months in terms of yearly plan in(USD)</b></label>
								  <input class="form-control input-sm" id="disinmonthforyearlydollar" value="<?php if($p['disinmonthforyearlydollar'] != ""){ echo $p['disinmonthforyearlydollar']; }?>" type="text" readonly >
								</div>
								</div>
								
								</div>
								 <div class="row">
								<!--<div class="col-md-4">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>archive</b></label>
								  <input class="form-control input-sm" id="archive" value="<?php if($p['archive'] != ""){ echo $p['archive']; }?>" type="text" readonly >
								</div>
								
								</div>-->
								<div class="col-md-4">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>App login</b></label>
								  <input class="form-control input-sm" id="applogin" value="<?php if($p['applogin'] != ""){ echo $p['applogin']; }?>" type="text" readonly >
								</div>
								
								</div>
								
								
								
								<div class="col-md-4">
								<div class="form-group">
								 <label for="inputsm" style="color:black;"> <b>Admin login</b></label>
								  <input class="form-control input-sm" id="adminlogin" value="<?php if($p['adminlogin'] != ""){ echo $p['adminlogin']; }?>" type="text" readonly >
								</div>
								</div>
								
								<div class="col-md-4">
								<div class="form-group">
								 <label for="inputsm" style="color:black;"> <b>Modified date</b></label>
								  <input class="form-control input-sm" id="modified_date" value="<?php if($p['modified_date'] != ""){ echo $p['modified_date']; }?>" type="text" readonly >
								</div>
								</div>
								
								</div>
								<div class="row">
								<div class="col-md-4">
								<div class="form-group">
								 <label for="inputsm" style="color:black;"> <b>Addon user price in INR per user per month</b></label>
								  <input class="form-control input-sm" id="addonuseerpminr" value="<?php if($p['addonuseerpminr'] != ""){ echo $p['addonuseerpminr']; }?>" type="text" readonly >
								</div>
								</div>
								
								<div class="col-md-4">
								<div class="form-group">
								 <label for="inputsm" style="color:black;"> <b>Addon user price in usd per user per month</b></label>
								  <input class="form-control input-sm" id="addonuseerpmusd" value="<?php if($p['addonuseerpmusd'] != ""){ echo $p['addonuseerpmusd']; }?>" type="text" readonly >
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
	document.getElementById('packagename').removeAttribute('readonly');
	document.getElementById('modules').removeAttribute('readonly');
	document.getElementById('baseinr').removeAttribute('readonly');
	document.getElementById('basedollar').removeAttribute('readonly');
	document.getElementById('priceperuserpermonthinr').removeAttribute('readonly');
	document.getElementById('priceperuserpermonthdollar').removeAttribute('readonly');
	document.getElementById('disinrupeeforinr').removeAttribute('readonly');
	document.getElementById('disindollarfordollar').removeAttribute('readonly');
	document.getElementById('disinperforinr').removeAttribute('readonly');
	document.getElementById('disinperfordollar').removeAttribute('readonly');
	document.getElementById('disinmonthforyearlyinr').removeAttribute('readonly');
	document.getElementById('disinmonthforyearlydollar').removeAttribute('readonly');
	document.getElementById('applogin').removeAttribute('readonly');
	document.getElementById('adminlogin').removeAttribute('readonly');
	document.getElementById('modified_date').removeAttribute('readonly');
	document.getElementById('addonuseerpminr').removeAttribute('readonly');
	document.getElementById('addonuseerpmusd').removeAttribute('readonly');
	
	
	$('#Edit_path').show();
	$('#path').hide();
	
})

$('#Edit_path').click(function(){
	var packagename = $('#packagename').val();
	var modules = $('#modules').val();
	var baseinr = $('#baseinr').val();
	var basedollar = $('#basedollar').val();
	
	var priceperuserpermonthinr = $('#priceperuserpermonthinr').val();
	var priceperuserpermonthdollar = $('#priceperuserpermonthdollar').val();
	var disinrupeeforinr = $('#disinrupeeforinr').val();
	var disindollarfordollar = $('#disindollarfordollar').val();
	
	var disinperforinr = $('#disinperforinr').val();
	var disinperfordollar = $('#disinperfordollar').val();
	var disinmonthforyearlyinr = $('#disinmonthforyearlyinr').val();
	var disinmonthforyearlydollar = $('#disinmonthforyearlydollar').val();
	
	var applogin = $('#applogin').val();
	var adminlogin = $('#adminlogin').val();
	var modified_date = $('#modified_date').val();
	
	var addonuseerpminr = $('#addonuseerpminr').val();
	var addonuseerpmusd = $('#addonuseerpmusd').val();
	
   $.ajax({url: "<?php echo URL ?>/ubitech/updatePackge1",
    data: {'packagename':packagename,
	'modules':modules,
	'baseinr':baseinr,
	'basedollar':basedollar,
	
	'priceperuserpermonthinr':priceperuserpermonthinr,
	'priceperuserpermonthdollar':priceperuserpermonthdollar,
	'disinrupeeforinr':disinrupeeforinr,
	'disindollarfordollar':disindollarfordollar,
	
	'disinperforinr':disinperforinr,
	'disinperfordollar':disinperfordollar,
	'disinmonthforyearlyinr':disinmonthforyearlyinr,
	'disinmonthforyearlydollar':disinmonthforyearlydollar,
	
	'applogin':applogin,
	'adminlogin':adminlogin,
	'modified_date':modified_date,
	'addonuseerpminr':addonuseerpminr,
	'addonuseerpmusd':addonuseerpmusd},
	success: function(result){
        if(result == 1){
		  doNotify('top','center',2,'Package updated successfully.');
			   setTimeout(location.reload.bind(location), 1000);
		  }else{
			  doNotify('top','center',4,'some error occurs.');
			  setTimeout(location.reload.bind(location), 2000);
			 // alert('false');
		  }
    }});
}) 
	</script>
	
</html>
