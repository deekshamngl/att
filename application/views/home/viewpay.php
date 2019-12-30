<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>View Payroll</title>
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
	  .card .table tfoot tr:first-child td {
     border-top: 1px solid black !important;
}
    </style>
  </head>
  <body>
    <div class="wrapper">
      <?php
        $data['pageid']=7.14;
        $this->load->view('menubar/sidebar',$data);
        ?>
      <div class="main-panel">
        <?php
          $this->load->view('menubar/navbar');
          ?>
        <div class="content" id="content" style="" >
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header" data-background-color="green" >
                  <!--  <h4 class="title">Attendance</h4> -->
                    <p class="category" style="color:#ffffff;font-size:17px;" >Payroll  <?= getEmpName($vid) ?> </p>
                  </div>
                  <div class="card-content">
                    <div id="typography">
                      <div class="title">
                       <!--<div class=" container-fluid row" style="margin-top:0px;" >
                          <div class="col-sm-3" >
                            <div id="reportrange" class="" style="background: #fff; cursor: pointer; padding: 6px; 10px; border: 1px solid #acadaf; width: 104%;margin-left:-12px;">
                              <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                              <span></span> <b class="caret"></b>
                            </div>
                          </div>
						  
						  <div class="col-sm-2">
						  <div class="row" >
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
							
                            <div class="col-sm-2" >	
                            <div class="row" >							
							<select id="deprt" name="deprt" style=" height:35px;position:relative;" class="col-sm-11">
						    <option value="0">--All Departments--</option>
								<?php
								$data= json_decode(getAllDept($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++)
								echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								?>
							  </select>		 
							  </div>
							  </div>
							  <div class="col-sm-2" >
							  <div class="row" >
                              <select id="shift" name="shift" style=" height:35px;position:relative;" class="col-sm-11">
							   <option value="0">--All Shifts--</option>
								<?php
								$data= json_decode(getAllShift($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++)
									echo '<option  value='.$data[$i]->id.'>'.$data[$i]->name.'  ('.substr(($data[$i]->TimeIn),0,5).' - '.substr(($data[$i]->
								TimeOut),0,5).')</option>';
								?></select>
								</div>
								</div>
								<div class="col-sm-2">
								<div class="row">
								<select id="empl" style="height:35px;position:relative;" class="col-sm-12">
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
								 <button class="btn btn-success pull-left" style="position:relative; right:10px;margin-top:0px;height:35px;padding-top:8px;" id="getAtt" ><i class="fa fa-search"></i></button>
						    </div>
                        </div>
                     <!--   <div class="row">
                          <div class="col-md-12 text-right">
                            <a rel="tooltip"  data-placement="bottom" title="Help" class="btn btn-success btn-sm toggle-sidebar">
                            <i class="fa fa-question"></i></a>
                          </div>
                        </div> -->
						<br>
                        <div class="row" style="overflow-x:scroll;">
                          <table id="example" class="display table"  width="100%">
                            <thead>
                              <tr>
                                <th>Name</th>
								 <th>Date</th>
								 <th>TimeIn</th>
								 <th>TimeOut</th>
                                <th>Worked hours</th>
                                <th>Hourly Rate</th>
                                <th class="dt-body-right">Amount</th>
                              </tr>
                            </thead>
							
							
							
							<tbody>
										<?php 
										foreach($adata['data'] as $data)
										{
										?> 
													<tr>
													<td><?= $data['name'] ?></td>
													<td><?= $data['date'] ?></td>
													<td><?= $data['timein'] ?></td>
													<td><?= $data['timeout'] ?></td>
													<td><?= $data['total_hour'] ?></td>
													<td><?= $data['rate'] ?></td>
													<td align="right" style="padding-right:50px;" ><?= $data['total_amount'] ?></td>
													</tr>
													
										<?php } ?>
							</tbody>
									
									  <tfoot>
										<tr>
										<td colspan="1"></td>
										<td colspan="1"></td>
										<td colspan="1"></td>
										<td colspan="2" style="font-weight:bold">Total WorkedHour: <?= $adata['total_workedhour'] ?></td>
										
										<td colspan="2" style="font-weight:bold">Total Amount: <?= $adata['net_amount'] ?></td>
										
										
										
										</tr>									
									</tfoot> 							
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
        <div class="col-md-3 t2" id="sidebar" style=" margin-top:50px;"></div>
        <footer class="footer">
          <div class="" style="position:relative; margin-bottom:0px;" >
            <nav class="pull-left">
            </nav>
           <!-- <p class="copyright pull-right" style="padding-right:35px;" >
              &copy; <script>document.write(new Date().getFullYear())</script>. Developed by<a href="http://www.ubitechsolutions.com/" target="_blank" > Ubitech Solutions </a>
            </p>-->
			<a href="http://www.ubitechsolutions.com/" target="_blank" >
					<p class="copyright pull-right" style="padding-right:25px;" >
					Copyright &copy;<script>document.write(new Date().getFullYear())</script>
					Ubitech Solutions. All rights reserved.
					</p>
				</a>
          </div>
        </footer>
      </div>
    </div>
    
   
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
    
    var table= $('#example').DataTable( {
		
    order: [[ 1, 'desc' ]],
	//aaSorting: [],
    //"scrollX": true,
    dom: 'Bfrtip',
    //"bDestroy": true, // destroy data table before reinitializing
    buttons: [
			'pageLength','csv','copy','print',
			{
				"extend":'colvis',
				//"columns":':not(:last-child)',
			},
			  { extend: 'excelHtml5', footer: true },
			],
			footer: true,
			columnDefs: [
			{
				targets: -1,
				className: 'dt-body-right'
			}
		  ],
	//"contentType": "application/json",
	//"ajax": "<?php echo URL;?>admin/gethourlypayview?datestatus="+7,
		"columnDefs": [
    { "visible": false, "targets":0 }
    
    ],
	
     "columns": [
	 { "data": "name" },
	 { "data": "date" },
	 { "data": "timein" },
	 { "data": "timeout" },
	 { "data": "total_hour" },
	 { "data": "rate" },
     { "data": "total_amount" },
    
     
	 
   
    ],
    "drawCallback": function ( settings ) {
    var api = this.api();
    var rows = api.rows( {page:'current'} ).nodes();
    var last=null;
    
    api.column(0, {page:'current'} ).data().each( function ( group, i ) {
    	if ( last !== group ) 
		{
    		$(rows).eq( i ).before(
    			'<tr class="group"><td bgcolor="#d59ff2" colspan=16><b>'+group+'</b><b> &nbsp; &nbsp;  </b></td></tr>'
    		);
    		last = group;
    	}
    });
	 
    }
    });
    
    
       ////---------date picker
      //var start = moment().subtract(29, 'days');
        var minDate = moment();
		//var start = moment().subtract(29, 'days');
		var start = moment().subtract(7,'days');
		var end = moment().subtract(0,'days');
    function cb(start, end) {
    $('#reportrange span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
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
    
    });
  </script>
  <script>
    $(document).ready(function(){
    $('.toggle-sidebar').click(function(){
    $("#sidebar").toggleClass("collapsed t2");
    $("#content").toggleClass("col-md-9");
    $("#sidebar").load('<?=URL?>admin/helpNav',{'pageid': 'attendanceH'});	
    });
    
    });
  </script>
</html>