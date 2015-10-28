<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Goutte\Client;
use App\Stop;
class Line extends Model {
	protected $table = 'lines';
	protected $primaryKey = 'lineID';

	public function __toString()
	{
		return "<a href='/import/".$this->lineID."'>".$this->lineID."</a>";
	}
	public static function import(City $city)
	{
		if(!$city)
			return [];
		$lines = [];
		$client = new Client();
		$crawler = $client->request('GET', $city->url);
		$crawler->filter('a')->each(function($line,$i) use (&$lines,$city) {
			if($line->attr('target')!='_blank')
			{
				$lineModel = self::getExistedOrNew(trim($line->text()),$city->cityID);
				$dirs = self::getStopsLinks($line->link()->getUri());
				$lineModel->start = self::getEnds($dirs[0])[0];
				$lineModel->end = self::getEnds($dirs[0])[1];
				if(!empty($dirs[0]))
				$lineModel->link1 = $dirs[0];
				if(!empty($dirs[1]))
					$lineModel->link2 = $dirs[1];
				$lineModel->save();
				// foreach(self::getStopsLinks($line->link()->getUri()) as $dir => $url)
				// {
				// 	$dirs[$dir] = Stop::import($url,$dir,$lineModel->lineID,$city->cityID);
				// }
				// $lineModel->dirs = $dirs;
				// dd($lineModel);
				$lines[] = $lineModel;
				// $lines[] = self::getEnds($dirs[0]);
			}
		});
		return $lines;
	}
	public static function getStopsLinks($url)
	{
		if(!$url)
			return [];
		$urls = [];
		$urls[] = self::getFrameUrl($url);
		$client = new Client();
		$crawler = $client->request('GET',$urls[0]);
		$crawler->filter('.cellroute')->each(function($route,$i) use (&$urls) {
			if($i==1)
			$route->filter('a')->each(function($link,$j) use (&$urls) {
				if($j==0)
					$urls[] = self::getFrameUrl($link->link()->getUri());
			});
		});
		return $urls;
	}
	public static function getFrameUrl($url='')
	{
		if(!$url)
			return [];
		$newUrl = $url;
		$client = new Client();
		$crawler = $client->request('GET',$url);
		$crawler->filter('frame')->each(function($frame,$i) use (&$newUrl) {
			if($i==0)
			{
				$explodedURL = explode('/', $newUrl);
				$explodedURL[count($explodedURL)-1] = $frame->attr('src');
				$newUrl = implode('/',$explodedURL);				
			}

		});
		return $newUrl;
	}
	public static function getEnds($url='')
	{
		if(!$url)
			return [];
		$ends = [];
		$client = new Client();
		$crawler = $client->request('GET', $url);
		$crawler->filter('a[target="R"]')->each(function($link,$j) use (&$ends){
			if($j==0)
				$ends[0] = $link->text();
		});
		$crawler->filter('.cellroute li')->each(function($link,$j) use (&$ends){
			$link->filter('b')->each(function($tag,$k) use (&$ends) {
				if($k==0)
				$ends[1] = $tag->text();
				
			});
		});
		return $ends;
	}
	public static function getExistedOrNew($name,$CityID)
	{
		$model = self::where('name','=',$name)->where('cityID','=',$CityID)->first();
		if($model)
		{
			echo "exist";
			return $model;
		}
		else 
		{
			$model = new self();
			$model->name = $name;
			$model->cityID = $CityID;
			$model->save(); 
			return  $model;
		}
	}

}
