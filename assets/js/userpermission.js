/*! Ubiattendance.ubihrm.js
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

var app = angular.module('permissionapp', []);


app.controller('permissionCtrl', function($scope, $http, $timeout) {
	    
 $scope.hastrue=false;
 $scope.name='sohan patel';
 $scope.records = [];
 $scope.arrdate = [];
 $scope.dates=[];
 
	
 
 $scope.updateuserpermission = function(desid)
 {
	
	 
	  var checked = [];
	  var status = [];
	  
	  $("input[name='"+desid+"[]']").each(function ()
		{
			if($(this).prop("checked") == 1)
			{
			 checked.push(parseInt($(this).val()));
			 status.push(1);
			 //alert($(this).val());
			}
			else
			{
			   checked.push(parseInt($(this).val()));
			   status.push(0);
			   //alert('0');
			}
	   });
	  checked = JSON.stringify(checked);
	  status = JSON.stringify(status);
	 // alert(checked);
	  //alert(status);
	 // return false;

	    $scope.hastrue=true; 
		$http({
			url: 'updateuserpermission',
			method: "POST",
			data: $.param({"checked": checked,"desid":desid,"status":status})	,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			
			 if(data==1)
			 {
				 doNotify('top','center',2,'Permission Update Successfully.');
				 setTimeout(function(){
					location.reload();
					 }, 2000);
			 }
			 else
			 {
				doNotify('top','center',3,'No Change Found.'); 
			 }
			$scope.hastrue=false;
		}).error(function (data, status, headers, config){
			$scope.hastrue=false;
			doNotify('top','center',4,' Unable to connect API');
		});
 }

	
});
