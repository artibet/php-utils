<?php

namespace Artibet\PhpUtils\Tests\Unit;

use Artibet\PhpUtils\Dates;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use DateTime;
use DateTimeZone;
use PHPUnit\Framework\TestCase;

class DatesTest extends TestCase
{
  // ---------------------------------------------------------------------------------------
  // Dates::formatDate()
  // ---------------------------------------------------------------------------------------

  /** @test */
  public function formatDate_with_not_valid_iso_string()
  {
    $isoString = 'not valid iso string';
    $this->expectException(InvalidFormatException::class);
    Dates::formatDate($isoString);
  }

  /** @test */
  public function formatDate_with_valid_iso_string()
  {
    $d = new DateTime();
    $d->setDate(2023, 12, 3);
    $isoString = ($d)->format(DateTime::ATOM);

    $this->assertSame('03/12/2023', Dates::formatDate($isoString));
  }

  // ---------------------------------------------------------------------------------------
  // Dates::formatTime()
  // ---------------------------------------------------------------------------------------

  /** @test */
  public function formatTime_with_not_valid_iso_string()
  {
    $isoString = 'not valid iso string';
    $this->expectException(InvalidFormatException::class);
    Dates::formatTime($isoString);
  }

  /** @test */
  public function formatTime_with_valid_iso_string()
  {
    $d = new DateTime();
    $d->setTimezone(new DateTimeZone('Europe/Athens'));
    $d->setTime(8, 9);
    $isoString = ($d)->format(DateTime::ATOM);

    $this->assertSame('08:09', Dates::formatTime($isoString));
  }

  // ---------------------------------------------------------------------------------------
  // Dates::formatDateTime()
  // ---------------------------------------------------------------------------------------

  /** @test */
  public function formatDateTime_with_not_valid_iso_string()
  {
    $isoString = 'not valid iso string';
    $this->expectException(InvalidFormatException::class);
    Dates::formatDateTime($isoString);
  }

  /** @test */
  public function formatDateTime_with_valid_iso_string()
  {
    $d = new DateTime();
    $d->setTimezone(new DateTimeZone('Europe/Athens'));
    $d->setDate(2023, 8, 2);
    $d->setTime(8, 9);
    $isoString = ($d)->format(DateTime::ATOM);

    $this->assertSame('02/08/2023, 08:09', Dates::formatDateTime($isoString));
  }

  // ---------------------------------------------------------------------------------------
  // Dates::getDay()
  // ---------------------------------------------------------------------------------------

  /** @test */
  public function getDay_check_lower_cases()
  {
    $d = Carbon::create(2024, 1, 6, 0, 0, 0, 'Europe/Athens');

    $this->assertSame('Σάββατο', Dates::getDay($d));
    $this->assertSame('Κυριακή', Dates::getDay($d->addDay()));
    $this->assertSame('Δευτέρα', Dates::getDay($d->addDay()));
    $this->assertSame('Τρίτη', Dates::getDay($d->addDay()));
    $this->assertSame('Τετάρτη', Dates::getDay($d->addDay()));
    $this->assertSame('Πέμπτη', Dates::getDay($d->addDay()));
    $this->assertSame('Παρασκευή', Dates::getDay($d->addDay()));
  }

  /** @test */
  public function getDay_check_upper_cases()
  {
    $d = Carbon::create(2024, 1, 6, 0, 0, 0, 'Europe/Athens');

    $this->assertSame('ΣΑΒΒΑΤΟ', Dates::getDay($d, true));
    $this->assertSame('ΚΥΡΙΑΚΗ', Dates::getDay($d->addDay(), true));
    $this->assertSame('ΔΕΥΤΕΡΑ', Dates::getDay($d->addDay(), true));
    $this->assertSame('ΤΡΙΤΗ', Dates::getDay($d->addDay(), true));
    $this->assertSame('ΤΕΤΑΡΤΗ', Dates::getDay($d->addDay(), true));
    $this->assertSame('ΠΕΜΠΤΗ', Dates::getDay($d->addDay(), true));
    $this->assertSame('ΠΑΡΑΣΚΕΥΗ', Dates::getDay($d->addDay(), true));
  }
}
