<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Exception;

class FileHelper
{
  public static function uploadThumbnail(array &$data, $post = null)
  {
    try {
      if (isset($data['thumbnail']) && $data['thumbnail'] instanceof UploadedFile) {
        $image = $data['thumbnail'];
        $imageName = $image->hashName();
        $image->storeAs('public/posts', $imageName);
        $data['thumbnail'] = $imageName;

        if ($post && $post->thumbnail) {
          self::deleteThumbnail($post->thumbnail);
        }
      } elseif ($post && empty($data['thumbnail'])) {
        $data['thumbnail'] = $post->thumbnail;
      }
    } catch (Exception $e) {
      throw new Exception($e->getMessage(), 500, $e);
    }
  }

  public static function deleteThumbnail($thumbnail)
  {
    try {
      if ($thumbnail) {
        Storage::delete('public/posts/' . $thumbnail);
      }
    } catch (Exception $e) {
      throw new Exception($e->getMessage(), 500, $e);
    }
  }
}
