<?php namespace App\Http\Controllers;

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
		$url = 'http://rozklady.mpk.krakow.pl/linie.aspx';
		$doc = new \DOMDocument();
		$xhtml = file_get_contents($url);
		$html = preg_replace("/<!DOCTYPE html(.+?)>/", '<!DOCTYPE html>', $xhtml);
		$html = str_replace("\r\n", "*^", $html);
		$html = preg_replace("/<HEAD>(.+?)<\/HEAD>/", '<HEAD></HEAD>', $html);
		$html = str_replace("*^", "\r\n", $html);
		// dd($html);
		libxml_use_internal_errors(true);
		$doc->loadHTML($html);
		// echo $doc->saveHTML();
		// $html = str_get_html($html);
		$tables = $doc->getElementsByTagName('table');
		$items = [];
		for($i = 0 ;$i< $tables->length;$i++)
		{
			if($tables->item($i)->getAttribute('width')=='80%')
				break;
			$items[$i]['header']  = trim($tables->item($i)->childNodes->item(0)->childNodes->item(0)->nodeValue);
			if(!empty( $tables->item($i)->childNodes->item(1)))
			{
				$item = $tables->item($i)->childNodes->item(1)->childNodes->item(0);
				$links = $item->childNodes;
				$items[$i]['item']  = [];
				for($j = 0;$j<$links->length;$j++)
				{
					if($links->item($j)->nodeName == "a")
					{
						$a['name'] = $links->item($j)->nodeValue;
						$a['src']	=  $links->item($j)->getAttribute('href');
						$items[$i]['item'][] = $a;
						
					}
				}
			}
		}
		dd($items);
		return view('index');
	}

}
