
<?php

  $paypalUrl='https://www.sandbox.paypal.com/cgi-bin/webscr'; // sandbox
  $paypalId='namrata@ubitechsolutions.com';		// sandbox
  
  
  // $paypalUrl='https://www.paypal.com/cgi-bin/webscr';// production
  // $paypalId='namrata@ubitechsolutions.com'; 			// production
  //--------------------------------------------PAYUMONEY INTEGRATION CODE
 // Merchant key here as provided by Payu
  // $MERCHANT_KEY = "dv1tL3LP";		//live key
 $MERCHANT_KEY = "rjQUPktU";	//sandbox key

// Merchant Salt as provided by Payu
  // $SALT = "AlGt0f59fS";			//live key
 $SALT = "e5iIg1jwi8";			//sandbox key

	$PAYU_BASE_URL = "https://test.payu.in"; // for sandbox
	// $PAYU_BASE_URL = "https://secure.payu.in";// for LIVE mode

$action = '';

$posted = array();
if(!empty($_REQUEST)){
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
		"gstin":"'.$posted['gstin'].'",
		"bulk_attendance":"'.$posted['postbulk_attendance'].'",
		"visit_punch":"'.$posted['postvisit_punch'].'",
		"loc_sharing":"'.$posted['postloc_trace'].'",
		"geo_fence":"'.$posted['postgeo_fence'].'",
		"payroll":"'.$posted['postpayroll'].'",
		"timeoff":"'.$posted['posttimeoff'].'",
		"stsbulk_attendance":"'.$posted['stsbulk_attendance'].'",
		"stsgeo_fence":"'.$posted['stsgeo_fence'].'",
		"stsloc_trace":"'.$posted['stsloc_trace'].'",
		"stsvisit_punch":"'.$posted['stsvisit_punch'].'",
		"stspayroll":"'.$posted['stspayroll'].'",
		"ststimeoff":"'.$posted['ststimeoff'].'"
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
//	 print_r($posted);
	 return false;
	
  } else {
	//  print_r($posted);
   //	return false;
		$hashVarsSeq = explode('|', $hashSequence);
		$hash_string = '';	
		foreach($hashVarsSeq as $hash_var) 
		{
		  $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
		  $hash_string .= '|';
        }
		$hash_string .= $SALT;
		 $hash = strtolower(hash('sha512', $hash_string));
		$action = $PAYU_BASE_URL . '/_payment';
	      }
	} elseif(!empty($posted['hash'])) {
		  $hash = $posted['hash'];
		  $action = $PAYU_BASE_URL . '/_payment';
		 // echo '*******************************************************';
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
//	alert(hash);
    function submitPayuForm() {
      if(hash == '') {
        return;
      }
      var payuForm =document.forms.payuForm;
      payuForm.submit();
    }
  </script>
	<style>
	
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
      100%{
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
	   var c_plan=plan; // copy of plan to keep the orignal selection of plan
      var users=0;
      var userrate=0;
      var currency='';
      var discount=0;
      var tax=0;
      var igst=0;        
    </script>
  </head>
  <body onload="submitPayuForm()">
    <div class="wrapper">
    <?php
      $data['pageid']=11.1;
      $this->load->view('menubar/sidebar',$data);
      ?>
    <div class="main-panel">
      <?php
        $this->load->view('menubar/navbar',$data);
        ?>
      <div class="content">
        <div class="container-fluid center">
          <div class="row">
            <div class="col-lg-1 col-md-1">	
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
                      <h6 class="nav-tabs-title">My Plan</h6>
                    </div>
                  </div>
                </div>
                <div class="card-content table-responsive">
                <div class="card-content table-responsive">
                  <div class="row">
                      <div class="accordion_container">
                        <div class="row">
                          <div class="col-xs-12 col-md-12 col-lg-12">
                            <div class="accordion_main">
                              <div class="accordion_head">Existing Plan<button id="edit1" type="button" class="btn editbutton"><i  class="fa fa-pencil " style="font-size:12px;margin-top:0px;top:0px;"></i> Edit</button></div>
                              <div class="accordion_body1 section_position" >
                                <div class="row">
                                  <div class="col-xs-6">
                                    <div class="form-group">
                                      <label for="inputsm"> Start Date</label>
                                      <span class="form-control input-sm " id="startdate"  type="text" value="" disabled ><?php if(isset($myplan['start_date'])){ echo $myplan['start_date']; } ?></span>
                                    </div>
                                  </div>
                                  <div class="col-xs-6">
                                    <div class="form-group">
                                      <label for="inputsm"> End Date</label>
                                      <span class="form-control input-sm" id="enddate"  type="text" value="" disabled ><?php if(isset($myplan['end_date'])){ echo $myplan['end_date']; } ?></span>
                                    </div>
                                  </div>
                                </div>
                                <div class="row" >
                                  <div class="col-xs-6">
                                    <div class="form-group">
                                      <label for="inputsm">Registered Users </label>
                                      <span class="form-control input-sm" id="totalusers"  type="text" value="" disabled ><?php if(isset($myplan['totalUser'])){ echo $myplan['totalUser']; } ?></span>
                                    </div>
                                  </div>
                                </div>
                               
                                <button type="button" class="btn btn-success next-button1" data-toggle="dropdown" aria-expanded="false">CONTINUE</button>
                              </div>
                            </div>
							
                            <script>
                              $(function(){
                              	$('.editbutton').hide();
                              	$("#edit1").click(function () {
                              		pid=$('#pid').val();			
                              		$(".accordion_body1").slideDown(300);
                              		$(".accordion_body2").slideUp(300);
                              		$(".accordion_body3").slideUp(300);
                              		$(".accordion_body4").slideUp(300);
                              		$(".accordion_body5").slideUp(300);
                              		$(".accordion_body6").slideUp(300);
                              		$("#edit2").hide();
                              		$("#edit3").hide();
                              		$("#edit4").hide();
                              		$("#edit6").hide();
														}); 
                              		
                              	$("#edit2").click(function () {
                              		pid=$('#pid').val();			
                              		$(".accordion_body1").slideUp(300);
                              		$(".accordion_body2").slideDown(300);
                              		$(".accordion_body3").slideUp(300);
                              		$(".accordion_body4").slideUp(300);
                              		$(".accordion_body5").slideUp(300);
                              		$(".accordion_body6").slideUp(300);
                              		$("#edit3").hide();
                              		$("#edit4").hide();
                              		$("#edit6").hide();
                              	}); 
                              	$("#edit3").click(function () {
                              		pid=$('#pid').val();			
                              		$(".accordion_body1").slideUp(300);
                              		$(".accordion_body2").slideUp(300);
                              		$(".accordion_body3").slideDown(300);
                              		$(".accordion_body4").slideUp(300);
                              		$(".accordion_body5").slideUp(300);
                              		$(".accordion_body6").slideUp(300);
                              		$("#edit4").hide();
                              		$("#edit6").hide();
                              	}); 
                              	$("#edit4").click(function (){
                              		pid=$('#pid').val();			
                              		$(".accordion_body1").slideUp(300);
                              		$(".accordion_body2").slideUp(300);
                              		$(".accordion_body3").slideUp(300);
                              		$(".accordion_body4").slideDown(300);
                              		$(".accordion_body5").slideUp(300);
                              		$(".accordion_body6").slideUp(300);
								
                              	}); 
								$("#edit6").click(function () {
                              		pid=$('#pid').val();			
                              		$(".accordion_body1").slideUp(300);
                              		$(".accordion_body2").slideUp(300);
                              		$(".accordion_body3").slideUp(300);
                              		$(".accordion_body4").slideUp(300);
                              		$(".accordion_body5").slideUp(300);
                              		$(".accordion_body6").slideDown(300);
									$("#edit4").hide();
                              	}); 
								})
                              
                            </script>
                           
						   <div class="accordion_main"  style="display:none">
                              <div class="accordion_head">Select Currency <button id="edit2" data-toggle="dropdown" aria-expanded="false" type="button" class="btn editbutton"><i  class="fa fa-pencil " style="font-size:12px;margin-top:0px;top:0px;"></i> Edit</button></div>
                              <div class="accordion_body2 " style="display: none;">
                                <div class="row" >
                                  <div class="col-md-4" ></div>
                                  <div class="col-md-2">
                                    <div class="form-group">
                                      <div class="form-group">
                                        <select class="form-control" id="currency" >
                                       <!--   <option value="">- Select Currency -</option>-->
                                          <?php	
											if($myplan['my_country']!=93)
												echo '<option selected value="USD">USD</option>';
											else
												echo '<option selected value="INR">INR</option>';
											?>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
								  <div class="col-md-6" ></div>
								  <script>
									$(function(){
										$('#currency').change(function(){
											if($('#currency').val()=='USD')
											{
												currency='USD';
												$('#currency_code').val('USD');
												$('#usdList').show();
												$('#inrList').hide();
												$('#in_cur').text(' (in USD) ');
												tax=0;
											}else{
												currency='INR';
												$('#currency_code').val('INR');
												$('#usdList').hide();
												$('#inrList').show();
												$('#in_cur').text(' (in INR) ');
											}
											
										});
									});
								  </script>
                                  <div class="col-md-3" ></div>
                                </div>
                                <button type="button" class="btn btn-success" id="continue"  data-toggle="dropdown" aria-expanded="false">Continue</button>
                              </div>
                            </div>




                            <div class="accordion_main">
                              <div class="accordion_head">Select Plan <button id="edit3" type="button" class="btn editbutton"><i class="fa fa-pencil " style="font-size:12px;margin-top:0px;top:0px;"></i> Edit</button></div>
                              <div class="accordion_body3" style="display: none;">
                                <!------start btn------>
                                
                                <!------ end btn------>	
                         
                    <!------start btn------>
                    <div id="forUsdBtns">
						<div class="btn-group" style="border: 2px solid #c9c9cc;padding:1px;">
							<button id="yearly" type="button" class="btn act">Yearly</button>
							<button id="monthly" type="button" class="btn dact">Monthly</button>
						</div> 
                    </div>
                   <script>
						$(function(){
							$("#yearly").click(function(){
								$("#yearly").removeClass('dact');
								$("#yearly").addClass('act');
								$("#monthly").removeClass('act');
								$("#monthly").addClass('dact');
								$("#planFor").text('YEARLY');
								$("#pln").text('year');
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
						});
                   </script>
                    <!------ end btn------>	
                    <div class="row" >
            
                    <div class="col-md-4 col-lg-4 col-xl-4 col-sm-12 col-xs-12">
					 
					<div class="row">
                           <div class="col-xs-6">
                              <div class="form-group">
								<label for="inputsm">  No. of Users*</label>
                                 <input type="number" min="1" class="form-control" id="noOfUser" name="noOfUser" placeholder="" required >
                                    </div>
                                  </div>
								    <div class="col-xs-6">
                                    <div class="form-group">
                                    <label for="inputsm">  No. of <span id="pln">years</span>s*</label>
                                     <input type="number" min="1" class="form-control" id="duration" maxlength="250" name="duration" placeholder="" required>
                                    </div>
                                  </div>
                                 </div>
                    </div>
					<div class="col-md-1 col-lg-1 col-xl-1 col-sm-12 col-xs-12" ></div>
					<div class="col-md-4 col-lg-4 col-xl-4 col-sm-12 col-xs-12" style="display:none">
						<div  style="padding-left:0px;padding-right:0px;">
							<div class="panel panel-default">
								<div class="panel-heading" align="center">
									<h4 align="center">Price List</h4>
								</div>
								<div id="inrList">
									<table class="tab1">
									  <tr>
										<th><center>No. of Employees</center></th>
										<th><center>Price/Employee per month(in INR)</center></th>
										<th><center>Price/Employee per year(in INR)</center></th>
									  </tr>
									  <?php 
									  $i=0;
										foreach($myplan['planinfo']['inr'] as $row){
											echo "<tr>
													<td><span>".$row['range']."</span></td>
													<td><span id='inrMonthly".$i."'>".$row['monthly']."</span></td>
													<td><span id='inrYearly".$i."'>".$row['yearly']."</span></td>
													<td><span id='bulk_attendanceINR".$i."'>".$row['bulk_attendance']."</span></td>
													<td><span id='location_tracingINR".$i."'>".$row['location_tracing']."</span></td>
													<td><span id='visit_punchINR".$i."'>".$row['visit_punch']."</span></td>
													<td><span id='geo_fenceINR".$i."'>".$row['geo_fence']."</span></td>
													<td><span id='payrollINR".$i."'>".$row['payroll']."</span></td>
													<td><span id='time_offINR".$i."'>".$row['time_off']."</span></td>
												  </tr>";
												  $i++;
										}
									  ?>
									</table>
								</div>
								<div id="usdList" style="display:none">
									<table class="tab1">
									  <tr>
										<th><center>No. of Employees</center></th>
										<th><center>Price/Employee per month(in USD)</center></th>
										<th><center>Price/Employee per year(in USD)</center></th>
									  </tr>
									   <?php 
									   $i=0;
										foreach($myplan['planinfo']['usd'] as $row){
											echo "<tr>
													<td><span>".$row['range']."</span></td>
													<td><span id='usdMonthly".$i."'>".$row['monthly']."</span></td>
													<td><span id='usdYearly".$i."'>".$row['yearly']."</span></td>
													<td><span id='bulk_attendanceUSD".$i."'>".$row['bulk_attendance']."</span></td>
													<td><span id='location_tracingUSD".$i."'>".$row['location_tracing']."</span></td>
													<td><span id='visit_punchUSD".$i."'>".$row['visit_punch']."</span></td>
													<td><span id='geo_fenceUSD".$i."'>".$row['geo_fence']."</span></td>
													<td><span id='payrollUSD".$i."'>".$row['payroll']."</span></td>
													<td><span id='time_offUSD".$i."'>".$row['time_off']."</span></td>
												  </tr>";
												  $i++;
										}
									  ?>
									</table>
								</div>
							</div>
						</div>
                    </div>
					<div class="col-md-1 col-lg-1 col-xl-1 col-sm-12 col-xs-12" ></div>
					</div>
				
					<input type='hidden' id="dis_usd_month" type="text" value="<?php
					if(isset($myplan['discount']['usd'][0]['dis']))
						echo $myplan['discount']['usd'][0]['dis']; // usd monthly dis 
					else echo 0;
					?>" />
				
					<input type='hidden'  id="dis_usd_year" type="text" value="<?php
					if(isset($myplan['discount']['usd'][1]['dis']))
						echo $myplan['discount']['usd'][1]['dis']; // usd monthly dis
					?>" />
					
					<input type='hidden'  id="dis_inr_month" type="text" value="<?php
					if(isset($myplan['discount']['inr'][0]['dis']))
						echo $myplan['discount']['inr'][0]['dis']; // usd monthly dis
					else echo 0;
					?>" />
					<input type='hidden'  id="dis_inr_year" type="text" value="<?php 
					if(isset($myplan['discount']['inr'][1]['dis']))
						echo $myplan['discount']['inr'][1]['dis'];
					else echo 0;									// usd monthly dis 
					?>"
					/>
				
						<strong>
							<span style="color:green;" id='dis'></span>
						</strong>
					<br/>
                    <button type="button" class="btn btn-success" id="continue2"  data-toggle="dropdown" aria-expanded="false">Continue</button>
                  
				</div>  
				
				<!----Start Tab for Addons---->
                    <div class="accordion_main">
                    <div class="accordion_head">Select Add-ons <button id="edit6" type="button" class="btn editbutton"><i  class="fa fa-pencil " style="font-size:12px;margin-top:0px;top:0px;"></i> Edit</button></div>
                    <div class="accordion_body6 " style="display: none;">
                    <div class="row"  ><!--id="TotalUsd"-->
                    <!--- <div class="col-md-1" ></div> --->
                    <div class="col-md-8" >
                    <!---<hr/> -->
					<center>
					
                    <table class="table table-responsive" style="width:80%" id="ordertable">
					<!---<h5 align="center"><strong>Addons</strong></h5>--->
					
					<tr>
                    <th width="50%" align="left">Add-ons </th>
                    <th width="25%" style="text-align: right;">Amount</th>
                    <th width="20%" style="text-align: right;">Select</th>
                    </tr>
				  
					
					<tr>
                    <td width="50%" align="left" id="bulkatt_perprice">Bulk Attendance @Rs. 2.00/month</td>
                    <td width="25%" align="right"><span id="bulk_attprice"></span></td>
                    <td width="20%" align="right"><input type='checkbox' name="bulk_attcheck" id="bulk_attcheck" /></td>
                    </tr>
					
					<tr style="display:none">
                    <td width="50%" align="left" id="loctrace_perprice">Location Tracing</td>
                    <td width="25%" align="right"><span id="location_traceprice"></span></td>
                    <td width="20%" align="right"><input type='checkbox'  name="location_tracecheck" id="location_tracecheck" checked /></td>
                    </tr>
					
					<tr>
                    <td width="50%" align="left" id="visit_perprice">Visit Punch</td>
                    <td width="25%" align="right"><span id="visit_punchprice"></span></td>
                    <td width="20%" align="right"><input type='checkbox' name="visit_punchcheck" id="visit_punchcheck" /></td>
                    </tr>
                   
				    <tr>
                    <td width="50%" align="left" id="gfence_perprice">Geo Fence</td>
                    <td width="25%" align="right"><span id="geo_fenceprice"></span></td>
                    <td width="20%" align="right"><input type='checkbox' name="geo_fencecheck" id="geo_fencecheck" /></td>
                    </tr>
					
				    <tr>
                    <td width="50%" align="left" id="payroll_perprice">Payroll</td>
                    <td width="25%" align="right"><span id="payroll_price"></span></td>
                    <td width="20%" align="right"><input type='checkbox' name="payroll_check" id="payroll_check" /></td>
                    </tr>
                    <tr>
                    <td width="50%" align="left" id="timeoff_perprice">Time Off</td>
                    <td width="25%" align="right"><span id="timeoff_price"></span></td>
                    <td width="20%" align="right"><input type='checkbox' name="timeoff_check" id="timeoff_check"  /></td>
                    </tr>
                    </tbody>
                    </table>
					
					</center>
                    </div>
                    <div class="col-md-4" >
						<div class="card-header" style="margin-top:20px;background-color: #45a149;color:white;">
							<span>Plan Duration: <span id="oplandur"></span></span><br/>
							<span>No. of Users: <span id="onousers"></span></span><br/>
							<span>Order Value: <span id="ocurr"></span><span id="cartval"></span></span>
						</div>
					</div>
                    </div>
					
                    <button type="button" class="btn btn-success" id="continue6"  data-toggle="dropdown" aria-expanded="false">Continue</button>
					
                    </div>
                    </div> 
					<!----End Tab for Addons---->
					
					
					
					<!----Start Tab for Plan Details---->
					<?php 
                        /*     $ragisteruser = countRegisteredEmployee($_SESSION['orgid']);
						     $due_amount_temp = 0;
							
					 	if($ragisteruser > $nofuser)
						{
						   $due_amount_temp =  ((int)$amount/(int)$nofuser)*($ragisteruser - $nofuser);
						}
							*/
					?>
                    <div class="accordion_main">
                    <div class="accordion_head">Plan Details <button id="edit4" type="button" class="btn editbutton"><i  class="fa fa-pencil " style="font-size:12px;margin-top:0px;top:0px;"></i> Edit</button></div>
                    <div class="accordion_body4 " style="display: none;">
                    <div class="row"  ><!--id="TotalUsd"-->
                    <div class="col-md-2" ></div>
                    <div class="col-md-8" >
                    <hr/> 
					<center>
                    <table class="table table-responsive" style="width:60%" id="ordertable">
					<h5 align="center"><strong>Order Summary</strong></h5>
					
					
					<tr>
                    <td width="24%" align="left">Plan Amount /User<span id="_per"></span>(Core -Attendance)</td>
                    <td width="1%"></td>
                    <td width="20%" align="right"><span class=""></span><span id="rate">0</span></td>
                    </tr>
					
					<tr>
                    <td width="24%" align="left">Plan Duration </td>
                    <td width="1%"></td>
                    <td width="20%" align="right"><span class="" id="duration_1"  type="text" value="duration_1" name="duration_1" disabled ></span></td>
                    </tr>
				  
					<tr>
                    <td width="24%" align="left">Ragister Users </td>
                    <td width="1%"></td>
                    <td width="20%" align="right"><span class=""></span><span id="ragisteruser"  ><?php echo countRegisteredEmployee($_SESSION['orgid']); ?></span></td>
                    </tr>
					
					<tr>
                    <td width="24%" align="left">User Limit </td>
                    <td width="1%"></td>
                    <td width="20%" align="right"><span class=""></span><span id="noOfUser_1"></span></td>
                    </tr>
					
					
					
					<tr>
                    <td width="24%" align="left">Plan Amount (Core -Attendance)</td>
                    <td width="1%"></td>
                    <td width="20%" align="right"><span class=""></span><span id="amount1">0</span></td>
                    </tr>
					<tr class="bulk">
                    <td width="24%" align="left">Bulk Attendance</td>
                    <td width="1%"></td>
                    <td width="20%" align="right"><span class=""></span><span id="bulkatt_tot">0</span></td>
                    </tr>
					<tr class="loc">
                    <td width="24%" align="left">Location Tracing</td>
                    <td width="1%"></td>
                    <td width="20%" align="right"><span class=""></span><span id="loctrace_tot">0</span></td>
                    </tr>
					<tr class="visit">
                    <td width="24%" align="left">Visit Punch</td>
                    <td width="1%"></td>
                    <td width="20%" align="right"><span class=""></span><span id="visitpunch_tot">0</span></td>
                    </tr>
					<tr class="geo">
                    <td width="24%" align="left">Geo Fence</td>
                    <td width="1%"></td>
                    <td width="20%" align="right"><span class=""></span><span id="geofence_tot">0</span></td>
                    </tr>
					<tr class="payroll">
                    <td width="24%" align="left">Basic Payroll</td>
                    <td width="1%"></td>
                    <td width="20%" align="right"><span class=""></span><span id="payroll_tot">0</span></td>
                    </tr>
					<tr class="timeoff">
                    <td width="24%" align="left">Time Off</td>
                    <td width="1%"></td>
                    <td width="20%" align="right"><span class=""></span><span id="timeoff_tot">0</span></td>
                    </tr>
					<tr>
                    <td width="24%" align="left">SubTotal</td>
                    <td width="1%"></td>
                    <td width="20%" align="right"><span class=""></span><span id="amount_tot">0</span></td>
                    </tr>
                   
				    <tr>
                    <td width="24%" align="left">Discount<span id="discount" style="display:none"></span></td>
                    <td width="1%"></td>
                    <td width="20%" align="right"><span class=""></span><span id="discount_amt">0</span></td>
                    </tr>
					
				    <tr>
                    <td width="24%" align="left">Tax(GST)<span id='tax_1' style="display:none"></span></td>
                    <td width="1%"></td>
                    <td width="20%" align="right"><span class=""></span><span id="tax">0</span></td>
                    </tr>
                   
				    
                    
				   <tr>
                   <td width="24%"><b>Total payable Amount</b> <span id='in_cur'></span> </td>
                    <td width="1%"></td>
                    <td width="20%" align="right"><span class=""><b></span><span id="total">0</span></b></td>
                    </tr>
					
					<tr id="tradditionaluse" hidden >
                     <td width="24%"  >Additional User</td>
                      <td width="1%"></td>
                       <td width="20%" align="right"><span class=""></span><span id="additionaluse">0</span></td>
                    </tr>
					
					<tr id="trdueamount" hidden >
                     <td width="24%">Due Amount</td>
                      <td width="1%"></td>
                       <td width="20%" align="right"><span class=""></span><span id="dueamount">0</span></td>
                    </tr>
					
                    </tbody>
                    </table>
					</center>
                    </div>
                    <div class="col-md-1" ></div>
                    </div>
                    <button type="button" class="btn btn-success" id="continue3"  data-toggle="dropdown" aria-expanded="false">Continue</button>
                    </div>
                    </div>
					<!----End Tab for Plan Details---->
					
					
					
					
					<!----Start Tab for Billing Details---->
                    <div class="accordion_main">
                    <div class="accordion_head">Billing Details</div>
                    <div class="accordion_body5 section_position" style="display:none;" >
                    
                   
                    <?php if($myplan['my_country']==93){?>
					<!------------PayUMoney for start------------>
					<div id="forPayUMoney">
                    <div class="row" id="payumoney" align="center">
              
					<form action="<?php echo $action; ?>" id="payuForm" method="post" name="payuForm">
					<h4><strong>Billing Details</strong></h4>
                   
                    <div class="row">
                    <div class="col-lg-6 col-sm-12 col-md-6 col-xs-12">
                    <input type="text" id="ind_name" class="form-control" name="Company" placeholder="Company Name" value="<?php //echo $individual; ?>"/>
                    <!--	<input type="text" class="form-control" id="country" name="country" value="india" readonly="true"  style="margin-bottom: 12px!important;"/> -->
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 col-xs-12">
                    <input type="number" id="contact" min="100000" max='999999999999999' class="form-control" name="contact" placeholder="Phone No." value=""/>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                    <textarea style="display:none" id="street" placeholder="Street Address" class="form-control" rows="2" name="street">no street</textarea>
                    </div>
                    </div>
                 <div class="row">
					 <div class="col-lg-4 col-sm-12 col-md-6 col-xs-12">
                    <select id="country" class="form-control" name="country">
                    <option value=''>Country </option>
                    <?php for($i =0; $i<count($myplan['country']['Name']); $i++){	
						?>
                    <option value="<?php echo $myplan['country']['Name'][$i];?>"><?php echo $myplan['country']['Name'][$i];?></option>	
                <?php 
                    }   
                    ?>
                    <option value='other'> others </option>
                    </select>
                    </div>
                    <div class="col-lg-4 col-sm-12 col-md-6 col-xs-12">
                    <input type="text" id="city" class="form-control" name="city" placeholder="City"/>
                    </div>
                    <div id="statediv"class="col-lg-4 col-sm-12 col-md-6 col-xs-12 ind_only" >
                    <select id="state" class="form-control" name="state">
                    <option value=''>State </option>
                    <?php for($i =0; $i<count($myplan['states']['name']); $i++){	
					?>
                    <option value="<?php echo $myplan['codes']['code'][$i];?>"><?php echo $myplan['states']['name'][$i];?></option>	
					<?php 
					}   
                    ?>
                    <option value='other'> others </option>
                    </select>
                    </div>
                    </div>
					
                    <div class="row">
                    <div class="col-lg-6 col-sm-12 col-md-6 col-xs-12">
                    <input type="text" id="zip" class="form-control" name="zip"  placeholder="Zip/Postal Code"/>
                    </div>
					<div id="gstdiv" class="ind_only">
                    <div class="col-sm-6 col-md-3 col-xs-6 col-lg-3 " >
                    <div class="input-group">
                    <span class="input-group-btn">
                    <input type="radio" name="gstno" id="descripcion" style="height:18px; width:18px; vertical-align: middle;margin-top:30px;" checked >
                    </span>
                    <input type="text" id="gstin" class="form-control descrip" name="gstin" value=''  placeholder="GST No." />
                    </div>
                    </div>
                    <div class="col-sm-6 col-lg-3 col-xs-6 col-md-3">
                    <input type="radio" name="gstno" id="1step"  value="not applicable" style="height:18px; width:18px;margin-top:40px;">&nbsp;<span style="font-size:15px;">Not applicable</span>
                    </div>
					</div>
					</div>
                    <div class="panel price panel-red">
					<input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
					<input type="hidden" name="hash" value="<?php echo $hash ?>"/>
					<input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
					
					<input type="hidden" name="action" id="action_pum"/>
					<input type="hidden" name="currency_code_pum" value="INR"/>
					<input type="hidden" name="nofuser" id="nofuser_pum" value=""/> 
					<input type="hidden" name="discount" id="discount_pum" value=""/>
					<input type="hidden" name="durarion" id="durarion_pum" value=""/>
					<input type="hidden" name="plan" id="plan_pum" value=""/>
					<input type="hidden" name="tax" id="tax_pum" value=""/>
					
					<input type="hidden" name="amount" id="amount_pum" value="<?php echo (empty($posted['amount'])) ? '' : $posted['amount'] ?>"/>
					<input type="hidden" name="firstname" id="firstname_pum" value="<?php echo $_SESSION['name']; ?>" />
					<input type="hidden" name="email" id="email_pum" value="<?php echo $_SESSION['Email']; ?>" />
					<input type="hidden" name="phone" id="phone_pum" value="<?php echo (empty($posted['phone'])) ? '' : $posted['phone'] ?>"/>
					<input type="hidden" name="postbulk_attendance" id="postbulk_attendance" value="0"/>
					<input type="hidden" name="postvisit_punch" id="postvisit_punch" value="0"/>
					<input type="hidden" name="postloc_trace" id="postloc_trace" value=""/>
					<input type="hidden" name="postgeo_fence" id="postgeo_fence" value=""/>
					<input type="hidden" name="postpayroll" id="postpayroll" value=""/>
					<input type="hidden" name="posttimeoff" id="posttimeoff" value=""/>
					
					<input type="hidden" name="stsbulk_attendance" id="stsbulk_attendance" value="0"/>
					<input type="hidden" name="stsvisit_punch" id="stsvisit_punch" value="0"/>
					<input type="hidden" name="stsloc_trace" id="stsloc_trace" value=""/>
					<input type="hidden" name="stsgeo_fence" id="stsgeo_fence" value=""/>
					<input type="hidden" name="stspayroll" id="stspayroll" value=""/>
					<input type="hidden" name="ststimeoff" id="ststimeoff" value=""/>
					
					<textarea style="display:none" name="productinfo"><?php echo (empty($posted['productinfo'])) ? 'data one' : $posted['productinfo'] ?></textarea>
					<input type="hidden" name="surl" value="<?php echo URL.'myplan/success'; ?>" size="64" />
					<input type="hidden" name="furl" value="<?php echo URL.'myplan/failed'; ?>" size="64" />
					<input type="hidden" name="service_provider" value="payu_paisa" size="64" />
							
							
                    <div class="panel-footer">
                    <?php if(!$hash) { ?>
						<input class="btn btn-success" id="payUMoney_button" onclick="return checkBillingForm();" type="Submit" value="Submit" />
					  <?php } ?>
                    </div>
                    </div>
                    </form>
					
                    <!-- /PRICE ITEM -->
                    <div class="clearfix"></div>
                    </div>
					</div>
					
					<!------------PayUMoney for end-------------->
                    <?php } else {?>
                    <!-- this form for paypal (start) -->
                    <div class="row" id="paypal" align="center" style="display:none;">
                    <!--<form id="frmPayPal1" action="<?php echo $paypalUrl; ?>" method="post" name="frmPayPal1">-->
					<form id="frmPayPal1" action="#" method="post" name="frmPayPal1">
					<h4><strong>Billing Details</strong></h4>
                   
                    <div class="row">
                    <div class="col-lg-6 col-sm-12 col-md-6 col-xs-12">
                    <input type="text" id="ind_name" class="form-control" name="Company" placeholder="Company Name" value="<?php //echo $individual; ?>"/>
                    <!--	<input type="text" class="form-control" id="country" name="country" value="india" readonly="true"  style="margin-bottom: 12px!important;"/> -->
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 col-xs-12">
                    <input type="number" id="contact" min="100000" max='999999999999999' class="form-control" name="contact" placeholder="Phone No." value=""/>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                    <textarea style="display:none" id="street" placeholder="Street Address" class="form-control" rows="2" name="street">no street</textarea>
                    </div>
                    </div>
                 <div class="row">
					 <div class="col-lg-4 col-sm-12 col-md-6 col-xs-12">
                    <select id="country" class="form-control" name="country">
                    <option value=''>Country </option>
                    <?php for($i =0; $i<count($myplan['country']['Name']); $i++){	
						?>
                    <option value="<?php echo $myplan['country']['Name'][$i];?>"><?php echo $myplan['country']['Name'][$i];?></option>	
					<?php 
                    }   
                    ?>
                    <option value='other'> others </option>
                    </select>
                    </div>
                    <div class="col-lg-4 col-sm-12 col-md-6 col-xs-12">
                    <input type="text" id="city" class="form-control" name="city" placeholder="City"/>
                    </div>
                    <div id="statediv"class="col-lg-4 col-sm-12 col-md-6 col-xs-12 ind_only">
                    <select id="state" class="form-control" name="state">
                    <option value=''>State </option>
                    <?php for($i =0; $i<count($myplan['states']['name']); $i++){	
						?>
                    <option value="<?php echo $myplan['codes']['code'][$i];?>"><?php echo $myplan['states']['name'][$i];?></option>	
					<?php 
                    }   
                    ?>
                    <option value='other'> others </option>
                    </select>
                    </div>
					
                    </div>
                    <div class="row">
                    <div class="col-lg-6 col-sm-12 col-md-6 col-xs-12">
                    <input type="text" id="zip" class="form-control" name="zip"  placeholder="Zip/Postal Code"/>
                    </div>
					<div id="gstdiv" class="ind_only">
                    <div class="col-sm-6 col-md-3 col-xs-6 col-lg-3">
                    <div class="input-group">
                    <span class="input-group-btn">
                    <input type="radio" name="gstno" id="descripcion" style="height:18px; width:18px; vertical-align: middle;margin-top:30px;" checked>
                    </span>
                    <input type="text" id="gstin" class="form-control descrip" name="gstin" value=''  placeholder="GST No." />
                    </div>
                    </div>
                    <div class="col-sm-6 col-lg-3 col-xs-6 col-md-3">
                    <input type="radio" name="gstno" id="1step" value="not applicable" style="height:18px; width:18px;margin-top:40px;">&nbsp;<span style="font-size:15px;">Not applicable</span>
                    </div>
					</div>
					</div>
                    <div class="panel price panel-red">
                    <input type="hidden" name="business" value="<?php echo $paypalId; ?>"/>
                    <input type="hidden" name="cmd" value="_xclick"/>
                    <input type="hidden" name="item_name" value="ubiAttendance Subscription"/>
                    <input type="hidden" name="item_number" value="2"/>
                    <input type="hidden" name="amount" id="amount" />
                    <input type="hidden" name="no_shipping" value="1"/>
                    <input type="hidden" name="currency_code" value="USD"/>
                    <input type="hidden" name="cancel_return" value="<?=URL?>Myplan/failed"/>
                    <input type="hidden" name="return" id="success" value="<?=URL?>Myplan/success"/> 
					<input type="hidden" name="nofuser" id="nofuser" value=""/> 
					<input type="hidden" name="stdate" id="stdate" value=""/> 
					<input type="hidden" name="endate" id="endate" value=""/> 
 					
                    <div class="panel-footer">
                    <button  type="button" href="#" id="paypal_button" ><img class="img-rounded" src="<?=URL?>../assets/img/PayPal_Paynow.png" style="max-width:150px; "/></button>
                    </div>
                    </div>
                    </form>
					
                    <!-- /PRICE ITEM -->
                    <div class="clearfix"></div>
                    </div>
                    <!-- This form for paypal(end) -->
					<?php } ?>
                    </div>	
                    </div>
					<!----End Tab for Billing Details---->
					
					
					
                    </div>
                    </div>
                    <!-- end .accordion_container -->
                    
                    </div>								
                  </div>
                </div>
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
			//	alert();
			//	return false;
				/////////////if data are valid
				$('#amount_pum').val(parseInt($('#total').text()));
				$('#nofuser_pum').val(parseInt($('#noOfUser_1').text()));
			//	$('#action_pum').val(action);
				$('#discount_pum').val(parseInt($('#discount_amt').text()));
				$('#tax_pum').val(parseInt($('#tax').text()));
				//alert($('#duration').val());
				
				$('#durarion_pum').val(parseInt($('#duration').val()));
				$("#phone_pum").val($("#contact").val());
				$('#plan_pum').val(c_plan);
				if($('#bulk_attcheck'). prop("checked") == true){
					$('#postbulk_attendance').val($('#bulkatt_tot').text());
					$('#stsbulk_attendance').val(1);
				}
					
				if($('#visit_punchcheck'). prop("checked")==true){
					$('#postvisit_punch').val($('#visitpunch_tot').text());
					$('#stsvisit_punch').val(1);
				}
					
				if($('#geo_fencecheck'). prop("checked")==true){
					$('#postgeo_fence').val($('#geofence_tot').text());
					$('#stsgeo_fence').val(1);
				}
					
				if($('#location_tracecheck'). prop("checked")==true){
					$('#postloc_trace').val($('#loctrace_tot').text());
					$('#stsloc_trace').val(1);
				}
					
				if($('#payroll_check'). prop("checked")==true){
					$('#postpayroll').val($('#payroll_tot').text());
					$('#stspayroll').val(1);
				}
					
				if($('#timeoff_check'). prop("checked")==true){
					$('#posttimeoff').val($('#timeoff_tot').text());
					$('#ststimeoff').val(1);
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
		data: {"street":street,"city":city,"zip":zip,"ind_name":ind_name,"state":state,"country":country,"contact":contact,"duration":duration,"gstin":gstin,"plan":plan,"noofusers":noofusers,"currency":currency,"taxforinr":taxforinr,"total":total,"discount":discount,"action":'BUY'},
				success: function(result){
					
				 },
				error: function(result){
					//alert('error');
				 }
		   });
	}
	
  </script>
  <script>
 $(document).ready(function () {
	 $('.ind_only').hide();	 
	 $("#country").change(function(){
	//	 alert($("#country").val());
	console.log($("#country").val());
		 if($("#country").val()=='India'){
			$('.ind_only').show();
			console.log("if");
		 }
		 else{
			 $('.ind_only').hide();
			 console.log("else");
		 }
		 console.log("end");
	 });
	 
    $(function () {
        $(".accordion_head").click(function () {
            if ($('.accordion_body').is(':visible')) {
                $(".accordion_body").slideUp(300);
                $(".updown").text('\u25BC');
            }
            if ($(this).next(".accordion_body").is(':visible')) {
                $(this).next(".accordion_body").slideUp(300);
                $(this).children(".updown").text('\u25BC');
            } else {
                $(this).next(".accordion_body").slideDown(300);
                $(this).children(".updown").text('\u25B2');
            }
        });
        $(".next-button").click(function () {
            if ($('.accordion_body').is(':visible')) {
                $(".accordion_body").slideUp(300);
                $(".updown").text('\u25BC');
            } else {
                $(this).next(".accordion_body").slideDown(300);
                $(this).children(".updown").text('\u25B2');
            }
        });  
        $(".accordion_body select").change(function () {
            nextQuestion($(this));
        });
        $(".accordion_body input").change(function () {
            nextQuestion($(this));
        });
    	
    	$(".next-button1").click(function () {
    			pid=$('#pid').val();
    			$("#edit1").show();		
				$('#noOfUser').val(0);
				$('#duration').val(0);
				$('#yearly').click();    		
				if(currency=='USD' && $('#dis_usd_year').val()!=0)
					$("#dis").text('Buy yearly ubiAttendance plan and  get '+$('#dis_usd_year').val()+'% Instant discount on billing amount.');
				else if(currency=='INR' && $('#dis_inr_year').val()!=0)
					$("#dis").text('Buy yearly ubiAttendance plan and  get '+$('#dis_inr_year').val()+'% Instant discount on billing amount.');
					
				currency=$('#currency').val();
				/* $(".accordion_body1").slideUp(300);
				$(".accordion_body3").slideDown(300); */
				
                $(".accordion_body1").slideUp(300);
                $(".accordion_body3").slideDown(300);
        }); 
    	
    	$("#continue").click(function(){
    		$("#edit2").show();			
    		if($('#currency').val() == ""){
    		  	alert("Please select currency");
    			return false;
    		}
			$('#noOfUser').val(0);
			$('#duration').val(0);
    		$('#yearly').click();    		
			if(currency=='USD' && $('#dis_usd_year').val()!=0)
				$("#dis").text('Buy yearly ubiAttendance plan and  get '+$('#dis_usd_year').val()+'% Instant discount on billing amount.');
			else if(currency=='INR' && $('#dis_inr_year').val()!=0)
				$("#dis").text('Buy yearly ubiAttendance plan and  get '+$('#dis_inr_year').val()+'% Instant discount on billing amount.');
    			
    		currency=$('#currency').val();
    		$(".accordion_body1").slideUp(300);
            $(".accordion_body3").slideDown(300);
    	})
		
    var price=0;
	var total=0;
    var startdate="";
    var lastdate="";
	var no_of_users="";
	var tax=0;
	var discount=0;
	var duration=0;
	var mduration=0;
	var bulkprice=0;
	var visitprice=0;
	var timeoffprice=0;
	var payrollprice=0;
	var loctraceprice=0;
	var geofenceprice=0;
	var bulkperprice=0;
	var visitperprice=0;
	var timeoffperprice=0;
	var payrollperprice=0;
	var loctraceperprice=0;
	var geofenceperprice=0;
	var totalcart=0;
    
    	$("#continue2").click(function(){ 
		
		if($("#noOfUser").val()==0 ||$("#noOfUser").val()=='')
		{
			alert("Please enter no. of users");
			$("#noOfUser").focus();
			return false;
		}
		if($("#noOfUser").val()<4)
		{
			alert("Minimum user limit is 4 for premium plan");
			$("#noOfUser").focus();
			return false;
		}
		if($("#duration").val()==0 ||$("#duration").val()=='')
		{	
			var msg='';
			if(plan=='YEARLY')
				msg='Please enter no. of years';
			else
				msg='Please enter no. of months';
			alert(msg);
			$("#duration").focus();
			return false;
		}
		$(".bulk").hide();
		$(".visit").hide();
		$(".geo").hide();
		$(".payroll").hide();
		$(".loc").hide();
		$(".timeoff").hide();
		$('#bulk_attcheck'). prop("checked", false);
		$('#visit_punchcheck'). prop("checked", false);
		$('#geo_fencecheck'). prop("checked", false);
		$('#location_tracecheck'). prop("checked", false);
		$('#payroll_check'). prop("checked", false);
		$('#timeoff_check'). prop("checked", false);
		duration=$("#duration").val();
		if(plan=='YEARLY'){
			$("#duration_1").text(duration + ' Year(s)');
			//mduration=duration*10;
		}
		else{
			$("#duration_1").text(duration + ' Month(s)');
			//mduration=duration;
		}
		mduration=duration;
		$("#noOfUser_1").text($("#noOfUser").val());
		
    	
    	var x=$("#noOfUser").val();
		no_of_users=x;
		var element='';
		if(plan=='YEARLY' && currency=="USD"){
			element='usdYearly';
			$('#discount').text($('#dis_usd_year').val());
		}
		else if(plan=='MONTHLY' && currency=="USD"){
			element='usdMonthly';
			$('#discount').text($('#dis_usd_month').val());
			if(duration>=12)
			{
			    element='usdYearly';
			   $('#discount').text($('#dis_usd_year').val());
			}
			
			
		}
		else if(plan=='YEARLY' && currency=="INR"){
			element='inrYearly';
			$('#discount').text($('#dis_inr_year').val());
			
		}
		else if(plan=='MONTHLY' && currency=="INR"){
			element='inrMonthly';
			$('#discount').text($('#dis_inr_month').val());
			if(duration >= 12)
			{
			   element='inrYearly';
			   $('#discount').text($('#dis_inr_year').val());
			}
			
		}
       switch (true) {
                 case (x  >= 1 && x <= 20):
					$('#rate').text($('#'+element+'0').text());
					bulkperprice=$('#bulk_attendance'+currency+'0').text();
					visitperprice=$('#visit_punch'+currency+'0').text();
					timeoffperprice=$('#time_off'+currency+'0').text();
					payrollperprice=$('#payroll'+currency+'0').text();
					loctraceperprice=$('#location_tracing'+currency+'0').text();
					geofenceperprice=$('#geo_fence'+currency+'0').text();
					
                 break;
                 case (x  >= 21 && x <= 40):
					$('#rate').text($('#'+element+'1').text());
					bulkperprice=$('#bulk_attendance'+currency+'1').text();
					visitperprice=$('#visit_punch'+currency+'1').text();
					timeoffperprice=$('#time_off'+currency+'1').text();
					payrollperprice=$('#payroll'+currency+'1').text();
					loctraceperprice=$('#location_tracing'+currency+'1').text();
					geofenceperprice=$('#geo_fence'+currency+'1').text();
                 break;
                 case (x  >= 41 && x <= 60):
					$('#rate').text($('#'+element+'2').text());
					bulkperprice=$('#bulk_attendance'+currency+'2').text();
					visitperprice=$('#visit_punch'+currency+'2').text();
					timeoffperprice=$('#time_off'+currency+'2').text();
					payrollperprice=$('#payroll'+currency+'2').text();
					loctraceperprice=$('#location_tracing'+currency+'2').text();
					geofenceperprice=$('#geo_fence'+currency+'2').text();
                 break;
				 case (x  >= 61 && x <= 80):
					$('#rate').text($('#'+element+'3').text());
					bulkperprice=$('#bulk_attendance'+currency+'3').text();
					visitperprice=$('#visit_punch'+currency+'3').text();
					timeoffperprice=$('#time_off'+currency+'3').text();
					payrollperprice=$('#payroll'+currency+'3').text();
					loctraceperprice=$('#location_tracing'+currency+'3').text();
					geofenceperprice=$('#geo_fence'+currency+'3').text();
                 break;
				 case (x  >= 81 && x <= 100):
					$('#rate').text($('#'+element+'4').text());
					bulkperprice=$('#bulk_attendance'+currency+'4').text();
					visitperprice=$('#visit_punch'+currency+'4').text();
					timeoffperprice=$('#time_off'+currency+'4').text();
					payrollperprice=$('#payroll'+currency+'4').text();
					loctraceperprice=$('#location_tracing'+currency+'4').text();
					geofenceperprice=$('#geo_fence'+currency+'4').text();
                 break;
				 case (x  >= 101 && x <= 120):
					$('#rate').text($('#'+element+'5').text());
					bulkperprice=$('#bulk_attendance'+currency+'5').text();
					visitperprice=$('#visit_punch'+currency+'5').text();
					timeoffperprice=$('#time_off'+currency+'5').text();
					payrollperprice=$('#payroll'+currency+'5').text();
					loctraceperprice=$('#location_tracing'+currency+'5').text();
					geofenceperprice=$('#geo_fence'+currency+'5').text();
                 break;
				 case (x  >= 120 ):
					$('#rate').text($('#'+element+'6').text());
					bulkperprice=$('#bulk_attendance'+currency+'6').text();
					visitperprice=$('#visit_punch'+currency+'6').text();
					timeoffperprice=$('#time_off'+currency+'6').text();
					payrollperprice=$('#payroll'+currency+'6').text();
					loctraceperprice=$('#location_tracing'+currency+'6').text();
					geofenceperprice=$('#geo_fence'+currency+'6').text();
                 break;
				 
                 default:
                 break;
              }
			  
			  var cur='';		
				if(currency=='USD')
					cur='$';
				else
					cur='Rs.';
				var plan_m_y="/month";
				if(plan=='YEARLY'){
					bulkperprice=bulkperprice*12;
					visitperprice=visitperprice*12;
					timeoffperprice=timeoffperprice*12;
					payrollperprice=payrollperprice*12;
					loctraceperprice=loctraceperprice*12;
					geofenceperprice=geofenceperprice*12;
					plan_m_y="/year";
				}
				bulkprice=bulkperprice*mduration*no_of_users;
				visitprice=visitperprice*mduration*no_of_users;
				timeoffprice=timeoffperprice*mduration*no_of_users;
				payrollprice=payrollperprice*mduration*no_of_users;
				loctraceprice=loctraceperprice*mduration*no_of_users;
				geofenceprice=geofenceperprice*mduration*no_of_users;
			  
				$('#bulkatt_perprice').text("Bulk Attendance @"+cur+" "+bulkperprice+plan_m_y);
				$('#loctrace_perprice').text("Location Tracing @"+cur+" "+loctraceperprice+plan_m_y);
				$('#visit_perprice').text("Visit Punch @"+cur+" "+visitperprice+plan_m_y);
				$('#payroll_perprice').text("Hourly Pay @"+cur+" "+payrollperprice+plan_m_y);
				$('#gfence_perprice').text("Geo Fence @"+cur+" "+geofenceperprice+plan_m_y);
				$('#timeoff_perprice').text("Time Off @"+cur+" "+timeoffperprice+plan_m_y);
				
				$('#bulk_attprice').text(bulkprice);
				$('#location_traceprice').text(loctraceprice);
				$('#visit_punchprice').text(visitprice);
				$('#payroll_price').text(payrollprice);
				$('#geo_fenceprice').text(geofenceprice);
				$('#timeoff_price').text(timeoffprice);
				
				$('#bulkatt_tot').text(bulkprice);
				$('#loctrace_tot').text(loctraceprice);
				$('#visitpunch_tot').text(visitprice);
				$('#payroll_tot').text(payrollprice);
				$('#geofence_tot').text(geofenceprice);
				$('#timeoff_tot').text(timeoffprice);
				
				price = x * ($('#rate').text());
				//console.log('rate:'+$('#rate').text());
				 if(plan == "MONTHLY" && duration >= 12)
				{
					price = x * (($('#rate').text())/12);
					$('#rate').text((($('#rate').text())/12).toFixed(2));
				}
				var amount=0;
				var amount= price*($("#duration").val());
				console.log(amount);
				$('#amount1').text(amount);
				discount = (Number(amount) * Number($('#discount').text())) /100;
				$('#discount_amt').text(discount);
				tax=0;
				var tax_per=0;
				if(currency=='INR')	{
					tax=((amount-discount)*18)/100;
					tax_per=18.00;
					$('#tax_1').text(' (in %) '+tax_per);
				}
				$('#tax').text(tax);
				$('#_per').text((('/'+plan).toLowerCase()).replace('ly', ''));
				total=(amount-discount)+tax;
				$('#total').text(total);
				
				$("#edit3").show();
				//$("#edit6").show();
				
				
				
				totalcart=amount-discount;
				console.log(totalcart);
				$('#ocurr').text(cur+" ");
				$('#onousers').text(no_of_users);
				$('#oplandur').text(duration+" "+(plan.toLowerCase()).replace('ly', '(s)'));
				$('#cartval').text(totalcart);
				
				$(".accordion_body3").slideUp(300);
				//$(".accordion_body4").slideDown(300);
				$(".accordion_body6").slideDown(300);
    	});
    	
		$("#bulk_attcheck").click(function(){
			if($('#bulk_attcheck'). prop("checked")==true){
				totalcart=totalcart+bulkprice;		
				$(".bulk").show();
			}else{
				totalcart=totalcart-bulkprice;
				$(".bulk").hide();	
			}
			$('#cartval').text(totalcart);
		});
		$("#visit_punchcheck").click(function(){
			if($('#visit_punchcheck'). prop("checked")==true){
				totalcart=totalcart+visitprice;
				$(".visit").show();
			}else{
				totalcart=totalcart-visitprice;
				$(".visit").hide();
			}
			$('#cartval').text(totalcart);
		});
		$("#geo_fencecheck").click(function(){
			if($('#geo_fencecheck'). prop("checked")==true){
				totalcart=totalcart+geofenceprice;
				$(".geo").show();
			}else{
				totalcart=totalcart-geofenceprice;
				$(".geo").hide();
			}
			$('#cartval').text(totalcart);
		});
		$("#location_tracecheck").click(function(){
			if($('#location_tracecheck'). prop("checked")==true){
				totalcart=totalcart+loctraceprice;
				$(".loc").show();
			}else{
				totalcart=totalcart-loctraceprice;
				$(".loc").hide();
			}
			$('#cartval').text(totalcart);
		});
		$("#payroll_check").click(function(){
			if($('#payroll_check'). prop("checked")==true){
				totalcart=totalcart+payrollprice;
				$(".payroll").show();
			}else{
				totalcart=totalcart-payrollprice;
				$(".payroll").hide();
			}
			$('#cartval').text(totalcart);
		});
		$("#timeoff_check").click(function(){
			if($('#timeoff_check'). prop("checked")==true){
				totalcart=totalcart+timeoffprice;
				$(".timeoff").show();
			}else{
				totalcart=totalcart-timeoffprice;
				$(".timeoff").hide();
			}
			$('#cartval').text(totalcart);
		});
		
    	$("#continue6").click(function(){
			var ragisteruser  =   <?php echo countRegisteredEmployee($_SESSION['orgid']); ?>;
			if((ragisteruser - no_of_users)>0)
			{
				$("#trdueamount").show();
				$("#tradditionaluse").show();
			    $("#additionaluse").text(ragisteruser - no_of_users);
			    $("#dueamount").text((totalcart /no_of_users)*(ragisteruser - no_of_users));
		    	
			}
			else
			{
				$("#trdueamount").hide();
				$("#tradditionaluse").hide();
			    $("#additionaluse").text("");
			    $("#dueamount").text("");
			}
			/*alert(ragisteruser);
			alert(no_of_users);
     			alert(totalcart);*/
			$("#edit6").show();
			console.log(totalcart);
			discount=(Number(totalcart) * Number($('#discount').text())) /100;
			var tax_per=0;
			if(currency=='INR')	{
				tax=((totalcart-discount)*18)/100;
				tax_per=18.00;
				$('#tax_1').text(' (in %) '+tax_per);
			}
			$('#tax').text(tax);
			$('#discount_amt').text(discount);
			$('#amount_tot').text(totalcart);
			total=(totalcart-discount)+tax;
			$('#total').text(total);
			$(".accordion_body6").slideUp(300);
			$(".accordion_body4").slideDown(300);
    	});
    	
    	
    	$("#continue3").click(function(){
    		$("#edit4").show();
    		$("#finalPackage").text(parseFloat($('#revTotal').text()));
    		$("#finalAddons").text(parseFloat($('#addOnUserAmt1').text()));
    		$("#finalDiscount").text(parseFloat($('#revDiscountAmt').text()));
    		$("#finalTax").text(parseFloat(parseFloat($('#revGrandTotal').text()))*igst/100);
    		$("#finalTotal").text(parseFloat($('#revGrandTotal').text())+parseFloat($("#finalTax").text()));
    		//$("#finalamount").val(1250);
    		$('#finalamount').attr('value', $('#finalTotal').text());
    		$("#payPalAmount").val(parseFloat($('#finalTotal').text()));
    		$('#sel_addon_amt').val($("#finalAddons").text());
    		$('#sel_discount_amt').val($("#finalDiscount").text());
    		$('#sel_tax').val($("#finalTax").text());
    		$('#sel_plan').val(plan);
    		$(".accordion_body4").slideUp(300);
            $(".accordion_body5").slideDown(300);
    		
			if(currency=='USD'){
				$('#statediv').hide();
				$('#gstdiv').hide();
    			$('#paypal').show();
    		}
    		else{
    			$('#paypal').show();
				$('#statediv').show();
				$('#gstdiv').show();
    		}
    	})
    	
    		$('#paypal_button').click(function(){ 
				if($("#street").val()=='')
				{
					$("#street").focus();
					alert('Please fill street address');
					return false;
				}
				if($("#city").val()=='')
				{
					$("#city").focus();
					alert('Please fill city ');
					return false;
				}
				if($("#country").val()=='')
				{
					$("#country").focus();
					alert('Please fill country ');
					return false;
				}
				if($("#zip").val()=='')
				{
					$("#zip").focus();
					alert('Please fill zip ');
					return false;
				}
				/* if($("#state").val()=='')
				{
					$("#state").focus();
					alert('Please select state  ');
					return false;
				} */
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
				/*	var user=$('#nousers').text();
							alert(user);
							alert(startdate);
							alert(lastdate);
							alert(total);
				 return;*/
		$("#amount").val(total);
		$("#nofuser").val(no_of_users);
		$("#stdate").val('');
		$("#stdate").val('');
		stdate='';
		endate='';
		
		    var business = '';
			var street = $("#street").val();
			var city = $("#city").val();
			var zip = $("#zip").val();
			var ind_name = $("#ind_name").val();
			var state = $("#state").val();
			var country = $("#country").val();
			var contact = $("#contact").val();
			var duration = $("#duration").val(); 
			var gstin = $("#gstin").val(); 
			
			var bulkAtt_sts=($('#bulk_attcheck'). prop("checked")==true)?1:0;
			var bulk_attp = (bulkAtt_sts==1)?bulkprice:0;   
			var visit_punchsts=($('#visit_punchcheck'). prop("checked")==true)?1:0;
			var visit_punchp = (visit_punchsts==1)?visitprice:0;    
			var loc_tracests=($('#location_tracecheck'). prop("checked")==true)?1:0;
			var loc_tracep = (loc_tracests==1)?loctraceprice:0;    
			var geo_fencests=($('#geo_fencecheck'). prop("checked")==true)?1:0;
			var geo_fencep = (geo_fencests==1)?geofenceprice:0;    
			var payrollsts=($('#payroll_check'). prop("checked")==true)?1:0;
			var payrollp = (payrollsts==1)?payrollprice:0;    
			var timeoffsts=($('#timeoff_check'). prop("checked")==true)?1:0;
			var timeoffp = (timeoffsts==1)?timeoffprice:0; 
			
		savetemppay();
		var string = "";	
		
			string += "?plan="+plan+"%26";
			string += "ind_name="+ind_name+"%26";
			string += "contact="+contact+"%26";
			string += "street="+btoa(street)+"%26";
			string += "country="+btoa(country)+"%26";
			string += "zip="+zip+"%26";
			string += "noofusers="+no_of_users+"%26";
			string += "currency="+currency+"%26";
			string += "taxforinr="+btoa(tax)+"%26";
			string += "total="+btoa(total)+"%26";
			string += "discount="+btoa(discount)+"%26";
			string += "duration="+btoa(duration)+"%26";
			string += "city="+btoa(city)+"%26";
			string += "gstin="+gstin+"%26";
			string += "bulk_attendance="+bulk_attp+"%26";
			string += "bulk_attsts="+bulkAtt_sts+"%26";
			string += "visit_punch="+visit_punchp+"%26";
			string += "visit_punchsts="+visit_punchsts+"%26";
			string += "geo_fence="+geo_fencep+"%26";
			string += "geo_fencests="+geo_fencests+"%26";
			string += "loc_trace="+loc_tracep+"%26";
			string += "loc_tracests="+loc_tracests+"%26";
			string += "payroll="+payrollp+"%26";
			string += "payrollsts="+payrollsts+"%26";
			string += "timeoff="+timeoffp+"%26";
			string += "timeoffsts="+timeoffsts+"%26";
			
		     var article="Attendance subscription";
			// var paypal_email = 'namrata@ubitechsolutions.com'; // for live
			var paypal_email = 'namrata@ubitechsolutions.com'; //for Sandbox
			
				
				var return_url = '<?=URL?>Myplan/success'+string;
				//console.log(return_url);
				//exit();
				var cancel_url = '<?=URL?>Myplan/failed'+string;
				var querystring = "?business="+(paypal_email)+"&";	
				querystring += "item_name="+article+"&";
				querystring += "amount="+total+"&";
				querystring += "hosted_button_id=C5567TZ5WM9H4&";					
				querystring += "no_note=1&";					
				querystring += "lc=US&";							
				querystring += "currency_code="+currency+"&";//"currency_code=USD&";					
				querystring += "bn=PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest&";					
				querystring += "first_name="+ind_name+"&";					
				querystring += "last_name=&";					
				querystring += "payer_email="+paypal_email+"&";					
				querystring += "cmd=_xclick&";
									
				querystring += "return="+return_url+"&";
				querystring += "cancel_return="+cancel_url+"&";
				//querystring += "notify_url="+notify_url;
				querystring += "&custom="+endate;
		window.open('https://www.sandbox.paypal.com/cgi-bin/webscr'+querystring,"_blank");  //sand box
		// window.open('https://www.paypal.com/cgi-bin/webscr'+querystring,"_self"); // live 
		
		//return true;
							
							
            });
    
    	
    	<!-- Bydefault checkbox is checked (start) -->
    	$('#CountinueWithUser').prop('checked', true); // Checks it
        $('#ChangeSubscription').prop('checked', true);
    	<!-- Bydefault checkbox is checked (end) -->
    	 
    	if($('#CountinueWithUser').prop("checked") == true){
    		
    	}
    	if($('#ChangeSubscription').prop("checked") == true){
    		 $('#SubscriptionMonth').show();
    	}
    	
        $('#ChangeSubscription').change(function() {
            if($(this).prop('checked')) {
              $('#SubscriptionMonth').show(); 
            }else {
               $('#SubscriptionMonth').hide();
            }
        }); 	
    });
    
    function nextQuestion(currentQuestion) {
        var parentEle = currentQuestion.parents(".accordion_main");
        if (parentEle.next()) {
            parentEle.find(".question-mark").addClass("glyphicon glyphicon-ok check-mark").removeClass("question-mark").text("");
           if (currentQuestion.attr('type')!='checkbox'){
            if (parentEle.next().find(".accordion_head").length>0){
            parentEle.next().find(".accordion_head").click();
            }
             else {
            //there is no next--> try to go to the next colum
            parentEle.parent("div").next("div").find(".accordion_head").first().click();
                }
             }
        }
    }
	});
  </script>
</html>