<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/styleqr.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/styleqr2.css" />
	<title>Active Employee</title>
	<style>



	
		.btn1>input[type='file']
		{
			position: absolute;
			top: 0;
			right: 0;
			min-width: 100%;
			min-height: 100%;
			font-size: 100px;
			text-align: right;
			opacity: 0;
			outline: none;
			background: white;
			cursor: inherit;
			display: block;
		}
		
		.red
		{
			color:red;
			font-weight:'bold';
			font-size:16px;
		}
			
			.delete{
			cursor:pointer;
					}
					
			div.dt-buttons
			{
			position:relative;
			float:left;
			margin-left:15px;
			}
		
				  #example thead tr th.headerSortUp  
				  {
				   background-image: url('<?=URL?>../assets/img/up_arrow.png');
				  }
              #example thead tr th.headerSortDown  {
              background-image: url('<?=URL?>../assets/img/down_arrow.png');
													}
			 #example tbody tr td.lalign 
					{
             text-align: left;
                   }
				   .id
				   {
					   color:grey;
				   }
				 .empname
				 {
					font-Size:18px; 
				 }
	.t2{display:none;}
	</style>
	<style type="text/css" media="print" >
		
		 .print {
			  margin-left:40px;
			 align:center;
			 border:2px #666 solid; padding:5px;  
				}

          .nonPrintable
					{
						display:none;
					} /*class for the element we don’t want to print*/
		  
		  
	#cart_cancel
	{
		background-color: transparent!important;
        border: none;
        float: right;
	}	
	
     </style>
	 <!-- pre loader -->
	 <style>
	  /* Preloader */
	  #preloader {
	  position: fixed;
	  top: 0;
	  left: 0;
	  right: 0;
	  bottom: 0;
	  background-color: #fff;
	  /* change if the mask should have another color then white */
	   z-index: 99;
	  /* makes sure it stays on top */
	}
		#status {
		  width: 200px;
		  height: 200px;
		  position: absolute;
		  left: 60%;
		  /* centers the loading animation horizontally one the screen */
		  top: 50%;
		  /* centers the loading animation vertically one the screen */
		  background-image: url(https://raw.githubusercontent.com/niklausgerber/PreLoadMe/master/img/status.gif);
		  background-repeat: no-repeat;
		  background-position: center;
		  margin: -100px 0 0 -100px;
		  /* is width and height divided by two */
		}
	#addEmp{
       overflow: scroll;
   }
	 </style>
	 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	 
</head>

      <div class="modal fade" id="loadmodel" role="dialog" data-backdrop="static" data-keyboard="false" style="z-index:11111111;" >
			<div class="modal-dialog">
				<center>
					<img src="<?php echo URL; ?>../assets/img/loaderimg.gif" alt="loader image" height="20%" width="20%" />
				</center>
			</div>
       </div> 
<body style="" >
         
	<div class="wrapper">
	
		<?php
			$data['pageid']=2;
			$this->load->view('menubar/sidebar',$data);
		?>
	    <div class="main-panel">
			<?php
				$this->load->view('menubar/navbar');
			?>
			
			<div class="content" id="content">
			  <!-- loader area 
			   <div id = "loader" hidden >
					<center>
					 <img src="<?php echo URL; ?>../assets/img/loaderimg.gif" alt="loader image" height="20%" width="20%" />
					</center>
					 
		       </div>-->
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
		       <!-- <?php echo $status; ?>  -->

		       <!-- <?php echo $userlimit ; ?> -->
		       <!-- <?php echo $data['userlimit'];?> -->
			   
	            <div class="container-fluid" id="maincontainerdiv" >
	                <div class="row">
	                    <div class="col-md-12">
	                        <div class="card">
	                            <div class="card-header" data-background-color="green"> 
	                              <p class="category" style="color:#ffffff;font-size:17px;" > List of Active Employees</p>
								  <a rel="tooltip"  data-placement="bottom" title="Help" class="btn btn-success btn-sm toggle-sidebar pull-right " style="position:relative;margin-top:-30px;" >
								  <i class="fa fa-question"></i></a>
	                            </div>
	                            <div class="card-content">
									<div id="typography">
										<div class="title">
											<div class="row">
												<!--<div class="col-md-2" style="margin-top:-10px;" >
													<h3>Manage Active Employees </h3>
												</div>-->
												<div class="col-md-12 text-left" >
												<button title="Add" class="btn btn-sm btn-success addemp" data-toggle="modal" data-target="#addEmp" type="button" style="">	
												 <i class="fa fa-plus">Add Employee</i>
											   </button>
												
                                               <a href="userprofiles/emport/2" class="btn btn-sm btn-success addemp" title="Add multiple employees through import." style="padding:5px 8px;" style=""><i class="fa fa-file-excel-o">&nbsp;Import </i></a>
											   
												<button title="Self Registration"  class="btn btn-sm btn-success addemp" data-toggle="modal" data-target="#inviteEmp" type="button" style=" font-size:5px ">	
												 <i class="fa fa-plus"> Self Registration </i>
												</button>
												
												<button title="Select employees to assign "  class="btn btn-sm btn-success"  id="frm-example" data-toggle="modal"  type="button" style="" onclick="updateshift();">
												<i class="fa fa-plus"> Assign Shift </i>
												</button>
												
												<button title="Select employees to assign"  class="btn btn-sm btn-success"  id="frm-example" data-toggle="modal"  type="button" style="" onclick="updateDesignation();">
												<i class="fa fa-plus"> Assign Designation </i>
												</button>
												
												<button title="Select employees to assign"  class="btn btn-sm btn-success"  id="frm-example" data-toggle="modal"  type="button" style="" onclick="updateDepartment();">
												<i class="fa fa-plus"> Assign Department </i>
												</button>
												
												 
											<button class="btn btn-sm btn-success" title="Generate QRCode" style="padding:5px 8px;" style="padding:5px 8px;" onclick="QRcode();" id="qrgen"><i class="fa fa-qrcode">&nbsp;QR Code</i></a>	
											</button>
											
												<?php
                                                $permis = getAddonPermission($_SESSION['orgid'],'Addon_GeoFence');
												
												if($permis == 1)
												{
												?>
													<button  title="Select employees to assign" class="btn btn-sm btn-success"  id="frm-example" data-toggle="modal"  type="button" style="" onclick="updateGeolocation();">
														<i class="fa fa-plus"> 
															Assign Geo Center</i>
													</button>
													<?php } ?>
													
												</div>
													<div class="col-md-4 text-right" style="float:right;">	
													</div>
													
											</div>
										</div>
										<div class="row" style="overflow-x:scroll;">
											<table id="example" class="display table" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th style="background-image:none"!important><input type="checkbox" id="select_all" name="select_all" value=""/></th>
													<th>Photo</th>
													<th class="" width="15%">Name</th>
													<th class="" width="15%">Code</th>
													<th width="15%">User Name/ Email </th>
													<th>Department</th>
													<th>Designation</th>
													<th>Shift</th>
												    <th>User ID/Phone</th>
													<th style="max-width:100px;" style="background-image:none"!important>Status</th>
													<th style="max-width:100px;">Geo Center</th>
													<!--<th>Password</th>-->
													<th>Permissions</th>
													<th class="text-left" width="10%" 
													style="background-image:none"!important>Action</th>
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
					<p class="copyright pull-right" style="padding-right:25px;" >
					Copyright &copy;<script>document.write(new Date().getFullYear())</script>
					Ubitech Solutions. All rights reserved.
					</p>
				</a>
				</div>
			</footer>
		 </div>
     </div>
<!-- Modal open add employee-->


<div id="addEmp" class="modal fade" role="dialog" style="z-index:10000000;" >
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Add Employee</h4>
      </div>
      <div class="modal-body">
		<form method="POST" id="empFrom" enctype="multipart/form-data" name="myform">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label" id="FNLable">First Name <span class="red"> *</span></label>
						<input type="text" id="firstName" class="form-control " required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Email<?php if($_SESSION['specialCase']=='RAKP') { ?><span class="red"> *</span><?php }else{?>(optional)<?php } ?> <span class="red"> </span></label>
						<input type="email" id="email" class="form-control " pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" >
					</div>
				</div>
				<!-- <div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label" id="shiftNameLable">Last Name <span class="red"> *</span></label>
						<input type="text" id="lastName" class="form-control " required>
					</div>
				</div> -->
			</div>
			
			<!--<div class="row">
			<?php 
			if($_SESSION['specialCase']=='RAKP') { //mandatory ?>
				<div class="col-md-12">
					<div class="form-group label-floating">
						<label class="control-label">Employee Code<span class="red">*</span></label>
						<input type="text" id="ecode" class="form-control" required>
					</div>
				</div>
			
			<?php }else {?>
			
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Employee Code(optional)</label>
						<input type="text" id="ecode" class="form-control" >
					</div>
				</div>
				   <?php 
                      $permis = getAddonPermission($_SESSION['orgid'],'Addon_Payroll') ;
					?> 
				<div class="col-md-6">
				 <div class="form-group label-floating">
					<label class="control-label">Geo Center<span class="red"> </span></label>
						<select class="form-control" id="areaAssign" <?php if($permis==0) echo "disabled"; ?> >
						<option value="0" >-Select-</option>
						<?php
							$data= json_decode(getAllArea($_SESSION['orgid']));
							for($i=0;$i<count($data);$i++) {
						
							echo "<option value='".$data[$i]->id."'>".$data[$i]->Name."</option>";
					}	
						?>
						</select>
				</div>
				</div>
				<?php } ?>
				
			</div>-->
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Department
						<?php if($_SESSION['specialCase']!='RAKP') { ?><span class="red"> *</span> <?php } ?></label>
						<select id="dept" class="form-control ">
							<option value="0">-Select-</option>
							<?php
							$data= json_decode(getAllDept($_SESSION['orgid']));
							for($i=0;$i<count($data);$i++)
								echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
							?>
						</select>
					</div>
				</div>
				
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Contact No. <span class="red"> *</span></label>
						<input type="text" pattern="[0-9]{1}[0-9]{9}" class="form-control numeric" id="cont" required>
					</div>
				</div>
			</div>
			
			<div class="row">
			<div class="col-md-6">
					<div class="form-group label-floating" >
						<label class="control-label">Password<span class="red"> *</span></label>
						<input type="text" id="password" class="form-control" value="123456"  title="Password is initially set. It can be changed later on by the Admin or the Employee" readonly>
					</div>
			</div>
			<div class="col-md-6">
				<div class="form-group label-floating" style="display:none">
					<label class="control-label">Confirm Password<span class="red"> *</span></label>
					<input type="password" id="cpassword" class="form-control " >
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group label-floating">		
					<label class="control-label">Shift<span class="red"> *</span></label>
						<select id="shift" class="form-control ">
							<option value="0">-Select-</option>
							<?php
							$data= json_decode(getAllShift($_SESSION['orgid']));
							for($i=0;$i<count($data);$i++)
								echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
							?>
						</select>
				</div>
			</div>
			</div>
			
			
			<!--<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Date Of Birth<span class="red"> *</span></label>
						<input type="text" id="dob"  class="form-control datepicker" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Date Of Joining<span class="red"> *</span></label>
						<input type="text" id="doj"   class="form-control datepicker" required >
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group label-floating">
						<label class="control-label">DOC<span class="red"> *</span></label>
						<input type="text" id="doc" class="form-control datepicker" >
					</div>
				</div>
			</div>-->
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating ">
						<label class="control-label">Country</label>
						<select id="country" class="form-control">
							<option value="0">-Select-</option>
							<?php
							$data= json_decode(getAllCountries());
							for($i=0;$i<count($data);$i++)
								echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
							?>
						</select>
					</div>
				</div>
				
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Designation<?php if($_SESSION['specialCase']!='RAKP') { ?><span class="red"> *</span> <?php } ?></label>
							<select id="desg" class="form-control">
								<option value="0">-Select-</option>
								<?php
								$data= json_decode(getAllDesg($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++)
									echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								?>
							</select>
					</div>
				</div>
			</div>
			<div class="row">
								
			</div> <!-- row end -->
			<!--<div class="row">
			<div class="col-md-6" >
			     <div class="form-group" >
						<label class="control-label">Profile Photo<span class="red"> *</span></label>
						<input id="profile" class="form-control" type="file" name="profile" onchange="changeImgUpload1(this)">
				</div>
			  </div>
			  <div class="col-md-6" >
			     <div class="form-group" >
			  <img id="imageAdd" src="" width="150px" height="150px" class="thumbnail"  
			  onerror="this.src='<?php echo IMGURL3."avatars/male.png"?>'"/>
			  </div>
			  </div>
			</div>-->
			<hr>
							<b>Optional Information</b>							
								<div class="row">
									<div class="col-md-6" >
								     
									     
								  
									 <div class="form-group label-floating">
											<label class="control-label">Hourly Rate(optional) </label>
											<select id="hourlyrate" class="form-control "  >
													<option value="0">-Select-</option>
													<?php
													$data= json_decode(getAllRate($_SESSION['orgid']));
													for($i=0;$i<count($data);$i++)
														echo '<option value='.$data[$i]->Id.'>'.$data[$i]->Rate.'</option>';
													?>
												</select>
										
									</div>
								  </div>
									<div class="col-md-6">
											<div class="form-group label-floating">
												<label class="control-label">Permission</label>
												<select class="form-control" id="sstatus" >
												   <option value='1' >Admin - <small>for App only</small></option>
												   <option value='2' >Dept Head
													</option>
													<option value='0' selected>User</option>
												</select>
											</div>
									</div>
								
									
								</div>
			<!--<div class="row">
				<div class="col-md-6">
						<div class="form-group label-floating">
							<label class="control-label">Permissions</label>
							<select class="form-control" id="sstatus" >
								<option value='1' >Admin - <small>for App only</small></option>
								<option value='0' selected>User</option>
							</select>
						</div>
				</div>
				<?php 
             $permis = getAddonPermission($_SESSION['orgid'],'Addon_Payroll') ;
			 ?> 
			
			  <div class="col-md-6" >
			     <div class="form-group label-floating">
						<label class="control-label">Hourly Rate (optional)</label>
						<select id="hourlyrate" class="form-control " <?php if( $permis==0) echo "disabled" ?> >
								<option value="0">-Select-</option>
								<?php
								$data= json_decode(getAllRate($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++)
									echo '<option value='.$data[$i]->Id.'>'.$data[$i]->Rate.'</option>';
								?>
							</select>
					
				</div>
			  </div>
            
			
				<!--<div class="col-md-6">
					<div class="form-group label-floating" style="display:none">
						<label class="control-label"> Employment Status<span class="red"> *</span></label>
						<select class="form-control" id="status" >
							<option value='1' selected>Active</option>
							<option value='0'>Inactive</option>
						</select>
					</div>
				</div>
			</div>-->
			            <?php 
                           $permis = getAddonPermission($_SESSION['orgid'],'Addon_Payroll') ;
						 ?> 
			<!--<div class="row" >
			  <div class="col-lg-6" >
			     <div class="form-group label-floating">
						<label class="control-label">Hourly Rate </label>
						<select id="hourlyrate" class="form-control " <?php if( $permis==0) echo "disabled" ?> >
								<option value="0">-Select-</option>
								<?php
								$data= json_decode(getAllRate($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++)
									echo '<option value='.$data[$i]->Id.'>'.$data[$i]->Rate.'</option>';
								?>
							</select>
					
				</div>
			  </div>
            </div>	-->		
			
			<!---<div class="row">
				<div class="col-md-3">
					<div class="form-group label-floating">
						<label class="control-label">Blood Group<span class="red"> *</span></label>
							<select id="bg" class="form-control ">
								<option value="0">-Select-</option>
								<?php
								$data= json_decode(getAllBloodGroup());
								for($i=0;$i<count($data);$i++)
									echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								?>
							</select>
					</div>
				</div>-->
				
				<!--<div class="col-md-3">
					<div class="form-group label-floating">
						<label class="control-label">Marriatal Status<span class="red"> *</span></label>
							<select id="ms" class="form-control ">
								<option value="0">-Select-</option>
								<?php
								$data= json_decode(getAllOther('MaritalStatus'));
								for($i=0;$i<count($data);$i++)
									echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								?>
							</select>
					</div>
				</div>-->
				<!--<div class="col-md-3">
					<div class="form-group label-floating">
						<label class="control-label">Religion<span class="red"> *</span></label>
						<select id="rel" class="form-control ">
							<option value="0">-Select-</option>
							<?php
							$data= json_decode(getAllReligion());
							for($i=0;$i<count($data);$i++)
								echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
							?>
						</select>
					</div>
				</div>
				
			</div>-->
			<!--<div class="row">
			<div class="col-md-3">
					<div class="form-group label-floating">
						<label class="control-label">Gender<span class="red"> *</span></label>
							<select id="gen" class="form-control">
								<option value="0">Female</option>
								<option value="1">Male</option>
								<option value="2">Transgender</option>
							</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group label-floating">
						<label class="control-label">Nationality<span class="red"> *</span></label>
							<select id="nationality" class="form-control ">
								<option value="0">-Select-</option>
								<?php
								$data= json_decode(getAllNationality());
								for($i=0;$i<count($data);$i++)
									echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								?>
							</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group label-floating">
						<label class="control-label">Country<span class="red"> *</span></label>
						<select id="country" class="form-control">
							<option value="0">-Select-</option>
							<?php
							$data= json_decode(getAllCountries());
							for($i=0;$i<count($data);$i++)
								echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
							?>
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group label-floating">
						<label class="control-label">City<span class="red"> *</span></label>
						<select id="city" class="form-control ">
							<option value="0">-Select-</option>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Status<span class="red"> *</span></label>
						<select class="form-control" id="status" >
							<option value='1' selected>Active</option>
							<option value='0'>Inactive</option>
						</select>
					</div>
				</div>
				
					<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Shift<span class="red"> *</span></label>
							<select id="shift" class="form-control ">
								<option value="0">-Select-</option>
								<?php
								$data= json_decode(getAllShift($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++)
									echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								?>
							</select>
					</div>
				</div>
				
			</div>-->
			
				<!--<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Address<span class="red"> *</span></label>
						<textarea class="form-control" id="addr"></textarea>
					</div>
				</div>-->
			<div class="row">
			<?php 
			if($_SESSION['specialCase']=='RAKP') { //mandatory ?>
				<div class="col-md-12">
					<div class="form-group label-floating">
						<label class="control-label">Employee Code<span class="red">*</span></label>
						<input type="text" id="ecode" class="form-control" required>
					</div>
				</div>
			<?php }else {?>
			
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Employee Code(optional)</label>
						<input type="text" id="ecode" class="form-control" >
					</div>
				</div>
				   <?php 
                      $permis = getAddonPermission($_SESSION['orgid'],'Addon_Payroll') ;
					?> 
				<div class="col-md-6">
				 <div class="form-group label-floating">
					<label class="control-label">Geo Center(optional)</label>
						<select class="form-control" id="areaAssign" <?php if($permis==0) echo "disabled"; ?> >
						<option value="0" >-Select-</option>
						<?php
							$data= json_decode(getAllArea($_SESSION['orgid']));
							for($i=0;$i<count($data);$i++) {
						
							echo "<option value='".$data[$i]->id."'>".$data[$i]->Name."</option>";
					}	
						?>
						</select>
				</div>
				</div>
				<?php } ?>
				
			</div>
			<div class="row">
			<div class="col-md-6">
									<div class="form-group label-floating">
										<div style="display:inline-flex;align-items:center;">
											<label class="">Profile Photo
											</label>&nbsp;&nbsp;&nbsp;
											<img id="imageAdd" src="" width="150px" height="150px" class="thumbnail" onerror="this.src=
									  '<?php echo IMGURL3."avatars/male.png"?>'"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<!--<i class="pencil fa fa-pencil" style="color:purple	;" 
											 title="choose a file">
											</i>
											<input type="file" name="profileE" id="profileE"  onchange="changeImgUpload(this)">-->
										<span  style="margin-bottom:50px;margin-right:-30px">
											<i class="fa fa-remove delete1" rel="tooltip" style="color:purple;" data-placement="bottom" title="Remove Image"></i>
								</span>	
										<span class="btn1 fa fa-pencil" style="color:purple;margin-left:20px">
										<input type="file" class="form-control" name="profile" id="profile"  onchange="changeImgUpload1(this)" file-upload accept="image/*">
										</span>
										</div>
									</div>
								</div>	
				</div>					
			<div class="clearfix"></div>
		
		
		
		
      </div>
      <div class="modal-footer">
        <button type="button" id="save"  class="btn btn-success">Save</button>
    <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
        <button type="button" id="resetAdd" class="btn btn-default">Reset</button>
      </div>
	  </form>
    </div>
  </div>
  </div>
 
<!---modal close add employee--->


<!-- Modal open Invite employee-->
<div id="inviteEmp" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Employee Self Registration</h4>
      </div>
      <div class="modal-body">
		<div>
			<h3>Employee Self Registration</h3>
		</div>
			<form>
					<input id="inveitedEmails" class="form-control" type="email" placeholder="Employee Email(s)  "/>
					<strong>Note: Seperate multiple emails by comma</strong>
				
			</form>
		<div class="clearfix"></div>		
      </div>
      <div class="modal-footer">
        <button type="button" id="sendInvitation"  class="btn btn-success">Send Registration Link</button>
        <button type="button" id="resetInvitation" class="btn btn-default">Reset</button>
      </div>
    </div>
  </div>
  </div>
<!---modal close Invite employee--->
<!-- Modal open edit employee-->
<div id="addEmpE" class="modal fade" role="dialog" style="z-index:10000000"  >
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Update employee details</h4>
      </div>
      <div class="modal-body">
		<form id="empFromE" method="POST" enctype="multipart/form-data" name="myformE">
		<input type="hidden" id="id" />
			<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating1">
						<label class="control-label" id="FNLableE">
						Name<span class="red">*</span></label>
						<input type="text" id="firstNameE" class="form-control " >
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating1">
						<label class="control-label" id="LNLableE">
						Last Name <span class="red"> *</span>
						</label>
						<input type = "text" id="lastNameE" class="form-control " >
					</div>
				</div>
			</div>
			
			<!--<div class="row">
			<?php 
			if($_SESSION['specialCase']=='RAKP') { ?>
				<div class="col-md-6">
					<div class="form-group label-floating1">
						<label class="control-label">Employee Code</label>
						<input readonly type="text" id="ecodeE" class="form-control" required>
					</div>
				</div>
				<?php }else {?>
				 <div class="col-md-6">
					<div class="form-group label-floating1">
						<label class="control-label">Employee Code(optional)</label>
						<input type="text" id="ecodeE" class="form-control">
					</div>
				</div>
				 <?php }?>
				
				<?php 
                         $permis = getAddonPermission($_SESSION['orgid'],'Addon_GeoFence') ;
					?> 
				<div class="col-md-6">
					<div class="form-group label-floating1">
						<label class="control-label">Geo Center<span class="red"></span></label>
						<select id="areaAssinE" class="form-control" <?php if($permis==0) echo "disabled" ?>  >
						
							<option value="0">-Select-</option>
							<?php
							$data= json_decode(getAllArea($_SESSION['orgid']));
							for($i=0;$i<count($data);$i++)
								{
							echo "<option value='".$data[$i]->id."'>".$data[$i]->Name."</option>";
					            }	
						?>
						</select>
					</div>
				</div>
			</div>-->
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating1">
						<label class="control-label">Email</label>
						<input type="email" id="emailEE1" class="form-control " pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" >
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating1" style="margin-top:21px;">
						<label class="control-label">Contact No.  <span class="red"> *</span></label>
						<input type="text" pattern="[0-9]{1}[0-9]{9}"  class="form-control numeric" id="contE">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
						<div class="form-group label-floating1">
							<label class="control-label">Password<span class="red"> *</span></label>
							<input type="password" id="passwordE" class="form-control">
						</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating1">
						<label class="control-label">Shift<span class="red"> *</span></label>
							<select id="shiftE" class="form-control ">
								<option value="0">-Select-</option>
								<?php
								$data= json_decode(getAllShift($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++)
									echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								?>
							</select>
					</div>
				</div>
			</div>
			
			<div class="row">
			  <!--<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Shift<span class="red"> *</span></label>
							<select id="shiftE" class="form-control ">
								<option value="0">-Select-</option>
								<?php
								$data= json_decode(getAllShift($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++)
									echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								?>
							</select>
					</div>
				</div>-->
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Department<?php if($_SESSION['specialCase']!='RAKP') { ?><span class="red">*</span> <?php } ?></label>
						<select id="deptE" class="form-control ">
							<option value="0">-Select-</option>
							<?php
							$data= json_decode(getAllDept($_SESSION['orgid']));
							for($i=0;$i<count($data);$i++)
								echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
							?>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Designation<?php if($_SESSION['specialCase']!='RAKP') { ?><span class="red"> *</span> <?php } ?></label>
							<select id="desgE" class="form-control ">
								<option value="0">-Select-</option>
								<?php
								$data= json_decode(getAllDesg($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++)
									echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								?>
							</select>
					</div>
				</div>
				
			</div>
			<!--<div class="row">
				 <div class="col-md-6" >
						<div class="form-group" >
							<img id="imageE" src="" width="150px" height="150px" class="thumbnail"/>	
						</div>
				  </div>
				<div class="col-md-6" >
					 <div class="form-group" >
							<label class="control-label">Profile Photo<span class="red">*</span></label>
								<input id="profileE" class="form-control" type="file" name="profileE" onchange="changeImgUpload(this)">
					 </div>
				 </div>
			</div>-->
			<div class="row">
				<!--<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Designation<?php if($_SESSION['specialCase']!='RAKP') { ?><span class="red"> *</span> <?php } ?></label>
							<select id="desgE" class="form-control ">
								<option value="0">-Select-</option>
								<?php
								$data= json_decode(getAllDesg($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++)
									echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								?>
							</select>
					</div>
				</div>-->
				
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Employment Status
							<span class="red">*</span>
						</label>
						<select class="form-control" id="statusE" >
							<option value='1' selected >Active</option>
							<option value='0'>Inactive</option>
						</select>
					</div>
				</div>

					<div class="col-md-6" style="margin-top: -36px;"> 
					<div class="form-group ">
						<label class="control-label">Country</label>
						<select id="countryE" class="form-control">
							<option value="0">-Select-</option>
							<?php
							$data= json_decode(getAllCountries());
							for($i=0;$i<count($data);$i++)
								echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
							?>
						</select>
					</div>
				</div>
				
				</div>

				
			<hr>
			<b>Optional Information</b>
			<div class="row">
			        
				 <div class="col-lg-6" >
			       <div class="form-group label-floating">
						<label class="control-label">Hourly Rate(optional) </label>
						<select id="hourlyrateE" class="form-control" >
								<option value="0">-Select-</option>
								<?php
								$data= json_decode(getAllRate($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++)
									echo '<option value='.$data[$i]->Id.'> '.$data[$i]->Rate.' </option>';
								?>
						</select>
				   </div>
			    </div>
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Permissions</label>
						<select class="form-control" id="sstatusE" >
							<option value='1' >Admin - <small>for App only</small> </option>
							<option value='2' >Dept. Head </option> 
							<option value='0' selected>User</option>
						</select>
					</div>
				</div>
				
			</div>
			<div class="row">
			<?php 
			if($_SESSION['specialCase']=='RAKP') { ?>
				<div class="col-md-6">
					<div class="form-group label-floating1">
						<label class="control-label">Employee Code</label>
						<input readonly type="text" id="ecodeE" class="form-control" required>
					</div>
				</div>
				<?php }else {?>
				 <div class="col-md-6">
					<div class="form-group label-floating1">
						<label class="control-label">Employee Code(optional)</label>
						<input type="text" id="ecodeE" class="form-control">
					</div>
				</div>
				 <?php }?>
				
				<?php 
                         $permis = getAddonPermission($_SESSION['orgid'],'Addon_GeoFence') ;
					?> 
				<div class="col-md-6">
					<div class="form-group label-floating1">
						<label class="control-label">Geo Center(optional)</label>
						<select id="areaAssinE" class="form-control" <?php if($permis==0) echo "disabled" ?> >
						
							<option value="0">-Select-</option>
							<?php
							$data= json_decode(getAllArea($_SESSION['orgid']));
							for($i=0;$i<count($data);$i++)
								{
							echo "<option value='".$data[$i]->id."'>".$data[$i]->Name."</option>";
					            }	
						?>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
			<div class="col-md-6">
						<div class="form-group label-floating">
							<div style="display:inline-flex;align-items:center;">
								<label class="">Profile Photo
								</label>&nbsp;&nbsp;&nbsp;
								<img id="imageE" src="" width="150px" height="150px" class="thumbnail" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<!--<i class="pencil fa fa-pencil" style="color:purple	;" 
								 title="choose a file">
								</i>
								<input type="file" name="profileE" id="profileE"  onchange="changeImgUpload(this)">-->
							<span  style="margin-bottom:50px;margin-right:-30px">
											<i class="fa fa-remove delete2" rel="tooltip" style="color:purple;" data-placement="bottom" title="Remove Image"></i>
								</span>
							<span class="btn1 fa fa-pencil" style="color:purple;margin-left:20px">
							<input type="file" class="form-control" name="profileE" id="profileE"  onchange="changeImgUpload(this)" file-upload accept="image/*">
							</span>
							</div>
						</div>
				</div>
			</div>
			
			<!--<div class="row">
				<div class="col-md-3">
					<div class="form-group label-floating">
						<label class="control-label">Blood Group<span class="red"> *</span></label>
							<select id="bgE" class="form-control ">
								<option value="0">-Select-</option>
								<?php
								$data= json_decode(getAllBloodGroup());
								for($i=0;$i<count($data);$i++)
									echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								?>
							</select>
					</div>
				</div>-->
				
				<!--<div class="col-md-3">
					<div class="form-group label-floating">
						<label class="control-label">Marriatal Status<span class="red"> *</span></label>
							<select id="msE" class="form-control ">
								<option value="0">-Select-</option>
								<?php
								$data= json_decode(getAllOther('MaritalStatus'));
								for($i=0;$i<count($data);$i++)
									echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								?>
							</select>
					</div>
				</div>-->
				<!--<div class="col-md-3">
					<div class="form-group label-floating">
						<label class="control-label">Religion<span class="red"> *</span></label>
						<select id="relE" class="form-control ">
							<option value="0">-Select-</option>
							<?php
							$data= json_decode(getAllReligion());
							for($i=0;$i<count($data);$i++)
								echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
							?>
						</select>
					</div>
				</div>
				
			</div>-->
			<!--<div class="row">
				<div class="col-md-3">
					<div class="form-group label-floating">
						<label class="control-label">Nationality<span class="red"> *</span></label>
							<select id="nationalityE" class="form-control ">
								<option value="0">-Select-</option>
								<?php
								$data= json_decode(getAllNationality());
								for($i=0;$i<count($data);$i++)
									echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								?>
							</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group label-floating">
						<label class="control-label">Gender<span class="red"> *</span></label>
							<select id="genE" class="form-control">
								<option value="0">Female</option>
								<option value="1">Male</option>
								<option value="2">Transgender</option>
							</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Superviser Status<span class="red"> *</span></label>
						<select class="form-control" id="sstatusE" >
							<option value='1' >Active</option>
							<option value='0' selected>Inactive</option>
						</select>
					</div>
				</div>
				<!--<div class="col-md-3">
					<div class="form-group label-floating">
						<label class="control-label">Country<span class="red"> *</span></label>
						<select id="countryE" class="form-control ">
							<option value="0">-Select-</option>
							<?php
							$data= json_decode(getAllCountries());
							for($i=0;$i<count($data);$i++)
								echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
							?>
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group label-floating">
						<label class="control-label">City<span class="red"> *</span></label>
						<select id="cityE" class="form-control ">
							<option value="0">-Select-</option>
							<?php
							$data= json_decode(getCityByID(26));
							for($i=0;$i<count($data);$i++)
								echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
							?>
							
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Status<span class="red"> *</span></label>
						<select class="form-control" id="statusE" >
							<option value='1' selected>Active</option>
							<option value='0'>Inactive</option>
						</select>
					</div>
				</div>
			</div>-->
			<!--<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating1">
						<label class="control-label">Address<span class="red"> *</span></label>
						<textarea class="form-control" id="addrE"></textarea>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating1">
						<label class="control-label">Contact No.</label>
						<textarea class="form-control" id="contE"></textarea>
					</div>
				</div>
			</div>-->
			
			
			<div class="clearfix"></div>
		
		
      </div>
      <div class="modal-footer">
        <button type="button" id="saveE"  class="btn btn-success">Update</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	  </form>
    </div>
  </div>
</div>

<!---modal close edit employee--->
<!------image modal ----->


<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-dialog" >
    <div class="modal-content"> 
      <div class="modal-body">
      	<button type="button" class="close" data-dismiss="modal" style="color:black"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<form id="imgE" method="POST" enctype="multipart/form-data" name="myformE">
		<input type="hidden" id="imgid">
        <img src="" class="imagepreview" style="width:550px!important;height:500px!important;" 
		id="profileimg" >
      </div>
		
	   </form>
    </div>
  </div>
</div>
		<!----------->
<!-----Archive employee start--->
<div id="delEmp" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Archive Employee</h4>
      </div>
      <div class="modal-body">		
		<form>
			<input type="hidden" id="del_id" />
			<div class="row">
				<div class="col-md-12">
					
					<h4>Move "<span id="na"></span>" to the Archive folder? Archived users will still be counted in registered users. To reduce the no. of registered  users, delete the user from the Archived folder also. </h4>
					
				</div>
			</div>
			
			<div class="clearfix"></div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="delete"  class="btn btn-warning" data-dismiss="modal">Archive</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-----delete employee close--->
<!--START shift changes of more than one employee simultaneously-->

<div id="shifts" class="modal fade" role="dialog" >
  <div class="modal-dialog">
    <!-- Modal content-->
   <div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<i class="material-icons">close</i></button>
				<h4 class="modal-title" id="title">Assign Shift</h4>
			  </div>
      <div class="modal-body">
		<form id="shiftC">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Shift<span class="red">*</span></label>
							<select id="shiftEE" class="form-control ">
								<option value="0">-Select-</option>
								<?php
								$data= json_decode(getAllShift($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++)
									echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.	'</option>';
								?>
							</select>
					</div>
				</div>
			</div>
		</form>
			<div class="clearfix"></div>

      </div>
			  <div class="modal-footer">
					<button type="button" id="saveshift" class="btn btn-success">Save</button>
					<button type="button" id="resetshift" data-dismiss="modal" class="btn btn-default">Close</button>
			  </div>
    </div>
  </div>
  </div>
  <!----------------->
  
  <div id="geolocation" class="modal fade" role="dialog" >
  <div class="modal-dialog">
    <!-- Modal content-->
   <div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<i class="material-icons">close</i></button>
				<h4 class="modal-title" id="title">Assign Geo Center</h4>
			  </div>
			  
      <div class="modal-body">
		<form id="geolocationF">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Geo Center<span class="red">*</span></label>
							<select id="geolocationS" class="form-control ">
								<option value="0">-Select-</option>
								<?php
									$data= json_decode(getAllArea($_SESSION['orgid']));
									for($i=0;$i<count($data);$i++) 
									{
										echo "<option value='".$data[$i]->id."'>".$data[$i]->Name."</option>";
									}	
								?>
							</select>
					</div>
				</div>
			</div>
		</form>
			<div class="clearfix"></div>

      </div>
			  <div class="modal-footer">
				<button type="button" id="savegeolocation" class="btn btn-success">Save</button>
				<button type="button" id="resetgeolocation" data-dismiss="modal" class="btn btn-default">Close</button>
			  </div>
    </div>
  </div>
  </div>
  
  
  
  
  
  
  <!------------->
  
  
  
   <div id="designation" class="modal fade" role="dialog" >
  <div class="modal-dialog">
    <!-- Modal content-->
   <div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<i class="material-icons">close</i></button>
				<h4 class="modal-title" id="title">Assign Designation</h4>
			  </div>
			  
      <div class="modal-body">
		<form id="">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Designation<span class="red">*</span></label>
							<select id="desgS" class="form-control ">
								<option value="0">-Select-</option>
								<?php
								$data= json_decode(getAllDesg($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++)
									echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								?>
							</select>
					</div>
				</div>
			</div>
		</form>
			<div class="clearfix"></div>

      </div>
			  <div class="modal-footer">
				<button type="button" id="savedesignation" class="btn btn-success">Save</button>
				<button type="button" id="resetdesignation" data-dismiss="modal" class="btn btn-default">Close</button>
			  </div>
    </div>
  </div>
  </div>
  
  
  <div id="department" class="modal fade" role="dialog" >
  <div class="modal-dialog">
    <!-- Modal content-->
   <div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<i class="material-icons">close</i></button>
				<h4 class="modal-title" id="title">Assign Department</h4>
			  </div>
			  
      <div class="modal-body">
		<form id="">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Department<span class="red">*</span></label>
							<select id="deptS" class="form-control ">
							<option value="0">-Select-</option>
							<?php
							$data= json_decode(getAllDept($_SESSION['orgid']));
							for($i=0;$i<count($data);$i++)
								echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
							?>
						</select>
					</div>
				</div>
			</div>
		</form>
			<div class="clearfix"></div>

      </div>
			  <div class="modal-footer">
				<button type="button" id="savedepartment" class="btn btn-success">Save</button>
				<button type="button" id="resetdepartment" data-dismiss="modal" class="btn btn-default">Close</button>
			  </div>
    </div>
  </div>
  </div>
  
  
  
  
  
  
  
  <!-------Confirm change status--------->
  
  <div id="changestatus" class="modal fade" role="dialog" >
  <div class="modal-dialog">
    <!-- Modal content-->
   <div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<i class="material-icons">close</i></button>
				<h4 class="modal-title" id="title">Change Status</h4>
			  </div>
      <div class="modal-body">
				<h4  id="sname">
				</h4>	
			<div class="clearfix"></div>
      </div>
			  <div class="modal-footer">
				<button type="button" id="savestatus" class="btn btn-success">Yes</button>
				<button type="button" data-dismiss="modal" class="btn btn-default">No</button>
			  </div>
    </div>
  </div>
  </div>

  
  <!-- jalsa qr start-->

  <div id="genQRjal"  class="modal fade "  style="margin-left:40px;" >
  <div class="modal-dialog" style="width: 250px;  align:center;  " >
    <!-- Modal content-->
    <div class="modal-content print" style="background-image:url('<?=URL?>../assets/img/jalfinallogo.png'); background-size:100%;background-repeat:no-repeat;-webkit-print-color-adjust:exact;">
      
        <button type="button" style="background-color: transparent!important;
        border: none;
        float: right;padding-top:2px;" onclick="closemodel()" id="cart_cancel"><i class="material-icons" ></i>
		</button><br/>
        <p class="modal-title" id="title" style="font-size:18px;text-align:center;">
		</p>
        
      
      <div class="modal-body" >		
		<div>
			<div>
				<strong>
					<!-- <div style="width:240px;">
						<img src ="<?=URL?>../assets/img/jalsa.png"  style="margin-top: -37px;
    margin-left: 0px;height:240px ;width:210px">
					</div> -->
				 <center> 
				 
				  <p style="color:#000;margin-top:37%;font-size:10px;">www.alislam.org | www.ahmadiyya.ng</p>
				    
					<!-- <div style="margin-top:80%;">
						<label for="user_name" style="font-weight: 600" > <span class="lnamejal" id="lNamejal" style="font-weight: 700"></span><span class="fnamejal" id="fnamejal"></span></label> 
					</div> -->
					<div style="font-weight:bold;font-size: 18px;"><span class="lnamejal" id="lNamejal"></span>
					<span class="fnamejal" id="fNamejal"></span></div>
					<!-- <div><span class="empecodejal" id="empecodejal"></span></div> -->
					<div><span style="color:#000" class="idjal" id="deptNamejal"></span></div>
					<div> <span style="color:#000" class="idjal" id="desgName23"></span></div>
					
			    	<div><span class="idjal" id="shiftnamejal"></span></div>
			    	<!-- <b><?php echo isset($_SESSION['orgName'])?$_SESSION['orgName']:'';?></b> -->
			    	<!-- <div><span class="id" id="shiftname23"></span></div> -->
				</center>

				</strong>
				
				<center>
					<img width="130px" id="qrCodejal" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=testing data found &choe=UTF-8"/>
				</center>
			
				<!-- <div> pulkit</div> -->
				
			</div>
			<button class="btn btn-warning btn-block nonPrintable" onclick="printDiv('genQRjal')" value="print a div!" data-dismiss="modal">Print</button>
      </div>
	  
      
    </div>
  </div>
</div>
</div>

  <!-- jalsa qr end-->
  
  <!-- qr real one -->

<div id="genQR23"  class="modal fade "  style="margin-left:40px;" >
  <div class="modal-dialog" style="width: 250px; align:center;">
    <!-- Modal content-->
    <div class="modal-content print">
      <div class="modal-header">
        <button type="button" style="background-color: transparent!important;
        border: none;
        float: right;padding-top:2px;" onclick="closemodel()" id="cart_cancel"><i class="material-icons" ></i>
		</button><br/>
        <p class="modal-title" id="title" style="font-size:18px;text-align:center;">
		</p>
        
      </div>
      <div class="modal-body" >		
		<div>
			<div>
				<strong>
				 <center>   
				    <b><?php echo isset($_SESSION['orgName'])?$_SESSION['orgName']:'';?></b>
					<div><span class="empname23" id="empName23"></span></div>
					<div><span class="empecode23" id="empecode23"></span></div>
					<div> <span class="id23" id="desgName23"></span></div>
					<div><span class="id" id="deptName23"></span></div>
			    	<div><span class="id" id="shiftname23"></span>(<span class="id" id="shiftime23"></span>)</div>
			    	<!-- <div><span class="id" id="shiftname23"></span></div> -->
				</center>

				</strong>
				
				<center>
					<img width="150px" id="qrCode321" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=testing data found &choe=UTF-8"/>
				</center>
			
				<!-- <div> pulkit</div> -->
				
			</div>
			<button class="btn btn-warning btn-block nonPrintable" onclick="printDiv('genQR23')" value="print a div!" data-dismiss="modal">Print</button>
      </div>
	  
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>
</div>


  <!-- //qr real one -->
 
  

<!--....................END........-->
<!-----Generate QR code start--->
<div id="genQR121"  class="modal fade "  style="margin-left:420px; background:transparent;" >
  <div class="modal-dialog">

  	<button type="button" style="background-color: transparent!important;
        border: none;
        float: right;padding-top:2px;" onclick="closemodel()" id="cart_cancel"><i class="material-icons" ></i>
		</button><br/>

    <!-- Modal content-->
    <!-- <div class="modal-content print"> -->
     <!--  <div class="modal-header">
        <button type="button" 
        border: none;
        float: right;padding-top:2px;" onclick="closemodel()" id="cart_cancel"><i class="material-icons" ></i>
		</button><br/>
        <p class="modal-title" id="title" style="font-size:18px;text-align:center;">
		</p> -->
		<!-- <div class="modal-content print"> -->
        <!-- <div class="modal-header">
        <button type="button"  onclick="closemodel()" id="cart_cancel">&times;</button>
         <h4 class="modal-title">Modal Header</h4> -->
      <!-- </div>  -->
      <!-- <div class="modal-header">
        <button type="button" class="close nonPrintable" data-dismiss="modal"><i class="material-icons">close</i></button>
        <p class="modal-title" id="title" style="font-size:18px;text-align:center;">
		</p>
        
      </div> -->
      <!-- </div> -->
      <div class="modal-body" >	
      	
		<div class="" >

        <!-- row -->
        <div class="">

            <!-- main card -->
            <div id="dayt_qrCard1">

                <!-- left side card blue -->
                <div id="dayt-leftSide"  >

                    <!-- user circle image -->
                    <div id="dayt-image_circle">
                    	<!-- <span class="profile" id="profile"></span> -->
                        <img id="profile1" width="60px" height="60px" style="border-radius: 50%;
   							 border-width:5px;"src=""  alt="user profile image">
                    </div>

                    <!-- username -->
                    <div id="dayt-user_name">
                        <label for="user_name" style="font-weight:600;"><span class="firstname" id="firstName1"></span> <span class="lastname" id="lastName1" style="font-weight: 700"></span></label>     
                    </div>

                    <!-- user designation -->
                    <div id="dayt-designation">
                        <label for="designation" style="font-weight: 400" ><span class="id" id="desgName"></span></label>     
                    </div>

                    <!-- User ID -->
                    <div id="dayt-empid">
                        <label for="empid" style="font-weight: 400" ><span class="empecode" id="empecode"></span></label>     
                    </div>
                    

                    <!-- user details email, address, phone number-->
                    <div id="dayt-user_details">
                        <div id="dayt-email_id">
                            <!-- <img id="email_icon" src="email.svg" alt=""> -->
                            <label for="email_id"><span class="email" id="email1"></span></label>
                        </div>
                        <div id="dayt-phone_no">
                                <!-- <img id="phone_no_icon" src="phone-call.svg" alt=""> -->
                                <label for="phone_no"><span class="mobile" id="mobile1"></span></label>
                            </div>
                            <div id="dayt-address">
                                    <!-- <img id="address_icon" src="location.svg" alt=""> -->
                                    <label for="address"><span class="address" id="address1"></span></label>
                                </div>
                    </div>
                </div>

                <!-- right side card  -->
                <div id="dayt-rightSide">

                    <!-- companys name  -->
                    <div id="dayt-company_name">
                       <label for="title"><b><?php echo isset($_SESSION['orgName'])?$_SESSION['orgName']:'';?></b></label>     
                    </div>


                    <!-- qr code -->
                    <div id="dayt-qrcode_rectangle_dotted">
                       <div id="dayt-qrcode_rectangle_line">
                        <img id="qrcode111" width="75px" height="75px" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=testing data found &choe=UTF-8" alt="">
                       </div> 
                    </div>

                    <!-- company's email website -->
                    <div id="dayt-company_website">
                            <label for="title"><span id="web123" class="web123"></span></label>     
                         </div>
                </div>
               
            </div>
        </div>
        
       <button id="dayt-image-print-btn" class="btn btn-warning nonPrintable"
            onclick="printDiv('dayt_qrCard1')" value="print a div!"
            data-dismiss="modal" style="">Print</button>
            <!-- <center><button class="btn btn-warning nonPrintable"
            onclick="printDiv('qrCard1')" value="print a div!"
            data-dismiss="modal">Print</button></center> -->
            <!-- <button class="btn btn-warning btn-block nonPrintable" onclick="printDiv('qrcard1')" value="print a div!" data-dismiss="modal">Print</button> -->
    </div>
	  
      <div class="modal-footer" style="border-top:none; !important">
       
      </div>
    </div>
  </div>
<!-- </div> -->
</div>
<!-----Generate QR code close--->

<!-- generate qrcode optional -->

<div id="genQR1"  class="modal fade "  style="margin-left:500px;margin-top:70px; background:transparent;" >
	<div class="modal-dialog">

  	
		<button type="button" style="background-color: transparent!important;
        border: none;
        float: right;padding-top:2px;" onclick="closemodel()" id="cart_cancel"><i class="material-icons" ></i>
		</button><br/>
  <!-- <div class="modal-dialog"> -->
    <!-- <div class="modal-header">
        <button type="button" class="close nonPrintable" data-dismiss="modal"><i class="material-icons"><span style="color:#000">close</span></i></button>
        <p class="modal-title" id="title" style="font-size:18px;text-align:center;">
    </p>
        
      </div> -->
       <div class="modal-body" >
       

    <!-- container -->
    <div class="">

        <!-- row -->
        <div class="" style="">

            <!-- main card -->
            <div id="dytaa_qrCard">
              
                <!-- top side card -->
                <div id="dytaa_topSide">

                      <!-- companys name  -->
                <div id="dytaa_company_name" >
                        <label for="title" ><b><?php echo isset($_SESSION['orgName'])?$_SESSION['orgName']:'';?></b></label>     
                </div>

                    <!-- user circle image -->
                    <div id="dytaa_image_circle">
                             <img id="profile2" width="60px" height="60px" style="border-radius: 50%;
                 border-width:5px;"src=""  alt="user profile image">
                    </div>

                    <!-- username -->
                    <div id="dytaa_user_name">
                            <label for="user_name" style="font-weight: 600" ><span class="firstname2" id="firstName2"></span> <span class="lastname2" id="lastName2" style="font-weight: 700"></span></label>     
                        </div>
    
                        <!-- user designation -->
                        <div id="dytaa_designation">
                            <label for="designation" style="font-weight: 400" > <span class="id1" id="desgName1"  style="font-weight: 700"></span></label>     
                        </div>
    
                        <!-- User ID -->
                        <div id="dytaa_empid">
                            <label for="empid" style="font-weight: 800" ><span class="empecode1" id="empecode1"></span></label>     
                        </div>
    

                         <!-- qr code -->
                         
                   <div id="dytaa_qrcode_rectangle_dotted">
                    <div id="dytaa_qrcode_rectangle_line">
                     <img id="qrcode123" width="75px" height="75px" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=testing data found &choe=UTF-8" alt="">
                    </div> 

                 </div>
            

                 <!-- company's email website -->
                 <div id="company_website">
                         <label for="title"><span id="web1234" class="web1234"></span></label>     
                      </div>
              </div>
                  
            </div>
        </div>
        
          <button id="dytaa_prntbtn" class="btn btn-warning nonPrintable"
            onclick="printDiv('dytaa_qrCard')" value="print a div!"
            data-dismiss="modal">Print</button>
            

    </div>
  </div>
</div>
<!-- </div> -->
</div>

<!-- //generate qrcode optional -->


<!-----Generate QR code start--->
<div id="genqrcode"  class="modal fade"  style="margin-left:40px;" >
  <div class="modal-dialog" style="width: 250px; align:center;">
    <!-- Modal content-->
  <div class="modal-content print">
      <div class="modal-header">
        <button type="button" style="background-color: transparent!important;
        border: none;
        float: right;" onclick="closemodel()" id="cart_cancel"><i class="material-icons">close</i></button>
        <p class="modal-title" id="title" style="font-size:18px;text-align: center;border-bottom: 1px solid #42a545;">
		</p>
        
      </div>
      <div class="modal-body" >		
		<div>
			<div >
				<strong>
				 <center>   <div>
				    <b><?php echo isset($_SESSION['orgName'])?$_SESSION['orgName']:'';?></b>
				   </div>
					<div><span class="id" id="empName"></span></div>
					<div><span class="id" id="desgName"></span></div>
					<div><span class="id" id="deptName"></span></div>
			    	<div><span class="id" id="shiftime"></span></div>
				</center>
				</strong>
				<center>
					<img width="150px" id="qrCode" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=testing data found &choe=UTF-8"/>
				</center>
			</div>
			<button class="btn btn-warning btn-block nonPrintable" onclick="printDiv('genQR')" value="print a div!" data-dismiss="modal" >Print</button>
      </div>
	  
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>
</div>
<!-----Generate QR code close--->





<div id="confirm" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Remove Profile Photo</h4>
      </div>
      <div class="modal-body">		
		<form>
			<input type="hidden" id="del_id" />
			<div class="row">
				<div class="col-md-12">
					<h4>Do you want to remove the Profile picture?</h4>
					
				</div>
			</div>
			
			<div class="clearfix"></div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="delete"  class="btn btn-warning" data-dismiss="modal">Remove</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<!-----Request for reset password--->
<div id="resetpwd"  class="modal fade " role="dialog" style="margin-left:40px;" >
  <div class="modal-dialog" >
    <!-- Modal content-->
    <div class="modal-content print">
      <div class="modal-header">
        <button type="button" class="close nonPrintable" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h6 class="modal-title" id="title" >Reset Password </h6>
      </div>
      <div class="modal-body" >		
		<div>
			<form id='resetpwdform'  >
			<input type='hidden' id="idResetPassword"/>
			Set new Password for <b><span id="nameResetPassword"></span></b>
			<div class="form-group label-floating">
						<label class="control-label">New Password*</label>
						<input class="form-control" type="password" id="resetPassword" />
			</div>
			<div class="form-group label-floating">
						<label class="control-label">Confirm Password*</label>
						<input class="form-control" type="password" id="confirmResetPassword" />
			</div>
			<span id='resetError' style="color:red"></span>
			<div class="col-md-6 col-lg-6 col-sm-12 form-group label-floating">
				
			</div>
			<div class="col-md-3 col-lg-3 col-sm-12 form-group label-floating">
				<input type="button" value="Submit" id="submitResetPassword" class="btn btn-success" />
			</div>
			<div class="col-md-3 col-lg-3 col-sm-12 form-group label-floating">
				<input type="button" data-dismiss="modal" value="cancel" class="btn btn-default" />
			</div>
			</form>
        </div>
	   
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>
</div>
		
<!-----Request for reset password close--->
</body>

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
	   <!--  <script>
	var table=$('#example').DataTable(); 
$('#select_all').on('click',function(){

		$('#example').DataTable().ajax.reload(null, false);
}
// 

</script> -->

	    <!-- dayitava script start -->




	    <!-- dayitava script end -->
	<div id="mySidenav" class="pull-right sidenav" style="background-image:url(<?=URL?>../assets/img/bg7.jpg);background-repeat:no-repeat;">
		<div class="helpHeader" ><span><b>&nbsp;&nbsp;<i style="font-size:24px; color:black;"class="fa fa-question-circle" ></i ></b></span><a style="color:black;" href="javascript:void(0)" class="closebtn text-right" onclick="closeNav()">x</a></div>
						<div id="sidenavData" class="sidenavData">
						</div>
					</div>
	<script>
	
	function openNav() {
						document.getElementById("mySidenav").style.width = "360PX";
						$('#sidenavData').load('<?=URL?>admin/helpNav',{'pageid': 'useri'});	
						}
						function closeNav() {
							document.getElementById("mySidenav").style.width = "0";
						}
						
						
						
			var specialKeys = new Array();
			specialKeys.push(8); //Backspace
			$(function () 
			{
				$(".numeric").bind("keypress", function (e) 
				{
					var keyCode = e.which ? e.which : e.keyCode
					var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
					$(".error").css("display", ret ? "none" : "inline");
					return ret;
				});
				
				$(".numeric").bind("drop", function (e) {
					return false;
				});
			});
			
			
			
			$(".alpha").keydown(function(e)
			{
				if ($.inArray(e.keyCode, [46, 8, 9]) !== -1 ||
				// Allow: Ctrl+A, Command+A
				(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
				(e.keyCode >= 35 && e.keyCode <= 40)) 
				{
				return;
				}// Ensure that it is a number and stop the keypress
				if ((e.keyCode < 65 || e.keyCode > 90) && (e.keyCode !=95 || e.keyCode > 123) && e.keyCode != 32)
				{
				e.preventDefault();
				}
			});
						</script>
						<script>
						
						
	  function printDiv(qrCard1) {
      setTimeout(function(){
     var printContents = document.getElementById(dayt_qrCard1).innerHTML;
	  
      var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;
	  },500);
	  /*  var popupWin = window.open('', '', 'width=300,height=300,align=center');
           popupWin.document.open();
           popupWin.document.write('<html><body onload="window.print()">' + genQR.innerHTML + '</html>');  */
}

  function printDiv(genQR23) {
      setTimeout(function(){
     var printContents = document.getElementById(genQR23).innerHTML;
	  
      var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;
	  },500);
	  /*  var popupWin = window.open('', '', 'width=300,height=300,align=center');
           popupWin.document.open();
           popupWin.document.write('<html><body onload="window.print()">' + genQR.innerHTML + '</html>');  */
}
function printDiv(genQRjal) {
      setTimeout(function(){
     var printContents = document.getElementById(genQRjal).innerHTML;
	  
      var originalContents = document.body.innerHTML;
printContents+="<style>"+
+"@media screen {"
+"	@page {"
+"	    margin-top: 2cm;"
+"	    margin-bottom: 2cm;"
+"	    margin-left: 2cm;"
+"	    margin-right: 2cm;"
+"	}"
+"#genQRjal {"
+"    width: 153pt!important;"
+"    height: 244.64pt!important;"
    
+"  }"
+"}"+


+"</style>";
     document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;
	  },500);
	  /*  var popupWin = window.open('', '', 'width=300,height=300,align=center');
           popupWin.document.open();
           popupWin.document.write('<html><body onload="window.print()">' + genQR.innerHTML + '</html>');  */
}

  function printDiv(dytaa_qrCard) {
      setTimeout(function(){
     var printContents = document.getElementById(dytaa_qrCard).innerHTML;
	  
      var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;
	  },500);
	  /*  var popupWin = window.open('', '', 'width=300,height=300,align=center');
           popupWin.document.open();
           popupWin.document.write('<html><body onload="window.print()">' + genQR.innerHTML + '</html>');  */
}
			
	</script>
<script>
	 // $(document).on("change", "#desg", function ()
			// {
            // var id = $(this).val();
			// $.ajax({url: "<?php echo URL;?>userprofiles/getDesignationType",
						// data: {"id":id}, 
						// success: function(result)
						// {
							
						// },
						// error: function(result)	
						// {
							// alert("error");
							
						// }								
				// });
            // });
			
</script>
<script>

var favorite = [];
function QRcode()
{
	if($('.checkbox:checked').length > 0)
	{
			//alert($('.checkbox:checked').length);
			favorite = [];
			$.each($("input[name='chk']:checked"), function(e)
			{ 
 		
				favorite.push($(this).val());
		
			});
			
			window.open("<?php echo URL; ?>userprofiles/QRcode?favorite="+favorite);
	}
	else
	{
		doNotify('top','center',3,'Select at least 1 employee to generate QR code');
		return false;
	}
	
}
</script>		
	<!-- <script>

		$('input[name="select_all"]').click(function() {
  table.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
     var $tr = this.nodes().to$()
     $tr.find('input[name="batch-select"]').prop('checked', true)
   })     
})
	</script> -->
	
<script>
var favorite;
function updateshift(){
	if($('.checkbox:checked').length > 0)
	{
		
		$('#shiftEE').val('0');
		$('#shifts').modal('show');
		 favorite = [];
			$.each($("input[name='chk']:checked"), function(){            
			favorite.push($(this).val());
			 // $('input[name="chk"]:checked').each(function(i, e) {
				// favorite[i] = $(this).val();
			});
		
	}
	else
	{
		//alert('select atleast 1 record to update');
		doNotify('top','center',3,'Select atleast 1 employee to assign shift');
		return false;
	}
}
$(document).on("click", "#saveshift", function ()
				{
					if($('#shiftEE').val()==0)
					{
						$('#shiftEE').focus();
						doNotify('top','center',4,'Please Select the shift');
						return false;
					}
					
						var shift=$('#shiftEE').val();
						// alert(favorite);
				   // alert(lname);
						//console.log(favorite);
						// favorite=JSON.stringify(favorite);
						// console.log(favorite);
						// favorite=JSON.parse(favorite);
						// console.log(favorite);
						$.ajax({url: "<?php echo URL;?>userprofiles/editshifts",
						data: {"shift":shift,"favorite":favorite},
						dataType: "json",						
						success:function(result)
						{
					//	result=JSON.parse(result);
					//	alert(result);
							if(result == 1)
							{
								$('#shifts').modal('hide');
								doNotify('top','center',2,'Shifts updated Successfully '); 
								table.ajax.reload();
							}
						else
							doNotify('top','center',3,'Error occured, Try later.'); 
						},
							error: function(result)	{
							alert("error");
							doNotify('top','center',4,'Unable to connect API');
													}								
								});
					
			});
		
</script>
<script>
var favorite = [];
function updateDepartment(){
	if($('.checkbox:checked').length > 0)
	{
		$('#deptS').val('0');
		$('#department').modal('show');
		 favorite = [];
			$.each($("input[name='chk']:checked"),function(){            
				favorite.push($(this).val());
			});
		
	}
	else
	{
		//alert('select atleast 1 record to update');
		doNotify('top','center',3,'select atleast 1 employee to assign Department');
		//$('#shifts').modal('hide');
		return false;
	}
}

$(document).on("click", "#savedepartment", function ()
				{
					if($('#deptS').val()==0)
					{
						$('#deptS').focus();
						doNotify('top','center',4,'Please Select the Department');
						return false;
					}
					
						var deptS=$('#deptS').val();
						$.ajax({url: "<?php echo URL;?>userprofiles/editdepartment",
						data: {"deptS":deptS,"favorite":favorite}, 
						success: function(result){
							//alert(result);
							if(result == 1)
							{
								$('#department').modal('hide');
								doNotify('top','center',2,'Department updated Successfully '); 
								table.ajax.reload();
							}
						else
							doNotify('top','center',3,'Error occured, Try later.'); 
								},
						error: function(result)	
						{
							
							doNotify('top','center',4,'Unable to connect API');
						}								
});
					
			});
</script>
<script>

var favorite = [];
function updateDesignation(){
	if($('.checkbox:checked').length > 0)
	{
		$('#desgS').val('0');
		$('#designation').modal('show');
		 favorite = [];
			$.each($("input[name='chk']:checked"),function(){            
				favorite.push($(this).val());
			});
		
	}
	else
	{
		//alert('select atleast 1 record to update');
		doNotify('top','center',3,'select atleast 1 employee to assign Designation');
		//$('#shifts').modal('hide');
		return false;
	}
}

$(document).on("click", "#savedesignation", function ()
				{
					if($('#desgS').val()==0)
					{
						$('#desgS').focus();
						doNotify('top','center',4,'Please Select the Designation');
						return false;
					}
					
						var desgS=$('#desgS').val();
						$.ajax({url: "<?php echo URL;?>userprofiles/editdesignation",
						data: {"desgS":desgS,"favorite":favorite}, 
						success: function(result){
							//alert(result);
							if(result == 1)
							{
								$('#designation').modal('hide');
								doNotify('top','center',2,'Designation updated Successfully '); 
								table.ajax.reload();
							}
						else
							doNotify('top','center',3,'Error occured, Try later.'); 
								},
						error: function(result)	
						{
							doNotify('top','center',4,'Unable to connect API');
						}								
});
					
			});
</script>

<script>
var favorite = [];
function updateGeolocation(){
	if($('.checkbox:checked').length > 0)
	{
		$('#geolocationS').val('0');
		$('#geolocation').modal('show');
		 favorite = [];
			$.each($("input[name='chk']:checked"), function(){            
				favorite.push($(this).val());
			});
		
	}
	else
	{
		//alert('select atleast 1 record to update');
		doNotify('top','center',3,'Select atleast 1 employee to assign geo center');
		//$('#shifts').modal('hide');
		return false;
	}
}
$(document).on("click", "#savegeolocation", function ()
				{
					if($('#geolocationS').val()==0)
					{
						$('#geolocationS').focus();
						doNotify('top','center',4,'Please Select the geolocation');
						return false;
					}
						var geolocation=$('#geolocationS').val();
						
						
						$.ajax({url: "<?php echo URL;?>userprofiles/editgeolocation",
						data: {"geolocation":geolocation,"favorite":favorite}, 
						success: function(result){
							//alert(result);
							if(result == 1)
							{
								$('#geolocation').modal('hide');
								doNotify('top','center',2,'Geolocation updated Successfully '); 
								table.ajax.reload();
							}
						else
							doNotify('top','center',3,'Error occured, Try later.'); 
								},
						error: function(result)	
						{
							
							doNotify('top','center',4,'Unable to connect API');
						}								
});
					
			});
		
</script>














	<script type="text/javascript">
	  
    	//$(document).ready(function() { 
		$(".datepicker" ).datepicker({
				dateFormat: "yy-mm-dd",
				changeMonth: true,
				changeYear: true,
                yearRange: "1900:2050"				
			}); 

			var table=$('#example').DataTable( {
					"bProcessing": true,
					"printable": true,
				   // "bServerSide": true,
				   // "bFilter": false,
				   "dom": "Bfrtip" ,
					"paging": true,
					
				    "stateSave": true,
				     //"deferRender": true,
				     //"bSort": true,
				//"scrollX": true,
				//"contentType": "application/json",

				



				order: [[ 0, 'asc' ]],
					"orderable": false,
					//"scrollX": true,
				 dom: 'Bfrtip',
					buttons: [
					'pageLength','csv','excel','copy','print',
					{
						"extend":'colvis',
						"columns":':not(:last-child)',	}
				],
				 columnDefs: [ { orderable: false, targets: [0]}],
	            "columnDefs": [
                  { "visible": false, "targets": [10,9,3,4] }
                  ],
				  "lengthMenu": [[10,100],[10,100]],
				// "bDestroy": false,
				//"searchable": false,
				"orderable": false,
				
				//"targets"  : 'no-sort'
				"contentType": "application/json",
				"ajax": "<?php echo URL;?>userprofiles/getEmployeesData",
				//"dom": 'T<"clear">lfrtpi<"clear">',	
				"columns": [
					{ "data": "change"},
					{ "data": "photo"},
					{ "data": "name" },
					{ "data": "code" },
					{ "data": "username" },
					{ "data": "department"},
					{ "data": "designation"},
					{ "data": "shift" },
					{ "data": "contact" },
					{ "data": "status" },
					{ "data": "area" },
					//{ "data": "password" },
					{ "data": "pemissions" },
					{ "data": "action"}
				]
			});
			// var dataSelected = dataTable.rows({ selected: true }).data();
			
			
			$('.addemp').click(function(){ 


			    var userlimit = '<?php echo $userlimit ?>';
			    var regusers = '<?php echo $reguser ?>';
			    var status = '<?php echo $status ?>';
			    // alert(parseInt(userlimit) + 5);

			    if(regusers > parseInt(userlimit) + 5 && status == 1){
			    	doNotify('top','center',4,'Please upgrade your plan as userlimit exceeded.');
			    	return false;
			    }
			});
				
			 $('#save').click(function(){
		
		    	var len = $("#cont").val().length;
			    var email = $('#email').val();
				//alert($('#cont').val().length);
				  var check=1;
				  if($('#firstName').val().trim()==''){
					  $('#firstName').focus();
						doNotify('top','center',4,'Please enter the full name.');
						return false;
				  }
				  // if($('#lastName').val().trim()==''){
					 //  $('#lastName').focus();
						// doNotify('top','center',4,'Please enter the last name.');
						// return false;
				  // }
				  <?php //if($_SESSION['specialCase']=='RAKP') { ?>
					  // if($('#ecode').val().trim()==''){
						  // $('#ecode').focus();
							// doNotify('top','center',4,'Please enter the Employee code.');
							// return false;
					  // }
				   <?php //} ?>
				  // if($('#email').val().trim()==''){
					  // <?php //if($_SESSION['specialCase']=='RAKP') { ?>
					  // $('#email').focus();
						// doNotify('top','center',4,'Please enter the Email Id.');
						// return false;
					  // <?php //} ?>
				  // }
				  		 
				if(!$('#email').val().trim()==''){						 
					if (!validate_Email(email)) {
					doNotify('top','center',4,'Please enter valid email Id');
						return false;
						e.preventDefault();
						}
				}
				function validate_Email(email) 
				{
						var expression = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
						if (expression.test(email))
							{
								return true;
							}
						else {
							return false;
							}
					}
				 /*   
			  if($('#email').val()==''){
					  $('#email').focus();
						doNotify('top','center',4,'Please enter the email.');
						return false;
				  }
	
     			
    			if (validate_Email(email)) {
    			alert('Nice!! your Email is valid, now you can continue..');
    				}
    			else {
    				alert('Invalid Email Address');
    				e.preventDefault();
    				}
 
    			  function validate_Email(email) {
    				var expression = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
    				if (expression.test(email)) {
    				return true;
    				}
    				else {
    					return false;
    					}
    					}
	
				  
				if($("#email").val().match(' /^[w-.+]+@[a-zA-Z0-9.-]+.[a-zA-z0-9]{2,4}$/')){
					$('#email').focus();
					doNotify('top','cenetr',4,'please enter the correct email');
					return false;
				}*/
				
				   if($('#cont').val().trim()==''){
					  $('#cont').focus();
						doNotify('top','center',4,'Please enter the contact No.');
						return false;
				  }
				     if(len < 8){
					  $('#cont').focus();
						doNotify('top','center',4,'Please enter the valid Contact No.');
						return false;
				  }	
				  if(isNaN($('#cont').val())){
					 // alert('ok');
					  $('#cont').focus();
						doNotify('top','center',4,'Contact No. can contains digits only');
						return false;
				  }	 
				 
				  // if($('#password').val().trim()==''){
					  // $('#password').focus();
						// doNotify('top','center',4,'Please enter the Password.');
						// return false;
				  // }
				   // if($('#password').val().trim().length<6){
					  // $('#password').focus();
						// doNotify('top','center',4,'Password must contains at least 6 characters');
						// return false;
				  // }
				  
				  // if($('#cpassword').val().trim() == ''){
					  // $('#cpassword').focus();
						// doNotify('top','center',4,'Please enter the confirm password.');
						// return false;
				  // }
				  
				  // if($('#password').val().trim() != $('#cpassword').val().trim()){
					 // $('#password').focus();
                     // $('#cpassword').focus();
                        // doNotify('top','center',4,'Please check confirm password.');
						// return false;					 
					  
				  // }
				  
				  if($('#shift').val()=='0')
				  {
					  $('#shift').focus();
						doNotify('top','center',4,'Please Select the shift.');
						return false;
				  }
				    // if($('#profile').val()=='')
					// {
					  // $('#profile').focus();
						// doNotify('top','center',4,'Please browse the file.');
						// return false;
				    // }
				  if($('#dept').val()=='0')
				  {
					  <?php if($_SESSION['specialCase']!='RAKP') { ?>  
					  $('#dept').focus();
						doNotify('top','center',4,'Please Select the Department.');
						return false;
					<?php } ?>
				  }
				   if($('#desg').val()=='0'){
					   <?php //if($_SESSION['specialCase']!='RAKP') { ?>  
					  $('#desg').focus();
						doNotify('top','center',4,'Please Select the Designation.');
						return false;
						<?php //} ?>
				  }
				  if($('#dob').val()=='')
				  {
					  $('#dob').focus();
						doNotify('top','center',4,'Please enter the date of birth.');
						check=0;
				  }
				  if($('#doj').val()=='')
				  {
					  $('#doj').focus();
						doNotify('top','center',4,'Please enter the date of joining.');
						check=0;
				  }
				  if($('#doc').val()=='')
				  {
					  $('#doc').focus();
						doNotify('top','center',4,'Please enter the DOC.');
						check=0;
				  }
				  
				  if($('#bg').val()=='0')
				  {
					  $('#bg').focus();
						doNotify('top','center',4,'Please select the blood group.');
						check=0;
				  }
				 
				  if($('#ms').val()=='0'){
					  $('#ms').focus();
						doNotify('top','center',4,'Please select the marital status.');
						check=0;
				  }
				  
				  if($('#rel').val()=='0'){
					  $('#rel').focus();
						doNotify('top','center',4,'Please select the religion.');
						check=0;
				  }
				  
				  if($('#nationality').val()=='0'){
					  $('#nationality').focus();
						doNotify('top','center',4,'Please select the nationality.');
						check=0;
				  }
				  
				  // if($('#country').val()=='0'){
					 //  $('#country').focus();
						// doNotify('top','center',4,'Please select the country .');
						// check=0;
				  // }
				  if($('#city').val()=='0'){
					  $('#city').focus();
						doNotify('top','center',4,'Please select the city.');
						check=0;
				  }
				  if($('#addr').val()==''){
					  $('#ms').focus();
						doNotify('top','center',4,'Please enter the corresponding address.');
						check=0;
				  }
				  if(check==0)
					  return false;
				  
				   var fname=$('#firstName').val().trim();
				   // var lname=$('#lastName').val().trim();
				   var area=$("#areaAssign").val().trim();
				   var dob=$('#dob').val();
				   var doj=$('#doj').val();
				   var doc=$('#doc').val();
				   var gen=$('#gen').val();
				   var nat=$('#nationality').val();
				   var ms=$('#ms').val();
				   var rel=$('#rel').val();
				   var bg=$('#bg').val();
				   var dept=$('#dept').val();
				   var desg=$('#desg').val();
				   var shift=$('#shift').val();
				   var sts= 1;//$('#status').val();
				  var sts1=$('#sstatus').val();
				   var country=$('#country').val();
				   var city=$('#city').val();
				   var email=$('#email').val().trim();
				   //var password=$('#password').val().trim();
				   var password=123456;
				   var addr=$('#addr').val();
				   var cont=$('#cont').val().trim();
				 //  alert(cont);
			       var hourlyrate=$('#hourlyrate').val();
			       var ecode='';
			   if($('#ecode').val()!=undefined)
					 ecode=$('#ecode').val().trim();
				 
				 var  formdata = new FormData();
				//formdata.append("file", document.getElementById('profile').files[0]);
				  formdata.append('prof',$('#profile').prop("files")[0]);
				  formdata.append('fname',fname);
				  formdata.append('area',area);
				  // formdata.append('lname',lname);
				  formdata.append('dob',dob);
				  formdata.append('doj',doj);
				  formdata.append('doc',doc);
				  formdata.append('gen',gen);
				  formdata.append('nat',nat);
				  formdata.append('ms',ms);
				  formdata.append('rel',rel);
				  formdata.append('bg',bg);
				  formdata.append('dept',dept);
				  formdata.append('desg',desg);
				  formdata.append('shift',shift);
				  formdata.append('sts',sts);
				  formdata.append('sts1',sts1);
				  formdata.append('country',country);
				  formdata.append('city',city);
				  formdata.append('email',email);
				  formdata.append('password',password);
				  formdata.append('addr',addr);
				  formdata.append('PersonalNo',cont);
				  formdata.append('ecode',ecode);
				  formdata.append('ecode',ecode);
				  formdata.append('hourlyrate',hourlyrate);
				 
					///// pre loader////
					
					
				   $("#loadmodel").modal('show'); 
				   
				   $.ajax({
					    processData: false,
						contentType: false,
					     url: "<?php echo URL;?>userprofiles/insertUsermaster",
						 data: formdata,
						 datatype:"json",
						 type:"post",
						
				  // data: {"fname":fname,"area":area,"lname":lname,"dob":dob,"doj":doj,"doc":doc,"gen":gen,"nat":nat,"ms":ms,"rel":rel,"bg":bg ,"dept":dept ,"desg":desg ,"shift":shift ,"sts":sts ,"sts1":sts1,"country":country ,"city":city ,"email":email ,"password":password ,"addr":addr ,"PersonalNo":cont,"ecode":ecode,"hourlyrate":hourlyrate},
				   
				   // data: {"fname":fname,"lname":lname,"dob":dob,"doj":doj,"doc":doc,"gen":gen,"nat":nat,"ms":ms,"rel":rel,"bg":bg ,"dept":dept ,"desg":desg ,"shift":shift ,"sts":sts ,"country":country ,"city":city ,"email":email ,"password":password ,"addr":addr ,"PersonalNo":cont},
					 
						success: function(result){
							 $("#loadmodel").modal('hide'); 
							if(result == 4){
								$('#addEmp').modal('hide');
								doNotify('top','center',2,'User Added Successfully.');
								
								document.getElementById('empFrom').reset();
								$('#addEmp').modal('hide');
								table.ajax.reload();
							}else if(result == 1){
								doNotify('top','center',4,'Duplicate Email Id found.');
							
							}else if(result == 2){
								doNotify('top','center',4,'Duplicate phone no. found.');
							
							}else if(result == 3){
								doNotify('top','center',4,'Employee code is already exist.');
							}

						 },
						error: function(result){
							$("#loadmodel").modal('hide');
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});
			 var emailV = 0; // this var use for email... if email exist then it can not left blank
			 
			$('#saveE').click(function(){
				var len = $("#contE").val().length;
				  var check=1;
				  if($('#firstNameE').val().trim()==''){
					  $('#firstNameE').focus();
						doNotify('top','center',4,'Please enter the first name.');
						return false;
						check=0;
						
				  }
				  if($('#lastNameE').val().trim()==''){
					  $('#lastNameE').focus();
						doNotify('top','center',4,'Please enter the last name.');
						return false;
						check=0;
				  }	
				// if($('#ecode').val().trim()==''){
						  // $('#ecode').focus();
							// doNotify('top','center',4,'Please enter the Employee code.');
							// return false;
					  // }				  
				  if($('#dobE').val()==''){
					  $('#dobE').focus();
						doNotify('top','center',4,'Please enter the date of birth.');
						return false;
						check=0;
				  }
				  if($('#dojE').val()=='')
				  {
					$('#dojE').focus();
					doNotify('top','center',4,'Please enter the date of joining.');
					return false;
					check=0;
				  }
				  if($('#docE').val()==''){
					  $('#docE').focus();
						doNotify('top','center',4,'Please enter the DOC.');
						return false;
						check=0;
						
				  }
				  if($('#deptE').val()=='0'){
					
					  $('#deptE').focus();
						doNotify('top','center',4,'Please Select the Department.');
						return false;
						check=0;
				  }
				  if($('#desgE').val()=='0'){
					  <?php //if($_SESSION['specialCase']!='RAKP') { ?>
					  $('#desg').focus();
						doNotify('top','center',4,'Please enter the Designation.');
						return false;
						check=0;
						
					  <?php //} ?>
				  }
				  if($('#shiftE').val()=='0')
				  {
					  $('#shiftE').focus();
						doNotify('top','center',4,'Please enter the shift.');
						return false;
						check=0;
						
				  }
				  /*if($('#emailEE1').val()==''){
					  $('#emailE').focus();
						doNotify('top','center',4,'Please enter the email.');
						check=0;
				  }*/
				  if($('#contE').val().trim()=='')
				  {
				  	$('#contE').focus();
				  	doNotify('top','center',4,'Please enter the contact number.');
					return false;
				  	check=0;
				  }
				
				  if(len< 8)
				  {
				  	$('#contE').focus();
				  	doNotify('top','center',4,'please enter the correct Number.');
					return false;
					check=0;
					
					
				  }
				  if($('#passwordE').val().trim()==''){
					  $('#passwordE').focus();
						doNotify('top','center',4,'Please enter the Password.');
						return false;
				  }
				   if($('#passwordE').val().trim().length<6){
					  $('#passwordE').focus();
						doNotify('top','center',4,'Password must contains at least 6 characters');
						return false;
				  }
				  // if($('#emailEE1').val().trim()=='' && emailV==1 ){
				  	// $('#emailEE1').focus();
				  	// doNotify('top','center',4,'Please enter the Email.');
				  	// check=0;
				  // }
				  // if(!$('#email').val()=='')
				  // {						 
					// if (!validate_Email(email)) {
					// doNotify('top','center',4,'Please enter valid email Id');
						// return false;
						// e.preventDefault();
						// }
			   	 // }
				// if(emailV==1)
				 // {
				  	// $('#emailEE1').focus();
				  	// doNotify('top','center',4,'Please enter the Email.');
				  	// check=0;
				 // }
				 
				function validate_Email(email) {
						var expression = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
						if (expression.test(email)) {
						return true;
						}
						else {
							return false;
							 }
					}
				  if($('#bgE').val()=='0'){
					  $('#bgE').focus();
						doNotify('top','center',4,'Please select the blood group.');
						return false;
						check=0;
						
				  }
				  if($('#msE').val()=='0'){
					  $('#msE').focus();
						doNotify('top','center',4,'Please select the marital status.');
						return false;
						check=0;
						
				  }
				  if($('#relE').val()=='0'){
					  $('#relE').focus();
						doNotify('top','center',4,'Please select the religion.');
						return false;
						check=0;
						
				  }
				  if($('#nationalityE').val()=='0'){
					  $('#nationalityE').focus();
						doNotify('top','center',4,'Please select the nationality.');
						return false;
						check=0;
						
				  }
				  // if($('#countryE').val()=='0'){
					 //  $('#countryE').focus();
						// doNotify('top','center',4,'Please select the country .');
						// return false;
						// check=0;
						
				  // }
				  if($('#cityE').val()=='0')
				  {
					  $('#cityE').focus();
						doNotify('top','center',4,'Please select the city.');
						return false;
						check=0;
						
				  }
				  if($('#addrE').val()==''){
					  $('#msE').focus();
						doNotify('top','center',4,'Please enter the corresponding address.');
						return false;
						check=0;
				  }
				
			  if(check==0)
					  return false;
				  
				   var fname=$('#firstNameE').val().trim();
				   //alert($('#firstNameE').val().trim());
				   var lname=$('#lastNameE').val().trim();
				   var areaE=$('#areaAssinE').val();
				   var dob=$('#dobE').val();
				   var doj=$('#dojE').val();
				   var doc=$('#docE').val();
				   var gen=$('#genE').val();
				   var nat=$('#nationalityE').val();
				   var ms=$('#msE').val();
				   var rel=$('#relE').val();
				   var bg=$('#bgE').val();
				   var dept=$('#deptE').val();
				   var desg=$('#desgE').val();
				   var shift=$('#shiftE').val();
				   var sts=$('#statusE').val();
				   var country=$('#countryE').val();
				   var city=$('#cityE').val();
				    var email=$('#emailEE1').val().trim();
				   var password=$('#passwordE').val();
				   var addr=$('#addrE').val();
				   var cont=$('#contE').val();
				   var empid = $("#id").val();
				   var sstatus = $("#sstatusE").val();
				   var hourlyrateE = $("#hourlyrateE").val();
				 // alert($("#hourlyrateE").val());
				   var ecode='';
				   if($('#ecodeE').val()!=undefined)
						ecode=$('#ecodeE').val().trim(); 
				   var areaE = '';
				   if($('#areaAssinE').val()!=undefined)
				   areaE=$('#areaAssinE').val();
			   
			   
			   
			   
			   var  formdata = new FormData();
				  formdata.append('profE',$('#profileE').prop("files")[0]);
				  formdata.append('fname',fname);
				  formdata.append('areaE',areaE);
				  formdata.append('lname',lname);
				  formdata.append('dob',dob);
				  formdata.append('doj',doj);
				  formdata.append('doc',doc);
				  formdata.append('gen',gen);
				  formdata.append('nat',nat);
				  formdata.append('ms',ms);
				  formdata.append('rel',rel);
				  formdata.append('bg',bg);
				  formdata.append('dept',dept);
				  formdata.append('desg',desg);
				  formdata.append('shift',shift);
				  formdata.append('sts',sts);
				  formdata.append('sstatus',sstatus);
				  formdata.append('country',country);
				  formdata.append('city',city);
				  formdata.append('email',email);
				  formdata.append('password',password);
				  formdata.append('addr',addr);
				  formdata.append('PersonalNo',cont);
				  formdata.append('ecode',ecode);
				  formdata.append('hourlyrateE',hourlyrateE);
				  formdata.append('empid',empid);
			// alert(formdata);
				   
				   $.ajax({
					   processData: false,
					contentType: false,
					url: "<?php echo URL;?>userprofiles/editUsermaster",
					data: formdata, //,"email":email
					datatype:"json",
					 type:"post",
                   //data: {"fname":fname,"areaE":areaE,"lname":lname,"dob":dob,"doj":doj,"doc":doc,"gen":gen,"nat":nat,"ms":ms,"rel":rel,"bg":bg ,"dept":dept ,"desg":desg ,"shift":shift ,"sts":sts ,"sstatus":sstatus,"country":country ,"city":city  ,"password":password ,"addr":addr ,"PersonalNo":cont, "empid":empid,"ecode":ecode,"hourlyrateE":hourlyrateE,"email":email}, //,"email":email
				   success: function(result)
				   {
					  if(result==3)
					  {
						   doNotify('top','center',3,'Employee Code Already Exist.'); 
					  }else if(result==4){
						   doNotify('top','center',3,'Duplicate phone no. found'); 
					  }
					  else if(result==2)
					  {
						 doNotify('top','center',3,'Duplicate EmailId found.');  
					  }
					  else if(result == 1){
						$('#addEmpE').modal('hide');
						 doNotify('top','center',2,'Employee Details updated Successfully'); 
						 table.ajax.reload();  
					  }
					  else
						doNotify('top','center',3,'Error occured, Try later.'); 
					}
					});
			});
             
			$(document).on("click", ".edit", function (){
			     	$('.checkbox').each(function()
						 {
							this.checked = false;
						});
						
						
					$('#select_all').each(function()
						 {
							this.checked = false;
						});
						
				 emailV = 0;
				$('#id').val($(this).data('id'));
				$('#firstNameE').val($(this).data('firstname'));
				$('#lastNameE').val($(this).data('lastname'));
				$('#areaAssinE').val($(this).data('area'));
				$('#dobE').val($(this).data('dob'));
				$('#dojE').val($(this).data('doj'));	
				$('#docE').val($(this).data('doc'));	
				$('#nationalityE').val($(this).data('nat'));	
				$('#msE').val($(this).data('ms'));	
				$('#relE').val($(this).data('rel'));	
				$('#bgE').val($(this).data('bg'));	
				$('#desgE').val($(this).data('desg'));	
				$('#shiftE').val($(this).data('shift'));	
				$('#statusE').val($(this).data('status'));	
				$('#countryE').val($(this).data('country'));	
				$('#cityE').val($(this).data('city'));	
				$('#emailEE1').val($(this).data('email'));	
				$('#imageE').val($(this).data('image'));
				$('#hourlyrateE').val($(this).data('hourlypay'));
				// alert ($(this).data('desg'));
				
				
				// var img="<?php echo base_url()."uploads/".$_SESSION['orgid']."/"?>"+$(this).data('image');
				// $("#imageE").attr("src",img);	
				
				if($(this).data('image') != "")
				{
				 var ii="<?php echo IMGURL3."uploads/".$_SESSION['orgid']."/"?>"+$(this).data('image');
					$("#imageE").attr("src",ii);
				}
				else
				{
				if($(this).data('gen')==1)
				{
				var ii="<?php echo IMGURL3."avatars/male.png"?>";
				$("#imageE").attr("src",ii);	
				}
				else if($(this).data('gen')==2)
				{
				var ii="<?php echo IMGURL3."avatars/female.png"?>";
				$("#imageE").attr("src",ii);	
				}
				else
				{
				var ii="<?php echo IMGURL3."avatars/male.png"?>";
				$("#imageE").attr("src",ii);	
				}
				}
				
				
				  if($(this).data('email') != "")
				 {
					 emailV = 1;
				 }
				$('#passwordE').val($(this).data('password'));	
				$('#addrE').val($(this).data('addr'));	
				$('#contE').val($(this).data('cont'));			
				$('#deptE').val($(this).data('dept'));			
				$('#genE').val($(this).data('gen'));
				$('#sstatusE').val($(this).data('sstatus'));
				$('#ecodeE').val($(this).data('ecode'));
				$('#hourlyrateE').val($(this).data('hourlypay'));	
				
			});
			var sid = 0;
			var ssts =  "";
			$(document).on("click", ".status", function (){
				//alert($(this).data('id'));
				   $('.checkbox').each(function()
						 {
							this.checked = false;
						});
							
					$('#select_all').each(function()
						 {
							this.checked = false;
						 });  
				   $("#sname").text("Do you want to change '"+$(this).data('ena')+"' status as Inactive?");
				   $("#changestatus").modal("show");
				   sid = $(this).data('id');
				   ssts = $(this).data('sts');;
				});
			$("#savestatus").click(function(){
				 id=sid;
				 sts=ssts;
				$.ajax({url: "<?php echo URL;?>userprofiles/updateUserStatus",
				
						data: {"id":id,"sts":sts},
						success: function(result){
							if(result == 1){	
								 doNotify('top','center',2,'User status updated successfully'); 
								 table.ajax.reload();  
								 $("#changestatus").modal("hide"); 
											}    
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});
			
			$(document).on("click", ".qr1", function ()
			{
				
					doNotify('top','center',3,' MobileNo. is mandatory to generate QR Code');
			});
			
			
		$(document).ready(function()		
		{
			// setTimeout(function(){
			$('#select_all').click();
			// }, 20000);

				$('#select_all').on('click',function()
				{
					// if(this.checked)
					// {
					// 	$('.checkbox').each(function()
					// 	{
					// 		this.checked = true;
					// 	});
					// }
					// else{
					// 	 $('.checkbox').each(function()
					// 	{
					// 		this.checked = false;
					// 	});
					// }

		$('thead input[name="select_all"]', table.table().container()).on('click', function(e){
      if(this.checked){
         $('#example tbody input[type="checkbox"]:not(:checked)').trigger('click');
        
      } else {
         $('#example tbody input[type="checkbox"]:checked').trigger('click');
         
      }

      // Prevent click event from propagating to parent
      e.stopPropagation();
   });
	});
				// setTimeout(function(){
	$('#select_all').click();
// }, 20000);

			
		});
		
		
	$(document).on("click", ".checkbox", function () 
	{
						if($('.checkbox:checked').length == $('.checkbox').length)	
						{
							$('#select_all').prop('checked',true);
						}
						else
						{
						$('#select_all').prop('checked',false);
						}
			});
			
			$(document).on("click", ".pop",function ()
			{
				$('#imgid').val($(this).data('id'));
			//	$('#profileimg').val($(this).data('enimage'));
			//	alert($(this).data('enimage'));
				$('.imagepreview').attr('src', $(this).find('img').attr('src'));
				
				$('#imagemodal').modal('show');   
			});
		



$('.delete1').on('click', function(e) {
	 $("#profile").val(null);
	 $("#imageAdd").attr("src","<?php IMGURL3."avatars/male.png"?>");
      
   });
$('.delete2').on('click', function(e) 
{ 
$("#imageE").attr("src","<?php IMGURL3."avatars/male.png"?>");
 //$("#profileE").val(null);
var empid = $("#id").val();
var imageE = $("#imageE").val();
	  $.ajax({
					 
					url: "<?php echo URL;?>userprofiles/deleteimg",
					datatype:"json",
					 type:"post",
                  data:{"empid":empid,"imageE":imageE}, 
				   success: function(result)
				   {
					   
					   $('#example').DataTable().ajax.reload();	
				   }
					});
	 
   }); 
   
   
			$(document).on("click", ".delete", function () {
				$('.checkbox').each(function()
					 {
						this.checked = false;
					});
						
					$('#select_all').each(function()
						{
							this.checked = false;
						});
				
				$('#del_id').val($(this).data('id'));
				$('#na').text($(this).data('name'));
			});
			$(document).on("click", "#delete", function (){
						$("#maincontainerdiv").css("opacity","0.08");
						$("#addEmp").css("opacity","0.02");
						$("#loader").show("slow");
					  
				var id=$('#del_id').val(); 
				$.ajax({url: "<?php echo URL;?>userprofiles/deleteUser",
						data: {"sid":id},
						success: function(result){
							
							if(result == 1){
								 $('#delEmp').modal('hide');
								 doNotify('top','center',3,'User archived Successfully.'); 
								 table.ajax.reload();  
					        }
                            if(result == 2)
							{
								doNotify('top','center',4,"This user has admin permission Its can not be delete."); 
							}
                             $("#maincontainerdiv").css("opacity","1");
				             $("#addEmp").css("opacity","1");
				             $("#loader").hide("slow");							
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
							 $("#maincontainerdiv").css("opacity","1");
				             $("#addEmp").css("opacity","1");
				             $("#loader").hide("slow");
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
			//////qr code
			$(document).on("click", ".qr", function () {
				$('#firstName1').text($(this).data('firstname'));
				$('#firstName2').text($(this).data('firstname'));
				$('#empName23').text($(this).data('name'));
				$('#fNamejal').text($(this).data('firstname'));
				// alert($(this).data('firstname'));
				$('#lastName1').text($(this).data('lastname'));
				$('#lastName2').text($(this).data('lastname'));
				$('#lNamejal').text($(this).data('lastname'));
				$('#empecode').text($(this).data('ecode'));
				$('#empecode1').text($(this).data('ecode'));
				$('#empecode23').text($(this).data('ecode'));
				$('#empecodejal').text($(this).data('ecode'));
				// alert($(this).data('ecode'));
				$('#desgName').text($(this).data('desg'));
				$('#desgName1').text($(this).data('desg'));
				$('#desgName23').text($(this).data('desg'));
				$('#desgNamejal').text($(this).data('desg'));
				$('#deptName').text($(this).data('dept'));
				$('#deptName23').text($(this).data('dept'));
				$('#deptNamejal').text($(this).data('dept'));
				
				$('#shiftime23').text($(this).data('shifttime'));
				$('#shiftname23').text($(this).data('shift'));
				$('#shiftnamejal').text($(this).data('shift'));
				$('#mobile1').text($(this).data('cont'));
				$('#email1').text($(this).data('email'));
				$('#address1').text($(this).data('city123'));
				$('#web123').text($(this).data('web123'));
				$('#web1234').text($(this).data('web123'));
				// alert($(this).data('addr'));
				$('#profile1').text($(this).data('image'));
				$('#profile2').text($(this).data('image'));
				
				// alert($(this).data('qrc'));
				// alert($(this).data('image'));
				$('#qrCode111').attr('src',"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl="+$(this).data('una')+""+$(this).data('upa')+"&choe=UTF-8");
				$('#qrCode123').attr('src',"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl="+$(this).data('una')+""+$(this).data('upa')+"&choe=UTF-8");
				$('#qrCode321').attr('src',"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl="+$(this).data('una')+""+$(this).data('upa')+"&choe=UTF-8");
				$('#qrCodejal').attr('src',"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl="+$(this).data('una')+""+$(this).data('upa')+"&choe=UTF-8");
			
			if($(this).data('qrc')==1){
					
					// $('#genQR').show();
					$('#genQR121').modal('show');
					// $('#genQR').modal('show');
					// alert('vanshika');
					// $('#genQR1').modal('hide');
					// $('#genQR1').hide();
				}
				else if($(this).data('qrc')==2) {
					// $('#genQR').modal('hide');
					$('#genQR1').modal('show');

					// $('#genQR1').show();
					// alert('pulkit');
					// $('#genQR').modal('hide');
					// $('#genQR').hide();

				}
				else if($(this).data('qrc')==3){
					$('#genQR23').modal('show');
					// alert('sohan');

				}
				else if($(this).data('qrc')==4){
					$('#genQRjal').modal('show');
					// alert('sohan');

				}
				else{

					doNotify('top','center',4,'Unable to connect API');
				}

				
			var iii="<?php echo IMGURL3."uploads/".$_SESSION['orgid']."/"?>"+$(this).data('image');
			if($(this).data('image') != "")
				{
				 var iii="<?php echo IMGURL3."uploads/".$_SESSION['orgid']."/"?>"+$(this).data('image');
				 // alert(iii);
					$("#profile1").attr("src",iii);
					$("#profile2").attr("src",iii);
				}
				else
				{
				if($(this).data('gen')==1)
				{
				var iii="<?php echo IMGURL3."avatars/male.png"?>";
				$("#profile1").attr("src",iii);	
				$("#profile2").attr("src",iii);	
				}
				else if($(this).data('gen')==2)
				{
				var iii="<?php echo IMGURL3."avatars/female.png"?>";
				$("#profile1").attr("src",iii);	
				$("#profile2").attr("src",iii);	
				}
				
				else
				{
				var iii="<?php echo IMGURL3."avatars/male.png"?>";
				$("#profile1").attr("src",iii);	
				$("#profile2").attr("src",iii);	
				}

				
				}
				

				});
			//////qr code///////
			$(document).on("click", ".resetpwd", function () {
				$('#idResetPassword').val($(this).data('id'));
				$('#nameResetPassword').text($(this).data('name'));
		//		alert($(this).data('name'));
			});
			
			
			$('#resetAdd').click(function(){$('#empFrom')[0].reset();});
			
		$("#submitResetPassword").click(function(){ 
				$('#resetError').text("");
				var pwd=$('#resetPassword');
				var cpwd=$('#confirmResetPassword');
				var id=$('#idResetPassword');
				//alert(id);
				
				if(pwd.val().trim().length<6)
				{
					$('#resetError').text('Password must contains at least 6 characters');
					pwd.val(pwd.val().trim());
					pwd.focus();
					return false;
				}
			if(pwd.val().trim() != cpwd.val().trim())
				{
					$('#resetError').text("Confirm password didn't match");
					cpwd.focus();
					return false;
				}
			$.ajax({
				url: "<?php echo URL;?>userprofiles/resetPassword",
						data: {"pass":pwd.val(),"id":id.val()},
						type: 'post',
						success: function(result)
						{
							result=JSON.parse(result);
							if(result)
							{
								table.ajax.reload();  
								doNotify('top','center',2,'Password is reset successfully');
								document.getElementById('resetpwdform').reset();
								$('#resetpwd').modal('hide');
							}
							else
								doNotify('top','center',3,'You can not use your current password as new password, Try again');
						 },
						error: function(result)
					     {
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			
			});
	</script>
	<script>
		$(document).ready(function(){
			$('#sendInvitation').click(function(){
				var x = $('#inveitedEmails').val();
				var temp = 1;
				if(x==''){
					$('#inveitedEmails').focus();
					return false;
				}
				var emails = x.split(",");
				emails.forEach(function (email) 
				{
				  if(!validateEmail(email.trim()))
					{
					alert(email+' is not a valid mail id, please check');
					temp = 0;
											return false;
					}
				});
				///ajax-start
				if(temp==0)
					return false;
				$.ajax({url: "<?php echo URL;?>admin/sendInvitation",
                   data: {"emails":x},
				   success: function(result){
					   if(result)
							doNotify('top','center',2,'Self registration link sent successfully');	  
						else
							doNotify('top','center',3,' No Invitation(s) sent');
						$("#inveitedEmails").val('');
						$('#inviteEmp').modal('hide');
                  },
					error: function(result){
						doNotify('top','center',4,'Unable to connect API');
				  }
				});
				  ////ajax-close
				
				});
				$('#resetInvitation').click(function(){
					$("#inveitedEmails").val('');
				});
			});
			function validateEmail(email) 
			{
			var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(String(email).toLowerCase());
			}
		</script>
	<script>
	$(document).ready(function(){
	$(".toggle-sidebar").click(function()
	{
	 // if($(".t2").is(':hidden'))
	 //   setTimeout(function(){
		$("#content").toggleClass("col-md-9");
		$("#sidebar").toggleClass("collapsed t2");
		$("#sidebar").load("<?=URL?>admin/helpnav",{'pageid':'useri'});
	 // }, 300);
	});
	
  //   $('.main-panel').click(function(){
		// if(!$(".t2").is(':hidden'))
		// {
		// 	 $("#sidebar").toggleClass("collapsed t2");
		// 	 $("#content").toggleClass("col-md-9");
		// }
	 //  });
 
	}); 
	 function closemodel()
	{
	  $("#genQR121").modal('toggle');   ///// ***********close the dialog *************** 
	  $("#genQR1").modal('toggle');   ///// ***********close the dialog *************** 
	  $("#genQR23").modal('toggle');   ///// ***********close the dialog *************** 
	  $("#genQRjal").modal('toggle');   ///// ***********close the dialog *************** 
    }
	</script>
	
        <script>
	  function changeImgUpload(input)
		{
			if (input.files && input.files[0]) 
			{
			var reader = new FileReader();

			reader.onload = function (e) 
			{
				$('#imageE')
					.attr('src', e.target.result);
			};
		reader.readAsDataURL(input.files[0]);
	      }
		}
	  </script>
	  <script>
	  function changeImgUpload1(input)
		{
			if (input.files && input.files[0]) 
			{
			var reader = new FileReader();
			reader.onload = function (e) 
			{
			$('#imageAdd').attr('src', e.target.result);
			};
		reader.readAsDataURL(input.files[0]);
	      }
		}
	  </script>
	  <script>
	  $(".pencil").click(function () 
	    {
			$("input[type='file']").trigger('click');
		});
		
	  </script>
</html>
			