<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Administrator | Results </title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?=URL?>../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?=URL?>../assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?=URL?>../assets/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- DATA TABLES -->
        <link href="<?=URL?>../assets/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css"href="<?=URL?>../assets/css/dataTables.tableTools.css">
        <link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
        <!-- Theme style -->
        <link href="<?=URL?>../assets/css/AdminLTE.css" rel="stylesheet" type="text/css" />
		<!------For Rating ----->
		<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
		<style>
			.bargraph{
	display:inline-block;
	}
			</style>
    </head>
    <body class="skin-blue fixed">
        <!-- header logo: style can be found in header.less -->
        <?php require VIEWS_PATH . '_templates/sidebar.php'; 
			topbar(1);
			$startdate=isset($this->startdate)?$this->startdate:"Start";
			$enddate=isset($this->enddate)?$this->enddate:"End";
			$positionSts=isset($this->positionSts)?$this->positionSts:"";
			$position_name=isset($this->position_name)?$this->position_name:"";
			$positionid=isset($this->positionid)?$this->positionid:"";
			$can_id=isset($this->candidate[0]["candidate_id"])?$this->candidate[0]["candidate_id"]:0;
			$pos="";
			if($positionSts==1)
			{
				$pos=" of current position";
			}elseif($positionSts==2){
				$pos=" of closed position";
			}else{
				$pos=" ";
			}
			if($position_name=="")
			{
				
				$position_name=" all position ";
			}
		?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo asnd sidebar -->
           
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="">                
                <!-- Content Header (Page header) -->
                <section class="content-header">
                   
                   	<!-- Help start -->
                     <div id="mySidenav" class="sidenav">
			  <div class="helpHeader"><span >Help</span><a href="javascript:void(0)" class="closebtn text-right" onclick="closeNav()">×</a></div>
			  <div id="sidenavData" class="sidenavData">
				
			  </div>
			</div>
			
			<script>
			function openNav() {
				document.getElementById("mySidenav").style.width = "400PX";
				$('#sidenavData').load('<?=URL?>help/helpNav', {'page': 'results'});	
			}
			function closeNav() {
				document.getElementById("mySidenav").style.width = "0";
			}
			</script>
               
 <!-- help close -->
                </section>
                <!-- Main content -->
                <section class="content" id="printsection">
                    <div class="row">
                        <div class="col-xs-12">
                            <!-- /.box -->
                            <div class="box">
                                <div class="box-header">
                                    
									<!-- tools box -->
                                    <div class="pull-left box-tools">
										<form action="<?php echo URL?>report/candidatebydate/3" method="post"><input type="hidden" id="startdate" name="startdate">
								<input type="hidden" id="enddate" name="enddate">
								<div class="bargraph">
								<div id="reportrange" class="" style="background: #fff;height:28px; cursor: pointer;border: 1px solid #ccc; width: 100%">&nbsp;&nbsp;
<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
<span></span> <b class="caret"></b>&nbsp;&nbsp;
</div>
								</div> &nbsp;&nbsp;
					<select id="positionSts" name="positionSts" style="height:31px" onchange="onchangepositionsts(this.value)">
					<option value="1" <?php if($positionSts==1){echo "selected";}?>>Current Positions</option>
					<option value="2" <?php if($positionSts==2){echo "selected";}?>>Closed Positions</option>
					<option value="3" <?php if($positionSts=="3"){echo "selected";}?>>Both</option>
					</select>&nbsp;&nbsp;<select id="position" name="position" style="height:31px"><option value="0">----  All Current Positions  ---</option><?php
										
											if (isset($this->positions)) {
												
										foreach($this->positions as $key => $value) {
											$selected="";
											if($positionid==$value['designation_id']){
												$selected="selected";
											}
										echo "<option value='".$value['designation_id']."' $selected>".$value['designation_name']."</option>";
												}
											} 
										?></select>
                                        <button type="submit" class="btn btn-info btn-sm"  data-toggle="tooltip" title="Search"><i class="fa fa-search"></i></button>
										</form>
                                    </div><!-- /. tools --> 
									
										 <div class="pull-right box-tools">									
                                       <button onclick="print()" class="btn btn-info btn-sm"  data-toggle="tooltip" title="Print"><i class="fa fa-print"></i></button> &nbsp;<button class="btn btn-info btn-sm" id="create_pdf" onclick="createpdf()" title="pdf" data-toggle="tooltip"><i class="fa fa-file"></i></button>  <a href="#"><button class="btn btn-info btn-sm"  data-toggle="tooltip" title="Refresh" onclick="location.reload();"><i class="fa fa-refresh"></i></button></a> 
                                        
                                       
                                    </div>
                                </div><!-- /.box-header -->
									<!-- <h3 class="text-center">Report</h3>-->
									 <h3 class="text-center">Tests Scheduled<small> <?=$position_name?> <?=$pos?> from:<b> <?=date("d M", strtotime($startdate))?> to <?=date("d M Y", strtotime($enddate))?></b></small></h3>
									
                                <div class="box-body table-responsive">
									<?php $this->renderFeedbackMessages(); ?>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr style="background-color:gray;color:#ffffff;">
												
												<th>Name</th>
												<th>Position</th>
												<th>Level</th>
												<th>Schedule Date</th>
												<th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
											$index=1;
											if ($this->schedule) {
												
											foreach($this->schedule as $key => $value) {
																								                                                       $name=isset($value["candidate"])? $value["candidate"] :" ";
												$position=isset($value["designation_name"])?$value["designation_name"]:"No Feedback Given";
												$schedule=isset($value["schedule_date"])?$value["schedule_date"]:"No Remark Given";
												$schedule_date=date("d M Y h:i A", strtotime($schedule));
													
													echo '<tr>';
													
													echo '<td>'.$name .'</td>';
													
													echo '<td>'.$position.'</td>';
													echo '<td>'.$value["level"].'</td>';
													echo '<td>'.$schedule_date.'</td>';
													
													
													echo'<td> &nbsp;&nbsp;&nbsp;&nbsp;<a href="'. URL . 'candidate/details/' . $value["candidate_id"].'" target="_blank"  title="View Candidate" rel="tooltip" class="label bg-blue"><i class="fa fa-eye"></i></a>';
													
													
													echo '</td></tr>';
													
												}
											}
										?>
                                        </tbody>    
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col-xs-12 -->
                    </div><!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

	<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">            
            <div class="modal-body">
                <h4>Do you want to delete this Candidate?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="#" class="btn btn-danger danger">Delete</a>
            </div>
        </div>
    </div>
</div>

	<!-- jQuery 2.0.2 -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
	<!-- Bootstrap -->
	
		<script src="<?php echo URL;?>public/js/bootstrap-datepicker.js" type="text/javascript"></script>
	<script src="<?php echo URL;?>public/js/bootstrap.min.js" type="text/javascript"></script>
	<!-- DATA TABES SCRIPT -->
	<script src="<?php echo URL;?>public/js/plugins/responsive/jquery.dataTables.min.js" type="text/javascript"></script>
	<script src="<?php echo URL;?>public/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo URL;?>public/js/plugins/responsive/dataTables.tableTools.js"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo URL;?>public/js/AdminLTE/app.js" type="text/javascript"></script>
	<!-- For Rating JS -->
	<script src="<?php echo URL;?>public/js/starrr.js" type="text/javascript"></script>   
			<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
			
			<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
			 <script src="<?php echo URL;?>public/js/html2canvas.min.js" type="text/javascript"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
	<!-- page script -->
	<script type="text/javascript">
	
	
	 
	
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
				pdf.save("scheduletest_report.pdf");
			});
		  }
	
		$('#confirm-delete').on('show.bs.modal', function(e) {
				$(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
			});
			$('#confirm-edit').on('show.bs.modal', function(e) {
				$(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
			});
			///////////// Tool Tip///////
			 $('body').tooltip({ 
			selector: '[rel=tooltip]' 
			});  
		
$( "#startdate" ).datepicker(
	{
		format: 'yyyy-mm-dd',
	autoclose: true
	}
);
			 

		 
$( "#enddate" ).datepicker(
	{
		format: 'yyyy-mm-dd',
	autoclose: true
	}
);

            $(function() {
               $('#example1').DataTable({
				    "bLengthChange": true,
					"iDisplayLength": 100,
					"dom": 'T<"clear">lfrtpi<"clear">',
					"tableTools": {
					"sSwfPath": path+"public/js/plugins/responsive/swf/copy_csv_xls.swf",
					"aButtons": [
					"copy",
					"print",
					"xls"
				]
				},
			   });
			   
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": true,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });
        </script>
			<script type="text/javascript">
var start = moment("<?=$startdate?>");
var end = moment("<?=$enddate?>");
function cb(start, end)  {
$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
}
$('#reportrange').daterangepicker({
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
},cb);
cb(start, end);
	 $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
$('#startdate').val(picker.startDate.format('YYYY-MM-DD'));
		 $('#enddate').val(picker.endDate.format('YYYY-MM-DD'));
		
});
$('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
$('#startdate').val('');
	$('#enddate').val('');
});			
	function onchangepositionsts($val)
{
	$.ajax({
		type:'POST',
		url:'<?= URL ?>'+'designation/positionBySts',
		data:'positionSts=' +$val,
		success:function(data)
		{
			var str="";
			var obj = jQuery.parseJSON( data );
			var data1=obj.data;
			if(data1.length!=0)
			{
				var html="";
				//var files= JSON.parse(data1);
				//console.log(files.length);
				$('#position').html(html);
				/* $('#tests').append($("<option></option>")
.attr("value", "").text("Please select")); */
				for(var i=0;i<data1.length;i++){
					if(i==0 && $val==1){
						$('#position').append($("<option></option>")
.attr("value", 0).text("---All Current Position---"));
					}
					if(i==0 && $val==2){
						$('#position').append($("<option></option>")
.attr("value", 0).text("---All Closed Position---"));
					}
					if(i==0 && $val==3){
						$('#position').append($("<option></option>")
.attr("value", 0).text("---All Position---"));
					}
					$('#position').append($("<option></option>")
.attr("value", data1[i]['id']).text(data1[i]['name']));
				}
			}
		}
	});
}	

	
				
</script>

    </body>
</html>
