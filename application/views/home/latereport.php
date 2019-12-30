<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
  <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
  <link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" />

  <title>Late Comers Employee </title>
     <style>
    
      .red{
      color:red;
      font-weight:'bold';
      font-size:16px;
      }
      .delete{
      cursor:pointer;
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
      .t2{display:none;}
     .modal-footer .btn+.btn 
    {
      margin-bottom: 10px!important;
    }
    a
    {
      cursor:pointer;
      
    }
    </style>
</head>
<body>
   <div class="wrapper">
		<?php
			$data['pageid']=7.1;
			$this->load->view('menubar/sidebar',$data);
			$data=isset($data)?$data:'';
		?>
	    <div class="main-panel">
			<?php
				$this->load->view('menubar/navbar');
			?>
			</br>
        <div class="content" id="content" style="" >
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header" data-background-color="green" >
                  <!--  <h4 class="title">Attendance</h4> -->
                   <p class="category" style="color:#ffffff;font-size:17px;" > Late comers </p>
                    <!-- <p class="category" style="color:#ffffff;font-size:17px;" >Helppage </p> -->
                    <a rel="tooltip" style="position:relative;margin-top:-30px;"  data-placement="bottom" title="Help" class="btn btn-success btn-sm pull-right toggle-sidebar ">
                   <i class="fa fa-question"></i></a>
                  </div>
                  <div class="card-content">
								<div class="row container-fluid" style="margin-top:0px;" >
								<div class="col-sm-3 bargraph" style="margin-top:0px;" >				
								<div id="reportrange" class="pull-left" style="background: #fff; cursor: pointer; padding: 6px; 10px; border: 1px solid #acadaf; width: 104%">
								<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
								<span></span> <b class="caret"></b>
							    </div>
							    </div>
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
							  </div>
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
								</div>
							  <div class="col-sm-2">			
							  <div class="row">			
							   <select id="empl" style="height:35px;position:relative;" class="col-sm-11">
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
								 <button class="btn btn-success pull-left" style="position:relative;margin-top:-3px;" id="getAtt" ><i class="fa fa-search"></i></button>
								 </div>
							 </div>
			    

				 <div id="typography">
						<div class="title">
								<div class="row">
									<div class="col-md-4">
												</div>
												</div>
											
										</div>
										<br>
										<div class="row" style="overflow-x:scroll;">
										<!--<h3 class="text-center">   Employee Late Report</h3>-->
											<table id="example" class="display table" cellspacing="0" width="100%">
											<thead>
											 
												<tr style="background-color:#008067;color:#ffffff;">
													<th class="text-left">Name</th>
													<th>Code</th>
													<th  width="10%" class="text-left">Date</th>
													<th  width="20%">Designation</th>
													<th  width="20%">Department</th>
													<th width="20%" class="text-left">Shift </th>
													<th width="10%"  class="text-left">Time In </th>
													<!--<th>Time Out</th>
													<th width="10%"  class="text-left">count</th>
													<!--<th>Total Time</th>-->
													
													
													<th  width="15%"  class="text-left">Late By </th>
													<th>Device</th>
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
   <div class="col-md-3 t2" id="sidebar" style=" margin-top:100px;"></div>
        <footer class="footer">
          <div class="container-fluid" style="" >
            <nav class="pull-left">
            </nav>
           <!-- <p class="copyright pull-right" style="padding-right:35px;" >
              &copy; <script>document.write(new Date().getFullYear())</script>. Developed by<a href="http://www.ubitechsolutions.com/" target="_blank" > Ubitech Solutions </a>
            </p>-->
      <a href="http://www.ubitechsolutions.com/" target="_blank" >
          <p class="copyright pull-right" style="padding-right:25px;padding-top:0px;" >
          Copyright &copy;<script>document.write(new Date().getFullYear())</script>
          Ubitech Solutions. All rights reserved.
          </p>
        </a>
          </div>


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
  <div id="mySidenav" class="pull-right sidenav" style="background-image:url(<?=URL?>../assets/img/bg7.jpg);background-repeat:no-repeat;">
            <div class="helpHeader"><span >Help</span><a style="color:black;" href="javascript:void(0)" class="closebtn text-right" onclick="closeNav()">x </a></div>
            <div id="sidenavData" class="sidenavData">
            </div>
          </div>

            <script src="<?=URL?>../assets/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/moment.js"></script>
   <script type="text/javascript" src="<?=URL?>../assets/js/daterangepicker.js"></script>
   <script src="<?=URL?>../assets/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <script src="<?=URL?>../assets/js/buttons.colVis.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/buttons.flash.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/jszip.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/buttons.html5.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/buttons.print.min.js"></script>
  

  <script>
            function openNav() 
            {
              document.getElementById("mySidenav").style.width = "360PX";
              $('#sidenavData').load('<?=URL?>help/helpNav',{'pageid' :'latecomer'});  
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
				order: [[ 2, 'desc' ],[0,'asc']],
			
				"lengthChange":true,
				//"scrollX": true,
				 dom: 'Bfrtip',
				 //"bSort": false,
				 //"orderable": false,
				
				buttons: [
					//	'pageLength','copy','csv','print', 'excel','pdfHtml5', 
						'pageLength','csv','excel','copy','print','colvis',
					],
				 "bDestroy": false, // destroy data table before reinitializing
				/* buttons: [
				'colvis',
				], */
				"contentType": "application/json",
				"ajax": "<?php echo URL;?>admin/getLate__new?datestatus="+7,
				"columnDefs": 
				[
					{ "visible": false, "targets": [1,2,8]}
				],
				 "columns": [
				    
				 	{ "data": "Name" },
				 	{ "data": "code" },
					{ "data": "date" },
					{ "data": "desg" } ,
					{ "data": "depart" } ,
					{ "data": "shift" },
					{ "data": "TimeIn" },
					//{ "data": "ad" },
				   // { "data": "TimeOut" },
					//{ "data": "Totaltime" },
					{ "data": "LateHours" },
					{ "data": "device" }
					
					] ,
					"drawCallback": function ( settings ) {
					var api = this.api();
					var rows = api.rows( {page:'current'} ).nodes();
					var last=null;
		 
					api.column(2, {page:'current'} ).data().each( function ( group, i ) {
						if ( last !== group ) {
							$(rows).eq( i ).before(
								'<tr class="group"><td bgcolor="#d59ff2" colspan=10><b>'+group+'</b> <b> &nbsp; &nbsp; </b></td></tr>'
							);
							last = group;
						}
					} );
				}
			}); 
			 
			////---------date picker
			var minDate = moment();
			var start = moment().subtract(6, 'days');
			var end = moment().subtract(0, 'days');
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
				   'Last 7 Days': [moment().subtract(7, 'days'), moment().subtract(1, 'days')],
           'Last 30 Days': [moment().subtract(30, 'days'), moment().subtract(1, 'days')],
				   'This Month': [moment().startOf('month'), moment().endOf('month')],
				   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				}
			}, cb);
			
			cb(start, end);
			

////---------/date picker
	//	$('#reportrange').on('DOMNodeInserted',function(){ //alert();
		$('#getAtt').click(function(){
			var range=$('#reportrange').text();
		
			var shift=$('#shift').val();
			var deprt=$('#deprt').val();
			var empl=$('#empl').val();
			var desg=$('#desg').val();
			$('#example').DataTable( {
					order: [[ 2, 'desc'],[0,'asc']],
					//"scrollX": true,
					 dom: 'Bfrtip',
					 	// "bSort": false,
					 "bDestroy": true,// destroy data table before reinitializing
					 buttons: [
						//'pageLength','copy','csv','print', 'excel','pdfHtml5',
						//'pageLength','csv','excel','copy','print','pdfHtml5',
						'pageLength','csv','excel','copy','print','colvis',
					],
					/* buttons: [
						'colvis'
					], */
				
					"contentType": "application/json",
					"ajax": "<?php echo URL;?>admin/getLate__new?date="+range+"&shift="+shift+"&deprt="+deprt+"&empl="+empl+"&desg="+desg,
					"columnDefs": [
					{ "visible": false, "targets": [1,2,8] }
				],
					"columns": [
					{ "data": "Name" },
					{ "data": "code" },
					{ "data": "date" },
					{ "data": "desg" } ,
					{ "data": "depart" } ,
					{ "data": "shift" },
					{ "data": "TimeIn" },
					//{ "data": "ad" },
				   // { "data": "TimeOut" },
				   //{ "data": "Totaltime" },
				
					{ "data": "LateHours" },
					{ "data": "device" },
		
					],

					"drawCallback": function ( settings ) {
					var api = this.api();
					var rows = api.rows( {page:'current'} ).nodes();
					var last=null;
		 
					api.column(2, {page:'current'} ).data().each( function ( group, i ) {
						if ( last !== group ) {
							$(rows).eq( i ).before(
								'<tr class="group"><td bgcolor="#d59ff2" colspan=10><b>'+group+'</b> <b>&nbsp; &nbsp;  </b></td></tr>'
							);
							last = group;
						}
					} );
				}
				} );
			});
			
			
			
			function createpdf()
			{
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

  <script>
    $(document).ready(function(){
    $('.toggle-sidebar').click(function(){
    $("#sidebar").toggleClass("collapsed t2");
    $("#content").toggleClass("col-md-9");
    $("#sidebar").load('<?=URL?>admin/helpNav',{'pageid': 'latecomer'}); 
    });
    
    });
  </script>

</html>