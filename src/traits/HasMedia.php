<?php

namespace Artibet\PhpUtils\Laravel;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

/**
 * Models with media files
 */
trait HasMedia
{
  /**
   * Path to media directory.
   * Should be set into Model that uses the trait
   * Defaults to /storage/app/public directory
   */
  protected $mediaPath = '/storage/app/public';

  /**
   * Store uploaded file and return the basename.
   */
  public function storeMedia(UploadedFile $media)
  {
    // Get original file extension
    $originalExtension = $media->getClientOriginalExtension();

    // Store to the filesystem
    // 
  }
}
