<?php

namespace Artibet\PhpUtils;

/**
 * Class Euro2Text.
 *
 * Translates an amount in EUR to Greek text. Only the main sayEuro() method
 * is public. Every other method is set to protected in order to allow
 * developers to extend this class for their own purposes.
 *
 * Original Credit for the Greek version goes to Uberalles_gr
 * @see http://www.insomnia.gr/topic/482555-μετατροπή-αριθμού-σε-λέξεις/?p=52289896
 *
 * If you are looking for the same functionality in English, you might look at
 * the following URLs:
 * @see http://www.jaygilford.com/php/number-to-text-converting-php-class/
 * @see http://bloople.net/num2text/cnumlib.txt
 */
class Olografos
{

  /**
   * Returns a word representation of a number in Greek.
   *
   * @param int|float $curAmount
   *   The number to represent in Greek.
   *
   * @return string
   *   The word representation of the number.
   */
  public static function sayEuro($curAmount)
  {
    $bFemale = FALSE;
    if ($curAmount > 999999.99 || $curAmount < -999999.99) {
      return 'Αδύνατη η μετατροπή αριθμού σε ολογράφως';
    }
    $sResult = '';
    if ($curAmount < 0) {
      $sResult = 'Μείον ';
      $curAmount = abs($curAmount);
    }
    $sResult .= self::sayNumber((int) $curAmount, $bFemale) . 'Ευρώ';
    if ($curAmount - (int) $curAmount > 0) {
      $sResult .= ' και ' . self::sayNumber(100 * ($curAmount - (int) $curAmount), $bFemale) . 'Λεπτά';
    }
    return $sResult;
  }

  /**
   * Private function to turn a single number to a single word representation.
   *
   * @param int|float $curAmount
   *   The amount to translate.
   * @param bool $bFemale
   *   Set to TRUE to match the female equivalent name.
   *
   * @return string
   *   The word representation.
   */
  protected static function sayNumber($curAmount, &$bFemale)
  {
    $sResult = '';
    $lAmount = round($curAmount, 0);

    // Uniques & decimals.
    $tmp = intval(substr($lAmount, -2));
    if ($lAmount == 0) {
      $sResult = 'Μηδέν ';
    } elseif ($tmp < 20) {
      if ($sResult) $sResult .= ' ';
      if ($bFemale) {
        $sResult .= self::sayUniqueFemale($tmp) . ' ';
      } else {
        $sResult .= self::sayUnique($tmp) . ' ';
      }
      // $sResult .= ($sResult == '') ? '' : ' ' . ($bFemale) ? self::sayUniqueFemale($tmp) : self::sayUnique($tmp) . ' ';
    } else {
      $sResult .= self::sayTens($tmp) . ' ';
      if (intval(substr(strval($tmp), -1)) > 0) {
        $tmptmp = substr(strval($tmp), 1);
        $sResult .= ($bFemale) ? self::sayUniqueFemale($tmptmp) : self::sayUnique($tmptmp) . ' ';
      }
    }

    $lAmount -= $tmp;

    // Hundreds.
    $tmp = substr($lAmount, -3);
    if ($tmp > 100 || ($tmp == 100 && $sResult != '')) {
      $sResult = (($bFemale) ? self::SayHundredsFemale($tmp) : self::sayHundreds($tmp)) . ' ' . $sResult;
    } elseif ($tmp == 100 && $sResult == '') {
      $sResult = 'Εκατό';
    }
    $lAmount -= $tmp;

    // Thousands.
    if ($lAmount >= 1000) {
      $sResult = self::SayThousands($lAmount, $bFemale) . ' ' . $sResult;
    }
    $bFemale = FALSE;
    return $sResult;
  }

  /**
   * Turns numbers from 1 to 19 to their word equivalents.
   *
   * @param int|float $iNumber
   *   The number to translate.
   *
   * @return string|null
   *   The word representation or NULL if the number is greater.
   */
  protected static function sayUnique($iNumber)
  {
    $vardigit = array(
      'Ένα',
      'Δύο',
      'Τρία',
      'Τέσσερα',
      'Πέντε',
      'Έξι',
      'Επτά',
      'Οκτώ',
      'Εννέα',
      'Δέκα',
      'Ένδεκα',
      'Δώδεκα',
      'Δεκατρία',
      'Δεκατέσσερα',
      'Δεκαπέντε',
      'Δεκαέξι',
      'Δεκαεφτά',
      'Δεκαοχτώ',
      'Δεκαεννιά',
    );
    if ($iNumber > 0) {
      return $vardigit[$iNumber - 1];
    }
  }

  /**
   * Turns 10,20,30,40,50,60,70,80,90 to their word equivalents.
   *
   * @param int|float $iNumber
   *   The number to translate.
   *
   * @return string|null
   *   The word representation or NULL if the number doesn't exist.
   */
  protected static function sayTens($iNumber)
  {
    $vardigit = array(
      'Δέκα',
      'Είκοσι',
      'Τριάντα',
      'Σαράντα',
      'Πενήντα',
      'Εξήντα',
      'Εβδομήντα',
      'Ογδόντα',
      'Ενενήντα',
    );
    return $vardigit[$iNumber / 10 - 1];
  }

  /**
   * Turns 100,200,300,400,500,600,700,800,900 to their word equivalents.
   *
   * @param int|float $iNumber
   *   The number to translate.
   *
   * @return string|null
   *   The word representation or NULL if the number doesn't exist.
   */
  protected static function sayHundreds($iNumber)
  {
    $vardigit = array(
      'Εκατόv',
      'Διακόσια',
      'Τριακόσια',
      'Τετρακόσια',
      'Πεντακόσια',
      'Εξακόσια',
      'Επτακόσια',
      'Οκτακόσια',
      'Εννιακόσια',
    );
    return $vardigit[$iNumber / 100 - 1];
  }

  /**
   * Turns numbers 1000,2000,3000,4000,... to their word equivalents.
   *
   * @param int|float $iNumber
   *   The number to translate.
   * @param bool $bFemale
   *   Set to TRUE to return the equivalent female word. FALSE otherwise.
   *
   * @return string|null
   *   The word representation or NULL if the number doesn't exist.
   */
  protected static function sayThousands($iNumber, &$bFemale)
  {
    $bFemale = TRUE;
    return ($iNumber == 1000) ? 'Χίλια' : (self::sayNumber($iNumber / 1000, $bFemale) . ' Χιλιάδες');
  }

  /**
   * Turns numbers 1000,2000,3000,4000,... to their female word equivalents.
   *
   * @param int|float $iNumber
   *   The number to translate.
   *
   * @return string|null
   *   The word representation or NULL if the number doesn't exist.
   */
  protected static function sayUniqueFemale($iNumber)
  {
    $vardigit = array(
      'Μια',
      'Δύο',
      'Τρεις',
      'Τέσσερις',
      'Πέντε',
      'Έξι',
      'Επτά',
      'Οκτώ',
      'Εννέα',
      'Δέκα',
      'Ένδεκα',
      'Δώδεκα',
      'Δεκατρείς',
      'Δεκατέσσερεις',
      'Δεκαπέντε',
      'Δεκαέξι',
      'Δεκαεφτά',
      'Δεκαοχτώ',
      'Δεκαεννιά',
    );
    if ($iNumber > 0) {
      return $vardigit[$iNumber - 1];
    }
  }

  /**
   * Turns 100,200,300,400,500,600,700,800,900 to their female word equivalents.
   *
   * @param int|float $iNumber
   *   The number to translate.
   *
   * @return string|null
   *   The word representation or NULL if the number doesn't exist.
   */
  protected static function sayHundredsFemale($iNumber)
  {
    $vardigit = array(
      'Εκατόv',
      'Διακόσιες',
      'Τριακόσιες',
      'Τετρακόσιες',
      'Πεντακόσιες',
      'Εξακόσιες',
      'Επτακόσιες',
      'Οκτακόσιες',
      'Εννιακόσιες',
    );
    return $vardigit[$iNumber / 100 - 1];
  }
}
