
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
	<title>ubiAttendance</title>
	<style>
		.red{
			color:red;
			font-weight:'bold';
			font-size:16px;
		}
		.deleteShift{
			cursor:pointer;
		}
        .t2{
			display: none;
		}
	</style>
	<style>
		
	
	</style>
</head>
 <!-- <body onload="weekfetch()" > -->
<body>
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
	                                <p class="category" style="color:#ffffff;font-size:17px;" >Create a shift</p>
									<a rel="tooltip" rel="tooltip"  data-placement="bottom" title="Help" class="btn btn-success btn-sm  toggle-sidebar pull-right" style="position:relative;margin-top:-30px;" >
									<i class="fa fa-question"></i></a>
	                            </div>
	                            <div class="card-content">
									<div id="typography">
										
								<!-------->
			         <div class="modal-body">
				     	 <form id="shifrFrom">
					     	<div class="row">
							  <div class="col-md-1" ></div>
							  <div class="col-md-10">
								<strong><span class="text-success">Shift Type</span></strong>
								<label class="checkbox-inline" title="Shift which starts & ends on the same date">
									<input  name="shifttype" type="radio" checked='true' value="1"><b> Single Date</b>
								</label>
								<label class="checkbox-inline" title="Shift which ends on a consecutive date & crosses midnight (12:00 AM)">
									<input name="shifttype" type="radio" value="2"><b> Multi Date </b>
								</label>
							 </div>
							 </div>
							 <div class="row">
						    <div class="col-md-1" ></div>
							<div class="col-md-4">
								<div class="form-group label-floating">
									<label class="control-label" id="shiftNameLable">Shift Name <span class="red"> *</span></label>
									<input type="text" id="shiftName" class="form-control"  >
								</div>
							</div>
							<div class="col-md-2" ></div>
							<div class="col-md-4">
							<div class="form-group label-floating" style="">
								<label class="control-label">Status  <span class="red"> *</span></label>
								<select class="form-control" id="status" >
									<option value='1' selected>Active</option>
									<option value='0'>Inactive</option>
								</select>
							 </div>
				          </div>
						</div>
						<div class="row">
						   <div class="col-md-1" ></div>
						  
							<div class="col-md-4">
								<div class="form-group label-floating">
									<label class="control-label">Time In  <span class="red"> *</span></label>
									<input type="text" id="timeIn"  class="form-control timepicker" value="09:00 AM" onchange="myFunction(this.value)">
								</div>
							</div>
							<div class="col-md-2" ></div>
							<div class="col-md-4">
								<div class="form-group label-floating">
									<label class="control-label">Time Out  <span class="red"> *</span></label>
									<input type="text" id="timeOut"   class="form-control timepicker" value="06:00 PM"onchange="myfunc(this.value)">
								</div>
							</div>
						</div>
						<div class="row">
						  <div class="col-md-1" ></div>
							<div class="col-md-4">
								<div class="form-group label-floating">
									<label class="control-label"> Break starts at<span class="red"> *</span></label> 
									<input type="text" id="timeInBreak" class="form-control timepicker" value="01:00 PM" >
								</div>
							</div>
							<div class="col-md-2" ></div>
							<div class="col-md-4">
								<div class="form-group label-floating">
									<label class="control-label">Break ends at<span class="red"> *</span></label> 
									<input type="text" id="timeOutBreak" class="form-control timepicker" value="02:00 PM">
								</div>
							</div>
						</div>

						<div class="row">
						  <div class="col-md-1" ></div>
							<div class="col-md-4">
								<div class="form-group label-floating">
									<label class="control-label">Grace Time In<span class="red"> *</span></label> 
									<input type="text" id="gracetime" class="form-control timepicker"value="09:00 AM" onchange="getDiff()">
								</div>
							</div>
							<div class="col-md-2" ></div>
							<div class="col-md-4">
								<div class="form-group label-floating">
									<label class="control-label">Grace Time Out<span class="red"> *</span></label> 
									<input type="text" id="gracetimeout" class="form-control timepicker"value="06:00 PM"onchange="getDifference()">
								</div>
							</div>
							
						</div>
						<div class="row">
						  <div class="col-md-1" ></div>
						  <div class="col-md-4">
								<div class="form-group label">
									<label class="control-label ">Total Grace Time In</label> 
									<input type="text" id="tgracetime"  class="form-control" readonly="true">
								</div>
							</div>
							
							<div class="col-md-2" ></div>
							<div class="col-md-4">
								<div class="form-group label">
									<label class="control-label ">Total Grace Time out</label> 
									<input type="text" id="tgracetimeout"  class="form-control" readonly="true">
								</div>
							</div>
						</div>
						<br>
						<br>
						<center>
						<div class="card-content"> 
							<div class="row">
								<div class="col-md-1 col-lg-1 col-xl-1">
								</div>
								<div class="col-md-10 col-lg-10 col-xl-10">
									<div class="panel panel-primary">
									  <div class="panel-heading" style="background-color:#05afc4;">
										<b>
											Monthly Shift Calendar
										</b>
									  </div>
									  <div class="panel-body" style="overflow: auto; ">
						<center>
							<table width="100%" class="table table-striped table-hover table-bordered" >
								<tr class="info">
									<th><h4 style="font-weight:bold">Day</h4></th>
									<th><h4 style="font-weight:bold">1<sup>st</sup> Week</h4></th>
									<th><h4 style="font-weight:bold">2<sup>nd</sup> Week</h4></th>
									<th><h4 style="font-weight:bold">3<sup>rd</sup> Week</h4></th>
									<th><h4 style="font-weight:bold">4<sup>th</sup> Week</h4></th>
									<th><h4 style="font-weight:bold">5<sup>th</sup> Week</h4></th>
								</tr>
								<tr>
							<td>Sunday</td>
							<td>
							    <input type="radio" name="weekOne1" value="0"  /> Working  Day  <br/>
								<input type="radio" name="weekOne1" value="2" /> Half Day  <br/>
								<input type="radio" name="weekOne1" value="1" checked="true"/> Off  Day  
								
								
							</td>
							<td>
							  
								<input type="radio" name="weekTwo1" value="0" /> Working  Day   <br/>
								<input type="radio" name="weekTwo1" value="2" /> Half Day  <br/>
								<input type="radio" name="weekTwo1" value="1" checked="true"/> Off  Day  
								
							</td>
							<td>
							    
								<input type="radio" name="weekThree1" value="0" /> Working  Day <br/>
								<input type="radio" name="weekThree1" value="2" /> Half Day  <br/>
								<input type="radio" name="weekThree1" value="1" checked="true"/> Off  Day  
								 
							</td>
							<td>
							    
								<input type="radio" name="weekFour1" value="0" /> Working  Day <br/>
								<input type="radio" name="weekFour1" value="2" /> Half Day  <br/>
								<input type="radio" name="weekFour1" value="1" checked="true"/> Off  Day  
								
							</td>
							<td>
							  
								<input type="radio" name="weekFive1" value="0" /> Working  Day  <br/>
								<input type="radio" name="weekFive1" value="2" /> Half Day  <br/>
								<input type="radio" name="weekFive1" value="1" checked="true"/> Off  Day  
								
							</td>
						</tr>
						<tr>
							<td>Monday</td>
							<td>
							    
								<input type="radio" name="weekOne2" value="0" checked="true" /> Working  Day <br/>
								<input type="radio" name="weekOne2" value="2" /> Half Day  <br/>
								<input type="radio" name="weekOne2" value="1"/> Off  Day  
								
							</td>
							<td>
							  
								<input type="radio" name="weekTwo2" value="0" checked="true"/> Working  Day    <br/>
								<input type="radio" name="weekTwo2" value="2" /> Half Day  <br/>
								<input type="radio" name="weekTwo2" value="1" /> Off  Day  
								 
							</td>
							<td>
							  
								<input type="radio" name="weekThree2" value="0" checked="true"/> Working  Day   <br/>
								<input type="radio" name="weekThree2" value="2" /> Half Day  <br/>
								<input type="radio" name="weekThree2" value="1" /> Off  Day  
								
							</td>
							<td>
							   
								<input type="radio" name="weekFour2" value="0" checked="true"/> Working  Day   <br/>
								<input type="radio" name="weekFour2" value="2" /> Half Day  <br/>
								<input type="radio" name="weekFour2" value="1" /> Off  Day  
								
							</td>
							<td>
							   
								<input type="radio" name="weekFive2" value="0" checked="true"/> Working  Day   <br/>
								<input type="radio" name="weekFive2" value="2" /> Half Day  <br/>
								<input type="radio" name="weekFive2" value="1" /> Off  Day  
								
							</td>
						</tr>
						<tr>
							<td>Tuesday</td>
							<td>
							    
								<input type="radio" name="weekOne3" value="0" checked="true" /> Working  Day  <br/>
								<input type="radio" name="weekOne3" value="2" /> Half Day  <br/>
								<input type="radio" name="weekOne3" value="1"/> Off  Day  
								
							</td>
							<td>
							   
								<input type="radio" name="weekTwo3" value="0" checked="true"/> Working  Day  <br/>
								<input type="radio" name="weekTwo3" value="2" /> Half Day  <br/>
								<input type="radio" name="weekTwo3" value="1" /> Off  Day  
								
							</td>
							<td>
							    <input type="radio" name="weekThree3" value="0" checked="true"/> Working  Day  <br/>
								<input type="radio" name="weekThree3" value="2" /> Half Day  <br/>
								<input type="radio" name="weekThree3" value="1" /> Off  Day  
								
								 
							</td>
							<td>
							  
								<input type="radio" name="weekFour3" value="0" checked="true"/> Working  Day  <br/>
								<input type="radio" name="weekFour3" value="2" /> Half Day  <br/>
								<input type="radio" name="weekFour3" value="1" /> Off  Day  
								
							</td>
							<td>
							   
								<input type="radio" name="weekFive3" value="0" checked="true"/> Working  Day  <br/>
								<input type="radio" name="weekFive3" value="2" /> Half Day  <br/>
								<input type="radio" name="weekFive3" value="1" /> Off  Day  
								
							</td>
						</tr>
						<tr>
							<td>Wednesday</td>
							<td>
							
								<input type="radio" name="weekOne4" value="0" checked="true" /> Working  Day <br/>
								<input type="radio" name="weekOne4" value="2" /> Half Day  <br/>
								<input type="radio" name="weekOne4" value="1"/> Off  Day  
								
							</td>
							<td>
							   
								<input type="radio" name="weekTwo4" value="0" checked="true"/> Working  Day <br/>
								<input type="radio" name="weekTwo4" value="2" /> Half Day  <br/>
								<input type="radio" name="weekTwo4" value="1" /> Off  Day  
								
							</td>
							<td>
							  
								<input type="radio" name="weekThree4" value="0" checked="true"/> Working  Day  <br/>
								<input type="radio" name="weekThree4" value="2" /> Half Day  <br/>
								<input type="radio" name="weekThree4" value="1" /> Off  Day  
								
							</td>
							<td>
							<input type="radio" name="weekFour4" value="0" checked="true"/> Working  Day <br/>
								<input type="radio" name="weekFour4" value="2" /> Half Day  <br/>
								<input type="radio" name="weekFour4" value="1" /> Off  Day  
								<br/>
								
							</td>
							<td>
							    
								<input type="radio" name="weekFive4" value="0" checked="true"/> Working  Day <br/>
								<input type="radio" name="weekFive4" value="2" /> Half Day  <br/>
								<input type="radio" name="weekFive4" value="1" /> Off  Day  
								
							</td>
						</tr>
						<tr>
							<td>Thursday</td>
							<td>
							  
								<input type="radio" name="weekOne5" value="0" checked="true" /> Working  Day  <br/>
								<input type="radio" name="weekOne5" value="2" /> Half Day  <br/>
								<input type="radio" name="weekOne5" value="1"/> Off  Day  
								
							</td>
							<td>
							  
								<input type="radio" name="weekTwo5" value="0" checked="true"/> Working  Day  <br/>
								<input type="radio" name="weekTwo5" value="2" /> Half Day  <br/>
								<input type="radio" name="weekTwo5" value="1" /> Off  Day  
								
							</td>
							<td>
							    
								<input type="radio" name="weekThree5" value="0" checked="true"/> Working  Day <br/>
								<input type="radio" name="weekThree5" value="2" /> Half Day  <br/>
								<input type="radio" name="weekThree5" value="1" /> Off  Day  
								
							</td>
							<td>
							    
								<input type="radio" name="weekFour5" value="0" checked="true"/> Working  Day <br/>
								<input type="radio" name="weekFour5" value="2" /> Half Day  <br/>
								<input type="radio" name="weekFour5" value="1" /> Off  Day  
								
							</td>
							<td>
							   
								<input type="radio" name="weekFive5" value="0" checked="true"/> Working  Day  <br/>
								<input type="radio" name="weekFive5" value="2" /> Half Day  <br/>
								<input type="radio" name="weekFive5" value="1" /> Off  Day  
								
							</td>
						</tr>
						<tr>
							<td>Friday</td>
							<td>
							   
								<input type="radio" name="weekOne6" value="0" checked="true" /> Working  Day <br/>
								<input type="radio" name="weekOne6" value="2" /> Half Day  <br/>
								<input type="radio" name="weekOne6" value="1"/> Off  Day  
								
							</td>
							<td>
							    
								<input type="radio" name="weekTwo6" value="0" checked="true"/> Working  Day <br/>
								<input type="radio" name="weekTwo6" value="2" /> Half Day  <br/>
								<input type="radio" name="weekTwo6" value="1" /> Off  Day  
								
							</td>
							<td>
							  
								<input type="radio" name="weekThree6" value="0" checked="true"/> Working  Day   <br/>
								<input type="radio" name="weekThree6" value="2" /> Half Day  <br/>
								<input type="radio" name="weekThree6" value="1" /> Off  Day  
								 
							</td>
							<td>
							
								<input type="radio" name="weekFour6" value="0" checked="true"/> Working  Day     <br/>
								<input type="radio" name="weekFour6" value="2" /> Half Day  <br/>
								<input type="radio" name="weekFour6" value="1" /> Off  Day  
								
							</td>
							<td>
							   
								<input type="radio" name="weekFive6" value="0" checked="true"/> Working  Day  <br/>
								<input type="radio" name="weekFive6" value="2" /> Half Day  <br/>
								<input type="radio" name="weekFive6" value="1" /> Off  Day  
								
							</td>
						</tr>
						<tr>
							<td>Saturday</td>
							<td>
							  
								<input type="radio" name="weekOne7" value="0" checked="true" /> Working  Day  <br/>
								<input type="radio" name="weekOne7" value="2" /> Half Day  <br/>
								<input type="radio" name="weekOne7" value="1"/> Off  Day  
								
							</td>
							<td>
							   
								<input type="radio" name="weekTwo7" value="0" checked="true"/> Working  Day <br/>
								<input type="radio" name="weekTwo7" value="2" /> Half Day  <br/>
								<input type="radio" name="weekTwo7" value="1" /> Off  Day  
								
							</td>
							<td>
							   
								<input type="radio" name="weekThree7" value="0" checked="true"/> Working  Day  <br/>
								<input type="radio" name="weekThree7" value="2" /> Half Day  <br/>
								<input type="radio" name="weekThree7" value="1" /> Off  Day  
								
							</td>
							<td>
							 
								<input type="radio" name="weekFour7" value="0" checked="true"/> Working  Day  <br/>
								<input type="radio" name="weekFour7" value="2" /> Half Day  <br/>
								<input type="radio" name="weekFour7" value="1" /> Off  Day  
								
							</td>
							<td>
								<input type="radio" name="weekFive7" value="0" checked="true"/> Working  Day   <br/>
								<input type="radio" name="weekFive7" value="2" /> Half Day  <br/>
								<input type="radio" name="weekFive7" value="1" /> Off  Day 
							</td>
						</tr>
							</table>
							<div>
							    <!--
								<button id="save" class="btn btn-success">Save</button>
								<a id="clear" href="<?=URL?>Dashboard" onclick="history.go(-1);" class="btn btn-default">Cancel</a> -->
							</div>
						</center>
						</div>
						</div>
						<!---- Submit Button ----->
					  <div class="">
						 <button type="button" id="save" class="btn btn-success">Save</button>
						 <a href="<?php echo URL;?>admin/shifts" class="btn btn-default">Cancel</a>
					  </div>
						</div>
								<div class="col-md-1 col-lg-1 col-xl-1">
								</div>
							</div>
						</div>
					</center>

						  <div class="clearfix"></div>
					    </form>
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
		<script type="text/javascript" src="<?=URL?>../assets/js/moment.js"></script>
		<script type="text/javascript" src="<?=URL?>../assets/js/daterangepicker.js"></script>
		<script type="text/javascript" src="<?=URL?>../assets/js/buttons.flash.min.js"></script>
		<script type="text/javascript" src="<?=URL?>../assets/js/jszip.min.js"></script>
		<script type="text/javascript" src="<?=URL?>../assets/js/buttons.html5.min.js"></script>
		
<script type="text/javascript">
   $('.timepicker').timepicker({defaultTime: ""});
</script>
	<script type="text/javascript">
    	$(document).ready(function(){
			var table=$('#example').DataTable({
				//"scrollX": true,
				"order": [[ 1, "desc" ]],
					"orderable": false,
					//"scrollX": true,
					"columnDefs": 
					[{
						"searchable": false,
						"orderable": false,
						"targets" : "no-sort",
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
					// { "data": "timeingrace" },
					// { "data": "timeoutgrace" },
					{"data": "gracetime"},
					{"data": "tgracetime"},
					{"data": "gracetimeout"},
					{"data": "tgracetimeout"},
					{ "data": "timeinbreak" },
					{ "data": "timeoutbreak" },
					{ "data": "shifttype" },
					{ "data": "shifthpurs" },
					{ "data": "workhours" },
					{ "data": "status" },
					{ "data": "action" },
				]
			} );
			  $('input.timepicker').timepicker();
			  
			  $('#save').click(function(){
				  
				  
				   if($('#shiftName').val().trim() == ''){
					  $('#shiftName').focus();
						doNotify('top','center',4,'Please enter the shift name.');
					  return false;
				  }
				  var sna=$('#shiftName').val().trim();
				   var ti=$('#timeIn').val();
				   // var tgracetime=$('#tgracetime').val();
				   // alert(tgracetime);
				    if(ti == "12:00 AM")
					  {
						ti ="12:01 AM";  
					  }
					  if(ti == "")
					  {
						  doNotify('top','center',4,'Please enter the TimeIn.');
					  }
				   var to=$('#timeOut').val();
				     if(to == "12:00 AM")
					  {
						to = "11:59 PM";  
					  }
					  if(to== "")
					  {
						  doNotify('top','center',4,'Please enter the TimeOut.');
					  }
				   var tib=$('#timeInBreak').val();
				      if(tib == "12:00 AM")
					  {
						tib ="12:01 AM";  
					  }
					  if(tib == "")
					  {
						  doNotify('top','center',4,'Please enter the break Timein.');
					  }
				   var tob=$('#timeOutBreak').val();
				      if(tob == "12:00 AM")
					  {
						tob ="12:01 AM";  
					  }
					  if(tob == "")
					  {
						  doNotify('top','center',4,'Please enter the break TimeOut.');
					  }
					  var tig=$('#gracetime').val();
					  if(tig == ""){
					  	doNotify('top','center',4,'Please enter the Grace Time.');
					  }
					   var gto=$('#gracetimeout').val();
					  if(gto == ""){
					  	doNotify('top','center',4,'Please enter the Grace Time Out.');
					  }

					  
				   // var tig=$('#timeInGrace').val();
				   var tog=$('#timeOutGrace').val();
				   
				   var gracetime=$('#gracetime').val();
				   //var gracetimeout=$('#gracetimeout').val();
				   // var bog=$('#breakInGrace').val();
				   // var big=$('#breakOutGrace').val();
				   // var sts = $("#status").val(); 

				   var tig=$('#gracetime').val();
				   var tog=$('#tgracetime').val();
				   var gto=$('#gracetimeout').val();
				   var tgto=$('#tgracetimeout').val();
				   var bog=$('#breakInGrace').val();
				   var big=$('#breakOutGrace').val();
				   var sts = $("#status").val();
				   // alert(tog);
				   
				   
				  ////////////////////////////////
				   var shifttype='';
				   shifttype=$("input[name='shifttype']:checked").val();
				   if(shifttype==0 || shifttype=='')
				    { 
					 doNotify('top','center',4,'Please select the shift type.');
					  return false;
				   }
				   var fromdt="2013/05/29 "+ti;
					var todt="2013/05/29 "+to;
					var tibdt="2013/05/29 "+tib;
					var grace="2013/05/29 "+gracetime;
					var gracetout="2013/05/29 "+gto;
					//alert(gracetout);
					// alert(fromdt);
					// alert(grace< fromdt);
					
					//var tibdtnewdate="2013/05/30 "+ti;
					
					var tobdt="2013/05/29 "+tob;
					var tot="2013/05/29 24:00:00";
					
					var frm = new Date(Date.parse(fromdt));
					var frmout = new Date(Date.parse(todt));
					var timilli=Date.parse(fromdt);
					var tomilli=Date.parse(todt);
					var frm1 = frm.setHours(frm.getHours()+ 3); //for adding 3 hour 
					var frm2 = frmout.setHours(frmout.getHours()- 3);  
				
					var to1 = new Date(Date.parse(todt));
					var ti1 = new Date(Date.parse(fromdt));
					var grace1 = new Date(Date.parse(grace));
					var grace2 = new Date(Date.parse(gracetout));
					/*alert(grace2);
					 alert (ti1);*/
					var tib1= new Date(Date.parse(tibdt));
					var slicetimeinbreak=tib.slice(-2);
				  //  var tibdtnewdate1= new Date(Date.parse(tibdtnewdate));
					
					var tob1 = new Date(Date.parse(tobdt));
					var slicetimeoutbreak=tob.slice(-2);
					
					var tot1 = new Date(Date.parse(todt));
					var diff = (tomilli- timilli) / 60000; //dividing by seconds and milliseconds
					var minutes = (diff % 60).toString();
					var hours = (((diff - minutes) / 60).toString()).replace('-','');
					var shiftHours='';
					if(minutes=='0'){
					minutes='00'
				}
  				  
				   var sht='';
				  
				   if(shifttype==1)
				   {
					   sht='Same Date';
					   
					    if(ti == to){
						    alert("Time In and Time Out can not be same for the shift");   
						  return false;
					   }
					 
							// alert (frm1);
							// alert (grace1 > frm1);
							// die;
					 if(ti == gto)
					 {
					 	doNotify('top','center',4,'Time In and Grace Time Out can not be same for the shift.');
					    	return false;
					 }	
					 if(to == tig)
					  {
					 	doNotify('top','center',4,'Grace Time In and time out can not be same for the shift.');
					    	return false;
					 }	
					/* if(ti > gto)
					 {
					 	doNotify('top','center',4,'Grace time out cannot be less than time In for Single Date shift.');
					    	return false;
					 }	*/
					   if(grace1 > frm1 ){
					    	doNotify('top','center',4,'Grace time cannot be greater than 3 hours for Single Date shift.');
					    	return false;
					    }
					    if(grace2 < frm2 ){
					    	doNotify('top','center',4,'Grace time out cannot be less than 3 hours for Single Date shift.');
					    	return false;
					    }
					     if (timilli > tomilli)

					   {
							alert("Time In can not be greater than Time Out for Single Date shift.");   
						  return false;
					   }
					   
				   }
				   if(shifttype==2)
				   {
						sht='Multi Date';
						
						if(ti == to)
					  {
						    alert("Shift cannot be greater than 20 hours");   
						  return false;
					   }
					   if (frm < to1)
						{
						alert("Time Out can not be greater than Time In for Multiple Date shift.");   
						return false;
						}
						//  if (frm < to1)
						// {
						// alert("Shift cannot be greater than 20 hours.");   
						// return false;
						// }
						if (tob > to)
							{
						alert("Time Out break can not be greater than Time Out for Multiple Date shift.");   
						return false;
						}

							
						if(grace1 > frm1){
					    	doNotify('top','center',4,'Total Grace Time Cannot be Exceeded by 3 hours ');

					    	return false;
					    }
					    if(grace2 < frm2 ){
					    	doNotify('top','center',4,'Total Grace time out cannot be less than 3 hours for multiple Date shift.');
					    	return false;
					    }

					    if(!(TimeComparison()==undefined))
						{
							return false;
						}
						
					    hours = 24-hours;

						
				   }
				   shiftHours = hours+":"+minutes;
				    
				  if(!confirm("You are going to register a new shift "+sna+" , which will start/end within "+sht+" \n Do you want to create this shift?"))
				   return false;
				
				  ///////////////Start weekoff functionality /////////////////
				  
				  var weekOne=$("input[name='weekOne1']:checked").val();
				  var weekTwo=$("input[name='weekTwo1']:checked").val();
				  var weekThree=$("input[name='weekThree1']:checked").val();
				  var weekFour=$("input[name='weekFour1']:checked").val();
				  var weekFive=$("input[name='weekFive1']:checked").val();
				  var sunday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				   weekOne=$("input[name='weekOne2']:checked").val();
				   weekTwo=$("input[name='weekTwo2']:checked").val();
				   weekThree=$("input[name='weekThree2']:checked").val();
				   weekFour=$("input[name='weekFour2']:checked").val();
				   weekFive=$("input[name='weekFive2']:checked").val();
				  var monday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				   weekOne=$("input[name='weekOne3']:checked").val();
				   weekTwo=$("input[name='weekTwo3']:checked").val();
				   weekThree=$("input[name='weekThree3']:checked").val();
				   weekFour=$("input[name='weekFour3']:checked").val();
				   weekFive=$("input[name='weekFive3']:checked").val();
				  var tuesday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				   weekOne=$("input[name='weekOne4']:checked").val();
				   weekTwo=$("input[name='weekTwo4']:checked").val();
				   weekThree=$("input[name='weekThree4']:checked").val();
				   weekFour=$("input[name='weekFour4']:checked").val();
				   weekFive=$("input[name='weekFive4']:checked").val();
				  var wednesday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				   weekOne=$("input[name='weekOne5']:checked").val();
				   weekTwo=$("input[name='weekTwo5']:checked").val();
				   weekThree=$("input[name='weekThree5']:checked").val();
				   weekFour=$("input[name='weekFour5']:checked").val();
				   weekFive=$("input[name='weekFive5']:checked").val();
				  var thusday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				   weekOne=$("input[name='weekOne6']:checked").val();
				   weekTwo=$("input[name='weekTwo6']:checked").val();
				   weekThree=$("input[name='weekThree6']:checked").val();
				   weekFour=$("input[name='weekFour6']:checked").val();
				   weekFive=$("input[name='weekFive6']:checked").val();
				  var friday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				   weekOne=$("input[name='weekOne7']:checked").val();
				   weekTwo=$("input[name='weekTwo7']:checked").val();
				   weekThree=$("input[name='weekThree7']:checked").val();
				   weekFour=$("input[name='weekFour7']:checked").val();
				   weekFive=$("input[name='weekFive7']:checked").val();
				  var saturday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				//  alert(shifttype);
				  ///////////////End  weekoff functionality /////////////////
				   $.ajax({url: "<?php echo URL;?>admin/registerShift",
						data: {"sna":sna,"ti":ti,"to":to,"tib":tib,"tob":tob,"tig":tig,"bog":bog,"big":big,"sts":sts,"shifttype":shifttype,"sun":sunday,"mon":monday,"tue":tuesday,"wed":wednesday,"thus":thusday,"fri":friday,"sat":saturday,"gto":gto},
						success: function(result){
							//alert(result);
							
							if(result == 1){
								doNotify('top','center',2,'Shift Added Successfully.');
								$('#addShift').modal('hide');
								document.getElementById('shifrFrom').reset();
								 setTimeout(function(){
								  window.location.replace("<?php echo URL;?>admin/shifts");
								 }, 2000);
							}else if(result== 2){
								doNotify('top','center',3,'Shift '+sna+'  already exist');			
							}
							else if(result==50){
								doNotify('top','center',3,'Grace time should be greater than Time in');
							}
							else if(result==60){
								doNotify('top','center',3,'Grace time out should be less than Time out');
							}
							else if(result==44 || result==55){
								doNotify('top','center',3,'Grace time  hours should be greater than Only 1 hours In Timein')
							}
							else if(result== 66)
							{
								doNotify('top','center',3,'Shift hours should be <= 20:00');	
							}
							else if(result== 22)
							{
								doNotify('top','center',3,'TimeIn should be lesser than timeout ');	
							}
							else if(result== 33 || result== 44 || result== 55 )
							{
								doNotify('top','center',3,'Invalid break time');	
							}
							else if(result == 51){
								doNotify('top','center',3,'Grace time out cannot be less than time In for Single Date shift.');
					    	return false;
							}
							else if(result == 52){
								doNotify('top','center',3,'Grace time In cannot be Greater than time Out for Single Date shift.');
					    	return false;
							}
							/*else if(result== 44)
							{
								doNotify('top','center',3,'Invalid break time ');	
							}
							else if(result== 55)
							{
								doNotify('top','center',3,'Invalid break time');	
							}*/
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
		});
		
		/*function CheckValidation( ti, to, tib, tob, shifttype)
		{
			var sna=$('#shiftName').val().trim();
			  if(sna == ''){
					  $('#shiftName').focus();
						doNotify('top','center',4,'Please enter the shift name.');
					  return false;
				  }
				  
				   var ti=$('#timeIn').val();
				    if(ti == "12:00 AM")
					  {
						ti ="12:01 AM";  
					  }
				   var to=$('#timeOut').val();
				     if(to == "12:00 AM")
					  {
						to = "11:59 PM";  
					  }
				   var tib=$('#timeInBreak').val();
				      if(tib == "12:00 AM")
					  {
						tib ="12:01 AM";  
					  }
				   var tob=$('#timeOutBreak').val();
				      if(tob == "12:00 AM")
					  {
						tob ="11:59 PM";  
					  }
			alert(ti);
			alert(to);
			alert(tib);
			alert(tob);
			alert(shifttype);
			
			 $.ajax({url: "<?php echo URL;?>admin/CheckValidation",
						data: {"ti":ti,"to":to,"tib":tib,"tob":tob,"shifttype":shifttype},
						success: function(result){
						   if(result==)
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
		}*/
	</script>
<script>
		$(document).ready(function (){
			$(".toggle-sidebar").click(function (){
			if($(".t2").is(':hidden'))
	            setTimeout(function(){
				$("#sidebar").toggleClass("collapsed t2");
				$("#content").toggleClass("col-md-9");
				$("#sidebar").load('<?=URL?>admin/helpNav',{'pageid': 'shiftH'});
				}, 300);
			
			});
			$('.main-panel').click(function(){
			if(!$(".t2").is(':hidden'))
			{
				 $("#sidebar").toggleClass("collapsed t2");
				 $("#content").toggleClass("col-md-9");
			}
		  });
		});	
	</script>
	
<script>


 function myFunction(gettime){
    document.getElementById("gracetime").value = gettime;

}


 $('.timepicker').timepicker();


function getDiff() {
	setTimeout(function(){
  var timeFrom = $('#gracetime').data('timepicker');
  var timeTO = $('#timeIn').data('timepicker');
 
// debugger;
  var timeFromHH = (timeFrom.hour == 12 && timeFrom.meridian == "AM") ? 0 :
    (timeFrom.hour != 12 && timeFrom.meridian == "PM") ? timeFrom.hour + 12 :
    timeFrom.hour;
  var timeTOHH = (timeTO.hour == 12 && timeTO.meridian == "AM") ? 0 :
    (timeTO.hour != 12 && timeTO.meridian == "PM") ? timeTO.hour + 12 :
    timeTO.hour;

  var timeFromMM = timeFromHH * 60 + timeFrom.minute;
  var timeTOMM = timeTOHH * 60 + timeTO.minute;

  var diffMM = Math.abs(timeTOMM - timeFromMM);
  var diff = Math.floor(diffMM / 60) + "hrs " + (diffMM % 60) + "mins";
  // alert(diff);

  
  $("#tgracetime").val(diff);
  }, 1000);
}
</script>
<script type="text/javascript">
	function myfunc(gettimeout){
    document.getElementById("gracetimeout").value = gettimeout;

}
$('.timepicker').timepicker();
function getDifference(){
	setTimeout(function(){
  var timeoutFrom = $('#gracetimeout').data('timepicker');
  var timeoutTO = $('#timeOut').data('timepicker');

   var timeoutFromHH = (timeoutFrom.hour == 12 && timeoutFrom.meridian == "AM") ? 0 :
    (timeoutFrom.hour != 12 && timeoutFrom.meridian == "PM") ? timeoutFrom.hour + 12 :
    timeoutFrom.hour;
  var timeoutTOHH = (timeoutTO.hour == 12 && timeToutO.meridian == "AM") ? 0 :
    (timeoutTO.hour != 12 && timeoutTO.meridian == "PM") ? timeoutTO.hour + 12 :
    timeoutTO.hour;

  var timeoutFromMM = timeoutFromHH * 60 + timeoutFrom.minute;
  var timeoutTOMM = timeoutTOHH * 60 + timeoutTO.minute;

  var diffMM = Math.abs(timeoutTOMM - timeoutFromMM);
  var difference = Math.floor(diffMM / 60) + "hrs " + (diffMM % 60) + "mins";
  // alert(diff);

  
  $("#tgracetimeout").val(difference);
  }, 1000);
}
</script>

	<script>
		function TimeComparison()
		{
			var ti=$('#timeIn').val();
			
				    if(ti == "12:00 AM")
					  {
						ti ="12:01 AM";  
					  }
			var fromdt="2013/05/29 "+ti;	
			var frm = new Date(Date.parse(fromdt));			  
			var slicetimein=ti.slice(-2);
			
			var tib=$('#timeInBreak').val();
			
				      if(tib == "12:00 AM")
					  {
						tib ="12:01 AM";  
					  }
					  
			var tibdt="2013/05/29 "+tib;
			
			var tib1= new Date(Date.parse(tibdt));
				//alert(tib1);	
			var slicetimeinbreak=tib.slice(-2);
			//alert(slicetimeinbreak);
			
			var to=$('#timeOut').val();
				     if(to == "12:00 AM")
					  {
						to = "11:59 PM";  
					  }
			var todt="2013/05/29 "+to;
			var to1 = new Date(Date.parse(todt));
			var slicetimeout=to.slice(-2);
			//alert(slicetimeout);
			
			var tob=$('#timeOutBreak').val();
				      if(tob == "12:00 AM")
					  {
						tob ="11:59 PM";  
					  }
					  
			
			var tobdt="2013/05/29 "+tob;
			var tob1 = new Date(Date.parse(tobdt));
			//alert(tob1);
			var slicetimeoutbreak=tob.slice(-2);
			
			//alert(slicetimeoutbreak);

			
			
			// var tobsecdate=$('#timeOutBreak').val();
				      // if(tobsecdate == "12:00 AM")
					  // {
						// tobsecdate ="11:59 PM";  
					  // }
					  
			
			// var tobdtsecdate="2013/05/30 "+tobsecdate;
			// var tob1secdate = new Date(Date.parse(tobdtsecdate));
			// var slicetimeoutbreaksecdate=tobsecdate.slice(-2);
			
				/////////////////TimeInBreak////////////////////

							if(slicetimein==slicetimeinbreak)
							{
								if(frm > tib1)
								{
									alert('TimeInBreak should be less then the TimeIn');
									 return false;
								}
							}
							if(slicetimeinbreak==slicetimeout)
							{
								if(tib1 > to1)
								{
									alert('TimeInBreak should be less than the TimeOut');
									return false;
								}
							}

							if(slicetimeinbreak==slicetimeoutbreak)
							{
								if(tib1 > tob1)
								{
									alert('TimeInBreak should be less than the TimeOutBreak');
									return false;
								}
							}
						
			

/////////////////////TimeOutBreak///////////////////////////////////////

							
							
							if(slicetimeout==slicetimeoutbreak)	
									{
										if(to1 < tob1)
										{
										alert('TimeOutBreak should be less than the TimeOut');
										return false;
										}
									}
							
								
							if(slicetimeoutbreak==slicetimein)	
									{
										if(frm < tob1) 
										{
										alert('TimeOutBreak should be less than the TimeIn');
										return false;
										}
									}
							
							// if(slicetimeout!=slicetimeoutbreak)	
									// {
										// if(tob1 > to1)
										// {
										// alert('TimeOutBreak should be less than the TimeOut');
										// return false;
										// }
									// }
									
									// if(tib1!=tob1)
									// {
									// if(slicetimeout!=slicetimeoutbreak)	
									// {
										// if(tob1 > to1)
										// {
										// alert('TimeOutBreak should be less than the TimeOut');
										// return false;
										// }
									// }	
									// }
					
		}
	</script>
	
</html>
