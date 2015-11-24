<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model {
	protected $table = 'cities';
	protected $primaryKey = 'cityID';
	

	public function lines()
	{
		return $this->hasMany('App\Line', 'cityID','cityID')->orderBy('name');
	}
	public function stops()
	{
		return $this->hasMany('App\Stop', 'cityID','cityID')->orderBy('name');
	}

}
