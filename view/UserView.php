<!DOCTYPE html>
<html>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<body>

<div ng-app="myApp" ng-controller="myCtrl"> 

<p>User name :</p>

<p>{{maison.nom}}</p>

</div>

<script>
var app = angular.module('myApp', []);
app.controller('myCtrl', function($scope, $http) {
  $http.get("/maison/1")
  .then(function(response) {
      $scope.maison = response.data;
  });
});
</script>

</body>
</html>
