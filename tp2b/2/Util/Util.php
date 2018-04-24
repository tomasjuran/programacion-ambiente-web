<?php

/**
* 
*/
class Util
{
	
	public static function format_date_dd_mm_Y($date)
	{
	    return date('d/m/Y', strtotime($date));
	}

	public static function format_date_Y_mm_dd($date)
	{
	    return date('Y-m-d', strtotime($date));
	}

}