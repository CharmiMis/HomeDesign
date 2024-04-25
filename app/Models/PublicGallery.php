<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicGallery extends Model
{
    use HasFactory;

    public $fillable = [
        'original_image',
        'generated_image',
        'style',
        'is_active',
        'firebase_id',
        'room_type',
        'user_uid',
        'is_public',
        'mode',
        'is_inpainting',
        'is_favorite',
        'design_type',
        'prompt',
        'hd_image'
    ];

    public function scopePrivate(Builder $query)
    {
        $query->where('is_public', 0);
    }

    public function scopePublic(Builder $query)
    {
        $query->where('is_public', 1);
    }
}
