
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Absent Employees</title>
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" />
	<!--/*
	 $query = $this->db->query("SELECT `Id`,  `Shift`  FROM ` EmployeeMaster`  WHERE OrganizationId=? AND `Id` Not IN(SELECT `EmployeeId` FROM `AttendanceMaster` ) ",array($orgid)); 
	 */--->
	<style>
	
	
	
		.red{
			color:red;
			font-weight:'bold';
			font-size:16px;
		}
		.delete{
			cursor:pointer;
		}
		td{
			   // width: 7%!important;
				///text-align: center!important;
				max-width:250px;
				word-wrap:break-word;
		}
		div.dt-buttons{
			position:relative;
			float:left;
			margin-left:15px;
			}
		#content {
			
			-webkit-transition: width 0.3s ease;
			-moz-transition: width 0.3s ease;
			-o-transition: width 0.3s ease;
			transition: width 0.3s ease;
		}
		#content .btn-group {
			margin-bottom: 10px;
		}
		
	
		
		.t2
		{display:none;}
		a.depart
	  {
		color: #43a047!important; 
		font-size:16px;
		margin:0px;
		text-decoration: underline!important;
	  }
	</style>
</head>
<body>
	<div class="wrapper">
		<?php
			$data['pageid']=3.1;
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
								 <?php $depart = getDepartment($id) ?><?php if($depart != ""){ ?>
								 <p class="category" style="color:#ffffff;font-size:17px;"> Employees by Department/Site</p>
								 <?php } ?> 
								 <?php $depart = getDepartment($id) ?><?php if($depart == ""){ ?>
								<p class="category" style="color:#ffffff;font-size:17px;"> 	List Of Absent Employees</p>
								 <?php } ?> 
									 <a rel="tooltip" onclick="openNav()"  rel="tooltip"  data-placement="bottom" title="Help" class="btn btn-success btn-sm pull-right toggle-sidebar pull-right " style="position:relative;margin-top:-30px;" >
									  <i class="fa fa-question"></i></a>
	                            </div>
								
	                            <div class="card-content">
									<div id="typography">
										<div class="title">
											<div class="row">
												<div class="col-md-8" style="margin-top:-10px;" >
											      <h3>
												    Absent Employees<?php $depart = getDepartment($id) ?> <?php if($depart != "") echo "in ".$depart." Department/Site"; ?>
												  </h3>
												</div>
										 <?php $depart = getDepartment($id) ?><?php if($depart == ""){ ?>
											<div class="col-md-4">
											
											<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px; 10px; border: 1px solid #ccc;margin-top:10px;">
												<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
												<span></span> <b class="caret"></b>
											</div>
											
											</div>
										<?php } ?>
											
						<div class="col-md-6">
							 <div class="col-md-3">
							 <?php $depart = getDepartment($id) ?><?php if($depart != ""){ ?>
								<a  href="<?=URL?>admin/department?id=<?php echo $id ?>" style="" class="depart">Present</a>&nbsp;|
							 <?php } ?>
							 </div>
						
							
								 <div class="col-md-4">
								 <?php $depart = getDepartment($id) ?><?php if($depart != ""){ ?>
									<a  href="<?=URL?>Dashboard/getLateEmployee?id=<?php echo $id ?>" style="" class="depart">Late Comers</a>&nbsp;|
								 <?php } ?>
								 </div>
							
							
							 <div class="col-md-4">
							 <?php $depart = getDepartment($id) ?><?php if($depart != ""){ ?>
								<a  href="<?=URL?>Dashboard/getearlyEmployee?id=<?php echo $id ?>" style="" class="depart">Early Leavers</a>
							 <?php } ?>
							 </div>
						 <hr/>
						</div> 
						
							<!--<div class="row pull-right" style="margin:0px">
								  <div class="col-md-4"> 
								 <?php $depart = getDepartment($id) ?><?php if($depart != ""){ ?>
								  <button  class="btn btn-sm present"  type="button" >	
								<i class=""> Present  </i>
									</button>
								<?php } ?> 
								  </div> 
						  
								  <div class="col-md-4"> 
								 <?php $depart = getDepartment($id) ?><?php if($depart != ""){ ?>
								  <button  class="btn btn-sm late"  type="button" >	
								<i class=""> Late Comers </i>
									</button>
								<?php } ?> 
								  </div> 
						  
								   <div class="col-md-4"> 
								 <?php $depart = getDepartment($id) ?><?php if($depart != ""){ ?>
								  <button  class="btn btn-sm early"  type="button" >	
								<i class="">Early Leavers</i>
									</button>
								<?php } ?> 
								  </div>
							</div>-->
											
							
							






							
										</div>
										
										<div class="row" style="overflow-x:scroll;">
											<table id="example" class="display table">
											<thead>
												<tr>
													<th>Name</th>
													<th>Code</th>
													<th width="25%">Designation</th>
													<th width="20%" >Date</th>
													<th width="20%"> Department</th>
													<th width="20%">Shift</th>
													<th width="15%">Device</th>
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
		
		<div class="col-md-3 t2" id="sidebar" style="margin-top:100px">

			</div>
		<footer class="footer" >
				<div class="container-fluid" >
					<nav class="pull-left">
						
					</nav>
					<!--<p class="copyright pull-right" style="padding-right:25px;" >
              &copy; <script>document.write(new Date().getFullYear())</script>. Developed by<a href="http://www.ubitechsolutions.com/" target="_blank" > Ubitech Solutions </a></p>-->
			  <a href="http://www.ubitechsolutions.com/" target="_blank" >
					<p class="copyright pull-right" style="padding-right:25px;;padding-top:0px;" >
					Copyright &copy;<script>document.write(new Date().getFullYear())</script>
					Ubitech Solutions. All rights reserved.
					</p>
				</a>
				</div>
			</footer>
	
<!------Edit attendance modal start------------>
<!------Edit attendance modal close------------>
<!-----delete attendance start--->
<!-----delete Attn close--->
</body>
<div id="mySidenav" class="pull-right sidenav" style="background-image:url(<?=URL?>../assets/img/bg7.jpg);">
						<div class="helpHeader"><span ><b>&nbsp;&nbsp;<i style="font-size:24px; color:black;"class="fa fa-question-circle" ></i ></b></span><a style="color:black;" href="javascript:void(0)" class="closebtn text-right" onclick="closeNav()">x</a></div>
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
		<!--
	<script>
		
	function openNav() {
							document.getElementById("mySidenav").style.width = "360PX";
							$('#sidenavData').load('<?=URL?>admin/helpNav',{'pageid': 'attendanceH'});	
						}
						function closeNav() {
							document.getElementById("mySidenav").style.width = "0";
						}
	
	</script>	-->
	<script type="text/javascript">
    	$(document).ready(function() {
			var table= $('#example').DataTable( {
				order: [[ 3, 'desc' ],[ 0, 'asc' ]],
				 dom: 'Bfrtip',
				//scrollX:'true',
				buttons: [
					'pageLength','csv', 'excel','copy','print','colvis'
				],
				"contentType": "application/json",
				//"ajax": "<?php echo URL;?>admin/getAbsent",
				"ajax": "<?php echo URL;?>admin/getAbsent__new?deprt=<?php echo $id; ?>",
				"columnDefs": [
					{ "visible": false, "targets": [1,3,6] }
				],
				"columns": [
					    { "data": "FirstName" },
					    { "data": "code" },
						{ "data": "desg" },
						{ "data": "absentdate"},
						{ "data": "deprt" },
						{ "data": "shift" },
						{ "data": "device" }
				],
				"drawCallback": function ( settings ) {
					var api = this.api();
					var rows = api.rows( {page:'current'} ).nodes();
					var last=null;
		 
					api.column(3, {page:'current'} ).data().each( function ( group, i ) {
						if ( last !== group ) {
							$(rows).eq( i ).before(
								'<tr class="group"><td bgcolor="#d59ff2" colspan=16><b>'+group+'</b><b> &nbsp; &nbsp;  </b></td></tr>'
							);
							last = group;
						}
					} );
				}
			});
			
			
////---------date picker
		//	var start = moment().subtract(29, 'days');
	var minDate = moment();
			//var start = moment().subtract(29, 'days');
			var start = moment().subtract(0,'days');
			var end = moment().subtract(0,'days');
			function cb(start, end) {
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
		$('#reportrange').on('DOMNodeInserted',function(){ 
			var range=$('#reportrange').text();
		//	$('#example').empty();
			$('#example').DataTable({
					//aaSorting: [[0, "asc"]],
					order: [[ 3, 'desc' ],[ 0, 'asc' ]],
					//"scrollX": true,
					 dom: 'Bfrtip',
					 "bDestroy": true,// destroy data table before reinitializing
					buttons: [
						'pageLength','csv','excel','copy','print','colvis'
					],
					"contentType": "application/json",
					//"ajax": "<?php echo URL;?>admin/getAbsent?date="+range,
					"ajax": "<?php echo URL;?>admin/getAbsent__new?date="+range,
					"columnDefs": [
					{ "visible": false, "targets": [1,3,6] }
				],
					"columns": [
						{ "data": "FirstName" },
						{ "data": "code" },
						{ "data": "desg" },
						{ "data": "absentdate" },
						{ "data": "deprt" },
						{ "data": "shift" },
						{ "data": "device" }
						
					],
						"drawCallback": function ( settings ) {
					var api = this.api();
					var rows = api.rows( {page:'current'} ).nodes();
					var last=null;
		 
					api.column(3, {page:'current'} ).data().each( function ( group, i ) {
						if ( last !== group ) {
							$(rows).eq( i ).before(
								'<tr class="group"><td bgcolor="#d59ff2" colspan=16><b>'+group+'</b><b> &nbsp; &nbsp;  </b></td></tr>'
							);
							last = group;
						}
					});
				  }
				} );
			});	
			
			
	$(document).on("click", ".present", function() 
	{
		var id='<?php echo $id; ?>';
    window.location.href = '<?=URL?>admin/department?id='+id; 

    });	
	$(document).on("click", ".late", function() 
	{
		var id='<?php echo $id; ?>';
    window.location.href = '<?=URL?>Dashboard/getLateEmployee?id='+id;

    });	
$(document).on("click", ".early", function() 
	{
		var id='<?php echo $id; ?>';
    window.location.href = '<?=URL?>Dashboard/getearlyEmployee?id='+id;

    });
		});
	</script>
	<script>
		$(document).ready(function(){
		$(".toggle-sidebar").click(function(){
		// if($(".t2").is(':hidden'))
		//    setTimeout(function(){
		$("#sidebar").toggleClass("collapsed t2");
		$(".content").toggleClass("col-md-9");
		$("#sidebar").load('<?=URL?>admin/helpNav',{'pageid': 'absentH'});
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
