<?php

namespace Artibet\PhpUtils;

use InvalidArgumentException;

class Encodings
{
  public static function toUtf8(string $str): string
  {
    $validEncodings = ['ISO-8859-7', 'UTF-8'];

    // Detect encoding (ISO-8859-1, or UTF-8)
    $encoding = mb_detect_encoding($str, $validEncodings);
    print($encoding);

    // If already in UTF-8
    if ($encoding === 'UTF-8') return $str;

    // Convert to UTF-8
    return mb_convert_encoding($str, "UTF-8", "ISO-8859-7");
  }
}
