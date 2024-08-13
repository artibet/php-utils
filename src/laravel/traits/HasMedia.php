<?php

namespace Artibet\PhpUtils\Laravel\Traits;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Models with media files
 */
trait HasMedia
{

  /**
   * if true default storate dir is storage/app/public
   * else storage/app
   */
  protected $isMediaPublic = true;

  /**
   * Media directory inside storage/app/[public]
   */
  protected function getMediaDir(): string
  {
    return '';
  }

  /**
   * calculate the local path based on public flag and mediaDir
   */
  private function localMediaPath(): string
  {
    if ($this->isMediaPublic) {
      return 'public' . $this->getMediaDir();
    } else {
      return $this->getMediaDir();
    }
  }

  /**
   * Store uploaded file and return the basename.
   * @param  Illuminate\Http\UploadedFile  $media
   * @return string
   */
  public function storeMedia(UploadedFile $media): string
  {
    // Get original file extension
    $originalExtension = $media->getClientOriginalExtension();

    // Store to the filesystem
    // store() starts from storage/app
    $fqp = $media->store($this->localMediaPath());   // storage/app/public/{mediaDir} or storage/app/{mediaDir}

    // If stored extension differs from original
    // add original extension
    $ext = pathinfo($fqp, PATHINFO_EXTENSION);
    $finalFqp = $fqp;
    if ($ext != $originalExtension) {
      $finalFqp = $fqp . ".$originalExtension";
      Storage::move($fqp, $finalFqp);
    }

    // Return stored basename
    return basename($finalFqp);
  }


  /**
   * Return file size in KB in formated string
   * @param string $basename
   */
  public function mediaSize(?string $basename): string
  {
    if ($basename) {
      $path = $this->localMediaPath() .  '/' . $basename;
      $bytes = Storage::size($path);
      $kbytes = $bytes / 1000;
      return number_format($kbytes, 1, ',', '.') . ' kB';
    } else {
      return '';
    }
  }

  /**
   * Returns media extension
   * @param string $basename
   * @return string 
   */
  public function mediaExtension(?string $basename): string
  {
    if ($basename) {
      $path = $this->localMediaPath() .  '/' . $basename;
      return pathinfo($path)['extension'];
    } else {
      return '';
    }
  }

  /**
   * Return the media url if isMediaPublic == true
   * @param string $basename
   * @return string
   * @throws Exception
   */
  public function mediaUrl(?string $basename, bool $full = false): string
  {
    if (!$this->isMediaPublic) throw new Exception('Access denied!');
    if ($basename) {
      $path = '/storage' . $this->getMediaDir() . '/' . $basename;
      return $full ? url($path) : $path;
    } else {
      return '';
    }
  }

  /**
   * Return the local media path
   * It is relative to /storage/app
   * @param string $basename
   * @return string
   */
  public function mediaPath(?string $basename): string
  {
    if ($basename) {
      return $this->localMediaPath() . '/' . $basename;
    } else {
      return '';
    }
  }


  /**
   * Delete media file.
   * If $deleteEmptyDir is true and media's dir is empty delete dir as well
   * @param string $basename
   * @param boolean $deleteEmptyDir=false
   */
  public function deleteMedia(?string $basename, bool $deleteEmptyDir = false): bool
  {
    if (!$basename) return false;

    $flag = false;  // success indicator

    $filename = $this->localMediaPath() . '/' . $basename;
    if (!empty($basename) && Storage::exists($filename)) {
      $flag = Storage::delete($filename);
    }

    if ($deleteEmptyDir && empty(Storage::files($this->localMediaPath()))) {
      Storage::deleteDirectory($this->localMediaPath());
    }

    return $flag;
  }
}
