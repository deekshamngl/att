<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link href="<?=URL?>../assets/css/bootstrap-timepicker.min.css" rel="stylesheet"/>
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="cache-control" content="no-cache">
	<title>ubiAttendance</title>
	<style>
		.red{
			color:red;
			font-weight:'bold';
			font-size:16px;
		}
		.deleteShift{
			cursor:pointer;
		}

	</style>
	<style>
		
	
	</style>
</head>
<body>
 <div class="accordion_main">
                    <div class="accordion_head">Plan Details <button id="edit4" type="button" class="btn editbutton"><i  class="fa fa-pencil " style="font-size:12px;margin-top:0px;top:0px;"></i> Edit</button></div>
                    <div class="accordion_body4 " style="display: none;">
                    <div class="row"  ><!--id="TotalUsd"-->
                    <div class="col-md-1" ></div>
                    <div class="col-md-10" >
                    <hr/> 
                    <table class="table borderless">
					
					 <tr>
                    <td width="10%"></td>
                    <td width="24%" align="left">Subscription End </td>
                    <td width="1%"></td>
                    <td width="20%"><span class=""></span><span id="subscriptend">0</span></td>
                    </tr>
					<tr>
                    <td width="10%"></td>
                    <td width="24%" align="left">My Plan</td>
                    <td width="1%"></td>
                    <td width="20%"><span class=""></span><span id="plan"></span></td>
                    </tr>
					<tr>
                    <td width="10%"></td>
                    <td width="24%" align="left">No. of Users </td>
                    <td width="1%"></td>
                    <td width="20%"><span class=""></span><span id="nousers"></span></td>
                    </tr>
					<tr>
                    <td width="10%"></td>
                    <td width="24%" align="left">Amount</td>
                    <td width="1%"></td>
                    <td width="20%"><span class="revCurrency"></span><span id="amount"></span></td>
                    </tr>
                   
                    <!--	  <tr>
                      <td width="25%"> 
                      </td>
                      <td width="20%"></td>
                      <td width="15%"></td>
                      <td width="10%"></td>
                      <td width="15%">Promo Code </td>
                      <td width="15%">- <span class="revCurrency"></span><span id="revPromoCodeAmt1">0</span></td>
                       </tr>
                    <tr>
                   
                    <td width="10%"></td>
                    <td width="25%"><span style="color: red">Yearly Discount<span> </td>
					<td width="1%" style="color: red">-</td>
                    <td width="20%"><span style="color: red"><span class="revCurrency"></span><span id="revDiscountAmt">0</span></span></td>
                    </tr>-->
                    <tr id="taxation" style="display:none">
                   
                    <td width="10%"></td>
                    <td width="24%">Tax<sup>*</sup> <span id="revIGSTPer"><?php echo isset($myplan['igst'])?$myplan['igst']:''; ?></span>%</td>
                    <td width="1%"></td>
                    <td width="20%">+ <span class="revCurrency"></span><span id="revIGSTAmt">0</span></td>
                    </tr>
                    <tr>
                   
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
</body>


	<script>
	
	function openNav() {
							document.getElementById("mySidenav").style.width = "360PX";
							
							
							$('#sidenavData').load('<?=URL?>admin/helpNav',{'pageid': 'shiftH'});	
						}
						function closeNav() {
							document.getElementById("mySidenav").style.width = "0";
						}
			//$("#mySidenav").toggleClass("collapsed");
			//$("#content").toggleClass("col-md-12 col-md-9");	
	
	</script>

<script src="<?=URL?>../assets/js/bootstrap-timepicker.min.js" type="text/javascript"></script>

<script src="<?=URL?>../assets/js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="<?=URL?>../assets/js/buttons.print.min.js"></script>
	<script src="<?=URL?>../assets/js/dataTables.buttons.min.js"></script>
	 <script type="text/javascript" src="<?=URL?>../assets/js/moment.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/daterangepicker.js"></script>
	  
      <script type="text/javascript" src="<?=URL?>../assets/js/buttons.flash.min.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/jszip.min.js"></script>
		 <script type="text/javascript" src="<?=URL?>../assets/js/jquery.dataTables.min.js"></script>
	    <script type="text/javascript" src="<?=URL?>../assets/js/buttons.html5.min.js"></script>
		

	<script type="text/javascript">
            $('.timepicker').timepicker();
       </script>
	<script type="text/javascript">
    	$(document).ready(function() {
			var table=$('#example').DataTable( {
				//"scrollX": true,
				"order": [[ 1, "desc" ]],
					"orderable": false,
					//"scrollX": true,
					"columnDefs": [ {
						"searchable": false,
						"orderable": false,
						"targets"  : "no-sort",
						//"className": 'noVis'
					}],
				 dom: 'Bfrtip',
					"buttons": [
					'pageLength','csv','excel','copy','print',
					{
						"extend":'colvis',
						"columns":':not(:last-child)',
					}
					
				],
				"contentType": "application/json",
				"ajax": "<?php echo URL;?>admin/getAllShift",
				"columns": [
					{ "data": "name" },
					{ "data": "timein" },
					{ "data": "timeout" },
					//{ "data": "timeingrace" },
					//{ "data": "timeoutgrace" },
					{ "data": "timeinbreak" },
					{ "data": "timeoutbreak" },
					{ "data": "shifttype" },
					{ "data": "shifthpurs" },
					{ "data": "workhours" },
					{ "data": "status" },
					{ "data": "action" }
				]
			} );
			  $('input.timepicker').timepicker();
			  
			  $('#save').click(function(){
				   if($('#shiftName').val()==''){
					  $('#shiftName').focus();
						doNotify('top','center',4,'Please enter the shift name.');
					  return false;
				  }
				  var sna=$('#shiftName').val();
				   var ti=$('#timeIn').val();
				   var to=$('#timeOut').val();
				   var tib=$('#timeInBreak').val();
				   var tob=$('#timeOutBreak').val();
				   var tig=$('#timeInGrace').val();
				   var tog=$('#timeOutGrace').val();
				   var bog=$('#breakInGrace').val();
				   var big=$('#breakOutGrace').val();
				   var sts=$('#status').val();
				  
				  
				  ////////////////////////////////
				   var shifttype='';
				   shifttype=$("input[name='shifttype']:checked").val();
				   if(shifttype==0 || shifttype==''){ 
					doNotify('top','center',4,'Please select the shift type.');
					return false;
				   }
  				    var fromdt="2013/05/29 "+ti;
					var todt="2013/05/29 "+to;
					var tot="2013/05/29 24:00:00";
					var frm = new Date(Date.parse(fromdt));
					var to1 = new Date(Date.parse(todt));
					var tot1 = new Date(Date.parse(todt));
					
					var diff = (frm - to1) / 60000; //dividing by seconds and milliseconds
					var minutes = (diff % 60).toString();
					var hours = (((diff - minutes) / 60).toString()).replace('-','');
					var shiftHours='';
				   var sht='';
				  if(minutes=='60')
						{
							hours=(parseInt(hours)+1).toString();
							minutes='00';
						}
				   if(shifttype==1){
					   sht='Same Day';
					   
					    if(ti == to){
						    alert("Time In and Time Out can not be same for the shift");   
						  return false;
					   }
					   
					   if (frm > to1){
						alert("Time In can not be greater than Time Out for Single day shift.");   
						  return false;
					   }
							//alert(hours);
						if(hours >= 16)
						{
							alert("you can not add more than 16 hours.");
							return false;
						}
				   }
				   if(shifttype==2){
						sht='Two Days';
						
						if(ti == to){
						    alert("Time In and Time Out can not be same for the shift");   
						  return false;
					   }
						if (frm < to1){
						alert("Time Out can not be greater than Time In for Multiple day shift.");   
						  return false;
					   }
					  	alert(hours);
						if(hours >= 16)
						{
					alert("You have to add the shift of less than 16 Hours, Eg.15:59 hr");
							return false;
						}
				   }
				    
				
					shiftHours = hours+":"+minutes;
				  if(!confirm("You are going to register a new shift "+sna+" of "+shiftHours +" hrs, which will start/end within "+sht+" \n Do you want to create this shift?"))
					return false;
				  ////////////////////////////////

				   
				   $.ajax({url: "<?php echo URL;?>admin/registerShift",
						data: {"sna":sna,"ti":ti,"to":to,"tib":tib,"tob":tob,"tig":tig,"tog":tog,"bog":bog,"big":big,"sts":sts,"shifttype":shifttype},
						success: function(result){
							if(result == 1){
								doNotify('top','center',2,'Shift Added Successfully.');
								$('#addShift').modal('hide');
								document.getElementById('shifrFrom').reset();
								 table.ajax.reload();
							}else if(result== 2){
								doNotify('top','center',3,'Shift '+sna+'  already exist.');
															
							}
							else{
								doNotify('top','center',4,'There may error(s) in creating shift, try later.');
								document.getElementById('shifrFrom').reset();
								$('#addShift').modal('hide');
							}
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});  
			$('#saveE').click(function(){
				  if($('#shiftNameE').val()==''){
					  $('#shiftNameE').focus();
						doNotify('top','center',4,'Please enter the shift name.');
					  return false;
				  }
				   var sid=$('#sid').val();
				   var sna=$('#shiftNameE').val();
				   var ti=$('#timeInE').val();
				   var to=$('#timeOutE').val();
				   var tib=$('#timeInBreakE').val();
				   var tob=$('#timeOutBreakE').val();
				   var tig=$('#timeInGraceE').val();
				   var tog=$('#timeOutGraceE').val();
				   var bog=$('#breakInGraceE').val();
				   var big=$('#breakOutGraceE').val();
				   var sts=$('#statusE').val();
				   $.ajax({url: "<?php echo URL;?>admin/editShift",
						data: {"sid":sid,"sna":sna,"ti":ti,"to":to,"tib":tib,"tob":tob,"tig":tig,"tog":tog,"bog":bog,"big":big,"sts":sts},
						success: function(result){
							if(result==1){
								doNotify('top','center',2,'Shift Updated Successfully.');
								$('#addShiftE').modal('hide');
								document.getElementById('shifrFrom').reset();
								 table.ajax.reload();
							}else if(result==2){
								doNotify('top','center',4,"Shift "+sna+" already exist. ");
							}
							else{
								doNotify('top','center',3,"No changes Found.");
								document.getElementById('shifrFrom').reset();
								$('#addShiftE').modal('hide');
							}
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			}); 
			
			$(document).on("click", "#delete", function () {
				var id=$('#del_sid').val();
				$.ajax({url: "<?php echo URL;?>admin/deleteShift",
						data: {"sid":id},
						success: function(result){
							result=JSON.parse(result);
							if(result.afft){
								$('#delShift').modal('hide');
								doNotify('top','center',2,'Shift deleted successfully.');
								 table.ajax.reload();
							}else{
								$('#delShift').modal('hide');
								doNotify('top','center',4,'This shift can not be delete, It is used in '+result.attn+' attendence(s) and currently assigned to '+result.emp+' employee(s).');
							}
						
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});
			
		});
			$(document).on("click", ".editShift", function () {
				$('#shiftNameLableE').text('');;
				$('#shiftNameE').attr('placeholder',"");
				$('#sid').val($(this).data('sid'));
				$('#shiftNameE').val($(this).data('name'));
				$('#timeInE').val($(this).data('ti'));
				$('#timeOutE').val($(this).data('to'));
				$('#timeInBreakE').val($(this).data('tib'));
				$('#timeOutBreakE').val($(this).data('tob'));
				$('#timeInGraceE').val($(this).data('tig'));
				$('#timeOutGraceE').val($(this).data('tog'));
				$('#breakInGraceE').val($(this).data('big'));
				$('#breakOutGraceE').val($(this).data('bog'));
				$('#statusE').val($(this).data('sts'));	
			});
			$(document).on("click", ".deleteShift", function () {
				$('#del_sid').val($(this).data('sid'));
				$('#sna').text($(this).data('sname'));
			});
			
		
	</script>
<script>
		$(document).ready(function () {
			$(".toggle-sidebar").click(function () {
				$("#sidebar").toggleClass("collapsed t2");
				$("#content").toggleClass("col-md-9");
				$("#sidebar").load('<?=URL?>admin/helpNav',{'pageid': 'shiftH'});
				return false;
			});
			
		});
		
	</script>
</html>
