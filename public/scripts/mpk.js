var app = angular.module('mpkApp', []);
app.controller("CitiesListController",function($filter,$http,$scope,$interval){
	var date = new Date();
	var CitiesList = this;
	CitiesList.city = {};
	CitiesList.showresults = false;
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
		CitiesList.showresults = false;
		$http.get("/getdeps/"+CitiesList.stop.stopID+"/"+Math.floor( CitiesList.date.getTime()/1000)).success(function(response){
			CitiesList.showresults = true;
			CitiesList.deps = response;
		});
	};
});