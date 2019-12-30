<?php
// Your test paypal sandbox url, Replace it with live url after successful testing.
DEFINE('PAYPAL_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr'); 
// Set paypal marchent id.
DEFINE('PAYPAL_ID', 'abhinavsengar.cs@gmail.com');  // you can find thuis in your developer account it look like "username-facilitator@gmail.com"
// Define your base currency
DEFINE('CURRENCY', 'USD');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- Bootstrap core CSS     -->
	 <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	 <meta name="viewport" content="width=device-width, initial-scale=1">
	 <link href="<?=URL?>../assets/css/bootstrap.min.css" rel="stylesheet" />
	 <link href="<?=URL?>../assets/css/font-awesome.min.css" rel="stylesheet" />
	 <link href="<?=URL?>../assets/css/_all-skins.min.css" rel="stylesheet"/>
	 <link href="<?=URL?>../assets/css/AdminLTE.min.css" rel="stylesheet"/>
	 
	<style>
     form {
          border: 3px solid #f1f1f1;
          }
@media only screen and (min-width: 501px) {
		form{
			margin-top:4%;
			width:400px!important;
		}
		.container{
			width:400px!important;
		}
		.alert{
	width:400px;
	}
}
input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
} 

.a-button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

button:hover {
    opacity: 0.8;
}

.cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
}

.imgcontainer {
    text-align: center;
    margin: 24px 0 4px 0;
}

img.avatar {
    width: 40%;
    border-radius: 50%;
}

.container {
    padding: 16px;
}

span.psw {
    float: right;
    padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
    span.psw {
       display: block;
       float: none;
    }
    .cancelbtn {
       width: 100%;
    }
}
.alert{
	display:none;	
}
.loader {
    border: 10px solid #f3f3f3; /* Light grey */
    border-top: 10px solid #3498db; /* Blue */
    border-radius: 50%;
    width: 60px;
    height: 60px;
	align: center;
	margin-left:150px;
    animation: spin 2s linear infinite;
}
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.border-button {
  border: solid 3px #d1a0ff;
  transition: border-width 0.4s linear ;
}
.stylefont{
	color:purple;
	font-weight: bold;
	border: 0px solid;
}
.headfont{
	color:black;
	//font-weight: 1000;
	//font-size:14px;
}
.border-button:hover { border-width: 8px; }
.btn-success{
	//color:black;
	//background-color:purple;
	font-size:14px;
}
.alert4{
	display:none;	
}

.hover{background-color: #cc0000}
.authorBlock{border-top:1px solid #cc0000;}

.accordion_container {
  width: 100%;
  padding: 1em;
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
.info1{
	margin-left:5px;
}
</style>

</head>
<body style="background-color:offwhite;" ng-app="packageapp" ng-controller="packageCtrl">
<?php
if($id == 1){
	$title = 'Basic Package';
}elseif($id == 2){
	$title = 'Pro Package';
}else{
	$title = 'Ultimate Package';
}
//echo "Buy Package: ".$title;
//echo $orgName;
//print_r($this->org);
?>
           
<!--<div class="imgcontainer">
	<img src="<?=URL?>../assets/img/logo.png" alt="Ubitech" height="100px" width="150px"/>
</div>-->
<section class="content">
<?php
$type = isset($_GET['type'])?$_GET['type'] : '';
if($type == 'success') {
  //echo "<pre>";
  //print_r($_REQUEST);
  echo "<h1>Payment Successful</h1>";
} 
 
if($type == 'cancel') {
  echo "<h1>Payment Canceled</h1>";
}
?>
   
	 <div class="box-header with-border" data-background-color="green" style="background-color:purple; height:40px;">
	 <p class="category" style="color:white;font-size:22px; font-family: Helvetica;" align="center" ><?php echo $title; ?></p>       
	 </div>
	 <div class="row " style="width:1400px; margin-left:45px; ">
	 <div class="imgcontainer">
    <img src="<?=URL?>../assets/img/logo.png" alt="Ubitech" height="85px" width="150px"/>
  </div>
		   <div id="winfo" class="alert4">  <label class="col-sm-8" >Please Enter Correct Refrence Id</label> </div>
		   <div id="info1" class="col-sm-8" style="margin-left:450px; border: 0px solid #d1d3d6;">
		     <div class="row form-group" >
			    <label class="col-sm-2" >Enter Reference Id</label>
			    <div class="col-sm-3">
				  <input type="text" id="refno"  ng-model="ref_no" name="refno" class="form-control" placeholder = "Enter Refrence Id" />
				  <input type="button" id="btn1" class="btn btn-sm btn-success" value="Submit" ng-click="getallorg()" />
				</div>
			 </div>
			 
			 <!--<div class="row form-group " >
			    <div class="col-sm-2" >Refrence No:</div>
			    <div class="col-sm-3" ><input type="text" class="form-control" id="email" placeholder="Refrence No" ng-model="refno"></div>
			 </div>-->
			
			<!--- <div class="row">
			 
			  <div id="info1" class="alert4">
		      <div class="row form-group" >
			  <div class="col-md-3">
			    <div class="headfont"> Consulting Person</div>
			    <span  class="form-control" id="email" placeholder="Consulting Person" ng-model="c_nmae" style=" border: 0px solid;"> <b class="stylefont">{{c_nmae}}</b></span>
				</div>
				
		 <div class="col-md-3">
			 <div> Organization Name</div>
			   <span type="text" class="form-control stylefont" id="email"data-placeholderr="Organization Name" ng-model="orgName" style=" border: 0px solid;" >{{orgName}}</span></div>
			 </div>
		<div class="row form-group" >
		 <div class="col-md-3">
			    <div> Email</div>
			    <span type="text" class="form-control stylefont" id="email" placeholder="email" ng-model="email" style=" border: 0px solid;">{{email}}</span>
		 </div>
		 <div class="col-md-3">
			    <div> Contact No</div>
			    <span type="text" class="form-control stylefont" id="email" placeholder="Contact No" ng-model="PhoneNumber"  style=" border: 0px solid;" > {{PhoneNumber}}</span></div>
			</div>
	  <div class="row form-group" >
	  <div class="col-md-3">
			 <div >Country</div>
			   <span type="text" class="form-control stylefont" id="email" placeholder="Country" ng-model="country" style=" border: 0px solid;" >{{country}}</span>
			 </div>
			    <div class="col-md-3">
			    <div  > Total Users</div>
			    <span type="text" class="form-control stylefont" id="email" placeholder="Total Users" ng-model="TotalUsers"  style=" border: 0px solid;">{{TotalUsers}}</span>
				</div>
	     </div>
		 <div class="row form-group" >
			 <div class="col-md-3">
			    <div> Registeration Date</div>
			    <span type="text" class="form-control stylefont" id="email" placeholder="Registration Date" ng-model="RegistrationDate" style=" border: 0px solid;">{{RegistrationDate}}</span></div>
				<div class="col-md-3">
			    <div >Subscription Upto</div>
			    <span type="text" class="form-control stylefont" ng-model="Subscriptionupto" >{{Subscriptionupto}}</span>
			 </div>
		 
	     </div>
		 
			 </div>
		 <div class="row form-group" >
			  <div class="col-md-3">
			   <div> User Limit</div>
			   <span type="text" class="form-control stylefont" ng-model="UserLimit" name="Users"  >{{UserLimit}}</span></div>
	     <div class="col-md-3">
			  <div>User</div>
			   <input type="text" class="form-control stylefont" ng-model="Users" name="Users" placeholder="Enter user">
			 </div>
		 
		 
		</div>
			
			<div class="row form-group" >
			  <div class="col-md-3">
			    <div>Currency</div>
			    <select class="form-control" ng-change="PaymentCurrency()" id="PaymentCurrency1" name="PaymentCurrency1"  ng-model="PaymentCurrency1" >
						<option value=''>Select Currency</option>
						<option value='RS'>RS</option>
						<option value='USD'>USD</option>
					</select>
				</div>
				
				
		<div class="col-md-3">
		 <div>Subscription Period</div>
			 <select class="form-control" ng-change="month()" id="month" name="month"  ng-model="mymonth" >
						<option value="">Select Month</option>
						<option value='1'>1 Month</option>
						<option value='3'>3 Months</option>
						<option value='6'>6 Months</option>
						<option value='12'>12 Months</option>
					</select>
			 </div>
			</div>
			 -->
			 
			 
	<div class="row alert4"  id="info1" style="margin-left:0px;">
      <div class="col-xs-12 col-md-12 col-lg-12" style="margin-left:0px;">
       
		<div class="accordion_main">
           <div class="accordion_head">Buyer info.</div>
          <div class="accordion_body1" >
			  <div class="row" >
			   
			  <div class="col-xs-6">
			  <div class=" form-group" >
			    <label class="headfont"> Consulting Person</label>
			    <span  class="form-control" id="email" placeholder="Consulting Person" ng-model="c_nmae" style=" border: 0px solid;"> <b class="stylefont">{{c_nmae}}</b></span>
				</div>
				</div>
				 <div class=" form-group" >
		          <div class="col-xs-6">
			 <label> Organization Name</label>
			   <span type="text" class="form-control stylefont" id="email"data-placeholderr="Organization Name" ng-model="orgName" style=" border: 0px solid;" >{{orgName}}</span></div>
			 </div>
		 <div class=" form-group" >
		 <div class="col-xs-6">
		 <label> Email</label>
			    <span type="text" class="form-control stylefont" id="email" placeholder="email" ng-model="email" style=" border: 0px solid;">{{email}}</span>
		 </div>
		 </div>
		  <div class=" form-group" >
		 <div class="col-xs-6">
			    <label> Contact No</label>
			    <span type="text" class="form-control stylefont" id="email" placeholder="Contact No" ng-model="PhoneNumber"  style=" border: 0px solid;" > {{PhoneNumber}}</span></div>
			</div>
	 
	  <div class="col-xs-6">
	   <div class=" form-group" >
	     <label >Country</label>
		 <span type="text" class="form-control stylefont" id="email" placeholder="Country" ng-model="country" style=" border: 0px solid;" >{{country}}</span>
		 </div>
	   </div>
	   <div class="col-xs-6">
		 <div class=" form-group" >
			 <label> Total Users</label>
			   <span type="text" class="form-control stylefont" id="email" placeholder="Total Users" ng-model="TotalUsers"  style=" border: 0px solid;">{{TotalUsers}}</span>
			</div>
	     </div>
		    <div class="col-xs-6">
				<div class="form-group">
				<label for="inputsm">Starting Date</label>
				<span type="text" class="form-control stylefont" id="email"placeholder="Registration Date" ng-model="RegistrationDate" style=" border: 0px solid;">{{RegistrationDate}}</span>
				</div>
			</div>
		<div class="col-xs-6">
			<div class="form-group">
		     <label for="inputsm"> Ending Date</label>
			   <span type="text" class="form-control stylefont" ng-model="Subscriptionupto" >{{Subscriptionupto}}</span>
			</div>
		 </div>
		</div>
		  
			  <div class="row" >
					<div class="col-xs-6">
						<div class="form-group">
							<label for="inputsm"> User Limit</label>
							 <span type="text" class="form-control stylefont" ng-model="UserLimit" name="Users"  >{{UserLimit}}</span>
						</div>
					</div>
					<div class="col-xs-6">
						<div class="form-group">
							<label for="inputsm">Total User</label>
							 <span type="text" class="form-control stylefont" ng-model="UserLimit" name="Users"  >{{UserLimit}}</span>
						</div>
					</div>
			  </div>
		  
			  <!--<div class="row" >
				    <div class="col-xs-6">
						<div class="form-group">
							<label for="inputsm">Active User</label>
							<input class="form-control input-sm" id="puname"  type="text" value="<?php if(isset($myplan['activeUser'])){ echo $myplan['activeUser']; } ?>" readonly >
						</div>
					</div>
				
					<div class="col-xs-6">
						<div class="form-group">
							<label for="inputsm">Inactive User</label>
							<input class="form-control input-sm" id="puname"  type="text" value="<?php if(isset($myplan['inactiveUser'])){ echo $myplan['inactiveUser']; } ?>" readonly >
						</div>
					</div>
				
			  </div>-->
		  
               <button type="button" class="btn btn-success next-button1" id="btn2"data-toggle="dropdown" aria-expanded="false">Upgrade Plan</button>
          </div>
        </div>
		
		<div class="accordion_main alert4" id="info2">
          <div class="accordion_head">Select Currency </div>
          <div class="accordion_body2" style="display: none;">
				<div class="row" >
				    <div class="col-md-3" ></div>
					<div class="col-md-6">
						<div class="form-group">
							<div class="form-group">
								<!--<select class="form-control" id="currency" >
								   <option value="">Select Currency</option>
								   <option value="USD" >USD</option>
								   <option value="RS" >RS</option>
								</select>-->
								
								
			               <div>Currency</div>
			               <select class="form-control" ng-change="PaymentCurrency()" id="PaymentCurrency1" name="PaymentCurrency1"  ng-model="PaymentCurrency1" >
						  <option value=''>Select Currency</option>
						   <option value='RS'>RS</option>
						  <option value='USD'>USD</option>
					      </select>
				
                            </div>
						</div>
					</div>
					<div class="col-md-3" ></div>
			    </div>
            <button type="button" class="btn btn-success" id="continue"  data-toggle="dropdown" aria-expanded="false">Continue</button>
          </div>
        </div>
		
		<div class="accordion_main alert4" id="info3">
          <div class="accordion_head">Item Details</div>
			  <div class="accordion_body3" style="display: none;">
					<div class="row" id="forRs" >
					  <div class="col-md-1" ></div>
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
								<td><?php if(isset($myplan['package_price_inr_yr'])){ echo $myplan['package_price_inr_yr']; } ?></td>
							  </tr>
							</tbody>
					   </table>
					  </div>
					  <div class="col-md-1" ></div>
					</div>
					
					<div class="row" id="forUsd" >
					  <div class="col-md-1" ></div>
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
								<td>{{PaypalAmount}}</td>
							  </tr>
							</tbody>
					   </table>
					  </div>
					  <div class="col-md-1" ></div>
					</div>
				 <button type="button" class="btn btn-success" id="continue2"  data-toggle="dropdown" aria-expanded="false">Continue</button>
			  </div>	
        </div>
        
		<div class="accordion_main alert4" id="info4">
          <div class="accordion_head">Review Order</div>
          <div class="accordion_body4" style="display: none;">
				<div class="row" >
				    <div class="col-md-3" ></div>
					<!--<div class="col-md-6">
						<div class="form-group">
							<div class="form-group">
								<select class="form-control" id="months" >
								   <option value="">Select Months</option>
								   <option value="3" >3 Months</option>
								   <option value="6" >6 Months</option>
								   <option value="12" >12 Months</option>
								   <option value="24" >24 Months</option>
								</select>
                            </div>
						</div>
					</div>-->
					
					<div class="col-md-3">
		         <div>Subscription Period</div>
			       <select class="form-control" ng-change="month()" id="month" name="month"  ng-model="mymonth" >
						<option value="">Select Month</option>
						<option value='1'>1 Month</option>
						<option value='3'>3 Months</option>
						<option value='6'>6 Months</option>
						<option value='12'>12 Months</option>
					</select>
			 </div>
					<div class="col-md-3" ></div>
			    </div>
            <button type="button" class="btn btn-success" id="continue"  data-toggle="dropdown" aria-expanded="false">Continue</button>
          </div>
        </div>
      </div>
      
    </div>
    <!-- end .accordion_container -->
</form>
									</div>	
			 
	<form  class="form-horizontal" role="form" id="paypalForm" method="post" action="<?php echo PAYPAL_URL; ?>" > 
			<div ng-show="myPaypal">
				<input type="hidden" name="business" value="<?php echo PAYPAL_ID; ?>">
				<input type="hidden" name="cmd" value="_xclick">
				<input type="hidden" name="credits" value="510">
				<input type="hidden" name="userid" value="1">
				<input type="hidden" name="cpp_header_image" value="">
				<input type="hidden" name="no_shipping" value="1">
				<input type="hidden" name="handling" value="0">
				<input type="hidden" name="cancel_return" value="http://192.168.0.200/ubiattendance/index.php/Buypackage/vieworg/<?php echo $id; ?>?type=cancel">
				<input type="hidden" name="return" value="http://192.168.0.200/ubiattendance/index.php/Buypackage/vieworg/<?php echo $id; ?>?type=success">
	
			  <div class="form-group" hidden>
				<label class="control-label col-sm-2" for="amount">Amount</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" name="amount" placeholder="Enter Amount" required="required"  ng-model="PaypalAmount" >
				</div>
			  </div>
			  
			  <div class="form-group" hidden>
				<label class="control-label col-sm-2" for="currency">Quantity</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" name="quantity" placeholder="Enter Quantity" value="1" required="required">
				</div>
			  </div>
			  
			  <div class="form-group" hidden>
				<label class="control-label col-sm-2" for="currency">Currency</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" name="currency" placeholder="Enter Currency Type" value="<?php echo CURRENCY; ?>" required="required">
				</div>
			  </div>
			  
			  <div class="form-group" hidden>
				<label class="control-label col-sm-2" for="description">Description</label>
				<div class="col-sm-10">  
				  <textarea class="form-control" name="item_name" placeholder="Enter Description">My First Payment</textarea>
				</div>
			  </div>
			  
			  <div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
				  <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				  <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
				</div>
			  </div>
			  
            </div>
            </form>
			</div>
		   </div>
		   <div class="col-sm-2" ></div>
		   
		   
	</div>
</section>

<!-- This form for payumoney(strat) -->
<div class="row" id="payumoney" style="display:none;"  align="center"  >
  <div class="col-sm-2" ></div>
  <div class="col-sm-8" id="imgPayumoney" >
     <input type="text" class="form-control" name="amount" id="PayUAmount" style="display:none;" /> 
	 
  </div>
  <div class="col-sm-2" ></div>
</div>
<!-- This form for payumoney(end) -->

<!-- -->
</body>
   <script src="<?=URL?>../assets/js/jquery-3.1.0.min.js" type="text/javascript"></script>
	<script src="<?=URL?>../assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?=URL?>../assets/js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script src="<?=URL?>../assets/js/material.min.js" type="text/javascript"></script>
	<script src="<?php echo URL;?>../assets/js/angular.min.js" type="text/javascript"></script>
	<!--  Charts Plugin -->
	<script src="<?=URL?>../assets/js/chartist.min.js"></script>
	<!--  Notifications Plugin    -->
	<script src="<?=URL?>../assets/js/bootstrap-notify.js"></script>
	
	<script>
	$(document).ready(function () {
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
            $(".accordion_body1").slideUp(300);
            $(".accordion_body2").slideDown(300);
    }); 
	
	$("#continue").click(function(){
		 $(info3).show();
		if($('#currency').val() == ""){
		  	alert("Please select currency");
			return false;
		}
		if($('#currency').val() == 'RS'){
			$('#forUsd').hide();
		}else{
			$('#forRs').hide();
		}	
		$(".accordion_body2").slideUp(300);
        $(".accordion_body3").slideDown(300);
	})
	
	$("#continue2").click(function(){
		 $(info4).show();
		$(".accordion_body3").slideUp(300);
        $(".accordion_body4").slideDown(300);
	})
	
	$("#months").change(function(){
		// var d = new Date();
		// var d1 = d.getDate()+'-'+(d.getMonth()+1)+'-'+d.getFullYear();
		// alert(d1);   
		// return false;
		
		var addmonth = $(this).val();
		var x = addmonth; 
        var CurrentDate = new Date();
        CurrentDate.setMonth(CurrentDate.getMonth() + x);
		var CurrentDate = CurrentDate.getDate()+'-'+(CurrentDate.getMonth()+1)+'-'+CurrentDate.getFullYear();
		
		var lastdate = new Date();
		var lastdate = lastdate.getDate()+'-'+(lastdate.getMonth()+1)+'-'+lastdate.getFullYear();
		alert(lastdate);
		return false;
		
		var dateone = new Date(currendate2[2],currendate2[1],currendate2[0]); 
        var datetwo = new Date(lastdate[2],lastdate[1],lastdate[0]);
        var dayDif = (datetwo - dateone)  / 1000 / 60 / 60 / 24;
			 
			 
		
		// var currendate = new Date();
        // var currendate1 = currendate.getDate()+'-'+(currendate.getMonth())+'-'+currendate.getFullYear();	
		// alert(currendate1);
        // return false;		
	})
	
	
});

	</script>
	<script>
	var packageId = <?=$id?>;
    var app = angular.module('packageapp', []);
    app.controller('packageCtrl', function($scope, $http) {
			$scope.myPaypal=false;
			$scope.showimmediate=true;
			$scope.select=1;
			$scope.refno="";
			$scope.c_nmae="";
			$scope.orgName="";
			$scope.email="";
			$scope.PhoneNumber="";
			$scope.country="";
			var totalmoneyInRs = "";
			
	$scope.getallorg =function(){
	//	alert("hhh");
			$scope.hastrue=true;
			$http({
				url:'<?=URL?>Buypackage/getOrganizationData/'+$scope.ref_no+'/'+packageId,		
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			}).success(function (data, status, headers, config) {
					 $scope.orgName=data.orgName;
					 $scope.refno=data.ref_no;
					 $scope.c_nmae=data.c_nmae;
					 $scope.email=data.email;
					 $scope.PhoneNumber=data.PhoneNumber;
				     $scope.country=data.country;
				     $scope.TotalUsers=data.TotalUsers;
				     $scope.RegistrationDate=data.RegistrationDate;
					 $scope.Subscriptionupto=data.Subscriptionupto;
				     $scope.userUsd=data.userUsd;
				     $scope.userRs=data.userRs;
					  $scope.UserLimit=data.UserLimit;
				     $scope.BasicInUsd=data.BasicInUsd;
				     $scope.BasicInRs=data.BasicInRs;
				     $scope.hastrue=false;
					 if($scope.orgName=='')
					 {
						  //alert ("Please Enter Correct Refrence No.");
						  $(winfo).show();
						  
					
					 }
					 else{
						 $(info1).show();
					 }
					
			}).error(function (data, status, headers, config){
				     $scope.hastrue=false;
			});
	}
	$scope.getaorg =function(){
		$scope.hastrue=true;
		if($scope.org){
			for (var i=0; i<$scope.org.length; i++) {
				if($scope.org[i]['ref_no']==$scope.ref_no)
				{
					$scope.ref_no=$scope.org[i]['ref_no'];
					$scope.c_nmae=$scope.org[i]['c_nmae'];
					$scope.orgname=$scope.org[i]['orgname'];
					$scope.email=$scope.org[i]['email'];
				}
			}
		}
	}
	$scope.getcur = function(){
		var id = <?php echo $id ?>;
		$http({
				url:'<?=URL?>Buypackage/getPackageData1/'+id,		
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			}).success(function (data, status, headers, config) {
				if($scope.myValue == 1){
					$scope.myPaypal=false;
					$('#sts').html("<option value=''>Select Price</option>"+"<option value="+data.package_price_inr_yr+">"+data.package_price_inr_yr+" INR/Yr</option>"+"<option value="+data.package_price_inr_hy+">"+data.package_price_inr_hy+" INR/Hr</option>"+"<option value="+data.package_price_inr_qt+">"+data.package_price_inr_qt+" INR/qr</option>"+"<option value="+data.package_price_inr_mt+">"+data.package_price_inr_mt+" INR/Pm</option>");
				}else{
					$scope.myPaypal=true;
					$('#sts').html("<option value=''>Select Price</option>"+"<option value="+data.package_price_usd_yr+">"+data.package_price_usd_yr+" USD/Yr</option>"+"<option value="+data.package_price_usd_hy+">"+data.package_price_usd_hy+" USD/Hr</option>"+"<option value="+data.package_price_usd_qt+">"+data.package_price_usd_qt+" USD/qr</option>"+"<option value="+data.package_price_usd_mt+">"+data.package_price_usd_mt+" USD/Pm</option>");
						$scope.Price = function(){
							$scope.PaypalAmount = $scope.myPrice;
						//alert();
						}
				}
				return false;
			}).error(function (data, status, headers, config){
				     $scope.hastrue=false;
			});
	}
	$scope.month= function(){
           var addmonth = $scope.mymonth;
           var addmonth = parseInt(addmonth);
		   var d = new Date();
           d.setMonth(d.getMonth() + addmonth);
		   var d1 = d.getDate()+'-'+(d.getMonth())+'-'+d.getFullYear();
		   $scope.Subscriptionupto=d1;
		   var userUsd = $scope.userUsd/365;
		   var userRs = $scope.userRs/365;
		  
		   <!-- Date difference and to get a days(strat)-->	
             var currendate = new Date();
             var currendate1 = currendate.getDate()+'-'+(currendate.getMonth())+'-'+currendate.getFullYear();		   
		     var currendate2 = currendate1.split("-");
		     var lastdate = d1.split("-");
		     var dateone = new Date(currendate2[2],currendate2[1],currendate2[0]); 
             var datetwo = new Date(lastdate[2],lastdate[1],lastdate[0]);
             var dayDif = (datetwo - dateone)  / 1000 / 60 / 60 / 24;
			 var BasicPrizeInUsd = $scope.BasicInUsd;
			 var BasicPrizeInRs = $scope.BasicInRs;
			 <!-- Date difference and to get a days(end)-->
			 var totalmoneyInUsd = parseInt(BasicPrizeInUsd)  + userUsd*$scope.Users*dayDif;
			 var totalmoneyInRs =  parseInt(BasicPrizeInRs)+ userRs*$scope.Users*dayDif;
		     $scope.PaypalAmount = totalmoneyInUsd;
             $('#PayUAmount').val(totalmoneyInRs);
			  
	}
    $scope.PaymentCurrency = function(){
		if($scope.PaymentCurrency1 == 'USD'){
			$scope.myPaypal=true;
		}else{
			var totalmoneyInRs = $('#PayUAmount').val();  
			$('#imgPayumoney').html('<a href="<?php echo URL;?>Buypackage/PayuMoney/'+totalmoneyInRs+'" ><img class="img-rounded" src="<?php echo URL;?>../assets/img/payumoney.png" style="max-width:100px; "><a>');
			$('#payumoney').show();
			
		}
		// return false;
	}
 $('#btn1').click(function(){
			//$('.buyclose').fadeOut(1000);
		 $(info1).show();
			
		});	
$('#btn2').click(function(){
			//$('.buyclose').fadeOut(1000);
 $(info2).show();
			});
})
	</script>
</html>