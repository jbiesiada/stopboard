<!DOCTYPE html>
<html ng-app="mpkApp">
<head>
 <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.min.js"></script>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
 <link rel="stylesheet" href="css/styles.css">
 <script src="scripts/mpk.js"></script>
 <meta charset="UTF-8"/>
	<title></title>
</head>
<body>
<div class="container-fluid" ng-controller="CitiesListController as cityList">
  	<div class="row" ng-controller="importController as import">
		<div class="col-xs-4" ng-hide='import.ready'>
			<H3>{{cityList.city.name}}<span ng-show="cityList.stop.name"> - {{cityList.stop.name}}</span></H3>
			<select class="form-control"  ng-model='stop' ng-change="cityList.update(stop)">
			<option ng-repeat="stop in cityList.stops" value="{{stop.stopID}}"> {{stop.name}} </option>				
			</select>
		</div>
		<div class="col-xs-8" ng-hide='import.ready'>
			<span>{{cityList.date | date:'yyyy-MM-dd hh:mm:ss'}}</span>
			<div>
				<p ng-repeat="dep in cityList.deps">{{dep.lineName}} | {{dep.lineEnd}} | {{dep.when}} ({{ dep.hour}}:{{dep.minute}})</p>
			</div>
		</div>
		<div class="col-xs-8" ng-show='import.ready'>
			<div role="alert" ng-class="{alert:true, 'alert-info':!import.deleted, 'alert-success':import.deleted}" ng-show = 'import.deleting'>
			<span>usuwanie starych danych </span><span ng-show = 'import.deleted' class="glyphicon glyphicon-ok" aria-hidden="true"></span><span  ng-show = '!import.deleted' class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>
			</div>
			<div role="alert" ng-class="{alert:true, 'alert-info':!import.importedCities, 'alert-success':import.importedCities}" ng-show = 'import.importingCities'>
			<span>pobieranie informacji o miastach </span><span ng-show = 'import.importedCities' class="glyphicon glyphicon-ok" aria-hidden="true"></span><span  ng-show = '!import.importedCities' class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>
			</div>
			<div role="alert" ng-class="{alert:true, 'alert-info':!import.importedLines, 'alert-success':import.importedLines}" ng-show = 'import.importingLines'>
			<span>pobieranie informacji o liniach </span><span ng-show = 'import.importedLines'  class="glyphicon glyphicon-ok" aria-hidden="true"></span><span  ng-show = '!import.importedLines' class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>
			</div>
			<div role="alert" class="alert alert-success" ng-show = 'import.importing'><span>zaimportowano linię nr: {{import.line.name}}</span></div>
			<div class="progress" ng-show='import.importing'>
		  		<div class="progress-bar" role="progressbar" aria-valuenow="{{import.percent}}" aria-valuemin="0" aria-valuemax="100" style="width: {{import.percent}}%;" >
		    		{{import.percent | number:2 }}%
		  		</div>
			</div>

			<div role="alert" class="alert alert-success" ng-show = 'import.stopsimporting'><span>zaimportowano przystanek {{import.stop.name}}</span></div>
			<div class="progress" ng-show='import.stopsimporting'>
		  		<div class="progress-bar" role="progressbar" aria-valuenow="{{import.stopspercent}}" aria-valuemin="0" aria-valuemax="100" style="width: {{import.stopspercent}}%;" >
		    		{{import.stopspercent | number:2 }}%
		  		</div>
			</div>
		</div>
	</div>
</div>

</body>
</html>