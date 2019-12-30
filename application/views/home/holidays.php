<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link href="<?=URL?>../assets/css/bootstrap-timepicker.min.css" rel="stylesheet"/>
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="cache-control" content="no-cache">
	<title>Holidays</title>
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
			$data['pageid']=9.2;
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
	                            
	                                <p style="color:#ffffff;font-size:17px;" class="category"> Manage holidays</p>
									<a rel="tooltip" style="position:relative;margin-top:-30px;"  data-placement="bottom" title="Help" class="btn btn-success btn-sm pull-right toggle-sidebar ">
								<i class="fa fa-question"></i></a>
	                            </div>
								  <div class="card-content">
									<div id="typography">
										<div class="title">
											<div class="row">
												<div class="col-md-8" style="margin-top:-10px;" >
													<h3>List of Holidays  </h3>
												</div>
										
												<div class="col-md-4 text-right">
													<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#add" type="button" title="Add a holiday">	
														<i class="fa fa-plus"> Add</i>
													</button>
												</div>
												
										</div>
										
										<div class="row" style="overflow-x:scroll;">
											<table id="example" class="display table" >
											<thead>
												<tr>
													<th>Holiday</th>
													<th width="40%">Description</th>
													<th width="10%">From</th>
													<th width="10%">To</th>
													<th width="10%">Total days</th>
													<th width="10%" style="background-image:none"!important>Action</th>
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
			<div class="col-md-3 t2" id="sidebar" style="margin-top:100px;"></div>
	       
			
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
<!-- Modal open add hodidays-->
<div id="add" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Add a holiday</h4>
      </div>
      <div class="modal-body">
		<form id="editForm">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group label-floating">
						<label class="control-label">Holiday Name <span class="red"> *</span></label>
						<input type="text" id="name1" class="form-control" autocomplete="off">
					</div>
				</div>
			</div>
			
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">From <span class="red"> *</span></label>
						<input type="text" id="from"  class="form-control datepicker" minvalue="dateToday">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">To <span class="red"> *</span></label>
						<input type="text" id="to" class="form-control datepicker" >
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group label-floating">
						<label class="control-label">Description  </label>
						<textarea id="desc" class="form-control" rows='4'></textarea>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		
      </div>
      <div class="modal-footer">
        <button type="button" id="save" class="btn btn-success" >Save</button>
        <button type="reset" class="btn btn-default" id="close1" data-dismiss="modal">Close</button>
      </div>
	  </form>
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
        <h4 class="modal-title" id="title">Update Holiday</h4>
      </div>
      <div class="modal-body">
		<form id="editFormE">
			<input type="hidden" id="sid" />
			<div class="row">
				<div class="col-md-12">
					<div class="form-group label-floating is-empty is-focused">
						<label class="control-label">Holiday Name <span class="red"> *</span></label>
						<input type="text" id="nameE" class="form-control" >
					</div>
				</div>
				
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating is-empty is-focused">
						<label class="control-label">From <span class="red"> *</span></label>
						<input type="text" id="fromE"  class="form-control datepicker" >
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating is-empty is-focused">
						<label class="control-label">To <span class="red"> *</span></label>
						<input type="text" id="toE" class="form-control datepicker" >
					</div>
				</div>
			</div>			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group label-floating is-empty is-focused">
						<label class="control-label">Description  </label>
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
        <button type="button" id="del"  class="btn btn-success">Delete</button>
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
					
		<script src="<?=URL?>../assets/js/buttons.colVis.min.js"></script>
		<script src="<?=URL?>../assets/js/dataTables.buttons.min.js"></script>
		<script type="text/javascript" src="<?=URL?>../assets/js/moment.js"></script>
		<script type="text/javascript" src="<?=URL?>../assets/js/daterangepicker.js"></script>
		<script type="text/javascript" src="<?=URL?>../assets/js/buttons.flash.min.js"></script>
		<script type="text/javascript" src="<?=URL?>../assets/js/jszip.min.js"></script>
		<script type="text/javascript" src="<?=URL?>../assets/js/jquery.dataTables.min.js"></script>
	    <script type="text/javascript" src="<?=URL?>../assets/js/buttons.html5.min.js"></script>
		<script type="text/javascript" src="<?=URL?>../assets/js/buttons.print.min.js"></script>
					
	<script>
						function openNav() 
						{
							document.getElementById("mySidenav").style.width = "360PX";
							$('#sidenavData').load('<?=URL?>help/helpNav',{'pageid' :'annualH'});	
						}
						function closeNav() {
							document.getElementById("mySidenav").style.width = "0";
						}
	
	</script>

<script src="<?=URL?>../assets/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"/>
	<script type="text/javascript">
            $( ".datepicker" ).datepicker({
            	 dateFormat: 'dd-mm-yy',
            	 minDate:new Date()
            });
			
       </script>
	<script type="text/javascript">
    	$(document).ready(function() {
		/*	var minDate = moment();
			//var start = moment().subtract(29, 'days');
			//var end = moment();
			var start = moment().subtract(7, 'days');
			var end = moment().subtract(1,'days');
			function cb(start, end) {
				$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
			}
			$('#reportrange').daterangepicker({
				maxDate:minDate,
				startDate: start,
				endDate: end,
				ranges: {
				   'Today': [moment(), moment()],
				   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				   'This Month': [moment().startOf('month'), moment().endOf('month')],
				   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				}
			}, cb);
			cb(start, end);
			
			*/
			
			
			var table=$('#example').DataTable( {
				   // "scrollX": true,
				    "searchable": false,
					"order": [[ 2, "desc" ]],
					 dom: 'Bfrtip',
					 "bDestroy": true,// destroy data table before reinitializing
					buttons: [
						'pageLength','csv','excel','copy','print',
						{
							"extend":'colvis',
							"columns":':not(:last-child)',
						}
					],
					columnDefs: [ { orderable: false, targets: [5]}],
				"contentType": "application/json",
				"ajax": "<?php echo URL;?>admin/getAllHolidays",
				//"ajax": "<?php echo URL;?>admin/getAllHolidays",
				"columns": [
					{ "data": "name" },
					{ "data": "description" },
					{ "data": "from" },
					{ "data": "to" },
					{ "data": "days" },
					{ "data": "action" }
				]
			});
			
			
			$('#reportrange').on('DOMNodeInserted',function(){ //alert();
			var range=$('#reportrange').text();
			
			var table=$('#example').DataTable( {
				   // "scrollX": true,
				    "searchable": false,
					"order": [[ 2, "desc" ]],
					 dom: 'Bfrtip',
					 "bDestroy": true,// destroy data table before reinitializing
					buttons: [
						'pageLength','colvis','csv','excel','copy','print'
					],
				"contentType": "application/json",
				"ajax": "<?php echo URL;?>admin/getAllHolidays",
				//"ajax": "<?php echo URL;?>admin/getAllHolidays",
				"columns": [
					{ "data": "name" },
					{ "data": "description" },
					{ "data": "from" },
					{ "data": "to" },
					{ "data": "days" },
					{ "data": "action" }
				]
			});
			});






			  $('#save').click(function(){
				   var name=$('#name1').val().trim();
				   var fromdate=$('#from').val();
				   var todate=$('#to').val();
				   var desc=$('#desc').val().trim();
				  if(name==''){
					  $('#name1').focus();
						doNotify('top','center',3,'Please enter the holiday Name.');
					  return false;
				  }
				   // if(desc==''){
					  // $('#name').focus();
						// doNotify('top','center',3,'Please enter the description.');
					  // return false;
				  // }
				  if(fromdate==''){
					  $('#from').focus();
						doNotify('top','center',3,'Please Enter the From date.');
					  return false;
				  }
				  if(todate==''){
					  $('#to').focus();
						doNotify('top','center',3,'Please Enter the To date.');
					  return false;
				  }

				  if(fromdate > todate){
   				// alert("Invalid date range!!!!  From date cannot be greater than To date.");

   				doNotify('top','center',4,'Invalid date range!  From date cannot be greater than To date.');
 						  return false;
							}
							

				 
				   
				   $.ajax({url: "<?php echo URL;?>admin/addHoliday",
						data: {"name":name,"from":fromdate,"to":todate,"desc":desc},
						success: function(result){
							//alert(result);
							result=JSON.parse(result);
							if(result.afft){
							//if(result==1){
								doNotify('top','center',2,'Holiday Added Successfully.');
								$('#add').modal('hide');
								 table.ajax.reload();
							}
							// else if(result==2)
							// {
								// doNotify('top','center',4,'Holiday Name should not be same');
								
								
							// }
							// else if(result==3)
							// {
								// doNotify('top','center',4,'Holiday Date  should not be same');
							// }
							else
								doNotify('top','center',4,'Holiday Name or Holiday Date should not be same');
								document.getElementById('editForm').reset();
								$('#add').modal('hide');
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });

             $('#from').datetimepicker({ minDate: new Date() }); 
             $('#to').datetimepicker({ minDate: new Date() }); 
        
			});  
			$('#saveE').click(function(){
				
				 var name=$('#nameE').val().trim();
				   var fromdate=$('#fromE').val();
				   var todate=$('#toE').val();
				   var desc=$('#descE').val().trim();
				   var sid=$('#sid').val();

				   

				  if(name==''){
					  $('#nameE').focus();
					  $('#nameE').val("");
						doNotify('top','center',4,'Please enter the holiday Name.');
					  return false;
				  }
				  if(fromdate==''){
					  $('#fromE').focus();
						doNotify('top','center',4,'Please enter the date from.');
					  return false;
				  }

				  if(todate==''){
					  $('#toE').focus();
						doNotify('top','center',4,'Please enter the date to.');
					  return false;
				  }
				  if(fromdate > todate){
   				// alert("Invalid date range!!!!  From date cannot be greater than To date.");
   					// $('#toE').focus();
   					// $('#fromE').focus();
   				doNotify('top','center',4,'Invalid date range!  From date cannot be greater than To date.');
 						  return false;
							}
						

				  

				  

							
				  // if(desc==''){
					  // $('#name').focus();
						// doNotify('top','center',4,'Please enter the description.');
					  // return false;
				  // }
				   $.ajax({url: "<?php echo URL;?>admin/editHoliday",
						data: {"sid":sid,"name":name,"from":fromdate,"to":todate,"desc":desc},
						success: function(result){
							if(result==1){
								doNotify('top','center',2,'Holiday Updated Successfully.');
								$('#edit').modal('hide');
								 table.ajax.reload();
							}
							else
								doNotify('top','center',2,'Holiday updated successfully.');
								document.getElementById('editForm').reset();
								$('#edit').modal('hide');
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			}); 
			
			$(document).on("click", "#del", function () 
			{
				var id=$('#del_sid').val();
				// alert(id);
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
				//alert("hyy");
				
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
	<script>
		$(document).ready(function(){
		$(".toggle-sidebar").click(function(){
		// if($(".t2").is(':hidden'))
	 //      setTimeout(function(){
		$("#sidebar").toggleClass("collapsed t2");
		$("#content").toggleClass("col-md-9");
		$("#sidebar").load('<?=URL?>help/helpnav',{'pageid':'annualH'});
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
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<script>

	// data-dissmiss modal with reset value in edit holiday section
 $(document).ready(function()
     {
    $('#close1').on('click', function () {
  $('#editForm').trigger("reset");
    console.log($('#editForm'));
 })
  });

// cannot delete

	$(document).on("click", ".cant23", function () 
			{
				var id=$('#del_sid').val();
				$.ajax({url: "<?php echo URL;?>admin/holiday",
						data: {"sid":id},
						success: function(result){
							if(result){
								
								doNotify('top','center',4,'This event cannot be deleted as it is a past event.');
								 table.ajax.reload();
							}else{
								
								doNotify('top','center',4,'There may error(s) in deleting holiday.');
							}
						
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});

	// cannot edit

	$(document).on("click", ".cant12", function () 
			{
				var id=$('#del_sid').val();
				$.ajax({url: "<?php echo URL;?>admin/holiday",
						data: {"sid":id},
						success: function(result){
							if(result){
							
								doNotify('top','center',4,'This event cannot be edited as it is a past event.');
								 table.ajax.reload();
							}else{
								
								doNotify('top','center',4,'There may error(s) in editing holiday.');
							}
						
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});

</script>



        


</html>
