<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Hourly Rate</title>
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
			$data['pageid']=12.5;
			$this->load->view('menubar/sidebar',$data);
		?>
	    <div class="main-panel">
			<?php
				$this->load->view('menubar/navbar');
			?>
			</br>
			<div class="content" id="content">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-md-12">
	                        <div class="card">
	                            <div class="card-header" data-background-color="green">
									 <p class="category" style="color:#ffffff;font-size:17px;" > Hourly Rate</p>
									 <a rel="tooltip" style="position:relative;margin-top:-30px;"  data-placement="bottom" title="Help" class="btn btn-success btn-sm pull-right toggle-sidebar ">
                    <i class="fa fa-question"></i></a>
	                            </div>
	                            <div class="card-content">
									<div id="typography">
										<div class="title">
											<div class="row">
												<div class="col-md-8" style="margin-top:-10px">
													<h3>Manage hourly rate</h3>
												</div>
												<div class="col-md-4 text-right">
													<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addDesg" type="button" title="Add a rate">	
														<i class="fa fa-plus"> Add</i>
													</button>
												</div>
											</div>
										</div>
										<div class="row" style="overflow-x:scroll;">
											<table id="example" class="display table" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th width='30%'>Designation</th>
													<th width='40%'>Rates</th>
													<th  width='7%' style="background-image:none"!important>Status</th>
													<th  width='10%' style="background-image:none"!important>Action</th>
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
        <h4 class="modal-title" id="title">Add a rate</h4>
      </div>
	  <form id="desgFrom">
       <div class="modal-body">
		
			<div class="row">
				<div class="col-md-8">
					<div class="form-group label-floating">
						<label class="control-label" id="desgNameLable">Name<span class="red">*</span></label>
						<input type="text" id="rateName" class="form-control"  >
							
					</div>
					<div class="form-group label-floating">
						<label class="control-label" id="desgNameLable">Rate <span class="red">*</span></label>
						<input type="number" min="0" id="rate" class="form-control" >
					</div>
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
         <button type="button" id="save"  class="btn btn-success">Save</button>
         <button type="reset" class="btn btn-default" data-dismiss="modal" >Close</button>
      </div>
	  </form>
    </div>
  </div>
</div>
<!---modal close--->
<!------Edit Designations modal start------------>
<div id="addDesgE"getAllDesghourlyrate class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Update Rate</h4>
      </div>
	    <form id="desgFromE">
         <div class="modal-body">
			<input type="hidden" id="rid" />
			<div class="row">
				<div class="col-md-12">
					<div class="form-group label-floating">
						<label>Name <span class="red"> *</span></label>
						<input type="text" id="rateNameE" class="form-control"  >
						<!--<select id="rateNameE" class="form-control" readonly>
								<option value="0">-Select-</option>
								<?php
								$data= json_decode(getAllDesg($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++)
									echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								?>
							</select>-->
					</div>
					<div class="form-group label-floating">
						<label >Rate </label>
						<input type="number" id="rateE" class="form-control" >
					</div>
				</div>
			</div>			
			<div class="row">
				<div class="col-md-4">
					<div class="form-group label-floating">
						<label class="control-label">Status  <span class="red"> </span></label>
						<select class="form-control" id="statusE" >
							<option value='1'>Active</option>
							<option value='0'>Inactive</option>
						</select>
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
        <h4 class="modal-title" id="title">Delete Rate</h4>
      </div>
      <div class="modal-body">		
		<form>
			<input type="hidden" id="del_did" />
			<div class="row">
				<div class="col-md-12">
					<h4>Do you want to delete this Rate "<span id="rna"></span>" ?</h4>
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
							$('#sidenavData').load('<?=URL?>admin/helpNav',{'pageid': 'hourlyrate'});	
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
					
    

				columnDefs: [ { orderable: false, targets: [2,3]}],
				//"scrollX": true,
				"contentType": "application/json",
				"ajax": "<?php echo URL;?>admin/getAllrates",
				"columns": [
					{ "data": "name" },
					{ "data": "rate" },
					//{ "data": "cdate" },
					//{ "data": "mdate" },
					{ "data": "status" },
					{ "data": "action" }
				]
			} );
			$('#save').click(function(){
				  if($('#rateName').val()==''){
					  $('#rateName').focus();
						doNotify('top','center',4,'Please enter the rate name.');
					  return false;
				  }
				  if($('#rate').val()==''){
					  $('#rate').focus();
						doNotify('top','center',4,'Please enter the Rate.');
					  return false;
				  }
				   var rna=$('#rateName').val();
				   var rate=$('#rate').val();
				   var sts=$('#status').val();
				   $.ajax({url: "<?php echo URL;?>admin/addRate",
						data: {"rna":rna,"sts":sts,"rate":rate},
						success: function(result){
							if(result==1){
								doNotify('top','center',2,'Rate Added Successfully.');
								$('#addDesg').modal('hide');
								document.getElementById('desgFrom').reset();
								 table.ajax.reload();
							}else if(result==2){
								doNotify('top','center',3,'Rate '+rate+' already exist.');
							}
							else{
								doNotify('top','center',4,'There may error(s) in creating Rate, try later.');
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
				  if($('#rateNameE').val()==''){
					  $('#rateNameE').focus();
						doNotify('top','center',4,'Please enter the Rate name.');
					  return false;
				  }
				  if($('#rateE').val()==''){
					  $('#rateE').focus();
						doNotify('top','center',4,'Please enter the Rate.');
					  return false;
				  }
				   var rid=$('#rid').val();
			
				   var rna=$('#rateNameE').val();
				   var sts=$('#statusE').val();
				   var rate=$('#rateE').val();
				   $.ajax({url: "<?php echo URL;?>admin/editRate",
						data: {"rid":rid,"rna":rna,"sts":sts,"rate":rate},
						success: function(result){
							//alert(result);
							if(result==1){
								doNotify('top','center',2,'Rate Updated Successfully.');
								$('#addDesgE').modal('hide');
								document.getElementById('desgFromE').reset();
								 table.ajax.reload();
							}else if(result==2){
								doNotify('top','center',3,'Designation '+rate+' already exist.');
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
			$(document).on("click", "#delete", function (){
				var id=$('#del_did').val();
				
				$.ajax({url: "<?php echo URL;?>admin/deleteRate",
						data: {"rid":id},
						success: function(result){
							result=JSON.parse(result);
							if(result.afft){
								$('#delDesg').modal('hide');
								doNotify('top','center',2,'Rate deleted successfully.');
								 table.ajax.reload();
							}else{
								$('#delDesg').modal('hide');
								doNotify('top','center',4,'Cannot be deleted');
							}
						
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});
			$(document).on("click", ".edit", function () {
				
				$('#rateNameE').attr('placeholder',"");
				$('#rateE').attr('placeholder',"");
				$('#rid').val($(this).data('did'));
				$('#rateE').val($(this).data('rate'));
				$('#rateNameE').val($(this).data('name'));
				  
				$('#statusE').val($(this).data('sts'));	
			});
			$(document).on("click", ".delete", function () {
				$('#del_did').val($(this).data('did'));
				$('#rna').text($(this).data('dname'));
			});		
		} );
	</script>
	<script>
		$(document).ready(function(){
		$(".toggle-sidebar").click(function(){
		$("#sidebar").toggleClass("collapsed t2");
		$("#content").toggleClass("col-md-9");
		$("#sidebar").load("<?=URL?>admin/helpnav",{'pageid':'hourlyrate'});
		});
		});
	</script>
</html>
