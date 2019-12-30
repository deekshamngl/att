<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/fixedColumns.dataTables.min.css"/><link rel="stylesheet" href="<?=URL?>../assets/css/jquery.dataTables.min.css"/>
	<link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/bootstrap-select/css/bootstrap-select.css" />
	<!-- <link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" /> -->

	<title>ubiAttendance</title>
</head>
<body>

	<div class="wrapper">
		<?php
			$data['pageid']=33.2;
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

	                		<?php if($this->session->flashdata('success') == 'Notification Added successfully'){ 
	                     ?><script>
							doNotify('top','center',2,'Notification Added successfully');
						 </script>
							
                        <?php 
						}if($this->session->flashdata('success') == 'Notification updated successfully'){ ?>
						  <script>
							doNotify('top','center',2,'Notification updated successfully.');
						 </script>
						 <?php
						}
						 ?>

	                		<div class="card">
	                            <div class="card-header" data-background-color="purple">
	                                <h4 class="title">Automatic Notifications</h4>
	                                <!-- <p class="category">Push Notification</p> -->
	                            </div>

	                            <div class="card-content">
									<div id="typography">
										<div class="title">
											
										</div>

										<div class="row">
											<table id="example" class="display table" cellspacing="0" width="100%">
											<thead>
												<tr>
													<!-- <th style="background-image:none"!important><input type="checkbox" id="select_all" value=""/> </th> -->
													<th width="15%">Title</th>
													<th>Sub Title</th>
													<th>Image</th>
													<th>Event</th>
													
													
													
													<th>Action</th>
													
													
												  <!--  <th>Email Verification</th>-->
													
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

<footer class="footer">
				<div class="container-fluid">
					<p class="copyright pull-right">
						&copy; <script>document.write(new Date().getFullYear())</script> <a href="#">DESIGNED BY </a>Ubitech Solutions Pvt. Ltd.
					</p>
				</div>
			</footer>
		</div>
	</div>
</div>

	<!-- Modal open add sld img-->
<div id="addnot" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
	
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Add Notification</h4>
      </div>
      <div class="modal-body">
		<form  enctype="multipart/form-data" id="deptFrom" method="post" action="<?php echo URL;?>ubitech/do_upload"  >
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">Title <span class="red"> *</span></label>
						<input type="text" id="name" name="name" class="form-control  alpha"  >
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">Sub-title<span class="red"> *</span></label>
						<input type="text" id="desc" name="desc" class="form-control alpha" >
					</div>
				</div>
			</div>
		</div>
		<div class="row">
				<div class="col-md-12">
					 <div class="col-md-6">
					<div class="form-group">
						<label class="control-label">image(1038*1038)</label>
						<input type="file" id="img" name="userfile" class="form-control" >
					</div>
				</div>
				<div class="col-md-6">
					<?php 
					$today= Date('Y-m-d');


					?>
					<div class="form-group">
						<label class="control-label">Date<span class="red"> *</span></label>
						<input type="date" id="dos" name="dos" class="form-control numeric" min="<?php echo $today ?>" VALUE="<?php echo $today ?>">
					</div>
				</div>
			</div>
		</div>

		<div class="row">
				<div class="col-md-12">
					 <div class="col-md-6">
					<div class="form-group">
						<label class="control-label">Organization<span class="red"> *</span></label>
						<select id="orga" class="form-control" name="orga">
						<option value="0">All Organization</option>
						<option value="1">Trial Organization</option>
						<option value="2">Extended Trial Organization</option>
						<option value="3">Expired Trial Organization</option>
						<option value="4">Premium Standard</option>
						<option value="5">Premium Customised</option>
						<option value="6">Premium Expired</option>
						<option value="7">Exceeded User Limit</option>

						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">Countries<span class="red"> *</span></label>

					<select id="county" style="height:35px;position:relative;" class="form-control selectpicker" name="county[]" multiple data-hide-disabled="true" data-live-search="true" data-actions-box="true" >
							<!-- <option value="0" selected>All Countries</option> -->
								<?php
								$data= json_decode(getAllCountries($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++){
									echo '<option  value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								}?>
							</select>
						</div>
					</div>

			</div>
			</div>
				<div class = "row">
					<div class="col-md-12">
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">Generate Promo Code</label>
					<input type="radio" id="promo" name="promo" >

				</div>
					
					
				</div>
			</div>
		</div>
				<div id="hide">
			  <div class="row" >
				<div class="col-md-12">
					 <div class="col-md-6">
					<div class="form-group">

						<label class="control-label">Enter Promo Code<span class="red"> *</span></label>
						<input type="text" id="enterpromo" name="enterpromo" class="form-control alpha" >
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">Offer Start<span class="red"> *</span></label>
						<input type="date" id="sdate" name="sdate" class="form-control alpha" min="<?php echo $today ?>" >
					</div>
				</div>

			</div>
		</div>


		<div class="row">
				<div class="col-md-12">
					 <div class="col-md-6">
					<div class="form-group">

							<label class="control-label">Offer End <span class="red"> *</span></label>
						<input type="date" id="edate" name="edate" class="form-control alpha" min="<?php echo $today ?>" >
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">Discount In<span class="red"> *</span></label>
						<select id="discounttype" name="discounttype">
						<option value="PERCENT">percentage(%)</option>
						<option value="INR">INR</option>
						<option value="USD">USD</option>
					</select>
					</div>
				</div>

			</div>
		</div>


			<div class="row">
				<div class="col-md-12">
					<div class="col-md-6">
						<div class="form-group">
						<label class="control-label">Discount<span class="red"> *</span></label>
						<input type="number" id="discount" name="discount" class="form-control alpha" >
					</div>
				</div>




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
<div id="addnot1" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
	
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Add Notification</h4>
      </div>
      <div class="modal-body">		
		<form>
			<input type="hidden" id="del_id" />
			<div class="row">
				<div class="col-md-12">
					
					<h4>Delete "<span id="na"></span>" Notification? </h4>
					
				</div>
			</div>
			
			<div class="clearfix"></div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="delete1"  class="btn btn-danger" >Delete</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	
    </div>
  </div>
</div>

<!---modal close--->

<!------Edit slider modal start------------>
<div id="addnotE" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
	
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Edit Notification</h4>
      </div>

      <input type="text" class="hidden" id="id" name="id" />
      <div class="modal-body">
		<form id="deptFromE" method="post" >
		<input type="text" class="hidden" id="id" name="id" />
			
		<div class="row">
				<div class="col-md-12">
					
					<div class="form-group ">
						<label class="control-label">Title <span class="red"> *</span></label>
						<input type="text" id="nameE" name="nameE" class="form-control" >
					</div>
					<div class="form-group ">
						<label class="control-label">Sub-title<span class="red"> *</span></label>
						<input type="text" id="descE" name="descE" class="form-control" >
					</div>
					
					

					<div class="form-group ">
						<label class="control-label">image
						 </label>

						<input type="file" id="imgE" name="imgE" class="form-control" >
					</div>
					
					
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
<div id="del123" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
	
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Edit Notification</h4>
      </div>

      <input type="text" class="hidden" id="id" name="id" />
      <div class="modal-body">
		
		
      </div>
      <div class="modal-footer">
        <button type="button" id="saveE"  class="btn btn-success" >Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	
    </div>
  </div>
</div>







</body>
<script type="text/javascript" src="<?=URL?>../assets/bootstrap-select/js/bootstrap-select.js"></script>
   	<script src="<?=URL?>../assets/js/dataTables.buttons.min.js"></script>
   	<!-- <script type="text/javascript" src="<?=URL?>../assets/js/moment.js"></script> -->
 	<script type="text/javascript" src="<?=URL?>../assets/js/buttons.print.min.js"></script>
	<script src="<?=URL?>../assets/js/buttons.colVis.min.js"></script>
	<script type="text/javascript" src="<?=URL?>../assets/js/pdfmake.min.js"></script>
	<script src=" https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js
"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script type="text/javascript" src="<?=URL?>../assets/js/buttons.html5.min.js"></script>
  	<script type="text/javascript" src="<?=URL?>../assets/js/dataTables.fixedColumns.min.js"></script>
   <!--  <script type="text/javascript" src="<?=URL?>../assets/js/daterangepicker.js"></script> -->
    <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"> </script> -->

	<!-- <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.15/sorting/datetime-moment.js"> </script> -->

	<!-- <script language="javascript">
    $(document).ready(function () {
        $("#dos").datepicker({
            format: 'yyyy-mm-dd',
            minDate: 0,
            
        });
    });
</script> -->
<script>

$(document).ready(function() {
    $("#hide").hide();
			
});
	
var checked= false;
		$(document).on("click", "#promo", function (){
				if(checked==false){

					checked=true;

				}
				else{
					checked=false;
				}
			// document.getElementById("desc").disabled = true;

			// $("#desc").disable();
			// $("#desc").prop("disabled", true);
			$("#desc").prop("readonly", true);
			$("#hide").show();


		});
	
</script>
	<script type="text/javascript">


var table;
		$(function()
		{
			$("#example").dataTable().fnDestroy();
			// $("#example").dataTable().fnClearTable();
			 table=$('#example').DataTable({
						//"scrollY":"400px",
        				"scrollX":true,

        				//"scrollCollapse":true,
        				//"fixedColumns":   {
            			// leftColumns: 1,
            			// rightColumns:1
        				//},
        			'columnDefs': [
       					
    					],
						"contentType": "application/json",
						"order": [[ 0, "asc" ]],
						dom: 'Bfrtip',
						"stateSave": true,
						//"target":5,
						// "stateDuration": 10,
					
						"lengthMenu": [[10, 25, 50,100,500,1000,-1],[10,25,50,100,500,1000,"All"]],
						buttons: [
					'pageLength','csv', 'excel','copy','print',
					{ 
                     "extend":'colvis', 
                     //"columns":':not(:last-child)', 
                    } ,
                    {
                "extend": 'pdfHtml5',
                "orientation": 'landscape',
                "pageSize": 'legal',
                
                exportOptions: {
                    columns: [0,1,2,3,4,5]
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
						"ajax": "<?php echo URL;?>ubitech/getautomaticdata",
						"columns": [
						
							{ "data": "name"},
							{ "data": "desc" },
							{ "data": "img" },
							
							{ "data": "event"},
							{ "data": "action"},
						]
					});
// 			 $(document).ready(function() {
//     $.fn.dataTable.moment('DD-MM-YYYY');
//     $('#example').DataTable();
// });
					
			// $(document).on("click", ".edit", function () {
			// 	$('#editE_id').val($(this).data('id'));
			// 	$('#org_nameE').val($(this).data('orgname'));
			// 	$('#countryE').val($(this).data('country'));
			// 	$('#emailE').val($(this).data('email'));	
			// 	$('#phoneE').val($(this).data('phonenumber'));	
			// 	$('#AddressE').val($(this).data('address'));  				
			// 	$('#nameE').val($(this).data('name'));  				
			// });
			
			// $('#saveE').click(function(){
				// var org_nameE =  $("#org_nameE").val();
                // var countryE =  $("#countryE").val();
                // var emailE =  $("#emailE").val();
                // var phoneE =  $("#phoneE").val();
                // var AddressE =  $("#AddressE").val();
                // var nameE =  $("#nameE").val();
				// alert(org_nameE+" "+countryE+" "+emailE+" "+phoneE+" "+AddressE+" "+nameE);
				// return false;
			    // $("#deptFromE").submit(); 
			// });
			
		});

    	
		$("#save").click(function(){
			
			var d = new Date();

			var month = d.getMonth()+1;
			var day = d.getDate();

			var today = d.getFullYear() + '/' +
    		(month<10 ? '0' : '') + month + '/' +
    			(day<10 ? '0' : '') + day;

    			// alert(today);
			var name =  $("#name").val();
            var desc =  $("#desc").val();
            var img =  $("#img").val();
            var dos=  $("#dos").val();
            var county=  $("#county").val();
            var sdate=  $("#sdate").val();
            var edate=  $("#edate").val();
            // alert(dos);

      

            if($('#name').val()==''){
					  $('#name').focus();
						doNotify('top','center',4,'Please enter name.');
						return false;
						
				  }



				   if($('#desc').val()==''){
					  $('#desc').focus();
						doNotify('top','center',4,'Please enter description.');
						return false;
						
				  }

				  

				  if($('#dos').val()==''){
					  $('#dos').focus();
						doNotify('top','center',4,'Please enter sending date.');
						return false;
						
				  }

				  if($('#county').val()==''){
					  $('#county').focus();
						doNotify('top','center',4,'Please select country.');
						return false;
						
				  }

				  if(checked==true){
				  	      if($('#enterpromo').val()==''){
					  $('#enterpromo').focus();
						doNotify('top','center',4,'Please enter promo code.');
						return false;
						
				  }


				  	if($('#edate').val()==''){
					  $('#edate').focus();
						doNotify('top','center',4,'Please enter end date.');
						return false;
						
				  }

				  if($('#sdate').val()==''){
					  $('#sdate').focus();
						doNotify('top','center',4,'Please enter start date.');
						return false;
						
				  }

				  if($('#discount').val()==''){
					  $('#discount').focus();
						doNotify('top','center',4,'Please select discount.');
						return false;
						
				  }

				  if(sdate > edate){

				  	doNotify('top','center',4,'offer start date cannot be greater than offer end date');
						return false;
				  }

				  }


            $("#deptFrom").submit();

           


		});

		<!-- for alert message (start) -->
		 $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
         $("#success-alert").slideUp(500);
        });
		<!-- alert message (end)-->

	
		$(document).on("click", ".edit", function (){


			$('#id').val($(this).data('id'));
			$('#nameE').val($(this).data('name'));
			$('#descE').val($(this).data('desc'));
			
			$('#dosE').val($(this).data('dos'));
			$('#imgE').val($(this).data('img'));

				alert($(this).data('dos'));
				// alert($(this).data('img'));

			});

		$('#saveE').click(function(){

			var name=$('#nameE').val().trim();
			var id=$('#id').val();
			var desc=$('#descE').val();
			// var dos=$('#dosE').val();
			var img = $('#imgE').prop('files')[0];
			// var img=$('#imgE').val();
			// alert(img);


			if(name==''){

				doNotify('top','center',4,'Please enter name');
						return false;
			}
			if(desc==''){

				doNotify('top','center',4,'Please enter Description');
						return false;
			}

			if(dos==''){

				doNotify('top','center',4,'Please select date');
						return false;
			}
			
			
			

			var  formdata = new FormData();
			formdata.append('name',name);
			// formdata.append('dos',dos);
			formdata.append('desc',desc);
			formdata.append('imgE',img);
			formdata.append('id',id);


				   $.ajax({
					   processData: false,
					contentType: false,
					url: "<?php echo URL;?>ubitech/editautomatic",
					data: formdata, //,"email":email
					datatype:"text",
					 type:"post",

					 success: function(result)
				   {

				   	if(result == 1){
						$('#addnotE').modal('hide');
						 doNotify('top','center',2,'Notification updated Successfully'); 
						 table.ajax.reload();  
					  }
					  else
						doNotify('top','center',3,'Error occured, Try later.'); 
					}
					});
			});

		$(document).on("click", ".deletee", function () {
			// alert();
			$('#delnotE').modal('toggle');
			$('#del_id').val($(this).data('id'));
			$('#na').text($(this).data('name'));


			});

		// $(document).on("click", "#delete1", function (){

		// 	var id=$('#del_id').val();

		// 	// alert(id);
		// 	// die;

		// 	$.ajax({url: "<?php echo URL;?>ubitech/deletenotification",
		// 				data: {"sid":id},
		// 				success: function(result){
							
		// 					if(result == 1){
		// 						 $('#addnot1').modal('hide');
		// 						 doNotify('top','center',2,'Notification Deleted Successfully.'); 
		// 						 table.ajax.reload();  
		// 			        }
		// 			        },
		// 				error: function(result){
		// 					doNotify('top','center',4,'Unable to connect API');
		// 					$('#addnot1').modal('hide');
		// 				 }
		// 		   });
		// 	});
			
		
			

	</script>

<script>
 $(".selectpicker").selectpicker({
         size: 4,
    });
</script>
</html>