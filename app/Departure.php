<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Goutte\Client;
class Departure extends Model {
	protected $table = 'departures';
	protected $primaryKey = 'departureID';
	public $timestamps = false;

	public static function import($url,$dir,$StopID, $LineID,$CityID)
	{
		if(!$url)
			return [];
		$deps = [];
		$client = new Client();
		$crawler = $client->request('GET', $url);
		$crawler->filter('.celldepart tr')->each(function($dep,$i) use (&$deps,$dir,$StopID, $LineID,$CityID) {
			$departures = [];
			$departuresall = [];
			$dep->filter('.cellhour')->each(function($hour,$j) use (&$departures,$dir,$StopID, $LineID,$CityID){
				$hourValue =  filter_var($hour->text(), FILTER_SANITIZE_NUMBER_INT);
				if(is_numeric($hourValue))
				{
					$departure = new self();
					$departure->directory = $dir;
					$departure->hour = $hourValue;
					$departure->dayType = $j;
					$departure->lineID = $LineID;
					$departure->stopID = $StopID;
					$departure->cityID = $CityID;
					$departures[$j] = $departure;
				}
			});
			$dep->filter('.cellmin')->each(function($minute,$j) use (&$departures,&$departuresall){
				$minuteValue =  filter_var($minute->text(), FILTER_SANITIZE_NUMBER_INT);
				$minutes = explode(' ',$minute->text());
				foreach ($minutes as $min) {
					if(is_numeric($min) && $time = (int) $min)
					{
						$departureClone = clone $departures[$j];
						$departureClone->minute = $time;
						// $departureClone->save();
						$departuresall[] = $departureClone;
					}
				}
			});
			foreach ($departuresall as $d) {
				$deps[] = $d;
			}
		});
		return $deps;
	}

}