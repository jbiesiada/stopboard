<!DOCTYPE html>
<html ng-app="mpkApp">
<head>
 <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.min.js"></script>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
 <script src="scripts/mpk.js"></script>
 <meta charset="UTF-8"/>
	<title></title>
</head>
<body>
<div class="container-fluid" ng-controller="CitiesListController as cityList">
	<ul class="nav nav-pills">
		<li ng-class="{ active:cityList.isSelected(key)}" role="presentation" ng-repeat="(key, city) in cityList.cities">
			<a ng-click="cityList.selectCity(key)" href="#">{{city.name}}</a>
		</li>
	</ul>
  	<div class="row">
		<div class="col-xs-2">
			<H3>{{cityList.getCity(cityList.cityId).name}}</H3>
		</div>
		<div class="col-xs-8" ng-controller="LinesListController as linesList">
			<div ng-repeat="type in linesList.types">
				<h4>{{type.name}}</h4>
				<span ng-repeat="line in linesList.lines" ng-show="line.type===type.type"> {{line.number}} </span>
			</div>
		</div>
		<div class="col-xs-2">
		</div>
	</div>
</div>
</body>
</html>