<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" />
	<title>Inactive Employees</title>
	<style>
		.red{
			color:red;
			font-weight:'bold';
			font-size:16px;
		}
		.delete{
			cursor:pointer;
		}
		.t2{display:none;}
		div.dt-buttons{
		position:relative;
		float:left;
		margin-left:15px;
		}

		      #example thead tr th.headerSortUp  {
               background-image: url('<?=URL?>../assets/img/up_arrow.png');
              }
              #example thead tr th.headerSortDown  {
              background-image: url('<?=URL?>../assets/img/down_arrow.png');
             }
			 #example tbody tr td.lalign {
             text-align: left;
                   }
				   .id{
					   color:grey;
				   }  

	</style>
	<style type="text/css" media="print" >
		 .print
		  {
			 margin-left:40px;
			 align:center;
			 border:2px #666 solid; padding:5px;  
		  }

          .nonPrintable
		  {display:none;} /*class for the element we don’t want to print*/
		  
         </style>
</head>
<body>
	<div class="wrapper">
		<?php
			$data['pageid']=2.1;
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
	                                <p class="category" style="color:#ffffff;font-size:17px;" > List of Inactive Employees</p>
									<a rel="tooltip"  data-placement="bottom" title="Help" class="btn btn-success btn-sm toggle-sidebar pull-right" style="position:relative;margin-top:-30px;" >
											<i class="fa fa-question"></i></a>
	                            </div>
	                            <div class="card-content">
									<div id="typography">
										<div class="title">
											<div class="row">
												<div class="col-md-8" style="margin-top:-10px;" >
													<h3>Manage Inactive Employees </h3>
												</div>
												<!--<div class="col-md-4 text-right">
													<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addEmp" type="button">	
														<i class="fa fa-plus"> Add</i>
													</button>
												</div>-->
													<div class="col-md-4 text-right">
													
											</div>
											</div>
										</div>
										<div class="row" style="overflow-x:scroll;">
											<table id="example" class="display table " cellspacing="0" width="100%">
											<thead>
												<tr>
													<th class="" width="15%">Name</th>
													<th width="15%">User Name/ Email</th>
													<th>Department</th>
													<th>Designation</th>
													<th>Shift</th>
													<th>Phone</th>
													<th style="background-image:none"!important>Status</th>
													<th class="text-left" width="10%" style="background-image:none"!important >Action</th>
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
			<div class="col-md-3 t2" id="sidebar" style="margin-top: 100px;"></div>
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
<div id="addEmp" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Add New Employee</h4>
      </div>
      <div class="modal-body">
		<form id="empFrom">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label" id="FNLable">Name <span class="red"> *</span></label>
						<input type="varchar" id="firstName" class="form-control alpha" >
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label" id="shiftNameLable">Last Name <span class="red"> *</span></label>
						<input type="text" id="lastName" class="form-control alpha" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Email<span class="red"> *</span></label>
						<input type="email" id="email" class="form-control " pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" >
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Contact No. <span class="red"> *</span></label>
						<input type="text" pattern="[0-9]{1}[0-9]{9}" class="form-control numeric" id="cont"></textarea>
					</div>
				</div>
			</div>
			<div class="row">
			<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Password<span class="red"> *</span></label>
						<input type="password" id="password" class="form-control " >
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Confirm Password<span class="red"> *</span></label>
						<input type="password" id="cpassword" class="form-control " >
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
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Department<span class="red"> *</span></label>
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
			
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Designation<span class="red"> *</span></label>
							<select id="desg" class="form-control ">
								<option value="0">-Select-</option>
								<?php
								$data= json_decode(getAllDesg($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++)
									echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								?>
							</select>
					</div>
				</div>
			
			
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label"> Employment Status<span class="red"> *</span></label>
						<select class="form-control" id="status" >
							<option value='1' selected>Active</option>
							<option value='0'>Inactive</option>
						</select>
					</div>
				</div>
				
					
			
			</div>
			
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
				
			<div class="clearfix"></div>
		</form>
		
      </div>
      <div class="modal-footer">
        <button type="button" id="save"  class="btn btn-success">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!---modal close add employee--->
<!-- Modal open edit employee-->
 <div id="addEmpE" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Update Employee</h4>
      </div>
      <div class="modal-body">
		<form id="empFromE">
		<input type="hidden" id="id" />
			<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating1">
						<label class="control-label" id="FNLableE">Name <span class="red"> *</span></label>
						<input type="text" id="firstNameE" class="form-control alpha" >
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating1">
						<label class="control-label" id="LNLableE">Last Name <span class="red"> *</span></label>
						<input type="text" id="lastNameE" class="form-control alpha" >
					</div>
				</div>
			</div>
			
	
			<!--<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating1">
						<label class="control-label">Date Of Birth<span class="red"> *</span></label>
						<input type="text" id="dobE"  class="form-control datepicker" >
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating1">
						<label class="control-label">Date Of Joining<span class="red"> *</span></label>
						<input type="text" id="dojE"   class="form-control datepicker" >
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group label-floating1">
						<label class="control-label">DOC<span class="red"> *</span></label>
						<input type="text" id="docE" class="form-control datepicker" >
					</div>
				</div>
			</div>-->
			
			<div class="row">
			<div class="col-md-6">
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
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Department<span class="red"> *</span></label>
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
				
				
			</div>
			<div class="row">
			<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Designation<span class="red"> *</span></label>
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
			
		<!--	<div class="col-md-4">
					<div class="form-group label-floating">
						<label class="control-label">Permission<span class="red"> *</span></label>
						<select class="form-control" id="sstatusE" >
							<option value='1' >Admin</option>
							<option value='0' selected>User</option>
						</select>
					</div>
				</div> -->
			<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Employment Status<span class="red"> *</span></label>
						<select class="form-control" id="statusE" >
							<option value='1' selected >Active</option>
							<option value='0'>Inactive</option>
						</select>
					</div>
				</div>
			</div>
					<div class="row">
				
				<div class="col-md-6">
					<div class="form-group label-floating1" style="margin-top:0px;">
						<label class="control-label" style="margin-top:0px;">Contact No.  <span class="red"> *</span></label>
						<input type="number" pattern="[0-9]{1}[0-9]{9}" class="form-control" id="contE">
					</div>
				</div>
				
				<!--<div class="col-md-6">
					<div class="form-group label-floating1">
						<label class="control-label">Email<span class="red"> *</span></label>
						<input type="email" id="emailEE" class="form-control " readonly >
					</div>
				</div>-->	
				<!--<div class="col-md-6">
					<div class="form-group label-floating1">
						<label class="control-label">Password<span class="red"> *</span></label>
						<input type="password" id="passwordE" class="form-control " readonly>
					</div>
				</div>-->
				
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
		</form>
		
		
		
      </div>
      <div class="modal-footer">
        <button type="button" id="saveE"  class="btn btn-success">Update</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
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
        <h4 class="modal-title" id="title">Archive Employee</h4>
      </div>
      <div class="modal-body">		
		<form>
			<input type="hidden" id="del_id" />
			<div class="row">
				<div class="col-md-12">
				  <h4>Move "<span id="na"></span>"to the archive folder?</h4>
				  <p><b>Note:</b> Archived users will still be counted in registered users. To reduce the no. of registered users, delete the user from the archived folder also.</p>
				</div>
			</div>
			<div class="clearfix"></div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="delete"  class="btn btn-warning">Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-----delete employee close--->
<!-----Generate QR code start--->
<div id="genQR"  class="modal fade " role="dialog" style="margin-left:40px;" >
  <div class="modal-dialog" style="width: 250px; align:center;">
    <!-- Modal content-->
    <div class="modal-content print" >
      <div class="modal-header  " >
        <button type="button" class="close nonPrintable" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h6 class="modal-title" id="title" >Employee Identity Card</h6>
      </div>
      <div class="modal-body" >		
		<div>
			<div >
				<strong>
					<div>Name: <span class="id" id="empName"></span></div>
					<div>Designation: <span class="id" id="desgName"></span></div>
					<div>Department: <span class="id" id="deptName"></span></div>
				</strong>
				<center>
					<img width="150px" id="qrCode" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=testing data found &choe=UTF-8"/>
				</center>
				<div>
					<?php echo isset($_SESSION['orgName'])?$_SESSION['orgName']:'';?>
				</div>
			</div>
			<button class="btn btn-warning btn-block nonPrintable" onclick="printDiv('genQR')" value="print a div!">Print</button>
      </div>
    </div>
  </div>
</div>
</div>
<!-- <footer class="footer">
          <div class="container-fluid">
            <nav class="pull-left">
            </nav>
            <p class="copyright pull-right">
              &copy; <script>document.write(new Date().getFullYear())</script> <a href="#">DESIGNED BY</a> ubitech solutions pvt. ltd.
            </p>
          </div>
        </footer>
<!-----Generate QR code close--->

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
				<h4  id="sname">  </h4>	
			<div class="clearfix"></div>

      </div>
			  <div class="modal-footer">
				<button type="button" id="savestatus" class="btn btn-success">Yes</button>
				<button type="button" data-dismiss="modal" class="btn btn-default">No</button>
			  </div>
    </div>
  </div>
  </div>





</body>
 <script src="<?=URL?>../assets/js/buttons.colVis.min.js"></script>
	<script src="<?=URL?>../assets/js/dataTables.buttons.min.js"></script>
	 <script type="text/javascript" src="<?=URL?>../assets/js/moment.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/daterangepicker.js"></script>
	  
      <script type="text/javascript" src="<?=URL?>../assets/js/buttons.flash.min.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/jszip.min.js"></script>
		 <script type="text/javascript" src="<?=URL?>../assets/js/jquery.dataTables.min.js"></script>
	    <script type="text/javascript" src="<?=URL?>../assets/js/buttons.html5.min.js"></script>
		<script type="text/javascript" src="<?=URL?>../assets/js/buttons.print.min.js"></script>
	    
	    
	<div id="mySidenav" class="pull-right sidenav" style="background-image:url(<?=URL?>../assets/img/bg7.jpg);background-repeat:no-repeat;">
						<div class="helpHeader" ><span><b>&nbsp;&nbsp;<i style="font-size:24px; color:black;"class="fa fa-question-circle" ></i ></b></span><a style="color:black;" href="javascript:void(0)" class="closebtn text-right" onclick="closeNav()">x</a></div>
						<div id="sidenavData" class="sidenavData">
						</div>
					</div>
	<script>
	
	function openNav() {
						document.getElementById("mySidenav").style.width = "360PX";
						$('#sidenavData').load('<?=URL?>admin/helpNav',{'pageid': 'userInactive'});	
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
						
						
	  function printDiv(genQR){
		  
      
     var printContents = document.getElementById(genQR).innerHTML;
	  
      var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

    window.print();
	

      document.body.innerHTML = originalContents;
	  /*  var popupWin = window.open('', '', 'width=300,height=300,align=center');
           popupWin.document.open();
           popupWin.document.write('<html><body onload="window.print()">' + genQR.innerHTML + '</html>');  */
}
			
	</script>


	<script type="text/javascript">
    	$(document).ready(function() {
			$( ".datepicker" ).datepicker({
				dateFormat: "yy-mm-dd",
				changeMonth: true,
				changeYear: true,
                yearRange: "1900:2050"				
			});
			var table=$('#example').DataTable( {
					"bProcessing": true,
					"printable": true,
					"responsive":true,
				    //"bServerSide": true,
				    //"stateSave": true,
				     //"deferRender": true,
				     //"bSort": true,
				//"scrollX": true,
				//"contentType": "application/json",
				order: [[ 0, 'asc' ]],
				//"scrollX": true,
					 dom: 'Bfrtip',
					 "bDestroy": true,// destroy data table before reinitializing
					buttons: [
						'pageLength','csv','excel','copy','print',
						{
							"extend":'colvis',
							"columns":':not(:last-child)',
						}
					],
				
				
				// "bDestroy": false,
				//"searchable": false,
				//"orderable": false,
				columnDefs: [ { orderable: false, targets: [6,7]}],
				//"targets"  : 'no-sort'
				"contentType": "application/json",
				"ajax": "<?php echo URL;?>userprofiles/getEmployeesDataInact",
				//"dom": 'T<"clear">lfrtpi<"clear">',		
					
					
				"columns": [
				   
					{ "data": "name" },
					{ "data": "username" },
					{ "data": "department"},
					{ "data": "designation" },
					{ "data": "shift" },
					{ "data": "contact" },
					{ "data": "status" },
					{ "data": "action" }
				]
			});
			$('#save').click(function(){
				  var check=1;
				  if($('#firstName').val()==''){
					  $('#firstName').focus();
						doNotify('top','center',4,'Please enter the first name.');
						check=0;
				  }
				  if($('#lastName').val()==''){
					  $('#lastName').focus();
						doNotify('top','center',4,'Please enter the last name.');
						check=0;
				  }
				  
				  if($('#email').val()==''){
					  $('#email').focus();
						doNotify('top','center',4,'Please enter the email.');
						check=0;
				  }
				   if($('#cont').val()==''){
					  $('#cont').focus();
						doNotify('top','center',4,'Please enter the Contact No..');
						check=0;
				  }
				  
				    
				  if($('#password').val()==''){
					  $('#password').focus();
						doNotify('top','center',4,'Please enter the Password.');
						check=0;
				  }
				  if($('#cpassword').val()==''){
					  $('#cpassword').focus();
						doNotify('top','center',4,'Please enter the confirm password.');
						check=0;
				  }
				  
				  if($('#password').val() != $('#cpassword').val()){
					 $('#password').focus();
                     $('#cpassword').focus();
                        doNotify('top','center',4,'Please check confirm password.');
						check=0;					 
					  
				  }
				  
				  if($('#shift').val()=='0'){
					  $('#shift').focus();
						doNotify('top','center',4,'Please Select the shift.');
						check=0;
				  }
				  if($('#dept').val()=='0'){
					  $('#dept').focus();
						doNotify('top','center',4,'Please Select the Department.');
						check=0;
				  }
				   if($('#desg').val()=='0'){
					  $('#desg').focus();
						doNotify('top','center',4,'Please Select the Designation.');
						check=0;
				  }
				  if($('#dob').val()==''){
					  $('#dob').focus();
						doNotify('top','center',4,'Please enter the date of birth.');
						check=0;
				  }
				  if($('#doj').val()==''){
					  $('#doj').focus();
						doNotify('top','center',4,'Please enter the date of joining.');
						check=0;
				  }
				  if($('#doc').val()==''){
					  $('#doc').focus();
						doNotify('top','center',4,'Please enter the DOC.');
						check=0;
				  }
				  
				 
				
				  if($('#bg').val()=='0'){
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
				  if($('#country').val()=='0'){
					  $('#country').focus();
						doNotify('top','center',4,'Please select the country .');
						check=0;
				  }
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
				  
				   var fname=$('#firstName').val();
				   var lname=$('#lastName').val();
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
				   var sts=$('#status').val();
				   var country=$('#country').val();
				   var city=$('#city').val();
				   var email=$('#email').val();
				   var password=$('#password').val();
				   var addr=$('#addr').val();
				   var cont=$('#cont').val();
				   
				   
				   $.ajax({url: "<?php echo URL;?>userprofiles/insertUsermaster",
				     data: {"fname":fname,"lname":lname,"dob":dob,"doj":doj,"doc":doc,"gen":gen,"nat":nat,"ms":ms,"rel":rel,"bg":bg ,"dept":dept ,"desg":desg ,"shift":shift ,"sts":sts ,"country":country ,"city":city ,"email":email ,"password":password ,"addr":addr ,"PersonalNo":cont},
						success: function(result){
							if(result == "true"){
								$('#addEmp').modal('hide');
								doNotify('top','center',2,'User Added Successfully.');
								//$('#addEmp').modal('hide');
								document.getElementById('empFrom').reset();
								$('#addEmp').modal('hide');
								table.ajax.reload();
							}else{
								doNotify('top','center',4,'user is already exists.');
								document.getElementById('empFrom').reset();
								$('#addEmp').modal('hide');
							}
							
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});
			$('#saveE').click(function(){
				  var check=1;
				  if($('#firstNameE').val()==''){
					  $('#firstNameE').focus();
						doNotify('top','center',4,'Please enter the first name.');
						check=0;
				  }
				  if($('#lastNameE').val()==''){
					  $('#lastNameE').focus();
						doNotify('top','center',4,'Please enter the last name.');
						check=0;
				  }
				  if($('#dobE').val()==''){
					  $('#dobE').focus();
						doNotify('top','center',4,'Please enter the date of birth.');
						check=0;
				  }
				  if($('#dojE').val()==''){
					  $('#dojE').focus();
						doNotify('top','center',4,'Please enter the date of joining.');
						check=0;
				  }
				  if($('#docE').val()==''){
					  $('#docE').focus();
						doNotify('top','center',4,'Please enter the DOC.');
						check=0;
				  }
				  if($('#deptE').val()=='0'){
					  $('#deptE').focus();
						doNotify('top','center',4,'Please Select the Department.');
						check=0;
				  }
				  if($('#desgE').val()=='0'){
					  $('#desg').focus();
						doNotify('top','center',4,'Please enter the Designation.');
						check=0;
				  }
				  if($('#shiftE').val()=='0'){
					  $('#shiftE').focus();
						doNotify('top','center',4,'Please enter the shift.');
						check=0;
				  }
				  if($('#emailE').val()==''){
					  $('#emailE').focus();
						doNotify('top','center',4,'Please enter the email.');
						check=0;
				  }
				  if($('#contE').val()==''){
				  	$('#contE').focus();
				  	doNotify('top','center',4,'please enter the contact Number.');
				  }
				 if($('#contE').val().length <= 8){
				  	$('#contE').focus();
				  	doNotify('top','center',4,'please enter the correct contact Number.');
				  }
				  if($('#bgE').val()=='0'){
					  $('#bgE').focus();
						doNotify('top','center',4,'Please select the blood group.');
						check=0;
				  }
				  if($('#msE').val()=='0'){
					  $('#msE').focus();
						doNotify('top','center',4,'Please select the marital status.');
						check=0;
				  }
				  if($('#relE').val()=='0'){
					  $('#relE').focus();
						doNotify('top','center',4,'Please select the religion.');
						check=0;
				  }
				  if($('#nationalityE').val()=='0'){
					  $('#nationalityE').focus();
						doNotify('top','center',4,'Please select the nationality.');
						check=0;
				  }
				  if($('#countryE').val()=='0'){
					  $('#countryE').focus();
						doNotify('top','center',4,'Please select the country .');
						check=0;
				  }
				  if($('#cityE').val()=='0'){
					  $('#cityE').focus();
						doNotify('top','center',4,'Please select the city.');
						check=0;
				  }
				  if($('#addrE').val()==''){
					  $('#msE').focus();
						doNotify('top','center',4,'Please enter the corresponding address.');
						check=0;
				  }
				
				
			  if(check==0)
					  return false;
				  
				
				
				   var fname=$('#firstNameE').val();
				   var lname=$('#lastNameE').val();
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
				   var email=$('#emailE').val();
				   var password=$('#passwordE').val();
				   var addr=$('#addrE').val();
				   var cont=$('#contE').val();
				   var empid = $("#id").val();
				   var sstatus = $("#sstatusE").val();
				   
				   $.ajax({url: "<?php echo URL;?>userprofiles/editUsermaster",
                   data: {"fname":fname,"lname":lname,"dob":dob,"doj":doj,"doc":doc,"gen":gen,"nat":nat,"ms":ms,"rel":rel,"bg":bg ,"dept":dept ,"desg":desg ,"shift":shift ,"sts":sts ,"sstatus":sstatus,"country":country ,"city":city ,"email":email ,"password":password ,"addr":addr ,"PersonalNo":cont, "empid":empid},
				   success: function(result){
                     if(result == 1){
						$('#addEmpE').modal('hide');
						 doNotify('top','center',2,'Employee Details updated Successfully.'); 
						 table.ajax.reload();  
					 }					    				 
                  }});
			});

			$(document).on("click", ".edit", function () {
				$('#id').val($(this).data('id'));
				$('#firstNameE').val($(this).data('firstname'));
				$('#lastNameE').val($(this).data('lastname'));
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
				$('#emailE').val($(this).data('email'));	
				$('#passwordE').val($(this).data('password'));	
				$('#addrE').val($(this).data('addr'));	
				$('#contE').val($(this).data('cont'));			
				$('#deptE').val($(this).data('dept'));			
				$('#genE').val($(this).data('gen'));
				$('#sstatusE').val($(this).data('sstatus'));	
                				
								
			});
			
			var sid = 0;
			var ssts =  "";
			$(document).on("click", ".status", function (){
				//alert($(this).data('id'));
				   $('.checkbox').each(function()
						 {
							this.checked = false;
						});
						  
				// $("#sname").text("Do you want to change '"+$(this).data('ena') +"'  status as Active");
				 $("#sname").text("Make user active?");
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
                            else if(result == 2)
							{
								alert("Can not delete user");
							}								
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
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
				$('#empName').text($(this).data('name'));
				$('#desgName').text($(this).data('desg'));
				$('#deptName').text($(this).data('dept'));
				$('#qrCode').attr('src',"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl="+$(this).data('una')+""+$(this).data('upa')+"&choe=UTF-8");
			});
			//////qr code/
	</script>
	<script>
		$(document).ready(function(){
		$(".toggle-sidebar").click(function(){
			// if($(".t2").is(':hidden'))
		 //  setTimeout(function(){
		$("#content").toggleClass("col-md-9");
		$("#sidebar").toggleClass("collapsed t2");
		$("#sidebar").load("<?=URL?>admin/helpnav",{'pageid':'userInactive'});
		// }, 300);	
		});
		// $('.main-panel').click(function(){
		// if(!$(".t2").is(':hidden'))
		// {
		// 	 $("#sidebar").toggleClass("collapsed t2");
		// 	 $("#content").toggleClass("col-md-9");
		// }
	 //  });
	});
	</script>
	
	

</html>
