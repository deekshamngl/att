
<?php

 /* 
  $paypalUrl='https://www.sandbox.paypal.com/cgi-bin/webscr';// sandbox
  $paypalId='glbsng@gmail.com';		// sandbox
  */
 
  $paypalUrl='https://www.paypal.com/cgi-bin/webscr';// production
  $paypalId='namrata@ubitechsolutions.com'; 			// production
  
 //--------------------------------------------PAYUMONEY INTEGRATION CODE
 // Merchant key here as provided by Payu
   $MERCHANT_KEY = "dv1tL3LP";		//live key
   //$MERCHANT_KEY = "rjQUPktU";	//sandbox key

// Merchant Salt as provided by Payu
	$SALT = "AlGt0f59fS";			//live key
	//$SALT = "e5iIg1jwi8";			//sandbox key

	//$PAYU_BASE_URL = "https://test.payu.in"; // for sandbox
	$PAYU_BASE_URL = "https://secure.payu.in";// for LIVE mode

$action = '';
$posted = array();
if(!empty($_REQUEST)) {
  foreach($_REQUEST as $key => $value) {    
    $posted[$key] = $value; 
  }
   $posted['productinfo'] = json_encode(json_decode('[{
		"ind_name":"'.$posted['firstname'].'",
		"total":"'.base64_encode($posted['amount']).'",
		"discount":"'.base64_encode($posted['discount']).'",
		"duration":"'.base64_encode($posted['durarion']).'",
		"plan":"'.$posted['plan'].'",
		"email":"'.$posted['email'].'",
		"country":"'.base64_encode($posted['country']).'",
		"street":"'.base64_encode($posted['street']).'",
		"city":"'.base64_encode($posted['city']).'",
		"state":"'.$posted['state'].'",
		"zip":"'.$posted['zip'].'",
		"noofusers":"'.$posted['nofuser'].'",
		"contact":"'.$posted['phone'].'",
		"currency":"'.$posted['currency_code_pum'].'",
		"taxforinr":"'.base64_encode($posted['tax']).'",
		"action":"'.$posted['action'].'",
		"bulk_attpriceP":"'.$posted['bulk_attpriceP'].'",
		"location_tracepriceP":"'.$posted['location_tracepriceP'].'",
		"visit_punchpriceP":"'.$posted['visit_punchpriceP'].'",
		"geo_fencepriceP":"'.$posted['geo_fencepriceP'].'",
		"payroll_priceP":"'.$posted['payroll_priceP'].'",
		"timeoff_priceP":"'.$posted['timeoff_priceP'].'",
		"stsbulk_attendance":"'.$posted['stsbulk_attendance'].'",
		"stsgeo_fence":"'.$posted['stsgeo_fence'].'",
		"stsloc_trace":"'.$posted['stsloc_trace'].'",
		"stsvisit_punch":"'.$posted['stsvisit_punch'].'",
		"stspayroll":"'.$posted['stspayroll'].'",
		"ststimeoff":"'.$posted['ststimeoff'].'",
		"dueamount":"'.$posted['dueamount'].'",
		"gstin":"'.$posted['gstin'].'"
		}]'));
}

$formError = 0;

if(empty($posted['txnid'])) {
  // Generate random transaction id
  $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
  $txnid = $posted['txnid'];
}

$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
//echo 'CONDITION ONE ::-----------------------------------------'.empty($posted['hash']);
//echo '\nCONDITION ONE ::-----------------------------------------'.sizeof($posted);

if(empty($posted['hash']) && sizeof($posted) > 0) {
  if(
          empty($posted['key'])
          || empty($posted['txnid'])
          || empty($posted['amount'])
          || empty($posted['firstname'])
          || empty($posted['email'])
          || empty($posted['phone'])
          || empty($posted['productinfo'])
          || empty($posted['surl'])
          || empty($posted['furl'])
		  || empty($posted['service_provider'])
  ) {
     $formError = 1;
	
  } else {
	//  print_r($posted);
//	return false;
		$hashVarsSeq = explode('|', $hashSequence);
		$hash_string = '';	
		foreach($hashVarsSeq as $hash_var) {
		  $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
		  $hash_string .= '|';
    }
		$hash_string .= $SALT;
		 $hash = strtolower(hash('sha512', $hash_string));
		$action = $PAYU_BASE_URL . '/_payment';
	}
	}
  elseif(!empty($posted['hash'])) {
		  $hash = $posted['hash'];
		  $action = $PAYU_BASE_URL . '/_payment';
		//  echo '*******************************************************';
	}
	
 //--------------------------------------------PAYUMONEY INTEGRATION CODE/
  ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>My Plan</title>
	
	<script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {
		
      if(hash == '') {
        return;
      }
      var payuForm = document.forms.payuForm;
      payuForm.submit();
    }
  </script>
  
	<style>
	label{
		color:black!important;
	}
	.radio label{
		color:#8d8989!important;
	}
table {
    font-family: arial, sans-serif;
   // border-collapse: collapse;
    width: 100%;
}

td, th {
    padding: 18px;
	height: 30px;
}
 table.tab1 td {
    text-align: center;
}
/*
tr:nth-child(even) {
    background-color: #dddddd;
}
	#ordertable td 
{
    text-align: right; 
    vertical-align: middle;
}*/
      .hover{background-color: #cc0000}
      .authorBlock{border-top:1px solid #cc0000;}
      .accordion_container {
      width: 100%;
      padding: 1em;
      }
      .section_position{
	  	margin-left:15px;
	  }
      .accordion_head {
      background-color: #9c27b0;
      color: white;
      cursor: pointer;
      font-family: arial;
      font-size: 14px;
      margin: 10px 0 0px 0px;
      padding: 10px 11px;
      font-weight: bold;
      border: 1px solid #ddd;
      }
      .positned{
	  	position: absolute;
	  	right: 50px;
	  }
      .accordion_body {
      background: white;
      padding: 1em;
      }
      .accordion_body p {
      padding: 18px 5px;
      margin: 0px;
      }
      .check-mark, .question-mark {
      border-style: solid;
      border-width: 1px;
      border-radius: 50%;
      float: right;
      height: 28px;
      line-height: 16px;
      padding: 5px;
      position: relative;
      width: 28px;
      text-align: center;
      top: -4px;
      }
      .check-mark {
      border-color: #c4db30;
      color: #c4db30;
      }
      
      .question-mark {
      border-color: #086cff;
      color: #086cff;
      font-size: 1.3em;
      }
      .plusminus {
      float: left;
      margin-right: 10px;
      }
      .next-button {
      /* display: none; */
      }
      .ui-datepicker-calendar {
      display: none;
      }​
      .borderless td, .borderless tr {
      border: none!important;
      }
       .editbutton{
      color: #ffc107!important;
      background-color: transparent!important;
      background-image: none!important;
      border-color: #ffc107!important;padding:0px!important;margin:0px!important;
      float:right!important;
      }
      #mystyle input{width: 50%;
      }
      <!--------CSS loader-------->
      /* Absolute Center Spinner 
      .loading {
      position: fixed;
      z-index: 999;
      height: 2em;
      width: 2em;
      overflow: show;
      margin: auto;
      top: 0;
      left: 0;
      bottom: 0;
      right: 0;
      }
      /* Transparent Overlay 
      .loading:before {
      content: '';
      display: block;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.3);
      }
      /* :not(:required) hides these rules from IE9 and below 
      .loading:not(:required) {
      /* hide "loading..." text 
      font: 0/0 a;
      color: transparent;
      text-shadow: none;
      background-color: transparent;
      border: 0;
      }
      .loading:not(:required):after {
      content: '';
      display: block;
      font-size: 10px;
      width: 1em;
      height: 1em;
      margin-top: -0.5em;
      -webkit-animation: spinner 1500ms infinite linear;
      -moz-animation: spinner 1500ms infinite linear;
      -ms-animation: spinner 1500ms infinite linear;
      -o-animation: spinner 1500ms infinite linear;
      animation: spinner 1500ms infinite linear;
      border-radius: 0.5em;
      -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
      box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
      }
      /* Animation 
      @-webkit-keyframes spinner {
      0% {
      -webkit-transform: rotate(0deg);
      -moz-transform: rotate(0deg);
      -ms-transform: rotate(0deg);
      -o-transform: rotate(0deg);
      transform: rotate(0deg);
      }
      100% {
      -webkit-transform: rotate(360deg);
      -moz-transform: rotate(360deg);
      -ms-transform: rotate(360deg);
      -o-transform: rotate(360deg);
      transform: rotate(360deg);
      }
      }
      @-moz-keyframes spinner {
      0% {
      -webkit-transform: rotate(0deg);
      -moz-transform: rotate(0deg);
      -ms-transform: rotate(0deg);
      -o-transform: rotate(0deg);
      transform: rotate(0deg);
      }
      100% {
      -webkit-transform: rotate(360deg);
      -moz-transform: rotate(360deg);
      -ms-transform: rotate(360deg);
      -o-transform: rotate(360deg);
      transform: rotate(360deg);
      }
      }
      @-o-keyframes spinner {
      0% {
      -webkit-transform: rotate(0deg);
      -moz-transform: rotate(0deg);
      -ms-transform: rotate(0deg);
      -o-transform: rotate(0deg);
      transform: rotate(0deg);
      }
      100% {
      -webkit-transform: rotate(360deg);
      -moz-transform: rotate(360deg);
      -ms-transform: rotate(360deg);
      -o-transform: rotate(360deg);
      transform: rotate(360deg);
      }
      }
      @keyframes spinner {
      0% {
      -webkit-transform: rotate(0deg);
      -moz-transform: rotate(0deg);
      -ms-transform: rotate(0deg);
      -o-transform: rotate(0deg);
      transform: rotate(0deg);
      }
	  
      100% {
      -webkit-transform: rotate(360deg);
      -moz-transform: rotate(360deg);
      -ms-transform: rotate(360deg);
      -o-transform: rotate(360deg);
      transform: rotate(360deg);
      }	
      }*/
     
      
    /*  <!--------CSS loader-------->	*/
      
      .spinner-wrapper {
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color:#f3cd9e;
		z-index: 999999;
		}
		.spinner{
			position: absolute;
			top: 48%;
			left: 48%;
		}
		.spinner {
  		width: 40px;
  		height: 40px;
  		background-color: #e88d4a;

 /* margin: 100px auto;*/
  -webkit-animation: sk-rotateplane 1.2s infinite ease-in-out;
  animation: sk-rotateplane 1.2s infinite ease-in-out;
}

@-webkit-keyframes sk-rotateplane {
  0% { -webkit-transform: perspective(120px) }
  50% { -webkit-transform: perspective(120px) rotateY(180deg) }
  100% { -webkit-transform: perspective(120px) rotateY(180deg)  rotateX(180deg) }
}

@keyframes sk-rotateplane {
  0% { 
    transform: perspective(120px) rotateX(0deg) rotateY(0deg);
    -webkit-transform: perspective(120px) rotateX(0deg) rotateY(0deg) 
  } 50% { 
    transform: perspective(120px) rotateX(-180.1deg) rotateY(0deg);
    -webkit-transform: perspective(120px) rotateX(-180.1deg) rotateY(0deg) 
  } 100% { 
    transform: perspective(120px) rotateX(-180deg) rotateY(-179.9deg);
    -webkit-transform: perspective(120px) rotateX(-180deg) rotateY(-179.9deg);
  }
}
.act{
	background-color:#4caf50!important;color: white!important;
}
.dact{
	background-color:transparent!important;color: black!important;
}
    </style>

    <script>
      ///////--------------- var declarations
      var plan='YEARLY'; // default yearly , other = monthly
      var plan1 ='YEARLY'; // default yearly , other = monthly temporary
      var c_plan=plan; // copy of plan to keep the orignal selection of plan
      var users=0;
      var userrate=0;
      var currency='';
      var discount=0;
      var tax=0;
      var igst=0;   
	  var due_amount = "<?php  echo $myplan['due_amount'];  ?>";
	// alert(due_amount);
	   var action='UO'; // UPDATE- 'UO'/'DO'/'UD'- Users only/ Duration only/ time and duration both
    </script>
	
  </head>
  <body onload="submitPayuForm()">
    <div class="wrapper">
    <?php
      $data['pageid']=1234;
      $this->load->view('menubar/sidebar',$data);
      ?>
    <div class="main-panel">
      <?php
        $this->load->view('menubar/navbar',$data);
        ?>
      <div class="content">
        <div class="container-fluid center">
          <div class="row">
            <div class="col-lg-4 col-md-4">	
			<!---------payumoney-------->
			<?php if($formError) { ?>
			  <span style="color:red">Please fill all mandatory fields.</span>
			  <br/>
			  <br/>
			<?php } ?>
			<!---------payumoney-------->
            </div>
            <div class="col-md-12" >
              <div class="card valign">
                <div class="card-header" data-background-color="orange">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <h6 class="nav-tabs-title">Due Payment Notification<a onClick="location.reload();" style="margin:0px; padding: 5px 15px; background-color:#45a149;" class="pull-right btn">Reset</a></h6>
					  
					</div>
                  </div>
                </div>
                <div class="card-content table-responsive">
                  <div class="row">
                      <div class="accordion_container">
                        <div class="row">
                          <div class="col-xs-12 col-md-12 col-lg-12">
							<h4>Payable Dues:</h4>
							
					   <div class="form-group">
						<label for="inputsm"><b>Note: Failing to pay the dues incurred for additional users will end your subscription on.</b></label>
						<?php if(isset($myplan['end_date'])){ echo $myplan['end_date']; } ?>
					
                        </div> 
                    </div>
                    </div>
                    <!-- end .accordion_container -->
					
                 <!--   </form>-->
                    </div>								
                  </div>
                </div>   <!-----card-content table-responsive--------->
				
              </div>
            </div>
          </div>
        </div>
        	<div class="spinner-wrapper" id='loader' style='display:none' >
				<div class="spinner"></div>
			</div>
        <footer class="footer">
          <div class="container-fluid">
            <nav class="pull-left">
            </nav>
            <!--<p class="copyright pull-right">
              &copy; <script>document.write(new Date().getFullYear())</script> <a href="#">DESIGNED BY</a> ubitech solutions pvt. ltd.
            </p>-->
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
  </body>
  
 <script>
                              $(function(){
                              	$('.editbutton').hide();
                              	$("#edit1").click(function (){
									
                              		pid=$('#pid').val();			
                              		//$(".accordion_body1").slideDown(300);
                              		$(".accordion_body2").slideUp(300);
                              		$(".accordion_body3").slideUp(300);
                              		$(".accordion_body4").slideUp(300);
                              		$(".accordion_body5").slideUp(300);
                              		$("#edit2").hide();
                              		$("#edit3").hide();
                              		$("#edit4").hide();
                              		}); 
                              		
                              	$("#edit2").click(function () {
									
                              		pid=$('#pid').val();			
                              	//	$(".accordion_body1").slideUp(300);
                              		$(".accordion_body2").slideDown(300);
                              		$(".accordion_body3").slideUp(300);
                              		$(".accordion_body4").slideUp(300);
                              		$(".accordion_body5").slideUp(300);
                              		$("#edit3").hide();
                              		$("#edit4").hide();
                              		}); 
									
                              	$("#edit3").click(function () {
									location.reload();
									/*$('#operation').show();
							    	$('#iwant').hide();
                              		pid=$('#pid').val();			
                              		//$(".accordion_body1").slideUp(300);
									
									$('#yearly').click();
									$('#noOfUser').val(0);
									$('#duration').val(0);
                              		$(".accordion_body2").slideUp(300);
                              		$(".accordion_body6").slideUp(300);
                              		$(".accordion_body3").slideDown(300);
                              		$(".accordion_body4").slideUp(300);
                              		$(".accordion_body5").slideUp(300);
                              		$("#edit6").hide();
                              		$("#edit4").hide();*/
                              		}); 
									
								$("#edit6").click(function(){
									
									pid=$('#pid').val();			
                              		$(".accordion_body2").slideUp(300);
                              		$(".accordion_body6").slideDown(300);
                              		$(".accordion_body4").slideUp(300);
                              		$(".accordion_body5").slideUp(300);
                              		$("#edit4").hide();
                              		}); 
									
							
								
                              	$("#edit4").click(function () {
                              		pid=$('#pid').val();			
                              //		$(".accordion_body1").slideUp(300);
                              		$(".accordion_body2").slideUp(300);
                              		$(".accordion_body3").slideUp(300);
                              		$(".accordion_body4").slideDown(300);
                              		$(".accordion_body5").slideUp(300);
                              		}); 
                              	
                              		
                              });
                              
							$(function(){
								/* $('#currency').change(function(){ */
									if($('#currency').val()=='USD')
									{
										currency='USD';
										$('#currency_code').val('USD');
										$('#usdList').show();
										$('#inrList').hide();
										$('#in_cur').text(' (USD) ');
										tax=0;
									}else{
										currency='INR';
										$('#currency_code').val('INR');
										$('#usdList').hide();
										$('#inrList').show();
										$('#in_cur').text(' (INR) ');
									}
									
/* 								}); */
							});
						  </script> 
						  
             <script>
						$(function(){
							
							$("#showcurr").text(currency);
							$("#yearly").click(function(){
								$("#yearly").removeClass('dact');
								$("#yearly").addClass('act');
								$("#monthly").removeClass('act');
								$("#monthly").addClass('dact');
								$("#planFor").text('YEARLY');
								$("#pln").text('year');
								plan1 = 'YEARLY';
								plan='YEARLY';
								c_plan=plan;
								$("#dis").text('');
								//alert(currency+" "+$('#dis_usd_month').val());
								if(currency=='USD' && $('#dis_usd_year').val()!=0){
									$("#dis").text('Buy yearly ubiAttendance plan and  get '+$('#dis_usd_year').val()+'% Instant discount on billing amount.');
									
								}
								else if(currency=='INR' && $('#dis_inr_year').val()!=0){
									
									$("#dis").text('Buy yearly ubiAttendance plan and  get '+$('#dis_inr_year').val()+'% Instant discount on billing amount.');
								}
							});
							
							$("#monthly").click(function(){
								
								$("#yearly").removeClass('act');
								$("#yearly").addClass('dact');
								$("#monthly").removeClass('dact');
								$("#monthly").addClass('act');
								$("#planFor").text('MONTHLY');
								$("#pln").text('month');
								plan1 = 'MONTHLY';
								plan='MONTHLY';
								c_plan=plan;
								$("#dis").text('');
								//alert(currency+" "+$('#dis_inr_month').val());
								if(currency=='INR' && $('#dis_inr_month').val()!=0){
									$("#dis").text('Buy monthly ubiAttendance plan and  get '+$('#dis_inr_month').val()+'% Instant discount on billing amount.');
								}
								else if(currency=='USD' && $('#dis_usd_month').val()!=0){
									$("#dis").text('Buy monthly ubiAttendance plan and  get '+ $('#dis_usd_month').val() +'% Instant discount on billing amount.');
									
								}
							});
							
							 
							$("#go").click(function(){
								$('#operation').hide();
								$('#iwant').show();
								var opr=$('input[name=get_opr]:checked').val();
								if(opr=='user_only'){
									action="UO";
									$('#noy').hide();
									$('#nou').show();
								}else if(opr=='duration_only'){
									action="DO";
									$('#nou').hide();
									$('#noy').show();
								}else if(opr=='duration_user'){
									action="UD";
									$('#nou').show();
									$('#noy').show();
								}
							});
						});
                   </script>
  
  
  <script>
  function checkBillingForm(){
				if($("#ind_name").val()=='')
				{
					$("#ind_name").focus();
					alert('Please fill individual/Company Name ');
					return false;
				}
				if($("#contact").val()=='')
				{
					$("#contact").focus();
					alert('Please fill contact');
					return false;
				}
				if($("#country").val()=='')
				{
					$("#country").focus();
					alert('Please fill country ');
					return false;
				}
				
				if($("#city").val()=='')
				{
					$("#city").focus();
					alert('Please fill city ');
					return false;
				}
				if($("#street").val()=='')
				{
					$("#street").focus();
					alert('Please fill street address ');
					return false;
				}
				if($("#zip").val()=='')
				{
					$("#zip").focus();
					alert('Please fill zip ');
					return false;
				}
				if($("#country").val()=='India' && $("#state").val()=='')
				{
					$("#state").focus();
					alert('Please select state ');
					return false;
				}
				var gst_stts=$("input[name='gstno']:checked").val();
				
				if($("#country").val()=='India' && gst_stts=='on' && $('#gstin').val()=='' )
				{
					$("#gstin").focus();
					alert('Please Enter GST No. ');
					return false;
				}
				savetemppay();
				/////////////if data are valid
				$('#amount_pum').val(parseInt($('#total').text()));
				$('#nofuser_pum').val(parseInt($('#noOfUser_1').text()));
				$('#action_pum').val(action);
				$('#discount_pum').val(parseInt($('#discount_amt').text()));
				$('#tax_pum').val(parseInt($('#tax').text()));
				$('#durarion_pum').val(parseInt($('#duration_1').text()));
				$("#phone_pum").val($("#contact").val());
				$('#plan_pum').val(c_plan);
	

	
	if($('#bulk_attcheck'). prop("checked") == true){
             $("#bulk_attprice_pum").val($('#bulk_attprice1').val());
             $("#stsbulk_attendance").val(1);
         }
		 else
		 {
			  $("#bulk_attprice_pum").val('0');
			  $("#stsbulk_attendance").val(0);
		 }
		 
	    if($('#location_tracecheck'). prop("checked") == true){
             $("#location_traceprice_pum").val($('#location_traceprice1').val());
			  $("#stsloc_trace").val(1);
         }
		 else
		 {
			  $("#location_traceprice_pum").val('0');
			  $("#stsloc_trace").val(0);
		 }
		 
		 if($('#visit_punchcheck'). prop("checked") == true){
             $("#visit_punchprice_pum").val($('#visit_punchprice1').val());
			  $("#stsvisit_punch").val(1);
			 
          }
		  else
		 {
			  $("#visit_punchprice_pum").val('0');
			  $("#stsvisit_punch").val(0);
		 }
		
		 if($('#geo_fencecheck'). prop("checked") == true)
		 {
             $("#geo_fenceprice_pum").val($('#geo_fenceprice1').val());
			  $("#stsgeo_fence").val(1);
         }
		 else
		 {
			  $("#geo_fenceprice_pum").val('0');
			  $("#stsgeo_fence").val(0);
		 }
		  if($('#payroll_check'). prop("checked") == true)
		 {
            $("#payroll_price_pum").val($('#payroll_price1').val());
			 $("#stspayroll").val(1);
         }
		 else
		 {
			  $("#payroll_price_pum").val('0');
			   $("#stspayroll").val(0);
		 }
		  if($('#timeoff_check'). prop("checked") == true)
		 {
            $("#timeoff_price_pum").val($('#timeoff_price1').val());
			 $("#ststimeoff").val(1);
		 }
		 else
		 {
			 $("#timeoff_price_pum").val('0');
			 $("#ststimeoff").val(1);
		 }
				
				return true;
	}
	
	function savetemppay(){
			var street = $("#street").val();
			var city = $("#city").val();
			var zip = $("#zip").val();
			var ind_name = $("#ind_name").val();
			var state = $("#state").val();
			var country = $("#country").val();
			var contact = $("#contact").val();
			var duration = $("#duration").val(); 
			var gstin = $("#gstin").val();
			var plan = c_plan;
			var noofusers=$("#noOfUser").val();
			var currency =$('#currency').val();
			var taxforinr =$('#tax').text();
			var total = $('#total').text();
			var discount= $('#discount_amt').text();
			
		//var xsrf = $.param({sts:2});
		$.ajax({
		url: "<?php echo URL;?>Myplan/saveTempPay",
		data: {"street":street,"city":city,"zip":zip,"ind_name":ind_name,"state":state,"country":country,"contact":contact,"duration":duration,"gstin":gstin,"plan":plan,"noofusers":noofusers,"currency":currency,"taxforinr":taxforinr,"total":total,"discount":discount,"action":'UPGRADE'},
				success: function(result){
				 },
				error: function(result){
					//alert('error');
				 }
		   });
	}
  </script>
  
  

</html>