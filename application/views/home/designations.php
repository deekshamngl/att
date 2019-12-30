<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Designations</title>
</head>
<style>
.delete{
			cursor:pointer;
		}
		.red{
			color:red;
			font-weight:'bold';
			font-size:16px;
		}
		.t2{
			display: none;
		}
</style>
<body>
	<div class="wrapper">
		<?php
			$data['pageid']=6;
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
	                               
	                                <p class="category" style="color:#ffffff;font-size:17px;"  >List of Designations </p>
									<a rel="tooltip"   rel="tooltip"  data-placement="bottom" title="Help" class="btn btn-success btn-sm toggle-sidebar pull-right " style="position:relative;margin-top:-30px;" > 
									<i class="fa fa-question"></i></a>	
	                            </div>
	                            <div class="card-content">
									<div id="typography">
										<div class="title">
											<div class="row">
												<div class="col-md-8" style="margin-top:-10px;" >
													<h3>Manage Designations</h3>
												</div>
												<div class="col-md-4 text-right">
												   <a href="<?php echo URL; ?>admin/importdesination" class="btn btn-sm btn-success" title="Add multiple designations through import" style="padding:5px 8px;"><i class="fa fa-file-excel-o">&nbsp;Import</i></a>
												   
													<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addDesg" type="button" title="Add a designation">	
														<i class="fa fa-plus"> Add</i>
													</button>
												</div>
												<div class="col-md-4 text-right">
												
											</div>
											</div>
										</div>
										<div class="row" style="overflow-x:scroll;">
											<table id="example" class="display table" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th width='80%'>Designations</th>
												    <!-- <th width='40%'>Description</th>
													<!--<th width='10%'>Created Date</th>
													<th width='10%' >Modified Date</th> -->
													<th  width='10' style="background-image:none"!important>Status</th>
													<th  width='10' style="background-image:none"!important>Action</th>
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
					<!--<p class="copyright pull-right">
						&copy; <script>document.write(new Date().getFullYear())</script> <a href="#">DESIGNED BY</a> Ubitech Solutions Pvt. Ltd.
					</p>-->
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
<!-- Modal open add Designations-->
<div id="addDesg" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title"> Add</h4>
      </div>
      <div class="modal-body">
		<form id="desgFrom">
			<div class="row">
				<div class="col-md-8">
					<div class="form-group label-floating">
						<label class="control-label" id="desgNameLable">Designation Name<span class="red">*</span></label>
						<input type="text" id="desgName" class="form-control" >
					</div>
				<!--	<div class="form-group label-floating">
						<label class="control-label" id="desgNameLable">Description </label>
						<textarea id="desc" rows='5' class="form-control"></textarea>
					</div> -->
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group label-floating" style="display:none">
						<label class="control-label">Status  <span class="red"> *</span></label>
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
        <button type="button" id="save"  class="btn btn-success">Add</button>
        <button type="reset" class="btn btn-default" data-dismiss="modal" >Reset</button>
      </div>
	  </form>
    </div>
  </div>
</div>
<!---modal close--->
<!------Edit Designations modal start------------>
<div id="addDesgE" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Update Designation</h4>
      </div>
	  <form id="desgFromE">
       <div class="modal-body">
			<input type="hidden" id="did" />
			<div class="row">
				<div class="col-md-12">
					<div class="form-group label-floating">
						<label>Designation Name <span class="red"> *</span></label>
						<input type="text" id="desgNameE" class="form-control" >
					</div>
				<!--	<div class="form-group label-floating">
						<label >Description </label>
						<textarea id="descE" rows='3' class="form-control"></textarea>
					</div> -->
				</div>
			</div>			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Status  <span class="red"> </span></label>
						<select class="form-control" id="statusE" >
							<option value='1'>Active</option>
							<option value='0'>Inactive</option>
						</select>
						<small style="color:green"  >This Designation assigned <span id="numemp" > </span> Employees</small>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		
      </div>
      
      <div class="modal-footer">
        <button type="button" id="saveE"  class="btn btn-success">Update</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	  </form>
    </div>
  </div>
</div>
<!------Edit desg modal close------------>
<!-----delete desg start--->
<div id="delDesg" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Delete Designation</h4>
      </div>
      <div class="modal-body">		
		<form>
			<input type="hidden" id="del_did" />
			<div class="row">
				<div class="col-md-12">
					<h4>Do you want to delete this Designation "<span id="dna"></span>" ?</h4>
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
<!-----delete desg close--->
</body>
<div id="mySidenav" class="pull-right sidenav" style="background-image:url(<?=URL?>../assets/img/bg7.jpg);background-repeat:no-repeat;">
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
							$('#sidenavData').load('<?=URL?>admin/helpNav',{'pageid': 'desgH'});	
						}
						function closeNav() {
							document.getElementById("mySidenav").style.width = "0";
						}
	
	</script>

	

	<script type="text/javascript">
    	$(document).ready(function() {
			var table=$('#example').DataTable( {
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
				//"scrollX": true,
				"contentType": "application/json",
				"ajax": "<?php echo URL;?>admin/getAllDesg",
				"columns": [
					{ "data": "name" },
				//	{ "data": "desc" },
					//{ "data": "cdate" },
					//{ "data": "mdate" },
					{ "data": "status" },
					{ "data": "action" }
				]
			} );
			$('#save').click(function(){
				  if($('#desgName').val().trim()==''){
					  $('#desgName').focus();
						doNotify('top','center',4,'Please enter the Designation name.');
					  return false;
				  }
				   var dna=$('#desgName').val().trim();
				   var desc=$('#desc').val();
				   var sts=$('#status').val();
				   $.ajax({url: "<?php echo URL;?>admin/registerDesg",
						data: {"dna":dna,"sts":sts,"desc":desc},
						success: function(result){
							if(result==1){
								doNotify('top','center',2,'Designation Added Successfully.');
								$('#addDesg').modal('hide');
								document.getElementById('desgFrom').reset();
								 table.ajax.reload();
							}else if(result==2){
								doNotify('top','center',3,'Designation '+dna+' already exist.');
							}
							else{
								doNotify('top','center',4,'There may error(s) in creating Designation, try later.');
								document.getElementById('desgFrom').reset();
								$('#addDesg').modal('hide');
							}
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});
			$('#saveE').click(function(){
				  if($('#desgNameE').val().trim()==''){
					  $('#desgNameE').focus();
						doNotify('top','center',4,'Please enter the Designation name.');
					  return false;
				  }
				   var did=$('#did').val();
				   var dna=$('#desgNameE').val().trim();
				   var sts=$('#statusE').val();
				   var desc=$('#descE').val();
				   $.ajax({url: "<?php echo URL;?>admin/editDesg",
						data: {"did":did,"dna":dna,"sts":sts,"desc":desc},
						success: function(result){
							if(result==1){
								doNotify('top','center',2,'Designation Updated Successfully.');
								$('#addDesgE').modal('hide');
								document.getElementById('desgFromE').reset();
								 table.ajax.reload();
							}else if(result==2){
								doNotify('top','center',3,'Designation '+dna+' already exist.');
							}
							else{
								doNotify('top','center',4,'No changes found.');
								document.getElementById('desgFromE').reset();
								$('#addDesgE').modal('hide');
							}
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});
			$(document).on("click", "#delete", function () {
				var id=$('#del_did').val();
				$.ajax({url: "<?php echo URL;?>admin/deleteDesg",
						data: {"did":id},
						success: function(result){
							result=JSON.parse(result);
							if(result.afft){
								$('#delDesg').modal('hide');
								doNotify('top','center',2,'Designation deleted successfully.');
								 table.ajax.reload();
							}else{
								$('#delDesg').modal('hide');
								doNotify('top','center',4,'This Designation can not be delete, It is currently assigned to '+result.emp+' employee(s).');
							}
						
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});
			$(document).on("click", ".edit", function () {
				$('#desgNameLableE').text('');
				$('#descNameLableE').text('');
				$('#desgNameE').attr('placeholder',"");
				$('#descE').attr('placeholder',"");
				$('#did').val($(this).data('did'));
				$('#descE').val($(this).data('desc'));
				$('#desgNameE').val($(this).data('name'));
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
		} );
	</script>
	<script>
		$(document).ready(function(){
		$(".toggle-sidebar").click(function(){
		// if($(".t2").is(':hidden'))
	 //       setTimeout(function(){
		$("#sidebar").toggleClass("collapsed t2");
		$("#content").toggleClass("col-md-9");
		$("#sidebar").load("<?=URL?>admin/helpnav",{'pageid':'desgH'});
		// }, 300);
		});
		/*$('.main-panel').click(function(){
			if(!$(".t2").is(':hidden'))
			{
				 $("#sidebar").toggleClass("collapsed t2");
				 $("#content").toggleClass("col-md-9");
			}
		  });*/
		});
	</script>
</html>
