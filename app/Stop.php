<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Goutte\Client;
use App\Departure;
class Stop extends Model {
	protected $table = 'stops';
	protected $primaryKey = 'stopID';

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
		if(!$url)
			return [];
		$stops = [];
		$client = new Client();
		$crawler = $client->request('GET', $url);
		$crawler->filter('a[target="R"]')->each(function($link,$k) use (&$stops,$dir,$LineID,$CityID){
			$stop = self::getExistedOrNew(trim($link->text()),$CityID);
			$stop->deps = Departure::import($link->link()->getUri(),$dir,$stop->stopID, $LineID,$CityID);
			$stops[] = $stop;
		});		
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
