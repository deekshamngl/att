<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Punched Locations</title>
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" />
	<style>

  .card .table tfoot tr:first-child td {
     border-top: 1px solid black !important;
}
		.red{
			color:red;
			font-weight:'bold';
			font-size:16px;
		}
		.delete{
			cursor:pointer;
		}
		td{
			   // width: 7%!important;
				///text-align: center!important;
				max-width:250px;
				word-wrap:break-word;
		}
		
		#content {
			
			-webkit-transition: width 0.3s ease;
			-moz-transition: width 0.3s ease;
			-o-transition: width 0.3s ease;
			transition: width 0.3s ease;
		}
		#content .btn-group {
			margin-bottom: 10px;
		}
		.col-md-9 .width-12,
		.col-md-12 .width-9 {
			display: none; /* just hiding labels for demo purposes */
		}
		#sidebar {
			
			-webkit-transition: margin 0.3s ease;
			-moz-transition: margin 0.3s ease;
			-o-transition: margin 0.3s ease;
			transition: margin 0.3s ease;
		}
		.collapsed {
			display: none; /* hide it for small displays */
		}
		@media (min-width: 992px) {
			.collapsed {
				display: block;
				margin-right: -25%; /* same width as sidebar */
			}
		}
		.t2{display:none;}
	</style>
</head>
<body>
	<div class="wrapper">
		<?php
			$data['pageid']=0;
			$this->load->view('menubar/sidebar',$data);
		?>
	    <div class="main-panel">
			<?php
				$this->load->view('menubar/navbar');
			?>
			</br>
			<div class="content" id="content">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-md-12">
	                        <div class="card">
	                            <div class="card-header" data-background-color="green">
	                                <h4 class="title">Employee(s) Visits</h4>
									 <p class="category"> List of visits </p>
	                            </div>
								
	                            <div class="card-content">
									<div id="typography">
										<div class="title">
											<div class="row">
												<div class="col-md-8">
												<h4><?php echo ' Visits by <b>'.$name.'</b> on <b>' .date("d-m-Y", strtotime($date)).'</b>'; ?></h4>
												</div>
												<div class="col-md-4">
											
											</div>
											<!-- <?php var_dump($arr['name']); ?>  -->
											<!-- <a rel="tooltip"  data-placement="bottom" title="Help" class="btn btn-success btn-sm pull-right toggle-sidebar">
											<i class="fa fa-question"></i></a> -->
										</div>
							<?php //print_r($detail);?>			
										<div class="row" style="overflow-x:scroll;">
											<table id="example" class="display table"  width="100%">
											<thead>
												<tr>
													<th style="width:1px"><b>S.No</b></th>
													<th><b>Client</b></th>
													<th><b>Visit In Image</b></th>
													<th><b>Visit In</b></th>
													<th><b>Visit In Location</b></th>
													<th><b>Visit Out Image</b></th>
													<th><b>Visit Out</b></th>
													<th><b>Visit Out Location</b></th>
													<th><b>Visit Hours</b></th>
													<!-- <th width="15%"><b>Client</b></th> -->
													<th><b>Remarks</b></th>
													
												</tr>
											</thead>
											<tbody>
												     <!-- <?php var_dump($detail); ?>   -->
												
													<?php 
													// $i=1;
													 foreach ($detail as $details) { ?> 
													 	 
														  
													 <tr>

													
													
											
													 <td><?=  $details['sno']; ?></td>
													 <td> <?=  $details['client'];?> </td>

													  <td> <?= $details['inimg'];?> </td>

													    <td><?= $details['tif'];?></td>

													  <td><?= $details['inloc'];?></td>

													  <td><?= $details['otimg'];?></td>

													  <td><?= $details['tof'];?></td>

													  <td><?= $details['outloc'];?></td>


													<td>
														<?= $details['workhr'];?>
														 </td>
														 <td><?= $details['desc'];?></td>
														 </tr>
														<?php } ?> 
												

												
											</tbody>

											<tfoot style="display:none">
												<tr style="background-color:#ddd;">
													
													<td  style="font-weight:bold;">Name:  <?php echo $name; ?></td>
													
													<td  style="font-weight:bold;">Time In:  <?php echo $ti; ?></td>
											
													<td   style="font-weight:bold;">Time Out:    <?php echo $to; ?> </td>
												
													<td   style="font-weight:bold;">Total  Worked Hours:<?php echo $wh; ?> </td>

													

													
													 <!--  <?php
													// $i=1; 													foreach($detail as $row) 													 echo '<td colspan="3"  style="font-weight:bold;">Total visit Hours:   '.substr($row->twh,0,5).' </td>'; 
													 ?> 
 -->
													<!-- <td colspan="3"  style="font-weight:bold;padding: 0px;">Total visit Hours:  <?php echo $twh; ?>  </td> -->
												
													
												
													
											
													
												</tr>
											</tfoot>
<tfoot>
												<tr style="background-color:#ddd;">
													
													<td colspan="3" style="font-weight:bold;">Name:  <?php echo $name; ?></td>
													
													<td colspan="2" style="font-weight:bold;">Time In:  <?php echo $ti; ?></td>
											
													<td colspan="2"  style="font-weight:bold;">Time Out:    <?php echo $to; ?> </td>
												
													<td colspan="3"  style="font-weight:bold;">Total  Worked Hours:<?php echo $wh; ?> </td> 

													
													 <!--  <?php
													// $i=1; 											foreach($detail as $row) 													 echo '<td colspan="3"  style="font-weight:bold;">Total visit Hours:   '.substr($row->twh,0,5).' </td>'; 
													 ?> 
 -->
													<!-- <td colspan="3"  style="font-weight:bold;padding: 0px;">Total visit Hours:  <?php echo $twh; ?>  </td> -->
												
													
												
													
											
													
												</tr>
											</tfoot>
										</table>
										</div>
										
										 
										<!-- ===== -->
									</div>

	                            </div>

	                        </div>
	                        <h3 style="text-align:left;padding-left: 8px;margin-top:0px"> Location Visited </h3>
							<div id="map" style="height:450px !important;margin-top:10px;"></div>
	                    </div>
	                </div>

	            </div>
	        </div>
	        </div>

	        <!-- my code for map -->
	      
		
		
	
 

	        <!-- end my code for map -->


	        <div class="col-md-3 t2" id="sidebar" style=" margin-top:100px;">

			</div>
			
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
<!------Edit attendance modal start------------>
<div id="addAttE" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Update Attendance</h4>
      </div>
      <div class="modal-body">
        
		<form id="AttFrom">
			<input type="hidden" id="id" />
			<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating">
					<label>Name</label>
						<input type="text" readonly='true' placeholder="Employee Name"  id="attNameE" class="form-control" >
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating">
					<label>Date</label>
						<input placeholder="Attendance Date" readonly='true' type="text" id="attDateE"  class="form-control" >
					</div>
				</div>
			</div>
			<div class="row">
				
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Shift</label>
						<select class="form-control" id="shiftE" >
							<?php
							$data= json_decode(getAllShift($_SESSION['orgid']));
							for($i=0;$i<count($data);$i++)
								echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
							?>
						</select>
						
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Status</label>
						<select class="form-control" id="statusE" >
							<option value='1'>Present</option>
							<option value='0'>Absent</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating">
					<label>Time In</label>
						<input type="text" placeholder="Time In" id="timeInE"  class="form-control timepicker">
					</div>
				</div>
				
				<div class="col-md-6">
					<div class="form-group label-floating">
					<label>Time Out</label>
						<input type="text" placeholder="Time Out" id="timeOutE"   class="form-control timepicker" >
					</div>
				</div>
			</div>
			<div class="row">
				
				
			</div>
			<div class="clearfix"></div>
		</form>
		
		
		
      </div>
      <div class="modal-footer">
        <button type="button" id="saveE"  class="btn btn-success">Update</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!------Edit attendance modal close------------>
<!-----delete attendance start--->
<div id="delAtt" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
        <h4 class="modal-title" id="title">Delete Attendance</h4>
      </div>
      <div class="modal-body">		
		<form>
			<input type="hidden" id="del_aid" />
			<div class="row">
				<div class="col-md-12">
					<h4>Are you sure want to delete <span id="ana"></span>'s Attendance  ?</h4>
				</div>
			</div>
			<div class="clearfix"></div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="delete"  class="btn btn-danger">Delete</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-----delete Attn close--->

<!------image modal ----->
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-dialog" >
    <div class="modal-content"> 
      <div class="modal-body">
      	<button type="button" class="close" data-dismiss="modal" style="color:black"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<form id="imgE" method="POST" enctype="multipart/form-data" name="myformE">
		<input type="hidden" id="imgid">
        <img src="" class="imagepreview" style="width:550px!important;height:500px!important;" 
id="profileimg" >
      </div>
		<div class="modal-footer">
            <button type="button" id="setprofile"  class="btn btn-success">Set as Profile</button>
		</div>
	   </form>
    </div>
  </div>
</div>
		<!----------->
</body>

	<script src="<?=URL?>../assets/js/buttons.colVis.min.js"></script>
	<script src="<?=URL?>../assets/js/dataTables.buttons.min.js"></script>
	 <script type="text/javascript" src="<?=URL?>../assets/js/moment.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/daterangepicker.js"></script>
	  
      <script type="text/javascript" src="<?=URL?>../assets/js/buttons.flash.min.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/jszip.min.js"></script>
		 <script type="text/javascript" src="<?=URL?>../assets/js/jquery.dataTables.min.js"></script>
	    <script type="text/javascript" src="<?=URL?>../assets/js/buttons.html5.min.js"></script>
		<script type="text/javascript" src="<?=URL?>../assets/js/buttons.print.min.js"></script>

	<script>
		$(document).ready(function(){
			$('#example').DataTable({
				 dom: 'Bfrtip',
				 buttons: [
							  { extend: 'excelHtml5', footer: true },
						  ],
					  	  
			
		"language": {"emptyTable":"No Location Punched"},
                                     });
	
		$('.toggle-sidebar').click(function(){
		$("#sidebar").toggleClass("collapsed t2");
		$("#content").toggleClass("col-md-9");
		$("#sidebar").load('<?=URL?>admin/helpNav',{'pageid': 'attendanceH'});	
		});
	
		});
	</script>
	<script>
              var data = <?php echo json_encode($detail);  ?>;
              // console.log(data);
              // alert(data);
              

          function initMap() {
  if(data.length <= 0)
  {
  $("#map").hide();
  return false;
  }
/*var locations = [
// ['location' , 'Lat' , ' long' ];
  ['Location One', 26.2019377, 78.2006305999, 0],
  ['Location two', 26.2018377, 78.2106305999, 2],
  ['Location three', 26.201377, 78.180630999, 3],
  ['Location four', 26.2019377, 78.17063099, 4],
  ['Location five', 26.2229377, 78.190130999, 5],
  ['Location six', 26.2317377, 78.190631599, 6],
  ['Location seven', 26.2819477, 78.190615999, 7],
];*/


			var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 15,
			center: new google.maps.LatLng(data[0]['latit_out'], data[0]['longi_out']),
			// center : {lat:26.196817 , lng:78.1970886},
			mapTypeId: google.maps.MapTypeId.ROADMAP
			});


				
			var infowindow = new google.maps.InfoWindow({});

			var marker, i;

			for (i = 0; i < data.length; i++) {
				// console.log(data[i].inloc);
			// for timein location
			marker = new google.maps.Marker({
			position: new google.maps.LatLng(data[i]['latit'], data[i]['longi']),
			// position : {lat:26.196817 , lng:78.1970886},
			map: map,
			icon: {
			url:'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+(i+1)+'|FF0000|000000',
			scaledSize: new google.maps.Size(40, 40),
			}
			//icon: "http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld="+(i+1)+"
			// (in)|FF0000|000000",
			});
		google.maps.event.addListener(marker, 'click', (function (marker, i) {
		return function ()
		{
		infowindow.setContent(data[i]['location']);
		infowindow.open(map, marker);
		}
				})(marker, i));
//alert(data[i]['latit'], data[i]['longi']);
// for timeout location
		/*marker = new google.maps.Marker({
		position: new google.maps.LatLng(data[i]['latit_out'], data[i]['longi_out']),
		map: map,
		icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+(i+1)+'|FE6256|000000'
//icon: "http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld="+(i+1)+"
// (out)|FF0000|000000",
		});
		google.maps.event.addListener(marker, 'click', (function (marker, i) {
		return function () {
		infowindow.setContent(data[i]['location_out']);
		infowindow.open(map, marker);
		}
		})(marker, i));*/
}
}
</script>
   
   
    <script async defer 
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYh77SKpI6kAD1jiILwbiISZEwEOyJLtM&libraries=places&callback=initMap"
         >
         	
         </script>

         <script>
         	$(document).on("click", ".pop",function ()
			{
				
				$('#imgid').val($(this).data('id'));
			//	$('#profileimg').val($(this).data('enimage'));
			//	alert($(this).data('enimage'));
			$('.imagepreview').attr('src', $(this).find('img').attr('src'));
				$('#imagemodal').modal('show');   
			});
	
	$('#setprofile').click(function(){
      var id=$('#imgid').val();
	 // alert($('#profileimg').prop("files")[0]);
	 var imgg=$('#profileimg').attr('src');
	
		var  formdata = new FormData();
		  formdata.append('profimg',imgg);
		  formdata.append('id',id);
    
      $.ajax({
		processData: false,
		contentType: false,
		url: "<?php echo URL;?>admin/editimg",
    	data: formdata,
		datatype:"json",
		type:"post",
    	success: function(result){
    		if(result==1)
			{
    			datestring='&date='+$('#reportrange').text();
    			doNotify('top','center',2,'Set as Profile Picture');
				$('#imagemodal').modal('hide');  
    			 $('#example').DataTable().ajax.reload();
    		}
			else
			{
    			doNotify('top','center',4,'can not be updated.');
    		}
    		
    	 },
    	error: function(result)
			{
				doNotify('top','center',4,'Unable to connect API');
			}
      });
    }); 
	</script>
</html>
