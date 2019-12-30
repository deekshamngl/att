<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Departments/Sites</title>
	<style>
		.red{
			color:red;
			font-weight:'bold';
			font-size:16px;
		}
		.delete{
			cursor:pointer;
		}
		.t2{
			display: none;
		}
	</style>
</head>
<body>
	<div class="wrapper">
		<?php
			$data['pageid']=5;
			$this->load->view('menubar/sidebar',$data);
		?>
	    <div class="main-panel">
			<?php
				$this->load->view('menubar/navbar');
			?>
			
			<div class="content" id="content">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-md-12">
	                        <div class="card">
	                            <div class="card-header" data-background-color="green">
	                                <p style="color:#ffffff;font-size:17px;"  class="category">List of departments</p>
									<a rel="tooltip"  data-placement="bottom" title="Help" class="btn btn-success btn-sm toggle-sidebar pull-right " style="position:relative;margin-top:-30px;" >
											<i class="fa fa-question"></i></a>
									
	                            </div>
	                            <div class="card-content">
									<div id="typography">
										<div class="title">
											<div class="row">
												<div class="col-md-8" style="margin-top:-10px;" >
													<h3>Manage Departments</h3>
												</div>
												<div class="col-md-4 text-right">
												   <a href="<?php echo URL; ?>admin/importdepartment" class="btn btn-sm btn-success" title="Add multiple departments through import" style="padding:5px 8px;"><i class="fa fa-file-excel-o">&nbsp;Import</i></a>
													<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addDept" type="button" title="Add a department">	
														<i class="fa fa-plus"> Add</i>
													</button>
												</div>
												<div class="col-md-4 text-right">
													
											</div>
											</div>
										</div>
										
										<div class="row">
											<table id="example" class="display table" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th width="80%">Department</th>
													<!--<th>Created Date</th>
													<th>Modified Date</th>-->
													<th width="10" style="background-image:none"!important>Status</th>
													<th width="10" style="background-image:none"!important>Action</th>
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

	       <div class="col-md-3 t2" id="sidebar" style="margin-top:100px;"></div>
			<footer class="footer">
				<div class="container-fluid">	
				</div>
			</footer>
			<footer class="footer">
				<div class="container-fluid">
					<nav class="pull-left">
						
					</nav>
					<!--<p class="copyright pull-right" style="padding-right:25px;" >
              &copy; <script>document.write(new Date().getFullYear())</script>. Developed by<a href="http://www.ubitechsolutions.com/" target="_blank" > Ubitech Solutions </a></p>-->
			  <a href="http://www.ubitechsolutions.com/" target="_blank" >
					<p class="copyright pull-right" style="padding-right:25px;" >
					Copyright &copy;<script>document.write(new Date().getFullYear())</script>
					Ubitech Solutions. All rights reserved.
					</p>
				</a>
				</div>
			</footer>
		</div>
		</div>
<!-- Modal open add dept-->
<div id="addDept" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Add Department</h4>
      </div>
      <div class="modal-body">
		<form id="deptFrom">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group label-floating">
						<label class="control-label" id="">Department <span class="red"> *</span></label>
						<input type="text" id="deptName" class="form-control" >
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group label-floating" style="display:none">
						<label class="control-label">Status  <span class="red"> </span></label>
						<select class="form-control" id="status" >
							<option value='1' selected>Active</option>
							<option value='0'>Inactive</option>
						</select>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		
      </div>
      <div class="modal-footer">
        <button type="button" id="save"  class="btn btn-success">Save</button>
        <button type="reset" class="btn btn-default" data-dismiss = "modal" >Reset</button>
      </div>
	  </form>
    </div>
  </div>
</div>
<!---modal close--->
<!------Edit department modal start------------>
<div id="addDeptE" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Update Department</h4>
      </div>
      <div class="modal-body">
        
		<form id="deptFromE">
			<input type="hidden" id="did" />
			<div class="row">
				<div class="col-md-12">
					<div class="form-group label-floating">
						<label >Department Name <span class="red"> *</span></label>
						<input type="text" id="deptNameE" class="form-control" >
					</div>
				</div>
			</div>			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Status <span class="red"> </span></label>
						<select class="form-control" id="statusE" >
							<option value='1'>Active</option>
							<option value='0'>Inactive</option>
						</select>
						<small style="color:green" >Assigned to <span id="numemp" > </span> Employee(s)</small>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</form>
		
		
      </div>
      <div class="modal-footer">
        <button type="button" id="saveE"  class="btn btn-success">Update</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!------Edit dept modal close------------>
<!-----delete dept start--->
<div id="delDept" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Delete Department</h4>
      </div>
      <div class="modal-body">		
		<form>
			<input type="hidden" id="del_did" />
			<div class="row">
				<div class="col-md-12">
					<h4>Do you want to delete this Department "<span id="dna"></span>" ?</h4>
				</div>
			</div>
			<div class="clearfix"></div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="delete"  class="btn btn-success">Delete</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
  
</div>
<!-----delete dept close--->
</body>
<div id="mySidenav" class="pull-right sidenav" style="background-image:url(<?=URL?>../assets/img/bg7.jpg);">
						<div class="helpHeader"><span><b>&nbsp;&nbsp;<i style="font-size:24px; color:black;"class="fa fa-question-circle" ></i ></b></span><a style="color:black;" href="javascript:void(0)" class="closebtn text-right" onclick="closeNav()">x </a></div>
						<div id="sidenavData" class="sidenavData">
						</div>
					</div>
					
	<script src="<?=URL?>../assets/js/bootstrap-timepicker.min.js" type="text/javascript"></script>

<script src="<?=URL?>../assets/js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="<?=URL?>../assets/js/buttons.print.min.js"></script>
	<script src="<?=URL?>../assets/js/dataTables.buttons.min.js"></script>
	 <script type="text/javascript" src="<?=URL?>../assets/js/moment.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/daterangepicker.js"></script>
	  
      <script type="text/javascript" src="<?=URL?>../assets/js/buttons.flash.min.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/jszip.min.js"></script>
		 <script type="text/javascript" src="<?=URL?>../assets/js/jquery.dataTables.min.js"></script>
	    <script type="text/javascript" src="<?=URL?>../assets/js/buttons.html5.min.js"></script>				
					
					
					
					
	<script>
	function openNav() {
							document.getElementById("mySidenav").style.width = "360PX";
							$('#sidenavData').load('<?=URL?>admin/helpNav',{'pageid': 'departH'});	
						}
						function closeNav() {
							document.getElementById("mySidenav").style.width = "0";
						}
	
	</script>

	<script type="text/javascript">
    	$(document).ready(function() {
			var table=$('#example').DataTable( {
						//"scrollX": true,
							"orderable": false,
					//"scrollX": true,
				 dom: 'Bfrtip',
					buttons: [
					'pageLength','csv','excel','copy','print',
					{
						"extend":'colvis',
						"columns":':not(:last-child)',
					}
				],
				columnDefs: [ { orderable: false, targets: [1,2]}],
						"contentType": "application/json",
						"ajax": "<?php echo URL;?>admin/getAllDept",
						"columns": [
							{ "data": "name" },
							///{ "data": "cdate" },
							//{ "data": "mdate" },
							{ "data": "status" },
							{ "data": "action" }
						]
					});
			$('#save').click(function(){
					  if($('#deptName').val().trim()=='')
					  {
						  $('#deptName').focus();
						  doNotify('top','center',4,'Please enter the Department name.');
						  return false;
					  }
				   var dna=$('#deptName').val().trim();
				   var sts=$('#status').val();
				   $.ajax({url: "<?php echo URL;?>admin/registerDept",
						data: {"dna":dna,"sts":sts},
						success: function(result){
							if(result==1)
							{
								doNotify('top','center',2,'Department Added Successfully.');
								$('#addDept').modal('hide');
								document.getElementById('deptFrom').reset();
								 table.ajax.reload();
							}
							else if(result==2){
								doNotify('top','center',3,'Department '+dna+' already exist.');
								
							}
							else{
								doNotify('top','center',4,'There may some error(s) i Adding department, Try Later');
								//$('#addDept').modal('hide');
								document.getElementById('deptFrom').reset();
								$('#addDept').modal('hide');
							}
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});
			$('#saveE').click(function(){
				  if($('#deptNameE').val().trim() == ''){
					  $('#deptNameE').focus();
						doNotify('top','center',4,'Please enter the department name.');
					  return false;
				  }
				   var did=$('#did').val();
				   var dna=$('#deptNameE').val().trim();
				   var sts=$('#statusE').val();
				   $.ajax({url: "<?php echo URL;?>admin/editDept",
						data: {"did":did,"dna":dna,"sts":sts},
						success: function(result){
							if(result==1){
								doNotify('top','center',2,'Department Updated Successfully.');
								$('#addDeptE').modal('hide');
								document.getElementById('deptFrom').reset();
								 table.ajax.reload();
							}else if(result==2){
								doNotify('top','center',3,'Department '+dna+' already exist.');
							}
							else{
							doNotify('top','center',4,'No Chnages Found');
							document.getElementById('deptFrom').reset();
								$('#addDeptE').modal('hide');
							}
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});
			
			$(document).on("click", "#delete", function () 
			{
				var id=$('#del_did').val();
				$.ajax({url: "<?php echo URL;?>admin/deleteDept",
						data: {"did":id},
						success: function(result){
							result=JSON.parse(result);
							if(result.afft){
								$('#delDept').modal('hide');
								doNotify('top','center',2,'Department deleted successfully.');
								 table.ajax.reload();
							}
							else if(result.emp){
								$('#delDept').modal('hide');
								doNotify('top','center',4,'This Department can not be delete, It is currently assigned to '+result.emp+' employee(s).  ');
							}
							else if(result.aarc){
								$('#delDept').modal('hide');
								doNotify('top','center',4,'ThisDepartment can not be delete, Some Employee Punched Attendance from this department  ');
							}
							else
							{
								$('#delDept').modal('hide');
								doNotify('top','center',4,'Department can not be delete, Some Employee Punched Attendance from this department  ');
							}
						
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});
			$(document).on("click", ".edit", function () {
				$('#deptNameLableE').text('');
				$('#deptName').attr('placeholder',"");
				$('#did').val($(this).data('did'));
				$('#deptNameE').val($(this).data('name'));
				$('#statusE').val($(this).data('sts'));	
				$('#numemp').text($(this).data('assign'));
				 if($(this).data('sts')==1 && parseInt($(this).data('assign')) > 0)
				 {
					 $("#statusE").prop('disabled', true);
				 }
				 else
				 {
					 $("#statusE").prop('disabled', false);
				 }
			});
			$(document).on("click", ".delete", function () {
				$('#del_did').val($(this).data('did'));
				$('#dna').text($(this).data('dname'));
			});			
		});
	</script>
	<script>
		$(document).ready(function(){
		$(".toggle-sidebar").click(function(){
		$("#sidebar").toggleClass("collpsed t2");
		$("#content").toggleClass("col-md-9");
		$("#sidebar").load("<?=URL?>admin/helpnav",{'pageid':'departH'});
		})
		})
	</script>
</html>
