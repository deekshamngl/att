<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link href="<?=URL?>../assets/css/bootstrap-timepicker.min.css" rel="stylesheet"/>
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="cache-control" content="no-cache">
	<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />
	<title>Shifts</title>
	<style>
		.red{
			 color:red;
			 font-weight:'bold';
			 font-size:16px;
		  }
		.deleteShift
		{
			cursor:pointer;
		}
        .t2{
			display: none;
		}
	</style>
	<style>
		
	
	</style>
</head>
<body ng-app ="adminapp"  ng-controller="attroasterCtrl" >
<div class="wrapper">
		<?php
			$data['pageid']=4;
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
	                                <p class="category" style="color:#ffffff;font-size:17px;" > Shifts</p>
									<a rel="tooltip" rel="tooltip"  data-placement="bottom" title="Help" class="btn btn-success btn-sm  toggle-sidebar pull-right" style="position:relative;margin-top:-30px;" >
									<i class="fa fa-question"></i></a>
	                            </div>
	                            <div class="card-content">
									<div id="typography">
										<div class="title">
											<div class="row">
												<div class="col-md-8" style="margin-top:-10px;" >
													<h3>Manage Shifts</h3>
												</div>
				            	            <div class="col-md-4 text-right">
				                       
												<a href="<?php echo URL; ?>Admin/addShift" class="btn btn-sm btn-success" title= "Add a shift" >	
												<i class="fa fa-plus"> Add</i>
												</a> 
										
											</div>
												<div class="col-md-4 text-right">
											</div>
											</div>
											
										</div>
										
										
										<div class="row" style="overflow-x:scroll;">
											<table id="example" class="display table" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>Shifts</th>
													<th>Time In</th>
													<th>Time Out</th>
													<th>Break Start Time</th>
													<th>Break  End Time</th>
													<th>Time In Grace</th>
													<th>Time Out Grace</th>
													<th>Shift Type</th>
													<th>Shift Hours</th>
													<th>Work Hours</th>
													<th width="7%" style="background-image:none"!important>Status</th>
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
	        
<div class="col-md-3 t2" id="sidebar" style=" margin-top:100px;">

</div>
	       
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
<!-- Modal open add shift-->
<div id="addShift" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <form>
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Add Shift</h4>
      </div>
      <div class="modal-body">
		<form id="shifrFrom">
			<div class="row">
				<div class="col-md-12">
					<strong><span class="text-success">Shift Starts and Ends whithin</span></strong>
					<label class="checkbox-inline">
						<input  name="shifttype" type="radio" checked='true' value="1"><b> Single day</b>
					</label>
					<label class="checkbox-inline">
						<input  name="shifttype" type="radio" value="2"><b> Multiple day </b>
					</label>
				</div>
				
				<div class="col-md-12">
					<div class="form-group label-floating">
						<label class="control-label" id="shiftNameLable">Shift Name <span class="red"> *</span></label>
						<input type="text" id="shiftName" class="form-control"  >
					</div>
				</div>
				
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Time In  <span class="red"> *</span></label>
						<input type="text" id="timeIn"  class="form-control timepicker" >
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Time Out  <span class="red"> *</span></label>
						<input type="text" id="timeOut"   class="form-control timepicker" >
					</div>
				</div>
			</div>
			<!--<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">TimeIn Grace</label>
						<input type="text" id="timeInGrace" class="form-control timepicker" >
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">TimeOut Grace</label>
						<input type="text" id="timeOutGrace" class="form-control timepicker" >
					</div>
				</div>
			</div>-->
			<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label"> Break Time Start<span class="red"> *</span></label> 
						<input type="text" id="timeInBreak" class="form-control timepicker" >
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Break Time End<span class="red"> *</span></label> 
						<input type="text" id="timeOutBreak" class="form-control timepicker" >
					</div>
				</div>
			</div>
			<!--<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">BreakIn Grace</label>
						<input type="text" id="breakInGrace" class="form-control timepicker" >
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">BreakOut Grace</label>
						<input type="text" id="breakOutGrace" class="form-control timepicker" >
					</div>
				</div>
			</div>-->
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
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="save" class="btn btn-success">Save</button>
        <button type="reset" class="btn btn-success">Reset</button>
      </div>
    </div>
	</form>
  </div>
</div>
<!---modal close--->
<!------Edit Shift modal start------------>
<div id="addShiftE" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Update Shift</h4>
      </div>
      <div class="modal-body">
        
		
		<form id="shifrFrom">
			<input type="hidden" id="sid" />
			<div class="row">
				<div class="col-md-12">
					<div class="form-group label-floating">
						<label >Shift Name <span class="red"> *</span></label>
						<input type="text" id="shiftNameE" class="form-control" >
					</div>
				</div>
				
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Time In <span class="red"> *</span></label>
						<input type="text"   id="timeInE"  class="form-control timepicker" disabled>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Time Out <span class="red"> *</span></label>
						<input type="text" id="timeOutE"  class="form-control timepicker" disabled >
					</div>
				</div>
			</div>
			<!--<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">TimeIn Grace</label>
						<input type="text" id="timeInGraceE" class="form-control timepicker" >
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">TimeOut Grace</label>
						<input type="text" id="timeOutGraceE" class="form-control timepicker" >
					</div>
					</div>
			</div>-->
			<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">TimeIn Break <span class="red"> *</span></label>
						<input type="text" id="timeInBreakE" class="form-control timepicker" disabled>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">TimeOut Break <span class="red"> *</span></label>
						<input type="text" id="timeOutBreakE" class="form-control timepicker"disabled >
					</div>
				</div>
			</div>
		     <!--<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">BreakIn Grace</label>
						<input type="text" id="breakInGraceE" class="form-control timepicker" >
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">BreakOut Grace</label>
						<input type="text" id="breakOutGraceE" class="form-control timepicker" >
					</div>
				</div>
			</div>-->
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
		</form>
		
		
		
      </div>
      <div class="modal-footer">
        <button type="button" id="saveE"  class="btn btn-success">Update</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!------Edit Shift modal close------------>
<!-----delete shift start--->
<div id="delShift" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Delete Shift</h4>
      </div>
      <div class="modal-body">		
		<form>
			<input type="hidden" id="del_sid" />
			<div class="row">
				<div class="col-md-12">
					<h4>Do you want to delete this Shift "<span id="sna"></span>" ?</h4>
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
<!-----delete shift close--->


<!-----------update shift simultaneously of more than one employee---------------->



<div id="updateShift" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Assign Employee(s)</h4>
      </div>
      <div class="modal-body">		
	<form>
		<input type="hidden" id="uid" />

		<p> Select the employee(s) to assign this shift </p>
			
			<div class="panel">
					<div class="panel-body" >
						<div class="row">
							 <div class="well" style="max-height: 300px;overflow: auto;">
									<ul  class="list-group checked-list-box" id="check-list-box">
									
										<div ng-repeat="c in emparray" >
											<li class=" list-group-item" data-color="success" id="{{c.id}}" ng-click="getchecklistid($index)">
												<label >{{$index+1}}.  {{c.name}} </label>
												
											</li>	
										</div>							
									</ul>
							</div>
						</div>
						
					</div>
				</div>
			
			
			<div class="clearfix"></div>
	</form>
      </div>
      <div class="modal-footer">
        <button type="button"  class="btn btn-success" ng-click="SaveEmpList(1)">Assign</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>




</body>

<div id="mySidenav" class="pull-right sidenav" style="background-image:url(<?=URL?>../assets/img/bg7.jpg);">

						<div class="helpHeader" ><span><b>&nbsp;&nbsp;<i style="font-size:24px; color:black;"class="fa fa-question-circle" ></i ></b></span><a style="color:black;" href="javascript:void(0)" class="closebtn text-right" onclick="closeNav()">x </a></div>
						<div id="sidenavData" class="sidenavData">
						</div>
					</div>
	<script>
	
	function openNav() {
							document.getElementById("mySidenav").style.width = "360PX";
							
							
							$('#sidenavData').load('<?=URL?>admin/helpNav',{'pageid': 'shiftH'});	
						}
						function closeNav() {
							document.getElementById("mySidenav").style.width = "0";
						}
			//$("#mySidenav").toggleClass("collapsed");
			//$("#content").toggleClass("col-md-12 col-md-9");	
	
	</script>
 
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
	<script type="text/javascript" src="<?=URL?>../assets/js/angular.min.js"></script>
		<script type="text/javascript" src="<?=URL?>../assets/js/angular-datatables.min.js"></script>
		<!--<script type="text/javascript" src="<?=URL?>../assets/js/attRoaster.js"></script>-->
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>
		
		
	<script type="text/javascript">
            $('.timepicker').timepicker();
       </script>
	<script type="text/javascript">
    	$(document).ready(function(){
			var table=$('#example').DataTable( {
				//"scrollX": true,
				"order": [[ 1, "desc" ]],
					"orderable": false,
					//"scrollX": true,
					"columnDefs": [ {
						"searchable": false,
						"orderable": false,
						"targets"  : "no-sort",
						"visible": false, "targets": [5,6] 
						//"className": 'noVis'
					}],
				 dom: 'Bfrtip',
					"buttons": [
					'pageLength','csv','excel','copy','print',
					{
						"extend":'colvis',
						"columns":':not(:last-child)',
					}
					
				],
				
				"contentType": "application/json",
				"ajax": "<?php echo URL;?>admin/getAllShift",
				"columns": [
					{ "data": "name" },
					{ "data": "timein" },
					{ "data": "timeout" },
					//{ "data": "timeingrace"},
					//{ "data": "timeoutgrace" },
					{ "data": "timeinbreak" },
					{ "data": "timeoutbreak" },
					{ "data": "timeingrace" },
					{ "data": "timeoutgrace" },
					{ "data": "shifttype" },
					{ "data": "shifthpurs" },
					{ "data": "workhours" },
					{ "data": "status" },
					{ "data": "action" }
				]
			} );
			  $('input.timepicker').timepicker();
			  
			  $('#save').click(function(){
				   if($('#shiftName').val()==''){
					  $('#shiftName').focus();
						doNotify('top','center',4,'Please enter the shift name.');
					  return false;
				  }
				  var sna=$('#shiftName').val();
				   var ti=$('#timeIn').val();
				   var to=$('#timeOut').val();
				   var tib=$('#timeInBreak').val();
				   var tob=$('#timeOutBreak').val();
				   var tig=$('#timeInGrace').val();
				   var tog=$('#timeOutGrace').val();
				   var bog=$('#breakInGrace').val();
				   var big=$('#breakOutGrace').val();
				   var sts=$('#status').val();
				  
				  
				  ////////////////////////////////
				   var shifttype='';
				   shifttype=$("input[name='shifttype']:checked").val();
				   if(shifttype==0 || shifttype==''){ 
					doNotify('top','center',4,'Please select the shift type.');
					return false;
				   }
  				    var fromdt="2013/05/29 "+ti;
					var todt="2013/05/29 "+to;
					var tot="2013/05/29 24:00:00";
					var frm = new Date(Date.parse(fromdt));
					var to1 = new Date(Date.parse(todt));
					var tot1 = new Date(Date.parse(todt));
					
					var diff = (frm - to1) / 60000; //dividing by seconds and milliseconds
					var minutes = (diff % 60).toString();
					var hours = (((diff - minutes) / 60).toString()).replace('-','');
					var shiftHours='';
				   var sht='';
				  if(minutes=='60')
						{
							hours=(parseInt(hours)+1).toString();
							minutes='00';
						}
				   if(shifttype==1){
					   sht='Same Day';
					   
					    if(ti == to){
						    alert("Time In and Time Out can not be same for the shift");   
						  return false;
					   }
					   
					   if (frm > to1){
						alert("Time In can not be greater than Time Out for Single day shift.");   
						  return false;
					   }
							//alert(hours);
						if(hours >= 16)
						{
							alert("you can not add more than 16 hours.");
							return false;
						}
				   }
				   if(shifttype==2){
						sht='Two Days';
						
						if(ti == to){
						    alert("Time In and Time Out can not be same for the shift");   
						  return false;
					   }
						if (frm < to1){
						alert("Time Out can not be greater than Time In for Multiple day shift.");   
						  return false;
					   }
					  	//alert(hours);
						if(hours >= 16)
						{
					alert("You have to add the shift of less than 16 Hours, Eg.15:59 hr");
							return false;
						}
				   }
				    
				
					shiftHours = hours+":"+minutes;
				  if(!confirm("You are going to register a new shift "+sna+" of "+shiftHours +" hrs, which will start/end within "+sht+" \n Do you want to create this shift?"))
					return false;
				  ////////////////////////////////

				   
				   $.ajax({url: "<?php echo URL;?>admin/registerShift",
						data: {"sna":sna,"ti":ti,"to":to,"tib":tib,"tob":tob,"tig":tig,"tog":tog,"bog":bog,"big":big,"sts":sts,"shifttype":shifttype},
						success: function(result){
							if(result == 1){
								doNotify('top','center',2,'Shift Added Successfully.');
								$('#addShift').modal('hide');
								document.getElementById('shifrFrom').reset();
								 table.ajax.reload();
							}else if(result== 2){
								doNotify('top','center',3,'Shift '+sna+'  already exist.');
															
							}
							else{
								doNotify('top','center',4,'There may error(s) in creating shift, try later.');
								document.getElementById('shifrFrom').reset();
								$('#addShift').modal('hide');
							}
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});  
			$('#saveE').click(function(){
				  if($('#shiftNameE').val().trim() == ''){
					  $('#shiftNameE').focus();
						doNotify('top','center',4,'Please enter the shift name.');
					  return false;
				  }
				   var sid=$('#sid').val();
				   var sna=$('#shiftNameE').val().trim();
				   var ti=$('#timeInE').val();
				   var to=$('#timeOutE').val();
				   var tib=$('#timeInBreakE').val();
				   var tob=$('#timeOutBreakE').val();
				   var tig=$('#timeInGraceE').val();
				   var tog=$('#timeOutGraceE').val();
				   var bog=$('#breakInGraceE').val();
				   var big=$('#breakOutGraceE').val();
				   var sts=$('#statusE').val();
				   $.ajax({url: "<?php echo URL;?>admin/editShift",
						data: {"sid":sid,"sna":sna,"ti":ti,"to":to,"tib":tib,"tob":tob,"tig":tig,"tog":tog,"bog":bog,"big":big,"sts":sts},
						success: function(result){
							if(result==1){
								doNotify('top','center',2,'Shift Updated Successfully.');
								$('#addShiftE').modal('hide');
								document.getElementById('shifrFrom').reset();
								 table.ajax.reload();
							}else if(result==2){
								doNotify('top','center',4,"Shift "+sna+" already exist. ");
							}
							else{
								doNotify('top','center',3,"No changes Found.");
								document.getElementById('shifrFrom').reset();
								$('#addShiftE').modal('hide');
							}
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			}); 
			
			$(document).on("click", "#delete", function () {
				var id=$('#del_sid').val();
				$.ajax({url: "<?php echo URL;?>admin/deleteShift",
						data: {"sid":id},
						success: function(result){
							result=JSON.parse(result);
							if(result.afft)
							{
								$('#delShift').modal('hide');
								doNotify('top','center',2,'Shift deleted successfully.');
								 table.ajax.reload();
							}

							else{
								$('#delShift').modal('hide');
								doNotify('top','center',4,' can not be delete, It is used in '+result.attn+' attendence(s) and currently assigned to '+result.emp+' employee(s) and attendance marked by '+result.arc+' employess.');
							}
						
						 },
						error: function(result)
						 {
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});
			
		});
			$(document).on("click", ".editShift", function () {
				$('#shiftNameLableE').text('');;
				$('#shiftNameE').attr('placeholder',"");
				$('#sid').val($(this).data('sid'));
				$('#shiftNameE').val($(this).data('name'));
				$('#timeInE').val($(this).data('ti'));
				$('#timeOutE').val($(this).data('to'));
				$('#timeInBreakE').val($(this).data('tib'));
				$('#timeOutBreakE').val($(this).data('tob'));
				$('#timeInGraceE').val($(this).data('tig'));
				$('#timeOutGraceE').val($(this).data('tog'));
				$('#breakInGraceE').val($(this).data('big'));
				$('#breakOutGraceE').val($(this).data('bog'));
				$('#statusE').val($(this).data('sts'));	
			});
			$(document).on("click", ".deleteShift", function () {
				$('#del_sid').val($(this).data('sid'));
				$('#sna').text($(this).data('sname'));
			});
			
		
	</script>
<script>
		$(document).ready(function () {
			$(".toggle-sidebar").click(function () {
			// if($(".t2").is(':hidden'))
	  //           setTimeout(function(){
				$("#sidebar").toggleClass("collapsed t2");
				$("#content").toggleClass("col-md-9");
				$("#sidebar").load('<?=URL?>admin/helpNav',{'pageid': 'shiftH'});
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
	<script>
	var app = angular.module('adminapp', []);
	app.controller('attroasterCtrl', function($scope, $http, $timeout) {
		$scope.hastrue=false;
		$scope.GetEmpList = function($shiftid)
		  {
			$scope.emparray=[];
			$scope.shiftid=$shiftid;
			$scope.hastrue=true;
			var xsrf = $.param({shiftid: $scope.shiftid});
			$http({
				url: 'getemployeebyshift',
				method: "POST",
				data: xsrf,
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			}).success(function (data, status, headers, config){
				
					
					$scope.emparray=data.data;
					console.log(data.data);
					setTimeout(function(){
						$timeout(function(){	$scope.getrow();}, 500); 
					}, 1000);
				
				$scope.hastrue=false;
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
		}
////////////List group item function ///////////////
 $scope.getrow= function ($index) {
	 //alert($index);
     $('.list-group.checked-list-box .list-group-item').each(function () {
        
        // Settings
        var $widget = $(this),
            $checkbox = $('<input type="checkbox" class="hidden" value="'+$index+'" id="'+$index+ 'checked"/>'),
            color = ($widget.data('color') ? $widget.data('color') : "primary"),
            style = ($widget.data('style') == "button" ? "btn-" : "list-group-item-"),
            settings = {
                on: {
                    icon: 'fa fa-check-square-o'
                },
                off: {
                    icon: 'fa fa-square-o'
                }
            };
            
        $widget.css('cursor', 'pointer')
        $widget.append($checkbox);

        // Event Handlers
        $widget.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateDisplay();
        });
        $checkbox.on('change', function () {
            updateDisplay();
        });
        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');
//console.log(isChecked);
            // Set the button's state
            $widget.data('state', (isChecked) ? "on" : "off");
				
            // Set the button's icon
            $widget.find('.state-icon')
                .removeClass()
                .addClass('state-icon ' + settings[$widget.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $widget.addClass(style + color + ' active');
            } else {
                $widget.removeClass(style + color + ' active');
            }
        }
		// Initialization
        function init() {
            
            if ($widget.data('checked') == true) {
                $checkbox.prop('checked', !$checkbox.is(':checked'));
            }
            
            updateDisplay();

            // Inject the icon if applicable
            if ($widget.find('.state-icon').length == 0) {
                $widget.prepend('<span class="state-icon ' + settings[$widget.data('state')].icon + '"></span>');
            }
        }
        init();
    });
};
 
 
 $scope.getchecklistid=function($index){
	//alert($index);
	//var st = $scope.emparray[$index]['sts'];
	if($scope.emparray[$index]['sts'] == 0)
	{
		$scope.emparray[$index]['sts'] = 1;
	}
	else{
		$scope.emparray[$index]['sts'] = 0;
	}
	
	}
 
 
 $scope.SaveEmpList=function($id){
		//alert($id);
		var total= $("#check-list-box li").length;
			//alert(total);
		var selectcheck= $(".list-group-item.list-group-item-success.active").length;
		
		if(selectcheck!=0){
			var json=angular.toJson($scope.emparray);			
			//console.log(json);
			//alert("json"+json);
			//alert("shift"+$scope.shiftid);
			var xsrf = $.param({ shiftid:$scope.shiftid,emplist:json});
			$http({
				url: 'SaveEmpShiftList',
				method: "POST",
				data: xsrf,
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			}).success(function(data, status, headers, config){
				$scope.hastrue = false;
				$('#updateShift').modal('hide');
				
		doNotify('top','center',2,'Shift assigned successfully');
				
			}).error(function(data, status, headers, config){
				$scope.hastrue=false;
			});
		} else {
			
			doNotify('top','center',4,'Please select atleast one employee');
			return false;
	  }
	}
 
 		
	});
	</script>
</html>
