<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<title>ubiAttendance</title>
</head>
<body  >

	<div class="wrapper">
		<?php
			$data['pageid']=1;
			$this->load->view('ubitech/sidebar',$data);
		?>
	    <div class="main-panel">
			<?php
				$this->load->view('ubitech/navbar');
			?>
			<div class="content">
	            <div class="container-fluid">
				   <div class="row" >
				    <div class="col-sm-12" >
	                    
	                   </div>
					  
	                </div>
					
	            </div>
	        </div>
		</div>
	</div>
   <footer class="footer">
				<div class="container-fluid">
					<p class="copyright pull-right">
						&copy; <script>document.write(new Date().getFullYear())</script> <a href="#"> DESIGNED BY </a>Ubitech Solutions Pvt. Ltd.
					</p>
				</div>
  </footer>
</body>

	

  <script src="<?=URL?>../assets/js/dataTables.buttons.min.js"></script>
   <script type="text/javascript" src="<?=URL?>../assets/js/moment.js"></script>
 <script type="text/javascript" src="<?=URL?>../assets/js/buttons.print.min.js"></script>
 <link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css"/>
	 <script src="<?=URL?>../assets/js/buttons.colVis.min.js"></script>
	   <script type="text/javascript" src="<?=URL?>../assets/js/pdfmake.min.js"></script>
	  <script type="text/javascript" src="<?=URL?>../assets/js/buttons.html5.min.js"></script>
	<script type="text/javascript">
      </script>
	 <script>
	    
	 </script>
	

</html>
