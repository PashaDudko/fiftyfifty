<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getLogoImgAttribute(): string
    {
        if (!$this->logo) {
            return asset('storage/shops/default.jpeg');
        }

        return Storage::disk('public')->url($this->logo);
    }
}
