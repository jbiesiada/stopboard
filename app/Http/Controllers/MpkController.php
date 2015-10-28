<?php namespace App\Http\Controllers;

use App\Departure;
use App\Line;
use App\City;
use App\Stop;

class MpkController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('index');
	}
	public function import($cityID)
	{
		$city = City::find($cityID);
		$line = Line::import($city);
		return json_encode($line);	
	}

	public function getCities()
	{
		return json_encode(City::all());
	}
	public function getDeps($stopID,$time)
	{	
		date_default_timezone_set("CET");
		$hour = (int) date('H',$time);
		$minute = (int) date('i',$time);
		$mixedtime = 60*$hour+$minute;
		$deps = Departure::getLatest($stopID,$time);
		foreach($deps as &$d)
		{
			$d->lineName = $d->line->name;
			$d->lineEnd = $d->end();
			$d->when = $d->when($mixedtime);
		}
		return json_encode($deps);
	}
	public function getLines($cityID)
	{
		return json_encode(Line::where('cityID','=',$cityID)->orderBy('name')->get());
	}
	public function getStops($cityID)
	{
		return json_encode(Stop::where('cityID','=',$cityID)->orderBy('name')->get());
	}
	public function importLine($lineID)
	{
		$line = Line::find($lineID);
		$stops = Stop::fullImport($line);
		return json_encode($stops);
	}

}
