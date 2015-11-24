<?php namespace App\Http\Controllers;

use App\Departure;
use App\Line;
use App\City;
use App\Stop;
use \DateTime;

class MpkController extends Controller {

	public function __construct()
	{
		date_default_timezone_set("CET");
	}
	public function index()
	{
		return view('index');
	}
	public function getCities()
	{
		return json_encode(City::all());
	}
	public function getDeps($stop,$time)
	{	
		return json_encode($stop->getLatest($time));
	}
	public function getLines($city)
	{
		return json_encode($city->lines);
	}
	public function getStops($city)
	{
		return json_encode($city->stops);
	}	
}
