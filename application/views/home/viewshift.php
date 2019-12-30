<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link href="<?=URL?>../assets/css/bootstrap-timepicker.min.css" rel="stylesheet"/>
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="cache-control" content="no-cache">
	<title>ubiAttendance</title>
	<style>
		.red
		{
			color:red;
			font-weight:'bold';
			font-size:16px;
		}
		.deleteShift{
			cursor:pointer;
		}
        .t2
		{
			display: none;
		}
	</style>
	<style>
		
	
	</style>
</head>
<body onload="weekfetch()" >
<div class="wrapper">
		<?php
			$data['pageid']=4;
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
	                                <p class="category" style="color:#ffffff;font-size:17px;" > Edit Shifts</p>
									
	                            </div>
	                            <div class="card-content">
									<div id="typography">
										
								<!-------->

					<?php $assignshiftofemployee = json_decode(assignShiftOfEmployee($sid));
                             $aa =  $assignshiftofemployee[0]->id;
					?>
					
					<?php if($aa==0){?>		 
			         <div class="modal-body">
				     	 <form id="shifrFrom">
					     	<div class="row">
							  <div class="col-md-1" ></div>
							  <div class="col-md-10">
								<strong><span class="text-success">Shift duration</span></strong>
								<label class="checkbox-inline">
									<input  name="shifttype" type="radio" <?php if($sdata[0]['stype']==1) echo 'checked'; ?>  value="1"><b> Single Date</b>
								</label>
								<label class="checkbox-inline">
									<input  name="shifttype" type="radio" value="2" <?php if($sdata[0]['stype']==2) echo 'checked'; ?> ><b> Multi Date </b>
								</label>
							 </div>
							 </div>
							 <div class="row">
						    <div class="col-md-1" ></div>
							<div class="col-md-4">
								<!-- <?php var_dump($sdata);?> -->
							
								<div class="form-group label-floating">
									<label class="control-label" id="shiftNameLable">Shift Name <span class="red"> *</span></label>
									<input type="text" id="shiftNameE" class="form-control" value="<?= $sdata[0]['sname'] ?>"  >
								</div>
							</div>
							 <div class="col-md-2" ></div>
							<div class="col-md-4">
							<?php $assignshift = json_decode(shiftAssign($sid));
                                   $num =  $assignshift[0]->emp;
							 ?>
							<div class="form-group label-floating" style="">
								<label class="control-label">Status  <span class="red"> *</span></label>
								<select class="form-control" 
								<?php if($sdata[0]['status']==1 && $num>0 )  echo 'disabled'; ?> id="statusE">
									<option value='1' <?php if($sdata[0]['status']==1) echo 'selected'; ?> >Active</option>
									<option value='0' <?php if($sdata[0]['status']==0) echo 'selected'; ?> >Inactive</option>
								</select>
								<small style="color:green" >Shift assigned to <?php echo $num; ?> employee(s)</small>
							 </div>
				          </div>
						</div>
						<div class="row">
						   <div class="col-md-1" ></div>
							<div class="col-md-4">
								<div class="form-group label-floating">
									<label class="control-label">Time In  <span class="red"> *</span></label>
									<input type="text" id="timeIn"  class="form-control timepicker" value="<?php echo $sdata[0]['sti'] ?>"  >
								</div>
							</div>
							<div class="col-md-2" ></div>
							<div class="col-md-4">
								<div class="form-group label-floating">
									<label class="control-label">Time Out <span class="red"> *</span></label>
									<input type="text" id="timeOut"   class="form-control timepicker" value="<?php echo $sdata[0]['sto'] ?>"  >
								</div>
							</div>
						</div>
						<div class="row">
						  <div class="col-md-1" ></div>
							<div class="col-md-4">
								<div class="form-group label-floating">
									<label class="control-label"> Break Time Start<span class="red"> *</span></label> 
									<input type="text" id="timeInBreak" class="form-control timepicker" value="<?php echo $sdata[0]['bsti'] ?>"  >
								</div>
							</div>
							<div class="col-md-2" ></div>
							<div class="col-md-4">
								<div class="form-group label-floating">
									<label class="control-label">Break Time End<span class="red"> *</span></label> 
									<input type="text" id="timeOutBreak" class="form-control timepicker" value="<?php echo $sdata[0]['bsto'] ?>"  >
								</div>
							</div>
						</div>
						<div class="row">
						  <div class="col-md-1" ></div>
							<div class="col-md-4">
								<div class="form-group label">
									<label class="control-label">Grace Time In</label> 
									
									<input type="text" id="total-hours" placeholder="Total Grace Hours" class="form-control" value="<?php echo $sdata[0]['tig'] ?>" readonly>
								</div>
							</div>
							<div class="col-md-2" ></div>
							<div class="col-md-4">
								<div class="form-group label">
									<label class="control-label">Grace Time Out</label> 
									
									<input type="text" id="total-hours-out" placeholder="Total Grace Hours" class="form-control" value="<?php echo $sdata[0]['tog'] ?>" readonly >
								</div>
							</div>
						</div>
						<br>
						<br>
						<center>
						<div class="card-content"> 
							<div class="row">
								<div class="col-md-1 col-lg-1 col-xl-1">
								</div>
								<div class="col-md-10 col-lg-10 col-xl-10">
									<div class="panel panel-primary">
									  <div class="panel-heading" 
									  style="background-color:#05afc4;">
										<b>
											Monthly Shift Calendar
										</b>
									  </div>
									  <div class="panel-body" style="overflow: auto; ">
						<center>
							<table width="100%" class="table table-striped table-hover table-bordered" >
								<tr class="info">
									<th><h4 style="font-weight:bold">Day</h4></th>
									<th><h4 style="font-weight:bold">1<sup>st</sup> Week</h4></th>
									<th><h4 style="font-weight:bold">2<sup>nd</sup> Week</h4></th>
									<th><h4 style="font-weight:bold">3<sup>rd</sup> Week</h4></th>
									<th><h4 style="font-weight:bold">4<sup>th</sup> Week</h4></th>
									<th><h4 style="font-weight:bold">5<sup>th</sup> Week</h4></th>
								</tr>
								<tr>
									<td>Sunday</td>
									<td>
									<input type="radio" name="weekOne1" value="0"  /> Working Day
									<br/>
										<input type="radio" name="weekOne1" value="2" /> Half Day <br/>
										<input type="radio" name="weekOne1" value="1" checked="true"/> Off Day
									
										
									</td>
									<td>
										<input type="radio" name="weekTwo1" value="0" /> Working Day
										<br/>
										<input type="radio" name="weekTwo1" value="2" /> Half Day <br/>
										<input type="radio" name="weekTwo1" value="1" checked="true"/> Off Day
										
										
									</td>
									<td><input type="radio" name="weekThree1" value="0" /> Working Day<br/>
										<input type="radio" name="weekThree1" value="2" /> Half Day <br/>
										<input type="radio" name="weekThree1" value="1" checked="true"/> Off Day
										
										
									</td>
									<td>
										<input type="radio" name="weekFour1" value="0" /> Working Day
										<br/>
										<input type="radio" name="weekFour1" value="2" /> Half Day <br/>
										<input type="radio" name="weekFour1" value="1" checked="true"/> Off Day
										<br/>
										
									</td>
										<td><input type="radio" name="weekFive1" value="0" /> Working Day
										<br/>
										<input type="radio" name="weekFive1" value="2" /> Half Day <br/>
										<input type="radio" name="weekFive1" value="1" checked="true"/> Off Day
										<br/>
										
									</td>
								</tr>
								<tr>
									<td>Monday</td>
									<td>
										<input type="radio" name="weekOne2" value="0" checked="true" /> Working Day
										<br/>
										<input type="radio" name="weekOne2" value="2" /> Half Day 
										<br/>
										<input type="radio" name="weekOne2" value="1"/> Off Day
										<br/>
										
									</td>
									<td>
										<input type="radio" name="weekTwo2" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekTwo2" value="2" /> Half Day <br/>
										<input type="radio" name="weekTwo2" value="1" /> Off Day
										
									</td>
									<td>
									<input type="radio" name="weekThree2" value="0" checked="true"/> Working Day
									<br/>
										<input type="radio" name="weekThree2" value="2" /> Half Day <br/>
										<input type="radio" name="weekThree2" value="1" /> Off Day
										<br/>
										
									</td>
									<td>
									<input type="radio" name="weekFour2" value="0" checked="true"/> Working Day
									<br/>
										<input type="radio" name="weekFour2" value="2" /> Half Day <br/>
										<input type="radio" name="weekFour2" value="1" /> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekFive2" value="0" checked="true"/> Working Day
									<br/>
										<input type="radio" name="weekFive2" value="2" /> Half Day <br/>
										<input type="radio" name="weekFive2" value="1" /> Off Day
										
										
									</td>
								</tr>
								<tr>
									<td>Tuesday</td>
									<td>
										<input type="radio" name="weekOne3" value="0" checked="true" /> Working Day	<br/>
										<input type="radio" name="weekOne3" value="2" /> Half Day <br/>
										<input type="radio" name="weekOne3" value="1"/> Off Day
										
									</td>
									<td>
										<input type="radio" name="weekTwo3" value="0" checked="true"/> Working Day
										<br/>
										<input type="radio" name="weekTwo3" value="2" /> Half Day <br/>
										<input type="radio" name="weekTwo3" value="1" /> Off Day
										
									</td>
									<td>
										<input type="radio" name="weekThree3" value="0" checked="true"/>
										Working Day
										<br/>
										<input type="radio" name="weekThree3" value="2" /> Half Day <br/>
										<input type="radio" name="weekThree3" value="1" /> Off Day
										<br/>
										
									</td>
									<td>
									
										<input type="radio" name="weekFour3" value="0" checked="true"/> Working Day
										<br/>
										<input type="radio" name="weekFour3" value="2" /> Half Day <br/>
										<input type="radio" name="weekFour3" value="1" /> Off Day
										
									</td>
									<td>
									<input type="radio" name="weekFive3" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekFive3" value="2" /> Half Day <br/>
										<input type="radio" name="weekFive3" value="1" /> Off Day
										
										
									</td>
								</tr>
								<tr>
									<td>Wednesday</td>
									<td><input type="radio" name="weekOne4" value="0" checked="true" /> Working Day<br/>
										<input type="radio" name="weekOne4" value="2" /> Half Day <br/>
										<input type="radio" name="weekOne4" value="1"/> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekTwo4" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekTwo4" value="2" /> Half Day <br/>
										<input type="radio" name="weekTwo4" value="1" /> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekThree4" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekThree4" value="2" /> Half Day <br/>
										<input type="radio" name="weekThree4" value="1" /> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekFour4" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekFour4" value="2" /> Half Day <br/>
										<input type="radio" name="weekFour4" value="1" /> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekFive4" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekFive4" value="2" /> Half Day <br/>
										<input type="radio" name="weekFive4" value="1" /> Off Day
										
										
									</td>
								</tr>
								<tr>
									<td>Thursday</td>
									<td>
									<input type="radio" name="weekOne5" value="0" checked="true" /> Working Day<br/>
										<input type="radio" name="weekOne5" value="2" /> Half Day <br/>
										<input type="radio" name="weekOne5" value="1"/> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekTwo5" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekTwo5" value="2" /> Half Day <br/>
										<input type="radio" name="weekTwo5" value="1" /> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekThree5" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekThree5" value="2" /> Half Day <br/>
										<input type="radio" name="weekThree5" value="1" /> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekFour5" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekFour5" value="2" /> Half Day <br/>
										<input type="radio" name="weekFour5" value="1" /> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekFive5" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekFive5" value="2" /> Half Day <br/>
										<input type="radio" name="weekFive5" value="1" /> Off Day
										
									</td>
								</tr>
								<tr>
									<td>Friday</td>
									<td>
									<input type="radio" name="weekOne6" value="0" checked="true" /> Working Day<br/>
										<input type="radio" name="weekOne6" value="2" /> Half Day <br/>
										<input type="radio" name="weekOne6" value="1"/> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekTwo6" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekTwo6" value="2" /> Half Day <br/>
										<input type="radio" name="weekTwo6" value="1" /> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekThree6" value="0" checked="true"/> Working Day	<br/>
										<input type="radio" name="weekThree6" value="2" /> Half Day <br/>
										<input type="radio" name="weekThree6" value="1" /> Off Day
									
										
									</td>
									<td>
										<input type="radio" name="weekFour6" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekFour6" value="2" /> Half Day <br/>
										<input type="radio" name="weekFour6" value="1" /> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekFive6" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekFive6" value="2" /> Half Day <br/>
										<input type="radio" name="weekFive6" value="1" /> Off Day
										
										
									</td>
								</tr>
								<tr>
									<td>Saturday</td>
									<td>
									<input type="radio" name="weekOne7" value="0" checked="true" /> Working Day<br/>
										<input type="radio" name="weekOne7" value="2" /> Half Day <br/>
										<input type="radio" name="weekOne7" value="1"/> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekTwo7" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekTwo7" value="2" /> Half Day <br/>
										<input type="radio" name="weekTwo7" value="1" /> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekThree7" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekThree7" value="2" /> Half Day <br/>
										<input type="radio" name="weekThree7" value="1" /> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekFour7" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekFour7" value="2" /> Half Day <br/>
										<input type="radio" name="weekFour7" value="1" /> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekFive7" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekFive7" value="2" /> Half Day <br/>
										<input type="radio" name="weekFive7" value="1" /> Off Day
										 
									</td>
								</tr>
							</table>
							<div>
							    <!--
								<button id="save" class="btn btn-success">Save</button>
								<a id="clear" href="<?=URL?>Dashboard" onclick="history.go(-1);" class="btn btn-default">Cancel</a> -->
							</div>
						</center>
						</div>
						</div>
						<!---- Submit Button ----->
					  <div class="">
						 <button type="button" id="saveE" class="btn btn-success">Save</button>
						 <a href="<?php echo URL;?>admin/shifts" class="btn btn-success">Cancel</a>
					  </div>
						</div>
								<div class="col-md-1 col-lg-1 col-xl-1">
								</div>
							</div>
						</div>
					</center>

						  <div class="clearfix"></div>
					    </form>
                     </div>
					
					<?php } else { ?>
					<div class="modal-body">
				     	 <form id="shifrFrom">
					     	<div class="row">
							  <div class="col-md-1" ></div>
							  <div class="col-md-10">
								<strong><span class="text-success">Shift duration</span></strong>
								<label class="checkbox-inline">
									<input  name="shifttype" type="radio" <?php if($sdata[0]['stype']==1) echo 'checked'; ?>  value="1"><b> Single Date</b>
								</label>
								<label class="checkbox-inline">
									<input  name="shifttype" type="radio" value="2" <?php if($sdata[0]['stype']==2) echo 'checked'; ?> ><b> Multi Date </b>
								</label>
							 </div>
							 </div>
							 <div class="row">
						    <div class="col-md-1" ></div>
							<div class="col-md-4">
							
								<div class="form-group label-floating">
									<label class="control-label" id="shiftNameLable">Shift Name <span class="red"> *</span></label>
									<input type="text" id="shiftNameE" class="form-control" value="<?= $sdata[0]['sname'] ?>"  >
								</div>
							</div>
							 <div class="col-md-2" ></div>
							<div class="col-md-4">
							<?php $assignshift = json_decode(shiftAssign($sid));
                                   $num =  $assignshift[0]->emp;
							 ?>
							<div class="form-group label-floating" style="">
								<label class="control-label">Status  <span class="red"> *</span></label>
								<select class="form-control" 
								<?php if($sdata[0]['status']==1 && $num>0 )  echo 'disabled'; ?> id="statusE">
									<option value='1' <?php if($sdata[0]['status']==1) echo 'selected'; ?> >Active</option>
									<option value='0' <?php if($sdata[0]['status']==0) echo 'selected'; ?> >Inactive</option>
								</select>
								<small style="color:green" >Shift assigned to <?php echo $num; ?> employee(s)</small>
							 </div>
				          </div>
						</div>
						<div class="row">
						   <div class="col-md-1" ></div>
							<div class="col-md-4">
								<div class="form-group label-floating">
									<label class="control-label">Time In  <span class="red"> *</span></label>
									<input type="text" id="timeIn"  class="form-control timepicker" value="<?php echo $sdata[0]['sti'] ?>" disabled >
								</div>
							</div>
							<div class="col-md-2" ></div>
							<div class="col-md-4">
								<div class="form-group label-floating">
									<label class="control-label">Time Out <span class="red"> *</span></label>
									<input type="text" id="timeOut"   class="form-control timepicker" value="<?php echo $sdata[0]['sto'] ?>" disabled >
								</div>
							</div>
						</div>
						<div class="row">
						  <div class="col-md-1" ></div>
							<div class="col-md-4">
								<div class="form-group label-floating">
									<label class="control-label"> Break Time Start<span class="red"> *</span></label> 
									<input type="text" id="timeInBreak" class="form-control timepicker" value="<?php echo $sdata[0]['bsti'] ?>" disabled >
								</div>
							</div>
							<div class="col-md-2" ></div>
							<div class="col-md-4">
								<div class="form-group label-floating">
									<label class="control-label">Break Time End<span class="red"> *</span></label> 
									<input type="text" id="timeOutBreak" class="form-control timepicker" value="<?php echo $sdata[0]['bsto'] ?>" disabled >
								</div>
							</div>
						</div>
						<br>
						<br>
						<center>
						<div class="card-content"> 
							<div class="row">
								<div class="col-md-1 col-lg-1 col-xl-1">
								</div>
								<div class="col-md-10 col-lg-10 col-xl-10">
									<div class="panel panel-primary">
									  <div class="panel-heading" 
									  style="background-color:#05afc4;">
										<b>
											Monthly Shift Calendar
										</b>
									  </div>
									  <div class="panel-body" style="overflow: auto; ">
						<center>
							<table width="100%" class="table table-striped table-hover table-bordered" >
								<tr class="info">
									<th><h4 style="font-weight:bold">Day</h4></th>
									<th><h4 style="font-weight:bold">1<sup>st</sup> Week</h4></th>
									<th><h4 style="font-weight:bold">2<sup>nd</sup> Week</h4></th>
									<th><h4 style="font-weight:bold">3<sup>rd</sup> Week</h4></th>
									<th><h4 style="font-weight:bold">4<sup>th</sup> Week</h4></th>
									<th><h4 style="font-weight:bold">5<sup>th</sup> Week</h4></th>
								</tr>
								<tr>
									<td>Sunday</td>
									<td>
									<input type="radio" name="weekOne1" value="0"  /> Working Day
									<br/>
										<input type="radio" name="weekOne1" value="2" /> Half Day <br/>
										<input type="radio" name="weekOne1" value="1" checked="true"/> Off Day
									
										
									</td>
									<td>
										<input type="radio" name="weekTwo1" value="0" /> Working Day
										<br/>
										<input type="radio" name="weekTwo1" value="2" /> Half Day <br/>
										<input type="radio" name="weekTwo1" value="1" checked="true"/> Off Day
										
										
									</td>
									<td><input type="radio" name="weekThree1" value="0" /> Working Day<br/>
										<input type="radio" name="weekThree1" value="2" /> Half Day <br/>
										<input type="radio" name="weekThree1" value="1" checked="true"/> Off Day
										
										
									</td>
									<td>
										<input type="radio" name="weekFour1" value="0" /> Working Day
										<br/>
										<input type="radio" name="weekFour1" value="2" /> Half Day <br/>
										<input type="radio" name="weekFour1" value="1" checked="true"/> Off Day
										<br/>
										
									</td>
										<td><input type="radio" name="weekFive1" value="0" /> Working Day
										<br/>
										<input type="radio" name="weekFive1" value="2" /> Half Day <br/>
										<input type="radio" name="weekFive1" value="1" checked="true"/> Off Day
										<br/>
										
									</td>
								</tr>
								<tr>
									<td>Monday</td>
									<td>
										<input type="radio" name="weekOne2" value="0" checked="true" /> Working Day
										<br/>
										<input type="radio" name="weekOne2" value="2" /> Half Day 
										<br/>
										<input type="radio" name="weekOne2" value="1"/> Off Day
										<br/>
										
									</td>
									<td>
										<input type="radio" name="weekTwo2" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekTwo2" value="2" /> Half Day <br/>
										<input type="radio" name="weekTwo2" value="1" /> Off Day
										
									</td>
									<td>
									<input type="radio" name="weekThree2" value="0" checked="true"/> Working Day
									<br/>
										<input type="radio" name="weekThree2" value="2" /> Half Day <br/>
										<input type="radio" name="weekThree2" value="1" /> Off Day
										<br/>
										
									</td>
									<td>
									<input type="radio" name="weekFour2" value="0" checked="true"/> Working Day
									<br/>
										<input type="radio" name="weekFour2" value="2" /> Half Day <br/>
										<input type="radio" name="weekFour2" value="1" /> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekFive2" value="0" checked="true"/> Working Day
									<br/>
										<input type="radio" name="weekFive2" value="2" /> Half Day <br/>
										<input type="radio" name="weekFive2" value="1" /> Off Day
										
										
									</td>
								</tr>
								<tr>
									<td>Tuesday</td>
									<td>
								
										<input type="radio" name="weekOne3" value="0" checked="true" /> Working Day	<br/>
										<input type="radio" name="weekOne3" value="2" /> Half Day <br/>
										<input type="radio" name="weekOne3" value="1"/> Off Day
										
									</td>
									<td>
										<input type="radio" name="weekTwo3" value="0" checked="true"/> Working Day
										<br/>
										<input type="radio" name="weekTwo3" value="2" /> Half Day <br/>
										<input type="radio" name="weekTwo3" value="1" /> Off Day
										
									</td>
									<td>
										<input type="radio" name="weekThree3" value="0" checked="true"/>
										Working Day
										<br/>
										<input type="radio" name="weekThree3" value="2" /> Half Day <br/>
										<input type="radio" name="weekThree3" value="1" /> Off Day
										<br/>
										
									</td>
									<td>
									
										<input type="radio" name="weekFour3" value="0" checked="true"/> Working Day
										<br/>
										<input type="radio" name="weekFour3" value="2" /> Half Day <br/>
										<input type="radio" name="weekFour3" value="1" /> Off Day
										
									</td>
									<td>
									<input type="radio" name="weekFive3" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekFive3" value="2" /> Half Day <br/>
										<input type="radio" name="weekFive3" value="1" /> Off Day
										
										
									</td>
								</tr>
								<tr>
									<td>Wednesday</td>
									<td><input type="radio" name="weekOne4" value="0" checked="true" /> Working Day<br/>
										<input type="radio" name="weekOne4" value="2" /> Half Day <br/>
										<input type="radio" name="weekOne4" value="1"/> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekTwo4" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekTwo4" value="2" /> Half Day <br/>
										<input type="radio" name="weekTwo4" value="1" /> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekThree4" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekThree4" value="2" /> Half Day <br/>
										<input type="radio" name="weekThree4" value="1" /> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekFour4" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekFour4" value="2" /> Half Day <br/>
										<input type="radio" name="weekFour4" value="1" /> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekFive4" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekFive4" value="2" /> Half Day <br/>
										<input type="radio" name="weekFive4" value="1" /> Off Day
										
										
									</td>
								</tr>
								<tr>
									<td>Thursday</td>
									<td>
									<input type="radio" name="weekOne5" value="0" checked="true" /> Working Day<br/>
										<input type="radio" name="weekOne5" value="2" /> Half Day <br/>
										<input type="radio" name="weekOne5" value="1"/> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekTwo5" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekTwo5" value="2" /> Half Day <br/>
										<input type="radio" name="weekTwo5" value="1" /> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekThree5" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekThree5" value="2" /> Half Day <br/>
										<input type="radio" name="weekThree5" value="1" /> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekFour5" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekFour5" value="2" /> Half Day <br/>
										<input type="radio" name="weekFour5" value="1" /> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekFive5" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekFive5" value="2" /> Half Day <br/>
										<input type="radio" name="weekFive5" value="1" /> Off Day
										
									</td>
								</tr>
								<tr>
									<td>Friday</td>
									<td>
									<input type="radio" name="weekOne6" value="0" checked="true" /> Working Day<br/>
										<input type="radio" name="weekOne6" value="2" /> Half Day <br/>
										<input type="radio" name="weekOne6" value="1"/> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekTwo6" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekTwo6" value="2" /> Half Day <br/>
										<input type="radio" name="weekTwo6" value="1" /> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekThree6" value="0" checked="true"/> Working Day	<br/>
										<input type="radio" name="weekThree6" value="2" /> Half Day <br/>
										<input type="radio" name="weekThree6" value="1" /> Off Day
									
										
									</td>
									<td>
										<input type="radio" name="weekFour6" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekFour6" value="2" /> Half Day <br/>
										<input type="radio" name="weekFour6" value="1" /> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekFive6" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekFive6" value="2" /> Half Day <br/>
										<input type="radio" name="weekFive6" value="1" /> Off Day
										
										
									</td>
								</tr>
								<tr>
									<td>Saturday</td>
									<td>
									<input type="radio" name="weekOne7" value="0" checked="true" /> Working Day<br/>
										<input type="radio" name="weekOne7" value="2" /> Half Day <br/>
										<input type="radio" name="weekOne7" value="1"/> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekTwo7" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekTwo7" value="2" /> Half Day <br/>
										<input type="radio" name="weekTwo7" value="1" /> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekThree7" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekThree7" value="2" /> Half Day <br/>
										<input type="radio" name="weekThree7" value="1" /> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekFour7" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekFour7" value="2" /> Half Day <br/>
										<input type="radio" name="weekFour7" value="1" /> Off Day
										
										
									</td>
									<td>
									<input type="radio" name="weekFive7" value="0" checked="true"/> Working Day<br/>
										<input type="radio" name="weekFive7" value="2" /> Half Day <br/>
										<input type="radio" name="weekFive7" value="1" /> Off Day
										 
									</td>
								</tr>
							</table>
							<div>
							    <!--
								<button id="save" class="btn btn-success">Save</button>
								<a id="clear" href="<?=URL?>Dashboard" onclick="history.go(-1);" class="btn btn-default">Cancel</a> -->
							</div>
						</center>
						</div>
						</div>
						<!---- Submit Button ----->
					  <div class="">
						 <button type="button" id="saveE" class="btn btn-success">Save</button>
						 <a href="<?php echo URL;?>admin/shifts" class="btn btn-success">Cancel</a>
					  </div>
						</div>
								<div class="col-md-1 col-lg-1 col-xl-1">
								</div>
							</div>
						</div>
					</center>

						  <div class="clearfix"></div>
					    </form>
                     </div>
					<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
 </div>
</div>
	        
<div class="col-md-3 t2" id="sidebar" style=" margin-top:100px;">

</div>
	       
		<footer class="footer">
				<div class="container-fluid">
					<nav class="pull-left">
						
					</nav>
					<!--<p class="copyright pull-right" style="padding-right:25px;" >
              &copy; <script>document.write(new Date().getFullYear())</script>. Developed by<a href="http://www.ubitechsolutions.com/" target="_blank" > Ubitech Solutions </a></p>-->
			  <a href="http://www.ubitechsolutions.com/" target="_blank" >
					<p class="copyright pull-right" style="padding-right:25px;padding-top:0px" >
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

						<div class="helpHeader" ><span><b>&nbsp;&nbsp;<i style="font-size:24px; color:black;"class="fa fa-question-circle" ></i ></b></span><a style="color:black;" href="javascript:void(0)" class="closebtn text-right" onclick="closeNav()">x </a></div>
						<div id="sidenavData" class="sidenavData">
						</div>
					</div>
	<script>
	
	function openNav() {
							document.getElementById("mySidenav").style.width = "360PX";
							
							
							$('#sidenavData').load('<?=URL?>admin/helpNav',{'pageid': 'shiftH'});	
						}
						function closeNav() {
							document.getElementById("mySidenav").style.width = "0";
						}
			//$("#mySidenav").toggleClass("collapsed");
			//$("#content").toggleClass("col-md-12 col-md-9");	
	
	</script>

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
		

	<script type="text/javascript">
            $('.timepicker').timepicker();
			//set  shift data
		
       </script>
	<script type="text/javascript">
    	$(document).ready(function() {
			//var h='<?php echo $_SESSION['orgid'];?>';
			
			var a='<?php $assignshiftofemployee = json_decode(assignShiftOfEmployee($sid));
                            echo  $num =  $assignshiftofemployee[0]->id;
							 ?>';
			if(a!=0)
		$('input[type="radio"]').prop('disabled', true);
	
		
		//if(h==8957)
		//$('input[type="radio"]').prop('disabled', false);
	
			var table=$('#example').DataTable( {
				//"scrollX": true,
				"order": [[ 1, "desc" ]],
					"orderable": false,
					//"scrollX": true,
					"columnDefs": [ {
						"searchable": false,
						"orderable": false,
						"targets"  : "no-sort",
						//"className": 'noVis'
					}],
				 dom: 'Bfrtip',
					"buttons": [
					'pageLength','csv','excel','copy','print',
					{
						"extend":'colvis',
						"columns":':not(:last-child)',
					}
					
				],
				"contentType": "application/json",
				"ajax": "<?php echo URL;?>admin/getAllShift",
				"columns": [
					{ "data": "name" },
					{ "data": "timein" },
					{ "data": "timeout" },
					//{ "data": "timeingrace" },
					//{ "data": "timeoutgrace" },
					{ "data": "timeinbreak" },
					{ "data": "timeoutbreak" },
					{ "data": "shifttype" },
					{ "data": "shifthpurs" },
					{ "data": "workhours" },
					{ "data": "status" },
					{ "data": "action" }
				]
			});
			  $('input.timepicker').timepicker();
			  
			  $('#save').click(function(){
				   if($('#shiftName').val()==''){
					  $('#shiftName').focus();
						doNotify('top','center',4,'Please enter the shift name.');
					  return false;
				  }
				  var sna=$('#shiftName').val();
				   var ti=$('#timeIn').val();
				   var to=$('#timeOut').val();
				   var tib=$('#timeInBreak').val();
				   var tob=$('#timeOutBreak').val();
				   var tig=$('#timeInGrace').val();
				   var tog=$('#timeOutGrace').val();
				   var bog=$('#breakInGrace').val();
				   var big=$('#breakOutGrace').val();
				   var sts=$('#status').val();
				  
				  
				  ////////////////////////////////
				   var shifttype='';
				   shifttype=$("input[name='shifttype']:checked").val();
				   if(shifttype==0 || shifttype==''){ 
					doNotify('top','center',4,'Please select the shift type.');
					return false;
				   }
  				    var fromdt="2013/05/29 "+ti;
					var todt="2013/05/29 "+to;
					var tot="2013/05/29 24:00:00";
					var frm = new Date(Date.parse(fromdt));
					var to1 = new Date(Date.parse(todt));
					var tot1 = new Date(Date.parse(todt));
					
					var diff = (frm - to1) / 60000; //dividing by seconds and milliseconds
					var minutes = (diff % 60).toString();
					var hours = (((diff - minutes) / 60).toString()).replace('-','');
					var shiftHours='';
				   var sht='';
				  if(minutes=='60')
						{
							hours=(parseInt(hours)+1).toString();
							minutes='00';
						}
				   if(shifttype==1){
					   sht='Same Day';
					   
					    if(ti == to){
						    alert("Time In and Time Out can not be same for the shift");   
						  return false;
					   }
					   
					   if (frm > to1){
						alert("Time In can not be greater than Time Out for Single day shift.");   
						  return false;
					   }
							//alert(hours);
						if(hours >= 16)
						{
							alert("you can not add more than 16 hours.");
							return false;
						}
				   }
				   if(shifttype==2){
						sht='Two Days';
						
						if(ti == to){
						    alert("Time In and Time Out can not be same for the shift");   
						  return false;
					   }
						if (frm < to1){
						alert("Time Out can not be greater than Time In for Multiple day shift.");   
						  return false;
					   }
					  	//alert(hours);
						if(hours >= 16)
						{
					alert("You have to add the shift of less than 16 Hours, Eg.15:59 hr");
							return false;
						}
				   }
				    
				
					shiftHours = hours+":"+minutes;
				  if(!confirm("You are going to register a new shift "+sna+" of "+shiftHours +" hrs, which will start/end within "+sht+" \n Do you want to create this shift?"))
					return false;
				
				  ///////////////Start weekoff functionality /////////////////
				  
				  var weekOne=$("input[name='weekOne1']:checked").val();
				  var weekTwo=$("input[name='weekTwo1']:checked").val();
				  var weekThree=$("input[name='weekThree1']:checked").val();
				  var weekFour=$("input[name='weekFour1']:checked").val();
				  var weekFive=$("input[name='weekFive1']:checked").val();
				  var sunday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				   weekOne=$("input[name='weekOne2']:checked").val();
				   weekTwo=$("input[name='weekTwo2']:checked").val();
				   weekThree=$("input[name='weekThree2']:checked").val();
				   weekFour=$("input[name='weekFour2']:checked").val();
				   weekFive=$("input[name='weekFive2']:checked").val();
				  var monday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				   weekOne=$("input[name='weekOne3']:checked").val();
				   weekTwo=$("input[name='weekTwo3']:checked").val();
				   weekThree=$("input[name='weekThree3']:checked").val();
				   weekFour=$("input[name='weekFour3']:checked").val();
				   weekFive=$("input[name='weekFive3']:checked").val();
				  var tuesday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				   weekOne=$("input[name='weekOne4']:checked").val();
				   weekTwo=$("input[name='weekTwo4']:checked").val();
				   weekThree=$("input[name='weekThree4']:checked").val();
				   weekFour=$("input[name='weekFour4']:checked").val();
				   weekFive=$("input[name='weekFive4']:checked").val();
				  var wednesday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				   weekOne=$("input[name='weekOne5']:checked").val();
				   weekTwo=$("input[name='weekTwo5']:checked").val();
				   weekThree=$("input[name='weekThree5']:checked").val();
				   weekFour=$("input[name='weekFour5']:checked").val();
				   weekFive=$("input[name='weekFive5']:checked").val();
				  var thusday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				   weekOne=$("input[name='weekOne6']:checked").val();
				   weekTwo=$("input[name='weekTwo6']:checked").val();
				   weekThree=$("input[name='weekThree6']:checked").val();
				   weekFour=$("input[name='weekFour6']:checked").val();
				   weekFive=$("input[name='weekFive6']:checked").val();
				  var friday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				   weekOne=$("input[name='weekOne7']:checked").val();
				   weekTwo=$("input[name='weekTwo7']:checked").val();
				   weekThree=$("input[name='weekThree7']:checked").val();
				   weekFour=$("input[name='weekFour7']:checked").val();
				   weekFive=$("input[name='weekFive7']:checked").val();
				  var saturday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				  
				  ///////////////End  weekoff functionality /////////////////

				   
				   $.ajax({url: "<?php echo URL;?>admin/registerShift",
						data: {"sna":sna,"ti":ti,"to":to,"tib":tib,"tob":tob,"tig":tig,"tog":tog,"bog":bog,"big":big,"sts":sts,"shifttype":shifttype,"sun":sunday,"mon":monday,"tue":tuesday,"wed":wednesday,"thus":thusday,"fri":friday,"sat":saturday},
						success: function(result){
							if(result == 1){
								doNotify('top','center',2,'Shift Added Successfully.');
								$('#addShift').modal('hide');
								document.getElementById('shifrFrom').reset();
								 setTimeout(function(){
								  window.location.replace("<?php echo URL;?>admin/shifts");
								 }, 2000);
							}else if(result== 2){
								doNotify('top','center',3,'Shift '+sna+'  already exist.');
															
							}
							else{
								doNotify('top','center',4,'There may error(s) in creating shift, try later.');
								document.getElementById('shifrFrom').reset();
								$('#addShift').modal('hide');
							}
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});  
			
			
			$('#saveE').click(function(){

				  if($('#shiftNameE').val()==''){
					  $('#shiftNameE').focus();
						doNotify('top','center',4,'Please enter the shift name.');
					  return false;
				  }
				   var sid=<?= $sid; ?>;
				   var sna=$('#shiftNameE').val();
				  var ti=$('#timeIn').val();
				   var to=$('#timeOut').val();
				   var tib=$('#timeInBreak').val();
				   var tob=$('#timeOutBreak').val();
				   var tig=$('#timeInGrace').val();
				   var tog=$('#timeOutGrace').val();
				   var bog=$('#breakInGrace').val();
				   var big=$('#breakOutGrace').val();
				   var sts=$('#statusE').val();
				    var shifttype='';
				   shifttype=$("input[name='shifttype']:checked").val();
				   
					var fromdt="2013/05/29 "+ti;
					var todt="2013/05/29 "+to;
					var tot="2013/05/29 24:00:00";
					var frm = new Date(Date.parse(fromdt));
					var to1 = new Date(Date.parse(todt));
					var tot1 = new Date(Date.parse(todt));
					
					var diff = (frm - to1) / 60000; //dividing by seconds and milliseconds
					var minutes = (diff % 60).toString();
					var hours = (((diff - minutes) / 60).toString()).replace('-','');
					var shiftHours='';
				   var sht='';
				  if(minutes=='60')
						{
							hours=(parseInt(hours)+1).toString();
							minutes='00';
						}
				   if(shifttype==1){
					   sht='Same Day';
					   
					    if(ti == to){
						    alert("Time In and Time Out can not be same for the shift");   
						  return false;
					   }
					   
					   if (frm > to1){
						alert("Time In can not be greater than Time Out for Single day shift.");   
						  return false;
					   }
							//alert(hours);
						if(hours >= 16)
						{
							alert("you can not add more than 16 hours.");
							return false;
						}
				   }
				   if(shifttype==2){
						sht='Two Days';
						
						if(ti == to)
						{
						    alert("Time In and Time Out can not be same for the shift");   
						  return false;
					    }
						if (frm < to1){
						alert("Time Out can not be greater than Time In for Multiple day shift.");   
						  return false;
					   }
					  	//alert(hours);
						if(hours >= 16)
						{
					alert("You have to add the shift of less than 16 Hours, Eg.15:59 hr");
							return false;
						}
				   }				 
				  var weekOne=$("input[name='weekOne1']:checked").val();
				  var weekTwo=$("input[name='weekTwo1']:checked").val();
				  var weekThree=$("input[name='weekThree1']:checked").val();
				  var weekFour=$("input[name='weekFour1']:checked").val();
				  var weekFive=$("input[name='weekFive1']:checked").val();
				  var sunday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				   weekOne=$("input[name='weekOne2']:checked").val();
				   weekTwo=$("input[name='weekTwo2']:checked").val();
				   weekThree=$("input[name='weekThree2']:checked").val();
				   weekFour=$("input[name='weekFour2']:checked").val();
				   weekFive=$("input[name='weekFive2']:checked").val();
				  var monday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				   weekOne=$("input[name='weekOne3']:checked").val();
				   weekTwo=$("input[name='weekTwo3']:checked").val();
				   weekThree=$("input[name='weekThree3']:checked").val();
				   weekFour=$("input[name='weekFour3']:checked").val();
				   weekFive=$("input[name='weekFive3']:checked").val();
				  var tuesday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				   weekOne=$("input[name='weekOne4']:checked").val();
				   weekTwo=$("input[name='weekTwo4']:checked").val();
				   weekThree=$("input[name='weekThree4']:checked").val();
				   weekFour=$("input[name='weekFour4']:checked").val();
				   weekFive=$("input[name='weekFive4']:checked").val();
				  var wednesday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				   weekOne=$("input[name='weekOne5']:checked").val();
				   weekTwo=$("input[name='weekTwo5']:checked").val();
				   weekThree=$("input[name='weekThree5']:checked").val();
				   weekFour=$("input[name='weekFour5']:checked").val();
				   weekFive=$("input[name='weekFive5']:checked").val();
				  var thusday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				   weekOne=$("input[name='weekOne6']:checked").val();
				   weekTwo=$("input[name='weekTwo6']:checked").val();
				   weekThree=$("input[name='weekThree6']:checked").val();
				   weekFour=$("input[name='weekFour6']:checked").val();
				   weekFive=$("input[name='weekFive6']:checked").val();
				  var friday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				   weekOne=$("input[name='weekOne7']:checked").val();
				   weekTwo=$("input[name='weekTwo7']:checked").val();
				   weekThree=$("input[name='weekThree7']:checked").val();
				   weekFour=$("input[name='weekFour7']:checked").val();
				   weekFive=$("input[name='weekFive7']:checked").val();
				  var saturday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				  
				   $.ajax({url: "<?php echo URL;?>admin/editShift",
				   
						data: {"sid":sid,"sna":sna,"ti":ti,"to":to,"tib":tib,"tob":tob,"tig":tig,"tog":tog,"bog":bog,"big":big,"sts":sts,"shifttype":shifttype,"sun":sunday,"mon":monday,"tue":tuesday,"wed":wednesday,"thus":thusday,"fri":friday,"sat":saturday},
						
						success: function(result){

						// alert(result);	
							if(result==1)
							{
								doNotify('top','center',2,'Shift Updated Successfully.');
								 setTimeout(function(){
								  window.location.replace("<?php echo URL;?>admin/shifts");
								 }, 2000);
							}else if(result==2){
								doNotify('top','center',4,"Shift "+sna+" already exist. ");
							}
							else if(result==3)
							{
								doNotify('top','center',4,"Shift "+sna+" already assign by employee");
							}
							else
							{
								doNotify('top','center',3,"No changes Found.");
								document.getElementById('shifrFrom').reset();
								$('#addShiftE').modal('hide');
							}
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			}); 
			
		});
			
			
		
	</script>
<script>
		function weekfetch(){
			 $.ajax({url: "<?php echo URL;?>admin/weekfetch/<?= $sid; ?>",
			success: function(result){
				//alert(result.data[]['day']);
			var result1=JSON.parse(result);
			//console.log(result1.data.length);
                             var i = 0;
                            for(i=0; i< result1.data.length; i++){
                                //console.log( result1.data[i].day) ;
							if(result1.data[i].day==1){
							var weekday =  result1.data[i].week.split(",");
							//var weekday = explode(',', result1.data[i].week);
									//console.log(weekday);
									var j=0;
									 for(j=0; j<weekday.length; j++){
										 if(j==0){
										$("input[name=weekOne1][value=" + weekday[j] + "]").attr('checked', 'checked');
										 }
										 else if(j==1){
											$("input[name=weekTwo1][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==2){
											$("input[name=weekThree1][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==3){
											$("input[name=weekFour1][value=" +weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==4){
											$("input[name=weekFive1][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
									}
								}
							else if(result1.data[i].day==2){
							var weekday =  result1.data[i].week.split(",");
							//var weekday = explode(',', result1.data[i].week);
									//console.log(weekday);
									var j=0;
									 for(j=0; j<weekday.length; j++){
										 
										if(j==0){
										$("input[name=weekOne2][value=" + weekday[j] + "]").attr('checked', 'checked');
										 }
										 else if(j==1){
											$("input[name=weekTwo2][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==2){
											$("input[name=weekThree2][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==3){
											$("input[name=weekFour2][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==4){
											$("input[name=weekFive2][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
									}
								}
								
								
									else if(result1.data[i].day==3){
							var weekday =  result1.data[i].week.split(",");
							//var weekday = explode(',', result1.data[i].week);
									//console.log(weekday);
									var j=0;
									 for(j=0; j<weekday.length; j++){
										 
										if(j==0){
										$("input[name=weekOne3][value=" + weekday[j] + "]").attr('checked', 'checked');
										 }
										 else if(j==1){
											$("input[name=weekTwo3][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==2){
											$("input[name=weekThree3][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==3){
											$("input[name=weekFour3][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==4){
											$("input[name=weekFive3][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
									}
								}
								
									else if(result1.data[i].day==5){
							var weekday =  result1.data[i].week.split(",");
							//var weekday = explode(',', result1.data[i].week);
									//console.log(weekday);
									var j=0;
									 for(j=0; j<weekday.length; j++){
										 
										if(j==0){
										$("input[name=weekOne5][value=" + weekday[j] + "]").attr('checked', 'checked');
										 }
										 else if(j==1){
											$("input[name=weekTwo5][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==2){
											$("input[name=weekThree5][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==3){
											$("input[name=weekFour5][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==4){
											$("input[name=weekFive5][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
									}
								}
									else if(result1.data[i].day==4){
							var weekday =  result1.data[i].week.split(",");
							//var weekday = explode(',', result1.data[i].week);
									//console.log(weekday);
									var j=0;
									 for(j=0; j<weekday.length; j++){
										 
										if(j==0){
										$("input[name=weekOne4][value=" + weekday[j] + "]").attr('checked', 'checked');
										 }
										 else if(j==1){
											$("input[name=weekTwo4][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==2){
											$("input[name=weekThree4][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==3){
											$("input[name=weekFour4][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==4){
											$("input[name=weekFive4][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
									}
								}
									else if(result1.data[i].day==6){
							var weekday =  result1.data[i].week.split(",");
							//var weekday = explode(',', result1.data[i].week);
									//console.log(weekday);
									var j=0;
									 for(j=0; j<weekday.length; j++){
										 
										if(j==0){
										$("input[name=weekOne6][value=" + weekday[j] + "]").attr('checked', 'checked');
										 }
										 else if(j==1){
											$("input[name=weekTwo6][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==2){
											$("input[name=weekThree6][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==3){
											$("input[name=weekFour6][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==4){
											$("input[name=weekFive6][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
									}
								}
									else if(result1.data[i].day==7){
							var weekday =  result1.data[i].week.split(",");
							//var weekday = explode(',', result1.data[i].week);
									//console.log(weekday);
									var j=0;
									 for(j=0; j<weekday.length; j++){
										 
										if(j==0){
										$("input[name=weekOne7][value=" + weekday[j] + "]").attr('checked', 'checked');
										 }
										 else if(j==1){
											$("input[name=weekTwo7][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==2){
											$("input[name=weekThree7][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==3){
											$("input[name=weekFour7][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==4){
											$("input[name=weekFive7][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
									}
								}

							}  
						}
			
                             
			  }); 
			 
			//alert("hello");
			
			}
	</script>
	
</html>
