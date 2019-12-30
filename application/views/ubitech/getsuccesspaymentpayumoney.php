<?php 
	$orgid=isset($_REQUEST['orgid'])?$_REQUEST['orgid']:'0';
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<script src="https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/3.2.6/css/fixedColumns.dataTables.min.css"/>
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css"/>
	<title>ubiAttendance</title>
</head>
<body>
	<div class="wrapper">
		<?php
			$data['pageid']=11.2;
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
						<?php if($this->session->flashdata('success') == 'Data inserted successfully'){ 
	                     ?><script>
							doNotify('top','center',2,'Data Inserted successfully.');
						 </script>
							
                        <?php unset($_SESSION['success']);
						}if($this->session->flashdata('success') == 'Data Updated successfully'){ ?>
						<script>
							doNotify('top','center',2,'Data Updated successfully.');
						 </script>
						<?php
						}
						if($result = $this->session->flashdata('error')){ 
	                     ?>
							<script>
							doNotify('top','center',4,'Some error occurs.');
						 </script>
                        <?php } ?>
					   	<!-- this message for success or error end-->
	                        <div class="card">
	                            <div class="card-header" data-background-color="purple">
	                                <h4 class="title">Transaction History <?php echo $orgid!=0?'for <b>'.getOrgName($orgid).'</b>':'- payu Payments';?></h4>
	                                <p class="category">Latest first</p>
	                            </div>
								<input type="hidden" value="<?php echo $orgid;?>" id="orgid" />
	                            <div class="card-content">
									<div id="typography">
										<div class="title">
											<div class="row">
												<div class="col-md-8">
												<!--	<h3>Manage Slider</h3> --->
												</div>
											</div>
										</div>
										<div class="row">
											<table id="example" class="display table" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th width="9%">Date</th>
													<th width="8%">Company(CRN)</th>
													<th width="8%">Activity</th>
													<th width="9%" >Plan Start</th>
													<th width="9%" >Plan End</th>
													<th>User Limit</th>
													<th>Payment Method</th>
													<!--<th>Payment Status</th>-->
													<th>Transaction ID</th>
													
													
													<th>Transaction Amount</th>
													<th>Discount</th>
													<th>Lead Owner</th>
													<th>Tax</th>
													<th width="15%">Remarks</th>
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
						&copy; <script>document.write(new Date().getFullYear())</script> <a href="#">Ubitech Pvt. Ltd.</a>, Connecting dots...
					</p>
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
  <script type="text/javascript" src="<?=URL?>../assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?=URL?>../assets/js/dataTables.fixedColumns.min.js"></script>
	<script type="text/javascript">
	var table;
		$(function(){
			var orgid=$('#orgid').val();
			 table=$('#example').DataTable( {
						"aaSorting": [],
						"scrollX": true,
						"contentType": "application/json",
						"fixedColumns":   {
            			 leftColumns: 1,
            			 rightColumns:1
        				},
        				dom: 'Bfrtip',
						"contentType": "application/json",
						
						buttons: [
					'pageLength','excel',
					{ 
                     "extend":'colvis', 
                     "columns":':not(:last-child)', 
                    } 
						],
						"ajax": "<?php echo URL;?>ubitech/getSuccessfulPaymentData/payumoney",
						"columns": [
							{ "data": "date" },
							{ "data": "company" },
							{ "data": "activity" },
							{ "data": "sdate" },
							{ "data": "edate" },
							{ "data": "userlimit" },
							{ "data": "paymentmthd" },
						//	{ "data": "pay_status" },
							{ "data": "transaction" },
							
							
							{ "data": "amount" },
							{ "data": "discount" },
							{ "data": "leadowner" },
							{ "data": "tax"},
							{ "data": "remark"},
							{ "data": "action"}
						]
					});
		});
			
	</script>
</html>
