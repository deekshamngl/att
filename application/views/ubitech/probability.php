<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css"/>
	<link rel="stylesheet" href="<?=URL?>../assets/css/fixedColumns.dataTables.min.css"/><link rel="stylesheet" href="<?=URL?>../assets/css/jquery.dataTables.min.css"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" />
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css">
	<title>ubiAttendance</title>
	
	
</head>
<body>

<div class="wrapper">
		<?php
			$data['pageid']=142;
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
	                <div class="card">
	                            <div class="card-header" data-background-color="purple">
	                                <h4 class="title">Probability</h4>
	                                <!-- <p class="category">Organization Settings</p> -->
	                            </div>
	                     <div class="card-content">
							<div id="typography">
								<div class="title">
									<div class="row">
									<div class="col-sm-12" style="margin-top:10px" >
										

										<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px;  border: 1px solid #ccc;">
                              <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                              <span></span> 
							  <b class="caret"></b>
                            </div>
                           <!--  <div class="col-sm-2" >
									  <button class="btn btn-success pull-left" style="position:relative;margin-top:-3px;" id="getAtt" >
									  <i class="fa fa-search"></i></button>
									</div> -->
									</div>
									
									
								    
								
									  
									 
											
									</div>
								</div>
										<div class="row">
											<table id="example" class="display table"  cellspacing="0" width="100%">
											<thead>
												<tr>
												
													<th>Organization Name</th>
													<th>Admin Registration</th>
													<th>Registered Employee</th>
													<th>Employee Punches Attendance</th>
													<th>Edit Or Add Shift</th>
													<th>Ios App Users</th>
													<th>Total</th>
													<!-- <?php echo round(1.95583, 2);?> -->
													
													
													
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
						&copy; <script>document.write(new Date().getFullYear())</script> <a href="#">DESIGNED BY </a>Ubitech Solutions Pvt. Ltd.
					</p>
				</div>
			</footer>
		</div>
	</div>	
	</body>
   <script src="<?=URL?>../assets/js/dataTables.buttons.min.js"></script>                <script src=" https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js
"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
   <script type="text/javascript" src="<?=URL?>../assets/js/moment.js"></script>
	<script type="text/javascript" src="<?=URL?>../assets/js/buttons.print.min.js"></script>
	 <script src="<?=URL?>../assets/js/buttons.colVis.min.js"></script>
	   <!-- <script type="text/javascript" src="<?=URL?>../assets/js/pdfmake.min.js"></script> -->

	  <script type="text/javascript" src="<?=URL?>../assets/js/buttons.html5.min.js"></script>
	  <script type="text/javascript" src="<?=URL?>../assets/js/dataTables.fixedColumns.min.js"></script>
   <script type="text/javascript" src="<?=URL?>../assets/js/daterangepicker.js"></script>

  <script type="text/javascript">
    	$(document).ready(function() {
		
			var table=$('#example').DataTable( {
				   "scrollX": true,
				    // "searchable": true,
					"order": [[ 6, "desc" ]],
					 dom: 'Bfrtip',
					 // "bDestroy": true,// destroy data table before reinitializing
					buttons: [
						'pageLength','csv','excel','copy','print',
						{
							"extend":'colvis',
							"columns":'',
						}
					],
				
				"contentType": "application/json",
				"ajax": "<?php echo URL;?>ubitech/getOrganizationData",
				"columns": [
							{ "data": "orgName"},
							{ "data": "admin"},
							{ "data": "reg"},
							{ "data": "att"},
							{ "data": "shfdesdep"},
							
							{ "data": "plat"},
							{ "data": "probability"}
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
				"ajax": "<?php echo URL;?>ubitech/getOrganizationData?date="+range,
				"columns": [
							{ "data": "orgName"},
							{ "data": "admin"},
							{ "data": "reg"},
							{ "data": "att"},
							{ "data": "shfdesdep"},
							
							{ "data": "plat"},
							{ "data": "probability"}
							]
			});
			});
			});
</script>

<script>
	

				////---------date picker
    //	var start = moment().subtract(29, 'days');
    var minDate = moment();
    var start = moment().subtract(7,'days');;
    var end = moment().subtract(0,'days');;
    function cb(start, end) 
	{
    $('#reportrange span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
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
    ////---------/date picker



				</script>

</html>