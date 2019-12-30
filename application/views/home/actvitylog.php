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
	<title>Activity Log</title>
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
			$data['pageid']= 12.7;
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
	                            
	                                <p style="color:#ffffff;font-size:17px;" class="category">Activity Log</p>
									<a rel="tooltip" style="position:relative;margin-top:-30px;"  data-placement="bottom" title="Help" class="btn btn-success btn-sm pull-right toggle-sidebar ">
								<i class="fa fa-question"></i></a>
	                            </div>
								  <div class="card-content">
									<div id="typography">
										<div class="title">
										
										<div class="row">
											<div class="col-md-12">

												<div class="col-md-4"> &nbsp;</div>
												<div class="col-md-4"> &nbsp;</div>
												
												<div class="col-md-4" style="margin-bottom: 10px;
    padding-right: 0px;" >
						   <!--   <a href="<?php echo URL; ?>admin/markattendance" class="btn btn-sm btn-success" type="button"><i class="fa fa-plus"> Add</i>
							<div class="ripple-container"></div>
							</a> --->
                            <!------------------------------->
                            <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px;  border: 1px solid #ccc;">
                              <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                              <span></span> 
							  <b class="caret"></b>
                            </div>
                            <!--<button class="btn btn-success pull-right" id="getAtt">Submit</button>-->
                            <!------------------------------->
                        </div>




											</div>
										</div>
										
										<div class="row" style="overflow-x:scroll;">
											
											
                    
											<table id="example" class="display table" >
											<thead>
												<tr>
													<th>Activities</th>
													<th >Module</th>
													<th >Users</th>
													<th>Date & Time</th>
												
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
							$('#sidenavData').load('<?=URL?>help/helpNav',{'pageid' :'activitylog'});	
						}
						function closeNav() {
							document.getElementById("mySidenav").style.width = "0";
						}
	
	</script>

<script src="<?=URL?>../assets/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"/>
	<script type="text/javascript">
            $( ".datepicker" ).datepicker();
			
       </script>
	<script type="text/javascript">
    	$(document).ready(function() {
		
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
				"contentType": "application/json",
				"ajax": "<?php echo URL;?>admin/getAllActivity",
				
				"columns": [
					{ "data": "ActionPerformed" },
					{ "data": "Module" },
					{ "data": "LastModifiedById" },
					{ "data": "LastModifiedDate" },
					
				]
			});
			
			
			$('#reportrange').on('DOMNodeInserted',function(){ //alert();
			var range=$('#reportrange').text();
			// alert(range);
			
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
				"ajax": "<?php echo URL;?>admin/getAllActivity?date="+range,
				//"ajax": "<?php echo URL;?>admin/getAllHolidays",
				"columns": [
					{ "data": "ActionPerformed" },
					{ "data": "Module" },
					{ "data": "LastModifiedById" },
					{ "data": "LastModifiedDate" },
					
				]
			});
			});
			  $('#save').click(function(){
				   var name=$('#name').val().trim();
				   var fromdate=$('#from').val();
				   var todate=$('#to').val();
				   var desc=$('#desc').val().trim();
				  if(name==''){
					  $('#name').focus();
						doNotify('top','center',3,'Please enter the holiday Name.');
					  return false;
				  }
				   if(desc==''){
					  $('#name').focus();
						doNotify('top','center',3,'Please enter the description.');
					  return false;
				  }
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
				
				 var name=$('#nameE').val().trim();
				   var fromdate=$('#fromE').val();
				   var todate=$('#toE').val();
				   var desc=$('#descE').val().trim();
				   var sid=$('#sid').val();
				  if(name==''){
					  $('#name').focus();
					  $('#name').val("");
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
		$("#sidebar").load('<?=URL?>help/helpnav',{'pageid':'activitylog'});
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
	

				////---------date picker
    //	var start = moment().subtract(29, 'days');
    var minDate = moment();
    var start = moment();
    var end = moment();
    function cb(start, end) 
	{
    $('#reportrange span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
    }
    $('#reportrange').daterangepicker({
   
    maxDate:minDate,
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
    ////---------/date picker



				</script>


</html>
 


