
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../assets/img/favicon.png" />
	<link rel="stylesheet" href="<?=URL?>../assets/css/buttons.dataTables.min.css" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />
	
	
	<title>Geo Fence</title>
	<style>
	.dt-buttons
	{
		    margin-left: 15px!important;
	}
		.red{
			color:red;
			font-weight:'bold';
			font-size:16px;
		}
		.delete{
			cursor:pointer;
		}
		.t2{
			display: none;
		}
	</style>
</head>
<body ng-app ="adminapp"  ng-controller="attroasterCtrl" >
	<div class="wrapper">
		<?php
			$data['pageid']=12.4;
			$this->load->view('menubar/sidebar',$data);
		?>
	    <div class="main-panel">
			<?php
				$this->load->view('menubar/navbar');
			?>
			
			<div class="content" id="content">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-md-12">
	                        <div class="card">
	                            <div class="card-header" data-background-color="green">
	                                
	                                <p class="category" style="color:#ffffff;font-size:17px;" >List of  Geo Centres</p>
									<a rel="tooltip"  data-placement="bottom" title="Help" class="btn btn-success btn-sm toggle-sidebar pull-right " style="position:relative;margin-top:-30px;"  >
									<i class="fa fa-question"></i></a> 
	                            </div>
	                            <div class="card-content">
									<div id="typography">
										<div class="title">
											<div class="row">
												<div class="col-md-8" style="margin-top:-10px" >
													<h3>Manage Geo Centres</h3>
												</div>
												<div class="col-md-4 text-right">
													<a href="<?= URL?>Dashboard/geoSettings" class="btn btn-sm btn-success" type="button" id="add"  title="Add a geo center">	
													<i class="fa fa-plus"> Add</i>
													</a>
												</div>
												
												<!--<div class="col-md-4 text-right">
													
											</div>-->
											</div>
										</div>
										
										<div class="row" style="overflow-x:scroll;">
											<table id="example" class="display table" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th width="16%">Geo Center Name</th>
													<th width="45">Geo Centres</th>
													<th width="10">Centre Coordinates </th>
													
													<th width="8%">Radius(Km)</th>
													<th width="8%" style="background-image:none"!important>Status</th>
													<th width="10%" style="background-image:none"!important>Action</th>
												</tr>
											</thead>
										</table>
										</div>
									</div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>

	       <div class="col-md-3 t2" id="sidebar" style="margin-top:100px;"></div>
			<footer class="footer">
				<div class="container-fluid">	
				</div>
			</footer>
			<footer class="footer">
				<div class="container-fluid">
					<nav class="pull-left">
						
					</nav>
					<!--<p class="copyright pull-right" style="padding-right:25px;" >
              &copy; <script>document.write(new Date().getFullYear())</script>. Developed by<a href="http://www.ubitechsolutions.com/" target="_blank" > Ubitech Solutions </a></p>-->
			  .<a href="http://www.ubitechsolutions.com/" target="_blank" >
					<p class="copyright pull-right" style="padding-right:25px;" >
					Copyright &copy;<script>document.write(new Date().getFullYear())</script>
					Ubitech Solutions. All rights reserved.
					</p>
				</a>
				</div>
			</footer>
		</div>
		</div>

		<!------Edit location modal start------------>
<div id="addDeptE" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Update geo center</h4>
      </div>
      <div class="modal-body">
        
		<form id="deptFromE">
			<input type="hidden" id="did" />
			<div class="row">
				<div class="col-md-12">
					<div class="form-group label-floating">
						<label >Name Of The Geo Center<span class="red"> *</span>
						</label>
						<input type="text" id="locationE" class="form-control" >
					</div>
				</div>
			</div>			
			<div class="row">
				
				<div class="col-md-4">
					<div class="form-group label-floating">
						<label class="control-label">Status <span class="red"> </span></label>
						<select class="form-control" id="statusE" >
							<option value='1'>Active</option>
							<option value='0'>Inactive</option>
						</select>
					</div>
				</div>
				<div class="col-md-4" style="margin-top:-28px;">
					<div class="form-group label-floating">
						<label >Radius(Km)<span class="red"> *</span>
						</label>
						<input type="number" id="radiusE" class="form-control" >
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</form>
		
		
      </div>
      <div class="modal-footer">
        <button type="button" id="saveE"  class="btn btn-success">Update</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!------Edit location modal close------------>	

<!---------------------------->
<div id="updateGeolocation" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Assign Geo Center</h4>
      </div>
      <div class="modal-body">		
	<form>
		<input type="hidden" id="uid" />
			
			<div class="panel">
					<div class="panel-body" >
						<p> Select the employee(s) to assign this geo center. </p>
						<div class="row">
							 <div class="well" style="max-height: 300px;overflow: auto;">
									<ul  class="list-group checked-list-box" id="check-list-box">
									
										<div ng-repeat="c in emparray" >
											<li class=" list-group-item" data-color="success" id="{{c.id}}" ng-click="getchecklistid($index)">
												<label >{{$index+1}}.  {{c.name}} </label>
											</li>	
										</div>							
									</ul>
							</div>
						</div>
						
					</div>
				</div>
			
			
			<div class="clearfix"></div>
	</form>
      </div>
      <div class="modal-footer">
        <button type="button"  class="btn btn-success" ng-click="SaveEmpList1(1)">Assign</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!------------------------------->



<!-----delete dept start--->
<div id="delDept" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>
        <h4 class="modal-title" id="title">Delete Location</h4>
      </div>
      <div class="modal-body">		
		<form>
			<input type="hidden" id="del_did" />
			<div class="row">
				<div class="col-md-12">
					<h4>Do you want to delete this Location "<span id="dna"></span>" ?</h4>
				</div>
			</div>
			<div class="clearfix"></div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="delete"  class="btn btn-success">Delete</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
</div>
<!-----delete dept close--->
</body>
<div id="mySidenav" class="pull-right sidenav" style="background-image:url(<?=URL?>../assets/img/bg7.jpg);">
						<div class="helpHeader"><span><b>&nbsp;&nbsp;<i style="font-size:24px; color:black;"class="fa fa-question-circle" ></i ></b></span><a style="color:black;" href="javascript:void(0)" class="closebtn text-right" onclick="closeNav()">x </a></div>
						<div id="sidenavData" class="sidenavData">
						</div>
					</div>
					
	<script src="<?=URL?>../assets/js/bootstrap-timepicker.min.js" type="text/javascript"></script>

<script src="<?=URL?>../assets/js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="<?=URL?>../assets/js/buttons.print.min.js"></script>
	<script src="<?=URL?>../assets/js/dataTables.buttons.min.js"></script>
	 <script type="text/javascript" src="<?=URL?>../assets/js/moment.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/angular.min.js"></script>
		<script type="text/javascript" src="<?=URL?>../assets/js/angular-datatables.min.js"></script>
		<!--<script type="text/javascript" src="<?=URL?>../assets/js/attRoaster.js"></script>-->
		<script type="text/javascript" src="<?=URL?>../assets/js/buttons.flash.min.js"></script>
      <script type="text/javascript" src="<?=URL?>../assets/js/jszip.min.js"></script>
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>			
			<script type="text/javascript" src="<?=URL?>../assets/js/jquery.dataTables.min.js"></script>
	    <script type="text/javascript" src="<?=URL?>../assets/js/buttons.html5.min.js"></script>		
					
		<?php if(isset($success_sms))
             echo "<script> alert('Your location set successfull.'); </script>";
		 ?>			
					
	<script>
	function openNav() {
							document.getElementById("mySidenav").style.width = "360PX";
							$('#sidenavData').load('<?=URL?>admin/helpNav',{'pageid': 'geofence'});	
						}
						function closeNav(){
							document.getElementById("mySidenav").style.width = "0";
						}
	
	</script>
	
	
	
	
	
	
	
	

	<script type="text/javascript">
			$(document).ready(function() {
		
			var table=$('#example').DataTable( {
					"orderable": false,
					//"scrollX": true,
				 dom: 'Bfrtip',
					buttons: [
							
							{
								"extend":'colvis',
								"columns":':not(:last-child)',
							}
							],
					
			columnDefs: [
                  { "visible": false, "targets": 2 },
    { orderable: false, targets: [4,5]}
                  ],

				//columnDefs: [ { orderable: false, targets: [4,5]}],
				//"scrollX": true,
				"contentType": "application/json",
				"ajax": "<?php echo URL;?>dashboard/getGeolocation",
				"columns":  [
							{ "data": "name" },
							{ "data": "location" },
							{ "data": "latlong" },
							{ "data": "radius" },
							{ "data": "status" },
							{ "data": "action" },
							]
			} );
		
			$(document).on("click", "#delete", function () {
				var id=$('#del_did').val();
	
				$.ajax({url: "<?php echo URL;?>Dashboard/deleteLocation",
						data: {"did":id},
						success: function(result){
							result=JSON.parse(result);
							
							if(result.afft){
								$('#delDept').modal('hide');
								doNotify('top','center',2,'Location deleted successfully.');
								 table.ajax.reload();
							}else{
								$('#delDept').modal('hide');
								doNotify('top','center',4,'Cannot be deleted, It is currently assigned to '+result.emp+' employee(s).');
							}
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});
			$(document).on("click", ".edit", function () {
				
				
				$('#deptNameLableE').text('');
				$('#deptName').attr('placeholder',"");
				$('#did').val($(this).data('did'));
				$('#locationE').val($(this).data('name'));
				$('#radiusE').val($(this).data('radius'));
				$('#statusE').val($(this).data('sts'));	
			});
			$(document).on("click", ".delete", function () {
				$('#del_did').val($(this).data('did'));
				$('#dna').text($(this).data('dname'));
			});	
$('#saveE').click(function(){
				  if($('#locationE').val().trim()==''){
					  $('#locationE').focus();
						doNotify('top','center',4,'Please enter the Geo Center Name.');
					  return false;
				  }
				  if($('#radiusE').val().trim()==''){
					  $('#radiusE').focus();
						doNotify('top','center',4,'Please enter the Fence Radius.');
					  return false;
				  }
				   var did=$('#did').val();
				   var dna =$('#locationE').val();
				   var dra =$('#radiusE').val();
				   var sts=$('#statusE').val();
				   if(dra < 0.05)
			 {
                        $('#radius').focus();
						doNotify('top','center',4,'Radius should be greater than 0.05 (km) ');
						return false;
             }

				   $.ajax({url: "<?php echo URL;?>Dashboard/editLocation",
						data: {"did":did,"dna":dna,"dra":dra,"sts":sts},
						success: function(result){
							 
							if(result==1){
								doNotify('top','center',2,'Location Updated Successfully.');
								$('#addDeptE').modal('hide');
								document.getElementById('deptFromE').reset();
								 table.ajax.reload();
							}else if(result==2){
								doNotify('top','center',3,'Location '+dna+' already exists.');
							}
							else{
							doNotify('top','center',4,'No changes found');
							document.getElementById('deptFromE').reset();
								$('#addDeptE').modal('hide');
							}
						 },
						error: function(result){
							doNotify('top','center',4,'Unable to connect API');
						 }
				   });
			});	
$(document).ready(function()
		{
				$('#select_all').on('click',function()
				{
					
					if(this.checked){
						$('.checkbox').each(function()
						{
						this.checked = true;
						});
					}else{
						 $('.checkbox').each(function()
						 {
							this.checked = false;
						});
					}
				});
			
		});
		
		
			$(document).on("click", ".checkbox", function ()
			{
						if($('.checkbox:checked').length == $('.checkbox').length)	
						{
							$('#select_all').prop('checked',true);
						}
						else
						{
						$('#select_all').prop('checked',false);
						}
			});			
			});
		
	</script>
	<script>
		$(document).ready(function(){
		$(".toggle-sidebar").click(function(){
		$("#sidebar").toggleClass("collpsed t2");
		$("#content").toggleClass("col-md-9");
		$("#sidebar").load("<?=URL?>admin/helpnav",{'pageid':'geofence'});
		})
		});
		
		 
	  
		
		
			
			
		
	</script>
	
	<script>
	var app = angular.module('adminapp', []);
	app.controller('attroasterCtrl', function($scope, $http, $timeout) 
	{
	$scope.hastrue=false;
	
	$scope.GetEmpList1 = function($geoid)
 	  {
		$scope.emparray=[];
		$scope.geoid=$geoid;
		$scope.hastrue=true;
		var xsrf = $.param({geoid: $scope.geoid});
		$http({
			url: 'getemployeebygeolocation',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config){
			
				
				$scope.emparray=data.data;
				//console.log(data.data);
				setTimeout(function(){
					$timeout(function(){	$scope.getrow();}, 500); 
				}, 1000);
			
			$scope.hastrue=false;
		}).error(function (data, status, headers, config) {
			//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}
	
	
	
 ////////////List group item function ///////////////
 $scope.getrow= function ($index) {
	 //alert($index);
     $('.list-group.checked-list-box .list-group-item').each(function () {
        
        // Settings
        var $widget = $(this),
            $checkbox = $('<input type="checkbox" class="hidden" value="'+$index+'" id="'+$index+ 'checked"/>'),
            color = ($widget.data('color') ? $widget.data('color') : "primary"),
            style = ($widget.data('style') == "button" ? "btn-" : "list-group-item-"),
            settings = {
                on: {
                    icon: 'fa fa-check-square-o'
                },
                off: {
                    icon: 'fa fa-square-o'
                }
            };
            
        $widget.css('cursor', 'pointer')
        $widget.append($checkbox);

        // Event Handlers
        $widget.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateDisplay();
        });
        $checkbox.on('change', function () {
            updateDisplay();
        });
        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');
//console.log(isChecked);
            // Set the button's state
            $widget.data('state', (isChecked) ? "on" : "off");
				
            // Set the button's icon
            $widget.find('.state-icon')
                .removeClass()
                .addClass('state-icon ' + settings[$widget.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $widget.addClass(style + color + ' active');
            } else {
                $widget.removeClass(style + color + ' active');
            }
        }
		// Initialization
			function init() {
				
				if ($widget.data('checked') == true) {
					$checkbox.prop('checked', !$checkbox.is(':checked'));
				}
				
				updateDisplay();

				// Inject the icon if applicable
				if ($widget.find('.state-icon').length == 0) {
					$widget.prepend('<span class="state-icon ' + settings[$widget.data('state')].icon + '"></span>');
				}
			}
        init();
    });
};
 
 
	 $scope.getchecklistid=function($index)
		{
			if($scope.emparray[$index]['sts'] == 0)
			{
				$scope.emparray[$index]['sts'] = 1;
			}
			else{
				$scope.emparray[$index]['sts'] = 0;
			}
		}
 $scope.SaveEmpList1=function($id){
	// alert($id);
	// return false;
		var total= $("#check-list-box li").length;
		var selectcheck= $(".list-group-item.list-group-item-success.active").length;
	
		if(selectcheck!=0){
			var json=angular.toJson($scope.emparray);			
			//console.log(json);
			//alert(json);
			
			var xsrf = $.param({ geoid:$scope.geoid,emplist:json});
			$http({
				url: 'SaveEmpGeoList',
				method: "POST",
				data: xsrf,
				
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
				}).success(function(data, status, headers, config){
				$scope.hastrue = false;
				$('#updateGeolocation').modal('hide');
				
				doNotify('top','center',2,'Geo Center assigned successfully.');
				
			}).error(function(data, status, headers, config){
			
				$scope.hastrue=false;
			});
		} else 
			{
			//alert("Select atleast one employee ");
			doNotify('top','center',4,'Please select atleast one employee.');
			return false;
			}
	}
		
	});
	</script>
</html>
