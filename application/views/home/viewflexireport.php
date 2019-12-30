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
	
	<title> Punched Flexi   </title>
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
			$data['pageid']='7.21';
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
	                                <p class="category" style="color:#ffffff;font-size:17px;" > Flexi Report
									</p>
								</div>
						<div class="card-content">
						   
								 <div id="typography">
									<div class="title">
											<div class="row">
												<div class="col-md-8">
												<h4><?php echo ' Attendance of <b>'.$name.'</b> on <b>' .$date.'</b>'; ?></h4>
												</div>
												<div class="col-md-4">
											
											</div>
											
											<a rel="tooltip"  data-placement="bottom" title="Help" class="btn btn-success btn-sm pull-right toggle-sidebar">
											<i class="fa fa-question"></i></a>
										</div>
											
									</div><br>

									
										<div class="row" style="overflow-x:scroll;">
										<!--<h3 class="text-center"> Employee  Overtime Report</h3>-->
											<table id="example" class="display table" cellspacing="0" width="100%">
											<thead>
												<tr style="background-color:#68d46d;color:#ffffff;">
													<th >Employees</th>
													<!--<th >Code</th>-->
													<!-- <th >Date</th> -->
													<!--<th>Visited Client</th>-->
												     <th>Visit In</th>
													<th >Time In</th>
													<th width="15%">Locations In</th>
													<th>Visit Out</th>
													<th >Time Out</th>
												<!--	<th >Total Time</th> -->
													<th width="15%">Locations Out</th>
													<th>Logged Hours</th>
													<!-- <th >Action</th> -->
												</tr>
											</thead>
											<tbody>
												
												
												<?php 
													
													for($i=0;$i<count($detail);$i++)
														echo '<tr>
															<td>'.getEmpName($detail[$i]['id']).'</td>
															
															<td>'.$detail[$i]['entryimg'].'</td>
															<td>'.$detail[$i]['timein'].'</td>
															<td>'.$detail[$i]['locationout'].'</td>
															<td>'.$detail[$i]['exitimg'].'</td>
															<td>'.$detail[$i]['timeout'].'</td>
															<td>'.$detail[$i]['locationout'].'</td>
															<td>'.$detail[$i]['loggedhours'].'</td>
															
															
														</tr>';
													
												 ?>
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
				</div>
			</footer>
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

<!---modal close edit employee--->



<!------image modal----->
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content"> 
      <div class="modal-body">
      	<button type="button" class="close" data-dismiss="modal" style="color:black"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <img src="" class="imagepreview"  style="width:550px!important;height:500px!important;" >
      </div>
    </div>
  </div>
</div>
		<!----------->










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
	function openNav() 	{
							document.getElementById("mySidenav").style.width = "400PX";
							$('#sidenavData').load('<?=URL?>help/helpNav');	
						}
						function closeNav() {
							document.getElementById("mySidenav").style.width = "0";
						}
	
	</script>

	<script type="text/javascript">
	
    	$(document).ready(function(){
			
			var table= $('#example').DataTable({
				
				
				
				 	// order: [[ 1, 'desc' ],[0,'asc']],
				// //"scrollX": true,
				 // dom: 'Bfrtip',
				  // "bSort": false,
		       // buttons: [
						// 'pageLength','csv','excel','copy','print','colvis',
					// ],
					
				// "bDestroy": false, // destroy data table before  
				
				// "contentType": "application/json",
				// "ajax": "<?php echo URL;?>admin/viewflezi",
				// "columnDefs": [
					// { "visible": false, "targets":[1]}
					// ,
					
				// ],
				 
				// "columns": [
					// { "data": "name" },
					// //{ "data": "code" },
					// { "data": "date" },
					// //{ "data": "client" },
					// { "data": "entryimg" },
					// { "data": "timein" },
					// { "data": "locationin" },
					// { "data": "exitimg" },
					// { "data": "timeout" },
				
					// { "data": "locationout" },
					// { "data": "loggedhours" },
					
					// // { "data": "action"}
					// ],
					// "drawCallback": function ( settings ) {
					// var api = this.api();
					// var rows = api.rows( {page:'current'} ).nodes();
					// var last=null;
		 
					// api.column(1, {page:'current'} ).data().each( function ( group, i ) {
						// if ( last !== group ) {
							// $(rows).eq( i ).before(
								// '<tr class="group"><td bgcolor="#d59ff2" colspan=10><b>'+group+'</b> <b> &nbsp; &nbsp; </b></td></tr>'
							// );
							// last = group;
						// }
					// } );
				// }
			}); 
	
		

////---------date picker
// 			var minDate = moment();
// 			var start = moment();
// 			var end = moment();
// 			function cb(start, end) {
// 				$('#reportrange span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
// 			}
// 			$('#reportrange').daterangepicker({
// 				maxDate:minDate,
// 				minDate:'-4M',
// 				startDate: start,
// 				endDate: end,
// 				ranges: {
// 				   'Today': [moment(), moment()],
// 				   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
// 				   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
// 				   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
// 				   'This Month': [moment().startOf('month'), moment().endOf('month')],
// 				   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
// 						}
// 			}, cb);
// 			cb(start, end);
// ////---------/date picker






// 		//$('#reportrange','#shift').on('DOMNodeInserted',function(){ //alert();
// 		$('#getAtt').click(function(){
// 			var range=$('#reportrange').text();
// 			var shift=$('#shift').val();
// 			var deprt=$('#deprt').val();
// 			var empl=$('#empl').val();
// 			var desg=$('#desg').val();
// 			$('#example').DataTable( {
// 						order: [[ 1, 'desc' ],[0,'asc']],
// 					//"scrollX": true,
// 					 dom: 'Bfrtip',
// 					 "bSort": false,
// 					buttons: [
// 						'pageLength','csv','excel','copy','print','colvis',
						
// 					],
// 					 "bDestroy": true,// destroy data table before reinitializing
					
// 					"contentType": "application/json",
// 					"ajax": "<?php echo URL;?>admin/punchedFlexi?date="+range+"&shift="+shift+"&deprt="+deprt+"&empl="+empl+"&desg="+desg,
// 					"columnDefs": 	[
// 					{ "visible": false, "targets": [1]},
// 									],
				
					
// 					"columns": 
// 					[
// 						{ "data": "name" },
// 						//{ "data": "code" },
// 						{ "data": "date" },
// 						//{ "data": "client" },
// 						{ "data": "entryimg" },
// 						{ "data": "timein" },
// 						{ "data": "locationin" },
// 						{ "data": "exitimg" },
// 						{ "data": "timeout" },
// 						{ "data": "locationout" },
// 						{ "data": "loggedhours" },
// 						//{ "data": "device" },
// 						//{ "data": "comments"},
// 					],
// 					"drawCallback": function (settings) {
// 					var api = this.api();
// 					var rows = api.rows( {page:'current'} ).nodes();
// 					var last=null;
		 
// 					api.column(1, {page:'current'} ).data().each( function ( group, i ) {
// 						if ( last !== group ) {
// 							$(rows).eq( i ).before(
// 								'<tr class="group"><td bgcolor="#d59ff2" colspan=10><b>'+group+'</b></td> <b> &nbsp; &nbsp; </b></tr>'
// 							);
// 							last = group;
// 						}
// 					} );
// 				}
// 				} );
// 			});
			
				
			
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
			
		
		
		////image pop up//////////////
		$(document).on("click", ".pop", function ()
			{
			$('.imagepreview').attr('src', $(this).find('img').attr('src'));
			$('#imagemodal').modal('show');   
			});	
		
		
		
		
		
		
		
		
		<!-- This code for when add the country (start)-->
		$(document).on("change", "#country", function () {
				var country = $(this).val();
				$.ajax({url: "<?php echo URL;?>userprofiles/getCity",
						data: {"country":country},
						success: function(result)
						{
							var result=JSON.parse(result);
							 var i = 0;
							for(i=0; i<result.length; i++){
								$('#city').append('<option value="' + result[i].Id + '">' + result[i].Name + '</option>');	
							}		   				
						 },
						error: function(result)
						 {
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
