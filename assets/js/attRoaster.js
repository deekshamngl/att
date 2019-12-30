/*! Ubiattendance.ubihrm.js
 * ================
 *
 * @Author  sohan patel
 * @Email   <sohna@gmail.com>
 * @version 1.0.0.0
 */

'use strict';

//Make sure jQuery has been loaded before app.js
if (typeof jQuery === "undefined") {
  throw new Error("UBICRM requires jQuery");
}
//'ui.bootstrap', 'xeditable', 'ngSanitize'

var app = angular.module('adminapp', ['ui.bootstrap']);


app.controller('attroasterCtrl', function($scope, $http, $timeout) {
	  
	   $scope.curPage = 1,
      $scope.itemsPerPage = 20,
      $scope.maxSize = 6;
    
	
 
 $scope.hastrue=false;
 $scope.name='sohan patel';
 $scope.records = [];
 $scope.arrdate = [];
 $scope.dates=[];
 
 $scope.fetchtabledata = function()
 {
	 
	        $scope.hastrue=true;
	        var shift=$('#shift').val();
			var deprt=$('#deprt').val();
			var empl=$('#empl').val();
			var desg=$('#desg').val();
			var date=$('#revenuedate').val();
			
		var xsrf = $.param({shift:shift,deprt: deprt,empl:empl,desg:desg});
		$http({
			url: 'getattRoaster',
			method: "POST",
			data:xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config)
		{
			console.log(data.data);
			console.log(data.date);
				$scope.dates = data.date;
				var obj = data.data;
				var n = data.count;
				$scope.arrdate = obj;
				$scope.records = obj;
				$scope.hastrue=false;
			
		}).error(function (data, status, headers, config) {
			
			$scope.hastrue=false;
			
		});
 }
 
 
 	
 
 $scope.fetchtablemonthlydata = function()
 {
			$scope.hastrue=true;
			$scope.arrdate = [];
			 $scope.records = [];
			 $scope.dates=[];
			var empl=$('#empl').val();
			var shift=$('#shift').val();
			var deprt=$('#deprt').val();
			var date=$('#revenuedate').val();
			var xsrf = $.param({empl:empl,date:date,deprt:deprt,shift:shift});
			
		// get data	
		$http
		({
			url: 'getattRoastermonthly_count',
			method: "POST",
			data:xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status,headers,config) {
			  $scope.$totalemp = data;
	 //  pagination Code
	 
	 
        $scope.numOfPages = function () {
			//alert();
             return Math.ceil($scope.$totalemp / $scope.itemsPerPage);
        };
 
		$scope.$watch('curPage + numPerPage', function() {
			$scope.hastrue=true;
		var begin = (($scope.curPage - 1) * $scope.itemsPerPage),
		end = begin + $scope.itemsPerPage;
		xsrf = $.param({empl:empl,date:date,deprt:deprt,shift:shift,begin:begin,end:end});
		/*------------------------------------------------------------------------------------------*/
		  $http
		({
			url: 'getattRoastermonthly',
			method: "POST",
			data:xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status,headers,config) {
			  $scope.dates = data.date;
			  $scope.arrdate = data.data;
			  $scope.records = data.data;
			
		    // alert("Begin1 : "+begin + " End : "+end);
		
		    $scope.filteredItems = $scope.records.slice(0, $scope.itemsPerPage);
	    	//$scope.filteredItems = $scope.records.slice(begin, end);
	   
			$scope.hastrue=false;
		}).error(function (data,status,headers,config) {
			$scope.hastrue=false;
		});
		
		/*-----------------------------------------------------------------------------*/
	  });
			 
			$scope.hastrue=false;
		}).error(function (data,status,headers,config) {
			$scope.hastrue=false;
		});
 }
 
  $scope.filtermonthlysummary = function()
   {
	    
	   $scope.hastrue=true;
	         $scope.arrdate = [];
			 $scope.records = [];
			 $scope.dates=[];
			var empl=$('#empl').val();
			var deprt=$('#deprt').val();
			var shift=$('#shift').val();
			$scope.hastrue=true;
			var date=$('#revenuedate').val();
			
		   var xsrf = $.param({empl:empl,date:date,deprt:deprt,shift:shift});
				
		$http({
			url: 'getattRoastermonthly',
			method: "POST",
			data:xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			//alert(data);
			console.log(data.data);
			$scope.dates = data.date;
			
			var n = data.count;
			var obj = data.data;
		   $scope.arrdate = obj;
		   $scope.filteredItems = obj;
		   
		   //  pagination Code
      /*  $scope.numOfPages = function () {
             return Math.ceil($scope.records.length / $scope.itemsPerPage);
        };
		$scope.$watch('curPage + numPerPage', function() {
		var begin = (($scope.curPage - 1) * $scope.itemsPerPage),
		end = begin + $scope.itemsPerPage;
	//	alert("Begin : "+begin + " End : "+end);
		$scope.filteredItems = $scope.records.slice(begin, end);
	   
	  }); */
		   
		   
		   
			$scope.hastrue=false;
		}).error(function (data,status,headers, config) {
			$scope.hastrue=false;
		});
			
 }
 
 
 
 
    $scope.GetEmpList = function($shiftid)
 	  {
		$scope.emparray=[];
		$scope.shiftid=$shiftid;
		$scope.hastrue=true;
		var xsrf = $.param({shiftid: $scope.shiftid});
		$http({
			url: 'getemployeebyshift',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config){
			
				
				$scope.emparray=data.data;
				console.log(data.data);
				setTimeout(function(){
					$timeout(function(){	$scope.getrow();}, 500); 
				}, 1000);
			
			$scope.hastrue=false;
		}).error(function (data, status, headers, config) {
			//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}
	
	
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
 
 
 $scope.getchecklistid=function($index){
	//alert($index);
	//var st = $scope.emparray[$index]['sts'];
	if($scope.emparray[$index]['sts'] == 0)
	{
		$scope.emparray[$index]['sts'] = 1;
	}
	else{
		$scope.emparray[$index]['sts'] = 0;
	}
	//alert($scope.emparray[$index]['sts']);
	/*	var customInput =  $(".list-group-item.list-group-item-success.active").length;
		//alert("customInput...."+customInput);
		//alert("scope.emparray.length...."+$scope.emparray.length);
			for(var i=0;i<$scope.emparray.length;i++){
				//console.log($scope.emparray[i]['id']);
				//alert("scope.emparray[i]['id']"+$scope.emparray[i]['id']);
				if($scope.emparray[i]['id']==$id){
					
					if(customInput==i){
						//alert("custominput in if"+customInput)
						$scope.emparray[i]['sts']=0;
						console.log($scope.emparray[i]['sts']);
						//alert("if status"+$scope.emparray[i]['sts'])
					}else{
						$scope.emparray[i]['sts']=1;
						console.log($scope.emparray[i]['sts']);
						//console.log($scope.checklistarray[i]['sts1']);
						//alert("else status"+$scope.emparray[i]['sts'])
						}
			                                   }
		}*/
	}
 
 
 $scope.SaveEmpList=function($id){
		//alert($id);
		var total= $("#check-list-box li").length;
			//alert(total);
		var selectcheck= $(".list-group-item.list-group-item-success.active").length;
		
		if(selectcheck!=0){
			var json=angular.toJson($scope.emparray);			
			//console.log(json);
			//alert("json"+json);
			//alert("shift"+$scope.shiftid);
			var xsrf = $.param({ shiftid:$scope.shiftid,emplist:json});
			$http({
				url: 'SaveEmpShiftList',
				method: "POST",
				data: xsrf,
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			}).success(function(data, status, headers, config){
				$scope.hastrue = false;
				$('#updateShift').modal('hide');
				
		doNotify('top','center',2,'Employee shift Updated Successfully.');
				
			}).error(function(data, status, headers, config){
				$scope.hastrue=false;
			});
		} else {
			
			doNotify('top','center',4,'Please select atleast one employee.');
			return false;
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
				
				doNotify('top','center',2,'Employee Geolocation Updated Successfully.');
				
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
 
 $scope.filter = function()
 {
	         $scope.hastrue=true;
	         $scope.arrdate = [];
			 $scope.records = [];
			 $scope.dates=[];
	        var shift=$('#shift').val();
			var deprt=$('#deprt').val();
			var empl=$('#empl').val();
			var desg=$('#desg').val();
			var date=$('#revenuedate').val();
		    var todayTime = new Date(date);
            var month = (todayTime . getMonth() + 1);
			 if(month<9)
				  month = 0+""+month;
            var year = (todayTime . getFullYear());
			  date = month+"-"+year;
			//alert(date);
			
		   var xsrf = $.param({shift:shift,empl:empl,desg:desg,date:date,deprt:deprt});
			//	alert(xsrf);
		$http({
			url: 'getattRoaster',
			method: "POST",
			data:xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			//alert(data);
			$scope.dates = data.date;
			var n = data.count;
			var obj = data.data;
		   $scope.arrdate = obj;
		   $scope.records = obj;
			$scope.hastrue=false;
		}).error(function (data, status, headers, config) {
			$scope.hastrue=false;
		});
			
 }
 

});
