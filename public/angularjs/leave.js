/*! UBIHRM ubiapp.js
 * ================
 *
 * @Author  Harish Kushwah
 * @Email   <harish@ubitechsolutions.com>
 * @version 1.0.0.0
 */
'use strict';
//Make sure jQuery has been loaded before app.js
if (typeof jQuery === "undefined") {
  throw new Error("UBIHRM requires jQuery");
}
//'ui.bootstrap', 'xeditable', 'ngSanitize'
var app = angular.module('leaveapi', []);
/*app.run(function(editableOptions) {
  editableOptions.theme = 'bs3'; // bootstrap3 theme. Can be also 'bs2', 'default'
});*/
app.directive('myPostRepeatDirective', function() {
  return function(scope, element, attrs) {
    if (scope.$last){
      // iteration is complete, do whatever post-processing
      // is necessary
		jQuery.fn.multiselect = function() {
			$(this).each(function() {
				var checkboxes = $(this).find("input:checkbox");
				checkboxes.each(function() {
					var checkbox = $(this);
					// Highlight pre-selected checkboxes
					if (checkbox.prop("checked"))
						checkbox.parent().addClass("multiselect-on");
		 
					// Highlight checkboxes that the user selects
					checkbox.click(function() {
						if (checkbox.prop("checked"))
							checkbox.parent().addClass("multiselect-on");
						else
							checkbox.parent().removeClass("multiselect-on");
					});
				});
			});
		};
		
		$(function() {
			 $(".multiselect").multiselect();
		});
    }
  };
});

//////////////////////// Leave Eligibility Controller///////////////////////

app.controller('leavedashCtrl', function($scope, $http, $timeout) {

$scope.hastrue=false;
$scope.leavedasharr1=[]; 
$scope.monthview ="";
$scope.fiscalview ="";
$scope.filscalid=0;

	$scope.onfetch=function($val,$type)
	{
		
		if($val==1){
			onfetch(1,$type);
			$scope.val=1;
		}else{
			onfetch(2,$type);
			$scope.val=2;
		}
	}
	function onfetch($val,$type)
	{
		$scope.hastrue=true;
		var xsrf = $.param({monthview:$scope.monthview,fiscalid: $scope.filscalid});
		
		$http({
			url: path+"leave/getLeaveDashboard/"+$val+'/'+$type,
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {
				if(data.status){
					$scope.leavedasharr1=[];
					$scope.leavedasharr1=data.data['leavetype'];
					
					$scope.leavedasharr2=[];
					$scope.leavedasharr2=data.data['teamleave'];
					console.log(data.data['teamleave']);
					$scope.fiscalformat=data.fiscal_format;
					$scope.filscalid=data.filscalid;
					//$scope.fiscalview =data.data['financialyear'][0]['name'];
					$scope.monthview1=data.curmonth;
					///// TOTAL CASH PAY BY CURRRENT FISCAL  ////////////
					var bar = new Morris.Bar({
					  element: 'bar-chart1',
					  resize: true, stacked:false,
					  xLabels: 'label', 
					  xLabelAngle: -90, 
					  data: data.data['employeeonleave'],
					  barColors: ['#FF8781', '#FF0000'],
					  xkey: 'label',
					  ykeys:  ['value'],
					  labels: ['Total Employee'],
					  hideHover: 'auto'
					});	
					
					///// TOTAL CASH PAY BY CURRRENT FISCAL  ////////////
					var bar = new Morris.Bar({
					  element: 'bar-chart3',
					  resize: true, stacked:false,
					  xLabels: 'label', 
					  xLabelAngle: -90, 
					  data: data.data['leaveutilized'],
					  barColors: ['#4BBCDC', '#B5B7AF'],
					  xkey: 'label',
					  ykeys:  ['paidleave', 'unpaidleave'],
					  labels: ['Paid leave','Unpaid Leave'],
					  hideHover: 'auto'
					});	
					//DONUT CHART
					var donut = new Morris.Donut({
					  element: 'sales-chart',
					  resize: true,
					  colors: ["#3399FF", "#FF0000", "#009933"],
					  data: $scope.leavedasharr1,
					  hideHover: 'auto'
					});
					
					var b = $('#calendar').fullCalendar('getDate');
					$scope.monthview = b.format('YYYY-MM-DD');	
					
					var backcolor='#00a65a';
					var event1=[];
					for(var i=0; i<data.data['teamleave'].length; i++)
					{
						event1.push({
							title:data.data['teamleave'][i]['label'],
							start:data.data['teamleave'][i]['from'],
							end:data.data['teamleave'][i]['to'],
							description:data.data['teamleave'][i]['description'],
							
							backgroundColor: data.data['teamleave'][i]['backcolor'], 
							borderColor: data.data['teamleave'][i]['backcolor'] 
							
						});
					}
					if($('#calendar').fullCalendar( 'clientEvents') != "") { 
						//$('#calendar').fullCalendar( 'removeEvents').fullCalendar('removeEventSources'); 
						$('#calendar').fullCalendar( 'removeEvents', function(e){
							return true;
							}); 
					}
					$('#calendar').fullCalendar( 'addEventSource', event1);
				}
				else{
				errorMessage(data.errorMsg);
			}
				$scope.hastrue=false;
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
			
	}


			$('body').on('click', 'button.fc-prev-button', function() {
				var b = $('#calendar').fullCalendar('getDate');
				$scope.monthview = b.format('YYYY-MM-DD');								
				onfetch($scope.val);
			});
			$('body').on('click', 'button.fc-next-button', function() {
				var b = $('#calendar').fullCalendar('getDate');
				$scope.monthview = b.format('YYYY-MM-DD');
				onfetch($scope.val);
			});
			$('body').on('click', 'button.fc-today-button', function() {
				//alert("today");
			});	


	
});
/////////////////////////// Leavetype Controller Starts From Here  ///////////////////////////////////

app.controller('leavetypeCtrl', function($scope, $http, $timeout) {

	$scope.hastrue=false;
	$scope.leavetypeid=0;
	$scope.leaveapply="";
	$scope.leavetypename="";
	$scope.leavedays=0;
	$scope.fiscalid=0;
	$scope.leaveusablests="1";
	$scope.leaveallowedsts="";
	$scope.leavecolor="";
	$scope.division=0;
	$scope.grade=0;
	$scope.department=0;
	$scope.designation=0;
	$scope.religion=0;
    $scope.gender=0;
    $scope.marital=0;
    $scope.employeeids="";
    $scope.employeeexperience="";
	$scope.totalleave=0;
	$scope.year=0;
	$scope.month=0;
	$scope.leavecalculate=1;
	$scope.check1=false;
	$scope.days1=0;
	$scope.check2=false;
	$scope.days2=0;
	$scope.check3=false;
	$scope.days3=0;
	$scope.check4=false;
	$scope.days4=0;
	$scope.check5=true;
	$scope.check6=true;
	$scope.check7=false;
	$scope.days7=0;
	$scope.check8=false;
	$scope.days8=0;
	
	$scope.fullpay=0;
	$scope.halfpay=0;
	$scope.nopay=0;
	$scope.workday=0;
	$scope.leavedayflag=true;
	$scope.leavepayrule="";
	$scope.leaverule="";
	$scope.payrule = 1;
	$scope.visiblests = 0;
	$scope.period = 2;
	$scope.compoffsts="";
	$scope.workfromhomests="";
	$scope.carriedforward="";
	$scope.includeweekoff="";
	
    $scope.leaveperdayarray=[]; 
    $scope.departarray=[]; 
	$scope.divisionarray=[];
	$scope.gradearray=[];
	$scope.departarray=[];
	$scope.desigarray=[];
	$scope.otherarray=[];
	$scope.selection=[];
	$scope.religionarray=[];
	$scope.employees=[];
	$scope.annualleave="";
	$scope.ProbationSts="";
	$scope.desc="";
	$scope.usable2=1;
	$scope.newemployeearr=[];
	onfetch('setup/getalldivision',1);
	onfetch('setup/getallgrade',2);
	onfetch('setup/getalldepartment',3);
	onfetch('setup/getalldesignation',4);
	onfetch('other',5);
	onfetch('leave/getallleaveemployee',6);
	onfetch('other/getallreligion',7);
	
	$scope.getId = function($id) {
		$scope.leavetypeid=$id;
	}
	$scope.ondelete =function()
	{
	//$scope.rolearr=[];
	//$scope.hastrue=true;
	$http({
        url: path+'leave/deleteleavetype/'+$scope.leavetypeid,
        method: "POST",
        headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
      }).success(function (data, status, headers, config) {
			if(data.status){
			
				 successMessage(data.successMsg);
				 table.draw();
			}else{
				errorMessage(data.errorMsg);
			}
			$scope.leavetypeid=0;
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
}
	setTimeout(function(){ 
		var value=$("#leavecolor").val();
		if(value != ""){
			$("#cp").css('backgroundColor',value);
		}
		else{
			$("#cp").css('backgroundColor','#000000');
		}
		
	 }, 1000);
	$scope.toggleSelection = function($idx) {
		//errorMessage($idx);
	 //var idx = $scope.employees[$index].id;
	 //var result = $.grep($scope.selection, function(e){ return e.id == idx; });
	 var flg=true;
	 var x=0;
	 for ( var i=0; i<$scope.selection.length; i++) {
		if ($scope.selection[i].id == $idx){ 
			flg = false;x=i;
			break;
			}
	  }
	 
	  if(flg){
		var x=0;
		for ( var i=0; i<$scope.employees.length; i++) {
			if ($scope.employees[i].id == $idx){ 
				x=i;
				break;
				}
		  }
		  
		$scope.selection.insert($scope.selection.length,$scope.employees[x]);
		$scope.employees[x].sts=1;
	  }else{
		$scope.selection.remove(x);
		$scope.employees[x].sts=0;
	  }
   };
	setTimeout(function(){
		$('.rulecheck input').on('ifToggled', function(event){
			if(event.target.name=="check1"){
				$scope.check1=event.target.checked;				
			}else if(event.target.name=="check2"){
				$scope.check2=event.target.checked;
			}else if(event.target.name=="check3"){
				$scope.check3=event.target.checked;
			}else if(event.target.name=="check4"){
				$scope.check4=event.target.checked;
			}else if(event.target.name=="check5"){
				$scope.check5=event.target.checked;
			}else if(event.target.name=="check6"){
				$scope.check6=event.target.checked;
			}else if(event.target.name=="check7"){
				$scope.check7=event.target.checked;
			}else if(event.target.name=="check8"){
				$scope.check8=event.target.checked;
			}
		});
		$('.leavepay input').on('ifChecked', function(event){
			$scope.payrule=event.target.value;
		});
		$('.usablefor input').on('ifChecked', function(event){	
			$scope.leaveusablests=event.target.value;
			if(event.target.value=="1"){
				$('#personal2').removeClass("fade in active");
				$('#personal1').addClass("fade in active");
			}else if(event.target.value=="2"){
				$('#personal1').removeClass("fade in active");
				$('#personal2').addClass("fade in active");
				$scope.division=0;
				$scope.grade=0;
				$scope.department=0;
				$scope.designation=0;
				$scope.gender=0;
				$scope.marital=0;
				$scope.religion=0;
			}
		});	
	}, 50);
	$('#cf').hide();
	$('input').on('ifChecked', function(event){
	  if(event.target.name=='annualleave'){
		$scope.annualleave=event.target.value;
		
		//$('#workday').prop('disabled', false);
		$('#cf').show();
	 }
	  if(event.target.name=='ProbationSts'){
		$scope.ProbationSts=event.target.value;
		
		$('#cf').show();
	 }
	 if(event.target.name=='carryforward'){
		$scope.carryforward=event.target.value;
		
	 }
	  if(event.target.name=='visiblests'){
		$scope.visiblests=event.target.value;
		
	 }
	 if(event.target.name=='leavecal'){
		$scope.leavecalculate=event.target.value;
		
	 }
	  
	});		
	$('input').on('ifUnchecked', function(event){
	  if(event.target.name=='annualleave'){
	  $scope.annualleave=0;
	  $scope.carryforward=0;
	  $('#cf').hide();
	 // $('#workday').prop('disabled', true);
	  }
	  if(event.target.name=='ProbationSts'){
	  	  $scope.ProbationSts=0;
	  $('#cf').hide();
	  }

	});			
   
	
	Array.prototype.insert = function (index, item) {
	  this.splice(index, 0, item);
	};	
	Array.prototype.remove = function (index) {
	  this.splice(index,1);
	};
    function onfetch($val, $id)
	{
		$scope.hastrue=true;
		$http({
			url: path+$val,
			method: "POST",
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {
				
				if(data.status){
					if($id==1){
						$scope.divisionarray=[];
						$scope.divisionarray=data.data;
						$scope.divisionarray.insert(0,{id:0,name:"----- All -------"});
					}else if($id==2){
						$scope.gradearray=[];
						$scope.gradearray=data.data;
						$scope.gradearray.insert(0,{id:0,name:"----- All -------"});
					}else if($id==3){
						$scope.departarray=[];
						$scope.departarray=data.data;
						$scope.departarray.insert(0,{id:0,name:"----- All -------"});
					}else if($id==4){
						$scope.desigarray=[];
						$scope.desigarray=data.data;
						$scope.desigarray.insert(0,{id:0,name:"----- All -------"});
					}else if($id==5){
						$scope.otherarray=[];
						$scope.otherarray=data.data;
						$scope.otherarray.insert(0,{id:0,type:"Gender",name:"----- All -------"});
						$scope.otherarray.insert(1,{id:0,type:"MaritalStatus",name:"----- All -------"});
					}else if($id==6){
						$scope.employees=[];
						$scope.employees=data.data;
					}else if($id==7){
						$scope.religionarray=[];
						$scope.religionarray=data.data;
						$scope.religionarray.insert(0,{id:0,name:"----- All -------"});
					}
					$timeout(function() {
					$('.selectpicker').selectpicker('refresh');                      
				}, 1000);
				}
				$scope.hastrue=false;
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
			
	}
	$scope.onfetchleavetype =function($id)
	{
		$scope.hastrue=true;
		var xsrf = $.param({leavetypeid: $id});
		$http({
			url: path+'leave/getaleavetype',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {

			if(data.status){
			
				$scope.leavetypename=data.data[0]['name'];
				$scope.leavedays=parseFloat(data.data[0]['leavedays']);
				$scope.fiscalid=data.data[0]['fiscal_id'];
				
				$scope.leaveallowedsts=data.data[0]['leaveallowedsts'];
				$scope.leavecolor=data.data[0]['leavecolor'];
				$scope.division=data.data[0]['division'];
				$scope.grade=data.data[0]['grade'];
				$scope.religion=data.data[0]['religion'];
				$scope.department=data.data[0]['department'];
				$scope.designation=data.data[0]['designation'];
				$scope.gender=data.data[0]['genderid'];
				$scope.marital=data.data[0]['maritalid'];
				$scope.leaveapply = data.data[0]['leaveapply'];
				$scope.workday = data.data[0]['workday'];
				$scope.period= data.data[0]['period'];
				
				$scope.employeeexperience=data.data[0]['employeeexperience'];
				$scope.desc = data.data[0]['desc'];
				if(data.data[0]['annualleave']==1){
					//$('#annualleave').iCheck("check");

				}
				if(data.data[0]['ProbationSts']==1){
				//	$('#ProbationSts').iCheck("check");
					$scope.ProbationSts = true;

				}
				if(data.data[0]['carriedforward']==1){
				//	$('#ProbationSts').iCheck("check");
					$scope.carriedforward = true;
				}
				if(data.data[0]['includeweekoff']==1){
				//	$('#ProbationSts').iCheck("check");
					$scope.includeweekoff = true;

				}
				/*if(data.data[0]['carryforward']==1){
					$('#c1').iCheck("check");
				}else{
					$('#c2').iCheck("check");
				}*/
				
			/*	$scope.visiblests = false;
				if(data.data[0]['visiblests']==0){
					$scope.visiblests = true;
				} */
				if(data.data[0]['leavecal']==1){
					
					//$('#l1').iCheck("check");
				}else{
					//$('#l2').iCheck("check");
				}
				$scope.payrule=data.data[0]['leavepayrule'];
				$scope.visiblests=data.data[0]['visiblests'];
				$scope.usable2=data.data[0]['leaveusablests'];
				$scope.employeeids =data.data[0]['employeeids'];
			//	$scope.employeeids = temparr[0];
			//	console.log($scope.employeeids);
				
				var tempexp = (data.data[0]['employeeexperience']).split(',');
				$scope.year = tempexp[0];
				$scope.month= tempexp[1];
				
				if(data.data[0]['compoffsts']==1){
				//	$('#ProbationSts').iCheck("check");
				$scope.compoffsts =true;
				}
				
				if(data.data[0]['workfromhomests']==1){
				//	$('#ProbationSts').iCheck("check");
				$scope.workfromhomests = true;
				}
				
				/*var temppayrule = (data.data[0]['leavepayrule']).split(',');
				$scope.fullpay = temppayrule[0];
				$scope.halfpay = temppayrule[1];
				$scope.nopay = temppayrule[2];
				leavepayrule();*/
				$timeout(function(){
					for ( var x=0; x<$scope.employeeids; x++){
						for ( var i=0; i<$scope.employees.length; i++){
							if ($scope.employees[i].id == $scope.employeeids[x]){ 
							$('#employeeids').append('<span>'+$scope.employees[j].name+'</span><br>');
							$scope.newemployeearr.push($scope.employees[j]);
								
								
							}
						}
					} 
				}, timeo); 
		/*		for(var i=0; i<$scope.employeeid.length; i++){
			for(var j=0;j<$scope.employeearray.length; j++){
				if($scope.employeearray[j].id==$scope.employeeid[i]){
					$('#empidlist').append('<span>'+$scope.employeearray[j].name+'</span><br>');
					$scope.newemployeearr.push($scope.employeearray[j]);
				//	console.log($scope.newemployeearr);
				}
			}
		}
				*/
				
				/*var temprule = (data.data[0]['leaverule']).split(',');
				for ( var x=0; x<temprule.length; x++){
					var temp = (temprule[x]).split('=');
					if(temp[0]==='true'){
						$('#check'+(x+1)).iCheck("check");
						if(x==0){
							$scope.days1=temp[1];
						}else if(x==1){
							$scope.days2=temp[1];
						}else if(x==2){
							$scope.days3=temp[1];
						}else if(x==3){
							$scope.days4=temp[1];
						}else if(x==6){
							$scope.days7=temp[1];
						}else if(x==7){
							$scope.days8=temp[1];
						}
					}
				}*/
				
				if(data.data[0]['leaveusablests']==1){
					//$('#usable1').iCheck("check");
				}else{
					//$('#usable2').iCheck("check");
				}
			}
			
			$('.my-colorpicker2').colorpicker({color:$scope.leavecolor}).on('changeColor.colorpicker', function(event){
				$("#leavecolor").focus();
				var e = jQuery.Event("change");
				e.keyCode = 32;                     
				$("#leavecolor").trigger(e); 
			
			});
				
			$scope.hastrue=false;
			
		}).error(function (data, status, headers, config) {
			//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}

	$scope.onleaverulechange = function()
	{	
		leavepayrule();
	}
	function leavepayrule()
	{
		if($scope.fullpay=="" && $scope.halfpay=="" && $scope.nopay=="")
		{
			$scope.leavedayflag=false;
			return;
		}
		var count=0;
		count = parseInt($scope.fullpay)+parseInt($scope.halfpay)+parseInt($scope.nopay);
		if($scope.leavedays==count)
		{
			$scope.leavedayflag=true;
		}else{
			$scope.leavedayflag=false;
		}
	}
	function validate()
	{		
		if($scope.leaveusablests=="2"){
			$scope.employeeids=angular.toJson($scope.selection);
			
		}else{
			$scope.employeeids=angular.toJson(new Array());
		}
		
		$scope.employeeexperience = $scope.year+","+$scope.month;		
		
		$scope.leavepayrule = $scope.payrule;//$scope.fullpay+","+$scope.halfpay+","+$scope.nopay;
		$scope.leaverule = $scope.check1+"="+$scope.days1+","+$scope.check2+"="+$scope.days2+","+$scope.check3+"="+$scope.days3+","+$scope.check4+"="+$scope.days4+","+$scope.check5+"=0,"+$scope.check6+"=0,"+$scope.check7+"="+$scope.days7+","+$scope.check8+"="+$scope.days8;
		
	}
	

	$scope.oncreate = function($val)
	{	
	//	validate();
		if($scope.compoffsts == true){$scope.compoffsts = 1;}
		if($scope.workfromhomests == true){$scope.workfromhomests = 1;}
		if($scope.ProbationSts == true){$scope.ProbationSts = 1;}
		if($scope.carriedforward == true){$scope.carriedforward = 1;}
		if($scope.includeweekoff == true){$scope.includeweekoff = 1;}
		
		$scope.hastrue=true;
		
		var xsrf = $.param({leavetypename: $scope.leavetypename, leavedays:$scope.leavedays,fiscalid:$scope.fiscalid,  usable2:$scope.usable2,leaveallowedsts:$scope.leaveallowedsts,leavecolor:$scope.leavecolor,departmentids:$scope.department,designationids:$scope.designation,genderid:$scope.gender,maritalid:$scope.marital, employeeids:$scope.employeeids,employeeexperience:$scope.employeeexperience, division: $scope.division, grade: $scope.grade, payrule: $scope.payrule, leaverule: $scope.leaverule, leaveapply:$scope.leaveapply, workday:$scope.workday,desc:$scope.desc,annualleave:$scope.annualleave, religion:$scope.religion,carryforward:$scope.carryforward,visiblests:$scope.visiblests,leavecal:$scope.leavecalculate,ProbationSts:$scope.ProbationSts,period:$scope.period,compoffsts:$scope.compoffsts,workfromhomests:$scope.workfromhomests, carriedforward:$scope.carriedforward,includeweekoff:$scope.includeweekoff});
		$http({
			url: path+'leave/createleavetype',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
				if(data.status){
					successMessage(data.successMsg);					
					$scope.leavetypename="";
					$scope.leavedays=0;
					$scope.fiscalid="";
					$scope.leaveusablests="1";
					$scope.leaveallowedsts="";
					$scope.leavecolor="";
					$scope.division=0;
					$scope.grade=0;
					$scope.department=0;
					$scope.designation=0;
					$scope.gender=0;
					$scope.religion=0;
					$scope.marital=0;
					$scope.employeeids="";
					$scope.employeeexperience="";			
					$scope.leavetypeid=0;
					$scope.leaveapply="";
					$scope.workday =0;
					if($val==1){
						//window.open(path+"leave/leavetype", "_self");
						$timeout(function(){window.open(path+"leave/leavetype", "_self");}, timeo);
					}
				}else{
					errorMessage(data.errorMsg);
				}
				$scope.hastrue=false;
		}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
		});
	}

	$scope.onupdate = function($val)
	{
	//	validate();
		
		if($scope.compoffsts == true){$scope.compoffsts = 1;}else{$scope.compoffsts = 0;}
		if($scope.workfromhomests == true){$scope.workfromhomests = 1;}else{$scope.workfromhomests = 0;}
		if($scope.ProbationSts == true){$scope.ProbationSts = 1;}else{$scope.ProbationSts = 0;}
		if($scope.carriedforward == true){$scope.carriedforward = 1;}else{$scope.carriedforward = 0;}
		if($scope.includeweekoff == true){$scope.includeweekoff = 1;}else{$scope.includeweekoff = 0;}

		
		$scope.hastrue=true;
		var xsrf = $.param({leavetypeid: $scope.leavetypeid, leavetypename: $scope.leavetypename, leavedays:$scope.leavedays,fiscalid:$scope.fiscalid,  usable2:$scope.usable2,leaveallowedsts:$scope.leaveallowedsts,leavecolor:$scope.leavecolor,departmentids:$scope.department,designationids:$scope.designation,genderid:$scope.gender,maritalid:$scope.marital, employeeids:$scope.employeeids,employeeexperience:$scope.employeeexperience, division: $scope.division, grade: $scope.grade, payrule: $scope.payrule, leaverule: $scope.leaverule, leaveapply:$scope.leaveapply, workday:$scope.workday,desc:$scope.desc,annualleave:$scope.annualleave, religion:$scope.religion,carryforward:$scope.carryforward,visiblests:$scope.visiblests,leavecal:$scope.leavecalculate,ProbationSts:$scope.ProbationSts,period:$scope.period,compoffsts:$scope.compoffsts,workfromhomests:$scope.workfromhomests,carriedforward:$scope.carriedforward,includeweekoff:$scope.includeweekoff});
		//errorMessage(xsrf);
		$http({
			url: path+'leave/updatedeleavetype',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
		
			if(data.status){
				
				$scope.leaveapply="";
				$scope.leavetypename="";
				$scope.leavedays="";
		        $scope.fiscalid="";
				$scope.leaveusablests="";
				$scope.leaveallowedsts="";
				$scope.leavecolor="";
				$scope.departmentids="";
				$scope.designationids="";
				$scope.religion=0;
				$scope.genderid="";
				$scope.maritalid="";
				$scope.employeeids="";
				$scope.employeeexperience="";
				$scope.createdate="";  
				$scope.createid="";
				$scope.lmodifieddate="";
				$scope.lmodifiedid="";				
				$scope.leavetypeid=0;
				$scope.workday =0;
				successMessage(data.successMsg);
				if($val==1){
					//window.open(path+"leave/leavetype", "_self");
					$timeout(function(){window.open(path+"leave/leavetype", "_self");}, timeo);
				}				
			}else{
				errorMessage(data.errorMsg);
			}
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}
});

/////////////////////////// EmployeeLeave Controller Starts From Here  ///////////////////////////////////
app.directive('onFinishRender', function ($timeout) {
    return {
        restrict: 'A',
        link: function (scope, element, attr) {
            if (scope.$last === true) {
                $timeout(function () {
                    scope.$emit('ngRepeatFinished');
                });
            }
        }
    }
});
app.controller('employeeleaveCtrl', function($scope, $http, $timeout) {

	$scope.hastrue=false;
    $scope.employeeid="";
	$scope.employeeleaveid=0;
	$scope.fromdate="";
	$scope.todate="";
	$scope.leavereason="";
	$scope.leavestatus="";
	$scope.leavevalidsts="";
	$scope.applydate="";
	$scope.approvercomment="";
	$scope.resumptiondate="";
    $scope.approvedby=0; 
    $scope.leavetypeid=0;
	//$scope.leavevalidsts=[];
    $scope.division=0;
    $scope.department=0;
	$scope.designation=0;
	$scope.applydate="";
	$scope.fromdaytype=1;
	$scope.todaytype=1;
	$scope.timeoffrom=1;
	$scope.timeofto=1;
    $scope.divisionarray=[];
	$scope.desigarray=[];
	$scope.departarray=[];
	$scope.leavestsarray=[];
	$scope.employeearray=[];
	$scope.leavetypearray=[];
    $scope.entitled=0;
	$scope.carryforward=0;
	$scope.advance=0;
	$scope.unpaid=0;
	$scope.leavelapse=0;
	$scope.leaveat="";
	$scope.dayseligible=0;
	onfetch('setup/getalldivision',1);
	onfetch('other',2);
	//onfetch('leave/getallleavetype',3);
	onfetch('leave/getallleaveemployee',4);
	onfetch('setup/getalldepartment',5);
	onfetch('setup/getalldesignation',6);
	//onfetch('leave/getallleavetype',7);
	$scope.$on('ngRepeatFinished', function(ngRepeatFinishedEvent) {
    //you also get the actual event object
	//
	//table = $('#example1').DataTable();
	$scope.leavetimediff=function($leaveto){
		var leavefrom=$( '#leavefrom' ).datepicker( "getDate" );
		 leavefrom.setDate(leavefrom.getDate());
		 $('#leaveto').datepicker("remove");
		$('#leaveto').datepicker({
			startDate: leavefrom
		});
	}
  
	
		var table = $('#example1').DataTable({
			 
		scrollY:        "500px", 
       searching:true,
        scrollCollapse: true, ordering:false,
        paging:         false,
		
		"drawCallback": function ( settings ) {
				var api = this.api();
				var rows = api.rows( {page:'current'} ).nodes();
				var last=null;
	 
				api.column(0, {page:'current'} ).data().each( function ( group, i ) {
					if ( last !== group ) {
						$(rows).eq( i ).before(
							'<tr class="group"><td class="bg-success text-bold text-left" colspan="'+(4)+'">'+group+'</td></tr>'
						);
						last = group;
					}
				} );
			}
				
        });
		table.column(0).visible(false);
	
	});
	
	$scope.getId = function($id) {
		$scope.employeeleaveid=$id;
	}
	$scope.ondelete =function()
	{
	//$scope.rolearr=[];
	//$scope.hastrue=true;
	$http({
        url: path+'leave/deleteemployeeleave/'+$scope.employeeleaveid,
        method: "POST",
        headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
      }).success(function (data, status, headers, config) {
			if(data.status){
			
				 successMessage(data.successMsg);
				 table.draw();
			}else{
				errorMessage(data.errorMsg);
			}
			$scope.employeeleaveid=0;
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
}
	Array.prototype.insert = function (index, item) {
	  this.splice(index, 0, item);
	};
   function onfetch($val, $id)
	{
		$scope.hastrue=true;
		$http({
			url: path+$val,
			method: "POST",
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {
				
				if(data.status){
					if($id==1){
						$scope.divisionarray=[];
						$scope.divisionarray=data.data;
						$scope.divisionarray.insert(0,{id:0,name:"------All-------"});
                                               
					}else if($id==2){
						$scope.leavestsarray=[];
						$scope.leavestsarray=data.data;
						
                                                
					}else if($id==3){
						$scope.leavetypearray=[];
						$scope.leavetypearray=data.data;
						
                                              
					}
					else if($id==4){
						$scope.employeearray=[];
						$scope.employeearray=data.data;
					}
					else if($id==5){
						$scope.departarray=[];
						$scope.departarray=data.data;
						$scope.departarray.insert(0,{id:0,name:"------All-------"});
					}
					else if($id==6){
						$scope.desigarray=[];
						$scope.desigarray=data.data;
						$scope.desigarray.insert(0,{id:0,name:"------All-------"});
					}else if($id==7){
						$scope.leavetypearray=[];
						$scope.leavetypearray=data.data;
						$scope.leavetypearray.insert(0,{id:0,name:"------All-------"});
					}
				}
				$scope.hastrue=false;
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
			
	}

	$scope.onfetchleavetype= function()
	{
		if($scope.employeeidmodel != undefined)
		{
			if($scope.employeeidmodel.length>1)
			{
				errorMessage("Select only one Employee");
				$scope.employeeidmodel=[];
				return;
			}	
			else
			{
				$scope.employeeid=parseInt($scope.employeeidmodel.toString());
			}	
		}
		$scope.employeeidmodel=undefined;
		$scope.hastrue=true;
		var xsrf = $.param({employeeid: $scope.employeeid,applydate:$scope.applydate});
		$http({
			url: path+'leave/getselectedemployeeleave',
			method: "POST",data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {
				if(data.status){
					$scope.leavetypearray=[];
					$scope.leavetypearray=data.data;
				}
				$scope.hastrue=false;
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
			
	}
	$scope.getweekoff = function($leavedate,$val){
		var xsrf = $.param({leavedate:$leavedate,val:$val,employeeid:$scope.employeeid});
		$scope.hastrue=true;
		$http({
			url: path+"leave/getweekoff",
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {
				if(data.status){
			//		$scope.leavefrom=$leavefrom;
				}else{
					errorMessage(data.errorMsg);
					if($val==1)
					$scope.fromdate="";
					if($val==2){
						$scope.todate="";
						$timeout(function(){
					$scope.dayseligible=0;
				}, 10);
					//$scope.dayseligible=0;
					
					}
				}				
				$scope.hastrue=false;
			}).error(function (data, status, headers, config) {
				////errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});	
	}
	$scope.timediff = function($leaveto){
		if($scope.todaytype==2 && ($scope.timeoffrom==$scope.timeofto) ) {
			
			
			$('#radio_btn2').click(function(){
			document.getElementById('radio_btn2').checked = false;
			document.getElementById('radio_btn1').checked = true;
			});
			return false;
		}
		$scope.resumptiondate="";
		
		var fromdate=$( '#fromdate' ).datepicker( "getDate" );
		 fromdate.setDate(fromdate.getDate());
		 $('#todate').datepicker("remove");
		$('#todate').datepicker({
			startDate: fromdate
		});
		if($scope.todate != ""){
			var todate=$( '#todate' ).datepicker( "getDate" );
			//todate.setDate(todate.getDate()+1);
			$('#resumption').datepicker("remove");
			 $('#resumption').datepicker({
				startDate: todate
			});
			//$scope.resumptiondate=todate;
		}
		if($scope.fromdate==$scope.todate) {
			if($scope.fromdaytype==2 ) {
				$scope.todaytype=2;
				$scope.timeofto=$scope.timeoffrom;
			}else{
				$scope.todaytype=1;
			}
		}
		
		$scope.gettimediff();
		
	}
	$scope.setEntitledleave = function(){
		$scope.unpaid=0;$scope.entitled=0;
		for(var i=0;i<$scope.leavetypearray.length;i++) {
			if($scope.leavetype==$scope.leavetypearray[i].id) {
				//console.log($scope.leavetypearray[i].payrule);
				if($scope.leavetypearray[i].payrule==0){
					//console.log($scope.dayseligible);
					$scope.unpaid=Number($scope.dayseligible);
				}else{
					if($scope.leavetypearray[i].leftleave>=$scope.dayseligible){
						$scope.entitled=$scope.dayseligible;
						$scope.unpaid=0;
					}else{
						if($scope.leavetypearray[i].leftleave!=0){
							$scope.leftleave=($scope.dayseligible)-($scope.leavetypearray[i].leftleave);
							$scope.entitled=$scope.leavetypearray[i].leftleave;
							$scope.unpaid=$scope.leftleave;
						}
						
						
					}
				}
				
			}
		}
		
	}
	$scope.gettimediff = function(){
	var xsrf = $.param({leavefrom:$scope.fromdate,leaveto:$scope.todate,employeeid:$scope.employeeid,leavefromtype:$scope.fromdaytype,leavetotype:$scope.todaytype,leavetype:$scope.leavetype,leavetimeofto:$scope.timeofto});
	$scope.hastrue=true;
		$http({
			url: path+"leave/getLeaveDaysDiff",
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {
				if(data.status){
					$scope.dayseligible=data.totaldays;
				
					$scope.resumptiondate=data.resumptiondate;
					$scope.empleavedetail=data.data;
					$scope.entitled = $scope.dayseligible;
					console.log($scope.entitled);
					$timeout(function(){
					for(var i=0;i<$scope.leavetypearray.length;i++){
						if($scope.leavetype==$scope.leavetypearray[i].id){
							
							var alloteddays=$scope.leavetypearray[i].leftleave;
						//	alert(alloteddays)
							if(alloteddays==0){
								$scope.entitled=0;
								$scope.unpaid=Number($scope.dayseligible);
							}
						}
					}
					}, 500);
					//$scope.setEntitledleave();
				}else{
					$scope.dayseligible=0;
				}				
				$scope.hastrue=false;
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
	}

	
  $scope.onfetchemployeeleave =function()
	{ 

		$scope.hastrue=true;
		var xsrf = $.param({employeeleaveid: $scope.employeeleaveid});
		$http({
			url: path+'leave/getaemployeeleave',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			if(data.status){
                
				$scope.employeeid=data.data[0]['employeeid'];
				$scope.fromdate=data.data[0]['fromdate'];
				$scope.todate=data.data[0]['todate'];
				$scope.leavereason=data.data[0]['leavereason'];
				$scope.leavestatus=data.data[0]['leavestatus'];
				$scope.leavevalidsts=data.data[0]['leavevalidsts'];
				$scope.dayseligible=data.data[0]['leavevalidsts'];
				$scope.applydate=data.data[0]['applydate'];
				$scope.approvercomment=data.data[0]['approvercomment'];
				$scope.resumptiondate=data.data[0]['resumptiondate'];
               	$scope.approvedby = data.data[0]['approvedby'];
				$scope.approvercomment = data.data[0]['approvercomment'];
				$scope.contactdetail = data.data[0]['emergencycontact'];
				$scope.leavetype = data.data[0]['leavetypeid'];
				$scope.fromdaytype=data.data[0]['fromdaytype'];
				$scope.todaytype=data.data[0]['todaytype'];
				$scope.timeoffrom=data.data[0]['timeoffrom'];
				$scope.timeofto=data.data[0]['timeofto'];
				$scope.leaveat=data.data[0]['leaveattachment'];
				var temp = data.data[0]['leavebreakdown'];
				
				if(temp != "")
				{
					temp=temp.split(',');
						   
					$scope.entitled=Number(temp[0]);
					$scope.carryforward=Number(temp[1]);
					$scope.advance=Number(temp[2]);
					$scope.unpaid=Number(temp[3]);
					
				}
				 gettimediffedit();
		
				$scope.onfetchleavetype();
				$timeout(function(){
				for(var i=0;i<$scope.leavetypearray.length;i++){
					if($scope.leavetype==$scope.leavetypearray[i].id){
						
						var alloteddays=$scope.leavetypearray[i].leftleave;
					//	alert(alloteddays)
						if(alloteddays==0){
							$scope.entitled=0;
							$scope.unpaid=Number($scope.dayseligible);
						}
					}
				}
				}, 500);
				
			}		
			$scope.changests=data.changestatus;
			$scope.hastrue=false;
			
		}).error(function (data, status, headers, config) {
			//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}
	
	function gettimediffedit(){
	var xsrf = $.param({leavefrom:$scope.fromdate,leaveto:$scope.todate,employeeid:$scope.employeeid,leavefromtype:$scope.fromdaytype,leavetotype:$scope.todaytype,leavetype:$scope.leavetype,leavetimeofto:$scope.timeofto});
	$scope.hastrue=true;
		$http({
			url: path+"leave/getLeaveDaysDiff",
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {
				if(data.status){
					$scope.empleavedetail=data.data;
				}else{
					$scope.dayseligible=0;
				}				
				$scope.hastrue=false;
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
}

	$scope.oncreate = function($val)
	{ 
	
		if($scope.fromdaytype==1){
			$scope.timeoffrom=0;
		}
		if($scope.todaytype==1){
			$scope.timeofto=0;
		}
		if($scope.fromdate==$scope.todate)
		{
			if($scope.fromdaytype==2)
			{
				if($scope.timeoffrom != $scope.timeofto){
					//$scope.todaytype=2;
					//$scope.timeofto=$scope.timeoffrom;
					errorMessage("You cannot choose diffrent half day for same day");
					return;
				}
				
			}
		}
		var temp=Number($scope.entitled)+Number($scope.carryforward)+Number($scope.advance)+Number($scope.unpaid);
			if(temp != $scope.dayseligible)
			{
				errorMessage("Leave break down should be equal to Leave Days");
				return;
			}
		var leavebreakdown=$scope.entitled+','+$scope.carryforward+','+$scope.advance+','+$scope.unpaid;
		
		for(var i=0;i<$scope.leavetypearray.length;i++)
		{
			if($scope.leavetype==$scope.leavetypearray[i].id)
			{
				
				if($scope.entitled>$scope.leavetypearray[i].leftleave)
				{
					errorMessage("This Employee have only "+$scope.leavetypearray[i].leftleave+"  entitle leave left");
					return;
				}
				if($scope.carryforward>$scope.leavetypearray[i].carryforward)
				{
					if($scope.carryforward != 0) {
						errorMessage("This Employee have only "+$scope.leavetypearray[i].carryforward+" carry forward leave left");
						return;
					}
				}
			}
		}
		$scope.hastrue=true;
		var xsrf = $.param({ resumptiondate: $scope.resumptiondate , leavefrom: $scope.fromdate , leaveto : $scope.todate , leavereason : $scope.leavereason, leavetypeid : $scope.leavetype, employeeid:$scope.employeeid, applydate:$scope.applydate, leavestatus:$scope.leavestatus, approvedby:$scope.approvedby, approvercomment:$scope.approvercomment, contactdetail:$scope.contactdetail,dayseligible:$scope.dayseligible,fromdaytype:$scope.fromdaytype,todaytype:$scope.todaytype,timeoffrom:$scope.timeoffrom,timeofto:$scope.timeofto,leavebreakdown:leavebreakdown ,empleavedetail:$scope.empleavedetail});
		$http({
			url: path+'leave/createemployeeleave',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
		 //errorMessage( $scope.leavevalidsts);
			if(data.status){
                            
				successMessage(data.successMsg);
				$scope.employeeleaveid=data.leaveid; 
				if(($("#documentfile").prop("files")[0] )!="")
				{
					$scope.uploaddoc();
				}
		        $scope.employeeleaveid=0; 
		        $scope.resumptiondate="";
                $scope.fromdate="";
                $scope.todate="";
			    $scope.leavereason="";
				$scope.leavetype="";
				$scope.employeeid="";
				$scope.applydate="";
				$scope.leavestatus="";
				$scope.approvedby=0;
				$scope.approvercomment="";
				$scope.contactdetail="";
				$scope.dayseligible="";
				$scope.fromdaytype="";
				$scope.todaytype="";
				$scope.timeoffrom="";
				$scope.timeofto="";
				$scope.entitled=0;
				$scope.carryforward=0;
				$scope.advance=0;
				$scope.unpaid=0;
				$scope.leavetypearray= [];
				if($val==1){
					//window.open(path+"leave/leaveslist", "_self");
					$timeout(function(){window.open(path+"leave/leaveslist", "_self");}, timeo);
				}				
			}else{
				errorMessage(data.errorMsg);
			}
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}
	
	$scope.onupdate = function($val)
	{ 
	
		if($scope.fromdaytype==1){
			$scope.timeoffrom=0;
		}
		if($scope.todaytype==1){
			$scope.timeofto=0;
		}
		if($scope.fromdate==$scope.todate)
		{
			if($scope.fromdaytype==2)
			{
				if($scope.timeoffrom != $scope.timeofto){
					//$scope.todaytype=2;
					//$scope.timeofto=$scope.timeoffrom;
					errorMessage("You cannot choose diffrent half day for same day");
					return;
				}
				
			}
		}
		
		var temp=Number($scope.entitled)+Number($scope.carryforward)+Number($scope.advance)+Number($scope.unpaid);
		if(temp != $scope.dayseligible)
		{
			errorMessage("Leave break down should be equal to Leave Days");
			return;
		}
		var leftleave=0;	
		for(var i=0;i<$scope.leavetypearray.length;i++)
		{
			//console.log($scope.leavetype)
			if($scope.leavetype==$scope.leavetypearray[i].id)
			{
				
				leftleave=parseFloat($scope.dayseligible)+parseFloat($scope.leavetypearray[i].leftleave);
				
				console.log("leavedays "+ $scope.dayseligible +" left "+$scope.leavetypearray[i].leftleave+" totalleft "+leftleave)
				if($scope.leavetypearray[i].days==0 && $scope.entitled!=0)
				{
					errorMessage("This Employee have only "+$scope.leavetypearray[i].leftleave+"  entitle leave left");
					return;
				}
				if($scope.entitled>leftleave )
				{
					errorMessage("This Employee have only "+leftleave+"  entitle leave left");
					return;
				}
				
				
				if($scope.carryforward>$scope.leavetypearray[i].carryforward)
				{
					if($scope.carryforward != 0) {
						errorMessage("This Employee have only "+$scope.leavetypearray[i].carryforward+" carry forward leave left");
						return;
					}
				}
			}
		}
		var leavebreakdown=$scope.entitled+','+$scope.carryforward+','+$scope.advance+','+$scope.unpaid;
		$scope.hastrue=true;
		var xsrf = $.param({leaveid:$scope.employeeleaveid, resumptiondate: $scope.resumptiondate , leavefrom: $scope.fromdate , leaveto : $scope.todate , leavereason : $scope.leavereason, leavetypeid : $scope.leavetype, employeeid:$scope.employeeid, applydate:$scope.applydate, leavestatus:$scope.leavestatus, approvedby:$scope.approvedby, approvercomment:$scope.approvercomment, contactdetail:$scope.contactdetail,dayseligible:$scope.dayseligible,fromdaytype:$scope.fromdaytype,todaytype:$scope.todaytype,timeoffrom:$scope.timeoffrom,timeofto:$scope.timeofto,leavebreakdown:leavebreakdown,empleavedetail:$scope.empleavedetail});
		$http({
			url: path+'leave/updatedeemployeeleave',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
		 //errorMessage( $scope.leavevalidsts);
			if(data.status){                            
				
				if(($("#documentfile").prop("files")[0] )!="")
				{
					$scope.uploaddoc();
				}
				successMessage(data.successMsg);
				$scope.employeeleaveid=0; 
		        $scope.resumptiondate="";
                $scope.fromdate="";
                $scope.todate="";
			    $scope.leavereason="";
				$scope.leavetype="";
				$scope.employeeid="";
				$scope.applydate="";
				$scope.leavestatus="";
				$scope.approvedby=0;
				$scope.approvercomment="";
				$scope.contactdetail="";
				$scope.dayseligible="";
				$scope.fromdaytype="";
				$scope.todaytype="";
				$scope.timeoffrom="";
				$scope.timeofto="";
				$scope.entitled=0;
				$scope.carryforward=0;
				$scope.advance=0;
				$scope.unpaid=0;
				$scope.leavetypearray= [];
				if($val==1){
					//window.open(path+"leave/leaveslist", "_self");
					$timeout(function(){window.open(path+"leave/leaveslist", "_self");}, timeo);
				}				
			}else{
				errorMessage(data.errorMsg);
			}
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}
	/////////////////upload leave attachment in the case of sick leave/////
	$scope.uploaddoc = function()
	{
		
		var file_data=$("#documentfile").prop("files")[0];
		var form_data=new FormData();
		form_data.append("file0",file_data);
		form_data.append("leave_id",$scope.employeeleaveid);
				
		$.ajax({
			type:"POST",
			url:path+"profile/uploadLeaveAttachment",
			datatype:'script',
			cache:false,
			contentType:false,
			processData:false,
			data:form_data,
			success:function(data){
						//console.log(data)
						//$scope.selectbackground(data);
			},
			error:function(){
			//----------
			}
		});
	}
    $scope.onclear = function()
	{
		$scope.department=0;
		$scope.designation=0;
		$scope.division=0;
	}
	$scope.onfilter = function($val)
	{ 
		$scope.hastrue=true;
		//var xsrf = { department: $scope.department ,designation: $scope.designation , division: $scope.division };
		var url=path+"leave/getemployeeleaveData";
		if($val==2)
		{
			url=path+"leave/getLeaveBalanceData";
		}
		table.destroy();
		table = $('#example1').DataTable({
				"bProcessing": true,
				"bServerSide": true,
				"stateSave": true,
                 
				"deferRender": true,
				"sAjaxSource": url,
				
				"fnServerParams": function ( aoData ) {
				  aoData.push( { "name": "department", "value": $scope.department }, { "name": "designation", "value": $scope.designation }, { "name": "division", "value": $scope.division } );
				},
				"columnDefs": [{
					"searchable": false,
					"orderable": false,
					"targets"  : 'no-sort'
				}]
        });
		
		
		$scope.hastrue=false;
	}
///////////////////leave history//////////////

	$scope.onfetchleavehistory= function()
	{
		$scope.hastrue=true;
		var xsrf = $.param({leavehistoryid: $scope.leavehistoryid});
		$http({
			url: path+'leave/getleavebalancehistory',
			method: "POST",data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {
				if(data.status){
					
				$scope.employeeid=data.data[0]['empid'];
				$scope.leavetype=data.data[0]['leavetype'];
				$scope.empname=data.data[0]['empname'];
				$scope.empcode=data.data[0]['empcode'];
				$scope.empdivision=data.data[0]['empdivision'];
				$scope.empmonth=data.data[0]['empmonthname'];
				$scope.empgrade=data.data[0]['empgrade'];
				$scope.empdept=data.data[0]['empdept'];
				$scope.empdays=data.data[0]['emppaiddays'];
				$scope.empshift=data.data[0]['empshift'];
				$scope.empdesig=data.data[0]['empdesig'];
				$scope.empdoj=data.data[0]['empdoj'];
				$scope.leavealloted=data.data[0]['leavealloted'];
				$scope.leaveutilized=data.data[0]['leaveutilized'];
				$scope.balanceleave=data.data[0]['balanceleave'];
				$scope.carryforward=data.data[0]['carryforward'];
				$scope.advance=data.data[0]['advance'];
				$scope.availableleave=data.data[0]['availableleave'];
				}
				$scope.hastrue=false;
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
			
	}
	
	//////////LEAVE CARRY FORWARD//////////////////////////////////////
	
	$scope.onfetchleavecf= function()
	{
		$scope.hastrue=true;
		//var xsrf = $.param({leavehistoryid: $scope.leavehistoryid});
		$http({
			url: path+'leave/getleavecf',
			method: "POST",
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {
				if(data.status){
					
				$scope.empleavearr=data.data;
				
				}
				$scope.hastrue=false;
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
			
	}

	$scope.onupdateleavehistory= function($val)
	{
		$scope.hastrue=true;
		var xsrf = $.param({leavehistoryid: $scope.leavehistoryid,availleave:$scope.availableleave,encashlapseleave:$scope.encashlapseleave,resettype:$scope.leavelapse,empid:$scope.employeeid});
		$http({
			url: path+'leave/updateleavehistory',
			method: "POST",data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {
				if(data.status){
					successMessage(data.successMsg);
					if($val==1){
						//window.open(path+"leave/leavetype", "_self");
						$timeout(function(){window.open(path+"leave/leavebalance", "_self");}, timeo);
					}	
				
				}else{
					errorMessage(data.errorMsg);
				}
				$scope.hastrue=false;
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
			
	}
	
	$scope.onsavecf= function($id,$carryforward,$empid,$monthlysts,$fiscalid,$cfmonth,$leaveid)
	{
		$scope.hastrue=true;
		var xsrf = $.param({leavecfid: $id,carryforward:$carryforward, empid:$empid, monthlysts:$monthlysts, fiscalid:$fiscalid, cfmonth:$cfmonth, leavetypeid:$leaveid });
		$http({
			url: path+'leave/updateleavecf',
			method: "POST",data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {
				if(data.status){
					successMessage(data.successMsg);
					
				
				}else{
					errorMessage(data.errorMsg);
				}
				$scope.hastrue=false;
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
			
	}

});
/////////////////////////// EmployeeLeave Controller Starts From Here  ///////////////////////////////////

app.controller('TimeoffCtrl', function($scope, $http, $timeout) {

	$scope.hastrue=false;
    $scope.timeoffid="";
	$scope.fromtime="";
	$scope.totime="";
	$scope.timeoffdate="";
	$scope.timeoffreason="";
	$scope.employeeid=0;
    $scope.employeearray=[];
	onfetch('leave/getallleaveemployee',4);
	onfetch('other',2);
	
	$scope.getId = function($id) {
		$scope.timeoffid=$id;
	}
	$scope.ondelete =function()
	{
	//$scope.rolearr=[];
	//$scope.hastrue=true;
	$http({
        url: path+'leave/deletetimeoff/'+$scope.timeoffid,
        method: "POST",
        headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
      }).success(function (data, status, headers, config) {
			if(data.status){
			
				 successMessage(data.successMsg);
				 table.draw();
			}else{
				errorMessage(data.errorMsg);
			}
			$scope.timeoffid=0;
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
}
	Array.prototype.insert = function (index, item) {
	  this.splice(index, 0, item);
	};
   function onfetch($val, $id)
	{
		$scope.hastrue=true;
		$http({
			url: path+$val,
			method: "POST",
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {
				
				if(data.status){
					 if($id==4){
						$scope.employeearray=[];
						$scope.employeearray=data.data;
					}
					if($id==2){
						$scope.leavestsarray=[];
						$scope.leavestsarray=data.data;
						console.log($scope.leavestsarray);
					}
					
				}
				$scope.hastrue=false;
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
			
	}

	$scope.onfetchleavetype= function()
	{
		if($scope.employeeidmodel != undefined)
		{
			if($scope.employeeidmodel.length>1)
			{
				errorMessage("Select only one Employee");
				$scope.employeeidmodel=[];
				return;
			}	
			else
			{
				$scope.employeeid=parseInt($scope.employeeidmodel.toString());
				
			}	
		}
	}
	
	$scope.onfetchtimeoffdetail =function()
	{ 

		$('#timeoffdate').datepicker({
						startDate: '0'
		});
		$('#applydate').datepicker({
						startDate: '+0d'
		});			
		$scope.hastrue=true;
		var xsrf = $.param({timeoffid: $scope.timeoffid});
		$http({
			url: path+'leave/getemployeetimeoff',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			if(data.status){
                
				$scope.employeeid=data.data[0]['employeeid'];
				//console.log($scope.employeeid);
				$scope.timeoffdate=data.data[0]['timeoffdate'];
				$scope.fromtime=data.data[0]['timefrom'];
				$scope.totime=data.data[0]['timeto'];
				
				$scope.timeoffreason=data.data[0]['reason'];
				$scope.timeoffapprovercomment=data.data[0]['approvercomment'];
				$scope.onfetchleavetype();
			}		
			$scope.changests=data.changestatus;
			$scope.hastrue=false;
			
		}).error(function (data, status, headers, config) {
			//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}

	$scope.oncreatetimeoff = function($val)
	{	
		var xsrf = $.param({employeeid:$scope.employeeid,timeoffdate:$scope.timeoffdate,fromtime:$scope.fromtime,totime:$scope.totime,timeoffreason:$scope.timeoffreason});
		
		$http({
			url: path+'leave/createtimeoff',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
				if(data.status){
					
					successMessage(data.successMsg);
					$scope.timeoffdate="";
					$scope.fromtime="";
					$scope.totime="";
					$scope.timeoffreason="";
					if($val==1){
						//window.open(path+"leave/leaveslist", "_self");
						$timeout(function(){window.open(path+"leave/timeoff", "_self");}, timeo);
					}
					
				}
				else{
					
				errorMessage(data.errorMsg);
			}
				$scope.hastrue=false;
		}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
		});
	
	}
	$scope.onupdatetimeoff = function($val)
	{ 
	
		var xsrf = $.param({employeeid:$scope.employeeid,timeoffdate:$scope.timeoffdate,fromtime:$scope.fromtime,totime:$scope.totime,timeoffreason:$scope.timeoffreason,timeoffid: $scope.timeoffid});
	
		
		$http({
			url: path+'leave/updatedtimeoff',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
				if(data.status){
					successMessage(data.successMsg);
				
					successMessage(data.successMsg);
					$scope.timeoffdate="";
					$scope.employeeid="";
					$scope.fromtime="";
					$scope.totime="";
					$scope.timeoffreason="";
					$timeout(function(){window.open(path+"leave/timeoff", "_self");}, timeo);
					}
				else{
				errorMessage(data.errorMsg);
			}
				$scope.hastrue=false;
		}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
		});
		
	}
	
	$scope.onfetchTimeoffApprover = function($id)
	{
		$scope.hastrue=true;
		var xsrf = $.param({timeoffid: $id});
		$http({
			url: path+'leave/getalltimeoffapprover',
			method: "POST",data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {
				
				if(data.status){
					$scope.timeapproverarray=[];
						$scope.timeapproverarray=data.data;
						console.log($scope.timeapproverarray);
				}
				$scope.hastrue=false;
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
			
	}
	
});
/* $scope.timediff = function(){
var fromtime=$('#fromtime').timepicker( "getTime" );
		 fromtime.setTime(fromtime.getTime());
		 $('#totime').timepicker("remove");
		$('#totime' ).timepicker({
			startDate: fromtime
		});
	}
		 */

	
/* $scope.timediff = function(){
		//alert($leaveto);
		//$scope.resumptiondate="";
		if(val==1){
			if($scope.fromtime!="")
			{
		var fromtime=$('#fromtime').timepicker( "getTime" );
		 fromtime.setTime(fromtime.getTime());
		 $('#totime').timepicker("remove");
		$('#totime' ).timepicker({
			startDate: fromtime
		});
	}
		
}
		
		if(val==2)
		{
			if($scope.totime!="")
			{
				var timeto=$( '#totime' ).timepicker( "getDate" );  
				$('#totime').timepicker("remove");
				$('#totime').timepicker({
					startDate: timeto
					
					
				});
				
			}
			
		}
} */

//////////////////////// Leave Eligibility Controller///////////////////////

app.controller('leaveeligibilityCtrl', function($scope, $http, $timeout) {

	$scope.hastrue=false;
    $scope.division=0;
    $scope.department=0;
	$scope.designation=0;
	$scope.grade=0;
	$scope.desc="";
	$scope.leavedays=0;
	$scope.workdays=0;
	$scope.stype = 0;
	$scope.leaveeligibilityid=0;
    $scope.divisionarray=[];
	$scope.departarray=[];
	$scope.desigarray=[];
	$scope.gradearray=[];
	$scope.typearray=[{id:0, name:"Apply Overall"}, {id:1, name:"Apply Specific"}];
    onfetch('setup/getalldivision',1);
	onfetch('setup/getalldepartment',2);
	onfetch('setup/getalldesignation',3);
	onfetch('setup/getallgrade',4);

	$scope.onTypeChange= function($index){
		if($index){
			$scope.division=0;
			$scope.department=0;
			$scope.designation=0;
			$scope.grade=0;
		}
	}
Array.prototype.insert = function (index, item) {
	  this.splice(index, 0, item);
	};	
	Array.prototype.remove = function (index) {
	  this.splice(index,1);
	};
	
   function onfetch($val, $id)
	{
		$scope.hastrue=true;
		$http({
			url: path+$val,
			method: "POST",
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {
				
				if(data.status){
					if($id==1){
						$scope.divisionarray=[];
						$scope.divisionarray=data.data;
						$scope.divisionarray.insert(0,{id:0,name:"----- All -------"});
                                               
					}else if($id==2){
						$scope.departarray=[];
						$scope.departarray=data.data;
						$scope.departarray.insert(0,{id:0,name:"----- All -------"});
                                                
					}else if($id==3){
						$scope.desigarray=[];
						$scope.desigarray=data.data;
						$scope.desigarray.insert(0,{id:0,name:"----- All -------"});
                                              
					}else if($id==4){
						$scope.gradearray=[];
						$scope.gradearray=data.data;
						$scope.gradearray.insert(0,{id:0,name:"----- All -------"});
					}
				}
				$scope.hastrue=false;
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
			
	}

  $scope.onfetchleaveeligibility =function($id)
	{ 

		$scope.hastrue=true;
		var xsrf = $.param({leaveeligibilityid: $id});
		$http({
			url: path+'leave/getaleave_eligibility',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			if(data.status){
                
				$scope.division=data.data[0]['division'];
				$scope.department=data.data[0]['department'];
				$scope.designation=(data.data[0]['designation']);
				$scope.grade=data.data[0]['grade'];
				$scope.desc=data.data[0]['desc'];
				$scope.leavedays=parseFloat(data.data[0]['leavedays']);
				$scope.workdays=Number(data.data[0]['workdays']);
			}		
 
			$scope.hastrue=false;
			
		}).error(function (data, status, headers, config) {
			//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}

	$scope.onupdate = function($val)
	{ 
		$scope.hastrue=true;
		var xsrf = $.param({ leaveeligibilityid:$scope.leaveeligibilityid,departmentid:$scope.department,designationid:$scope.designation,divisionid: $scope.division, gradeid: $scope.grade, leavedays: $scope.leavedays, workdays: $scope.workdays, desc: $scope.desc });
		$http({
			url: path+'leave/updatedeleave_eligibility',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
		 //errorMessage( $scope.leavevalidsts);
			if(data.status){
                            
				successMessage(data.successMsg);
					$scope.division=0;
					$scope.department=0;
					$scope.designation=0;
					$scope.grade=0;
					$scope.desc="";
					$scope.leavedays=0;
					$scope.leaveeligibilityid=0;
			        $scope.workdays=0;
				if($val==1){
					//window.open(path+"leave/leave_eligibility", "_self");
					$timeout(function(){window.open(path+"leave/leave_eligibility", "_self");}, timeo);
				}				
			}else{
				errorMessage(data.errorMsg);
			}
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}
	
	
	
	
	$scope.oncreate = function($val)
	{	
		
		
		$scope.hastrue=true;
		
		var xsrf = $.param({departmentid:$scope.department,designationid:$scope.designation,divisionid:$scope.division, gradeid:$scope.grade, leavedays: $scope.leavedays, workdays: $scope.workdays, desc: $scope.desc});
		$http({
			url: path+'leave/createleave_eligibility',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
				if(data.status){
					successMessage(data.successMsg);					
					$scope.division=0;
					$scope.department=0;
					$scope.designation=0;
					$scope.grade=0;
					$scope.desc="";
					$scope.leavedays=0;
					$scope.workdays=0;
					if($val==1){
						//window.open(path+"leave/leave_eligibility", "_self");
						$timeout(function(){window.open(path+"leave/leave_eligibility", "_self");}, timeo);
					}
				}else{
					errorMessage(data.errorMsg);
				}
				$scope.hastrue=false;
		}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
		});
	}
	
});

//////////////////////// Time Off Approval by mail Controller///////////////////////

app.controller('timeoffapprovalbymailCtrl', function($scope, $http, $timeout) {

	$scope.hastrue=false;
    $scope.userid=0;
    $scope.org_id=0;
	$scope.employeetimeoffid=0;
	$scope.approverresult=0;
	$scope.comment="";
	$scope.result="";
	$scope.remarks="";
	$scope.approvaltext="";
	
	$scope.onapprove = function()
	{
		$scope.hastrue=true;
		$('#comment').modal('hide');
		var xsrf = $.param({ userid:$scope.userid, org_id:$scope.org_id,employeetimeoffid:$scope.employeetimeoffid,approverresult:$scope.approverresult, comment:$scope.comment});
		$http({
			url: path+'Login/approvetimeoffbymail',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
		 //errorMessage( $scope.leavevalidsts);
			if(data.status){
            	//successMessage(data.successMsg);
				$scope.result=data.successMsg;
			}else{
			//errorMessage(data.errorMsg);
			$scope.result=data.errorMsg;
			}
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}
	
$scope.onfetch = function($userid,$org_id,$employeetimeoffid,$approverresult,$appSts){
	 $scope.userid=$userid;
    $scope.org_id=$org_id;
	$scope.employeetimeoffid=$employeetimeoffid;
	$scope.approverresult=$approverresult;
	// console.log($userid);
	// console.log($org_id);
	// console.log($employeetimeoffid);
	
	if($approverresult==1){
		$scope.remarks="Remark for rejecting timeoff";
		$scope.approvaltext="Reject";
		
	}
	if($approverresult==2){
		$scope.remarks="Remark for approving timeoff";
		$scope.approvaltext="Approve";	
			
	}
	
	if($appSts==1){
		$scope.result="Time off has already been rejected";
		//$timeout(function(){
				//	$("#confirm").modal('show');
			//	}, 2000);
	}
	if($appSts==2){
		$scope.result="Time off has already been approved";
			//	$timeout(function(){
				//	$("#confirm").modal('show');
				//}, 2000);
			
	}
	if($appSts==7){
		$scope.result="Time off has been escalated to next level";
				//$timeout(function(){
					//$("#confirm").modal('show');
				//}, 2000);
			
	}
}
});


//////////////////////// Leave Approval by mail Controller///////////////////////

app.controller('leaveapprovalbymailCtrl', function($scope, $http, $timeout) {

	$scope.hastrue=false;
    $scope.userid=0;
    $scope.org_id=0;
	$scope.employeeleaveid=0;
	$scope.approverresult=0;
	$scope.comment="";
	$scope.result="";
	$scope.remarks="";
	$scope.approvaltext="";
	
	
	$scope.onapprove = function()
	{
		$scope.hastrue=true;
		$('#comment').modal('hide');
		var xsrf = $.param({ userid:$scope.userid, org_id:$scope.org_id,employeeleaveid:$scope.employeeleaveid,approverresult:$scope.approverresult, comment:$scope.comment});
		$http({
			url: path+'approvalbymail/approveleaveapproval',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
		 //errorMessage( $scope.leavevalidsts);
			if(data.status){
            	//successMessage(data.successMsg);
				$scope.result=data.successMsg;
				}else{
				//errorMessage(data.errorMsg);
				$scope.result=data.errorMsg;
			}
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}
	
	$scope.onfetch = function($userid,$org_id,$employeeleaveid,$approverresult,$appSts){
		alert($appSts);
	 $scope.userid=$userid;
    $scope.org_id=$org_id;
	$scope.employeeleaveid=$employeeleaveid;
	$scope.approverresult=$approverresult;
	console.log($scope.approverresult);
	if($approverresult==1){
		$scope.remarks="Remark for rejecting leave";
		$scope.approvaltext="Reject";
		//$timeout(function(){
			//		$("#confirm").modal('show');
				//}, 2000);
	}
	if($approverresult==2){
		$scope.remarks="Remark for approving leave";
		$scope.approvaltext="Approve";
				//$timeout(function(){
					//$("#confirm").modal('show');
				//}, 2000);
	}
	if($appSts==1){
		$scope.result="Leave has already been rejected";
		//$timeout(function(){
			//		$("#confirm").modal('show');
				//}, 2000);
	}
	if($appSts==2){
		$scope.result="Leave has already been approved";
				//$timeout(function(){
					//$("#confirm").modal('show');
				//}, 2000);
			
	}
	if($appSts==7)
	{
		$scope.result="Leave has been escalated to next level";
				//$timeout(function(){
					//$("#confirm").modal('show');
				//}, 2000);
			
	}
}
	
});

/////////////////////// Leave Approval Controller///////////////////////

app.controller('leaveapprovalCtrl', function($scope, $http, $timeout) {

	$scope.hastrue=false;
    $scope.leaveapprovalid=0;
    $scope.approverresult=3;
    onfetch('other',2);
	$scope.entitled=0;
	$scope.carryforward=0;
	$scope.advance=0;
	$scope.unpaid=0;
	$scope.leaveat="";
	$scope.leavetypearray1=[];
	
	$scope.getId = function($id) {
		$scope.leaveapprovalid=$id;
	}
	$scope.ondelete =function()
	{
	//$scope.rolearr=[];
	//$scope.hastrue=true;
	$http({
        url: path+'leave/deleteleaveapproval/'+$scope.leaveapprovalid,
        method: "POST",
        headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
      }).success(function (data, status, headers, config) {
			if(data.status){
			
				 successMessage(data.successMsg);
				 table.draw();
			}else{
				errorMessage(data.errorMsg);
			}
			$scope.leaveapprovalid=0;
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
}
	
	
	$('input').on('ifUnchecked', function(event){
	  if(event.target.name=='entitledchk'){
	  	$scope.entitledchk=0;
	  	$scope.entitled=0;
		
	 }
	 if(event.target.name=='carryforwardchk'){
		$scope.carryforwardchk=0;
		$scope.carryforward=0;
		
	 }
	  if(event.target.name=='advancechk'){
		$scope.advancechk=0;
		$scope.advance=0;
		
	 }
	 if(event.target.name=='unpaidchk'){
		$scope.unpaidchk=0;
		$scope.unpaid=0;
		
	 }
	  
	});	
   function onfetch($val, $id)
	{
		$scope.hastrue=true;
		var xsrf = $.param({leaveid: $scope.employeeleaveid});
		$http({
			url: path+$val,
			method: "POST",data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {
				
				if(data.status){
					if($id==2){
						$scope.leavestsarray=[];
						$scope.leavestsarray=data.data;
					}
				}
				$scope.hastrue=false;
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
			
	}
	
	$scope.onfetchApprover = function($id)
	{
		$scope.hastrue=true;
		var xsrf = $.param({leaveid: $id});
		$http({
			url: path+'leave/getallleaveapprover',
			method: "POST",data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {
				
				if(data.status){
					$scope.employeearray=[];
						$scope.employeearray=data.data;
				}
				$scope.hastrue=false;
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
			
	}
	
	$scope.onfetchleavetype= function()
	{//alert('ddd');
		$scope.hastrue=true;
		var xsrf = $.param({employeeid: $scope.empid,applydate:$scope.applydate});
		$http({
			url: path+'leave/getselectedemployeeleave',
			method: "POST",data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {
				if(data.status){
					$scope.leavetypearray=[];
					$scope.leavetypearray=data.data;
				//	$scope.leavetypearray1=data.data;
					//alert('bbb');
				//	console.log($scope.leavetypearray1);
				}
				$scope.hastrue=false;
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
			
	}

	 
	function gettimediff(){
	var xsrf = $.param({leavefrom:$scope.fromdate,leaveto:$scope.todate,employeeid:$scope.empid,leavefromtype:$scope.fromdaytype,leavetotype:$scope.todaytype,leavetype:$scope.leavetypeid,leavetimeofto:$scope.timeofto});
	$scope.hastrue=true;
		$http({
			url: path+"leave/getLeaveDaysDiff",
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {
				if(data.status){
					$scope.dayseligible=data.totaldays;
					$scope.resumptiondate=data.resumptiondate;
					$scope.empleavedetail=data.data;
					$scope.entitled = $scope.dayseligible;
					
					//$scope.setEntitledleave();
				}else{
					$scope.dayseligible=0;
				}				
				$scope.hastrue=false;
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
}
  $scope.onfetchleaveapproval =function($id)
	{ 
//alert($id);
		$scope.hastrue=true;
		var xsrf = $.param({leaveapprovalid: $id});
		$http({
			url: path+'leave/getaleaveapproval',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
		
			if(data.status){
                $scope.empid=data.data[0]['employee'];
				$scope.employeeid=data.data[0]['employeeid'];
				$scope.fromdate=data.data[0]['fromdate'];
				$scope.todate=data.data[0]['todate'];
				$scope.leavereason=data.data[0]['leavereason'];
				$scope.leavestatus=data.data[0]['leavestatus'];
				$scope.leavevalidsts=data.data[0]['leavevalidsts'];
				if($scope.val==2)
					$scope.entitled=Number($scope.leavevalidsts);
				$scope.applydate=data.data[0]['applydate'];
				$scope.approvercomment=data.data[0]['approvercomment'];
				$scope.resumptiondate=data.data[0]['resumptiondate'];
                $scope.leavetypeid = data.data[0]['leavetypeid'];
                $scope.leavetype = data.data[0]['leavetype'];
				$scope.dayseligible = data.data[0]['leavevalidsts'];
				$scope.substituteid = data.data[0]['substituteid'];
				$scope.carryforwardedleave = data.data[0]['carryforwarded'];
				$scope.designation = data.data[0]['designation'];
				$scope.leaveat=data.data[0]['leaveattachment'];
				$scope.fromdaytype=data.data[0]['fromdaytype'];
				$scope.todaytype=data.data[0]['todaytype'];
				$scope.timeoffrom=data.data[0]['timeoffrom'];
				$scope.timeofto=data.data[0]['timeofto'];
				var curyear = data.data[0]['curyear'];
				var curmonth = data.data[0]['curmonth'];
				$scope.curexperience=curyear+' years '+curmonth+' months';
				var temp = data.data[0]['leavebreakdown'];
				if(temp != "")
				{
					temp=temp.split(',');
					
					$scope.entitled=Number(temp[0]);
					
					$scope.carryforward=Number(temp[1]);
					$scope.advance=Number(temp[2]);
					$scope.unpaid=Number(temp[3]);
					
				}
				gettimediff();
				$scope.onfetchleavetype();
			
				$timeout(function(){
				for(var i=0;i<$scope.leavetypearray.length;i++){
					if($scope.leavetypeid==$scope.leavetypearray[i].id){
						
						var alloteddays=$scope.leavetypearray[i].leftleave;
						
						if(alloteddays==0){
							$scope.entitled=0;
							$scope.unpaid=Number($scope.leavevalidsts);
						}
					}
				}
				}, 500);
			}		
 
			$scope.hastrue=false;
			
		}).error(function (data, status, headers, config) {
			//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}
	
	$scope.onaddcomment = function($id)
	{
		if($scope.val==2 && $id==2)
		{
			var temp=Number($scope.entitled)+Number($scope.carryforward)+Number($scope.advance)+Number($scope.unpaid);
			if(temp != $scope.dayseligible)
			{
				errorMessage("Leave break down should be equal to Leave Days");
				return;
			}
		
		
		for(var i=0;i<$scope.leavetypearray.length;i++)
		{
			if($scope.leavetypeid==$scope.leavetypearray[i].id)
			{
				if($scope.entitled>$scope.leavetypearray[i].leftleave)
				{
					errorMessage("This Employee have only "+$scope.leavetypearray[i].leftleave+"  entitle leave left");
					return;
					$scope.entitled=0;
				}
				if($scope.carryforward>$scope.leavetypearray[i].carryforward)
				{
					if($scope.carryforward != 0) {
						errorMessage("This Employee have only "+$scope.leavetypearray[i].carryforward+" carry forward leave left");
						return;
						$scope.carryforward=0;
					}
				}
			}
		}
		}
		$scope.approverresult=$id;
		 $('#comment').modal('show');
		
		 
		 
	}
	
	$scope.onapprove = function($val)
	{ 
		var leavebreakdown="";
		if($scope.val==2 && $scope.approverresult==2)
		{
			leavebreakdown=$scope.entitled+','+$scope.carryforward+','+$scope.advance+','+$scope.unpaid;
		}
		$scope.hastrue=true;
		$('#comment').modal('hide');
		var xsrf = $.param({ employeeleaveid:$scope.employeeleaveid, approverresult:$scope.approverresult, comment:$scope.comment,leavebreakdown:leavebreakdown , empleavedetail:$scope.empleavedetail});
		$http({
			url: path+'leave/approveleaveapproval',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
		 //errorMessage( $scope.leavevalidsts);
			if(data.status){
            	successMessage(data.successMsg);
				if($val==1){
					$timeout(function(){window.open(path+"leave/leave_approval", "_self");}, timeo);
				}				
			}else{
				errorMessage(data.errorMsg);
			}
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}

	$scope.onreject = function($val)
	{ 
		$scope.hastrue=true;
		
		var xsrf = $.param({ employeeleaveid:$scope.employeeleaveid });
		$http({
			url: path+'leave/rejectleaveapproval',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
		 //errorMessage( $scope.leavevalidsts);
			if(data.status){
            	successMessage(data.successMsg);
				if($val==1){
					$timeout(function(){window.open(path+"leave/leave_approval", "_self");}, timeo);
				}				
			}else{
				errorMessage(data.errorMsg);
			}
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}

});


//////////////////////// Time off Approval Controller///////////////////////

app.controller('timeoffapprovalCtrl', function($scope, $http, $timeout) {

	$scope.hastrue=false;
    $scope.leaveapprovalid=0;
    $scope.approverresult=3;
    onfetch('other',2);
	$scope.entitled=0;
	$scope.carryforward=0;
	$scope.advance=0;
	$scope.unpaid=0;
	$scope.leaveat="";
	$scope.createddate="";
	$scope.fromtime="";
	$scope.totime="";
	$scope.timeoffreason="";
	$scope.timeoffstatus="";
	$scope.st="";
	$scope.comment="";
	$scope.totaltime="";
	$scope.employeetimeoffid="";
	$scope.getId = function($id) {
		$scope.leaveapprovalid=$id;
	}
	$scope.ondelete =function()
	{
	//$scope.rolearr=[];
	//$scope.hastrue=true;
	$http({
        url: path+'leave/deleteleaveapproval/'+$scope.leaveapprovalid,
        method: "POST",
        headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
      }).success(function (data, status, headers, config) {
			if(data.status){
			
				 successMessage(data.successMsg);
				 table.draw();
			}else{
				errorMessage(data.errorMsg);
			}
			$scope.leaveapprovalid=0;
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
}
	
	
	$('input').on('ifUnchecked', function(event){
	  if(event.target.name=='entitledchk'){
	  	$scope.entitledchk=0;
	  	$scope.entitled=0;
		
	 }
	 if(event.target.name=='carryforwardchk'){
		$scope.carryforwardchk=0;
		$scope.carryforward=0;
		
	 }
	  if(event.target.name=='advancechk'){
		$scope.advancechk=0;
		$scope.advance=0;
		
	 }
	 if(event.target.name=='unpaidchk'){
		$scope.unpaidchk=0;
		$scope.unpaid=0;
		
	 }
	  
	});	
   function onfetch($val, $id)
	{
		$scope.hastrue=true;
		var xsrf = $.param({leaveid: $scope.employeeleaveid});
		$http({
			url: path+$val,
			method: "POST",data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {
				
				if(data.status){
					if($id==2){
						$scope.leavestsarray=[];
						$scope.leavestsarray=data.data;
					}
				}
				$scope.hastrue=false;
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
			
	}
	
	$scope.onfetchApprover = function($id)
	{
		$scope.hastrue=true;
		var xsrf = $.param({leaveid: $id});
		$http({
			url: path+'leave/getallleaveapprover',
			method: "POST",data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {
				if(data.status){
					$scope.employeearray=[];
					$scope.employeearray=data.data;
				}
				$scope.hastrue=false;
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
	}
	
	$scope.onfetchTimeoffApprover = function($id)
	{
		$scope.hastrue=true;
		var xsrf = $.param({timeoffid: $id});
		$http({
			url: path+'leave/getalltimeoffapprover',
			method: "POST",data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {
				
				if(data.status){
					$scope.employeearray=[];
						$scope.employeearray=data.data;
				}
				$scope.hastrue=false;
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
			
	}
	
	$scope.onfetchleavetype= function()
	{
		$scope.hastrue=true;
		var xsrf = $.param({employeeid: $scope.empid,applydate:$scope.applydate});
		$http({
			url: path+'leave/getselectedemployeeleave',
			method: "POST",data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {
				if(data.status){
					$scope.leavetypearray=[];
					$scope.leavetypearray=data.data;
				}
				$scope.hastrue=false;
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
			
	}

	 
	
  $scope.onfetchleaveapproval =function($id)
	{ 
//alert($id);
		$scope.hastrue=true;
		var xsrf = $.param({leaveapprovalid: $id});
		$http({
			url: path+'leave/getaleaveapproval',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
		
			if(data.status){
                $scope.empid=data.data[0]['employee'];
				$scope.employeeid=data.data[0]['employeeid'];
				$scope.fromdate=data.data[0]['fromdate'];
				$scope.todate=data.data[0]['todate'];
				$scope.leavereason=data.data[0]['leavereason'];
				$scope.leavestatus=data.data[0]['leavestatus'];
				$scope.leavevalidsts=data.data[0]['leavevalidsts'];
				$scope.applydate=data.data[0]['applydate'];
				$scope.approvercomment=data.data[0]['approvercomment'];
				$scope.resumptiondate=data.data[0]['resumptiondate'];
                $scope.leavetypeid = data.data[0]['leavetypeid'];
                $scope.leavetype = data.data[0]['leavetype'];
				$scope.dayseligible = data.data[0]['leavevalidsts'];
				$scope.substituteid = data.data[0]['substituteid'];
				$scope.carryforwardedleave = data.data[0]['carryforwarded'];
				$scope.designation = data.data[0]['designation'];
				$scope.leaveat=data.data[0]['leaveattachment'];
				var curyear = data.data[0]['curyear'];
				var curmonth = data.data[0]['curmonth'];
				$scope.curexperience=curyear+' years '+curmonth+' months';
				
				var temp = data.data[0]['leavebreakdown'];
				if(temp != "")
				{
					temp=temp.split(',');
					
					$scope.entitled=Number(temp[0]);
					$scope.carryforward=Number(temp[1]);
					$scope.advance=Number(temp[2]);
					$scope.unpaid=Number(temp[3]);
					
				}
				$scope.onfetchleavetype();
			}		
 
			$scope.hastrue=false;
			
		}).error(function (data, status, headers, config) {
			//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}
	
$scope.onfetchtimeoffapproval =function($id)
	{ 
//alert($id);
		$scope.hastrue=true;
		var xsrf = $.param({timeoffapprovalid: $id});
		$http({
			url: path+'leave/getatimeoffapproval',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
		
			if(data.status){
                $scope.empid=data.data[0]['employee'];
				$scope.employeeid=data.data[0]['employeeid'];
				$scope.fromdate=data.data[0]['TimeofDate'];
				$scope.fromtime=data.data[0]['FromTime'];
				$scope.totime=data.data[0]['ToTime'];
				$scope.totaltime=data.data[0]['TotalTime'];
				$scope.timeoffreason=data.data[0]['Reason'];
				$scope.createddate=data.data[0]['CreatedDate'];
				$scope.comment=data.data[0]['ApproverComment'];
				$scope.employeetimeoffid=$id;
				
				$scope.designation = data.data[0]['designation'];
				$scope.st=data.data[0]['ApprovalSts'];
				if ($scope.st==1) {
					$scope.timeoffstatus="Rejected";
					}else if($scope.st==2){
					$scope.timeoffstatus="Approved";
					}else if($scope.st==4){
					$scope.timeoffstatus="Cancel";
					}else if($scope.st==5){
					$scope.timeoffstatus="WithDraw";
					}else{
					$scope.timeoffstatus="pending";
					}
				
				
				
				
				
			}		
 
			$scope.hastrue=false;
			
		}).error(function (data, status, headers, config) {
			//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}	
	
	
	$scope.onaddcomment = function($id)
	{
		
	
		 $('#comment').modal('show');
		 $scope.approverresult=$id;
		 
		 
	}
	
	$scope.onapprove = function($val)
	{ 
		var leavebreakdown="";
		if($scope.val==2 && $scope.approverresult==2)
		{
			leavebreakdown=$scope.entitled+','+$scope.carryforward+','+$scope.advance+','+$scope.unpaid;
		}
		$scope.hastrue=true;
		$('#comment').modal('hide');
		var xsrf = $.param({ employeeleaveid:$scope.employeeleaveid, approverresult:$scope.approverresult, comment:$scope.comment,leavebreakdown:leavebreakdown });
		$http({
			url: path+'leave/approveleaveapproval',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
		 //errorMessage( $scope.leavevalidsts);
			if(data.status){
            	successMessage(data.successMsg);
				if($val==1){
					$timeout(function(){window.open(path+"leave/leave_approval", "_self");}, timeo);
				}				
			}else{
				errorMessage(data.errorMsg);
			}
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}

	$scope.onreject = function($val)
	{ 
		$scope.hastrue=true;
		
		var xsrf = $.param({ employeeleaveid:$scope.employeeleaveid });
		$http({
			url: path+'leave/rejectleaveapproval',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
		 //errorMessage( $scope.leavevalidsts);
			if(data.status){
            	successMessage(data.successMsg);
				if($val==1){
					$timeout(function(){window.open(path+"leave/leave_approval", "_self");}, timeo);
				}				
			}else{
				errorMessage(data.errorMsg);
			}
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}


$scope.ontimeoffapprove = function($val)
	{ 
		var leavebreakdown="";
		
		$scope.hastrue=true;
		$('#comment').modal('hide');
		var xsrf = $.param({ employeetimeoffid:$scope.employeetimeoffid,comment:$scope.comment,approverresult:$scope.approverresult});
		$http({
			url: path+'leave/approvetimeoffapproval',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
		 //errorMessage( $scope.leavevalidsts);
			if(data.status){
            	successMessage(data.successMsg);
				if($val==1){
					$timeout(function(){window.open(path+"leave/timeoff_approval", "_self");}, timeo);
				}				
			}else{
				errorMessage(data.errorMsg);
			}
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}

	

});



///////////////////////////// report Controller Starts From Here  ///////////////////////////////////

app.controller('reportCtrl', function($scope, $http, $timeout) {

	$scope.hastrue=false;
	$scope.customsts=0;
	$scope.reportid=0;
	$scope.fiscalview="";
	$scope.reportname="";
	$scope.modulename="";
	$scope.selectedcol="";
	$scope.groupby1="";
	$scope.groupby2="";
	$scope.leftdisable=true;
	$scope.rightdisable=true;
	$scope.orderby1='asc';
	$scope.orderby2='asc';
	$scope.orderbytype='orderby';
	$scope.modulesarr = [];
	$scope.columnsarr = [];
	$scope.groupcolumnsarr = [];
	$scope.selectedcolumnsarr = [];
	$scope.filtercolumn=[];
	$scope.datefilterid=0;
	$scope.datefilter=0;
	$scope.leavereportarr=[];
	$scope.timesheetarr=[];
	$scope.fromdate=0;
	$scope.from=0;
	$scope.todate=0;
	$scope.to=0;
	$scope.tempar=[];
	$scope.totalcolarr=[];
	$scope.filtercolumnsarr=[];
	$scope.reportype="";
	$scope.totalcolumn="";
	$scope.mails="";
	$scope.startdate="";
	$scope.enddate="";
	$scope.client="";
	$scope.projectid="";
	$scope.empid="";
	$scope.leavetypearr=[];
	
	onfetch('setup/getalldivision',1);
	onfetch('setup/getalldesignation',2);
	onfetch('setup/getsenioremail',3);
	onfetch('setup/getalldepartment',4);
	onfetch('setup/getallchannel',5);
	onfetch('client/getallclients',6);
	onfetch("milestone/getAllRunningProject",7);
	onfetch('other',8);
	onfetch('setup/getallemployee',9);
	onfetch('employee/getEmployeeListbyreport',10);
	onfetch('employee/getEmployeeListbyreportproject',11);
	onfetch('leave/getallleavetype',12);
	onfetch('attendance/getallshift',13);
	$scope.orderarr = [{id:'asc', name:"Ascending"},{id:'desc', name:"Descending"}];
	$scope.ordertypearr = [{id:'orderby', name:"Order By"},{id:'groupby', name:"Group By"}];
	$scope.conditionarr = [{id:'OR', name:"OR"},{id:'AND', name:"AND"}];
	$scope.conditionarr2 = [];
	$scope.filterarr = [{id:0, condition1:"AND", column:"", condition2:"", textvalue:"" }];
	/////////////////////////////
	$scope.GetSelectedDepartment = function(){
		//alert($scope.client);
		$http({
			url: path+'leave/getempteam/'+$scope.client,
			method: "POST",
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			if(data.status){
				$scope.employeearray = [];
				$scope.employeearray = data.data;
			
			}else{
				errorMessage(data.errorMsg);
			}
			
		}).error(function (data, status, headers, config) {
				$scope.hastrue=false;
		});
	}
	$scope.getselectedemployee = function(){
		
		http({
			url:path+'',
			method:'POST',
			data:xsrf,
			headers:{'Content-Type':'application/x-www-urlencoded; charset=UTF-8'}
		}).success(function(data,headers,config,status){
			if(data.status){
				successMessage(data.successMsg);
				cleardata();
			}
		})
	}
	$scope.range = function(count){
		var ratings = []; 
		for (var i = 0; i < count; i++){ 
			ratings.push(i) 
		} 
		return ratings;
	}
	$scope.getId = function($id) {
		$scope.reportid=$id;
	}
	$scope.ondelete =function() {
		//$scope.rolearr=[];
		//$scope.hastrue=true;
		$http({
			url: path+'employee/deletereport/'+$scope.reportid,
			method: "POST",
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			if(data.status){
				successMessage(data.successMsg);
				table.draw();
			}else{
				errorMessage(data.errorMsg);
			}
			$scope.reportid=0;
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}
	/////attendence--> Report
	$scope.timediff = function($val){
		if($val==1) {
			if($scope.fromdate != ""){
				var datefrom=$( '#fromdate' ).datepicker( "getDate" );
				//$scope.resumptiondate="";
				$scope.todate="";
				$('#todate').datepicker("remove");
				$('#todate').datepicker({
					startDate: datefrom
				});
			}
		}
		if($val==2) {
			if($scope.todate != ""){
				//$scope.resumptiondate="";
				var dateto=$( '#todate' ).datepicker( "getDate" );  
				$('#todate').datepicker("remove");
				$('#todate').datepicker({
					startDate: dateto
				});
			}
		}
	}
	/////employee--> Report
	$scope.datediff = function($val){
		if($val==1) {
			if($scope.fromdate != ""){
				var datefrom=$( '#fromdate' ).datepicker( "getDate" );
				//$scope.resumptiondate="";
				$scope.todate="";
				$('#todate').datepicker("remove");
				$('#todate').datepicker({
					startDate: datefrom
				});
			}
		}
		if($val==2) {
			if($scope.todate != ""){
				//$scope.resumptiondate="";
				var dateto=$( '#todate' ).datepicker( "getDate" );  
				$('#todate').datepicker("remove");
				$('#todate').datepicker({
					startDate: dateto
				});
			}
		}
	}
	/////Timesheet--> Report
	$scope.difdate = function($val){
		if($val==1) {
			if($scope.fromdate != ""){
				var datefrom=$( '#fromdate' ).datepicker( "getDate" );
				//$scope.resumptiondate="";
				$scope.todate="";
				$('#todate').datepicker("remove");
				$('#todate').datepicker({
					startDate: datefrom
				});
			}
		}
		if($val==2) {
			if($scope.todate != ""){
				//$scope.resumptiondate="";
				var dateto=$( '#todate' ).datepicker( "getDate" );  
				$('#todate').datepicker("remove");
				$('#todate').datepicker({
					startDate: dateto
				});
			}
		}
	}
	////salary--report
	$scope.saldate = function($val){
		if($val==1) {
			if($scope.fromdate != ""){
				var datefrom=$( '#fromdate' ).datepicker( "getDate" );
				//$scope.resumptiondate="";
				$scope.todate="";
				$('#todate').datepicker("remove");
				$('#todate').datepicker({
					startDate: datefrom
				});
			}
		}
		if($val==2) {
			if($scope.todate != ""){
				//$scope.resumptiondate="";
				var dateto=$( '#todate' ).datepicker( "getDate" );  
				$('#todate').datepicker("remove");
				$('#todate').datepicker({
					startDate: dateto
				});
			}
		}
	}
	$scope.fetchmodel = function($tabid) {
		$scope.hastrue=true;
		var xsrf = $.param({tabid: $tabid});
		$http({
			url: path+'leave/getreportingmodule',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			if(data.status){
				$scope.modulesarr=data.data;
			}			
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}
	$scope.fetchmodelcolumn = function() {	
		if($scope.modulename.length>2 && $scope.tabid!=5){
			errorMessage('Choose only 2 Modules..');
		} else{
			$scope.hastrue=true;
			var xsrf = $.param({tablename: $scope.modulename});
			$http({
				url: path+'employee/getcolumnname',
				method: "POST",
				data: xsrf,
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			}).success(function (data, status, headers, config) {
				if(data.status){
					$scope.columnsarr=data.data;
					$scope.datefiltercolumn=[];
					$scope.filtercolumn=[];
					if($scope.filterarr.length == 0){
						$scope.filterarr = [{id:0, condition1:"AND", column:"", condition2:"", textvalue:"" }];
					}
					$scope.selectedcolumnsarr=new Array();
					//$scope.groupcolumnsarr = data.data;
					//name: "EmployeeCode", label: "Employee Code", type: "var", colindex: ""
					for(var i=0;i<$scope.columnsarr.length;i++){
						$scope.filtercolumn.insert(i, {name: $scope.columnsarr[i]['name'], label: $scope.columnsarr[i]['label'], type: $scope.columnsarr[i]['type'], colindex:$scope.columnsarr[i]['colindex'],tablename:$scope.columnsarr[i]['tablename']});
					}
					for(var i=0;i<$scope.columnsarr.length;i++){
						if($scope.columnsarr[i]['type'] == 'dat' || $scope.columnsarr[i]['type'] == 'dattim'){
							$scope.datefiltercolumn.insert(i, {name: $scope.columnsarr[i]['name'], label: $scope.columnsarr[i]['label'], type: $scope.columnsarr[i]['type'], colindex:$scope.columnsarr[i]['colindex']});
						}
					}
				}	
							
				$scope.hastrue=false;
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
		}	
	}
	$scope.onchangecol = function($val,$index){
		//alert($index+" "+$scope.filterarr[$index]['type']+" "+$val);
		for(var i=0;i<$scope.filtercolumn.length;i++){
			if($scope.filtercolumn[i]['name']==$val){
				$scope.filterarr[$index]['type']= $scope.filtercolumn[i]['type'];
				$scope.filterarr[$index]['tablename']= $scope.filtercolumn[i]['tablename'];
			}
		}
	
		if($scope.filterarr[$index]['type'] == 'var' || $scope.filterarr[$index]['type'] == 'tex' || $scope.filterarr[$index]['type'] == 'dat' || $scope.filterarr[$index]['type'] == 'dattim' || $scope.filterarr[$index]['type'] == 'int' || $scope.filterarr[$index]['type'] == 'tin'){
			$scope.conditionarr2[$index]=[];
			$scope.conditionarr2[$index] = [{id:'=', name:"is equal to"},{id:'<>', name:"is not equal to"}];
			$scope.filtercolumnsarr[$index]=[];
		}
		else if($scope.filterarr[$index]['type'] == 'flo' || $scope.filterarr[$index]['type'] == 'dou') {
			$scope.conditionarr2[$index]=[];
			$scope.conditionarr2[$index] = [{id:'=', name:"is equal to"},{id:'<', name:"is less than"},{id:'>', name:"is greater than"},{id:'<=', name:"is less than equal to"},{id:'>=', name:"is greater than equal to"},{id:'<>', name:"is not equal to"}];
			$scope.filtercolumnsarr[$index]=[];
		}
		if(($scope.filterarr[$index]['type'] == 'tin' || $scope.filterarr[$index]['type'] == 'int') ){
			if($scope.filterarr[$index]['tablename'] != ""){
				var xsrf = $.param({tablename: $scope.modulename,columnname:$val});
				$http({
					url: path+'leave/getcolumnvalues',
					method: "POST",
					data: xsrf,
					headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
				}).success(function (data, status, headers, config) {
					if(data.status){
						$scope.filtercolumnsarr[$index]=[];
						$scope.filtercolumnsarr[$index]=data.data;
					}			
					$scope.hastrue=false;
				}).error(function (data, status, headers, config) {
					//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
					$scope.hastrue=false;
				});
			}else{
				$scope.filterarr[$index]['type'] ="";
			}
		}
	}
	$scope.toggleSelection = function($x) {
		if($scope.columnsarr[$x].vsts){		
			$scope.columnsarr[$x].vsts=false;
		}else{
			$scope.columnsarr[$x].vsts=true;
		}
		$scope.leftdisable=true;
		var len = $scope.columnsarr.length;
		for(var i=0; i<len; i++) {
			if($scope.columnsarr[i].vsts){		
				$scope.leftdisable=false;
				break;
			}
		}
	};
	$scope.toggleSelection1 = function($x) {
		if($scope.selectedcolumnsarr[$x].vsts){		
			$scope.selectedcolumnsarr[$x].vsts=false;
		}else{
			$scope.selectedcolumnsarr[$x].vsts=true;
		}
		$scope.rightdisable=true;
		var len = $scope.selectedcolumnsarr.length;
		for(var i=0; i<len; i++) {
			if($scope.selectedcolumnsarr[i].vsts){		
				$scope.rightdisable=false;
				break;
			}
		}
	};  
	$scope.onAddSelection = function() {
		$scope.leftdisable=true;
		$scope.rightdisable=true;
		for (var i=0; i<$scope.columnsarr.length; i++) {
			if ($scope.columnsarr[i].vsts){ 
				$scope.columnsarr[i].vsts=false;
				$scope.selectedcolumnsarr.insert($scope.selectedcolumnsarr.length,$scope.columnsarr[i]);
				$scope.columnsarr[i].vsts=true;
			}
		}
		for ( var i=$scope.columnsarr.length-1; i>=0; i--) {
			if ($scope.columnsarr[i].vsts){ 
				$scope.columnsarr.remove(i);
			}
		}
		for ( var i=0; i<$scope.selectedcolumnsarr.length; i++) {
			$scope.selectedcolumnsarr[i].vsts=false;
		}
		$scope.totalcolarr=[];
		for(var i=0;i<$scope.selectedcolumnsarr.length;i++){
			if($scope.selectedcolumnsarr[i].type=='int' || $scope.selectedcolumnsarr[i].type=='flo' || $scope.selectedcolumnsarr[i].type=='dou' || $scope.selectedcolumnsarr[i].label=='Time spent' || $scope.selectedcolumnsarr[i].type=='tim'){
				if($scope.selectedcolumnsarr[i].tablename=='')
				$scope.totalcolarr.push($scope.selectedcolumnsarr[i]);
			}
		}
		$scope.groupcolumnsarr=[];
		for(var i=0;i<$scope.selectedcolumnsarr.length;i++){
			/*if($scope.totalcolarr.length>0){
				for(var j=0;j<$scope.totalcolarr.length;j++){
					if($scope.selectedcolumnsarr[i].name != $scope.totalcolarr[j].name)
						$scope.groupcolumnsarr.push($scope.selectedcolumnsarr[i]);
					}
				}else{
			}*/
			$scope.groupcolumnsarr.push($scope.selectedcolumnsarr[i]);
		}
	}
	$scope.onRemoveSelection = function() {
		$scope.leftdisable=true;
		$scope.rightdisable=true;
		for ( var i=0; i<$scope.selectedcolumnsarr.length; i++) {
			if ($scope.selectedcolumnsarr[i].vsts){ 
				$scope.selectedcolumnsarr[i].vsts=false;
				$scope.columnsarr.insert($scope.columnsarr.length,$scope.selectedcolumnsarr[i]);
				$scope.selectedcolumnsarr[i].vsts=true;
			}
		}
		for ( var i=$scope.selectedcolumnsarr.length-1; i>=0; i--) {
			if ($scope.selectedcolumnsarr[i].vsts){ 
				$scope.selectedcolumnsarr.remove(i);
			}
		}
		for ( var i=0; i<$scope.columnsarr.length; i++) {
			$scope.columnsarr[i].vsts=false;
		}
		$scope.totalcolarr=[];
		for(var i=0;i<$scope.selectedcolumnsarr.length;i++){
			if($scope.selectedcolumnsarr[i].type=='int' || $scope.selectedcolumnsarr[i].type=='flo' || $scope.selectedcolumnsarr[i].type=='dou' || $scope.selectedcolumnsarr[i].label=='Time spent' || $scope.selectedcolumnsarr[i].type=='tim'){
				if($scope.selectedcolumnsarr[i].tablename=='')
				$scope.totalcolarr.push($scope.selectedcolumnsarr[i]);
			}
		}
		$scope.groupcolumnsarr=[];
		for(var i=0;i<$scope.selectedcolumnsarr.length;i++){
			/*if($scope.totalcolarr.length>0){
				for(var j=0;j<$scope.totalcolarr.length;j++){
					if($scope.selectedcolumnsarr[i].name != $scope.totalcolarr[j].name)
						$scope.groupcolumnsarr.push($scope.selectedcolumnsarr[i]);
					}
				}else{
				$scope.groupcolumnsarr.push($scope.selectedcolumnsarr[i]);
			}*/
			$scope.groupcolumnsarr.push($scope.selectedcolumnsarr[i]);
		}		
	}
	var move = function (origin, destination) {
        var temp = $scope.selectedcolumnsarr[destination];
        $scope.selectedcolumnsarr[destination] = $scope.selectedcolumnsarr[origin];
        $scope.selectedcolumnsarr[origin] = temp;
    };
	$scope.moveUp = function(){ 
		for ( var i=0; i<$scope.selectedcolumnsarr.length; i++) {
			if ($scope.selectedcolumnsarr[i].vsts){ 
				if(i != 0){
					move(i, i - 1);
				}
				//break;
				$scope.selectedcolumnsarr[i].vsts=false;
			}
		}
    };
	$scope.moveDown = function(){  
		for ( var i=0; i<$scope.selectedcolumnsarr.length; i++) {
			if ($scope.selectedcolumnsarr[i].vsts){ 
				if(i < $scope.selectedcolumnsarr.length-1){
					move(i, i + 1);
				}
				$scope.selectedcolumnsarr[i].vsts=false;
				break;
			}
		} 
    };
	$scope.addfilter = function($i) {	
		var len = $scope.filterarr.length-1;
		if($scope.filterarr[len]['column'] == "" || $scope.filterarr[len]['condition2'] == "" || $scope.filterarr[len]['textvalue'] == ""){
			errorMessage("Fill all the fields");
		}else{
			$scope.filterarr.insert($i, {id:0, condition1:"AND", column:"", condition2:"", textvalue:"" });
		}
	}
    $scope.removefilter = function($i){
		$scope.filterarr.remove($i);
		if($scope.filterarr.length == 0) {
			$scope.filterarr.insert($i, {id:0, condition1:"AND", column:"", condition2:"", textvalue:"" });
		}
	}
	Array.prototype.insert = function (index, item) {
	  this.splice(index, 0, item);
	};
	Array.prototype.remove = function (index) {
	  this.splice(index,1);
	};
	$scope.onfetchreport =function($id) {
		
		$scope.hastrue=true;
		var xsrf = $.param({reportid: $id});
		$http({
			url: path+'leave/getareport',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			if(data.status){
				$scope.todaydate=data.date;
				$scope.reportname=data.data[0]['name'];
				$scope.reportype=data.data[0]['reportype'];
				$scope.totalcolumn=data.data[0]['totalcolumn'];
				$scope.customsts = data.data[0]['customsts'];
				if(data.data[0]['module'] != ""){
				$scope.modulename=data.data[0]['module'].split(',');
				$scope.fetchmodelcolumn();
			}
			var temparr= data.data[0]['selectedcol'];
			$timeout(function(){
				for ( var x=0; x<temparr.length; x++){
					for ( var i=0; i<$scope.columnsarr.length; i++){
						if ($scope.columnsarr[i].name == temparr[x]){ 
							$scope.selectedcolumnsarr.insert($scope.selectedcolumnsarr.length,$scope.columnsarr[i]);
							//$scope.selectedcolumnsarr.sort();
							$scope.columnsarr.remove(i);
						}
					}
				}
				for(var i=0;i<$scope.selectedcolumnsarr.length;i++){
					if($scope.selectedcolumnsarr[i].type=='int' || $scope.selectedcolumnsarr[i].type=='flo' || $scope.selectedcolumnsarr[i].type=='dou' || $scope.selectedcolumnsarr[i].label=='Time spent' || $scope.selectedcolumnsarr[i].type=='tim'){
						if($scope.selectedcolumnsarr[i].tablename=='')
						$scope.totalcolarr.push($scope.selectedcolumnsarr[i]);
					}
				}
				for(var i=0;i<$scope.selectedcolumnsarr.length;i++){
					/*if($scope.totalcolarr.length>0){
						for(var j=0;j<$scope.totalcolarr.length;j++){
							if($scope.selectedcolumnsarr[i].name != $scope.totalcolarr[j].name)
							$scope.groupcolumnsarr.push($scope.selectedcolumnsarr[i]);
						}
					}else{
						}*/
					$scope.groupcolumnsarr.push($scope.selectedcolumnsarr[i]);
				}
				if(data.data[0]['groupby'] != ""){
					if((data.data[0]['groupby']).indexOf (',') > -1){
						var gru=data.data[0]['groupby'].split(' ');
						var groupby1=gru[0].split(' ');
						var groupby2=gru[1].split(' ');
						
						$scope.groupby1=gru[0];
						$scope.orderby1=gru[1].replace(",",'');
						$scope.groupby2=gru[2];
						$scope.orderby2=gru[3];
						$scope.orderbytype=gru[4];
					} else{
						var gru=data.data[0]['groupby'].split(' ');
						$scope.groupby1=gru[0];
						$scope.orderby1=gru[1];
						$scope.orderbytype=gru[2];
					}
				}
				var temp=data.data[0]['reportfilter'];	
				if(temp.length == 0){
					$scope.filterarr.insert(0, {id:0, condition1:"AND", column:"", condition2:"", textvalue:"" });
				}else{
					if(temp[0]['condition2'] == 'between'){
						$scope.datefilterid=temp[0]['id'];
						$scope.datefilter = temp[0]['column'];
						$scope.datecondition = temp[0]['condition2'];
						if(temp[0]['textvalue'] != ""){
							var a=temp[0]['textvalue'].split("'AND'");
							$scope.fromdate = a[0].replace(/'/g, "");
							$scope.todate = a[1].replace(/'/g, "");
						}
					}else if(temp[0]['type'] == 'dat' || temp[0]['type'] == 'dattim' || temp[0]['type'] == ''){
							$scope.datefilterid=temp[0]['id'];
							$scope.datefilter = temp[0]['column'].replace( /(^.*\(|\).*$)/g, '' );
							if(temp[0]['textvalue'] == 'YEAR(NOW()) AND MONTH(DOL)= MONTH(NOW())-1')
							$scope.datecondition = 'lmonth';
							else if(temp[0]['textvalue'] == 'YEAR(NOW()) AND MONTH(DOL)= MONTH(NOW())')
							$scope.datecondition = 'tmonth';
							else if(temp[0]['textvalue'] == 'CURDATE()' )
							$scope.datecondition = 'today';
							else if(temp[0]['textvalue'] == 'CURDATE() + INTERVAL 1 DAY' )
							$scope.datecondition = 'tomorrow';
							else if(temp[0]['textvalue'] == 'CURDATE() - INTERVAL 1 DAY' )
							$scope.datecondition = 'yesterday';
							else if(temp[0]['textvalue'] == '(CURDATE() - INTERVAL 1 WEEK) and CURDATE()' )
							$scope.datecondition = 'lweek';
							else if(temp[0]['textvalue'] == 'WEEKOFYEAR(NOW()) and YEAR('+$scope.datefilter+')=YEAR(NOW())' )
							$scope.datecondition = 'tweek';
							else if(temp[0]['textvalue'] == '(CURDATE() + INTERVAL 1 WEEK) and (CURDATE() + INTERVAL 2 WEEK)' )
							$scope.datecondition = 'nweek';
							else if(temp[0]['textvalue'] == 'YEAR(NOW()) AND MONTH('+$scope.datefilter+')= MONTH(NOW())' )
							$scope.datecondition = 'tmonth';
							else if(temp[0]['textvalue'] == 'DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), "%Y-%m-01") and LAST_DAY(NOW() - INTERVAL 1 MONTH)' )
							$scope.datecondition = 'lmonth';
							else if(temp[0]['textvalue'] == 'DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL 1 MONTH), \"%Y-%m-01\") and LAST_DAY(CURDATE() + INTERVAL 1 MONTH)' )
							$scope.datecondition = 'nmonth';
							else if(temp[0]['textvalue'] == 'YEAR(NOW())' )
							$scope.datecondition = 'tyear';
							else if(temp[0]['textvalue'] == 'YEAR(NOW())-1' )
							$scope.datecondition = 'lyear';
							else if(temp[0]['textvalue'] == 'YEAR(NOW())+1' )
							$scope.datecondition = 'nyear';
							$scope.onchangecondition();
						}
					if(temp.length>1){
						$scope.filterarr=data.data[0]['reportfilter'];	
						$scope.filterarr.remove(0);
						for(var i=0;i<$scope.filterarr.length;i++) {
							$scope.onchangecol($scope.filterarr[i].column,i);
						}		
					}
				}
			}, timeo); 
		}
			$scope.todaydate=data.date;
			$scope.fiscalstartdate=data.fiscalstartdate;
			$scope.fiscalenddate=data.fiscalenddate;
			$scope.dateformat=data.dateformat;
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}
	$scope.onfetchreport1 =function($id) {
		//console.log($id);
		$scope.hastrue=true;
		var xsrf = $.param({reportid: $id});
		$http({
			url: path+'leave/getareport',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {
				if(data.status){
				var reportname=data.data[0]['name'].charAt(0).toUpperCase() + data.data[0]['name'].slice(1);
				
				var aryColTableChecked = data.data[0]['reportcolumns'];
				$scope.customsts = data.data[0]['customsts'];
				var org=data.orgdetails[0]['org']+"<br>"+data.orgdetails[0]['email']+"<br>"+data.orgdetails[0]['phone']+"<br>"+data.orgdetails[0]['city']+"<br>"+data.orgdetails[0]['country'];
				var img ="<img src='"+data.orgdetails[0]['image']+"' id='img1'  />";
				var aryJSONColTable = [];
				var collength=aryColTableChecked.length;
				for (var i=0; i < aryColTableChecked.length; i++ ) {
					  aryJSONColTable.push({
							"sTitle": aryColTableChecked[i],
							"aTargets": [i]
				   });
				};
				var groupby="";
				var groupby1="";
				var selectedcol=data.data[0]['selectedcol'];
				if(data.data[0]['groupby1'] != ""){
					groupby=data.data[0]['groupby1'].split(" ");
					var temp=groupby.length-1;
					groupby1=groupby[0].replace(/,/g,'');
					var a = selectedcol.indexOf(groupby1);
					var type =groupby[temp];
				}
				var totalcolumn = data.data[0]['totalcolumn'];
				var totalcolumntyp = data.data[0]['totalcolumntyp'];
				if(totalcolumn != ""){
					var b = selectedcol.indexOf(totalcolumn);
				}
				$scope.table = $('#example1').DataTable({
					"bProcessing": true,
					"bServerSide": true,
					"searching": false,
					"ordering": false,
					"paging": false,
					"sAjaxSource": path+"leave/getReportData1/"+$id,
					//"dom": '<"top" i>Blf<"clear">rtpi',
					//"dom": 'T<"clear">lfrtip<"clear">T',
					"dom": 'Bfrtip',
					 "buttons": [
				'copy', 'csv', 'excel', 'pdf', 'print'
				],
					/* "tableTools": {
						"sSwfPath": path+"public/plugins/responsive/swf/copy_csv_xls_pdf.swf"
					}, */
					"aoColumns": aryJSONColTable,
					"drawCallback": function ( settings ) {
						var api = this.api();
						var rows = api.rows( {page:'current'} ).nodes();
						var last=null;
						var total=0; 
						var subtotal=0;
						var subtime=0;
						var tottime=0;
						var rowsData = api.rows({page:'current'}).data();
						//alert(JSON.stringify(rowsData));
							api.column(a, {page:'current'} ).data().each( function ( group, i ) {
								if ( last !== group ) {
								//console.log(sAjaxSource)
									
									if(type =="groupby"){
										if(i>0){
											if(totalcolumn != ""){
												
												$(rows).eq( i ).before(
													'<tr class="group"><td class="bg-warning text-bold" colspan="'+(collength-2)+'">Sub Total</td><td class="bg-warning text-bold">'+subtotal+'</td></tr>'
									       			);
												subtotal=0;
												subtime=0;
											}	
										}
										$(rows).eq( i ).before(
											'<tr class="group"><td class="bg-success text-center" colspan="'+(collength-1)+'"><h4>'+group+'</h4></td></tr>'
										);
										$timeout(function(){$scope.table.column(a).visible(false);}, 1000);
									}else{
										if(i>0){
										if(totalcolumn != ""){
											$(rows).eq( i ).before(
											'<tr class="group"><td class="bg-warning text-bold" colspan="'+(collength-1)+'">Sub Total</td><td class="bg-warning text-bold">'+subtotal+'</td>'
											);
											subtotal=0;
											subtime=0;
										}	
									}
									}	
									last = group;
									}
								if(totalcolumn != "" ){
								if(totalcolumntyp == 'tim')
								{
									var caltime=0;
									if(rowsData[i][b]){
									caltime = rowsData[i][b].split(':');
									//for negative time//
									if(caltime[0].includes('-'))
									{
										caltime = ((caltime[0]) * 3600) - (caltime[1]*60) - (caltime[2]);
											
									}
									//for positive time//
									else{
										caltime = (+caltime[0]) * 3600 + (+caltime[1] * 60) + (+caltime[2]);
									}
									}
									tottime = tottime + caltime;
									subtime = subtime + caltime;
									total = parseInt(tottime / 3600) +' hours '+ parseInt(tottime % 3600 / 60) + ' minutes';
									
									subtotal = parseInt(subtime / 3600) +' hours '+ parseInt(subtime % 3600 / 60) + ' minutes';
								}
								else{
								total = total + parseFloat(rowsData[i][b]);
								subtotal = subtotal + parseFloat(rowsData[i][b]);
								}
								}
							} );
							
						if(type =="groupby"){	
							collength = collength-2;
						}else{
							collength = collength-1;
						}	
								if(totalcolumn != ""){
									$(rows).eq( rows.length-1).after(
										'<tr class="group"><td class="bg-danger text-bold" colspan="'+(collength)+'">Grand Total</td><td class="bg-danger text-bold">'+total+'</td></tr>'
									);	
									$(rows).eq( rows.length-1 ).after(
										'<tr class="group"><td class="bg-warning text-bold" colspan="'+(collength)+'">Sub Total</td><td class="bg-warning text-bold">'+subtotal+'</td></tr>'
									);
								}
					}
				});
				$('#example1 caption').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><h3>"+reportname+"</h3></div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
					//$('#example1 caption').html("<h4 style='text-align:right'>"+org+"</h4>"); 
			}
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}
	$scope.onchangecondition = function() {
		$scope.tempar=new Array();
		var currentDate = new Date($scope.todaydate);
		var tomorrow = new Date($scope.todaydate);
		if($scope.datecondition == 'today'){
			$( "#fromdate" ).datepicker( "option", "dateFormat", $scope.dateformat );
			$scope.fromdate=currentDate.getDate()  +'/'+ (currentDate.getMonth()+1) +'/'+ currentDate.getFullYear();
			$scope.todate=currentDate.getDate()  +'/'+ (currentDate.getMonth()+1) +'/'+ currentDate.getFullYear();
			$scope.tempar.insert (0,{id:$scope.datefilterid, condition1:"AND", column:$scope.datefilter, condition2:'=', textvalue: 'CURDATE()' });
		}
		else if($scope.datecondition == 'tomorrow'){
			$scope.fromdate=currentDate.getDate()  +'/'+ (currentDate.getMonth()+1) +'/'+ currentDate.getFullYear();
			tomorrow.setDate(tomorrow.getDate() + 1);
			$scope.todate=tomorrow.getDate() +'/'+ (tomorrow.getMonth()+1) +'/'+ tomorrow.getFullYear() ;
			$scope.tempar.insert (0,{id:$scope.datefilterid, condition1:"AND", column:$scope.datefilter, condition2:'=', textvalue: 'CURDATE() + INTERVAL 1 DAY' });
		}
		else if($scope.datecondition == 'yesterday'){
			tomorrow.setDate(tomorrow.getDate() - 1);
			$scope.fromdate=tomorrow.getDate() +'/'+ (tomorrow.getMonth()+1) +'/'+ tomorrow.getFullYear() ;
			$scope.todate=currentDate.getDate()  +'/'+ (currentDate.getMonth()+1) +'/'+ currentDate.getFullYear();
			$scope.tempar.insert (0,{id:$scope.datefilterid, condition1:"AND", column:$scope.datefilter, condition2:'=', textvalue: 'CURDATE() - INTERVAL 1 DAY' });
		}
		else if($scope.datecondition == 'tweek'){
			tomorrow.setDate(tomorrow.getDate() - tomorrow.getDay());	
			$scope.fromdate=tomorrow.getDate() +'/'+ (tomorrow.getMonth()+1) +'/'+ tomorrow.getFullYear() ;
			$scope.todate= (currentDate.getDate() - currentDate.getDay() + 6) +'/'+ (currentDate.getMonth()+1) +'/'+ currentDate.getFullYear();
			$scope.tempar.insert (0,{id:$scope.datefilterid, condition1:"AND", column:'WEEKOFYEAR('+$scope.datefilter+')', condition2:'=', textvalue: 'WEEKOFYEAR(NOW()) and YEAR('+$scope.datefilter+')=YEAR(NOW())' });
		}
		else if($scope.datecondition == 'lweek'){
			tomorrow.setDate(tomorrow.getDate() - tomorrow.getDay() -7);	
			$scope.fromdate=tomorrow.getDate() +'/'+ (tomorrow.getMonth()+1) +'/'+ tomorrow.getFullYear() ;
			currentDate.setDate(tomorrow.getDate() + 6 );
			$scope.todate= currentDate.getDate()  +'/'+ (currentDate.getMonth()+1) +'/'+ currentDate.	getFullYear();
			$scope.tempar.insert (0,{id:$scope.datefilterid, condition1:"AND", column:$scope.datefilter, condition2:'BETWEEN', textvalue: '(CURDATE() - INTERVAL 1 WEEK) and CURDATE()' });
		}
		else if($scope.datecondition == 'nweek'){
			tomorrow.setDate(tomorrow.getDate() - tomorrow.getDay() +7);	
			$scope.fromdate=tomorrow.getDate() +'/'+ (tomorrow.getMonth()+1) +'/'+ tomorrow.getFullYear() ;
			currentDate.setDate(tomorrow.getDate() + 6 );
			$scope.todate= currentDate.getDate()  +'/'+ (currentDate.getMonth()+1) +'/'+ currentDate.getFullYear();
			$scope.tempar.insert (0,{id:$scope.datefilterid, condition1:"AND", column:$scope.datefilter, condition2:'BETWEEN', textvalue: '(CURDATE() + INTERVAL 1 WEEK) and (CURDATE() + INTERVAL 2 WEEK)' });
		}
		else if($scope.datecondition == 'tmonth'){
			currentDate.setMonth(currentDate.getMonth()+1 ,0);
			$scope.fromdate  = 1  +'/'+ (currentDate.getMonth()+1) +'/'+ currentDate.getFullYear();
			$scope.todate = currentDate.getDate()  +'/'+ (currentDate.getMonth()+1) +'/'+ currentDate.getFullYear();
		
			$scope.tempar.insert (0,{id:$scope.datefilterid, condition1:"AND", column:'YEAR('+$scope.datefilter+')', condition2:'=', textvalue: 'YEAR(NOW()) AND MONTH('+$scope.datefilter+')= MONTH(NOW())' });
		}
		else if($scope.datecondition == 'lmonth'){
			currentDate.setMonth(currentDate.getMonth() ,0);
			$scope.fromdate  = 1  +'/'+ (currentDate.getMonth()+1) +'/'+ currentDate.getFullYear();
			$scope.todate = currentDate.getDate()  +'/'+ (currentDate.getMonth()+1) +'/'+ currentDate.getFullYear();
			$scope.tempar.insert (0,{id:$scope.datefilterid, condition1:"AND", column:$scope.datefilter, condition2:'BETWEEN', textvalue: 'DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), "%Y-%m-01") and LAST_DAY(NOW() - INTERVAL 1 MONTH)' });
		}
		else if($scope.datecondition == 'nmonth'){
			currentDate.setMonth(currentDate.getMonth()+2 ,0);
			$scope.fromdate  = 1  +'/'+ (currentDate.getMonth()+1) +'/'+ currentDate.getFullYear();
			$scope.todate = currentDate.getDate()  +'/'+ (currentDate.getMonth()+1) +'/'+ currentDate.getFullYear();
			$scope.tempar.insert (0,{id:$scope.datefilterid, condition1:"AND", column:$scope.datefilter, condition2:'BETWEEN', textvalue: 'DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL 1 MONTH), "%Y-%m-01") and LAST_DAY(CURDATE() + INTERVAL 1 MONTH)' });
		}
		else if($scope.datecondition == 'tyear'){
			currentDate.setFullYear(currentDate.getFullYear(),11,31);
			$scope.fromdate  = 1  +'/'+ 1 +'/'+ currentDate.getFullYear();
			$scope.todate = currentDate.getDate()  +'/'+ (currentDate.getMonth()+1) +'/'+ currentDate.getFullYear();
			$scope.tempar.insert (0,{id:$scope.datefilterid, condition1:"AND", column:'YEAR('+$scope.datefilter+')', condition2:'=', textvalue: 'YEAR(NOW())' });
		}
		else if($scope.datecondition == 'lyear'){
			currentDate.setFullYear(currentDate.getFullYear()-1,11,31);
			$scope.fromdate  = 1  +'/'+ 1 +'/'+ currentDate.getFullYear();
			$scope.todate = currentDate.getDate()  +'/'+ (currentDate.getMonth()+1) +'/'+ currentDate.getFullYear();
			$scope.tempar.insert (0,{id:$scope.datefilterid, condition1:"AND", column:'YEAR('+$scope.datefilter+')', condition2:'=', textvalue: 'YEAR(NOW())-1' });
		}
		else if($scope.datecondition == 'nyear'){
			currentDate.setFullYear(currentDate.getFullYear()+1,11,31);
			$scope.fromdate  = 1  +'/'+ 1 +'/'+ currentDate.getFullYear();
			$scope.todate = currentDate.getDate()  +'/'+ (currentDate.getMonth()+1) +'/'+ currentDate.getFullYear();
			$scope.tempar.insert (0,{id:$scope.datefilterid, condition1:"AND", column:'YEAR('+$scope.datefilter+')', condition2:'=', textvalue: 'YEAR(NOW())+1' });
		}
		else if($scope.datecondition == 'between'){
			$scope.fromdate="";
			$scope.todate="";
		}else{
			$scope.fromdate="";
			$scope.todate="";
			$scope.tempar=[{id:$scope.datefilterid, condition1:0, column:0, condition2:"", textvalue: 0 }];
		}
	}
/////////////fetch data by date or division conditions starts from here//////////////
	$scope.onfetchclientreport=function($val){

$( "#refresh_div" ).show();
	$scope.hastrue=true;
	
	var xsrf = $.param({reportid:$scope.reportid, fromdate:$scope.from, todate:$scope.to,division:$scope.division});
  $http({
        url: path+'leave/daterangereport/'+$val,
        method: "POST",
		data: xsrf,
        headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
      }).success(function (data, status, headers, config) {
			if(data.status){
				//var reportid=data.reportid;
				$scope.show=true;
				var fromdate=data.startdate;
				var fiscalview="";
				var to=data.enddate;
				if(to!=undefined){
					var fiscalview='['+fromdate+' - '+to+']';
				}else{
					var fiscalview='['+fromdate+']';
				}
				$scope.currentmonth = fromdate;
				console.log($scope.currentmonth);
				$('#fiscalview').text(fiscalview);
				$('#fiscalvieww').text($scope.currentmonth);
				if($val==22)
				$('#currentmonth').text($scope.currentmonth);
				$scope.leavereportarr=data.data;
				if($val==1)
				document.getElementById('output').innerHTML=$scope.leavereportarr;
				//$scope.table.draw();
				//$timeout(function(){window.open(path+"leave/viewreport/"+reportid, '_self');}, timeo);
			}else{
				data.show=false;
				//errorMessage(data.errorMsg);
			}
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});

}
  
   $scope.onfetchattsumarry = function($id)
   {
	   
	         $scope.hastrue=true;
			 
			var date=$('#desig').val();
			
			/* if(date != "")
			{
		    var todayTime = new Date(date);
            var month = (todayTime . getMonth() + 1);
			 if(month<9)
				  month = 0+""+month;
            var year = (todayTime . getFullYear());
			  date = month+"-"+year;
			} */
			
			var xsrf = $.param({empl:$scope.empid,date:date,reportid: $id,division:$scope.division});
			$http({
			url: path+'leave/daterangereport/'+$id,
			method: "POST",
			data:xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			 console.log(data);
			 $scope.dates = data.date;
			var obj = data.data;
			  $scope.arrdate = obj;
			 $scope.records = obj;
			 $scope.from=data.startdate;
			console.log($scope.from);
			var fiscalview=data.startdate;
			$('#fiscalview').text(fiscalview); 
			
			$scope.hastrue=false 
		}).error(function (data, status, headers, config) {
			$scope.hastrue=false;
		});
   }
	$scope.onfetchtable=function($val){ 

//alert($scope.from);
//alert($scope.to);

		// $( "#refresh_div" ).show();
		//$scope.enddate=$('#enddate').val();
		//$scope.startdate=$('#startdate').val();

		// alert($scope.enddate);
		// alert($scope.startdate);
		
		if($scope.from != undefined  ){

			var temp= new Date($scope.from);
//			var temp= new Date(startdate);
		 	var gDay=temp.getDate();
			var gMonth=temp.getMonth()+1;
			var gYear=temp.getFullYear(); 
			$scope.from1=gYear+"-"+gMonth+"-"+gDay;
		}	
		//if($scope.startdate == ""){$scope.startdate="";}
		
	
		
		// //var fromdate=$('#from').val();
		// var fromdate=$( '#from' ).val(); 

		
		// if($scope.startdate != undefined || $scope.startdate !=""){
		// 	console.log($scope.startdate);
		// 	var temp= new Date($scope.startdate);
		// 	console.log(temp);
		// 	var gDay=temp.getDate();
		// 	var gMonth=temp.getMonth()+1;
		// 	var gYear=temp.getFullYear();
		// 	$scope.from=gDay+"/"+gMonth+"/"+gYear;
			
		// 	console.log($scope.from);
			
		// }	
		// if($scope.startdate == ""){$scope.startdate="";} 
		// var todate=$('#to').val();

		
		
			if($scope.to != undefined){
				var temp= new Date($scope.to);
				var gDay=temp.getDate();
				var gMonth=temp.getMonth()+1;
				var gYear=temp.getFullYear();
				$scope.to1=gYear+"-"+gMonth+"-"+gDay;
			}	
		
		//if($scope.enddate == ""){$scope.enddate="";}
		
		$scope.hastrue=true;
		var xsrf = $.param({reportid:$scope.reportid, fromdate:$scope.from1, todate:$scope.to1,division:$scope.division,projectid:$scope.projectid,client:$scope.client,startdate:$scope.startdate, enddate:$scope.enddate, empid:$scope.empid, shiftid:$scope.shiftid,departmentid:$scope.departmentid});

		$http({
			url: path+'leave/daterangereport/'+$val,
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			if(data.status){
				//var reportid=data.reportid;
				$scope.show=true;
				var fromdate=data.startdate;
				var todate=data.enddate;
				// console.log(fromdate);
				$scope.from=fromdate;
				$scope.to=todate;
		//		$scope.to=data.enddate;

				var fiscalview="";
				//var to=data.enddate;
				var to=data.enddate;
				if(to!=undefined){
					var fiscalview='['+fromdate+' - '+to+']';
				}else{
					var fiscalview='['+fromdate+']';
				}
				$scope.currentmonth = fromdate;
			//	console.log($scope.currentmonth);
			
				$('#fiscalview').text(fiscalview);
				$('#fiscalvieww').text($scope.currentmonth);
				if($val==22 )
				$('#currentmonth').text($scope.currentmonth);
				$scope.leavereportarr=data.data;
				$scope.attendaneyesarr=data.data;
				$scope.attendaneflexiarr=data.data;
				//if($val==1)
				//document.getElementById('example2').innerHTML=$scope.leavereportarr;
				//$scope.table.draw();
				//$timeout(function(){window.open(path+"leave/viewreport/"+reportid, '_self');}, timeo);
			}else{
				data.show=false;
				//errorMessage(data.errorMsg);
			}
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});

	} 


$scope.onfetchanonymousreport =function($id)
{
	$scope.hastrue=true;
	var xsrf = $.param({reportid: $id});
	$http({
        url: path+'leave/getareport',
        method: "POST",
		data: xsrf,
        headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
      }).success(function (data, status, headers, config) {
			if(data.status){
				$scope.todaydate=data.date;
				$scope.customsts=data.data[0]['customsts'];
				$scope.from=data.startdate;
				$scope.anonymousfeedbackreport=data.anonymousfeedbackreport;
				$scope.fiscalview=data.startdate;
				
				
				
				//document.getElementById('output').innerHTML=$scope.leavereportarr;
				var reportname=data.data[0]['name'].charAt(0).toUpperCase() + data.data[0]['name'].slice(1);
				
				var org=data.orgdetails[0]['org']+"<br>"+data.orgdetails[0]['email']+"<br>"+data.orgdetails[0]['phone']+"<br>"+data.orgdetails[0]['city']+"<br>"+data.orgdetails[0]['country'];
				var img ="<img src='"+data.orgdetails[0]['image']+"' id='img1' />";
					
				
				$('#example1 caption').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <span id='fiscalview'><p>["+$scope.fiscalview+"]</p></span></div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
				if($scope.customsts == 52){
					$('#header').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3> </div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
				}
				  
			}
						
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
			
		});
}

	
$scope.onchangefetchemployee =function()
{
	
	var xsrf = $.param({division: $scope.division});
	$http({
        url: path+'leave/getemployeefilterwise',
        method: "POST",
		data: xsrf,
        headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
      }).success(function (data, status, headers, config) {
			if(data.status){
			
			//	successMessage(data.successMsg);
				$scope.employeearray=[];
				$scope.employeearray=data.data;
				$timeout(function() {
					$('.selectpicker').selectpicker('refresh');                      
				}, 1000);
				 
			}else{
				errorMessage(data.errorMsg);
			}
		//	$scope.notificationid=0;
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);/$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
}
	
	
	$scope.onfetchtable2=function($val){ 
		var startdate=$('#startdate').val(); 
		
		 if(startdate != undefined  ){
			var temp= new Date(startdate+", 1");
//			var temp= new Date(startdate);
		 	var gDay=temp.getDate();
			var gMonth=temp.getMonth()+1;
			var gYear=temp.getFullYear(); 
			$scope.startdate=gYear+"-"+gMonth+"-"+gDay;
		}	
		if(startdate == ""){$scope.startdate="";}
		
		$scope.hastrue=true;
		var xsrf = $.param({reportid:$scope.reportid, division:$scope.division,projectid:$scope.projectid,client:$scope.client,startdate:$scope.startdate, enddate:$scope.enddate, empid:$scope.empid,leavetype:$scope.leavetype,shiftid:$scope.shiftid,departmentid:$scope.departmentid});
		
		$http({
			url: path+'leave/daterangereport2/'+$val,
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			if(data.status){
				$scope.show=true;
				$scope.from=data.startdate1;
				
				var fiscalview="";
					 fiscalview='['+data.startdate1+']';
				$('#fiscalview').text(fiscalview);
				var fiscalstartdate = data.fiscalstartdate;
				var fiscalenddate = data.fiscalenddate;
				if(fiscalstartdate != undefined && fiscalenddate != undefined)
				{
					fiscalview='['+data.fiscalstartdate+' - '+data.fiscalenddate+']';
					$('#fiscalview').text(fiscalview);
					$scope.from='';
				}
				$scope.leavereportarr=data.data;
				
				if($val==52)
				{
					$scope.leavereportarr=data.data;
				}
				if($val==54)
				{
					$scope.anonymousfeedbackreport=data.data;
				}
				if($val==62)
				{
					$scope.consolidateattndcearr=data.data;
				//	var fiscalview="";
					// fiscalview='['+data.startdate1+']';
				}
				if($val==64)
				{
					$scope.personalloan=data.data;
				//	var fiscalview="";
					// fiscalview='['+data.startdate1+']';
				}
				//if($val==1)
				//document.getElementById('example2').innerHTML=$scope.leavereportarr;
				//$scope.table.draw();
				//$timeout(function(){window.open(path+"leave/viewreport/"+reportid, '_self');}, timeo);
			}else{
				data.show=false;
				console.log('dgsg');
			}
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});

	}
	
	$scope.onfetchtable1=function($val){
		$( "#refresh_div" ).show();
		//alert($scope.from);
		if($scope.from != undefined  ){

			var temp= new Date($scope.from);
//			var temp= new Date(startdate);
		 	var gDay=temp.getDate();
			var gMonth=temp.getMonth()+1;
			var gYear=temp.getFullYear(); 
			$scope.from1=gYear+"-"+gMonth+"-"+gDay;
		}	
		if($scope.to != undefined  ){

			var temp= new Date($scope.to);
//			var temp= new Date(startdate);
		 	var gDay=temp.getDate();
			var gMonth=temp.getMonth()+1;
			var gYear=temp.getFullYear(); 
			$scope.to1=gYear+"-"+gMonth+"-"+gDay;
		}	
		$scope.hastrue=true;
		var xsrf = $.param({reportid:$scope.reportid, division:$scope.division,fromdate:$scope.from1, todate:$scope.to1});
	
		$http({
			url: path+'employee/divisionwisereport/'+$val,
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			if(data.status){
				var from=data.startdate;
				var to=data.enddate;
				var fiscalview='['+from+' - '+to+']';
				$('#fiscalview').text(fiscalview);
				$scope.leavereportarr=data.data;
				
			}else{
				errorMessage(data.errorMsg);
			}
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}
	$scope.onfetchsalarytable=function($val){
		
		var fromdate=$('#salarymonth').val(); 
		
		 if(fromdate != undefined  ){
			var temp= new Date(fromdate+", 1");
//			var temp= new Date(startdate);
		 	var gDay=temp.getDate();
			var gMonth=temp.getMonth()+1;
			var gYear=temp.getFullYear(); 
			$scope.from=gYear+"-"+gMonth+"-"+gDay;
			console.log($scope.from);
		}	
		if(fromdate == ""){$scope.from="";}
	
$scope.salarydetail=[];
	$( "#refresh_div" ).show();
	$scope.hastrue=true;
	var xsrf = $.param({reportid:$scope.reportid, division:$scope.division,department:$scope.department,costcentre:$scope.costcentre,fromdate:$scope.from, todate:$scope.to,empid:$scope.empid});
  $http({
        url: path+'salary/daterangereport/'+$val,
        method: "POST",
		data: xsrf,
        headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
      }).success(function (data, status, headers, config) {
			if(data.status){
			
				
				var from=data.salarymonth;
				var to=data.enddate;
				var fiscalview='['+from+']';
				$('#fiscalview').text(fiscalview);
				$scope.salarydetail=data.data;
				
				//$scope.salaryheads = data.data[0]['salarydetail'];
				//console.log($scope.salaryheads )
						
					var  table= $('#datatable').DataTable({
						scrollY:        "800px", 
						scrollX:        true, searching:false,
						scrollCollapse: true, ordering:false,
						paging:         false,
						"columnDefs": [
							{ "visible": false, "targets": 1 }
						],
						"drawCallback": function ( settings ) {
							var api = this.api();
							var rows = api.rows( {page:'current'} ).nodes();
							var last=null;
				 
							api.column(1, {page:'current'} ).data().each( function ( group, i ) {
								if ( last !== group ) {
									$(rows).eq( i ).before(
										'<tr class="group"><td class="bg-success text-bold" colspan="'+($scope.salaryheads.length+7)+'">'+group+'</td></tr>'
									);
									last = group;
								}
							} );
						}					
					});
				 

			}else{
				//errorMessage(data.errorMsg);
			}
			$( "#refresh_div" ).hide();
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
}
/////////////fetch data by date or division conditions ends here//////////////
$scope.onfetchperformancetable=function($val){

$( "#refresh_div" ).show();

if($scope.from != undefined  ){

			var temp= new Date($scope.from);
//			var temp= new Date(startdate);
		 	var gDay=temp.getDate();
			var gMonth=temp.getMonth()+1;
			var gYear=temp.getFullYear(); 
			$scope.from1=gYear+"-"+gMonth+"-"+gDay;
		}	
		if($scope.to != undefined  ){

			var temp= new Date($scope.to);
//			var temp= new Date(startdate);
		 	var gDay=temp.getDate();
			var gMonth=temp.getMonth()+1;
			var gYear=temp.getFullYear(); 
			$scope.to1=gYear+"-"+gMonth+"-"+gDay;
			
		}	
	$scope.hastrue=true;
	var xsrf = $.param({reportid:$scope.reportid, fromdate:$scope.from1, todate:$scope.to1,division:$scope.division,empid:$scope.empid});
	
  $http({
        url: path+'performance/daterangereport/'+$val,
        method: "POST",
		data: xsrf,
        headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
      }).success(function (data, status, headers, config) {
			if(data.status){
				//var reportid=data.reportid;
				var from=data.startdate;
				console.log(from);
				var to=data.enddate;
				var fiscalview='['+from+' - '+to+']';
				console.log(fiscalview);
				$('#fiscalview').text(fiscalview);
				$scope.leavereportarr=data.data;
				console.log($scope.leavereportarr);
				//$scope.table.draw();
				//$timeout(function(){window.open(path+"leave/viewreport/"+reportid, '_self');}, timeo);
			}else{
				errorMessage(data.errorMsg);
			}
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});

}
$scope.onfetchperformancetable1=function($val){

$( "#refresh_div" ).show();
	$scope.hastrue=true;
	var xsrf = $.param({reportid:$scope.reportid, fromdate:$scope.from,division:$scope.division});
  $http({
        url: path+'performance/daterangereport/'+$val,
        method: "POST",
		data: xsrf,
        headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
      }).success(function (data, status, headers, config) {
			if(data.status){
				//var reportid=data.reportid;
				var from=data.startdate;
				var to=data.enddate;
				var fiscalview='['+from+' - '+to+']';
				$('#fiscalview').text(fiscalview);
				$scope.leavereportarr1=data.data;
				
				//$scope.table.draw();
				//$timeout(function(){window.open(path+"leave/viewreport/"+reportid, '_self');}, timeo);
			}else{
				errorMessage(data.errorMsg);
			}
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});

}
$scope.oncreate = function($val)
{
	
	if($scope.reportype==1)
	{
		if($scope.totalcolumn == "")
		{
			errorMessage("Choose summary column");
			return;
		}
	}else{
		$scope.totalcolumn = "";
	}
	$scope.hastrue=true;

	if($scope.datecondition == 'between'){
		$scope.tempar.insert (0,{id:$scope.datefilterid, condition1:"AND", column:$scope.datefilter, condition2:$scope.datecondition, textvalue:$scope.fromdate+"'AND'"+$scope.todate });
	}else{
		//$scope.tempar.insert (0,{id:$scope.datefilterid, condition1:0, column:0, condition2:0, textvalue:0 });
	}

	var groupby ="";
	if($scope.groupby1 != "" && $scope.groupby1 != null && $scope.groupby2 == ""){
		groupby=$scope.groupby1+" "+$scope.orderby1+" "+$scope.orderbytype;
	}
	else if($scope.groupby1 == "" && $scope.groupby2 != "" && $scope.groupby2 != null){
	 
		groupby=$scope.groupby2+" "+$scope.orderby2+" "+$scope.orderbytype;
	}
	else if($scope.groupby1 != "" && $scope.groupby1 != null && $scope.groupby2 != ""  && $scope.groupby2 != null){
		groupby=$scope.groupby1+" "+$scope.orderby1+", "+$scope.groupby2+" "+$scope.orderby2+" "+$scope.orderbytype;
	}
	else{
		groupby="";
	}

	$scope.selectedcol=angular.toJson($scope.selectedcolumnsarr);
	var jsonData1=angular.toJson($scope.filterarr);
	var jsonData2=angular.toJson($scope.tempar);

var xsrf = $.param({reportname:$scope.reportname, modulename:$scope.modulename, selectcol:$scope.selectedcol,selectcrit:$scope.selectedcriteria, groupby:groupby,filter:jsonData1,reportype:$scope.reportype,totalcolumn:$scope.totalcolumn,datefilter: jsonData2,tabid:$scope.tabid,customsts:$scope.customsts});
  $http({
        url: path+'leave/createreport',
        method: "POST",
		data: xsrf,
        headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
      }).success(function (data, status, headers, config) {
			if(data.status){
				successMessage(data.successMsg);
				$scope.filterarr = [{id:0, condition1:"AND", column:"", condition2:"", textvalue:"" }];
				var reportid=data.reportid;
				if($val==11){
					$timeout(function(){window.open(path+"employee/report", "_self");}, timeo);
					$timeout(function(){window.open(path+"employee/viewreport/"+reportid, '');}, timeo);
					
				}
				if($val==22){
					$timeout(function(){window.open(path+"attendance/report", "_self");}, timeo);
					$timeout(function(){window.open(path+"attendance/viewreport/"+reportid, "");}, timeo);
					
				}
				if($val==33){
					$timeout(function(){window.open(path+"leave/report", "_self");}, timeo);
					$timeout(function(){window.open(path+"leave/viewreport/"+reportid, "");}, timeo);
					
				}
				if($val==44){
					$timeout(function(){window.open(path+"salary/report", "_self");}, timeo);
					$timeout(function(){window.open(path+"salary/viewreport/"+reportid, "");}, timeo);
					
				}
				if($val==55){
					$timeout(function(){window.open(path+"setup/report", "_self");}, timeo);
					$timeout(function(){window.open(path+"setup/viewreport/"+reportid, "");}, timeo);
					
				}
				if($val==66){
					$timeout(function(){window.open(path+"performance/report", "_self");}, timeo);
					$timeout(function(){window.open(path+"performance/viewreport/"+reportid, "");}, timeo);
					
				}
				if($val==77){
					$timeout(function(){window.open(path+"timesheet/report", "_self");}, timeo);
					$timeout(function(){window.open(path+"timesheet/viewreport/"+reportid, "");}, timeo);
					
				}
				
				if($val==1){
					//window.open(path+"leave/report", "_self");
					$timeout(function(){window.open(path+"employee/report", "_self");}, timeo);
				}
				else if($val==2){
					//window.open(path+"leave/report", "_self");
					$timeout(function(){window.open(path+"attendance/report", "_self");}, timeo);
				}
				else if($val==3){
					//window.open(path+"leave/report", "_self");
					$timeout(function(){window.open(path+"leave/report", "_self");}, timeo);
				}
				else if($val==4){
					//window.open(path+"leave/report", "_self");
					$timeout(function(){window.open(path+"salary/report", "_self");}, timeo);
				}
				else if($val==5){
					//window.open(path+"leave/report", "_self");
					$timeout(function(){window.open(path+"setup/report", "_self");}, timeo);
				}
				else if($val==6){
					//window.open(path+"leave/report", "_self");
					$timeout(function(){window.open(path+"performance/report", "_self");}, timeo);
				}
				else if($val==7){
					//window.open(path+"leave/report", "_self");
					$timeout(function(){window.open(path+"timesheet/report", "_self");}, timeo);
				}
			}else{
				errorMessage(data.errorMsg);
			}
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
}
$scope.onupdate = function($val)
{

if($scope.reportype==1)
{
	if($scope.totalcolumn == "")
	{
		errorMessage("Choose summary column");
		return;
	}
}else{
	$scope.totalcolumn = "";
}
$scope.hastrue=true;

	if($scope.datecondition == 'between'){
		$scope.tempar.insert (0,{id:$scope.datefilterid, condition1:"AND", column:$scope.datefilter, condition2:$scope.datecondition, textvalue:$scope.fromdate+"'AND'"+$scope.todate });
	}else{
		//$scope.tempar.insert (0,{id:$scope.datefilterid, condition1:0, column:0, condition2:0, textvalue:0 });
	}

var groupby ="";
if($scope.groupby1 != "" && $scope.groupby1 != null && $scope.groupby2 == ""){
 	groupby=$scope.groupby1+" "+$scope.orderby1+" "+$scope.orderbytype;
}
else if($scope.groupby1 == "" && $scope.groupby2 != "" && $scope.groupby2 != null){
 
	groupby=$scope.groupby2+" "+$scope.orderby2+" "+$scope.orderbytype;
}
else if($scope.groupby1 != "" && $scope.groupby1 != null && $scope.groupby2 != ""  && $scope.groupby2 != null){
 	groupby=$scope.groupby1+" "+$scope.orderby1+", "+$scope.groupby2+" "+$scope.orderby2+" "+$scope.orderbytype;
}
else{
	groupby="";
}

$scope.selectedcol=angular.toJson($scope.selectedcolumnsarr);
var jsonData1=angular.toJson($scope.filterarr);
var jsonData2=angular.toJson($scope.tempar);

var xsrf = $.param({reportid: $scope.reportid,reportname: $scope.reportname, modulename:$scope.modulename, selectcol:$scope.selectedcol,selectcrit:$scope.selectedcriteria, groupby:groupby,filter:jsonData1,reportype:$scope.reportype,totalcolumn:$scope.totalcolumn,datefilter: jsonData2, tabid:$scope.tabid,customsts:$scope.customsts});
  $http({
        url: path+'leave/updatedreport',
        method: "POST",
		data: xsrf,
        headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
      }).success(function (data, status, headers, config) {
		
			if(data.status){
				successMessage(data.successMsg);
				var reportid=data.reportid;
				
				if($val==11){
					
					$timeout(function(){window.open(path+"employee/viewreport/"+reportid, '_blank');}, timeo);
					$timeout(function(){window.open(path+"employee/editreport/"+reportid, '_self');}, timeo);
					
				}
				if($val==22){
					$timeout(function(){window.open(path+"attendance/viewreport/"+reportid, '_blank');}, timeo);
					$timeout(function(){window.open(path+"attendance/editreport/"+reportid, '_self');}, timeo);
				}
				if($val==33){
					$timeout(function(){window.open(path+"leave/viewreport/"+reportid, '_blank');}, timeo);
					$timeout(function(){window.open(path+"leave/editreport/"+reportid, '_self');}, timeo);
				}
				if($val==44){
					$timeout(function(){window.open(path+"salary/viewreport/"+reportid, '_blank');}, timeo);
					$timeout(function(){window.open(path+"salary/editreport/"+reportid, '_self');}, timeo);
				}
				if($val==55){
					$timeout(function(){window.open(path+"setup/viewreport/"+reportid, '_blank');}, timeo);
					$timeout(function(){window.open(path+"setup/editreport/"+reportid, '_self');}, timeo);
				}
				if($val==66){
					$timeout(function(){window.open(path+"performance/viewreport/"+reportid, '_blank');}, timeo);
					$timeout(function(){window.open(path+"performance/editreport/"+reportid, '_self');}, timeo);
				}
				if($val==77){
					$timeout(function(){window.open(path+"timesheet/viewreport/"+reportid, '_blank');}, timeo);
					$timeout(function(){window.open(path+"timesheet/editreport/"+reportid, '_self');}, timeo);
				}
				
				if($val==1){
					//window.open(path+"leave/report", "_self");
					$timeout(function(){window.open(path+"employee/report", "_self");}, timeo);
				}
				else if($val==2){
					//window.open(path+"leave/report", "_self");
					$timeout(function(){window.open(path+"attendance/report", "_self");}, timeo);
				}
				else if($val==3){
					//window.open(path+"leave/report", "_self");
					$timeout(function(){window.open(path+"leave/report", "_self");}, timeo);
				}
				else if($val==4){
					//window.open(path+"leave/report", "_self");
					$timeout(function(){window.open(path+"salary/report", "_self");}, timeo);
				}
				else if($val==5){
					//window.open(path+"leave/report", "_self");
					$timeout(function(){window.open(path+"setup/report", "_self");}, timeo);
				}
				else if($val==6){
					//window.open(path+"leave/report", "_self");
					$timeout(function(){window.open(path+"performance/report", "_self");}, timeo);
				}
				else if($val==7){
					//window.open(path+"leave/report", "_self");
					$timeout(function(){window.open(path+"timesheet/report", "_self");}, timeo);
				}
			}else{
				errorMessage(data.errorMsg);
			}
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
}
//////////////////This is for custom reports/////////////
$scope.fetchclientwisereport =function($id)
{	
	$scope.hastrue=true;
	var xsrf = $.param({reportid: $id});
	$http({
        url: path+'leave/getclientwisetreport',
        method: "POST",
		data: xsrf,
        headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
      }).success(function (data, status, headers, config) {
			if(data.status){
				//alert(data[0].client);
				$scope.todaydate=data.date;
				$scope.customsts=data.data[0]['customsts'];
				$scope.leavereportarr=data.leavecustomreport1;
				
				console.log($scope.timesheetarr);
				if($scope.leavereportarr!=undefined){
				document.getElementById('output').innerHTML=$scope.leavereportarr;}else{
				$scope.leavereportarr=data.timesheetreport;
				}
				
				$scope.fiscalview=data.fiscalview;
				$scope.todaydate=data.today;
				console.log(data.currentmonth);
				$scope.currentmonth=data.startdate;
				var reportname=data.data[0]['name'].charAt(0).toUpperCase() + data.data[0]['name'].slice(1);
				
				var org=data.orgdetails[0]['org']+"<br>"+data.orgdetails[0]['email']+"<br>"+data.orgdetails[0]['phone']+"<br>"+data.orgdetails[0]['city']+"<br>"+data.orgdetails[0]['country'];
				var img ="<img src='"+data.orgdetails[0]['image']+"' id='img1'  />";
					
				$('#todaytask').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <span id='fiscalview'><p><b>"+$scope.todaydate+"</b></p></span></div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
				
				$('#monthly').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <p><b><span id='currentmonth'><b>"+$scope.currentmonth+"</b></span></b></p></div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
				
				$('#projectall').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3><span id='fiscalvieww'><p><b>"+$scope.currentmonth+"</b></p></span> </div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
				$('#header').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <span id='fiscalview'><p>"+$scope.fiscalview+"</p></span></div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
				
				$('#example1 caption').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <span id='fiscalview'><p>["+$scope.fiscalview+"]</p></span></div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
				 
				
			}
						
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
			
		});
}
$scope.onfetchleavereport =function($id)
{
	$scope.hastrue=true;
	var xsrf = $.param({reportid: $id});
	$http({
        url: path+'leave/getareport',
        method: "POST",
		data: xsrf,
        headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
      }).success(function (data, status, headers, config) {
			if(data.status){
				$scope.todaydate=data.date;
				$scope.customsts=data.data[0]['customsts'];
				$scope.leavereportarr=data.leavecustomreport1;
				$scope.from=data.fiscalstartdate1;
				$scope.to=data.fiscalenddate1;
				
				if($scope.leavereportarr!=undefined){
			//	document.getElementById('output').innerHTML=$scope.leavereportarr;
				}else{
				$scope.leavereportarr=data.timesheetreport;
				console.log(data.startdate);
				$scope.startdate1=data.startdate;	
				$scope.enddate1=data.enddate;					
				$scope.startdate=data.startdate1;	
				$scope.enddate=data.enddate1;	
				$scope.currentmonthtimesheet=$scope.startdate1;
				}
				
				$scope.fiscalview=data.fiscalview;
				$scope.todaydate=data.today;
				
				$scope.currentmonth=data.startdate;
			//	console.log(data.currentmonth);
				var reportname=data.data[0]['name'].charAt(0).toUpperCase() + data.data[0]['name'].slice(1);
				
				var org=data.orgdetails[0]['org']+"<br>"+data.orgdetails[0]['email']+"<br>"+data.orgdetails[0]['phone']+"<br>"+data.orgdetails[0]['city']+"<br>"+data.orgdetails[0]['country'];
				var img ="<img src='"+data.orgdetails[0]['image']+"' id='img1'  />";
					
				$('#todaytask').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <span id='fiscalview'><p><b>"+$scope.todaydate+"</b></p></span></div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
				
				$('#monthly').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <p><b><span id='currentmonth'><b>"+$scope.currentmonth+"</b></span></b></p></div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
				
				$('#monthlytimesheet').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <p><b><span id='fiscalview'><b>"+$scope.currentmonthtimesheet+"</b></span></b></p></div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
				
				$('#projectall').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3><span id='fiscalvieww'><p><b>"+$scope.currentmonth+"</b></p></span> </div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
				
				$('#header').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <span id='fiscalview'><p>"+$scope.fiscalview+"</p></span></div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
				
				$('#example1 caption').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <span id='fiscalview'><p>["+$scope.fiscalview+"]</p></span></div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
			/* 	var start = moment($scope.startdate);
						var end = moment($scope.enddate);
						function cb(start, end)  {
						$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
						}
						$('#reportrange').daterangepicker({
						startDate: start,
						endDate: end,
						ranges: {
						'Today': [moment(), moment()],
						'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
						'Last 7 Days': [moment().subtract(6, 'days'), moment()],
						'Last 30 Days': [moment().subtract(29, 'days'), moment()],
						'This Month': [moment().startOf('month'), moment().endOf('month')],
						'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
						}
						},cb);
						cb(start, end);
							 $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
							$('#startdate').val(picker.startDate.format('YYYY-MM-DD'));
							 $('#enddate').val(picker.endDate.format('YYYY-MM-DD'));
							 //alert($scope.startdate+" "+$scope.enddate);
						});
						$('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
						//$scope.startdate="2018-02-02";
						//$scope.enddate="2018-02-09";
						});		 */ 
				
			}
						
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
			
		});
}
/////////////////////////////////////////fetch report for schedule mail/////////////////////////////////////
$scope.onfetchleavereportschedule =function($id)
{
	$scope.hastrue=true;
	var xsrf = $.param({reportid: $id});
	$http({
        url: path+'report/getareport',
        method: "POST",
		data: xsrf,
        headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
      }).success(function (data, status, headers, config) {
			if(data.status){
				$scope.todaydate=data.date;
				$scope.customsts=data.data[0]['customsts'];
				$scope.leavereportarr=data.leavecustomreport1;
				
				//console.log($scope.timesheetarr);
				if($scope.leavereportarr!=undefined){
				document.getElementById('output').innerHTML=$scope.leavereportarr;}else{
				$scope.leavereportarr=data.timesheetreport;
				}
				
				$scope.fiscalview=data.fiscalview;
				$scope.todaydate=data.today;
				//console.log(data.currentmonth);
				$scope.currentmonth=data.startdate;
				var reportname=data.data[0]['name'].charAt(0).toUpperCase() + data.data[0]['name'].slice(1);
				
				var org=data.orgdetails[0]['org']+"<br>"+data.orgdetails[0]['email']+"<br>"+data.orgdetails[0]['phone']+"<br>"+data.orgdetails[0]['city']+"<br>"+data.orgdetails[0]['country'];
				var img ="<img src='"+data.orgdetails[0]['image']+"' id='img1'  />";
					
				$('#todaytask').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <span id='fiscalview'><p><b>"+$scope.todaydate+"</b></p></span></div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
				$('#monthly').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <p><b>"+$scope.currentmonth+"</b></p></span></div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
				$('#projectall').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3><span id='fiscalvieww'><p><b>"+$scope.currentmonth+"</b></p></span> </div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
				$('#header').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <span id='fiscalview'><p>"+$scope.fiscalview+"</p></span></div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
				
				$('#example1 caption').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <span id='fiscalview'><p>["+$scope.fiscalview+"]</p></span></div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
				 
				
			}
						
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
			
		});
}
/////////////////////////////////////////End fetch report for schedule mail/////////////////////////////////////
$scope.onfetchleavereport1 =function($id)
{
	$scope.hastrue=true;
	var xsrf = $.param({reportid: $id});
	$http({
        url: path+'leave/getareport',
        method: "POST",
		data: xsrf,
        headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
      }).success(function (data, status, headers, config) {
			if(data.status){
				$scope.todaydate=data.date;
				$scope.customsts=data.data[0]['customsts'];
				$scope.fiscalview="["+data.fiscalview+"]";
				if($scope.customsts==2){
					$scope.leavereportarr=data.leavecustomreport2;
				}else if($scope.customsts==10){
					$scope.leavereportarr=data.leavecustomreport3;
					
				}else if($scope.customsts==11 || $scope.customsts==12){
					$scope.leavereportarr=data.leavecustomreport4;
					//$scope.fiscalview="";
				}else if($scope.customsts==13 || $scope.customsts==15){
					$scope.leavereportarr=data.empassessment;
					if($scope.customsts==15)	
					$scope.fiscalview="["+$scope.leavereportarr[0].fromdate+" - "+$scope.leavereportarr[0].todate+"]";
					//$scope.fiscalview="";
				}else if($scope.customsts==44){
					$scope.leavereportarr=data.skillgapreport;
					$scope.skillarr=data.skillgapreport.skills[0];
					$scope.emparr=data.skillgapreport.emp;
				}else if($scope.customsts==60 ){
					$scope.leavereportarr=data.employeeassessmentreport;
					if($scope.leavereportarr.length!=0)	{
					$scope.fiscalview="["+$scope.leavereportarr[0].fromdate+" - "+$scope.leavereportarr[0].todate+"]";
					}
				}else if($scope.customsts==61 ){
					$scope.leavereportarr=data.employeeassessmentreport_ALL;
					if($scope.leavereportarr.length!=0)	{
					$scope.fiscalview="["+$scope.leavereportarr[0].fromdate+" - "+$scope.leavereportarr[0].todate+"]";
					}
					//$scope.fiscalview="";
				}
				$scope.from=data.fiscalstartdate1;
				$scope.to=data.fiscalenddate1;
				//console.log($scope.from);
				//document.getElementById('output').innerHTML=$scope.leavereportarr;
				var reportname=data.data[0]['name'].charAt(0).toUpperCase() + data.data[0]['name'].slice(1);
				
				var org=data.orgdetails[0]['org']+"<br>"+data.orgdetails[0]['email']+"<br>"+data.orgdetails[0]['phone']+"<br>"+data.orgdetails[0]['city']+"<br>"+data.orgdetails[0]['country'];
				var img ="<img src='"+data.orgdetails[0]['image']+"' id='img1'  />";
					
					
				
				$('#header').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <span id='fiscalview'><p>"+$scope.fiscalview+"</p></span></div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
				$('#datelessheader').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3></div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
				
				 $('#example1 caption').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><h3>"+reportname+"</h3><span id='fiscalview'><p>"+$scope.fiscalview+"</p></span></div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
				 $('#example2 caption').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><h3>"+reportname+"</h3><span id='fiscalview'><p>"+$scope.fiscalview+"</p></span></div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
				
			}
						
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
			
		});
}
/////////////fetch data by date or division conditions ends here//////////////
$scope.onfetchempskillstable=function($val){

$scope.from=$('#from').val();
$scope.to=$('#to').val();
$( "#refresh_div" ).show();
	$scope.hastrue=true;
	var xsrf = $.param({reportid:$scope.reportid, fromdate:$scope.from, todate:$scope.to,division:$scope.division,department:$scope.department,employee:$scope.employee});
  $http({
        url: path+'performance/daterangereport/'+$val,
        method: "POST",
		data: xsrf,
        headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
      }).success(function (data, status, headers, config) {
			if(data.status){
				//var reportid=data.reportid;
				var from=data.startdate;
				var to=data.enddate;
				var fiscalview='['+from+' - '+to+']';
				$('#fiscalview').text(fiscalview);
				$scope.leavereportarr=data.data;
				$scope.emparr=data.data['emp'];
				$scope.skillarr=data.data['skills'][0];
				//$scope.table.draw();
				//$timeout(function(){window.open(path+"leave/viewreport/"+reportid, '_self');}, timeo);
			}else{
				errorMessage(data.errorMsg);
			}
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});

}
$scope.onfetchlatehrs =function($id)
{
	$scope.hastrue=true;
	var xsrf = $.param({reportid: $id,startdate: $scope.startdate,enddate: $scope.enddate});
	$http({
        url: path+'leave/getareport',
        method: "POST",
		data: xsrf,
        headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
      }).success(function (data, status, headers, config) {
			if(data.status){
				$scope.todaydate=data.date;
				$scope.customsts=data.data[0]['customsts'];
				$scope.leavereportarr=data.attendancereport1;	
				$scope.startdate1=data.attendancereport1.startdate;	
				$scope.enddate1=data.attendancereport1.enddate;					
				$scope.startdate=data.attendancereport1.startdate1;	
				$scope.enddate=data.attendancereport1.enddate1;	
				$scope.fiscalview=data.fiscalview;
				$scope.currentmonth=$scope.startdate1+" - "+$scope.enddate1;
				//document.getElementById('output').innerHTML=$scope.leavereportarr;
				var reportname=data.data[0]['name'].charAt(0).toUpperCase() + data.data[0]['name'].slice(1);				
				var org=data.orgdetails[0]['org']+"<br>"+data.orgdetails[0]['email']+"<br>"+data.orgdetails[0]['phone']+"<br>"+data.orgdetails[0]['city']+"<br>"+data.orgdetails[0]['country'];
				var img ="<img src='"+data.orgdetails[0]['image']+"' id='img1'  />";
				$('#monthly').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <span id='fiscalview'><p><b>"+$scope.currentmonth+"</b></span></p></span></div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 	
				$('#header').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <span id='fiscalview'><p>"+$scope.fiscalview+"</p></span></div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
				$('#example1 caption').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <span id='fiscalview'><p>["+$scope.fiscalview+"]</p></span></div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 	
				
						if(data.attendancereport1.status){
							$scope.show=true;
						}else{
							$scope.show=false;
						}
						var start = moment($scope.startdate);
						var end = moment($scope.enddate);
						function cb(start, end)  {
						$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
						}
						$('#reportrange').daterangepicker({
						startDate: start,
						endDate: end,
						ranges: {
						'Today': [moment(), moment()],
						'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
						'Last 7 Days': [moment().subtract(6, 'days'), moment()],
						'Last 30 Days': [moment().subtract(29, 'days'), moment()],
						'This Month': [moment().startOf('month'), moment().endOf('month')],
						'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
						}
						},cb);
						cb(start, end);
							 $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
							 $scope.startdate=picker.startDate.format('YYYY-MM-DD');
							 $scope.enddate=picker.endDate.format('YYYY-MM-DD');
							 //alert($scope.startdate+" "+$scope.enddate);
						});
						$('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
						//$scope.startdate="2018-02-02";
						//$scope.enddate="2018-02-09";
						});		
						
			}
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;			
		});
}
$scope.onfetchattendancereport =function($id)
{
	
	$scope.hastrue=true;
	var xsrf = $.param({reportid: $id});
	$http({
        url: path+'leave/getareport',
        method: "POST",
		data: xsrf,
        headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
      }).success(function (data, status, headers, config) {
			if(data.status){
				$scope.todaydate=data.date;
				$scope.startdate1=data.startdate1;
				$scope.customsts=data.data[0]['customsts'];
				$scope.leavereportarr=data.attendancereport1;				
				$scope.attendaneyesarr=data.attendanceyesterdayreport;
				$scope.attendaneflexiarr=data.attendanceflexishiftreport;
				console.log($scope.attendaneflexiarr);
				$scope.consolidateattndcearr=data.ConsolidatedAttendancereport;
				$timeout(function(){var table1 = $('#example1').DataTable({
				scrollY:        "500px", 
				scrollX:        true, searching:false,
				scrollCollapse: true, ordering:false,
				paging:         false
		});}, timeo);
				
		
				
				$scope.fiscalview=data.fiscalview;
				$scope.currentmonth=data.startdate;
				$scope.from=data.startdate;
				var fromdate=$( '#desig' ).datepicker( "setDate" ,data.startdate );
			
			//	console.log($scope.currentmonth);
				//document.getElementById('output').innerHTML=$scope.leavereportarr;
				var reportname=data.data[0]['name'].charAt(0).toUpperCase() + data.data[0]['name'].slice(1);				
				var org=data.orgdetails[0]['org']+"<br>"+data.orgdetails[0]['email']+"<br>"+data.orgdetails[0]['phone']+"<br>"+data.orgdetails[0]['city']+"<br>"+data.orgdetails[0]['country'];
				var img ="<img src='"+data.orgdetails[0]['image']+"' id='img1'  />";
			
				$('#monthly').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <span id='fiscalview'><p><b>"+$scope.currentmonth+"</b></span></p></span></div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 	
		//console.log("sddf");
				$('#header').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <span id='fiscalview'><p>"+$scope.fiscalview+"</p></span></div><div class='col-xs-4' id='org' style='text-align:right;'>"+org+"</div></div>"); 
				$('#header1').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <span id='fiscalview'><p>"+$scope.startdate1+"</p></span></div><div class='col-xs-4' id='org' style='text-align:right;'>"+org+"</div></div>"); 
				$('#example1 caption').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <span id='fiscalview'><p>["+$scope.currentmonth+"]</p></span></div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 				
			}						
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;			
		});
}
//// this function getting a monthly  attendance summary "sohan"
  $scope.fetchtabledata = function($id)
   {
	    $scope.hastrue=true;
		var xsrf = $.param({reportid: $id});
		$http({
			url: path+'leave/getareport',
			method: "POST",
			data:xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			 
			
			$scope.dates = data.attsummary.date;
			var obj = data.attsummary.data;
			$scope.arrdate = obj;
			$scope.records = obj;
			
			$scope.from=data.startdate;
			
			$scope.fiscalview=data.startdate;
			 
			var reportname=data.data[0]['name'].charAt(0).toUpperCase() + data.data[0]['name'].slice(1);
			
			var org=data.orgdetails[0]['org']+"<br>"+data.orgdetails[0]['email']+"<br>"+data.orgdetails[0]['phone']+"<br>"+data.orgdetails[0]['city']+"<br>"+data.orgdetails[0]['country'];
			var img ="<img src='"+data.orgdetails[0]['image']+"' id='img1' />";
			 
			$('#monthly').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <span id='fiscalview'><p>["+$scope.fiscalview+"]</p></span></div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
			$scope.hastrue=false 
		}).error(function (data, status, headers, config) {
			$scope.hastrue=false;
		});
		
 } 
 
 //// this function getting a monthly  personal loan installment
  $scope.onfetchpersonalloandata = function($id)
   {
	    $scope.hastrue=true;
		var xsrf = $.param({reportid: $id});
		$http({
			url: path+'leave/getareport',
			method: "POST",
			data:xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			 
			
			/* $scope.dates = data.attsummary.date;
			var obj = data.attsummary.data;
			$scope.arrdate = obj;
			$scope.records = obj;
			 */
			
			$scope.personalloan=data.personalloan;

			$scope.from=data.startdate;
			
			$scope.fiscalview=data.startdate;
			 
			var reportname=data.data[0]['name'].charAt(0).toUpperCase() + data.data[0]['name'].slice(1);
				
			var org=data.orgdetails[0]['org']+"<br>"+data.orgdetails[0]['email']+"<br>"+data.orgdetails[0]['phone']+"<br>"+data.orgdetails[0]['city']+"<br>"+data.orgdetails[0]['country'];
			var img ="<img src='"+data.orgdetails[0]['image']+"' id='img1' />";
			 
			$('#monthly').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <span id='fiscalview'><p>["+$scope.fiscalview+"]</p></span></div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
			$scope.hastrue=false 
		}).error(function (data, status, headers, config) {
			$scope.hastrue=false;
		});
		
 }


///////////////this custom report is for getting data of transferred or promoted employee///////////
$scope.division=0;
$scope.employee=0;
$scope.department=0;
$scope.costcentre=0;
$scope.projectarray=[];
$scope.onfetchjobmodifyreport =function($id)
{
	
	$scope.hastrue=true;
	var xsrf = $.param({reportid: $id});
	$http({
        url: path+'leave/getareport',
        method: "POST",
		data: xsrf,
        headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
      }).success(function (data, status, headers, config) {
			if(data.status){
				$scope.todaydate=data.date;
				$scope.from=data.fiscalstartdate1;
				console.log($scope.from);
				$scope.to=data.fiscalenddate1;
				$scope.customsts=data.data[0]['customsts'];
				$scope.leavereportarr=data.jobmodificationreport;
				console.log($scope.leavereportarr);
				if($scope.leavereportarr.length==0)
				{
					errorMessage('No record found');
				}
				$scope.fiscalview=data.fiscalview;
				//document.getElementById('output').innerHTML=$scope.leavereportarr;
				var reportname=data.data[0]['name'].charAt(0).toUpperCase() + data.data[0]['name'].slice(1);
				
				var org=data.orgdetails[0]['org']+"<br>"+data.orgdetails[0]['email']+"<br>"+data.orgdetails[0]['phone']+"<br>"+data.orgdetails[0]['city']+"<br>"+data.orgdetails[0]['country'];
				var img ="<img src='"+data.orgdetails[0]['image']+"' id='img1' />";
					
				
				$('#example1 caption').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <span id='fiscalview'><p>["+$scope.fiscalview+"]</p></span></div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
				if($scope.customsts == 52){
					$('#header').html("<div class='row'><div class='col-xs-3'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-5' style='text-align:center' ><p><h3>"+reportname+"</p></h3> </div><div class='col-xs-4' id='org' style='text-align:right;padding-right:20px'>"+org+"</div></div>"); 
				}
				  
			}
						
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
			
		});
}
 function onfetch($val, $id)
	{
		$http({
			url: path+$val,
			method: "POST",
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {
				
				if(data.status){
					if($id==1){
						$scope.divisionarray=[];
						$scope.divisionarray=data.data;
						//$scope.divisionarray.insert(0,{id:0,name:"------All Locations-------"});
                     }
					else if($id==2){
						$scope.designationarray=[];
						$scope.designationarray=data.data;
						$scope.designationarray.insert(0,{id:0,name:"---All Designations---"});
						}
					else if($id==3){
						$scope.mails=data.senioremail;
						}
					else if($id==4){
						$scope.departmentarray=[];
						$scope.departmentarray=data.data;
						$scope.departmentarray.insert(0,{id:0,name:"---All Departments---"});
						}	
					else if($id==5){
						$scope.costcentrearray=[];
						$scope.costcentrearray=data.data;
						$scope.costcentrearray.insert(0,{id:0,name:"------All Channels-------"});
						}else if($id==6){
						$scope.clientarray=[];
						$scope.clientarray=data.data;
						$timeout(function() {
							$('.selectpicker').selectpicker('refresh');}, 1000);
						//$scope.clientarray.insert(0,{id:0,name:"------All Client-------"});
						}
						else if($id==7){
							$scope.projectarray=[];
							$scope.projectarray=data.data;
							$timeout(function() {
								$('.selectpicker').selectpicker('refresh');}, 1000);
						//$scope.projectarray.insert(0,{id:0,name:"------All Project-------"});
						}else if($id==8){
						$scope.otherarray=[];
						$scope.otherarray=data.data;
						$scope.projectstatus=$scope.otherarray[0]['id'];
				}else if($id==9){
						$scope.employeearr=[];
						$scope.employeearr=data.data;
						$scope.employeearr.insert(0,{id:0,name:"---All Employees---"});
				}else if($id==10){
					$scope.employeearray=[];
					$scope.employeearray=data.data;
					$timeout(function() {
					$('.selectpicker').selectpicker('refresh');                      
				}, 1000);
				}else if($id==11){
					$scope.employeearray1=[];
					$scope.employeearray1=data.data;
					$timeout(function() {
					$('.selectpicker').selectpicker('refresh');                      
				}, 1000);
				}else if($id==12){
						$scope.leavetypearr=[];
						$scope.leavetypearr=data.data;
						$timeout(function() {
							$('.selectpicker').selectpicker('refresh_div');                      
						}, 1000);
						
					//	$scope.leavetypearr.insert(0,{id:0,name:"---Select Leave Type---"});
				}
				else if($id==13){
					$scope.shiftarray=[];
					$scope.shiftarray=data.data;
					
				}		
				}
				
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
	}
	
	$scope.createpdf=function($val)
	  {
	  console.log($val)
		var pdf = new jsPDF('p', 'pt', 'a3');
		var options = {
				 pagesplit: true,
				 background:'#fff'
			};
		var element="#example1";
		if($val==13)
			element="#example2";
		pdf.addHTML($(element), options, function()
		{
			pdf.save("empassessment.pdf");
		});
	  }
	
$scope.onfetchsalaryreport =function($id)
{
	$scope.hastrue=true;
	var xsrf = $.param({reportid: $id});
	$http({
        url: path+'leave/getareport',
        method: "POST",
		data: xsrf,
        headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
      }).success(function (data, status, headers, config) {
			if(data.status){
				$scope.todaydate=data.date;
				$scope.customsts=data.data[0]['customsts'];
				
				if($scope.customsts==16){
					$scope.salarydetail=data.empgratuity;
					$scope.salarymonth = data.empgratuity[0]['empmonthdate'];
				}
				else if($scope.customsts==30 || $scope.customsts==31 || $scope.customsts==33 || $scope.customsts==37 ){
					$scope.salarydetail=data.wpsreport;
					
					$scope.salarymonth = data.wpsreport[0]['empmonthname'];
				}
				else{
					$scope.salarydetail=data.salarydistribution;
					$scope.salaryheads = data.salarydistribution[0]['salarydetail'];
					$scope.salarymonth = data.salarydistribution[0]['empmonthname'];
				}	
				var reportname=data.data[0]['name'].charAt(0).toUpperCase() + data.data[0]['name'].slice(1);
				$scope.reportname=data.data[0]['name'].charAt(0).toUpperCase() + data.data[0]['name'].slice(1);
				
				var org=data.orgdetails[0]['org']+"<br>"+data.orgdetails[0]['email']+"<br>"+data.orgdetails[0]['phone']+"<br>"+data.orgdetails[0]['city']+"<br>"+data.orgdetails[0]['country'];
				var img ="<img src='"+data.orgdetails[0]['image']+"' id='img1'  />";
					
				$scope.companylogo=data.orgdetails[0]['image'];
				$scope.org=data.orgdetails[0]['org'];
				$scope.email=data.orgdetails[0]['email'];
				$scope.phone=data.orgdetails[0]['phone'];
				$scope.country=data.orgdetails[0]['country'];
				$scope.city=data.orgdetails[0]['city'];
				$('#datatable caption').html("<div class='row'><div class='col-xs-4'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-4' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <span id='fiscalview'><p>["+$scope.salarymonth+"]</p></span> </div><div class='col-xs-3' id='org' style='text-align:right;padding-right:10px'>"+org+"</div></div>"); 
				$('#datatable1 caption').html("<div class='row'><div class='col-xs-4'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-4' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <span id='fiscalview'><p>["+$scope.salarymonth+"]</p></span> </div><div class='col-xs-3' id='org' style='text-align:right;padding-right:10px'>"+org+"</div></div>"); 
				
				$timeout(function(){
				if($scope.customsts==9){				
					$scope.table = $('#datatable').DataTable({
						scrollY:        "500px", 
						scrollX:        true, searching:false,
						scrollCollapse: true, ordering:false,
						paging:         false,
						
						"columnDefs": [
							{ "visible": false, "targets": 2 }
						],
						"drawCallback": function ( settings ) {
							var api = this.api();
							var rows = api.rows( {page:'current'} ).nodes();
							var last=null;
				 
							api.column(2, {page:'current'} ).data().each( function ( group, i ) {
								if ( last !== group ) {
									$(rows).eq( i ).before(
										'<tr class="group"><td  colspan="'+($scope.salaryheads.length+7)+'" bgcolor="#99ffbb"><b>'+group+'</b></td></tr>'
									);
									last = group;
								}
							} );
						}					
					});
					}else{
					$scope.table = $('#datatable').DataTable({
						scrollY:        false, 
						scrollX:        false, searching:false,
						scrollCollapse: false, ordering:false,
						paging:         false,
						
						"columnDefs": [
							{ "visible": false, "targets": 2 }
						],
						"drawCallback": function ( settings ) {
							var api = this.api();
							var rows = api.rows( {page:'current'} ).nodes();
							var last=null;
							var collength=api.columns().header().length;
							api.column(2, {page:'current'} ).data().each( function ( group, i ) {
								if ( last !== group ) {
									$(rows).eq( i ).before(
										'<tr class="group"><td  colspan="'+collength+'" bgcolor="#99ffbb"><b>'+group+'</b></td></tr>'
									);
									last = group;
								}
							} );
						}					
					});
					
					
					
					}
				},3000);		 
				
			}
						
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
			
		});
	
	  
}

$scope.onfetchfundreport =function($id)
{
	$scope.hastrue=true;
	var xsrf = $.param({reportid: $id});
	$http({
        url: path+'leave/getareport',
        method: "POST",
		data: xsrf,
        headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
      }).success(function (data, status, headers, config) {
			if(data.status){
				$scope.todaydate=data.date;
				$scope.customsts=data.data[0]['customsts'];
				
				 if($scope.customsts==34 || $scope.customsts==35 || $scope.customsts==36 ){
					$scope.salarydetail=data.fundreport;
					
					$scope.salarymonth = data.fundreport[0]['empmonthname'];
				}
				
				var reportname=data.data[0]['name'].charAt(0).toUpperCase() + data.data[0]['name'].slice(1);
				$scope.reportname=data.data[0]['name'].charAt(0).toUpperCase() + data.data[0]['name'].slice(1);
				
				var org=data.orgdetails[0]['org']+"<br>"+data.orgdetails[0]['email']+"<br>"+data.orgdetails[0]['phone']+"<br>"+data.orgdetails[0]['city']+"<br>"+data.orgdetails[0]['country'];
				var img ="<img src='"+data.orgdetails[0]['image']+"' id='img1'  />";
					
				$scope.companylogo=data.orgdetails[0]['image'];
				$scope.org=data.orgdetails[0]['org'];
				$scope.email=data.orgdetails[0]['email'];
				$scope.phone=data.orgdetails[0]['phone'];
				$scope.country=data.orgdetails[0]['country'];
				$scope.city=data.orgdetails[0]['city'];
				$('#datatable1 caption').html("<div class='row'><div class='col-xs-4'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-4' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <span id='fiscalview'><p>["+$scope.salarymonth+"]</p></span> </div><div class='col-xs-3' id='org' style='text-align:right;padding-right:10px'>"+org+"</div></div>"); 
				$('#datatable1 caption').html("<div class='row'><div class='col-xs-4'><div class='img-holder' style='border: 1px solid white;'>"+img+"</div></div><div class='col-xs-4' style='text-align:center' ><p><h3>"+reportname+"</p></h3> <span id='fiscalview'><p>["+$scope.salarymonth+"]</p></span> </div><div class='col-xs-3' id='org' style='text-align:right;padding-right:10px'>"+org+"</div></div>"); 
				
			}
						
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
			
		});
	
	  
}


	var form = $('.form'),
	cache_width = form.width(),
	a3  =[ 841.89, 1190.55];  // for a4 size paper width and height
	
	$scope.send_pdf=function($name)
	{
		$scope.hastrue=true;
		getCanvas().then(function(canvas){
			var
			img = canvas.toDataURL("image/png");
			var doc="";
			if(canvas.width > canvas.height){
			doc = new jsPDF('l', 'mm', [canvas.width, canvas.height],true);
			}else{
			doc = new jsPDF('p', 'mm', [canvas.width, canvas.height],true);
			}
			var width = doc.internal.pageSize.width;    
			var height = doc.internal.pageSize.height;
			doc.addImage(img, 'PNG', 10, 10, width-10,height-10,'','FAST');
			//window.open(img);
			/* console.log(doc.output('datauri')); */
			var pdfencoded=doc.output('blob');
			//alert($scope.mails);
			var mails=$scope.mails;
			//alert(pdfencoded);
			var fd = new FormData();     // To carry on your data  
			fd.append('mypdf',pdfencoded);
			fd.append('mail',mails);
			$http({
				url: path+'report/showpdf/'+$name,
				method: "POST",
				data: fd,
				 headers: { 'Content-Type': undefined }
			}).success(function (data, status, headers, config) {
				//errorMessage( $scope.leavevalidsts);
				if(data.status){
					successMessage(data.successMsg);
				   $scope.hastrue=false;				
				}else{
					errorMessage(data.errorMsg);
					$scope.hastrue=false;
				}
				
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
		   // doc.save('Employee_dashboard.pdf');
			form.width(cache_width);
		});
		//$scope.hastrue=false;
	}
	
		$scope.save_pdf=function($name){
		form.width(cache_width);
		getCanvas().then(function(canvas){			
		var
		img = canvas.toDataURL("image/png");
		var doc="";
		if(canvas.width > canvas.height){
		doc = new jsPDF('l', 'mm', [canvas.width, canvas.height],true);
		}else{
		doc = new jsPDF('p', 'mm', [canvas.width, canvas.height],true);
		}
		var width = doc.internal.pageSize.width;    
		var height = doc.internal.pageSize.height;
        doc.addImage(img, 'PNG', 10, 10, width-10,height-10,'','FAST');
		//form.width(cache_width);
		doc.save("Report.pdf");
		});

	}
	
function getCanvas(){
	//form.width((a3[0]*1.33333) -80).css('max-width','none');
	return html2canvas(form,{
    	imageTimeout:2000,
    	removeContainer:true
    });
}
});
/////////////Ending report controller ///////

/////////////////////////// Topbar Controller Starts From Here  ///////////////////////////////////
app.controller('projectCtrl', function($scope, $http, $timeout) {

	$scope.hastrue=false;
    $scope.employeeid="";
	$scope.projectid=0;
	$scope.fromdate="";
	$scope.todate="";
	$scope.leavereason="";
	$scope.leavestatus="";
	$scope.leavevalidsts="";
	$scope.applydate="";
	$scope.approvercomment="";
	$scope.resumptiondate="";
    $scope.approvedby=0; 
    $scope.leavetypeid=0;
	//$scope.leavevalidsts=[];
    onfetch('leave/getallleaveemployee',4);
	function onfetch($val, $id)
	{
		$scope.hastrue=true;
		$http({
			url: path+$val,
			method: "POST",
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {
				
				if(data.status){
					if($id==1){
						$scope.divisionarray=[];
						$scope.divisionarray=data.data;
						$scope.divisionarray.insert(0,{id:0,name:"------All-------"});
                                               
					}else if($id==2){
						$scope.leavestsarray=[];
						$scope.leavestsarray=data.data;
					}else if($id==3){
						$scope.leavetypearray=[];
						$scope.leavetypearray=data.data;
						
                                              
					}
					else if($id==4){
						$scope.employeearray=[];
						$scope.employeearray=data.data;
					}
					else if($id==5){
						$scope.departarray=[];
						$scope.departarray=data.data;
						$scope.departarray.insert(0,{id:0,name:"------All-------"});
					}
					else if($id==6){
						$scope.desigarray=[];
						$scope.desigarray=data.data;
						$scope.desigarray.insert(0,{id:0,name:"------All-------"});
					}
				}
				$scope.hastrue=false;
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
			
	}

	
	$scope.getId = function($id) {
		$scope.projectid=$id;
	}
	$scope.ondelete =function()
	{
	//$scope.rolearr=[];
	//$scope.hastrue=true;
	$http({
        url: path+'timesheet/deleteproject/'+$scope.projectid,
        method: "POST",
        headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
      }).success(function (data, status, headers, config) {
			if(data.status){
			
				 successMessage(data.successMsg);
				 table.draw();
			}else{
				errorMessage(data.errorMsg);
			}
			$scope.projectid=0;
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
}
	Array.prototype.insert = function (index, item) {
	  this.splice(index, 0, item);
	};
 $scope.juniourarr=[];  
	$scope.onfetchjuniours =function($id)
	{ 

		$scope.hastrue=true;
		var xsrf = $.param({empid: $id});
		$http({
			url: path+'employee/getemployeehierarchy',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			if(data.status){
                
				$scope.juniourarr=data.data;
				
			}		
			$scope.changests=data.changestatus;
			$scope.hastrue=false;
			
		}).error(function (data, status, headers, config) {
			//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}

	
  $scope.onfetchproject =function()
	{ 

		$scope.hastrue=true;
		var xsrf = $.param({projectid: $scope.projectid});
		$http({
			url: path+'timesheet/getaproject',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			if(data.status){
                
				$scope.employeeid=data.data[0]['employeeid'];
				$scope.fromdate=data.data[0]['fromdate'];
				$scope.todate=data.data[0]['todate'];
				$scope.leavereason=data.data[0]['leavereason'];
				$scope.leavestatus=data.data[0]['leavestatus'];
				$scope.leavevalidsts=data.data[0]['leavevalidsts'];
				$scope.leavedays=data.data[0]['leavevalidsts'];
				$scope.applydate=data.data[0]['applydate'];
				$scope.approvercomment=data.data[0]['approvercomment'];
				$scope.resumptiondate=data.data[0]['resumptiondate'];
               	$scope.approvedby = data.data[0]['approvedby'];
				$scope.approvercomment = data.data[0]['approvercomment'];
				$scope.contactdetail = data.data[0]['emergencycontact'];
				$scope.leavetype = data.data[0]['leavetypeid'];
				$scope.fromdaytype=data.data[0]['fromdaytype'];
				$scope.todaytype=data.data[0]['todaytype'];
				$scope.timeoffrom=data.data[0]['timeoffrom'];
				$scope.timeofto=data.data[0]['timeofto'];
				$scope.leaveat=data.data[0]['leaveattachment'];
				var temp = data.data[0]['leavebreakdown'];
				if(temp != "")
				{
					temp=temp.split(',');
					
					$scope.entitled=Number(temp[0]);
					$scope.carryforward=Number(temp[1]);
					$scope.advance=Number(temp[2]);
					$scope.unpaid=Number(temp[3]);
					
				}
				gettimediff();
				$scope.onfetchleavetype();
				
			}		
			$scope.changests=data.changestatus;
			$scope.hastrue=false;
			
		}).error(function (data, status, headers, config) {
			//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}

	$scope.oncreate = function($val)
	{ 
	
		
		
		$scope.hastrue=true;
		var xsrf = $.param({ ownerid: $scope.ownerid , fromdate: $scope.fromdate , todate : $scope.todate , desc : $scope.desc, title : $scope.title, assignempid:$scope.assignempid });
		$http({
			url: path+'timesheet/createproject',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
		 //errorMessage( $scope.leavevalidsts);
			if(data.status){
                            
				successMessage(data.successMsg);
				
		        
				if($val==1){
					//window.open(path+"timesheet/leaveslist", "_self");
					$timeout(function(){window.open(path+"timesheet/projectlist", "_self");}, timeo);
				}				
			}else{
				errorMessage(data.errorMsg);
			}
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}
	
	
	
	
	
	
	
	$scope.onupdate = function($val)
	{ 
	
		if($scope.fromdaytype==1){
			$scope.timeoffrom=0;
		}
		if($scope.todaytype==1){
			$scope.timeofto=0;
		}
		if($scope.fromdate==$scope.todate)
		{
			if($scope.fromdaytype==2)
			{
				if($scope.timeoffrom != $scope.timeofto){
					//$scope.todaytype=2;
					//$scope.timeofto=$scope.timeoffrom;
					errorMessage("You cannot choose diffrent half day for same day");
					return;
				}
				
			}
		}
		
		var temp=Number($scope.entitled)+Number($scope.carryforward)+Number($scope.advance)+Number($scope.unpaid);
		if(temp != $scope.dayseligible)
		{
			errorMessage("Leave break down should be equal to Leave Days");
			return;
		}
		var leftleave=0;	
		for(var i=0;i<$scope.leavetypearray.length;i++)
		{
			if($scope.leavetype==$scope.leavetypearray[i].id)
			{
				leftleave=parseFloat($scope.leavedays)+parseFloat($scope.leavetypearray[i].leftleave);
				console.log(leftleave)
				if($scope.entitled>leftleave)
				{
					errorMessage("This Employee have only "+leftleave+"  entitle leave left");
					return;
				}
				if($scope.carryforward>$scope.leavetypearray[i].carryforward)
				{
					if($scope.carryforward != 0) {
						errorMessage("This Employee have only "+$scope.leavetypearray[i].carryforward+" carry forward leave left");
						return;
					}
				}
			}
		}
		var leavebreakdown=$scope.entitled+','+$scope.carryforward+','+$scope.advance+','+$scope.unpaid;
		$scope.hastrue=true;
		var xsrf = $.param({leaveid:$scope.projectid, resumptiondate: $scope.resumptiondate , leavefrom: $scope.fromdate , leaveto : $scope.todate , leavereason : $scope.leavereason, leavetypeid : $scope.leavetype, employeeid:$scope.employeeid, applydate:$scope.applydate, leavestatus:$scope.leavestatus, approvedby:$scope.approvedby, approvercomment:$scope.approvercomment, contactdetail:$scope.contactdetail,dayseligible:$scope.dayseligible,fromdaytype:$scope.fromdaytype,todaytype:$scope.todaytype,timeoffrom:$scope.timeoffrom,timeofto:$scope.timeofto,leavebreakdown:leavebreakdown});
		$http({
			url: path+'timesheet/updatedeproject',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
		 //errorMessage( $scope.leavevalidsts);
			if(data.status){                            
				
				if(($("#documentfile").prop("files")[0] )!="")
				{
					$scope.uploaddoc();
				}
				successMessage(data.successMsg);
				$scope.applydate="";
				//$scope.projectid=0; 
		        $scope.resumptiondate="";
                $scope.fromdate="";
                $scope.todate="";
			    $scope.leavereason="";
				$scope.leavetype="";
				$scope.employeeid="";
				$scope.leavestatus="";
				$scope.approvedby=0;
				$scope.approvercomment="";
				$scope.contactdetail="";
				if($val==1){
					//window.open(path+"timesheet/leaveslist", "_self");
					$timeout(function(){window.open(path+"timesheet/leaveslist", "_self");}, timeo);
				}				
			}else{
				errorMessage(data.errorMsg);
			}
			$scope.hastrue=false;
        }).error(function (data, status, headers, config) {
            //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}
	/////////////////upload leave attachment in the case of sick timesheet/////
	
});
