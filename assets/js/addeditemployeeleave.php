<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>UBIHRM | Employee Leave</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="<?php echo URL;?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="<?php echo URL;?>public/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo URL;?>public/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
	<!-- Bootstrap Color Picker -->
    <link href="<?php echo URL;?>public/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo URL;?>public/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
	<?php include(VIEWS_PATH."_templates/sidebar.php");?>
	
 <!-- Ionicons -------->
<!-- iCheck -->
    <link href="<?php echo URL; ?>public/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="skin-green"  ng-app="leaveapi"  ng-controller="employeeleaveCtrl">
    <!-- Site wrapper -->
    <div class="wrapper" ng-init="employeeleaveid=<?= $this->employeeleaveid ?>;onfetchemployeeleave();">
      <header>
		<?php echo topmenu(3);?>
	  </header>

      <!-- =============================================== -->

      <!-- Left side column. contains the sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <?php echo sidemenu(3.11,3);?>
        <!-- /.sidebar -->
      </aside>

      <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Leave
            <!-----<small>it all starts here</small>------->
          </h1>
          <ol class="breadcrumb">
            <!-------<li><a href="#"><i class="fa fa-home"></i> Home</a></li>---->
            <li class="active"><a href="<?php echo URL;?>leave"><i class="fa fa-user"></i>Leave</a></li>
            <li class="active"><span ng-show="!employeeleaveid">Add</span><span ng-show="employeeleaveid">Edit</span> </li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content" >

          <!-- Default box -->
          <div class="box box-solid box-success">
			<div class="box-header with-border">
						  <h3 class="box-title"> Employee Leave </h3>
						  <div class="box-tools pull-right" ng-show="!val">
							<button class="btn btn-box-tool" data-widget="refresh" id="refresh_" data-toggle="tooltip" title="Refresh"><i class="fa fa-refresh"></i></button>
							<button class="btn btn-box-tool" data-toggle="tooltip" title="Help"><i class="fa fa-question"></i></button>
						  </div>
						  
						</div>
						<div class="box-body" ng-cloak  ng-init="val=<?= $this->val ?>">
             
							<form role="form" name="myForm" novalidate class="form-horizontal">
										<div class="row">
											<div class="form-group">
													
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label col-sm-4" for="employeeid">Employee &nbsp;&nbsp;</label>
													<div class="col-sm-6" ng-class="{ true: 'has-success', false : 'has-error'  }[myForm.employeeid.$valid]">
														<select class="form-control" id="employeeid" name="employeeid" ng-model="employeeid" ng-options="c.id as c.name for c in employeearray" required ng-disabled="val" ng-change="onfetchleavetype()">
														</select>					
													</div>
													<a data-toggle="modal" data-target="#selectbox" class="btn btn-primary btn-xs" ng-disabled="val" title="Search Employee"><i class="fa fa-search"></i></a>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-4" for="leavetype">Leave Type &nbsp;&nbsp;</label>
													<div class="col-sm-6" ng-class="{ true: 'has-success', false : 'has-error'  }[myForm.leavetype.$valid]">
														<select class="form-control" id="leavetype" name="leavetype" ng-model="leavetype" ng-options="c.id as c.name for c in leavetypearray" required ng-disabled="val">
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-4" for="fromdate"> From&nbsp;&nbsp;</label>
								                    <div class="col-sm-6" ng-class="{ true: 'has-success', false : 'has-error'  }[myForm.fromdate.$valid]">	
														<input  type="text" id="fromdate" ng-change="timediff(fromdate)" name="fromdate" ng-model="fromdate"  class="form-control" placeholder="Date From" data-provide="datepicker" data-date-autoclose="true" data-date-format="<?=$_SESSION['ubihrm_dateformate1']?>"  required ng-disabled="val">		
													</div>
												</div>
												<div class="form-group" >
													<label class="control-label col-sm-4" for="desc">&nbsp;&nbsp;</label>
													<div class="col-sm-6" >
													Full day&nbsp;&nbsp;<input type="radio" name="fromdaytype" value="1" ng-disabled="val" ng-checked='true' ng-change="timediff(fromdate)" ng-model="fromdaytype">&nbsp;&nbsp;
													Half day&nbsp;&nbsp;<input type="radio" name="fromdaytype" value="2" ng-change="timediff(fromdate)" ng-disabled="val" ng-model="fromdaytype">
													</div>
												</div>
												<div class="form-group" ng-show="fromdaytype==2">
													<label class="control-label col-sm-4" for="desc">&nbsp;&nbsp;</label>
													<div class="col-sm-6" >
													First Half&nbsp;&nbsp;<input type="radio" name="timeoffrom" value="1" ng-disabled="val" ng-checked='true' ng-model="timeoffrom">&nbsp;&nbsp;
													Second Half&nbsp;&nbsp;<input type="radio" name="timeoffrom" value="2" ng-disabled="val" ng-model="timeoffrom">
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-4" for="todate">To&nbsp;&nbsp;</label>
								                    <div class="col-sm-6"  ng-class="{ true: 'has-success', false : 'has-error'  }[myForm.todate.$valid]">	
														<input  type="text" id="todate" name="todate" ng-model="todate" class="form-control" placeholder="Date To" data-provide="datepicker" ng-change="timediff(todate)"  data-date-autoclose="true" data-date-format="<?=$_SESSION['ubihrm_dateformate1']?>" required ng-disabled="val">	
													</div>
												</div>
												
												<div class="form-group" >
													<label class="control-label col-sm-4" for="desc">&nbsp;&nbsp;</label>
													<div class="col-sm-6" >
													Full day&nbsp;&nbsp;<input type="radio" name="todaytype" ng-change="timediff(fromdate)" ng-model="todaytype" value="1" ng-disabled="val" ng-checked='true' >&nbsp;&nbsp;
													Half day&nbsp;&nbsp;<input type="radio" name="todaytype" ng-change="timediff(fromdate)" ng-model="todaytype" value="2" ng-disabled="val">
													</div>
												</div>
												<div class="form-group" ng-show="todaytype==2">
													<label class="control-label col-sm-4" for="desc">&nbsp;&nbsp;</label>
													<div class="col-sm-6" >
													First Half&nbsp;&nbsp;<input type="radio" name="timeofto" ng-model="timeofto" value="1" ng-disabled="val" ng-checked='true' >&nbsp;&nbsp;
													Second Half&nbsp;&nbsp;<input type="radio" name="timeofto" ng-model="timeofto" value="2" ng-disabled="val">
													</div>
												</div>
												
												
												<div class="form-group">
													<label class="control-label col-sm-4" for="days_elig">Leave Days&nbsp;&nbsp;</label>
													<div class="col-sm-4">
														<input type="text" class="form-control" readonly id="days_elig" placeholder="Leave Days" ng-model="dayseligible" ng-disabled="val">
													</div>
													<div class="col-sm-1">
														<button class="btn btn-danger btn-sm" data-toggle="modal" title="Leave Days" data-target="#myModal" ng-disabled="val"><i class="fa fa-calendar"></i></button>
													</div>	
												</div>
												<div class="form-group">
													<label class="control-label col-sm-4" for="documentfile">Attachment&nbsp;&nbsp;</label>
													<div class="col-sm-6"  >
														<input type="file" name="documentfile" class="form-control" id="documentfile" ng-disabled="val" ng-model="documentfile" file-upload accept=image/* />
													</div>
													<a ng-show="leaveat!=''" href="{{leaveat}}" title="sick leave attachment" target="_blank"><i class="fa fa-download fa-2x"></i></a>
												</div>
											</div>


											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label col-sm-4" for="applydate">Application Date&nbsp;&nbsp;</label>
													<div class="col-sm-6" ng-class="{ true: 'has-success', false : 'has-error'  }[myForm.applydate.$valid]">
														<input type="text" class="form-control" id="applydate" name="applydate" ng-model="applydate" placeholder="Apply Date" data-provide="datepicker" data-date-autoclose="true" data-date-format="<?=$_SESSION['ubihrm_dateformate1']?>" required ng-disabled="val  || !employeeid" ng-change="onfetchleavetype()">
													</div>
												</div>
												
												<div class="form-group">
													<label class="control-label col-sm-4" for="leavereason">Remarks&nbsp;&nbsp;</label>
													<div class="col-sm-6 " >
														<textarea rows="5" cols="30" id="leavereason" name="leavereason" ng-model="leavereason" class="form-control" placeholder="Give Reason for leave" ng-disabled="val"></textarea>
													</div><!-- /.input group -->
												</div>
												<div class="form-group">
													<label class="control-label col-sm-4" for="resumptiondate">Date of Resuming&nbsp;&nbsp;</label>
													<div class="col-sm-6" ng-class="{ true: 'has-success', false : 'has-error'  }[myForm.resumptiondate.$valid]">
														<input type="text" class="form-control" id="resumption" name="resumptiondate" ng-model="resumptiondate" placeholder="Date of Resuming" data-provide="datepicker" data-date-autoclose="true"   data-date-format="<?=$_SESSION['ubihrm_dateformate1']?>" required ng-disabled="val">
													</div>
												</div>
											<!--	<div class="form-group">
													<label class="control-label col-sm-4" for="leavestatus">Status&nbsp;&nbsp;</label>
								                    <div class="col-sm-6"  ng-class="{ true: 'has-success', false : 'has-error'  }[myForm.leavestatus.$valid]">	
														<select class="form-control" id="leavestatus" name="leavestatus" ng-model="leavestatus" ng-options="c.value as c.name for c in leavestsarray| filter:{type:'LeaveStatus'}" required ng-disabled="val">
														</select>
													</div>
												</div>-->
												<div class="form-group">
													<label class="control-label col-sm-4" for="contactdetail">Contact details&nbsp;&nbsp;</label>
													<div class="col-sm-6" >
														<input type="text" class="form-control" id="contactdetail" name="contactdetail" ng-model="contactdetail" placeholder="Contact details"  ng-disabled="val">
													</div>
												</div>
												<!--<div class="form-group">
													<label class="control-label col-sm-4" for="approvercomment">Approver Comment&nbsp;&nbsp;</label>
													<div class="col-sm-6 " >
														<textarea rows="4" cols="30" id="approvercomment" name="approvercomment" ng-model="approvercomment" class="form-control" placeholder="Comments" ng-disabled="val" ></textarea>
													</div>
												</div>-->
											</div>
										</div>
										<h4 ng-show="changests==1">Leave Utilized from </h4>
										<hr ng-show="changests==1">
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group" ng-show="changests==1">
													<label class="text-right col-sm-6" for="deptname">Entitled</label>
													
													<div class="col-sm-2">
														<input type='number' class="form-control" id="entitled" name="entitled" ng-model="entitled" >
													</div>
													
												</div>
												<div class="form-group" ng-show="changests==1" >
													<label class="text-right col-sm-6" for="deptname">Carried Forward</label>
																									
													<div class="col-sm-2">
														<input type='number' class="form-control" id="carryforward" name="carryforward" ng-model="carryforward" ng-keyup="onchangecarryforward()">
													</div>
													
												</div>
											</div>
										
											<div class="col-sm-6">
												<div class="form-group" ng-show="changests==1">
													<label class="text-right col-sm-4" for="deptname">Advance</label>
													
													<div class="col-sm-2">
														<input type='number' class="form-control" id="advance" name="advance" ng-model="advance" >
													</div>
													
												</div>
												<div class="form-group" ng-show="changests==1">
													<label class="text-right col-sm-4" for="deptname">Loss of pay</label>
													
													<div class="col-sm-2">
														<input type='number' class="form-control" id="unpaid" name="unpaid" ng-model="unpaid" >
													</div>
													
												</div>
											</div>
										</div>
									 </form>
								
            </div><!-- /.box-body -->
			<div class="overlay" ng-show="hastrue">
                  <i class="fa fa-refresh fa-spin"></i>
                </div>
			<div class="box-footer text-center">
					<a  class="btn btn-primary" href="<?php echo URL;?>employee"  align="right" ng-show="val"><b>Back</b></a>
					<button type="submit" class="btn btn-primary" ng-disabled="myForm.$invalid || dayseligible==0" ng-show="employeeleaveid=='0' && !val"  ng-click="oncreate(1)">Save</button>
					<button type="submit" class="btn btn-primary" ng-disabled="myForm.$invalid || dayseligible==0" ng-show="employeeleaveid=='0' && !val" ng-click="oncreate(0)">Save&nbsp;&amp;&nbsp;New</button>
					<button type="submit" class="btn btn-primary" ng-disabled="myForm.$invalid || dayseligible==0" ng-show="employeeleaveid!='0' && !val"  ng-click="onupdate(1)">Save</button>
					<button type="submit" class="btn btn-primary" ng-disabled="myForm.$invalid || dayseligible==0" ng-show="employeeleaveid!='0' && !val" ng-click="onupdate(0)">Save&nbsp;&amp;&nbsp;New</button>
					<a href="<?php echo URL;?>leave/leaveslist"><button type="button" class="btn btn-primary" ng-show="!val">Cancel</button></a>
            </div><!-- /.box-footer-->
          </div><!-- /.box -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <footer class="main-footer">
        <?php footertext();?>
      </footer>
	  <div class="example-modal" >
            <div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Leave Details</h4>
                  </div>
				 <div class="modal-body chat" id="chat-box">
                    	<div class="row">
							<div class="col-sm-12">
								<table class="table table-bordered">
									<tr>
									  <th style="width: 10px">#</th>
									  <th>Date</th>
									  <th>Status</th>									  
									</tr>
									<tr ng-repeat="r in empleavedetail">
									  <td>{{$index+1}}</td>
									  <td>{{r.date}}</td>
									  <td><span class="badge bg-green" ng-show="r.label=='Leave Full Day'">{{r.label}}</span>
									  <span class="badge bg-red" ng-show="r.label!='Leave Full Day'">{{r.label}}</span></td>
									</tr>
									<tr ng-show="empleavedetail.length==0">
									  <td colspan="3" align="center">No details</td>
									</tr>
								</table>
							</div>
						</div>
							
                  </div>
                <div class="modal-footer">
				<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
				</div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
          </div><!-- /.example-modal -->
	  <div class="modal fade" id="selectbox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">   
				<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Search Employee</h4>
					
                  </div>
				<div class="modal-body">
				<input type="text" class="form-control" ng-model="name" placeholder="Search employee">
					<select  class="form-control" id="modelselect" multiple style="height:200px" ng-model="employeeidmodel" ng-options="c.id as c.name for c in employeearray | filter:name"  ng-change="onfetchleavetype()" ng-disabled="val " data-dismiss="modal">
						
					</select>
					<br>
					<label class="text-green text-left">*Note-Select only one Employee.</label>
				</div>
				<div class="modal-footer">
					
					<button type="button" class="btn btn-info" data-dismiss="modal" >Close</button>
					
				</div>
			</div>
		</div>
	</div>	
    </div><!-- ./wrapper -->
	
    <!-- jQuery 2.1.3 -->
    <script src="<?php echo URL;?>public/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo URL;?>public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo URL;?>public/angularjs/angular.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="<?php echo URL;?>public/plugins/slimScroll/jquery.slimScroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src="<?php echo URL;?>public/plugins/fastclick/fastclick.min.js"></script>
	<!-- iCheck -->
    <script src="<?php echo URL; ?>public/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
	<script src="<?php echo URL;?>public/angularjs/leave.js" type="text/javascript"></script>
	<script src="<?php echo URL;?>public/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
  
	<script>
      $(function () {
		
        /*$('input[type="radio"]').iCheck({
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });*/
      });
	  $("button").click(function(){
		 $('#myModal').modal('hide');;
	  });
	   $('#chat-box').slimScroll({
		height: '300px'
	  });
	
    </script>
  </body>
</html>
