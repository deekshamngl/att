<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<script src="https://www.paypalobjects.com/api/checkout.js"></script>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>ubiAttendance</title>
	<style type="text/css">
</style>
</head>
<body>

	<div class="wrapper">
		<?php
			$data['pageid']=12.1;
	//		$this->load->view('menubar/sidebar');
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
				<h6 class="nav-tabs-title">Transaction Success </h6>
				</div>
				</div>
	             </div>
								<div class="container-fluid">
								<br/>
								<div>
									<h3>Thank You... <?php echo $firstname; ?>, you just completed your payment.</h3>
									<p>
										Congratulations! Your payment has been successfully received & you have updated your plan. Your transaction details are:
									</p>
									<ul>
										<li><b>Name:</b> <?php echo $firstname; ?></li>
										<li><b>Transaction status:</b> <?php echo 'success'; ?></li>
										<li><b>Transaction Id:</b> <?php echo $txnid; ?></li>
										<li><b>Transaction Date & Time:</b> <?php echo date('d-M-Y h:ia'); ?></li>
										<li><b>Payment Amount:</b> <?php echo $cur.' '.
										($amount+$tax); ?></li>
										
									</ul>
									<p>
									
										<a href="<?php echo URL.'cron/generateInvoice?id='.base64_encode($txnid); ?>" target="_blank">Click here</a> to generate your <a href="<?php echo URL.'cron/generateInvoice?id='.base64_encode($txnid); ?>" target="_blank">invoice</a>.
									</p>
									<p>
										Please save your transaction details for any query related to this request. We’ll send a confirmation mail to <?php echo $email;?> with transaction details & a link to generate invoice.
									</p>
									<p>
									Please add our email address i.e. noreply@ubiattendance.com & support@ubitechsolutions.com to your address book. So that you don’t miss any of our mails or contact us on +91 - 7024077050.
									</p>
									<p>
									<?php /* $arr=array();
											$arr['firstname']=$firstname;
											$arr['amount']=$amount;
											$arr['txnid']=$txnid;
											$arr['country']=$country;
											$arr['state']=$state;
											$arr['city']=$city;
											$arr['zip']=$zip;
											$arr['street']=$street;
											$arr['contact']=$contact;
											$arr['cur']=$cur;
											$arr['plan_users']=$plan_users;
											$arr['gstin']=$gstin;
											$arr['addon_amt']=$addon_amt;
											$arr['addon_users']=$addon_users;
											$arr['plan']=$plan;
											$arr['package']=$package;
											$arr['email']=$email;
											$_SESSION['invoice']=$arr;
									*/?> 
		<!--	<a href="<?php echo URL."Myplan/generateInvoice/".$txnid;?>" target='_blank'>Click here</a> to generate the invoice.-->
									</p>
								</div>
										<?php /*
											echo "\n status:".$status;
											echo "\n firstname:".$firstname;
											echo "\n amount:".$amount;
											echo "\n txnid:".$txnid;
											echo "\n country:".$country;
											echo "\n state:".$state;
											echo "\n city:".$city;
											echo "\n zip:".$zip;
											echo "\n street:".$street;
											echo "\n contact:".$contact;
											echo "\n cur:".$cur;
											echo "\n plan_users:".$plan_users;
											echo "\n package:".$package;
											echo "\n plan:".$plan;
											echo "\n addon_users:".$addon_users;
											echo "\n addon_amt:".$addon_amt;
											echo "\n gstin:".$gstin;
										$data['cur']=$cur;
			*/
			?>
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
</html>