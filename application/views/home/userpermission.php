
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<link href="<?=URL?>../assets/css/bootstrap-timepicker.min.css" rel="stylesheet"/>
	<link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>timeoffs</title>
	<style>
		.red{
			color:red;
			font-weight:'bold';
			font-size:16px;
		}
		.delete{
			cursor:pointer;
		}
		.t2{
			display: none;
		}
		.bargraph{
			display:inline-block;
			margin-top:-8px;
			margin-left:-17px;
    	}
		
		.panel-footer
		{
			height:38px;
			background-color:#7aa07e;
			padding-left:190px !important;
		}
		
		.editbutton {
			color: #ffc107 !important;
			background-color: transparent !important;
			border-color: #ffc107 !important;
			padding: 11px !important;
			margin-right:0px !important;
			
		}
		/* The containerE */
	.containerE {
		display: block;
		position: relative;
		padding-left: 45px;
		margin-bottom: -2px;
		cursor: pointer;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}

	/* Hide the browser's default checkbox */
	.containerE input {
		position: absolute;
		opacity: 0;
		cursor: pointer;
		height: 0;
		width: 0;
	}

	/* Create a custom checkbox */
	.checkmark {
		position: absolute;
		top: 0;
		left: 0;
		bottom: 0;
		height: 20px;
		width: 20px;
		background-color: #eee;
	}

	/* On mouse-over, add a grey background color */
	.containerE:hover input ~ .checkmark {
		background-color: #ccc;
	}

	/* When the checkbox is checked, add a blue background */
	.containerE input:checked ~ .checkmark {
		background-color: #2196F3;
	}

	/* Create the checkmark/indicator (hidden when not checked) */
	.checkmark:after {
		content: "";
		position: absolute;
		display: none;
	}

	/* Show the checkmark when checked */
	.containerE input:checked ~ .checkmark:after {
		display: block;
	}

	/* Style the checkmark/indicator */
	.containerE .checkmark:after {
		left: 9px;
		top: 5px;
		width: 5px;
		height: 10px;
		border: solid white;
		border-width: 0 3px 3px 0;
		-webkit-transform: rotate(45deg);
		-ms-transform: rotate(45deg);
		transform: rotate(45deg);
	}
	</style>
</head>
<body ng-app="permissionapp" ng-controller="permissionCtrl" >
	<div class="wrapper">
		<?php
			$data['pageid']=14;
			$this->load->view('menubar/sidebar',$data);
		?>
	    <div class="main-panel">
			<?php
				$this->load->view('menubar/navbar');
				$data=isset($data)?$data:'';
				$id=isset($id)?$id:0;
				$startdate=isset($this->startdate)?$this->startdate:"Start";
				$enddate=isset($this->enddate)?$this->enddate:"End";
			?>
			
			<div class="content" id="content">
	            <div class="container-fluid">
	            <div class="row">
	            <div class="col-md-12">
	            <div class="card">
				<div class="card-header" data-background-color="green">
					<p class="category" style="color:#ffffff;font-size:17px;" >Set User Permissions </p>
				</div>
	              <div class="card-content">
				   <div id="typography">
				   <div class="row" >
				     <!----- first column ------>
				     <div class="col-sm-4 col-md-4" >
					 <div  class="panel-group" id="accordion" >
					  <?php 
                        $data= json_decode(getAllDesg($_SESSION['orgid']));
						for($i=0;$i<count($data);$i++){
						if(($i+1)%3==1)
						{
					  ?>
					   <!--open panel group -->
						<div class="panel panel-default">
						  <div class="panel-heading" style="background-color:#7aa07e" >
							<h4 class="panel-title">
							  <p class="category" style="color:#ffffff;font-size:14px;" ><?= $data[$i]->name . " "; ?></p>
							</h4>
							<a data-toggle="collapse" data-parent="#accordion" href="#<?= $data[$i]->id; ?>" class="btn editbutton pull-right" style="position:relative;margin-top:-35px;" >
                           <i class="fa fa-pencil" style="margin-top:0px;top:0px;" ></i></a>
						  </div>
						  <div id="<?= $data[$i]->id; ?>" class="panel-collapse collapse">
						   
							<ul class="list-group">
							 <?php $data1 = getpermission($data[$i]->id,$_SESSION['orgid']);
                              for($j=0;$j<count($data1);$j++)
							  {							 
							 ?>
							  <li class="list-group-item">
							     <label class="containerE">
								  <input type="checkbox" value="<?= $data1[$j]['moduleid'] ?>" name="<?= $data[$i]->id.'[]'; ?>"  ng-checked="<?= $data1[$j]['vsts'] ?>" /> <?= $data1[$j]['label'] ?>
								  <span class="checkmark"></span>
								</label>
							  </li>
							  <?php } ?>
							</ul>
							
							<div class="panel-footer"><button class="btn btn-success btn-sm"  style="position:absolute;margin-top:-6px;" ng-click="updateuserpermission(<?= $data[$i]->id; ?>)" >Update</button>
							</div>
						  </div>
						 </div>
					         	<!--close panel group -->
						 <?php 
					 }
				   }
						 ?>					   
					  </div> 
					 </div> 	<!--close  div   col-sm-4 -->
					  <!------- second column ------>
                     <div class="col-sm-4 col-md-4" >
					 <div  class="panel-group" id="accordion1" >
					  <?php 
                        $data= json_decode(getAllDesg($_SESSION['orgid']));
						 for($i= 0;$i<count($data);$i++){
					     if(($i+1)%3==2)
					    	{
					  ?>
					  
						<div class="panel panel-default">
						  <div class="panel-heading" style="background-color:#7aa07e" >
							<h4 class="panel-title">
							  <p class="category" style="color:#ffffff;font-size:14px;" ><?= $data[$i]->name . " "; ?></p>
							</h4>
							<a data-toggle="collapse" data-parent="#accordion1" href="#<?= $data[$i]->id; ?>" class="btn editbutton pull-right" style="position:relative;margin-top:-35px;" >
                           <i class="fa fa-pencil" style="margin-top:0px;top:0px;" ></i></a>
						  </div>
						  <div id="<?= $data[$i]->id; ?>" class="panel-collapse collapse">
							<ul class="list-group">
							 <?php $data1 = getpermission($data[$i]->id,$_SESSION['orgid']);
                              for($j=0;$j<count($data1);$j++){							 
							 ?>
							  <li class="list-group-item">
							     <label class="containerE">
								  <input type="checkbox" value="<?= $data1[$j]['moduleid'] ?>" name="<?= $data[$i]->id.'[]'; ?>"  ng-checked="<?= $data1[$j]['vsts'] ?>" /> <?= $data1[$j]['label'] ?>
								  <span class="checkmark"></span>
								</label>
							  </li>
							  <?php } ?>
							</ul>
							<div class="panel-footer"><button class="btn btn-success btn-sm"  style="position:absolute;margin-top:-6px;" ng-click="updateuserpermission(<?= $data[$i]->id; ?>)" >Update</button></div>
						  </div>
						 </div>
					   
						 <?php 
						 }
						 }
						 ?>			
					  </div> 	
					 </div> <!--close  div   col-sm-4 -->
					  <!----- third column ----->
                     <div class="col-sm-4 col-md-4" >
					  <div  class="panel-group" id="accordion2" >
					  <?php 
                        $data= json_decode(getAllDesg($_SESSION['orgid']));
						 for($i= 0;$i<count($data);$i++)
						 {
						 if(($i+1)%3==0)
						  {
					     ?>
					  
						<div class="panel panel-default">
						  <div class="panel-heading" style="background-color:#7aa07e" >
							<h4 class="panel-title">
							  <p class="category" style="color:#ffffff;font-size:14px;" ><?= $data[$i]->name . " "; ?></p>
							</h4>
							<a data-toggle="collapse" data-parent="#accordion2" href="#<?= $data[$i]->id; ?>" class="btn editbutton pull-right" style="position:relative;margin-top:-35px;" >
                           <i class="fa fa-pencil" style="margin-top:0px;top:0px;" ></i></a>
						  </div>
						  <div id="<?= $data[$i]->id; ?>" class="panel-collapse collapse">
							<ul class="list-group">
							 <?php $data1 = getpermission($data[$i]->id,$_SESSION['orgid']);
                              for($j=0;$j<count($data1);$j++){							 
							 ?>
							  <li class="list-group-item">
							     <label class="containerE">
								  <input type="checkbox" value="<?= $data1[$j]['moduleid'] ?>" name="<?= $data[$i]->id.'[]'; ?>"  ng-checked="<?= $data1[$j]['vsts'] ?>" /> <?= $data1[$j]['label'] ?>
								  <span class="checkmark"></span>
								</label>
							  </li>
							  <?php } ?>
							</ul>
							<div class="panel-footer"><button class="btn btn-success btn-sm"  style="position:absolute;margin-top:-6px;" ng-click="updateuserpermission(<?= $data[$i]->id; ?>)" >Update</button></div>
						  </div>
						 </div>
					   
						 <?php } 
						     }
						 ?>			
					  </div> 					 
					 </div> 	<!--close  div   col-sm-4 -->					 
					 </div>	<!-- close div row -->		
				  </div> <!-- close div typography -->
	             </div> <!-- content -->
	           </div>
	         </div>
	       </div>
	     </div>
	   </div>
	   <div class="col-md-3 t2" id="sidebar" style="margin-top:100px;"></div>
		<footer class="footer">
			<div class="container-fluid">	
			</div>
		</footer>
	<footer class="footer">
		<div class="container-fluid">
			<nav class="pull-left">
				
			</nav>
			<p class="copyright pull-right" style="padding-right:25px;" >
	  &copy; <script>document.write(new Date().getFullYear())</script>. Developed by<a href="http://www.ubitechsolutions.com/" target="_blank" > Ubitech Solutions </a></p>
		</div>
	</footer>
		</div>
		</div>

		<!------Edit Timeoff modal start------------>
<div id="editTimeoff" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Update Timeoff <b>&nbsp;&nbsp;<span id="empname" > </span></b> </h4>
      </div>
      <div class="modal-body">
        
		<form id="timeoffE">
			<input type="hidden" id="timeoffid" />
			<div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label >Time From<span class="red"> *</span></label>
						<input type="text" id="timefromE" class="form-control timepicker" disabled >
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label >Time To <span class="red"> *</span></label>
						<input type="text" id="timetoE" class="form-control timepicker" disabled >
					</div>
				</div>
			</div>	
            <div class="row">
				<div class="col-md-6">
					<div class="form-group label-floating" style="margin-top:42px;" >
						<label >Status<span class="red"> *</span></label>
						<select  class="form-control" id="timoffstatusE" > 
						  <option value="0" >-Select-</option>
						  <option value="1" >Rejected</option>
						  <option value="2" >Approved</option>
						  <option value="3" >Pending</option>
						  <option value="4" >Cancel</option>
						  <option value="5" >Withdrawn</option>
						  <option value="7" >Escalated</option>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label > Comment<span class="red"> *</span></label>
						<textarea  rows="2" cols="50" class="form-control" id="commentE" name="commentE" > </textarea>
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

<!------Edit location modal close------------>	
		
		

<!-----delete dept start--->
<div id="delDept" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Delete Location</h4>
      </div>
      <div class="modal-body">		
		<form>
			<input type="hidden" id="del_did" />
			<div class="row">
				<div class="col-md-12">
					<h4>Do you want to delete this Location "<span id="dna"></span>" ?</h4>
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
<!-----delete dept close--->
</body>
<div id="mySidenav" class="pull-right sidenav" style="background-image:url(<?=URL?>../assets/img/bg7.jpg);">
						<div class="helpHeader"><span><b>&nbsp;&nbsp;<i style="font-size:24px; color:black;"class="fa fa-question-circle" ></i ></b></span><a style="color:black;" href="javascript:void(0)" class="closebtn text-right" onclick="closeNav()">x </a></div>
						<div id="sidenavData" class="sidenavData">
						</div>
					</div>
					
	<script src="<?=URL?>../assets/js/bootstrap-timepicker.min.js" type="text/javascript"></script>


	 <script type="text/javascript" src="<?=URL?>../assets/js/moment.js"></script>
       <script type="text/javascript" src="<?=URL?>../assets/js/angular.min.js"></script>			
       <script type="text/javascript" src="<?=URL?>../assets/js/userpermission.js"></script>			
					
					
		<?php if(isset($success_sms))
             echo "<script> alert('Your location set successfull.'); </script>";
		 ?>			
					
	<script>
	function openNav() {
							document.getElementById("mySidenav").style.width = "360PX";
							$('#sidenavData').load('<?=URL?>admin/helpNav',{'pageid': 'departH'});	
						}
						function closeNav(){
							document.getElementById("mySidenav").style.width = "0";
						}
	
	</script>
   <script type="text/javascript">
            $('.timepicker').timepicker();
			$('input.timepicker').timepicker();
   </script>
	<script type="text/javascript">
	    	
	</script>
</html>
