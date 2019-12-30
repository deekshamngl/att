<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link href="<?=URL?>../assets/css/bootstrap-timepicker.min.css" rel="stylesheet"/>
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="cache-control" content="no-cache">
	<title>ubiAttendance</title>
	<style>
		.red{
			color:red;
			font-weight:'bold';
			font-size:16px;
		}
		.deleteShift
		{
			cursor:pointer;
		}
	</style>
</head>
<body onload="weekfetch()">

	<div class="wrapper">
		<?php
			$data['pageid']=9.1;
			$this->load->view('menubar/sidebar',$data);
		?>
	    <div class="main-panel">
			<?php
				$this->load->view('menubar/navbar');
			
			?>
			<div class="content">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-md-12">
	                        <div class="card">
	                            <div class="card-header" data-background-color="green">
	                                <p  style="color:#ffffff;font-size:17px;" class="category">Manage Default Weekly Off for all employees</p>
	                              <!--  <a rel="tooltip" onclick="openNav()"  rel="tooltip"  data-placement="bottom" title="Help" style="position:relative;margin-top:-30px;" class="btn btn-success btn-sm pull-right"  >
			                        <i class="fa fa-question"></i></a> -->	
	                            </div>
	                              
								<center>
									<div class="card-content"> 
										<div class="row">
											<div class="col-md-1 col-lg-1 col-xl-1">
											</div>
											<div class="col-md-10 col-lg-10 col-xl-10">
												<div class="panel panel-primary">
												  <div class="panel-heading" style="background-color:#05afc4;">
													<b>
														Set Weekly Off
													</b>
												  </div>
												  <div class="panel-body" style="overflow: auto; ">
			<center>
				<table width="100%" class="table table-striped table-hover table-bordered" >
					<tr class="info">
						<th><h4 style="font-weight:bold">Day</h4></th>
						<th><h4 style="font-weight:bold">1<sup>st</sup> Week</h4></th>
						<th><h4 style="font-weight:bold">2<sup>nd</sup> Week</h4></th>
						<th><h4 style="font-weight:bold">3<sup>rd</sup> Week</h4></th>
						<th><h4 style="font-weight:bold">4<sup>th</sup> Week</h4></th>
						<th><h4 style="font-weight:bold">5<sup>th</sup> Week</h4></th>
					</tr>
					<tr>
						<td>Sunday</td>
						<td>
							<input type="radio" name="weekOne1" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekOne1" value="1"/> Full Day Off
							<br/>
							<input type="radio" name="weekOne1" value="0" checked="true" /> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekTwo1" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekTwo1" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekTwo1" value="0" checked="true"/> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekThree1" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekThree1" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekThree1" value="0" checked="true"/> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekFour1" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekFour1" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekFour1" value="0" checked="true"/> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekFive1" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekFive1" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekFive1" value="0" checked="true"/> Full Day Working
						</td>
					</tr>
					<tr>
						<td>Monday</td>
						<td>
							<input type="radio" name="weekOne2" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekOne2" value="1"/> Full Day Off
							<br/>
							<input type="radio" name="weekOne2" value="0" checked="true" /> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekTwo2" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekTwo2" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekTwo2" value="0" checked="true"/> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekThree2" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekThree2" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekThree2" value="0" checked="true"/> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekFour2" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekFour2" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekFour2" value="0" checked="true"/> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekFive2" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekFive2" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekFive2" value="0" checked="true"/> Full Day Working
						</td>
					</tr>
					<tr>
						<td>Tuesday</td>
						<td>
							<input type="radio" name="weekOne3" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekOne3" value="1"/> Full Day Off
							<br/>
							<input type="radio" name="weekOne3" value="0" checked="true" /> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekTwo3" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekTwo3" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekTwo3" value="0" checked="true"/> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekThree3" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekThree3" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekThree3" value="0" checked="true"/> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekFour3" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekFour3" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekFour3" value="0" checked="true"/> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekFive3" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekFive3" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekFive3" value="0" checked="true"/> Full Day Working
						</td>
					</tr>
					<tr>
						<td>Wednesday</td>
						<td>
							<input type="radio" name="weekOne4" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekOne4" value="1"/> Full Day Off
							<br/>
							<input type="radio" name="weekOne4" value="0" checked="true" /> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekTwo4" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekTwo4" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekTwo4" value="0" checked="true"/> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekThree4" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekThree4" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekThree4" value="0" checked="true"/> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekFour4" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekFour4" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekFour4" value="0" checked="true"/> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekFive4" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekFive4" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekFive4" value="0" checked="true"/> Full Day Working
						</td>
					</tr>
					<tr>
						<td>Thursday</td>
						<td>
							<input type="radio" name="weekOne5" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekOne5" value="1"/> Full Day Off
							<br/>
							<input type="radio" name="weekOne5" value="0" checked="true" /> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekTwo5" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekTwo5" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekTwo5" value="0" checked="true"/> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekThree5" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekThree5" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekThree5" value="0" checked="true"/> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekFour5" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekFour5" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekFour5" value="0" checked="true"/> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekFive5" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekFive5" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekFive5" value="0" checked="true"/> Full Day Working
						</td>
					</tr>
					<tr>
						<td>Friday</td>
						<td>
							<input type="radio" name="weekOne6" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekOne6" value="1"/> Full Day Off
							<br/>
							<input type="radio" name="weekOne6" value="0" checked="true" /> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekTwo6" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekTwo6" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekTwo6" value="0" checked="true"/> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekThree6" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekThree6" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekThree6" value="0" checked="true"/> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekFour6" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekFour6" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekFour6" value="0" checked="true"/> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekFive6" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekFive6" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekFive6" value="0" checked="true"/> Full Day Working
						</td>
					</tr>
					<tr>
						<td>Saturday</td>
						<td>
							<input type="radio" name="weekOne7" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekOne7" value="1"/> Full Day Off
							<br/>
							<input type="radio" name="weekOne7" value="0" checked="true" /> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekTwo7" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekTwo7" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekTwo7" value="0" checked="true"/> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekThree7" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekThree7" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekThree7" value="0" checked="true"/> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekFour7" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekFour7" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekFour7" value="0" checked="true"/> Full Day Working
						</td>
						<td>
							<input type="radio" name="weekFive7" value="2" /> Half Day Off <br/>
							<input type="radio" name="weekFive7" value="1" /> Full Day Off
							<br/>
							<input type="radio" name="weekFive7" value="0" checked="true"/> Full Day Working
						</td>
					</tr>
				</table>
				<div>
					<button id="save" class="btn btn-success">Save</button>
					<a id="clear" href="<?=URL?>Dashboard" onclick="history.go(-1);" class="btn btn-default">Cancel</a>
				</div>
			</center>
		  </div>
		</div>
	</div>
	<div class="col-md-1 col-lg-1 col-xl-1">
	</div>
</div>
</div>
</center>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>

	       
			<footer class="footer">
				<div class="container-fluid">	
				</div>
			</footer>
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
</body>

<div id="mySidenav" class="pull-right sidenav" style="background-image:url(<?=URL?>../assets/img/bg7.jpg);background-repeat:no-repeat;">
						<div class="helpHeader"><span >Help</span><a style="color:black;" href="javascript:void(0)" class="closebtn text-right" onclick="closeNav()">x </a></div>
						<div id="sidenavData" class="sidenavData">
						</div>
					</div>
<script>
	function openNav() {
			document.getElementById("mySidenav").style.width = "360PX";
			$('#sidenavData').load('<?=URL?>help/helpNav');	
		}
		function closeNav() {
			document.getElementById("mySidenav").style.width = "0";
		}
		function weekfetch(){
			 $.ajax({url: "<?php echo URL;?>admin/weekfetch",
			success: function(result){
				//alert(result.data[]['day']);
			var result1=JSON.parse(result);
			//console.log(result1.data.length);
                             var i = 0;
                            for(i=0; i<result1.data.length; i++){
                                //console.log( result1.data[i].day) ;
							if(result1.data[i].day==1){
							var weekday =  result1.data[i].week.split(",");
							//var weekday = explode(',', result1.data[i].week);
									//console.log(weekday);
									var j=0;
									 for(j=0; j<weekday.length; j++){
										 if(j==0){
										$("input[name=weekOne1][value=" + weekday[j] + "]").attr('checked', 'checked');
										 }
										 else if(j==1){
											$("input[name=weekTwo1][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==2){
											$("input[name=weekThree1][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==3){
											$("input[name=weekFour1][value=" +weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==4){
											$("input[name=weekFive1][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
									}
								}
							else if(result1.data[i].day==2){
							var weekday =  result1.data[i].week.split(",");
							//var weekday = explode(',', result1.data[i].week);
									//console.log(weekday);
									var j=0;
									 for(j=0; j<weekday.length; j++){
										 
										if(j==0){
										$("input[name=weekOne2][value=" + weekday[j] + "]").attr('checked', 'checked');
										 }
										 else if(j==1){
											$("input[name=weekTwo2][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==2){
											$("input[name=weekThree2][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==3){
											$("input[name=weekFour2][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==4){
											$("input[name=weekFive2][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
									}
								}
								
								
									else if(result1.data[i].day==3){
							var weekday =  result1.data[i].week.split(",");
							//var weekday = explode(',', result1.data[i].week);
									//console.log(weekday);
									var j=0;
									 for(j=0; j<weekday.length; j++){
										 
										if(j==0){
										$("input[name=weekOne3][value=" + weekday[j] + "]").attr('checked', 'checked');
										 }
										 else if(j==1){
											$("input[name=weekTwo3][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==2){
											$("input[name=weekThree3][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==3){
											$("input[name=weekFour3][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==4){
											$("input[name=weekFive3][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
									}
								}
								
									else if(result1.data[i].day==5){
							var weekday =  result1.data[i].week.split(",");
							//var weekday = explode(',', result1.data[i].week);
									//console.log(weekday);
									var j=0;
									 for(j=0; j<weekday.length; j++){
										 
										if(j==0){
										$("input[name=weekOne5][value=" + weekday[j] + "]").attr('checked', 'checked');
										 }
										 else if(j==1){
											$("input[name=weekTwo5][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==2){
											$("input[name=weekThree5][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==3){
											$("input[name=weekFour5][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==4){
											$("input[name=weekFive5][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
									}
								}
									else if(result1.data[i].day==4){
							var weekday =  result1.data[i].week.split(",");
							//var weekday = explode(',', result1.data[i].week);
									//console.log(weekday);
									var j=0;
									 for(j=0; j<weekday.length; j++){
										 
										if(j==0){
										$("input[name=weekOne4][value=" + weekday[j] + "]").attr('checked', 'checked');
										 }
										 else if(j==1){
											$("input[name=weekTwo4][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==2){
											$("input[name=weekThree4][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==3){
											$("input[name=weekFour4][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==4){
											$("input[name=weekFive4][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
									}
								}
									else if(result1.data[i].day==6){
							var weekday =  result1.data[i].week.split(",");
							//var weekday = explode(',', result1.data[i].week);
									//console.log(weekday);
									var j=0;
									 for(j=0; j<weekday.length; j++){
										 
										if(j==0){
										$("input[name=weekOne6][value=" + weekday[j] + "]").attr('checked', 'checked');
										 }
										 else if(j==1){
											$("input[name=weekTwo6][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==2){
											$("input[name=weekThree6][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==3){
											$("input[name=weekFour6][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==4){
											$("input[name=weekFive6][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
									}
								}
									else if(result1.data[i].day==7){
							var weekday =  result1.data[i].week.split(",");
							//var weekday = explode(',', result1.data[i].week);
									//console.log(weekday);
									var j=0;
									 for(j=0; j<weekday.length; j++){
										 
										if(j==0){
										$("input[name=weekOne7][value=" + weekday[j] + "]").attr('checked', 'checked');
										 }
										 else if(j==1){
											$("input[name=weekTwo7][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==2){
											$("input[name=weekThree7][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==3){
											$("input[name=weekFour7][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
										 else if(j==4){
											$("input[name=weekFive7][value=" + weekday[j] + "]").attr('checked', 'checked'); 
										 }
									}
								}

							}  
						}
			
                             
			  }); 
			 
			//alert("hello");
			
			}
</script>
	<script type="text/javascript">
    	$(document).ready(function() { 
			  $('#save').click(function(){
				  var weekOne=$("input[name='weekOne1']:checked").val();
				  var weekTwo=$("input[name='weekTwo1']:checked").val();
				  var weekThree=$("input[name='weekThree1']:checked").val();
				  var weekFour=$("input[name='weekFour1']:checked").val();
				  var weekFive=$("input[name='weekFive1']:checked").val();
				  var sunday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				   weekOne=$("input[name='weekOne2']:checked").val();
				   weekTwo=$("input[name='weekTwo2']:checked").val();
				   weekThree=$("input[name='weekThree2']:checked").val();
				   weekFour=$("input[name='weekFour2']:checked").val();
				   weekFive=$("input[name='weekFive2']:checked").val();
				  var monday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				   weekOne=$("input[name='weekOne3']:checked").val();
				   weekTwo=$("input[name='weekTwo3']:checked").val();
				   weekThree=$("input[name='weekThree3']:checked").val();
				   weekFour=$("input[name='weekFour3']:checked").val();
				   weekFive=$("input[name='weekFive3']:checked").val();
				  var tuesday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				   weekOne=$("input[name='weekOne4']:checked").val();
				   weekTwo=$("input[name='weekTwo4']:checked").val();
				   weekThree=$("input[name='weekThree4']:checked").val();
				   weekFour=$("input[name='weekFour4']:checked").val();
				   weekFive=$("input[name='weekFive4']:checked").val();
				  var wednesday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				   weekOne=$("input[name='weekOne5']:checked").val();
				   weekTwo=$("input[name='weekTwo5']:checked").val();
				   weekThree=$("input[name='weekThree5']:checked").val();
				   weekFour=$("input[name='weekFour5']:checked").val();
				   weekFive=$("input[name='weekFive5']:checked").val();
				  var thusday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				   weekOne=$("input[name='weekOne6']:checked").val();
				   weekTwo=$("input[name='weekTwo6']:checked").val();
				   weekThree=$("input[name='weekThree6']:checked").val();
				   weekFour=$("input[name='weekFour6']:checked").val();
				   weekFive=$("input[name='weekFive6']:checked").val();
				  var friday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				   weekOne=$("input[name='weekOne7']:checked").val();
				   weekTwo=$("input[name='weekTwo7']:checked").val();
				   weekThree=$("input[name='weekThree7']:checked").val();
				   weekFour=$("input[name='weekFour7']:checked").val();
				   weekFive=$("input[name='weekFive7']:checked").val();
				  var saturday=weekOne+','+weekTwo+','+weekThree+','+weekFour+','+weekFive;
				//  alert('Sunday: '+sunday+' \nMonday: '+monday+'\nTuesday: '+tuesday+' \nwednesday: '+wednesday+'\nthusday: '+thusday+' \nfriday: '+friday+'\nSaturday: '+saturday);
				
				  
				   $.ajax({url: "<?php echo URL;?>admin/editWeeklyOff",
						data: {"sun":sunday,"mon":monday,"tue":tuesday,"wed":wednesday,"thus":thusday,"fri":friday,"sat":saturday},
						success: function(result){
							if(result!='')
								doNotify('top','center',2,'Weekly off saved Successfully.');
							else
								doNotify('top','center',4,'There may error(s) in saving weekly off, try later.');
						 },
						error: function(result){
							doNotify('top','center',3,'Unable to connect API');
						 }
				   });
			});		
			//$("input[name=mygroup][value=" + value + "]").attr('checked', 'checked');
			
		});
	</script>

</html>
