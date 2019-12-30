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
			$data['pageid']=3;
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
	                            <div class="card-header" data-background-color="purple">
	                                <h4 class="title">Organization</h4>
	                                <p class="category">Organization Settings</p>
	                            </div>
	                            <div class="card-content">
									<div id="typography">
										<div class="title">
											<div class="row">
												<div class="col-md-8">
													<h3>Organization</h3>
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
													<th width="15%">Organization</th>
													<th>Register on</th>
													<th>Subscription start date</th>
													<th>Subscribe upto</th>
													<th>Ref_no</th>
													<th>Country</th>
													<th>Email</th>
													<th>Consulting Name</th>
												    <th>PhoneNumber</th>
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
        <h4 class="modal-title" id="title">Add Organization</h4>
      </div>
      <div class="modal-body">
		<form id="deptFrom" action="<?php echo URL;?>ubitech/registerOrganization"  >
			<div class="row">
				<div class="col-md-12">
					
					<div class="form-group label-floating">
						<label class="control-label">Organization Name <span class="red"> *</span></label>
						<input type="text" id="org_name" name="org_name" class="form-control" >
					</div>
					<div class="form-group label-floating">
						<label class="control-label">Contact Person Name<span class="red"> *</span></label>
						<input type="text" id="name" name="name" class="form-control" >
					</div>
					 
					<div class="form-group label-floating">
						<label class="control-label">Email<span class="red"> *</span></label>
						<input type="email" id="email" name="email" class="form-control" >
					</div>
					<div class="form-group label-floating">
						<label class="control-label">Phone</label>
						<input type="number" id="phone" name="phone" class="form-control">
					</div>
					<div class="form-group label-floating">
						<select id="country" name="country" class="form-control" >
						       <option value="0" >Country</option>
						    <?php foreach ($h->result() as $row){ ?>
		                       <option value="<?php echo $row->Id;?>" ><?php echo $row->Name;?></option>
                            <?php } ?> 
						</select>
					</div>
					<div class="form-group label-floating">
						<label class="control-label">Address</label>
						<textarea id="Address" name="Address" class="form-control"></textarea>
					</div>
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
        <h4 class="modal-title" id="title">Edit Organization</h4>
      </div>
      <div class="modal-body">
		<form id="deptFromE"   action="<?php echo URL;?>ubitech/editOrganizationData" >
		<input type="text" class="hidden" id="edit_id" name="edit_id" />
			
		<div class="row">
				<div class="col-md-12">
					
					<div class="form-group label-floating">
						<label class="control-label">Organization Name <span class="red"> *</span></label>
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
						"order": [[ 1, "desc" ]],
						"ajax": "<?php echo URL;?>ubitech/getOrganizationData",
						"columns": [
							{ "data": "orgName"},
							{ "data": "rdate"},
							{ "data": "sdate"},
							{ "data": "edate"},
							{ "data": "ref_no" },
							{ "data": "country"},
							{ "data": "email" },
							{ "data": "c_nmae" },
                          //{ "data": "pass" },
							{ "data": "PhoneNumber"},
							{ "data": "action"}
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
			var org_name =  $("#org_name").val();
            var con_per_name =  $("#name").val();
            var org_email =  $("#email").val();
            var phone =  $("#phone").val();
            var country =  $("#country").val();
            var address =  $("#Address").val();
			if(org_name == ""){
				doNotify('top','center',4,'Please enter organization name.');
				return false;
			}
			if(con_per_name == ""){
				doNotify('top','center',4,'Please enter contact person name.');
				return false;
			}
			if(org_email == ""){
				doNotify('top','center',4,'Please enter email.');
				return false;
			}
			if(phone == ""){
				doNotify('top','center',4,'Please enter phone.');
				return false;
			}
			if(country == 0){
				doNotify('top','center',4,'Please select country.');
				return false;
			}
			if(address == ""){
				doNotify('top','center',4,'Please enter address.');
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
