<?php

namespace Artibet\PhpUtils;

use Carbon\Carbon;

/*
    Date fromating and stuff ...
*/

class Dates
{
  /**
   * Format date (iso string) to dd/mm/yyyy
   */
  public static function formatDate(string $isoString): string
  {
    if (!$isoString) return '';
    return (new Carbon($isoString))->setTimeZone('Europe/Athens')->format('d/m/Y');
  }

  /**
   * Format data (iso string) to hh:mm
   */
  public static function formatTime(string $isoString): string
  {
    if (!$isoString) return '';
    return (new Carbon($isoString))->setTimeZone('Europe/Athens')->format('H:i');
  }

  /**
   * Format date (iso string) to dd/mm/yyyy, hh:mm
   */
  public static function formatDateTime(string $isoString): string
  {
    if (!$isoString) return '';
    return (new Carbon($isoString))->setTimeZone('Europe/Athens')->format('d/m/Y, H:i');
  }


  /**
   * Return a translation of week day in greek
   */
  public static function getDay(Carbon $carbonDate, bool $upperCase = false): string
  {
    if (!$carbonDate) return '';
    $dayOfWeek = $carbonDate->dayOfWeek;
    if ($dayOfWeek === 0) return $upperCase ? 'ΚΥΡΙΑΚΗ' : 'Κυριακή';
    if ($dayOfWeek === 1) return $upperCase ? 'ΔΕΥΤΕΡΑ' : 'Δευτέρα';
    if ($dayOfWeek === 2) return $upperCase ? 'ΤΡΙΤΗ' : 'Τρίτη';
    if ($dayOfWeek === 3) return $upperCase ? 'ΤΕΤΑΡΤΗ' : 'Τετάρτη';
    if ($dayOfWeek === 4) return $upperCase ? 'ΠΕΜΠΤΗ' : 'Πέμπτη';
    if ($dayOfWeek === 5) return $upperCase ? 'ΠΑΡΑΣΚΕΥΗ' : 'Παρασκευή';
    if ($dayOfWeek === 6) return $upperCase ? 'ΣΑΒΒΑΤΟ' : 'Σάββατο';
    return "";
  }

  /**
   * format protokollo from aa and date
   * $prot_date should be carbon
   */
  public static function formatProtokollo($prot_aa, $prot_date)
  {
    // $prot_date should be carbon
    if (!$prot_date) return '';
    return $prot_aa . "/" . $prot_date->day . "-" . $prot_date->month . "-" . $prot_date->year;
  }
}
