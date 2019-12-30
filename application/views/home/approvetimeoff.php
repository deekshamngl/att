
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<link href="<?=URL?>../assets/css/bootstrap-timepicker.min.css" rel="stylesheet"/>
	<link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Aprrove Time off</title>
	<style>
			.red
			{
				color:red;
				font-weight:'bold';
				font-size:16px;
			}
			.delete
			{
				cursor:pointer;
			}
			.t2
			{
				display: none;
			}
		.bargraph
		{
		display:inline-block;
		margin-top:-8px;
		margin-left:-17px;
		}
	</style>
</head>
<body>
	<div class="wrapper">
		<?php
			$data['pageid']=13;
			$this->load->view('menubar/sidebar',$data);
		?>
	    <div class="main-panel">
			<?php
				$this->load->view('menubar/navbar');
				$data=isset($data)?$data:'';
				$id=isset($id)?$id:0;
				$startdate=isset($this->startdate)?$this->startdate:"Start";
				$enddate=isset($this->enddate)?$this->enddate:"End";
			?>
			
			<div class="content" id="content">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-md-12">
	                        <div class="card">
	                            <div class="card-header" data-background-color="green">
	                                
	                                <p class="category" style="color:#ffffff;font-size:17px;" >Approve Time Off </p>
	                                <a rel="tooltip" style="position:relative;margin-top:-30px;"  data-placement="bottom" title="Help" class="btn btn-success btn-sm pull-right toggle-sidebar ">
                                    <i class="fa fa-question"></i></a>
									
	                            </div>
	                            <div class="card-content">
							
								<div class="row container-fluid" style="margin-top:0px;" >
								<div class="col-sm-3 bargraph" style="margin-top:0px;" >				
								<div id="reportrange" class="pull-left" style="background: #fff; cursor: pointer; padding: 6px; 10px; border: 1px solid #acadaf; width: 104%">
								<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
								<span></span> <b class="caret"></b>
							    </div>
							    </div>
							 
							   <select id="desg" style="height:35px;position:relative; margin-right:3px;" class="col-sm-2">
							   <option value="0">------All Designations------</option>
								<?php
								$data= json_decode(getAllDesg($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++){
									echo '<option  value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								}?>
							    </select>
							
								
								<select id="deprt" style=" height:35px;position:relative; margin-right:3px;" class="col-sm-2">
							    <option value="0">----All Departments----</option>
								<?php
								$data= json_decode(getAllDept($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++)
									echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								?>
							     </select> 
								 
							<!--	<div class="col-sm-2">
                                 <select id="shift" style=" height:35px;position:relative; right:10px;" class="">
							     <option value="0">------All Shifts------</option>
								<?php
								$data= json_decode(getAllShift($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++)
								echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.' ('.substr(($data[$i]->TimeIn),0,5).' - '.substr(($data[$i]->
								TimeOut),0,5).')</option>';
								?></select> 
								</div>-->
							  			
							   <select id="empl" style="height:35px;position:relative;margin-right:3px;" class="col-sm-2">
							   <option value="0">------All Employees------</option>
								<?php
								$data= json_decode(getAllemp($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++){
									echo '<option  value='.$data[$i]->id.'>'.$data[$i]->FirstName.'  '.$data[$i]->LastName.'</option>';
								}?>
							    </select>
								
								
								 <button class="btn btn-success pull-left col-sm-1" style="position:relative;margin-top:-3px;margin-left:10px;" id="getAtt" ><i class="fa fa-search"></i></button>
								 
							 </div>
						
										<div id="typography">
										<div class="row">
											<table id="example" class="display table" cellspacing="0" width="100%">
											<thead>
												<tr style="background-color:#008067;color:#ffffff;" >
													<th style="width:13%;">Employee</th>
													<th style="width:13%;">Applied On</th>
													<th style="width:13%;">Time Off Date</th>
													<th style="width:9%;">From</th>
													<th style="width:9%;">To</th>
													<th style="width:9%;">Duration</th>
													<th style="width:21%;">Reason</th>
													<th style="width:13%;">Status</th>
												<!--	<th>Action</th> -->
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
					<p class="copyright pull-right" style="padding-right:25px;padding-top:0px;" >
					Copyright &copy;<script>document.write(new Date().getFullYear())</script>
					Ubitech Solutions. All rights reserved.
					</p>
				</a>
				</div>
			</footer>
		</div>
		</div>

		<!------Edit Timeoff modal start------------>
<div id="editTimeoff" class="modal fade" role="dialog">
  <div class="modal-dialog ">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Approve Time Off Request  ?<b>&nbsp;&nbsp;<span id="empname" > </span></b></h4>
      </div>
      <div class="modal-body">
        
		<form id="timeoffE">
			<input type="hidden" id="timeoffid" />
			<!--<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label >Time Offfrom<span class="red"> *</span></label>
						<input type="text" id="timefromE" class="form-control timepicker" disabled >
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label >Time to <span class="red"> *</span></label>
						<input type="text" id="timetoE" class="form-control timepicker" disabled >
					</div>
				</div>
			</div>	-->
            <div class="row">
				<div class="col-md-11">
					<div class="form-group label-floating" style="margin-top:42px;" >
						<!-- <input type="hidden" id="#name121"> -->
						<label >Status<span class="red"> *</span></label>
						<select type="hidden" class="form-control" id="timoffstatusE" > 
						  <option type="hidden" value="0" >-Select-</option>
						  <option type="hidden" value="1" >Rejected</option>
						  <option type="hidden" value="2" >Approved</option>
						  <option  type="hidden" value="3" >Pending</option>
						 <!-- <option value="4" >Cancelled</option>
						  <option value="5" >Withdrawn</option>
						  <option value="7" >Escalated</option> -->
						</select>
					</div>
				</div>
				<div class="col-md-11">
					<div class="form-group label-floating">
						<label > Remarks</label>
						<textarea  rows="2" cols="50" class="form-control" id="commentE" name="commentE" > </textarea>
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

<!------Edit location modal close------------>	
		
		

<!-----delete dept start--->
<div id="delDept" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Delete Location</h4>
      </div>
      <div class="modal-body">		
		<form>
			<input type="hidden" id="del_did" />
			<div class="row">
				<div class="col-md-12">
					<h4>Do you want to delete this Location "<span id="dna"></span>" ?</h4>
				</div>
			</div>
			<div class="clearfix"></div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="delete"  class="btn btn-danger">Delete</button>
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
  <script src="<?=URL?>../assets/js/dataTables.buttons.min.js"></script>
 <script type="text/javascript" src="<?=URL?>../assets/js/buttons.flash.min.js"></script>
 <script type="text/javascript" src="<?=URL?>../assets/js/buttons.print.min.js"></script>
 <script type="text/javascript" src="<?=URL?>../assets/js/buttons.html5.min.js"></script>
  
  <script type="text/javascript" src="<?=URL?>../assets/js/jszip.min.js"></script>

<script type="text/javascript" src="<?=URL?>../assets/js/jquery-ui.js"></script>
	 <script type="text/javascript" src="<?=URL?>../assets/js/moment.js"></script>
       <script type="text/javascript" src="<?=URL?>../assets/js/daterangepicker.js"></script>			
					
					
		<?php if(isset($success_sms))
             echo "<script> alert('Your location set successfull.'); </script>";
		 ?>			
					
	<script>
	function openNav() {
							document.getElementById("mySidenav").style.width = "360PX";
							$('#sidenavData').load('<?=URL?>admin/helpNav',{'pageid': 'approvetime'});	
						}
						function closeNav(){
							document.getElementById("mySidenav").style.width = "0";
						}
	
	</script>
   <script type="text/javascript">
            $('.timepicker').timepicker();
			$('input.timepicker').timepicker();
   </script>
	<script type="text/javascript">
	     
		    var timeoffdate = "";
			var table=$('#example').DataTable({
				     aaSorting: [[0, "asc"]],
				   order: [[ 2, 'desc' ]],
				    dom: 'Bfrtip',
					"bDestroy": true,// destroy data table before reinitializing
						//"scrollX": true,
					//"orderable": true,
					//"scrollX": true,
					buttons: [
					'pageLength','csv','excel','copy','print',
					{
						"extend":'colvis',
						"columns":':not(:last-child)',
					}
				],
				"columnDefs": [
				 	{ "orderable": false, "targets": [0, 6,7 ]}
				],
						"contentType": "application/json",
						"ajax": "<?php echo URL;?>Userprofiles/getTimeoffs",
						"columns": [
							{ "data": "name" },
							{ "data": "createddate" },
							{ "data": "date" },
							{ "data": "timefrom" },
							{ "data": "timeto" },
							{ "data": "duration" },
							{ "data": "reason" },
							{ "data": "status" },
							//{ "data": "action" }
						],
						"drawCallback": function ( settings ){
							var api = this.api();
							var rows = api.rows( {page:'current'} ).nodes();
							var last=null;
				 
							api.column(2, {page:'current'} ).data().each( function ( group, i ) {
								if ( last !== group ) {
									$(rows).eq( i ).before(
										'<tr class="group"><td bgcolor="#d59ff2" colspan=16><b>'+group+'</b><b> &nbsp; &nbsp;  </b></td></tr>'
									);
									last = group;
								}
							});
				         }
			    });
		 
		$('#getAtt').click(function(){
			
			var range=$('#reportrange').text();
			//alert(range);
			var shift= 0;//$('#shift').val();
			var deprt=$('#deprt').val();
			var empl=$('#empl').val();
			var desg=$('#desg').val();
			
			table  = $('#example').DataTable({
					aaSorting: [[0, "asc"]],
					order: [[ 2, 'desc']],
					//"scrollX": true,
					 dom: 'Bfrtip',
					 "bDestroy": true,// destroy data table before reinitializing
					buttons: [
						'pageLength','csv','excel','copy','print','colvis',
					],
					"contentType": "application/json",
					"ajax": "<?php echo URL;?>Userprofiles/getTimeoffs?date="+range+"&shift="+shift+"&deprt="+deprt+"&empl="+empl+"&desg="+desg,
				"columnDefs": [
				 	{ "orderable": false, "targets": [0, 6,7] }
				],
					"columns": [
						{ "data": "name" },
						{ "data": "createddate" },
						{ "data": "date" },
						{ "data": "timefrom" },
						{ "data": "timeto" },
						{ "data": "duration" },
						{ "data": "reason" },
						{ "data": "status" },
						//{ "data": "action" }
						
					],
				    "drawCallback": function ( settings ) {
					var api = this.api();
					var rows = api.rows( {page:'current'} ).nodes();
					var last=null;
		 
					api.column(2, {page:'current'} ).data().each( function ( group, i ) {
						if ( last !== group ) {
							$(rows).eq( i ).before(
								'<tr class="group"><td bgcolor="#d59ff2" colspan=16><b>'+group+'</b><b> &nbsp; &nbsp;  </b></td></tr>'
							);
							last = group;
						}
					} );
				  }
				});
			});
			
		$(document).ready(function(){
		$(".toggle-sidebar").click(function(){
		$("#sidebar").toggleClass("collpsed t2");
		$("#content").toggleClass("col-md-9");
		$("#sidebar").load("<?=URL?>admin/helpnav",{'pageid':'approvetime'});
		})
		});
		
		 $('#saveE').click(function(){
			       var comment=$('#commentE').val();
			       var timeoffid=$('#timeoffid').val();
				   var sts=$('#timoffstatusE').val();
				   var name121=$('#empname').text();
				   // var name121=$('#name121').text($(this).data('empname'));
				   // alert($(this).data('empname'));
				   // alert(name121);
				   
				  if($("#timoffstatusE").val()==0)
				    {
					    $('#timoffstatusE').focus();
						doNotify('top','center',3,'Please select the status .');
					    return false; 
				    }
				  else if(sts==3)
				  {
					    $('#timoffstatusE').focus();
						doNotify('top','center',3,'Please select another status .');
					    return false; 
				  }
				   $.ajax({url: "<?php echo URL;?>Userprofiles/updatetimeoff",
						data: {"timeoffid":timeoffid,"sts":sts,"comment":comment,'timeoffdate':timeoffdate,'name121':name121},
						success: function(result){
							// alert(result);
							if(result==1){
								doNotify('top','center',2,'updated successfully..');
								$('#editTimeoff').modal('hide');
								document.getElementById('timeoffE').reset();
								 table.ajax.reload();
							}else if(result==2){
								doNotify('top','center',3,'Time off status has not been updated.');
							}
							else{
							doNotify('top','center',4,'No Changes Found');
							document.getElementById('timeoffE').reset();
								$('#editTimeoff').modal('hide');
							}
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});
	      
		   ////---------date picker
			var minDate = moment();
			//var start = moment().subtract(29, 'days');
			var start = moment().subtract(7,'days');
			var end = moment().subtract(0,'days');
			
			//var start = moment("<?=$startdate?>");
               //var end = moment("<?=$enddate?>");
			function cb(start, end) {
				$('#reportrange span').html(start.format('MMM D, YY') + ' - ' + end.format('MMM D, YY'));
			}
			$('#reportrange').daterangepicker({
				
				//maxDate:minDate,
				minDate:'-4M',
				startDate: start,
				endDate: end,
				ranges: {
				   'Today': [moment(), moment()],
				   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				   'Last 7 Days': [moment().subtract(7, 'days'), moment().subtract(1, 'days')],
				   'Last 30 Days': [moment().subtract(30, 'days'), moment().subtract(1, 'days')],
				   'This Month': [moment().startOf('month'), moment().endOf('month')],
				   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				}
			}, cb);
			cb(start, end);
		
		$(document).on("click", ".edit", function (){
			  
			$('#empname').text('"'+$(this).data('empname')+'"');
			$('#timeoffid').val($(this).data('timeoffid'));
			$('#timefromE').val($(this).data('timefrom'));
			$('#timetoE').val($(this).data('timeto'));
			$('#timoffstatusE').val($(this).data('sts'));
			$('#commentE').val($(this).data('comment'));
            timeoffdate = $(this).data('timeoffdate');		
		 });
		$(document).on("click", ".notedit", function (){
			  	doNotify('top','center',3,'You can not change this TimeOff !');
		 });	
	///////time conversion function 
  
  
		
	</script>
</html>
