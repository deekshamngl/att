<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<title>Ubiattendance</title>
	<style>
		.red{
			color:red;
			font-weight:'bold';
			font-size:16px;
		}
		.bargraph{
	display:inline-block;
	margin-top:-8px;
	margin-left:-17px;
	
	}
	div.dt-buttons{
position:relative;
float:left;
margin-left:15px;
}
    		tr {display: block; }
th, td { width: 125px!important; }
tbody { display: block; height: 550px; overflow: auto;} 

thead{
			//background-color: rgb(242,155,20);
			}
			tbody {
				max-height: 300px;
				overflow-y: scroll;
				overflow-x: scroll;
			}
			td{
				white-space: pre-wrap!important;
				
			}
	thead, tbody {
			/// display: table-header-group;
		}
		table td { 
		word-wrap:break-word!important;
		
		}	
		body{
			 position: relative;
		}
		
	   #absenttable tbody td 
	   {
		  width:25%;
		  text-align: left;
	   }
	</style>
</head>
<body>
	<div class="wrapper">
		<?php
			$data['pageid']=7.51;
			$this->load->view('menubar/sidebar',$data);
			$data=isset($data)?$data:'';
		?>
	    <div class="main-panel">
			<?php
				$this->load->view('menubar/navbar');
			?>
			</br>
			  <section class="content" id="printsection">
			<div class="content">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-md-12">
	                        <div class="card">
	                            <div class="card-header" data-background-color="green">
	                                
	                                <p class="category" style="color:#ffffff;font-size:17px;" > Employees Record </p>
								</div>
								
			              
                     <br>
                     <br>
				  <div id="typography">
					<!-----Today Table Start here----->
					<div class="row">
						<div class="col-lg-6 col-md-12">
							<div class="card card-nav-tabs">
								<div class="card-header" data-background-color="green" >
									<div class="nav-tabs-navigation" >
										<div class="nav-tabs-wrapper">
											<div class="row">
											<div class="col-md-2 col-lg-2 col-xs-3 col-sm-2">
												<p class="nav-tabs-title">TODAY</p>
											</div>
											<div>
											<ul class="nav nav-tabs" data-tabs="tabs">
												<li class="active">
													<a href="#profile" data-toggle="tab">
														<i class="fa fa-user fa-2x"></i>
														 <span style="text-transform: capitalize; font-size: 14px; font-family: Helvetica;">Present</span> <span class="badge" id="presentCount1"></span>
													<div class="ripple-container"></div></a>
												</li>
 
												<li class="" >
													<a href="#settings" data-toggle="tab">
														<i class="fa fa-user fa-2x"></i>
														<span style="text-transform: capitalize; font-size: 14px; font-family: Helvetica;">Recent Comers </span>     
													<div class="ripple-container"></div></a>
												</li>
												<li class="">
													<a href="#Absent" data-toggle="tab">
														<i class="fa fa-user fa-2x"></i>
														<span style="text-transform: capitalize; font-size: 14px; font-family: Helvetica;">Absent </span>     
													<div class="ripple-container"></div></a>
												</li>
											</ul>
											</div>
											</div>
										</div>
									</div>
									
								</div>

								<div class="card-content">
									<div class="tab-content">
										<div class="tab-pane active" id="profile">
										<div class="table-responsive">
										<table class="table table-hover" id="presentList11" >
												<thead class="text-warning" style="width:105%;">
													<th>Name</th>
													<th>Designation</th>
													<th>Department</th>
													<th>Shift</th>
													<th>Time In</th>
												</thead>
												<tbody style="max-height:300px;">
													<?php getPresentEmployees();?>
												</tbody>
											</table>
										</div>
										</div>
										<div class="tab-pane" id="messages">
										<div class="table-responsive">
											<table class="table table-hover">
												<thead class="text-warning">
													
													<th>Name</th>
													<th>Department</th>
													<th>Designation</th>
													<th>Shift</th>
													<th>Break On Time</th>
												</thead>
												<tbody style="max-height:300px;">
													<?php getAbsentees();?>
												</tbody>
											</table>
										</div>
										</div>
										<div class="tab-pane" id="settings">
										<div class="table-responsive">
											<table class="table table-hover">
												<thead class="text-warning">
													<th>Name</th>
													<th>Designation</th>
													<th>Department</th>
												    <th>Shift</th>
													<th>Time In</th>
												</thead>
												<tbody style="max-height:300px">
													<?php getRecentComers();?>
												</tbody>
											</table>
										</div>
										</div>
										
										<div class="tab-pane" id="Absent">
										  <div class="table-responsive">
											<table class="table table-hover" id= "absenttable" style="width:100%" >
												<thead class="text-warning">
													
													<th>Name</th>
													<th>Designation</th>
													<th>Department</th>
													<th>Shift</th>
													
													
												</thead>
												<tbody style="max-height:300px">
													<?php getAbsentEmployees();?>
												</tbody>
											</table>
										</div>
										</div>
										
										
										
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-6 col-md-12">
							<div class="card card-nav-tabs">
								<div class="card-header" data-background-color="blue" >
									<div class="nav-tabs-navigation" >
										<div class="nav-tabs-wrapper">
											<div class="row">
											<div class="col-md-2 col-lg-2 col-xs-3 col-sm-2">
												<p class="nav-tabs-title">TODAY</p>
											</div>
											<div>
											<ul class="nav nav-tabs" data-tabs="tabs">
												
												<li class="active">
													<a href="#LateN" data-toggle="tab">
														<i class="fa fa-user fa-2x"></i>
														  <span style="text-transform: capitalize; font-size: 14px; font-family: Helvetica;">Late Comers </span>  
													<div class="ripple-container"></div></a>
												</li>
												
												<li class="">
													<a href="#EarlyN" data-toggle="tab">
														<i class="fa fa-user fa-2x"></i>
														<span style="text-transform: capitalize; font-size: 14px; font-family: Helvetica;">
														Early Leavers   </span>
													<div class="rippleLate-container"></div></a>
												</li>
												<li class="">
													<a href="#Time_OffN" data-toggle="tab">
														<i class="fa fa-user fa-2x"></i>
														<span style="text-transform: capitalize; font-size: 14px; font-family: Helvetica;"> On Time Off   </span>
													<div class="ripple-container"></div></a>
												</li>
											</ul>
											</div>
											</div>
										</div>
									</div>
								</div>

								<div class="card-content">
									<div class="tab-content ">
										<div class="tab-pane active" id="LateN" style="">
										<div class="table-responsive">
											<table class="table table-hover">
												<thead class="text-warning">
													<th>Name</th>
													<th>Designation</th>
													<th>Department</th>
													<th>Shift</th>
													<th>Time In</th>
												</thead>
												<tbody style="max-height:300px">
													<?php getLateEmployee();?>
												</tbody>
											</table>
										</div>
										</div>
										
										<div class="tab-pane" id="EarlyN" style="">
										<div class="table-responsive">
											<table class="table table-hover">
												<thead class="text-warning">
													<th>Name</th>
													<th>Designation</th>
													<th>Department</th>
													<th>Shift</th>
													<th>Time Out</th>
												</thead>
												<tbody style="max-height:300px">
													<?php getEarlyEmployee();?>
												</tbody>
											</table>
										</div>
										</div>
										
										<div class="tab-pane" id="Time_OffN" style="">
										<div class="table-responsive">
											<table class="table table-hover">
												<thead class="text-warning">
													
	                                    	        <th>Name</th>
													<th>Department</th>
													<th>TimeOffStart</th>
													<th>TimeOffEnd</th>
	                                    	        <th>TotalTime</th>
												</thead>
												<tbody style="max-height:300px">
													<?php getOnTimeBreak1();?>
												</tbody>
													
											</table>
										</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div> 
					<!-- Today table end  --->
					
					
					
					<!---- start monthly table--->
					<div class="row">
						<div class="col-lg-6 col-md-12">
							<div class="card card-nav-tabs">
								<div class="card-header" data-background-color="green"  style="background-color:#01b3bc">
									<div class="nav-tabs-navigation" >
										<div class="nav-tabs-wrapper">
											<div class="row">
											
											<span class="nav-tabs-title" style="font-size:16px;"> &nbsp;<i class="fa fa-calendar-o " style="font-size:22px;"></i> &nbsp; MONTH <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo date("F",strtotime("-1 month"));?>)	
											</span>
											<div>
											<ul class="nav nav-tabs" data-tabs="tabs">
												<li class="active">
													<a href="#late1" data-toggle="tab">
														<i class="fa fa-user fa-2x"></i>
														 <span style="text-transform: capitalize; font-size: 14px; font-family: Helvetica;">   Late Comers</span> <span class="badge" id="presentCount1"></span>
													<div class="ripple-container"></div></a>
												</li>
 
												<li class="" >
													<a href="#early1" data-toggle="tab">
														<i class="fa fa-user fa-2x"></i>
														<span style="text-transform: capitalize; font-size: 14px; font-family: Helvetica;">Early Leavers </span>     
													<div class="ripple-container"></div></a>
												</li>
												
											</ul>
											</div>
											</div>
										</div>
									</div>
								</div>

								<div class="card-content" >
									<div class="tab-content" >
										<div class="tab-pane active " id="late1"  >
										<div class="table-responsive" >
										<table class="table table-hover" id="lateList" >
												<thead class="text-warning" style="width:105%;">
												
													<th>Name</th>
													<th>Designation</th>
													<th>Department</th>
													<th>Shift</th>
													<th>Late by</th>
												
												</thead>
												<tbody style="max-height:300px;">
													<?php MonthlyLateComing(); ?>
												</tbody>
											</table>
											</div>
										</div>
										<div class="tab-pane" id="messages1" style="">
										<div class="table-responsive">
											<table class="table table-hover">
												<thead class="text-warning">
													<th>S.No.</th>
													<th>Name</th>
													<th>Department</th>
													<th>Designation</th>
													<th>Break On Time</th>
												</thead>
												<tbody style="max-height:300px;">
													<?php getAbsentees();?>
												</tbody>
											</table>
										</div>
										</div>
										<div class="tab-pane" id="early1" >
										<div class="table-responsive">
											<table class="table table-hover" id="earlybytable" >
												<thead class="text-warning" style="width:105%;">
													
													<th>Name</th>
												    <th>Department</th>
													<th>Designation</th>
													<th>Shift</th>
													<th>Early by</th>
													
													
												</thead>
												<tbody style="max-height:300px">
													<?php MonthlyEarlyGoing();?>
												</tbody>
											</table>
										</div>
										</div>
										
										<div class="tab-pane" id="Absent1" style="">
											<div class="table-responsive">
											<table class="table table-hover" >
												<thead class="text-warning">
													<th>S.No.</th>
													<th>Name</th>
													<th>Department</th>
													<th>Designation</th>
												</thead>
												<tbody style="max-height:300px">
													<?php MonthlyAbsent();?>
												</tbody>
											</table>
										</div>
										</div>
										
										
										
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-6 col-md-12">
							<div class="card card-nav-tabs">
								<div class="card-header" data-background-color="orange" >
									<div class="nav-tabs-navigation" >
										<div class="nav-tabs-wrapper">
											<div class="row">
											
											<span class="nav-tabs-title " style="font-size:16px;">  &nbsp;<i class="fa fa-calendar-o " style="font-size:22px;"></i> &nbsp;MONTH<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (<?php echo date("F",strtotime("-1 month"));?>)	
											</span>
											<div>
											<ul class="nav nav-tabs" data-tabs="tabs">
												<li class="active">
													<a href="#over1" data-toggle="tab">
														<i class="fa fa-user fa-2x"></i>
														  <span style="text-transform: capitalize; font-size: 14px; font-family: Helvetica;">Over Time </span>  
													<div class="ripple-container"></div></a>
												</li>
												
												<li class="">
													<a href="#under1" data-toggle="tab">
														<i class="fa fa-user fa-2x"></i>
														<span style="text-transform: capitalize; font-size: 14px; font-family: Helvetica;">
														Under Time  </span>
													<div class="rippleLate-container"></div></a>
												</li>
											
											</ul>
											</div>
											</div>
										</div>
									</div>
								</div>

								<div class="card-content">
									<div class="tab-content ">
										<div class="tab-pane active" id="over1" >
										<div class="table-responsive">
											<table class="table table-hover">
												<thead class="text-warning" style="width:105%;">
												
													<th>Name</th>
													<th>Designation</th>
													<th>Department</th>
													<th>Shift</th>
													<th>Over Time</th>
													
												</thead>
												<tbody style="max-height:300px">
													<?php MonthlyOverTime();?>
												</tbody>
													
											</table>
										</div>
										</div>
										
										<div class="tab-pane" id="under1" >
											<div class="table-responsive">
											<table class="table table-hover">
												<thead class="text-warning" style="width:105%;">
													
													<th>Name</th>
													<th>Designation</th>
													<th>Department</th>
													<th>Shift</th>
													<th>Under Time</th>
													
												</thead>
												<tbody style="max-height:300px">
													<?php MonthlyUnderTime();?>
												</tbody>
													
											</table>
										</div>
										</div>
										
										<div class="tab-pane" id="Time_OffN1" style="">
											<div class="table-responsive">
											<table class="table table-hover">
												<thead class="text-warning" style="width:105%;">
													<th>S.No.</th>
	                                    	        <th>Name</th>
	                                    	        <th>Department</th>
	                                    	        <th>Designation</th>
	                                    	        <th>Time Off Start</th>
												</thead>
												<tbody style="max-height:300px">
													<?php getOnTimeBreak1();?>
												</tbody>
											</table>
										</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div> 
					<!-- monthly table end --->	
					
					
					
					
				<!--	<div class="row">
						

						<div class="col-lg-6 col-md-12">
							<div class="card">
	                            <div class="card-header" data-background-color="green">
									<div class="nav-tabs-navigation">
										<div class="nav-tabs-wrapper">
											<h6 class="nav-tabs-title" style="font-size:16px;"> <i class="fa fa-calendar-o  fa-2x"></i>&nbsp; Month (<?php echo date("F",strtotime("-1 month"));?>)	<!---	<span class="badge" id="countTB1"></span> -->
											<!--</h6>
										</div>
									</div>
	                            </div>
								<div class="tab-pane active" style="overflow-x:scroll;">
									<table class="table table-hover"  >
												<thead class="text-warning">
													
													<th width="20%">Name</th>
													<th width="20%">Late Coming</th>
													<th width="20%">Early Leaving</th>
													<th width="20%">OverTime</th>
													<th width="20%">UnderTime</th>
													
												</thead>
												<tbody style="max-height:335px;">
													<?php MonthlyOverTime(); ?>
												</tbody>
									</table>
								</div>
									  
	                        </div>
						</div>
						
						<div class="col-lg-6 col-md-12">
							<div class="card">
	                            <div class="card-header" data-background-color="orange">
									<div class="nav-tabs-navigation">
										<div class="nav-tabs-wrapper">
										
											<h6 class="nav-tabs-title" style="font-size:16px;"> <i class="fa fa-calendar-o  fa-2x"></i> &nbsp;Month (<?php echo date("F",strtotime("-1 month"));?>)	<!---	<span class="badge" id="countTB1"></span> -->
											<!--</h6>
										</div>
									</div>
	                            </div>
								<div class="tab-pane active" style="overflow-x:scroll;">
									<table class="table table-hover"  >
												<thead class="text-warning">
													
													<th width="20%">Name</th>
													<th width="20%">LateComing</th>
													<th width="20%">EarlyGoing</th>
													<th width="20%">OverTime</th>
													<th width="20%">UnderTime</th>
													
												</thead>
												<tbody style="max-height:335px;">
													<?php getMonthlyEmployee(); ?>
												</tbody>
									</table>
								</div>
									  
	                        </div>
						</div>
						
						
						
						
					</div>-->
	
					<!----------------table section 2 start----------------------->
					<div class="row">
						<!--<div class="col-lg-6 col-md-12">
							<div class="card card-nav-tabs">
								<div class="card-header" data-background-color="blue">
									<div class="nav-tabs-navigation">
										<div class="nav-tabs-wrapper">
											<span class="nav-tabs-title">TODAY</span>
											<ul class="nav nav-tabs" data-tabs="tabs">
												<li class="active">
													<a href="#Absent" data-toggle="tab">
														<i class="fa fa-user fa-2x"></i>
														  Absent<span class="badge"></span>
													<div class="ripple-container"></div></a>
												</li>
												<li class="">
													<a href="#Late" data-toggle="tab">
														<i class="material-icons">person</i>
														Late
													<div class="ripple-container"></div></a>
												</li>
												<li class="">
													<a href="#Early" data-toggle="tab">
														<i class="material-icons">person</i>
														Early
													<div class="ripple-container"></div></a>
												</li>
												<li class="">
													<a href="#Time_Off" data-toggle="tab">
														<i class="material-icons">person</i>
														Time Off
													<div class="ripple-container"></div></a>
												</li>
												
											</ul>
										</div>
									</div>
								</div>

								<div class="card-content">
									<div class="tab-content">
										<div class="tab-pane active" id="Absent">
										<table class="table table-hover"  >
												<thead class="text-warning">
													<th>S.No.</th>
													<th>Name</th>
													<th>Department</th>
													<th>Designation</th>
												</thead>
												<tbody style="max-height:250px;">
													<?php getAbsentEmployees(); ?>
												</tbody>
											</table>
										</div>
										<div class="tab-pane" id="Late">
											<table class="table table-hover">
												<thead class="text-warning">
													<th>S.No.</th>
													<th>Name</th>
													<th>Department</th>
													<th>Designation</th>
													<th>Time in</th>
												</thead>
												<tbody style="max-height:250px;">
												    
													<?php getLateEmployee();?>
												</tbody>
											</table>
										</div>
										<div class="tab-pane" id="Early">
											<table class="table table-hover">
												<thead class="text-warning">
													<th>S.No.</th>
													<th>Name</th>
													<th>Department</th>
													<th>Designation</th>
													<th>Time Out</th>
												</thead>
												<tbody style="max-height:250px">
												
													<?php getEarlyEmployee();?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>-->

						
					</div>
					<!-----------------table section 2 end---------------------->				
								
										
				   </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>

	       </section>
			<footer class="footer">
				<div class="container-fluid">	
				</div>
			</footer>
			<footer class="footer">
				<div class="container-fluid">
					<nav class="pull-left">
						
					</nav>
				<!--<p class="copyright pull-right" style="padding-right:25px;" >
              &copy; <script>document.write(new Date().getFullYear())</script>. Developed by<a href="http://www.ubitechsolutions.com/" target="_blank" > Ubitech Solutions </a>
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

<!---modal close edit employee--->
<!-----delete employee start--->
<div id="delEmp" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Delete Employee</h4>
      </div>
      <div class="modal-body">		
		<form>
			<input type="hidden" id="del_id"/>
			<div class="row">
				<div class="col-md-12">
					<h4><span id="na"></span> will no longer be available, Are you sure want to delete this Record ?</h4>
				</div>
			</div>
			<div class="clearfix"></div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="delete"  class="btn btn-warning">Delete</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-----delete employee close--->
</body>
<div id="mySidenav" class="pull-right sidenav" style="background-image:url(<?=URL?>../assets/img/bg7.jpg);">
						<div class="helpHeader"><span ><b>&nbsp;&nbsp;<i style="font-size:24px; color:black;"class="fa fa-question-circle" ></i ></b></span><a style="color:black;" href="javascript:void(0)" class="closebtn text-right" onclick="closeNav()">x </a></div>
						<div id="sidenavData" class="sidenavData">
						</div>
					</div>
      <script src="<?=URL?>../assets/js/buttons.colVis.min.js"></script>
      <script src="<?=URL?>../assets/js/dataTables.buttons.min.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/moment.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/daterangepicker.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/dataTables.buttons.min.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/buttons.flash.min.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/jszip.min.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/pdfmake.min.js"></script>
	     <script type="text/javascript" src="<?=URL?>../assets/js/vfs_fonts.js"></script>
		 <script type="text/javascript" src="<?=URL?>../assets/js/jquery.dataTables.min.js"></script>
	    <script type="text/javascript" src="<?=URL?>../assets/js/buttons.html5.min.js"></script>
     <script type="text/javascript" src="<?=URL?>../assets/js/buttons.print.min.js"></script>
	
	<script>
	function openNav() {
							document.getElementById("mySidenav").style.width = "360PX";
							$('#sidenavData').load('<?=URL?>help/helpNav/7');	
						}
						function closeNav() {
							document.getElementById("mySidenav").style.width = "0";
						}
						
	
	</script>

	<script type="text/javascript">
	
    	$(document).ready(function() {
			var table= $('#example').DataTable( {
				"paging": true,
				//"bProcessing": true,
				order: [[ 1, 'desc' ],[0,'asc']],
			
				"lengthChange":true,
				//"scrollX": true,
				 dom: 'Bfrtip',
				 //"bSort": false,
				 //"orderable": false,
				
				buttons: [
					//	'pageLength','copy','csv','print', 'excel','pdfHtml5', 
						'pageLength','csv','excel','copy','print','colvis',
					],
				 "bDestroy": false, // destroy data table before reinitializing
				/* buttons: [
				'colvis',
				], */
				"contentType": "application/json",
				"ajax": "<?php echo URL;?>admin/getLate__new",
				"columnDefs": [
					{ "visible": false, "targets": 1 }
				],
				 "columns": [
				    
				 	{ "data": "Name" },
					{ "data": "date" },
					{ "data": "desg" } ,
					{ "data": "depart" } ,
					{ "data": "shift" },
					{ "data": "TimeIn" },
					//{ "data": "ad" },
				   // { "data": "TimeOut" },
				   
					//{ "data": "Totaltime" },
					
					
					{ "data": "LateHours" }
					
					] ,
					"drawCallback": function ( settings ) {
					var api = this.api();
					var rows = api.rows( {page:'current'} ).nodes();
					var last=null;
		 
					api.column(1, {page:'current'} ).data().each( function ( group, i ) {
						if ( last !== group ) {
							$(rows).eq( i ).before(
								'<tr class="group"><td bgcolor="#d59ff2" colspan=6><b>'+group+'</b> <b> &nbsp; &nbsp; </b></td></tr>'
							);
							last = group;
						}
					} );
				}
			}); 
			 
				////---------date picker
			var minDate = moment();
			var start = moment().subtract(7, 'days');
			var end = moment().subtract(1,'days');
			function cb(start, end) {
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
	//	$('#reportrange').on('DOMNodeInserted',function(){ //alert();
		$('#getAtt').click(function(){
			var range=$('#reportrange').text();
		
			var shift=$('#shift').val();
			var deprt=$('#deprt').val();
			var empl=$('#empl').val();
			var desg=$('#desg').val();
			$('#example').DataTable( {
					order: [[ 1, 'desc'],[0,'asc']],
					//"scrollX": true,
					 dom: 'Bfrtip',
					 	// "bSort": false,
					 "bDestroy": true,// destroy data table before reinitializing
					 buttons: [
						//'pageLength','copy','csv','print', 'excel','pdfHtml5',
						//'pageLength','csv','excel','copy','print','pdfHtml5',
						'pageLength','csv','excel','copy','print','colvis',
					],
					/* buttons: [
						'colvis'
					], */
				
					"contentType": "application/json",
					"ajax": "<?php echo URL;?>admin/getLate__new?date="+range+"&shift="+shift+"&deprt="+deprt+"&empl="+empl+"&desg="+desg,
					"columnDefs": [
										{ "visible": false, "targets": 1 }
									],
					"columns": [
					{ "data": "Name" },
					{ "data": "date" },
					{ "data": "desg" } ,
					{ "data": "depart" } ,
					{ "data": "shift" },
					{ "data": "TimeIn" },
					//{ "data": "ad" },
				   // { "data": "TimeOut" },
				   //{ "data": "Totaltime" },
				
					{ "data": "LateHours" }
		
					],
					"drawCallback": function ( settings ) {
					var api = this.api();
					var rows = api.rows( {page:'current'} ).nodes();
					var last=null;
		 
					api.column(1, {page:'current'} ).data().each( function ( group, i ) {
						if ( last !== group ) {
							$(rows).eq( i ).before(
								'<tr class="group"><td bgcolor="#d59ff2" colspan=6><b>'+group+'</b> <b>&nbsp; &nbsp;  </b></td></tr>'
							);
							last = group;
						}
					} );
				}
				} );
			});
			
			
			
			function createpdf()
			{
			var pdf = new jsPDF('p', 'pt', 'a3');
			var options = {
					 pagesplit: true,
					 background:'#fff'
				};
			
			pdf.addHTML($("#printsection")[0], options, function()
			{
				//console.log(pdf)	
				pdf.save("absent_report.pdf");
			});
			}
			
			
			
			$(document).on("click", ".delete", function () {
				
				$('#del_id').val($(this).data('id'));
				$('#na').text($(this).data('name'));
			});
			$(document).on("click", "#delete", function () {
				var id=$('#del_id').val(); 
				$.ajax({url: "<?php echo URL;?>userprofiles/deleteUser",
						data: {"sid":id},
						success: function(result){
							if(result == 1){
								$('#delEmp').modal('hide');
								 doNotify('top','center',2,'User deleted Successfully.'); 
								 table.ajax.reload();  
					        }    
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});
			
		
		<!-- This code for when add the country (start)-->
		$(document).on("change", "#country", function () {
			
				var country = $(this).val();
				$.ajax({url: "<?php echo URL;?>userprofiles/getCity",
						data: {"country":country},
						success: function(result){
							var result=JSON.parse(result);
							 var i = 0;
							for(i=0; i<result.length; i++){
								$('#city').append('<option value="' + result[i].Id + '">' + result[i].Name + '</option>');	
							}		   				
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
				
			})
			<!-- This code for when add  the country (end)-->
			<!-- This code for when edit  the country (start)-->
			$(document).on("change", "#countryE", function () {
				var country = $(this).val();
				$.ajax({url: "<?php echo URL;?>userprofiles/getCity",
						data: {"country":country},
						success: function(result){
							var result=JSON.parse(result);
							 var i = 0;
							for(i=0; i<result.length; i++){
								$('#cityE').append('<option value="' + result[i].Id + '"  >' + result[i].Name + '</option>');	
							}		   				
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
				
			})
			<!-- This code for when edit  the country (end)-->
			
			$('#create_pdf').on('click',function(){
	$('body').scrollTop(0);
	createPDF();
});
	$(document).on("change", "#divi", function () {
				var divi = $(this).val();
				$.ajax({url: "<?php echo URL;?>admin/getAlldiv",
						data: {"divi":division},
						success: function(result){
							var result=JSON.parse(result);
							 var i = 0;
								for(i=0; i<result.length; i++)
								{
									$('#divi').append('<option value="' + result[i].Id + '"  >' + result[i].Name + '</option>');	
								}		   				
												},
						error: function(result)
							{
							doNotify('top','center',4,'Unable to connect API');
							}
				   });
				
			})
	
	
	});		
	</script>
	
	
	

</html>
