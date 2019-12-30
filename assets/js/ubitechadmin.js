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

var app = angular.module('ubiapp', []);
/*angular.module('TestApp', ['TestApp.controllers','datatables', 'datatables.buttons']);*/

app.controller('ubictrl', function($scope, $http, $timeout) {
	  
	  
$scope.hastrue=false;
$scope.name='sohan patel';
 $scope.records = [];
 $scope.dates=[];
 $scope.arrexpired = [];
 
 
	
 
 $scope.fetchtabledata = function()
 {
	    $scope.hastrue=true;
		$http({
			url: 'expiredOrganization',
			method: "POST",
			
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			 //alert(data.data.length);
			 $scope.arrexpired = data.data;
			
			$scope.hastrue=false;
		}).error(function (data, status, headers, config){
			$scope.hastrue=false;
		});
 }
$scope.fetchtabledata();
	
});
