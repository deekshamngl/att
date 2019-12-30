

<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	  <link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/datepicker.css" />
	
	<script src="<?=URL?>../assets/js/jquery-3.1.0.min.js"></script>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

<link data-require="bootstrap-css@2.3.2" data-semver="2.3.2" rel="stylesheet" href="<?=URL?>../assets/css/bootstrap-combined.min.css" />

<!--<link data-require="bootstrap-css@2.3.2" data-semver="2.3.2" rel="stylesheet" href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" /> -->
	<title>Monthly Summary</title>
	
	<style>
		.red
		{
			color:red;
			font-weight:'bold';
			font-size:16px;
		}
		
		.bargraph{
		display:inline-block;
		margin-top:-8px;
		margin-left:-17px;
	  }
		div.dt-buttons{
		position:relative;
		float:left;
		margin-left:15px;
	}
	 tbody td:not(:nth-child(1)){
        
		text-align:center;
    		
	}
	
	.sticky {
  position: fixed;
  top: 0;
  width: 100%;
}

.sticky + .content {
  padding-top: 102px;
}
	.t2{display:none;}
	

/* table scrolling */	
	
/*	
	.scrolling table
	{
     table-layout: inherit;
   }
.scrolling td, th {
    vertical-align: top;
	padding-bottom: 5px;
	min-width: 65px;
	height:53px;
}
.scrolling .name {
	position: absolute;
	left: 0;
	width: 150px;
}
	
.outer {
	position: relative
}
.inner {
	overflow-x: auto;
	overflow-y: visible;
	margin-left: 120px;
} */
	</style>
	
</head>   <!------ng-init="fetchtablemonthlydata();"------>
<body ng-app = "adminapp"  ng-controller="attroasterCtrl" ng-init="fetchtablemonthlydata();"   >
	<div class="wrapper"  >  <!--- ng-init="fetchtablemonthlydata();--->
		<?php
			$data['pageid']=112;
			$this->load->view('menubar/sidebar',$data);
			$data=isset($data)?$data:'';
		?>
	    <div class="main-panel">
			<?php
				$this->load->view('menubar/navbar');
			?>
			</br>
			  <section class="content" id="printsection">
			<div class="content" id="content">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-md-12">
	                        <div class="card">
	                            <div class="card-header" data-background-color="green">
	                                <p class="category" style="color:#ffffff;font-size:17px;" >Monthly Summary</p>
	                                <a rel="tooltip" style="position:relative;margin-top:-30px;"  data-placement="bottom" title="Help" class="btn btn-success btn-sm pull-right toggle-sidebar ">
                    <i class="fa fa-question"></i></a>
								</div>
								<div class="card-content">
								 <div class="typography">
									<div class="title">
										<div class="row container-fluid" style="margin-top:2px;" >
											<div class="col-md-3 col-sm-3" style="padding-left:35px;" >
											<div style="height:35px;width:222px;border :1px solid #acadaf; position:relative; margin-left:-10px;margin-top:0px;" >
											<input id="revenuedate" class="datepicker"  style="background: #fff; border: 0px solid #acadaf;border-radius:0px !important; height:33px;width:220px;" type="Text" 
											value="<?php echo date('F-Y'); ?>" data-date-autoclose="true" />  
											</div>
											</div>
							<div class="col-sm-2">			
							   <div class="row">			
							   <select id="empl" style="height:35px;position:relative;" class="col-sm-11">
							   <option value="0">--Select  Employee--</option>
								<?php
								$data= json_decode(getAllemp($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++){
									echo '<option  value='.$data[$i]->id.'>'.$data[$i]->FirstName.'  '.$data[$i]->LastName.'</option>';
								}?>
							    </select>
							  </div>
							</div>
							<div class="col-sm-2">
						    	<div class="row">
									<select id="deprt" style=" height:35px;position:relative;" class="col-sm-11">
									<option value="0">--All Departments--</option>
									<?php
									$data= json_decode(getAllDept($_SESSION['orgid']));
									for($i=0;$i<count($data);$i++)
										echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
									?>
									</select> 
								</div>
							</div>
						   	<div class="col-sm-2">
							  <div class="row">
                                 <select id="shift" style=" height:35px;position:relative;" class="col-sm-11">
							     <option value="0">--All Shifts--</option>
									<?php
									$data= json_decode(getAllShift($_SESSION['orgid']));
									for($i=0;$i<count($data);$i++)
									echo '<option value='.$data[$i]->id.'>'.$data[$i]->name.' ('.substr(($data[$i]->TimeIn),0,5).' - '.substr(($data[$i]->
									TimeOut),0,5).')</option>';
									?>
								</select>
							  </div>
							</div>
							
							<div class="col-sm-2">
						    	<div class="row">
									<select id="area" style=" height:35px;position:relative;" class="col-sm-11">
									<option value="0">--All Area--</option>
									<?php
									$data= json_decode(getAllArea($_SESSION['orgid']));
									for($i=0;$i<count($data);$i++)
										echo '<option value='.$data[$i]->id.'>'.$data[$i]->Name.'</option>';
									?>
									</select> 
								</div>
							</div>
							<div class="col-sm-1">
								 <button class="btn btn-success pull-left" style="position:relative;margin-top:-3px;right:18px;" id="getAtt" 
								 ng-click="fetchtablemonthlydata()"><i class="fa fa-search"></i></button>
							</div>
											
										</div>
									</div>
								
							<!--<div class="col-sm-2">
							<div class="row">
							   <select id="desg" style="height:35px;position:relative;" class="col-sm-11">
							   <option value="0">--All Designations--</option>
								<?php
								$data= json_decode(getAllDesg($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++)
								{
									echo '<option  value='.$data[$i]->id.'>'.$data[$i]->name.'</option>';
								}
								?>
							    </select>
							 </div>
							</div>
							
						
							 <div class="col-sm-2">			
							   <div class="row">			
							   <select id="empl" style="height:35px;position:relative;" class="col-sm-11">
							   <option value="0">--All Employees--</option>
								<?php
								$data= json_decode(getAllemp($_SESSION['orgid']));
								for($i=0;$i<count($data);$i++){
									echo '<option  value='.$data[$i]->id.'>'.$data[$i]->FirstName.'  '.$data[$i]->LastName.'</option>';
								}?>
							    </select>
							  </div>
							</div>
							<div class="col-sm-1">
								 <button class="btn btn-success pull-left" style="position:relative;margin-top:-3px;right:18px;" id="getAtt" ng-click="filter()" ><i class="fa fa-search"></i></button>
							</div>
									
						</div>
							</div>	-->
				 	<!--  <div class="row">
                          <div class="col-md-12 text-right">
                            <a rel="tooltip"  data-placement="bottom" title="Help" class="btn btn-success btn-sm toggle-sidebar">
                            <i class="fa fa-question"></i></a>
                          </div>
                        </div> -->
							
									
				<!-- <button id="export" data-export="export" class="dt-button buttons-excel buttons-html5" style="margin-bottom:5px;" >Excel</button>  -->
			<a download="Monthlyreport.xls" href="#" onclick="return ExcellentExport.excel(this,'example','Monthly Report');" class="btn btn-default no-print" >Excel</a>
				<div class="pull-right">
			<!--	Search:<input  type="text"  ng-model="searchText"> -->
				</div>
			<!--<button id="btnExport" onclisck="fnExcelReport();"> EXPORT </button>-->
				 
       

 <!-- <a download="Monthlyreport.xls" href="#" onclick="return ExcellentExport.excel(this, 'example');" class="btn btn-default no-print">Excel</a>-->
        <br/>  
        <br/>
        <br/>
										
   <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="scrolling outer" style="overflow-x:scroll;height:450px;" >
        <div class="inner" ng-show="!hastrue" >
		<!----Start repeat----->
		<table border="0" id="example">
		 <tr>
		  <td>
		<table ng-repeat="a in filteredItems | filter:searchText" >
		   
			<tbody>
			 <tr>
		       <td>
					<table border="0">
					 <tr>	
						 <td colspan="30" >
						  <b>Employee:</b>&nbsp;&nbsp;&nbsp;<!--{{a.empcode}}:&nbsp;-->{{a.name}}&nbsp;
						  <b>Department:</b>&nbsp;&nbsp;&nbsp;{{a.department}}
						  <br/><br/>
						</td>
					</tr>
					</table>
			   </td>
			</tr>	
		</tbody>
			<!--<img ng-src="{{a.entryimg}}" style="width:60px!important;" class="pull-right"/>---->
		<tbody>	
		<tr>
		       <td>
		<table class="table table-striped table-hover" >
			<tr>
              <th class="name" style="padding-top:5px;padding-left:20px;">Date</th>
              <th  ng-repeat="b in dates ">{{b}}</th>
            </tr>
			<tr>
              <th class="name" style="padding-top:10px;padding-left:20px;">Status</th>
			 <td ng-repeat="x in  a.sts track by $index" >
			 {{x}}
			 </td>
            </tr>
			<!--<tr>
				<th class="name" style="padding-top:10px;padding-left:20px;">Shift</th>
				<td ng-repeat="as in a.attshift track by $index">{{as}}
				</td>
            </tr>-->
			<tr>
				<th class="name" style="padding-top:10px;padding-left:20px;">Time In</th>
				<td ng-repeat="ti in a.timein track by $index">{{ti}}
				</td>
            </tr>
			<tr>
              <th class="name" style="padding-top:10px;padding-left:20px;">Time Out</th>
				  <td ng-repeat="to in  a.timeout track by $index">{{to}}
					</td>
            </tr>
            <tr>
              <th class="name" style="padding-top:10px;padding-left:20px;">Time In Date</th>
				  <td ng-repeat="tidate in a.timeindate track by $index">{{tidate}}
					</td>
            </tr>
            <tr>
              <th class="name" style="padding-top:10px;padding-left:20px;">Time Out Date</th>
				  <td ng-repeat="todate in a.timeoutdate track by $index">{{todate}}
					</td>
            </tr>
			<tr>
				<th class="name" style="padding-top:10px;padding-left:20px;">Late by</th>
				  <td ng-repeat="l in  a.latecome track by $index">{{l}}
				</td>
            </tr>
			<tr>
				<th class="name" style="padding-top:10px;padding-left:20px;">Left Early by</th>
				  <td ng-repeat="e in  a.earlyleave track by $index">{{e}}
				</td>
            </tr>
			
			<tr>
              <th class="name" style="padding-top:10px;padding-left:20px;">Overtime</th>
				  <td ng-repeat="ov in  a.overtime track by $index">{{ov}}
				  </td>
            <tr>
              <th class="name" style="padding-top:10px;padding-left:20px;">Undertime</th>
				  <td ng-repeat="u in  a.undertimee track by $index">{{u}}
				  </td>
            </tr>
			<tr>
              <th class="name" style="padding-top:10px;padding-left:20px;">Logged Hours</th>
				  <td ng-repeat="o in  a.officehours track by $index" >{{o}}
				  </td>
            </tr>
			<tr>
              <th class="name" style="padding-top:10px;padding-left:20px;">Time Off</th>
				  <td ng-repeat="timeoff in  a.timeoff track by $index">{{timeoff}}
				  </td>
            </tr>
        </table>
			 </td>
		</tr>	
		</tbody>
			<tbody>	
		    <tr>
		      <td>	
	            <table border="0" >
			 <tr>	
				 <td colspan="30" >
			<!--<b>Total Logged Hours/Total Shift Hours</b>:&nbsp;&nbsp;{{a.totaldurations}}/{{a.shifthours}}-->&nbsp;&nbsp;
			<b>Present</b>:&nbsp;{{a.present}}&nbsp;&nbsp;
			<b>Absent</b>:&nbsp;{{a.absent}}&nbsp;&nbsp;
			<b>Weekoff</b>:&nbsp;{{a.weekoff}}&nbsp;&nbsp;
			<b>Holidays</b>:&nbsp;{{a.holyday}}&nbsp;&nbsp;
			<b>Half-days</b>:&nbsp;{{a.halfday}}&nbsp;&nbsp;
			<b>Leave</b>:&nbsp;{{a.leave}}&nbsp;&nbsp;
			<b>Total Logged Hours/Total Shift Hours</b>:&nbsp;{{a.totaldurations}}/{{a.shifthours}}&nbsp;&nbsp;
			
			<!--<b>Leave</b>:&nbsp;{{a.leave}}-->
		      </td>
		    </tr>
		</table>		 
		   </td>
			</tr>
				</tbody>
			
			  <tbody>	
				<tr>
					<td colspan="30" >
						<div>
							 <br />
							 <br />
						</div>
					</td>
				</tr>
			</tbody>
		</table>
			   
		   </td>
		 </tr>
	</table>
		<!----close repeat------>
        </div>
		<div style="padding-top:10%;" ng-show="hastrue" >
		 <center> 
			 <img src = "<?=URL?>../assets/loaderimage.gif" alt="Loading....." style="width:100px;height:100px;">
			 </img>
		 </center>
	   </div>
	   
      </div> 
	 
	      <div data-pagination="" data-num-pages="numOfPages()" 
      data-current-page="curPage" data-max-size="maxSize"  
      data-boundary-links="true"></div>  
    </div>				  
  </div>
	                </div>
	            </div>
	        </div>
			</div>
			</div>
			</div>
			</div>
			<div class="col-md-3 t2" id="sidebar"></div>
	       </section>
			<footer class="footer">
				<div class="container-fluid">
					<nav class="pull-left">
						
					</nav>
					<!--<p class="copyright pull-right" style="padding-right:25px;" >
              &copy; <script>document.write(new Date().getFullYear())</script>. Developed by<a href="http://www.ubitechsolutions.com/" target="_blank" > Ubitech Solutions </a></p>-->
			  
			  <a href="http://www.ubitechsolutions.com/" target="_blank" >
					<p class="copyright pull-right" style="padding-right:25px;padding-top:0px" >
					Copyright &copy;<script>document.write(new Date().getFullYear())</script>
					Ubitech Solutions. All rights reserved.
					</p>
				</a>
				
				</div>
			</footer>
		</div>
	</div>

</body>
	<script src="<?=URL?>../assets/js/buttons.colVis.min.js"></script>
	<script src="<?=URL?>../assets/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="<?=URL?>../assets/js/moment.js"></script>
	<script type="text/javascript" src="<?=URL?>../assets/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="<?=URL?>../assets/js/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="<?=URL?>../assets/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="<?=URL?>../assets/js/buttons.flash.min.js"></script>
	<script type="text/javascript" src="<?=URL?>../assets/js/jszip.min.js"></script>
	<script type="text/javascript" src="<?=URL?>../assets/js/vfs_fonts.js"></script>
	<script type="text/javascript" src="<?=URL?>../assets/js/buttons.print.min.js"></script>
	<script type="text/javascript" src="<?=URL?>../assets/js/angular.min.js"></script>
	<script type="text/javascript" src="<?=URL?>../assets/js/angular-datatables.min.js"></script>
	<script type="text/javascript" src="<?=URL?>../assets/js/attRoaster.js"></script>
	<script src="<?=URL?>../assets/tabletoCSV/jquery.tabletoCSV.js"></script>
	<script src='<?php echo URL;?>../assets/js/excellentexport.js'></script>
	<script type="text/javascript" src="<?=URL?>../assets/js/jquery.dataTables.min.js"></script>
	
   <script data-require="angular-ui-bootstrap@0.3.0" data-semver="0.3.0" src="<?=URL?>../assets/js/ui-bootstrap-tpls-0.3.0.min.js"></script>
<!--	<script data-require="angular-ui-bootstrap@0.3.0" data-semver="0.3.0" src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.3.0.min.js"></script> -->
<script>
    $(function(){
		$("#export").click(function()
		{
            $("#example").tableToCSV();
		});   
		
		 
   });
   
    
</script>
  
	
	<script>
	   
	   function openNav() 
	    {
		document.getElementById("mySidenav").style.width = "360PX";
		$('#sidenavData').load('<?=URL?>help/helpNav/7',{'pageid' :'monthlysummary'});	
		}
						function closeNav()
						{
						document.getElementById("mySidenav").style.width = "0";
						}
						
	
	</script>
<script>
	
</script>

<script>

</script>

	<script type="text/javascript">
		$(function() {
		$('#getAtt').click(function(){ 
			var range=$('#reportrange').text();
			var shift=$('#shift').val();
			var deprt=$('#deprt').val();
			var empl=$('#empl').val();
			var desg=$('#desg').val();
			var area=$('#area').val();
			});
			
	function createpdf()
		  {
		    // console.log($val)
			var pdf = new jsPDF('p', 'pt', 'a3');
			var options = {
					 pagesplit: true,
					 background:'#fff'
				};
			
			pdf.addHTML($("#printsection")[0], options, function()
			{
				//console.log(pdf)	
				pdf.save("absent_report.pdf");
			});
		  }
		
			$('#create_pdf').on('click',function(){
	$('body').scrollTop(0);
	createPDF();
  });
});
	
	
	</script>
	<script>
       $(".datepicker").datepicker( {
	  
		startView: "months", 
		minViewMode: "months",
		format: "MM-yyyy",
		startDate: '-3m',
		endDate: '+0m',
		
		});
    </script>
	
	<script>
	$(document).ready(function()
	{
	$(".toggle-sidebar").click(function(){
	$("#content").toggleClass("col-md-9");
	$("#sidebar").toggleClass("collapsed t2");
	$("#sidebar").load("<?=URL?>admin/helpnav",{'pageid':'monthlysummary'});
	});
	});
	</script>
	<!--<script>
	function fnExcelReport()
{
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange; var j=0;
    tab = document.getElementById('example'); // id of table

    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus(); 
        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
    }  
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

    return (sa);
}
	</script>-->

</html>
