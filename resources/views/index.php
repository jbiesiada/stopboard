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
  	<div class="row">
		<div class="col-xs-4">
			<H3>{{cityList.city.name}}<span ng-show="cityList.stop.name"> - {{cityList.stop.name}}</span></H3>
			<select class="form-control"  ng-model='stop' ng-change="cityList.update(stop)">
			<option ng-repeat="stop in cityList.stops" value="{{stop.stopID}}"> {{stop.name}} </option>				
			</select>
		</div>
		<div class="col-xs-8" >
			<span>{{cityList.date | date:'yyyy-MM-dd hh:mm:ss'}}</span>
			<div>
				<p ng-repeat="dep in cityList.deps">{{dep.lineName}} | {{dep.lineEnd}} | {{dep.when}} ({{ dep.hour}}:{{dep.minute}})</p>
			</div>
		</div>
	</div>
</div>

<div ng-controller="importController as import" ng-show='false'>
	<h3>{{import.line.name}}</h3>
	<div class="progress">
  		<div class="progress-bar" role="progressbar" aria-valuenow="{{import.percent}}" aria-valuemin="0" aria-valuemax="100" style="width: {{import.percent}}%;">
    		{{import.percent | number:2 }}%
  		</div>
	</div>
	<button ng-show="import.ready" ng-click="import.importStart()">Start</button>
</div>
</body>
</html>