<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\Departure;
use App\Line;
use App\City;
use App\Stop;

class ImportLines extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'import:lines';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Importing lines.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		Departure::truncate();
		Line::truncate();
		Stop::truncate();
		$cities = City::all();
		foreach ($cities as $city) {
			$this->info('importing city: '.$city->name);
			$lines = Line::import($city);
			foreach($lines as $line)
			{
				$this->info('importing line: '.$line->name);
				$stops = Stop::fullImport($line);
			}
		}
	}
}
