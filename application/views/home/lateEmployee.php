<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Late Comers <?php echo date('M d,y'); ?></title>
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" />
	<style>
	 $query = $this->db->query("SELECT `Id`,  `Shift`  FROM ` EmployeeMaster`  WHERE OrganizationId=? AND `Id` Not IN(SELECT `EmployeeId` FROM `AttendanceMaster` ) ",array($orgid)); 
		.red{
			color:red;
			font-weight:'bold';
			font-size:16px;
		}
		.delete{
			cursor:pointer;
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
	/*	#content .btn-group {
			margin-bottom: 10px;
		}
		.col-md-9 .width-12,
		.col-md-12 .width-9 {
			display: none; /* just hiding labels for demo purposes 
		}
		#sidebar {
			
			-webkit-transition: margin 0.3s ease;
			-moz-transition: margin 0.3s ease;
			-o-transition: margin 0.3s ease;
			transition: margin 0.3s ease;
		}
		.collapsed {
			display: none; /* hide it for small displays */
		}
		@media (min-width: 992px) {
			.collapsed {
				display: block;
				margin-right: -25%; /* same width as sidebar */
			}
		}
		.t2{display:none;}
		a.depart
	  {
		color: #43a047!important; 
		font-size:16px;
		margin:0px;
		text-decoration: underline!important;
		font-family: "Roboto"!important;
	  }
	</style>
</head>
<body>
	<div class="wrapper">
		<?php
			$data['pageid']=3.2;
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
								 <?php $depart = getDepartment($id) ?><?php if($depart	!=	""){ ?>
								 <p class="category" style="color:#ffffff;font-size:17px;" >	Employees by Department/Site</p>
								 <?php } ?>
								 
								  <?php $depart = getDepartment($id) ?><?php if($depart == ""){ ?>
									<p class="category" style="color:#ffffff;font-size:17px;" >List of Late Comers</p>
								  <?php } ?>
									<a  rel="tooltip"  data-placement="bottom" title="Help" class="btn btn-success btn-sm  toggle-sidebar pull-right" style="position:relative;margin-top:-30px;" >
									<i class="fa fa-question"></i></a>
	                            </div>
	                            <div class="card-content">
									<div id="typography">
										<div class="title">
											<div class="row">
												<div class="col-md-8" style="margin-top:-10px" >
										
													<h3>Late Comers<?php $depart = getDepartment($id) ?> <?php if($depart != "") echo "in ".$depart." Department/Site"; ?></h3>
												</div>
												
												<div class="col-md-6" >
						
						<div class="col-md-3">
						 <?php $depart = getDepartment($id) ?><?php if($depart != ""){ ?>
							<a  href="<?=URL?>admin/department?id=<?php echo $id ?>" style="" class="depart">Present</a>&nbsp;|
						 <?php } ?>
						 </div>
							
							<div class="col-md-4">
						 <?php $depart = getDepartment($id) ?><?php if($depart != ""){ ?>
							<a  href="<?=URL?>Dashboard/gatAbsentEmployee?id=<?php echo $id ?>" style="" class="depart">Absent</a>&nbsp;|
						 <?php } ?>
						 </div>
							 
							
							
						 <div class="col-md-4">
						 <?php $depart = getDepartment($id) ?><?php if($depart != ""){ ?>
							<a  href="<?=URL?>Dashboard/getearlyEmployee?id=<?php echo $id ?>" style="" class="depart">Early Leavers</a>
						 <?php } ?>
						 </div>
						</div>
						<!--<div class="row pull-right" style="margin:0px">
							<div class="col-md-4"> 
							 <?php $depart = getDepartment($id) ?><?php if($depart != ""){ ?>
							  <button  class="btn btn-sm present"  type="button" >	
							<i class=""> Present </i>
								</button>
							<?php } ?> 
							  </div>
							  
							  <div class="col-md-4"> 
							 <?php $depart = getDepartment($id) ?><?php if($depart != ""){ ?>
							  <button  class="btn btn-sm absent"  type="button" >	
							<i class=""> Absent </i>
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
											<hr/>
										
										<div class="row" style="overflow-x:scroll;">
										
											<table id="example" class="display table" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th width=15%>Name</th>
													<th width=12%>Code</th>
													<th width=13%>Department</th>
													<th width=15%>Designation</th>
													<th width=20%>Shift</th>
													<th width=10%>Time In</th>
													<th width=10%>Late By</th>
													<th width=5%>Device</th>
												</tr>
											</thead>
											<tbody>
										
											<?php
											// var_dump($LateEmployee);
											   for($i =0; $i<count($LateEmployee); $i++)
											   {  
											?>
											<tr>
													<td width=15%><?php echo $LateEmployee[$i]['Name']; ?></td>
													<td width=12%><?php echo $LateEmployee[$i]['code']; ?></td>
													
													<td width=13%><?php echo $LateEmployee[$i]['deprt']; ?></td>
													<td width=15%><?php echo $LateEmployee[$i]['Designation']; ?></td>													
													<td width=20%><?php echo $LateEmployee[$i]['shift']; ?></td>
													<td width=10%><?php echo $LateEmployee[$i]['TimeIn']; ?></td>
													<td width=10%><?php echo $LateEmployee[$i]['late_by'];?></td>
													<td width=5%><?php echo $LateEmployee[$i]['device'];?></td>
											</tr>
                                            <?php										
											   }
											?>
											</tbody>
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

      <script type="text/javascript" src="<?=URL?>../assets/js/buttons.flash.min.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/jszip.min.js"></script>
		 <script type="text/javascript" src="<?=URL?>../assets/js/jquery.dataTables.min.js"></script>
	    <script type="text/javascript" src="<?=URL?>../assets/js/buttons.html5.min.js"></script>
		<script type="text/javascript" src="<?=URL?>../assets/js/buttons.print.min.js"></script>	
		<!--
	  <script>
	function openNav() {
							document.getElementById("mySidenav").style.width = "400PX";
							$('#sidenavData').load('<?=URL?>admin/helpNav',{'pageid': 'lateH'});	
						}
						function closeNav() {
							document.getElementById("mySidenav").style.width = "0";
						}
	
	</script>
	-->
	<script type="text/javascript">
    	$(document).ready(function() {
			var table= $('#example').DataTable({
				order: [[ 4, 'asc' ]],
				"orderable": false,
				"scrollX": true,
				 dom: 'Bfrtip',
				 "bDestroy": true, 
				buttons: [
					'pageLength','csv','excel','copy','print','colvis',
				],
				"columnDefs": 
				[
					{ "visible": false, "targets": [1,7]}
				],
				
											});
										}); 
		
	</script>
	<script>
	$(document).on("click", ".present", function() 
	{
		var id='<?php echo $id; ?>';
    window.location.href = '<?=URL?>admin/department?id='+id; 

    });	
	$(document).on("click", ".absent", function() 
	{
		var id='<?php echo $id; ?>';
    window.location.href = '<?=URL?>Dashboard/gatAbsentEmployee?id='+id;

    });	
$(document).on("click", ".early", function() 
	{
		var id='<?php echo $id; ?>';
    window.location.href = '<?=URL?>Dashboard/getearlyEmployee?id='+id;

    });
	</script>
	<script>
		$(document).ready(function(){
		$(".toggle-sidebar").click(function(){
		// if($(".t2").is(':hidden'))
		//   setTimeout(function(){
		$("#sidebar").toggleClass("collapsed t2");
		$("#content").toggleClass('col-md-9');
		$("#sidebar").load('<?=URL?>admin/helpnav',{'pageid':'lateH'});
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
