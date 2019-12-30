<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>ubiAttendance</title>
</head>
<body>  
  	
	<div class="wrapper">
		<?php
			$data['pageid']=121.1;
			$this->load->view('ubitech/sidebar',$data);
		?>
	    <div class="main-panel">
			<?php
				$this->load->view('ubitech/navbar');
			?>
			<div class="content">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-md-12">
						
	                        <div class="card">
	                            <div class="card-header" data-background-color="purple">
	                                <h4 class="title">Plans</h4>
	                                <p class="category">Plan Settings</p>
									
									
	                            </div>
	                            <div class="card-content">
									<div class="hide1" readonly id="typography">
										

						<!-----Tabing-------->
			<div class="col-md-12">
				  <ul class="nav nav-pills nav-justified">
					<li class="active"><a data-toggle="pill" href="#home">Home</a></li>
					<li><a data-toggle="pill" href="#bulkatt">Bulk Attendance</a></li>
					<li><a data-toggle="pill" href="#locationtra">Location Tracking</a></li>
					<li><a data-toggle="pill" href="#visitpunch">Visit Punch</a></li>
					<li><a data-toggle="pill" href="#geofence">Geo Fence</a></li>
					<li><a data-toggle="pill" href="#payroll">Payroll</a></li>
					<li><a data-toggle="pill" href="#timeoff">TimeOff</a></li>
				  </ul>

				  <div class="tab-content">
			       <div id="home" class="tab-pane fade in active">
					<!-------->
					 <div class="nav-tabs-wrapper">
											<h6 class="nav-tabs-title">
											<button class="btn btn-sm btn-primary" class="hide1" readonly id="path"  data-background-color="purple" type="button" style="float: right;margin-top: -20px;" >	
														Edit
													<div class="ripple-container"></div></button>
											<button style="display:none;float: right;margin-top: -20px;" data-background-color="purple" class="btn btn-sm btn-primary"  class="hide1" readonly id="Edit_path" type="button" >Done</button>
											</h6>
											
					</div>
					 


					 <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>No. of Employees</b></label>
								</div>
								
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>Price/Employee ($)/month  </b>
								  </label>
								</div>
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>Price/Employee ($)/year</b></label>
								</div>
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"><b>Price/Employee (Rs.)/month</b>
								  </label>
								</div>
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>Price/Employee (Rs.)/year</b></label>
								</div>
								</div>
						</div>
	                          
 		               <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>0 to 20 </b></label>
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								   <input type="number" style="width:100px" class="hide1" readonly id="usdmonthly1" value="<?=$p[0]['monthly']?>">
								  
								</div>
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="hide1" readonly id="usdyearly1" value="<?=$p[0]['yearly']?>">
								  
								</div>
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="hide1" readonly id="rsmonthly1"  value="<?=$p[7]['monthly']?>">
								  
								</div>
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="hide1" readonly id="rsyearly1"  value="<?= $p[7]['yearly']?>" >
								  
								</div>
								</div>
						</div>
						
	                   
			<div class="row">
				<div class="col-sm-2">
					<div class="form-group">
				<label for="inputsm" style="color:black;"> <b>21 to 40</b></label> 
								 </div>
								
								
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								   <input type="number" style="width:100px" class="hide1" readonly id="usdmonthly2"  value="<?=$p[1]['monthly']?>">
								  
								</div>
								
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="hide1" readonly id="usdyearly2"  value="<?=$p[1]['yearly']?>">
								  
								</div>
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="hide1" readonly id="rsmonthly2"  value="<?=$p[8]['monthly']?>">
								</div>
								
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="hide1" readonly id="rsyearly2"  value="<?=$p[8]['yearly']?>">
								</div>
								</div>
						</div>
	        
			         <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>41 to 60</b></label>
								 </div>
								
								
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								   <input type="number" style="width:100px" class="hide1" readonly id="usdmonthly3"  value="<?=$p[2]['monthly']?>">
								  
								</div>
								
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="hide1" readonly id="usdyearly3"  value="<?=$p[2]['yearly']?>">
								  
								</div>
								
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="hide1" readonly id="rsmonthly3" value="<?=$p[9]['monthly']?>">
								</div>
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="hide1" readonly id="rsyearly3" value="<?=$p[9]['yearly']?>">
								</div>
								</div>
						</div>
	        
	     <div class="row">
		   <div class="col-sm-2">
			  <div class="form-group">
			    <label for="inputsm" style="color:black;"> <b>61 to 80 </b></label> 
								 </div>
								
								
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								   <input type="number" style="width:100px" class="hide1" readonly id="usdmonthly4" value="<?=$p[3]['monthly']?>">
								  
								</div>
								
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="hide1" readonly id="usdyearly4" value="<?=$p[3]['yearly']?>">
								  
								</div>
								
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="hide1" readonly id="rsmonthly4" value="<?=$p[10]['monthly']?>">
								</div>
								
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="hide1" readonly id="rsyearly4" value="<?=$p[10]['yearly']?>">
								</div>
								
								</div>
								
								</div>
	        
			         <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>81 to 100</b></label> 
		
								 </div>
								
								
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								   <input type="number" style="width:100px" class="hide1" readonly id="usdmonthly5" value="<?=$p[4]['monthly']?>">
								  
								</div>
								
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="hide1" readonly id="usdyearly5" value="<?=$p[4]['yearly']?>">
								  
								</div>
								
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="hide1" readonly id="rsmonthly5" value="<?=$p[11]['monthly']?>">
								  
								</div>
								
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="hide1" readonly id="rsyearly5" value="<?=$p[11]['yearly']?>">
								  
								</div>
								</div>
								</div>
	        
			<div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>101 to 120 </b></label> 
		
								 </div>
								
								
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								   <input type="number" style="width:100px" class="hide1" readonly id="usdmonthly6" value="<?=$p[5]['monthly']?>">
								  
								</div>
								
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="hide1" readonly id="usdyearly6" value="<?=$p[5]['yearly']?>">
								  
								</div>
								
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="hide1" readonly id="rsmonthly6" value="<?=$p[12]['monthly']?>">
								  
								</div>
								
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="hide1" readonly id="rsyearly6" value="<?=$p[12]['yearly']?>">
								  
								</div>
								</div>
						</div>
	        
		    	<div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>120+ </b></label> 
								 </div>
								
								
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								   <input type="number" style="width:100px" class="hide1" readonly id="usdmonthly7" value="<?=$p[6]['monthly']?>">
								</div>
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="hide1" readonly id="usdyearly7" value="<?=$p[6]['yearly']?>">
								</div>
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="hide1" readonly id="rsmonthly7" value="<?=$p[13]['monthly']?>">
								  
								</div>
								
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="hide1" readonly id="rsyearly7" value="<?=$p[13]['yearly']?>">
								  
								</div>
								</div>
								</div>
								
					</div>
					
	
					<div id="bulkatt" class="tab-pane fade">
					 <div class="nav-tabs-wrapper">
										
											<h6 class="nav-tabs-title">
											
											<button data-has = "b" data-name = "bulkatt" class="btn btn-sm btn-primary path" class="hide1" readonly   data-background-color="purple" type="button" style="float: right;margin-top: -20px;" >	Edit
											 <div class="ripple-container"></div>
											</button>
													
											<button data-has = "B_"  data-name = "bulk_attendance" style="display:none;float: right;margin-top: -20px; " data-background-color="purple" id="bulkatt1" class="btn btn-sm btn-primary Edit_path"  readonly  type="button" >Done
											</button>
											
											</h6>
											
					</div>
					 <div class="row">
								<div class="col-sm-12">
									<b>All Prices are based on employee/month.</b>


					</div>
			</div>
					  <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>No. of Employees</b></label>
								</div>
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>Price($)</b></label>
								</div>
								</div>
								
								
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>Price(Rs.)</b></label>
								  
								</div>
								</div>
								
								
								
						</div>
	                          
 		               <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>0 to 20 </b></label>
								 </div>
								
								
								</div>
								
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="bhide1" readonly id="B_usdyearly1" value="<?=$p[0]['bulkattendance']?>">
								</div>
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="bhide1" readonly id="B_rsyearly1"  value="<?=$p[7]['bulkattendance']?>">
								</div>
								</div>
								
						</div>
	                   
			<div class="row">
				<div class="col-sm-2">
					<div class="form-group">
				<label for="inputsm" style="color:black;"> <b>21 to 40</b></label> 
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="bhide1" readonly id="B_usdyearly2"  value="<?=$p[1]['bulkattendance']?>">
								  
								</div>
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="bhide1" readonly id="B_rsyearly2"  value="<?=$p[8]['bulkattendance']?>">
								</div>
								</div>
								
								
						</div>
	        
			         <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>41 to 60</b></label>
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="bhide1" readonly id="B_usdyearly3"  value="<?=$p[2]['bulkattendance']?>">
								  
								</div>
								
								</div>
							
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="bhide1" readonly id="B_rsyearly3" value="<?=$p[9]['bulkattendance']?>">
								</div>
								</div>
								
						</div>
	        
	     <div class="row">
		   <div class="col-sm-2">
			  <div class="form-group">
			    <label for="inputsm" style="color:black;"> <b>61 to 80 </b></label> 
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="bhide1" readonly id="B_usdyearly4" value="<?=$p[3]['bulkattendance']?>">
								  
								</div>
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="bhide1" readonly id="B_rsyearly4" value="<?=$p[10]['bulkattendance']?>">
								  
								</div>
								
								</div>
								
								
								</div>
	        
			            <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>81 to 100</b></label> 
		
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="bhide1" readonly id="B_usdyearly5" value="<?=$p[4]['bulkattendance']?>">
								  
								</div>
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="bhide1" readonly id="B_rsyearly5" value="<?=$p[11]['bulkattendance']?>">
								  
								</div>
								</div>
								
						</div>
	        
			<div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>101 to 120 </b></label> 
		
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="bhide1" readonly id="B_usdyearly6" value="<?=$p[5]['bulkattendance']?>">
								  
								</div>
								
								</div>
								
							
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="bhide1" readonly id="B_rsyearly6" value="<?=$p[12]['bulkattendance']?>">
								  
								</div>
								</div>
							
						</div>
	        
		    	       <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>120+ </b></label> 
								 </div>
								
								
								</div>
								
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="bhide1" readonly id="B_usdyearly7" value="<?=$p[6]['bulkattendance']?>">
								</div>
								</div>
								
							
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="bhide1" readonly id="B_rsyearly7" value="<?=$p[13]['bulkattendance']?>">
								  
								</div>
								</div>
								
								</div>
					  
					  
					</div>
					
					<div id="locationtra" class="tab-pane fade">
					  <div class="nav-tabs-wrapper">
										
											<h6 class="nav-tabs-title">
											
											<button  data-name = "location" class="btn btn-sm btn-primary path" class="hide1" readonly data-has = "l"  data-background-color="purple" type="button" style="float: right;margin-top: -20px;" >	Edit
											 <div class="ripple-container"></div>
											</button>
													
											<button data-has = "L_" data-name = "	location_tracing" style="display:none;float: right;margin-top: -20px; " data-background-color="purple" id = "location1" class="btn btn-sm btn-primary Edit_path"  readonly  type="button" >Done
											</button>
											
											</h6>
											
					</div>
					<div class="row">
								<div class="col-sm-12">
									<b>All Prices are based on employee/month.</b>


					</div>
			</div>
					  <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>No. of Employees</b></label>
								</div>
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>Price($)</b></label>
								</div>
								</div>
								
								
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>Price(Rs.)</b></label>
								  
								</div>
								</div>
								
								
								
						</div>
	                          
 		               <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>0 to 20 </b></label>
								 </div>
								
								
								</div>
								
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="lhide1" readonly id="L_usdyearly1" value="<?=$p[0]['location_tracing']?>">
								  
								</div>
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="lhide1" readonly id="L_rsyearly1"  value="<?=$p[7]['location_tracing']?>">
								  
								</div>
								</div>
								
						</div>
	                   
			<div class="row">
				<div class="col-sm-2">
					<div class="form-group">
				<label for="inputsm" style="color:black;"> <b>21 to 40</b></label> 
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="lhide1" readonly id="L_usdyearly2"  value="<?=$p[1]['location_tracing']?>">
								  
								</div>
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="lhide1" readonly id="L_rsyearly2"  value="<?=$p[8]['location_tracing']?>">
								</div>
								</div>
								
								
						</div>
	        
			         <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>41 to 60</b></label>
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="lhide1" readonly id="L_usdyearly3"  value="<?=$p[2]['location_tracing']?>">
								  
								</div>
								
								</div>
							
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="lhide1" readonly id="L_rsyearly3" value="<?=$p[9]['location_tracing']?>">
								  
								</div>
								</div>
								
						</div>
	        
	     <div class="row">
		   <div class="col-sm-2">
			  <div class="form-group">
			    <label for="inputsm" style="color:black;"> <b>61 to 80 </b></label> 
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="lhide1" readonly id="L_usdyearly4" value="<?=$p[3]['location_tracing']?>">
								  
								</div>
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="lhide1" readonly id="L_rsyearly4" value="<?=$p[10]['location_tracing']?>">
								  
								</div>
								
								</div>
								
								
								</div>
	        
			            <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>81 to 100</b></label> 
		
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="lhide1" readonly id="L_usdyearly5" value="<?=$p[4]['location_tracing']?>">
								  
								</div>
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="lhide1" readonly id="L_rsyearly5" value="<?=$p[11]['location_tracing']?>">
								  
								</div>
								</div>
								
						</div>
	        
			<div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>101 to 120 </b></label> 
		
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="lhide1" readonly id="L_usdyearly6" value="<?=$p[5]['location_tracing']?>">
								  
								</div>
								
								</div>
								
							
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="lhide1" readonly id="L_rsyearly6" value="<?=$p[12]['location_tracing']?>">
								  
								</div>
								</div>
							
						</div>
	        
		    	       <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>120+ </b></label> 
								 </div>
								
								
								</div>
								
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="lhide1" readonly id="L_usdyearly7" value="<?=$p[6]['location_tracing']?>">
								</div>
								</div>
								
							
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="lhide1" readonly id="L_rsyearly7" value="<?=$p[13]['location_tracing']?>">
								  
								</div>
								</div>
								
								</div>
					</div>
					
					<div id="visitpunch" class="tab-pane fade">
					  <div class="nav-tabs-wrapper">
										
											<h6 class="nav-tabs-title">
											
											<button  data-name = "visitpunch" class="btn btn-sm btn-primary path" class="hide1" readonly data-has = "v"   data-background-color="purple" type="button" style="float: right;margin-top: -20px;" >	Edit
											 <div class="ripple-container"></div>
											</button>
													
											<button style="display:none;float: right;margin-top: -20px;"   data-name = "visit_punch" data-has = "V_" data-background-color="purple" class="btn btn-sm btn-primary Edit_path" id = "visitpunch1"  class="hide1" readonly  type="button" >Done
											</button>
											
											</h6>
											
					</div>
					<div class="row">
								<div class="col-sm-12">
									<b>All Prices are based on employee/month.</b>


					</div>
			</div>
					  <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>No. of Employees</b></label>
								</div>
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>Price($)</b></label>
								</div>
								</div>
								
								
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>Price(Rs.)</b></label>
								  
								</div>
								</div>
								
								
								
						</div>
	                          
 		               <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>0 to 20 </b></label>
								 </div>
								
								
								</div>
								
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="vhide1" readonly id="V_usdyearly1" value="<?=$p[0]['visit_punch']?>">
								  
								</div>
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="vhide1" readonly id="V_rsyearly1"  value="<?=$p[7]['visit_punch']?>">
								  
								</div>
								</div>
								
						</div>
	                   
			<div class="row">
				<div class="col-sm-2">
					<div class="form-group">
				<label for="inputsm" style="color:black;"> <b>21 to 40</b></label> 
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="vhide1" readonly id="V_usdyearly2"  value="<?=$p[1]['visit_punch']?>">
								  
								</div>
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="vhide1" readonly id="V_rsyearly2"  value="<?=$p[8]['visit_punch']?>">
								</div>
								</div>
								
								
						</div>
	        
			         <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>41 to 60</b></label>
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="vhide1" readonly id="V_usdyearly3"  value="<?=$p[2]['visit_punch']?>">
								  
								</div>
								
								</div>
							
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="vhide1" readonly id="V_rsyearly3" value="<?=$p[9]['visit_punch']?>">
								  
								</div>
								</div>
								
						</div>
	        
	     <div class="row">
		   <div class="col-sm-2">
			  <div class="form-group">
			    <label for="inputsm" style="color:black;"> <b>61 to 80 </b></label> 
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="vhide1" readonly id="V_usdyearly4" value="<?=$p[3]['visit_punch']?>">
								  
								</div>
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="vhide1" readonly id="V_rsyearly4" value="<?=$p[10]['visit_punch']?>">
								  
								</div>
								
								</div>
								
								
								</div>
	        
			            <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>81 to 100</b></label> 
		
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="vhide1" readonly id="V_usdyearly5" value="<?=$p[4]['visit_punch']?>">
								  
								</div>
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="vhide1" readonly id="V_rsyearly5" value="<?=$p[11]['visit_punch']?>">
								  
								</div>
								</div>
								
						</div>
	        
			<div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>101 to 120 </b></label> 
		
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="vhide1" readonly id="V_usdyearly6" value="<?=$p[5]['visit_punch']?>">
								  
								</div>
								
								</div>
								
							
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="vhide1" readonly id="V_rsyearly6" value="<?=$p[12]['visit_punch']?>">
								  
								</div>
								</div>
							
						</div>
	        
		    	       <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>120+ </b></label> 
								 </div>
								
								
								</div>
								
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="vhide1" readonly id="V_usdyearly7" value="<?=$p[6]['visit_punch']?>">
								</div>
								</div>
								
							
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="vhide1" readonly id="V_rsyearly7" value="<?=$p[13]['visit_punch']?>">
								  
								</div>
								</div>
								
								</div>
					</div>
					
					 <div id="geofence" class="tab-pane fade">
					    <div class="nav-tabs-wrapper">
										
											<h6 class="nav-tabs-title">
											
											<button data-has = "g" class="btn btn-sm btn-primary path" class="hide1" readonly   data-name = "geofence"  data-background-color="purple" type="button" style="float: right;margin-top: -20px;" >	Edit
											 <div class="ripple-container"></div>
											</button>
													
											<button style="display:none;float: right;margin-top: -20px;" data-background-color="purple" data-name = "geo_fence" data-has = "G_" class="btn btn-sm btn-primary Edit_path" id="geofence1" readonly  type="button" >Done
											</button>
											
											</h6>
											
					</div>
					<div class="row">
								<div class="col-sm-12">
									<b>All Prices are based on employee/month.</b>


					</div>
			</div>
					  <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>No. of Employees</b></label>
								</div>
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>Price($)</b></label>
								</div>
								</div>
								
								
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>Price(Rs.)</b></label>
								  
								</div>
								</div>
								
								
								
						</div>
	                          
 		               <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>0 to 20 </b></label>
								 </div>
								
								
								</div>
								
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="ghide1" readonly id="G_usdyearly1" value="<?=$p[0]['geo_fence']?>">
								  
								</div>
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="ghide1" readonly id="G_rsyearly1"  value="<?=$p[7]['geo_fence']?>">
								  
								</div>
								</div>
								
						</div>
	                   
			<div class="row">
				<div class="col-sm-2">
					<div class="form-group">
				<label for="inputsm" style="color:black;"> <b>21 to 40</b></label> 
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="ghide1" readonly id="G_usdyearly2"  value="<?=$p[1]['geo_fence']?>">
								  
								</div>
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="ghide1" readonly id="G_rsyearly2"  value="<?=$p[8]['geo_fence']?>">
								</div>
								</div>
								
								
						</div>
	        
			         <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>41 to 60</b></label>
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="ghide1" readonly id="G_usdyearly3"  value="<?=$p[2]['geo_fence']?>">
								  
								</div>
								
								</div>
							
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="ghide1" readonly id="G_rsyearly3" value="<?=$p[9]['geo_fence']?>">
								  
								</div>
								</div>
								
						</div>
	        
	     <div class="row">
		   <div class="col-sm-2">
			  <div class="form-group">
			    <label for="inputsm" style="color:black;"> <b>61 to 80 </b></label> 
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="ghide1" readonly id="G_usdyearly4" value="<?=$p[3]['geo_fence']?>">
								  
								</div>
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="ghide1" readonly id="G_rsyearly4" value="<?=$p[10]['geo_fence']?>">
								  
								</div>
								
								</div>
								
								
								</div>
	        
			            <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>81 to 100</b></label> 
		
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="ghide1" readonly id="G_usdyearly5" value="<?=$p[4]['geo_fence']?>">
								  
								</div>
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="ghide1" readonly id="G_rsyearly5" value="<?=$p[11]['geo_fence']?>">
								  
								</div>
								</div>
								
						</div>
	        
			<div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>101 to 120 </b></label> 
		
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="ghide1" readonly id="G_usdyearly6" value="<?=$p[5]['geo_fence']?>">
								  
								</div>
								
								</div>
								
							
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="ghide1" readonly id="G_rsyearly6" value="<?=$p[12]['geo_fence']?>">
								  
								</div>
								</div>
							
						</div>
	        
		    	       <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>120+ </b></label> 
								 </div>
								
								
								</div>
								
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="ghide1" readonly id="G_usdyearly7" value="<?=$p[6]['geo_fence']?>">
								</div>
								</div>
								
							
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="ghide1" readonly id="G_rsyearly7" value="<?=$p[13]['geo_fence']?>">
								  
								</div>
								</div>
								
								</div>
					</div>
					
					<div id="payroll" class="tab-pane fade">
					  <div class="nav-tabs-wrapper">
										
											<h6 class="nav-tabs-title">
											
											<button class="btn btn-sm btn-primary path" class="hide1" readonly data-name = "payroll" data-has = "p"  data-background-color="purple" type="button" style="float: right;margin-top: -20px;" >	Edit
											 <div class="ripple-container"></div>
											</button>
													
											<button data-has = "P_" style="display:none;float: right;margin-top: -20px;" data-background-color="purple" data-name = "payroll" class="btn btn-sm btn-primary Edit_path"  id = "payroll1" readonly  type = "button" >Done
											</button>
											
											</h6>
											
					</div>
					<div class="row">
								<div class="col-sm-12">
									<b>All Prices are based on employee/month.</b>


					</div>
			</div>
					  <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>No. of Employees</b></label>
								</div>
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>Price($)</b></label>
								</div>
								</div>
								
								
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>Price(Rs.)</b></label>
								  
								</div>
								</div>
								
								
								
						</div>
	                          
 		               <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>0 to 20 </b></label>
								 </div>
								
								
								</div>
								
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="phide1" readonly id="P_usdyearly1" value="<?=$p[0]['payroll']?>">
								  
								</div>
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="phide1" readonly id="P_rsyearly1"  value="<?=$p[7]['payroll']?>">
								  
								</div>
								</div>
								
						</div>
	                   
			<div class="row">
				<div class="col-sm-2">
					<div class="form-group">
				<label for="inputsm" style="color:black;"> <b>21 to 40</b></label> 
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="phide1" readonly id="P_usdyearly2"  value="<?=$p[1]['payroll']?>">
								  
								</div>
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="phide1" readonly id="P_rsyearly2"  value="<?=$p[8]['payroll']?>">
								</div>
								</div>
								
								
						</div>
	        
			         <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>41 to 60</b></label>
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="phide1" readonly id="P_usdyearly3"  value="<?=$p[2]['payroll']?>">
								  
								</div>
								
								</div>
							
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="phide1" readonly id="P_rsyearly3" value="<?=$p[9]['payroll']?>">
								  
								</div>
								</div>
								
						</div>
	        
	     <div class="row">
		   <div class="col-sm-2">
			  <div class="form-group">
			    <label for="inputsm" style="color:black;"> <b>61 to 80 </b></label> 
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="phide1" readonly id="P_usdyearly4" value="<?=$p[3]['payroll']?>">
								  
								</div>
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="phide1" readonly id="P_rsyearly4" value="<?=$p[10]['payroll']?>">
								  
								</div>
								
								</div>
								
								
								</div>
	        
			            <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>81 to 100</b></label> 
		
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="phide1" readonly id="P_usdyearly5" value="<?=$p[4]['payroll']?>">
								  
								</div>
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="phide1" readonly id="P_rsyearly5" value="<?=$p[11]['payroll']?>">
								  
								</div>
								</div>
								
						</div>
	        
			<div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>101 to 120 </b></label> 
		
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="phide1" readonly id="P_usdyearly6" value="<?=$p[5]['payroll']?>">
								  
								</div>
								
								</div>
								
							
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="phide1" readonly id="P_rsyearly6" value="<?=$p[12]['payroll']?>">
								  
								</div>
								</div>
							
						</div>
	        
		    	       <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>120+ </b></label> 
								 </div>
								
								
								</div>
								
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="phide1" readonly id="P_usdyearly7" value="<?=$p[6]['payroll']?>">
								</div>
								</div>
								
							
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="phide1" readonly id="P_rsyearly7" value="<?=$p[13]['payroll']?>">
								  
								</div>
								</div>
								
								</div>
					</div>
					
					<div id="timeoff" class="tab-pane fade">
					  <div class="nav-tabs-wrapper">
										
											<h6 class="nav-tabs-title">
											
											<button data-has = "t" class="btn btn-sm btn-primary path" class="hide1" readonly data-name = "timeoff"    data-background-color="purple" type="button" style="float: right;margin-top: -20px;" >	Edit
											 <div class="ripple-container"></div>
											</button>
													
											<button data-has = "T_" style="display:none;float: right;margin-top: -20px;" data-background-color="purple" data-name = "time_off"  id = "timeoff1" class="btn btn-sm btn-primary Edit_path"   readonly  type="button" >Done
											</button>
											
											</h6>
											
					</div>
					<div class="row">
								<div class="col-sm-12">
									<b>All Prices are based on employee/month.</b>


					</div>
			</div>
					  <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>No. of Employees</b></label>
								</div>
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>Price($)</b></label>
								</div>
								</div>
								
								
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>Price(Rs.)</b></label>
								  
								</div>
								</div>
								
								
								
						</div>
	                          
 		               <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>0 to 20 </b></label>
								 </div>
								
								
								</div>
								
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="thide1" readonly id="T_usdyearly1" value="<?=$p[0]['time_off']?>">
								  
								</div>
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="thide1" readonly id="T_rsyearly1"  value="<?=$p[7]['time_off']?>">
								  
								</div>
								</div>
								
						</div>
	                   
			<div class="row">
				<div class="col-sm-2">
					<div class="form-group">
				<label for="inputsm" style="color:black;"> <b>21 to 40</b></label> 
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="thide1" readonly id="T_usdyearly2"  value="<?=$p[1]['time_off']?>">
								  
								</div>
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="thide1" readonly id="T_rsyearly2"  value="<?=$p[8]['time_off']?>">
								</div>
								</div>
								
								
						</div>
	        
			         <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>41 to 60</b></label>
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="thide1" readonly id="T_usdyearly3"  value="<?=$p[2]['time_off']?>">
								  
								</div>
								
								</div>
							
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="thide1" readonly id="T_rsyearly3" value="<?=$p[9]['time_off']?>">
								  
								</div>
								</div>
								
						</div>
	        
	     <div class="row">
		   <div class="col-sm-2">
			  <div class="form-group">
			    <label for="inputsm" style="color:black;"> <b>61 to 80 </b></label> 
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="thide1" readonly id="T_usdyearly4" value="<?=$p[3]['time_off']?>">
								  
								</div>
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="thide1" readonly id="T_rsyearly4" value="<?=$p[10]['time_off']?>">
								  
								</div>
								
								</div>
								
								
								</div>
	        
			            <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>81 to 100</b></label> 
		
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="thide1" readonly id="T_usdyearly5" value="<?=$p[4]['time_off']?>">
								  
								</div>
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="thide1" readonly id="T_rsyearly5" value="<?=$p[11]['time_off']?>">
								  
								</div>
								</div>
								
						</div>
	        
			<div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>101 to 120 </b></label> 
		
								 </div>
								
								
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="thide1" readonly id="T_usdyearly6" value="<?=$p[5]['time_off']?>">
								  
								</div>
								
								</div>
								
							
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="thide1" readonly id="T_rsyearly6" value="<?=$p[12]['time_off']?>">
								  
								</div>
								</div>
							
						</div>
	        
		    	       <div class="row">
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="inputsm" style="color:black;"> <b>120+ </b></label> 
								 </div>
								
								
								</div>
								
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="thide1" readonly id="T_usdyearly7" value="<?=$p[6]['time_off']?>">
								</div>
								</div>
								
								<div class="col-sm-2">
								<div class="form-group">
								  <input type="number" style="width:100px" class="thide1" readonly id="T_rsyearly7" value="<?=$p[13]['time_off']?>">
								</div>
								</div>
								</div>
					</div>
					
				  </div>
				</div>
				 
				<!-----Tabing-------->				
										
                       
							  </div>
	                        </div>
							
							<label  style="color:red;margin-top:20px;"> <b>&nbsp;&nbsp;Employees more than 120! Please contact us for Bulk Discount.</b><br></label>
	                    </div>
						 
	                </div>
	           
				</div>
	        </div>

			<footer class="footer">
				<div class="container-fluid">
					<p class="copyright pull-right">
						&copy; <script>document.write(new Date().getFullYear())</script> <a href="#">DESIGNED BY </a>Ubitech Solutions Pvt. Ltd.
					</p>
				</div>
			</footer>
		</div>
	</div>



</body>

	
	<script type="text/javascript">
	$('#trial_setting').click(function(){
		var days = $('#days').val();
		$.ajax({url: "<?php echo URL;?>/ubitech/trial_days",
        data: {'days':days},
		success: function(result){
	   if(result == 'true'){
			  doNotify('top','center',2,'days updated successfully.');
			   setTimeout(location.reload.bind(location), 2000);
		  }else{
			  doNotify('top','center',4,'some error occurs.');
			   setTimeout(location.reload.bind(location), 2000);
			  alert('false');
		  }
		  
    }});
	})
	
	
	$('#path').click(function(){
	 $(".hide1").attr("readonly", false); 
	
	
	$('#Edit_path').show();
	$('#path').hide();
	
})

$('.path').click(function(){
	  //  alert($(this).data('name'));
		var id=  $(this).data('name')+1;
		var has = $(this).data('has')+'hide1';
		//alert(has);
	   $("."+has).attr("readonly",false); 
	   $('#'+id).show();
	   $(this).hide();
	   
	/*
	$('#Edit_path').show();
	$('#path').hide();*/
})


  

$('#Edit_path').click(function()
{
	var usdmonthly1 = $('#usdmonthly1').val();
	var usdyearly1 = $('#usdyearly1').val();
	var rsmonthly1 = $('#rsmonthly1').val();
	var rsyearly1 = $('#rsyearly1').val();
	
	var usdmonthly2 = $('#usdmonthly2').val();
	var usdyearly2 = $('#usdyearly2').val();
	var rsmonthly2 = $('#rsmonthly2').val();
	var rsyearly2 = $('#rsyearly2').val();
	
	var usdmonthly3 = $('#usdmonthly3').val();
	var usdyearly3 = $('#usdyearly3').val();
	var rsmonthly3 = $('#rsmonthly3').val();
	var rsyearly3 = $('#rsyearly3').val();
	
	var usdmonthly4 = $('#usdmonthly4').val();
	var usdyearly4 = $('#usdyearly4').val();
	var rsmonthly4 = $('#rsmonthly4').val();
	var rsyearly4 = $('#rsyearly4').val();
	
	var usdmonthly5 = $('#usdmonthly5').val();
	var usdyearly5 = $('#usdyearly5').val();
	var rsmonthly5 = $('#rsmonthly5').val();
	var rsyearly5 = $('#rsyearly5').val();
	
	var usdmonthly6 = $('#usdmonthly6').val();
	var usdyearly6 = $('#usdyearly6').val();
	var rsmonthly6 = $('#rsmonthly6').val();
	var rsyearly6 = $('#rsyearly6').val();
	
	var usdmonthly7 = $('#usdmonthly7').val();
	var usdyearly7 = $('#usdyearly7').val();
	var rsmonthly7 = $('#rsmonthly7').val();
	var rsyearly7 = $('#rsyearly7').val();
	
	
   $.ajax({url: "<?php echo URL ?>/ubitech/updateNewPackages",
    data: {
	'usdmonthly1':usdmonthly1,
	'usdyearly1':usdyearly1,
	'rsmonthly1':rsmonthly1,
	'rsyearly1':rsyearly1,
	
	'usdmonthly2':usdmonthly2,
	'usdyearly2':usdyearly2,
	'rsmonthly2':rsmonthly2,
	'rsyearly2':rsyearly2,
	
	'usdmonthly3':usdmonthly3,
	'usdyearly3':usdyearly3,
	'rsmonthly3':rsmonthly3,
	'rsyearly3':rsyearly3,
	
	'usdmonthly4':usdmonthly4,
	'usdyearly4':usdyearly4,
	'rsmonthly4':rsmonthly4,
	'rsyearly4':rsyearly4,
	
	'usdmonthly5':usdmonthly5,
	'usdyearly5':usdyearly5,
	'rsmonthly5':rsmonthly5,
	'rsyearly5':rsyearly5,
	
	'usdmonthly6':usdmonthly6,
	'usdyearly6':usdyearly6,
	'rsmonthly6':rsmonthly6,
	'rsyearly6':rsyearly6,
	
	'usdmonthly7':usdmonthly7,
	'usdyearly7':usdyearly7,
	'rsmonthly7':rsmonthly7,
	'rsyearly7':rsyearly7	
	},
	success: function(result){
        if(result == 1){
		  doNotify('top','center',2,'Package updated successfully.');
			   setTimeout(location.reload.bind(location), 1000);
		  }else{
			  doNotify('top','center',4,'some error occurs.');
			  setTimeout(location.reload.bind(location), 2000);
			 // alert('false');
		  }
    }});
}) 

$('.Edit_path').click(function(){
	
	
	var ids = $(this).data('has');
	var addons = $(this).data('name');
	
   
	var usdyearly1 = $('#'+ids+'usdyearly1').val();
	var rsyearly1 = $('#'+ids+'rsyearly1').val();
	
	
	
	var usdyearly2 = $('#'+ids+'usdyearly2').val();
	var rsyearly2 = $('#'+ids+'rsyearly2').val();
	

	var usdyearly3 = $('#'+ids+'usdyearly3').val();
	var rsyearly3 = $('#'+ids+'rsyearly3').val();
	

	var usdyearly4 = $('#'+ids+'usdyearly4').val();
	var rsyearly4 = $('#'+ids+'rsyearly4').val();
	
	
	var usdyearly5 = $('#'+ids+'usdyearly5').val();
	var rsyearly5 = $('#'+ids+'rsyearly5').val();
	

	var usdyearly6 = $('#'+ids+'usdyearly6').val();
	var rsyearly6 = $('#'+ids+'rsyearly6').val();
	

	var usdyearly7 = $('#'+ids+'usdyearly7').val();
	var rsyearly7 = $('#'+ids+'rsyearly7').val();
	
	
	
	$.ajax({url: "<?php echo URL ?>/ubitech/updateAddons",
    data: {

	'usdyearly1':usdyearly1,
	'rsyearly1':rsyearly1,
	

	'usdyearly2':usdyearly2,
	'rsyearly2':rsyearly2,
	

	'usdyearly3':usdyearly3,
	'rsyearly3':rsyearly3,
	
	
	'usdyearly4':usdyearly4,
	'rsyearly4':rsyearly4,
	

	'usdyearly5':usdyearly5,
	'rsyearly5':rsyearly5,
	

	'usdyearly6':usdyearly6,
	'rsyearly6':rsyearly6,
	

	'usdyearly7':usdyearly7,
	'rsyearly7':rsyearly7,
	
    'addons':addons	
	},
	success: function(result){
		
		
        if(result == 1){
		  doNotify('top','center',2,'Package updated successfully.');
			   setTimeout(location.reload.bind(location), 1000);
		  }else{
			  doNotify('top','center',4,'some error occurs.');
			 // setTimeout(location.reload.bind(location), 2000);
			 // alert('false');
		  }
    }});
	
})
	</script>
	
</html>
