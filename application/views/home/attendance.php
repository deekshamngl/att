<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<link href="<?=URL?>../assets/css/bootstrap-timepicker.min.css" rel="stylesheet"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Present Employee</title>
    <link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/jquery-ui.css" />
	<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
    <style>
	
      $query = $this->db->query("SELECT `Id`,  `Shift`  FROM ` EmployeeMaster`  WHERE OrganizationId=? AND `Id` Not IN(SELECT `EmployeeId` FROM `AttendanceMaster` ) ",array($orgid)); 
      .red{
      color:red;
      font-weight:'bold';
      font-size:16px;
      }
      .delete
	  {
      cursor:pointer;
      }
      div.dt-buttons{
      position:relative;
      float:left;
      margin-left:15px;
      }
      .t2{display:none;}
	  .modal-footer .btn+.btn 
		{
			margin-bottom: 0px!important;
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
        $data['pageid']=3;
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
                    <p class="category" style="color:#ffffff;font-size:17px;" > List of Present Employees  </p>
					<a rel="tooltip"  data-placement="bottom" title="Help"  class="btn btn-success btn-sm pull-right toggle-sidebar pull-right " style="position:relative;margin-top:-30px;"><i class="fa fa-question"></i></a>
                  </div>
                  <div class="card-content">
                    <div id="typography">
                      <div class="title">
                        <div class="row">
                          <div class="col-md-8" style="margin-top:-10px;"  >
						      <?php //$depart = getDepartment($id) ?>
                            <h3>Present Employees <?php $depart = getDepartment($id) ?> <?php if($depart != "") echo "in ".$depart.""; ?></h3>
							
							<?php //if($depart != "") 
								//echo "  <small><b>".$depart."</b></small>"; ?> 
                          </div>
					
						 
							
                        <div class="col-md-4" >
						   <!--   <a href="<?php echo URL; ?>admin/markattendance" class="btn btn-sm btn-success" type="button"><i class="fa fa-plus"> Add</i>
							<div class="ripple-container"></div>
							</a> --->
                            <!------------------------------->
                            <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px;  border: 1px solid #ccc;">
                              <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                              <span></span> 
							  <b class="caret"></b>
                            </div>
                            <!--<button class="btn btn-success pull-right" id="getAtt">Submit</button>-->
                            <!------------------------------->
                        </div>
						  
						
						
                        </div>
                        
                        <div class="row" style="overflow-x:scroll;">
                          <table id="example" class="display table"  width="100%">
                            <thead>
                              <tr>
                                <th>Name</th>
                                <th>Profile Image</th>
                                <th>Code</th>
                                <th>Shift</th>
                                <th>Date</th>
                                <th>Time In Date</th>
                                <th>Time In</th>
                                <th>Time In Image</th>
                                <th width='30%'>Time In Location</th>
                                <th>Time Out Date</th>
                                <th>Time Out</th>
                                <th>Time Out Image</th>
                                <th width='30%'>Time Out Location</th>
                                <th>Logged Hours</th>
                                <th>Device</th>
                                <th width="10%" style="background-image:none"!important>Status</th>
                                <th style="background-image:none"!important>Action</th>
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
        </div>
        <div class="col-md-3 t2" id="sidebar" style="margin-top:100px;"></div>
        <footer class="footer" >
          <div class="container-fluid">
            <nav class="pull-left">
            </nav>
            <!--<p class="copyright pull-right">
              &copy; <script>document.write(new Date().getFullYear())</script> <a href="#">DESIGNED BY</a> Ubitech Solutions Pvt. Ltd.
            </p>-->
			<a href="http://www.ubitechsolutions.com/" target="_blank" >
					<p class="copyright pull-right" style="padding-right:25px;padding-top:0px;" >
					Copyright &copy;<script>document.write(new Date().getFullYear())</script>
					Ubitech Solutions. All rights reserved.
					</p>
				</a>
          </div>
        </footer>
      </div>
    </div>
    <!------Edit attendance modal start------------>
    <div id="addAttATO" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
            <h4 class="modal-title" id="title">Update TimeOut</h4>
          </div>
          <div class="modal-body">
            <form id="AttFrom">
              <input type="hidden" id="id" />
			   <!--<input  type="hidden" id="attDateE"   >-->
			   <input  type="hidden" id="shifttype"   >
			   <input  type="hidden" id="timeInE"   >
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group label-floating">
                    <label class="control-label">Time Out <span class="red">*</span></label>
                    <input type="text"  id="timeOutE"   class="form-control timepicker2" >
                  </div>
                </div>
              </div>
              <div class="row" id="shifttypedate">
					<div class="col-md-6">
					  <div class="form-group ">
						<label class="control-label">Time Out Date <span class="red">*</span></label>
						<input type="text"  id="attDateE"   class="form-control datepicker" >
					  </div>
					</div>	 
              </div>
			  
              <div class="clearfix"></div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="saveEE" class="btn btn-success">Update</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!------Edit attendance modal close------------>
	
	
	
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
              <input type="hidden" id="aname" />
			   <!--<input  type="hidden" id="attDateE"   >-->
			   <input  type="hidden" id="shifttype"   >
			   <!--<input  type="hidden" id="timeInE"   >-->
              <!--<div class="row">
                <div class="col-md-6">
                  <div class="form-group label-floating">
                    <label>Name</label>
                    <input type="text" readonly='true' placeholder="Employee Name"  id="attNameE" class="form-control" >
                  </div>
                </div>
                <!--<div class="col-md-6">
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
              </div>-->
              <div class="row">
			  <div class="col-md-6">
                  <div class="form-group label-floating">
                    <label class="control-label">Time In <span class="red">*</span></label>
                    <input type="text"  id="timeInE1"   class="form-control timepicker" >
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group label-floating">
                    <label class="control-label">Time Out <span class="red">*</span></label>
                    <input type="text"  id="timeOutE1"   class="form-control timepicker1" >
                  </div>
                </div>
              </div>
			  
			   
			 
              <div class="row" id="shifttypedate">
					<div class="col-md-6">
					  <div class="form-group ">
						<label class="control-label">Time In Date <span class="red">*</span></label>
						<input type="text"  id="attInDateE1"   class="form-control datepicker" readonly="readonly" >
					  </div>
					</div>
					
					<div class="col-md-6">
					  <div class="form-group ">
						<label class="control-label">Time Out Date <span class="red">*</span></label>
						<input type="text"  id="attOutDateE1"   class="form-control datepicker" readonly="readonly">
					  </div>
					</div>	 
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
	
	
	
	<!-- edit attendance modal for current day -->
<div id="addAttc" class="modal fade" role="dialog">
 <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
            <h4 class="modal-title" id="title">Update Attendance</h4>
          </div>
          <div class="modal-body">
            <form id="AttForm">

              <input type="hidden" id="idc" />
              <input type="hidden" id="anamec" />
              <input type="hidden" id="attInDatec1" />
         <!--<input  type="hidden" id="attDateE"   >-->
         <input  type="hidden" id="shifttypec"   >

          <div class="row">
        <div class="col-md-6">
                  <div class="form-group ">
                    <label class="control-label">Time In <span class="red">*</span></label>
                    <input type="text"  id="timeInc1"   class="form-control timepicker" >
                  </div>
                </div>
            </div>
            <div class="clearfix"></div>

 </form>
</div>

     <div class="modal-footer">
            <button type="button" id="savec"  class="btn btn-success">Update</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>



</div>
</div>  
</div>

<!-- end edit attendance modal for current day -->

	
	<!------image modal ----->
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-dialog" >
    <div class="modal-content"> 
      <div class="modal-body">
      	<button type="button" class="close" data-dismiss="modal" style="color:black"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<form id="imgE" method="POST" enctype="multipart/form-data" name="myformE">
		<input type="hidden" id="imgid">
        <img src="" class="imagepreview" style="width:550px!important;height:500px!important;object-fit:cover" 
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
    <!-- profile modal Start -->


<div class="modal fade" id="imagemodal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-dialog" >
    <div class="modal-content"> 
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" style="color:black"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <form id="imgE1" method="POST" enctype="multipart/form-data" name="myformE1">
    <input type="hidden" id="imgid1">
        <img src="" class="imagepreview1" style="width:550px!important;height:500px!important;" 
id="profileimg1" >
      </div>
    <div class="modal-footer">
            <button type="button" id="setprofile"  class="btn btn-success">Set as Profile</button>
    </div> 
     </form>
    </div>
  </div>
</div>



<!-- profile modal End -->
	
<!------------------Location Modal --------------->
<div class="modal fade" id="locationmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-dialog" >
    <div class="modal-content"> 
	 <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
            <h4 class="modal-title" id="title"></h4>
          </div>
      <div class="modal-body">
		<form>
		<input type="hidden" id="latitid">
		<input type="hidden" id="latitinid">
		<input type="hidden" id="longiid">
		<input type="hidden" id="checkinloc">
		<div class="row">
                <div class="col-md-12">
                  <h4> Choose an option</h4>
                </div>
              </div>
              <div class="clearfix"></div>
		<div class="modal-footer">
           <!-- <button type="button" id="showgoogle"  class="btn btn-danger">Show Google Map</button>-->
			<a href="#"  class="btn btn-success" id="showgoogle" >Open In Google Maps</a>
			<a href="#"  id="creategeo" class="btn btn-success"  >Create GeoFence</a>
            <!--<button type="button" class="btn btn-danger" >Create GeoFence</button>-->
		</div>
	   </form>
    </div>
  </div>
</div>
</div>
<!--------------------------------->

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
              <input type="hidden" id="del_att" />
             
              <div class="row">
                <div class="col-md-12">
                  <h4> Delete <span id="ana"></span>'s Attendance  ?</h4>
                </div>
              </div>
              <div class="clearfix"></div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="delete"  class="btn btn-danger" style="margin-top: -10px;">Delete</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-----delete Attn close--->
  </body>
    <script src="<?=URL?>../assets/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
  
  <script src="<?=URL?>../assets/js/buttons.colVis.min.js"></script>
  <script src="<?=URL?>../assets/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/moment.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/daterangepicker.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/buttons.flash.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/jszip.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/buttons.html5.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/buttons.print.min.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/jquery-ui.js"></script>
  <script type="text/javascript" src="<?=URL?>../assets/js/repeatheadeerprint.js"></script>
  
  <script>
    // var attdatein = $('#attInDateE1').val($(this).data('tidate'));
    // alert(attdatein);
    // var attdateout $('#attOutDateE1').val($(this).data('todate'));
  //   var attdatein=$(this).data('tidate');  
  // $(".datepicker").datepicker
  //   ({
  //   "minDate": dateSelected ,
  //   "maxDate": "+0d",
  //   "dateFormat": 'yy-mm-dd'
  //   });

    // var attdatein = $(this).data('tidate');
//     alert(attdatein);
//     $("#attInDateE1").datepicker({
//     "minDate": attdatein,
//     "maxDate": "+0d"
//     "dateFormat": 'yy-mm-dd'
    
    
// });
    </script>
<!-- <script>

     $("#attOutDateE1").datepicker({
    minDate: 0,
   
});
    
  </script>
 -->  
 <script type="text/javascript">
   //$(document).ready(function() {
		//var range=$('#reportrange').text();
    var org = '<?php echo getOrgName($_SESSION['orgid']) ?>';
		var datestring="&date=";
  var date = new Date();
date.setMinutes(0);
date.setSeconds(0);
date.setMilliseconds(0);

var isoDateString = date.toISOString().substring(0,10);

   
		var ts;
		var ts1;
		var ss;
    
    var table= $('#example').DataTable({
		
				order:[[4,'DESC'],[0, "asc"]],
				//"scrollX": true,
				dom: 'Bfrtip',
				//"bDestroy": true, // destroy data table before reinitializing
				buttons: 
				[
				'pageLength','csv','excel','copy',
				{
					"extend":'colvis',
					"columns":':not(:last-child)',
				},
        {
            extend: 'print',
            // autoPrint: false,
            title: '',
            exportOptions: {
                // columns: ':visible',
                columns: [ 0, 1, 2, 3,5,6,7,8,9,10,11,12,13],
                stripHtml: false,
            },
            repeatingHead:{
               logo: '<?=URL?>../assets/img/newlogo.png',
               logoPosition: 'center',
                logoStyle: 'height:100px;width:130px;',
                title: 'Attendance report of '+org+' Dated '+isoDateString+'',
                
            },
            text: '<i class="fa fa-print"></i> Print',
             
            customize: function (win) {
                $(win.document.body)
                    .css('font-size', '10px')
                    
                    // .prepend(
                    //     '<img src="<?=URL?>../assets/img/newlogo.png" height="100px" width="130px" style="position:absolute; top:-20px; left:450px;" />'
                    // );

                $(win.document.body).find('table')
                    .addClass('compact')
                    .css('font-size', 'inherit');
            }
        }


				],
				//"columnDefs": [ { "orderable": false, "targets": [15,16]}],
				"contentType": "application/json",
				"ajax": "<?php echo URL;?>admin/getAttendances__new?dept=<?php echo $id; ?>"+datestring,
				 "columnDefs": [
					{ "visible": false, "targets": [1,2,4,5,9,14] }
                               ],
				
				"columns": 
				[
				{ "data": "name" },
				{ "data": "proimage" },
				{ "data": "code" },
				{ "data": "shift" },
				{ "data": "date" },
				{ "data": "timeindate" },
				{ "data": "ti" },
				{ "data": "entryimg" },
				{ "data": "chiloc" },
				{ "data": "timeoutdate" },
				{ "data": "to" },
				{ "data": "exitimg" },
				{ "data": "choloc" },
				{ "data": "wh" },
				{ "data": "device" },
				{ "data": "status" },
				{ "data": "action" },
				],
				"drawCallback": function ( settings ) {
				var api = this.api();
				var rows = api.rows( {page:'current'} ).nodes();
				var last=null;
				
				api.column(4, {page:'current'} ).data().each( function ( group, i ) {
					if ( last !== group ) {
						$(rows).eq( i ).before(
							'<tr class="group"><td bgcolor="#d59ff2" colspan=16><b>'+group+'</b><b> &nbsp; &nbsp;  </b></td></tr>'
						);
						last = group;
					}
				});
				}
    });
	
	
	
    
    ////---------date picker
    //	var start = moment().subtract(29, 'days');
    var minDate = moment();
    var start = moment();
    var end = moment();

    // var date =date('Y-m-d');
    function cb(start, end) 
	{
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
    $('#reportrange').on('DOMNodeInserted',function(){ 
    var range=$('#reportrange').text();
// alert(range);
   // $('#example').empty();
    $('#example').DataTable({
    order:[[4,'DESC'],[0, "asc"]],
    //aaSorting: [[0, "asc"]],
    //"scrollX": true,
     dom: 'Bfrtip',
     "bDestroy": true,// destroy data table before reinitializing
    buttons: 
	[
    	'pageLength','csv','excel','copy',
    	{
    		"extend":'colvis',
    		"columns":':not(:last-child)',
    	},
      {
            extend: 'print',
            // autoPrint: false,
            title: '',
            exportOptions: {
                // columns: ':visible',
                columns: [ 0, 1, 2, 3,5,6,7,8,9,10,11,12,13],
                stripHtml: false,
            },
            repeatingHead:{
               logo: '<?=URL?>../assets/img/newlogo.png',
               logoPosition: 'center',
                logoStyle: 'height:100px;width:130px;',
                title: 'Attendance report of '+org+' Between '+range+' ',
                
            },
            text: '<i class="fa fa-print"></i> Print',
             
            customize: function (win) {
                $(win.document.body)
                    .css('font-size', '10px')
                    
                    // .prepend(
                    //     '<img src="<?=URL?>../assets/img/newlogo.png" height="100px" width="130px" style="position:absolute; top:-20px; left:450px;" />'
                    // );

                $(win.document.body).find('table')
                    .addClass('compact')
                    .css('font-size', 'inherit');
            }
        }
    ],
	columnDefs: [ { orderable: false, targets: [15,16]}],
    "contentType": "application/json",
    "ajax": "<?php echo URL;?>admin/getAttendances__new?date="+range,
    "columnDefs": 
	[
    { "visible": false, "targets": [1,2,4,5,9,14] }
    ],
    "columns":
	[
		{ "data": "name" },
		{ "data": "proimage" },
		{ "data": "code" },
		{ "data": "shift" },
    	{ "data": "date" },
    	{ "data": "timeindate" },
    	{ "data": "ti" },
    	{ "data": "entryimg" },
    	{ "data": "chiloc" },
    	{ "data": "timeoutdate" },
    	{ "data": "to" },
    	//{ "data": "ot" },//get Changed by Ma'am ..
    	{ "data": "exitimg" },
    	{ "data": "choloc" },
    	{ "data": "wh" },
    	{ "data": "device" },
    	{ "data": "status" },
    	{ "data": "action" }
    ],
    	"drawCallback": function ( settings ) {
    var api = this.api();
    var rows = api.rows( {page:'current'} ).nodes();
    var last=null;
    
    api.column(4, {page:'current'} ).data().each( function ( group, i ) {
    	if ( last !== group ) {
    		$(rows).eq( i ).before(
    			'<tr class="group"><td bgcolor="#d59ff2" colspan=16><b>'+group+'</b><b> &nbsp; &nbsp;  </b></td></tr>'
    		);
    		last = group;
    	}
              });
     }
    } );
    });
  
   //////////////////////////
   $(document).on("click", ".loc",function ()
			{
				$('#latitid').val($(this).data('latit'));
				$('#latitinid').val($(this).data('latitin'));
				$('#longiid').val($(this).data('longiin'));
				$('#checkinloc').val($(this).data('checkinloc'));
				$('#locationmodal').modal('show');   
			});
			
			
		$('#showgoogle').click(function(){
			 var latitid=$('#latitid').val();
			// alert(latitid);
			window.open("http://maps.google.com/?q="+latitid);
			// $("a").attr("href", "http://maps.google.com/?q="+latitid);
			// $("a").attr("target", "_blank");
			  $('#locationmodal').modal('hide');  
			 
			
			 
		});			
			
		$('#creategeo').click(function(){
			 //var latitid=$('#latitid').val();
			 var latitid=$('#latitinid').val();
			 var longiid=$('#longiid').val();
			 var checkinloc=$('#checkinloc').val();
			// alert(checkinloc);
			 window.open("<?= URL?>Dashboard/creategeofence/"+latitid+"/"+longiid+"/"+checkinloc);
			// $("a").attr("href", "<?= URL?>Dashboard/creategeofence/"+latitid+"/"+longiid+"/"+checkinloc);
			 //$("a").attr("target", "_blank");
			
			 $('#locationmodal').modal('hide'); 
		$('#example').DataTable().ajax.reload();			 
			 
		});	
			
   //////////////////////
	
 $(document).on("click", ".pop",function ()
			{
				$('#imgid').val($(this).data('id'));
			//	$('#profileimg').val($(this).data('enimage'));
			//	alert($(this).data('enimage'));
				$('.imagepreview').attr('src', $(this).find('img').attr('src'));
				$('#imagemodal').modal('show');   
			});

 $(document).on("click", ".pop1",function ()
      {
        
        $('#imgid1').val($(this).data('id'));
      //  $('#profileimg').val($(this).data('enimage'));
      //  alert($(this).data('enimage'));
      $('.imagepreview1').attr('src', $(this).find('img').attr('src'));
        $('#imagemodal1').modal('show');   
      });
			
// $('#setprofile').click(function(){
 $(document).on("click", "#setprofile", function(){
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
    			doNotify('top','center',4,'cannot be updated.');
    		}
    		
    	 },
    	error: function(result)
			{
				doNotify('top','center',4,'Unable to connect API');
			}
      });
    }); 
	
    $(document).on("click", ".delete", function () {
		$('#del_aid').val($(this).data('aid'));
		$('#ana').text($(this).data('aname'));
		$('#del_att').val($(this).data('attdate'));
	
    });
	
	
	
    $(document).on("click", "#delete", function() 
	{
    var id=$('#del_aid').val();
    var ana=$('#ana').text();
    var del_att=$('#del_att').val();
    $.ajax({url: "<?php echo URL;?>admin/deleteAtt",
    	data: {"aid":id,"ana":ana,"del_att":del_att},
    	success: function(result)
		{
    		if(result==1){
				datestring='&date='+$('#reportrange').text();
    			$('#delAtt').modal('hide');
    			doNotify('top','center',2,'Attendance deleted successfully.');
    			 $('#example').DataTable().ajax.reload();
    		}else{
    			$('#delAtt').modal('hide');
    			doNotify('top','center',4,'There may problem(s) in deleting Attendance , try later.');
    		}
    	
    	 },
    	error: function(result){
    		doNotify('top','center',4,'Unable to connect API');
    	 }
      });
    });
	
	
	
 $('#saveEE').click(function(){
		  var id=$('#id').val();
		  var ti=$('#timeInE').val();
		  var to=$('#timeOutE').val();
		  var date=$('#attDateE').val();
		  var shifttype=$('#shifttype').val();
		
		  if(shifttype==1)
		  {
			  if(ti==to)
			  {
				doNotify('top','center',4,'Time In can not be equal to Time Out'); 
				return false;  
			  }
			 // if(ti>to)
			 // {
				// doNotify('top','center',4,'Time In can not be greater than Time Out'); 
				// return false;
			 // }				 
		  }
		   if(shifttype==2)
		  {
			  if(ti==to)
			  {
				doNotify('top','center',4,'Time In can not be equal to Time Out'); 
				return false;  
			  }
			 // if(ti<to)
			 // {
				// doNotify('top','center',4,'Time Out can not be greater than Time In'); 
				// return false;
			 // }				 
		  }
		 
		  $.ajax({url: "<?php echo URL;?>admin/editAttUBI",
			data: {"id":id,"ti":ti,"to":to,"date":date,"shifttype":shifttype},
			success: function(result){
				//alert(result);
				if(result==1)
				{
					datestring='&date='+$('#reportrange').text();
					// alert(datestring);
					doNotify('top','center',2,'TimeOut Updated Successfully.');
					$('#addAttATO').modal('hide');
					//table.ajax.reload();
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
		
			
			
			
   
    
   $('#saveE').click(function(){
		  var id=$('#id').val();

		  var aname=$('#aname').text();
		  var ti=$('#timeInE1').val();
      // alert(ti);
      // die;
		  var to=$('#timeOutE1').val();
      
		  var dateIn=$('#attInDateE1').val();
      // var dateIntimein=$('#attInDateE1').val() + ti;
      // alert(dateIntimein);
		  var dateOut=$('#attOutDateE1').val();
      // alert(dateOut);
      // alert(dateIn);
      // alert(dateIn==dateOut);
      // var dateOuttimeout=$('#attOutDateE1').val()+to;
      // alert(dateOuttimeout);
		  var shifttype=$('#shifttype').val();
      // var fromd = parseInt(dateIntimein);
      // var tod = parseInt(dateOuttimeout);
		 // alert(id);
   //   alert(shifttype);

		  if(shifttype==1)
		  {
			 //  if(ti==to)
			 //  {
				// doNotify('top','center',4,'Time In can not be equal to Time Out'); 
				// return false;  
			 //  }
			 
        if(dateIn > dateOut){
          doNotify('top','center',4,'Time In Date cannot be greater than  Time Out Date'); 
        return false;
        }
        if(dateIn==dateOut){
          if(ti==to)
        {
        doNotify('top','center',4,'Time In can not be equal to Time Out'); 
        return false;  
        }

        else if(ti =='12:00 AM' ){
         

          ti='12:01 AM';

          

          // return false;
        }
        
        
        }
        if(dateIn == ''){
          doNotify('top','center',4,'Please select a value for Time In Date'); 
        return false;
        }
        if(dateOut == ''){
          doNotify('top','center',4,'Please select a value for Time Out Date'); 
        return false;
        }
        if( ti== ''){
          doNotify('top','center',4,'Please select a value for Time In'); 
        return false;
        }
         if( to== ''){
          doNotify('top','center',4,'Please select a value for Time Out'); 
        return false;
        }
        if(ti =='12:00 AM' ){
         

          ti='12:01 AM';

          

          // return false;
        }


        

        // alert(fromd>tod);
        // alert(fromd);
        // alert(tod);
			 // if(tidp>todp)
			 // {
				// doNotify('top','center',4,'Time In can not be greater than Time Out'); 
				// return false;
			 // }				 
		  }
		   if(shifttype==2)
		  {
			 //  if(ti==to)
			 //  {
				// doNotify('top','center',4,'Time In can not be equal to Time Out'); 
				// return false;  
			 //  }	 
       
       if(ti =='12:00 AM' ){
         

          ti='12:01 AM';

          

          // return false;
        }
         if( ti== ''){
          doNotify('top','center',4,'Please select a value for Time In'); 
        return false;
        }
         if( to== ''){
          doNotify('top','center',4,'Please select a value for Time Out'); 
        return false;
        }
        if(dateIn > dateOut){
          doNotify('top','center',4,'Time In Date cannot be greater than  Time Out Date'); 
        return false;
        }
        if(dateIn == ''){
          doNotify('top','center',4,'Please select a value for Time In Date'); 
        return false;
        }
        if(dateOut == ''){
          doNotify('top','center',4,'Please select a value for Time Out Date'); 
        return false;
        }
        if(dateIn==dateOut){
          if(ti==to)
        {
        doNotify('top','center',4,'Time In can not be equal to Time Out'); 
        return false;  
        }

        else if(ti =='12:00 AM' ){
         

          ti='12:01 AM';

          

          // return false;
        }


        }
		  }
		
			$.ajax({url: "<?php echo URL;?>admin/editAtt",
			data: {"id":id,"ti":ti,"to":to,"dateIn":dateIn,"dateOut":dateOut,"shifttype":shifttype,"aname":aname,"ts":ts,"ts1":ts1},
			success: function(result){
				if(result==1)
				{
					datestring='&date='+$('#reportrange').text();
					doNotify('top','center',2,'Attendance Updated Successfully.');
					$('#addAttE').modal('hide');
					$('#example').DataTable().ajax.reload();
				}
        else if(result== 22)
              {
                doNotify('top','center',4,'TimeIn should be lesser than timeout '); 
              }
              else if(result== 111)
              {
                doNotify('top','center',4,'TimeOut should be lesser than or equal to current time '); 
                return false;
              }
              else if(result== 112)
              {
                doNotify('top','center',4,'TimeInDate should be  equal to current Date '); 
                return false;
              }
              else if(result== 114)
              {
                doNotify('top','center',4,'TimeIn should be lesser than or equal to current time '); 
                return false;
              }
              else if(result== 113)
              {
                doNotify('top','center',4,'TimeOutDate should be  equal to current Date '); 
                return false;
              }
				else
				{
					doNotify('top','center',4,'cannot be updated.');
				}
			 },
			error: function(result)
				{
					doNotify('top','center',4,'Unable to connect API');
				}
		  });
		}); 

   $('#savec').click(function(){
      var id=$('#idc').val();
      var aname=$('#anamec').text();
      var ti=$('#timeInc1').val();
      var shifttype=$('#shifttypec').val();
      var dateIn=$('#attInDatec1').val();
      var dateOut='0000-00-00';
      var to='00:00:00';


      if(ti =='12:00 AM' ){
         

          ti='12:01 AM';

          

          // return false;
        }
      // var today = new Date();
      // var timec = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
  //     var date = new Date();
  //       var hours = date.getHours() > 12 ? date.getHours() - 12 : date.getHours();
  //       var am_pm = date.getHours() >= 12 ? "PM" : "AM";
  //       hours = hours < 10 ? "0" + hours : hours;
  //       var minutes = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
  //       var seconds = date.getSeconds() < 10 ? "0" + date.getSeconds() : date.getSeconds();
  //       timec = hours + ":" + minutes + ":" + seconds + " " + am_pm;
  // alert(timec);
  // alert(ti);

  // // return strTime;

  //     if(ti > timec){
  //       doNotify('top','center',4,'TimeIN Should be lesser than or equal to current Time.');
  //       return false;
  //     }

      // alert(shifttype);
      // alert(id);
      // alert(dateIn);
//       $('#addAttc').on('hidden.bs.modal', function () {
//  location.reload();
// })

        // $('#addAttc').on("hidden.bs.mo", function() {
        //   $('#example').DataTable().ajax.reload();
        //  }); 
       

      $.ajax({url: "<?php echo URL;?>admin/editAtt",
        data: {"id":id,"ti":ti,"to":to,"dateIn":dateIn,"dateOut":dateOut,"shifttype":shifttype,"aname":aname,"ts":ts,"ts1":ts1},
        success: function(result){
        if(result==1)
        {
          datestring='&date='+$('#reportrange').text();
          doNotify('top','center',2,'Attendance Updated Successfully.');
          $('#addAttc').modal('hide');
          $('#example').DataTable().ajax.reload();
        }
        else if(result== 22)
              {
                doNotify('top','center',4,'TimeIn should be lesser than timeout '); 
                return false;
              }
              else if(result== 110)
              {
                doNotify('top','center',4,'TimeIn should be lesser than or equal to current time '); 
                return false;
              }
              
              
        else
        {
          doNotify('top','center',4,'cannot be updated.');
        }
       },
       error: function(result)
        {
          doNotify('top','center',4,'Unable to connect API');
        }

      });
      }); 

// 		 $('#addAttc').on('hidden.bs.modal', function () {
//     // $('#example').dataTable().reload();
//     location.reload();
// });
		
  </script>
  <script>
$(document).ready(function(){
$(document).on("click", ".edit", function () 
	{
    $('#id').val($(this).data('id'));
    $('#idc').val($(this).data('id'));
    $('#aname').text($(this).data('aname'));
    $('#anamec').text($(this).data('aname'));
    $('#timeInE1').val($(this).data('timein'));
    $('#timeInc1').val($(this).data('timein'));
    $('#timeOutE1').val($(this).data('timeout'));
    $('#attInDateE1').val($(this).data('tidate'));
    $('#attInDatec1').val($(this).data('tidate'));
    $('#attOutDateE1').val($(this).data('todate'));
    $('#shifttype').val($(this).data('shifttype'));
    $('#shifttypec').val($(this).data('shifttype'));
	
	if($(this).data('shifttype')==1)
	{
		$('#shifttypedate').hide();
	}
	else
	{
	$('#shifttypedate').show();	
	}
	 ts=$(this).data('timein');
	ts1=$(this).data('timeout');

			setTimeout(function(){  
				$('.timepicker').timepicker({
				defaultTime: ts,
				//timeFormat: 'H:i',
			                    });
	 $('.timepicker1').timepicker({
				//timeFormat: 'H:i',
				defaultTime: ts1,
			});
			}, 1000);
			
	// var dateSelected=$(this).data('date');	
 //  $(".datepicker").datepicker
 //    ({
 //    "minDate": dateSelected ,
 //    "maxDate": "+0d",
 //    "dateFormat": 'yy-mm-dd'
 //    });
  var attdatein = $(this).data('tidate');
  
  // alert(dateSelected);
	$("#attInDateE1").datepicker
		({
		"minDate": attdatein ,
		"maxDate": "+0d",
		"dateFormat": 'yy-mm-dd'
		});
    var attdateout = $(this).data('todate');
    var attdateint = $(this).data('tidate');
    // alert(attdateout);
    $("#attOutDateE1").datepicker
    ({
    "minDate": attdateint ,
    "maxDate": "+0d",
    "dateFormat": 'yy-mm-dd'
    });
    });
});
</script>
  <script>
  $(document).ready(function(){
   $(document).on("click", ".editATT", function () 
	{
    $('#id').val($(this).data('id'));
    $('#timeOutE').val($(this).data('timeout'));
    $('#attDateE').val($(this).data('date'));
    $('#shifttype').val($(this).data('shifttype'));
	
	if($(this).data('shifttype')==1)
	{
		$('#shifttypedate').hide();
	}
	else
	{
	$('#shifttypedate').show();	
	}
	 
	
		ts=$(this).data('ti');
	ss=$(this).data('timeout');
			setTimeout(function(){ 
	 $('.timepicker2').timepicker({
				defaultTime: ss,
			});
$('.timepicker').timepicker({
        defaultTime: ts,
      });
  



			},1000);	

        
			
			
	var dateSelected=$(this).data('date');	
	
	$(".datepicker").datepicker
		({
		"minDate": dateSelected ,
		"maxDate": "+0d",
		 "dateFormat": 'yy-mm-dd'
		});
    });
  });
  </script>	
		

  <script>
   $(document).ready(function(){
		$(".toggle-sidebar").click(function(){
		/*if($(".t2").is(':hidden'))
		   setTimeout(function(){*/
    
		$("#sidebar").toggleClass("collapsed t2");
		$(".content").toggleClass("col-md-9");
		$("#sidebar").load('<?=URL?>admin/helpNav',{'pageid': 'attendanceH'});
		   /*}, 300);*/
		});
		
		/*$('.main-panel').click(function(){
		if(!$(".t2").is(':hidden'))
		{ 
       
			 $("#sidebar").toggleClass("collapsed t2");
			 $("#content").toggleClass("col-md-9");
		}

	  });*/
		});
  </script>
</html>



