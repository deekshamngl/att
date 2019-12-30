<?php
  $paypalUrl='https://www.sandbox.paypal.com/cgi-bin/webscr';
 $paypalId='abhinavsengar.cs@gmail.com';
  //$paypalId='glbsng@gmail.com';
  
  $MERCHANT_KEY = "rjQUPktU"; // test
  $SALT = "e5iIg1jwi8";       //test
  $PAYU_BASE_URL = "https://test.payu.in";     
// should alo change in  myplan_moedel  PaymentSuccess();
/*
  $MERCHANT_KEY = "dv1tL3LP";//for LIVE mode
  $SALT = "AlGt0f59fS"; //for LIVE mode 
  $PAYU_BASE_URL = "https://secure.payu.in";//for LIVE mode
*/
  
  $action = '';
  $posted = array();
  if(!empty($_POST)) {
    // print_r($_POST);
  
   foreach($_POST as $key => $value) {    
     $posted[$key] = $value; 
  
   }
  }
  $formError = 0;
  if(empty($posted['txnid'])) {
   // Generate random transaction id
   $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
  } else {
   $txnid = $posted['txnid'];
  }
  $hash = '';
  $amount=isset($posted['amount'])?$posted['amount']:"";
  $plan='';
  $addon_users='';
  $addon_amt='';
  $discount_amt='';
  $tax='';
  $productinfo='';
  $country='';
  $state='';
  $street='';
  $city='';
  $zip='';
  $individual='';
  $contact='';
  $gstin='';
  // Hash Sequence
  $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
  
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
   //	echo '<script>$("#loader").show();</script>';
  //$org_id=$_SESSION['orgid'];
  $_SESSION['paid_in']="INR";
  $_SESSION['plan_users']=isset($myplan['applogin'])?$myplan['applogin']:'0';
  $_SESSION['package']=isset($myplan['packagename'])?$myplan['packagename']:'';;
  $_SESSION['plan']=isset($posted['plan']) ? $posted['plan'] : 'noplan';; //monthly or annually
  $_SESSION['addon_users']=isset($posted['addon_users']) ? $posted['addon_users'] : '0';
  $_SESSION['addon_amt']=isset($posted['addon_amt']) ? $posted['addon_amt'] : '0';;
  $_SESSION['discount_amt']=isset($posted['discount_amt']) ? $posted['discount_amt'] : '0';
  $_SESSION['tax']=isset($posted['tax']) ? $posted['tax'] : '0';
  
  $_SESSION['country']=isset($posted['country']) ? $posted['country'] : '0';
  $_SESSION['state']=isset($posted['state']) ? $posted['state'] : '0';
  $_SESSION['street']=isset($posted['street']) ? $posted['street'] : '0';
  $_SESSION['city']=isset($posted['city']) ? $posted['city'] : '0';
  $_SESSION['zip']=isset($posted['zip']) ? $posted['zip'] : '0';
  $_SESSION['individual']=isset($posted['individual']) ? $posted['individual'] : '0';
  $_SESSION['contact']=isset($posted['contact']) ? $posted['contact'] : '0';
  $_SESSION['gstin']=isset($posted['gstin']) ? $posted['gstin'] : '';
  
  //	$productinfo=$org_id.",,".$paid_in.",,".$plan_users.",,".$plan.",,".$addon_users.",,".$addon_amt.",,".$addon_amt.",,".$tax.",,".$package.",,".$discount_amt}';
    // $productinfo = json_encode(json_decode('[{"org_id":$org_id,"paid_in":$paid_in,"plan_users":$plan_users,"plan":$plan,"addon_users":$addon_users,"addon_amt":$addon_amt,"addon_amt":$addon_amt,"tax":$tax,"package":$package,"discount_amt",$discount_amt}]'));
  $hashVarsSeq = explode('|', $hashSequence);
     $hash_string = '';	
  foreach($hashVarsSeq as $hash_var) {
       $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
       $hash_string .= '|';
     }
     $hash_string .= $SALT;
     $hash = strtolower(hash('sha512', $hash_string));
     $action = $PAYU_BASE_URL . '/_payment';
  //$action ='#';
   }
  } elseif(!empty($posted['hash'])) { 
   $hash = $posted['hash'];
   $action = $PAYU_BASE_URL . '/_payment';
  // $action = '#';
  }
  
  ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>ubiAttendance</title>
    <style type="text/css">
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
    </style>

    <script>
      ///////--------------- var declarations
      var currency='';
      var plan=12; // default yearly , i = monthly
      var pid=0;
      var users=0;
      var admins=0;
      var addonuser=0;
      var userrate=0;
      var setup=0;
      var discount=0;
      var discountmonths=0;
      var packageuser=0;
      var igst=0;
      ///////---------------
          var hash = '<?php echo $hash ?>';
       //   var $amount = '<?php echo $hash ?>';
          function submitPayuForm() { 
            if(hash == '') {  
              return; 
            }
      	/* alert('<?php echo isset($posted['amount'])?$posted['amount']:"0"; ?>');*/
           var payuForm = document.forms.payuForm; 
            payuForm.submit();
          }
        
    </script>
  </head>
  <body onload="submitPayuForm()" >
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
            </div>
            <?php //print_r($myplan['codes']['code'][0]); ?>
            <div class="col-md-12" >
              <div class="card valign">
                <div class="card-header" data-background-color="orange">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <h6 class="nav-tabs-title">My Plan<input type="hidden" id="pid" value="<?php echo isset($myplan['pid'])?$myplan['pid']:'0';?>"></h6>
                    </div>
                  </div>
                </div>
                <div class="card-content table-responsive">
                  <div class="row">
                    <form action="#" method="get">
                      <div class="accordion_container">
                        <div class="row">
                          <div class="col-xs-12 col-md-12 col-lg-12">
                            <div class="accordion_main">
                              <div class="accordion_head">Existing Plan<button id="edit1" type="button" class="btn editbutton"><i  class="fa fa-pencil " style="font-size:12px;margin-top:0px;top:0px;"></i> Edit</button></div>
                              <div class="accordion_body1 section_position" >
                                <div class="row" >
                                  <div class="col-xs-6">
                                    <div class="form-group">
                                      <label for="inputsm"> Starting Date</label>
                                      <span class="form-control input-sm " id="startdate"  type="text" value="" disabled ><?php if(isset($myplan['start_date'])){ echo $myplan['start_date']; } ?></span>
                                    </div>
                                  </div>
                                  <div class="col-xs-6">
                                    <div class="form-group">
                                      <label for="inputsm"> Ending Date</label>
                                      <span class="form-control input-sm" id="enddate"  type="text" value="" disabled ><?php if(isset($myplan['end_date'])){ echo $myplan['end_date']; } ?></span>
                                    </div>
                                  </div>
                                </div>
                                <div class="row" >
                                  <div class="col-xs-6">
                                    <div class="form-group">
                                      <label for="inputsm"> Users Limit</label>
                                      <span class="form-control input-sm" id="userlimit"  type="text" value="" disabled ><?php if(isset($myplan['user_limit'])){ echo $myplan['user_limit']; } ?></span>
                                    </div>
                                  </div>
                                  <div class="col-xs-6">
                                    <div class="form-group">
                                      <label for="inputsm">Registered Users </label>
                                      <span class="form-control input-sm" id="totalusers"  type="text" value="" disabled ><?php if(isset($myplan['totalUser'])){ echo $myplan['totalUser']; } ?></span>
                                    </div>
                                  </div>
                                </div>
                                <div class="row" >
                                  <div class="col-xs-6">
                                    <div class="form-group">
                                      <label for="inputsm">Active Users</label>
                                      <span class="form-control input-sm" id="activeusers"  type="text" value="" disabled ><?php if(isset($myplan['activeUser'])){ echo $myplan['activeUser']; } ?></span>
                                    </div>
                                  </div>
                                  <div class="col-xs-6">
                                    <div class="form-group">
                                      <label for="inputsm">Inactive Users</label>
                                      <span class="form-control input-sm" id="inactiveusers"  type="text" value="" disabled ><?php if(isset($myplan['inactiveUser'])){ echo $myplan['inactiveUser']; } ?></span>
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
                              		$("#edit2").hide();
                              		$("#edit3").hide();
                              		$("#edit4").hide();
                              		}); 
                              		
                              	$("#edit2").click(function () {
                              		pid=$('#pid').val();			
                              		$(".accordion_body1").slideUp(300);
                              		$(".accordion_body2").slideDown(300);
                              		$(".accordion_body3").slideUp(300);
                              		$(".accordion_body4").slideUp(300);
                              		$(".accordion_body5").slideUp(300);
                              		$("#edit3").hide();
                              		$("#edit4").hide();
                              		}); 
                              	$("#edit3").click(function () {
                              		pid=$('#pid').val();			
                              		$(".accordion_body1").slideUp(300);
                              		$(".accordion_body2").slideUp(300);
                              		$(".accordion_body3").slideDown(300);
                              		$(".accordion_body4").slideUp(300);
                              		$(".accordion_body5").slideUp(300);
                              		$("#edit4").hide();
                              		}); 
                              	$("#edit4").click(function () {
                              		pid=$('#pid').val();			
                              		$(".accordion_body1").slideUp(300);
                              		$(".accordion_body2").slideUp(300);
                              		$(".accordion_body3").slideUp(300);
                              		$(".accordion_body4").slideDown(300);
                              		$(".accordion_body5").slideUp(300);
                              		}); 
                              	
                              		
                              })
                              
                            </script>
                            <div class="accordion_main">
                              <div class="accordion_head">Select Currency <button id="edit2" data-toggle="dropdown" aria-expanded="false" type="button" class="btn editbutton"><i  class="fa fa-pencil " style="font-size:12px;margin-top:0px;top:0px;"></i> Edit</button></div>
                              <div class="accordion_body2 " style="display: none;">
                                <div class="row" >
                                  <div class="col-md-3" ></div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <div class="form-group">
                                        <select class="form-control" id="currency" >
                                          <option value="">Select Currency</option>
                                          	  <!-- <option value="USD">USD</option>-->
                                          <option value="INR">Rupees</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-3" ></div>
                                </div>
                                <button type="button" class="btn btn-success" id="continue"  data-toggle="dropdown" aria-expanded="false">Continue</button>
                              </div>
                            </div>
                            <div class="accordion_main">
                              <div class="accordion_head">Select Plan <button id="edit3" type="button" class="btn editbutton"><i  class="fa fa-pencil " style="font-size:12px;margin-top:0px;top:0px;"></i> Edit</button></div>
                              <div class="accordion_body3" style="display: none;">
                                <!------start btn------>
                                <div id="forRsBtns">
                                  <div class="btn-group" style="border: 2px solid #c9c9cc;padding:1px;" >
                                    <button id="yearly" type="button" class="btn " style="background-color:#9c27b0!important;color: white;">Yearly</button>
                                    <button id="monthly" type="button" class="btn " style="background-color:transparent!important;color: black;">Monthly</button>
                                  </div>
                                  &nbsp;<span id="offer" style="font-weight: bold;color: #3cad3c;"><?php 
                                    if($myplan['disinmonthforyearlyinr']>0){ echo "<b> Get ".$myplan['disinmonthforyearlyinr']." months discount on yearly subscription</b>"; } ?></span>
                                </div>
                                <script>
                                  $('#yearly').click(function(){ 
                                  	$('#yearly').css({'background-color':'#9c27b0;','color':'white'});
                                  	$('#monthly').css({'background-color':'transparent','color':'black'});
                                  //	$('#offer').show();
                                  	$('#forRsYearly').show();
                                  	$('#forRsMonthly').hide();
                                  	plan=12;
                                  });
                                  $('#monthly').click(function(){ 
                                  	$('#monthly').css({'background-color':'#9c27b0','color':'white'});
                                  	$('#yearly').css({'background-color':'transparent','color':'black'});
                                  //	$('#offer').hide();
                                  	$('#forRsMonthly').show();
                                  	$('#forRsYearly').hide();
                                  	plan=1;
                                  });
                                </script>
                                <!------ end btn------>	
                                <div class="row" id="forRs" >
                                  <div class="col-md-4 col-lg-4 col-xl-4 col-sm-12 col-xs-12" >
                                  </div>
                                  <div class="col-md-4 col-lg-4 col-xl-4 col-sm-12 col-xs-12" id="forRsYearly" >
                                    <center>
                                      <div class="panel panel-default">
                                        <div class="panel-heading">
                                          <h4>
                                            YEARLY PLAN<!--<?php echo $myplan['packagename']; ?>-->
                                          </h4>
                                        </div>
                                        <div class="panel-body" style="padding-left:0px;padding-right:0px;">
                                          <div class="feature">
                                            <?php if(isset($myplan['priceperuserpermonthinr'])){ echo " Rs.<b>".$myplan['priceperuserpermonthinr']*(12-$myplan['disinmonthforyearlyinr'])*$myplan['applogin']; } ?></b> - <?php 
                                              if($myplan['disinmonthforyearlyinr']>0){ echo " Get <b><span id='discountINRmo'>".$myplan['disinmonthforyearlyinr']."</span></b> months discount!"; } ?> 
                                          </div>
                                          <div class="feature">
                                            <?php if(isset($myplan['baseinr'])){ if($myplan['baseinr']==0) echo "<b>Zero</b> <span id='setupchargeINR2' style='display:none'>".$myplan['baseinr']."</span>"; else echo " Rs.<b>".$myplan['baseinr']; } ?></b> setup charges
                                          </div>
                                          <div class="feature" style="background-color: #f5f5f5;">
                                            <h5>FEATURES</h5>
                                          </div>
                                          <div class="feature">
                                            <table class="table">
                                              <tr>
                                                <td width="50%">User Logins</td>
                                                <td width="50%"><span id='usersRSyr'class="positned"><?php if(isset($myplan['applogin'])){ echo $myplan['applogin']; } ?></span></td>
                                              </tr>
                                            </table>
                                          </div>
                                          <div class="feature">
                                            <table class="table">
                                              <tr>
                                                <td width="50%">Administrator Logins</td>
                                                <td width="50%"><span id='adminsRSyr'class="positned"><?php if(isset($myplan['adminlogin'])){ echo $myplan['adminlogin']; } ?></span></td>
                                              </tr>
                                            </table>
                                          </div>
                                          <div class="feature"style="background-color: #f5f5f5;">
                                            <h5>ADD-ONS </h5>
                                          </div>
                                          <div >
                                            <table class="table">
                                              <tr>
                                                <td>Additional Users</td>
                                                <td><?php if(isset($myplan['addonuseerpminr'])){ echo " <b><del>Rs.<span id='userrateRS1'>".$myplan['addonuseerpminr']*12; } ?></span></del></b> <?php echo " <b>Rs.<span>".$myplan['addonuseerpminr']*(12-$myplan['disinmonthforyearlyinr']);  ?></span></b>/user/year</td>
                                              </tr>
                                            </table>
                                          </div>
                                        </div>
                                      </div>
                                    </center>
                                  </div>
                                  <div class="col-md-4 col-lg-4 col-xl-4 col-sm-12 col-xs-12" id="forRsMonthly" style="display:none" >
                                    <center>
                                      <div class="panel panel-default">
                                        <div class="panel-heading">
                                          <h4>
                                            MONTHLY PLAN<!--<?php echo $myplan['packagename']; ?>-->
                                          </h4>
                                        </div>
                                        <div class="panel-body" style="padding-left:0px;padding-right:0px;">
                                          <div class="feature">
                                            <?php if(isset($myplan['priceperuserpermonthinr'])){ echo "Rs.<b>".$myplan['priceperuserpermonthinr']*$myplan['applogin']."</b>"; } ?> 
                                          </div>
                                          <div class="feature">
                                            <?php if(isset($myplan['baseinr'])){ if($myplan['baseinr']==0) echo "<b>Zero</b> <span id='setupchargeINR3' style='display:none'>".$myplan['baseinr']."</span>"; else echo " Rs.<b>".$myplan['baseinr']; } ?></b> setup charges
                                          </div>
                                          <div class="feature" style="background-color: #f5f5f5;">
                                            <h5>FEATURES</h5>
                                          </div>
                                          <div class="feature">
                                            <table class="table">
                                              <tr>
                                                <td width="50%">User Logins</td>
                                                <td width="50%"><span id='usersRSmo'class="positned"><?php if(isset($myplan['applogin'])){ echo $myplan['applogin']; } ?></span></td>
                                              </tr>
                                            </table>
                                          </div>
                                          <div class="feature">
                                            <table class="table">
                                              <tr>
                                                <td width="50%">Administrator Logins</td>
                                                <td width="50%"><span id='adminsRSmo' class="positned"><?php if(isset($myplan['adminlogin'])){ echo $myplan['adminlogin']; } ?></span></td>
                                              </tr>
                                            </table>
                                          </div>
                                          <div class="feature" style="background-color: #f5f5f5;">
                                            <h5>ADD-ONS </h5>
                                          </div>
                                          <div >
                                            <table class="table">
                                              <tr>
                                                <td>Additional Users</td>
                                                <td><?php if(isset($myplan['addonuseerpminr'])){ echo " Rs.<b><span id='userrateRS2'>".$myplan['addonuseerpminr']."</span>"; } ?></b>/user/month</td>
                                              </tr>
                                            </table>
                                          </div>
                                        </div>
                                      </div>
                                    </center>
                                  </div>
                    </form>
                    <div class="col-md-4 col-lg-4 col-xl-4 col-sm-12 col-xs-12" ></div>
                    </div>
                    <!------start btn------>
                    <div id="forUsdBtns">
                    <div class="btn-group" style="border: 2px solid #c9c9cc;padding:1px;" >
                    <button id="yearlyUsd" type="button" class="btn " style="background-color:#9c27b0!important;color: white;">Yearly</button>
                    <button id="monthlyUsd" type="button" class="btn " style="background-color:transparent!important;color: black;">Monthly</button>
                    </div> &nbsp;<span  style="font-weight: bold;color: #3cad3c;" id="offerUSDyr"><?php 
                      if($myplan['disinmonthforyearlydollar']>0){ echo "<b> Get <span id='offerUsd'>".$myplan['disinmonthforyearlydollar']."</span> months discount on yearly subscription</b>"; } ?></span></span>
                    </div>
                    <script>
                      /*
                      var currency='';
                      var plan=''; ////1(month) and 12(yearly)
                      var pid=0;
                      var users=0;
                      var admins=0;
                      var addonuser=0;
                      var userrate=0;
                      var setup=0;
                      var discount=0;
                      var discountmonths=0;
                      var packageuser=0;
                      */
                      	$('#yearlyUsd').click(function(){ 
                      		$('#yearlyUsd').css({'background-color':'#9c27b0;','color':'white'});
                      		$('#monthlyUsd').css({'background-color':'transparent','color':'black'});
                      		$('#offerUsd').show();
                      	//	$('#offerUSDyr').show();
                      		$('#forUsdYearly').show();
                      		$('#forUsdMonthly').hide();
                      		plan=12; //yearly
                      
                      	//	alert(currency+' '+pid+' '+plan+' '+discountmonths+' '+setup+' '+admins+' '+users+' '+userrate);
                      	});
                      
                      	$('#monthlyUsd').click(function(){ 
                      		$('#monthlyUsd').css({'background-color':'#9c27b0','color':'white'});
                      		$('#yearlyUsd').css({'background-color':'transparent','color':'black'});
                      	//	$('#offerUsd').hide();
                      	//	$('#offerUSDyr').hide();
                      		$('#forUsdMonthly').show();
                      		$('#forUsdYearly').hide();
                      		plan=1; //monthly
                      	});
                    </script>
                    <!------ end btn------>	
                    <div class="row" id="forUsd" >
                    <div class="col-md-4 col-lg-4 col-xl-4 col-sm-12 col-xs-12" >
                    </div>
                    <div class="col-md-4 col-lg-4 col-xl-4 col-sm-12 col-xs-12" id="forUsdYearly" >
                    <center>
                    <div class="panel panel-default">
                    <div class="panel-heading"><h4><?php echo $myplan['packagename']; ?></h4></div>
                    <div class="panel-body" style="padding-left:0px;padding-right:0px;">
                    <div class="feature">
                    <?php if(isset($myplan['priceperuserpermonthdollar'])){ echo " $ <b>".$myplan['priceperuserpermonthdollar']*(12-$myplan['disinmonthforyearlydollar'])*$myplan['applogin']; } ?></b>/<?php 
                      if($myplan['disinmonthforyearlydollar']>0){ echo " Get <b>".$myplan['disinmonthforyearlydollar']."</b> months discount!"; } ?> 
                    </div>
                    <div class="feature">
                    <?php if(isset($myplan['basedollar'])){ if($myplan['basedollar']==0) echo "<b>Zero</b> <span id='setupchargeusd1' style='display:none'>".$myplan['basedollar']."</span>"; else echo " $ <b>".$myplan['basedollar']; } ?></b> setup charge
                    </div>
                    <div class="feature">
                    <h5>FEATURES</h5>
                    </div>
                    <div class="feature">
                    <table class="table">
                    <tr>
                    <td width="50%">User Logins</td><td width="50%"><span id="usersUSDyr" class="positned"><?php if(isset($myplan['applogin'])){ echo $myplan['applogin']; } ?></span></td>
                    </tr>
                    </table>
                    </div>
                    <div class="feature">
                    <table class="table">
                    <tr>
                    <td width="50%">Administrator Logins</td><td width="50%"><span id="adminsUSDyr" class="positned"><?php if(isset($myplan['adminlogin'])){ echo $myplan['adminlogin']; } ?></td>
                    </tr>
                    </table>
                    </div>
                    <div class="feature">
                    <h5>ADD-ONS </h5>
                    </div>
                    <div >
                    <table class="table">
                    <tr>
                    <td>Additional USers</td><td><?php if(isset($myplan['addonuseerpmusd'])){ echo "  <b><del>$<span id='userrateUSD'>".$myplan['addonuseerpmusd']*12; } ?></span></del></b><?php echo " $<span>".$myplan['addonuseerpmusd']*(12-$myplan['disinmonthforyearlydollar']); ?></span>/user/Year</td>
                    </tr>
                    </table>
                    </div>
                    </div>
                    </div>
                    </center>
                    </div>
                    <div class="col-md-4 col-lg-4 col-xl-4 col-sm-12 col-xs-12" id="forUsdMonthly" style="display:none" >
                    <center>
                    <div class="panel panel-default">
                    <div class="panel-heading"><h4><?php echo $myplan['packagename']; ?></h4></div>
                    <div class="panel-body" style="padding-left:0px;padding-right:0px;">
                    <div class="feature">
                    <?php if(isset($myplan['priceperuserpermonthdollar'])){ echo " $ <b>".$myplan['priceperuserpermonthdollar']*$myplan['applogin']; } ?></b>
                    </div>
                    <div class="feature">
                    <?php if(isset($myplan['basedollar'])){ if($myplan['basedollar']==0) echo "<b>Zero</b><span id='setupchargeusd2' style='display:none'>".$myplan['basedollar']."</span>"; else echo " $ <b>".$myplan['basedollar']; } ?></b> setup charge
                    </div>
                    <div class="feature">
                    <h5>FEATURES</h5>
                    </div>
                    <div class="feature">
                    <table class="table">
                    <tr>
                    <td width="50%">User Logins</td><td width="50%"><span id="usersUSDmo" class="positned"><?php if(isset($myplan['applogin'])){ echo $myplan['applogin']; } ?></span></td>
                    </tr>
                    </table>
                    </div>
                    <div class="feature">
                    <table class="table">
                    <tr>
                    <td width="50%">Administrator Logins</td><td width="50%"><span id="adminsUSDmo" class="positned"><?php if(isset($myplan['adminlogin'])){ echo $myplan['adminlogin']; } ?></span></td>
                    </tr>
                    </table>
                    </div>
                    <div class="feature">
                    <h5>ADD-ONS </h5>
                    </div>
                    <div >
                    <table class="table">
                    <tr>
                    <td>Additional Users</td><td><?php if(isset($myplan['addonuseerpmusd'])){ echo " $ <b><span id='userrateUSD1'>".$myplan['addonuseerpmusd']; } ?></span></b>/user/month</td>
                    </tr>
                    </table>
                    </div>
                    </div>
                    </div>
                    </center>
                    </div>
                    <div class="col-md-4 col-lg-4 col-xl-4 col-sm-12 col-xs-12" ></div>
                    <!--  <div class="col-md-1"></div>
                      <div class="col-md-10" >
                      <table class="table table-bordereds">
                      <thead>
                        <tr>
                      	<th><b>#</b></th>
                      	<th><b>Item</b></th>
                      	<th><b>Price</b></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                      	<td>1</td>
                      	<td>Annual subscription for Basic package</td>
                      	<td><?php if(isset($myplan['package_price_usd_yr'])){ echo "<b> $</b>".$myplan['package_price_usd_yr']; } ?></td>
                        </tr>
                      </tbody>
                       </table>
                      </div>
                      <div class="col-md-1" ></div>-->
                    </div>
                    <button type="button" class="btn btn-success" id="continue2"  data-toggle="dropdown" aria-expanded="false">Continue</button>
                    </div>	
                    </div>
                    <!--		
                      $myplan['packagename'] =  $row[0]['packagename'];
                      $myplan['baseinr'] =  $row[0]['baseinr'];
                         $myplan['basedollar'] =  $row[0]['basedollar'];
                         $myplan['priceperuserpermonthinr'] =  $row[0]['priceperuserpermonthinr'];
                         $myplan['priceperuserpermonthdollar'] =  $row[0]['priceperuserpermonthdollar'];
                         $myplan['disinrupeeforinr'] =  $row[0]['disinrupeeforinr'];
                         $myplan['disindollarfordollar'] =  $row[0]['disindollarfordollar'];
                         $myplan['disinperforinr'] =  $row[0]['disinperforinr'];
                         $myplan['disinperfordollar'] =  $row[0]['disinperfordollar'];
                         $myplan['disinmonthforyearlyinr'] =  $row[0]['disinmonthforyearlyinr'];
                         $myplan['disinmonthforyearlydollar'] =  $row[0]['disinmonthforyearlydollar'];
                         $myplan['applogin'] =  $row[0]['applogin'];
                         $myplan['adminlogin'] =  $row[0]['adminlogin'];
                      $myplan['addonuseerpminr'] =  $row[0]['addonuseerpminr'];		 
                         $myplan['addonuseerpmusd'] =  $row[0]['addonuseerpmusd'];			 
                         $myplan['igst'] =  $row[0]['igst'];			 
                      		-->
                    <div class="accordion_main">
                    <div class="accordion_head">Plan Details <button id="edit4" type="button" class="btn editbutton"><i  class="fa fa-pencil " style="font-size:12px;margin-top:0px;top:0px;"></i> Edit</button></div>
                    <div class="accordion_body4 " style="display: none;">
                    <div class="row"  ><!--id="TotalUsd"-->
                    <div class="col-md-1" ></div>
                    <div class="col-md-10" >
                    <table class="table table-bordereds">
                    <tr>
                    <th width="30%"><b>Item</b></th>
                    <th width="24%"><b>Unit Price</b></th>
                    <th width="27%"><b>No. Of Units</b></th>
                    <th width="19%"><b>Total</b></th>
                    </tr>
                    <tbody>
                    <tr>
                    <td width="30%">
                    <!--	<?php echo isset($myplan['packagename'])?$myplan['packagename']:''; ?> -->					<span id="packageuse"></span>&nbsp;(<span><?php if(isset($myplan['applogin'])){ echo $myplan['applogin']; } ?>&nbsp;Users</span>)
                    </td>
                    <td width="24%">
                    <span class="revCurrency"></span><span id="revUnitPrice">
                    </td>
                    <td width="27%"><span style="text-align: center;">1</span></td>
                    <td width="19%">
                    <span class="revCurrency"></span><span id="revTotal"></span>
                    </td>
                    </tr>
                    </tbody>
                    </table>
                    <table class="table table-bordereds">
                    <tr>
                    <td width="30%">Additional Users  
                    </td>
                    <td width="24%">
                    <span class="revCurrency"></span>
                    <span id="reVamount"></span><span >/user/</span><span id="plan"></span>
                    </td>
                    <td width="27%"><span id="mystyle"><input type="number" name='addOnUser' id="addOnUser" value="0" min="0" class="form-control"/></span></td>
                    <td width="19%"><span class="revCurrency"></span><span id="addOnUserAmt">0</span></td>
                    </tr>
                    </table>
                    <!--		<table class="table table-bordereds">
                      <thead>
                        <tr>
                      	<th width="15%"><b>Plan</b></th>
                      	<th width="15%"><b>Renewal</b></th>
                      	<th width="15%"><b>Subscribe Upto</b></th>
                      	<th width="15%" ><b>Setup Fee</b></th>
                      	<th width="15%"><b>Users</b></th>
                      	<th width="10%" ><b>Rate</b></th>
                          <th width="15%"><b>Total</b></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                      	<td><?php echo isset($myplan['packagename'])?$myplan['packagename']:''; ?></td>
                      	<td><span id="revPlanType"></span></td>
                      	<td><span id="revSubUpto"></span></td>
                      	<td><span class="revCurrency"></span><span id="revSetup"></span></td>
                      	<td><span  id="revPlanPrice" ></span></td>
                      	<td><span class="revCurrency"></span><span  id="revUnit" ></span></td>
                      	<td><span class="revCurrency"></span><span id="revTotal"></span></td>
                        </tr>
                        </table>	-->
                    <script>
                      $("#addOnUser").change(function(){
                       if( $("#addOnUser").val()=='')
                      	$("#addOnUser").val(0);
                        $("#addOnUserAmt").text(parseFloat($("#addOnUser").val())*userrate*plan);
                      //  alert("addons: "+ $("#addOnUser").val());
                      //  alert( "users: "+parseFloat(parseFloat(users) + parseFloat($("#addOnUser").val())));
                      //	  alert( "userrate: "+userrate);
                      //	  alert( "discountmonths: "+discountmonths);
                        $("#revDiscountAmt").text(parseFloat(discountmonths)*parseFloat((parseFloat(users)+(parseFloat($("#addOnUser").val()))))*userrate);
                        $("#addOnUserAmt1").text(parseFloat($("#addOnUser").val())*userrate*plan);
                        var igst=0;
                      igst=parseFloat($("#revIGSTPer").text());
                      $('#revIGSTAmt').text((((parseFloat(userrate*users*plan)+parseFloat(setup))+(parseFloat($("#addOnUser").val())*userrate*plan)-(parseFloat(discountmonths)*parseFloat((parseFloat(users)+(parseFloat($("#addOnUser").val()))))*userrate))*igst)/100); //
                      //	$('#revGrandTotal').text((parseFloat(userrate*users*plan)+parseFloat(setup)-(parseFloat(discountmonths)*users*userrate))+((parseFloat(userrate*users*plan)+parseFloat(setup)-(parseFloat(discountmonths)*users*userrate))*igst)/100);
                      //+((parseFloat(discountmonths)*users*userrate)*igst)/100	//+((parseFloat($("#addOnUser").val())*userrate*plan))+((parseFloat(userrate*users*plan)+parseFloat(setup)
                      //
                        $('#revGrandTotal').text((parseFloat(userrate*users*plan)+parseFloat(setup))+(parseFloat($("#addOnUser").val())*userrate*plan)-(parseFloat(discountmonths)*parseFloat((parseFloat(users)+(parseFloat($("#addOnUser").val()))))*userrate));//+parseFloat($('#revIGSTAmt').text())
                        
                      
                      $('#sel_addon_users').val( $("#addOnUser").val());
                      });
                    </script>
                    <!--	  <h5><b>Promo Code</b></h5>
                      <table class="table table-bordereds">
                       <tr>
                      <td width="25%"> 
                      <span>Have Promo Code ?</span>
                      </td>
                      <td width="20%"><span id=""><input type="test" name='addOnUser' class="form-control" placeholder="Promo Code (if available)"/></span> </td>
                      <td width="15%"> <span style="color:green;cursor:pointer"><b>apply</span></span></td>
                      <td width="10%"></td>
                      <td width="15%"></td>
                      <td width="15%"><span>0000</span></td>
                      </tr>
                      </table>-->
                    <hr/> 
                    <table class="table borderless">
                    <tr>
                    <td width="25%"> 
                    </td>
                    <td width="20%"></td>
                    <td width="10%"></td>
                    <td width="24%">My Plan </td>
                    <td width="1%"></td>
                    <td width="20%"><span class="revCurrency"></span><span id="revPlanPrice1"></span></td>
                    </tr>
                    <tr>
                    <td width="25%"> 
                    </td>
                    <td width="20%"></td>
                    <td width="10%"></td>
                    <td width="24%">Add-ons </td>
                    <td width="1%">+</td>
                    <td width="20%"><span class="revCurrency"></span><span id="addOnUserAmt1">0</span></td>
                    </tr>
                    <!--	  <tr>
                      <td width="25%"> 
                      </td>
                      <td width="20%"></td>
                      <td width="15%"></td>
                      <td width="10%"></td>
                      <td width="15%">Promo Code </td>
                      <td width="15%">- <span class="revCurrency"></span><span id="revPromoCodeAmt1">0</span></td>
                       </tr>-->
                    <tr>
                    <td width="25%"> 
                    </td>
                    <td width="20%"></td>
                    <td width="10%"></td>
                    <td width="25%"><span style="color: red">Yearly Discount<span> </td>					<td width="1%" style="color: red">-</td>
                    <td width="20%"><span style="color: red"><span class="revCurrency"></span><span id="revDiscountAmt">0</span></span></td>
                    </tr>
                    <tr id="taxation" style="display:none">
                    <td width="25%"> 
                    </td>
                    <td width="20%"></td>
                    <td width="10%"></td>
                    <td width="24%">Tax<sup>*</sup> <span id="revIGSTPer"><?php echo isset($myplan['igst'])?$myplan['igst']:''; ?></span>%</td>
                    <td width="1%"></td>
                    <td width="20%">+ <span class="revCurrency"></span><span id="revIGSTAmt">0</span></td>
                    </tr>
                    <tr>
                    <td width="25%"> 
                    </td>
                    <td width="20%"></td>
                    <td width="10%"></td>
                    <td width="24%"><b>Total Amount</b> </td>
                    <td width="1%"></td>
                    <td width="20%"><span class="revCurrency"></span><span id="revGrandTotal">0</span></td>
                    </tr>
                    </tbody>
                    </table>
                    </div>
                    <div class="col-md-1" ></div>
                    </div>
                    <button type="button" class="btn btn-success" id="continue3"  data-toggle="dropdown" aria-expanded="false">Continue</button>
                    </div>
                    </div>
                    <div class="accordion_main">
                    <div class="accordion_head">Review Order</div>
                    <div class="accordion_body5 section_position" style="display:none;" >
                    <h5><strong>Order Summary</strong></h5>
                    <table class="table table-striped">
                    <thead>
                    <tr>
                    <th width="74%"><b>Particulars</b></th>
                    <th width="1%"></th>
                    <th width="25%"><b> Amount</b></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                    <td width="74%">My Plan</td>
                    <td width="1%"></td>
                    <td width="25%"> <span class="revCurrency"></span><span id="finalPackage"></span></td>
                    </tr>
                    <tr>
                    <td width="74%">Add-ons</td>
                    <td width="1%">+</td>
                    <td width="25%"><span class="revCurrency"></span><span id="finalAddons"></span></td>
                    </tr>
                    <tr style="color:red">
                    <td width="74%">Yearly Discount</td>
                    <td width="1%">-</td>
                    <td width="25%"><span class="revCurrency"></span><span id="finalDiscount"></span></td>
                    </tr>
                    <tr>
                    <td width="74%">Tax<sup>*</sup></td>
                    <td width="1%">+</td>
                    <td width="25%"><span class="revCurrency"></span><span id="finalTax"></span></td>
                    </tr>
                    <tr>
                    <td width="74%"><b>Total</b></td>
                    <td width="1%"></td>
                    <td width="25%"><b><span class="revCurrency"></span><span id="finalTotal"></span></b></td>
                    </tr>
                    </tbody>
                    </table>
                    <span><small>* Tax mentioned may vary. The final tax amount will be reflected in your invoice.
                    </small></span>
                    <hr/>
                    <?php if($formError) { ?>
                    <span style="color:red">Please fill all mandatory fields.</span>
                    <br/>
                    <br/>
                    <?php } ?>
                    <form action="<?php echo $action;?>" method="post" id="myForm" name="payuForm">
                    <!---------------Custom field----------------->
                    <h4><strong>Billing Details</strong></h4>
                   
                    <div class="row">
                    <div class="col-lg-6 col-sm-12 col-md-6 col-xs-12">
                    <input type="text" id="individual" class="form-control" name="individual" placeholder="Company Name" value="<?php echo $individual; ?>"/>
                    <!--	<input type="text" class="form-control" id="country" name="country" value="india" readonly="true"  style="margin-bottom: 12px!important;"/> -->
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 col-xs-12">
                    <input type="number" id="contact" min="1000000000" max='999999999999999' class="form-control" name="contact" placeholder="Phone No." value="<?php echo $contact; ?>"/>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                    <textarea id="street" placeholder="Street Address" class="form-control" rows="2" name="street"><?php echo $street; ?></textarea>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-lg-6 col-sm-12 col-md-6 col-xs-12">
                    <input type="text" id="city" class="form-control" name="city" placeholder="City" value="<?php echo $city; ?>"/>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 col-xs-12">
                    
                    <select id="state" class="form-control" name="state">
                    <option value=''>State </option>
                    <?php for($i =0; $i<count($myplan['states']['name']); $i++){	
						?>
                    <option value="<?php echo $myplan['codes']['code'][$i];?>"><?php echo $myplan['states']['name'][$i];?></option>	
                <?php 
                    }   
                    ?>
                    <option value='other'> other </option>
                    </select>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-lg-6 col-sm-12 col-md-6 col-xs-12">
                    <input type="text" id="zip" class="form-control" name="zip"  placeholder="Pin Code" value="<?php echo $zip; ?>"/>
                    </div>
                    <div class="col-sm-6 col-md-3 col-xs-6 col-lg-3">
                    <div class="input-group">
                    <span class="input-group-btn">
                    <input type="radio" name="gstno" id="descripcion" style="height:18px; width:18px; vertical-align: middle;margin-top:30px;" checked>
                    </span>
                    <input type="text" id="gstin" class="form-control descrip" name="gstin"  placeholder="GST No." value="<?php echo $gstin; ?>"/>
                    </div>
                    </div>
                    <div class="col-sm-6 col-lg-3 col-xs-6 col-md-3">
                    <input type="radio" name="gstno" id="1step" value="not applicable" style="height:18px; width:18px;margin-top:40px;">&nbsp;<span style="font-size:15px;">Not Applicable</span>
                    </div>
                    </div>
                    <!---------------Custom field----------------->
                    <script>
                      $(function(){
                      	$("#1step").click(function() {
                            				$(".descrip").prop("required", false);
                            				$(".descrip").prop("disabled", true);
                        				});
                        				$("#descripcion").click(function(){
                        					$(".descrip").prop("required",true);
                        					$(".descrip").prop("disabled",false);	
                        				});
                      });
                    </script>
                    <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
                    <input type="hidden"  type="text" name="hash" value="<?php echo $hash ?>"/>
                    <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
                    <div style="display:none">
                    <input name="amount"  id="finalamount" value="<?php echo $amount; ?>" readonly />
                    <input name="firstname" id="firstname" value="<?php echo $myplan['cname']; ?>" readonly />
                    <input name="email" id="email" value="<?php echo (empty($_SESSION['Email'])) ? '' : $myplan['oemail']; ?>" readonly />
                    <input name="phone" value="<?php echo str_replace(' ', '', $myplan['ophone']); ?>" />
                    <textarea name="productinfo">ubiAttendance Application</textarea>
                    <input name="surl" value="<?php echo URL.'Myplan/success'?>" size="64" />
                    <input name="furl" value="<?php echo URL.'Myplan/failed'?>" size="64" />
                    <input type="hidden" name="service_provider" value="payu_paisa" size="64" />
                    <input type="text" name="plan" id="sel_plan" value="<?php echo $plan;?>" />
                    <input type="text" name="addon_users" id="sel_addon_users" value="<?php echo $addon_users;?>" />
                    <input type="text" name="addon_amt" id="sel_addon_amt" value="<?php echo $addon_amt;?>" />
                    <input type="text" name="discount_amt" id="sel_discount_amt" value="<?php echo $discount_amt;?>" />
                    <input type="text" name="tax" id="sel_tax" value="<?php echo $tax;?>" />
                    </div>
                    <input id="payumoney" class="btn btn-success" type="submit" value="Make Payment" />
                    </form>
                    <script>
                      $(function(){
                      	$('#payumoney').click(function(){
                      		
                      		if($("#street").val()=='')
                      		{
                      			$("#street").focus();
                      			alert('Please fill street address ');
                      			return false;
                      		}
                      		if($("#city").val()=='')
                      		{
                      			$("#city").focus();
                      			alert('Please fill city ');
                      			return false;
                      		}
                      		if($("#zip").val()=='')
                      		{
                      			$("#zip").focus();
                      			alert('Please fill zip ');
                      			return false;
                      		}
                      		if($("#state").val()=='')
                      		{
                      			$("#state").focus();
                      			alert('Please select state  ');
                      			return false;
                      		}
                      		if($("#individual").val()=='')
                      		{
                      			$("#individual").focus();
                      			alert('Please fill individual/Company Name ');
                      			return false;
                      		}
                      		if($("#contact").val()=='')
                      		{
                      			$("#contact").focus();
                      			alert('Please fill contact');
                      			return false;
                      		}
                      		return true;
                      	});
                      });
                       
                    </script>
                    <!--		<button class="btn btn-success" onclick="return false;" id="paypal">Pay via payPal</button>-->
                    <!-- this form for paypal (start) -->
                    <div class="row" id="paypal" align="center" style="display:none;">
                    <form action="<?php echo $paypalUrl; ?>" method="post" name="frmPayPal1">
                    <div class="panel price panel-red">
                    <input type="hidden" name="business" value="<?php echo $paypalId; ?>">
                    <input type="hidden" name="cmd" value="_xclick">
                    <input type="hidden" name="item_name" value="ubiAttendance Subscription">
                    <input type="hidden" name="item_number" value="2">
                    <input type="hidden" name="amount1" id="payPalAmount" value="<?php echo $amount; ?>">
                    <input type="hidden" name="no_shipping" value="1">
                    <input type="hidden" name="currency_code" value="USD">
                    <input type="hidden" name="cancel_return" value="<?=URL?>Myplan/failed">
                    <input type="hidden" name="return" id="success" value="">  
                    <div class="panel-footer">
                    <button  href="#" id="paypal_button" ><img class="img-rounded" src="../assets/img/secure_payment_by_paypal.jpg" style="max-width:100px; "/></button>
                    </div>
                    </div>
                    </form>
                    <!-- /PRICE ITEM -->
                    <div class="clearfix"></div>
                    </div>
                    <!-- This form for paypal(end) -->
                    </div>	
                    </div>
                    </div>
                    </div>
                    <!-- end .accordion_container -->
                    </form>
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
            <p class="copyright pull-right">
              &copy; <script>document.write(new Date().getFullYear())</script> <a href="#">DESIGNED BY</a> ubitech solutions pvt. ltd.
            </p>
          </div>
        </footer>
      </div>
    </div>
  </body>
  <script>
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
    	
    	$("#continue").click(function(){
    		$("#edit2").show();			
    		if($('#currency').val() == ""){
    		  	alert("Please select currency");
    			return false;
    			
    		}
    		
    			
    		if($('#currency').val() != 'USD'){
    			$('#forUsd').hide();
    			$('#forUsdBtns').hide();
    			$('#forRs').show();
    			$('#forRsBtns').show();
    		
    		}else{
    			$('#forRs').hide();
    			$('#forRsBtns').hide();
    			$('#forUsd').show();
    			$('#forUsdBtns').show();
    		}	
    		currency=$('#currency').val();
    		$(".accordion_body2").slideUp(300);
            $(".accordion_body3").slideDown(300);
    	})
    /*
    var currency='';
    var plan='';
    var pid=0;
    var users=0;
    var admins=0;
    var addonuser=0;
    var userrate=0;
    var setup=0;
    var discount=0;
    var discountmonths=0;
    var packageuser=0;
    */
    	
    	
    	$("#continue2").click(function(){ 
    	$("#edit3").show();
    	//
    	
    	$('#addOnUser').val(0);
    	$('#addOnUserAmt').text('0');
    	$('#addOnUserAmt1').text('0');
    		if(plan==12 && currency=='USD'){
    					discountmonths=$('#offerUsd').text();
    					setup=parseFloat($('#setupchargeusd1').text());
    					admins=parseFloat($('#adminsUSDyr').text());
    					users=parseFloat($('#usersUSDyr').text());
    					userrate=parseFloat($('#userrateUSD').text())/12;
    					$("#revIGSTPer").text('0');
    			//		$("#taxation").hide();
    					$('#reVamount').text(parseFloat(userrate)*12);
    					$('#plan').text('annum');
    					$('#packageuse').text('Yearly Plane');
    		}else if(plan==1 && currency=='USD'){
    					discountmonths=0; 
    					setup=parseFloat($('#setupchargeusd2').text());
    					admins=parseFloat($('#adminsUSDmo').text());
    					users=parseFloat($('#usersUSDmo').text());
    					userrate=parseFloat($('#userrateUSD1').text());
    					$("#revIGSTPer").text('0');
    			//		$("#taxation").hide();
    					$('#reVamount').text(parseFloat(userrate));
    					$('#plan').text('Month');
    					$('#packageuse').text('Monthly plan');
    		}else if(plan==12 && currency=='INR'){ 
    					discountmonths=$('#discountINRmo').text();
    					setup=$('#setupchargeINR2').text();
    					admins=$('#adminsRSyr').text();
    					users=$('#usersRSyr').text();
    					userrate=parseFloat($('#userrateRS1').text())/12;
    				//	$("#taxation").show();
    					$('#reVamount').text(parseFloat(userrate)*12);
    					$('#plan').text('annum');
    					$('#packageuse').text('Yearly Plan');
    		}else if(plan==1 && currency=='INR'){ 
    					discountmonths=0;
    					setup=$('#setupchargeINR3').text();
    					admins=$('#adminsRSmo').text();
    					users=$('#usersRSmo').text();
    					userrate=parseFloat($('#userrateRS2').text());
    				//	$("#taxation").show();
    					$('#reVamount').text(parseFloat(userrate));
    					$('#plan').text('Month');
    					$('#packageuse').text('Monthly plan');
    		}
    		
    	//	alert(currency+' '+pid+' '+plan+' '+discountmonths+' '+setup+' '+admins+' '+users+' '+userrate);
    	var cur='';		
    	if(currency=='USD')
    		cur='$';
    	else
    		cur='Rs.';
    		
    	
    		igst=parseFloat($("#revIGSTPer").text());
    		$('.revCurrency').text(cur);
    			
    		$('#revPlanType').text(plan=='12'?'Yearly':'Monthly');
    		$('#revPlanPrice').text(parseFloat(users));
    		$('#revUnitPrice').text(parseFloat(userrate*users*plan)+parseFloat(setup));
    	//	alert(" userrate: "+userrate+" users: "+users+" plan: "+plan)
    		$('#revTotal').text(parseFloat(userrate*users*plan)+parseFloat(setup));
    		$('#revUnit').text(parseFloat(userrate));
    		$('#revSetup').text(parseFloat(setup));
    		$('#revDiscountAmt').text(parseFloat(discountmonths)*users*userrate);// discount mnth
    		$('#revPlanPrice1').text(parseFloat(userrate*users*plan)+parseFloat(setup));
    		
    		
    		$('#revIGSTAmt').text(((parseFloat(userrate*users*plan)+parseFloat(setup)-(parseFloat(discountmonths)*users*userrate))*igst)/100);
    		$('#revGrandTotal').text((parseFloat(userrate*users*plan)+parseFloat(setup)-(parseFloat(discountmonths)*users*userrate)));//+((parseFloat(userrate*users*plan)+parseFloat(setup)-(parseFloat(discountmonths)*users*userrate))*igst)/100
    		
    		var enddate=$("#enddate").text().split("-");;
    		var d1 = new Date(enddate[2], enddate[1], enddate[0]);
    		var d = new Date();
    		if(d1>d) // get max date for renewal the subscription
    			d=d1;
    		d.setMonth(d.getMonth()+1+ plan); //() returns month in 0-11
    		$('#revSubUpto').text(d.getDate()+"-"+d.getMonth()+"-"+d.getFullYear());		
    		$(".accordion_body3").slideUp(300);
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
    			$('#payumoney').hide();
    			$('#paypal').show();
    			
    		}
    		else{
    			$('#paypal').hide();
    			$('#payumoney').show();
    		}
    		
    	})
    	
    	
    
    	
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
  </script>
      <script>
      $(function(){
      	
	 	$("#payumoney").click(function(){
	 	<?php if(!isset($posted['street'])){ alert();
	 	?> //$('#loader').hide();
	 	document.getElementById("loader").style.display = "none";
	 	<?php }else{ ?>
	 	document.getElementById("loader").style.display = "block";
	 	//$('#loader').show();
	 	<?php } ?>
	 		
	 			//$('.spinner-wrapper').show();
	//	$("#maindiv").addClass("spinner-wrapper");
		});
	});
</script>
</html>