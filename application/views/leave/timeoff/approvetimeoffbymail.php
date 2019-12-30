<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Ubiaatendance |  Timeoff Approval</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="<?php echo URL;?>../public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <!-- <link href="<?php echo URL;?>../public/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> -->
    <!-- Theme style -->
    <link href="<?php echo URL;?>../public/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
	<!-- Bootstrap Color Picker -->
    <link href="<?php echo URL;?>../public/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
	 <link href="<?php echo URL; ?>../public/plugins/iCheck/square/orange.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo URL;?>../public/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
	
	 
	  <!-- <?php
				 // $this->load->view('menubar/navbar');
			?>  -->
 <!-- Ionicons -------->


  </head>
  <body class="skin-green"  ng-app="leaveapi"  ng-controller="timeoffapprovalbymailCtrl" ng-init=" onfetch(userid,org_id,employeetimeoffid,approverresult,appSts); 
  ">
    <!-- Site wrapper -->
  <h1 class="text-center" ng-show="apptimeofSts!=5">{{result}}</h1>
  <div class="overlay text-center" ng-show="hastrue">
                  <h1><i class="fa fa-refresh fa-spin"></i></h1>
                </div>
				 <div  ng-show="apptimeofSts==5" class="overlay text-center" >
                  <h1>Time off has already withdrawn</h1>
                </div>
  <div  ng-show="apptimeofSts==3" class="modal fade" id="comment" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">            
			<div class="modal-body">
				<h4>{{remarks}}</h4>
				<textarea class="form-control" ng-model="comment" rows="4" placeholder="Please enter your remarks here"></textarea>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-success" ng-click="onapprove()">{{approvaltext}}</a>
			</div>
		</div>
	</div>
</div> 
<div class="modal fade" id="confirm" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">            
				<div class="modal-body">
					<h4>{{result}}</h4>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-info" data-dismiss="modal">Ok</button>
				</div>
			</div>
		</div>
	</div>


	
    <!-- jQuery 2.1.3 -->
    <script src="<?php echo URL;?>../public/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    

    <!-- Bootstrap 3.3.2 JS -->
    <!-- <script src="<?php echo URL;?>../public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> -->
	<script src="<?php echo URL;?>../public/angularjs/angular.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    
    <!-- FastClick -->
    <!-- <script src="<?php echo URL;?>../public/plugins/fastclick/fastclick.min.js"></script> -->
	<!-- iCheck -->
    <!-- <script src="<?php echo URL;?>../public/plugins/slimScroll/jquery.slimScroll.min.js" type="text/javascript"></script> -->
	 <!-- <script src="<?php echo URL; ?>../public/plugins/iCheck/icheck.min.js" type="text/javascript"></script> -->
	<!-- <script src="<?php echo URL;?>../public/angularjs/leave.js" type="text/javascript"></script> -->
	<!-- <script src="<?php echo URL;?>../public/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script> -->
  
	<script type="text/javascript">
   <?php 
   if($this->appSts==3){
	?>
		$("#comment").modal('show');
	   <?php
   }
?>
</script>
  </body>
</html>
