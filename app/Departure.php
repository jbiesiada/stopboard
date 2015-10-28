<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Goutte\Client;
class Departure extends Model {
	protected $table = 'departures';
	protected $primaryKey = 'departureID';
	public $timestamps = false;

	public function line()
	{
		return $this->hasOne('App\Line', 'lineID','lineID');
	}
	public function when($mixedtime)
	{
		$thismtime = $this->hour*60+$this->minute;
		return $thismtime - $mixedtime;
	}
	public function end()
	{
		$line = $this->line;
		if($this->directory == 0)
			return $line->end;
		return $line->start;
	}
	public static function getLatest($stopID,$time)
	{
		date_default_timezone_set("CET");
		$dayType = date('w',$time)== 7?2:date('w',$time)== 6?1:0;
		$hour = (int) date('H',$time);
		$minute = (int) date('i',$time);
		$deps = self::where('stopID','=',$stopID)->where('dayType','=',$dayType)->where(function($query) use($hour,$minute)
		{
			$query->where('hour','=',$hour)->where('minute','>=',$minute)->orWhere('hour','>',$hour);
		})
		->orderBy('hour')->orderBy('minute')->limit(5)->get();
		return $deps;
	}

	public static function import($url,$dir,$StopID, $LineID,$CityID)
	{
		if(!$url)
			return [];
		$old = self::where('directory','=',$dir)
			->where('stopID','=',$StopID)
			->where('lineID','=',$LineID)
			->where('cityID','=',$CityID)->get();
		if(!empty($old))
			foreach($old as $line)
				$line->delete();

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
						$departureClone->save();
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