var cities = [
	{id:0,name:'Poznań'},
	{id:1,name:'Kraków'},
	{id:2,name:'Warszawa'},
	{id:3,name:'Gdańsk'}
];
var lines = [
	{id:0,	type:'Tram',	number:1	},
	{id:1,	type:'Tram',	number:2	},
	{id:2,	type:'Tram',	number:3	},
	{id:3,	type:'Tram',	number:4	},
	{id:4,	type:'Bus',		number:61	},
	{id:5,	type:'Bus',		number:71	},
	{id:6,	type:'Bus',		number:81	},
	{id:7,	type:'Bus',		number:91	}
];
var stops = [
	{id:0,name}
];
var types = [{name:'Trams',type:'Tram'},{name:'Buses',type:'Bus'}];
var app = angular.module('mpkApp', []);

app.controller("CitiesListController",function(){
	var CitiesList = this;
	CitiesList.cityId = 0;

	CitiesList.cities = cities;
	this.selectCity = function(key){
		CitiesList.cityId = key;
	};
	this.isSelected = function(key){
		return CitiesList.cityId === key;
	};
	this.getCity = function(key){
		return CitiesList.cities[key];
	};
});

app.controller("LinesListController",function(){
	var LinesList = this;
	LinesList.lines = lines;
	LinesList.types = types;
});