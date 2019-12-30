

<html lang="en">
<head>
	<meta charset="utf-8" />
	<?php
		$this->load->view('menubar/loadcss');			
		$this->load->view('menubar/loadjs');
		?>
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	  <link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/datepicker.css" />
	
	<script src="<?=URL?>../assets/js/jquery-3.1.0.min.js"></script>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/bootstrap-select/css/bootstrap-select.css" />

	<title>Employee Register Report</title>
	
	<style>
		.red
		{
			color:red;
			font-weight:'bold';
			font-size:16px;
		}
		
		.bargraph{
		display:inline-block;
		margin-top:-8px;
		margin-left:-17px;
	  }
		div.dt-buttons{
		position:relative;
		float:left;
		margin-left:15px;
	}
	 tbody td:not(:nth-child(1)){
        
		text-align:center;
    		
	}
	
	.sticky {
  position: fixed;
  top: 0;
  width: 100%;
}

.sticky + .content {
  padding-top: 102px;
}
	.t2{display:none;}
	

/* table scrolling */	
	
/*	
	.scrolling table
	{
     table-layout: inherit;
   }
.scrolling td, th {
    vertical-align: top;
	padding-bottom: 5px;
	min-width: 65px;
	height:53px;
}
.scrolling .name {
	position: absolute;
	left: 0;
	width: 150px;
}
	
.outer {
	position: relative
}
.inner {
	overflow-x: auto;
	overflow-y: visible;
	margin-left: 120px;
} */
.btn-primary
	{
		padding:10px 20px !important;
	}
	.btn-success{
   // padding: 10px 20px !important; 
    background-color: #ff9800 !important;
    color: #fff !important;
    font-size: 13px !important;
    border-radius: 2px !important;
    border-top-left-radius: 5px !important;
    border-top-right-radius: 5px !important;
    border-bottom-right-radius: 5px !important;
    border-bottom-left-radius: 5px !important;
    text-decoration: none !important;
    text-decoration-line: none !important;
    text-decoration-style: initial !important;
    text-decoration-color: initial !important;
	text:bold;
	}
	</style>
	
</head>   <!------ng-init="fetchtablemonthlydata();"------>
<body style="overflow:none" ng-app = "adminapp1"  ng-controller="attroasterCtrl1" ng-init="filtermonthlysummary1(<?php echo $empid ?>);byDefault=1"  >
	<div class="wrapper"   >  <!--- ng-init="fetchtablemonthlydata();--->
	  <br>
	  <br>
	  <br>
	  <div class="col-sm-8" > 
			<div class="col-sm-2">
				<input type="radio" value="1" name="byDefault" ng-model="byDefault"   style="cursor: pointer;"><label>&nbsp;&nbsp;By Default</label>
			</div>
			<div class="col-sm-2">
				<input type="radio" value="0" name="byDefault"  ng-model="byDefault" style="cursor: pointer;"><label>&nbsp;&nbsp;All Data</label>
			</div>
			</div>
			<br/>
			<br/>
		
		<div ng-show="byDefault==0">
	    <div class="row" >
		  <div class="col-md-12 col-sm-12" style="margin-bottom:50px;" >
		   <div class="col-md-1 col-sm-1" > </div>
				<!--<div class="col-md-3 col-sm-3"><h4>Generate Excel 20 Employee</h4> </div>-->
		  </div>
		   <div class="row" style="margin-bottom:50px;" >
               <div class="col-md-1 col-sm-1" ></div>
					<div class="col-md-3 col-sm-3" style="padding-left:35px;" >
						<div style="height:35px;width:210px;border :1px solid #acadaf; position:relative; margin-left:10px;margin-top:0px;" >
						<input id="revenuedate1" class="datepicker"   style="background: #fff; border: 0px solid #acadaf;border-redius:0px !important; height:33px;width:205px;" type="Text" value="<?php echo date('F-Y'); ?>" data-date-autoclose="true" />   </div>
					</div>
				<!--
				 <div class="col-sm-2">
							    <div class="row">
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
				
				<div class="col-sm-2">
								 <div class="row">
								<select id="deprt" style=" height:35px;position:relative;" class="col-sm-11">
							    <option value="0">--All Departments--</option>
								<?php
								$data= json_decode(getAllDept($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++)
									echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								?>
							     </select> 
								 </div>
				</div>  -->
			 <!--	
				<div class="col-sm-2">
								<div class="row">
                                 <select id="shift" style=" height:35px;position:relative;" class="col-sm-11">
							     <option value="0">--All Shifts--</option>
								<?php
								$data= json_decode(getAllShift($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++)
								echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.' ('.substr(($data[$i]->TimeIn),0,5).' - '.substr(($data[$i]->
								TimeOut),0,5).')</option>';
								?></select>
								 </div>
			   </div> -->
					   <div class="col-sm-2">
							<div class="row">
							<select id="userlimit" style=" height:35px;position:relative;" class="col-sm-11">
								<?php 
									$data= count(json_decode(getAllemp($_SESSION['orgid'])));
									$tempvar = $data%20;
									$tempvar1 = ceil($data/20);
									$k = 0;
									for($i=0;$i<$tempvar1;$i++)
									{
									//echo '<option  value='.$k.'>'. $k+1 .'- to -'. $k+20 . '</option>';
									if($i == ($tempvar1-1))
									  echo "<option  value='".$k."'>". ($k+1) .'-to-'.($k+$tempvar ). "</option>";
								   else
									  echo "<option  value='".$k."'>". ($k+1) .'-to-'.($k+20). "</option>";  
									$k = $k+20;
									}
									
				
								?>
								</select>
								<small>User Limits(order by name)</small>
							</div>
					   </div>
					   <div class="col-sm-1">
							<div class="row">
							  <label></label>
							</div>
					   </div>
			  
				  <div class="col-sm-2 " style="margin-top:-6px;" >
						  <button id="generate_csv" class="btn btn-default">Excel</button>
				  </div>
		   </div>
		   
		 <div class="col-md-12 col-sm-12" style="height:1px; width:100%;border:1px solid gray;margin-bottom:30px;" >
		  </div>
	</div>
	</div>
	<br/>
		<div ng-show="byDefault==1">
		<div class="row">		
		 <div class="col-md-12 col-sm-12" >
				<div class="col-sm-3 col-sm-3">
					<h4>Generate Excel 20 Employee</h4> 
				</div>
		  </div>
		 <div class="row" style="position:relative;overflow:none;">
		   <div class="col-md-1 col-sm-1" ></div>
		        <div class="col-md-3 col-sm-3" style="padding-left:35px;margin-top:12px" >
					<div style="height:35px;width:215px;border :1px solid #acadaf;position:relative; margin-left:-10px;">
						<input id="revenuedate" class="datepicker"   style="background: #fff; border: 0px solid #acadaf;border-radius:0px !important; height:33px;width:210px;" type="Text" value="<?php echo date('F-Y'); ?>" data-date-autoclose="true" />
					</div>
				</div>
				
				<div class="col-sm-2">			
							   <div class="row">			
							   <select id="empl" style="height:35px;position:relative;" class="col-sm-11 selectpicker" multiple data-hide-disabled="true" data-live-search="true" data-actions-box="true" data-size="5"  ng-model="employee">
								<?php 
								$data= json_decode(getAllemp($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++){
									echo '<option  value='.$data[$i]->id.'>'.$data[$i]->FirstName.'  '.$data[$i]->LastName.'</option>';
								}?>
							    </select>
							  </div>
				</div>
				<!--margin-top:0;style="margin-top:-6px;"-->
				<div class="col-sm-1">
					   <button class="btn btn-warning" style="height:40px;" id="getAtt" ng-click="filtermonthlysummary()" ><i class="fa fa-search"></i>
						</button>
				</div>
				<div class="col-sm-2 ">
				      <a download="Monthlyreport.xls" href="#" onclick="return ExcellentExport.excel(this,'example','Monthly Report');" class="btn btn-default no-print" >Excel</a>
				</div>
				
				
		 </div>
		 <div class="row">
		   <div class = "col-sm-12" style="margin-left:30px;margin-right:30px;overflow-x:auto" >
		        		<!----Start repeat----->
		<br />			
				
    <table border="0" id="example">
		 <tr>
		  <td>
		<table ng-repeat="a in filteredItems | filter:searchText" >
		   
			<tbody>
			 <tr>
		       <td>
					<table border="0">
					 <tr>	
						 <td colspan="30" >
						  <b>Employee:</b>&nbsp;&nbsp;&nbsp;{{a.empcode}}:&nbsp;{{a.name}}&nbsp;
						  <b>Department:</b>&nbsp;&nbsp;&nbsp;{{a.department}}
						  <br/><br/>
						</td>
					</tr>
					</table>
			   </td>
			</tr>	
		</tbody>
			<!--<img ng-src="{{a.entryimg}}" style="width:60px!important;" class="pull-right"/>---->
		<tbody>	
		<tr>
		       <td>
		<table class="table table-striped table-hover" >
			<tr>
              <th class="name" style="padding-top:5px;padding-left:20px;">Days</th>
              <th  ng-repeat="b in dates ">{{b}}</th>
            </tr>
			<tr>
              <th class="name" style="padding-top:10px;padding-left:20px;">Status</th>
			 <td ng-repeat="x in  a.sts track by $index">
			 {{x}}
			 </td>
            </tr>
			<!--<tr>
				<th class="name" style="padding-top:10px;padding-left:20px;">Shift</th>
				<td ng-repeat="as in a.attshift track by $index">{{as}}
				</td>
            </tr>-->
			<tr>
				<th class="name" style="padding-top:10px;padding-left:20px;">Time In</th>
				<td ng-repeat="ti in a.timein track by $index">{{ti}}
				</td>
            </tr>
			<tr>
              <th class="name" style="padding-top:10px;padding-left:20px;">Time Out</th>
				  <td ng-repeat="to in  a.timeout track by $index">{{to}}
					</td>
            </tr>
			<tr>
				<th class="name" style="padding-top:10px;padding-left:20px;">Late by</th>
				  <td ng-repeat="l in  a.latecome track by $index">{{l}}
				</td>
            </tr>
			<tr>
				<th class="name" style="padding-top:10px;padding-left:20px;">Left Early by</th>
				  <td ng-repeat="e in  a.earlyleave track by $index">{{e}}
				</td>
            </tr>
			
			<tr>
              <th class="name" style="padding-top:10px;padding-left:20px;">Overtime</th>
				  <td ng-repeat="ov in  a.overtime track by $index">{{ov}}
				  </td>
            <tr>
              <th class="name" style="padding-top:10px;padding-left:20px;">Undertime</th>
				  <td ng-repeat="u in  a.undertimee track by $index">{{u}}
				  </td>
            </tr>
			<tr>
              <th class="name" style="padding-top:10px;padding-left:20px;">Logged Hours</th>
				  <td ng-repeat="o in  a.officehours track by $index">{{o}}
				  </td>
            </tr>
        </table>
			 </td>
		</tr>	
		</tbody>
			<tbody>	
		    <tr>
		      <td>	
	            <table border="0" >
			 <tr>	
				 <td colspan="30" >
			<!--<b>Total Logged Hours/Total Shift Hours</b>:&nbsp;&nbsp;{{a.totaldurations}}/{{a.shifthours}}-->&nbsp;&nbsp;
			<b>Present</b>:&nbsp;{{a.present}}&nbsp;&nbsp;
			<b>Absent</b>:&nbsp;{{a.absent}}&nbsp;&nbsp;
			<b>Weekoff</b>:&nbsp;{{a.weekoff}}&nbsp;&nbsp;
			<b>Holidays</b>:&nbsp;{{a.holyday}}&nbsp;&nbsp;
			<!--<b>Leave</b>:&nbsp;{{a.leave}}-->
		      </td>
		    </tr>
		</table>		 
		   </td>
			</tr>
				</tbody>
			
			  <tbody>	
				<tr>
					<td colspan="30" >
						<div>
							 <br />
							 <br />
						</div>
					</td>
				</tr>
			</tbody>
		</table>
			   
		   </td>
		 </tr>
	</table>
		<!----close repeat------>
	</div>	
		   </div>
		   </div>
		 </div>
	    
	</div>

</body>
	
	
	<script type="text/javascript" src="<?=URL?>../assets/js/moment.js"></script>
	<script type="text/javascript" src="<?=URL?>../assets/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="<?=URL?>../assets/js/bootstrap-datetimepicker.js"></script>
	

	<script type="text/javascript" src="<?=URL?>../assets/js/jszip.min.js"></script>
	<script type="text/javascript" src="<?=URL?>../assets/js/vfs_fonts.js"></script>
	
	<script type="text/javascript" src="<?=URL?>../assets/js/angular.min.js"></script>
	<script src='<?php echo URL;?>../assets/js/excellentexport.js'></script>
	<script src='<?php echo URL;?>../assets/js/bootstrap-notify.js'></script>
	<script type="text/javascript" src="<?=URL?>../assets/bootstrap-select/js/bootstrap-select.js"></script>
	<script type="text/javascript">
	
	
	</script>
	<script>
       $(".datepicker").datepicker({
		startView: "months", 
		minViewMode: "months",
		format: "MM-yyyy",
		startDate:"-2m",
		endDate:"+0m",
		
		});
    </script>
	<script>
	
if (typeof jQuery === "undefined") {
  throw new Error("UBICRM requires jQuery");
}
//'ui.bootstrap', 'xeditable', 'ngSanitize'

var app = angular.module('adminapp1', []);


app.controller('attroasterCtrl1', function($scope, $http, $timeout) {
 $scope.hastrue=false;
 $scope.name='sohan patel';
 $scope.records = [];
 $scope.arrdate = [];
 $scope.dates=[];
 $scope.path= "<?php echo URL; ?>";

  
 
  $scope.filtermonthlysummary = function()
       {
			var len=$('#empl').val().length;
				    if(len>20)
					{	
					doNotify('top','center',3,'Select  atmost 20 employees');
					return false;
					}
	         $scope.hastrue=true;
	         $scope.arrdate = [];
			 $scope.records = [];
			 $scope.dates=[];
			var empl=$('#empl').val();
			
			// var empl=$scope.employee;
			 
			 //alert(empl);
			 if(empl==0)
			 empl=$empid;
				
			//var deprt=$('#deprt').val();
			//var shift=$('#shift').val();
			
			$scope.hastrue=true;
					
			var date=$('#revenuedate').val();
		    var xsrf = $.param({empl:empl,date:date});
				
		$http({
			url:  $scope.path+'Admin/getattRoastermonthly__new',
			method: "POST",
			data:xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			console.log(data);
			$scope.dates = data.date;
			
			var n = data.count;
			var obj = data.data;
		   $scope.arrdate = obj;
		   $scope.filteredItems = obj;
			$scope.hastrue=false;
		}).error(function (data,status,headers, config) {
			$scope.hastrue=false;
		});
 }
 
 $scope.filtermonthlysummary1 = function($empid)
       {
	         $scope.hastrue=true;
	         $scope.arrdate = [];
			 $scope.records = [];
			 $scope.dates=[];
			 var empl=$('#empl').val();
			// var empl=$scope.employee;
			/* $('select[name=setvalue]').val(empl);*/
			 //alert(empl);
			 if(empl==0)
			 empl=$empid;
			//var deprt=$('#deprt').val();
			//var shift=$('#shift').val();
			
			$scope.hastrue=true;
			var date=$('#revenuedate').val();
		    var xsrf = $.param({empl:empl,date:date});
				
		$http({
			url:  $scope.path+'Admin/getattRoastermonthly__new1',
			method: "POST",
			data:xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			console.log(data);
			
			$scope.dates = data.date;
			
			var n = data.count;
			var obj = data.data;
		   $scope.arrdate = obj;
		   $scope.filteredItems = obj;
		   $("#empl").selectpicker("val",empl);	
			$scope.hastrue=false;
		}).error(function (data,status,headers, config) {
			$scope.hastrue=false;
		});
 }
 
});
  $("#generate_csv").click(function(){
	     /*   var deprt=$('#deprt').val();
			var shift=$('#shift').val();
			var designation=$('#desg').val();*/
			var date=$('#revenuedate1').val();
			var userlimit = $('#userlimit').val();
			
			
	   //window.location.href = "<?php echo URL; ?>admin/allempcsv?date="+date+"&shift="+shift+"&deprt="+deprt+"&designation="+designation;
	   
	   window.location.href = "<?php echo URL; ?>admin/allempcsv?date="+date+"&userlimit="+userlimit;
  });
	
	</script>
	<script>
	$(function(){
	$(".bs-select-all").hide();
	$(".bs-deselect-all").hide();
	});
	</script>
	<script>
	/*$('.selectpicker').selectpicker('val', 4902);*/
	</script>
	
</html>
