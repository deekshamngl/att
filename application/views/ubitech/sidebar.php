<html>
<head>
	<style>
		.active1 a {
			
			background-color: none;
			
		}
		.activeall{
			color: #9c27b0;
			font-size:15px;
			font-weight: bold;
		}
		#navid li > a {
    margin: 0px 5px;
		}

	</style>
</head>
<body>
<div class="sidebar" data-color="purple" data-image="">
			<!--
		        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

		        Tip 2: you can also add an image using data-image tag
		    -->
          
			<div class="logo" style="text-align: center;">
				<!-- <a href="<?=URL?>dashboard" class="simple-text"> -->
					<img src="<?=URL?>../assets/img/logo.png" alt="Ubitech" height="85px" width="150px"/>
				<!-- </a> -->
			</div>

	    	<div class="sidebar-wrapper">
	            <ul class="nav">
	               <!--  <li <?php if(isset($pageid) and $pageid==1)echo 'class="active"'; ?>>
	                    <a href="<?=URL?>ubitech/dashboard">
	                        <i class="material-icons">dashboard</i>
	                        <p>Dashboard</p>
	                    </a>
	                </li> -->
	                <li <?php if(isset($pageid) and ($pageid==3 || $pageid==3.1|| $pageid==3.2 || $pageid==3.3|| $pageid==3.4|| $pageid==3.5|| $pageid==3.6|| $pageid==3.7|| $pageid==3.8|| $pageid==3.9|| $pageid==3.11||$pageid==3.12||$pageid==3.13 ||$pageid==3.14 ))echo 'class="active "';?>>
					<a  data-toggle="collapse" data-target="#reportmenu" data-parent="#sidenav01" class="collapsed" style="cursor: pointer;">
					<i class="material-icons">unarchive</i>
	                        <p>Organizations</p>
	                   </a>
				</li> 
			  <div <?php if(isset($pageid) and ($pageid==3 || $pageid==3.1 || $pageid==3.2|| $pageid==3.3|| $pageid==3.4|| $pageid==3.5|| $pageid==3.6|| $pageid==3.7|| $pageid==3.8|| $pageid==3.9|| $pageid==3.11|| $pageid==3.13 || $pageid==3.14)) 
				echo 'class="collapse in" aria-expanded="true" style="height: 530px;margin-left:10%"'; else echo 'class="collapse" aria-controls="navbar" aria-expanded="false" style="height: 0px;margin-left:10%"'; ?> id="reportmenu" style="height: 0px;margin-left:10%;">
	                    
						<ul class="nav nav-list" style="margin-top:-4px;" id="navid">

							<li <?php if(isset($pageid) and $pageid==3.14)echo 'class="active1 "'; ?>><a href="<?= URL ?>ubitech/organization/addorg" <?php if(isset($pageid) and $pageid==3.14)echo 'class="activeall" style="color: #9c27b0;"'; ?>>Add Organization </a></li>
						  
						        <li <?php if(isset($pageid) and $pageid==3.5)echo 'class="active1 "'; ?>><a href="<?= URL ?>ubitech/organization" <?php if(isset($pageid) and $pageid==3.5)echo 'class="activeall" style="color: #9c27b0;"'; ?>>All </a></li>
								
								<li <?php if(isset($pageid) and $pageid==3.1)echo 'class="active1 "'; ?>><a href="<?=URL?>ubitech/organization/trial" <?php if(isset($pageid) and $pageid==3.1)echo 'class="activeall" style="color: #9c27b0;"'; ?>>Trial  </a></li>
								
								<li <?php if(isset($pageid) and $pageid==3.3)echo 'class="active1 "'; ?>><a href="<?=URL?>ubitech/organization/extendtrial" <?php if(isset($pageid) and $pageid==3.3)echo 'class="activeall" style="color: #9c27b0;"'; ?>>Extended Trial</a></li>
								
								<li <?php if(isset($pageid) and $pageid==3.2)echo 'class="active1 "'; ?>><a href="<?=URL?>ubitech/organization/expiretril" <?php if(isset($pageid) and $pageid==3.2)echo 'class="activeall" style="color: #9c27b0;"'; ?>>Expired Trial</a></li>
								
						        
								
								
								
								 <li <?php if(isset($pageid) and $pageid==3)echo 'class="active1 "'; ?>><a href="<?= URL?>ubitech/organization/paid" <?php if(isset($pageid) and $pageid==3)echo 'class="activeall" style="color: #9c27b0;"'; ?>>Premium - Standard</a></li>
								 
								 <li <?php if(isset($pageid) and $pageid==3.7)echo 'class="active1 "'; ?>><a href="<?= URL?>ubitech/organization/customized" <?php if(isset($pageid) and $pageid==3.7)echo 'class="activeall " style="color: #9c27b0;"'; ?>>Premium - Customized</a></li>
								 
								 <li <?php if(isset($pageid) and $pageid==3.9)echo 'class="active1 "'; ?>><a href="
								 <?= URL ?>ubitech/extrauserOrganization" <?php if(isset($pageid) and $pageid==3.9)echo 'class="activeall " style="color:#9c27b0;"'; ?>>Premium - Exceeded Users</a></li>
								 
								 <li <?php if(isset($pageid) and $pageid==3.6)echo 'class="active1 "'; ?>><a href="<?=  URL ?>ubitech/organization/active" <?php if(isset($pageid) and $pageid==3.6)echo 'class="activeall" style="color: #9c27b0; "'; ?>>Premium - Expired </a></li>
								 
								 <li <?php if(isset($pageid) and $pageid==3.4)echo 'class="active1 "'; ?>><a href="<?=URL?>ubitech/organization/notrenew" <?php if(isset($pageid) and $pageid==3.4)echo 'class="activeall" style="color: #9c27b0; "'; ?>>Premium - Not to be renewed</a></li>
								 
								 
								 <li <?php if(isset($pageid) and $pageid==3.8)echo 'class="active1 "'; ?>><a href="<?= URL ?>ubitech/organization/archive" <?php if(isset($pageid) and $pageid==3.8)echo 'class="activeall " style="color:#9c27b0;"'; ?>>Archived</a></li>
								 
							 <!--<li <?php if(isset($pageid) and $pageid==3.12)echo 'class="active1 "'; ?>>
								  <a href="<?= URL ?>ubitech/organization/testing" <?php if(isset($pageid) and $pageid==3.12)echo 'class="activeall " style="color:#9c27b0;"'; ?>>Testing</a>
								  </li>-->
								  
								  <li <?php if(isset($pageid) and $pageid==3.13)echo 'class="active1 "'; ?>>
								 <a href="<?= URL ?>ubitech/organization/cleanedup" <?php if(isset($pageid) and $pageid==3.13)echo 'class="activeall " style="color:#9c27b0;"'; ?>>Cleaned Up</a>
								  </li>
								 
								 
								  <li <?php if(isset($pageid) and $pageid==3.10)echo 'class="active1 "'; ?>><a href="<?= URL ?>ubitech/unsubscribe" <?php if(isset($pageid) and $pageid==3.11)echo 'class="activeall " style="color:#9c27b0;"'; ?>>Unsubscribed </a>
								  </li>
										
			             </ul>
				</div> 
				<!-----Payment history----->
				<li <?php if(isset($pageid) and ($pageid==11 || $pageid==11.1 || $pageid==11.2|| $pageid==11.3 || $pageid==11.4||$pageid==11.5||$pageid==11.6))echo 'class="active "';?>>
					<a  data-toggle="collapse" data-target="#paymenthistory" data-parent="#sidenav01" class="collapsed" style="cursor: pointer;">
					<i class=" fa fa-credit-card"></i>
	                        <p>Transaction History</p>
	                   </a>
				 </li> 	
				<div <?php if(isset($pageid) and ($pageid==11 || $pageid==11.1 || $pageid==11.2|| $pageid==11.3 || $pageid==11.4||$pageid==11.5||$pageid==11.6)) 
				echo 'class="collapse in" aria-expanded="true" style="height: 280px;margin-left:10%"'; else echo 'class="collapse" aria-controls="navbar" aria-expanded="false" style="height: 0px;margin-left:10%"'; ?> id="paymenthistory" style="height: 0px;margin-left:10%;">
	                    
						<ul class="nav nav-list" style="margin-top:-4px;" id="navid">
						  
						        <li <?php if(isset($pageid) and $pageid==11)echo 'class="active1 "'; ?>><a href="<?=URL?>ubitech/getPaymentHistory" <?php if(isset($pageid) and $pageid==11)echo 'class="activeall" style="color: #9c27b0;"'; ?>>All Transactions </a></li>
								
								 <li <?php if(isset($pageid) and $pageid==11)echo 'class="active1 "'; ?>><a href="<?=URL?>ubitech/getSuccessfullPayment/all" <?php if(isset($pageid) and $pageid==11.4)echo 'class="activeall" style="color: #9c27b0;"'; ?>>All Payments</a></li>
								
								 <li <?php if(isset($pageid) and $pageid==11)echo 'class="active1 "'; ?>><a href="<?=URL?>ubitech/getSuccessfullPayment/manual" <?php if(isset($pageid) and $pageid==11.1)echo 'class="activeall" style="color: #9c27b0;"'; ?>>Manual Payments </a></li>
								 
								 <li <?php if(isset($pageid) and $pageid==11)echo 'class="active1 "'; ?>><a href="<?=URL?>ubitech/getSuccessfullPayment/payumoney" <?php if(isset($pageid) and $pageid==11.2)echo 'class="activeall" style="color: #9c27b0;"'; ?>>Pay U Payments</a></li>
								  
								 <li <?php if(isset($pageid) and $pageid==11)echo 'class="active1 "'; ?>><a href="<?=URL?>ubitech/getSuccessfullPayment/paypal" <?php if(isset($pageid) and $pageid==11.3)echo 'class="activeall" style="color: #9c27b0;"'; ?>>Paypal Payments</a></li>
								 
								 <li <?php if(isset($pageid) and $pageid==11)echo 'class="active1 "'; ?>><a href="<?=URL?>ubitech/paymentfailed" <?php if(isset($pageid) and $pageid==11.5)echo 'class="activeall" style="color: #9c27b0;"'; ?>>Failed Transactions</a></li>
								 
								 <li <?php if(isset($pageid) and $pageid==11)echo 'class="active1 "'; ?>><a href="<?=URL?>ubitech/gstreport" <?php if(isset($pageid) and $pageid==11.6)echo 'class="activeall" style="color: #9c27b0;"'; ?>>GST Report</a></li>
								 
								 
			             </ul>
				</div>


				<li <?php if(isset($pageid) and ($pageid==33 || $pageid==33.1 || $pageid==33.2|| $pageid==33.3 ))echo 'class="active "';?>>
					<a  data-toggle="collapse" data-target="#pushnotification" data-parent="#sidenav01" class="collapsed" style="cursor: pointer;">
					<i class=" fa fa-bell"></i>
	                        <p>Push Notifications</p>
	                   </a>
				 </li> 

				 <div <?php if(isset($pageid) and ($pageid==33 || $pageid==33.1 || $pageid==33.2|| $pageid==33.3 )) 
				echo 'class="collapse in" aria-expanded="true" style="height: 80px;margin-left:10%"'; else echo 'class="collapse" aria-controls="navbar" aria-expanded="false" style="height: 0px;margin-left:10%"'; ?> id="pushnotification" style="height: 0px;margin-left:10%;">
	                    
						<ul class="nav nav-list" style="margin-top:-4px;" id="navid">
						  
						        <li <?php if(isset($pageid) and $pageid==33)echo 'class="active1 "'; ?>><a href="<?=URL?>ubitech/preconfigured" <?php if(isset($pageid) and $pageid==33.1)echo 'class="activeall" style="color: #9c27b0;"'; ?>>Manual </a></li>
								
								 <li <?php if(isset($pageid) and $pageid==33)echo 'class="active1 "'; ?>><a href="<?=URL?>ubitech/automaticnotification" <?php if(isset($pageid) and $pageid==33.2)echo 'class="activeall" style="color: #9c27b0;"'; ?>>Automatic</a></li>
								
								 <!-- <li <?php if(isset($pageid) and $pageid==33)echo 'class="active1 "'; ?>><a href="<?=URL?>ubitech/manualnotification" <?php if(isset($pageid) and $pageid==33.3)echo 'class="activeall" style="color: #9c27b0;"'; ?>>Manual</a></li> -->
								 
								
								 
								 
			             </ul>
				</div>


				<li <?php  if(isset($pageid) and $pageid==143){echo 'class="active "'; }?>><a href="<?=URL?>ubitech/activitylog"><i class="fa fa-check-circle"></i>Activity Log</a></li>

				<li <?php  if(isset($pageid) and $pageid==142){echo 'class="active "'; }?>><a href="<?=URL?>ubitech/probability"><i class="fa fa-check-circle"></i>Probability</a></li>

					

				<li <?php if(isset($pageid) and ($pageid==121 || $pageid==121.1 || $pageid==121.2|| $pageid==121.3 || $pageid==121.4||$pageid==121.5))echo 'class="active "';?>>
					<a  data-toggle="collapse" data-target="#settings" data-parent="#sidenav01" class="collapsed" style="cursor: pointer;">
					<i class=" fa fa-cogs"></i>
	                        <p>Settings</p>
	                   </a>
				 </li>
				 <div <?php if(isset($pageid) and ($pageid==121 || $pageid==121.1 || $pageid==121.2|| $pageid==121.3 || $pageid==121.4||$pageid==121.5)) 
				echo 'class="collapse in" aria-expanded="true" style="height: 230px;margin-left:10%"'; else echo 'class="collapse" aria-controls="navbar" aria-expanded="false" style="height: 0px;margin-left:10%"'; ?> id="settings" style="height: 0px;margin-left:10%;">


					<ul class="nav nav-list" style="margin-top:-4px;" id="navid">


						<li <?php if(isset($pageid) and $pageid==121)echo 'class="active1"'; ?>>
	                    <a href="<?=URL?>ubitech/newpackages"
	                        <?php if(isset($pageid) and $pageid==121.1)echo 'class="activeall" style="color: #9c27b0;"'; ?>>
	                        <p>Plans</p>
	                    </a>
	                </li>

						<li <?php if(isset($pageid) and $pageid==121)echo 'class="active1"'; ?>>
	                    <a href="<?=URL?>ubitech/trial_setting"
	                        <?php if(isset($pageid) and $pageid==121.2)echo 'class="activeall" style="color: #9c27b0;"'; ?>>
	                        <p>Trial Settings</p>
	                    </a>
	                </li>

	                <li <?php if(isset($pageid) and $pageid==121)echo 'class="active1"'; ?>>
	                    <a href="<?=URL?>ubitech/attDiscount"
	                        <?php if(isset($pageid) and $pageid==121.3)echo 'class="activeall" style="color: #9c27b0;"'; ?>>
	                        <p>Promotional Discount</p>
	                    </a>
	                </li>

	                <li <?php if(isset($pageid) and $pageid==121)echo 'class="active1"'; ?>>
	                    <a href="<?=URL?>ubitech/setAppStorePath"
	                        <?php if(isset($pageid) and $pageid==121.4)echo 'class="activeall" style="color: #9c27b0;"'; ?>>
	                        <p>Play Store</p>
	                    </a>
	                </li>

	                <li <?php if(isset($pageid) and $pageid==121)echo 'class="active1"'; ?>>
	                    <a href="<?=URL?>ubitech/leadowner"
	                        
	                        <?php if(isset($pageid) and $pageid==121.5)echo 'class="activeall" style="color: #9c27b0;"'; ?>>
	                        <p>Lead Owner</p>
	                    </a>
	                </li>
	                <li <?php  if(isset($pageid) and $pageid==786){echo 'class="active "'; }?>><a href="<?=URL?>ubitech/ReferenceAmount">Referral Program</a></li>
	            </ul>
	               

				</div>
				

				<li <?php if(isset($pageid) and $pageid==4)echo 'class="active"'; ?> style="margin-top:5px;">
	                    <a href="<?=URL?>ubitech/organization">
	                        <i class="material-icons">unarchive</i>
	                        <p>Asssign Lead Owner</p>
	                    </a>
	                </li> 
				
					
					<!-- <li <?php if(isset($pageid) and $pageid==9)echo 'class="active"'; ?>>
	                    <a href="<?=URL?>ubitech/newpackages">
	                        <i class=" fa fa-dropbox"></i>
	                        <p>Plans</p>
	                    </a>
	                </li> -->
					
					
	             <!--    <li <?php if(isset($pageid) and $pageid==4)echo 'class="active"'; ?>>
	                    <a href="<?=URL?>ubitech/trial_setting">
	                        <i class="material-icons">unarchive</i>
	                        <p>Trial Settings</p>
	                    </a>
	                </li> -->
					<!-- <li <?php if(isset($pageid) and $pageid==2)echo 'class="active"'; ?>>
	                    <a href="<?=URL?>ubitech/slider">
	                        <i class="fa fa-sliders"></i>
	                        <p>Promotional Banners</p>
	                    </a>
	                </li> -->
	                <!--  <li <?php if(isset($pageid) and $pageid==10)echo 'class="active"'; ?>>
	                    <a href="<?=URL?>ubitech/attDiscount">
	                        <i class=" fa fa-dropbox"></i>
	                        <p>Promotional Discount</p>
	                    </a>
	                </li> -->
	               
				<!--	<li <?php if(isset($pageid) and $pageid==3)echo 'class="active"'; ?>>
	                    <a href="<?=URL?>ubitech/organization">
	                        <i class="material-icons">unarchive</i>
	                        <p>Organization</p>
	                    </a>
	                </li> -->
				 
					
					<!--<li <?php if(isset($pageid) and $pageid==5)echo 'class="active"'; ?>>
	                    <a href="<?=URL?>ubitech/package">
	                        <i class=" fa fa-dropbox"></i>
	                        <p>Packages</p>
	                    </a>
	                </li>-->
					<!-- <li <?php if(isset($pageid) and $pageid==6)echo 'class="active"'; ?>>
	                    <a href="<?=URL?>ubitech/setAppStorePath">
	                        <i class=" fa fa-play"></i>
	                        <p>Play Store</p>
	                    </a>
	                </li> -->
					
					
					<!-- <li <?php if(isset($pageid) and $pageid==42)echo 'class="active"'; ?>>
	                    <a href="<?=URL?>ubitech/leadowner">
	                        <i class=" fa fa-cogs"></i>
	                        <p>Lead / Renewal owner</p>
	                    </a>
	                </li> -->
					
					
					
				<!--	<li <?php if(isset($pageid) and $pageid==11)echo 'class="active"'; ?>>
	                    <a href="<?=URL?>ubitech/getPaymentHistory">
	                        <i class=" fa fa-credit-card"></i>
	                        <p>Payment History</p>
	                    </a>
	                </li> -->
				 
				<!--	<li <?php if(isset($pageid) and $pageid==8)echo 'class="active"'; ?>>
	                    <a href="<?=URL?>ubitech/packages">
	                        <i class=" fa fa-dropbox"></i>
	                        <p>Plans</p>
	                    </a>
	                </li> -->
					
	               
					<!--<li <?php if(isset($pageid) and $pageid==7)echo 'class="active"'; ?>>
	                    <a href="<?=URL?>ubitech/orginfo">
	                        <i class=" fa fa-file"></i>
	                        <p>Organization Information</p>
	                    </a>
	                </li>-->
	            </ul>
	    	</div>
	    </div>
		
		<!-----delete org start--...///its js code is in navbar.php////-->
<div id="delOrg" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>.
        <h4 class="modal-title" id="title">Archive Company</h4>
      </div>
      <div class="modal-body">		
		<form>
			<input type="hidden" id="del_did" />
			<div class="row">
				<div class="col-md-12">
					<h4>Archive the Company data "<span id="dna"></span>"?</h4>
				</div>
			</div>
			<div class="clearfix"></div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="delete"  class="btn btn-danger">Archive</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div> 
  </div> 
</div>

<!-----delete org close--->
</body>

</html>