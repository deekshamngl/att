<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>UBIHRM | Report List</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="<?php echo URL;?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="<?php echo URL;?>public/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo URL;?>public/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo URL;?>public/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
	<?php include(VIEWS_PATH."_templates/sidebar.php");?>
 <!-- Ionicons -------->

    
    <!-- DATA TABLES -------->

    <link href="<?php echo URL;?>public/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="<?php echo URL;?>public/plugins/responsive/dataTables.tableTools.css">
  </head>
  <body class="skin-green sidebar-collapse" ng-app="leaveapi" ng-controller="reportCtrl" ng-init="reportid=<?= $this->reportid ?>;onfetchreport1(reportid);">
    <!-- Site wrapper -->
    <div class="wrapper">
      

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        

        <!-- Main content -->
        <section class="content">
	
          <!-- Default box -->
          <div class="box box-solid " >
           <form class="form">
            <div class="box-body">
			
					<div class="col-xs-12 text-right">
						<a class="btn btn-info" href="<?= URL; ?>attendance/htmltopdf/<?= $this->reportid ?>" title="To enable snapshot allow pop-up, after the snapshot appears you can copy & mail." rel="tooltip" >Mail</a>
					</div>							
						 
						
			
               <table id="example" class="display table" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>Name</th>
													<th>UserName</th>
													<th>Designation</th>
													<th>Shift</th>4
													<th>Department</th>
													<th>Contact</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</thead>
										</table>
                </div><!-- /.box-body -->
				</form>
				<div class="overlay" id="refresh_div">
                  <i class="fa fa-refresh fa-spin"></i>
                </div>
              </div><!-- /.box -->
           
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <footer class="main-footer">
        <?php footertext();?>
      </footer>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.3 -->
    <script src="<?php echo URL;?>public/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo URL;?>public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo URL;?>public/angularjs/angular.min.js" type="text/javascript"></script>
   <!-- DATA TABES SCRIPT -->
    <script type="text/javascript"  src="<?php echo URL;?>public/plugins/table_pdf/jspdf.min.js"></script>
		<script type="text/javascript" src="<?php echo URL;?>public/plugins/table_pdf/html2canvas.min.js"></script>
		
   <script type="text/javascript" src="<?php echo URL;?>public/plugins/responsive/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="<?php echo URL;?>public/plugins/responsive/dataTables.tableTools.js"></script>
	<script type="text/javascript" src="<?php echo URL;?>public/plugins/responsive/dataTables.responsive.min.js"></script>
	<script type="text/javascript" src="<?php echo URL;?>public/plugins/responsive/dataTables.bootstrap.js"></script>
    <!-- SlimScroll -->
    <script src="<?php echo URL;?>public/plugins/slimScroll/jquery.slimScroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='<?php echo URL;?>public/plugins/fastclick/fastclick.min.js'></script>
  <!---------------------------------------------------->
  
<script src="<?php echo URL;?>public/angularjs/leave.js" type="text/javascript"></script>

<script src="<?php echo URL;?>public/angularjs/alerts.js" type="text/javascript"></script>

    <script type="text/javascript">
	
		var table=$('#example').DataTable( {
				//"bSort": true,
				"scrollX": true,
				"contentType": "application/json",
				"ajax": "<?php echo URL;?>report/getEmployeesData",
							
				"columns": [
				   
					{ "data": "name" },
					{ "data": "username" },
					{ "data": "designation" },
					{ "data": "shift" },
					{ "data": "department"},
					{ "data": "contact" },
					{ "data": "status" },
					{ "data": "action" }
				]
			});
	
	
      $(function () {
		//demo.remove();
        
		$( "#refresh_div" ).hide();
		$( "#refresh_" ).click(function() {
			$( "#refresh_div" ).show();
		  setTimeout(function(){ $( "#refresh_div" ).hide(); }, 3000);
		});
		
			$('body').tooltip({
		selector: '[rel=tooltip]'
	});	
      });
	 	(function(){
var
	form = $('.form'),
	cache_width = form.width(),
	a3  =[ 841.89, 1190.55];  // for a4 size paper width and height

$('#create_pdf').on('click',function(){
	$('body').scrollTop(0);
	createPDF();
});
//create pdf
function createPDF(){
	getCanvas().then(function(canvas){
		var
		img = canvas.toDataURL("image/png"),
		doc = new jsPDF({
          unit:'px',
          format:'a3'
        });
        doc.addImage(img, 'JPEG', 20, 20);
		window.open(img)
       // doc.save('Employee_dashboard.pdf');
        //form.width(cache_width);
	});
}

// create canvas object
function getCanvas(){
	form.width((a3[0]*1.33333) -80).css('max-width','none');
	return html2canvas(form,{
    	imageTimeout:2000,
    	removeContainer:true
    });
}

}());
    </script>
  </body>
</html>
