
<?php
	$paypalUrl='https://www.sandbox.paypal.com/cgi-bin/webscr';
	$paypalId='abhinavsengar.cs@gmail.com';
   /*
   *  @author   Gopal Joshi
   *  @wesite   www.sgeek.org
   *  @about    PayUMoney Payment Gateway integration in PHP
   */
	$merchant_key  = "gtKFFx";
	$salt          = "eCwWELxi";
	$payu_base_url = "https://test.payu.in"; // For Test environment
	$action        = '';
	$currentDir	   = 'http://localhost/creative/payment/payumoney/';
	$posted = array();
	if(!empty($_POST)) {
	  foreach($_POST as $key => $value) {    
	    $posted[$key] = $value; 
	  }
	}

	$formError = 0;
	if(empty($posted['txnid'])) {
	  $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
	} else {
	  $txnid = $posted['txnid'];
	}

	$hash         = '';
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
	  ){
	    $formError = 1;

	  } else {
	   	$hashVarsSeq = explode('|', $hashSequence);
	    $hash_string = '';	
		foreach($hashVarsSeq as $hash_var) {
	      $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
	      $hash_string .= '|';
	    }
	    $hash_string .= $salt;
	    $hash = strtolower(hash('sha512', $hash_string));
	    $action = $payu_base_url . '/_payment';
	  }
	} elseif(!empty($posted['hash'])) {
	  $hash = $posted['hash'];
	  $action = $payu_base_url . '/_payment';
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
	<title>My Plan</title>
	<style type="text/css">
.hover{background-color: #cc0000}
.authorBlock{border-top:1px solid #cc0000;}
</style>
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
</head>
<body onload="submitPayuForm()" >

	<div class="wrapper">
		<?php
			$data['pageid']=11.1;
			$this->load->view('menubar/sidebar');
		?>
	    <div class="main-panel">
			<?php
				$this->load->view('menubar/navbar');
			?>
			<div class="content ">
				<div class="container-fluid center">
					<div class="row">
						<div class="col-lg-6 col-md-12">	
						</div>
						<div class="col-md-11">
							<div class="card valign">
	                            <div class="card-header" data-background-color="orange">
									<div class="nav-tabs-navigation">
										<div class="nav-tabs-wrapper">
										
											<h6 class="nav-tabs-title">My Plan</h6>
											
										</div>
									</div>
	                         <!--       <p class="category">Employee(s) are on Break currently. </p>-->
							 
	                            </div>
	                            <div class="card-content table-responsive">
								<div class="row">
								<div class="col-md-6">
								<div class="form-group">
								  <label for="inputsm">Start date</label>
								  <input class="form-control input-sm datepicker " id="cpname"  type="text" value="<?php if(isset($myplan['start_date'])){ echo $myplan['start_date']; } ?>"  readonly >
								</div>
								
								</div>
								
								<div class="col-md-6">
								<div class="form-group">
								  <label for="inputsm">End date</label>
								  <input class="form-control input-sm datepicker" id="cpwebsite"  type="text"  value="<?php if(isset($myplan['end_date'])){ echo $myplan['end_date']; } ?>" readonly >
								</div>
								</div>
								</div>
								
								<div class="row">
								<div class="col-md-6">
								<div class="form-group">
								  <label for="inputsm">Users Limit</label>
								  <input class="form-control input-sm" id="pname"  type="text" value="<?php if(isset($myplan['user_limit'])){ echo $myplan['user_limit']; } ?>" readonly >
								</div>
								</div>
								<div class="col-md-6">
								<div class="form-group">
								  <label for="inputsm"> Total User</label>
								  <input class="form-control input-sm" id="puname"  type="text" value="<?php if(isset($myplan['totalUser'])){ echo $myplan['totalUser']; } ?>" readonly >
								</div>
									</div>
									</div>
									<div class="row">
									<div class="col-md-6">
								<div class="form-group">
								  <label for="inputsm">Active User</label>
								  <input class="form-control input-sm" id="cppnumber"  type="text" value="<?php if(isset($myplan['activeUser'])){ echo $myplan['activeUser']; } ?>" readonly >
								</div>
								</div>
								<div class="col-md-6">
								<div class="form-group">
								  <label for="inputsm">Inactive User</label>
								  <input class="form-control input-sm" id="cpemail"  type="text" value="<?php if(isset($myplan['inactiveUser'])){ echo $myplan['inactiveUser']; } ?>" readonly >
								</div>
								</div>
								
								<button style="float: right;" data-background-color="orange" class="btn btn-sm btn-success" id="upgrade_plan" type="button" >Upgrade Plan</button>
								</div>
	                            </div>
	                        </div>
						</div>
					</div>
				</div>
			</div>

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
<a href="#"  id="notificationButton" class="button" hidden >Attendance</a>
<a href="#"  id="timeBreakNotification" class="button" hidden >Attendance</a>
<!-- Upgrade plan start-->
<div id="delAtt" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
        <h4 class="modal-title" id="title">Upgrade Plan : <?php echo $myplan['PerUserPlan'] ?>   Per User for one year</h4>
      </div>
      <div class="modal-body">		
			<input type="hidden" id="del_aid" />
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
                        <input type="number" class="form-control" id="users" placeholder="Enter no. of user ">
                    </div>
				</div>
			    <div class="col-md-6">
					<div class="form-group">
						<select class="form-control" id="currency" >
						   <option>Select Currency</option>
						   <option value="USD" >USD</option>
						   <option value="RS" >RS</option>
						</select>
                    </div>
				</div>
			<!-- PRICE ITEM -->
			</div>
			<div class="row" align="center" >
			  <button class="btn btn-danger" id="pay" >Pay</button>
			</div>
			<!-- this form for paypal (start) -->
			<div class="row" id="paypal" align="center" style="display:none;">
			  <form action="<?php echo $paypalUrl; ?>" method="post" name="frmPayPal1">
					<div class="panel price panel-red">
						    <input type="hidden" name="business" value="<?php echo $paypalId; ?>">
						    <input type="hidden" name="cmd" value="_xclick">
						    <input type="hidden" name="item_name" value="It Solution Stuff">
						    <input type="hidden" name="item_number" value="2">
						    <input type="hidden" name="amount" id="amount" >
						    <input type="hidden" name="no_shipping" value="1">
						    <input type="hidden" name="currency_code" value="USD">
						    <input type="hidden" name="cancel_return" value="<?=URL?>MyPlan/failed">
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
	  <!-- This form for payumoney(start) -->
		<div id="payumoney1" style="display:none;" >
		   <?php if($formError) { ?>
			  <span style="color:red">Please fill all mandatory fields.</span>
			  <br/>
			  <br/>
           <?php } ?>
				<form action="<?php echo $action; ?>" method="post" name="payuForm" id="submit_payumoney" >
				  <input type="hidden" name="key" value="<?php echo $merchant_key ?>" />
				  <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
				  <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
				  <table>
					<tr hidden>
					  <td><b>Mandatory Parameters</b></td>
					</tr>
					<tr hidden>
					  <td>Amount <span class="mand">*</span>: </td>
					  <td><input name="amount" type="number" id="payumoney_amount" value="5000" /></td>
					  <td>First Name <span class="mand">*</span>: </td>
					  <td><input type="text" name="firstname" id="firstname" value="Palash gupta" /></td>
					</tr>
					<tr hidden>
					  <td>Email <span class="mand">*</span>: </td>
					  <td><input type="email" name="email" id="email" value="palash@ubitechsolutions.com" /></td>
					  <td>Phone <span class="mand">*</span>: </td>
					  <td><input type="text" name="phone" value="9584271783" /></td>
					</tr>
					<tr hidden  >
					  <td>Product Info <span class="mand">*</span>: </td>
					  <td colspan="3"><textarea name="productinfo">hello world</textarea></td>
					</tr>
					<tr hidden >
					  <td>Success URL <span class="mand">*</span>: </td>
					  <td colspan="3"><input type="text" name="surl" value="http://192.168.0.200/ubiattendance/index.php/MyPlan" size="64" /></td>
					</tr>
					<tr hidden >
					  <td>Failure URL <span class="mand">*</span>: </td>
					  <td colspan="3"><input type="text" name="furl" value="http://192.168.0.200/ubiattendance/index.php/MyPlan" size="64" /></td>
					</tr>
					<tr hidden >
					  <td colspan="3"><input type="hidden" name="service_provider" value="" size="64" /></td>
					</tr>
					<tr hidden >
					  <td><b>Optional Parameters</b></td>
					</tr>
					<tr hidden >
					  <td>Last Name: </td>
					  <td><input type="text" name="lastname" id="lastname" value="<?php echo (empty($posted['lastname'])) ? '' : $posted['lastname']; ?>" /></td>
					  <td>Cancel URI: </td>
					  <td><input type="text" name="curl" value="" /></td>
					</tr>
					<tr hidden >
					  <td>Address1: </td>
					  <td><input type="text" name="address1" value="<?php echo (empty($posted['address1'])) ? '' : $posted['address1']; ?>" /></td>
					  <td>Address2: </td>
					  <td><input type="text" name="address2" value="<?php echo (empty($posted['address2'])) ? '' : $posted['address2']; ?>" /></td>
					</tr>
					<tr hidden >
					  <td>City: </td>
					  <td><input type="text" name="city" value="<?php echo (empty($posted['city'])) ? '' : $posted['city']; ?>" /></td>
					  <td>State: </td>
					  <td><input type="text" name="state" value="<?php echo (empty($posted['state'])) ? '' : $posted['state']; ?>" /></td>
					</tr>
					<tr hidden >
					  <td>Country: </td>
					  <td><input type="text" name="country" value="<?php echo (empty($posted['country'])) ? '' : $posted['country']; ?>" /></td>
					  <td>Zipcode: </td>
					  <td><input type="text" name="zipcode" value="<?php echo (empty($posted['zipcode'])) ? '' : $posted['zipcode']; ?>" /></td>
					</tr>
					<tr hidden >
					  <td>UDF1: </td>
					  <td><input type="text" name="udf1" value="<?php echo (empty($posted['udf1'])) ? '' : $posted['udf1']; ?>" /></td>
					  <td>UDF2: </td>
					  <td><input type="text" name="udf2" value="<?php echo (empty($posted['udf2'])) ? '' : $posted['udf2']; ?>" /></td>
					</tr>
					<tr hidden >
					  <td>UDF3: </td>
					  <td><input type="text" name="udf3" value="<?php echo (empty($posted['udf3'])) ? '' : $posted['udf3']; ?>" /></td>
					  <td>UDF4: </td>
					  <td><input type="text" name="udf4" value="<?php echo (empty($posted['udf4'])) ? '' : $posted['udf4']; ?>" /></td>
					</tr>
					<tr hidden >
					  <td>UDF5: </td>
					  <td><input type="text" name="udf5" value="<?php echo (empty($posted['udf5'])) ? '' : $posted['udf5']; ?>" /></td>
					  <td>PG: </td>
					  <td><input type="text" name="pg" value="<?php echo (empty($posted['pg'])) ? '' : $posted['pg']; ?>" /></td>
					</tr>
					<tr hidden>
					  <?php if(!$hash) { ?>
						<td colspan="4"><input type="submit" value="Submit" /></td>
					  <?php } ?>
					</tr>
				  </table>
				</form>
		</div>
		  
	  <!-- This form for payumoney(end)-->
	  <div class="row" id="payumoney" align="center" style="display:none;" >
		 <button  href="#"><img class="img-rounded" src="../assets/img/payumoney.png" style="max-width:100px; "/></button>				
	  </div>
      <div class="modal-footer">
        <button type="button" id="delete"  class="btn btn-warning">Delete</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Upgrade plan end-->
</body>
<script type="text/javascript">

$( ".datepicker" ).datepicker({
	dateFormat: 'dd-mm-yy'
});
</script>
<script type="text/javascript">
$('#proile').click(function(){
	var pname = $('#pname').val();
	var puname = $('#puname').val();
	var pemail = $('#pemail').val();
	$.ajax({url: "<?php echo URL ?>/dashboard/updateProfile",
    data: {'pname':pname,'puname':puname,'pemail':pemail},
	success: function(result){
        if(result == 1){
		  doNotify('top','center',2,'Profile updated successfully.');
			   setTimeout(location.reload.bind(location), 1000);
		  }else{
			  doNotify('top','center',4,'some error occurs.');
			  setTimeout(location.reload.bind(location), 2000);
			  alert('false');
		  }
    }});
}) 

$('#upgrade_plan').click(function(){
	$('#delAtt').modal('show');
	//var plan = '<?php $myplan['PerUserPlan'] ?>';
	//alert(plan);
	return false;
	var cpname = $('#cpname').val();
	var cpwebsite = $('#cpwebsite').val();
	var pname = $('#pname').val();
	var puname = $('#puname').val();
	var cppnumber = $('#cppnumber').val();
	var cpemail = $('#cpemail').val();
	var cpaddress = $('#cpaddress').val();
	
	$.ajax({url: "<?php echo URL ?>/dashboard/updateCProfile",
    data: {'cpname':cpname,'cpwebsite':cpwebsite,'cppnumber':cppnumber,'pname':pname,'puname':puname,'cpemail':cpemail,'cpaddress':cpaddress},
	success: function(result){
        if(result == 1){
		  doNotify('top','center',2,'Company profile updated successfully.');
			   setTimeout(location.reload.bind(location), 1000);
		  }else{
			  doNotify('top','center',4,'some error occurs.');
			   setTimeout(location.reload.bind(location), 2000);
			  alert('false');
		  }
    }});
})
</script>
<script>
$(function(){ 
$('#pay').click(function(){
 var user = $('#users').val();	
	if(user == ""){
		doNotify('top','center',4,'Please enter no. of users');
		 return false;
	}
	var currency = $('#currency').val();
	if(currency == ""){
	   doNotify('top','center',4,'Please select currency');
		 return false;	
	}
	if(currency == "USD"){
		$('#paypal').show();
		$('#payumoney').hide();
	}else{
		$('#paypal').hide();
		$('#payumoney').show();
	}
			
	var status = '<?php echo $myplan['status'] ?>';
	var per_user_inr = '<?php echo $myplan['per_user_inr'] ?>';
    var days = '<?php echo $myplan['days'] ?>';
    var package_price_inr_yr = '<?php echo $myplan['package_price_inr_yr'] ?>';
    var package_price_usd_yr = '<?php echo $myplan['package_price_usd_yr'] ?>';
    var plan = '<?php echo $myplan['PerUserPlan'] ?>';
	var planInRs = per_user_inr/365;
    var paymentInRs = user*days*planInRs;
    $('#payumoney_amount').val(Math.round(paymentInRs));
    //var payumoney_amount = $('#payumoney_amount').val(5000);
	var plan = plan/365;
	var payment = user*days*plan;
	$('#amount').val(payment);
	var success = '<?=URL?>MyPlan/success/'+user;
	$('#success').val(success);
})
    $('#payumoney').click(function(){
    var paymentInRs = $('#payumoney_amount').val();
	var paymentInRs = '<?=URL?>Buypackage/PayuMoney/'+paymentInRs;
    window.location.assign(paymentInRs)
	//return false;	
	//$("#submit_payumoney").submit();
    })	
})

</script>
</html>