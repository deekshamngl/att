<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>QR Code Options</title>
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?=URL?>../assets/css/daterangepicker.css" />
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  
    <link href="<?=URL?>../assets/css/demo.css" rel="stylesheet" />
    
    
    

   <script src="<?=URL?>../assets/js/custom.js" type="text/javascript"></script>
   <script src="<?=URL?>../assets/js/demo.js"></script>
   <script src="<?=URL?>../assets/js/bootstrap-notify.js"></script>
   <script src="<?=URL?>../assets/js/bootstrap.min.js" type="text/javascript"></script>
   <link href="<?=URL?>../assets/css/css.css" rel="stylesheet" />
   <link href="<?=URL?>../assets/css/material-dashboard.css" rel="stylesheet"/>
   <link href="<?=URL?>../assets/css/bootstrap.min.css" rel="stylesheet" />
	
	<style>
	
	
	.card img {
    width: 20% !important;
    height: 20% !important;
}
		.red{
			color:red;
			font-weight:'bold';
			font-size:16px;
		}
		.delete{
			cursor:pointer;
		}
		td{
			   // width: 7%!important;
				///text-align: center!important;
				max-width:250px;
				word-wrap:break-word;
		}
		div.dt-buttons{
			position:relative;
			float:left;
			margin-left:15px;
			}
		#content {
			
			-webkit-transition: width 0.3s ease;
			-moz-transition: width 0.3s ease;
			-o-transition: width 0.3s ease;
			transition: width 0.3s ease;
		}
		#content .btn-group {
			margin-bottom: 10px;
		}
		
	
		
		.t2{display:none;}
	</style>
</head>
<body>
   <div class="modal fade" id="loadmodel" role="dialog" data-backdrop="static" data-keyboard="false" style="z-index:11111111;margin-top:100px;" >
			<div class="modal-dialog" >
				<center>
					<img src="<?php echo URL; ?>../assets/img/loaderimg.gif" alt="loader image" height="20%" width="20%" />
				</center>
			</div>
     </div> 

	<div class="wrapper">
		<?php
			$data['pageid']=12.11;
			$this->load->view('menubar/sidebar',$data);
		?>
	    <div class="main-panel">
			<?php
				$this->load->view('menubar/navbar');
			?>
			<div class="content" id="content">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-md-12">
	                        <div class="card">


	                            <div class="card-header" data-background-color="green">
									 <p class="category" style="color:#ffffff;font-size:17px;"> QR Code Options </p>
									
	                            </div>

	                            <div>
	                            	<h3 style="margin-left:25px;"> Please Select a Template For QR Code </h3>
	                            </div>

	                            <div style="margin-top:20px;margin-bottom:20px;">

	                        	<form method="post" id="qrselect">
  <!-- <input type="radio" name="gender" value="1" style="margin-left:10px;"> <img src="<?php echo URL; ?>../assets/img/qrimg1.png" alt="qr image1" width="55%" />
  <input type="radio" name="gender" value="2" style="margin-left:15px;"> <img src= "<?php echo URL; ?>../assets/img/qrimg2.png" alt="qr image 2" width="30%" /> </br> -->
  <input type="radio" name="gender" value="3" style="margin-left:25px"> <img src= "<?php echo URL; ?>../assets/img/realqr.png" alt="qr image 3" height="20%" width="20%" /> 
  <input type="radio" name="gender" value="4" style="margin-left: 110px;
}"> <img src= "<?php echo URL; ?>../assets/img/jalsaqr1.png" alt="qr image 4" height="20% !impoe" width="20%" />
  <!-- <?php echo $qrselector ?> -->
</form>

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
   $('input[type="radio"]').click(function(){

        var home = $(this).val();
        
        
        
        // alert(home);
        // var id = $(this).attr('id');
        $.ajax({
             url:"<?php echo URL;?>admin/qrcodeselector",
             method:"POST",
             data:{home:home},

             success: function(result){
							//alert(result);
							if(result == 1){
								 doNotify('top','center',2,'QRTemplate Selected Successfully.'); 
								 table.ajax.reload();  
					        }
                            if(result == 0)
							{
								doNotify('top','center',4,"This Template Is Already Selected."); 
							}
                             							
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
							 
						 }
        });
   });
});
</script>
	</html>