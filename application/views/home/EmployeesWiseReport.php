<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<title> Wise Employee Report</title>
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
	 tbody td:not(:nth-child(1)){
		text-align:center;	
	}
	</style>
</head>
<body>
	<div class="wrapper">
		<?php
			$data['pageid']=7.8;
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
	                                <p class="category">Employee Wise Report</p>
	                               
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
			 <!--    <a rel="tooltip" onclick="openNav()"  rel="tooltip"  data-placement="bottom" title="Help" class="btn btn-success btn-sm pull-right ">
			     <i class="fa fa-question"></i></a>	-->

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
													<th width="10%" class="text-left"> Date</th>
													<th width="9%" class="text-left">Shift Name</th>
													<th width="8%" class="text-left">Shift Start</th>
													<th width="8%" class="text-left">Time In</th>
													<th width="8%" class="text-left">Late By</th>
													<th width="8%" class="text-left">Shift End</th>
													<th width="8%" class="text-left">Time Out</th>
													<th width="8%" class="text-left">Early By</th>
													<th width="8%" class="text-left">Overtime/ Undertime </th>
													<th width="9%"  class="text-left">Time Off </th>									
												<th  width="10%"  class="text-left">Total Working Hours</th>
												<th  width="9%"  class="text-left">Name</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
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
					<nav class="pull-left">
						
					</nav>
					<p class="copyright pull-right">
						&copy; <script>document.write(new Date().getFullYear())</script> <a href="#">DESIGNED BY</a> Ubitech Solutions Pvt. Ltd.
					</p>
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
			<input type="hidden" id="del_id"/>
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
						<div class="helpHeader"><span ><b>&nbsp;&nbsp;<i style="font-size:24px; color:black;"class="fa fa-question-circle" ></i ></b></span><a style="color:black;" href="javascript:void(0)" class="closebtn text-right" onclick="closeNav()">x </a></div>
						<div id="sidenavData" class="sidenavData">
						</div>
					</div>
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
	
	<script>
	function openNav() {
							document.getElementById("mySidenav").style.width = "360PX";
							$('#sidenavData').load('<?=URL?>help/helpNav/7');	
						}
						function closeNav() {
							document.getElementById("mySidenav").style.width = "0";
						}
						
	
	</script>

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
				 "bDestroy": false, // destroy data table before reinitializing
				/* buttons: [
				'colvis',
				], */
				"contentType": "application/json",
				"ajax": "<?php echo URL;?>Report/getEmployeesWiseReport",
				"columnDefs": [
					{ "visible": false, "targets": 11 }
				],
				
				 "columns": [
				    
				 	{ "data": "Date" },
					{ "data": "cname" },
					{ "data": "Shift_start" },
					{ "data": "Time_in" } ,
					{ "data": "Late_by" },
					{ "data": "Shift_end" },
					{ "data": "Time_out" },
					{ "data": "Early_by" },
					{ "data": "Over_under" },
					{ "data": "Time_of" },
					{ "data": "Totalworkin_hour" },
					{ "data": "Name" }
					] ,
					
					"drawCallback": function ( settings ){
					var api = this.api();
					var rows = api.rows( {page:'current'} ).nodes();
					var last=null;
		 
					api.column(11, {page:'current'} ).data().each( function ( group, i ) {
						if ( last !== group ) {
							$(rows).eq( i ).before(
								'<tr class="group"><td bgcolor="#d59ff2" colspan=12><b>'+group+'</b> <b>&nbsp; &nbsp;  </b></td></tr>'
							);
							last = group;
						}
					} );
				}
					
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
	//	$('#reportrange').on('DOMNodeInserted',function(){ //
		$('#getAtt').click(function(){ 
			var range=$('#reportrange').text();
			var shift=$('#shift').val();
			var deprt=$('#deprt').val();
			var empl=$('#empl').val();
			var desg=$('#desg').val();
		      
			$('#example').DataTable( {
					order: [[ 1, 'asc' ]],
					"scrollX": true,
					 dom: 'Bfrtip',
					 	 "bSort": false,
					 "bDestroy": true,// destroy data table before reinitializing
					 buttons: [
						'pageLength','copy','csv','print', 'excel','pdfHtml5', 
					],
					/* buttons: [
						'colvis'
					], */
					"contentType": "application/json",
					"ajax": "<?php echo URL;?>Report/getEmployeesWiseReport?date="+range+"&shift="+shift+"&deprt="+deprt+"&empl="+empl+"&desg="+desg,
					"columnDefs": [
					{ "visible": false, "targets": 11 }
				],
					"columns": [
					{ "data": "Date" },
					{ "data": "cname" },
					{ "data": "Shift_start" },
					{ "data": "Time_in" } ,
					{ "data": "Late_by" },
					{ "data": "Shift_end" },
					{ "data": "Time_out" },
					{ "data": "Early_by" },
					{ "data": "Over_under" },
					{ "data": "Time_of" },
					{ "data": "Totalworkin_hour" },
					{ "data": "Name" }
		
					],
					
					"drawCallback": function ( settings ) {
					var api = this.api();
					var rows = api.rows( {page:'current'} ).nodes();
					var last=null;
		 
					api.column(11, {page:'current'} ).data().each( function ( group, i ) {
						if ( last !== group ) {
							$(rows).eq( i ).before(
								'<tr class="group"><td bgcolor="#d59ff2" colspan=12><b>'+group+'</b> <b>&nbsp; &nbsp;  </b></td></tr>'
							);
							last = group;
						}
					} );
				}
					
			  });
			});
			
			
			
			function createpdf()
		  {
		 // console.log($val)
		 
			var pdf = new jsPDF('p', 'pt', 'a3');
			var options = {
					 pagesplit: true,
					 background:'#fff'
				};
			
			pdf.addHTML($("#printsection")[0], options, function()
			{
				//console.log(pdf)	
				pdf.save("absent_report.pdf");
			});
		  }
			
			
			
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
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
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
			
			$('#create_pdf').on('click',function(){
	$('body').scrollTop(0);
	createPDF();
});
	$(document).on("change", "#divi", function () {
				var divi = $(this).val();
				$.ajax({url: "<?php echo URL;?>admin/getAlldiv",
						data: {"divi":division},
						success: function(result){
							var result=JSON.parse(result);
							 var i = 0;
							for(i=0; i<result.length; i++){
								$('#divi').append('<option value="' + result[i].Id + '"  >' + result[i].Name + '</option>');	
							}		   				
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
				
			})
	});		
	</script>
	
	
	

</html>
