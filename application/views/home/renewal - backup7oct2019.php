
<?php
 
  $paypalUrl='https://www.sandbox.paypal.com/cgi-bin/webscr';// sandbox
  $paypalId='glbsng@gmail.com';		// sandbox
  
 
  /*$paypalUrl='https://www.paypal.com/cgi-bin/webscr';// production
  $paypalId='namrata@ubitechsolutions.com'; 			// production*/
  
 //--------------------------------------------PAYUMONEY INTEGRATION CODE
 // Merchant key here as provided by Payu
   //$MERCHANT_KEY = "dv1tL3LP";		//live key
   // $MERCHANT_KEY = "rjQUPktU";	//sandbox key
   $MERCHANT_KEY = "hDkYGPQe";  //sandbox key

// Merchant Salt as provided by Payu
	//$SALT = "AlGt0f59fS";			//live key
	// $SALT = "e5iIg1jwi8";			//sandbox key
  $SALT = "yIEkykqEH3";     //sandbox key

	$PAYU_BASE_URL = "https://test.payu.in"; // for sandbox
	//$PAYU_BASE_URL = "https://secure.payu.in";// for LIVE mode

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

if(empty($posted['hash']) && sizeof($posted) > 0)
 {
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
.addon
{
background-color:grey;
color:white;
}

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
	  
	   var action='UO'; // UPDATE- 'UO'/'DO'/'UD'- Users only/ Duration only/ time and duration both
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
                      <h6 class="nav-tabs-title">Upgrade Plan
					  <a onClick="location.reload();" style="margin:0px; padding: 5px 15px; background-color:#45a149;" class="pull-right btn">Reset</a>
					  </h6>
					  
					</div>
                  </div>
                </div>
                <div class="card-content table-responsive">
                  <div class="row">
                      <div class="accordion_container">
                        <div class="row">
                          <div class="col-xs-12 col-md-12 col-lg-12">
                	
					
					      <!-------currency tab open------>
                            <div class="accordion_main" hidden>
                              <div class="accordion_head">Currency <button id="edit2" data-toggle="dropdown" aria-expanded="false" type="button" class="btn editbutton"><i  class="fa fa-pencil " style="font-size:12px;margin-top:0px;top:0px;"></i> Edit</button></div>
                              <div class="accordion_body2 ">
                                <div class="row" >
                                  <div class="col-md-4" ></div>
                                  <div class="col-md-2">
                                    <div class="form-group">
                                      <div class="form-group">
                                        <select class="form-control" id="currency" style="cursor:auto;" disabled>
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
								  
							
								  
                                  <div class="col-md-3" ></div>
                                </div>
                                <button type="button" class="btn btn-success" id="continue"  data-toggle="dropdown" aria-expanded="false">Continue</button>
                              </div>
                            </div>
							<!---- currency tab close-- ---->
							
							
							
							
							
							
							<!---- select palan open-- ---->
                            <div class=	"accordion_main" >
                              <div class="accordion_head">Select Plan<button id="edit3" type="button" class="btn editbutton"><i  class="fa fa-pencil " style="font-size:12px;margin-top:0px;top:0px;"></i> Edit</button></div>
                              <div class="accordion_body3" style="display: none;" >
                                <!------existing plan------>
								<div>
							<h4 align="center" style="margin-right: -112px"><strong> &nbsp;&nbsp;&nbsp;&nbsp;   </strong></h4>
									<!--<div class="row text-center" style="padding-left:10px">
									<div class="col-xs-12 col-sm-6 col-md-4 col-lg-12">
									   <strong></strong> <span id="ddd"></span>
									</div>
								</div>-->
							
	<!--------------------------------Start New Code ----------------------------------------->
<!--<?php //echo($myplan['totalUser'] < $myplan['user_limit']) ? "User limit should be greater than or equal to the registered users.": ""; ?>-->
	<div class="row" >
		<div class="col-sm-6" style="margin-top: -35px;">
			<h4><strong>Upgrade Plan</strong></h4>
			<!------Upgrade Plan--------->
			<div  class="row">
					 <br/>
				     <div id="operation" class="col-sm-8 col-md-8 col-xs-8">
							<!--- <h5>I want to upgrade</h5>--->
							<div class="radio">
								 <label><input type="radio" value="user_only" name="get_opr" checked>Update User Limit only</label>
							</div>
							<div class="radio">
								<label><input type="radio" value="duration_only" name="get_opr"  <?php echo($myplan['totalUser'] > $myplan['user_limit']) ? "disabled":  ""; ?>  >Renew only</label>
								 <span style="margin-left:2px;font-size:12px;color:orange" >   
								 </span>
							</div>
							<div class="radio">
								<label><input type="radio" value="duration_user" name="get_opr" >Renew & update User Limit</label>
							</div>
							<input type="button" value="Go" id="go" class="btn btn-warning" />
						</div>
					
					<div class="col-sm-8 col-md-8" id="iwant" style="display:none;">
							<div class="row container">
								<div class="col-md-4 col-lg-4 col-xl-4 col-sm-12 col-xs-12 planduration" style="padding-left: 0px;">
									<div class="form-group" style="margin-top: 15px;">
										<label for="inputsm">Plan Duration </label><br/>
										<div class="radio" style="display: inline;">
											<label>
											<input id="yearly" name="monthopt" type="radio" >Yearly&nbsp;&nbsp;</label>
										</div>
										<div class="radio" style="display: inline;">
											<label><input id="monthly" name="monthopt" type="radio" >Monthly&nbsp;&nbsp;</label>
										</div>
									</div>
								</div>
								<strong>
							&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:green;" id='dis'></span>
								</strong>					
							</div>
                  
                    <!------ end btn ------>	
					
                    <div class="row" style="margin-top: -23px;">
                    
										<?php
										if(isset($myplan['user_limit']) && (($myplan['user_limit']-$myplan['totalUser'])<0)){
										$diff=$myplan['totalUser']-$myplan['user_limit'];
										
										}
										?>
                                 <div class="col-xs-6" id="noy" style="margin-left: 0px;">
                                    <div class="form-group" style="margin-top: 15px;">
										<label for="inputsm">No. of <span id="pln">years</span>s</label>
										 <input type="number" title="Please enter the no. of year(s) or month(s)" min="0" tooltip="You can't set your " class="form-control" id="duration" maxlength="250" value='0' name="duration" placeholder="" required>
                                    </div>
                                  </div>
                                  <div class="col-xs-6" id="nou" style="margin-left: 0px;">
                                    <div class="form-group"  style="margin-top: 15px;">
                                      <label for="inputsm">  Additional Users </label>
                                      <input title='Pleae enter the no. of additional users' type="number" min="0" class="form-control" value='0' id="noOfUser" name="noOfUser" placeholder="" required >
                                    </div>
                                  </div>
								    
					 
					<span style="color:red" id='err'></span>
                    
					<!--<div class="col-md-1 col-lg-1 col-xl-1 col-sm-12 col-xs-12" ></div>-->
					<div class="col-md-4 col-lg-4 col-xl-4 col-sm-12 col-xs-12" style="display:none" >
					
						<div  style="padding-left:0px;padding-right:0px;">
							<div class="panel panel-default">
								<div class="panel-heading" align="center">
									<h4  align="center">Price List</h4>
								</div>
								<div id="inrList">
								<table class="tab1">
									  <tr>
										<th><center>No. of Employees</center></th>
										<th><center>Price/month(INR)</center></th>
										<th><center>Price/year(INR)</center></th>
										<th><center>Group Attendance</center></th>
										<th><center>Location Tracking</center></th>
										<th><center>Visit Punch</center></th>
										<th><center>Geo Fence</center></th>
										<th><center>Hourly Pay</center></th>
										<th><center>Time Off</center></th>
									  </tr>
									  <?php 
									  $i=0;
										foreach($myplan['planinfo']['inr'] as $row){
											echo "<tr>
													<td><span>".$row['range']."</span></td>
													<td><span id='inrMonthly".$i."'>".$row['monthly']."</span></td>
													<td><span id='inrYearly".$i."'>".$row['yearly']."</span></td>
													<td><span id='inrbulk_attendance".$i."'>".$row['bulk_attendance']."</span></td>
													<td><span id='inrlocation_tracing".$i."'>".$row['location_tracing']."</span></td>
													<td><span id='inrvisit_punch".$i."'>".$row['visit_punch']."</span></td>
													<td><span id='inrgeo_fence".$i."'>".$row['geo_fence']."</span></td>
													<td><span id='inrpayroll".$i."'>".$row['payroll']."</span></td>
													<td><span id='inrtime_off".$i."'>".$row['time_off']."</span></td>
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
										<th><center>Price/month($)</center></th>
										<th><center>Price/year($)</center></th>
									  </tr>
									   <?php 
									   $i=0;
										foreach($myplan['planinfo']['usd'] as $row){
											echo "<tr>
													<td><span>".$row['range']."</span></td>
													<td><span id='usdMonthly".$i."'>".$row['monthly']."</span></td>
													<td><span id='usdYearly".$i."'>".$row['yearly']."</span></td>
													<td><span id='usdbulk_attendance".$i."'>".$row['bulk_attendance']."</span></td>
													<td><span id='usdlocation_tracing".$i."'>".$row['location_tracing']."</span></td>
													<td><span id='usdvisit_punch".$i."'>".$row['visit_punch']."</span></td>
													<td><span id='usdgeo_fence".$i."'>".$row['geo_fence']."</span></td>
													<td><span id='usdpayroll".$i."'>".$row['payroll']."</span></td>
													<td><span id='usdtime_off".$i."'>".$row['time_off']."</span></td>
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

                    <button type="button" class="btn btn-success" id="continue2"  data-toggle="dropdown" aria-expanded="false">Continue</button>
                  </div>
				  
				  
				  
				  
			      </div>
			<!--------------->
		</div>
		<div class="col-sm-6" style="background-color:#ecebeb"></div>
		<div class="col-sm-6" style="width:45%;background-color:#ecebeb">
		<h4 align="center" ><strong>Existing Plan: Premium</strong></h4>
		<div class="row" style="padding-left:146px">
			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-12">
			   <strong>Currency:</strong> <span id="showcurr"></span>
			</div>
		</div>
		
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					  <label for="inputsm"><strong>Start Date</strong></label>
					  <span class="form-control input-sm " id="startdate"  type="text" value="" disabled ><?php if(isset($myplan['start_date'])){ echo $myplan['start_date']; } ?></span>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label for="inputsm"><strong>End Date</strong></label>
						<span class="form-control input-sm" id="enddate"  type="text" value="" disabled ><?php if(isset($myplan['end_date'])){ echo $myplan['end_date']; } ?>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-top:-104px;" >
		<div class="col-sm-6"></div>
			<div class="col-sm-6"  style="width: 45%;background-color:#ecebeb;margin-top: -2px;">
				<div class="row" style="margin-top: -13px">
					<div class="col-sm-6">
					  <div class="form-group">
						  <label for="inputsm"><strong>Registered Users </strong></label>
						  <span class="form-control input-sm" id="totalusers"  type="text" value="" disabled>
						  <?php 
						  if(isset($myplan['totalUser'])){ echo $myplan['totalUser']; } 
						  ?></span>
						</div>
					</div>
				<div class="col-sm-6">
					<div class="form-group">
					  <label for="inputsm"><strong>User Limit</strong> </label>
					  <span class="form-control input-sm" id="userlimit"  type="text" value="" disabled ><?php if(isset($myplan['user_limit'])){ echo $myplan['user_limit']; } ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!--<div class="row">
		<div class="col-sm-6"></div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputsm"> <strong>Previous Dues</strong></label>
								<span class="form-control input-sm" disabled ><?php if(isset($myplan['due_amount'])){ echo $myplan['due_amount']; } ?></span>
						</div>
					</div>
				</div>
			</div>
	</div>-->






				
				<!------------End  -New Code -------------------------->				
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
<!-----------------------------------Start Old Code---------------------------------------->

								 <!--<div class="row" style="padding:10px;padding-top: 0px;">
                                  <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                    <div class="form-group">
                                      <label for="inputsm"> <strong>Start Date</strong></label>
                                      <span class="form-control input-sm " id="startdate"  type="text" value="" disabled ><?php if(isset($myplan['start_date'])){ echo $myplan['start_date']; } ?></span>
                                    </div>
                                  </div>
                                  <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                    <div class="form-group">
										<label for="inputsm"> <strong>End Date</strong></label>
										<span class="form-control input-sm" id="enddate"  type="text" value="" disabled ><?php if(isset($myplan['end_date'])){ echo $myplan['end_date']; } ?>
										</span>
                                    </div>
                                  </div>
                                 
                                  <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                    <div class="form-group">
                                      <label for="inputsm"><strong>Registered Users </strong></label>
                                      <span class="form-control input-sm" id="totalusers"  type="text" value="" disabled >
									  <?php 
									  if(isset($myplan['totalUser'])){ echo $myplan['totalUser']; } 
									  ?></span>
                                    </div>
                                  </div> 
								  <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                    <div class="form-group">
                                      <label for="inputsm"><strong>User Limit</strong> </label>
                                      <span class="form-control input-sm" id="userlimit"  type="text" value="" disabled ><?php if(isset($myplan['user_limit'])){ echo $myplan['user_limit']; } ?></span>
                                    </div>
                                  </div>
                                </div>
									<div class="row" style="padding:10px;padding-top: 0px;">
										<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
											<div class="form-group">
											  <label for="inputsm"> <strong>Previous Dues</strong></label>
											  <span class="form-control input-sm " disabled ><?php if(isset($myplan['due_amount'])){ echo $myplan['due_amount']; } ?></span>
											</div>
										</div>
									</div>-->
									
<!------------------------------------------End Old Code------------------------------------------------->
                               </div>
                                <!------/existing plan------>
                         
						 
						 
                    <!------start btn------>
					<!--- <h4>Upgrade Your Plan</h4> --->
					<!--<h4><strong>Upgrade Plan</strong></h4>-->
					<!--<div  class="row">
					 <br/>
				
					
				     <div id="operation" class="col-sm-8 col-md-8 col-xs-8">
							<!--- <h5>I want to upgrade</h5>--->
							<!--<div class="radio">
								 <label><input type="radio" value="user_only" name="get_opr" checked>Update User Limit only</label>
							</div>
							<div class="radio">
								<label><input type="radio" value="duration_only" name="get_opr"  <?php echo($myplan['totalUser'] > $myplan['user_limit']) ? "disabled":  ""; ?>  >Renew only</label>
								 <span style="margin-left:2px;font-size:12px;color:orange" > <?php echo($myplan['totalUser'] < $myplan['user_limit']) ? "User limit should be greater than or equal to the registered users.": ""; ?>  </span>
							</div>
							<div class="radio">
								<label><input type="radio" value="duration_user" name="get_opr" >Renew & update User Limit</label>
							</div>
							<input type="button" value="Go" id="go" class="btn btn-warning" />
						</div>
					
					<div class="col-sm-4 col-md-4" id="iwant" style="display:none;">
							<div class="row container">
								<div class="col-md-4 col-lg-4 col-xl-4 col-sm-12 col-xs-12">
									<div class="form-group" style="margin-top: 15px;">
										<label for="inputsm">Plan Duration </label><br/>
										<div class="radio" style="display: inline;">
											<label>
											<input id="yearly" name="monthopt" type="radio" >Yearly&nbsp;&nbsp;</label>
										</div>
										<div class="radio" style="display: inline;">
											<label><input id="monthly" name="monthopt" type="radio" >Monthly&nbsp;&nbsp;</label>
										</div>
									</div>
								</div>
								<strong>
									&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:green;" id='dis'></span>
								</strong>					
							</div>
                  
                    <!------ end btn ------>	
					
                    <!--<div class="row">
                    
										<?php
										if(isset($myplan['user_limit']) && (($myplan['user_limit']-$myplan['totalUser'])<0)){
										$diff=$myplan['totalUser']-$myplan['user_limit'];
										
										}
										?>
                                 
                                  <div class="col-xs-6" id="nou">
                                    <div class="form-group"  style="margin-top: 15px;">
                                      <label for="inputsm">  Additional Users </label>
                                      <input title='Pleae enter the no. of additional users' type="number" min="0" class="form-control" value='0' id="noOfUser" name="noOfUser" placeholder="" required >
                                    </div>
                                  </div>
								    <div class="col-xs-6" id="noy">
                                    <div class="form-group" style="margin-top: 15px;">
										<label for="inputsm">No. of <span id="pln">years</span>s</label>
										 <input type="number" title="Please enter the no. of year(s) or month(s)" min="0" tooltip="You can't set your " class="form-control" id="duration" maxlength="250" value='0' name="duration" placeholder="" required>
                                    </div>
                                  </div>
					 
					 <span style="color:red" id='err'></span>
                    
					<div class="col-md-1 col-lg-1 col-xl-1 col-sm-12 col-xs-12" ></div>
					<div class="col-md-4 col-lg-4 col-xl-4 col-sm-12 col-xs-12" style="display:none" >
					
						<div  style="padding-left:0px;padding-right:0px;">
							<div class="panel panel-default">
								<div class="panel-heading" align="center">
									<h4  align="center">Price List</h4>
								</div>
								<div id="inrList">
								<table class="tab1">
									  <tr>
										<th><center>No. of Employees</center></th>
										<th><center>Price/month(INR)</center></th>
										<th><center>Price/year(INR)</center></th>
										<th><center>Group Attendance</center></th>
										<th><center>Location Tracking</center></th>
										<th><center>Visit Punch</center></th>
										<th><center>Geo Fence</center></th>
										<th><center>Hourly Pay</center></th>
										<th><center>Time Off</center></th>
									  </tr>
									  <?php 
									  $i=0;
										foreach($myplan['planinfo']['inr'] as $row){
											echo "<tr>
													<td><span>".$row['range']."</span></td>
													<td><span id='inrMonthly".$i."'>".$row['monthly']."</span></td>
													<td><span id='inrYearly".$i."'>".$row['yearly']."</span></td>
													<td><span id='inrbulk_attendance".$i."'>".$row['bulk_attendance']."</span></td>
													<td><span id='inrlocation_tracing".$i."'>".$row['location_tracing']."</span></td>
													<td><span id='inrvisit_punch".$i."'>".$row['visit_punch']."</span></td>
													<td><span id='inrgeo_fence".$i."'>".$row['geo_fence']."</span></td>
													<td><span id='inrpayroll".$i."'>".$row['payroll']."</span></td>
													<td><span id='inrtime_off".$i."'>".$row['time_off']."</span></td>
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
										<th><center>Price/month($)</center></th>
										<th><center>Price/year($)</center></th>
									  </tr>
									   <?php 
									   $i=0;
										foreach($myplan['planinfo']['usd'] as $row){
											echo "<tr>
													<td><span>".$row['range']."</span></td>
													<td><span id='usdMonthly".$i."'>".$row['monthly']."</span></td>
													<td><span id='usdYearly".$i."'>".$row['yearly']."</span></td>
													<td><span id='usdbulk_attendance".$i."'>".$row['bulk_attendance']."</span></td>
													<td><span id='usdlocation_tracing".$i."'>".$row['location_tracing']."</span></td>
													<td><span id='usdvisit_punch".$i."'>".$row['visit_punch']."</span></td>
													<td><span id='usdgeo_fence".$i."'>".$row['geo_fence']."</span></td>
													<td><span id='usdpayroll".$i."'>".$row['payroll']."</span></td>
													<td><span id='usdtime_off".$i."'>".$row['time_off']."</span></td>
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

                    <button type="button" class="btn btn-success" id="continue2"  data-toggle="dropdown" aria-expanded="false">Continue</button>
                  </div>
				  
				  
				  
				  
			      </div>-->
				  <!---------end upgrade plan----------->
				  
				  
				</div>  
			</div>  
				           <!---- select palan close---- ---->
				          
						  
						  
						  
						  
	   <!-------Addons tab start--------->
                <div class="accordion_main">
                    <div class="accordion_head">Add-ons Details<button id="edit6" type="button" class="btn editbutton"><i  class="fa fa-pencil " style="font-size:12px;margin-top:0px;top:0px;"></i> Edit</button></div>
					
                    <div class="accordion_body6" style="display: none;">
                    <div class="row"  ><!--id="TotalUsd"-->
					
                    <div class="col-md-8" >
		
				  <table class="table table-responsive" style="width:80%" id="ordertable">
					<!---<h5 align="center"><strong>Addons</strong></h5>--->
					
					<tr>
                    <th width="50%" align="left">Add-ons </th>
                    <th width="25%" style="text-align: right;">Amount</th>
                    <th width="20%" style="text-align: right;">Select</th>
                    </tr>
				  
					
					<tr>
                    <td width="50%" align="left" id="bulkatt_perprice">Group Attendance@Rs. 2.00/month</td>
                    <td width="25%" align="right"><span id="bulk_attprice"></span></td>
                    <td width="20%" align="right"><input onclick="Add_addonsprice()" type='checkbox' name="bulk_attcheck" id="bulk_attcheck" <?php if($myplan['Addon_BulkAttnP']==1) echo "checked "; ?>  /></td>
                    </tr>
					<!--
					<tr>
                    <td width="50%" align="left" id="loctrace_perprice">Location Tracing</td>
                    <td width="25%" align="right"><span id="location_traceprice"></span></td>
                    <td width="20%" align="right"><input  onclick="Add_addonsprice()" type='checkbox'  name="location_tracecheck" id="location_tracecheck" <?php if($myplan['Addon_LocationTrackingP']==1) echo "checked "; ?>  /></td>
                    </tr>  -->
					
					<tr>
                    <td width="50%" align="left" id="visit_perprice">Visit Punch</td>
                    <td width="25%" align="right"><span id="visit_punchprice"></span></td>
                    <td width="20%" align="right"><input onclick="Add_addonsprice()" type='checkbox' name="visit_punchcheck" id="visit_punchcheck" <?php if($myplan['Addon_VisitPunchP']==1) echo "checked "; ?>  /></td>
                    </tr>
                   
				    <tr>
                    <td width="50%" align="left" id="gfence_perprice">Geo Fence</td>
                    <td width="25%" align="right"><span id="geo_fenceprice"></span></td>
                    <td width="20%" align="right"><input onclick="Add_addonsprice()" type='checkbox' name="geo_fencecheck" id="geo_fencecheck" <?php if($myplan['Addon_GeoFenceP']==1) echo "checked "; ?> /></td>
                    </tr>
					
				    <tr>
                    <td width="50%" align="left" id="payroll_perprice">Hourly Pay</td>
                    <td width="25%" align="right"><span id="payroll_price"></span></td>
                    <td width="20%" align="right"><input onclick="Add_addonsprice()" type='checkbox' name="payroll_check" id="payroll_check" <?php if($myplan['Addon_PayrollP']==1) echo "checked "; ?> /></td>
                    </tr>
					
                    <tr>
                    <td width="50%" align="left" id="timeoff_perprice">Time Off</td>
                    <td width="25%" align="right"><span id="timeoff_price"></span></td>
                    <td width="20%" align="right"><input onclick="Add_addonsprice()"  type='checkbox' name="timeoff_check" id="timeoff_check" <?php if($myplan['Addon_TimeOffP']==1) echo "checked "; ?>  /></td>
                    </tr>
					
					 <tr style="display:none">
					   <td><input type = "hidden" value="" id = "bulk_attprice1" /> </td>
					   <td><input type = "hidden" value="" id = "location_traceprice1" /> </td>
					   <td><input type = "hidden" value="" id = "visit_punchprice1" /> </td>
					   <td><input type = "hidden" value="" id = "geo_fenceprice1" /> </td>
					   <td><input type = "hidden" value="" id = "payroll_price1" /> </td>
					   <td><input type = "hidden" value="" id = "timeoff_price1" /> </td>
					 </tr>
                    </tbody>
                    </table>
					
					</div>
                 
					<div class="col-md-4" >
						<div class="card-header" style="margin-top:20px;background-color: #45a149;color:white;">
						    <span>Add-ons: <span id= "addonsprice" ></span> </span><br/>
						<!--	<span>Order Value: <span id="ocurr"></span><span id="cartval"></span></span> --->
						</div>
					</div>
                    <div class="col-md-1" ></div>
                    </div>
                    <button type="button" class="btn btn-success" id="continue6"  data-toggle="dropdown" aria-expanded="false">Continue</button>
                    </div>
                    </div>
	 <!-------Addons tab close----------->
				
				
				      <!-----plan details tab open------>
                    <div class="accordion_main">
                    <div class="accordion_head">Order Details <button id="edit4" type="button" class="btn editbutton"><i  class="fa fa-pencil " style="font-size:12px;margin-top:0px;top:0px;"></i> Edit</button></div>
                    <div class="accordion_body4 " style="display: none;">
                    <div class="row"  ><!--id="TotalUsd"-->
                    <div class="col-md-2" ></div>
                    <div class="col-md-8">
                    <hr/> 
					
					<center>
                    <table class="table table-responsive"  id="ordertable">
					<h5 align="center"><strong>Order Summary</strong></h5>
					<hr/>
					<!--<tr class="addon">
						<td></td>
						<td></td>
						<td><strong>Dues</strong></td>
						<td></td>		
					</tr>
					<tr>
						<td><strong>Description</strong></td>
						<td><strong>Users Added</strong></td>
						<td><strong>Price/User<span id="_per" class="__per"></span></strong></td>
						<td><strong>Amount</strong></td>
                    </tr>
					<tr id="due_amount" >
					<td>Previous Dues for Additional Users</td>
					<td><span id="noOfUser_1" class="noOfUser_12"></span></td>
						<td><span id="rate" class="ratee"></span></td>
						<td>
						<span id="due_amount1">
						<?php if(isset($myplan['due_amount'])){ 
						echo $myplan['due_amount']; } ?>
						</span>
						</td>
                    </tr>-->
					
					<tr class="addon">
						<td><strong> Premium Plan</strong></td>
						<td width="20%"></td>
						<td></td>
						<td></td>		
					</tr>
					
					<tr>
						<td><strong>Description</strong></td>
						<td width="20%"><strong>No.of Users</strong></td>
						<td><strong>Rate</strong></td>
						<td align="right"><strong>Amount<span id='in_cur' class="cur_in"></span></strong></td>
                    </tr>
					
					
					
					<tr class="ud do">
                    <td>Renew Premium Subscription for <span class="" id="duration_1"  type="text" value="duration_1" name="duration_1" disabled></span></td>
                    <td width="20%"><span id="noOfUser_1" class="noOfUser_12"></span></td>
						<td><span id="rate" class="ratee"></span></td>
						<td align="right"><span class="newplan" ></span></td>
                    </tr>
					
					<!--<tr>
						<td></td>
						<td width="24%"><strong>Additional Users</strong</td>
						<td></td>
						<td></td>
					</tr>-->
					
					<!--<tr>
						<td>Previous User limit</td>
						<td></td>
						<td></td>
						<td><span id="noOfUser_e"></span></td>
					</tr>
						
						<tr >
						<td>Revised User limit</td>
						<td></td>
						<td></td>
						<td><span class=""></span><span id="noOfUser_n"></span></td>
						</tr>-->
					
					<!--<tr>
						<td >Users added </td>
						<td></td>
						<td></td>
						<td><span class=""></span><span id="noOfUser_1"></span></td>
                    </tr>-->
					<span id="remaining_days"  hidden><?php echo $myplan['days'];?></span>
					<!--<tr>
						<td></td>
						<td></td>
						<td></td>
						<td><span class=""></span><span id="remaining_days" hidden><?php echo $myplan['days'];?></span></td>                              
                    </tr>-->
					
					<!--<tr>
						<td>Price/User<span id="_per"></span></td>
						<td></td>
						<td></td>
						<td><span id="rate">0</span></td>
                    </tr>-->
					
					<!--- <tr>
                    <td width="24%" align="left">Price/User/Day</td>
                    <td width="1%"></td>
                    <td width="20%" align="right"><span class=""></span><span id="rateindays">0</span></td>
                    </tr> ---->
					
					<tr class="au">
						<td>Additional Users for <?php echo $myplan['days'];?> days</td>
						<td width="20%"><span id="noOfUser_1" class="noOfUser_12"></span></td>
						<td><span id="rate" class="ratee"></span></td>
						<td align="right"><span id="AttendnaceAmount" class="adduser"></span></td>
                    </tr>
					
					
					
					
					
				<tr class="addon">
				<td><strong>Add-ons</strong></td>
				<td></td>
				<td></td>
				<td></td>		
				</tr>
				<tr>
					<td><strong>Description</strong></td>
					<td width="20%"><strong>No.of Users</strong></td>
					<td><strong>Rate</strong></td>
					<!--<td><strong>Remaining Plan days</strong></td>-->
					<td align="right"><strong>Amount<span id='in_cur' class="cur_in"></span></strong></td>
                </tr>
				
					<tr class="" style="display:none" id="S_bulkatttendance1" >
						<td>Group Attendance </td>
						<td width="20%"><span id="noOfUser_1" class="noOfUser_12"></span></td>
						<td><span id="bulkaddonamount" ></span></td>
						<!--<td><span id="remaining_days"><?php echo $myplan['days'];?></span></td>-->
						<td align="right" ><span id="S_bulkatttendance">0</span></td>
                    </tr>
					
					<tr class="" id="S_visitpunch1" style="display:none" >
						<td>Visit Punch </td>
						<td width="20%"><span id="noOfUser_1" class="noOfUser_12"></span></td>
						<td><span id="visitpunchaddonamount" ></span></td>
						<td align="right"><span class=""></span><span id="S_visitpunch">0</span></td>
                    </tr>
					
					<tr class="" id="S_geofence1" style="display:none">
						<td>Geo Fence </td>
						<td width="20%"><span id="noOfUser_1" class="noOfUser_12"></span></td>
						<td><span id="geofenceaddonamount" ></span></td>
						<td align="right"><span class=""></span><span id="S_geofence">0</span></td>
                    </tr>
					
					<tr class="" style="display:none" id="S_payroll1" >
						<td>Hourly Pay</td>
						<td width="20%"><span id="noOfUser_1" class="noOfUser_12"></span></td>
						<td><span id="payrolladdonamount" ></span></td>
						<td align="right"><span class=""></span><span id="S_payroll">0</span></td>
                    </tr>
					
					<tr class="" style="display:none" id="S_timeoff1" >
						<td>Time Off </td>
						<td width="20%"><span id="noOfUser_1" class="noOfUser_12"></span></td>
						<td><span id="timeoffaddonamount"></span></td>
						<td align="right"><span class=""></span><span id="S_timeoff">0</span></td>
                    </tr>
					
					<tr class="" style="display:none" id="S_locationtracing1">
						<td>Location Tracking</td>
						<td width="20%"><span id="noOfUser_1" class="noOfUser_12"></span></td>
						<td><span id="locationaddonamount" ></span></td>
						<td align="right"><span class=""></span><span id="S_locationtracing">0</span></td>
                    </tr>
					
					
					<!--<tr class="uo ud">
						<td width="1%" align="left"></td>
						<td width="24%"><strong>ubiAttendance Premium Plan</strong></td>
						<td width="1%" align="right"></td>
                    </tr>-->
					
					<!--<tr>
					<td><strong>Description</strong></td>
					<td><strong>Users Added</strong></td>
					<td><strong>Price/User<span id="_per" class="__per"></span></strong></td>
					<td><strong>Amount</strong></td>
                   </tr>-->
				   
				   <tr class="addon">
					<td><strong> Amount Payable</strong></td>
					<td></td>
					<td></td>
					<td></td>
                   </tr>
				   
				   
				   
				   
					<!--<tr>
						<td></td>
						<td></td>
						<td><strong>Add-ons Total</strong></td>
						<td><span id="addonsprice" class="addonspricefororder"></span>
						</td>
                    </tr>-->
					
				   
				 <tr  class="uo ud">
						<td></td>
						<td></td>
						<td><strong>Total Amount</strong></td>
						<td align="right"><span class=""></span><span id="amount1">0</span>
						</td>
                    </tr>
					<tr  class="uo ud">
						<td></td>
						<td></td>
						<td><strong> Previous Dues</strong></td>
						<td align="right"><span id="due_amount1">
						<?php if(isset($myplan['due_amount'])){ 
						echo $myplan['due_amount']; } ?>
						</span>
						</td>
                    </tr>
					<!--<tr  class="uo ud">
						<td>Amount for additional users</td>
						<td><span id="noOfUser_1" class="noOfUser_12"></span></td>
						<td><span id="rate" class="ratee"></span></td>
						<td><span class=""></span><span id="amount1">0</span>
						</td>
                    </tr>-->
                   
				    <tr class="ud do">
					<td></td>
					<td></td>
					<td><span id='txt_ep'>Renewal Amount</span></td>
					<td align="right"><span class=""></span><span id="amount_cp">0</span></td>
                    </tr>
				   
				    <tr class=" ud">
					<td></td>
					<td></td>
					<td><span style="color:#b6b6b6">Sub Total</span></td>
					<td align="right"><span id="amount_st" style="color:#b6b6b6">0</span></td>
                    </tr>
					<!--amount_st-->
				    <tr id="disrow">
					<td></td>
					<td></td>
                    <td>Discount<span id="discount" style="display:none"></span></td>
                    <td align="right"><span class=""></span><span id="discount_amt">0</span></td>
                    </tr>
					
				    <tr>
						<td></td>
						<td></td>
						<td><strong>Tax Amount</strong><span id='tax_1' style="display:none"></span></td>
						<td align="right"><span class=""></span><span id="tax">0</span></td>
                    </tr>
					
				    <tr>
						<td></td>
						<td></td>
						<td><b>Total payable Amount<span id='in_cur' class="cur_in"></span></b></td>
						<td align="right"><span class=""><b></span><span id="totalshow">0</span><span id="total" hidden>0</span></b></td>
                    </tr>
					
                    </tbody>
                    </table>
					</center>
                    </div>
                    <div class="col-md-1"></div>
                    </div>
                    <button type="button" class="btn btn-success" id="continue3"  data-toggle="dropdown" aria-expanded="false">Continue</button>
                    </div>
                    </div>
					
					<!--palan tab details close--   -->
					
					
					
					
					
					
					
                    <div class="accordion_main">
                    <div class="accordion_head">Billing Details</div>
                    <div class="accordion_body5 section_position" style="display:none;">
                    
					<?php if($myplan['my_country']==93){?>
					<!------------PayUMoney for start------------>
					<div id="forPayUMoney">
                    <div class="row" id="payumoney" align="center">
              
					<form action="<?php echo $action; ?>" method="post" name="payuForm">
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
                    <input type="radio" name="gstno" checked id="descripcion" style="height:18px; width:18px; vertical-align: middle;margin-top:30px;" >
                    </span>
                    <input type="text"  id="gstin" class="form-control descrip" name="gstin" value=''  placeholder="GST No." />
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
					
					<input type="hidden" name="bulk_attpriceP" id="bulk_attprice_pum" value="" />
					<input type="hidden" name="location_tracepriceP" id="location_traceprice_pum" value="" />
					<input type="hidden" name="visit_punchpriceP" id="visit_punchprice_pum" value="" />
					<input type="hidden" name="geo_fencepriceP" id="geo_fenceprice_pum" value="" />
					<input type="hidden" name="payroll_priceP" id="payroll_price_pum" value="" />
					<input type="hidden" name="timeoff_priceP" id="timeoff_price_pum" value="" />
					
					<input type="hidden" name="stsbulk_attendance" id="stsbulk_attendance" value=""/>
					<input type="hidden" name="stsvisit_punch" id="stsvisit_punch" value=""/>
					<input type="hidden" name="stsloc_trace" id="stsloc_trace" value=""/>
					<input type="hidden" name="stsgeo_fence" id="stsgeo_fence" value=""/>
					<input type="hidden" name="stspayroll" id="stspayroll" value=""/>
					<input type="hidden" name="ststimeoff" id="ststimeoff" value=""/>
					<input type="hidden" name="dueamount" id="dueamount" value="<?php echo$myplan['due_amount']; ?>" />
					
					
					
					<input type="hidden" name="amount" id="amount_pum" value="<?php echo (empty($posted['amount'])) ? '' : $posted['amount'] ?>"/>
					<input type="hidden" name="firstname" id="firstname_pum" value="<?php echo $_SESSION['name']; ?>" />
					<input type="hidden" name="email" id="email_pum" value="<?php echo $_SESSION['Email']; ?>" />
					<input type="hidden" name="phone" id="phone_pum" value="<?php echo (empty($posted['phone'])) ? '' : $posted['phone'] ?>"/>
					
					
					<textarea style="display:none" name="productinfo"><?php echo (empty($posted['productinfo'])) ? 'data one' : $posted['productinfo'] ?></textarea>
					<input type="hidden" name="surl" value="<?php echo URL.'myplan/success_payUMoney'; ?>" size="64" />
					<input type="hidden" name="furl" value="<?php echo URL.'myplan/failed_upgrade'; ?>" size="64" />
					<input type="hidden" name="service_provider" value="payu_paisa" size="64" />
							
                    <div class="panel-footer">
						<?php if(!$hash){ ?>
							<input class="btn btn-success" id="payUMoney_button" onclick="return checkBillingForm();" type="submit" value="Submit" />
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
					<div id="forPayPal">
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
                    <input type="number" id="contact" min="100000" max='999999999999999' class="form-control"  name="contact" placeholder="Phone No." value=""/>
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
                    <div id="statediv" class="col-lg-4 col-sm-12 col-md-6 col-xs-12 ind_only">
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
						<div id="gstdiv" class="ind_only" >
							<div class="col-sm-6 col-md-3 col-xs-6 col-lg-3" >
								<div class="input-group">
									<span class="input-group-btn">
									<input type="radio" name="gstno" checked id="descripcion" style="height:18px; width:18px; vertical-align: middle;margin-top:30px;" checked>
									</span>
									<input type="text" id="gstin" class="form-control descrip" name="gstin" value=''  placeholder="GST No." />
								</div>
							</div>
							<div class="col-sm-6 col-lg-3 col-xs-6 col-md-3">
								<input type="radio"  name="gstno" id="1step" value="not applicable" style="height:18px; width:18px;margin-top:40px;">&nbsp;<span style="font-size:15px;">Not applicable</span>
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
						<input type="hidden" name="cancel_return" value="<?=URL?>Myplan/failed_upgrade"/>
						<input type="hidden" name="return" id="success" value="<?=URL?>Myplan/UpgradePlan_Successpaypal"/> 
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
					</div>
                    <!-- This form for paypal(end) -->
					<?php } ?>
                    </div>	
					
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
										//$('#in_cur').text(' (USD) ');
										$('.cur_in').text(' (USD) ');
										tax=0;
									}else{
										currency='INR';
										$('#currency_code').val('INR');
										$('#usdList').hide();
										$('#inrList').show();
										//$('#in_cur').text(' (INR) ');
										$('.cur_in').text(' (INR) ');
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
								if(currency=='USD' && $('#dis_usd_year').val()!=0)
								{
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
								//$('.planduration').hide();
								
								var opr=$('input[name=get_opr]:checked').val();
								if(opr=='user_only'){
									action="UO";
									$('#noy').hide();
									$('#nou').show();
									$('.planduration').hide();
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
				//$('#nofuser_pum').val(parseInt($('#noOfUser_1').text()));
				$('#nofuser_pum').val(parseInt($('.noOfUser_12').text()));
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
			//alert(duration);
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
  
  
  <script>
  function AddonsPrice()
  {
	  $('#bulk_attprice1').val($('#bulk_attprice').text());
	  $('#location_traceprice1').val($('#location_traceprice').text());
	  $('#visit_punchprice1').val($('#visit_punchprice').text());
	  $('#geo_fenceprice1').val($('#geo_fenceprice').text());
	  $('#payroll_price1').val($('#payroll_price').text());
	  $('#timeoff_price1').val($('#timeoff_price').text());
	  Add_addonsprice();
  }
   var addondpricetemp = 0;
   
  function Add_addonsprice()
  {
	   addondpricetemp = 0;
	    if($('#bulk_attcheck'). prop("checked") == true)
		{
             addondpricetemp = addondpricetemp + parseFloat($('#bulk_attprice1').val());
			 $("#S_bulkatttendance1").show();
			 $("#S_bulkatttendance").text($('#bulk_attprice1').val());
         }
		 else
		 {
			  $("#S_bulkatttendance1").hide();
			   $("#S_bulkatttendance").text('0');
		 }
		 
	    if($('#location_tracecheck'). prop("checked") == true){
             addondpricetemp = addondpricetemp + parseFloat($('#location_traceprice1').val());
			  $("#S_locationtracing1").show();
			  $("#S_locationtracing").text($('#location_traceprice1').val());
         }
		 else
		 {
			  $("#S_locationtracing1").hide();
			  $("#S_locationtracing").text('0');
		 }
		 
		 if($('#visit_punchcheck'). prop("checked") == true){
             addondpricetemp = addondpricetemp + parseFloat($('#visit_punchprice1').val());
			 $("#S_visitpunch1").show();
			 $("#S_visitpunch").text($('#visit_punchprice1').val());
			 
          }
		  else
		 {
			  $("#S_visitpunch1").hide();
			  $("#S_visitpunch").text('0');
		 }
		
		 if($('#geo_fencecheck'). prop("checked") == true)
		 {
             addondpricetemp = addondpricetemp + parseFloat($('#geo_fenceprice1').val());
			 $("#S_geofence1").show();
			 $("#S_geofence").text($('#geo_fenceprice1').val());
         }
		 else
		 {
			  $("#S_geofence1").hide();
			  $("#S_geofence").text('0');
		 }
		  if($('#payroll_check'). prop("checked") == true)
		 {
             addondpricetemp = addondpricetemp + parseFloat($('#payroll_price1').val());
			 $("#S_payroll1").show();
			 $("#S_payroll").text($('#payroll_price1').val());
         }
		 else
		 {
			  $("#S_payroll1").hide();
			  $("#S_payroll").text('0');
		 }
		  if($('#timeoff_check'). prop("checked") == true)
		 {
             addondpricetemp = addondpricetemp + parseFloat($('#timeoff_price1').val());
            $("#S_timeoff1").show();
            $("#S_timeoff").text($('#timeoff_price1').val());
		}
		 else
		 {
			  $("#S_timeoff1").hide();
			  $("#S_timeoff1").text('0.00');
		 }
		 $("#addonsprice").text(addondpricetemp.toFixed(2));
		//alert(addondpricetemp);
  }
  
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
                $(".accordion_body1").slideUp(300);
                $(".accordion_body2").slideDown(300);
        }); 
    	
		if($('#currency').val() == ""){
    		  	alert("Please select currency");
    			return false;
    		}
    		$('#yearly').click();    		
			if(currency=='USD' && $('#dis_usd_year').val()!=0)
				$("#dis").text('Buy yearly ubiAttendance plan and  get '+$('#dis_usd_year').val()+'% Instant discount on billing amount.');
			else if(currency=='INR' && $('#dis_inr_year').val()!=0)
				$("#dis").text('Buy yearly ubiAttendance plan and  get '+$('#dis_inr_year').val()+'% Instant discount on billing amount.');
    			
				
				
    		currency=$('#currency').val();
    		$(".accordion_body2").slideUp(300);
            $(".accordion_body3").slideDown(300);  // open first tab bydefault
			$("#edit2").show();
		
    	$("#continue").click(function(){
    					
    		if($('#currency').val() == ""){
    		  	alert("Please select currency");
    			return false;
    		}
    		$('#yearly').click();    		
			if(currency=='USD' && $('#dis_usd_year').val()!=0)
				$("#dis").text('Buy yearly ubiAttendance plan and  get '+$('#dis_usd_year').val()+'% Instant discount on billing amount.');
			else if(currency=='INR' && $('#dis_inr_year').val()!=0)
				$("#dis").text('Buy yearly ubiAttendance plan and  get '+$('#dis_inr_year').val()+'% Instant discount on billing amount.');
    			
    		currency=$('#currency').val();
    		$(".accordion_body2").slideUp(300);
            $(".accordion_body3").slideDown(300);
			$("#edit2").show();
    	});
		
    var price=0;
	var total=0;
    var startdate="";
    var lastdate="";
	var no_of_users="";
	var tax=0;
	var discount=0;
	var duration=0;
    var users=0;
    var userlimit=0;
   
	$("#continue6").click(function(){
		
		 duration 	= 	Number($("#duration").val());
		users		= 	Number($("#noOfUser").val());
		userlimit 	= 	Number($("#userlimit").text());
		
		var amount	=	0;
		var tax_per	=	0;
		plan  = plan1;
		if(plan=='YEARLY')
		{
				$("#duration_1").text(duration + ' Year(s)');
		}
			else
			{
				$("#duration_1").text(duration + ' Month(s)');
				
			}
		//$("#noOfUser_1").text($("#noOfUser").val());
		$(".noOfUser_12").text($("#noOfUser").val());
		
		//if(duration==0 && users>userlimit){
		if(action=="UO"){
			if(users<1)
			{
				$('#err').text('Please upgrade the user limit');
				$("#noOfUser").focus();
				return false;
		    } 
			$(".ud").hide();
			$(".do").hide();			// update the user limit only
			$(".uo").show();
			action='UO'; 								// update user limit only
			//alert('update the user limit only');
			
			$("#noOfUser_e").text(userlimit);			// user limit existing
			$("#noOfUser_n").text(users + userlimit); 				// user limit new
			//$("#noOfUser_1").text(users); 	// user lim updated by(users)
			$(".noOfUser_12").text(users); 	// user lim updated by(users)
			var remaining_days=Number($("#remaining_days").text()); 	// user lim updated by(users)
		
			var x=users+userlimit;
			//alert('user: '+x);
			no_of_users=users;
			//var element='';
			
			var element='';
			var bulkattendance = "";
			var locationtracing = "";
			var visitpunch = "";
			var geofence = "";
			var payroll = "";
			var timeoff = "";
			
			
			if(remaining_days>364)
				 plan='YEARLY';
			else 
				plan='MONTHLY';
			
			if(plan=='YEARLY' && currency=="USD"){
				element='usdYearly';
				$('#discount').text($('#dis_usd_year').val());
			}
			else if(plan=='MONTHLY' && currency=="USD")
			{
				element='usdMonthly';
				$('#discount').text($('#dis_usd_month').val());
			}
			else if(plan=='YEARLY' && currency=="INR")
			{
				element='inrYearly';
				$('#discount').text($('#dis_inr_year').val());
			}
			else if(plan=='MONTHLY' && currency=="INR")
			{
				element='inrMonthly';
				$('#discount').text($('#dis_inr_month').val());
			}
			
		var tempcurrency = "";
			if(currency=="INR")
			{
				 bulkattendance = "inrbulk_attendance";
				 locationtracing = "inrlocation_tracing";
				 visitpunch = "inrvisit_punch";
				 geofence = "inrgeo_fence";
				 payroll = "inrpayroll";
				 timeoff = "inrtime_off";
				 tempcurrency = "Rs";
			}
			else if(currency=="USD")
			{
				 bulkattendance = "usdbulk_attendance";
				 locationtracing = "usdlocation_tracing";
				 visitpunch = "usdvisit_punch";
				 geofence = "usdgeo_fence";
				 payroll = "usdpayroll";
				 timeoff = "usdtime_off";
				 tempcurrency = "USD";
			}
			var tempvar = "";	
			
			
			
			
			
			
			
			
			
		   switch (true) {
                 case (x  >= 1 && x <= 20):
					$('.ratee').text($('#'+element+'0').text());
					tempvar = 0;
                 break;
                 case (x  >= 21 && x <= 40):
					$('.ratee').text($('#'+element+'1').text());
					tempvar = 1;
                 break;
                 case (x  >= 41 && x <= 60):
					$('.ratee').text($('#'+element+'2').text());
					tempvar = 2;
                 break;
				 case (x  >= 61 && x <= 80):
					$('.ratee').text($('#'+element+'3').text());
					tempvar = 3;
                 break;
				 case (x  >= 81 && x <= 100):
					$('.ratee').text($('#'+element+'4').text());
					tempvar = 4;
                 break;
				 case (x  >= 101 && x <= 120):
					$('.ratee').text($('#'+element+'5').text());
					tempvar = 5;
                 break;
				 case (x  >= 120):
					$('.ratee').text($('#'+element+'6').text());
					tempvar = 6;
                 break;
                 default:
                 break;
              }
			  
			  
			  $('#bulkaddonamount').text($('#'+bulkattendance+tempvar).text());
			  $('#locationaddonamount').text($('#'+locationtracing+tempvar).text());
			  $('#visitpunchaddonamount').text($('#'+visitpunch+tempvar).text());
			  $('#geofenceaddonamount').text($('#'+geofence+tempvar).text());
			  $('#payrolladdonamount').text($('#'+payroll+tempvar).text());
			  $('#timeoffaddonamount').text($('#'+timeoff+tempvar).text());
			 
			  
			   AddonsPrice();
			
			  $(".addonspricefororder").text(addondpricetemp.toFixed(2)); 
			 // alert(addondpricetemp.toFixed(2));
			  
			 
			 if(plan=='YEARLY')
			 {
			    amount = Math.round(no_of_users * (($('#rate').text())/365) * remaining_days);
				$('#rateindays').text(($('#rate').text())+'/365');
			 }
			else{
				amount = Math.round(no_of_users * (($('#rate').text())/30.42) * remaining_days);
				$('#rateindays').text(($('#rate').text())+'/30.5');
				//alert(($('#rate').text())+'/30.5');
			}
			    $("#AttendnaceAmount").text(Number(amount).toFixed(2));
				
				amount = (amount+addondpricetemp+ Number(due_amount)).toFixed(2);
				$('#txt_ep').text("Amount");
				$('#amount1').text(amount);
				discount=Math.round((Number(amount) * Number($('#discount').text())) /100);
				$('#discount_amt').text(discount);
				
				if(discount<1){
					$("#disrow").css("display", "none");
					
				}
				else
				{
					$("#disrow").css("display", "block");
				}
				tax=0;
				
				if(currency=='INR')	{
					tax=Math.round(((amount-discount)*18)/100);
					tax_per=18.00;
					$('#tax_1').text(' ('+tax_per+'%) ');
					$('#tax_1').show();
				}
				$('#tax').text(Number(tax).toFixed(2));
				//$('#_per').text((('/'+plan).toLowerCase()).replace('ly', ''));
				$('.__per').text((('/'+plan).toLowerCase()).replace('ly', ''));
				total=(amount-discount)+tax;
				$('#total').text(total);
				$('#totalshow').text(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
			//alert('total: '+total);
		}
		//else if(duration!=0 && users==userlimit){ 	// update the subs period only
		if(action=="DO")
		{ 					// update the subs period only
			if(duration<1)
			{
				$('#err').text('Please upgrade the Duration');
				$("#duration").focus();
				return false;
			} 	
		
			$(".ud").hide();
			$(".uo").hide();
			$(".do").show();
			$(".au").hide();
			
			
			//alert(userlimit);
			action='DO'; // update subscription duration only
		//	alert('update the subs period only');
		  var remaining_days=Number($("#remaining_days").text());
		   //alert("remaining_days :"+remaining_days);
		   var extendday = 0;
		   if(plan=='YEARLY')
		      extendday =  $("#duration").val()*365;
		   else
			   extendday =  $("#duration").val()*30.42;
		  
		    if((remaining_days+extendday)>364)
				plan='YEARLY';
			else 
				plan='MONTHLY';
		
		
			var x=userlimit;
			//alert('user: '+x);
			no_of_users=x;
			var element='';
			var bulkattendance = "";
			var locationtracing = "";
			var visitpunch = "";
			var geofence = "";
			var payroll = "";
			var timeoff = "";
			if(plan=='YEARLY' && currency=="USD"){
				element='usdYearly';
				$('#discount').text($('#dis_usd_year').val());
			}
			else if(plan=='MONTHLY' && currency=="USD")
			{
				element='usdMonthly';
				$('#discount').text($('#dis_usd_month').val());
			}
			else if(plan=='YEARLY' && currency=="INR")
			{
				element='inrYearly';
				$('#discount').text($('#dis_inr_year').val());
			}
			else if(plan=='MONTHLY' && currency=="INR")
			{
				element='inrMonthly';
				$('#discount').text($('#dis_inr_month').val());
			}
			
			var tempcurrency = "";
			if(currency=="INR")
			{
				 bulkattendance = "inrbulk_attendance";
				 locationtracing = "inrlocation_tracing";
				 visitpunch = "inrvisit_punch";
				 geofence = "inrgeo_fence";
				 payroll = "inrpayroll";
				 timeoff = "inrtime_off";
				 tempcurrency = "Rs";
			}
			else if(currency=="USD")
			{
				 bulkattendance = "usdbulk_attendance";
				 locationtracing = "usdlocation_tracing";
				 visitpunch = "usdvisit_punch";
				 geofence = "usdgeo_fence";
				 payroll = "usdpayroll";
				 timeoff = "usdtime_off";
				 tempcurrency = "USD";
			}
			var tempvar = "";
			
			
		   switch (true) {
                 case (x  >= 1 && x <= 20):
					$('.ratee').text($('#'+element+'0').text());
					tempvar = 0;
                 break;
                 case (x  >= 21 && x <= 40):
					$('.ratee').text($('#'+element+'1').text());
					tempvar = 1;
                 break;
                 case (x  >= 41 && x <= 60):
					$('.ratee').text($('#'+element+'2').text());
					tempvar = 2;
                 break;
				 case (x  >= 61 && x <= 80):
					$('.ratee').text($('#'+element+'3').text());
					tempvar = 3;
                 break;
				 case (x  >= 81 && x <= 100):
					$('.ratee').text($('#'+element+'4').text());
					tempvar = 4;
                 break; 
				 case (x  >= 101 && x <= 120):
					$('.ratee').text($('#'+element+'5').text());
					tempvar = 5;
                 break;
				 case (x  >= 120 ):
					$('.ratee').text($('#'+element+'6').text());
					tempvar = 6;
                 break;
                 default:
                 break;
              }
			  
			        AddonsPrice();
					
				$('#bulkaddonamount').text($('#'+bulkattendance+tempvar).text());
			  $('#locationaddonamount').text($('#'+locationtracing+tempvar).text());
			  $('#visitpunchaddonamount').text($('#'+visitpunch+tempvar).text());
			  $('#geofenceaddonamount').text($('#'+geofence+tempvar).text());
			  $('#payrolladdonamount').text($('#'+payroll+tempvar).text());
			  $('#timeoffaddonamount').text($('#'+timeoff+tempvar).text());	
					
					
					
				if(plan=='YEARLY'){
					$('#rateindays').text((($('#rate').text())/365));
				}else{
					$('#rateindays').text((($('#rate').text())/30.42));
				}
				
				price = x * ($('#rate').text());
			
				amount= price*($("#duration").val());
				
			 //$("#AttendnaceAmount").text(Number(amount).toFixed(2));
				 $(".newplan").text(Number(amount).toFixed(2));
				amount = (addondpricetemp+amount+Number(due_amount)).toFixed(2);
				$('#txt_ep').text("Amount");
				$('#amount_cp').text(amount);
				discount=(Number(amount) * Number($('#discount').text())) /100;
				$('#discount_amt').text(discount);
				if(discount<1)
				{
					$("#disrow").css("display", "none");
				}
				else
				{
					$("#disrow").css("display", "block");
				}
				tax=0;
				$("#noOfUser_e").text(userlimit);			// user limit existing
				if(currency=='INR')	{
					tax=Math.round(((amount-discount)*18)/100);
					tax_per=18.00;
					$('#tax_1').text(' ('+tax_per+'%) ');
					$('#tax_1').show();
				}
				$('#tax').text(Number(tax).toFixed(2));
			//	$('#_per').text((('/'+plan).toLowerCase()).replace('ly', ''));
				$('.__per').text((('/'+plan).toLowerCase()).replace('ly', ''));
				total=(amount-discount)+tax;
				$('#total').text(total);
				$('#totalshow').text(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
			////////////end update subs period

		}
		//else {		//if(duration!=0 && users>userlimit)	// update the subs and user limit both
		else if(action=="UD"){ 		// update the subs and user limit both
			if(duration<1){
				$('#err').text('Please upgrade the Duration');
				$("#duration").focus();
				return false;
			}else if(users<1){
				$('#err').text('You should add at least 1 user to proceed further.');
				$("#noOfUser").focus();
				return false;
			} 
			action='UD'; // update User limit and subscription duration both
			$(".uo").hide();
			$(".do").hide();
			$(".ud").show();
			//$(".au").hide();
			$("#noOfUser_e").text(userlimit);			// user limit existing
			$("#noOfUser_n").text(users + userlimit); 				// user limit new
			//$("#noOfUser_1").text(users); 	// user lim updated by(users)
			$(".noOfUser_12").text(users); 	// user lim updated by(users)
			var remaining_days=$("#remaining_days").text(); 	// user lim updated by(users)
			var x=users+userlimit;
			no_of_users=users;
			var element='';
			var bulkattendance = "";
			var locationtracing = "";
			var visitpunch = "";
			var geofence = "";
			var payroll = "";
			var timeoff = "";
			
			var temp_plan=plan;
			if(remaining_days>364)
			plan='YEARLY';
		
			if(plan=='YEARLY' && currency=="USD"){
				element='usdYearly';
				$('#discount').text($('#dis_usd_year').val());
			}
			else if(plan=='MONTHLY' && currency=="USD"){
				element='usdMonthly';
				$('#discount').text($('#dis_usd_month').val());
			}
			else if(plan=='YEARLY' && currency=="INR"){
				element='inrYearly';
				$('#discount').text($('#dis_inr_year').val());
			}
			else if(plan=='MONTHLY' && currency=="INR"){
				element='inrMonthly';
				$('#discount').text($('#dis_inr_month').val());
			}
			
			
			var tempcurrency = "";
			if(currency=="INR")
			{
				 bulkattendance = "inrbulk_attendance";
				 locationtracing = "inrlocation_tracing";
				 visitpunch = "inrvisit_punch";
				 geofence = "inrgeo_fence";
				 payroll = "inrpayroll";
				 timeoff = "inrtime_off";
				 tempcurrency = "Rs";
			}
			else if(currency=="USD")
			{
				 bulkattendance = "usdbulk_attendance";
				 locationtracing = "usdlocation_tracing";
				 visitpunch = "usdvisit_punch";
				 geofence = "usdgeo_fence";
				 payroll = "usdpayroll";
				 timeoff = "usdtime_off";
				 tempcurrency = "USD";
			}
			var tempvar = "";
			
			
			
		   switch(true){
                 case (x  >= 1 && x <= 20):
					$('.ratee').text($('#'+element+'0').text());
					tempvar = 0;
                 break;
                 case (x  >= 21 && x <= 40):
					$('.ratee').text($('#'+element+'1').text());
					tempvar = 1;
                 break;
                 case (x  >= 41 && x <= 60):
					$('.ratee').text($('#'+element+'2').text());
					tempvar = 2;
                 break;
				 case (x  >= 61 && x <= 80):
					$('.ratee').text($('#'+element+'3').text());
					tempvar = 3;
                 break;
				 case (x  >= 81 && x <= 100):
					$('.ratee').text($('#'+element+'4').text());
					tempvar = 4;
                 break;
				 case (x  >= 101 && x <= 120):
					$('.ratee').text($('#'+element+'5').text());
					tempvar = 5;
                 break;
				 case (x  >= 120 ):
					$('.ratee').text($('#'+element+'6').text());
					tempvar = 6;
                 break;
                 default:
                 break;
              }
			  
			  
	////////////////////////////////////////////////////
	$('#bulkaddonamount').text($('#'+bulkattendance+tempvar).text());
			  $('#locationaddonamount').text($('#'+locationtracing+tempvar).text());
			  $('#visitpunchaddonamount').text($('#'+visitpunch+tempvar).text());
			  $('#geofenceaddonamount').text($('#'+geofence+tempvar).text());
			  $('#payrolladdonamount').text($('#'+payroll+tempvar).text());
			  $('#timeoffaddonamount').text($('#'+timeoff+tempvar).text());
////////////////////////////////////////////////////////////////	
			  
			  
			  
			  
			  
			  
			  var amt_for_new_period=0;
			  
			  AddonsPrice();
		//	alert($('#'+bulkattendance+tempvar ).text());
			 if(plan=='YEARLY')
			 {
				$('#rateindays').text((($('#rate').text())+'/365'));
				amount =Math.round(no_of_users * (($('#rate').text())/365) * remaining_days);
				if(temp_plan=="YEARLY")// monthly or yearly cal for new period
					amt_for_new_period=Math.round((users+userlimit) * (($('#rate').text())) * duration);
				else{
					amt_for_new_period=Math.round((users+userlimit) * (($('#rate').text())) * duration/12); // duration is in year after updating 'plan' by 365 days factor
				}
			}
			else
			{
				$('#rateindays').text((($('#rate').text())+'/30.5'));
				amount = Math.round(no_of_users * (($('#rate').text())/30.42) * remaining_days);
				amt_for_new_period=Math.round((users+userlimit) * (($('#rate').text())) * duration);
				//alert(amount);
				//alert(no_of_users);
			}
			
				$('#txt_ep').text("Amount to be paid for Extended period"); 		// for existing plan
				//$('#amount1').text(amount.toFixed(2)); 	// for existing plan
				$('#amount1').text(Number(amount).toFixed(2));
				
				$('#amount_cp').text(amt_for_new_period); 		// for new period and for all users
				
				$('#amount_st').text(amount+amt_for_new_period+addondpricetemp); // sub total of new and existing plan
			//	alert(amount);
			//	alert(amt_for_new_period);
				$(".adduser").text(Number(amount).toFixed(2));
				$(".newplan").text(Number(amt_for_new_period).toFixed(2));
				// $("#AttendnaceAmount").text(Number(amount+amt_for_new_period).toFixed(2));
				 
				tamt = (amt_for_new_period+amount+addondpricetemp+Number(due_amount)).toFixed(2);
				discount=Math.round((Number(tamt) * Number($('#discount').text())) /100);
				$('#discount_amt').text(discount);
				if(discount<1){
					$("#disrow").css("display", "none");
				}else{
					$("#disrow").css("display", "block");
				}
				tax=0;
				if(currency=='INR'){
					tax=Math.round(((tamt-discount)*18)/100);
					tax_per=18.00;
					$('#tax_1').text(' ('+tax_per+'%) ');
					$('#tax_1').show();
				}
				$('#tax').text(Number(tax).toFixed(2));
				//$('#_per').text((('/'+plan).toLowerCase()).replace('ly', ''));
				$('.__per').text((('/'+plan).toLowerCase()).replace('ly', ''));
				total=(tamt-discount)+tax;
				$('#total').text(total);
				$('#totalshow').text(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
		}
		 
		  $("#edit6").show();
          $(".accordion_body6").slideUp(300);
          $(".accordion_body4").slideDown(300);
		
	});
	
    $("#continue2").click(function(){ 
	    $('#err').text('');
		duration 	= 	Number($("#duration").val());
		
		users		= 	Number($("#noOfUser").val());
		userlimit 	= 	Number($("#userlimit").text());
		var ragisteruser = <?php echo $myplan['totalUser'] ?>;
		
		var amount	=	0;
		var tax_per	=	0;

    // alert(users);
	
		/*if (plan=='YEARLY')
				$("#duration_1").text(duration + ' Year(s)');
			else
				$("#duration_1").text(duration + ' Month(s)');*/
		//$("#noOfUser_1").text($("#noOfUser").val());
		$(".noOfUser_12").text($("#noOfUser").val());
		
		 
		
			if(duration>10)
			{
				$('#err').text('No. of month not more than 10.Please go for yearly plan');
				$('#discount').focus();
				return false;
			}	
		//if(duration==0 && users>userlimit){
		if(action=="UO")
		{
			
			if(users<1)
			{
				$('#err').text('Please upgrade the user limit');
				$("#noOfUser").focus();
				return false;
			}
		
			if(ragisteruser > (Number(userlimit)+ Number(users)) )
		    {
			alert("The No. of Additional Users should be >= "+ (Number(ragisteruser) - Number(userlimit)));
		 return false;
		    }
			
			$(".ud").hide();
			$(".do").hide();			// update the user limit only
			$(".uo").show();
			action='UO'; 								// update user limit only
			//alert('update the user limit only');
			
			$("#noOfUser_e").text(userlimit);			// user limit existing
			$("#noOfUser_n").text(users + userlimit); 				// user limit new
			//$("#noOfUser_1").text(users); 	// user lim updated by(users)
			$(".noOfUser_12").text(users); 	// user lim updated by(users)
			var remaining_days=Number($("#remaining_days").text()); 	// user lim updated by(users)
		  
			var x=users+userlimit;
			
			no_of_users=users;
			
			var element='';
			var bulkattendance = "";
			var locationtracing = "";
			var visitpunch = "";
			var geofence = "";
			var payroll = "";
			var timeoff = "";
			
			
			if(remaining_days>364)
				plan='YEARLY';
			else 
				plan='MONTHLY';
			if(plan=='YEARLY' && currency=="USD"){
				element='usdYearly';
				$('#discount').text($('#dis_usd_year').val());
			}
			else if(plan=='MONTHLY' && currency=="USD")
			{
				element='usdMonthly';
				$('#discount').text($('#dis_usd_month').val());
			}
			else if(plan=='YEARLY' && currency=="INR")
			{
				element='inrYearly';
				$('#discount').text($('#dis_inr_year').val());
			}
			else if(plan=='MONTHLY' && currency=="INR")
			{
				element='inrMonthly';
				$('#discount').text($('#dis_inr_month').val());
			}
			var tempcurrency = "";
			if(currency=="INR")
			{
				 bulkattendance = "inrbulk_attendance";
				 locationtracing = "inrlocation_tracing";
				 visitpunch = "inrvisit_punch";
				 geofence = "inrgeo_fence";
				 payroll = "inrpayroll";
				 timeoff = "inrtime_off";
				 tempcurrency = "Rs";
			}
			else if(currency=="USD")
			{
				 bulkattendance = "usdbulk_attendance";
				 locationtracing = "usdlocation_tracing";
				 visitpunch = "usdvisit_punch";
				 geofence = "usdgeo_fence";
				 payroll = "usdpayroll";
				 timeoff = "usdtime_off";
				 tempcurrency = "USD";
			}
			var tempvar = "";
		   switch (true)
		   {
                 case (x  >= 1 && x <= 20):
					$('.ratee').text($('#'+element+'0').text());
					tempvar = 0;
                 break;
                 case (x  >= 21 && x <= 40):
					$('.ratee').text($('#'+element+'1').text());
					tempvar = 1;
                 break;
                 case (x  >= 41 && x <= 60):
					$('.ratee').text($('#'+element+'2').text());
					tempvar = 2;
                 break;
				 case (x  >= 61 && x <= 80):
					$('.ratee').text($('#'+element+'3').text());
					tempvar = 3;
                 break;
				 case (x  >= 81 && x <= 100):
					$('.ratee').text($('#'+element+'4').text());
					tempvar = 4;
                 break;
				 case (x  >= 101 && x <= 120):
					$('.ratee').text($('#'+element+'5').text());
					tempvar = 5;
                 break;
				 case (x  >= 120 ):
					$('.ratee').text($('#'+element+'6').text());
					tempvar = 6;
                 break;
                 default:
                 break;
              }
			  
			// alert($('#'+bulkattendance+tempvar ).text());
		      $('#bulkatt_perprice').text("Bulk Attendance @"+tempcurrency+". "+$('#'+bulkattendance+tempvar ).text()+"/month");
			 // alert($('#bulkatt_perprice').text("Bulk Attendance @"+tempcurrency+". "+$('#'+bulkattendance+tempvar ).text()+"/month"));
			  $('#loctrace_perprice').text("Location Tracing @"+tempcurrency+". "+$('#'+locationtracing+tempvar ).text()+"/month");
			  $('#visit_perprice').text("Visit Punch @"+tempcurrency+". "+$('#'+visitpunch+tempvar ).text()+"/month");
			  $('#gfence_perprice').text("Geo Fence @"+tempcurrency+". "+$('#'+geofence+tempvar ).text()+"/month");
			  $('#payroll_perprice').text("Hourly Pay @"+tempcurrency+". "+$('#'+payroll+tempvar ).text()+"/month");
			  $('#timeoff_perprice').text("Time Off @ "+tempcurrency+". "+$('#'+timeoff+tempvar ).text()+"/month");
			  
			  
			  // calculate price 
			  <?php if($myplan['Addon_BulkAttnP']==1) { ?>
			 $("#bulk_attprice").text((no_of_users *Number($('#'+bulkattendance+tempvar).text())*remaining_days/30.42).toFixed(2));
			 // alert(no_of_users);
			 // alert(Number($('#'+bulkattendance+tempvar).text()));
			 // alert(remaining_days/30.42);
			 // alert((no_of_users *Number($('#'+bulkattendance+tempvar ).text())*remaining_days/30.42).toFixed(2));
			  <?php } 
			   else{
			  ?>
			   $("#bulk_attprice").text((x *Number($('#'+bulkattendance+tempvar ).text())*remaining_days/30.42).toFixed(2));
			   <?php } ?>
			   
			 <?php if($myplan['Addon_LocationTrackingP']==1) { ?>
			 $("#location_traceprice").text((no_of_users*Number($('#'+locationtracing+tempvar ).text())*remaining_days/30.42).toFixed(2));
			    <?php } 
			   else{
			  ?>
			  $("#location_traceprice").text((x*Number($('#'+locationtracing+tempvar ).text())*remaining_days/30.42).toFixed(2));
			   <?php } ?>
			 
			  <?php if($myplan['Addon_VisitPunchP']==1) { ?>
			  $("#visit_punchprice").text((no_of_users *Number($('#'+visitpunch+tempvar ).text())*remaining_days/30.42).toFixed(2));
			     <?php } 
			   else{
			  ?>
			  $("#visit_punchprice").text((x *Number($('#'+visitpunch+tempvar ).text())*remaining_days/30.42).toFixed(2));
			   <?php } ?>
			  
			   <?php if($myplan['Addon_GeoFenceP']==1) { ?>
			  $("#geo_fenceprice").text((no_of_users *Number($('#'+geofence+tempvar ).text())*remaining_days/30.42).toFixed(2));
			   <?php } 
			   else{
			  ?>
			   $("#geo_fenceprice").text((x *Number($('#'+geofence+tempvar ).text())*remaining_days/30.42).toFixed(2));
			   <?php } ?>
			  
			  <?php if($myplan['Addon_PayrollP']==1) { ?>
			  $("#payroll_price").text((no_of_users *Number($('#'+payroll+tempvar ).text())*remaining_days/30.42).toFixed(2));
			   <?php } 
			   else{
			  ?>
			  $("#payroll_price").text((x *Number($('#'+payroll+tempvar ).text())*remaining_days/30.42).toFixed(2));
			   <?php } ?>
			  
			  <?php if($myplan['Addon_TimeOffP']==1) { ?> 
			  $("#timeoff_price").text((no_of_users *Number($('#'+timeoff+tempvar ).text())*remaining_days/30.42).toFixed(2));
			   <?php } 
			   
			   else{
			  ?>
			  $("#timeoff_price").text((x *Number($('#'+timeoff+tempvar ).text())*remaining_days/30.42).toFixed(2));
	<?php } ?>
			  
			 if(plan=='YEARLY'){
				amount = Math.round(no_of_users * (($('.ratee').text())/365) * remaining_days);
				$('#rateindays').text(($('.ratee').text())+'/365');
			 }
			else{
				amount = Math.round(no_of_users * (($('.ratee').text())/30.42) * remaining_days);
				$('#rateindays').text(($('.ratee').text())+'/30.42');
			}
				
				$('#txt_ep').text("Amount");
				$('#amount1').text(amount);
				discount=Math.round((Number(amount) * Number($('#discount').text())) /100);
				$('#discount_amt').text(discount);
				if(discount<1){
					$("#disrow").css("display", "none");
				}else{
					$("#disrow").css("display", "block");
				}
				tax=0;
				
				//AddonsPrice();
				
				if(currency=='INR'){
					tax=Math.round(((amount-discount)*18)/100);
					
					tax_per=18.00;
					$('#tax_1').text(' ('+tax_per+'%) ');
					$('#tax_1').show();
				}
				$('#tax').text(tax);
			//	$('#_per').text((('/'+plan).toLowerCase()).replace('ly', ''));
				$('.__per').text((('/'+plan).toLowerCase()).replace('ly', ''));
				total=(amount-discount)+tax;
				$('#total').text(total);
				$('#totalshow').text(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
			//alert('total: '+total);
		}
		
		
		
		//else if(duration!=0 && users==userlimit){ 	// update the subs period only
		if(action=="DO"){ 					// update the subs period only
			if(duration<1){
				$('#err').text('Please upgrade the Duration');
				$("#duration").focus();
				return false;
			} 	
			$(".ud").hide();
			$(".uo").hide();
			$(".do").show();
			//$(".au").hide();
			//alert(userlimit);
			action='DO'; // update subscription duration only
		//	alert('update the subs period only');
		
		   var remaining_days=Number($("#remaining_days").text());
		   //alert("remaining_days :"+remaining_days);
		   var extendday = 0;
		   if(plan=='YEARLY')
		      extendday =  $("#duration").val()*365;
		   else
			   extendday =  $("#duration").val()*30.42;
		  
		    if((remaining_days+extendday)>364)
				plan='YEARLY';
			else 
				plan='MONTHLY';
			
			var x=userlimit;
			
			no_of_users=x;
			var element='';
			var bulkattendance = "";
			var locationtracing = "";
			var visitpunch = "";
			var geofence = "";
			var payroll = "";
			var timeoff = "";
			
		
			if(plan=='YEARLY' && currency=="USD"){
				element='usdYearly';
				$('#discount').text($('#dis_usd_year').val());
			}
			else if(plan=='MONTHLY' && currency=="USD"){
				element='usdMonthly';
				$('#discount').text($('#dis_usd_month').val());
			}
			else if(plan=='YEARLY' && currency=="INR"){
				element='inrYearly';
				$('#discount').text($('#dis_inr_year').val());
			}
			else if(plan=='MONTHLY' && currency=="INR"){
				element='inrMonthly';
				$('#discount').text($('#dis_inr_month').val());
			}
			
			var tempcurrency = "";
			if(currency=="INR")
			{
				 bulkattendance = "inrbulk_attendance";
				 locationtracing = "inrlocation_tracing";
				 visitpunch = "inrvisit_punch";
				 geofence = "inrgeo_fence";
				 payroll = "inrpayroll";
				 timeoff = "inrtime_off";
				 tempcurrency = "Rs";
			}
			else if(currency=="USD")
			{
				 bulkattendance = "usdbulk_attendance";
				 locationtracing = "usdlocation_tracing";
				 visitpunch = "usdvisit_punch";
				 geofence = "usdgeo_fence";
				 payroll = "usdpayroll";
				 timeoff = "usdtime_off";
				 tempcurrency = "USD";
			}
			var tempvar = "";
			
		   switch (true) {
                 case (x  >= 1 && x <= 20):
					$('.ratee').text($('#'+element+'0').text());
					tempvar = 0;
                 break;
                 case (x  >= 21 && x <= 40):
					$('.ratee').text($('#'+element+'1').text());
					tempvar = 1;
                 break;
                 case (x  >= 41 && x <= 60):
					$('.ratee').text($('#'+element+'2').text());
					tempvar = 2;
                 break;
				 case (x  >= 61 && x <= 80):
					$('.ratee').text($('#'+element+'3').text());
					tempvar = 3;
                 break;
				 case (x  >= 81 && x <= 100):
					$('.ratee').text($('#'+element+'4').text());
					tempvar = 4;
                 break;
				 case (x  >= 101 && x <= 120):
					$('.ratee').text($('#'+element+'5').text());
					tempvar = 5;
                 break;
				 case (x  >= 120 ):
					$('.ratee').text($('#'+element+'6').text());
					tempvar = 6;
                 break;
                 default:
                 break;
              }
			  
			 
			  /*alert("duration: "+$("#duration").val());
			  alert(tempvar);
			  alert($('#rate').text());
			  return false;*/
			  
			  $('#bulkatt_perprice').text("Bulk Attendance @"+tempcurrency+". "+$('#'+bulkattendance+tempvar ).text()+"/month");
			  $('#loctrace_perprice').text("Location Tracing @"+tempcurrency+". "+$('#'+locationtracing+tempvar ).text()+"/month");
			  $('#visit_perprice').text("Visit Punch @"+tempcurrency+". "+$('#'+visitpunch+tempvar ).text()+"/month");
			  $('#gfence_perprice').text("Geo Fence @"+tempcurrency+". "+$('#'+geofence+tempvar ).text()+"/month");
			  $('#payroll_perprice').text("Payroll @"+tempcurrency+". "+$('#'+payroll+tempvar ).text()+"/month");
			  $('#timeoff_perprice').text("Time Off @ "+tempcurrency+". "+$('#'+timeoff+tempvar ).text()+"/month");
			  
			  
			    // calculate price 
			  <?php if($myplan['Addon_BulkAttnP']==1) { ?>
			 $("#bulk_attprice").text((x *Number($('#'+bulkattendance+tempvar ).text())*extendday/30.42).toFixed(2));
			  <?php } 
			   else{
			  ?>
			   $("#bulk_attprice").text((x *Number($('#'+bulkattendance+tempvar ).text())*(remaining_days+extendday)/30.42).toFixed(2));
			   <?php } ?>
			   
			 <?php if($myplan['Addon_LocationTrackingP']==1) { ?>
			 $("#location_traceprice").text((x *Number($('#'+locationtracing+tempvar ).text())*extendday/30.42).toFixed(2));
			    <?php } 
			   else{
			  ?>
			  $("#location_traceprice").text((x *Number($('#'+locationtracing+tempvar ).text())*(remaining_days+extendday)/30.42).toFixed(2));
			   <?php } ?>
			 
			  <?php if($myplan['Addon_VisitPunchP']==1) { ?>
			  $("#visit_punchprice").text((x *Number($('#'+visitpunch+tempvar ).text())*extendday/30.42).toFixed(2));
			     <?php } 
			   else{
			  ?>
			  $("#visit_punchprice").text((x *Number($('#'+visitpunch+tempvar ).text())*(remaining_days+extendday)/30.42).toFixed(2));
			   <?php } ?>
			  
			   <?php if($myplan['Addon_GeoFenceP']==1) { ?>
			  $("#geo_fenceprice").text((x *Number($('#'+geofence+tempvar ).text())*extendday/30.42).toFixed(2));
			   <?php } 
			   else{
			  ?>
			   $("#geo_fenceprice").text((x *Number($('#'+geofence+tempvar ).text())*(remaining_days+extendday)/30.42).toFixed(2));
			   <?php } ?>
			  
			  <?php if($myplan['Addon_PayrollP']==1) { ?>
			  $("#payroll_price").text((x *Number($('#'+payroll+tempvar ).text())*extendday/30.42).toFixed(2));
			   <?php } 
			   else{
			  ?>
			  $("#payroll_price").text((x *Number($('#'+payroll+tempvar ).text())*(remaining_days+extendday)/30.42).toFixed(2));
			   <?php } ?>
			  
			  <?php if($myplan['Addon_TimeOffP']==1) { ?> 
			  $("#timeoff_price").text((no_of_users *Number($('#'+timeoff+tempvar ).text())*extendday/30.42).toFixed(2));
			   <?php } 
			   else{
			  ?>
			  $("#timeoff_price").text((x *Number($('#'+timeoff+tempvar ).text())*(remaining_days+extendday)/30.42).toFixed(2));
			   <?php } ?>
			  
			  
				if(plan=='YEARLY'){
					$('#rateindays').text((($('.ratee').text())/365));
                    extendday = extendday/365;
				}else{
					$('#rateindays').text((($('.ratee').text())/30.42));
					extendday = extendday/30.42;
				}
				price = x * ($('.ratee').text());
			
				amount= price*(extendday).toFixed(2);
			//	alert("Amount: "+amount);
			
		
				//AddonsPrice();
				
			
			
				$('#txt_ep').text("Amount");
				$('#amount_cp').text(amount);
				discount=(Number(amount) * Number($('#discount').text())) /100;
				$('#discount_amt').text(discount);
				if(discount<1){
					$("#disrow").css("display", "none");
				}else{
					$("#disrow").css("display", "block");
				}
				tax=0;
				$("#noOfUser_e").text(userlimit);			// user limit existing
				if(currency=='INR')	{
					tax=Math.round(((amount-discount)*18)/100);
					tax_per=18.00;
					$('#tax_1').text(' ('+tax_per+'%) ');
					$('#tax_1').show();
				}
				$('#tax').text(tax);
				//$('#_per').text((('/'+plan).toLowerCase()).replace('ly', ''));
				$('.__per').text((('/'+plan).toLowerCase()).replace('ly', ''));
				total=(amount-discount)+tax;
				$('#total').text(total);
				$('#totalshow').text(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
			////////////end update subs period

		}
		
		//else {		//if(duration!=0 && users>userlimit)	// update the subs and user limit both
		
		
		else if(action=="UD"){ 		// update the subs and user limit both
		  
			if(duration<1)
			{
				$('#err').text('Please upgrade the Duration');
				$("#duration").focus();
				return false;
			}
			// else if(users<1){
				// $('#err').text('You should add at least 1 user to proceed further.');
				// $("#noOfUser").focus();
				// return false;
			// } 
			if(ragisteruser > (Number(userlimit)+ Number(users)) )
		    {
		    	alert("The No. of Additional Users should be >= "+ (Number(ragisteruser) - Number(userlimit))+" user" );
			    return false;
		    }
			action='UD'; // update User limit and subscription duration both
			$(".uo").hide();
			$(".do").hide();
			$(".ud").show();
			$("#noOfUser_e").text(userlimit);			// user limit existing
			$("#noOfUser_n").text(users + userlimit); 				// user limit new
			//$("#noOfUser_1").text(users); 	// user lim updated by(users)
			$(".noOfUser_12").text(users); 	// user lim updated by(users)
			var remaining_days=$("#remaining_days").text(); 	// user lim updated by(users)
			var x=users+userlimit;
			no_of_users=users;
			var element='';
			var element='';
			var bulkattendance = "";
			var locationtracing = "";
			var visitpunch = "";
			var geofence = "";
			var payroll = "";
			var timeoff = "";
			
			var extendday = 0;
		   if(plan=='YEARLY')  
		      extendday =  $("#duration").val()*365;
		   else
			   extendday =  $("#duration").val()*30.42;
		   
		    
			var temp_plan=plan;
			if( (remaining_days+extendday) > 364 )
			plan='YEARLY';
			if(plan=='YEARLY' && currency=="USD"){
				element='usdYearly';
				$('#discount').text($('#dis_usd_year').val());
			}
			else if(plan=='MONTHLY' && currency=="USD"){
				element='usdMonthly';
				$('#discount').text($('#dis_usd_month').val());
			}
			else if(plan=='YEARLY' && currency=="INR"){
				element='inrYearly';
				$('#discount').text($('#dis_inr_year').val());
			}
			else if(plan=='MONTHLY' && currency=="INR"){
				element='inrMonthly';
				$('#discount').text($('#dis_inr_month').val());
			}
			
			
				var tempcurrency = "";
				if(currency=="INR")
				{
					 bulkattendance = "inrbulk_attendance";
					 locationtracing = "inrlocation_tracing";
					 visitpunch = "inrvisit_punch";
					 geofence = "inrgeo_fence";
					 payroll = "inrpayroll";
					 timeoff = "inrtime_off";
					 tempcurrency = "Rs";
				}
				else if(currency=="USD")
				{
					 bulkattendance = "usdbulk_attendance";
					 locationtracing = "usdlocation_tracing";
					 visitpunch = "usdvisit_punch";
					 geofence = "usdgeo_fence";
					 payroll = "usdpayroll";
					 timeoff = "usdtime_off";
					 tempcurrency = "USD";
				}
			 var tempvar = "";
			
		   switch(true){
                 case (x  >= 1 && x <= 20):
				   tempvar = 0;
					$('.ratee').text($('#'+element+'0').text());
                 break;
                 case (x  >= 21 && x <= 40):
				    tempvar = 1;
					$('.ratee').text($('#'+element+'1').text());
                 break;
                 case (x  >= 41 && x <= 60):
				    tempvar = 2;
					$('.ratee').text($('#'+element+'2').text());
                 break;
				 case (x  >= 61 && x <= 80): 
				     tempvar = 3;
					$('.ratee').text($('#'+element+'3').text());
                 break;
				 case (x  >= 81 && x <= 100):
				     tempvar = 4;
					$('.ratee').text($('#'+element+'4').text());
                 break;
				 case (x  >= 101 && x <= 120):
				     tempvar = 5;
					$('.ratee').text($('#'+element+'5').text());
                 break;
				 case (x  >= 120 ):
				   tempvar = 6;
					$('.ratee').text($('#'+element+'6').text());
                 break;
                 default:
                 break;
              }
			  
			    $('#bulkatt_perprice').text("Bulk Attendance @"+tempcurrency+". "+$('#'+bulkattendance+tempvar ).text()+"/month");
			  $('#loctrace_perprice').text("Location Tracing @"+tempcurrency+". "+$('#'+locationtracing+tempvar ).text()+"/month");
			  $('#visit_perprice').text("Visit Punch @"+tempcurrency+". "+$('#'+visitpunch+tempvar ).text()+"/month");
			  $('#gfence_perprice').text("Geo Fence @"+tempcurrency+". "+$('#'+geofence+tempvar ).text()+"/month");
			  $('#payroll_perprice').text("Payroll @"+tempcurrency+". "+$('#'+payroll+tempvar ).text()+"/month");
			  $('#timeoff_perprice').text("Time Off @ "+tempcurrency+". "+$('#'+timeoff+tempvar ).text()+"/month");
			  
			  

			 /* alert("total user :"+x+" additional user : "+users+" proce :"+$('#'+bulkattendance+tempvar ).text()+" remaining_days days : "+remaining_days+" Extended days: "+ extendday);
			  alert("New price "+parseFloat((x *Number($('#'+bulkattendance+tempvar ).text())*extendday/30.42).toFixed(2)));
			  alert("Old price "+parseFloat((users *Number($('#'+bulkattendance+tempvar ).text())*remaining_days/30.42).toFixed(2)));*/
			  
			    // calculate price 
			  <?php if($myplan['Addon_BulkAttnP']==1) { ?>
			  
			 $("#bulk_attprice").text((parseFloat((x *Number($('#'+bulkattendance+tempvar ).text())*extendday/30.42).toFixed(2)) + parseFloat((users *Number($('#'+bulkattendance+tempvar ).text())*remaining_days/30.42).toFixed(2))).toFixed(2));
			  <?php } 
			   else{
			  ?>
			   $("#bulk_attprice").text((x *Number($('#'+bulkattendance+tempvar ).text())*(parseFloat(remaining_days)+parseFloat(extendday))/30.42).toFixed(2));
			   <?php } ?>
			   
			 <?php if($myplan['Addon_LocationTrackingP']==1) { ?>
			 $("#location_traceprice").text((parseFloat((x *Number($('#'+locationtracing+tempvar ).text())*extendday/30.42).toFixed(2)) + parseFloat((users*Number($('#'+locationtracing+tempvar ).text())*remaining_days/30.42).toFixed(2))).toFixed(2));
			    <?php } 
			   else{
			  ?>
			  $("#location_traceprice").text((x *Number($('#'+locationtracing+tempvar ).text())*(parseFloat(remaining_days) + parseFloat(extendday))/30.42).toFixed(2));
			   <?php } ?>
			 
			  <?php if($myplan['Addon_VisitPunchP']==1) { ?>
			  $("#visit_punchprice").text((parseFloat((x *Number($('#'+visitpunch+tempvar ).text())*extendday/30.42).toFixed(2)) + parseFloat((users*Number($('#'+visitpunch+tempvar ).text())*remaining_days/30.42).toFixed(2))).toFixed(2));
			     <?php } 
			   else{
			  ?>
			  $("#visit_punchprice").text((x *Number($('#'+visitpunch+tempvar ).text())*(parseFloat(remaining_days)+parseFloat(extendday))/30.42).toFixed(2));
			   <?php } ?>
			  
			   <?php if($myplan['Addon_GeoFenceP']==1) { ?>
			  $("#geo_fenceprice").text((parseFloat((x *Number($('#'+geofence+tempvar ).text())*extendday/30.42).toFixed(2)) + parseFloat((users *Number($('#'+geofence+tempvar ).text())*remaining_days/30.42).toFixed(2))).toFixed(2)) ;
			   <?php } 
			   else{
			  ?>
			   $("#geo_fenceprice").text((x *Number($('#'+geofence+tempvar ).text())*(parseFloat(remaining_days) +parseFloat(extendday))/30.42).toFixed(2));
			   <?php } ?>
			  
			  <?php if($myplan['Addon_PayrollP']==1) { ?>
			  $("#payroll_price").text((parseFloat((x *Number($('#'+payroll+tempvar ).text())*extendday/30.42).toFixed(2)) + parseFloat((users*Number($('#'+payroll+tempvar ).text())*remaining_days/30.42).toFixed(2))).toFixed(2));
			   <?php } 
			   else{
			  ?>
			  $("#payroll_price").text((x *Number($('#'+payroll+tempvar ).text())*(parseFloat(remaining_days)+parseFloat(extendday))/30.42).toFixed(2));
			   <?php } ?>
			  
			  <?php if($myplan['Addon_TimeOffP']==1) { ?> 
			  $("#timeoff_price").text((parseFloat((x *Number($('#'+timeoff+tempvar ).text())*extendday/30.42).toFixed(2)) + parseFloat((users*Number($('#'+timeoff+tempvar ).text())*remaining_days/30.42).toFixed(2))).toFixed(2));
			   <?php } 
			   else{
			  ?>
			  $("#timeoff_price").text((x *Number($('#'+timeoff+tempvar ).text())*(parseFloat(remaining_days)+parseFloat(extendday))/30.42).toFixed(2));
			   <?php } ?>
			  
			  
				//AddonsPrice();
				
			  
			  var amt_for_new_period=0;
			 if(plan=='YEARLY'){
				$('#rateindays').text((($('.ratee').text())+'/365'));
				amount =Math.round(no_of_users * (($('.ratee').text())/365) * remaining_days);
				if(temp_plan=="YEARLY")// monthly or yearly cal for new period
					amt_for_new_period=Math.round((users+userlimit) * (($('.ratee').text())) * duration);
				else{
					amt_for_new_period=Math.round((users+userlimit) * (($('.ratee').text())) * duration/12); // duration is in year after updating 'plan' by 365 days factor
				}
			}else{
				$('#rateindays').text((($('.ratee').text())+'/30.42'));
				amount = Math.round(no_of_users * (($('.ratee').text())/30.42) * remaining_days);
				amt_for_new_period=Math.round((users+userlimit) * (($('.ratee').text())) * duration);
			 }
			
				$('#txt_ep').text("Amount to be paid for Extended period"); 		// for existing plan
				$('#amount1').text(amount); 		// for existing plan
				
				$('#amount_cp').text(amt_for_new_period); 		// for new period and for all users
				
				$('#amount_st').text(amount+amt_for_new_period); // sub total of new and existing plan
				
				tamt=amt_for_new_period+amount;
				//alert(tamt);
			//	return false;
			
				discount=Math.round((Number(tamt) * Number($('#discount').text())) /100);
				$('#discount_amt').text(discount);
				if(discount<1){
					$("#disrow").css("display", "none");
				}else{
					$("#disrow").css("display", "block");
				}
				tax=0;
				if(currency=='INR')
				{
					tax=Math.round(((tamt-discount)*18)/100);
					tax_per=18.00;
					$('#tax_1').text(' ('+tax_per+'%) ');
					$('#tax_1').show();
				}
				$('#tax').text(tax);
				//$('#_per').text((('/'+plan).toLowerCase()).replace('ly', ''));
				$('.__per').text((('/'+plan).toLowerCase()).replace('ly', ''));
				total=(tamt-discount)+tax;
				//alert(total);
				$('#total').text(total);
				$('#totalshow').text(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
		}
	     
		//// set addons start here
       		AddonsPrice();
		
       $("#edit3").show();
    	var cur='';		
    	if(currency=='USD')
    		cur='$';
    	else
    		cur='Rs.';
    		$(".accordion_body3").slideUp(300);
            $(".accordion_body6").slideDown(300);
            //$(".accordion_body4").slideDown(300);
		
		
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
				if($("#country").val()=='India' && $("#state").val()=='')
				{
					$("#state").focus();
					alert('Please select state ');
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
		    
		
	    	var bulkAtt_sts=($('#bulk_attcheck'). prop("checked")==true)?1:0;
			var bulk_attp = (bulkAtt_sts==1)?$('#bulk_attprice1').val():0;   
			var visit_punchsts=($('#visit_punchcheck'). prop("checked")==true)?1:0;
			var visit_punchp = (visit_punchsts==1)?$('#visit_punchprice1').val():0;    
			var loc_tracests=($('#location_tracecheck'). prop("checked")==true)?1:0;
			var loc_tracep = (loc_tracests==1)?$('#location_traceprice1').val():0;    
			var geo_fencests=($('#geo_fencecheck'). prop("checked")==true)?1:0;
			var geo_fencep = (geo_fencests==1)?$('#geo_fenceprice1').val():0;    
			var payrollsts=($('#payroll_check'). prop("checked")==true)?1:0;
			var payrollp = (payrollsts==1)?$('#payroll_price1').val():0;    
			var timeoffsts=($('#timeoff_check'). prop("checked")==true)?1:0;
			var timeoffp = (timeoffsts==1)?$('#timeoff_price1').val():0; 	
			
			
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
			
			savetemppay();
		/*
			alert("Plan"+plan);
			alert("ind_name"+ind_name);
			alert("contact"+contact);
			alert("street"+street);
			alert("country"+country);
			alert("zip"+zip);
			alert("action"+action);
			alert("no_of_users"+no_of_users);
			alert("currency"+currency);
			alert("tax"+tax);
			alert("total"+total);
			alert("discount"+discount);
			alert("city"+city);
			alert("gstin"+gstin);
			return false;
		*/
			var string = "";	
		
			string += "?plan="+plan+"%26";
			string += "ind_name="+ind_name+"%26";
			string += "contact="+contact+"%26";
			string += "street="+btoa(street)+"%26";
			string += "country="+btoa(country)+"%26";
			string += "zip="+zip+"%26";
			string += "action="+action+"%26";
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
			var paypal_email = 'namrata@ubitechsolutions.com'; // for production
		//	var paypal_email = 'glbsng@gmail.com'; //for Sandbox
			
				var return_url = '<?=URL?>Myplan/UpgradePlan_Successpaypal'+string;
				console.log(return_url);
				//exit();
				var cancel_url = '<?=URL?>Myplan/failed_upgrade'+string  ;
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
				//window.open('https://www.sandbox.paypal.com/cgi-bin/webscr'+querystring,"_blank");  // send box
				 window.open('https://www.paypal.com/cgi-bin/webscr'+querystring,"_self");
				
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