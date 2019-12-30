<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Present Employee</title>
    <link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" />
    <style>
      $query = $this->db->query("SELECT `Id`,  `Shift`  FROM ` EmployeeMaster`  WHERE OrganizationId=? AND `Id` Not IN(SELECT `EmployeeId` FROM `AttendanceMaster` ) ",array($orgid)); 
      .red{
      color:red;
      font-weight:'bold';
      font-size:16px;
      }
      .delete{
      cursor:pointer;
      }
      div.dt-buttons{
      position:relative;
      float:left;
      margin-left:15px;
      }
      .t2{display:none;}
	  
	  a.depart
	  {
		color: #43a047!important;
		
	    font-size:16px;
		margin:0px;
		text-decoration: underline!important;
		font-family: "Roboto", "Helvetica", "Arial", sans-serif!important;
		font-weight: 300; 
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
                    <p class="category" style="color:#ffffff;font-size:17px;" > Employees by Department/Site</p>
					<a rel="tooltip"  data-placement="bottom" title="Help"  class="btn btn-success btn-sm pull-right toggle-sidebar pull-right " style="position:relative;margin-top:-30px;"><i class="fa fa-question"></i></a>
                  </div>
                  <div class="card-content">
                    <div id="typography">
                      <div class="title">
                        <div class="row">
                          <div class="col-md-8" style="margin-top:-10px;"  >
						      <?php //$depart = getDepartment($id) ?>
                           
							<h3>Present Employees  <?php $depart = getDepartment($id) ?> <?php if($depart != "") echo "in ".$depart." Department/Site"; ?> </h3>
							<?php //if($depart != "") 
								//echo "  <small><b>".$depart."</b></small>"; ?> 
                          </div>
					
						  
						  
							<!--<div class="col-md-4">
								<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px; 10px; border: 1px solid #ccc;">
								  <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
								  <span></span> <b class="caret"></b>
								</div>
							</div>-->
						
						<div class="col-md-6" >
							<div class="col-md-3" >
							 <?php $depart = getDepartment($id) ?><?php if($depart != ""){ ?>
								<a  href="<?=URL?>Dashboard/gatAbsentEmployee?id=<?php echo $id ?>" style="" class="depart">Absent</a>&nbsp;|
							 <?php } ?>
							</div>
						
							
							 <div class="col-md-4" >
							 <?php $depart = getDepartment($id) ?><?php if($depart != ""){ ?>
								<a  href="<?=URL?>Dashboard/getLateEmployee?id=<?php echo $id ?>" style="" class="depart">Late 	Comers</a>&nbsp;|
							 <?php } ?>
							 </div>
							
							
							 <div class="col-md-4" >
							 <?php $depart = getDepartment($id) ?><?php if($depart != ""){ ?>
								<a  href="<?=URL?>Dashboard/getearlyEmployee?id=<?php echo $id ?>" style="" class="depart">Early Leavers</a>
							 <?php } ?>
							 </div>
						 <hr/>
						 
						</div> 
						
							
							
                            <!--<button class="btn btn-success pull-right" id="getAtt">Submit</button>-->
                            <!------------------------------->
                         
						  
						  
						  
						  
						  
						  
						  
						  
						 <!-- <div class="row pull-right" style="margin:0px">
							  <div class="col-md-4"> 
								 <?php $depart = getDepartment($id) ?><?php if($depart != ""){ ?>
									<button  class="btn btn-sm absent"  type="button" >	
										<i class=""> Absent </i>
									</button>
								<?php } ?> 
							  </div> 
						    
							  <div class="col-md-4"> 
								 <?php $depart = getDepartment($id) ?><?php if($depart != ""){ ?>
									<button  class="btn btn-sm late"  type="button" >	
								<i class=""> Late Comers </i>
									</button>
								<?php } ?> 
							  </div> 
						  
							   <div class="col-md-4"> 
								 <?php $depart = getDepartment($id) ?><?php if($depart != ""){ ?>
								  <button  class="btn btn-sm early"  type="button" >	
								<i class="">Early Leavers</i>
									</button>
								<?php } ?> 
							  </div>
						  </div>-->
						  
						  
												
						
						  
				<!--	<div class="col-md-4">
						  <div class="row">
						 <select id="stat" style="height:35px;position:relative;" class="col-sm-4">
							<option value="0">--Status--</option>
							<option value="1">Present</option>
							<option value="2">Absent</option>
						 </select>
						</div>
						</div>-->
						
						
						
						
						
						
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
                                <th width='15%'>Time In Location</th>
                                <th>Time Out Date</th>
                                <th>Time Out</th>
                                <th>Time Out Image</th>
                                <th width='15%'>Time Out Location</th>
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
  <script type="text/javascript">
    $(document).ready(function() {
    
    var table= $('#example').DataTable({
    order:[[4,'DESC'],[0, "asc"]],
    //"scrollX": true,
    dom: 'Bfrtip',
    //"bDestroy": true, // destroy data table before reinitializing
    buttons: [
    'pageLength','csv','excel','copy','print',
    {
    	"extend":'colvis',
    	"columns":':not(:last-child)',
    }
    ],
	"columnDefs": [ { "orderable": false, "targets": [15,16]}],
    "contentType": "application/json",
    "ajax": "<?php echo URL;?>admin/getAttendances__new?dept=<?php echo $id; ?>",
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
    	if ( last !== group )	 {
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
    function cb(start,end)
	{
    $('#reportrange span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
    }
    $('#reportrange').daterangepicker({
    maxDate:minDate,
    startDate: start,
    endDate:end,
    ranges: {
      'Today': [moment(), moment()],
      'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Last 7 Days':[moment().subtract(6, 'days'), moment()],
      'Last 30 Days':[moment().subtract(29, 'days'), moment()],
      'This Month': [moment().startOf('month'), moment().endOf('month')],
      'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
           }
    }, cb);
    cb(start, end);
    ////---------/date picker
    $('#reportrange').on('DOMNodeInserted',function(){ 
    var range=$('#reportrange').text();
   // $('#example').empty();
    $('#example').DataTable({
    order:[[4,'DESC'],[0, "asc"]],
    //aaSorting: [[0, "asc"]],
    //"scrollX": true,
	
     dom: 'Bfrtip',
     "bDestroy": true,// destroy data table before reinitializing
    buttons: [
    	'pageLength','csv','excel','copy','print',
    	{
    		"extend":'colvis',
    		"columns":':not(:last-child)',
    	}
    ],
	columnDefs: [ { orderable: false, targets: [15,16]}],
    "contentType": "application/json",
    "ajax": "<?php echo URL;?>admin/getAttendances__new?date="+range,
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
    $('#saveE').click(function(){
      var id=$('#id').val();
    			// var na=$('#attNameE').val();
      var ti=$('#timeInE').val();
      var to=$('#timeOutE').val();
    			// var ad=$('#attDateE').val();
      var sh=$('#shiftE').val();
      var sts=$('#statusE').val();
      $.ajax({url: "<?php echo URL;?>admin/editAtt",
    	data: {"id":id,"ti":ti,"to":to,"sh":sh,"sts":sts},
    	success: function(result){
    		if(result==1){
    			doNotify('top','center',2,'Attendance Updated Successfully.');
    			$('#addAttE').modal('hide');
    			 table.ajax.reload();
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
    			doNotify('top','center',2,'Set as Profile Picture');
    			
				$('#imagemodal').modal('hide');  
    			 table.ajax.reload();
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
	
    $(document).on("click", "#delete", function() 
	{
    var id=$('#del_aid').val();
    $.ajax({url: "<?php echo URL;?>admin/deleteAtt",
    	data: {"aid":id},
    	success: function(result){
    		if(result==1){
    			$('#delAtt').modal('hide');
    			doNotify('top','center',2,'Attendance deleted successfully.');
    			 table.ajax.reload();
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
	
	
	
	
	$(document).on("click", ".absent", function() 
	{
		var id='<?php echo $id; ?>';
    window.location.href = '<?=URL?>Dashboard/gatAbsentEmployee?id='+id;

    });	
	$(document).on("click", ".late", function() 
	{
		var id='<?php echo $id; ?>';
    window.location.href = '<?=URL?>Dashboard/getLateEmployee?id='+id;

    });	
$(document).on("click", ".early", function() 
	{
		var id='<?php echo $id; ?>';
    window.location.href = '<?=URL?>Dashboard/getearlyEmployee?id='+id;

    });		
			
			
    $(document).on("click", ".edit", function () 
	{
    $('#id').val($(this).data('id'));
    $('#attNameE').val($(this).data('name'));
    $('#timeInE').val($(this).data('ti'));
    $('#timeOutE').val($(this).data('to'));
    $('#statusE').val($(this).data('sts'));	
    $('#attDateE').val($(this).data('date'));	
    $('#shiftE').val($(this).data('shiftid'));		
    });
    $(document).on("click", ".delete", function () 
	{
		$('#del_aid').val($(this).data('aid'));
		$('#ana').text($(this).data('aname'));
    });
    });
  </script>
  <script>
   $(document).ready(function(){
		$(".toggle-sidebar").click(function(){
		if($(".t2").is(':hidden'))
		   setTimeout(function(){
		$("#sidebar").toggleClass("collapsed t2");
		$(".content").toggleClass("col-md-9");
		$("#sidebar").load('<?=URL?>admin/helpNav',{'pageid': 'attendanceH'});
		   }, 300);
		});
		
		$('.main-panel').click(function(){
		if(!$(".t2").is(':hidden'))
		{
			 $("#sidebar").toggleClass("collapsed t2");
			 $("#content").toggleClass("col-md-9");
		}
	  });
		});
  </script>
</html>