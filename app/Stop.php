<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Goutte\Client;
use App\Departure;
class Stop extends Model {
	protected $table = 'stops';
	protected $primaryKey = 'stopID';
	public $timestamps = false;

	public static function import($url,$dir,$LineID,$CityID)
	{
		if(!$url)
			return [];
		$stops = [];
		$client = new Client();
		$crawler = $client->request('GET', $url);
		$crawler->filter('.cellroute')->each(function($route,$i) use (&$stops,$dir,$LineID,$CityID) {
			if($i==0)
			{				
				$route->filter('li')->each(function($stop,$j) use (&$stops,$dir,$LineID,$CityID){
					$stop->filter('a')->each(function($link,$k) use (&$stops,$dir,$LineID,$CityID){
						if($k==1)
						{
							$stop = self::getExistedOrNew($link->text(),$CityID);
							$stop->deps = Departure::import($link->link()->getUri(),$dir,$stop->stopID, $LineID,$CityID);
							$stops[] = $stop;
						}
						
					});
				});
			}
		});		
		return $stops;
	}

	public static function getExistedOrNew($name,$CityID)
	{
		$stop = self::where('name','=',$name)->where('cityID','=',$CityID)->first();
		if($stop)
			return $stop;
		else 
		{
			$stop = new self();
			$stop->name = $name;
			$stop->cityID = $CityID;
			// $stop->save(); 
			return  $stop;
		}
	}

}
