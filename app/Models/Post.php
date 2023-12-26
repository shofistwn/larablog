<?php

namespace App\Models;

use App\Helpers\FileHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
    ];

    protected $dates = ['deleted_at'];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d M, Y');
    }

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
        } catch (\Exception $e) {
            throw new \Exception("Failed to update thumbnail", 500);
        }
    }

    public static function deleteThumbnail($thumbnail)
    {
        try {
            if ($thumbnail) {
                Storage::delete('public/posts/' . $thumbnail);
            }
        } catch (\Exception $e) {
            throw new \Exception("Failed to delete thumbnail", 500);
        }
    }
}
