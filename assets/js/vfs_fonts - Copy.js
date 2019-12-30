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

var app = angular.module('adminapp', []);


app.controller('attroasterCtrl', function($scope, $http, $timeout) {
$scope.hastrue=false;
$scope.name='sohan patel';

	
});
