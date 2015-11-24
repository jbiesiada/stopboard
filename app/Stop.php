<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Goutte\Client;
use App\Departure;
use App\SelectedTime;
class Stop extends Model {
	protected $table = 'stops';
	protected $primaryKey = 'stopID';

	public function departures()
	{
		return $this->hasMany('App\Departure', 'stopID','stopID');
	}

	public function getLatest($time)
	{	
		$selectedTime = new SelectedTime($time);
		$deps = $this->departures()->nearest($selectedTime)->get();
		foreach($deps as &$d)
		{
			$d->addDesc($selectedTime);
		}
		return $deps;
	}

	public static function fullImport(Line $line)
	{
		if(!empty($line->link1))
			$dirs[0] = Stop::import($line->link1,0,$line->lineID,$line->cityID);
		if(!empty($line->link2))
			$dirs[1] = Stop::import($line->link2,1,$line->lineID,$line->cityID);
		return $dirs;
	}
	public static function import($url,$dir,$LineID,$CityID)
	{
		$stop_links = \Cache::get('stop_links'.$LineID.'_'.$CityID);
		if(empty($stop_links))
			$stop_links = [];
		if(!$url)
			return [];
		$stops = [];
		$client = new Client();
		$crawler = $client->request('GET', $url);
		$crawler->filter('a[target="R"]')->each(function($link,$k) use (&$stops,&$stop_links,$dir,$LineID,$CityID){
			$stop = self::getExistedOrNew(trim($link->text()),$CityID);
			$stop_links[$stop->stopID][$dir] = $link->link()->getUri();
			$stop->deps = Departure::import($link->link()->getUri(),$dir,$stop->stopID, $LineID,$CityID);
			$stops[] = $stop;
		});		
		\Cache::put('stop_links'.$LineID.'_'.$CityID,$stop_links,30);
		return $stops;
	}

	public static function getExistedOrNew($name,$CityID)
	{
		$stop = self::where('name','=',$name)->where('cityID','=',$CityID)->first();
		if($stop)
		{
			// dd($stop);
			return $stop;
		}
		else 
		{
			$stop = new self();
			$stop->name = $name;
			$stop->cityID = $CityID;
			$stop->save(); 
			// dd($stop);
			return  $stop;
		}
	}

}
