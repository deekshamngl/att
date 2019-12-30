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
</style>
</head>
<body style="background-color:offwhite;" ng-app="packageapp"   ng-controller="packageCtrl" >
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


<div class="row">				
				  <div class="box">
	                     <div class="box-header with-border" data-background-color="green" style="background-color:purple; height:40px;">
	                           <h4 class="category" style="color:white;" align="center" ><?php echo $title; ?></h4>       
	                      </div>
	               <div class=" " style="background-color:white; border-color: purple; border-style: solid; border-width: 2px;" >
      <div class="col-sm-4">
	  </div>
	  <div class="col-sm-4">		   
		    <form  class="form-horizontal" role="form" id="paypalForm" method="post" action="<?php echo PAYPAL_URL; ?>" > 
		
				<div class="form-group ">	
					<label class="col-sm-5 control-label">
					Enter Refrence Id<span class="red"></span>
					</label>
					<div class="col-sm-7" >
					  <input type="text" id="refno"  ng-model="ref_no"  ng-blur="getallorg()" name="refno" class="form-control" >
				    </div>
				</div>
					 
		        <div class="row">				
					<div class="col-sm-10">
						<label class="col-sm-5 text-right">Refrence No :</label>
						<div ng-model="refno">{{refno}}</div>
					</div></br>
													
													
					<div class="col-sm-10">
						<label class="col-sm-5 text-right">Consulting Person :</label>
						<div ng-model="c_nmae">{{c_nmae}}</div>
					</div>
					</br>
													
					<div class="col-sm-10">
						<label class="col-sm-5 text-right">Organization Name:</label>
						<div ng-model="orgName">{{orgName}}</div>
					</div></br>
													
					<div class="col-sm-10">
						<label class="col-sm-5 text-right">Email :</label>
						<div ng-model="email">{{email}}</div>
					</div></br>
													
					<div class="col-sm-10">
						<label class="col-sm-5 text-right">contact No :</label>
						<div ng-model="PhoneNumber">{{PhoneNumber}}</div>
					</div></br>
					
					<div class="col-sm-10">
						<label class="col-sm-5 text-right">Country :</label>
						<div ng-model="country">{{country}}</div>
					</div></br>
					
					<div class="col-sm-10">
						<label class="col-sm-5 text-right">Total Users :</label>
						<div ng-model="TotalUsers">{{TotalUsers}}</div>
					</div></br>
					
					<div class="col-sm-10">
						<label class="col-sm-5 text-right">Registration Date:</label>
						<div ng-model="RegistrationDate">{{RegistrationDate}}</div>
					</div></br>
					
					
					
					
					<div class="form-group ">	
						<label class="col-sm-3 control-label">
						Users<span class="red"></span>
						</label>
						<div class="col-sm-7" >
						  <input type="text" id="Users" ng-model="Users" name="Users" class="form-control" >				
						</div>
				    </div><br>
													
					<div class="col-sm-10">
								<div class="col-sm-6">
								   <label class="control-label">Subscription For<span class="red"> *</span></label>
									  <select class="form-control" ng-change="month()" id="month" name="month"  ng-model="mymonth" >
										<option value="">Select Month</option>
										<option value='1'>1 Month</option>
										<option value='3'>3 Month</option>
										<option value='6'>6 Month</option>
										<option value='12'>12 Month</option>
									  </select>
								</div>
					</div><br>
					
					<div class="col-sm-10">
						<label class="col-sm-7 text-right">Subscription Upto:</label>
						<div ng-model="Subscriptionupto">{{Subscriptionupto}}</div>
					</div></br>
									
				</div>
													
														
							<div class="row">	
								<label class="col-sm-6"></label>
									<!--<div class="col-sm-10">
										<div class="col-sm-6">
					                       <label class="control-label">Select Currency<span class="red"> *</span></label>
						                      <select class="form-control" ng-change="getcur()" id="cur" name="cur"  ng-model="myValue" >
						                        <option value="">Select Currency</option>
												<option value='1'>INR</option>
												<option value='2'>USD</option>
											  </select>
					                    </div>
									</div>
									<div  class="col-sm-10">
										<div class="col-sm-6">
										  <label class="control-label">Select Package<span class="red"> *</span></label>
										   <select class="form-control" id="sts" name="sts" ng-model="myPrice" ng-change="Price()" >
											</select>
										</div>
									</div><br>-->
												
								<div class="overlay" ng-show="hastrue" id="refno">
					              <i class="fa fa-cog fa-spin"></i>
					               <div style="padding:40% 10%;"><h4>Loading...Please wait..</h4></div>
					            </div>			
			                </div>
			
			        <!-- -->
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
    <label class="control-label col-sm-2" for="amount">Amount:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="amount" placeholder="Enter Amount" required="required" value="10" ng-model="PaypalAmount" >
    </div>
  </div>
  <div class="form-group" hidden>
    <label class="control-label col-sm-2" for="currency">Quantity:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="quantity" placeholder="Enter Quantity" value="1" required="required">
    </div>
  </div>
  <div class="form-group" hidden>
    <label class="control-label col-sm-2" for="currency">Currency:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="currency" placeholder="Enter Currency Type" value="<?php echo CURRENCY; ?>" required="required">
    </div>
  </div>
  <div class="form-group" hidden>
    <label class="control-label col-sm-2" for="description">Description:</label>
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
			 
			      <div class="clearfix"></div>			
	                </div>
	                        </div>

</div>
 <form class="form-horizontal" role="form" id="paypalForm" method="post" action="<?php echo PAYPAL_URL; ?>">
 
</form>
</section>
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
	<script src="<?=URL?>../assets/js/jquery-3.1.0.min.js" type="text/javascript"></script>
	<script>
	var packageId = <?=$id?>;
	alert(packageId);
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
			
	        $scope.getallorg =function(){
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
				     $scope.userUsd=data.userUsd;
				     $scope.hastrue=false;
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
		   var d1 = d.getDate()+'-'+(d.getMonth()+1)+'-'+d.getFullYear();
		   $scope.Subscriptionupto=d1;
		   var userUsd = $scope.userUsd/365;
		  
		   <!-- Date difference and to get a days(strat)-->	
             var currendate = new Date();
             var currendate1 = currendate.getDate()+'-'+(currendate.getMonth()+1)+'-'+currendate.getFullYear();		   
		     var currendate2 = currendate1.split("-");
		     var lastdate = d1.split("-");
		     var dateone = new Date(currendate2[2],currendate2[1],currendate2[0]); 
             var datetwo = new Date(lastdate[2],lastdate[1],lastdate[0]);
             var dayDif = (datetwo - dateone)  / 1000 / 60 / 60 / 24;
			 <!-- Date difference and to get a days(end)-->
			 //alert(userUsd);
			 var totalmoney = userUsd*$scope.Users*dayDif;
			 
           //alert(totalmoney);
		   $scope.myPaypal=true;
		   $scope.PaypalAmount = totalmoney;		   
	}			
})
	
	
	</script>
	
	
</html>