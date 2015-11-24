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
	<div class="col-xs-3">
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
</div>

</body>
</html>