<?php namespace App\Http\Controllers;

use App\Departure;
use App\Stop;

class MpkController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

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
		$url = 'http://rozklady.mpk.krakow.pl/aktualne/0001/0001w001.htm';

		$out = Stop::import($url,0,0,0);
		dd($out);
		return view('index');
	}

}
