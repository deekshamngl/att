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
			$data['pageid']=2;
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
	                                <h4 class="title">Promotional Banners</h4>
	                                <p class="category">Banner Settings</p>
	                            </div>
	                            <div class="card-content">
									<div id="typography">
										<div class="title">
											<div class="row">
												<div class="col-md-8">
												<!--	<h3>Manage Slider</h3> --->
												</div>
												<div class="col-md-4 text-right">
													<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addSld" type="button">	
														<i class="fa fa-plus"> Add</i>
													</button>
												</div>
											</div>
										</div>
										<div class="row">
											<table id="example" class="display table" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th width="15%">Image</th>
													<th>Name</th>
													<th>Description</th>
													<th>Link</th>
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
        <h4 class="modal-title" id="title">Add Slider Image</h4>
      </div>
      <div class="modal-body">
		<form id="deptFrom" action="<?php echo URL;?>ubitech/uploadimg" method="post" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-8">
							<div class="">
								<label class="" >Image <span class="red"> *</span></label>
								<input name="file" accept="image/x-png,image/gif,image/jpeg"  type="file" id="file" class=""  >
								
							</div>
						</div>
						<div class="col-md-4">
							<img src="<?=URL?>../upload/blank.jpg" id="preview" src="#"  width="100%" />
						</div>
					</div>
					<div class="form-group label-floating">
						<label class="control-label">Name <span class="red"> *</span></label>
						<input type="text" id="name" name="name" class="form-control" >
					</div>
					<div class="form-group label-floating">
						<label class="control-label">Description </label>
						<textarea id="desc" name="desc" class="form-control"></textarea>
					</div>
					<div class="form-group label-floating">
						<label class="control-label">Link To </label>
						<input type="text" id="link" name="link" class="form-control" >
						<label>
							<small>					Eg.http://www.ubijournal.com/affordable-pricing-for-open-journals/
							</small>
						</label>
					</div>
				</div>
			</div>
			<input type="hidden" id="image_width" />
			<input type="hidden" id="image_height" />
			<div class="row">
				<div class="col-md-4">
					<div class="form-group label-floating">
						<label class="control-label">Visible To</label>
						<select class="form-control" id="status" name="status">
							<option value='1' selected>Visible to all</option>
							<option value='2'>Paid user's only</option>
							<option value='3'>Trial user's only</option>
							<option value='0'>Invisible</option>
						</select>
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
        <h4 class="modal-title" id="title">Edit Slider Image</h4>
      </div>
      <div class="modal-body">
		<form id="deptFromE" method="post" enctype="multipart/form-data" action="<?php echo URL;?>ubitech/editSliderData" >
		<input type="text" class="hidden" id="edit_id" name="edit_id" />
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-8">
							<div class="">
								<label class="">Image <span class="red"> *</span></label>
								<input name="fileE" accept="image/x-png,image/gif,image/jpeg"  type="file" id="fileE" class="" onchange="readURLE(this);" >
							</div>
						</div>
						<div class="col-md-4">
							<img id="previewE" src="#"  width="100%" />
						</div>
					</div>
					<div class=" label-floating1">
						<label class="control-label">Name <span class="red"> *</span></label>
						<input type="text" id="nameE" name="nameE" class="form-control" >
					</div>
					<div class=" label-floating1">
						<label class="control-label">Description </label>
						<textarea id="descE" name="descE" class="form-control"></textarea>
					</div>
					<div class=" label-floating1">
						<label class="control-label">Link To </label>
						<input type="text" id="linkE" name="linkE" class="form-control" >
						<label>
							<small>					Eg.http://www.ubijournal.com/affordable-pricing-for-open-journals/
							</small>
						</label>
					</div>
				</div>
			</div>
			<input type="hidden" id="image_widthE" />
			<input type="hidden" id="image_heightE" />
			<div class="row">
				<div class="col-md-4">
					<div class="form-group label-floating1">
						<label class="control-label">Visibile To</label>
						<select class="form-control" id="statusE" name="statusE">
							<option value='1' selected>Visible to all</option>
							<option value='2'>Paid user's only</option>
							<option value='3'>Trial user's only</option>
							<option value='0'>Invisible</option>
						</select>
					</div>
				</div>
			</div>
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
			 table=$('#example').DataTable({
						"scrollX": true,
						"contentType": "application/json",
						"ajax": "<?php echo URL;?>ubitech/getSliderData",
						"columns": [
							{ "data": "image" },
							{ "data": "name" },
							{ "data": "desc" },
							{ "data": "link" },
							{ "data": "status"},
							{ "data": "action"}
								]
					});
					
			$('#saveE').click(function(){
				var nameE =  $("#nameE").val();
                var descE =  $("#descE").val();
                var linkE =  $("#linkE").val();
				if(nameE == ""){
					doNotify('top','center',4,'Please enter name.');
					return false;
			     }
				if(descE == ""){
					doNotify('top','center',4,'Please enter Description.');
					return false;
				}
				if(linkE == "")
				{
					doNotify('top','center',4,'Please enter Link.');
					return false;
				}
				var widthE  =  $("#image_widthE").val();
			    var heightE =  $("#image_heightE").val();
				
				if(widthE != "" && heightE != ""){
					if(widthE != 350 && heightE != 125){
						alert("image size should be 350 X 125");
					    return false;
					}
				}
				// var widthE  =  $("#image_widthE").val();
			    // var heightE =  $("#image_heightE").val();
				// if(widthE==350 && heightE==125){
			        $("#deptFromE").submit();
			    // }else{
				   // alert("image size should be 350 X 125");
			    // }  
			});
			$(document).on("click", ".edit", function () { 
				$('#edit_id').val($(this).data('id'));
				$('#nameE').val($(this).data('name'));
				$('#descE').val($(this).data('desc'));
				$('#linkE').val($(this).data('link'));
				//$('#previewE').src="<?=URL?>../ubitech/upload/"+$(this).data('filename');
				$('#previewE').attr('src',"<?=URL?>../ubitech/upload/"+$(this).data('file'));
				$('#statusE').val($(this).data('sts'));	
			});
			$(document).on("click", ".delete1", function () {
				$('#del_image').val($(this).data('image'));
				$('#del_aid').val($(this).data('aid'));
			});
		});
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
            var desc =  $("#desc").val();
            var link =  $("#link").val();
			if(name == ""){
				doNotify('top','center',4,'Please enter name.');
				return false;
			}
			if(desc == ""){
				doNotify('top','center',4,'Please enter Description.');
				return false;
			}
			if(link == ""){
				doNotify('top','center',4,'Please enter Link.');
				return false;
			}
			var width  =  $("#image_width").val();
			var height =  $("#image_height").val();
			if(width==350 && height==125){
			 $("#deptFrom").submit();
			}else{
				alert("image size should be 350 X 125");
			}
		
		});
   
			// Javascript method's body can be found in assets/js/demos.js
        	//demo.initDashboardPageCharts();

    	});
		
		
			
		$('#delete').click(function(){
			var id = $('#del_aid').val();			
			var image = $('#del_image').val();			
				   $.ajax({url: "<?php echo URL;?>ubitech/deleteSliderData",
						data: {"id":id,"imagePath":image},
						success: function(result){
							if(result == "true"){
								doNotify('top','center',2,'Data deleted successfully.');
								$('#delSld').modal('hide');
								 table.ajax.reload();
							}else{
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
