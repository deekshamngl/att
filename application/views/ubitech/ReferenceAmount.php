<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>ubiAttendance</title>
</head>
<body>  
  	
	<div class="wrapper">
		<?php
			$data['pageid']=786;
			$this->load->view('ubitech/sidebar',$data);
		?>
		<?php
$data=isset($data)?$data:'';


?>
	    <div class="main-panel">
			<?php
				$this->load->view('ubitech/navbar');
			?>

			
			<div class="content" >
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-md-12">
						
	                        <div class="card">
	                            <div class="card-header" data-background-color="purple">
	                                <h4 class="title">Referral Program</h4>
	                               
	                            </div>
	                         <div class="card-content">
						        <div id="typography">
									<input type="hidden" name="id" value="">		
								  <div class="row">
								  	   <div class="col-sm-4"style="margin-left: 75px;margin-top: 50px;">

								  	   	<?php 
								  	   	$c= "%";
								  	   	$b= $result['detail'][0]['ReferrerAmount'];
								  	   
								  	   		$a=	$b;

								  	   	// var_dump($c);
								  	   	

								  	   	{

								  	   	?>
								  	   	
								  	   	<label><b>Referrer Amount</b></label>
											<div class="input-group">
												<input  class="form-control" type="number"  id="refamt" value="<?php if(isset($result) && $result['res']==1 ){ echo $a  ; } ?>"> 

								  	   <?php } ?>
												<div class="input-group-btn">
												  <button class="btn btn-default" type="button" onclick="return false">
													%
												  </button>
												</div>
											  </div>
								  	   	
								  	   
								  	   </div>
								  	   
								  	   <!-- <div class="col-sm-4"style="margin-left: 50px;margin-top: 50px;text-align: center;">
								  	   	<label><b>Referral Amount Type</b></label><br><br>
								  	   
								  	   	<select id="type1" style="width: 50%;height: 40px;">
								  	   			<option value="<?php echo $result['detail'][0]['currencyreferrer'] ?>"  selected> <?php if($result['detail'][0]['currencyreferrer'] == 0){

								  	   				echo "Rupees(rs)";
                                                     }
                                                   elseif($result['detail'][0]['currencyreferrer'] == 1){
                                                   	  echo "doller($)";
                                                   	   }
                                                   	  else{

                                                   	  	echo "percentage(%)";
                                                   	  }
                                                 ?> </option>
								  	   		<option value="0">Rupees(rs) </option>
								  	   		<option value="1">doller($) </option>
								  	   		<option value="2">percentage(%) </option>
  
                                        </select>
								  	   </div> -->

								  	  <!--  <?php $result['detail'][0]['currencyreferrer'];

								  	   var_dump($result['detail'][0]['currencyreferrer']);
								  	   ?> -->
								  	   <div class="col-sm-4"style="margin-left: 75px;margin-top: 50px;">

								  	    	<?php

                                             $a="%";
                                             $b=$result['detail'][0]['ReferrenceAmount'];

                                             $c=	$b;


								  	    	?>
								  	   	<label><b>Referee Amount</b></label>
								  	   	
									   <div class="input-group">
										<input  class="form-control" type="number"  id="reffamt" value="<?php if(isset($result) && $result['res']==1 ){ echo $c ; } ?>">
								  	   
								  	   
												<div class="input-group-btn">
												  <button class="btn btn-default" type="button" onclick="return false">
													%
												  </button>
												</div>
											  </div>
									   </div>
								  	   
											
								  </div>
								  <div class="row">
								  	    <div class="col-sm-4" style="margin-left: 75px;margin-top: 50px;">
								  	   	<label><b>Valid From:</b></label>
										
								  	   	<input  class="form-control" type="datetime-local" id="valdf" value="<?php if(isset($result) && $result['res']==1 ){ echo str_replace(" ","T",$result['detail'][0]['ValidFrom']); } ?>">
								  	   </div>
								  	   <!-- <div class="col-sm-4"style="margin-left: 50px;margin-top: 50px;text-align: center;">
								  	   	<label><b>Referree Amount Type</b></label><br><br>
								  	   	<select id="type2" 
								  	   	style="width: 50%;height: 40px;">
                                         <!--<option value="<?php echo $result['detail'][0]['currencyreference'] ?>"  selected> <?php if($result['detail'][0]['currencyreference'] == 0){

								  	   				echo "Rupees(rs)";
                                                     }
                                                 elseif($result['detail'][0]['currencyreference'] == 1){
                                                   	  echo "doller($)";
                                                   	   }
                                                  else{

                                                   	  	echo "percentage(%)";
                                                   	  }
                                                 ?> </option>-->
								  	   		<!-- <option <?php if($result['detail'][0]['currencyreference'] == 0) echo "selected" ?> value="0">Rupees(rs) </option> -->
								  	   		<!-- <option <?php if($result['detail'][0]['currencyreference'] == 1) echo "selected" ?> value=1>doller($) </option> -->
								  	   		<!-- <option <?php if($result['detail'][0]['currencyreference'] == 2) echo "selected" ?> value=2>percentage(%) </option> -->
  <!-- 
                                        </select>
								  	   </div>  -->
								  	   <div class="col-sm-4" style="margin-left: 75px;margin-top: 50px;">
								  	   	<label><b>Valid To:</b></label>
										
								  	   	<input  class="form-control" type="datetime-local" id="valdt" value="<?php if(isset($result) && $result['res']==1 ){ echo str_replace(" ","T",$result['detail'][0]['ValidTo']); } ?>">
								  	   </div>
								  </div>
	                            </div>
	                            <div class="col-sm-12 text-center" >
								<hr/>
								  <button style="background-color:#942bad;" class="btn  btn-primary" id="Curref" type="button">submit</button>
								</div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>

			<footer class="footer">
				<div class="container-fluid">
					<p class="copyright pull-right">
						&copy; <script>document.write(new Date().getFullYear())</script> <a href="#">DESIGNED BY </a>Ubitech Solutions Pvt. Ltd.
					</p>
				</div>
			</footer>

		</div>
	</div>
</body>
<style>


</style>

<script type="text/javascript">


$('#Curref').click(function(){
		var Rf1  = $('#refamt').val();
		var Rf2  = $('#reffamt').val();
        var validfrom = $('#valdf').val();
        var validto = $('#valdt').val();
         /*var cref = $('#type1').val();
          var crefe = $('#type2').val();*/

         /* if(crefe==2)
          	if(Rf2 > '100'){

        	 	 doNotify('top','center',4,'some error occurs.');
        	 	 return false;

        	 	}
        	 
          

          
        if(cref==2)

        	 if(Rf1 > '100')
        	    {
        	 	 doNotify('top','center',4,'some error occurs.');
        	 	 return false;
        	 	}
            */

  

        $.ajax({url: "<?php echo URL;?>/ubitech/getReferenceAmount",
        data: {'referreramount':Rf1,'referrenceamount':Rf2,'validf':validfrom,'validt':validto},

        success: function(result){
			
	   if(result == 1){
			  doNotify('top','center',2,'Current ReferrenceAmount updated successfully.');
			   setTimeout(location.reload.bind(location), 2000);
		  }else{
			  doNotify('top','center',4,'some error occurs.');
			   setTimeout(location.reload.bind(location), 2000);
			  
		  }
	}	  
    });
   });     
   
</script>

	
</html>
