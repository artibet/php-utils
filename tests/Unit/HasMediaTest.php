<?php

namespace Artibet\PhpUtils\Tests\Unit;

use Artibet\PhpUtils\Laravel\Traits\HasMedia;
use Exception;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Http\UploadedFile;
use Orchestra\Testbench\Concerns\CreatesApplication;

class HasMediaTest extends TestCase
{
  use CreatesApplication;
  use HasMedia;

  /** @test */
  public function assert_default_media_scope_is_public()
  {
    $this->assertEquals(true, $this->isMediaPublic);
  }

  /** @test */
  public function assert_default_mediaDir_is_empty()
  {
    return $this->assertSame('', $this->mediaDir);
  }

  /** @test */
  public function assert_local_path_and_url()
  {
    $this->setMediaDir('/applications');
    $this->assertSame('public/applications', $this->localMediaPath());
    $this->assertSame('/storage/applications/test.php', $this->mediaUrl('test.php'));
  }

  /** @test */
  public function raise_exception_on_empty_basename()
  {
    $this->expectException(Exception::class);
    $this->mediaUrl('');
  }

  /** @test */
  public function raise_exception_on_private_media()
  {
    $this->isMediaPublic = false;
    $this->expectException(Exception::class);
    $this->mediaUrl('/test.php');
    $this->isMediaPublic = true;
  }
}
