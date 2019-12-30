<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/fixedColumns.dataTables.min.css"/><link rel="stylesheet" href="<?=URL?>../assets/css/jquery.dataTables.min.css"/>
	<link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" />

	<title>ubiAttendance</title>
	<style>
select:invalid{ color: #AAAAAA; }
option[value=""][disabled] {
  display: none;
}
option {
  color: black;
}
div:{
	color: black;
}
</style>
</head>
<body>
       
	<div class="wrapper">
		<?php
			$data['pageid']=3.14;
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
						<?php if($this->session->flashdata('success') == 'Organization registered successfully'){ 
	                     ?><script>
							doNotify('top','center',2,'Organization registered successfully');
						 </script>
							
                        <?php 
						}if($this->session->flashdata('success') == 'Organization updated successfully'){ ?>
						  <script>
							doNotify('top','center',2,'Organization updated successfully');
						 </script>
						<?php }
						if($this->session->flashdata('error')){ ?>
						<script>
							doNotify('top','center',2,'Email id is already exists.');
							

						 </script>
						<?php
						}
						 ?>
					   	<!-- this message for success or error end-->
	                        <div class="card">
	                            <div class="card-header" data-background-color="purple">
	                                <h4 class="title">Add Organization</h4>
	                                <p class="category">Organization Settings</p>
	                            </div>

	                            
  
    <!-- Modal content-->
    
	
     <!--  <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Add Organization</h4>
      </div> -->
      <div class="">
		<form id="deptFrom" action="<?php echo URL;?>ubitech/registerOrganization"  >
			<div class="row">
				<div class="col-md-12">
				<div class="col-md-6">
					
				<div class="form-group label-floating">
						<label class="control-label">Organization Name <span class="red"> *</span></label>
						<input type="text" id="org_name" name="org_name" class="form-control  alpha" >
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating">
						<label class="control-label">Contact Person Name<span class="red"> *</span></label>
						<input type="text" id="name" name="name" class="form-control alpha" >
					</div>
				</div>
			</div>
				<div class="col-md-12">
					<div class="col-md-6">
					 
					<div class="form-group label-floating" style="margin-left: 10px;">
						<label class="control-label">Email<span class="red"> *</span></label>
						<input type="email" id="email" name="email" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating" style="margin-left: 5px;">
						<label class="control-label">Phone<span class="red"> *</span></label>
						<input type="text" id="phone" name="phone" class="form-control numeric" pattern="[0-9]{1}[0-9]{9}">
					</div>
				</div>
			</div>
			<div class="col-md-12">
					<div class="col-md-6">
					<div class="form-group label-floating" style="margin-left: 10px;">
						<select id="country" name="country" class="form-control" required>
						       <option value="">Country<span class="red"> *</span></option>
						    <?php foreach ($h->result() as $row){ ?>
		                       <option value="<?php echo $row->Id;?>" ><?php echo $row->Name;?></option>
                            <?php } ?> 
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group label-floating" style="margin-left: 5px;margin-top: 10px;">
						<label class="control-label" style="margin-top: 30px;">Address<span class="red"> *</span></label>
						<textarea id="Address" name="Address" class="form-control" style=""></textarea>
					</div>
				</div>
				</div>
			</div>
			
			<div class="clearfix"></div>
		</form>
		
		
		
      </div>
      <div class="">
        <button type="button" id="save"  class="btn btn-success" style="    margin-left: 10px;">Save</button>
        
      </div>
	
    
 

	                        </div>

	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>











</body>

<script>
	$(document).ready(function(){
		$("#save").click(function(){
			var org_name =  $("#org_name").val();
            var con_per_name =  $("#name").val();
            var org_email =  $("#email").val();
            var phone =  $("#phone").val();
            var country =  $("#country").val();
            var address =  $("#Address").val();
			var len = $("#phone").val().length;
			if(org_name == ""){
				doNotify('top','center',4,'Please enter organization name.');
				return false;
			}
			if(con_per_name == ""){
				doNotify('top','center',4,'Please enter contact person name.');
				return false;
			}
			if(org_email == ""){
				doNotify('top','center',4,'Please enter email.');
				return false;
			}
			 if(!validateEmail(org_email.trim())){
					alert(org_email+' is not a valid mail id, please check');
					return false;
				  }
			if(phone == ""){
				doNotify('top','center',4,'Please enter phone no.');
				return false;
			}
			if(len < 8){
					  $('#phone').focus();
						doNotify('top','center',4,'Please enter the valid Phone ');
						return false;
				  }	if(isNaN($('#phone').val())){
					  $('#phone').focus();
						doNotify('top','center',4,'Phone  can contains digits only');
						return false;
				  }	
			if(country == 0){
				doNotify('top','center',4,'Please select country.');
				return false;
			}
			if(address == "")
			{
				doNotify('top','center',4,'Please enter address.');
				return false;
			}
			function validateEmail(org_email) {
			var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(String(org_email).toLowerCase());
		}
			$("#deptFrom").submit();
		});
    	});
		<!-- for alert message (start) -->
		 $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
         $("#success-alert").slideUp(500);
        });
		<!-- alert message (end)-->
	</script>
</html>

