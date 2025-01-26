<?php

namespace Artibet\PhpUtils;

/*
	Table formating class
*/

class Tables
{
  // ---------------------------------------------------------------------------------------
  // Table row to split pages
  // $tds is an array of table cells:
  // $tds = [
  // 		'text' => '.....'
  //		'style' => '....'
  // ]
  // ---------------------------------------------------------------------------------------
  public static function tableRow($tds)
  {
    // The row to be built
    $row = '';

    // Split td data into rows
    $lines = [];
    foreach ($tds as $td) {
      $lines[] = explode("\n", str_replace("\t", " ", $td['text']));
    }

    // Μέγιστο πλήθος γραμμών
    $maxLines = 0;
    for ($i = 0; $i < count($lines); $i++) {
      $c = count($lines[$i]);
      if ($c > $maxLines) $maxLines = $c;
    }

    // Δημιουργία tr για κάθε γραμμή
    for ($i = 0; $i < $maxLines; $i++) {

      // Μία μοναδική γραμμή
      if ($i == 0 && $maxLines == 1) {
        $row = "<tr>";
        for ($k = 0; $k < count($tds); $k++) {
          $style = array_key_exists('style', $tds[$k]) ? $tds[$k]['style'] : '';
          if (count($lines[$k]) > 0) {
            $row .= "<td style='border: 1px solid black; $style'>" . $lines[$k][0] . "</td>";
          } else {
            $row .= "<td style='border: 1px solid black; $style'></td>";
          }
        }
        $row .= "</tr>";
      }

      // Πρώτη γραμμή - υπάρχουν και άλλες
      else if ($i == 0 && $maxLines > 1) {
        $row = "<tr>";
        for ($k = 0; $k < count($tds); $k++) {
          $style = array_key_exists('style', $tds[$k]) ? $tds[$k]['style'] : '';
          if (count($lines[$k]) > 0) {
            $row .= "<td style='border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; $style'>" . $lines[$k][0] . "</td>";
          } else {
            $row .= "<td style='border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; $style'></td>";
          }
        }
        $row .= "</tr>";
      }

      // Υπόλοιπες γραμμές εκτός από την τελευταία
      else if ($i > 0 && $i < $maxLines - 1) {
        $row .= "<tr>";
        for ($k = 0; $k < count($tds); $k++) {
          $style = array_key_exists('style', $tds[$k]) ? $tds[$k]['style'] : '';
          if (count($lines[$k]) >= $i + 1) {
            $row .= "<td style='border-left: 1px solid black; border-right: 1px solid black; $style'>" . $lines[$k][$i] . "</td>";
          } else {
            $row .= "<td style='border-left: 1px solid black; border-right: 1px solid black; $style'></td>";
          }
        }
        $row .= "</tr>";
      }

      // Η τελευταία γραμμή
      else if ($i == $maxLines - 1) {
        $row .= "<tr>";
        for ($k = 0; $k < count($tds); $k++) {
          $style = array_key_exists('style', $tds[$k]) ? $tds[$k]['style'] : '';
          if (count($lines[$k]) == $maxLines) {
            $row .= "<td style='border-left: 1px solid black; border-bottom: 1px solid black; border-right: 1px solid black; $style'>" . $lines[$k][$maxLines - 1] . "</td>";
          } else {
            $row .= "<td style='border-left: 1px solid black; border-bottom: 1px solid black; border-right: 1px solid black; $style'></td>";
          }
        }
        $row .= "</tr>";
      }
    }

    // Επιστροφή της γραμμής
    return $row;
  }
}
