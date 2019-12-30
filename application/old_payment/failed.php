<?php
$status=isset($_POST["status"])?$_POST["status"]:0;
$firstname=isset($_POST["firstname"])?$_POST["firstname"]:'0';
$amount=isset($_POST["amount"])?$_POST["amount"]:'0';
$txnid=isset($_POST["txnid"])?$_POST["txnid"]:'0';
$posted_hash=isset($_POST["hash"])?$_POST["hash"]:'0';
$key=isset($_POST["key"])?$_POST["key"]:'0';
$productinfo=isset($_POST["productinfo"])?$_POST["productinfo"]:'0';
$email=isset($_POST["email"])?$_POST["email"]:'0';
$salt="e5iIg1jwi8";
//echo 'status: '.$status;
//print_r($productinfo);
	$_SESSION['paid_in']='';
 	$_SESSION['plan_users']='';
 	$_SESSION['package']='';
	$_SESSION['plan']='';
	$_SESSION['addon_users']='';
	$_SESSION['addon_amt']='';
	$_SESSION['discount_amt']='';
	$_SESSION['tax']='';
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
///////---------------
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {
      if(hash == '') { 
        return; 
      }
      var payuForm = document.forms.payuForm; 
	  return false;
      payuForm.submit();
    }
  </script>
</head>
<body onload="submitPayuForm()" >

	<div class="wrapper">
		<?php
			$data['pageid']=12.1;
			$this->load->view('menubar/sidebar');
		?>
	    <div class="main-panel">
			<?php
				$this->load->view('menubar/navbar');
			?>
			
			<div class="content">
				<div class="container-fluid center">
					<div class="row">
						<div class="col-lg-6 col-md-12">	
						</div>
						<div class="col-md-11">
							<div class="card valign">
	                            <div class="card-header" data-background-color="orange">
									<div class="nav-tabs-navigation">
										<div class="nav-tabs-wrapper">
											<h6 class="nav-tabs-title">Transaction Failed </h6>
										</div>
								</div>
								<div class="card-content table-responsive">
								<div class="row">
								<?php		
		If (isset($_POST["additionalCharges"])) {
		   $additionalCharges=$_POST["additionalCharges"];
			$retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
			
                  }
		else {	  

			$retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;

			 }
			 $hash = hash("sha512", $retHashSeq);
	  
		   if ($hash != $posted_hash) {
			   echo "Invalid Transaction. Please try again";
			   }
		   else {

			 echo "<h3>Your order status is ". $status .".</h3>";
			 echo "<h4>Your transaction id for this transaction is ".$txnid.".  Try Later.</h4>";
			 
          
		 } 
?>
							            </div>
									 </div>
	                            </div>
							</div>
						</div>
					<div class="col-lg-6 col-md-12">	
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
					<p class="copyright pull-right">
						&copy; <script>document.write(new Date().getFullYear())</script> <a href="#">DESIGNED BY</a> ubitech solutions pvt. ltd.
					</p>
				</div>
			</footer>
		</div>
	</div>
</body>
<script>

	
  
</script>
</html>