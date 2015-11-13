<!DOCTYPE html>
<html ng-app="mpkApp">
<head>
<title>Przystanki</title>
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
		<div class="col-xs-3" ng-hide='import.ready'>
			<h3>{{cityList.city.name}}</h3>
			<div class="form-group">				
				<select class="form-control"  ng-model='stop' ng-change="cityList.update(stop)" id =  "stopsList">
				<option ng-repeat="stop in cityList.stops" value="{{stop.stopID}}"> {{stop.name}} </option>				
				</select>
			</div>
		</div>
		<div class="col-xs-8 col-md-6" ng-hide='import.ready'>
			<h3 ng-show="cityList.stop.name">Przystanek - {{cityList.stop.name}}: <span ng-hide = 'cityList.showresults' class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span></h3>
			<h5 ng-show='cityList.showresults'>{{cityList.date | date:'yyyy-MM-dd hh:mm:ss'}}</h5>
			<table ng-show='cityList.showresults' class="table table-striped">
				<thead>
					<tr>
						<th>Linia</th>
						<th>Przystanek końcowy</th>
						<th>odjazd za (min)</th>
						<th>godzina odjazdu</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="dep in cityList.deps">
						<td>{{dep.lineName}}</td>
						<td>{{dep.lineEnd}}</td>
						<td>{{dep.when}}</td>
						<td>{{ dep.hour}}:{{dep.minute}}</td>
					</tr>
				</tbody>
			</table>
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