<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<title> Employee Summary Report </title>
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
	tbody td:nth-child(1){
        
		text-align:left;
		padding-left:20px !important;
	}
	tbody td:nth-child(2){
        
		text-align:left;
		padding-left:20px !important;
	}
	tbody td:nth-child(3){
        
		text-align:center;
		
	}
	tbody td:nth-child(4){
        
		text-align:center;
	
	}
	tbody td:nth-child(5){
        
		text-align:center;
		
	}
	tbody td:nth-child(6){
        
		text-align:center;

	}
	tbody td:nth-child(7){
        
		text-align:center;
	
	}
	tbody td:nth-child(8){
        
		text-align:center;
		
	}
	
	</style>
</head>
<body>
	<div class="wrapper">
		<?php
			$data['pageid']=7.10;
			$this->load->view('menubar/sidebar',$data);
			$data=isset($data)?$data:'';
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
	                                <h4 class="title">Report</h4>
	                                <p class="category"> Early-Leavers </p>
	                               
								</div>
								<div class="card-content">
									<div class="col-sm-4 bargraph">
											<!------------------------------->
											</br><div id="reportrange" class="pull-left" style="background: #fff; cursor: pointer; padding: 6px; 10px; border: 1px solid #acadaf; width: 104%">
												<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
												<span></span> <b class="caret"></b>
											</div>
										 </div>
										 
							   <select id="desg" style="width:145px;height:35px" class="">
							   <option value="0">------All Designation------</option>
								<?php
								$data= json_decode(getAllDesg($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++){
									echo '<option  value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								}?>
							    </select>
										
							   <select id="deprt" style="width:145px;height:35px" class="">
							   <option value="0">----All Departments------</option>
								<?php
								$data= json_decode(getAllDept($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++){
									echo '<option  value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								}?>
							    </select>
										 
                                 <select id="shift" style=" width:140px;height:35px" class="">
							     <option value="0">--------All Shifts------</option>
								<?php
								$data= json_decode(getAllShift($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++){
									
								echo '<option  value='.$data[$i]->id.'>'.$data[$i]->name.'  ('.substr(($data[$i]->TimeIn),0,5).' - '.substr(($data[$i]->
								TimeOut),0,5).')</option>';
								
								}?></select>
								
								<select id="empl" style="width:140px;height:35px" class="">
							   <option value="0">------All Employee------</option>
								<?php
								$data= json_decode(getAllemp($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++){
									echo '<option  value='.$data[$i]->id.'>'.$data[$i]->FirstName.'  '.$data[$i]->LastName.'</option>';
								}?>
							    </select>
								
										<!--<div class="col-md-8">
                                        <select id="divi" style="  width:140px;height:31px" class="">
							            <option value="0">-Select Division-</option>
							       </select>
										</div>-->	
										
				 <button class="btn btn-success " id="getAtt"><i class="fa fa-search"></i></button>	
			     <a rel="tooltip" onclick="openNav()"  rel="tooltip"  data-placement="bottom" title="Help" class="btn btn-success btn-sm pull-right ">
			     <i class="fa fa-question"></i></a>

				 <div id="typography">
						<div class="title">
								<div class="row">
									<div class="col-md-4">
												</div>
												</div>
											
										</div>
										<div class="row" style="overflow-x:scroll;">
										<!--<h3 class="text-center">   Employee Late Report</h3>-->
											<table id="example" class="display table" cellspacing="0" width="100%">
											<thead>
											 
				<tr style="background-color:#68d46d;color:#ffffff;">
					<th width="15%" class="text-left">Name</th>
					<th width="15%" class="text-left">Designation</th>
					<th width="15%" class="text-left">Department</th>
					
					<th width="10%" class="text-left">Late By</th>
					<th width="10%" class="text-left">Early By</th>
					<th width="15%" class="text-left">Overtime/ Undertime </th>
							
					<th  width="15%"  class="text-left">Total Working Hours</th>
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

	       </section>
			<footer class="footer">
				<div class="container-fluid">	
				</div>
			</footer>
		</div>
	</div>


</body>
<script src="<?=URL?>../assets/js/buttons.colVis.min.js"></script>
      <script src="<?=URL?>../assets/js/dataTables.buttons.min.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/moment.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/daterangepicker.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/dataTables.buttons.min.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/buttons.flash.min.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/jszip.min.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/pdfmake.min.js"></script>
	     <script type="text/javascript" src="<?=URL?>../assets/js/vfs_fonts.js"></script>
		 <script type="text/javascript" src="<?=URL?>../assets/js/jquery.dataTables.min.js"></script>
	    <script type="text/javascript" src="<?=URL?>../assets/js/buttons.html5.min.js"></script>
     <script type="text/javascript" src="<?=URL?>../assets/js/buttons.print.min.js"></script>
     
     
     
     
     <script type="text/javascript">
	
    	$(document).ready(function() {
			
			var table= $('#example').DataTable( {
				"paging": true,
				//"bProcessing": true,
				order: [[ 1, 'asc' ]],
				"lengthChange":true,
				"scrollX": true,
				 dom: 'Bfrtip',
				 "bSort": false,
				 //"orderable": false,
		    
				
				buttons: [
						'pageLength','copy','csv','print', 'excel','pdfHtml5', 
					],
				
					});
					
						////---------date picker
			var minDate = moment();
			var start = moment().subtract(7,'days');
			var end = moment().subtract(1,'days');
			function cb(start, end) {
				$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
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