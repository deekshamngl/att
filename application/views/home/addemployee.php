<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" />
	<title>Add Employee</title>
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
				  
	.t2{display:none;}
	</style>
	<style type="text/css" media="print" >
		 .print {
			
			  margin-left:40px;
			 align:center;
			 border:2px #666 solid; padding:5px;  
		}

          .nonPrintable
		  {display:none;} /*class for the element we don’t want to print*/
		  
		  
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
   .col-md-6
   {
	   padding-left:10px !important;
   }
	 </style>
	 
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
			$data['pageid']=2.3;
			$this->load->view('menubar/sidebar',$data);
		?>
	    <div class="main-panel">
			<?php
				$this->load->view('menubar/navbar');
			?>
			
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

			<div class="content" id="content">
			  <!-- loader area 
			   <div id = "loader" hidden >
					<center>
					 <img src="<?php echo URL; ?>../assets/img/loaderimg.gif" alt="loader image" height="20%" width="20%" />
					</center>
					 
		       </div>-->
			   
	            <div class="container-fluid" id="maincontainerdiv" >
	                <div class="row">
	                    <div class="col-md-12">
	                        <div class="card">
	                            <div class="card-header" data-background-color="green"> 
	                              <p class="category" title="add employee one by one" style="color:#ffffff;font-size:17px;" > Add</p>
	                              <a rel="tooltip" style="position:relative;margin-top:-30px;"  data-placement="bottom" title="Help" class="btn btn-success btn-sm pull-right toggle-sidebar ">
								<i class="fa fa-question"></i></a>
								  
	                            </div>
	                            <div class="card-content">
									<div id="typography">
										<div class="title">
											<div class="row">
												
												<div class="col-md-12 text-right" >
												
										
                                               <a href="<?php echo URL ?>userprofiles/emport/2.3" class="btn btn-sm btn-success" title="Add multiple employees through import." style="padding:5px 8px;" style=""><i class="fa fa-file-excel-o">&nbsp;Import  Employees</i></a>

												<button title="Employees can register themselves"  class="btn btn-sm btn-success" data-toggle="modal" data-target="#inviteEmp" type="button" style=" font-size:5px ">	
												 <i class="fa fa-plus"> Self Registration </i>
												</button>
												
												<!--
												<button title="Assign Shift Checked Employee"  class="btn btn-sm btn-success"  id="frm-example" data-toggle="modal"  type="button" style="" onclick="updateshift();">
												<i class="fa fa-plus"> Assign Shift </i>
												</button>
												
												
												
													<button  title="Assign Geo Center Checked Employee" class="btn btn-sm btn-success"  id="frm-example" data-toggle="modal"  type="button" style="" onclick="updateGeolocation();">
													<i class="fa fa-plus"> 
													Assign Geo Center </i>
													</button>  -->
												
											
													
												</div>
													<div class="col-md-4 text-right" style="float:right;">	
													</div>
											</div>
										</div>
										
						<div class="container-fluid">
							<form method="POST" id="empFrom" enctype="multipart/form-data" name="myform">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group label-floating">
											<label class="control-label" id="FNLable">Full Name <span class="red"> *</span></label>
											<input type="varchar" id="firstName" title="Please fill the required field" class="form-control " required>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group label-floating">
											<label class="control-label">Email<?php if($_SESSION['specialCase']=='RAKP') { ?><span class="red">*</span><?php }else{?>(optional)<?php } ?> <span class="red"> </span>
											</label>
											<input type="email" id="email" class="form-control " pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" >
										</div>
									</div>
									<!-- <div class="col-md-6">
										<div class="form-group label-floating">
											<label class="control-label" id="shiftNameLable">Last Name <span class="red"> *</span></label>
											<input type="text" id="lastName" title="Please fill the required field" class="form-control " required>
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
									<div class="col-md-6">
									 <div class="form-group label-floating">
										<label class="control-label">Geo Center<span class="red"> </span></label>
										  <?php 
                                            $permis = getAddonPermission($_SESSION['orgid'],'Addon_GeoFence') ;
										  ?>
											<select class="form-control" id="areaAssign" <?php if($permis==0) echo "disabled" ?>  >
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
											<select id="dept" title="Please fill the required field"class="form-control ">
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
											<input type="text" pattern="[0-9]{1}[0-9]{9}" class="form-control numeric" id="cont" title="Please fill the required field" required>
										</div>
									</div>
								</div>
								<div class="row">
								<div class="col-md-6">
										<div class="form-group label-floating">
											<label class="control-label">Password<span class="red"> *</span></label>
											<input type="text" id="password" title="Please fill the required field" class="form-control " value="123456" readonly 
											title="Password is initially set. It can be changed later on by the Admin or the Employee">
										</div>
								</div>
								<!--<div class="col-md-6">
									<div class="form-group label-floating" style="display:none">
										<label class="control-label">Confirm Password<span class="red"> *</span></label>
										<input type="password" id="cpassword" class="form-control " >
									</div>
								</div>-->
								<div class="col-md-6">
										<div class="form-group label-floating">
											<label class="control-label">Shift<span class="red"> *</span></label>
												<select id="shift" title="Please fill the required field" class="form-control ">
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
						<div class="col-md-6">
						<div class="form-group label-floating ">
						<label class="control-label">Country<span class="red"> *</span></label>
						<select id="country" title="Please fill the required field" class="form-control">
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
												<select id="desg" title="Please fill the required field" class="form-control ">
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
								 <!-- row end -->
								<!--<div class="row">
									<div class="col-md-6" >
										<div class="form-group" >
											<label class="control-label">Profile Photo<span class="red"> *</span></label>
												<input id="profile" class="form-control" type="file" name="profile"  onchange="changeImgUpload1(this)">
										</div>
									</div>
									<div class="col-md-6" >
									 <div class="form-group" >
									  <img id="imageAdd" src="" width="150px" height="150px" class="thumbnail"  onerror="this.src=
									  '<?php echo IMGURL3."avatars/male.png"?>'" />
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
													<option value='1' >Admin - <small>for App only</small>
													</option>
													<option value='2' >Dept. Head
													</option>
													<option value='0' selected>User</option>
												</select>
											</div>
									</div>
								
									<div class="col-md-6">
										<div class="form-group label-floating" style="display:none">
											<label class="control-label"> Employment Status<span class="red"> *</span></label>
											<select class="form-control" id="status" >
												<option value='1' selected>Active</option>
												<option value='0'>Inactive</option>
											</select>
										</div>
									</div>
								</div>
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
									<div class="col-md-6">
									 <div class="form-group label-floating">
										<label class="control-label">Geo Center(optional)</label>
										  <?php 
                                            $permis = getAddonPermission($_SESSION['orgid'],'Addon_GeoFence') ;
										  ?>
											<select class="form-control" id="areaAssign" <?php if($permis==0) echo "disabled" ?>  >
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
									
								<div class="col-md-6">
									<div class="form-group label-floating">
										<div style="display:inline-flex;align-items:center;">
											<label class="">Profile Photo
											</label>&nbsp;&nbsp;&nbsp;
											<img id="imageAdd" src="" width="150px" height="150px" style="height:150px;width:150px; " class="thumbnail" onerror="this.src=
									  '<?php echo IMGURL3."avatars/male.png"?>'"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<!--<i class="pencil fa fa-pencil" style="color:purple	;" 
											 title="choose a file">
											</i>
											<input type="file" name="profileE" id="profileE"  onchange="changeImgUpload(this)">-->
											<!--data-toggle="modal" data-target="#confirm"-->
										<span  style="margin-bottom:50px;margin-right:-30px">
												<i class="fa fa-remove delete" rel="tooltip" style="color:purple;" data-placement="bottom" title="Remove Image"></i>
										</span>

										
											<span class="btn1 fa fa-pencil" style="color:purple;margin-left:20px">
												<input type="file" class="form-control" name="profile" id="profile"  onchange="changeImgUpload1(this)" file-upload accept="image/*">
											</span>
											
										</div>
									</div>
								</div>	
									
									
									
									
									
									
									
									
									
									
									
									
									
									
								</div>
								<!--<div class="row" >
								  <div class="col-lg-12" >
								     
									     <?php 
                                            $permis = getAddonPermission($_SESSION['orgid'],'Addon_Payroll') ;
										  ?>
								  
									 <div class="form-group label-floating">
											<label class="control-label">Hourly Rate(optional) </label>
											<select id="hourlyrate" class="form-control " <?php if($permis==0) echo 'disabled' ?> >
													<option value="0">-Select-</option>
													<?php
													$data= json_decode(getAllRate($_SESSION['orgid']));
													for($i=0;$i<count($data);$i++)
														echo '<option value='.$data[$i]->Id.'>'.$data[$i]->Rate.'</option>';
													?>
												</select>
										
									</div>
								  </div>
								</div>-->			
								<div class="clearfix"></div>
							
						
				 </div>
				 <div class="modal-footer">
						<button type="button" id="save"  class="btn btn-success">Submit</button>
					
						<button type="reset" style="margin-top:-0px;" id="resetAdd" class="btn btn-default">Reset</button>
				</div>
					</form>					
										
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

 
<!-- Modal open Invite employee-->
<div id="inviteEmp" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Self Registration</h4>
      </div>
      <div class="modal-body">
		<div>
			<h3>Self Registration</h3>
		</div>
			<form>
					<input id="inveitedEmails" class="form-control" type="email" placeholder="Employee Email(s)  "/>
					<strong>Note: For multiple emails use comma</strong>
				
			</form>
		<div class="clearfix"></div>		
      </div>
      <div class="modal-footer">
        <button type="button" id="sendInvitation"  class="btn btn-success">Send Link</button>
        <button type="button" id="resetInvitation" class="btn btn-default">Reset</button>
      </div>
    </div>
  </div>
  </div>
<!---modal close Invite employee--->
<!-------------------->
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
			<!--<input type="hidden" id="del_id" />-->
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
<!-------------------->
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
	  <div id="mySidenav" class="pull-right sidenav" style="background-image:url(<?=URL?>../assets/img/bg7.jpg);background-repeat:no-repeat;">
		<div class="helpHeader" ><span><b>&nbsp;&nbsp;<i style="font-size:24px; color:black;"class="fa fa-question-circle" ></i ></b></span><a style="color:black;" href="javascript:void(0)" class="closebtn text-right" onclick="closeNav()">x</a></div>
						<div id="sidenavData" class="sidenavData">
						</div>
					</div>
	<script>
	
	function openNav() {
						document.getElementById("mySidenav").style.width = "360PX";
						$('#sidenavData').load('<?=URL?>admin/helpNav',{'pageid': 'userH'});	
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
						
						
	  function printDiv(genQR) {
      setTimeout(function(){
     var printContents = document.getElementById(genQR).innerHTML;
	  
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
var favorite = [];
function updateshift(){
	if($('.checkbox:checked').length > 0)
	{
		$('#shiftEE').val('0');
		$('#shifts').modal('show');
		 favorite = [];
			$.each($("input[name='chk']:checked"), function(e){            
				favorite.push($(this).val());
			});
		
	}
	else
	{
		//alert('select atleast 1 record to update');
		doNotify('top','center',3,'select atleast 1 employee to assign shift');
		//$('#shifts').modal('hide');
		return false;
	}
}
$(document).on("click", "#saveshift", function (e)
				{
					if($('#shiftEE').val()==0)
					{
						$('#shiftEE').focus();
						doNotify('top','center',4,'Please Select the shift');
						return false;
					}
					
						var shift=$('#shiftEE').val();
						
						
						$.ajax({url: "<?php echo URL;?>userprofiles/editshifts",
						data: {"shift":shift,"favorite":favorite}, 
						success: function(result){
							//alert(result);
							if(result == 1)
							{
								$('#shifts').modal('hide');
								doNotify('top','center',2,'Shifts updated Successfully '); 
								table.ajax.reload();
							}
						else
							doNotify('top','center',3,'Error occured, Try later.'); 
								},
						error: function(result)	
						{
							alert("error");
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
		doNotify('top','center',3,'select atleast 1 employee to assign Geofence');
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
							//alert("error");
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
					"paging": true,
				    //"stateSave": true,
				     //"deferRender": true,
				     //"bSort": true,
				//"scrollX": true,
				//"contentType": "application/json",
				order: [[ 1, 'asc' ]],
					"orderable": true,
					//"scrollX": true,
				 dom: 'Bfrtip',
					buttons: [
					'pageLength','csv','excel','copy','print',
					{
						"extend":'colvis',
						"columns":':not(:last-child)',					}
				    ],
	            "columnDefs": [
                  { "visible": false, "targets": 8 }
    
                  ],
				// "bDestroy": false,
				//"searchable": false,
				//"orderable": false,
				columnDefs: [ { orderable: false, targets: [0]}],
				//order: [],
//columnDefs: [ { orderable: false, targets: [0,2,3]}]
				//"targets"  : 'no-sort'
				"contentType": "application/json",
				"ajax": "<?php echo URL;?>userprofiles/getEmployeesData",
				//"dom": 'T<"clear">lfrtpi<"clear">',	
				"columns": [
					{ "data": "change"},
					{ "data": "name" },
					{ "data": "username" },
					{ "data": "department"},
					{ "data": "designation" },
					{ "data": "shift" },
					{ "data": "contact" },
					{ "data": "status" },
					{ "data": "area" },
					{ "data": "action" }
				]
			});
			
			 
				
			 $('#save').click(function(){
		    	var len = $("#cont").val().length;
			    var email = $('#email').val();

			    var userlimit = '<?php echo $userlimit ?>';
			    var regusers = '<?php echo $reguser ?>';
			    var status = '<?php echo $status ?>';
			    // alert(parseInt(userlimit) + 5);

			    if(regusers > parseInt(userlimit) + 5 && status == 1){
			    	doNotify('top','center',4,'Please upgrade your plan as userlimit exceeded.');
			    	return false;
			    }
				//alert($('#cont').val().length);
				  var check=1;
				  if($('#firstName').val().trim()=='')
				  {
					    $('#firstName').focus();
						doNotify('top','center',4,'Please enter the full name.');
						return false;
				  }
				  // if($('#lastName').val().trim()=='')
				  // {
					 //  $('#lastName').focus();
						// doNotify('top','center',4,'Please enter the last name.');
						// return false;
				  // }
				  // <?php if($_SESSION['specialCase']=='RAKP') { ?>
					  // if($('#ecode').val().trim()==''){
						  // $('#ecode').focus();
							// doNotify('top','center',4,'Please enter the Employee code.');
							// return false;
					  // }
				   // <?php } ?>
				  // if($('#email').val().trim()==''){
					  // <?php if($_SESSION['specialCase']=='RAKP') { ?>
					  // $('#email').focus();
						// doNotify('top','center',4,'Please enter the Email Id.');
						// return false;
					  // <?php } ?>
				  // }
				  		 
				if(!$('#email').val().trim()==''){						 
					if (!validate_Email(email)) {
					doNotify('top','center',4,'Please enter valid email Id');
						return false;
						e.preventDefault();
						}
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
				  }	if(isNaN($('#cont').val())){
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
				  
				  if($('#shift').val()=='0'){
					  $('#shift').focus();
						doNotify('top','center',4,'Please Select the shift.');
						return false;
				  }
				  if($('#dept').val()=='0'){
					  <?php if($_SESSION['specialCase']!='RAKP') { ?>  
					  $('#dept').focus();
						doNotify('top','center',4,'Please Select the Department.');
						return false;
					<?php } ?>
				  }
				   if($('#desg').val()=='0'){
					   <?php if($_SESSION['specialCase']!='RAKP') { ?>  
					  $('#desg').focus();
						doNotify('top','center',4,'Please Select the Designation.');
						return false;
						<?php } ?>
				  }
				  if($('#country').val()=='0'){
					   <?php if($_SESSION['specialCase']!='RAKP') { ?>  
					  $('#country').focus();
						doNotify('top','center',4,'Please Select the Country.');
						return false;
						<?php } ?>
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
				   // if($('#profile').val()=='')
					// {
					  // $('#profile').focus();
						// doNotify('top','center',4,'Please browse the file.');
						// check=0;
					// }
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
				   var fname=$('#firstName').val().trim();
				   // var lname=$('#lastName').val().trim();
				   var area=$("#areaAssign").val();
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
					 url: "<?php echo URL;?>userprofiles/insertUsermaster",
					 processData: false,
					 contentType: false,
					 data: formdata,
					 datatype:"json",
					 type:"post",
					 
				    //data: {"fname":fname,"area":area,"lname":lname,"dob":dob,"doj":doj,"doc":doc,"gen":gen,"nat":nat,"ms":ms,"rel":rel,"bg":bg ,"dept":dept ,"desg":desg ,"shift":shift ,"sts":sts ,"sts1":sts1 ,"country":country ,"city":city ,"email":email ,"password":password ,"addr":addr ,"PersonalNo":cont,"ecode":ecode,"hourlyrate":hourlyrate},
					 
				    // data: {"fname":fname,"lname":lname,"dob":dob,"doj":doj,"doc":doc,"gen":gen,"nat":nat,"ms":ms,"rel":rel,"bg":bg ,"dept":dept ,"desg":desg ,"shift":shift ,"sts":sts ,"country":country ,"city":city ,"email":email ,"password":password ,"addr":addr ,"PersonalNo":cont},
					 
						success: function(result){
							 $("#loadmodel").modal('hide'); 
							if(result == 4){
								$('#addEmp').modal('hide');
								doNotify('top','center',2,'User Added Successfully.');
								
								document.getElementById('empFrom').reset();
								
							}else if(result == 1){
								doNotify('top','center',4,'Mail ID already exists');
							
							}else if(result == 2){
								doNotify('top','center',4,'Duplicate phone no. found');
							
							}else if(result == 3){
								doNotify('top','center',4,'Employee code is already exists');
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
				
				  var check=1;
				  if($('#firstNameE').val().trim()=='')
				  {
						$('#firstNameE').focus();
						doNotify('top','center',4,'Please enter the first name');
						check=0;
				  }
				  // if($('#lastNameE').val().trim()=='')
				  // {		
						// $('#lastNameE').focus();
						// doNotify('top','center',4,'Please enter the last name.');
						// check=0;
				  // }
				  
				  if($('#dobE').val()==''){
					  $('#dobE').focus();
						doNotify('top','center',4,'Please enter the date of birth');
						check=0;
				  }
				  if($('#dojE').val()==''){
					  $('#dojE').focus();
						doNotify('top','center',4,'Please enter the date of joining');
						check=0;
				  }
				  if($('#docE').val()==''){
					  $('#docE').focus();
						doNotify('top','center',4,'Please enter the DOC');
						check=0;
				  }
				  if($('#deptE').val()=='0'){
					 <?php if($_SESSION['specialCase']!='RAKP') { ?>
					  $('#deptE').focus();
						doNotify('top','center',4,'Please select the Department');
						check=0;
					 <?php } ?>
				  }
				  if($('#desgE').val()=='0'){
					  <?php if($_SESSION['specialCase']!='RAKP') { ?>
					  $('#desg').focus();
						doNotify('top','center',4,'Please enter the Designation');
						check=0;
					  <?php } ?>
				  }
				  if($('#shiftE').val()=='0'){
					  $('#shiftE').focus();
						doNotify('top','center',4,'Please enter the shift');
						check=0;
				  }
				  /*if($('#emailEE1').val()==''){
					  $('#emailE').focus();
						doNotify('top','center',4,'Please enter the email.');
						check=0;
				  }*/
				  if($('#contE').val().trim()==''){
				  	$('#contE').focus();
				  	doNotify('top','center',4,'Please enter the contact number');
				  	check=0;
				  }
				  
				  if($("#contE").val().length <= 8){
				  	$('#contE').focus();
				  	doNotify('top','center',4,'please enter the correct number')
					check=0;
					
				  }
				  
				  if($('#emailEE1').val().trim()=='' && emailV==1 ){
				  	$('#emailEE1').focus();
				  	doNotify('top','center',4,'Please enter the Email');
				  	check=0;
				  }
				  if(!$('#email').val()==''){						 
					if (!validate_Email(email)) {
					doNotify('top','center',4,'Please enter valid email Id');
						return false;
						e.preventDefault();
						}
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
				  if($('#bgE').val()=='0'){
					  $('#bgE').focus();
						doNotify('top','center',4,'Please select the blood group');
						check=0;
				  }
				  if($('#msE').val()=='0'){
					  $('#msE').focus();
						doNotify('top','center',4,'Please select the marital status');
						check=0;
				  }
				  if($('#relE').val()=='0'){
					  $('#relE').focus();
						doNotify('top','center',4,'Please select the religion');
						check=0;
				  }
				  if($('#nationalityE').val()=='0'){
					  $('#nationalityE').focus();
						doNotify('top','center',4,'Please select the nationality');
						check=0;
				  }
				  if($('#countryE').val()=='0'){
					  $('#countryE').focus();
						doNotify('top','center',4,'Please select the country');
						check=0;
				  }
				  if($('#cityE').val()=='0')
				  {
					  $('#cityE').focus();
						doNotify('top','center',4,'Please select the city');
						check=0;
				  }
				  if($('#addrE').val()==''){
					  $('#msE').focus();
						doNotify('top','center',4,'Please enter the corresponding address');
						check=0;
				  }
				
			  if(check==0)
					  return false;
				  
				   var fname=$('#firstNameE').val().trim();
				   // var lname=$('#lastNameE').val().trim();
				  // var areaE=$('#areaAssinE').val();
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
				   var ecode='';
				   if($('#ecodeE').val()!=undefined)
						ecode=$('#ecodeE').val().trim(); 
				   var areaE = '';
				   if($('#areaAssinE').val()!=undefined)
				   areaE=$('#areaAssinE').val();
				   
				   $.ajax({url: "<?php echo URL;?>userprofiles/editUsermaster",
                   data: {"fname":fname,"areaE":areaE,"lname":lname,"dob":dob,"doj":doj,"doc":doc,"gen":gen,"nat":nat,"ms":ms,"rel":rel,"bg":bg ,"dept":dept ,"desg":desg ,"shift":shift ,"sts":sts ,"sstatus":sstatus,"country":country ,"city":city  ,"password":password ,"addr":addr ,"PersonalNo":cont, "empid":empid,"ecode":ecode,"hourlyrateE":hourlyrateE,"email":email}, //,"email":email
				   success: function(result){
					   
					  if(result=='false3'){
						   doNotify('top','center',3,'Employee code already exists'); 
					  }else if(result=='false'){
						   doNotify('top','center',3,'Duplicate phone no.found'); 
					  }
					  else if(result=='false2')
					  {
						 doNotify('top','center',3,'Email Already Exist');  
					  }
					  else if(result == 1){
						$('#addEmpE').modal('hide');
						 doNotify('top','center',2,'Employee Details updated Successfully'); 
						 table.ajax.reload();  
					  }else
						doNotify('top','center',3,'Error occured, Try later.'); 
                  }});
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
				// $('#lastNameE').val($(this).data('lastname'));
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
				   $("#sname").text("Do you want to change '"+$(this).data('ena')+"' status as Inactive");
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
								 doNotify('top','center',2,'User status updated successfully.'); 
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
				
					doNotify('top','center',2,'Please add mobile no. Then generate QR Code');
			});
			
			
		$(document).ready(function(){
				$('#select_all').on('click',function()
				{
					
					if(this.checked){
						$('.checkbox').each(function(){
							this.checked = true;
						});
					}else{
						 $('.checkbox').each(function()
						 {
							this.checked = false;
						});
						}
				});
			
			});
		
		
			$(document).on("click", ".checkbox", function (){
						if($('.checkbox:checked').length == $('.checkbox').length)	
						{
						$('#select_all').prop('checked',true);
						}
						else
						{
						$('#select_all').prop('checked',false);
						}
						});
			
			
		
			
			// $(document).on("click", ".delete", function () 
				// {
					
				 // const file = document.querySelector('#imageAdd');
					// file.value = '';
				// });
				
				
$('.delete').on('click', function(e) {
	 $("#profile").val(null);
	 $("#imageAdd").attr("src","<?php IMGURL3."avatars/male.png"?>");
      
   });
			// $(document).on("click", "#delete", function (){
				
						// $("#maincontainerdiv").css("opacity","0.08");
						// $("#addEmp").css("opacity","0.02");
						// $("#loader").show("slow");
					  
				// var id=$('#del_id').val(); 
				
				// $.ajax({url: "<?php echo URL;?>userprofiles/deleteUser",
						// data: {"sid":id},
						// success: function(result){
							// //alert(result);
							// if(result == 1){
								 // $('#delEmp').modal('hide');
								 // doNotify('top','center',3,'User archived Successfully.'); 
								 // table.ajax.reload();  
					        // }
							// if(result == 2)
							// {
								// doNotify('top','center',4,"This user has admin permission Its can not be archive."); 
							// }
                             // $("#maincontainerdiv").css("opacity","1");
				             // $("#addEmp").css("opacity","1");
				             // $("#loader").hide("slow");							
						 // },
						// error: function(result){
							// doNotify('top','center',4,'Unable to connect API');
							 // $("#maincontainerdiv").css("opacity","1");
				             // $("#addEmp").css("opacity","1");
				             // $("#loader").hide("slow");
						 // }
				   // });
			// });
			
			
		
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
				$('#shiftime').text($(this).data('shifttime'));
				$('#qrCode').attr('src',"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl="+$(this).data('una')+""+$(this).data('upa')+"&choe=UTF-8");
			});
			//////qr code/
			$(document).on("click", ".resetpwd", function () {
				$('#idResetPassword').val($(this).data('id'));
				$('#nameResetPassword').text($(this).data('name'));
			});
			
			
			$('#resetAdd').click(function(){$('#empFrom')[0].reset();});
			
		$("#submitResetPassword").click(function(){ 
				$('#resetError').text("");
				var pwd=$('#resetPassword');
				var cpwd=$('#confirmResetPassword');
				var id=$('#idResetPassword');
				if(pwd.val().trim().length<6){
					$('#resetError').text('Password must contains at least 6 characters');
					pwd.val(pwd.val().trim());
					pwd.focus();
					return false;
				}
			if(pwd.val().trim() != cpwd.val().trim()){
					$('#resetError').text("Confirm password didn't match");
					cpwd.focus();
					return false;
				}
			$.ajax({
				url: "<?php echo URL;?>userprofiles/resetPassword",
						data: {"pass":pwd.val(),"id":id.val()},
						type: 'post',
						success: function(result){
							result=JSON.parse(result);
							if(result){
								doNotify('top','center',2,'Password Reset Successfully');
								document.getElementById('resetpwdform').reset();
								$('#resetpwd').modal('hide');
							}
							else
								doNotify('top','center',3,'You can not use your current password as new password, Try again');
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			
			});
	</script>
	<script>
		$(document).ready(function(){
			$('#sendInvitation').click(function(){
				var x = $('#inveitedEmails').val();
				if(x==''){
					$('#inveitedEmails').focus();
					return false;
				}
				var emails = x.split(",");
				emails.forEach(function (email) {
				  if(!validateEmail(email.trim())){
					alert(email+' is not a valid mail id, please check');
					return false;
				  }
				});
				///ajax-start
				$.ajax({url: "<?php echo URL;?>admin/sendInvitation",
                   data: {"emails":x},
				   success: function(result){
					   if(result)
							doNotify('top','center',2,result+'link sent');	  
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
			function validateEmail(email) {
			var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(String(email).toLowerCase());
		}
		</script>
	<script>
	$(document).ready(function(){
	$(".toggle-sidebar").click(function(){
	 // if($(".t2").is(':hidden'))
	 //   setTimeout(function(){
		$("#content").toggleClass("col-md-9");
		$("#sidebar").toggleClass("collapsed t2");
		$("#sidebar").load("<?=URL?>admin/helpnav",{'pageid':'userH'});
	 // }, 300);
	});
	
  //   $('.main-panel').click(function(){
		// if(!$(".t2").is(':hidden'))
		// {
		
			
		// 	 $("#sidebar").toggleClass("collapsed t2");
		// 	 $("#content").toggleClass("col-md-12 col-md-9");
		// }
	 //  });
 
	}); 
	 function closemodel()
	{
	  $("#genQR").modal('toggle');   ///// ***********close the dialog *************** 
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
				$('#imageAdd')
					.attr('src', e.target.result);
			};
		reader.readAsDataURL(input.files[0]);
	      }
		}
	  </script>
      
</html>
