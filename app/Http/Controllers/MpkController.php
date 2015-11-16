<?php namespace App\Http\Controllers;

use App\Departure;
use App\Line;
use App\City;
use App\Stop;
use \DateTime;

class MpkController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		date_default_timezone_set("CET");
		$this->middleware('guest');
	}

	public function index()
	{
		$d = new DateTime;
		return view('index');
	}
	public function import($cityID)
	{
		$lines = Line::where('cityID','=',$cityID)->orderBy('name')->get();
		if(!empty($lines[0]))
			return json_encode($lines);		
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
	public function getcreated()
	{
		$line = Stop::first();
		if($line)
		{
			$dbcreated = $line->created_at;
			$now = time();
			$when =  ($now-$dbcreated->timestamp)/(60*60);
			if($when<24)
				return json_encode(null);
		}
		return json_encode("import");
	}
	public function truncateTables()
	{
		$cities = City::get();
		foreach($cities as $city)
		{
			$lines = Line::where('cityID','=',$city->cityID)->get();
			foreach($lines as $line)
			{
				$value = \Cache::put('stop_links'.$line->lineID.'_'.$city->cityID,[],30);
			}
		}
		Departure::truncate();
		Line::truncate();
		Stop::truncate();
		return json_encode("ok");
	}

}
