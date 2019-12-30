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
     <!-----delete org start--...///its js code is in navbar.php////-->
<div id="delOrg_p" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title">Delete Company</h4>
      </div>
      <div class="modal-body">		
		<form>
			<input type="hidden" id="del_did_p" />
			<div class="row">
				<div class="col-md-12">
					<h4>Delete the Company data "<span id="dna_p"></span>"?</h4>
				</div>
			</div>
			<div class="clearfix"></div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="delete_p"  class="btn btn-danger">Delete<i class=" fa fa-circle-o-notch fa-spin wait" style="display:none;"></i></button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
  
</div>
<!-----delete org close---> 


<!------Unarchive--------->
<div id="archOrg" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Unarchive Company</h4>
      </div>
      <div class="modal-body">		
		<form>
			<input type="hidden" id="del_did_U" />
			<div class="row">
				<div class="col-md-12">
					<h4>Unarchive the Company data "<span id="dna_U"></span>"?</h4>
				</div>
			</div>
			<div class="clearfix"></div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="unarchive"  class="btn btn-danger">Unarchive</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div> 
  </div> 
</div>
<!--------------->
<div id="modaldelete" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Delete Company</h4>
      </div>
      <div class="modal-body">		
		<form>
			<div class="row">
				<div class="col-md-12">
					<h4>Delete the Company data?</h4>
				</div>
			</div>
			<div class="clearfix"></div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="deleteall"  class="btn btn-danger">Delete</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div> 
  </div> 
</div>


 
	<div class="wrapper">
		<?php
			$data['pageid']=3.8;
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
	                                <h4 class="title">Archived Organizations</h4>
	                                <p class="category">Organization Settings</p>
	                            </div>
	                            <div class="card-content">
									<div id="typography">
										<div class="title">
											<div class="row">
											<div class="col-md-3">
													
											</div>	
											<div class="col-md-2">
													
												</div>
											<div class="col-sm-2" style="margin-top:-20px;">
												<select id="getval" class="form-control">
													<option value="">All Countries</option>
													<option value="1">International</option>
													<option value="2">National</option>
												</select>
											</div>
											<div class="col-sm-3" style="margin-top:0px;">
													<button class="btn btn-sm btn-primary" data-toggle="modal"  type="button"	onclick="Allassign();" style="margin-top:10px;margin-left: -22px"><i class="fa fa-plus"> Assign Lead Owner</i>
													</button>	
												</div>
											
											<div class="col-sm-2 text-right">
													<button class="btn btn-sm btn-primary" data-toggle="modal"  type="button"	onclick="Alldelete();" ><i class="fa fa-trash"> Delete</i>
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
													<th>City</td>
													<th width="80" >plan Start</th>
													
													<th width="80" >plan End</th>
													<th>Lead Owner</th>
													<th>Rating</th>
													<th>Registered Users</td>
													
												
													<th>Password</th>
													<th>CRN</th>
													<th>Remarks</th>
													
												  <!--  <th>Email Verification</th>-->
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
  // $(function{
  var favorite = [];
function Alldelete()
{
	if($('.checkbox:checked').length > 0)
	{
		$('#modaldelete').modal('show');
		 favorite = [];
			$.each($("input[name='chk']:checked"), function(e)
			{
			favorite.push($(this).val());
			});
	}
	else
	{
		doNotify('top','center',3,'select atleast 1 employee to unarchive');
		return false;
	}
}

	
	$(document).on("click", "#deleteall", function (e)
				{
				$.ajax({url: "<?php echo URL;?>ubitech/DeleteAllOrg",
						data: {"favorite":favorite},
						success: function(result){
						//alert(result);
							if(result == 1)
							{
								$('#modaldelete').modal('hide');
								doNotify('top','center',2,'Company delete successfully.'); 
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
   
	<script type="text/javascript">
	    var table;
		$(function(){
			 table=$('#example').DataTable({
						"scrollY":"400px",
        				"scrollX":true,
        				"scrollCollapse":true,
        				// "fixedColumns":   {
            // 			 leftColumns: 1,
            // 			 rightColumns:1
        				// },
        			'columnDefs': [
       					{ targets: [10,9,11,12,13], visible :false }
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
                    columns: [1,2,3,4,5,6,7,8,9,10,11,12,13]
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
						"ajax": "<?php echo URL;?>ubitech/archived",
						"columns": [
							{ "data": "change"},
							{ "data": "orgName"},
							{ "data": "c_nmae" },
							{ "data": "email" },
							{ "data": "PhoneNumber"},
							
							{ "data": "country"},
							{ "data": "address"},
							{ "data": "rdate"},
							
							//{ "data": "sdate"},
							{ "data": "edate"},
							{ "data": "leadowner"},
							{ "data": "rating"},
							{ "data": "noemp"},
							//{ "data": "sstts"},
							{ "data": "ref_no" },
							{ "data": "pass" },
							{ "data": "note" },
							//{ "data": "emailstatus"},
							{ "data": "action"}
						]
					});
					
					
		
						$(document).ready(function() {
    $.fn.dataTable.moment('DD-MM-YYYY');
    $('#example').DataTable();
});
						
						
			$("#getval").change(function(){
				
			var conttype = $(this).children(":selected").attr("value");	
			//alert(conttype);
			$("#example").dataTable().fnDestroy()
			 table=$('#example').DataTable( {
						"scrollX": true,
						"contentType": "application/json",
						"order": [[ 6, "desc" ]],
						dom: 'Bfrtip',
						"stateSave": true,
						// "stateDuration": 10,
						"lengthMenu": [[10, 25, 50,100,500,1000,-1],[10,25,50,100,500,1000,"All"]],
						'columnDefs': [
       					{ targets: [10,9,11,12,13], visible :false }
    					],
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
                    columns: [1,2,3,4,5,6,7,8,9,10,11,12,13]
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
						"ajax": "<?php echo URL;?>ubitech/archived?conttype="+conttype,
						"columns": [
							{ "data": "change"},
							{ "data": "orgName"},
							{ "data": "c_nmae" },
							{ "data": "email" },
							{ "data": "PhoneNumber"},
							
							{ "data": "country"},
							{ "data": "address"},
							{ "data": "rdate"},
							
							//{ "data": "sdate"},
							{ "data": "edate"},
							{ "data": "leadowner"},
							{ "data": "rating"},
							{ "data": "noemp"},
							//{ "data": "sstts"},
							{ "data": "ref_no" },
							{ "data": "pass" },
							{ "data": "note" },
							//{ "data": "emailstatus"},
							{ "data": "action"}
						]
					});
			
			});	
			
			
			
			//////////del org permanently
			$(document).on("click", ".delete_p", function () 
			{
				$('#del_did_p').val($(this).data('id'));
				$('#dna_p').text($(this).data('orgname'));
				$('#delOrg_p').modal('show');
			});
			$(document).on("click", "#delete_p", function () {
				var id=$('#del_did_p').val();
				$('.wait').show();
				$.ajax({url: "<?php echo URL;?>ubitech/archiveOrg_del",
						data: {"did":id},
						success: function(result){
							result=JSON.parse(result);
							if(result.afft){
								$('.wait').hide();
								$('#delOrg_p').modal('hide');
								doNotify('top','center',2,'Company Deleted successfully.');
								var table=$('#example').DataTable();
								 table.ajax.reload();
							}else{
								$('.wait').hide();
								$('#delOrg_p').modal('hide');
								doNotify('top','center',4,'Unable to delete this company');
							}
						
						 },
						error: function(result){
							$('.wait').hide();
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});
			//////////unarchieve org permanently
			
		
				$(document).on("click", ".delete_a", function () {
				$('#del_did_U').val($(this).data('id'));
				$('#dna_U').text($(this).data('orgname'));
				$('#archOrg').modal('show');
			});
			$(document).on("click", "#unarchive", function () {
				var id=$('#del_did_U').val();
				$.ajax({url: "<?php echo URL;?>ubitech/unarchiveOrg",
						data: {"did":id},
						success: function(result){
							
							result=JSON.parse(result);
							
							if(result.afft){
									$('#archOrg').modal('hide');
								doNotify('top','center',2,'Company unarchived successfully.');
							
								var table=$('#example').DataTable();
								 table.ajax.reload();
							}else{
								$('#unarchive').modal('hide');
								doNotify('top','center',4,'Unable to unarchive this company');
							}
						
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
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
</html>
