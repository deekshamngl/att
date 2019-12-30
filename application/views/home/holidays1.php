<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link href="<?=URL?>../assets/css/bootstrap-timepicker.min.css" rel="stylesheet"/>
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="cache-control" content="no-cache">
	<title>ubiAttendance</title>
	<style>
		.red{
			color:red;
			font-weight:'bold';
			font-size:16px;
		}
		.delete{
			cursor:pointer;
		}
	</style>
</head>
<body>

	<div class="wrapper">
		<?php
			$data['pageid']=9.2;
			$this->load->view('menubar/sidebar',$data);
		?>
	    <div class="main-panel">
			<?php
				$this->load->view('menubar/navbar');
			?>
			</br>
			<div class="content">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-md-12">
	                        <div class="card">
	                            <div class="card-header" data-background-color="purple">
	                                <h4 class="title">Holidays</h4>
	                                <p class="category">Manage Holidays </p>
	                            </div>
								  <div class="card-content">
									<div id="typography">
										<div class="title">
											<div class="row">
												<div class="col-md-8">
													<h3>Holidays List</h3>
												</div>
												<div class="col-md-4 text-right">
													<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add" type="button">	
														<i class="fa fa-plus"> Add</i>
													</button>
												</div>
										</div>
										<a rel="tooltip" onclick="openNav()"  rel="tooltip"  data-placement="bottom" title="Help" class="btn btn-primary btn-sm pull-right ">
											<i class="fa fa-question"></i></a>
										<div class="row">
											<table id="example" class="display table"  width="200%">
											<thead>
												<tr>
													<th>Holiday Name</th>
													<th width="40%">Description</th>
													<th width="10%">From</th>
													<th width="10%">To</th>
													<th width="10%">Action</th>
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
	        </div>

	       
			<footer class="footer">
				<div class="container-fluid">	
				</div>
			</footer>
		</div>
	</div>
<!-- Modal open add hodidays-->
<div id="add" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Add Holidays</h4>
      </div>
      <div class="modal-body">
		<form id="editForm">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group label-floating">
						<label class="control-label">Name <span class="red"> *</span></label>
						<input type="text" id="name" class="form-control" >
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">From <span class="red"> *</span></label>
						<input type="text" id="from"  class="form-control datepicker" >
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">To <span class="red"> *</span></label>
						<input type="text" id="to"   class="form-control datepicker" >
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group label-floating">
						<label class="control-label">Description  <span class="red"> *</span></label>
						<textarea id="desc" class="form-control" rows='4'></textarea>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="save" class="btn btn-success">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!---modal close--->
<!------Edit Holidays modal start------------>
<div id="edit" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Update Holidays</h4>
      </div>
      <div class="modal-body">
		<form id="editFormE">
			<input type="hidden" id="sid" />
			<div class="row">
				<div class="col-md-12">
					<div class="form-group label-floating is-empty is-focused">
						<!--<label class="control-label">Name <span class="red"> *</span></label>-->
						<input type="text" id="nameE" class="form-control" >
					</div>
				</div>
				
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating is-empty is-focused">
						<!--<label class="control-label">From <span class="red"> *</span></label>-->
						<input type="text" id="fromE"  class="form-control datepicker" >
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating is-empty is-focused">
						<!--<label class="control-label">To <span class="red"> *</span></label>-->
						<input type="text" id="toE" class="form-control datepicker" >
					</div>
				</div>
			</div>			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group label-floating is-empty is-focused">
						<!--<label class="control-label">Description  <span class="red"> *</span></label>-->
						<textarea id="descE" class="form-control" rows='4'></textarea>
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
<!------Edit holidays modal close------------>
<!-----delete holiday start--->
<div id="delete" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Delete Holiday</h4>
      </div>
      <div class="modal-body">		
		<form>
			<input type="hidden" id="del_sid" />
			<div class="row">
				<div class="col-md-12">
					<h4>Do you want to delete this holiday "<span id="hna"></span>" ?</h4>
				</div>
			</div>
			<div class="clearfix"></div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="del"  class="btn btn-warning">Delete</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-----delete holiday close--->
</body>

<div id="mySidenav" class="pull-right sidenav" style="background-image:url(<?=URL?>../assets/img/bg7.jpg);background-repeat:no-repeat;">
						<div class="helpHeader"><span >Help</span><a style="color:black;" href="javascript:void(0)" class="closebtn text-right" onclick="closeNav()">x </a></div>
						<div id="sidenavData" class="sidenavData">
						</div>
					</div>
	<script>
	function openNav() {
							document.getElementById("mySidenav").style.width = "360PX";
							$('#sidenavData').load('<?=URL?>help/helpNav');	
						}
						function closeNav() {
							document.getElementById("mySidenav").style.width = "0";
						}
	
	</script>

<script src="<?=URL?>../assets/js/bootstrap-timepicker.min.js" type="text/javascript"></script>

	<script type="text/javascript">
            $( ".datepicker" ).datepicker();
			
       </script>
	<script type="text/javascript">
    	$(document).ready(function() {
			var table=$('#example').DataTable( {
				    "scrollX": true,
				    "searchable": false,
					"orderable": false,
				"contentType": "application/json",
				"ajax": "<?php echo URL;?>admin/getAllHolidays",
				"columns": [
					{ "data": "name" },
					{ "data": "description" },
					{ "data": "from" },
					{ "data": "to" },
					{ "data": "action" }
				]
			});
			  $('#save').click(function(){
				   var name=$('#name').val();
				   var fromdate=$('#from').val();
				   var todate=$('#to').val();
				   var desc=$('#desc').val();
				  if(name==''){
					  $('#name').focus();
						doNotify('top','center',4,'Please enter the holiday Name.');
					  return false;
				  }
				  if(fromdate==''){
					  $('#name').focus();
						doNotify('top','center',4,'Please enter the date from.');
					  return false;
				  }
				  if(todate==''){
					  $('#name').focus();
						doNotify('top','center',4,'Please enter the date to.');
					  return false;
				  }
				  if(desc==''){
					  $('#name').focus();
						doNotify('top','center',4,'Please enter the description.');
					  return false;
				  }
				   
				   $.ajax({url: "<?php echo URL;?>admin/addHoliday",
						data: {"name":name,"from":fromdate,"to":todate,"desc":desc},
						success: function(result){
							
							if(result==1){
								doNotify('top','center',2,'Holiday Added Successfully.');
								$('#add').modal('hide');
								 table.ajax.reload();
							}
							else
								doNotify('top','center',2,'There may error(s) in creating holiday, try later.');
								document.getElementById('editForm').reset();
								$('#add').modal('hide');
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});  
			$('#saveE').click(function(){
				 var name=$('#nameE').val();
				   var fromdate=$('#fromE').val();
				   var todate=$('#toE').val();
				   var desc=$('#descE').val();
				   var sid=$('#sid').val();
				  if(name==''){
					  $('#name').focus();
						doNotify('top','center',4,'Please enter the holiday Name.');
					  return false;
				  }
				  if(fromdate==''){
					  $('#name').focus();
						doNotify('top','center',4,'Please enter the date from.');
					  return false;
				  }
				  if(todate==''){
					  $('#name').focus();
						doNotify('top','center',4,'Please enter the date to.');
					  return false;
				  }
				  if(desc==''){
					  $('#name').focus();
						doNotify('top','center',4,'Please enter the description.');
					  return false;
				  }
				   $.ajax({url: "<?php echo URL;?>admin/editHoliday",
						data: {"sid":sid,"name":name,"from":fromdate,"to":todate,"desc":desc},
						success: function(result){
							if(result==1){
								doNotify('top','center',2,'Holiday Updated Successfully.');
								$('#edit').modal('hide');
								 table.ajax.reload();
							}
							else
								doNotify('top','center',3,'There may error(s) in updating holiday or no change found');
								document.getElementById('editForm').reset();
								$('#edit').modal('hide');
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			}); 
			
			$(document).on("click", "#del", function () {
				var id=$('#del_sid').val();
				$.ajax({url: "<?php echo URL;?>admin/deleteHoliday",
						data: {"sid":id},
						success: function(result){
							if(result){
								$('#delete').modal('hide');
								doNotify('top','center',2,'Holiday deleted successfully.');
								 table.ajax.reload();
							}else{
								$('#delete').modal('hide');
								doNotify('top','center',4,'There may error(s) in deleting holiday.');
							}
						
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});
			
		});
			$(document).on("click", ".edit", function () {
				$('#nameE').attr('placeholder',"Holiday Name");
				$('#sid').val($(this).data('sid'));
				$('#nameE').val($(this).data('name'));
				$('#fromE').val($(this).data('from'));
				$('#toE').val($(this).data('to'));
				$('#descE').val($(this).data('description'));
			});
			$(document).on("click", ".delete", function () {
				$('#del_sid').val($(this).data('sid'));
				$('#hna').text($(this).data('sname'));
			});
	</script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</html>
