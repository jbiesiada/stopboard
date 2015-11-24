<?php namespace App;

/**
* 
*/
class SelectedTime
{
	protected $time;
	function __construct($time)
	{
		$this->time = $time;
	}
	public function dayType()
	{
		return max(date('w',$this->time)-5,0);		
	}
	public function hour()
	{
		return (int) date('H',$this->time);
	}
	public function minute()
	{
		return (int) date('i',$this->time);
			
	}
	public function mixedTime()
	{
		return 60*$this->hour()+$this->minute();			
	}
	public function when($mixedTime)
	{
		return $mixedTime - $this->mixedTime();
	}
}