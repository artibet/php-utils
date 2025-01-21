<?php

namespace Artibet\PhpUtils;

/*
	Strings formating and stuff...
*/

class Strings
{
	// ---------------------------------------------------------------------------------------
	// Convert string to uppercase 
	// Remove accents
	// ---------------------------------------------------------------------------------------
	public static function toUpper(string $str)
	{
		$converted =  mb_strtoupper($str);

		// Αφαίρεση τόνων
		$converted = str_replace('Ά', 'Α', $converted);
		$converted = str_replace('Έ', 'Ε', $converted);
		$converted = str_replace('Ό', 'Ο', $converted);
		$converted = str_replace('Ί', 'Ι', $converted);
		$converted = str_replace('Ύ', 'Υ', $converted);
		$converted = str_replace('Ή', 'Η', $converted);
		$converted = str_replace('Ώ', 'Ω', $converted);

		return $converted;
	}

	// ---------------------------------------------------------------------------------------
	// Αφαίρεση τόνων
	// ---------------------------------------------------------------------------------------
	public static function stripAccents($str)
	{
		$search = ['ά', 'έ', 'ό', 'ύ', 'ή', 'ώ', 'ί', 'Ά', 'Έ', 'Ό', 'Ύ', 'Ή', 'Ώ', 'Ί'];
		$replace = ['α', 'ε', 'ο', 'υ', 'η', 'ω', 'ι', 'Α', 'Ε', 'Ο', 'Υ', 'Η', 'Ω', 'Ι'];
		return str_replace($search, $replace, $str);
	}

	// ---------------------------------------------------------------------------------------
	// Κλιτική προσφόνηση
	// ---------------------------------------------------------------------------------------
	public static function klitiki($str)
	{
		// Ενδέχετε να υπάρχουν πολλά ονόματα - κλητική για το καθένα
		$names = explode(' ', trim($str));
		$result = '';
		$exceptions = ['ΣΤΕΡΓΙΟΣ', 'ΣΤΕΛΙΟΣ', 'ΧΡΗΣΤΟΣ', 'ΠΕΤΡΟΣ', 'ΜΙΛΤΟΣ'];
		foreach ($names as $name) {
			if (in_array($name, $exceptions)) {
				$result = $result . " " . mb_substr($name, 0, -1);
			} else if (str_ends_with($name, 'ΟΣ')) {
				$result = $result . " " . mb_substr($name, 0, -2) . 'Ε';
			} else if (str_ends_with($name, 'Σ')) {
				$result = $result . " " . mb_substr($name, 0, -1);
			} else {
				$result = $result . " " . $name;
			}
		}
		return trim($result);
	}

	// ---------------------------------------------------------------------------------------
	// Αιτιατική
	// Αν τελειώνει σε 'Σ' το αφαιρούμε
	// ---------------------------------------------------------------------------------------
	public static function aitiatiki($str)
	{
		$names = explode(' ', trim($str));
		$result = '';
		foreach ($names as $name) {
			if (str_ends_with($name, 'Σ') || str_ends_with($name, 'ς')) {
				$result = $result . " " . mb_substr($name, 0, -1);
			} else {
				$result = $result . ' ' . $name;
			}
		}

		return trim($result);
	}

	// ---------------------------------------------------------------------------------------
	// Placeholder or value
	// ---------------------------------------------------------------------------------------
	public static function placeholder($data, $chars = '-', $repeat = 5)
	{
		if ($data) return $data;
		else return str_repeat($chars, $repeat);
	}
}
