<!doctype html> 
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Dashboard</title>
	<style type="text/css">
	
		.hover{background-color: #cc0000}
		.authorBlock{border-top:1px solid #cc0000;}
		
		.canvasjs-chart-credit{
			display:none;
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
<style type="text/css">
	
		.hover{background-color: #cc0000}
		.authorBlock{border-top:1px solid #cc0000;}
		
		.canvasjs-chart-credit{
			display:none;
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
				//overflow-x: scroll;
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
      .summry{
		  color:white;
		  font-size:2em;margin:10%;margin-left:28%;
		margin-right:28%;
		padding:12%;border-radius:4px 4px 4px 4px;
	  }
</style>
</head>
<body>
	
	<div class="wrapper">
		<?php 
			$data['pageid']=1;
			$this->load->view('menubar/sidebar',$data);
			
		?>
		<?php
    $data=isset($data)?$data:'';

?>
	    <div class="main-panel">
			<?php
				$this->load->view('menubar/navbar');
			?>
			</br>
			<div class="content">
			<div class="row">
				<div id="rd1"clas="col-sm-6" style="display:none;">
					<div id="RD" class="col-sm-10" style="padding-right: 25px;box-shadow:2px 2px 2px #4c2652; background-color:red;color:wheat ">
						<b>Remaining Days : <span id="day"></span>
						</b>
					</div>
				</div>
			</div>
				<div class="container-fluid">
					<div class="row">
					
							<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="card card-stats">
								<div class="card-header" style="background-image:url(<?=URL?>../assets/img/ch2g.jpg);">
									<i class="fa fa-user" style="color:white;"></i>
								</div>
								<div class="card-content">
									<p class="category">Present</p>
									<h3 class="title"><?php if(isset($presentE)){
										                     echo $presentE;
									                        }else{
										                      echo 0;
									                        } ?></h3>
								</div>
								<div class="card-footer">
									<div class="stats">
										<i class="fa fa-hand-o-right"></i><a href="<?=URL?>admin/attendances" > Show All</a>
									</div>
								</div>
							</div>
						</div>
						
							<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="card card-stats">
								<div class="card-header" style="background-image:url(<?=URL?>../assets/img/ch3r.jpg);">
									<i class="fa fa-thumbs-o-down" style="color:white;" ></i>
								</div>
								<div class="card-content">
									<p class="category">Absent</p>
									<h3 class="title"><?php
									 if(isset($absent)){
										echo  $absent;
									 }else{
										 echo 0;
									 }
									?></h3>
								</div>
								<div class="card-footer">
									<div class="stats">
										<i class="fa fa-hand-o-right" aria-hidden="true"></i><a href= "<?=URL?>dashboard/gatAbsentEmployee">  Show All</a>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="card card-stats">
								<div class="card-header" style="background-image:url(<?=URL?>../assets/img/ch6sb.jpg);">
									<i class="fa fa-clock-o" style="color:white;"></i>
								</div>
								<div class="card-content">
									<p class="category">Late Comers</p>
									<h3 class="title"><?php if(isset($LateEmployee)){echo ($LateEmployee); 
									}else{
										echo 0;
									} ?></h3>
								</div>
								<div class="card-footer">
									<div class="stats">
										<i class="fa fa-hand-o-right" aria-hidden="true"></i><a href="<?=URL?>dashboard/getLateEmployee">     Show All</a>
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="card card-stats">
							<div class="card-header" style="background-image:url(<?=URL?>../assets/img/c10.jpg);">
								<!--<div class="card-header" style="background-image:url(<?=URL?>../assets/img/images.jpg);">-->
									<i class="fa fa-users" style="color:white;"></i>
								</div>
								<div class="card-content">
									<p class="category">Early Leavers</p>
									<h3 class="title"><?php if(isset($earlyEmployee)){echo ($earlyEmployee); }else{
										echo 0;
									} ?></h3>
								</div>
								<div class="card-footer">
									<div class="stats">
										<i class="fa fa-hand-o-right "></i> <a href="<?=URL?>dashboard/getearlyEmployee"> Show All</a>
									</div>
								</div>
							</div>
						</div>
					
					
					
					</div>

		
					<div class="row">
						<div class="col-md-4">
							<div class="card">
								<div class="card-header card-chart"  hieght="20px" width="150px" >
								
								<div   id="03061994" data-background-color="green" style=" height: 165px; width: 100%;">
								</div>
								</div>
								<div class="card-content">
									<h4 class="title">Absentees - Last 7 days</h4>
									
								</div>
								<div class="card-footer">
									<div class="stats">
										<i class="fa fa-clock-o"></i>   updated few moments ago
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4" >
							<div class="card">
							<div class="card-header card-chart"  data-background-color="yellow">
								<div   id="04061993" style="height: 165px; width: 100%;" ></div>
							</div>
								<div class="card-content">
									<h4 class="title">30 Days</h4>
								</div>
								
								<div class="card-footer">
									<div class="stats">
										<i class="fa fa-clock-o"></i>   Updated Today
									</div>
								</div>
							</div>
						</div>
						

						<div class="col-md-4" >
							<div class="card">
							
							<div class="card-header card-chart"  data-background-color="orange">
								<div   id="05061994" style="height: 165px; width: 100%;" ></div>
								</div>
								<div class="card-content">
									<h4 class="title">Late Comers - Last 7 days</h4>
								</div>
								
								<div class="card-footer">
									<div class="stats">
										<i class="fa fa-clock-o"></i>  Updated Today
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						
						<div class="col-md-4">
							<div class="card">
								<div class="card-header card-chart"  data-background-color="red">
								<div   id="04061994" style="height: 165px; width: 100%;"></div>
								</div>
								<div class="card-content">
									<h4 class="title">Early Leavers  - Last 7 days</h4>
								</div>
								
								<div class="card-footer">
									<div class="stats">
										<i class="fa fa-clock-o"></i>  Updated Today
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-----Today Table Start here----->
				<!--	<div class="row">
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
													<?php //getAbsentEmployees();?>
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
					</div> -->
					<!-- Today table end  --->
					
					
					
					<!---- start monthly table--->
				<!---	<div class="row">
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
													<?php //MonthlyLateComing(); ?>
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
													<?php //getAbsentees();?>
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
													<?php //MonthlyEarlyGoing();?>
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
													<?php //MonthlyAbsent();?>
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
													<?php //MonthlyOverTime();?>
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
													<?php //MonthlyUnderTime();?>
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
													<?php //getOnTimeBreak1();?>
												</tbody>
											</table>
										</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div> -->
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
				
			
			  <div class="row">
					<?php foreach($res as $row){ ?>
						<div class="col-lg-3 col-md-6 col-sm-6">
							<a href="<?=URL?>admin/attendances?id=<?php echo $row['id'] ?>">
							<!--<?=URL?>admin/attendances?id=<?php echo $row['id']?>-->
							<div class="card card-stats" style="border:2px solid gray;border-radius:5px 5px 5px 5px;min-height: 200px;padding:7px; ">
								<center>
								<div class='summry' title="<?php echo $row['totalemp']." Present"; ?>" style="background-color:<?php echo $row['totalemp']==1?'#ff8100':($row['totalemp']>1 || $row['totalemp']== $row['allemp'] ?'green':'red');?>;">
								
								<span><?php echo $row['totalemp']; ?></span>
								</div>
								<h4 title="<?php echo $row['allemp']." Employee"; ?>"><b><?php echo $row['name']." (".$row['allemp'].")"; ?><b/></h4>
								</center>
							</div>
							</a>
						</div>
						<?php } ?> 
						
					 </div>
					 </div>
					</div>
		<footer class="footer">
				<div class="container-fluid">
					<nav class="pull-left">
						
					</nav>
					<!--<p class="copyright pull-right" style="padding-right:25px;" >
					&copy; <script>document.write(new Date().getFullYear())</script>. Developed by
					<a href="http://www.ubitechsolutions.com/" target="_blank" > Ubitech Solutions </a>
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
	
	
	
	<!--
<a href="#"  id="notificationButton" class="button"  >att</a>
<a href="#"  id="timeBreakNotification" class="button"  >brk</a>-->
	 

</body>
</html>
 <!--<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="../assets/js/materialize.js"></script>
  <script src="../assets/js/init.js"></script>--->

<script src="../assets/js/canvasjs.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	demo.initDashboardPageCharts();
	 
});
$(document).ready(function(){
	//$('li:nth-child(3n)').next().css({'clear': 'both'});
	var RDa=0;
	$.ajax({url: "<?php echo URL;?>admin/remain",
			success: function(result){
			//alert(result);
	        var result1=JSON.parse(result);
			if(result1.data!='')
			{
			$('#day').text(result1.data);
		    $('#rd1').show();
		 // $('#day').show();
		    }
		   }
		 });  
});




</script>
<script type="text/javascript">

var dataPoints = [];
var dailyAttendance = '<?=$DailyabsentAttendance?>';
var dailyAttendance = JSON.parse(dailyAttendance);
for(var i=1; i<dailyAttendance.length; i++){
	 dataPoints.push({label: dailyAttendance[i].label, y: parseInt(dailyAttendance[i].y)});
}

/*
var dataPoints11 = [];
var monthlyAttendance  = '<?=$MonthlyLateEmployee ?>';
var monthlyAttendance  = JSON.parse(monthlyAttendance);
for(var j=0; j<monthlyAttendance.length; j++){
	 dataPoints11.push({label: monthlyAttendance[j].months, y: parseInt(monthlyAttendance[j].total)});
}*/


var dataPoints15 = [];
var earlyAttendance  = '<?=$earlyAttendance ?>';
//alert(earlyAttendance);
var earlyAttendance  = JSON.parse(earlyAttendance);
//alert(earlyAttendance);
for(var l=1; l<earlyAttendance.length; l++)
{
	 dataPoints15.push({label: earlyAttendance[l].label, y: parseInt(earlyAttendance[l].early)});
}


var dataPoints12 = [];
var LateAttendance  = '<?=$LateAttendance ?>';
var LateAttendance  = JSON.parse(LateAttendance);

for(var k=1; k<LateAttendance.length; k++){
	  
	 dataPoints12.push({label: LateAttendance[k].label, y: parseInt(LateAttendance[k].lateComers)});
}



var dataPoints02 = [];
var thirtydays  = '<?=$thirtydays ?>';
//alert(thirtydays);
var thirtydays  = JSON.parse(thirtydays);

console.log(thirtydays[0].label);
// for(var l=1; l<thirtydays.length; l++)
// {
	 dataPoints02.push(
	 {label: thirtydays[0].label, y: parseInt(thirtydays[0].presentee)},
	 {label: thirtydays[0].label1, y: parseInt(thirtydays[0].absentee)},
	 {label: thirtydays[0].label2, y: parseInt(thirtydays[0].latecomer)},
	 {label: thirtydays[0].label3, y: parseInt(thirtydays[0].earlyleaver)},
	 );
				
				
	 //dataPoints02.push({label: thirtydays[l].label1, y: parseInt(thirtydays[l].absentee)});
// }

<!-- This pie chart for daily attendance (start) --> 
window.onload = function () {
var chart03061994 = new CanvasJS.Chart("03061994", {
	backgroundColor: "green",
	  reversed: true,
	//backgroundColor: "transparent",
	theme: "light1",
	 axisY:{
   fontColor: "white",
   lineColor: "white",
   gridColor: "white",
   tickColor: "white",
   labelFontColor:"white",
 },
  axisX:{
	 //color: "white",
    lineColor: "white",
    tickColor: "white",
	labelFontColor: "white",
   // beginAtZero: true,
   reversed: true,
        
 },
 toolTip:{
  backgroundColor: "white",
  cornerRadius: 15,
 },
  credits: {
      enabled: false,
  },
	//background-image:url(<?=URL?>../assets/img/images.jpg),
	//background-repeat:no-repeat;
	//backgroundColor: "none",
	//backgroundColor: "#fbf9fc", data-image="../assets/img/images.jpg"
	//background: url(<?=URL?>../assets/img/images.jpg) no-repeat;
	
	animationEnabled: true,
	animationDuration: 1000,
	data: [{
		type: "line",
		startAngle: 60,
		indexLabelFontColor: "white",
		lineColor: "White",
		color:"orange",
		//innerRadius: 60,
		indexLabelFontSize: 12,
		 //context.fillText(count,200,200);
		dataPoints: dataPoints,
	}]
});
chart03061994.render();
chart03061994 = {};

var chart04061994 = new CanvasJS.Chart("04061994", {
	//backgroundColor: "transparent",
	backgroundColor: "#cc1508",
	theme: "light1",
	toolTip:{
    fontColor: "wheat",
    backgroundColor: "black",
    cornerRadius: 15,
 },
	
	animationEnabled: true,
	animationDuration: 1000,
	data: [{
		type: "doughnut",
		//type: "pie",
		startAngle: 45,
		indexLabelFontColor: "white",
		 colorSet:  "customColorSet1",
		//color:"#ba75d8",
	     lineColor: "White",
		//innerRadius: 60,
		indexLabelFontSize: 12,
		dataPoints: dataPoints15,
	}]
});
chart04061994.render();
chart04061994 = {};



//console.log(dataPoints02);

/////////////
var chart04061993 = new CanvasJS.Chart("04061993", {
	//backgroundColor: "transparent",
	backgroundColor: "blue",
	theme: "light1",
	toolTip:{
    fontColor: "wheat",
    backgroundColor: "black",
    cornerRadius: 15,
 },
	
	animationEnabled: true,
	animationDuration: 1000,
	data: [{
		type: "pie",
		startAngle: 45,
		indexLabelFontColor: "white",
		// colorSet:  "customColorSet1",
		//color:"#ba75d8",
	     lineColor: "White",
		//innerRadius: 60,
		indexLabelFontSize: 12,
		dataPoints: dataPoints02,
	}]
});
//alert(chart04061993);
chart04061993.render();
chart04061993 = {};
//////////////////////
















var chart05061994 = new CanvasJS.Chart("05061994", {
	backgroundColor: "darkorange",
	
	//backgroundColor: "transparent",
	//#05aac1
	 axisY:{
   fontColor: "white",
   lineColor: "white",
   gridColor: "white",
   tickColor: "white",
   labelFontColor: "white",
 },
  axisX:{
	 //color: "white",
    lineColor: "white",
    tickColor: "white",
	labelFontColor: "white",
   // beginAtZero: true,
   reversed: true,
        
 },
 toolTip:{
	fontColor: "wheat",
    backgroundColor: "black",
    cornerRadius: 15,
 },
       
	//background-image:url(<?=URL?>../assets/img/images.jpg);
	//background: url(<?=URL?>../assets/img/images.jpg) no-repeat;
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	//theme: "ocean",
	
	
	animationEnabled: true,
	animationDuration: 1000,
	data: [{
		//type: "splineArea",
		// markerColor: "#008000",
		markerType: "triangle",
		type: "line",
		markerSize:10,
		startAngle: 45,
		indexLabelFontColor:"white",
		color:"white",
		 colorSet:  "customColorSet1",
		//scaleColor:"white",
		lineColor: "White",
		//indexLabelFontSize: 12,
		dataPoints: dataPoints12,
		borderColor:"white",
		
	    // anchorBgColor: "#876EA1",
	    pointBackgroundColor:"white",	
	  }]
   });
chart05061994.render();
chart05061994 = {};
}
    //////////table order by sohan////////////////////////////////////////
		/*	
		  var table, rows, switching, i, x, y, shouldSwitch;
		  table = document.getElementById("absenttable");
		  switching = true;
		  
		  while (switching) {
			
			switching = false;
			rows = table.getElementsByTagName("TR");
			
			for (i = 1; i < (rows.length - 1); i++) {
			  
			  shouldSwitch = false;
			 
			  x = rows[i].getElementsByTagName("TD")[0];
			  y = rows[i + 1].getElementsByTagName("TD")[0];
			  
			  if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
			
				shouldSwitch= true;
				break;
			  }
			}
			if (shouldSwitch) {
			 
			  rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
			  switching = true;
			}
		  }
		///////////////////////////table order of Early by ...by sohan////////////
            var table, rows, switching, i, x, y, shouldSwitch;
		  table = document.getElementById("earlybytable");
		  switching = true;
		  
		  while (switching) {
			
			switching = false;
			rows = table.getElementsByTagName("TR");
			
			for (i = 1; i < (rows.length - 1); i++) {
			  
			  shouldSwitch = false;
			 
			  x = rows[i].getElementsByTagName("TD")[4];
			  y = rows[i + 1].getElementsByTagName("TD")[4];
			 
			  if (x.innerHTML < y.innerHTML) {
				
				shouldSwitch= true;
				break;
			  }
			}
			if (shouldSwitch) {
			  
			  rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
			  switching = true;
			}
		  }
        ///////////////////////////table order of Early by ...by sohan////////////
            var table, rows, switching, i, x, y, shouldSwitch;
		  table = document.getElementById("lateList");
		  switching = true;
		  
		  while (switching) {
			
			switching = false;
			rows = table.getElementsByTagName("TR");
			
			for (i = 1; i < (rows.length - 1); i++) {
			  
			  shouldSwitch = false;
			 
			  x = rows[i].getElementsByTagName("TD")[4];
			  y = rows[i + 1].getElementsByTagName("TD")[4];
			 
			  if (x.innerHTML < y.innerHTML) {
				
				shouldSwitch= true;
				break;
			  }
			}
			if (shouldSwitch) {
			  rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
			  switching = true;
			}
		  }
         */

</script>
