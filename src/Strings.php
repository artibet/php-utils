<?php

namespace Artibet\PhpUtils;

/*
    Strings formating and stuff...
*/

class Strings
{
  /**
   * Convert string to uppercase 
   * Remove accents
   */
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
}
