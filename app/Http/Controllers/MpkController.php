<?php namespace App\Http\Controllers;

use App\Departure;
use App\Line;
use App\City;

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
		set_time_limit(120);
		$city = City::first();
		$out = Line::import($city);
		$lines = Line::all();
		foreach($lines as $line)
			echo $line." ";
		return "";
	}

}
