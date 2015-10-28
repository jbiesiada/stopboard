var app = angular.module('mpkApp', []);
app.controller("CitiesListController",function($filter,$http){
	var date = new Date();
	console.log(date);

	var CitiesList = this;
	CitiesList.city = {};
	CitiesList.stop = {};
	CitiesList.cities = [];
	CitiesList.date = new Date();
	CitiesList.stops = [];
	CitiesList.deps = [];
	$http.get("/getcities").success(function(response){
		CitiesList.cities = response;
		CitiesList.city = response[0];
		$http.get("/getstops/"+response[0].cityID).success(function(response){
			CitiesList.stops = response;
		});
	});
	this.selectCity = function(key){
		$http.get("/getstops/"+key).success(function(response){
			CitiesList.stops = response;
		});
		CitiesList.city = $filter('filter')(CitiesList.cities, function (d) {return d.cityID === key;})[0];
	};
	this.isSelected = function(key){
		return CitiesList.city.cityID === key;
	};
	this.update = function(key){
		CitiesList.date = new Date();
		CitiesList.stop = $filter('filter')(CitiesList.stops, function (d) {return d.stopID === key;})[0];
		$http.get("/getdeps/"+CitiesList.stop.stopID+"/"+Math.floor( CitiesList.date.getTime()/1000)).success(function(response){
			CitiesList.deps = response;
		});
	};
});


app.controller("importController",function($http){
	var importer = this;
	importer.line = {};
	importer.cities = [];
	importer.ready = false;
	importer.percent = 0;
	var counter = 0;
	importer.lines = [];
	$http.get("/getcities").success(function(response){
		importer.cities = response;
		importer.cityId = response[0].cityID;
		$http.get("/getlines/"+importer.cityId).success(function(response){
			importer.lines = response;
			importer.ready = true;
		});
	});

	importer.importStart = function(){
		counter = 0;
		for(l in importer.lines)
		{
			$http.get("/getline/"+importer.lines[l].lineID).success(function(response){
				importer.line = importer.lines[l];
				counter++;
				importer.percent = 100*counter/importer.lines.length;
			});				
		}
	};



});