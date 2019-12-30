/*! UBICRM Setup.js
 * ================
 *
 * @Author  Deeksha Mangal
 * @Email   <deeksha@ubitechsolutions.com>
 * @version 1.0.0.0
 */

'use strict';

//Make sure jQuery has been loaded before app.js
if (typeof jQuery === "undefined") {
  throw new Error("UBICRM requires jQuery");
}
//'ui.bootstrap', 'xeditable', 'ngSanitize'

var app = angular.module('hourlyapp',[]);
/*angular.module('TestApp', ['TestApp.controllers','datatables', 'datatables.buttons']);*/

app.controller('hourlyctrl', function($scope, $http, $timeout) {
	 
    
$scope.hastrue=false;
$scope.ratedata = [];
 
 $scope.fetchhourlyratedata = function()
 {
	       /* var shift=$('#shift').val();
			var deprt=$('#deprt').val();
			var empl=$('#empl').val();
			var desg=$('#desg').val();
			var date=$('#revenuedate').val();*/
			
	 // var xsrf = $.param({shift:shift, deprt: deprt,empl:empl,desg:desg});
	    $scope.hastrue=true;
		$http({
			url: 'getHourlyPay',
			method: "POST",
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			 //alert(data.data[0][0]['info'].total_hour);
			 $scope.ratedata = data.data;
			$scope.hastrue=false;
		}).error(function (data, status, headers, config) {
			$scope.hastrue=false;
		});
 }
 $scope.fetchhourlyratedata();
 $scope.filterratedata = function()
  {          
            $scope.ratedata = [];
	        var range=$('#reportrange').text();
			var shift=$('#shift').val();
			var deprt=$('#deprt').val();
			var empl=$('#empl').val();
			var desg=$('#desg').val();
			
	  var xsrf = $.param({shift:shift, deprt: deprt,empl:empl,desg:desg,date:range});
	    $scope.hastrue=true;
		$http({
			url: 'getHourlyPay',
			method: "POST",
			data:xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			
			 $scope.ratedata = data.data;
			$scope.hastrue=false;
		}).error(function (data, status, headers, config) {
			$scope.hastrue=false;
		});
 }
	
});
