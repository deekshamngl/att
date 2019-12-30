/*! Ubiattendance.ubihrm.js
 * ================
 *
 * @Author  sohan patel
 * @Email   <sohan@ubitechsolutions.com.com>
 * @version 1.0.0.0
 */

'use strict';

//Make sure jQuery has been loaded before app.js
if (typeof jQuery === "undefined") {
  throw new Error("UBICRM requires jQuery");
}
//'ui.bootstrap', 'xeditable', 'ngSanitize'

var app = angular.module('attapp', []);


app.controller('attctrl', function($scope, $http, $timeout) {
  
 $scope.hastrue=false;
 $scope.name='sohan patel';
 $scope.attendancearray = [];
 
 $scope.onfetchattendance= function()
	  {
		 $scope.shift = $("#shift").val();
	    $scope.deprt = $("#deprt").val();
	   $scope.desg = $("#desg").val();
	   $scope.empl = $("#empl").val(); 
		$scope.hastrue=true;
		var xsrf = $.param({shift: $scope.shift,deprt:$scope.deprt,desg:$scope.desg,empl:$scope.empl});
		$http({
			url: 'getaattendance',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			//var data = JSON.parse(data);
			$scope.attendancearray = data;
		   // alert(data[0].empname);
	        setTimeout(function(){
					$(".timepicker").timepicker({ showInputs: false,showMeridian: false, minuteStep:5});
					
				
				}, 1000);
			$scope.hastrue=false;
		}).error(function (data, status, headers, config) {
			
			$scope.hastrue=false;
		});
	}

 $scope.checkovertime = function($i){
		
		var timein = new Date("01/01/1970 " + $scope.attendancearray[$i].timein);
		//console.log(timein);
		var timeout = new Date("01/01/1970 " + $scope.attendancearray[$i].timeout);
		var shifttimein = new Date("01/01/1970 " + $scope.attendancearray[$i].shifttimein).getTime();
		var shifttimeout = new Date("01/01/1970 " + $scope.attendancearray[$i].shifttimeout).getTime();
		var shifttimeinbreak = new Date("01/01/1970 " + $scope.attendancearray[$i].shifttimeinbreak).getTime();
		var shifttimeoutbreak = new Date("01/01/1970 " + $scope.attendancearray[$i].shifttimeoutbreak).getTime();
		
		var difference = new Date((timeout - timein)-(shifttimeoutbreak-shifttimeinbreak)).toUTCString().split(" ")[4];
		var difference2 = new Date((shifttimeout - shifttimein)-(shifttimeoutbreak-shifttimeinbreak)).toUTCString().split(" ")[4];
		
		var over1 = new Date((timeout - timein)-(shifttimeoutbreak-shifttimeinbreak));
		var over2 = new Date((shifttimeout - shifttimein)-(shifttimeoutbreak-shifttimeinbreak));
		
		if(difference>difference2){
			var difference1 = new Date(over1 - over2).toUTCString().split(" ")[4]; 
			var arr1 = difference1.split(":");
			$scope.attendancearray[$i].overtime= arr1[0]+":"+arr1[1];
		}else{
			var difference1 = new Date(over2 - over1).toUTCString().split(" ")[4]; 
			var arr1 = difference1.split(":");
			$scope.attendancearray[$i].overtime= "-"+arr1[0]+":"+arr1[1];
		}
		//alert( difference ); // shows: 00:07:03
		if(difference != undefined){
		var arr = difference.split(":");
		$scope.attendancearray[$i].totaltime= arr[0]+":"+arr[1];
		if($scope.attendancearray[$i].sts==5 || $scope.attendancearray[$i].sts==3)
		{
			$scope.attendancearray[$i].overtime= arr[0]+":"+arr[1];
		}
		
		}
		
	}
	Array.prototype.remove = function (index) {
	  this.splice(index,1);
	};
	$scope.removework = function($i){
		//alert();
		$scope.attendancearray.remove($i);	
	}
	$scope.oncreate = function($val)
	{	
		$scope.hastrue=true;
		var jsonData=angular.toJson($scope.attendancearray);
		var xsrf = $.param({jsonarr:jsonData});
		$http({
			url: 'createattendance',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			     if(data.status = 1)
				 {
					var count =  data.count;
					doNotify('top','center',2,  count+' Record Inserted Successfully. ');
				 }
				 else
				 {
					doNotify('top','center',4,  'Record Not Inserted. '); 
				 }
				$scope.hastrue=false;
		}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
		});
	}
});
