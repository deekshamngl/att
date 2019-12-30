<html>
<head>
 <style>
 	#sidenav01 .nav li > a {
        margin: 4px 12px;
    }
    .rotate-icon{-webkit-transform:rotate(180deg);-ms-transform:rotate(180deg);transform:rotate(180deg)}
	 #sidenav01 .nav li > a 
	 {
       margin-bottom: 0px !important;
     }
	 .nav>li>a{
          padding-top: 4px !important;
       }
	 .nav>div>ul
	 {
		z-index:1 !important;
		margin-top:-3px !important;
	 }
   .nav>div>ul>li{
	 margin-bottom:-8px !important;
   }
   .nav div li.active a,.nav div li.active a
   {
	   background-color:transparent !important;
	   box-shadow:none !important;
	   color:#45a149 !important;
   }
   .nav div{
	   margin-left:20% !important;
   }

 </style>


 
</head>
<body>
<div class="sidebar" data-color="green" data-image="<?php echo URL; ?>../assets/img/sidebar-1.jpg" style="height:`800px;position: fixed;z-index: 10000000;">

			<!--
		        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

		        Tip 2: you can also add an image using data-image tag
		    -->
			<?php
			
			if($_SESSION['expirydate']==0)
			    {
				?>
	        <div class="logo">
				<a href="<?=URL?>dashboard" class="simple-text" title="View Dashboard">
				<img src="<?=URL?>../assets/img/newlogo.png" height="120px" width="150px"/>
				</a>
			</div>
				
	    	<div class="sidebar-wrapper" id="sidenav01" data-color="purple" data-image="<?php echo URL; ?>../assets/img/sidebar-1.jpg" style="height:440px;" >
	            <ul class="nav" >
	               <!-- <li <?php if(isset($pageid) and $pageid==1)echo 'class="active"'; ?>>
	                    <a href="<?=URL?>dashboard">
	                        <i class="fa fa-dashboard"></i>
	                        <p>Dashboard</p>
	                    </a>
	                </li>-->
	                <?php  if($_SESSION['specialCase']!='RAKP') { ?>  
						 
				<li <?php if(isset($pageid) and $pageid==11.1)echo 'class="active "'; ?> >
					<a href="<?= URL ?>myplan ">
					<i class="fa fa-cube "></i>
	                        <p>My Plan</p>
	                </a>
				</li>		
                  <?php }	?>
                     <!---------Employee List--------->
	                <li <?php if(isset($pageid) and ($pageid==2.3 || $pageid==2 || $pageid==2.1 || $pageid==14.1 ))echo 'class="active"'; ?>>
	                    <a data-toggle="collapse" data-target="#empmenu" data-parent="#sidenav01" class="collapsed">
	                        <i class="fa fa-users"></i>
	                        <p>Employees</p>
	                    </a>
	                </li>
	               
					<div <?php if(isset($pageid) and ($pageid==2.3 || $pageid==2 || $pageid==2.1 || $pageid==14.1 ))echo 'class="collapse in" aria-expanded="true" style="height: 118px;margin-left:25%"'; else echo 'class="panel-collapse collapse" aria-expanded="false" aria-controls="navbar" style="height: 0px;margin-left:25%"' ;?> id="empmenu" style="height: 0px;margin-left:25%">
						<ul class="nav nav-list">
							<?php 
		       $orgid =$_SESSION['orgid'];
		       $query1 = $this->db->query("SELECT `user_limit` as userlimit,status ,(SELECT COUNT(*)
    FROM EmployeeMaster where`OrganizationId` = $orgid and Is_Delete != 2) as registeredusers from licence_ubiattendance where `OrganizationId`=$orgid"); 

		       if ($r=$query1->result()){
							$userlimit  = $r[0]->userlimit;
							$reguser  = $r[0]->registeredusers;
							$status  = $r[0]->status;

						}




		       ?>
		       <?php if($reguser > $userlimit+5 && $status == 1){
 
	                    echo '';

                }
else{
	?>
						  <li <?php if(isset($pageid) and $pageid==2.3)echo 'class="active"'; ?> ><a href="<?=URL?>userprofiles/addemployee">Add Employees</a></li>
						<?php } ?>
						  
						  <li <?php if(isset($pageid) and $pageid==2)echo 'class="active"'; ?> ><a href="<?=URL?>userprofiles">Active Employees</a></li>
						  
						  <li <?php if(isset($pageid) and $pageid==2.1)echo 'class="active"'; ?>><a href="<?=URL?>userprofiles/inctiveemp">Inactive Employees</a></li>
						  
						  <li <?php if(isset($pageid) and $pageid==14.1)echo 'class="active"'; ?>>
						  <a href="<?=URL?>userprofiles/archiveemployee">Archive Employees</a></li>
						</ul>
					 </div>
			         	   <?php
                               $permis = getAddonPermission($_SESSION['orgid'],'Addon_TimeOff') ;
							  if($permis == 1)
								{
							   ?>
				
					<li <?php if(isset($pageid) and $pageid==13)echo 'class="active "'; ?> >
						<a href="<?= URL ?>userprofiles/approvetimeoff ">
						<i class="fa fa-check-circle"></i>
								<p>Approve Time Off </p>
						</a>
					</li>  
								<?php } ?>
			
					<!--<li <?php if(isset($pageid) and $pageid==3)echo 'class="active"'; ?>>
	                    <a href="<?=URL?>admin/attendances">
	                        <i class="fa fa-calendar-o"></i>
	                        <p>Attendance</p>
	                    </a>
	                </li>--->
					
					
					<li <?php if(isset($pageid) and ($pageid==3 || $pageid==3.1 || $pageid==3.2|| $pageid==3.3 or $pageid==5.1 or $pageid==5.2))echo 'class="active"'; ?>>
					  <a href="#attmenu" data-toggle="collapse" data-target="#attmenu" data-parent="#sidenav01" class="collapsed"> <i class="fa fa-calendar-o"></i> <p>Today's Attendance</p>
					  </a>
					</li>
					<div <?php if(isset($pageid) and ($pageid==3 || $pageid==3.1 || $pageid==3.2|| $pageid==3.3 or $pageid==5.1 or $pageid==5.2))echo 'class="collapse in" aria-expanded="true" style="height: 200px;margin-left:20%"'; else echo 'class="collapse"  style="height:0px;margin-left:20%"' ;?> id="attmenu" style="height: 0px;margin-left:20%">
						<ul class="nav nav-list" style="" >
						  <li <?php if(isset($pageid) and $pageid==3)echo 'class="active"'; ?> ><a href="<?=URL?>admin/attendances"> Present</a></li>
						  
						  <li <?php if(isset($pageid) and $pageid==3.1)echo 'class="active"'; ?>><a href="<?=URL?>dashboard/gatAbsentEmployee"> Absent </a>
						  </li>
						  
						  
						  <li <?php if(isset($pageid) and $pageid==3.2)echo 'class="active"'; ?>><a href="<?=URL?>dashboard/getLateEmployee">Late Comers Today</a></li>
						  
						  
						  <li <?php if(isset($pageid) and $pageid==3.3)echo 'class="active"'; ?>><a href="<?=URL?>dashboard/getearlyEmployee">Early Leavers Today</a></li>
						  
						   <li <?php if(isset($pageid) and $pageid==5.1)echo 'class="active"'; ?>><a href="<?=URL?>dashboard/loggeddepart">Department Dashboard</a>
						   </li>
						  
							<li <?php if(isset($pageid) and $pageid==5.2)echo 'class="active"'; ?>><a href="<?=URL?>dashboard/depart">Department Summary</a>
						   </li>
						</ul>
					  </div>
					
					
					
					
	                <li <?php if(isset($pageid) and ($pageid >=7 and $pageid <8 ))echo 'class="active "';?> style="margin-bottom:0px;" >
					 
					<a  href='#reportmenu' data-toggle="collapse" data-target="#reportmenu" data-parent="#sidenav01" class="collapsed"  >
					<i class="fa fa-files-o"></i>
	                    <p>Attendance Reports</p>
	                </a>
					 </li>
					 
			    	<div <?php if(isset($pageid) and ($pageid >= 7 and $pageid <8  )) 
					 echo 'class="collapse in" aria-expanded="true" style="height: 420px;margin-left:20%"'; else echo 'class="collapse" aria-controls="navbar" aria-expanded="false" style="height: 0px;margin-left:20%"'; ?> id="reportmenu" style="height: 0px;margin-left:20%;">
	                    
						<ul class="nav nav-list">
						   <!--     <li <?php if(isset($pageid) and $pageid==7.6)echo 'class="active "'; ?>><a href="<?php echo URL?>admin/empreport">Employees Monthly Reports </a></li>-->
						    
						   

						 
						   <li <?php if(isset($pageid) and $pageid == 7.775)echo 'class="active"'; ?> ><a href="<?=URL?>admin/both">All Attendances</a> </li>

						
						         <li <?php if(isset($pageid) and $pageid == 7.15)echo 'class="active"'; ?> ><a href="<?=URL?>admin/attendances1">Present</a> </li>
								<li <?php if(isset($pageid) and $pageid==7)echo 'class="active "'; ?>><a href="<?php echo URL?>admin/absent"> Absent</a></li>
								
								<li <?php if(isset($pageid) and $pageid==7.1)echo 'class="active "'; ?>><a href="<?php echo URL?>admin/latecoming"> Late Comers</a></li>
								
								<li <?php if(isset($pageid) and $pageid==7.5)echo 'class="active "'; ?>><a href="<?php echo URL?>admin/Earlyleave">Early Leavers </a></li> 
								
								<!--<li <?php if(isset($pageid) and $pageid==7.51)echo 'class="active "'; ?>><a href="<?php echo URL?>admin/tabuler">Tabular</a></li> -->
								
								<li <?php if(isset($pageid) and $pageid==7.2)echo 'class="active "'; ?>><a href="<?php echo URL?>admin/overtime">Overtime </a></li>
								
								<li <?php if(isset($pageid) and $pageid==7.3)echo 'class="active "'; ?>><a href="<?php echo URL?>admin/undertime"> UnderTime </a></li>

								<li <?php if(isset($pageid) and $pageid==7.299)echo 'class="active "'; ?>><a href="<?php echo URL?>admin/notsync"> Not Synced</a></li>
								
								<?php
                               $permis = getAddonPermission($_SESSION['orgid'],'Addon_TimeOff') ;
							  if($permis == 1)
								{
							   ?>
								<li <?php if(isset($pageid) and $pageid==7.4)echo 'class="active "'; ?>><a href="<?php echo URL?>admin/timeoff">On Time off </a></li>
								
								<?php } ?>
								
								
							
								<?php
								$permis = getAddonPermission($_SESSION['orgid'],'Addon_flexi_shif') ;
								if($permis == 1)
								{
								?>
								<li <?php if(isset($pageid) and $pageid==7.21)echo 'class="active "'; ?>><a href="<?php echo URL?>admin/flexi">Flexi Report</a>
								</li>
								<?php } ?>

								<?php
	                 $orgid=$_SESSION['orgid'];
	                if($orgid == 10 || $orgid == 35171){ ?>
	                <li <?php if(isset($pageid) and $pageid==7.786)echo 'class="active"'; ?>>
	                    <a href="<?=URL?>admin/attendance_register">
	                       
	                        Attendance Register
	                    </a>
	                </li>
	            <?php } ?>
								
								
								<!--<li <?php if(isset($pageid) and $pageid==7.22)echo 'class="active "'; ?>><a href="<?php echo URL?>admin/data3month">Archived Attendance</a>
								</li>-->
								
							
				        	<!--<li <?php if(isset($pageid) and ($pageid==7.11 || $pageid==7.13))echo 'class="active "'; ?>>
								<a data-toggle="collapse" data-target="#punchedlocation" data-parent="#sidenav01" class="collapsed"><p>Punched Visits</p>
					            </a>
						</li>
						<div <?php if(isset($pageid) and ($pageid==7.11 || $pageid==7.13))echo 'class="collapse in" aria-expanded="true" style="height: 60px;margin-left:25%"'; else echo 'class="collapse" aria-expanded="false" style="height: 0px;margin-left:25%"' ;?> id="punchedlocation" style="height: 0px;margin-left:25%">
							<ul class="nav nav-list">
							  <li <?php if(isset($pageid) and $pageid==7.13)echo 'class="active"'; ?>><a href="<?php echo URL?>admin/locationReportnamewise">Single Date</a></li>
							  
							  <li <?php if(isset($pageid) and $pageid==7.11)echo 'class="active"'; ?> ><a href="<?php echo URL?>admin/locationReport">Multiple Dates</a></l	i>
							  
							</ul>
					  </div> -->
								
								
								<!--<li <?php if(isset($pageid) and $pageid==7.7)echo 'class="active "'; ?>><a href="<?php echo URL?>admin/employeeSummaryReport">Monthly Summary </a></li>
								
								<li <?php if(isset($pageid) and $pageid==7.8)echo 'class="active "'; ?>><a href="<?php echo URL?>Report/EmployeesWiseReport ">Employees Wise Report </a></li>
								
								<li <?php if(isset($pageid) and $pageid==7.9)echo 'class="active "'; ?>><a href="<?php echo URL?>admin/DepartmentReport ">By Department</a></li>--->
								
								
							<!-- <li <?php if(isset($pageid) and $pageid==7.13)echo 'class="active"'; ?>><a href="<?php echo URL?>admin/locationReportnamewise">New Report</a></li> -->
							   <?php
                               $permis = getAddonPermission($_SESSION['orgid'],'Addon_Payroll') ;
							  if($permis == 1)
								{
							   ?>
							 <li <?php if(isset($pageid) and $pageid==7.14)echo 'class="active"'; ?>><a href="<?php echo URL?>admin/hourlypay">Hourly Pay</a></li>  
								<?php 
								} 
								?>
							</ul>
			     	</div>
	               
			     			


				    <li <?php if(isset($pageid) and ($pageid==3.4 || $pageid==3.5 || $pageid==3.6 || $pageid ==  8.17||$pageid == 3.7))echo 'class="active"'; ?>>
	                    <a data-toggle="collapse" data-target="#summarymenu" data-parent="#sidenav01" class="collapsed">
	                        <i class="fa fa-list"></i>
	                        <p>Summary Reports</p>
	                    </a>
	                </li>
	                
					<div <?php if(isset($pageid) and ($pageid==3.4 || $pageid==3.5 || $pageid==3.6 || $pageid ==  8.17||$pageid ==  3.7 ))echo 'class="collapse in" aria-expanded="true" style="height: 75px;margin-left:25%"'; else echo 'class="panel-collapse collapse" aria-expanded="false" aria-controls="navbar" style="height: 0px;margin-left:25%"' ;?> id="summarymenu" style="height: 0px;margin-left:25%">
						<ul class="nav nav-list">
						
						  <li <?php if(isset($pageid) and $pageid==3.4)echo 'class="active"'; ?>><a href="<?=URL?>dashboard/getSummaryData/1" target="_blank">Today's Summary</a></li>
						  
						  <li <?php if(isset($pageid) and $pageid== 8.17)echo 'class="active"'; ?>><a href="<?php echo URL?>dashboard/getSummaryData/2" target="_blank">Yesterday's Summary</a></li> 
						  
						  <li <?php if(isset($pageid) and $pageid==3.5)echo 'class="active"'; ?>><a href="<?=URL?>Attendance/getWeeklyAverageSummary/1" target="_blank">Weekly Summary</a></li>
						  
						   <li <?php if(isset($pageid) and $pageid==3.6)echo 'class="active"'; ?>><a href="<?=URL?>Attendance/getMonthlyAverageSummary/2" target="_blank">Monthly Summary</a></li>
						   
						  <li <?php if(isset($pageid) and $pageid==3.7)echo 'class="active"'; ?>><a href="<?=URL?>Attendance/attendanceOutsideThefencedArea" target="_blank">Outside the Fence</a></li> 
						</ul>
					 </div>


					 <li <?php if(isset($pageid) and ($pageid==9.007 || $pageid==9.008 || $pageid==9.009 ))echo 'class="active"'; ?>>
	                    <a data-toggle="collapse" data-target="#visit" data-parent="#sidenav01" class="collapsed">

	                        <!-- <i class="fa fa-calendar-o"></i> -->
	                        <!-- <i class="fas fa-walking"></i> -->
	                        <i class="fa fa-calendar-o"></i>
	                        <!-- <i class="fas fa-walking"></i> -->
	                        <!-- <i class="fa fa-walking"></i> -->
	                        Punched Visits</a>
	                </li>

	                	<div <?php if(isset($pageid) and ( $pageid==9.007 || $pageid==9.008 ))echo 'class="collapse in" aria-expanded="true" style="height: 62px;margin-left:20%"'; else echo 'class="collapse"  style="height:0px;margin-left:20%"' ;?> id="visit" style="height: 0px;margin-left:20%">
						<ul class="nav nav-list">
						
						  <?php
								$permis = getAddonPermission($_SESSION['orgid'],'Addon_VisitPunch') ;
								if($permis == 1)
								{?>
								<li <?php if(isset($pageid) and $pageid==9.008)echo 'class="active "'; ?>><a href="<?php echo URL?>admin/locationReportemp">Employees Wise</a>
								</li>
							<?php } ?>
						  
						  <?php
								$permis = getAddonPermission($_SESSION['orgid'],'Addon_VisitPunch') ;
								if($permis == 1)
								{?>
								<li <?php if(isset($pageid) and $pageid==9.007)echo 'class="active "'; ?>><a href="<?php echo URL?>admin/locationReport">Date Wise</a>
								</li>
							<?php } ?>
						</ul>
					</div>
				   
				   
				   <li <?php if(isset($pageid) and $pageid==112)echo 'class="active"'; ?>>
				  <a href="<?php echo URL?>admin/monthlysummary">
				  <i class="fa fa-calendar-o" aria-hidden="true"></i>
				  <p> Monthly Employee wise Summary</p>
				   </a>
				  </li>
				   
				  <li <?php if(isset($pageid) and $pageid==111)echo 'class="active"'; ?>>
				  <a href="<?php echo URL?>admin/attendanceRoaster">
				  <i class="fa fa-calendar" aria-hidden="true"></i>
				  <p> Monthly Register</p>
				   </a>
				  </li>	
				  
				  	
				  
				  <!------Another multipl day shifts---------->
				 <!-- <li <?php if(isset($pageid) and $pageid==113)echo 'class="active"'; ?>>
				  <a href="<?php echo URL?>userprofiles/monthlyreport">
				  <i class="fa fa-calendar-o" aria-hidden="true"></i>
				  <p> Monthly Summary</p>
				   </a>
				  </li>	-->
					
					 
					 <!-- 
					 <li <?php if(isset($pageid) and ($pageid==13 || $pageid==13.1))echo 'class="active"'; ?>>
	                    <a data-toggle="collapse" data-target="#approve" data-parent="#sidenav01" class="collapsed">
	                        <i class="fa fa-check"></i>
	                        <p>Approve Request</p>
	                    </a>
	                </li>
					
					<div <?php if(isset($pageid) and ($pageid==13 || $pageid==13.1))echo 'class="collapse in" aria-expanded="true" style="height: 40px;margin-left:25%"'; else echo 'class="panel-collapse collapse" aria-expanded="false" aria-controls="navbar" style="height: 0px;margin-left:25%"' ;?> id="approve" style="height: 0px;margin-left:25%">
						<ul class="nav nav-list">
						  <li <?php if(isset($pageid) and $pageid==13)echo 'class="active"'; ?> ><a href="<?=URL?>userprofiles/approvetimeoff">Time Off</a></li>
						  
						 <li <?php if(isset($pageid) and $pageid==13.1)echo 'class="active"'; ?>><a href="<?=URL?>userprofiles/approvetimeleave">Leave</a></li> 
						</ul>
					 </div> -->
	               
					<!--
					<li <?php if(isset($pageid) and ($pageid==14))echo 'class="active"'; ?>>
	                   <a href="<?= URL?>Admin/Userpermission" >
	                        <i class="fa fa-lock"></i>
	                        <p>Permissions</p>
	                    </a>
	                </li> -->
					
	               <!--<li <?php if(isset($pageid) and $pageid==8)echo 'class="active"'; ?>>
	                    <a href="">
	                        <i class="fa fa-cogs "></i>
	                        <p>Settings</p>
	                    </a>
	                </li>
		         -->			
	               
	               
					
	            
				
				<!--<li <?php if(isset($pageid) and ($pageid==1.1 || $pageid==1.2))echo 'class="active "';?>>
				
	                   <a  href="#" data-toggle="collapse" data-target="#settingmenu" data-parent="#sidenav01" class="collapsed">
	                        <i class="fa fa-cogs"></i>
	                        <p>Settings</p>
	                    </a>
						</li>
						 <div <?php if(isset($pageid) and ($pageid==1.1 || $pageid==1.2))
					 echo 'class="collapse in" aria-expanded="true" style="height: 100px;margin-left:25%"'; else echo 'class="collapse" aria-expanded="false" style="height: 0px;margin-left:25%"'; ?> id="settingmenu" style="height: 0px;margin-left:25%">
						<ul class="nav nav-list">
									<li <?php if(isset($pageid) and $pageid==1.1)echo 'class="active "'; ?>><a href="<?php echo URL?>dashboard/profile">My Profile</a></li>
									<li <?php if(isset($pageid) and $pageid==1.2)echo 'class="active "'; ?>><a href="<?php echo URL?>dashboard/changePassword">Change Password</a></li>
									<!--<li><a href="<?=URL?>Logout">Logout</a></li>
								</ul>
								</div>-->
							
            
				<li <?php if(isset($pageid) and ($pageid==12.1 || $pageid==12.2 || $pageid==12.3 || $pageid==12.4 || $pageid==12.5 ||$pageid==9.2 ||$pageid==9.1||$pageid==4 || $pageid==5 ||  $pageid==6||  $pageid==12.7||$pageid==12.9))echo 'class="active "';?>>
					<a data-toggle="collapse" data-target="#settingmenu" data-parent="#sidenav01" class="collapsed" onclick = "slide()" >
					<i class=" fa fa-cogs "></i>
	                        <p>Settings</p>
	                </a>
			    </li>
						 
			<div <?php if(isset($pageid) and ($pageid==12.1 || $pageid==12.2 || $pageid==12.3 || $pageid==12.4 || $pageid==12.5 ||$pageid==9.2 ||$pageid==9.1||$pageid==4  || $pageid==5 ||  $pageid==6 ||  $pageid==12.7|| $pageid==12.9 || $pageid==12.11)) 
				 echo 'class="collapse in" aria-expanded="true" style="height: 375px;margin-left:15%"'; else echo 'class="collapse"  aria-expanded="false" style="height: 0px;margin-left:15%"'; ?> id="settingmenu" style="height: 0px;margin-left:15%">
	                    
				<ul class="nav nav-list">
					<li <?php if(isset($pageid) and $pageid==12.1)echo 'class="active "'; ?>><a href="<?=URL?>dashboard/profile">Company Profile</a></li>
								
					<!--<li <?php if(isset($pageid) and $pageid==12.2)echo 'class="active "'; ?>><a href="<?=URL?>dashboard/changePassword"> Change Password</a></li>-->
					
					<li <?php if(isset($pageid) and $pageid==9.2)echo 'class="active"'; ?>><a href="<?=URL?>admin/holiday">Holidays</a>
					</li>
					
					<li <?php if(isset($pageid) and $pageid==4)echo 'class="active"'; ?>>
	                    <a href="<?=URL?>admin/shifts">
	                       
	                        <p>Shifts</p>
	                    </a>
	                </li>	
	               
						  <li <?php if(isset($pageid) and $pageid==5)echo 'class="active"'; ?> ><a href="<?=URL?>admin/departments">Departments/Sites</a>
						  </li>
						 
	                <li <?php if(isset($pageid) and $pageid==6)echo 'class="active"'; ?>>
	                    <a href="<?=URL?>admin/designations">
	                       
	                        <p>Designations</p>
	                    </a>
	                </li>	

	                <li <?php if(isset($pageid) and $pageid==7777)echo 'class="active"'; ?>>
	                    <a href="<?=URL?>dashboard/selfie">
	                       
	                        <p>Permissions</p>
	                    </a>
	                </li>
	                <?php
	                 $orgid=$_SESSION['orgid'];
	                if($orgid == 36706 || $orgid == 10){ ?>
	                <li <?php if(isset($pageid) and $pageid==12.11)echo 'class="active"'; ?>>
	                    <a href="<?=URL?>admin/qrcodeoption">
	                       
	                        <p>QR Code Options</p>
	                    </a>
	                </li>
	            <?php } ?>
				   	<li <?php if(isset($pageid) and $pageid==12.3)echo 'class="active "'; ?>><a href="<?=URL?>dashboard/alertSetting">Alerts</a></li> 
						
						<?php 
                         $permis = getAddonPermission($_SESSION['orgid'],'Addon_Payroll') ;
							if($permis == 1)
									{
						?>
						
						<li <?php if(isset($pageid) and $pageid==12.5)echo 'class="active "'; ?>><a href="<?=URL?>dashboard/hourlypaySetting">Hourly Rate</a></li>  
									<?php } ?>
								
							<?php	if($_SESSION['specialCase']=='RAKP') { ?>
								
								<?php } else {
                                     // check addon permission by sohan
					        $permis = getAddonPermission($_SESSION['orgid'],'Addon_GeoFence') ;
									if($permis == 1)
									{
								?>
								<li <?php if(isset($pageid) and $pageid==12.4){echo 'class="active "'; }?>><a href="<?=URL?>dashboard/geoLocations"> Geo-Fence</a></li>
								
								<?php 
							    }
				               }
							   ?>
								
					<li <?php  if(isset($pageid) and $pageid==12.7){echo 'class="active "'; }?>><a href="<?=URL?>admin/activitylog">Activity Log</a></li>
						
						 <?php
                               // $permis = getAddonPermission($_SESSION['orgid'],'Addon_Edit') ;
                               // $permis1 = getAddonPermission($_SESSION['orgid'],'Addon_Delete') ;
							   // //echo $permis;
							  // // echo $permis1;
							  // if($permis == 1 || $permis1==1)
								// {
							   ?>
					<!--<li <?php //if(isset($pageid) and $pageid==12.9){echo 'class="active "'; }?>><a href="<?=URL?>admin/attendancelog">Attendance Log</a></li>--> 
							<?php	//}  ?>
				</ul>
				 
		    	</div>
				
			<li <?php if(isset($pageid) and ($pageid==3.411 || $pageid==3.511 ))echo 'class="active"'; ?>>
	                    <a data-toggle="collapse" data-target="#summarymenu2" data-parent="#sidenav01" class="collapsed">
	                        <i class="fa fa-archive"></i>
	                        <p>Archived Attendances</p>
	                    </a>
	                </li>

	                	<div <?php if(isset($pageid) and ( $pageid==3.411 || $pageid==3.511 ))echo 'class="collapse in" aria-expanded="true" style="height: 62px;margin-left:20%"'; else echo 'class="collapse"  style="height:0px;margin-left:20%"' ;?> id="summarymenu2" style="height: 0px;margin-left:20%">
						<ul class="nav nav-list">
						
						  <li <?php if(isset($pageid) and $pageid==3.411)echo 'class="active"'; ?>><a href="<?php echo URL?>admin/archiveattendance3months">Present</a></li>
						  
						  <li <?php if(isset($pageid) and $pageid== 3.511)echo 'class="active"'; ?>><a href="<?php echo URL?>admin/absent_archived" >Absent</a></li>
						</ul>
					</div>
				  
	         </ul>
					
					
	    	</div>
			<?php
				  } 
                  else
				  { 
				?>
				<div class="logo">
				<a href="<?=URL?>Myplan" class="simple-text">
				<img src="<?=URL?>../assets/img/logo.png" hieght="20px" width="150px"/>
				</a>
			   </div>
			   <div  class="sidebar-wrapper" data-color="purple" data-image="<?php echo URL; ?>../assets/img/sidebar-1.jpg">
			   <ul class="nav">
					  <li class="active">
						<a href="<?php echo URL; ?>Myplan"  >
						<i class="fa fa-cube "></i>
							  <p>My Plan</p>
						</a>
					  </li>
				    
					<!-- <li <?php if(isset($pageid) and $pageid==1234)echo 'class="active "'; ?> >
						<a href="<?= URL ?>Myplan/balancedues">
						<i class="fa fa-check-circle"></i>
								<p>Due Payment Notification</p>
						</a>
					</li> --> 			   
			   </ul>
			   
			   </div>
				<?php } ?>
			
	    </div>
		
		<script>
		
		/*$(document).ready(function() {
		
		$("#sidenav01").accordion({
		
         active: false,
         collapsible: true          
          });
          });*/
		
		  function slide()
		    { 
				  $("#sidenav01").animate({ scrollTop: $(document).height() }, 1000);
			};
		
		</script>
		
		</body>
		
		</html>