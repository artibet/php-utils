<?php

namespace Artibet\PhpUtils\Tests\Unit;

use Artibet\PhpUtils\Encodings;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class EncodingsTest extends TestCase
{

  // ---------------------------------------------------------------------------------------
  // Encodings::toUtf8()
  // ---------------------------------------------------------------------------------------

  /** @test */
  public function toUtf8_with_utf8_string()
  {
    $utfStr = mb_convert_encoding("Ένα Αλφαριθμητικό σε UTF-9", 'UTF-8');

    $this->assertSame("Ένα Αλφαριθμητικό σε UTF-9", Encodings::toUtf8($utfStr));
  }

  /** @test */
  public function toUtf8_with_iso8859_7_string()
  {
    $utfStr = mb_convert_encoding("Ένα Αλφαριθμητικό σε ISO-8859-7", 'ISO-8859-7');

    $this->assertSame(mb_convert_encoding("Ένα Αλφαριθμητικό σε ISO-8859-7", 'UTF-8'), Encodings::toUtf8($utfStr));
  }
}
