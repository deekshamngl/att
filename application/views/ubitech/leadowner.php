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
			$data['pageid']=121.5;
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
						<?php if($this->session->flashdata('success') == 'Data inserted successfully'){ 
	                     ?><script>
							doNotify('top','center',2,'Data Inserted successfully.');
						 </script>
							
                        <?php unset($_SESSION['success']);
						}if($this->session->flashdata('success') == 'Data Updated successfully'){ ?>
						<script>
							doNotify('top','center',2,'Data Updated successfully.');
						 </script>
						<?php
						}
						if($result = $this->session->flashdata('error')){ 
	                     ?>
							<script>
							doNotify('top','center',4,'Some error occurs.');
						 </script>
                        <?php } ?>
					   	<!-- this message for success or error end-->
	                        <div class="card">
	                            <div class="card-header" data-background-color="purple">
	                                <h4 class="title">Lead Owner</h4>
	                                <!--<p class="category">Banner Settings</p>-->
	                            </div>
	                            <div class="card-content">
									<div id="typography">
										<div class="title">
											<div class="row">
												<div class="col-md-8">
												<!--	<h3>Manage Slider</h3> --->
												</div>
												<div class="col-md-4 text-right">
													<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addLead" type="button">	
														<i class="fa fa-plus"> Add Lead Owner</i>
													</button>
												</div>
											</div>
										</div>
										<div class="row">
											<table id="example" class="display table" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>Lead Owner</th>
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
<div id="addLead" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
	
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Add Lead Owner</h4>
      </div>
      <div class="modal-body">
		<form id="leadfrom">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group  label-floating">
						<label class="control-label">Name <span class="red">*</span></label>
						<input type="text" id="name" name="name" class="form-control" autocomplete="off">
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
<div id="addLeadE" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
	
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Edit Lead Owner</h4>
      </div>
      <div class="modal-body">
		<form>
		<input type="text" class="hidden" id="editid" name="editid" />
			<div class="row">
				<div class="col-md-12">
					
					<div class=" label-floating1">
						<label class="control-label">Name <span class="red"> *</span></label>
						<input type="text" id="nameE" name="nameE" class="form-control" >
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</form>
		
		
		
      </div>
      <div class="modal-footer">
        <button type="button" id="saveE"  class="btn btn-success" >Update</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	
    </div>
  </div>
</div>
<!------Edit slider modal close------------>
<!-----delete sld start--->
<div id="delLead" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Delete Lead Owner</h4>
      </div>
      <div class="modal-body">		
		<form>
			<input type="hidden" id="delid" />
			
			<div class="row">
				<div class="col-md-12">
					<h4>Are you sure want to delete Lead Owner ?</h4>
				</div>
			</div>
			<div class="clearfix"></div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="deletelead"  class="btn btn-warning">Delete</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-----delete sld close--->
</body>

	

	<script type="text/javascript">
	
	var table;
		//$(function(){
			 table=$('#example').DataTable({
						"scrollX": true,
						"contentType": "application/json",
						"ajax": "<?php echo URL;?>ubitech/getleadOwnerData",
						"columns": 	[
							{ "data": "name" },
							{ "data": "action"}
									]
					});
					
			$('#saveE').click(function(){
				var editid =  $("#editid").val();
				var nameE =  $("#nameE").val();
			
               
				if(nameE == ""){
					doNotify('top','center',4,'Please enter name.');
					return false;
			     }
				 $.ajax({url: "<?php echo URL;?>ubitech/editLeadOwnerData",
						data: {"editid":editid,"nameE":nameE},
						success: function(result){
							
							if(result)
							{
								doNotify('top','center',2,'Lead Owner updated successfully.');
								$('#addLeadE').modal('hide');
								table.ajax.reload();
							}
							else
							{
								doNotify('top','center',4,'Some error occurs.');
							}
							
						 },
						error: function(result)
							{
							doNotify('top','center',4,'Unable to connect API');
						    }
				   }); 
				  
				  
				  
			});
			$(document).on("click", ".edit", function () { 
				$('#editid').val($(this).data('id'));
				$('#nameE').val($(this).data('name'));
				
			});
			$(document).on("click", ".delete2", function () {
				
				$('#delid').val($(this).data('aid'));
			});
		//});
    	$(document).ready(function(){
			$("#fileE").hide();
			$("#preview").click(function(){
				$("#file").click();
			});
			$("#previewE").click(function(){
				$("#fileE").click();
			});
			function readURL(input) {
				if (input.files && input.files[0]) {
					var reader = new FileReader();
					reader.onload = function (e) {
						$('#preview').attr('src', e.target.result);
					}
					reader.readAsDataURL(input.files[0]);
				}
			}

			$("#file").change(function(){
				readURL(this);
				 var myImg = document.getElementById('preview');
				var width = $("#preview").width();
				var height =$("#preview").height();
				//alert(width+" X"+height);
				
				});
				
				<!-- this is get size of image when add a image (start)-->
					var _URL = window.URL || window.webkitURL;
					$("#file").change(function (e) {
						var file, img;
						if ((file = this.files[0])) {
							img = new Image();
							img.onload = function () {
								var width  =  this.width;
								var height =  this.height;
								$("#image_width").val(width);
								$("#image_height").val(height);
								
							};
							img.src = _URL.createObjectURL(file);
						}
					});
	            <!-- this is get size of image when add a image (end)-->	
			
		$("#save").click(function(){
            var name =  $("#name").val();
           
			if(name == ""){
				doNotify('top','center',4,'Please enter name.');
				return false;
			}
			$.ajax({url: "<?php echo URL;?>ubitech/addleadowner",
						data: {"name":name},
						success: function(result){
						
							if(result==4){
								doNotify('top','center',2,'Lead Owner added successfully.');
								$('#addLead').modal('hide');
								document.getElementById('leadfrom').reset();
								 table.ajax.reload();
							}
							else if(result==1)
							{
								doNotify('top','center',4,'Duplicate Lead Owner  found.');
							}
							
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			
		
		});
   
			// Javascript method's body can be found in assets/js/demos.js
        	//demo.initDashboardPageCharts();

    	});
		
		
			
		$('#deletelead').click(function(){
			var id = $('#delid').val();	
				   $.ajax({url: "<?php echo URL;?>ubitech/deleteLeadOwnerData",
						data: {"id":id},
						success: function(result){
							if(result==1){
								doNotify('top','center',2,'Lead Owner deleted successfully.');
								$('#delLead').modal('hide');
								 table.ajax.reload();
							}
							else if(result==2)
							{
								doNotify('top','center',4,"This lead owner has already assigned to organization. Its can not be delete."); 
								$('#delLead').modal('hide');
								 table.ajax.reload();
							}
							else{
								doNotify('top','center',4,'Some error occurs.');
							}
							
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});
			
		
            			
			
			function readURLE(input) {
				if (input.files && input.files[0]) 
				{
					var reader = new FileReader();
					reader.onload = function (e) 
					{
						$('#previewE').attr('src', e.target.result);
					}
					reader.readAsDataURL(input.files[0]);
				}
			}
			<!-- for alert message-->
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
             $("#success-alert").slideUp(500);
            });
			<!-- -->
			
			
			<!-- this is get size of image when edit a image (start)-->	
			var _URL = window.URL;
			$("#fileE").change(function (e) {
				var file, img;
				if ((file = this.files[0])) {
					img = new Image();
					img.onload = function () {
                    $("#image_widthE").val(this.width);
					$("#image_heightE").val(this.height);
					};
					img.src = _URL.createObjectURL(file);
				}
			});
       
	    <!-- this is get size of image when edit a image (end)-->
			
	</script>

</html>
