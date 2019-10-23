<?php
namespace Camagru\Lib;

class Helper
{
	public static function get_class_name($classname) {
		if ($pos = strrpos($classname, '\\'))
			return (substr($classname, $pos + 1));
		return ($pos);
	}

	public static function array_key_last($array) {
        if (!is_array($array) || empty($array)) {
            return (NULL);
        }
        return (array_keys($array)[count($array) - 1]);
	}

	public static function time_elapsed_string($datetime, $full = false) {
		$now = new \DateTime;
		$ago = new \DateTime($datetime);
		$diff = $now->diff($ago);
	
		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;
	
		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
		);
		foreach ($string as $k => &$v) {
			if ($diff->$k)
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			else
				unset($string[$k]);
		}
	
		if (!$full)
			$string = array_slice($string, 0, 1);
		return ($string ? implode(', ', $string) . ' ago' : 'just now');
	}
}
