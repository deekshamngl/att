<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/fixedColumns.dataTables.min.css"/><link rel="stylesheet" href="<?=URL?>../assets/css/jquery.dataTables.min.css"/>
	<title>ubiAttendance</title>
</head>
<body>
       
	<div class="wrapper">
		<?php
			$data['pageid']=3.6;
			$this->load->view('ubitech/sidebar',$data);
		?>
	    <div class="main-panel">
			<?php
				$this->load->view('ubitech/navbar');
			?>
			<div class="content">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-md-12">
						<!-- this message for success or error start-->
						<?php if($this->session->flashdata('success') == 'Organization registered successfully'){ 
	                     ?><script>
							doNotify('top','center',2,'Organization registered successfully');
						 </script>
							
                        <?php 
						}if($this->session->flashdata('success') == 'Organization updated successfully'){ ?>
						  <script>
							doNotify('top','center',2,'Organization updated successfully.');
						 </script>
						<?php }
						if($this->session->flashdata('error')){ ?>
						<script>
							doNotify('top','center',2,'Email id is already exists.');
						 </script>
						<?php
						}
						 ?>
					   	<!-- this message for success or error end-->
	                        <div class="card">
	                            <div class="card-header" data-background-color="purple">
	                                <h4 class="title">Expired Subscriptions</h4>
	                                <p class="category">Organization Settings</p>
	                            </div>
	                            <div class="card-content">
									<div id="typography">
										<div class="title">
											<div class="row">
												<div class="col-md-3">
													
												</div>
												<div class="col-md-1">
													
												</div>
												<div class="col-sm-2" style="margin-top:-20px;">
								<select id="getval" class="form-control">
    									<option value="">All Countries</option>
    									<option value="1">International</option>
    									<option value="2">National</option>
								</select>
										</div>
										        <div class="col-sm-3">
													<button class="btn btn-sm btn-primary" data-toggle="modal"  type="button"	onclick="Allassign();" style="margin-top:11px;margin-left: 25px;"><i class="fa fa-plus"> Assign Lead Owner</i>
													</button>	
												</div>
										
												<div class="col-md-2 text-right">
													<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addSld" type="button">	
														<i class="fa fa-plus">Add</i>
													</button>
												</div>
											</div>
										</div>
										<div class="row">
											<table id="example" class="display table" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th style="background-image:none"!important><input type="checkbox" id="select_all" value=""/> </th>
													<th width="15%">Organization</th>
													<th>Contact Name</th>
													<th>Email</th>
													<th>Phone </th>
													
													<th>Country</th>
													<th>City</th>
													<th width="80" >Plan Start</th>
													<th width="80" >Plan End</th>
													<th>Lead Owner</th>
													<th>Rating</th>
													<th>Registered Users</th>
													<th>User Limit</th>
												
												
													<th>Password</th>
													<th>Paye Details</th>
													
													<th>CRN</th>
												
													<th>Action</th>
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

			<footer class="footer">
				<div class="container-fluid">
					<p class="copyright pull-right">
						&copy; <script>document.write(new Date().getFullYear())</script> <a href="#">DESIGNED BY </a>Ubitech Solutions Pvt. Ltd.
					</p>
				</div>
			</footer>
		</div>
	</div>
<!-- Modal open add sld img-->
<div id="addSld" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
	
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Add Organization</h4>
      </div>
      <div class="modal-body">
		<form id="deptFrom" action="<?php echo URL;?>ubitech/registerOrganization"  >
			<div class="row">
				<div class="col-md-12">
					
					<div class="form-group label-floating">
						<label class="control-label">Organization Name <span class="red"> *</span></label>
						<input type="text" id="org_name" name="org_name" class="form-control alpha" >
					</div>
					<div class="form-group label-floating">
						<label class="control-label">Contact Person Name<span class="red"> *</span></label>
						<input type="text" id="name" name="name" class="form-control alpha" >
					</div>
					 
					<div class="form-group label-floating">
						<label class="control-label">Email<span class="red"> *</span></label>
						<input type="email" id="email" name="email" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
					</div>
					<div class="form-group label-floating">
						<label class="control-label">Phone<span class="red"> *</span></label>
						<input type="text" id="phone" name="phone" class="form-control numeric" pattern="[0-9]{1}[0-9]{9}">
					</div>
					<div class="form-group label-floating">
						<select id="country" name="country" class="form-control" >
						       <option value="0" >Country<span class="red"> *</span></option>
						    <?php foreach ($h->result() as $row){ ?>
		                       <option value="<?php echo $row->Id;?>" ><?php echo $row->Name;?></option>
                            <?php } ?> 
						</select>
					</div>
					<div class="form-group label-floating">
						<label class="control-label">Address<span class="red"> *</span></label>
						<textarea id="Address" name="Address" class="form-control"></textarea>
					</div>
				</div>
			</div>
			
			<div class="clearfix"></div>
		</form>
		
		
		
      </div>
      <div class="modal-footer">
        <button type="button" id="save"  class="btn btn-success" >Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	
    </div>
  </div>
</div>
<!---modal close--->

<!------Edit slider modal start------------>
<div id="addSldE" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
	
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Edit Organization</h4>
      </div>
      <div class="modal-body">
		<form id="deptFromE"   action="<?php echo URL;?>ubitech/editOrganizationData" >
		<input type="text" class="hidden" id="edit_id" name="edit_id" />
			
		<div class="row">
				<div class="col-md-12">
					
					<div class="form-group label-floating">
						<label class="control-label">Organization Name <span class="red"> *</span></label>
						<input type="text" id="org_nameE" name="org_nameE" class="form-control" >
					</div>
					<div class="form-group label-floating">
						<label class="control-label">Contact Person Name<span class="red"> *</span></label>
						<input type="text" id="nameE" name="nameE" class="form-control" >
					</div>
					
					 
					<div class="form-group label-floating">
						<label class="control-label">Email<span class="red"> *</span></label>
						<input type="email" id="emailE" name="emailE" class="form-control" >
					</div>
					<div class="form-group label-floating">
						<label class="control-label">Phone</label>
						<input type="number" id="phoneE" name="phoneE" class="form-control">
					</div>
					<div class="form-group label-floating">
						<select id="countryE" name="countryE" class="form-control" >
						       <option value="0" >Country</option>
						    <?php foreach ($h->result() as $row){ ?>
		                       <option value="<?php echo $row->Id;?>" ><?php echo $row->Name;?></option>
                            <?php } ?> 
						</select>
					</div>
					<div class="form-group label-floating">
						<label class="control-label">City</label>
						<textarea id="AddressE" name="AddressE" class="form-control"></textarea>
					</div>
				</div>
			</div>
			<input type="hidden" id="editE_id" name="editE_id" />
			
			<div class="clearfix"></div>
		</form>
		
		
		
      </div>
      <div class="modal-footer">
        <button type="button" id="saveE"  class="btn btn-success" >Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	
    </div>
  </div>
</div>
<!------Edit slider modal close------------>

<!------Assign Owner Model------------>
<div id="modelassign" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Assign Lead Owner</h4>
      </div>
      <div class="modal-body">		
		<form>
			<div class="row">
				<div class="col-md-12">
					<h4>Assign Lead Owner</h4>

				</div>
			</div>
			<div class="form-group label-floating">
						<select id="lead_name" name="lead_name" class="form-control" style="width: 50%;">
						       <option value="0" >Please Select</option>
						    <?php foreach ($l->result() as $row){ ?>
		                       <option value="<?php echo $row->Id;?>" ><?php echo $row->Name;?></option>
                            <?php } ?> 
						</select>
					</div>
			<div class="clearfix"></div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="saveall"  class="btn btn-success">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div> 
  </div> 
</div>
<!------Assign Owner Model close------------>

<!-----delete sld start--->
<div id="delSld" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Delete Attendance</h4>
      </div>
      <div class="modal-body">		
		<form>
			<input type="hidden" id="del_aid" />
			<input type="hidden" id="del_image" />
			<div class="row">
				<div class="col-md-12">
					<h4>Are you sure want to delete Image  ?</h4>
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
<!-----delete sld close--->

<!-----Not Renewed org start--->
<div id="notrenew" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Plan renewal</h4>
      </div>
      <div class="modal-body">		
		<form>
			<input type="hidden" id="del_did1" />
			<div class="row">
				<div class="col-md-12">
					<h4>Are you sure that the plan is not to be renewed?"<span id="dna1"></span>" ?</h4>
				</div>
			</div>
			<div class="clearfix"></div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="notrenewed"  class="btn btn-success"> Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div> 
  </div> 
</div>

<!-----Not Renewed org close--->
</body>
   <script src="<?=URL?>../assets/js/dataTables.buttons.min.js"></script>
   <script type="text/javascript" src="<?=URL?>../assets/js/moment.js"></script>
 <script type="text/javascript" src="<?=URL?>../assets/js/buttons.print.min.js"></script>
	 <script src="<?=URL?>../assets/js/buttons.colVis.min.js"></script>
	   <!-- <script type="text/javascript" src="<?=URL?>../assets/js/pdfmake.min.js"></script> -->
	   <script src=" https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js
"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

	  <script type="text/javascript" src="<?=URL?>../assets/js/buttons.html5.min.js"></script>
 <script type="text/javascript" src="<?=URL?>../assets/js/dataTables.fixedColumns.min.js"></script>
   <script type="text/javascript" src="<?=URL?>../assets/js/jquery.dataTables.min.js"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"> </script>

	<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.15/sorting/datetime-moment.js"> </script>
   <script>
   var specialKeys = new Array();
			specialKeys.push(8); //Backspace
			$(function () 
			{
				$(".numeric").bind("keypress", function (e) 
				{
					var keyCode = e.which ? e.which : e.keyCode
					var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
					$(".error").css("display", ret ? "none" : "inline");
					return ret;
				});
				
				$(".numeric").bind("drop", function (e) {
					return false;
				});
			});
			
			$(".alpha").keydown(function(e)
			{
				if ($.inArray(e.keyCode, [46, 8, 9]) !== -1 ||
				// Allow: Ctrl+A, Command+A
				(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
				(e.keyCode >= 35 && e.keyCode <= 40)) 
				{
				return;
				}// Ensure that it is a number and stop the keypress
				if ((e.keyCode < 65 || e.keyCode > 90) && (e.keyCode !=95 || e.keyCode > 123) && e.keyCode != 32)
				{
				e.preventDefault();
				}
			});
   </script>
	<script type="text/javascript">
			
	    var table;
		
		$(function(){
			 table=$('#example').DataTable( {
						"scrollY":"400px",
        				"scrollX":true,
        				"scrollCollapse":true,
        				//"paging":false,
        				
        			'columnDefs': [
       					{ targets: [9,10,11,12,14], visible :false }
    					],
						"contentType": "application/json",
						"order": [[ 7, "desc" ]],
						dom: 'Bfrtip',
						"stateSave": true,
						// "stateDuration": 10,
						"lengthMenu": [[10, 25, 50,100,500,1000,-1],[10,25,50,100,500,1000,"All"]],
						buttons: [
					'pageLength','csv', 'excel','copy','print',
					{ 
                     "extend":'colvis', 
                     "columns":':not(:last-child)', 
                    } 
,
                    {
                "extend": 'pdfHtml5',
                "orientation": 'landscape',
                "pageSize": 'legal',
                
                exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9,10,11,12]
                },
                customize: function (doc) {
						//Remove the title created by datatTables
						doc.content.splice(0,1);
						//Create a date string that we use in the footer. Format is dd-mm-yyyy
						var now = new Date();
						var jsDate = now.getDate()+'-'+(now.getMonth()+1)+'-'+now.getFullYear();
						// Logo converted to base64
						// var logo = getBase64FromImageUrl('https://datatables.net/media/images/logo.png');
						// The above call should work, but not when called from codepen.io
						// So we use a online converter and paste the string in.
						// Done on http://codebeautify.org/image-to-base64-converter
						// It's a LONG string scroll down to see the rest of the code !!!
						
						// A documentation reference can be found at
						// https://github.com/bpampuch/pdfmake#getting-started
						// Set page margins [left,top,right,bottom] or [horizontal,vertical]
						// or one number for equal spread
						// It's important to create enough space at the top for a header !!!
						doc.pageMargins = [20,60,20,30];
						// Set the font size fot the entire document
						doc.defaultStyle.fontSize = 7;
						// Set the fontsize for the table header
						doc.styles.tableHeader.fontSize = 7;
						// Create a header object with 3 columns
						// Left side: Logo
						// Middle: brandname
						// Right side: A document title
						doc['header']=(function() {
							return {
								columns: [
									
									{
										alignment: 'left',
										italics: true,
										 text: 'PDF Report',
										fontSize: 18,
										margin: [8,0]
									},
									{
										alignment: 'right',
										fontSize: 14,
										text: ' '
									}
								],
								margin: 2
							}
						});
						// Create a footer object with 2 columns
						// Left side: report creation date
						// Right side: current page and total pages
						doc['footer']=(function(page, pages) {
							return {
								columns: [
									{
										alignment: 'left',
										text: ['Created on: ', { text: jsDate.toString() }]
									},
									{
										alignment: 'right',
										text: ['page ', { text: page.toString() },	' of ',	{ text: pages.toString() }]
									}
								],
								margin: 2
							}
						});
						// Change dataTable layout (Table styling)
						// To use predefined layouts uncomment the line below and comment the custom lines below
						// doc.content[0].layout = 'lightHorizontalLines'; // noBorders , headerLineOnly
						var objLayout = {};
						objLayout['hLineWidth'] = function(i) { return .5; };
						objLayout['vLineWidth'] = function(i) { return .5; };
						objLayout['hLineColor'] = function(i) { return '#aaa'; };
						objLayout['vLineColor'] = function(i) { return '#aaa'; };
						objLayout['paddingLeft'] = function(i) { return 4; };
						objLayout['paddingRight'] = function(i) { return 4; };
						doc.content[0].layout = objLayout;
				}
            }
				],
						"ajax": "<?php echo URL;?>ubitech/expiredOrganization",
						"columns": [
						{ "data": "change"},
							{ "data": "orgName"},
							{ "data": "c_nmae" },
							{ "data": "email" },
							{ "data": "PhoneNumber"},
							
							{ "data": "country"},
							{ "data": "address"},
							{ "data": "rdate"},
							{ "data": "edate"},
							{ "data": "leadowner"},
							{ "data": "rating"},
							{ "data": "noemp"},
							{ "data": "userlimit"},
							
							{ "data": "pass" },
							{ "data": "note" },
						    { "data": "ref_no" },
							
							{ "data": "action"}
						]
					});
			 
					$(document).ready(function() {
    $.fn.dataTable.moment('DD-MM-YYYY');
    $('#example').DataTable();
});
			$(document).on("click", ".edit", function () {
				$('#editE_id').val($(this).data('id'));
				$('#org_nameE').val($(this).data('orgname'));
				$('#countryE').val($(this).data('country'));
				$('#emailE').val($(this).data('email'));	
				$('#phoneE').val($(this).data('phonenumber'));	
				$('#AddressE').val($(this).data('address'));  				
				$('#nameE').val($(this).data('name'));  				
			});
			
			$('#saveE').click(function(){
				// var org_nameE =  $("#org_nameE").val();
                // var countryE =  $("#countryE").val();
                // var emailE =  $("#emailE").val();
                // var phoneE =  $("#phoneE").val();
                // var AddressE =  $("#AddressE").val();
                // var nameE =  $("#nameE").val();
				// alert(org_nameE+" "+countryE+" "+emailE+" "+phoneE+" "+AddressE+" "+nameE);
				// return false;
			    $("#deptFromE").submit(); 
			});
			
		});
		
    	$(document).ready(function(){
		$("#save").click(function(){
			var org_name =  $("#org_name").val();
            var con_per_name =  $("#name").val();
            var org_email =  $("#email").val();
            var phone =  $("#phone").val();
            var country =  $("#country").val();
            var address =  $("#Address").val();
			var len = $("#phone").val().length;
			if(org_name == ""){
				doNotify('top','center',4,'Please enter organization name.');
				return false;
			}
			if(con_per_name == ""){
				doNotify('top','center',4,'Please enter contact person name.');
				return false;
			}
			if(org_email == ""){
				doNotify('top','center',4,'Please enter email.');
				return false;
			}
			if(phone == ""){
				doNotify('top','center',4,'Please enter phone no.');
				return false;
			}
			if(len < 8){
					  $('#phone').focus();
						doNotify('top','center',4,'Please enter the valid Phone ');
						return false;
				  }	if(isNaN($('#phone').val())){
					  $('#phone').focus();
						doNotify('top','center',4,'Phone  can contains digits only');
						return false;
				  }
			if(country == 0){
				doNotify('top','center',4,'Please select country.');
				return false;
			}
			if(address == ""){
				doNotify('top','center',4,'Please enter address.');
				return false;
			}
			if(!validateEmail(org_email.trim())){
					alert(org_email+' is not a valid mail id, please check');
					return false;
				  }
        function validateEmail(org_email) {
			var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(String(org_email).toLowerCase());
		}
			$("#deptFrom").submit();
				
			
		});
    	});

		<!-- for alert message (start) -->
		 $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
         $("#success-alert").slideUp(500);
        });
		<!-- alert message (end)-->
	
	</script>
	<script>
		
			$(document).ready(function(){
		$("#getval").change(function(){
		var conttype = $(this).children(":selected").attr("value");
		$("#example").dataTable().fnDestroy()
				 table=$('#example').DataTable( {
						"scrollY":"400px",
        				"scrollX":true,
        				"scrollCollapse":true,
        				//"paging":false,
        				
        			'columnDefs': [
       					{ targets:  [9,10,11,12,13], visible :false }
    					],
						"contentType": "application/json",
						"order": [[ 7, "desc" ]],
						dom: 'Bfrtip',
						"stateSave": true,
						// "stateDuration": 10,
						'columnDefs': [
       					{ targets: [13,12,9,10], visible :false }
    					],
						"lengthMenu": [[10, 25, 50,100,500,1000,-1],[10,25,50,100,500,1000,"All"]],
						buttons: [
							'pageLength','csv', 'excel','copy','print',
							{ 
							 "extend":'colvis', 
							 "columns":':not(:last-child)', 
							} 
,
                    {
                "extend": 'pdfHtml5',
                "orientation": 'landscape',
                "pageSize": 'legal',
                
                exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9,10,11,12]
                },
                customize: function (doc) {
						//Remove the title created by datatTables
						doc.content.splice(0,1);
						//Create a date string that we use in the footer. Format is dd-mm-yyyy
						var now = new Date();
						var jsDate = now.getDate()+'-'+(now.getMonth()+1)+'-'+now.getFullYear();
						// Logo converted to base64
						// var logo = getBase64FromImageUrl('https://datatables.net/media/images/logo.png');
						// The above call should work, but not when called from codepen.io
						// So we use a online converter and paste the string in.
						// Done on http://codebeautify.org/image-to-base64-converter
						// It's a LONG string scroll down to see the rest of the code !!!
						
						// A documentation reference can be found at
						// https://github.com/bpampuch/pdfmake#getting-started
						// Set page margins [left,top,right,bottom] or [horizontal,vertical]
						// or one number for equal spread
						// It's important to create enough space at the top for a header !!!
						doc.pageMargins = [20,60,20,30];
						// Set the font size fot the entire document
						doc.defaultStyle.fontSize = 7;
						// Set the fontsize for the table header
						doc.styles.tableHeader.fontSize = 7;
						// Create a header object with 3 columns
						// Left side: Logo
						// Middle: brandname
						// Right side: A document title
						doc['header']=(function() {
							return {
								columns: [
									
									{
										alignment: 'left',
										italics: true,
										 text: 'PDF Report',
										fontSize: 18,
										margin: [8,0]
									},
									{
										alignment: 'right',
										fontSize: 14,
										text: ' '
									}
								],
								margin: 2
							}
						});
						// Create a footer object with 2 columns
						// Left side: report creation date
						// Right side: current page and total pages
						doc['footer']=(function(page, pages) {
							return {
								columns: [
									{
										alignment: 'left',
										text: ['Created on: ', { text: jsDate.toString() }]
									},
									{
										alignment: 'right',
										text: ['page ', { text: page.toString() },	' of ',	{ text: pages.toString() }]
									}
								],
								margin: 2
							}
						});
						// Change dataTable layout (Table styling)
						// To use predefined layouts uncomment the line below and comment the custom lines below
						// doc.content[0].layout = 'lightHorizontalLines'; // noBorders , headerLineOnly
						var objLayout = {};
						objLayout['hLineWidth'] = function(i) { return .5; };
						objLayout['vLineWidth'] = function(i) { return .5; };
						objLayout['hLineColor'] = function(i) { return '#aaa'; };
						objLayout['vLineColor'] = function(i) { return '#aaa'; };
						objLayout['paddingLeft'] = function(i) { return 4; };
						objLayout['paddingRight'] = function(i) { return 4; };
						doc.content[0].layout = objLayout;
				}
            }
				                ],
						"ajax": "<?php echo URL;?>ubitech/expiredOrganization?conttype="+conttype,
						"columns": [
						{ "data": "change"},
							{ "data": "orgName"},
							{ "data": "c_nmae" },
							{ "data": "email" },
							{ "data": "PhoneNumber"},
							
							{ "data": "country"},
							{ "data": "address"},
							{ "data": "rdate"},
							{ "data": "edate"},
							{ "data": "leadowner"},
							{ "data": "rating"},
							{ "data": "noemp"},
							{ "data": "userlimit"},
							{ "data": "pass" },
							{ "data": "note" },
						    { "data": "ref_no" },
							{ "data": "action"}
						]
					});
			   });
			});
			  
			  
    //// not renewed js code
	$(document).on("click", ".notrenew", function () {
				$('#del_did1').val($(this).data('id'));
				$('#dna1').text($(this).data('orgname'));
				
				$('#notrenew').modal('show');
			});
			
			$(document).on("click", "#notrenewed", function () {
				var id=$('#del_did1').val();
				$.ajax({url: "<?php echo URL;?>ubitech/notrenedOrg",
						data: {"did":id},
						success: function(result){
							result=JSON.parse(result);
							if(result.afft){
								$('#notrenewed').modal('hide');
								doNotify('top','center',2,'Company Not Renewed successfully.');
								$('#notrenew').modal('hide');
								var table=$('#example').DataTable();
								 table.ajax.reload();
							}else{
								$('#notrenew').modal('hide');
								doNotify('top','center',4,'Unable to archive this company');
							}
						
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});
			
			
	</script>

	<script>
		var favorite = [];
function Allassign()
{
	if($('.checkbox:checked').length > 0)
	{
		$("#lead_name").val('0');
		$('#modelassign').modal('show');

		 favorite = [];
			$.each($("input[name='chk']:checked"), function(e)
			{
			favorite.push($(this).val());
			});
			
			// alert(favorite);
			

	}
	else
	{
		doNotify('top','center',3,'select atleast 1 organization');
		return false;
	}
}

	
	$(document).on("click", "#saveall", function (e)
				{
					var lead_name =  $("#lead_name").val();
		
			// alert(lead_name);
				$.ajax({url: "<?php echo URL;?>ubitech/updateleadownerorg",
						data: {"favorite":favorite,"lead_name":lead_name},
						success: function(result){
						//alert(result);
							if(result == 1)
							{
								$('#modelassign').modal('hide');
								doNotify('top','center',2,'Lead Owner Assign Successfully.'); 
								var table=$('#example').DataTable();
								 table.ajax.reload();
							}
						else
							doNotify('top','center',3,'Error occured, Try later.'); 
								},
						error: function(result)	
						{
							alert("error");
							doNotify('top','center',4,'Unable to connect API');
						}								
						});
				
			});
   //});
	
</script>
<script type="text/javascript" >

	$(function(){


   $(document).on("click", "#select_all", function (){
				
					if(this.checked){
						$('.checkbox').each(function(){
							this.checked = true;
						});
						
					}else{
						 $('.checkbox').each(function()
						 {
							this.checked = false;
							//this.checked = true;
							});
						}
						
				});

		});
		$(document).on("click", ".checkbox", function (){
			
						if($('.checkbox:checked').length == $('.checkbox').length)	
						{
							//alert($('.checkbox').length);
							//alert($('.checkbox:checked').length);
							$('#select_all').prop('checked',true);
						}
						else
						{
							$('#select_all').prop('checked',false);
						}
						});
			
			
		

     
   </script>

</html>
