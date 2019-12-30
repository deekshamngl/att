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
	
	<title> Punched Locations   </title>
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
<body>
	<div class="wrapper">
		<?php
			$data['pageid']='7.13';
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
	                                <h4 class="title">Report</h4>
	                                <p class="category">Punched Locations  </p>
	                               
								</div>
								<div class="card-content">
								
						<!--<div class="col-sm-3">
							<select id="shift" class="form-control ">
								<option value="0">-Select Shift-</option>
								<?php
								$data= json_decode(getAllShift($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++)
									echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								?>
							</select>
						</div>	-->
						<div class="col-sm-6 col-md-3 col-lg-3 col-xs-12 ">
											<!------------------------------->
											<div id="reportrange" class="" style="background: #fff; cursor: pointer; padding: 6px; 10px; border: 1px solid #acadaf">
												<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
												<span></span> <b class="caret"></b>
						                     </div>
						</div>
						<div class="col-sm-2 col-md-2 col-lg-2 col-xs-12 ">
							   <select id="desg" style="width:145px;height:35px" class="">
							   <option value="0">---All Designations------</option>
								<?php
								$data= json_decode(getAllDesg($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++){
									echo '<option  value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								}?>
							    </select> 
						</div>	
						<div class="col-sm-2 col-md-2 col-lg-2 col-xs-12 ">
								<select id="deprt" name="deprt" style=" width:145px;height:35px" class="">
							    <option value="0">---All Departments------</option>
								<?php
								$data= json_decode(getAllDept($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++)
								echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								?>
							     </select>		 
						</div>	
						<div class="col-sm-2 col-md-2 col-lg-2 col-xs-12 ">
                              <select id="shift" name="shift" style=" width:140px;height:35px" class="">
							   <option value="0">---All Shifts------</option>
								<?php
								$data= json_decode(getAllShift($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++)
									echo '<option  value='.$data[$i]->id.'>'.$data[$i]->name.'  ('.substr(($data[$i]->TimeIn),0,5).' - '.substr(($data[$i]->
								TimeOut),0,5).')</option>';
								?></select>
						</div>
						<div class="col-sm-3 col-md-2 col-lg-2 col-xs-12 ">						
								
								<select id="empl" style="width:140px;height:35px" class="">
							   <option value="0">---All Employees------</option>
								<?php
								$data= json_decode(getAllemp($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++){
									echo '<option  value='.$data[$i]->id.'>'.$data[$i]->FirstName.'  '.$data[$i]->LastName.'</option>';
								}?>
							    </select>
						</div>
						
						<div class="col-sm-3 col-md-1 col-lg-1 col-xs-12 ">
								 <button style="margin-top: 0px;" class="btn btn-success " id="getAtt"><i class="fa fa-search"></i></button>
						</div>
							<!--	<a rel="tooltip" onclick="openNav()"  rel="tooltip"  data-placement="bottom" title="Help" class="btn btn-success btn-sm pull-right ">	-->
								 <div id="typography">
									<div class="title">
											<div class="row">
												<div class="col-md-4">
												</div>
											
												</div>
											
										</div>
										<div class="row" style="overflow-x:scroll;">
										<!--<h3 class="text-center"> Employee  Overtime Report</h3>-->
											<table id="example" class="display table" cellspacing="0" width="100%">
											<thead>
												<tr style="background-color:#68d46d;color:#ffffff;">
													<th >Name</th>
													<th >Time In</th>
													<th width="10%">Date</th>
													<th width="10%">Time</th>
													<th width="20%">Location</th>
													<th width="10%">Time Out</th>
													<th width="20%">Client</th>
													<th width="20%">Comments</th>
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
						<div class="helpHeader"><span ><b>&nbsp;&nbsp;<i style="font-size:24px; color:black;"class="fa fa-question-circle" ></i ></b></span><a style="color:black;" href="javascript:void(0)" class="closebtn text-right" onclick="closeNav()">x </a></div>
						<div id="sidenavData" class="sidenavData">
						</div>
					</div>
      <script src="<?=URL?>../assets/js/dataTables.buttons.min.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/moment.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/daterangepicker.js"></script>
	  <script type="text/javascript" src="<?=URL?>../assets/js/dataTables.tableTools.js"></script>
	  <script src="<?=URL?>../assets/js/buttons.colVis.min.js"></script>
	   <script type="text/javascript" src="<?=URL?>../assets/js/jquery.dataTables.min.js"></script>
	  <script type="text/javascript"  src="<?=URL?>../assets/js/table_pdf/jspdf.min.js"></script>
     <!-- <script type="text/javascript" src="<?=URL?>../assets/js/dataTables.bootstrap.js"></script>-->
	  <script type="text/javascript" src="<?=URL?>../assets/js/buttons.flash.min.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/jszip.min.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/pdfmake.min.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/vfs_fonts.js"></script>
	  <script type="text/javascript" src="<?=URL?>../assets/js/buttons.print.min.js"></script>
	  <script type="text/javascript" src="<?=URL?>../assets/js/buttons.html5.min.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/tableExport.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/jquery.dataTables.min.js"></script>
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
	
    	$(document).ready(function() {
			$('#example tr:eq(1)').remove();
			var table= $('#example').DataTable( {
				order: [[ 1, 'asc' ]],
				//"scrollX": true,
				 dom: 'Bfrtip',
				  "bSort": false,
		       buttons: [
						'pageLength','copy','csv','print', 'excel','pdfHtml5','colvis',
					],
				"bDestroy": false, // destroy data table before  
				
				"contentType": "application/json",
				"ajax": "<?php echo URL;?>admin/getdaypunchLocation",
				"columnDefs": [
					{ "visible": false, "targets": [0,1,7] },
					
				],
				
				"columns": [
				    
					{ "data": "name" },
					{ "data": "timein" },
					{ "data": "date" },
					{ "data": "time" },
					{ "data": "loc" },
					{ "data": "timeout" },
					{ "data": "client"},
					{ "data": "desc"}
				
					],
					"rowGroup": {
                dataSrc: 0,
                startRender: null,
                endRender: function ( rows, group) {
                    var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
           					 };  
                },
            },
      	"drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last = null;
            api.rows({page:'current'}).data().each(function (data, i){
                var group1 = data['name'];
                var group = data['timein'];
                var groups = data['timeout'];
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="6" bgcolor="#d59ff2"><div class="pull-left" >'+group1+'</div><div class="pull-right" >Time In : '+group+'&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;  Time Out : '+groups+'</div></td></tr>'
                    );
 
                    last = group;
                }
            });
          
        }
			}); 
	
			////---------date picker
			var minDate = moment();
			var start = moment();
			var end = moment();
			function cb(start, end) {
				$('#reportrange span').html(start.format('MMM D, YY') + ' - ' + end.format('MMM D, YY'));
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
		//$('#reportrange','#shift').on('DOMNodeInserted',function(){ //alert();
		$('#getAtt').click(function(){
			  
			  
			var range=$('#reportrange').text();
			var shift=$('#shift').val();
			var deprt=$('#deprt').val();
			var empl=$('#empl').val();
			var desg=$('#desg').val();
			$('#example').DataTable( {
				 
				       
					order: [[ 1, 'asc' ]],
					//"scrollX": true,
					 dom: 'Bfrtip',
					 "bSort": false,
					buttons: [
				       'pageLength','copy','csv','print', 'excel','pdfHtml5','colvis',

					],
					 "bDestroy": true,// destroy data table before reinitializing
					/* buttons: [
				 //'colvis'   "+range+"&shift="+shift+"&deprt="+deprt,
				], */
					"contentType": "application/json",
					"ajax": "<?php echo URL;?>admin/getdaypunchLocation?date="+range+"&shift="+shift+"&deprt="+deprt+"&empl="+empl+"&desg="+desg,
					"columnDefs": [
					{ "visible": false, "targets": [0,2,1,7]},
					
				],
					"columns": [
					{ "data": "name" },
					{ "data": "timein"},
					{ "data": "date" },
					{ "data": "time" },
					{ "data": "loc" },
					{ "data": "client"},
					{ "data": "desc"},
					{ "data": "timeout" },
					],
				
     ////////////start this////////	
       "rowGroup": {
                dataSrc: 0,
                startRender: null,
                endRender: function ( rows, group) {
                    var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
           					 };  
                },
            },
      	"drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last = null;
            api.rows({page:'current'}).data().each(function (data, i){
                var group1 = data['name'];
                var group2 = data['date'];
                var group = data['timein'];
                var groups = data['timeout'];
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="6" bgcolor="#d59ff2"><div class="pull-left" >'+group1+'</div><div class="pull-right" >Date :'+group2+'&nbsp;&nbsp;&nbsp;&nbsp;  Time In : '+group+'&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;  Time Out : '+groups+'</div></td></tr>'
                    );
 
                    last = group;
                }
            });
          
        }
     
     
				} );
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
