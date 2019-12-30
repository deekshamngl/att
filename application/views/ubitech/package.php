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
			$data['pageid']=5;
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
						<!-- this message for success or error start-->
						<?php if($this->session->flashdata('success') == 'Package registered successfully'){ 
	                     ?><script>
							doNotify('top','center',2,'Package registered successfully.');
						 </script>
							
                        <?php 
						}if($this->session->flashdata('success') == 'Package updated successfully'){ ?>
						  <script>
							doNotify('top','center',2,'Package updated successfully.');
						 </script>
						<?php }
						if($this->session->flashdata('error')){ ?>
						<script>
							doNotify('top','center',2,'Package id is already exists.');
						 </script>
						<?php
						}
						 ?>
					   	<!-- this message for success or error end-->
	                        <div class="card">
	                            <div class="card-header" data-background-color="purple">
	                                <h4 class="title">Plans</h4>
	                                <p class="category">Package Setting</p>
	                            </div>
	                            <div class="card-content">
									<div id="typography">
										<div class="title">
											<div class="row">
												<div class="col-md-8">
													<h3>Packages</h3>
												</div>
												<div class="col-md-4 text-right">
													<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addSld" type="button">	
														<i class="fa fa-plus">Add</i>
													</button>
												</div>
											</div>
										</div>
										<div class="row">
											<table id="example" class="display table" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th width="15%">Name</th>
													<th>Base Price(INR)/Yr</th>
													<th>Base Price(USD)/Yr</th>
													<th>Per User(INR)/Yr</th>
													<th>Per User(USD)/Yr</th>
													<th>Discount in(%)</th>
													<th>User Limit(default)</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</thead>
										</table>
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
<!-- Modal open add sld img-->
<div id="addSld" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
	
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Add Package</h4>
      </div>
      <div class="modal-body">
		<form id="deptFrom" action="<?php echo URL;?>ubitech/registerPackage"  >
		
		
					<div class="row">
					<div class="col-sm-9">
					<label class="control-label">Package Name <span class="red"> *</span></label>
						<input type="text" id="packagenameA" name="packagenameA" class="form-control" >
						
					</div>
					<div class="col-sm-3">
						<label class="control-label">Discount in % <span class="red"> *</span></label>
						
						<input type="number"  min="0" max="100" value="0" id="discountA" name="discountA" class="form-control" >
					<!--	<span><small>0 if not applocable</small></span>-->
					</div>
					<div class="col-sm-6">
						<label class="control-label">Base Price INR/Yr<span class="red"> *</span></label>
						<input type="number" id="inrA" name="inrA" class="form-control" >
					</div>
					<div class="col-sm-6">
						<label class="control-label">Base Price USD/Yr<span class="red"> *</span> </label>
						
						<input type="number" id="usdA" name="usdA" class="form-control" >
						
					</div>
					<div class="col-sm-6">
						<label class="control-label">Per User Charges(INR) / 365 days<span class="red"> *</span></label>
						<input type="number" id="inrperuserA" name="inrperuserA" class="form-control" >
					</div>
					<div class="col-sm-6">
						<label class="control-label">Per User Charges(USD) / 365 days<span class="red"> *</span> </label>
						
						<input type="number" id="usdperuserA" name="usdperuserA" class="form-control" >
						
					</div>
					
					</div>
				
					
				<div class="row">
				
					<div class="col-sm-6">
					    <label class="control-label">Default User Limit<span class="red"> *</span></label>
						<input type="number" id="userA" name="userA" class="form-control" >
					</div>
					<div class="col-sm-6">
					    <label class="control-label">Status<span class="red"> *</span></label>
						<!--<input type="text" id="sts" name="sts" class="form-control" >-->
						<select class="form-control" id="stsA" name="stsA">
							<option value='1'>Active</option>
							<option value='0'>Inactive</option>
						</select>
					</div>
	                  </div>
				<div class="modal-footer">
        <button type="button" id="save"  class="btn btn-success" >Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
			
			
			<div class="clearfix"></div>
			
		</form>
	</div>
      
	
    </div>
  </div>
</div>
<!---modal close--->

<!------Edit slider modal start------------>
<div id="PackageE" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
	
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Edit Package</h4>
      </div>
      <div class="modal-body">	
<form id="deptFromU"   action="<?php echo URL;?>ubitech/updatePackageData" >
		<input type="text" class="hidden" id="edit_id" name="edit_id" />
				
					<div class="row">
					<div class="col-sm-9">
					<label class="control-label">Package Name <span class="red"> *</span></label>
						<input type="text" id="packagename" name="packagename" class="form-control" >
						
					</div>
					<div class="col-sm-3">
						<label class="control-label">Discount in % <span class="red"> *</span></label>
						
						<input type="number"  min="0" max="100" value="0" id="discount" name="discount" class="form-control" >
					<!--	<span><small>0 if not applocable</small></span>-->
					</div>
					<div class="col-sm-6">
						<label class="control-label">Base Price INR/Yr<span class="red"> *</span></label>
						<input type="number" id="inr" name="inr" class="form-control" >
					</div>
					<div class="col-sm-6">
						<label class="control-label">Base Price USD/Yr<span class="red"> *</span> </label>
						
						<input type="number" id="usd" name="usd" class="form-control" >
						
					</div>
					</div>
				
					
				
					<div class="col-sm-6">
						<label class="control-label">Per User Charges(INR) / 365 days<span class="red"> *</span></label>
						<input type="number" id="inrperuser" name="inrperuser" class="form-control" >
					</div>
					<div class="col-sm-6">
						<label class="control-label">Per User Charges(USD) / 365 days<span class="red"> *</span> </label>
						
						<input type="number" id="usdperuser" name="usdperuser" class="form-control" >
						
					</div>
			
				
				
					<div class="col-sm-6">
					    <label class="control-label">Default User Limit<span class="red"> *</span></label>
						<input type="number" id="user" name="user" class="form-control" >
					</div>
					<div class="col-sm-6">
					    <label class="control-label">Status<span class="red"> *</span></label>
						<!--<input type="text" id="sts" name="sts" class="form-control" >-->
						<select class="form-control" id="sts" name="sts">
							<option value='1'>Active</option>
							<option value='0'>Inactive</option>
						</select>
					</div>
	                  
					
					 <div class="modal-footer">
        <button type="button" id="saveE"  class="btn btn-success">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
				</div>
		<div class="clearfix"></div>
		</form>
	 </div>
     
	
    </div>
  </div>
</div>
<!------Edit slider modal close------------>
<!-----delete sld start--->
<div id="delSld" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Delete Attendance</h4>
      </div>
      <div class="modal-body">		
		<form>
			<input type="hidden" id="del_aid" />
			<input type="hidden" id="del_image" />
			<div class="row">
				<div class="col-md-12">
					<h4>Are you sure want to delete Image  ?</h4>
				</div>
			</div>
			<div class="clearfix"></div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="delete"  class="btn btn-warning">Delete</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-----delete sld close--->
</body>

	

	<script type="text/javascript">
			
	    var table;
		table=$('#example').DataTable( {
						"scrollX": true,
						"contentType": "application/json",
						"ajax": "<?php echo URL;?>ubitech/getPackageData",
						"columns": [
							
							{ "data": "name" },
							{ "data": "inr" },
							{ "data": "usd" },
							{ "data": "inrperuser" },
							{ "data": "usdperuser" },
							{ "data": "discount" },
							{ "data": "user" },
							{ "data": "sts" },
							{ "data": "action"}
						]
					});
		$(document).on("click", ".edit", function () { 
				$('#edit_id').val($(this).data('id'));
				$('#packagename').val($(this).data('name'));
				$('#discount').val($(this).data('discount'));
				$('#inr').val($(this).data('inr'));
				$('#usd').val($(this).data('usd'));
				$('#inrperuser').val($(this).data('userinr'));
				$('#usdperuser').val($(this).data('userusd'));
				$('#user').val($(this).data('user'));
				$('#sts').val($(this).data('sts'));
					});			
		/* $('#update_package').click(function(){
			//alert();addSld
			$("#deptFromU").submit();
		}) */
		 
		
    	$(document).ready(function(){
		$("#save").click(function(){
			var nameA =  $("#packagenameA").val();
            var discountA =  $("#discountA").val();
            var inrA =  $("#inrA").val();
            var usdA =  $("#usdA").val();
			var inrperuserA =  $("#inrperuserA").val();
            var usdperuserA =  $("#usdperuserA").val();
            var userA =  $("#userA").val();
		    var stsA =  $("#stsA").val();
           
			if(nameA == ""){
				doNotify('top','center',4,'Please enter Package name.');
				return false;
			}
			if(discountA == ""){
				doNotify('top','center',4,'Please enter package discount.');
				return false;
			}
			if(inrA == ""){
				doNotify('top','center',4,'Please enter package price inr yr.');
				return false;
			}
			if(usdA == ""){
				doNotify('top','center',4,'Please enter package price usd yr.');
				return false;
			}
			if(inrperuserA == ""){
				doNotify('top','center',4,'Please enter per user per 365 days price in INR.');
				return false;
			}
			if(usdperuserA == ""){
				doNotify('top','center',4,'Please enter per user per 365 days price in USD');
				return false;
			}
			if(userA == 0){
				doNotify('top','center',4,'Please enter package user limit.');
				return false;
			}
			if(stsA == ""){
				doNotify('top','center',4,'Please eneter status.');
				return false;
			}
			
			
			$("#deptFrom").submit();
		});
    	});
		
			
    	$(document).ready(function(){
		$("#saveE").click(function(){
			var name =  $("#packagename").val();
            var discount = $("#discount").val();
            var inr =  $("#inr").val();
            var usd =  $("#usd").val();
            var inrperuser =  $("#inrperuser").val();
            var usdperuser =  $("#usdperuser").val();
            var user =  $("#user").val();
			var sts =  $("#sts").val();
           
			if(name == ""){
				doNotify('top','center',4,'Please enter Package name.');
				return false;
			}
			if(discount == ""){
				doNotify('top','center',4,'Please enter discount %.');
				return false;
			}
			if(inr == ""){
				doNotify('top','center',4,'Please enter package price inr per yr.');
				return false;
			}
			if(usd == ""){
				doNotify('top','center',4,'Please enter package price usd per yr.');
				return false;
			}
			if(inrperuser == ""){
				doNotify('top','center',4,'Please enter per user price INR per 365 days.');
				return false;
			}
			if(usdperuser == ""){
				doNotify('top','center',4,'Please enter per user price USD per 365 days.');
				return false;
			}
			
			if(user == 0){
				doNotify('top','center',4,'Please enter package user limit (min 1).');
				return false;
			}
			$("#deptFromU").submit();
		});
    	});
		
		
		<!-- for alert message (start) -->
		 $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
         $("#success-alert").slideUp(500);
        });
		<!-- alert message (end)-->
			
	
			
			
	</script>

</html>
