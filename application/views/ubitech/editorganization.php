<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>ubiAttendance</title>
	<style>
	.red{
		color: #e10500;
	}
	</style>
</head>
<body>  
  	
	<div class="wrapper">
		<?php 
		    if($pageid != "")
			  $data['pageid']=$pageid;
		     else
			  $data['pageid']=3;
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
						<!-- this message for success or error start-->
						<?php if($this->session->flashdata('success') == 'User Updated successfully'){ 
	                     ?><script>
							doNotify('top','center',2,'User Updated successfully.');
						 </script>
							
                        <?php 
						}if($this->session->flashdata('success') == 'Organization updated successfully'){ ?>
						  <script>
							doNotify('top','center',2,'Organization updated successfully.');
						 </script>
						<?php }
						if($this->session->flashdata('error')){ ?>
							<script>
							doNotify('top','center',4,'some error occurs.');
							</script>
						<?php
						}
						if($this->session->flashdata('error1')){
						 ?>
						 <script>
							doNotify('top','center',4,'Email id is already exists.');
						 </script>
						 <?php
						}
						 if($this->session->flashdata('error2')){
						 ?>
						 <script>
							doNotify('top','center',4,'Phone is already exists.');
						 </script>
						 <?php 
						 }
						 if($this->session->flashdata('success1'))
						 {
						  ?>
						  <script>
							doNotify('top','center',2,'Admin added Successfully.');
						 </script>
						  <?php 
						 }
						  if($this->session->flashdata('success') == 'Addons updated successfully')
						  { 
					    ?>
	                     <script>
							doNotify('top','center',2,'Addons updated successfully.');
						 </script>
						 <?php 
						  }
						   if($this->session->flashdata('error') == 'some error occur')
						  { 
					    ?>
	                     <script>
							doNotify('top','center',4,'some error occurs.');
						 </script>
						 <?php 
						  }
						   ?>
					   	<!-- this message for success or error end-->
	                        <div class="card">
	                            <div class="card-header" data-background-color="purple">
	                                <h4 class="title">Organization</h4>
	                                <p class="category">Organization Settings</p>
	                            </div>
	                            <div class="card-content">
									<div id="typography">
										<div class="title">
											<div class="row">
												<div class="col-md-8">
													<h3>Organization</h3>
												</div>
												<div class="col-md-4 text-right">
													
												</div>
											</div>
										</div><br><br>	
  
									  <div class="panel panel-default">
										<div class="panel-heading card-header" style="background-color:teal; color:white;" >Organization Details
										<button style="background-color:teal;position:relative;margin-top:-8px;" class="btn btn-sm btn-primary pull-right" data-toggle="modal" data-target="#addSld" type="button">	
									   <i class="fa fa-edit">&nbsp;Edit</i>
									   </button>
										</div>
										<div class="panel-body" align="center">
										<table id="example1" class="display table" cellspacing="0" width="100%">
										
											<thead>
												<tr>
												    <th>Organization</th>
													<th>Phone</th>
													<th width="50%">Email</th>
													<th>Country</th>
													<th>City</th>
													<th>Lead Owner</th>
													<th>User Limit</th>
													<th>Registered Users</th>
													<th>Dues</th>
												</tr>
											</thead>
											<tbody>
											    <tr>
												    <td><?php echo $data['Name']; ?></td>
												    <td><?php echo $data['PhoneNumber']; ?></td>
												    <td><?php echo $data['Email']; ?></td>
												    <td><?php echo $data['Country']; ?></td>
												    <td><?php echo $data['Address']; ?></td>
													<td><?php echo $data['leadowner_id']; ?></td>
												    <td><?php echo $data['userLimit']; ?></td>
												    <td><?php echo $data['activeUsers']; ?></td>
													<td><?php echo $data['due']; ?></td>
												</tr>
											</tbody>
										</table>
										    <!-- <p><b>Company :</b><?php echo $data['Name']; ?></p>
										    <p><b>Phone :</b><?php echo $data['PhoneNumber']; ?></p>
										    <p><b>Email :</b><?php echo $data['Email']; ?></p>
										    <p><b>Country :</b><?php echo $data['Country']; ?></p>
										    <p><b>Address :</b><?php echo $data['Address']; ?></p> -->
										</div>
									  </div><br>
									  
									    
									  <!-- admin details -->
									  <div class="panel panel-default">
										<div class="panel-heading card-header" style="background-color:teal; color:white;" title="Add Another Admin" >Web Panel Admin Details
										<button style="margin-top:0px;" class="pull-right btn btn-sm btn-primary" data-toggle="modal" data-target="#addSld1" type="button">	
										<i class="fa fa-plus">&nbsp;ADD</i>
										</button></div>
										
										<div class="panel-body" align="center">
											<table id="example" class="display table" cellspacing="0" width="100%">
											<thead>
												<tr>
												    <th>Username</th>
													<th>Name</th>
													<th>Email</th>
													<th>Password</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</thead>
										</table>
										</div>
									  </div>
									  <br>
									  
									  <!-- Plan details -->
									  <div class="panel panel-default">
										<div class="panel-heading card-header" style="background-color:teal; color:white;" title="Add Another Admin" >Plan Details
										</div>
										
										<div class="panel-body" align="center">
											<table id="planexample" class="display table" cellspacing="0" width="100%">
											<thead>
												<tr>
												    <th>Plan</th>
													<th >Start Date</th>
													<th>End Date</th>
													<th width="20%">Transaction ID</th>
													<th>Action</th>
												</tr>
											</thead>
											 <tbody>
											  <td><?php if($t['status'] == 1){ echo 'Premium'; } else echo 'Trial' ?> </td>
											  <td><?php if($t['start_date']!=""){  echo $t['start_date']; }?></td>
											  <td><?php if($t['end_date']!=""){  echo $t['end_date']; }?></td>
											  <td><?php if($data['txnid'] != "") echo $data['txnid']; else echo "-"; ?></td>
											  <td>
											  <i class="material-icons edit" style="cursor: pointer;" data-toggle="modal" data-target="#addtrail" title="View/Update">edit</i>
											  <i class="fa fa-expand" aria-hidden="true" style="cursor: pointer;font-size:20px;" data-toggle="modal" data-target="#editdate" title="Extend Subscription"></i>
											  </td>
												</tbody>
										</table>
										</div>
									  </div>
									  <br>
									  
									   <!-- Addons details -->
									  <div class="panel panel-default">
										<div class="panel-heading card-header" style="background-color:teal; color:white;" title="Add Another Admin" >Addons Details
										</div>
										<!----Addons details --->
										<div class="panel-body" align="center">
											<br />  
					<form id="addonsform"  action="<?php echo URL;?>ubitech/updateaddonspermission/<?php echo $data['id']; ?>"  >						
					<div class="row" >
						<div class="col-sm-1">
							<input type="checkbox"  name="attendanceaddon" id = "attendanceaddon" value="<?php echo $data['attendanceadon'] ?>" <?php if($data['attendanceadon']==1) echo 'checked';  ?> />
						</div>
						<div class="col-sm-3">
							<label class="pull-left">Admin Attendance</label>
						</div>
						<div class="col-sm-1">
							<input type="checkbox"  name="locationtracking" id = "locationtracking" value="<?php echo $data['locationtracking'] ?>" <?php if($data['locationtracking']==1) echo 'checked';  ?> />
						</div>
						<div class="col-sm-3">
							<label class="pull-left"  >Location Tracking</label>
						</div>
						<div class="col-sm-1">
							<input type="checkbox"  name="visitpunch" id = "visitpunch" value="<?php echo $data['visitpunch'] ?>" <?php if($data['visitpunch']==1) echo 'checked';  ?> />
						</div>
						<div class="col-sm-3">
							<label class="pull-left"  >Visit Punch</label>
						</div>
					</div>
					
					
					<div class="row">
						<div class="col-sm-1">
						<input type="checkbox"  name="geofence" id = "geofence" value="<?php echo $data['geofence'] ?>" <?php if($data['geofence']==1) echo 'checked';  ?> />
						</div>
						<div class="col-sm-3">
						<label class="pull-left"  >Geofence</label>
						</div>
						
						<div class="col-sm-1">
						<input type="checkbox"  name="payroll" id = "payroll" value="<?php echo $data['payroll'] ?>" <?php if($data['payroll']==1) echo 'checked';  ?> />
						</div>
						<div class="col-sm-3">
						<label class="pull-left"  >Hourly Pay</label>
						</div>
						
						<div class="col-sm-1">
						<input type="checkbox"  name="timeoff" id = "timeoff" value="<?php echo $data['timeoff'] ?>" <?php if($data['timeoff']==1) echo 'checked';  ?> /></div>
						<div class="col-sm-3">
						<label class="pull-left"  >Timeoff</label>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-1">
						<input type="checkbox"  name="flexi" id = "flexi" value="<?php echo $data['flexi'] ?>" <?php if($data['flexi']==1) echo 'checked';  ?> /></div>
						<div class="col-sm-3">
						<label class="pull-left" >Flexi_Shift</label>
						</div>

						<div class="col-sm-1">
						<input type="checkbox"  name="offline" id = "offline" value="<?php echo $data['offline'] ?>" <?php if($data['offline']==1) echo 'checked';  ?> /></div>
						<div class="col-sm-3">
						<label class="pull-left" >Offline Mode</label>
						</div>

						 <div class="col-sm-1">
						<input type="checkbox"  name="edit123" id = "edit123" value="<?php echo $data['edit123'] ?>" <?php if($data['edit123']==1) echo 'checked';  ?> /></div>
						<div class="col-sm-3">
						<label class="pull-left" >Edit</label>
						</div> 
					</div>
					<div class="row"> 
						<div class="col-sm-1">
						<input type="checkbox"  name="delete123" id = "delete123" value="<?php echo $data['delete123'] ?>" <?php if($data['delete123']==1) echo 'checked';  ?> /></div>
						<div class="col-sm-3">
						<label class="pull-left" >Delete</label>
						</div>

						<div class="col-sm-1">
						<input type="checkbox"  name="autotimeout" id = "autotimeout" value="<?php echo $data['autotimeout'] ?>" <?php if($data['autotimeout']==0) echo 'checked';  ?> /></div>
						<div class="col-sm-3">
						<label class="pull-left" >Auto TimeOut</label>
						</div>


						<div class="col-sm-1">
						<input type="checkbox"  name="image_status" id = "image_status" value="<?php echo $data['image_status'] ?>"<?php if($data['image_status']==1) echo 'checked';  ?>  /></div>
						<div class="col-sm-3">
						<label class="pull-left" >Selfie</label>
						</div>


					</div> 
						<div class="row">
						<div class="col-sm-12">
					     <div class="modal-footer">
				    	<button type="button" id="addonspermission"  class="btn btn-success">Update</button>
				
				     </div>
						</div>
						</form>
		
										</div>
									  </div>
									  <br>
									  
									<!--  <div class="panel panel-default">
										<div class="panel-heading card-header" style="background-color:teal; color:white;" >Update Plan</div>
										<div class="panel-body" align="center" style="overflow-x:auto;" > 
										<table class="table table-bordered">
										  <tr>
											<td width="50%" align='center'>
											
											<input type="radio" name="r1" id="r1" value="0" <?php if($t['status'] == 0){ echo 'checked'; } ?>  /><b>&nbsp;&nbsp;&nbsp;Trial</b>
											
											</td>
											<td align='center' >
											<div id="trial_date" style="display:none;"  >
											<b>Till Date </b><input type="date" name="till_date" id="till_date" value="<?php if($t['end_date']!=""){  echo $t['end_date']; }?>" checked="checked" />
											<input type="hidden" value="<?php if($t['extended']!=""){  echo $t['extended']; }?>" id="extended_data"/>
											</br>
											<button style="background-color:teal;" class="btn btn-sm btn-primary" id="trail" type="button">	
											Submit
											</button>
											</div>
											</td>
										  </tr>
										  <tr>
											<td width="50%" align='center' >
											
											<input type="radio" name="r1" id="r2" value="1"  <?php if($t['status'] == 1){ echo 'checked'; } ?> /><b>&nbsp;&nbsp;&nbsp;&nbsp;Buy</b>
											
											</td>
											<td align="center">
											<div id="buy_date" style="display:none;"  >
											<b>Start Date </b><input type="date" name="start_date" id="start_date" value="<?php if($t['start_date']!=""){  echo $t['start_date']; }?>"  /></br><br>
											<b>End Date </b>&nbsp;<input type="date" name="end_date" id="end_date" value="<?php if($t['end_date']!=""){  echo $t['end_date']; }?>" /></br>
											<button style="background-color:teal;" class="btn btn-sm btn-primary" id="buy" type="button">	
											Submit
											</button>
											</div>
											</td>
										  </tr>
									  </table>-->
									  
									<!--		
									<div class="row">
										<div class="col-md-12">
											<input type="radio" name="r1" id="r1" value="0" <?php if($t['status'] == 0){ echo 'checked'; } ?>  /><b>&nbsp;&nbsp;&nbsp;Trial</b>
												&nbsp;&nbsp;&nbsp;&nbsp;
													<input type="radio" class="with-gap" name="r1" id="r2" value="1"  <?php if($t['status'] == 1){ echo 'checked'; } ?> /><b>&nbsp;&nbsp;&nbsp;&nbsp;Premium </b>
											<br/>
										</div>	
										<br/>
										<br/>
										<br/>
										<div class="col-lg-12">
                              		    					                                                                     <div class="row" >
										<div id="trial_date" style="display:none;"  >
										<div class="col-sm-1" ></div>
										<div class="col-sm-3" style="margin-left:35px;" >
										<span style="float:left"><b>Start Date</b></span><input class="form-control" type="date" name="start_date" id="start_date" value="<?php if($t['start_date']!=""){  echo $t['start_date']; }?>"  />
										</div>
										<div class="col-sm-3">
				                        <span style="float:left"><b>End Date</b></span>
											<input type="date" class="form-control" name="till_date" id="till_date" value="<?php if($t['end_date']!=""){  echo $t['end_date']; }?>" checked="checked" />
											<input type="hidden" value="<?php if($t['extended']!=""){  echo $t['extended']; }?>" id="extended_data"/>
										</div>	
										<div class="col-sm-3">
												<span style="float:left"><b> User limit </b></span>
												<input style=""  id="userLimit" type="number" class="form-control" value="<?php echo $data['userLimit']; ?>" />
											
											</div>
											<div class="col-sm-12 text-center" >
												<button style="background-color:teal;" class="btn btn-sm btn-primary" data-toggle="model" data-target="#addtrail" id="trail" type="button">	
												Update Plan
												</button>
											</div>	
											</div>	
											</div>
										</div>
										</div>
									  <div class="row">
									   <div id="buy_date" style="display:none;">
									       
										    <div class="col-sm-1"></div>
										    <div class="col-sm-3" style="margin-left:35px;" >
											<span style="float:left"><b>Start Date</b></span><input class="form-control" type="date" name="start_date" id="start_date" value="<?php if($t['start_date']!=""){  echo $t['start_date']; }?>"  />
											</div>
											<div class="col-sm-3">
											<span style="float:left"><b>End Date</b></span><input class="form-control" type="date" name="end_date" id="end_date" value="<?php if($t['end_date']!=""){  echo $t['end_date']; }?>" />
											</div>
											<div class="col-md-3">
												<span style="float:left"><b>User Limit </b></span>
												<input style=""  id="userLimit1" type="number" class="form-control" value="<?php echo $data['userLimit']; ?>" >					
											</div>
											<div class="col-md-12 text-center ">
											<button style="background-color:teal;" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addtrail" id="buy" type="button">	
											Update Plan
											</button>
										  </div>
									</div>
									</div>
										<hr/>	
									  
										
											
											<!-- <div class="row">
											 <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12 ">
											 </div>
											 <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 ">
											 <div class="row">
												<div class="col-md-4 col-lg-4 col-sm-6 col-xs-12 ">
												<span style=""><b>Update user limit </b></span>
												</div>
												<div class="col-md-4 col-lg-4 col-sm-6 col-xs-12 ">
												<input style="margin-top: -40px;"  id="userLimit" type="number" class="form-control" value="<?php echo $data['userLimit']; ?>" >
												</div>
												<div class="col-md-4 col-lg-4 col-sm-6 col-xs-12 ">
													<button style="background-color:teal;margin-top:-5px" class="btn btn-sm btn-primary" id="updateUserLimit" type="button">	
													Update
													</button>
												</div>
											  </div>
											 </div>
											 <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12 ">
											 </div>
											 
											</div>
										 
									  
										</div>
									  </div>-->

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
	<!-- Modal open add admin-->
<div id="addSld1" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
	
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Add Admin</h4>
      </div>
      <div class="modal-body">
		<form id="adminform" action="<?php echo URL;?>ubitech/add_admin"  >
			<div class="row">
				<div class="col-md-12">
					
					<div class="form-group label-floating">
						<label class="control-label"> Name <span class="red"> *</span></label>
						<input type="text" id="admin_name" name="admin_name" class="form-control" >
					</div>
					
					<div class="form-group label-floating">
						<label class="control-label">Email<span class="red"> *</span></label>
						<input type="email" id="admin_email" name="admin_email" class="form-control" >
					</div>
					
					<div class="form-group label-floating">
						<label class="control-label">Password<span class="red"> *</span></label>
						<input type="password" id="admin_pass" name="admin_pass" class="form-control" >
					</div>
					<div class="form-group label-floating">
						<input type="hidden"  name="orgid1" class="form-control" value="<?php echo $data['id']; ?>" >
					</div>
			
				</div>
			</div>
			
			<div class="clearfix"></div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="admin_save"  class="btn btn-success" >Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	
    </div>
  </div>
</div>
<!---modal close Admin--->
<!----------------extend enddate----------->
<div id="editdate" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
	
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Extend</h4>
      </div>
      <div class="modal-body">
		<form id="adminform"  >
        <div style="margin-top: 20px;">
                           <input type="radio" name="u" id="renewo" value="1" /><b>&nbsp;&nbsp;&nbsp;Plan End</b>
									&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" class="with-gap" name="u" id="userlimt" value="2" /><b>&nbsp;&nbsp; User Limit</b>&nbsp;&nbsp;&nbsp;&nbsp;
							
								<br/>
								<br/>
		</div>	
		<hr>				
     <div class="col-sm-12" id="extend_renewonly" style="display:none;margin-top: 10px;margin-bottom: 0px;">

		<!-- <h6 id="title" style="margin-top: -10px;margin-bottom: 20px;margin-left:-15px;"><b>Upgrade -  Renew</b></h6> -->
           
           <div class="row">
				<div class="col-md-6">
							<span style="float:left"><b>Extend End Date</b></span>
								<input type="date" class="form-control" name="till_date" id="tilldate" value="<?php if($e['end_date']!=""){  echo $e['end_date']; }?>"  />
								<input type="hidden" value="<?php if($t['extended']!=""){  echo $t['extended']; }?>" id="extended_data"/>
								
				</div>
				<div class="col-md-3">
					<span style="float:left"><b>Extended By</b></span>
					<select id="extendsublead" name="lead1" class="form-control" style="margin-top:-42px; width: 153px;"required>

			        		<!-- <?php print_r($data['leadowner_id']); ?> -->
								<option value="0" >--Please Select--</option>
						      
						    <?php foreach ($l->result() as $row){ ?>

							      <option value="<?php echo $row->id;?>" 
								   <?php if($row->id == $data['lead_id']){ echo 'selected'; } ?> ><?php echo $row->name;?></option>

		                      <!--  <option value="<?php echo $row->id;?>" ><?php echo $row->name;?></option> -->
                            <?php } ?> 
						</select>
					</div>
				</div>
    </div>

	<div class="col-sm-12" id="extend_userlmt" style="display:none;margin-top: 10px;margin-bottom: 10px;">

    <!-- <h6 id="title" style="margin-top: -10px;margin-bottom: 20px;margin-left:-15px;"><b>Upgrade -  User Limit</b></h6> -->
    

    <div class= "col-sm-4" style="">
    <span style="float:left;" class="control-label" id="FNLable"  ><b> Current User Limit </b></span> 

	<input style=""  id="userLimitupgrade0" type="number" min="1" class="form-control " value="<?php echo $data['userLimit']; ?>" oninput="validity.valid||(value='');"readonly />
	</div>
	<div class= "col-sm-4" style="">
    <span style="float:left;" class="control-label" id="FNLable"  ><b> extended user </b></span> 

	<input style=""  id="userLimitupgrade2552" type="number" min="1" class="form-control " value="<?php echo $data['userLimit']; ?>" oninput="validity.valid||(value='');"/>
	</div>
	<div class="col-md-4">

					<span style="float:left"><b>Extended By</b></span>
					<select id="extendsublead" name="lead1" class="form-control" style="margin-top:-42px; width: 153px;"required>

			        		<!-- <?php print_r($data['leadowner_id']); ?> -->
								<option value="0" >--Please Select--</option>
						      
						    <?php foreach ($l->result() as $row){ ?>

							      <option value="<?php echo $row->id;?>" 
								   <?php if($row->id == $data['lead_id']){ echo 'selected'; } ?> ><?php echo $row->name;?></option>

		                      <!--  <option value="<?php echo $row->id;?>" ><?php echo $row->name;?></option> -->
                            <?php } ?> 
						</select>
					</div>

       
    </div>
    
   <!--  <div class="col-sm-12" id="extend_both" style="display:none;margin-top:10px;margin-bottom: 10px;">

	<h6 style="margin-top: -10px;margin-bottom: 20px;"><b>Upgrade - Both - Renew & update User Limit</b></h6>
      
	
	</div>	 --> 	

			
			
			<div class="clearfix"></div>
		</form>
      </div>
      <div class="modal-footer">
      	
      	<button type="button" id="extendsubs1"  class="btn btn-success" style="display: none;" >Save</button>
     
        <button type="button" id="extendsubs"  class="btn btn-success" style="display: none;">Save</button>

        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	
    </div>
  </div>
</div>
<!----------------------extend enddate----------->

<!----------add trail user payment invoice-------------->
<div id="addtrail" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Payment details</h4>
      </div>
      <div class="modal-body">
			
			<input type="hidden" value="<?=$data['Email']?>" id="inv_email">
			<input type="hidden" value="<?=$orgid?>" id="inv_orgid">
			<input type="hidden" value="<?=$data['Name']?>" id="inv_company">
		<!--	<input type="hidden" value="<?=$data['country_id']?>"--> <!--id="inv_country"> -->
		    <h6 id="title" style="margin-top:-10px;margin-left: -15px;" ><b>Plan Details </b></h6>
			  <div class="row" style="margin-top:-5px;" >

			  <?php if($t['status'] == 0){ ?>
			               <div class="col-md-6">
							<input type="radio" name="r1" id="r1" value="0" <?php if($t['status'] == 0){ echo 'checked'; } else echo 'disabled' ?>  /><b>&nbsp;&nbsp;&nbsp;Trial</b>
									&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" class="with-gap" name="r1" id="r2" value="1"  <?php if($t['status'] == 1){ echo 'checked'; } ?> /><b>&nbsp;&nbsp;&nbsp;&nbsp;Premium </b>
								<br/>
								<br/>
							</div>

						<?php } ?>


						 <?php if($t['status'] == 1){ ?>


						 	<div class="col-md-6">
							<input type="radio" name="r1" id="r2" value="0" <?php  echo 'disabled';   ?>  /><b>&nbsp;&nbsp;&nbsp;Premium</b>
									&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" class="with-gap" name="r1" id="r3" value="1"  <?php if($t['status'] == 1){ echo 'checked'; } ?> /><b>&nbsp;&nbsp;Upgrade </b>
								<br/>
								<br/>
							</div>


							<!-- create exisiting plan here -->

							

					<!--<div class="form-group label-floating">
						<label class="control-label" id="FNLable">Previous Dues</label>-->
						
					<!-- <span style="float:left" id="FNLable" ><b>Lead Owner </b><span class="red">*</span></span>
					<select id="triallead11" name="lead" class="form-control"  disabled>
						       <option value="0" ><?php if($data['leadowner_id'] != ''){ ?><?php echo $data['leadowner_id'] ; ?> <?php } else { ?>Please Select <?php } ?></option>
						    <?php foreach ($l->result() as $row){ ?>
		                       <option value="<?php echo $row->id;?>" ><?php echo $row->name;?></option>
                            <?php } ?> 
						</select>

				</div>	 -->



							







						 	<?php } ?>













							<!-- <div class="col-sm-5">
								<label style="color:#000;margin-left:5px;"> <b>Plan details</b> <select> 
									<option> please select </option>
									<option> Renew Only </option>
									<option> User Limit Only</option>
									<option> Both </option>


								</select>
							</label>

							 </div> -->
							<div class="col-sm-6 text-right" >
							 <button style="background-color:teal;margin-top:-5px;" class="btn btn-success trail" id="trail" type="button" hidden >Update Plan</button>
							<button style="background-color:teal;margin-top:-5px;" class="btn btn-success payment" data-toggle="modal" data-target="#addtrail" id="payment" type="button" hidden >Update Plan</button>
							
							</div>
							<br>
			  <div class="col-sm-12" id="trial_date" style="display:none;">			
				          <div class="col-sm-4" >
							 <span style="float:left"><b>Start Date</b></span><input class="form-control" type="date" name="start_date" id="start_date" value="<?php if($t['start_date']!=""){  echo $t['start_date']; }?>"  />
							</div>
							<div class="col-sm-4">
							<span style="float:left"><b>End Date</b></span>
								<input type="date" class="form-control" name="till_date" id="till_date" value="<?php if($t['end_date']!=""){  echo $t['end_date']; }?>" checked="checked" />
								<input type="hidden" value="<?php if($t['extended']!=""){  echo $t['extended']; }?>" id="extended_data"/>
							</div>	
							<div class="col-sm-4">
									<span style="float:left"><b> User limit </b></span>
									<input style=""  id="userLimit" type="number" class="form-control" min = "1" value="<?php echo $data['userLimit']; ?>" />
							</div>
							 <div class="col-md-4" >
					<!--<div class="form-group label-floating">
						<label class="control-label" id="FNLable">Previous Dues</label>-->
						<!-- <span style="float:left" id="FNLable"><b>Lead Owner</b></span>
						<input type="text" id="lead" value="<?php echo $data['leadowner_id']; ?>" class="form-control alpha"> -->
					<!--</div>-->
					<span style="float:left" id="FNLable" ><b>Lead Owner </b><span class="red">*</span></span>
					<select id="triallead" style="width: 153px;" name="lead" class="form-control" required>
						       <option value="0" >--Select Lead Owner--</option>
						      
						    <?php foreach ($l->result() as $row){ ?>


	
								
								   <option value="<?php echo $row->id;?>" 
								   <?php if($row->id == $data['lead_id']){ echo 'selected'; } ?> ><?php echo $row->name;?></option>
                            <?php } ?> 
						</select>

				</div>	
				<div class="col-md-4">
						<hr style="margin-top:0px;" >
			            <h6 id="title" style="margin-top:-18px;" ><b>Remarks</b></h6>
						<input type="text"  id="trial_remark" class="form-control alpha" style="position:relative;margin-top:-25px;" value ="" />
				</div>
							
			      </div>
			 
			 <div class="col-sm-12" id="buy_date" style="display:none;" >	
			 <div class="col-md-4" >
					<!--<div class="form-group label-floating">
						<label class="control-label" id="FNLable">Previous Dues</label>-->
						<!-- <span style="float:left" id="FNLable"><b>Lead Owner</b></span>
						<input type="text" id="lead" value="<?php echo $data['leadowner_id']; ?>" class="form-control alpha"> -->
					<!--</div>-->
					<span style="float:left" id="FNLable" ><b>Lead Owner </b><span class="red">*</span></span>
					<select id="lead" name="lead" class="form-control" style="width: 153px;" required>
						       <option value="0" >--Select Lead Owner--</option>
						      
						    <?php foreach ($l->result() as $row){ ?>


	
								
								   <option value="<?php echo $row->id;?>" 
								   <?php if($row->id == $data['lead_id']){ echo 'selected'; } ?> ><?php echo $row->name;?></option>
                            <?php } ?> 
						</select>

				</div>		
					<div class="col-sm-4">
					<span style="float:left"><b>Start Date</b></span><input class="form-control" type="date" name="start_date" id="start_date" value="<?php if($t['start_date']!=""){  echo $t['start_date']; }?>"  />
					</div>
					
					<div class="col-sm-4">
					<span style="float:left"><b>End Date</b></span><input class="form-control" type="date" name="end_date" id="end_date" value="<?php if($t['end_date']!=""){  echo $t['end_date']; }?>" />
					</div>
					<div class="col-md-4">
						<span style="float:left"><b>User Limit </b></span>
						<input style=""  id="userLimit1" type="number" class="form-control" min = "1" value="<?php echo $data['userLimit']; ?>" >
					</div>
					<div class="col-md-4" id="pdue">
					<!--<div class="form-group label-floating">
						<label class="control-label" id="FNLable">Previous Dues</label>-->
						<span style="float:left" id="FNLable"><b>Previous Dues</b></span>
						<input type="text" id="inv_due" value="<?php echo $data['due']; ?>" class="form-control alpha">
					<!--</div>-->
				</div>

				
			 </div>







			 	<div class="col-sm-12" id="upgrade_date" style="display:none;" >

			 		 <?php if($t['status'] == 1){ ?>
                           <input type="radio" name="u1" id="renew" value="1" /><b>&nbsp;&nbsp;&nbsp;Renew only</b>
									&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" class="with-gap" name="u1" id="userlmt" value="2" /><b>&nbsp;&nbsp; User Limit only</b>&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" class="with-gap" name="u1" id="both" value="3" /><b>&nbsp;&nbsp;Both - Renew & update User Limit </b>
								<br/>
								<br/>
							



						 	<?php } ?>










			 		<!-- <div class="form-group label-floating">
						<label class="control-label" id="FNLable">Upgrade Options<span class="red"> *</span></label>
							<select name="" id="paym" class="form-control" required>
								<option value="select"> Please Select</option>
							<option id="renewuser" value="renew">Upgrade : Renew</option>
							<option id="userlmt" value="userlimit">Upgrade :User Limit</option>
							<option id="both" value="both">Upgrade :Both (Renew/Userlimit)</option>
							
						</select>
					</div> -->


			 	</div>

			 	<a href="#existingplan" style="margin-top:24px;position:absolute;top:17px;left:404px;" class="existingboth" id="exisitingboth"><span style="color:#3b9c3b;"><b><u>See Existing Plan Details</u> </b></span></a>



			 	<div class= col-md-12 id="existingplan" style="margin-top:20px;border-bottom:1px solid #aaaaaa;border-top:1px solid #aaaaaa;margin-bottom:15px; ">

				<!-- <button style="background-color:teal;margin-top:25px;position:absolute;top:-178;left:40px;" class="btn btn-success back" id="back" type="button" >Back</button> -->

								<h6 id="title" style="margin-bottom:20px;margin-left:-15px;"> <b>Existing Plan Details </b> </h6>

								<div class="col-sm-4"style="margin-left:-15px;" >
							 <span style="float:left"><b>Start Date</b></span><input class="form-control" type="date" name="start_date" id="start_date11" value="<?php if($t['start_date']!=""){  echo $t['start_date']; }?>" disabled />
							</div>
							<div class="col-sm-4">
							<span style="float:left"><b>End Date</b></span>
								<input type="date" class="form-control" name="till_date" id="till_date11" value="<?php if($t['end_date']!=""){  echo $t['end_date']; }?>" checked="checked" disabled />
								<input type="hidden" value="<?php if($t['extended']!=""){  echo $t['extended']; }?>" id="extended_data"/ >
							</div>	
							<div class="col-sm-4">
									<span style="float:left"><b> User limit </b></span>
									<input style="" min = "1" id="userLimit11" type="number" class="form-control" value="<?php echo $data['userLimit']; ?>" disabled />
							</div>
							 <div class="col-md-4" >

							 	<span style="float:left" id="FNLable"><b>Lead Owner</b></span>
						<input type="text" id="lead" value="<?php echo $data['leadowner_id']; ?>" class="form-control alpha" disabled>
					</div>

					</div>

					<a href="#existingplan" style="margin-top:24px;position: absolute;top: 17px;left: 404px" class="existinguser" id="exisitinguser"><span style="color:#3b9c3b;"><b><u>See Existing Plan Details</u> </b></span></a>

			 	<div class="col-sm-12" id="upgrade_userlmt" style="display:none;margin-top: 25px;margin-bottom: 25px;">

<h6 id="title" style="margin-top: -10px;margin-bottom: 20px;margin-left:-15px;"><b>Upgrade -  User Limit</b></h6>



<!-- <div classs="col-sm-4"> 
	<span style="float:left" id="FNLable" ><b>Lead Owner </b><span class="red">*</span></span>
					<select id="leadupgusrlmt" name="leadusrlmt" class="form-control" required>
						       <option value="0" ><?php if($data['leadowner_id'] != ''){ ?><?php echo $data['leadowner_id'] ; ?> <?php } else { ?>Please Select <?php } ?></option>
						    <?php foreach ($l->result() as $row){ ?>
		                       <option value="<?php echo $row->id;?>" ><?php echo $row->name;?></option>
                            <?php } ?> 
						</select>



</div> -->

<!-- <div class="col-sm-4">

	<span style="float:left" id="FNLable" ><b>Lead Owner </b><span class="red">*</span></span>
					<select id="leadupgusrlmt" name="leadusrlmt" class="form-control" required>
						       <option value="0" ><?php if($data['leadowner_id'] != ''){ ?><?php echo $data['leadowner_id'] ; ?> <?php } else { ?>Please Select <?php } ?></option>
						    <?php foreach ($l->result() as $row){ ?>
		                       <option value="<?php echo $row->id;?>" ><?php echo $row->name;?></option>
                            <?php } ?> 
						</select>


</div> -->
<!-- <div class= "col-sm-4" style="margin-left:-15px;">  -->
	
	<span style="float:left;margin-left:-15px;color:#aaaaaa;" class="control-label" id="FNLable"  >  User Limit </span>
	<div class= "col-sm-3" style="margin-top:-44px;"> 

	<input style=""  id="userLimitupgrade" type="number" min="1" class="form-control" value="<?php echo $data['userLimit']; ?>" oninput="validity.valid||(value='');" />
								</div>
								<span style="float:left;color:#aaaaaa;" id="FNLable" >Lead Owner <span class="red">*</span></span>
					<div class="col-md-3">
					<select id="upgusrlmtlead" name="lead" class="form-control" style="margin-top:-42px; width: 153px;"required>

								<!-- <?php print_r($data['leadowner_id']); ?> -->
								<option value="0" >--Select Lead Owner--</option>
						      
						    <?php foreach ($l->result() as $row){ ?>


	
								
								   <option value="<?php echo $row->id;?>" 
								   <?php if($row->id == $data['lead_id']){ echo 'selected'; } ?> ><?php echo $row->name;?></option>
								

						    	


		                      <!--  <option value="<?php echo $row->id;?>" ><?php echo $row->name;?></option> -->
                            <?php } ?> 
						</select>
					</div>
					<div class="col-sm-3" id="currentuser">
					<span style="color:red;position:absolute;top:32px;font-size: 12px;left:-419px;">Current User Limit is:  <?php echo $data['userLimit']; ?> </span>
				</div>
					<!-- <div class="col-md-3">
									<span style="float:left"><b> User limit </b></span>
									<input style=""  id="userLimitupgrade" type="number" class="form-control" value="<?php echo $data['userLimit']; ?>" />
							</div> -->
						
								<div class= "col-sm-4"></div>
								<div class= "col-sm-4">
									<!-- <button style="background-color:teal;margin-top:25px;position:absolute;top:-178px;left:249px;" class="btn btn-success existinguser" id="exisitnguser" type="button" hidden >Exisiting Plan Details</button> -->
									<?php {
								if($data['country_id']== 93){
								?> 
									<button style="background-color:teal;margin-top:92px;position:absolute;top:504px;left:185px;" class="btn btn-success upgradeuserlmt" id="upgradeusrlmt" type="button" hidden >Update Plan</button>
								
								<?php } else{ ?>
									<button style="background-color:teal;margin-top:92px;position:absolute;top:428px;left:361px;" class="btn btn-success upgradeuserlmt" id="upgradeusrlmt" type="button" hidden >Update Plan</button>

									<?php } 
							} ?>
								

								</div>



</div>
    
    
    


		<a href="#existingplan" style="margin-top:24px;position: absolute;top: 17px;left: 404px" class="existingrenew" id="exisitingrenew"><span style="color:#3b9c3b;"><b><u>See Existing Plan Details</u> </b></span></a>
	<div class="col-sm-12" id="upgrade_renewonly" style="display:none;margin-top: 25px;margin-bottom: 25px;">

		<h6 id="title" style="margin-top: -10px;margin-bottom: 20px;margin-left:-15px;"><b>Upgrade -  Renew</b></h6>

<!-- <div class= "col-sm-4" > -->
	<!-- <div class="col-sm-4">

	<span style="float:left" id="FNLable" ><b>Lead Owner </b><span class="red">*</span></span>
					<select id="leadupgrenew" name="leadrenew" class="form-control" required>
						       <option value="0" ><?php if($data['leadowner_id'] != ''){ ?><?php echo $data['leadowner_id'] ; ?> <?php } else { ?>Please Select <?php } ?></option>
						    <?php foreach ($l->result() as $row){ ?>
		                       <option value="<?php echo $row->id;?>" ><?php echo $row->name;?></option>
                            <?php } ?> 
						</select>


</div> -->

	
	<span style="float:left;margin-left:-15px;color:#aaaaaa;"class="control-label" > Renew plan for:   <span class="red">*</span> </span>
<!-- </div> -->
<div class= "col-sm-2" style="margin-top:-44px" >
									<input style=""  id="upgrnw" type="number" min="1"  class="form-control" value="" oninput="validity.valid||(value='');" />
								</div>

								<div class= "col-sm-2" style="margin-top:-44px;margin-left:-15px;">
	
						<!-- <label class="control-label"  style="color:#000;margin-top:-10px;"><b>Years/Months</b><span class="red"> *</span></label> -->
							<select name="" id="yrmon" class="form-control" style="margin-top:2px;" required>
								<!-- <option value="select"> Please Select</option> -->
							<option  value="yrs">Years</option>
							<option  value="months">Months</option>
							
						</select>
					</div>
					
					<span style="float:left;color:#aaaaaa;"class="control-label" id="FNLable"  >Lead Owner <span class="red">*</span></span>
					<div class="col-md-3">
					<select id="upgrenewlead" name="lead" class="form-control" style="width: 153px;margin-top:-42px;"required>
						       <option value="0" >--Select Lead Owner--</option>
						      
						    <?php foreach ($l->result() as $row){ ?>


	
								
								   <option value="<?php echo $row->id;?>" 
								   <?php if($row->id == $data['lead_id']){ echo 'selected'; } ?> ><?php echo $row->name;?></option>
                            <?php } ?> 
						</select>
					</div>
							 
						<div class= "col-sm-4"></div>	
						<!-- <div class= "col-sm-4"> -->
							
							<!-- <a href="#existingplan" style="margin-top:24px;position:absolute;top:13px;left:425px;" class="existingboth" id="exisitingboth"><span style="color:#3b9c3b;"><b><u>See Existing Plan Details</u> </b></span></a> -->
						<!-- </div>	 -->

						<div class= "col-sm-4">

							<?php {
								if($data['country_id']== 93){
								?>

									<button style="background-color:teal;margin-top:92px;position:absolute;top:504px;left:184px;" class="btn btn-success upgraderenew" id="upgraderenew" type="button" hidden >Update Plan</button>

									<?php } else{ ?>
										<button style="background-color:teal;margin-top:92px;position:absolute;top:429px;left:184px;" class="btn btn-success upgraderenew" id="upgraderenew" type="button" hidden >Update Plan</button>

										<?php } 
							} ?>



								</div>
								

</div>

<!-- <div class="col-sm-12" id="upgrade_both" style="display:none;">

	<h6 style="margin-top: -10px;margin-bottom: 20px;"><b>Upgrade - Both - Renew & update User Limit</b></h6>

	<div class= "col-sm-4">
	<span style="float:left"><b>Additional users </b> <span class="red">* </span></span>
									<input style=""  id="upgusr1" type="number" class="form-control" value="" />
								</div>
								<div class= "col-sm-4">

									<button style="background-color:teal;margin-top:25px;" class="btn btn-success upgradeuserlmt" id="upgradeusrlmt1" type="button" hidden >Next</button>
								</div>
							</div> -->
							<a href="#existingplan" style="margin-top:24px;position:absolute;top:17px;left:404px;" class="existingrenuse" id="exisitingrenuse"><span style="color:#3b9c3b;"><b><u>See Existing Plan Details</u> </b></span></a>
								<div class="col-sm-12" id="next" style="display:none;margin-top: 25px;margin-bottom: 25px;">
									<h6 id="title" style="margin-top: -10px;margin-bottom: 20px;margin-left:-15px;"><b>Upgrade - Both - Renew & update User Limit</b></h6>

									
								<!-- <div class= "col-sm-10"> -->
	
	<!-- <span style="float:left"><b> Renew plan for:  </b> <span class="red">* </span></span>
									<input style=""  id="upgrnw1" type="number" class="form-control" value="" />
								</div>

								<div class= "col-sm-6">
	
						<label class="control-label"  style="color:#000;margin-top:-10px;"><b>Years/Months</b><span class="red"> *</span></label>
							<select name="" id="yrmon1" class="form-control" style="margin-top:-20px;" required>
								<option value="select"> Please Select</option>
							<option  value="yrs1"> Years</option>
							<option  value="months1">Months</option>
							
						</select>
					</div> -->


	<span style="float:left;margin-left:-12px;color:#aaaaaa;" class="control-label">User Limit  <span class="red">* </span></span>
	<div class= "col-sm-2" style="margin-top:-44px">
									<input style="" min="1" id="userLimitupgrade1" type="number" class="form-control" value="<?php echo $data['userLimit']; ?>" oninput="validity.valid||(value='');" />
								</div>
								
								




						<span style="float:left;color:#aaaaaa;margin-left: 41px;"class="control-label"> Renew plan for:   <span class="red">*</span> </span>
<!-- </div> -->
								<div class= "col-sm-2" style="margin-top:-44px;" >
									<input style=""  id="upgrnw1" type="number" min="1" class="form-control" value="" oninput="validity.valid||(value='');"/>
								</div>

								<div class= "col-sm-2" style="margin-top:-44px">
	
						<!-- <label class="control-label"  style="color:#000;margin-top:-10px;"><b>Years/Months</b><span class="red"> *</span></label> -->
							<select name="" id="yrmon1" class="form-control" style="margin-top:2px;" required>
								<!-- <option value="select"> Please Select</option> -->
							<option  value="yrs">Years</option>
							<option  value="months">Months</option>
							
						</select>
					</div>
						<span style="float:left;margin-left:-7px;margin-top:2px;color:#aaaaaa;" id="FNLable" >Lead Owner<span class="red">*</span></span>
					<div class="col-md-3">

					<select id="upgbothlead" name="lead" class="form-control" style="width: 153px;margin-top:-32px;"required>
						       <<option value="0" >--Select Lead Owner--</option>
						      
						    <?php foreach ($l->result() as $row){ ?>


	
								
								   <option value="<?php echo $row->id;?>" 
								   <?php if($row->id == $data['lead_id']){ echo 'selected'; } ?> ><?php echo $row->name;?></option>
                            <?php } ?> 
						</select>
					</div>

							 
						<div class="col-sm-4" id="currentuser1">
					<span style="color:red;position:absolute;top:32px;font-size: 12px;left:-152px;">Current User Limit is:  <?php echo $data['userLimit']; ?> </span>
				</div>	
						<div class= "col-sm-4"></div>	
						<div class= "col-sm-4">
							

							<!-- <button style="background-color:teal;margin-top:25px;position:absolute;top:-178px;left:40px;" class="btn btn-success existingboth" id="exisitngboth" type="button" hidden >Exisiting Plan Details</button> -->
							<?php {
								if($data['country_id']== 93){
								?>
									<button style="background-color:teal;margin-top:92px;position:absolute;left:160px;top:547px" class="btn btn-success upgradeboth" id="upgradeboth" type="button" hidden >Update Plan</button>
								<?php } else{ ?>

									<button style="background-color:teal;margin-top:92px;position:absolute;left:10px;top:472px" class="btn btn-success upgradeboth" id="upgradeboth" type="button" hidden >Update Plan</button>

							<?php } 
							} ?> 
							</div>
							<!-- </div> -->





	







			</div>

			


			<form id="empFrom">
			<hr style="margin-top:0px;" >
			<h6 id="title" style="margin-top:-10px;" ><b> Bill To </b></h6>
			<div class="row" style="margin-top:-10px;" >
				<div class="col-md-6">
					<div class="form-group label-floating">
						
						<label class="control-label" id="shiftNameLable">Organization Name <span class="red"> *</span></label>
						<input type="text" value="<?php echo $data['Name']; ?>" id="inv_contact" class="form-control numeric" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label" id="FNLable">Contact Name <span class="red"> *</span></label>
						<input type="text" id="inv_name" class="form-control alpha" value="<?php echo $data['contectperson']; ?>" required>
					</div>
				</div>
				
			</div>
			<div class="row" style="margin-top:-10px;" >
		
				<div class="col-md-6" style="margin-top:-10px;" >
					<div class="form-group label-floating">
						<label class="control-label" id="">Country<span class="red"> *</span></label>
							<?php
								$country=json_decode(getAllCountries());
							?>
							<select id="inv_country" class="form-control">
								<option value='0'>-Country-</option>
							<?php 
								foreach($country as $cont){
							?>
								<option <?php echo $cont->id==$data['country_id']?'selected':'';?>><?php echo $cont->name; ?></option>
							<?php
								}
							?>
							</select>
					</div>
				</div>
				<div class="col-md-6" id="state1" style="margin-top:-10px;"  >
					<div class="form-group label-floating"  >
						<label class="control-label" id="FNLable">State<span class="red"> *</span></label>
							<?php
								$states=json_decode(getAllStates());
							?>
							<select id="inv_state" class="form-control">
								<option value='0'>-State-</option>
							<?php 
								foreach($states as $state){
							?>
								<option value="<?php echo $state->code; ?>"><?php echo $state->name; ?></option>
							<?php
								}
							?>
							</select>
					</div>
				</div>
				<div class="col-md-6" style="margin-top:-10px;" >
					<div class="form-group label-floating">
						<label class="control-label" id="">City<span class="red"> *</span></label>
						<input type="text" id="inv_city" class="form-control alpha" required value="<?= $data['city']; ?>" >
					</div>
				</div>
				<div class="col-md-6" id="gst1" style="margin-top:-10px;"  >
					<div class="form-group label-floating" >
						<label class="control-label" id="FNLable">GST Number<span class="red"> *</span></label>
						<input type="text" id="inv_gst" class="form-control alpha" value="<?php echo $data['gst']; ?>" required>
					</div>
				</div>
				
			</div>
			<div class="row" style="margin-top:-10px;" >
				<div class="col-md-6">
					<div class="form-group label-floating">
						
						<label class="control-label" id="shiftNameLable">Phone <span class="red"> *</span></label>
						<input type="text" value="<?php echo $data['PhoneNumber']; ?>" id="inv_contact" class="form-control numeric" required>
					</div>
				</div>
			</div>
			<hr style="margin-top:0px;" >
			<h6 id="title" style="margin-top:-10px;" ><b>Transaction Details </b></h6>
			<div class="row" style="margin-top:-10px;" >
			    
				<!--<div class="col-md-4">
					<div class="form-group label-floating">
						<label class="control-label" id="FNLable">Transaction Mode</label>
						<!--<input type="text" id="inv_due" value="<?php echo $data['due']; ?>"class="form-control alpha">-->
					<!--</div>
				</div>-->
				<div class="col-md-4">
					<div class="form-group label-floating">
						<label class="control-label" id="FNLable">Payment Method<span class="red"> *</span></label>
							<select name="" id="paym" class="form-control" value="<?php echo $data['paymentmethod']; ?>"required>
								<!-- <option value="select"> Please Select</option> -->
							<option  value="kotak India"> kotak India</option>
							<option  value="UAE">UAE</option>
							
						</select>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="form-group label-floating">
					<label class="control-label" >Transaction ID<span class="red"> *</span></label>
						<input type="text" id="inv_txn" class="form-control alpha" value="<?php echo $data['txnid']; ?>" required>
					</div>
				</div>
				
				<div class="col-md-4">
				 <div class="form-group label-floating">
						<label class="control-label" id="FNLable">Currency<span class="red"> *</span></label>
							<select name="" id="inv_currency" class="form-control" value="<?php echo $data['currency']; ?>"required>
							<option <?php if($data['currency']=='INR') echo "selected" ?> value="INR">INR</option>
							<option <?php if($data['currency']=='USD') echo "selected" ?> value="USD">USD</option>
							
						</select>
					</div>	
				</div>
				
				</div>
			<div class="row" >
				<div class="col-md-4" style="margin-top:-10px;" >
					<div class="form-group label-floating">
						<label class="control-label" id="shiftNameLable">Amount(with tax)</label>
						<input type="number" id="inv_amount" class="form-control alpha" value="<?= $data['paymentamount'] ?>" required >
					</div>
				</div>
			
			    <div class="col-md-4" style="margin-top:-10px;" >
					<div class="form-group label-floating">
						<label class="control-label" id="shiftNameLable">Tax</label>
						<input type="text" value="<?= $data['tax'] ?>" id="inv_tax" class="form-control alpha" >
					</div>
				</div>
				<div class="col-md-4" style="margin-top:-10px;" >
					<div class="form-group label-floating">
						<label class="control-label" id="shiftNameLable">Discount</label>
						<input type="text" id="inv_dis" value="<?= $data['discount'] ?>" class="form-control alpha" >
					</div>
				</div>
			</div>
			<div class="row"  id="remarks" >
				<div class="col-md-4">
					<div class="form-group label-floating">
						<label class="control-label" id="FNLable">Dues</label>
						<input type="text" id="inv_due1" value="<?php echo $data['due']; ?>"class="form-control alpha">
					</div>
				</div>
				<div class="col-md-4">
						
						<label class="control-label"  id="title">Remarks</label>
						<input type="text"  id="inv_remark" class="form-control alpha" style="position:relative;margin-top:-30px;" value ="" />
				</div>
			</div>
		</form>
		<div class="modal-footer">
		<button style="background-color:teal;" class="btn btn-success trail" id="trail" type="button" hidden >Update Plan</button>
		<button style="background-color:teal;display;none" class="btn btn-success payment"  data-target="#addtrail" id="payment" type="button" hidden >Update Plan</button>
        <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
      </div>
</div>
</div>
</div>
</div>
</div>

<!------Edit slider modal start------------>
<div id="addSldE" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
	
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Edit Users</h4>
      </div>
      <div class="modal-body">
		<form id="deptFromE" method="post" enctype="multipart/form-data" action="<?php echo URL;?>ubitech/editUserData/<?php echo $data['id']; ?>" >
		<input type="text" class="hidden" id="edit_id" name="edit_id" />
			<div class="row">
				<div class="col-md-12">
					<div class=" label-floating1">
						<label class="control-label">Name <span class="red"> *</span></label>
						<input type="text" id="nameE" name="nameE" class="form-control" >
					</div>
					<div class=" label-floating1">
						<label class="control-label">Username</label>
						<input type="text" id="usernameE" name="usernameE" class="form-control" >
					</div>
					<div class=" label-floating1">
						<label class="control-label">Email</label>
						<input type="text" id="emailE" name="emailE" class="form-control" >
					</div>
					
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-4">
					<div class="form-group label-floating1">
						<label class="control-label">Status</label>
						<select class="form-control" id="statusE" name="statusE">
							<option value='1'>Active</option>
							<option value='0'>Inactive</option>
						</select>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="saveE"  class="btn btn-success" >Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	
    </div>
  </div>
</div>
<!------Edit slider modal close------------>
<!-- Modal open edit organization-->
<div id="addSld" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Edit Organization</h4>
      </div>
      <div class="modal-body">
		<form id="deptFrom"  action="<?php echo URL;?>ubitech/updateOrganizationData/<?php echo $data['id']; ?>"  >

	<div class="row">
				<div class="col-md-12">
					<div class="form-group label-floating">
						<label class="control-label">Organization Name <span class="red"> *</span></label>
						<input type="text" id="org_name" name="org_name" value="<?php echo $data['Name']; ?>" class="form-control" >
					</div>
				</div>
					
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Email<span class="red"> *</span></label>
						<input type="email" id="email" name="email" class="form-control" value="<?php echo $data['Email']; ?>" >
					</div>
				</div>
				
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Phone</label>
						<input type="number" id="phone" name="phone" class="form-control" value="<?php echo $data['PhoneNumber']; ?>" >
					</div>
				</div>
					<div class="col-md-6">
						<div class="form-group label-floating">
							<select id="country" name="country" class="form-control" >
								   <option value="0" >Country</option>
								<?php foreach ($h->result() as $row){ ?>
								   <option value="<?php echo $row->Id;?>" <?php if($row->Id == $data['country_id']){ echo 'selected'; } ?> ><?php echo $row->Name;?></option>
								<?php } ?> 
							</select>
						</div>
					</div>
					<div class="col-md-6">
					<div class="form-group label-floating">
					<label class="control-label">Organization Type</label>
						<select id="orgtype" name="orgtype" class="form-control" >
						       <option value="0" <?php if($data['orgtype']=='0'){ echo 'selected'; } ?>>Standard</option>
						       <option value="1" <?php if($data['orgtype']=='1'){ echo 'selected'; } ?>>Customized</option>
						</select>
					</div>
				</div>
				
				<div class="col-md-6">
						<div class="form-group label-floating">
						<select id="lead" name="lead" class="form-control" style="width: 153px;">
						<option value="0" >--Select Lead Owner--</option>
								<?php foreach ($l->result() as $row){ ?>
								   <option value="<?php echo $row->id;?>" 
								   <?php if($row->id == $data['lead_id']){ echo 'selected'; } ?> ><?php echo $row->name;?></option>
								<?php } ?> 
							</select>
					</div>
				</div>	
			<div class="col-md-6">
					<div class="form-group label-floating">
					<label class="control-label">Rating</label>
						<select id="rating1" name="rating1" class="form-control" >
						       <!--<option value="0" <?php if($data['rating']=='0'){ echo 'selected'; } ?>>Junk</option>-->
						       <option value="0" <?php if($data['rating']=='0'){ echo 'selected'; } ?>>
							   1 Star</option>
						       <option value="1" <?php if($data['rating']=='1'){ echo 'selected'; } ?>>
							   2 Star</option>
						       <option value="2" <?php if($data['rating']=='2'){ echo 'selected'; } ?>>
							   3 Star</option>
						       <option value="3" <?php if($data['rating']=='3'){ echo 'selected'; } ?>>
							   4 Star</option>
							   <option value="4" <?php if($data['rating']=='4'){ echo 'selected'; } ?>>
							   5 Star</option>
						</select>
					</div>
				</div>
				
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Address</label>
						<textarea id="Address" name="Address" class="form-control"><?php echo $data['Address']; ?></textarea>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group" style="margin-top:11px;"> 
						<label class="control-label">organization Remark</label>
						<input type="text" id="remark1" name="remark1" class="form-control" value="<?php echo $data['remarks']; ?>">
					</div>
				</div>
				
				
					
			</div>
			
			<div class="clearfix"></div>
		</form>
		
		
		
      </div>
      <div class="modal-footer">
        <button type="button" id="update_organization"  class="btn btn-success">Save</button>
        <button type="reset" class="btn btn-default"    data-dismiss="modal" >Close</button>
      </div>
	
    </div>
  </div>
</div>
<!---modal close--->

</body>

	
	<script type="text/javascript">
	     $('#planexample').DataTable({
			 
		 });
	var table;
		$(function(){
			 table=$('#example').DataTable({
						"scrollX": true,
						"contentType": "application/json",
						"ajax": "<?php echo URL;?>ubitech/getUserData/<?php echo $data['id']; ?>",
						"columns": [
							{ "data": "orgName" },
							{ "data": "name" },
							{ "data": "email"},
							{ "data": "password"},
							{ "data": "status" },
							{ "data": "action"}
						]
					});	
			$(document).on("click", ".edit", function () { 
				$('#edit_id').val($(this).data('id'));
				$('#nameE').val($(this).data('name'));
				$('#usernameE').val($(this).data('username'));
				$('#emailE').val($(this).data('email'));
				$('#statusE').val($(this).data('status'));
			});
		});
		
		$(document).ready(function(){
		$("#admin_save").click(function()
		{
			var admin_name =  $("#admin_name").val();
            var admin_email =  $("#admin_email").val();
            var admin_pass =  $("#admin_pass").val();
 
			if(admin_name == ""){
				doNotify('top','center',4,'Please enter name.');
				return false;
			}
			if(admin_email == "")
			{
				doNotify('top','center',4,'Please enter email.');
				return false;
			}
			if(admin_pass == ""){
				doNotify('top','center',4,'Please enter password.');
				return false;
			}
			$("#adminform").submit();
		  });
    	});
		
		$('#saveE').click(function(){
			var id       = $('#edit_id').val();
			var name     = $('#nameE').val();
			var username = $('#usernameE').val();
			var email    = $('#emailE').val();
			var status   = $('#statusE').val();			
			$("#deptFromE").submit();
		});
		
		$('#addonspermission').click(function(){
			//alert();addSld
			$("#addonsform").submit();
		});
		
		$('#update_organization').click(function(){
			//alert();addSld
			$("#deptFrom").submit();
		});
		
        $('#adduser1').click(function(){
			if($('#user_name').val() == ''){
				doNotify('top','center',4,'Please enter Name.');
			    return false;
			}
			if($('#user_username').val() == ''){
				doNotify('top','center',4,'Please enter Username.');
			    return false;
			}
			if($('#user_email').val() == ''){
				doNotify('top','center',4,'Please enter Email.');
			    return false;
			}
			$("#userFrom").submit();
		})
			<!-- for alert message-->
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
            $("#success-alert").slideUp(500);
            });
			<!-- -->
			
			table=$('#example1').DataTable( {
						"scrollX": true
					});
	</script>
	<script>

		
		var status = 	 <?php echo $t['status'] ?>;
		if(status == 0){
			 $('#exisitingboth').hide();
		  $('#exisitingrenew').hide();
		   $('.existinguser').hide();
		   $('.existingrenuse').hide();
		   $('#existingplan').hide();

		}
	  $('#r1').click(function(){
		  $('#buy_date').hide();
		  $('#upgrade_date').hide();
		  $('#trial_date').show();
		  $('#lown').show();
		  $('.trail').show();
		  $('.payment').hide();
		  $('#empFrom').hide();
		   $('#upgrade_userlmt').hide();
		  $('#upgrade_renewonly').hide();
		  // $('#upgrade_both').hide();
		  $('#next').hide();
		  ('#existingplan').hide();
		 $('#exisitingboth').hide();
		  $('#exisitingrenew').hide();
		   $('.existinguser').hide();
		   $('.existingrenuse').hide();
	  })
	  $('#r2').click(function(){
		  
		  $('#trial_date').hide();
	      $('#buy_date').show();
	      $('#upgrade_date').hide();
	      // $('#upgrade_renewonly').hide();
	        $('#upgrade_userlmt').hide();
		  $('#upgrade_renewonly').hide();
		  // $('#upgrade_both').hide();
		  $('#next').hide();
	      $('#pdue').hide();
	      $('.payment').show();
	      $('#empFrom').show();
		  $('.trail').hide();
		  $('#existingplan').hide();
		  $('#exisitingboth').hide();
		  $('#exisitingrenew').hide();
		   $('.existinguser').hide();
		   $('.existingrenuse').hide();
	  })
	  $('#r3').click(function(){
		  
		  $('#trial_date').hide();
		  
	      $('#buy_date').hide();
	      $('#upgrade_date').show();
	      $('#pdue').hide();
	      $('.payment').hide();
	      $('#empFrom').hide();
		  $('.trail').hide();
		  $('.payment').hide();
		   $('#upgrade_userlmt').hide();
		  $('#upgrade_renewonly').hide();
		  // $('#upgrade_both').hide();
		  $('#next').hide();
		  $('#existingplan').hide();
		  $('#exisitingboth').show();
		  $('#exisitingrenew').hide();
		   $('.existinguser').hide();
		   $('.existingrenuse').hide();
	  })
	  $('#userlmt').click(function(){
		  
		  $('#trial_date').hide();
	      $('#buy_date').hide();
	      $('#upgrade_date').show();
	      $('#pdue').hide();
	      $('.payment').show();
	      $('#empFrom').show();
	      $('#currentuser').hide();
		  $('.trail').hide();
		  $('#trail').hide();
		  $('.payment').hide();
		  $('#upgrade_userlmt').show();
		  $('#upgrade_renewonly').hide();
		  $('#existingplan').hide();
		  $('#exisitingboth').hide();
		   $('.existinguser').show();
		   $('.existingrenew').hide();
		   $('.existingrenuse').hide();
		 
		  
		  // $('#upgrade_both').hide();
		  $('#next').hide();
		  // $('.close').hide();


	  });
	   $('#userlimt').click(function(){
         $('#upgrade_date').show();
          $('#extend_userlmt').show();
          $('#extend_renewonly').hide();
           $('#extend_both').hide();
            $('#extendsubs').hide();
            $('#extendsubs1').show();
	   });
	  
	   $('#extendsubs').click(function(){
		 var till_date =  $('#tilldate').val();
		 var extendsublead =  $('#extendsublead').val();
		 var extended_data =  $('#extended_data').val();
		 var org_id = '<?php echo $e['org_id'] ?>';
	     var end_date = '<?php echo $e['end_date'] ?>';
	     var status = '<?php echo $t['status'] ?>';
    
	 // alert(extendsublead);

	 
	 if(end_date == till_date){

	 	doNotify('top','center',4,'Please change the Date.');
				return false;

	 }
	 if($('#extendsublead').val().trim()== 0){
					  $('#extendsublead').focus();
						doNotify('top','center',4,'Please select a leadowner.');
						return false;
				  }
	 // alert(status);
	 // return false;
	
	 // if(till_date<=end_date)
	 // {
		// $('#tilldate').focus();
		// doNotify('top','center',4,'Till Date Should be greater than Enddate');
	 //    return false;
	 // }
		 $.ajax({url: "<?php echo URL;?>/ubitech/extendsubs/",
		 data : {'till_date':till_date,'status':status,'org_id':org_id,'extended_data':extended_data,'end_date':end_date,'extendsublead':extendsublead},
		 success: function(result){
			 
          if(result == 1){
			  doNotify('top','center',2,'End Date updated successfully.....');
			   setTimeout(location.reload.bind(location), 2000);
		  }else if(result == 0){
			  doNotify('top','center',3,'No change found.');
			   setTimeout(location.reload.bind(location), 2000);
			 
		  }
         }});
	  });
	  
	  $('#extendsubs1').click(function(){
	     //var till_date =  $('#tilldate').val(); 
	  	 var extended_data =  $('#extended_data').val();
		 var org_id = '<?php echo $e['org_id'] ?>';
		  var status = '<?php echo $t['status'] ?>';
		  var limit=$('#userLimitupgrade2552').val();
		  var extendsublead =  $('#extendsublead').val();
	  	  var currentlimit = <?php echo $data['userLimit'] ?>;
	  	  //var end_date = '<?php echo $e['end_date'] ?>';
		   
		   if(limit <= currentlimit){

		   	doNotify('top','center',4,'Please enter a value greater than existing user limit.');
				return false;
		   }

		  $.ajax({url: "<?php echo URL;?>/ubitech/extendsubs1/",
		  	data : {'status':status,'org_id':org_id,'extended_data':extended_data,'limit':limit,'currentlimit':currentlimit,'extendsublead':extendsublead},

		  	success: function(result){
			 
          if(result == 1){
			  doNotify('top','center',2,'  Userlimit Extended Successfully');
			   setTimeout(location.reload.bind(location), 2000);
		  }else if(result == 0){
			  doNotify('top','center',3,'No change found.');
			   setTimeout(location.reload.bind(location), 2000);
			 
		  }
         }});
		});
	  
	  
	  
	  
	  
	  
	  $('#renew').click(function(){
		  
		  $('#trial_date').hide();
	      $('#buy_date').hide();
	      $('#upgrade_date').show();
	      $('#pdue').hide();
	      $('.payment').show();
	      $('#empFrom').show();
		  $('.trail').hide();
		  $('#upgrade_userlmt').hide();
		  $('#upgrade_renewonly').show();
		  // $('#upgrade_both').hide();
		  $('#next').hide();
		  // $('.close').hide();
		  $('#trail').hide();
		  $('.payment').hide();
		  $('#existingplan').hide();
		  $('#exisitingboth').hide();
		  $('#exisitingrenew').show();
		   $('.existinguser').hide();
		   $('.existingrenuse').hide();



	  })

	  $('#renewo').click(function(){
         $('#upgrade_date').show();
         $('#extend_renewonly').show();
         $('#extend_userlmt').hide();
         $('#exisitingrenew').show();
          $('#extend_both').hide();
          $('#extendsubs1').hide();
          $('#extendsubs').show();
     })
	  // $('#both').click(function(){
		  
		 //  $('#trial_date').hide();
	  //     $('#buy_date').hide();
	  //     $('#upgrade_date').hide();
	  //     $('#pdue').hide();
	  //     $('.payment').hide();
	  //     $('#empFrom').hide();
		 //  $('.trail').hide();
		 //  $('#upgrade_userlmt').hide();
		 //  $('#upgrade_renewonly').hide();
		 //  $('#upgrade_both').show();
		 //  $('#next').hide();
		 //  $('#upgrade_userlmt').hide();
		 //  $('#upgrade_renewonly').hide();
		  
		  // $('.close').hide();



	  // })

	   $('#both').click(function(){
		  
		  $('#trial_date').hide();
	      $('#buy_date').hide();
	      $('#upgrade_date').show();
	      $('#pdue').hide();
	      $('.payment').show();
	      $('#empFrom').show();
		  $('.trail').hide();
		  $('#upgrade_userlmt').hide();
		  $('#upgrade_renewonly').hide();
		  // $('#upgrade_both').hide();
		  $('#next').show();
		  $('#currentuser1').hide();
		  // $('.close').hide();
		  $('#trail').hide();
		  $('.payment').hide();
		  $('#existingplan').hide();
		  $('#exisitingboth').hide();
		   $('.existinguser').hide();
		   // $('#existingrenew').hide();
		   $('#exisitingrenew').hide();
		   $('.existingrenuse').show();



	  })

	    /*$('#bothr').click(function(){
           $('#upgrade_date').show();
         $('#extend_renewonly').hide();
         $('#extend_userlmt').hide();
         $('#extend_both').show();

	    })
*/
	   $('.existingboth').click(function(){
		  
		  $('#trial_date').hide();
	      $('#buy_date').hide();
	      $('#upgrade_date').show();

	      $('#pdue').hide();
	      $('.payment').hide();
	      $('#empFrom').hide();
		  $('.trail').hide();
		  $('#upgrade_userlmt').hide();
		  $('#upgrade_renewonly').hide();
		  // $('#upgrade_both').hide();
		  $('#next').hide();
		  // $('.close').hide();
		   // $('#next').show();
		  $('#trail').hide();
		  $('.payment').hide();
		  $('#existingplan').toggle();
		  $('#exisitingrenew').hide();
		   $('.existinguser').hide();
		   $('.existingrenuse').hide();
		 
		 



	  })
	   
	   $('.existingrenew').click(function(){
		  
		  $('#trial_date').hide();
	      $('#buy_date').hide();
	      $('#upgrade_date').show();

	      $('#pdue').hide();
	      $('.payment').hide();
	      $('#empFrom').show();
		  $('.trail').hide();
		  $('#upgrade_userlmt').hide();
		  $('#upgrade_renewonly').show();
		  // $('#upgrade_both').hide();
		  $('#next').hide();
		  // $('.close').hide();
		   // $('#next').show();
		  $('#trail').hide();
		  // $('.payment').hide();
		  $('#existingplan').toggle();
		  $('.existinguser').hide();
		  $('.existingrenuse').hide();
		 
		 



	  })
	   
	    $('.existinguser').click(function(){
		  
		  $('#trial_date').hide();
	      $('#buy_date').hide();
	      $('#upgrade_date').show();

	      $('#pdue').hide();
	      $('.payment').hide();
	      $('#empFrom').show();
		  $('.trail').hide();
		  $('#upgrade_userlmt').show();
		  $('#upgrade_renewonly').hide();
		  // $('#upgrade_both').hide();
		  $('#next').hide();
		  // $('.close').hide();
		   // $('#next').show();
		  $('#trail').hide();
		  // $('.payment').hide();
		  $('#existingplan').toggle();
		  // $('#existinguser').hide();
		  $('.existingrenew').hide();
		  $('.existingrenuse').hide();
		 
		 



	  })
	    
	     $('.existingrenuse').click(function(){
		  
		  $('#trial_date').hide();
	      $('#buy_date').hide();
	      $('#upgrade_date').show();

	      $('#pdue').hide();
	      $('.payment').hide();
	      $('#empFrom').show();
		  $('.trail').hide();
		  $('#upgrade_userlmt').hide();
		  $('#upgrade_renewonly').hide();
		  // $('#upgrade_both').hide();
		  $('#next').show();
		  // $('.close').hide();
		   // $('#next').show();
		  $('#trail').hide();
		  // $('.payment').hide();
		  $('#existingplan').toggle();
		  // $('#existinguser').hide();
		  $('.existingrenew').hide();
		  $('.existinguser').hide();
		  
		 
		 



	  })

	     $('#userLimitupgrade').click(function(){
	     	$('#currentuser').show();

	     })
	     $('#userLimitupgrade1').click(function(){
	     	$('#currentuser1').show();

	     })

	  
     if($('input:radio[name=r1]:checked').val() == "0")
	 {
       $('#r1').click();
     }
	 if($('input:radio[id=r2]:checked').val() == "1")
	 {
       $('#r2').click();
     }
     if($('input:radio[id=r3]:checked').val() == "1")
	 {
       $('#r3').click();
     }
	</script>
	<script>
	  $('.trail').click(function(){
		 var till_date =  $('#till_date').val();
		 var extended_data =  $('#extended_data').val();
		 var limit   =  $('#userLimit').val();
		 var triallead   =  $('#triallead').val();
		 var trial_remark   =  $('#trial_remark').val();
		
		 var end_date = '<?php echo $t['end_date'] ?>';
		  
		 var org_id = '<?php echo $t['org_id'] ?>';
		 var start_date = '<?php echo $t['start_date'] ?>';

		 if($('#triallead').val().trim()== 0){
					  $('#triallead').focus();
						doNotify('top','center',4,'Please select a leadowner.');
						return false;
				  } 


		 $.ajax({url: "<?php echo URL;?>/ubitech/trial/",
		 data : {'till_date':till_date,'extended_data':extended_data,'start_date':start_date,'org_id':org_id,'trial_remark':trial_remark,'end_date':end_date,'triallead':triallead, 'limit':limit},
		 success: function(result){
			 
          if(result == 1){
			  doNotify('top','center',2,'Package updated successfully.....');
			   setTimeout(location.reload.bind(location), 2000);
		  }else if(result == 0){
			  doNotify('top','center',3,'No change found.');
			   setTimeout(location.reload.bind(location), 2000);
			 
		  }
         }});
	  });
	 /* 
	  $('#buy').click(function(){
		 var end_date   =  $('#end_date').val();
		 var start_date =  $('#start_date').val();
		 var org_id = '<?php echo $t['org_id'] ?>';
		// $.ajax({url: "<?php echo URL;?>/ubitech/buy/",
		 data : {'start_date':start_date,'org_id':org_id,'end_date':end_date},
		 success: function(result){
          if(result == 'true'){
			  doNotify('top','center',2,'Package updated successfully.');
			   setTimeout(location.reload.bind(location), 2000);
		  }else{
			  doNotify('top','center',4,'some error occurs.');
			   setTimeout(location.reload.bind(location), 2000);
			  alert('false');
		  }
         }
		 
		 });
	  */
	/*  $('#updateUserLimit').click(function(){
		 var limit   =  $('#userLimit').val();
		 var org_id = '<?php echo $t['org_id'] ?>';
		 $.ajax({url: "<?php echo URL;?>/ubitech/updateLimit",
		 data : {'limit':limit,'org_id':org_id},
		 success: function(result){
          if(result == 'true'){
			  doNotify('top','center',2,'User limit updated successfully.');
			   setTimeout(location.reload.bind(location), 2000);
		  }else{
			  doNotify('top','center',4,'some error occurs.');
			   setTimeout(location.reload.bind(location), 2000);
			  alert('false');
		  }
         }});
	  });  */
	  $(".payment").click(function(){
		 /* alert('Saved successfull');
		  return false; */
		  
		   if($('#inv_amount').val().trim()<=0)
		   {
			$('#inv_amount').focus();
			doNotify('top','center',4,'Transaction Amount should be greater than zero');
			return false;
		   }
		   
		  if($('#inv_name').val().trim()==''){
					  $('#inv_name').focus();
						doNotify('top','center',4,'Please enter the name.');
						return false;
				  } 
			if($('#inv_country').val().trim()==''){
					  $('#inv_country').focus();
						doNotify('top','center',4,'Please enter the country.');
						return false;
				  } 
			if($('#inv_txn').val().trim()==''){
					  $('#inv_txn').focus();
						doNotify('top','center',4,'Please enter the transaction id.');
						return false;
				  } 
				  if($('#lead').val().trim()== 0){
					  $('#lead').focus();
						doNotify('top','center',4,'Please select a leadowner.');
						return false;
				  } 
				  if($('#paym').val().trim()== 'select'){
					  $('#paym').focus();
						doNotify('top','center',4,'Please select a payment method.');
						return false;
				  }
			if($('#inv_city').val().trim()==''){
					  $('#inv_city').focus();
						doNotify('top','center',4,'Please enter the city.');
						return false;
				  }
			if($('#inv_contact').val().trim()==''){
					  $('#inv_contact').focus();
						doNotify('top','center',4,'Please enter the phone No.');
						return false;
				  } 
if($('#inv_country').val()=='India')
{	
			if($('#inv_gst').val().trim()=='')
					{
					  $('#inv_gst').focus();
						doNotify('top','center',4,'Please enter the GST.');
						return false;
				  }
}		
		if($('#inv_country').val()=='India')
			{  
			if($('#inv_state').val().trim()=='')
					{
					  $('#inv_state').focus();
						doNotify('top','center',4,'Please enter the state.');
						return false;
				    } 
			}
	  	var email=$('#inv_email').val();
	 //	var orgid=$('#inv_orgid').val();
	  	var company=$('#inv_company').val();
	  	var country=$('#inv_country').val();
	  	var name=$('#inv_name').val();
	  	var txn=$('#inv_txn').val();
	  	var currency=$('#inv_currency').val();
	  	var due=$('#inv_due').val();//  no tax and 
	  	var due1=$('#inv_due1').val();//  no tax and 
	  	var lead=$('#lead').val();//  
	  	var paym=$('#paym').val();//  
	  	var amount=$('#inv_amount').val();//  no tax and 
	  	var tax=$('#inv_tax').val();
	  	var dis=$('#inv_dis').val();
	  	var state=$('#inv_state').val();
	  	var city=$('#inv_city').val();
	  	var gst=$('#inv_gst').val();
	  	var contact=$('#inv_contact').val();
	  	var remark=$('#inv_remark').val();
		var limit   =  $('#userLimit1').val();
        amount=amount-tax;  /// tax seprated
		/////////////////////
		var end_date   =  $('#end_date').val();
		var start_date =  $('#start_date').val();
		var org_id = '<?php echo $t['org_id'] ?>';
		
		 $.ajax({url: "<?php echo URL;?>/ubitech/buy/",
		 data : {'start_date':start_date,'org_id':org_id,'end_date':end_date, 'email':email, 'company':company, 'country':country, 'name':name, 'txn':txn, 'currency':currency, 'due':due,'amount':amount,'tax':tax,'dis':dis,'lead':lead,'paym':paym,'state':state, 'city':city,'gst':gst,'contact':contact,'remark':remark,'limit':limit},
		 success: function(result){
			                  
		    if(result == 1)
			{
			  doNotify('top','center',2,'Package updated successfully.');
			  setTimeout(location.reload.bind(location), 2000);
			}
			
		  else if(result == 2)
		  {
			  doNotify('top','center',4,'Already exists Transaction Id');
		  }
		  
		  else{
			  doNotify('top','center',4,'some error occurs.');
			   setTimeout(location.reload.bind(location), 2000);
			 
		  }
         }
	  	});
		
		////////////////
	  });

	  $(".upgradeuserlmt").click(function(){
		 /* alert('Saved successfull');
		  return false; */
		  if($('#inv_amount').val().trim()<=0)
		   {
			$('#inv_amount').focus();
			doNotify('top','center',4,'Transaction Amount should be greater than zero');
			return false;
		   }
		  if($('#inv_name').val().trim()==''){
					  $('#inv_name').focus();
						doNotify('top','center',4,'Please enter the name.');
						return false;
				  } 
				  
				  // if($('#upgusr').val().trim()==''){
					 //  $('#upgusr').focus();
						// doNotify('top','center',4,'Please enter a value greater than 0.');
						// return false;
				  // }
				  if($('#upgusrlmtlead').val().trim()==0){
					  $('#upgusrlmtlead').focus();
						doNotify('top','center',4,'Please select a lead owner.');
						return false;
				  }

				  
				  
			if($('#inv_country').val().trim()==''){
					  $('#inv_country').focus();
						doNotify('top','center',4,'Please enter the country.');
						return false;
				  } 
			if($('#inv_txn').val().trim()==''){
					  $('#inv_txn').focus();
						doNotify('top','center',4,'Please enter the transaction id.');
						return false;
				  } 
				  // if($('#lead').val().trim()== 0){
					 //  $('#lead').focus();
						// doNotify('top','center',4,'Please select a leadowner.');
						// return false;
				  // } 
				  if($('#paym').val().trim()== 'select'){
					  $('#paym').focus();
						doNotify('top','center',4,'Please select a payment method.');
						return false;
				  }
			if($('#inv_city').val().trim()==''){
					  $('#inv_city').focus();
						doNotify('top','center',4,'Please enter the city.');
						return false;
				  }
			if($('#inv_contact').val().trim()==''){
					  $('#inv_contact').focus();
						doNotify('top','center',4,'Please enter the phone.');
						return false;
				  } 
if($('#inv_country').val()=='India')
{	
			if($('#inv_gst').val().trim()=='')
					{
					  $('#inv_gst').focus();
						doNotify('top','center',4,'Please enter the GST.');
						return false;
				  }
}		
		if($('#inv_country').val()=='India')
			{  
			if($('#inv_state').val().trim()=='')
					{
					  $('#inv_state').focus();
						doNotify('top','center',4,'Please enter the state.');
						return false;
				    } 
			}
	  	var email=$('#inv_email').val();
	  	// var upgusr=$('#upgusr').val();
	  	var upgusrlmtlead=$('#upgusrlmtlead').val();
	  	var limit=$('#userLimitupgrade').val();
	  	var currentlimit = <?php echo $data['userLimit'] ?>;
	  	// alert(currentlimit);
	  	
	 //	var orgid=$('#inv_orgid').val();
	  	var company=$('#inv_company').val();
	  	var country=$('#inv_country').val();
	  	var name=$('#inv_name').val();
	  	var txn=$('#inv_txn').val();
	  	var currency=$('#inv_currency').val();
	  	var due=$('#inv_due').val();//  no tax and 
	  	var due1=$('#inv_due1').val();//  no tax and 
	  	var lead=$('#lead').val();//  
	  	var paym=$('#paym').val();//  
	  	var amount=$('#inv_amount').val();//  no tax and 
	  	var tax=$('#inv_tax').val();
	  	var dis=$('#inv_dis').val();
	  	var state=$('#inv_state').val();
	  	var city=$('#inv_city').val();
	  	var gst=$('#inv_gst').val();
	  	var contact=$('#inv_contact').val();
	  	var remark=$('#inv_remark').val();
		// var limit   =  $('#userLimit1').val();
        amount=amount-tax;  /// tax seprated
		/////////////////////
		var end_date   =  $('#end_date').val();
		var start_date =  $('#start_date').val();
		var org_id = '<?php echo $t['org_id'] ?>';
		
		 $.ajax({url: "<?php echo URL;?>/ubitech/upgradeuser/",
		 data : {'start_date':start_date,'currentlimit':currentlimit,'limit':limit,'org_id':org_id,'end_date':end_date, 'email':email, 'company':company, 'country':country, 'name':name, 'txn':txn, 'currency':currency, 'due':due,'amount':amount,'tax':tax,'dis':dis,'lead':lead,'paym':paym,'state':state, 'city':city,'gst':gst,'contact':contact,'remark':remark,'upgusrlmtlead':upgusrlmtlead},
		 success: function(result){
			                  
		    if(result == 1)
			{
			  doNotify('top','center',2,'Package updated successfully.');
			  setTimeout(location.reload.bind(location), 2000);
			}
			
		  else if(result == 2)
		  {
			  doNotify('top','center',4,'Already exists Transaction Id');
		  }
		  
		  else{
			  doNotify('top','center',4,'some error occurs.');
			   setTimeout(location.reload.bind(location), 2000);
			 
		  }
         }
	  	});
		
		////////////////
	  });

	  $(".upgraderenew").click(function(){
		 /* alert('Saved successfull');
		  return false; */
		  if($('#inv_amount').val().trim()<=0)
		   {
			$('#inv_amount').focus();
			doNotify('top','center',4,'Transaction Amount should be greater than zero');
			return false;
		   }
		  if($('#inv_name').val().trim()==''){
					  $('#inv_name').focus();
						doNotify('top','center',4,'Please enter the name.');
						return false;
				  } 
				  if($('#upgrnw').val().trim()==''){
					  $('#upgrnw').focus();
						doNotify('top','center',4,'Please enter a value between 0 and 1000.');
						return false;
				  }
				  if($('#upgrenewlead').val().trim()==0){
					  $('#upgrenewlead').focus();
						doNotify('top','center',4,'Please select a lead owner.');
						return false;
				  }
				   if($('#yrmon').val().trim()==0){
					  $('#yrmon').focus();
						doNotify('top','center',4,'Please select years/months.');
						return false;
				  }

				  
				  
			if($('#inv_country').val().trim()==''){
					  $('#inv_country').focus();
						doNotify('top','center',4,'Please enter the country.');
						return false;
				  } 
			if($('#inv_txn').val().trim()==''){
					  $('#inv_txn').focus();
						doNotify('top','center',4,'Please enter the transaction id.');
						return false;
				  } 
				  // if($('#lead').val().trim()== 0){
					 //  $('#lead').focus();
						// doNotify('top','center',4,'Please select a leadowner.');
						// return false;
				  // } 
				  if($('#paym').val().trim()== 'select'){
					  $('#paym').focus();
						doNotify('top','center',4,'Please select a payment method.');
						return false;
				  }
			if($('#inv_city').val().trim()==''){
					  $('#inv_city').focus();
						doNotify('top','center',4,'Please enter the city.');
						return false;
				  }
			if($('#inv_contact').val().trim()==''){
					  $('#inv_contact').focus();
						doNotify('top','center',4,'Please enter the phone.');
						return false;
				  } 
if($('#inv_country').val()=='India')
{	
			if($('#inv_gst').val().trim()=='')
					{
					  $('#inv_gst').focus();
						doNotify('top','center',4,'Please enter the GST.');
						return false;
				  }
}		
		if($('#inv_country').val()=='India')
			{  
			if($('#inv_state').val().trim()=='')
					{
					  $('#inv_state').focus();
						doNotify('top','center',4,'Please enter the state.');
						return false;
				    } 
			}
	  	var email=$('#inv_email').val();
	  	
	 //	var orgid=$('#inv_orgid').val();
	  	var company=$('#inv_company').val();
	  	var country=$('#inv_country').val();
	  	var name=$('#inv_name').val();
	  	var txn=$('#inv_txn').val();
	  	var currency=$('#inv_currency').val();
	  	var due=$('#inv_due').val();//  no tax and 
	  	var due1=$('#inv_due1').val();//  no tax and 
	  	var lead=$('#lead').val();//  
	  	var paym=$('#paym').val();//  
	  	var amount=$('#inv_amount').val();//  no tax and 
	  	var tax=$('#inv_tax').val();
	  	var dis=$('#inv_dis').val();
	  	var state=$('#inv_state').val();
	  	var city=$('#inv_city').val();
	  	var gst=$('#inv_gst').val();
	  	var contact=$('#inv_contact').val();
	  	var remark=$('#inv_remark').val();
		var limit   =  $('#userLimit1').val();
		var upgrnw   =  $('#upgrnw').val();
		var yrmon   =  $('#yrmon').val();
		var upgrenewlead   =  $('#upgrenewlead').val();
        amount=amount-tax;  /// tax seprated
		/////////////////////
		var end_date   =  $('#end_date').val();
		var start_date =  $('#start_date').val();
		var org_id = '<?php echo $t['org_id'] ?>';
		
		 $.ajax({url: "<?php echo URL;?>/ubitech/upgraderenew/",
		 data : {'start_date':start_date,'org_id':org_id,'end_date':end_date, 'email':email, 'company':company, 'country':country, 'name':name, 'txn':txn, 'currency':currency, 'due':due,'due1':due1,'amount':amount,'tax':tax,'dis':dis,'lead':lead,'yrmon':yrmon,'upgrnw':upgrnw,'paym':paym,'state':state, 'city':city,'gst':gst,'contact':contact,'remark':remark,'upgrenewlead':upgrenewlead,'limit':limit},
		 success: function(result){
			                  
		    if(result == 1)
			{
			  doNotify('top','center',2,'Package updated successfully.');
			  setTimeout(location.reload.bind(location), 2000);
			}
			
		  else if(result == 2)
		  {
			  doNotify('top','center',4,'Already exists Transaction Id');
		  }
		  
		  else{
			  doNotify('top','center',4,'some error occurs.');
			   setTimeout(location.reload.bind(location), 2000);
			 
		  }
         }
	  	});
		
		////////////////
	  });



$(".upgradeboth").click(function(){
		 /* alert('Saved successfull');
		  return false; */
		  if($('#inv_amount').val().trim()<=0)
		   {
			$('#inv_amount').focus();
			doNotify('top','center',4,'Transaction Amount should be greater than zero');
			return false;
		   }
		  if($('#inv_name').val().trim()==''){
					  $('#inv_name').focus();
						doNotify('top','center',4,'Please enter the name.');
						return false;
				  } 
				  
				  // if($('#upgusr1').val().trim()==''){
					 //  $('#upgusr1').focus();
						// doNotify('top','center',4,'Please enter a value greater than 0.');
						// return false;
				  // }
				  if($('#upgrnw1').val().trim()==''){
					  $('#upgrnw1').focus();
						doNotify('top','center',4,'Please enter a value greater than 0.');
						return false;
				  }
				  if($('#upgbothlead').val().trim()==0){
					  $('#upgbothlead').focus();
						doNotify('top','center',4,'Please select a lead owner.');
						return false;
				  }
				   if($('#yrmon1').val().trim()==0){
					  $('#yrmon1').focus();
						doNotify('top','center',4,'Please select years/months.');
						return false;
				  }

				  
				  
			if($('#inv_country').val().trim()==''){
					  $('#inv_country').focus();
						doNotify('top','center',4,'Please enter the country.');
						return false;
				  } 
			if($('#inv_txn').val().trim()==''){
					  $('#inv_txn').focus();
						doNotify('top','center',4,'Please enter the transaction id.');
						return false;
				  } 
				  // if($('#lead').val().trim()== 0){
					 //  $('#lead').focus();
						// doNotify('top','center',4,'Please select a leadowner.');
						// return false;
				  // } 
				  if($('#paym').val().trim()== 'select'){
					  $('#paym').focus();
						doNotify('top','center',4,'Please select a payment method.');
						return false;
				  }
			if($('#inv_city').val().trim()==''){
					  $('#inv_city').focus();
						doNotify('top','center',4,'Please enter the city.');
						return false;
				  }
				  
			if($('#inv_contact').val().trim()==''){
					  $('#inv_contact').focus();
						doNotify('top','center',4,'Please enter the phone.');
						return false;
				  } 
if($('#inv_country').val()=='India')
{	
			if($('#inv_gst').val().trim()=='')
					{
					  $('#inv_gst').focus();
						doNotify('top','center',4,'Please enter the GST.');
						return false;
				  }
}		
		if($('#inv_country').val()=='India')
			{  
			if($('#inv_state').val().trim()=='')
					{
					  $('#inv_state').focus();
						doNotify('top','center',4,'Please enter the state.');
						return false;
				    } 
			}
	  	var email=$('#inv_email').val();
	  	
	  	
	 //	var orgid=$('#inv_orgid').val();
	  	var company=$('#inv_company').val();
	  	var country=$('#inv_country').val();
	  	var name=$('#inv_name').val();
	  	var txn=$('#inv_txn').val();
	  	var currency=$('#inv_currency').val();
	  	var due=$('#inv_due').val();//  no tax and 
	  	var due1=$('#inv_due1').val();//  no tax and 
	  	var lead=$('#lead').val();//  
	  	var paym=$('#paym').val();//  
	  	var amount=$('#inv_amount').val();//  no tax and 
	  	var tax=$('#inv_tax').val();
	  	var dis=$('#inv_dis').val();
	  	var state=$('#inv_state').val();
	  	var city=$('#inv_city').val();
	  	var gst=$('#inv_gst').val();
	  	var contact=$('#inv_contact').val();
	  	var remark=$('#inv_remark').val();
	  	var limit=$('#userLimitupgrade1').val();
	  	var currentlimit = <?php echo $data['userLimit'] ?>;
		// var limit   =  $('#userLimit1').val();
		var upgrnw1   =  $('#upgrnw1').val();
		var yrmon1   =  $('#yrmon1').val();
		var upgbothlead=$('#upgbothlead').val();
		// var upgusr1=$('#upgusr1').val();
		// var upgrenewlead   =  $('#upgrenewlead').val();
        amount=amount-tax;  /// tax seprated
		/////////////////////
		var end_date   =  $('#end_date').val();
		
		var org_id = '<?php echo $t['org_id'] ?>';
		
		 $.ajax({url: "<?php echo URL;?>/ubitech/upgradeboth/",
		 data : {'org_id':org_id,'end_date':end_date,'currentlimit':currentlimit, 'email':email, 'company':company, 'country':country, 'name':name, 'txn':txn, 'currency':currency, 'due':due,'amount':amount,'tax':tax,'dis':dis,'lead':lead,'yrmon1':yrmon1,'upgrnw1':upgrnw1,'paym':paym,'state':state, 'city':city,'gst':gst,'contact':contact,'remark':remark,'upgbothlead':upgbothlead,'limit':limit},
		 success: function(result){
			                  
		    if(result == 1)
			{
			  doNotify('top','center',2,'Package updated successfully.');
			  setTimeout(location.reload.bind(location), 2000);
			}
			
		  else if(result == 2)
		  {
			  doNotify('top','center',4,'Already exists Transaction Id');
		  }
		  
		  else{
			  doNotify('top','center',4,'some error occurs.');
			   setTimeout(location.reload.bind(location), 2000);
			 
		  }
         }
	  	});
		
		////////////////
	  });
	   
	  </script>
	  <script>
	           setTimeout(function(){ 
			       if($('#inv_country').val()=='India')
				   {
						$('#state1').show();
						$('#gst1').show();
						$("#inv_state").val("<?= $data['state'] ?>");
					 
					}
					else
					{
						$('#state1').hide();
						$('#gst1').hide();
					}
					
					
			   }, 2000);
				$('#inv_country').change(function(){
					//alert($('#inv_country').val());
					if($('#inv_country').val()=='India'){
						$('#state1').show();
						$('#gst1').show();
					}
					else
					{
						$('#state1').hide();
						$('#gst1').hide();
					}
				});
			</script>
			
			
	</script>
	
</html>
