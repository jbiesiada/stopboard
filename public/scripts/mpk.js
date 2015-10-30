var app = angular.module('mpkApp', []);
app.controller("CitiesListController",function($filter,$http){
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


app.controller("importController",function($scope,$http,$interval){
	var importer = this;
	var counter = 0;
	importer.ready = false;
	importer.resetValues = function(){
		importer.deleting = false;
		importer.deleted = false;
		importer.importingCities = false;
		importer.importedCities = false;
		importer.importingLines = false;
		importer.importedLines = false;
		importer.importing = false;
		importer.line = {};
		importer.stop = {};
		importer.cities = [];
		importer.ready = false;
		importer.percent = 0;
		importer.stopspercent = 0;
		importer.lines = [];	
		$http.get('/getcreated').success(function(response){
			if(response != 'null')
			{
				importer.ready = true;
				importer.deleteAndImportLines();
			}
		});
	}
	setInterval(function($scope,$interval){
		if(importer.ready == false)
			importer.resetValues();
	},10000);
	
	importer.importLines = function(){
		importer.importingCities = true;
		$http.get("/getcities").success(function(response){
			importer.importedCities = true;
			importer.cities = response;
			importer.cityId = response[0].cityID;
			importer.importingLines = true;
			$http.get("/import/"+importer.cityId).success(function(response){
				importer.importedLines = true;
				console.log('imported');
				importer.lines = response;
				importer.importStart();
			});
		});
	}

	importer.deleteAndImportLines = function(){
		importer.deleting = true;
		$http.get("/truncatetables").success(function(response){
			importer.deleted = true;
			console.log('deleted');
			importer.importLines();
		});
	}
	importer.importStart = function(){
		counter = 0;
		importer.importing = true;
		for(l in importer.lines)
		{
			$http.get("/getline/"+importer.lines[l].lineID).success(function(response){
				importer.line = importer.lines[counter];
				counter++;
				importer.percent = 100*counter/importer.lines.length;
				if(importer.percent == 100)
				{
					location.reload();					
				}
			});				
		}
	};
});