<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.css" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/dataTables.tableTools.css" />
	 <link href="<?=URL?>../assets/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css" /> 
	<link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<title>Hourly Pay</title>
	<style>
		.red{
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
	</style>
</head>
<body ng-app = "hourlyapp" ng-controller ="hourlyctrl" >
	<div class="wrapper">
		<?php
			$data['pageid']='7.14';
			$this->load->view('menubar/sidebar',$data);
		?>
	    <div class="main-panel">
			<?php
				$this->load->view('menubar/navbar');
			?>
			</br>
			  <section class="content" id="printsection">
			<div class="content">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-md-12">
	                        <div class="card">
	                            <div class="card-header" data-background-color="green">
	                                <p class="category" style="color:#ffffff;font-size:17px;" >Hourly Pay  </p>
	                               
								</div>
								<div class="card-content">
								
						
						<div class="col-sm-3 bargraph " style="padding-top:16px;" >
											<!------------------------------->
										
										<div id="reportrange" class="pull-left" style="background: #fff; cursor: pointer; padding: 6px; 10px; border: 1px solid #acadaf;margin-bottom:10px; width: 104%">
												<i class="glyphicon glyphicon-calendar fa  fa-calendar"></i>&nbsp;
												<span></span> <b class="caret"></b>
											</div>
						</div>
						
						
						      <select id="deprt" name="deprt" style=" width:145px;height:35px" class="">
							    <option value="0">----All Departments------</option>
								<?php
								$data= json_decode(getAllDept($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++)
								echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								?>
							     </select>
							   <select id="desg" style="width:145px;height:35px" class="">
							   <option value="0">----All Designations------</option>
								<?php
								$data= json_decode(getAllDesg($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++){
									echo '<option  value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								}?>
							    </select> 
						
						
										 
				
						
                              <select id="shift" name="shift" style=" width:140px;height:35px" class="">
							   <option value="0">----All Shifts------</option>
								<?php
								$data= json_decode(getAllShift($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++)
									echo '<option  value='.$data[$i]->id.'>'.$data[$i]->name.'  ('.substr(($data[$i]->TimeIn),0,5).' - '.substr(($data[$i]->
								TimeOut),0,5).')</option>';
								?></select>
					
												
								
								<select id="empl" style="width:140px;height:35px" class="">
							   <option value="0">----All Employees------</option>
								<?php
								$data= json_decode(getAllemp($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++){
									echo '<option  value='.$data[$i]->id.'>'.$data[$i]->FirstName.'  '.$data[$i]->LastName.'</option>';
								}?>
							    </select>
				
						
						
								 <button style="margin-top: 0px;" class="btn btn-success" id="getAtt" ng-click="filterratedata()" ><i class="fa fa-search" ></i></button>
					
							<!--	<a rel="tooltip" onclick="openNav()"  rel="tooltip"  data-placement="bottom" title="Help" class="btn btn-success btn-sm pull-right ">	-->
								 <div id="typography">
									<div class="title">
											
											
									</div>
									  <div class="row">
												<div class="col-md-4">
												  <button class="btn btn-success pull" id="cmd"  >PDF</button>
												</div>
											  
											</div>
										<div class="row container-fluid" style="overflow-x:scroll;" id="content1" >
										<!--<h3 class="text-center"> Employee  Overtime Report</h3>-->
										<div class="col-lg-12"  style="height:40px;border-radius:3px;background-color:#e6ffe6;">
										   <div class="col-lg-3" style="padding-top:4px;color:black" ><h4 class="title" >Name</h4></div>
										   <div class="col-lg-3" style="padding-top:4px;color:black" ><h5 class="title" >Worked hour</h5></div>
										   <div class="col-lg-3" style="padding-top:4px;color:black" ><h5 class="title" >Hourly Rate</h5></div>
										   <div class="col-lg-3" style="padding-top:4px;color:black" ><h5 class="title" >Amount</h5></div>
										 </div>	
										  <div class="col-lg-12" ng-repeat = "a in ratedata" >
										  <div class="col-lg-12"  style="height:30px;margin-top:10px;" ng-repeat = "b in a.info" >
										   <div class="col-lg-3" style="font-size:12px;"><h5 class="title"  >{{b.name}}</h5></div>
										   <div class="col-lg-3" ><h6 class="title">{{b.total_hour	}}</h6></div>
										   <div class="col-lg-3" ><h6 class="title">{{b.rate}}</h6></div>
										   <div class="col-lg-3" ><h6 class="title">{{b.total_amount}}</h6></div>
										   </div>
										  <div class="col-lg-12" style="height:30px;border-radius:3px;font-size:13px;background-color:#e6ffe6;" >
										   <div class="col-lg-6" style="padding-top:3px;" ><h5 class="title" style="color:red" >Payable Amount</h5></div>
										   <div class="col-lg-6" style="padding-top:3px;" ><div class="col-lg-8" ></div><div class="col-lg-4">
										   <h5 class="title pull-left " style="color:red" >{{a.total}}</h5></div>
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

	       </section>
			<footer class="footer">
				<div class="container-fluid">	
				</div>
			</footer>
			<footer class="footer">
				<div class="container-fluid">
					<nav class="pull-left">
						
					</nav>
					<!--<p class="copyright pull-right">
						&copy; <script>document.write(new Date().getFullYear())</script> <a href="#">DESIGNED BY</a> Ubitech Solutions Pvt. Ltd.
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

<!---modal close edit employee--->
<!-----delete employee start--->
<div id="delEmp" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Delete Employee</h4>
      </div>
      <div class="modal-body">		
		<form>
			<input type="hidden" id="del_id" />
			<div class="row">
				<div class="col-md-12">
					<h4><span id="na"></span> will no longer be available, Are you sure want to delete this Record ?</h4>
				</div>
			</div>
			<div class="clearfix"></div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="delete"  class="btn btn-warning">Delete</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-----delete employee close--->
</body>
    <div id="mySidenav" class="pull-right sidenav" style="background-image:url(<?=URL?>../assets/img/bg7.jpg);">
						<div class="helpHeader"><span ><b>&nbsp;&nbsp;<i style="font-size:24px; color:black;"class="fa fa-question-circle" ></i ></b></span><a style="color:black;" href="javascript:void(0)" class="closebtn text-right" onclick="closeNav()">x</a></div>
						<div id="sidenavData" class="sidenavData">
						</div>
					</div>
     
      <script type="text/javascript" src="<?=URL?>../assets/js/moment.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/daterangepicker.js"></script>
	  
	  <script type="text/javascript"  src="<?=URL?>../assets/js/table_pdf/jspdf.min.js"></script>
     
      <script type="text/javascript" src="<?=URL?>../assets/js/jszip.min.js"></script>
	  
      <script type="text/javascript" src="<?=URL?>../assets/js/pdfmake.min.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/html2canvas.min.js"></script>
	  
	  <script type="text/javascript" src="<?=URL?>../assets/js/angular.min.js"></script>
	  
      <script type="text/javascript" src="<?=URL?>../assets/js/hourlypay.js"></script>
	 
	<script>
	function openNav() {
							document.getElementById("mySidenav").style.width = "400PX";
							$('#sidenavData').load('<?=URL?>help/helpNav');	
						}
						function closeNav() {
							document.getElementById("mySidenav").style.width = "0";
						}
	
	</script>

	<script type="text/javascript">
	////---------date picker
    //	var start = moment().subtract(29, 'days');
    var minDate = moment();
    var start = moment().subtract(7, 'days');
    var end = moment();
    function cb(start, end) {
    $('#reportrange span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
    }
    $('#reportrange').daterangepicker({
    maxDate:minDate,
	minDate:'-4M',
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
    	var doc = new jsPDF();
var specialElementHandlers = {
    '#editor': function (element, renderer) {
        return true;
    }
};

 var form = $("#content1"),
	cache_width = form.width(),
	a3  =[ 841.89, 1190.55];  // for a4 size paper width and height

$('#cmd').click(function () { 
   
    form.width(cache_width);
		getCanvas().then(function(canvas){			
		var
		img = canvas.toDataURL("image/png");
		var doc="";
		if(canvas.width > canvas.height){
		doc = new jsPDF('l', 'mm', [canvas.width, canvas.height],true);
		}else{
		doc = new jsPDF('p', 'mm', [canvas.width, canvas.height],true);
		}
		var width = doc.internal.pageSize.width;    
		var height = doc.internal.pageSize.height;
        doc.addImage(img, 'PNG', 10, 10, width-10,height-10,'','FAST');
		//form.width(cache_width);
		doc.save("Report.pdf");
		});
});

 function getCanvas(){
	//form.width((a3[0]*1.33333) -80).css('max-width','none');
	return html2canvas(form,{
    	imageTimeout:2000,
    	removeContainer:true
    });
}
	
	</script>
	
	
	

</html>
