<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>ubiAttendance</title>
	<link href="<?=URL?>../assets/timepicker/bootstrap-timepicker.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" />
    <style>
      
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
      .t2{display:none;}
    </style>
  </head>
  <body ng-app="attapp" ng-controller ="attctrl" >
    <div class="wrapper" ng-init="onfetchattendance();" >
      <?php
        $data['pageid']=3;
        $this->load->view('menubar/sidebar',$data);
        ?>
      <div class="main-panel">
        <?php
          $this->load->view('menubar/navbar');
          ?>
        <div class="content" id="content" style="" >
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header" data-background-color="green" >
                  <!--  <h4 class="title">Attendance</h4> -->
                    <p class="category" style="color:#ffffff;font-size:17px;" > List Of Absent Employees </p>
                  </div>
                  <div class="card-content">
                    <div id="typography">
                      <div class="title">
                       <div class=" container-fluid row" style="margin-top:0px;" >
                          <div class="col-sm-3" >
                            <div id="reportrange" class="" style="background: #fff; cursor: pointer; padding: 6px; 10px; border: 1px solid #acadaf; width: 104%;margin-left:-12px;">
                              <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                              <span></span> <b class="caret"></b>
                            </div>
                          </div>
						  
						  <div class="col-sm-2">
						  <div class="row" >
						  <select id="desg" style="height:35px;position:relative;" class="col-sm-11">
							<option value="0">--All Designations--</option>
								<?php
								$data= json_decode(getAllDesg($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++){
									echo '<option  value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								}?>
							</select>
							 </div>
							</div>
							
                            <div class="col-sm-2" >	
                            <div class="row" >							
							<select id="deprt" name="deprt" style=" height:35px;position:relative;" class="col-sm-11">
						    <option value="0">--All Departments--</option>
								<?php
								$data= json_decode(getAllDept($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++)
								echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								?>
							  </select>		 
							  </div>
							  </div>
							  <div class="col-sm-2" >
							  <div class="row" >
                              <select id="shift" name="shift" style=" height:35px;position:relative;" class="col-sm-11">
							   <option value="0">--All Shifts--</option>
								<?php
								$data= json_decode(getAllShift($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++)
									echo '<option  value='.$data[$i]->id.'>'.$data[$i]->name.'  ('.substr(($data[$i]->TimeIn),0,5).' - '.substr(($data[$i]->
								TimeOut),0,5).')</option>';
								?></select>
								</div>
								</div>
								
								<div class="col-sm-2">
								<div class="row">
								<select id="empl" style="height:35px;position:relative;" class="col-sm-12">
							   <option value="0">--All Employees--</option>
								<?php
								$data= json_decode(getAllemp($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++){
									echo '<option  value='.$data[$i]->id.'>'.$data[$i]->FirstName.'  '.$data[$i]->LastName.'</option>';
								}?>
							    </select>
								 </div>
								</div>
								 <div class="col-sm-1">
								 <button class="btn btn-success pull-left" style="position:relative; right:10px;margin-top:0px;height:35px;padding-top:8px;" id="getAtt" ><i class="fa fa-search"></i></button>
						    </div>
                        </div>
                     
						<br>
						
                        <div class="row" style="overflow-x:scroll;">
                         <!----  Data start  here--->
						 <hr>
						
						 <div class="row" >
								<div class="col-sm-1"></div>
								
								<div class="col-sm-4">
									<label class=""><b>Employee Name</b></label>
								</div>
								
								<div class="col-sm-1 bootstrap-timepicker">
									<label class=""><b>Time in</b></label>
								</div>
								<div class="col-sm-1 bootstrap-timepicker">
									<label class="" style="margin-left:-10px;"><b>Time out</b></label>
								</div>
								<div class="col-sm-1"><label class="" style="margin-left: -20px;"><b>TotalTime</b></label></div>
								<div class="col-sm-1"><label class="" style="margin-left: -20px;"><b>OverTime</b></label></div>
								<div class="col-sm-2">
									<label class="" style="margin-left: 15px;"><b>Status</b></label>
								</div>
								<div class="col-sm-1">
									<label class=""><b>Action</b></label>
								</div>
								<hr>
						</div>
		 <div style="display:block;height:387px;overflow-y:auto;overflow-x:hidden">
				<div class="row" ng-repeat="w in attendancearray"  >
								<div class="col-sm-1" style="margin-top:35px;" ><label class=" pull-right" style="font-weight:normal">{{$index+1}}</label></div>
								
								<div class="col-sm-4" style="margin-top:35px;" >
									<label class=" text-left" style="font-weight:normal" ng-bind="w.empname"></label>
								</div>	
								
								<div class="col-sm-1 bootstrap-timepicker">
									<input type="text" class="form-control timepicker" placeholder="Time In"  ng-model="w.timein" style="cursor:pointer" readonly ng-change="checkovertime($index)" />
								</div>
								
								<div class="col-sm-1 bootstrap-timepicker"  >
									<input type="text" class="form-control timepicker" placeholder="Time Out" ng-model="w.timeout" style="cursor:pointer" readonly ng-change="checkovertime($index)" />
								</div>
								
								<div class="col-sm-1" style="margin-top:35px;" >
									<label class="" style="font-weight:normal" ng-bind="w.totaltime"></label>
								</div>
								
								<div class="col-sm-1" style="margin-top:35px;" >
									<label class="" style="font-weight:normal" ng-bind="w.overtime"></label>
								</div>
								
								<div class="col-sm-2 text-center">
									<select class="form-control"  ng-model="w.sts" >
										<option value='1' >Present</option>
										<option value='2' >Absent</option>
										<option value='3' >WeeklyOff</option>
										<option value='5' >Holiday</option>
									</select>
								</div>
								
							  <div class="col-sm-1">
								<button class="btn bg-red" ng-show="" data-toggle="tooltip" title="Remove" ng-click="removework($index)"><i class="fa fa-minus" ></i></button>
							  </div>
					</div>
			      </div>
						 
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3 t2" id="sidebar" style=" margin-top:50px;"></div>
        <footer class="footer">
          <div class="" style="position:relative; margin-bottom:0px;" >
            <nav class="pull-left">
            </nav>
            <p class="copyright pull-right" style="padding-right:35px;" >
              &copy; <script>document.write(new Date().getFullYear())</script>. Developed by<a href="http://www.ubitechsolutions.com/" target="_blank" > Ubitech Solutions </a>
            </p>
          </div>
        </footer>
      </div>
    </div>
   

  </body>
 
  <script src="<?=URL?>../assets/js/buttons.colVis.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/moment.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/daterangepicker.js"></script>
  
 
  <script type="text/javascript" src="<?=URL?>../assets/js/angular.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/attendance.js"></script>
   <script src="<?=URL?>../assets/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
  <script type="text/javascript" >
     $('.timepicker').timepicker();
	
   </script>
   
  <script type="text/javascript">
  
   //$('input.timepicker').timepicker();
   
    $(document).ready(function() {
      // $('.timepicker').timepicker();
    ////---------date picker -------------------////
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
	});
   
  </script>
 
</html>