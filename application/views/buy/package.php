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
						<?php if($this->session->flashdata('success') == 'Organization registered successfully'){ 
	                     ?><script>
							doNotify('top','center',2,'Organization registered successfully.');
						 </script>
							
                        <?php 
						}if($this->session->flashdata('success') == 'Organization updated successfully'){ ?>
						  <script>
							doNotify('top','center',2,'Organization updated successfully.');
						 </script>
						<?php }
						if($this->session->flashdata('error')){ ?>
						<script>
							doNotify('top','center',2,'Email id is already exists.');
						 </script>
						<?php
						}
						 ?>
					   	<!-- this message for success or error end-->
	                        <div class="card">
	                            <div class="card-header" data-background-color="green">
	                                <h4 class="title">Packages</h4>
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
													<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addSld" type="button">	
														<i class="fa fa-plus">Add</i>
													</button>
												</div>
											</div>
										</div>
										<div class="row">
											<table id="example" class="display table" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th width="15%">Id</th>
													<th>Name</th>
													<th>Modules</th>
													<th>Package Price In INR(year)</th>
													<th>Package Price In USD(year)</th>
													<th>User Limit</th>
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
						&copy; <script>document.write(new Date().getFullYear())</script> <a href="#">Ubitech Pvt. Ltd.</a>, Connecting dots...
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
				<div class="col-md-12">
					
					<div class="form-group label-floating">
						<label class="control-label">Package Name <span class="red"> *</span></label>
						<input type="text" id="package_namepackage_name" name="org_name" class="form-control" >
					</div>
					<div class="form-group label-floating">
						<label class="control-label">Package Module<span class="red"> *</span></label>
						<input type="text" id="package_modules" name="package_modules" class="form-control" >
					</div>
					 
					<div class="form-group label-floating">
						<label class="control-label">Package Price In INR(year)<span class="red"> *</span></label>
						<input type="text" id="package_price_inr_yr" name="package_price_inr_yr" class="form-control" >
					</div>
					<div class="form-group label-floating">
						<label class="control-label">Package Price In USD(year)</label>
						<input type="number" id="package_price_usd_yr" name="package_price_usd_yr" class="form-control">
					</div>
					<div class="form-group label-floating">
						<label class="control-label">User Limit</label>
						<input type="number" id="package_user_limit" name="package_user_limit" class="form-control">
					</div>
					 <!--<div class="form-group label-floating">
						<label class="control-label">Address</label>
						<textarea id="Address" name="Address" class="form-control"></textarea>
					</div> -->
				</div>
			</div>
			
			<div class="clearfix"></div>
		</form>
		
		
		
      </div>
      <div class="modal-footer">
        <button type="button" id="save"  class="btn btn-success" >Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	
    </div>
  </div>
</div>
<!---modal close--->

<!------Edit slider modal start------------>
<div id="addSldE" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
	
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Edit Package</h4>
      </div>
      <div class="modal-body">
		<form id="deptFromE"   action="<?php echo URL;?>ubitech/editOrganizationData" >
		<input type="text" class="hidden" id="edit_id" name="edit_id" />
			
		<div class="row">
				<div class="col-md-12">
					
					<div class="form-group label-floating">
						<label class="control-label">Package Name <span class="red"> *</span></label>
						<input type="text" id="org_nameE" name="org_nameE" class="form-control" >
					</div>
					<div class="form-group label-floating">
						<label class="control-label">Contact Person Name<span class="red"> *</span></label>
						<input type="text" id="nameE" name="nameE" class="form-control" >
					</div>
					 
					<div class="form-group label-floating">
						<label class="control-label">Email<span class="red"> *</span></label>
						<input type="email" id="emailE" name="emailE" class="form-control" >
					</div>
					<div class="form-group label-floating">
						<label class="control-label">Phone</label>
						<input type="number" id="phoneE" name="phoneE" class="form-control">
					</div>
					<div class="form-group label-floating">
						<select id="countryE" name="countryE" class="form-control" >
						       <option value="0" >Country</option>
						    <?php foreach ($h->result() as $row){ ?>
		                       <option value="<?php echo $row->Id;?>" ><?php echo $row->Name;?></option>
                            <?php } ?> 
						</select>
					</div>
					<div class="form-group label-floating">
						<label class="control-label">Address</label>
						<textarea id="AddressE" name="AddressE" class="form-control"></textarea>
					</div>
				</div>
			</div>
			<input type="hidden" id="editE_id" name="editE_id" />
			
			<div class="clearfix"></div>
		</form>
		
		
		
      </div>
      <div class="modal-footer">
        <button type="button" id="saveE"  class="btn btn-success" >Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
		$(function(){
			 table=$('#example').DataTable( {
						"scrollX": true,
						"contentType": "application/json",
						"ajax": "<?php echo URL;?>ubitech/getPackageData",
						"columns": [
							{ "data": "package_id" },
							{ "data": "package_name" },
							{ "data": "package_modules"},
							{ "data": "package_price_inr_yr" },
							{ "data": "package_price_usd_yr"},
							{ "data": "package_user_limit"}
						]
					});
					
			$(document).on("click", ".edit", function () {
				$('#editE_id').val($(this).data('id'));
				$('#org_nameE').val($(this).data('orgname'));
				$('#countryE').val($(this).data('country'));
				$('#emailE').val($(this).data('email'));	
				$('#phoneE').val($(this).data('phonenumber'));	
				$('#AddressE').val($(this).data('address'));  				
				$('#nameE').val($(this).data('name'));  				
			});
			
			$('#saveE').click(function(){
				// var org_nameE =  $("#org_nameE").val();
                // var countryE =  $("#countryE").val();
                // var emailE =  $("#emailE").val();
                // var phoneE =  $("#phoneE").val();
                // var AddressE =  $("#AddressE").val();
                // var nameE =  $("#nameE").val();
				// alert(org_nameE+" "+countryE+" "+emailE+" "+phoneE+" "+AddressE+" "+nameE);
				// return false;
			    $("#deptFromE").submit(); 
			});
			
		});
		
    	$(document).ready(function(){
		$("#save").click(function(){
			var package_name =  $("#package_name").val();
            var package_modules =  $("#package_modules").val();
            var package_price_inr_yr =  $("#package_price_inr_yr").val();
            var package_price_usd_yr =  $("#package_price_usd_yr").val();
            var package_user_limit =  $("#package_user_limit").val();
           
			if(package_name == ""){
				doNotify('top','center',4,'Please enter Package name.');
				return false;
			}
			if(package_modules == ""){
				doNotify('top','center',4,'Please enter package modules.');
				return false;
			}
			if(package_price_inr_yr == ""){
				doNotify('top','center',4,'Please enter package price inr yr.');
				return false;
			}
			if(package_price_usd_yr == ""){
				doNotify('top','center',4,'Please enter package price usd yr.');
				return false;
			}
			if(package_user_limit == 0){
				doNotify('top','center',4,'Please select package user limit.');
				return false;
			}
			
			$("#deptFrom").submit();
		});
    	});
		
		
		
		<!-- for alert message (start) -->
		 $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
         $("#success-alert").slideUp(500);
        });
		<!-- alert message (end)-->
			
			
			
			
	</script>

</html>
