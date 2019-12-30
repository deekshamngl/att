<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" />
	<title>ubiAttendance</title>
	<style>
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
		
		      #example thead tr th.headerSortUp  {
               background-image: url('<?=URL?>../assets/img/up_arrow.png');
              }
              #example thead tr th.headerSortDown  {
              background-image: url('<?=URL?>../assets/img/down_arrow.png');
             }
			 #example tbody tr td.lalign {
             text-align: left;
                   }
				   .id{
					   color:grey;
				   }
				  
	.t2{display:none;}
	</style>
	<style type="text/css" media="print" >
 .print 
 {
     margin-left:40px;
     align:center;
	 border:2px #666 solid; padding:5px;  
 }

          .nonPrintable
		  {display:none;} /*class for the element we don’t want to print*/
         </style>
</head>
<body>
	<div class="wrapper">
		<?php
		    if($id==1)
			  $data['pageid']=6;
		    else
				$data['pageid']=5;
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
	                                <h4 class="title">Import Designation</h4>
	                                <p class="category"> </p>
	                        </div>
	                    <div class="card-content">
						<table id="example" class="display table" width="100%">
						<thead>
							<tr style="background-color:#68d46d;color:#ffffff;">
								<th width="">Department</th>
								<th width="">Designation</th>
								<th width="">date</th>
								<th width="">Remark</th>
							</tr>
						</thead>
						</table>			
						</div>
						</div>
					</div>
	    		</div>
	    	</div>
	
	       <div id="output"></div>
			<div class="col-md-3 t2" id="sidebar" style="margin-top:100px;"></div>
	       
			<footer class="footer">
				<div class="container-fluid">
					<nav class="pull-left">
						
					</nav>
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
		</div>
			



</body>
<script src="<?=URL?>../assets/js/bootstrap-timepicker.min.js" type="text/javascript"></script>

	<script src="<?=URL?>../assets/js/buttons.colVis.min.js"></script>
	<script type="text/javascript" src="<?=URL?>../assets/js/buttons.print.min.js"></script>
	<script src="<?=URL?>../assets/js/dataTables.buttons.min.js"></script>
	 <script type="text/javascript" src="<?=URL?>../assets/js/moment.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/daterangepicker.js"></script>
	  
      <script type="text/javascript" src="<?=URL?>../assets/js/buttons.flash.min.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/jszip.min.js"></script>
		 <script type="text/javascript" src="<?=URL?>../assets/js/jquery.dataTables.min.js"></script>
	    <script type="text/javascript" src="<?=URL?>../assets/js/buttons.html5.min.js"></script>
	<div id="mySidenav" class="pull-right sidenav" style="background-image:url(<?=URL?>../assets/img/bg7.jpg);background-repeat:no-repeat;">
						
						<div id="sidenavData" class="sidenavData">
						</div>
					</div>
	
	<script>
    	$(document).ready(function(){
    		var table = $("#example").DataTable({
				

				"contentType": "application/json",
				order: [[ 1, 'asc' ]],
				"scrollX": true,
				"lengthChange":true,
				dom: 'Bfrtip',
				"bSort": false,
		        buttons: [
						'pageLength','copy','csv','print', 'excel','pdfHtml5', 
						
					],
				
				 "bDestroy": false, 
				/* buttons: [
				'colvis',
				], */
				 "contentType": "application/json",
				"ajax": "<?php echo URL;?>admin/getEmpotTmpDes",
				/* "columnDefs": [
					
				], */
				"columns": [
					 { "data": "deprt" },
					  { "data": "desg" },
					  {"data":"Date"},
					  {"data":"remark"}
						
				   ]	   
				  
			});
			});

	
	</script>
	
	

</html>
